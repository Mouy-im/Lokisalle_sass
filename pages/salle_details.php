<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<div id="salle_details" class="conteneur py-5">
<!--    <a href="/pages/recherche.php"><i class="fa fa-arrow-circle-left fa-3x pr-2"></i>Retour recherche</a>-->
<?php
if (isset($_GET)) {
    $salle = $pdo->query("SELECT * FROM salle WHERE id_salle = $_GET[id]");
    $datas = $salle->fetch(PDO::FETCH_ASSOC); 
    $datas['description'] = stripslashes($datas['description']);
    $datas['adresse'] = stripslashes($datas['adresse']);
    ?>
    <h1 class="pb-0 mb-0"><?php echo $datas['titre'] ?></h1>
    <div class="row">
        <div class="col-12 text-center mb-5">
        <?php
    $nb_avis = $pdo->query("SELECT COUNT(*) AS nombre, AVG(note) AS moy FROM avis WHERE id_salle=$datas[id_salle]");
    $avis_number = $nb_avis->fetch(PDO::FETCH_ASSOC);
    if ($avis_number['nombre']==0) 
    {
        $message = '<a href="#avis">Soyez le premier à laisser votre commentaire</a><br>';
    } else 
    {
        $message = 'Sur '.$avis_number['nombre'].' avis client';
        if($avis_number['nombre']>1) $message .='s';
        $message .= '<br>'.round($avis_number['moy'], 1).'/10<br>';
    } ?>
       <?php echo $message ?>
        </div>
    </div>
    <div class="row bg-light shadow rounded p-3 p-md-5">
        <div class="col-10 mx-auto">
            <div class="row">
                <div class="col-12 col-md-5">
                    <img id="img_reservation_detail" src="<?php echo $datas['photo']?>" class="card-img-top" alt="'<?php echo $datas['titre']?>">
                </div>
                <div class="col-12 col-md-7 my-auto">
                    <p>
                        <strong>Description : </strong><?php echo $datas['description'] ?><br>
                        <strong>Capacité :  </strong><?php echo $datas['capacite']?> personnes
                        <span class="pl-3"><strong>Catégorie : </strong><?php echo $datas['categorie']?></span><br>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-7 my-auto">
                    <p class="mt-5">
                        <strong>Adresse : </strong><?php echo $datas['adresse'] ?><br>
                        <strong>Ville : </strong><?php echo $datas['ville'] ?><br>
                        <strong>Code postal : </strong><?php echo $datas['cp'] ?><br>
                        <strong>Pays : </strong><?php echo $datas['pays'] ?><br>
                    </p>
                </div>
                <div class="col-12 col-md-5">
                <strong>Accès : </strong><br>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.7019296386375!2d2.435313316145011!3d48.84482397928618!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e672a3399ef36d%3A0x3000b2a1a3c6d510!2s10%20Avenue%20de%20Paris%2C%2094300%20Vincennes!5e0!3m2!1sfr!2sfr!4v1609708712237!5m2!1sfr!2sfr" width="350" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!-- Disponibilités -->
    <div class="row mt-5">
        <div class="col-12 col-md-6">
            <div class="col-12 mx-auto bg-light shadow rounded p-2 p-md-3 mt-5">
                <h2 class="h4 text-center"><strong>Prochaines disponibilités</strong></h2>
               
               <?php 
               $produit = $pdo->query("SELECT date_format(date_arrivee,'%d/%m/%Y à %kh%i') AS new_date_arrivee, date_format(date_depart,'%d/%m/%Y à %kh%i') AS new_date_depart,produit.*,salle.* FROM salle, produit WHERE salle.id_salle = produit.id_salle AND produit.id_salle = '$_GET[id]' AND produit.etat = 1 AND produit.date_arrivee >= NOW() ORDER BY produit.date_arrivee ASC");
               if($produit->rowcount() != 0)
               {
                    while ($produits = $produit->fetch(PDO::FETCH_ASSOC)) 
                    { ?>
                        <div class="bg-white rounded p-2 shadow mt-3 card">
                            <p class="card-text mb-0 pt-3">
                                <strong>Date d'arrivée : </strong><?php echo $produits['new_date_arrivee']?> <br>
                                <strong>Date de départ : </strong><?php echo $produits['new_date_depart']?> <br>
                                <span class="price2">Prix : <?php echo $produits['prix']?> €*</span>
                            
                            <?php
                            //affichage du bouton ajouter au panier
                            if (internauteEstConnecte()) 
                            {
                                if(isset($_SESSION['panier'][$produits['id_produit']]))
                                {
                                    echo '<a href="#" class="btn btn-primary pull-right mt-4" Onclick="'."return(confirm('Ce produit est déjà dans le panier'))".'"><i class="fa fa-shopping-basket"></i></a><br>';
                                }else
                                {
                                    echo '<a href="/pages/panier.php?ajout_panier&id='.$produits['id_produit'].'" class="btn btn-primary pull-right mt-4"><i class="fa fa-shopping-basket"></i></a>';
                                }
                            } else 
                            {
                                echo '<a href="#" class="btn btn-primary pull-right mt-4"><i class="fa fa-shopping-basket mr-2"></i>(Se connecter)</a>';
                            }?>
                            
                            </p>  
                            <span class="text-left"><em>*Ce prix est hors taxes</em></span>
                        </div> 
       <?php        }
               }else
               {
                   echo '<div class="text-center bg-white rounded p-2 shadow mt-3">';
                   echo 'Aucunes disponibilités pour cette salle';
                   echo '</div>';
               }
               
                ?>
                
<?php 
}
?> 
            
            </div>
        </div>

<!-- Avis -->
        <!-- Affichage des avis-->
        <div id="avis" class="col-12 col-md-6">
            <div class="col-12 mx-auto bg-light shadow rounded p-2 p-md-4 my-5">
                <h2 class="h4 text-center"><strong>Avis</strong></h2>
                    <?php
                    $pdo->query("SET lc_time_names = 'fr_FR'");
                    $avis = $pdo->query("SELECT date_format(date,'%d/%m/%Y') AS new_date,date_format(date,'%H:%i') AS new_time, avis.*,membre.pseudo as pseudo FROM avis LEFT JOIN membre ON avis.id_membre = membre.id_membre WHERE avis.id_salle = $datas[id_salle]");
                    while ($avis_datas = $avis->fetch(PDO::FETCH_ASSOC)) {
                        $avis_datas['commentaire'] = stripslashes($avis_datas['commentaire']);
                        echo '<div class="my-3  carte_avis">';
                        echo '<strong>Pseudo : </strong>'.$avis_datas['pseudo'].'<br>';
                        echo 'Le '.$avis_datas['new_date'].' à '.$avis_datas['new_time'].'<br>';
                        echo '<strong>Note : </strong>'.$avis_datas['note'].'/10<br>';
                        echo '<strong>Commentaire : </strong>'.$avis_datas['commentaire'].'<br>';
                        echo '</div>';
                    }?>
    <?php
    //Ajout d'un avis dans la bbd
    if (!empty($_POST['note']) && !empty($_POST['commentaire'])) {
        $id_session = $_SESSION['membre']['id_membre'];
        $_POST['commentaire'] = addslashes($_POST['commentaire']);
       
        $statement = $pdo->prepare("INSERT INTO avis(id_membre, id_salle, commentaire, note, date)VALUES ($id_session,?,?,?,NOW())");
        $resultat = $statement->execute(array($datas['id_salle'],$_POST['commentaire'],$_POST['note']));

    }
    //Affichage du formulaire de dépot d'un avis si membre
    if (internauteEstConnecte()) {
        $id_session = $_SESSION['membre']['id_membre'];
        $membre = $pdo->query("SELECT * FROM `avis` WHERE id_membre = $id_session AND id_salle = $datas[id_salle]");
        if ($membre->rowCount() != 0) {
            $data=$membre->fetch(PDO::FETCH_ASSOC);
            
            echo '<div class="mt-3">';
            echo '<div class="alert alert-success text-center" role="alert">Merci de votre contribution !</div>';
            echo '</div>';
        } else {
            affichage_form_avis();
        }
    }else {
        affichage_form_avis();
    }
    ?>
                  
            </div>
        </div>
    </div>
<!--Autres suggestions-->

<div class="row mt-3">
    <div class="col-12">
        <h2 class="h4 text-center"><strong><?php 
if (!empty($_COOKIE['ville']) || !empty($_COOKIE['categorie']) || !empty($_COOKIE['date_arrivee']) || !empty($_COOKIE['date_depart']) || !empty($_COOKIE['prix_min']) || !empty($_COOKIE['prix_max']) || !empty($_COOKIE['capacite'])) 
 echo 'Produits similaires'; else echo 'Autres suggestions'; ?></strong></h2>
    </div>
</div>
<?php
    $query ="SELECT date_format(date_arrivee,'%d/%m/%Y') AS new_date_arrivee,date_format(date_arrivee,'%kh%i') AS heure_arrivee,date_format(date_depart,'%d/%m/%Y') AS new_date_depart,produit.*,date_format(date_depart,'%kh%i') AS heure_depart,salle.* FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1  AND produit.date_arrivee > NOW() "; 
    if(!empty($_COOKIE['ville'])){
        $query .= " AND salle.ville = '$_COOKIE[ville]'";
    }
    if(!empty($_COOKIE['categorie'])){
        $query .= " AND salle.categorie ='$_COOKIE[categorie]'";
    }
    if(!empty($_COOKIE['capacite'])){
        $query .= " AND salle.capacite >='$_COOKIE[capacite]'";
    }
    if(!empty($_COOKIE['date_arrivee'])){
        $query .= " AND produit.date_arrivee >= '$_COOKIE[date_arrivee]'";
    }
    if(!empty($_COOKIE['date_depart'])){
        $query .= " AND produit.date_depart <= '$_COOKIE[date_depart]'";
    }
    if(!empty($_COOKIE['prix_min'])){
        $query .= " AND produit.prix >= '$_COOKIE[prix_min]'";
    }
    if(!empty($_COOKIE['prix_max'])){
        $query .= " AND produit.prix <= '$_COOKIE[prix_max]'";
    }
    $query .= " LIMIT 3";
    $resultat = $pdo->query($query);
    include('../inc/affichage_suggestion.inc.php');

?>
</div>
<?php include_once('../inc/bas.inc.php');?>