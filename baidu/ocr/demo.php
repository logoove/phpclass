<?php
/**
 * 功能.识别身份证和银行卡的文字识别服务
 * User: Yoby logove@qq.com
 * Date: 2019/5/22 21:18
 * wechat: logove
 */
require_once "./AipOcr.php";

// 你的 APPID AK SK
const APP_ID = '16319885';
const API_KEY = 'vZpMCEhMarHLHyKcBFdgGNOe';
const SECRET_KEY = '521zhZoyGEkmdMxYb3BdNZNE5gXRQjkD';

$client = new AipOcr(APP_ID, API_KEY, SECRET_KEY);
$type = (empty($_GET['type']))?1:$_GET['type'];
if($type==1) {
    $image = file_get_contents('1.jpg');
    $idCardSide = "front";//正面  反面back
// 如果有可选参数
    $options = array();
    $options["detect_direction"] = "true";//检测方向
    $options["detect_risk"] = "false";//是否开启风险类型

// 带参数调用身份证识别
    $data = $client->idcard($image, $idCardSide, $options);//返回的json

    dump($data);
}elseif($type==2){
    $image = file_get_contents('23.jpg');
    $data = $client->bankcard($image);
    dump($data);
}