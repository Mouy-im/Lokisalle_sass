<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');

if (!internauteEstConnecteEtEstAdmin())
{
  header('location:../pages/connexion.php');
  exit();
}

?>
<div id="gestion_codepromo" class="conteneur py-5">
    <h1>Gestion des codes promo</h1>
    <div class="text-center mb-3">

<?php
 //--- LIENS Gestions codes promo ---//
$contenu .= '<a href="?action=affichage">Affichage des codes promo</a><br>';
$contenu .= '<a href="?action=ajout">Ajout d\'un code promo</a><br><br><hr><br>';
echo $contenu;

//Affichage des codes promo
if (isset($_GET['action']) && $_GET['action'] == 'affichage') {
    ?>
    <div class="row">
 
        <table class="table table-striped text-center">
            <thead>
                <tr>
<?php
$cols = $pdo->query("SELECT COLUMN_NAME as col FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'promotion'");
    while ($col = $cols->fetch(PDO::FETCH_ASSOC)) {
        echo '<th scope="col">'.$col['col'].'</th>';
    } ?>              
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
           
<?php
$resultat = $pdo->query('SELECT * FROM promotion');
    while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>'.$datas['id_promo'].'</td>';
        echo '<td>'.$datas['code_promo'].'</td>';
        echo '<td>'.$datas['reduction'].'</td>';
        echo '<td><a href="?action=edit&id='.$datas['id_promo'].'"><i class="fa fa-edit fa-2x"></i></a></td>';
        echo '<td><a href="?action=delete&id='.$datas['id_promo'].'"><i class="fa fa-trash fa-2x"></i></a></td>';
        echo '</tr>';
    } ?>
            </tbody>
        </table>
    </div>
<?php
}
//Ajout ou modification d'un code promo via le formulaire
if (!empty($_POST)) {
    //ajout
    if ($_GET['action']=='ajout') {
        $statement = $pdo->prepare("INSERT INTO promotion(code_promo, reduction)VALUES (?,?)");
        $resultat = $statement->execute(array($_POST['code_promo'],$_POST['reduction']));
        echo '<div class="alert alert-success" role="alert">Ajout d\'un nouveau code promo effectué</div>';
        die;
    }
    //modification
    if ($_GET['action']=='edit') {
        $statement = $pdo->prepare("UPDATE promotion SET code_promo = ?, reduction = ? WHERE id_promo = '$_GET[id]'");
        $resultat = $statement->execute(array($_POST['code_promo'],$_POST['reduction']));
        echo '<div class="alert alert-success " role="alert">Modification du code promo '.$_POST['id_promo'].' effectué</div>';
        die;
    }
}

//suppression d'un code promo
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{   
   $pdo->query("DELETE FROM promotion WHERE id_promo = '$_GET[id]'");
   echo '<div class="alert alert-danger" role="alert">Suppression du code promo '.$_GET['id'].' effectué</div>' ;
      die;
}

//Formulaire ajout ou modification d'un code promo
if (isset($_GET['action']) && ($_GET['action']=='ajout' || $_GET['action']=='edit')) {
    if ($_GET['action']=='edit') {
        $promos = $pdo->query("SELECT * FROM promotion WHERE id_promo = '$_GET[id]'");
        $promo = $promos->fetch(PDO::FETCH_ASSOC);
    } ?>
  
      <form action="" method="post" enctype="multipart/form-data" class="py-5 formulaire">
  
      <input type="hidden" id="id_promo" name="id_promo" value="<?php if (isset($promo['id_promo'])) {
        echo $promo['id_promo'];
    } ?>"/>
       
        <div class="mb-3">
            <label for="code_promo" class="form-label">Code promo</label>
            <input type="text" class="form-control" id="code_promo" name="code_promo" placeholder="code_promo" value="<?php if (isset($promo['code_promo'])) {
        echo $promo['code_promo'];
    } ?>">
        </div>
        <div class="mb-3">
          <label for="reduction" class="form-label">Réduction</label>
          <input type="text" class="form-control" id="reduction" name="reduction" placeholder="reduction" value="<?php if (isset($promo['reduction'])) {
        echo $promo['reduction'];
    } ?>">
        </div>
       
      <button type="submit" class="btn btn-primary mt-2"><?php
      if (isset($_GET['action']) && $_GET['action'] == 'edit') {
          echo 'Modifier';
      } else {
          echo'Ajouter';
      } ?></button>
      </form>
    ?>

  

<?php
}
?>
    </div>
</div>
<?php include_once('../inc/bas.inc.php');?>




