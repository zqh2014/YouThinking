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
        $Wxcj = new Wxcj_Lite();    //采集类


        $count_ok = 0; //成功链接的数量
        foreach($cat_link as $value){

            switch($value['url_type']){
                case "wx":  //微信文章
               
                $article_list = $Wxcj->get_link_by_url($value['url']);
                break;
                case "lookmw":  //lookmw.com美文网文章
                    $article_list = $Wxcj->get_lookmw_url($value['url']);

                break;
                default: continue;;
            }

            if(!empty($article_list)){
                foreach($article_list as &$val){
                    $val['type_id'] = $value['type_id'];
                    $val['url_type'] = $value['url_type'];
                    $val['ctime'] = time();

                }

                $model->addLinkTime($value['id']);  //采集成功采集数量加1
                $insert_count = $model->inserArticle($article_list);
                $count_ok +=$insert_count ; //总数
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
    pubLic function putArticleContent(){

        $model = new Model_Article();
        $article_list = $model->getArticle();
        $Wxcj = new Wxcj_Lite();    //采集类
        $count_ok = 0;  //成功数量
        foreach($article_list as $value){
             switch($value['url_type']){
                 case "wx":  //微信文章

                 $maxid = $model->getMaxID();    //文章最大ID，用来生成ID                
                 $path_name = $maxid.$Wxcj->createRandomStr(); //生成目录名称（文章唯一的ID）               
                 $status = $Wxcj->fetch($value['original_url'],$path_name); //获取文章内容并保存到腾讯云
                 break;
                 case "lookmw": 
                 $maxid = $model->getMaxID();    //文章最大ID，用来生成ID
                
                 $path_name = $maxid.$Wxcj->createRandomStr(); //生成目录名称（文章唯一的ID）
                 $status = $Wxcj->get_lookmw_info($value['original_url'],$path_name,$value['img_url']); //获取文章内容并保存到腾讯云
                 
                 break;
                 
                 default: 
                 continue;
                 break;
             }

              if($status){
                    $upret = $model->updateArticle($value['id'], $value['type_id'], $path_name ,1,$value['title']);     //更新数据库

                    $count_ok++;
                 }else{
                    $model->updateArticle($value['id'], $value['type_id'], $path_name ,3);
                 }
                $Wxcj->delDirAndFile($path_name);   //删除当前目录和文件

        }
        return array("count_ok"=>$count_ok); 

    }



    //删除指定的文件夹
    public function delFolder( $folder ){
       
         $Wxcj = new Wxcj_Lite();    //采集类 
         $ret = $Wxcj->delFolder($folder);
         return $ret;
    }


}

?>