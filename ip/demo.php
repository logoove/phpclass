<?php
if (!function_exists('dump')) {
    function dump($arr){
        echo '<pre>'.print_r($arr,TRUE).'</pre>';
    }

}
require dirname(__FILE__) . '/Ip2Region.class.php';
$ipobj = new Ip2Region("ip2region.db");

dump($ipobj->binarySearch('221.11.1.68'));