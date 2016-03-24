<?php
function dump($a){
	echo "<pre>".print_r($a,1)."</pre>";
}
	include'lib/XmlExcel.php';
	$xls=new XmlExcel;
$x = (array)$xls->import("2.xls");
dump($x);
?>