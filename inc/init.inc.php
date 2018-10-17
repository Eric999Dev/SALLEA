<?php
// Ce fichier sera inclus dans TOUS les scripts du site (hors les fichiers inc eux mêmes). Ainsi, les paramètres qui y sont définis seront disponibles partout.

// Connexion à la BDD :
$pdo = new PDO(
		'mysql:host=localhost;dbname=sallea',
		'root',
		'',
		array(
			PDO::ATTR_ERRMODE  => PDO::ERRMODE_WARNING,
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
		) 
	);
	

// Session :
session_start();

	
// Chemin du site :
define('RACINE_SITE', '/SALLEA/');  // chemin absolu du site à partir de localhost. Utile pour faire des liens dynamiques selon que le fichier source qui les contient sont dans le dossier /admin/ (back-office) ou à la racine du site (front-office)


// Variables d'affichage :
$contenu = '';
$contenu_gauche = '';
$contenu_droite = '';


// Inclusion du fichier de fonctions :
require_once('fonctions.inc.php');


