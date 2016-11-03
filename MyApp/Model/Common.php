<?php
/**
 * 团队数据源类
 * 
 * - 用户模型
 * 
 * @author Qui
 */


class Model_Common extends PhalApi_Model_NotORM {

    protected function getTableName($id = null) {
        return 'common';
    }


     /**获取网页内容
     *  
     * @param $url string 网址
     * @param $data string post数据
     */
    public function get_contents($url,$data='') {
    	

        $data_info = DI()->loginLite->get_content($url,$data);

        return $data_info;
    }



    

}

?>