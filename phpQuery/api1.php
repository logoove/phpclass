<?php
/**
 * Description: 抓取https://shuiyuezhouzhuang0512.fang.com/页面.
 * Author: yoby
 * DateTime: 2019/2/18 1:45
 * Email:logove@qq.com
 * Copyright Yoby版权所有
 */
set_time_limit (0);
require 'phpQuery.php';
header("Content-Type:text/html;charset=UTF-8");

function json_encode1($array)
{
    if(version_compare(PHP_VERSION,'5.4.0','<')){
        $str = json_encode($array);
        $str = preg_replace_callback("#\\\u([0-9a-f]{4})#i",function($matchs){
            return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
        },$str);
        return $str;
    }else{
        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }
}
/*xml转换成数组*/
function xml2arr($xml) {
    if (empty($xml)) {
        return array();
    }
    $result = array();
    $xmlobj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    if($xmlobj instanceof SimpleXMLElement) {
        $result = json_decode(json_encode($xmlobj), true);
        if (is_array($result)) {
            return $result;
        } else {
            return array();
        }
    } else {
        return $result;
    }
}
/*数组排序*/
function array_sort($array, $keys, $type='asc'){
    $keysvalue = $new_array = array();
    foreach ($array as $k => $v){
        $keysvalue[$k] = $v[$keys];
    }
    if($type == 'asc'){
        asort($keysvalue);
    }else{
        arsort($keysvalue);
    }
    reset($keysvalue);
    foreach ($keysvalue as $k => $v){
        $new_array[$k] = $array[$k];
    }
    return $new_array;
}
if (!function_exists('dump')) {
    function dump($arr)
    {
        echo '<pre>' . print_r($arr, TRUE) . '</pre>';
    }
}
/*表格转数组*/
function tableArr($table)
{
    $table = preg_replace("'<table[^>]*?>'si", "", $table);
    $table = preg_replace("'<tr[^>]*?>'si", "", $table);
    $table = preg_replace("'<td[^>]*?>'si", "", $table);
    $table = str_replace("</tr>", "{tr}", $table);
    $table = str_replace("</td>", "{td}", $table);
    //去掉 HTML 标记
    $table = preg_replace("'<[/!]*?[^<>]*?>'si", "", $table);
    //去掉空白字符
    $table = preg_replace("'([rn])[s]+'", "", $table);
    $table = preg_replace('/&nbsp;/', "", $table);
    $table = str_replace(" ", "", $table);
    $table = str_replace(" ", "", $table);
    $table = str_replace("\r", "", $table);
    $table = str_replace("\t", "", $table);
    $table = str_replace("\n", "", $table);
    $table = explode('{tr}', $table);
    array_pop($table);
    foreach ($table as $key => $tr) {
        $td = explode('{td}', $tr);
        array_pop($td);
        $td_array[] = $td;
    }
    return $td_array;
}
/*返回ajax状态*/
function json($code=200,$message='请求成功',$list=array(),$total=0){
    $json = array(
        'code'=>$code,
        'msg'=>$message
    );
    if(!empty($list)){
        $json['list'] = $list;
    }
    if(!empty($total)){
        $json['total'] = $total;
    }

    header('Content-type: application/json');
    exit(json_encode1($json));
}
/*下载图片需要传入文件名*/
function mkdirs($dir)
{
    if(!is_dir($dir))
    {
        if(!mkdirs(dirname($dir))){
            return false;
        }
        if(!mkdir($dir,0777)){
            return false;
        }
    }
    return true;
}
function downimg($img,$ico=''){
    global $url;
    $domain = "/gitee/phpclass/";
    $urls =  parse_url($url);
    $ico = empty($ico)?$urls['host']:$ico;
    $localSrc =rtrim("images/$ico/",'/').'/'.md5($img).'.'.pathinfo($img, PATHINFO_EXTENSION);
    $savePath = rtrim(dirname(__FILE__),'/').'/'.ltrim($localSrc,'/');
    mkdirs(dirname($savePath));
    $stream = @file_get_contents($img);
    file_put_contents($savePath,$stream);
    return $domain.$localSrc;
}
/*获取html并用正则处理*/
function get_content($url){
    $html = file_get_contents($url);
   // $html = file_get_contents("compress.zlib://".$url);
    $code= mb_detect_encoding($html, array("GB2312","GBK",'UTF-8','BIG5'));//获取编码
    if($code!="UTF-8"){
        $htmls =  mb_convert_encoding($html, "UTF-8", $code);//转换内容为UTF-8编码
    }else{
        $htmls = $html;
    }
    $htmls = preg_replace("/<script[\s\S]*?<\/script>/i","",$htmls,-1);//去除script
    $htmls = preg_replace("/<noscript[\s\S]*?<\/noscript>/i","",$htmls,-1);//去除noscript
    $htmls=preg_replace("/<(\/?link.*?)>/si","",$htmls);//去掉link
    $htmls=preg_replace("/<(style.*?)>(.*?)<(\/style.*?)>/si","",$htmls);//去掉style
    $htmls =preg_replace("/style=.+?['|\"]/i",'',$htmls,-1);//去除style行内样式
    $htmls =preg_replace('#<!--[^\!\[]*?(?<!\/\/)-->#' , '' , $htmls);//去掉html注释
    //$htmls = preg_replace("/<a[^>]*>(.*?)<\/a>/is", "$1", $htmls);//去除外站超链接
    $htmls =  preg_replace("/(\n\r)/i", '', $htmls); //去掉空行
    $htmls =  preg_replace("/<(input|textarea|select).*?>/i", '', $htmls); //去掉input/textarea/select



    return $htmls;
}
if (!function_exists('dump')) {
    function dump($arr){
        echo '<pre>'.print_r($arr,TRUE).'</pre>';
    }

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

$url = isset($_GET['url'])?$_GET['url']:"http://news.cctv.com/2019/02/17/ARTIHWAx0zEs6A4uEGPmTX44190217.shtml?from=singlemessage";//抓取页面

$domain = "http://".$_SERVER['HTTP_HOST']."/gitee/phpclass/";
$html = get_content($url);
preg_match('/<div class="text_area" id="text_area" >.*?<div class="text_02">/ism', $html, $rs);
$htmls = $rs[0];

$data= QueryList::Query($html,array(
    'title' => array('.title_area h1','text'),
    "time"=>array(".info",'text','',function($s){
        $s = preg_replace("/\s+/", "", $s);
        return trim($s);
    }),
    "img"=>array(".text_area","html",'',function($s){
        $doc = phpQuery::newDocumentHTML($s);
        $imgs = pq($doc)->find('img');
        foreach ($imgs as $img) {
            $src =pq($img)->attr('src');
            $path[] =  downimg($src);
        }
        return $path;

    })

))->getData();

dump($data);