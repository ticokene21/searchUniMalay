<?php
require_once 'Combinatorics.php';
$combinatorics = new Math_Combinatorics;

// Function convert string to array
// example string = 1,(2,3); array = [[1,2],[1,3]]
//function test($string)
//{
//	$array = spliti("[(]",$string);
//	foreach($array as $val)
//	{
//
//	}
//	$arr1 = spliti("[,(). ]",$array[0]);
//	$arr2 = spliti("[,(). ]",$array[1]);
//
//	$b = array();
//
//	for($i=0;$i<count($arr2);$i++)
//	{
//		$a = array($arr2[$i]);
//		for($j=0;$j<count($arr1);$j++) {
//			if($arr2[$i] !=null && $arr1[$j] != null) {
//				array_push($a, $arr1[$j]);
//				sort($a);
//			}
//		}
//		array_push($b,$a);
//
//	}
//	array_pop($b);
//	return $b;
//}
//function test($string)
//{
//	if(strpos($string,"(")) {
//		$array = spliti("[(]", $string);
//
//		$arr1 = spliti("[,(). ]", $array[0]);
//		$arr2 = spliti("[,(). ]", $array[1]);
//		$b = array();
//
//		for ($i = 0; $i < count($arr2); $i++) {
//			$a = array($arr2[$i]);
//			for ($j = 0; $j < count($arr1); $j++) {
//				if ($arr2[$i] != null && $arr1[$j] != null) {
//					array_push($a, $arr1[$j]);
//					sort($a);
//				}
//			}
//			array_push($b, $a);
//		}
//		array_pop($b);
//		return $b;
//	}
//	else if(strpos($string,"-")){
//		$array = spliti("[- ]", $string);
//		$b = array();
//		for($i =0; $i < count($array); $i++)
//		{
//			if($array[$i] !=null)
//			{
//				$arr = spliti("[, ]",$array[$i]);
//				$a = array();
//				for($j = 0; $j < count($arr); $j++)
//				{
//					array_push($a, $arr[$j]);
//				}
//				array_push($b, $a);
//
//			}
//
//		}
//		return $b;
//	}
//}
//$a = test("21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44-",5);
//print_r($a);


function generate_combinations(array $data, array &$all = array(), array $group = array(), $value = null, $i = 0)
{
	$keys = array_keys($data);
	if (isset($value) === true) {
		array_push($group, $value);
	}
	if ($i >= count($data)) {
		array_push($all, $group);
	} else {
		$currentKey     = $keys[$i];
		$currentElement = $data[$currentKey];
		foreach ($currentElement as $val) {
			generate_combinations($data, $all, $group, $val, $i + 1);
		}
	}

	return $all;
}
function test($string,$num)
{
	if(strpos($string,"<")){
		$data = array();
		$array = spliti("[<]",$string);
		for($i=0;$i<count($array); $i++)
		{
			$b = array();
			$a = spliti("[ >,.;'/n/r ]",$array[$i]);
			for($j =0; $j < count($a); $j++)
			{
				if($a[$j])
				{
					array_push($b,$a[$j]);
				}
			}
			array_push($data,$b);

		}
		$combos =  generate_combinations($data);
		return $combos;
	}
	else if(strpos($string,"(")) {
		$array = spliti("[(]", $string);

		$arr1 = spliti("[,(). ]", $array[0]);
		$arr2 = spliti("[,(). ]", $array[1]);
		$b = array();

		for ($i = 0; $i < count($arr2); $i++) {
			$a = array($arr2[$i]);
			for ($j = 0; $j < count($arr1); $j++) {
				if ($arr2[$i] != null && $arr1[$j] != null) {
					array_push($a, $arr1[$j]);

				}
			}
			array_push($b, $a);
		}
		return $b;
	}
	else if(strpos($string,"-")){
		$array = spliti("[- ]", $string);
		for($i =0; $i < count($array); $i++)
		{
			if($array[$i] !=null)
			{
				$arr = spliti("[, ]",$array[$i]);
				$a = array();
				for($j = 0; $j < count($arr); $j++)
				{
					array_push($a, $arr[$j]);
				}
			}
		}
		$combinatorics = new Math_Combinatorics;
		$c = $combinatorics->combinations($a,$num);
		return $c;
	}
}

//test("1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20-",5);

require_once('DB_driver.php');
$conn = new DB_driver();
$conn->open_connect();

if(isset($_POST['data'])){
	$arr_val = json_decode($_POST['data']);
//	print_r($arr_val[0]->listreq->listsub[0]->scoreEnglish);
//	print_r($arr_val[0]->listreq->listsub[0]->sub_id);
//	if($arr_val[0])
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
	//print_r($arr_val);

	$arr_scoReq = array();
	$arr_couidUni = array();
//	print_r($arr_val);
	foreach($arr_val as $req ){
		if($req->listreq->req_id == 7)
		{

			foreach($req->listreq->listsub as $sub)
			{
//				$overall = empty($sub->scoreEnglish->overall) ? 'NULL' : $sub->scoreEnglish->overall;
//				$writing = empty($sub->scoreEnglish->writing) ? 'NULL' : $sub->scoreEnglish->writing;
//				$listening = empty($sub->scoreEnglish->listening) ? 'NULL' : $sub->scoreEnglish->listening;
//				$reading = empty($sub->scoreEnglish->reading) ? 'NULL' : $sub->scoreEnglish->reading;
//				$speaking = empty($sub->scoreEnglish->speaking) ? 'NULL':$sub->scoreEnglish->speaking;
				$sql = "select * from cou_req where req_id ={$req->listreq->req_id} and sub_id= {$sub->sub_id} and overall <= {$sub->scoreEnglish->overall} and writing <= {$sub->scoreEnglish->writing} and listening <= {$sub->scoreEnglish->listening} and reading <= {$sub->scoreEnglish->reading} and speaking <= {$sub->scoreEnglish->speaking}  ";
				$query = mysql_query($sql);
				if(mysql_num_rows($query) > 0) {
					while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
						if($row['operater'] == 1)
						{
							$str = $row['number'].",".$row['andwith'];
							$row['opera'] = test($str);
							array_push($arr_scoReq,$row);
						}else{
							$row['opera'] = null;
							array_push($arr_couidUni,$row['cou_id']);
						}
					}
				}
			}
		}else{
			foreach($req->listreq->listsub as $sub){
				$sql = "select score_id from scorestruct where req_id = {$req->listreq->req_id} and point <= {$sub->score->point}";// select id of scorestruct where req_id and point < input point from html
				$query = mysql_query($sql);
				if(mysql_num_rows($query) > 0 )
				{
					while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
//					print_r($row['score_id']);
//					echo "<br>";
//						if()
						$sql1 ="select * from cou_req where req_id = {$req->listreq->req_id} and sub_id={$sub->sub_id} and score_id = {$row['score_id']}";
						$query1 = mysql_query($sql1);
						if(mysql_num_rows($query1) > 0)
						{
							while($row1 = mysql_fetch_array($query1,MYSQL_ASSOC)){
								//if operate = 1 convert string to array
								if($row1['operater']==1)
								{
									$str = $row1['number'].",".$row1['andwith'];
									//$row1['opera'] = test($str,0);
									array_push($arr_scoReq,$row1);
								}elseif($row1['operater'] == 2){
									$row1['opera'] = test($row1['andwith'],$row1['anysub']);
//									print_r($row1);
									array_push($arr_scoReq,$row1);
								}else{
									$row1['opera'] = null;
									array_push($arr_couidUni,$row1['cou_id']);
								}
							}
						}
					}
				}
			}
		}
	}
	//End function query data input in database

//	$arr_scoReq = json_decode(json_encode($arr_scoReq));
	print_r($arr_scoReq);

	$arr_scoNum = [];
	$arr_scoOpera = [];
	// function push number in arr_number and opera into arr_opera group by cou_id
	foreach ($arr_scoReq as $i) {
		$found = false;
		$foundIndex = -1;
		foreach ($arr_scoNum as $key=>$res) {
			if ($res['cou_id'] == $i['cou_id'])  {
				$foundIndex = $key;
				$found = true;
			}
		}

		if ($foundIndex > -1 && !in_array($i['number'], $arr_scoNum[$foundIndex]['arr_number'])  ) {
			array_push($arr_scoNum[$foundIndex]['arr_number'], $i['number']);
		}

		if (!$found) {//'arr_opera' => [$i['opera']]
			array_push($arr_scoNum, array( 'cou_id' => $i['cou_id'],
											'req_number' => array('req_id' =>$i['req_id'], 'arr_number' => [$i['number']] ,'andwith' => $i['andwith'])));

		}
	}
//
	print_r($arr_scoNum);
	die();
	// Function check and or as way for compare between arr_number and arr_opera. Get cou_id if arr_number into item of arr_opera
	foreach($arr_scoNum as $scoNum){
		foreach($scoNum['arr_opera'][0] as $arr_opera )
		{
			if($arr_opera != null)
			{
				sort($scoNum['arr_number']);
				$combera = array_diff($arr_opera,$scoNum['arr_number']);
//				print_r($combera);
				if($combera == null){
					array_push($arr_couidUni,$scoNum['cou_id']);
				}
			}
		}
	}
	$arr_couidUni = array_unique($arr_couidUni);
//	print_r($arr_couidUni);
	// Display university and courese
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

