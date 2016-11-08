<?php
/**
 * 
 * 
 * - 网站
 * 
 * @author Quinn
 */


class Domain_Site {



    /**
    * 生成要提交的字段
    * @param $url String 
    * @return array getRules()参数
    */
    pubLic function getRulesArray($site_url_id){

             
        $model_Site_Url = new Model_SiteUrl();
        $model_Site_Field_Config = new Model_SiteFieldConfig();

        $site_url = $model_Site_Url->getSiteUrlById($site_url_id);
        $site_field_config = $model_Site_Field_Config->getSiteFieldConfigById($site_url_id);

        $method = '';   //对应链接类型，调用的方法，
        switch($site_url["type"]){
            case 1:     //注册
             $method = "regeist";   
            break;

            case 2:     //登录
            $method = "login";           
            break;

            case 3:     //数据提交并获取
                $method = "get_contents_post";
            break;

            default :
                throw new PhalApi_Exception_BadRequest("错误代码：D101");
            break;
        }

        $rules_array = array();
        $rules_array[$method] = array();
        $type_arr = array(1=>"string",2=>"int",3=>"float",4=>"boolean",5=>"date",6=>"array",7=>"enum",8=>"file",9=>"callable"); //字段类型
        if(empty($site_field_config)){
            throw new PhalApi_Exception_BadRequest("错误代码：D102");
        }
        foreach($site_field_config as $key=>$value){

            $arr = array();
            $arr['name'] = $value['field_name'];  //字段名  
            $arr['type'] = $type_arr[$value['type']];              //字段类型
            $arr['is_require'] = $value['is_require']?true:false;  //是否必填
           
            if(!empty($value['max'])){                  //字符最大长度（文件类型为容量以字节计算）
                $arr['max'] = $value['max'];
            }
            if(!empty($value['min'])){                  //字符最小长度（文件类型为容量以字节计算）
                $arr['min'] = $value['min'];
            }
            if(!empty($value['default_value'])){        //默认值
                $arr['default_value'] = $value['default_value'];
            }
            if(!empty($value['format'])){               //字段格式，不同类型有不同的模式     
                $arr['format'] = $value['format'];
            }
            if(!empty($value['separator_symbol'])){     //数组类型的分割符
                $arr['separator_symbol'] = $value['separator_symbol'];
            }
            if(!empty($value['range_value'])){          //取值范围
                $arr['range_value'] = $value['range_value'];
            }               
            if(!empty($value['ext'])){                  //文件类型扩展名
                $arr['ext'] = $value['ext'];
            }

            $arr['desc_info'] = $value['desc_info'];    //字段描述，接口文档显示用

            $rules_array[$method][$arr['name']] = $arr;
        }
     // print_r($rules_array);
        return $rules_array;

    }
  


    /**
    * 登录
    * @param $data array 要提交的字段 
    * @return array 登录返回的结果
    */
    pubLic function login($data){

        $site_url_id = $data->url_id;
        $model_Site = new Model_Site();
        $model_Site_Url = new Model_SiteUrl();
        $model_Site_Field_Config = new Model_SiteFieldConfig();
        $model_Site_Login_Config = new Model_SiteLoginConfig();

        $site_url = $model_Site_Url->getSiteUrlById($site_url_id);
        $site = $model_Site->getSiteById($site_url['site_id']);

        $site_field_config = $model_Site_Field_Config->getSiteFieldConfigById($site_url_id);
        $site_login_config = $model_Site_Login_Config->getSiteLoginConfigById($site_url['site_id']);


        $login_status_arr = array(0=>"登录失败",1=>"登录成功");  //登录状态 0登录失败，1登录成功
        $home_url = $site['domain'];
        DI()->loginLite->m_url_home     = $home_url;
        DI()->loginLite->m_url_login    = $home_url.$site_login_config['url_login'];
        DI()->loginLite->m_url_logout   = $home_url.$site_login_config['url_logout'];
        DI()->loginLite->m_url_check    = $home_url;
        DI()->loginLite->m_flag_check   = $site_login_config['flag_check'];
        DI()->loginLite->m_flag_login   = $site_login_config['flag_login'];

        DI()->loginLite->login();
        $status = DI()->loginLite->check();

        if(!$status){       //判断是否已经登录
            $posts=array();
            foreach ($site_field_config as $key => $value) {
                $posts[$value['field_name']] = $data->$value['field_name'];
            }

            DI()->loginLite->m_logins = $posts;  
            $status =  DI()->loginLite->login();
        }

        return array('status'=>$status,'info'=>$login_status_arr[$status]); 

    }

    /**
    * 提交数据并获取结果，发布内容
    * @param $data array 要提交的字段 
    * @return array 返回提交结果
    */
    pubLic function get_contents_post($data){

        $site_url_id = $data->url_id;
        $model_Site = new Model_Site();
        $model_Site_Url = new Model_SiteUrl();
        $model_Site_Field_Config = new Model_SiteFieldConfig();

        $site_url = $model_Site_Url->getSiteUrlById($site_url_id);
        $site = $model_Site->getSiteById($site_url['site_id']);
        $site_field_config = $model_Site_Field_Config->getSiteFieldConfigById($site_url_id);

        $url = $site['domain'].$site_url['url'];
        $posts=array();

        foreach ($site_field_config as $key => $value) {
            $posts[$value['field_name']] = $data->$value['field_name'];
        }

        $data_info = DI()->loginLite->get_content($url,$posts);

        $is_success = strpos($data_info,$site_url['success_keyword']);

        if($is_success){
            return array('status'=>1,'info'=>"提交成功"); 
        }else{
            return array('status'=>0,'info'=>"提交失败"); 
        }
        return $data_info;

    }


}

?>