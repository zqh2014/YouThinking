<?php
/**
 * 团队数据源类
 * 
 * - 用户模型
 * 
 * @author Quinn
 */


class Model_Icoord extends PhalApi_Model_NotORM {


    public $url_home;
    public $url_result;
    public $url_login;
    public $url_logout;
    public $url_check;
    public $flag_check;
    public $flag_login;

    function __construct(){ 
        $this->url_home   = 'http://www.icoord.com';
        $this->url_result = $this->url_home;

        $this->url_login=$this->url_home.'/index.php?s=/ucenter/member/login.html';
        $this->url_logout=$this->url_home.'/index.php?s=/ucenter/system/logout.html';
        $this->url_check  = $this->url_home.'http://www.icoord.com';
        $this->flag_check = '未读';
        $this->flag_login = '未读';
    }


    protected function getTableName($id = null) {
        return 'icoord';
    }


     /**
     * 用户登录
     *  
     * @param $login_data['user_name'] string 用户名
     * @param $login_data['password'] string 密码
     * @param $login_data['captcha'] string 验证码
     * @return array 
     * 
     */
    public function userLogin($login_data) {
    	
        //header("Content-Type: text/html;charset=utf-8");
       // DI()->loginLite->m_url_charset= 'GBK';
        $login_status_arr = array(0=>"登录失败",1=>"登录成功");  //登录状态 0登录失败，1登录成功
        DI()->loginLite->m_url_home= $this->url_home;
        DI()->loginLite->m_url_login = $this->url_login;
        DI()->loginLite->m_url_logout = $this->url_logout;
        DI()->loginLite->m_url_check = $this->url_check;
        DI()->loginLite->m_flag_check = $this->flag_check;
        DI()->loginLite->m_flag_login = $this->flag_login;

        DI()->loginLite->login();
        $status =  DI()->loginLite->check();
            if(!$status){
               // echo '<font color="red">登录失效1</font>';
                //登录时需要递交的参数(用户名，密码，验证码）
                //如果有验证码，需要先显示验证码
                $posts=array(
                    'username'=>$login_data->user_name,
                    'password'=>$login_data->password
                );
                DI()->loginLite->m_logins = $posts;  
                $status =  DI()->loginLite->login();

            }

 //print_r(DI()->loginLite->m_content); 
//$status = DI()->loginLite->logout();//退出登录

        return array('status'=>$status,'info'=>$login_status_arr[$status]);

    }



}

?>