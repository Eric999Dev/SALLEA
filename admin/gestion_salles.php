<?php
require_once('../inc/init.inc.php');

//-------------------- TRAITEMENT ----------------------
// 1- on vérifie que le salle est admin :
if (!userConnectAdmin()) {
	header('location:../connexion.php');
	exit();
}



// 7- Suppression d'une salle :
if (isset($_GET['action']) && $_GET['action'] == 'supprimer_salle' && isset($_GET['id_salle'])) {
	// si les indices "action" et "id_salle", c'est que l'url est complète

	$resultat = executeRequete("SELECT photo FROM salle WHERE id_salle = :id_salle", array(':id_salle' => $_GET['id_salle']));

	if ($resultat->rowCount() == 1) {
		// Ici le produit existe
		$produit_a_supprimer = $resultat->fetch(PDO::FETCH_ASSOC); // pas de boucle car on a qu'un seul produit par id

		if (!empty($produit_a_supprimer['photo'])) {
			// s'il y a une photo dans la BDD, on peut supprimer la photo physique :
			$chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . $produit_a_supprimer['photo'];  // chemin COMPLET du fichier photo : C:/wamp64/www/SALLEA/img/nomphoto.jpg

			if (file_exists($chemin_photo_a_supprimer)) {
				unlink($chemin_photo_a_supprimer); // si le fichier existe, on le supprimer avec unlink()
			}
		}

		executeRequete("DELETE FROM salle WHERE id_salle = :id_salle", array(':id_salle' => $_GET['id_salle']));
		$contenu .= '<div class="bg-success">Salle supprimée !</div>';

	} else {
		// ici le produit n'existe pas
		$contenu .= '<div class="bg-danger">Salle inexistante !</div>';
	}


}

// 4- Traitement du formulaire : modification d'une salle :

if ($_POST) {  // si le formulaire est soumis

    // ici il faudrait mettre tous les contrôles sur le formulaire, ce qu'on ne fait pas...

	$photo_bdd = '';   // contiendra le chemin de la photo en BDD

	// 5- Traitement de la photo :
	if (isset($_GET['action']) && $_GET['action'] == 'modifier_salle') {
		// si je modifie le produit, je prend la photo actuelle que je remets en BDD :
		$photo_bdd = $_POST['photo_actuelle'];

	// debug($_FILES);

	if (!empty($_FILES['photo']['name'])) { // si "name" n'est pas vide c'est que l'on est en train d'uploader une photo
		$nom_photo = $_POST['titre'] . '_' . $_FILES['photo']['name'];  // on constitue le nom unique du fichier photo qui sera uploadée sur notre serveur (la référence étant unique)


		$photo_bdd = 'img/' . $nom_photo;   // chemin relatif de la photo enregistré en BDD (exemple : img/nomphoto.jpg)

//		 debug($_SERVER['DOCUMENT_ROOT']);

		$photo_physique = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . $photo_bdd;   // on obtient le chemin COMPLET pour enregistrer physiquement le fichier photo dans le dossier /photo/. $_SERVER['DOCUMENT_ROOT'] = localhost ou C:/wamp64/www. Ainsi on obtient un chemin du type : C:/wamp64/www/SALLEA/img/nomphoto.jpg

		copy($_FILES['photo']['tmp_name'], $photo_physique);  // enregistre le fichier temporaire qui est dans $_FILES['photo']['tmp_name'] à l'endroit indiqué par $photo_physique


	}

	// Modification de salle en BDD :
	executeRequete("UPDATE salle SET titre = :titre, description = :description, photo = :photo_bdd, ville = :ville, capacite = :capacite, categorie = :categorie, adresse = :adresse, cp = :cp WHERE id_salle = :id_salle",
				   array(

						':titre'        => $_POST['titre'],
						':description'  => $_POST['description'],
						':photo_bdd'    => $photo_bdd,
                        ':ville'    	=> $_POST['ville'],
						':capacite'     => $_POST['capacite'],
						':categorie'    => $_POST['categorie'],
						':adresse'      => $_POST['adresse'],
						':cp'           => $_POST['cp'],
                        ':id_salle'     => $_GET['id_salle']
				   ));

        $contenu .= '<div class="bg-success">La salle a bien été modifiée.</div>';
        $_GET['action'] = 'affichage';
        }


}  // fin du if ($_POST)




	// 5- Traitement de la photo :
	if (isset($_GET['action']) && $_GET['action'] == 'ajouter_salle') {
        if ($_POST) {

		// si je modifie le produit, je prend la photo actuelle que je remets en BDD :
            if (!empty($_FILES['photo']['name'])) { // si "name" n'est pas vide c'est que l'on est en train d'uploader une photo
		$nom_photo = $_POST['titre'] . '_' . $_FILES['photo']['name'];  // on constitue le nom unique du fichier photo qui sera uploadée sur notre serveur (la référence étant unique)
		$photo_bdd = 'img/' . $nom_photo;   // chemin relatif de la photo enregistré en BDD (exemple : photo/nomphoto.jpg)
		$photo_physique = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . $photo_bdd;   // on obtient le chemin COMPLET pour enregistrer physiquement le fichier photo dans le dossier /photo/. $_SERVER['DOCUMENT_ROOT'] = localhost ou C:/wamp64/www. Ainsi on obtient un chemin du type : C:/wamp64/www/PHP/08-site/photo/nomphoto.jpg


		copy($_FILES['photo']['tmp_name'], $photo_physique);  // enregistre le fichier temporaire qui est dans $_FILES['photo']['tmp_name'] à l'endroit indiqué par $photo_physique
	}



	// Ajout d'une salle en BDD :
	executeRequete("INSERT INTO salle (titre, description, photo, pays, ville, adresse, cp, capacite, categorie ) VALUES (:titre, :description, :photo, :pays, :ville, :adresse, :cp, :capacite, :categorie)",
				   array(

						':titre'        => $_POST['titre'],
						':description'  => $_POST['description'],
						':photo'        => $photo_bdd,
						':pays'         => 'France',
						':ville'        => $_POST['ville'],
                        ':adresse'      => $_POST['adresse'],
						':cp'           => $_POST['cp'],
						':capacite'     => $_POST['capacite'],
						':categorie'    => $_POST['categorie']

				   ));


	$contenu .= '<div class="bg-success">La salle a bien été rajoutée.</div>';

        }
    }// fin du if ($_POST)


// 6- Affichage des salles sous forme de table HTML :

	$resultat = executeRequete("SELECT * FROM salle"); // on obtient un objet PDOStatement non exploitable directement : il faudra donc faire un fetch dessus

	$contenu .= '<h3>Affichage des salles</h3> <a class="btn btn-primary pull-right" href="?action=ajouter_salle" role="button">Ajouter</a><br>';
	$contenu .= 'Nombre de salle : ' . $resultat->rowCount();

	$contenu .= '<div class="no-more-tables">';
	$contenu .=  '<table class="col-md-12 table-bordered table-striped table-condensed cf">';
    $contenu .= '<thead class="label-default">';
    $contenu .= '<tr>';
		// Affichage des entêtes :
		for($i = 0; $i < $resultat->columnCount(); $i++)
		{
			$colonne = $resultat->getColumnMeta($i);  // Retourne les métadonnées pour une colonne dans le jeu de résultats $resultat sous forme de tableau
			// debug($colonne);  // on y trouve l'indice "name"
			$contenu .= '<th style="text-align:center";>' . $colonne['name'] . '</th>';
		}
		$contenu .=  '<th>Supprimer</th>';
		$contenu .=  '<th>Modifier</th>';
		$contenu .=  '</tr>';
		$contenu .=  '</thead>';

		// Affichage des lignes :
		while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC))
		{
			$contenu .=  '<tr>';
				foreach ($ligne as $indice => $info)
				if ($indice == 'photo') {
						$contenu .= '<td><img src="../'. $info .'" width="70" height="70" ></td>';
					} else {
						$contenu .= '<td>'. $info .'</td>';
					}
$contenu .=  '<td><a href="?action=supprimer_salle&id_salle=' . $ligne['id_salle'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce salle?\'));"><i class="glyphicon glyphicon-trash"></a></td>';

  $contenu .= '<td><a href="?action=modifier_salle&id_salle=' . $ligne['id_salle'] .'"><i class="glyphicon glyphicon-pencil"></a></td>';


						}

$contenu .=  '</table>';
$contenu .= '</div>';

//-------------------- AFFICHAGE ------------------------
require_once('../inc/haut.inc.php');

echo $contenu;

// 3- Formulaire HTML : on affiche le formulaire uniquement en action "modifier_salle" de salle :
if (isset($_GET['action']) && ($_GET['action'] == 'modifier_salle' || ($_GET['action'] == 'ajouter_salle' ))):  // syntaxe en if () : ... endif; utile quand on mélange beaucoup de HTML/php dans la condition

	// 8- Formulaire de modification de salle :
	if (isset($_GET['id_salle'])) {
		// si id_salle est dans l'url c'est que l'on modifie un salle existant : on requête en BDD les infos du salle à afficher :
		$resultat = executeRequete("SELECT * FROM salle WHERE id_salle = :id_salle", array(':id_salle' => $_GET['id_salle']));

		$salle_actuelle = $resultat->fetch(PDO::FETCH_ASSOC);  // pas de while car un seul salle

    }
?>

<h3>Ajout et Modification de salle</h3>

<form method="post" action="" enctype="multipart/form-data">

	<input type="hidden" id="id_salle" name="id_salle" value="<?php echo $salle_actuelle['id_salle'] ?? 0; ?>">
	<!-- champ caché pour ne pas pouvoir le modifier. Il est utile pour connaitre l'id de la salle que l'on est en train de modifier -->

	<label for="titre">Titre</label><br>
	<input type="text" id="titre" name="titre" value="<?php echo $salle_actuelle['titre'] ?? ''; ?>" requierd><br><br>

	<label for="description">Description</label><br>
	<textarea id="description" name="description" requierd rows="5" cols="25" style="resize: none;"><?php echo $salle_actuelle['description'] ?? ''; ?></textarea><br><br>

	<label for="photo">Photo</label><br>
	<input type="file" id="photo" name="photo" requierd><br><br><!-- ne pas oublier enctype="multipart/form-data" dans la balise <form> -->

	<!-- 9- modification de la photo : -->
	<?php
	if (isset($salle_actuelle['photo'])) {
		// en cas de modification, on affiche la photo actuellement en BDD :
		echo '<i>Vous pouvez uploader une nouvelle photo.</i><br>';
		echo '<p>Photo actuelle : </p>';
		echo '<img src="../'. $salle_actuelle['photo'] .'" width="50" height="50"><br>';
		echo '<input type="hidden" name="photo_actuelle" value="'. $salle_actuelle['photo'] .'" ><br> ';  // renseigne $_POST['photo_actuelle'] qui remplace en BDD l'ancienne photo
	}
	?>

	<label for="pays">Pays</label><br>
	<input type="text" id="pays" name="pays" value="France"><br><br>

	<label>Ville</label>
	<select name="ville">
		<option value="Paris" <?php if (isset($salle_actuelle['ville'])  && $salle_actuelle['ville'] == 'Paris') echo 'selected'; ?> > Paris </option>
		<option value="Lyon" <?php if (isset($salle_actuelle['ville'])  && $salle_actuelle['ville'] == 'Lyon') echo 'selected'; ?>> Lyon </option>
		<option value="Marseille" <?php if (isset($salle_actuelle['ville'])  && $salle_actuelle['ville'] == 'Marseille') echo 'selected'; ?>> Marseille </option>
    </select><br><br>

	<label for="adresse">Adresse</label><br>
	<input type="text" id="adresse" name="adresse" value="<?php echo $salle_actuelle['adresse'] ?? ''; ?>" requierd><br><br>

	<label for="cp">Code postal</label>
    <input type="text" id="cp" name="cp" pattern="[0-9]{5}" maxlength="5" value="<?php echo $salle_actuelle['cp'] ?? ''; ?>" requierd><br><br>

	<label for="capacite">Capacite</label><br>
	<input type="text" id="capacite" name="capacite" value="<?php echo $salle_actuelle['capacite'] ?? ''; ?>" requierd><br><br>

	<label>Catégorie</label>
	<select name="categorie">
		<option value="reunion" <?php if (isset($salle_actuelle['categorie'])  && $salle_actuelle['categorie'] == 'reunion') echo 'selected'; ?> > Reunion </option>
		<option value="bureau" <?php if (isset($salle_actuelle['categorie'])  && $salle_actuelle['categorie'] == 'bureau') echo 'selected'; ?>> Bureau </option>
		<option value="formation" <?php if (isset($salle_actuelle['categorie'])  && $salle_actuelle['categorie'] == 'formation') echo 'selected'; ?>> Formation </option>
    </select><br><br>

		<input type="submit" value="valider" class="btn btn-success">
		<a href="gestion_salles.php" class="btn btn-warning">Annuler</a>
</form>
<?php
endif;  // ce endif ferme le if du début du chapitre 3
require_once('../inc/bas.inc.php');
