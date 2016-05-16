<?php
error_reporting(0);
header('Content-Type: text/html; charset=utf-8');
$SCRIPT_NAME = "";
$adminfile = $SCRIPT_NAME;
$tbcolor1 = "#bacaee";
$tbcolor2 = "#daeaff";
$tbcolor3 = "#7080dd";
$bgcolor1 = "#ffffff";
$bgcolor2 = "#a6a6a6";
$bgcolor3 = "#003399";
$txtcolor1 = "#000000";
$txtcolor2 = "#003399";
$filefolder = "./";
$sitetitle = 'ftp文件管理系统';
$user = 'admin';
$pass = 'admin';
$meurl = $_SERVER['PHP_SELF'];
$me = end(explode('/',$meurl));


$op = $_REQUEST['op'];
$folder = $_REQUEST['folder'];
while (preg_match('/\.\.\//',$folder)) $folder = preg_replace('/\.\.\//','/',$folder);
while (preg_match('/\/\//',$folder)) $folder = preg_replace('/\/\//','/',$folder);

if ($folder == '') {
  $folder = $filefolder;
} elseif ($filefolder != '') {
  if (!ereg($filefolder,$folder)) {
    $folder = $filefolder;
  }  
}


/****************************************************************/
/* User identification                                          */
/*                                                              */
/* Looks for cookies. Yum.                                      */
/****************************************************************/

if ($_COOKIE['user'] != $user || $_COOKIE['pass'] != md5($pass)) {
	if ($_REQUEST['user'] == $user && $_REQUEST['pass'] == $pass) {
	    setcookie('user',$user,time()+60*60*24*1);
	    setcookie('pass',md5($pass),time()+60*60*24*1);
	} else {
		if ($_REQUEST['user'] == $user || $_REQUEST['pass']) $er = true;
		login($er);
	}
}



/****************************************************************/
/* function maintop()                                           */
/*                                                              */
/* Controls the style and look of the site.                     */
/* Recieves $title and displayes it in the title and top.       */
/****************************************************************/
function maintop($title,$showtop = true) {
  global $me,$sitetitle, $lastsess, $login, $viewing, $iftop, $bgcolor1, $bgcolor2, $bgcolor3, $txtcolor1, $txtcolor2, $user, $pass, $password, $debug, $issuper;
  echo "<html>\n<head>\n"
      ."<title>$sitetitle :: $title</title>\n"
      ."</head>\n"
      ."<body bgcolor=\"#ffffff\">\n"
      ."<style>\n"
      ."td { font-size : 80%;font-family : tahoma;color: $txtcolor1;font-weight: 700;}\n"
      ."A:visited {color: \"$txtcolor2\";font-weight: bold;text-decoration: underline;}\n"
      ."A:hover {color: \"$txtcolor1\";font-weight: bold;text-decoration: underline;}\n"
      ."A:link {color: \"$txtcolor2\";font-weight: bold;text-decoration: underline;}\n"
      ."A:active {color: \"$bgcolor2\";font-weight: bold;text-decoration: underline;}\n"
      ."textarea {border: 1px solid $bgcolor3 ;color: black;background-color: white;}\n"
      ."input.button{border: 1px solid $bgcolor3;color: black;background-color: white;}\n"
      ."input.text{border: 1px solid $bgcolor3;color: black;background-color: white;}\n"
      ."BODY {color: $txtcolor1; FONT-SIZE: 10pt; FONT-FAMILY: Tahoma, Verdana, Arial, Helvetica, sans-serif; scrollbar-base-color: $bgcolor2; MARGIN: 0px 0px 10px; BACKGROUND-COLOR: $bgcolor1}\n"
      .".title {FONT-WEIGHT: bold; FONT-SIZE: 10pt; COLOR: #000000; TEXT-ALIGN: center; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif}\n"
      .".copyright {FONT-SIZE: 8pt; COLOR: #000000; TEXT-ALIGN: left}\n"
      .".error {FONT-SIZE: 10pt; COLOR: #AA2222; TEXT-ALIGN: left}\n"
      ."</style>\n\n";

  if ($viewing == "") {
    echo "<table cellpadding=10 cellspacing=10 bgcolor=$bgcolor1 align=center><tr><td>\n"
        ."<table cellpadding=1 cellspacing=1 bgcolor=$bgcolor2><tr><td>\n"
        ."<table cellpadding=5 cellspacing=5 bgcolor=$bgcolor1><tr><td>\n";
  } else {
    echo "<table cellpadding=7 cellspacing=7 bgcolor=$bgcolor1><tr><td>\n";
  }

  echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
      ."<tr><td align=\"left\"><font face=\"Arial\" color=\"black\" size=\"4\">$sitetitle</font><font size=\"3\" color=\"black\"> :: $title</font></td>\n"
      ."<tr><td width=650 style=\"height: 1px;\" bgcolor=\"black\"></td></tr>\n";

  if ($showtop) {
    echo "<tr><td><font size=\"2\">\n"
        ."<a href=\"".$adminfile."?op=home\" $iftop>主页</a>\n"
        ."<img src=pixel.gif width=7 height=1><a href=\"".$adminfile."?op=up\" $iftop>上传</a>\n"
        ."<img src=pixel.gif width=7 height=1><a href=\"".$adminfile."?op=cr\" $iftop>创建</a>\n"
        ."<img src=pixel.gif width=7 height=1><a href=\"".$adminfile."?op=allz\" $iftop>全站备份</a>\n"
        ."<img src=pixel.gif width=7 height=1><a href=\"".$adminfile."?op=sqlb\" $iftop>数据库备份</a>\n"
        ."<img src=pixel.gif width=7 height=1><a href=\"".$adminfile."?op=ftpa\" $iftop>FTP功能</a>\n"
        ."<img src=pixel.gif width=7 height=1><a href=\"".$adminfile."?op=killme&dename=".$me."&folder=./\">自杀</a>\n"
        ."<img src=pixel.gif width=7 height=1><a href=\"".$adminfile."?op=logout\" $iftop>退出</a>\n";

    echo "<tr><td width=650 style=\"height: 1px;\" bgcolor=\"black\"></td></tr>\n";
  }
  echo "</table><br>\n";
}


/****************************************************************/
/* function login()                                             */
/*                                                              */
/* Sets the cookies and alows user to log in.                   */
/* Recieves $pass as the user entered password.                 */
/****************************************************************/
function login($er=false) {
  global $op;
  global $user;
  global $pass;
    setcookie("user","",time()-60*60*24*1);
    setcookie("pass","",time()-60*60*24*1);
    maintop("登录",false);

    if ($er) { 
		echo "<font class=error>**错误: 不正确的登录信息.**</font><br><br>\n"; 
	}

    echo "<form action=\"".$adminfile."?op=".$op."\" method=\"post\">\n"
        ."<table><tr>\n"
        ."<td><font size=\"2\">用户名: </font>"
        ."<td><input type=\"text\" name=\"user\" size=\"18\" border=\"0\" class=\"text\" value=\"$user\">\n"
        ."<tr><td><font size=\"2\">密码: </font>\n"
        ."<td><input type=\"password\" name=\"pass\" size=\"18\" border=\"0\" class=\"text\" value=\"$pass\">\n"
        ."<tr><td colspan=\"2\"><input type=\"submit\" name=\"submitButtonName\" value=\"登录\" border=\"0\" class=\"button\">\n"
        ."</table>\n"
        ."</form>\n";
  mainbottom();

}


/****************************************************************/
/* function home()                                              */
/*                                                              */
/* Main function that displays contents of folders.             */
/****************************************************************/
function home() {
  global $folder, $tbcolor1, $tbcolor2, $tbcolor3, $filefolder, $HTTP_HOST;
  maintop("主页");
  echo "<font face=\"tahoma\" size=\"2\"><b>\n"
      ."<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=100%>\n";

  $content1 = "";
  $content2 = "";

  $count = "0";
  $style = opendir($folder);
  $a=1;
  $b=1;

  if ($folder) {
    if (ereg("/home/",$folder)) {
      $folderx = ereg_replace("$filefolder", "", $folder);
      $folderx = "http://".$HTTP_HOST."/".$folderx;
    } else {
      $folderx = $folder;
    } 
  }

  while($stylesheet = readdir($style)) {
    if (strlen($stylesheet)>40) { 
      $sstylesheet = substr($stylesheet,0,40)."...";
    } else {
      $sstylesheet = $stylesheet;
    }
    if ($stylesheet[0] != "." && $stylesheet[0] != ".." ) {
      if (is_dir($folder.$stylesheet) && is_readable($folder.$stylesheet)) { 
        $content1[$a] ="<td>".$sstylesheet."</td>\n"
                 ."<td> "
                 //.disk_total_space($folder.$stylesheet)." Commented out due to certain problems
                 ."<td align=\"left\"><img src=pixel.gif width=5 height=1>".substr(sprintf('%o',fileperms($folder.$stylesheet)), -4)
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=home&folder=".$folder.$stylesheet."/\">打开</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=ren&file=".$stylesheet."&folder=$folder\">重命名</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=z&dename=".$stylesheet."&folder=$folder\">压缩</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=del&dename=".$stylesheet."&folder=$folder\">删除</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=mov&file=".$stylesheet."&folder=$folder\">移动</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=chm&file=".$stylesheet."&folder=$folder\">设置</a>\n"
                 ."<td align=\"center\"> <tr height=\"2\"><td height=\"2\" colspan=\"3\">\n";
        $a++;
      } elseif (!is_dir($folder.$stylesheet) && is_readable($folder.$stylesheet)) { 
        $content2[$b] ="<td><a href=\"".$folderx.$stylesheet."\">".$sstylesheet."</a></td>\n"
                 ."<td align=\"left\"><img src=pixel.gif width=5 height=1>".filesize($folder.$stylesheet)
                 ."<td align=\"left\"><img src=pixel.gif width=5 height=1>".substr(sprintf('%o',fileperms($folder.$stylesheet)), -4)
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=edit&fename=".$stylesheet."&folder=$folder\">编辑</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=ren&file=".$stylesheet."&folder=$folder\">重命名</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=unz&dename=".$stylesheet."&folder=$folder\">解压</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=del&dename=".$stylesheet."&folder=$folder\">删除</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=mov&file=".$stylesheet."&folder=$folder\">移动</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=chm&file=".$stylesheet."&folder=$folder\">设置</a>\n"
                 ."<td align=\"center\"><a href=\"".$adminfile."?op=viewframe&file=".$stylesheet."&folder=$folder\">查看</a>\n"
                 ."<tr height=\"2\"><td height=\"2\" colspan=\"3\">\n";
        $b++;
      } else {
        echo "Directory is unreadable\n";
      }
    $count++;
    } 
  }
  closedir($style);

  echo "浏览目录: $folder\n"
       ."<br>文件数: " . $count . "<br><br>";

  echo "<tr bgcolor=\"$tbcolor3\" width=100%>"
      ."<td width=220>档名\n"
      ."<td width=65>大小\n"
      ."<td width=35>权限\n"
      ."<td align=\"center\" width=44>打开\n"
      ."<td align=\"center\" width=58>重命名\n"
      ."<td align=\"center\" width=45>压缩\n"
      ."<td align=\"center\" width=45>删除\n"
      ."<td align=\"center\" width=45>移动\n"
      ."<td align=\"center\" width=45>权限\n"
      ."<td align=\"center\" width=45>查看\n"
      ."<tr height=\"2\"><td height=\"2\" colspan=\"3\">\n";

  for ($a=1; $a<count($content1)+1;$a++) {
    $tcoloring   = ($a % 2) ? $tbcolor1 : $tbcolor2;
    echo "<tr bgcolor=".$tcoloring." width=100%>";
    echo $content1[$a];
  }

  for ($b=1; $b<count($content2)+1;$b++) {
    $tcoloring   = ($a++ % 2) ? $tbcolor1 : $tbcolor2;
    echo "<tr bgcolor=".$tcoloring." width=100%>";
    echo $content2[$b];
  }

  echo"</table>";
  mainbottom();
}


/****************************************************************/
/* function up()                                                */
/*                                                              */
/* First step to Upload.                                        */
/* User enters a file and the submits it to upload()            */
/****************************************************************/

function up() {
  global $folder, $content, $filefolder;
  maintop("上传");

  echo "<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"".$adminfile."?op=upload\" METHOD=\"POST\">\n"
      ."<font face=\"tahoma\" size=\"2\"><b>本地上传 <br>文件:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上传目录:</b></font><br><input type=\"File\" name=\"upfile\" size=\"20\" class=\"text\">\n"
      ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name=\"ndir\" size=1>\n"
      ."<option value=\"".$filefolder."\">".$filefolder."</option>";
  listdir($filefolder);
  echo $content
      ."</select><br>"
      ."<input type=\"submit\" value=\"上传\" class=\"button\">\n"
      ."</form>\n";
  echo "远程上传是什么意思？<br>远程上传是从其他服务器获取文件并直接下载到当前服务器的一种功能。<br>类似于SSH的Wget功能，免去我们下载再手动上传所浪费的时间。<br><br>远程下载地址:<form action=\"".$adminfile."?op=yupload\" method=\"POST\"><input name=\"url\" size=\"80\" /><input name=\"submit\" value=\"上传\" type=\"submit\" /></form>\n"
    ."以下为备用下载地址：（请手动复制）"
    ."<br>Wordpress：http://tool.gidc.me/file/wordpress.zip"
    ."<br>Typecho：http://tool.gidc.me/file/typecho.zip"
    ."<br>EMBlog：http://tool.gidc.me/file/emblog.zip<br><br>";
  mainbottom();
}

/****************************************************************/
/* function yupload()                                           */
/*                                                              */
/* Second step in wget file.                                    */
/* Saves the file to the disk.                                  */
/* Recieves $upfile from up() as the uploaded file.             */
/****************************************************************/

function yupload($url, $folder = "./") {
set_time_limit (24 * 60 * 60); // 设置超时时间
$destination_folder = $folder . './'; // 文件下载保存目录，默认为当前文件目录
if (!is_dir($destination_folder)) { // 判断目录是否存在
mkdirs($destination_folder); // 如果没有就建立目录
}
$newfname = $destination_folder . basename($url); // 取得文件的名称
$file = fopen ($url, "rb"); // 远程下载文件，二进制模式
if ($file) { // 如果下载成功
$newf = fopen ($newfname, "wb"); // 远在文件文件
if ($newf) // 如果文件保存成功
while (!feof($file)) { // 判断附件写入是否完整
fwrite($newf, fread($file, 1024 * 8), 1024 * 8); // 没有写完就继续
}
}
if ($file) {
fclose($file); // 关闭远程文件
}
if ($newf) {
fclose($newf); // 关闭本地文件
}
maintop("远程上传");
echo "文件 ".$url." 上传成功.\n"
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
mainbottom();
return true;
}

/****************************************************************/
/* function upload()                                            */
/*                                                              */
/* Second step in upload.                                      */
/* Saves the file to the disk.                                  */
/* Recieves $upfile from up() as the uploaded file.             */
/****************************************************************/
function upload($upfile, $ndir) {

  global $folder;
  if (!$upfile) {
    error("文件太大 或 文件大小等于0");
  } elseif($upfile['name']) { 
    if(copy($upfile['tmp_name'],$ndir.$upfile['name'])) { 
      maintop("上传");
      echo "文件 ".$upfile['name'].$folder.$upfile_name." 上传成功.\n";
      mainbottom();
    } else {
      printerror("文件 $upfile 上传失败.");
    }
  } else {
    printerror("请输入文件名.");
  }
}

/****************************************************************/
/* function allz()                                               */
/*                                                              */
/* First step in allzip.                                        */
/* Prompts the user for confirmation.                           */
/* Recieves $dename and ask for deletion confirmation.          */
/****************************************************************/
function allz() {
    maintop("全站备份");
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
        ."<font class=error>**警告: 这将进行全站打包成allbackup.zip的动作! 如存在该文件，该文件将被覆盖!**</font><br><br>\n"
        ."确定要进行全站打包?<br><br>\n"
        ."<a href=\"".$adminfile."?op=allzip\">确定</a> | \n"
        ."<a href=\"".$adminfile."?op=home\"> 取消 </a>\n"
        ."</table>\n";
    mainbottom();
}

/****************************************************************/
/* function allzip()                                            */
/*                                                              */
/* Second step in unzip.                                       */
/****************************************************************/
function allzip() {
maintop("全站备份");
if (file_exists('allbackup.zip')) {
unlink('allbackup.zip'); }
else {
}
class Zipper extends ZipArchive {
public function addDir($path) {
print 'adding ' . $path . '<br>';
$this->addEmptyDir($path);
$nodes = glob($path . '/*');
foreach ($nodes as $node) {
print $node . '<br>';
if (is_dir($node)) {
$this->addDir($node);
} else if (is_file($node))  {
$this->addFile($node);
}
}
} 
}
$zip = new Zipper;
$res = $zip->open('allbackup.zip', ZipArchive::CREATE);
if ($res === TRUE) {
$zip->addDir('.');
$zip->close();
echo '全站压缩完成！'
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
} else {
echo '全站压缩失败！'
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
}
    mainbottom();
}

/****************************************************************/
/* function unz()                                               */
/*                                                              */
/* First step in unz.                                        */
/* Prompts the user for confirmation.                           */
/* Recieves $dename and ask for deletion confirmation.          */
/****************************************************************/
function unz($dename) {
  global $folder;
    if (!$dename == "") {
    maintop("解压");
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
        ."<font class=error>**警告: 这将解压 ".$folder.$dename." 到$folder. **</font><br><br>\n"
        ."确定要解压 ".$folder.$dename."?<br><br>\n"
        ."<a href=\"".$adminfile."?op=unzip&dename=".$dename."&folder=$folder\">确定</a> | \n"
        ."<a href=\"".$adminfile."?op=home\"> 取消 </a>\n"
        ."</table>\n";
    mainbottom();
  } else {
    home();
  }
}


/****************************************************************/
/* function unzip()                                            */
/*                                                              */
/* Second step in unzip.                                       */
/****************************************************************/
function unzip($dename) {
  global $folder;
  if (!$dename == "") {
    maintop("解压");
 $zip = new ZipArchive();
if ($zip->open($folder.$dename) === TRUE) {
    $zip->extractTo('./'.$folder);
    $zip->close();
    echo $dename." 已经被解压."
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
} else {
    echo '无法解压文件.'
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
}
    mainbottom();
  } else {
    home();
}
}


/****************************************************************/
/* function del()                                               */
/*                                                              */
/* First step in delete.                                        */
/* Prompts the user for confirmation.                           */
/* Recieves $dename and ask for deletion confirmation.          */
/****************************************************************/
function del($dename) {
  global $folder;
    if (!$dename == "") {
    maintop("删除");
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
        ."<font class=error>**警告: 这将永久删除 ".$folder.$dename.". 这个动作是不可还原的.**</font><br><br>\n"
        ."确定要删除 ".$folder.$dename."?<br><br>\n"
        ."<a href=\"".$adminfile."?op=delete&dename=".$dename."&folder=$folder\">确定</a> | \n"
        ."<a href=\"".$adminfile."?op=home\"> 取消 </a>\n"
        ."</table>\n";
    mainbottom();
  } else {
    home();
  }
}


/****************************************************************/
/* function delete()                                            */
/*                                                              */
/* Second step in delete.                                       */
/* Deletes the actual file from disk.                           */
/* Recieves $upfile from up() as the uploaded file.             */
/****************************************************************/
function deltree($pathdir)  
{  
if(is_empty_dir($pathdir))//如果是空的  
   {  
   rmdir($pathdir);//直接删除  
   }  
   else  
   {//否则读这个目录，除了.和..外  
       $d=dir($pathdir);  
       while($a=$d->read())  
       {  
       if(is_file($pathdir.'/'.$a) && ($a!='.') && ($a!='..')){unlink($pathdir.'/'.$a);}  
       //如果是文件就直接删除  
       if(is_dir($pathdir.'/'.$a) && ($a!='.') && ($a!='..'))  
       {//如果是目录  
           if(!is_empty_dir($pathdir.'/'.$a))//是否为空  
           {//如果不是，调用自身，不过是原来的路径+他下级的目录名  
           deltree($pathdir.'/'.$a);  
           }  
           if(is_empty_dir($pathdir.'/'.$a))  
           {//如果是空就直接删除  
           rmdir($pathdir.'/'.$a);
           }
       }  
       }  
       $d->close();  
   }  
}  
function is_empty_dir($pathdir)  
{ 
//判断目录是否为空 
$d=opendir($pathdir);  
$i=0;  
   while($a=readdir($d))  
   {  
   $i++;  
   }  
closedir($d);  
if($i>2){return false;}  
else return true;  
}

function delete($dename) {
  global $folder;
  if (!$dename == "") {
    maintop("删除");
    if (is_dir($folder.$dename)) {
      if(is_empty_dir($folder.$dename)){ 
      rmdir($folder.$dename);
      echo $dename." 已经被删除."
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
    } else {
      deltree($folder.$dename);
      rmdir($folder.$dename);
      echo $dename." 已经被删除."
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
      }
    } else {
      if(unlink($folder.$dename)) {
        echo $dename." 已经被删除."
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
      } else {
        echo "无法删除文件. "
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
      }
    }
    mainbottom();
  } else {
    home();
  }
}


/****************************************************************/
/* function edit()                                              */
/*                                                              */
/* First step in edit.                                          */
/* Reads the file from disk and displays it to be edited.       */
/* Recieves $upfile from up() as the uploaded file.             */
/****************************************************************/
function edit($fename) {
  global $folder;
  if (!$fename == "") {
    maintop("编辑");
    echo $folder.$fename;

    echo "<form action=\"".$adminfile."?op=save\" method=\"post\">\n"
        ."<textarea cols=\"73\" rows=\"40\" name=\"ncontent\">\n";

   $handle = fopen ($folder.$fename, "r");
   $contents = "";

    while ($x<1) {
      $data = @fread ($handle, filesize ($folder.$fename));
      if (strlen($data) == 0) {
        break;
      }
      $contents .= $data;
    }
    fclose ($handle);

    $replace1 = "</text";
    $replace2 = "area>";
    $replace3 = "< / text";
    $replace4 = "area>";
    $replacea = $replace1.$replace2;
    $replaceb = $replace3.$replace4;
    $contents = ereg_replace ($replacea,$replaceb,$contents);

    echo $contents;

    echo "</textarea>\n"
        ."<br><br>\n"
        ."<input type=\"hidden\" name=\"folder\" value=\"".$folder."\">\n"
        ."<input type=\"hidden\" name=\"fename\" value=\"".$fename."\">\n"
        ."<input type=\"submit\" value=\"保存\" class=\"button\">\n"
        ."</form>\n";
    mainbottom();
  } else {
    home();
  }
}


/****************************************************************/
/* function save()                                              */
/*                                                              */
/* Second step in edit.                                         */
/* Recieves $ncontent from edit() as the file content.          */
/* Recieves $fename from edit() as the file name to modify.     */
/****************************************************************/
function save($ncontent, $fename) {
  global $folder;
  if (!$fename == "") {
    maintop("编辑");
    $loc = $folder.$fename;
    $fp = fopen($loc, "w");

    $replace1 = "</text";
    $replace2 = "area>";
    $replace3 = "< / text";
    $replace4 = "area>";
    $replacea = $replace1.$replace2;
    $replaceb = $replace3.$replace4;
    $ncontent = ereg_replace ($replaceb,$replacea,$ncontent);

    $ydata = stripslashes($ncontent);

    if(fwrite($fp, $ydata)) {
      echo "文件 <a href=\"".$adminfile."?op=viewframe&file=".$fename."&folder=".$folder."\">".$folder.$fename."</a> 保存成功！\n"
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
      $fp = null;
    } else {
      echo "文件保存出错！\n"
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
    }
    mainbottom();
  } else {
    home();
  }
}


/****************************************************************/
/* function cr()                                                */
/*                                                              */
/* First step in create.                                        */
/* Promts the user to a filename and file/directory switch.     */
/****************************************************************/
function cr() {
  global $folder, $content, $filefolder;
  maintop("创建");
  if (!$content == "") { echo "<br><br>请输入一个名称.\n"; }
  echo "<form action=\"".$adminfile."?op=create\" method=\"post\">\n"
      ."文件名: <br><input type=\"text\" size=\"20\" name=\"nfname\" class=\"text\"><br><br>\n"
   
      ."目标:<br><select name=ndir size=1>\n"
      ."<option value=\"".$filefolder."\">".$filefolder."</option>";
  listdir($filefolder);
  echo $content
      ."</select><br><br>";


  echo "文件 <input type=\"radio\" size=\"20\" name=\"isfolder\" value=\"0\" checked><br>\n"
      ."目录 <input type=\"radio\" size=\"20\" name=\"isfolder\" value=\"1\"><br><br>\n"
      ."<input type=\"hidden\" name=\"folder\" value=\"$folder\">\n"
      ."<input type=\"submit\" value=\"创建\" class=\"button\">\n"
      ."</form>\n";
  mainbottom();
}


/****************************************************************/
/* function create()                                            */
/*                                                              */
/* Second step in create.                                       */
/* Creates the file/directoy on disk.                           */
/* Recieves $nfname from cr() as the filename.                  */
/* Recieves $infolder from cr() to determine file trpe.         */
/****************************************************************/
function create($nfname, $isfolder, $ndir) {
  global $folder;
  if (!$nfname == "") {
    maintop("创建");

    if ($isfolder == 1) {
      if(mkdir($ndir."/".$nfname, 0777)) {
        echo "您的目录<a href=\"".$adminfile."?op=home&folder=./".$nfname."/\">".$ndir."".$nfname."</a> 已经成功被创建.\n"
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
      } else {
        echo "您的目录".$ndir."".$nfname." 不能被创建. 请检查您的目录权限是否已经被设置为777\n";
      }
    } else {
      if(fopen($ndir."/".$nfname, "w")) {
        echo "您的文件, <a href=\"".$adminfile."?op=viewframe&file=".$nfname."&folder=$ndir\">".$ndir.$nfname."</a> 已经成功被创建.\n"
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
      } else {
        echo "您的文件 ".$ndir."/".$nfname." 不能被创建. 请检查您的目录权限是否已经被设置为777\n";
      }
    }
    mainbottom();
  } else {
    cr();
  }
}

function chm($file) {
  global $folder;
  if (!$file == "") {
    maintop("设置权限");
    echo "<form action=\"".$adminfile."?op=chmodok\" method=\"post\">\n"
        ."<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
        ."设置权限 ".$folder.$file;

    echo "</table><br>\n"
        ."<input type=\"hidden\" name=\"rename\" value=\"".$file."\">\n"
        ."<input type=\"hidden\" name=\"folder\" value=\"".$folder."\">\n"
        ."权限:<br><input class=\"text\" type=\"text\" size=\"20\" name=\"nchmod\">\n"
        ."<input type=\"Submit\" value=\"设置\" class=\"button\">\n";
    echo "<br><br>\n"
         ."权限为四位数，如0777 0755 0644等\n"
         ."<br>\n";
    mainbottom();
  } else {
    home();
  }
}


function chmodok($rename, $nchmod, $folder) {
  global $folder;
  if (!$rename == "") {
    maintop("重命名");
    $loc1 = "$folder".$rename; 
    $loc2 = octdec($nchmod);

    if(chmod($loc1,"$loc2")) {
      echo "文件 ".$folder.$rename." 的权限已经设置为".$nchmod."</a>\n"
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
    } else {
      echo "设置出错！\n"
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
    }
    mainbottom();
  } else {
    home();
  }
}

/****************************************************************/
/* function ren()                                               */
/*                                                              */
/* First step in rename.                                        */
/* Promts the user for new filename.                            */
/* Globals $file and $folder for filename.                      */
/****************************************************************/
function ren($file) {
  global $folder;
  if (!$file == "") {
    maintop("重命名");
    echo "<form action=\"".$adminfile."?op=rename\" method=\"post\">\n"
        ."<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
        ."重命名 ".$folder.$file;

    echo "</table><br>\n"
        ."<input type=\"hidden\" name=\"rename\" value=\"".$file."\">\n"
        ."<input type=\"hidden\" name=\"folder\" value=\"".$folder."\">\n"
        ."新档名:<br><input class=\"text\" type=\"text\" size=\"20\" name=\"nrename\">\n"
        ."<input type=\"Submit\" value=\"重命名\" class=\"button\">\n";
    mainbottom();
  } else {
    home();
  }
}


/****************************************************************/
/* function renam()                                             */
/*                                                              */
/* Second step in rename.                                       */
/* Rename the specified file.                                   */
/* Recieves $rename from ren() as the old  filename.            */
/* Recieves $nrename from ren() as the new filename.            */
/****************************************************************/
function renam($rename, $nrename, $folder) {
  global $folder;
  if (!$rename == "") {
    maintop("重命名");
    $loc1 = "$folder".$rename; 
    $loc2 = "$folder".$nrename;

    if(rename($loc1,$loc2)) {
      echo "文件 ".$folder.$rename." 的档名已被更改成 ".$folder.$nrename."</a>\n"
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
    } else {
      echo "重命名出错！\n"
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
    }
    mainbottom();
  } else {
    home();
  }
}


/****************************************************************/
/* function listdir()                                           */
/*                                                              */
/* Recursivly lists directories and sub-directories.            */
/* Recieves $dir as the directory to scan through.              */
/****************************************************************/
function listdir($dir, $level_count = 0) {
  global $content;
    if (!@($thisdir = opendir($dir))) { return; }
    while ($item = readdir($thisdir) ) {
      if (is_dir("$dir/$item") && (substr("$item", 0, 1) != '.')) {
        listdir("$dir/$item", $level_count + 1);
      }
    }
    if ($level_count > 0) {
      $dir = ereg_replace("[/][/]", "/", $dir);
      $content .= "<option value=\"".$dir."/\">".$dir."/</option>";
    }
}


/****************************************************************/
/* function mov()                                               */
/*                                                              */
/* First step in move.                                          */
/* Prompts the user for destination path.                       */
/* Recieves $file and sends to move().                          */
/****************************************************************/
function mov($file) {
  global $folder, $content, $filefolder;
  if (!$file == "") {
    maintop("移动");
    echo "<form action=\"".$adminfile."?op=move\" method=\"post\">\n"
        ."<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
        ."移动 ".$folder.$file." 到:\n"
        ."<select name=ndir size=1>\n"
        ."<option value=\"".$filefolder."\">".$filefolder."</option>";
    listdir($filefolder);
    echo $content
        ."</select>"
        ."</table><br><input type=\"hidden\" name=\"file\" value=\"".$file."\">\n"
        ."<input type=\"hidden\" name=\"folder\" value=\"".$folder."\">\n" 
        ."<input type=\"Submit\" value=\"移动\" class=\"button\">\n";
    mainbottom();
  } else {
    home();
  }
}


/****************************************************************/
/* function move()                                              */
/*                                                              */
/* Second step in move.                                         */
/* Moves the oldfile to the new one.                            */
/* Recieves $file and $ndir and creates $file.$ndir             */
/****************************************************************/
function move($file, $ndir, $folder) {
  global $folder;
  if (!$file == "") {
    maintop("移动");
    if (rename($folder.$file, $ndir.$file)) {
      echo $folder.$file." 已经成功移动到 ".$ndir.$file
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
    } else {
      echo "无法移动 ".$folder.$file
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
    }
    mainbottom();
  } else {
    home();
  }
}


/****************************************************************/
/* function viewframe()                                         */
/*                                                              */
/* First step in viewframe.                                     */
/* Takes the specified file and displays it in a frame.         */
/* Recieves $file and sends it to viewtop                       */
/****************************************************************/
function viewframe($file) {
  global $sitetitle, $folder, $HTTP_HOST, $filefolder;  
  if ($filefolder == "/") {
    $error="**错误: 你选择查看$file 但你的目录是 /.**";
    printerror($error);
    die();
  } elseif (ereg("/home/",$folder)) {
    $folderx = ereg_replace("$filefolder", "", $folder);
    $folder = "http://".$HTTP_HOST."/".$folderx;
  }
     maintop("查看文件",true);

    echo "<iframe width=\"99%\" height=\"99%\" src=\"".$folder.$file."\">\n"
      ."本站使用了框架技术,但是您的浏览器不支持框架,请升级您的浏览器以便正常访问本站."
      ."</iframe>\n\n";
     mainbottom();
}


/****************************************************************/
/* function viewtop()                                           */
/*                                                              */
/* Second step in viewframe.                                    */
/* Controls the top bar on the viewframe.                       */
/* Recieves $file from viewtop.                                 */
/****************************************************************/
function viewtop($file) {
  global $viewing, $iftop;
  $viewing = "yes";
  $iftop = "target=_top";
  maintop("查看文件 - $file");
}


/****************************************************************/
/* function logout()                                            */
/*                                                              */
/* Logs the user out and kills cookies                          */
/****************************************************************/
function logout() {
  global $login;
  setcookie("user","",time()-60*60*24*1);
  setcookie("pass","",time()-60*60*24*1);

  maintop("退出",false);
  echo "你已经退出."
      ."<br><br>"
      ."<a href=".$adminfile."?op=home>点击这里重新登录.</a>";
  mainbottom();
}


/****************************************************************/
/* function mainbottom()                                        */
/*                                                              */
/* Controls the bottom copyright.                               */
/****************************************************************/
function mainbottom() {
  echo "</table></table>\n"
      ."<table width=100%><tr><td align=right></table>\n"
      ."</table></table></body>\n"
      ."</html>\n";
  exit;
}

/****************************************************************/
/* function sqlb()                                              */
/*                                                              */
/* First step to backup sql.                                    */
/****************************************************************/

function sqlb() {
  maintop("数据库备份");
  echo $content 
      ."<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\"></table><font class=error>**警告: 这将进行数据库导出并压缩成mysql.zip的动作! 如存在该文件,该文件将被覆盖!**</font><br><br><form action=\"".$adminfile."?op=sqlbackup\" method=\"POST\">数据库地址:&nbsp;&nbsp;<input name=\"ip\" size=\"30\" /><br>数据库名称:&nbsp;&nbsp;<input name=\"sql\" size=\"30\" /><br>数据库用户:&nbsp;&nbsp;<input name=\"username\" size=\"30\" /><br>数据库密码:&nbsp;&nbsp;<input name=\"password\" size=\"30\" /><br>数据库编码:&nbsp;&nbsp;<select id=\"chset\"><option id=\utf8\">utf8</option></select><br><input name=\"submit\" value=\"备份\" type=\"submit\" /></form>\n
";
  mainbottom();
}

/****************************************************************/
/* function sqlbackup()                                         */
/*                                                              */
/* Second step in backup sql.                                   */
/****************************************************************/
function sqlbackup($ip,$sql,$username,$password) {
  maintop("数据库备份");
$database=$sql;//数据库名
$options=array(
    'hostname' => $ip,//ip地址
    'charset' => 'utf8',//编码
    'filename' => $database.'.sql',//文件名
    'username' => $username,
    'password' => $password
);
mysql_connect($options['hostname'],$options['username'],$options['password'])or die("不能连接数据库!");
mysql_select_db($database) or die("数据库名称错误!");
mysql_query("SET NAMES '{$options['charset']}'");
$tables = list_tables($database);
$filename = sprintf($options['filename'],$database);
$fp = fopen($filename, 'w');
foreach ($tables as $table) {
    dump_table($table, $fp);
}
fclose($fp);
//压缩sql文件
if (file_exists('mysql.zip')) {
unlink('mysql.zip'); }
else {
}
$file_name=$options['filename'];
$zip = new ZipArchive;
$res = $zip->open('mysql.zip', ZipArchive::CREATE);
if ($res === TRUE) {
$zip->addfile($file_name);
$zip->close();
//删除服务器上的sql文件
unlink($file_name);
echo '数据库导出并压缩完成！'
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
} else {
echo '数据库导出并压缩失败！'
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
}
exit;
//获取表的名称
  mainbottom();
}

function list_tables($database)
{
    $rs = mysql_list_tables($database);
    $tables = array();
    while ($row = mysql_fetch_row($rs)) {
        $tables[] = $row[0];
    }
    mysql_free_result($rs);
    return $tables;
}
//导出数据库
function dump_table($table, $fp = null)
{
    $need_close = false;
    if (is_null($fp)) {
        $fp = fopen($table . '.sql', 'w');
        $need_close = true;
    }
$a=mysql_query("show create table `{$table}`");
$row=mysql_fetch_assoc($a);fwrite($fp,$row['Create Table'].';');//导出表结构
    $rs = mysql_query("SELECT * FROM `{$table}`");
    while ($row = mysql_fetch_row($rs)) {
        fwrite($fp, get_insert_sql($table, $row));
    }
    mysql_free_result($rs);
    if ($need_close) {
        fclose($fp);
    }
}
//导出表数据
function get_insert_sql($table, $row)
{
    $sql = "INSERT INTO `{$table}` VALUES (";
    $values = array();
    foreach ($row as $value) {
        $values[] = "'" . mysql_real_escape_string($value) . "'";
    }
    $sql .= implode(', ', $values) . ");";
    return $sql;
}

function z($dename) {
  global $dename;
    maintop("目录压缩");
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
        ."<font class=error>**警告: 这将进行目录压缩为".$dename.".zip的动作! 如存在该文件，该文件将被覆盖!**</font><br><br>\n"
        ."确定要进行目录压缩?<br><br>\n"
        ."<a href=\"".$adminfile."?op=zip&dename=".$dename."&folder=$folder\">确定</a> | \n"
        ."<a href=\"".$adminfile."?op=home\"> 取消 </a>\n"
        ."</table>\n";
    mainbottom();
}

function zip($dename) {
  global $dename;
  $path = './'.$dename;
maintop("目录压缩");
if (file_exists($dename.'.zip')) {
unlink($dename.'.zip'); }
else {
}
class Zipper extends ZipArchive {
public function addDir($path) {
print 'adding ' . $path . '<br>';
$this->addEmptyDir($path);
$nodes = glob($path . '/*');
foreach ($nodes as $node) {
print $node . '<br>';
if (is_dir($node)) {
$this->addDir($node);
} else if (is_file($node))  {
$this->addFile($node);
}
}
} 
}
$zip = new Zipper;
$res = $zip->open($dename.'.zip', ZipArchive::CREATE);
if ($res === TRUE) {
$zip->addDir($path);
$zip->close();
echo '压缩完成！'
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
} else {
echo '压缩失败！'
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
}
    mainbottom();
}

function killme($dename) {
  global $folder;
  if (!$dename == "") {
    maintop("自杀");
      if(unlink($folder.$dename)) {
        echo "自杀成功. "
        ."&nbsp;<a href=".$folder.">返回网站首页</a>\n";
      } else {
        echo "无法自杀. "
        ."&nbsp;<a href=\"/\">返回网站首页</a>\n";
      }
    mainbottom();
  } else {
    home();
  }
}



/****************************************************************/
/* function ftpa()                                              */
/*                                                              */
/* First step to backup sql.                                    */
/****************************************************************/

function ftpa() {
  maintop("FTP功能");
  echo $content 
      ."<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\"></table><font class=error>**警告: 这将把文件远程上传到其他ftp! 如目录存在该文件,文件将被覆盖!**</font><br><br><form action=\"".$adminfile."?op=ftpall\" method=\"POST\">FTP&nbsp;地址:&nbsp;&nbsp;<input name=\"ftpip\" size=\"30\" /><br>FTP&nbsp;用户:&nbsp;&nbsp;<input name=\"ftpuser\" size=\"30\" /><br>FTP&nbsp;密码:&nbsp;&nbsp;<input name=\"ftppass\" size=\"30\" /><br>上传文件:&nbsp;&nbsp;<input name=\"ftpfile\" size=\"30\" /><br><input name=\"submit\" value=\"备份\" type=\"submit\" /></form>\n
";
  mainbottom();
}

/****************************************************************/
/* function ftpall()                                         */
/*                                                              */
/* Second step in backup sql.                                   */
/****************************************************************/
function ftpall($ftpip,$ftpuser,$ftppass,$ftpfile) {
  maintop("FTP功能");
$ftp_server=$ftpip;//服务器
$ftp_user_name=$ftpuser;//用户名
$ftp_user_pass=$ftppass;//密码
$ftp_port='21';//端口
$ftp_put_dir='./';//上传目录
$ffile=$ftpfile;//上传文件

$ftp_conn_id = ftp_connect($ftp_server,$ftp_port);
$ftp_login_result = ftp_login($ftp_conn_id, $ftp_user_name, $ftp_user_pass);

if ((!$ftp_conn_id) || (!$ftp_login_result)) {
 echo "连接到ftp服务器失败";
 exit;
} else {
 ftp_pasv ($ftp_conn_id,true); //返回一下模式，这句很奇怪，有些ftp服务器一定需要执行这句
 ftp_chdir($ftp_conn_id, $ftp_put_dir);
 $ftp_upload = ftp_put($ftp_conn_id,$ffile,$ffile, FTP_BINARY);
 //var_dump($ftp_upload);//看看是否写入成功
 ftp_close($ftp_conn_id); //断开
}
echo "文件 ".$ftpfile." 上传成功.\n"
    ."&nbsp;<a href=\"".$adminfile."?op=home\">返回文件管理</a>\n";
  mainbottom();
}

/****************************************************************/
/* function printerror()                                        */
/*                                                              */
/* Prints error onto screen                                     */
/* Recieves $error and prints it.                               */
/****************************************************************/
function printerror($error) {
  maintop("错误");
  echo "<font class=error>\n".$error."\n</font>";
  mainbottom();
}


/****************************************************************/
/* function switch()                                            */
/*                                                              */
/* Switches functions.                                          */
/* Recieves $op() and switches to it                            *.
/****************************************************************/
switch($op) {

    case "home":
	home();
	break;
    case "up":
	up();
	break;
    case "yupload":
	yupload($_POST['url']);
	break;
    case "upload":
	upload($_FILES['upfile'], $_REQUEST['ndir']);
	break;

    case "del":
	del($_REQUEST['dename']);
	break;

    case "delete":
	delete($_REQUEST['dename']);
	break;

    case "unz":
	unz($_REQUEST['dename']);
	break;

    case "unzip":
	unzip($_REQUEST['dename']);
	break;
	
    case "sqlb":
	sqlb();
	break;

    case "sqlbackup":
	sqlbackup($_POST['ip'], $_POST['sql'], $_POST['username'], $_POST['password']);
	break;
	
    case "ftpa":
	ftpa();
	break;

    case "ftpall":
	ftpall($_POST['ftpip'], $_POST['ftpuser'], $_POST['ftppass'], $_POST['ftpfile']);
	break;

    case "allz":
	allz();
	break;

    case "allzip":
	allzip();
	break;

    case "edit":
	edit($_REQUEST['fename']);
	break;

    case "save":
	save($_REQUEST['ncontent'], $_REQUEST['fename']);
	break;

    case "cr":
	cr();
	break;

    case "create":
	create($_REQUEST['nfname'], $_REQUEST['isfolder'], $_REQUEST['ndir']);
	break;

    case "chm":
	chm($_REQUEST['file']);
	break;

    case "chmodok":
	chmodok($_REQUEST['rename'], $_REQUEST['nchmod'], $folder);
	break;

    case "ren":
	ren($_REQUEST['file']);
	break;

    case "rename":
	renam($_REQUEST['rename'], $_REQUEST['nrename'], $folder);
	break;

    case "mov":
	mov($_REQUEST['file']);
	break;

    case "move":
	move($_REQUEST['file'], $_REQUEST['ndir'], $folder);
	break;

    case "viewframe":
	viewframe($_REQUEST['file']);
	break;

    case "viewtop":
	viewtop($_REQUEST['file']);
	break;

    case "printerror":
	printerror($error);
	break;

    case "logout":
	logout();
	break;
	
    case "z":
	z($_REQUEST['dename']);
	break;

    case "zip":
	zip($_REQUEST['dename']);
	break;

    case "killme":
	killme($_REQUEST['dename']);
	break;

    default:
	home();
	break;
}
?>