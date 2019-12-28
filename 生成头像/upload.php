<?php
/*
* 文件名: result.php
* 作者  : Yoby 微信logove email:logove@qq.com
* 日期时间: 2019/11/14  11:35
* 功能  :
*/
if (!function_exists('md')) {
    function md($path)
    {
        if (!is_dir($path)) {
            md(dirname($path));
            mkdir($path);
        }

        return is_dir($path);
    }
}
/**
 * @param 文件路径
 * @param $data 数据
 * @return bool
 */
if (!function_exists('putfile')) {
    function putfile($filename, $data) {
        md(dirname($filename));
        file_put_contents($filename, $data);
        return is_file($filename);
    }}
/*
 * 读取文件
 */
if (!function_exists('getfile')) {
    function getfile($filename) {
        if (!is_file($filename)) {
            return false;
        }
        return file_get_contents($filename);
    }}
/*
 * 生成图片base64图片
 */
/**
 * @param $path 路径不含最后/
 * @param $data base64数据
 */
function upimg64($path,$data){
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data, $result)) {
        $type = ".".$result[2];
        $path2=md5(uniqid()).$type;
        $path1  =$path."/".$path2;
    }
    $img =  base64_decode(str_replace($result[1], '', $data));
    putfile($path1, $img);
    return $path2;
}
define('IA_ROOT', str_replace("\\", '/', dirname(__FILE__)));
$pic = $_POST['pic'];
$file = upimg64(IA_ROOT,$pic);
exit('{"status":1,"pic":"'.$file.'"}');
