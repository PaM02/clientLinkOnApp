<?php   

include("bdd.php");
    //$compteur= '47000564865';
    $compteur = $_POST["compteur"];
    //tableau consommation quotidienne
    //les 10 dernier jours de la semaine
    setlocale(LC_TIME, 'fra_fra');

    $day = 1 ;
    //faire la somme des consommations
    $array2= [];
    $tableauSomme =[];
    $somme = 0;
    $day = 1 ;
    while($day <=7 ){

      $yesterday = new DateTime('-'.$day.' day', new DateTimeZone('Africa/Dakar'));
      $hierEnChiffre =  $yesterday -> format('yy-m-d');
      $array2 [] = $hierEnChiffre;
      $req = $bdd->prepare('SELECT consommation_actuelle  FROM `rapport_journalier` where date = :date
      and compteur_no= :compteur
        ');
      $req->execute(
          array(
            'date' => $hierEnChiffre,
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