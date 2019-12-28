<?php
/*
* 文件名: quere.php
* 作者  : Yoby 微信logove email:logove@qq.com
* 日期时间: 2019/12/5  18:26
* 功能  :
*/
if(empty($argv[1])) {
    die('Specify the name of a job to add. e.g, php queue.php PHP_Job');
}

require __DIR__ . '/vendor/autoload.php';
date_default_timezone_set('GMT');
Resque::setBackend('127.0.0.1:6379');

$names = [
    '李灵黛','冷文卿','阴露萍','柳兰歌','秦水支','李念儿','文彩依','柳婵诗','顾莫言','任水寒','金磨针','丁玲珑','凌霜华','水笙','景茵梦','容柒雁','林墨瞳','华诗','千湄','剑舞','兰陵',' 洛离'
];
foreach($names as $name){
    $jobId = Resque::enqueue('default', 'TestJob', ['name' => $name]);
    echo "Queued job " . $jobId . "\n\n";
}
