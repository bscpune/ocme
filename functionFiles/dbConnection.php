<?php	
//$servername = "localhost";
$servername = "192.168.1.106";
$username = "bscemco";
//$username = "root";
$password = "root";
$dbname = "emcoinventory";
$dbCon = new mysqli($servername, $username, $password, $dbname);
if ($dbCon->connect_error) {
	die("Connection failed1: " . $dbCon->connect_error);
}else{
	//echo "DB Connected...";
}
?>

