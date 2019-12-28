<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
ini_set('display_errors', '1');
error_reporting(E_ALL ^ E_NOTICE);
set_time_limit(0);

ob_start();
define('IA_INSTALL_ROOT', str_replace("\\",'/', dirname(__FILE__)));
define('COOKIE_PRE', 'we7install_');
define('API_HOST', 'http://api.w7.cc');
define('API_SITE_REGISTER_EXIST', API_HOST . '/site/register/exist');
define('API_OAUTH_LOGIN_URL', API_HOST . '/oauth/login-url/index');
define('API_OAUTH_ACCESSTOKEN', API_HOST . '/oauth/access-token/code');
define('API_GET_PACKAGE_MD5_AND_CHUNKTOTAL', API_HOST . '/util/package/install');
define('API_GET_CHUNK_PACKAGE', API_HOST . '/util/package/install');
define('API_OAUTH_REGISTER_SITE', API_HOST . '/site/register/index');
//todo 更名
define('API_UPDATE_SITENAME', API_HOST . '/site/register/rename');

$actions = array('check_site', 'oauth', 'environment', 'install', 'chunktotal', 'download_percent', 'download', 'install', 'register_callback', 'login');
$action = trim($_GET['step']);
$action = in_array($action, $actions) ? $action : '';

if (file_exists(IA_INSTALL_ROOT . '/data/install.lock') && !in_array($action, array('oauth', 'login'))) {
	header('location: ./index.php');
	exit;
}
$is_https = $_SERVER['SERVER_PORT'] == 443 ||
(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') ||
strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https' ||
strtolower($_SERVER['HTTP_X_CLIENT_SCHEME']) == 'https'
	? true : false;
$sitepath = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$sitepath = str_replace('/install.php', '', $sitepath);
$siteroot = ($is_https ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $sitepath;
$cdn_source_file = 'https://cdn.w7.cc/download/install.zip?v=' . time();

$accesstoken = we7_get_accesstoken();
$registered_site = we7_getcookie('registered_site');
if (empty($accesstoken) && !$registered_site && $action != 'register_callback') {
	$action = 'check_site';
}

if ($action == 'check_site') {
	$data = we7_request_api(API_SITE_REGISTER_EXIST, array('url' => $siteroot));
	if (!empty($data) && $data['status'] == 1) {
		we7_setcookie('registered_site', 1);
		we7_setcookie('ims_family', in_array($data['family'], array('l', 'v', 's', 'x')) ? $data['family'] : 'v');
		header('Location: ' . $siteroot . '/install.php');
		exit();
	} else {
		$action = 'oauth';
	}
}

if ($action == 'oauth') {
	$code = trim($_GET['code']);
	if (empty($code)) {
		$url = $siteroot . '/install.php?step=oauth';
		$callback = urlencode($url);
		$data = we7_request_api(API_OAUTH_LOGIN_URL,array('redirect' => $callback));
		if (is_array($data) && isset($data['error'])) {
			exit(we7_error(400, '请重新登录.'));
		}
		$forward = $data['url'];
		header('Location: ' . $forward);
		exit();
	} else {
		$data = we7_request_api(API_OAUTH_ACCESSTOKEN, array('code' => $code));
		if (is_array($data) && isset($data['error'])) {
			exit(we7_error(400, '获取accesstoken失败，请重新登录.'));
		}
		we7_setcookie('accesstoken', $data);
		header('Location: ' . $siteroot . '/install.php');
		exit();
	}
}

if($action == 'environment') {
	$server['upload'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow';
	$server['upload'] = strtolower($server['upload']);
	if ($server['upload'] == 'unknow' || !strstr($server['upload'], 'm')) {
		$ret['upload']['failed'] = true;
		$ret['upload']['name'] = '上传限制';
		$ret['upload']['result'] = $server['upload'];
	}
	if(version_compare(PHP_VERSION, '5.3.0') == -1) {
		$ret['version']['failed'] = true;
		$ret['version']['name'] = 'PHP版本';
		$ret['version']['result'] = PHP_VERSION;
	}
	if(version_compare(PHP_VERSION, '7.0.0') == -1 && version_compare(PHP_VERSION, '5.6.0') >= 0) {
		$ret['always_populate_raw_post_data']['failed'] = @ini_get('always_populate_raw_post_data') != '-1';
		$ret['always_populate_raw_post_data']['name'] = 'always_populate_raw_post_data配置';
		$ret['always_populate_raw_post_data']['result'] = @ini_get('always_populate_raw_post_data');
		$ret['always_populate_raw_post_data']['handle'] = 'https://bbs.w7.cc/thread-33148-1-1.html';
	}

	if (!we7_network_enable($_SERVER['SERVER_NAME'])) {
		$ret['network_enabled']['failed'] = true;
		$ret['network_enabled']['name'] = '外网可访问性';
		$ret['network_enabled']['result'] = '外网不可访问';		
	}

	$ret['fopen']['ok'] = @ini_get('allow_url_fopen') && function_exists('fsockopen');
	if(!$ret['fopen']['ok']) {
		$ret['fopen']['failed'] = true;
		$ret['fopen']['name'] = 'fopen';
		$ret['fopen']['result'] = '不支持fopen';
	}

	$ret['dom']['ok'] = class_exists('DOMDocument');
	if(!$ret['dom']['ok']) {
		$ret['dom']['failed'] = true;
		$ret['dom']['name'] = 'DOMDocument';
		$ret['dom']['result'] = '没有启用DOMDocument';
	}

	$ret['session']['ok'] = ini_get('session.auto_start');
	if(!empty($ret['session']['ok']) && strtolower($ret['session']['ok']) == 'on') {
		$ret['session']['failed'] = true;
		$ret['session']['name'] = 'session.auto_start开启';
		$ret['session']['result'] = '系统session.auto_start开启';
	}

	$ret['asp_tags']['ok'] = ini_get('asp_tags');
	if(!empty($ret['asp_tags']['ok']) && strtolower($ret['asp_tags']['ok']) == 'on') {
		$ret['asp_tags']['failed'] = true;
		$ret['asp_tags']['name'] = 'asp_tags';
		$ret['asp_tags']['result'] = 'asp_tags开启状态';
	}

	$ret['root']['ok'] = local_writeable(IA_INSTALL_ROOT);
	if(!$ret['root']['ok']) {
		$ret['root']['failed'] = true;
		$ret['root']['name'] = '本地目录写入';
		$ret['root']['result'] = '本地目录无法写入';
	}
	$ret['data']['ok'] = local_writeable(IA_INSTALL_ROOT . '/data');
	if(!$ret['data']['ok']) {
		$ret['data']['failed'] = true;
		$ret['data']['name'] = 'data目录写入';
		$ret['data']['result'] = 'data目录无法写入';
	}
	
	foreach (we7_need_extension() as $extension) {
		$if_ok = extension_loaded($extension);
		if (!$if_ok) {
			$ret[$extension]['failed'] = true;
			$ret[$extension]['name'] = $extension . '扩展';
			$ret[$extension]['result'] = '不支持' . $extension;
		}
	}

	$result = array();
	foreach($ret as $key => $value) {
		if(version_compare(PHP_VERSION, '7.0.0') >= 0 && in_array($key, array('mcrypt', 'always_populate_raw_post_data'))) {
			continue;
		}
		if($value['failed']) {
			$value['handle'] = !empty($value['handle']) ? $value['handle'] : 'https://bbs.we7.cc/thread-3564-1-1.html';
			$result[] = $value;
		}
	}
	if (empty($result)) {
		exit(we7_error(0, 'success'));
	} else {
		exit(we7_error(434, $result));
	}
}

if ($action == 'chunktotal') {
	if ($registered_site ==1) {
		we7_setcookie('chunk_total', 1);
		exit(we7_error(0, array('total' => 1)));
	}
	$data = we7_request_api(API_GET_PACKAGE_MD5_AND_CHUNKTOTAL, array('access_token' => $accesstoken));
	if (is_array($data) && isset($data['error'])) {
		if ($data['error'] == 401) {
			exit(we7_error(433, 'accesstoken expired.'));
		} else {
			exit(we7_error(400, $data['error']));
		}
	} else {
		we7_setcookie('package_md5', $data['md5']);
		we7_setcookie('chunk_total', $data['chunk_total']);
		exit(we7_error(0, array('total' => $data['chunk_total'])));
	}
}

if ($action == 'download_percent') {
	clearstatcache();
	$source_size = we7_getcookie('cdn_source_size');
	if (empty($source_size)) {
		$header_array = get_headers($cdn_source_file, 1);
		$source_size = $header_array['Content-Length'];
		we7_setcookie('cdn_source_size', $source_size);
	}
	$download_size = filesize('./we7source.zip');
	$result = intval(($download_size / $source_size) * 100);
	exit(we7_error(0, $result));
}
if ($action == 'download') {
	$chunk_num = max(1, intval($_POST['chunk']));
	$chunk_total = we7_getcookie('chunk_total');
	if (empty($chunk_total)) {
		exit(we7_error(432, '请先获取分卷总量.'));
	}

	if ($registered_site ==1) {
		$hostfile = fopen($cdn_source_file, 'rb');
		$fh = fopen("./we7source.zip", 'wb');
		while (!feof($hostfile)) {
			$output = fread($hostfile, 8192);
			fwrite($fh, $output);
		}
		fclose($hostfile);
		we7_handle_chunk();
	} else {
		if ($chunk_num == 1) {
			$hostfile = fopen($cdn_source_file, 'rb');
			$fh = fopen("./we7source.zip", 'wb');
			while (!feof($hostfile)) {
				$output = fread($hostfile, 8192);
				fwrite($fh, $output);
			}
			fclose($hostfile);
			we7_handle_chunk();
		}
	}
	exit(we7_error(0, $chunk_num));
	if ($chunk_num > $chunk_total) {
		exit(we7_error(400, 'chunk大于最大值'));
	}
	$filename = IA_INSTALL_ROOT . '/chunk_' . $chunk_num;
	$filesize = filesize($filename);
	if (file_exists($filename) && !empty($filesize)) {
		exit(we7_error(0, $chunk_num));
	}

	$post = array('access_token' => $accesstoken, 'chunk' => $chunk_num);
	$data = we7_request_api(API_GET_CHUNK_PACKAGE, $post);

	if (is_array($data) && isset($data['error'])) {
		if ($data['error'] == 401) {
			exit(we7_error(433, 'accesstoken expired.'));
		} else {
			exit(we7_error(400, $chunk_num));
		}
	}
	if (empty($data)) {
		exit(we7_error(400, $chunk_num));
	}
	$result = file_put_contents('./chunk_' . $chunk_num, $data);
	if ($result) {
		$finished = true;
		for ($i = 1; $i <= $chunk_total; $i++) {
			$chunk_i_filesize = filesize(IA_INSTALL_ROOT . '/chunk_' . $i);
			if (!file_exists(IA_INSTALL_ROOT . '/chunk_' . $i) || empty($chunk_i_filesize)) {
				$finished = false;
			}
		}
		if ($finished === true) {
			$handle_result = we7_handle_chunk();
			if ($handle_result !== true) {
				exit(we7_error(421, $handle_result));
			}
		}
		exit(we7_error(0, $chunk_num));
	} else {
		exit(we7_error(400, $chunk_num));
	}
}

if ($action == 'install') {
	//1.config
	if (!file_exists(IA_INSTALL_ROOT . '/data/config.php') || !empty($_POST)) {
		$server = trim($_POST['server']);
		$db_username = trim($_POST['username']);
		$db_password = trim($_POST['password']);
		$db_name = trim($_POST['name']);
		$db_prefix = trim($_POST['prefix']);
		$db_prefix = !empty($db_prefix) ? $db_prefix : 'ims_';
		$database_result = we7_build_config($server, $db_username, $db_password, $db_name, $db_prefix);
		if ($database_result !== true) {
			exit(we7_error(419, $database_result));
		}
	}

	//2.检测系统文件,若不存在,则去下载包
	$verfile = IA_INSTALL_ROOT . '/framework/version.inc.php';
	$dbfile = IA_INSTALL_ROOT . '/data/db.php';
	if (!(file_exists(IA_INSTALL_ROOT . '/index.php') && is_dir(IA_INSTALL_ROOT . '/web') && file_exists($verfile) && file_exists($dbfile))) {
		exit(we7_error(421, '安装包不完整.'));
	}

	//3.数据库
	if (!file_exists(IA_INSTALL_ROOT . '/data/db.lock')) {
		$database_result = we7_db();
		if ($database_result !== true) {
			exit(we7_error(420, $database_result));
		}
		touch(IA_INSTALL_ROOT . '/data/db.lock');
	}

	//4.注册站点
	if (!file_exists(IA_INSTALL_ROOT . '/data/install.lock') && !$registered_site) {
		$register_site_result = we7_register_site();
		if ($register_site_result !== true) {
			exit(we7_error(430, $register_site_result));
		}
	}

	//5.更新到最新版(现在每更新一个版本会发一个更新包，故此步暂屏蔽)
	// if (!file_exists(IA_INSTALL_ROOT . '/data/install.lock')) {
	// 	$install_result = we7_upgrade();
	// 	if ($install_result !== true) {
	// 		exit(we7_error(427, $install_result));
	// 	}
	// 	touch(IA_INSTALL_ROOT . '/data/install.lock');
	// }
	touch(IA_INSTALL_ROOT . '/data/install.lock');
	exit(we7_error(0, 'success'));
}

if ($action == 'login') {
	$sitename = trim($_POST['sitename']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	we7_finish();
	if ($sitename != $siteroot . '的站点') {
		$sitename_result = we7_update_sitename($sitename);
		if (!$sitename_result) {
			exit(we7_error(400, '修改站点名称失败.'));
		}
	}

	if ($username != 'admin' || $password != '123456') {
		$user_result = we7_update_user($username, $password);
		if (!$user_result) {
			exit(we7_error(400, '修改用户名密码失败.'));
		}
	}

	exit(we7_error(0, 'success'));
}

if ($action == 'register_callback') {
	$post = file_get_contents('php://input');
	$auth = @json_decode(base64_decode($post), true);
	if (!empty($auth['url']) && $auth['url'] == $siteroot) {
		define('IN_SYS', true);
		require IA_INSTALL_ROOT . '/framework/bootstrap.inc.php';
		$site = array('key' => $auth['key'], 'token' => $auth['token'], 'url' => $siteroot);
		setting_save($site, 'site');
		exit(we7_error(0, 'success'));
	}
	exit(we7_error(400, '数据错误.'));
}

header('content-type:text/html;charset=utf-8');
echo '<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>We7Install</title>
  <base href="' . $sitepath . '/install.php">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href=//cdn.w7.cc/we7-install/favicon.ico">
<link rel="stylesheet" href="//cdn.w7.cc/we7-install/styles.css?v=' . time() . '"></head>
<body>
  <app-root></app-root>
<script type="text/javascript" src="//cdn.w7.cc/we7-install/runtime.js?v=' . time() . '"></script><script type="text/javascript" src="//cdn.w7.cc/we7-install/polyfills.js?v=' . time() . '"></script><script type="text/javascript" src="//cdn.w7.cc/we7-install/main.js?v=' . time() . '"></script></body>
</html>';


function local_writeable($dir) {
	$writeable = 0;
	if(!is_dir($dir)) {
		@mkdir($dir, 0777);
	}
	if(is_dir($dir)) {
		if($fp = fopen("$dir/test.txt", 'w')) {
			fclose($fp);
			unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}

function local_salt($length = 8) {
	$strs = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklnmopqrstuvwxyz0123456789';
	$result = substr(str_shuffle($strs),mt_rand(0,strlen($strs)-($length + 1)),$length);
	return $result;
}

function local_config() {
	$cfg = <<<EOF
<?php
defined('IN_IA') or exit('Access Denied');

\$config = array();

\$config['db']['master']['host'] = '{db-server}';
\$config['db']['master']['username'] = '{db-username}';
\$config['db']['master']['password'] = '{db-password}';
\$config['db']['master']['port'] = '{db-port}';
\$config['db']['master']['database'] = '{db-name}';
\$config['db']['master']['charset'] = 'utf8';
\$config['db']['master']['pconnect'] = 0;
\$config['db']['master']['tablepre'] = '{db-tablepre}';

\$config['db']['slave_status'] = false;
\$config['db']['slave']['1']['host'] = '';
\$config['db']['slave']['1']['username'] = '';
\$config['db']['slave']['1']['password'] = '';
\$config['db']['slave']['1']['port'] = '3307';
\$config['db']['slave']['1']['database'] = '';
\$config['db']['slave']['1']['charset'] = 'utf8';
\$config['db']['slave']['1']['pconnect'] = 0;
\$config['db']['slave']['1']['tablepre'] = 'ims_';
\$config['db']['slave']['1']['weight'] = 0;

\$config['db']['common']['slave_except_table'] = array('core_sessions');

// --------------------------  CONFIG COOKIE  --------------------------- //
\$config['cookie']['pre'] = '{cookiepre}';
\$config['cookie']['domain'] = '';
\$config['cookie']['path'] = '/';

// --------------------------  CONFIG SETTING  --------------------------- //
\$config['setting']['charset'] = 'utf-8';
\$config['setting']['cache'] = 'mysql';
\$config['setting']['timezone'] = 'Asia/Shanghai';
\$config['setting']['memory_limit'] = '256M';
\$config['setting']['filemode'] = 0644;
\$config['setting']['authkey'] = '{authkey}';
\$config['setting']['founder'] = '1';
\$config['setting']['development'] = 0;
\$config['setting']['referrer'] = 0;

// --------------------------  CONFIG UPLOAD  --------------------------- //
\$config['upload']['image']['extentions'] = array('gif', 'jpg', 'jpeg', 'png');
\$config['upload']['image']['limit'] = 5000;
\$config['upload']['attachdir'] = '{attachdir}';
\$config['upload']['audio']['extentions'] = array('mp3');
\$config['upload']['audio']['limit'] = 5000;

// --------------------------  CONFIG MEMCACHE  --------------------------- //
\$config['setting']['memcache']['server'] = '';
\$config['setting']['memcache']['port'] = 11211;
\$config['setting']['memcache']['pconnect'] = 1;
\$config['setting']['memcache']['timeout'] = 30;
\$config['setting']['memcache']['session'] = 1;

// --------------------------  CONFIG PROXY  --------------------------- //
\$config['setting']['proxy']['host'] = '';
\$config['setting']['proxy']['auth'] = '';
EOF;
	return trim($cfg);
}

function local_mkdirs($path) {
	if(!is_dir($path)) {
		local_mkdirs(dirname($path));
		mkdir($path);
	}
	return is_dir($path);
}

function local_run($sql, $link, $db) {
	if(!isset($sql) || empty($sql)) return;

	$sql = str_replace("\r", "\n", str_replace(' ims_', ' '.$db['prefix'], $sql));
	$sql = str_replace("\r", "\n", str_replace(' `ims_', ' `'.$db['prefix'], $sql));
	$ret = array();
	$num = 0;
	foreach(explode(";\n", trim($sql)) as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0].$query[1] == '--') ? '' : $query;
		}
		$num++;
	}
	unset($sql);
	foreach($ret as $query) {
		$query = trim($query);
		if($query) {
			$link->exec($query);
			if($link->errorCode() != '00000') {
				$errorInfo = $link->errorInfo();
				echo $errorInfo[0] . ": " . $errorInfo[2] . "<br />";
				exit($query);
			}
		}
	}
}

function local_create_sql($schema, $local_create_sql) {
	$pieces = explode('_', $schema['charset']);
	$charset = $pieces[0];
	$engine = $local_create_sql ? $schema['engine'] : 'MyISAM';
	$sql = "CREATE TABLE IF NOT EXISTS `{$schema['tablename']}` (\n";
	foreach ($schema['fields'] as $value) {
		if(!empty($value['length'])) {
			$length = "({$value['length']})";
		} else {
			$length = '';
		}

		$signed = empty($value['signed']) ? ' unsigned' : '';
		if(empty($value['null'])) {
			$null = ' NOT NULL';
		} else {
			$null = '';
		}
		if(isset($value['default'])) {
			$default = " DEFAULT '" . $value['default'] . "'";
		} else {
			$default = '';
		}
		if($value['increment']) {
			$increment = ' AUTO_INCREMENT';
		} else {
			$increment = '';
		}

		$sql .= "`{$value['name']}` {$value['type']}{$length}{$signed}{$null}{$default}{$increment},\n";
	}
	foreach ($schema['indexes'] as $value) {
		$fields = implode('`,`', $value['fields']);
		if($value['type'] == 'index') {
			$sql .= "KEY `{$value['name']}` (`{$fields}`),\n";
		}
		if($value['type'] == 'unique') {
			$sql .= "UNIQUE KEY `{$value['name']}` (`{$fields}`),\n";
		}
		if($value['type'] == 'primary') {
			$sql .= "PRIMARY KEY (`{$fields}`),\n";
		}
	}
	$sql = rtrim($sql);
	$sql = rtrim($sql, ',');

	$sql .= "\n) ENGINE=$engine DEFAULT CHARSET=$charset;\n\n";
	return $sql;
}

function install_authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key != '' ? $key : $GLOBALS['_W']['config']['setting']['authkey']);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya . md5($keya . $keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for ($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for ($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for ($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if ($operation == 'DECODE') {
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc . str_replace('=', '', base64_encode($result));
	}

}

function we7_network_enable($host) {
	if (empty($host)) {
		return false;
	}
	$httphost_is_ip = preg_match('/^(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|[1-9])\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)$/', $host);
	if ($httphost_is_ip) {
		$if_local_network10 = preg_match('/^10\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)$/', $host);
		if ($if_local_network10) {
			return false;
		}
		$if_local_network172 = preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)$/', $host);
		if ($if_local_network172) {
			return false;
		}
		$if_local_network192 = preg_match('/^192\.168\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)\.(1\d{2}|2[0-4]\d|25[0-5]|[1-9]\d|\d)$/', $host);
		if ($if_local_network192) {
			return false;
		}
	} else {
		$dns_record = dns_get_record($host, DNS_A);
		if (empty($dns_record) || empty($dns_record[0]['ip']) || $dns[0]['ip'] == '127.0.0.1') {
			return false;
		}
	}
	return true;
}

function we7_need_extension() {
	return array('zip', 'pdo', 'pdo_mysql', 'openssl', 'gd', 'mbstring', 'mcrypt', 'curl');
}

function we7_get_accesstoken() {
	$cookie_accesstoken = we7_getcookie('accesstoken');
	$accesstoken = json_decode($cookie_accesstoken, true);
	if(!empty($accesstoken) && !empty($accesstoken['accessToken']) && $accesstoken['expireTime'] > time()) {
		return $accesstoken['accessToken'];
	}
	return '';
}

function we7_handle_chunk() {
	$tmpfile = "./we7source.zip";
	$result = false;
	if (file_exists($tmpfile)) {
		$zip = new ZipArchive;
		$res = $zip->open($tmpfile);
		if ($res === TRUE) {
			$zip->extractTo(IA_INSTALL_ROOT);
			$zip->close();
			$result = true;
		}
	}
	return $result;
}

/**
 * 生成config.php文件
 * @param $server
 * @param $db_username
 * @param $db_password
 * @param $db_name
 * @param $db_prefix
 * @return bool|false|string
 */
function we7_build_config($server, $db_username, $db_password, $db_name, $db_prefix) {
	if (empty($server) || empty($db_username) || empty($db_password) || empty($db_name)) {
		return false;
	}
	$pieces = explode(':', $server);
	$db = array(
		'server' => $pieces[0] == '127.0.0.1' ? 'localhost' : $pieces[0],
		'port' => !empty($pieces[1]) ? $pieces[1] : '3306',
		'username' => $db_username,
		'password' => $db_password,
		'prefix' => $db_prefix,
		'name' => $db_name,
	);

	try {
		$link = new PDO("mysql:host={$db['server']};port={$db['port']}", $db['username'], $db['password']); 	// dns可以没有dbname
		$link->exec("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary");
		$link->exec("SET sql_mode=''");
		if ($link->errorCode() != '00000') {
			$errorInfo = $link->errorInfo();
			$error = $errorInfo[2];
		} else {
			$statement = $link->query("SHOW DATABASES LIKE '{$db['name']}';");
			$fetch = $statement->fetch();
			if (empty($fetch)){
				if (substr($link->getAttribute(PDO::ATTR_SERVER_VERSION), 0, 3) > '4.1') {
					$link->query("CREATE DATABASE IF NOT EXISTS `{$db['name']}` DEFAULT CHARACTER SET utf8");
				} else {
					$link->query("CREATE DATABASE IF NOT EXISTS `{$db['name']}`");
				}
			}
			$statement = $link->query("SHOW DATABASES LIKE '{$db['name']}';");
			$fetch = $statement->fetch();
			if (empty($fetch)) {
				$error .= "数据库不存在且创建数据库失败.";
			}
			if ($link->errorCode() != '00000') {
				$errorInfo = $link->errorInfo();
				$error .= $errorInfo[2];
			}
		}
		$link->exec("USE {$db['name']}");
		$statement = $link->query("SHOW TABLES LIKE '{$db['prefix']}%';");
		if ($statement->fetch()) {
			return '您的数据库不为空，请重新建立数据库或是清空该数据库或更改表前缀！';
		}
	} catch (PDOException $e) {
		$error = $e->getMessage();
		if (strpos($error, 'Access denied for user') !== false) {
			$error = '您的数据库访问用户名或是密码错误.';
		} else {
			$error = iconv('gbk', 'utf8', $error);
		}
	}
	if (!empty($error)) {
		return $error;
	}

	$config = local_config();
	$cookiepre = local_salt(4) . '_';
	$authkey = local_salt(8);
	$config = str_replace(array(
		'{db-server}', '{db-username}', '{db-password}', '{db-port}', '{db-name}', '{db-tablepre}', '{cookiepre}', '{authkey}', '{attachdir}'
	), array(
		$db['server'], $db['username'], $db['password'], $db['port'], $db['name'], $db['prefix'], $cookiepre, $authkey, 'attachment'
	), $config);
	local_mkdirs(IA_INSTALL_ROOT . '/data');
	$result = file_put_contents(IA_INSTALL_ROOT . '/data/config.php', $config);
	return $result !== false ? true : false;
}

/**
 * 创建数据库
 * @return bool|string
 */
function we7_db() {
	global $is_https;
	define('IN_IA', true);
	require IA_INSTALL_ROOT . '/data/config.php';
	$db = array(
		'server' => $config['db']['master']['host'],
		'port' => $config['db']['master']['port'],
		'username' => $config['db']['master']['username'],
		'password' => $config['db']['master']['password'],
		'prefix' => $config['db']['master']['tablepre'],
		'name' => $config['db']['master']['database'],
	);
	$cookiepre = $config['cookie']['pre'];
	$authkey = $config['setting']['authkey'];

	$link = new PDO("mysql:dbname={$db['name']};host={$db['server']};port={$db['port']}", $db['username'], $db['password']);
	$link->exec("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary");
	$link->exec("SET sql_mode=''");

	$dbfile = IA_INSTALL_ROOT . '/data/db.php';
	if(file_exists(IA_INSTALL_ROOT . '/index.php') &&
		is_dir(IA_INSTALL_ROOT . '/web') &&
		file_exists(IA_INSTALL_ROOT . '/framework/version.inc.php') &&
		file_exists($dbfile)) {
		$dat = require $dbfile;
		if(empty($dat) || !is_array($dat)) {
			return '安装包不正确, 数据安装脚本缺失.';
		}

		$support_innodb = false;
		$engines = $link->query("SHOW ENGINES;");
		$all_engines = $engines->fetchAll();
		foreach ($all_engines as $engine) {
			if (strtolower($engine['Engine']) == 'innodb' && in_array(strtolower($engine['Support']), array('default', 'yes'))) {
				$support_innodb = true;
			}
		}

		foreach($dat['schemas'] as $schema) {
			$sql = local_create_sql($schema, $support_innodb);
			local_run($sql, $link, $db);
		}
		foreach($dat['datas'] as $data) {
			local_run($data, $link, $db);
		}
	} else {
		return '安装包不正确.';
	}

	//默认用户名密码
	$user = array('username' => 'admin', 'password' => '123456');
	$salt = local_salt(8);
	$password = sha1("{$user['password']}-{$salt}-{$authkey}");
	$link->exec("INSERT INTO {$db['prefix']}users (username, password, salt, joindate, groupid, status, founder_groupid) VALUES('{$user['username']}', '{$password}', '{$salt}', '" . time() . "', 1, 2, 1)");
	$cookie = array('lastvisit' => '', 'lastip' => '');
	$cookie['uid'] = $link->lastInsertId();
	$cookie['hash'] = md5($password . $salt);

	$session = install_authcode(json_encode($cookie), 'encode', $authkey);
	$secure = $is_https ? 1 : 0;
	setcookie("{$cookiepre}__session", $session, 0, '/', '', $secure, true);

	return true;
}

/**
 * 注册站点
 * @return bool|string
 */
function we7_register_site() {
	global $siteroot, $accesstoken;

	define('IN_IA', true);
	require IA_INSTALL_ROOT . '/framework/version.inc.php';
	$version = IMS_VERSION;
	$release = IMS_RELEASE_DATE;
	$callback = urlencode($siteroot . '/install.php?step=register_callback');
	$post = array(
		'access_token' => $accesstoken,
		'name' => $siteroot . '的站点',
		'url' => $siteroot,
		'version' => $version,
		'release' => $release,
		'callback' => $callback,
	);
	$data = we7_request_api(API_OAUTH_REGISTER_SITE, $post);

	if (is_array($data) && isset($data['error'])) {
		return $data['error'];
	} else {
		return true;
	}
}

/**
 * 执行安装升级
 * @return bool
 */
function we7_upgrade() {
	global $_W;
	define('IN_SYS', true);
	require IA_INSTALL_ROOT . '/framework/bootstrap.inc.php';
	require IA_INSTALL_ROOT . '/web/common/bootstrap.sys.inc.php';
	load()->model('cloud');
	load()->func('db');
	load()->func('file');

	$packet = cloud_build();
	if (empty($packet)) {
		return true;
	}

	//升级文件
	if (!empty($packet['files']) && is_array($packet['files'])) {
		foreach ($packet['files'] as $file) {
			cloud_download($file, 'files');
		}
	}
	//升级数据库
	if (!empty($packet['schemas']) && is_array($packet['schemas'])) {
		foreach ($packet['schemas'] as $schema) {
			$tablename = substr($schema['tablename'], 4);
			$local = db_table_schema(pdo(), $tablename);
			$sqls = db_table_fix_sql($local, $schema);
			foreach ($sqls as $sql) {
				pdo_query($sql);
			}
		}
	}
	//升级脚本
	if (!empty($packet['scripts']) && is_array($packet['scripts'])) {
		$updatefiles = array();
		$updatedir = IA_INSTALL_ROOT . '/data/update/';

		rmdirs($updatedir, true);
		mkdirs($updatedir);
		$cversion = IMS_VERSION;
		$crelease = IMS_RELEASE_DATE;
		foreach ($packet['scripts'] as $script) {
			if ($script['release'] <= $crelease) {
				continue;
			}
			$fname = "update({$crelease}-{$script['release']}).php";
			$crelease = $script['release'];
			$script['script'] = @base64_decode($script['script']);
			if (empty($script['script'])) {
				$script['script'] = <<<DAT
<?php
load()->model('setting');
setting_upgrade_version('{$packet['family']}', '{$script['version']}', '{$script['release']}');
return true;
DAT;
			}
			$updatefile = $updatedir . $fname;
			file_put_contents($updatefile, $script['script']);
			$updatefiles[] = $updatefile;
		}

		if (!empty($updatefiles)) {
			foreach ($updatefiles as $file) {
				if (!is_file($file) || !preg_match('/^update\(\d{12}\-\d{12}\)\.php$/', $file)) {
					continue;
				}
				$evalret = include $entry;
				if (!empty($evalret)) {
					cache_build_users_struct();
					cache_build_setting();
					@unlink($entry);
				}
			}
		}
	}

	return true;
}

function we7_update_sitename($sitename) {
	global $accesstoken, $_W;
	$site_info = setting_load('site');
	if (empty($site_info['site']) || empty($site_info['site']['key'])) {
		return '站点信息不存在，请重新注册站点.';
	}
	$data = we7_request_api(API_UPDATE_SITENAME, array('access_token' => $accesstoken, 'site_name' => $sitename, 'site_key' => $site_info['site']['key']));
	if (is_array($data) && isset($data['error'])) {
		return $data['error'];
	} else {
		return true;
	}
}

function we7_update_user($username, $password) {
	global $_W, $is_https;
	load()->model('user');
	$userinfo = pdo_get('users', array('username' => 'admin'));
	$password = user_hash($password, $userinfo['salt']);
	$result = pdo_update('users', array('username' => $username, 'password' => $password), array('uid' => $userinfo['uid']));
	//重写session
	$cookie = array('lastvisit' => '', 'lastip' => '');
	$cookie['uid'] = $userinfo['uid'];
	$cookie['hash'] = md5($password . $userinfo['salt']);

	$session = install_authcode(json_encode($cookie), 'encode', $_W['config']['setting']['authkey']);
	$secure = $is_https ? 1 : 0;
	setcookie($_W['config']['cookie']['pre'] . "__session", $session, 0, '/', '', $secure, true);
	return $result ? true : false;
}

/**
 * 重建站点缓存
 * @return bool
 */
function we7_finish() {
	global $_W;
	//全部删除文件包
	$chunk_num = we7_getcookie('chunk_total');
	@unlink('./we7source.zip');
	for ($i = 1; $i <= $chunk_num; $i++) {
		@unlink("./chunk_" . $i);
	}
	we7_setcookie('package_md5', '', -10);
	we7_setcookie('chunk_total', '', -10);
	@unlink(IA_INSTALL_ROOT . '/data/db.php');
	@unlink(IA_INSTALL_ROOT . '/data/db.lock');
	define('IN_SYS', true);
	require IA_INSTALL_ROOT . '/framework/bootstrap.inc.php';
	require IA_INSTALL_ROOT . '/web/common/bootstrap.sys.inc.php';
	$_W['uid'] = $_W['isfounder'] = 1;
	load()->web('common');
	load()->web('template');
	load()->model('setting');
	load()->model('cache');

	setting_upgrade_version(we7_getcookie('ims_family'), IMS_VERSION, IMS_RELEASE_DATE);
	we7_setcookie('ims_family', '', -10);
	cache_build_frame_menu();
	cache_build_setting();
	cache_build_users_struct();
	cache_build_module_subscribe_type();
	return true;
}

function we7_http_request($url, $post = array()) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

	$data = curl_exec($ch);
	$errno = curl_errno($ch);
	$error = curl_error($ch);
	curl_close($ch);
	if ($errno || empty($data)) {
		return array('errno' => $errno, 'error' => $error);
	} else {
		return we7_http_response_parse($data);
	}
}

function we7_http_response_parse($data) {
	$rlt = array();

	$pos = strpos($data, "\r\n\r\n");
	$split1[0] = substr($data, 0, $pos);
	$split1[1] = substr($data, $pos + 4, strlen($data));

	$split2 = explode("\r\n", $split1[0], 2);
	preg_match('/^(\S+) (\S+) (.*)$/', $split2[0], $matches);
	$rlt['code'] = !empty($matches[2]) ? $matches[2] : 200;
	$rlt['status'] = !empty($matches[3]) ? $matches[3] : 'OK';
	$rlt['responseline'] = !empty($split2[0]) ? $split2[0] : '';
	$header = explode("\r\n", $split2[1]);
	$isgzip = false;
	foreach ($header as $v) {
		$pos = strpos($v, ':');
		$key = substr($v, 0, $pos);
		$value = trim(substr($v, $pos + 1));
		if (is_array($rlt['headers'][$key])) {
			$rlt['headers'][$key][] = $value;
		} elseif (!empty($rlt['headers'][$key])) {
			$temp = $rlt['headers'][$key];
			unset($rlt['headers'][$key]);
			$rlt['headers'][$key][] = $temp;
			$rlt['headers'][$key][] = $value;
		} else {
			$rlt['headers'][$key] = $value;
		}
		if(!$isgzip && strtolower($key) == 'content-encoding' && strtolower($value) == 'gzip') {
			$isgzip = true;
		}
	}
	$rlt['content'] = $split1[1];
	if($isgzip && function_exists('gzdecode')) {
		$rlt['content'] = gzdecode($rlt['content']);
	}

	$rlt['meta'] = $data;
	if($rlt['code'] == '100') {
		return we7_http_response_parse($rlt['content']);
	}
	return $rlt;
}

function we7_request_api($url, $post = array()) {
	$response = we7_http_request($url, $post);

	if ($response['code'] == 401) {
		return array('error' => 401);
	}

	if ($response['code'] != 200 || isset($response['errno'])) {
		return array('error' =>$response['content']);
	}
	$result = json_decode($response['content'], true);
	if (is_array($result)) {
		return $result;
	} else {
		return $response['content'];
	}
}

function we7_error($num, $message = 'success') {
	$num = intval($num);
	return json_encode(array('errno' => $num, 'data' => $message));
}

function we7_setcookie($key, $value) {
	$secure = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
	if (is_array($value)) {
		$value = json_encode($value);
	}
	return setcookie(COOKIE_PRE . $key, $value, 0,'', '', $secure, true);
}

function we7_getcookie($key) {
	if (empty($key)) {
		return '';
	}
	$key = COOKIE_PRE . $key;
	return $_COOKIE[$key];
}