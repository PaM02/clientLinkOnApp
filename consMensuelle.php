<?php   

include("bdd.php");
    $compteur= '47000564865';
    //$compteur = $_POST["compteur"];
    //tableau consommation quotidienne
    //les 10 dernier jours de la semaine
    setlocale(LC_TIME, 'fra_fra');

    $day = 1 ;
    //faire la somme des consommations
  
    $tableauSomme =[];
    $somme = 0;
    $day = 1 ;
    while($day <=12 ){

      $date = new DateTime('-'.$day.' month', new DateTimeZone('Africa/Dakar'));
      $dateRecup =  $date -> format('Y'); 


      $mois = new DateTime('-'.$day.' month', new DateTimeZone('Africa/Dakar'));
      $moisRecup =  $mois -> format('m'); 


      $req = $bdd->prepare('SELECT consommation_actuelle  FROM `rapport_mensuel` where annee = :annee
      and compteur= :compteur and mois = :mois
        ');

      $req->execute(
          array(
            'mois' => $moisRecup,
            'compteur' => $compteur,
            'annee' => $dateRecup,
            'compteur' => $compteur
          )
      );

      //je recupere les données

      while ($donnees = $req->fetch()){

    
        $cons = $donnees['consommation_actuelle'];
        if($cons=='N/A'){

        }else{

        $cons = (float) $cons;
        $somme = $cons;
        }
    
  
      }
      
      $tableauSomme [] = $somme;

      $somme = 0;
      $day +=1;

    }

    foreach($tableauSomme as $tab){
      echo $tab.',';
  }


?>    