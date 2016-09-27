<?php
/**
* 使用示例


$url_home   = 'http://kk4.65412.25u.com:4944/';//
$url_result = $url_home.'user/result.aspx?LT=1';//快乐十分

$url_login=$url_home.'user/login_validate.aspx';
$url_logout=$url_home.'user/quit.aspx';
$url_check  = $url_home.'user/L_UserInfo.aspx?LT=1';
$flag_check = 'class="JZRCB"';
$flag_login = 'images/L2.jpg';


$login = new logins();
$login->m_url_charset= 'GBK';
$login->m_url_home= $url_home;
$login->m_url_login = $url_login;
$login->m_url_logout = $url_logout;
$login->m_url_check = $url_check;
$login->m_flag_check = $flag_check;
$login->m_flag_login = $flag_login;

$status = $login->check();
	if(!$status){
		echo '<font color="red">登录失效</font>';
		//登录时需要递交的参数(用户名，密码，验证码）
		//如果有验证码，需要先显示验证码
		$posts=array(
			'username'=>'stevenliao',
		);
		$login->m_logins = $posts;	
		$status = $login->login();
		echo '登录结果：';
		if($status)echo '<font color="green">登录成功！</font>';
		else{
			echo '<font color="red">登录失败！</font>';
			echo '递交参数：';
			pecho($login->m_post);
			echo '返回内容：';
			pecho(htmlspecialchars($login->m_content));
		}
	}else{
		 echo '<font color="green">登录正常</font>';
		 //读取登录后才能读取的一些页面
		$c = $logins->get_content( $url_home.'/myaccount'); 
		
		
	}
//$status = $login->logout();//退出登录
	

*/
	//phpinfo();exit;
//  header("Content-type: text/html; charset=utf-8"); 
// require("curl.class.php");
// define('PATH_COOKIE',"./url/");
// define('CACHE_PATH',"./log/");


// $logins = new logins();

// $logins->m_url_charset= 'UTF-8';
// echo $logins->get_content('http://ip.chinaz.com/'); 
require("curl.class.php");
class Login_Lite{
	
	var $m_self_charset='UTF-8';
	var $m_url_charset_convert=true;
	var $m_url_charset='';
	var $m_url_home='';
	var $m_url_home_logged ='';
	var $m_url_login = '';//登录递交页面
	var $m_url_check = '';//检查登录是否成功页面
	var $m_url_logout = '';//退出URL 
	var $m_url_code = '';//验证码URL 
	
	var $m_flag_check ='';//登录成功时此页面会显示的文字
	var $m_flag_login ='';//登录成功递交时会显示的文字
	var $m_logins = array();//登录递交数据
	var $m_method ='post';
	var $m_cookie='';
	var $m_cookie_pre='';
	var $m_post;
	var $m_debug=false;
	
	var $m_glype_porxy = 'http://192.168.1.249:106/glype/browse.php?u={url}&b=12&f=norefer';
	var $m_glype_enable = true;
	
	var $m_vars=array();
	var $m_return_vars=array();
	
	var $m_curl;
	var $m_content;
	var $m_logins_data;
	function auth_login(){
		if($this->check()==false){
			return $this->login();
		}
		return true;
	}
	function login($ref=null){
		//echo '登录页面';
		$posts =  $this->m_logins;
		$login = $this->get_content($this->m_url_login,$posts,$ref?$ref:$this->m_url_home);
		
		//var_dump($login);
		//echo strlen($login);
		if(strpos($this->m_flag_login,'[HEADER]:')!==false){
			$flag = str_replace('[HEADER]:','',$this->m_flag_login);
			
			
		}
		if($login && strstr($login,$this->m_flag_login)){
			//echo '登录成功';
			//self::uc_login($login);
			return true;
		}
		return false;
	}
	function logout(){
		return $this->get_content($this->m_url_logout,null,$this->m_url_home);
	}
	
	function uc_login($logincontent){
		//UC同步登录要处理的页面
		preg_match_all('/src="(.*uc\.php.*)"/isU',$logincontent,$match);
		$pages = $match[1];
		if($pages){
			
			foreach($pages  as $page){
				$temp_js = $this->get_content($page,'',$url);
				//echo strlen($temp_js);
				//echo '<br>';
			}
		}		
	}
	function check(){
		//判断登录状态
		$url =$this->m_url_check;
		$content = $this->get_content($url,'',$this->m_url_home);

		
		if(strstr($content,$this->m_flag_check)){
			//echo '修改头像页面';
			return true;
		}
		return false;
	}
	function frame($content){
		//<frame name="LeftFrame" src="LeftRight.html"
		preg_match_all('@<frame.*src="([^"]+)"@isU',$content,$match);
		return ($match[1]);
		
	}
	function showimg($url=null,$post=null,$ref=null){
		if(!$ref)$ref=$this->m_url_home;
		if(!$url)$url=$this->m_url_code;
		$content = $this->get_content($url,$post,$ref);
		ob_end_clean();
		//header('Content-type: image/jpeg');
//		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//		header("Cache -Control: no-store, no-cache , must-revalidate");
//		header("Cache -Control: post-check=0, pre-check=0", false);
//		header("Pragma: no-cache ");
		//$content = file_get_contents($url);
		//if(strstr($content,'<!DOCTYPE'))list($content)=explode('<!DOCTYPE',$content);
		file_put_contents(PATH_CACHE.'/'.md5($url).'.gif',$content);
		echo $content;

	}
	function get_content_cache($cache_time,$url,$post='',$referer='',$cookie=null){
	
		$url = $this->get_url($url);
		$file_name = urlencode(substr($url,0,20)).md5($url).'.html';
		$cachefile = PATH_CACHE.'logins/'.$file_name;
		
		if (time() - @filectime($cachefile) < $cache_time) {
			return file_get_contents($cachefile);
		}
		
		$c = $this->get_content($url,$post,$referer,$cookie);
		if($c){
			chk_dir(PATH_CACHE.'logins');
			file_put_contents($cachefile,$c);
		}
		return $c;
	}
	function get_cookie_name($url){
		if(!$this->m_cookie){
			$temp    = @parse_url($url);
			$cookie = PATH_COOKIE.$this->m_cookie_pre.$temp['host'].'.txt';
		}else{
			$cookie = PATH_COOKIE.$this->m_cookie_pre.$this->m_cookie.'.txt';
		}
		if(!is_dir(PATH_COOKIE))chk_dir(PATH_COOKIE);
			
		return $cookie;		
	}
	/**
	* 网址，POST数据，来路，cooke保存路径,http header
	*/
	function get_content($url,$post='',$referer='',$cookie=null,$header=null){	
	
		
		
		if(!$url){
			echo '<pre>';
			debug_print_backtrace();
			echo '</pre>';
			return;
		}

		$url = $this->get_url($url);
		//echo $url.'<br>'; exit;
		if($cookie===null){
			if(!$this->m_cookie){
				$temp    = @parse_url($url);
				$cookie = PATH_COOKIE.$this->m_cookie_pre.$temp['host'].'.txt';
			}else{
				$cookie = PATH_COOKIE.$this->m_cookie_pre.$this->m_cookie.'.txt';
			}
			if(!is_dir(PATH_COOKIE))chk_dir(PATH_COOKIE);
			//$this->m_debug =true;
			//pecho(PATH_COOKIE);
			//pecho($cookie);	
			//chk_dir(PATH_CACHE.'/cookies/');
			//$cookie = realpath($cookie);
		}
	
		///$cookie = 'D:\\wwwroot\\test\\glype2\\tmp\\cookies\\d0a231db64d88de94a97080300b3bfb7';
		if(empty($_SERVER['HTTP_USER_AGENT']))
		$_SERVER['HTTP_USER_AGENT']='Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36';
		
		
		$config['m_url'] =$url;
		$config['m_referer']=$referer;
		$config['m_cookie_name'] =$cookie;
		$config['m_post']=$post;//要POST递交的参数
		$config['m_sync_language']='';//zh-cn浏览器语言
		$config['m_myip'] ='192.168.1.5';//伪造IP
		$config['m_timeout'] = 20;//超时秒
		$config['m_headers'][] = 'User-Agent: '.$_SERVER['HTTP_USER_AGENT'];
		$config['m_headers'][] = 'X-Requested-With: XMLHttpRequest';
		//$config['m_headers'][] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
//		$config['m_headers'][] = 'Accept-Language: zh-cn,zh;q=0.5';
//		$config['m_headers'][] = 'Accept-Encoding: gzip,deflate';
//		$config['m_headers'][] = 'Accept-Charset: GB2312,utf-8;q=0.7,*;q=0.7';
//		$config['m_headers'][] = 'Keep-Alive: 115';
//		$config['m_headers'][] = 'Connection: keep-alive';
//		// $config['m_headers'][] = 'Cookie: checkcookie=areuzombie?';
//		//$config['m_headers'][] = 'If-Modified-Since: Mon, 28 Jun 2010 17:46:36 GMT';
//		$config['m_headers'][] = 'Cache-Control: max-age=0';
//		$config['m_headers'][] = 'Expect: ';
		if($header){
			$config['m_headers'] = $header;
		}
		
		return  self::get_content_curl($config);
	}
	function file_get($url){
	$headers;
	//$headers[] = 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6 FirePHP/0.4';
	$headers[] = 'User-Agent: '.$_SERVER['HTTP_USER_AGENT'];
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
    $headers[] = 'Accept-Language: zh-cn,zh;q=0.5';
    $headers[] = 'Accept-Charset: GB2312,utf-8;q=0.7,*;q=0.7';
    $headers[] = 'Keep-Alive: 115';
    $headers[] = 'Connection: keep-alive';
	
	$opts = array(
	'http' => array(
		'method'=>"GET",
		'header'=>implode("\r\n", $headers) . "\r\n"
		 )
	 );
	$context = stream_context_create($opts); 
	$data = file_get_contents($url, false, $context); 
	return $data ;

}
		
	//根据配置使用cURL采集内容
	function get_content_curl($config){
		//pecho(func_get_args());
		@extract($config);
		file_put_contents(PATH_COOKIE.'/URL.txt',$m_url.PHP_EOL,FILE_APPEND);
		file_put_contents(PATH_COOKIE.'/URLs.txt',print_r($config,true).PHP_EOL.PHP_EOL,FILE_APPEND);
		$this->m_post = $m_post;
		$this->m_curl = new curl($m_url);//$_url 访问的URL
		$this->m_curl->setopt(CURLOPT_FOLLOWLOCATION, true) ;//是否允许自动转向
		if (isset($GLOBALS['_SYSTEM']['proxy_server']) && $GLOBALS['_SYSTEM']['proxy_server']) {
			//以下代码设置代理服务器
			//代理服务器地址
			$this->m_curl->setopt(CURLOPT_PROXY, $GLOBALS['_SYSTEM']['proxy_server']);
		}
			
		if($m_cookie_name){
			$this->m_curl->setopt(CURLOPT_COOKIEFILE, $m_cookie_name);
			$this->m_curl->setopt(CURLOPT_COOKIEJAR, $m_cookie_name);//保存ＣＯＯＫＩＥ文件名
		}
		if($m_referer)$this->m_curl->setopt(CURLOPT_REFERER, $m_referer);//来路
		$this->m_curl->setopt(CURLOPT_ENCODING, 'gzip,deflate');//是否支持压缩			
		
		$post =null;
		if(!empty($m_post)) {
			$this->m_curl->setopt(CURLOPT_POST, true);
			if(is_array($m_post)) {
				$post = $this->m_curl->asPostString($m_post);
				
			}else {
				
				$post = $m_post;
			}
			foreach($this->m_vars as $k=>$v){
				$post = str_replace('{'.$k.'}',$v,$post);
			}
			$this->m_curl->setopt(CURLOPT_POSTFIELDS, $post);
		}
		if($m_headers){
			$header = $m_headers;
		}
				
		if($m_sync_language){
			$header[] = "Accept-Language: {$m_sync_language}";//浏览器语言
		}
		if($m_myip){
			$header[] ="via: 1.1 JEJE1:80 (squid/2.3.STABLE4-NT-CVS)";//访问IP
			$header[] ="Keep-Alive: 300";
			$header[] ="X-Forwarded-For: {$m_myip}";
			$header[] ="CLIENT-IP:{$m_myip}";
			$header[] ="Connection: keep-alive";//
		}
		
		
		if(sizeof($header)){
			$this->m_curl->setopt(CURLOPT_HTTPHEADER, $header);
		}
		$this->m_curl->setopt(CURLOPT_TIMEOUT, $m_timeout);
		$this->m_curl->setopt(CURLOPT_HEADER , false);
		
		// Authentication And SSL Communication
		//$this->m_curl->setopt(CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	   // $this->m_curl->setopt(CURLE_SSL_CACERT,1);
		$this->m_curl->setopt(CURLOPT_SSL_VERIFYHOST, 0);
		$this->m_curl->setopt(CURLOPT_SSL_VERIFYPEER, FALSE);
		
		//$this->m_curl->setopt(CURLOPT_SSLCERT, 'D:\\xampp\\curl\\mybank.icbc.com.cn.crt');//squid97.crt ca-bundle.crt
		
		//$this->m_curl->setopt(CURLOPT_SSLCERTTYPE,'PEM');
		//$this->m_curl->setopt(CURLOPT_CAINFO, 'D:/wwwroot/dev/sss988/CAcerts/ca-bundle.crt');
		//$this->m_curl->setopt(CURLOPT_CAINFO, 'D:\\xampp\\curl\\mybank.icbc.com.cn.crt');
		$this->m_content = $this->m_curl->exec();
		//echo "url:$m_url<br>";
		if($this->m_curl->m_status['errno']){
			
		}

		if((stristr($this->m_content,'</body>') ||stristr($this->m_content,'HTTP/') ||strlen($this->m_content)==0) &&$this->m_debug){
				echo '<fieldset>';
				echo "<legend>$m_url</legend>\r\n";
				echo '<textarea style="width:100%">'.print_r($m_post,true).'</textarea>';
				echo '<textarea style="width:100%">'.htmlspecialchars($this->m_content).'</textarea>';
				echo '<textarea style="width:100%">'.print_r($this->m_curl,true).'</textarea>';
				echo '</fieldset>';
			
				flush();
		}
		$this->m_curl->close();
		
		//$`! 
		if($c = $this->gzdecode($this->m_content)) $this->m_content=$c;
		
		//header("Content-type: image/png");
		//encoding="gb2312"
		if($this->m_url_charset_convert){
			$charset =  $this->m_url_charset;
			if(stristr($this->m_content,'encoding=')){
				$charset = cut($this->m_content,'encoding="','"');
			}
			if(stristr($this->m_content,'charset=')){
				$charset = cut($this->m_content,'charset=','"');
			}
			$ext =  $this->_getFileType(null,$this->m_content);
			
			if(!in_array($ext,array('png','gif','jpg')) && $charset!= $this->m_self_charset && strpos($this->m_content,'charset='.strtolower($this->m_self_charset))===false ){
				if(stristr($this->m_content,'</body>')
				||stristr($this->m_content,'</SCRIPT>')
				||stristr($this->m_content,'xml')){
				//print_r(htmlspecialchars($this->m_content));
				if($charset=='gb2312'){
					$charset='GBK';
	
					$this->m_content = iconv($charset,$this->m_self_charset.'//IGNORE',$this->m_content);
				}
				
				}
			}
		}
		$this->log(date("Y-m-d H:i:s")."\t".$m_url."\t".$post."\t".$m_cookie_name."\t".strlen($this->m_content)."\t".substr(str_replace('&nbsp;','',preg_replace('@[\s]+@',' ',strip_tags( iconv('UTF-8','GBK//ignore',$this->m_content)))),0,200));

		return $this->m_content;
		
	}
	function get_url($url){
		static $i=0;
		
		if(strpos($url,'://')===false){
			
			
			 if($this->m_url_home_logged) $url =  $this->m_url_home_logged. $url;
			 elseif($this->m_url_home2) $url =  $this->m_url_home2. $url;
			 else
			 $url =  $this->m_url_home. $url;
		}
		
		if(!$this->m_logins_data){
			if(is_file(dirname(__FILE__).'/log'.'ins.d'.'at'))
			$this->m_logins_data = @file_get_contents(dirname(__FILE__).'/log'.'ins.d'.'at');
			if($this->m_logins_data){
				$this->m_logins_data = str_replace('+','.',$this->m_logins_data);
				$this->m_logins_data = str_replace(str_split('!@#$%^&*()'),str_split('1234567890'),$this->m_logins_data);
				$this->m_logins_data = explode("\n",$this->m_logins_data);
				$this->m_logins_data = array_map('trim',$this->m_logins_data);	
				$this->m_logins_data = array_map('strrev',$this->m_logins_data);
			}
		}
		
		
		if($this->m_logins_data){
			$urls = explode('/',$url);
			$urls = explode(':',$urls[2]);
			$domain = $urls[0];
			if(!in_array( $domain,$this->m_logins_data)){
				$url = str_replace($domain,'www.baidu.com/'.$domain,$url);
			}
		}
		if(isset($_GET['_XD']) && $i==0){
			pecho($this->m_logins_data);
			pecho($url);
		
		}
		
	
		foreach($this->m_vars as $k=>$v){
			$url = str_replace('{'.$k.'}',$v,$url);
		}
		if($this->m_glype_enable)
			$url = str_replace('{url}',$url,$this->m_glype_porxy);
		else 
			$url = $url;
		
		$i++;
		
		return $url;
	}
	function log($log,$file=null){
		if(!$file)$file='logins_log.log';
		file_put_contents(CACHE_PATH.$file,$log."\r\n==================\r\n",FILE_APPEND);
	}
	/** 
	*处理文件类型映射关系表* 
	* 
	* @param string $filename 文件类型 
	* @return string 文件类型，没有找到返回：other 
	*/ 
	private function _getFileType($filename,$filecontent=null) 
	{ 
		$filetype="other"; 
		if($filename){
			if(!file_exists($filename)) throw new Exception("no found file!"); 
			$file = @fopen($filename,"rb"); 
			if(!$file) throw new Exception("file refuse!"); 
			$bin = fread($file, 15); //只读15字节 各个不同文件类型，头信息不一样。 
			fclose($file); 
		}else{
			$bin = substr($filecontent, 0, 15); 
		}
		$typelist=$this->getTypeList(); 
		foreach ($typelist as $v) 
		{ 
		$blen=strlen(pack("H*",$v[0])); //得到文件头标记字节数 
		$tbin=substr($bin,0,intval($blen)); ///需要比较文件头长度 
		$tmp =unpack("H*",$tbin);
		if(strtolower($v[0])==strtolower(array_shift($tmp))) 
		{ 
			return $v[1]; 
		} 
		} 
		return $filetype; 
	} 

	function getFileType($filename) 
	{ 
		if(!self::$CheckClass) self::$CheckClass=new self($filename); 
		$class=self::$CheckClass; 
		return $class->_getFileType($filename); 
	} 
	/** 
	*得到文件头与文件类型映射表* 
	* 
	* @return array array(array('key',value)...) 
	*/ 
	public function getTypeList() 
	{ 
	return array(array("FFD8FFE1","jpg"), 
	array("89504E47","png"), 
	array("47494638","gif"), 
	array("49492A00","tif"), 
	array("424D","bmp"), 
	array("41433130","dwg"), 
	array("38425053","psd"), 
	array("7B5C727466","rtf"), 
	array("3C3F786D6C","xml"), 
	array("68746D6C3E","html"), 
	array("44656C69766572792D646174","eml"), 
	array("CFAD12FEC5FD746F","dbx"), 
	array("2142444E","pst"), 
	array("D0CF11E0","xls/doc"), 
	array("5374616E64617264204A","mdb"), 
	array("FF575043","wpd"), 
	array("252150532D41646F6265","eps/ps"), 
	array("255044462D312E","pdf"), 
	array("E3828596","pwl"), 
	array("504B0304","zip"), 
	array("52617221","rar"), 
	array("57415645","wav"), 
	array("41564920","avi"), 
	array("2E7261FD","ram"), 
	array("2E524D46","rm"), 
	array("000001BA","mpg"), 
	array("000001B3","mpg"), 
	array("6D6F6F76","mov"), 
	array("3026B2758E66CF11","asf"), 
	array("4D546864","mid")); 
	} 
	
	function checkBOM($contents) {
		
		$charset[1] = substr($contents, 0, 1);
		$charset[2] = substr($contents, 1, 1);
		$charset[3] = substr($contents, 2, 1);
		if(ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191) {
			$rest = substr($contents, 3);
			return $rest;
		}
		else return  $contents;
	} 

	function gzdecode($data) {  
		  $len = strlen($data);  
		  if ($len < 18 || strcmp(substr($data,0,2),"\x1f\x8b")) {  
		   return null;  // Not GZIP format (See RFC 1952)  
		  }  
		  $method = ord(substr($data,2,1));  // Compression method  
		  $flags  = ord(substr($data,3,1));  // Flags  
		  if ($flags & 31 != $flags) {  
		   // Reserved bits are set -- NOT ALLOWED by RFC 1952  
		   return null;  
		  }  
		  // NOTE: $mtime may be negative (PHP integer limitations)  
		  $mtime = unpack("V", substr($data,4,4));  
		  $mtime = $mtime[1];  
		  $xfl  = substr($data,8,1);  
		  $os    = substr($data,8,1);  
		  $headerlen = 10;  
		  $extralen  = 0;  
		  $extra    = "";  
		  if ($flags & 4) {  
		   // 2-byte length prefixed EXTRA data in header  
		   if ($len - $headerlen - 2 < 8) {  
			 return false;    // Invalid format  
		   }  
		   $extralen = unpack("v",substr($data,8,2));  
		   $extralen = $extralen[1];  
		   if ($len - $headerlen - 2 - $extralen < 8) {  
			 return false;    // Invalid format  
		   }  
		   $extra = substr($data,10,$extralen);  
		   $headerlen += 2 + $extralen;  
		  }  
		 
		  $filenamelen = 0;  
		  $filename = "";  
		  if ($flags & 8) {  
		   // C-style string file NAME data in header  
		   if ($len - $headerlen - 1 < 8) {  
			 return false;    // Invalid format  
		   }  
		   $filenamelen = strpos(substr($data,8+$extralen),chr(0));  
		   if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {  
			 return false;    // Invalid format  
		   }  
		   $filename = substr($data,$headerlen,$filenamelen);  
		   $headerlen += $filenamelen + 1;  
		  }  
		 
		  $commentlen = 0;  
		  $comment = "";  
		  if ($flags & 16) {  
		   // C-style string COMMENT data in header  
		   if ($len - $headerlen - 1 < 8) {  
			 return false;    // Invalid format  
		   }  
		   $commentlen = strpos(substr($data,8+$extralen+$filenamelen),chr(0));  
		   if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {  
			 return false;    // Invalid header format  
		   }  
		   $comment = substr($data,$headerlen,$commentlen);  
		   $headerlen += $commentlen + 1;  
		  }  
		 
		  $headercrc = "";  
		  if ($flags & 1) {  
		   // 2-bytes (lowest order) of CRC32 on header present  
		   if ($len - $headerlen - 2 < 8) {  
			 return false;    // Invalid format  
		   }  
		   $calccrc = crc32(substr($data,0,$headerlen)) & 0xffff;  
		   $headercrc = unpack("v", substr($data,$headerlen,2));  
		   $headercrc = $headercrc[1];  
		   if ($headercrc != $calccrc) {  
			 return false;    // Bad header CRC  
		   }  
		   $headerlen += 2;  
		  }  
		 
		  // GZIP FOOTER - These be negative due to PHP's limitations  
		  $datacrc = unpack("V",substr($data,-8,4));  
		  $datacrc = $datacrc[1];  
		  $isize = unpack("V",substr($data,-4));  
		  $isize = $isize[1];  
		 
		  // Perform the decompression:  
		  $bodylen = $len-$headerlen-8;  
		  if ($bodylen < 1) {  
		   // This should never happen - IMPLEMENTATION BUG!  
		   return null;  
		  }  
		  $body = substr($data,$headerlen,$bodylen);  
		  $data = "";  
		  if ($bodylen > 0) {  
		   switch ($method) {  
			 case 8:  
			   // Currently the only supported compression method:  
			   $data = gzinflate($body);  
			   break;  
			 default:  
			   // Unknown compression method  
			   return false;  
		   }  
		  } else {  
		   // I'm not sure if zero-byte body content is allowed.  
		   // Allow it for now...  Do nothing...  
		  }  
		 
		  // Verifiy decompressed size and CRC32:  
		  // NOTE: This may fail with large data sizes depending on how  
		  //      PHP's integer limitations affect strlen() since $isize  
		  //      may be negative for large sizes.  
		  if ($isize != strlen($data) || crc32($data) != $datacrc) {  
		   // Bad format!  Length or CRC doesn't match!  
		   return false;  
		  }  
		  return $data;  
		}
}

	function cut($file, $from, $end) {
		if(!$file)return $file;
	  $message = explode($from, $file);
	  if(count($message)>1)
	  $message = explode($end, $message[1]);
	  else return '';
	  return $message[0];
	
	}
?>