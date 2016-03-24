UploadFile
=====
<h5>UploadFile.class.php 支持多文件上传的上传类</h5>
<hr/>
<b>
vsersion:1.0 <br/>
author:silenceper<br/>
email:silenceper#gmail.com(将#改为@)<br/>
</b>
<hr/>
说明:
  支持多文件上传的上传类 使用方法：<br/>

<pre>
	include '../UploadFile.class.php';
	$upload=new UploadFile();
	if(!$upload->upload()) {
		// 上传错误提示错误信息
		$this->error($upload->getErrorMsg());
	}else{
		// 上传成功 获取上传文件信息
		$info =  $upload->getUploadFileInfo();
	}
</pre>

