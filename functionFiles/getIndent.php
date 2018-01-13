<?php
require_once 'dbConnection.php';
switch($_GET["operType"]){

/**************sujata code starts here************************/

// IndentCreation
	

	case "getInternalIndentCode":
		$query = "SELECT indent_code as indent_code FROM indent_head where indent_type='Internal Indent' ORDER BY indent_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $indent_code = $row['indent_code'];
	break;

	case "getExternalIndentCode":
		$query = "SELECT indent_code as indent_code FROM indent_head where indent_type='External Indent' ORDER BY indent_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $indent_code = $row['indent_code'];
	break;

	case "getIndentDetails":
		$indent_id = $_GET['indent_id'];
		$query = "SELECT indent.indent_id,indent.indent_code,indent.indent_date,indent.indent_type,project.project_name,project.manager_name,activity.activity_id,contractor.contractor_id,site.site_location FROM indent_head indent,tbl_project_master project,tbl_activity_master activity,tbl_contractor_master contractor,tbl_site_master site WHERE indent.project_id=project.project_id and indent.activity_id=activity.activity_id and indent.contractor_id=contractor.contractor_id and indent.site_id=site.site_id";
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

	case 'getIndentDetailsforAP':
		$indent_code = $_GET['indent_code'];
		$query = "SELECT ih.indent_id,im.material_id,im.indent_material_id,ih.indent_code,ih.indent_date,p.project_id,si.site_id,act.activity_id,con.contractor_id,ih.indent_type,p.manager_name,ih.remark as remarks,ih.indent_status,tsm.store_id,ih.store_id FROM indent_head as ih,tbl_project_master as p,indent_material as im,tbl_site_master as si,tbl_activity_master as act,tbl_contractor_master as con,tbl_store_master as tsm where ih.indent_id = ih.indent_id AND ih.store_id = ih.store_id AND  im.material_id=im.material_id ANd im.indent_material_id=im.indent_material_id AND ih.project_id =p.project_id AND ih.site_id=si.site_id AND ih.activity_id=act.activity_id AND ih.contractor_id=con.contractor_id AND ih.indent_code='".$indent_code."'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;		
	break;

	case 'getIndentMaterialListforAP':
		$indent_code = $_GET['indent_code'];
		$query1 = "SELECT indent_id FROM indent_head where indent_code='".$indent_code."'";
		$result1 = mysqli_query($dbCon,$query1);
		$row1 = $result1->fetch_assoc();
		
		$query ="SELECT ih.indent_id,im.material_id,im.indent_material_id,im.material_code,mm.material_id,mm.material_name,mm.material_description,mm.unit_of_measurment,im.indent_material_qty,im.approved_total_qty FROM indent_head as ih,
		indent_material as im,tbl_material_master as mm where ih.indent_id=im.indent_id and mm.material_id=im.material_id and ih.indent_id='".$row1['indent_id']."'";
		
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

	case "getProjectNameList":
		$query = "SELECT project_id,project_name,project_code FROM tbl_project_master";
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

	case "getProjectDetails":
	$project_id = $_GET['project_id'];
	$query = "select * from tbl_project_master where project_id='".$project_id."'";
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


	case "getContractorNameList":
		$query = "SELECT contractor_id,contractor_name FROM tbl_contractor_master";
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

	case "getStoreNameList":
		$query = "SELECT store_id,store_name FROM tbl_store_master";
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

//Indent Approval

	case "getSiteLocationList":
		$query = "SELECT site_id,site_location FROM tbl_site_master";
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


case "getMaterialCodeList":
		$query = "SELECT material_id,material_code FROM tbl_material_master";
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

	// case "getMaterialCodeList":
	// 	$query = "SELECT material_code FROM tbl_material_master  WHERE active_status=0";
	// 	$result = mysqli_query($dbCon,$query);
	// 	$main_array =[];
	// 	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
	// 		foreach($row as $key => $value) { 
	// 			$arr[$key] = $value;
	// 		}
	// 		$main_array[] = $arr;
	// 	}
	// 	$json=json_encode($main_array); 
	// 	header('Content-Type: application/json');
	// 	echo $json;
	// break;

	case "getMaterialCodeDetails":
	$material_code = $_GET['material_code'];
	$query = "SELECT material.material_id,material.material_code,material.material_name,material.material_description,material.min_quantity,material.unit_of_measurment,indent.current_stock from tbl_material_master material left join indent_material indent on material.material_id=indent.material_id where material.material_code='".$material_code."'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getMaterialIssuedQty":
	$material_number = $_GET['material_code'];
	$contractor_id = $_GET['contractor_id'];
	$project_id = $_GET['project_id'];
	$site_id = $_GET['site_id'];
	$activity_id = $_GET['activity_id'];
	

	$query = "SELECT SUM(ctm.issued_qty) as issued_qty from tbl_contractor_inventory_material ctm,tbl_contractor_inventory ct where ct.contractor_inventory_id=ctm.contractor_inventory_id and ct.contractor_id='".$contractor_id."' and ct.project_id='".$project_id."' and ct.site_id='".$site_id."' and ct.activity_id='".$activity_id."' and ctm.material_number='".$material_number."'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getMaterialIssuedQty1":
	$material_number = $_GET['material_code'];

	$query = "SELECT SUM(ctm.issued_qty) as issued_qty from tbl_contractor_inventory_material ctm,tbl_contractor_inventory ct where ct.contractor_inventory_id=ctm.contractor_inventory_id and ctm.material_number='".$material_number."'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

case "getMaterialTransferDetails":
	$material_number = $_GET['material_numbermaterial_number'];
	$query = "SELECT material.material_id,material.material_code,material.material_name,material.material_description,material.min_quantity,material.unit_of_measurment,indent.current_stock from tbl_material_master material left join indent_material indent on material.material_id=indent.material_id where material.material_number='".$material_numbermaterial_number."'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

case "getMaterialList":
		$query = "SELECT material.material_id,material.material_code,material.material_name,material.material_description,material.min_quantity,material.unit_of_measurment,material.unit_price,material.expiry_status from tbl_material_master material where material.active_status=0";
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

	case "getIndentMaterialList":
		$indent_id = $_GET['indent_id'];
		$query = "SELECT mm.material_id,mm.unit_of_measurment,mm.approved_total_qty,mm.indent_material_id from indent_material mm left join tbl_material_master material on mm.indent_material_id=material.material_id where mm.indent_material_id=".$material_id."";

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

// Inventory Stock
	case "getMaterialStockList":
	 $project_id = $_GET['project_id'];
	 $store_id = $_GET['store_id'];
	 $contractor_id = $_GET['contractor_id'];
	$inventory_type_id = $_GET['inventory_type_id'];
    $query = "SELECT sto.store_inventory_id,pr.project_name,st.store_name,con.contractor_name,mm.material_code,mm.material_name,mm.material_description,mm.unit_of_measurment,mm.unit_price,mm.expiry_status,sto.inventory_type_id FROM tbl_store_inventory sto,tbl_project_master pr,tbl_store_master st,tbl_contractor_master con,tbl_material_master mm where sto.project_id=pr.project_id and sto.store_id=st.store_id and sto.contractor_id=con.contractor_id and sto.material_id=mm.material_id and pr.project_id=".$project_id." and  st.store_id=".$store_id." and con.contractor_id= ".$contractor_id." and inventory_type_id='".$inventory_type_id."'";

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
		//echo $query;
	break;
case "getMaterialStockListPROSTO":
	 $project_id = $_GET['project_id'];
	// $store_id = $_GET['store_id'];
    $query = "SELECT pr.project_name, str.store_name, st.material_id, st.material_number, st.accepted_quantity, st.remaining_qty, st.inventory_type_id, mm.material_description, mm.expiry_status, mm.unit_of_measurment,mm.unit_price 
	from tbl_store_inventory as st, tbl_material_master as mm, tbl_mrr_material as mrr, tbl_project_master as pr, tbl_store_master as str 
	where st.material_number = mrr.material_number AND mm.material_code = mrr.material_number   
	AND pr.project_id = st.project_id AND str.store_id = st.store_id 
	AND st.project_id = ".$project_id." group by st.material_number ";

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
		//echo $query;
	break;
case "getMaterialStockListPROSTOINV":
	 $project_id = $_GET['project_id'];
	 $store_id = $_GET['store_id'];
	//$inventory_type_id = $_GET['inventory_type_id'];
    $query = "SELECT pr.project_name, str.store_name, st.material_id, st.material_number, st.accepted_quantity, st.remaining_qty, st.inventory_type_id, mm.material_description, mm.expiry_status, mm.unit_of_measurment, mm.unit_price 
	from tbl_store_inventory as st, tbl_material_master as mm, tbl_mrr_material as mrr, tbl_project_master as pr, tbl_store_master as str 
	where st.material_number = mrr.material_number AND mm.material_code = mrr.material_number   
	AND pr.project_id = st.project_id AND str.store_id = st.store_id AND st.project_id = ".$project_id." AND st.store_id = ".$store_id."  group by st.material_number ";

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
		//echo $query;
	break;
case "getMaterialContractorStockList":
	 /*$project_id = $_GET['project_id'];
	 $store_id = $_GET['store_id'];*/
	 $contractor_id = $_GET['contractor_id'];
    $query = "SELECT ci.contractor_inventory_id, con.contractor_name, pr.project_name, st.store_name, inventory_type, cim.material_number,  SUM(cim.issued_qty) as remaining_qty, mm.material_description, mm.unit_of_measurment, mm.unit_price from tbl_contractor_inventory as ci, tbl_contractor_inventory_material as cim, tbl_material_master as mm, tbl_contractor_master as con, tbl_project_master as pr , tbl_store_master as st
		WHERE cim.contractor_inventory_id = ci.contractor_inventory_id AND con.contractor_id = ci.contractor_id AND cim.material_number = mm.material_code AND pr.project_id = ci.project_id AND ci.store_id = st.store_id AND ci.contractor_id = ".$contractor_id." group by cim.material_number ";

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
		//echo $query;
	break;

case "getStoreList":
	    $query = "SELECT store_id,store_name FROM tbl_store_master where active_status=0;";
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



case "getStoreList1":
	$project_id = $_GET['project_id'];
	    $query = "SELECT store_id,store_name FROM tbl_store_master where active_status=0 and project_id='".$project_id."';";
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

/*----------------------------------------Tarun---------------------------*/

case 'getExternalIndentDetailsforAP':
		$indent_code = $_GET['indent_code'];
		$query = "SELECT ih.indent_id,im.material_id,im.indent_material_id,ih.indent_code,ih.indent_date,p.project_id,si.site_id,act.activity_id,con.contractor_id,ih.indent_type,p.manager_name,ih.remark as remarks,ih.indent_status FROM indent_head as ih,tbl_project_master as p,indent_material as im,tbl_site_master as si,tbl_activity_master as act,tbl_contractor_master as con where ih.indent_id = ih.indent_id AND im.material_id=im.material_id ANd im.indent_material_id=im.indent_material_id AND ih.project_id =p.project_id AND ih.site_id=si.site_id AND ih.activity_id=act.activity_id AND ih.contractor_id=con.contractor_id AND ih.indent_code='".$indent_code."'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;		
	break;
case "getExternalIndentList":
		$query = "SELECT ih.indent_id,ih.indent_code,date_format(ih.indent_date, '%d-%m-%Y') as indent_date,pr.project_name,pr.manager_name,ih.indent_type,act.activity_name,con.contractor_name,si.site_location,ih.indent_status,ih.indent_total_qty,ih.approved_total_qty,ih.approved_by
		   FROM indent_head ih,tbl_project_master pr,tbl_activity_master act,tbl_contractor_master con,tbl_site_master si
		   WHERE ih.project_id=pr.project_id and ih.activity_id=act.activity_id and ih.contractor_id=con.contractor_id and ih.site_id=si.site_id and ih.indent_code=ih.indent_code and ih.active_status=0 and ih.indent_type='External Indent' ORDER BY indent_id DESC";  
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
case "getProjectNameList1":
$project_id = $_GET['project_id'];
		$query = "SELECT project_id,project_name,project_code FROM tbl_project_master where project_id='".$project_id."';";
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
case "getSiteNameList":
	$store_id = $_GET['store_id'];
	    $query = "SELECT site_id,site_name,site_location FROM tbl_site_master where store_id='".$store_id."' and active_status=0;";
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

case "getSiteLocation":
	$store_id = $_GET['site_id'];
	    $query = "SELECT site_location FROM tbl_site_master where site_id='".$site_id."' and active_status=0;";
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


	case "getActivityNameList":
	$project_id = $_GET['project_id'];
	    $query = "SELECT ac.activity_id,ac.activity_name,atm.activity_id FROM tbl_activity_master ac,tbl_activity_transaction_master atm where ac.activity_id = atm.activity_id and atm.project_id='".$project_id."';";
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

case "getBOMData":
	$activity_id = $_GET['activity_id'];
	$project_id = $_GET['project_id'];
	$site_id = $_GET['site_id'];

	    $query = "SELECT bom_id,bom_name,soil_type,tower_type,bom_number FROM tbl_bom_master where activity_id='".$activity_id."' and project_id='".$project_id."' and site_id='".$site_id."';";
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

	case "getBOMDataMaterial":
	$bom_id = $_GET['bom_id'];
	

	    $query = "SELECT material_id,material_code,material_description,required FROM tbl_bom_material where bom_id='".$bom_id."';";
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

	case "getInternalIndent":
		$query = "SELECT indent_code as indent_code FROM indent_head order by indent_code desc limit 1 ";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;


	case "getActivityNameList1":
		$query = "SELECT activity_id,activity_name FROM tbl_activity_master";
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

	case "getActivityNameList2":
		$query = "SELECT activity_id,activity_name FROM tbl_activity_master";
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

	case "getSiteNameList1":
		$query = "SELECT site_id,site_name FROM tbl_site_master where active_status=0";
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

	case "getIndentList":
		$query = "SELECT ih.indent_id,ih.indent_code,date_format(ih.indent_date, '%d-%m-%Y') as indent_date,pr.project_name,pr.manager_name,ih.indent_type,act.activity_name,con.contractor_name,si.site_location,ih.indent_status,ih.indent_total_qty,ih.approved_total_qty,ih.approved_by
		   FROM indent_head ih,tbl_project_master pr,tbl_activity_master act,tbl_contractor_master con,tbl_site_master si
		   WHERE ih.project_id=pr.project_id and ih.activity_id=act.activity_id and ih.contractor_id=con.contractor_id and ih.site_id=si.site_id and ih.indent_code=ih.indent_code and ih.active_status=0 and ih.indent_type='Internal Indent' ORDER BY indent_id DESC";  
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

	case "getIndentListforApproval":
		$query = "SELECT ih.indent_id,ih.indent_code,date_format(ih.indent_date, '%d-%m-%Y') as indent_date,pr.project_name,pr.manager_name,ih.indent_type,act.activity_name,con.contractor_name,si.site_location,ih.indent_status,ih.indent_total_qty,ih.approved_total_qty,ih.approved_by
		   FROM indent_head ih,tbl_project_master pr,tbl_activity_master act,tbl_contractor_master con,tbl_site_master si
		   WHERE ih.project_id=pr.project_id and ih.indent_type='Internal Indent' and ih.activity_id=act.activity_id and ih.contractor_id=con.contractor_id and ih.site_id=si.site_id and ih.indent_code=ih.indent_code and ih.active_status=0 ORDER BY indent_id DESC";  
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

	/*case "getIndentListforupdate":
		$query = "SELECT ih.indent_id,ih.indent_code,date_format(ih.indent_date, '%d-%m-%Y') as indent_date,pr.project_name,pr.manager_name,ih.indent_type,act.activity_name,con.contractor_name,si.site_location,ih.indent_status,ih.indent_total_qty,ih.approved_total_qty,ih.approved_by
		   FROM indent_head ih,tbl_project_master pr,tbl_activity_master act,tbl_contractor_master con,tbl_site_master si
		   WHERE ih.project_id=pr.project_id and ih.activity_id=act.activity_id and ih.contractor_id=con.contractor_id and ih.site_id=si.site_id and ih.indent_code=ih.indent_code and ih.active_status=0 ORDER BY indent_id DESC";  
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
	break;*/

	case 'getIndentListforupdate':
		$indent_code = $_GET['indent_code'];
		$query = "SELECT ih.indent_id,im.material_id,im.indent_material_id,ih.indent_code,ih.indent_date,p.project_id,si.site_id,act.activity_id,ih.bom_id,con.contractor_id,ih.indent_type,p.manager_name,ih.soil_type,ih.tower_type,ih.bom_name,ih.bom_code,tsm.store_id,ih.store_id FROM indent_head as ih,tbl_project_master as p,indent_material as im,tbl_site_master as si,tbl_activity_master as act,tbl_contractor_master as con,tbl_store_master as tsm where ih.indent_id = ih.indent_id AND im.material_id=im.material_id ANd im.indent_material_id=im.indent_material_id AND ih.project_id =p.project_id AND ih.site_id=si.site_id AND ih.store_id=si.store_id AND ih.activity_id=act.activity_id AND ih.contractor_id=con.contractor_id AND ih.indent_code='".$indent_code."'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;		
	break;

case 'getIndentListMaterialforupdate':
		$indent_code = $_GET['indent_code'];
		$query1 = "SELECT indent_id FROM indent_head where indent_code='".$indent_code."'";
		$result1 = mysqli_query($dbCon,$query1);
		$row1 = $result1->fetch_assoc();
		
		$query ="SELECT ih.indent_id,im.material_id,im.indent_material_id,im.material_code,mm.material_id,mm.material_name,mm.material_description,mm.unit_of_measurment,im.indent_material_qty,im.issued_qty FROM indent_head as ih,
		indent_material as im,tbl_material_master as mm where ih.indent_id=im.indent_id and mm.material_id=im.material_id and ih.indent_id='".$row1['indent_id']."'";
		
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


/*--------------------------------------Tarun-----------------------------*/










}







?>	