<?php
require dirname(__FILE__) . '/Ip2Region.class.php';
$ipobj = new Ip2Region("ip2region.db");

dump($ipobj->binarySearch('36.157.208.51'));
