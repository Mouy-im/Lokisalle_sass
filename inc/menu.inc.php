<header id="haut" class="sticky-top">
<div id="banniere">
  <a href="/index.php" title="accueil"><img class="pt-5" id="logo" src="/inc/logo/logo.png" alt="location salle de reunion lokisalle"></a>
  <p class="slogan">Le meilleur de la location de salle de réunion</p>
  <img  id="banniere_img" src="/images/banniere_2.jpg" alt="location salle de reunion lokisalle">
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <a class="navbar-brand" href="/index.php">
      <img src="/inc/logo/logoseul.png" alt="logo location salle de reunion lokisalle" width="40" >
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/pages/reservation.php">Réservation</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/pages/recherche.php">Recherche</a>
        </li>
       
         <?php
         if (isset($_GET['action']) && $_GET['action'] == 'deconnexion')
         {
           session_destroy();
           header('location:../pages/connexion.php');
         }
         if (internauteEstConnecte()) 
         {
           echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Mon compte';
                      if (internauteEstConnecteEtEstAdmin()){echo ' - Admin';}
                      
                    echo '</a>
                
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                      if (internauteEstConnecteEtEstAdmin())               
                      {
                          echo
                          '<li><a class="dropdown-item" href="/admin/gestion_salle.php">Gestion des salles</a></li>
                          <li><a class="dropdown-item" href="/admin/gestion_produit.php">Gestion des produits</a></li>
                          <li><a class="dropdown-item" href="/admin/gestion_membre.php">Gestion des membres</a></li>
                          <li><a class="dropdown-item" href="/admin/gestion_commande.php">Gestion des commandes</a></li>
                          <li><a class="dropdown-item" href="/admin/gestion_avis.php">Gestion des avis</a></li>
                          <li><a class="dropdown-item" href="/admin/gestion_codepromo.php">Gestion des codes promo</a></li>
                          <li><a class="dropdown-item" href="/admin/statistique.php">Statistiques</a></li>
                          <li><a class="dropdown-item" href="/admin/gestion_newsletter.php">Envoyer la newsletter</a></li>';
                        }
          echo   '<li><a class="dropdown-item" href="/pages/profil.php">Mon profil</a></li>
                                <li><a class="dropdown-item" href="/pages/commande.php">Mes commandes</a></li>
                                <li><a class="dropdown-item" href="/pages/panier.php">Mon panier</a></li>
                                <li><a class="dropdown-item" href="?action=deconnexion">Me deconnecter</a></li>
                    </ul>
                  </li>
                </ul>
                <a href="/pages/panier.php" class="nav-link btn btn-primary mx-2"><i class="fa fa-shopping-basket"></i> '; 
                if (isset($_SESSION['panier'])) 
                {
                  echo '<span class="badge bg-dark">'.count($_SESSION['panier']['id_produit']).'</span></a>';
                }else{
                  echo '<span class="badge bg-dark">0</span>';
                }
                 echo '</a>;';                     
             
       
         } else
         {
          echo   
          '<li class="nav-item">
              <a class="nav-link" href="/pages/connexion.php">Se connecter</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/pages/inscription.php">S\'inscrire</a>
          </li>
          </ul>';
         }
        ?>
        
      
      
    </div>
  </nav>
  

</header>