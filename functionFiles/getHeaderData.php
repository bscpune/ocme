<?php
require_once 'dbConnection.php';
switch($_GET["operType"]){
	// case "getCountForHeader":
	// 	$query = "SELECT count(indent_status) from indent_head where indent_status='pending'";
	// 	$result = mysqli_query($dbCon,$query);
	// 	$row = $result->fetch_assoc();
	// 	echo $mrr_code = $row['mrr_code'];
	// break;

	case "getPendingIndent":
		$query = "SELECT count(*) as indent_count from indent_head where indent_status='pending'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
			foreach($row as $key => $value) { 
				$arr[$key] = $value;
			}
			$main_array[] = $arr;
		}
		 $json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getMaterialExpiry":
		$query = "SELECT count(*) as material_count FROM tbl_mrr_material WHERE DATEDIFF(expiry_date, NOW()) <= 10";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
			foreach($row as $key => $value) { 
				$arr[$key] = $value;
			}
			$main_array[] = $arr;
		}
		 $json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getExpireMaterialList":
		$query = "SELECT gem.material_number,date_format(mm.expiry_date, '%d-%m-%Y') as expiry_date from tbl_mrr_material mm,tbl_inward_gate_entry_material gem where gem.inward_ge_material_id=mm.inward_ge_material_id and DATEDIFF(expiry_date, NOW()) <= 10";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
			foreach($row as $key => $value) { 
				$arr[$key] = $value;
			}
			$main_array[] = $arr;
		}
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;
}


?>