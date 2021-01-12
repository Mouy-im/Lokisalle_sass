<?php include_once('../inc/init.inc.php');?>
<?php
if (!internauteEstConnecteEtEstAdmin())
{
  header('location:../pages/connexion.php');
  exit();
}
?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<?php
//récupération des emails
$resultat = $pdo->query("SELECT membre.email FROM membre INNER JOIN newsletter ON membre.id_membre = newsletter.id_membre");

//envoi de la newsletter
if(!empty($_POST))
{
    //mailto
    echo 'envoyé';
}
?>



<div id="gestion newsletter" class="formulaire py-5">

    <h1>Gestion de la newsletter</h1>
    <h2 class="h4 text-center">Envoyer la Newsletter</h2>
    Nombre d'abonner à la Newsletter : <?php $resultat = $pdo->query('SELECT * FROM newsletter'); echo $resultat->rowCount(); ?>
    <form class="m-5" method="post" action="">
        <div class="mb-3">
            <label class="form-label" for="expéditeur">Expéditeur</label>
            <input class="form-control" type="text" id="expediteur" name="" placeholder="Expéditeur"> 
        </div>
        <div class="mb-3">
            <label class="form-label" for="sujet">Expéditeur</label>
            <input class="form-control" type="text" id="sujet" name="" placeholder="Sujet">
        </div>
        <div class="mb-3">
            Message :<br>
            <textarea class="form-control" type="text" id="expediteur" rows="10" name="" placeholder="Expéditeur"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-5">Envoi de la newsletter aux membres</button>
    </form>


























</div>



<?php include_once('../inc/bas.inc.php');?>
