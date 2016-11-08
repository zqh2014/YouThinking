<?php
/**
 *  统一入口
 */

require_once dirname(__FILE__) . '/../init.php';

//装载你的接口
DI()->loader->addDirs(array('Library','MyApp'));
DI()->loginLite = new Login_Lite();

if(isset($_GET['debug_ic'])&&$_GET['debug_ic']){
	DI()->loginLite->m_debug = true;	//调试
}

/** ---------------- 响应接口请求 ---------------- **/

$api = new PhalApi();
$rs = $api->response();
$rs->output();

