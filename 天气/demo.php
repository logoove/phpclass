<?php

$version = 'v1';//v1: 7天
$ip = $_SERVER['REMOTE_ADDR'];
$url = 'https://www.tianqiapi.com/api/?version=' . $version . '&ip=' . $ip . '&appid=' . $appid . '&appsecret=' . $appsecret;
$data = file_get_contents($url);
$json = json_decode($data, true);
echo $json['city'] . '天气: ' . '<br>';
echo '更新时间: ' . $json['update_time'] . '<br>';
$list = $json['data'];
// 7天

for ($i = 0; $i < count($list); $i++) {
        echo $list[$i]['date'] . ' ' . $list[$i]['wea'] . ' ' . $list[$i]['tem1'] . '/' . $list[$i]['tem2'] . ' ' . $list[$i]['win'][0] . ' ' . $list[$i]['win_speed'] . '<br>';
    }
