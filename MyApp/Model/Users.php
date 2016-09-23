<?php
/**
 * 团队数据源类
 * 
 * - 用户
 * 
 * @author Qui
 */


class Model_Users extends PhalApi_Model_NotORM {

    protected function getTableName($id = null) {
        return 'users';
    }


     /**
     * key是否正确
     *  
     * @return bool  true匹配成功，false匹配失败
     * 
     */
    public function isJoinIn($domain,$key) {
    	if(empty(trim($domain))||empty(trim($key))){
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