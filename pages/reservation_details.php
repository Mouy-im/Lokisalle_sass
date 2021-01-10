<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<div id="reservation_details" class="conteneur py-5">
<a href="/pages/reservation.php"><i class="fa fa-arrow-circle-left fa-3x pr-2"></i>Retour réservation</a>
  <?php

if (isset($_GET)) {
    $salle = $pdo->query("SELECT * FROM salle WHERE id_salle=$_GET[id]");
    $datas = $salle->fetch(PDO::FETCH_ASSOC);
}

   echo '<h1 class="pb-0 mb-0">'.$datas['titre'].'</h1>';
   echo '<div class="row">';
   echo '<div class="col-12 text-center mb-5">';
   $nb_avis = $pdo->query("SELECT COUNT(*) AS nombre, AVG(note) AS moy FROM avis WHERE id_salle=$datas[id_salle]");
   $avis_number = $nb_avis->fetch(PDO::FETCH_ASSOC);
   if ($avis_number['nombre']==0) {
       echo '<a href="#avis">Soyez le premier à laisser votre commentaire</a><br>';
   } else {
       echo 'Sur '.$avis_number['nombre'].' avis clients<br>';
       echo round($avis_number['moy'],1).'/10<br>';
   }
   echo '</div>';
   echo '</div>';
   echo '<div class="row">';
   echo '<div class="col-12">';
   echo '<div class="row">';
   echo '<div class="col-12 col-md-3">';
   echo '<img src="'.$datas['photo'].'" class="card-img-top" alt="'.$datas['description'].'">';
   echo '</div>';
   echo '<div class="col-12 col-md-9">';
   echo 'Description : '.$datas['description'].'<br>Capacité : '.$datas['capacite'].' personnes<br>Catégorie : '.$datas['categorie'];
   echo '</div>';
   echo '</div>';
   echo '</div>';
   echo '</div>';

   echo '<div class="row mt-5">';
   //Informations complémentaires
   echo '<div class="col-12 col-md-4">';
   echo '<h2 class="h4 text-center">Informations complémentaires</h2>';
   echo 'Pays : '.$datas['pays'].'<br>';
   echo 'Ville : '.$datas['ville'].'<br>';
   echo 'Adresse : '.$datas['adresse'].'<br>';
   echo 'Cp : '.$datas['cp'].'<br>';
   echo 'Accès : <br>';
   echo '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.7019296386375!2d2.435313316145011!3d48.84482397928618!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e672a3399ef36d%3A0x3000b2a1a3c6d510!2s10%20Avenue%20de%20Paris%2C%2094300%20Vincennes!5e0!3m2!1sfr!2sfr!4v1609708712237!5m2!1sfr!2sfr" width="350" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>';
   echo '</div>';

   // Offres disponibles
   $offres = $pdo->query("SELECT * FROM salle, produit WHERE salle.id_salle = produit.id_salle LIKE $datas[id_salle]");
 
     
    if($offres->rowCount() != 0)
    { 
        While($offre = $offres->fetch(PDO::FETCH_ASSOC)){
        echo '<div class="col-12 col-md-4">';
        echo '<h2 class="h4 text-center">Offre disponible</h2>';
        echo 'id_salle : '.$offre['id_salle'].' <br>';
        echo 'Date d\'arrivée :'.$offre['date_arrivee'].' <br>';
        echo 'Date de départ :'.$offre['date_depart'].' <br>';
        echo 'Prix : '.$offre['prix'].' €*<br>';
        echo '<em>*Ce prix est hors taxes</em><br>';
        if (internauteEstConnecte()) 
        {
            echo '<div class="text-center"><a href="#" class="btn btn-primary my-2"><i class="fa fa-shopping-basket mr-2"></i>Ajouter au panier</a></div>';
        }else
        {
            echo '<div class="text-center"><a href="#" class="btn btn-primary my-2"><i class="fa fa-shopping-basket mr-2"></i>(Se connecter)</a></div>';
        }
       
        echo '</div>';
        }
    }  else
    {
        echo 'Pas d\'offres disponibles';
    }
   
  


  
  //Avis
   echo '<div id="avis" class="col-12 col-md-8">';

   echo '<h2 class="h4 text-center">Avis</h2>';
   echo '<div class="row mt-5">';
   echo '<div class="col-12 col-md-6">';
   $avis = $pdo->query("SELECT * FROM avis WHERE id_salle=$datas[id_salle]");
   

   while ($avis_datas = $avis->fetch(PDO::FETCH_ASSOC)) 
   {
       $date = new DateTime($avis_datas['date']);
       echo '<div class="my-3  carte_avis">';
       
       echo 'Le '.date_format($date,'d-m-Y').' à '.date_format($date,'h:m').'<br>';
       echo 'Note : '.$avis_datas['note'].'/10<br>';
       echo 'Commentaire : '.$avis_datas['commentaire'].'<br>';
       echo '</div>';
   }
   echo '</div>';
  
   if (internauteEstConnecte()) {
       $id_session = $_SESSION['membre']['id_membre'];
       echo '<div class="col-12 col-md-6">';
       echo '<form action="" method="post" class="py-5">';
       echo '<div class="mb-3">';
       echo 'Note : <select class="form-select" name="note" required="required">
             <option selected>-- Choisir une note --</option>';
       for ($i=0; $i<=10; $i++) {
           echo '<option value="'.$i.'">'.$i.'</option>';
       }
       echo  '</select>';
       echo '</div>';
      
       echo '<div class="mb-3">
               Ajouter un commentaire :<textarea type="text" class="form-control mt-2"  name="commentaire" placeholder="Votre commentaire" rows="10" required="required"></textarea>
           </div>
           <button type="submit" class="btn btn-primary">Soumettre</button>';
       echo '</form>';
       echo '</div>';
       echo '</div>';
       echo '</div>';
       echo '</div>';
  
       

       if (!empty($_POST['note']) && !empty($_POST['commentaire'])) {
          
           $statement = $pdo->prepare("INSERT INTO avis(id_membre, id_salle, commentaire, note, date)VALUES ($id_session,?,?,?,NOW())");
           $resultat = $statement->execute(array($datas['id_salle'],$_POST['commentaire'],$_POST['note']));
      
        
       }
   } else {
       echo '<div class="col-12 col-md-6">';
       echo '<a href="/pages/connexion.php" class="btn btn-primary mr-5">Se connecter pour écrire un commentaire</a>';
       echo '</div>';
       echo '</div>';
       echo '</div>';
 
       
   }
   

   

 
   
 
   
   


?>

  
  

</div>
</div>
<?php include_once('../inc/bas.inc.php');?>