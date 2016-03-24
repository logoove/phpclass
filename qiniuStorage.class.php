<?php
/**
 * $uploader = new qiniuStorage($config);
 * $result = $uploader->uploadFile($_FILES,array('path'=>'YOUR DIR')); 普通文件
 * $result = $uploader->uploadFile($_FILES,array('path'=>'YOUR DIR'),'base'); 二进制
 */
class qiniuStorage{
	public $RSF_HOST = 'http://rsf.qbox.me';
	public $RS_HOST = 'http://rs.qbox.me';
	public $UP_HOST = 'http://up.qiniu.com';
	public $IO_HOST = 'http://iovip.qbox.me';
	public $timeout = '';

	public function __construct($config){
		$this->sk = $config['secrectKey'];
		$this->ak = $config['accessKey'];
		$this->domain = $config['domain'];
		$this->bucket = $config['bucket'];
		$this->timeout = isset($config['timeout'])? $config['timeout'] : 3600;
	}
	
	static function sign ($sk,$ak,$data){
		$sign = hash_hmac('sha1', $data, $sk, true);
		return $ak . ':' . self::encode($sign);
	}
	
	static function signWithData($sk,$ak,$data){
		$data = self::encode($data);
		return self::sign($sk,$ak,$data) . ':' . $data;
	}
	
	static function encode ($str){
		$find = array('+', '/');
		$replace = array('-', '_');
		return str_replace($find, $replace, base64_encode($str));
	}
	
	public function uploadToken($sk,$ak,$param){
		$deadline = time() + 3600;
		$data = array('scope'=> $this->bucket,'deadline'=>$deadline);
		array_merge($data,$param);
		$data = json_encode($data);
		return self::SignWithData($sk,$ak,$data);		
	}
	
	public function accessToken($url, $body=''){
		$parsed_url = parse_url($url);
		$path = $parsed_url['path'];
		$access = $path;
		if (isset($parsed_url['query'])) {
			$access .= "?" . $parsed_url['query'];
		}
		$access .= "\n";

		if($body){
			$access .= $body;
		}
		return self::sign($this->sk, $this->ak, $access);
	}  
	
	//图片上传
	public function upload ($file,$config,$type){
		$mimeBoundary = md5(microtime());
		$uploadToken = $this->uploadToken($this->sk,$this->ak,$config);
		$header[] = 'Content-Type:multipart/form-data;boundary=' . $mimeBoundary;
		$data = array(
			'--' . $mimeBoundary,
			'Content-Disposition: form-data; name="token"',
			'',
			$uploadToken,
			'--' . $mimeBoundary,
			'Content-Disposition: form-data; name="key"',
			'',
			$config['saveName'],
			'--' . $mimeBoundary,
			'Content-Disposition: form-data; name="file"; filename="' . $file['fileName'] . '"',
			'Content-Type: application/octet-stream',
			'Content-Transfer-Encoding: binary',
			'',
			file_get_contents($file['temp']),
			'--' . $mimeBoundary . '--'
		);
		if($type == 'file'){
			array_push($data,file_get_contents($file['temp']));
		}else{
			$database = base64_decode(substr(strstr($file['temp'],','),1));
			array_push($data,$database);
		}
		array_push($data,'--' . $mimeBoundary . '--');
		$body = implode("\r\n", $data);
		$header[] = 'Content-Length:' . @strlen($body);
		return $this->request($this->UP_HOST,$header,$body);
	}
	
	//抓取远程图片
	public function fetch ($fileurl,$newfile){
		$entry = self::encode($fileurl);
		$save = self::encode("{$this->bucket}:$newfile");
		$opturl = $this->IO_HOST.'/fetch/'.$entry.'/to/'.$save;
		$accessToken = $this->accessToken($opturl);
		$header[] = 'Content-Type: application/json';
		$header[] = 'Authorization: QBox '.$accessToken;
		$response = $this->request($opturl,$header);
		return $response;
	}
	
	// 图片处理
	public function dealImage ($file,$type,$data){
		$entry = self::encode("{$this->bucket}:{$file}");
		if(isset($data['copy']) && $data['copy']){
			$newfile=$data['newfile'];
			$entry = self::encode("{$this->bucket}:{$newfile}");
		}
		switch($type){
			case 'crop':
					$opturl = $this->domain.'/'.$file.'?imageMogr2/crop/!'.$data['w'].'x'.$data['h'].'a'.$data['x'].'a'.$data['y'].'|saveas/'.$entry;
				break;
			case 'thumb':
					$opturl = $this->domain.'/'.$file.'?imageMogr2/thumbnail/'.$data['w'].'x'.$data['h'].'|saveas/'.$entry;
				break;
			case 'rotate':
					$opturl = $this->domain.'/'.$file.'?imageMogr2/rotate/'.$data.'|saveas/'.$entry;
				break;
		}
		$sign = self::sign($this->sk,$this->ak,$opturl); 
		$url = 'http://'.$opturl.'/sign/'.$sign;
		$response = $this->request($url);
		return $response;
	}
	
	public function request ($url,$header = null,$body = null){
		$curl = curl_init($url); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($curl, CURLOPT_HEADER,1); 
		if(!is_null($header)) curl_setopt($curl, CURLOPT_HTTPHEADER,$header); 
		if(!is_null($body)) curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		curl_setopt($curl, CURLOPT_POST, 1); 
		$result = curl_exec($curl);
		list($header, ,$body) = explode("\r\n\r\n",$result,3);
		curl_close($curl);
		if($result !== false){
			return json_decode($body,true);
		}else{
			return $header;
		}
	}
}
