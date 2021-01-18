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

<div id="gestion_commande" class="conteneur py-5">
    <h1>Gestion des commandes</h1>
    <div class="text-center mb-3">
    <!-- Affichage des commandes -->
        <div class="row">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">id_commande</th>
                        <th scope="col">id_membre</th>
                        <th scope="col">
                            <div class="dropdown">
                                <span class="dropdown-toggle" id="drop_montant" data-bs-toggle="dropdown" aria-expanded="false">Montant
                                </span>
                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="drop_montant">
                                    <li><a class="dropdown-item" href="/admin/gestion_commande.php?trie=montant_asc">Trier par ordre croissant</a></li>
                                    <li><a class="dropdown-item" href="/admin/gestion_commande.php?trie=montant_desc">Trier par ordre décroissant</a></li>
                                </ul>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $total = 0;
                if(isset($_GET['trie']) && $_GET['trie'] == 'montant_asc')
                {
                    $resultat = $pdo->query('SELECT * FROM commande ORDER by montant asc');
                }elseif (isset($_GET['trie']) && $_GET['trie'] == 'montant_desc')
                {
                    $resultat = $pdo->query('SELECT * FROM commande ORDER by montant desc');
                }else{
                    $resultat = $pdo->query('SELECT * FROM commande');
                }
                    while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
                    {
                    ?>
                        <tr>
                        <td><a href="?action=afficher&id_commande=<?php echo $datas['id_commande']?>"><?php echo $datas['id_commande'] ?></a></td>
                        <td><?php echo $datas['id_membre'] ?></td>
                        <td><?php echo number_format($datas['montant'],2) ?></td>

                        </tr>
                    <?php
                    $total += $datas['montant'];
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-center">
        Le chiffre d'affaire (CA) de notre société est de :  <?php echo number_format($total,2) ?> €
    </div>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'afficher')
{
    $commande = $pdo->prepare("SELECT * FROM commande WHERE id_commande = ?");
    $commande->execute(array($_GET['id_commande']));
    $data = $commande->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="row mt-5">
        <h2 class="h5 text-center">Détails de la commande</h2>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th scope="col">id_commande</th>
                    <th scope="col">
                            <div class="dropdown">
                                <span class="dropdown-toggle" id="drop_montant" data-bs-toggle="dropdown" aria-expanded="false">Montant
                                </span>
                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="drop_montant">
                                    <li><a class="dropdown-item" href="/admin/gestion_commande.php?action=afficher&id_commande=<?php echo $data['id_commande']?>&trie=montant_asc">Trier par ordre croissant</a></li>
                                    <li><a class="dropdown-item" href="/admin/gestion_commande.php?action=afficher&id_commande=<?php echo $data['id_commande']?>&trie=montant_desc">Trier par ordre décroissant</a></li>
                                </ul>
                            </div>
                        </th>
                    <th scope="col">Date</th>
                    <th scope="col">id_membre</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">id_produit</th>
                    <th scope="col">id_salle</th>
                    <th scope="col">Ville</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if(isset($_GET['trie']) && $_GET['trie'] == 'montant_asc')
            {
                $resultat = $pdo->query("SELECT commande.*, membre.pseudo AS pseudo, produit.*, details_commande.*, salle.ville AS ville FROM commande INNER JOIN membre ON membre.id_membre=commande.id_membre INNER JOIN details_commande ON commande.id_commande=details_commande.id_commande INNER JOIN produit ON details_commande.id_produit = produit.id_produit INNER JOIN salle ON salle.id_salle=produit.id_salle WHERE commande.id_commande = '$_GET[id_commande]' ORDER by prix asc");
            }elseif(isset($_GET['trie']) && $_GET['trie'] == 'montant_desc')
            {
                $resultat = $pdo->query("SELECT commande.*, membre.pseudo AS pseudo, produit.*, details_commande.*, salle.ville AS ville FROM commande INNER JOIN membre ON membre.id_membre=commande.id_membre INNER JOIN details_commande ON commande.id_commande=details_commande.id_commande INNER JOIN produit ON details_commande.id_produit = produit.id_produit INNER JOIN salle ON salle.id_salle=produit.id_salle WHERE commande.id_commande = '$_GET[id_commande]' ORDER by prix desc");
            }else
            {
                $resultat = $pdo->query("SELECT commande.*, membre.pseudo AS pseudo, produit.*, details_commande.*, salle.ville AS ville FROM commande INNER JOIN membre ON membre.id_membre=commande.id_membre INNER JOIN details_commande ON commande.id_commande=details_commande.id_commande INNER JOIN produit ON details_commande.id_produit = produit.id_produit INNER JOIN salle ON salle.id_salle=produit.id_salle WHERE commande.id_commande = '$_GET[id_commande]'");
            }
                    while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
                    {
                    ?>
                        <tr>
                            <td><?php echo $datas['id_commande'] ?></td>
                            <td><?php echo number_format($datas['prix'],2) ?></td>
                            <td><?php echo $datas['date'] ?></td>
                            <td><?php echo $datas['id_membre'] ?></td>
                            <td><?php echo $datas['pseudo'] ?></td>
                            <td><?php echo $datas['id_produit'] ?></td>
                            <td><?php echo $datas['id_salle'] ?></td>
                            <td><?php echo $datas['ville'] ?></td>
                        </tr>
                    <?php
                    } 
                   ?>
            </tbody>
        </table>
    </div>  
<?php
}
?>

</div>
<?php include_once('../inc/bas.inc.php');?>




