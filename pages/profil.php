<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<h1>Profil</h1>
<div id="profil" class="conteneur py-5">
<?php

if (internauteEstConnecte())
{

    echo '<h2 class="text-center">Bonjour '.$_SESSION['membre']['pseudo'].'</h2>';
    echo '<div class="row">';
    echo '<div class="col-12 col-md-6">';
    echo '<h3 class="h5">Voici vos informations personnelles :</h3>';
    echo 'Compte : ';
    if (isset($_SESSION['membre']['statut']) && $_SESSION['membre']['statut'] == 1) echo 'Admin'; else echo 'User'; echo '<br>';
    echo 'Civilité : ';
    if (isset($_SESSION['membre']['sexe']) && $_SESSION['membre']['sexe'] == 'm') echo 'Monsieur'; else echo 'Madame'; echo '<br>';
    echo 'Nom : '.$_SESSION['membre']['nom'].'<br>';
    echo 'Prénom : '.$_SESSION['membre']['prenom'].'<br>';
    echo 'Email : '.$_SESSION['membre']['email'].'<br>';
    echo 'Adresse : '.$_SESSION['membre']['adresse'].'<br>';
    echo 'Code postal : '.$_SESSION['membre']['cp'].'<br>';
    echo 'Adresse : '.$_SESSION['membre']['ville'].'<br>';
    echo '<a href="?action=modif">Modifier/compléter mes informations</a>';
    echo '</div>';
    echo '</div>';
}

if (!empty($_POST)) 
{
        $membre_id = $_SESSION['membre']['id_membre'];
        $statement = $pdo->prepare("UPDATE membre SET pseudo = ?, nom = ?, prenom = ?, email = ?, sexe = ?, ville= ?, cp = ?, adresse =? WHERE id_membre = $membre_id");
        $resultat = $statement->execute(array($_POST['pseudo'],$_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['sexe'],$_POST['ville'],$_POST['cp'],$_POST['adresse']));
        //echo '<div class="alert alert-success " role="alert">Modifications de votre profil '.$_POST['id_membre'].' effectuées</div>';
            $resultat = $pdo->query("SELECT * FROM membre WHERE id_membre = $membre_id");
            $membre = $resultat->fetch(PDO::FETCH_ASSOC);
            $_SESSION['membre']['nom']=$membre['nom'];
            $_SESSION['membre']['prenom']=$membre['prenom'];
            $_SESSION['membre']['sexe']=$membre['sexe'];
            $_SESSION['membre']['cp']=$membre['cp'];
            $_SESSION['membre']['email']=$membre['email'];
            $_SESSION['membre']['pseudo']=$membre['pseudo'];
            $_SESSION['membre']['adresse']=$membre['adresse'];
            $_SESSION['membre']['ville']=$membre['ville'];
            $_SESSION['membre']['id_membre']=$membre['id_membre'];        
            die;
    
}


if (isset($_GET['action']) && $_GET['action'] == 'modif') {
    //modification/complément d'information
   
    
?>
<div class="row">
    <div class="col-12 col-md-6">
        <form action="/pages/profil.php" method="post" class="py-5">
            <input type="hidden" id="id_membre" name="id_membre" value="<?php if (isset($_SESSION['membre']['id_membre'])) {
                echo $_SESSION['membre']['id_membre'];
            } ?>"/>
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" maxlength="20" placeholder="Votre pseudo" value = "<?php if (isset($_SESSION['membre']['pseudo'])) {
                echo $_SESSION['membre']['pseudo'];
            } ?>" pattern="[a-zA-Z0-9-_.]{2,20}" title="caractères acceptés : a-zA-Z0-9-_." required="required">
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" value = "<?php if (isset($_SESSION['membre']['nom'])) {
                echo $_SESSION['membre']['nom'];
            } ?>">
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prenom" value = "<?php if (isset($_SESSION['membre']['prenom'])) {
                echo $_SESSION['membre']['prenom'];
            } ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="adresse@email.com" required="required" value = "<?php if (isset($_SESSION['membre']['email'])) {
                echo $_SESSION['membre']['email'];
            } ?>">
            </div>
            <div class="mb-3">
                <select class="form-select" name="sexe">
                <option selected>-- Civilité --</option>
                <option value="m" <?php if (isset($_SESSION['membre']['sexe']) && $_SESSION['membre']['sexe'] == 'm') {
                echo 'selected';
            } ?>>Homme</option>
                <option value="f" <?php if (isset($_SESSION['membre']['sexe']) && $_SESSION['membre']['sexe'] == 'f') {
                echo 'selected';
            } ?>>Femme</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="ville" class="form-label">Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" placeholder="votre ville" value = "<?php if (isset($_SESSION['membre']['ville'])) {
                echo $_SESSION['membre']['ville'];
            } ?>" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés : a-zA-Z0-9-_.">
            </div>
            <div class="mb-3">
                <label for="cp" class="form-label">Code postal</label>
                <input type="text" class="form-control" id="cp" name="cp" placeholder="code postal" value = "<?php if (isset($_SESSION['membre']['cp'])) {
                echo $_SESSION['membre']['cp'];
            } ?>" pattern="[0-9]{5}" title="5 chiffres requis : 0-9">
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <textarea id="adresse" class="form-control" name="adresse" placeholder="votre adresse" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés :  a-zA-Z0-9-_."><?php if (isset($_SESSION['membre']['adresse'])) {
                echo $_SESSION['membre']['adresse'];
            } ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary mt-2">Valider</button>
        </form>
    </div>
</div>
<?php
} 

?>
</div>





<?php
require_once("../inc/bas.inc.php");
?>