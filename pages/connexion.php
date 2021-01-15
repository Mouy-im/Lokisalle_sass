<?php include_once('../inc/init.inc.php');?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion')
  {
      session_destroy();
      header('Location: connexion.php');
  }

if(isset($_COOKIE['pseudo']) && isset($_COOKIE['mdp']))
{
  $resultat = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_COOKIE[pseudo]'");
  $membre = $resultat->fetch(PDO::FETCH_ASSOC);
  $_SESSION['membre']['nom']=$membre['nom'];
  $_SESSION['membre']['prenom']=$membre['prenom'];
  $_SESSION['membre']['sexe']=$membre['sexe'];
  $_SESSION['membre']['cp']=$membre['cp'];
  $_SESSION['membre']['email']=$membre['email'];
  $_SESSION['membre']['pseudo']=$membre['pseudo'];
  $_SESSION['membre']['adresse']=$membre['adresse'];
  $_SESSION['membre']['id_membre']=$membre['id_membre'];
  $_SESSION['membre']['ville']=$membre['ville'];
  $_SESSION['membre']['statut']=$membre['statut'];
  
  header('Location: profil.php');
  exit; 
}

if(!empty($_POST))
{
//on selectionne toutes les lignes(info) dont le pseudo est égal au pseudo posté
//ici la table va récupérer 0 ou 1 ligne
$resultat = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");

    if ($resultat->rowCount() != 0){
        $membre = $resultat->fetch(PDO::FETCH_ASSOC);
        $mdp = md5($_POST['mdp']);
        $_POST['pseudo'] = htmlentities($_POST['pseudo'],ENT_QUOTES);
        $_POST['mdp'] = htmlentities($_POST['mdp'],ENT_QUOTES);
        if($mdp==$membre['mdp'])
        {
            $_SESSION['membre']['nom']=$membre['nom'];
            $_SESSION['membre']['prenom']=$membre['prenom'];
            $_SESSION['membre']['sexe']=$membre['sexe'];
            $_SESSION['membre']['cp']=$membre['cp'];
            $_SESSION['membre']['email']=$membre['email'];
            $_SESSION['membre']['pseudo']=$membre['pseudo'];
            $_SESSION['membre']['adresse']=$membre['adresse'];
            $_SESSION['membre']['id_membre']=$membre['id_membre'];
            $_SESSION['membre']['ville']=$membre['ville'];
            $_SESSION['membre']['statut']=$membre['statut'];
            if(!empty($_POST['check_remind'])){
              $pseudo = $_POST['pseudo'];
              $mdp = $_POST['mdp'];
              $dateExpiration = time() + 1 * 60 * 60 * 24 * 365;
              setcookie('pseudo',$pseudo,$dateExpiration);
              setcookie('mdp',$mdp,$dateExpiration);
            }
            header('Location: profil.php');
            exit; 
        }else {
            $contenu.='<div class="alert alert-danger" role="alert">Mot de passe incorrect</div>';
        }
    }else{
        $contenu.='<div class="alert alert-danger" role="alert">Pseudo incorrecte</div>';
    }

}
?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<div id="connexion_form" class="formulaire py-5">
  <h1>Connexion</h1>

  <ul class="nav nav-tabs" id="cf" role="tablist">
    <li class="nav-item" role="connexion_form">
      <a class="nav-link active" id="membre-tab" data-bs-toggle="tab" href="#membre" role="tab" aria-controls="membre" aria-selected="true">Déjà membre ?</a>
    </li>
    <li class="nav-item" role="connexion_form">
      <a class="nav-link" id="membre-tab" data-bs-toggle="tab" href="#nonmembre" role="tab" aria-controls="nonmembre" aria-selected="false">Pas encore membre ?</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="membre" role="tabpanel" aria-labelledby="membre-tab">
   
      <form action="" method="post" class="py-5">
         <?php echo $contenu; ?>
        <div class="mb-3">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Votre pseudo">
        </div>
        <div class="mb-3">
          <label for="mdp" class="form-label">Mot de passe</label>
          <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="check_remind" name="check_remind">
          <label class="form-check-label" for="check_remind">Se souvenir de moi</label>
        </div>
        <button type="submit" class="btn btn-primary mr-5">Se connecter</button>
        <a href="/pages/mdpperdu.php">Mot de passe oublié</a>
      </form>
    </div>
    <div class="tab-pane fade text-center" id="nonmembre" role="tabpanel" aria-labelledby="membre-tab"><a href="/pages/inscription.php">Inscrivez-vous</div>

  </div>
</div>

<?php include_once('../inc/bas.inc.php');?>