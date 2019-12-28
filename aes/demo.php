<?php
/**
 * 功能.
 * User: Yoby logove@qq.com
 * Date: 2019/5/22 16:50
 * wechat: logove
 */

error_reporting();
function aes_decode($message, $encodingaeskey = '') {
	$key = base64_decode($encodingaeskey . '=');

	$ciphertext_dec = base64_decode($message);
	$iv = substr($key, 0, 16);
    $iv = strlen($iv)<16?substr(hash('sha256', $key), 0, 16):$iv;
		$decrypted = openssl_decrypt($ciphertext_dec, 'AES-256-CBC', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
	$block_size = 32;

	$pad = ord(substr($decrypted, -1));
	if ($pad < 1 || $pad > 32) {
		$pad = 0;
	}
	$result = substr($decrypted, 0, (strlen($decrypted) - $pad));
	if (strlen($result) < 16) {
		return '';
	}
	$content = substr($result, 16, strlen($result));
	$len_list = unpack("N", substr($content, 0, 4));
	$contentlen = $len_list[1];
	$content = substr($content, 4, $contentlen);
	return $content;
}

function aes_encode($message, $encodingaeskey = '') {
	$key = base64_decode($encodingaeskey . '=');
	$random = function()
	{

		$str = "";
		$str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		$max = strlen($str_pol) - 1;
		for ($i = 0; $i < 16; $i++) {
			$str .= $str_pol[mt_rand(0, $max)];
		}
		return $str;
	};
	$text = $random() . pack("N", strlen($message)) . $message;

	$iv = substr($key, 0, 16);
	$iv = strlen($iv)<16?substr(hash('sha256', $key), 0, 16):$iv;
	$block_size = 32;
	$text_length = strlen($text);
		$amount_to_pad = $block_size - ($text_length % $block_size);
	if ($amount_to_pad == 0) {
		$amount_to_pad = $block_size;
	}
		$pad_chr = chr($amount_to_pad);
	$tmp = '';
	for ($index = 0; $index < $amount_to_pad; $index++) {
		$tmp .= $pad_chr;
	}
	$text = $text . $tmp;
		$encrypted = openssl_encrypt($text, 'AES-256-CBC', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
		$encrypt_msg = base64_encode($encrypted);
	return $encrypt_msg;
}