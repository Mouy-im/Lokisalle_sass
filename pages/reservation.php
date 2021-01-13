<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="reservation" class="conteneur py-5">
  <h1>Toutes nos offres</h1>
    <div class="row">
  <?php

$resultat = $pdo->query('SELECT * FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 AND produit.date_arrivee > NOW()');
while ($datas = $resultat->fetch(PDO::FETCH_ASSOC))
{
   
   echo '<div class="col-12 col-md-6 col-lg-4 col-xl-3 my-3">';
   echo '<div class="card">';
   echo '<img src="'.$datas['photo'].'" class="card-img-top" alt="'.$datas['description'].'">';
   echo '<div class="card-body">';
   echo '<h2 class="card-title">'.$datas['titre'].'</h2>';
   echo '<p class="card-text">'.$datas['ville'].'<br>Capacité : '.$datas['capacite'].' places<br>'.$datas['description'].'</p>';
   echo 'Date d\'arrivée :'.$datas['date_arrivee'].' <br>';
   echo 'Date de départ :'.$datas['date_depart'].' <br>';
   echo 'Prix : '.$datas['prix'].' €*<br>';
   echo '<em>*Ce prix est hors taxes</em><br>';
   echo '<a href="/pages/reservation_details.php?id='.$datas['id_produit'].'" class="btn btn-primary my-2">Voir plus</a>';
   if (internauteEstConnecte()) 
   {
      if(isset($_SESSION['panier'][$datas['id_produit']]))
      {
         echo '<a href="#" class="btn btn-primary ml-2" Onclick="'."return(confirm('Ce produit est déjà dans le panier'))".'"><i class="fa fa-shopping-basket"></i></a>';
      }else
      {
         echo '<a href="/pages/panier.php?ajout_panier&id='.$datas['id_produit'].'" class="btn btn-primary ml-2"><i class="fa fa-shopping-basket"></i></a>';
      }
   }else
   {
      echo '<br><a href="/pages/connexion.php" class="btn btn-primary my-2"><i class="fa fa-shopping-basket mr-2"></i>(Se connecter)</a>';
   }
  
   echo '</div>';
   echo '</div>';
   echo '</div>';
}
?>
</div>
</div>
<?php include_once('../inc/bas.inc.php');?>
