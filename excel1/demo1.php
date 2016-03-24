<?php
	include'lib/XmlExcel.php';
	$xls=new XmlExcel;
	$xls->setDefaultWidth(80);
	$xls->setDefaultAlign("center");
	$xls->setDefaultHeight(18);
	$xls->addHead(array("A标题","B标题","C标题"),"表一");

	$xls->addRow(array("A1","2","3"),"表一"); //单行添加
	$xls->addRow(array("A2","22","32"),"表一");
	
	$xls->addRows(array(
		array("A3",'B3',"c3"),
		array("a4",'b4','c4')
	),"表一");
	$xls->addTitle("标题",'表一');
	
	$xls->addSheet("表二");
	
	$xls->setCharset("utf-8");//编码
	
	//$xls->debug();
	$xls->export("数据表");
?>