<?php
require_once 'dbConnection.php';
switch($_GET["operType"]){
	case "login":
		$user = $_GET["formDataJson"]; 
		$query = "SELECT user.* FROM tbl_user_master user WHERE user_name = '".$user['user_name']."' AND password = '".$user['password']."' AND user_status = 0";
		$result = mysqli_query($dbCon,$query);
		$main_array =[];
		$main_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$json=json_encode($main_array); 
		header('Content-Type: application/json');
		echo $json;
	break;

	case "createSesssionLogin":
		session_start();
		$_SESSION['uid']=uniqid('ang_');
		$arrayName = $arrayName = array('session_id' => $_SESSION['uid'] );
		$json=json_encode($arrayName); 
		header('Content-Type: application/json');
		echo $json;
	break;
		
}
?>