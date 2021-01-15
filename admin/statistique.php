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
<div id="statistique" class="conteneur py-5">
    <h1>Statistiques</h1>
    <div class="text-center mb-3">
<!--LIENS Gestions des codes promo-->
       <button type="button" class="btn btn-primary mb-3"><a href="?afficher=note">Top 5 des salles les mieux notés</a></button>
       <button type="button" class="btn btn-primary mb-3"><a href="?afficher=vendu">Top 5 des salles les plus vendues</a></button>
       <button type="button" class="btn btn-primary mb-3"><a href="?afficher=membre_qte">Top 5 des membres qui achète le plus</a></button>
       <button type="button" class="btn btn-primary mb-3"><a href="?afficher=membre_prix">Top 5 des membres qui achète le plus cher</a></button>
   </div>
   <?php
if (isset($_GET['afficher']) && $_GET['afficher'] == 'note')
{
    $resultat=$pdo->query('SELECT salle.titre AS nom_salle, AVG(avis.note) AS moy_note FROM salle,avis WHERE salle.id_salle = avis.id_salle GROUP BY salle.titre ORDER BY AVG(avis.note) DESC LIMIT 5');
    ?>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Top</th>
                    <th>Salle</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                $i=0;
                while($datas = $resultat->fetch(PDO::FETCH_ASSOC))
                {
                    $i+=1;
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo '<td>'.$datas['nom_salle'].'</td>';
                    echo '<td>'.number_format($datas['moy_note'],1).' /10</td>';
                    echo '</tr>';
                }?>
            </tbody>
        </table>
    <?php    
}
if (isset($_GET['afficher']) && $_GET['afficher'] == 'vendu')
{
    $resultat=$pdo->query('SELECT salle.titre AS nom_salle, COUNT(details_commande.id_produit) AS nb_commande FROM commande INNER JOIN details_commande ON details_commande.id_commande = commande.id_commande INNER JOIN produit ON details_commande.id_produit = produit.id_produit INNER JOIN salle ON produit.id_salle = salle.id_salle GROUP BY nom_salle ORDER BY nb_commande DESC LIMIT 5');
    ?>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Top</th>
                    <th>Salle</th>
                    <th>Nombre de commande</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                $i=0;
                while($datas = $resultat->fetch(PDO::FETCH_ASSOC))
                {
                    $i+=1;
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo '<td>'.$datas['nom_salle'].'</td>';
                    echo '<td>'.$datas['nb_commande'].'</td>';
                    echo '</tr>';
                }?>
            </tbody>
        </table>
<?php
}
if (isset($_GET['afficher']) && $_GET['afficher'] == 'membre_qte')
{
    $resultat=$pdo->query('SELECT membre.pseudo AS pseudo, membre.id_membre AS id_membre, COUNT(commande.id_membre) AS nb_commande FROM commande INNER JOIN membre ON membre.id_membre = commande.id_membre GROUP BY pseudo ORDER BY nb_commande DESC LIMIT 5');
    ?>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Top</th>
                    <th>id_membre</th>
                    <th>Pseudo</th>
                    <th>Nombre de commande</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                $i=0;
                while($datas = $resultat->fetch(PDO::FETCH_ASSOC))
                {
                    $i+=1;
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo '<td>'.$datas['id_membre'].'</td>';
                    echo '<td>'.$datas['pseudo'].'</td>';
                    echo '<td>'.$datas['nb_commande'].'</td>';
                    echo '</tr>';
                }?>
            </tbody>
        </table>
<?php
}
if (isset($_GET['afficher']) && $_GET['afficher'] == 'membre_prix')
{
    $resultat=$pdo->query('SELECT membre.pseudo AS pseudo, membre.id_membre AS id_membre, SUM(commande.montant) AS montant FROM commande INNER JOIN membre ON membre.id_membre = commande.id_membre GROUP BY pseudo ORDER BY montant DESC LIMIT 5');
    ?>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Top</th>
                    <th>id_membre</th>
                    <th>Pseudo</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                $i=0;
                while($datas = $resultat->fetch(PDO::FETCH_ASSOC))
                {
                    $i+=1;
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo '<td>'.$datas['id_membre'].'</td>';
                    echo '<td>'.$datas['pseudo'].'</td>';
                    echo '<td>'.$datas['montant'].' €</td>';
                    echo '</tr>';
                }?>
            </tbody>
        </table>
<?php
}
?>
</div>
<?php include_once('../inc/bas.inc.php');?>
