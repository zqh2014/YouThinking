<?php
/**
 * 
 * 
 * - url参数配置
 * 
 * @author Quinn
 */


class Model_SiteFieldConfig extends PhalApi_Model_NotORM {




    function __construct(){ 

    }


    protected function getTableName($id = null) {
        return 'site_field_config';
    }


    /**
    * 用id获取网站参数配置信息
    * @param $url_id String 提交地址ID
    * @return array 网站参数配置信息
    */

  
    public function getSiteFieldConfigById($site_url_id){

       return  $this->getORM()->where('site_url_id = ?', $site_url_id)->fetchAll(); 

    }



}

?>