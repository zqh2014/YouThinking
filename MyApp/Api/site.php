<?php
/**
 * 默认接口服务类
 *
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */

class Api_Site extends PhalApi_Api {


	public function getRules() {
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
            	'url' => array('name' => 'url', 'require' => true)	 //用户名
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







}
