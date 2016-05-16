<?php
include 'phpclass/geohash.class.php';

//根据经纬度计算距离 其中A($lat1,$lng1)、B($lat2,$lng2)
function getDistance($lat1,$lng1,$lat2,$lng2)
{
    //地球半径,米
    $R = 6378137;
  
    //将角度转为狐度
    $radLat1 = deg2rad($lat1);
    $radLat2 = deg2rad($lat2);
    $radLng1 = deg2rad($lng1);
    $radLng2 = deg2rad($lng2);
  
    //结果
    $s = acos(cos($radLat1)*cos($radLat2)*cos($radLng1-$radLng2)+sin($radLat1)*sin($radLat2))*$R;
   //精度
    $s = round($s* 10000)/10000;
  
    return  round($s);
    }
    
get_db('test');

$geo=new Geohash;
  
//获取附近的信息
$lat= $_GET['lat'];//经度
$lng= $_GET['lng'];//纬度
 
//当前 geohash值
$geo_v = $geo->encode($lat,$lng);
 echo $geo_v; 
//附近
$n = $_GET['n'];
$geo_str = substr($geo_v, 0, $n);

$sql = 'select * from map where geo like "'.$geo_str.'%"';
echo $sql;
$data =mysql_query($sql);
$d = array();
while($rs = mysql_fetch_array($data,MYSQL_ASSOC)){
	$d[] = $rs;
}
  
//算出实际距离
foreach($d as $key=>$val)
{
    $distance = getDistance($lat,$lng,$val['lat'],$val['lng']);
  
    $d[$key]['distance'] = $distance;
  
    //排序列
    $sortdistance[$key] = $distance;
}
  
//距离排序
array_multisort($sortdistance,SORT_ASC,$d);
  
  
dump($d);
?>