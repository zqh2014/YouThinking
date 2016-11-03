<?php
/**
 * 
 * 
 * - 网站
 * 
 * @author Quinn
 */


class Model_Site extends PhalApi_Model_NotORM {




    function __construct(){ 

    }


    protected function getTableName($id = null) {
        return 'site';
    }


    /**
    * 用网站ID获取网站
    * @param $id String 
    * @return array 网站信息
    */

  
    public function getSiteById($id){

       return  $this->getORM()->where('id = ?', $id)->fetchOne(); 

    }


}

?>