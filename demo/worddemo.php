<?php
function dump($arr){
	echo '<pre>'.print_r($arr,TRUE).'</pre>';
}
include "PHPWord.php";

$w = new PHPWord();

/*
$section = $w->createSection(array('borderColor'=>'00FF00', 'borderSize'=>1)); //设置边框粗细 颜色

//创建标题
$header = $section->createHeader();

$header->addWatermark('earth.jpg', array('marginTop'=>200, 'marginLeft'=>55)); //添加背景

$table = $header->addTable();
$table->addRow();
$table->addCell(4500)->addText('中文');
$table->addCell(4500)->addImage('earth.jpg', array('width'=>250, 'height'=>250, 'align'=>'right'));

//创建页脚
$footer = $section->createFooter();
$footer->addPreserveText('当前 {PAGE}页   共 {NUMPAGES}页.', array('align'=>'center'));

//正文
$section->addTextBreak();
$section->addText('中文12word');//添加文本

$section->addImage('earth.jpg',array("width"=>200,"height"=>200,"align"=>'center'));
$section->addTextBreak(2); //两行
$section->addLink('http://www.google.com', '欢迎访问谷歌', array('color'=>'red', 'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE));
$w->addLinkStyle('myOwnLinkStyle', array('bold'=>true, 'color'=>'808000'));
$section->addLink('http://www.bing.com', null, 'myOwnLinkStyle');

// 列表样式 3行 点开头
$section->addListItem('List Item 1', 0);
$section->addListItem('List Item 2', 0);
$section->addListItem('List Item 3', 0);
$section->addTextBreak(2);

// 分章节
$section->addListItem('第一章', 0);
$section->addListItem('第一节', 1);
$section->addListItem('第二节', 1);
$section->addListItem('第三节', 1, array('bold'=>true));
$section->addListItem('第三节第一小节', 2);
$section->addListItem('第三节第二小节', 2);
$section->addTextBreak(2);

// 数字样式
$listStyle = array('listType'=>PHPWord_Style_ListItem::TYPE_NUMBER);
$section->addListItem('List Item 1', 0, null, $listStyle);
$section->addListItem('List Item 2', 0, null, $listStyle);
$section->addListItem('List Item 3', 0, null, $listStyle);
$section->addTextBreak(2);

// 颜色 数字 分格
$w->addFontStyle('myOwnStyle', array('color'=>'FF0000'));
$w->addParagraphStyle('P-Style', array('spaceAfter'=>95));
$listStyle = array('listType'=>PHPWord_Style_ListItem::TYPE_NUMBER_NESTED);

$section->addListItem('List Item 1', 0, 'myOwnStyle', $listStyle, 'P-Style');
$section->addListItem('List Item 2', 0, 'myOwnStyle', $listStyle, 'P-Style');
$section->addListItem('List Item 3', 1, 'myOwnStyle', $listStyle, 'P-Style');
$section->addListItem('List Item 4', 1, 'myOwnStyle', $listStyle, 'P-Style');
$section->addListItem('List Item 5', 2, 'myOwnStyle', $listStyle, 'P-Style');
$section->addListItem('List Item 6', 1, 'myOwnStyle', $listStyle, 'P-Style');
$section->addListItem('List Item 7', 0, 'myOwnStyle', $listStyle, 'P-Style');

//宽屏
$section = $w->createSection(array('orientation'=>'landscape'));//创建宽屏幕
$section->addText('I am placed on a landscape section. Every page starting from this section will be landscape style.');
$section->addPageBreak(); //添加一页

//上下左右间距
$section = $w->createSection(array('marginLeft'=>600, 'marginRight'=>600, 'marginTop'=>600, 'marginBottom'=>600));
$section->addText('This section uses other margins.');


//文本样式
$w->addParagraphStyle('pStyle', array('spacing'=>100));
$w->addFontStyle('BoldText', array('bold'=>true));
$w->addFontStyle('ColoredText', array('color'=>'FF8080'));
$w->addLinkStyle('NLink', array('color'=>'0000FF', 'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE));
$textrun = $section->createTextRun('pStyle');
$textrun->addText('Each textrun can contain native text or link elements.');
$textrun->addText(' No break is placed after adding an element.', 'BoldText');
$textrun->addText(' All elements are placed inside a paragraph with the optionally given p-Style.', 'ColoredText');
$textrun->addText(' The best search engine: ');
$textrun->addLink('http://www.google.com', null, 'NLink');
$textrun->addText('. Also not bad: ');
$textrun->addLink('http://www.bing.com', null, 'NLink');

//标题 内容

$w->addTitleStyle(1, array('size'=>20, 'color'=>'333333', 'bold'=>true));
$w->addTitleStyle(2, array('size'=>16, 'color'=>'666666'));

$fontStyle = array('spaceAfter'=>60, 'size'=>12);
$section->addTOC($fontStyle);
$section->addTitle('标题11', 1);
$section->addText('Some text...');
$section->addTextBreak(2);

$section->addTitle('这里是标题', 1);
$section->addText('一些内容...');



//保存

$obj = PHPWord_IOFactory::createWriter($w,"word2007");
$obj->save("2.docx");
*/

$document = $w->loadTemplate('1.doc');
//$document->setValue('title','标题简介');
//$document->setValue('value1', '太阳');
//$document->setValue('value2', '天空');

//$document->setValue('weekday', date('l'));
//$document->setValue('time', date('H:i'));

//$document->save('Solarsystem.docx');
dump($document);
?>