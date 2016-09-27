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
            	//password' => array('name' => 'password', 'require' => true, 'min' => 6),
            	'user_name' => array('name' => 'user_name', 'require' => true),
            	'password'  => array('name' => 'password', 'require' => true),
            	'captcha'   => array('name' => 'captcha', 'default' => ''),
            	'model_class'  => array('name' => 'model_class', 'require' => true),
            	)
        );
	}
	
	/**
	 * 默认接口服务
	 */
	public function login() {
        
        $Domain_Login = new Domain_Login();
        $rs = $Domain_Login->userLogin($this->user_name, $this->password,$this->captcha,$this->model_class);
        return $rs;
	}








}
