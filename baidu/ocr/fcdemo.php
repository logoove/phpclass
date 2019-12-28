<?php
/**
 * 功能.识别身份证和银行卡的文字识别服务
 * User: Yoby logove@qq.com
 * Date: 2019/5/22 21:18
 * wechat: logove
 */
require_once "./AipNlp.php";

// 你的 APPID AK SK
const APP_ID = '16975883';
const API_KEY = 'FkL4sKNN5uia8nsUavaCKMpm';
const SECRET_KEY = 'rqjIUVOEiacMbvELDsbPDztKYwMalPZ4';

$client = new AipNlp(APP_ID, API_KEY, SECRET_KEY);
$text = "长沙雨花经济开发区管理委员会";

// 调用词法分析
$data = $client->lexer($text);
dump($data);