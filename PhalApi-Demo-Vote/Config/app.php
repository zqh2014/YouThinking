<?php
/**
 * 请在下面放置任何您需要的应用配置
 */

return array(

    /**
     * 应用接口层的统一参数
     */
    'apiCommonRules' => array(
        'sign' => array('name' => 'sign', 'require' => true),

        //登录信息
        'userId' => array(
            'name' => 'user_id', 'type' => 'int', 'default' => 0, 'require' => false,
        ),
        'token' => array(
            'name' => 'token', 'type' => 'string', 'default' => '', 'require' => false,
        ),
    ),

    'max_daily_vote_times' => 3,
);
