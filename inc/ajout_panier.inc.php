<?php
if (isset($_GET['ajout_panier'])) 
{
    $resultat = $pdo->query("SELECT date_format(date_arrivee,'%d/%m/%Y à %kh%i') AS new_date_arrivee,date_format(date_depart,'%d/%m/%Y à %kh%i') AS new_date_depart,produit.*,salle.* FROM produit,salle WHERE produit.id_salle=salle.id_salle AND produit.id_produit = '$_GET[id]'");
    $produit = $resultat->fetch(PDO::FETCH_ASSOC);
    ajouterProduitDansPanier($produit['id_produit'], $produit['titre'], $produit['photo'], $produit['ville'], $produit['capacite'], $produit['new_date_arrivee'], $produit['new_date_depart'], $produit['prix']);
}
?>