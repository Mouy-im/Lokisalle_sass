<?php include_once('../inc/init.inc.php');?>
<?php 
if (!empty($_POST['mots_cles']))
{
    $mc = $_POST['mots_cles'];
    $dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
    setcookie('mots_cles',$mc,$dateExpiration);
}
if (!empty($_POST['date']))
{
    $d = $_POST['date'];
    $dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
    setcookie('date',$d,$dateExpiration);
    
}?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<!--Affichage du menu recherche-->
<div id="reservation" class="conteneur py-5">
  <h1>Recherche</h1>
    <div class="row">
        <div class='col-12 col-md-8 bg-light mx-auto p-5'>
            <h2 class="h4 text-center">Recherche d'une location de salle pour réservation</h2>
            <form method="post" action="">
                <div class="row text-center mt-5">
                    <div class="col-6 text-center">
                        <div class="mb-3 text-center">
                            <label for="date" class="form-label">À la date du :</label>
                            <input type="text" id="date_recherche" class="form-control" name="date" placeholder="AAAA/mm/jj">
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <div class="mb-3 text-center">
                            <label for="mots_cles" class="form-label">Par mots clés</label><br>
                            <input type="text" id="mots_cles" class=" form-control" name="mots_cles" placeholder="Ex : Paris"><br>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-6">
                        <button type='submit' class='btn btn-primary mt-2 px-5'>Je recherche</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
if (!empty($_POST)) {
    if (!empty($_POST['mots_cles']) && !empty($_POST['date'])) {
        $mc = $_POST['mots_cles'];
        $resultat = $pdo->query("SELECT date_format(date_arrivee,'%d/%m/%Y') AS new_date_arrivee,date_format(date_arrivee,'%T') AS heure_arrivee,date_format(date_depart,'%d/%m/%Y') AS new_date_depart,produit.*,date_format(date_depart,'%T') AS heure_depart,salle.* FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1  AND produit.date_arrivee > NOW() AND (salle.ville LIKE '%$mc%'|| salle.categorie LIKE '%$mc%' || salle.pays LIKE '%$mc%' || salle.adresse LIKE '%$mc%' || salle.cp LIKE '%$mc%' || salle.titre LIKE '%$mc%'|| salle.description LIKE '%$mc%' || salle.capacite LIKE '%$mc%' || produit.prix LIKE '%$mc%') AND produit.date_arrivee >= '$_POST[date]'");
        include('../inc/affichage_nb_ligne.inc.php');
        include('../inc/affichage_filtre.inc.php');
    } elseif (!empty($_POST['date'])) {
        $resultat = $pdo->query("SELECT date_format(date_arrivee,'%d/%m/%Y') AS new_date_arrivee,date_format(date_arrivee,'%T') AS heure_arrivee,date_format(date_depart,'%d/%m/%Y') AS new_date_depart,produit.*,date_format(date_depart,'%T') AS heure_depart,salle.* FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 AND produit.date_arrivee > NOW() AND produit.date_arrivee >= '$_POST[date]'");
        include('../inc/affichage_nb_ligne.inc.php');
        include('../inc/affichage_filtre.inc.php');
    } elseif (!empty($_POST['mots_cles'])) {
        $mc = $_POST['mots_cles'];
        $resultat = $pdo->query("SELECT date_format(date_arrivee,'%d/%m/%Y') AS new_date_arrivee,date_format(date_arrivee,'%T') AS heure_arrivee,date_format(date_depart,'%d/%m/%Y') AS new_date_depart,produit.*,date_format(date_depart,'%T') AS heure_depart,salle.* FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 AND produit.date_arrivee > NOW()  AND (salle.ville LIKE '%$mc%'|| salle.categorie LIKE '%$mc%' || salle.pays LIKE '%$mc%' || salle.adresse LIKE '%$mc%' || salle.cp LIKE '%$mc%' || salle.titre LIKE '%$mc%'|| salle.description LIKE '%$mc%' || salle.capacite LIKE '%$mc%' || produit.prix LIKE '%$mc%')");
        include('../inc/affichage_nb_ligne.inc.php');
        include('../inc/affichage_filtre.inc.php');
    }
}
?>  
</div>   
<?php include_once('../inc/bas.inc.php');?>