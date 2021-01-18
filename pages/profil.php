<?php include_once('../inc/init.inc.php');?>
<?php
if (!empty($_POST)) 
{
        $membre_id = $_SESSION['membre']['id_membre'];
        $_POST['adresse'] = addslashes($_POST['adresse']);
        $statement = $pdo->prepare("UPDATE membre SET pseudo = ?, nom = ?, prenom = ?, email = ?, sexe = ?, ville= ?, cp = ?, adresse =? WHERE id_membre = $membre_id");
        $resultat = $statement->execute(array($_POST['pseudo'],$_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['sexe'],$_POST['ville'],$_POST['cp'],$_POST['adresse']));
            $resultat = $pdo->query("SELECT * FROM membre WHERE id_membre = $membre_id");
            $membre = $resultat->fetch(PDO::FETCH_ASSOC);
            $membre['adresse'] = stripslashes($membre['adresse']);
            $_SESSION['membre']['nom']=$membre['nom'];
            $_SESSION['membre']['prenom']=$membre['prenom'];
            $_SESSION['membre']['sexe']=$membre['sexe'];
            $_SESSION['membre']['cp']=$membre['cp'];
            $_SESSION['membre']['email']=$membre['email'];
            $_SESSION['membre']['pseudo']=$membre['pseudo'];
            $_SESSION['membre']['adresse']=$membre['adresse'];
            $_SESSION['membre']['ville']=$membre['ville'];
            $_SESSION['membre']['id_membre']=$membre['id_membre'];        
            
}?>

<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<h1>Profil</h1>
<div id="profil" class="conteneur py-5">
<?php
//Affichage du profil utilisateur
if (internauteEstConnecte())
{  
    $id_membre = $_SESSION['membre']['id_membre'];
    $commande = $pdo->query("SELECT * FROM commande WHERE id_membre = $id_membre");
   
   
?>
    <h2 class="text-center mb-3">Bonjour <?php echo $_SESSION['membre']['pseudo'] ?></h2>
        <div class="row">
            <div class="col-12 col-md-5 bg-light p-3 mb-4 rounded mx-auto">
            <h3 class="h5">Voici vos informations personnelles :</h3>
            <hr>
            Compte : <?php if (isset($_SESSION['membre']['statut']) && $_SESSION['membre']['statut'] == 1) echo 'Admin'; else echo 'Membre';?><br>
            Civilité : <?php if (isset($_SESSION['membre']['sexe']) && $_SESSION['membre']['sexe'] == 'm') echo 'Monsieur'; elseif (isset($_SESSION['membre']['sexe']) && $_SESSION['membre']['sexe'] == 'f') echo 'Madame'; else echo '';?><br>
            Nom : <?php echo $_SESSION['membre']['nom'] ?><br>
            Prénom : <?php echo $_SESSION['membre']['prenom'] ?><br>
            Email : <?php echo $_SESSION['membre']['email'] ?><br>
            Adresse : <?php echo $_SESSION['membre']['adresse'] ?><br>
            Code postal : <?php echo $_SESSION['membre']['cp'] ?><br>
            Adresse : <?php echo $_SESSION['membre']['ville'] ?><br>
            <a href="?action=modif">Modifier/compléter mes informations</a>
            </div>
            <?php $data = $commande->fetch(PDO::FETCH_ASSOC); ?>
            <?php if ($commande->rowCount() != 0) 
            {
                $date = new dateTime($data['date']);
            ?>
            <div class="col-12 col-md-5 bg-light rounded p-3 mx-auto">
            <h3 class="h5">Vos dernières commandes :</h3>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>Numéro de suivi</th>
                        <th>date</th>
                        <th>Fature</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $data['id_commande'] ?></td>
                        <td><?php echo date_format($date,'d-m-Y') ?></td>
                        <td><a href ="/pages/facture.php?id_commande=<?php echo $data['id_commande'] ?>"><i class="fa fa-file"></i></a></td>
                    </tr>
                </tbody>
            </table>
            </div>
            <?php
            } 
            ?>
        </div>
<?php
}
?>

<?php
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