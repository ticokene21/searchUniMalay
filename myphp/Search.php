<?php
require_once('DB_driver.php');
$conn = new DB_driver();
$conn->open_connect();
if(isset($_POST['d'])){
	var_dump($_POST['d']);
//    $arr_val = array();
//    // echo '-------------';
//    // print_r(json_decode($_POST['data']));
//    // echo '-------------';
//    //
//    $arr_val = json_decode($_POST['data']);//
//    $arr_course = array();
//    $arr_uni = array();
//    $arr_result = array();
//
//        for($i = 0;$i<count($arr_val);$i++)
//		{
//			if($arr_val[$i]->req_id == 21)
//			{
//				$sql="select DISTINCT course_id from cou_req where req_id = {$arr_val[$i]->req_id} and valuea <= {$arr_val[$i]->grade_a} and valueb <= {$arr_val[$i]->grade_b} and valuec <= {$arr_val[$i]->grade_c} ";
//			    $query=mysql_query($sql);
//			}else{
//			    $sql="select DISTINCT course_id from cou_req where req_id = {$arr_val[$i]->req_id} and valueorther <= {$arr_val[$i]->grade} or valuea <= {$arr_val[$i]->grade_a}";
//			    $query=mysql_query($sql); //var_dump($query );`
//			}
//		    if ($query)
//		    while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
//		    	// echo '-------------';
//
//		     	array_push($arr_course, $row['course_id']);
//		     	// var_dump($row['course_id']);
//
//		    }
//		}
//
//		$arr_course = array_values(array_unique($arr_course));
//
//
//        for ($i=0; $i < count($arr_course) ; $i++) {
//       	 	$sql1= "select DISTINCT * from course where course_id={$arr_course[$i]}";
//       	 	$query1 = mysql_query($sql1);
//       	 	while ($row1 = mysql_fetch_array($query1,MYSQL_ASSOC)) {
//       	 		array_push($arr_uni,$row1);
//        	}
//       	}
//
//
//       	// $arr_uni = array_values(array_unique($arr_uni));
//
//        echo "<table>";
//        echo "<tr>";
//        echo    "<th>School</th>";
//        echo    "<th>Course</th>";
//        echo    "<th>Level</th>";
//        echo    "<th>Group</th>";
//        echo "</tr>";
//        for ($i=0; $i < count($arr_uni) ; $i++) {
//
//         	$sql2 = "select DISTINCT* from uni where uni_id ={$arr_uni[$i]['uni_id']}";
//         	$query2 = mysql_query($sql2);
//         	// echo $arr_uni[$i]['name_course'];
//         	// echo "</br>";
//            echo "<tr>";
//         	while ($row2 = mysql_fetch_array($query2,MYSQL_ASSOC)) {
//
//         		array_push($arr_result,$row2);
//                echo "<td>";
//         		print_r($row2['name_uni']);
//                echo "</td>";
//         		if ($row2['uni_id'] == $arr_uni[$i]['uni_id']) {
//         			# code...
//
//         			echo "<td> ";
//         			print_r($arr_uni[$i]['name_course']);
//                    echo "</td>";
//         			echo "<td>";
//         			print_r($arr_uni[$i]['level_name']);
//         			echo "</td>";
//                    echo "<td>";
//         			print_r($arr_uni[$i]['group_name']);
//         			echo "</td>";
//
//         		}
//         		// if ($arr_uni[$i][]==) {
//
//         	}
//            echo "</tr>";
//
//        }
//            echo "</table>";
//
        

}else
	echo"khong";
