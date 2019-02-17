<?php
/*
*如果想要定位准确,请使用baidu定位
开发文档http://lbsyun.baidu.com/index.php?title=webapi/ip-api
设置key就是百度定位,否则使用开放的新浪定位
*/
if (!function_exists('dump')) {
    function dump($arr){
        echo '<pre>'.print_r($arr,TRUE).'</pre>';
    }

}
/*
 * POST或GET的curl请求
 * $url 请求地址
 * $data 请求数组
 * */
function curl($url,$data = ''){
    $ch = curl_init();
    if (class_exists('\CURLFile'))
    {
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
    }
    else
    {
        if (defined('CURLOPT_SAFE_UPLOAD'))
        {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        }
    }
    preg_match('/https:\/\//', $url) ? $ssl = TRUE : $ssl = FALSE;
    if ($ssl) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    if (!empty($data))
    {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $d = curl_exec($ch);
    curl_close($ch);
    return $d;
}
function get_ip(){
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    if(!preg_match("/^\d+\.\d+\.\d+\.\d+$/", $ip)){
        $ip = '0';
    }
    return $ip;
}

/*
 * 根据ip获取省市
 参数是百度地图key
 */
function getaddress($ak='') {
    $ak = (empty($ak))?"8SlSbHObMgN8HeOwGUQXU5XM":$ak;
    $url ="https://api.map.baidu.com/location/ip?ak=$ak&coor=bd09ll&ip=124.23.134.44";
    $rs = json_decode(curl($url),1);
    return $rs;
}

dump(getaddress());
?>