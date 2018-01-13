<?php
require_once 'dbConnection.php';
switch($_GET["operType"]){

	/*********************Saurabh*********************************/
	case "getProjectCount":
		$query = "SELECT count(*) as project_count FROM tbl_project_master WHERE active_status=0";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $project_count = $row['project_count'];
	break;

	/*case 'gettotal_sites':
		$query = "SELECT count(*) as total_sites FROM tbl_site_master WHERE active_status=0";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $total_sites = $row['total_sites'];
		break;*/

	case 'getUserCount':
		$query = "SELECT count(*) as total_user from tbl_user_master";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $UserCount = $row['total_user'];
		break;
	

	/******************************************************************/

	/*****************  Amit w code starts here  ********************/
	
case "getCountryList":
		$query = "SELECT Distinct country_name FROM tbl_country_state";
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
	case "getStateList":
	$country_name = $_GET['country_name'];
		$query = "SELECT state_name FROM tbl_country_state WHERE country_name='".$country_name."';";
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
		$query = "SELECT activity_id,activity_name FROM tbl_activity_master WHERE active_status=0 ";
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
		//Customer Master

	case "getCustomerList":

		$query = "select customer.customer_id,customer.customer_sap_code,customer.customer_code,customer.customer_name,customer.address1,customer.address2,customer.address3,customer.city,customer.pin_code,customer.state_name,customer.gst_no,customer.country_name,customer.contact_person,customer.contact_no,customer.email_id, customer.pan_no,customer.active_status from tbl_customer_master customer";

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

	case "checkDuplicateCustomer":
		$customer_name = $_GET['customer_name'];
		$query = "SELECT COUNT(*) as count FROM tbl_customer_master where customer_name='".$customer_name."';";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;

	case "getCustomerId":
		$query = "SELECT customer_id FROM tbl_customer_master ORDER BY customer_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $customer_id = $row['customer_id'];
	break;

	case "getCustomerCode":
		$query = "SELECT customer_code as customer_code FROM tbl_customer_master ORDER BY customer_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $customer_code = $row['customer_code'];
	break;

	case "getCustomerDetails":
		$customer_id = $_GET['customer_id'];
		$query = "select customer.customer_id,customer.customer_sap_code,customer.customer_code,customer.customer_name,customer.address1,customer.address2,customer.address3,customer.city,customer.pin_code,customer.state_name,customer.country_name,customer.fax_no,customer.gst_no,customer.contact_person,customer.contact_no,customer.email_id,customer.pan_no from tbl_customer_master customer where customer.customer_id=".$customer_id."";
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

		//Vendor Master

	case "getVendorList":
		$query = "select vendor.vendor_id,vendor.vendor_code,vendor.vendor_name,vendor.vendor_sap_id,vendor.address1,vendor.address2,vendor.address3,vendor.city,vendor.state_name,vendor.country_name,vendor.contact_person,vendor.contact_no,vendor.pin_code,vendor.email_id,vendor.pan_details,vendor.gst_no,vendor.active_status from tbl_vendor_master vendor";
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
	case "checkDuplicateProject":
		$project_name = $_GET['project_name'];
		$query = "SELECT COUNT(*) as count FROM tbl_project_master where project_name='".$project_name."';";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;

	case "checkDuplicateVendor":
		$vendor_name = $_GET['vendor_name'];
		$query = "SELECT COUNT(*) as count FROM tbl_vendor_master where vendor_name='".$vendor_name."';";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;

	case "getVendorId":
		$query = "SELECT vendor_id FROM tbl_vendor_master ORDER BY vendor_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $vendor_id = $row['vendor_id'];
	break;

	case "getVendorCode":
		$query = "SELECT vendor_code as vendor_code FROM tbl_vendor_master ORDER BY vendor_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $vendor_code = $row['vendor_code'];
	break;

	case "getVendorDetails":
		$vendor_id = $_GET['vendor_id'];
		$query = "select vendor.vendor_id,vendor.vendor_code,vendor.vendor_name,vendor.vendor_sap_id,vendor.address1,vendor.address2,vendor.address3,vendor.city,vendor.state_name,vendor.country_name,vendor.contact_person,vendor.contact_no,vendor.email_id,vendor.pin_code,vendor.pan_details,vendor.gst_no from tbl_vendor_master vendor where vendor.vendor_id=".$vendor_id."";
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

case "checkDuplicateVendorForUpdate":
		$vendor_id = $_GET['vendor_id'];
		$vendor_name = $_GET['vendor_name'];

		$selectQuery = "SELECT vendor_name FROM tbl_vendor_master WHERE vendor_id=".$vendor_id."";
		$result = mysqli_query($dbCon,$selectQuery);
		$row = $result->fetch_assoc();

		if($row['vendor_name'] == $vendor_name){
			echo 0;
		} else {
			$query = "SELECT COUNT(*) as count FROM tbl_vendor_master where active_status=0 and vendor_name='".$vendor_name."';";
			$result = mysqli_query($dbCon,$query);
			$row = $result->fetch_assoc();
			echo $count = $row['count'];
		}
	break;

		//Project Master

	case "getProjectList":
	
		$query = "select project.plant_name,project.project_id,project.project_code,project.project_name,
project.project_location,project.manager_name,project.active_status,project.contact_no,
project.email_id,project.address1,project.city,project.state_name,project.country_name,
project.pin_code,date_format(project.start_date, '%d-%m-%Y') as start_date,project.manager_name as user_fullname,
date_format(project.end_date, '%d-%m-%Y') as end_date,project.wbs from tbl_project_master project";

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
		$query = "SELECT project_id,project_name FROM tbl_project_master where active_status='0'";
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

	case "checkDuplicateProject":
		$project_name = $_GET['project_name'];
		$query = "SELECT COUNT(*) as count FROM tbl_project_master where project_name='".$project_name."';";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;

	case "getProjectCode":
		$query = "SELECT project_code as project_code FROM tbl_project_master ORDER BY project_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $project_code = $row['project_code'];
	break;

	case "getProjectDetails":
		$project_id = $_GET['project_id'];
		$query = "select project.plant_name,project.project_id,project.project_code, project.project_name,project.manager_name,
project.state_name,project.country_name,project.project_location, project.contact_no,
 project.email_id, project.address1, project.address2, project.address3, project.city,project.pin_code,
 project.state_name,project.country_name,
 date_format( project.start_date, '%d-%m-%Y') 
as start_date,project.manager_name as user_fullname, date_format( project.end_date, '%d-%m-%Y') as end_date,
 project.wbs from tbl_project_master as project where project_id=".$project_id."";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
			foreach($row as $key => $value) { 
				$arr[$key] = $value;
			}
			$main_array[] = $arr;
		}
		$json=json_encode($main_array); 
		header('Content-Type:application/json');
		echo $json;
	break;

//Material Master
	case "getMaterialCode":
		$query = "SELECT material_code as material_code FROM tbl_material_master ORDER BY material_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $material_code = $row['material_code'];
	break;

	case "getMaterialList":
		$query = "select material.material_id,material.active_status,material.material_code,material.material_name,material.material_description, material.material_type, material.unit_of_measurment,material.unit_price,material.expiry_status,material.reorder_level,material.reorder_quantity from tbl_material_master material";
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

	case "checkDuplicateMaterial":
		$material_code = $_GET['material_code'];
		$query = "SELECT COUNT(*) as count FROM tbl_material_master where material_code='".$material_code."';";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;

	case "getMaterialDetails":
		$material_id = $_GET['material_id'];
		$query = "select material.material_id,material.material_code,material.material_name,material.material_description,material.material_type,material.unit_of_measurment,material.unit_price,material.min_quantity, material.max_quantity, material.expiry_status,material.reorder_level,material.reorder_quantity from tbl_material_master material where material.material_id=".$material_id."";
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

	case "getUOMList":
		$query = "SELECT uom_id,uom_name,uom_description FROM tbl_uom_master WHERE active_status=0";
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

	case "getUOMDetails":
		$uom_id = $_GET['uom_id'];
		$query = "SELECT uom_id,uom_name,uom_description FROM tbl_uom_master activity WHERE uom_id=".$uom_id."";
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

	case "getUOMNameList":
		$query = "SELECT uom_id,uom_name,uom_description FROM tbl_uom_master WHERE active_status=0";
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
	/*****************  Amit w code ends here  ********************/


	/****************** Sujata Code Starts Here **************/

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

// 	case "getInwardList":
// 	//$project_id = $_GET['project_id'];
// 	// $store_id = $_GET['store_id'];
// 	// $contractor_id = $_GET['contractor_id'];
// 	// $inventory_type = $_GET['inventory_type'];

// $query = "SELECT ge.time_in,ge.challan_no,ge.transporter_name,mm.material_name,mr.accepted_quantity,mr.rejected_quantity,mr.reason_for_rejection,st.store_supervisor_name FROM tbl_gate_entry ge,tbl_material_master mm,tbl_mrr_material mr, tbl_store_master st where ge.gate_entry_id=mr.gate_entry_id and mm.material_id=mr.mrr_material_id and st.store_id=ge.store_id group by gate_entry_code order by material_code ";

// 	  $result = mysqli_query($dbCon,$query);
// 		$main_array =[];
// 		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
// 			foreach($row as $key => $value) { 
// 				$arr[$key] = $value;
// 			}
// 			$main_array[] = $arr;
// 		}
// 		$json=json_encode($main_array); 
// 		header('Content-Type: application/json');
// 		echo $json;
// 	break;

// 	case "getOutwardList":
// 	//$project_id = $_GET['project_id'];
// 	// $store_id = $_GET['store_id'];
// 	// $contractor_id = $_GET['contractor_id'];
// 	// $inventory_type = $_GET['inventory_type'];
// $query = "SELECT  ge.challan_no,ge.transporter_name,mm.material_name,mrr.accepted_quantity,ih.indent_code,ih.indent_date,ih.approved_by,st.store_supervisor_name from tbl_gate_entry ge,tbl_material_master mm,tbl_mrr_material mrr,indent_head ih,tbl_store_master st where ge.gate_entry_id=mrr.gate_entry_id and ge.project_id=ih.project_id and ge.store_id=st.store_id and ih.approved_total_qty=mm.approved_total_qty group by indent_code order by indent_id";

// 	  $result = mysqli_query($dbCon,$query);
// 		$main_array =[];
// 		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {   
// 			foreach($row as $key => $value) { 
// 				$arr[$key] = $value;
// 			}
// 			$main_array[] = $arr;
// 		}
// 		$json=json_encode($main_array); 
// 		header('Content-Type: application/json');
// 		echo $json;
// 	break;

	case "getGateinwardList":
 $from_date = $_GET['from_date'];
 $to_date = $_GET['to_date'];
 if($to_date=='%'){
  $to_date1=date("Y-m-d");
 }else{
  $to_date1 = date('Y-m-d',strtotime($_GET['to_date'])); 
 }
 
 $from_date1 = date('Y-m-d',strtotime($_GET['from_date']));
 
 $project_id = $_GET['project_id'];
 $challan_no = $_GET['challan_no'];
 $store_id = $_GET['store_id'];
 $supplier_name = $_GET['supplier_name'];
 $inventory_type_id = $_GET['inventory_type_id'];
   $query = "SELECT tigem.material_number,tigem.material_description,inventory.inventory_type_name,project.project_id,project.project_name,store.store_id,store.store_name,gate_entry_code,inward_date,tigm.inventory_type_id,reference_number,supplier_name,transporter_name,
      vehicle_no,status,outward_time from tbl_inward_gate_entry as tigm,tbl_project_master as project,tbl_store_master as store,
      tbl_inventory_type as inventory,tbl_inward_gate_entry_material as tigem where
      project.project_id=tigm.project_id and store.store_id=tigm.store_id and      
     tigm.inventory_type_id=inventory.inventory_type_id and tigem.gate_entry_id=tigm.gate_entry_id and
     tigm.project_id LIKE '".$project_id."' and
     tigm.store_id LIKE '".$store_id."' and  
      tigm.reference_number LIKE '".$challan_no."' and  
  tigm.inventory_type_id  LIKE '".$inventory_type_id."' and 
  tigm.supplier_name  LIKE '".$supplier_name."'and
 tigm.inward_date between '".$from_date1."' AND '".$to_date1."'";

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

case "getGateoutwardList":
	$from_date = $_GET['from_date'];
 $to_date = $_GET['to_date'];
 if($to_date=='%'){
  $to_date1=date("Y-m-d");
 }else{
  $to_date1 = date('Y-m-d',strtotime($_GET['to_date'])); 
 }
 
 $from_date1 = date('Y-m-d',strtotime($_GET['from_date']));
 
 $project_id = $_GET['project_id'];
 $challan_no = $_GET['challan_no'];
 $store_id = $_GET['store_id'];
 $supplier_name = $_GET['supplier_name'];
 $inventory_type_id = $_GET['inventory_type_id'];

$query = "SELECT outward_gate_entry_id,outward_ge_code,outward_date,cn.customer_name,transporter_name,vehicle_no,status,outward_time FROM tbl_outward_gate_entry ge,tbl_customer_master cn where ge.customer_id=cn.customer_id AND outward_date between '".$from_date1."' AND '".$to_date1."';";
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

case "getinwardoutwardList":
	$from_date = $_GET['from_date'];
	$to_date = $_GET['to_date'];
	$from_date1 = date('Y-m-d',strtotime($_GET['from_date']));
	 $to_date1 = date('Y-m-d',strtotime($_GET['to_date']));
	//$project_id = $_GET['project_id'];
	// $store_id = $_GET['store_id'];
	// $contractor_id = $_GET['contractor_id'];
	// $inventory_type = $_GET['inventory_type'];
   $query = "SELECT ige.gate_entry_code,ige.inward_date,ige.inventory_type_id,ige.reference_number,ige.supplier_name,ige.transporter_name,ige.vehicle_no,ige.status,ige.outward_time,oge.outward_gate_entry_id,oge.outward_ge_code,oge.outward_date,cn.customer_name,oge.transporter_name,oge.vehicle_no,oge.status,oge.outward_time from tbl_inward_gate_entry ige,tbl_outward_gate_entry oge,tbl_customer_master cn where oge.customer_id=cn.customer_id and inward_date between '".$from_date1."' AND '".$to_date1."'";
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


case "getScstockmovementregisterList":
	$from_date = $_GET['from_date'];
	$to_date = $_GET['to_date'];

	$from_date1 = date('Y-m-d',strtotime($_GET['from_date']));
	$to_date1 = date('Y-m-d',strtotime($_GET['to_date']));

$query = "SELECT coninv.loc_no,coninv.material_issue_date,mm.material_name,coninvml.issued_qty,mch.jmc_number,coninvml.consumed_qty,coninv.material_return_date,coninvml.return_qty from tbl_contractor_inventory coninv,tbl_contractor_inventory_material coninvml,tbl_material_master mm,tbl_material_consumption_header mch where coninvml.contractor_inventory_id=coninv.contractor_id and coninvml.material_id=mm.material_id  AND material_issue_date between '".$from_date1."' 
	AND '".$to_date1."' group by material_name order by issued_qty";

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





case "getDetailedstockList":
	$from_date = $_GET['from_date'];
	$to_date = $_GET['to_date'];

	$from_date1 = date('Y-m-d',strtotime($_GET['from_date']));
	$to_date1 = date('Y-m-d',strtotime($_GET['to_date']));

$query = "SELECT mh.mrr_date,mm.material_code,mm.material_name,mm.max_quantity,mm.unit_price,mrr.accepted_quantity,igem.unitprice,conim.issued_qty,igem.unitprice from tbl_material_master mm,tbl_inward_gate_entry_material igem,tbl_mrr_material mrr,tbl_contractor_inventory_material conim,tbl_mrr_head mh where conim.material_id=mm.material_id and igem.inward_ge_material_id=mrr.inward_ge_material_id AND mrr_date between '".$from_date1."' 
	AND '".$to_date1."' group by material_code";

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
/*********************Sujata Code Ends Here **************/

	/**************Sujata code starts here************************/

	//Storage Location Master

	case "getStorageList":
		$query = "SELECT storage.storage_id,storage.store_id,storage.project_id,project.project_name,store.store_name,storage.storage_location_code,storage.storage_location_name,storage.active_status
		   FROM tbl_storage_location_master storage,tbl_project_master project,tbl_store_master store
		   WHERE storage.project_id=project.project_id and storage.store_id=store.store_id";
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

	case "getStorageDetails":
	$project_id = $_GET['project_id'];
		$store_id = $_GET['store_id'];
		$query = "SELECT storage.storage_id,storage.project_id,storage.store_id,storage.storage_location_code,storage.storage_location_name FROM tbl_storage_location_master storage,tbl_project_master project,tbl_store_master store WHERE storage.project_id=project.project_id and storage.store_id=store.store_id and storage.project_id = ".$project_id." and storage.store_id=".$store_id."";
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


		//Store Master
	case "getStoreList":
		$query = "SELECT store.store_id,project.project_name,store.store_name, store.store_address1,store.address2,store.address3,store.city,store.state_name,store.country_name,store.store_location,store.store_supervisor_name,store.active_status
		   FROM tbl_store_master store,tbl_project_master project
		   WHERE store.project_id=project.project_id";
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

	case "getStoreDetails":
		$store_id = $_GET['store_id'];
		$query = "select store.store_id,store.project_id,store.store_name,store.store_address1,store.address2,store.address3,store.city,store.state_name,store.country_name,store.store_location,store.store_supervisor_name from tbl_store_master store where store.store_id=".$store_id."";
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

		//Site Master

	case "getSite":
		$query = "SELECT project.project_id,project.project_name,store.store_name,store.store_id FROM tbl_site_master_header site,tbl_project_master project,
 tbl_store_master as store WHERE store.store_id=site.store_id and site.project_id=project.project_id";
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
		$query = "SELECT site_master_main_id,site_name,site_location FROM tbl_site_master_main where active_status=0";
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

case "getSiteList":
		$query = "SELECT project.project_id,project.project_name,store.store_name,store.store_id,main.site_name,main.site_location,main.site_engineer_name FROM tbl_site_master_header site,tbl_project_master project,
 tbl_store_master as store,tbl_site_master_main as main WHERE store.store_id=site.store_id and site.project_id=project.project_id and site.site_header_id =main.site_header_id";
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


	case "getSiteDetails":
		$project_id = $_GET['project_id'];
		$store_id = $_GET['store_id'];
		$query = "SELECT site.site_id,store.store_id,store.store_name,site.project_id,project.project_code,site.site_engineer_name,project.project_name,project.project_id,site.site_name,site.site_location,site.site_engineer_name FROM tbl_site_master site,tbl_project_master project,tbl_store_master as store WHERE project.project_id=site.project_id and store.store_id=site.store_id AND site.project_id=".$project_id."";
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
  
case "checkDuplicateSite":
		$project_id = $_GET['project_id'];
		$store_id = $_GET['store_id'];
		$site_id = $_GET['site_id'];
		$query = "SELECT COUNT(*) as count FROM tbl_site_master where project_id=".$project_id." and store_id=".$store_id." and store_id=".$store_id.";";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;

case "checkDuplicateActivity":
		$activity_name = $_GET['activity_name'];
		$query = "SELECT COUNT(*) as count FROM tbl_activity_master where activity_name='".$activity_name."';";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;

		//Activity Master

	case "getActivityList":
		$query = "SELECT activity.activity_id,activity.activity_code,activity.activity_name,activity.active_status FROM tbl_activity_master activity";
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

	case "getActivityDetails":
		$activity_id = $_GET['activity_id'];
		$query = "SELECT activity.activity_id,activity.activity_code,activity.activity_name FROM tbl_activity_master activity WHERE activity.activity_id=".$activity_id."";
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

	case "checkDuplicateActivityForUpdate":
		$activity_id = $_GET['activity_id'];
		$query = "SELECT COUNT(*) as count FROM tbl_activity_master where  activity_id=".$activity_id.";";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;
		//Contractor Master

	case "getContractorList":

		$query = "SELECT contractor.contractor_id,contractor.contractor_number,contractor.contractor_name,contractor.contractor_address1,contractor.address2,contractor.address3,contractor.pin_code,contractor.city,contractor.state_name,contractor.country_name,contractor.gstin_no,contractor.contact_person,contractor.contact_no,contractor.pan_details,contractor.active_status FROM tbl_contractor_master contractor";
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
		//echo $contractorQuery;
	break;

	case "getContractorDetails":
		$contractor_id = $_GET['contractor_id'];
		$query = "SELECT contractor.contractor_id,contractor.contractor_number,contractor.contractor_name,contractor.contractor_address1,contractor.address2,contractor.address3,contractor.pin_code,contractor.city,contractor.state_name,contractor.country_name,contractor.gstin_no,contractor.contact_person,contractor.contact_no,contractor.pan_details FROM tbl_contractor_master contractor WHERE contractor.contractor_id=".$contractor_id."";
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

		//BOM Master

	case "getBomList":
		$query = "select bom.site_id,bom.activity_id,bom.material_id,bom.quantity,bom.unit from tbl_bom_master bom;";
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

	/*****************  Sujata code ends here  ********************/

case "getUserRoleList":
		$query = "SELECT user_role_id,user_role FROM tbl_user_role WHERE active_status=0";
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

	case "getUserList":
		$query = "select user.user_id,user.user_name,user.user_fullname,user.mobile_number,user.user_role from tbl_user_master user where user.user_status=0;";
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

	case "checkDuplicateUser":
		$user_name = $_GET['user_name'];
		$query = "SELECT COUNT(*) as count FROM tbl_user_master where user_status=0 and user_name='".$user_name."';";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;

	case "checkDuplicateRole":
		$user_role = $_GET['user_role'];
		$query = "SELECT COUNT(*) as count FROM tbl_user_role where active_status=0 and user_role='".$user_role."';";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;

	case "checkDuplicateUserForUpdate":
		$user_id = $_GET['user_id'];
		$user_name = $_GET['user_name'];
		$selectQuery = "SELECT user_name FROM tbl_user_master WHERE user_id=".$user_id.";";
		$result = mysqli_query($dbCon,$selectQuery);
		$row = $result->fetch_assoc();
		if($row['user_name'] == $user_name){
			echo 0;
		} else {
			$query = "SELECT COUNT(*) as count FROM tbl_user_master where user_status=0 and user_name='".$user_name."';";
			$result1 = mysqli_query($dbCon,$query);
			$row1 = $result1->fetch_assoc();
			echo $count = $row1['count'];
		}
	break;

	case "getUserDetails":
		$user_name = $_GET['user_name'];
		$query = "select user.user_id,user.user_name,user.user_fullname,user.password,user.email_id,user.mobile_number,user.user_role, user.dept_id,dept.dept_name from tbl_user_master user left join tbl_department_master dept on user.dept_id=dept.dept_id where user.user_name='".$user_name."'";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	/**************************************************************************/

	/*************************************Tarun*************************************/
case "getManagerDetails":
        $manager_name = $_GET['manager_name'];


		$query = "SELECT email_id,mobile_number  FROM tbl_user_master where user_fullname = '".$manager_name."';";
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

case "getRoleList":
      $User = $_GET['user_name'];
      $Role = $_GET['user_role'];

		$query = "SELECT um.user_name,us.user_role,us.master_data_access,us.inventory_access,us.indent_access,us.gate_entry_access,us.material_receipt_access,us.material_rejection_access,us.material_issue_access,us.material_transfer_note_access,us.material_return_access,us.reports_access from tbl_user_role us,tbl_user_master um where us.user_role ='".$Role."' and um.user_name='".$User."'";
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


case "getUserRole":
		$query = "select user_role_id,user_role,description from tbl_user_role user where active_status=0;";
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
	/*************************************Tarun*************************************/

/*********************************Madhuri code Starts here***********************/

case "getManagerList":

       $queryM = "select user_role_id from tbl_user_role where user_role='Project Manager'";
  		$resultM = mysqli_query($dbCon,$queryM);
	    $rowM = mysqli_fetch_array($resultM,MYSQLI_ASSOC);


		$query = "SELECT user_fullname as manager_name,email_id,mobile_number  FROM tbl_user_master where user_role_id='".$rowM['user_role_id']."';";
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


case "getSiteEngineerName":
       $query1 = "select user_role_id from tbl_user_role where user_role='Site Engineer'";
  		$result1 = mysqli_query($dbCon,$query1);
	    $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);


		$query = "SELECT user_fullname as site_engineer_name FROM tbl_user_master where user_role_id='".$row1['user_role_id']."';";
		

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

	case "getProjectCode1":
	$project_id = $_GET['project_id'];
		$query = "SELECT project_name,project_code FROM tbl_project_master WHERE project_id= ".$project_id."";
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


	case "getSupervisorList":

	 $queryS = "select user_role_id from tbl_user_role where user_role='Supervisor'";
  		$resultS = mysqli_query($dbCon,$queryS);
	    $rowS = mysqli_fetch_array($resultS,MYSQLI_ASSOC);


		$query = "SELECT user_fullname as store_supervisor_name,email_id,mobile_number  FROM tbl_user_master where user_role_id='".$rowS['user_role_id']."';";
		
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
      $project_id = $_GET['project_id'];
		$query = "SELECT store_id,store_name FROM tbl_store_master WHERE active_status=0 and project_id= ".$project_id."";
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

	/*case "getValue2":
	$project_code = $_GET['project_code'];
		$query = "SELECT * FROM tbl_project_master WHERE project_code= ".$search."";
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
	break;*/


case "checkDuplicateStoreForUpdate":
       $project_id = $_GET['project_id'];
		$store_name = $_GET['store_name'];
		$query = "SELECT COUNT(*) as count FROM tbl_store_master where store_name='".$store_name."'and project_id=".$project_id.";";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;
/*******************************Madhuri Code Ends here*****************************/

/*************************************suraj b code start here***********************************/
	//Activity Transaction Master
//Activity Master

case "getSiteNameList":
	$store_id = $_GET['store_id'];

	 $queryS = "select site_header_id from tbl_site_master_header where store_id=".$store_id."";
  		$resultS = mysqli_query($dbCon,$queryS);
	    $rowS = mysqli_fetch_array($resultS,MYSQLI_ASSOC);


	    $query = "SELECT site_master_main_id,site_name,site_location FROM tbl_site_master_main where site_header_id='".$rowS['site_header_id']."' and active_status=0;";
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

	case "getActivityTransactionList":
		$query = "SELECT activityTransaction.activity_transaction_id,project.project_name,activity.activity_name,activityTransaction.activity_status,activityTransaction.active_status FROM tbl_activity_transaction_master activityTransaction,tbl_project_master project,tbl_activity_master as activity  WHERE activityTransaction.project_id=project.project_id and activityTransaction.activity_id=activity.activity_id";
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

	case "getActivityTransactionDetails":
		$activity_transaction_id = $_GET['activity_transaction_id'];
		$query = "SELECT activityTransaction.activity_transaction_id,project.project_name,project.project_id,activity.activity_id,activity.activity_name,activityTransaction.activity_status 
                  FROM tbl_activity_transaction_master activityTransaction, tbl_project_master project,
                  tbl_activity_master activity WHERE project.project_id=activityTransaction.project_id 
                  and activity.activity_id=activityTransaction.activity_id and activityTransaction.activity_transaction_id=".$activity_transaction_id."";
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

	case "checkDuplicateActivityTransactionForUpdate":
		$activity_id = $_GET['activity_id'];
		$project_id = $_GET['project_id'];
		$query = "SELECT COUNT(*) as count FROM tbl_activity_transaction_master where project_id=".$project_id." and activity_id=".$activity_id.";";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $count = $row['count'];
	break;

	case "getActivityCode":

		$query = "SELECT activity_code  FROM tbl_activity_master ORDER BY activity_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $activity_code = $row['activity_code'];
	break;
	/******************suraj B codes end here*/

	/******************Ankita code starts here******************************/
	case "getContractorCode":

		$query = "SELECT contractor_code as contractor_number FROM tbl_contractor_master ORDER BY contractor_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		echo $contractor_number = $row['contractor_number'];
	break;

	/******************Ankita codes end here******************************/
}
?>