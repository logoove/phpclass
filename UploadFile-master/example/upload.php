<?php
	include '../UploadFile.class.php';
	
	
	$upload=new UploadFile();
	$upload->maxSize  = 3*pow(2,20) ;// 设置附件上传大小  3M    默认为2M
	$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型   默认为空不检测扩展
	$upload->savePath =  './pictures/';// 设置附件上传目录   默认上传目录为 ./uploads/
	
	if(!$upload->upload()) {
		// 上传错误提示错误信息
		$this->error($upload->getErrorMsg());
	}else{
		// 上传成功 获取上传文件信息
		$info =  $upload->getUploadFileInfo();
	}	

?>
