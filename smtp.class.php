<?php
/*
$Smtpserver = "smtp.qq.com";//Smtp服务器
$Smtpserverport =25;//Smtp服务器端口
$Smtpusermail = "logove@qq.com";//Smtp服务器的用户邮箱
$Smtpemailto = "18291448834@139.com";//发送给谁
$Smtpuser = "logove@qq.com";//Smtp服务器的用户帐号
$Smtppass = "2008234logove";//Smtp服务器的用户密码
$mailsubject = "测试邮件1";//邮件主题
$mailbody = "<h1> 这是一个测试程序 PHP100.com </h1>";//邮件内容
$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
$Smtp = new Smtp($Smtpserver,$Smtpserverport,true,$Smtpuser,$Smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
$Smtp->debug = FALSE;//是否显示发送的调试信息
$Smtp->sendmail($Smtpemailto, $Smtpusermail, $mailsubject, $mailbody, $mailtype);
*/
class Smtp
{
/* Public Variables */
var $Smtp_port;
var $time_out;
var $host_name;
var $log_file;
var $relay_host;
var $debug;
var $auth;
var $user;
var $pass;

/* Private Variables */
var $sock;

/* Constractor */
function Smtp($relay_host = "", $Smtp_port = 25,$auth = false,$user,$pass)
{
$this->debug = FALSE;
$this->Smtp_port = $Smtp_port;
$this->relay_host = $relay_host;
$this->time_out = 30; //is used in fsockopen()
#
$this->auth = $auth;//auth
$this->user = $user;
$this->pass = $pass;
#
$this->host_name = "localhost"; //is used in HELO command
$this->log_file ="";

$this->sock = FALSE;
}

/* Main Function */
function sendmail($to, $from, $subject = "", $body = "", $mailtype, $cc = "", $bcc = "", $additional_headers = "")
{
$mail_from = $this->get_address($this->strip_comment($from));
$body = ereg_replace("(^|(\r\n))(\\.)", "\\1.\\3", $body);
$header .= "MIME-Version:1.0\r\n";
if($mailtype=="HTML"){
$header .= "Content-Type:text/html\r\n";
}
$header .= "To: ".$to."\r\n";
if ($cc != "") {
$header .= "Cc: ".$cc."\r\n";
}
$header .= "From: $from<".$from.">\r\n";
$header .= "Subject: ".$subject."\r\n";
$header .= $additional_headers;
$header .= "Date: ".date("r")."\r\n";
$header .= "X-Mailer:By Redhat (PHP/".phpversion().")\r\n";
list($msec, $sec) = explode(" ", microtime());
$header .= "Message-ID: <".date("YmdHis", $sec).".".($msec*1000000).".".$mail_from.">\r\n";
$TO = explode(",", $this->strip_comment($to));

if ($cc != "") {
$TO = array_merge($TO, explode(",", $this->strip_comment($cc)));
}

if ($bcc != "") {
$TO = array_merge($TO, explode(",", $this->strip_comment($bcc)));
}

$sent = TRUE;
foreach ($TO as $rcpt_to) {
$rcpt_to = $this->get_address($rcpt_to);
if (!$this->Smtp_sockopen($rcpt_to)) {
$this->log_write("Error: Cannot send email to ".$rcpt_to."\n");
$sent = FALSE;
continue;
}
if ($this->Smtp_send($this->host_name, $mail_from, $rcpt_to, $header, $body)) {
$this->log_write("E-mail has been sent to <".$rcpt_to.">\n");
} else {
$this->log_write("Error: Cannot send email to <".$rcpt_to.">\n");
$sent = FALSE;
}
fclose($this->sock);
$this->log_write("Disconnected from remote host\n");
}
echo "<br>";
//echo $header;
return $sent;
}

/* Private Functions */

function Smtp_send($helo, $from, $to, $header, $body = "")
{
if (!$this->Smtp_putcmd("HELO", $helo)) {
return $this->Smtp_error("sending HELO command");
}
#auth
if($this->auth){
if (!$this->Smtp_putcmd("AUTH LOGIN", base64_encode($this->user))) {
return $this->Smtp_error("sending HELO command");
}

if (!$this->Smtp_putcmd("", base64_encode($this->pass))) {
return $this->Smtp_error("sending HELO command");
}
}
#
if (!$this->Smtp_putcmd("MAIL", "FROM:<".$from.">")) {
return $this->Smtp_error("sending MAIL FROM command");
}

if (!$this->Smtp_putcmd("RCPT", "TO:<".$to.">")) {
return $this->Smtp_error("sending RCPT TO command");
}

if (!$this->Smtp_putcmd("DATA")) {
return $this->Smtp_error("sending DATA command");
}

if (!$this->Smtp_message($header, $body)) {
return $this->Smtp_error("sending message");
}

if (!$this->Smtp_eom()) {
return $this->Smtp_error("sending <CR><LF>.<CR><LF> [EOM]");
}

if (!$this->Smtp_putcmd("QUIT")) {
return $this->Smtp_error("sending QUIT command");
}

return TRUE;
}

function Smtp_sockopen($address)
{
if ($this->relay_host == "") {
return $this->Smtp_sockopen_mx($address);
} else {
return $this->Smtp_sockopen_relay();
}
}

function Smtp_sockopen_relay()
{
$this->log_write("Trying to ".$this->relay_host.":".$this->Smtp_port."\n");
$this->sock = @fsockopen($this->relay_host, $this->Smtp_port, $errno, $errstr, $this->time_out);
if (!($this->sock && $this->Smtp_ok())) {
$this->log_write("Error: Cannot connenct to relay host ".$this->relay_host."\n");
$this->log_write("Error: ".$errstr." (".$errno.")\n");
return FALSE;
}
$this->log_write("Connected to relay host ".$this->relay_host."\n");
return TRUE;;
}

function Smtp_sockopen_mx($address)
{
$domain = ereg_replace("^.+@([^@]+)$", "\\1", $address);
if (!@getmxrr($domain, $MXHOSTS)) {
$this->log_write("Error: Cannot resolve MX \"".$domain."\"\n");
return FALSE;
}
foreach ($MXHOSTS as $host) {
$this->log_write("Trying to ".$host.":".$this->Smtp_port."\n");
$this->sock = @fsockopen($host, $this->Smtp_port, $errno, $errstr, $this->time_out);
if (!($this->sock && $this->Smtp_ok())) {
$this->log_write("Warning: Cannot connect to mx host ".$host."\n");
$this->log_write("Error: ".$errstr." (".$errno.")\n");
continue;
}
$this->log_write("Connected to mx host ".$host."\n");
return TRUE;
}
$this->log_write("Error: Cannot connect to any mx hosts (".implode(", ", $MXHOSTS).")\n");
return FALSE;
}

function Smtp_message($header, $body)
{
fputs($this->sock, $header."\r\n".$body);
$this->Smtp_debug("> ".str_replace("\r\n", "\n"."> ", $header."\n> ".$body."\n> "));

return TRUE;
}

function Smtp_eom()
{
fputs($this->sock, "\r\n.\r\n");
$this->Smtp_debug(". [EOM]\n");

return $this->Smtp_ok();
}

function Smtp_ok()
{
$response = str_replace("\r\n", "", fgets($this->sock, 512));
$this->Smtp_debug($response."\n");

if (!ereg("^[23]", $response)) {
fputs($this->sock, "QUIT\r\n");
fgets($this->sock, 512);
$this->log_write("Error: Remote host returned \"".$response."\"\n");
return FALSE;
}
return TRUE;
}

function Smtp_putcmd($cmd, $arg = "")
{
if ($arg != "") {
if($cmd=="") $cmd = $arg;
else $cmd = $cmd." ".$arg;
}

fputs($this->sock, $cmd."\r\n");
$this->Smtp_debug("> ".$cmd."\n");

return $this->Smtp_ok();
}

function Smtp_error($string)
{
$this->log_write("Error: Error occurred while ".$string.".\n");
return FALSE;
}

function log_write($message)
{
$this->Smtp_debug($message);

if ($this->log_file == "") {
return TRUE;
}

$message = date("M d H:i:s ").get_current_user()."[".getmypid()."]: ".$message;
if (!@file_exists($this->log_file) || !($fp = @fopen($this->log_file, "a"))) {
$this->Smtp_debug("Warning: Cannot open log file \"".$this->log_file."\"\n");
return FALSE;
}
flock($fp, LOCK_EX);
fputs($fp, $message);
fclose($fp);

return TRUE;
}

function strip_comment($address)
{
$comment = "\\([^()]*\\)";
while (ereg($comment, $address)) {
$address = ereg_replace($comment, "", $address);
}

return $address;
}

function get_address($address)
{
$address = ereg_replace("([ \t\r\n])+", "", $address);
$address = ereg_replace("^.*<(.+)>.*$", "\\1", $address);

return $address;
}

function Smtp_debug($message)
{
if ($this->debug) {
echo $message."<br>";
}
}

function get_attach_type($image_tag) { //

$filedata = array();

$img_file_con=fopen($image_tag,"r");
unset($image_data);
while ($tem_buffer=AddSlashes(fread($img_file_con,filesize($image_tag))))
$image_data.=$tem_buffer;
fclose($img_file_con);

$filedata['context'] = $image_data;
$filedata['filename']= basename($image_tag);
$extension=substr($image_tag,strrpos($image_tag,"."),strlen($image_tag)-strrpos($image_tag,"."));
switch($extension){
case ".gif":
$filedata['type'] = "image/gif";
break;
case ".gz":
$filedata['type'] = "application/x-gzip";
break;
case ".htm":
$filedata['type'] = "text/html";
break;
case ".html":
$filedata['type'] = "text/html";
break;
case ".jpg":
$filedata['type'] = "image/jpeg";
break;
case ".tar":
$filedata['type'] = "application/x-tar";
break;
case ".txt":
$filedata['type'] = "text/plain";
break;
case ".zip":
$filedata['type'] = "application/zip";
break;
default:
$filedata['type'] = "application/octet-stream";
break;
}


return $filedata;
}

}
?>
