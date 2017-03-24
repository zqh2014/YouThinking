<?php
/**
 * 网站登录操作
 *
 * @author: quinn <quinn@gmail.com> 2017-1-04
 */

class Api_Site extends PhalApi_Api {


    var $Domain_site;
    var $url_id;


    function __construct(){ 
        $this->Domain_site = new Domain_Site();

        if(isset($_REQUEST['url_id'])){
            $this->url_id = $_REQUEST['url_id'];
        }else{
           throw new PhalApi_Exception_BadRequest("错误代码：A100"); 
        }
    }
	public function getRules() {
        //print_r($_REQUEST);

        if(empty($this->url_id)){
            
             throw new PhalApi_Exception_BadRequest("错误代码：A101");
        }
      
              $arr =array(
                'get_contents'=> array(
                    'url' => array('name' => 'url', 'require' => true) )  //url地址 带http://
             );

        return array_merge($arr,$this->Domain_site->getRulesArray($this->url_id));    

	}
	
	/**
	 * 登录服务
	 */
	public function login() {
       
       
        return $this->Domain_site->login($this);
        
	}


	//获取页面
	public function get_contents(){

		$Domain_Common = new Domain_Common();

		$data_info = $Domain_Common->get_contents($this->url);
		return $data_info;

	}

    //获取要登录的页面
    public function get_contents_post(){
      
       
        return $this->Domain_site->get_contents_post($this);

    }





}
