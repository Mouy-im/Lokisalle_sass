<?php
// BDD
$pdo = new PDO("mysql:host=localhost;dbname=lokisalle", "root", "");
//$pdo = new PDO("mysql:host=mouyimv619.mysql.db;dbname=mouyimv619", "mouyimv619", "Noodles1987");

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