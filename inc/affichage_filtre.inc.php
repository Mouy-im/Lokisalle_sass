<div class="row mt-3">
    <div class="col-12 col-md-8">
        <h3 class="h4 text-center">Résultat(s) de votre recherche : <?php echo $resultat->rowCount();?></h3>
    </div>
</div>
<div class="row">
<?php
while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) 
{
?>
    <div class="col-12 col-lg-6 col-xl-4 my-3 card">
        <img src="<?php echo $datas['photo']?>" class="card-img-top" alt="<?php echo $datas['description']?>">
        <div class="card-body">
            <h2 class="card-title"><?php echo $datas['titre']?></h2>
            <p class="card-text"><?php echo $datas['ville']?><br>Capacité : <?php echo $datas['capacite']?> places<br><?php echo $datas['description']?></p>
            Date d'arrivée :<?php echo $datas['date_arrivee']?> <br>
            Date de départ :<?php echo $datas['date_depart']?> <br>
            Prix : <?php echo $datas['prix']?> €*<br>
            <em>*Ce prix est hors taxes</em><br>
            <a href="/pages/reservation_details.php?id=<?php echo $datas['id_salle']?>" class="btn btn-primary my-2">Voir plus</a>
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

<?php 
}
?>
</div> 