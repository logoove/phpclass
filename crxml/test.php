<?php
function testCmp($src,$tar,$testNum)
{
	if($src==$tar) {
		echo "Test $testNum OK<br/>\n";
	} else {
		echo "Test $testNum Failed\nexpected\n".($tar)."\ngot\n".($src)."<br/>\n";
	}
}
function test($object,$target,$testNum=1)
{
	$src=str_replace("\n","",$object->xml());
	$src=str_replace("\r","",$src);

	$target=str_replace("\n","",$target);
	$target=str_replace("\r","",$target);

	if(strcmp($src,$target)!==0) {
		echo "Test $testNum Failed\nexpected\n".($target)."\ngot\n".($src)."<br/>\n";
	}else echo "\nTest $testNum OK<br/>\n";
}
include 'crXml.php';

$x=new crXml();
$x->records->name='sandeep';

$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
<name>sandeep</name>
</records>
EOB;
test($x,$target,1);

$x=new crXml();
$x->records->addNameSpace(array('prfx'=>'http://base.google.caaaom/ns/1.0'));
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://base.google.caaaom/ns/1.0"/>
EOB;
test($x,$target,2);

$x=new crXml();
$x->records[5]->name='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records/>
<records/>
<records/>
<records/>
<records/>
<records>
<name>sandeep</name>
</records>
EOB;
test($x,$target,3);

$x=new crXml();
$x->records[5]->name[5]='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records/>
<records/>
<records/>
<records/>
<records/>
<records>
<name/>
<name/>
<name/>
<name/>
<name/>
<name>sandeep</name>
</records>
EOB;
test($x,$target,4);


$x=new crXml();
$x->records->person->name='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
<person>
<name>sandeep</name>
</person>
</records>
EOB;
test($x,$target,5);


$x=new crXml();
$x->records->person[0]->name='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
<person>
<name>sandeep
</name>
</person>
</records>
EOB;
test($x,$target,6);

$x=new crXml();
$x->records[0]->person[0]->name='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
<person>
<name>sandeep</name>
</person>
</records>
EOB;
test($x,$target,7);

$x=new crXml();
$x->records[0]->person[0]->name[0]='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
<person>
<name>sandeep</name>
</person>
</records>
EOB;
test($x,$target,8);


$x=new crXml();
$x->records[1]->person[0]->name='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records/>
<records>
<person>
<name>sandeep</name>
</person>
</records>
EOB;
test($x,$target,9);



$x=new crXml();
$x->records[1]->person[1]->name='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records/>
<records>
<person/>
<person>
<name>sandeep
</name>
</person>
</records>
EOB;
test($x,$target,10);

$x=new crXml();
$x->records[1]->person[1]->name[1]='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records/>
<records>
<person/>
<person>
<name/>
<name>sandeep</name>
</person>
</records>
EOB;
test($x,$target,11);

$x=new crXml();
$r=$x->records->addNameSpace(array('prfx'=>'http://google.com'));
$x->records[1]->person[1]->name='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com"/>
<records>
<person/>
<person>
<name>sandeep</name>
</person>
</records>
EOB;
test($x,$target,12);

$x=new crXml();
$r=$x->records->addNameSpace(array('prfx'=>'http://google.com'));
$x->records[1]->person[1]->name='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com"/>
<records>
<person/>
<person>
<name>sandeep</name>
</person>
</records>
EOB;
test($x,$target,13);



$x=new crXml();
$r=$x->records->addNameSpace(array('prfx'=>'http://google.com'));
$x->records->person[1]->{'prfx:name'}='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com">
<person/>
<person>
<prfx:name>sandeep</prfx:name>
</person>
</records>
EOB;
test($x,$target,14);


$x=new crXml();
$r=$x->records->addNameSpace(array('prfx'=>'http://google.com'));
$x->records->person[1]->{'prfx:name'}[3]='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com">
<person/>
<person>
<prfx:name></prfx:name>
<prfx:name></prfx:name>
<prfx:name></prfx:name>
<prfx:name>sandeep</prfx:name>
</person>
</records>
EOB;
test($x,$target,15);




$x=new crXml();
$r=$x->records->addNameSpace(array('prfx'=>'http://google.com'));
$x->records->{'prfx:person'}[1]->{'prfx:name'}[3]='sandeep';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com">
<prfx:person></prfx:person>
<prfx:person>
<prfx:name></prfx:name>
<prfx:name></prfx:name>
<prfx:name></prfx:name>
<prfx:name>sandeep</prfx:name>
</prfx:person>
</records>
EOB;
test($x,$target,16);


$x=new crXml();
$r=$x->records->addNameSpace(array('prfx'=>'http://google.com'));
$x->records->{'prfx:person'}[1]->{'prfx:name'}[3]='sandeep';
$x->records->{'prfx:person'}[1]->{'prfx:name'}[3]['callsign']='max';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com">
<prfx:person></prfx:person>
<prfx:person>
<prfx:name></prfx:name>
<prfx:name></prfx:name>
<prfx:name></prfx:name>
<prfx:name callsign="max">sandeep</prfx:name>
</prfx:person>
</records>
EOB;
test($x,$target,17);



$x=new crXml();
$r=$x->records->addNameSpace(array('prfx'=>'http://google.com'));
$x->records->{'prfx:person'}[1]->{'prfx:name'}[3]->name='sandeep';
$x->records->{'prfx:person'}[1]->{'prfx:name'}[1]->name='max';
$x->records->{'prfx:person'}[1]->{'prfx:name'}[2]->name='deepu';
ob_start();
foreach($x->records->{'prfx:person'}[1] as $k=>$v) {
echo $v->name;
}
$output=ob_get_clean();
testCmp("maxdeepusandeep",$output,18);


/*
$x=new crXml();
$x->loadXML(file_get_contents('xml.xml'));
testCmp("false",$x->rss->channel->item[0]->guid['isPermaLink'],19);
testCmp("false_1",$x->rss->channel->item[1]->guid['isPermaLink'],20);
testCmp("false_2",$x->rss->channel->item[2]->guid['isPermaLink'],21);
testCmp("false_3",$x->rss->channel->item[3]->guid['isPermaLink'],22);
foreach($x->rss->channel as $k=>$v) echo $v->title;
*/
$x=new crXml();
$x->root->person['name']='sandeep';
ob_start();
var_dump(isset($x->root->person['name']));
$output=ob_get_clean();
testCmp("bool(true)\n",$output,23);
ob_start();
var_dump(isset($x->root->person['place']));
$output=ob_get_clean();
testCmp("bool(false)\n",$output,24);

$x->person->name=  (object)'johnson&johnson';
testCmp('johnson&johnson',(string)$x->person->name,25);
testCmp('',(string)$x->person,26);

$x=new crXml();
$r=$x->records->addNameSpace(array('prfx'=>'http://google.com'));
$r->{'prfx:person'}[1]->{'prfx:name'}[2]->name=(object)'deepu';
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com"><prfx:person></prfx:person><prfx:person><prfx:name></prfx:name><prfx:name></prfx:name><prfx:name><name><![CDATA[deepu]]></name></prfx:name></prfx:person></records>
EOB;
test($x,$target,27);
$x=new crXml();
$r=$x->records->addNameSpace(array('prfx'=>'http://google.com'));
$r->{'prfx:person'}[1]->{'prfx:name'}[2]->name=(object)'deepu';
unset($r->{'prfx:person'}[0]);
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com"><prfx:person><prfx:name></prfx:name><prfx:name></prfx:name><prfx:name><name><![CDATA[deepu]]></name></prfx:name></prfx:person></records>
EOB;
test($x,$target,28);
$testxml = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><GetRateEstimateResponse xmlns="http://www.yahoo.com" ><GetRateEstimateResult><TotalTransit><bg>01</bg></TotalTransit><EstimateNumber>001874842</EstimateNumber><ShipperNumber>000541203</ShipperNumber><OriginCity>Dothan</OriginCity><OriginState>AL</OriginState><OriginZip>36302</OriginZip><OriginCountryCode>USA</OriginCountryCode><OriginTerminal>DOT</OriginTerminal><DestinationCity>Dothan</DestinationCity><DestinationState>AL</DestinationState><DestinationZip>36301</DestinationZip><DestinCountryCode>USA</DestinCountryCode><DestinTerminal>DOT</DestinTerminal><BillDate>030409</BillDate><PrePaidCollect>P</PrePaidCollect><Tariff>501</Tariff><Discount /><RateBase>0040</RateBase><TotalActualWeight>50</TotalActualWeight><DetailLineCount>6</DetailLineCount><TotalAsWeight>50</TotalAsWeight><TotalCharges>325.35</TotalCharges><CODAmount>1000</CODAmount><Floor>71.25</Floor><Line><Description>Testing please dont process. This is for Testing            </Description><Class>60</Class><Weight>50</Weight><Charges>71.25</Charges><Accessorial>M</Accessorial><HandlingUnits>23</HandlingUnits><HandlingUnitType>PALLETS</HandlingUnitType><Packages /><Rate /><Cube /><Length /><Height /><Width /></Line><Line><Description>Coll on Delvry $10.00****     </Description><Class /><Weight /><Charges>60.00</Charges><Accessorial>CFC</Accessorial><HandlingUnits /><HandlingUnitType /><Packages /><Rate /><Cube /><Length /><Height /><Width /></Line><Line><Description>MINE DELIVERY                 </Description><Class /><Weight /><Charges>35.00</Charges><Accessorial>MND</Accessorial><HandlingUnits /><HandlingUnitType /><Packages /><Rate /><Cube /><Length /><Height /><Width /></Line><Line><Description>IN BOND CHARGE                </Description><Class /><Weight /><Charges>85.00</Charges><Accessorial>INB</Accessorial><HandlingUnits /><HandlingUnitType /><Packages /><Rate /><Cube /><Length /><Height /><Width /></Line><Line><Description>INSIDE PICKUP                 </Description><Class /><Weight /><Charges>57.00</Charges><Accessorial>ISP</Accessorial><HandlingUnits /><HandlingUnitType /><Packages /><Rate /><Cube /><Length /><Height /><Width /></Line><Line><Description>Fuel Surcharge 24.00 PCT      </Description><Class /><Weight /><Charges>17.10</Charges><Accessorial /><HandlingUnits /><HandlingUnitType /><Packages /><Rate /><Cube /><Length /><Height /><Width /></Line><GuaranteedDeliveryFee>44.00</GuaranteedDeliveryFee><TotalChargesWithGuaranteedDeliveryFee>369.35</TotalChargesWithGuaranteedDeliveryFee></GetRateEstimateResult></GetRateEstimateResponse></soap:Body></soap:Envelope>';

$x=new crXml();
$x->loadXML($testxml);
testCmp('01',$x->{'soap:Envelope'}->{'soap:Body'}->{'http://www.yahoo.com|GetRateEstimateResponse'}->GetRateEstimateResult->TotalTransit->bg,29);

$x=new crXml();
$target=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
<name>sandeep</name>
</records>
EOB;
$x->loadXML($target);
testCmp($x->records->name,'sandeep',30);

$x=new crXml();
$xml=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
<name>sandeep</name>
<name>max</name>
</records>
EOB;

$x->loadXML($xml);
testCmp($x->records->name[1],'max',31);

$x=new crXml();
$xml=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prf = 'http://yahoo.com'>
<prf:name>sandeep</prf:name>
<prf:name>max</prf:name>
</records>
EOB;

$x->loadXML($xml);
testCmp($x->records->{'prf:name'}[1],'max',32);

$x=new crXml();
$xml=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
	<records xmlns = 'http://yahoo.com'>
		<name>sandeep</name>
		<name>max</name>
	</records>
EOB;

$x->loadXML($xml);
testCmp($x->{'http://yahoo.com|records'}->name[1],'max',33);

$x=new crXml();
$xml=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
	<prf:records xmlns:prf = 'http://yahoo.com'>
		<prf:name>sandeep</prf:name>
		<prf:name>max</prf:name>
	</prf:records>
EOB;

$x->loadXML($xml);
testCmp($x->{'prf:records'}->{'prf:name'}[1],'max',34);

$x=new crXml();
$xml=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com"><prfx:person><prfx:name></prfx:name><prfx:name></prfx:name><prfx:name><name><![CDATA[deepu]]></name></prfx:name></prfx:person></records>
EOB;

$x->loadXML($xml);
testCmp($x->records->{'prfx:person'}->{'prfx:name'}[2]->name,'deepu',35);
$x=new crXml();
$xml=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records><person><name></name><name></name><name><![CDATA[deepu]]></name></person></records>
EOB;
$x->loadXML($xml);
$r = $x->records->person->name[2];
$r->a = $r;
$target = <<<EOB
<?xml version="1.0" encoding="UTF-8"?><records><person><name/><name/><name><![CDATA[deepu]]><a><![CDATA[deepu]]><a><![CDATA[deepu]]></a></a></name></person></records>
EOB;
test($x,$target,36);


$x=new crXml();
$xml=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com"><prfx:person><prfx:name></prfx:name><prfx:name></prfx:name><prfx:name><name>deepu</name></prfx:name></prfx:person></records>
EOB;
$x->loadXML($xml);
$r = $x->records->{'prfx:person'}->{'prfx:name'}[2];
$r->a = $r->name;
$target = <<<EOB
<?xml version="1.0" encoding="UTF-8"?><records xmlns:prfx="http://google.com"><prfx:person><prfx:name/><prfx:name/><prfx:name><name>deepu</name><a>deepu</a></prfx:name></prfx:person></records>
EOB;
test($x,$target,37);

$x=new crXml();
$xml=<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records xmlns:prfx="http://google.com"><prfx:person><prfx:name></prfx:name><prfx:name></prfx:name><prfx:name><name><![CDATA[deepu]]></name></prfx:name></prfx:person></records>
EOB;
$x->loadXML($xml);
$y= new crXml();
$y->b="test";
$y->c="testc";


$x->records->newnode = $y;



$target = <<<EOB
<?xml version="1.0" encoding="UTF-8"?><records xmlns:prfx="http://google.com"><prfx:person><prfx:name/><prfx:name/><prfx:name><name><![CDATA[deepu]]></name></prfx:name></prfx:person><newnode><b>test</b><c>testc</c></newnode></records>

EOB;
test($x,$target,38);

/*
$x=new crXml();
$x->loadXML($testxml);
//testCmp('01',$x->{'soap:Envelope'}->{'soap:Body'}->addNameSpace(array('aatom'=>'http://www.yahoo.com'))->{'aatom:GetRateEstimateResponse'}->GetRateEstimateResult->TotalTransit->bg,30);
$x->dump();

//echo $x->{'soap:Envelope'}->{'soap:Body'}->{'http://www.yahoo.com|GetRateEstimateResponse'}->GetRateEstimateResult->TotalTransit->bg;
//echo $x->{'soap:Envelope'}->{'soap:Body'}->addNameSpace(array('atom'=>'http://www.yahoo.com'))->{'atom:GetRateEstimateResponse'}->GetRateEstimateResult->TotalTransit->bg;
*/

$x = new crXml();
$xml = <<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
	<person age="15">
		<name>
			alex
		</name>
	</person>
	<person age="28">
		<name>
			sandeep
		</name>
	</person>
</records>
EOB;

$x->loadXML($xml);

$x->records->person[1]['age'] = '30';    //sets second persons attribute to 30
$x->records->person[1]->name = 'albert';  // sets child node ‘name’ of second person to ‘albert’

$target = <<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
	<person age="15">
		<name>
			alex
		</name>
	</person>
	<person age="30">
		<name>albert</name>
	</person>

</records>
EOB;
test($x,$target,39);
unset($x->records->person[1]);            // unsets or removes the first 'person' child of records
$target =<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
	<person age="15">
		<name>
			alex
		</name>
	</person>
	
</records>
EOB;
test($x,$target,40);

$x->records->emptyNode();
$target =<<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records/>
EOB;
test($x,$target,41);


$x = new crXml();
$xml = <<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<records>
	<person age="15">
		<name>
			alex
		</name>
	</person>
	<person age="28">
		<name>
			sandeep
		</name>
	</person>
</records>
EOB;

$x->loadXML($xml);

$x->records->person[1]->remove();
//echo $x->xml();



