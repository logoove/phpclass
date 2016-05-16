<?php
include("crXml.php");
//用来生成RSS的例子
$rss = new crXml();
$rss->rss["version"] = "2.0";
$rss->rss->channel->title="标题";
$rss->rss->channel->description=(object)"描述";
$rss->rss->channel->link="http://www.baidu.com";
$rss->rss->channel->language="zh-CN";
$rss->rss->channel->pubDate=date("c",time());
$rss->rss->channel->image->link="http://www.baidu.com";
$rss->rss->channel->image->url="http://www.baidu.com/img/baidu_jgylogo3.gif";
$rss->rss->channel->image->title="标题";
$rss->rss->channel->image->description=(object)"描述";
$arr[] = array(
'id'=>1,
'title'=>'标题就是我',
'type'=>'分类',
'content'=>'我就是内容',
);
$arr[] = array(
'id'=>2,
'title'=>'标题就是我',
'type'=>'分类',
'content'=>'我就是内容',
);
$arr[] = array(
'id'=>3,
'title'=>'标题就是我',
'type'=>'分类',
'content'=>'我就是内容',
);
$arr[] = array(
'id'=>4,
'title'=>'标题就是我',
'type'=>'分类',
'content'=>'我就是内容',
);
foreach ($arr as $r){
$m=$r['id'];
$rss->rss->channel->item[$m-1]->title=$r['title'];
$rss->rss->channel->item[$m-1]->link="http://www.baidu.com?id=".$r['id'];
$rss->rss->channel->item[$m-1]->category=$r['type'];
$rss->rss->channel->item[$m-1]->description=(object)$r['content'];
$rss->rss->channel->item[$m-1]->pubDate = date("c",time());
$rss->rss->channel->item[$m-1]->author="作者";

}
echo $rss->xml();

