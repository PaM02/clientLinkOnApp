<?php 

    // Connexion à la base de données
    include("bdd.php");
    //je recupere le numero de compteur, et le montant saisie  de l'applicaton mobile
    //47000564881
    /*$MeterNo = '47000564881';
    $amount=75;*/
    $amount = $_POST["montant"];
    $MeterNo = $_POST["compteur"];
    $idPrix='';
    $idCompte='';
    $prix='';
    $site = '';
    $impotBDD='';
    //on recupere le id_prix unitaire et le  idCompte

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

    $energie = ($amount)/($prix*(1+($impotBDD/100)));

    //si la taille est superieur à 4 on l'arrondie
    if (strlen($energie) > 3) {
    # code...
    $position = strpos($energie, '.');
    $position+=2;
    $energie= substr($energie,0,$position);
    }

    $path = 'http://51.75.250.106/PHP_Demo/Gettoken.php?meterid='.$MeterNo.'&&amount='.$energie; // A remplir avec l'url de la page web a aspirer
    $fp = @fopen($path, "r");

    $chaine = '';

    if($fp) {

        while(!feof($fp)) {
            $chaine .= fgets($fp,1024);
        }
        $recherche = strrchr($chaine, '"result":"');
        //reduire la taille
        $codeGen= substr($recherche,13,20);
        

        //on recupere le site du compteur

        $req = $bdd->prepare('SELECT compteur_No, site FROM gestion_des_compteurs WHERE compteur_No = :compteur_No');
        $req->execute(array(
        
        'compteur_No' => $MeterNo

        ));

        while ($donnees = $req->fetch()){

            $site = $donnees['site'];

        }


        //curl---------------------------------------------------
        $CompanyName =  "NsResif";
        $UserName = "AMR03";
        $Password = 123456;
        $Token = $codeGen;

        $formData =  array (
            'CompanyName' => $CompanyName,   
            'UserName' => $UserName,
            'Password' => $Password,
            'MeterNo' => $MeterNo,
            'Token' => $Token
        );
    
        $str = http_build_query($formData);
        $curl = curl_init("https://ami.calinhost.com/api/COMM_RemoteToken");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $output = curl_exec($curl);
        $json_array=json_decode($output,true);

        //je recupere le taskNo
        $tache =  $json_array['Result']['TaskNo'];
        curl_close($curl);

        //end--curl---------------------------------------------------  

        // Insertion
        $req = $bdd->prepare('INSERT INTO tache_jeton (compteur_No, jeton, date, heure,remarque,etat,site,tache,energie,montant) 
        VALUES(:compteur_No, :jeton, CURRENT_DATE, CURRENT_TIME, :remarque, :etat, :site, :tache, :energie, :montant)');
        $req->execute(array(
        'compteur_No' => $MeterNo,
        'jeton' => $codeGen,
        'remarque' => "Crédité Jeton",
        'etat' => "En attente",
        'site' => $site,
        'tache' => $tache,
        'energie' => $energie,
        'montant' => $amount
        ));     

        $req->closeCursor();
        
        $req = $bdd->prepare("SELECT jeton,energie FROM tache_jeton where compteur_No = :MeterNo AND tache= :tache");
        $req->execute(array(
            'MeterNo' => $MeterNo,
            'tache' => $tache
        ));
        
        while ($donnees = $req->fetch()){
            # code...
            $jSon[]=$donnees;
        }
     
        
        echo json_encode($jSon,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $req->closeCursor();
     //end--curl---------------------------------------------------     
    }   
    


    
    
?> 
