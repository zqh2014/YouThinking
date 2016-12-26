<?php
/**
 * 文章采集接口
 *
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */

class Api_Article extends PhalApi_Api {



    function __construct(){ 
       
    }
	public function getRules() {
        //print_r($_REQUEST);


      
              $arr =array(
                'get_contents'=> array(
                    'url' => array('name' => 'url', 'require' => true) )  //url地址 带http://
             );

        return $arr;    
        // return array(

        //     'login'=>array( 
        //     	//password' => array('name' => 'password', 'require' => true, 'min' => 6,'max'=>20),
        //     	'user_name' => array('name' => 'user_name', 'require' => true),		//用户名
        //     	'password'  => array('name' => 'password', 'require' => true),		//密码
        //     	'captcha'   => array('name' => 'captcha', 'default' => ''),			//验证码
        //     	'remember'   => array('name' => 'remember', 'default' => ''),			//是否记住
        //     	'model_class'  => array('name' => 'model_class', 'require' => true),	//网站模型
        //     	)
        // );
	}
	






}
