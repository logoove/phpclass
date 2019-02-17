<?php
/*
 * 此文件用于验证短信服务API接口，供开发时参考
 * 执行验证前请确保文件为utf-8编码，并替换相应参数为您自己的信息，并取消相关调用的注释
 * 建议验证前先执行Test.php验证PHP环境
 *
 * 2017/11/30
 */


require_once "SignatureHelper.php";
/**
 * 发送短信
 */
function sendSms($arr) {
    $sms_ak = $arr['keyid'];
    $sms_sk =  $arr['keysecret'];
    $sms_sg =  $arr['signname'];
    $sms_id =  $arr['templatecode'];

    $params = array ();

    // *** 需用户填写部分 ***

    // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
    $accessKeyId = $sms_ak;
    $accessKeySecret = $sms_sk;

    // fixme 必填: 短信接收号码
    $params["PhoneNumbers"] = $arr['phonenumbers'];

    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
    $params["SignName"] =$sms_sg;

    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
    $params["TemplateCode"] = $sms_id;

    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
    // $code = mt_rand(10000, 99999);
    $params['TemplateParam'] = $arr['templateparam'];


    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }

    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new sms();

    // 此处可能会抛出异常，注意catch
    $content = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
    // fixme 选填: 启用https
    // ,true
    );

    return $content;
}
/*
include_once 'aliyun/sendSms.php';
$params = array(
    'code'=>"12345"
);
$option = array('keyid' => $smsset['aliyun_new_keyid'], 'keysecret' => $smsset['aliyun_new_keysecret'], 'phonenumbers' => $mobile, 'signname' => $template['smssign'], 'templatecode' => $template['smstplid'], 'templateparam' => $params);
$result = sendSms($option);
if ($result['Message'] != 'OK') {
				return array('status' => 0, 'message' => '短信发送失败(错误信息: ' . $result['Message'] . ')');
			}
*/