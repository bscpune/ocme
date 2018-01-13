<?php  
     $operType = isset($_GET['operType'])?$_GET['operType']:"";
    switch($_GET['operType']){  
   
    case "uploadFile":
$jsonData1 = stripslashes(html_entity_decode($_GET["formDataJson"]));
  $dArray = json_decode($jsonData1,true); 
 if(isset($_FILES["file"]["type"]))
    if($dArray[prod_cat] != ''){
{ 
  $upload_dir = 
'..//UploadDocument//'.$dArray[prod_cat].'//'.$dArray[prod_sub_cat].'//'.$dArray[spmdname].'//'.$dArray[spname].'//'.$dArray[spprdcolor].'//'; 
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
    
};
 ?>