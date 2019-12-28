<?php
/*
* 文件名: function.php
* 作者  : Yoby 微信logove email:logove@qq.com
* 日期时间: 2019/12/14  21:31
* 功能  :
*/
if (!function_exists('dump')) {
    function dump($arr){
        echo '<pre>'.print_r($arr,TRUE).'</pre>';
    }

}
if (!function_exists('curl')) {
    /**
     * @param $url Curl请求支持POST和GET|传入url
     * @param string $data
     * @return string
     */
    function curl($url, $data = '')
    {
        $ch = curl_init();
        if (class_exists('\CURLFile')) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        } else {
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            }
        }
        preg_match('/https:\/\//', $url) ? $ssl = TRUE : $ssl = FALSE;
        if ($ssl) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($data)) {
            if (is_array($data))
            {
                $data = http_build_query($data, null, '&');
            }
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $d = curl_exec($ch);
        curl_close($ch);
        return $d;
    }
}
if (!function_exists('getoauth')) {
    /**
     * @param $type 微信授权获取用户信息snsapi_userinfo|snsapi_base
     * @param  $appid
     * @param  $apps
     * @param  $expired 过期时间
     * @return array
     */
    function getoauth($type = 'snsapi_base', $appid = '', $apps = '', $expired = '600')
    {
        $scheme = $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
        $baseUrl = urlencode($scheme . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);

        if (!isset($_GET['code'])) {
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$baseUrl&response_type=code&scope=$type#wechat_redirect";
            header("location:$url");
            exit();
        } else {
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$apps&code=" . $_GET['code'] . "&grant_type=authorization_code";

            $output = (array)json_decode(curl($url));
            if ($type == 'snsapi_base') {
                return $output['openid'];
            } else {
                $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $output['access_token'] . '&openid=' . $output['openid'] . '&lang=zh_CN';
                $output = (array)json_decode(curl($url));
                return $output;
            }

        }
    }
}
if (!function_exists('setcache')) {
    /**
     * @param $name 设置文件缓存|传入文件名
     * @param $value 内容
     * @param  $expire  过期时间秒默认7000秒
     * @return bool
     */
    function setcache($name, $value, $expire = 7000)
    {
        $filename = "./$name._cache.php";
        $json = json_encode(array($name => $value, "expire" => time() + $expire));
        $result = file_put_contents($filename, $json);
        if ($result) {
            return true;
        }
        return false;
    }
}
if (!function_exists('getcache')) {
    /**
     * @param $name 返回文件缓存内容|传入文件名
     * @return string
     */
    function getcache($name)
    {
        $filename = "./$name._cache.php";
        if (!is_file($filename)) {
            return false;
        }
        $content = file_get_contents($filename);

        $arr = json_decode($content, true);
        if ($arr['expire'] <= time()) {
            return false;
        }
        return $content;
    }
}
if (!function_exists('json')) {
    /**
     * @param  $code JSON格式生成传入代码编号
     * @param  $message 提示信息
     * @param  $list 数组或字符串
     * @param  $total 数据条数
     */
    function json($code = 200, $message = '请求成功', $list =[], $total = 0)
    {
        $json = [
            'code' => $code,
            'msg' => $message
        ];
        if (!empty($list)) {
            $json['data'] = $list;
        }
        if (!empty($total)) {
            $json['total'] = $total;
        }
        header("Access-Control-Allow-Origin:*");
        header('Content-type: application/json');
        exit(json_encode($json, 256));
    }
}
if (!function_exists('tablearr')) {
    /**
     * @param $table 表格html转换成数组|传入字符串
     * @return array
     */
    function tablearr($table)
    {
        $table = preg_replace("'<table[^>]*?>'si", "", $table);
        $table = preg_replace("'<tr[^>]*?>'si", "", $table);
        $table = preg_replace("'<td[^>]*?>'si", "", $table);
        $table = str_replace("</tr>", "{tr}", $table);
        $table = str_replace("</td>", "{td}", $table);
        //去掉 HTML 标记
        $table = preg_replace("'<[/!]*?[^<>]*?>'si", "", $table);
        //去掉空白字符
        $table = preg_replace("'([rn])[s]+'", "", $table);
        $table = preg_replace('/&nbsp;/', "", $table);
        $table = str_replace(" ", "", $table);
        $table = str_replace(" ", "", $table);
        $table = str_replace("\r", "", $table);
        $table = str_replace("\t", "", $table);
        $table = str_replace("\n", "", $table);
        $table = explode('{tr}', $table);
        array_pop($table);
        foreach ($table as $key => $tr) {
            $td = explode('{td}', $tr);
            array_pop($td);
            $td_array[] = $td;
        }
        return $td_array;
    }
}
if (!function_exists('findstr')) {
    /**
     * @param $string 是否包含子字符串
     * @param $find 子字符串
     * @return bool
     */
    function findstr($string, $find)
    {
        return !(strpos($string, $find) === FALSE);
    }
}
/**
 * emoji转换成utf8,方便存储,支持还原
 * de是解码  en编码
 */
if (!function_exists('emoji')) {
    /**
     * @param $str emoji编码解码默认编码
     * @param  $is en是编码de解码
     * @return string
     */
    function emoji($str, $is = 'en')
    {
        if ('en' == $is) {
            if (!is_string($str)) return $str;
            if (!$str || $str == 'undefined') return '';

            $text = json_encode($str);
            $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i", function ($str) {
                return addslashes($str[0]);
            }, $text);
            return json_decode($text);
        } else {
            $text = json_encode($str);
            $text = preg_replace_callback('/\\\\\\\\/i', function ($str) {
                return '\\';
            }, $text);
            return json_decode($text);
        }
    }
}
if (!function_exists('emoji_encode')) {
    /**
     * @param $str emoji转换实体推荐使用有同名js函数
     * @return string
     */
function emoji_encode($str){
    preg_match_all('/./u',$str,$matches);
    $unicodeStr = "";
    foreach($matches[0] as $m){
        $unicodeStr .=(strlen($m) >= 4 )?"&#".base_convert(bin2hex(iconv('UTF-8',"UCS-4",$m)),16,10).';':$m;
    }
    return $unicodeStr;
}}
if (!function_exists('timeline')) {
    /**
     * @param $time 时间戳友好显示|传入时间戳
     * @return string
     */
    function timeline($time)
    {
        if (time() <= $time) {
            return date("Y-m-d H:i:s", $time);
        } else {
            $t = time() - $time;
            $f = array(
                '31536000' => '年',
                '2592000' => '个月',
                '604800' => '星期',
                '86400' => '天',
                '3600' => '小时',
                '60' => '分钟',
                '1' => '秒'
            );
            foreach ($f as $k => $v) {
                if (0 != $c = floor($t / (int)$k)) {
                    return $c . $v . '前';
                }
            }
        }
    }
}
if (!function_exists('fileext')) {
    /**
     * @param $file 获取文件扩展名|传入文件名
     * @return string
     */
    function fileext($file)
    {
        return strtolower(pathinfo($file, 4));
    }
}
if (!function_exists('isajax')) {
    /**
     *
     * @return 是否ajax提交bool
     */
    function isajax()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') return true;
        if(isset($_GET['HTTP_X_REQUESTED_WITH'])    && $_GET['HTTP_X_REQUESTED_WITH']    == 'XMLHttpRequest') return true;
        return false;
    }
}
if (!function_exists('putcsv')) {
    /**
     * @param $filename 生成csv文件|传入文件名
     * @param $arr 传入数据数组array
     * @return void
     * $arr = array(
     * array('用户名','密码','邮箱'),
     * array(
     * array('A用户','123456','xiaohai1@zhongsou.com'),
     * array('B用户','213456','xiaohai2@zhongsou.com'),
     * array('C用户','123456','xiaohai3@zhongsou.com')
     * ));
     * putcsv("导出文件",$arr);
     *
     * 导出csv模板
     * $arr = array(array('用户名','密码','邮箱'));
     * putcsv("导出模板",$arr);
     */
    function putcsv($filename, $arr)
    {
        if (empty($arr)) {
            return false;
        }
        $export_str = implode(',', $arr[0]) . "\n";

        if (!empty($arr[1])) {
            foreach ($arr[1] as $k => $v) {

                $export_str .= implode(',', $v) . "\n";

            }
        }
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . date('Y-m-d-H-i-s') . ".csv");
        ob_start();
        ob_end_clean();
        //echo "\xEF\xBB\xBF" . $export_str;//解决WPS和excel不乱码
        echo mb_convert_encoding($export_str,'GBK','utf-8');
    }
}
if (!function_exists('getcsv')) {
    /**
     * @param $path 读取csv文件
     * @return array
     */
    function getcsv($path)
    {
        $handle = fopen($path, 'r');
        $dataArray = array();
        $row = 0;
        while ($data = fgetcsv($handle)) {
            $num = count($data);

            for ($i = 0; $i < $num; $i++) {
                $dataArray[$row][$i] = mb_convert_encoding($data[$i], "utf-8","GBK,ANSI");
            }
            $row++;

        }

        return $dataArray;
    }
}
if (!function_exists('isweixin')) {
    /**
     * @return 判断是否微信内bool
     */
    function isweixin()
    {
        $agent = $_SERVER ['HTTP_USER_AGENT'];
        if (!strpos($agent, "icroMessenger")) {
            return false;
        }
        return true;
    }
}
if (!function_exists('hidetel')) {
    /**
     * @param $phone 隐藏手机号中间四位
     * @return string
     */
    function hidetel($phone)
    {
        $IsWhat = preg_match('/(0[0-9]{2,3}[-]?[2-9][0-9]{6,7}[-]?[0-9]?)/i', $phone);
        if ($IsWhat == 1) {
            return preg_replace('/(0[0-9]{2,3}[-]?[2-9])[0-9]{3,4}([0-9]{3}[-]?[0-9]?)/i', '$1****$2', $phone);
        } else {
            return preg_replace('/(1[34578]{1}[0-9])[0-9]{4}([0-9]{4})/i', '$1****$2', $phone);
        }
    }
}
if (!function_exists('randstr')) {
    /**
     * @param $len 生成随机字符串|长度6
     * @param  $type 类型默认随机0大小写1数字2大写3小写4中文
     * @param  $addChars 加入字符
     * @return string
     */
    function randstr($len = 6, $type = '', $addChars = '')
    {
        $str = '';
        switch ($type) {
            case 0:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 1:
                $chars = str_repeat('0123456789', 3);
                break;
            case 2:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
                break;
            case 3:
                $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 4:
                $chars = "的一是在不了有和人这中大为上个国我以要他时来用们生到作地于出就分对成会可主发年动同工也能下过子说产种面而方后多定行学法所民得经十三之进着等部度家电力里如水化高自二理起小物现实加量都两体制机当使点从业本去把性好应开它合还因由其些然前外天政四日那社义事平形相全表间样与关各重新线内数正心反你明看原又么利比或但质气第向道命此变条只没结解问意建月公无系军很情者最立代想已通并提直题党程展五果料象员革位入常文总次品式活设及管特件长求老头基资边流路级少图山统接知较将组见计别她手角期根论运农指几九区强放决西被干做必战先回则任取据处队南给色光门即保治北造百规热领七海口东导器压志世金增争济阶油思术极交受联什认六共权收证改清己美再采转更单风切打白教速花带安场身车例真务具万每目至达走积示议声报斗完类八离华名确才科张信马节话米整空元况今集温传土许步群广石记需段研界拉林律叫且究观越织装影算低持音众书布复容儿须际商非验连断深难近矿千周委素技备半办青省列习响约支般史感劳便团往酸历市克何除消构府称太准精值号率族维划选标写存候毛亲快效斯院查江型眼王按格养易置派层片始却专状育厂京识适属圆包火住调满县局照参红细引听该铁价严龙飞" . $addChars;
                break;
            default :
                $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
                break;
        }
        if ($len > 10) {
            $chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
        }
        if ($type != 4) {
            $chars = str_shuffle($chars);
            $str = substr($chars, 0, $len);
        } else {
            for ($i = 0; $i < $len; $i++) {
                $str .= cutstr($chars, 1, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 0);
            }
        }
        return $str;
    }
}
if (!function_exists('cutstr')) {
    /**
     *
     * @param $str 中文字符串截取|传入字符
     * @param $length 长度
     * @param $start 开始位置
     * @param $suffix 是否显示...
     * @param  $charset 编码
     * @return string
     */
    function cutstr($str, $length, $start = 0, $suffix = true, $charset = "utf-8")
    {
        if (function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif (function_exists('iconv_substr')) {
            $slice = iconv_substr($str, $start, $length, $charset);
            if (false === $slice) {
                $slice = '';
            }
        } else {
            $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("", array_slice($match[0], $start, $length));
        }
        return $suffix ? $slice . '...' : $slice;
    }
}
if (!function_exists('filecount')) {
    /**
     * @param $size 格式化字节大小|字节大小
     * @param $dec 保留小数2
     * @return string
     */
    function filecount($size, $dec=2) {
        $a = array("B", "KB", "MB", "GB", "TB", "PB");
        $pos = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }
        return round($size,$dec)." ".$a[$pos];
    }}
if (!function_exists('getrand')) {
    /**
     * @param  $proArr 传入array|概率算法
     * @return array
       proArr array(100,200,300，400)
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
       $ridk = getrand($arr); //根据概率获取奖项id

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
    function getrand($proArr) {
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
    }}
if (!function_exists('trimstr')) {
/**
 * @param  $str 去除空格换行
 * @return string
 */
function trimstr($str)
{
    $str = trim($str);
    $str = preg_replace("/\t/","",$str);
    $str = preg_replace("/\r\n/","",$str);
    $str = preg_replace("/\r/","",$str);
    $str = preg_replace("/\n/","",$str);
    $str = preg_replace("/ /","",$str);
    return trim($str); //返回字符串
}}
if (!function_exists('trimarray')) {
/**
 * @param  $Input 去除数组字符中值两端空格|支持excel
 * @return array|string
 */
function trimarray($Input){
    if (!is_array($Input))
        return preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$Input);
    return array_map('trimarray', $Input);
}}
if (!function_exists('getip')) {
    /**
     * @return 返回IP
     */
    function getip() {
        static $ip = '';
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        if (preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $ip)) {
            return $ip;
        } else {
            return '127.0.0.1';
        }
    }
}
/**
 *
 * @param $email 生成avatar头像|email
 * @param  $s 大小
 * @return string
 */
function getavatar($email='', $s=40, $d='mm', $g='g') {
    $hash = md5($email);
    $avatar = "http://www.gravatar.com/avatar/$hash?s=$s&d=$d&r=$g";
    return $avatar;
}
if (!function_exists('getmemory')) {
/**
 * @return 返回使用内存
 */
function getmemory(){
    return round((memory_get_usage()/1024/1024),3)."M";
}}
if (!function_exists('authcode')) {
    /**
     * @param $string 加密解密可逆操作
     * @param  $operation EN加密DECODE解密
     * @param $key  密钥字符串
     * @param  $expiry 过期秒数
     * @return string
     */
    function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
        $ckey_length = 4;
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }
}
if (!function_exists('randcolor')) {
    /**
     * @return 返回随机颜色
     */
    function randcolor()
    {
        $char = 'abcdef0123456789';
        $str = '';
        for ($i = 0; $i < 6; $i++) {
            $str .= substr($char, mt_rand(0, 15), 1);
        }
        return '#' . $str;
    }
}
if (!function_exists('arr2xml')) {
    /**
     * @param $arr 数组转换字符串
     * @param  $level 是否包含xml开始标签
     * @return string
     */
    function arr2xml($arr, $level = 1) {
        $s = $level == 1 ? "<xml>" : '';
        foreach ($arr as $tagname => $value) {
            if (!is_array($value)) {
                $s .= "<{$tagname}>" . (!is_numeric($value) ? '<![CDATA[' : '') . $value . (!is_numeric($value) ? ']]>' : '') . "</{$tagname}>";
            } else {
                $s .= "<{$tagname}>" . arr2xml($value, $level + 1) . "</{$tagname}>";
            }
        }
        $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
        return $level == 1 ? $s . "</xml>" : $s;
    }
}
if (!function_exists('xml2arr')) {
    /**
     * @param $xml xml转换成数组
     * @return array
     */
    function xml2arr($xml)
    {
        if (empty($xml)) {
            return array();
        }
        $result = array();
        $xmlobj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($xmlobj instanceof \SimpleXMLElement) {
            $result = json_decode(json_encode($xmlobj), true);
            if (is_array($result)) {
                return $result;
            } else {
                return array();
            }
        } else {
            return $result;
        }
    }
}
if (!function_exists('obj2arr')) {
    /**
     * @param $array 对象转换数组多维也支持
     * @return array
     */
function obj2arr($array) {
    if(is_object($array)) {
        $array = (array)$array;
    } if(is_array($array)) {
        foreach($array as $key=>$value) {
            $array[$key] = obj2arr($value);
        }
    }
    return $array;
}}
if (!function_exists('arr2obj')) {
    /**
     * @param $arr 数组转换对象obj
     * @return object
     */
function arr2obj($arr) {
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k =>$v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object)arr2obj($v);
        }
    }

    return (object)$arr;
}}
if (!function_exists('msg')) {
    /**
     * @param  $type 提示信息类型|help|gopage|goto|info|success|warn
     * @param  $info 提示字符串
     * @param  $url 跳转地址
     */
    function msg($type="help", $info = "", $url = "")
    {
        if ("close"== $type) {
            $strs = empty($info) ? "" : "alert('$info');";
            echo "<script>" . $strs . "document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
WeixinJSBridge.call('closeWindow');});</script>";
            exit;
        } elseif ("gopage"== $type) {
            $urls = empty($url) ? "" : 'location.href="' . $url . '";';
            $strs = empty($info) ? "正在跳转中..." : $info;
            $html =<<<EOF
            <meta charset='utf-8'>
<script type="text/javascript">document.write("<meta name='viewport' content='width=device-width,initial-scale=1,user-scalable=0'><div style='font-size:16px;margin:30px auto;text-align:center;'>$strs </div>"); $urls;</script>
EOF;
            exit($html);
        } elseif ("goto"== $type) {
            $strs = empty($info) ? "" : "alert('$info');";
            $urls = empty($url) ? "" : 'location.href="' . $url . '";';
            exit('<script type="text/javascript">' . $strs . $urls . '</script>');
        } elseif ("info"== $type ||"success"== $type ||"warn"== $type) {
            $html=<<<EOF
<meta charset='utf-8'>
<script>document.write("<title>提示</title><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet'  href='https://res.wx.qq.com/open/libs/weui/0.4.3/weui.min.css'><div class='weui_msg'><div class='weui_icon_area'><i class='weui_icon_$type weui_icon_msg'></i></div><div class='weui_text_area'><h4 class='weui_msg_title'>$info</h4></div></div>");document.addEventListener("WeixinJSBridgeReady", function onBridgeReady() {WeixinJSBridge.call("hideOptionMenu");});</script>
EOF;
            exit($html);
        }
    }
}
if (!function_exists('str2arr')) {
    /**
     * @param $var 字符串与数组互相转换|转换自动判断是否数组
     * @param  $str 分隔符默认
     * @return array|string
     */
    function str2arr($var, $str = ',')
    {
        if (is_array($var)) {
            return implode($str, $var);
        } else {
            return explode($str, $var);
        }
    }
}

if (!function_exists('getdistance')) {
    /**
     * 计
     * @param  $lat1 返回两地之间距离|经度1
     * @param  $lng1 纬度1
     * @param  $lat2 经度2
     * @param  $lng2 纬度2
     * @param $len_type 1是米,2,千米
     * @param $decimal 保留两位小数
     * @return float
     */
    function getdistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 2)
    {
        $pi = 3.1415926000000001;
        $er = 6378.1369999999997;
        $radLat1 = ($lat1 * $pi) / 180;
        $radLat2 = ($lat2 * $pi) / 180;
        $a = $radLat1 - $radLat2;
        $b = (($lng1 * $pi) / 180) - (($lng2 * $pi) / 180);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + (cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))));
        $s = $s * $er;
        $s = round($s * 1000);
        if (1 < $len_type) {
            $s /= 1000;
        }
        return round($s, $decimal);
    }
}
if (!function_exists('getaddress')) {
    /**
     * @param $ak IP定位返回省市县|百度或腾讯地图密钥
     * @param $type baidu|qq
     * @return array
     */
    function getaddress($ak = '', $type = "baidu")
    {

        if ($type == 'baidu') {
            $ak = (empty($ak)) ? "8SlSbHObMgN8HeOwGUQXU5XM" : $ak;
            $url = "https://api.map.baidu.com/location/ip?ak=$ak&coor=bd09ll&ip=" . getip();
            $rs = json_decode(curl($url), 1);
            if ($rs['status'] == 0) {
                return $rs['content'];
            } else {
                return $rs['message'];
            }
        } else {
            $ak = (empty($ak)) ? "ACEBZ-FDXWP-WFRDV-VGS5Q-S2Q5K-HQBNA" : $ak;
            $url = "https://apis.map.qq.com/ws/location/v1/ip?ip=" . getip() . "&key=$ak";
            $rs = json_decode(curl($url), 1);
            if ($rs['status'] == 0) {
                return $rs['result'];
            } else {
                return $rs['message'];
            }
        }


    }
}
if (!function_exists('htmlencode')) {
    /**
     * @param $var 字符串转换成实体
     * @return string
     */
    function htmlencode($var)
    {
       return str_replace('&amp;', '&', htmlspecialchars($var, ENT_QUOTES));
    }
}
if (!function_exists('htmldecode')) {
    /**
     * @param $var HTML实体还原
     * @return string
     */
    function htmldecode($var)
    {
        return htmlspecialchars_decode($var);
    }
}

if (!function_exists('ids')) {
    /**
     * @return 生产不重复id千万次下测试无重复32位长度string
     */
    function ids()
    {
        return md5(uniqid(mt_rand()));
    }
}
if (!function_exists('uuid')) {
/**
 * @return  生成36位uuid字符串
 */
 function uuid()
{
    // fix for compatibility with 32bit architecture; seed range restricted to 62bit
    $seed = mt_rand(0, 2147483647) . '#' . mt_rand(0, 2147483647);

    // Hash the seed and convert to a byte array
    $val = md5($seed, true);
    $byte = array_values(unpack('C16', $val));

    // extract fields from byte array
    $tLo = ($byte[0] << 24) | ($byte[1] << 16) | ($byte[2] << 8) | $byte[3];
    $tMi = ($byte[4] << 8) | $byte[5];
    $tHi = ($byte[6] << 8) | $byte[7];
    $csLo = $byte[9];
    $csHi = $byte[8] & 0x3f | (1 << 7);

    // correct byte order for big edian architecture
    if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
        $tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8)
            | (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
        $tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
        $tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
    }

    // apply version number
    $tHi &= 0x0fff;
    $tHi |= (3 << 12);

    // cast to string
    $uuid = sprintf(
        '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
        $tLo,
        $tMi,
        $tHi,
        $csHi,
        $csLo,
        $byte[10],
        $byte[11],
        $byte[12],
        $byte[13],
        $byte[14],
        $byte[15]
    );

    return $uuid;
}}
if (!function_exists('id')) {
    class Snowflake { const TIMESTAMP_BITS = 41; const MACHINE_BITS = 10; const PROCESS_BITS = 10; const SEQUENCE_BITS = 2; const TIMESTAMP_BIT_OFFSET = self::MACHINE_BITS + self::PROCESS_BITS + self::SEQUENCE_BITS; const MACHINE_BIT_OFFSET = self::PROCESS_BITS + self::SEQUENCE_BITS; const PROCESS_BITS_OFFSET = self::SEQUENCE_BITS; const MAX_MILLISECOND_TIMESTAMP = (-1 ^ (-1 << self::TIMESTAMP_BITS)); const MAX_MACHINE_ID = (-1 ^ (-1 << self::MACHINE_BITS)); const MAX_PROCESS_ID = (-1 ^ (-1 << self::PROCESS_BITS)); const MAX_SEQUENCE_ID = (-1 ^ (-1 << self::SEQUENCE_BITS)); const EPOCH_OFFSET = 1483200000000; private static $lastMillisecondTimeStamp = 0; private static $machineId; private static $processId; private static $sequenceId = 0; public static function id() { $machineId = self::getMachineId(); $processId = self::getProcessId(); $sequence = self::getSequence(); $pastTime = self::getPastTime(); return (($pastTime << self::TIMESTAMP_BIT_OFFSET) | ($machineId << self::MACHINE_BIT_OFFSET) | ($processId << self::PROCESS_BITS_OFFSET) | $sequence) & PHP_INT_MAX; } private static function getMachineId() { if (empty(self::$machineId)) { $hostName = gethostname(); $achineId = preg_replace('/\D/s', '', md5($hostName)) % 1024; if (self::MAX_MACHINE_ID < $achineId) { throw new \RuntimeException('机器ID大于允许的最大值'); } self::$machineId = $achineId; } return self::$machineId; } private static function getProcessId() { if (empty(self::$processId)) { $processId = getmypid(); if (false === $processId) { throw new \RuntimeException('获取进程PID失败'); } $processIdLowBit = $processId & self::MAX_PROCESS_ID; if (self::MAX_PROCESS_ID < $processIdLowBit) { throw new \RuntimeException('进程ID大于允许的最大值'); } self::$processId = $processIdLowBit; } return self::$processId; } private static function getSequence() { $currentMicroTimeStamp = self::getCurrentMicrosecond(); if ($currentMicroTimeStamp < self::$lastMillisecondTimeStamp) { throw new \RuntimeException('生成ID所依靠的时间回拨了'); } if ($currentMicroTimeStamp == self::$lastMillisecondTimeStamp) { $sequence = ++self::$sequenceId; if ($sequence > self::MAX_SEQUENCE_ID) { do { $currentMicroTimeStamp = self::getCurrentMicrosecond(); } while ($currentMicroTimeStamp <= self::$lastMillisecondTimeStamp); self::$sequenceId = 0; $sequence = self::$sequenceId; } } else { self::$sequenceId = 0; $sequence = self::$sequenceId; } self::$lastMillisecondTimeStamp = $currentMicroTimeStamp; return $sequence; } private static function getPastTime() { $pastMillisecond = self::$lastMillisecondTimeStamp - self::EPOCH_OFFSET; if ($pastMillisecond > self::MAX_MILLISECOND_TIMESTAMP) { throw new \RuntimeException('Time error'); } $pastMicroSecondLowBit = $pastMillisecond & self::MAX_MILLISECOND_TIMESTAMP; return $pastMicroSecondLowBit; } private static function getCurrentMicrosecond() { return (int)(microtime(true) * 1000); } }
    /**
     * @return  生成唯一id数字字符串|雪花算法百万无重复
     */
    function id()
    {  return \Snowflake::id();
    }
}
if (!function_exists('md')) {
    /**
     * @param $path 创建多级目录
     * @return bool
     */
    function md($path)
    {
        if (!is_dir($path)) {
            md(dirname($path));
            mkdir($path);
        }

        return is_dir($path);
    }
}
if (!function_exists('putfile')) {
    /**
     * @param $filename 写入文件内容|文件名
     * @param $data 内容
     * @return bool
     */
    function putfile($filename, $data) {
        md(dirname($filename));
        file_put_contents($filename, $data);
        return is_file($filename);
    }}
if (!function_exists('getfile')) {
    /**
     * @param $filename 读取文件内容
     * @return string
     */
    function getfile($filename) {
        if (!is_file($filename)) {
            return false;
        }
        return file_get_contents($filename);
    }}
if (!function_exists('upimg64')) {
    /**
     * @param $path 生成图片base64图片|路径不含最后
     * @param $data base64数据
     * @return string 路径
     */
    function upimg64($path, $data)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data, $result)) {
            $type = "." . $result[2];
            $path1 = $path . "/" . id() . $type;
        }
        $img = base64_decode(str_replace($result[1], '', $data));
        filewrite($path1, $img);
        return $path1;
    }
}
if (!function_exists('arr_unique')) {
    /**
     * @param $arr 返回数组重复元素只支持一维数组
     * @return array
     */
    function arr_unique($arr)
    {
        $unique_arr = array_unique($arr);
        $repeat_arr = array_diff_assoc($arr, $unique_arr);
        return $repeat_arr;
    }
}
if (!function_exists('is_unique')) {
    /**
     * @param $arr 判断是否有重复数组元素
     * @return bool
     */
    function is_unique($arr)
    {
        if (count($arr) != count(array_unique($arr))) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('arr2_uniqueRemove')) {
    /**
     * @param $arr 二维数据值去重
     * @return array|bool
     */
    function arr2_uniqueRemove($arr)
    {
        $newarr = [];
        if (is_array($arr)) {
            foreach ($arr as $v) {
                if (!in_array($v, $newarr, true)) {
                    $newarr[] = $v;
                }
            }
        } else {
            return false;
        }
        return $newarr;
    }
}
if (!function_exists('arr_remove')) {
    /**
     * @param $arr 删除数组的值只支持一维数组
     * @param string|array $str
     * @return array
     */
    function arr_remove($arr, $str)
    {
        if (is_array($str)) {
            return array_diff($arr, $str);
        } else {
            return array_diff($arr, ["$str"]);
        }
    }
}
if (!function_exists('arr_key')) {
    /**
     * @param $arr 返回关联数组的值作为数组的key|
     * @param string $key 数组key
     * @return array
     * [
     * ['name'=>1,'id'=>'2'],
     * ['name'=>3,'id'=>3]
     * ];
     */
    function arr_key($arr, $key)
    {
        return array_column($arr, NULL, $key);
    }
}
if (!function_exists('arr_field')) {
    /**
     * @param $arr 返回关联数组某个字段组成的新数组|传入数组
     * @param string $key
     * @return array
     */
    function arr_field($arr, $key)
    {
        return array_column($arr, $key);
    }
}
if (!function_exists('arr_rand')) {
    /**
     *
     * @param $array 返回数组随机值|传入数组
     * @param $number 数字
     * @return array
     * @date 2019-12-16
     */
    function arr_rand($array, $number = null)
    {
        $requested = is_null($number) ? 1 : $number;

        $count = count($array);

        if ($requested > $count) {
            $number = $count;
        }

        if (is_null($number)) {
            return $array[array_rand($array)];
        }

        if ((int)$number === 0) {
            return [];
        }

        $keys = array_rand($array, $number);

        $results = [];

        foreach ((array)$keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
    }
}
if (!function_exists('arr_unset')) {
    /**
     * @param $array 删除数组中元素|只用于一维数组
     * @param $keys 数组|字符串
     */
    function arr_unset(&$array, $keys)
    {
        if (empty($keys) && $keys != 0) {
            return;
        }
        if (is_array($keys)) {
            foreach ($keys as $key) {
                if (array_key_exists($key, $array)) {
                    unset($array[$key]);
                    continue;
                }
            }
            return;
        } else {
            unset($array[$keys]);
            return;
        }

    }
}
if (!function_exists('arr_sort')) {
    /**
     * @param $array 数组排序
     * @param $keys 排序字段
     * @param string $type 排序方式
     * @return array
     */
    function arr_sort($array, $keys = 'id', $type = 'asc')
    {
        $keysvalue = $new_array = array();
        foreach ($array as $k => $v) {
            $keysvalue[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($keysvalue);
        } else {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $array[$k];
        }
        return $new_array;
    }
}
if (!function_exists('root')) {
    /**
     * @return 返回当前文件的目录
     */
    function root($path='')
    {
        $path = (empty($path))?__FILE__:$path;
        return str_replace("\\", '/', dirname($path));
    }
}
if (!function_exists('pinyin')) {
    /**
     * @param $str 汉字转拼音不能识别的汉字返回x英文不转换
     * @param $cut 分隔符号默认没有
     * @param  $isall 是否只返回首字母
     * @return string
     */
function pinyin($str,$cut="",$isall=true){
    $data = array( 'a'=>-20319,'ai'=>-20317,'an'=>-20304,'ang'=>-20295,'ao'=>-20292, 'ba'=>-20283,'bai'=>-20265,'ban'=>-20257,'bang'=>-20242,'bao'=>-20230,'bei'=>-20051,'ben'=>-20036,'beng'=>-20032,'bi'=>-20026,'bian'=>-20002,'biao'=>-19990,'bie'=>-19986,'bin'=>-19982,'bing'=>-19976,'bo'=>-19805,'bu'=>-19784, 'ca'=>-19775,'cai'=>-19774,'can'=>-19763,'cang'=>-19756,'cao'=>-19751,'ce'=>-19746,'ceng'=>-19741,'cha'=>-19739,'chai'=>-19728,'chan'=>-19725,'chang'=>-19715,'chao'=>-19540,'che'=>-19531,'chen'=>-19525,'cheng'=>-19515,'chi'=>-19500,'chong'=>-19484,'chou'=>-19479,'chu'=>-19467,'chuai'=>-19289,'chuan'=>-19288,'chuang'=>-19281,'chui'=>-19275,'chun'=>-19270,'chuo'=>-19263,'ci'=>-19261,'cong'=>-19249,'cou'=>-19243,'cu'=>-19242,'cuan'=>-19238,'cui'=>-19235,'cun'=>-19227,'cuo'=>-19224, 'da'=>-19218,'dai'=>-19212,'dan'=>-19038,'dang'=>-19023,'dao'=>-19018,'de'=>-19006,'deng'=>-19003,'di'=>-18996,'dian'=>-18977,'diao'=>-18961,'die'=>-18952,'ding'=>-18783,'diu'=>-18774,'dong'=>-18773,'dou'=>-18763,'du'=>-18756,'duan'=>-18741,'dui'=>-18735,'dun'=>-18731,'duo'=>-18722, 'e'=>-18710,'en'=>-18697,'er'=>-18696, 'fa'=>-18526,'fan'=>-18518,'fang'=>-18501,'fei'=>-18490,'fen'=>-18478,'feng'=>-18463,'fo'=>-18448,'fou'=>-18447,'fu'=>-18446, 'ga'=>-18239,'gai'=>-18237,'gan'=>-18231,'gang'=>-18220,'gao'=>-18211,'ge'=>-18201,'gei'=>-18184,'gen'=>-18183,'geng'=>-18181,'gong'=>-18012,'gou'=>-17997,'gu'=>-17988,'gua'=>-17970,'guai'=>-17964,'guan'=>-17961,'guang'=>-17950,'gui'=>-17947,'gun'=>-17931,'guo'=>-17928, 'ha'=>-17922,'hai'=>-17759,'han'=>-17752,'hang'=>-17733,'hao'=>-17730,'he'=>-17721,'hei'=>-17703,'hen'=>-17701,'heng'=>-17697,'hong'=>-17692,'hou'=>-17683,'hu'=>-17676,'hua'=>-17496,'huai'=>-17487,'huan'=>-17482,'huang'=>-17468,'hui'=>-17454,'hun'=>-17433,'huo'=>-17427, 'ji'=>-17417,'jia'=>-17202,'jian'=>-17185,'jiang'=>-16983,'jiao'=>-16970,'jie'=>-16942,'jin'=>-16915,'jing'=>-16733,'jiong'=>-16708,'jiu'=>-16706,'ju'=>-16689,'juan'=>-16664,'jue'=>-16657,'jun'=>-16647, 'ka'=>-16474,'kai'=>-16470,'kan'=>-16465,'kang'=>-16459,'kao'=>-16452,'ke'=>-16448,'ken'=>-16433,'keng'=>-16429,'kong'=>-16427,'kou'=>-16423,'ku'=>-16419,'kua'=>-16412,'kuai'=>-16407,'kuan'=>-16403,'kuang'=>-16401,'kui'=>-16393,'kun'=>-16220,'kuo'=>-16216, 'la'=>-16212,'lai'=>-16205,'lan'=>-16202,'lang'=>-16187,'lao'=>-16180,'le'=>-16171,'lei'=>-16169,'leng'=>-16158,'li'=>-16155,'lia'=>-15959,'lian'=>-15958,'liang'=>-15944,'liao'=>-15933,'lie'=>-15920,'lin'=>-15915,'ling'=>-15903,'liu'=>-15889,'long'=>-15878,'lou'=>-15707,'lu'=>-15701,'lv'=>-15681,'luan'=>-15667,'lue'=>-15661,'lun'=>-15659,'luo'=>-15652, 'ma'=>-15640,'mai'=>-15631,'man'=>-15625,'mang'=>-15454,'mao'=>-15448,'me'=>-15436,'mei'=>-15435,'men'=>-15419,'meng'=>-15416,'mi'=>-15408,'mian'=>-15394,'miao'=>-15385,'mie'=>-15377,'min'=>-15375,'ming'=>-15369,'miu'=>-15363,'mo'=>-15362,'mou'=>-15183,'mu'=>-15180, 'na'=>-15165,'nai'=>-15158,'nan'=>-15153,'nang'=>-15150,'nao'=>-15149,'ne'=>-15144,'nei'=>-15143,'nen'=>-15141,'neng'=>-15140,'ni'=>-15139,'nian'=>-15128,'niang'=>-15121,'niao'=>-15119,'nie'=>-15117,'nin'=>-15110,'ning'=>-15109,'niu'=>-14941,'nong'=>-14937,'nu'=>-14933,'nv'=>-14930,'nuan'=>-14929,'nue'=>-14928,'nuo'=>-14926, 'o'=>-14922,'ou'=>-14921, 'pa'=>-14914,'pai'=>-14908,'pan'=>-14902,'pang'=>-14894,'pao'=>-14889,'pei'=>-14882,'pen'=>-14873,'peng'=>-14871,'pi'=>-14857,'pian'=>-14678,'piao'=>-14674,'pie'=>-14670,'pin'=>-14668,'ping'=>-14663,'po'=>-14654,'pu'=>-14645, 'qi'=>-14630,'qia'=>-14594,'qian'=>-14429,'qiang'=>-14407,'qiao'=>-14399,'qie'=>-14384,'qin'=>-14379,'qing'=>-14368,'qiong'=>-14355,'qiu'=>-14353,'qu'=>-14345,'quan'=>-14170,'que'=>-14159,'qun'=>-14151, 'ran'=>-14149,'rang'=>-14145,'rao'=>-14140,'re'=>-14137,'ren'=>-14135,'reng'=>-14125,'ri'=>-14123,'rong'=>-14122,'rou'=>-14112,'ru'=>-14109,'ruan'=>-14099,'rui'=>-14097,'run'=>-14094,'ruo'=>-14092, 'sa'=>-14090,'sai'=>-14087,'san'=>-14083,'sang'=>-13917,'sao'=>-13914,'se'=>-13910,'sen'=>-13907,'seng'=>-13906,'sha'=>-13905,'shai'=>-13896,'shan'=>-13894,'shang'=>-13878,'shao'=>-13870,'she'=>-13859,'shen'=>-13847,'sheng'=>-13831,'shi'=>-13658,'shou'=>-13611,'shu'=>-13601,'shua'=>-13406,'shuai'=>-13404,'shuan'=>-13400,'shuang'=>-13398,'shui'=>-13395,'shun'=>-13391,'shuo'=>-13387,'si'=>-13383,'song'=>-13367,'sou'=>-13359,'su'=>-13356,'suan'=>-13343,'sui'=>-13340,'sun'=>-13329,'suo'=>-13326, 'ta'=>-13318,'tai'=>-13147,'tan'=>-13138,'tang'=>-13120,'tao'=>-13107,'te'=>-13096,'teng'=>-13095,'ti'=>-13091,'tian'=>-13076,'tiao'=>-13068,'tie'=>-13063,'ting'=>-13060,'tong'=>-12888,'tou'=>-12875,'tu'=>-12871,'tuan'=>-12860,'tui'=>-12858,'tun'=>-12852,'tuo'=>-12849, 'wa'=>-12838,'wai'=>-12831,'wan'=>-12829,'wang'=>-12812,'wei'=>-12802,'wen'=>-12607,'weng'=>-12597,'wo'=>-12594,'wu'=>-12585, 'xi'=>-12556,'xia'=>-12359,'xian'=>-12346,'xiang'=>-12320,'xiao'=>-12300,'xie'=>-12120,'xin'=>-12099,'xing'=>-12089,'xiong'=>-12074,'xiu'=>-12067,'xu'=>-12058,'xuan'=>-12039,'xue'=>-11867,'xun'=>-11861, 'ya'=>-11847,'yan'=>-11831,'yang'=>-11798,'yao'=>-11781,'ye'=>-11604,'yi'=>-11589,'yin'=>-11536,'ying'=>-11358,'yo'=>-11340,'yong'=>-11339,'you'=>-11324,'yu'=>-11303,'yuan'=>-11097,'yue'=>-11077,'yun'=>-11067, 'za'=>-11055,'zai'=>-11052,'zan'=>-11045,'zang'=>-11041,'zao'=>-11038,'ze'=>-11024,'zei'=>-11020,'zen'=>-11019,'zeng'=>-11018,'zha'=>-11014,'zhai'=>-10838,'zhan'=>-10832,'zhang'=>-10815,'zhao'=>-10800,'zhe'=>-10790,'zhen'=>-10780,'zheng'=>-10764,'zhi'=>-10587,'zhong'=>-10544,'zhou'=>-10533,'zhu'=>-10519,'zhua'=>-10331,'zhuai'=>-10329,'zhuan'=>-10328,'zhuang'=>-10322,'zhui'=>-10315,'zhun'=>-10309,'zhuo'=>-10307,'zi'=>-10296,'zong'=>-10281,'zou'=>-10274,'zu'=>-10270,'zuan'=>-10262,'zui'=>-10260,'zun'=>-10256,'zuo'=>-10254 );
    $topinyin = function($iWORD) use ($data)
    {
        if($iWORD>0 && $iWORD<160 ) {
            return chr($iWORD);
        } elseif ($iWORD<-20319||$iWORD>-10247) {
            return 'x';
        } else {
            foreach ($data as $py => $code)  {
                if($code > $iWORD) break;
                $result = $py;
            }
            return $result;
        }
    };
    $GBK = iconv('UTF-8', 'GBK', $str);
    $UTF8 = iconv('GBK', 'UTF-8', $GBK);
    if($UTF8 != $str) $GBK = $str;
    $Buf = array();
    for ($i=0, $iLoop=strlen($GBK); $i<$iLoop; $i++) {
        $Chr = ord($GBK{$i});
        if ($Chr>160) {
            $Chr = ($Chr<<8) + ord($GBK{++$i}) - 65536;
        }
        if (false==$isall) {
            $Buf[] = substr($topinyin($Chr),0,1);
        }else{
            $Buf[] = $topinyin($Chr);
        }

    }
    return implode($cut, $Buf);
}}
if (!function_exists('aesDecode')) {
    /**
     * @param $message AES解密信息
     * @param $encodingaeskey 密钥
     * @return string
     */
    function aesDecode($message, $encodingaeskey = '')
    {
        $key = base64_decode($encodingaeskey . '=');

        $ciphertext_dec = base64_decode($message);
        $iv = substr($key, 0, 16);
        $iv = strlen($iv) < 16 ? substr(hash('sha256', $key), 0, 16) : $iv;
        $decrypted = openssl_decrypt($ciphertext_dec, 'AES-256-CBC', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
        $block_size = 32;

        $pad = ord(substr($decrypted, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
        $result = substr($decrypted, 0, (strlen($decrypted) - $pad));
        if (strlen($result) < 16) {
            return '';
        }
        $content = substr($result, 16, strlen($result));
        $len_list = unpack("N", substr($content, 0, 4));
        $contentlen = $len_list[1];
        $content = substr($content, 4, $contentlen);
        return $content;
    }
}
    if (!function_exists('aesEncode')) {
        /**
         * @param $message Aes加密信息
         * @param string $encodingaeskey 密钥
         * @return string
         */
        function aesEncode($message, $encodingaeskey = '')
        {
            $key = base64_decode($encodingaeskey . '=');
            $random = function () {

                $str = "";
                $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
                $max = strlen($str_pol) - 1;
                for ($i = 0; $i < 16; $i++) {
                    $str .= $str_pol[mt_rand(0, $max)];
                }
                return $str;
            };
            $text = $random() . pack("N", strlen($message)) . $message;

            $iv = substr($key, 0, 16);
            $iv = strlen($iv) < 16 ? substr(hash('sha256', $key), 0, 16) : $iv;
            $block_size = 32;
            $text_length = strlen($text);
            $amount_to_pad = $block_size - ($text_length % $block_size);
            if ($amount_to_pad == 0) {
                $amount_to_pad = $block_size;
            }
            $pad_chr = chr($amount_to_pad);
            $tmp = '';
            for ($index = 0; $index < $amount_to_pad; $index++) {
                $tmp .= $pad_chr;
            }
            $text = $text . $tmp;
            $encrypted = openssl_encrypt($text, 'AES-256-CBC', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
            $encrypt_msg = base64_encode($encrypted);
            return $encrypt_msg;
        }
    }
/**
 * @param $data 私钥加密需要公钥解密
 * @param  $pri_key 私钥
 * @return string
 */
function privateEncode($data,$pri_key){
    $pri_key = openssl_pkey_get_private($pri_key);
    openssl_private_encrypt($data, $encrypted, $pri_key);
    $crypted = base64_encode($encrypted);
    return $crypted;
}

/**
 * @param $data 公钥解密需要公钥
 * @param $pub_key 公钥
 * @return string
 */
function publicDecode($data,$pub_key){
    $pub_key = openssl_pkey_get_public($pub_key);
    openssl_public_decrypt(base64_decode($data),$de,$pub_key);
    return $de;
}

/**
 * @param $data 公钥加密
 * @param $pub_key 公钥
 * @return string
 */
function publicEncode($data,$pub_key){
    $pub_key = openssl_pkey_get_public($pub_key);
    openssl_public_encrypt($data, $en, $pub_key);
    return base64_encode($en);
}
/**
 * @param $data 私钥解密
 * @param $pri_key 私钥
 * @return string
 */
function privateDecode($data,$pri_key){
    $pri_key = openssl_pkey_get_private($pri_key);
    openssl_private_decrypt(base64_decode($data), $de, $pri_key);
    return $de;
}
