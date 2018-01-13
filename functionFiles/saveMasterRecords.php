<?php

require_once 'dbConnection.php';

$operType = isset($_GET['operType'])?$_GET['operType']:"";
switch($_GET['operType']){

/**************************** Amit W code starts here *************************/
	//Customer Master

case "saveCustomer":
		$customer = json_decode($_POST["formDataJson"],true);	
		$customerQuery = "";
    
    	$customerQuery .= "INSERT INTO tbl_customer_master(customer_code,customer_sap_code,customer_name,address1,address2,address3,country_name,state_name,city,gst_no,contact_person,email_id,pan_no,created_by,active_status,pin_code,contact_no) 
    	VALUES('".$customer['customer_code']."',
    			'".$customer['customer_sap_code']."',
    			'".$customer['customer_name']."',
    			'".$customer['address1']."',
    			'".$customer['address2']."',
    			'".$customer['address3']."',
    			'".$customer['country_name']."',
    			'".$customer['state_name']."',    			
    			'".$customer['city']."',
    			'".$customer['gst_no']."',
    			'".$customer['contact_person']."',
       			'".$customer['email_id']."',
    			'".$customer['pan_no']."',
    			'".$customer['created_by']."',0,";            
					if($customer['pin_code'] == ''){
						$customerQuery .= "NULL,";
					}else{
						$customerQuery .= "".$customer['pin_code'].",";
					}
					if($customer['contact_no'] == ''){
						$customerQuery .= "NULL);";
					}else{
						$customerQuery .= "".$customer['contact_no'].");";
					}
	//			echo $customerQuery;
	echo mysqli_query($dbCon,$customerQuery);
break;

case "updateCustomer":
		$customer = json_decode($_POST["formDataJson"],true);
		$customerQuery = "";

		$customerQuery .= "UPDATE tbl_customer_master SET 
			customer_code='".$customer['customer_code']."',
			customer_name='".$customer['customer_name']."',
			customer_sap_code='".$customer['customer_sap_code']."',
			address1='".$customer['address1']."',
			address2='".$customer['address2']."',
			address3='".$customer['address3']."',
			country_name='".$customer['country_name']."',
			state_name='".$customer['state_name']."',
			city='".$customer['city']."',
			fax_no='".$customer['fax_no']."',
			gst_no='".$customer['gst_no']."',
			contact_person='".$customer['contact_person']."',
			email_id='".$customer['email_id']."',
			pan_no='".$customer['pan_no']."',
			updated_by='".$customer['updated_by']."',";
     		
		if($customer['pin_code'] == ''){
			$customerQuery .= "pin_code=NULL,";
		} else {
			$customerQuery .= "pin_code=".$customer['pin_code'].",";
		}	
		if($customer['contact_no'] == ''){
			$customerQuery .= "contact_no=NULL";
		} else {
			$customerQuery .= "contact_no=".$customer['contact_no']."";
		}		
		$customerQuery .= " WHERE customer_id=".$customer['customer_id'].";";
	//echo $customerQuery;
echo mysqli_query($dbCon,$customerQuery);
break;

case "deleteCustomer":
	  $customer = json_decode($_POST["formDataJson"],true);
		$query = "";
    if($customer['active_status']==0){
    $query .= "UPDATE tbl_customer_master SET active_status=1,deleted_by='".$customer['deleted_by']."',deleted_on=now() WHERE customer_id=".$customer['customer_id']."";
}else{
	$query .= "UPDATE tbl_customer_master SET active_status=0,deleted_by='".$customer['deleted_by']."',deleted_on=now() WHERE customer_id=".$customer['customer_id']."";
}
	//echo $query;
 echo mysqli_query($dbCon,$query);
break;
	 

	//Project Master

case "saveProject":
		$project = json_decode($_POST["formDataJson"],true);
		$projectQuery = "";
		$start_date = date('Y-m-d',strtotime($project['start_date']));
		$end_date = date('Y-m-d',strtotime($project['end_date']));

	  	$projectQuery .= "INSERT INTO tbl_project_master(project_code, project_name,project_location, manager_name,contact_no, email_id, address1,plant_name,address2,address3,city,state_name,country_name,start_date, end_date,wbs,created_by,active_status,pin_code) 
	  		VALUES('".$project['project_code']."',
	  				'".$project['project_name']."',
	  				'".$project['project_location']."',
	  				'".$project['manager_name']."',
	  				'".$project['contact_no']."',
	  				'".$project['email_id']."',
	  				'".$project['address1']."',
	  				'".$project['plant_name']."',
	  				'".$project['address2']."',
	  				'".$project['address3']."',
	  				'".$project['city']."',
	  				'".$project['state_name']."',
	  				'".$project['country_name']."',
	  				'".$start_date."',
	  				'".$end_date."',
	  				'".$project['wbs']."',
	  				'".$project['created_by']."',0,";
                if($project['pin_code'] == ''){
						$projectQuery .= "NULL);";
					}else{
						$projectQuery .= "".$project['pin_code'].");";
					}
					//echo $projectQuery;
echo mysqli_query($dbCon,$projectQuery);
break;

case "updateProject":
	  	$project = json_decode($_POST["formDataJson"],true);
		$projectQuery = "";
		$start_date = date('Y-m-d',strtotime($project['start_date']));
		$end_date = date('Y-m-d',strtotime($project['end_date']));
		$projectQuery .= "UPDATE tbl_project_master SET 
			project_code='".$project['project_code']."',
			project_name='".$project['project_name']."',
			project_location='".$project['project_location']."',
			manager_name='".$project['manager_name']."',
			contact_no='".$project['contact_no']."',
			email_id='".$project['email_id']."',
			plant_name='".$project['plant_name']."',
			address1='".$project['address1']."',
			address2='".$project['address2']."',
			address3='".$project['address3']."',
			city='".$project['city']."',
			state_name='".$project['state_name']."',
			country_name='".$project['country_name']."',
			start_date='".$start_date."',
			end_date='".$end_date."',
			wbs='".$project['wbs']."',
			updated_by='".$project['updated_by']."',";	
		if($project['pin_code'] == ''){
			$projectQuery .= "pin_code=null";
		} else {
			$projectQuery .= "pin_code=".$project['pin_code']."";
		}		
		$projectQuery .= " WHERE project_id=".$project['project_id'].";";
	echo mysqli_query($dbCon,$projectQuery);
break;

case "deleteProject":
	  $project = json_decode($_POST["formDataJson"],true);
		$query = "";
    if($project['active_status']==0){
    $query .= "UPDATE tbl_project_master SET active_status=1,deleted_by='".$project['deleted_by']."',deleted_on=now() WHERE project_id=".$project['project_id']."";
}else{
	$query .= "UPDATE tbl_project_master SET active_status=0,deleted_by='".$project['deleted_by']."',deleted_on=now() WHERE project_id=".$project['project_id']."";
}
	//echo $query;
 echo mysqli_query($dbCon,$query);
break;

	//Vendor Master

case "saveVendor":
	  	$vendor = json_decode($_POST["formDataJson"],true);	
		$vendorQuery = "";
    
    	$vendorQuery .= "INSERT INTO tbl_vendor_master(vendor_code, vendor_name, vendor_sap_id, address1,address2,address3,city,contact_person,email_id,pan_details,gst_no,country_name,state_name,created_by,active_status,pin_code,contact_no) 
   			VALUES('".$vendor['vendor_code']."',
   					'".$vendor['vendor_name']."',
   					'".$vendor['vendor_sap_id']."',
   					'".$vendor['address1']."',
   					'".$vendor['address2']."',
   					'".$vendor['address3']."',
   					'".$vendor['city']."',
   					'".$vendor['contact_person']."',
   					'".$vendor['email_id']."',
   					'".$vendor['pan_details']."',
   					'".$vendor['gst_no']."',
   					'".$vendor['country_name']."',
   					'".$vendor['state_name']."',
   					'".$vendor['created_by']."',0,";            
					 if($vendor['pin_code'] == ''){
						$vendorQuery .= "NULL,";
					}else{
						$vendorQuery .= "".$vendor['pin_code'].",";
					}
					if($vendor['contact_no'] == ''){
						$vendorQuery .= "NULL);";
					}else{
						$vendorQuery .= "".$vendor['contact_no'].");";
					}
					//echo $vendorQuery;
	echo mysqli_query($dbCon,$vendorQuery);
break;

case "updateVendor":
	  	$vendor = json_decode($_POST["formDataJson"],true);
		$vendorQuery = "";
		$vendorQuery .= "UPDATE tbl_vendor_master SET 
			vendor_code='".$vendor['vendor_code']."',
			vendor_name='".$vendor['vendor_name']."',
			vendor_sap_id='".$vendor['vendor_sap_id']."',
			address1='".$vendor['address1']."',
			address2='".$vendor['address2']."',
			address3='".$vendor['address3']."',
			city='".$vendor['city']."',
			contact_person='".$vendor['contact_person']."',
			email_id='".$vendor['email_id']."',
			country_name='".$vendor['country_name']."',
			state_name='".$vendor['state_name']."',
			pan_details='".$vendor['pan_details']."',
			gst_no='".$vendor['gst_no']."',
			updated_by='".$vendor['updated_by']."',";
		if($vendor['pin_code'] == ''){
			$vendorQuery .= "pin_code=null,";
		} else {
			$vendorQuery .= "pin_code=".$vendor['pin_code'].",";
		}	
		if($vendor['contact_no'] == ''){
			$vendorQuery .= "contact_no=null";
		} else {
			$vendorQuery .= "contact_no=".$vendor['contact_no']."";
		}		
		$vendorQuery .= " WHERE vendor_id=".$vendor['vendor_id'].";";
	//echo $vendorQuery;
	echo mysqli_query($dbCon,$vendorQuery);
break;
case "deleteVendor":
	  $vendor = json_decode($_POST["formDataJson"],true);
	//  echo $vendor['active_status'];
	$query = "";
    if($vendor['active_status']==0){
    $query .= "UPDATE tbl_vendor_master SET active_status=1,deleted_by='".$vendor['deleted_by']."',deleted_on=now() WHERE vendor_id=".$vendor['vendor_id']."";
}else{
	$query .= "UPDATE tbl_vendor_master SET active_status=0,deleted_by='".$vendor['deleted_by']."',deleted_on=now() WHERE vendor_id=".$vendor['vendor_id']."";
}
	//echo $query;
 echo mysqli_query($dbCon,$query);
break;
	//Material Master

case "saveMaterial":
	  	$material = json_decode($_POST["formDataJson"],true);
		$materialQuery = "";
		// $mfg_date = date('Y-m-d',strtotime($material['mfg_date']));
		// $expiry_date = date('Y-m-d',strtotime($material['expiry_date']));
    	$materialQuery .= "INSERT INTO tbl_material_master(material_code,
    		material_name,material_description,material_type,expiry_status,reorder_level,unit_of_measurment,secondary_uom,created_by,active_status,unit_price,min_quantity,max_quantity,reorder_quantity) 
    		VALUES('".$material['material_code']."',
    				'".$material['material_name']."',
    				'".$material['material_description']."',
    				'".$material['material_type']."',
    				'".$material['expiry_status']."',
    				'".$material['reorder_level']."',
    				'".$material['unit_of_measurment']."',
    				'".$material['secondary_uom']."',
					'".$material['created_by']."',0,";

					if($material['unit_price'] == ''){
						$materialQuery .= "NULL,";
					}else{
						$materialQuery .= "".$material['unit_price'].",";
					}
					if($material['min_quantity'] == ''){
						$materialQuery .= "NULL,";
					}else{
						$materialQuery .= "".$material['min_quantity'].",";
					}
					if($material['max_quantity'] == ''){
						$materialQuery .= "NULL,";
					}else{
						$materialQuery .= "".$material['max_quantity'].",";
					}
					if($material['reorder_quantity'] == ''){
						$materialQuery .= "NULL);";
					}else{
						$materialQuery .= "".$material['reorder_quantity'].");";
					}

					//echo $materialQuery;
	//echo $materialQuery;
echo mysqli_query($dbCon,$materialQuery);
break;

case "updateMaterial":
	  	$material = json_decode($_POST["formDataJson"],true);
		$materialQuery = "";

		$materialQuery.="UPDATE tbl_material_master SET material_code='".$material['material_code']."',
			material_name='".$material['material_name']."',
			material_description='".$material['material_description']."',
			material_type='".$material['material_type']."',
			unit_of_measurment='".$material['unit_of_measurment']."',
			updated_by='".$material['updated_by']."',";
 
		if($material['expiry_status'] == ''){
			$materialQuery .= "expiry_status=NULL,";
		} else {
			$materialQuery .= "expiry_status='".$material['expiry_status']."',";
		}
 		if($material['reorder_level'] == ''){
			$materialQuery .= "reorder_level=NULL,";
		} else {
			$materialQuery .= "reorder_level='".$material['reorder_level']."',";
		}
  		if($material['secondary_uom'] == ''){
			$materialQuery .= "secondary_uom=NULL,";
		} else {
			$materialQuery .= "secondary_uom='".$material['secondary_uom']."',";
		}
  		if($material['unit_price'] == ''){
			$materialQuery .= "unit_price=NULL,";
		} else {
			$materialQuery .= "unit_price=".$material['unit_price'].",";
		}
		if($material['min_quantity'] == ''){
			$materialQuery .= "min_quantity=NULL,";
		} else {
			$materialQuery .= "min_quantity=".$material['min_quantity'].",";
		}
		if($material['max_quantity'] == ''){
			$materialQuery .= "max_quantity=NULL,";
		} else {
			$materialQuery .= "max_quantity=".$material['max_quantity'].",";
		}
		if($material['max_quantity'] == ''){
			$materialQuery .= "max_quantity=NULL";
		} else {
			$materialQuery .= "max_quantity=".$material['max_quantity']."";
		}

		$materialQuery .= " WHERE material_id=".$material['material_id'].";";

	  echo mysqli_multi_query($dbCon,$materialQuery);
		//echo $materialQuery;
break;

case "deleteMaterial":
	  $material = json_decode($_POST["formDataJson"],true);
		$query = "";
    if($material['active_status']==0){
    $query .= "UPDATE tbl_material_master SET active_status=1,deleted_by='".$material['deleted_by']."',deleted_on=now() WHERE material_id=".$material['material_id']."";
}else{
	$query .= "UPDATE tbl_material_master SET active_status=0,deleted_by='".$material['deleted_by']."',deleted_on=now() WHERE material_id=".$material['material_id']."";
}
	//echo $query;
 echo mysqli_query($dbCon,$query);
break;

case "saveUOM":
	  	$uom = json_decode($_POST["formDataJson"],true);	
		$uomQuery = "";
    
    	$uomQuery .= "INSERT INTO tbl_uom_master(uom_name,uom_description,active_status) 
    		VALUES('".$uom['uom_name']."',	
    			'".$uom['uom_description']."',0);";
    	//echo $uomQuery;

	echo mysqli_query($dbCon,$uomQuery);
break;

case "updateUOM":
	  	$uom = json_decode($_POST["formDataJson"],true);
	  	$uomQuery = "";

		$uomQuery .= "UPDATE tbl_uom_master SET 
			uom_name='".$uom['uom_name']."',
			uom_description='".$uom['uom_description']."'
			WHERE uom_id=".$uom['uom_id'].";";
	echo mysqli_query($dbCon,$uomQuery);
break;

case "deleteUOM":
	 	$uom = json_decode($_POST["formDataJson"],true);
		$uomQuery = "";
    
    	$uomQuery .= "UPDATE tbl_uom_master SET active_status=1 WHERE uom_id=".$uom['uom_id']."";
	echo mysqli_multi_query($dbCon,$uomQuery);
break;
/**************************** Amit W code ends here *************************/

/**************************** Tarun code starts here *************************/
case "saveRole1":
  	$user = json_decode($_POST["formDataJson"],true);
  	// print_r($user);die;
  	$query = '';
  	//$permision ='{'.$user['master_data'].','.$user['inventory'].','.$user['indent'].'}';
  	$permission = array();
  	if(!empty( $user['master_data'])){
  	  $permission[] = $user['master_data'];
  	}
  	if(!empty( $user['inventory'])){
  	  $permission[] = $user['inventory'];
  	}if(!empty( $user['indent'])){
  	  $permission[] = $user['indent'];
  	}if(!empty( $user['gate_entry'])){
  	  $permission[] = $user['gate_entry'];
  	}if(!empty( $user['material_receipt'])){
  	  $permission[] = $user['material_receipt'];
  	}if(!empty( $user['material_rejection'])){
  	  $permission[] = $user['material_rejection'];
  	}if(!empty( $user['material_issue'])){
  	  $permission[] = $user['material_issue'];
  	}if(!empty( $user['material_transfer'])){
  	  $permission[] = $user['material_transfer'];
  	}if(!empty( $user['material_return'])){
  	  $permission[] = $user['material_return'];
  	}if(!empty( $user['reports'])){
  	  $permission[] = $user['reports'];
  	}
  	
  /*	$array
  	$material_rejection = $arr['material_rejection'];*/
  	echo $permission = json_encode($permission);

  	$query .= "INSERT INTO tbl_user_role(user_role,description,master_data_access) VALUES('".$user['user_role']."','".$user['discription']."','".$permission."');";

  	$query .="INSERT INTO tbl_securityroles(secrolename) VALUES('".$user['user_role']."')";

  

  /*	if($user['dept_id'] == ''){
  		$query .= "NULL);";
  	} else {
  		$query .= "".$user['dept_id'].");";
  	}*/
   echo $query;
  	echo mysqli_multi_query($dbCon,$query);
  	echo mysqli_error($dbCon);

        $query3 = "select secroleid from tbl_securityroles where secrolename='".$user['user_role']."'";
		$result3 = mysqli_query($dbCon,$query3);
		$row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
	    // echo $result3;

  		if($user['master_data'] == 1 ){

    $query1 ="INSERT INTO tbl_securitygroups(secroleid) VALUES('".$row3['secroleid']."')";
  	 mysqli_query($dbCon,$query1);
   

  	}
  	 echo $query1;
	break;


case "saveRole":
  	$user = json_decode($_POST["formDataJson"],true);
  	$query = '';
  	$query .= "INSERT INTO tbl_user_role(user_role,description,master_data_access,inventory_access,indent_access,gate_entry_access,material_receipt_access,material_rejection_access,material_issue_access,material_transfer_note_access,material_return_access,reports_access) VALUES('".$user['user_role']."','".$user['discription']."','".$user['master_data']."','".$user['inventory']."','".$user['indent']."','".$user['gate_entry']."','".$user['material_receipt']."','".$user['material_rejection']."','".$user['material_issue']."','".$user['material_transfer']."','".$user['material_return']."','".$user['reports']."');";

  	$query .="INSERT INTO tbl_securityroles(secrolename) VALUES('".$user['user_role']."')";

  

  /*	if($user['dept_id'] == ''){
  		$query .= "NULL);";
  	} else {
  		$query .= "".$user['dept_id'].");";
  	}*/
   echo $query;
  	echo mysqli_multi_query($dbCon,$query);

        $query3 = "select secroleid from tbl_securityroles where secrolename='".$user['user_role']."'";
		$result3 = mysqli_query($dbCon,$query3);
		$row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
	    echo $result3;

  		if($user['master_data'] == 1 ){

    $query1 ="INSERT INTO tbl_securitygroups(secroleid) VALUES('".$row3['secroleid']."')";


  	}
  	echo $query1;
  	echo mysqli_query($dbCon,$query1);
	break;

case "saveUser":
  	$user = json_decode($_POST["formDataJson"],true);
  	$query = '';
  	$query .= "INSERT INTO tbl_user_master(user_name,password,user_role,user_fullname,email_id,mobile_number,user_location) VALUES('".$user['user_name']."','".$user['password']."','".$user['user_role']."','".$user['user_fullname']."','".$user['email_id']."','".$user['mobile_number']."',NULL)";

  /*	if($user['dept_id'] == ''){
  		$query .= "NULL);";
  	} else {
  		$query .= "".$user['dept_id'].");";
  	}*/
  echo $query;
  	echo mysqli_query($dbCon,$query);
	break;



/**************************** Tarun code ends here *************************/



/**************************Sujata Code Starts Here*********************/


	//Storage Location Master


case "saveSite":
	  	$site = json_decode($_POST["formDataJson"],true);
	  	$siteList= json_decode($_POST["formDataJson1"],true);	
		$siteQuery = "";
		$siteQueryMaterial = "";

$siteQuery .= "INSERT INTO tbl_site_master_header(project_id,store_id) 
    		VALUES(".$site['project_id'].",
    		     ".$site['store_id'].");";

    		     $site_header_id="SELECT site_header_id FROM tbl_site_master_header ORDER BY site_header_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$site_header_id);
        $row = $result->fetch_assoc();
		$site_header_id = (int) $row['site_header_id'] + 1;
	

for($i=0;$i<sizeof($siteList);$i++){
    	$siteQuery .= "INSERT INTO tbl_site_master_main(site_name,site_location,site_header_id,created_by,active_status,site_engineer_name) 
    		VALUES('".$siteList[$i]['site_name']."',
    			'".$siteList[$i]['site_location']."',
    			".$site_header_id.",
    			'".$site['created_by']."',0,";

    if($siteList[$i]['site_engineer_name'] == ''){
			$siteQuery .= "NULL);";
		} else {
			$siteQuery .= "'".$siteList[$i]['site_engineer_name']."');";
		}
    		}
    //echo $siteQuery;
	echo mysqli_multi_query($dbCon,$siteQuery);
break;


	
	case "saveStorage":
	  	$storage = json_decode($_POST["formDataJson"],true);
	  	$storageList = json_decode($_POST["formDataJson1"],true);	
		$storageQuery = "";
    
   
    	$storageQuery .= "INSERT INTO tbl_storage_master_header(project_id,store_id) 
    		VALUES(".$storage['project_id'].",
    		     ".$storage['store_id'].");";

    		      $storage_header_id="SELECT storage_header_id FROM tbl_storage_master_header ORDER BY storage_header_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$storage_header_id);
        $row = $result->fetch_assoc();
		$storage_header_id = (int) $row['storage_header_id'] + 1;
    		// echo $storageQuery;
    		for($i=0;$i<sizeof($storageList);$i++){
    	$storageQuery .= "INSERT INTO tbl_storage_master_main(storage_location_code,storage_location_name,storage_header_id,created_by,active_status) 
    		VALUES('".$storageList[$i]['storage_location_code']."',
    			'".$storageList[$i]['storage_location_name']."',
    			".$storage_header_id.",
    			'".$storage['created_by']."',0);";
    		}

    //echo $storageQuery;
	echo mysqli_multi_query($dbCon,$storageQuery);
break;

case "updateStorage":
	  	$storage = json_decode($_POST["formDataJson"],true);
	    $storageList = json_decode($_POST["formDataJson1"],true);	
	  	$storageQuery = "";

      for($i=0;$i<sizeof($storageList);$i++){
		$storageQuery .= "UPDATE tbl_storage_location_master SET 
			storage_location_code='".$storageList[$i]['storage_location_code']."',
			storage_location_name='".$storageList[$i]['storage_location_name']."',
			updated_by='".$storage['updated_by']."'
			WHERE storage_id=".$storageList[$i]['storage_id'].";";
		}
echo $storageQuery;
	echo mysqli_multi_query($dbCon,$storageQuery);
break;

case "deleteStorage":
	 	$storage = json_decode($_POST["formDataJson"],true);
		$storageQuery = "";

		if($storage['active_status']==0){
    $storageQuery .= "UPDATE tbl_storage_location_master SET active_status=1,deleted_by='".$storage['deleted_by']."',deleted_on=now() WHERE storage_id=".$storage['storage_id']."";
}else{
	$storageQuery .= "UPDATE tbl_storage_location_master SET active_status=0,deleted_by='".$storage['deleted_by']."',deleted_on=now() WHERE storage_id=".$storage['storage_id']."";
}
    
	echo mysqli_multi_query($dbCon,$storageQuery);
break;


	//Store Master
case "saveStore":
	  	$store = json_decode($_POST["formDataJson"],true);
		$storeQuery = "";
    	$storeQuery = "INSERT INTO tbl_store_master(store_name,store_address1,address2,address3,state_name,country_name,city,store_location,store_supervisor_name,created_by,active_status,project_id)
    		VALUES('".$store['store_name']."',
    			   '".$store['store_address1']."',
    			   '".$store['address2']."',
    			   '".$store['address3']."',
    			    '".$store['state_name']."',
                    '".$store['country_name']."', 
                   '".$store['city']."',
    			   '".$store['store_location']."',
    			   '".$store['store_supervisor_name']."',
    			   '".$store['created_by']."',0,";
    			   if($store['project_id'] == ''){
			          $storeQuery .= "NULL);";
		           } else {
			       $storeQuery .= "".$store['project_id'].");";
		          }  
	    		 
    	//echo $storeQuery;

     echo mysqli_query($dbCon,$storeQuery);
break;

case "updateStore":
	 	$store = json_decode($_POST["formDataJson"],true);
		$storeQuery = "";

		$storeQuery .= "UPDATE tbl_store_master SET 
			store_name='".$store['store_name']."',
			store_address1='".$store['store_address1']."',
			address2='".$store['address2']."',
			address3='".$store['address3']."',
			city='".$store['city']."',
			country_name='".$store['country_name']."',
			state_name='".$store['state_name']."',
			store_location='".$store['store_location']."',
			store_supervisor_name='".$store['store_supervisor_name']."',
			updated_by='".$store['updated_by']."'
			WHERE store_id=".$store['store_id'].";";
	echo mysqli_query($dbCon,$storeQuery);
break;

case "deleteStore":
	  	 $store = json_decode($_POST["formDataJson"],true);
		$query = "";
    if($store['active_status']==0){
    $query .= "UPDATE tbl_store_master SET active_status=1,deleted_by='".$store['deleted_by']."',deleted_on=now() WHERE store_id=".$store['store_id']."";
}else{
	$query .= "UPDATE tbl_store_master SET active_status=0,deleted_by='".$store['deleted_by']."',deleted_on=now() WHERE store_id=".$store['store_id']."";
}
	echo mysqli_multi_query($dbCon,$query);
break;



	//Site Master

case "saveSite":
	  	$site = json_decode($_POST["formDataJson"],true);
	  	$siteList= json_decode($_POST["formDataJson1"],true);	
		$siteQuery = "";
		$siteQueryMaterial = "";

$siteQuery .= "INSERT INTO tbl_site_master_header(project_id,store_id) 
    		VALUES(".$site['project_id'].",
    		     ".$site['store_id'].");";

    		     $site_header_id="SELECT site_header_id FROM tbl_site_master_header ORDER BY site_header_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$site_header_id);
        $row = $result->fetch_assoc();
		$site_header_id = (int) $row['site_header_id'] + 1;
	

for($i=0;$i<sizeof($siteList);$i++){
    	$siteQuery .= "INSERT INTO tbl_site_master_main(site_name,site_location,site_header_id,created_by,active_status,site_engineer_name) 
    		VALUES('".$siteList[$i]['site_name']."',
    			'".$siteList[$i]['site_location']."',
    			".$site_header_id.",
    			'".$site['created_by']."',0,";

    if($siteList[$i]['site_engineer_name'] == ''){
			$siteQuery .= "NULL);";
		} else {
			$siteQuery .= "'".$siteList[$i]['site_engineer_name']."');";
		}
    		}
    //echo $siteQuery;
	echo mysqli_multi_query($dbCon,$siteQuery);
break;

case "updateSite":

        $site = json_decode($_POST["formDataJson"],true);
	  	$siteList = json_decode($_POST["formDataJson1"],true);
		$siteQuery = "";

       for($i=0;$i<sizeof($siteList);$i++){
       $siteQuery .= "UPDATE tbl_site_master SET 
			project_id=".$site['project_id'].",
			store_id=".$site['store_id'].",
			site_name='".$siteList[$i]['site_name']."',
			site_location='".$siteList[$i]['site_location']."',
			site_engineer_name='".$siteList[$i]['site_engineer_name']."',
			updated_by='".$siteList['updated_by']."'
			WHERE site_id=".$siteList[$i]['site_id'].";";
		}
		//echo $siteQuery;
	echo mysqli_multi_query($dbCon,$siteQuery);
break;

case "deleteSite":
        $site = json_decode($_POST["formDataJson"],true);
	  	$siteList = json_decode($_POST["formDataJson1"],true);
		$query = "";
    
      if($site['active_status']==0){
    $query .= "UPDATE tbl_site_master SET active_status=1,deleted_by='".$site['deleted_by']."',deleted_on=now()   WHERE  site_id=".$site['site_id']."";
}else{
	$query .= "UPDATE tbl_site_master SET active_status=0,deleted_by='".$site['deleted_by']."',deleted_on=now() WHERE  site_id=".$site['site_id']."";
}
	 echo mysqli_multi_query($dbCon,$query);
break;

	//Activity Master

case "saveActivity":
	  	$activity = json_decode($_POST["formDataJson"],true);	
		$activityQuery = "";
    
    	$activityQuery .= "INSERT INTO tbl_activity_master(activity_code,activity_name,created_by,active_status) 
    		VALUES('".$activity['activity_code']."',	
    			'".$activity['activity_name']."',
    			'".$activity['created_by']."',0);";
    		//echo $activityQuery;

	echo mysqli_multi_query($dbCon,$activityQuery);
break;

case "updateActivity":
	  	$activity = json_decode($_POST["formDataJson"],true);
	  	$activityQuery = "";

		$activityQuery .= "UPDATE tbl_activity_master SET 
			activity_code='".$activity['activity_code']."',
			activity_name='".$activity['activity_name']."',
			updated_by='".$activity['updated_by']."'
			WHERE activity_id=".$activity['activity_id'].";";
	echo mysqli_query($dbCon,$activityQuery);
break;

case "deleteActivity":
	 	$activity = json_decode($_POST["formDataJson"],true);
		$activityQuery = "";

		if($activity['active_status']==0){
    $activityQuery .= "UPDATE tbl_activity_master SET active_status=1,deleted_by='".$activity['deleted_by']."',deleted_on=now() WHERE activity_id=".$activity['activity_id']."";
}else{
	$activityQuery .= "UPDATE tbl_activity_master SET active_status=0,deleted_by='".$activity['deleted_by']."',deleted_on=now() WHERE activity_id=".$activity['activity_id']."";
}
    
    	/*$activityQuery .= "UPDATE tbl_activity_master SET active_status=1,deleted_by='".$activity['deleted_by']."',deleted_on=now() WHERE activity_id=".$activity['activity_id']."";*/
	echo mysqli_multi_query($dbCon,$activityQuery);
break;

	//Contractor Master

case "saveContractor":
$contractor = json_decode($_POST["formDataJson"],true);	
		$contractorQuery = "";
    	$contractorQuery .= "INSERT INTO tbl_contractor_master(contractor_name,contractor_code,contractor_address1,address2,address3,city,state_name,country_name,pan_details,gstin_no,contact_person,created_by,active_status,pin_code,contact_no)    	
    		VALUES('".$contractor['contractor_name']."',
    		    '".$contractor['contractor_number']."',
    			'".$contractor['contractor_address1']."',
    			'".$contractor['address2']."',
    			'".$contractor['address3']."',
    			'".$contractor['city']."',
    			'".$contractor['state_name']."',
                '".$contractor['country_name']."',
    			'".$contractor['pan_details']."',
    			'".$contractor['gstin_no']."',
    			'".$contractor['contact_person']."',
    			'".$contractor['created_by']."',0,";
           

					if($contractor['pin_code'] == ''){
						$contractorQuery .= "NULL,";
					}else{
						$contractorQuery .= "".$contractor['pin_code'].",";
					}

					if($contractor['contact_no'] == ''){
						$contractorQuery .= "NULL);";
					}else{
						$contractorQuery .= "".$contractor['contact_no'].");";
					}
					//echo $contractorQuery;
	echo mysqli_query($dbCon,$contractorQuery);
	break;

case "updateContractor":
	  	$contractor = json_decode($_POST["formDataJson"],true);
		$contractorQuery = "";

		$contractorQuery .= "UPDATE tbl_contractor_master SET 
			contractor_name='".$contractor['contractor_name']."',
			contractor_address1='".$contractor['contractor_address1']."',
			address2='".$contractor['address2']."',
			address3='".$contractor['address3']."',
			city='".$contractor['city']."',
			state_name='".$contractor['state_name']."',
			country_name='".$contractor['country_name']."',
			pan_details='".$contractor['pan_details']."',
			gstin_no='".$contractor['gstin_no']."',
			contact_person='".$contractor['contact_person']."',
			updated_by='".$contractor['updated_by']."',";
         
		if($contractor['pin_code'] == ''){
			$contractorQuery .= "pin_code=null,";
		} else {
			$contractorQuery .= "pin_code=".$contractor['pin_code'].",";
		}	
		if($contractor['contact_no'] == ''){
			$contractorQuery .= "contact_no=null";
		} else {
			$contractorQuery .= "contact_no=".$contractor['contact_no']."";
		}			
		$contractorQuery .= " WHERE contractor_id=".$contractor['contractor_id'].";";
	//echo $contractorQuery;
	echo mysqli_query($dbCon,$contractorQuery);
break;

case "deleteContractor":
	  	$contractor = json_decode($_POST["formDataJson"],true);
		$contractorQuery = "";
    
    	 if($contractor['active_status']==0){
    $contractorQuery .= "UPDATE tbl_contractor_master SET active_status=1,deleted_by='".$contractor['deleted_by']."',deleted_on=now() WHERE contractor_id=".$contractor['contractor_id']."";
}else{
	$contractorQuery .= "UPDATE tbl_contractor_master SET active_status=0,deleted_by='".$contractor['deleted_by']."',deleted_on=now() WHERE contractor_id=".$contractor['contractor_id']."";
}
	echo mysqli_multi_query($dbCon,$contractorQuery);
break;

/*********************Sujata Code ends Here**********************/
case "uploadFile":
// $json = file_get_contents('php://input');
// $getData = json_decode($json, true);
// $excel = json_decode($getData["formDataJson1"],true);
// $excelData = json_decode($getData["formDataJson2"],true);

if(!empty($_FILES))  
 {  
      $path = 'upload/' . $_FILES['file']['name'];  
      if(move_uploaded_file($_FILES['file']['tmp_name'], $path))  
      {  
           $insertQuery = "INSERT INTO tbl_bom_master(name) VALUES ('".$_FILES['file']['name']."')";  
           if(mysqli_query($connect, $insertQuery))  
           {  
                echo 'File Uploaded';  
           }  
           else  
           {  
                echo 'File Uploaded But not Saved';  
           }  
      }  
 }  
 else  
 {  
      echo 'Some Error';  
 }  

  break;

// case "uploadFile":
// $jsonData1 = stripslashes(html_entity_decode($_GET["formDataJson"]));
//   $dArray = json_decode($jsonData1,true);   
//  if(isset($_FILES["file"]["type"]))
//     if($dArray[bom_name] != ''){
//     	echo $dArray;

// { 
//   $upload_dir = 	
// '..//UploadDocument//'.$dArray[bom_name].'//'.$dArray[soil_type].'//'.$dArray[tower_type].'//'.$dArray[activity_id].'//'; 
// if (!is_dir($upload_dir)) {
//     mkdir($upload_dir, 0755, true);
// }
// echo $upload_dir;
//     $validextensions = array("jpeg", "jpg", "png", "gif","txt","docx","pdf","xlsx");
//     $temporary = explode(".", $_FILES["file"]["name"]);

//     $file_extension = end($temporary);
//     if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg")) || ($_FILES["file"]["type"] == "text/plain") || ($_FILES["file"]["type"] == "application/xlsx") || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")|| ($_FILES["file"]["type"] == "application/pdf")|| ($_FILES["file"]["type"] == "application/msword")|| ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")&& in_array($file_extension, $validextensions)) {
//         if ($_FILES["file"]["error"] > 0){
//             echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
//         } else {
//             if (file_exists($upload_dir.$_FILES["file"]["name"])) {  $arrayName = array('MESSAGE' => 'File already exist');
//                 $json=json_encode($arrayName); 
//                 header('Content-Type: application/json');
//                 echo $json;              
                
//             } else {
//                 $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
//                 $filename = $_FILES['file']['name'];
//                 $targetPath = $upload_dir.$filename; // Target path where file is to be stored
//                 move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
//                 $arrayName = array('MESSAGE' => 'file uploaded successfully');
//                 $json=json_encode($arrayName); 
//                 header('Content-Type: application/json');
//                 echo $json;
                 
               
//             }
//         }
//     } 
// }
// }
//  break;
/**********************************************Suraj B Code Starts Here****************************/
//Activity Master

case "saveActivityTransaction":
	  	$activityTransaction = json_decode($_POST["formDataJson"],true);	
		$activityTransactionQuery = "";
    
    	$activityTransactionQuery .= "INSERT INTO tbl_activity_transaction_master(created_by,active_status,activity_id,project_id,store_id,site_master_main_id) 
    		VALUES(	'".$activityTransaction['created_by']."',0,";
                if($activityTransaction['activity_id'] == ''){
						$activityTransactionQuery .= "NULL,";
					}else{
						$activityTransactionQuery .= "".$activityTransaction['activity_id'].",";
					}
					if($activityTransaction['project_id'] == ''){
						$activityTransactionQuery .= "NULL,";
					}else{
						$activityTransactionQuery .= "".$activityTransaction['project_id'].",";
					}
					if($activityTransaction['store_id'] == ''){
						$activityTransactionQuery .= "NULL,";
					}else{
						$activityTransactionQuery .= "".$activityTransaction['store_id'].",";
					}
					if($activityTransaction['site_master_main_id'] == ''){
						$activityTransactionQuery .= "NULL,";
					}else{
						$activityTransactionQuery .= "".$activityTransaction['site_master_main_id'].");";
					}
	echo mysqli_query($dbCon,$activityTransactionQuery);
    //echo $activityTransactionQuery;
break;

case "updateActivityTransaction":
	  	$activityTransaction = json_decode($_POST["formDataJson"],true);
	  	$activityTransactionQuery = "";

		$activityTransactionQuery .= "UPDATE tbl_activity_transaction_master SET 
			updated_by='".$activityTransaction['updated_by']."',";
         if($activityTransaction['activity_id'] == ''){
			$activityTransactionQuery .= "activity_id=null";
		} else {
			$activityTransactionQuery .= "activity_id=".$activityTransaction['activity_id'].",";
		}	
		if($activityTransaction['project_id'] == ''){
			$activityTransactionQuery .= "project_id=null";
		} else {
			$activityTransactionQuery .= "project_id=".$activityTransaction['project_id']."";
		}			
		$activityTransactionQuery .= " WHERE activity_transaction_id=".$activityTransaction['activity_transaction_id'].";";
	//echo $activityTransactionQuery;
	echo mysqli_query($dbCon,$activityTransactionQuery);
break;

case "deleteActivityTransaction":
	 	$activityTransaction = json_decode($_POST["formDataJson"],true);
		$activityTransactionQuery = "";

		if($activityTransaction['active_status']==0){
    $activityTransactionQuery .= "UPDATE tbl_activity_transaction_master SET active_status=1,deleted_by='".$activityTransaction['deleted_by']."',deleted_on=now() WHERE activity_transaction_id=".$activityTransaction['activity_transaction_id']."";
}else{
	$activityTransactionQuery .= "UPDATE tbl_activity_transaction_master SET active_status=0,deleted_by='".$activityTransaction['deleted_by']."',deleted_on=now() WHERE activity_transaction_id=".$activityTransaction['activity_transaction_id']."";
}
    
    	/*$activityTransactionQuery .= "UPDATE tbl_activity_transaction_master SET active_status=1,deleted_by='".$activityTransaction['deleted_by']."',deleted_on=now() WHERE activity_transaction_id=".$activityTransaction['activity_transaction_id']."";*/
    	//echo $activityTransactionQuery;
	echo mysqli_multi_query($dbCon,$activityTransactionQuery);
break;


/*************************************Suraj B Code Ends Here*************************/

}
function sendSMS($url1){
	$url =$url1;
	$url = str_replace(" ", '%20', $url);   	  
	$ch = curl_init(); 
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$output = curl_exec($ch);
	curl_close($ch);
}
?>