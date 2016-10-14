<?php
$config = array();

if(defined('SAE_TMP_PATH')){//判断是否SAE
$config['db']['host'] =SAE_MYSQL_HOST_M;
$config['db']['username'] = SAE_MYSQL_USER;
$config['db']['password'] = SAE_MYSQL_PASS;
$config['db']['port'] = SAE_MYSQL_PORT;
$config['db']['database'] =SAE_MYSQL_DB;
$config['temp'] =SAE_TMP_PATH;//临时目录
$config['ak'] = SAE_ACCESSKEY ;
$config['sk'] = SAE_SECRETKEY;

}else{
$config['db']['host'] = 'localhost';
$config['db']['username'] = 'root';
$config['db']['password'] = 'mysql';
$config['db']['port'] = '3306';
$config['db']['database'] = 'test';
$config['temp'] =dirname(__FILE__)."/cache/";//临时目录
}

$config['db']['charset'] = 'utf8';
$config['db']['pconnect'] = 0;
$config['db']['tablepre'] = 'ims_';

$config['wx']['appid'] = 'wxef5e62bfe14ed476';//微信APPID
$config['wx']['appsn'] = '4a85df1740a4ad5b60d0d80e3ad5662b';//微信APPSN
$config['domain'] = "http://".$_SERVER['HTTP_HOST']."/";//域名
?>