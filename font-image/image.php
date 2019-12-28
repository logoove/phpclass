<?php
/*
* 文件名: image.php
* 作者  : Yoby 微信logove email:logove@qq.com
* 日期时间: 2019/11/16  10:55
* 功能  :图片处理,包括剪裁,缩略图,水印,上传下载等与图片有关
*/

class image
{
    static public $filetype=[1=>'gif',2=>'jpeg',3=>'png',18=>'webp'];
    function __construct() {
    }
    public static function root(){
        return str_replace("\\", '/', dirname(__FILE__));
}
    //十六进制转换rgb
  public static  function hex2rgb($hexColor) {
        $color = str_replace('#', '', $hexColor);

        if (strlen($color) > 3) {

            $rgb = array(hexdec(substr($color, 0, 2)),hexdec(substr($color, 2, 2)),hexdec(substr($color, 4, 2)));
        } else {

            $color = $hexColor;

            $r = substr($color, 0, 1) . substr($color, 0, 1);

            $g = substr($color, 1, 1) . substr($color, 1, 1);

            $b = substr($color, 2, 1) . substr($color, 2, 1);

            $rgb = [hexdec($r),hexdec($g),hexdec($b)];
        }

        return $rgb;
    }
    //创建目录
  public static  function mkdirs($path)
    {
        if (!is_dir($path)) {
            self::mkdirs(dirname($path));
            mkdir($path);
        }

        return is_dir($path);
    }
    //输出文件
    public static function putfile($filename, $data) {
        self::mkdirs(dirname($filename));
        file_put_contents($filename, $data);
        return is_file($filename);
    }
    /*
    base64编码上传
    $path:路径.表示当前目录,或者使用绝对路径
    $data base64编码
    */
    public static function upload64($path,$data){
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data, $result)) {
            $type = ".".$result[2];
            $path2=md5(uniqid()).$type;
            $path1  =(substr($path,0,1)=='.')?$path."/".$path2:$path2;
        }
        $img =  base64_decode(str_replace($result[1], '', $data));
        self::putfile($path1, $img);
        return $path1;
    }
    /*
     * 添加图片水印
     * $src 图片路径
     * $water 水印 最好png透明
     * $point 位置 0是平铺整张图,1-9是位置
     * $isout 是否输出
     * $alpha 透明度0-127 127不透明
     ** $new 新文件名字,不会覆盖原图,必须是不输出才有效
     * */
    public static function waterMarkImg($src,$water="./water.png",$point=0,$isout=TRUE,$alpha=90,$new=""){
$img1=getimagesize($src);
$img2=getimagesize($water);
$type=self::$filetype[$img1[2]];
$type2=self::$filetype[$img2[2]];
$fun = "imagecreatefrom{$type}";
$im = $fun("$src");
$fun = "imagecreatefrom{$type2}";
$watermark = $fun("$water");
$width=$img1[0];
$width=$width-10;
$height=$img1[1];
$height=$height-10;
$w=$img2[0];
$h=$img2[1];
if($width<$w || $height<$h){//什么也不做
    return false;
}
        $simg = imagecreatetruecolor($w, $h);
$color=imagecolorallocate($simg,255,255,255);
        imagecolortransparent($simg,$color);
        imagefill( $simg, 0, 0, $color );
        imagealphablending($simg, true);
        imagesavealpha($simg , true);
        imagecopyresized($simg, $watermark, 0, 0, 0, 0,$w, $h, $w, $h);
if($point==0) {
    $color = imagecolorallocate($im, 255, 255, 255);
    imagecolortransparent($im, $color);
    imagefill($im, 0, 0, $color);
    imagealphablending($im, true);
    imagesavealpha($im, true);
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            imagecopymerge($im, $simg, $x, $y, 0, 0, $w, $h, $alpha);
            $y += $h;
        }
        $x += $w;
    }
}else {
    switch ($point) {
        case 1:
            $x = +5;
            $y = +5;
            break;
        case 2:
            $x = ($width - $w) / 2;
            $y = +5;
            break;
        case 3:
            $x = $width - $w - 5;
            $y = +15;
            break;
        case 4:
            $x = +5;
            $y = ($height - $h) / 2;
            break;
        case 5:
            $x = ($width - $w) / 2;
            $y = ($height - $h) / 2;
            break;
        case 6:
            $x = $width - $w - 5;
            $y = ($height - $h) / 2;
            break;
        case 7:
            $x = +5;
            $y = $height - $h - 5;
            break;
        case 8:
            $x = ($width - $w) / 2;
            $y = $height - $h - 5;
            break;
        case 9:
            $x = $width - $w - 5;
            $y = $height - $h - 5;
            break;
        default:
            die("此位置不支持");
            exit;
    }
    $color = imagecolorallocate($im, 255, 255, 255);
    imagecolortransparent($im, $color);
    imagefill($im, 0, 0, $color);
    imagealphablending($im, true);
    imagesavealpha($im, true);
    imagecopy($im, $simg, $x, $y, 0, 0, $w, $h);
}
        if($isout){
            header('Content-type:'.$img1['mime']);
            $func = "image{$type}";
            $func($im);
        }else{
            $func = "image{$type}";
            $src=(!empty($new))?$new:$src;
            $func($im,$src);
        }
        imagedestroy($im);
        imagedestroy($watermark);
    }
    /*
     * 添加文字水印
     * $src 图片路径
     * $text 水印文本 数组形式
     * $point 水印位置1-8
     * $isout 是否输出到浏览器 true输出
     * $color 颜色
     * size 字体大小磅 默认14.5 相当于20px
     * $alpha 透明度 0不透明 127全透明
     * * $new 新文件名字,不会覆盖原图,必须是不输出才有效
    */
    public static function waterMarkText($src,$text=["中国人"],$point=8,$isout=TURE,$color="#FF0000",$size="14.5",$alpha=0,$new=""){
        $info = getimagesize($src);
        $type=self::$filetype[$info[2]];
        $width=$info[0];
        $height=$info[1];
        $fun = "imagecreatefrom{$type}";
        $image = $fun("$src");

        $textLength = count($text) - 1;
        $maxtext = 0;
        foreach ($text as $val) {
            $maxtext = strlen($val) > strlen($maxtext) ? $val : $maxtext;
        }
        $textSize = imagettfbbox($size, 0, self::root()."/zk.ttf", $maxtext);
        $textWidth = $textSize[2] - $textSize[1]; //文字的最大宽度
        $textHeight = $textSize[1] - $textSize[7]; //文字的高度
        $lineHeight = $textHeight + 3; //文字的行高
        //是否可以添加文字水印 只有图片的可以容纳文字水印时才添加
        if ($textWidth + 40 > $width || $lineHeight * $textLength + 40 > $height) {
            return false;
        }
        if ($point == 1) { //左上角
            $porintLeft = 20;
            $pointTop = 20;
        } elseif ($point == 2) { //上中部
            $porintLeft = floor(($width - $textWidth) / 2);
            $pointTop = 20;
        } elseif ($point == 3) { //右上部
            $porintLeft = $width - $textWidth - 20;
            $pointTop = 20;
        } elseif ($point == 4) { //左中部
            $porintLeft = 20;
            $pointTop = floor(($height - $textLength * $lineHeight) / 2);
        } elseif ($point == 5) { //正中部
            $porintLeft = floor(($width - $textWidth) / 2);
            $pointTop = floor(($height - $textLength * $lineHeight) / 2);
        } elseif ($point == 6) { //右中部
            $porintLeft = $width - $textWidth - 20;
            $pointTop = floor(($height - $textLength * $lineHeight) / 2);
        } elseif ($point == 7) { //左下部
            $porintLeft = 20;
            $pointTop = $height - $textLength * $lineHeight - 20;
        } elseif ($point == 8) { //中下部
            $porintLeft = floor(($width - $textWidth) / 2);
            $pointTop = $height - $textLength * $lineHeight - 20;
        } elseif ($point == 9) { //右下部
            $porintLeft = $width - $textWidth - 20;
            $pointTop = $height - $textLength * $lineHeight - 20;
        }
        $color1 = imagecolorallocate($image, 255, 255, 255);
        imagecolortransparent($image, $color1);
        imagefill($image, 0, 0, $color1);
        imagealphablending($image, true);
        imagesavealpha($image, true);
       $color= self::hex2rgb($color);
        foreach ($text as $key => $val) {
            imagettftext($image, $size, 0, $porintLeft, $pointTop+ $key * $lineHeight, imagecolorallocatealpha($image, $color[0], $color[1], $color[2],$alpha), self::root() . "/zk.ttf", $val);
        }
        if($isout){
            header('Content-type:'.$info['mime']);
            $func = "image{$type}";
            $func($image);
        }else{
            $func = "image{$type}";
            $src=(!empty($new))?$new:$src;
            $func($image,$src);
        }
        imagedestroy($image);
    }
    /*
     * 缩放图片,按照比例
     * $src原图片
     * $w缩放宽度,如果是等比的话,将会按照宽高值
     * $isout 是否输出,默认是输出到浏览器
     * $isscale 是否按照比例,如果按照比例,会根据比例,否则按照给定宽高
     * * $new 新文件名字,不会覆盖原图,必须是不输出才有效
     * */
    public static function resize($src,$w,$h,$isout=TRUE,$isscale=TRUE,$new=""){
        $info = getimagesize($src);
        $type=self::$filetype[$info[2]];
        $width=$info[0];
        $height=$info[1];
        $fun = "imagecreatefrom{$type}";
        $image = $fun("$src");
        if($isscale==TRUE) {
            $scale = ($width / $w) > ($height / $h) ? ($width / $w) : ($height / $h);
            $w = floor($width / $scale);
            $h = floor($height / $scale);
        }
        $image1 = imagecreatetruecolor($w, $h);
        $color1 = imagecolorallocate($image1, 255, 255, 255);
        imagecolortransparent($image1, $color1);
        imagefill($image1, 0, 0, $color1);
        imagealphablending($image1, true);
        imagesavealpha($image1, true);
        imagecopyresampled($image1, $image, 0, 0, 0, 0, $w, $h, $width, $height);
        if($isout){
            header('Content-type:'.$info['mime']);
            $func = "image{$type}";
            $func($image1);
        }else{
            $func = "image{$type}";
            $src=(!empty($new))?$new:$src;
            $func($image1,$src);
        }
        imagedestroy($image);
        imagedestroy($image1);
    }
    /*图片灰度处理
    *$src 图片
     *$isout 是否输出
     * $new 新文件名字,不会覆盖原图,必须是不输出才有效
    */
    public static function gray($src,$isout=TRUE,$new=''){
        $info = getimagesize($src);
        $type=self::$filetype[$info[2]];
        $fun = "imagecreatefrom{$type}";
        $image = $fun("$src");
        imagealphablending($image, true);
        imagesavealpha($image, true);
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        if($isout){
            header('Content-type:'.$info['mime']);
            $func = "image{$type}";
            $func($image);
        }else{
            $func = "image{$type}";
            $src=(!empty($new))?$new:$src;
            $func($image,$src);
        }
        imagedestroy($image);
    }
    /*合成图片
    $src是背景图
    $water 要合成图片,
    $pos 合成坐标默认左上角
    $isout 是否输出
    $new新文件名称
    */
    public static function copy($src,$water,$pos=[0,0],$isout=TRUE,$new=""){
        $img1=getimagesize($src);
        $img2=getimagesize($water);
        $type1=self::$filetype[$img1[2]];
        $width=$img2[0];
        $height=$img2[1];
        $type2=self::$filetype[$img2[2]];
        $fun = "imagecreatefrom{$type1}";
        $image = $fun("$src");
        $fun = "imagecreatefrom{$type2}";
        $watermark = $fun("$water");
        imagealphablending($image, true);
        imagesavealpha($image, true);
       //imagecopymerge($image, $watermark, $pos[0], $pos[1], 0, 0, $width, $height, $alpha);
       imagecopy($image, $watermark, $pos[0], $pos[1], 0, 0, $width, $height);
        if($isout){
            header('Content-type:'.$img1['mime']);
            $func = "image{$type1}";
            $func($image);
        }else{
            $func = "image{$type1}";
            $src=(!empty($new))?$new:$src;
            $func($image,$src);
        }
        imagedestroy($image);
        imagedestroy($watermark);
    }
}
