<?php 
require "conn.php";
$username = $_POST["username"];
$prenom = $_POST["prenom"];
$nom = $_POST["nom"];
$tel = $_POST["tel"];
$password = $_POST["password"];
$numcompteur = $_POST["numcompteur"];

$mysql_qry = "insert into client (username, prenom, nom, tel, password, numcompteur)  values ('$username','$prenom','$nom','$tel','$password','$numcompteur');";

if($conn->query($mysql_qry) === TRUE) {
	
echo "1";
}
else {
echo "0";
}
$conn->close();

?>