<?php
/*
 * 说明： 聚合短信发送接口
 *
 * 版本: V1.0 
 * 作者:  yoby
 * 微信: logove  邮箱: logove@qq.com
 * 日期: 2018/10/18 20:23
 * Copyright (c) 2018 Yoby 版权所有.
 *
*/
function post($url, $msg)
{
    $ch = curl_init();
    if (class_exists('\CURLFile')) {
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
    } else {
        if (defined('CURLOPT_SAFE_UPLOAD')) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        }
    }
    preg_match('/https:\/\//', $url) ? $ssl = TRUE : $ssl = FALSE;
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($ssl) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
function json($code=200,$message='请求成功',$list=[],$total=0){
    $json = array(
        'code'=>$code,
        'msg'=>$message,
        'data'=>$list,
        'totl'=>$total
);
    exit(json_encode($json));
}

function juhe_sms($mobile,$key,$mid,$tpl){
    $url = 'http://v.juhe.cn/sms/send';
    $arr = array(
        'key'   => $key,
        'mobile'    => $mobile,
        'tpl_id'    =>$mid,
        'tpl_value' =>$tpl
    );
    $content =post($url,$arr);
    if($content){
        $result = json_decode($content,true);
        $error_code = $result['error_code'];
        if($error_code == 0){
            //状态为0，说明短信发送成功
            json(200,'短信发送成功');
        }else{
            //状态非0，说明失败
            $msg = $result['reason'];
            json(400,$msg);
        }
    }else{
        //返回内容异常，以下可根据业务逻辑自行修改
        json(400,'发送短信异常');
    }

}

//juhe_sms('18291448866','123','100405','#code#='.$code);