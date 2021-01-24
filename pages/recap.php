<?php include_once('../inc/init.inc.php');
unset($_SESSION['panier']);
?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<?php
$id_membre = $_SESSION['membre']['id_membre'];
$resultats=$pdo->query("SELECT date_format(date,'%d/%m/%Y') AS new_date,commande.* FROM commande WHERE id_membre = $id_membre ORDER BY date DESC LIMIT 1");
$datas=$resultats->fetch(PDO::FETCH_ASSOC); ?>
<div id="recap" class="conteneur py-5">
  <h1>Récapitulatif de votre commande</h1>
    <div class="text-center">
      <h2>Merci pour votre commande</h2>
      Vous recevrez un mail de confirmation de commande<br>
      Votre facture est disponible dans votre espace membre "profil"<br>
      <br>
      <table class="table table-striped col-12 col-md-5 mx-auto">
        <thead>
          <tr>
            <th colspan="2">Récapitulatif de votre commande</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Commande n°:</td>
            <td><?php echo $datas['id_commande']?></td>
          </tr> 
          <tr>
            <td>Date de commande :</td>
            <td><?php echo $datas['new_date']?></td>
          </tr>
          <tr>
            <td>Montant TTC:</td>
            <td><?php echo number_format(($datas['montant']*1.196),2)?> €</td>
          </tr>
        </tbody>
      </table>
    </div>
</div>


<?php include_once('../inc/bas.inc.php');?>