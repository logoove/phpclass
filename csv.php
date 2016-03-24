<?php
header("Content-Type:text/html;charset=UTF-8");
class Csv{
  public $csv_array; //csv数组数据
  public $csv_str; //csv文件数据
  public function __construct($param_arr, $column){
    $this->csv_array = $param_arr;
    $this->path = $path;
    $this->column = $column;
  }
  /**
   * 导出
   * */
  public function export(){
    if(empty($this->csv_array) || empty($this->column)){
      return false;
    }
    $param_arr = $this->csv_array;
    unset($this->csv_array);
    $export_str = implode(',',$param_arr['nav'])."n";
    unset($param_arr['nav']);
    //组装数据
    foreach($param_arr as $k=>$v){
      foreach($v as $k1=>$v1){
        $export_str .= implode(',',$v1)."n";
      }
    }
    //将$export_str导出
    header( "Cache-Control: public" );
    header( "Pragma: public" );
   header("Content-type: text/csv");
    header("Content-Disposition:attachment;filename=txxx.csv");
    header('Content-Type:APPLICATION/OCTET-STREAM');
    ob_start();   
  $export_str= mb_convert_encoding($export_str, "gb2312",'auto');
    ob_end_clean();
    echo $export_str;
  }
  /**
   * 导入
   * */
  public function import($path,$column = 3){
    $flag = flase;
    $code = 0;
    $msg = '未处理';
    $filesize = 10; //1MB
    $maxsize = $filesize * 1024 * 1024;
    $max_column = 1000;
 
    //检测文件是否存在
    if($flag === flase){
      if(!file_exists($path)){
        $msg = '文件不存在';
        $flag = true;
      }
    }
    //检测文件格式
    if($flag === flase){
      $ext = preg_replace("/.*.([^.]+)/","$1",$path);
      if($ext != 'csv'){
        $msg = '只能导入CSV格式文件';
        $flag = true;
      }
    }
    //检测文件大小
    if($flag === flase){
      if(filesize($path)>$maxsize){
        $msg = '导入的文件不得超过'.$maxsize.'B文件';
        $flag = true;
      }
    }
    //读取文件
    if($flag == flase){
      $row = 0;
      $handle = fopen($path,'r');
      $dataArray = array();
      while($data = fgetcsv($handle,$max_column,",")){
        $num = count($data);
        if($num < $column){
          $msg = '文件不符合规格真实有：'.$num.'列数据';
          $flag = true;
          break;
        }
        if($flag === flase){
          for($i=0;$i<3;$i++){
            if($row == 0){
              break;
            }
            //组建数据
            $dataArray[$row][$i] = $data[$i];
          }
        }
        $row++;
      }
    }
    return $dataArray;
  }
}



$param_arr = array(
'nav'=>array('用户名','密码','邮箱'),
array(0=>array('xiaohai1','123456','xiaohai1@zhongsou.com'),
   1=>array('xiaohai2','213456','xiaohai2@zhongsou.com'),
   2=>array('xiaohai3','123456','xiaohai3@zhongsou.com')
));
$column = 3;
$csv = new Csv($param_arr, $column);
$csv->export();
//$path = 'txxx.csv';
//$import_arr = $csv->import($path,3);
//var_dump($import_arr);
