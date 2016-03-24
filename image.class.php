<?
/*
    图片处理类：缩略，裁剪，圆角，倾斜
*/
class resizeimage
{
   //图片类型
   var $type;
   //实际宽度
   var $width;
   //实际高度
   var $height;
   //改变后的宽度
   var $resize_width;
   //改变后的高度
   var $resize_height;
   //是否裁图
   var $cut;
   //源图象
   var $srcimg;
   //目标图象地址
   var $dstimg;
   //圆角源
   var $corner;
   var $im;
  
function resizeimage($img, $corner, $wid, $hei,$c, $corner_radius, $angle)
   {
       $this->srcimg = $img;
           $this->corner = $corner;
       $this->resize_width = $wid;
       $this->resize_height = $hei;
       $this->cut = $c;
           $this->corner_radius = $corner_radius;
           $this->angle = $angle;
       //图片的类型
       $this->type = substr(strrchr($this->srcimg,"."),1);
       //初始化图象
       $this->initi_img();
       //目标图象地址
       $this -> dst_img();
       //--
       $this->width = imagesx($this->im);
       $this->height = imagesy($this->im);
       //生成图象
       $this->newimg();
       ImageDestroy ($this->im);
   }
   function newimg()
   {
       //改变后的图象的比例
       $resize_ratio = ($this->resize_width)/($this->resize_height);
       //实际图象的比例
       $ratio = ($this->width)/($this->height);
       if(($this->cut)=="1")
       //裁图
       {
           if($ratio>=$resize_ratio)
           //高度优先
           {
               $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
               imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);
                           $tmp = $this->rounded_corner($newimg,$this->resize_width);
               imagepng ($tmp,$this->dstimg);
           }
           if($ratio<$resize_ratio)
           //宽度优先
           {
               $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
               imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width)/$resize_ratio));
                           $tmp = $this->rounded_corner($newimg);
               imagepng ($tmp,$this->dstimg);
           }
       }
       else
       //不裁图
       {
           if($ratio>=$resize_ratio)
           {
               $newimg = imagecreatetruecolor($this->resize_width,($this->resize_width)/$ratio);
               imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width)/$ratio, $this->width, $this->height);
               ImageJpeg ($newimg,$this->dstimg);
           }
           if($ratio<$resize_ratio)
           {
               $newimg = imagecreatetruecolor(($this->resize_height)*$ratio,$this->resize_height);
               imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height)*$ratio, $this->resize_height, $this->width, $this->height);
               ImageJpeg ($newimg,$this->dstimg);
           }
       }
   }
   //初始化图象
   function initi_img()
   {
       if($this->type=="jpg")
       {
           $this->im = imagecreatefromjpeg($this->srcimg);
       }
       if($this->type=="gif")
       {
           $this->im = imagecreatefromgif($this->srcimg);
       }
       if($this->type=="png")
       {
           $this->im = imagecreatefrompng($this->srcimg);
       }
   }
  
   //处理圆角
   function rounded_corner($image,$size)
   {
                $topleft = true;
                $bottomleft = true;
                $bottomright = true;
                $topright = true;
                $corner_source = imagecreatefrompng('rounded_corner.png');
                $corner_width = imagesx($corner_source); 
                $corner_height = imagesy($corner_source); 
                $corner_resized = ImageCreateTrueColor($this->corner_radius, $this->corner_radius);
                ImageCopyResampled($corner_resized, $corner_source, 0, 0, 0, 0, $this->corner_radius, $this->corner_radius, $corner_width, $corner_height);
                $corner_width = imagesx($corner_resized); 
                $corner_height = imagesy($corner_resized); 
                $white = ImageColorAllocate($image,255,255,255);
                $black = ImageColorAllocate($image,0,0,0);
  
                //顶部左圆角
                if ($topleft == true) {
                        $dest_x = 0; 
                        $dest_y = 0; 
                        imagecolortransparent($corner_resized, $black);
                        imagecopymerge($image, $corner_resized, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);
                }
  
                //下部左圆角
                if ($bottomleft == true) {
                        $dest_x = 0; 
                        $dest_y = $size - $corner_height;
                        $rotated = imagerotate($corner_resized, 90, 0);
                        imagecolortransparent($rotated, $black);
                        imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100); 
                }
  
                //下部右圆角
                if ($bottomright == true) {
                        $dest_x = $size - $corner_width; 
                        $dest_y = $size - $corner_height; 
                        $rotated = imagerotate($corner_resized, 180, 0);
                        imagecolortransparent($rotated, $black);
                        imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100); 
                }
  
                //顶部右圆角
                if ($topright == true) {
                        $dest_x = $size - $corner_width; 
                        $dest_y = 0;
                        $rotated = imagerotate($corner_resized, 270, 0);
                        imagecolortransparent($rotated, $black);
                        imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100); 
                }
                $image = imagerotate($image, $this->angle, $white);
                return $image;
   }
  
   //图象目标地址
   function dst_img()
   {
       $full_length = strlen($this->srcimg);
       $type_length = strlen($this->type);
       $name_length = $full_length-$type_length;
       $name         = substr($this->srcimg,0,$name_length-1);
       $this->dstimg = $name."_small.png";
   }
}
  
//resizeimage("图片地址", "处理后的宽度", "处理后的高度", "是否裁剪", "圆角度数", "倾斜度");
$img_file = 'Sunset.jpg';
$corner = 'rounded_corner.png';
$resizeimage = new resizeimage($img_file, $corner, "80", "80", "1", "6", "0");
?>
<img src="Sunset_small.png" border="0">