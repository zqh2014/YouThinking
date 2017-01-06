<?php
/**
 * 文章采集接口
 *
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */

class Api_Article extends PhalApi_Api {



    function __construct(){ 
        set_time_limit ( 0 );
    }
	public function getRules() {
        //print_r($_REQUEST);


      
              $arr =array(
                'getArticleType'=> array(
                    'type_id' => array('name' => 'type_id', 'require' => true) ),                  
                'getArticleList'=> array(
                    'type_id' => array('name' => 'type_id', 'require' => true) ), 
                'putArticleInfo' =>array(
                    'limit' => array('name' => 'limit', 'require' => false)) 
             );

        return $arr;    

	}
	

    /*  获取文章所有分类
    * @Param $type_id 父ID
    * @Return Array 文章分类
    */
    public function getArticleType(){

    }


    /*  获取分类下的文章
    * @Param  $type_id 分类ID
    * @Return Array 文章列表
    */
    public function getArticleList(){

        
    }   


    /*  获取分文章详细内容
    * @Param  $path_name 文章目录，从腾讯去获取
    * @Return Array 文章详细内容
    */
    public function getArticleInfo(){


    }   


    //采集文章列表
    public function putArticleUrl(){

        $domain = new domain_Article();
        return $domain->putArticleUrl();

    }

    //采集文章内容
    public function putArticleInfo(){

        $domain = new domain_Article();

        return $domain->putArticleContent($this->limit);

    }



}
