<?php include_once('../inc/init.inc.php');?>
<?php if (!internauteEstConnecte())
{
  header('location:connexion.php');
  exit();
}?>
<?php
if(!empty($_POST['email'])){
  $id = $_SESSION['membre']['id_membre'];
 
  $resultat = $pdo->prepare("SELECT * FROM newsletter WHERE id_membre = ?");
  $resultat->execute(array($id));

    if ($resultat->rowCount() == 0) 
    {
     
        $statement = $pdo->prepare("INSERT INTO newsletter (id_membre)VALUES (?)");
        $statement->execute(array($id));
        $contenu = '<div class="alert alert-success text-center" role="alert">Votre inscription à la newsletter a bien été prise en compte</div>';
      
    }elseif($resultat->rowCount() != 0) 
    {
      $contenu = '<div class="text-center">Vous êtes déjà inscrit à la newsletter</span></div>';
    }else
    {
      $contenu = '<div class="text-center">Vous devez être membre pour vous inscrire à la newsletter</br>
            <a href="/pages/inscription.php">Je m\'inscris</a></div>';
    }
}

?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<div id="newsletter_form" class="conteneur py-5">
  <h1>Inscription à la Newsletter</h1>
 <?php  echo $contenu ;?>
      <form action="" method="post" class="py-5">
          <div class="mb-3">
            <label for="email" class="form-label">Veuillez indiquer votre adresse email :</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="adresse@email.com">
          </div>
        <button type="submit" class="btn btn-primary">Valider</button>
      </form>
   
</div>

<?php include_once('../inc/bas.inc.php');?>