<?php
require_once('inc/init.inc.php');

//-------------TRAITEMENT PHP--------------

//Traitement du POST
if (!empty($_POST)) {  // si le formulaire est posté, $_POST est remplie

	// Validation du formulaire :
	if (!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20 ) {
		// si l'indice 'pseudo' n'existe pas, ou que sa longueur est < 4 ou > 20, on met un message d'erreur :
		$contenu .= '<div class="bg-danger">Le pseudo doit contenir entre 4 et 20 caractères. </div>';
	}

	if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 20 ) {
		$contenu .= '<div class="bg-danger">Le mot de passe doit contenir entre 4 et 20 caractères. </div>';
	}

	if (!isset($_POST['nom']) || strlen($_POST['nom']) < 4 || strlen($_POST['nom']) > 20 ) {
		$contenu .= '<div class="bg-danger">Le nom doit contenir entre 4 et 20 caractères. </div>';
	}

	if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 4 || strlen($_POST['prenom']) > 20 ) {
		$contenu .= '<div class="bg-danger">Le prenom doit contenir entre 4 et 20 caractères. </div>';
	}

	if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		// filter_var permet ici de valider le format de type email : retourne true si c'est ok, sinon false. Note : ici on vérifie la négation, qu'il ne s'agit pas d'un email (d'où le "!")
		$contenu .= '<div class="bg-danger">Email incorrect ! </div>';
	}

    	if (!isset($_POST['civilite']) || ($_POST['civilite'] != 'm' && $_POST['civilite'] != 'f')) {
		$contenu .= '<div class="bg-danger">Civilité incorrecte ! </div>';
	}

    // Si pas d'erreur dans $contenu, on vérifie l'unicité du pseudo en base de données puis on fait l'inscription :
	if (empty($contenu)) {
		// si $contenu est vide, c'est qu'il n'y a pas d'erreur

    $membre = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo']));  // on fait cette requête pour vérifier la disponibilité du pseudo

		// debug($membre->rowCount());

		if ($membre->rowCount() > 0) {
			// si la requête retourne au moins 1 ligne, c'est que le pseudo existe déjà
			$contenu .= '<div class="bg-danger">Pseudo indisponible : veuillez en choisir un autre !</div>';
		} else {
			// sinon on peut inscrire le membre en BDD :
			$mdp = md5($_POST['mdp']); // si nous cryptons le mdp avec la fonction prédéfinie md5(), il faudra également le faire sur la page de connexion pour comparer 2 mdp cryptés

            executeRequete(
			"INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, statut, date_enregistrement)
			VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, 0, NOW())",
			array(
				':pseudo'        => $_POST['pseudo'],
				':mdp'           => $mdp,
				':nom'           => $_POST['nom'],
				':prenom'        => $_POST['prenom'],
				':email'         => $_POST['email'],
				':civilite'      => $_POST['civilite'],

			));

            header('location: connexion.php');

		$contenu .= '<div class="bg-success">Vous êtes inscrit à notre site. <a href="connexion.php">Cliquez ici pour vous connecter .</a></div>';
		}
	}
} // fin du if (!empty($_POST))



//---------- AFFICHAGE ------------------------
require_once('inc/haut.inc.php');
echo $contenu;  // variable qui va contenir les éléments à afficher (déclarée dans init.inc.php)
?>

<h3>Veuillez remplir le formulaire pour vous inscrire</h3>
<form method="post" action="">
	<label for="pseudo">Votre pseudo</label><br>
	<input type="text" id="pseudo" name="pseudo" value="<?php echo $_POST['pseudo'] ?? ''; ?>" requierd><span style="color:#ff0000;">*</span><br><br>

	<label for="mdp">Votre mot de passe</label><br>
	<input type="password" id="mdp" name="mdp" value="<?php echo $_POST['mdp'] ?? ''; ?>" requierd><span style="color:#ff0000;">*</span><br><br>

	<label for="nom">Votre nom</label><br>
	<input type="text" id="nom" name="nom" value="<?php echo $_POST['nom'] ?? ''; ?>" requierd><span style="color:#ff0000;">*</span><br><br>

	<label for="prenom">Votre prenom</label><br>
	<input type="text" id="prenom" name="prenom" value="<?php echo $_POST['prenom'] ?? ''; ?>" requierd><span style="color:#ff0000;">*</span><br><br>

	<label for="email">Votre email</label><br>
	<input type="text" id="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" requierd><span style="color:#ff0000;">*</span><br><br>

	<label>Civilité</label><br>
	<input type="radio" name="civilite" value="m" checked> Homme
	<input type="radio" name="civilite" value="f" <?php if (isset($_POST['civilite']) && $_POST['civilite'] == 'f') echo 'checked'; ?> > Femme <br><br>


	<input type="submit" name="inscription" value="s'inscrire" class="btn">

</form>

<?php
require_once('inc/bas.inc.php');
?>
