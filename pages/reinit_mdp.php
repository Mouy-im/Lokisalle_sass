<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="reinit_mdp_form" class="formulaire py-5">
  <h1>Réinitialisation du mot de passe</h1>
<?php

if(!empty($_POST))
{
    if($_POST['new_mdp'] == $_POST['new_mdp2'])
    {
        $newmdp = md5($_POST['new_mdp2']);
        $resultat = $pdo->exec("UPDATE membre SET mdp = '$newmdp' WHERE id_membre = '$_GET[id]'");
        echo '<div><p class="text-center">Mot de passe réinitialisé<br><a href="/pages/connexion.php">Connectez-vous ici</a></p></div>';

    }else
    {
        echo 'Les mots de passe doivent être identiques';
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'new_mdp')
{
?>

<form method="post" action=""> 
    <div class="mb-3">
      <label for="new_mdp" class="form-label">Nouveau mot de passe*</label>
      <input type="password" class="form-control" id="new_mdp" name="new_mdp" placeholder="Nouveau mot de passe" required="required">
      <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password3"></span>
    </div>
    <div class="mb-3">
      <label for="new_mdp2" class="form-label">Confirmation mot de passe*</label>
      <input type="password" class="form-control" id="new_mdp2" name="new_mdp2" placeholder="Confirmation nouveau mot de passe" required="required">
      <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password4"></span>
    </div>
    <i>*Champs requis</i><br>
  <button type="submit" class="btn btn-primary mt-2">Renouveller mon mot de passe</button>
</form>
<?php
}
?>
</div>


<?php include_once('../inc/bas.inc.php');?>