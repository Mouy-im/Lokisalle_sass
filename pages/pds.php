<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="pds" class="conteneur py-5">
  <h1>Plan du site</h1>
  <ul>
    <li>
      <a href="/index.php">Accueil</a>
      <ul>
        <li><a href="/pages/inscription.php">Inscription</a></li>
        <li><a href="/pages/connexion.php">Connexion</a></li>
        <li><a href="/pages/reservation.php">Réservation</a></li>
        <li><a href="/pages/recherche.php">Recherche</a></li>
        <li><a href="/pages/mdpperdu.php">Mot de passe perdu</a></li>
        <li><a href="/pages/contact.php">Nous contacter</a></li>
      </ul>
      <?php
      if(internauteEstConnecte())
      { ?>
      <ul>Mon compte
        <li><a href="/pages/profil.php">Mon profil</a></li>
        <li><a href="/pages/panier.php">Mon panier</a></li>
        <li><a href="/pages/newsletter.php">Inscription à la newsletter</a></li>
      </ul>
   <?php if (internauteEstConnecteEtEstAdmin())
          {?>
      <ul>Gestion administrateur
        <li><a href="/admin/gestion_avis.php">Gestion des avis</a></li>
        <li><a href="/admin/gestion_codepromo.php">Gestion des codes promo</a></li>
        <li><a href="/admin/gestion_commande.php">Gestion des commandes</a></li>
        <li><a href="/admin/gestion_membre.php">Gestion des membres</a></li>
        <li><a href="/admin/gestion_newsletter.php">Gestion de la newsletter</a></li>
        <li><a href="/admin/gestion_produit.php">Gestion des produit</a></li>
        <li><a href="/admin/gestion_salle.php">Gestion des salles</a></li>
        <li><a href="/admin/statistique.php">Statistiques</a></li>
      </ul>
    <?php } 
      }
      ?>
      <ul>Liens utils
        <li><a href="/pages/cgv.php">Conditions générales de vente</a></li>
        <li><a href="/pages/ml.php">Mentions légales</a></li>
      </ul>
    </li>
  </ul>
</div>

<?php include_once('../inc/bas.inc.php');?>