<?php include_once('inc/init.inc.php');?>
<?php include_once('inc/haut.inc.php');?>
<?php include_once('inc/menu.inc.php');?>

<main>
  <div id="carousel_index" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <ol class="carousel-indicators">
      <li data-bs-target="#carousel_index" data-bs-slide-to="0" class="active"></li>
      <li data-bs-target="#carousel_index" data-bs-slide-to="1"></li>
      <li data-bs-target="#carousel_index" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="/images/reunion.jpg" class="d-block w-100" alt="location salle de reunion">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="text-primary">Salles de réunion</h2>
        </div>
      </div>
      <div class="carousel-item">
        <img src="/images/bureau.jpg" class="d-block w-100" alt="location de bureau">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="text-light">Bureaux</h2>
        </div>
      </div>
      <div class="carousel-item">
        <img src="/images/conf.jpg" class="d-block w-100" alt="location salle de conference">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="text-light">Salles de conférence</h2>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carousel_index" role="button" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel_index" role="button" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </a>
  </div>
</main>
<div class="container-fluid">
  <div class="row mx-auto ">
    <div class="col-12 col-md-6 col-lg-8 p-md-2 p-lg-5">
      <h1>Lokisalle</h1>
      <p class="text-justify">Lokisalle vous propose un service de location de salle à Paris, Marseille et Lyon. Lokisalle propose un large choix de salles au meilleur prix.</p>
      <p class="text-justify">Le monde du travail est en profonde mutation. Fini les salles de réunions et les postes de travail classiques, dématérialisé, il évolue vers davantage de flexibilité, de nomadisme, et adopte un style libéré. De ce constat, Lokisalle a créé la première marketplace collaborative permettant d’héberger les activités professionnelles chez l’habitant.</p>

      <p class="text-justify">Location de salle de réunion, de conférence et de bureaux : la révolution des espaces de travail partagés
      Dans les grandes villes, c’est une révolution : à l’aide des nouvelles technologies, Lokisalle réinvente des espaces uniques et atypiques sous-utilisés, à l’intention des professionnels.</p>

      <p class="text-justify">Avec Lokisalle, vivez l’expérience du travail de demain grâce à cette solution profitant à tous et offrant une diversité d’espace sans pareille : des ateliers d’artistes, des lofts industriels, des boutiques-hôtels, des concepts stores…</p>
      <div class="my-3">
        <img class="my-5" id="image_index" src="/images/meeting-1453895_1280.png" alt="image reunion professionnelle">
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4 my-5 mx-auto bg-light shadow rounded py-5">
        <h2 class="h4 text-center"><strong>Nos 3 dernières offres</strong></h2>
        <div class="row mx-2">
<?php
$pdo->query("SET lc_time_names = 'fr_FR'");
$resultat = $pdo->query('SELECT date_format(date_arrivee,"%d/%m/%Y") AS new_date_arrivee,date_format(date_arrivee,"%kh%i") AS heure_arrivee,date_format(date_depart,"%d/%m/%Y") AS new_date_depart,produit.*,date_format(date_depart,"%kh%i") AS heure_depart,salle.* FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 AND produit.date_arrivee > NOW() ORDER BY produit.id_produit DESC LIMIT 3');
while ($datas = $resultat->fetch(PDO::FETCH_ASSOC))
{
    $datas['description'] = stripslashes($datas['description']);
?>
        <div class="col-12  my-3">
          <div class="card shadow rounded">
            <img src="<?php echo $datas['photo']?>" class="card-img-top" alt="<?php echo $datas['titre']?>">
            <div class="card-body">
                <h2 class="card-title text-center"><?php echo $datas['titre']?></h2>
                <p class="card-text">
                    <span class="ville"><?php echo $datas['ville']?></span><br>
                    <strong>Du : </strong><?php echo $datas['new_date_arrivee'].' à '.$datas['heure_arrivee']?><br>
                    <strong>Au : </strong><?php echo $datas['new_date_depart'].' à '.$datas['heure_depart']?><br>
                    <strong>Catégorie : </strong><?php echo $datas['categorie']?><br>
                    <strong>Capacité : </strong><?php echo $datas['capacite']?> places
                    <span class="price">Prix : <?php echo $datas['prix']?> €*</span><br>
                    <em>*Ce prix est hors taxes</em><br>
                </p>
                <a href="/pages/reservation_details.php?id=<?php echo $datas['id_produit']?>" class="btn btn-primary my-2">Voir plus</a>
                <?php
                if (internauteEstConnecte()) 
                {
                    if(isset($_SESSION['panier'][$datas['id_produit']]))
                    {
                    echo '<a href="#" class="btn btn-primary ml-2" Onclick="'."return(confirm('Ce produit est déjà dans le panier'))".'"><i class="fa fa-shopping-basket"></i></a>';
                    }else
                    {
                        echo '<a href="/pages/panier.php?ajout_panier&id='.$datas['id_produit'].'" class="btn btn-primary ml-2"><i class="fa fa-shopping-basket"></i></a>';
                        ?>
                               
                 <?php   }
                } else {
                    echo '<br><a href="/pages/connexion.php" class="btn btn-primary my-2"><i class="fa fa-shopping-basket mr-2"></i>(Se connecter)</a>';
                }
                ?>
            </div>
        </div>
      </div>  
<?php
}
?>            
      </div>
    </div> 
  </div>
</div>
<?php include_once('inc/bas.inc.php');?>

    