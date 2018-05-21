# 教程
~~~
模板标签/语法

在模板中，用"{"开头，以"}"结尾就构成一个标签单元，"{"紧接着的单词就是标签名。在标签单元中单词前含"$"(美元符)的为变量名。

一、资源引用
    res标签
功能：返回当前模板当前风格目录的url路径
实例：{res file=css/css.css}这个标签在模板编译后将变成http://商城域名/themes/default/styles/default，注意末尾没有"/"，返回结果会随后台设置的主题变化

    lib标签
功能：返回javascript库的url路径
实例：{lib file=js.js}这个标签在模板编译后将变成http://商城域名/includes/libraries/javascript，注意末尾没有"/"，返回结果不会随后台设置的主题变化

    url标签
功能：url解析器，可根据后台伪静态状态返回相应url等。
说明：如果一个链接的目标页面需要伪静态功能，请使用该url标签，只有当后台开启伪静态并在.htaccess文件为目标页面设置了伪静态规则时url标签才能解析为静态url地址。
实例：{url app=goods&id=$goods_id}解析后如果伪静态成功则返回"goods/19"

    include标签
功能：Include 标签用于在当前模板中包含其它模板. 当前模板中的变量在被包含的模板中可用. 必须指定 file 属性，该属性指明模板资源的位置.实例：模板代码:
{include file="header.html"}
{* body of template goes here *}
{include file="footer.html"}

二、模板变量
    1.模板保留变量
模板预置的一些系统变量，包括
    $smarty.now  当前时刻对应的格林尼治时间戳，可以用{$smarty.now|date}显示当前日期时间，关于date变量调节器请看下文讲解。
    $smarty.get  $smarty.post $smarty.cookie $smarty.env $smarty.server $smarty.request $smarty.session同php的$_GET、$_POST、$_COOKIE、$_ENV、$_SEVER、$_REQUEST、$_SESSION变量。非程序人员如果需要了解请参考php相关手册了解

    2.自定义变量
从php赋值变量：
例如在调用该模板的app程序文件中进行赋值复制内容到剪贴板代码:
//在app/default.app.php文件的index方法中$this->display前添加赋值语句
$this->assign('name', 'Tom'); //普通变量
$this->assign('user', array(
    'name' => 'Tom',
    'age'    => '28'
)); //数组变量
$this->display('index.html');在themes/mall/default/index.html中显示变量模板代码:
Hello,{$name},your age are {$user.age}！

在模板中赋值变量：
    assign标签
    例在themes/mall/default/index.html中赋值变量
模板代码:
{assign var="name" value="Tom"}
Hello,{$firstname}！

  

    4.变量调节器
    escape
功能：提供各种编码功能
参数：可选参数html、url、quotes、input、editor，缺省为html
    html：分别替换变量中的如下字符&<>"为其html实体代码，用于按原样输出html源代码；
    url：如果该变量用于储存url地址，需要进行url编码；
    quotes：在单双引号字符前添加反斜杠；
    input：给输入框赋值时使用；
    editor：当显示通过文本编辑器录入的内容，需要用此参数；
实例
php赋值复制内容到剪贴板代码:
$this->assign('goods_name', "L'oreal/欧莱雅"  .  '"'   . "清润全日保湿乳霜"  .  '"'   . "50ml<br /><script>");
$this->display('index.tpl');模板
模板代码:
{$goods_name}
{$goods_name|escape}
{$goods_name|escape:"html"}
{$goods_name|escape:"url"}
{$goods_name|escape:"quotes"}
{$goods_name|escape:"input"}
{$goods_name|escape:"editor"}
输出结果为
L'oreal/欧莱雅"清润全日保湿乳霜"50ml<br /><script>
L'oreal/欧莱雅"清润全日保湿乳霜"50ml<br /><script>
L'oreal/欧莱雅"清润全日保湿乳霜"50ml<br /><script>
L%27oreal%2F%E6%AC%A7%E8%8E%B1%E9%9B%85%22%E6%B8%85%E6%B6%A6%E5%85%A8%E6%97%A5%E4%BF%9D%E6%B9%BF%E4%B9%B3%E9%9C%9C%2250ml%3Cbr+%2F%3E%3Cscript%3E
L\'oreal/欧莱雅\"清润全日保湿乳霜\"50ml<br /><script>
L'oreal/欧莱雅\"清润全日保湿乳霜\"50ml<br /><script>
L'oreal/欧莱雅"清润全日保湿乳霜"50ml<br /><script>

    nl2br
功能：将换行符替换成<br />
例子
模板代码:
{$var|nl2br}

    default
功能：为变量设置一个默认值，当变量为空或者未分配的时候，将由默认值替代输出
例子
模板代码:
{$var|default:"no title"}

    truncate
功能：字符串截取。从字符串开始处截取某长度的字符。默认会在末尾追加省略号。
例子：
模板代码:
{$content|truncate:20}

    strip_tags
功能：去除<和>标签,包括在<和>之间的任何内容。
例子：
模板代码:
{assign var="content" value="<b>文章内容</b>"}
{$content|strip_tags}输出结果为：文章内容

    price
功能：格式化价格。
例子：
模板代码:
{assign var="goods_price" value="123456"}
{$goods_price|price}输出结果为：¥123,456.00

    date
功能：格式化本地时间和日期。
格式：{$var|date:format}
说明：变量$var必须是格林尼治标准时间，php中gmtime()和模板中$smarty.now得到的都是格林尼治标准时间
参数format可为simple、complete或自定义日期格式，缺省为simple。
simple和complete均可由后台设置，自定义日期格式请参考http://docs.php.net/manual/zh/function.date.php
常用：Y-m-d H:i:s
例子：
模板代码:
{$smarty.now|date}
{$smarty.now|date:complete}
{$smarty.now|date:Y-m-d H:i}
输出结果为：
2010-12-01
2010-12-01 22:49:46
2010-12-01 22:49

    modifier
功能：调用php自定义函数。
格式：{$var|modifier:user_func}

三、流程控制标签
    1.条件判断（if，elseif，else）
说明
    模板中的 if 语句和 php 中的 if 语句一样灵活易用，并增加了几个特性以适宜模板引擎. if 必须于 /if 成对出现. 可以使用 else 和 elseif 子句. 可以使用以下条件修饰词：eq、ne/neq、gt、lt、lte/le、gte/ge、mod、not、==、!=、>、<、<=、>=、%、!使用这些修饰词时必须和变量或常量用空格格开.
    多个条件之间用 and、or、&&、|| 连接，实现简单的逻辑运算
实例
模板代码:
{if $name eq "Fred"}
        Welcome Sir.
{elseif $name eq "Wilma"}
        Welcome Ma'am.
{else}
        Welcome, whatever you are.
{/if}

{* 一个"或"逻辑的例子 *}
{if $name eq "Fred" or $name eq "Wilma"}
        ...
{/if}

{* 与上例等效 *}
{if $name == "Fred" || $name == "Wilma"}
        ...
{/if}

{* 下面的语法无效，条件修饰符必须由空格跟其他元素分开 *}
{if $name=="Fred" || $name=="Wilma"}
        ...
{/if}

{* 允许使用括号 *}
{if ( $amount < 0 or $amount > 1000 ) and $volume >= #minVolAmt#}
        ...
{/if}

    2.数组遍历（foreach，foreachelse）
说明：
    foreach 用于处理简单数组(数组中的元素的类型一致)。
    foreach 必须和 /foreach 成对使用，且必须指定 from 和 item 属性。
    foreach 可以嵌套，但必须保证嵌套中的 foreach 名称唯一。    
    foreachelse 语句在 from 变量没有值的时候被执行。

    from 属性：指定被循环的数组，数组长度决定了循环的次数。
    item属性：单个循环项目的变量名，在循环内部使用。
name 属性为可选属性，可以任意指定(字母、数字和下划线的组合)。
key：单个循环的Key值。（这行是ZC加的说明）

    name 属性如果指定，foreach循环体内会自动生成如下变量
    $smarty.foreach.foreach_name.index表示本次循环索引，从0开始递增的整数
    $smarty.foreach.foreach_name.iteration表示本次的循环次数，从1开始递增的整数
    $smarty.foreach.foreach_name.first表示是否是第一次循环
    $smarty.foreach.foreach_name.last表示是否是最后一次循环
    $smarty.foreach.foreach_name.show表示是否有数据
    $smarty.foreach.foreach_name.total表示循环总次数，也可在循环体外使用

实例1
模板代码:
{* 该例将输出数组 $custid 中的所有元素的值 *}
{foreach from=$custid item=curr_id}
        id: {$curr_id}<br>
{/foreach} 
输出结果为:
id: 1000<br>
id: 1001<br>
id: 1002<br>

实例2
复制内容到剪贴板代码:
/* 在对应的控制器中赋值 */
$this->assign("contacts", array(
    array("phone" => "1", "fax" => "2", "cell" => "3"),
    array("phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234")
));模板代码:
{* 键就是数组的下标，请参看关于数组的解释 *}
{foreach name=outer item=contact from=$contacts}
{foreach key=key item=item from=$contact}
{$key}: {$item}<br>
{/foreach}
{/foreach}
输出结果为:
phone: 1<br>
fax: 2<br>
cell: 3<br>
phone: 555-4444<br>
fax: 555-3333<br>
cell: 760-1234<br>

模板代码:
{* 最后一行不显示<br>标签 *}
{foreach name=outer item=contact from=$contacts name=my_name}
{foreach key=key item=item from=$contact}
{$key}: {$item}{if !smarty.foreach.my_name.last}<br>{/if}
{/foreach}
{/foreach}
输出结果为:
phone: 1<br>
fax: 2<br>
cell: 3<br>
phone: 555-4444<br>
fax: 555-3333<br>
cell: 760-1234

四、显示标签
    cycle
格式：{cycle values="val1,val2,val3..."}
说明：cycle 用于轮转使用一组值。该特性使得在表格中交替输出颜色或轮转使用数组中的值变得很容易。
实例
模板代码:
{foreach from=$data_list item=data}
<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
<td>{$data}</td>
</tr>
{/foreach}
输出结果为：
<tr bgcolor="#eeeeee">
<td>1</td>
</tr>
<tr bgcolor="#d0d0d0">
<td>2</td>
</tr>
<tr bgcolor="#eeeeee">
<td>3</td>
</tr>

    html_options
说明：自定义函数 html_options 根据给定的数据创建选项组. 该函数可以指定哪些元素被选定. 要么必须指定 values 和 ouput 属性，要么指定 options 替代。
实例1
复制内容到剪贴板代码:
$this->assign('cust_ids', array(1000,1001,1002,1003));
$this->assign('cust_names', array('Joe Schmoe','Jack Smith','Jane Johnson','Carlie Brown'));
$this->assign('customer_id', 1001);
模板代码:
<select>
        {html_options values=$cust_ids selected=$customer_id output=$cust_names}
</select>

实例2
复制内容到剪贴板代码:
$this->assign('cust_options', array(
    1001 => 'Joe Schmoe',
    1002 => 'Jack Smith',
    1003 => 'Jane Johnson',
    1004 => 'Charlie Brown'));
$this->assign('customer_id', 1001);模板代码:
<select>
        {html_options options=$cust_options selected=$customer_id}
</select>

实例1和实例2输出结果均为：
<select>
        <option value="1000">Joe Schmoe</option>
        <option value="1001" selected>Jack Smith</option>
        <option value="1002">Jane Johnson</option>
        <option value="1003">Carlie Brown</option>
</select>

    html_radios
说明：自定义函数 html_radios 根据给定的数据创建选项组. 该函数可以指定哪些元素被选定. 要么必须指定 values 和 ouput 属性，要么指定 options 替代。与html_options不同的是html_radios有一个checked属性

    html_checkbox
说明：自定义函数 html_checkboxes 根据给定的数据创建复选按钮组。该函数可以指定哪些元素被选定。 要么必须指定 values 和 ouput 属性，要么指定 options 替代.。与html_options不同的是html_checkbox有一个checked属性。
~~~