<?php
class PdoResult{
	private $stmt;
	public function __construct($stmt){
		$this->stmt=& $stmt;
	}
	public function fetch(){
		return $this->stmt->fetch();
    }
	public function fetchall(){
		return $this->stmt->fetchAll();
	}
	public function size(){
		return $this->stmt->rowCount();
	}
}
class db{
  private $host = "";
  private $dbName = "";
  private $user = "";
  private $pass = "";
  
  private $dbh;
  private $error;
  private $qError;
  private $query_sql;	
  
  private $stmt;
  private $echo_error;
  
  public function __construct($dbHost,$dbUser,$dbPass,$dbName){
	global $lo_url_temp;

	$this->host=$dbHost;
	$this->user=$dbUser;
	$this->pass=$dbPass;
	$this->dbName=$dbName;
    $this->echo_error=1;
      //dsn for mysql
    $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
    $options = array(
        PDO::ATTR_PERSISTENT    => false,
        PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
    
    try{
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		$this->dbh->query("SET NAMES 'utf8'");
    }
    //catch any errors
    catch (PDOException $e){
        $this->error = $e->getMessage();
    }
	 
    
  }
  function set_error($error=1){
		$this->echo_error=$error;
	}
 public function query_all($query,$bind_val_arr=array()){
    $this->query_sql=$query;
    $this->stmt = $this->dbh->prepare($query);
	$param_array=array();
	$value_array=array();
	$a=0;
	foreach($bind_val_arr as $index=>$value){
		$param_array[$a]=":".$index;
		$temp=(String)$index;
		if($bind_val_arr[$temp]==''&&$bind_val_arr[$temp]!=0){
			$bind_val_arr[$temp]="''";
		}
		$value_array[$a]=$bind_val_arr[$temp];
		$this->query_sql=str_replace(":".$index,"'".$bind_val_arr[$temp]."'",$this->query_sql);
		
		$a++;
	}
	return $this->bind_all($param_array,$value_array);
  }
  public function query($query){
      $this->stmt = $this->dbh->prepare($query);
  }
  public function bind_all($param_array,$value_array){
	 
	  for($i=0;$i<count($param_array);$i++){
		
		$this->bind($param_array[$i],$value_array[$i]);
	  }
	 return $this->execute();
  }
  public function bind($param, $value, $type = null){
      if(is_null($type)){
          switch (true){
              case is_int($value):
                $type = PDO::PARAM_INT;
                break;
              case is_bool($value):
                  $type = PDO::PARAM_BOOL;
                  break;
              case is_null($value):
                  $type = PDO::PARAM_NULL;
                  break;
              default:
                  $type = PDO::PARAM_STR;
          }
      }
	  if($param==":mb_no"){
		$type = PDO::PARAM_STR;
	  }
    $this->stmt->bindValue($param, $value, $type);
  }
  
 public function execute(){
	try{
		$this->stmt->execute();
		$dataResult=new PdoResult($this->stmt);
		return $dataResult;
	}catch(PDOException $e) {
		$URL='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$log_str=date("Y-m-d H:i:s")." ".$this->query_sql."||".$URL."||".$e->getMessage();
		if($this->echo_error==1){
			echo $log_str."<br>\n";
		}
		return "error";
	}	
  }
public function dbInsert($table,$arFieldValues){
	$fields=array_keys($arFieldValues);
	$values=array_values($arFieldValues);
	$sql_str="INSERT INTO ".$table."(";
	$sql_str.=join(",",$fields);
	$sql_str.=")VALUES(";
	for($i=0;$i<count($fields);$i++){
		if($i!=0)$sql_str.=",";
		$sql_str.=":".$fields[$i];
	}
	$sql_str.=")";
	return $this->query_all($sql_str,$arFieldValues);
}
public function dbInsert_datas($table,$insert_datas){
	$report_str='';
	$report_count=0;
	$insert_title="-1";
	for($i=0;$i<count($insert_datas);$i++){
		$insert_data=$insert_datas[$i];
		if($report_count>0){
			$report_str.=",";
		}
		if($insert_title=="-1"){
			$insert_title="";
			foreach($insert_data as $index => $val){
				if($insert_title!="")$insert_title.=",";
				$insert_title.=$index;
			}
		
		}
		$report_str2="";
		foreach($insert_data as $index => $val){
			if($report_str2!="")$report_str2.=",";
			$report_str2.="'".$val."'";
		}
		$report_str.="(".$report_str2.")";
		$report_count++;
		if($report_count>=3000){
			$rp_query = "insert into ".$table."(".$insert_title.")";
			$rp_query.= " values ".$report_str;
			$this->query_all($rp_query);
			$report_str='';
			$report_count=0;
		}
	}
	if($report_count>0){
		$rp_query = "insert into ".$table."(".$insert_title.")";
		$rp_query.= " values ".$report_str;
		$this->query_all($rp_query);
		$report_str='';
		$report_count=0;
	}
}
public function dbUpdate($table,$arFieldValues,$sWhere=NULL,$bind=array()){
	$fields=array_keys($arFieldValues);
	$values=array_values($arFieldValues);
	$arSet=array();
	foreach($arFieldValues as $field=>$val){
		$arSet[]=$field."=:".$field;
	}
	$sSet=implode(",",$arSet);
	$sql_str="UPDATE ".$table." SET ".$sSet;
	if(strlen(trim($sWhere))>0){
		$sql_str.=" WHERE ".$sWhere;
	}
	if(count($bind)==0){
		$bind=$arFieldValues;
	}
	//echo $sql_str."<br>";
	return $this->query_all($sql_str,$bind);
} 
 
  public function fetch(){
      return $this->stmt->fetch();
  }
   public function fetchAll(){
      return $this->stmt->fetchAll();
  }
  
  public function size(){
      return $this->stmt->rowCount();
  }
  
  public function lastInsertId(){
      return $this->dbh->lastInsertId();
  }
  
  public function beginTransaction(){
      return $this->dbh->beginTransaction();
  }
  
  public function endTransaction(){
      return $this->dbh->commit();
  }
  
  public function cancelTransaction(){
      return $this->dbh->rollBack();
  }
  
  public function debugDumpParams(){
      return $this->stmt->debugDumpParams();
  }
  
  public function queryError(){
      $this->qError = $this->dbh->errorInfo();
  }
  
}//end class db
?>
