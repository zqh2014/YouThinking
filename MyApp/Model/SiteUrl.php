<?php
/**
 * 
 * 
 * - 网站url
 * 
 * @author Quinn
 */


class Model_Siteurl extends PhalApi_Model_NotORM {




    function __construct(){ 

    }


    protected function getTableName($id = null) {
        return 'site_url';
    }


    /**
    * 用网站url_id获取网站url信息
    * @param $id String 
    * @return array 网站信息
    */

  
    public function getSiteUrlById($id){

       return   $this->getORM()->where('id = ?', $id)->fetchOne(); 

    }
  



}

?>