<?php 

	header('content-type:application/json');
	header('Content-Type: text/plain; charset=UTF-8') ;

	$db_name = "linkonprojet";
	$mysql_username = "root";
	$mysql_password = "";
	$server_name = "127.0.0.1";
	$conn = mysqli_connect($server_name, $mysql_username, $mysql_password,$db_name);

	mysqli_set_charset($conn, 'utf8');
	$conn -> set_charset("utf8");

	$username = 'imamUser';
	$password = 'a';
	$passwordBDD="";
	$accesMobile="";

	$mysql_qry = "SELECT * FROM comptes where usernameApp='$username';";
	$result = mysqli_query($conn ,$mysql_qry) or die(mysqli_error()."<hr/>Line:"._LINE_."<br/>$mysql_qry");
	while ($rs=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		# code...
		$json[]=$rs;
		$passwordBDD=$rs['passwordApp'];
		$accesMobile=$rs['accesAppMobile'];

	}



	//si le pseudo n'est pas bon
	if ($accesMobile=="oui"){   

		// Comparaison du pass envoyé via le formulaire avec la base
		$isPasswordCorrect = password_verify($password,$passwordBDD);
		if ($isPasswordCorrect){   

			echo json_encode($json,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

		}
		else {
			
		}

	}
	else {
		
	}


	mysqli_free_result($result);
	mysqli_close($conn);


?>