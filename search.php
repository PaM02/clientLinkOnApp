<?php 
$db_name = "linkonprojet";
$mysql_username = "root";
$mysql_password = "23R@bichr@khli1234";
$server_name = "127.0.0.1";
$conn = mysqli_connect($server_name, $mysql_username, $mysql_password,$db_name);

$compteur = $_POST["compteur"];

$mysql_qry = "select compteur_no from comptes where compteur_no='$compteur';";
$result = mysqli_query($conn ,$mysql_qry) or die(mysqli_error()."<hr/>Line:"._LINE_.
	"<br/>$mysql_qry");
while ($rs=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	# code...
	$json[]=$rs;
}

echo json_encode($json,JSON_UNESCAPED_UNICODE);
mysqli_free_result($result);
mysqli_close($conn);

?>