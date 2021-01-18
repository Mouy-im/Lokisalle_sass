<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<?php
$subject =$headers =  $emailText =$emailTo ="";
if (isset($_POST['email']))
{
  $resultat = $pdo->query("SELECT * FROM membre WHERE email = '$_POST[email]'");
  $data = $resultat->fetch(PDO::FETCH_ASSOC);

  $emailText = 'Pour reinitialiser votre mot de passe cliquer sur le lien suivant:
   https://www.lokisalle.mouyim-gibassier.xyz%2F'/*/pages/reinit_mdp.php?action=new_mdp&id='.$data['id_membre']*/;

  if ($resultat->rowCount() != 0) 
  {
    $subject = 'Lokisalle : Réinitialisation de votre mot de passe';
   
    $headers = "From : nepasrepondre@lokisalle.fr";
    $emailTo = $_POST['email'];
    mail($emailTo,$subject,$emailText,$headers);
    $message = 'Un mail de réinitialisation vous a été envoyé à cette adresse : '.$_POST['email'].'<br><a href ="https://www.lokisalle.mouyim-gibassier.xyz/pages/reinit_mdp.php?action=new_mdp&id='.$data['id_membre'].'">Cliquez-ici pour réinitialiser votre mot de passe</a>';
  }else
  {
    $message = 'Vous n\'avez pas de compte.<br><a href="/pages/inscription.php">Créer un compte ici</a>';
  }
}
?>

<div id="mdpperdu_form" class="py-5 conteneur">
  <h1>Mot de passe perdu</h1>
  <div>
    <p class="text-center"><?php if(isset($_POST))echo $message?></p>
  </div>
      <form action="" method="post" class="py-5">
          <div class="mb-3">
          <label for="email" class="form-label">Afin de pouvoir réinitialiser votre mot de passe, vous devez nous fournir votre adresse email :</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="adresse@email.com">
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
      </form>
   
</div>

<?php include_once('../inc/bas.inc.php');?>