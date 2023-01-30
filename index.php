<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>


同步資料<br>
<input id="get_restaurant_data" type='button' value="從API同步餐廳資料" onclick="get_restaurant_data()"><br>
<input id="get_park_data" type='button' value="從API同步停車位資料" onclick="get_park_data()"><br>
<br>
<br>
x:<input id="x" value="120.6744499">y:<input id="y" value="24.1409741"><input type='button' value="取得我的位置" onclick="getLocation()">

<br>
依<select id='sort_by'><option value=1>距離</option><option value=2>星等</option></select>排序
<input type='button' value="取得餐廳" onclick="get_restaurant_data_from_db()"><br>

<br>
<input type='button' value="取得周圍停車" onclick="get_park_data_from_db()">
<br>
<input type='button' value="停車收藏清單" onclick="get_park_favo_data()">
<table border=1px>
<thead>
<tr><td id="data_title" style='text-align:center' colspan=6></td></tr>
<tr id="data_title2"></tr>
</thead>
<tbody id="tbody1"></tbody>
</table>
<script>
function get_restaurant_data(){
	var yes = confirm('此動作會將現有資料清空,重新抓取資料(會消耗google api次數),是否確定要使用？');
	if (yes) {
		$("#get_restaurant_data").attr("disabled",true);
		$.ajax({
			type :"POST",
			url: "./ajax.php",
				data : {
					get_restaurant_data:1,
				},
			dataType: "text",
			success : function(res_text) {
				var obj =JSON.parse(res_text);
				alert(obj.rtn_msg);
				$("#get_restaurant_data").attr("disabled",false);
			}	
		});		
	}
}
function get_park_data(){
	var yes = confirm('此動作會將現有資料清空,重新抓取資料,是否確定要使用？');
	if (yes) {
		$("#get_park_data").attr("disabled",true);
		$.ajax({
			type :"POST",
			url: "./ajax.php",
				data : {
					get_park_data:1,
				},
			dataType: "text",
			success : function(res_text) {
				var obj =JSON.parse(res_text);
				alert(obj.rtn_msg);
				$("#get_park_data").attr("disabled",false);
			}	
		});		
	}
}
function get_restaurant_data_from_db(){
	$.ajax({
		type :"POST",
		url: "./ajax.php",
			data : {
				get_restaurant_data_from_db:1,
				limit_num:10,
				sort_by:$("#sort_by").val(),
				x:$("#x").val(),
				y:$("#y").val(),
			},
		dataType: "text",
		success : function(res_text) {
			$("#tbody1").html("");
			$("#data_title").html("餐廳資料");
			$("#data_title2").html("");
			var set_html="";
			var set_html2="";
			set_html2+="<th>序號</th>";
			set_html2+="<th>名稱</th>";
			set_html2+="<th>電話</th>";
			set_html2+="<th>地址</th>";
			set_html2+="<th>星等</th>";
			set_html2+="<th>距離</th>";
			set_html2+="<th>餐廳圖片</th>";
			var obj =JSON.parse(res_text);
			for(var i=0;i<obj.data.length;i++){//顯示資料
				set_html+="<tr>";
				set_html+="<td>"+obj.data[i].sn+"</td>";
				set_html+="<td>"+obj.data[i].name+"</td>";
				set_html+="<td>"+obj.data[i].tel+"</td>";
				set_html+="<td>"+obj.data[i].address+"</td>";
				set_html+="<td>"+obj.data[i].star+"</td>";
				set_html+="<td>"+obj.data[i].distance_in_km+"</td>";
				set_html+="<td>"+obj.data[i].image+"</td>";

				set_html+="</tr>";
			}
			$("#data_title2").html(set_html2);
			$("#tbody1").html(set_html);
		
		}	
	});		
}
function get_park_data_from_db(){
	$.ajax({
		type :"POST",
		url: "./ajax.php",
			data : {
				get_park_data_from_db:1,
				limit_num:10,
				x:$("#x").val(),
				y:$("#y").val(),
			},
		dataType: "text",
		success : function(res_text) {
			$("#tbody1").html("");
			$("#data_title").html("停車場資料");
			$("#data_title2").html("");
			var set_html="";
			var set_html2="";
			set_html2+="<th>ID</th>";
			set_html2+="<th>area_id</th>";
			set_html2+="<th>road_id</th>";
			set_html2+="<th>rdname</th>";
			set_html2+="<th>se_road</th>";
			set_html2+="<th>ceiiId</th>";
			set_html2+="<th>day</th>";
			set_html2+="<th>hour</th>";
			set_html2+="<th>pay</th>";
			set_html2+="<th>paycash</th>";
			set_html2+="<th>cellsum</th>";
			set_html2+="<th>bdate</th>";
			set_html2+="<th>memo</th>";
			set_html2+="<th>X</th>";
			set_html2+="<th>Y</th>";
			set_html2+="<th>parkingT</th>";
			set_html2+="<th>TWD97_X</th>";
			set_html2+="<th>TWD97_Y</th>";
			set_html2+="<th>距離</th>";
			set_html2+="<th>收藏</th>";
			var obj =JSON.parse(res_text);
			for(var i=0;i<obj.data.length;i++){//顯示資料
				set_html+="<tr>";
				set_html+="<td>"+obj.data[i].ID+"</td>";
				set_html+="<td>"+obj.data[i].area_id+"</td>";
				set_html+="<td>"+obj.data[i].road_id+"</td>";
				set_html+="<td>"+obj.data[i].rdname+"</td>";
				set_html+="<td>"+obj.data[i].se_road+"</td>";
				set_html+="<td>"+obj.data[i].ceiiId+"</td>";
				set_html+="<td>"+obj.data[i].day+"</td>";
				set_html+="<td>"+obj.data[i].hour+"</td>";
				set_html+="<td>"+obj.data[i].pay+"</td>";
				set_html+="<td>"+obj.data[i].paycash+"</td>";
				set_html+="<td>"+obj.data[i].cellsum+"</td>";
				set_html+="<td>"+obj.data[i].bdate+"</td>";
				set_html+="<td>"+obj.data[i].memo+"</td>";
				set_html+="<td>"+obj.data[i].X+"</td>";
				set_html+="<td>"+obj.data[i].Y+"</td>";
				set_html+="<td>"+obj.data[i].parkingT+"</td>";
				set_html+="<td>"+obj.data[i].TWD97_X+"</td>";
				set_html+="<td>"+obj.data[i].TWD97_Y+"</td>";
				set_html+="<td>"+obj.data[i].distance_in_km+"</td>";
				set_html+="<td><input onclick='add_favo("+obj.data[i].ID+",this,1)' type='checkbox' ";
				if(obj.data[i].favo==1){
					set_html+=" checked ";
				}
				set_html+=" />";
				set_html+="</tr>";
			}
			$("#data_title2").html(set_html2);
			$("#tbody1").html(set_html);
		}	
	});		
}
function add_favo(id,that,type){
	if($(that).prop("checked")){
		to_favo=1;
	}else{
		to_favo=0;
	}
	$.ajax({
		type :"POST",
		url: "./ajax.php",
			data : {
				add_favo:1,
				id:id,
				to_favo:to_favo
			},
		dataType: "text",
		success : function(res_text) {
			//var obj =JSON.parse(res_text);
			if(to_favo==1){
				alert("收藏成功");
			}else{
				alert("取消收藏成功");
			}
			if(type==1){
				get_park_data_from_db();
			}else{
				get_park_favo_data();
			}
			
		}	
	});
}
function get_park_favo_data(){
	$.ajax({
		type :"POST",
		url: "./ajax.php",
			data : {
				get_park_favo_data:1,
				limit_num:10,
				x:$("#x").val(),
				y:$("#y").val(),
			},
		dataType: "text",
		success : function(res_text) {
			$("#tbody1").html("");
			$("#data_title").html("收藏停車場資料");
			$("#data_title2").html("");
			var set_html="";
			var set_html2="";
			set_html2+="<th>ID</th>";
			set_html2+="<th>area_id</th>";
			set_html2+="<th>road_id</th>";
			set_html2+="<th>rdname</th>";
			set_html2+="<th>se_road</th>";
			set_html2+="<th>ceiiId</th>";
			set_html2+="<th>day</th>";
			set_html2+="<th>hour</th>";
			set_html2+="<th>pay</th>";
			set_html2+="<th>paycash</th>";
			set_html2+="<th>cellsum</th>";
			set_html2+="<th>bdate</th>";
			set_html2+="<th>memo</th>";
			set_html2+="<th>X</th>";
			set_html2+="<th>Y</th>";
			set_html2+="<th>parkingT</th>";
			set_html2+="<th>TWD97_X</th>";
			set_html2+="<th>TWD97_Y</th>";
			set_html2+="<th>距離</th>";
			set_html2+="<th>收藏</th>";
			var obj =JSON.parse(res_text);
			for(var i=0;i<obj.data.length;i++){//顯示資料
				set_html+="<tr>";
				set_html+="<td>"+obj.data[i].ID+"</td>";
				set_html+="<td>"+obj.data[i].area_id+"</td>";
				set_html+="<td>"+obj.data[i].road_id+"</td>";
				set_html+="<td>"+obj.data[i].rdname+"</td>";
				set_html+="<td>"+obj.data[i].se_road+"</td>";
				set_html+="<td>"+obj.data[i].ceiiId+"</td>";
				set_html+="<td>"+obj.data[i].day+"</td>";
				set_html+="<td>"+obj.data[i].hour+"</td>";
				set_html+="<td>"+obj.data[i].pay+"</td>";
				set_html+="<td>"+obj.data[i].paycash+"</td>";
				set_html+="<td>"+obj.data[i].cellsum+"</td>";
				set_html+="<td>"+obj.data[i].bdate+"</td>";
				set_html+="<td>"+obj.data[i].memo+"</td>";
				set_html+="<td>"+obj.data[i].X+"</td>";
				set_html+="<td>"+obj.data[i].Y+"</td>";
				set_html+="<td>"+obj.data[i].parkingT+"</td>";
				set_html+="<td>"+obj.data[i].TWD97_X+"</td>";
				set_html+="<td>"+obj.data[i].TWD97_Y+"</td>";
				set_html+="<td>"+obj.data[i].distance_in_km+"</td>";
				set_html+="<td><input onclick='add_favo("+obj.data[i].ID+",this,2)' type='checkbox' ";
				if(obj.data[i].favo==1){
					set_html+=" checked ";
				}
				set_html+=" />";
				set_html+="</tr>";
			}
			$("#data_title2").html(set_html2);
			$("#tbody1").html(set_html);
		}	
	});
}







function getLocation() {//取得 經緯度
    if (navigator.geolocation) {//
        navigator.geolocation.getCurrentPosition(showPosition, showError, {timeout: 10000});//有拿到位置就呼叫 showPosition 函式
    }else{
       alert("您的瀏覽器不支援 顯示地理位置 API ，請使用其它瀏覽器開啟 這個網址");
    }
}
function showPosition(position){
    user_lat = position.coords.latitude;
    user_lng = position.coords.longitude;
    $("#y").val(user_lat);
    $("#x").val(user_lng);
}
function showError(error){
    var msg = '';
    var flag_error_f=0;
    switch(error.code)
    {
        case error.PERMISSION_DENIED:
            alert("用户拒絕獲取地理位置的请求。");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("位置是不可用的。");
            break;
        case error.TIMEOUT:
            alert("請求位置地理位置超時。");
            break;
        case error.UNKNOWN_ERROR:
			alert("未知錯誤。");
            break;
    }
}
</script>
