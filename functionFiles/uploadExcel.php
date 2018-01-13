<?php
require_once 'dbConnection.php';
$operType = isset($_GET['operType'])?$_GET['operType']:"";
switch($_GET['operType']){

	case "uploadFile":
$jsonData1 = stripslashes(html_entity_decode($_GET["formDataJson1"]));
  $dArray = json_decode($jsonData1,true); 
 if(isset($_FILES["file"]["type"]))
    if($dArray[project_id] != ''){
{ 
  $upload_dir = 
'..//UploadDocument//'.$dArray[project_id].'//'; 
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}
    $validextensions = array("jpeg", "jpg", "png", "gif","txt","docx","pdf","xlsx");
    $temporary = explode(".", $_FILES["file"]["name"]);

    $file_extension = end($temporary);
    if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg")) || ($_FILES["file"]["type"] == "text/plain") || ($_FILES["file"]["type"] == "application/xlsx") || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")|| ($_FILES["file"]["type"] == "application/pdf")|| ($_FILES["file"]["type"] == "application/msword")|| ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")&& in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0){
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            if (file_exists($upload_dir.$_FILES["file"]["name"])) {  $arrayName = array('MESSAGE' => 'File already exist');
                $json=json_encode($arrayName); 
                header('Content-Type: application/json');
                echo $json;              
                
            } else {
                $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
                $filename = $_FILES['file']['name'];
                $targetPath = $upload_dir.$filename; // Target path where file is to be stored
                move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                $arrayName = array('MESSAGE' => 'file uploaded successfully');
                $json=json_encode($arrayName); 
                header('Content-Type: application/json');
                echo $json;
                 
               
            }
        }
    } 
}
}
 break;

 case "getBOMNumber":
    $query = "SELECT bom_number as bom_number FROM tbl_bom_master ORDER BY bom_id DESC LIMIT 1";
    $result = mysqli_query($dbCon,$query);
    $row = $result->fetch_assoc();
    echo $bom_number = $row['bom_number'];
  break;
    

case "saveExcel":
$json = file_get_contents('php://input');
$getData = json_decode($json, true);
$excel = json_decode($getData["formDataJson1"],true);
$excelData = json_decode($getData["formDataJson2"],true);
//$excel['start_date'] = date('Y-m-d',strtotime($excel['start_date']));
//$excel['expected_delivery_date'] = date('Y-m-d',strtotime($excel['expected_delivery_date']));
$excelQuery='';
      
      $excelQuery.= "INSERT INTO  tbl_bom_master(bom_number,bom_type, project_id, site_id,activity_id,soil_type, tower_type) VALUES('".$excel['bom_number']."',".$excel['bom_type'].",".$excel['project_id'].",".$excel['site_id'].",";

      if($excel['activity_id']==''){
	  	$excelQuery .= "NULL,";
	  } else {
	  	$excelQuery .= "".$excel['activity_id'].",";
	  }

	  if($excel['soil_type']==''){
	  	$excelQuery .= "NULL,";
	  } else {
	  	$excelQuery .= "'".$excel['soil_type']."',";
	  }

	  if($excel['tower_type']==''){
	  	$excelQuery .= "NULL);";
	  } else {
	  	$excelQuery .= "'".$excel['tower_type']."');";
	  }

      $gateEntryId="SELECT bom_id FROM tbl_bom_master ORDER BY bom_id DESC LIMIT 1";
	    $result = mysqli_query($dbCon,$gateEntryId);
        $row = $result->fetch_assoc();
		$bom_id = (int) $row['bom_id'] + 1;

      for($i=0;$i<sizeof($excelData);$i++){
      $excelQuery.= "INSERT INTO  tbl_bom_material(bom_id, material_code, member, material_description, length, unit_wt, wt_per_pcs, required, total_wt, remark,width) VALUES('".$bom_id."','".$excelData[$i]['material_code']."','".$excelData[$i]['member']."','".$excelData[$i]['material_description']."','".$excelData[$i]['length']."','".$excelData[$i]['unit_wt']."','".$excelData[$i]['wt_per_pcs']."','".$excelData[$i]['required']."','".$excelData[$i]['total_wt']."','".$excelData[$i]['remark']."','".$excelData[$i]['width']."');";
 
     /* $excelQuery.= "INSERT INTO  tbl_material_master(material_code,material_description) VALUES('".$excelData[$i]['material_code']."','".$excelData[$i]['material_description']."') ;";*/
    $excelQuery.="INSERT INTO tbl_material_master (material_code, material_description)
SELECT * FROM (SELECT '".$excelData[$i]['material_code']."','".$excelData[$i]['material_description']."') AS tmp WHERE NOT EXISTS (
    SELECT material_code FROM tbl_material_master WHERE material_code = '".$excelData[$i]['material_code']."') LIMIT 1;";
                    }
      
    
//echo $excelQuery;
echo mysqli_multi_query($dbCon,$excelQuery);
  break;

  case "getExcelList":
  $query = "SELECT bm.bom_id,bm.bom_number,bm.bom_name,pr.project_name,si.site_name,ac.activity_name,bm.soil_type,bm.tower_type
 FROM tbl_bom_master bm left join tbl_project_master pr on bm.project_id=pr.project_id left join tbl_site_master si on bm.site_id=si.site_id left join tbl_activity_master ac on bm.activity_id=ac.activity_id";
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
case "saveExcelMaterialConsumption":
     $json = file_get_contents('php://input');
    $getData = json_decode($json, true);
  $consumption = json_decode($getData["formDataJson1"],true);
   $excelData = json_decode($getData["formDataJson2"],true);
      $consumptionQuery='';
    /*  $indent_id="SELECT indent_id from indent_head where indent_code='".$consumption['indent_code']."';";
       $result = mysqli_query($dbCon,$indent_id);
       $row = $result->fetch_assoc();
       $indent_id = (int) $row['indent_id'] ;*/
     $consumptionQuery .= "INSERT INTO tbl_material_consumption_header(material_consumption_code,project_id,site_id,activity_id,jmc_number,contractor_id) VALUES
    ('".$consumption['material_consumption_code']."',".$consumption['project_id'].",".$consumption['site_id'].",".$consumption['activity_id'].",'".$consumption['jmc_number']."','".$consumption['contractor_id']."');";
    

  $material_consumption_header_id="SELECT material_consumption_header_id FROM tbl_material_consumption_header ORDER BY material_consumption_header_id DESC LIMIT 1";
      $result = mysqli_query($dbCon,$material_consumption_header_id);
    $row = $result->fetch_assoc();
    $material_consumption_header_id = (int) $row['material_consumption_header_id'] + 1;
    
      for($i=0;$i<sizeof($excelData);$i++){
    $consumptionQuery .= "INSERT INTO tbl_material_consumption (material_name,issued_qty,jmc_quantity,actual_quantity,material_issue_number,location_number,material_consumption_header_id) VALUES('".$excelData[$i]['material_number']."',".$excelData[$i]['issued_qty'].",".$excelData[$i]['jmc_qty'].",".$excelData[$i]['actual_qty'].",'".$excelData[$i]['material_issue_number']."','".$excelData[$i]['loc_no']."',".$material_consumption_header_id.");";    
   
        /* $contractor_inventory_id="SELECT contractor_inventory_id from tbl_contractor_inventory where indent_id=".$indent_id." and project_id=".$consumption['project_id']." and store_id=".$consumption['store_id']." and contractor_id=".$consumption['contractor_id'].";";

           $result = mysqli_query($dbCon,$contractor_inventory_id);
           $row = $result->fetch_assoc();
           $contractor_inventory_id = (int) $row['contractor_inventory_id'] ;

           $material_id="SELECT material_id from tbl_material_master where material_name='".$excelData[$i]['material_name']."';";
           $result = mysqli_query($dbCon,$material_id);
           $row = $result->fetch_assoc();
           $material_id = (int) $row['material_id'] ;
           $consumptionQuery .="UPDATE tbl_contractor_inventory SET
							issued_qty = (issued_qty-".$excelData[$i]['consumed_qty']."),
							consumed_qty = ".$excelData[$i]['consumed_qty']."
							where contractor_inventory_id = ".$contractor_inventory_id." and
							material_id=".$material_id.";";*/
/*
							 $contractor_inventory_id="SELECT contractor_inventory_id from tbl_contractor_inventory where indent_id=".$indent_id." and project_id=".$consumption['project_id']." and store_id=".$consumption['store_id']." and contractor_id=".$consumption['contractor_id'].";";

           $result = mysqli_query($dbCon,$contractor_inventory_id);
           $row = $result->fetch_assoc();
           $contractor_inventory_id = (int) $row['contractor_inventory_id'] ;
*/
         /*  $material_id="SELECT material_id from tbl_contractor_inventory_material where material_number='".$excelData[$i]['material_number']."';";
           $result = mysqli_query($dbCon,$material_id);
           $row = $result->fetch_assoc();

         $consumed_qty="SELECT consumed_qty from tbl_contractor_inventory_material where material_number='".$excelData[$i]['material_number']."';";
           $result = mysqli_query($dbCon,$consumed_qty);
           $row1 = $result->fetch_assoc();*/

           //$budget = (float)($row9['actual_budget']) +(float)($journal['total_credit_check']);
        /*   $excelData[$i]['actual_qty'];
           $row1['consumed_qty'];

           $issued_qty =(int)($excelData[$i]['issued_qty'])-(int)($excelData[$i]['actual_qty']);
           $row1['consumed_qty']=(int)($row1['consumed_qty'])+(int)($excelData[$i]['actual_qty']);
           $issued_qty;
           $consumed_qty;
           $material_id = (int) $row['material_id'] ;
           $consumed_qty = (int) $row1['consumed_qty'] ;
           $consumptionQuery .="UPDATE tbl_contractor_inventory_material SET
							issued_qty = '".$issued_qty."',
							consumed_qty = '".$row1['consumed_qty']."'
							where material_id=".$material_id.";";*/
	 } 

  // echo $consumptionQuery;
  echo mysqli_multi_query($dbCon,$consumptionQuery);
  break;


  case "getMaterialConsumtionCode":
	    $query = "SELECT material_consumption_code as material_consumption_code FROM tbl_material_consumption_header order by material_consumption_header_id desc limit 1";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "getMaterialConsumptionList":
		/*$query = "SELECT tmch.material_consumption_code,ih.indent_code,tpm.project_name,tsm.store_name,tcm.contractor_name
                 from tbl_material_consumption_header as tmch,indent_head as ih,tbl_project_master as tpm,tbl_store_master as tsm,tbl_contractor_master as tcm where ih.indent_id=tmch.indent_id and tmch.project_id=tpm.project_id and tsm.store_id=tmch.store_id and tmch.contractor_id=tcm.contractor_id";*/

              $query ="   SELECT distinct tmch.material_consumption_code,tpm.project_name,tcm.contractor_name,tmch.approve_reject_status
    from tbl_material_consumption_header as tmch,indent_head as ih,tbl_project_master as tpm,
    tbl_contractor_master as tcm where
    tmch.project_id=tpm.project_id and tmch.contractor_id=tcm.contractor_id";
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

  case "getMaterialConsumptionListforReturn":
    /*$query = "SELECT tmch.material_consumption_code,ih.indent_code,tpm.project_name,tsm.store_name,tcm.contractor_name
                 from tbl_material_consumption_header as tmch,indent_head as ih,tbl_project_master as tpm,tbl_store_master as tsm,tbl_contractor_master as tcm where ih.indent_id=tmch.indent_id and tmch.project_id=tpm.project_id and tsm.store_id=tmch.store_id and tmch.contractor_id=tcm.contractor_id";*/

              $query ="SELECT distinct tmch.material_consumption_code,tpm.project_name,tcm.contractor_name,tmch.approve_reject_status
    from tbl_material_consumption_header as tmch,indent_head as ih,tbl_project_master as tpm,
    tbl_contractor_master as tcm where
    tmch.project_id=tpm.project_id and tmch.contractor_id=tcm.contractor_id and tmch.approve_reject_status='Approved'";
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

	case "getMaterialConsumptionDetails":
		$material_consumption_code = $_GET['material_consumption_code'];
		$query = "SELECT distinct tmch.material_consumption_header_id,tmch.material_consumption_code,tpm.project_name,tmch.approve_reject_status,tmch.remarks,
tcm.contractor_name,tsm1.site_name,tam.activity_name,tsm1.site_location,tmch.jmc_number from tbl_material_consumption_header as
 tmch,indent_head as tih,tbl_project_master as tpm,tbl_store_master as tsm,tbl_contractor_master as
            tcm,tbl_site_master as tsm1, tbl_activity_master as tam where tmch.project_id=tpm.project_id and tmch.site_id=tsm1.site_id and
  tmch.contractor_id=tcm.contractor_id and tmch.material_consumption_code = '".$material_consumption_code."';";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;
	case "getConsumptionListView":
	$material_consumption_code = $_GET['material_consumption_code'];
	     $material_consumption_header_id="SELECT material_consumption_header_id FROM tbl_material_consumption_header WHERE material_consumption_code ='".$material_consumption_code."';";
        $result = mysqli_query($dbCon,$material_consumption_header_id);
       $row = $result->fetch_assoc();
       $material_consumption_header_id = (int) $row['material_consumption_header_id'] ;
		
		$query = "SELECT distinct tmc.material_issue_number,tmc.location_number,tmc.material_name,tmc.issued_qty,tmc.standard_quantity,tmc.jmc_quantity,
tmc.actual_quantity,mm.material_description,mm.unit_of_measurment 
from tbl_material_consumption tmc,tbl_material_master as mm
           where tmc.material_name = mm.material_code and material_consumption_header_id ='".$material_consumption_header_id."';";
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

  
case "consumptionApproval":

  //$json = file_get_contents('php://input');
   // $getData = json_decode($json, true);
  $consumption = json_decode($_POST["formDataJson1"],true);
   $excelData = json_decode($_POST["formDataJson2"],true);

      $consumptionQuery='';
  
  /*   $consumptionQuery .= "INSERT INTO tbl_material_consumption_header(material_consumption_code,project_id,site_id,activity_id,jmc_number,contractor_id) VALUES
    ('".$consumption['material_consumption_code']."',".$consumption['project_id'].",".$consumption['site_id'].",".$consumption['activity_id'].",'".$consumption['jmc_number']."','".$consumption['contractor_id']."');";
    

  $material_consumption_header_id="SELECT material_consumption_header_id FROM tbl_material_consumption_header ORDER BY material_consumption_header_id DESC LIMIT 1";
      $result = mysqli_query($dbCon,$material_consumption_header_id);
    $row = $result->fetch_assoc();
    $material_consumption_header_id = (int) $row['material_consumption_header_id'] + 1;
    
      for($i=0;$i<sizeof($excelData);$i++){
    $consumptionQuery .= "INSERT INTO tbl_material_consumption (material_name,issued_qty,jmc_quantity,actual_quantity,material_issue_number,location_number,material_consumption_header_id) VALUES('".$excelData[$i]['material_number']."',".$excelData[$i]['issued_qty'].",".$excelData[$i]['jmc_qty'].",".$excelData[$i]['actual_qty'].",'".$excelData[$i]['material_issue_number']."','".$excelData[$i]['loc_no']."',".$material_consumption_header_id.");";    
  */ 
   /*---------------------------------------------------*/
  $query1 = "select project_id from tbl_project_master where project_name='".$consumption['project_name']."'";
    $result1 = mysqli_query($dbCon,$query1);
    $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

$query2 = "select site_id from tbl_site_master where site_name='".$consumption['site_name']."'";
    $result2 = mysqli_query($dbCon,$query2);
    $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);

$query3 = "select contractor_id from tbl_contractor_master where contractor_name='".$consumption['contractor_name']."'";
    $result3 = mysqli_query($dbCon,$query3);
    $row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);

$query5 = "SELECT material_consumption_header_id from tbl_material_consumption_header WHERE material_consumption_code='".$consumption['material_consumption_code']."';";
    $result5 = mysqli_query($dbCon,$query5);
    $row5 = mysqli_fetch_array($result5,MYSQLI_ASSOC);
   
        $contractor_inventory_id="SELECT contractor_inventory_id from tbl_contractor_inventory where project_id=".$row1['project_id']." and site_id=".$row2['site_id']." and contractor_id=".$row3['contractor_id'].";";

           $result4 = mysqli_query($dbCon,$contractor_inventory_id);
           $row4 = $result4->fetch_assoc();
           $contractor_inventory_id = (int) $row4['contractor_inventory_id'] ;
         //  echo $contractor_inventory_id;

for($i=0;$i<sizeof($excelData);$i++){
            echo sizeof($excelData);
           $material_id="SELECT material_id from tbl_material_master where material_name='".$excelData[$i]['material_name']."';";
           $result = mysqli_query($dbCon,$material_id);
           $row = $result->fetch_assoc();
           $material_id = (int) $row['material_id'] ;
          /* $consumptionQuery .="UPDATE tbl_contractor_inventory SET
              issued_qty = (issued_qty-".$excelData[$i]['actual_quantity']."),
              consumed_qty = ".$excelData[$i]['actual_quantity']."
              where contractor_inventory_id = ".$contractor_inventory_id." and
              material_id=".$material_id.";";*/
/*
               $contractor_inventory_id="SELECT contractor_inventory_id from tbl_contractor_inventory where indent_id=".$indent_id." and project_id=".$consumption['project_id']." and store_id=".$consumption['store_id']." and contractor_id=".$consumption['contractor_id'].";";

           $result = mysqli_query($dbCon,$contractor_inventory_id);
           $row = $result->fetch_assoc();
           $contractor_inventory_id = (int) $row['contractor_inventory_id'] ;
*/
            
          $material_id="SELECT material_id from tbl_contractor_inventory_material where material_number='".$excelData[$i]['material_name']."';";
           $result = mysqli_query($dbCon,$material_id);
           $row = $result->fetch_assoc();

           /*$query7 = "select inventory_material_id from tbl_contractor_inventory_material where material_number='".$excelData[$i]['material_name']."'";
           $result7 = mysqli_query($dbCon,$query7);
             $row7 = $result7->fetch_assoc();*/
          
     //    for($j=0;$j<sizeof($row7);$j++){

          /* $inventory_material_id="SELECT inventory_material_id from tbl_contractor_inventory_material where material_number='".$excelData[$i]['material_name']."';";
           $result1 = mysqli_query($dbCon,$inventory_material_id);
           $row1 = $result1->fetch_assoc();

           $contractor_inventory_id="SELECT contractor_inventory_id from tbl_contractor_inventory_material where material_number='".$excelData[$i]['material_name']."';";
           $result2 = mysqli_query($dbCon,$contractor_inventory_id);
           $row2 = $result2->fetch_assoc();*/

         $consumed_qty="SELECT consumed_qty from tbl_contractor_inventory_material where material_number='".$excelData[$i]['material_name']."';";
           $result = mysqli_query($dbCon,$consumed_qty);
           $row1 = $result->fetch_assoc();

           //$budget = (float)($row9['actual_budget']) +(float)($journal['total_credit_check']);
           $excelData[$i]['actual_quantity'];
           $row1['consumed_qty'];

           $issued_qty =(int)($excelData[$i]['issued_qty'])-(int)($excelData[$i]['actual_quantity']);
           $row1['consumed_qty']=(int)($row1['consumed_qty'])+(int)($excelData[$i]['actual_quantity']);
           $issued_qty;
           $consumed_qty;
           $material_id = (int) $row[$i]['material_id'] ;
           $consumed_qty = (int) $row1[$i]['consumed_qty'] ;
          $inventory_material_id =(int) $row7[$i]['inventory_material_id'];
          echo $inventory_material_id;
           $consumptionQuery .="UPDATE tbl_contractor_inventory_material SET
              issued_qty = '".$issued_qty."',
              consumed_qty = '".$row1['consumed_qty']."'
              where material_id=".$row['material_id'].";";
 

//}
//}

  

   /* $indentQuery .= "updated_by='".$indent['updated_by']."',updated_on=now() 
    WHERE indent_id='".$indent['indent_id']."';";
    
    for($i=0;$i<sizeof($indentMaterialList);$i++){
        $selectQuery= "select indent_material_id from indent_material where indent_id='".$indent['indent_id']."' and material_code='".$indentMaterialList[$i]['material_code']."'";
        $result = mysqli_query($dbCon,$selectQuery);
    $row = $result->fetch_assoc();
    $indent_material_id = $row['indent_material_id'];

      $indentQuery .= "UPDATE indent_material SET approved_total_qty='".$indentMaterialList[$i]['approved_total_qty']."',indent_remaining_qty='".$indentMaterialList[$i]['approved_total_qty']."'
      WHERE indent_material_id='".$indent_material_id."';";
    }*/
  }
   $consumptionQuery .= "UPDATE tbl_material_consumption_header SET 
       approve_reject_status='Approved',remarks='".$consumption['remarks']."' WHERE material_consumption_header_id='".$row5['material_consumption_header_id']."';";
   // echo $consumptionQuery;
  echo mysqli_multi_query($dbCon,$consumptionQuery);
  break;





//   case "saveExcel1":
// $json = file_get_contents('php://input');
// $getData = json_decode($json, true);
// $excel = json_decode($getData["formDataJson1"],true);
// $excelData = json_decode($getData["formDataJson2"],true);
// $excelQuery='';
//       for($i=0;$i<sizeof($excelData);$i++){
//       $excelQuery.= "INSERT INTO  mtn_material(material_number,issued_quantity,transfer_quantity,remark) VALUES('".$excel['material_number']."','".$excel['issued_quantity']."','".$excel['transfer_quantity']."','".$excelData['remark']."');";
      
//     }
// echo mysqli_multi_query($dbCon,$excelQuery);
//   break;
}
?>