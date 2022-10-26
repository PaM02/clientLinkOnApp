<?php
//23R@bichr@khli1234
//je me connecte à la base données
try{

    $servername = '127.0.0.1';
    $root = 'root';
    $db = 'linkonprojet';
    $pwd = '';
    $bdd = new PDO('mysql:host='.$servername.';dbname='.$db.';charset=utf8', $root, $pwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
    die('Erreur : '.$e->getMessage());
}
