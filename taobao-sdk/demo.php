<?php
/*
* 文件名: demo.php
* 作者  : Yoby 微信logove email:logove@qq.com
* 日期时间: 2019/6/4  11:14
* 功能  :
*/
include "TopSdk.php";
$appkey = "27594003";
$secret = "27bb65fde25687b022ad91a9a2a9339c";

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;
$req = new TbkItemGetRequest;
$req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
$req->setQ("女装");
$req->setCat("16,18");
$resp = $c->execute($req);
dump($resp);
