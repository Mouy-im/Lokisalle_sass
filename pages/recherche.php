<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="reservation" class="conteneur py-5">
  <h1>Recherche</h1>
    <div class="row">

Rechercher d'une location de salle pour réservation :
<!--<form method="post" action="">
Ville<input type="radio" name="f-ville" value="f_ville">
Categorie<input type="radio" name="f-cat" value="f_cat">
Prix<input type="radio" name="f-prix" value="f_prix">
Capacité<input type="radio" name="f-cap" value="f_cap">
</form>-->

 <?php

$villes = $pdo->query("SELECT DISTINCT ville FROM salle");
$categories = $pdo->query("SELECT DISTINCT categorie FROM salle");
echo '<div>';
echo '<form method="post" action="">';
echo ' Ville : <select class="form-select" name="ville">';
echo'<option selected disabled>Choisir une ville</option>'; 
while ($ville = $villes->fetch(PDO::FETCH_ASSOC)) 
{
    echo'<option value="'.$ville['ville'].'">'.$ville['ville'].'</option>'; 
}
echo'</select><br>';  
echo ' Catégorie : <select class="form-select" name="categorie">';
echo'<option selected disabled>Choisir une catégorie</option>'; 
while ($cat = $categories->fetch(PDO::FETCH_ASSOC)) 
{
    echo'<option value="'.$cat['categorie'].'">'.$cat['categorie'].'</option>'; 
}
echo'</select><br>';    
echo "<button type='submit' class='btn btn-primary mt-2'>Je recherche</button>";

echo '</form>';
echo '</div>';


if(isset($_POST['ville']) )
{   
        $resultat = $pdo->query("SELECT * FROM salle WHERE ville = '$_POST[ville]'");
        include('../inc/affichage_filtre.inc.php');                    
}
if(isset($_POST['categorie']) )
{   
        $resultat = $pdo->query("SELECT * FROM salle WHERE categorie = '$_POST[categorie]'");
        include('../inc/affichage_filtre.inc.php');                    
}

?>
</div>
</div>
<?php include_once('../inc/bas.inc.php');?>