<?php
require_once 'dbConnection.php';
switch($_GET["operType"]){

	/********************** Ankita Code Starts Here**************/
	case "getActivityNameList":
		$query = "SELECT activity_id,activity_name FROM tbl_activity_master WHERE active_status=0";
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
	case "getGateEntryCode":
	    $query = "SELECT gate_entry_code as gate_entry_code FROM tbl_inward_gate_entry order by gate_entry_id desc limit 1";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getReferenceNoList":
		$query = "select purchase_document_number from tbl_sap_po_details group by purchase_document_number";
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
	
	case "getDeliveryNoList":
		$query = "select delivery_number from tbl_packing_list group by delivery_number";
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

	case "getPOSupplierName":
		$purchase_document_number = $_GET['purchase_document_number'];
		$query = "SELECT distinct vendor_name FROM tbl_sap_po_details
				  where purchase_document_number = '".$purchase_document_number."';";
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


	case "getPOMaterialList":
		$purchase_document_number = $_GET['purchase_document_number'];

		$query1 = "SELECT supplier_invoice_no from tbl_mrr_head";
		$result1 = mysqli_query($dbCon,$query1);
		$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

		$query12 = "SELECT mrr_id from tbl_mrr_head where supplier_invoice_no='".$purchase_document_number."' ORDER BY mrr_id desc LIMIT 1"; 
		$result12 = mysqli_query($dbCon,$query12);
		$row12 = $result12->fetch_assoc();

		if($row1['supplier_invoice_no'] == $purchase_document_number){


			$query11= " SELECT distinct tmm.mrr_balance_quantity,mm.material_id,mm.material_description,mm.unit_of_measurment as unit_of_measurement,mm.material_name ,mm.material_code as material_number,tspd.sap_po_details_id,tspd.purchase_document_number,tspd.material_number,tspd.material_description,tspd.unit_of_measurement,tspd.po_quantity as quantity,tspd.moving_price
           from tbl_mrr_head tmh,tbl_mrr_material tmm,tbl_material_master mm,tbl_sap_po_details tspd
           where tmm.material_id=mm.material_id and tmm.material_number = tspd.material_number and tmm.mrr_id=".$row12['mrr_id']." and tmh.supplier_invoice_no='".$purchase_document_number."'";

         //  echo $query11;

			/*$query2="SELECT mrr_id from tbl_mrr_head where supplier_invoice_no= '".$purchase_document_number."' ORDER BY mrr_id desc LIMIT 1";
			$result2 = mysqli_query($dbCon,$query2);
			$row2 = $result2->fetch_assoc();

			$query3="SELECT material_number,mrr_balance_quantity from tbl_mrr_material where mrr_id='".$row2['mrr_id']."'";
			$result3 = mysqli_query($dbCon,$query3);
			$row3 = $result3->fetch_assoc();

			$query4=" SELECT spd.material_number,spd.unit_of_measurement,spd.material_description from tbl_sap_po_details spd,tbl where material_number='".$row3['material_number']."'";
			$result4 = mysqli_query($dbCon,$query4);
			$row4 = $result4->fetch_assoc();

$query = "SELECT sap_po_details_id,purchase_document_number,material_number,material_description,unit_of_measurement,po_quantity as quantity,moving_price
                FROM tbl_sap_po_details
				  where purchase_document_number = '".$purchase_document_number."';";

*/
	 $result = mysqli_query($dbCon,$query11);
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
		}
         
else{
    


		$query = "SELECT sap_po_details_id,purchase_document_number,material_number,material_description,unit_of_measurement,po_quantity as quantity,moving_price
                FROM tbl_sap_po_details
				  where purchase_document_number = '".$purchase_document_number."';";

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
	}
	break;

	case "getDeliveryList":
		$delivery_number = $_GET['delivery_number'];
		$query = "SELECT material_number, material_description, quantity FROM tbl_packing_list where delivery_number ='".$delivery_number."';";
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

	case "getReturnContractorName":
		$material_return_number = $_GET['material_return_number'];
		$query = "SELECT rc.materia_return_date,pm.project_name,pm.project_id,am.activity_name,sm.site_name,cm.contractor_name,rc.material_return_code as purchase_document_number FROM tbl_return_contractor rc,tbl_activity_master am,
tbl_contractor_master cm,tbl_project_master pm,tbl_site_master as sm where 
rc.project_id = pm.project_id and rc.activity_id = am.activity_id and
 sm.site_id = rc.site_id and cm.contractor_id = rc.contractor_id and material_return_code='".$material_return_number."';";
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

case "getReturnContractorMaterialList":
		$material_return_number = $_GET['material_return_number'];

		$returnID = "Select return_contractor_id from tbl_return_contractor where material_return_code='".$material_return_number."';";
      $result = mysqli_query($dbCon,$returnID);
       $row = mysqli_fetch_array($result,MYSQLI_ASSOC);


		$query = "SELECT rcm.material_issue_number,rcm.material_number as material_name,rcm.material_description,rcm.issued_qty,
rcm.consumed_qty as actual_quantity,rcm.balance_qty,mm.unit_of_measurment
,rcm.return_qty as quantity,rcm.reason_return FROM tbl_return_contractor_material rcm,tbl_material_master as mm where rcm.material_number=mm.material_code and return_contractor_id= ".$row['return_contractor_id'].";";
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

case "getReturnContractorMaterialListForInward":
		$material_return_number = $_GET['material_return_number'];

		$returnID = "Select return_contractor_id from tbl_return_contractor where material_return_code='".$material_return_number."';";
      $result = mysqli_query($dbCon,$returnID);
       $row = mysqli_fetch_array($result,MYSQLI_ASSOC);


		$query = "SELECT distinct rcm.material_issue_number,rcm.material_number,rcm.material_description,rcm.issued_qty,
rcm.consumed_qty as actual_quantity,rcm.balance_qty,mm.unit_of_measurment
,rcm.return_qty as quantity,rcm.reason_return FROM tbl_return_contractor_material rcm,tbl_material_master as mm where rcm.material_number=mm.material_code and return_contractor_id= ".$row['return_contractor_id'].";";
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



	case "getGateEntryList":
		$query = "SELECT gate_entry_id,gate_entry_code,date_format(inward_date, '%d-%m-%Y') as inward_date,inventory_type_id,reference_number,supplier_name,transporter_name,vehicle_no,status,inward_time,outward_time,challan_date,challan_no FROM tbl_inward_gate_entry;";
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

	case "getgateEntryDetailsView":
		$gate_entry_id = $_GET['gate_entry_id'];

		$query = "SELECT gate_entry_id,pr.project_id,st.store_id as store_id,gate_entry_code,inward_date,supplier_name,transporter_name,inventory_type_id,inward_time,lr_no,vehicle_no,reference_number,outward_time,challan_date,total_no_pkg as ttl_no_pkg,challan_no FROM tbl_inward_gate_entry, tbl_project_master pr,tbl_store_master st where tbl_inward_gate_entry.project_id=pr.project_id and tbl_inward_gate_entry.store_id=st.store_id and gate_entry_id= '".$gate_entry_id."';";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getGateEntryMaterials":
		$gate_entry_id = $_GET['gate_entry_id'];
$query11 = "SELECT reference_number from tbl_inward_gate_entry where gate_entry_id='".$gate_entry_id."' ORDER BY reference_number desc LIMIT 1"; 
		$result11 = mysqli_query($dbCon,$query11);
		$row11 = $result11->fetch_assoc();

$query12 = "SELECT mrr_id from tbl_mrr_head where supplier_invoice_no='".$row11['reference_number']."' ORDER BY mrr_id desc LIMIT 1"; 
		$result12 = mysqli_query($dbCon,$query12);
		$row12 = $result12->fetch_assoc();

/*$query13 = "SELECT mrr_balance_quantity from tbl_mrr_material where mrr_id='".$row12['mrr_id']."' ORDER BY mrr_id desc LIMIT 1"; 
		$result13 = mysqli_query($dbCon,$query13);
		$row13 = $result13->fetch_assoc();
*/

		echo $query = "SELECT tim.material_number,tim.material_description,tim.unit_of_measurement as unit_of_measurment,tim.unitprice
 as moving_price,tim.quantity as quantity,tim.challan_qty as challan_quantity,tmm.mrr_balance_quantity FROM 
 tbl_inward_gate_entry_material as tim,tbl_mrr_material tmm where tim.gate_entry_id='".$gate_entry_id."' and tmm.mrr_id='".$row12['mrr_id']."';";


		/*$query = "SELECT material_number,material_description,unit_of_measurement as unit_of_measurment,unitprice as moving_price,quantity as quantity,challan_qty as challan_quantity,po_balance_qty as balance_quantity FROM tbl_inward_gate_entry_material where gate_entry_id= '".$gate_entry_id."';";*/
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

	case "getInventoryTypeList":
		$query = "SELECT inventory_type_id,inventory_type_name FROM tbl_inventory_type";
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
		$query = "SELECT project_id,project_name FROM tbl_project_master where active_status=0";
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

	case "getCustomerNameList":
		$query = "SELECT customer_id,customer_name FROM tbl_customer_master";
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

	case "getContractorList":
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
		$query = "SELECT store_id,store_name FROM tbl_store_master where active_status=0";
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

	case "getStoreName":
	$project_id = $_GET['s_project_id'];
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

	case "getStoreList":
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

	case "getStoreListConsumption":
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



	case "getStoreName1":
	$project_id = $_GET['d_project_id'];
	    $query = "SELECT store_id,store_name FROM tbl_store_master where project_id='".$project_id."';";
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

	case "getContractorName":

	    $query = "SELECT contractor_id,contractor_name FROM tbl_contractor_master;";
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

	case "getContractorName1":

	    $query = "SELECT contractor_id,contractor_name FROM tbl_contractor_master;";
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
	$project_id = $_GET['project_id'];
	    $query = "SELECT site_id,site_name,site_location FROM tbl_site_master where project_id='".$project_id."';";
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

	case "getOutwardGECode":
	    $query = "SELECT outward_ge_code as outward_ge_code FROM tbl_outward_gate_entry order by outward_gate_entry_id desc limit 1";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getOutwardGateEntryList":
		$query = "SELECT outward_gate_entry_id,outward_ge_code,date_format(outward_date, '%d-%m-%Y') as outward_date,cn.contractor_name,transporter_name,vehicle_no,status,outward_time FROM tbl_outward_gate_entry ge,tbl_contractor_master cn where ge.contractor_id=cn.contractor_id;";
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

	case "getOutwardGateEntryDetails":
		$outward_gate_entry_id = $_GET['outward_gate_entry_id'];
		$query = "SELECT outward_gate_entry_id,pr.project_id,st.store_id,outward_ge_code,outward_date,cn.contractor_id,cn.contractor_name,transporter_name,inward_time,lr_no,vehicle_no
                 FROM tbl_outward_gate_entry, tbl_project_master pr,tbl_store_master st,tbl_contractor_master cn
                 where tbl_outward_gate_entry.project_id=pr.project_id and tbl_outward_gate_entry.store_id=st.store_id and tbl_outward_gate_entry.contractor_id=cn.contractor_id and outward_gate_entry_id='".$outward_gate_entry_id."';";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;

	break;


	case "getIndentListContractor":
		$query = "SELECT indent_id,indent_code, project_id
                 FROM indent_head";
        /*echo $query;*/
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

	case "getIndentMaterialListIssue":
		$indent_code = $_GET['indent_code'];
		$query = /*"select material.*,mm.material_name,head.project_id,head.activity_id,head.site_id,sm.store_name,sm.store_id
				from indent_head as head, indent_material as material,tbl_material_master as mm,tbl_store_master as sm
				where head.indent_id = material.indent_id and sm.project_id = head.project_id
				and material.material_id = mm.material_id
				and head.indent_code='".$indent_code."';";*/
"SELECT activity.activity_name,site.site_location,pm.project_id,tsm.store_id,tcm.contractor_id from tbl_activity_master as activity,tbl_site_master as site,
indent_head as indent,tbl_project_master as pm,tbl_store_master as tsm,tbl_contractor_master as tcm
where indent.activity_id=activity.activity_id and site.site_id=indent.site_id and pm.project_id=indent.project_id and tsm.store_id=indent.store_id and tcm.contractor_id=indent.contractor_id and indent.indent_status='approved' 
and indent.indent_code='".$indent_code."';";
			$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

case "getIndentMaterialListIssue1":
		$indent_code= $_GET['indent_code'];
		$indentId = "select indent_id  from indent_head where indent_status='approved' and  indent_code ='".$indent_code."';";
      $result = mysqli_query($dbCon,$indentId);
       $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$query = "SELECT indent.approved_total_qty,material.material_code,material.material_name,material.unit_of_measurment,indent.indent_remaining_qty from indent_material as indent,indent_head as head,tbl_material_master as material
				where material.material_id=indent.material_id
                and head.indent_id=indent.indent_id 
				and indent.indent_id=".$row['indent_id'].";";
				//echo $query;
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


/*case "getStoreInventoryMaterialStock":
		$indent_id= $_GET['indent_id'];
	$materialNumber = "select material_code as material_number from indent_material where  indent_id=".$indent_id.";";
      $result1 = mysqli_query($dbCon,$materialNumber);
      $main_array1 =[];
      while($stock = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {   
			foreach($stock as $key => $value) { 
				$arr[$key] = $value;
			}
			$main_array1[] = $arr;
		}
      // $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
     //  echo $row1;

        // angular.forEach($scope.materialNumber, function(){
for($i=0;$i<sizeof($main_array1);$i++){
echo $stock1 ="select remaining_qty from tbl_store_inventory where material_number='".$main_array1[$i]['material_number']."' ;";
      $result2 = mysqli_query($dbCon,$stock1);
    //  echo $stock;
      // $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
             $main_array3 =[];
		while($stock5 = mysqli_fetch_array($result2,MYSQLI_ASSOC)) {   
			foreach($stock5 as $key => $value) { 
				$arr[$key] = $value;
			}
			$main_array3[] = $arr;
		}
		$json=json_encode($main_array3); 
		header('Content-Type: application/json');
		echo $json;
         }
	break;
*/


	case "getMaterialIssueNumber":
	    $query = "SELECT material_issue_number as material_issue_number FROM tbl_contractor_inventory order by contractor_inventory_id desc limit 1";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getMaterialIssueList":
		$query = "SELECT * ,inv.contractor_inventory_id,con.contractor_name,ind.indent_code
					FROM tbl_contractor_inventory as inv,tbl_contractor_master as con,indent_head as ind
					where con.contractor_id = inv.contractor_id
					and ind.indent_id = inv.indent_id;";
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

	case "getIssueCodeList":
		$query = "SELECT material_issue_number,contractor_inventory_id FROM tbl_contractor_inventory;";
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

	case "getIssueMaterialList":
		$contractor_inventory_id = $_GET['contractor_inventory_id'];
		$query = "select mm.material_code,mm.material_description,mm.unit_price,cm.issued_qty
from tbl_material_master mm,tbl_contractor_inventory_material cm where 
cm.material_id=mm.material_id and contractor_inventory_id='".$contractor_inventory_id."';";
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

	case "getMaterialIssueDetails":
	$contractor_inventory_id = $_GET['contractor_inventory_id'];
		$query = "SELECT con.contractor_inventory_id,con.material_return_code,con.material_return_date,con.material_issue_number,con.material_issue_date,ind.indent_code,store.store_id,store.store_name,activity.activity_name,project.project_id,project.project_name,con.contractor_id,con.challan_no,con.inventory_type,con.loc_no,con.issued_to,con.remark,site.site_location,con.issued_to_name FROM tbl_contractor_inventory as con,indent_head as ind,
            tbl_activity_master as activity,tbl_site_master as site,tbl_project_master as project ,tbl_store_master as store where project.project_id=con.project_id and store.store_id=con.store_id and con.indent_id = ind.indent_id and activity.activity_id=con.activity_id and site.site_id=con.site_id
			and con.contractor_inventory_id =".$contractor_inventory_id.";";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getIssueData":
	$contractor_inventory_id = $_GET['contractor_inventory_id'];
		$query = "SELECT contractor_inventory_id,material_issue_number as contractor_inventory_id,inventory_type FROM tbl_contractor_inventory where contractor_inventory_id = '".$contractor_inventory_id."';";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getReturnDetails":
		$material_return_code = $_GET['material_return_code'];
		$query = "SELECT rc.material_return_code,rc.materia_return_date as material_return_date,pro.project_name,tsm.site_name,
tam.activity_name,tcm.contractor_name,rc.return_remarks as remarksReturn,rc.material_consumption_id as material_consumption_code
  FROM tbl_return_contractor as rc,tbl_project_master as pro,
tbl_site_master as tsm,tbl_activity_master as tam,tbl_contractor_master as tcm 
where rc.project_id = pro.project_id and rc.site_id = tsm.site_id and
 rc.activity_id = tam.activity_id and rc.contractor_id = tcm.contractor_id and material_return_code='".$material_return_code."';";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

case "getIssueListView":
$contractor_inventory_id = $_GET['contractor_inventory_id'];
		$query = "SELECT cm.inventory_material_id,cm.material_number as material_code,cm.issued_qty,cm.indent_qty as approved_total_qty,mm.material_name,cm.consumed_qty,mm.material_id,mm.unit_of_measurment,indent_qty-issued_qty as indent_remaining_qty FROM tbl_contractor_inventory_material as cm,tbl_material_master as mm
			     where cm.material_id = mm.material_id
                 and contractor_inventory_id = ".$contractor_inventory_id.";";
		
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


	case "getReturnListView":

		$material_return_code = $_GET['material_return_code'];

		$returnID = "Select return_contractor_id from tbl_return_contractor where material_return_code='".$material_return_code."';";
      $result = mysqli_query($dbCon,$returnID);
       $row = mysqli_fetch_array($result,MYSQLI_ASSOC);


		$query = "SELECT rcm.material_issue_number,rcm.material_number as material_name,rcm.material_description,rcm.issued_qty,
rcm.consumed_qty as actual_quantity,rcm.balance_qty,mm.unit_of_measurment
,rcm.return_qty,rcm.reason_return FROM tbl_return_contractor_material rcm,tbl_material_master as mm where rcm.material_number=mm.material_code and return_contractor_id= ".$row['return_contractor_id'].";";
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

	case "getMaterialReturnCode":
	    $query = "SELECT material_return_code
				  FROM tbl_return_contractor order by CAST(SUBSTR(material_return_code,11) AS UNSIGNED) desc limit 1";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getMaterialreturnList":
		$query = "SELECT rc.material_return_code,rc.materia_return_date as material_return_date,pro.project_name,tsm.site_name,
tam.activity_name,tcm.contractor_name
  FROM tbl_return_contractor as rc,tbl_project_master as pro,
tbl_site_master as tsm,tbl_activity_master as tam,tbl_contractor_master as tcm 
where rc.project_id = pro.project_id and rc.site_id = tsm.site_id and rc.activity_id = tam.activity_id and rc.contractor_id = tcm.contractor_id";
					
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

	case "getTransferCodeList":
		$query = "SELECT transfer_code as reference_number FROM tbl_mtn_head;";
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

	case "getTransferMaterialList":
		$reference_number = $_GET['reference_number'];
		$query = "SELECT distinct mm.material_id,mm.material_code,mm.material_name,mm.material_description,mat.transfer_quantity as billing_quantity,mm.unit_price as net_value,mat.mtn_material_id
                FROM import_excel,tbl_material_master as mm,tbl_mtn_head as mtn,tbl_mtn_material as mat
				  where  mm.material_id=mat.material_id
                  and mtn.mtn_id = mat.mtn_id
                  and transfer_code ='".$reference_number."';";
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

	case "getIndentCodeList":
		$query = "SELECT indent_code as reference_number FROM indent_head";
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
		$reference_number = $_GET['reference_number'];
		$query = "SELECT distinct mm.material_id,mm.material_code,mm.material_name,mm.unit_of_measurment,mm.material_description,mat.approved_total_qty as billing_quantity,mm.unit_price as net_value,mat.indent_material_id
                FROM import_excel,tbl_material_master as mm,indent_head as ind,indent_material as mat
				  where  mm.material_id=mat.material_id
                  and ind.indent_id = mat.indent_id
                  and indent_code ='".$reference_number."';";
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

	case "getMaterialCodeDetails":
	$material_code = $_GET['material_code'];
	$query = "SELECT material.material_id,material.material_code,material.material_name,material.unit_price as net_value ,material.material_name,material.material_description,material.min_quantity,material.unit_of_measurment,indent.current_stock from tbl_material_master material left join indent_material indent on material.material_id=indent.material_id where material.material_code='".$material_code."'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	/********************** Ankita Code Ends Here**************/

	

	/********************** Amit W Code Starts Here**************/
	case "getGateEntryCodeList":
		$query = "SELECT gate_entry_id,gate_entry_code FROM tbl_inward_gate_entry where mrr_status=0";
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

case "getStorageLocationList":
	$project_id = $_GET['project_id'];
	$store_id = $_GET['store_id'];
	$query = "Select storage_location_code from tbl_storage_location_master where project_id=".$project_id." and store_id=".$store_id."";

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


	case "getGateEntryData":
	$gate_entry_id = $_GET['gate_entry_id'];
	$query = "SELECT ge.gate_entry_id,ge.gate_entry_code as gate_entry_id,project.project_name,ge.project_id,ge.store_id,store.store_name,ge.supplier_name,ge.inventory_type_id,tit.inventory_type_name  as inventory_type_id,ge.transporter_name,ge.vehicle_no,ge.reference_number as supplier_invoice_no,ge.lr_no,ge.challan_no as challan_no,ge.challan_date as challan_date,ge.total_no_pkg as ttl_no_pkg from tbl_inward_gate_entry ge,tbl_project_master project,tbl_store_master store,tbl_inventory_type tit where ge.project_id=project.project_id and ge.store_id=store.store_id and tit.inventory_type_id = ge.inventory_type_id and gate_entry_id=".$gate_entry_id."";

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

	case "getMaterialDescriptionList":
	$gate_entry_id = $_GET['gate_entry_id'];
	$query = "SELECT inward_ge_material_id,material_id, material_number, material_description, unitprice as moving_price,quantity,unit_of_measurement,challan_qty,po_balance_qty FROM tbl_inward_gate_entry_material where gate_entry_id='".$gate_entry_id."'";

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

	case "getMRRCode":
		$query = "SELECT mrr_code as mrr_code FROM tbl_mrr_head ORDER BY mrr_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $mrr_code = $row['mrr_code'];
	break;

	case "getMRCode":
		$query = "SELECT material_rejection_code as material_rejection_code FROM tbl_mrr_head ORDER BY material_rejection_code DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $material_rejection_code = $row['material_rejection_code'];
	break;

	case "getMRRList":
		$query = "SELECT mh.mrr_id,mh.mrr_code,mh.gate_entry_id,mm.gate_entry_code,mh.material_rejection_code,date_format(mh.mrr_date, '%d-%m-%Y') as mrr_date,date_format(mh.rejection_date, '%d-%m-%Y') as rejection_date,mh.inventory_type_id,mh.total_quantity,mh.total_rejected_quantity,mh.total_accepted_quantity,mh.rejection_status FROM tbl_mrr_head mh,tbl_inward_gate_entry mm where mh.gate_entry_id=mm.gate_entry_id;";
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

	case "getMrrDetails":
		$mrr_id = $_GET['mrr_id'];
		$query = "SELECT mh.mrr_id,mh.mrr_code,ge.gate_entry_id,ge.gate_entry_code,mh.material_rejection_code,mh.gate_entry_id,pr.project_name,st.store_name,mh.inventory_type_id,date_format(mh.mrr_date, '%d-%m-%Y') as mrr_date,mh.supplier_name,mh.supplier_invoice_no,mh.location_of_despatch,ge.transporter_name,ge.vehicle_no,ge.lr_no,ge.challan_no,ge.challan_date,ge.total_no_pkg as ttl_no_pkg,mh.remark,mh.material_rejection_code,mh.rejection_status FROM tbl_mrr_head mh left join tbl_inward_gate_entry ge on mh.gate_entry_id=ge.gate_entry_id left join tbl_project_master pr on pr.project_id=ge.project_id left join tbl_store_master st on st.store_id=ge.store_id
                 where mrr_id= '".$mrr_id."';";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getMrrMaterials":
		$mrr_id = $_GET['mrr_id'];
		$query = "SELECT ge.material_number,ge.material_description,date_format(mm.expiry_date, '%d-%m-%Y') as expiry_date,ge.quantity,ge.challan_qty,ge.po_balance_qty,mm.accepted_quantity,mm.rejected_quantity,ge.unit_of_measurement,mm.location_of_disp as storage_location_code from tbl_mrr_material mm,tbl_inward_gate_entry_material ge where ge.inward_ge_material_id=mm.inward_ge_material_id and mm.mrr_id='".$mrr_id."';";
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

	case "getMrMaterials":
		$mrr_id = $_GET['mrr_id'];
		$query = "select ge.material_number,ge.material_description,mm.expiry_date,ge.quantity,mm.accepted_quantity,mm.rejected_quantity,ge.unit_of_measurement,mm.reason_for_rejection from tbl_mrr_material mm,tbl_inward_gate_entry_material ge where ge.inward_ge_material_id=mm.inward_ge_material_id and mm.rejected_quantity>0 and mm.mrr_id='".$mrr_id."';";
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


	case "getMaterialRejectList":
		$query = "SELECT mh.mrr_id,mh.mrr_code,ge.gate_entry_code,mh.material_rejection_code,date_format(mh.rejection_date, '%d-%m-%Y') as rejection_date,mh.total_quantity,mh.total_rejected_quantity,mh.rejection_status from tbl_gate_entry ge,tbl_mrr_head mh where mh.gate_entry_id=ge.gate_entry_id and mh.total_rejected_quantity>'0' ORDER BY mh.mrr_code DESC;";
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

	case "getMTNCode":
		$query = "SELECT transfer_code as transfer_code FROM tbl_mtn_head ORDER BY mtn_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $transfer_code = $row['transfer_code'];
	break;

	case "getMTNSList":
		$query = "SELECT mh.mtn_id,mh.transfer_code,mh.transfer_type,date_format(mh.transfer_date, '%d-%m-%Y') as transfer_date,pr.project_name as s_project_name, st.store_name as s_store_name,ct.contractor_name as s_contractor_name,pro.project_name as d_project_name,sto.store_name as d_store_name,cto.contractor_name as d_contractor_name FROM tbl_mtn_head mh left join tbl_project_master pr on mh.s_project_id=pr.project_id left join tbl_store_master st on mh.s_store_id=st.store_id left join tbl_contractor_master ct on mh.s_contractor_id=ct.contractor_id left join tbl_project_master pro on mh.d_project_id=pro.project_id left join tbl_store_master sto on mh.d_store_id=sto.store_id left join tbl_contractor_master cto on mh.d_contractor_id=cto.contractor_id ORDER BY mtn_id ASC;";
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

	case "getMaterialTransferDetails":
	$materialTransfer = $_GET['materialTransfer'];
	$query = "SELECT mi.store_inventory_id,mi.material_id,mi.material_number,mi.issued_qty from tbl_material_master mi where mi.materialTransfer='".$materialTransfer."'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	// case "getStoreData":
	// $store_id = $_GET['s_store_id'];
	// $query = "select material_number, issued_qty from tbl_store_inventory where store_id='".$store_id."'";

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
	// 	//echo $query;
	// break;
	
	case "getStoreData":
	$store_id = $_GET['s_store_id'];
		$query = "select st.store_inventory_id,st.material_id,st.material_number,mt.material_description,mt.unit_of_measurment, st.issued_qty from tbl_store_inventory st,tbl_material_master mt where st.material_id=mt.material_id and store_id='".$store_id."'";
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

	case "getContractorData":
	$store_id = $_GET['s_store_id'];
	$contractor_id = $_GET['s_contractor_id'];
		$query = "SELECT ctm.material_id,ctm.contractor_inventory_id,mm.material_description,ctm.material_number,ctm.issued_qty 
from tbl_contractor_inventory_material ctm left join  tbl_contractor_inventory ct 
on ct.contractor_inventory_id=ctm.contractor_inventory_id left join tbl_material_master mm on mm.material_id=ctm.material_id where ct.store_id='".$store_id."' and ct.contractor_id='".$contractor_id."'";
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

	case "getMtnDetails":
		$mtn_id = $_GET['mtn_id'];
		$query = "select mh.transfer_code,date_format(mh.transfer_date, '%d-%m-%Y') as transfer_date,mh.transfer_type,mh.s_project_id,mh.s_store_id,mh.s_contractor_id,mh.d_project_id,mh.d_store_id,mh.d_contractor_id from tbl_mtn_head mh where mtn_id='".$mtn_id."';";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
		//echo $query;
	break;

	case "getMtnStoreMaterials":
		$mtn_id = $_GET['mtn_id'];
		$query = "SELECT material.material_name,material.material_description,st.material_number,st.store_inventory_id,mtn.issued_quantity,mtn.transfer_quantity,mtn.remark FROM shubharambh.tbl_mtn_material as mtn,tbl_material_master as material,
            tbl_store_inventory st  where st.store_inventory_id=mtn.store_inventory_id
            and mtn.material_id=material.material_id and mtn. mtn_id='".$mtn_id."';";
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

	case "getMtnContractorMaterials":
		$mtn_id = $_GET['mtn_id'];
		$query = "SELECT ct.material_number,ct.contractor_inventory_id,m.material_description,ct.issued_qty,mm.transfer_quantity,mm.remark from tbl_mtn_material mm,tbl_contractor_inventory_material ct,tbl_material_master m where ct.contractor_inventory_id=mm.contractor_inventory_id and m.material_id=mm.material_id and mtn_id='".$mtn_id."';";
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
	/********************** Amit W ends Starts Here**************/

	/********************** Suraj B Code Starts Here**************/

	case "getMaterialNameList":
		$query = "SELECT material_id,material_name FROM tbl_material_master";
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
	/********************** Suraj B Code ends Starts Here**************/


/********************** Madhuri Code ends Starts Here**************/
case "getReasonReturn":
        $reason_return = $_GET['reason_return'];
		$query = "SELECT reason_return FROM tbl_contractor_inventory_material WHERE reason_return IS NOT NULL;";
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

case "getMRRStoreList":
		$query = "SELECT mh.mrr_id,mh.mrr_code,mh.gate_entry_id,mm.gate_entry_code,mh.material_rejection_code,date_format(mh.mrr_date, '%d-%m-%Y') as mrr_date,date_format(mh.rejection_date, '%d-%m-%Y') as rejection_date,mh.inventory_type_id,mh.total_quantity,mh.total_rejected_quantity,mh.rejection_status FROM tbl_mrr_head mh,tbl_inward_gate_entry mm where mh.gate_entry_id=mm.gate_entry_id;";
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

	case "getMrrDetails1":
		$mrr_id = $_GET['mrr_id'];
		$query = "SELECT mrr.mrr_code,mrr.mrr_id,mrr.inventory_type_id,mrr.supplier_name,mrr.location_of_despatch,mrr.vehicle_no,mrr.transporter_name,mrr.remark,store.store_id,project.project_id,mrr.supplier_invoice_no 
           FROM tbl_mrr_head mrr
           left join tbl_store_master store on mrr.store_id=store.store_id
           left join tbl_project_master project on mrr.project_id=project.project_id
           where mrr_id= '".$mrr_id."';";

		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getReturnDetailsForStore":
		$mrr_id = $_GET['mrr_id'];
		$query = "SELECT mrr.mrr_id,mrr.return_no,mrr.rejected_return_no,mrr.mrr_code,mrr.supplier_name,mrr.supplier_invoice_no,mrr.location_of_despatch,mrr.vehicle_no,mrr.transporter_name,mrr.remark,mrr.inventory_type_id,project.project_id,store.store_id FROM tbl_mrr_head mrr,tbl_project_master project,tbl_store_master store where mrr.project_id=project.project_id and mrr.store_id=store.store_id and mrr.mrr_id=".$mrr_id."";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getReturnListForStore":
	$mrr_id = $_GET['mrr_id'];
		$query = "SELECT store.material_id,mm.material_code,mm.material_name,mrr.rejected_quantity,mrr.reason_for_rejection,mrr.mrr_material_id,mrr.mrr_id FROM tbl_store_inventory store,tbl_material_master mm, tbl_mrr_material mrr WHERE mm.material_id=store.material_id and mrr.mrr_id='".$mrr_id."';";
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

	case "getMaterialStoreReturnList":
		$query = "SELECT mrr.mrr_id,mrr.return_no,mrr.rejected_return_no,store.store_name,project.project_name FROM tbl_mrr_head mrr,tbl_store_master store,tbl_project_master project WHERE mrr.store_id=store.store_id and mrr.project_id=project.project_id and (mrr.return_no is not null or mrr.rejected_return_no is not null);";
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

	case "getMrrMaterials1":
		$mrr_id = $_GET['mrr_id'];
		$query = "SELECT store.material_id,mm.material_code,mm.material_name,mrr.rejected_quantity,mrr.reason_for_rejection,mrr.mrr_material_id,mrr.mrr_id FROM tbl_store_inventory store,tbl_material_master mm, tbl_mrr_material mrr WHERE mm.material_id=store.material_id and mrr.mrr_id='".$mrr_id."';";
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

case "getMaterialCodeList1":
		$query = "SELECT material_id,material_number FROM tbl_store_inventory";
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

	case "getMaterialReturnCode1":
	    $query = "SELECT return_no FROM tbl_mrr_head order by CAST(SUBSTR(return_no,12) AS UNSIGNED) desc limit 1";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getMaterialReturnCode2":
	    $query = "SELECT rejected_return_no FROM tbl_mrr_head order by CAST(SUBSTR(rejected_return_no,12) AS UNSIGNED) desc limit 1";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getMaterialRejectList1":
		$query = "SELECT mh.mrr_id,mh.mrr_code,mh.material_rejection_code,date_format(mh.rejection_date, '%d-%m-%Y') as rejection_date,mh.total_quantity,mh.total_rejected_quantity,mh.rejection_status from tbl_gate_entry ge,tbl_mrr_head mh where mh.total_rejected_quantity>'0' ORDER BY mh.mrr_code DESC;";
		
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
/*----------------------------------Tarun------------------------------*/

case "getReturnMaterialList":
	$return_no = $_GET['return_no'];

	// $query1 = "SELECT mrr_id FROM tbl_mrr_head where return_no=".$return_no."";
	// $result1 = mysqli_query($dbCon,$query1);
	// $row3 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
	// echo $row3;

	$query1="SELECT mrr_id FROM tbl_mrr_head where return_no=".$return_no."";
	    $result = mysqli_query($dbCon,$query1);
		$row = $result->fetch_assoc();
		$mrr_id = (int) $row['mrr_id'] + 1;	
	$query = "select tmm.mrr_material_id,tmm.return_qty,mm.material_code,mm.material_description,mm.material_id,mm.unit_price
 from tbl_mrr_material tmm,tbl_material_master mm where mrr_id=".$mrr_id.";";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

case "getReturnstoreReferenceList":
		$query = "SELECT return_no FROM tbl_mrr_head;";
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

case "getActivityNameListforConsumption":
	$site_id = $_GET['site_id'];
	    $query = "select am.activity_id,am.activity_name,sm.project_id,sm.site_id,atm.project_id,atm.activity_id
from tbl_activity_master as am,tbl_site_master as sm,tbl_activity_transaction_master as atm
 where sm.project_id=atm.project_id and am.activity_id=atm.activity_id and sm.site_id='".$site_id."';";
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
	$site_id = $_GET['site_id'];
	    $query = "SELECT site_location from tbl_site_master where site_id='".$site_id."';";
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


case "getContractorNameforConsumption":
	$activity_id = $_GET['activity_id'];
	    $query = "select distinct ci.contractor_id,ci.activity_id,cm.contractor_name,cm.contractor_id
from tbl_contractor_inventory as ci,tbl_contractor_master as cm
 where cm.contractor_id=ci.contractor_id and ci.activity_id='".$activity_id."';";
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


case "getDetailsofMaterialIssue":
		$material_issue_number = $_GET['material_issue_number'];
		$query = "select material.*,mm.material_name,head.project_id,head.activity_id,head.site_id,sm.store_name,sm.store_id
				from indent_head as head, indent_material as material,tbl_material_master as mm,tbl_store_master as sm
				where head.indent_id = material.indent_id and sm.project_id = head.project_id
				and material.material_id = mm.material_id
				and head.indent_code ='".$material_issue_number."';";
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


case "getMaterialIssueNumberList":
		$query = "SELECT contractor_inventory_id,material_issue_number,indent_id,store_id,contractor_id,project_id,inventory_type FROM tbl_contractor_inventory";
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

	case "getSiteNameforConsumption":
	    $project_id =$_GET['project_id'];
		$query = "SELECT site_id,site_name FROM tbl_site_master where project_id='".$project_id."';";
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

	case "getMaterialListContractorforConsumption":
		$contractor_id = $_GET['contractor_id'];
		$query = "select distinct ci.contractor_id,ci.contractor_inventory_id, ci.material_issue_number, ci.material_issue_date, ci.loc_no, 
cim.material_number,cim.issued_qty,
cim.material_id,mm.unit_of_measurment, mm.material_description
from tbl_contractor_inventory as ci,tbl_contractor_inventory_material as cim,
tbl_material_master as mm
 where cim.contractor_inventory_id=ci.contractor_inventory_id 
 and mm.material_code=cim.material_number and ci.contractor_id='".$contractor_id."';";
        /*echo $query;*/
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
/*--------------------------------------Tarun-------------------*/
}
?>