<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="panier" class="conteneur py-5">
  <h1>Panier</h1>
  <div class="row">
  <?php

//Vider le panier
if (isset($_GET['action']) && $_GET['action'] == 'vider_panier') {
  unset($_SESSION['panier']);
}

//Supprimer un article du panier
if (isset($_GET['id_suppr'])) {
  unset($_SESSION['panier'][$_GET['id_suppr']]);
}

  if (isset($_GET['ajout_panier'])) 
  {
      $resultat = $pdo->query("SELECT * FROM produit,salle WHERE produit.id_salle=salle.id_salle AND produit.id_produit = '$_GET[id]'");
    
      $produit = $resultat->fetch(PDO::FETCH_ASSOC);
      //debug($produit['titre']);
      //die;
      ajouterProduitDansPanier($produit['id_produit'], $produit['titre'], $produit['photo'], $produit['ville'], $produit['capacite'], $produit['date_arrivee'], $produit['date_depart'], $produit['prix']);
  }?>
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
          <th scope="col" class="text-center">TVA</th>
        </tr>
      </thead>
      <tbody>
      <?php if (isset($_SESSION['panier']))
      {
        if(empty($_SESSION['panier']))
        {?>
        <tr>
          <td scope="col" class="text-center" colspan="10">Votre panier est vide</td>
        </tr>
       <?php
        }else 
        {?>
          <?php  foreach ($_SESSION['panier'] as $key => $value) { ?>
          <tr>
            <th class="align-middle text-center" scope="row"><?php echo $value['id_produit'] ?></th>
            <td class="align-middle text-center" style="width:1%;"><?php echo $value['titre'] ?></td>
            <td class="align-middle text-center" style="width:20%;"><a href="<?php echo '/reservation_details.php?id='.$value['id_produit'] ?>'"><img src="<?php echo $value['photo'] ?>"alt="<?php echo $value['ville'] ?>" width="100%"></a></td>
            <td class="align-middle text-center"><?php echo $value['ville'] ?></td>
            <td class="align-middle text-center"><?php echo $value['capacite'] ?></td>
            <td class="align-middle text-center"><?php echo $value['date_arrivee'] ?></td>
            <td class="align-middle text-center"><?php echo $value['date_depart'] ?></td>
            <td class="align-middle text-center"><a href="<?php echo '?id_suppr='.$value['id_produit']?>"><i class="fa fa-trash fa-2x"></i></a></td>
            <td class="align-middle text-center"><?php echo number_format($value['prix'],2) ?> €<br>
            <?php 
            if (!empty($_POST['codepromo'])) 
            {
                $codepromo = $pdo->query("SELECT * FROM produit,promotion where promotion.code_promo = '$_POST[codepromo]' AND promotion.id_promo = produit.id_promo");
                $data = $codepromo->fetch(PDO::FETCH_ASSOC);
                if ($codepromo->rowcount() !=0 && $data['id_produit']==$key) 
                {
                
                  echo '<strong>Remise : '.$_POST['codepromo'].' - '.$data['reduction'] .'%</strong>';
               
               
                }
            }?>
              </td>
            <td class="align-middle text-center">19.6 %</td>
          </tr>
          <?php } 
        }
      }?>
      </tbody>  
      <tfoot>
        <tr>
          <th scope="col" class="text-center" colspan="8">Prix total TTC :</th>
          <th scope="col" class="text-center" colspan="2"><?php echo number_format(montantTotal(),2) ?>€</th>
        </tr>
        <?php
          if (!empty($_POST['codepromo']))
          {
           
            $codepromo = $pdo->query("SELECT * FROM produit,promotion where promotion.code_promo = '$_POST[codepromo]' AND promotion.id_promo = produit.id_promo");
            
            $data = $codepromo->fetch(PDO::FETCH_ASSOC);
            foreach ($_SESSION['panier'] as $key => $value) 
            {
              if($codepromo->rowcount() !=0 && $data['id_produit']==$key)
              {?>
              <tr>
                <th scope="col" class="text-center" colspan="8">Promotion </th>
                <th scope="col" class="text-center" colspan="2"><?php echo ' - '.$data['reduction'];?>%</th>
              </tr>
              <tr>
                <th scope="col" class="text-center" colspan="8">Montant TTC après remise :</th>
                <th scope="col" class="text-center" colspan="2"><?php echo round(reduction($data['reduction']),2);?>€</th>
              </tr>
                <?php
              }
            }
            
          }
          ?>
        </tfoot>
      </thead>
    </table>
    <form method="post" action="">
      <div class="my-3">
        <label for="cgv" class="form-label">J'accepte les conditions générales de vente <a href="/pages/cgv.php">(voir)</a>
        <input type="checkbox" name="cgv" id="cgv" required><br>
      </div>
      <label for="codepromo" class="form-label">Utiliser un code promo
      <input type="text" class="form-control" name="codepromo" id="codepromo">
      <input type="submit" class="btn btn-secondary" value="Valider le code promo">
      <div class="my-3">
        <input type="submit" class="btn btn-primary" value="Payer">
      </div>
    </form>
<a href="/pages/panier.php?action=vider_panier"> + Vider le panier</a>
  </div>
  <div>
    <pre>
Tous nos articles sont calculés avec le taux de TVA à 19,6%

Règlement: Par Chèque uniquement

Nous attendons votre règlement par chèque à l'adresse suivante:

Ma boutique - 1 Rue Boswellia, 75000 Paris, France
    </pre>

  </div>
</div>
<?php include_once('../inc/bas.inc.php');?>