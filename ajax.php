<?php	
header('Access-Control-Allow-Origin:*');  
header('Access-Control-Allow-Methods:POST, GET');  
header('Access-Control-Allow-Headers:x-requested-with,content-type'); 
error_reporting(E_ALL^E_NOTICE);
session_start();	
require_once "./dbclass.php";	
$conf=parse_ini_file("./conf.ini",true);
$db=new db($conf['db']['dbHost'],$conf['db']['dbUser'],$conf['db']['dbPass'],$conf['db']['dbName']);


if(isset($_POST['get_park_data'])){//取得停車場資料
	$db->query_all("delete from park where system_insert=1");
	$url='https://datacenter.taichung.gov.tw/swagger/OpenData/e2263556-5e34-403e-9ede-3fcb983c135f';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$csvData = curl_exec($ch);
	curl_close($ch);
	$lines = explode(PHP_EOL, $csvData);
	$insert_datas=array();
	$i=0;
	foreach ($lines as $line) {
		if($i!=0){
			$array = array();
			$array = str_getcsv($line);
			for($ii=0;$ii<count($array);$ii++){
				$array[$ii]=str_replace("'","",$array[$ii]);
			}
			$insert_data=array();
			$insert_data['ID']=$array[0];
			$insert_data['area_id']=$array[1];
			$insert_data['road_id']=$array[2];
			$insert_data['rdname']=$array[3];
			$insert_data['se_road']=$array[4];
			$insert_data['ceiiId']=$array[5];
			$insert_data['day']=$array[6];
			$insert_data['hour']=$array[7];
			$insert_data['pay']=$array[8];
			$insert_data['paycash']=$array[9];
			$insert_data['cellsum']=$array[10];
			$insert_data['bdate']=$array[11];
			$insert_data['memo']=$array[12];
			$insert_data['X']=$array[13];
			$insert_data['Y']=$array[14];
			$insert_data['parkingT']=$array[15];
			$insert_data['TWD97_X']=$array[16];
			$insert_data['TWD97_Y']=$array[17];
			$insert_data['system_insert']=1;
			$insert_data['update_date']=date("Y-m-d H:i:s");
			$insert_datas[]=$insert_data;
		}
		$i++;
	}
	$db->dbInsert_datas("park",$insert_datas);
	$rtn_data=array();
	$rtn_data['rtn_code']=1;
	$rtn_data['rtn_msg']="資料轉入成功";
	echo json_encode($rtn_data);
	exit();
}
if(isset($_POST['get_restaurant_data'])){//取得餐廳資料
	$db->query_all("delete from restaurant where system_insert=1");
	$url='https://datacenter.taichung.gov.tw/swagger/OpenData/3e587629-3792-49f9-94c6-bb672773b146';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$csvData = curl_exec($ch);
	curl_close($ch);
	$lines = explode(PHP_EOL, $csvData);
	$insert_datas=array();
	$i=0;
	foreach ($lines as $line) {
		if($i!=0){
			$array = array();
			$array = str_getcsv($line);
			for($ii=0;$ii<count($array);$ii++){
				$array[$ii]=str_replace("'","",$array[$ii]);
			}
			$insert_data=array();
			$insert_data['sn']=$array[0];
			$insert_data['name']=$array[1];
			$insert_data['tel']=$array[2];
			$insert_data['address']=$array[3];
			$insert_data['system_insert']=1;
			$insert_data['update_date']=date("Y-m-d H:i:s");
			$insert_datas[]=$insert_data;
		}
		$i++;
	}
	$db->dbInsert_datas("restaurant",$insert_datas);
	$res=$db->query_all("select * from restaurant where 1 ");
	while($data=$res->fetch()){
		get_google_place($data['sn'],$data['name'], $data['address']);
	}
	$rtn_data=array();
	$rtn_data['rtn_code']=1;
	$rtn_data['rtn_msg']="資料轉入成功";
	echo json_encode($rtn_data);
	exit();
}

if(isset($_POST['get_restaurant_data_from_db'])){
	$lat=$_POST['y'];
	$lng=$_POST['x'];
	$query="select r.*, IF(r.lat is not null and r.lng is not null, (111.111 *
        DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$lat."))
             * COS(RADIANS(r.lat))
             * COS(RADIANS(".$lng." - r.lng))
             + SIN(RADIANS(".$lat."))
             * SIN(RADIANS(r.lat)))))), 99999)  AS distance_in_km FROM restaurant r where 1 ";
	
	if($_POST['sort_by']==1){
		$query.=" order by IF(r.lat is not null and r.lng is not null, (111.111 *
        DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$lat."))
             * COS(RADIANS(r.lat))
             * COS(RADIANS(".$lng." - r.lng))
             + SIN(RADIANS(".$lat."))
             * SIN(RADIANS(r.lat)))))), 99999) asc ";
	}else{
		$query.=" order by star desc ";
	}
	$query.=" limit ".$_POST['limit_num'];
	$res = $db->query_all($query);
	$return_str="";
	while($data=$res->fetch()){
		if($return_str!=""){
			$return_str.=",";
		}
		$data['distance_in_km']=round($data['distance_in_km'],4);
		$return_str.=json_encode($data);
	}
	$ture_post_data='{"data":['.$return_str.']}';
	echo $ture_post_data;//回傳json格式至前端
}
if(isset($_POST['get_park_data_from_db'])){
	$y=$_POST['y'];//lng=y
	$x=$_POST['x'];//lat=x
	$query="select r.*, IF(r.TWD97_X is not null and r.TWD97_Y is not null, (111.111 *
        DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$x."))
             * COS(RADIANS(r.TWD97_X))
             * COS(RADIANS(".$y." - r.TWD97_Y))
             + SIN(RADIANS(".$x."))
             * SIN(RADIANS(r.TWD97_X)))))), 99999)  AS distance_in_km FROM park r where 1 ";
	$query.=" order by IF(r.TWD97_X is not null and r.TWD97_Y is not null, (111.111 *
        DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$x."))
             * COS(RADIANS(r.TWD97_X))
             * COS(RADIANS(".$y." - r.TWD97_Y))
             + SIN(RADIANS(".$x."))
             * SIN(RADIANS(r.TWD97_X)))))), 99999) asc ";
	$query.=" limit ".$_POST['limit_num'];
	$res = $db->query_all($query);
	$return_str="";
	while($data=$res->fetch()){
		$bind2=array();
		$bind2['id']=$data['ID'];
		$res2=$db->query_all("select * from favo where id=:id",$bind2);
		if($res2->size()>0){
			$data['favo']=1;
		}else{
			$data['favo']=0;
		}
		if($return_str!=""){
			$return_str.=",";
		}
		$data['distance_in_km']=round($data['distance_in_km'],4);
		$return_str.=json_encode($data);
	}
	$ture_post_data='{"data":['.$return_str.']}';
	echo $ture_post_data;//回傳json格式至前端
}
if(isset($_POST['add_favo'])){
	$bind2=array();
	$bind2['id']=$_POST['id'];
	$db->query_all("delete from favo where id=:id",$bind2);
	if($_POST['to_favo']==1){
		$db->query_all("insert into favo(`id`)values(:id)",$bind2);
	}
	$rtn_data=array();
	$rtn_data['rtn_code']=1;
	echo json_encode($rtn_data);
	exit();
}
if(isset($_POST['get_park_favo_data'])){
	$y=$_POST['y'];//lng=y
	$x=$_POST['x'];//lat=x
	$query="select r.*, IF(r.TWD97_X is not null and r.TWD97_Y is not null, (111.111 *
        DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$x."))
             * COS(RADIANS(r.TWD97_X))
             * COS(RADIANS(".$y." - r.TWD97_Y))
             + SIN(RADIANS(".$x."))
             * SIN(RADIANS(r.TWD97_X)))))), 99999)  AS distance_in_km FROM park r where 1 ";
	$query.=" order by IF(r.TWD97_X is not null and r.TWD97_Y is not null, (111.111 *
        DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$x."))
             * COS(RADIANS(r.TWD97_X))
             * COS(RADIANS(".$y." - r.TWD97_Y))
             + SIN(RADIANS(".$x."))
             * SIN(RADIANS(r.TWD97_X)))))), 99999) asc ";
	$query.=" limit ".$_POST['limit_num'];
	$res = $db->query_all($query);
	$return_str="";
	while($data=$res->fetch()){
		$bind2=array();
		$bind2['id']=$data['ID'];
		$res2=$db->query_all("select * from favo where id=:id",$bind2);
		if($res2->size()>0){
			$data['favo']=1;
			if($return_str!=""){
				$return_str.=",";
			}
			$data['distance_in_km']=round($data['distance_in_km'],4);
			$return_str.=json_encode($data);
		}
	}
	$ture_post_data='{"data":['.$return_str.']}';
	echo $ture_post_data;//回傳json格式至前端
}
function get_google_place($sn,$place_name = '', $address = ''){
    global $db;
	$key="AIzaSyBxyyOjIvJ9XsAjrR5zGvgjSnr5cctmGVQ";
    $place_name = str_replace(    
    array('!', '"', '#', '$', '%', '&', '\'', '(', ')', '*',    
        '+', ', ', '-', '.', '/', ':', ';', '<', '=', '>',    
        '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|',    
        '}', '~', '；', '﹔', '︰', '﹕', '：', '，', '﹐', '、',    
        '．', '﹒', '˙', '·', '。', '？', '！', '～', '‥', '‧',    
        '′', '〃', '〝', '〞', '‵', '‘', '’', '『', '』', '「',    
        '」', '“', '”', '…', '❞', '❝', '﹁', '﹂', '﹃', '﹄',
        '（', '）'),    
    '',    
    $place_name);
    $resp = array(
        'place_id' => '',
        'place_data' => ''
    );
    $google_api_data = file_get_contents('https://maps.googleapis.com/maps/api/place/findplacefromtext/json?key='.$key.'&input='.urlencode($place_name . ' ' . $address).'&inputtype=textquery&language=zh-tw');
    $google_api_data = json_decode($google_api_data, true);
    if($google_api_data['status'] == 'OK'){
        $resp['place_id'] = $google_api_data['candidates'][0]['place_id'];
    }
    $google_api_data = file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?key='.$key.'&place_id='.$resp['place_id'].'&language=zh-TW');
    $google_api_data = json_decode($google_api_data, true);
    if(isset($google_api_data['status']) && $google_api_data['status'] == 'OK'){
		$rating=$google_api_data['result']['rating'];
		$lat=$google_api_data['result']['geometry']['location']['lat'];
		$lng=$google_api_data['result']['geometry']['location']['lng'];
		$file_name="";
		if(count($google_api_data['result']['photos'])>0){//API取的圖片
			$photo_reference=$google_api_data['result']['photos'][0]['photo_reference'];
			$google_pic_api_data = file_get_contents('https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference='.$photo_reference.'&key='.$key);//用token取真正的圖片
			$file_name=$resp['place_id']."_".time();//取不重複檔名
			$fp = fopen("./pic/".$file_name, "a+");
			fwrite($fp, $google_pic_api_data);//把圖片存到主機
			fclose($fp);
		}
		
		$bind=array();
		$bind['sn']=$sn;
		$bind['lat']=$lat;
		$bind['lng']=$lng;
		$bind['rating']=$rating;
		$bind['image']=$file_name;//把餐廳圖片的檔名存在資料庫
		$db->query_all("update restaurant set lat=:lat,lng=:lng,star=:rating,image=:image where sn=:sn",$bind);
		
		
    }
}

?>