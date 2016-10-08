<?php
/**
 * 登录网站和网站登录后的操作
 * 
 * @author Quinn 20160927
 */

class Domain_Login {



      /**
     * 用户登录
     * @param login_data 登录需要的数据
     * @return string 返回登录返回的的信息。
     * 
     */
    public function userLogin($login_data) {

        $model = new $login_data->model_class();
        $login_info = $model->userLogin($login_data);
        return   $login_info;

    }


}
