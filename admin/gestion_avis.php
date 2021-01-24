<?php include_once('../inc/init.inc.php');?>
<?php
if (!internauteEstConnecteEtEstAdmin())
{
  header('location:../pages/connexion.php');
  exit();
}

//suppression d'un avis
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{   
   $statement = $pdo->prepare("DELETE FROM avis WHERE id_avis = ?");
   $resultat = $statement->execute(array($_GET['id']));
   $message = '<div class="alert alert-success" role="alert">Suppression de l\'avis '.$_GET['id'].'</div>';
  }

?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<div id="gestion_avis" class="conteneur py-5">
    <h1>Gestion des avis</h1>
    <div class="text-center mb-3">
<?php echo $message ?>

<!-- Affichage des salles -->
    <div class="row">
 
        <table class="table table-striped text-center">
            <thead>
                <tr>
                  <th scope="col">id_avis</th>
                  <th scope="col">id_membre</th>
                  <th scope="col">id_salle</th>
                  <th scope="col">Commentaire</th>
                  <th scope="col">Note</th>
                  <th scope="col">Date</th>         
                  <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
           
<?php
$resultat = $pdo->query('SELECT * FROM avis');
while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
{
    $datas['commentaire']=stripslashes($datas['commentaire']);
    echo '<tr>';
    echo '<td>'.$datas['id_avis'].'</td>';
    echo '<td>'.$datas['id_membre'].'</td>';
    echo '<td>'.$datas['id_salle'].'</td>';
    echo '<td>'.$datas['commentaire'].'</td>';
    echo '<td>'.$datas['note'].'</td>';
    echo '<td>'.$datas['date'].'</td>';?>
    <td><a href="?action=delete&id=<?php echo $datas['id_avis']?>" Onclick="return(confirm('Êtes-vous sûr de vouloir supprimer cet avis?'))"><i class="fa fa-trash fa-2x"></i></a></td>
    </tr>
<?php
}
?>
            </tbody>
        </table>
    </div>
  </div>
</div>
<?php include_once('../inc/bas.inc.php');?>




