<?php

function debug($variable, $mode =1)
{
    if ($mode == 1)
    {
        echo '<pre>';
        print_r($variable);
        echo '</pre>';
    }
    if ($mode == 2)
    {
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
    }
}

function internauteEstConnecte()
{
    if (isset($_SESSION['membre']))
    {
        return true;
    } else
    {
        return false;
    }
}

function internauteEstConnecteEtEstAdmin()
{
    if (internauteEstConnecte() && $_SESSION['membre']['statut'] == 1)
    {
        return true;
    } else
    {
        return false;
    }
}

//cette fonction permet de créer un panier qui n'existe pas
function creationDuPanier()
{
    if (!isset($_SESSION['panier'])) 
    {
        $_SESSION['panier'] = array();
    }
}

function ajouterProduitDansPanier($titre, $id_produit, $quantite, $prix, $photo)
{
    creationDuPanier();
    //quand on a déjà le produit dans le panier
    if (isset($_SESSION['panier'][$id_produit])) {
        $new_qte = intval($_SESSION['panier'][$id_produit]['quantite']);
        $new_qte += $quantite;
        $_SESSION['panier'][$id_produit]['quantite'] = $new_qte;
        
    // quand ajoute le produit pour la toute premiere connexion dans le panier on entre dans le else
    } else 
    {
        $nouveauproduit = array();
        $nouveauproduit['titre'] = $titre;
        $nouveauproduit['id_produit'] = $id_produit;
        $nouveauproduit['quantite'] = $quantite;
        $nouveauproduit['prix']= $prix;
        $nouveauproduit['photo'] = $photo;

        $_SESSION['panier'][$id_produit] = $nouveauproduit;
    }
}

function montantTotal()
{
    if (!empty($_SESSION['panier'])) 
    {
        $total = 0;

        foreach ($_SESSION['panier'] as $key => $value) {
            $total += $value['quantite']*$value['prix'];
        }
        //permet d'arrondir à 2 chiffres après la virgule
        return round($total, 2);
    }
}


function affichage_form_avis()
{
    echo '<form action="" method="post" class="pb-5">';
    echo '<div class="mb-3">';
    echo 'Note : <select class="form-select" name="note" required="required">
        <option selected>-- Choisir une note --</option>';
    for ($i=0; $i<=10; $i++) {
        echo '<option value="'.$i.'">'.$i.'</option>';
    }
    echo  '</select>';
    echo '</div>';
    echo '<div class="mb-3">
        Ajouter un commentaire :<textarea type="text" class="form-control mt-2"  name="commentaire" placeholder="Votre commentaire" rows="10" required="required"></textarea>
    </div>';
    if (internauteEstConnecte()) {
        echo '<button type="submit" class="btn btn-primary">Soumettre</button>';
    } else {
        echo '<a href="/pages/connexion.php" class="btn btn-primary mr-5">Se connecter pour écrire un commentaire</a>';
    }
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

?>