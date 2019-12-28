<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 4.7.5
*/error_reporting(6135);$Xc=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($Xc||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$Ji=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($Ji)$$X=$Ji;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection(){global$g;return$g;}function
adminer(){global$b;return$b;}function
version(){global$ia;return$ia;}function
idf_unescape($u){$qe=substr($u,-1);return
str_replace($qe.$qe,$qe,substr($u,1,-1));}function
escape_string($X){return
substr(q($X),1,-1);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes($tg,$Xc=false){if(get_magic_quotes_gpc()){while(list($y,$X)=each($tg)){foreach($X
as$fe=>$W){unset($tg[$y][$fe]);if(is_array($W)){$tg[$y][stripslashes($fe)]=$W;$tg[]=&$tg[$y][stripslashes($fe)];}else$tg[$y][stripslashes($fe)]=($Xc?$W:stripslashes($W));}}}}function
bracket_escape($u,$Pa=false){static$vi=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($u,($Pa?array_flip($vi):$vi));}function
min_version($bj,$Ee="",$h=null){global$g;if(!$h)$h=$g;$oh=$h->server_info;if($Ee&&preg_match('~([\d.]+)-MariaDB~',$oh,$A)){$oh=$A[1];$bj=$Ee;}return(version_compare($oh,$bj)>=0);}function
charset($g){return(min_version("5.5.3",0,$g)?"utf8mb4":"utf8");}function
script($zh,$ui="\n"){return"<script".nonce().">$zh</script>$ui";}function
script_src($Oi){return"<script src='".h($Oi)."'".nonce()."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($P){return
str_replace("\0","&#0;",htmlspecialchars($P,ENT_QUOTES,'utf-8'));}function
nl_br($P){return
str_replace("\n","<br>",$P);}function
checkbox($B,$Y,$gb,$me="",$vf="",$lb="",$ne=""){$H="<input type='checkbox' name='$B' value='".h($Y)."'".($gb?" checked":"").($ne?" aria-labelledby='$ne'":"").">".($vf?script("qsl('input').onclick = function () { $vf };",""):"");return($me!=""||$lb?"<label".($lb?" class='$lb'":"").">$H".h($me)."</label>":$H);}function
optionlist($Af,$ih=null,$Ti=false){$H="";foreach($Af
as$fe=>$W){$Bf=array($fe=>$W);if(is_array($W)){$H.='<optgroup label="'.h($fe).'">';$Bf=$W;}foreach($Bf
as$y=>$X)$H.='<option'.($Ti||is_string($y)?' value="'.h($y).'"':'').(($Ti||is_string($y)?(string)$y:$X)===$ih?' selected':'').'>'.h($X);if(is_array($W))$H.='</optgroup>';}return$H;}function
html_select($B,$Af,$Y="",$uf=true,$ne=""){if($uf)return"<select name='".h($B)."'".($ne?" aria-labelledby='$ne'":"").">".optionlist($Af,$Y)."</select>".(is_string($uf)?script("qsl('select').onchange = function () { $uf };",""):"");$H="";foreach($Af
as$y=>$X)$H.="<label><input type='radio' name='".h($B)."' value='".h($y)."'".($y==$Y?" checked":"").">".h($X)."</label>";return$H;}function
select_input($Ka,$Af,$Y="",$uf="",$fg=""){$Zh=($Af?"select":"input");return"<$Zh$Ka".($Af?"><option value=''>$fg".optionlist($Af,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$fg'>").($uf?script("qsl('$Zh').onchange = $uf;",""):"");}function
confirm($Oe="",$jh="qsl('input')"){return
script("$jh.onclick = function () { return confirm('".($Oe?js_escape($Oe):lang(0))."'); };","");}function
print_fieldset($t,$ve,$ej=false){echo"<fieldset><legend>","<a href='#fieldset-$t'>$ve</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$t');",""),"</legend>","<div id='fieldset-$t'".($ej?"":" class='hidden'").">\n";}function
bold($Xa,$lb=""){return($Xa?" class='active $lb'":($lb?" class='$lb'":""));}function
odd($H=' class="odd"'){static$s=0;if(!$H)$s=-1;return($s++%2?$H:'');}function
js_escape($P){return
addcslashes($P,"\r\n'\\/");}function
json_row($y,$X=null){static$Yc=true;if($Yc)echo"{";if($y!=""){echo($Yc?"":",")."\n\t\"".addcslashes($y,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$Yc=false;}else{echo"\n}\n";$Yc=true;}}function
ini_bool($Sd){$X=ini_get($Sd);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$H;if($H===null)$H=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$H;}function
set_password($aj,$M,$V,$E){$_SESSION["pwds"][$aj][$M][$V]=($_COOKIE["adminer_key"]&&is_string($E)?array(encrypt_string($E,$_COOKIE["adminer_key"])):$E);}function
get_password(){$H=get_session("pwds");if(is_array($H))$H=($_COOKIE["adminer_key"]?decrypt_string($H[0],$_COOKIE["adminer_key"]):false);return$H;}function
q($P){global$g;return$g->quote($P);}function
get_vals($F,$e=0){global$g;$H=array();$G=$g->query($F);if(is_object($G)){while($I=$G->fetch_row())$H[]=$I[$e];}return$H;}function
get_key_vals($F,$h=null,$rh=true){global$g;if(!is_object($h))$h=$g;$H=array();$G=$h->query($F);if(is_object($G)){while($I=$G->fetch_row()){if($rh)$H[$I[0]]=$I[1];else$H[]=$I[0];}}return$H;}function
get_rows($F,$h=null,$n="<p class='error'>"){global$g;$zb=(is_object($h)?$h:$g);$H=array();$G=$zb->query($F);if(is_object($G)){while($I=$G->fetch_assoc())$H[]=$I;}elseif(!$G&&!is_object($h)&&$n&&defined("PAGE_HEADER"))echo$n.error()."\n";return$H;}function
unique_array($I,$w){foreach($w
as$v){if(preg_match("~PRIMARY|UNIQUE~",$v["type"])){$H=array();foreach($v["columns"]as$y){if(!isset($I[$y]))continue
2;$H[$y]=$I[$y];}return$H;}}}function
escape_key($y){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$y,$A))return$A[1].idf_escape(idf_unescape($A[2])).$A[3];return
idf_escape($y);}function
where($Z,$p=array()){global$g,$x;$H=array();foreach((array)$Z["where"]as$y=>$X){$y=bracket_escape($y,1);$e=escape_key($y);$H[]=$e.($x=="sql"&&is_numeric($X)&&preg_match('~\.~',$X)?" LIKE ".q($X):($x=="mssql"?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($p[$y],q($X))));if($x=="sql"&&preg_match('~char|text~',$p[$y]["type"])&&preg_match("~[^ -@]~",$X))$H[]="$e = ".q($X)." COLLATE ".charset($g)."_bin";}foreach((array)$Z["null"]as$y)$H[]=escape_key($y)." IS NULL";return
implode(" AND ",$H);}function
where_check($X,$p=array()){parse_str($X,$eb);remove_slashes(array(&$eb));return
where($eb,$p);}function
where_link($s,$e,$Y,$xf="="){return"&where%5B$s%5D%5Bcol%5D=".urlencode($e)."&where%5B$s%5D%5Bop%5D=".urlencode(($Y!==null?$xf:"IS NULL"))."&where%5B$s%5D%5Bval%5D=".urlencode($Y);}function
convert_fields($f,$p,$K=array()){$H="";foreach($f
as$y=>$X){if($K&&!in_array(idf_escape($y),$K))continue;$Ha=convert_field($p[$y]);if($Ha)$H.=", $Ha AS ".idf_escape($y);}return$H;}function
cookie($B,$Y,$ye=2592000){global$ba;return
header("Set-Cookie: $B=".urlencode($Y).($ye?"; expires=".gmdate("D, d M Y H:i:s",time()+$ye)." GMT":"")."; path=".preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
restart_session(){if(!ini_bool("session.use_cookies"))session_start();}function
stop_session($dd=false){$Si=ini_bool("session.use_cookies");if(!$Si||$dd){session_write_close();if($Si&&@ini_set("session.use_cookies",false)===false)session_start();}}function&get_session($y){return$_SESSION[$y][DRIVER][SERVER][$_GET["username"]];}function
set_session($y,$X){$_SESSION[$y][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($aj,$M,$V,$l=null){global$gc;preg_match('~([^?]*)\??(.*)~',remove_from_uri(implode("|",array_keys($gc))."|username|".($l!==null?"db|":"").session_name()),$A);return"$A[1]?".(sid()?SID."&":"").($aj!="server"||$M!=""?urlencode($aj)."=".urlencode($M)."&":"")."username=".urlencode($V).($l!=""?"&db=".urlencode($l):"").($A[2]?"&$A[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
redirect($_e,$Oe=null){if($Oe!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($_e!==null?$_e:$_SERVER["REQUEST_URI"]))][]=$Oe;}if($_e!==null){if($_e=="")$_e=".";header("Location: $_e");exit;}}function
query_redirect($F,$_e,$Oe,$Eg=true,$Ec=true,$Pc=false,$hi=""){global$g,$n,$b;if($Ec){$Gh=microtime(true);$Pc=!$g->query($F);$hi=format_time($Gh);}$Bh="";if($F)$Bh=$b->messageQuery($F,$hi,$Pc);if($Pc){$n=error().$Bh.script("messagesPrint();");return
false;}if($Eg)redirect($_e,$Oe.$Bh);return
true;}function
queries($F){global$g;static$yg=array();static$Gh;if(!$Gh)$Gh=microtime(true);if($F===null)return
array(implode("\n",$yg),format_time($Gh));$yg[]=(preg_match('~;$~',$F)?"DELIMITER ;;\n$F;\nDELIMITER ":$F).";";return$g->query($F);}function
apply_queries($F,$S,$Ac='table'){foreach($S
as$Q){if(!queries("$F ".$Ac($Q)))return
false;}return
true;}function
queries_redirect($_e,$Oe,$Eg){list($yg,$hi)=queries(null);return
query_redirect($yg,$_e,$Oe,$Eg,false,!$Eg,$hi);}function
format_time($Gh){return
lang(1,max(0,microtime(true)-$Gh));}function
remove_from_uri($Qf=""){return
substr(preg_replace("~(?<=[?&])($Qf".(SID?"":"|".session_name()).")=[^&]*&~",'',"$_SERVER[REQUEST_URI]&"),0,-1);}function
pagination($D,$Mb){return" ".($D==$Mb?$D+1:'<a href="'.h(remove_from_uri("page").($D?"&page=$D".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($D+1)."</a>");}function
get_file($y,$Ub=false){$Vc=$_FILES[$y];if(!$Vc)return
null;foreach($Vc
as$y=>$X)$Vc[$y]=(array)$X;$H='';foreach($Vc["error"]as$y=>$n){if($n)return$n;$B=$Vc["name"][$y];$pi=$Vc["tmp_name"][$y];$Bb=file_get_contents($Ub&&preg_match('~\.gz$~',$B)?"compress.zlib://$pi":$pi);if($Ub){$Gh=substr($Bb,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$Gh,$Kg))$Bb=iconv("utf-16","utf-8",$Bb);elseif($Gh=="\xEF\xBB\xBF")$Bb=substr($Bb,3);$H.=$Bb."\n\n";}else$H.=$Bb;}return$H;}function
upload_error($n){$Le=($n==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($n?lang(2).($Le?" ".lang(3,$Le):""):lang(4));}function
repeat_pattern($dg,$we){return
str_repeat("$dg{0,65535}",$we/65535)."$dg{0,".($we%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
shorten_utf8($P,$we=80,$Nh=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$we).")($)?)u",$P,$A))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$we).")($)?)",$P,$A);return
h($A[1]).$Nh.(isset($A[2])?"":"<i>â€¦</i>");}function
format_number($X){return
strtr(number_format($X,0,".",lang(5)),preg_split('~~u',lang(6),-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~[^a-z0-9_]~i','-',$X);}function
hidden_fields($tg,$Hd=array()){$H=false;while(list($y,$X)=each($tg)){if(!in_array($y,$Hd)){if(is_array($X)){foreach($X
as$fe=>$W)$tg[$y."[$fe]"]=$W;}else{$H=true;echo'<input type="hidden" name="'.h($y).'" value="'.h($X).'">';}}}return$H;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
table_status1($Q,$Qc=false){$H=table_status($Q,$Qc);return($H?$H:array("Name"=>$Q));}function
column_foreign_keys($Q){global$b;$H=array();foreach($b->foreignKeys($Q)as$q){foreach($q["source"]as$X)$H[$X][]=$q;}return$H;}function
enum_input($T,$Ka,$o,$Y,$vc=null){global$b;preg_match_all("~'((?:[^']|'')*)'~",$o["length"],$Ge);$H=($vc!==null?"<label><input type='$T'$Ka value='$vc'".((is_array($Y)?in_array($vc,$Y):$Y===0)?" checked":"")."><i>".lang(7)."</i></label>":"");foreach($Ge[1]as$s=>$X){$X=stripcslashes(str_replace("''","'",$X));$gb=(is_int($Y)?$Y==$s+1:(is_array($Y)?in_array($s+1,$Y):$Y===$X));$H.=" <label><input type='$T'$Ka value='".($s+1)."'".($gb?' checked':'').'>'.h($b->editVal($X,$o)).'</label>';}return$H;}function
input($o,$Y,$r){global$U,$b,$x;$B=h(bracket_escape($o["field"]));echo"<td class='function'>";if(is_array($Y)&&!$r){$Fa=array($Y);if(version_compare(PHP_VERSION,5.4)>=0)$Fa[]=JSON_PRETTY_PRINT;$Y=call_user_func_array('json_encode',$Fa);$r="json";}$Og=($x=="mssql"&&$o["auto_increment"]);if($Og&&!$_POST["save"])$r=null;$md=(isset($_GET["select"])||$Og?array("orig"=>lang(8)):array())+$b->editFunctions($o);$Ka=" name='fields[$B]'";if($o["type"]=="enum")echo
h($md[""])."<td>".$b->editInput($_GET["edit"],$o,$Ka,$Y);else{$wd=(in_array($r,$md)||isset($md[$r]));echo(count($md)>1?"<select name='function[$B]'>".optionlist($md,$r===null||$wd?$r:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($md))).'<td>';$Ud=$b->editInput($_GET["edit"],$o,$Ka,$Y);if($Ud!="")echo$Ud;elseif(preg_match('~bool~',$o["type"]))echo"<input type='hidden'$Ka value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$Ka value='1'>";elseif($o["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$o["length"],$Ge);foreach($Ge[1]as$s=>$X){$X=stripcslashes(str_replace("''","'",$X));$gb=(is_int($Y)?($Y>>$s)&1:in_array($X,explode(",",$Y),true));echo" <label><input type='checkbox' name='fields[$B][$s]' value='".(1<<$s)."'".($gb?' checked':'').">".h($b->editVal($X,$o)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$o["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$B'>";elseif(($fi=preg_match('~text|lob|memo~i',$o["type"]))||preg_match("~\n~",$Y)){if($fi&&$x!="sqlite")$Ka.=" cols='50' rows='12'";else{$J=min(12,substr_count($Y,"\n")+1);$Ka.=" cols='30' rows='$J'".($J==1?" style='height: 1.2em;'":"");}echo"<textarea$Ka>".h($Y).'</textarea>';}elseif($r=="json"||preg_match('~^jsonb?$~',$o["type"]))echo"<textarea$Ka cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$Ne=(!preg_match('~int~',$o["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$o["length"],$A)?((preg_match("~binary~",$o["type"])?2:1)*$A[1]+($A[3]?1:0)+($A[2]&&!$o["unsigned"]?1:0)):($U[$o["type"]]?$U[$o["type"]]+($o["unsigned"]?0:1):0));if($x=='sql'&&min_version(5.6)&&preg_match('~time~',$o["type"]))$Ne+=7;echo"<input".((!$wd||$r==="")&&preg_match('~(?<!o)int(?!er)~',$o["type"])&&!preg_match('~\[\]~',$o["full_type"])?" type='number'":"")." value='".h($Y)."'".($Ne?" data-maxlength='$Ne'":"").(preg_match('~char|binary~',$o["type"])&&$Ne>20?" size='40'":"")."$Ka>";}echo$b->editHint($_GET["edit"],$o,$Y);$Yc=0;foreach($md
as$y=>$X){if($y===""||!$X)break;$Yc++;}if($Yc)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $Yc), oninput: function () { this.onchange(); }});");}}function
process_input($o){global$b,$m;$u=bracket_escape($o["field"]);$r=$_POST["function"][$u];$Y=$_POST["fields"][$u];if($o["type"]=="enum"){if($Y==-1)return
false;if($Y=="")return"NULL";return+$Y;}if($o["auto_increment"]&&$Y=="")return
null;if($r=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$o["on_update"])?idf_escape($o["field"]):false);if($r=="NULL")return"NULL";if($o["type"]=="set")return
array_sum((array)$Y);if($r=="json"){$r="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$o["type"])&&ini_bool("file_uploads")){$Vc=get_file("fields-$u");if(!is_string($Vc))return
false;return$m->quoteBinary($Vc);}return$b->processInput($o,$Y,$r);}function
fields_from_edit(){global$m;$H=array();foreach((array)$_POST["field_keys"]as$y=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$y];$_POST["fields"][$X]=$_POST["field_vals"][$y];}}foreach((array)$_POST["fields"]as$y=>$X){$B=bracket_escape($y,1);$H[$B]=array("field"=>$B,"privileges"=>array("insert"=>1,"update"=>1),"null"=>1,"auto_increment"=>($y==$m->primary),);}return$H;}function
search_tables(){global$b,$g;$_GET["where"][0]["val"]=$_POST["query"];$lh="<ul>\n";foreach(table_status('',true)as$Q=>$R){$B=$b->tableName($R);if(isset($R["Engine"])&&$B!=""&&(!$_POST["tables"]||in_array($Q,$_POST["tables"]))){$G=$g->query("SELECT".limit("1 FROM ".table($Q)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($Q),array())),1));if(!$G||$G->fetch_row()){$pg="<a href='".h(ME."select=".urlencode($Q)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$B</a>";echo"$lh<li>".($G?$pg:"<p class='error'>$pg: ".error())."\n";$lh="";}}}echo($lh?"<p class='message'>".lang(9):"</ul>")."\n";}function
dump_headers($Ed,$Xe=false){global$b;$H=$b->dumpHeaders($Ed,$Xe);$Nf=$_POST["output"];if($Nf!="text")header("Content-Disposition: attachment; filename=".$b->dumpFilename($Ed).".$H".($Nf!="file"&&!preg_match('~[^0-9a-z]~',$Nf)?".$Nf":""));session_write_close();ob_flush();flush();return$H;}function
dump_csv($I){foreach($I
as$y=>$X){if(preg_match("~[\"\n,;\t]~",$X)||$X==="")$I[$y]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$I)."\r\n";}function
apply_sql_function($r,$e){return($r?($r=="unixepoch"?"DATETIME($e, '$r')":($r=="count distinct"?"COUNT(DISTINCT ":strtoupper("$r("))."$e)"):$e);}function
get_temp_dir(){$H=ini_get("upload_tmp_dir");if(!$H){if(function_exists('sys_get_temp_dir'))$H=sys_get_temp_dir();else{$Wc=@tempnam("","");if(!$Wc)return
false;$H=dirname($Wc);unlink($Wc);}}return$H;}function
file_open_lock($Wc){$kd=@fopen($Wc,"r+");if(!$kd){$kd=@fopen($Wc,"w");if(!$kd)return;chmod($Wc,0660);}flock($kd,LOCK_EX);return$kd;}function
file_write_unlock($kd,$Ob){rewind($kd);fwrite($kd,$Ob);ftruncate($kd,strlen($Ob));flock($kd,LOCK_UN);fclose($kd);}function
password_file($i){$Wc=get_temp_dir()."/adminer.key";$H=@file_get_contents($Wc);if($H||!$i)return$H;$kd=@fopen($Wc,"w");if($kd){chmod($Wc,0660);$H=rand_string();fwrite($kd,$H);fclose($kd);}return$H;}function
rand_string(){return
md5(uniqid(mt_rand(),true));}function
select_value($X,$_,$o,$gi){global$b;if(is_array($X)){$H="";foreach($X
as$fe=>$W)$H.="<tr>".($X!=array_values($X)?"<th>".h($fe):"")."<td>".select_value($W,$_,$o,$gi);return"<table cellspacing='0'>$H</table>";}if(!$_)$_=$b->selectLink($X,$o);if($_===null){if(is_mail($X))$_="mailto:$X";if(is_url($X))$_=$X;}$H=$b->editVal($X,$o);if($H!==null){if(!is_utf8($H))$H="\0";elseif($gi!=""&&is_shortable($o))$H=shorten_utf8($H,max(0,+$gi));else$H=h($H);}return$b->selectVal($H,$_,$o,$X);}function
is_mail($sc){$Ia='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$fc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$dg="$Ia+(\\.$Ia+)*@($fc?\\.)+$fc";return
is_string($sc)&&preg_match("(^$dg(,\\s*$dg)*\$)i",$sc);}function
is_url($P){$fc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($fc?\\.)+$fc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$P);}function
is_shortable($o){return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~',$o["type"]);}function
count_rows($Q,$Z,$ae,$pd){global$x;$F=" FROM ".table($Q).($Z?" WHERE ".implode(" AND ",$Z):"");return($ae&&($x=="sql"||count($pd)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$pd).")$F":"SELECT COUNT(*)".($ae?" FROM (SELECT 1$F GROUP BY ".implode(", ",$pd).") x":$F));}function
slow_query($F){global$b,$ri,$m;$l=$b->database();$ii=$b->queryTimeout();$wh=$m->slowQuery($F,$ii);if(!$wh&&support("kill")&&is_object($h=connect())&&($l==""||$h->select_db($l))){$ke=$h->result(connection_id());echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$ke,'&token=',$ri,'\');
}, ',1000*$ii,');
</script>
';}else$h=null;ob_flush();flush();$H=@get_key_vals(($wh?$wh:$F),$h,false);if($h){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$H;}function
get_token(){$Ag=rand(1,1e6);return($Ag^$_SESSION["token"]).":$Ag";}function
verify_token(){list($ri,$Ag)=explode(":",$_POST["token"]);return($Ag^$_SESSION["token"])==$ri;}function
lzw_decompress($Ta){$cc=256;$Ua=8;$nb=array();$Qg=0;$Rg=0;for($s=0;$s<strlen($Ta);$s++){$Qg=($Qg<<8)+ord($Ta[$s]);$Rg+=8;if($Rg>=$Ua){$Rg-=$Ua;$nb[]=$Qg>>$Rg;$Qg&=(1<<$Rg)-1;$cc++;if($cc>>$Ua)$Ua++;}}$bc=range("\0","\xFF");$H="";foreach($nb
as$s=>$mb){$rc=$bc[$mb];if(!isset($rc))$rc=$pj.$pj[0];$H.=$rc;if($s)$bc[]=$pj.$rc[0];$pj=$rc;}return$H;}function
on_help($tb,$th=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $tb, $th) }, onmouseout: helpMouseout});","");}function
edit_form($a,$p,$I,$Mi){global$b,$x,$ri,$n;$Sh=$b->tableName(table_status1($a,true));page_header(($Mi?lang(10):lang(11)),$n,array("select"=>array($a,$Sh)),$Sh);if($I===false)echo"<p class='error'>".lang(12)."\n";echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';if(!$p)echo"<p class='error'>".lang(13)."\n";else{echo"<table cellspacing='0' class='layout'>".script("qsl('table').onkeydown = editingKeydown;");foreach($p
as$B=>$o){echo"<tr><th>".$b->fieldName($o);$Vb=$_GET["set"][bracket_escape($B)];if($Vb===null){$Vb=$o["default"];if($o["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$Vb,$Kg))$Vb=$Kg[1];}$Y=($I!==null?($I[$B]!=""&&$x=="sql"&&preg_match("~enum|set~",$o["type"])?(is_array($I[$B])?array_sum($I[$B]):+$I[$B]):$I[$B]):(!$Mi&&$o["auto_increment"]?"":(isset($_GET["select"])?false:$Vb)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$o);$r=($_POST["save"]?(string)$_POST["function"][$B]:($Mi&&preg_match('~^CURRENT_TIMESTAMP~i',$o["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(preg_match("~time~",$o["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$r="now";}input($o,$Y,$r);echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($p){echo"<input type='submit' value='".lang(14)."'>\n";if(!isset($_GET["select"])){echo"<input type='submit' name='insert' value='".($Mi?lang(15):lang(16))."' title='Ctrl+Shift+Enter'>\n",($Mi?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".lang(17)."â€¦', this); };"):"");}}echo($Mi?"<input type='submit' name='delete' value='".lang(18)."'>".confirm()."\n":($_POST||!$p?"":script("focus(qsa('td', qs('#form'))[1].firstChild);")));if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$ri,'">
</form>
';}if(isset($_GET["file"])){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃşÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ıÀ/(%Œ\0");}elseif($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("\n1Ì‡“ÙŒŞl7œ‡B1„4vb0˜Ífs‘¼ên2BÌÑ±Ù˜Şn:‡#(¼b.\rDc)ÈÈa7E„‘¤Âl¦Ã±”èi1Ìs˜´ç-4™‡fÓ	ÈÎi7†³¹¤Èt4…¦ÓyèZf4°i–AT«VVéf:Ï¦,:1¦Qİ¼ñb2`Ç#ş>:7Gï—1ÑØÒs°™L—XD*bv<ÜŒ#£e@Ö:4ç§!fo·Æt:<¥Üå’¾™oâÜ\niÃÅğ',é»a_¤:¹iï…´ÁBvø|Nû4.5Nfi¢vpĞh¸°l¨ê¡ÖšÜO¦‰î= £OFQĞÄk\$¥Óiõ™ÀÂd2Tã¡pàÊ6„‹ş‡¡-ØZ€ƒ Ş6½£€ğh:¬aÌ,£ëî2#8Ğ±#’˜6nâî†ñJˆ¢h«t…Œ±Šä4O42ô½okŞ¾*r ©€@p@†!Ä¾ÏÃôş?Ğ6À‰r[ğLÁğ‹:2Bˆj§!HbóÃPä=!1V‰\"ˆ²0…¿\nSÆÆÏD7ÃìDÚ›ÃC!†!›à¦GÊŒ§ È+’=tCæ©.C¤À:+ÈÊ=ªªº²¡±å%ªcí1MR/”EÈ’4„© 2°ä± ã`Â8(áÓ¹[WäÑ=‰ySb°=Ö-Ü¹BS+É¯ÈÜı¥ø@pL4Ydã„qŠøã¦ğê¢6£3Ä¬¯¸AcÜŒèÎ¨Œk‚[&>ö•¨ZÁpkm]—u-c:Ø¸ˆNtæÎ´pÒŒŠ8è=¿#˜á[.ğÜŞ¯~ mËy‡PPá|IÖ›ùÀìQª9v[–Q•„\n–Ùrô'g‡+áTÑ2…­VÁõzä4£8÷(	¾Ey*#j¬2]­•RÒÁ‘¥)ƒÀ[N­R\$Š<>:ó­>\$;–> Ì\r»„ÎHÍÃTÈ\nw¡N åwØ£¦ì<ïËGwàöö¹\\Yó_ Rt^Œ>\r}ŒÙS\rzé4=µ\nL”%Jã‹\",Z 8¸™i÷0u©?¨ûÑô¡s3#¨Ù‰ :ó¦ûã½–ÈŞE]xİÒs^8£K^É÷*0ÑŞwŞàÈŞ~ãö:íÑiØşv2w½ÿ±û^7ãò7£cİÑu+U%{PÜ*4Ì¼éLX./!¼‰1CÅßqx!H¹ãFdù­L¨¤¨Ä Ï`6ëè5®™f€¸Ä†¨=Høl ŒV1“›\0a2×;Ô6†àöş_Ù‡Ä\0&ôZÜS d)KE'’€nµ[X©³\0ZÉŠÔF[P‘Ş˜@àß!‰ñYÂ,`É\"Ú·Â0Ee9yF>ËÔ9bº–ŒæF5:üˆ”\0}Ä´Š‡(\$Ó‡ë€37Hö£è M¾A°²6R•ú{Mqİ7G ÚC™Cêm2¢(ŒCt>[ì-tÀ/&C›]êetGôÌ¬4@r>ÇÂå<šSq•/åú”QëhmšÀĞÆôãôLÀÜ#èôKË|®™„6fKPİ\r%tÔÓV=\" SH\$} ¸)w¡,W\0F³ªu@Øb¦9‚\rr°2Ã#¬DŒ”Xƒ³ÚyOIù>»…n†Ç¢%ãù'‹İ_Á€t\rÏ„zÄ\\1˜hl¼]Q5Mp6k†ĞÄqhÃ\$£H~Í|Òİ!*4ŒñòÛ`Sëı²S tíPP\\g±è7‡\n-Š:è¢ªp´•”ˆl‹B¦î”7Ó¨cƒ(wO0\\:•Ğw”Áp4ˆ“ò{TÚújO¤6HÃŠ¶rÕ¥q\n¦É%%¶y']\$‚”a‘ZÓ.fcÕq*-êFWºúk„zƒ°µj‘°lgáŒ:‡\$\"ŞN¼\r#ÉdâÃ‚ÂÿĞscá¬Ì „ƒ\"jª\rÀ¶–¦ˆÕ’¼Ph‹1/‚œDA) ²İ[ÀknÁp76ÁY´‰R{áM¤Pû°ò@\n-¸a·6şß[»zJH,–dl B£ho³ìò¬+‡#Dr^µ^µÙeš¼E½½– ÄœaP‰ôõJG£zàñtñ 2ÇXÙ¢´Á¿V¶×ßàŞÈ³‰ÑB_%K=E©¸bå¼¾ßÂ§kU(.!Ü®8¸œüÉI.@KÍxnş¬ü:ÃPó32«”míH		C*ì:vâTÅ\nR¹ƒ•µ‹0uÂíƒæîÒ§]Î¯˜Š”P/µJQd¥{L–Ş³:YÁ2b¼œT ñÊ3Ó4†—äcê¥V=¿†L4ÎĞrÄ!ßBğY³6Í­MeLŠªÜçœöùiÀoĞ9< G”¤Æ•Ğ™Mhm^¯UÛNÀŒ·òTr5HiM”/¬nƒí³T [-<__î3/Xr(<‡¯Š†®Éô“ÌuÒ–GNX20å\r\$^‡:'9è¶O…í;×k¼†µf –N'a¶”Ç­bÅ,ËV¤ô…«1µïHI!%6@úÏ\$ÒEGÚœ¬1(mUªå…rÕ½ïßå`¡ĞiN+Ãœñ)šœä0lØÒf0Ã½[UâøVÊè-:I^ ˜\$Øs«b\re‡‘ugÉhª~9Ûßˆb˜µôÂÈfä+0¬Ô hXrİ¬©!\$—e,±w+„÷ŒëŒ3†Ì_âA…kšù\nkÃrõÊ›cuWdYÿ\\×={.óÄ˜¢g»‰p8œt\rRZ¿vJ:²>ş£Y|+Å@À‡ƒÛCt\r€jt½6²ğ%Â?àôÇñ’>ù/¥ÍÇğÎ9F`×•äòv~K¤áöÑRĞW‹ğz‘êlmªwLÇ9Y•*q¬xÄzñèSe®İ›³è÷£~šDàÍá–÷x˜¾ëÉŸi7•2ÄøÑOİ»’û_{ñú53âút˜›_ŸõzÔ3ùd)‹C¯Â\$?KÓªP%ÏÏT&ş˜&\0P×NA^­~¢ƒ pÆ öÏœ“Ôõ\r\$ŞïĞÖìb*+D6ê¶¦ÏˆŞíJ\$(ÈolŞÍh&”ìKBS>¸‹ö;z¶¦xÅoz>íœÚoÄZğ\nÊ‹[Ïvõ‚ËÈœµ°2õOxÙVø0fû€ú¯Ş2BlÉbkĞ6ZkµhXcdê0*ÂKTâ¯H=­•Ï€‘p0ŠlVéõèâ\r¼Œ¥nm¦ï)((ô:#¦âòE‰Ü:C¨CàÚâ\r¨G\rÃ©0÷…iæÚ°ş:`Z1Q\n:€à\r\0àçÈq±°ü:`¿-ÈM#}1;èş¹‹q‘#|ñS€¾¢hl™DÄ\0fiDpëL ``™°çÑ0y€ß1…€ê\rñ=‘MQ\\¤³%oq–­\0Øñ£1¨21¬1°­ ¿±§Ñœbi:“í\r±/Ñ¢› `)šÄ0ù‘@¾Â›±ÃI1«NàCØàŠµñO±¢Zñã1±ïq1 òÑüà,å\rdIÇ¦väjí‚1 tÚBø“°â’0:…0ğğ“1 A2V„ñâ0 éñ%²fi3!&Q·Rc%Òq&w%Ñì\ràVÈ#Êø™Qw`‹% ¾„Òm*r…Òy&iß+r{*²»(rg(±#(2­(ğå)R@i›-  ˆ•1\"\0Û²Rêÿ.e.rëÄ,¡ry(2ªCàè²bì!BŞ3%Òµ,R¿1²Æ&èşt€äbèa\rL“³-3á Ö ó\0æóBp—1ñ94³O'R°3*²³=\$à[£^iI;/3i©5Ò&’}17²# Ñ¹8 ¿\"ß7Ñå8ñ9*Ò23™!ó!1\\\0Ï8“­rk9±;S…23¶àÚ“*Ó:q]5S<³Á#383İ#eÑ=¹>~9Sè³‘rÕ)€ŒT*aŸ@Ñ–ÙbesÙÔ£:-ó€éÇ*;, Ø™3!i´›‘LÒ²ğ#1 +nÀ «*²ã@³3i7´1©´_•F‘S;3ÏF±\rA¯é3õ>´x:ƒ \r³0ÎÔ@’-Ô/¬ÓwÓÛ7ñ„ÓS‘J3› ç.Fé\$O¤B’±—%4©+tÃ'góLq\rJt‡JôËM2\rôÍ7ñÆT@“£¾)â“£dÉ2€P>Î°€Fià²´ş\nr\0¸bçk(´D¶¿ãKQƒ¤´ã1ã\"2t”ôôºPè\rÃÀ,\$KCtò5ôö#ôú)¢áP#Pi.ÎU2µCæ~Ş\"ä");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…†81ĞÊx:\nOg#)Ğêr7\n\"†è´`ø|2ÌgSi–H)N¦S‘ä§\r‡\"0¹Ä@ä)Ÿ`(\$s6O!ÓèœV/=Œ' T4æ=„˜iS˜6IO G#ÒX·VCÆs¡ Z1.Ğhp8,³[¦Häµ~Cz§Éå2¹l¾c3šÍés£‘ÙI†bâ4\néF8Tà†I˜İ©U*fz¹är0EÆÀØy¸ñfY.:æƒIŒÊ(Øc·áÎ‹!_l™í^·^(¶šN{S–“)rËqÁY“–lÙ¦3Š3Ú\n˜+G¥Óêyºí†Ëi¶ÂîxV3w³uhã^rØÀº´aÛ”ú¹cØè\r“¨ë(.ÂˆºChÒ<\r)èÑ£¡`æ7£íò43'm5Œ£È\nPÜ:2£P»ª‹q òÿÅC“}Ä«ˆúÊÁê38‹BØ0hR‰Èr(œ0¥¡b\\0ŒHr44ŒÁB!¡pÇ\$rZZË2Ü‰.Éƒ(\\5Ã|\nC(Î\"€P…ğø.ĞNÌRTÊÎ“Àæ>HN…8HPá\\¬7Jp~„Üû2%¡ĞOC¨1ã.ƒ§C8Î‡HÈò*ˆj°…á÷S(¹/¡ì¬6KUœÊ‡¡<2‰pOI„ôÕ`Ôäâ³ˆdOH Ş5-üÆ4ŒãpX25-Ò¢òÛˆ°z7£¸\"(°P \\32:]UÚèíâß…!]¸<·AÛÛ¤’ĞßiÚ°‹l\rÔ\0v²Î#J8«ÏwmíÉ¤¨<ŠÉ æü%m;p#ã`XDŒø÷iZøN0Œ•È9ø¨å Áè`…wJD¿¾2Ò9tŒ¢*øÎyìËNiIh\\9ÆÕèĞ:ƒ€æáxï­µyl*šÈˆÎæY Ü‡øê8’W³â?µŞ›3ÙğÊ!\"6å›n[¬Ê\r­*\$¶Æ§¾nzxÆ9\rì|*3×£pŞï»¶:(p\\;ÔËmz¢ü§9óĞÑÂŒü8N…Áj2½«Î\rÉHîH&Œ²(Ãz„Á7iÛk£ ‹Š¤‚c¤‹eòı§tœÌÌ2:SHóÈ Ã/)–xŞ@éåt‰ri9¥½õëœ8ÏÀËïyÒ·½°VÄ+^WÚ¦­¬kZæY—l·Ê£Œ4ÖÈÆ‹ª¶À¬‚ğ\\EÈ{î7\0¹p†€•D€„i”-TæşÚû0l°%=Á ĞËƒ9(„5ğ\n\n€n,4‡\0èa}Üƒ.°öRsï‚ª\02B\\Ûb1ŸS±\0003,ÔXPHJspåd“Kƒ CA!°2*WŸÔñÚ2\$ä+Âf^\n„1Œ´òzEƒ Iv¤\\äœ2É .*A°™”E(d±á°ÃbêÂÜ„Æ9‡‚â€ÁDh&­ª?ÄH°sQ˜2’x~nÃJ‹T2ù&ãàeRœ½™GÒQTwêİ‘»õPˆâã\\ )6¦ôâœÂòsh\\3¨\0R	À'\r+*;RğHà.“!Ñ[Í'~­%t< çpÜK#Â‘æ!ñlßÌğLeŒ³œÙ,ÄÀ®&á\$	Á½`”–CXš‰Ó†0Ö­å¼û³Ä:Méh	çÚœGäÑ!&3 D<!è23„Ã?h¤J©e Úğhá\r¡m•˜ğNi¸£´’†ÊNØHl7¡®v‚êWIå.´Á-Ó5Ö§ey\rEJ\ni*¼\$@ÚRU0,\$U¿E†¦ÔÔÂªu)@(tÎSJkáp!€~­‚àd`Ì>¯•\nÃ;#\rp9†jÉ¹Ü]&Nc(r€ˆ•TQUª½S·Ú\08n`«—y•b¤ÅLÜO5‚î,¤ò‘>‚†xââ±fä´’âØ+–\"ÑI€{kMÈ[\r%Æ[	¤eôaÔ1! èÿí³Ô®©F@«b)RŸ£72ˆî0¡\nW¨™±L²ÜœÒ®tdÕ+íÜ0wglø0n@òêÉ¢ÕiíM«ƒ\nA§M5nì\$E³×±NÛál©İŸ×ì%ª1 AÜûºú÷İkñrîiFB÷Ïùol,muNx-Í_ Ö¤C( fél\r1p[9x(i´BÒ–²ÛzQlüº8CÔ	´©XU Tb£İIİ`•p+V\0î‹Ñ;‹CbÎÀXñ+Ï’sïü]H÷Ò[ák‹x¬G*ô†]·awnú!Å6‚òâÛĞmSí¾“IŞÍKË~/Ó¥7ŞùeeNÉòªS«/;dåA†>}l~Ïê ¨%^´fçØ¢pÚœDEîÃa·‚t\nx=ÃkĞ„*dºêğT—ºüûj2ŸÉjœ\n‘ É ,˜e=‘†M84ôûÔa•j@îTÃsÔänf©İ\nî6ª\rdœ¼0ŞíôYŠ'%Ô“íŞ~	Ò¨†<ÖË–Aî‹–H¿G‚8ñ¿Îƒ\$z«ğ{¶»²u2*†àa–À>»(wŒK.bP‚{…ƒoı”Â´«zµ#ë2ö8=É8>ª¤³A,°e°À…+ìCè§xõ*ÃáÒ-b=m‡™Ÿ,‹a’Ãlzkï\$Wõ,mJiæÊ§á÷+‹èı0°[¯ÿ.RÊsKùÇäXçİZLËç2`Ì(ïCàvZ¡ÜİÀ¶è\$×¹,åD?H±ÖNxXôó)’îM¨‰\$ó,Í*\nÑ£\$<qÿÅŸh!¿¹S“âƒÀŸxsA!˜:´K¥Á}Á²“ù¬£œRşšA2k·Xp\n<÷ş¦ıëlì§Ù3¯ø¦È•VV¬}£g&Yİ!†+ó;<¸YÇóŸYE3r³Ùñ›Cío5¦Åù¢Õ³Ïkkş…ø°ÖÛ£«Ït÷’Uø…­)û[ıßÁî}ïØu´«lç¢:DŸø+Ï _oãäh140ÖáÊ0ø¯bäK˜ã¬’ öşé»lGª„#ªš©ê†¦©ì|Udæ¶IK«êÂ7à^ìà¸@º®O\0HÅğHiŠ6\r‡Û©Ü\\cg\0öãë2BÄ*eà\n€š	…zr!nWz& {H–ğ'\$X  w@Ò8ëDGr*ëÄİHå'p#Ä®€¦Ô\ndü€÷,ô¥—,ü;g~¯\0Ğ#€Ì²EÂ\rÖI`œî'ƒğ%EÒ. ]`ÊĞ›…î%&Ğîm°ı\râŞ%4S„vğ#\n fH\$%ë-Â#­ÆÑqBâíæ ÀÂQ-ôc2Š§‚&ÂÀÌ]à™ èqh\rñl]à®s ĞÑhä7±n#±‚‚Ú-àjE¯Frç¤l&dÀØÙåzìF6¸ˆÁ\" “|¿§¢s@ß±®åz)0rpÚ\0‚X\0¤Ùè|DL<!°ôo„*‡D¶{.B<Eª‹‹0nB(ï |\r\nì^©à h³!‚Öêr\$§’(^ª~èŞÂ/pq²ÌB¨ÅOšˆğú,\\µ¨#RRÎ%ëäÍdĞHjÄ`Â ô®Ì­ Vå bS’d§iE‚øïoh´r<i/k\$-Ÿ\$o”¼+ÆÅ‹ÎúlÒŞO³&evÆ’¼iÒjMPA'u'Î’( M(h/+«òWD¾So·.n·.ğn¸ìê(œ(\"­À§hö&p†¨/Ë/1DÌŠçjå¨¸EèŞ&â¦€,'l\$/.,Äd¨…‚W€bbO3óB³sH :J`!“.€ª‚‡Àû¥ ,FÀÑ7(‡ÈÔ¿³û1Šlås ÖÒ‘²—Å¢q¢X\rÀš®ƒ~Ré°±`®Òó®Y*ä:R¨ùrJ´·%LÏ+n¸\"ˆø\r¦ÎÍ‡H!qb¾2âLi±%ÓŞÎ¨Wj#9ÓÔObE.I:…6Á7\0Ë6+¤%°.È…Ş³a7E8VSå?(DG¨Ó³Bë%;ò¬ùÔ/<’´ú¥À\r ì´>ûQV–t/8®c8å\$\0ÈğŒ©RVæI8àRWÿ´\nÿäv¶¥yCìÌ-¢5FóŒæiQ0Ëè_ÔIE”sIR!¥ğŠXkè€z@¶`»¥·D‚`DV!Cæ8¥\r­´Ÿb“3©!3â@Ù33N}âZBó3F.H}ä30ÚÜM(ê>‚Ê}ä\\Ñtê‚f fŒËâI\r®€ó337 XÔ\"tdÎ,\nbtNO`Pâ;­Ü•Ò­ÀÔ¯\$\n‚ßäZÑ­5U5WUµ^hoıàætÙPM/5K4Ej³KQ&53GX“Xx)Ò<5D”^íûVô\nßr¢5bÜ€\\J\">§è1S\r[-¦ÊDuÀ\rÒâ§Ã)00óYõÈË¢·k{\nµÄ#µŞ\r³^·‹|èuÜ»Uå_nïU4ÉUŠ~YtÓ\rIšÃ@ä³™R ó3:ÒuePMSè0TµwW¯XÈòòD¨ò¤KF5Üà•‡;Uõ\n OYéYÍQ,M[\0÷_ªDšÍÈW ¾J*ì\rg(]à¨\r\"ZC‰©6uê+µYóˆY6Ã´0ªqõ(Ùó8}ó3AX3T h9j¶jàfcMtåPJbqMP5>ğÈø¶©Y‡k%&\\‚1d¢ØE4À µYnÊí\$<¥U]Ó‰1‰mbÖ¶^Òõš ê\"NVéßp¶ëpõ±eMÚŞ×WéÜ¢î\\ä)\n Ë\nf7\n×2´cr8‹—=K7tVš‡µ7P¦¶LÉía6òòv@'‚6iàïj&>±â;­ã`Òÿa	\0pÚ¨(µJ‘ë)«\\¿ªnûòÄ¬m\0¼¨2€ôeqJö­PôhŒë±fjüÂ\"[\0¨·†¢X,<\\Œî¶×â÷æ·+md†å~âàš…Ñs%o°´mn×),×„æÔ‡²\r4¶Â8\r±Î¸×mE‚H]‚¦˜üÖHW­M0Dïß€—å~Ë˜K˜îE}ø¸´à|fØ^“Ü×\r>Ô-z]2s‚xD˜d[s‡tŒS¢¶\0Qf-K`­¢‚tàØ„wT«9€æZ€à	ø\nB£9 Nb–ã<ÚBşI5o×oJñpÀÏJdåË\rhŞÃ2\"àyG¡C‚sÓ•V”¹Ò%zr+z±ùş\\’÷•œôm Ş±T öò ÷@Y2lQ<2O+¥%“Í.Óƒhù,AŞñ¸ŠÃZ‹2R¦À1£Š/¯hH\r¨X…ÈaNB&§ ÄM@Ö[xŒ‡Ê®¥ê–â8&LÚVÍœvà±*šj¤ÛšHåÈ\\Ùª	™®²&sÛ\0Qš`\\\"èb °	àÄ\rBs›‰wB	™İN`š7§Co(Ù¿à¨\nÃ¨“h1™ùÈ*E—àñS…ÓU0Uºtš#|Š4ƒ'{™ñ¡Ú #É5	 å	p„àyBà@Rô·™pŞ@|„º7\rå\0€_Bú^z<Bú@W4&Kús¢úxO×·àPà@Xâ]Ô…§úw>âZe{¨åLY‰¡LÚ¢\\’(*R` 	à¦\n…ŠàºÄQC£(*¹µc¢;œlÚp†X|`N¨‚¾\$€[†‰’@ÍU¢àğ¦¶àZ¥`Zd\"\\\"…‚¢£)«Iˆ:àtšäoDæ\0[²(à±‚-©“ 'í³	™­ª`hu%¢Â,€”¨ãIµ7Ä«±Èó´‚m§VŞ}®ºNÖÍ³\$»E´ÕYf&1ùŠÀ›]]pzUx\rĞ}…·;w§UXû\\«ña^ ËUÂ0SZODšRK”¶&‡Z\\Oq}Æ¾w‡Ìºg¦´I¥èV…ºº	5ªk¸ûç?Ğ={º‹ª…©*ã©k˜@[u¡hÜv´mˆÛa;]—Ûà&àé\"“­/\$\0C¡Ù‚dSg¸k‚ {\0”\n`	ÀÃüC ¢¹Üaçr\rÂ»2G×ŒäèO{§Å[­ÅÊûCƒÊFKZÖj˜©Â’FYBäpFk–›0<ÛàÊD<JE™Zb^µ.“2–ü8éU@*Î5fkªÌFDìÈÉ4‹•DU76É4Qï@·‚K+„ÃöJ®ºÃÂí@Ó=ŒÜWIF\$³85MšNº\$Rô\0ø5¨\ràù_ğªœìEœñÏI«Ï³Nçl£Òåy\\ôˆÇqU€ĞQû ª\n@’¨€ÛÅcpš¬¨PÛ±+7Ô½N\rıR{*qmİF	M}I8 `W\0Á8‚µT\rä*NpTöb¨d<ºË¤Ô8îFğ²€_Ï+Ü»Tî®eN#]˜d;ó,šŠ€~ÀU|0VReõˆÅıˆÖY|,d YÃ<Í²]„ƒûá·—É”=ç±ümÅ›®,\rj\r5à±pÊdu èéˆÔfpÈ+¾Jü–’ºX^ æ\nâ¨Ş)ß>-“h€‚¼¥½<•6èßb¼dmh×â@qíÕAhÖ),J­×W–Çcm÷em]Ô\\÷)1Zb0ßåşYñ]ymŠè‡fØe¸Â;¹ÏêOÉÀWŸapDWûŒÉÜÓzE¤ŒÓ\"ö\$êÇ=kİëå!8úæ€‚g@¢-Q¦/e&ßÆ‡¬v_€xn\rÄe3{UÕ4öÜĞn{Ü:B§ˆâÕsm¶­Y düŞò7}3?*‚túòéÏlTÚ}˜~€„€ä=cı¬ÖŞÇ¹€{íƒ8SµA\$À}ãQ\" Ÿâ;TWè98ç‚Ó{IDqÍúÖÂ÷®Ç˜‚Oì[”&œ]ïØ¤Ìs‘˜€¸-§˜\r6§£qqš h€e5…\0Ò¢À±ú*àbøISÛêÄ†Î®9yıpÓ-øı`{ı±É–kP˜0T<„©Z9â0<Õ™Í©€;[ƒˆg¹\nKÔ\n•\0Á°*½\nb7(À_¸@,îE2\rÀ]”K…*\0Éÿp C\\Ñ¢,0¬^ìMĞ§šº©“@Š;X\r•ğ?\$\r‡j’*öOµ¬BöæP ¿1¹hLK¡¦Ó‘3—/œ´a@|€¦²w¼(pÄÔ0Ûş€»uo	T/b¼“ BÈádkœL8è‡DbÊDöë`ºÉÕª*3Ø…Nêâ¾ÃM	wëkÇzâ·¿¤¶Ì«q¬!Ün÷èäèğ~éÖÏÌÊ´àÂEÍ¦š}QÍm\0ƒ4@;¥Ô&¡@è\"B»Ğ	PÀ m5p¿ª­)Æ„÷@2ÀM‘ğ;¬\rŠàbˆ¤05	 Î\0[²N9”hY…à»ˆŞt1e¯AŒo`ÆX¡gÈUb5ÆXõ6†¼ĞÒhUp€“0&*ŠE¤:Úqt%>²ÃÔYa¡Ö²¯°hb¬b œáÖLÀú8U¾rC£¼[Vá£I¬9DĞ´{ĞŞê]È!ÑaÂœˆ‘=Tú´&B5º¯\0~y¾Uè+²Ö\"ª’hÌHÃTb\".\r­Ì <)‘o¡ğœF°m–¤jb!Ú‡DE¢%ş IñÚ¢øDAm2ki„!„«\"ÂŒ©µN¾wTëÇ€Şu–¿*hò1UdV¬ÜD#)À®Á¾`‹x\\CM=r)Èğ ¾¯80¥ácSD¨ÜŞ•Wˆ”±)\\-€b!¢7ÅùåÏG_ŠÚZÃè2yÈ…qÓ)®}(\$µÈÃ‹t\0‘'†È´pZ,aË˜ 8ÊE¼·Ñ—‹”ã4#ö¾î~RÏŞét¶İ=¬ap~Å€<wU–ÀQ+·Álœ¦RÆÜ{ÑœV€	Õ¸o%Õôa.Yàc}\nÕ3'Z|`À6Ò4HUep¿H1ÀıÇd¡‚\\\\¿ˆìüdo\\iËa³åŞ5‘Ô¬uˆš8íA‚;­Õ€PÑ\"Ç–.ç¼~4œÅü’>ÑéÛÇÚ%—‚¸¹VG'zªA!%\\=AGMƒp}CÜÂ?/XöÏşJˆ“ŠTR(Æ¹‰”±`©Œ#Z6Æt¶iua‚ıu”¾tüÏÒp˜ş‰˜”ö¨O1¸÷#pTa#»<.¨+°« ñ\\I{Ãà`M\nk% ÜIP|GÊ’PA¤˜;Wª»Å ñ5B9%.@I#“Pä:Eà§ä¿\$é+E¬ÇĞ,:Ï|U ‰µk¶“ e0òí2L©9)–`T+\$€l¡ç²U\"+Øİ\0\$\n _èÑ’Ÿ(à‰4DR‚”³'¥1\"h6Ÿ%<*/¥\\É\"ØÉ=y€£F}lªÜÕ#70¸ğE¦m šşéA(ÆTÎG]@ÉÑ®.IKâW’­ÀÑ¥xD¸.ÆV.¤D\\Ü÷*{°AAeÔŒf±ò­3êÏUØœ@Uw.Œ5€ZÄ†S”*<BA#Ó\0O.„•Œá]ÉÁ·™Npi¾ıU)Ás(¥ì’°ëaĞÕagˆ%áÀÄ‚Èyx#¨ê[èeXÄ4« ,ÜHo€8NàIà	 %y- p°ÄT‹¼¨ådw„„[Ï^gxfb§(UÁ©~ˆ¾\0PÙß+Ãƒ'h×AküÏ€ÔúÙŸˆÈ.\"2@•f™…¹„ÅOí>tÑ£\"•¹£âi\0j3‚Xßâˆw!/„å^šòbqøŒ (5*ı\0ZÁ°9ˆ\\¤\rJ@ZAQEÍ‘{àxÛL/»‘| # 	ÜD¹¬Í*kr¼‰ÛQE‚`.\0_€qdäB(Ğ.4Ô%S™läç*ğ—Ne(\nœÔ'4ñ–ˆ`@mxÀÅ:³”Èÿ¡SÌØÅ4‚’¿N4¬sšç'=6 Á€½ƒ8æY;©Ì†s™Pn'€ 9ÍŒs,é&y!å>\0[ÏS(N€Û11\nÌVfÎ ÌÅB‚ğÆ•á%š~E‚3…¤¬H4Œ(Bµ\"”“Œ˜Š s3mê'pİ<±²ƒ ïÓàÔLÔ±pŸäŒÙE‡B€Æ5 ÃëÙË2YÑ§&¥ˆ–‰³”­\"(ørG€XxÉ©€»R¨O0•Jn–a1`Êå‘œgÌn²@(	Œãy%£œKˆc<É•„ª6‘†òö±†dH´;“c.”Ş¡â„KxØï^=Ä+®\0É3ô&ÅDå\rÊ‰C¥ä•;)ä\\bùøÙEÔÔ’*Q–DÔ—åÉğİ–ğt‡Ê{\\–p3ˆTƒñE\0)	%bÄì*ì­¤2‰h{öX‰œÙåŞPµKˆH(ÕÎQ\n e !ÖúFŒÉ“e—aC©B€.Š%©	Ü¡ğC‹Jp¸Şá\$˜€òMáZ2|² )éNéZ\\Z_œÑ)T y\"‰ãÌq+ Yzxb§EU€e\"ÔLZc–½c/=aa©‹L´0ª°kÚ(×ìG5üŸàtß[É])Æúı8œ“•62/„<ÓaM‰­.ÊÌÖŒy,å‹ØYœk\nPC.ÓüvJ6¦2›ƒNÊfSŠœ€]82ıÑ5ó;ÓÎ\0•§	\"*&/êeS¶¢Tğ(ê-NšaCL1t#\"ã#’4Æ¢‘1¹^ò”6DŸ`øÄÈ‘”+ŸÁŠäYFhÉ0ÚFI„\$àğ\\êƒP½Òu0nmY„4bÔ#·¯\"…pÛ#Ì&R8´ì¤Ş2(U\0Çã%şSiúqe3“kB”“¤¦jîgIÒUƒíUŒÊ3ué NBbœa41Ğv‚@dhªaaˆLKx«Õ¼Œ½)¹	©P(«-uºã³JGXà¸\nKÅ/„ÉĞã×Æ\\ÛiÏ™æ\0^À\$, |ZÊ€(Rv*ïÄEbE{ZŠÕHäeş\n™§€PšÉ €”ØuNXb`XTU06œaXP=Q*Î€dt*z+H@°…°ÁIvéZ‡äÀgáqÂI^Rª\0€¸A\n *¼!À8|\$prãëê!WF„°˜ôOBÌ+ßViˆuŠ'èKYz(³)ùedš3\\±“Õ‘	è\nz&ƒ^bß‹J^V%t+‘Ti[Q4&”®ùtÏ\\ŠĞ6´iê\rÕs*¤¼Õ…H¯ø&[W'×ZÅ–'¬øŠ+Bx[	,Â¹«Ø²Å¦µÁqŞÈ8ä¬~3ŠÚ®Ã@'	ği†fş’à.JÊˆT¢ï˜ÜX1-¤Ø€Š&3‘ì6ª—éòĞf@|O`b®UeD\0»:†ÎÖpSjMDÖQt\n¬³‘ñg§ÑèŸaÀy\$s€È`\"Ì5¿ğ²É56V¢| `&´Êöåˆ7ÍÂ:ªr5:àŞË/'màPiw	A\rP‹šG‚X#H˜ıÔY\n¡ÑÎÚ&RÃt{‡f¤éém@8ôx‘c·mú›FD3¤\"–¸ç]u±)laêZ…:#¶Y«KKhWë€^Lİµ‹İm…¦…®Ûp¹6}·­i[ÑW¯ãmÌÛ‹tZ„M°ú·e³(oeñrpÀ[PYÒíà‡“îŒ­ _«ÜÃãoR—1©\"R)ºø’\$Hˆ;»\0“‚€íÁ%Y#‘¨-Ihx¹*É”QRï¤^Z¨â.YÃWœè*çÑLZÇ]jU³¬V›§\\;4z#ğvƒµ:R×ê)«*:·ÁÇŸœõ±iXbs.hqZTºŸ\"„I¡h£å\0Á;§¤û@Zx°–„Iê½èN'ğÓ~—”¡\r‹®¿BB‡’‡Ã’h©†‰YG°£F4)Š¹i%PĞ€ì–õxx\n+°Ã2°5İ¬ßhè‘Ö'­İ‚,¬Á^^9Ì -ğlúÛ·nòƒÔmQßi‚\0®ÓB‰8ğn¾:T1éö1RÄ¢ÑY€¸ÕÉ9à=¬p¯s-“^œf%©q't8Ÿ(ø£š½@ïo’¾Z1–håâP¿?À©+g_U™q	¥ó^~Ç@n³ªÎ¾ †ÕP&–g­šC9|º9_ø–c¿U™¬Ğ›5_şî?İEÛ!Ú'ŞT]¥¯İí—Yëÿ\rE·pNJROÓ€‹î\nS…Üœ®Ÿl›e¹B8ˆ¼ \n}6¹Èà|÷‹ 9 N”ªÇøQ×½èÇ¸I5yQîºDİïœÊ‰ŒÁüuj*?m\\MÓŞ²`İëdˆàU(\$€¦N~UY#}—nÃ@h:«Hı•\rZ'õ@jµªÄ4€2I€®ç÷…Ö¡·é 0h@\\ÔµÉ\0À8P3†B.«0Òa´ìˆJLh\r?K\\¦NxQ0“Ñ#Õ…HŸÃt½¾Œc?¼,«¶‚t0¢;upÀ0d7ş ËäÊ°<a¯iö2s9‰bÂOx¡ıê\0PÜ2áñ@,ÃUÏ\0·[VÆÁèh|BQ Xì5Ò˜_¡‚Ì1Ar8¹ĞìÈr î}‹šNâó—Db¦&Ìë‰Û\"a|?Å0?…Óî£Oq[µ8‚^Kè‘ßáQ”6í[”v˜èÑ•Û¾‡‡×Æ°™n¥	¨4S-R8Íñ³eâªéy—1´ı¶Go¶\ràdñˆö¸ØèIP€6İmÍ³ºØÍ†‹ÄÍĞí×)GÂAK*Œx˜ŒU–ª‚Rma„%Æ£HsEÂ°öÈ9L}œs¶é`6@Qéæg#a•§¾ÂF@B'<rÒÏË“[ğŠE\$i#÷\"Åš,¾7iâã„Ùã ƒt±µR 9äêékÖP²s­÷)Ã·Êº£²³tœ®‡Ç*`gÊ®6—LŒwàœ¹LáË^ißˆPY%Ó%v¡a¥Ô™ ª 2ê˜^»šğch»­,“!w^µØM3WE¹÷²¤Ä=Ü´åúZb\$Ü‚Ì~VàXk¡ĞÆí\0[`­ÁŸIÂÙø€bc0MköéC¾°ÑF9¡†hóJœÓ—¸•µ´¼(K‚XèĞæÅ·©auQ…›qwæé=¹³YƒŸÉ8´s›üÍ|\rŞˆ1›Ä¼\"NíuLs2£ÌÍ¤0xÆÅÀ—T`‚”Bî©v«¥2™Ê9D¾‚€Ş1ó¼Uç`É•/×1:,&ÅÇ™´ô	8ù¥\$€ŒojUŒà9¬\n›ÑŸ•›`6æà#7AÍX-w|ûµFí!Ø¶IŸÉuçø úf€çÿĞ7®¢‹\0?9 OÀø –Í¥Ñ*®J5¡¬ü ”–ğ!Ø·k«’Á¡rN×z|~„3×vƒ~×¥şcÈníh<&m`P4M%ã'G’Ñöfôƒf0Ó—HºÒ>€ª,-€¾ÓZ;ÃÉ\0úÅ¦.#]Äò€…Óå¿—hğÇş]¸BhPÃ‰ *ÍÌµF\r¡´šAHf›A¸ÌBû¢¸<¨eèG3VÆ›\"ŸàµË~7ëyšpòÎOS®fÿA9ÁÔ{u\nóMİZŠËI5X‹P4Lzm¨#mœ`h\"“á\nÓÉà¬Ë4ÇœÌJÖÙ\n9J=1ê‰zöMÈå-A’-`\"ÃXRrG´dMXcÇÚ(Õ˜BÙœ+[Â‰Ø€)È\n„éŠ|‡p¤âwœŠ€¡Ckt®\n |~\0zå§¯>à†æX)	€v…ÀßÕàš5‚Ö°û[Ê.óƒ™¹)I?áÿ—r[¸ìº|òX3!>\r¯Pã5Ç	âğÄ\roüá¦òÉ½„uªX))Ü‹n^\nÚëÈW“ünïcğìWc€şMíÓµ yoÇÃ.ê©’q5JsKVWV¹H#îÎ»vœ‡+ P&¥rÀ~G»\r†px(ôÃ9<„ß<&A2Yµ9½¿Æs-ÿÀ&ôÔG´íT™ \"ÎÓ‘yd“YeÖpå5|=µ§\$ÚÏNeøÀ¦W0;ºïáMOHÉ&39ú\$†@µan.|+bfx‰Ò1C‹iõ§Â——ã¥H¯´¾À™ÚÂĞäR‚ëKm8P.¡Ç%”Z\0^  9¬ |­CXlHëÌÄ”z\\¥24n+¹ÕØ¸°¤ôªÜ¹î÷F]ÒèÌ‡ŠF°Õ¸Ù\0™wÇ5)ğ¹fşîcy{À0ÀP4ĞÅİ5¡·zaÆ¼ÔÉ)_ÊQY3É&‚Ãnİ›ê,åØÀK¦ù_öY‡W0YÃÓ.s•-i=²÷eÙ,u@|Uvt!#ã¤ôÎ´ÅÊ×^à¤ç«&İÑèdSÖ€³0­8İ¤€g.ŞoG@\\(Ëc t\rÍXG¤Ö•Ìƒµ×TÚFàem© :‘DÚÊÖ9)`EYk™MkÖÁ\$ÈŠONÓ‚JÁæe£7’8yáM•nâZ*|ê‡r†	DÀZB[Ò¡@T!Ç\0Â00L˜£û|,•Èöwß¾f\\&»‰eâmj®œ&/	Ù‹ŸÉóªÕBÂÕ¥|rI¦Öbx‚QD€ÆwJ«|·Œ”½÷M–`ß‹-5t™4æXüw¼WÛÏOÓÅ½ññu’ü_>	xÆ+^2Ê5#³ôÂ›-÷’„â'‚»åfùÈ©å¥¥-bŠKjQ;‡&>’3Åâ²»'jtYqŞ§²+Jv\"j–t~_â—ÍEåBORÔ¾¡0)Æp¹29IB¯Ûôe¿\"I;Û©X¬\$,p0ô_KáÅÌ\$Ä‹Úv°›,?1‡½Õ‹<LD;rJ;¦lg.ËÇ~;ìUW¢°•vËİÏŒ0P+g0Ôır+IAA*º\0|àØS¨o €\\„S½5ÜuÛÚ'(›ÓÅ|¸Àæà„ÀWĞÀ5;\$5\0´ô{¹®;dóiÈtÄ‘ñ ò‘â:™)½Èº)†.‹;—£j%\rÁ—ÌF¶=ïœDä¤õ]HŞ“ƒ\0ˆ	 N @°!à’+|²d!.úH|ÆM»ÆCOUŒwI…Rü|”H°R‘TÆ@%<œÂnßŸÏn7r‡õ]c#;‰¯\"f½AÚ9Ê¾dñğ',††'U•ËK‘r^ÕÁŞ_:Ry±O~m!Û¥˜j>²S°ñ\"[ùq²§Ü½ëœ‹Ë\\˜8Ms\0üİ7›ç_¹UÌV´f6‡KÉDÏ—Æs4S¬­P_=\"A«ˆ,&G³=‰êşXÁ9IØ`o#IFÂëSAíÖËAà;4kYÂN@”à<@gu|It\rÏû.ÖR9Ê:¿¸ğyîK­ ùÜÂ“¹Àyî*Eó`r’Y·÷¦	š\${ä6Ğ\0®â½òïhLÑ3ŞûŠ·€\" _\$U×È_“(¢GÀC0ğ(Õ•ˆÖ1F÷ÂMzÍÈüà{¥Q!\r…ƒNöxCsaÚ5Ğ¨ŠOz	M·ğªÙGª`Qé4õÚÀ×“IIâJa6ç›€àT`(½MáßJ\\WÇ‚Øñ÷Ejuû8§ó ¾B†ÜÑQ[Ë?Öü_%+“O”+|šÀ˜ê w(e¡‡¼€…\\Uöû»ŞƒU¼ZÙ4Í\n P @¨P<Èš4šC €æÌ.K!˜éÇM#oSY3«LùºÿBˆ\$€0{§Ht¼Ñ)Jp\$\rJËy\"äò€;¿¥ª@,ú_ŒZò€È\$åçÑØ‡Ğ°`ÜT ÕçcƒS%¸C(+oOá²Ò@\0^kX•ª@|¡Í‡¯U@¡ùú(h®Bé>³œVnÍ\$H€2‰(ßAúLŒma¾hÃ†ÔI‡ÄŠ™Kiü:ê'¢éE—ÈV“C¡EE5îaFû¤§b¦´H°dA| ²í‚\"‰ÇŠBº,öûXÎJvN¿ğyJ”å×À@íÔâld ±WõëÆ+&wÄ]\0Ä¡odá ¾ïKÔy€.ÈˆHÌ‰ÃûUCpLaÁ”/ñ\rK¡ãÖÀtøÓõÀĞ8cİi”¨oÌÀSñÏ„Èóæ`=ù˜E\0;Ê|'½llcTHUé?Psß=øÏÑÇbª™À«æß8	\rÖ¾fß…Ãçïíù~²Kë¬ı[é>ß8MlFğšéá»ÕøæÑ…ñ¿´€Ÿé<È×Ü©^ğkí@×¸Åõğ/uÛä .ügÉ+±ò`ß%€lœ2\nĞ[v«üiS¿‡ù]}IñAØzü*üßÙ~%ê_c|ª€ÿ-Q7Û:Ò³«€Éª_;ñ©b®½g}´1?p>WÜ€íõº`=úØ”5iùŸÛ~ß?{ïî~„‹¡[|ÌEş_Õÿ÷UNÿ]?7pt?22?ØÿTrÎ€©©åTñ…´]?fúô¾õõõ,wû‰üßûÑº 2‰yı:P.Tµ1GÚÿ‹Ö*“½hb ¸€?âßQ ô·Ò ¨?ìW½rõ\0¯b‡`*”à:=v hv\0¸¿âõ’¢åı%L:V(½Pø8wD—1è³a\0Ğo­ª¾p4‚D&”¥è@€a¹5€ÀmÀP…ÀZşÚ’Eû½ü]wI^)Q¬Àw¸(#-»Æu#¼§Z…È*0“L¿¨ødÛğGÀ5Tõ@p/§Ââbˆ:ú\"|01\0ÌÈ`À°ĞÚbï:P„—¼ÿÉ'!ˆ€Ä„\r \0fxÊÊí4\0ß‘€†€àH[,p<öƒMU¦àT°/a\rLCÁbEš¸\\µAçBV€öŞ»MF/­Ä™ñ‹v\n<ÃMB&DOø»ƒfÔÍù,:M\rU4ĞãMxF}`Ò‰ô#0š}€ğ€¶ÓB²o0åƒ&« Ná©p‚:Á~áÇ\rÀM¦| NˆR¢\n\"	#'@Áb‘ãû Pq€Ç½J\\‚<•:h!pG€ù‹dd\n˜@jmæ•´øpˆ1ˆPXÁá`#/|ŸÌ¤ïº¾‡Ò\"ĞncÓD]ÁÂû8r6ğ{5ä~ğ\r\0AĞ„De…q\\o‰B!™[òŸÎá0BD“¤“É3°Tˆ/0B‰rèàĞI²P ©;¤òeàP“MÁ‹Ã¡ˆ€ã#ÀÂpÓZ?Èñ·`pW·Ğá\0`Ê\0");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0œF£©ÌĞ==˜ÎFS	ĞÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xğ¸?Ä'ƒi°SANN‘ùğxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\n?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYÌèy6GFmY8o7\n\r³0¤÷\0DbcÓ!¾Q7Ğ¨d8‹Áì~‘¬N)ùEĞ³`ôNsßğ`ÆS)ĞOé—·ç/º<xÆ9o»ÔåµÁì3n«®2»!r¼:;ã+Â9ˆCÈ¨®‰Ã\n<ñ`Èó¯bè\\š?`†4\r#`È<¯BeãB#¤N Üã\r.D`¬«jê4ÿpéar°øã¢º÷>ò8Ó\$Éc ¾1Écœ ¡c êİê{n7ÀÃ¡ƒAğNÊRLi\r1À¾ø!£(æjÂ´®+Âê62ÀXÊ8+Êâàä.\rÍÎôƒÎ!x¼åƒhù'ãâˆ6Sğ\0RïÔôñOÒ\n¼…1(W0…ãœÇ7qœë:NÃE:68n+äÕ´5_(®s \rã”ê‰/m6PÔ@ÃEQàÄ9\n¨V-‹Áó\"¦.:åJÏ8weÎq½|Ø‡³XĞ]µİY XÁeåzWâü 7âûZ1íhQfÙãu£jÑ4Z{p\\AUËJ<õ†káÁ@¼ÉÃà@„}&„ˆL7U°wuYhÔ2¸È@ûu  Pà7ËA†hèÌò°Ş3Ã›êçXEÍ…Zˆ]­lá@MplvÂ)æ ÁÁHW‘‘Ôy>Y-øYŸè/«›ªÁî hC [*‹ûFã­#~†!Ğ`ô\r#0PïCË—f ·¶¡îÃ\\î›¶‡É^Ã%B<\\½fˆŞ±ÅáĞİã&/¦O‚ğL\\jF¨jZ£1«\\:Æ´>N¹¯XaFÃAÀ³²ğÃØÍf…h{\"s\n×64‡ÜøÒ…¼?Ä8Ü^p\"ë°ñÈ¸\\Úe(¸PƒNµìq[g¸Árÿ&Â}PhÊà¡ÀWÙí*Şír_sËP‡hà¼àĞ\nÛËÃomõ¿¥Ãê—Ó#§¡.Á\0@épdW ²\$Òº°QÛ½Tl0† ¾ÃHdHë)š‡ÛÙÀ)PÓÜØHgàıUş„ªBèe\r†t:‡Õ\0)\"Åtô,´œ’ÛÇ[(DøO\nR8!†Æ¬ÖšğÜlAüV…¨4 hà£Sq<à@}ÃëÊgK±]®àè]â=90°'€åâøwA<‚ƒĞÑaÁ~€òWšæƒD|A´††2ÓXÙU2àéyÅŠŠ=¡p)«\0P	˜s€µn…3îr„f\0¢F…·ºvÒÌG®ÁI@é%¤”Ÿ+Àö_I`¶ÌôÅ\r.ƒ N²ºËKI…[”Ê–SJò©¾aUf›Szûƒ«M§ô„%¬·\"Q|9€¨Bc§aÁq\0©8Ÿ#Ò<a„³:z1Ufª·>îZ¹l‰‰¹ÓÀe5#U@iUGÂ‚™©n¨%Ò°s¦„Ë;gxL´pPš?BçŒÊQ\\—b„ÿé¾’Q„=7:¸¯İ¡Qº\r:ƒtì¥:y(Å ×\nÛd)¹ĞÒ\nÁX; ‹ìêCaA¬\ráİñŸP¨GHù!¡ ¢@È9\n\nAl~H úªV\nsªÉÕ«Æ¯ÕbBr£ªö„’­²ßû3ƒ\rP¿%¢Ñ„\r}b/‰Î‘\$“5§PëCä\"wÌB_çÉUÕgAtë¤ô…å¤…é^QÄåUÉÄÖj™Áí Bvhì¡„4‡)¹ã+ª)<–j^<Lóà4U* õBg ëĞæè*nÊ–è-ÿÜõÓ	9O\$´‰Ø·zyM™3„\\9Üè˜.oŠ¶šÌë¸E(iåàœÄÓ7	tßšé-&¢\nj!\rÀyœyàD1gğÒö]«ÜyRÔ7\"ğæ§·ƒˆ~ÀíàÜ)TZ0E9MåYZtXe!İf†@ç{È¬yl	8‡;¦ƒR{„ë8‡Ä®ÁeØ+ULñ'‚F²1ıøæ8PE5-	Ğ_!Ô7…ó [2‰JËÁ;‡HR²éÇ¹€8pç—²İ‡@™£0,Õ®psK0\r¿4”¢\$sJ¾Ã4ÉDZ©ÕI¢™'\$cL”R–MpY&ü½Íiçz3GÍzÒšJ%ÁÌPÜ-„[É/xç³T¾{p¶§z‹CÖvµ¥Ó:ƒV'\\–’KJa¨ÃMƒ&º°£Ó¾\"à²eo^Q+h^âĞiTğ1ªORäl«,5[İ˜\$¹·)¬ôjLÆU`£SË`Z^ğ|€‡r½=Ğ÷nç™»–˜TU	1Hyk›Çt+\0váD¿\r	<œàÆ™ìñjG”­tÆ*3%k›YÜ²T*İ|\"CŠülhE§(È\rÃ8r‡×{Üñ0å²×şÙDÜ_Œ‡.6Ğ¸è;ãü‡„rBjƒO'Ûœ¥¥Ï>\$¤Ô`^6™Ì9‘#¸¨§æ4Xş¥mh8:êûc‹ş0ø×;Ø/Ô‰·¿¹Ø;ä\\'( î„tú'+™òı¯Ì·°^]­±NÑv¹ç#Ç,ëvğ×ÃOÏiÏ–©>·Ş<SïA\\€\\îµü!Ø3*tl`÷u\0p'è7…Pà9·bsœ{Àv®{·ü7ˆ\"{ÛÆrîaÖ(¿^æ¼İE÷úÿë¹gÒÜ/¡øUÄ9g¶î÷/ÈÔ`Ä\nL\n)À†‚(Aúağ\" çØ	Á&„PøÂ@O\nå¸«0†(M&©FJ'Ú! …0Š<ïHëîÂçÆù¥*Ì|ìÆ*çOZím*n/bî/ö®Ôˆ¹.ìâ©o\0ÎÊdnÎ)ùi:RÎëP2êmµ\0/vìOX÷ğøFÊ³ÏˆîŒè®\"ñ®êöî¸÷0õ0ö‚¬©í0bËĞgjğğ\$ñné0}°	î@ø=MÆ‚0nîPŸ/pæotì€÷°¨ğ.ÌÌ½g\0Ğ)o—\n0È÷‰\rF¶é€ b¾i¶Ão}\n°Ì¯…	NQ°'ğxòFaĞJîÎôLõéğĞàÆ\rÀÍ\r€Öö‘0Åñ'ğ¬Éd	oepİ°4DĞÜÊ¦q(~ÀÌ ê\r‚E°ÛprùQVFHœl£‚Kj¦¿äN&­j!ÍH`‚_bh\r1 ºn!ÍÉ­z™°¡ğ¥Í\\«¬\rŠíŠÃ`V_kÚÃ\"\\×‚'Vˆ«\0Ê¾`ACúÀ±Ï…¦VÆ`\r%¢’ÂÅì¦\rñâƒ‚k@NÀ°üBñíš™¯ ·!È\n’\0Z™6°\$d Œ,%à%laíH×\n‹#¢S\$!\$@¶İ2±„I\$r€{!±°J‡2HàZM\\ÉÇhb,‡'||cj~gĞr…`¼Ä¼º\$ºÄÂ+êA1ğœE€ÇÀÙ <ÊL¨Ñ\$âY%-FDªŠd€Lç„³ ª\n@’bVfè¾;2_(ëôLÄĞ¿Â²<%@Úœ,\"êdÄÀN‚erô\0æƒ`Ä¤Z€¾4Å'ld9-ò#`äóÅ–…à¶Öãj6ëÆ£ãv ¶àNÕÍf Ö@Ü†“&’B\$å¶(ğZ&„ßó278I à¿àP\rk\\§—2`¶\rdLb@Eöƒ2`P( B'ã€¶€º0²& ô{Â•“§:®ªdBå1ò^Ø‰*\r\0c<K|İ5sZ¾`ºÀÀO3ê5=@å5ÀC>@ÂW*	=\0N<g¿6s67Sm7u?	{<&LÂ.3~DÄê\rÅš¯x¹í),rîinÅ/ åO\0o{0kÎ]3>m‹”1\0”I@Ô9T34+Ô™@e”GFMCÉ\rE3ËEtm!Û#1ÁD @‚H(‘Ón ÃÆ<g,V`R]@úÂÇÉ3Cr7s~ÅGIói@\0vÂÓ5\rVß'¬ ¤ Î£PÀÔ\râ\$<bĞ%(‡Ddƒ‹PWÄîĞÌbØfO æx\0è} Üâ”lb &‰vj4µLS¼¨Ö´Ô¶5&dsF Mó4ÌÓ\".HËM0ó1uL³\"ÂÂ/J`ò{Çş§€ÊxÇYu*\"U.I53Q­3Qô»J„”g ’5…sàú&jÑŒ’Õu‚Ù­ĞªGQMTmGBƒtl-cù*±ş\rŠ«Z7Ôõó*hs/RUV·ğôªBŸNËˆ¸ÃóãêÔŠài¨Lk÷.©´Ätì é¾©…rYi”Õé-Sµƒ3Í\\šTëOM^­G>‘ZQjÔ‡™\"¤¬i”ÖMsSãS\$Ib	f²âÑuæ¦´™å:êSB|i¢ YÂ¦ƒà8	vÊ#é”Dª4`‡†.€Ë^óHÅM‰_Õ¼ŠuÀ™UÊz`ZJ	eçºİ@Ceíëa‰\"mób„6Ô¯JRÂÖ‘T?Ô£XMZÜÍĞ†ÍòpèÒ¶ªQv¯jÿjV¶{¶¼ÅCœ\rµÕ7‰TÊª úí5{Pö¿]’\rÓ?QàAAÀè‹’Í2ñ¾ “V)Ji£Ü-N99f–l JmÍò;u¨@‚<FşÑ ¾e†j€ÒÄ¦I‰<+CW@ğçÀ¿Z‘lÑ1É<2ÅiFı7`KG˜~L&+NàYtWHé£‘w	Ö•ƒòl€Òs'gÉãq+Lézbiz«ÆÊÅ¢Ğ.ĞŠÇzW²Ç ùzd•W¦Û÷¹(y)vİE4,\0Ô\"d¢¤\$Bã{²!)1U†5bp#Å}m=×È@ˆwÄ	P\0ä\rì¢·‘€`O|ëÆö	œÉüÅõûYôæJÕ‚öE×ÙOu_§\n`F`È}MÂ.#1á‚¬fì*´Õ¡µ§  ¿zàucû€—³ xfÓ8kZR¯s2Ê‚-†’§Z2­+Ê·¯(åsUõcDòÑ·Êì˜İX!àÍuø&-vPĞØ±\0'LïŒX øLÃ¹Œˆo	İô>¸ÕÓ\r@ÙPõ\rxF×üE€ÌÈ­ï%Àãì®ü=5NÖœƒ¸?„7ùNËÃ…©wŠ`ØhX«98 Ìø¯q¬£zãÏd%6Ì‚tÍ/…•˜ä¬ëLúÍl¾Ê,ÜKa•N~ÏÀÛìú,ÿ'íÇ€M\rf9£w˜!x÷x[ˆÏ‘ØG’8;„xA˜ù-IÌ&5\$–D\$ö¼³%…ØxÑ¬Á”ÈÂ´ÀÂŒ]›¤õ‡&o‰-39ÖLù½zü§y6¹;u¹zZ èÑ8ÿ_•Éx\0D?šX7†™«’y±OY.#3Ÿ8 ™Ç€˜e”Q¨=Ø€*˜™GŒwm ³Ú„Y‘ù ÀÚ]YOY¨F¨íšÙ)„z#\$eŠš)†/Œz?£z;™—Ù¬^ÛúFÒZg¤ù• Ì÷¥™§ƒš`^Úe¡­¦º#§“Øñ”©ú?œ¸e£€M£Ú3uÌåƒ0¹>Ê\"?Ÿö@×—Xv•\"ç”Œ¹¬¦*Ô¢\r6v~‡ÃOV~&×¨^gü šÄ‘Ù‡'Î€f6:-Z~¹šO6;zx²;&!Û+{9M³Ù³d¬ \r,9Öí°ä·WÂÆİ­:ê\rúÙœùã@ç‚+¢·]œÌ-[g™Û‡[s¶[iÙiÈq››y›éxé+“|7Í{7Ë|w³}„¢›£E–ûW°€Wk¸|JØ¶å‰xmˆ¸q xwyjŸ»˜#³˜e¼ø(²©‰¸ÀßÃ¾™†ò³ {èßÚ y“ »M»¸´@«æÉ‚“°Y(gÍš-ÿ©º©äí¡š¡ØJ(¥ü@ó…;…yÂ#S¼‡µY„Èp@Ï%èsúoŸ9;°ê¿ôõ¤¹+¯Ú	¥;«ÁúˆZNÙ¯Âº§„š k¼V§·u‰[ñ¼x…|q’¤ON?€ÉÕ	…`uœ¡6|­|X¹¤­—Ø³|Oìx!ë:¨œÏ—Y]–¬¹™c•¬À\r¹hÍ9nÎÁ¬¬ë€Ï8'—ù‚êà Æ\rS.1¿¢USÈ¸…¼X‰É+ËÉz]ÉµÊ¤?œ©ÊÀCË\r×Ë\\º­¹ø\$Ï`ùÌ)UÌ|Ë¤|Ñ¨x'ÕœØÌäÊ<àÌ™eÎ|êÍ³ç—â’Ìé—LïÏİMÎy€(Û§ĞlĞº¤O]{Ñ¾×FD®ÕÙ}¡yu‹ÑÄ’ß,XL\\ÆxÆÈ;U×ÉWt€vŸÄ\\OxWJ9È’×R5·WiMi[‡Kˆ€f(\0æ¾dÄšÒè¿©´\rìMÄáÈÙ7¿;ÈÃÆóÒñçÓ6‰KÊ¦Iª\rÄÜÃxv\r²V3ÕÛßÉ±.ÌàRùÂşÉá|Ÿá¾^2‰^0ß¾\$ QÍä[ã¿D÷áÜ£å>1'^X~t1\"6Lş›+ş¾Aàeá“æŞåI‘ç~Ÿåâ³â³@ßÕ­õpM>Óm<´ÒSKÊç-HÉÀ¼T76ÙSMfg¨=»ÅGPÊ°›PÖ\r¸é>Íö¾¡¥2Sb\$•C[Ø×ï(Ä)Ş%Q#G`uğ°ÇGwp\rkŞKe—zhjÓ“zi(ôèrO«óÄŞÓşØT=·7³òî~ÿ4\"ef›~íd™ôíVÿZ‰š÷U•-ëb'VµJ¹Z7ÛöÂ)T‘£8.<¿RMÿ\$‰ôÛØ'ßbyï\n5øƒİõ_àwñÎ°íUğ’`eiŞ¿J”b©gğuSÍë?Íå`öáì+¾Ïï Mïgè7`ùïí\0¢_Ô-ûŸõ_÷–?õF°\0“õ¸X‚å´’[²¯Jœ8&~D#Áö{P•Øô4Ü—½ù\"›\0ÌÀ€‹ı§ı@Ò“–¥\0F ?* ^ñï¹å¯wëĞ:ğ¾uàÏ3xKÍ^ów“¼¨ß¯‰y[Ô(æ–µ#¦/zr_”g·æ?¾\0?€1wMR&M¿†ù?¬St€T]İ´Gõ:I·à¢÷ˆ)‡©Bïˆ‹ vô§’½1ç<ôtÈâ6½:W{ÀŠôx:=Èî‘ƒŒŞšóø:Â!!\0x›Õ˜£÷q&áè0}z\"]ÄŞo•z¥™ÒjÃw×ßÊÚÁ6¸ÒJ¢PÛ[\\ }ûª`S™\0à¤qHMë/7B’€P°ÂÄ]FTã•8S5±/IÑ\rŒ\n îO¯0aQ\n >Ã2­j…;=Ú¬ÛdA=­p£VL)Xõ\nÂ¦`e\$˜TÆ¦QJÍó®ælJïŠÔîÑy„IŞ	ä:ƒÑÄÄBùbPÀ†ûZÍ¸n«ª°ÕU;>_Ñ\n	¾õëĞÌ`–ÔuMòŒ‚‚ÂÖm³ÕóÂLwúB\0\\b8¢MÜ[z‘&©1ı\0ô	¡\r˜TÖ×› €+\\»3ÀPlb4-)%Wd#\nÈårŞåMX\"Ï¡ä(Ei11(b`@fÒ´­ƒSÒóˆjåD†bf£}€rï¾‘ıD‘R1…´bÓ˜AÛïIy\"µWvàÁgC¸IÄJ8z\"P\\i¥\\m~ZR¹¢vî1ZB5IŠÃi@x”†·°-‰uM\njKÕU°h\$o—ˆJÏ¤!ÈL\"#p7\0´ P€\0ŠD÷\$	 GK4eÔĞ\$\nGä?ù3£EAJF4àIp\0«×F4±²<f@ %q¸<kãw€	àLOp\0‰xÓÇ(	€G>ğ@¡ØçÆÆ9\0TÀˆ˜ìGB7 - €øâG:<Q™ #Ã¨ÓÇ´û1Ï&tz£á0*J=à'‹J>ØßÇ8q¡Ğ¥ªà	€OÀ¢XôF´àQ,ÀÊĞ\"9‘®pä*ğ66A'ı,y€IF€Rˆ³TˆÏı\"”÷HÀR‚!´j#kyFÀ™àe‘¬z£ëéÈğG\0p£‰aJ`C÷iù@œT÷|\n€Ix£K\"­´*¨Tk\$c³òÆ”aAh€“! \"úE\0OdÄSxò\0T	ö\0‚à!FÜ\n’U“|™#S&		IvL\"”“…ä\$hĞÈŞEAïN\$—%%ù/\nP†1š“²{¤ï) <‡ğ L å-R1¤â6‘¶’<@O*\0J@q¹‘Ôª#É@Çµ0\$tƒ|’]ã`»¡ÄŠA]èÍìPá‘€˜CÀp\\pÒ¤\0™ÒÅ7°ÄÖ@9©bmˆr¶oÛC+Ù]¥JrÔfü¶\rì)d¤’Ñœ­^hßI\\Î. g–Ê>¥Í×8ŒŞÀ'–HÀf™rJÒ[rçoã¥¯.¹v„½ï#„#yR·+©yËÖ^òù›†F\0á±™]!É•ÒŞ”++Ù_Ë,©\0<@€M-¤2WòâÙR,c•Œœe2Ä*@\0êP €Âc°a0Ç\\PÁŠˆO ø`I_2Qs\$´w£¿=:Îz\0)Ì`ÌhŠÂ–Áƒˆç¢\nJ@@Ê«–\0šø 6qT¯å‡4J%•N-ºm¤Äåã.É‹%*cnäËNç6\"\rÍ‘¸òè—ûŠfÒAµÁ„põMÛ€I7\0™MÈ>lO›4ÅS	7™cÍì€\"ìß§\0å“6îps…–Äİåy.´ã	ò¦ñRKğ•PAo1FÂtIÄb*ÉÁ<‡©ı@¾7ĞË‚p,ï0NÅ÷: ¨N²m ,xO%è!‚Úv³¨˜ gz(ĞM´óÀIÃà	à~yËö›h\0U:éØOZyA8<2§²ğ¸ÊusŞ~lòÆÎEğ˜O”0±Ÿ0]'…>¡İÉŒ:ÜêÅ;°/€ÂwÒôäì'~3GÎ–~Ó­äş§c.	ş„òvT\0cØt'Ó;P²\$À\$ø€‚Ğ-‚s³òe|º!•@dĞObwÓæc¢õ'Ó@`P\"xôµèÀ0O™5´/|ãU{:b©R\"û0…Ñˆk˜Ğâ`BD\nk€Pãc©á4ä^ p6S`Ü\$ëf;Î7µ?lsÅÀß†gDÊ'4Xja	A‡…E%™	86b¡:qr\r±]C8ÊcÀF\n'ÑŒf_9Ã%(¦š*”~ŠãiSèÛÉ@(85 T”Ë[ş†JÚ4I…l=°QÜ\$dÀ®hä@D	-Ù!ü_]ÉÚH–ÆŠ”k6:·Úò\\M-ÌØğò£\r‘FJ>\n.‘”qeGú5QZ´†‹' É¢½Û0ŸîzP–à#Å¤øöÖéràÒít½’ÒÏËşŠ<QˆT¸£3D\\¹„ÄÓpOE¦%)77–Wt[ºô@¼›š\$F)½5qG0«-ÑW´v¢`è°*)RrÕ¨=9qE*K\$g	‚íA!åPjBT:—Kû§!×÷H“ R0?„6¤yA)B@:Q„8B+J5U]`„Ò¬€:£ğå*%Ip9ŒÌ€ÿ`KcQúQ.B”±Ltbª–yJñEê›Té¥õ7•ÎöAmÓä¢•Ku:ğSji— 5.q%LiFºšTr¦Ài©ÕKˆÒ¨z—55T%U•‰UÚIÕ‚¦µÕY\"\nSÕm†ÑÄx¨½Ch÷NZ¶UZ”Ä( Bêô\$YËV²ã€u@è”»’¯¢ª|	‚\$\0ÿ\0 oZw2Ò€x2‘ûk\$Á*I6IÒn• •¡ƒI,€ÆQU4ü\n„¢).øQôÖaIá]™À èLâh\"øf¢ÓŠ>˜:Z¥>L¡`n˜Ø¶Õì7”VLZu”…e¨ëXúè†ºB¿¬¥B‰º’¡Z`;®ø•J‡]òÑ€äS8¼«f \nÚ¶ˆ#\$ùjM(¹‘Ş¡”„¬a­Gí§Ì+Aı!èxL/\0)	Cö\nñW@é4€ºáÛ©• ŠÔRZƒ®â =˜Çî8“`²8~â†hÀìP °\r–	°ìD-FyX°+Êf°QSj+Xó|•È9-’øs¬xØü†ê+‰VÉcbpì¿”o6HĞq °³ªÈ@.€˜l 8g½YMŸÖWMPÀªU¡·YLß3PaèH2Ğ9©„:¶a²`¬Æd\0à&ê²YìŞY0Ù˜¡¶SŒ-—’%;/‡TİBS³PÔ%fØÚı• @ßFí¬(´Ö*Ñq +[ƒZ:ÒQY\0Ş´ëJUYÖ“/ı¦†pkzÈˆò€,´ğª‡ƒjÚê€¥W°×´e©JµFèıVBIµ\r£ÆpF›NÙ‚Ö¶™*Õ¨Í3kÚ0§D€{™Ôø`q™•Ò²Bqµe¥D‰cÚÚÔVÃE©‚¬nñ×äFG E›>jîèĞú0g´a|¡Shì7uÂİ„\$•†ì;aô—7&¡ë°R[WX„ÊØ(qÖ#Œ¬P¹Æä×–İc8!°H¸àØVX§Ä­jøÊZô‘¡¥°Q,DUaQ±X0‘ÕÕ¨ÀİËGbÁÜlŠBŠt9-oZü”L÷£¥Â­åpË‡‘x6&¯¯MyÔÏsÒ¿–èğ\"ÕÍ€èR‚IWU`c÷°à}l<|Â~Äw\"·ğvI%r+‹Rà¶\n\\ØùÃÑ][‹Ñ6&Á¸İÈ­Ãa”ÓºìÅj¹(Ú“ğTÑ“À·C'Š…´ '%de,È\n–FCÅÑe9C¹NäĞ‚-6”UeÈµŒıCX¶ĞV±ƒ¹ıÜ+ÔR+ºØ”Ë•3BÜÚŒJğ¢è™œ±æT2 ]ì\0PèaÇt29Ï×(i‹#€aÆ®1\"S…:ö· ˆÖoF)kÙfôòÄĞª\0ÎÓ¿şÕ,ËÕwêƒJ@ìÖVò„µéq.e}KmZúÛïå¹XnZ{G-»÷ÕZQº¯Ç}‘Å×¶û6É¸ğµÄ_ØÕ‰à\nÖ@7ß` Õï‹˜C\0]_ ©Êµù¬«ï»}ûGÁWW: fCYk+éÚbÛ¶·¦µ2S,	Ú‹Ş9™\0ï¯+şWÄZ!¯eş°2ûôà›—í²k.OcƒÖ(vÌ®8œDeG`Û‡ÂŒöL±õ“,ƒdË\"CÊÈÖB-”Ä°(ş„„„p÷íÓp±=àÙü¶!ık’ØÒÄ¼ï}(ıÑÊB–kr_Rî—Ü¼0Œ8a%Û˜L	\0é†Àñ‰b¥²šñÅş@×\"ÑÏr,µ0TÛrV>ˆ…ÚÈQŸĞ\"•rŞ÷P‰&3báP²æ- x‚Ò±uW~\"ÿ*èˆŒNâh—%7²µşK¡Y€€^A÷®úÊC‚èş»p£áîˆ\0ğ..`cÅæ+ÏŠâGJ£¤¸H¿À®E‚…¤¾l@|I#AcâÿD…|+<[c2Ü+*WS<ˆràãg¸ÛÅ}‰Š>iİ€!`f8ñ€(c¦èÉQı=fñ\nç2Ñc£h4–+q8\na·RãBÜ|°R“×ê¿İmµŠ\\qÚõgXÀ –Ï0äXä«`nîF€îìŒO pÈîHòCƒ”jd¡fµßEuDV˜bJÉ¦¿å:±ï€\\¤!mÉ±?,TIa˜†ØaT.L€]“,JŒ?™?Ï”FMct!aÙ§RêF„Gğ!¹Aõ“»rrŒ-pXŸ·\r»òC^À7áğ&ãRé\0ÎÑf²*àA\nõÕ›Háã¤yîY=Çúè…l€<‡¹AÄ_¹è	+‘ÎtAú\0B•<Ay…(fy‹1Îc§O;pèÅá¦`ç’4Ğ¡Mìà*œîf†ê 5fvy {?©àË:yøÑ^câÍuœ'‡™€8\0±¼Ó±?«ŠgšÓ‡ 8BÎ&p9ÖO\"zÇõrs–0ºæB‘!uÍ3™f{×\0£:Á\n@\0ÜÀ£pÙÆ6şv.;àú©„Êb«Æ«:J>Ë‚‰é-ÃBÏhkR`-ÜñÎğawæxEj©…÷Ár8¸\0\\Áïô€\\¸Uhm› ı(mÕH3Ì´í§S™“Áæq\0ùŸNVh³Hy	—»5ãMÍe\\g½\nçIP:Sj¦Û¡Ù¶è<¯Ñxó&ŒLÚ¿;nfÍ¶cóq›¦\$fğ&lïÍşi³…œàç0%yÎ¾tì/¹÷gUÌ³¬dï\0e:ÃÌhïZ	Ğ^ƒ@ç ı1€Ïm#ÑNów@ŒßOğğzGÎ\$ò¨¦m6é6}ÙÒÒ‹šX'¥I×i\\QºY€¸4k-.è:yzÑÈİH¿¦]ææxåGÏÖ3ü¿M\0€£@z7¢„³6¦-DO34Ş‹\0ÎšÄùÎ°t\"Î\"vC\"JfÏRÊÔúku3™MÎæ~ú¤Ó5V à„j/3úƒÓ@gG›}Dé¾ºBÓNq´Ù=]\$é¿I‡õÓ”3¨x=_j‹XÙ¨fk(C]^jÙMÁÍF«ÕÕ¡ŒàÏ£CzÈÒVœÁ=]&\r´A<	æµÂÀÜãç6ÙÔ®¶×´İ`jk7:gÍî‘4Õ®áë“YZqÖftu|hÈZÒÒ6µ­iã€°0 ?éõéª­{-7_:°×ŞtÑ¯íck‹`YÍØ&“´éIõlP`:íô j­{hì=Ğf	àÃ[by¢Ê€oĞ‹B°RS—€¼B6°À^@'4æø1UÛDq}ìÃNÚ(Xô6j}¬cà{@8ãòğ,À	ÏPFCàğ‰Bà\$mv˜¨Pæ\"ºÛLöÕCS³]›İàEÙŞÏlU†Ñfíwh{o(—ä)è\0@*a1GÄ ( D4-cØóP8£N|R›†âVM¸°×n8G`e}„!}¥€Çp»‡Üòı@_¸ÍÑnCtÂ9Ñ\0]»u±î¯s»Šİ~èr§»#Cn p;·%‹>wu¸ŞnÃwû¤İê.âà[ÇİhT÷{¸İå€¼	ç¨Ë‡·JğÔÆ—iJÊ6æ€O¾=¡€‡ûæßE”÷Ù´‘ImÛïÚV'É¿@â&‚{ª‘›òö¯µ;íop;^–Ø6Å¶@2ç¯lûÔŞNï·ºMÉ¿r€_Ü°ËÃ´` ì( yß6ç7‘¹ıëîÇ‚“7/Ápğe>|ßà	ø=½]Ğocû‘á&åxNm£‰çƒ»¬ào·GÃN	p—‚»˜x¨•Ã½İğƒy\\3àø‡Â€'ÖI`râG÷]Ä¾ñ7ˆ\\7Ú49¡]Å^p‡{<Zá·¸q4™uÎ|ÕÛQÛ™àõp™ıši\$¶@oxñ_<Àæ9pBU\"\0005— iä×‚»¸Cûp´\nôi@‚[ãœÆ4¼jĞ„6bæP„\0Ÿ&F2~Àù£¼ïU&š}¾½¿É˜	™ÌDa<€æzx¶k£ˆ‹=ùñ°r3éË(l_”…FeF›4ä1“K	\\Óldî	ä1H\r½€ùp!†%bGæXfÌÀ'\0ÈœØ	'6Àps_›á\$?0\0’~p(H\n€1…W:9ÕÍ¢¯˜`‹æ:hÇB–èg›BŠk©ÆpÄÆót¼ìˆEBI@<ò%Ã¸Àù` êŠyd\\Y@D–P?Š|+!„áWÀø.:ŸLe€v,Ğ>qóAÈçº:–îbYéˆ@8Ÿd>r/)ÂBç4ÀĞÎ(·Š`|é¸:t±!«‹Á¨?<¯@ø«’/¥ S’¯P\0Âà>\\æâ |é3ï:VÑuw¥ëçx°(®²Ÿœ4€ÇZjD^´¥¦Lı'¼ìÄC[×'ú°§®éjÂº[ E¸ó uã°{KZ[s„€6ˆ‚S1Ìz%1õc™£B4ˆB\n3M`0§;çòÌÂ3Ğ.”&?¡ê!YAÀI,)ğå•l†W['ÆÊIÂ‡Tjƒè>F©¼÷S§‡ BĞ±Pá»caşÇŒuï¢NİÏÀøHÔ	LSôî0”ÕY`ÂÆÈ\"il‘\rçB²ëã/Œôãø%P€ÏİN”Gô0JÆX\n?aë!Ï3@MæF&Ã³Öş¿,°\"î€èlbô:KJ\rï`k_êb÷üAáÙÄ¯Ìü1ÑI,Åİîüˆ;B,×:ó¾ìY%¼J Š#v”€'†{ßÑÀã„	wx:\ni°¶³’}cÀ°eN®Ñï`!wÆ\0ÄBRU#ØSı!à<`–&v¬<¾&íqOÒ+Î£¥sfL9QÒBÊ‡„ÉóäbÓà_+ï«*€Su>%0€™©…8@l±?’L1po.ÄC&½íÉ BÀÊqh˜¦ó­’Áz\0±`1á_9ğ\"–€è!\$øŒ¶~~-±.¼*3r?øÃ²Àd™s\0ÌõÈ>z\nÈ\0Š0 1Ä~‘ô˜Jğ³ğú”|SŞœô k7gé\0ŒúKÔ d¶ÙaÉîPgº%ãw“DôêzmÒûÈõ·)¿‘ñŠœj‹Û×Âÿ`k»ÒQà^ÃÎ1üŒº+Îåœ>/wbüGwOkÃŞÓ_Ù'ƒ¬-CJ¸å7&¨¢ºğEñ\0L\r>™!ÏqÌîÒ7İÁ­õoŠ™`9O`ˆàƒ”ö+!}÷P~EåNÈc”öQŸ)ìá#ûï#åò‡€ì‡ÌÑøÀ‘¡¯èJñÄz_u{³ÛK%‘\0=óáOX«ß¶Cù>\n²€…|wá?ÆF€Åê„Õa–Ï©UÙåÖb	N¥YïÉhŠ½»é‘/úû)ŞGÎŒ2ü™¢K|ã±y/Ÿ\0éä¿Z”{éßP÷YG¤;õ?Z}T!Ş0ŸÕ=mN¯«úÃfØ\"%4™aö\"!–ŞŸúºµ\0çõï©}»î[òçÜ¾³ëbU}»Ú•mõÖ2±• …ö/tşî‘%#.ÑØ–Äÿse€Bÿp&}[ËŸÇ7ã<aùKıïñ8æúP\0™ó¡g¼ò?šù,Ö\0ßßˆr, >¿ŒıWÓşïù/Öş[™qık~®CÓ‹4ÛûGŠ¯:„€X÷˜Gúr\0ÉéŸâ¯÷ŸL%VFLUc¯Şä‘¢şHÿybP‚Ú'#ÿ×	\0Ğ¿ıÏì¹`9Ø9¿~ïò—_¼¬0qä5K-ÙE0àbôÏ­üš¡œt`lmêíËÿbŒàÆ˜; ,=˜ 'S‚.bÊçS„¾øCc—ƒêëÊAR,„ƒíÆXŠ@à'…œ8Z0„&ìXnc<<È£ğ3\0(ü+*À3·@&\r¸+Ğ@h, öò\$O’¸„\0Å’ƒèt+>¬¢‹œbª€Ê°€\r£><]#õ%ƒ;Nìsó®Å€¢Êğ*»ïcû0-@®ªLì >½Yp#Ğ-†f0îÃÊ±aª,>»Ü`ÆÅàPà:9ŒŒo·ğ°ov¹R)e\0Ú¢\\²°Áµ\nr{Ã®X™ÒøÎ:A*ÛÇ.Dõº7»¼ò#,ûN¸\rE™Ô÷hQK2»İ©¥½zÀ>P@°°¦	T<ÒÊ=¡:òÀ°XÁGJ<°GAfõ&×A^pã`©ÀĞ{ûÔ0`¼:ûğ€);U !Ğe\0î£½Ïc†p\r‹³ ‹¾:(ø•@…%2	S¯\$Y«İ3é¯hCÖì™:O˜#ÏÁLóï/šé‚ç¬k,†¯Kåoo7¥BD0{ƒ¡jó ìj&X2Ú«{¯}„RÏx¤ÂvÁä÷Ø£À9Aë¸¶¾0‰;0õá‘à-€5„ˆ/”<Üç° ¾NÜ8E¯‘—Ç	+ãĞ…ÂPd¡‚;ªÃÀ*nŸ¼&²8/jX°\rš>	PÏW>Kà•O’¢VÄ/”¬U\n<°¥\0Ù\nIk@Šºã¦ƒ[àÈÏ¦Â²œ#?€Ùã%ñƒ‚èË.\0001\0ø¡kè`1T· ©„¾ë‚Él¼šÀ£îÅp®¢°Á¤³¬³…< .£>íØ5Ğ\0ä»	O¬>k@Bn¾Š<\"i%•>œºzÄ–ç“ñáºÇ3ÙPƒ!ğ\rÀ\"¬ã¬\r ‰>šadàöó¢U?ÚÇ”3P×Áj3£ä°‘>;Óä¡¿>t6Ë2ä[ÂğŞ¾M\r >°º\0äìP®‚·Bè«Oe*Rn¬§œy;« 8\0ÈËÕoæ½0ıÓøiÂøş3Ê€2@Êıà£î¯?xô[÷€ÛÃLÿa¯ƒw\ns÷ˆ‡ŒA²¿x\r[Ñaª6Âclc=¶Ê¼X0§z/>+šª‰øW[´o2ÂøŒ)eî2şHQPéDY“zG4#YD…ö…ºp)	ºHúp˜&â4*@†/:˜	á‰T˜	­Ÿ¦aH5‘ƒëh.ƒA>œï`;.Ÿ­îY“Áa	Âòút/ =3…°BnhD?(\n€!ÄBúsš\0ØÌDÑ&D“J‘)\0‡jÅQÄyhDh(ôK‘/!Ğ>®h,=Ûõ±†ãtJ€+¡Sõ±,\"M¸Ä¿´NÑ1¿[;øĞ¢Š¼+õ±#<ìŒI¤ZÄŸŒP‘)ÄáLJñDéìP1\$Äîõ¼Q‘>dO‘¼vé#˜/mh8881N:øZ0ZŠÁèT •BóCÇq3%°¤@¡\0Øï\"ñXD	à3\0•!\\ì8#h¼vìibÏ‚T€!dª—ˆÎüV\\2óÀSëÅÅ’\nA+Í½pšxÈiD(ìº(à<*öÚ+ÅÕE·ÌT®¾ BèS·CÈ¿T´æÙÄ e„Aï’\"á|©u¼v8ÄT\0002‘@8D^ooƒ‚ø÷‘|”Nù˜ô¥ÊJ8[¬Ï3ÄÂõîJz×³WL\0¶\0€È†8×:y,Ï6&@”À E£Ê¯İ‘h;¼!f˜¼.Bş;:ÃÊÎ[Z3¥™Â«‚ğn»ìëÈ‘­éA¨’ÓqP4,„óºXc8^»Ä`×ƒ‚ôl.®üº¢S±hŞ”°‚O+ª%P#Î¡\n?ÛÜIB½ÊeË‘O\\]ÎÂ6ö#û¦Û½Ø(!c) Nõ¸ºÑ?EØ”B##D íDdo½åPAª\0€:ÜnÂÆŸ€`  ÚèQ„³>!\r6¨\0€‰V%cbHF×)¤m&\0B¨2Ií5’Ù#]ú˜ØD>¬ì3<\n:MLğÉ9CñÊ˜0ãë\0“¨(á©H\nş€¦ºM€\"GR\n@éø`[Ãó€Š˜\ni*\0œğ)ˆü€‚ìu©)¤«Hp\0€Nˆ	À\"€®N:9qÛ.\r!´JÖÔ{,Û'æÙŠ4…B†úÇlqÅ¨ŸXc«Â4ß‹N1É¨5«WmÇ3\nÁF€„`­'‘ˆÒŠxàƒ&>z>N¬\$4?ó›ÃïÂ(\nì€¨>à	ëÏµPÔ!CqÍŒ¼Œp­qGLqqöG²yÍH.«^à\0zÕ\$€AT9Fs†Ğ…¢D{ía§øcc_€GÈz†)ó³‡ Ü}QÆÅhóÌHBÖ¸<‚y!L­“€Û!\\‚²ˆî ø'’H(‚ä-µ\"ƒin]Äˆ³­\\¨!Ú`M˜H,gÈí»*ÒKfë*\0ò>Â€6¶ˆà6ÈÖ2óhJæ7Ù{nqÂ8àßôÉHÕ#cHã#˜\r’:¶–7Ê8àÜ€Z²˜ZrD£şß²`rG\0äl\n®Iˆi\0<±äãô\0Lg…~¨ÃE¬Û\$¹ÒP“\$Š@ÒPÆ¼T03ÉHGH±lÉQ%*\"N?ë%œ–	€Î\nñCrWÉC\$¬–pñ%‰uR`ÀË%³òR\$–<‘`ÖIfxª¯÷\$/\$„”¥\$œš’O…(‹Ë\0æË\0RY‚*Ù/	ê\rÜœC9€ï&hhá=IÓ'\$–RRIÇ'\\•a=EÔ„òuÂ·'Ì™wIå'T’€€‘üÿ©¾ãK9%˜d¢´·‚!ü”ÀÊÊÀÒj…ì¡íÓÊ&Ğæ„vÌŸ²\\=<,œEùŒ`ÛYÁò\\Ÿ²‚¤*b0>²r®à,d–pdŒŒÌ0DD Ì–`â,T ­1İ% P‘¤/ø\ròb¹(Œ£õJÑèÍîT0ò``Æ¾ŞèíóJ”t©’©ÊŸ((dÇÊªáh+ <Éˆ+H%i‡Èô‹²•#´`­ ÚÊÑ'ô£B>t˜¯J€Z\\‘`<Jç+hR·ÊÔ8î‰€àhR±,J]gò¨Iä•è0\n%J¹*ĞY²¯£JwDœ°&Ê–D±®•ÉĞœªR§K\"ß1Qò¨Ë ”²AJKC,ä´mV’»²›ÊÙ-±òÏKI*±r¨ƒ\0ÇL³\"ÆKb(üªóJ:qKr·dùÊŸ-)ÁË†#Ô¸²Ş¸[ºA»@•.[–Ò¨Ê¼ß4º¡¯.™1ò®J½.Ì®¦u#J“‡Ág\0Æãò‘§£<Ë&”’ğK¤+½	M?Í/d£Ê%'/›¿2YÈä>­\$Í¬lº\0†©+ø—Á‰}-tº’Í…*ê‰Rä\$ß”òÌK».´Á­óJHûÊ‰‡2\r„¿B‚½(PÍÓÌ6\"ü–nf†\0#Ğ‡ ®Í%\$ÄÊ[€\nĞnoLJ°ŒÅÓÂe'<¯ó…‡1KíÁyÌY1¤Çs¥0À&zLf#üÆ³/%y-²Ë£3-„Â’ÍK£L¶ÎÉ×0œ³’ë¸[,¤ËÌµ,œ±’«„§0”±Ó(‹.DÀ¡@ÏÁ2ïL+.|£’÷¤É2è(³L¥*´¹S:\0Ù3´ÌíóG3lÌÁaËl³@L³3z4­Ç½%Ì’ÍLİ3»…³¼!0Š33=Lù4|È—¡à+\"°Êé4´Ëå7Ë,\$¬SPM‘\\±Î?JŠY“Ì¡¹½+(Âa=K¨ì4œ¤³CÌ¤<Ğ…=\$,»³UJ]5h³W &tÖI%€é5¬Ò³\\M38g¢Í5HŠN?W1Hš±^ÊÙÔ¸“YÍ—Ø Í.‚N3MŸ4Ã…³`„i/P‰7ÖdM>šd¯/LRÎÜâ=K‘60>¯I\0[ğõ\0ßÍ\r2ôÔòZ@Ï1„Û2ÿ°7È9äFG+ä¯ÒœÅ\r)àhQtL}8\$ÊBeC#Á“r*HÈÛ«-›Hı/ØËÒ6Èß\$øRC9ÂØ¨!‚€Å7ük/PË0Xr5ƒ¡3D„¼<TÁÔ’q¯Kô©³nÎH§<µFÿ:1SLÎrÀ%(ÿu)¸Xr—1Ñ€nJÃIÌ´S£\$\$é.Î‡9Ôé²IÎŸÒ3 ¨LÃl”“¯Î™9äÅC•N #Ô¡ó\$µ/ÔésÉ9«@6Êt“²®Nñ9¼´·NÉ:¹’Â¡7ó Ó¬Í:DáÓÁM)<#–ÓÃM}+ñ2ÎNşñ²›O&„ğ¢JNy*ŒòòÙ¸[;ñóÎO\"mÚÄóÅMõ<c Â´‚°±8¬K²,´ÓÇN£=07s×JE=Tá³ÆO<Ôô³£Jé=D“Ó:ÏC<Ì“àË‰=äèó®KÊ»Ì³ÈL3¬÷­„LTĞ€3ÊS,œ.¨ÿÏq-Œñsç7Í>‚?ó¼7O;Ü `ùOA9´óñÏ»\$œüÁOÑ;ìı`9ÎnÇIAŒxpÜöE=O¹<ü²5ÏÎ„ı2¸O?d´„´Œ`NòiOÿ>Œş3½P	?¤òÔOmœúSğMôË¬·†=¹(ãdã¤AÈ­9“‘\0í#üä²@ƒ­9DÁÉ&ÜıòŠ‚?œ “Ği9»\nà/€ñAİóòÈ­A¤ıSËPo?kuN5¨~4ÜãÆ6††Ø=ò–Œ“*@(®N\0\\Û”dGåüp#è¤> 0À«\$2“4z )À`ÂW˜ğ +\0Š‘80£è¦• ¤ª”äz\"TĞä0Ô:\0Š\ne \$€rM”=¡r\n²N‰P÷Cmt80ğú #¤ØJ= &ĞÆ3\0*€Bú6€\"€ˆéèú€#Ì>˜	 (Q\nŒğê´8Ñ1C\rt2ƒECˆ\n`(Çx?j8N¹\0¨È[À¤QN>£©à'\0¬x	cêªğ\nÉ3×Chü`&\0²Ğ´8Ñ\0ø\näµ¦úO`/€„¢A`#ĞìXcèĞÏD ÿtR\n>¼ÔdÑBòD´LĞÄÌõ‰äĞÍDt4ĞÖ j”pµGAoQoG8,-sÑÖğÔK#‡);§E5´TQÑGĞ4Ao\0 >ğtMÓD8yRG@'PõC°	ô<PõCå\"”K\0’xüÔ~\0ªei9Ğìœv))ÑµGb6‰€±H\r48Ñ@‚M‰:€³FØtQÒ!H•”{R} ôURpÍÔO\0¥I…t8¤ØğûÎÇ[D4FÑD#ÊÑ+D½'ôMÊ•À>RgIÕ´ŠQïJ¨””UÒ)EmàüTZ­Eµ'ãê£iEİ´£ÒqFzAªº>ı)T‹Q3HÅ#TLÒqIjNT½¼…&CøÒhX\nT›ÑÙK\0000´5€ˆ¢JHÑ\0“FE@'Ñ™Fp´hS5F\"ÎoÑ®e%aoS E)  €“DU «Q—FmÎÑ£M´ÑÑ²e(tnÒ “U1Ü£~>\$ñßÇ‚’­(hÕÇ‘Güy`«\0’ê 	ƒíG„ò3Ô5Sp(ıõPãGí\$”œ#¤¨	©†©N¨\nôV\$ö]ÔœPÖ=\"RÓ¨?Lzt·ƒ1L\$\0ÔøG~å ,‰KNı=”ëÒGMÅ”…¤NS€)ÑáO]:ÔŠS}İ81àRGe@Cí\0«OPğSõNÍ1ôİT!P•@ÑİS€ğÿÕS‰G`\nÉ:€“P°j”7R€ @3üÑ\n‘ üã÷â£”DÓ æúLÈÏ¼ 	èë\0ùQ5ôµ©CPúµSMP´v4†º?h	hëT‡D0úÑÖàõ>&ÒITxôO¼?•@U¤÷R8@%Ô–ŒõK‰€§NåKãóRyE­E#ıù @ıÃøä%Là«Q«Q¨µ£ª?N5\0¥R\0úÔTëFåÔ”RŸSí!oTEÂC(Ï¶ÈıÄµ\0„?3iîSS@U÷QeMµƒ	KØ\n4PÕCeS”‘\0NC«P‚­Oõ! \"RTûõ€S¥NÕÁU5OU>UiIÕPU#UnKPô£UYTè*ÕC«U¥/\0+º¸Å)ÈÚ:ReAà\$\0ø¤xòÇWDº3Ãêà`üÚüçU5ÒIHUY”ô:°P	õe\0–MJi€ƒµÃıQø>õ@«T±C{›ÕuÑì?Õ^µv\0WR]U}Cöê1-5+Uä?í\rõW<¸?5•JU-SXüÕLÔß \\tÕ?ÒsMÕb„ÕƒVÜt§TŒ>ÂMU+Ö	EÅcˆÏÔ9Nm\rRÇƒCı8SÇX•'RÒéXjCI#G|¥!QÙGh•tğQ¸ı )<¹YĞ*ÔĞRmX0üôö½M£›õOQßYıhÀ«ßduÕ¤ÕZ(ıAo#¥NlyN¬V€Z9IÕºM•¦V«ZuOÕ…TÕTÅEÕ‡Ö·SÍeµµÖÊ\nµXµªSÛQERµ³ÔÙ[MF±VçO=/õ­¨>õgÕ¹TíVoUT³Z’N€*T\\*ÃïĞ×S-pµSÕÃVÕq€ÒM(ÏQ=\\-UUUV­C•Ä×ZØ\nu’V\$?M@UÎWJ\r\rUĞÔ\\å'U×W]…W”£W8ºN '#h=oCóĞıF(üé:9ÕYu•†¤÷V-UÓ9Ÿ]ÒC©:U¿\\\nµqW—™à(TT?5Páª\$ R3ÕâºŸC}`>\0®E]ˆ#Rêà	ƒÿ#R¥)²W–’:`#óGõ)4ŠRÀı;õáViD%8À)Ç“^¥Qõé#”h	´HÂX	ƒş\$Nıx´š#i xûÔ’XRõ€'Ô9`m\\©†¨\nEÀ¦Q±`¥bu@×ñN¥dT×#YYı„µ®GV]j5#?L¤xt/#¬”å#é…½O­PÕëQæ¢6•££Ï^í† €šğüÖØM\\R5t´Óšpà*€ƒXˆV\"WÅD€	oRALm\rdGN	ÕÖÀú6”p\$PåºŸE5Ôı†©Tx\n€+€‹C[¨ôVŒıÖ8U•Du}Ø»F\$.ªËQ-;4È€±NX\n.XñbÍ•\0¯b¥)–#­NıG4KØĞZS”^×´M¶8Øód­\"C‚¬>ÅÕdHe\nöY8¥Ñ.ê ú°ˆÒFúD”½W1cZ6”›QâKHü@*\0¿^¸úÖ\\QßF‚4U3Y|‘=˜Ó¤éE›ÔÛ¤¦?-™47YƒPm™hYw_\ršVe×±M˜±ßÙe(0¶ÔFÕ\r !ÒPUI•uÑ7Qå•CèÑ?0ÿµİgu\rqà¤§Y-Qèó°èú=g\0…\0M#÷U×S5Zt®ÖŸae^•\$>²ArV¯_\r;tî¬’¨”HW©Zí@HÕØhzDèÚ\0«S2Jµ HIåO 'ÇeígÉ6¹[µR”<¸?È /ÒKM¤ö–Ø\n>½¤HáZ!iˆö¤ŸTX6–Ò×iºC !Ó›g½à ÒG }Q6Ñ4>äwà!Ú™C}§VBÖ>åªUQÚ‘jª8cïUTàû–'<‚>ÈıõôHC]¨VšÑ7jj3v¥¤å`0ÃèÈ23ö°Ğòxû@U—k \n€:Si5Õ#Yì-wî”ÕàéM?céÒMQÅGQÕÑƒb`•ò\0@õËÒ§\0M¥à)ZrKXûÖŸÙWl­²öÍlå³TM×D\r4—QsS¥40ÑsQÌõmYãh•d¶ÂC`{›V€gEÈ\n–»XkÕà'Óè,4ú¼¹^í¢6Æ#<4éNXnM):¹·OM_6d€–æõ¸Ãõ[\"KU²nÖ?l´x\0&\0¿R56ŸT~> ô†Õ¸?”Jn€’ ˆÏZ/iÒ6ôÎÚglÍ¦ÖUÛáF}´.£¼JLöCTbM4ÍÓcLõTjSD’}JtŒ€Z›ªµÇ:±L­€´d:‰Ez”Ê¤ª>ÖV\$2>­µ¢[ãpâ6öÔR9uêW.?•1®£RHuèÛR¸?58Ô®¤íDİÆuƒ£çpûcìZà?œr×» Eaf°}5wY´ëå‚Ï’ÒêÅW‚wT[Sp7'Ô_aEk \"[/i¥¿#ÿ\$;m…fØ£WOüô”ÔFò\r%\$Íju-t#<Å!·\n:«KEA£íÒÑ]À\nUæQ­KEÀ #€¿Xå¨÷5[Ê>ˆ`/£ÍDµÊÖ­VEpà)åI%ÏqßÜûníx):¤§le¢´Õ[eÕ\\•eV[j…–£éÑ7 -+ÖßGWEwt¯WkEÅ~uìQ/mõ#ÔW—`ıyu“Ç£DİAö'×±\r±•Õ™OD )ZM^€³u-|v8]‹g½‘hö×ÅLà–W\0øÈû6ËX†‘=YÔd½Q­7Ï“”Ï9£çÍ²r <ÃÖêD³ºB`c 9¿’È`D¬=wx©I%ä,á„¬†è²àêƒj[ÑšÖíßOÿ‹´ ``Å|¸òòÆŞø¤Œ˜¼í.Ì	AOŠÀÄ	·‰@å@ 0h2í\\âĞ€M{eã€9^>ô•â@7\0òôË‚W’€ò\$,íÉÅš¡@Ø€Òâ•å×w^fmå‰,\0ÏyD,×^X€.¯Ö†©7ã·›Ã×2İÅf;¥€6«\n”¤…^ŸzC©×§mz…én–^ˆô”&LFFê,°ö[€¥eÈõaXy9h€!:zÍ9còQ9bÅ !€¦µGw_WÉg¥9©ÓS+t®ÚápİtÉƒ\nm+–œŞÙ_ğ	¡ª\\¼’k5£ÒÜ]Æ4ˆ_h•9 Ù÷N…—Å]%|¥ˆ7ËÖœ];”ï|ñµ ßXıÍ9Õ|åñ×ÌG¢“¨[×Ô\0‘}Uñ”çßMCI:ÒqO¨VÔƒa\0\rñRÍ6Ï€Ã\0ø@H¢ÅP+rìS¤Wãè€øp7äI~p/ø HÏ^İê²ü¤¬E§-%û¥Ì»Í&.ÎÄ+¸JÑ’;:³¶«!“ıĞNğ	Æ~öª‰€/“WÄÂ!„BèL+Â\$ğíq§=ü¿+Ñ`/Æ„e„\\±ÒÏxÀpE‘lpSÂJSİ¢½ö6à‡_¹(Å¯©Äéb\\OÆÊ&ì¼\\Ğ59\0ûÂ€9nñøD¸{¡\$á¸‹K‘v2	d]èv…CÕşÅÕ?tf|WÜ:£Ô¨p&¿àLn„Îè³î{;ˆçÚGR9øT.y¹üïI8€¹´\rl° ú	Tè n”3¼öğT.ƒ9´è3› š¼Zès¡¯ÑÒGñşˆ:	0£¦£zè­İ.Œ]ÀçÄ£Q›?àgT»%ñ™ÕxŒÕŒ.„šÔÇn<ì£-â8BË³,Bòì˜rgQş¢íßó„É`Úá2é„:îµ½{…gëÄs„øgóZ¿•… ×Œ<æ×w{¦˜ƒbU9ˆ	`5`4„\0BxMpğ‘8qnahé†@Ø¼í†-â(—>S|0®…¾¥…3á8h\0Ñ«µCÔzLQ@¶\n?†¸`AÀ >2šÂ,÷á˜ñN&Œ«xˆl8sah1è|˜B‡É‡DxBŞ#V—‹V–×Š`Wâa'@›‡¬	X_?\nì¾  •_â. ØP¼r2®bUarÀI¸~áñ…S“àú\0×…\" 2€ÖşÀ>b;…vPh{[°7a`Ë\0êË²j—oŒ~·ûşvÍÙ|fv†4[½\$¶«{ó¯P\rvæBKGbpëÈÅø™–OŠ5İ 2\0j÷Ù„L€î)ÇmáÈV¡ejBB.'R{C¤ïV'`Ø‚ ‰%­Ç€Ğ\$ Oå\0˜`‚’«4 ÌNò>;4£³¢/ÌÏ€´À*Âø\\5„ÅÁ!†û`X*Ş%îÄNÍ3SõAMôşËÆ”,ş1¬²®í\\¯²caÏ§ ³ù@Ø¬Ëƒ¸B/„¬Íø0`óv2ï¡„§Œ`hDÅJO\$ç…@p!9˜!¥\n1ø7pB,>8F4¯åf Ï€:“ñ7Â„î3›£3…¿à°T8—=+~Øn«Îâ\\Äe¸<br·ş øFØ²° ¹C¡N‹:c€:Ôl–<\r›ã\\3à>ñ˜‡À6ONnŠä!;áñ@›twë^Fé€Là;€×º,^aÈ\ra\"ŞÀÚ®'ú:„vàJe4Ã×;•ñ_d\r4\rÌ:ÛüÀ¬S˜à2€[c€„XÿÊ¦Pl˜\$¹Ş£i“wåd#B šb›Î×¤õ’™`:†€Ï~ <\0Ñ2Ù·—‘RŒÂÆPÈ\r¸J8D¡t@ìEè\0\rÍœ6öóäŞ7•½ä˜YÏ£ú\"åäÀš\rüƒ¦Àš3ƒ¡.˜+«z3±;_ÊŸvLİäÓwJ¿94ÀIJa,A¦ñˆ¯;ƒs?ÖN\nR‡!§İ†Om…sÈ_æà-zÛ­w„€ÛzÜ­7¡ÍÅzî÷–M”ˆ€o¿”¥æ\0¢ƒa”Åİ¹4å8èPfñYå?”òi—–eBÎSà1\0ÉjDTeK”®UYSå?66R	¦cõ6Ry[c÷”°5Ù]BÍ”ÖRù_eA)&ù[å‡•XYRW–6VYaeU•fYeåw•U¹båw”Eë°Ê†;z¤^W«9–ä×§äİ–õë\0<Ş˜èeê9SåÎ¤daª	”_-îá‰L×8Ç…ÍQöèTH[!<p\0£”Py5ˆ|—#ê‘P³	×9vàš2Â|Ç¸áfao†á,j8×\$A@kñƒ¿aË‘½bócñÈf4!4¨‘¶cr,;™‘æ‘öbÆ=€Â;\0°øÅº…˜†cdÃæX¾bìx™a™Rx0Aãh£+wğxN[˜ÜB·pÚƒ¿w™TÀ8T%™šMšl2à‡½¡šğ—}¡Ès.kY„˜0\$/èfU€=şØs„gKÃ¡ˆM› õ?ÿ›ç`4c.Ôø!¡&€åˆ†g°ûfà/şf1=¯›V AE<#Ì¹¡f\n») Šë›Npò“ã`.\"\"»Açœ¤ã—üq¸X“ Ù¬:aÉ8™¹f¯™Vsó‹G™Şr:æVŞÆcÔgVl™g=`ã“WËıyÒgUÀË™ªáº¼îeT= ã€á€Æx 0â M¼@ˆ»šÂ%Îºb½œşw™ÆfÛÙOøç­˜Ü*0¯…®|tá°%±™PÈÍpæúgKù¬?pô@JÀ<BÙŸ#­`1„î9ş2çg¶!3~ØÜçînläÅfŠØVhù¬.Ñ€à…aCÑù•?³Šû-à1œ68>A¤ˆaÈ\r—¦y‹0 Öi‘J«} à¹© Ğz:\r¡)‘Sş‚¡@¢åh@äöƒY¹ã´mCEg¡cyÏ†‚<õàÍh@¼@«zh<WÙÄ`Â•¨±:zOãÎÖ\rÍêW«“°V08Ùf7™(Gyƒ²`St#ï„f†#ƒ²œC(9ÈÂ˜Ø€dùææ8T:¯»Œ0ºè qµ  79·á£phAgÜ6Š.ãæ7Fr™bä ÈjšèA5î…†ƒá¡a1úÚh•ZCh:–%¹ÎgU¢ğD9ÖÅÉˆ„×¹Ïé0~vTi;VvSš„wœØ\rÎƒ?àÇf²£…ÿ¥nŠÏ›iY™ìaº¬3 Î‡9Õ,\n™Ãr‘‰,/,@.:èY>&…šFÑ)ú™¶}šb£€èiOİiæš:dèAŒn˜šc=¤L9O’h{¦ 8hY.’ÙÀ®¾‡®‡…œüÇ\r¬Ö‡£À›Šé1Q¯U	”C‘hô†eÿO‰›°+2oÌÎìŞN‹˜÷§øzpè¢(ş]Óh€å¢Z|¬O¡cÑzDáş;õT\0j¡\0…8#>ÎÁ=bZ8Fjóìé;íŞºTé…¡w®Í)¦ıøN`æë¨¤Ã…B{ûƒz\ró¡c“Óè|dTG“iœ/ûú!i†Ê0±¼ø'`Z:ŠCHï(8Âê`V¥™Úãöª\0Üê§©†£WïßÇª˜ÕzgG¾‘…ƒ½²-[ÃĞ	iœêN\rqºé«n„„“o	Æ¥fEJı¡apb¹ê}6£…Õ=o¤–„,tèY+ö®EC\rÖPx4=¼¾™Ù@‡‰¦.†‘F£[¡zqçÜèX6:FG¨ #°û\$@&­ab¤şhE:²ƒå¬ä`¶S­1—1g1©ş„2uhY‹¬_:Bß¡dcï–*ÿ­†\0úÆ—FYFœ:Ë£ªn„ØÌ=Û¨H*Z¼Mhk/ëƒ¡zÙ¹ï‹´]šÁh@ôæ©Øã1\0˜øZKù¢ëÎÆè^+º,vfós®š>ˆ¤’Oã|èÀÊsÃ\0Öœ5öXé‹îÑ¯F„÷n¿Aˆr]|ÏIi4è…ş ØÂC° h@Ø¹´Ÿ–cß¥¨6smOÃå‰™›gX¬V2¦6g?~ÖÃYÕÑ°†súcl \\RŠ\0Œ¨cœA+Œ1°„›ùÌé\n(ÑúÃÌ^368cz:=z÷‚(äø ;è£¨ñsüF¶@`;ì€,>yTßï&–•d½L×Ÿœÿ%Òƒ-ëCHL8\r‡Çbû°°£úMj]4Ym9üÛüĞZÚBøïP}<ŸûàX²¯‰Ì¥á+gÅ^ØMŞ + B_Fd¬X„ø‹lówÈ~î\râ½‹è\":ÔêqA1X¾ìæ²Ğø¯3ÖÎ“Eáh±4ßZZÂó¸& …ææ1~!Nfã´öo—ˆ™\nMeÜà¬„îëXIÎ„íG@V*X¯†;µY5{Vˆ\nè»ÏTéz\rF 3}m¶Ôp1í[€>©tèe¶w™Ÿæë@VÖz#‚2Äï	iôôÎ{ã9ƒ‚pÌ»gh‘Šæ+[elU‰¦ÛAßÙ¶Ó¼i1Ä!Œ¾ommµ*Kà‡ê}¶°!íÆ³í¡®İ{me·f`“—mè˜CÛz=nŞ:}g° T›mLu1FÜÚ}=8¸ZáíèOÛmFFMf¤…OO€ğîáÀ‹ƒèøß/¼éõ¸Ş“šå€şV™oqj³²èn!+½òµüZ¨ËI¹.Ì9!nG¹\\„›3a¹~…O+Îå::îK@Œ\nÚ@ƒ‘¤Hph‘´\\BÄõdmfvCèÓPÛ\" æ½Û.nW&–ên¢øHYş+\r¶“Äz÷i>MfqÛ¤î­ºùİQc‚[­H+æÀo¤Ñ*ú1'¤÷#ÄEw€D_Xí)>Ğs£„-~\rT=½£à÷ˆà- íy§m§¹æğ{„hóŸÌjÚMè)€^¹ïÀ'@Vå¡+iÈîÎò›Ÿåµ†É;F“ D[Îb!¼¾´B	¦¤:MP‹îóÛ­oC¼vAE?éC²IiYÍ„#şp¶P\$kâJŞq½.É07œşöxˆl¦sC|ï½¾bo–2äXª>Mô\rl&»Ç:2ã~ÛÑcQ²îò²æoÑŞdá‚-şèUÜRo‚YšnM;’n©#–ß\0–P¾fğÚPo×¿(CÚv<Ê¬ø[òoÛ¸”šû×fÑ¿ÖüÁ;ßáº–õ[úYŸ.o®Up¿®pUŒø”. ©B!'\0‹òã<Tñ:1±À¾ šã¤î<„›ğnˆîF³ğƒI¢Ç”´‚V0ÊÇRO8‰wøÎ,aFú¼É¥¹[´ÎŸ…ñYOù«‰€/\0™Ùox÷ÇQğ?§°:Ù‹ëÆè`h@:ƒ«¿öÑ/Mím¼x:Û°c1¤Öàû¯ív²;„‚è^æØÆ@®õ@£úğ½ÂÇ\n{¯¼Âî‹à;ç‘´B¼í¸8‘º gå’ä\\*gåyC)Û„E^ıOÄh	¡³¦Aƒu>Æèü@àDÌ†Yæ¼í›â`o»<>Àƒp‰™ŠÄ·’q,Y1Q¨Áß¸†/qgŒ\0+\0âæå‡Dÿƒç?¶ş î©Úßîk:ù\$©û¬í×¥6~I¥…=@íÑ!¾ùvÚzOñš²â+ÍõÆ9Çi³–›¼aïğ†êû…gòğôî¿—¹ÿ?š0Gn˜q²]{Ò¸,FáÃøO¡â„Ş <_>f+¢,ñÌ	»Ôñ±&ôœ†ğíÂ·¼yêÇ©Oü:¬UÂ¯ˆLÆ\nÃÃºI:2³¿-;_Ä¢È|%éå´¿!Îõf\$¦ˆ†Xr\"Kniîñ—ÀĞ\$8#›g¤t-›€r@LÓåœè@S£<‘rN\nD/rLdQkà£“”ªõÄîeğåäãĞ­åø\n=4)ƒB˜”Ë×šôÌZ-|Hb¡†‘HkÊ*	ÖQ!Ğ'êG ›Ybt!¿Ê(n,ìP³OfqÑ+X“Y±ÿ‚ë\"b F6ÖÌr fò\"ÒÜ³!N¡ó^¼¦r±B_(í\"¨KÊ_-<µò *Q÷ò¨Ù/,)H\0„‰²rç\"z2(¹tÙ‡.F>†‡#3â®Ø¦268shÙ ş¨Æ‘I1Sn20¶çÊ-«4’ÚÇ2Aœs(¬4ä¼Ë¶Š\0Æİ#„årşK'ËÍ·G'—7&\n>xßüÜJØGO8,ó…0¼â‹ù8”ÑÓ\0óW9’İIˆ?:3nº\r-w:³ÂÌÅ×;3È‰”!Ï;³Üêƒ˜˜Z’RMƒ+>ÖÜğÊé0/=R…'1Ï4Õ8ûÑÏmÿ%È¥}Ï‡9»;‚=ÏnQöã=ÏhhLõ·GÏkWÎ\rô	%Ø4ÒœsñÎ–J€3sÛ4—@™U‚%\$ÜÑN;Ì?4­»óNÚÏ2|ÊóZÚ3Øh\0Ï3“5€^Àxi2d\r|ûM·Ê£bh|İ#vÇ` \0”ê®äàû\$\r2h#ú¤?³ˆI\n’¼+o-œŠ?6`á¹½¿.\$µšøKY%ØÂJ?¦c°RN#K:°KáELÁ>:Á¥@ŒãjP‘Ìn_t&slm’'æĞ©É¸Óœ²Œ½—ã;6Û—HU5#ìQ7U ıWYÜU bNµ–Wû_ûª©;TCø[İ<Ú–>ÅÇõ‰WıCUÔ6X#`MI:tùÓµ€ö	u#`­fu«\$«t­öXó`f<Ô;båghöÑÕ9×7ØS58õ¬İ#^–-õ\0êÀúîÕ¹R*Ö'£¨(õğõqZå££êX¹QİFUvÔW GWíñÓTêÇWô~Ú­^§WöÄÁÕıJ=_Ø—bmÖİbV\\l·/ÚMÕÿTmTOXuÊ=_ıITvvu‹a\rL_ÕqR/]]mÒsu=H=uÑg o\\UÕ…gM×	XVU À%õhı¡53U™\\=¡öQßØM¹v‡€¡gåmàõue¡ˆÙûhÿbİMİGCeO5®ÔÖO5…ÔYÙi=eÕ	GTURvOa°*İivWX•J5<õ¯bu ]ˆ×Öğúµ<õÃÙÕ\$u3v#×'eöuÑR5m•Šv‹D5.vŒõW=ŸU_å(´\\VØÏ_<õ÷SÍn)Ü1M%QháZ‡T…f5EÕ'ÕÍW½ŠvÅUmiÕ‚UÔÕ]aW©U§dRváÙ-YUZuÙUV—UiRV™õ³ÓÇ[£íZMU§\\=Âv{ÛXıµ¼wQ÷huHvÇ×gqİ´w!Úoqt¢U{TGqı{÷#^G_ubQ„êå•i9Qb>ÚNUdº±k…½5hPÙmu[•\0¦êÅ_¶é[õY-ğô÷rõÈÕ(ÖCrMeıJõ!h?QrX3 xÿÈÏ#‡÷xÖ<Û{u5~ƒíÑ-İuëYyQ\r-”î\0ùuÕ£uuÙ¿pUÚ…•)–PåÜ\r<u«S›0İÉw¹ß-iİóÔ!ÌÖŠøB÷áÆd]ùèÅ‡ÔÆEêğvlmQİ6k¼ÒJ´ˆwí¦ÄØÃãŒED¶UÙR“ev:XßcØNW}`-¨tÓH#e„bº±u€ãó	~B7ê ?ƒ	OPœCWµ×SEÍ•V>¶“×UÛ7ßç‰Ôám»Ó‚¬zÿ=µƒÍØ1º™ƒ+ ¹mÃI,>µX7àä] .‡½*	^îŠã°N…º.èÎ/\"„˜)Ğ	…¯‚s®|à¤çÓŸĞlÁ}ã¸Íç!óîƒ‘5n±p„j£¾h’}½èğm“EázHÂaO0d=A|wëß³ãë×šÎìu²œŸvùØ¼G€x#®…b”cSğo-‰ùtOm`C‹ò^MŒÅ@ë´h­n\$k´`ş`HD^PEà[äŒ]¹¨rR¸m=‚.ñÙ‡>Ayi‚ \"ú€ò	Ö·oã-,.œ\nq+À¥åfXdŠ«¶ã*ß½ˆKÎØƒ'Üê Ğ%aôÿ‡ù9pûæ—øKLM„à!ş,èÊË¨ŒzX#˜Vá†uH%!Àœ63œJ¾ryÕíùq_èu	úWù±‡Æ|@3b1åÈ7|~wï±³şíA7“ÒÂ›è™	¼™9cS&{ãäÒ%VxğïkZO‰×w‰Ur?®„’ªN Î|…CÉ#Å°õåÕ¯ ¹/ú™9ftEw¸CÁºa¦^\0øO<şW¦{Yã=éŸeë˜ınÉ„ígyf0h@ìSİ\0:C©´^€¸VgpE9:85Ã3æŞ§áºğ@»áj_ª[Ş+«êÇ©xƒ^“ê®†~@Ñ‡Wª¸ãã“œ†9x—FC˜¿­.ãšçöük^Iû¡pU9üØSŸØ÷½—œ\$óóø\r4´…ù\0ÎèO°ã‘Ä)L[Âp?ì.PECSìI1nm{Å?PîWAß²Á;€ñìD°;SºaKføò›%?´XõŞ+¤B>½ù9¿¯ÙGj˜cz‘AÍ÷:êa³n0bJ{o¥·!3À­!'’ØKÃÅíùÔ}ã\\èÎ3Wøê5îxÏÉÁL;ƒ2Î¶n—a;²í×ºXÓ›]Éoºœxû{ä¦5Ş™jX÷ˆğ—¶vÓšéãqŞÊEE{Ñ€4Á¾öÄ{íÙç	Ì\nöÊ>ù™aï¯·¾üì§ïØLûÔûåïÿ½ûìñ'ğ½Şé{ë\n‰—>JøßŒŒá¸Ó—†÷YÏ\rOÊ½ğ‘t¯ÿû¥-OÃ¦ü4Ôÿ9Fü;ğ§Á»ÔüGğøIªFßì1ÂoÿßóñO²¾éa{w—0Ó»ï¤Æ¯;ñ”„‘lüoñàJĞTb\rwÇ2®Jµş=D#ònÁ:ÉyñûSø^ã,.¿?(ÈI\$¯ÊÆ¯í¨á3÷Ãsğ4MÊaCRÉÆÍGÌ‘œúIß°n<ûzyÑXN¾ğ?õâ.Ãî=—àñ´DÇ¼\r›Øé\nÕó¨\roõı\nĞŸCl%ÁÍYÎû¥ß°ÏàGÑşÚ}#VĞ%ı(ÔÿÒà3æÉ˜rğ};ôû×¿GÉÌnö[ª{¥¹–“_<m4[	I¥¢À¼q°µ?ğ0cVınms„³nMõõˆ\"Nj1õw?@ì\$1¦ş>ğÒ^øÕû¥ö\\Ì{nÂ\\Ìé7Ÿ„¿ÙŸic1ïÚÿhooê·?j<GöxŸlÏù©Sèr}ÍÃÚ|\"}•÷/Ú?sç¬tIäåê¼&^ı1eóÓtãô,*'F¸ß=/Fkş,95rVâáøàÀºì‘ˆÛo9Íø/FÀ–_†~*^×ã{ĞIÆö¯ã_ƒ‚²Œ“^n„øşNŸŠ~øáÅAí¦‘d©åñşUøwäqY±åî´T¸2ÀéGä?‡&–§æô:yùè%Ÿ–Xç˜JÛCşd	Wèß~úG!†´J}›—¤úìùõÄB-Óï±;îûœhÃ*ó¼R´ìöE¶ ~âæó.«~Éçæ SAqDVxÂîÍ='íÉEÙ(^Šû¢~›ùø¿›çòéçïo7~‚M[§Qãî(³Üy¸ùnPÑ>[WX{qÔaÏ¤ÆÉı.&NÚ3]ñúHYïİûƒëÛ[¶ÁÙ&ü8?Ñ3„‹›¦¶§İ†Ú»¶á#Œ¦ÎBğe6ë…@–“[°¤£ûàĞG\rÎ+ı§}ü˜÷ÁÿÏ_İç7–|N„§«Ş4~(zÁ~“»¹ï§%›–?±ßÓÈ[¹ø1Sª]xØköÑKxO^éA€‰rZ+ºÿ»½*ÂWö¯kşwD(¹ø»R:æı\0•§íù'¤Šó“m!OĞ\näÅuè‚Æó.[ PÆ!¹²}×Ïm Ûï1pñuüâ,T©çL 	Â€0}â&PÙ¥\n€=Dÿ=¾ñĞ\rÂšA/·o@äü2ãt 6àDK³¶\0ÈÂƒq†7„l ¼ğBêŠúÌ(ƒ;[ñˆkr\r‘;#‘ÃäƒlÅ”\r³<}zb+ÔĞOñ[€WrXƒ`Z Å£†Pm'Fn ¼‰îSpß-°\0005À`d¨Ø÷P„ÁÚÇ¾·Û;²Ìn\0‚5fïP„¿EJäwûÛ ¹.?À;¶§NòŞ¥,;Æ¦Ï-[7·ŞeşÚiÅâ-“ÖîdÙ<[~”6k:&Ğ.7‡]\0ó©ûë–ù/µ59 ñÁ@eT:ç…˜¯3Ådsİú5äœ5f\0ĞPµöHB–•í°½º8JÔLS\0vI\0ˆ™Ç7DmÆa3e×í?B³ª\$´.E‹ĞfË@ªnúƒ‰bòGbÁÏq3Ÿ|üšPaËˆøÏ¯X7Tg>Â.ÚpØï™’5¸«AHÅµ’Š3Sğ,˜Á@Ô#&wµî3†ôm[ÏÀòIíÑ¥Ó^“Ì¤J1?©gTá½#ÏS±=_„‚_±	«£ÉVq/CÛ¾·İ€Î|ËôáşD ƒg>Ü„õëé 6\rŠ7}q”ÆÅ¤‹JGïB^î†\\g´İõüœ&%­Ø[ª2IxÃ¬ªñ6\03]Á3Œ{É@RUàÙMö v<å1Š¿‘¾sz±uP’5ŸªF:Òiî|À`­qÓ÷†V| »¦\nkâ}Ğ'|gd†!¨8¦ <,ëP7˜m¦»||»ÿ¶IAÓ]BB ÏFö0XÏú³	ŠDÖß`W µÁqm¦OL‘	ì¸.Í(Áp‚¼Òä¶\"!‹ıª\0âÍAïÃô‡‰ÁV€–7kƒŒM¸\$ÓN0\\Õ§ƒ\"‹f‘á Çëñ È\0uq—,Œ 5ÆãA6×pÎÎÈ\nğÎjY³7[pK°ğ4;lœ5n©Á@â\\fûĞl	¦‚MöùûPÁç3®—C HbĞŒ©¸cEpP‰ÚĞ4eooeù{\r-àš2.ÔÖ¥½ŒP50uÁ²°G}Äâ\0îËõ¨<\röœ!¸œ~Êıµ¾óñ¹\n7F®d¶ıà“œ>·Ôa¢Ù%ºc6Ô§õMÀ¥|òàd‹û·ìOÓ_¨?J„æªC0Ä>ĞÁ&7kM4ª`%fílğÎ˜B~¢wxÑÚZGéP†2¯à0ü=*pğ†@ˆBeÈ”ØÏ|2Ä\r³?q¸Ğ8í¸ë±ñÍĞŠ(·yráö 0àî>œ>ÀE?wÜ|r]Ö%AvàıÁÅä@+İXÁªAgâÉÛÿsû®CĞûAXmNÒú4\0\rÚÍ½8JİJğÇ¸DÒšó´:=	•ğó‡ëÆS™4¯ñF;	¬\\&Öè†P!6%\$iäxi4c½0Bá;62=ÚÛ1ÂùÌˆPCØåÂƒmËÍ“dpc+Ò5Šå\$/rCR†`£MQ¤6(\\á2A ¦¹\\ªŒlGòl¬\0Bq°¤P¯r²ûøBµ‰ê›Ñ‚¹_6LlË!BQ‰IÂGÀåÜØğXRbs¡]B—Hrã˜`ÎX‹ä\$på±8ğ„•	nbR,Â±…L \"ÂE%\0’aYB¦sœ…ÍD,!Æ×Ï›pN9RbG·4ÆşM¬Œt…¸œ¬jUô¤À§y\0ìİ%\$.˜iL!xÂìÒ“Å(Ä.‘)6T(’I…ìa%ÒKÈ]mÄt¥ô…ú&‚óG7ÇITMóBú\rzaÂØ])vaˆ%œ†²41TÁjÍ¹(!…¬Ş¡¨\\\\ÆWÂÜ\\t\$¤0Åæ%á”\0aK\$èTšF(YàC@‚ºHÏĞHã€nD’dÃ†Wp˜ÉhZ¯'áZC,/¡\$û¦£—J¡FB¨uÜ¬Q:Î¥ÂAö‰:-a#”ì=jb¨§lÕUg;{R°€Uº±EWnÔUa»Vâî•Nj¬§u‹GÉ*¨yÖ¹%İÒ@Åï*Ìä«ÕYxê±_ó²§z€]ë)v\"£çRÕåL¯VIvê=`›¾'ª°Uİ) S\r~R˜•™\ni”Å)5S¦åD49~Êb”;)3‡,¦9M3¯HsJkTœÃœ‡(¢†ú—uJ‰][\$uf¨íob£µ¹\n.,îYÜµ9j1'µŒ!ö1\$J¶‘gÚ¤ÕŸÄ†U0­ÓZuah£±·cH¥,ÃYt²ñKbö5—ë5–’/dY¬³AUšÒ…©‹[W>¨_Vÿ\rˆ‘*·õ©j£§-T±… zÖYÊd•c®m‡Ò¹±Ø:¹€üË[Ut-{ªµıl	£i+a)».[º•_:Ú5ähƒò­WÂ§Ém»¥%JI‘´[T«h>š®µ·°•™;ËXÌºdêÂŸS›d‰Væ;\rÆ±!Nˆ“K&—AˆJu4B…ÁdgÎ¢.Vp¢ámb‹…)ÇV!U\0Gä¸¨“`‹Ğ­\\…qâŸ7Qöb«VL¥Ş:äÕ‚úƒó¬Z.­Nò˜Ä*–ÔU]Z´læzë…Îöù®ÇR D1IŸåÂ£Ñr:\0<1~;#ÀJbà¦ÊM˜yİ+™Û”/\"Ï›j<3æ#“–ÌŒêñ¡…:P.}êe÷ïòD\"qÙyJıGŒû·sopŒ¯²şXŒ\rİ³d–Ş\rxJ%–í‰ÏÆ¼O:%yyãÅ,‡”%{Î3<îXÃ¸ÏÌ÷¯zÂEÎz(\0 €D_÷½Ÿ.2+Ög®bºcÚxìpgŞ¨Áß|9CPûî˜48U	Q§/Aq®İQ¼(4 7e\$D“‰v:ŒV¡b×ûN4[ùˆiv°Àê2ñ\r•X1¼˜AJ(<PlFĞ\0¾¨€\\zİ)ÑçšW€(ü4ôÈÃÚï¢ p•™ÓõÊ`µÇ\r³da6”¯üOÖímña´}qÅ`ÂÀ6Pƒ'hàç3§|š’îÃf jÈÿAæƒz‰ø£+ŒDŒUWøDíşŞ5ÅÄ%#é°x“3{«¶L\r-Í™]:jd×P	jüf½q:Z÷\"sadÒ)óGØ3	¤+ğŠr„NKö1Qş½ç†x=>û\"¤°-á:ÊFÍõœIÙƒ*í@ÔŸÇy»Tí\\Uè¨ãŠY~ÂŠ‰äâš‚3Då€Á™ã¨f,s¢8HV¯'Ét9v(:ÖB9ñ\\Zš¡…(‘&‚E8¯ƒÍW\$X\0»\nŒ9«WBÀ’bÁÃ66j9Ğ âÊˆ„ƒ?,š¬| ùa¾g1²\nPs \0@%#K„¸€ \r\0Å§\0çˆÀ0ä?ÀÅ¡,ä\0ÔhµÑh€\08\0l\0Ö-ÜZ±jbàÅ¬\0p\0Ş-Ùf`ql¢ä€0\0i-Ü\\ps¢è€7‹e\"-ZğlbßEÑ,ä\0ÈÌ]P ¢ÚE¶‹b\0Ú/,Zğà\rÀ\0000‹[f-@\rÓ¯EÚ‹Ï/„Z8½‘~\"ÚÅÚ‹­ö.^ÒÎQw€ÅÏ‹‚\0Ö/t_È¼ÀâèEğ‹Ö\0æ0d]µ€búÅ¤‹|\0ÈÄ\\Ø¼‚¢íE¤\0af0tZÀÑnJô\0l\0Î0L^˜´Qj@ÅáŒJˆ´^¸¹q#F(Œ1º/ì[µ1Š¢ãÆŒIæ.Ü^8»\0[ŒqØÌ[Ã‘l\"åÆ Œ€\0æ0,dè¶À€Æ\rŒÌ„cøµ{cEÁ\0oâ0¬]°\0\rc%ÅÛ‹—ğˆ8½w¢åÆZ‹µ-Ä\\ºñ{ãÅÖ‹Gª/\\bp„…@1Æ\0a²1ù‹ÈÏÑsã!Å¨Œ/î/Ì]8¹‘~c\"ÅÛ‹Åş2ôcÎ‘m£\"€9Œqš/\\^fQ~cÆ_‹£Î-\$i\"Ö\0003ŒË¬¤fXºqx#\09Œ—Z.´i¸ÈŒ@FˆŒ‰3tZHÉ \rcK€b\0j’/DjøÉ1¨ââÆIh´aÈñv€Æ©OZ4œZòÌÑ‚#YE¨\0i–.hHÒÑsX/F<‹Ï†.äjøËñ­bèÆÍ\0mV/d\\èØñ‹b÷E³‹£3T^(İÑˆcKFR‹Õù‚ô]X¶q½¢øÅà—’6Ô]hÓñc6EÄ‹ó66Üh‘Ÿãn\0005sn/dn¸Ô`\r\"ÑFŒ³Ú-D`ÈÕ‘‹ãN€2‹Y”¤bxÀñ”#\\Åë‹‡V3x·1x€FxŒ¾\0Ê6Œb°q£ƒÇ!8|^‚ÌÑubåÆàÕ-ôrØäq¼ã:Æé%ö0Œppñ”#Ç‹¢\0Æ6ÔfÕÑÇ¢âÅ¬dÒ0„qH´±¾£\$Ç@‹qò-¼^B4±¦\"ú\081ª/lnxÏ‘ âêG3:0tjhÒ~@Æ¼¥¦3¤vHÆñ¹bÜG(e„4gØºqÂã2Æ1ŒÉ-ŒnXËñº\"ãF<Q1\\j¸¸1®ãÈEÇ‹Çä³4m¨Õñªã[ô‹nÁz7üyhŞ1§#ÆŞ/‚3\\xĞqÍKG‚ŒÿÆ6äo˜Ñ1{£°FJ×š6¼lXéqâ£„Æu©Ş9œr(¿1Òã‡Gc\0Åf:„rX½ #ĞÅ½\0iŞ<\\}×ñåbîF½\0sÖ7Üy2ÌÑæ#uFe›\">4iØÅ¿âÔÆçŒé\n<{¸ã‘£âÆ‰ŒJ;¬]ØÄ1Å#ÎÆ0ÙJ;4^èÂD½ãóÇ®‹Ÿ¨³4i¨À(H#ÚÆEŒx–/¤nøû1ğã/Ç¡‹åj6,l˜Û1tã/\0005%ï0„]xü‘¶£GG5!’0¤€¨×ñÚâé–rŒq¢2Ì¨Ş‘ÎãNFPo\"4ô_˜·1×dÇ%‹e ²3¬s8é‘üã†G5“ æ6Ô[Hë“cØHjYš;ô[è¾‘˜bë! yò@Ä\\¸½qØ#WHN‡;ÌcÆQèã:Ç-%ª.œkXÆ‘ı£ÚGÍŒÏ†1Df¨ß‘ºcWFl¡!‚0ü€™²c EÜ©;l˜Ñq\"ëF©ß¢7\\\\¨ùñâ£ÔÆO‹qş.T|\"?‘ñã™ÆE³f9TyYÑ©ãSG1ûÂA\$f9R\n\"ŞÆxŒ¹>Bœ…HÚñß¤\0ÇŒ¶:\$e¹1œ£³F?=º3Tu)\nq¹béÇ~ËÎ<TøÎ±Ğc‰H.‘m~CôwHÊ±¸#/ÈI]~3ä^ˆºÑ„#§Æ>‘Y®4Œ^¸ÎQjcÊÇKŒ1\"Ò8¬|6Ñåc\"ÇB‘µ\"b4ãèæ%œ¢ÔÈG\0e\"’/t‹¨´1r£1Æe!v2„yÀ±õä<Ç †8\\o¨ÊÑ’#tÅÑ\rz@´}HÂ‘èbïÆèy î1Ì\\¨ğëdeGÁZ3Œ~ér)ã1È¿‹Û†Bl~H½²:£dF£‘-Î?”k8´qèc(FÍ‹ŠKŞ5|myñ€c1Æ<’*@´jØáò1ãÛÅ¾Œ‹>I´ZèÍQjä•È2ŒÉ\$0¤‹hµQˆäVFTŒ	\$ÆAl~öqÚ£È±\$Ö>\\pÙ\rq‚\$/Èu%ï!®Jq \$ ãtE²‹GN-Tq)ò\"¢ÛHÊŒË¦=ì–XÉ2-£H’«š8\\nˆµRW\$HŒë\"¢C\\_¹\0»d\$Çf‘³\".D„u	'Q£zEíŒÙ&0toˆóqjãúÆ¿Œ³R@d—øÉä£ùÇu##¶LLkÉ*qó\$*GÄ‘iÎ@TŠi‘lãòEª‘ƒÎ5Œ˜¾r\\d–I–‘µ\"/ÌZÉ0’j\$TÅşŒz5Ld3’£ëÉ’oÂ.Tq¹!1{£Æ‹åÖ9œZ¸¾QÕbÓFŒwJ94nˆÒÄÖä{É(“-8·2h¤uÈé“;\$†-Dkøårs£‡H™#¡‚ôY7ò\"Ø/E¿’Ó 	\$j¢^ò-£]Ç7[\"N\$’èÂ‘“¤WÈ‘¯Ö/]à\$²+€1Ga/&IDnøÂ’@\$åÆ!‹ç\$Î-Œk!Q¨âùÊ)(N/\$t¸İ¹äëÆOKzP´tXÜò[\0’G’w(*K\$vˆË1ócÉ'“ŞGÌIòxd­È\n“AÒ8\\rX·Òa£÷I”iNœI%\$½ã’Æ_‘÷ª6¤fçQş#–ÈI”5#F´—ØºñÏ#³Eâ’•\"î3\$¢IÜc‡Hˆ‹İvR|ùQ€¤cE¸ñ:R„eº±hä¶EÎfK`8şr.#·E³s®0L…˜üRä†F©‹·!\nC\$`Èöñ´\$ôH?’ËnPÜe™!ñš¥@F'”¿–/œ‡¸¶ÄÖäÿÊ”¯%ÂN,hÈÌrF\$öÈşŒÇ3´tøæÒ€¥Åæ’!1<„ÉCQÏ%ÉÃ’¹æJäZØf.İ6Å†œ·±C‰¥ÊÔœ.²[ş™BÒ¿xëàƒè\0NRn`šÈùY\n’%+N¨IMs:Ã¹Ydƒef¬B[¶°İnÆ¹YŠòm¨ÁR®×’ûÉY¯ÚC„XŒëÛj³çU+Vk,¯\0Pëıb@e²¹¥x¬„V¾ºyT¤7ˆuî«[Jï•È±\nD¯§eR¿¬mx&°lÀ\0)Œ}ÚJ¼,\0„IØZÆµ\$k!µ¨ñYb²Áœ°€RÂ‡e/Q¾Àk°5.Áe‘­5•À¨W‘`ª¥\0)€Yv\"VÂ\0•Ã\n‡%—å–`Yn¯Õ¡aôÔxÃ†Q!,õ`\"‰	_.Ÿå©Æ–tm\$•\"“²J«¤ÖÀ§vÆ%‰M9j‚°	æ–§Ä*³KpÖ”’;\\R ¼ü3(§õŠ^¯:}–Èï|>Âµa-'U%w*‰#>¤@Ì¬e–Jÿ¤;Pw/+¹á5E\rjn¡ĞÃd–ô¢^[ú¯§cÎ°¥uËz\\Ø1mi\"x‚„påÃ;£ÌîˆæˆP)äøªÇ#„±Ø’¡…Ë!Aª;¨ß	4ì³a{`aV{KUàÊ8ã¨Ÿ0''o€2ˆ¨¢ycÌ¸9]Ké@ºÒ—^ğlBˆâOrëÔã,du¤¾8¤?õ‰€Õ%¼gB»ˆî‚ÆYn+ã%c¬e\0Œ°ñà¤±Yr@fì‹(]Ö¼¨\nbizîÖn€SS2£ÁGdBPjŠ¹Ö@€(—È¥¦!à-çv²´eÚ*c\0„ª4Jæç‚’ùÕÙ,“UÈ	dºÉeğj'TˆH]ÔŠÔG!œ)u‹ÕÖ¯Ÿ•Ò¯ùZËB5ûÌ“W‰0\n±á¡ÔR«ÁW…\\¦Q jÄ^rÊ%lÌ˜3,ÒYy×Éf3&Ì•ÜÕQ:Ïµ2„mÉR)”T€¾(KRÁ 0ªÊ”@«ìY´¢Y:£Ùe3\r%´¨°Tö%­X”Á¹‡STÔ.J\\ë0ÙhôÄ…ŠD!Ä:—uæêÉU\"¾ÅÁo+7–\"„µ“f'º­R\0°‘ŞJõ2S–2è#nm »ÁIåŠœı\"Xü³²[Ö€Ñì} J¨¯c¼9p0ªüÕQ»(U\0£xDEW‚Œ.LõÁ=<BÔ0+½)ZS V;â\\âµI{5I‘AôÖÃ,dW²uè5Ew\n\$%Ò…ˆ½2i_\$ÈÙ+ìæO,Œ¬‡íX‹´Õ‘Jg&J¡úG’º%\\J“·b.Äİ^L‹TòFlŒè–¹]k#f@L·G€ÄT¼Ù—ÒÍHÏÌ\"–q1SÌ°ù‰jVÉ(Î™„ìZVzßÅ†³,§ÊèG.1Fû±gNÊ;×1ÃŠV¬¦5EÍò5`ò\0Ctè=F\ná¹›Î±•K‡ş™Ö\0­ÛŠ±%¨ËD]Q\$\r\0‡3J\\,Í™š³<T4*£™Á.ÒYK²D«QƒéLïS%,ŠgÔÇåª§Ö<Ëë™u0–ôÍUÄ‰Ö*x(©åNÂ’Yv!ş¥yÍ	wÅ4fdª¥rG•‰M \$äê‰^;ºéîİæˆ)<Pã]DÒ%%Ó;ÔjÊåšI0æaÓu^Jp—[)¦v©3RhRúEöÀ\næ–L_š#5|Ü¾Õm3Pñ*¨\\Y51X’’	i³N—Èñ\$\"°ºaü­õh*KUİÌïV8¨åuò±%&„ræ¯Ëš ²5oŒÕçg³;İrMl[Æ¨ögœ³ùª’·UÍq™ê¹šh|ÔeO2·f MlW2AP„×¹˜’ÍÀÍv~eD¬eñ3UÓ«l‡E62iüÎõìÓUbÌï˜¬«õUŒ¬©¨îøıªVğêiI!\$i¨Ê­&Z:½–xm!Å†“.ÖOÍfwÒ¯!”ÌÓkİ¤Íƒ™6b\"«I™J]]:T™6ÒVrú¹}’ÜÇ«]™®±‘U¢	ys7fÔMÅ™ÿ3ˆŒÜÎYœó:T_MÍw%3ÆnÏ¥\nÎæz*™í3âhƒ·	»`U–²Lÿš‡,¥Û„Ğ5¨óvfƒ»Ã›Ù42_Q‰¼hİÇÍuD§\no£¹)¤ÄœÕ«M9¿7foÛ¼©¤rÖİÇÎWB~iTİeyQTâN\nšd¦pr§#›óM§;’˜…4æpª¼„têÿ–(;š›³5	|¬àÇ‚Š­',AV7Ü”ÔåUAö&ìÍRœP¯\"äÕy‡Ò·•‰) [ŠnÌÕñ-3V•Ë,?œs6ºpŠù†3fµÎAšÛ9k|İÉ®S†f¬*@œ•5Şg¼¾É¿2·Í}œŒ®şUüİ™‘ğùæHÎF›l%®pÂ«Ie³be—MÙSO\r[¼æi²3fÉÎLVá®rÙu®Š¾¥ÛNA›:î%r„Úy3Q_Ì¸›W.ÑÕÈ^Sl@&ÌÁ5ÖYlÂÌ1åæÎ}VxêgÊ…§^SnÕÌÍQ!:5×ZŞiZCÔˆ:¿›•3qgé%Dáõİª{U¡3’tZ¹`ûÓu%w:ÉZQ:QìÏÇW fî‡í›¿9Jplê)Ö3xÔvÌşK7b#«ù½«çX+Jš(¢Âh´ìP*Ó´«Î›ş¢!×”ìÅSLçh*'¤¨\npBù™ÚªgNÊ§8BuÒªéÂ¯çÎŒ½8niêˆIÍs¸USÍIš‡;vvÚ³UõsR•7Nu×8©H|íéÅÓ·§Ìœ«8òq´ÕÙŞ+'ÑßÍ`œx¢9Rˆ	Õ®ºçMaR8úxä)¸'!Ïœ;±U¬×YÖ“’İsNIg:ÕKTëy¯3®gÍYìëÊkäãÉÜ³n'LO(œ¿3šw4ñ4î»¦ÇÏœÚêşl¬ñÎJ½–ªw½9İ\\ìç•óóhf(¢_~ìòà}9Nö¦Õ\0–´åb\"¢Yé¤ƒTh,Ú¤@ú±D¡û€\$€I·;eüèUÊn¨³·,¹OªÆ	Xÿg´-ÀÉ+>ti'G‚ölª%\0­8âVBËU1«ye\0KTÆ4ûÁÈm’ºV2)\r]I/\rFù…ÔXˆ×Àß¨ña·­GŠÂ¹ò*ˆ§»ÿ>ERì÷ğî®¥‡ÑZ›-)I\$®¹íç:¦aË\0¾FybaÙg«w§­(ß_@§v}öiõÊ³î€S^Ë25DÔ³Ğ	ÈôURO±ŸJHÖ\\ØisğfÆËKšN±€qi÷Sg×OÂŸ\n²F~|«µÏ*@gR€_Q<9sÜ¬3i+Ø—².Cw²²ê|‚øyË6aìOÜY9¶Œ¶É–\nëÔ½-([®±†_ˆ}íSû]c¤S=Â¤ÎÙşÎÍÔYÎàU-> <ú©µ\n<ÖsOôQ4F¦^}\0007uäk(/‹ŸÛ/5{Lÿ9µ\0§¬Ğ &³Š[<ÏõŸsÛ\0&Íè#…@hÌéª3©V}ĞH¢Š*Üw+]'DĞ& @§Ö])µè;TGe3\\Îên®ÑßËd\$:¦uN4Åyktê-dR!7–­Ée4(P!•Ÿ-ş9À4ç_PMGbÄ±w…«ØÉ6O§S¦F‚âí)§Šyh0+€²§qT|·Š+uÔÿÎ+ A¬?òŞ	öTè3.q 41T´¸e›€\n:P ø¯–{Tî\n³ëh?«šTïAùS£­*«åÒ+åu¥>ú\\ê¾ZéíÊîYì·¢wEJö%·’s—L±¾dªšyÀ+\rCèœß¡'Añl,Òyå3şç²ËÍ—`º	_*ÑPû ThKDV²·–~5	à0´+á¼,š-?­]œºò3ëÖKå—`¯^†¸¤I42(]ªw.æ†rÄÊËê]¬\nYÆ¨B†£­Ğ	³í–}Ğ‹R ¾ÉgØ}:H§ğJÄWP²ê„\"Şµ—ğôV\\¬<——? >½å—áÿ§Ü¬İ†¿=¦…:Ÿ\n0×è\\+ñS–´æfİUŒ³í‰U,…WCÖˆè•On¨òÎ…¢§.†e9|R÷I'©[×/º²ÄÙü2ù›«QÓBn:ÆIõ\nö§g¼9Æ\rü,ÓR6³ıçÒQ\$Xİ+¸>–©±`\nù)/_8QiÔùµê—=‡êv?5v\0 \n¨çÉLG¥Dmˆw\\ëFÖŒ‡Ñ¢¯ÁdêŸµ}s‰\"‘ÃYv¤|â™J*´9h­¡Ñ@XEUÑ*Ş(oQ]\$Bˆ,ûéÜƒ•KTœv¤AptCÉƒ\n×C,/˜<¡­Ú™EW‹-VïP¡¢=Wÿ*%Kê—-Q`9	(Êú59Ó€èm)ËX¸¨@ç2ø ıT@ˆÛ\nS–¯‘bd×EÎ´a€+€DXîá|UÚ	‹	’¡F® 2ú%5\nj•m«€WÙ+xêKŒæVÌ3#„¶CTÃek¤™–&Î,£l¬jbd7)Ó“\"\n+ìPüºb’èIŠ@è3Ñ•ÜµjUÒÌEsŞÔ)D¢fë’ƒõŠû•ÇPZ3AÎŒÕ\nwThğ—²ªÛ˜Å4Zäª<Êuß©ßdqâËŠu(÷“bKG±à¥éÀnÓTï®ˆ]z¨f%#3IËfS¨®&}µ@D†@++ù¤Aíhª¿\nªï€U—Ş¥|B¡;”…UmÑÙU…E•N¥!ôx2±1Ò\0§GmvH~õÁHèTê)öW®³YNı\"åk5©ÑvT#=µÚ¥Ê<\n}‘#R3YƒHÅRÍIÍ³Ü¦;ÌÑRl£1léuB%TQJî™*ºêˆÙ'ºEë0i¬dw,¥zÊÍ¥:\$†¦;Í? üîj‘¿)§ô)ÔÊ\$32J}Å&‡[³\$¨õÌ¤;DnıE×´À+0ÛaZ{¨èC èû€(¤ê:“¸ ÚO@hø²D£æ\0¡‰`PTou“³ÄïF®\rQv‚û¨˜o½Ü¡\$Sîö+˜Ò#7À¤Izr…pk DW”ˆFsÍ9™ Qê  Ğ°1€gÀÅ#•\0\\Là\$Ø 3€g©Xyôy œ-3h›ÀşÃ!†nXèô]+±—	É€c\0È\0¼bØÅ\0\r‰ü‡-{\0ºQ(ğQÔ\$s€0…ºém(°[RuòVÆ÷ÒØ>Æ¼+àJ[©6à‘ÒàJ\0Ö—ú\\´¶ã,Òé‚Kš3ı.ê]a_\0RòJ Æ—`š^Ô¶ClRÛIKî–ù\n \$®nÅÒä¥ïKj–©\n€šÁ©~/¥ªmn˜].ª`ô¿ijÒâ¦#K¾˜f:`\0…éŒ€6¦7Kâ–¨zcôÂ\0’Òõ¦/K®–­/ªdôÄé‡FE\0aL˜¤dZ`ƒJé†S‘ÏÊ™…2ØÍ4Î@/Æ(Œ‹Lò™õ0ª`´Ä©†€_Lş™]4ZhôĞ©šSD¦M˜…4:cÑé‹SR¥×M—E4šiò€éSG¦EMj˜å4zdÔÕ©–SFKLª›%4ªeÔÏ%\$ÓlKM2–õ1ÈÚ”Ôi¦Ó©MV›­.¸Ú”Öi´Ó©Lz›/ˆ÷ôÛ£Ó„¦ÑMæ›,`Š_ôàimSŠ¦gMÆœ€jg‘òéÇÓ5¦9.›…9j_òéºS¥µ.›Å9ê_±òé¾Sˆ¦‹.œ7Úrò)ÉÓ%§[2m8ºuTæé™S±§3M:]3ºq”èänÓ±§KNˆ1|^ÒktÏ\"ÒÓH§gKj-;zcñiÎÓš§–\r<ê_²-iÊÓ¸¥ñ\"ÖU.¹´óiëRÚ‘kOFí=:\\ôÏ\$ZÓ©§MLE­5úxôø©ÂÓ»_\"Öœ=<\0ñtéÙSç¦9OÒ­1Š~”öi²Óô§¹Oêí>ê~qœ)òF¸¨’ =6:~ÔõãJÔ‘ÏP:ŸÍ=¨åTÿ)¢Æ«§ÿPJ8õ@êwôô©÷Ç*§ÍOÊ5]>ªt÷£•T\n§å!\" 6Y	)€ÈH¨/Pª…3É	éğ†/‘P~ àù	ªÓ®¨!\"ŸC’ÌÔıj¡ ¨eNJ¡üˆêˆñÔ*%Ô4¦1Q¡ÅCZ‡Q‘jTBQ.¢\rE)\0004Ëê\$€2¨SM+å<j„t¿j0Ô,¦9Q†¡}F\0\$±s©Ta¨KÎ£]Ecj*€'K»M¾—MGx½ÕRÇT1¦#Qê¡¥GªŠ5ª:Ôz¨Lš¡4u6z•\"j\"TˆKuNÖ£ıGÚg\$jFSÜ¨ïQ2¤¥Høîµ\"êMTƒ©%R¤•HzÕ\$ª,Ôw¨Re.\$rªzµ)©ÛÔ¦©-Qö ÍJ„¹‘Êª@Ô°©=R&/IÊ•1†*]T³‹À7¼˜¾QÒåD&Ó©qN¦_(´q²c[TwŒQRôå´œJš\0nâ÷T­¨û.¦˜956cÔÜŒÕSz¥H˜Á•7ªRÔ}Sr8¥NŠšÕ\"bÖTè§ÁQŞ5MNŠ–õ#ãçÔè©ESÂ§-H˜Á7\"ÜTü©_Sê§}GØÌ•?*yÔ©‹‡Sò§½P*Ÿ5#âöÔÜÏT:§]PÊŸõC*€Ô‰‹T:¨-K8Æ5Cª„ÕªR¦--MÈ¾•HªˆÕ ª'T‚¨­HøËõHªŒÔÑ‹×TŠ¨íRª£õ,âéÔÜ‹GTÚ©-SJ¤õM*”Ô©‹UTÚ©mMH¸õMª˜Õ>ªgSD³5MÈÂ•RªœÕHªwU\"©íK8ÕÕRª ÔÚŒ¡U*ª-U*¨ànÂ¾TÙIR­,t¢Z«ÕêY¶IUF«51ª¬µW)vÕk‹_KÆ«pJ«5Zj­Å¯©R4r\n¬^jIÓCKº„‚ª}UÊ“_ª°Ô›ªãO¬=N·R*¯F-ª½R¬%Wš‹Õcê¦Õ\\aV>«EYj–µdªªÔÃ«UÎ¬µWXÍ5*ÈÕ‹’¹Uy‚õZŠ°1kã™Õ¨«7Vš¬R\\HÍ5h*ÖU¢©ÏUÆ§M[Š²±kêvÕ¸«3Vò­}[(ä5WªzÕ¸«iB­Oº®1¯ê¯Tı«—V®;­[øîµpRæGu«;T@0>\0‚ê/I³ªÿW`í]¦ô\0ªîÆ8«¿PŠ¯]ÈÍ1m*ïÕÇyUz¨mW¡õ|ªİ“[«¡Ö¯…]J¬ÑˆêøU±««ö¯…Z*¤5\\j‘Ö«ëZªô`ZÁ5~ª®Eì¬Wú«4ZšÁ5h£QÕ^‹cXZ®•Sú®1o«Vª¹U&«TºÄ5}cU^›Xš°dm*³±’kUu¥«SfG=[¹õjäsÕ¿‘ÏX¦Kc\n®iRâHç«i#±uWt»µª½¥º«»XÂÕcÄ¹•«U†¬”rÚ¢õUZ‹Õ‡ƒNE¢¬‘Xº¬…4ÚÈudê·Eä¬eV^²íKÉànâòV8‹sXÂ¥ÍfÇõ/ÂhJ³-J]Ó‚…™ÓÎÁÕzO›±<Eh‰\$å‹“·¡ó\0Kœë<bw„ñ…>·”øN\")]b£	â+zê.cS.¢iFç	ã£µQNQ«éV*ªéÛÎúŞO[X¤nxŠ¤P	k­§oNø£}<aOò§Iß“Áh·ºšT;òrñ‰‰¤ƒVD6Qß;zŠ]j×~'’:ë–[Ivôó7^Ê‘§ÖÁjëºw[«ùæîºçœÊÅ†¥:u ÅDs#¦¿Î\\wµ<n|*á‰hëmÎKv;YÒˆ±Ú3á]Œ«^#—Zªj¥gy³jÄ§Y,”%;3¾³ÊÚù×.ÈW\"‘Ã\$Ù3>gÚœºÏÓÏ¦ªVTóZj¥hYİjkD*!šh&XzËiª•¥+GV—­\"¥æ¸Z:Ò¤§+‡NoG¥Zjj¥iÉ]ÊkOĞ_­Ö¬ÔmjIª•¨§t¯–#½[âj\rnŠãê©×Ğn™ßZ¥_,Õé†ógÎÄš©:¹¼Å9‰Áÿ«[L2®W=TÔ×0®ãf¶\0P®U6\ns%7isYæ?£¿uá3¾’½nb5¡«Ÿ»šX|G~l•&×k¤¥·M§ †¯ú¶ŒÏy¡S–É)Î]œÜ­r·¶Ù¸µ¸æìÖê›Å?Õ}u'n0W-Î¹®æb·´ÇªìõŸk?»vQı7…Ü}p\nìõÀ’ÍÙ®Z*»9)Êá5Ş•ZW­-ZB¸²Œ:ìõã«ŠW\0WZfp•GpõîÍÙ®:Fpú¤ŠäUÙëSN/™Ï\\©Ü%s9¬S{§ ×8®ÏZÍasÊÛ“’+¢N^®“9™MÕ{…P5Óç ×Q®ÔîJº¢«y§õÕè;œÚîz¸ƒÂÕYÚV Ä3—:ïœDÅIŠÃ+ç‡ı¯£19M;º¥Œ’ô¨“V´®š\rQ{êÉÕ®•¶Å+£ƒFCLÄ¹ŠN¥–©Ôˆ\\ùŞ)\$iŒÛN'\0¦°PŠÂšõÊÇ]XÌ^s1òf&Š\"'<OøóšÌ¡ËL\0¹\"‡@Ö”¥%ä6úÂUAõ1ıi(zÌèİ€\rÒÕ‚ä±ÈbZÀ”+IQOï3€ºË\r=*Ä‰ ‰)ñ¨!Á Ğ`ª¼h°ˆ,Ğ«mGPCËA Ù²íƒA„Œ(ZÅ°%ƒtì,h/Á‰ˆi–Èk¬«¡XEJ6ğ±„IDèÈ¬\"›\nïaU- ›«\nvy°_€ÄÂÂ›Ú«¯k	a½B<ÇVÂƒÛD»/P»ôaîÁ)9Lã¶(Z‚°8êvvÃ¹Øk	§oĞZXkäÑå§|´&°.Âæ±C¹’Øá°`€1€]7&Ä™+™H¤CBcX“B7xXó|1“€0¦ãaš6š°ubpJLÇ…–(·š÷mbl8I¶*Rö—@tk0€—¡¯ÅxXÛÁÓ;ÁÅ al]4s°t¿íÅªğ0§c‡'´ælß`8MŒ8‘ÀÃ€D4w`p?@706gÌˆ~K±\r‚Û “P´…Ùbh€\"&¯\nìq‘PDÈĞÎó\$Ğ(Í0QP<÷°àÀã¬Q!X´…xúÔ5€ˆR·`w/2°2#ŠÀ¸ `¬»‘1†/ˆÜ\r¡Ö:Â²–±¢£B7öV7ZŒ›gMYúH3È „ÙbÎ	ZÁÓJÅöGâwÙgl^Æ-‘R-!Íl“7Ì²Lõ†Æ°<1 íQC/Õ²h¼à)ÏW6C	÷*dˆş6]VK!mì…ØÜã€05G\$–R˜µ4¯±=Cw&[æ«YP²›dÉš³')VK,¨5eÈ\rŞÊè†K+ï1„X)bÛe)ÄâuF2A#EÑ&g~‘e¡y’fp5¨lYl²Ôœ5õƒö¿Ö\nÂŠÙm}`‚(¬M Pl9Yÿfø±ıÖ]€Vl-4Ã©¦«ÂÁ>`À•/û³fPE™i‹\0k™vÆ\0ßfhS0±&ÍÂ¦lÍ¼¢#fuåÌû5	i%ÿ:Fd€ö9™Ø€G<ä	{ö}ìÂs[7\0á¬Î3íft:+.È”–p >ØÕ±£@!Pas6q,À³—1bÇ¬Å‹ãZK°ê±Ü-ú“ar`•?RxXÁé‘¡ÏVïú˜#Ä¤ÔzÂ; ÀD€•¾H²Á1¥’6D`şYê`÷RÅPÖ‹>-Æ!\$Ùù³ì×~Ï€ĞÅà`>Ùï³õhÔ0ô1†À¬–&\0Ãh—ëûI–wlûZ„\$“\\\r¡8¶~,\nºo_áÀB2D´–ƒa1ê³àÇ©=¢v<ÏkF´p``”kBF¶6 ÄÖ²—hÆÉT TÖ	‡@?drÑå‰€JÀH@1°G´dnÁÒw‡Æ%äÚJGšÒ0bğTf]m(Øk´qg\\í½ó¸–¬ë°ê ÈÑˆ3vk'ı^d´¨AXÿ™~ÇW™VsÂ*¼Ê±æd´ûM À¬@?²ÄÓ}§6\\–m9<Î±i”İ§›ˆÔ¬h½^s}æ-¦[Kœs±qãbÎÓ-“öOORm8\$ŞywÄì##°Œ@â·\0ôÒØ¤ 5F7ö¨ƒ X\nÓÀ|JË/-S™W!fÇ† 0¶,w½¨D4Ù¡RU¥T´’îÕğZXÇ=í`‰W\$@âÔ¥(‹XG§‹ÒŠµ—a>Ö*ûY¶²ˆ\n³ü\nŒìš!«[mjœµŠ0,mu¬W@ FXúÚÎòğü=­ (¦ı­b¿ı<!\n\"”ª83Ã'¦‚(R™İ\n>”ù@¨W¦r!L£HÅkÌ\rˆE\nWÆŞ\r¢‚'FHœ\$£‹ääÀm„È=ÔÛ¥{LY—…&ÑÜ£_\0Æüİ#¢ä”€[„9\0¤\"ÔÒ@8ÄiKª¹ö0Ùl‰ÑĞp\ngî‚Û'qbF–Øyá«cl@9Û(#JU«İ²ƒ{io­‘¥.{ÔÍ³4ŞVÍŠVnFÉxğÑüzÎ QàŞ\$kSa~Ê¨0s@£À«%…y@•À5H†NÎÍ¦´@†x’#	Ü« /\\¥Ö?<hÚ‚ù…¼ITŒ :3Ã\n%—¸");}else{header("Content-Type: image/gif");switch($_GET["file"]){case"plus.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;";break;case"cross.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;";break;case"up.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMQN\nï}ôa8ŠyšaÅ¶®\0Çò\0;";break;case"down.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wş\\¢ÇL&ÙœÆ¶•\0Çò\0;";break;case"arrow.gif":echo"GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹”ªÓ²Ş»\0\0;";break;}}exit;}if($_GET["script"]=="version"){$kd=file_open_lock(get_temp_dir()."/adminer.version");if($kd)file_write_unlock($kd,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));exit;}global$b,$g,$m,$gc,$oc,$yc,$n,$md,$sd,$ba,$Td,$x,$ca,$pe,$tf,$eg,$Kh,$xd,$ri,$xi,$U,$Li,$ia;if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");$Rf=array(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba);if(version_compare(PHP_VERSION,'5.2.0')>=0)$Rf[]=true;call_user_func_array('session_set_cookie_params',$Rf);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$Xc);if(get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("zend.ze1_compatibility_mode",false);@ini_set("precision",15);$pe=array('en'=>'English','zh'=>'ç®€ä½“ä¸­æ–‡',);function
get_lang(){global$ca;return$ca;}function
lang($u,$kf=null){if(is_string($u)){$hg=array_search($u,get_translations("en"));if($hg!==false)$u=$hg;}global$ca,$xi;$wi=($xi[$u]?$xi[$u]:$u);if(is_array($wi)){$hg=($kf==1?0:($ca=='cs'||$ca=='sk'?($kf&&$kf<5?1:2):($ca=='fr'?(!$kf?0:1):($ca=='pl'?($kf%10>1&&$kf%10<5&&$kf/10%10!=1?1:2):($ca=='sl'?($kf%100==1?0:($kf%100==2?1:($kf%100==3||$kf%100==4?2:3))):($ca=='lt'?($kf%10==1&&$kf%100!=11?0:($kf%10>1&&$kf/10%10!=1?1:2)):($ca=='bs'||$ca=='ru'||$ca=='sr'||$ca=='uk'?($kf%10==1&&$kf%100!=11?0:($kf%10>1&&$kf%10<5&&$kf/10%10!=1?1:2)):1)))))));$wi=$wi[$hg];}$Fa=func_get_args();array_shift($Fa);$hd=str_replace("%d","%s",$wi);if($hd!=$wi)$Fa[0]=format_number($kf);return
vsprintf($hd,$Fa);}function
switch_lang(){global$ca,$pe;echo"<form action='' method='post'>\n<div id='lang'>",lang(19).": ".html_select("lang",$pe,$ca,"this.form.submit();")," <input type='submit' value='".lang(20)."' class='hidden'>\n","<input type='hidden' name='token' value='".get_token()."'>\n";echo"</div>\n</form>\n";}if(isset($_POST["lang"])&&verify_token()){cookie("adminer_lang",$_POST["lang"]);$_SESSION["lang"]=$_POST["lang"];$_SESSION["translations"]=array();redirect(remove_from_uri());}$ca="en";if(isset($pe[$_COOKIE["adminer_lang"]])){cookie("adminer_lang",$_COOKIE["adminer_lang"]);$ca=$_COOKIE["adminer_lang"];}elseif(isset($pe[$_SESSION["lang"]]))$ca=$_SESSION["lang"];else{$va=array();preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~',str_replace("_","-",strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])),$Ge,PREG_SET_ORDER);foreach($Ge
as$A)$va[$A[1]]=(isset($A[3])?$A[3]:1);arsort($va);foreach($va
as$y=>$xg){if(isset($pe[$y])){$ca=$y;break;}$y=preg_replace('~-.*~','',$y);if(!isset($va[$y])&&isset($pe[$y])){$ca=$y;break;}}}$xi=$_SESSION["translations"];if($_SESSION["translations_version"]!=2436906165){$xi=array();$_SESSION["translations_version"]=2436906165;}function
get_translations($oe){switch($oe){case"en":$xb="A9D“yÔ@s:ÀGà¡(¸ffƒ‚Š¦ã	ˆÙ:ÄS°Şa2\"1¦..L'ƒI´êm‘#Çs,†KƒšOP#IÌ@%9¥i4Èo2ÏÆó €Ë,9%ÀPÀb2£a¸àr\n2›NCÈ(Şr4™Í1C`(:Ebç9AÈi:‰&ã™”åy·ˆFó½ĞY‚ˆ\r´\n– 8ZÔS=\$Aœ†¤`Ñ=ËÜŒ²‚0Ê\nÒãdFé	ŒŞn:ZÎ°)­ãQ¦ÕÈmwÛø€İO¼êmfpQËÎ‚‰†qœêaÊÄ¯±#q®–w7SX3” ‰œŠ˜o¢\n>Z—M„ziÃÄs;ÙÌ’‚„_Å:øõğ#|@è46ƒÃ:¾\r-z| (j*œ¨Œ0¦:-hæé/Ì¸ò8)+r^1/Ğ›¾Î·,ºZÓˆKXÂ9,¢pÊ:>#Öã(Ş6ÅqCŠ´Iú|³©È¢,(y ¸,	%b{µÊ¢°µó9Bƒ’)BƒßŒ+À1>îPŞµ\rÒÊü6¹’2šL€P‚2\r«\\*ò©Jb=mèÂ1ŒjHæá¤O\$¾û„ºğ4 ªjF÷oƒäâF4 #0z\r è8aĞ^õ\\N-ûº³Œá|ŒÑ”pä2á€\r«:x7Ë<ĞØµáà^0‡Í#2Œjk6¸µ@îƒÂ­Š„´âØÎA&2óu§\n®1úİlÄ +Äãs‡	„©Ä<³ MÒ]lì&!ãb_2Š»Oz\r±£a7¬Âö1 7òòãÃëiÚÃ\rìÓŠvŠÃ¨İbÀ«äÜ3ŒèÎÎc2ŒN1\0S˜<ğÔ=€PÈ¤Ï­c†å%­°¨à»šÿÍØÃ_ŠaccC ã˜Ô\n\"`@×_®dº7Ã(æÓ[V¥nÌ6–¬9ä‹Âh8kÑ/kË¯K,“)‰+Z\"Êó°Œ»†‹åÔ¦\"MF»³¯¨¾'iÊŒB\r¿ƒ0Ì6NRLÇDB ŞMpò¯–tûFŒØ^s1·t„!Íº\n×p»7}K€´`O-Ìdüâ>Oİ…6t¬¼P‘cı_W×6W’P½ØpÒˆb˜¤#2ãx×#Á\"Ö2ğI]xPİÉôLïÜtZP*1nª}\\Ú¯Í7Ô«õ ×@™}«I1T­/LÓtí>¨Cº£N	ÉS‡%RªÊ9W¹XƒèÈj¾X	F±”IŠ@·“ÆïË©-d •\$õª«Räƒ\$Õê¿…(T²˜SJqO*D©  .U\nª\$TsÍÆ°h\$‘Ğ F‡ü7’0ššá=©4›(ŸÍzw=G²%’š‡é¢>nUí'¸¡I3BŒ`9>ÄhHCfknyÜº(AûÙl…4¸4šƒK0ÆE„Ê[ÍúB?Ïhô·bj€H\n-Èb|\n\n\0)\$D‘<’Lh‰Bô\rÆıŒ×¢dq2¤…»ã@yÉ‰3……è7<— kcù°!°Ã>‚üO	ñ#g¹>ºÈôëƒ2	lù(S>É\"QiS+ÀÏ&Œ~M)%d´—›ä6…Oì±0’<’œpÈOŠz}&°²HcÆZØ\$H\$‘A‹¹!–õìó@@C‰³*\$Á“á#ÑÙdxñÏâ|{Œ«çrëÀ´É\0Â£W/T)U5hÒBZ³Á±P×´_¡%9ÁÉE’î@XÁ%)¥œÃ2G‰TT)´’H‚Œ™#ÁRI´åÂÜéx ˆÌƒ¥\"üPÕ±i;/M'\0£\\L©je	á8P T *­‚\0ˆB`E¬Mz¯s}\r:Z¥‘-\n¥sN0gg<±±”&›çÑÀ%!¼ÕËjŠ9ØTuZ˜Ùi-]Lôï7ã,bÍRHÇÁ©fÄ\\2Æ²Í±\"xN˜P0n|Ÿ9¢‚²'(ı	 ó8~Ha>JrD“ş`Ã¨g\rBIID!‘Òbc’<ñ[Òbál•zUˆåMµ'KíÌ““h!K¡ÎØ÷”H[Zh„Œ´<¢vHVºÙ\nÁ¥l]…¼^ÙxxC-i\n–»ò†B™Iöì@dVÕKòn„Ú¨†z¦K(T-,9Wüï‹I•JB*ó`ÎKZ/	ìï1Etg,Z‰NHL\"˜Ó`‡¤o(‚l%JÂC	\0‚€—ëé0däûO²Y„S¶^=FË¼‚HLw]Ù@Â!0¢lİùOXÀ„ğ–¤~Q\$N:ğÂÀ•Ëó›ËA.½˜2¡…Ìa›2Æ3ÓÌç”ù­Ø…ß’³UúÍ—‹7°]”ñæXÇè/-èL¼]t°f‰Ä¦å&Q	Á§	wL‚:GóÓŒ<ˆáÆ0AjhrJ`(+†PÄo?'<)1mdÄÈpHGd¿Å’a5ØlÍY\n€ ’Ë9egÙ*j”Ã‹hI3¤ÀÅ“ë4vYyÈ–{H°˜£Å5,ÙXûoi¤«¸É»/×‰ó£ÏµìãPCŒ*ní¿¼rÔ–{Õ¢nğËfç‹cŞˆæ»šœ,0aL2[P#‹gQÑ®FÆ3®´²‰ø¥~âåü¼AnlXz¿hŸY‚¾Üxæ°§‚ò†+bö\r§d3ªôIn®\r¢Ô-ıfÃ%ŞvU´óíï¿ÎÉ®Ñóİ½µºD~ÆrÏ¦Ù>Ô,Şù—ñŒ)¸5'ÑúB³ı{§î¥À'dçğ‡”Ë0‡´1KN]—x4bdMs‚ØÇ:,\\Ì±T‰ít×»Á²œfdïÚ›à÷7àúò–aÆ‚\n©İ:ZåX˜€Õ/-„<Ç\0´¶LZŒ\\p1MªëÜŸêÉ¦;S¶!‡LÊˆ®‹ä\n›_î[OùDæWÕVŞg0^Â•—ì^GûOt‚Ò]Pó¸;Ïá†ŠÛÚû}'FÀ4¿Œ™ošàğ~jYş—ä;cüŞ†…z8ÆŞÕñXµ5~Íãg£ôÃÿ¶ÿœ\\)¯à-ØÁª¯şÆFõ\0ÄÔ5P/ Š5æJbÊ	ê»£‚Ã\")*œî#bğNÀÛÒ%\0îP<ëØßHÇp:êîÍ\0If¿…ªt&.ºğ`•\0ŞO ÈZDdgÄÊş@20n£ÆV£ è!#²,`b,zùìò/ğXPš˜°ıĞ¤6pœÿP%j/°¦_oF©°¾r¥õ	ğC„0şĞ\\Œpk	PÀêoj4ì\$Ã\$*ı\$ŞŒ&ÃOìüñ…«\n®§\rRÃ)b1,\n„G0\n£yĞî%°>&0¶J°Õ\nÍŒ<D\0K°Tá\0¥…ş£ ìzCN]ğ„µì\rhÒÌÑPµdü²ãpŞXğ©B#Ã~ÉéŒ#\"â- –1t\\M©®øÎ­]ñ„ä±fó/\0`†B\0Øj\r Æ\rmvP.#0‰ ÒÇ6/'ŒV\n ¨ÀZz5Âî9¬üÎ/ì%©>mÒÍ¼³.£LˆŒb&G#0p«Â˜åºo€›‘¼º\0Ø«\$&6¢óbœ.äÖÄ)NV¢ïÇ²4²rJrV©8´äÄ\$fKC£!+^\nå'¤abòß‚çîNê%šbîĞ¾ÒZö\rà±­ö»2]¦ ¾¶’vŞ èriQğ³f 6\$â½íÛ(\nŒ¾+jo,¸ohurC0LƒNé @¯vd®Fº¯&y+NßìR0«`O`ê%êÈ¯²–Z\"Ø\"vl« =È2r äbÆŒ92\n5C0)†T²DÃ0+¸Ê°‚üâĞ»àËëjk°ro€‚)¢ÔÅÄDKŞ ZMLşÉø*M3Ó@—’‚ê3FÀ";break;case"zh":$xb="æA*ês•\\šr¤îõâ|%ÌÂ:\$\nr.®„ö2Šr/d²È»[8Ğ S™8€r©!T¡\\¸s¦’I4¢b§r¬ñ•Ğ€Js!J¥“É:Ú2r«STâ¢”\n†Ìh5\rÇSRº9QÉ÷*-Y(eÈ—B†­+²¯Î…òFZI9PªYj^F•X9‘ªê¼Pæ¸ÜÜÉÔ¥2s&Ö’Eƒ¡~™Œª®·yc‘~¨¦#}K•r¶s®Ôûkõ|¿iµ-rÙÍ€Á)c(¸ÊC«İ¦#*ÛJ!A–R\nõk¡P€Œ/Wît¢¢ZœU9ÓêWJQ3ÓWãq¨*é'Os%îdbÊ¯C9Ô¿Mnr;NáPÁ)ÅÁZâ´'1Tœ¥‰*†J;’©§)nY5ªª®¨’ç9XS#%’ÊîœÄAns–%ÙÊO-ç30¥*\\OœÄ¹lt’å¢0]Œñ6r‘²Ê^’-‰8´å\0Jœ¤Ù|r—¥ÊS0Œ9„),„•ò²,‘´¯,Ápi+\r‘»F²–eÛb‡%ÊPœ¤Ë½D¥ºF­/Ãô@¥¯[r½Ë)3¤«úJ´<¡E# Ú4Ã(ät—dÂlR>•›ñÁ\\È.Dáû¿/ÚrĞOi&†àÂ\rÊ3¡Ğ:ƒ€æáxïa…Ã\r%JRÁpŞ9áxÊ7ã€Â9c½–2á:e1ÌA§ANš³çIX…ã|GI\0DœÄYS1,ZZLÇ9H]6\$™ÌO]FJ7\r&—Øã‚®Éi,X¥Ùuz=‘ZS¤‰‡Œ8tId€K¬±LW–eEÍ9Tr‘PDO\\Ä}ÛLÓg)\0^]·}âTÉíév“x9 D%¤8s–’’N]œÄ\"†^‘§9zW%¤s]fÌ²¡®:Da&ÇIâ\\V×Åô]2Ä„!fD#°ECGmşl)Š\"f2nŒIœ¥ã°İ58V	ŠPt+M—'1Q:™´â\\—)›q•qÌSGD¨–²›lú^8=9ÊC­¾\"]M|íIĞ7­\\–ò|.»Ÿ^@PØ:Ijs”Óqt_œ…Ñ«œôwYCQaHX¤dV.LC<C¦\$Õ`ÿ(Øì€C\$’ØH×26WÌëÄjÃ‘\0†)ŠB0@“”‡9F)O÷Ôg(+¸š—aÊ#_iK\r¸E	÷šŠa‚|tD€ÙİR*MJ‡'¾+Å¸èt	‘\"Q,'b±Y+El®Ò¼WËa,EJËY«<†@Şƒt\r0ılƒãf`¾!‚ t±bOH¡£¤NŠ\"\"Aâé]d`^	£¦j»ÛFp|[¿öÔyW#(©?´,,£œå*«Un®UÚ½Wëa‡uŠ±àêÊY‹9hPğxsˆkAm5¹RAÑeu&2HäE˜•&È0W1Ì,Àä\"rˆÁ,†Åø…Š(¨H%ÓºHbğ¯§ÄùŸS+E æb5¹”UQ,ğaq6.HŒUn¬VÈĞ¢HHABœº¿ÇÜdU4‘LÅÁR¯<}UX \n (&I\$“|®,£ÅxÔFŒ5&æxOa)R\0°NDÊqV+à£1¦‰˜{i/ÁÌ¸Ú NYsAàğ–qÌ(ãß3ğW‘Æ„&(\0¯Œ´Z*!Ò(„ÄË-i4PÑl¸Eø‡%ÄÀ™OlN	ÒÂ¸Z¯Fjÿa\0åflÀP%t6èøœ1ÆõRQ!v# ÚÈPˆk\$ˆ‚Œ†Y£‰›.\"ŒSŠ¥\\(ğ¦Ê­&,¼R\nz€„8(\"EÎ¥¨E)*Š¨©|tˆVªÕÛûø¡(t’sÈ \"õ1ÁP(òB(	û'o0¦ã^IæœNIÑ;wP`ĞØ¤Ç•¬Qtè+ÅÈ\n	á8P T¶ªÖ@Š-²-\"´KÓ±jËHKÒà‘*/Ô ¦g¢&(Ú“†qf©¿0&ŒEEİÕw`²Šqvt+ğvG¹\r¡t€sÄÌ¹­W¼.åà¼¯´uÎfõ»D|9Å@‹di®\0‰†jYDQ¾ªÄ=,?¡ÙĞ„í‚1û »8Â„ÚAÉ]è(ôğ‰°Hs9¢ÜÎÑAiíMü­¥›aB9Ås\$÷¸åœÛĞtb¤õ“.iİ<ÄË)˜3:Bƒ¤ã¤ÃZ`¢pª)Ç°¼ƒÉhº”Mª1@!ÜU©ÂİW¢chÄ£X\\Lb'S½|İ€§Ë‚G/‘6.ˆ0š\"L_Oc	BİYh¢î¡ÊÛ±!~/Ó`y'”;V+˜0¸·º¢6Z(ËbC	˜ñ1Dcth¯ÈN°ò‰–8x ÒóT–éE4æ©ƒ™ö+\0JÇué@XYvcfÂ§.\0RDŞDLÔ3X–jt²'K–ó˜#Ms5LnÇ×k´Ë¶û¢bq=@¤€‘m›c‰¶o*Ó'E+-IÅ˜YÃ¼Ã(bÜ‰Ï/YQm…ğº(S>ç*E°å5(V´áv![Jù_zTô‘ÁÄz\"ÂâU^’ò^Ëëu\"/Şcœt.lÆ1…ãa™£9ÆrmåWHàò\\„¸çÅæ‘dV	Ë9JaØcû„‚|ÈrèG3u4+…#:g—œè%p~sX8Œ_Œ™t‰JëDGIÍä´³²Ò…ùp¹Èâò–V›ÑB*é¬%Ük.…4W-<äŠ‹¯Ì±}ñäO©¿§¾åÌswd]`_¹õÛú%éÆW‘w—sá9Yğb<ş‹€³¶xP‚?mA_wu6¨×{kVjááx½éÊö“–÷ÖèòÏ æ£”¼”ÈÇ(’™Y6‹½ÄÒ9eL«0XqSLi\$&Q:s½…“«¨@½¦OddÜJ¡BÔ5<=®Ò2%;İUnËÜüô2iM¢´™3't×ÖKMy²	§·õœr“½+ÇŒ#Õ:ÿŞ/“G4şşĞ©ÁtÏ‚Rñ/L`Œö)¯êbP\n%Õ\0as&àæg_ÂÒpÂÚ-åú2dàç,ÍFi¢\$éx4áÎ­,ïè!ZÎëòòoJr£Lòññ%ï\$kÁhM ıÊbÏšõpvhlÀ{p€3Ï°a<øÆåC òfG\0ìĞk£\0P]\n„Ó/OU¦®OÙÏû	\nPÉF	‚uğÕOäÌl½¦Ëj©0fÿLÅ¤í\r,ºNĞÖbPéã¼ßpGP%\rÃ Ğ0å\r\$HDĞÍán*àZ`Ğ Èò0Vl	ìÀã(-!tëÀ×ÃB¾ëòÛCbÀíúü\" H\"Ò§¨ÁB|\"ÊqTJQH¢L€-V ­ZÕçÜ@g€\rƒz€ä˜æ á 4.„GÉªë\$&ÚOš•iˆ; ª\n€Œ p6Á,Oâ®×ÍB¼ÊD8)Ş#b:½Æ~:mÂa¯Ğ«Ğ!(4Âä!^áãp;(2 Cn/¬ÖÍ©îıÁ^ŸvCjôzhC4{§:-2!¬Z¬(¨JJfš\"Z!\0.p.ÆèBî¢Ìæ¯Àò‹°æöCI¡m%øånlñ!x*lq&¢X4obG¯æÇÏ4j\"iLƒ\".vnzs®Ì¹.¼ÈN¹)nĞÏÃ\$¤pDMíÄ\\Î‰`¬ Æ ê\r®Ô\$2pÎ_ì–ÁG#£Æ`BbO’G\$£¤²T»Éò@‚“Ëë.²î»2âmã¤ÃòrÑ\nØòÒ˜øãè{‚ÄríaL";break;}$xi=array();foreach(explode("\n",lzw_decompress($xb))as$X)$xi[]=(strpos($X,"\t")?explode("\t",$X):$X);return$xi;}if(!$xi){$xi=get_translations($ca);$_SESSION["translations"]=$xi;}if(extension_loaded('pdo')){class
Min_PDO
extends
PDO{var$_result,$server_info,$affected_rows,$errno,$error;function
__construct(){global$b;$hg=array_search("SQL",$b->operators);if($hg!==false)unset($b->operators[$hg]);}function
dsn($lc,$V,$E,$Af=array()){try{parent::__construct($lc,$V,$E,$Af);}catch(Exception$Cc){auth_error(h($Cc->getMessage()));}$this->setAttribute(13,array('Min_PDOStatement'));$this->server_info=@$this->getAttribute(4);}function
query($F,$Fi=false){$G=parent::query($F);$this->error="";if(!$G){list(,$this->errno,$this->error)=$this->errorInfo();if(!$this->error)$this->error=lang(21);return
false;}$this->store_result($G);return$G;}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result($G=null){if(!$G){$G=$this->_result;if(!$G)return
false;}if($G->columnCount()){$G->num_rows=$G->rowCount();return$G;}$this->affected_rows=$G->rowCount();return
true;}function
next_result(){if(!$this->_result)return
false;$this->_result->_offset=0;return@$this->_result->nextRowset();}function
result($F,$o=0){$G=$this->query($F);if(!$G)return
false;$I=$G->fetch();return$I[$o];}}class
Min_PDOStatement
extends
PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch(2);}function
fetch_row(){return$this->fetch(3);}function
fetch_field(){$I=(object)$this->getColumnMeta($this->_offset++);$I->orgtable=$I->table;$I->orgname=$I->name;$I->charsetnr=(in_array("blob",(array)$I->flags)?63:0);return$I;}}}$gc=array();class
Min_SQL{var$_conn;function
__construct($g){$this->_conn=$g;}function
select($Q,$K,$Z,$pd,$Cf=array(),$z=1,$D=0,$pg=false){global$b,$x;$ae=(count($pd)<count($K));$F=$b->selectQueryBuild($K,$Z,$pd,$Cf,$z,$D);if(!$F)$F="SELECT".limit(($_GET["page"]!="last"&&$z!=""&&$pd&&$ae&&$x=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$K)."\nFROM ".table($Q),($Z?"\nWHERE ".implode(" AND ",$Z):"").($pd&&$ae?"\nGROUP BY ".implode(", ",$pd):"").($Cf?"\nORDER BY ".implode(", ",$Cf):""),($z!=""?+$z:null),($D?$z*$D:0),"\n");$Gh=microtime(true);$H=$this->_conn->query($F);if($pg)echo$b->selectQuery($F,$Gh,!$H);return$H;}function
delete($Q,$zg,$z=0){$F="FROM ".table($Q);return
queries("DELETE".($z?limit1($Q,$F,$zg):" $F$zg"));}function
update($Q,$N,$zg,$z=0,$L="\n"){$Yi=array();foreach($N
as$y=>$X)$Yi[]="$y = $X";$F=table($Q)." SET$L".implode(",$L",$Yi);return
queries("UPDATE".($z?limit1($Q,$F,$zg,$L):" $F$zg"));}function
insert($Q,$N){return
queries("INSERT INTO ".table($Q).($N?" (".implode(", ",array_keys($N)).")\nVALUES (".implode(", ",$N).")":" DEFAULT VALUES"));}function
insertUpdate($Q,$J,$ng){return
false;}function
begin(){return
queries("BEGIN");}function
commit(){return
queries("COMMIT");}function
rollback(){return
queries("ROLLBACK");}function
slowQuery($F,$ii){}function
convertSearch($u,$X,$o){return$u;}function
value($X,$o){return(method_exists($this->_conn,'value')?$this->_conn->value($X,$o):(is_resource($X)?stream_get_contents($X):$X));}function
quoteBinary($bh){return
q($bh);}function
warnings(){return'';}function
tableHelp($B){}}$gc["sqlite"]="SQLite 3";$gc["sqlite2"]="SQLite 2";if(isset($_GET["sqlite"])||isset($_GET["sqlite2"])){$kg=array((isset($_GET["sqlite"])?"SQLite3":"SQLite"),"PDO_SQLite");define("DRIVER",(isset($_GET["sqlite"])?"sqlite":"sqlite2"));if(class_exists(isset($_GET["sqlite"])?"SQLite3":"SQLiteDatabase")){if(isset($_GET["sqlite"])){class
Min_SQLite{var$extension="SQLite3",$server_info,$affected_rows,$errno,$error,$_link;function
__construct($Wc){$this->_link=new
SQLite3($Wc);$bj=$this->_link->version();$this->server_info=$bj["versionString"];}function
query($F){$G=@$this->_link->query($F);$this->error="";if(!$G){$this->errno=$this->_link->lastErrorCode();$this->error=$this->_link->lastErrorMsg();return
false;}elseif($G->numColumns())return
new
Min_Result($G);$this->affected_rows=$this->_link->changes();return
true;}function
quote($P){return(is_utf8($P)?"'".$this->_link->escapeString($P)."'":"x'".reset(unpack('H*',$P))."'");}function
store_result(){return$this->_result;}function
result($F,$o=0){$G=$this->query($F);if(!is_object($G))return
false;$I=$G->_result->fetchArray();return$I[$o];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($G){$this->_result=$G;}function
fetch_assoc(){return$this->_result->fetchArray(SQLITE3_ASSOC);}function
fetch_row(){return$this->_result->fetchArray(SQLITE3_NUM);}function
fetch_field(){$e=$this->_offset++;$T=$this->_result->columnType($e);return(object)array("name"=>$this->_result->columnName($e),"type"=>$T,"charsetnr"=>($T==SQLITE3_BLOB?63:0),);}function
__desctruct(){return$this->_result->finalize();}}}else{class
Min_SQLite{var$extension="SQLite",$server_info,$affected_rows,$error,$_link;function
__construct($Wc){$this->server_info=sqlite_libversion();$this->_link=new
SQLiteDatabase($Wc);}function
query($F,$Fi=false){$Ue=($Fi?"unbufferedQuery":"query");$G=@$this->_link->$Ue($F,SQLITE_BOTH,$n);$this->error="";if(!$G){$this->error=$n;return
false;}elseif($G===true){$this->affected_rows=$this->changes();return
true;}return
new
Min_Result($G);}function
quote($P){return"'".sqlite_escape_string($P)."'";}function
store_result(){return$this->_result;}function
result($F,$o=0){$G=$this->query($F);if(!is_object($G))return
false;$I=$G->_result->fetch();return$I[$o];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($G){$this->_result=$G;if(method_exists($G,'numRows'))$this->num_rows=$G->numRows();}function
fetch_assoc(){$I=$this->_result->fetch(SQLITE_ASSOC);if(!$I)return
false;$H=array();foreach($I
as$y=>$X)$H[($y[0]=='"'?idf_unescape($y):$y)]=$X;return$H;}function
fetch_row(){return$this->_result->fetch(SQLITE_NUM);}function
fetch_field(){$B=$this->_result->fieldName($this->_offset++);$dg='(\[.*]|"(?:[^"]|"")*"|(.+))';if(preg_match("~^($dg\\.)?$dg\$~",$B,$A)){$Q=($A[3]!=""?$A[3]:idf_unescape($A[2]));$B=($A[5]!=""?$A[5]:idf_unescape($A[4]));}return(object)array("name"=>$B,"orgname"=>$B,"orgtable"=>$Q,);}}}}elseif(extension_loaded("pdo_sqlite")){class
Min_SQLite
extends
Min_PDO{var$extension="PDO_SQLite";function
__construct($Wc){$this->dsn(DRIVER.":$Wc","","");}}}if(class_exists("Min_SQLite")){class
Min_DB
extends
Min_SQLite{function
__construct(){parent::__construct(":memory:");$this->query("PRAGMA foreign_keys = 1");}function
select_db($Wc){if(is_readable($Wc)&&$this->query("ATTACH ".$this->quote(preg_match("~(^[/\\\\]|:)~",$Wc)?$Wc:dirname($_SERVER["SCRIPT_FILENAME"])."/$Wc")." AS a")){parent::__construct($Wc);$this->query("PRAGMA foreign_keys = 1");return
true;}return
false;}function
multi_query($F){return$this->_result=$this->query($F);}function
next_result(){return
false;}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($Q,$J,$ng){$Yi=array();foreach($J
as$N)$Yi[]="(".implode(", ",$N).")";return
queries("REPLACE INTO ".table($Q)." (".implode(", ",array_keys(reset($J))).") VALUES\n".implode(",\n",$Yi));}function
tableHelp($B){if($B=="sqlite_sequence")return"fileformat2.html#seqtab";if($B=="sqlite_master")return"fileformat2.html#$B";}}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
connect(){global$b;list(,,$E)=$b->credentials();if($E!="")return
lang(22);return
new
Min_DB;}function
get_databases(){return
array();}function
limit($F,$Z,$z,$C=0,$L=" "){return" $F$Z".($z!==null?$L."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$F,$Z,$L="\n"){global$g;return(preg_match('~^INTO~',$F)||$g->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($F,$Z,1,0,$L):" $F WHERE rowid = (SELECT rowid FROM ".table($Q).$Z.$L."LIMIT 1)");}function
db_collation($l,$qb){global$g;return$g->result("PRAGMA encoding");}function
engines(){return
array();}function
logged_user(){return
get_current_user();}function
tables_list(){return
get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");}function
count_tables($k){return
array();}function
table_status($B=""){global$g;$H=array();foreach(get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') ".($B!=""?"AND name = ".q($B):"ORDER BY name"))as$I){$I["Rows"]=$g->result("SELECT COUNT(*) FROM ".idf_escape($I["Name"]));$H[$I["Name"]]=$I;}foreach(get_rows("SELECT * FROM sqlite_sequence",null,"")as$I)$H[$I["name"]]["Auto_increment"]=$I["seq"];return($B!=""?$H[$B]:$H);}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){global$g;return!$g->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");}function
fields($Q){global$g;$H=array();$ng="";foreach(get_rows("PRAGMA table_info(".table($Q).")")as$I){$B=$I["name"];$T=strtolower($I["type"]);$Vb=$I["dflt_value"];$H[$B]=array("field"=>$B,"type"=>(preg_match('~int~i',$T)?"integer":(preg_match('~char|clob|text~i',$T)?"text":(preg_match('~blob~i',$T)?"blob":(preg_match('~real|floa|doub~i',$T)?"real":"numeric")))),"full_type"=>$T,"default"=>(preg_match("~'(.*)'~",$Vb,$A)?str_replace("''","'",$A[1]):($Vb=="NULL"?null:$Vb)),"null"=>!$I["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1),"primary"=>$I["pk"],);if($I["pk"]){if($ng!="")$H[$ng]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$T))$H[$B]["auto_increment"]=true;$ng=$B;}}$Bh=$g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));preg_match_all('~(("[^"]*+")+|[a-z0-9_]+)\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$Bh,$Ge,PREG_SET_ORDER);foreach($Ge
as$A){$B=str_replace('""','"',preg_replace('~^"|"$~','',$A[1]));if($H[$B])$H[$B]["collation"]=trim($A[3],"'");}return$H;}function
indexes($Q,$h=null){global$g;if(!is_object($h))$h=$g;$H=array();$Bh=$h->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$Bh,$A)){$H[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$A[1],$Ge,PREG_SET_ORDER);foreach($Ge
as$A){$H[""]["columns"][]=idf_unescape($A[2]).$A[4];$H[""]["descs"][]=(preg_match('~DESC~i',$A[5])?'1':null);}}if(!$H){foreach(fields($Q)as$B=>$o){if($o["primary"])$H[""]=array("type"=>"PRIMARY","columns"=>array($B),"lengths"=>array(),"descs"=>array(null));}}$Eh=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($Q),$h);foreach(get_rows("PRAGMA index_list(".table($Q).")",$h)as$I){$B=$I["name"];$v=array("type"=>($I["unique"]?"UNIQUE":"INDEX"));$v["lengths"]=array();$v["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($B).")",$h)as$ah){$v["columns"][]=$ah["name"];$v["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($B).' ON '.idf_escape($Q),'~').' \((.*)\)$~i',$Eh[$B],$Kg)){preg_match_all('/("[^"]*+")+( DESC)?/',$Kg[2],$Ge);foreach($Ge[2]as$y=>$X){if($X)$v["descs"][$y]='1';}}if(!$H[""]||$v["type"]!="UNIQUE"||$v["columns"]!=$H[""]["columns"]||$v["descs"]!=$H[""]["descs"]||!preg_match("~^sqlite_~",$B))$H[$B]=$v;}return$H;}function
foreign_keys($Q){$H=array();foreach(get_rows("PRAGMA foreign_key_list(".table($Q).")")as$I){$q=&$H[$I["id"]];if(!$q)$q=$I;$q["source"][]=$I["from"];$q["target"][]=$I["to"];}return$H;}function
view($B){global$g;return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU','',$g->result("SELECT sql FROM sqlite_master WHERE name = ".q($B))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($l){return
false;}function
error(){global$g;return
h($g->error);}function
check_sqlite_name($B){global$g;$Mc="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Mc)\$~",$B)){$g->error=lang(23,str_replace("|",", ",$Mc));return
false;}return
true;}function
create_database($l,$d){global$g;if(file_exists($l)){$g->error=lang(24);return
false;}if(!check_sqlite_name($l))return
false;try{$_=new
Min_SQLite($l);}catch(Exception$Cc){$g->error=$Cc->getMessage();return
false;}$_->query('PRAGMA encoding = "UTF-8"');$_->query('CREATE TABLE adminer (i)');$_->query('DROP TABLE adminer');return
true;}function
drop_databases($k){global$g;$g->__construct(":memory:");foreach($k
as$l){if(!@unlink($l)){$g->error=lang(24);return
false;}}return
true;}function
rename_database($B,$d){global$g;if(!check_sqlite_name($B))return
false;$g->__construct(":memory:");$g->error=lang(24);return@rename(DB,$B);}function
auto_increment(){return" PRIMARY KEY".(DRIVER=="sqlite"?" AUTOINCREMENT":"");}function
alter_table($Q,$B,$p,$ed,$vb,$wc,$d,$Na,$Xf){global$g;$Ri=($Q==""||$ed);foreach($p
as$o){if($o[0]!=""||!$o[1]||$o[2]){$Ri=true;break;}}$c=array();$Lf=array();foreach($p
as$o){if($o[1]){$c[]=($Ri?$o[1]:"ADD ".implode($o[1]));if($o[0]!="")$Lf[$o[0]]=$o[1][0];}}if(!$Ri){foreach($c
as$X){if(!queries("ALTER TABLE ".table($Q)." $X"))return
false;}if($Q!=$B&&!queries("ALTER TABLE ".table($Q)." RENAME TO ".table($B)))return
false;}elseif(!recreate_table($Q,$B,$c,$Lf,$ed,$Na))return
false;if($Na){queries("BEGIN");queries("UPDATE sqlite_sequence SET seq = $Na WHERE name = ".q($B));if(!$g->affected_rows)queries("INSERT INTO sqlite_sequence (name, seq) VALUES (".q($B).", $Na)");queries("COMMIT");}return
true;}function
recreate_table($Q,$B,$p,$Lf,$ed,$Na,$w=array()){global$g;if($Q!=""){if(!$p){foreach(fields($Q)as$y=>$o){if($w)$o["auto_increment"]=0;$p[]=process_field($o,$o);$Lf[$y]=idf_escape($y);}}$og=false;foreach($p
as$o){if($o[6])$og=true;}$jc=array();foreach($w
as$y=>$X){if($X[2]=="DROP"){$jc[$X[1]]=true;unset($w[$y]);}}foreach(indexes($Q)as$ie=>$v){$f=array();foreach($v["columns"]as$y=>$e){if(!$Lf[$e])continue
2;$f[]=$Lf[$e].($v["descs"][$y]?" DESC":"");}if(!$jc[$ie]){if($v["type"]!="PRIMARY"||!$og)$w[]=array($v["type"],$ie,$f);}}foreach($w
as$y=>$X){if($X[0]=="PRIMARY"){unset($w[$y]);$ed[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($Q)as$ie=>$q){foreach($q["source"]as$y=>$e){if(!$Lf[$e])continue
2;$q["source"][$y]=idf_unescape($Lf[$e]);}if(!isset($ed[" $ie"]))$ed[]=" ".format_foreign_key($q);}queries("BEGIN");}foreach($p
as$y=>$o)$p[$y]="  ".implode($o);$p=array_merge($p,array_filter($ed));$ci=($Q==$B?"adminer_$B":$B);if(!queries("CREATE TABLE ".table($ci)." (\n".implode(",\n",$p)."\n)"))return
false;if($Q!=""){if($Lf&&!queries("INSERT INTO ".table($ci)." (".implode(", ",$Lf).") SELECT ".implode(", ",array_map('idf_escape',array_keys($Lf)))." FROM ".table($Q)))return
false;$Ci=array();foreach(triggers($Q)as$Ai=>$ji){$_i=trigger($Ai);$Ci[]="CREATE TRIGGER ".idf_escape($Ai)." ".implode(" ",$ji)." ON ".table($B)."\n$_i[Statement]";}$Na=$Na?0:$g->result("SELECT seq FROM sqlite_sequence WHERE name = ".q($Q));if(!queries("DROP TABLE ".table($Q))||($Q==$B&&!queries("ALTER TABLE ".table($ci)." RENAME TO ".table($B)))||!alter_indexes($B,$w))return
false;if($Na)queries("UPDATE sqlite_sequence SET seq = $Na WHERE name = ".q($B));foreach($Ci
as$_i){if(!queries($_i))return
false;}queries("COMMIT");}return
true;}function
index_sql($Q,$T,$B,$f){return"CREATE $T ".($T!="INDEX"?"INDEX ":"").idf_escape($B!=""?$B:uniqid($Q."_"))." ON ".table($Q)." $f";}function
alter_indexes($Q,$c){foreach($c
as$ng){if($ng[0]=="PRIMARY")return
recreate_table($Q,$Q,array(),array(),array(),0,$c);}foreach(array_reverse($c)as$X){if(!queries($X[2]=="DROP"?"DROP INDEX ".idf_escape($X[1]):index_sql($Q,$X[0],$X[1],"(".implode(", ",$X[2]).")")))return
false;}return
true;}function
truncate_tables($S){return
apply_queries("DELETE FROM",$S);}function
drop_views($dj){return
apply_queries("DROP VIEW",$dj);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
move_tables($S,$dj,$ai){return
false;}function
trigger($B){global$g;if($B=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$u='(?:[^`"\s]+|`[^`]*`|"[^"]*")+';$Bi=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$u\\s*(".implode("|",$Bi["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($u))?\\s+ON\\s*$u\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",$g->result("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($B)),$A);$mf=$A[3];return
array("Timing"=>strtoupper($A[1]),"Event"=>strtoupper($A[2]).($mf?" OF":""),"Of"=>($mf[0]=='`'||$mf[0]=='"'?idf_unescape($mf):$mf),"Trigger"=>$B,"Statement"=>$A[4],);}function
triggers($Q){$H=array();$Bi=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q))as$I){preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*('.implode("|",$Bi["Timing"]).')\s*(.*?)\s+ON\b~i',$I["sql"],$A);$H[$I["name"]]=array($A[1],$A[2]);}return$H;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
begin(){return
queries("BEGIN");}function
last_id(){global$g;return$g->result("SELECT LAST_INSERT_ROWID()");}function
explain($g,$F){return$g->query("EXPLAIN QUERY PLAN $F");}function
found_rows($R,$Z){}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($eh){return
true;}function
create_sql($Q,$Na,$Lh){global$g;$H=$g->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($Q));foreach(indexes($Q)as$B=>$v){if($B=='')continue;$H.=";\n\n".index_sql($Q,$v['type'],$B,"(".implode(", ",array_map('idf_escape',$v['columns'])).")");}return$H;}function
truncate_sql($Q){return"DELETE FROM ".table($Q);}function
use_sql($j){}function
trigger_sql($Q){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q)));}function
show_variables(){global$g;$H=array();foreach(array("auto_vacuum","cache_size","count_changes","default_cache_size","empty_result_callbacks","encoding","foreign_keys","full_column_names","fullfsync","journal_mode","journal_size_limit","legacy_file_format","locking_mode","page_size","max_page_count","read_uncommitted","recursive_triggers","reverse_unordered_selects","secure_delete","short_column_names","synchronous","temp_store","temp_store_directory","schema_version","integrity_check","quick_check")as$y)$H[$y]=$g->result("PRAGMA $y");return$H;}function
show_status(){$H=array();foreach(get_vals("PRAGMA compile_options")as$_f){list($y,$X)=explode("=",$_f,2);$H[$y]=$X;}return$H;}function
convert_field($o){}function
unconvert_field($o,$H){return$H;}function
support($Rc){return
preg_match('~^(columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$Rc);}$x="sqlite";$U=array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0);$Kh=array_keys($U);$Li=array();$yf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");$md=array("hex","length","lower","round","unixepoch","upper");$sd=array("avg","count","count distinct","group_concat","max","min","sum");$oc=array(array(),array("integer|real|numeric"=>"+/-","text"=>"||",));}$gc["pgsql"]="PostgreSQL";if(isset($_GET["pgsql"])){$kg=array("PgSQL","PDO_PgSQL");define("DRIVER","pgsql");if(extension_loaded("pgsql")){class
Min_DB{var$extension="PgSQL",$_link,$_result,$_string,$_database=true,$server_info,$affected_rows,$error,$timeout;function
_error($zc,$n){if(ini_bool("html_errors"))$n=html_entity_decode(strip_tags($n));$n=preg_replace('~^[^:]*: ~','',$n);$this->error=$n;}function
connect($M,$V,$E){global$b;$l=$b->database();set_error_handler(array($this,'_error'));$this->_string="host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' user='".addcslashes($V,"'\\")."' password='".addcslashes($E,"'\\")."'";$this->_link=@pg_connect("$this->_string dbname='".($l!=""?addcslashes($l,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->_link&&$l!=""){$this->_database=false;$this->_link=@pg_connect("$this->_string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->_link){$bj=pg_version($this->_link);$this->server_info=$bj["server"];pg_set_client_encoding($this->_link,"UTF8");}return(bool)$this->_link;}function
quote($P){return"'".pg_escape_string($this->_link,$P)."'";}function
value($X,$o){return($o["type"]=="bytea"?pg_unescape_bytea($X):$X);}function
quoteBinary($P){return"'".pg_escape_bytea($this->_link,$P)."'";}function
select_db($j){global$b;if($j==$b->database())return$this->_database;$H=@pg_connect("$this->_string dbname='".addcslashes($j,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($H)$this->_link=$H;return$H;}function
close(){$this->_link=@pg_connect("$this->_string dbname='postgres'");}function
query($F,$Fi=false){$G=@pg_query($this->_link,$F);$this->error="";if(!$G){$this->error=pg_last_error($this->_link);$H=false;}elseif(!pg_num_fields($G)){$this->affected_rows=pg_affected_rows($G);$H=true;}else$H=new
Min_Result($G);if($this->timeout){$this->timeout=0;$this->query("RESET statement_timeout");}return$H;}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($F,$o=0){$G=$this->query($F);if(!$G||!$G->num_rows)return
false;return
pg_fetch_result($G->_result,0,$o);}function
warnings(){return
h(pg_last_notice($this->_link));}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($G){$this->_result=$G;$this->num_rows=pg_num_rows($G);}function
fetch_assoc(){return
pg_fetch_assoc($this->_result);}function
fetch_row(){return
pg_fetch_row($this->_result);}function
fetch_field(){$e=$this->_offset++;$H=new
stdClass;if(function_exists('pg_field_table'))$H->orgtable=pg_field_table($this->_result,$e);$H->name=pg_field_name($this->_result,$e);$H->orgname=$H->name;$H->type=pg_field_type($this->_result,$e);$H->charsetnr=($H->type=="bytea"?63:0);return$H;}function
__destruct(){pg_free_result($this->_result);}}}elseif(extension_loaded("pdo_pgsql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_PgSQL",$timeout;function
connect($M,$V,$E){global$b;$l=$b->database();$P="pgsql:host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' options='-c client_encoding=utf8'";$this->dsn("$P dbname='".($l!=""?addcslashes($l,"'\\"):"postgres")."'",$V,$E);return
true;}function
select_db($j){global$b;return($b->database()==$j);}function
quoteBinary($bh){return
q($bh);}function
query($F,$Fi=false){$H=parent::query($F,$Fi);if($this->timeout){$this->timeout=0;parent::query("RESET statement_timeout");}return$H;}function
warnings(){return'';}function
close(){}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($Q,$J,$ng){global$g;foreach($J
as$N){$Mi=array();$Z=array();foreach($N
as$y=>$X){$Mi[]="$y = $X";if(isset($ng[idf_unescape($y)]))$Z[]="$y = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Mi)." WHERE ".implode(" AND ",$Z))&&$g->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
slowQuery($F,$ii){$this->_conn->query("SET statement_timeout = ".(1000*$ii));$this->_conn->timeout=1000*$ii;return$F;}function
convertSearch($u,$X,$o){return(preg_match('~char|text'.(!preg_match('~LIKE~',$X["op"])?'|date|time(stamp)?|boolean|uuid|'.number_type():'').'~',$o["type"])?$u:"CAST($u AS text)");}function
quoteBinary($bh){return$this->_conn->quoteBinary($bh);}function
warnings(){return$this->_conn->warnings();}function
tableHelp($B){$ze=array("information_schema"=>"infoschema","pg_catalog"=>"catalog",);$_=$ze[$_GET["ns"]];if($_)return"$_-".str_replace("_","-",$B).".html";}}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
connect(){global$b,$U,$Kh;$g=new
Min_DB;$Jb=$b->credentials();if($g->connect($Jb[0],$Jb[1],$Jb[2])){if(min_version(9,0,$g)){$g->query("SET application_name = 'Adminer'");if(min_version(9.2,0,$g)){$Kh[lang(25)][]="json";$U["json"]=4294967295;if(min_version(9.4,0,$g)){$Kh[lang(25)][]="jsonb";$U["jsonb"]=4294967295;}}}return$g;}return$g->error;}function
get_databases(){return
get_vals("SELECT datname FROM pg_database WHERE has_database_privilege(datname, 'CONNECT') ORDER BY datname");}function
limit($F,$Z,$z,$C=0,$L=" "){return" $F$Z".($z!==null?$L."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$F,$Z,$L="\n"){return(preg_match('~^INTO~',$F)?limit($F,$Z,1,0,$L):" $F".(is_view(table_status1($Q))?$Z:" WHERE ctid = (SELECT ctid FROM ".table($Q).$Z.$L."LIMIT 1)"));}function
db_collation($l,$qb){global$g;return$g->result("SHOW LC_COLLATE");}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT user");}function
tables_list(){$F="SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";if(support('materializedview'))$F.="
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";$F.="
ORDER BY 1";return
get_key_vals($F);}function
count_tables($k){return
array();}function
table_status($B=""){$H=array();foreach(get_rows("SELECT c.relname AS \"Name\", CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\", pg_relation_size(c.oid) AS \"Data_length\", pg_total_relation_size(c.oid) - pg_relation_size(c.oid) AS \"Index_length\", obj_description(c.oid, 'pg_class') AS \"Comment\", ".(min_version(12)?"''":"CASE WHEN c.relhasoids THEN 'oid' ELSE '' END")." AS \"Oid\", c.reltuples as \"Rows\", n.nspname
FROM pg_class c
JOIN pg_namespace n ON(n.nspname = current_schema() AND n.oid = c.relnamespace)
WHERE relkind IN ('r', 'm', 'v', 'f')
".($B!=""?"AND relname = ".q($B):"ORDER BY relname"))as$I)$H[$I["Name"]]=$I;return($B!=""?$H[$B]:$H);}function
is_view($R){return
in_array($R["Engine"],array("view","materialized view"));}function
fk_support($R){return
true;}function
fields($Q){$H=array();$Da=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);$Fd=min_version(10)?"(a.attidentity = 'd')::int":'0';foreach(get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, pg_get_expr(d.adbin, d.adrelid) AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment, $Fd AS identity
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = ".q($Q)."
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$I){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$I["full_type"],$A);list(,$T,$we,$I["length"],$xa,$Ga)=$A;$I["length"].=$Ga;$fb=$T.$xa;if(isset($Da[$fb])){$I["type"]=$Da[$fb];$I["full_type"]=$I["type"].$we.$Ga;}else{$I["type"]=$T;$I["full_type"]=$I["type"].$we.$xa.$Ga;}if($I['identity'])$I['default']='GENERATED BY DEFAULT AS IDENTITY';$I["null"]=!$I["attnotnull"];$I["auto_increment"]=$I['identity']||preg_match('~^nextval\(~i',$I["default"]);$I["privileges"]=array("insert"=>1,"select"=>1,"update"=>1);if(preg_match('~(.+)::[^)]+(.*)~',$I["default"],$A))$I["default"]=($A[1]=="NULL"?null:(($A[1][0]=="'"?idf_unescape($A[1]):$A[1]).$A[2]));$H[$I["field"]]=$I;}return$H;}function
indexes($Q,$h=null){global$g;if(!is_object($h))$h=$g;$H=array();$Th=$h->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($Q));$f=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Th AND attnum > 0",$h);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption , (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Th AND ci.oid = i.indexrelid",$h)as$I){$Lg=$I["relname"];$H[$Lg]["type"]=($I["indispartial"]?"INDEX":($I["indisprimary"]?"PRIMARY":($I["indisunique"]?"UNIQUE":"INDEX")));$H[$Lg]["columns"]=array();foreach(explode(" ",$I["indkey"])as$Pd)$H[$Lg]["columns"][]=$f[$Pd];$H[$Lg]["descs"]=array();foreach(explode(" ",$I["indoption"])as$Qd)$H[$Lg]["descs"][]=($Qd&1?'1':null);$H[$Lg]["lengths"]=array();}return$H;}function
foreign_keys($Q){global$tf;$H=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = ".q($Q)." AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname")as$I){if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$I['definition'],$A)){$I['source']=array_map('trim',explode(',',$A[1]));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$A[2],$Fe)){$I['ns']=str_replace('""','"',preg_replace('~^"(.+)"$~','\1',$Fe[2]));$I['table']=str_replace('""','"',preg_replace('~^"(.+)"$~','\1',$Fe[4]));}$I['target']=array_map('trim',explode(',',$A[3]));$I['on_delete']=(preg_match("~ON DELETE ($tf)~",$A[4],$Fe)?$Fe[1]:'NO ACTION');$I['on_update']=(preg_match("~ON UPDATE ($tf)~",$A[4],$Fe)?$Fe[1]:'NO ACTION');$H[$I['conname']]=$I;}}return$H;}function
view($B){global$g;return
array("select"=>trim($g->result("SELECT pg_get_viewdef(".$g->result("SELECT oid FROM pg_class WHERE relname = ".q($B)).")")));}function
collations(){return
array();}function
information_schema($l){return($l=="information_schema");}function
error(){global$g;$H=h($g->error);if(preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s',$H,$A))$H=$A[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($A[3]).'})(.*)~','\1<b>\2</b>',$A[2]).$A[4];return
nl_br($H);}function
create_database($l,$d){return
queries("CREATE DATABASE ".idf_escape($l).($d?" ENCODING ".idf_escape($d):""));}function
drop_databases($k){global$g;$g->close();return
apply_queries("DROP DATABASE",$k,'idf_escape');}function
rename_database($B,$d){return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($B));}function
auto_increment(){return"";}function
alter_table($Q,$B,$p,$ed,$vb,$wc,$d,$Na,$Xf){$c=array();$yg=array();if($Q!=""&&$Q!=$B)$yg[]="ALTER TABLE ".table($Q)." RENAME TO ".table($B);foreach($p
as$o){$e=idf_escape($o[0]);$X=$o[1];if(!$X)$c[]="DROP $e";else{$Xi=$X[5];unset($X[5]);if(isset($X[6])&&$o[0]=="")$X[1]=($X[1]=="bigint"?" big":" ")."serial";if($o[0]=="")$c[]=($Q!=""?"ADD ":"  ").implode($X);else{if($e!=$X[0])$yg[]="ALTER TABLE ".table($B)." RENAME $e TO $X[0]";$c[]="ALTER $e TYPE$X[1]";if(!$X[6]){$c[]="ALTER $e ".($X[3]?"SET$X[3]":"DROP DEFAULT");$c[]="ALTER $e ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}}if($o[0]!=""||$Xi!="")$yg[]="COMMENT ON COLUMN ".table($B).".$X[0] IS ".($Xi!=""?substr($Xi,9):"''");}}$c=array_merge($c,$ed);if($Q=="")array_unshift($yg,"CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)");elseif($c)array_unshift($yg,"ALTER TABLE ".table($Q)."\n".implode(",\n",$c));if($Q!=""||$vb!="")$yg[]="COMMENT ON TABLE ".table($B)." IS ".q($vb);if($Na!=""){}foreach($yg
as$F){if(!queries($F))return
false;}return
true;}function
alter_indexes($Q,$c){$i=array();$hc=array();$yg=array();foreach($c
as$X){if($X[0]!="INDEX")$i[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$hc[]=idf_escape($X[1]);else$yg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($i)array_unshift($yg,"ALTER TABLE ".table($Q).implode(",",$i));if($hc)array_unshift($yg,"DROP INDEX ".implode(", ",$hc));foreach($yg
as$F){if(!queries($F))return
false;}return
true;}function
truncate_tables($S){return
queries("TRUNCATE ".implode(", ",array_map('table',$S)));return
true;}function
drop_views($dj){return
drop_tables($dj);}function
drop_tables($S){foreach($S
as$Q){$O=table_status($Q);if(!queries("DROP ".strtoupper($O["Engine"])." ".table($Q)))return
false;}return
true;}function
move_tables($S,$dj,$ai){foreach(array_merge($S,$dj)as$Q){$O=table_status($Q);if(!queries("ALTER ".strtoupper($O["Engine"])." ".table($Q)." SET SCHEMA ".idf_escape($ai)))return
false;}return
true;}function
trigger($B,$Q=null){if($B=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");if($Q===null)$Q=$_GET['trigger'];$J=get_rows('SELECT t.trigger_name AS "Trigger", t.action_timing AS "Timing", (SELECT STRING_AGG(event_manipulation, \' OR \') FROM information_schema.triggers WHERE event_object_table = t.event_object_table AND trigger_name = t.trigger_name ) AS "Events", t.event_manipulation AS "Event", \'FOR EACH \' || t.action_orientation AS "Type", t.action_statement AS "Statement" FROM information_schema.triggers t WHERE t.event_object_table = '.q($Q).' AND t.trigger_name = '.q($B));return
reset($J);}function
triggers($Q){$H=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE event_object_table = ".q($Q))as$I)$H[$I["trigger_name"]]=array($I["action_timing"],$I["event_manipulation"]);return$H;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW","FOR EACH STATEMENT"),);}function
routine($B,$T){$J=get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = '.q($B));$H=$J[0];$H["returns"]=array("type"=>$H["type_udt_name"]);$H["fields"]=get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = '.q($B).'
ORDER BY ordinal_position');return$H;}function
routines(){return
get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');}function
routine_languages(){return
get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");}function
routine_id($B,$I){$H=array();foreach($I["fields"]as$o)$H[]=$o["type"];return
idf_escape($B)."(".implode(", ",$H).")";}function
last_id(){return
0;}function
explain($g,$F){return$g->query("EXPLAIN $F");}function
found_rows($R,$Z){global$g;if(preg_match("~ rows=([0-9]+)~",$g->result("EXPLAIN SELECT * FROM ".idf_escape($R["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$Kg))return$Kg[1];return
false;}function
types(){return
get_vals("SELECT typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){global$g;return$g->result("SELECT current_schema()");}function
set_schema($dh,$h=null){global$g,$U,$Kh;if(!$h)$h=$g;$H=$h->query("SET search_path TO ".idf_escape($dh));foreach(types()as$T){if(!isset($U[$T])){$U[$T]=0;$Kh[lang(26)][]=$T;}}return$H;}function
create_sql($Q,$Na,$Lh){global$g;$H='';$Tg=array();$nh=array();$O=table_status($Q);$p=fields($Q);$w=indexes($Q);ksort($w);$bd=foreign_keys($Q);ksort($bd);if(!$O||empty($p))return
false;$H="CREATE TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." (\n    ";foreach($p
as$Tc=>$o){$Uf=idf_escape($o['field']).' '.$o['full_type'].default_value($o).($o['attnotnull']?" NOT NULL":"");$Tg[]=$Uf;if(preg_match('~nextval\(\'([^\']+)\'\)~',$o['default'],$Ge)){$mh=$Ge[1];$Ah=reset(get_rows(min_version(10)?"SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = ".q($mh):"SELECT * FROM $mh"));$nh[]=($Lh=="DROP+CREATE"?"DROP SEQUENCE IF EXISTS $mh;\n":"")."CREATE SEQUENCE $mh INCREMENT $Ah[increment_by] MINVALUE $Ah[min_value] MAXVALUE $Ah[max_value] START ".($Na?$Ah['last_value']:1)." CACHE $Ah[cache_value];";}}if(!empty($nh))$H=implode("\n\n",$nh)."\n\n$H";foreach($w
as$Kd=>$v){switch($v['type']){case'UNIQUE':$Tg[]="CONSTRAINT ".idf_escape($Kd)." UNIQUE (".implode(', ',array_map('idf_escape',$v['columns'])).")";break;case'PRIMARY':$Tg[]="CONSTRAINT ".idf_escape($Kd)." PRIMARY KEY (".implode(', ',array_map('idf_escape',$v['columns'])).")";break;}}foreach($bd
as$ad=>$Zc)$Tg[]="CONSTRAINT ".idf_escape($ad)." $Zc[definition] ".($Zc['deferrable']?'DEFERRABLE':'NOT DEFERRABLE');$H.=implode(",\n    ",$Tg)."\n) WITH (oids = ".($O['Oid']?'true':'false').");";foreach($w
as$Kd=>$v){if($v['type']=='INDEX'){$f=array();foreach($v['columns']as$y=>$X)$f[]=idf_escape($X).($v['descs'][$y]?" DESC":"");$H.="\n\nCREATE INDEX ".idf_escape($Kd)." ON ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." USING btree (".implode(', ',$f).");";}}if($O['Comment'])$H.="\n\nCOMMENT ON TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." IS ".q($O['Comment']).";";foreach($p
as$Tc=>$o){if($o['comment'])$H.="\n\nCOMMENT ON COLUMN ".idf_escape($O['nspname']).".".idf_escape($O['Name']).".".idf_escape($Tc)." IS ".q($o['comment']).";";}return
rtrim($H,';');}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
trigger_sql($Q){$O=table_status($Q);$H="";foreach(triggers($Q)as$zi=>$yi){$_i=trigger($zi,$O['Name']);$H.="\nCREATE TRIGGER ".idf_escape($_i['Trigger'])." $_i[Timing] $_i[Events] ON ".idf_escape($O["nspname"]).".".idf_escape($O['Name'])." $_i[Type] $_i[Statement];;\n";}return$H;}function
use_sql($j){return"\connect ".idf_escape($j);}function
show_variables(){return
get_key_vals("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
show_status(){}function
convert_field($o){}function
unconvert_field($o,$H){return$H;}function
support($Rc){return
preg_match('~^(database|table|columns|sql|indexes|descidx|comment|view|'.(min_version(9.3)?'materializedview|':'').'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~',$Rc);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){global$g;return$g->result("SHOW max_connections");}$x="pgsql";$U=array();$Kh=array();foreach(array(lang(27)=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),lang(28)=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),lang(25)=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),lang(29)=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),lang(30)=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"txid_snapshot"=>0),lang(31)=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),)as$y=>$X){$U+=$X;$Kh[$y]=array_keys($X);}$Li=array();$yf=array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");$md=array("char_length","lower","round","to_hex","to_timestamp","upper");$sd=array("avg","count","count distinct","max","min","sum");$oc=array(array("char"=>"md5","date|time"=>"now",),array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",));}$gc["oracle"]="Oracle (beta)";if(isset($_GET["oracle"])){$kg=array("OCI8","PDO_OCI");define("DRIVER","oracle");if(extension_loaded("oci8")){class
Min_DB{var$extension="oci8",$_link,$_result,$server_info,$affected_rows,$errno,$error;function
_error($zc,$n){if(ini_bool("html_errors"))$n=html_entity_decode(strip_tags($n));$n=preg_replace('~^[^:]*: ~','',$n);$this->error=$n;}function
connect($M,$V,$E){$this->_link=@oci_new_connect($V,$E,$M,"AL32UTF8");if($this->_link){$this->server_info=oci_server_version($this->_link);return
true;}$n=oci_error();$this->error=$n["message"];return
false;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($j){return
true;}function
query($F,$Fi=false){$G=oci_parse($this->_link,$F);$this->error="";if(!$G){$n=oci_error($this->_link);$this->errno=$n["code"];$this->error=$n["message"];return
false;}set_error_handler(array($this,'_error'));$H=@oci_execute($G);restore_error_handler();if($H){if(oci_num_fields($G))return
new
Min_Result($G);$this->affected_rows=oci_num_rows($G);}return$H;}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($F,$o=1){$G=$this->query($F);if(!is_object($G)||!oci_fetch($G->_result))return
false;return
oci_result($G->_result,$o);}}class
Min_Result{var$_result,$_offset=1,$num_rows;function
__construct($G){$this->_result=$G;}function
_convert($I){foreach((array)$I
as$y=>$X){if(is_a($X,'OCI-Lob'))$I[$y]=$X->load();}return$I;}function
fetch_assoc(){return$this->_convert(oci_fetch_assoc($this->_result));}function
fetch_row(){return$this->_convert(oci_fetch_row($this->_result));}function
fetch_field(){$e=$this->_offset++;$H=new
stdClass;$H->name=oci_field_name($this->_result,$e);$H->orgname=$H->name;$H->type=oci_field_type($this->_result,$e);$H->charsetnr=(preg_match("~raw|blob|bfile~",$H->type)?63:0);return$H;}function
__destruct(){oci_free_statement($this->_result);}}}elseif(extension_loaded("pdo_oci")){class
Min_DB
extends
Min_PDO{var$extension="PDO_OCI";function
connect($M,$V,$E){$this->dsn("oci:dbname=//$M;charset=AL32UTF8",$V,$E);return
true;}function
select_db($j){return
true;}}}class
Min_Driver
extends
Min_SQL{function
begin(){return
true;}}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
connect(){global$b;$g=new
Min_DB;$Jb=$b->credentials();if($g->connect($Jb[0],$Jb[1],$Jb[2]))return$g;return$g->error;}function
get_databases(){return
get_vals("SELECT tablespace_name FROM user_tablespaces");}function
limit($F,$Z,$z,$C=0,$L=" "){return($C?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $F$Z) t WHERE rownum <= ".($z+$C).") WHERE rnum > $C":($z!==null?" * FROM (SELECT $F$Z) WHERE rownum <= ".($z+$C):" $F$Z"));}function
limit1($Q,$F,$Z,$L="\n"){return" $F$Z";}function
db_collation($l,$qb){global$g;return$g->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT USER FROM DUAL");}function
tables_list(){return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."
UNION SELECT view_name, 'view' FROM user_views
ORDER BY 1");}function
count_tables($k){return
array();}function
table_status($B=""){$H=array();$fh=q($B);foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q(DB).($B!=""?" AND table_name = $fh":"")."
UNION SELECT view_name, 'view', 0, 0 FROM user_views".($B!=""?" WHERE view_name = $fh":"")."
ORDER BY 1")as$I){if($B!="")return$I;$H[$I["Name"]]=$I;}return$H;}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){return
true;}function
fields($Q){$H=array();foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($Q)." ORDER BY column_id")as$I){$T=$I["DATA_TYPE"];$we="$I[DATA_PRECISION],$I[DATA_SCALE]";if($we==",")$we=$I["DATA_LENGTH"];$H[$I["COLUMN_NAME"]]=array("field"=>$I["COLUMN_NAME"],"full_type"=>$T.($we?"($we)":""),"type"=>strtolower($T),"length"=>$we,"default"=>$I["DATA_DEFAULT"],"null"=>($I["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);}return$H;}function
indexes($Q,$h=null){$H=array();foreach(get_rows("SELECT uic.*, uc.constraint_type
FROM user_ind_columns uic
LEFT JOIN user_constraints uc ON uic.index_name = uc.constraint_name AND uic.table_name = uc.table_name
WHERE uic.table_name = ".q($Q)."
ORDER BY uc.constraint_type, uic.column_position",$h)as$I){$Kd=$I["INDEX_NAME"];$H[$Kd]["type"]=($I["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($I["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$H[$Kd]["columns"][]=$I["COLUMN_NAME"];$H[$Kd]["lengths"][]=($I["CHAR_LENGTH"]&&$I["CHAR_LENGTH"]!=$I["COLUMN_LENGTH"]?$I["CHAR_LENGTH"]:null);$H[$Kd]["descs"][]=($I["DESCEND"]?'1':null);}return$H;}function
view($B){$J=get_rows('SELECT text "select" FROM user_views WHERE view_name = '.q($B));return
reset($J);}function
collations(){return
array();}function
information_schema($l){return
false;}function
error(){global$g;return
h($g->error);}function
explain($g,$F){$g->query("EXPLAIN PLAN FOR $F");return$g->query("SELECT * FROM plan_table");}function
found_rows($R,$Z){}function
alter_table($Q,$B,$p,$ed,$vb,$wc,$d,$Na,$Xf){$c=$hc=array();foreach($p
as$o){$X=$o[1];if($X&&$o[0]!=""&&idf_escape($o[0])!=$X[0])queries("ALTER TABLE ".table($Q)." RENAME COLUMN ".idf_escape($o[0])." TO $X[0]");if($X)$c[]=($Q!=""?($o[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($Q!=""?")":"");else$hc[]=idf_escape($o[0]);}if($Q=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)");return(!$c||queries("ALTER TABLE ".table($Q)."\n".implode("\n",$c)))&&(!$hc||queries("ALTER TABLE ".table($Q)." DROP (".implode(", ",$hc).")"))&&($Q==$B||queries("ALTER TABLE ".table($Q)." RENAME TO ".table($B)));}function
foreign_keys($Q){$H=array();$F="SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = ".q($Q);foreach(get_rows($F)as$I)$H[$I['NAME']]=array("db"=>$I['DEST_DB'],"table"=>$I['DEST_TABLE'],"source"=>array($I['SRC_COLUMN']),"target"=>array($I['DEST_COLUMN']),"on_delete"=>$I['ON_DELETE'],"on_update"=>null,);return$H;}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($dj){return
apply_queries("DROP VIEW",$dj);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
last_id(){return
0;}function
schemas(){return
get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX'))");}function
get_schema(){global$g;return$g->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($eh,$h=null){global$g;if(!$h)$h=$g;return$h->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($eh));}function
show_variables(){return
get_key_vals('SELECT name, display_value FROM v$parameter');}function
process_list(){return
get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');}function
show_status(){$J=get_rows('SELECT * FROM v$instance');return
reset($J);}function
convert_field($o){}function
unconvert_field($o,$H){return$H;}function
support($Rc){return
preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view|view_trigger)$~',$Rc);}$x="oracle";$U=array();$Kh=array();foreach(array(lang(27)=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),lang(28)=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),lang(25)=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),lang(29)=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),)as$y=>$X){$U+=$X;$Kh[$y]=array_keys($X);}$Li=array();$yf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");$md=array("length","lower","round","upper");$sd=array("avg","count","count distinct","max","min","sum");$oc=array(array("date"=>"current_date","timestamp"=>"current_timestamp",),array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",));}$gc["mssql"]="MS SQL (beta)";if(isset($_GET["mssql"])){$kg=array("SQLSRV","MSSQL","PDO_DBLIB");define("DRIVER","mssql");if(extension_loaded("sqlsrv")){class
Min_DB{var$extension="sqlsrv",$_link,$_result,$server_info,$affected_rows,$errno,$error;function
_get_error(){$this->error="";foreach(sqlsrv_errors()as$n){$this->errno=$n["code"];$this->error.="$n[message]\n";}$this->error=rtrim($this->error);}function
connect($M,$V,$E){global$b;$l=$b->database();$_b=array("UID"=>$V,"PWD"=>$E,"CharacterSet"=>"UTF-8");if($l!="")$_b["Database"]=$l;$this->_link=@sqlsrv_connect(preg_replace('~:~',',',$M),$_b);if($this->_link){$Rd=sqlsrv_server_info($this->_link);$this->server_info=$Rd['SQLServerVersion'];}else$this->_get_error();return(bool)$this->_link;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($j){return$this->query("USE ".idf_escape($j));}function
query($F,$Fi=false){$G=sqlsrv_query($this->_link,$F);$this->error="";if(!$G){$this->_get_error();return
false;}return$this->store_result($G);}function
multi_query($F){$this->_result=sqlsrv_query($this->_link,$F);$this->error="";if(!$this->_result){$this->_get_error();return
false;}return
true;}function
store_result($G=null){if(!$G)$G=$this->_result;if(!$G)return
false;if(sqlsrv_field_metadata($G))return
new
Min_Result($G);$this->affected_rows=sqlsrv_rows_affected($G);return
true;}function
next_result(){return$this->_result?sqlsrv_next_result($this->_result):null;}function
result($F,$o=0){$G=$this->query($F);if(!is_object($G))return
false;$I=$G->fetch_row();return$I[$o];}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($G){$this->_result=$G;}function
_convert($I){foreach((array)$I
as$y=>$X){if(is_a($X,'DateTime'))$I[$y]=$X->format("Y-m-d H:i:s");}return$I;}function
fetch_assoc(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_ASSOC));}function
fetch_row(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_NUMERIC));}function
fetch_field(){if(!$this->_fields)$this->_fields=sqlsrv_field_metadata($this->_result);$o=$this->_fields[$this->_offset++];$H=new
stdClass;$H->name=$o["Name"];$H->orgname=$o["Name"];$H->type=($o["Type"]==1?254:0);return$H;}function
seek($C){for($s=0;$s<$C;$s++)sqlsrv_fetch($this->_result);}function
__destruct(){sqlsrv_free_stmt($this->_result);}}}elseif(extension_loaded("mssql")){class
Min_DB{var$extension="MSSQL",$_link,$_result,$server_info,$affected_rows,$error;function
connect($M,$V,$E){$this->_link=@mssql_connect($M,$V,$E);if($this->_link){$G=$this->query("SELECT SERVERPROPERTY('ProductLevel'), SERVERPROPERTY('Edition')");if($G){$I=$G->fetch_row();$this->server_info=$this->result("sp_server_info 2",2)." [$I[0]] $I[1]";}}else$this->error=mssql_get_last_message();return(bool)$this->_link;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($j){return
mssql_select_db($j);}function
query($F,$Fi=false){$G=@mssql_query($F,$this->_link);$this->error="";if(!$G){$this->error=mssql_get_last_message();return
false;}if($G===true){$this->affected_rows=mssql_rows_affected($this->_link);return
true;}return
new
Min_Result($G);}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
mssql_next_result($this->_result->_result);}function
result($F,$o=0){$G=$this->query($F);if(!is_object($G))return
false;return
mssql_result($G->_result,0,$o);}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($G){$this->_result=$G;$this->num_rows=mssql_num_rows($G);}function
fetch_assoc(){return
mssql_fetch_assoc($this->_result);}function
fetch_row(){return
mssql_fetch_row($this->_result);}function
num_rows(){return
mssql_num_rows($this->_result);}function
fetch_field(){$H=mssql_fetch_field($this->_result);$H->orgtable=$H->table;$H->orgname=$H->name;return$H;}function
seek($C){mssql_data_seek($this->_result,$C);}function
__destruct(){mssql_free_result($this->_result);}}}elseif(extension_loaded("pdo_dblib")){class
Min_DB
extends
Min_PDO{var$extension="PDO_DBLIB";function
connect($M,$V,$E){$this->dsn("dblib:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$E);return
true;}function
select_db($j){return$this->query("USE ".idf_escape($j));}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($Q,$J,$ng){foreach($J
as$N){$Mi=array();$Z=array();foreach($N
as$y=>$X){$Mi[]="$y = $X";if(isset($ng[idf_unescape($y)]))$Z[]="$y = $X";}if(!queries("MERGE ".table($Q)." USING (VALUES(".implode(", ",$N).")) AS source (c".implode(", c",range(1,count($N))).") ON ".implode(" AND ",$Z)." WHEN MATCHED THEN UPDATE SET ".implode(", ",$Mi)." WHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).");"))return
false;}return
true;}function
begin(){return
queries("BEGIN TRANSACTION");}}function
idf_escape($u){return"[".str_replace("]","]]",$u)."]";}function
table($u){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($u);}function
connect(){global$b;$g=new
Min_DB;$Jb=$b->credentials();if($g->connect($Jb[0],$Jb[1],$Jb[2]))return$g;return$g->error;}function
get_databases(){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($F,$Z,$z,$C=0,$L=" "){return($z!==null?" TOP (".($z+$C).")":"")." $F$Z";}function
limit1($Q,$F,$Z,$L="\n"){return
limit($F,$Z,1,0,$L);}function
db_collation($l,$qb){global$g;return$g->result("SELECT collation_name FROM sys.databases WHERE name = ".q($l));}function
engines(){return
array();}function
logged_user(){global$g;return$g->result("SELECT SUSER_NAME()");}function
tables_list(){return
get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ORDER BY name");}function
count_tables($k){global$g;$H=array();foreach($k
as$l){$g->select_db($l);$H[$l]=$g->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");}return$H;}function
table_status($B=""){$H=array();foreach(get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment FROM sys.all_objects AS ao WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ".($B!=""?"AND name = ".q($B):"ORDER BY name"))as$I){if($B!="")return$I;$H[$I["Name"]]=$I;}return$H;}function
is_view($R){return$R["Engine"]=="VIEW";}function
fk_support($R){return
true;}function
fields($Q){$wb=get_key_vals("SELECT objname, cast(value as varchar) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', ".q(get_schema()).", 'table', ".q($Q).", 'column', NULL)");$H=array();foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default]
FROM sys.all_columns c
JOIN sys.all_objects o ON c.object_id = o.object_id
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.parent_column_id
WHERE o.schema_id = SCHEMA_ID(".q(get_schema()).") AND o.type IN ('S', 'U', 'V') AND o.name = ".q($Q))as$I){$T=$I["type"];$we=(preg_match("~char|binary~",$T)?$I["max_length"]:($T=="decimal"?"$I[precision],$I[scale]":""));$H[$I["name"]]=array("field"=>$I["name"],"full_type"=>$T.($we?"($we)":""),"type"=>$T,"length"=>$we,"default"=>$I["default"],"null"=>$I["is_nullable"],"auto_increment"=>$I["is_identity"],"collation"=>$I["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),"primary"=>$I["is_identity"],"comment"=>$wb[$I["name"]],);}return$H;}function
indexes($Q,$h=null){$H=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($Q),$h)as$I){$B=$I["name"];$H[$B]["type"]=($I["is_primary_key"]?"PRIMARY":($I["is_unique"]?"UNIQUE":"INDEX"));$H[$B]["lengths"]=array();$H[$B]["columns"][$I["key_ordinal"]]=$I["column_name"];$H[$B]["descs"][$I["key_ordinal"]]=($I["is_descending_key"]?'1':null);}return$H;}function
view($B){global$g;return
array("select"=>preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU','',$g->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($B))));}function
collations(){$H=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$d)$H[preg_replace('~_.*~','',$d)][]=$d;return$H;}function
information_schema($l){return
false;}function
error(){global$g;return
nl_br(h(preg_replace('~^(\[[^]]*])+~m','',$g->error)));}function
create_database($l,$d){return
queries("CREATE DATABASE ".idf_escape($l).(preg_match('~^[a-z0-9_]+$~i',$d)?" COLLATE $d":""));}function
drop_databases($k){return
queries("DROP DATABASE ".implode(", ",array_map('idf_escape',$k)));}function
rename_database($B,$d){if(preg_match('~^[a-z0-9_]+$~i',$d))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $d");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($B));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($Q,$B,$p,$ed,$vb,$wc,$d,$Na,$Xf){$c=array();$wb=array();foreach($p
as$o){$e=idf_escape($o[0]);$X=$o[1];if(!$X)$c["DROP"][]=" COLUMN $e";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~",'\1\2',$X[1]);$wb[$o[0]]=$X[5];unset($X[5]);if($o[0]=="")$c["ADD"][]="\n  ".implode("",$X).($Q==""?substr($ed[$X[0]],16+strlen($X[0])):"");else{unset($X[6]);if($e!=$X[0])queries("EXEC sp_rename ".q(table($Q).".$e").", ".q(idf_unescape($X[0])).", 'COLUMN'");$c["ALTER COLUMN ".implode("",$X)][]="";}}}if($Q=="")return
queries("CREATE TABLE ".table($B)." (".implode(",",(array)$c["ADD"])."\n)");if($Q!=$B)queries("EXEC sp_rename ".q(table($Q)).", ".q($B));if($ed)$c[""]=$ed;foreach($c
as$y=>$X){if(!queries("ALTER TABLE ".idf_escape($B)." $y".implode(",",$X)))return
false;}foreach($wb
as$y=>$X){$vb=substr($X,9);queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table',  @level1name = ".q($B).", @level2type = N'Column', @level2name = ".q($y));queries("EXEC sp_addextendedproperty @name = N'MS_Description', @value = ".$vb.", @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table',  @level1name = ".q($B).", @level2type = N'Column', @level2name = ".q($y));}return
true;}function
alter_indexes($Q,$c){$v=array();$hc=array();foreach($c
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$hc[]=idf_escape($X[1]);else$v[]=idf_escape($X[1])." ON ".table($Q);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q):"ALTER TABLE ".table($Q)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$v||queries("DROP INDEX ".implode(", ",$v)))&&(!$hc||queries("ALTER TABLE ".table($Q)." DROP ".implode(", ",$hc)));}function
last_id(){global$g;return$g->result("SELECT SCOPE_IDENTITY()");}function
explain($g,$F){$g->query("SET SHOWPLAN_ALL ON");$H=$g->query($F);$g->query("SET SHOWPLAN_ALL OFF");return$H;}function
found_rows($R,$Z){}function
foreign_keys($Q){$H=array();foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($Q))as$I){$q=&$H[$I["FK_NAME"]];$q["db"]=$I["PKTABLE_QUALIFIER"];$q["table"]=$I["PKTABLE_NAME"];$q["source"][]=$I["FKCOLUMN_NAME"];$q["target"][]=$I["PKCOLUMN_NAME"];}return$H;}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($dj){return
queries("DROP VIEW ".implode(", ",array_map('table',$dj)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('table',$S)));}function
move_tables($S,$dj,$ai){return
apply_queries("ALTER SCHEMA ".idf_escape($ai)." TRANSFER",array_merge($S,$dj));}function
trigger($B){if($B=="")return
array();$J=get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = ".q($B));$H=reset($J);if($H)$H["Statement"]=preg_replace('~^.+\s+AS\s+~isU','',$H["text"]);return$H;}function
triggers($Q){$H=array();foreach(get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = ".q($Q))as$I)$H[$I["name"]]=array($I["Timing"],$I["Event"]);return$H;}function
trigger_options(){return
array("Timing"=>array("AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("AS"),);}function
schemas(){return
get_vals("SELECT name FROM sys.schemas");}function
get_schema(){global$g;if($_GET["ns"]!="")return$_GET["ns"];return$g->result("SELECT SCHEMA_NAME()");}function
set_schema($dh){return
true;}function
use_sql($j){return"USE ".idf_escape($j);}function
show_variables(){return
array();}function
show_status(){return
array();}function
convert_field($o){}function
unconvert_field($o,$H){return$H;}function
support($Rc){return
preg_match('~^(comment|columns|database|drop_col|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~',$Rc);}$x="mssql";$U=array();$Kh=array();foreach(array(lang(27)=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),lang(28)=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),lang(25)=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),lang(29)=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),)as$y=>$X){$U+=$X;$Kh[$y]=array_keys($X);}$Li=array();$yf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");$md=array("len","lower","round","upper");$sd=array("avg","count","count distinct","max","min","sum");$oc=array(array("date|time"=>"getdate",),array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",));}$gc['firebird']='Firebird (alpha)';if(isset($_GET["firebird"])){$kg=array("interbase");define("DRIVER","firebird");if(extension_loaded("interbase")){class
Min_DB{var$extension="Firebird",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($M,$V,$E){$this->_link=ibase_connect($M,$V,$E);if($this->_link){$Pi=explode(':',$M);$this->service_link=ibase_service_attach($Pi[0],$V,$E);$this->server_info=ibase_server_info($this->service_link,IBASE_SVC_SERVER_VERSION);}else{$this->errno=ibase_errcode();$this->error=ibase_errmsg();}return(bool)$this->_link;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($j){return($j=="domain");}function
query($F,$Fi=false){$G=ibase_query($F,$this->_link);if(!$G){$this->errno=ibase_errcode();$this->error=ibase_errmsg();return
false;}$this->error="";if($G===true){$this->affected_rows=ibase_affected_rows($this->_link);return
true;}return
new
Min_Result($G);}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($F,$o=0){$G=$this->query($F);if(!$G||!$G->num_rows)return
false;$I=$G->fetch_row();return$I[$o];}}class
Min_Result{var$num_rows,$_result,$_offset=0;function
__construct($G){$this->_result=$G;}function
fetch_assoc(){return
ibase_fetch_assoc($this->_result);}function
fetch_row(){return
ibase_fetch_row($this->_result);}function
fetch_field(){$o=ibase_field_info($this->_result,$this->_offset++);return(object)array('name'=>$o['name'],'orgname'=>$o['name'],'type'=>$o['type'],'charsetnr'=>$o['length'],);}function
__destruct(){ibase_free_result($this->_result);}}}class
Min_Driver
extends
Min_SQL{}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
connect(){global$b;$g=new
Min_DB;$Jb=$b->credentials();if($g->connect($Jb[0],$Jb[1],$Jb[2]))return$g;return$g->error;}function
get_databases($cd){return
array("domain");}function
limit($F,$Z,$z,$C=0,$L=" "){$H='';$H.=($z!==null?$L."FIRST $z".($C?" SKIP $C":""):"");$H.=" $F$Z";return$H;}function
limit1($Q,$F,$Z,$L="\n"){return
limit($F,$Z,1,0,$L);}function
db_collation($l,$qb){}function
engines(){return
array();}function
logged_user(){global$b;$Jb=$b->credentials();return$Jb[1];}function
tables_list(){global$g;$F='SELECT RDB$RELATION_NAME FROM rdb$relations WHERE rdb$system_flag = 0';$G=ibase_query($g->_link,$F);$H=array();while($I=ibase_fetch_assoc($G))$H[$I['RDB$RELATION_NAME']]='table';ksort($H);return$H;}function
count_tables($k){return
array();}function
table_status($B="",$Qc=false){global$g;$H=array();$Ob=tables_list();foreach($Ob
as$v=>$X){$v=trim($v);$H[$v]=array('Name'=>$v,'Engine'=>'standard',);if($B==$v)return$H[$v];}return$H;}function
is_view($R){return
false;}function
fk_support($R){return
preg_match('~InnoDB|IBMDB2I~i',$R["Engine"]);}function
fields($Q){global$g;$H=array();$F='SELECT r.RDB$FIELD_NAME AS field_name,
r.RDB$DESCRIPTION AS field_description,
r.RDB$DEFAULT_VALUE AS field_default_value,
r.RDB$NULL_FLAG AS field_not_null_constraint,
f.RDB$FIELD_LENGTH AS field_length,
f.RDB$FIELD_PRECISION AS field_precision,
f.RDB$FIELD_SCALE AS field_scale,
CASE f.RDB$FIELD_TYPE
WHEN 261 THEN \'BLOB\'
WHEN 14 THEN \'CHAR\'
WHEN 40 THEN \'CSTRING\'
WHEN 11 THEN \'D_FLOAT\'
WHEN 27 THEN \'DOUBLE\'
WHEN 10 THEN \'FLOAT\'
WHEN 16 THEN \'INT64\'
WHEN 8 THEN \'INTEGER\'
WHEN 9 THEN \'QUAD\'
WHEN 7 THEN \'SMALLINT\'
WHEN 12 THEN \'DATE\'
WHEN 13 THEN \'TIME\'
WHEN 35 THEN \'TIMESTAMP\'
WHEN 37 THEN \'VARCHAR\'
ELSE \'UNKNOWN\'
END AS field_type,
f.RDB$FIELD_SUB_TYPE AS field_subtype,
coll.RDB$COLLATION_NAME AS field_collation,
cset.RDB$CHARACTER_SET_NAME AS field_charset
FROM RDB$RELATION_FIELDS r
LEFT JOIN RDB$FIELDS f ON r.RDB$FIELD_SOURCE = f.RDB$FIELD_NAME
LEFT JOIN RDB$COLLATIONS coll ON f.RDB$COLLATION_ID = coll.RDB$COLLATION_ID
LEFT JOIN RDB$CHARACTER_SETS cset ON f.RDB$CHARACTER_SET_ID = cset.RDB$CHARACTER_SET_ID
WHERE r.RDB$RELATION_NAME = '.q($Q).'
ORDER BY r.RDB$FIELD_POSITION';$G=ibase_query($g->_link,$F);while($I=ibase_fetch_assoc($G))$H[trim($I['FIELD_NAME'])]=array("field"=>trim($I["FIELD_NAME"]),"full_type"=>trim($I["FIELD_TYPE"]),"type"=>trim($I["FIELD_SUB_TYPE"]),"default"=>trim($I['FIELD_DEFAULT_VALUE']),"null"=>(trim($I["FIELD_NOT_NULL_CONSTRAINT"])=="YES"),"auto_increment"=>'0',"collation"=>trim($I["FIELD_COLLATION"]),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),"comment"=>trim($I["FIELD_DESCRIPTION"]),);return$H;}function
indexes($Q,$h=null){$H=array();return$H;}function
foreign_keys($Q){return
array();}function
collations(){return
array();}function
information_schema($l){return
false;}function
error(){global$g;return
h($g->error);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($dh){return
true;}function
support($Rc){return
preg_match("~^(columns|sql|status|table)$~",$Rc);}$x="firebird";$yf=array("=");$md=array();$sd=array();$oc=array();}$gc["simpledb"]="SimpleDB";if(isset($_GET["simpledb"])){$kg=array("SimpleXML + allow_url_fopen");define("DRIVER","simpledb");if(class_exists('SimpleXMLElement')&&ini_bool('allow_url_fopen')){class
Min_DB{var$extension="SimpleXML",$server_info='2009-04-15',$error,$timeout,$next,$affected_rows,$_result;function
select_db($j){return($j=="domain");}function
query($F,$Fi=false){$Rf=array('SelectExpression'=>$F,'ConsistentRead'=>'true');if($this->next)$Rf['NextToken']=$this->next;$G=sdb_request_all('Select','Item',$Rf,$this->timeout);$this->timeout=0;if($G===false)return$G;if(preg_match('~^\s*SELECT\s+COUNT\(~i',$F)){$Oh=0;foreach($G
as$de)$Oh+=$de->Attribute->Value;$G=array((object)array('Attribute'=>array((object)array('Name'=>'Count','Value'=>$Oh,))));}return
new
Min_Result($G);}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
quote($P){return"'".str_replace("'","''",$P)."'";}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0;function
__construct($G){foreach($G
as$de){$I=array();if($de->Name!='')$I['itemName()']=(string)$de->Name;foreach($de->Attribute
as$Ja){$B=$this->_processValue($Ja->Name);$Y=$this->_processValue($Ja->Value);if(isset($I[$B])){$I[$B]=(array)$I[$B];$I[$B][]=$Y;}else$I[$B]=$Y;}$this->_rows[]=$I;foreach($I
as$y=>$X){if(!isset($this->_rows[0][$y]))$this->_rows[0][$y]=null;}}$this->num_rows=count($this->_rows);}function
_processValue($rc){return(is_object($rc)&&$rc['encoding']=='base64'?base64_decode($rc):(string)$rc);}function
fetch_assoc(){$I=current($this->_rows);if(!$I)return$I;$H=array();foreach($this->_rows[0]as$y=>$X)$H[$y]=$I[$y];next($this->_rows);return$H;}function
fetch_row(){$H=$this->fetch_assoc();if(!$H)return$H;return
array_values($H);}function
fetch_field(){$je=array_keys($this->_rows[0]);return(object)array('name'=>$je[$this->_offset++]);}}}class
Min_Driver
extends
Min_SQL{public$ng="itemName()";function
_chunkRequest($Gd,$wa,$Rf,$Gc=array()){global$g;foreach(array_chunk($Gd,25)as$jb){$Sf=$Rf;foreach($jb
as$s=>$t){$Sf["Item.$s.ItemName"]=$t;foreach($Gc
as$y=>$X)$Sf["Item.$s.$y"]=$X;}if(!sdb_request($wa,$Sf))return
false;}$g->affected_rows=count($Gd);return
true;}function
_extractIds($Q,$zg,$z){$H=array();if(preg_match_all("~itemName\(\) = (('[^']*+')+)~",$zg,$Ge))$H=array_map('idf_unescape',$Ge[1]);else{foreach(sdb_request_all('Select','Item',array('SelectExpression'=>'SELECT itemName() FROM '.table($Q).$zg.($z?" LIMIT 1":"")))as$de)$H[]=$de->Name;}return$H;}function
select($Q,$K,$Z,$pd,$Cf=array(),$z=1,$D=0,$pg=false){global$g;$g->next=$_GET["next"];$H=parent::select($Q,$K,$Z,$pd,$Cf,$z,$D,$pg);$g->next=0;return$H;}function
delete($Q,$zg,$z=0){return$this->_chunkRequest($this->_extractIds($Q,$zg,$z),'BatchDeleteAttributes',array('DomainName'=>$Q));}function
update($Q,$N,$zg,$z=0,$L="\n"){$Xb=array();$Vd=array();$s=0;$Gd=$this->_extractIds($Q,$zg,$z);$t=idf_unescape($N["`itemName()`"]);unset($N["`itemName()`"]);foreach($N
as$y=>$X){$y=idf_unescape($y);if($X=="NULL"||($t!=""&&array($t)!=$Gd))$Xb["Attribute.".count($Xb).".Name"]=$y;if($X!="NULL"){foreach((array)$X
as$fe=>$W){$Vd["Attribute.$s.Name"]=$y;$Vd["Attribute.$s.Value"]=(is_array($X)?$W:idf_unescape($W));if(!$fe)$Vd["Attribute.$s.Replace"]="true";$s++;}}}$Rf=array('DomainName'=>$Q);return(!$Vd||$this->_chunkRequest(($t!=""?array($t):$Gd),'BatchPutAttributes',$Rf,$Vd))&&(!$Xb||$this->_chunkRequest($Gd,'BatchDeleteAttributes',$Rf,$Xb));}function
insert($Q,$N){$Rf=array("DomainName"=>$Q);$s=0;foreach($N
as$B=>$Y){if($Y!="NULL"){$B=idf_unescape($B);if($B=="itemName()")$Rf["ItemName"]=idf_unescape($Y);else{foreach((array)$Y
as$X){$Rf["Attribute.$s.Name"]=$B;$Rf["Attribute.$s.Value"]=(is_array($Y)?$X:idf_unescape($Y));$s++;}}}}return
sdb_request('PutAttributes',$Rf);}function
insertUpdate($Q,$J,$ng){foreach($J
as$N){if(!$this->update($Q,$N,"WHERE `itemName()` = ".q($N["`itemName()`"])))return
false;}return
true;}function
begin(){return
false;}function
commit(){return
false;}function
rollback(){return
false;}function
slowQuery($F,$ii){$this->_conn->timeout=$ii;return$F;}}function
connect(){global$b;list(,,$E)=$b->credentials();if($E!="")return
lang(22);return
new
Min_DB;}function
support($Rc){return
preg_match('~sql~',$Rc);}function
logged_user(){global$b;$Jb=$b->credentials();return$Jb[1];}function
get_databases(){return
array("domain");}function
collations(){return
array();}function
db_collation($l,$qb){}function
tables_list(){global$g;$H=array();foreach(sdb_request_all('ListDomains','DomainName')as$Q)$H[(string)$Q]='table';if($g->error&&defined("PAGE_HEADER"))echo"<p class='error'>".error()."\n";return$H;}function
table_status($B="",$Qc=false){$H=array();foreach(($B!=""?array($B=>true):tables_list())as$Q=>$T){$I=array("Name"=>$Q,"Auto_increment"=>"");if(!$Qc){$Te=sdb_request('DomainMetadata',array('DomainName'=>$Q));if($Te){foreach(array("Rows"=>"ItemCount","Data_length"=>"ItemNamesSizeBytes","Index_length"=>"AttributeValuesSizeBytes","Data_free"=>"AttributeNamesSizeBytes",)as$y=>$X)$I[$y]=(string)$Te->$X;}}if($B!="")return$I;$H[$Q]=$I;}return$H;}function
explain($g,$F){}function
error(){global$g;return
h($g->error);}function
information_schema(){}function
is_view($R){}function
indexes($Q,$h=null){return
array(array("type"=>"PRIMARY","columns"=>array("itemName()")),);}function
fields($Q){return
fields_from_edit();}function
foreign_keys($Q){return
array();}function
table($u){return
idf_escape($u);}function
idf_escape($u){return"`".str_replace("`","``",$u)."`";}function
limit($F,$Z,$z,$C=0,$L=" "){return" $F$Z".($z!==null?$L."LIMIT $z":"");}function
unconvert_field($o,$H){return$H;}function
fk_support($R){}function
engines(){return
array();}function
alter_table($Q,$B,$p,$ed,$vb,$wc,$d,$Na,$Xf){return($Q==""&&sdb_request('CreateDomain',array('DomainName'=>$B)));}function
drop_tables($S){foreach($S
as$Q){if(!sdb_request('DeleteDomain',array('DomainName'=>$Q)))return
false;}return
true;}function
count_tables($k){foreach($k
as$l)return
array($l=>count(tables_list()));}function
found_rows($R,$Z){return($Z?null:$R["Rows"]);}function
last_id(){}function
hmac($Ca,$Ob,$y,$Cg=false){$Wa=64;if(strlen($y)>$Wa)$y=pack("H*",$Ca($y));$y=str_pad($y,$Wa,"\0");$ge=$y^str_repeat("\x36",$Wa);$he=$y^str_repeat("\x5C",$Wa);$H=$Ca($he.pack("H*",$Ca($ge.$Ob)));if($Cg)$H=pack("H*",$H);return$H;}function
sdb_request($wa,$Rf=array()){global$b,$g;list($Cd,$Rf['AWSAccessKeyId'],$gh)=$b->credentials();$Rf['Action']=$wa;$Rf['Timestamp']=gmdate('Y-m-d\TH:i:s+00:00');$Rf['Version']='2009-04-15';$Rf['SignatureVersion']=2;$Rf['SignatureMethod']='HmacSHA1';ksort($Rf);$F='';foreach($Rf
as$y=>$X)$F.='&'.rawurlencode($y).'='.rawurlencode($X);$F=str_replace('%7E','~',substr($F,1));$F.="&Signature=".urlencode(base64_encode(hmac('sha1',"POST\n".preg_replace('~^https?://~','',$Cd)."\n/\n$F",$gh,true)));@ini_set('track_errors',1);$Vc=@file_get_contents((preg_match('~^https?://~',$Cd)?$Cd:"http://$Cd"),false,stream_context_create(array('http'=>array('method'=>'POST','content'=>$F,'ignore_errors'=>1,))));if(!$Vc){$g->error=$php_errormsg;return
false;}libxml_use_internal_errors(true);$qj=simplexml_load_string($Vc);if(!$qj){$n=libxml_get_last_error();$g->error=$n->message;return
false;}if($qj->Errors){$n=$qj->Errors->Error;$g->error="$n->Message ($n->Code)";return
false;}$g->error='';$Zh=$wa."Result";return($qj->$Zh?$qj->$Zh:true);}function
sdb_request_all($wa,$Zh,$Rf=array(),$ii=0){$H=array();$Gh=($ii?microtime(true):0);$z=(preg_match('~LIMIT\s+(\d+)\s*$~i',$Rf['SelectExpression'],$A)?$A[1]:0);do{$qj=sdb_request($wa,$Rf);if(!$qj)break;foreach($qj->$Zh
as$rc)$H[]=$rc;if($z&&count($H)>=$z){$_GET["next"]=$qj->NextToken;break;}if($ii&&microtime(true)-$Gh>$ii)return
false;$Rf['NextToken']=$qj->NextToken;if($z)$Rf['SelectExpression']=preg_replace('~\d+\s*$~',$z-count($H),$Rf['SelectExpression']);}while($qj->NextToken);return$H;}$x="simpledb";$yf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","IS NOT NULL");$md=array();$sd=array("count");$oc=array(array("json"));}$gc["mongo"]="MongoDB";if(isset($_GET["mongo"])){$kg=array("mongo","mongodb");define("DRIVER","mongo");if(class_exists('MongoDB')){class
Min_DB{var$extension="Mongo",$server_info=MongoClient::VERSION,$error,$last_id,$_link,$_db;function
connect($Ni,$Af){return@new
MongoClient($Ni,$Af);}function
query($F){return
false;}function
select_db($j){try{$this->_db=$this->_link->selectDB($j);return
true;}catch(Exception$Cc){$this->error=$Cc->getMessage();return
false;}}function
quote($P){return$P;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($G){foreach($G
as$de){$I=array();foreach($de
as$y=>$X){if(is_a($X,'MongoBinData'))$this->_charset[$y]=63;$I[$y]=(is_a($X,'MongoId')?'ObjectId("'.strval($X).'")':(is_a($X,'MongoDate')?gmdate("Y-m-d H:i:s",$X->sec)." GMT":(is_a($X,'MongoBinData')?$X->bin:(is_a($X,'MongoRegex')?strval($X):(is_object($X)?get_class($X):$X)))));}$this->_rows[]=$I;foreach($I
as$y=>$X){if(!isset($this->_rows[0][$y]))$this->_rows[0][$y]=null;}}$this->num_rows=count($this->_rows);}function
fetch_assoc(){$I=current($this->_rows);if(!$I)return$I;$H=array();foreach($this->_rows[0]as$y=>$X)$H[$y]=$I[$y];next($this->_rows);return$H;}function
fetch_row(){$H=$this->fetch_assoc();if(!$H)return$H;return
array_values($H);}function
fetch_field(){$je=array_keys($this->_rows[0]);$B=$je[$this->_offset++];return(object)array('name'=>$B,'charsetnr'=>$this->_charset[$B],);}}class
Min_Driver
extends
Min_SQL{public$ng="_id";function
select($Q,$K,$Z,$pd,$Cf=array(),$z=1,$D=0,$pg=false){$K=($K==array("*")?array():array_fill_keys($K,true));$yh=array();foreach($Cf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Gb);$yh[$X]=($Gb?-1:1);}return
new
Min_Result($this->_conn->_db->selectCollection($Q)->find(array(),$K)->sort($yh)->limit($z!=""?+$z:0)->skip($D*$z));}function
insert($Q,$N){try{$H=$this->_conn->_db->selectCollection($Q)->insert($N);$this->_conn->errno=$H['code'];$this->_conn->error=$H['err'];$this->_conn->last_id=$N['_id'];return!$H['err'];}catch(Exception$Cc){$this->_conn->error=$Cc->getMessage();return
false;}}}function
get_databases($cd){global$g;$H=array();$Tb=$g->_link->listDBs();foreach($Tb['databases']as$l)$H[]=$l['name'];return$H;}function
count_tables($k){global$g;$H=array();foreach($k
as$l)$H[$l]=count($g->_link->selectDB($l)->getCollectionNames(true));return$H;}function
tables_list(){global$g;return
array_fill_keys($g->_db->getCollectionNames(true),'table');}function
drop_databases($k){global$g;foreach($k
as$l){$Pg=$g->_link->selectDB($l)->drop();if(!$Pg['ok'])return
false;}return
true;}function
indexes($Q,$h=null){global$g;$H=array();foreach($g->_db->selectCollection($Q)->getIndexInfo()as$v){$ac=array();foreach($v["key"]as$e=>$T)$ac[]=($T==-1?'1':null);$H[$v["name"]]=array("type"=>($v["name"]=="_id_"?"PRIMARY":($v["unique"]?"UNIQUE":"INDEX")),"columns"=>array_keys($v["key"]),"lengths"=>array(),"descs"=>$ac,);}return$H;}function
fields($Q){return
fields_from_edit();}function
found_rows($R,$Z){global$g;return$g->_db->selectCollection($_GET["select"])->count($Z);}$yf=array("=");}elseif(class_exists('MongoDB\Driver\Manager')){class
Min_DB{var$extension="MongoDB",$server_info=MONGODB_VERSION,$error,$last_id;var$_link;var$_db,$_db_name;function
connect($Ni,$Af){$lb='MongoDB\Driver\Manager';return
new$lb($Ni,$Af);}function
query($F){return
false;}function
select_db($j){$this->_db_name=$j;return
true;}function
quote($P){return$P;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($G){foreach($G
as$de){$I=array();foreach($de
as$y=>$X){if(is_a($X,'MongoDB\BSON\Binary'))$this->_charset[$y]=63;$I[$y]=(is_a($X,'MongoDB\BSON\ObjectID')?'MongoDB\BSON\ObjectID("'.strval($X).'")':(is_a($X,'MongoDB\BSON\UTCDatetime')?$X->toDateTime()->format('Y-m-d H:i:s'):(is_a($X,'MongoDB\BSON\Binary')?$X->bin:(is_a($X,'MongoDB\BSON\Regex')?strval($X):(is_object($X)?json_encode($X,256):$X)))));}$this->_rows[]=$I;foreach($I
as$y=>$X){if(!isset($this->_rows[0][$y]))$this->_rows[0][$y]=null;}}$this->num_rows=$G->count;}function
fetch_assoc(){$I=current($this->_rows);if(!$I)return$I;$H=array();foreach($this->_rows[0]as$y=>$X)$H[$y]=$I[$y];next($this->_rows);return$H;}function
fetch_row(){$H=$this->fetch_assoc();if(!$H)return$H;return
array_values($H);}function
fetch_field(){$je=array_keys($this->_rows[0]);$B=$je[$this->_offset++];return(object)array('name'=>$B,'charsetnr'=>$this->_charset[$B],);}}class
Min_Driver
extends
Min_SQL{public$ng="_id";function
select($Q,$K,$Z,$pd,$Cf=array(),$z=1,$D=0,$pg=false){global$g;$K=($K==array("*")?array():array_fill_keys($K,1));if(count($K)&&!isset($K['_id']))$K['_id']=0;$Z=where_to_query($Z);$yh=array();foreach($Cf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Gb);$yh[$X]=($Gb?-1:1);}if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>0)$z=$_GET['limit'];$z=min(200,max(1,(int)$z));$vh=$D*$z;$lb='MongoDB\Driver\Query';$F=new$lb($Z,array('projection'=>$K,'limit'=>$z,'skip'=>$vh,'sort'=>$yh));$Sg=$g->_link->executeQuery("$g->_db_name.$Q",$F);return
new
Min_Result($Sg);}function
update($Q,$N,$zg,$z=0,$L="\n"){global$g;$l=$g->_db_name;$Z=sql_query_where_parser($zg);$lb='MongoDB\Driver\BulkWrite';$ab=new$lb(array());if(isset($N['_id']))unset($N['_id']);$Mg=array();foreach($N
as$y=>$Y){if($Y=='NULL'){$Mg[$y]=1;unset($N[$y]);}}$Mi=array('$set'=>$N);if(count($Mg))$Mi['$unset']=$Mg;$ab->update($Z,$Mi,array('upsert'=>false));$Sg=$g->_link->executeBulkWrite("$l.$Q",$ab);$g->affected_rows=$Sg->getModifiedCount();return
true;}function
delete($Q,$zg,$z=0){global$g;$l=$g->_db_name;$Z=sql_query_where_parser($zg);$lb='MongoDB\Driver\BulkWrite';$ab=new$lb(array());$ab->delete($Z,array('limit'=>$z));$Sg=$g->_link->executeBulkWrite("$l.$Q",$ab);$g->affected_rows=$Sg->getDeletedCount();return
true;}function
insert($Q,$N){global$g;$l=$g->_db_name;$lb='MongoDB\Driver\BulkWrite';$ab=new$lb(array());if(isset($N['_id'])&&empty($N['_id']))unset($N['_id']);$ab->insert($N);$Sg=$g->_link->executeBulkWrite("$l.$Q",$ab);$g->affected_rows=$Sg->getInsertedCount();return
true;}}function
get_databases($cd){global$g;$H=array();$lb='MongoDB\Driver\Command';$tb=new$lb(array('listDatabases'=>1));$Sg=$g->_link->executeCommand('admin',$tb);foreach($Sg
as$Tb){foreach($Tb->databases
as$l)$H[]=$l->name;}return$H;}function
count_tables($k){$H=array();return$H;}function
tables_list(){global$g;$lb='MongoDB\Driver\Command';$tb=new$lb(array('listCollections'=>1));$Sg=$g->_link->executeCommand($g->_db_name,$tb);$rb=array();foreach($Sg
as$G)$rb[$G->name]='table';return$rb;}function
drop_databases($k){return
false;}function
indexes($Q,$h=null){global$g;$H=array();$lb='MongoDB\Driver\Command';$tb=new$lb(array('listIndexes'=>$Q));$Sg=$g->_link->executeCommand($g->_db_name,$tb);foreach($Sg
as$v){$ac=array();$f=array();foreach(get_object_vars($v->key)as$e=>$T){$ac[]=($T==-1?'1':null);$f[]=$e;}$H[$v->name]=array("type"=>($v->name=="_id_"?"PRIMARY":(isset($v->unique)?"UNIQUE":"INDEX")),"columns"=>$f,"lengths"=>array(),"descs"=>$ac,);}return$H;}function
fields($Q){$p=fields_from_edit();if(!count($p)){global$m;$G=$m->select($Q,array("*"),null,null,array(),10);while($I=$G->fetch_assoc()){foreach($I
as$y=>$X){$I[$y]=null;$p[$y]=array("field"=>$y,"type"=>"string","null"=>($y!=$m->primary),"auto_increment"=>($y==$m->primary),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,),);}}}return$p;}function
found_rows($R,$Z){global$g;$Z=where_to_query($Z);$lb='MongoDB\Driver\Command';$tb=new$lb(array('count'=>$R['Name'],'query'=>$Z));$Sg=$g->_link->executeCommand($g->_db_name,$tb);$qi=$Sg->toArray();return$qi[0]->n;}function
sql_query_where_parser($zg){$zg=trim(preg_replace('/WHERE[\s]?[(]?\(?/','',$zg));$zg=preg_replace('/\)\)\)$/',')',$zg);$nj=explode(' AND ',$zg);$oj=explode(') OR (',$zg);$Z=array();foreach($nj
as$lj)$Z[]=trim($lj);if(count($oj)==1)$oj=array();elseif(count($oj)>1)$Z=array();return
where_to_query($Z,$oj);}function
where_to_query($jj=array(),$kj=array()){global$b;$Ob=array();foreach(array('and'=>$jj,'or'=>$kj)as$T=>$Z){if(is_array($Z)){foreach($Z
as$Jc){list($ob,$wf,$X)=explode(" ",$Jc,3);if($ob=="_id"){$X=str_replace('MongoDB\BSON\ObjectID("',"",$X);$X=str_replace('")',"",$X);$lb='MongoDB\BSON\ObjectID';$X=new$lb($X);}if(!in_array($wf,$b->operators))continue;if(preg_match('~^\(f\)(.+)~',$wf,$A)){$X=(float)$X;$wf=$A[1];}elseif(preg_match('~^\(date\)(.+)~',$wf,$A)){$Qb=new
DateTime($X);$lb='MongoDB\BSON\UTCDatetime';$X=new$lb($Qb->getTimestamp()*1000);$wf=$A[1];}switch($wf){case'=':$wf='$eq';break;case'!=':$wf='$ne';break;case'>':$wf='$gt';break;case'<':$wf='$lt';break;case'>=':$wf='$gte';break;case'<=':$wf='$lte';break;case'regex':$wf='$regex';break;default:continue
2;}if($T=='and')$Ob['$and'][]=array($ob=>array($wf=>$X));elseif($T=='or')$Ob['$or'][]=array($ob=>array($wf=>$X));}}}return$Ob;}$yf=array("=","!=",">","<",">=","<=","regex","(f)=","(f)!=","(f)>","(f)<","(f)>=","(f)<=","(date)=","(date)!=","(date)>","(date)<","(date)>=","(date)<=",);}function
table($u){return$u;}function
idf_escape($u){return$u;}function
table_status($B="",$Qc=false){$H=array();foreach(tables_list()as$Q=>$T){$H[$Q]=array("Name"=>$Q);if($B==$Q)return$H[$Q];}return$H;}function
create_database($l,$d){return
true;}function
last_id(){global$g;return$g->last_id;}function
error(){global$g;return
h($g->error);}function
collations(){return
array();}function
logged_user(){global$b;$Jb=$b->credentials();return$Jb[1];}function
connect(){global$b;$g=new
Min_DB;list($M,$V,$E)=$b->credentials();$Af=array();if($V.$E!=""){$Af["username"]=$V;$Af["password"]=$E;}$l=$b->database();if($l!="")$Af["db"]=$l;if(($Ma=getenv("MONGO_AUTH_SOURCE")))$Af["authSource"]=$Ma;try{$g->_link=$g->connect("mongodb://$M",$Af);if($E!=""){$Af["password"]="";try{$g->connect("mongodb://$M",$Af);return
lang(22);}catch(Exception$Cc){}}return$g;}catch(Exception$Cc){return$Cc->getMessage();}}function
alter_indexes($Q,$c){global$g;foreach($c
as$X){list($T,$B,$N)=$X;if($N=="DROP")$H=$g->_db->command(array("deleteIndexes"=>$Q,"index"=>$B));else{$f=array();foreach($N
as$e){$e=preg_replace('~ DESC$~','',$e,1,$Gb);$f[$e]=($Gb?-1:1);}$H=$g->_db->selectCollection($Q)->ensureIndex($f,array("unique"=>($T=="UNIQUE"),"name"=>$B,));}if($H['errmsg']){$g->error=$H['errmsg'];return
false;}}return
true;}function
support($Rc){return
preg_match("~database|indexes|descidx~",$Rc);}function
db_collation($l,$qb){}function
information_schema(){}function
is_view($R){}function
convert_field($o){}function
unconvert_field($o,$H){return$H;}function
foreign_keys($Q){return
array();}function
fk_support($R){}function
engines(){return
array();}function
alter_table($Q,$B,$p,$ed,$vb,$wc,$d,$Na,$Xf){global$g;if($Q==""){$g->_db->createCollection($B);return
true;}}function
drop_tables($S){global$g;foreach($S
as$Q){$Pg=$g->_db->selectCollection($Q)->drop();if(!$Pg['ok'])return
false;}return
true;}function
truncate_tables($S){global$g;foreach($S
as$Q){$Pg=$g->_db->selectCollection($Q)->remove();if(!$Pg['ok'])return
false;}return
true;}$x="mongo";$md=array();$sd=array();$oc=array(array("json"));}$gc["elastic"]="Elasticsearch (beta)";if(isset($_GET["elastic"])){$kg=array("json + allow_url_fopen");define("DRIVER","elastic");if(function_exists('json_decode')&&ini_bool('allow_url_fopen')){class
Min_DB{var$extension="JSON",$server_info,$errno,$error,$_url;function
rootQuery($bg,$Bb=array(),$Ue='GET'){@ini_set('track_errors',1);$Vc=@file_get_contents("$this->_url/".ltrim($bg,'/'),false,stream_context_create(array('http'=>array('method'=>$Ue,'content'=>$Bb===null?$Bb:json_encode($Bb),'header'=>'Content-Type: application/json','ignore_errors'=>1,))));if(!$Vc){$this->error=$php_errormsg;return$Vc;}if(!preg_match('~^HTTP/[0-9.]+ 2~i',$http_response_header[0])){$this->error=$Vc;return
false;}$H=json_decode($Vc,true);if($H===null){$this->errno=json_last_error();if(function_exists('json_last_error_msg'))$this->error=json_last_error_msg();else{$Ab=get_defined_constants(true);foreach($Ab['json']as$B=>$Y){if($Y==$this->errno&&preg_match('~^JSON_ERROR_~',$B)){$this->error=$B;break;}}}}return$H;}function
query($bg,$Bb=array(),$Ue='GET'){return$this->rootQuery(($this->_db!=""?"$this->_db/":"/").ltrim($bg,'/'),$Bb,$Ue);}function
connect($M,$V,$E){preg_match('~^(https?://)?(.*)~',$M,$A);$this->_url=($A[1]?$A[1]:"http://")."$V:$E@$A[2]";$H=$this->query('');if($H)$this->server_info=$H['version']['number'];return(bool)$H;}function
select_db($j){$this->_db=$j;return
true;}function
quote($P){return$P;}}class
Min_Result{var$num_rows,$_rows;function
__construct($J){$this->num_rows=count($J);$this->_rows=$J;reset($this->_rows);}function
fetch_assoc(){$H=current($this->_rows);next($this->_rows);return$H;}function
fetch_row(){return
array_values($this->fetch_assoc());}}}class
Min_Driver
extends
Min_SQL{function
select($Q,$K,$Z,$pd,$Cf=array(),$z=1,$D=0,$pg=false){global$b;$Ob=array();$F="$Q/_search";if($K!=array("*"))$Ob["fields"]=$K;if($Cf){$yh=array();foreach($Cf
as$ob){$ob=preg_replace('~ DESC$~','',$ob,1,$Gb);$yh[]=($Gb?array($ob=>"desc"):$ob);}$Ob["sort"]=$yh;}if($z){$Ob["size"]=+$z;if($D)$Ob["from"]=($D*$z);}foreach($Z
as$X){list($ob,$wf,$X)=explode(" ",$X,3);if($ob=="_id")$Ob["query"]["ids"]["values"][]=$X;elseif($ob.$X!=""){$di=array("term"=>array(($ob!=""?$ob:"_all")=>$X));if($wf=="=")$Ob["query"]["filtered"]["filter"]["and"][]=$di;else$Ob["query"]["filtered"]["query"]["bool"]["must"][]=$di;}}if($Ob["query"]&&!$Ob["query"]["filtered"]["query"]&&!$Ob["query"]["ids"])$Ob["query"]["filtered"]["query"]=array("match_all"=>array());$Gh=microtime(true);$fh=$this->_conn->query($F,$Ob);if($pg)echo$b->selectQuery("$F: ".json_encode($Ob),$Gh,!$fh);if(!$fh)return
false;$H=array();foreach($fh['hits']['hits']as$Bd){$I=array();if($K==array("*"))$I["_id"]=$Bd["_id"];$p=$Bd['_source'];if($K!=array("*")){$p=array();foreach($K
as$y)$p[$y]=$Bd['fields'][$y];}foreach($p
as$y=>$X){if($Ob["fields"])$X=$X[0];$I[$y]=(is_array($X)?json_encode($X):$X);}$H[]=$I;}return
new
Min_Result($H);}function
update($T,$Dg,$zg,$z=0,$L="\n"){$Zf=preg_split('~ *= *~',$zg);if(count($Zf)==2){$t=trim($Zf[1]);$F="$T/$t";return$this->_conn->query($F,$Dg,'POST');}return
false;}function
insert($T,$Dg){$t="";$F="$T/$t";$Pg=$this->_conn->query($F,$Dg,'POST');$this->_conn->last_id=$Pg['_id'];return$Pg['created'];}function
delete($T,$zg,$z=0){$Gd=array();if(is_array($_GET["where"])&&$_GET["where"]["_id"])$Gd[]=$_GET["where"]["_id"];if(is_array($_POST['check'])){foreach($_POST['check']as$eb){$Zf=preg_split('~ *= *~',$eb);if(count($Zf)==2)$Gd[]=trim($Zf[1]);}}$this->_conn->affected_rows=0;foreach($Gd
as$t){$F="{$T}/{$t}";$Pg=$this->_conn->query($F,'{}','DELETE');if(is_array($Pg)&&$Pg['found']==true)$this->_conn->affected_rows++;}return$this->_conn->affected_rows;}}function
connect(){global$b;$g=new
Min_DB;list($M,$V,$E)=$b->credentials();if($E!=""&&$g->connect($M,$V,""))return
lang(22);if($g->connect($M,$V,$E))return$g;return$g->error;}function
support($Rc){return
preg_match("~database|table|columns~",$Rc);}function
logged_user(){global$b;$Jb=$b->credentials();return$Jb[1];}function
get_databases(){global$g;$H=$g->rootQuery('_aliases');if($H){$H=array_keys($H);sort($H,SORT_STRING);}return$H;}function
collations(){return
array();}function
db_collation($l,$qb){}function
engines(){return
array();}function
count_tables($k){global$g;$H=array();$G=$g->query('_stats');if($G&&$G['indices']){$Od=$G['indices'];foreach($Od
as$Nd=>$Hh){$Md=$Hh['total']['indexing'];$H[$Nd]=$Md['index_total'];}}return$H;}function
tables_list(){global$g;$H=$g->query('_mapping');if($H)$H=array_fill_keys(array_keys($H[$g->_db]["mappings"]),'table');return$H;}function
table_status($B="",$Qc=false){global$g;$fh=$g->query("_search",array("size"=>0,"aggregations"=>array("count_by_type"=>array("terms"=>array("field"=>"_type")))),"POST");$H=array();if($fh){$S=$fh["aggregations"]["count_by_type"]["buckets"];foreach($S
as$Q){$H[$Q["key"]]=array("Name"=>$Q["key"],"Engine"=>"table","Rows"=>$Q["doc_count"],);if($B!=""&&$B==$Q["key"])return$H[$B];}}return$H;}function
error(){global$g;return
h($g->error);}function
information_schema(){}function
is_view($R){}function
indexes($Q,$h=null){return
array(array("type"=>"PRIMARY","columns"=>array("_id")),);}function
fields($Q){global$g;$G=$g->query("$Q/_mapping");$H=array();if($G){$Ce=$G[$Q]['properties'];if(!$Ce)$Ce=$G[$g->_db]['mappings'][$Q]['properties'];if($Ce){foreach($Ce
as$B=>$o){$H[$B]=array("field"=>$B,"full_type"=>$o["type"],"type"=>$o["type"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);if($o["properties"]){unset($H[$B]["privileges"]["insert"]);unset($H[$B]["privileges"]["update"]);}}}}return$H;}function
foreign_keys($Q){return
array();}function
table($u){return$u;}function
idf_escape($u){return$u;}function
convert_field($o){}function
unconvert_field($o,$H){return$H;}function
fk_support($R){}function
found_rows($R,$Z){return
null;}function
create_database($l){global$g;return$g->rootQuery(urlencode($l),null,'PUT');}function
drop_databases($k){global$g;return$g->rootQuery(urlencode(implode(',',$k)),array(),'DELETE');}function
alter_table($Q,$B,$p,$ed,$vb,$wc,$d,$Na,$Xf){global$g;$vg=array();foreach($p
as$Oc){$Tc=trim($Oc[1][0]);$Uc=trim($Oc[1][1]?$Oc[1][1]:"text");$vg[$Tc]=array('type'=>$Uc);}if(!empty($vg))$vg=array('properties'=>$vg);return$g->query("_mapping/{$B}",$vg,'PUT');}function
drop_tables($S){global$g;$H=true;foreach($S
as$Q)$H=$H&&$g->query(urlencode($Q),array(),'DELETE');return$H;}function
last_id(){global$g;return$g->last_id;}$x="elastic";$yf=array("=","query");$md=array();$sd=array();$oc=array(array("json"));$U=array();$Kh=array();foreach(array(lang(27)=>array("long"=>3,"integer"=>5,"short"=>8,"byte"=>10,"double"=>20,"float"=>66,"half_float"=>12,"scaled_float"=>21),lang(28)=>array("date"=>10),lang(25)=>array("string"=>65535,"text"=>65535),lang(29)=>array("binary"=>255),)as$y=>$X){$U+=$X;$Kh[$y]=array_keys($X);}}$gc["clickhouse"]="ClickHouse (alpha)";if(isset($_GET["clickhouse"])){define("DRIVER","clickhouse");class
Min_DB{var$extension="JSON",$server_info,$errno,$_result,$error,$_url;var$_db='default';function
rootQuery($l,$F){@ini_set('track_errors',1);$Vc=@file_get_contents("$this->_url/?database=$l",false,stream_context_create(array('http'=>array('method'=>'POST','content'=>$this->isQuerySelectLike($F)?"$F FORMAT JSONCompact":$F,'header'=>'Content-type: application/x-www-form-urlencoded','ignore_errors'=>1,))));if($Vc===false){$this->error=$php_errormsg;return$Vc;}if(!preg_match('~^HTTP/[0-9.]+ 2~i',$http_response_header[0])){$this->error=$Vc;return
false;}$H=json_decode($Vc,true);if($H===null){if(!$this->isQuerySelectLike($F)&&$Vc==='')return
true;$this->errno=json_last_error();if(function_exists('json_last_error_msg'))$this->error=json_last_error_msg();else{$Ab=get_defined_constants(true);foreach($Ab['json']as$B=>$Y){if($Y==$this->errno&&preg_match('~^JSON_ERROR_~',$B)){$this->error=$B;break;}}}}return
new
Min_Result($H);}function
isQuerySelectLike($F){return(bool)preg_match('~^(select|show)~i',$F);}function
query($F){return$this->rootQuery($this->_db,$F);}function
connect($M,$V,$E){preg_match('~^(https?://)?(.*)~',$M,$A);$this->_url=($A[1]?$A[1]:"http://")."$V:$E@$A[2]";$H=$this->query('SELECT 1');return(bool)$H;}function
select_db($j){$this->_db=$j;return
true;}function
quote($P){return"'".addcslashes($P,"\\'")."'";}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($F,$o=0){$G=$this->query($F);return$G['data'];}}class
Min_Result{var$num_rows,$_rows,$columns,$meta,$_offset=0;function
__construct($G){$this->num_rows=$G['rows'];$this->_rows=$G['data'];$this->meta=$G['meta'];$this->columns=array_column($this->meta,'name');reset($this->_rows);}function
fetch_assoc(){$I=current($this->_rows);next($this->_rows);return$I===false?false:array_combine($this->columns,$I);}function
fetch_row(){$I=current($this->_rows);next($this->_rows);return$I;}function
fetch_field(){$e=$this->_offset++;$H=new
stdClass;if($e<count($this->columns)){$H->name=$this->meta[$e]['name'];$H->orgname=$H->name;$H->type=$this->meta[$e]['type'];}return$H;}}class
Min_Driver
extends
Min_SQL{function
delete($Q,$zg,$z=0){if($zg==='')$zg='WHERE 1=1';return
queries("ALTER TABLE ".table($Q)." DELETE $zg");}function
update($Q,$N,$zg,$z=0,$L="\n"){$Yi=array();foreach($N
as$y=>$X)$Yi[]="$y = $X";$F=$L.implode(",$L",$Yi);return
queries("ALTER TABLE ".table($Q)." UPDATE $F$zg");}}function
idf_escape($u){return"`".str_replace("`","``",$u)."`";}function
table($u){return
idf_escape($u);}function
explain($g,$F){return'';}function
found_rows($R,$Z){$J=get_vals("SELECT COUNT(*) FROM ".idf_escape($R["Name"]).($Z?" WHERE ".implode(" AND ",$Z):""));return
empty($J)?false:$J[0];}function
alter_table($Q,$B,$p,$ed,$vb,$wc,$d,$Na,$Xf){$c=$Cf=array();foreach($p
as$o){if($o[1][2]===" NULL")$o[1][1]=" Nullable({$o[1][1]})";elseif($o[1][2]===' NOT NULL')$o[1][2]='';if($o[1][3])$o[1][3]='';$c[]=($o[1]?($Q!=""?($o[0]!=""?"MODIFY COLUMN ":"ADD COLUMN "):" ").implode($o[1]):"DROP COLUMN ".idf_escape($o[0]));$Cf[]=$o[1][0];}$c=array_merge($c,$ed);$O=($wc?" ENGINE ".$wc:"");if($Q=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)$O$Xf".' ORDER BY ('.implode(',',$Cf).')');if($Q!=$B){$G=queries("RENAME TABLE ".table($Q)." TO ".table($B));if($c)$Q=$B;else
return$G;}if($O)$c[]=ltrim($O);return($c||$Xf?queries("ALTER TABLE ".table($Q)."\n".implode(",\n",$c).$Xf):true);}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($dj){return
drop_tables($dj);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
connect(){global$b;$g=new
Min_DB;$Jb=$b->credentials();if($g->connect($Jb[0],$Jb[1],$Jb[2]))return$g;return$g->error;}function
get_databases($cd){global$g;$G=get_rows('SHOW DATABASES');$H=array();foreach($G
as$I)$H[]=$I['name'];sort($H);return$H;}function
limit($F,$Z,$z,$C=0,$L=" "){return" $F$Z".($z!==null?$L."LIMIT $z".($C?", $C":""):"");}function
limit1($Q,$F,$Z,$L="\n"){return
limit($F,$Z,1,0,$L);}function
db_collation($l,$qb){}function
engines(){return
array('MergeTree');}function
logged_user(){global$b;$Jb=$b->credentials();return$Jb[1];}function
tables_list(){$G=get_rows('SHOW TABLES');$H=array();foreach($G
as$I)$H[$I['name']]='table';ksort($H);return$H;}function
count_tables($k){return
array();}function
table_status($B="",$Qc=false){global$g;$H=array();$S=get_rows("SELECT name, engine FROM system.tables WHERE database = ".q($g->_db));foreach($S
as$Q){$H[$Q['name']]=array('Name'=>$Q['name'],'Engine'=>$Q['engine'],);if($B===$Q['name'])return$H[$Q['name']];}return$H;}function
is_view($R){return
false;}function
fk_support($R){return
false;}function
convert_field($o){}function
unconvert_field($o,$H){if(in_array($o['type'],array("Int8","Int16","Int32","Int64","UInt8","UInt16","UInt32","UInt64","Float32","Float64")))return"to$o[type]($H)";return$H;}function
fields($Q){$H=array();$G=get_rows("SELECT name, type, default_expression FROM system.columns WHERE ".idf_escape('table')." = ".q($Q));foreach($G
as$I){$T=trim($I['type']);$if=strpos($T,'Nullable(')===0;$H[trim($I['name'])]=array("field"=>trim($I['name']),"full_type"=>$T,"type"=>$T,"default"=>trim($I['default_expression']),"null"=>$if,"auto_increment"=>'0',"privileges"=>array("insert"=>1,"select"=>1,"update"=>0),);}return$H;}function
indexes($Q,$h=null){return
array();}function
foreign_keys($Q){return
array();}function
collations(){return
array();}function
information_schema($l){return
false;}function
error(){global$g;return
h($g->error);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($dh){return
true;}function
auto_increment(){return'';}function
last_id(){return
0;}function
support($Rc){return
preg_match("~^(columns|sql|status|table|drop_col)$~",$Rc);}$x="clickhouse";$U=array();$Kh=array();foreach(array(lang(27)=>array("Int8"=>3,"Int16"=>5,"Int32"=>10,"Int64"=>19,"UInt8"=>3,"UInt16"=>5,"UInt32"=>10,"UInt64"=>20,"Float32"=>7,"Float64"=>16,'Decimal'=>38,'Decimal32'=>9,'Decimal64'=>18,'Decimal128'=>38),lang(28)=>array("Date"=>13,"DateTime"=>20),lang(25)=>array("String"=>0),lang(29)=>array("FixedString"=>0),)as$y=>$X){$U+=$X;$Kh[$y]=array_keys($X);}$Li=array();$yf=array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");$md=array();$sd=array("avg","count","count distinct","max","min","sum");$oc=array();}$gc=array("server"=>"MySQL")+$gc;if(!defined("DRIVER")){$kg=array("MySQLi","MySQL","PDO_MySQL");define("DRIVER","server");if(extension_loaded("mysqli")){class
Min_DB
extends
MySQLi{var$extension="MySQLi";function
__construct(){parent::init();}function
connect($M="",$V="",$E="",$j=null,$gg=null,$xh=null){global$b;mysqli_report(MYSQLI_REPORT_OFF);list($Cd,$gg)=explode(":",$M,2);$Fh=$b->connectSsl();if($Fh)$this->ssl_set($Fh['key'],$Fh['cert'],$Fh['ca'],'','');$H=@$this->real_connect(($M!=""?$Cd:ini_get("mysqli.default_host")),($M.$V!=""?$V:ini_get("mysqli.default_user")),($M.$V.$E!=""?$E:ini_get("mysqli.default_pw")),$j,(is_numeric($gg)?$gg:ini_get("mysqli.default_port")),(!is_numeric($gg)?$gg:$xh),($Fh?64:0));$this->options(MYSQLI_OPT_LOCAL_INFILE,false);return$H;}function
set_charset($db){if(parent::set_charset($db))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $db");}function
result($F,$o=0){$G=$this->query($F);if(!$G)return
false;$I=$G->fetch_array();return$I[$o];}function
quote($P){return"'".$this->escape_string($P)."'";}}}elseif(extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))){class
Min_DB{var$extension="MySQL",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($M,$V,$E){if(ini_bool("mysql.allow_local_infile")){$this->error=lang(32,"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");return
false;}$this->_link=@mysql_connect(($M!=""?$M:ini_get("mysql.default_host")),("$M$V"!=""?$V:ini_get("mysql.default_user")),("$M$V$E"!=""?$E:ini_get("mysql.default_password")),true,131072);if($this->_link)$this->server_info=mysql_get_server_info($this->_link);else$this->error=mysql_error();return(bool)$this->_link;}function
set_charset($db){if(function_exists('mysql_set_charset')){if(mysql_set_charset($db,$this->_link))return
true;mysql_set_charset('utf8',$this->_link);}return$this->query("SET NAMES $db");}function
quote($P){return"'".mysql_real_escape_string($P,$this->_link)."'";}function
select_db($j){return
mysql_select_db($j,$this->_link);}function
query($F,$Fi=false){$G=@($Fi?mysql_unbuffered_query($F,$this->_link):mysql_query($F,$this->_link));$this->error="";if(!$G){$this->errno=mysql_errno($this->_link);$this->error=mysql_error($this->_link);return
false;}if($G===true){$this->affected_rows=mysql_affected_rows($this->_link);$this->info=mysql_info($this->_link);return
true;}return
new
Min_Result($G);}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($F,$o=0){$G=$this->query($F);if(!$G||!$G->num_rows)return
false;return
mysql_result($G->_result,0,$o);}}class
Min_Result{var$num_rows,$_result,$_offset=0;function
__construct($G){$this->_result=$G;$this->num_rows=mysql_num_rows($G);}function
fetch_assoc(){return
mysql_fetch_assoc($this->_result);}function
fetch_row(){return
mysql_fetch_row($this->_result);}function
fetch_field(){$H=mysql_fetch_field($this->_result,$this->_offset++);$H->orgtable=$H->table;$H->orgname=$H->name;$H->charsetnr=($H->blob?63:0);return$H;}function
__destruct(){mysql_free_result($this->_result);}}}elseif(extension_loaded("pdo_mysql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_MySQL";function
connect($M,$V,$E){global$b;$Af=array(PDO::MYSQL_ATTR_LOCAL_INFILE=>false);$Fh=$b->connectSsl();if($Fh){if(!empty($Fh['key']))$Af[PDO::MYSQL_ATTR_SSL_KEY]=$Fh['key'];if(!empty($Fh['cert']))$Af[PDO::MYSQL_ATTR_SSL_CERT]=$Fh['cert'];if(!empty($Fh['ca']))$Af[PDO::MYSQL_ATTR_SSL_CA]=$Fh['ca'];}$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$E,$Af);return
true;}function
set_charset($db){$this->query("SET NAMES $db");}function
select_db($j){return$this->query("USE ".idf_escape($j));}function
query($F,$Fi=false){$this->setAttribute(1000,!$Fi);return
parent::query($F,$Fi);}}}class
Min_Driver
extends
Min_SQL{function
insert($Q,$N){return($N?parent::insert($Q,$N):queries("INSERT INTO ".table($Q)." ()\nVALUES ()"));}function
insertUpdate($Q,$J,$ng){$f=array_keys(reset($J));$lg="INSERT INTO ".table($Q)." (".implode(", ",$f).") VALUES\n";$Yi=array();foreach($f
as$y)$Yi[$y]="$y = VALUES($y)";$Nh="\nON DUPLICATE KEY UPDATE ".implode(", ",$Yi);$Yi=array();$we=0;foreach($J
as$N){$Y="(".implode(", ",$N).")";if($Yi&&(strlen($lg)+$we+strlen($Y)+strlen($Nh)>1e6)){if(!queries($lg.implode(",\n",$Yi).$Nh))return
false;$Yi=array();$we=0;}$Yi[]=$Y;$we+=strlen($Y)+2;}return
queries($lg.implode(",\n",$Yi).$Nh);}function
slowQuery($F,$ii){if(min_version('5.7.8','10.1.2')){if(preg_match('~MariaDB~',$this->_conn->server_info))return"SET STATEMENT max_statement_time=$ii FOR $F";elseif(preg_match('~^(SELECT\b)(.+)~is',$F,$A))return"$A[1] /*+ MAX_EXECUTION_TIME(".($ii*1000).") */ $A[2]";}}function
convertSearch($u,$X,$o){return(preg_match('~char|text|enum|set~',$o["type"])&&!preg_match("~^utf8~",$o["collation"])&&preg_match('~[\x80-\xFF]~',$X['val'])?"CONVERT($u USING ".charset($this->_conn).")":$u);}function
warnings(){$G=$this->_conn->query("SHOW WARNINGS");if($G&&$G->num_rows){ob_start();select($G);return
ob_get_clean();}}function
tableHelp($B){$De=preg_match('~MariaDB~',$this->_conn->server_info);if(information_schema(DB))return
strtolower(($De?"information-schema-$B-table/":str_replace("_","-",$B)."-table.html"));if(DB=="mysql")return($De?"mysql$B-table/":"system-database.html");}}function
idf_escape($u){return"`".str_replace("`","``",$u)."`";}function
table($u){return
idf_escape($u);}function
connect(){global$b,$U,$Kh;$g=new
Min_DB;$Jb=$b->credentials();if($g->connect($Jb[0],$Jb[1],$Jb[2])){$g->set_charset(charset($g));$g->query("SET sql_quote_show_create = 1, autocommit = 1");if(min_version('5.7.8',10.2,$g)){$Kh[lang(25)][]="json";$U["json"]=4294967295;}return$g;}$H=$g->error;if(function_exists('iconv')&&!is_utf8($H)&&strlen($bh=iconv("windows-1250","utf-8",$H))>strlen($H))$H=$bh;return$H;}function
get_databases($cd){$H=get_session("dbs");if($H===null){$F=(min_version(5)?"SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME":"SHOW DATABASES");$H=($cd?slow_query($F):get_vals($F));restart_session();set_session("dbs",$H);stop_session();}return$H;}function
limit($F,$Z,$z,$C=0,$L=" "){return" $F$Z".($z!==null?$L."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$F,$Z,$L="\n"){return
limit($F,$Z,1,0,$L);}function
db_collation($l,$qb){global$g;$H=null;$i=$g->result("SHOW CREATE DATABASE ".idf_escape($l),1);if(preg_match('~ COLLATE ([^ ]+)~',$i,$A))$H=$A[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$i,$A))$H=$qb[$A[1]][-1];return$H;}function
engines(){$H=array();foreach(get_rows("SHOW ENGINES")as$I){if(preg_match("~YES|DEFAULT~",$I["Support"]))$H[]=$I["Engine"];}return$H;}function
logged_user(){global$g;return$g->result("SELECT USER()");}function
tables_list(){return
get_key_vals(min_version(5)?"SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME":"SHOW TABLES");}function
count_tables($k){$H=array();foreach($k
as$l)$H[$l]=count(get_vals("SHOW TABLES IN ".idf_escape($l)));return$H;}function
table_status($B="",$Qc=false){$H=array();foreach(get_rows($Qc&&min_version(5)?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($B!=""?"AND TABLE_NAME = ".q($B):"ORDER BY Name"):"SHOW TABLE STATUS".($B!=""?" LIKE ".q(addcslashes($B,"%_\\")):""))as$I){if($I["Engine"]=="InnoDB")$I["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\1',$I["Comment"]);if(!isset($I["Engine"]))$I["Comment"]="";if($B!="")return$I;$H[$I["Name"]]=$I;}return$H;}function
is_view($R){return$R["Engine"]===null;}function
fk_support($R){return
preg_match('~InnoDB|IBMDB2I~i',$R["Engine"])||(preg_match('~NDB~i',$R["Engine"])&&min_version(5.6));}function
fields($Q){$H=array();foreach(get_rows("SHOW FULL COLUMNS FROM ".table($Q))as$I){preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~',$I["Type"],$A);$H[$I["Field"]]=array("field"=>$I["Field"],"full_type"=>$I["Type"],"type"=>$A[1],"length"=>$A[2],"unsigned"=>ltrim($A[3].$A[4]),"default"=>($I["Default"]!=""||preg_match("~char|set~",$A[1])?$I["Default"]:null),"null"=>($I["Null"]=="YES"),"auto_increment"=>($I["Extra"]=="auto_increment"),"on_update"=>(preg_match('~^on update (.+)~i',$I["Extra"],$A)?$A[1]:""),"collation"=>$I["Collation"],"privileges"=>array_flip(preg_split('~, *~',$I["Privileges"])),"comment"=>$I["Comment"],"primary"=>($I["Key"]=="PRI"),"generated"=>preg_match('~^(VIRTUAL|PERSISTENT|STORED)~',$I["Extra"]),);}return$H;}function
indexes($Q,$h=null){$H=array();foreach(get_rows("SHOW INDEX FROM ".table($Q),$h)as$I){$B=$I["Key_name"];$H[$B]["type"]=($B=="PRIMARY"?"PRIMARY":($I["Index_type"]=="FULLTEXT"?"FULLTEXT":($I["Non_unique"]?($I["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$H[$B]["columns"][]=$I["Column_name"];$H[$B]["lengths"][]=($I["Index_type"]=="SPATIAL"?null:$I["Sub_part"]);$H[$B]["descs"][]=null;}return$H;}function
foreign_keys($Q){global$g,$tf;static$dg='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';$H=array();$Hb=$g->result("SHOW CREATE TABLE ".table($Q),1);if($Hb){preg_match_all("~CONSTRAINT ($dg) FOREIGN KEY ?\\(((?:$dg,? ?)+)\\) REFERENCES ($dg)(?:\\.($dg))? \\(((?:$dg,? ?)+)\\)(?: ON DELETE ($tf))?(?: ON UPDATE ($tf))?~",$Hb,$Ge,PREG_SET_ORDER);foreach($Ge
as$A){preg_match_all("~$dg~",$A[2],$zh);preg_match_all("~$dg~",$A[5],$ai);$H[idf_unescape($A[1])]=array("db"=>idf_unescape($A[4]!=""?$A[3]:$A[4]),"table"=>idf_unescape($A[4]!=""?$A[4]:$A[3]),"source"=>array_map('idf_unescape',$zh[0]),"target"=>array_map('idf_unescape',$ai[0]),"on_delete"=>($A[6]?$A[6]:"RESTRICT"),"on_update"=>($A[7]?$A[7]:"RESTRICT"),);}}return$H;}function
view($B){global$g;return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU','',$g->result("SHOW CREATE VIEW ".table($B),1)));}function
collations(){$H=array();foreach(get_rows("SHOW COLLATION")as$I){if($I["Default"])$H[$I["Charset"]][-1]=$I["Collation"];else$H[$I["Charset"]][]=$I["Collation"];}ksort($H);foreach($H
as$y=>$X)asort($H[$y]);return$H;}function
information_schema($l){return(min_version(5)&&$l=="information_schema")||(min_version(5.5)&&$l=="performance_schema");}function
error(){global$g;return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",$g->error));}function
create_database($l,$d){return
queries("CREATE DATABASE ".idf_escape($l).($d?" COLLATE ".q($d):""));}function
drop_databases($k){$H=apply_queries("DROP DATABASE",$k,'idf_escape');restart_session();set_session("dbs",null);return$H;}function
rename_database($B,$d){$H=false;if(create_database($B,$d)){$Ng=array();foreach(tables_list()as$Q=>$T)$Ng[]=table($Q)." TO ".idf_escape($B).".".table($Q);$H=(!$Ng||queries("RENAME TABLE ".implode(", ",$Ng)));if($H)queries("DROP DATABASE ".idf_escape(DB));restart_session();set_session("dbs",null);}return$H;}function
auto_increment(){$Oa=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$v){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$v["columns"],true)){$Oa="";break;}if($v["type"]=="PRIMARY")$Oa=" UNIQUE";}}return" AUTO_INCREMENT$Oa";}function
alter_table($Q,$B,$p,$ed,$vb,$wc,$d,$Na,$Xf){$c=array();foreach($p
as$o)$c[]=($o[1]?($Q!=""?($o[0]!=""?"CHANGE ".idf_escape($o[0]):"ADD"):" ")." ".implode($o[1]).($Q!=""?$o[2]:""):"DROP ".idf_escape($o[0]));$c=array_merge($c,$ed);$O=($vb!==null?" COMMENT=".q($vb):"").($wc?" ENGINE=".q($wc):"").($d?" COLLATE ".q($d):"").($Na!=""?" AUTO_INCREMENT=$Na":"");if($Q=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)$O$Xf");if($Q!=$B)$c[]="RENAME TO ".table($B);if($O)$c[]=ltrim($O);return($c||$Xf?queries("ALTER TABLE ".table($Q)."\n".implode(",\n",$c).$Xf):true);}function
alter_indexes($Q,$c){foreach($c
as$y=>$X)$c[$y]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($Q).implode(",",$c));}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($dj){return
queries("DROP VIEW ".implode(", ",array_map('table',$dj)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('table',$S)));}function
move_tables($S,$dj,$ai){$Ng=array();foreach(array_merge($S,$dj)as$Q)$Ng[]=table($Q)." TO ".idf_escape($ai).".".table($Q);return
queries("RENAME TABLE ".implode(", ",$Ng));}function
copy_tables($S,$dj,$ai){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($S
as$Q){$B=($ai==DB?table("copy_$Q"):idf_escape($ai).".".table($Q));if(($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $B"))||!queries("CREATE TABLE $B LIKE ".table($Q))||!queries("INSERT INTO $B SELECT * FROM ".table($Q)))return
false;foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$I){$_i=$I["Trigger"];if(!queries("CREATE TRIGGER ".($ai==DB?idf_escape("copy_$_i"):idf_escape($ai).".".idf_escape($_i))." $I[Timing] $I[Event] ON $B FOR EACH ROW\n$I[Statement];"))return
false;}}foreach($dj
as$Q){$B=($ai==DB?table("copy_$Q"):idf_escape($ai).".".table($Q));$cj=view($Q);if(($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $B"))||!queries("CREATE VIEW $B AS $cj[select]"))return
false;}return
true;}function
trigger($B){if($B=="")return
array();$J=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($B));return
reset($J);}function
triggers($Q){$H=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$I)$H[$I["Trigger"]]=array($I["Timing"],$I["Event"]);return$H;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($B,$T){global$g,$yc,$Td,$U;$Da=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$_h="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Ei="((".implode("|",array_merge(array_keys($U),$Da)).")\\b(?:\\s*\\(((?:[^'\")]|$yc)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$dg="$_h*(".($T=="FUNCTION"?"":$Td).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Ei";$i=$g->result("SHOW CREATE $T ".idf_escape($B),2);preg_match("~\\(((?:$dg\\s*,?)*)\\)\\s*".($T=="FUNCTION"?"RETURNS\\s+$Ei\\s+":"")."(.*)~is",$i,$A);$p=array();preg_match_all("~$dg\\s*,?~is",$A[1],$Ge,PREG_SET_ORDER);foreach($Ge
as$Qf)$p[]=array("field"=>str_replace("``","`",$Qf[2]).$Qf[3],"type"=>strtolower($Qf[5]),"length"=>preg_replace_callback("~$yc~s",'normalize_enum',$Qf[6]),"unsigned"=>strtolower(preg_replace('~\s+~',' ',trim("$Qf[8] $Qf[7]"))),"null"=>1,"full_type"=>$Qf[4],"inout"=>strtoupper($Qf[1]),"collation"=>strtolower($Qf[9]),);if($T!="FUNCTION")return
array("fields"=>$p,"definition"=>$A[11]);return
array("fields"=>$p,"returns"=>array("type"=>$A[12],"length"=>$A[13],"unsigned"=>$A[15],"collation"=>$A[16]),"definition"=>$A[17],"language"=>"SQL",);}function
routines(){return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = ".q(DB));}function
routine_languages(){return
array();}function
routine_id($B,$I){return
idf_escape($B);}function
last_id(){global$g;return$g->result("SELECT LAST_INSERT_ID()");}function
explain($g,$F){return$g->query("EXPLAIN ".(min_version(5.1)?"PARTITIONS ":"").$F);}function
found_rows($R,$Z){return($Z||$R["Engine"]!="InnoDB"?null:$R["Rows"]);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($dh,$h=null){return
true;}function
create_sql($Q,$Na,$Lh){global$g;$H=$g->result("SHOW CREATE TABLE ".table($Q),1);if(!$Na)$H=preg_replace('~ AUTO_INCREMENT=\d+~','',$H);return$H;}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
use_sql($j){return"USE ".idf_escape($j);}function
trigger_sql($Q){$H="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")),null,"-- ")as$I)$H.="\nCREATE TRIGGER ".idf_escape($I["Trigger"])." $I[Timing] $I[Event] ON ".table($I["Table"])." FOR EACH ROW\n$I[Statement];;\n";return$H;}function
show_variables(){return
get_key_vals("SHOW VARIABLES");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
show_status(){return
get_key_vals("SHOW STATUS");}function
convert_field($o){if(preg_match("~binary~",$o["type"]))return"HEX(".idf_escape($o["field"]).")";if($o["type"]=="bit")return"BIN(".idf_escape($o["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$o["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($o["field"]).")";}function
unconvert_field($o,$H){if(preg_match("~binary~",$o["type"]))$H="UNHEX($H)";if($o["type"]=="bit")$H="CONV($H, 2, 10) + 0";if(preg_match("~geometry|point|linestring|polygon~",$o["type"]))$H=(min_version(8)?"ST_":"")."GeomFromText($H, SRID($o[field]))";return$H;}function
support($Rc){return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(8)?"":"|descidx".(min_version(5.1)?"":"|event|partitioning".(min_version(5)?"":"|routine|trigger|view")))."~",$Rc);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){global$g;return$g->result("SELECT @@max_connections");}$x="sql";$U=array();$Kh=array();foreach(array(lang(27)=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),lang(28)=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),lang(25)=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),lang(33)=>array("enum"=>65535,"set"=>64),lang(29)=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),lang(31)=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),)as$y=>$X){$U+=$X;$Kh[$y]=array_keys($X);}$Li=array("unsigned","zerofill","unsigned zerofill");$yf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");$md=array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper");$sd=array("avg","count","count distinct","group_concat","max","min","sum");$oc=array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",));}define("SERVER",$_GET[DRIVER]);define("DB",$_GET["db"]);define("ME",str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*).*~','\1',$_SERVER["REQUEST_URI"])).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));$ia="4.7.5";class
Adminer{var$operators;function
name(){return"<a href='https://www.adminer.org/'".target_blank()." id='h1'>Adminer</a>";}function
credentials(){return
array(SERVER,$_GET["username"],get_password());}function
connectSsl(){}function
permanentLogin($i=false){return
password_file($i);}function
bruteForceKey(){return$_SERVER["REMOTE_ADDR"];}function
serverName($M){return
h($M);}function
database(){return
DB;}function
databases($cd=true){return
get_databases($cd);}function
schemas(){return
schemas();}function
queryTimeout(){return
2;}function
headers(){}function
csp(){return
csp();}function
head(){return
true;}function
css(){$H=array();$Wc="adminer.css";if(file_exists($Wc))$H[]="$Wc?v=".crc32(file_get_contents($Wc));return$H;}function
loginForm(){global$gc;echo"<table cellspacing='0' class='layout'>\n",$this->loginFormField('driver','<tr><th>'.lang(34).'<td>',html_select("auth[driver]",$gc,DRIVER,"loginDriver(this);")."\n"),$this->loginFormField('server','<tr><th>'.lang(35).'<td>','<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'."\n"),$this->loginFormField('username','<tr><th>'.lang(36).'<td>','<input name="auth[username]" id="username" value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password','<tr><th>'.lang(37).'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'."\n"),$this->loginFormField('db','<tr><th>'.lang(38).'<td>','<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'."\n"),"</table>\n","<p><input type='submit' value='".lang(39)."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],lang(40))."\n";}function
loginFormField($B,$zd,$Y){return$zd.$Y;}function
login($Ae,$E){if($E=="")return
lang(41,target_blank());return
true;}function
tableName($Rh){return
h($Rh["Name"]);}function
fieldName($o,$Cf=0){return'<span title="'.h($o["full_type"]).'">'.h($o["field"]).'</span>';}function
selectLinks($Rh,$N=""){global$x,$m;echo'<p class="links">';$ze=array("select"=>lang(42));if(support("table")||support("indexes"))$ze["table"]=lang(43);if(support("table")){if(is_view($Rh))$ze["view"]=lang(44);else$ze["create"]=lang(45);}if($N!==null)$ze["edit"]=lang(46);$B=$Rh["Name"];foreach($ze
as$y=>$X)echo" <a href='".h(ME)."$y=".urlencode($B).($y=="edit"?$N:"")."'".bold(isset($_GET[$y])).">$X</a>";echo
doc_link(array($x=>$m->tableHelp($B)),"?"),"\n";}function
foreignKeys($Q){return
foreign_keys($Q);}function
backwardKeys($Q,$Qh){return
array();}function
backwardKeysPrint($Qa,$I){}function
selectQuery($F,$Gh,$Pc=false){global$x,$m;$H="</p>\n";if(!$Pc&&($gj=$m->warnings())){$t="warnings";$H=", <a href='#$t'>".lang(47)."</a>".script("qsl('a').onclick = partial(toggle, '$t');","")."$H<div id='$t' class='hidden'>\n$gj</div>\n";}return"<p><code class='jush-$x'>".h(str_replace("\n"," ",$F))."</code> <span class='time'>(".format_time($Gh).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($F)."'>".lang(10)."</a>":"").$H;}function
sqlCommandQuery($F){return
shorten_utf8(trim($F),1000);}function
rowDescription($Q){return"";}function
rowDescriptions($J,$fd){return$J;}function
selectLink($X,$o){}function
selectVal($X,$_,$o,$Kf){$H=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$o["type"])&&!preg_match("~var~",$o["type"])?"<code>$X</code>":$X));if(preg_match('~blob|bytea|raw|file~',$o["type"])&&!is_utf8($X))$H="<i>".lang(48,strlen($Kf))."</i>";if(preg_match('~json~',$o["type"]))$H="<code class='jush-js'>$H</code>";return($_?"<a href='".h($_)."'".(is_url($_)?target_blank():"").">$H</a>":$H);}function
editVal($X,$o){return$X;}function
tableStructurePrint($p){echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr><th>".lang(49)."<td>".lang(50).(support("comment")?"<td>".lang(51):"")."</thead>\n";foreach($p
as$o){echo"<tr".odd()."><th>".h($o["field"]),"<td><span title='".h($o["collation"])."'>".h($o["full_type"])."</span>",($o["null"]?" <i>NULL</i>":""),($o["auto_increment"]?" <i>".lang(52)."</i>":""),(isset($o["default"])?" <span title='".lang(53)."'>[<b>".h($o["default"])."</b>]</span>":""),(support("comment")?"<td>".h($o["comment"]):""),"\n";}echo"</table>\n","</div>\n";}function
tableIndexesPrint($w){echo"<table cellspacing='0'>\n";foreach($w
as$B=>$v){ksort($v["columns"]);$pg=array();foreach($v["columns"]as$y=>$X)$pg[]="<i>".h($X)."</i>".($v["lengths"][$y]?"(".$v["lengths"][$y].")":"").($v["descs"][$y]?" DESC":"");echo"<tr title='".h($B)."'><th>$v[type]<td>".implode(", ",$pg)."\n";}echo"</table>\n";}function
selectColumnsPrint($K,$f){global$md,$sd;print_fieldset("select",lang(54),$K);$s=0;$K[""]=array();foreach($K
as$y=>$X){$X=$_GET["columns"][$y];$e=select_input(" name='columns[$s][col]'",$f,$X["col"],($y!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($md||$sd?"<select name='columns[$s][fun]'>".optionlist(array(-1=>"")+array_filter(array(lang(55)=>$md,lang(56)=>$sd)),$X["fun"])."</select>".on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($y!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($e)":$e)."</div>\n";$s++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$f,$w){print_fieldset("search",lang(57),$Z);foreach($w
as$s=>$v){if($v["type"]=="FULLTEXT"){echo"<div>(<i>".implode("</i>, <i>",array_map('h',$v["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$s]' value='".h($_GET["fulltext"][$s])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$s]",1,isset($_GET["boolean"][$s]),"BOOL"),"</div>\n";}}$cb="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$s=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators))){echo"<div>".select_input(" name='where[$s][col]'",$f,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".lang(58).")"),html_select("where[$s][op]",$this->operators,$X["op"],$cb),"<input type='search' name='where[$s][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $cb }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}}echo"</div></fieldset>\n";}function
selectOrderPrint($Cf,$f,$w){print_fieldset("sort",lang(59),$Cf);$s=0;foreach((array)$_GET["order"]as$y=>$X){if($X!=""){echo"<div>".select_input(" name='order[$s]'",$f,$X,"selectFieldChange"),checkbox("desc[$s]",1,isset($_GET["desc"][$y]),lang(60))."</div>\n";$s++;}}echo"<div>".select_input(" name='order[$s]'",$f,"","selectAddRow"),checkbox("desc[$s]",1,false,lang(60))."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($z){echo"<fieldset><legend>".lang(61)."</legend><div>";echo"<input type='number' name='limit' class='size' value='".h($z)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($gi){if($gi!==null){echo"<fieldset><legend>".lang(62)."</legend><div>","<input type='number' name='text_length' class='size' value='".h($gi)."'>","</div></fieldset>\n";}}function
selectActionPrint($w){echo"<fieldset><legend>".lang(63)."</legend><div>","<input type='submit' value='".lang(54)."'>"," <span id='noindex' title='".lang(64)."'></span>","<script".nonce().">\n","var indexColumns = ";$f=array();foreach($w
as$v){$Nb=reset($v["columns"]);if($v["type"]!="FULLTEXT"&&$Nb)$f[$Nb]=1;}$f[""]=1;foreach($f
as$y=>$X)json_row($y);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint($tc,$f){}function
selectColumnsProcess($f,$w){global$md,$sd;$K=array();$pd=array();foreach((array)$_GET["columns"]as$y=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],$md)||in_array($X["fun"],$sd)))){$K[$y]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],$sd))$pd[]=$K[$y];}}return
array($K,$pd);}function
selectSearchProcess($p,$w){global$g,$m;$H=array();foreach($w
as$s=>$v){if($v["type"]=="FULLTEXT"&&$_GET["fulltext"][$s]!="")$H[]="MATCH (".implode(", ",array_map('idf_escape',$v["columns"])).") AGAINST (".q($_GET["fulltext"][$s]).(isset($_GET["boolean"][$s])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$y=>$X){if("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)){$lg="";$yb=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Jd=process_length($X["val"]);$yb.=" ".($Jd!=""?$Jd:"(NULL)");}elseif($X["op"]=="SQL")$yb=" $X[val]";elseif($X["op"]=="LIKE %%")$yb=" LIKE ".$this->processInput($p[$X["col"]],"%$X[val]%");elseif($X["op"]=="ILIKE %%")$yb=" ILIKE ".$this->processInput($p[$X["col"]],"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$lg="$X[op](".q($X["val"]).", ";$yb=")";}elseif(!preg_match('~NULL$~',$X["op"]))$yb.=" ".$this->processInput($p[$X["col"]],$X["val"]);if($X["col"]!="")$H[]=$lg.$m->convertSearch(idf_escape($X["col"]),$X,$p[$X["col"]]).$yb;else{$sb=array();foreach($p
as$B=>$o){if((preg_match('~^[-\d.'.(preg_match('~IN$~',$X["op"])?',':'').']+$~',$X["val"])||!preg_match('~'.number_type().'|bit~',$o["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$o["type"])))$sb[]=$lg.$m->convertSearch(idf_escape($B),$X,$o).$yb;}$H[]=($sb?"(".implode(" OR ",$sb).")":"1 = 0");}}}return$H;}function
selectOrderProcess($p,$w){$H=array();foreach((array)$_GET["order"]as$y=>$X){if($X!="")$H[]=(preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$y])?" DESC":"");}return$H;}function
selectLimitProcess(){return(isset($_GET["limit"])?$_GET["limit"]:"50");}function
selectLengthProcess(){return(isset($_GET["text_length"])?$_GET["text_length"]:"100");}function
selectEmailProcess($Z,$fd){return
false;}function
selectQueryBuild($K,$Z,$pd,$Cf,$z,$D){return"";}function
messageQuery($F,$hi,$Pc=false){global$x,$m;restart_session();$_d=&get_session("queries");if(!$_d[$_GET["db"]])$_d[$_GET["db"]]=array();if(strlen($F)>1e6)$F=preg_replace('~[\x80-\xFF]+$~','',substr($F,0,1e6))."\nâ€¦";$_d[$_GET["db"]][]=array($F,time(),$hi);$Dh="sql-".count($_d[$_GET["db"]]);$H="<a href='#$Dh' class='toggle'>".lang(65)."</a>\n";if(!$Pc&&($gj=$m->warnings())){$t="warnings-".count($_d[$_GET["db"]]);$H="<a href='#$t' class='toggle'>".lang(47)."</a>, $H<div id='$t' class='hidden'>\n$gj</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $H<div id='$Dh' class='hidden'><pre><code class='jush-$x'>".shorten_utf8($F,1000)."</code></pre>".($hi?" <span class='time'>($hi)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($_d[$_GET["db"]])-1)).'">'.lang(10).'</a>':'').'</div>';}function
editFunctions($o){global$oc;$H=($o["null"]?"NULL/":"");foreach($oc
as$y=>$md){if(!$y||(!isset($_GET["call"])&&(isset($_GET["select"])||where($_GET)))){foreach($md
as$dg=>$X){if(!$dg||preg_match("~$dg~",$o["type"]))$H.="/$X";}if($y&&!preg_match('~set|blob|bytea|raw|file~',$o["type"]))$H.="/SQL";}}if($o["auto_increment"]&&!isset($_GET["select"])&&!where($_GET))$H=lang(52);return
explode("/",$H);}function
editInput($Q,$o,$Ka,$Y){if($o["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$Ka value='-1' checked><i>".lang(8)."</i></label> ":"").($o["null"]?"<label><input type='radio'$Ka value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$Ka,$o,$Y,0);return"";}function
editHint($Q,$o,$Y){return"";}function
processInput($o,$Y,$r=""){if($r=="SQL")return$Y;$B=$o["field"];$H=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$r))$H="$r()";elseif(preg_match('~^current_(date|timestamp)$~',$r))$H=$r;elseif(preg_match('~^([+-]|\|\|)$~',$r))$H=idf_escape($B)." $r $H";elseif(preg_match('~^[+-] interval$~',$r))$H=idf_escape($B)." $r ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$H);elseif(preg_match('~^(addtime|subtime|concat)$~',$r))$H="$r(".idf_escape($B).", $H)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$r))$H="$r($H)";return
unconvert_field($o,$H);}function
dumpOutput(){$H=array('text'=>lang(66),'file'=>lang(67));if(function_exists('gzencode'))$H['gz']='gzip';return$H;}function
dumpFormat(){return
array('sql'=>'SQL','csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($l){}function
dumpTable($Q,$Lh,$ce=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($Lh)dump_csv(array_keys(fields($Q)));}else{if($ce==2){$p=array();foreach(fields($Q)as$B=>$o)$p[]=idf_escape($B)." $o[full_type]";$i="CREATE TABLE ".table($Q)." (".implode(", ",$p).")";}else$i=create_sql($Q,$_POST["auto_increment"],$Lh);set_utf8mb4($i);if($Lh&&$i){if($Lh=="DROP+CREATE"||$ce==1)echo"DROP ".($ce==2?"VIEW":"TABLE")." IF EXISTS ".table($Q).";\n";if($ce==1)$i=remove_definer($i);echo"$i;\n\n";}}}function
dumpData($Q,$Lh,$F){global$g,$x;$Ie=($x=="sqlite"?0:1048576);if($Lh){if($_POST["format"]=="sql"){if($Lh=="TRUNCATE+INSERT")echo
truncate_sql($Q).";\n";$p=fields($Q);}$G=$g->query($F,1);if($G){$Vd="";$Za="";$je=array();$Nh="";$Sc=($Q!=''?'fetch_assoc':'fetch_row');while($I=$G->$Sc()){if(!$je){$Yi=array();foreach($I
as$X){$o=$G->fetch_field();$je[]=$o->name;$y=idf_escape($o->name);$Yi[]="$y = VALUES($y)";}$Nh=($Lh=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$Yi):"").";\n";}if($_POST["format"]!="sql"){if($Lh=="table"){dump_csv($je);$Lh="INSERT";}dump_csv($I);}else{if(!$Vd)$Vd="INSERT INTO ".table($Q)." (".implode(", ",array_map('idf_escape',$je)).") VALUES";foreach($I
as$y=>$X){$o=$p[$y];$I[$y]=($X!==null?unconvert_field($o,preg_match(number_type(),$o["type"])&&!preg_match('~\[~',$o["full_type"])&&is_numeric($X)?$X:q(($X===false?0:$X))):"NULL");}$bh=($Ie?"\n":" ")."(".implode(",\t",$I).")";if(!$Za)$Za=$Vd.$bh;elseif(strlen($Za)+4+strlen($bh)+strlen($Nh)<$Ie)$Za.=",$bh";else{echo$Za.$Nh;$Za=$Vd.$bh;}}}if($Za)echo$Za.$Nh;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",$g->error)."\n";}}function
dumpFilename($Ed){return
friendly_url($Ed!=""?$Ed:(SERVER!=""?SERVER:"localhost"));}function
dumpHeaders($Ed,$Xe=false){$Nf=$_POST["output"];$Kc=(preg_match('~sql~',$_POST["format"])?"sql":($Xe?"tar":"csv"));header("Content-Type: ".($Nf=="gz"?"application/x-gzip":($Kc=="tar"?"application/x-tar":($Kc=="sql"||$Nf!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($Nf=="gz")ob_start('ob_gzencode',1e6);return$Kc;}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.lang(68)."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?lang(69):lang(70))."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.lang(71)."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".lang(72)."</a>\n":"");return
true;}function
navigation($We){global$ia,$x,$gc,$g;echo'<h1>
',$this->name(),' <span class="version">',$ia,'</span>
<a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ia,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</h1>
';if($We=="auth"){$Nf="";foreach((array)$_SESSION["pwds"]as$aj=>$ph){foreach($ph
as$M=>$Vi){foreach($Vi
as$V=>$E){if($E!==null){$Tb=$_SESSION["db"][$aj][$M][$V];foreach(($Tb?array_keys($Tb):array(""))as$l)$Nf.="<li><a href='".h(auth_url($aj,$M,$V,$l))."'>($gc[$aj]) ".h($V.($M!=""?"@".$this->serverName($M):"").($l!=""?" - $l":""))."</a>\n";}}}}if($Nf)echo"<ul id='logins'>\n$Nf</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");}else{if($_GET["ns"]!==""&&!$We&&DB!=""){$g->select_db(DB);$S=table_status('',true);}echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=4.7.5");if(support("sql")){echo'<script',nonce(),'>
';if($S){$ze=array();foreach($S
as$Q=>$T)$ze[]=preg_quote($Q,'/');echo"var jushLinks = { $x: [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$ze).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.$x;\n";}$oh=$g->server_info;echo'bodyLoad(\'',(is_object($g)?preg_replace('~^(\d\.?\d).*~s','\1',$oh):""),'\'',(preg_match('~MariaDB~',$oh)?", true":""),');
</script>
';}$this->databasesPrint($We);if(DB==""||!$We){echo"<p class='links'>".(support("sql")?"<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".lang(65)."</a>\n<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".lang(73)."</a>\n":"")."";if(support("dump"))echo"<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".lang(74)."</a>\n";}if($_GET["ns"]!==""&&!$We&&DB!=""){echo'<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".lang(75)."</a>\n";if(!$S)echo"<p class='message'>".lang(9)."\n";else$this->tablesPrint($S);}}}function
databasesPrint($We){global$b,$g;$k=$this->databases();if($k&&!in_array(DB,$k))array_unshift($k,DB);echo'<form action="">
<p id="dbs">
';hidden_fields_get();$Rb=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".lang(76)."'>".lang(77)."</span>: ".($k?"<select name='db'>".optionlist(array(""=>"")+$k,DB)."</select>$Rb":"<input name='db' value='".h(DB)."' autocapitalize='off'>\n"),"<input type='submit' value='".lang(20)."'".($k?" class='hidden'":"").">\n";if($We!="db"&&DB!=""&&$g->select_db(DB)){if(support("scheme")){echo"<br>".lang(78).": <select name='ns'>".optionlist(array(""=>"")+$b->schemas(),$_GET["ns"])."</select>$Rb";if($_GET["ns"]!="")set_schema($_GET["ns"]);}}foreach(array("import","sql","schema","dump","privileges")as$X){if(isset($_GET[$X])){echo"<input type='hidden' name='$X' value=''>";break;}}echo"</p></form>\n";}function
tablesPrint($S){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($S
as$Q=>$O){$B=$this->tableName($O);if($B!=""){echo'<li><a href="'.h(ME).'select='.urlencode($Q).'"'.bold($_GET["select"]==$Q||$_GET["edit"]==$Q,"select").">".lang(79)."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($Q).'"'.bold(in_array($Q,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($O)?"view":"structure"))." title='".lang(43)."'>$B</a>":"<span>$B</span>")."\n";}}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
Adminer);if($b->operators===null)$b->operators=$yf;function
page_header($ki,$n="",$Ya=array(),$li=""){global$ca,$ia,$b,$gc,$x;page_headers();if(is_ajax()&&$n){page_messages($n);exit;}$mi=$ki.($li!=""?": $li":"");$ni=strip_tags($mi.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());echo'<!DOCTYPE html>
<html lang="',$ca,'" dir="',lang(80),'">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>',$ni,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=4.7.5"),'">
',script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=4.7.5");if($b->head()){echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.7.5"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.7.5"),'">
';foreach($b->css()as$Lb){echo'<link rel="stylesheet" type="text/css" href="',h($Lb),'">
';}}echo'
<body class="',lang(80),' nojs">
';$Wc=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($Wc)&&filemtime($Wc)+86400>time()){$bj=unserialize(file_get_contents($Wc));$wg="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($bj["version"],base64_decode($bj["signature"]),$wg)==1)$_COOKIE["adminer_version"]=$bj["version"];}echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ia', '".js_escape(ME)."', '".get_token()."')");?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape(lang(81)),'\';
var thousandsSeparator = \'',js_escape(lang(5)),'\';
</script>

<div id="help" class="jush-',$x,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';if($Ya!==null){$_=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($_?$_:".").'">'.$gc[DRIVER].'</a> &raquo; ';$_=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$M=$b->serverName(SERVER);$M=($M!=""?$M:lang(35));if($Ya===false)echo"$M\n";else{echo"<a href='".($_?h($_):".")."' accesskey='1' title='Alt+Shift+1'>$M</a> &raquo; ";if($_GET["ns"]!=""||(DB!=""&&is_array($Ya)))echo'<a href="'.h($_."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> &raquo; ';if(is_array($Ya)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> &raquo; ';foreach($Ya
as$y=>$X){$Zb=(is_array($X)?$X[1]:h($X));if($Zb!="")echo"<a href='".h(ME."$y=").urlencode(is_array($X)?$X[0]:$X)."'>$Zb</a> &raquo; ";}}echo"$ki\n";}}echo"<h2>$mi</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($n);$k=&get_session("dbs");if(DB!=""&&$k&&!in_array(DB,$k,true))$k=null;stop_session();define("PAGE_HEADER",1);}function
page_headers(){global$b;header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach($b->csp()as$Kb){$yd=array();foreach($Kb
as$y=>$X)$yd[]="$y $X";header("Content-Security-Policy: ".implode("; ",$yd));}$b->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$gf;if(!$gf)$gf=base64_encode(rand_string());return$gf;}function
page_messages($n){$Ni=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$Se=$_SESSION["messages"][$Ni];if($Se){echo"<div class='message'>".implode("</div>\n<div class='message'>",$Se)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$Ni]);}if($n)echo"<div class='error'>$n</div>\n";}function
page_footer($We=""){global$b,$ri;echo'</div>

';switch_lang();if($We!="auth"){echo'<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="',lang(82),'" id="logout">
<input type="hidden" name="token" value="',$ri,'">
</p>
</form>
';}echo'<div id="menu">
';$b->navigation($We);echo'</div>
',script("setupSubmitHighlight(document);");}function
int32($Ze){while($Ze>=2147483648)$Ze-=4294967296;while($Ze<=-2147483649)$Ze+=4294967296;return(int)$Ze;}function
long2str($W,$fj){$bh='';foreach($W
as$X)$bh.=pack('V',$X);if($fj)return
substr($bh,0,end($W));return$bh;}function
str2long($bh,$fj){$W=array_values(unpack('V*',str_pad($bh,4*ceil(strlen($bh)/4),"\0")));if($fj)$W[]=strlen($bh);return$W;}function
xxtea_mx($sj,$rj,$Oh,$fe){return
int32((($sj>>5&0x7FFFFFF)^$rj<<2)+(($rj>>3&0x1FFFFFFF)^$sj<<4))^int32(($Oh^$rj)+($fe^$sj));}function
encrypt_string($Jh,$y){if($Jh=="")return"";$y=array_values(unpack("V*",pack("H*",md5($y))));$W=str2long($Jh,true);$Ze=count($W)-1;$sj=$W[$Ze];$rj=$W[0];$xg=floor(6+52/($Ze+1));$Oh=0;while($xg-->0){$Oh=int32($Oh+0x9E3779B9);$nc=$Oh>>2&3;for($Of=0;$Of<$Ze;$Of++){$rj=$W[$Of+1];$Ye=xxtea_mx($sj,$rj,$Oh,$y[$Of&3^$nc]);$sj=int32($W[$Of]+$Ye);$W[$Of]=$sj;}$rj=$W[0];$Ye=xxtea_mx($sj,$rj,$Oh,$y[$Of&3^$nc]);$sj=int32($W[$Ze]+$Ye);$W[$Ze]=$sj;}return
long2str($W,false);}function
decrypt_string($Jh,$y){if($Jh=="")return"";if(!$y)return
false;$y=array_values(unpack("V*",pack("H*",md5($y))));$W=str2long($Jh,false);$Ze=count($W)-1;$sj=$W[$Ze];$rj=$W[0];$xg=floor(6+52/($Ze+1));$Oh=int32($xg*0x9E3779B9);while($Oh){$nc=$Oh>>2&3;for($Of=$Ze;$Of>0;$Of--){$sj=$W[$Of-1];$Ye=xxtea_mx($sj,$rj,$Oh,$y[$Of&3^$nc]);$rj=int32($W[$Of]-$Ye);$W[$Of]=$rj;}$sj=$W[$Ze];$Ye=xxtea_mx($sj,$rj,$Oh,$y[$Of&3^$nc]);$rj=int32($W[0]-$Ye);$W[0]=$rj;$Oh=int32($Oh-0x9E3779B9);}return
long2str($W,true);}$g='';$xd=$_SESSION["token"];if(!$xd)$_SESSION["token"]=rand(1,1e6);$ri=get_token();$eg=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($y)=explode(":",$X);$eg[$y]=$X;}}function
add_invalid_login(){global$b;$kd=file_open_lock(get_temp_dir()."/adminer.invalid");if(!$kd)return;$Yd=unserialize(stream_get_contents($kd));$hi=time();if($Yd){foreach($Yd
as$Zd=>$X){if($X[0]<$hi)unset($Yd[$Zd]);}}$Xd=&$Yd[$b->bruteForceKey()];if(!$Xd)$Xd=array($hi+30*60,0);$Xd[1]++;file_write_unlock($kd,serialize($Yd));}function
check_invalid_login(){global$b;$Yd=unserialize(@file_get_contents(get_temp_dir()."/adminer.invalid"));$Xd=$Yd[$b->bruteForceKey()];$ff=($Xd[1]>29?$Xd[0]-time():0);if($ff>0)auth_error(lang(83,ceil($ff/60)));}$La=$_POST["auth"];if($La){session_regenerate_id();$aj=$La["driver"];$M=$La["server"];$V=$La["username"];$E=(string)$La["password"];$l=$La["db"];set_password($aj,$M,$V,$E);$_SESSION["db"][$aj][$M][$V][$l]=true;if($La["permanent"]){$y=base64_encode($aj)."-".base64_encode($M)."-".base64_encode($V)."-".base64_encode($l);$qg=$b->permanentLogin(true);$eg[$y]="$y:".base64_encode($qg?encrypt_string($E,$qg):"");cookie("adminer_permanent",implode(" ",$eg));}if(count($_POST)==1||DRIVER!=$aj||SERVER!=$M||$_GET["username"]!==$V||DB!=$l)redirect(auth_url($aj,$M,$V,$l));}elseif($_POST["logout"]){if($xd&&!verify_token()){page_header(lang(82),lang(84));page_footer("db");exit;}else{foreach(array("pwds","db","dbs","queries")as$y)set_session($y,null);unset_permanent();redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),lang(85).' '.lang(86));}}elseif($eg&&!$_SESSION["pwds"]){session_regenerate_id();$qg=$b->permanentLogin();foreach($eg
as$y=>$X){list(,$kb)=explode(":",$X);list($aj,$M,$V,$l)=array_map('base64_decode',explode("-",$y));set_password($aj,$M,$V,decrypt_string(base64_decode($kb),$qg));$_SESSION["db"][$aj][$M][$V][$l]=true;}}function
unset_permanent(){global$eg;foreach($eg
as$y=>$X){list($aj,$M,$V,$l)=array_map('base64_decode',explode("-",$y));if($aj==DRIVER&&$M==SERVER&&$V==$_GET["username"]&&$l==DB)unset($eg[$y]);}cookie("adminer_permanent",implode(" ",$eg));}function
auth_error($n){global$b,$xd;$qh=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$qh]||$_GET[$qh])&&!$xd)$n=lang(87);else{restart_session();add_invalid_login();$E=get_password();if($E!==null){if($E===false)$n.='<br>'.lang(88,target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$qh]&&$_GET[$qh]&&ini_bool("session.use_only_cookies"))$n=lang(89);$Rf=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?$_COOKIE["adminer_key"]:rand_string()),$Rf["lifetime"]);page_header(lang(39),$n,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".lang(90)."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists("Min_DB")){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header(lang(91),lang(92,implode(", ",$kg)),false);page_footer("auth");exit;}stop_session(true);if(isset($_GET["username"])&&is_string(get_password())){list($Cd,$gg)=explode(":",SERVER,2);if(is_numeric($gg)&&$gg<1024)auth_error(lang(93));check_invalid_login();$g=connect();$m=new
Min_Driver($g);}$Ae=null;if(!is_object($g)||($Ae=$b->login($_GET["username"],get_password()))!==true){$n=(is_string($g)?h($g):(is_string($Ae)?$Ae:lang(94)));auth_error($n.(preg_match('~^ | $~',get_password())?'<br>'.lang(95):''));}if($La&&$_POST["token"])$_POST["token"]=$ri;$n='';if($_POST){if(!verify_token()){$Sd="max_input_vars";$Me=ini_get($Sd);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$y){$X=ini_get($y);if($X&&(!$Me||$X<$Me)){$Sd=$y;$Me=$X;}}}$n=(!$_POST["token"]&&$Me?lang(96,"'$Sd'"):lang(84).' '.lang(97));}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$n=lang(98,"'post_max_size'");if(isset($_GET["sql"]))$n.=' '.lang(99);}function
select($G,$h=null,$Ff=array(),$z=0){global$x;$ze=array();$w=array();$f=array();$Va=array();$U=array();$H=array();odd('');for($s=0;(!$z||$s<$z)&&($I=$G->fetch_row());$s++){if(!$s){echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr>";for($ee=0;$ee<count($I);$ee++){$o=$G->fetch_field();$B=$o->name;$Ef=$o->orgtable;$Df=$o->orgname;$H[$o->table]=$Ef;if($Ff&&$x=="sql")$ze[$ee]=($B=="table"?"table=":($B=="possible_keys"?"indexes=":null));elseif($Ef!=""){if(!isset($w[$Ef])){$w[$Ef]=array();foreach(indexes($Ef,$h)as$v){if($v["type"]=="PRIMARY"){$w[$Ef]=array_flip($v["columns"]);break;}}$f[$Ef]=$w[$Ef];}if(isset($f[$Ef][$Df])){unset($f[$Ef][$Df]);$w[$Ef][$Df]=$ee;$ze[$ee]=$Ef;}}if($o->charsetnr==63)$Va[$ee]=true;$U[$ee]=$o->type;echo"<th".($Ef!=""||$o->name!=$Df?" title='".h(($Ef!=""?"$Ef.":"").$Df)."'":"").">".h($B).($Ff?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($B),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr".odd().">";foreach($I
as$y=>$X){if($X===null)$X="<i>NULL</i>";elseif($Va[$y]&&!is_utf8($X))$X="<i>".lang(48,strlen($X))."</i>";else{$X=h($X);if($U[$y]==254)$X="<code>$X</code>";}if(isset($ze[$y])&&!$f[$ze[$y]]){if($Ff&&$x=="sql"){$Q=$I[array_search("table=",$ze)];$_=$ze[$y].urlencode($Ff[$Q]!=""?$Ff[$Q]:$Q);}else{$_="edit=".urlencode($ze[$y]);foreach($w[$ze[$y]]as$ob=>$ee)$_.="&where".urlencode("[".bracket_escape($ob)."]")."=".urlencode($I[$ee]);}$X="<a href='".h(ME.$_)."'>$X</a>";}echo"<td>$X";}}echo($s?"</table>\n</div>":"<p class='message'>".lang(12))."\n";return$H;}function
referencable_primary($kh){$H=array();foreach(table_status('',true)as$Sh=>$Q){if($Sh!=$kh&&fk_support($Q)){foreach(fields($Sh)as$o){if($o["primary"]){if($H[$Sh]){unset($H[$Sh]);break;}$H[$Sh]=$o;}}}}return$H;}function
adminer_settings(){parse_str($_COOKIE["adminer_settings"],$sh);return$sh;}function
adminer_setting($y){$sh=adminer_settings();return$sh[$y];}function
set_adminer_settings($sh){return
cookie("adminer_settings",http_build_query($sh+adminer_settings()));}function
textarea($B,$Y,$J=10,$sb=80){global$x;echo"<textarea name='$B' rows='$J' cols='$sb' class='sqlarea jush-$x' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
edit_type($y,$o,$qb,$gd=array(),$Nc=array()){global$Kh,$U,$Li,$tf;$T=$o["type"];echo'<td><select name="',h($y),'[type]" class="type" aria-labelledby="label-type">';if($T&&!isset($U[$T])&&!isset($gd[$T])&&!in_array($T,$Nc))$Nc[]=$T;if($gd)$Kh[lang(100)]=$gd;echo
optionlist(array_merge($Nc,$Kh),$T),'</select>',on_help("getTarget(event).value",1),script("mixin(qsl('select'), {onfocus: function () { lastType = selectValue(this); }, onchange: editingTypeChange});",""),'<td><input name="',h($y),'[length]" value="',h($o["length"]),'" size="3"',(!$o["length"]&&preg_match('~var(char|binary)$~',$T)?" class='required'":"");echo' aria-labelledby="label-length">',script("mixin(qsl('input'), {onfocus: editingLengthFocus, oninput: editingLengthChange});",""),'<td class="options">',"<select name='".h($y)."[collation]'".(preg_match('~(char|text|enum|set)$~',$T)?"":" class='hidden'").'><option value="">('.lang(101).')'.optionlist($qb,$o["collation"]).'</select>',($Li?"<select name='".h($y)."[unsigned]'".(!$T||preg_match(number_type(),$T)?"":" class='hidden'").'><option>'.optionlist($Li,$o["unsigned"]).'</select>':''),(isset($o['on_update'])?"<select name='".h($y)."[on_update]'".(preg_match('~timestamp|datetime~',$T)?"":" class='hidden'").'>'.optionlist(array(""=>"(".lang(102).")","CURRENT_TIMESTAMP"),(preg_match('~^CURRENT_TIMESTAMP~i',$o["on_update"])?"CURRENT_TIMESTAMP":$o["on_update"])).'</select>':''),($gd?"<select name='".h($y)."[on_delete]'".(preg_match("~`~",$T)?"":" class='hidden'")."><option value=''>(".lang(103).")".optionlist(explode("|",$tf),$o["on_delete"])."</select> ":" ");}function
process_length($we){global$yc;return(preg_match("~^\\s*\\(?\\s*$yc(?:\\s*,\\s*$yc)*+\\s*\\)?\\s*\$~",$we)&&preg_match_all("~$yc~",$we,$Ge)?"(".implode(",",$Ge[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$we)));}function
process_type($o,$pb="COLLATE"){global$Li;return" $o[type]".process_length($o["length"]).(preg_match(number_type(),$o["type"])&&in_array($o["unsigned"],$Li)?" $o[unsigned]":"").(preg_match('~char|text|enum|set~',$o["type"])&&$o["collation"]?" $pb ".q($o["collation"]):"");}function
process_field($o,$Di){return
array(idf_escape(trim($o["field"])),process_type($Di),($o["null"]?" NULL":" NOT NULL"),default_value($o),(preg_match('~timestamp|datetime~',$o["type"])&&$o["on_update"]?" ON UPDATE $o[on_update]":""),(support("comment")&&$o["comment"]!=""?" COMMENT ".q($o["comment"]):""),($o["auto_increment"]?auto_increment():null),);}function
default_value($o){$Vb=$o["default"];return($Vb===null?"":" DEFAULT ".(preg_match('~char|binary|text|enum|set~',$o["type"])||preg_match('~^(?![a-z])~i',$Vb)?q($Vb):$Vb));}function
type_class($T){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$y=>$X){if(preg_match("~$y|$X~",$T))return" class='$y'";}}function
edit_fields($p,$qb,$T="TABLE",$gd=array()){global$Td;$p=array_values($p);echo'<thead><tr>
';if($T=="PROCEDURE"){echo'<td>';}echo'<th id="label-name">',($T=="TABLE"?lang(104):lang(105)),'<td id="label-type">',lang(50),'<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">',lang(106),'<td>',lang(107);if($T=="TABLE"){echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="',lang(52),'">AI</acronym>',doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype.html#DATATYPE-SERIAL",'mssql'=>"ms186775.aspx",)),'<td id="label-default">',lang(53),(support("comment")?"<td id='label-comment'>".lang(51):"");}echo'<td>',"<input type='image' class='icon' name='add[".(support("move_col")?0:count($p))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.7.5")."' alt='+' title='".lang(108)."'>".script("row_count = ".count($p).";"),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($p
as$s=>$o){$s++;$Gf=$o[($_POST?"orig":"field")];$dc=(isset($_POST["add"][$s-1])||(isset($o["field"])&&!$_POST["drop_col"][$s]))&&(support("drop_col")||$Gf=="");echo'<tr',($dc?"":" style='display: none;'"),'>
',($T=="PROCEDURE"?"<td>".html_select("fields[$s][inout]",explode("|",$Td),$o["inout"]):""),'<th>';if($dc){echo'<input name="fields[',$s,'][field]" value="',h($o["field"]),'" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">',script("qsl('input').oninput = function () { editingNameChange.call(this);".($o["field"]!=""||count($p)>1?"":" editingAddRow.call(this);")." };","");}echo'<input type="hidden" name="fields[',$s,'][orig]" value="',h($Gf),'">';edit_type("fields[$s]",$o,$qb,$gd);if($T=="TABLE"){echo'<td>',checkbox("fields[$s][null]",1,$o["null"],"","","block","label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$s,'"';if($o["auto_increment"]){echo' checked';}echo' aria-labelledby="label-ai"></label><td>',checkbox("fields[$s][has_default]",1,$o["has_default"],"","","","label-default"),'<input name="fields[',$s,'][default]" value="',h($o["default"]),'" aria-labelledby="label-default">',(support("comment")?"<td><input name='fields[$s][comment]' value='".h($o["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");}echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.7.5")."' alt='+' title='".lang(108)."'> "."<input type='image' class='icon' name='up[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=4.7.5")."' alt='â†‘' title='".lang(109)."'> "."<input type='image' class='icon' name='down[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=4.7.5")."' alt='â†“' title='".lang(110)."'> ":""),($Gf==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.7.5")."' alt='x' title='".lang(111)."'>":"");}}function
process_fields(&$p){$C=0;if($_POST["up"]){$qe=0;foreach($p
as$y=>$o){if(key($_POST["up"])==$y){unset($p[$y]);array_splice($p,$qe,0,array($o));break;}if(isset($o["field"]))$qe=$C;$C++;}}elseif($_POST["down"]){$id=false;foreach($p
as$y=>$o){if(isset($o["field"])&&$id){unset($p[key($_POST["down"])]);array_splice($p,$C,0,array($id));break;}if(key($_POST["down"])==$y)$id=$o;$C++;}}elseif($_POST["add"]){$p=array_values($p);array_splice($p,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum($A){return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($A[0][0].$A[0][0],$A[0][0],substr($A[0],1,-1))),'\\'))."'";}function
grant($nd,$sg,$f,$sf){if(!$sg)return
true;if($sg==array("ALL PRIVILEGES","GRANT OPTION"))return($nd=="GRANT"?queries("$nd ALL PRIVILEGES$sf WITH GRANT OPTION"):queries("$nd ALL PRIVILEGES$sf")&&queries("$nd GRANT OPTION$sf"));return
queries("$nd ".preg_replace('~(GRANT OPTION)\([^)]*\)~','\1',implode("$f, ",$sg).$f).$sf);}function
drop_create($hc,$i,$ic,$ei,$kc,$_e,$Re,$Pe,$Qe,$pf,$cf){if($_POST["drop"])query_redirect($hc,$_e,$Re);elseif($pf=="")query_redirect($i,$_e,$Qe);elseif($pf!=$cf){$Ib=queries($i);queries_redirect($_e,$Pe,$Ib&&queries($hc));if($Ib)queries($ic);}else
queries_redirect($_e,$Pe,queries($ei)&&queries($kc)&&queries($hc)&&queries($i));}function
create_trigger($sf,$I){global$x;$ji=" $I[Timing] $I[Event]".($I["Event"]=="UPDATE OF"?" ".idf_escape($I["Of"]):"");return"CREATE TRIGGER ".idf_escape($I["Trigger"]).($x=="mssql"?$sf.$ji:$ji.$sf).rtrim(" $I[Type]\n$I[Statement]",";").";";}function
create_routine($Xg,$I){global$Td,$x;$N=array();$p=(array)$I["fields"];ksort($p);foreach($p
as$o){if($o["field"]!="")$N[]=(preg_match("~^($Td)\$~",$o["inout"])?"$o[inout] ":"").idf_escape($o["field"]).process_type($o,"CHARACTER SET");}$Wb=rtrim("\n$I[definition]",";");return"CREATE $Xg ".idf_escape(trim($I["name"]))." (".implode(", ",$N).")".(isset($_GET["function"])?" RETURNS".process_type($I["returns"],"CHARACTER SET"):"").($I["language"]?" LANGUAGE $I[language]":"").($x=="pgsql"?" AS ".q($Wb):"$Wb;");}function
remove_definer($F){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\1)',logged_user()).'`~','\1',$F);}function
format_foreign_key($q){global$tf;$l=$q["db"];$hf=$q["ns"];return" FOREIGN KEY (".implode(", ",array_map('idf_escape',$q["source"])).") REFERENCES ".($l!=""&&$l!=$_GET["db"]?idf_escape($l).".":"").($hf!=""&&$hf!=$_GET["ns"]?idf_escape($hf).".":"").table($q["table"])." (".implode(", ",array_map('idf_escape',$q["target"])).")".(preg_match("~^($tf)\$~",$q["on_delete"])?" ON DELETE $q[on_delete]":"").(preg_match("~^($tf)\$~",$q["on_update"])?" ON UPDATE $q[on_update]":"");}function
tar_file($Wc,$oi){$H=pack("a100a8a8a8a12a12",$Wc,644,0,0,decoct($oi->size),decoct(time()));$ib=8*32;for($s=0;$s<strlen($H);$s++)$ib+=ord($H[$s]);$H.=sprintf("%06o",$ib)."\0 ";echo$H,str_repeat("\0",512-strlen($H));$oi->send();echo
str_repeat("\0",511-($oi->size+511)%512);}function
ini_bytes($Sd){$X=ini_get($Sd);switch(strtolower(substr($X,-1))){case'g':$X*=1024;case'm':$X*=1024;case'k':$X*=1024;}return$X;}function
doc_link($cg,$fi="<sup>?</sup>"){global$x,$g;$oh=$g->server_info;$bj=preg_replace('~^(\d\.?\d).*~s','\1',$oh);$Qi=array('sql'=>"https://dev.mysql.com/doc/refman/$bj/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$bj/",'mssql'=>"https://msdn.microsoft.com/library/",'oracle'=>"https://www.oracle.com/pls/topic/lookup?ctx=db".preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s','\1\2',$oh)."&id=",);if(preg_match('~MariaDB~',$oh)){$Qi['sql']="https://mariadb.com/kb/en/library/";$cg['sql']=(isset($cg['mariadb'])?$cg['mariadb']:str_replace(".html","/",$cg['sql']));}return($cg[$x]?"<a href='$Qi[$x]$cg[$x]'".target_blank().">$fi</a>":"");}function
ob_gzencode($P){return
gzencode($P);}function
db_size($l){global$g;if(!$g->select_db($l))return"?";$H=0;foreach(table_status()as$R)$H+=$R["Data_length"]+$R["Index_length"];return
format_number($H);}function
set_utf8mb4($i){global$g;static$N=false;if(!$N&&preg_match('~\butf8mb4~i',$i)){$N=true;echo"SET NAMES ".charset($g).";\n\n";}}function
connect_error(){global$b,$g,$ri,$n,$gc;if(DB!=""){header("HTTP/1.1 404 Not Found");page_header(lang(38).": ".h(DB),lang(112),true);}else{if($_POST["db"]&&!$n)queries_redirect(substr(ME,0,-1),lang(113),drop_databases($_POST["db"]));page_header(lang(114),$n,false);echo"<p class='links'>\n";foreach(array('database'=>lang(115),'privileges'=>lang(72),'processlist'=>lang(116),'variables'=>lang(117),'status'=>lang(118),)as$y=>$X){if(support($y))echo"<a href='".h(ME)."$y='>$X</a>\n";}echo"<p>".lang(119,$gc[DRIVER],"<b>".h($g->server_info)."</b>","<b>$g->extension</b>")."\n","<p>".lang(120,"<b>".h(logged_user())."</b>")."\n";$k=$b->databases();if($k){$eh=support("scheme");$qb=collations();echo"<form action='' method='post'>\n","<table cellspacing='0' class='checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".lang(38)." - <a href='".h(ME)."refresh=1'>".lang(121)."</a>"."<td>".lang(122)."<td>".lang(123)."<td>".lang(124)." - <a href='".h(ME)."dbsize=1'>".lang(125)."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$k=($_GET["dbsize"]?count_tables($k):array_flip($k));foreach($k
as$l=>$S){$Wg=h(ME)."db=".urlencode($l);$t=h("Db-".$l);echo"<tr".odd().">".(support("database")?"<td>".checkbox("db[]",$l,in_array($l,(array)$_POST["db"]),"","","",$t):""),"<th><a href='$Wg' id='$t'>".h($l)."</a>";$d=h(db_collation($l,$qb));echo"<td>".(support("database")?"<a href='$Wg".($eh?"&amp;ns=":"")."&amp;database=' title='".lang(68)."'>$d</a>":$d),"<td align='right'><a href='$Wg&amp;schema=' id='tables-".h($l)."' title='".lang(71)."'>".($_GET["dbsize"]?$S:"?")."</a>","<td align='right' id='size-".h($l)."'>".($_GET["dbsize"]?db_size($l):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".lang(126)." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".lang(127)."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$ri'>\n","</form>\n",script("tableCheck();");}}page_footer("db");}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$g->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}connect_error();exit;}if(support("scheme")&&DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header(lang(78).": ".h($_GET["ns"]),lang(128),true);page_footer("ns");exit;}}$tf="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";class
TmpFile{var$handler;var$size;function
__construct(){$this->handler=tmpfile();}function
write($Cb){$this->size+=strlen($Cb);fwrite($this->handler,$Cb);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}$yc="'(?:''|[^'\\\\]|\\\\.)*'";$Td="IN|OUT|INOUT";if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$p=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$K=array(idf_escape($_GET["field"]));$G=$m->select($a,$K,array(where($_GET,$p)),$K);$I=($G?$G->fetch_row():array());echo$m->value($I[0],$p[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$p=fields($a);if(!$p)$n=error();$R=table_status1($a,true);$B=$b->tableName($R);page_header(($p&&is_view($R)?$R['Engine']=='materialized view'?lang(129):lang(130):lang(131)).": ".($B!=""?$B:h($a)),$n);$b->selectLinks($R);$vb=$R["Comment"];if($vb!="")echo"<p class='nowrap'>".lang(51).": ".h($vb)."\n";if($p)$b->tableStructurePrint($p);if(!is_view($R)){if(support("indexes")){echo"<h3 id='indexes'>".lang(132)."</h3>\n";$w=indexes($a);if($w)$b->tableIndexesPrint($w);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.lang(133)."</a>\n";}if(fk_support($R)){echo"<h3 id='foreign-keys'>".lang(100)."</h3>\n";$gd=foreign_keys($a);if($gd){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(134)."<td>".lang(135)."<td>".lang(103)."<td>".lang(102)."<td></thead>\n";foreach($gd
as$B=>$q){echo"<tr title='".h($B)."'>","<th><i>".implode("</i>, <i>",array_map('h',$q["source"]))."</i>","<td><a href='".h($q["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($q["db"]),ME):($q["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($q["ns"]),ME):ME))."table=".urlencode($q["table"])."'>".($q["db"]!=""?"<b>".h($q["db"])."</b>.":"").($q["ns"]!=""?"<b>".h($q["ns"])."</b>.":"").h($q["table"])."</a>","(<i>".implode("</i>, <i>",array_map('h',$q["target"]))."</i>)","<td>".h($q["on_delete"])."\n","<td>".h($q["on_update"])."\n",'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($B)).'">'.lang(136).'</a>';}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.lang(137)."</a>\n";}}if(support(is_view($R)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".lang(138)."</h3>\n";$Ci=triggers($a);if($Ci){echo"<table cellspacing='0'>\n";foreach($Ci
as$y=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($y)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($y))."'>".lang(136)."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.lang(139)."</a>\n";}}elseif(isset($_GET["schema"])){page_header(lang(71),"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Uh=array();$Vh=array();$ea=($_GET["schema"]?$_GET["schema"]:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$Ge,PREG_SET_ORDER);foreach($Ge
as$s=>$A){$Uh[$A[1]]=array($A[2],$A[3]);$Vh[]="\n\t'".js_escape($A[1])."': [ $A[2], $A[3] ]";}$si=0;$Sa=-1;$dh=array();$Ig=array();$ue=array();foreach(table_status('',true)as$Q=>$R){if(is_view($R))continue;$hg=0;$dh[$Q]["fields"]=array();foreach(fields($Q)as$B=>$o){$hg+=1.25;$o["pos"]=$hg;$dh[$Q]["fields"][$B]=$o;}$dh[$Q]["pos"]=($Uh[$Q]?$Uh[$Q]:array($si,0));foreach($b->foreignKeys($Q)as$X){if(!$X["db"]){$se=$Sa;if($Uh[$Q][1]||$Uh[$X["table"]][1])$se=min(floatval($Uh[$Q][1]),floatval($Uh[$X["table"]][1]))-1;else$Sa-=.1;while($ue[(string)$se])$se-=.0001;$dh[$Q]["references"][$X["table"]][(string)$se]=array($X["source"],$X["target"]);$Ig[$X["table"]][$Q][(string)$se]=$X["target"];$ue[(string)$se]=true;}}$si=max($si,$dh[$Q]["pos"][0]+2.5+$hg);}echo'<div id="schema" style="height: ',$si,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",",$Vh)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$si,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($dh
as$B=>$Q){echo"<div class='table' style='top: ".$Q["pos"][0]."em; left: ".$Q["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($B).'"><b>'.h($B)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($Q["fields"]as$o){$X='<span'.type_class($o["type"]).' title="'.h($o["full_type"].($o["null"]?" NULL":'')).'">'.h($o["field"]).'</span>';echo"<br>".($o["primary"]?"<i>$X</i>":$X);}foreach((array)$Q["references"]as$bi=>$Jg){foreach($Jg
as$se=>$Fg){$te=$se-$Uh[$B][1];$s=0;foreach($Fg[0]as$zh)echo"\n<div class='references' title='".h($bi)."' id='refs$se-".($s++)."' style='left: $te"."em; top: ".$Q["fields"][$zh]["pos"]."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$te)."em;'></div></div>";}}foreach((array)$Ig[$B]as$bi=>$Jg){foreach($Jg
as$se=>$f){$te=$se-$Uh[$B][1];$s=0;foreach($f
as$ai)echo"\n<div class='references' title='".h($bi)."' id='refd$se-".($s++)."' style='left: $te"."em; top: ".$Q["fields"][$ai]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~","",ME)."?file=arrow.gif) no-repeat right center;&version=4.7.5")."'><div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$te)."em;'></div></div>";}}echo"\n</div>\n";}foreach($dh
as$B=>$Q){foreach((array)$Q["references"]as$bi=>$Jg){foreach($Jg
as$se=>$Fg){$Ve=$si;$Ke=-10;foreach($Fg[0]as$y=>$zh){$ig=$Q["pos"][0]+$Q["fields"][$zh]["pos"];$jg=$dh[$bi]["pos"][0]+$dh[$bi]["fields"][$Fg[1][$y]]["pos"];$Ve=min($Ve,$ig,$jg);$Ke=max($Ke,$ig,$jg);}echo"<div class='references' id='refl$se' style='left: $se"."em; top: $Ve"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($Ke-$Ve)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">',lang(140),'</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$n){$Fb="";foreach(array("output","format","db_style","routines","events","table_style","auto_increment","triggers","data_style")as$y)$Fb.="&$y=".urlencode($_POST[$y]);cookie("adminer_export",substr($Fb,1));$S=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$Kc=dump_headers((count($S)==1?key($S):DB),(DB==""||count($S)>1));$be=preg_match('~sql~',$_POST["format"]);if($be){echo"-- Adminer $ia ".$gc[DRIVER]." dump\n\n";if($x=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
".($_POST["data_style"]?"SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";$g->query("SET time_zone = '+00:00';");}}$Lh=$_POST["db_style"];$k=array(DB);if(DB==""){$k=$_POST["databases"];if(is_string($k))$k=explode("\n",rtrim(str_replace("\r","",$k),"\n"));}foreach((array)$k
as$l){$b->dumpDatabase($l);if($g->select_db($l)){if($be&&preg_match('~CREATE~',$Lh)&&($i=$g->result("SHOW CREATE DATABASE ".idf_escape($l),1))){set_utf8mb4($i);if($Lh=="DROP+CREATE")echo"DROP DATABASE IF EXISTS ".idf_escape($l).";\n";echo"$i;\n";}if($be){if($Lh)echo
use_sql($l).";\n\n";$Mf="";if($_POST["routines"]){foreach(array("FUNCTION","PROCEDURE")as$Xg){foreach(get_rows("SHOW $Xg STATUS WHERE Db = ".q($l),null,"-- ")as$I){$i=remove_definer($g->result("SHOW CREATE $Xg ".idf_escape($I["Name"]),2));set_utf8mb4($i);$Mf.=($Lh!='DROP+CREATE'?"DROP $Xg IF EXISTS ".idf_escape($I["Name"]).";;\n":"")."$i;;\n\n";}}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$I){$i=remove_definer($g->result("SHOW CREATE EVENT ".idf_escape($I["Name"]),3));set_utf8mb4($i);$Mf.=($Lh!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($I["Name"]).";;\n":"")."$i;;\n\n";}}if($Mf)echo"DELIMITER ;;\n\n$Mf"."DELIMITER ;\n\n";}if($_POST["table_style"]||$_POST["data_style"]){$dj=array();foreach(table_status('',true)as$B=>$R){$Q=(DB==""||in_array($B,(array)$_POST["tables"]));$Ob=(DB==""||in_array($B,(array)$_POST["data"]));if($Q||$Ob){if($Kc=="tar"){$oi=new
TmpFile;ob_start(array($oi,'write'),1e5);}$b->dumpTable($B,($Q?$_POST["table_style"]:""),(is_view($R)?2:0));if(is_view($R))$dj[]=$B;elseif($Ob){$p=fields($B);$b->dumpData($B,$_POST["data_style"],"SELECT *".convert_fields($p,$p)." FROM ".table($B));}if($be&&$_POST["triggers"]&&$Q&&($Ci=trigger_sql($B)))echo"\nDELIMITER ;;\n$Ci\nDELIMITER ;\n";if($Kc=="tar"){ob_end_flush();tar_file((DB!=""?"":"$l/")."$B.csv",$oi);}elseif($be)echo"\n";}}foreach($dj
as$cj)$b->dumpTable($cj,$_POST["table_style"],1);if($Kc=="tar")echo
pack("x512");}}}if($be)echo"-- ".$g->result("SELECT NOW()")."\n";exit;}page_header(lang(74),$n,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
';$Sb=array('','USE','DROP+CREATE','CREATE');$Wh=array('','DROP+CREATE','CREATE');$Pb=array('','TRUNCATE+INSERT','INSERT');if($x=="sql")$Pb[]='INSERT+UPDATE';parse_str($_COOKIE["adminer_export"],$I);if(!$I)$I=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($I["events"])){$I["routines"]=$I["events"]=($_GET["dump"]=="");$I["triggers"]=$I["table_style"];}echo"<tr><th>".lang(141)."<td>".html_select("output",$b->dumpOutput(),$I["output"],0)."\n";echo"<tr><th>".lang(142)."<td>".html_select("format",$b->dumpFormat(),$I["format"],0)."\n";echo($x=="sqlite"?"":"<tr><th>".lang(38)."<td>".html_select('db_style',$Sb,$I["db_style"]).(support("routine")?checkbox("routines",1,$I["routines"],lang(143)):"").(support("event")?checkbox("events",1,$I["events"],lang(144)):"")),"<tr><th>".lang(123)."<td>".html_select('table_style',$Wh,$I["table_style"]).checkbox("auto_increment",1,$I["auto_increment"],lang(52)).(support("trigger")?checkbox("triggers",1,$I["triggers"],lang(138)):""),"<tr><th>".lang(145)."<td>".html_select('data_style',$Pb,$I["data_style"]),'</table>
<p><input type="submit" value="',lang(74),'">
<input type="hidden" name="token" value="',$ri,'">

<table cellspacing="0">
',script("qsl('table').onclick = dumpClick;");$mg=array();if(DB!=""){$gb=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$gb>".lang(123)."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".lang(145)."<input type='checkbox' id='check-data'$gb></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$dj="";$Xh=tables_list();foreach($Xh
as$B=>$T){$lg=preg_replace('~_.*~','',$B);$gb=($a==""||$a==(substr($a,-1)=="%"?"$lg%":$B));$pg="<tr><td>".checkbox("tables[]",$B,$gb,$B,"","block");if($T!==null&&!preg_match('~table~i',$T))$dj.="$pg\n";else
echo"$pg<td align='right'><label class='block'><span id='Rows-".h($B)."'></span>".checkbox("data[]",$B,$gb)."</label>\n";$mg[$lg]++;}echo$dj;if($Xh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".lang(38)."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$k=$b->databases();if($k){foreach($k
as$l){if(!information_schema($l)){$lg=preg_replace('~_.*~','',$l);echo"<tr><td>".checkbox("databases[]",$l,$a==""||$a=="$lg%",$l,"","block")."\n";$mg[$lg]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$Yc=true;foreach($mg
as$y=>$X){if($y!=""&&$X>1){echo($Yc?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$y%")."'>".h($y)."</a>";$Yc=false;}}}elseif(isset($_GET["privileges"])){page_header(lang(72));echo'<p class="links"><a href="'.h(ME).'user=">'.lang(146)."</a>";$G=$g->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$nd=$G;if(!$G)$G=$g->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($nd?"":"<input type='hidden' name='grant' value=''>\n"),"<table cellspacing='0'>\n","<thead><tr><th>".lang(36)."<th>".lang(35)."<th></thead>\n";while($I=$G->fetch_assoc())echo'<tr'.odd().'><td>'.h($I["User"])."<td>".h($I["Host"]).'<td><a href="'.h(ME.'user='.urlencode($I["User"]).'&host='.urlencode($I["Host"])).'">'.lang(10)."</a>\n";if(!$nd||DB!="")echo"<tr".odd()."><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".lang(10)."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$n&&$_POST["export"]){dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);exit;}restart_session();$Ad=&get_session("queries");$_d=&$Ad[DB];if(!$n&&$_POST["clear"]){$_d=array();redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?lang(73):lang(65)),$n);if(!$n&&$_POST){$kd=false;if(!isset($_GET["import"]))$F=$_POST["query"];elseif($_POST["webfile"]){$Ch=$b->importServerPath();$kd=@fopen((file_exists($Ch)?$Ch:"compress.zlib://$Ch.gz"),"rb");$F=($kd?fread($kd,1e6):false);}else$F=get_file("sql_file",true);if(is_string($F)){if(function_exists('memory_get_usage'))@ini_set("memory_limit",max(ini_bytes("memory_limit"),2*strlen($F)+memory_get_usage()+8e6));if($F!=""&&strlen($F)<1e6){$xg=$F.(preg_match("~;[ \t\r\n]*\$~",$F)?"":";");if(!$_d||reset(end($_d))!=$xg){restart_session();$_d[]=array($xg,time());set_session("queries",$Ad);stop_session();}}$_h="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Yb=";";$C=0;$vc=true;$h=connect();if(is_object($h)&&DB!=""){$h->select_db(DB);if($_GET["ns"]!="")set_schema($_GET["ns"],$h);}$ub=0;$_c=array();$Tf='[\'"'.($x=="sql"?'`#':($x=="sqlite"?'`[':($x=="mssql"?'[':''))).']|/\*|-- |$'.($x=="pgsql"?'|\$[^$]*\$':'');$ti=microtime(true);parse_str($_COOKIE["adminer_export"],$ya);$mc=$b->dumpFormat();unset($mc["sql"]);while($F!=""){if(!$C&&preg_match("~^$_h*+DELIMITER\\s+(\\S+)~i",$F,$A)){$Yb=$A[1];$F=substr($F,strlen($A[0]));}else{preg_match('('.preg_quote($Yb)."\\s*|$Tf)",$F,$A,PREG_OFFSET_CAPTURE,$C);list($id,$hg)=$A[0];if(!$id&&$kd&&!feof($kd))$F.=fread($kd,1e5);else{if(!$id&&rtrim($F)=="")break;$C=$hg+strlen($id);if($id&&rtrim($id)!=$Yb){while(preg_match('('.($id=='/*'?'\*/':($id=='['?']':(preg_match('~^-- |^#~',$id)?"\n":preg_quote($id)."|\\\\."))).'|$)s',$F,$A,PREG_OFFSET_CAPTURE,$C)){$bh=$A[0][0];if(!$bh&&$kd&&!feof($kd))$F.=fread($kd,1e5);else{$C=$A[0][1]+strlen($bh);if($bh[0]!="\\")break;}}}else{$vc=false;$xg=substr($F,0,$hg);$ub++;$pg="<pre id='sql-$ub'><code class='jush-$x'>".$b->sqlCommandQuery($xg)."</code></pre>\n";if($x=="sqlite"&&preg_match("~^$_h*+ATTACH\\b~i",$xg,$A)){echo$pg,"<p class='error'>".lang(147)."\n";$_c[]=" <a href='#sql-$ub'>$ub</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$pg;ob_flush();flush();}$Gh=microtime(true);if($g->multi_query($xg)&&is_object($h)&&preg_match("~^$_h*+USE\\b~i",$xg))$h->query($xg);do{$G=$g->store_result();if($g->error){echo($_POST["only_errors"]?$pg:""),"<p class='error'>".lang(148).($g->errno?" ($g->errno)":"").": ".error()."\n";$_c[]=" <a href='#sql-$ub'>$ub</a>";if($_POST["error_stops"])break
2;}else{$hi=" <span class='time'>(".format_time($Gh).")</span>".(strlen($xg)<1000?" <a href='".h(ME)."sql=".urlencode(trim($xg))."'>".lang(10)."</a>":"");$_a=$g->affected_rows;$gj=($_POST["only_errors"]?"":$m->warnings());$hj="warnings-$ub";if($gj)$hi.=", <a href='#$hj'>".lang(47)."</a>".script("qsl('a').onclick = partial(toggle, '$hj');","");$Hc=null;$Ic="explain-$ub";if(is_object($G)){$z=$_POST["limit"];$Ff=select($G,$h,array(),$z);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$jf=$G->num_rows;echo"<p>".($jf?($z&&$jf>$z?lang(149,$z):"").lang(150,$jf):""),$hi;if($h&&preg_match("~^($_h|\\()*+SELECT\\b~i",$xg)&&($Hc=explain($h,$xg)))echo", <a href='#$Ic'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Ic');","");$t="export-$ub";echo", <a href='#$t'>".lang(74)."</a>".script("qsl('a').onclick = partial(toggle, '$t');","")."<span id='$t' class='hidden'>: ".html_select("output",$b->dumpOutput(),$ya["output"])." ".html_select("format",$mc,$ya["format"])."<input type='hidden' name='query' value='".h($xg)."'>"." <input type='submit' name='export' value='".lang(74)."'><input type='hidden' name='token' value='$ri'></span>\n"."</form>\n";}}else{if(preg_match("~^$_h*+(CREATE|DROP|ALTER)$_h++(DATABASE|SCHEMA)\\b~i",$xg)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($g->info)."'>".lang(151,$_a)."$hi\n";}echo($gj?"<div id='$hj' class='hidden'>\n$gj</div>\n":"");if($Hc){echo"<div id='$Ic' class='hidden'>\n";select($Hc,$h,$Ff);echo"</div>\n";}}$Gh=microtime(true);}while($g->next_result());}$F=substr($F,$C);$C=0;}}}}if($vc)echo"<p class='message'>".lang(152)."\n";elseif($_POST["only_errors"]){echo"<p class='message'>".lang(153,$ub-count($_c))," <span class='time'>(".format_time($ti).")</span>\n";}elseif($_c&&$ub>1)echo"<p class='error'>".lang(148).": ".implode("",$_c)."\n";}else
echo"<p class='error'>".upload_error($F)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Ec="<input type='submit' value='".lang(154)."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$xg=$_GET["sql"];if($_POST)$xg=$_POST["query"];elseif($_GET["history"]=="all")$xg=$_d;elseif($_GET["history"]!="")$xg=$_d[$_GET["history"]][0];echo"<p>";textarea("query",$xg,20);echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".remove_from_uri("sql|limit|error_stops|only_errors")."');"),"<p>$Ec\n",lang(155).": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".lang(156)."</legend><div>";$td=(extension_loaded("zlib")?"[.gz]":"");echo(ini_bool("file_uploads")?"SQL$td (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$Ec":lang(157)),"</div></fieldset>\n";$Id=$b->importServerPath();if($Id){echo"<fieldset><legend>".lang(158)."</legend><div>",lang(159,"<code>".h($Id)."$td</code>"),' <input type="submit" name="webfile" value="'.lang(160).'">',"</div></fieldset>\n";}echo"<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])),lang(161))."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])),lang(162))."\n","<input type='hidden' name='token' value='$ri'>\n";if(!isset($_GET["import"])&&$_d){print_fieldset("history",lang(163),$_GET["history"]!="");for($X=end($_d);$X;$X=prev($_d)){$y=key($_d);list($xg,$hi,$qc)=$X;echo'<a href="'.h(ME."sql=&history=$y").'">'.lang(10)."</a>"." <span class='time' title='".@date('Y-m-d',$hi)."'>".@date("H:i:s",$hi)."</span>"." <code class='jush-$x'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$xg)))),80,"</code>").($qc?" <span class='time'>($qc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".lang(164)."'>\n","<a href='".h(ME."sql=&history=all")."'>".lang(165)."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$p=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$p):""):where($_GET,$p));$Mi=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($p
as$B=>$o){if(!isset($o["privileges"][$Mi?"update":"insert"])||$b->fieldName($o)==""||$o["generated"])unset($p[$B]);}if($_POST&&!$n&&!isset($_GET["select"])){$_e=$_POST["referer"];if($_POST["insert"])$_e=($Mi?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$_e))$_e=ME."select=".urlencode($a);$w=indexes($a);$Hi=unique_array($_GET["where"],$w);$_g="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($_e,lang(166),$m->delete($a,$_g,!$Hi));else{$N=array();foreach($p
as$B=>$o){$X=process_input($o);if($X!==false&&$X!==null)$N[idf_escape($B)]=$X;}if($Mi){if(!$N)redirect($_e);queries_redirect($_e,lang(167),$m->update($a,$N,$_g,!$Hi));if(is_ajax()){page_headers();page_messages($n);exit;}}else{$G=$m->insert($a,$N);$re=($G?last_id():0);queries_redirect($_e,lang(168,($re?" $re":"")),$G);}}}$I=null;if($_POST["save"])$I=(array)$_POST["fields"];elseif($Z){$K=array();foreach($p
as$B=>$o){if(isset($o["privileges"]["select"])){$Ha=convert_field($o);if($_POST["clone"]&&$o["auto_increment"])$Ha="''";if($x=="sql"&&preg_match("~enum|set~",$o["type"]))$Ha="1*".idf_escape($B);$K[]=($Ha?"$Ha AS ":"").idf_escape($B);}}$I=array();if(!support("table"))$K=array("*");if($K){$G=$m->select($a,$K,array($Z),$K,array(),(isset($_GET["select"])?2:1));if(!$G)$n=error();else{$I=$G->fetch_assoc();if(!$I)$I=false;}if(isset($_GET["select"])&&(!$I||$G->fetch_assoc()))$I=null;}}if(!support("table")&&!$p){if(!$Z){$G=$m->select($a,array("*"),$Z,array("*"));$I=($G?$G->fetch_assoc():false);if(!$I)$I=array($m->primary=>"");}if($I){foreach($I
as$y=>$X){if(!$Z)$I[$y]=null;$p[$y]=array("field"=>$y,"null"=>($y!=$m->primary),"auto_increment"=>($y==$m->primary));}}}edit_form($a,$p,$I,$Mi);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Vf=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$y)$Vf[$y]=$y;$Hg=referencable_primary($a);$gd=array();foreach($Hg
as$Sh=>$o)$gd[str_replace("`","``",$Sh)."`".str_replace("`","``",$o["field"])]=$Sh;$If=array();$R=array();if($a!=""){$If=fields($a);$R=table_status($a);if(!$R)$n=lang(9);}$I=$_POST;$I["fields"]=(array)$I["fields"];if($I["auto_increment_col"])$I["fields"][$I["auto_increment_col"]]["auto_increment"]=true;if($_POST)set_adminer_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));if($_POST&&!process_fields($I["fields"])&&!$n){if($_POST["drop"])queries_redirect(substr(ME,0,-1),lang(169),drop_tables(array($a)));else{$p=array();$Ea=array();$Ri=false;$ed=array();$Hf=reset($If);$Ba=" FIRST";foreach($I["fields"]as$y=>$o){$q=$gd[$o["type"]];$Di=($q!==null?$Hg[$q]:$o);if($o["field"]!=""){if(!$o["has_default"])$o["default"]=null;if($y==$I["auto_increment_col"])$o["auto_increment"]=true;$ug=process_field($o,$Di);$Ea[]=array($o["orig"],$ug,$Ba);if($ug!=process_field($Hf,$Hf)){$p[]=array($o["orig"],$ug,$Ba);if($o["orig"]!=""||$Ba)$Ri=true;}if($q!==null)$ed[idf_escape($o["field"])]=($a!=""&&$x!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$gd[$o["type"]],'source'=>array($o["field"]),'target'=>array($Di["field"]),'on_delete'=>$o["on_delete"],));$Ba=" AFTER ".idf_escape($o["field"]);}elseif($o["orig"]!=""){$Ri=true;$p[]=array($o["orig"]);}if($o["orig"]!=""){$Hf=next($If);if(!$Hf)$Ba="";}}$Xf="";if($Vf[$I["partition_by"]]){$Yf=array();if($I["partition_by"]=='RANGE'||$I["partition_by"]=='LIST'){foreach(array_filter($I["partition_names"])as$y=>$X){$Y=$I["partition_values"][$y];$Yf[]="\n  PARTITION ".idf_escape($X)." VALUES ".($I["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$Xf.="\nPARTITION BY $I[partition_by]($I[partition])".($Yf?" (".implode(",",$Yf)."\n)":($I["partitions"]?" PARTITIONS ".(+$I["partitions"]):""));}elseif(support("partitioning")&&preg_match("~partitioned~",$R["Create_options"]))$Xf.="\nREMOVE PARTITIONING";$Oe=lang(170);if($a==""){cookie("adminer_engine",$I["Engine"]);$Oe=lang(171);}$B=trim($I["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($B),$Oe,alter_table($a,$B,($x=="sqlite"&&($Ri||$ed)?$Ea:$p),$ed,($I["Comment"]!=$R["Comment"]?$I["Comment"]:null),($I["Engine"]&&$I["Engine"]!=$R["Engine"]?$I["Engine"]:""),($I["Collation"]&&$I["Collation"]!=$R["Collation"]?$I["Collation"]:""),($I["Auto_increment"]!=""?number($I["Auto_increment"]):""),$Xf));}}page_header(($a!=""?lang(45):lang(75)),$n,array("table"=>$a),h($a));if(!$_POST){$I=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($U["int"])?"int":(isset($U["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$I=$R;$I["name"]=$a;$I["fields"]=array();if(!$_GET["auto_increment"])$I["Auto_increment"]="";foreach($If
as$o){$o["has_default"]=isset($o["default"]);$I["fields"][]=$o;}if(support("partitioning")){$ld="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($a);$G=$g->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $ld ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");list($I["partition_by"],$I["partitions"],$I["partition"])=$G->fetch_row();$Yf=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $ld AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$Yf[""]="";$I["partition_names"]=array_keys($Yf);$I["partition_values"]=array_values($Yf);}}}$qb=collations();$xc=engines();foreach($xc
as$wc){if(!strcasecmp($wc,$I["Engine"])){$I["Engine"]=$wc;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo
lang(172),': <input name="name" data-maxlength="64" value="',h($I["name"]),'" autocapitalize="off">
';if($a==""&&!$_POST)echo
script("focus(qs('#form')['name']);");echo($xc?"<select name='Engine'>".optionlist(array(""=>"(".lang(173).")")+$xc,$I["Engine"])."</select>".on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;"):""),' ',($qb&&!preg_match("~sqlite|mssql~",$x)?html_select("Collation",array(""=>"(".lang(101).")")+$qb,$I["Collation"]):""),' <input type="submit" value="',lang(14),'">
';}echo'
';if(support("columns")){echo'<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';edit_fields($I["fields"],$qb,"TABLE",$gd);echo'</table>
</div>
<p>
',lang(52),': <input type="number" name="Auto_increment" size="6" value="',h($I["Auto_increment"]),'">
',checkbox("defaults",1,($_POST?$_POST["defaults"]:adminer_setting("defaults")),lang(174),"columnShow(this.checked, 5)","jsonly"),(support("comment")?checkbox("comments",1,($_POST?$_POST["comments"]:adminer_setting("comments")),lang(51),"editingCommentsClick(this, true);","jsonly").' <input name="Comment" value="'.h($I["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'">':''),'<p>
<input type="submit" value="',lang(14),'">
';}echo'
';if($a!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$a));}if(support("partitioning")){$Wf=preg_match('~RANGE|LIST~',$I["partition_by"]);print_fieldset("partition",lang(176),$I["partition_by"]);echo'<p>
',"<select name='partition_by'>".optionlist(array(""=>"")+$Vf,$I["partition_by"])."</select>".on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($I["partition"]),'">)
',lang(177),': <input type="number" name="partitions" class="size',($Wf||!$I["partition_by"]?" hidden":""),'" value="',h($I["partitions"]),'">
<table cellspacing="0" id="partition-table"',($Wf?"":" class='hidden'"),'>
<thead><tr><th>',lang(178),'<th>',lang(179),'</thead>
';foreach($I["partition_names"]as$y=>$X){echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($y==count($I["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($I["partition_values"][$y]).'">';}echo'</table>
</div></fieldset>
';}echo'<input type="hidden" name="token" value="',$ri,'">
</form>
',script("qs('#form')['defaults'].onclick();".(support("comment")?" editingCommentsClick(qs('#form')['comments']);":""));}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Ld=array("PRIMARY","UNIQUE","INDEX");$R=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$R["Engine"]))$Ld[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$R["Engine"]))$Ld[]="SPATIAL";$w=indexes($a);$ng=array();if($x=="mongo"){$ng=$w["_id_"];unset($Ld[0]);unset($w["_id_"]);}$I=$_POST;if($_POST&&!$n&&!$_POST["add"]&&!$_POST["drop_col"]){$c=array();foreach($I["indexes"]as$v){$B=$v["name"];if(in_array($v["type"],$Ld)){$f=array();$xe=array();$ac=array();$N=array();ksort($v["columns"]);foreach($v["columns"]as$y=>$e){if($e!=""){$we=$v["lengths"][$y];$Zb=$v["descs"][$y];$N[]=idf_escape($e).($we?"(".(+$we).")":"").($Zb?" DESC":"");$f[]=$e;$xe[]=($we?$we:null);$ac[]=$Zb;}}if($f){$Fc=$w[$B];if($Fc){ksort($Fc["columns"]);ksort($Fc["lengths"]);ksort($Fc["descs"]);if($v["type"]==$Fc["type"]&&array_values($Fc["columns"])===$f&&(!$Fc["lengths"]||array_values($Fc["lengths"])===$xe)&&array_values($Fc["descs"])===$ac){unset($w[$B]);continue;}}$c[]=array($v["type"],$B,$N);}}}foreach($w
as$B=>$Fc)$c[]=array($Fc["type"],$B,"DROP");if(!$c)redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),lang(180),alter_indexes($a,$c));}page_header(lang(132),$n,array("table"=>$a),h($a));$p=array_keys(fields($a));if($_POST["add"]){foreach($I["indexes"]as$y=>$v){if($v["columns"][count($v["columns"])]!="")$I["indexes"][$y]["columns"][]="";}$v=end($I["indexes"]);if($v["type"]||array_filter($v["columns"],'strlen'))$I["indexes"][]=array("columns"=>array(1=>""));}if(!$I){foreach($w
as$y=>$v){$w[$y]["name"]=$y;$w[$y]["columns"][]="";}$w[]=array("columns"=>array(1=>""));$I["indexes"]=$w;}echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">',lang(181),'<th><input type="submit" class="wayoff">',lang(182),'<th id="label-name">',lang(183),'<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.7.5")."' alt='+' title='".lang(108)."'>",'</noscript>
</thead>
';if($ng){echo"<tr><td>PRIMARY<td>";foreach($ng["columns"]as$y=>$e){echo
select_input(" disabled",$p,$e),"<label><input disabled type='checkbox'>".lang(60)."</label> ";}echo"<td><td>\n";}$ee=1;foreach($I["indexes"]as$v){if(!$_POST["drop_col"]||$ee!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$ee][type]",array(-1=>"")+$Ld,$v["type"],($ee==count($I["indexes"])?"indexesAddRow.call(this);":1),"label-type"),"<td>";ksort($v["columns"]);$s=1;foreach($v["columns"]as$y=>$e){echo"<span>".select_input(" name='indexes[$ee][columns][$s]' title='".lang(49)."'",($p?array_combine($p,$p):$p),$e,"partial(".($s==count($v["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape($x=="sql"?"":$_GET["indexes"]."_")."')"),($x=="sql"||$x=="mssql"?"<input type='number' name='indexes[$ee][lengths][$s]' class='size' value='".h($v["lengths"][$y])."' title='".lang(106)."'>":""),(support("descidx")?checkbox("indexes[$ee][descs][$s]",1,$v["descs"][$y],lang(60)):"")," </span>";$s++;}echo"<td><input name='indexes[$ee][name]' value='".h($v["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$ee]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.7.5")."' alt='x' title='".lang(111)."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$ee++;}echo'</table>
</div>
<p>
<input type="submit" value="',lang(14),'">
<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["database"])){$I=$_POST;if($_POST&&!$n&&!isset($_POST["add_x"])){$B=trim($I["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),lang(184),drop_databases(array(DB)));}elseif(DB!==$B){if(DB!=""){$_GET["db"]=$B;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($B),lang(185),rename_database($B,$I["collation"]));}else{$k=explode("\n",str_replace("\r","",$B));$Mh=true;$qe="";foreach($k
as$l){if(count($k)==1||$l!=""){if(!create_database($l,$I["collation"]))$Mh=false;$qe=$l;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($qe),lang(186),$Mh);}}else{if(!$I["collation"])redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($B).(preg_match('~^[a-z0-9_]+$~i',$I["collation"])?" COLLATE $I[collation]":""),substr(ME,0,-1),lang(187));}}page_header(DB!=""?lang(68):lang(115),$n,array(),h(DB));$qb=collations();$B=DB;if($_POST)$B=$I["name"];elseif(DB!="")$I["collation"]=db_collation(DB,$qb);elseif($x=="sql"){foreach(get_vals("SHOW GRANTS")as$nd){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~',$nd,$A)&&$A[1]){$B=stripcslashes(idf_unescape("`$A[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($B,"\n")?'<textarea id="name" name="name" rows="10" cols="40">'.h($B).'</textarea><br>':'<input name="name" id="name" value="'.h($B).'" data-maxlength="64" autocapitalize="off">')."\n".($qb?html_select("collation",array(""=>"(".lang(101).")")+$qb,$I["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"ms187963.aspx",)):""),script("focus(qs('#name'));"),'<input type="submit" value="',lang(14),'">
';if(DB!="")echo"<input type='submit' name='drop' value='".lang(127)."'>".confirm(lang(175,DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.7.5")."' alt='+' title='".lang(108)."'>\n";echo'<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["scheme"])){$I=$_POST;if($_POST&&!$n){$_=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$_,lang(188));else{$B=trim($I["name"]);$_.=urlencode($B);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($B),$_,lang(189));elseif($_GET["ns"]!=$B)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($B),$_,lang(190));else
redirect($_);}}page_header($_GET["ns"]!=""?lang(69):lang(70),$n);if(!$I)$I["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" id="name" value="',h($I["name"]),'" autocapitalize="off">
',script("focus(qs('#name'));"),'<input type="submit" value="',lang(14),'">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".lang(127)."'>".confirm(lang(175,$_GET["ns"]))."\n";echo'<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?$_GET["name"]:$_GET["call"]);page_header(lang(191).": ".h($da),$n);$Xg=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Jd=array();$Mf=array();foreach($Xg["fields"]as$s=>$o){if(substr($o["inout"],-3)=="OUT")$Mf[$s]="@".idf_escape($o["field"])." AS ".idf_escape($o["field"]);if(!$o["inout"]||substr($o["inout"],0,2)=="IN")$Jd[]=$s;}if(!$n&&$_POST){$bb=array();foreach($Xg["fields"]as$y=>$o){if(in_array($y,$Jd)){$X=process_input($o);if($X===false)$X="''";if(isset($Mf[$y]))$g->query("SET @".idf_escape($o["field"])." = $X");}$bb[]=(isset($Mf[$y])?"@".idf_escape($o["field"]):$X);}$F=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$bb).")";$Gh=microtime(true);$G=$g->multi_query($F);$_a=$g->affected_rows;echo$b->selectQuery($F,$Gh,!$G);if(!$G)echo"<p class='error'>".error()."\n";else{$h=connect();if(is_object($h))$h->select_db(DB);do{$G=$g->store_result();if(is_object($G))select($G,$h);else
echo"<p class='message'>".lang(192,$_a)."\n";}while($g->next_result());if($Mf)select($g->query("SELECT ".implode(", ",$Mf)));}}echo'
<form action="" method="post">
';if($Jd){echo"<table cellspacing='0' class='layout'>\n";foreach($Jd
as$y){$o=$Xg["fields"][$y];$B=$o["field"];echo"<tr><th>".$b->fieldName($o);$Y=$_POST["fields"][$B];if($Y!=""){if($o["type"]=="enum")$Y=+$Y;if($o["type"]=="set")$Y=array_sum($Y);}input($o,$Y,(string)$_POST["function"][$B]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="',lang(191),'">
<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$B=$_GET["name"];$I=$_POST;if($_POST&&!$n&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){$Oe=($_POST["drop"]?lang(193):($B!=""?lang(194):lang(195)));$_e=ME."table=".urlencode($a);if(!$_POST["drop"]){$I["source"]=array_filter($I["source"],'strlen');ksort($I["source"]);$ai=array();foreach($I["source"]as$y=>$X)$ai[$y]=$I["target"][$y];$I["target"]=$ai;}if($x=="sqlite")queries_redirect($_e,$Oe,recreate_table($a,$a,array(),array(),array(" $B"=>($_POST["drop"]?"":" ".format_foreign_key($I)))));else{$c="ALTER TABLE ".table($a);$hc="\nDROP ".($x=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($B);if($_POST["drop"])query_redirect($c.$hc,$_e,$Oe);else{query_redirect($c.($B!=""?"$hc,":"")."\nADD".format_foreign_key($I),$_e,$Oe);$n=lang(196)."<br>$n";}}}page_header(lang(197),$n,array("table"=>$a),h($a));if($_POST){ksort($I["source"]);if($_POST["add"])$I["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$I["target"]=array();}elseif($B!=""){$gd=foreign_keys($a);$I=$gd[$B];$I["source"][]="";}else{$I["table"]=$a;$I["source"]=array("");}echo'
<form action="" method="post">
';$zh=array_keys(fields($a));if($I["db"]!="")$g->select_db($I["db"]);if($I["ns"]!="")set_schema($I["ns"]);$Gg=array_keys(array_filter(table_status('',true),'fk_support'));$ai=($a===$I["table"]?$zh:array_keys(fields(in_array($I["table"],$Gg)?$I["table"]:reset($Gg))));$uf="this.form['change-js'].value = '1'; this.form.submit();";echo"<p>".lang(198).": ".html_select("table",$Gg,$I["table"],$uf)."\n";if($x=="pgsql")echo
lang(78).": ".html_select("ns",$b->schemas(),$I["ns"]!=""?$I["ns"]:$_GET["ns"],$uf);elseif($x!="sqlite"){$Tb=array();foreach($b->databases()as$l){if(!information_schema($l))$Tb[]=$l;}echo
lang(77).": ".html_select("db",$Tb,$I["db"]!=""?$I["db"]:$_GET["db"],$uf);}echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="',lang(199),'"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">',lang(134),'<th id="label-target">',lang(135),'</thead>
';$ee=0;foreach($I["source"]as$y=>$X){echo"<tr>","<td>".html_select("source[".(+$y)."]",array(-1=>"")+$zh,$X,($ee==count($I["source"])-1?"foreignAddRow.call(this);":1),"label-source"),"<td>".html_select("target[".(+$y)."]",$ai,$I["target"][$y],1,"label-target");$ee++;}echo'</table>
<p>
',lang(103),': ',html_select("on_delete",array(-1=>"")+explode("|",$tf),$I["on_delete"]),' ',lang(102),': ',html_select("on_update",array(-1=>"")+explode("|",$tf),$I["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-REFERENCES",'mssql'=>"ms174979.aspx",'oracle'=>"https://docs.oracle.com/cd/B19306_01/server.102/b14200/clauses002.htm#sthref2903",)),'<p>
<input type="submit" value="',lang(14),'">
<noscript><p><input type="submit" name="add" value="',lang(200),'"></noscript>
';if($B!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$B));}echo'<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$I=$_POST;$Jf="VIEW";if($x=="pgsql"&&$a!=""){$O=table_status($a);$Jf=strtoupper($O["Engine"]);}if($_POST&&!$n){$B=trim($I["name"]);$Ha=" AS\n$I[select]";$_e=ME."table=".urlencode($B);$Oe=lang(201);$T=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$B&&$x!="sqlite"&&$T=="VIEW"&&$Jf=="VIEW")query_redirect(($x=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($B).$Ha,$_e,$Oe);else{$ci=$B."_adminer_".uniqid();drop_create("DROP $Jf ".table($a),"CREATE $T ".table($B).$Ha,"DROP $T ".table($B),"CREATE $T ".table($ci).$Ha,"DROP $T ".table($ci),($_POST["drop"]?substr(ME,0,-1):$_e),lang(202),$Oe,lang(203),$a,$B);}}if(!$_POST&&$a!=""){$I=view($a);$I["name"]=$a;$I["materialized"]=($Jf!="VIEW");if(!$n)$n=error();}page_header(($a!=""?lang(44):lang(204)),$n,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>',lang(183),': <input name="name" value="',h($I["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$I["materialized"],lang(129)):""),'<p>';textarea("select",$I["select"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($a!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$a));}echo'<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$Wd=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$Ih=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$I=$_POST;if($_POST&&!$n){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),lang(205));elseif(in_array($I["INTERVAL_FIELD"],$Wd)&&isset($Ih[$I["STATUS"]])){$ch="\nON SCHEDULE ".($I["INTERVAL_VALUE"]?"EVERY ".q($I["INTERVAL_VALUE"])." $I[INTERVAL_FIELD]".($I["STARTS"]?" STARTS ".q($I["STARTS"]):"").($I["ENDS"]?" ENDS ".q($I["ENDS"]):""):"AT ".q($I["STARTS"]))." ON COMPLETION".($I["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?lang(206):lang(207)),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$ch.($aa!=$I["EVENT_NAME"]?"\nRENAME TO ".idf_escape($I["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($I["EVENT_NAME"]).$ch)."\n".$Ih[$I["STATUS"]]." COMMENT ".q($I["EVENT_COMMENT"]).rtrim(" DO\n$I[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?lang(208).": ".h($aa):lang(209)),$n);if(!$I&&$aa!=""){$J=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$I=reset($J);}echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>',lang(183),'<td><input name="EVENT_NAME" value="',h($I["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">',lang(210),'<td><input name="STARTS" value="',h("$I[EXECUTE_AT]$I[STARTS]"),'">
<tr><th title="datetime">',lang(211),'<td><input name="ENDS" value="',h($I["ENDS"]),'">
<tr><th>',lang(212),'<td><input type="number" name="INTERVAL_VALUE" value="',h($I["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$Wd,$I["INTERVAL_FIELD"]),'<tr><th>',lang(118),'<td>',html_select("STATUS",$Ih,$I["STATUS"]),'<tr><th>',lang(51),'<td><input name="EVENT_COMMENT" value="',h($I["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION","PRESERVE",$I["ON_COMPLETION"]=="PRESERVE",lang(213)),'</table>
<p>';textarea("EVENT_DEFINITION",$I["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($aa!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$aa));}echo'<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?$_GET["name"]:$_GET["procedure"]);$Xg=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$I=$_POST;$I["fields"]=(array)$I["fields"];if($_POST&&!process_fields($I["fields"])&&!$n){$Gf=routine($_GET["procedure"],$Xg);$ci="$I[name]_adminer_".uniqid();drop_create("DROP $Xg ".routine_id($da,$Gf),create_routine($Xg,$I),"DROP $Xg ".routine_id($I["name"],$I),create_routine($Xg,array("name"=>$ci)+$I),"DROP $Xg ".routine_id($ci,$I),substr(ME,0,-1),lang(214),lang(215),lang(216),$da,$I["name"]);}page_header(($da!=""?(isset($_GET["function"])?lang(217):lang(218)).": ".h($da):(isset($_GET["function"])?lang(219):lang(220))),$n);if(!$_POST&&$da!=""){$I=routine($_GET["procedure"],$Xg);$I["name"]=$da;}$qb=get_vals("SHOW CHARACTER SET");sort($qb);$Yg=routine_languages();echo'
<form action="" method="post" id="form">
<p>',lang(183),': <input name="name" value="',h($I["name"]),'" data-maxlength="64" autocapitalize="off">
',($Yg?lang(19).": ".html_select("language",$Yg,$I["language"])."\n":""),'<input type="submit" value="',lang(14),'">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';edit_fields($I["fields"],$qb,$Xg);if(isset($_GET["function"])){echo"<tr><td>".lang(221);edit_type("returns",$I["returns"],$qb,array(),($x=="pgsql"?array("void","trigger"):array()));}echo'</table>
</div>
<p>';textarea("definition",$I["definition"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($da!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$da));}echo'<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["sequence"])){$fa=$_GET["sequence"];$I=$_POST;if($_POST&&!$n){$_=substr(ME,0,-1);$B=trim($I["name"]);if($_POST["drop"])query_redirect("DROP SEQUENCE ".idf_escape($fa),$_,lang(222));elseif($fa=="")query_redirect("CREATE SEQUENCE ".idf_escape($B),$_,lang(223));elseif($fa!=$B)query_redirect("ALTER SEQUENCE ".idf_escape($fa)." RENAME TO ".idf_escape($B),$_,lang(224));else
redirect($_);}page_header($fa!=""?lang(225).": ".h($fa):lang(226),$n);if(!$I)$I["name"]=$fa;echo'
<form action="" method="post">
<p><input name="name" value="',h($I["name"]),'" autocapitalize="off">
<input type="submit" value="',lang(14),'">
';if($fa!="")echo"<input type='submit' name='drop' value='".lang(127)."'>".confirm(lang(175,$fa))."\n";echo'<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["type"])){$ga=$_GET["type"];$I=$_POST;if($_POST&&!$n){$_=substr(ME,0,-1);if($_POST["drop"])query_redirect("DROP TYPE ".idf_escape($ga),$_,lang(227));else
query_redirect("CREATE TYPE ".idf_escape(trim($I["name"]))." $I[as]",$_,lang(228));}page_header($ga!=""?lang(229).": ".h($ga):lang(230),$n);if(!$I)$I["as"]="AS ";echo'
<form action="" method="post">
<p>
';if($ga!="")echo"<input type='submit' name='drop' value='".lang(127)."'>".confirm(lang(175,$ga))."\n";else{echo"<input name='name' value='".h($I['name'])."' autocapitalize='off'>\n";textarea("as",$I["as"]);echo"<p><input type='submit' value='".lang(14)."'>\n";}echo'<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$B=$_GET["name"];$Bi=trigger_options();$I=(array)trigger($B)+array("Trigger"=>$a."_bi");if($_POST){if(!$n&&in_array($_POST["Timing"],$Bi["Timing"])&&in_array($_POST["Event"],$Bi["Event"])&&in_array($_POST["Type"],$Bi["Type"])){$sf=" ON ".table($a);$hc="DROP TRIGGER ".idf_escape($B).($x=="pgsql"?$sf:"");$_e=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($hc,$_e,lang(231));else{if($B!="")queries($hc);queries_redirect($_e,($B!=""?lang(232):lang(233)),queries(create_trigger($sf,$_POST)));if($B!="")queries(create_trigger($sf,$I+array("Type"=>reset($Bi["Type"]))));}}$I=$_POST;}page_header(($B!=""?lang(234).": ".h($B):lang(235)),$n,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>',lang(236),'<td>',html_select("Timing",$Bi["Timing"],$I["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>',lang(237),'<td>',html_select("Event",$Bi["Event"],$I["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$Bi["Event"])?" <input name='Of' value='".h($I["Of"])."' class='hidden'>":""),'<tr><th>',lang(50),'<td>',html_select("Type",$Bi["Type"],$I["Type"]),'</table>
<p>',lang(183),': <input name="Trigger" value="',h($I["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$I["Statement"]);echo'<p>
<input type="submit" value="',lang(14),'">
';if($B!=""){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,$B));}echo'<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["user"])){$ha=$_GET["user"];$sg=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$I){foreach(explode(",",($I["Privilege"]=="Grant option"?"":$I["Context"]))as$Db)$sg[$Db][$I["Privilege"]]=$I["Comment"];}$sg["Server Admin"]+=$sg["File access on server"];$sg["Databases"]["Create routine"]=$sg["Procedures"]["Create routine"];unset($sg["Procedures"]["Create routine"]);$sg["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$sg["Columns"][$X]=$sg["Tables"][$X];unset($sg["Server Admin"]["Usage"]);foreach($sg["Tables"]as$y=>$X)unset($sg["Databases"][$y]);$bf=array();if($_POST){foreach($_POST["objects"]as$y=>$X)$bf[$X]=(array)$bf[$X]+(array)$_POST["grants"][$y];}$od=array();$qf="";if(isset($_GET["host"])&&($G=$g->query("SHOW GRANTS FOR ".q($ha)."@".q($_GET["host"])))){while($I=$G->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$I[0],$A)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~',$A[1],$Ge,PREG_SET_ORDER)){foreach($Ge
as$X){if($X[1]!="USAGE")$od["$A[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$I[0]))$od["$A[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$I[0],$A))$qf=$A[1];}}if($_POST&&!$n){$rf=(isset($_GET["host"])?q($ha)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $rf",ME."privileges=",lang(238));else{$df=q($_POST["user"])."@".q($_POST["host"]);$ag=$_POST["pass"];if($ag!=''&&!$_POST["hashed"]&&!min_version(8)){$ag=$g->result("SELECT PASSWORD(".q($ag).")");$n=!$ag;}$Ib=false;if(!$n){if($rf!=$df){$Ib=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $df IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($ag));$n=!$Ib;}elseif($ag!=$qf)queries("SET PASSWORD FOR $df = ".q($ag));}if(!$n){$Ug=array();foreach($bf
as$lf=>$nd){if(isset($_GET["grant"]))$nd=array_filter($nd);$nd=array_keys($nd);if(isset($_GET["grant"]))$Ug=array_diff(array_keys(array_filter($bf[$lf],'strlen')),$nd);elseif($rf==$df){$of=array_keys((array)$od[$lf]);$Ug=array_diff($of,$nd);$nd=array_diff($nd,$of);unset($od[$lf]);}if(preg_match('~^(.+)\s*(\(.*\))?$~U',$lf,$A)&&(!grant("REVOKE",$Ug,$A[2]," ON $A[1] FROM $df")||!grant("GRANT",$nd,$A[2]," ON $A[1] TO $df"))){$n=true;break;}}}if(!$n&&isset($_GET["host"])){if($rf!=$df)queries("DROP USER $rf");elseif(!isset($_GET["grant"])){foreach($od
as$lf=>$Ug){if(preg_match('~^(.+)(\(.*\))?$~U',$lf,$A))grant("REVOKE",array_keys($Ug),$A[2]," ON $A[1] FROM $df");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?lang(239):lang(240)),!$n);if($Ib)$g->query("DROP USER $df");}}page_header((isset($_GET["host"])?lang(36).": ".h("$ha@$_GET[host]"):lang(146)),$n,array("privileges"=>array('',lang(72))));if($_POST){$I=$_POST;$od=$bf;}else{$I=$_GET+array("host"=>$g->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$I["pass"]=$qf;if($qf!="")$I["hashed"]=true;$od[(DB==""||$od?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>',lang(35),'<td><input name="host" data-maxlength="60" value="',h($I["host"]),'" autocapitalize="off">
<tr><th>',lang(36),'<td><input name="user" data-maxlength="80" value="',h($I["user"]),'" autocapitalize="off">
<tr><th>',lang(37),'<td><input name="pass" id="pass" value="',h($I["pass"]),'" autocomplete="new-password">
';if(!$I["hashed"])echo
script("typePassword(qs('#pass'));");echo(min_version(8)?"":checkbox("hashed",1,$I["hashed"],lang(241),"typePassword(this.form['pass'], this.checked);")),'</table>

';echo"<table cellspacing='0'>\n","<thead><tr><th colspan='2'>".lang(72).doc_link(array('sql'=>"grant.html#priv_level"));$s=0;foreach($od
as$lf=>$nd){echo'<th>'.($lf!="*.*"?"<input name='objects[$s]' value='".h($lf)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$s]' value='*.*' size='10'>*.*");$s++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>lang(35),"Databases"=>lang(38),"Tables"=>lang(131),"Columns"=>lang(49),"Procedures"=>lang(242),)as$Db=>$Zb){foreach((array)$sg[$Db]as$rg=>$vb){echo"<tr".odd()."><td".($Zb?">$Zb<td":" colspan='2'").' lang="en" title="'.h($vb).'">'.h($rg);$s=0;foreach($od
as$lf=>$nd){$B="'grants[$s][".h(strtoupper($rg))."]'";$Y=$nd[strtoupper($rg)];if($Db=="Server Admin"&&$lf!=(isset($od["*.*"])?"*.*":".*"))echo"<td>";elseif(isset($_GET["grant"]))echo"<td><select name=$B><option><option value='1'".($Y?" selected":"").">".lang(243)."<option value='0'".($Y=="0"?" selected":"").">".lang(244)."</select>";else{echo"<td align='center'><label class='block'>","<input type='checkbox' name=$B value='1'".($Y?" checked":"").($rg=="All privileges"?" id='grants-$s-all'>":">".($rg=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$s-all'); };"))),"</label>";}$s++;}}}echo"</table>\n",'<p>
<input type="submit" value="',lang(14),'">
';if(isset($_GET["host"])){echo'<input type="submit" name="drop" value="',lang(127),'">',confirm(lang(175,"$ha@$_GET[host]"));}echo'<input type="hidden" name="token" value="',$ri,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")&&$_POST&&!$n){$le=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$le++;}queries_redirect(ME."processlist=",lang(245,$le),$le||!$_POST["kill"]);}page_header(lang(116),$n);echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$s=-1;foreach(process_list()as$s=>$I){if(!$s){echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");foreach($I
as$y=>$X)echo"<th>$y".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($y),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"REFRN30223",));echo"</thead>\n";}echo"<tr".odd().">".(support("kill")?"<td>".checkbox("kill[]",$I[$x=="sql"?"Id":"pid"],0):"");foreach($I
as$y=>$X)echo"<td>".(($x=="sql"&&$y=="Info"&&preg_match("~Query|Killed~",$I["Command"])&&$X!="")||($x=="pgsql"&&$y=="current_query"&&$X!="<IDLE>")||($x=="oracle"&&$y=="sql_text"&&$X!="")?"<code class='jush-$x'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($I["db"]!=""?"db=".urlencode($I["db"])."&":"")."sql=".urlencode($X)).'">'.lang(246).'</a>':h($X));echo"\n";}echo'</table>
</div>
<p>
';if(support("kill")){echo($s+1)."/".lang(247,max_connections()),"<p><input type='submit' value='".lang(248)."'>\n";}echo'<input type="hidden" name="token" value="',$ri,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$R=table_status1($a);$w=indexes($a);$p=fields($a);$gd=column_foreign_keys($a);$nf=$R["Oid"];parse_str($_COOKIE["adminer_import"],$za);$Vg=array();$f=array();$gi=null;foreach($p
as$y=>$o){$B=$b->fieldName($o);if(isset($o["privileges"]["select"])&&$B!=""){$f[$y]=html_entity_decode(strip_tags($B),ENT_QUOTES);if(is_shortable($o))$gi=$b->selectLengthProcess();}$Vg+=$o["privileges"];}list($K,$pd)=$b->selectColumnsProcess($f,$w);$ae=count($pd)<count($K);$Z=$b->selectSearchProcess($p,$w);$Cf=$b->selectOrderProcess($p,$w);$z=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$Ii=>$I){$Ha=convert_field($p[key($I)]);$K=array($Ha?$Ha:idf_escape(key($I)));$Z[]=where_check($Ii,$p);$H=$m->select($a,$K,$Z,$K);if($H)echo
reset($H->fetch_row());}exit;}$ng=$Ki=null;foreach($w
as$v){if($v["type"]=="PRIMARY"){$ng=array_flip($v["columns"]);$Ki=($K?$ng:array());foreach($Ki
as$y=>$X){if(in_array(idf_escape($y),$K))unset($Ki[$y]);}break;}}if($nf&&!$ng){$ng=$Ki=array($nf=>0);$w[]=array("type"=>"PRIMARY","columns"=>array($nf));}if($_POST&&!$n){$mj=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$hb=array();foreach($_POST["check"]as$eb)$hb[]=where_check($eb,$p);$mj[]="((".implode(") OR (",$hb)."))";}$mj=($mj?"\nWHERE ".implode(" AND ",$mj):"");if($_POST["export"]){cookie("adminer_import","output=".urlencode($_POST["output"])."&format=".urlencode($_POST["format"]));dump_headers($a);$b->dumpTable($a,"");$ld=($K?implode(", ",$K):"*").convert_fields($f,$p,$K)."\nFROM ".table($a);$rd=($pd&&$ae?"\nGROUP BY ".implode(", ",$pd):"").($Cf?"\nORDER BY ".implode(", ",$Cf):"");if(!is_array($_POST["check"])||$ng)$F="SELECT $ld$mj$rd";else{$Gi=array();foreach($_POST["check"]as$X)$Gi[]="(SELECT".limit($ld,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$p).$rd,1).")";$F=implode(" UNION ALL ",$Gi);}$b->dumpData($a,"table",$F);exit;}if(!$b->selectEmailProcess($Z,$gd)){if($_POST["save"]||$_POST["delete"]){$G=true;$_a=0;$N=array();if(!$_POST["delete"]){foreach($f
as$B=>$X){$X=process_input($p[$B]);if($X!==null&&($_POST["clone"]||$X!==false))$N[idf_escape($B)]=($X!==false?$X:idf_escape($B));}}if($_POST["delete"]||$N){if($_POST["clone"])$F="INTO ".table($a)." (".implode(", ",array_keys($N)).")\nSELECT ".implode(", ",$N)."\nFROM ".table($a);if($_POST["all"]||($ng&&is_array($_POST["check"]))||$ae){$G=($_POST["delete"]?$m->delete($a,$mj):($_POST["clone"]?queries("INSERT $F$mj"):$m->update($a,$N,$mj)));$_a=$g->affected_rows;}else{foreach((array)$_POST["check"]as$X){$ij="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$p);$G=($_POST["delete"]?$m->delete($a,$ij,1):($_POST["clone"]?queries("INSERT".limit1($a,$F,$ij)):$m->update($a,$N,$ij,1)));if(!$G)break;$_a+=$g->affected_rows;}}}$Oe=lang(249,$_a);if($_POST["clone"]&&$G&&$_a==1){$re=last_id();if($re)$Oe=lang(168," $re");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$Oe,$G);if(!$_POST["delete"]){edit_form($a,$p,(array)$_POST["fields"],!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$n=lang(250);else{$G=true;$_a=0;foreach($_POST["val"]as$Ii=>$I){$N=array();foreach($I
as$y=>$X){$y=bracket_escape($y,1);$N[idf_escape($y)]=(preg_match('~char|text~',$p[$y]["type"])||$X!=""?$b->processInput($p[$y],$X):"NULL");}$G=$m->update($a,$N," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($Ii,$p),!$ae&&!$ng," ");if(!$G)break;$_a+=$g->affected_rows;}queries_redirect(remove_from_uri(),lang(249,$_a),$G);}}elseif(!is_string($Vc=get_file("csv_file",true)))$n=upload_error($Vc);elseif(!preg_match('~~u',$Vc))$n=lang(251);else{cookie("adminer_import","output=".urlencode($za["output"])."&format=".urlencode($_POST["separator"]));$G=true;$sb=array_keys($p);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$Vc,$Ge);$_a=count($Ge[0]);$m->begin();$L=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$J=array();foreach($Ge[0]as$y=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$L]*)$L~",$X.$L,$He);if(!$y&&!array_diff($He[1],$sb)){$sb=$He[1];$_a--;}else{$N=array();foreach($He[1]as$s=>$ob)$N[idf_escape($sb[$s])]=($ob==""&&$p[$sb[$s]]["null"]?"NULL":q(str_replace('""','"',preg_replace('~^"|"$~','',$ob))));$J[]=$N;}}$G=(!$J||$m->insertUpdate($a,$J,$ng));if($G)$G=$m->commit();queries_redirect(remove_from_uri("page"),lang(252,$_a),$G);$m->rollback();}}}$Sh=$b->tableName($R);if(is_ajax()){page_headers();ob_start();}else
page_header(lang(54).": $Sh",$n);$N=null;if(isset($Vg["insert"])||!support("table")){$N="";foreach((array)$_GET["where"]as$X){if($gd[$X["col"]]&&count($gd[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&!preg_match('~[_%]~',$X["val"]))))$N.="&set".urlencode("[".bracket_escape($X["col"])."]")."=".urlencode($X["val"]);}}$b->selectLinks($R,$N);if(!$f&&support("table"))echo"<p class='error'>".lang(253).($p?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):"");echo'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($K,$f);$b->selectSearchPrint($Z,$f,$w);$b->selectOrderPrint($Cf,$f,$w);$b->selectLimitPrint($z);$b->selectLengthPrint($gi);$b->selectActionPrint($w);echo"</form>\n";$D=$_GET["page"];if($D=="last"){$jd=$g->result(count_rows($a,$Z,$ae,$pd));$D=floor(max(0,$jd-1)/$z);}$hh=$K;$qd=$pd;if(!$hh){$hh[]="*";$Eb=convert_fields($f,$p,$K);if($Eb)$hh[]=substr($Eb,2);}foreach($K
as$y=>$X){$o=$p[idf_unescape($X)];if($o&&($Ha=convert_field($o)))$hh[$y]="$Ha AS $X";}if(!$ae&&$Ki){foreach($Ki
as$y=>$X){$hh[]=idf_escape($y);if($qd)$qd[]=idf_escape($y);}}$G=$m->select($a,$hh,$Z,$qd,$Cf,$z,$D,true);if(!$G)echo"<p class='error'>".error()."\n";else{if($x=="mssql"&&$D)$G->seek($z*$D);$uc=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$J=array();while($I=$G->fetch_assoc()){if($D&&$x=="oracle")unset($I["RNUM"]);$J[]=$I;}if($_GET["page"]!="last"&&$z!=""&&$pd&&$ae&&$x=="sql")$jd=$g->result(" SELECT FOUND_ROWS()");if(!$J)echo"<p class='message'>".lang(12)."\n";else{$Ra=$b->backwardKeys($a,$Sh);echo"<div class='scrollable'>","<table id='table' cellspacing='0' class='nowrap checkable'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$pd&&$K?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".lang(254)."</a>");$af=array();$md=array();reset($K);$Bg=1;foreach($J[0]as$y=>$X){if(!isset($Ki[$y])){$X=$_GET["columns"][key($K)];$o=$p[$K?($X?$X["col"]:current($K)):$y];$B=($o?$b->fieldName($o,$Bg):($X["fun"]?"*":$y));if($B!=""){$Bg++;$af[$y]=$B;$e=idf_escape($y);$Dd=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($y);$Zb="&desc%5B0%5D=1";echo"<th>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});",""),'<a href="'.h($Dd.($Cf[0]==$e||$Cf[0]==$y||(!$Cf&&$ae&&$pd[0]==$e)?$Zb:'')).'">';echo
apply_sql_function($X["fun"],$B)."</a>";echo"<span class='column hidden'>","<a href='".h($Dd.$Zb)."' title='".lang(60)."' class='text'> â†“</a>";if(!$X["fun"]){echo'<a href="#fieldset-search" title="'.lang(57).'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($y)."');");}echo"</span>";}$md[$y]=$X["fun"];next($K);}}$xe=array();if($_GET["modify"]){foreach($J
as$I){foreach($I
as$y=>$X)$xe[$y]=max($xe[$y],min(40,strlen(utf8_decode($X))));}}echo($Ra?"<th>".lang(255):"")."</thead>\n";if(is_ajax()){if($z%2==1&&$D%2==1)odd();ob_end_clean();}foreach($b->rowDescriptions($J,$gd)as$Ze=>$I){$Hi=unique_array($J[$Ze],$w);if(!$Hi){$Hi=array();foreach($J[$Ze]as$y=>$X){if(!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~',$y))$Hi[$y]=$X;}}$Ii="";foreach($Hi
as$y=>$X){if(($x=="sql"||$x=="pgsql")&&preg_match('~char|text|enum|set~',$p[$y]["type"])&&strlen($X)>64){$y=(strpos($y,'(')?$y:idf_escape($y));$y="MD5(".($x!='sql'||preg_match("~^utf8~",$p[$y]["collation"])?$y:"CONVERT($y USING ".charset($g).")").")";$X=md5($X);}$Ii.="&".($X!==null?urlencode("where[".bracket_escape($y)."]")."=".urlencode($X):"null%5B%5D=".urlencode($y));}echo"<tr".odd().">".(!$pd&&$K?"":"<td>".checkbox("check[]",substr($Ii,1),in_array(substr($Ii,1),(array)$_POST["check"])).($ae||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$Ii)."' class='edit'>".lang(256)."</a>"));foreach($I
as$y=>$X){if(isset($af[$y])){$o=$p[$y];$X=$m->value($X,$o);if($X!=""&&(!isset($uc[$y])||$uc[$y]!=""))$uc[$y]=(is_mail($X)?$af[$y]:"");$_="";if(preg_match('~blob|bytea|raw|file~',$o["type"])&&$X!="")$_=ME.'download='.urlencode($a).'&field='.urlencode($y).$Ii;if(!$_&&$X!==null){foreach((array)$gd[$y]as$q){if(count($gd[$y])==1||end($q["source"])==$y){$_="";foreach($q["source"]as$s=>$zh)$_.=where_link($s,$q["target"][$s],$J[$Ze][$zh]);$_=($q["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($q["db"]),ME):ME).'select='.urlencode($q["table"]).$_;if($q["ns"])$_=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($q["ns"]),$_);if(count($q["source"])==1)break;}}}if($y=="COUNT(*)"){$_=ME."select=".urlencode($a);$s=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$Hi))$_.=where_link($s++,$W["col"],$W["val"],$W["op"]);}foreach($Hi
as$fe=>$W)$_.=where_link($s++,$fe,$W);}$X=select_value($X,$_,$o,$gi);$t=h("val[$Ii][".bracket_escape($y)."]");$Y=$_POST["val"][$Ii][bracket_escape($y)];$pc=!is_array($I[$y])&&is_utf8($X)&&$J[$Ze][$y]==$I[$y]&&!$md[$y];$fi=preg_match('~text|lob~',$o["type"]);echo"<td id='$t'";if(($_GET["modify"]&&$pc)||$Y!==null){$ud=h($Y!==null?$Y:$I[$y]);echo">".($fi?"<textarea name='$t' cols='30' rows='".(substr_count($I[$y],"\n")+1)."'>$ud</textarea>":"<input name='$t' value='$ud' size='$xe[$y]'>");}else{$Be=strpos($X,"<i>â€¦</i>");echo" data-text='".($Be?2:($fi?1:0))."'".($pc?"":" data-warning='".h(lang(257))."'").">$X</td>";}}}if($Ra)echo"<td>";$b->backwardKeysPrint($Ra,$J[$Ze]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($J||$D){$Dc=true;if($_GET["page"]!="last"){if($z==""||(count($J)<$z&&($J||!$D)))$jd=($D?$D*$z:0)+count($J);elseif($x!="sql"||!$ae){$jd=($ae?false:found_rows($R,$Z));if($jd<max(1e4,2*($D+1)*$z))$jd=reset(slow_query(count_rows($a,$Z,$ae,$pd)));else$Dc=false;}}$Pf=($z!=""&&($jd===false||$jd>$z||$D));if($Pf){echo(($jd===false?count($J)+1:$jd-$D*$z)>$z?'<p><a href="'.h(remove_from_uri("page")."&page=".($D+1)).'" class="loadmore">'.lang(258).'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$z).", '".lang(259)."â€¦');",""):''),"\n";}}echo"<div class='footer'><div>\n";if($J||$D){if($Pf){$Je=($jd===false?$D+(count($J)>=$z?2:1):floor(($jd-1)/$z));echo"<fieldset>";if($x!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".lang(260)."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".lang(260)."', '".($D+1)."')); return false; };"),pagination(0,$D).($D>5?" â€¦":"");for($s=max(1,$D-4);$s<min($Je,$D+5);$s++)echo
pagination($s,$D);if($Je>0){echo($D+5<$Je?" â€¦":""),($Dc&&$jd!==false?pagination($Je,$D):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$Je'>".lang(261)."</a>");}}else{echo"<legend>".lang(260)."</legend>",pagination(0,$D).($D>1?" â€¦":""),($D?pagination($D,$D):""),($Je>$D?pagination($D+1,$D).($Je>$D+1?" â€¦":""):"");}echo"</fieldset>\n";}echo"<fieldset>","<legend>".lang(262)."</legend>";$ec=($Dc?"":"~ ").$jd;echo
checkbox("all",1,0,($jd!==false?($Dc?"":"~ ").lang(150,$jd):""),"var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$ec' : checked); selectCount('selected2', this.checked || !checked ? '$ec' : checked);")."\n","</fieldset>\n";if($b->selectCommandPrint()){echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>',lang(254),'</legend><div>
<input type="submit" value="',lang(14),'"',($_GET["modify"]?'':' title="'.lang(250).'"'),'>
</div></fieldset>
<fieldset><legend>',lang(126),' <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="',lang(10),'">
<input type="submit" name="clone" value="',lang(246),'">
<input type="submit" name="delete" value="',lang(18),'">',confirm(),'</div></fieldset>
';}$hd=$b->dumpFormat();foreach((array)$_GET["columns"]as$e){if($e["fun"]){unset($hd['sql']);break;}}if($hd){print_fieldset("export",lang(74)." <span id='selected2'></span>");$Nf=$b->dumpOutput();echo($Nf?html_select("output",$Nf,$za["output"])." ":""),html_select("format",$hd,$za["format"])," <input type='submit' name='export' value='".lang(74)."'>\n","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($uc,'strlen'),$f);}echo"</div></div>\n";if($b->selectImportPrint()){echo"<div>","<a href='#import'>".lang(73)."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import' class='hidden'>: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$za["format"],1);echo" <input type='submit' name='import' value='".lang(73)."'>","</span>","</div>";}echo"<input type='hidden' name='token' value='$ri'>\n","</form>\n",(!$pd&&$K?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$O=isset($_GET["status"]);page_header($O?lang(118):lang(117));$Zi=($O?show_status():show_variables());if(!$Zi)echo"<p class='message'>".lang(12)."\n";else{echo"<table cellspacing='0'>\n";foreach($Zi
as$y=>$X){echo"<tr>","<th><code class='jush-".$x.($O?"status":"set")."'>".h($y)."</code>","<td>".h($X);}echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$Ph=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$B=>$R){json_row("Comment-$B",h($R["Comment"]));if(!is_view($R)){foreach(array("Engine","Collation")as$y)json_row("$y-$B",h($R[$y]));foreach($Ph+array("Auto_increment"=>0,"Rows"=>0)as$y=>$X){if($R[$y]!=""){$X=format_number($R[$y]);json_row("$y-$B",($y=="Rows"&&$X&&$R["Engine"]==($Bh=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($Ph[$y]))$Ph[$y]+=($R["Engine"]!="InnoDB"||$y!="Data_free"?$R[$y]:0);}elseif(array_key_exists($y,$R))json_row("$y-$B");}}}foreach($Ph
as$y=>$X)json_row("sum-$y",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$g->query("KILL ".number($_POST["kill"]));else{foreach(count_tables($b->databases())as$l=>$X){json_row("tables-$l",$X);json_row("size-$l",db_size($l));}json_row("");}exit;}else{$Yh=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($Yh&&!$n&&!$_POST["search"]){$G=true;$Oe="";if($x=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$G=truncate_tables($_POST["tables"]);$Oe=lang(263);}elseif($_POST["move"]){$G=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Oe=lang(264);}elseif($_POST["copy"]){$G=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Oe=lang(265);}elseif($_POST["drop"]){if($_POST["views"])$G=drop_views($_POST["views"]);if($G&&$_POST["tables"])$G=drop_tables($_POST["tables"]);$Oe=lang(266);}elseif($x!="sql"){$G=($x=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$Oe=lang(267);}elseif(!$_POST["tables"])$Oe=lang(9);elseif($G=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('idf_escape',$_POST["tables"])))){while($I=$G->fetch_assoc())$Oe.="<b>".h($I["Table"])."</b>: ".h($I["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$Oe,$G);}page_header(($_GET["ns"]==""?lang(38).": ".h(DB):lang(78).": ".h($_GET["ns"])),$n,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".lang(268)."</h3>\n";$Xh=tables_list();if(!$Xh)echo"<p class='message'>".lang(9)."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".lang(269)." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".lang(57)."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]="LIKE %%";search_tables();}}echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.lang(131),'<td>'.lang(270).doc_link(array('sql'=>'storage-engines.html')),'<td>'.lang(122).doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.lang(271).doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT','oracle'=>'REFRN20286')),'<td>'.lang(272).doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')),'<td>'.lang(273).doc_link(array('sql'=>'show-table-status.html')),'<td>'.lang(52).doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.lang(274).doc_link(array('sql'=>'show-table-status.html','pgsql'=>'catalog-pg-class.html#CATALOG-PG-CLASS','oracle'=>'REFRN20286')),(support("comment")?'<td>'.lang(51).doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')):''),"</thead>\n";$S=0;foreach($Xh
as$B=>$T){$cj=($T!==null&&!preg_match('~table~i',$T));$t=h("Table-".$B);echo'<tr'.odd().'><td>'.checkbox(($cj?"views[]":"tables[]"),$B,in_array($B,$Yh,true),"","","",$t),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($B)."' title='".lang(43)."' id='$t'>".h($B).'</a>':h($B));if($cj){echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($B).'" title="'.lang(44).'">'.(preg_match('~materialized~i',$T)?lang(129):lang(130)).'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($B).'" title="'.lang(42).'">?</a>';}else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",lang(45)),"Index_length"=>array("indexes",lang(133)),"Data_free"=>array("edit",lang(46)),"Auto_increment"=>array("auto_increment=1&create",lang(45)),"Rows"=>array("select",lang(42)),)as$y=>$_){$t=" id='$y-".h($B)."'";echo($_?"<td align='right'>".(support("table")||$y=="Rows"||(support("indexes")&&$y!="Data_length")?"<a href='".h(ME."$_[0]=").urlencode($B)."'$t title='$_[1]'>?</a>":"<span$t>?</span>"):"<td id='$y-".h($B)."'>");}$S++;}echo(support("comment")?"<td id='Comment-".h($B)."'>":"");}echo"<tr><td><th>".lang(247,count($Xh)),"<td>".h($x=="sql"?$g->result("SELECT @@storage_engine"):""),"<td>".h(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$y)echo"<td align='right' id='sum-$y'>";echo"</table>\n","</div>\n";if(!information_schema(DB)){echo"<div class='footer'><div>\n";$Wi="<input type='submit' value='".lang(275)."'> ".on_help("'VACUUM'");$zf="<input type='submit' name='optimize' value='".lang(276)."'> ".on_help($x=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".lang(126)." <span id='selected'></span></legend><div>".($x=="sqlite"?$Wi:($x=="pgsql"?$Wi.$zf:($x=="sql"?"<input type='submit' value='".lang(277)."'> ".on_help("'ANALYZE TABLE'").$zf."<input type='submit' name='check' value='".lang(278)."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".lang(279)."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".lang(280)."'> ".on_help($x=="sqlite"?"'DELETE'":"'TRUNCATE".($x=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".lang(127)."'>".on_help("'DROP TABLE'").confirm()."\n";$k=(support("scheme")?$b->schemas():$b->databases());if(count($k)!=1&&$x!="sqlite"){$l=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".lang(281).": ",($k?html_select("target",$k,$l):'<input name="target" value="'.h($l).'" autocapitalize="off">')," <input type='submit' name='move' value='".lang(282)."'>",(support("copy")?" <input type='submit' name='copy' value='".lang(283)."'> ".checkbox("overwrite",1,$_POST["overwrite"],lang(284)):""),"\n";}echo"<input type='hidden' name='all' value=''>";echo
script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $S);":"")." }"),"<input type='hidden' name='token' value='$ri'>\n","</div></fieldset>\n","</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.lang(75)."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.lang(204)."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".lang(143)."</h3>\n";$Zg=routines();if($Zg){echo"<table cellspacing='0'>\n",'<thead><tr><th>'.lang(183).'<td>'.lang(50).'<td>'.lang(221)."<td></thead>\n";odd('');foreach($Zg
as$I){$B=($I["SPECIFIC_NAME"]==$I["ROUTINE_NAME"]?"":"&name=".urlencode($I["ROUTINE_NAME"]));echo'<tr'.odd().'>','<th><a href="'.h(ME.($I["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($I["SPECIFIC_NAME"]).$B).'">'.h($I["ROUTINE_NAME"]).'</a>','<td>'.h($I["ROUTINE_TYPE"]),'<td>'.h($I["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($I["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($I["SPECIFIC_NAME"]).$B).'">'.lang(136)."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.lang(220).'</a>':'').'<a href="'.h(ME).'function=">'.lang(219)."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".lang(285)."</h3>\n";$nh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($nh){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(183)."</thead>\n";odd('');foreach($nh
as$X)echo"<tr".odd()."><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".lang(226)."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".lang(26)."</h3>\n";$Ui=types();if($Ui){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(183)."</thead>\n";odd('');foreach($Ui
as$X)echo"<tr".odd()."><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".lang(230)."</a>\n";}if(support("event")){echo"<h3 id='events'>".lang(144)."</h3>\n";$J=get_rows("SHOW EVENTS");if($J){echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(183)."<td>".lang(286)."<td>".lang(210)."<td>".lang(211)."<td></thead>\n";foreach($J
as$I){echo"<tr>","<th>".h($I["Name"]),"<td>".($I["Execute at"]?lang(287)."<td>".$I["Execute at"]:lang(212)." ".$I["Interval value"]." ".$I["Interval field"]."<td>$I[Starts]"),"<td>$I[Ends]",'<td><a href="'.h(ME).'event='.urlencode($I["Name"]).'">'.lang(136).'</a>';}echo"</table>\n";$Bc=$g->result("SELECT @@event_scheduler");if($Bc&&$Bc!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($Bc)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.lang(209)."</a>\n";}if($Xh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();