<?php include_once('inc/init.inc.php');?>
<?php include_once('inc/haut.inc.php');?>
<?php include_once('inc/menu.inc.php');?>
<div>
  <div id="carouselExampleCaptions" class="carousel carousel-fade slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
      <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
      <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
      <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="/images/salle1.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>First slide label</h5>
          <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="/images/salle2.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Second slide label</h5>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="/images/salle3.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Third slide label</h5>
          <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </a>
  </div>
</div>
<div class="container-fluid">
  <div class="row mx-auto">
    <div class="col-12 col-md-8">
      <h1>Lokisalle</h1>
      <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean orci nisl, porta convallis commodo at, hendrerit eget nisl. Proin augue tortor, dapibus ornare tristique vitae, porttitor vitae erat. Phasellus tempor, justo eu interdum maximus,
      augue felis faucibus quam, viverra consectetur nulla sapien nec est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Phasellus est tortor, tempus quis augue a, facilisis sagittis sem. Vivamus condimentum
      finibus lacus nec cursus. Etiam quis pretium velit. Nullam interdum, mi sollicitudin interdum ultrices, leo odio semper sapien, in aliquet elit urna at massa. Proin quam sapien, lacinia at nibh eget, vestibulum cursus enim. Quisque imperdiet
      at risus vitae auctor. Etiam suscipit erat tortor, convallis luctus tellus cursus et. Nunc ornare condimentum bibendum. In elit mi, semper eu fringilla nec, suscipit nec libero. Cras quis scelerisque magna. Fusce porttitor, purus et aliquet
      porta, quam mauris dictum purus, nec mollis tortor metus ut erat. Morbi sit amet purus malesuada libero consectetur aliquet sit amet sed dui. Donec malesuada eros vitae augue pretium rhoncus.</p>
      <p class="text-justify">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda tempora amet nisi porro aliquid pariatur unde fugiat sequi tempore corrupti odit officiis doloribus nostrum architecto laudantium deleniti neque quia, quam provident rerum consectetur alias. Laborum unde blanditiis ab dolorum maxime, praesentium optio amet vitae nostrum, obcaecati non cumque facere et aliquam, suscipit perferendis voluptate ratione perspiciatis! Suscipit cupiditate reiciendis perspiciatis possimus blanditiis, porro distinctio assumenda. Ea est asperiores nostrum adipisci aut, sint accusantium! Recusandae, non nobis voluptates in voluptatum nemo cumque nihil ab porro odit at repellendus quidem quas cum ipsum alias distinctio impedit pariatur itaque assumenda laudantium similique voluptatibus?</p>
      <p class="text-justify">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda tempora amet nisi porro aliquid pariatur unde fugiat sequi tempore corrupti odit officiis doloribus nostrum architecto laudantium deleniti neque quia, quam provident rerum consectetur alias. Laborum unde blanditiis ab dolorum maxime, praesentium optio amet vitae nostrum, obcaecati non cumque facere et aliquam, suscipit perferendis voluptate ratione perspiciatis! Suscipit cupiditate reiciendis perspiciatis possimus blanditiis, porro distinctio assumenda. Ea est asperiores nostrum adipisci aut, sint accusantium! Recusandae, non nobis voluptates in voluptatum nemo cumque nihil ab porro odit at repellendus quidem quas cum ipsum alias distinctio impedit pariatur itaque assumenda laudantium similique voluptatibus?</p>
    </div>
    <div class="col-12 col-md-3 my-5 mx-auto">
        <h2 class="h4 text-center">Nos 3 dernières offres</h2>
        <div class="row mx-2">
<?php

$resultat = $pdo->query('SELECT * FROM produit,salle WHERE produit.id_salle = salle.id_salle AND produit.etat = 1 ORDER BY salle.id_salle DESC LIMIT 3');
while ($datas = $resultat->fetch(PDO::FETCH_ASSOC))
{
 
   echo '<div class="col-12 carte mx-auto my-2">' ;
   echo '<img src="'.$datas['photo'].'" class="card-img-top" alt="'.$datas['description'].'">';
   echo '<div class="card-body">';
   echo '<h2 class="card-title">'.$datas['titre'].'</h2>';
   echo '<p class="card-text">'.$datas['ville'].'<br>Capacité : '.$datas['capacite'].' places<br>'.$datas['description'].'</p>';
   echo '<a href="/pages/reservation_details.php?id='.$datas['id_salle'].'" class="btn btn-primary my-2">Voir plus</a>';
   if (internauteEstConnecte()) 
   {
      echo '<a href="/pages/connexion.php" class="btn btn-primary mx-2"><i class="fa fa-shopping-basket"></i></a>';
   }else
   {
      echo '<br><a href="/pages/connexion.php" class="btn btn-primary my-2"><i class="fa fa-shopping-basket mr-2"></i>(Se connecter)</a>';
   }
  
   echo '</div>';
   echo '</div>';

}
?>
               
      </div>
    </div> 
  </div>
</div>

    <?php include_once('inc/bas.inc.php');?>