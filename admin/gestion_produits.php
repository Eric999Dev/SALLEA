<?php

require_once("../inc/init.inc.php");

// 1- Vérification si Admin :
if(!userConnectAdmin())
{
	header("location:../connexion.php");
	exit();
}

// 3- Suppression d'un produit :
if(isset($_GET['action']) && $_GET['action'] == "supprimer_produit" && isset($_GET['id_produit']))
{

		executeRequete("DELETE FROM produit WHERE id_produit=:id_produit", array(':id_produit' => $_GET['id_produit']));


}

// 4- Modification produit
// && isset($_GET['id_produit']))

if(isset($_GET['action']) && $_GET['action'] == "modifier_produit"){
if ($_POST){
	$date_a = new DateTime($_POST['date_arrivee']); // Création d'un objet afin de pouvoir le traité avec une méthode objet format
	$date_b = new DateTime($_POST['date_depart']);
	$date_a = $date_a->format('Y-m-d');
	$date_b = $date_b->format('Y-m-d');

		executeRequete("UPDATE produit SET id_salle = :id_salle ,date_arrivee = :date_arrivee, date_depart = :date_depart, prix = :prix WHERE id_produit= :id_produit",
        array(
            ':date_arrivee' => $date_a,
            ':date_depart'  => $date_b,
            ':id_salle'     => $_POST['id_salle'],
            ':prix'         => $_POST['prix'],
            ':id_produit'   => $_GET['id_produit']


        ));

    $contenu .= '<div class="bg-success">Le produit a bien été modifié.</div>';

        }
}

//Ajout du produit

if(isset($_GET['action']) && $_GET['action'] == "ajouter_produit"){
if ($_POST){
$date_a = new DateTime($_POST['date_arrivee']); // Création d'un objet afin de pouvoir le traité avec une méthode objet format
$date_b = new DateTime($_POST['date_depart']);
$date_a = $date_a->format('Y-m-d');
$date_b = $date_b->format('Y-m-d');

		executeRequete("INSERT INTO produit (id_salle, date_arrivee, date_depart, prix, etat) VALUES (:id_salle, :date_arrivee, :date_depart, :prix, :etat)",
        array(

            ':id_salle'     => $_POST['id_salle'],
            ':date_arrivee' => $date_a,
            ':date_depart'  => $date_b,
            ':prix'         => $_POST['prix'],
            ':etat'         => 'libre'

        ));

    $contenu .= '<div class="bg-success">Le produit a bien été ajouté.</div>';

        }
}

if(isset($_GET['action']) && $_GET['action'] == "voir_produit"){
    header('location:../fiche_produit.php');
}


// 2- Préparation de l'affichage
$resultat = executeRequete("SELECT p.*, s.titre, s.photo FROM produit p, salle s
                          WHERE p.id_salle = s.id_salle");


$contenu .= '<h3> Produits </h3><a class="btn btn-primary pull-right" href="?action=ajouter_produit" role="button">Ajouter</a><br>';
$contenu .=  "Nombre de produit(s) : " . $resultat->rowCount();


$contenu .=  '<table class="col-md-12 table-bordered table-striped table-condensed cf">';
               $contenu .= '<tr class="label-default">';
                // Affichage des entêtes :
                    $contenu .=  '<th> Id Produit </th>';
                    $contenu .=  '<th> Date d\'arrivée </th>';
                    $contenu .=  '<th> Date de départ </th>';
                    $contenu .=  '<th> Id Salle </th>';
                    $contenu .=  '<th> Prix </th>';
                    $contenu .=  '<th> Etat </th>';
                    $contenu .=  '<th> Supprimer </th>';
                    $contenu .=  '<th> Modifier </th>';
                    $contenu .=  '<th> Voir </th>';
                $contenu .=  '</tr>';

		// Affichage des lignes :
		while ($produit = $resultat->fetch(PDO::FETCH_ASSOC))
		{

            extract($produit);
						$date_arrivee = new DateTime($date_arrivee);
						$date_depart = new DateTime($date_depart);
						$date_arrivee = $date_arrivee->format('d/m/Y');
						$date_depart = $date_depart->format('d/m/Y');

			$contenu .=  '<tr>';
                $contenu .=  '<td>' . $id_produit . '</td>';
                $contenu .=  '<td>' . $date_arrivee . '</td>';
                $contenu .=  '<td>' . $date_depart . '</td>';
                $contenu .=  '<td><p style="text-align:center;">' . $id_salle.'</p><p style="text-align:center;">'.$titre.'</p><p style="text-align:center;"><img src="'. RACINE_SITE . $photo .'" width="80" height="80"></p></td>';
                $contenu .=  '<td>' . $prix. ' €</td>';
                $contenu .=  '<td>' . $etat. '</td>';
                $contenu .=  '<td><a href="?action=supprimer_produit&id_produit=' . $produit['id_produit'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce produit?\'));"> <i class="glyphicon glyphicon-trash"></i> </a></td>';
                $contenu .=  '<td><a href="?action=modifier_produit&id_produit=' . $produit['id_produit'] .'"> <i class="glyphicon glyphicon-pencil"></i> </a></td>';
                $contenu .=  '<td><a href="../fiche_produit.php?id_produit='. $produit['id_produit'] .'"> <i class="glyphicon glyphicon-search"></i> </a></td>';
            $contenu .=  '</tr>';
		}
$contenu .=  '</table>';


//---------------------- Affichage -------------------//
require_once("../inc/haut.inc.php");
echo $contenu;

// 3- Formulaire HTML : on affiche le formulaire uniquement en action "ajout" ou "modification" de produit :
if (isset($_GET['action']) && ($_GET['action'] == 'modifier_produit' || ($_GET['action'] == 'ajouter_produit' ))):  // syntaxe en if () : ... endif; utile quand on mélange beaucoup de HTML/php dans la condition

// 8- Formulaire de modification de produit :
	if (isset($_GET['id_produit'])) {
		// si id_produit est dans l'url c'est que l'on modifie un produit existant : on requête en BDD les infos du produit à afficher :
		$resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));

		$produit_actuel = $resultat->fetch(PDO::FETCH_ASSOC);  // pas de while car un seul produit

}


?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<script
		src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous">
	</script>

	<script
		src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
		integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
		crossorigin="anonymous">
	</script>

	<script src="datepicker-fr.js"></script>

<h3>Modification d'un produit</h3>

<form method="post" action=""><!-- multipart/form-data spécifie que le formulaire envoie des données texte (champs du formulaire) et des données binaires (= fichier) -->

	<input type="hidden" id="id_produit" name="id_produit" value="<?php echo $produit_actuel['id_produit'] ?? 0; ?>">
	<!-- champ caché pour ne pas pouvoir le modifier. Il est utile pour connaitre l'id du produit que l'on est en train de modifier -->
<div class="input-group">
	<label for="date_arrivee">Date d'arrivée</label><br>
	<input type="text" id="date_arrivee" name="date_arrivee" value="<?php echo $produit_actuel['date_arrivee'] ?? ''; ?>" requierd><br><br>
    </div>

	<label for="date_depart">Date de départ</label><br>
	<input type="text" id="date_depart" name="date_depart" value="<?php echo $produit_actuel['date_depart'] ?? ''; ?>" requierd><br><br>

	<label>Salle</label>
	<select name="id_salle">
		<?php
        $salle2 = executeRequete("SELECT * FROM salle ORDER BY id_salle DESC");
        while($salle= $salle2->fetch(PDO::FETCH_ASSOC)):
        ?>
        <option value="<?php echo $salle['id_salle']; ?>">
        <?php echo $salle['id_salle'].' - '. $salle['titre'].' - '. $salle['adresse'].' - '.$salle['cp'].','.$salle['ville'].' - '.$salle['capacite']. ' '.'personnes';?>
        </option>
        <?php endwhile;
        ?>
	</select><br><br>


	<label for="prix">Tarif</label><br>
	<input type="text" id="prix" name="prix" value="<?php echo $produit_actuel['prix'] ?? ''; ?>" requierd><br><br>

	<input type="submit" value="valider" class="btn btn-success">
	<a href="gestion_produits.php" class="btn btn-warning">Annuler</a>
</form>

<?php
endif;  // ce endif
require_once("../inc/bas.inc.php");
?>
