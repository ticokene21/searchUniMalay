<?php
    require_once('DB_driver.php');
    $conn = new DB_driver();
    $conn->open_connect();

    $arr_req = array();
    $arr_sub = array();
    $arr_sco = array();
    $arr_item = array();

    $sql = "select * from requirement";
    $query = mysql_query($sql);
    $sql1 = "select * from subject";
    $query1 = mysql_query($sql1);
    $sql2 = "select * from scorestruct";
    $query2 = mysql_query($sql2);
    if(mysql_num_rows($query) > 0)
    {
        while($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
            $arr_req[] = array(
                'req_id' => $row['req_id'],
                'req_name' => $row['req_name'],
            );
        }
    }

    if(mysql_num_rows($query1) > 0)
    {
        while($row1 = mysql_fetch_array($query1,MYSQL_ASSOC)){
            $arr_sub[] = array(
                'sub_id' => $row1['sub_id'],
                'sub_name' => $row1['sub_name'],
                'short_name' => $row1['short_name'],
                'req_id' => $row1['req_id'],
                'cat_id' => $row1['cat_id'],
            );
        }
    }
    if(mysql_num_rows($query2) > 0)
    {
        while($row2 = mysql_fetch_array($query2,MYSQL_ASSOC)){
            $arr_sco[] = array(
                'score_id' => $row2['score_id'],
                'sign' => $row2['sign'],
                'grade'=> $row2['grade'],
                'point'=> $row2['point'],
                'status' => $row2['status'],
                'req_id' => $row2['req_id'],
            );
        }
    }
    array_push($arr_item,$arr_req,$arr_sub,$arr_sco);
    echo json_encode($arr_item,JSON_PRETTY_PRINT);


?>