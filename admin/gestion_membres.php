<?php
require_once('../inc/init.inc.php');


//-------------------- TRAITEMENT ----------------------
// 1- on vérifie que le membre est admin :
if (!userConnectAdmin()) {
	header('location:../connexion.php');
	exit();
}

//-Suppression d'un membre:
if(isset($_GET['action']) && $_GET['action'] == "supprimer_membre" && isset($_GET['id_membre']))
{	// on ne peut pas supprimer son propre profil :
	if ($_SESSION['membre']['id_membre'] != $_GET['id_membre']) {
		executeRequete("DELETE FROM membre WHERE id_membre=:id_membre", array(':id_membre' => $_GET['id_membre']));

	} else {
		$contenu .= '<div class="bg-danger">Vous ne pouvez pas supprimer votre propre profil ! </div>';
	}
}


// 4- Traitement du formulaire : modification du membre :
if ($_POST) {  // si le formulaire est soumis

    if ($_SESSION['membre']['id_membre'] != $_GET['id_membre']) {
	// Enregistrement du membre en BDD :
	executeRequete("UPDATE membre SET pseudo = :pseudo, nom = :nom, prenom = :prenom, email = :email, civilite = :civilite, statut = :statut WHERE id_membre = :id_membre ",
				   array(

						':pseudo'    => $_POST['pseudo'],
						':nom'       => $_POST['nom'],
						':prenom'    => $_POST['prenom'],
						':email'     => $_POST['email'],
						':civilite'  => $_POST['civilite'],
						':statut'    => $_POST['statut'],
                        ':id_membre'  => $_GET['id_membre']
				   ));

	$contenu .= '<div class="bg-success">Le membre a bien été modifié.</div>';

}else{
	$contenu .= '<div class="bg-danger">Vous ne pouvez pas modifier votre compte !</div>';
}
	$_GET['action'] = 'annuler';
}  // fin du if ($_POST)


// 6- Affichage des membres sous forme de table HTML :

	$resultat = executeRequete("SELECT * FROM membre"); // on obtient un objet PDOStatement non exploitable directement : il faudra donc faire un fetch dessus


	$contenu .= '<h3>Affichage des membres</h3>';
	$contenu .= 'Nombre de membres dans la boutique : ' . $resultat->rowCount();

		$contenu .= '<div class="no-more-tables">';
    $contenu .=  '<table class="col-md-12 table-bordered table-striped table-condensed cf">';
    $contenu .=  '<tr>';
		// Affichage des entêtes :
		for($i = 0; $i < $resultat->columnCount(); $i++)
		{
			$colonne = $resultat->getColumnMeta($i);  // Retourne les métadonnées pour une colonne dans le jeu de résultats $resultat sous forme de tableau
			// debug($colonne);  // on y trouve l'indice "name"
			if ( $colonne['name'] != 'mdp') $contenu .= '<th>' . $colonne['name'] . '</th>';
		}

		$contenu .=  '<th> Supprimer </th>';
		$contenu .=  '<th> Modifier </th>';
		$contenu .=  '</tr>';

		// Affichage des lignes :
		while ($membre = $resultat->fetch(PDO::FETCH_ASSOC))
		{
			$contenu .=  '<tr>';
				foreach ($membre as $indice => $information)
				{
					if ($indice != 'mdp') $contenu .=  '<td>' . $information . '</td>';
				}
				$contenu .=  '<td><a href="?action=supprimer_membre&id_membre=' . $membre['id_membre'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce membre?\'));"> <i class="glyphicon glyphicon-trash"></i> </a></td>';
				$contenu .=  '<td><a href="?action=modifier_membre&id_membre=' . $membre['id_membre'] . '&statut='. $membre['statut'] .'"> <i class="glyphicon glyphicon-pencil"></i> </a></td>';
			$contenu .=  '</tr>';
		}
$contenu .=  '</table>';
$contenu .= '</div>';

//-------------------- AFFICHAGE ------------------------
require_once('../inc/haut.inc.php');

echo $contenu .'<br><br>';

// 3- Formulaire HTML : on affiche le formulaire uniquement en action "modifier_membre" de membre :
if (isset($_GET['action']) && ($_GET['action'] == 'modifier_membre' || $_GET['action'] == 'affichage')):  // syntaxe en if () : ... endif; utile quand on mélange beaucoup de HTML/php dans la condition

	// 8- Formulaire de modification de membre :
	if (isset($_GET['id_membre'])) {
		// si id_membre est dans l'url c'est que l'on modifie un membre existant : on requête en BDD les infos du membre à afficher :
		$resultat = executeRequete("SELECT * FROM membre WHERE id_membre = :id_membre", array(':id_membre' => $_GET['id_membre']));

		$membre_actuel = $resultat->fetch(PDO::FETCH_ASSOC);  // pas de while car un seul membre


	}

?>

<h3>Modification de membre</h3>
<div class="row">
<div class="col-lg-6">
<form method="post" action="">

	<input type="hidden" id="id_membre" name="id_membre" value="<?php echo $membre_actuel['id_membre'] ?? 0; ?>">
	<!-- champ caché pour ne pas pouvoir le modifier. Il est utile pour connaitre l'id du membre que l'on est en train de modifier -->

	<label for="pseudo">Pseudo</label><br>
	<input type="text" id="pseudo" name="pseudo" value="<?php echo $membre_actuel['pseudo'] ?? ''; ?>"><br><br>

	<label for="nom">Nom</label><br>
	<input type="text" id="nom" name="nom" value="<?php echo $membre_actuel['nom'] ?? ''; ?>"><br><br>

	<label for="prenom">Prenom</label><br>
	<input type="text" id="prenom" name="prenom" value="<?php echo $membre_actuel['prenom'] ?? ''; ?>"><br><br>
</div>

<div class="col-lg-6">
	<label for="email">Email</label><br>
	<input type="text" id="email" name="email" value="<?php echo $membre_actuel['email'] ?? ''; ?>"><br><br>

	<label>Civilité</label><br>
	<select name="civilite">
		<option value="m" <?php if (isset($membre_actuel['civilite'])  && $membre_actuel['civilite'] == 'm') echo 'selected'; ?> > Homme </option>
		<option value="f" <?php if (isset($membre_actuel['civilite'])  && $membre_actuel['civilite'] == 'f') echo 'selected'; ?>> Femme </option>
    </select><br><br>

    <label>Statut</label><br>
    <select name="statut">
		<option value="1" <?php if (isset($membre_actuel['statut'])  && $membre_actuel['statut'] == '') echo 'selected'; ?> > Admin </option>
		<option value="0" <?php if (isset($membre_actuel['statut'])  && $membre_actuel['statut'] == '0') echo 'selected'; ?>> Membre </option>
    </select><br><br>

	<input type="submit" value="valider" class="btn btn-success">
	<a href="gestion_membres.php" class="btn btn-warning">Annuler</a>
</form>
</div>
</div>
<?php
endif;  // ce endif ferme le if du début du chapitre 3
require_once('../inc/bas.inc.php');
?>
