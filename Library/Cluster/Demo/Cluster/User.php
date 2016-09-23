<?php
/**
 * 初始化DB集群拓展 Domen演示层
 * @author: 喵了_个咪 <wenzhenxi@vip.qq.com> 2015-10-21
 */
class Cluster_User extends Cluster_Cluster_DB{
    /**
     * 获取集群实例类
     */
    public function getCluster(){
        return DI()->Cluster_DB;
    }

    /**
     * 获取主数据库表实例
     */
    public function getMainDB(){
        return DI()->notorm->user_base;
    }

    /**
     * 新加记录
     */
    public function setInfo($data){
        return $this->getORM()->insert($data);
    }

    /**
     * 查询记录
     */
    public function getInfo($id){
        return $this->getORM()->select('*')->where('uId', $id)->fetchAll();
    }

    /**
     * 修改记录
     */
    public function updateInfo($data, $id){
        return $this->getORM()->where('uId', $id)->update($data);
    }

    /**
     * 删除记录
     */
    public function delectInfo($id){
        return $this->getORM()->where('uId', $id)->delete();
    }
}
