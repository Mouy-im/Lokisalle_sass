<?php include_once('../inc/init.inc.php');?>
<?php 
$dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
if(isset($_COOKIE['ville']))
{
    setcookie('ville','',$dateExpiration);
}
if(isset($_COOKIE['categorie']))
{
    setcookie('categorie','',$dateExpiration);
}
if(isset($_COOKIE['date_arrivee']))
{
    setcookie('date_arrivee','',$dateExpiration);
}
if(isset($_COOKIE['date_depart']))
{
    setcookie('date_depart','',$dateExpiration);
}
if(isset($_COOKIE['prix_min']))
{
    setcookie('prix_min','',$dateExpiration);
}
if(isset($_COOKIE['prix_max']))
{
    setcookie('prix_max','',$dateExpiration);
}
if(isset($_COOKIE['capacite']))
{
    setcookie('capacite','',$dateExpiration);
}

if (!empty($_POST['ville']))
{
    $dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
    setcookie('ville',$_POST['ville'],$dateExpiration);
}
if (!empty($_POST['categorie']))
{
    $dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
    setcookie('categorie',$_POST['categorie'],$dateExpiration);
}
if (!empty($_POST['date_arrivee']))
{
    $dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
    setcookie('date_arrivee',$_POST['date_arrivee'],$dateExpiration);
}
if (!empty($_POST['date_depart']))
{
    $dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
    setcookie('date_depart',$_POST['date_depart'],$dateExpiration);
}
if (!empty($_POST['prix_min']))
{
    $dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
    setcookie('prix_min',$_POST['prix_min'],$dateExpiration);
}
if (!empty($_POST['prix_max']))
{
    $dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
    setcookie('prix_max',$_POST['prix_max'],$dateExpiration);
}
if (!empty($_POST['capacite']))
{
    $dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
    setcookie('capacite',$_POST['capacite'],$dateExpiration);
}
?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="reservation" class="conteneur py-5 mx-2auto">    
    <div class="row">
<?php
$villes = $pdo->query("SELECT DISTINCT ville FROM salle");
$categories = $pdo->query("SELECT DISTINCT categorie FROM salle");
?>

        <div class='col-12 col-md-3 bg-light shadow p-3 mt-5'>
            <div class="col-12 text-center">
            <span class="h4 text-center"><strong>Affinez votre recherche </strong></span>
            </div>
            <hr class="col-8 mx-auto text-primary">
            <div class="col-12">
                <form method="post" action="">
                <!--Filtre par ville-->
                Ville : <select class="form-select" name="ville">
                <option value="" hidden>Choisir une ville</option> 
                <option value="">Toutes les villes</option> 
                <?php
                while ($ville = $villes->fetch(PDO::FETCH_ASSOC)) 
                {
                    echo'<option value="';if (isset($_POST['ville']) && $_POST['ville'] == $ville['ville']){echo $_POST['ville'].'" selected';}else{echo $ville['ville'].'"';} echo '>';;if (isset($_POST['ville']) && $_POST['ville'] == $ville['ville']){echo $_POST['ville'];}else{echo $ville['ville'];} echo '</option>'; 
                }
                ?>
                </select><br>
                <!--Filtre par categorie-->
                Catégorie : <select class="form-select" name="categorie">
                <option value="" hidden>Choisir une catégorie</option>
                <option value="">Toutes les catégories</option> 
                <?php
                while ($cat = $categories->fetch(PDO::FETCH_ASSOC)) 
                {
                    echo'<option value="';if (isset($_POST['categorie']) && $_POST['categorie'] == $cat['categorie']){echo $_POST['categorie'].'" selected';}else{echo $cat['categorie'].'"';} echo '>';if (isset($_POST['categorie']) && $_POST['categorie'] == $cat['categorie']){echo $_POST['categorie'];}else{echo $cat['categorie'];} echo '</option>'; 
                }
                ?>
                </select><br>
                <!--Filtre par date-->
                <div class="mb-3">
                    <label for="date_arrivee" class="form-label">Date d'arrivée :</label>
                    <input type="text" id="date_arrivee_r" class="form-control" name="date_arrivee" placeholder="aaaa/mm/jj" value="<?php if (isset($_POST['date_arrivee'])) echo $_POST['date_arrivee'] ?>">
                    <label for="date_depart" class="form-label">Date de départ :</label>
                    <input type="text" id="date_depart_r" class="form-control" name="date_depart" placeholder="aaaa/mm/jj" value="<?php if (isset($_POST['date_depart'])) echo $_POST['date_depart'] ?>">
                </div>
                <!--Filtre par prix-->
                <div class="mb-3">
                    <label for="prix_min" class="form-label">Prix :</label><br>
                    <input type="number" id="prix_min" min="0" name="prix_min" class="col-4" placeholder="min" value="<?php if (isset($_POST['prix_min'])) echo $_POST['prix_min'] ?>"> €
                    <input type="number" min="0" id="prix_max" class="mt-2 col-4" name="prix_max" placeholder="max" value="<?php if (isset($_POST['prix_max'])) echo $_POST['prix_max'] ?>"> €
                </div>
                <!--Filtre par capacite-->
                 <div class="mb-3">
                    <label for="capacite" class="form-label">Capacité :</label><br>
                    <input type="number" min="0" id="capacite" name="capacite"class="col-4" placeholder="Ex : 20" value="<?php if (isset($_POST['capacite'])) echo $_POST['capacite'] ?>"> personnes<br>
                </div>
                <!--Validation du formulaire-->
                <button type='submit' class='btn btn-primary mt-2'>Je recherche</button>
                </form>
            </div>
        </div>
        <div class='col-12 col-md-9'>
         <h1>Tous nos produits disponibles</h1>
            <div class="row">
            <?php
                $query ="SELECT date_format(date_arrivee,'%d/%m/%Y') AS new_date_arrivee,date_format(date_arrivee,'%kh%i') AS heure_arrivee,date_format(date_depart,'%d/%m/%Y') AS new_date_depart,produit.*,date_format(date_depart,'%kh%i') AS heure_depart,salle.* FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1  AND produit.date_arrivee > NOW() "; 
                if(!empty($_POST['ville'])){
                    $query .= " AND salle.ville = '$_POST[ville]'";
                }
                if(!empty($_POST['categorie'])){
                    $query .= " AND salle.categorie ='$_POST[categorie]'";
                }
                if(!empty($_POST['capacite'])){
                    $query .= " AND salle.capacite >='$_POST[capacite]'";
                }
                if(!empty($_POST['date_arrivee']) ){
                    $query .= " AND produit.date_arrivee >= '$_POST[date_arrivee]'";
                }
                if(!empty($_POST['date_depart'])){
                    $query .= " AND produit.date_depart <= '$_POST[date_depart]'";
                }
                if(!empty($_POST['prix_min'])){
                    $query .= " AND produit.prix >= '$_POST[prix_min]'";
                }
                if(!empty($_POST['prix_max'])){
                    $query .= " AND produit.prix <= '$_POST[prix_max]'";
                }
                $resultat = $pdo->query($query);
                if(!empty($_POST)){ include('../inc/affichage_nb_ligne.inc.php');}
                include('../inc/affichage_filtre.inc.php');
            
            ?>
            </div>
        </div>
    </div><!--fermeture du row-->
</div>

<?php include_once('../inc/bas.inc.php');?>