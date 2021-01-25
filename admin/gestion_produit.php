<?php include_once('../inc/init.inc.php');?>
<?php
if (!internauteEstConnecteEtEstAdmin())
{
  header('location:../pages/connexion.php');
  exit();
}
$error_date_arrivee = $error_date_depart = "";
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
    if (isset($_GET['action']) && $_GET['action']=='ajout') 
    {
      if(empty($_POST['id_salle']))
      {
          $message = 'Veuillez sélectionner une salle';
      }else
      {
          $dates = $pdo->query("SELECT date_format(date_arrivee,'%Y/%m/%d %H:%i') AS new_date_arrivee,date_format(date_depart,'%Y/%m/%d %H:%i') AS new_date_depart,id_salle FROM `produit` WHERE id_salle = '$_POST[id_salle]'");
          while ($res = $dates->fetch(PDO::FETCH_ASSOC)) 
          {  
              if($_POST['date_arrivee'] >= $res['new_date_arrivee'] && $_POST['date_arrivee'] <= $res['new_date_depart']) 
              {
                $error_date_arrivee = 'Salle déjà utilisée à cette date';
                break;
              }elseif($_POST['date_arrivee'] <= $res['new_date_arrivee'] && ($_POST['date_depart'] <= $res['new_date_depart'] && $_POST['date_depart'] >= $res['new_date_arrivee']))
              {
                $error_date_depart = 'Salle déjà utilisée à cette date';
                break;
              }elseif($_POST['date_arrivee'] <= $res['new_date_arrivee'] && $_POST['date_depart'] >= $res['new_date_depart']) 
              {
                $error_date_depart = 'Produit existant avec des dates compris entre les dates d\'arrivée et de départ';
                $error_date_arrivee = 'Produit existant avec des dates compris entre les dates d\'arrivée et de départ';
                break;
              } elseif(($_POST['date_arrivee'] >= $res['new_date_arrivee'] && $_POST['date_arrivee'] <= $res['new_date_depart'] ) && $_POST['date_depart'] >= $res['new_date_depart']) 
              {
                $error_date_arrivee = 'Salle déjà utilisée à cette date';
                break;
              } elseif($_POST['date_depart'] >= $res['new_date_arrivee'] && $_POST['date_depart'] <= $res['new_date_depart'])
              {
                $error_date_depart = 'Salle déjà utilisée à cette date';
                break;
              }else 
              {
                  $new_produit = $pdo->prepare("INSERT INTO produit(date_arrivee, date_depart, id_salle, id_promo, prix, etat)VALUES (?,?,?,?,?,?)");
                  $ajout = $new_produit->execute(array($_POST['date_arrivee'],$_POST['date_depart'],$_POST['id_salle'],$_POST['id_promo'],$_POST['prix'],1));
                  echo '<div class="alert alert-success text-center" role="alert">Ajout d\'un nouveau produit effectué</div>';
                  break;
              }
          }
          if($dates->rowCount() == 0)
          {
            $new_produit = $pdo->prepare("INSERT INTO produit(date_arrivee, date_depart, id_salle, id_promo, prix, etat)VALUES (?,?,?,?,?,?)");
            $ajout = $new_produit->execute(array($_POST['date_arrivee'],$_POST['date_depart'],$_POST['id_salle'],$_POST['id_promo'],$_POST['prix'],1));
            echo '<div class="alert alert-success text-center" role="alert">Ajout d\'un nouveau produit effectué</div>';
          }
      }
    }
    //modification 
    if(isset($_GET['action']) && $_GET['action']=='edit')
    {
      $dates = $pdo->query("SELECT id_produit,date_format(date_arrivee,'%Y/%m/%d %H:%i') AS new_date_arrivee,date_format(date_depart,'%Y/%m/%d %H:%i') AS new_date_depart,id_salle FROM `produit` WHERE id_salle = '$_POST[id_salle]'");
      
          while ($res = $dates->fetch(PDO::FETCH_ASSOC)) 
          {
              if ($res['id_produit'] != $_POST['id_produit']) 
              {
                  if ($_POST['date_arrivee'] >= $res['new_date_arrivee'] && $_POST['date_arrivee'] <= $res['new_date_depart']) 
                  {
                      $error_date_arrivee = 'Salle déjà utilisée à cette date';
                      break;
                  } elseif ($_POST['date_arrivee'] <= $res['new_date_arrivee'] && ($_POST['date_depart'] <= $res['new_date_depart'] && $_POST['date_depart'] >= $res['new_date_arrivee'])) 
                  {
                      $error_date_depart = 'Salle déjà utilisée à cette date';
                      break;
                  } elseif ($_POST['date_arrivee'] <= $res['new_date_arrivee'] && $_POST['date_depart'] >= $res['new_date_depart']) 
                  {
                      $error_date_depart = 'Produit existant avec des dates compris entre les dates d\'arrivée et de départ';
                      $error_date_arrivee = 'Produit existant avec des dates compris entre les dates d\'arrivée et de départ';
                      break;
                  } elseif ($_POST['date_arrivee'] >= $res['new_date_arrivee'] && $_POST['date_arrivee'] <= $res['new_date_depart'] && $_POST['date_depart'] >= $res['new_date_depart']) 
                  {
                      $error_date_arrivee = 'Salle déjà utilisée à cette date';
                      break;
                  } elseif ($_POST['date_depart'] >= $res['new_date_arrivee'] && $_POST['date_depart'] <= $res['new_date_depart']) 
                  {
                      $error_date_depart = 'Salle déjà utilisée à cette date';
                      break;
                  } else 
                  {
                      $edit_produit = $pdo->prepare("UPDATE produit SET date_arrivee = ?, date_depart = ?, id_salle = ?, id_promo = ?, prix = ? WHERE id_produit = ?");
                      $edit = $edit_produit->execute(array($_POST['date_arrivee'],$_POST['date_depart'],$_POST['id_salle'],$_POST['id_promo'],$_POST['prix'],$_GET['id']));
                      echo '<div class="alert alert-success " role="alert">Modification de la salle '.$_POST['id_produit'].' effectuée</div>';
                      break;
                  }
              }
          }
          
          if ($dates->rowCount() == 0) 
          {
            $edit_produit = $pdo->prepare("UPDATE produit SET date_arrivee = ?, date_depart = ?, id_salle = ?, id_promo = ?, prix = ? WHERE id_produit = ?");
            $edit = $edit_produit->execute(array($_POST['date_arrivee'],$_POST['date_depart'],$_POST['id_salle'],$_POST['id_promo'],$_POST['prix'],$_GET['id']));
            echo '<div class="alert alert-success " role="alert">Modification de la salle '.$_POST['id_produit'].' effectuée</div>';
          }
    }
}
//suppression d'une salle
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{   
   $produit = $pdo->prepare("DELETE FROM produit WHERE id_produit = ?");
   $delete = $produit->execute(array($_GET['id']));
   echo '<div class="alert alert-danger text-center" role="alert">Suppression du produit '.$_GET['id'].' effectué</div>' ;
}

//Formulaire ajout ou modification d'une salle
if (isset($_GET['action']) && ($_GET['action']=='ajout' || $_GET['action']=='edit' )) {

  if(isset($_GET['action']) && $_GET['action']=='edit')
  {
    $produits = $pdo->prepare("SELECT date_format(date_arrivee,'%Y/%m/%d %H:%i') AS new_date_arrivee,date_format(date_depart,'%Y/%m/%d %H:%i') AS new_date_depart,produit.*,salle.* FROM produit,salle WHERE produit.id_produit = ? AND produit.id_salle = salle.id_salle");
    $edit = $produits->execute(array($_GET['id']));
    $produit = $produits->fetch(PDO::FETCH_ASSOC);
  }
  ?>
    <h2 class="text-center"><?php if (isset($_GET['action']) && $_GET['action'] == 'edit') echo 'Modification d\'un produit'; else echo 'Ajout d\'un nouveau produit'; ?></h2>

    <form action="" method="post" class="py-5 formulaire">
      <input type="hidden" id="id_produit" name="id_produit" value="<?php if (isset($produit['id_produit'])) echo $produit['id_produit'];?>"/>
      <div class="mb-3">
          <select id="salle" name="id_salle" class="form-select" required>
            <option value ="" disabled selected>Selectionner une salle</option>
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
         <p class="message_error"><?php echo $message ?></p>
      </div>
      <div class="mb-3">
         <label for="date_arrivee" class="form-label">Date d'arrivée :</label>
        <input type="text" id="date_arrivee" class="datetimepicker form-control" name="date_arrivee" placeholder="AAAA/mm/jj - HH:mm" value="<?php if (isset($produit['date_arrivee'])) echo $produit['new_date_arrivee']; ?>">
        <p class="message_error"><?php echo $error_date_arrivee ?></p>
      </div>
      <div class="mb-3">
         <label for="date_depart" class="form-label">Date de départ :</label>
         <input type="text" id="date_depart" class="datetimepicker2 form-control" name="date_depart" placeholder="AAAA/mm/jj - HH:mm" value="<?php if (isset($produit['date_depart'])) echo $produit['new_date_depart']; ?>">
         <p class="message_error"><?php echo $error_date_depart ?></p>
      </div>
      <div class="mb-3">
         <label for="prix" class="form-label">Prix :</label><br>
         <input type="text" id="prix" class="form-control" name="prix" placeholder="prix" value="<?php if (isset($produit['prix'])) echo $produit['prix']; ?>" required>
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
                  <th scope="col">
                    <div class="dropdown">
                      <span class="dropdown-toggle" id="drop_date_arrivee" data-bs-toggle="dropdown" aria-expanded="false">Date d'arrivée
                      </span>
                      <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="drop_date_arrivee">
                        <li><a class="dropdown-item" href="/admin/gestion_produit.php?action=affichage&trie=date_a_asc">Trier par date croissante</a></li>
                        <li><a class="dropdown-item" href="/admin/gestion_produit.php?action=affichage&trie=date_a_desc">Trier par date décroissante</a></li>
                      </ul>
                    </div>
                  </th>
                  <th scope="col">
                    <div class="dropdown">
                      <span class="dropdown-toggle" id="drop_date_depart" data-bs-toggle="dropdown" aria-expanded="false">Date de départ
                      </span>
                      <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="drop_date_depart">
                        <li><a class="dropdown-item" href="/admin/gestion_produit.php?action=affichage&trie=date_d_asc">Trier par date croissante</a></li>
                        <li><a class="dropdown-item" href="/admin/gestion_produit.php?action=affichage&trie=date_d_desc">Trier par date décroissante</a></li>
                      </ul>
                    </div>
                  </th>
                  <th scope="col">
                    <div class="dropdown">
                      <span class="dropdown-toggle" id="drop_salle" data-bs-toggle="dropdown" aria-expanded="false">id_salle
                      </span>
                      <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="drop_salle">
                        <li><a class="dropdown-item" href="/admin/gestion_produit.php?action=affichage&trie=salle_asc">Trier par salle croissante</a></li>
                        <li><a class="dropdown-item" href="/admin/gestion_produit.php?action=affichage&trie=salle_desc">Trier par salle décroissante</a></li>
                      </ul>
                    </div>
                  </th>
                  <th scope="col">id_promo</th>
                  <th scope="col">
                    <div class="dropdown">
                      <span class="dropdown-toggle" id="drop_prix" data-bs-toggle="dropdown" aria-expanded="false">Prix
                      </span>
                      <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="drop_prix">
                        <li><a class="dropdown-item" href="/admin/gestion_produit.php?action=affichage&trie=prix_asc">Trier par prix croissant</a></li>
                        <li><a class="dropdown-item" href="/admin/gestion_produit.php?action=affichage&trie=prix_desc">Trier par prix décroissant</a></li>
                      </ul>
                    </div>
                  </th>
                  <th scope="col">
                    <div class="dropdown">
                      <span class="dropdown-toggle" id="drop_etat" data-bs-toggle="dropdown" aria-expanded="false">État
                      </span>
                      <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="drop_etat">
                        <li><a class="dropdown-item" href="/admin/gestion_produit.php?action=affichage&trie=etat_asc">Trier par état</a></li>
                      </ul>
                    </div>
                  </th>
                  <th scope="col">Modifier</th>
                  <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
           
<?php
if(isset($_GET['trie']) && $_GET['trie'] == 'prix_asc')
{
  $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y %T") AS new_date_arrivee,date_format(date_depart,"%d/%m/%Y %T") AS new_date_depart,produit.* FROM produit ORDER by prix asc');
}elseif (isset($_GET['trie']) && $_GET['trie'] == 'prix_desc')
{
  $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y %T") AS new_date_arrivee,date_format(date_depart,"%d/%m/%Y %T") AS new_date_depart,produit.* FROM produit ORDER by prix desc');
}elseif (isset($_GET['trie']) && $_GET['trie'] == 'date_a_asc')
{
  $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y %T") AS new_date_arrivee,date_format(date_depart,"%d/%m/%Y %T") AS new_date_depart,produit.* FROM produit ORDER by date_arrivee asc');
}elseif (isset($_GET['trie']) && $_GET['trie'] == 'date_a_desc')
{
  $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y %T") AS new_date_arrivee,date_format(date_depart,"%d/%m/%Y %T") AS new_date_depart,produit.* FROM produit ORDER by date_arrivee desc');
}elseif (isset($_GET['trie']) && $_GET['trie'] == 'date_d_asc')
{
  $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y %T") AS new_date_arrivee,date_format(date_depart,"%d/%m/%Y %T") AS new_date_depart,produit.* FROM produit ORDER by date_depart asc');
}elseif (isset($_GET['trie']) && $_GET['trie'] == 'date_d_desc')
{
  $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y %T") AS new_date_arrivee,date_format(date_depart,"%d/%m/%Y %T") AS new_date_depart,produit.* FROM produit ORDER by date_depart desc');
}elseif (isset($_GET['trie']) && $_GET['trie'] == 'salle_asc')
{
  $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y %T") AS new_date_arrivee,date_format(date_depart,"%d/%m/%Y %T") AS new_date_depart,produit.* FROM produit ORDER by id_salle asc');
}elseif (isset($_GET['trie']) && $_GET['trie'] == 'salle_desc')
{
  $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y %T") AS new_date_arrivee,date_format(date_depart,"%d/%m/%Y %T") AS new_date_depart,produit.* FROM produit ORDER by id_salle desc');
}elseif (isset($_GET['trie']) && $_GET['trie'] == 'etat_asc')
{
  $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y %T") AS new_date_arrivee,date_format(date_depart,"%d/%m/%Y %T") AS new_date_depart,produit.* FROM produit ORDER by etat asc');
}else
{
  $resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y %T") AS new_date_arrivee,date_format(date_depart,"%d/%m/%Y %T") AS new_date_depart,produit.* FROM  produit');
}

    while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
    {
        echo '<tr>';
        echo '<td class="align-middle">'.$datas['id_produit'].'</td>';
        echo '<td class="align-middle">'.$datas['new_date_arrivee'].'</td>';
        echo '<td class="align-middle">'.$datas['new_date_depart'].'</td>';
        echo '<td class="align-middle">'.$datas['id_salle'].'</td>';
        echo '<td class="align-middle">'.$datas['id_promo'].'</td>';
        echo '<td class="align-middle">'.$datas['prix'].'</td>';
        echo '<td class="align-middle">'.$datas['etat'].'</td>';
        echo '<td class="align-middle"><a href="?action=edit&id='.$datas['id_produit'].'"><i class="fa fa-edit fa-2x"></i></a></td>';
        echo '<td class="align-middle"><a href="?action=delete&id='.$datas['id_produit'].'" Onclick="'."return(confirm('Êtes-vous sûr de vouloir supprimer ce produit?'))".'"><i class="fa fa-trash fa-2x"></i></a></td>';
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




