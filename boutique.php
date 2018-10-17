<?php
require_once('inc/init.inc.php');

//------------------- TRAITEMENT  -------------------

// 1- Affichage des catégories de produits :

$resultat = executeRequete("SELECT DISTINCT categorie FROM salle");

$contenu_gauche .= '<p class="lead">Catégorie</p>';
$contenu_gauche .= '<form id="filter">';
$contenu_gauche .= '<select class="form-control" id="categorie">';
	while($cat = $resultat->fetch(PDO::FETCH_ASSOC)) {

		$contenu_gauche .= '<option value="'. $cat['categorie'] .'">'. $cat['categorie'] .'</option>';
	}
$contenu_gauche .= '</select>';



$resultat = executeRequete("SELECT DISTINCT ville FROM salle");

$contenu_gauche .= '<p class="lead">Ville</p>';
	$contenu_gauche .= '<select id="ville" class="form-control">';

	while($cat = $resultat->fetch(PDO::FETCH_ASSOC)) {
		//debug($cat);
		$contenu_gauche .= '<option value="'. $cat['ville'] .'">'. $cat['ville'] .'</option>';
	}
$contenu_gauche .= '</select>';


$contenu_gauche .= '<div class="form-group">';
$contenu_gauche .= '<p class="lead">Capacité</p>';
$contenu_gauche .= '<select name="capacite" class="form-control" id="capacite">';
	$contenu_gauche .= '<option value="10">10</option>';
	$contenu_gauche .= '<option value="20">20</option>';
	$contenu_gauche .= '<option value="30">30</option>';
	$contenu_gauche .= '<option value="40">40</option>';
	$contenu_gauche .= '<option value="50">50</option>';
	$contenu_gauche .= '<option value="60">60</option>';
	$contenu_gauche .= '<option value="70">70</option>';
	$contenu_gauche .= '<option value="80">80</option>';
$contenu_gauche .= '</select>';
$contenu_gauche .= '</div>';

$contenu_gauche .= '<label id="prixValue" for="prix">Prix </label>';
$contenu_gauche .= '<input type="range" id="prix" min="200" max="1500" value="800">';

$contenu_gauche .= '<div class="form-group">';
$contenu_gauche .= '<label for="date_arrivee">Date arrivée </label>';
$contenu_gauche .= '<input type="text" class="form-control" id="date_arrivee">';
$contenu_gauche .= '<label for="date_depart">Date départ </label>';
$contenu_gauche .= '<input type="text" class="form-control" id="date_depart">';
$contenu_gauche .= '</div>';


$contenu_gauche .= '</form>';

//------------------ AFFICHAGE -----------------------
require_once('inc/haut.inc.php');
?>
	<div class="row">
		<div class="col-md-3">
			<?php
			echo $contenu_gauche;
			?>
		</div>
		<div class="col-md-9">
			<div class="row">
				<div id="results">
					<?php include_once('ajax.php'); ?>
					<?= $contenu_droite; ?>
				</div>
			</div>
		</div>
	</div>

<?php
require_once('inc/bas.inc.php');

?>

<script>

$("#filter").change(function(){
 		var categorie = $("#categorie").val();
		var ville = $("#ville").val();
		var capacite = $("#capacite").val();
		var date_arrivee = $("#date_arrivee").val();
		var date_depart = $("#date_depart").val();
		var prix = $("#prix").val();
        $.ajax({
        type : 'GET',
        data : {
					categorie : categorie,
					ville : ville,
					capacite : capacite,
					date_arrivee : date_arrivee,
					date_depart : date_depart,
					prix : prix
				},
        url : 'ajax.php',
        success : function(data) {
          $("#results").html(data)
          }
      })
  });

	var today = new Date();
	var dd = today.getDate();
	var mm_a = today.getMonth()+1; //January is 0!
	var mm_d = today.getMonth()+2; //January is 0!
	var yyyy = today.getFullYear();
	if(dd<10){
	    dd='0'+dd;
	}
	if(mm_a<10){
	    mm_a='0'+mm_a;
	}

	if(mm_d<10){
	    mm_d='0'+mm_d;
	}
	var today = dd+'/'+mm_a+'/'+yyyy;
	var depart = dd+'/'+mm_d+'/'+yyyy;

	  $("#date_arrivee").val(today);
	  $("#date_depart").val(depart);



$("#prix").change(function(){

    var prix = $("#prix").val();
    $("#prixValue").text('Prix : ' + prix + ' € max');


})



$("#sel1").change(function(){
    var capacite = $("#sel1").val();
    window.location="boutique.php?capacite="+capacite;
})
</script>
