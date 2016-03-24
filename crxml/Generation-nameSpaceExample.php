<?php
include 'crXml.php';
$crXml = new crXml();

$year= $crXml->year;

$year->addNameSpace(array( 'prefixOne' => 'http://uriOne.com', 'prefixTwo' => 'http://uriTwo.com',));

foreach(range(1,12) as $m)

{
      $year->month[$m-1]->{'prefixOne:noOfDays'}  =      date('t',mktime(0,0,0,$m,$m,2000));

      $year->month[$m-1]->shortName = date('M',mktime(0,0,0,$m,$m,2000));

      $year->month[$m-1]['name']    =date('F',mktime(0,0,0,$m,$m,2000));

      $year->month[$m-1]['prefixTwo:name']    =date('F',mktime(0,0,0,$m,$m,2000));

}

header("Content-Type:text/xml");
echo $crXml->xml();
/* Output

<?xml version="1.0" encoding="UTF-8"?>
<year xmlns:prefixOne="http://uriOne.com" xmlns:prefixTwo="http://uriTwo.com">
      <month name="January" prefixTwo:name="January">
            <prefixOne:noOfDays>31</prefixOne:noOfDays>
            <shortName>Jan</shortName>
      </month>
      <month name="February" prefixTwo:name="February">
            <prefixOne:noOfDays>29</prefixOne:noOfDays>
            <shortName>Feb</shortName>
      </month>
      <month name="March" prefixTwo:name="March">
            <prefixOne:noOfDays>31</prefixOne:noOfDays>
            <shortName>Mar</shortName>
      </month>
      <month name="April" prefixTwo:name="April">
            <prefixOne:noOfDays>30</prefixOne:noOfDays>
            <shortName>Apr</shortName>
      </month>
      <month name="May" prefixTwo:name="May">
            <prefixOne:noOfDays>31</prefixOne:noOfDays>
            <shortName>May</shortName>
      </month>
      <month name="June" prefixTwo:name="June">
            <prefixOne:noOfDays>30</prefixOne:noOfDays>
            <shortName>Jun</shortName>
      </month>
      <month name="July" prefixTwo:name="July">
            <prefixOne:noOfDays>31</prefixOne:noOfDays>
            <shortName>Jul</shortName>
      </month>
      <month name="August" prefixTwo:name="August">
            <prefixOne:noOfDays>31</prefixOne:noOfDays>
            <shortName>Aug</shortName>
      </month>
      <month name="September" prefixTwo:name="September">
            <prefixOne:noOfDays>30</prefixOne:noOfDays>
            <shortName>Sep</shortName>
      </month>
      <month name="October" prefixTwo:name="October">
            <prefixOne:noOfDays>31</prefixOne:noOfDays>
            <shortName>Oct</shortName>
      </month>
      <month name="November" prefixTwo:name="November">
            <prefixOne:noOfDays>30</prefixOne:noOfDays>
            <shortName>Nov</shortName>
      </month>
      <month name="December" prefixTwo:name="December">
            <prefixOne:noOfDays>31</prefixOne:noOfDays>
            <shortName>Dec</shortName>
      </month>
</year>
*/


