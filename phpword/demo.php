<?php
header("Content-Type: text/html; charset=UTF-8");
include "phpword/PHPWord.php";

$PHPWord = new PHPWord();
$PHPWord->addFontStyle('rStyle', array('bold' => true, 'italic' => true, 'size' => 16));
$PHPWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 100));
$PHPWord->addTitleStyle(1, array('bold' => true), array('spaceAfter' => 240));


$section = $PHPWord->createSection();//创建新页面



$section->addTitle('欢迎使用', 1);
$section->addText('中国');

$section->addTextBreak(2);


// Link
$section->addLink('http://www.google.com', null, '中国');
$section->addTextBreak();


// Image
$section->addImage('1.jpg', array('width'=>180, 'height'=>180));

//表格--------------------------------------------------------------------------------------------

// Define table style arrays
$styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');

// Define cell style arrays
$styleCell = array('valign'=>'center');
$styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

// Define font style for first row
$fontStyle = array('bold'=>true, 'align'=>'center');

// Add table style
$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

// Add table
$table = $section->addTable('myOwnTableStyle');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(2000, $styleCell)->addText('姓名 1', $fontStyle);
$table->addCell(2000, $styleCell)->addText('性别 2', $fontStyle);
$table->addCell(2000, $styleCell)->addText('Row 3', $fontStyle);
$table->addCell(2000, $styleCell)->addText('Row 4', $fontStyle);
$table->addCell(500, $styleCellBTLR)->addText('Row 5', $fontStyle);

// Add more rows / cells
for($i = 1; $i <= 10; $i++) {
	$table->addRow();
	$table->addCell(2000)->addText("我 $i");
	$table->addCell(2000)->addText("Cell $i");
	$table->addCell(2000)->addText("Cell $i");
	$table->addCell(2000)->addText("Cell $i");
	
	$text = ($i % 2 == 0) ? 'X' : '';
	$table->addCell(500)->addText($text);
}
//-------------------------------------表格结束-------------------------------------------------------
// Add table
$table = $section->addTable();

for($r = 1; $r <= 10; $r++) { // Loop through rows
	// Add row
	$table->addRow();
	
	for($c = 1; $c <= 5; $c++) { // Loop through cells
		// Add Cell
		$table->addCell(1750)->addText("行 $r, 列 $c");
	}
}
//-----------------------------简单表格----------------------------
// Add 页头
$header = $section->createHeader();
$table = $header->addTable();
$table->addRow();
$table->addCell(4500)->addText('我是页头.');
$table->addCell(4500)->addImage('1.jpg', array('width'=>50, 'height'=>50, 'align'=>'right'));

// Add 页尾
$footer = $section->createFooter();
$footer->addPreserveText('第 {PAGE} 页共 {NUMPAGES} 页', array('align'=>'center'));

$section->addTextBreak(2);
// Add hyperlink elements
$section->addLink('http://www.google.com', '最好的搜索', array('color'=>'0000FF', 'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE));
$section->addTextBreak(2);

$PHPWord->addLinkStyle('myOwnLinkStyle', array('bold'=>true, 'color'=>'808000'));
$section->addLink('http://www.bing.com', '描述', 'myOwnLinkStyle');
$section->addLink('http://www.yahoo.com', '超级链接', 'myOwnLinkStyle');


// Add listitem elements
$section->addListItem('列表 1', 0);
$section->addListItem('List Item 1.1', 1);
$section->addListItem('List Item 1.2', 1);
$section->addListItem('List Item 1.3 (styled)', 1, array('bold'=>true));
$section->addListItem('List列表Item 1.3.1', 2);
$section->addListItem('List Item 1.3.2', 2);
$section->addTextBreak(2);


$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2003');
$objWriter->save('demo.doc');

?>