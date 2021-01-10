<?php
// BDD
$pdo = new PDO("mysql:host=localhost;dbname=lokisalle", "root", "");

// SESSION
session_start();

//CHEMIN
define("RACINE_SITE","/");

// VARIABLES
$contenu = "";
$message = "";

//FONCTIONS
require("fonction.inc.php");