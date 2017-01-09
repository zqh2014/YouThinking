<?php
require('cos-php/include.php');
use qcloudcos\Cosapi;
Cosapi::setTimeout(180);
// 设置COS所在的区域，对应关系如下：
//     华南  -> gz
//     华中  -> sh
//     华北  -> tj
Cosapi::setRegion('gz');

class Wxcj_Lite {
	private $url;
	private $path;
	private $cos_obj;
	private $bucket_contents = 'article';
	private $dir = "http://article-1252171157.cosgz.myqcloud.com/article_contents/";

	private function ksort($arr) {
		foreach ( $arr as $value ) {
			$temp [] = $value;
		}
		return $temp;
	}
	public function __construct() {
		//$this->url = $url;
		//$this->path = $path;
		// 设置脚本执行不超时
		set_time_limit ( 0 );
	}

	//按链接获取文章
	public function fetch($url, $path) {
		$this->url = $url;
		$this->path = $path;
		return $this->transform ( $this->url, $this->path );
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

	//获取并保存--微信文章信息
	private function transform($url, $path) {
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

		file_put_contents ( $path."/data.json", json_encode($data) );
		
		$status = $this->upAllFile($path);

		return $status;
		
	}

	//获取lookmw.com文章内容信息
	public function get_lookmw_info($url,$path){

			if (! file_exists ( $path ))
			mkdir ( $path );

		//$data ['url'] = $url; // 文章URL
		$content = @file_get_contents ( $url );

		// $data ['title'] = ''; //标题
		// $data ['cover'] = '';	//封面
		// $data ['msg_desc'] = '';	//描述
		// $data['content'] = '';		//内容







	}



	//soso获取微信文章url，返回列表
	public function get_link_by_url($url){

		$content = @file_get_contents($url);
		$preg = '/\<li (.*?)\<\/li\>/s';
		preg_match_all($preg, $content, $match);

		$data = array();
		if(!empty($match[0])){
			foreach($match[0] as $key => $value){
				$preg = '/href="(.*?)\" target/s';
				preg_match_all($preg, $value, $match_url);
				if(empty($match_url[1][0]))  continue;
				$data[$key]['original_url'] = $match_url[1][0];

				$preg = '/target=\"_blank\">(.*?)<\/a><\/h3>/i';
				preg_match_all($preg, $value, $match_title);
				$data[$key]['title'] = $match_title[1][0];
			}
			return $data;
		}else{

			return false;
		}

		

	}

	//lookmw.com文章url，返回列表
	public function get_lookmw_url($url){

		$content = @file_get_contents($url);
		$content = iconv("GB2312","UTF-8//IGNORE",$content);
		$preg = '/\<ul class=\"picAtc pr\"\>(.*?)\<\/ul\>/s';

		preg_match_all($preg, $content, $match);
		if(empty($match[1][0])) return false;
		$preg = '/\<li>(.*?)\<\/li\>/s';
		preg_match_all($preg, $match[1][0], $match2);
		if(empty($match2[1])) return false;

		$data = array();
		if(!empty($match2[1])){
			foreach($match2[1] as $key => $value){
				
				//链接
				$preg ='/\<h3\>\<a href=\"(.*?)"/i';
				preg_match_all($preg, $value, $match_url);
				if(empty($match_url[1][0]))  continue;
				$data[$key]['original_url'] = "http://www.lookmw.cn".$match_url[1][0];

				//标题
				$preg = '/target=\"_blank\">(.*?)\<\/a\>/i';
				preg_match_all($preg, $value, $match_title);
				$data[$key]['title'] = strip_tags($match_title[1][0]);

				//列表图
				$preg = '/data-original=\'(.*?)\'/i';
				preg_match_all($preg, $value, $match_img);
				if(!empty($match_img[1][0]))
				$data[$key]['img_url'] = "http://www.lookmw.cn".$match_img[1][0];

			}

			return $data;
		}else{

			return false;
		}

		

	}


	//获取随机字符
	public function createRandomStr($length=4){
		$str = '0123456789';//36个字符
		$strlen = 10;
		while($length > $strlen){
		$str .= $str;
		$strlen += 10;
		}
		$str = str_shuffle($str);
		return substr($str,0,$length);
	} 

	/*创建和上传当前目录的图片到腾讯云
	* @Param $folder 目标文件夹 名称
	
	* @Return 
	*/
	private function upAllFile($folder){

		$folder_con = "/article_contents/".$folder;	
		$ret = Cosapi::statFolder($this->bucket_contents, $folder_con);	//文件夹是否存在		
		if($ret['code']!=0){	//不存在，则新建目录
			$ret = Cosapi::createFolder($this->bucket_contents, $folder_con);	//创建文件夹
			if($ret['code']!=0){

				return false;  //创建不成功
			}
		}
		$file_arr = $this->getFileList($folder);
		foreach($file_arr as $value){
			Cosapi::upload($this->bucket_contents, "./".$folder."/".$value, $folder_con."/".$value);	
		}
		
		return true;
	}


	//获取文件列表
	private function getFileList($dir) {
	    $fileArray[]=NULL;
	    if (false != ($handle = opendir ( $dir ))) {
	        $i=0;
	        while ( false !== ($file = readdir ( $handle )) ) {
	            //去掉"“.”、“..”以及带“.xxx”后缀的文件
	            if ($file != "." && $file != ".."&&strpos($file,".")) {
	                $fileArray[$i]=$file;
	                if($i==100){
	                    break;
	                }
	                $i++;
	            }
	        }
	        //关闭句柄
	        closedir ( $handle );
	    }
	    return $fileArray;
	}

	//删除该目录及所有文件
	public function delDirAndFile( $dirName ){
		if ( $handle = opendir( "$dirName" ) ) {
			while ( false !== ( $item = readdir( $handle ) ) ) {
				if ( $item != "." && $item != ".." ) {
					if ( is_dir( "$dirName/$item" ) ) {
						delDirAndFile( "$dirName/$item" );
					} else {
						unlink( "$dirName/$item" );
					}
				}
			}
			closedir( $handle );
			rmdir( $dirName );
		}
	}

	//删除云上面的文件夹
	public function delFolder( $folder ){

		$folder = "article_contents/".$folder."/";
		$list = Cosapi::listFolder($this->bucket_contents,$folder,100);

		foreach($list['data']['infos'] as $val){
		
			Cosapi::delFile($this->bucket_contents, $folder.$val['name']);
		}
		$ret = Cosapi::delFolder($this->bucket_contents, $folder);
		return $ret;
		
	}




}	//class end

