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
    public $__connect;

    function __construct()
    {
        $this->__connect = mysql_connect("localhost", "root", "") or die ("Can not connect to Database");
        mysql_select_db("uni",$this->__connect ) or die("not exist Database");
        mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'",$this->__connect );
    }
    function initdata(){

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
    }
    function SearchCourseID(){
        if(isset($_POST['data'])){

            $arr_val = json_decode($_POST['data']);

            foreach($arr_val as $req ){
                if($req->listreq->input_type == 2)
                {

                    foreach($req->listreq->listsub as $sub)
                    {
                        $sql = "select * from cou_req where req_id ={$req->listreq->req_id} and sub_id= {$sub->sub_id} and overall <= {$sub->scoreEnglish->overall} and writing <= {$sub->scoreEnglish->writing} and listening <= {$sub->scoreEnglish->listening} and reading <= {$sub->scoreEnglish->reading} and speaking <= {$sub->scoreEnglish->speaking}  ";
                        $query = mysql_query($sql);
                        if(mysql_num_rows($query) > 0) {
                            while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
                                array_push($this->arr_couidUni,$row['cou_id']);
                            }
                        }
                    }
                }elseif($req->listreq->input_type == 4){
                    foreach($req->listreq->listsub as $sub) {
                        $sql = "select * from cou_req where req_id ={$req->listreq->req_id} and overall <= {$sub->scoreEnglish->overall} ";
                        $query = mysql_query($sql);
                        if (mysql_num_rows($query) > 0) {
                            while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
                                array_push($this->arr_couidUni, $row['cou_id']);
                            }
                        }
                    }
                } else{
                    foreach($req->listreq->listsub as $sub){
                        $sql = "select score_id from scorestruct where req_id = {$req->listreq->req_id} and point <= {$sub->score->point}";// select id of scorestruct where req_id and point < input point from html
                        $query = mysql_query($sql);

                        if(mysql_num_rows($query) > 0 )
                        {
                            while($row = mysql_fetch_array($query,MYSQL_ASSOC)){

                                $sql1 ="select cou_id from cou_req where req_id = {$req->listreq->req_id} or req_id = 0 and sub_id={$sub->sub_id} and score_id = {$row['score_id']}";
                                $query1 = mysql_query($sql1);
                                if(mysql_num_rows($query1) > 0)
                                {
                                    while($row1 = mysql_fetch_array($query1,MYSQL_ASSOC)){

                                        array_push($this->arr_couidUni,$row1['cou_id']);

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
    function UpdateCourseID(){
        if(isset($_POST['data'])){

            $arr_couid = array();
            $arr_val = array();

            $arr_val = json_decode($_POST['data']);
            $arr_couid= json_decode($_POST['arr_result']);
            foreach($arr_val as $req ) {
                if ($req->listreq->input_type == 2) {

                    foreach ($req->listreq->listsub as $sub) {

                        $sql = "select * from cou_req where req_id ={$req->listreq->req_id} and sub_id= {$sub->sub_id} and overall <= {$sub->scoreEnglish->overall} and writing <= {$sub->scoreEnglish->writing} and listening <= {$sub->scoreEnglish->listening} and reading <= {$sub->scoreEnglish->reading} and speaking <= {$sub->scoreEnglish->speaking}  ";
                        $query = mysql_query($sql);
                        if (mysql_num_rows($query) > 0) {
                            while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
                                array_push($this->arr_couidUni, $row['cou_id']);
                            }
                        }
                    }
                }elseif($req->listreq->input_type == 4){
                    foreach($req->listreq->listsub as $sub) {
                        $sql = "select * from cou_req where req_id ={$req->listreq->req_id} and overall <= {$sub->scoreEnglish->overall} ";
                        $query = mysql_query($sql);
                        if (mysql_num_rows($query) > 0) {
                            while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
                                array_push($this->arr_couidUni, $row['cou_id']);
                            }
                        }
                    }
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
    function GetUniCourse(){

        if(isset($_POST['data'])){
            $arr_coUni = json_decode($_POST['data']);
            foreach($arr_coUni as $couidUni){
                $sql = "select * from course where cou_id = {$couidUni}";
                $query = mysql_query($sql);
                if(mysql_num_rows($query) > 0 ){
                    while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
                        array_push($this->arr_universiry,$row);
                    }
                }
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
        }
    }
    function close_connect(){
        mysql_close($this->__connect);
    }
}
