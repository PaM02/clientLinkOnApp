<?php 
require "conn.php";
$username = $_POST["username"];
$compteur = $_POST["compteur"];

$mysql_qry = "update  comptes set usernameApp='$username' where compteur_no='$compteur';";

if($conn->query($mysql_qry) === TRUE) {
	
echo "1";
}
else {
echo "0";
}
$conn->close();

?>