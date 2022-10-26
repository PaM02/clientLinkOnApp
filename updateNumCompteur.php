<?php 
require "conn.php";
$username = $_POST["username"];
$numcompteur = $_POST["numcompteur"];

$mysql_qry = "update  comptes set compteur_no='$numcompteur' where usernameApp='$username';";

if($conn->query($mysql_qry) === TRUE) {
	
echo "1";
}
else {
echo "0";
}
$conn->close();

?>