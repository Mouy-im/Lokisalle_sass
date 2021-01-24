<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="reservation" class="conteneur py-5">
  <h1>Toutes nos salles</h1>
    <div class="row">
      <div class="col-12">
      <?php
        $villes = $pdo->query("SELECT DISTINCT ville FROM salle");
        $categories = $pdo->query("SELECT DISTINCT categorie FROM salle");?>
        <form method="post" action="">
          <div class="row bg-light shadow text-center rounded pt-5">
            <!--Filtre par ville-->
            <div class="col-12 col-md-3">
              <select class="form-select" name="ville">
                <option value="" hidden>Choisir une ville</option> 
                <option value="">Toutes les villes</option> 
                <?php
                while ($ville = $villes->fetch(PDO::FETCH_ASSOC)) 
                {
                    echo'<option value="';if (isset($_POST['ville']) && $_POST['ville'] == $ville['ville']){echo $_POST['ville'].'" selected';}else{echo $ville['ville'].'"';} echo '>';;if (isset($_POST['ville']) && $_POST['ville'] == $ville['ville']){echo $_POST['ville'];}else{echo $ville['ville'];} echo '</option>'; 
                }
                ?>
              </select><br>
            </div>
            <!--Filtre par categorie-->
            <div class="col-12 col-md-3">
                <select class="form-select" name="categorie">
                  <option value="" hidden>Choisir une catégorie</option>
                  <option value="">Toutes les catégories</option> 
                  <?php
                  while ($cat = $categories->fetch(PDO::FETCH_ASSOC)) 
                  {
                      echo'<option value="';if (isset($_POST['categorie']) && $_POST['categorie'] == $cat['categorie']){echo $_POST['categorie'].'" selected';}else{echo $cat['categorie'].'"';} echo '>';if (isset($_POST['categorie']) && $_POST['categorie'] == $cat['categorie']){echo $_POST['categorie'];}else{echo $cat['categorie'];} echo '</option>'; 
                  }
                  ?>
              </select><br>
            </div>
            <!--Filtre par capacite-->
            <div class="col-12 col-md-5 text-center">
                <label for="capacite" class="form-label">Capacité :</label>
                <input type="number" min="0" id="capacite" name="capacite"class="col-4" placeholder="Ex : 20" value="<?php if (isset($_POST['capacite'])) echo $_POST['capacite'] ?>"> personnes<br>
            </div>
            <!--Validation du formulaire-->
            <div class="col-6 text-center pb-5">
            <button type='submit' class='btn btn-primary mt-2'>Je recherche</button>
            </div>
          </div><!--fin du row du form-->
          
        </form>
      </div>
    </div>
    <div class="row">
  <?php
  
   
   $query ="SELECT * FROM salle WHERE 1=1"; 
   if(!empty($_POST['ville'])){
       $query .= " AND salle.ville = '$_POST[ville]'";
   }
   if(!empty($_POST['categorie'])){
       $query .= " AND salle.categorie ='$_POST[categorie]'";
   }
   if(!empty($_POST['capacite'])){
       $query .= " AND salle.capacite >='$_POST[capacite]'";
   }
   $resultat = $pdo->query($query);
   if(!empty($_POST)){ include('../inc/affichage_nb_ligne.inc.php');}
   while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) {
       $datas['description'] = stripslashes($datas['description']); ?>
       <div class="col-12 col-lg-6 col-xl-4 my-3">
          <div class="card shadow">
              <img src="<?php echo $datas['photo']?>" class="card-img-top" alt="<?php echo $datas['titre']?>">
              <div class="card-body">
                <h2 class="card-title text-center"><?php echo $datas['titre']?></h2>
                <p class="card-text text-center">
                  <span class="ville"><?php echo $datas['ville']?></span><br>
                  <strong>Catégorie : </strong><?php echo $datas['categorie']?><br>
                  <strong>Capacité : </strong><?php echo $datas['capacite']?> places
                </p>
                <div class="text-center">
                  <a href="/pages/salle_details.php?id=<?php echo $datas['id_salle']?>" class="btn btn-primary my-2 col-8">Voir les disponibilités</a>
                </div>
              </div>
            </div>
          </div>
<?php
   } ?>
   </div>
</div>
<?php include_once('../inc/bas.inc.php');?>