<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="mdpperdu_form" class="py-5">
  <h1>Mot de passe perdu</h1>
 
      <form action="" method="post" class="py-5">
          <div class="mb-3">
          <label for="email" class="form-label">Afin de pouvoir réinitialiser votre mot de passe, vous devez nous fournir votre adresse email :</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="adresse@email.com">
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
      </form>
   
</div>

<?php include_once('../inc/bas.inc.php');?>