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

<div id="gestion_salle" class="conteneur py-5">
    <h1>Gestion des produits</h1>
    <div class="text-center mb-3">
      <!--LIENS Gestions salles-->
      <button type="button" class="btn btn-primary mb-3"><a href="?action=affichage">Affichage des produits</a></button>
      <button type="button" class="btn btn-primary mb-3"><a href="?action=ajout">Ajout d'un produit</a></button>
<?php

//Ajout ou modification d'une salle via le formulaire
if (!empty($_POST)) 
{
    //ajout
    if(isset($_GET['action']) && $_GET['action']=='ajout')
    {
      $new_produit = $pdo->prepare("INSERT INTO produit(date_arrivee, date_depart, id_salle, id_promo, prix, etat)VALUES (?,?,?,?,?,?)");
      $ajout = $new_produit->execute(array($_POST['date_arrivee'],$_POST['date_depart'],$_POST['id_salle'],$_POST['id_promo'],$_POST['prix'],1));
      echo '<div class="alert alert-success" role="alert">Ajout d\'un nouveau produit effectué</div>';
      die;
    }
    //modification 
    if(isset($_GET['action']) && $_GET['action']=='edit')
    {
      $edit_produit = $pdo->prepare("UPDATE produit SET date_arrivee = ?, date_depart = ?, id_salle = ?, id_promo = ?, prix = ? WHERE id_produit = ?");
      $edit = $edit_produit->execute(array($_POST['date_arrivee'],$_POST['date_depart'],$_POST['id_salle'],$_POST['id_promo'],$_POST['prix'],$_GET['id']));
      echo '<div class="alert alert-success " role="alert">Modification de la salle '.$_POST['id_produit'].' effectuée</div>';
      die;
    }
}
//suppression d'une salle
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{   
   $produit = $pdo->prepare("DELETE FROM produit WHERE id_produit = ?");
   $delete = $produit->execute(array($_GET['id']));
   echo '<div class="alert alert-success" role="alert">Suppression du produit '.$_GET['id'].' effectué</div>' ;
   die;
}

//Formulaire ajout ou modification d'une salle
if (isset($_GET['action']) && ($_GET['action']=='ajout' || $_GET['action']=='edit' )) {

  if(isset($_GET['action']) && $_GET['action']=='edit')
  {
    $produits = $pdo->prepare("SELECT * FROM produit,salle WHERE produit.id_produit = ? AND produit.id_salle = salle.id_salle");
    $edit = $produits->execute(array($_GET['id']));
    $produit = $produits->fetch(PDO::FETCH_ASSOC);
  }
    
   ?>
    <h2 class="text-center">Ajout d'un nouveau produit</h2>
    <form action="" method="post" class="py-5 formulaire">
      <input type="hidden" id="id_produit" name="id_produit" value="<?php if (isset($produit['id_produit'])) echo $produit['id_produit'];?>"/>
      <div class="mb-3">
          <select id="salle" name="id_salle" class="form-select">
            <option value ="-" disabled selected>Selectionner une salle</option>
            <?php
                $salles = $pdo->query("SELECT * FROM salle");
                while($salle = $salles->fetch(PDO::FETCH_ASSOC))
                {
                   echo '<option value ="';
                   if (isset($produit['id_produit']) && $produit['id_salle'] == $salle['id_salle'])
                   echo $produit['id_salle'];
                   else echo $salle['id_salle'];
                   echo '"';
                   if (isset($produit['id_produit']) && $produit['id_salle'] == $salle['id_salle']) echo 'selected';echo '>' .$salle['id_salle'].' - '.$salle['pays'].' - '.$salle['ville'].' - '.$salle['adresse'].' - '.$salle['titre'].' - '.$salle['capacite'].' - '.$salle['categorie'].'</option>'; 
                }   
            ?>
         </select>
      </div>
      <div class="mb-3">
         <label for="date_arrivee" class="form-label">Date d'arrivée :</label>
        <input type="text" id="date_arrivee" class="datepicker form-control" name="date_arrivee" min="<?php echo date('Y/m/d'); ?>" placeholder="aaaa/mm/jj" value="<?php if (isset($produit['date_arrivee'])) echo $produit['date_arrivee']; ?>">
      </div>
      <div class="mb-3">
         <label for="date_depart" class="form-label">Date de départ :</label>
         <input type="text" id="date_depart" class="datepicker form-control" name="date_depart" min="<?php if(!empty($_POST['date_arrivee'])) echo $_POST['date_arrivee'] ?>" placeholder="aaaa/mm/jj" value="<?php if (isset($produit['date_depart'])) echo $produit['date_depart']; ?>">
      </div>
      <div class="mb-3">
         <label for="prix" class="form-label">Prix :</label><br>
         <input type="text" id="prix" class="form-control" name="prix" placeholder="prix" value="<?php if (isset($produit['prix'])) echo $produit['prix']; ?>"> €
      </div>
      <div class="mb-3">
          <select id="id_promo" name="id_promo" class="form-select">
            <option value ="0" selected>Selectionner un code promo</option>
            <?php
                $promos = $pdo->query("SELECT * FROM promotion");
                while($promo = $promos->fetch(PDO::FETCH_ASSOC))
                {
                   echo '<option value ="';
                   if (isset($produit['id_promo']) && $produit['id_promo'] == $promo['id_promo'])
                   echo $produit['id_promo'];
                   else echo $promo['id_promo']; echo '"';if (isset($produit['id_promo']) && $produit['id_promo'] == $promo['id_promo']) echo 'selected'; echo '>'.$promo['id_promo'].' - '.$promo['code_promo'].' - '.$promo['reduction'].'</option>'; 
                }   
            ?>
         </select>
      <button type="submit" class="btn btn-primary mt-2"><?php 
    if(isset($_GET['action']) && $_GET['action'] == 'edit') echo 'Modifier';else echo'Ajouter'; ?></button>
    </form>
<?php
}

//Affichage des produits
if (isset($_GET['action']) && $_GET['action']=='affichage') {
  ?>
  
    <div class="row">
          <table class="table table-striped text-center">
            <thead>
                <tr>
                  <th scope="col">id_produit</th>
                  <th scope="col">Date d'arrivée</th>
                  <th scope="col">Date de départ</th>
                  <th scope="col">id_salle</th>
                  <th scope="col">id_promo</th>
                  <th scope="col">Prix</th>
                  <th scope="col">État</th>
                  <th scope="col">Modifier</th>
                  <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
           
<?php
$resultat = $pdo->query('SELECT * FROM  produit');
while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
{
    echo '<tr>';
    echo '<td class="align-middle">'.$datas['id_produit'].'</td>';
    echo '<td class="align-middle">'.$datas['date_arrivee'].'</td>';
    echo '<td class="align-middle">'.$datas['date_depart'].'</td>';
    echo '<td class="align-middle">'.$datas['id_salle'].'</td>';
    echo '<td class="align-middle">'.$datas['id_promo'].'</td>';
    echo '<td class="align-middle">'.$datas['prix'].'</td>';
    echo '<td class="align-middle">'.$datas['etat'].'</td>';
    echo '<td class="align-middle"><a href="?action=edit&id='.$datas['id_produit'].'"><i class="fa fa-edit fa-2x"></i></a></td>';
    echo '<td class="align-middle"><a href="?action=delete&id='.$datas['id_produit'].'"><i class="fa fa-trash fa-2x"></i></a></td>';
    echo '</tr>';
}
?>
            </tbody>
        </table>
    </div>
<?php
}
?>   
  </div>
</div>




<?php include_once('../inc/bas.inc.php');?>




