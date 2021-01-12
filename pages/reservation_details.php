<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>

<div id="reservation_details" class="conteneur py-5">
<a href="/pages/reservation.php"><i class="fa fa-arrow-circle-left fa-3x pr-2"></i>Retour réservation</a>

<?php
if (isset($_GET)) {
    $salle = $pdo->query("SELECT * FROM salle, produit WHERE salle.id_salle = produit.id_salle AND produit.id_produit LIKE $_GET[id]");
    $datas = $salle->fetch(PDO::FETCH_ASSOC); ?>
    <h1 class="pb-0 mb-0"><?php echo $datas['titre'] ?></h1>
    <div class="row">
        <div class="col-12 text-center mb-5">
        <?php
        $nb_avis = $pdo->query("SELECT COUNT(*) AS nombre, AVG(note) AS moy FROM avis WHERE id_salle=$datas[id_salle]");
    $avis_number = $nb_avis->fetch(PDO::FETCH_ASSOC);
    if ($avis_number['nombre']==0) {
        echo '<a href="#avis">Soyez le premier à laisser votre commentaire</a><br>';
    } else {
        echo 'Sur '.$avis_number['nombre'].' avis clients<br>';
        echo round($avis_number['moy'], 1).'/10<br>';
    } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-3">
                    <img src="<?php echo $datas['photo']?>" class="card-img-top" alt="'<?php echo $datas['titre']?>">
                </div>
                <div class="col-12 col-md-9">
                Description : <?php echo $datas['description'] ?><br>Capacité :  <?php echo $datas['capacite']?> personnes<br>Catégorie : <?php echo $datas['categorie']?>
                </div>
            </div>
        </div>
    </div>
 <!-- Informations complémentaires -->
    <div class="row mt-5">
        <div class="col-12 col-md-4">
            <div class="col-12">
                <h2 class="h4 text-center">Informations complémentaires</h2>
                Pays : <?php echo $datas['pays'] ?><br>
                Ville : <?php echo $datas['ville'] ?><br>
                Adresse : <?php echo $datas['adresse'] ?><br>
                Cp : <?php echo $datas['cp'] ?><br>
                Date d'arrivée : <?php echo $datas['date_arrivee'] ?> <br>
                Date de départ : <?php echo $datas['date_depart'] ?> <br>
                Prix : <?php echo $datas['prix'] ?> €*<br>
                <em>*Ce prix est hors taxes</em><br>
                Accès : <br>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.7019296386375!2d2.435313316145011!3d48.84482397928618!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e672a3399ef36d%3A0x3000b2a1a3c6d510!2s10%20Avenue%20de%20Paris%2C%2094300%20Vincennes!5e0!3m2!1sfr!2sfr!4v1609708712237!5m2!1sfr!2sfr" width="350" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
<!-- Avis -->
        <div id="avis" class="col-12 col-md-8">
        <h2 class="h4 text-center">Avis</h2>
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php
                   $avis = $pdo->query("SELECT avis.*,membre.pseudo as pseudo FROM avis LEFT JOIN membre ON avis.id_membre = membre.id_membre WHERE avis.id_salle = $datas[id_salle]");
    while ($avis_datas = $avis->fetch(PDO::FETCH_ASSOC)) {
        $date = new DateTime($avis_datas['date']);
        echo '<div class="my-3  carte_avis">';
        echo  'pseudo : '.$avis_datas['pseudo'].'<br>';
        echo 'Le '.date_format($date, 'd-m-Y').' à '.date_format($date, 'h:m').'<br>';
        echo 'Note : '.$avis_datas['note'].'/10<br>';
        echo 'Commentaire : '.$avis_datas['commentaire'].'<br>';
        echo '</div>';
    } ?>
                </div>
<?php
//Ajout d'un avis dans la bbd
if (!empty($_POST['note']) && !empty($_POST['commentaire'])) {
    $id_session = $_SESSION['membre']['id_membre'];
    $statement = $pdo->prepare("INSERT INTO avis(id_membre, id_salle, commentaire, note, date)VALUES ($id_session,?,?,?,NOW())");
    $resultat = $statement->execute(array($datas['id_salle'],$_POST['commentaire'],$_POST['note']));
}
    //Affichage du formulaire de dépot d'un avis ?>
                <div class="col-12 col-md-6">
    <?php
    if (isset($_SESSION['membre'])) {
        $id_session = $_SESSION['membre']['id_membre'];
        $membre = $pdo->query("SELECT * FROM `avis`WHERE id_membre = $id_session");
        $data=$membre->fetch(PDO::FETCH_ASSOC);
        if ($membre->rowCount() != 0 && $data['id_salle']==$datas['id_salle']) {
            echo '<div class="mt-3">';
            echo '<div class="alert alert-success text-center" role="alert">Merci de votre contribution !</div>';
            echo '</div>';
        } else {
            affichage_form_avis();
        }
    } else {
        affichage_form_avis();
    } ?>
                </div>
            </div>
        </div>
    </div>
    xamp
    <?php
    //affichage du bouton ajouter au panier
    if (internauteEstConnecte()) {
        echo '<div class="text-center"><a href="#" class="btn btn-primary my-2"><i class="fa fa-shopping-basket mr-2"></i>Ajouter au panier</a></div>';
    } else {
        echo '<div class="text-center"><a href="#" class="btn btn-primary my-2"><i class="fa fa-shopping-basket mr-2"></i>(Se connecter)</a></div>';
    }
}
?>

</div>
<?php include_once('../inc/bas.inc.php');?>