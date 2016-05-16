<?php
include "csv.php";

$param_arr = array(
'nav'=>array('用户名','密码','邮箱'),
array(array('xiaohai1','123456','xiaohai1@zhongsou.com'),
   array('xiaohai2','213456','xiaohai2@zhongsou.com'),
   array('xiaohai3','123456','xiaohai3@zhongsou.com')
));
$csv = new csv($param_arr,'小说');
$csv->export();