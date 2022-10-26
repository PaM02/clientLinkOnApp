<?php 

    require "bdd.php";
    $username = $_POST["username"];
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $tel = $_POST["tel"];
    $password = $_POST["password"];
    $numcompteur = $_POST["numcompteur"];

    $req = $bdd->prepare('insert into client (username, prenom, nom, tel, password, numcompteur)
    values (:username,:prenom,:nom,:tel,:password,:numcompteur)');
    $req->execute(
        array(
            'username' => $username,
            'prenom' => $prenom,
            'nom' => $nom,
            'tel' => $tel,
            'password' => $password,
            'numcompteur' => $numcompteur,
        )
    );

        echo "1";

    $req->closeCursor();

?>