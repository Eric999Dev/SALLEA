<?php
require_once('../inc/init.inc.php');


//-------------------- TRAITEMENT ----------------------
// 1- on vérifie que le membre est admin :
if (!userConnectAdmin()) {
	header('location:../connexion.php');	
	exit();
}

// 7- Suppression du produit :
if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['id_produit'])) {
	// si les indices "action" et "id_produit", c'est que l'url est complète
	
	$resultat = executeRequete("SELECT photo FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));
	
	if ($resultat->rowCount() == 1) {
		// Ici le produit existe
		$produit_a_supprimer = $resultat->fetch(PDO::FETCH_ASSOC); // pas de boucle car on a qu'un seul produit par id
		
		if (!empty($produit_a_supprimer['photo'])) {
			// s'il y a une photo dans la BDD, on peut supprimer la photo physique :
			$chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . $produit_a_supprimer['photo'];  // chemin COMPLET du fichier photo : C:/wamp64/www/PHP/08-site/photo/nomphoto.jpg
			
			if (file_exists($chemin_photo_a_supprimer)) {
				unlink($chemin_photo_a_supprimer); // si le fichier existe, on le supprimer avec unlink()
			} 
		}	
				
		executeRequete("DELETE FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));
		$contenu .= '<div class="bg-success">Produit supprimé !</div>';
		
	} else {
		// ici le produit n'existe pas 
		$contenu .= '<div class="bg-danger">Produit inexistant !</div>';
	}
	
	$_GET['action'] = 'affichage';  // afficher automatiquement le tableau des produits après suppression
}




// 4- Traitement du formulaire : enregistrement du produit :
if ($_POST) {  // si le formulaire est soumis

	// ici il faudrait mettre tous les contrôles sur le formulaire, ce qu'on ne fait pas...
	
	$photo_bdd = '';   // contiendra le chemin de la photo en BDD
	
	// 5- Traitement de la photo :
	if (isset($_GET['action']) && $_GET['action'] == 'modification') {
		// si je modifie le produit, je prend la photo actuelle que je remets en BDD :
		$photo_bdd = $_POST['photo_actuelle'];	
	} 
	
		
	
	// debug($_FILES);
	
	if (!empty($_FILES['photo']['name'])) { // si "name" n'est pas vide c'est que l'on est en train d'uploader une photo
		$nom_photo = $_POST['reference'] . '_' . $_FILES['photo']['name'];  // on constitue le nom unique du fichier photo qui sera uploadée sur notre serveur (la référence étant unique)
		
		$photo_bdd = 'photo/' . $nom_photo;   // chemin relatif de la photo enregistré en BDD (exemple : photo/nomphoto.jpg)
		
		// debug($_SERVER['DOCUMENT_ROOT']);
		
		$photo_physique = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . $photo_bdd;   // on obtient le chemin COMPLET pour enregistrer physiquement le fichier photo dans le dossier /photo/. $_SERVER['DOCUMENT_ROOT'] = localhost ou C:/wamp64/www. Ainsi on obtient un chemin du type : C:/wamp64/www/PHP/08-site/photo/nomphoto.jpg
	
		copy($_FILES['photo']['tmp_name'], $photo_physique);  // enregistre le fichier temporaire qui est dans $_FILES['photo']['tmp_name'] à l'endroit indiqué par $photo_physique
	
	}
	
	
	
	
	// Enregistrement du produit en BDD :
	executeRequete("REPLACE INTO produit VALUES(:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo_bdd, :prix, :stock )", 
				   array(
						':id_produit'  => $_POST['id_produit'],
						':reference'   => $_POST['reference'],
						':categorie'   => $_POST['categorie'],
						':titre'       => $_POST['titre'],
						':description' => $_POST['description'],
						':couleur'     => $_POST['couleur'],
						':taille'      => $_POST['taille'],
						':public'      => $_POST['public'],
						':photo_bdd'   => $photo_bdd,
						':prix'        => $_POST['prix'],
						':stock'       => $_POST['stock']
				   ));
	// Note : quand on ne spécifie pas les champs impactés par le REPLACE, il faut mettre dans VALUES tous les champs de la table exactement dans le même ordre que dans cette table
	
	$contenu .= '<div class="bg-success">Le produit a bien été enregistré.</div>';
	
	$_GET['action'] = 'affichage';  // on met un indice "action" et une valeur "affichage" dans $_GET pour forcer l'affichage du tableau HTML de tous les produits un peu plus bas (cf chapitre 6)
	
}  // fin du if ($_POST)


// 6- Affichage des produits sous forme de table HTML :
if (isset($_GET['action']) && $_GET['action'] == 'affichage') {
	// si on demande l'affichage des produits en GET :
	
	$resultat = executeRequete("SELECT * FROM produit"); // on obtient un objet PDOStatement non exploitable directement : il faudra donc faire un fetch dessus
	
	$contenu .= '<h3>Affichage des produits</h3>';
	$contenu .= 'Nombre de produits dans la boutique : ' . $resultat->rowCount();
	
	$contenu .= '<table class="table">';
		// Affichage des entêtes :
		$contenu .= '<tr>';
			for($i = 0; $i < $resultat->columnCount(); $i++) {
				$colonne = $resultat->getColumnMeta($i);
				$contenu .= '<th>' . $colonne['name'] . '</th>';
			}
			$contenu .= '<th>Actions</th>';
		$contenu .= '</tr>';
	
		// Affichage des lignes :
		while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
			//debug($ligne);
			$contenu .= '<tr>';
				foreach($ligne as $indice => $info) {
					if ($indice == 'photo') {
						$contenu .= '<td><img src="../'. $info .'" width="90" height="90" ></td>';
					} else {
						$contenu .= '<td>'. $info .'</td>';
					}
				}
$contenu .= '<td>
				<a href="?action=modification&id_produit='. $ligne['id_produit'] .'">modifier </a> 
				/
				<a href="?action=suppression&id_produit='. $ligne['id_produit'] .'" onclick="return(confirm(\'Etes-vous certain de vouloir supprimer ce produit ? \'))" >supprimer</a>
			 </td>';	
	
			$contenu .= '</tr>';
		}
	$contenu .= '</table>';
}	
	
	
	

//-------------------- AFFICHAGE ------------------------
require_once('../inc/haut.inc.php');

// 2- création des onglets "affichage" et "ajout" des produits :
echo '<ul class="nav nav-tabs">
		<li><a href="?action=affichage">Affichage des produits</a></li>	
		<li><a href="?action=ajout">Ajout produit</a></li>	
	  </ul>';  // quand on débute un href par un "?" c'est que l'on envoie en GET dans l'url des infos à la même page

echo $contenu;

// 3- Formulaire HTML : on affiche le formulaire uniquement en action "ajout" ou "modification" de produit :
if (isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) :  // syntaxe en if () : ... endif; utile quand on mélange beaucoup de HTML/php dans la condition

	// 8- Formulaire de modification de produit :
	if (isset($_GET['id_produit'])) {
		// si id_produit est dans l'url c'est que l'on modifie un produit existant : on requête en BDD les infos du produit à afficher :
		$resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));
		
		$produit_actuel = $resultat->fetch(PDO::FETCH_ASSOC);  // pas de while car un seul produit
		
		// debug($produit_actuel);
		
	}

?>
<h3>Ajout ou modification d'un produit</h3>
<form method="post" action="" enctype="multipart/form-data"><!-- multipart/form-data spécifie que le formulaire envoie des données texte (champs du formulaire) et des données binaires (= fichier) -->
		
	<input type="hidden" id="id_produit" name="id_produit" value="<?php echo $produit_actuel['id_produit'] ?? 0; ?>">
	<!-- champ caché pour ne pas pouvoir le modifier. Il est utile pour connaitre l'id du produit que l'on est en train de modifier -->
	
	<label for="reference">Référence</label><br>
	<input type="text" id="reference" name="reference" value="<?php echo $produit_actuel['reference'] ?? ''; ?>"><br><br>
	
	<label for="categorie">Catégorie</label><br>
	<input type="text" id="categorie" name="categorie" value="<?php echo $produit_actuel['categorie'] ?? ''; ?>"><br><br>
	
	<label for="titre">Titre</label><br>
	<input type="text" id="titre" name="titre" value="<?php echo $produit_actuel['titre'] ?? ''; ?>"><br><br>
	
	<label for="description">Description</label><br>
	<textarea id="description" name="description"><?php echo $produit_actuel['description'] ?? ''; ?></textarea><br><br>
	
	<label for="couleur">Couleur</label><br>
	<input type="text" id="couleur" name="couleur" value="<?php echo $produit_actuel['couleur'] ?? ''; ?>"><br><br>
	
	<label>Taille</label>
	<select name="taille">
		<option value="S" <?php if (isset($produit_actuel['taille'])  && $produit_actuel['taille'] == 'S') echo 'selected'; ?> > S </option>
		<option value="M" <?php if (isset($produit_actuel['taille'])  && $produit_actuel['taille'] == 'M') echo 'selected'; ?>> M </option>
		<option value="L" <?php if (isset($produit_actuel['taille'])  && $produit_actuel['taille'] == 'L') echo 'selected'; ?>> L </option>
		<option value="XL" <?php if (isset($produit_actuel['taille'])  && $produit_actuel['taille'] == 'XL') echo 'selected'; ?>> XL </option>
		<option value="XXL" <?php if (isset($produit_actuel['taille'])  && $produit_actuel['taille'] == 'XXL') echo 'selected'; ?>> XXL </option>
	</select><br><br>
	
	<label for="public">Public</label><br>
	<input type="radio" name="public" value="m" checked> Homme
	<input type="radio" name="public" value="f" <?php if (isset($produit_actuel['public']) && $produit_actuel['public'] == 'f') echo 'checked'; ?> > Femme <br><br>
	
	<label for="photo">Photo</label><br>
	<input type="file" id="photo" name="photo"><br><br><!-- ne pas oublier enctype="multipart/form-data" dans la balise <form> -->
	
	<!-- 9- modification de la photo : -->
	<?php
	if (isset($produit_actuel['photo'])) {
		// en cas de modification, on affiche la photo actuellement en BDD :
		echo '<i>Vous pouvez uploader une nouvelle photo.</i><br>';
		echo '<p>Photo actuelle : </p>';
		echo '<img src="../'. $produit_actuel['photo'] .'" width="90" height="90"><br>';
		echo '<input type="hidden" name="photo_actuelle" value="'. $produit_actuel['photo'] .'" ><br> ';  // renseigne $_POST['photo_actuelle'] qui remplace en BDD l'ancienne photo
	}	
	?>
	
	
	<label for="prix">Prix</label><br>
	<input type="text" id="prix" name="prix" value="<?php echo $produit_actuel['prix'] ?? 0; ?>"><br><br>
	
	<label for="stock">Stock</label><br>
	<input type="text" id="stock" name="stock" value="<?php echo $produit_actuel['stock'] ?? 0; ?>"><br><br>

	<input type="submit" value="valider" class="btn">
</form>
<?php
endif;  // ce endif ferme le if du début du chapitre 3
require_once('../inc/bas.inc.php');












