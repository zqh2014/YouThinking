<?php
/**
 * 团队数据源类
 * 
 * - 用户模型
 * 
 * @author Qui
 */


class Model_Users extends PhalApi_Model_NotORM {

    protected function getTableName($id = null) {
        return 'users';
    }


     /**
     * key是否正确是否存在
     *  
     * @return bool  true匹配成功，false匹配失败
     * 
     */
    public function isJoinIn($domain,$key) {
        $domain = trim($domain);
        $key= trim($key);
    	if(empty($domain)||empty($key)){
    		return false;
    	}
        $num = $this->getORM()
            ->where('domain', $domain)
            ->where('`key`', $key)
            ->count('user_id');

        return $num > 0 ? true : false;
    }
}

?>