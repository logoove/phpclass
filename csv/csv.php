<?php
class csv{
  public $csv_array; //csv数组数据
  public $csv_str; //csv文件数据
  public function __construct($param_arr=array(),$filename=''){
    $this->csv_array = $param_arr;
   // $this->path = $path;
    $this->column = (empty($param_arr[0]))?0:$param_arr[0];
    $this->filename =(empty($filename))?date('YmdHis',time()):$filename;
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
    $export_str = implode(',',$param_arr['nav'])."\n";
    unset($param_arr['nav']);
    //组装数据
    foreach($param_arr as $k=>$v){
      foreach($v as $k1=>$v1){
        $export_str .= implode(',',$v1)."\n";
      }
    }
    //将$export_str导出
    header( "Cache-Control: public" );
    header( "Pragma: public" );
   header("Content-type: text/csv");
    header("Content-Disposition:attachment;filename=".$this->filename.".csv");
    header('Content-Type:APPLICATION/OCTET-STREAM');
    ob_start();   
  $export_str= mb_convert_encoding($export_str, "gb2312",'auto');
    ob_end_clean();
    echo $export_str;
  }
  public function input_csv($handle) { 
    $out = array (); 
    $n = 0; 
    while ($data = fgetcsv($handle, 10000)) { 
        $num = count($data); 
        for ($i = 0; $i < $num; $i++) { 
            $out[$n][$i] = $data[$i]; 
        } 
        $n++; 
    } 
    return $out; 
}
public function dump($arr){
	echo '<pre>'.print_r($arr,TRUE).'</pre>';
} 
  /**
   * 导入
   * */
  public function import($path){
 
    $handle = fopen($path, 'r'); 
    $result = $this->input_csv($handle); //解析csv 
    $len_result = count($result); 
    if($len_result==0){ 
        return  array(0=>"没有数据");
    }
   // $this->dump($result);

    fclose($handle); 
 return $result;
    
  }
  
  /*
内部方法
show 数组转换xml格式或json格式或数组输出
$code 状态码
$message 返回信息
$data 数组
$type 类型默认json 支持xml  array参数
*/
public function _arr2json($code,$message='',$data = array()){
		if(!is_numeric($code)){
			return '';
		}
		$arr  =array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		echo json_encode($arr);
		exit;
	} 
	public function _xml2encode($data){
		$d = '';
		$attr = '';
		foreach($data  as $k=>$v){
			if(is_numeric($k)){
				
				$attr = "id='{$k}'";
				$k ="item";
			}
			$d  .= "<{$k} {$attr}>";
			$d .=is_array($v)?self::_xml2encode($v) : $v;
			$d .="</{$k}>";
		}
		
		return $d;
	}
public function _arr2xml($code,$message='',$data = array()){
		if(!is_numeric($code)){
			return '';
		}
		$arr  =array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		
		header("Content-Type:text/xml");
		$xml="";
		
		$xml .= '<?xml   version="1.0"   encoding="utf-8"?>';
		$xml  .='<root>';
		$xml .="<code>{$code}</code>";
		$xml .="<message>{$message}</message>";
		$xml .="<data>";
		$xml  .=$this->_xml2encode($data);
		$xml .="</data>";
		$xml .='</root>';
		
		echo $xml;
	}
	
	public function show($code,$message='',$data = array(),$type='json'){
				if(!is_numeric($code)){
			return '';
		}
				$arr  =array(
			'code'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		$type = isset($_GET['format'])?$_GET['format']:$type;
		if('json' == $type){
			$this->_arr2json($code,$message,$data);
			exit;
		}elseif('xml' ==$type){
			$this->_arr2xml($code,$message,$data);
			exit;
		}elseif('array' ==$type){
			$this->dump($data);
		}
		
	}
}