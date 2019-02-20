<?php
/**
 * Description: PhpStorm.
 * Author: yoby
 * DateTime: 2019/2/20 15:31
 * Email:logove@qq.com
 * Copyright Yoby版权所有
 */
$str = php_strip_whitespace ("global.php");
file_put_contents("global.min.php",$str);