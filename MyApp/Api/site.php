<?php
/**
 * 默认接口服务类
 *
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */

class Api_Site extends PhalApi_Api {


	public function getRules() {
        //print_r($_REQUEST);

        if(!empty($_REQUEST['url_id'])){
            $url_id = $_REQUEST['url_id'];
        }else{
             throw new PhalApi_Exception_BadRequest("参数错误！");
        }
        $site = new Domain_Site();

        $site->getRulesArray($url_id);


        
        return array(

            'login'=>array( 
            	//password' => array('name' => 'password', 'require' => true, 'min' => 6,'max'=>20),
            	'user_name' => array('name' => 'user_name', 'require' => true),		//用户名
            	'password'  => array('name' => 'password', 'require' => true),		//密码
            	'captcha'   => array('name' => 'captcha', 'default' => ''),			//验证码
            	'remember'   => array('name' => 'remember', 'default' => ''),			//是否记住
            	'model_class'  => array('name' => 'model_class', 'require' => true),	//网站模型
            	),
            'get_contents'=> array(
            	'url' => array('name' => 'url', 'require' => true)	 //url地址 带http://
            	),
            'get_contents_post'=>array(
                'url' => array('name' => 'url', 'require' => true),   //url地址 带http://
                'nickname'=>array('name' => 'nickname', 'require' => true),
                'sex'=>array('name' => 'sex', 'default' => '0'),
                'province'=>array('name' => 'province', 'type'=>'int', 'default' => 1),
                'city'=>array('name' => 'city', 'default' => ''),
                'district'=>array('name' => 'district', 'default' => ''),
                'signature'=>array('name' => 'signature', 'require' => true)
                )
        );
	}
	
	/**
	 * 登录服务
	 */
	public function login() {
       
        $Domain_Login = new Domain_Login();
        $rs = $Domain_Login->userLogin($this);
        return $rs;
	}


	//获取页面
	public function get_contents(){

		$Domain_Common = new Domain_Common();

		$data_info = $Domain_Common->get_contents($this->url);
		return $data_info;

	}

    //获取要登录的页面
    public function get_contents_post(){
        $Domain_Common = new Domain_Common();

        $data_info = $Domain_Common->get_contents_post($this);
        return $data_info;

    }





}
