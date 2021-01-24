<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<?php
$subject =$headers =  $emailText =$emailTo ="";
if (isset($_POST['email']))
{
  $resultat = $pdo->query("SELECT * FROM membre WHERE email = '$_POST[email]'");
  $data = $resultat->fetch(PDO::FETCH_ASSOC);
  $to = $_POST['email'];
  $subject = 'Lokisalle : Renouvellement de votre mot de passe';
  $from = 'contact@mouyim-gibassier.xyz';
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

//En-têtes de courriel
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

//Message électronique HTML
$emailText = '<html><body>';
$emailText .= '<h1>Bonjour '.$data['pseudo'].' !</h1>';
$emailText .= '<p>Pour réinitialiser votre mot de passe cliquer sur le lien suivant:</p>
<a href="https://www.lokisalle.mouyim-gibassier.xyz/pages/reinit_mdp.php?action=new_mdp&id='.$data['id_membre'].'">https://www.lokisalle.mouyim-gibassier.xyz/pages/reinit_mdp.php?action=new_mdp&id='.$data['id_membre'].'</a><br><br><br><br>
<footer>Cordialement,<br><br>Marie de Lokisalle</footer>';
$emailText .= '</body></html>';

  if ($resultat->rowCount() != 0) 
  {
    mail($to, $subject, $emailText, $headers);
    $message = 'Un mail de réinitialisation vous a été envoyé à cette adresse : '.$_POST['email'];
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