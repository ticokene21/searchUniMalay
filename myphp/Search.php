<?php
require_once('DB_driver.php');
$conn = new DB_driver();
$conn->open_connect();
if(isset($_POST['data'])){
	echo "co";
    $arr_val = array();
    $arr_val = json_decode($_POST['data']);//Bắt dữ liệu json bên ajax vào chuyển thàng kiểu array()
    $arr_course = array();
    $arr_uni = array();
    echo count($arr_val);
    echo $arr_val[1]->req_id;

//	echo count($arr_val);
  //   $sql="select * from cou_req";
 	// $query=mysql_query($sql);
 	// if(mysql_num_rows($query) == 0){
  //       echo "Chua co du lieu";
  //   }
  //   else{
  //       $row=mysql_fetch_array($query)
        for($i = 0;$i<count($arr_val)-1;$i++)
		{
		    $sql="select DISTINCT course_id from cou_req where req_id = '$arr_val[$i]->req_id' and valueother= '$arr_val[$i]->grade'";
		    $query=mysql_query($sql);
		    while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
		    	echo $row['course_id'];
		     	array_push($arr_course, $row['course_id']);
		    }
		}

		$arr_course = array_unique($arr_course);
//		echo $arr_course;
        for ($i=0; $i < count($arr_course) ; $i++) {
       		$sql1= "select uni_id from course where course_id="+$arr_course[$i];
       		$query1 = mysql_query($sql1);
       		while ($row1 = mysql_fetch_array($query1)) {
       			array_push($arr_uni,$row1['uni_id']);
       		}
       	}
       	$arr_uni = array_unique($arr_uni);
        for ($i=0; $i < count($arr_uni) ; $i++) {
        	$sql2 = "select * from uni where uni_id ="+$arr_uni[$i];
        	$query2 = mysql_query($sql2);
        	while ($row2 = mysql_fetch_array($query2)) {
        		echo $row2['name_uni'];
        	}
        }

}else
	echo"khong";
