<?php
include "pdo/db.php";
require "phpexcel/PHPExcel/IOFactory.php";

$file = "test.csv";
$type = strtolower( pathinfo($file, PATHINFO_EXTENSION) );

if( $type=='xlsx'||$type=='xls' ){
  $objPHPExcel = PHPExcel_IOFactory::load($file);
}else if( $type=='csv' ){
  $objReader = PHPExcel_IOFactory::createReader('CSV')
    ->setDelimiter(',')
    ->setInputEncoding('GBK')
    ->setEnclosure('"')
    ->setLineEnding("\r\n")
    ->setSheetIndex(0);
  @$objPHPExcel = $objReader->load($file);

}else{
  die('不能读取文件!');
}

$sheet = $objPHPExcel->getSheet(0);

$highestRowNum = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();
$highestColumnNum = PHPExcel_Cell::columnIndexFromString($highestColumn);

$filed = array();
for($i=0; $i<$highestColumnNum;$i++){
  $cellName = PHPExcel_Cell::stringFromColumnIndex($i).'1';
  $cellVal = $sheet->getCell($cellName)->getValue();//取得列内容
  $filed []= $cellVal;
}

$data = array();
for($i=2;$i<=$highestRowNum;$i++){
  $row = array();
  for($j=0; $j<$highestColumnNum;$j++){
    $cellName = PHPExcel_Cell::stringFromColumnIndex($j).$i;
    $cellVal = $sheet->getCell($cellName)->getValue();
    $row[ $filed[$j] ] = $cellVal;
  }
  $data []= $row;
}

dump($data);











?>