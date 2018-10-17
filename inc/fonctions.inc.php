<?php

function debug($var) {
	echo '<div style="border: 1px solid orange">';

		echo '<pre>'; print_r($var); echo '</pre>';

	echo '</div>';
}


//--------------------------------------
// Fonctions liées au membre :
// Fonction pour déterminer si un membre est connecté :

function userConnect() {
	if (isset($_SESSION['membre'])) {  // si "membre" existe dans $_SESSION c'est que l'internaute est passé par le formulaire de connexion avec le bon mot de passe (cf connexion.php)
		return true;
	} else {
		return false;
	}
	// return (isset($_SESSION['membre']));
}

// Fonction pour déterminer si un membre est connecté et qu'il est administrateur :
function userConnectAdmin() {
	if (userConnect() && $_SESSION['membre']['statut'] == 1) {  // si le statut est 1 dans $_SESSION['membre'] c'est que l'internaute est bien admin. De plus on vérifie qu'il est bien connecté.
		return true;
	} else {
		return false;
	}

	// return (userConnect() && $_SESSION['membre']['statut'] == 1);
}

//-----------------------------------
// Fonction pour exécuter des requêtes :
function executeRequete($req, $param = array()) {

	if (!empty($param)) {
		// si j'ai reçu des valeurs associées aux marqeurs, je fais un htmlspecialchars pour les échapper = convertir les caractères spéciaux en entité HTML :

		foreach($param as $indice => $valeur) {
			$param[$indice] = htmlspecialchars($valeur, ENT_QUOTES); // on prend la valeur de $param que l'on traite par htmlspecialchars et que l'on remet à son indice (c'est-à-dire exactement à la même place). Permet d'éviter les injections XSS et CSS
		}
	}

	global $pdo;   // permet d'avoir accès à la variable $pdo définie dans l'espace global, à l'intérieur de l'espace local de la fonction executeRequete

	$r = $pdo->prepare($req);  // on prépare le requête reçue en argument
	$r->execute($param);  // on exécute la requête fournie en passant l'array $param qui associe les marqueurs aux variables

	return $r;   // on retourne l'objet PDOStatement à l'endroit où la fonction executeRequete est appelée (utile aux SELECT)
}
	//---------------------------------------
