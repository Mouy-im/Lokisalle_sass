<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="reservation" class="conteneur py-5">
  <h1>Toutes nos offres</h1>
  <?php
   $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y") AS new_date_arrivee,date_format(date_arrivee,"%T") AS heure_arrivee,date_format(date_depart,"%d/%m/%Y") AS new_date_depart,produit.*,date_format(date_depart,"%T") AS heure_depart,salle.* FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 AND produit.date_arrivee > NOW()');

   include('../inc/affichage_filtre.inc.php');
   ?>
</div>
<?php include_once('../inc/bas.inc.php');?>
