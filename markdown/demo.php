<?php
/**
 * Description:md文件解析演示.
 * Author: yoby
 * DateTime: 2019/2/17 23:10
 * Email:logove@qq.com
 * Copyright Yoby版权所有
 */

include "Markdown.class.php";

$m = new Markdown();

$s = file_get_contents("../README.md");

echo $m->setMarkupEscaped(true)->text($s);