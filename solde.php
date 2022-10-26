<?php 

    // Connexion à la base de données
       // Connexion à la base de données
       include("bdd.php");
    // remote reading
    //je recupere le numero de compteur de l'applicaton mobile
    //$MeterNo = '47000564881';
    $MeterNo = $_POST["compteur"];
    
    //curl post---------------------------------------------------
    // $DataItem = Switch on Ou Switch off
    $CompanyName =  "NsResif";
    $UserName = "AMR03";
    $Password = 123456;
    $DataItem = 'Current Credit Register';

    $formData =  array (
        'CompanyName' => $CompanyName,   
        'UserName' => $UserName,
        'Password' => $Password,
        'MeterNo' => $MeterNo,
        'DataItem' => $DataItem
    );
    
    $str = http_build_query($formData);
    $curl = curl_init("https://ami.calinhost.com/api/COMM_RemoteReading");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $str);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $output = curl_exec($curl);
    
    $json_array=json_decode($output,true);

    //je recupere le taskNo
    $tache =  $json_array['Result']['TaskNo'];
    //Arrête l'exécution pendant 13s
    //usleep(13000000);
    curl_close($curl);
    //end--curl---------------------------------------------------  
    //remote reading task

    $formData =  array (
        'CompanyName' => $CompanyName,   
        'UserName' => $UserName,
        'Password' => $Password,
        'TaskNo' => $tache
    );
 
     $str = http_build_query($formData);
     $curl = curl_init("https://ami.calinhost.com/api/COMM_RemoteReadingTask");
     curl_setopt($curl, CURLOPT_POST, true);
     curl_setopt($curl, CURLOPT_POSTFIELDS, $str);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 
     $output = curl_exec($curl);
     $err = curl_error($curl);
     
     $json_array=json_decode($output,true);
   
    //je recupere le status et la data

    $Data =  $json_array['Result']['Data'];
    $idPrix = '';
    $idCompte ='';
    $prix ='';
    $impotBDD='';
    $amount ='';
    //on recuperer juste le nombre
    $Datachiffres  = substr($Data, 0, -6);  // retourne "abcde"

    $req = $bdd->prepare('SELECT  id_prix,idCompte FROM comptes WHERE compteur_no = :compteur_no');
    $req->execute(
        array(
            'compteur_no' => $MeterNo
        )
    );
        //je recupere les données

    while ($donnees = $req->fetch()){

        $idPrix = $donnees['id_prix'];
        $idCompte = $donnees['idCompte'];

    }

    $req = $bdd->prepare('SELECT  prix,impot FROM gestion_des_prix WHERE idPrix = :idPrix');
    $req->execute(
        array(
            'idPrix' => $idPrix
        )
    );

    while ($donnees = $req->fetch()){

        $prix = $donnees['prix'];
        $impotBDD = $donnees['impot'];

    }

    $amount = $Datachiffres*($prix*(1+($impotBDD/100)));
    

    $status =  $json_array['Result']['Status'];
    $etat = '';

    if ($status=='True') {
        # code...
        $etat = 'Succès';
    }
    elseif ($status=='False') {
        # code...
        $etat = 'Echec';
    }
    else {
        # code...
        $etat = 'En attente';
    }
    // Insertion des données 
    $req = $bdd->prepare('INSERT INTO lecture_tache (compteur_no_lecture_tache, donnees,
    date_de_creation, heure_de_creation, etat, Reception_donnees, tacheLecture,Reception_donnees_credit_courant) 
    VALUES(:compteur_no_lecture_tache, :donnees,CURRENT_DATE,CURRENT_TIME, :etat, :Reception_donnees, :tacheLecture,
    :Reception_donnees_credit_courant)');
    $req->execute(
        array(
        'compteur_no_lecture_tache' => $MeterNo,
        'donnees' => 'Crédit courant',
        'etat' => $etat,
        'Reception_donnees' => $Data,
        'tacheLecture' => $tache,
        'Reception_donnees_credit_courant' => $Datachiffres
        )
    ); 
    
    $req = $bdd->prepare("SELECT *,DATE_FORMAT(date_de_creation,'%d-%m-%Y') AS date_de_creation FROM lecture_tache where compteur_no_lecture_tache = :MeterNo AND etat= :etat");
    $req->execute(array(
        'MeterNo' => $MeterNo,
        'etat' => 'Succès'
    ));
    
    while ($donnees = $req->fetch()){
        # code...
		$json[]=$donnees;
    }
 
    
    echo json_encode($json,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    $req->closeCursor();
    
?> 