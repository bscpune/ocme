<?php
require_once 'dbConnection.php';

$operType = isset($_GET['operType'])?$_GET['operType']:"";
switch($_GET['operType']){
case "getExcelList":
  $query = "SELECT * FROM excel_data";
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