<?php
/**
 * 团队数据源类
 * 
 * - 用户模型
 * 
 * @author Qui
 */


class Model_Baidu extends PhalApi_Model_NotORM {


    protected function getTableName($id = null) {
        return 'baidu';
    }

     /**
     * key是否正确是否存在
     *  
     * @param $user_name string 用户名
     * @param $password string 密码
     * @param $captcha string 验证码
     * @return bool  true匹配成功，false匹配失败
     * 
     */
    public function userLogin($user_name, $password,$captcha="") {
    	
        return "baidu OK haha!";
    }
}

?>