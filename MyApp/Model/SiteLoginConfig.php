<?php
/**
 * 
 * 
 * - url登录参数配置
 * 
 * @author Quinn
 */


class Model_SiteLoginConfig extends PhalApi_Model_NotORM {




    function __construct(){ 

    }


    protected function getTableName($id = null) {
        return 'site_login_config';
    }


    /**
    * 用id获取网站参数配置信息
    * @param $id String 
    * @return array 网站参数配置信息
    */

  
    public function getSiteLoginConfigById($id){

       return $this->getORM()->where('id = ?', $id)->fetchOne(); 

    }
  



}

?>