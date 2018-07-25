<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/25
 * Time: 8:28
 */
/**
 * 获得分类树
 * @param int $pid  父id
 * @param array $result返回树结构
 * @param int $spac
 * @return array
 */
require_once "pdo.php";
function gettree($pid=0,&$result=array(),$spac=0){
    $spac = $spac+2;
    $row = pdo_getall('item',array('pid'=>$pid));
    foreach($row as $v){
        if($v['pid']==0){
            $v['title'] = $v['title'];
        } else{
            $v['title'] = str_repeat('&nbsp;&nbsp;',$spac)."|--".$v['title'];
        }


        $result[] = $v;
        gettree($v['id'],$result,$spac);
    }
    return $result;
}
/*
 * 父类id  选中的id
 * */
function puttree($pid=0,$selected=0){
    $rs = gettree($pid);
    $str='';
    $str .= "<select name='pid'>";
    $str .= '<option value="0">顶级分类</option>';
    foreach($rs as $key=>$val){

        if($val['id'] == $selected){
            $selectedstr = "selected";
        }else{
            $selectedstr = "";
        }
        $str .= "<option $selectedstr value='".$val['id']."'>".$val['title']."</option>";
    }
    $str .= "</select>";
    return $str;
}
//面包屑路径  ,$cid为分类id  ,直到返回顶级
function getmenu($cid,&$result=array()){
    //引用数据库连接资源
$row = pdo_get('item',array('id'=>$cid));
    if($row){
        $result[] = $row;
        getmenu($row['pid'],$result);
    }
    //数组顺序倒序
    krsort($result);

    return $result;

}
//输出从当前分类到顶级分类路径
function putmenu($cid,$url="demo.php?cid="){

    $res = getmenu($cid);

    $str = "";
    foreach($res as $key=>$val){
        $str .= "<a href='{$url}{$val['id']}'>{$val['title']}</a>>";
    }

    return $str;

}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>演示无限级分类</title>
    <style>
        .table {
            width: 100%;
            background: #f8f9fa;
            margin: 10px auto;
            border-collapse: collapse;
        }
        .table th,
        .table td {
            border: 1px solid #f0f1f4;
            padding: 8px;
        }
        .table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        .table tr {
            background: #FFF;
        }
        .table tr:hover {
            background: #f8f9fa;
        }
        .table td a {
            color: #18B4ED;
            text-decoration: none;
        }
        .table td a:hover {
            color: #18B4ED;
            text-decoration: underline;
        }
    </style>
</head>
<body>
 <?php   //默认设置顶级分类开始,1选中
 echo  puttree(0,1) ;
 echo putmenu(8) ;?>
<table class="table">
    <tr><th>ID</th><th>上级ID</th><th>分类名称</th></tr>
    <tbody>
    <?php
    foreach(gettree() as $k=>$v){
        echo "<tr ><td>".$v['id']."</td><td>".$v['pid']."</td><td align='left'>".$v['title']."</td></tr>";
    }
    ?>

    </tbody>
</table>
</body>
</html>
