<?php 
require "conn.php";
$username = $_POST["username"];
$tel = $_POST["tel"];

$mysql_qry = "update  comptes set tel_client='$tel' where usernameApp='$username';";

if($conn->query($mysql_qry) === TRUE) {
	
echo "1";
}
else {
echo "0";
}
$conn->close();

?>