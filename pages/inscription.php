<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="inscription_form" class="py-5">
  <h1>Inscription</h1>
  <?php 

if($_POST)
{
  $verif_caractere = preg_match("#^[a-zA-Z0-9._-]+$#",$_POST['pseudo']);
  if (!$verif_caractere || strlen($_POST['pseudo']) <=3 || strlen($_POST['pseudo']) > 20) 
  {
    $contenu.='Le pseudo doit contenir entre 3 et 20 caractères';

  }elseif (strlen($_POST['mdp']) <=3 || strlen($_POST['mdp']) > 20) 
  {
    $contenu.='Le mot de passe doit contenir entre 3 et 20 caractères';
  }else 
  {
    $membre = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");
    $membre2 = $pdo->query("SELECT * FROM membre WHERE email = '$_POST[email]'");
    // rowCount() retourne le nombre de ligne qui existe dans une table
    if ($membre->rowCount()>0) 
    {
        $contenu.="Ce pseudo existe déjà";
    }elseif($membre2->rowCount()>0)
    { 
        $contenu.="Il existe déjà un compte avec cet adresse email<br><a href='/pages/mdpperdu.php'>Mot de passe oublié ?</a>";
    }else
    {
        $mdp = md5($_POST['mdp']);
        $_POST['adresse'] = addslashes($_POST['adresse']);
        $statement = $pdo->prepare("INSERT INTO membre(pseudo, mdp, nom, prenom, email, sexe, ville, cp, adresse,statut)VALUES (?,'$mdp',?,?,?,?,?,?,?,0)");
        $resultat = $statement->execute(array($_POST['pseudo'],$_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['sexe'],$_POST['ville'],$_POST['cp'],$_POST['adresse']));
        $res = $pdo->query("SELECT id_membre FROM membre WHERE pseudo = '$_POST[pseudo]'");
        $data=$res->fetch(PDO::FETCH_ASSOC);
        $_SESSION['membre']['nom']=$_POST['nom'];
        $_SESSION['membre']['prenom']=$_POST['prenom'];
        $_SESSION['membre']['sexe']=$_POST['sexe'];
        $_SESSION['membre']['cp']=$_POST['cp'];
        $_SESSION['membre']['email']=$_POST['email'];
        $_SESSION['membre']['ville']=$_POST['ville'];
        $_SESSION['membre']['id_membre']=$data['id_membre'];
        $_SESSION['membre']['pseudo']=$_POST['pseudo'];
        $_SESSION['membre']['adresse']=$_POST['adresse'];
        $_SESSION['membre']['statut']=0;
        echo'<div class="text-center">';
        echo '<h2>Bienvenue '.$_POST['prenom'].'</h2>'
        .'Votre compte a été créé avec succès !<br>'; 
        echo '<a href="../index.php">Retour à la page d\'accueil</a>';
        echo'</div>';
        die();
    }   
  }
}

?>
  <?php echo '<div class="text-center">'.$contenu.'</div>'; ?>
  <form action="" method="post" class="py-5">
    <div class="mb-3">
        <label for="pseudo" class="form-label">Pseudo*</label>
        <input type="text" class="form-control" id="pseudo" name="pseudo" maxlength="20" placeholder="Votre pseudo" pattern="[a-zA-Z0-9-_.]{2,20}" title="caractères acceptés : a-zA-Z0-9-_." required="required">
    </div>
    <div class="mb-3">
      <label for="mdp" class="form-label">Mot de passe*</label>
      <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe" required="required">
    </div>
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom">
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prenom">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email*</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="adresse@email.com" required="required">
    </div>
    <div class="mb-3">
      <select class="form-select" name="sexe">
        <option selected>-- Civilité --</option>
        <option value="m">Homme</option>
        <option value="f">Femme</option>
      </select>
    </div>
    <div class="mb-3">
        <label for="ville" class="form-label">Ville</label>
        <input type="text" class="form-control" id="ville" name="ville" placeholder="votre ville" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés : a-zA-Z0-9-_.">
    </div>
    <div class="mb-3">
        <label for="cp" class="form-label">Code postal</label>
        <input type="text" class="form-control" id="cp" name="cp" placeholder="code postal" pattern="[0-9]{5}" title="5 chiffres requis : 0-9">
    </div>
    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse</label>
        <textarea id="adresse" class="form-control" name="adresse" placeholder="votre adresse" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés :  a-zA-Z0-9-_."></textarea>
    </div>
    <i>*Champs requis</i><br>
  <button type="submit" class="btn btn-primary mt-2">S'inscrire</button>
  </form>
</div>
   


<?php include_once('../inc/bas.inc.php');?>