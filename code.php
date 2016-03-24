<?php
  class _MzgLock {
    static $enb64_rid = 70;
    static $enb64_rid1 = 0;
    static $enb64_rid2 = 0;
    static $enb64_array = array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m','_');
    static $enb64_name = '';
    static $enb64_sign = '';
    static $enb64_sum = 3;
    static $preg_rid = 0;
    static $preg_sign='';
      public function read($filename) {
          if (!is_file($filename)) return '';
          if (function_exists("file_get_contents")) {
              $data = file_get_contents($filename);
          } else {
              $data = implode("", file($filename));
          }
          return $data;
      }

      public function write($filename, $data) {
          $fp = @fopen($filename, "w+");
          if ($fp) {
              flock($fp, LOCK_EX);
              fwrite($fp, $data);
              flock($fp, LOCK_UN);
              fclose($fp);
              return true;
          }
          return false;
      }
      public function getfiles($files) {

          $d = dir($files);
          $tmps = array();
          while (false !== ($entry = $d->read())) {
              if ($entry != '.' and $entry != '..') {
                  $tmparr = explode(".", $entry);
                  $type = strtoupper($tmparr[count($tmparr) - 1]);
                  if (is_file($entry) and $type == 'ZIP') {
                      $tmps[] = $entry;
                  }
              }
          }
          $d->close();

          return $tmps;
      }
      public function ischarset($str) {
          //注意无中文时，无论是不是UTF8格式都当UTF8返回
          $lang_arr = array('UTF-8', 'GBK', 'BIG5');
          foreach ($lang_arr as $val) {
              if (iconv_strlen($str, $val)) {
                  return $val;
              }
          }
      }
      public function setcharset($out_charset, $str) {
          $out_charset = strtoupper($out_charset);
          if (!self::ischarset($str)) return $str;
          $in_charset = self::ischarset($str);
          if ($in_charset != $out_charset) {
              if (function_exists('iconv') and @iconv($in_charset, $out_charset, $str) == true) {
                  return iconv($in_charset, $out_charset, $str);
              } elseif (function_exists('mb_convert_encoding') and @mb_convert_encoding($str, $in_charset,
              $out_charset) == true) {
                  return mb_convert_encoding($str, $in_charset, $out_charset);
              }
          }
          return $str;

      }
      private function expstr($str) {
          return "?>" . $str . "<?php ";
      }

      private function inrandstr($strdata, $base64_decode = '', $deb64_func = '', $b64_key =
          '',$is_func=0) {
          $rs = strlen($strdata) / rand(2, 4);
          $randvar = "";
          for ($i = 0; $i <= rand(2, 8); $i++) $randvar .= $strdata{$rs + $i};

          if ($deb64_func) {
              return str_replace($randvar, '\'.' . ($base64_decode ? '$' . $base64_decode :
                  'base64_decode') . '(' . $deb64_func . '(\'' . self::enb64(base64_encode($randvar)) .
                  '\',\'' . $b64_key . '\')).\'', $strdata);
          } else {
              return $strdata;
          }
      }

      public function encode($strdata, $base64_decode = '', $gzuncompress = '', $deb64_func =
          '', $b64_key = '', $preg_replace = '', $preg_pre = '', $eval_name1 = '', $preg_pre_md5 =
          '',$enb64_sign_name='',$is_func=0) {

          $characters = array("r", "s", "f", "D", "w", "F", "f", "H", "p", "j", "N", "f",
              "d", "T", "V", "W", "s", "x", "n");
          $restdata = "";
          $rid = rand(0, count($characters) - 1).rand(0, count($characters) - 1).rand(0, count($characters) - 1);
          if ($is_func){
          $b64_data = $strdata;
          $b64_rid = rand(64, 128);
          $b64_data_pre = base64_encode(gzcompress(substr($b64_data,0,strlen($b64_data)-$b64_rid), 9));
          $b64_data_end = substr($b64_data,$b64_rid*-1);
            self::$enb64_sign =base64_encode(gzcompress($b64_data_end, 9));
          $restdata = '$' . $preg_replace . '($' . $preg_pre . ',$' . $eval_name1 . '.\'(@$' . $gzuncompress .
              '($' . $base64_decode . '(\\\'' . self::inrandstr(str_replace($rid, $rid . chr(rand
              (128, 250)), $b64_data_pre), $base64_decode, $deb64_func,
              $b64_key,$is_func) . '\\\')).' . '$' . $gzuncompress . '($'.$base64_decode.'($'.$enb64_sign_name.')))\',"' . $preg_pre_md5 . '")';

              } else {
          $b64_data = base64_encode(gzcompress($strdata, 9));
          $b64_data_pre = substr($b64_data,0,strlen($b64_data)-32);
          $b64_data_end = substr($b64_data,-32);
            self::$enb64_sign ='';
            $preg_sign_b64 = base64_encode($b64_key.$deb64_func);
            self::$preg_rid=rand(4,strlen($preg_sign_b64)-4);
            self::$preg_sign = (self::$preg_rid%2==0?chr(rand(129,214)):'').substr($preg_sign_b64,0,self::$preg_rid).(self::$preg_rid%3==0?chr(rand(129,214)):'');
          for ($i=0;$i<rand(1,3);$i++){
          $b64_data_end = base64_encode($b64_data_end);
            $srid = rand(0,strlen($b64_data_end)-1);
          $b64_data_end = str_replace($b64_data_end{$srid}.$b64_data_end{$srid+1},$b64_data_end{$srid}.$b64_data_end{$srid+1}.self::$preg_sign,$b64_data_end);
          }
          $restdata = '$' . $preg_replace . '($' . $preg_pre . ',$' . $eval_name1 . '.\'(@$' . $gzuncompress .
              '($' . $base64_decode . '(\\\'' . self::inrandstr(str_replace($rid, $rid . chr(rand
              (128, 250)), $b64_data_pre), $base64_decode, $deb64_func,
              $b64_key,$is_func) . '\\\'.($'.self::$enb64_name.'.='.self::$enb64_name.'($'.self::$enb64_name.')))))\',"' . $preg_pre_md5 . '".($'.self::$enb64_name.'=\''.addcslashes($b64_data_end,"'").'\'))';

              }
          return $restdata;
      }
      
      public function E($code) {
            return self::intocode($code,0,"",array(),"");
      }
      public function intocode($codedata, $rankcount, $defile_data, $copyright, $usercode) {
        $rand_arr = array(68,70,72,74,76,78,80,92,96,98,90);
            self::$enb64_rid = $rand_arr[rand(0,count($rand_arr)-1)];
            self::$enb64_name=chr(rand(129, 214)) . rand(550, 559) . chr(rand(129, 214));
self::$enb64_sum = rand(2,5);

            self::$enb64_rid1 = rand(129,150);
            self::$enb64_rid2 = rand(180,214);

          $base64_decode1 = chr(rand(129, 214)) . rand(20, 29) . chr(rand(129, 214));
          $base64_decode2 = chr(rand(129, 214)) . rand(30, 39) . chr(rand(129, 214));
          $base64_decode_value = self::enb64('base64_decode');



          $preg_replace = chr(rand(129, 214)) . rand(470, 479) . chr(rand(129, 214));
          $preg_replace_value = self::enb64('preg_replace');

          $str_replace_value = self::enb64('str_replace');

          $preg_pre = chr(rand(129, 214)) . rand(480, 489) . chr(rand(129, 214));
          $preg_pre_md5 = md5($preg_pre);
          $preg_pre_value = self::enb64('/' . $preg_pre_md5 . '/e');

          $gzuncompress = chr(rand(129, 214)) . rand(70, 79) . chr(rand(129, 214));
          $gzuncompress_value = self::enb64('gzuncompress');



          $eval_name1 = chr(rand(129, 214)) . rand(140, 149) . chr(rand(129, 214));
          $eval_name2 = chr(rand(129, 214)) . rand(150, 159) . chr(rand(129, 214));
          $eval_value = self::enb64('eval');



          $deb64_func = chr(rand(129, 214)) . rand(170, 179) . chr(rand(129, 214));
          $deb64_name = chr(rand(129, 214)) . rand(180, 189) . chr(rand(129, 214));
          $deb64_func_name = chr(rand(129, 214)) . rand(290, 299) . chr(rand(129, 214));
          $deb64_func_value = self::enb64var('base64_decode');
            $enb64_sign_name = chr(rand(129, 214)) . rand(670, 679) . chr(rand(129, 214));
          $ae_name = chr(rand(129, 214)) . rand(190, 199) . chr(rand(129, 214));

          $ord_name = chr(rand(129, 214)) . rand(190, 199) . chr(rand(129, 214));
          $chr_name = chr(rand(129, 214)) . rand(200, 209) . chr(rand(129, 214));
          $strlen_name = chr(rand(129, 214)) . rand(300, 309) . chr(rand(129, 214));
          $ord_value = self::enb64var('ord');
          $chr_value = self::enb64var('chr');
          $strlen_value = self::enb64var('strlen');
          $b245_name = chr(rand(129, 214)) . rand(210, 219) . chr(rand(129, 214));
          $b245_value = self::enb64var(245);
          $b140_name = chr(rand(129, 214)) . rand(220, 229) . chr(rand(129, 214));
          $b140_value = self::enb64var(self::$enb64_rid*2);
          $b2_name = chr(rand(129, 214)) . rand(230, 239) . chr(rand(129, 214));
          $b2_value = self::enb64var(2);
          $b0_name = chr(rand(129, 214)) . rand(240, 249) . chr(rand(129, 214));
          $b0_value = self::enb64var(0);
          $bvar_name = chr(rand(129, 214)) . rand(250, 259) . chr(rand(129, 214));
          $btmp_name = chr(rand(129, 214)) . rand(260, 269) . chr(rand(129, 214));

          $b64_key_name = chr(rand(129, 214)) . rand(300, 309) . chr(rand(129, 214));

          $b64_key = self::enb64(md5($btmp_name . $bvar_name . time()));



        $preg_match_name1 = chr(rand(129, 214)) . rand(620, 629) . chr(rand(129, 214));
        $preg_match_name2 = chr(rand(129, 214)) . rand(300, 309) . chr(rand(129, 214));
        $preg_match_value1 = self::enb64('strstr');
        $preg_match_value2 = self::enb64('preg_match');

        $pathinfo_name = chr(rand(129, 214)) . rand(200, 209) . chr(rand(129, 214));
        $files_name = chr(rand(129, 214)) . rand(100, 109) . chr(rand(129, 214));
        $pathinfo_value = self::enb64('pathinfo');

        $chr_value3 = self::enb64("/([".chr(127)."-".chr(255)."]+)/");
        $chr_value2 = self::enb64("/([".chr(127)."-".chr(255)."]+)/i");

          $copyright['starttime'] = ($copyright['starttime'] <= 0) ? time() : $copyright['starttime'];

          $restdata = self::setcharset($copyright['outlang'], self::expstr($codedata));



          $restdata =  ($defile_data ? $defile_data.$restdata : $restdata).
              '$GLOBALS[decode_fp_sign]=$GLOBALS[' .self::$enb64_name . ']=$GLOBALS[' .$gzuncompress . ']=$GLOBALS[' .$base64_decode1 . ']=$GLOBALS[' . $enb64_sign_name .']=$GLOBALS[' .$preg_replace . ']=$GLOBALS[' .$preg_pre . ']=$GLOBALS[' .$eval_name1 . ']=null;unset($GLOBALS[' .$preg_replace . ']);unset($GLOBALS[' .$preg_pre . ']);unset($GLOBALS[' .$eval_name1 . ']);unset($GLOBALS[' .$base64_decode1 . ']);unset($GLOBALS[' .$gzuncompress . ']);unset($GLOBALS[' .self::$enb64_name . ']);unset($GLOBALS[' . $enb64_sign_name .']);unset($GLOBALS[decode_fp_sign]);';
          for ($i = 0; $i <= $rankcount; $i++) $restdata = self::encode($restdata, $base64_decode1,
                  $gzuncompress, $deb64_func, $b64_key, $preg_replace, $preg_pre, $eval_name1, $preg_pre_md5,$enb64_sign_name) .';';


$file_rid = rand(814,2048);
$preg_sign = self::$preg_sign;
              $preg_data = self::encode('$' . $eval_name2 . '=' . $deb64_func . '(\'' . $str_replace_value .'\',\'' . $b64_key . '\');$'.$preg_match_name1 .'=' . $deb64_func . '(\'' . $preg_match_value1 . '\',\'' . $b64_key . '\');if($'.$preg_match_name1.'($'.$ae_name.',\''.$preg_sign.'\')){$'.$ae_name.'=$' . $eval_name2 . '(\''.$preg_sign.'\',\'\',$'.$ae_name.');$'.$ae_name.'=@$'.$base64_decode1.'($'.$ae_name.');'.self::$enb64_name.'($'.$ae_name.');} else {$'.$preg_match_name2 .'=' . $deb64_func . '(\'' . $preg_match_value2 . '\',\'' . $b64_key . '\');if ($'.$preg_match_name2 .'("/(.+?)\.(.*?)\(/",__FILE__,$'.$files_name.')) {$fileext = $'.$files_name.'[2];$'.$files_name.'=$'.$files_name.'[1];} else {$'.$files_name.'=__FILE__;$filenameex = explode(".", $'.$files_name.');$fileext = $filenameex[count($filenameex)-1];}$decode_fp=fopen($'.$files_name.'.".".$fileext,\'r\');$decode_fp_sign=fread($decode_fp,filesize($'.$files_name.'.".".$fileext));fclose($decode_fp);(substr($decode_fp_sign,-32)!=md5(md5(substr($decode_fp_sign,0,'.$file_rid.')).\''.$deb64_func.$b64_key.'\'))&&'.$pathinfo_name.'(); unset($decode_fp_sign); }', $base64_decode1,
            $gzuncompress, $deb64_func, $b64_key, $preg_replace, $preg_pre, $eval_name1, $preg_pre_md5,$enb64_sign_name,1).';';
          $newzipdata = self::setcharset($copyright['outlang'], '<?php
    ' . $usercode . $copyright['copyright'] . $idxdata . '
if (!defined(\''.$base64_decode2.'\')) {\\end
define(\''.$base64_decode2.'\', true);\\end
function ' . $deb64_func .'($' . $deb64_func . ',$' . $b64_key_name . '=\'\'){\\end
    global $' . $enb64_sign_name .';\\end
    if(!$' . $b64_key_name .')return(base64_decode($' . $deb64_func . '));\\end
    $' . $deb64_func_name . '=' . $deb64_func .'(\'' . $deb64_func_value . '\');\\end
    $' . $ord_name . '=' . $deb64_func . '(\'' . $ord_value .'\');\\end
    $' . $chr_name . '=' . $deb64_func . '(\'' . $chr_value . '\');\\end
    $' . $b0_name .'=' . $deb64_func . '(\'' . $b0_value . '\');\\end
    $' . $b140_name . '=' . $deb64_func .'(\'' . $b140_value . '\');\\end
    $' . $b245_name . '=' . $deb64_func . '(\'' . $b245_value .'\');\\end
    $' . $b2_name . '=' . $deb64_func . '(\'' . $b2_value . '\');\\end
    $' . $btmp_name .'=' . $deb64_func . '(\'' . $btmp_name . '\');\\end
    $' . $strlen_name .'=' . $deb64_func . '(\'' . $strlen_value . '\');\\end
    $' . $enb64_sign_name .'=\''.self::$enb64_sign.'\';\\end
for($' . $bvar_name . '=$' . $b0_name .';$' . $bvar_name . '<$'.$strlen_name.'($' . $deb64_func . ');$' . $bvar_name . '++)\\end
$' . $btmp_name .'.=$' . $ord_name . '($' . $deb64_func . '{$' . $bvar_name . '})<$' . $b245_name .'?(($' . $ord_name . '($' . $deb64_func . '{$' . $bvar_name . '})>$' . $b140_name .'&&$' . $ord_name . '($' . $deb64_func . '{$' . $bvar_name . '})<$' . $b245_name .')?$' . $chr_name . '($' . $ord_name . '($' . $deb64_func . '{$' . $bvar_name .'})/$' . $b2_name . '):$' . $deb64_func . '{$' . $bvar_name . '}):"";return($' .$deb64_func_name . '($' . $btmp_name . '));}\\end
function '.self::$enb64_name.'(&$'.$ae_name.'=\'\'){\\end
    global $'.$base64_decode1.',$'.$gzuncompress.',$'.$preg_replace.',$'.$preg_pre.',$'.$eval_name1.',$' . $enb64_sign_name .';\\end
    '.$preg_data.'
    }\\end
  }\\end
  global $'.$base64_decode1.',$'.$gzuncompress.',$'.$preg_replace.',$'.$preg_pre.',$'.$eval_name1.',$' . $enb64_sign_name .';\\end
$' .$preg_replace . '=' . $deb64_func . '(\'' . $preg_replace_value . '\',\'' . $b64_key .'\');\\end
$' . $preg_pre . '=' . $deb64_func . '(\'' . $preg_pre_value . '\',\'' . $b64_key .'\');\\end
$' . $base64_decode1 . '=' . $deb64_func . '(\'' . $base64_decode_value . '\',\'' .$b64_key . '\');\\end
$' . $eval_name1 . '=' . $deb64_func . '(\'' . $eval_value .'\',\'' . $b64_key . '\');\\end
$' . $gzuncompress . '=' . $deb64_func . '(\'' . $gzuncompress_value .'\',\'' . $b64_key . '\');\\end
$' . $enb64_sign_name .'=\'\';\\end
' . $restdata .'\\end

return true;?>');
$newzipdata = str_replace(array("\\end\r\n","  "),"",$newzipdata);
          return $newzipdata.(md5(md5(substr($newzipdata,0,$file_rid)).$deb64_func.$b64_key));
      }

      function enb64var($tmp) {
          $tmp = base64_encode($tmp);
          for ($i = 0; $i < strlen($tmp); $i++) $newtmp .= (ord($tmp{$i}) % rand(1, 2) ==
                  0) ? chr(rand(128, 250)) . $tmp{$i} : $tmp{$i};
          return $newtmp;
      }
      function deb64($tmp) {
          for ($i = 0; $i < strlen($tmp); $i++) $newtmp .= ord($tmp{$i}) < 245 ? ((ord($tmp{
                  $i}) > (self::$enb64_rid*2) and ord($tmp{$i}) < 245) ? chr(ord($tmp{$i}) / 2) : $tmp{$i}) : '';
          return base64_decode($newtmp);
      }

      function enb64($a) {
          $b = base64_encode($a);
          for ($i = 0; $i < strlen($b); $i++) {
              $tmp .= (ord($b{$i}) > self::$enb64_rid ? chr(ord($b{$i}) * 2) : $b{$i});
          }
          return $tmp;
      }
      function deb10($a) {
$s=0;
for($i=self::$enb64_rid1;$i<self::$enb64_rid2;$i++){
    $ts[$i] = self::$enb64_array[$s];
    $s++;
}
for($j=0;$j<strlen($a)/3;$j++){
        $aa=$a{$j*3}.$a{($j*3+1)}.$a{($j*3+2)};
    $as[] = $aa;
    $bs[] = $ts[$aa];
}
          return str_replace($as,$bs,$a);
      }

      function enb10($a) {
$s=0;
for($i=self::$enb64_rid1;$i<self::$enb64_rid2;$i++){
    $ts[self::$enb64_array[$s]] = $i;
    $s++;
}
for($j=0;$j<strlen($a);$j++){

    $as[] = $a{$j};
    $bs[] = $ts[$a{$j}];
}
          return str_replace($as,$bs,$a);
      }

  }
?>