<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<?php
if (isset($_POST['email']))
{
  $resultat = $pdo->query("SELECT * FROM membre WHERE email = '$_POST[email]'");
  $data = $resultat->fetch(PDO::FETCH_ASSOC);
  if ($resultat->rowCount() != 0) 
  {
      mail("$_POST[email]","Réinitialisation de votre mot de passe","<a href=/pages/reinit_mdp.php?action=new_mdp&id=$data[id_membre]>Réinitialiser mon mot de passe</a>");
    
  }else
  {
    echo 'Vous n\'avez pas de compte.<br><a href="/pages/inscription.php">Créer un compte ici</a>';
  }
}
?>

<div id="mdpperdu_form" class="py-5">
  <h1>Mot de passe perdu</h1>
 
      <form action="" method="post" class="py-5">
          <div class="mb-3">
          <label for="email" class="form-label">Afin de pouvoir réinitialiser votre mot de passe, vous devez nous fournir votre adresse email :</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="adresse@email.com">
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
      </form>
   
</div>

<?php include_once('../inc/bas.inc.php');?>