<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<?php

if(!empty($_POST))
{
  $from = "";
  $emailTo = 'mouyim.gibassier@hotmail.com';
  $emailText = $_POST['message'];
  $subject = $_POST['sujet'];
  if (!internauteEstConnecte())
  {
    $from = $_POST['email'];
    $headers = "From :".$from;
    mail($emailTo,$subject, $emailText,$headers);
    $message = 'Votre message a bien été envoyé !<br>Merci de m\'avoir contacté';
  }elseif (internauteEstConnecte())
  {

    $from = $_SESSION['membre']['email'];
    $headers = "From :".$from;
    mail($emailTo,$subject, $emailText,$headers);
    $message = 'Votre message a bien été envoyé !<br>Merci de m\'avoir contacté';

  }
}
?>
<div id="contact_form" class="formulaire py-5">
  <h1>Nous contacter</h1>
  <div>
    <p class="text-center"><?php if(isset($_POST))echo $message?></p>
  </div>
  <form action="" method="post" class="py-5">
      <?php if (!internauteEstConnecte())
      { ?>
      
      <div class="mb-3">
        <label for="email" class="form-label">Votre adresse email :</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="adresse@email.com">
      </div>
      <?php
      }
      ?>
      <div class="mb-3">
        <label for="sujet" class="form-label">Sujet :</label>
        <input type="text" class="form-control" id="sujet" name="sujet" placeholder="sujet">
      </div>
      <div class="mb-3">
        Message :<textarea type="text" class="form-control mt-2" rows="10" name="message" placeholder="Votre message"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Valider</button>
      
  </form>
</div>

<?php include_once('../inc/bas.inc.php');?>


