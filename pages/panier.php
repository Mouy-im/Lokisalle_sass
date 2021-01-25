<?php include_once('../inc/init.inc.php');?>
<?php
if (!internauteEstConnecte())
{
  header('location:../pages/connexion.php');
  exit();
}
//Paiement & validation de la commande
if(isset($_POST['payer']))
{
  $id_membre=$_SESSION['membre']['id_membre'];
  
  $commande = $pdo->prepare("INSERT INTO commande (montant,id_membre,date) VALUES (?,?,NOW())");
  $commande->execute(array(montantTotal(),$id_membre));
  
  $commande = $pdo->query("SELECT * FROM commande WHERE id_membre=$id_membre AND date=NOW()");
  
  $res= $commande->fetch(PDO::FETCH_ASSOC);
  foreach ($_SESSION['panier'] as $key => $value) 
  { 
    $details_commande = $pdo->prepare("INSERT INTO details_commande (id_commande,id_produit) VALUES (?,?)");
    $details_commande->execute(array($res['id_commande'],$value['id_produit']));
    $produit = $pdo->exec("UPDATE produit SET etat = 0 WHERE id_produit = $value[id_produit]");
  }
  unset($_SESSION['panier']);
  //envoi du mail recap
  $membres = $pdo->query("SELECT * FROM membre WHERE id_membre = $id_membre");
  $membre = $membres->fetch(PDO::FETCH_ASSOC);
  $resultats=$pdo->query("SELECT date_format(date,'%d/%m/%Y') AS new_date,commande.* FROM commande WHERE id_membre = $id_membre ORDER BY date DESC LIMIT 1");
  $datas_commande=$resultats->fetch(PDO::FETCH_ASSOC);
  $to = $membre['email'];
  $subject = 'Lokisalle : Récapitulatif de votre commande';
  $from = 'contact@mouyim-gibassier.xyz';
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

  //En-têtes de courriel
  $headers .= 'From: '.$from."\r\n".
      'Reply-To: '.$from."\r\n" .
      'X-Mailer: PHP/' . phpversion();

  //Message électronique HTML
  $emailText = '<html><body>';
  $emailText .= '<h1>Bonjour '.$membre['pseudo'].' !</h1>';
  $emailText .= '<p>Merci pour votre commande<br>Retrouver votre facture dans votre espace membre "Profil"</p>
  <table class="table table-striped col-12 col-md-5 mx-auto">
  <thead>
    <tr>
      <th colspan="2">Récapitulatif de votre commande</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Commande n°:</td>
      <td>'.$datas_commande['id_commande'].'</td>
    </tr> 
    <tr>
      <td>Date de commande :</td>
      <td>'.$datas_commande['new_date'].'</td>
    </tr>
    <tr>
      <td>Montant TTC:</td>
      <td>'.number_format(($datas_commande['montant']*1.196),2).' €</td>
    </tr>
  </tbody>
</table><br><br>
  <footer>Cordialement,<br><br>Marie de Lokisalle</footer>';
  $emailText .= '</body></html>';
  mail($to, $subject, $emailText, $headers);
  
  //redirection page recapitulatif de commande
  header('location:recap.php');
}
//Vider le panier
if (isset($_GET['action']) && $_GET['action'] == 'vider_panier') {
  unset($_SESSION['panier']);
}

//Supprimer un article du panier
if (isset($_GET['id_suppr'])) {
  unset($_SESSION['panier'][$_GET['id_suppr']]);
}
?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="panier" class="conteneur py-5">
<?php echo $contenu ?>
  <h1>Panier</h1>
  <div class="row table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col" class="text-center">Produit</th>
          <th scope="col" class="text-center">Salle</th>
          <th scope="col" class="text-center">Photo</th>
          <th scope="col" class="text-center">Ville</th>
          <th scope="col" class="text-center">Capacité</th>
          <th scope="col" class="text-center">Date d'arrivée</th>
          <th scope="col" class="text-center">Date départ</th>
          <th scope="col" class="text-center">Retirer</th>
          <th scope="col" class="text-center">Prix HT</th>
          <th scope="col" class="text-center">TVA*</th>
        </tr>
      </thead>
      <tbody>
      <?php
        if((isset($_SESSION['panier']) && empty($_SESSION['panier'])) || !isset($_SESSION['panier']))
        {?>
        <tr>
          <td scope="col" class="text-center" colspan="10">Votre panier est vide</td>
        </tr>
        </tbody>
       <?php
        }else 
        {?>
          <?php  foreach ($_SESSION['panier'] as $key => $value) { ?>
          <tr>
            <th class="align-middle text-center" scope="row"><?php echo $value['id_produit'] ?></th>
            <td class="align-middle text-center" style="width:1%;"><?php echo $value['titre'] ?></td>
            <td class="align-middle text-center" style="width:20%;"><a href="<?php echo '/pages/reservation_details.php?id='.$value['id_produit']?>"><img src="<?php echo $value['photo'] ?>"alt="<?php echo $value['ville'] ?>" width="100%"></a></td>
            <td class="align-middle text-center"><?php echo $value['ville'] ?></td>
            <td class="align-middle text-center"><?php echo $value['capacite'] ?></td>
            <td class="align-middle text-center"><?php echo $value['date_arrivee'] ?></td>
            <td class="align-middle text-center"><?php echo $value['date_depart'] ?></td>
            <td class="align-middle text-center"><a href="<?php echo '?id_suppr='.$value['id_produit']?>"><i class="fa fa-trash fa-2x"></i></a></td>
            <td class="align-middle text-center"><?php echo number_format($value['prix'], 2) ?> €<br>
            <?php
            if (!empty($_POST['codepromo'])) {
                $codepromo = $pdo->query("SELECT * FROM produit,promotion where promotion.code_promo = '$_POST[codepromo]' AND promotion.id_promo = produit.id_promo");
                $data = $codepromo->fetch(PDO::FETCH_ASSOC);
                if ($codepromo->rowcount() !=0 && $data['id_produit']==$key) {
                    echo '<strong>Remise : '.$_POST['codepromo'].'<br> - '.$data['reduction'] .'%</strong>';
                } elseif ($codepromo->rowcount() == 0) {
                    $message = 'Le code promo n\'est pas valide';
                }
            }?>
              </td>
            <td class="align-middle text-center">19.6 %</td>
          </tr>
          <?php }
        
      ?>
      </tbody>  
      <tfoot>
      <tr>
          <th scope="col" class="text-center" colspan="8">Prix total HT :</th>
          <th scope="col" class="text-center" colspan="2"><?php echo number_format(montantTotal(), 2) ?>€</th>
        </tr>
        <tr>
          <th scope="col" class="text-center" colspan="8">Prix total TTC :</th>
          <th scope="col" class="text-center" colspan="2"><?php echo number_format(montantTotal()*1.196, 2) ?>€</th>
        </tr>
        <?php
          if (!empty($_POST['codepromo'])) 
          {
              $codepromo = $pdo->query("SELECT * FROM produit,promotion where promotion.code_promo = '$_POST[codepromo]' AND promotion.id_promo = produit.id_promo");
            
              $data = $codepromo->fetch(PDO::FETCH_ASSOC);
              foreach ($_SESSION['panier'] as $key => $value) 
              {
                  if ($codepromo->rowcount() !=0 && $data['id_produit']==$key) {?>
              <tr>
                <th scope="col" class="text-center" colspan="8">Promotion </th>
                <th scope="col" class="text-center" colspan="2"><?php echo ' - '.$data['reduction'];?>%</th>
              </tr>
              <tr>
                <th scope="col" class="text-center" colspan="8">Montant TTC après remise :</th>
                <th scope="col" class="text-center" colspan="2"><?php echo number_format(reduction($data['reduction']), 2);?>€</th>
              </tr>
                <?php
              }
          }
        }?>
          <tr>
            <th scope="col" class="text-center" colspan="10"><a href="/pages/panier.php?action=vider_panier"> Vider le panier</a></th>
          </tr>
        </tfoot>
<?php } ?>
    </table>
  </div>
  <div class="my-5">
      <em>*Tous nos articles sont calculés avec le taux de TVA à 19,6%</em>
  </div>
  <div class="row">
    <form method="post" action="">
      Utiliser un code promo<br>
      <div class="input-group col-12 col-lg-4 px-0">
        <input type="text" name="codepromo" id="codepromo" class="form-control" placeholder="Votre code promo" aria-label="" aria-describedby="basic-addon1">
        <div class="input-group-append">
          <button type="submit" class="btn btn-outline-secondary" type="button">Valider</button>
        </div>
      </div>
      <p class="message_error"><?php if (!empty($_POST['codepromo'])) echo $message?> </p>
    </form>
    <div class="my-3">
      <a href="?action=paiement#paiement_form" class="btn btn-primary" name="valid_panier">Valider mon panier</a>
    </div>
  </div>
    <!--Formulaire de paiement-->
    <?php if (!empty($_SESSION['panier']) && (isset($_GET['action']) && $_GET['action']=='paiement'))
    {
      ?>
    <div id="paiement_form" class="col-12">
    <h2 class="text-center h3">Paiement</h2>
      <form method="post" action="" class="mx-auto col-12 col-sm-10 col-md-8 col-lg-6">
        <div class="bg-light p-2 p-md-5 col-12 col-md-10 mx-auto">
          <div class="mb-3">
            <span class="paiement_form">Type de carte*</span>
            <select class="form-select" id="cb_type" name="cb_type" required>
                <option value="" hidden>-- Carte bancaire --</option>
                <option value="visa">VISA</option>
                <option value="mastercard">Mastercard</option>
                <option value="maestro">Maestro</option>
            </select>
          </div>
          <div class="mb-3">
            <span class="paiement_form">Numéro de carte*</span>
            <input type="text" class="form-control" id="card_number" name="card_number" pattern="[0-9\s]{19}" placeholder="Ex : 4973 1234 1234 1234" required>
          </div>
          <div class="mb-3 col-12 p-0">
            <div class="row">
              <div class="col-12 col-md-8">
                <span class="paiement_form">Date d'expiration*</span><br>
                <div class="form-inline">
                  <select class="form-select col-6 col-md-4" id="cb_exp_month" name="cb_exp_month" required>
                    <option value="" hidden>-- MM --</option>
                    <?php 
                    for ($i=01; $i<=12; $i++)
                    {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }?>
                  </select>
                  <select class="form-select col-6 col-md-4" id="cb_exp_year" name="cb_exp_year" required>
                    <option value="" hidden>-- AAAA --</option>
                    <?php for ($i=2021; $i<=2031; $i++){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }?>
                  </select>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <span class="paiement_form"><span class="paiement_form">Cryptogramme*</span>
                <input type="text" class="form-control" id="card_crypto" pattern="[0-9]{3}" name="card_crypto" required>
              </div>
            </div>
          </div>
          <span class="paiement_form"><em>*Champs obligatoires</em></span>
        </div>
        <div class="col-12 col-md-10 mx-auto">
          <div>
            <input type="checkbox" name="cgv" id="cgv" class="mr-2" required><label for="cgv" class="form-label">J'accepte les CGV <a href="/pages/cgv.php">(voir)</a>
            <br>
          </div>
          <div class="col-10 mx-auto text-center">
            <input type="submit" class="btn btn-primary" name="payer" value="Valider le paiement">
          </div>
        </div>
      </form>
    </div>
  </div>
 <?php
 } 
 ?>
</div>

<?php include_once('../inc/bas.inc.php');?>