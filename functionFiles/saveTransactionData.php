<?php
require_once 'dbConnection.php';
switch($_GET["operType"]){

	/****************************Ankita code starts here****************/

	case "saveGateEntry":
		$dArray = json_decode($_POST['formDataJson1'],true);
		$ReferenceMaterialList=json_decode($_POST['formDataJson2'],true);
		$insertQuery = '';

		$dArray['inward_date'] = date('Y-m-d',strtotime($dArray['inward_date']));
        $dArray['challan_date'] = date('Y-m-d',strtotime($dArray['challan_date']));
		// $query1 = "select import_excel_id from import_excel where reference_number= '".$dArray['reference_number']."'";
  // 		$result1 = mysqli_query($dbCon,$query1);
	 //    $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

		//$temp_invnttyp = 0;
		$insertQuery .= "INSERT INTO tbl_inward_gate_entry(gate_entry_code,inward_date,supplier_name,inventory_type_id,challan_no,challan_date,total_no_pkg,reference_number,transporter_name,vehicle_no,inward_time,project_id,store_id,lr_no,created_by) VALUES
	  ('".$dArray['gate_entry_code']."','".$dArray['inward_date']."','".$dArray['supplier_name']."','".$dArray['inventory_type_id']."','".$dArray['challan_no']."','".$dArray['challan_date']."','".$dArray['ttl_no_pkg']."',";
	  if($dArray['inventory_type_id'] == 1 || $dArray['inventory_type_id'] == 3){
	  	$insertQuery .= "'".$dArray['purchase_document_number']."',";
	  	//$temp_invnttyp=1;
	  } else if($dArray['inventory_type_id'] == 2){
	  	$insertQuery .= "'".$dArray['delivery_number']."',";
	  	//$temp_invnttyp=2;
	  }else if($dArray['inventory_type_id'] == 7){
	  	$insertQuery .= "'".$dArray['material_return_number']."',";
	  }
	  else {
	  	$insertQuery .= "'".$dArray['purchase_document_number']."',";
	  	//$temp_invnttyp=3;
	  }
	  $insertQuery .="'".$dArray['transporter_name']."','".$dArray['vehicle_no']."','".$dArray['inward_time']."','".$dArray['project_id']."','".$dArray['store_id']."','".$dArray['lr_no']."','".$dArray['created_by']."');";

	  	$gateEntryId="SELECT gate_entry_id FROM tbl_inward_gate_entry ORDER BY gate_entry_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$gateEntryId);
        $row = $result->fetch_assoc();
		$gateEntryId = (int) $row['gate_entry_id'] + 1;
		/*echo $gateEntryId;*/

		for($i=0;$i<sizeof($ReferenceMaterialList);$i++){
			 $materialId= "SELECT material_id FROM tbl_material_master where material_code= '".$ReferenceMaterialList[$i]['material_number']."'";
	   $result = mysqli_query($dbCon,$materialId);
        $row = $result->fetch_assoc();
		$material_id = (int) $row['material_id']+ 1;

		if ($dArray['inventory_type_id']== 1 || $dArray['inventory_type_id']== 3 || $dArray['inventory_type_id']== 2 || $dArray['inventory_type_id']== 7){
  		$insertQuery .= "INSERT INTO tbl_inward_gate_entry_material(gate_entry_id, material_number, material_description, quantity,unit_of_measurement,material_id,challan_qty) VALUES('".$gateEntryId."','".$ReferenceMaterialList[$i]['material_number']."','".$ReferenceMaterialList[$i]['material_description']."','".$ReferenceMaterialList[$i]['quantity']."','".$ReferenceMaterialList[$i]['unit_of_measurement']."',".$material_id.",'".$ReferenceMaterialList[$i]['challan_quantity']."');";
  		}
  		else {
  			$insertQuery .= "INSERT INTO tbl_inward_gate_entry_material(gate_entry_id, material_number, material_description, unit_of_measurement,material_id,challan_qty) VALUES('".$gateEntryId."','".$ReferenceMaterialList[$i]['material_number']."','".$ReferenceMaterialList[$i]['material_description']."','".$ReferenceMaterialList[$i]['unit_of_measurment']."',".$material_id.",'".$ReferenceMaterialList[$i]['challan_quantity']."');";
 	  	}
 	  }
  	//echo $insertQuery;
  	echo mysqli_multi_query($dbCon,$insertQuery);

	break;
    
	case "updateOutwardTime":
		$dArray = json_decode($_POST['formDataJson1'],true);
		$insertQuery = "UPDATE tbl_inward_gate_entry SET
						status = 1,
						outward_time = '".$dArray['outward_time']."'
						where gate_entry_id = '".$dArray['gate_entry_id']."'";
  	
  	   echo mysqli_query($dbCon,$insertQuery);
	break;

	case "saveOutwardGateEntry":
		$dArray = json_decode($_POST['formDataJson1'],true);
		//$ReferenceMaterialList=json_decode($_POST['formDataJson2'],true);
		$insertQuery = '';

		$dArray['outward_date'] = date('Y-m-d',strtotime($dArray['outward_date']));

		// $query1 = "select import_excel_id from import_excel where reference_number= '".$dArray['reference_number']."'";
  // 		$result1 = mysqli_query($dbCon,$query1);
	 //    $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

		$insertQuery .= "INSERT INTO tbl_outward_gate_entry(outward_ge_code,outward_date,contractor_id,transporter_name,vehicle_no,lr_no,inward_time,project_id,store_id) VALUES
	  ('".$dArray['outward_ge_code']."','".$dArray['outward_date']."','".$dArray['contractor_id']."','".$dArray['transporter_name']."','".$dArray['vehicle_no']."','".$dArray['lr_no']."','".$dArray['inward_time']."','".$dArray['project_id']."','".$dArray['store_id']."');";

	 //  	$gateEntryId="SELECT gate_entry_id FROM tbl_gate_entry ORDER BY gate_entry_id DESC LIMIT 1";
	 //    $result = mysqli_query($dbCon,$gateEntryId);
  //       $row = $result->fetch_assoc();
		// $gateEntryId = (int) $row['gate_entry_id'] + 1;
		// /*echo $gateEntryId;*/

		// for($i=0;$i<sizeof($ReferenceMaterialList);$i++){
		

  // 		$insertQuery .= "INSERT INTO tbl_gate_entry_material(gate_entry_id,material_id, material_number, material_description, quantity, unitprice) VALUES('".$gateEntryId."','".$ReferenceMaterialList[$i]['material_id']."','".$ReferenceMaterialList[$i]['material_code']."','".$ReferenceMaterialList[$i]['material_description']."','".$ReferenceMaterialList[$i]['billing_quantity']."','".$ReferenceMaterialList[$i]['net_value']."');";
  // 	}
  	//echo $insertQuery;
  	echo mysqli_query($dbCon,$insertQuery);

	break;

	case "updateOutwardEntry":
		$dArray = json_decode($_POST['formDataJson1'],true);
		$insertQuery = "UPDATE tbl_outward_gate_entry SET inventory_type='".$dArray['inventory_type']."',outward_type='".$dArray['outward_type']."',reference_number='".$dArray['reference_number']."',status = 1,
						outward_time = '".$dArray['outward_time']."'
						where outward_gate_entry_id = '".$dArray['outward_gate_entry_id']."'";
  	
  	   echo mysqli_query($dbCon,$insertQuery);
	break;

	case "saveMaterialIssue":
		$dArray = json_decode($_POST['formDataJson1'],true);
		$ReferenceMaterialList=json_decode($_POST['formDataJson2'],true);
		$materialIssueQuery = '';

		$dArray['material_issue_date'] = date('Y-m-d',strtotime($dArray['material_issue_date']));

	   $query1 = "select indent_id from indent_head where indent_code= '".$dArray['indent_code']."'";
  		$result1 = mysqli_query($dbCon,$query1);
	    $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

	    $query2 = "select activity_id from tbl_activity_master where activity_name= '".$dArray['activity_name']."'";
	    $result2 = mysqli_query($dbCon,$query2);
	    $row2= mysqli_fetch_array($result2,MYSQLI_ASSOC);

		$query3 = "select site_id from tbl_site_master where site_location= '".$dArray['site_location']."'";
		$result3 = mysqli_query($dbCon,$query3);
	    $row3= mysqli_fetch_array($result3,MYSQLI_ASSOC);

		$materialIssueQuery .= "INSERT INTO tbl_contractor_inventory(material_issue_number,material_issue_date,inventory_type,issued_to_name,remark,active_status,indent_id,contractor_id,activity_id,store_id,project_id,site_id)
		 VALUES('".$dArray['material_issue_number']."',
	  '".$dArray['material_issue_date']."',
	  '".$dArray['inventory_type']."',
	  '".$dArray['issued_to_name']."',
	  '".$dArray['remark']."',0,";
         if($row1['indent_id']  == ''){
						$materialIssueQuery .= "NULL,";
					}else{
						$materialIssueQuery .= "".$row1['indent_id'].",";
					}
					if($dArray['contractor_id'] == ''){
						$materialIssueQuery .= "NULL,";
					}else{
						$materialIssueQuery .= "".$dArray['contractor_id'].",";
					}
					if($row2['activity_id']== ''){
						$materialIssueQuery .= "NULL,";
					}else{
						$materialIssueQuery .= "".$row2['activity_id'].",";
					}
					if($dArray['store_id'] == ''){
						$materialIssueQuery .= "NULL,";
					}else{
						$materialIssueQuery .= "".$dArray['store_id'].",";
					}
					if($dArray['project_id']== ''){
						$materialIssueQuery .= "NULL,";
					}else{
						$materialIssueQuery .= "".$dArray['project_id'].",";
					}
					if($row3['site_id']  == ''){
						$materialIssueQuery .= "NULL);";
					}else{
						$materialIssueQuery .= "".$row3['site_id'].");";
					}
	  	$gateEntryId="SELECT contractor_inventory_id FROM tbl_contractor_inventory ORDER BY contractor_inventory_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$gateEntryId);
        $row = $result->fetch_assoc();
		$contractor_inventory_id = (int) $row['contractor_inventory_id'] + 1;
		//echo $gateEntryId;

		for($i=0;$i<sizeof($ReferenceMaterialList);$i++){
         $materialId="select material_id from tbl_material_master where material_code='".$ReferenceMaterialList[$i]['material_code']."';";
         $result4 = mysqli_query($dbCon,$materialId);
	    $row4= mysqli_fetch_array($result4,MYSQLI_ASSOC);


	 $inventorymaterialid = "select inventory_material_id from tbl_contractor_inventory_material where contractor_inventory_id=".$contractor_inventory_id." and material_id=".$row4['material_id'].";";
		 $result14 = mysqli_query($dbCon,$inventorymaterialid);
	    $row14= mysqli_fetch_array($result14,MYSQLI_ASSOC);
      if($row14['inventory_material_id']==NULL){
  		$materialIssueQuery .= "INSERT INTO tbl_contractor_inventory_material(material_number,contractor_inventory_id, material_id,indent_qty, issued_qty) 
  		VALUES('".$ReferenceMaterialList[$i]['material_code']."',";
        if($contractor_inventory_id == ''){
						$materialIssueQuery .= "NULL,";
					}else{
						$materialIssueQuery .= "".$contractor_inventory_id.",";
					}
        if($row4['material_id'] == ''){
						$materialIssueQuery .= "NULL,";
					}else{
						$materialIssueQuery .= "".$row4['material_id'].",";
					}
		if($ReferenceMaterialList[$i]['approved_total_qty'] == ''){
						$materialIssueQuery .= "NULL,";
					}else{
						$materialIssueQuery .= "".$ReferenceMaterialList[$i]['approved_total_qty'].",";
					}
		if($ReferenceMaterialList[$i]['issued_qty']== ''){
						$materialIssueQuery .= "NULL);";
					}else{
						$materialIssueQuery .= "".$ReferenceMaterialList[$i]['issued_qty'].");";
					}
  	}else{
  		$query5 = "select * from tbl_contractor_inventory_material where inventory_material_id= ".$row14['inventory_material_id']."";
		$result5= mysqli_query($dbCon,$query5);
	    $row5= mysqli_fetch_array($result5,MYSQLI_ASSOC);
       $issuedQty=(int)($ReferenceMaterialList[$i]['issued_qty'])+(int)($row5['issued_qty']);

  		$materialIssueQuery .= "UPDATE tbl_contractor_inventory_material SET 
			material_number='".$ReferenceMaterialList[$i]['material_code']."',
			unit_of_measurment='".$ReferenceMaterialList[$i]['unit_of_measurment']."',
			updated_by='".$vendor['updated_by']."',";	
		if($ReferenceMaterialList[$i]['issued_qty'] == ''){
			$materialIssueQuery .= "issued_qty=".$row5['issued_qty'].",";
		} else {
			$materialIssueQuery .= "issued_qty=".$issuedQty.",";
		}	
		if($row4['material_id'] == ''){
			$materialIssueQuery .= "material_id=null";
		} else {
			$materialIssueQuery .= "material_id=".$row4['material_id']."";
		}			
		$materialIssueQuery .= " WHERE inventory_material_id=".$row14['inventory_material_id'].";";
  	}
  	}

  	for($i=0;$i<sizeof($ReferenceMaterialList);$i++){ 
        $materialId1="select material_id from tbl_material_master where material_code='".$ReferenceMaterialList[$i]['material_code']."';";
         $result41 = mysqli_query($dbCon,$materialId1);
	    $row41= mysqli_fetch_array($result41,MYSQLI_ASSOC);

  		$query6 = "select accepted_quantity,remaining_qty,issued_qty from tbl_store_inventory where 
  		material_number='".$ReferenceMaterialList[$i]['material_code']."' and project_id = ".$dArray['project_id']." and store_id = ".$dArray['store_id'].";";
  		$result6 = mysqli_query($dbCon,$query6);
	    $row6 = mysqli_fetch_array($result6,MYSQLI_ASSOC);
       $query7 = "select indent_remaining_qty  from indent_material where material_code='".$ReferenceMaterialList[$i]['material_code']."' and indent_id = ".$row1['indent_id'].";";
  $result7 = mysqli_query($dbCon,$query7);
$row7 = mysqli_fetch_array($result7,MYSQLI_ASSOC);

$acceptedQty = (float)$row6['accepted_quantity'];
$issuedQty = (float)$row6['issued_qty'] + (float)$ReferenceMaterialList[$i]['issued_qty'];
$indentRemainigQty=(float)$row7['indent_remaining_qty'] - (float)$ReferenceMaterialList[$i]['issued_qty'];
$storeRemainingQty=(float)$row6['remaining_qty'] - (float)$ReferenceMaterialList[$i]['issued_qty'];
       
   //Upadte the accepted qty remaining qty and issued qty against the tbl_store_inventory
$materialIssueQuery .= "UPDATE tbl_store_inventory SET ";
		if($row6['accepted_quantity'] == ''){
			$materialIssueQuery .= "accepted_quantity=null,";
		} else {
			$materialIssueQuery .= "accepted_quantity=".$acceptedQty.",";
		}
		if($row6['remaining_qty'] == ''){
			$materialIssueQuery .= "remaining_qty=null,";
		} else {
			$materialIssueQuery .= "remaining_qty=".$storeRemainingQty.",";
		}	
		if($ReferenceMaterialList[$i]['issued_qty'] == ''){
			$materialIssueQuery .= "issued_qty=null";
		} else {
			$materialIssueQuery .= "issued_qty=".$issuedQty."";
		}	
  		$materialIssueQuery .= " where material_number='".$ReferenceMaterialList[$i]['material_code']."' and store_id=".$dArray['store_id']." and project_id=".$dArray['project_id'].";";

  		$materialIssueQuery .= "UPDATE indent_material SET 	";
		if($ReferenceMaterialList[$i]['indent_remaining_qty'] == ''){
			$materialIssueQuery .= "indent_remaining_qty=".$indentRemainigQty."";
		} else {
			$materialIssueQuery .= "indent_remaining_qty=".$indentRemainigQty."";
		}	
		$materialIssueQuery .= " where material_id=".$row41['material_id']." and indent_id = ".$row1['indent_id'].";";
  	}

//  	echo $materialIssueQuery;
	echo mysqli_multi_query($dbCon,$materialIssueQuery);

	break;

	case "saveMaterialReurn":
		$dArray = json_decode($_POST['formDataJson1'],true);
		$ReferenceMaterialList=json_decode($_POST['formDataJson2'],true);
		$insertQuery = '';

		$dArray['material_return_date'] = date('Y-m-d',strtotime($dArray['material_return_date']));

  $query1 = "select project_id from tbl_project_master where project_name='".$dArray['project_name']."'";
		$result1 = mysqli_query($dbCon,$query1);
		$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

		$query2 = "select site_id from tbl_site_master where site_name='".$dArray['site_name']."'";
		$result2 = mysqli_query($dbCon,$query2);
		$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);

		$query3 = "select activity_id from tbl_activity_master where activity_name='".$dArray['activity_name']."'";
		$result3 = mysqli_query($dbCon,$query3);
		$row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);

		$query4 = "select contractor_id from tbl_contractor_master where contractor_name='".$dArray['contractor_name']."'";
		$result4 = mysqli_query($dbCon,$query4);
		$row4 = mysqli_fetch_array($result4,MYSQLI_ASSOC);



	  $insertQuery .= "INSERT INTO tbl_return_contractor(project_id,site_id,activity_id,contractor_id,material_return_code,materia_return_date,return_remarks,material_consumption_id) VALUES(
	  ".$row1['project_id'].",
	  ".$row2['site_id'].",
	  ".$row3['activity_id'].",
	  ".$row4['contractor_id'].",
	  '".$dArray['material_return_code']."',
	  '".$dArray['material_return_date']."',
	  '".$dArray['remarksReturn']."',
	  '".$dArray['material_consumption_code']."');";

		  $query="SELECT return_contractor_id FROM tbl_return_contractor ORDER BY return_contractor_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		$return_contractor_id = (int) $row['return_contractor_id'] + 1;
				
	  	for($i=0;$i<sizeof($ReferenceMaterialList);$i++){

  		$balance_qty=(int)(($ReferenceMaterialList[$i]['issued_qty'])- (int)($ReferenceMaterialList[$i]['actual_quantity']));

  		$insertQuery .= "INSERT INTO tbl_return_contractor_material(return_contractor_id,material_issue_number,material_number,material_description,issued_qty,consumed_qty,balance_qty,return_qty,reason_return) 
  		VALUES(".$return_contractor_id.",
  		'".$ReferenceMaterialList[$i]['material_issue_number']."',
  		'".$ReferenceMaterialList[$i]['material_name']."',
  		'".$ReferenceMaterialList[$i]['material_description']."',
  		".$ReferenceMaterialList[$i]['issued_qty'].",
  		".$ReferenceMaterialList[$i]['actual_quantity'].",
  		".$balance_qty.",
  		".$ReferenceMaterialList[$i]['return_qty'].",
  		'".$ReferenceMaterialList[$i]['reason_return']."');";
	 	}




  	//echo $insertQuery;
  	echo mysqli_multi_query($dbCon,$insertQuery);
  	break;

	/****************************Ankita code ends here****************/

	/****************************Amit W code starts here****************/

	case "saveMRR":
	  $mrr = json_decode($_POST["formDataJson1"],true);
	  $materialList = json_decode($_POST["formDataJson2"],true);
	  $mrrQuery = '';	
	 
	  $mrr_date = date('Y-m-d',strtotime($mrr['mrr_date']));

	  //$expiry_date = date('Y-m-d',strtotime($materialList['expiry_date']));

	  //$rejection_date = date('Y-m-d',strtotime($mrr['rejection_date']));
	  //$expiry_date = date('Y-m-d',strtotime($materialList[$i]['expiry_date']));

	  $query="SELECT gate_entry_id FROM tbl_mrr_head ORDER BY gate_entry_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		$gate_entry_id = (int) $row['gate_entry_id'] + 1;

	  $mrrQuery .= "INSERT INTO tbl_mrr_head(gate_entry_id,mrr_code,mrr_date,project_id,store_id,inventory_type_id,supplier_name,supplier_invoice_no,transporter_name,vehicle_no,lr_no,total_quantity,total_rejected_quantity,rejection_status,remark) VALUES(".$gate_entry_id.",
	  '".$mrr['mrr_code']."',
	  '".$mrr_date."',
	  ".$mrr['project_id'].",
	  ".$mrr['store_id'].",
	  '".$mrr['inventory_type_id']."',
	  '".$mrr['supplier_name']."',
	  '".$mrr['supplier_invoice_no']."',
	  '".$mrr['transporter_name']."',
	  '".$mrr['vehicle_no']."',
	  '".$mrr['lr_no']."',
	  ".$mrr['total_quantity'].",
	  ".$mrr['total_rejected_quantity'].",'reject',";
					if($mrr['remark'] == ''){
						$mrrQuery .= "'');";
					}else{
						$mrrQuery .= "'".$mrr['remark']."');";
					}
	 	$query="SELECT gate_entry_id FROM tbl_mrr_head ORDER BY gate_entry_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		$gate_entry_id = (int) $row['gate_entry_id'] + 1;

		$mrrQuery .= "UPDATE tbl_inward_gate_entry SET mrr_status=1 WHERE gate_entry_id='".$gate_entry_id."';";

		$query="SELECT mrr_id FROM tbl_mrr_head ORDER BY mrr_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		$mrr_id = (int) $row['mrr_id'] + 1;
  	for($i=0;$i<sizeof($materialList);$i++){
  		$expiry_date = date('Y-m-d',strtotime($materialList[$i]['expiry_date']));

  		
  		$mrrQuery .= "INSERT INTO tbl_mrr_material(mrr_id,gate_entry_id,inward_ge_material_id,accepted_quantity,rejected_quantity,mrr_balance_quantity,location_of_disp,material_id,material_number,expiry_date) 
  		VALUES(".$mrr_id.",
  		".$gate_entry_id.",
  		".$materialList[$i]['inward_ge_material_id'].",
  		".$materialList[$i]['accepted_quantity'].",
  		".$materialList[$i]['rejected_quantity'].",
  		".$materialList[$i]['po_balance_qty'].",
  		'".$materialList[$i]['storage_location_code']."',
  		".$materialList[$i]['material_id'].",
  		'".$materialList[$i]['material_number']."',";
  		if($materialList[$i]['expiry_date']==''){
  			$mrrQuery .="'');";
		}else{				
			$mrrQuery .="'$expiry_date');";
		}
	 	}

 $query1ci="SELECT contractor_id FROM tbl_contractor_master where contractor_name='".$mrr['supplier_name']."'";
	   $result1ci = mysqli_query($dbCon,$query1ci);
		$row1ci = mysqli_fetch_array($result1ci,MYSQLI_ASSOC);

	 for($i=0;$i<sizeof($materialList);$i++){
	 	 $storeQuery = '';
	 	 $contractorQuery = '';
	  $storeQuery = "SELECT store_inventory_id FROM tbl_store_inventory 
	 	 WHERE project_id = ".$mrr['project_id']." AND store_id = ".$mrr['store_id']."  
	 	 AND material_number = '".$materialList[$i]['material_number']."'  ORDER BY store_inventory_id DESC LIMIT 1 ;";
		
		 $strresult = mysqli_query($dbCon,$storeQuery);
	    $row4 = $strresult->fetch_assoc();
	    $store_inventory_id = (int)$row4['store_inventory_id'];
		  if($store_inventory_id != '' || $store_inventory_id != null )
		  {
		  	$mrrQuery .= "UPDATE tbl_store_inventory set 
		  	 accepted_quantity = (accepted_quantity + ".$materialList[$i]['accepted_quantity']."),
		  	 remaining_qty = (remaining_qty + ".$materialList[$i]['accepted_quantity'].") 
		  	 WHERE store_inventory_id = ".$store_inventory_id." ;";
		  }
		  else{
	 	 $mrrQuery .= "INSERT INTO tbl_store_inventory(store_id,inventory_type_id,project_id, accepted_quantity, remaining_qty,store_location_id,material_id,material_number) VALUES(".$mrr['store_id'].",'".$mrr['inventory_type_id']."',".$mrr['project_id'].",".$materialList[$i]['accepted_quantity'].",".$materialList[$i]['accepted_quantity'].",'".$materialList[$i]['storage_location_code']."',".$materialList[$i]['material_id'].",'".$materialList[$i]['material_number']."');";
	 	}

if($mrr['inventory_type_id'] == 'Material Return'){
	 	 $contractorQuery = "SELECT contractor_inventory_id FROM tbl_contractor_inventory 
	 	 WHERE project_id = ".$mrr['project_id']." AND store_id = ".$mrr['store_id']." AND contractor_id = ".$row1ci['contractor_id'].";";
		
	/*	$contractor3 = mysqli_query($dbCon,$contractorQuery3);
		$row3c = mysqli_fetch_array($contractor3,MYSQLI_ASSOC);*/

		 $ctrresult = mysqli_query($dbCon,$contractorQuery);
	    $rowc = $ctrresult->fetch_assoc();
	    $contractor_inventory_id = (int)$rowc['contractor_inventory_id'] + 1;


	    $mrrQuery .= "UPDATE tbl_contractor_inventory_material set 
		  	 issued_qty = (issued_qty - ".$materialList[$i]['accepted_quantity'].")
		   
		  	 WHERE material_number='".$materialList[$i]['material_number']."' AND contractor_inventory_id = ".$contractor_inventory_id." ;";
	 	
	 	
	 }
}
	/* if($mrr['inventory_type_id'] == 7){


	 }*/
	 // $mrrQuery .= "UPDATE tbl_gate_entry SET mrr_status='deactive' where gate_entry_id='gate_entry_id';";	
	//echo $mrrQuery;
	echo mysqli_multi_query($dbCon,$mrrQuery);
	break; 

	case "saveMaterialRejection":
	  $mrr = json_decode($_POST["formDataJson1"],true);
	  $materialList = json_decode($_POST["formDataJson2"],true);
	  $rejection_date = date('Y-m-d',strtotime($mrr['rejection_date']));
	  $mrrQuery ='';

	  $mrrQuery .= "UPDATE tbl_mrr_head SET mrr_code='".$mrr['mrr_code']."',
	  gate_entry_id='".$mrr['gate_entry_id']."',
      rejection_date='".$rejection_date."',
      material_rejection_code='".$mrr['material_rejection_code']."',
 	  rejection_status='Return'

 	  WHERE mrr_id='".$mrr['mrr_id']."';";

		// $mrrQuery .="updated_by='".$mrr['updated_by']."',updated_on=now() 		
	 // WHERE mrr_id='".$mrr['mrr_id']."';";


	  for($i=0;$i<sizeof($materialList);$i++){
  	  $mrrQuery .= "UPDATE tbl_mrr_material SET 
  	  	reason_for_rejection='".$materialList[$i]['reason_for_rejection']."'
	  	WHERE mrr_id='".$mrr['mrr_id']."';";
	  }
	  echo mysqli_multi_query($dbCon,$mrrQuery);
	  //echo $mrrQuery;
 	break;

	case "saveMaterialTransferNoteContractor":
	  $mtn = json_decode($_POST["formDataJson1"],true);
	  $storeData = json_decode($_POST["formDataJson2"],true);
	  $transfer_date = date('Y-m-d',strtotime($mtn['transfer_date']));
	  $mtnQuery = '';
       $store_inventory_id="SELECT store_inventory_id from tbl_store_inventory where project_id = '".$mtn[' s_project_id']."'and store_id = '".$mtn['s_store_id']."';";
	   $result = mysqli_query($dbCon,$store_inventory_id);
		$row = $result->fetch_assoc();
		$store_inventory_id = (int) $row['store_inventory_id'];
	//	echo $store_inventory_id;

	  $mtnQuery .= "INSERT INTO tbl_mtn_head(transfer_code,transfer_date,transfer_type,sap_invoice_number,active_status,store_inventory_id,s_project_id,s_store_id,s_contractor_id,d_project_id,d_store_id,d_contractor_id) 
	  VALUES('".$mtn['transfer_code']."',
	  '".$transfer_date."',
	  '".$mtn['transfer_type']."',
	  '".$mtn['sap_invoice_number']."',0,";
         if($store_inventory_id  == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$store_inventory_id .",";
					}
					if($mtn['s_project_id']  == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$mtn['s_project_id'].",";
					}
					if($mtn['$s_store_id'] == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$mtn['s_project_id'].",";
					}
					if($mtn['$s_contractor_id']  == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$mtn['s_contractor_id'].",";
					}
					if($mtn['$d_project_id']  == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$mtn['d_project_id'].",";
					}
					if(['$d_store_id']  == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$mtn['d_store_id'].",";
					}
					if($mtn['d_contractor_id'] == ''){
						$mtnQuery .= "NULL);";
					}else{
						$mtnQuery .= "".$mtn['d_contractor_id'].");";
					}

	  $query="SELECT mtn_id FROM tbl_mtn_head ORDER BY mtn_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		$mtn_id = (int) $row['mtn_id'] + 1;
	  for($i=0;$i<sizeof($storeData);$i++){
  		$mtnQuery .= "INSERT INTO tbl_mtn_material(transfer_quantity,remark,mtn_id,material_id) 
  		VALUES(".$storeData[$i]['transfer_quantity'].",
  		'".$storeData[$i]['remark']."',";
					if(['$mtn_id']  == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$mtn['mtn_id'].",";
					}
					if($mtn['material_id'] == ''){
						$mtnQuery .= "NULL);";
					}else{
						$mtnQuery .= "".$mtn['material_id'].");";
					}
	 	}
	//echo $mtnQuery;
	echo mysqli_multi_query($dbCon,$mtnQuery);
	break;
	case "saveMaterialTransferNote":
	  $mtn = json_decode($_POST["formDataJson1"],true);
	  $storeData = json_decode($_POST["formDataJson2"],true);
	  $transfer_date = date('Y-m-d',strtotime($mtn['transfer_date']));
	  $mtnQuery = '';
       $store_inventory_id="SELECT store_inventory_id from tbl_store_inventory where project_id = '".$mtn[' s_project_id']."'and store_id = '".$mtn['s_store_id']."';";
	   $result = mysqli_query($dbCon,$store_inventory_id);
		$row = $result->fetch_assoc();
		$store_inventory_id = (int) $row['store_inventory_id'];
	//	echo $store_inventory_id;

	  $mtnQuery .= "INSERT INTO tbl_mtn_head(transfer_code,transfer_date,transfer_type,sap_invoice_number,active_status,store_inventory_id,s_project_id,s_store_id,d_project_id,d_store_id) 
	  VALUES('".$mtn['transfer_code']."',
	  '".$transfer_date."',
	  '".$mtn['transfer_type']."',
	  '".$mtn['sap_invoice_number']."',0,";
         if($store_inventory_id  == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$store_inventory_id .",";
					}
					if($mtn['s_project_id']  == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$mtn['s_project_id'].",";
					}
					if($mtn['$s_store_id'] == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$mtn['s_project_id'].",";
					}
					if($mtn['$d_project_id']  == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$mtn['d_project_id'].",";
					}
					if($mtn['d_store_id'] == ''){
						$mtnQuery .= "NULL);";
					}else{
						$mtnQuery .= "".$mtn['d_store_id'].");";
					}

	  $query="SELECT mtn_id FROM tbl_mtn_head ORDER BY mtn_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$query);
		$row = $result->fetch_assoc();
		$mtn_id = (int) $row['mtn_id'] + 1;
	  for($i=0;$i<sizeof($storeData);$i++){
  		$mtnQuery .= "INSERT INTO tbl_mtn_material(transfer_quantity,remark,mtn_id,material_id) 
  		VALUES(".$storeData[$i]['transfer_quantity'].",
  		'".$storeData[$i]['remark']."',";
					if(['$mtn_id']  == ''){
						$mtnQuery .= "NULL,";
					}else{
						$mtnQuery .= "".$mtn['mtn_id'].",";
					}
					if($mtn['material_id'] == ''){
						$mtnQuery .= "NULL);";
					}else{
						$mtnQuery .= "".$mtn['material_id'].");";
					}
	 	}
	echo $mtnQuery;
	//echo mysqli_multi_query($dbCon,$mtnQuery);
	break;
	/****************************Amit W code ends here****************/

	/****************************Madhuri Code Starts here****************/

	case "saveMrrReturn":
		$dArray = json_decode($_POST['formDataJson1'],true);
		$ReferenceMaterialList=json_decode($_POST['formDataJson2'],true);
		$insertQuery = '';

 			$query7 = "select mrr_id from tbl_mrr_head where mrr_code='".$dArray['mrr_code']."'";
            $result7 = mysqli_query($dbCon,$query7);
            $row7 = mysqli_fetch_array($result7,MYSQLI_ASSOC);

		
	    $insertQuery .= "UPDATE tbl_mrr_head SET rejected_return_no = ";
  		
  		if($dArray['rejected_return_no'] == ''){
						$insertQuery .= "NULL,";
					}else{
						$insertQuery .= "'".$dArray['rejected_return_no']."',";
					}

	    if($dArray['return_no'] == ''){
						$insertQuery .= "return_no = NULL";
					}else{
						$insertQuery .= "return_no ='".$dArray['return_no']."'";
					}
          $insertQuery .=  " where mrr_id = ".$dArray['mrr_id'].";";

//echo $insertQuery;
		for($i=0;$i<sizeof($ReferenceMaterialList);$i++){

		$selectQuery = "select return_qty from tbl_store_inventory where material_id = ".$ReferenceMaterialList[$i]['material_id']."";
		$result = mysqli_query($dbCon,$selectQuery);
        //$row = $result->fetch_assoc();
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$return_qty = (int) $row['return_qty'];  		
		$final_return = $return_qty - $ReferenceMaterialList[$i]['return_qty']; 
  		$insertQuery .= "UPDATE tbl_store_inventory SET return_qty =".$final_return." WHERE material_id = ".$ReferenceMaterialList[$i]['material_id']." ;";

       $selectQuery1 = "select return_qty,rejected_quantity,rejected_return_qty from tbl_mrr_material where mrr_material_id = ".$ReferenceMaterialList[$i]['mrr_material_id']."";
		$result3 = mysqli_query($dbCon,$selectQuery1);
        //$row3 = $result3->fetch_assoc();
         $row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
		$return_qty = (int) $row3['return_qty'];  		
		$final_return3 = $return_qty + $ReferenceMaterialList[$i]['return_qty']; 

        $rejected_quantity = (int) $row3['rejected_quantity'];  		
		$final_return1 = $rejected_quantity - $ReferenceMaterialList[$i]['return_qty'];

		$rejected_return_qty = (int) $row3['rejected_return_qty'];  		
		$final_return2 = $rejected_return_qty + $ReferenceMaterialList[$i]['return_qty'];


  	  $insertQuery .= "UPDATE tbl_mrr_material SET return_qty = ".$final_return3.", rejected_quantity = ".$final_return1.", rejected_return_qty = ".$final_return2."

  	    WHERE mrr_material_id = ".$ReferenceMaterialList[$i]['mrr_material_id']."; ";
  			}
   //echo $insertQuery;
  	echo mysqli_multi_query($dbCon,$insertQuery);
  	break;

/****************************Madhuri Code Ends here****************/
}
?>

