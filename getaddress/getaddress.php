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
function get($url){
    $ch = curl_init();
    preg_match('/https:\/\//',$url)?$ssl=TRUE:$ssl=FALSE;
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    if($ssl){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    $data  =  curl_exec($ch);
    curl_close($ch);
    return $data;
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
    $ak = (empty($ak))?"":$ak;
    $url ="https://api.map.baidu.com/location/ip?ak=$ak&coor=bd09ll&ip=".get_ip();
    $rs = json_decode(get($url),1);
    if($rs['status']==0){
        $arr = explode('|',$rs['address']);
        $arr = ['province'=>$arr[1],'city'=>$arr[2]];
    }else{
        $arr2 = json_decode(get('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json'),1);
        if($arr2['ret']==1){
            $arr = [];
            $arr['country'] = $arr2['country'];
            $arr['province'] = $arr2['province'];
            $arr['city'] = $arr2['city'];
        }
    }
    return $arr;
}

dump(getaddress());
?>