<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<?php $commande = $pdo->query("SELECT date_format(commande.date,'%d/%m/%Y') AS new_date_commande,commande.*, membre.* FROM commande INNER JOIN membre ON membre.id_membre = commande.id_membre INNER JOIN details_commande ON details_commande.id_commande = commande.id_commande INNER JOIN produit ON produit.id_produit = details_commande.id_produit INNER JOIN salle ON salle.id_salle=produit.id_salle WHERE commande.id_commande = $_GET[id_commande]");
 $data=$commande->fetch(PDO::FETCH_ASSOC);
    ?>
<div class="conteneur">
    <hr>
    <h1 class="text-left"><img class= "pb-2 pr-3" src="/inc/logo/logoseul.png" alt ="logo lokisalle"><span class="align-middle">Facture</span></h1>

<hr>
  <section class="text-center">
   <dl>
      <dt>Facture N° :</dt>
      <dd><?php echo $data['id_commande'] ?></dd>
      <dt>Date de facturation :</dt>
      <dd><?php echo $data['new_date_commande'] ?></dd>
    </dl>
</section>
<section>
    <dl>
        <dt>Facturé à :</dt>
        <dd>
        <?php echo $data['nom'] .' '.$data['prenom'].'<br>'
        .$data['adresse'].'<br>'
        .$data['cp'].' '.$data['ville']; ?>
        
        </dd>
    <dl>
        <dt>Email :</dt>
        <dd><?php echo $data['email'] ?></dd>
    </dl>
    <section id="facture" class="table-responsive">
    <table class="table table-striped text-center my-5">
        <thead>
            <tr>
                <th scope="col">id_commande</th>
                <th scope="col">id_produit</th>
                <th scope="col">Salle</th>
                <th scope="col">Date d'arrivée</th>
                <th scope="col">Date de départ</th>
                <th scope="col">Adresse</th>
                <th scope="col">Ville</th>
                <th scope="col">Code postal</th>
                <th scope="col">Prix HT</th>
            </tr>    
        </thead>
        <tbody>
        <?php
$pdo->query("SET lc_time_names = 'fr_FR'");
$resultat = $pdo->query("SELECT commande.*, membre.pseudo AS pseudo, date_format(produit.date_arrivee,'%d/%m/%Y à %kh%i') AS new_date_arrivee,date_format(produit.date_depart,'%d/%m/%Y à %kh%i') AS new_date_depart,produit.*, details_commande.*, salle.ville AS ville, salle.titre AS nom_salle, salle.adresse AS adresse, salle.cp AS cp FROM commande INNER JOIN membre ON membre.id_membre=commande.id_membre INNER JOIN details_commande ON commande.id_commande=details_commande.id_commande INNER JOIN produit ON details_commande.id_produit = produit.id_produit INNER JOIN salle ON salle.id_salle=produit.id_salle WHERE commande.id_commande = '$_GET[id_commande]'");
$total = 0;
       while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
        {?>
        <tr>
            <td><?php echo $datas['id_commande'] ?></td>
            <td><?php echo $datas['id_produit'] ?></td>
            <td><?php echo $datas['nom_salle'] ?></td>
            <td><?php echo $datas['new_date_arrivee'] ?></td>
            <td><?php echo $datas['new_date_depart'] ?></td>
            <td><?php echo $datas['adresse'] ?></td>
            <td><?php echo $datas['ville'] ?></td>
            <td><?php echo $datas['cp'] ?></td>
            <td><?php echo number_format($datas['prix'],2) ?> €</td>
           
</tr>
        <?php  $total += $datas['prix']; }  ?>
        </tbody>
        <tfoot>
        <tr> 
            <td colspan="8">Montant Total HT</td>
            <td><?php echo number_format($total,2);?> €</td>
        </tr>
        <tr> 
            <td colspan="8">Montant Total TTC</td>
            <td><?php echo number_format($total*1.196,2);?> €</td>
        </tr>
        </tfoot>
    </table>
</section>
  <hr>
  <div class="text-center">
   Lokisalle - SARL | <a href="/index.php">https://www.lokisalle.mouyim-gibassier.xyz</a> | 
   1 Rue Boswellia, 75000 Paris, France | <a href="mailto:contact@lokisalle.com">contact@lokisalle.com</a>
   </div>
    </div>

<?php include_once('../inc/bas.inc.php');?>