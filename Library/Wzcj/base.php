<?php
require('cos-php/include.php');
use qcloudcos\Cosapi;
Cosapi::setTimeout(180);
// 设置COS所在的区域，对应关系如下：
//     华南  -> gz
//     华中  -> sh
//     华北  -> tj
Cosapi::setRegion('gz');

class base {
	private $cos_obj;
	private $bucket_contents = 'article';
	private $dir = "http://article-1252171157.cosgz.myqcloud.com/article_contents/";

	
	public function __construct() {
		//$this->url = $url;
		//$this->path = $path;
		// 设置脚本执行不超时
		set_time_limit ( 0 );
	}


	

	//获取随机字符
	private function createRandomStr($length=4){
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
	public function upAllFile($folder){

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
	public function getFileList($dir) {
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

function __autoload($classname){ 
		
		$classpath="site/".$classname.'.php'; 

		if(file_exists($classpath)){ 
			require_once($classpath); 

		} 
		else{ 
		echo 'class file'.$classpath.'not found!'; 
		exit;
		} 
	} 