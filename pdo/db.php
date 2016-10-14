<?php
require_once('conf.php');
require 'db/db.class.php';

/**
 * 初始化 pdo 对象实例
 * @return object->PDO
 */
function pdo() {
	global $config;
	static $db;
	if(empty($db)) {
		$db = new DB($config['db']['database']);
	}
	return $db;
}

/**
 * 执行一条非查询语句
 *
 * @param string $sql
 * @param array or string $params
 * @return mixed
 *		  成功返回受影响的行数
 *		  失败返回FALSE
 */
function pdo_query($sql, $params = array()) {
	return pdo()->query($sql, $params);
}

/**
 * 执行SQL返回第一个字段
 *
 * @param string $sql
 * @param array $params
 * @param int $column 返回查询结果的某列，默认为第一列
 * @return mixed
 */
function pdo_fetchcolumn($sql, $params = array(), $column = 0) {
	return pdo()->fetchcolumn($sql, $params, $column);
}
/**
 * 执行SQL返回第一行
 *
 * @param string $sql
 * @param array $params
 * @return mixed
 */
function pdo_fetch($sql, $params = array()) {
	return pdo()->fetch($sql, $params);
}
/**
 * 执行SQL返回全部记录
 *
 * @param string $sql
 * @param array $params
 * @return mixed
 */
function pdo_fetchall($sql, $params = array(), $keyfield = '') {
	return pdo()->fetchall($sql, $params, $keyfield);
}

/**
 * 更新记录
 *
 * @param string $table
 * @param array $data
 *		  要更新的数据数组
 *		  array(
 *			  '字段名' => '值'
 *		  )
 * @param array $params
 *		  更新条件
 *		  array(
 *			  '字段名' => '值'
 *		  )
 * @param string $glue
 *		  可以为AND OR
 * @return mixed
 */
function pdo_update($table, $data = array(), $params = array(), $glue = 'AND') {
	return pdo()->update($table, $data, $params, $glue);
}

/**
 * 更新记录
 *
 * @param string $table
 * @param array $data
 *		  要更新的数据数组
 *		  array(
 *			  '字段名' => '值'
 *		  )
 * @param boolean $replace
 *		  是否执行REPLACE INTO
 *		  默认为FALSE
 * @return mixed
 */
function pdo_insert($table, $data = array(), $replace = FALSE) {
	return pdo()->insert($table, $data, $replace);
}

/**
 * 删除记录
 *
 * @param string $table
 * @param array $params
 *		  更新条件
 *		  array(
 *			  '字段名' => '值'
 *		  )
 * @param string $glue
 *		  可以为AND OR
 * @return mixed
 */
function pdo_delete($table, $params = array(), $glue = 'AND') {
	return pdo()->delete($table, $params, $glue);
}

/**
 * 返回lastInsertId
 *
 */
function pdo_insertid() {
	return pdo()->insertid();
}

function pdo_begin() {
	pdo()->begin();
}

function pdo_commit() {
	pdo()->commit();
}

function pdo_rollback() {
	pdo()->rollBack();
}

/**
 * 获取pdo操作错误信息列表
 * @param bool $output 是否要输出执行记录和执行错误信息
 * @param array $append 加入执行信息，如果此参数不为空则 $output 参数为 false
 * @return array
 */
function pdo_debug($output = false, $append = array()) {
	return pdo()->debug($output, $append);
}
/**
 * 执行SQL文件
 */
function pdo_run($sql) {
	return pdo()->run($sql);
}

function pdo_fieldexists($tablename, $fieldname = '') {
	return pdo()->fieldexists($tablename, $fieldname);
}

function pdo_indexexists($tablename, $indexname = '') {
	return pdo()->indexexists($tablename, $indexname);
}
/**
 * 获取所有字段,用于过滤字段
 * @param string $tablename 原始表名
 * @return array 所有表名 array('col1','col2');
 */
function pdo_fetchallfields($tablename){
	$fields = pdo_fetchall("DESCRIBE {$tablename}", array(), 'Field');
	$fields = array_keys($fields);
	return $fields;
}
function tablename($table) {
global $config;
	return $config['db']['tablepre'] .$table;
}





/**
* 
* 测试变量 数组 对象
* 
* 数组
*/
if (!function_exists('dump')) {
function dump($arr){
	echo '<pre>'.print_r($arr,TRUE).'</pre>';
}

}
/**
* 
* @param 时间戳 $time
* 
* 格式化时间线
*/
function timeline($time){  
    $t = time()-$time;  
    $f = array(  
        '31536000'=>'年',  
        '2592000'=>'个月',  
        '604800'=>'星期',  
        '86400'=>'天',  
        '3600'=>'小时',  
        '60'=>'分钟',  
        '1'=>'秒'  
    );  
    foreach($f as $k=>$v){  
        if(0 != $c = floor($t/(int)$k)){  
            return $c.$v.'前';  
        }  
    }  
}

/**
* 
* @param 对象 $obj
* 
* 对象转换数组
*/
function obj2arr($obj) {
		if (is_object($obj)) {
			$obj = get_object_vars($obj);
		}
 
		if (is_array($obj)) {
			return array_map(__FUNCTION__, $obj);
		}
		else {
			return $obj;
		}
	}
/**
* 
* @param 数组 $d
* 
*数组转换对象
*/
	function arr2obj($d) {
if (is_array($d)) {

return (object) array_map(__FUNCTION__, $d);
}
else {

return $d;
}
} 
/**
* 
* @param 数组 $arr
* @param 层级 $level
* @param undefined $ptagname
* 
* 数组转换xml
*/	
	function arr2xml($arr, $level = 1, $ptagname = '') {
		$s = $level == 1 ? "<xml>" : '';
		foreach($arr as $tagname => $value) {
			if (is_numeric($tagname)) {
				$tagname = $value['TagName'];
				unset($value['TagName']);
			}
			if(!is_array($value)) {
				$s .= "<{$tagname}>".(!is_numeric($value) ? '<![CDATA[' : '').$value.(!is_numeric($value) ? ']]>' : '')."</{$tagname}>";
			} else {
				$s .= "<{$tagname}>".self::arr2xml($value, $level + 1)."</{$tagname}>";
			}
		}
		$s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
		return $level == 1 ? $s."</xml>" : $s;
	}
/**
* 
* @param 文件名 $file
* 
* 获取文件扩展名
*/
function file_ext($file){
	return strtolower(pathinfo($file,4));
}	
/**
* 
* @param 文件名或路径 $file
* 
* 删除文件夹或文件
*/
function file_delete($file){
    if (empty($file))
    	return false;
    if (@is_file($file))
        return @unlink($file);
   	$ret = true;
   	if ($handle = @opendir($file)) {
		while ($filename = @readdir($handle)){
			if ($filename == '.' || $filename == '..')
				continue;
			if (!file_delete($file . '/' . $filename))
				$ret = false;
		}
   	} else {
   		$ret = false;
   	}
   	@closedir($handle);
	if ( file_exists($file) && !rmdir($file) ){
		$ret = false;
	}
   	return $ret;
}

/**
* 
* @param 文件夹 $folder
* @param undefined $levels
* 
* 列出文件
*/
function file_list($folder = '', $levels =10 ) {
    if( empty($folder) )
        return false;

    if( ! $levels )
        return false;

    $files = array();
    if ( $dir = @opendir( $folder ) ) {
        while (($file = readdir( $dir ) ) !== false ) {
            if ( in_array($file, array('.', '..') ) )
                continue;
            if ( is_dir( $folder . '/' . $file ) ) {
                $files2 = file_list( $folder . '/' . $file, $levels -1);
                if( $files2 )
                    $files = array_merge($files, $files2 );
                else
                    $files[] = $folder . '/' . $file . '/';
            } else {
                $files[] = $folder . '/' . $file;
            }
        }
    }
    @closedir( $dir );
    return $files;
}
/**
* 
* @param 字节大小 $size
* @param 保留小数位数 $dec
* 
* 格式化文件大小
*/
function file_size($size, $dec=2) {
	$a = array("B", "KB", "MB", "GB", "TB", "PB");
	$pos = 0;
	while ($size >= 1024) {
		 $size /= 1024;
		   $pos++;
	}
	return round($size,$dec)." ".$a[$pos];
}

/**
* 
* @param 字符串 $str
* @param 长度 $length
* @param 开始位置 $start
* @param 是否显示... $suffix
* @param 编码 $charset
* 
* 截取字符串
*/
function strcut($str,$length, $start=0, $suffix=true,$charset="utf-8") {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
* 
* @param 长度 $l
* 最长32
* 生成密码等随机长度字符串
*/
function strrandom($l=6){
 return substr(md5(time()),0,$l); 
}
/**
* 
* @param 生成字符长度 $len
* @param 生成类型默认大小写数字,0大小写 1数字 2大写 3小写 4中文 $type
* @param 添加字符后缀 $addChars
* 
* @return
*/
function strrandom1($len=6,$type='',$addChars='') {
    $str ='';
    switch($type) {
        case 0:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 1:
            $chars= str_repeat('0123456789',3);
            break;
        case 2:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
            break;
        case 3:
            $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 4:
            $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
            break;
        default :
            $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
            break;
    }
    if($len>10 ) {
        $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
    }
    if($type!=4) {
        $chars   =   str_shuffle($chars);
        $str     =   substr($chars,0,$len);
    }else{
        for($i=0;$i<$len;$i++){
          $str.= strcut($chars,1, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),0);
        }
    }
    return $str;
}

/**
* 
* 
* 获取ip
*/
function get_ip(){
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if(!preg_match("/^\d+\.\d+\.\d+\.\d+$/", $ip)){
		$ip = '0';
	}
	return $ip;
}
/**
* 生成avatar头像
* @param 邮箱 $email
* @param 大小 $s
* @param undefined $d
* @param undefined $g
* 
* @return
*/
function get_avatar($email='', $s=40, $d='mm', $g='g') {
	$hash = md5($email);
	$avatar = "http://www.gravatar.com/avatar/$hash?s=$s&d=$d&r=$g";
	return $avatar;
}
/**
* 
* @param 要编码内容 $string
* @param ENCODE加密 默认解密 $operation
* @param 蜜月 $key
* @param undefined $expiry
* 
* @return
*/
function str_authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    $ckey_length = 4;
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}
/**
* 转换数字成大写
* @param 要转化数字 $num
* 
* @return
*/
function get_rmb($num){
		$c1 = "零壹贰叁肆伍陆柒捌玖";
		$c2 = "分角元拾佰仟万拾佰仟亿";
		$num = round($num, 2);
		$num = $num * 100;
		if (strlen($num) > 20) {
			return "金额过大";
		} 
		$i = 0;
		$c = "";
		while (1) {
			if ($i == 0) {
				$n = substr($num, strlen($num)-1, 1);
			} else {
				$n = $num % 10;
			} 
			$p1 = substr($c1, 3 * $n, 3);
			$p2 = substr($c2, 3 * $i, 3);
			if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
				$c = $p1 . $p2 . $c;
			} else {
				$c = $p1 . $c;
			} 
			$i = $i + 1;
			$num = $num / 10;
			$num = (int)$num;
			if ($num == 0) {
				break;
			} 
		}
		$j = 0;
		$slen = strlen($c);
		while ($j < $slen) {
			$m = substr($c, $j, 6);
			if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
				$left = substr($c, 0, $j);
				$right = substr($c, $j + 3);
				$c = $left . $right;
				$j = $j-3;
				$slen = $slen-3;
			} 
			$j = $j + 3;
		} 

		if (substr($c, strlen($c)-3, 3) == '零') {
			$c = substr($c, 0, strlen($c)-3);
		}
		if (empty($c)) {
			return "零元整";
		}else{
			return $c . "整";
		}
	}
	
	/**
* 生成随即颜色
* 
* @return
*/
function randcolor(){
    $char='abcdef0123456789';
    $str='';
       for($i=0;$i<6;$i++){
        $str .= substr($char,mt_rand(0,15),1);
    }
    return '#'.$str;
}
/**
* 自动添加http://
* @param 网站 $url
* 
* @return
*/
function addhttp($url){
	return preg_match('/(http|https):\/\//',$url)?$url:'http://'.$url;
}
//转换红色时间
function timered($time,$color='red')
	{
		if((time()-$time)>24*3600)
		{
			return timeline($time);
		}
		else
		{
			return '<span style="color:'.$color.'">'.timeline($time).'</span>';
		}
	}

/**
* 表格转换成数组
* @param 表格 $table
* 
* @return
*/
function table_arr($table) {   
        $table = preg_replace("'<table[^>]*?>'si","",$table);  
        $table = preg_replace("'<tr[^>]*?>'si","",$table);   
        $table = preg_replace("'<td[^>]*?>'si","",$table);   
        $table = str_replace("</tr>","{tr}",$table);   
        $table = str_replace("</td>","{td}",$table);   
        //去掉 HTML 标记    
        $table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table);  
        //去掉空白字符     
        $table = preg_replace("'([rn])[s]+'","",$table);
        $table = preg_replace('/&nbsp;/',"",$table);   
        $table = str_replace(" ","",$table);   
        $table = str_replace(" ","",$table);   
           
        $table = explode('{tr}', $table);   
        array_pop($table);   
        foreach ($table as $key=>$tr) {   
                $td = explode('{td}', $tr);   
                array_pop($td);   
            $td_array[] = $td;    
        }   
        return $td_array;   
}
/**
* 去除文字之间或两边空格
* @param 字符 $a
* 
* @return
*/
function strtrim($a){
	return preg_replace("/\s+/"," ",$a);
}
/**
* 年转换天干地支
* @param undefined $year
* 
* @return
*/
function tiangan($year){
         $sky = array('庚','辛','壬','癸','甲','乙','丙','丁','戊','己');
         $earth = array('申','酉','戌','亥','子','丑','寅','卯','辰','巳','午','未');
         $year = $year.'';
         return $sky[$year{3}].$earth[$year%12];
}

function shengxiao($year){
         $zodiac = array('猴','鸡','狗','猪','鼠','牛','虎','兔','龙','蛇','马','羊');
         return $zodiac[$year%12];
    }
function xingzuo($month, $day) {
 if ($month < 1 || $month > 12 || $day < 1 || $day > 31) return false;
 $constellations = array(
  array( "20" => "水瓶座"),
  array( "19" => "双鱼座"),
  array( "21" => "白羊座"),
  array( "20" => "金牛座"),
  array( "21" => "双子座"),
  array( "22" => "巨蟹座"),
  array( "23" => "狮子座"),
  array( "23" => "处女座"),
  array( "23" => "天秤座"),
  array( "24" => "天蝎座"),
  array( "22" => "射手座"),
  array( "22" => "摩羯座")
 );
 list($constellation_start, $constellation_name) = each($constellations[(int)$month-1]);
 if ($day < $constellation_start) list($constellation_start, $constellation_name) = each($constellations[($month -2 < 0) ? $month = 11: $month -= 2]);
 return $constellation_name;
}

function xingqi($y){
	$n=((string)$y=='')?(string)date("w",time()) : (string)$y;
$array=array('天','一','二','三','四','五','六');

return '星期'.$array[$n];
}

//编码成unicode
function utf8_unicode($name)
{
    $name = iconv('UTF-8', 'UCS-2', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2)
    {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0)
        {  
            // 两个字节的文字
            $str .='\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
        }
        else
        {
            $str .= $c2;
        }
    }
    return $str;
}
function unicode_utf8($name)
{
    // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}

/**
 * 对查询结果集进行排序
 *
 * @access public
 * @param array $list
 *        	查询结果
 * @param string $field
 *        	排序的字段名
 * @param array $sortby
 *        	排序类型
 *        	asc正向排序 desc逆向排序 nat自然排序
 * @return array
 *
 */
function str_orderby($list, $field, $sortby = 'asc') {
	if (is_array ( $list )) {
		$refer = $resultSet = array ();
		foreach ( $list as $i => $data )
			$refer [$i] = &$data [$field];
		switch ($sortby) {
			case 'asc' : // 正向排序
				asort ( $refer );
				break;
			case 'desc' : // 逆向排序
				arsort ( $refer );
				break;
			case 'nat' : // 自然排序
				natcasesort ( $refer );
				break;
		}
		foreach ( $refer as $key => $val )
			$resultSet [] = &$list [$key];
		return $resultSet;
	}
	return false;
}

/**
 * 把返回的数据集转换成Tree
 *
 * @param array $list
 *        	要转换的数据集
 * @param string $pid
 *        	parent标记字段
 * @param string $level
 *        	level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
	// 创建Tree
	$tree = array ();
	if (is_array ( $list )) {
		// 创建基于主键的数组引用
		$refer = array ();
		foreach ( $list as $key => $data ) {
			$refer [$data [$pk]] = & $list [$key];
		}
		foreach ( $list as $key => $data ) {
			// 判断是否存在parent
			$parentId = $data [$pid];
			if ($root == $parentId) {
				$tree [] = & $list [$key];
			} else {
				if (isset ( $refer [$parentId] )) {
					$parent = & $refer [$parentId];
					$parent [$child] [] = & $list [$key];
				}
			}
		}
	}
	return $tree;
}
/**
 * 将list_to_tree的树还原成列表
 *
 * @param array $tree
 *        	原来的树
 * @param string $child
 *        	孩子节点的键
 * @param string $order
 *        	排序显示的键，一般是主键 升序排列
 * @param array $list
 *        	过渡用的中间数组，
 * @return array 返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_list($tree, $child = '_child', $order = 'id', &$list = array()) {
	if (is_array ( $tree )) {
		$refer = array ();
		foreach ( $tree as $key => $value ) {
			$reffer = $value;
			if (isset ( $reffer [$child] )) {
				unset ( $reffer [$child] );
				tree_list ( $value [$child], $child, $order, $list );
			}
			$list [] = $reffer;
		}
		$list = str_orderby( $list, $order, $sortby = 'asc' );
	}
	return $list;
}
//输出菜单 id pid title
function menu_tree($tree, $prefix='') {
    foreach ($tree as $k => $v) {
       echo  '<option value="'.$v['id'].'">'.$prefix.$v['title'].'</option>';
        if (count($v['_child']) > 0) {
            menu_tree($v['_child'], $prefix.'--');
        }
    }
}
// 判断是否是在微信浏览器里
function is_weixin() {
	$agent = $_SERVER ['HTTP_USER_AGENT'];
	if (! strpos ( $agent, "icroMessenger" )) {
		return false;
	}
	return true;
}

// php获取当前访问的完整url地址
function get_url() {
	$url = 'http://';
	if (isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on') {
		$url = 'https://';
	}
	if ($_SERVER ['SERVER_PORT'] != '80') {
		$url .= $_SERVER ['HTTP_HOST'] . ':' . $_SERVER ['SERVER_PORT'] . $_SERVER ['REQUEST_URI'];
	} else {
		$url .= $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
	}
	// 兼容后面的参数组装
	if (stripos ( $url, '?' ) === false) {
		$url .= '?t=' . time ();
	}
	return $url;
}

/**
* 
* @param 网址 $url
* @param 提交数组 $msg
* @param 是否支持 $ssl
* 
* POST数据
*/
function post($url,$msg,$ssl=false){//post ssl
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL,$url);
if($ssl){
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
}
curl_setopt($ch, CURLOPT_POSTFIELDS,$msg);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);

return $data;
    }
/**
* 
* @param 网址 $url
* @param 是否支持 $ssl
* 
* GET数据
*/    
function get($url,$ssl=false){   
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HEADER, 0);
if($ssl){
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
}
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$data  =  curl_exec($ch);
curl_close($ch);
return $data; 
}

/**
* 
* @param 字符串 $string
* @param 要查找字符串 $find
* 
* 是否包含子字符串
*/
function strfind($string, $find) {
	return !(strpos($string, $find) === FALSE);
}

/**
* 获得使用内存
* 
* @return 内存大小
*/
function get_memory(){
  return round((memory_get_usage()/1024/1024),3)."M";
}


/*存储缓存
*$key  缓存文件名
*$value 缓存字符串货数组 值为空为 null表示删除
$cachetime 缓存时间 0是永久 其他是秒
*/
function cachedata($key,$value='',$cachetime=0){
global $config;
    $dir =$config['temp'];
		$filename = $dir.$key.'.txt';
		if('' !== $value){//写入缓存
			if(is_null($value)){
				return @unlink($filename);
			}
			$dir = dirname($filename);
			if(!is_dir($dir)){
				mkdir($dir,0777);//创建目录
			}
			
			$cachetime = sprintf('%011d',$cachetime);
			return file_put_contents($filename,$cachetime.serialize($value));
		}
		
		if(!is_file($filename)){
			return 0;
		}else{
			$content = file_get_contents($filename);
			$cachetime = (int)substr($content,0,11);
			$value = substr($content,11);
			if(0 !=$cachetime && ($cachetime+fileatime($filename) <time())){
				@unlink($filename);
				return 0;
			}
			return unserialize($value);
		}
	}

/**
* 
* @param 要压缩字符串 $string
* 
* 压缩字符串
*/
function lzw_encode($string) {  
    // compression  
    $dictionary = array_flip(range("\0", "\xFF"));  
    $word = "";  
    $codes = array();  
    for ($i=0; $i <= strlen($string); $i++) {  
        $x = @$string[$i];  
        if (strlen($x) && isset($dictionary[$word . $x])) {  
            $word .= $x;  
        } elseif ($i) {  
            $codes[] = $dictionary[$word];  
            $dictionary[$word . $x] = count($dictionary);  
            $word = $x;  
        }  
    }  
      
    // convert codes to binary string  
    $dictionary_count = 256;  
    $bits = 8; // ceil(log($dictionary_count, 2))  
    $return = "";  
    $rest = 0;  
    $rest_length = 0;  
    foreach ($codes as $code) {  
        $rest = ($rest << $bits) + $code;  
        $rest_length += $bits;  
        $dictionary_count++;  
        if ($dictionary_count > (1 << $bits)) {  
            $bits++;  
        }  
        while ($rest_length > 7) {  
            $rest_length -= 8;  
            $return .= chr($rest >> $rest_length);  
            $rest &= (1 << $rest_length) - 1;  
        }  
    }  
    return $return . ($rest_length ? chr($rest << (8 - $rest_length)) : "");  
}  
  
/**
* 
* @param 解码被压缩字符串 $binary
* 
* @return
*/ 
function lzw_decode($binary) {  
    // convert binary string to codes  
    $dictionary_count = 256;  
    $bits = 8; // ceil(log($dictionary_count, 2))  
    $codes = array();  
    $rest = 0;  
    $rest_length = 0;  
    for ($i=0; $i < strlen($binary); $i++) {  
        $rest = ($rest << 8) + ord($binary[$i]);  
        $rest_length += 8;  
        if ($rest_length >= $bits) {  
            $rest_length -= $bits;  
            $codes[] = $rest >> $rest_length;  
            $rest &= (1 << $rest_length) - 1;  
            $dictionary_count++;  
            if ($dictionary_count > (1 << $bits)) {  
                $bits++;  
            }  
        }  
    }  
      
    // decompression  
    $dictionary = range("\0", "\xFF");  
    $return = "";  
    foreach ($codes as $i => $code) {  
        $element = @$dictionary[$code];  
        if (!isset($element)) {  
            $element = $word . $word[0];  
        }  
        $return .= $element;  
        if ($i) {  
            $dictionary[] = $word . $element[0];  
        }  
        $word = $element;  
    }  
    return $return;  
}
/**
* 
* @param 开始时间戳 $begin_time
* @param 结束时间戳 $end_time
* 
* 计算时间间隔
*/
function time_day($begin_time,$end_time)
{
      if($begin_time < $end_time){
         $starttime = $begin_time;
         $endtime = $end_time;
      }
      else{
         $starttime = $end_time;
         $endtime = $begin_time;
      }
      $timediff = $endtime-$starttime;
      $days = intval($timediff/86400);
      $remain = $timediff%86400;
      $hours = intval($remain/3600);
      $remain = $remain%3600;
      $mins = intval($remain/60);
      $secs = $remain%60;
      $res = array("d" => $days,"H" => $hours,"i" => $mins,"s" => $secs);
      return $res;
}

/**
* 
* @param 倒计时时间 $settime
* 
* @return
*/
	function daojishi($settime)
	{
        $time = time();
        $settime  = strtotime($settime);
        $interval = $settime - $time;
        $days = $interval/(24*60*60);//精确到天数
        $days = intval($days);
        $hours = $interval /(60*60) - $days*24;//精确到小时
        $hours = intval($hours);
        $minutes = $interval /60 - $days*24*60 - $hours*60;//精确到分钟
        $minutes = intval($minutes);
        $seconds = $interval - $days*24*60*60 - $hours*60*60 - $minutes*60;//精确到秒
        $seconds = intval($seconds);
		$str = $days."天".$hours."小时".$minutes."分".$seconds."秒";
		if(intval($days)<0){
		$str=0;
		}
		return $str;
	}
	
/**
* 
* @param 手机号 $phone
* 
* 隐藏手机中间四位
*/	
	function hidetel($phone){
    $IsWhat = preg_match('/(0[0-9]{2,3}[-]?[2-9][0-9]{6,7}[-]?[0-9]?)/i',$phone); 
    if($IsWhat == 1){
        return preg_replace('/(0[0-9]{2,3}[-]?[2-9])[0-9]{3,4}([0-9]{3}[-]?[0-9]?)/i','$1****$2',$phone);
    }else{
        return  preg_replace('/(1[3587]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
    }
}
/*
内部方法
show 数组转换xml格式或json格式或数组输出
$code 状态码
$message 返回信息
$data 数组
$type 类型默认json 支持xml  array参数
*/
function _arr2json($code,$message='',$data = array()){
		if(!is_numeric($code)){
			return '';
		}
		$arr  =array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		echo json_encode($arr);
		exit;
	} 
	function _xml2encode($data){
		$d = '';
		$attr = '';
		foreach($data  as $k=>$v){
			if(is_numeric($k)){
				
				$attr = "id='{$k}'";
				$k ="item";
			}
			$d  .= "<{$k} {$attr}>";
			$d .=is_array($v)?self::_xml2encode($v) : $v;
			$d .="</{$k}>";
		}
		
		return $d;
	}
function _arr2xml($code,$message='',$data = array()){
		if(!is_numeric($code)){
			return '';
		}
		$arr  =array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		
		header("Content-Type:text/xml");
		
		
		$xml .= '<?xml   version="1.0"   encoding="utf-8"?>';
		$xml  .='<root>';
		$xml .="<code>{$code}</code>";
		$xml .="<message>{$message}</message>";
		$xml .="<data>";
		$xml  .=_xml2encode($data);
		$xml .="</data>";
		$xml .='</root>';
		
		echo $xml;
	}	
	function show($code,$message='',$data = array(),$type='json'){
				if(!is_numeric($code)){
			return '';
		}
				$arr  =array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		$type = isset($_GET['format'])?$_GET['format']:$type;
		if('json' == $type){
			_arr2json($code,$message,$data);
			exit;
		}elseif('xml' ==$type){
			_arr2xml($code,$message,$data);
			exit;
		}elseif('array' ==$type){
			echo '<pre>'.print_r($data,TRUE).'</pre>';
		}
		
	}
	
/**
* 
* @param 年月日 $date
* 
* 计算生日
*/	
	function age($date){
    $year_diff = '';
    $time = strtotime($date);
    if(FALSE === $time){
        return '';
    }

    $date = date('Y-m-d', $time);
    list($year,$month,$day) = explode("-",$date);
    $year_diff = date("Y")-$year;
    $month_diff = date("m")-$month;
    $day_diff = date("d")-$day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff;

    return $year_diff;
}

/*
$total 红包总额
$num 发几个
$min  最小红包
*/
function get_hongbao($total, $num = 10,$min = 0.01)
{
$money_arr = array();
$return_arr = array();
for ($i = 1; $i <$num; ++$i) {
$max =round($total, 2)/($num-$i);
$random =  0.01+ mt_rand() / mt_getrandmax() * (0.99- 0.01); 
$money = $random*$max;
$money = $money<=$min?0.01:$money;
$money =floor($money*100)/100;
$total = $total - $money;
$money_arr[$i] = round($money, 2);
}
$money_arr[$i] = round($total, 2);
shuffle($money_arr);
$return_arr['money'] = $money_arr;
$return_arr['total'] = array_sum($money_arr);
$return_arr['max']=max($money_arr);
return $return_arr;
}
/*概率算法
proArr array(100,200,300，400)
*/
function get_rand($proArr) { 
    $result = '';  
    $proSum = array_sum($proArr);   
    foreach ($proArr as $key => $proCur) { 
        $randNum = mt_rand(1, $proSum); 
        if ($randNum <= $proCur) { 
            $result = $key; 
            break; 
        } else { 
            $proSum -= $proCur; 
        } 		
    } 
    unset ($proArr);  
    return $result; 
}
/*
function  get_prize(){//获取中奖
$prize_arr = array( 
    array('id'=>1,'prize'=>'平板电脑','v'=>1), 
    array('id'=>2,'prize'=>'数码相机','v'=>1), 
    array('id'=>3,'prize'=>'音箱设备','v'=>1), 
   array('id'=>4,'prize'=>'4G优盘','v'=>1), 
   array('id'=>5,'prize'=>'10Q币','v'=>1), 
   array('id'=>6,'prize'=>'下次没准就能中哦','v'=>95), 
);
foreach ($prize_arr as $key => $val) { 
    $arr[$val['id']] = $val['v']; 
} 
$ridk = get_rand($arr); //根据概率获取奖项id 

$res['yes'] = $prize_arr[$ridk-1]['prize']; //中奖项 
unset($prize_arr[$ridk-1]); //将中奖项从数组中剔除，剩下未中奖项 
shuffle($prize_arr); //打乱数组顺序 
for($i=0;$i<count($prize_arr);$i++){ 
    $pr[] = $prize_arr[$i]['prize']; 
} 
$res['no'] = $pr;
return $res;
}
*/
//昵称转换成utf8直接存储到数据库
 function emojien($str){
    if(!is_string($str))return $str;
    if(!$str || $str=='undefined')return '';

    $text = json_encode($str);
    $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
        return addslashes($str[0]);
    },$text); 
    return json_decode($text);
}
//显示解码
 function emojide($str){
    $text = json_encode($str);
    $text = preg_replace_callback('/\\\\\\\\/i',function($str){
        return '\\';
    },$text);
    return json_decode($text);
}
/*
生成20位长度sn
*/
function sn(){
return date('YmdHis') . str_pad(mt_rand(1, 99999), 6, '0', STR_PAD_LEFT);
}