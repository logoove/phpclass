<?php
include 'crXml.php';
$crXml = new crXml();

$year= $crXml->year;

$year->addNameSpace(array( 'm1' => 'http://uriOne.com', 'm2' => 'http://uriTwo.com',));

foreach(range(1,12) as $m)

{
      $year->month[$m-1]->{'m1:noOfDays'}  =      date('t',mktime(0,0,0,$m,$m,2000));

      $year->month[$m-1]->shortName = date('M',mktime(0,0,0,$m,$m,2000));

      $year->month[$m-1]['name']    =date('F',mktime(0,0,0,$m,$m,2000));

      $year->month[$m-1]['m2:name']    =date('F',mktime(0,0,0,$m,$m,2000));

}

header("Content-Type:text/xml");
echo $crXml->xml();


