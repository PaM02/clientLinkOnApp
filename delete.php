<?php 
require "conn.php";
$compteur = $_POST["compteur"];

$mysql_qry = "delete from  comptes where compteur_no='$compteur';";

if($conn->query($mysql_qry) === TRUE) {
	
echo "1";
}
else {
echo "0";
}
$conn->close();

?>