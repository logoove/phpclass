<?php
include('upload.class.php');
include "pdo/Db.class.php";
$action = (isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : ''));

if ($action == 'simple') {
	$handle = new Upload($_FILES['my_field']);
	
	if ($handle->uploaded) {
		$handle->file_new_name_body =time();
		//$handle->file_new_name_ext = 'txt';//制定上传类型
		
		$handle->mime_check = true;//检查扩展名类型
		$handle->allowed = array('image/*');
		
		
        $handle->image_resize            = true;//图片缩放
        $handle->image_x                 = 300;//可读300px
        $handle->image_ratio_y           = true;//高度自动
        
		$handle->Process('tmp');
		if ($handle->processed) {
			dump($handle);
		}else{
		echo $handle->error;
	}
	$handle-> Clean();	
	}else{
		echo $handle->error;
	}
	
	
}elseif($action == 'base64') {
 $handle = new Upload('base64:'.$_POST['my_field']);
if ($handle->uploaded) {
		$handle->file_new_name_body =time();
		//$handle->file_new_name_ext = 'txt';//制定上传类型
		
		$handle->mime_check = true;//检查扩展名类型
		$handle->allowed = array('image/*');
		
		
        $handle->image_resize            = true;//图片缩放
        $handle->image_x                 = 300;//可读300px
        $handle->image_ratio_y           = true;//高度自动
        
		$handle->Process('tmp');
		if ($handle->processed) {
			dump($handle);
		}else{
		echo $handle->error;
	}
	$handle-> Clean();	
	}else{
		echo $handle->error;
	}

}elseif($action == 'multiple') {
    $files = array();
    foreach ($_FILES['my_field'] as $k => $l) {
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files))
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
    }	
 foreach ($files as $file) {	
	
 $handle = new Upload($file);
if ($handle->uploaded) {
		$handle->file_new_name_body =time();
		//$handle->file_new_name_ext = 'txt';//制定上传类型
		
		$handle->mime_check = true;//检查扩展名类型
		$handle->allowed = array('image/*');
		
		
        $handle->image_resize            = true;//图片缩放
        $handle->image_x                 = 300;//可读300px
        $handle->image_ratio_y           = true;//高度自动
        
		$handle->Process('tmp');
		if ($handle->processed) {
			dump($handle);
		}else{
		echo $handle->error;
	}
	$handle-> Clean();	
	}else{
		echo $handle->error;
	}
}
}


?>