<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');

if (!internauteEstConnecteEtEstAdmin())
{
  header('location:../pages/connexion.php');
  exit();
}

?>
<div id="gestion_avis" class="conteneur py-5">
    <h1>Gestion des avis</h1>
    <div class="text-center mb-3">


  <?php

//suppression d'un avis
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{   
   $pdo->query("DELETE FROM avis WHERE id_avis = '$_GET[id]'");
   echo '<div class="alert alert-success" role="alert">Suppression de l\'avis '.$_GET['id'].' effectué</div><br><a href="/admin/gestion_avis.php">Retour sur la page des avis</a>' ;
      die;
}

//Affichage des salles
?>
    <div class="row">
 
        <table class="table table-striped text-center">
            <thead>
                <tr>
<?php
$cols = $pdo->query("SELECT COLUMN_NAME as col FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'avis'");
while ($col = $cols->fetch(PDO::FETCH_ASSOC)) 
{
     echo '<th scope="col">'.$col['col'].'</th>';                
}
?>              
                <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
           
<?php
$resultat = $pdo->query('SELECT * FROM avis');
while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
{
    echo '<tr>';
    echo '<td>'.$datas['id_avis'].'</td>';
    echo '<td>'.$datas['id_membre'].'</td>';
    echo '<td>'.$datas['id_salle'].'</td>';
    echo '<td>'.$datas['commentaire'].'</td>';
    echo '<td>'.$datas['note'].'</td>';
    echo '<td>'.$datas['date'].'</td>';
    echo '<td><a href="?action=delete&id='.$datas['id_avis'].'"><i class="fa fa-trash fa-2x"></i></a></td>';
    echo '</tr>';
}
?>
            </tbody>
        </table>
    </div>
  </div>
</div>

<?php include_once('../inc/bas.inc.php');?>




