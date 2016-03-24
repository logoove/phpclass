<?php

include 'crXml.php';

$xml = new crXml();

$year = $xml->year;

foreach(range(1,12) as $m)

{

      $year->month[$m-1]->noOfDays =      date('t',mktime(0,0,0,$m,$m,2000));

      $year->month[$m-1]->shortName = date('M',mktime(0,0,0,$m,$m,2000));

      $year->month[$m-1]['name']=date('F',mktime(0,0,0,$m,$m,2000));

 

}
header("Content-Type:text/xml"); 
echo $xml->xml();

?>