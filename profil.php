<?php
require_once('inc/init.inc.php');

//------------------ TRAITEMENT ----------------------
// 1- on redirige l'internaute vers la page de connexion s'il n'est pas connecté :
if (!userConnect()) {
	// si pas connecté :
	header('location:connexion.php'); // nous l'invitons à se connecter
	exit();
}

// 2- Préparation du profil à afficher :
// debug($_SESSION);

$contenu .= '<h2>Bonjour '. $_SESSION['membre']['pseudo'] .'</h2>';

if (userConnectAdmin()) {
	// si membre administrateur :
	$contenu .= '<p>Vous êtes administrateur.</p>';
}

$contenu .= '<div><h3>Vos informations de profil :</h3>';
	$contenu .= '<p>Votre email : '. $_SESSION['membre']['email'] .'</p>';
	$contenu .= '<p>Votre nom : '. $_SESSION['membre']['nom'] .'</p>';
	$contenu .= '<p>Votre prenom : '. $_SESSION['membre']['prenom'] .'</p>';
$contenu .= '</div>';


//----------
//Afficher le suivi des commandes de l'internaute connecté dans une liste <ul><li> avec les infos suivantes : id_commande, date et état. S'il n'y a pas de commande à afficher, on met "aucune commande en cours".

$resultat = executeRequete("SELECT *, DATE_FORMAT(date_enregistrement, '%d/%m/%Y %H:%i:%s') AS date_fr  FROM commande WHERE id_membre = :id_membre", array(':id_membre' => $_SESSION['membre']['id_membre']));


if ($resultat->rowCount() > 0) {
	// si il y a des lignes dans $resultats, c'est qu'il y a des commandes en BDD :

	$contenu .= '<ul>';

	while($commande_membre = $resultat->fetch(PDO::FETCH_ASSOC)) {
		$contenu .= '<li class="list-group-item"> La commande '. $commande_membre['id_commande'] . ' enregistrée le ' . $commande_membre['date_fr'] . '</li>';


	}


	$contenu .= '</ul>';

} else {
	$contenu .= '<p>Aucune commande en cours</p>';
}









//------------------ AFFICHAGE ------------------------
require_once('inc/haut.inc.php');
echo $contenu;
require_once('inc/bas.inc.php');
