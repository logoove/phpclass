<?php
/*
* 文件名: demo.php
* 作者  : Yoby 微信logove email:logove@qq.com
* 日期时间: 2019/7/10  14:55
* 功能  :
*/
include "Music.class.php";
$api = new Music('netease');
$data = $api->format(1)->search('常回家看看',['page'=>1,"limit"=>20]);
$data = json_decode($data,1);
foreach( $data as $k=>$v){
    $data[$k]['artist']=$v['artist'];
    $data[$k]['music'] =json_decode($api->format(true)->url($v['id']),1)['url'];
    $data[$k]['pic'] = json_decode($api->format(true)->pic($v['pic_id']),1)['url'];
    $data[$k]['lyric'] = json_decode($api->format(true)->lyric($v['lyric_id']),1)['lyric'];
}
dump($data);
