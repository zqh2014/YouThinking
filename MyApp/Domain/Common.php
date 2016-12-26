<?php
/**
 * 公共方法
 * 
 * @author Quinn 20160927
 */

class Domain_Common {



      /**
     * 获取页面
     *  
     * @return string 返回信息。
     * 
     */
    public function get_contents($url) {

        $model = new Model_Common();
        $data_info = $model->get_contents($url);
        return   $data_info;

    }      





}
