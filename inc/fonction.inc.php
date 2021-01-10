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


?>