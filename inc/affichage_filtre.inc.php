<?php

echo 'Nombres de résultats : ' .$resultat->rowCount();
echo '</div>';
echo '<div class="row">';
        while ($datas = $resultat->fetch(PDO::FETCH_ASSOC)) {
     
            echo '<div class="col-12 col-lg-6 col-xl-4 my-3">';
            echo '<div class="card">';
            echo '<img src="'.$datas['photo'].'" class="card-img-top" alt="'.$datas['description'].'">';
            echo '<div class="card-body">';
            echo '<h2 class="card-title">'.$datas['titre'].'</h2>';
            echo '<p class="card-text">'.$datas['ville'].'<br>Capacité : '.$datas['capacite'].' places<br>'.$datas['description'].'</p>';
            echo 'Date d\'arrivée :'.$datas['date_arrivee'].' <br>';
            echo 'Date de départ :'.$datas['date_depart'].' <br>';
            echo 'Prix : '.$datas['prix'].' €*<br>';
            echo '<em>*Ce prix est hors taxes</em><br>';
            echo '<a href="/pages/reservation_details.php?id='.$datas['id_salle'].'" class="btn btn-primary my-2">Voir plus</a>';
            if (internauteEstConnecte()) {
                echo '<a href="/pages/connexion.php" class="btn btn-primary mx-2"><i class="fa fa-shopping-basket"></i></a>';
            } else {
                echo '<br><a href="/pages/connexion.php" class="btn btn-primary my-2"><i class="fa fa-shopping-basket mr-2"></i>(Se connecter)</a>';
            }
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>