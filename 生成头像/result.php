<?php
/*
* 文件名: result.php
* 作者  : Yoby 微信logove email:logove@qq.com
* 日期时间: 2019/11/14  11:35
* 功能  :
*/
function dump($arr){
    echo '<pre>'.print_r($arr,TRUE).'</pre>';
}
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
define('IA_ROOT', str_replace("\\", '/', dirname(__FILE__)));
$pic = empty($_GET['img'])?"images/TXA.jpg":$_GET['img'];//本地图片

$pics = IA_ROOT."/".$pic;//真实路径
$bj = empty($_GET['bj'])?6:$_GET['bj'];//要合成的背景
//本地的绝对路径
$dst_path =IA_ROOT."/images/A$bj.png";//背景图
$src_path= $pics; //头像
$type= getimagesize($src_path)['2'];

//生成新图片名
$image = IA_ROOT."/new/".$pic;
//创建图片的实例
$dst = imagecreatefrompng($dst_path);//水印
switch ($type) {
    case 1: $src = imagecreatefromgif($src_path); break;
    case 2: $src = imagecreatefromjpeg($src_path); break;
    case 3: $src = imagecreatefrompng($src_path); break;
}
$src1= imagecreatetruecolor(600, 600);
list($width, $height) = getimagesize($src_path);
imagecopyresampled($src1,$src,0,0,0,0,600,600,$width,$height);
imagecopyresized($src1, $dst, 0,0, 0, 0,600,600,600,600);
//输出图片
$mime = getimagesize($src_path)['mime'];
header("Content-Type:$mime");
switch ($type) {
    case 1://GIF
        imagegif($src1);
        break;
    case 2://JPG
        imagejpeg($src1);
        break;
    case 3://PNG
        imagepng($src1);
        break;
    default:
        break;
}
imagedestroy($dst);
imagedestroy($src);
