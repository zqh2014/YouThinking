<?php
/**
 * 
 * 
 * - 网站
 * 
 * @author Quinn
 */


class Model_Article extends PhalApi_Model_NotORM {




    function __construct(){ 

    }


    protected function getTableName($id = null) {
        return 'Article_temp';
    }



    /**
    * 插入文章数据
    * @param $data 二维数组
    * @return int 插入数量
    */

  
    public function inserArticle($data){
        $count = 0;
        foreach($data as $val){

            if(!$this->title_isexist($val['title'])){
                $this->getORM()->insert($val);
                 $count++;
            }
           

        }
     return $count;   //插入多条

    }


    //标题是否存在
    public function title_isexist($title){

     $info = $this->getORM()->where("title LIKE ?","%{$title}%")->fetchOne();   //插入多条
     if(!empty($info)){
        return true;    //存在
     }else{ 

        $sql = "select * from ic_article where title like '%{$title}%'";   
        $data = $this->getORM()->queryRows($sql);  
        if(!empty($data)){
            return true;
        }else{
            return false;   //不存在
        }
     }

    }

    /**
    * 获取文章所有的采集链接
    * 
    * @return $data
    */

  
    public function getCatLink(){

      $this->delWxArticle(); //删除旧数据（前一天的微信链接）
      $sql = "select * from ic_article_cat_links order by cj_times asc";    //次数小的在前面
      $data = $this->getORM()->queryRows($sql);   
       return $data;
    }


    /**
    * 采集链接次数加1
    * 
    * @return $data
    */

  
    public function addLinkTime($id){

      $sql = "UPDATE ic_article_cat_links SET cj_times = cj_times+1 WHERE id =".$id;    //次数小的在前面
      $data = $this->getORM()->queryRows($sql);   
       return $data;
    }



    /**
    * 获取文章采集内容
    * 
    * @return $data
    */

  
    public function getArticle(){

      $limit=1;
      $sql = "select * from ic_article_temp where status=0 limit {$limit}";    
      $data = $this->getORM()->queryRows($sql);   
       return $data;
    }

    /**
    * 获取已采集文章最大的ID
    * 
    * @return $data
    */

  
    public function getArticleCount(){

      $limit=1;
      $sql = "select id from ic_article order by id desc limit 1";    
      $data = $this->getORM()->queryRows($sql);   
      
      return $data[0]['id'];
    }


     /**
    * 删除微信前一天采集的文章链接
    * 
    * @return $data
    */

  
    public function delWxArticle(){

      $ago_time = strtotime(date("Y-m-d",time()));

      $sql = "delete from ic_article_temp where url_type='wx' and ctime<".$ago_time;    
      $data = $this->getORM()->queryRows($sql);   
       return $data;
    }

       

    /**
    * 更新文章内容
    * 
    * @return $data
    */

  
    public function updateArticle($id,$type_id,$path_name,$status,$title=''){

            if($status==1){
                 $rs=$this->getORM()->where('id', $id)->update(array("status"=>1));

                $time = time();
                $temp = $this->getORM()->where('id', $id)->fetchOne();
                $sql = "INSERT INTO `ic_article` (`title`,`path_name`, `type_id`, `ctime`)  VALUES ('{$title}','{$path_name}', '{$type_id}', '{$time}');";              
              
                $this->getORM()->queryAll($sql);              
                $this->getORM()->where('id', $id)->delete();
                return true;
            }else if($status==3){

                 $rs=$this->getORM()->where('id', $id)->update(array("status"=>3));
                 return false;
            }

        }




  

}

?>