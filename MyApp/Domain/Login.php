<?php
/**
 * 投票领域业务类
 * 
 * @author dogstar <chanzonghuang@gmail.com> 20150517
 */

class Domain_Login {



      /**
     * key是否正确
     *  
     * @return bool  true匹配成功，false匹配失败
     * 
     */
    public function userLogin($user_name, $password,$captcha="",$model_class="Model_Icoord") {
        $model = new $model_class();
        return   $model->userLogin("", "" , "");
       

    }
}
