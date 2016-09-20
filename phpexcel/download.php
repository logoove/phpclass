<?php
include "pdo/db.php";

require "phpexcel/PHPExcel.php";
$data = pdo_fetchall("SELECT *  FROM ".tablename('test'));

$objPHPExcel = new PHPExcel();
$objPHPExcel->getActiveSheet()->setTitle('表1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '国家')
            ->setCellValue('C1', '代码')
            ->setCellValue('D1', '时间');

$i = 2; 
foreach($data as $item){ 
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A' . $i, $item['id'])
->setCellValue('B' . $i, $item['weid']) 
->setCellValue('C' . $i,$item['headimgurl'])
->setCellValue('D' . $i, $item['openid']); 
$i ++; 
}
$objPHPExcel->setActiveSheetIndex(0);
$filename = date('Y-m-d',time())."-测试";

/*
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

*/

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');


$objWriter->save('php://output');
exit;
/*
$str="昵称,姓名,地址,手机号,排名,所玩次数,最好分数\n";
header("Content-type:text/csv");
header('Content-Disposition:attachment;filename="'.$filename.'.csv"');
echo "\xEF\xBB\xBF".$str;
*/















?>


