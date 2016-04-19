<?php
// Function convert string to array
// example string = 1,(2,3); array = [[1,2],[1,3]]
function test($string)
{
	$array = spliti("[(]",$string);
	foreach($array as $val)
	{

	}
	$arr1 = spliti("[,(). ]",$array[0]);
	$arr2 = spliti("[,(). ]",$array[1]);

	$b = array();

	for($i=0;$i<count($arr2);$i++)
	{
		$a = array($arr2[$i]);
		for($j=0;$j<count($arr1);$j++) {
			if($arr2[$i] !=null && $arr1[$j] != null) {
				array_push($a, $arr1[$j]);
				sort($a);
			}
		}
		array_push($b,$a);

	}

	array_pop($b);
	return $b;
}
require_once('DB_driver.php');
$conn = new DB_driver();
$conn->open_connect();

if(isset($_POST['data'])){
	$arr_val = array();
	$arr_val = json_decode($_POST['data']);
	// get data post
	/*\ $arr_val:
	Array([0] => stdClass Object
	(
	[listreq] => stdClass Object
		(
		[req_id] => 1
        [req_name] => Sijil Tinggi Persekolahan Malaysia
        [listsub] => Array
			(
			[0] => stdClass Object
				(
				[sub_id] => 15
				[sub_name] => General Studies
				[short_name] => General Studies
				[req_id] => 1
				[cat_id] => 1
				[$$hashKey] => object:13
				[score] => stdClass Object
					(
						[score_id] => 12
						[sign] => A-
						[grade] => 3.67
						[point] => 3.67
						[status] =>
						[req_id] => 1
					)
				)
			)
		)
	)*/
	// Start function query data input in database
	$arr_scoReq = array();
	$arr_couidUni = array();

	foreach($arr_val as $req ){
		foreach($req->listreq->listsub as $sub){
			$sql = "select score_id from scorestruct where req_id = {$req->listreq->req_id} and point <= {$sub->score->point}";// select id of scorestruct where req_id and point < input point from html
			$query = mysql_query($sql);
			if(mysql_num_rows($query) > 0 )
			{
				while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
					$sql1 ="select * from cou_req where req_id = {$req->listreq->req_id} and sub_id={$sub->sub_id} and score_id = {$row['score_id']} group by cou_id";
					$query1 = mysql_query($sql1);
					if(mysql_num_rows($query1) > 0)
					{
						while($row1 = mysql_fetch_array($query1,MYSQL_ASSOC)){
							//if operate = 1 convert string to array
							if($row1['operater']==1)
							{
								$str = $row1['number'].",".$row1['andwith'];
								$row1['opera'] = test($str);
								array_push($arr_scoReq,$row1);
							}
							else{
								$row1['opera'] = null;
								array_push($arr_couidUni,$row1['cou_id']);
							}
						}
					}
				}
			}
		}
	}
	//End function query data input in database
	$arr_scoReq = json_decode(json_encode($arr_scoReq));
	$arr_scoNum = [];
	$arr_scoOpera = [];
	// function push number in arr_number and opera into arr_opera group by cou_id
	foreach ($arr_scoReq as $i) {
		$found = false;
		$foundIndex = -1;
		foreach ($arr_scoNum as $key=>$res) {
			if ($res['cou_id'] == $i->cou_id)  {
				$foundIndex = $key;
				$found = true;
			}

		}

		if ($foundIndex > -1 && !in_array($i->number, $arr_scoNum[$foundIndex]['arr_number'])  ) {
			array_push($arr_scoNum[$foundIndex]['arr_number'], $i->number);
			array_merge($arr_scoNum[$foundIndex]['arr_opera'],$i->opera);
		}
		if (!$found) {
			array_push($arr_scoNum, [ 'cou_id' => $i->cou_id, 'arr_number' => [$i->number],'arr_opera' => [$i->opera]]);

		}
	}
	// get cou_id
	foreach($arr_scoNum as $scoNum){
		foreach($scoNum['arr_opera'] as $key=>$arr_opera )
		{
			if($arr_opera != null)
			{
				$combera = in_array($scoNum['arr_number'],$arr_opera);
				if($combera == true){
					array_push($arr_couidUni,$scoNum['cou_id']);
				}
			}
		}
	}

	ob_start();
	echo "<table>";
	echo "<tr>";
	echo    "<th>Course</th>";
	echo    "<th>Level</th>";
	echo    "<th>Group</th>";
	echo    "<th>School</th>";
	echo "</tr>";
	foreach($arr_couidUni as $couidUni)
	{
		$sql2 = "select * from course where cou_id = {$couidUni}";
		$query2 = mysql_query($sql2);
		if(mysql_num_rows($query2) > 0){
			while($row2 = mysql_fetch_array($query2,MYSQL_ASSOC)){
				echo "<tr>";
				echo    "<td>{$row2['cou_name']}</td>";
				echo    "<td>{$row2['group_name']}</td>";
				echo    "<td>{$row2['level_name']}</td>";

				$sql3 = "select uni_name from university where uni_id = {$row2['uni_id']}";
				$query3 = mysql_query($sql3);
				if(mysql_num_rows($query3) > 0){
					while($row3 = mysql_fetch_array($query3,MYSQL_ASSOC))
					{
						echo "<td>{$row3['uni_name']}</td>";
						echo "</tr>";
					}
				}
			}
		}
	}
	echo "</table>";
	$fragment = ob_get_clean();
	$data = array("fragment"=>$fragment);

	echo json_encode($data);
	die();

}else
	echo"khong";

