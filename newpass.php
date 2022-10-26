<?php 
require "conn.php";
$scompteur = $_POST["scompteur"];
$password = $_POST["password"];
$pass_hache = password_hash($password, PASSWORD_DEFAULT);

$mysql_qry = "update  comptes set passwordApp='$pass_hache' where compteur_no='$scompteur';";

if($conn->query($mysql_qry) === TRUE) {
	
echo "1";
}
else {
echo "0";
}
$conn->close();

?>