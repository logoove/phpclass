# php-pdo
一个php数据库处理类,以及常见php自定义函数


定义函数
<pre>
dump();//测试函数'
timeline($time);//时间戳
timeline1($time); ;另一个
timered($time) 24小时内红色
str2arr('1,2,3',',') 字符串转换数组
arr2str($arr, $glue = ',') 数组转换字符串
arr2xml($arr) 数组转换xml
arr2obj($arr) 数组转换对象多层
obj2arr($obj) 对象转换数组多层
file_ext($file) 文件扩展名 file_delete($file) 删除文件或文件夹
file_list($temp) 返回文件夹里面文件数组
file_size($filesize) 文件大小格式化显示
strcut("我是中国人abcde",6) 字符串截取 中英文都是1个长度
strrandom($l=6) 随即字符串最长32
strrandom1(6,0); 0大小写 1数字 2大写 3小写 4中文
str_authcode("www.baixiaoyong.info","ENCODE");//默认解密
encode加密
randcolor() 随即颜色值
addhttp($url) 自动为网站添加http://
str_addstr("1,a,\d"); 自动添加反斜杠 入库 str_delstr('\')
去除反斜杠
htmlencode($var) 转换成实体
htmldecode($var) 还原实体
strtrim($var) 去除多个空格 str_orderby($list, $field, $sortby =
'asc'); 结果集,字段 asc正向排序 desc逆向排序 nat自然排序
strfind($string, $find) 查找字符串是否存在
cachedata('qq');获取缓存 cachedata('qq',null);删除缓存
cachedata('qq',$str,100);设置过期时间秒
utf8_unicode("我们") 转换成Unicode
unicode_utf8("\u6211\u4eec") 反转
get_ip();//获得ip getip()
get_avatar('logove@qq.com');//头像
get_rmb($num) 转换成大写格式
get_uri() 完整url
get_memory() 内存
table_arr($table) 表格转换数组
sendsms($phone,$content,$time='') 发送短信
is_weixin() 是否微信
tiangan($year) 天干地支
shengxiao($year) 生效
xingzuo($month, $day) 星座
xingqi($y) 转换成星期 默认是当天
$data = list_tree($list);数据集转换成树
echo "
"; menu_tree($data);//输出树echo "
"; tree_list($tree)
;数转换成数据集
</pre>
##数据库 
<pre>  
表名 tablename('')
插入 pdo_insert('',$arr);
插入id $id = pdo_insertid();
修改 pdo_update('',$arr,array('id'=>$id));
更新一条数据 成功返回行数 或0 失败返回false
删除 pdo_delete('',array('id'=>$id));
删除一条数据 false失败 成功行数
查询 $row = pdo_fetch("SELECT * FROM
".tablename('')." WHERE id = :id", array(':id'
=> $id));
$list = pdo_fetchall("SELECT * FROM
".tablename('')." where 1=1");
$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '
. tablename('')." where " ); 首行首列
没查询到返回false
pdo_query("UPDATE ".tablename('')." SET num =
num+1 WHERE id=".$id); 用于无返回值sql 失败返回false`
</pre>
