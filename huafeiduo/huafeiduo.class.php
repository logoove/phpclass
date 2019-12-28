<?php
class Huafeiduo {
	///话费多相关配置(登录后台->系统设置->基本设置 里面获取以下数据)
	private $_gateway = 'http://api.huafeiduo.com/gateway.cgi';
	//你的api_key
	private $_api_key = 'API_KEY';
	//你的secret_key
	private $_secret_key = 'SECRET_KEY';

	//private $_notify_url = 'http://yourdomain.com/callback/huafeiduo';


	/*
	*	发送HTTP请求
	*	@param $url string 请求地址
	*	@param $params array 请求参数
	*	@param $method string GET或POST
	*	@param $timeout 超时时间
	*	@return string HTTP请求结果
	*/
	private function _sendRequest($url, $params=array(), $method='GET', $timeout = 60) {
        $data_string = http_build_query($params);

        $ch = curl_init();
        if(strtoupper($method) == 'GET')
        {
            if(strpos($url, '?'))
                $url .= '&' . $data_string;
            else
                $url .= '?' . $data_string;
            
            curl_setopt($ch, CURLOPT_URL, $url);

        }else if(strtoupper($method) == 'POST'){
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_POST, TRUE);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        
        $result = curl_exec($ch);
        
        curl_close ($ch);
        
        return $result;
	}

	/*
	*	生成签名　
	*	@param $params  array 参与参与签名的参数数组
	*	@return string
	*/
	private function _getSign($params) {
		$paramString = '';
		ksort($params);

		foreach($params as $k=>$v) {
			$paramString .= "{$k}{$v}";
		}

		$sign = md5($paramString . $this->_secret_key);

		return $sign;
	}

	/*
	*	检查指定面额和手机号码当前是否可以下单, 以及获取下单价格
	*	@param $card_worth int 待检测的充值面额
	*	@param $phone_number string 待检测的充值手机号码 
	*	@return 检查结果为＂可以下单＂时返回数组, 此数组形如: 
	*		array(
	*			'price' => 49.5, // 成本价
	*			'card_worth'=> 50, //面额
	*			'phone_number'=> 15623722222, //手机号码
	*			'area'=> '湖北武汉', //手机归属地
	*			'platform'=> '联通'	 //运营商
	*		)
	＊		检查结果为"正在维护(无法充值)"时返回FALSE
	*/
	public function check($card_worth, $phone_number) {
		$mod = 'order.phone.check';
		$params = array(
			'card_worth'=> $card_worth,
			'phone_number'=> $phone_number,
			'api_key'=> $this->_api_key
			);

		$sign = $this->_getSign($params);

		$params['sign'] = $sign;

		$params['mod'] = $mod;

		$ret_json_string = $this->_sendRequest($this->_gateway, $params, 'GET');

		$ret = json_decode($ret_json_string, TRUE);

		if (is_array($ret) && $ret['status'] == 'success') {
			return $ret['data'];
		}

		return FALSE;
	}

	/*
	*	提交充值(下单) 
	* 	注意: 
	*		1. 提交成功不代表充值成功, 充值成功与否需要依赖异步回调结果, 或提交后调用order.phone.status接口确认订单状态
	*		2. 如果接口没有明确返回失败(例如请求超时),  则不能说明订单是充值失败
	*	@param $card_worth int 充值面额
	*	@param $phone_number string 充值手机号码 
	*	@param $sp_order_id string 商户订单号
	*	@return boolean 提交成功返回TRUE, 提交失败返回FALSE
	*/
	public function submit($card_worth, $phone_number, $sp_order_id) {
		$mod = 'order.phone.submit';
		$params = array(
			'card_worth'=> $card_worth,		//必须 面值,
			'phone_number'=> $phone_number,	//必须 充值号码
			//'notify_url'=> $this->_notify_url, //可选  充值成功或失败时会向此地址发送异步回调, 以通知充值结果
			'sp_order_id'=> $sp_order_id, //必须 商户订单号, 是由用户自己生成的订单号 用于关联一笔订单
			'api_key'=> $this->_api_key
			);
		$sign = $this->_getSign($params);

		$params['sign'] = $sign;

		$params['mod'] = $mod;	//参数mod不参与签名

		$ret_json_string = $this->_sendRequest($this->_gateway, $params, 'GET');

		$ret = json_decode($ret_json_string, TRUE);

		if (is_array($ret) && $ret['status'] == 'success') {
			return TRUE;
		}

		return FALSE;
	}

	/*
	*	检查当前订单状态
	*	@param $sp_order_id string 商户订单号(同order.phone.submit接口中的sp_order_id)
	*	@return string: 
	*		"init": 充值中
	*		"recharging": 充值中
	*		"success": 充值成功
	*		"failure": 充值失败
	*/
	public function status($sp_order_id) {
		$mod = 'order.phone.status';
		$params = array(
			'sp_order_id'=> $sp_order_id,
			'api_key'=> $this->_api_key
			);
		$sign = $this->_getSign($params);

		$params['sign'] = $sign;

		$params['mod'] = $mod;

		$ret_json_string = $this->_sendRequest($this->_gateway, $params, 'GET');

		$ret = json_decode($ret_json_string, TRUE);

		if (is_array($ret) && $ret['status'] == 'success') {
			return $ret['order_status'];
		}

		return FALSE;
	}

	/*
	*	针对notify_url来验证消息是否是话费多发出的合法消息
	*	@return boolean 验证通过时返回TRUE 否则返回FALSE
	*/
	public function verifyNotify() {
		$orderId =	isset($_GET['order_id'])	? $_GET['order_id']	: '';
		$status = 	isset($_GET['status'])		? $_GET['status']	: '';
		$worth = 	isset($_GET['worth'])		? $_GET['worth']	: '';
		$price = 	isset($_GET['price'])		? $_GET['price']	: '';
		$phone = 	isset($_GET['phone'])		? $_GET['phone']	: '';
		$spId = 	isset($_GET['sp_order_id'])	? $_GET['sp_order_id'] : '';
		$sign = 	isset($_GET['sign'])		? $_GET['sign']		: '';

		if ($sign == md5($orderId . $status . $worth . $price . $phone . $spId . $this->_secret_key)) {
			return TRUE;
		}

		return FALSE;
	}

}

$HFD = new Huafeiduo();

/// 为一个手机号码充值
$phone_number = '156xxxxxxxx';
$card_worth = 1;
// 先检查该手机号码和相应面额是否可以充值
$ret = $HFD->check($card_worth, $phone_number);
if ($ret === FALSE) {
	echo "地区维护, 请尝试其它面额和手机号码\n";
	exit;
	
}
//提交充值
$sp_order_id = uniqid() . mt_rand(10000, 99999);
$ret = $HFD->submit($card_worth, $phone_number, $sp_order_id);
if ($ret) {
	echo "充值提交成功\n";
	exit;
}

///充值的最终结果请通过配置异步回调地址, 或通过order.phone.status接口后续查询获取

