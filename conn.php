<?php 
$db_name = "linkonprojet";
$mysql_username = "root";
$mysql_password = "23R@bichr@khli1234";
$server_name = "127.0.0.1";
$conn = mysqli_connect($server_name, $mysql_username, $mysql_password,$db_name);
if($conn){
	echo "1";
}
else{
	echo "0";
}

?>