<?php

require_once 'dbConnection.php';

$operType = isset($_GET['operType'])?$_GET['operType']:"";
switch($_GET['operType']){

/**************************Sujata Code Starts Here*********************/

	//IndentCreation

case "saveIndent":
	  $indent = json_decode($_POST["formDataJson1"],true);
	  $indentMaterialList = json_decode($_POST["formDataJson2"],true);
	  $indentQuery = '';
	  $indent_date = date('Y-m-d',strtotime($indent['indent_date']));
	  
	  $indentQuery .= "INSERT INTO indent_head(indent_code,indent_date,project_id,site_id,store_id,activity_id,contractor_id,indent_type,indent_status,created_by,bom_id,active_status,soil_type,tower_type,bom_name,bom_code) VALUES('".$indent['indent_code']."','".$indent_date."',".$indent['project_id'].",".$indent['site_id'].",".$indent['store_id'].",".$indent['activity_id'].",".$indent['contractor_id'].",'Internal Indent','Pending','".$indent['created_by']."',";

	   if($indent['bom_id'] == ''){
	  	$indentQuery .= "NULL,0,";
	  } else {
	  	$indentQuery .= "".$indent['bom_id'].",0,";
	  }

	   if($indent['soil_type'] == ''){
	  	$indentQuery .= "NULL,";
	  } else {
	  	$indentQuery .= "'".$indent['soil_type']."',";
	  }

	  if($indent['tower_type'] == ''){
	  	$indentQuery .= "NULL,";
	  } else {
	  	$indentQuery .= "'".$indent['tower_type']."',";
	  }
	  if($indent['bom_name'] == ''){
	  	$indentQuery .= "NULL,";
	  } else {
	  	$indentQuery .= "'".$indent['bom_name']."',";
	  }
	  if($indent['bom_code'] == ''){
	  	$indentQuery .= "NULL);";
	  } else {
	  	$indentQuery .= "'".$indent['bom_code']."');";
	  }


	  $selectQuery = "SELECT indent_id as indent_id FROM indent_head ORDER BY indent_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$selectQuery);
		$row = $result->fetch_assoc();
		$indent_id = (int) $row['indent_id'] + 1;

  	for($i=0;$i<sizeof($indentMaterialList);$i++){
  		$indentQuery .= "INSERT INTO indent_material(material_id,material_code,indent_material_qty,issued_qty,unit_of_measurment,indent_id,bom_id,description,bom_reference) VALUES(".$indentMaterialList[$i]['material_id'].",'".$indentMaterialList[$i]['material_code']."',".$indentMaterialList[$i]['indent_material_qty'].",".$indentMaterialList[$i]['issued_qty'].",";
         if($indentMaterialList[$i]['unit_of_measurment'] == ''){
  		   $indentQuery .= "NULL,".$indent_id.",";
  		 }else{
  		 	$indentQuery .= "'".$indentMaterialList[$i]['unit_of_measurment']."',".$indent_id.",";
  		 }

  		if($indent['bom_id'] == ''){

	  	$indentQuery .= "NULL,'".$indentMaterialList[$i]['material_description']."','yes');";
	  } else {
	  	$indentQuery .= "".$indent['bom_id'].",'".$indentMaterialList[$i]['material_description']."','yes');";
	  }
  	}
  	//echo $indentQuery;
	echo mysqli_multi_query($dbCon,$indentQuery);
	break;

// case "updateIndent":
// 	  $indent = json_decode($_POST["formDataJson1"],true);
// 	  $indentMaterialList = json_decode($_POST["formDataJson2"],true);
// 	  $indentQuery = '';
// 	 $indentQuery .= "UPDATE indent_head SET 
// 	  created_by='".$indent['created_by']."',
// 	  indent_status='approved',
	  
// 	  approved_total_qty='".$indent['approved_total_qty']."', updated_by='".$indent['updated_by']."',updated_on=now() WHERE indent_id=".$indent['indent_id'].";";
// 	  	echo $indentQuery;
// 	 	echo mysqli_multi_query($dbCon,$indentQuery);
// break;

case "updateIndent":
	  $indent = json_decode($_POST["formDataJson1"],true);
	  $indentMaterialList = json_decode($_POST["formDataJson2"],true);
	  $indentQuery = '';
	  $indent_date = date('Y-m-d',strtotime($indent['indent_date']));
	  
	  $indentQuery .="UPDATE indent_head SET indent_code='".$indent['indent_code']."',
	  indent_date='".$indent_date."',
	  project_id=".$indent['project_id'].",
	  site_id='".$indent['site_id']."',
	   store_id='".$indent['store_id']."',
	  activity_id=".$indent['activity_id'].",
	  contractor_id='".$indent['contractor_id']."',
	  indent_type='".$indent['indent_type']."',
	   bom_name='".$indent['bom_name']."',
	    bom_code='".$indent['bom_code']."',
	     tower_type='".$indent['tower_type']."',
	      soil_type='".$indent['soil_type']."',
	  indent_status='Pending',";

	  	
	  $indentQuery .="updated_by='".$indent['updated_by']."',updated_on=now() WHERE indent_id='".$indent['indent_id']."';";


  	for($i=0;$i<sizeof($indentMaterialList);$i++){
  		$indentQuery.="DELETE FROM indent_material where indent_id='".$indent['indent_id']."';";
  	}


  	for($i=0;$i<sizeof($indentMaterialList);$i++){
  		$indentQuery .= "INSERT INTO indent_material(material_id,material_code,indent_material_qty,issued_qty,unit_of_measurment,indent_id,bom_id,description,bom_reference) VALUES(".$indentMaterialList[$i]['material_id'].",'".$indentMaterialList[$i]['material_code']."',".$indentMaterialList[$i]['indent_material_qty'].",
  		".$indentMaterialList[$i]['issued_qty'].",";
         if($indentMaterialList[$i]['unit_of_measurment'] == ''){
  		   $indentQuery .= "NULL,".$indent['indent_id'].",";
  		 }else{
  		 	$indentQuery .= "'".$indentMaterialList[$i]['unit_of_measurment']."',".$indent['indent_id'].",";
  		 }

  		if($indent['bom_id'] == ''){

	  	$indentQuery .= "NULL,'".$indentMaterialList[$i]['material_description']."','yes');";
	  } else {
	  	$indentQuery .= "".$indent['bom_id'].",'".$indentMaterialList[$i]['material_description']."','yes');";
	  }
  	}



	//  echo $indentQuery;
	 	echo mysqli_multi_query($dbCon,$indentQuery);
	break;




case "deleteIndent":
	  $indent = json_decode($_POST["formDataJson1"],true);
	  $indentQuery = '';
	  $indentQuery .= "UPDATE indent_head SET active_status=1,deleted_by='".$indent['deleted_by']."',deleted_on=now() WHERE indent_id=".$indent['indent_id']."";
	 	echo mysqli_multi_query($dbCon,$indentQuery);
	 	//echo $indentQuery;
break;

//IndentApproval

case "approveIndent":
	  $indent = json_decode($_POST["formDataJson1"],true);
	  $indentMaterialList = json_decode($_POST["formDataJson2"],true);
	  $indent_date = date('Y-m-d',strtotime($indent['indent_date']));
	  $indentQuery = '';

	 $indentQuery .= "UPDATE indent_head SET indent_code='".$indent['indent_code']."',
	  indent_date='".$indent_date."',
	  project_id='".$indent['project_id']."',
	  indent_type='".$indent['indent_type']."',
	  activity_id='".$indent['activity_id']."',
	  contractor_id=".$indent['contractor_id'].",
	  site_id='".$indent['site_id']."',
	 remark='".$indent['remarks']."',
	  approved_by='".$indent['approved_by']."',
	  indent_status='Approved',";

		$indentQuery .= "updated_by='".$indent['updated_by']."',updated_on=now() 
		WHERE indent_id='".$indent['indent_id']."';";
	  
	  for($i=0;$i<sizeof($indentMaterialList);$i++){
        $selectQuery= "select indent_material_id from indent_material where indent_id='".$indent['indent_id']."' and material_code='".$indentMaterialList[$i]['material_code']."'";
        $result = mysqli_query($dbCon,$selectQuery);
		$row = $result->fetch_assoc();
		$indent_material_id = $row['indent_material_id'];

	  	$indentQuery .= "UPDATE indent_material SET approved_total_qty='".$indentMaterialList[$i]['approved_total_qty']."',indent_remaining_qty='".$indentMaterialList[$i]['approved_total_qty']."'
	  	WHERE indent_material_id='".$indent_material_id."';";
	  }
	 // echo $indentQuery;
	  echo mysqli_multi_query($dbCon,$indentQuery);
	break;


	case "rejectIndent":
	  $indent = json_decode($_POST["formDataJson1"],true);
	  $indentMaterialList = json_decode($_POST["formDataJson2"],true);
	  $indent_date = date('Y-m-d',strtotime($indent['indent_date']));
	  $indentQuery = '';
	  $indentQuery .= "UPDATE indent_head SET indent_code='".$indent['indent_code']."',
	  indent_date='".$indent_date."',
	  project_id='".$indent['project_id']."',
	  indent_type='".$indent['indent_type']."',
	  activity_id='".$indent['activity_id']."',
	  contractor_id=".$indent['contractor_id'].",
	    site_id='".$indent['site_id']."',
	     remark='".$indent['remarks']."',
	  approved_by='".$indent['approved_by']."',
	   site_id='".$indent['site_id']."',

	  indent_status='Reject',";

	  $indentQuery .= "updated_by='".$indent['updated_by']."',updated_on=now() 
		WHERE indent_id='".$indent['indent_id']."';";
	  
	  for($i=0;$i<sizeof($indentMaterialList);$i++){
	  	 $selectQuery= "select indent_material_id from indent_material where indent_id='".$indent['indent_id']."' and material_code='".$indentMaterialList[$i]['material_code']."'";
        $result = mysqli_query($dbCon,$selectQuery);
		$row = $result->fetch_assoc();
		$indent_material_id = $row['indent_material_id'];

	  	$indentQuery .= "UPDATE indent_material SET approved_total_qty='".$indentMaterialList[$i]['approved_total_qty']."'
	  	WHERE indent_material_id='".$indent_material_id."';";
	  }
	 // echo $insertQuery;
	  echo mysqli_multi_query($dbCon,$indentQuery);
	break;



/*--------------------------------------Tarun--------------------*/

case "saveExternalIndent":
	  $indent = json_decode($_POST["formDataJson1"],true);
	  $indentMaterialList = json_decode($_POST["formDataJson2"],true);
	  $indentQuery = '';
	  $indent_date = date('Y-m-d',strtotime($indent['indent_date']));
	  
	  $indentQuery .= "INSERT INTO indent_head(indent_code,indent_date,project_id,site_id,activity_id,contractor_id,soil_type,tower_type,indent_type,indent_status,active_status) VALUES('".$indent['indent_code']."','".$indent_date."',".$indent['project_id'].",".$indent['site_id'].",".$indent['activity_id'].",".$indent['contractor_id'].",'".$indent['soil_type']."','".$indent['tower_type']."','External Indent','Pending',0);";

	  $selectQuery = "SELECT indent_id as indent_id FROM indent_head ORDER BY indent_id DESC LIMIT 1";
		$result = mysqli_query($dbCon,$selectQuery);
		$row = $result->fetch_assoc();
		$indent_id = (int) $row['indent_id'] + 1;

  	for($i=0;$i<sizeof($indentMaterialList);$i++){
  		$indentQuery .= "INSERT INTO indent_material(material_id,material_code,indent_material_qty,issued_qty,unit_of_measurment,indent_id) VALUES(".$indentMaterialList[$i]['material_id'].",'".$indentMaterialList[$i]['material_code']."',".$indentMaterialList[$i]['indent_material_qty'].",".$indentMaterialList[$i]['issued_qty'].",'".$indentMaterialList[$i]['unit_of_measurment']."',".$indent_id.");";
  	}
  	//echo $indentQuery;
	echo mysqli_multi_query($dbCon,$indentQuery);
	break;

/*--------------------------------------Tarun--------------------*/

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
