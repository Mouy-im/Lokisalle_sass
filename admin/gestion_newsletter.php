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
    $emailText = $_POST['message'];
    $subject = $_POST['sujet'];
    $from = $_POST['expediteur'];
    $headers = "From :".$from;
    while ($emails_news = $resultat->fetch(PDO::FETCH_ASSOC))
    {
    $emailTo = $emails_news['email'];
    mail($emailTo,$subject,$emailText,$headers);
    }
    $message = 'Newletter envoyé à vos '.$resultat->rowCount(). ' abonnés.';
    echo '<div class="col-12 col-md-6 mt-5 mx-auto alert alert-success text-center" role="alert">'.$message.'</div>';
}
?>
<div id="gestion newsletter" class="formulaire py-3">
    <h1>Gestion de la newsletter</h1>
    <h2 class="h4 text-center">Envoyer la Newsletter</h2>
   
    <form class="m-5" method="post" action="">
        <div class="mb-3">
            <strong>Nombre d'abonner à la Newsletter : </strong><?php $resultat = $pdo->query('SELECT * FROM newsletter'); echo $resultat->rowCount(); ?>
        </div>
        <div class="mb-3">
            <label class="form-label" for="expediteur">Expéditeur</label>
            <input class="form-control" type="email" id="expediteur" name="expediteur" placeholder="Expéditeur@email.com"> 
        </div>
        <div class="mb-3">
            <label class="form-label" for="sujet">Sujet</label>
            <input class="form-control" type="text" id="sujet" name="sujet" placeholder="Sujet">
        </div>
        <div>
            Message :<br>
            <textarea class="form-control" type="text" id="message" rows="10" name="message" placeholder="Message"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-5">Envoi de la newsletter aux membres</button>
    </form>
</div>
<?php include_once('../inc/bas.inc.php');?>
