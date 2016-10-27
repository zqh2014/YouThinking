<?php
/**
 * 用户领域业务类
 * 
 * @author dogstar <chanzonghuang@gmail.com> 20150517
 */

class Domain_Users {



      /**
     * key是否正确
     *  
     * @return bool  true匹配成功，false匹配失败
     * 
     */
    public function isJoinIn($domain, $key) {
        $model = new Model_Users();
        return   $model->isJoinIn($domain, $key);
       

    }
}
