<div class="row">
<?php
while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
{
    $datas['description'] = stripslashes($datas['description']);
?>
    <div class="col-12 col-lg-6 col-xl-4 my-3">
        <div class="card shadow">
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
                    }
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