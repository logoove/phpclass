<?php
/*
 * 功能：
 *
 * Version: V1.0
 * By:yoby
 * date: 2018/10/16 14:48
 * Copyright (c) 2012-2018 http://www.hanett.com All rights reserved.
 *
*/
require_once 'PHPWord/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();
//读取文件
$file = __DIR__ . "/1.docx";
$word = \PhpOffice\PhpWord\IOFactory::load($file);

//增加图片
$image = __DIR__ . "/1.jpg";
$section = $word->addSection();
$section->addImage($image);

//生成文件
$name       = "HelloWorld.html";
$wordWriter = \PhpOffice\PhpWord\IOFactory::createWriter($word, "HTML");
$wordWriter->save($name);


