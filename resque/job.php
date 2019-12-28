<?php
/*
* 文件名: job.php
* 作者  : Yoby 微信logove email:logove@qq.com
* 日期时间: 2019/12/5  18:25
* 功能  :
*/
class TestJob
{
    public function perform()
    {
        echo $this->args['name'];
    }
}
