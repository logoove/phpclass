<?php
/*
* 文件名: resque.php
* 作者  : Yoby 微信logove email:logove@qq.com
* 日期时间: 2019/12/5  18:27
* 功能  :
*/
date_default_timezone_set('GMT');
require 'bad_job.php';
require 'job.php';
require 'php_error_job.php';

require __DIR__ . '/vendor/autoload.php';
