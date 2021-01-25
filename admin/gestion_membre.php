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

<div id="gestion_membre" class="conteneur py-5">

    <h1>Gestion des membres</h1>
    <div class="text-center mb-3">
      <!--LIENS Gestions des membres-->
      <button type="button" class="btn btn-primary mb-3"><a href="?action=ajout">Ajouter un compte administrateur</a></button>
      <button type="button" class="btn btn-primary mb-3"><a href="?action=afficher">Afficher la liste des membres</a></button>
    </div> 
<?php
$erreur_pseudo = $erreur_mdp = $erreur_email = $erreur_mdp2= "";
if(!empty($_POST))
{
  $verif_caractere = preg_match("#^[a-zA-Z0-9._-]+$#",$_POST['pseudo']);
  if (!$verif_caractere || strlen($_POST['pseudo']) <3 || strlen($_POST['pseudo']) > 20) 
  {
    $erreur_pseudo = "Le pseudo doit contenir entre 3 et 20 caractères";
  }elseif (strlen($_POST['mdp']) <3 || strlen($_POST['mdp']) > 20) 
  {
    $erreur_mdp='Le mot de passe doit contenir entre 3 et 20 caractères';
  }elseif ($_POST['mdp'] != $_POST['mdp2']) 
  {
    $erreur_mdp2='Les mots de passe sont différents';
  }else 
  {
    $statement = $pdo->prepare("SELECT * FROM membre WHERE pseudo = ?");
    $membre = $statement->execute(array($_POST['pseudo']));
   
    $statement2 = $pdo->prepare("SELECT * FROM membre WHERE email = ?");
    $membre2 = $statement2->execute(array($_POST['email']));
   
    // rowCount() retourne le nombre de ligne qui existe dans une table
    if ($statement->rowCount()>0) 
    {
      $erreur_pseudo = "Ce pseudo existe déjà";
    }elseif($statement2->rowCount()>0)
    { 
      $erreur_email = "Il existe déjà un compte avec cet adresse email<br><a href='/pages/mdpperdu.php'>Mot de passe oublié ?</a>";
    }else
    {
        $mdp = md5($_POST['mdp']);
        $_POST['adresse'] = addslashes($_POST['adresse']);
        $statement = $pdo->prepare("INSERT INTO membre(pseudo, mdp, nom, prenom, email, sexe, ville, cp, adresse,statut)VALUES (?,'$mdp',?,?,?,?,?,?,?,1)");
        $resultat = $statement->execute(array($_POST['pseudo'],$_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['sexe'],$_POST['ville'],$_POST['cp'],$_POST['adresse']));  
        $_POST="";
        $message .= '<div class="alert alert-success text-center" role="alert">Ajout d\'un nouvel administrateur effectué</div>';
    }   
  }
  
}
if(isset($_GET['action']) && $_GET['action'] == 'ajout')
{
?>
<?php echo $message; ?> 
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header mx-auto">
      <h5 class="modal-title text-center">Ajout d'un nouvel administrateur</h5>
    </div>
    <div class="modal-body">
    <?php echo '<div id="inscription_admin_form" class="text-center">'.$contenu.'</div>'; ?>
      <form action="" method="post" class="py-5">
        <div class="mb-3">
            <label for="pseudo" class="form-label">Pseudo*</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" maxlength="20" placeholder="Votre pseudo" pattern="[a-zA-Z0-9-_.]{3,20}" title="caractères acceptés : a-zA-Z0-9-_." value="<?php if (!empty($_POST['pseudo'])) echo $_POST['pseudo']?>" required="required">
            <p class="message_error"><?php echo $erreur_pseudo ?></p>
        </div>
        <div class="mb-3">
          <label for="mdp" class="form-label">Mot de passe*</label>
          <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe" required="required" value="<?php if (!empty($_POST['mdp'])) echo $_POST['mdp']?>">
          <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
          <p class="message_error"><?php echo $erreur_mdp ?></p>
        </div>
        <div class="mb-3">
          <label for="mdp2" class="form-label">Confirmation du mot de passe*</label>
          <input type="password" class="form-control" id="mdp2" name="mdp2" placeholder="Confirmer votre mot de passe" required="required" value="<?php if (!empty($_POST['mdp2'])) echo $_POST['mdp2']?>">
          <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
          <p class="message_error"><?php echo $erreur_mdp2 ?></p>
        </div>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" value="<?php if (!empty($_POST['nom'])) echo $_POST['nom']?>">
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prenom" value="<?php if (!empty($_POST['prenom'])) echo $_POST['prenom']?>">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email*</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="adresse@email.com" value="<?php if (!empty($_POST['email'])) echo $_POST['email']?>" required="required">
          <p class="message_error"><?php echo $erreur_email ?></p>
        </div>
        <div class="mb-3">
          <select class="form-select" name="sexe">
            <option selected>-- Civilité --</option>
            <option value="m" <?php if (isset($_POST['sexe']) && $_POST['sexe'] == "m") echo 'selected'?>>Homme</option>
            <option value="f" <?php if (isset($_POST['sexe']) && $_POST['sexe'] == "f") echo 'selected'?>>Femme</option>
          </select>
        </div>
        <div class="mb-3">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville" placeholder="votre ville" pattern="[a-zA-Z0-9-_.]{2,15}" title="caractères acceptés : a-zA-Z0-9-_." value="<?php if (!empty($_POST['ville'])) echo $_POST['ville']?>">
        </div>
        <div class="mb-3">
            <label for="cp" class="form-label">Code postal</label>
            <input type="text" class="form-control" id="cp" name="cp" placeholder="code postal" pattern="[0-9]{5}" title="5 chiffres requis : 0-9" value="<?php if (!empty($_POST['cp'])) echo $_POST['cp']?>">
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <textarea id="adresse" class="form-control" name="adresse" placeholder="votre adresse" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés :  a-zA-Z0-9-_."><?php if (!empty($_POST['adresse'])) echo $_POST['adresse']?></textarea>
        </div>
        <i>*Champs requis</i><br>
        <button type="submit" class="btn btn-primary mt-5">Ajouter</button>
      </form>
    </div>
  </div>
</div>
    
<?php
} 
//suppression d'un membre
if(isset($_GET['action']) && $_GET['action'] == 'delete' )
{

    $pdelete = $pdo->prepare("DELETE FROM membre WHERE id_membre = ?");
    $delete = $pdelete->execute(array($_GET['id']));
    echo '<div class="alert alert-danger text-center" role="alert">Suppression du membre '.$_GET['id'].' effectué' ;
}

if (isset($_GET['action']) && $_GET['action'] == 'afficher') 
{


//Affichage des membres
  ?>
    <div class="row">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                  <th scope="col">id_membre</th>
                  <th scope="col">Pseudo</th>
                  <th scope="col">Mdp</th>
                  <th scope="col">Nom</th>
                  <th scope="col">Prénom</th>
                  <th scope="col">Email</th>
                  <th scope="col">Sexe</th>
                  <th scope="col">Ville</th>
                  <th scope="col">Cp</th>
                  <th scope="col">Adresse</th>
                  <th scope="col">Statut</th>
                  <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
           
<?php

$resultat = $pdo->query('SELECT * FROM membre');
while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
{
    echo '<tr>'; 
      echo '<td>'.$datas['id_membre'].'</td>';
      echo '<td>'.$datas['pseudo'].'</td>';
      echo '<td>'.$datas['mdp'].'</td>';
      echo '<td>'.$datas['nom'].'</td>';
      echo '<td>'.$datas['prenom'].'</td>';
      echo '<td>'.$datas['email'].'</td>';
      echo '<td>'.$datas['sexe'].'</td>';
      echo '<td>'.$datas['ville'].'</td>';
      echo '<td>'.$datas['cp'].'</td>';
      echo '<td>'.$datas['adresse'].'</td>';
      echo '<td>'.$datas['statut'].'</td>';
      echo '<td><a href="?action=delete&id='.$datas['id_membre'].'" Onclick="'."return(confirm('Êtes-vous sûr de vouloir supprimer ce membre?'))".'"><i class="fa fa-trash fa-2x"></i></a></td>';
    echo '</tr>';
?>
<?php               
                }
} 
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>



<?php include_once('../inc/bas.inc.php');?>




