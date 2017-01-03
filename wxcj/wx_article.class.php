<?php
class Wx_article {
	private $url;
	private $path;
	private function ksort($arr) {
		foreach ( $arr as $value ) {
			$temp [] = $value;
		}
		return $temp;
	}
	public function __construct($url, $path) {
		$this->url = $url;
		$this->path = $path;
		// 设置脚本执行不超时
		set_time_limit ( 0 );
	}

	//按链接获取文章
	public function fetch() {
		return $this->transform ( $this->url, $this->path );
	}

	//获取图片
	private function createPic($url, $path, $name) {
		$img = file_get_contents ( $url );
		$info = getimagesize ( $url );
		$type = str_replace ( 'image/', '', $info ['mime'] );
		$fileName = $path . DIRECTORY_SEPARATOR . $name . ".$type";
		file_put_contents ( $fileName, $img );
		return $fileName;
	}

	//获取并保存
	private function transform($url, $path) {
		if (! file_exists ( $path ))
			mkdir ( $path );
		$data ['url'] = $url; // 文章URL
		$content = file_get_contents ( $url );
		preg_match ( '/<title>(.*)<\/title>/i', $content, $result );
		$data ['title'] = $result [1]; // 文章标题
		preg_match ( '/var\s+msg_cdn_url\s*=\s*"([^\s]*)"/', $content, $result );
		//$data ['cover'] = $result [1];
		$data ['cover'] = $this->createPic ( $result [1], $path, "cover" );  // 封面
		preg_match ( '/var\s+nickname\s*=\s*"([^\s]*)"/', $content, $result );
		$data ['nickname'] = $result [1]; // 公众号昵称
		preg_match ( '/var\s+ct\s*=\s*"([^\s]*)"/', $content, $result );
		$data ['ct'] = $result [1]; // 公众号发布的时间戳
		preg_match ( '/var\s+user_name\s*=\s*"([^\s]*)"/', $content, $result );
		$data ['user_name'] = $result [1]; // 公众号的原始ID

		preg_match ( '/var\s+round_head_img\s*=\s*"([^\s]*)"/', $content, $result );
		$data ['round_head_img'] = $this->createPic ( $result [1], $path, "round_head_img_" . $data ['user_name'] ); // // 公众号头像
		//preg_match ( "/s?__biz=(.*)&mid=/i", $url, $result );
		//$data ['bizId'] = $result [1]; // 公众号BizId
		preg_match ( '/var\s+msg_desc\s*=\s*"([^\s]*)"/', $content, $result );
		$data ['msg_desc'] = $result [1]; // 公众号文章摘要
		                                  
		// 获取微信主体内容
		preg_match ( '/<div\s+class="rich_media_content\s*"\s+id="js_content">(.*?)<\/div>/is', $content, $result ); //注意非贪婪的?
		// 精细化筛选
		// preg_match_all ( '/data-src="([a-zA-z]+:\/\/[^\s]*mmbiz\/([^\s]*)\/\d+\?)[^\s]*=([^\s]*)"|data-src="([a-zA-z]+:\/\/[^\s]*mmbiz\/([^\s]*)\/\d+)"|background-image\s*:\s*url\s*\(\s*([a-zA-z]+:\/\/[^\s]*mmbiz\/([^\s]*)\/\d+)\s*\)|background-image\s*:\s*url\s*\(\s*([a-zA-z]+:\/\/[^\s]*mmbiz\/([^\s]*)\/\d+\?)[^\s]*=([^\s]*)\s*\)/is', $result [1], $result2 );
		// 获取微信主体中的防盗链图片(含css背景图片)内容
		preg_match_all ( '/data-src="[a-zA-z]+:\/\/[^\s]*[mmbiz|mmbiz_jpg]\/[^\s]*\/\d+\?[^\s]*=[^\s]*"|data-src="[a-zA-z]+:\/\/[^\s]*[mmbiz|mmbiz_jpg]\/[^\s]*\/\d+"|background-image\s*:\s*url\s*\(\s*[a-zA-z]+:\/\/[^\s]*mmbiz\/[^\s]*\/\d+|background-image\s*:\s*url\s*\(\s*[a-zA-z]+:\/\/[^\s]*mmbiz\/[^\s]*\/\d+\?[^\s]*=[^\s]*/is', $result [1], $result2 );
		// 判断微信主体中是否包含防盗链图片
		if (! empty ( $result2 [0] )) {
			foreach ( $result2 [0] as $value ) {
				// 取出防盗链地址中的data-src值后的http://url主体部分
				preg_match ( '/[a-zA-z]+:\/\/[^\s]*\/[mmbiz|mmbiz_jpg]\/([^\s\/]*)\/\d+\?[^\s"]*|[a-zA-z]+:\/\/[^\s]*[mmbiz|mmbiz_jpg]\/([^\s\/]*)\/\d+/', $value, $temp );
				$temp = array_filter ( $temp );
				$temp = $this->ksort ( $temp );
				$urlList [] = $temp [0];
				$nameList [] = $temp [1];
			}
			foreach ( $urlList as $value ) {
				$name = array_shift ( $nameList );
				$fileName = $this->createPic ( $value, $path, $name ); // 保存为本地图片
				$result [1] = str_replace ( $value, $fileName, $result [1] );
			}
		}
		// 更新所有data-src的地址
		$result [1] = str_replace ( "data-src", "src", $result [1] );
		// 返回处理后的微信主体内容。
		$data ['content'] = trim($result [1]);
		return $data;
	}


	
}


	$a= new Wx_article("https://mp.weixin.qq.com/s/wvGnYERCGKkVyvpM2acybg","aa");
	print_r($a->fetch());
