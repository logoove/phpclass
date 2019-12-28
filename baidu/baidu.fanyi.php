<?php
/**
 * Description: 百度翻译.
 * Author: yoby
 * DateTime: 2019/2/17 23:36
 * Email:logove@qq.com
 * Copyright Yoby版权所有
 */

define("URL",            "https://fanyi-api.baidu.com/api/trans/vip/translate");
define("APP_ID",         "20160111000008800"); //替换为您的APPID
define("SEC_KEY",        "IwRILsfSuzMTJnmaRJKM");//替换为您的密钥


function buildSign($query, $appID, $salt, $secKey)
{/*{{{*/
    $str = $appID . $query . $salt . $secKey;
    $ret = md5($str);
    return $ret;
}
/*
 * POST或GET的curl请求
 * $url 请求地址
 * $data 请求数组
 * */
function curl($url,$data = ''){
    $ch = curl_init();
    if (class_exists('\CURLFile'))
    {
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
    }
    else
    {
        if (defined('CURLOPT_SAFE_UPLOAD'))
        {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        }
    }
    preg_match('/https:\/\//', $url) ? $ssl = TRUE : $ssl = FALSE;
    if ($ssl) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    if (!empty($data))
    {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $d = curl_exec($ch);
    curl_close($ch);
    return $d;
}

function translate($q,$from,$to){

    $args = [
      'q'=>$q,
        'salt' => rand(10000,99999),
       'from'=>$from,
        'to'=>$to,
        'appid'=>APP_ID

    ];
    $args['sign'] = buildSign($q, APP_ID, $args['salt'], SEC_KEY);
    $rs = curl(URL,$args);
    $rs = json_decode($rs,1);
    return $rs['trans_result'][0];

}

dump(translate("中国",'zh','en'));
