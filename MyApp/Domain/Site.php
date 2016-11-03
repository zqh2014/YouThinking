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
    * 获取登录要提交的字段
    * @param $url String 
    * @return array getRules()参数
    */
    pubLic function getRulesArray($site_url_id){

             
        $model_Site = new Model_Site();
        $model_Site_Url = new Model_SiteUrl();
        $model_Site_Field_Config = new Model_SiteFieldConfig();
        $model_Site_Login_Config = new Model_SiteLoginConfig();

        $site_url = $model_Site_Url->getSiteUrlById($site_url_id);
        $site     = $model_Site->getSiteById( $site_url['site_id']);
        $site_field_config = $model_Site_Field_Config->getSiteFieldConfigById($site_url_id);

print_r($site_field_config);

        
        return '';

    }
  



}

?>