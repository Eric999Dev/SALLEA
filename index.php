<?php
require_once('inc/init.inc.php');

//------------------- TRAITEMENT  -------------------

// Affichage des catégories de produits :

$resultat = executeRequete("SELECT DISTINCT categorie FROM salle");

$contenu_gauche .= '<p class="lead">Catégorie</p>';

	while($cat = $resultat->fetch(PDO::FETCH_ASSOC)) {
		$contenu_gauche .= '<div class="checkbox">';
		  $contenu_gauche .= '<label><input type="checkbox" name="categorie[]" value="'. strtolower($cat['categorie']) .'">' . $cat['categorie'] . '</label>';
		$contenu_gauche .= '</div>';

	}


// Affichage des villes :

$resultat = executeRequete("SELECT DISTINCT ville FROM salle");

$contenu_gauche .= '<p class="lead">Ville</p>';
	//$contenu_gauche .= '<select name="ville" id="ville" class="form-control">';

	while($ville = $resultat->fetch(PDO::FETCH_ASSOC)) {
		$contenu_gauche .= '<div class="checkbox">';
			$contenu_gauche .= '<label><input type="checkbox" name="ville[]" value="'. strtolower($ville['ville']) .'">' . $ville['ville'] . '</label>';
		$contenu_gauche .= '</div>';

	}


// Affichage des capacités des salles :

$contenu_gauche .= '<div class="form-group">';
$contenu_gauche .= '<p class="lead">Capacité max</p>';
$contenu_gauche .= '<select name="capacite" class="form-control" id="capacite">';
	$contenu_gauche .= '<option value="2">2</option>';
	$contenu_gauche .= '<option value="4">4</option>';
	$contenu_gauche .= '<option value="6">6</option>';
	$contenu_gauche .= '<option value="8">8</option>';
	$contenu_gauche .= '<option value="20">20</option>';
	$contenu_gauche .= '<option value="40">40</option>';
	$contenu_gauche .= '<option value="80" selected>80</option>';
$contenu_gauche .= '</select>';
$contenu_gauche .= '</div>';

// Affichage des prix des produits :

$contenu_gauche .= '<label id="prixValue" for="prix">Prix maximum</label>';
$contenu_gauche .= '<input name="prix" type="range" id="prix" min="200" max="1500" value="1500">';
$contenu_gauche .= '<div id="affiche-prix">1500 €</div><br/><br/>';

// Affichage des dates des produits :

$contenu_gauche .= '<div class="form-group">';
$contenu_gauche .= '<label for="date_arrivee">Date arrivée </label>';
$contenu_gauche .= '<input name="date_arrivee" type="text" class="form-control" id="date_arrivee">';
$contenu_gauche .= '<label for="date_depart">Date départ </label>';
$contenu_gauche .= '<input name="date_depart" type="text" class="form-control" id="date_depart">';
$contenu_gauche .= '</div>';
$contenu_gauche .= '</form>';

//------------------ AFFICHAGE -----------------------
require_once('inc/haut.inc.php');
?>
	<div class="row">
		<div class="col-md-2">
			<form method="post" id="filter" action="">
				<?php echo $contenu_gauche; ?>
			</form>
			<?php // echo $contenu_droite; ?>
		</div>
		<div class="col-md-10">
			<div class="row">
				<div id="results">
					<?php include_once('inc/ajax.inc.php'); ?>
				</div>
			</div>
		</div>
	</div>

<?php
require_once('inc/bas.inc.php');

?>




<script>
$(function(){
		// AJAX
		// 3- fonction callback
		function reponse(retourPHP) {
			$("#results").html(retourPHP); // on affiche le HTML envoyé en réponse par le serveur.
		}

	// 1- fonction d'envoi de la requête au serveur en AJAX
		function envoi_ajax(){
			var donnees = $("#filter").serialize() // transforme les données du formulaire en string avant envoi vers le serveur en AJAX. String formaté pour pouvoir remplir l'array $_POST automatiquement.
			$.post('inc/ajax.inc.php', donnees, reponse, 'html'); // url de destination, données envoyées (objet OU string), fonction callback de traitement de la réponse serveur, format de retour = on attend du HTML.
		}

	// 2- appels de notre fonction
		envoi_ajax(); // pour afficher tout de suite tous les produits disponibles au chargement de la page (initial)
		$("#filter").change(envoi_ajax); // si les valeurs du formulaire changent, on appelle de nouveau la fonction pour modifier la sélection (et son affichage)



	// affichage prix
	$('#prix').change(function(){
		var prix = $("#prix").val();
		$('#affiche-prix').text(prix + ' €');
	});


}); // fin document ready
</script>
