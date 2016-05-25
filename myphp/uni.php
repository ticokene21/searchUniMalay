<?php
//require_once('DB_driver.php');
require_once('object/CouReq.php');

$coursereq = new CouReq();
$coursereq->GetUniCourse();

$coursereq->close_connect();


//ob_start();
//echo "<table>";
//echo    "<tr>";
//echo        "<th>Course</th>";
//echo        "<th>Level</th>";
//echo      "<th>Group</th>";
//echo    "<th>School</th>";
//echo    "<th>Requirement</th>";
//echo"</tr>";
//    foreach ($coursereq->arr_universiry as $key => $universiry) {
//        echo"<tr>";
//        echo"<td>{$universiry['uniname']}</td>";
//        echo"<td>{$universiry['cou_name']}</td>";
//        echo"<td>{$universiry['level_name']}</td>";
//        echo"<td>{$universiry['group_name']}</td>";
//        echo"<td></td>";
//        echo"</tr>"	;
//    }
//echo"</table>";
//$fragment = ob_get_clean();
//$data = array("fragment"=>$fragment);
//echo json_encode($data);
//die();
?>

