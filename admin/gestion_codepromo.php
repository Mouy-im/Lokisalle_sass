<?php include_once('../inc/init.inc.php');?>
<?php
if (!internauteEstConnecteEtEstAdmin())
{
  header('location:../pages/connexion.php');
  exit();
}
//Ajout ou modification d'un code promo via le formulaire
if (!empty($_POST)) {
    //ajout
    if ($_GET['action']=='ajout') {
        $statement = $pdo->prepare("INSERT INTO promotion(code_promo, reduction)VALUES (?,?)");
        $resultat = $statement->execute(array($_POST['code_promo'],$_POST['reduction']));
        $message = '<div class="alert alert-success" role="alert">Ajout d\'un nouveau code promo effectué</div>';
        
    }
    //modification
    if ($_GET['action']=='edit') {
        $statement = $pdo->prepare("UPDATE promotion SET code_promo = ?, reduction = ? WHERE id_promo = ?");
        $resultat = $statement->execute(array($_POST['code_promo'],$_POST['reduction'],$_GET['id']));
        $message = '<div class="alert alert-success" role="alert">Modification du code promo '.$_POST['id_promo'].' effectué</div>';
     
    }
}

//suppression d'un code promo
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{   
    $statement = $pdo->prepare("DELETE FROM promotion WHERE id_promo = ?");
    $resultat = $statement->execute(array($_GET['id']));
    $message = '<div class="alert alert-danger" role="alert">Suppression du code promo '.$_GET['id'].' effectué</div>' ;
}

?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<div id="gestion_codepromo" class="conteneur py-5">
    <h1>Gestion des codes promo</h1>
    <div class="text-center mb-3">

 <!--LIENS Gestions des codes promo-->
        <button type="button" class="btn btn-primary mb-3"><a href="?action=affichage">Affichage des codes promo</a></button>
        <button type="button" class="btn btn-primary mb-3"><a href="?action=ajout">Ajout d'un code promo</a></button>
       
    </div>
 <?php echo $message; ?>  
<?php
//Affichage des codes promo
if (isset($_GET['action']) && $_GET['action'] == 'affichage') {
    ?>
    <div class="row">
 
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th scope="col">id_promo</th>
                    <th scope="col">Code promo</th>
                    <th scope="col">Réduction</th>
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
        echo '<td><a href="?action=delete&id='.$datas['id_promo'].'" Onclick="'."return(confirm('Êtes-vous sûr de vouloir supprimer ce code promo?'))".'"><i class="fa fa-trash fa-2x"></i></a></td>';
        echo '</tr>';
    } ?>
            </tbody>
        </table>
    </div>
<?php
}
//Formulaire ajout ou modification d'un code promo
if (isset($_GET['action']) && ($_GET['action']=='ajout' || $_GET['action']=='edit')) {
    if ($_GET['action']=='edit') 
    {
        $statement = $pdo->prepare("SELECT * FROM promotion WHERE id_promo = ?");
        $statement->execute(array($_GET['id']));
        $promo = $statement->fetch(PDO::FETCH_ASSOC);
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




