<?php
// BDD

if(is_int(stripos($_SERVER['HTTP_HOST'], 'localhost')) || is_int(stripos($_SERVER['HTTP_HOST'], '127.0.0.1')) || is_int(stripos($_SERVER['HTTP_HOST'], '[::1]'))) {
    // connexion au serveur mysql local
    $pdo = new PDO("mysql:host=localhost;dbname=lokisalle", "root", "");
   } else { 
    $pdo = new PDO("mysql:host=mouyimv619.mysql.db;dbname=mouyimv619;charset=utf8", "mouyimv619", "Noodles1987");
   }
//$pdo = new PDO("mysql:host=localhost;dbname=lokisalle", "root", "");
//$pdo = new PDO("mysql:host=mouyimv619.mysql.db;dbname=mouyimv619;charset=utf8", "mouyimv619", "Noodles1987");
// SESSION
session_start();

//CHEMIN
define("RACINE_SITE","/");

// VARIABLES
$contenu = "";
$message = "";

//FONCTIONS
require("fonction.inc.php");
?>