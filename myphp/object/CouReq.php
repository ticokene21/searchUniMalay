<?php

/**
 * Created by PhpStorm.
 * User: vi
 * Date: 5/17/2016
 * Time: 11:32 AM
 */
class CouReq
{
    public $arr_couidUni = array();
    public $arr_universiry = array();
    public $arr_couid = array();
    public $__connect;

    function __construct()
    {
        $this->__connect = mysql_connect("localhost", "root", "") or die ("Can not connect to Database");
        mysql_select_db("uni",$this->__connect ) or die("not exist Database");
        mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'",$this->__connect );
    }
    function test($string)
    {
        if(strpos($string,"(")) {
            $array = spliti("[(]", $string);

            $arr1 = spliti("[,(). ]", $array[0]);
            $arr2 = spliti("[,(). ]", $array[1]);
            $b = array();
            for ($i = 0; $i < count($arr2); $i++) {
                $a = array($arr2[$i]);
                for ($j = 0; $j < count($arr1); $j++) {
                    if ($arr2[$i] != null && $arr1[$j] != null) {
                        array_push($a, $arr1[$j]);
                        sort($a);
                    }
                }
                array_push($b,$a);
            }
            array_pop($b);
        }
        return $b;
    }

    function groupBy($arr) {
        $out = array();
        foreach($arr as $val){
            $out[$val['cou_id']]['array_number'][] = $val['number'];
            if(is_array($val['opera'][0])){
                foreach($val['opera'] as $newVal)
                    $out[$val['cou_id']]['array_opera'][] = $newVal;
            }
            else
                $out[$val['cou_id']]['array_opera'][] = $val['opera'];

            $out[$val['cou_id']]['array_opera'] = array_map("unserialize", array_unique(array_map("serialize", $out[$val['cou_id']]['array_opera'])));
        }
        return($out);
    }

    function comBare($arr,$arr_couid){
        $arr = $this->groupBy($arr);
        $out = array();
        foreach($arr as $key=>$val){
            if(in_array($key,$arr_couid)){
                continue;
            }
            else{
                foreach($val['array_opera'] as $opera_val){
                    $combera = array_diff($opera_val,$val['array_number']);
                    if($combera == null) {
                        array_push($out, $key);
                        break;
                    }
                }
            }

        }
//        print_r($out);
        return $out;
    }

    function initdata(){

        $arr_req = array();
        $arr_sub = array();
        $arr_sco = array();
        $arr_item = array();
        $arr_level = array();
        $arr_group = array();
        $sql = "select * from requirement";
        $query = mysql_query($sql);
        $sql1 = "select * from subject";
        $query1 = mysql_query($sql1);
        $sql2 = "select * from scorestruct";
        $query2 = mysql_query($sql2);
        $sql3 = "select * from groupcourse";
        $query3 = mysql_query($sql3);
        $sql4 = "select * from levelcourse";
        $query4 = mysql_query($sql4);
        if(mysql_num_rows($query) > 0)
        {
            while($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
                $arr_req[] = array(
                    'req_id' => $row['req_id'],
                    'req_name' => $row['req_name'],
                    'input_type' => $row['input_type'],
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
                    'cat' => $row1['cat'],
                    'unit' => $row1['unit']
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
        if(mysql_num_rows($query3) > 0)
        {
            while($row3 = mysql_fetch_array($query3,MYSQL_ASSOC)){
//                array_push($arr_group,$row3['group_name']);
                $arr_group[] = array(
                    'group_id' => $row3['group_id'],
                    'group_name' => $row3['group_name'],
                );
            }
        }
        if(mysql_num_rows($query4) > 0)
        {
            while($row4 = mysql_fetch_array($query4,MYSQL_ASSOC)){
//                array_push($arr_level,$row4['level_name']);
                $arr_level[] = array(
                    'level_id' => $row4['level_id'],
                    'level_name' => $row4['level_name'],
                );
            }
        }
        array_push($arr_item,$arr_req,$arr_sub,$arr_sco,$arr_group,$arr_level);
        echo json_encode($arr_item,JSON_PRETTY_PRINT);
    }
    function SearchCourseID(){
        if(isset($_POST['data'])){

            $arr_val = json_decode($_POST['data']);

            foreach($arr_val as $req ){
                if($req->listreq->input_type == 2)
                {

                    foreach($req->listreq->listsub as $sub)
                    {
                        if($req->listreq->req_id == 7)
                            $sql = "select cou_id,operater,number,andwith from cou_req where req_id ={$req->listreq->req_id} and sub_id= {$sub->sub_id} and overall <= {$sub->scoreEnglish->overall} and writing <= {$sub->scoreEnglish->writing} and listening <= {$sub->scoreEnglish->listening} and reading <= {$sub->scoreEnglish->reading} and speaking <= {$sub->scoreEnglish->speaking}  ";
                        else
                            $sql = "select cou_id,operater,number,andwith from cou_req where req_id ={$req->listreq->req_id} and sub_id= {$sub->sub_id} and overall <= {$sub->scoreEnglish->overall} ";
                        $query = mysql_query($sql);
                        if(mysql_num_rows($query) > 0) {
                            while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
                                if($row['operater'] == 1)
                                {
                                    $str = $row['number'].",".$row['andwith'];
                                    $row['opera'] = $this->test($str);
                                    array_push($this->arr_couidUni,$row);
                                }else
                                    array_push($this->arr_couid,$row['cou_id']);
                            }
                        }
                    }
//                }elseif($req->listreq->input_type == 4){
//                    foreach($req->listreq->listsub as $sub) {
//                        $sql = "select * from cou_req where req_id ={$req->listreq->req_id} and overall <= {$sub->scoreEnglish->overall} ";
//                        $query = mysql_query($sql);
//                        if (mysql_num_rows($query) > 0) {
//                            while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
//                                array_push($this->arr_couidUni, $row['cou_id']);
//                            }
//                        }
//                    }
                } else{
                    foreach($req->listreq->listsub as $sub){
                        $sql = "select score_id from scorestruct where req_id = {$req->listreq->req_id} and point <= {$sub->score->point}";// select id of scorestruct where req_id and point < input point from html
                        $query = mysql_query($sql);

                        if(mysql_num_rows($query) > 0 )
                        {
                            while($row = mysql_fetch_array($query,MYSQL_ASSOC)){

                                $sql1 ="select cou_id,operater,number,andwith from cou_req where req_id = {$req->listreq->req_id} and sub_id={$sub->sub_id} or sub_id = 0 and score_id = {$row['score_id']}";
 //                               print_r($sql1);
                                $query1 = mysql_query($sql1);
                                if(mysql_num_rows($query1) > 0)
                                {
                                    while($row1 = mysql_fetch_array($query1,MYSQL_ASSOC)){
                                        if($row1['operater'] == 1)
                                        {
                                            $str = $row1['number'].",".$row1['andwith'];
                                            $row1['opera'] = $this->test($str);
                                            array_push($this->arr_couidUni,$row1);
                                        }else
                                            array_push($this->arr_couid,$row1['cou_id']);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->arr_couidUni = array_map("unserialize", array_unique(array_map("serialize", $this->arr_couidUni)));
            $item_couid = $this->comBare($this->arr_couidUni,$this->arr_couid);
//              print_r($item_couid);
//            print_r($this->arr_couid);
            if($item_couid != null)
                $this->arr_couid = array_merge($this->arr_couid,$item_couid);

            print_r(json_encode($this->arr_couid));
//            $this->arr_couid = array_unique($this->arr_couid);

        }else
            echo"khong";
    }
    function UpdateCourseID(){
        if(isset($_POST['data'])){

//            $arr_couid = array();
//            $arr_val = array();

            $arr_val = json_decode($_POST['data']);
            $arr_couid= json_decode($_POST['arr_result']);
            foreach($arr_val as $req ) {
                if ($req->listreq->input_type == 2) {

                    foreach ($req->listreq->listsub as $sub) {
                        foreach($arr_couid as $couid)
                        {
                            if($req->listreq->req_id == 7)
                                $sql = "select * from cou_req where cou_id = {$couid} and req_id ={$req->listreq->req_id} and sub_id= {$sub->sub_id} and overall <= {$sub->scoreEnglish->overall} and writing <= {$sub->scoreEnglish->writing} and listening <= {$sub->scoreEnglish->listening} and reading <= {$sub->scoreEnglish->reading} and speaking <= {$sub->scoreEnglish->speaking}  ";
                            else
                                $sql = "select * from cou_req where cou_id = {$couid} and req_id ={$req->listreq->req_id} and sub_id= {$sub->sub_id} and overall <= {$sub->scoreEnglish->overall} ";
                            $query = mysql_query($sql);
                            if (mysql_num_rows($query) > 0) {
                                while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
                                    array_push($this->arr_couidUni, $row['cou_id']);
                                }
                            }

                        }
                    }
//                }elseif($req->listreq->input_type == 4){
//                    foreach($req->listreq->listsub as $sub) {
//                        $sql = "select * from cou_req where req_id ={$req->listreq->req_id} and overall <= {$sub->scoreEnglish->overall} ";
//                        $query = mysql_query($sql);
//                        if (mysql_num_rows($query) > 0) {
//                            while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
//                                array_push($this->arr_couidUni, $row['cou_id']);
//                            }
//                        }
//                    }
                }else{
                    foreach ($req->listreq->listsub as $sub) {
                        $sql = "select score_id from scorestruct where req_id = {$req->listreq->req_id} and point <= {$sub->score->point}";// select id of scorestruct where req_id and point < input point from html
                        $query = mysql_query($sql);

                        if (mysql_num_rows($query) > 0) {
                            while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {

                                foreach ($arr_couid as $couid) {
                                    $sql1 = "select * from cou_req where cou_id = {$couid} and req_id = {$req->listreq->req_id} and sub_id={$sub->sub_id} or sub_id = 0 and score_id = {$row['score_id']}";

                                    $query1 = mysql_query($sql1);
                                    if (mysql_num_rows($query1) > 0) {
                                        while ($row1 = mysql_fetch_array($query1, MYSQL_ASSOC)) {
                                            array_push($this->arr_couidUni, $row1['cou_id']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->arr_couidUni = array_unique($this->arr_couidUni);
            print_r(json_encode($this->arr_couidUni));
        }else
            echo"khong";
    }

//    function QueryGetCourse($le,$gro,$arr_sco){
//        $arr_u = array();
//        foreach($arr_sco as $sco){
//            if($sco['level_name'] == $le->level_name && $sco['group_name'] == $gro->group_name )
//            {
//                array_push($arr_u,$sco);
//            }elseif($sco['level_name'] == $le->level_name || $sco['group_name'] == $gro->group_name){
//
//            }
//        }
//        return $arr_u;
//    }

    function GetUniCourse(){

        if($_POST['data'] != null){
            $level = json_decode($_POST['level']);
            $group = json_decode($_POST['group']);
            $arr_coUni = json_decode($_POST['data']);
            $arr_course = array();
            foreach($arr_coUni as $couidUni){
                $sql = "select * from course where cou_id = {$couidUni}";
                $query = mysql_query($sql);
                if(mysql_num_rows($query) > 0 ){
                    while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
                        array_push($arr_course,$row);
                    }
                }
            }

            if($level->level_id == 1 && $group->group_id != 1){

                foreach($arr_course as $course){

                    if($course['group_name'] == $group->group_name){
                        array_push($this->arr_universiry,$course);

                    }
                }
            }elseif($level->level_id != 1 && $group->group_id == 1){
                foreach($arr_course as $course){
                    if($course['level_name'] == $level->level_name){
                        array_push($this->arr_universiry,$course);

                    }
                }
            }elseif($level->level_id != 1 && $group->group_id != 1){
                foreach($arr_course as $course){
                    if($course['level_name'] == $level->level_name && $course['group_name'] == $group->group_name  ){
                        array_push($this->arr_universiry,$course);

                    }
                }
            }else{

                $this->arr_universiry = $arr_course;
            }

            foreach($this->arr_universiry as $key=>$universiry){
                $sql1 = "select * from university where uni_id = {$universiry['uni_id']}";
                $query1 = mysql_query($sql1);
                if(mysql_num_rows($query1) > 0){
                    while($row1 = mysql_fetch_array($query1,MYSQL_ASSOC)){
                        $this->arr_universiry[$key]['uniname'] = $row1['uni_name'];
                    }
                }
            }
            echo json_encode($this->arr_universiry,JSON_PRETTY_PRINT);
        }else{
            echo "áaaaaaa";
        }
    }

    function close_connect(){
        mysql_close($this->__connect);
    }
}
