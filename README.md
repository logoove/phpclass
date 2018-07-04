# PHP类和工具收集


### 2018.5.20起本项目更改更新方式,现在开发使用composer更好,方便库的加载,composer使用方法参见日志(https://www.yoby123.cn/index.php/archives/28.html),.
### composer更新地址 (https://github.com/logoove/composer)
### 更新日志
- 2018.5.19 新增smarty精简类,单文件20kb,功能强大
- 2018.5.18 新增百度翻译类baidu,百度定位省市县接口getaddress,升级pdo类到微擎最新1.7
- 2018.4.1 新增crypt


### 详细介绍
=============================
- smarty 模板类,这是精简版本,功能可没有精简
- adminer 这是一个数据库管理工具,单文件,非常好用支持mysql,sqlite,在没有安装phpmyadmin情况下最好的选择;使用后要删除;
- crxml 用于生成xml格式数据,支持生成rss
- geohash 解决计算附近距离,搜索附近的商业点,两个经纬度距离,地理位置应用处理
- phpexcel 支持excel的导入导出处理,非常强大,是目前处理excel文件必不可少库,支持xls,xlsx,csv

- phpqrcode 支持二维码生成,在二维码应用中很常见
- phpQuery 支持抓取网站,进行爬虫,非常强大
- phpword 支持word文件的处理

- pinyin 支持汉字转换拼音
- qnsdk 七牛云存储的sdk
- qreader 支持二维码的读取,目前唯一php写成的读取类
- smtp 发邮,在邮件处理很常用
- zip 压缩成zip和zip管理类
- ftp 异常强大的单文件ftp管理工具,删除文件非常快
- crypt js和php同一函数加密解密,支持密钥
- upload 目前处理php上传最强大,支持图片,文件以及base64编码图片
- pdo 一个提取自微擎中的pdo方式处理数据库的工具类
- markdown类 转换markdown为html

~~~
表名 
tablename('mc_members')
查询一条数据
pdo_get('yoby_demo',['id'=>1]);
pdo_get('yoby_demo',['id'=>1],['title','num']);返回特定字段
pdo_get('yoby_demo',[],['count(*) as z','title','num','max(num)']);
pdo_fetch("SELECT username, uid FROM ".tablename('users')." WHERE uid = :uid LIMIT 1", array(':uid' => 1));
查询单字段
pdo_getcolumn('yoby_demo',['id'=>1],'title');
pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('users'));
查询多条记录
表名,条件,返回字段,主键,排序,限制条数
pdo_getall('yoby_demo',[],[],'','id desc','LIMIT '.($pindex-1)* $psize.','.$psize); 
pdo_fetchall("SELECT username, uid FROM ".tablename('users'), []);
插入数据,第二个参数数组
pdo_insert('yoby_demo',[]);
$id = pdo_insertid();插入id
修改
pdo_update('yoby_demo',['num +='=>1],['id'=>1]);
删除
pdo_delete('yoby_demo',['id'=>1]);
执行sql
pdo_query("DELETE FROM ".tablename('users')." WHERE uid = :uid", array(':uid' => 2));
支持多条sql用分号隔开
pdo_run($sql);
显示调试语句
pdo_debug();
检测某个字段是否存在
pdo_fieldexists('shopping_goods', 'credit');
检测某个表是否存在
pdo_tableexists($tablename)
~~~
- baidu 百度翻译类
- getaddress 自动定位获取省市县
