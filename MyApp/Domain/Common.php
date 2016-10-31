<?php
/**
 * 登录网站和网站登录后的操作
 * 
 * @author Quinn 20160927
 */

class Domain_Common {



      /**
     * 获取页面
     *  
     * @return string 返回登录返回的的信息。
     * 
     */
    public function get_contents($url) {

        $model = new Model_Common();
        $data_info = $model->get_contents($url);
        return   $data_info;

    }      


    /**
     * 提交数据
     *  
     * @return string 返回登录返回的的信息。
     * 
     */
    public function get_contents_post($post_data) {

        $model = new Model_Common();
        $url = $post_data->url;
        unset($post_data->url);
        $post_str = '';
        foreach($post_data as $key=>$val){
            $post_str .=$key."=".$val."&";
        }
        $post_str = trim($post_str,"&");
        $data_info = $model->get_contents($url,$post_str);


        $status =101;
        $info = "设置失败";
        if(strpos($data_info, "设置成功")){
            $status = 0;
            $info = "设置成功";
        }

        if(strpos($data_info, "设置失败")){
            $status = 101;
            $info = "设置失败";
        }
        if(strpos($data_info, "需要登录")){
            $status = 102;
            $info = "需要登录";
        }

     
            $re_data = array("code"=>$status,"info"=>$info);

        
        return   $re_data;

    }


}
