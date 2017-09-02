<?php

/*
	微信文章采集
	www.lookmw.cn获取微信文章
*/
class lookmw {
	
	public function __construct() {

	}


	/*
	 *  获取文章链接列表
	 *  @return array 链接列表 ['url','title']
	 */
	public function getList($url){

		$content = $this->get_content($url);
		//$content = iconv("GB2312","UTF-8//IGNORE",$content);
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
				$preg = '/">(.*?)\<\/a\>/i';
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


	/*
	 *  获取文章内容，生成json文件并反加文件地址用于上传到COS
	 *  @return string $path json路径
	 */
	public function getContents($url, $path,$img_url='') {
		if (! file_exists ( $path ))
			mkdir ( $path );
 
		//$data ['url'] = $url; // 文章URL
		$content = $this->get_content( $url );
		//$content = iconv("GB2312","UTF-8//IGNORE",$content);
		//$content = preg_replace("/<img[^>]*\/>/","",$content);
		

		$preg = '/\<h1(.*?)\<\/h1\>/s';
		preg_match_all($preg, $content, $match);
		if(empty($match[1])) return false;
		$data ['title'] = $match[1]; //标题 <h1>想你的夜，爱与痛在我心里纠缠</h1>
		

		$data ['cover'] = $img_url;	//封面
		if(!empty($img_url)){
			$this->createPic ( $img_url, $path, "cover" ); // 保存为本地图片
		}

		$preg = '/\<meta name=\"description\" content=\"(.*?)\" \/\>/is';
		preg_match_all($preg, $content, $match);
		$data ['msg_desc'] = $match[1];	//描述  

		$preg = '/\<article(.*?)\<\/article\>/si';
		preg_match_all($preg, $content, $match);
		$data['content'] = $match[1];		//内容
		// <ul class="diggts">
		$data['content']= preg_replace("/<img[^>]*\/>/","", $data['content']);
		$data['content']= preg_replace("/\<ul class=\"diggts\">(.*?)<\/ul\>/is","", $data['content']);
		$data['content']= preg_replace("/\<ul class=\"pagelist\">(.*?)<\/ul\>/is","", $data['content']);
		if(empty($data['content'])) return false;

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


	private function get_content($url){

		 $snoopy = new Snoopy;
		 $snoopy->fetch($url); //获取所有内容
		 return $snoopy->results;

	}

}	
