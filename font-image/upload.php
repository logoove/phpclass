<?php
/*
* 文件名: result.php
* 作者  : Yoby 微信logove email:logove@qq.com
* 日期时间: 2019/11/14  11:35
* 功能  :
*/
error_reporting(E_ALL);
require_once "image.php";

//image::watermarktext("./1.png",["我爱中国 I love China"],2,1,"#FFFFFF",20,0);
//image::watermarkimg("./1.png","./water.png",9,true);
//image::resize("1.png",200,200,true,false);
//image::gray("1.png",true,"2.png");
image::copy("1.png","1.gif",[50,50]);
