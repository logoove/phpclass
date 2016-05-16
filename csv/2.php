<?php
//导入 by yoby
header("Content-Type: text/html; charset=UTF-8");
include "csv.php";
$path = '1.csv';
$csv = new csv();
$import_arr = $csv->import($path);
//$csv->dump($import_arr);//显示数组  1
//echo $csv->show(200,'导入成功',$import_arr);//导出json 2
echo $csv->show(200,'导入成功',$import_arr,'xml');//导出xml  3
//echo $csv->show(200,'导入成功',$import_arr,'array');//调试数组 同1
