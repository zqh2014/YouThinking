<?php
/**
 * 
 * 
 * - 文章
 * 
 * @author Quinn
 */


class Domain_Article {



  

    /**
    * 插入文章数据,采集数据库已有的链接，
    * @param $data array 要提交的字段 
    * @return int 插入成功数量
    */
    pubLic function putArticleUrl(){

        $model = new Model_Article();
        $cat_link = $model->getCatLink();
       
        $count_ok = 0; //成功链接的数量
        foreach($cat_link as $value){

            switch($value['url_type']){
                case "wx":  //微信文章
                $Wxcj = new Wxcj_Lite();    //采集类
                $article_list = $Wxcj->get_link_by_url($value['url']);
              
                foreach($article_list as &$val){
                    $val['type_id'] = $value['type_id'];
                    $val['url_type'] = $value['url_type'];
                    $val['ctime'] = time();

                }
            
                $insert_count = $model->inserArticle($article_list);
                $count_ok +=$insert_count ; //总数
                break;
                case "lookmw": continue;    //未待过完续
                break;
                default: continue;
            }
        }
        
       
        return array("count_ok"=>$count_ok); 
        //print_r($cat_link);

    }

    /**
    * 采集文章内容保存到腾讯云
    * @param $data array 要提交的字段 
    * @return int 插入成功数量
    */
    pubLic function putArticleContent($limit=100){

        $model = new Model_Article();
        $article_list = $model->getArticle($limit);

        $count_ok = 0;  //成功数量
        foreach($article_list as $value){
             switch($value['url_type']){
                 case "wx":  //微信文章

                 $Wxcj = new Wxcj_Lite();    //采集类
                 //$article_list = $Wxcj->get_link_by_url($value['url']);
                 if(empty($value['path_name'])){
                     $path_name = $value['id'].$Wxcj->createRandomStr();
                 }else{
                    $path_name = $value['path_name'];
                 }

                 $status = $Wxcj->fetch($value['original_url'],$path_name); //获取文章内容并保存到腾讯云

                 if($status){
                    $upret = $model->updateArticle($value['id'], $value['type_id'], $path_name ,1,$value['title']);     //更新数据库
                    $Wxcj->delDirAndFile($path_name);   //删除当前目录和文件
                    $count_ok++;
                 }else{
                    $model->updateArticle($value['id'], $value['type_id'], $path_name ,3);
                 }
                 break;
                 case "lookmw": continue;    //未待过完续
                 break;
                 default: continue;


             }

        }
        return array("count_ok"=>$count_ok); 

    }

}

?>