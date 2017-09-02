<?php

ini_set("display_errors","On");
# error_reporting(E_ALL);

include_once("base.php");
include_once("Snoopy.class.php");
/*
* 文章采集类
* 采集文章保存到腾讯COS
*/

class Wzcj_Lite extends base {

	private $site;
	function __construct($site_name) {

		// 设置脚本执行不超时
		set_time_limit ( 0 );

		$this->site = new $site_name();

	}

	//获取列表链接
	public function getList($url){

		return $this->site->getList($url);

	}

	//获取文章内容并保存到cos
	public function getContents($url, $path) {

		$path = $this->site->getContents($url, $path);
		$status = $this->upAllFile($path);		//上传文章目录
		return $status;


	}



}	//class end


//$Wzcj_Lite = new Wzcj_Lite("lookmw");

//$list = $Wzcj_Lite->getList("http://www.lookmw.cn/yc/list_64477_1.html");
//var_dump($list);



