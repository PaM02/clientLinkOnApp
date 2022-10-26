<?php 
    // Connexion à la base de données
    include("bdd.php");

	$req = $bdd->query('SELECT * FROM client ');
	    
	
	while ($donnees = $req->fetch()){
		# code...
		$json[]=$donnees;
	}

	echo json_encode($json,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
	$req->closeCursor();
?>