<?php


/*
	微信文章采集
	www.soso.com获取微信文章
*/
class weixin {
	
	private $dir = "http://article-1252171157.cosgz.myqcloud.com/article_contents/";
	public function __construct() {

	}


	/*
	 *  获取文章链接列表
	 *  @return array 链接列表 ['url','title']
	 */
	public function getList($url){

		$content = @file_get_contents($url);
		$preg = '/\<li (.*?)\<\/li\>/s';
		preg_match_all($preg, $content, $match);

		$data = array();
		if(!empty($match[0])){
			foreach($match[0] as $key => $value){
				$preg = '/href="(.*?)\" target/s';
				preg_match_all($preg, $value, $match_url);
				if(empty($match_url[1][0]))  continue;
				$data[$key]['url'] = $match_url[1][0];

				$preg = '/\">(.*?)<\/a><\/h3>/i';
				preg_match_all($preg, $value, $match_title);
				$data[$key]['title'] = $match_title[1][0];
			}
			return $data;
		}else{

			return false;
		}

		

	}


	/*
	 *  获取文章内容，生成json文件并反加文件地址用于上传到COS
	 *  @return string $path json路径
	 */
	public function getContents($url, $path) {
		if (! file_exists ( $path ))
			mkdir ( $path );

		//$data ['url'] = $url; // 文章URL
		$content = @file_get_contents ( $url );
		
		preg_match ( '/<title>(.*)<\/title>/i', $content, $result );
		if(empty($result [1])) return false;  //标题为必填 字段
		$data ['title'] = $result [1]; // 文章标题
		
		preg_match ( '/var\s+msg_cdn_url\s*=\s*"([^\s]*)"/', $content, $result );
		//$data ['cover'] = $result [1];
		if(!empty($result [1]))
		$data ['cover'] = $this->createPic ( $result [1], $path, "cover" );  // 封面
		
		// preg_match ( '/var\s+nickname\s*=\s*"([^\s]*)"/', $content, $result );
		// $data ['nickname'] = $result [1]; // 公众号昵称
		
		//preg_match ( '/var\s+ct\s*=\s*"([^\s]*)"/', $content, $result );
		
		//$data ['ct'] = $result [1]?$result [1]:0; // 公众号发布的时间戳
		
		// preg_match ( '/var\s+user_name\s*=\s*"([^\s]*)"/', $content, $result );
		// $data ['user_name'] = $result [1]; // 公众号的原始ID

		// preg_match ( '/var\s+round_head_img\s*=\s*"([^\s]*)"/', $content, $result );
		// $data ['round_head_img'] = $this->createPic ( $result [1], $path, "round_head_img_" . $data ['user_name'] ); // // 公众号头像
		
		//preg_match ( "/s?__biz=(.*)&mid=/i", $url, $result );
		//$data ['bizId'] = $result [1]; // 公众号BizId
		preg_match ( '/var\s+msg_desc\s*=\s*"([^\s]*)"/', $content, $result );

		if(!empty($result [1])){
			$data ['msg_desc'] = $result [1]; // 公众号文章摘要
		}
		                                  
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
		$data['content'] = trim($result [1]);
		if(empty($data['content'])) return false;	
		$data['content'] =  str_replace ( 'background-image: url("', 'background-image: url("'.$this->dir, $data['content'] );
		$data['content'] =  str_replace ( 'background-image: url(&quot;', 'background-image: url(&quot;'.$this->dir, $data['content'] );
		$data['content'] =  str_replace ( 'src="', 'src="'.$this->dir, $data['content'] );

		@file_put_contents ( $path."/data.json", json_encode($data) );

		return $path;
	}


	//获取图片
	private function createPic($url, $path, $name) {
		$img = @file_get_contents ( $url );
		$info = getimagesize ( $url );
		$type = str_replace ( 'image/', '', $info ['mime'] );
		$fileName = $path . "/" . $name . ".$type";
		file_put_contents ( $fileName, $img );
		return $fileName;
	}

private function ksort($arr) {
		foreach ( $arr as $value ) {
			$temp [] = $value;
		}
		return $temp;
	}
}	
