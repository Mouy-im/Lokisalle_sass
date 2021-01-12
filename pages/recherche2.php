<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="reservation" class="conteneur py-5">
  <h1>Recherche</h1>
    <div class="row">


<!--<form method="post" action="">
Ville<input type="radio" name="f-ville" value="f_ville">
Categorie<input type="radio" name="f-cat" value="f_cat">
Prix<input type="radio" name="f-prix" value="f_prix">
Capacité<input type="radio" name="f-cap" value="f_cap">
</form>-->
<?php
$villes = $pdo->query("SELECT DISTINCT ville FROM salle");
$categories = $pdo->query("SELECT DISTINCT categorie FROM salle");
?>

        <div class='col-12 col-md-4 bg-light p-3'>
       <h2 class="h4 text-center">Votre recherche :</h2>
            <div class="col-12">
                <form method="post" action="">
                <!--Filtre par ville-->
                Ville : <select class="form-select" name="ville">
                <option selected disabled>Choisir une ville</option> 
                <?php
                while ($ville = $villes->fetch(PDO::FETCH_ASSOC)) 
                {
                    echo'<option value="'.$ville['ville'].'">'.$ville['ville'].'</option>'; 
                }
                ?>
                </select><br>
                <!--Filtre par categorie-->
                Catégorie : <select class="form-select" name="categorie">
                <option selected disabled>Choisir une catégorie</option> 
                <?php
                while ($cat = $categories->fetch(PDO::FETCH_ASSOC)) 
                {
                    echo'<option value="'.$cat['categorie'].'">'.$cat['categorie'].'</option>'; 
                }
                ?>
                </select><br>
                <!--Filtre par date-->
                <div class="mb-3">
                    <label for="date_arrivee" class="form-label">Date d'arrivée :</label>
                    <input type="text" id="date_arrivee" class="datepicker form-control" name="date_arrivee" placeholder="aaaa/mm/jj">
                    <label for="date_depart" class="form-label">Date de départ :</label>
                    <input type="text" id="date_depart" class="datepicker form-control" name="date_depart" placeholder="aaaa/mm/jj">
                </div>
                <!--Filtre par prix-->
                <div class="mb-3">
                    <label for="prix_min" class="form-label">Prix :</label><br>
                    <input type="text" id="prix_min" name="prix_min" placeholder="min"> €
                   
                    <input type="text" id="prix_max" class="ml-3" name="prix_max" placeholder="max"> €
                </div>
                <!--Filtre par capacite-->
                 <div class="mb-3">
                    <label for="capacite" class="form-label">Capacité :</label><br>
                    <input type="text" id="capacite" name="capacite" placeholder="nombre de"> personnes<br>
                </div>
                <!--Validation du formulaire-->
                <button type='submit' class='btn btn-primary mt-2'>Je recherche</button>
               
                </form>
            </div>
        </div>
        <div class='col-12 col-md-7'>
      
            <div class="row">
            <?php
            if(!empty($_POST['ville']) )
            {   
                    $resultat = $pdo->query("SELECT * FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 AND salle.ville= '$_POST[ville]'");
                    //$resultat = $pdo->query("SELECT * FROM salle WHERE ville = '$_POST[ville]'");
               
                    include('../inc/affichage_filtre.inc.php');                    
            }
            if(!empty($_POST['categorie']) )
            {   
                    $resultat = $pdo->query("SELECT * FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 AND salle.categorie = '$_POST[categorie]'");
                    //$resultat = $pdo->query("SELECT * FROM salle WHERE categorie = '$_POST[categorie]'");
                    include('../inc/affichage_filtre.inc.php');                    
            }
            if(!empty($_POST['date_arrivee']) ||!empty($_POST['date_depart']) )
            {   
                  
                $resultat = $pdo->query("SELECT * FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 AND produit.date_arrivee >= '$_POST[date_arrivee]' AND produit.date_depart <= '$_POST[date_depart]'");
                    include('../inc/affichage_filtre.inc.php');                    
            }
            if(!empty($_POST['prix_min']) || !empty($_POST['prix_max']) )
            {   
                    $resultat = $pdo->query("SELECT * FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 AND produit.prix BETWEEN '$_POST[prix_min]' AND '$_POST[prix_max]'");
                    include('../inc/affichage_filtre.inc.php');                    
            }
            if(!empty($_POST['capacite']) )
            {   
                    $resultat = $pdo->query("SELECT * FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 AND salle.capacite >= '$_POST[capacite]'");
                    
                    include('../inc/affichage_filtre.inc.php');                    
            }
            ?>
            </div>
        </div>
    </div><!--fermeture du row-->
</div>
</div>
<?php include_once('../inc/bas.inc.php');?>