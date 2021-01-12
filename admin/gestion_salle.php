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
    <h1>Gestion des salles</h1>
    <div class="text-center mb-3">
      <!--LIENS Gestions salles-->
      <button type="button" class="btn btn-primary mb-3"><a href="?action=affichage">Affichage des salles</a></button>
      <button type="button" class="btn btn-primary mb-3"><a href="?action=ajout">Ajout d'une salle</a></button>
<?php

//Ajout ou modification d'une salle via le formulaire
if (!empty($_POST)) 
{
    $photo_bdd = "";
    //cas d'une modification : on récupère l'ancienne photo si elle n'est pas modifiée
    if (isset($_GET['action']) && $_GET['action'] == 'edit') 
    {
      $salles = $pdo->query("SELECT * FROM salle WHERE id_salle = '$_GET[id]'");
      $salle = $salles->fetch(PDO::FETCH_ASSOC);  
      $photo_bdd = $salle['photo'];
    
    }
    if (!empty($_FILES['photo']['name'])) 
    {  
      $produit = $pdo->query('SELECT * FROM salle');
      $produits = $produit->fetch(PDO::FETCH_ASSOC);
      $nom_photo = $produits['id_salle'].'_'.$_FILES['photo']['name'];
              
      $photo_bdd = RACINE_SITE."images/$nom_photo";

      $photo_dossier = $_SERVER['DOCUMENT_ROOT'].RACINE_SITE."images/$nom_photo";
      copy($_FILES['photo']['tmp_name'],$photo_dossier);  
    }
    //ajout
    if($_GET['action']=='ajout')
    {
      $statement = $pdo->prepare("INSERT INTO salle(pays, ville, adresse, cp, titre, description, photo, capacite, categorie)VALUES (?,?,?,?,?,?,?,?,?)");
      $resultat = $statement->execute(array($_POST['pays'],$_POST['ville'],$_POST['adresse'],$_POST['cp'],$_POST['titre'],$_POST['description'],$photo_bdd,$_POST['capacite'],$_POST['categorie']));
      echo '<div class="alert alert-success" role="alert">Ajout d\'une nouvelle salle réussie</div>';
      die;
    }
    //modification 
    if($_GET['action']=='edit')
    {
      $statement = $pdo->prepare("UPDATE salle SET pays = ?, ville = ?, adresse = ?, cp = ?, titre = ?, description = ?, photo = ?, capacite =?, categorie = ? WHERE id_salle = '$_GET[id]'");
      $resultat = $statement->execute(array($_POST['pays'],$_POST['ville'],$_POST['adresse'],$_POST['cp'],$_POST['titre'],$_POST['description'],$photo_bdd,$_POST['capacite'],$_POST['categorie']));
      echo '<div class="alert alert-success " role="alert">Modification de la salle '.$_POST['id_salle'].' effectuée</div>';
      die;
    }
}

//suppression d'une salle
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{   
  //suppression de la photo située dans le dossier images
  $resultat = $pdo->query("SELECT * FROM salle WHERE id_salle = '$_GET[id]'");
  $produit_a_supprimer = $resultat->fetch(PDO::FETCH_ASSOC);

  $chemin_photo_a_supprimer = $produit_a_supprimer['photo'];
  $chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'].$chemin_photo_a_supprimer;
  if(!empty($produit_a_supprimer) && file_exists($chemin_photo_a_supprimer))
  {
      unlink($chemin_photo_a_supprimer);
  }

   $pdo->query("DELETE FROM salle WHERE id_salle = '$_GET[id]'");
   echo '<div class="alert alert-success" role="alert">Suppression de la salle '.$_GET['id'].' effectuée</div>' ;
      die;
}

//Formulaire ajout ou modification d'une salle
if (isset($_GET['action']) && ($_GET['action']=='ajout' || $_GET['action']=='edit' )) {

  if($_GET['action']=='edit')
  {
    $salles = $pdo->query("SELECT * FROM salle WHERE id_salle = '$_GET[id]'");
    $salle = $salles->fetch(PDO::FETCH_ASSOC);
  }
  
   ?>
     
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header mx-auto">
      <h5 class="modal-title text-center"><?php if($_GET['action']=='edit') echo 'Modification d\'une salle';else echo 'Ajout d\'une nouvelle salle';?></h5>
    </div>
    <div class="modal-body">
    <form action="" method="post" enctype="multipart/form-data" class="py-5 formulaire">
      <input type="hidden" id="id_salle" name="id_salle" value="<?php if (isset($salle['id_salle'])) echo $salle['id_salle'];?>"/>
      <div class="mb-3">
          <label for="pays" class="form-label">Pays</label>
          <input type="text" class="form-control" id="pays" name="pays" placeholder="Pays" value="<?php if (isset($salle['pays'])) echo $salle['pays'];?>">
      </div>
      <div class="mb-3">
        <label for="ville" class="form-label">Ville</label>
        <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville" value="<?php if (isset($salle['ville'])) echo $salle['ville'];?>">
      </div>
      <div class="mb-3">
          <label for="adresse" class="form-label">Adresse</label>
          <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse" value="<?php if (isset($salle['adresse'])) echo $salle['adresse'];?>">
      </div>
      <div class="mb-3">
          <label for="cp" class="form-label">Code postal</label>
          <input type="text" class="form-control" id="cp" name="cp" placeholder="Code postal" value="<?php if (isset($salle['cp'])) echo $salle['cp'];?>">
      </div>
      <div class="mb-3">
        <label for="titre" class="form-label">Titre</label>
        <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" value="<?php if (isset($salle['titre'])) echo $salle['titre'];?>">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" class="form-control" name="description" placeholder="Description" rows="10"><?php if (isset($salle['description'])) echo $salle['description'];?></textarea>
      </div>
      <div class="mb-3">
      <?php if (isset($salle['photo'])){?>
        <label for="photo_actuelle" class="form-label">Remplacer la photo</label><br>
        <img src="<?php echo $salle['photo']?>" alt="" height=70><br>
        <input type="hidden" lass="form-control" id="photo_actuelle" name="photo_actuelle" value='<img src="<?php if (isset($salle['photo'])) echo $salle['photo'];?>" height=70>'/>
      <?php } ?>
        <label for="photo" class="form-label">Photo</label>
        <input type="file" class="form-control" id="photo" name="photo">
      </div>
      <div class="mb-3">
        <label for="capacite" class="form-label">Capacité</label>
        <input type="text" class="form-control" id="capacite" name="capacite" placeholder="Capacité" pattern="[0-9]{1,5}" title="chiffres requis : 0-9" value="<?php if (isset($salle['capacite'])) echo $salle['capacite'];?>">
      </div>
      <div class="mb-3">
          <select id="categorie" name="categorie" class="form-select">
            <option value ="-" disabled selected>Catégorie</option>
            <option value ="reunion"<?php if (isset($salle['categorie']) && $salle['categorie'] == 'reunion') echo 'selected';?>>Réunion</option>
            <option value ="bureau"<?php if (isset($salle['categorie']) && $salle['categorie'] == 'bureau') echo 'selected';?>>Bureau</option>
            <option value ="formation"<?php if (isset($salle['categorie']) && $salle['categorie'] == 'formation') echo 'selected';?>>Formation</option>
         </select>
       </div>
      <button type="submit" class="btn btn-primary mt-2"><?php 
    if(isset($_GET['action']) && $_GET['action'] == 'edit') echo 'Modifier';else echo'Ajouter'; ?></button>
    </form>
    </div>
  </div>
</div>
<?php
}
//Affichage des salles
if (isset($_GET['action']) && $_GET['action']=='affichage') {
  ?>
  
    <div class="row">
          <table class="table table-striped text-center">
            <thead>
                <tr>
                  <th scope="col">id_salle</th>
                  <th scope="col">Pays</th>
                  <th scope="col">Ville</th>
                  <th scope="col">Adresse</th>
                  <th scope="col">Code postale</th>
                  <th scope="col">Titre</th>
                  <th scope="col">Description</th>
                  <th scope="col">Photo</th>
                  <th scope="col">Capacité</th>
                  <th scope="col">Catégorie</th>
                  <th scope="col">Modifier</th>
                  <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
           
<?php

$resultat = $pdo->query('SELECT * FROM salle');
while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
{
    echo '<tr>';
    echo '<td class="align-middle">'.$datas['id_salle'].'</td>';
    echo '<td class="align-middle">'.$datas['pays'].'</td>';
    echo '<td class="align-middle">'.$datas['ville'].'</td>';
    echo '<td class="align-middle">'.$datas['adresse'].'</td>';
    echo '<td class="align-middle">'.$datas['cp'].'</td>';
    echo '<td class="align-middle">'.$datas['titre'].'</td>';
    echo '<td class="align-middle">'.$datas['description'].'</td>';
    echo '<td  class="align-middle" style="width:20%;"><img src="'.$datas['photo'].'" alt="'.$datas['description'].'" style="width:100%;"></td>';
    echo '<td class="align-middle">'.$datas['capacite'].'</td>';
    echo '<td class="align-middle">'.$datas['categorie'].'</td>';
    echo '<td class="align-middle"><a href="?action=edit&id='.$datas['id_salle'].'"><i class="fa fa-edit fa-2x"></i></a></td>';
    echo '<td class="align-middle"><a href="?action=delete&id='.$datas['id_salle'].'"><i class="fa fa-trash fa-2x"></i></a></td>';
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




