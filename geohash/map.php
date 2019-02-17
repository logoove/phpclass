<?php
include 'geohash.class.php';

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
