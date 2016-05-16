<?php

include 'crXml.php';

$xml = new crXml();

$year = $xml->year;

foreach(range(1,12) as $m)
{
$year->month[$m-1]->month = date('m',time());
$year->month[$m-1]->day =      date('d',time());
$year->month[$m-1]['name']=date('m',time());
}
header("Content-Type:text/xml"); 
echo $xml->xml();

?>