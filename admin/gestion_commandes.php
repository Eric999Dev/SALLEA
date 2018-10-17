<?php

require_once("../inc/init.inc.php");

// 1- Vérification si Admin :
if(!userConnectAdmin())
{
	header("location:../connexion.php");
	exit();
}

// Suppression d'une commande :

if(isset($_GET['action']) && $_GET['action'] == "supprimer_commande" && isset($_GET['id_commande']))
{
		executeRequete("DELETE FROM commande WHERE id_commande = :id_commande", array(':id_commande' => $_GET['id_commande']));

	}


// Affichage du tableau :
$resultat = executeRequete("SELECT c.id_commande, m.id_membre, p.id_produit, p.prix, c.date_enregistrement
                            FROM commande c, membre m, produit p
                            WHERE c.id_membre = m.id_membre AND c.id_produit = p.id_produit"); // On obtient un objet PDOStatement

$contenu = '<h3> Commande </h3>';

$contenu .=  '<table class="col-md-12 table-bordered table-striped table-condensed cf">';
$contenu .=  '<tr>';
		// Affichage des entêtes :
		for($i = 0; $i < $resultat->columnCount(); $i++)
		{
			$champs = $resultat->getColumnMeta($i);  // Retourne les métadonnées pour une colonne dans le jeu de résultats $resultat sous forme de tableau
			// debug($colonne);  // on y trouve l'indice "name"
			$contenu .= '<th>' . $champs['name'] . '</th>';
		}

		$contenu .=  '<th> Supprimer </th>';
		$contenu .=  '</tr>';

		// Affichage des lignes :
		while ($commande = $resultat->fetch(PDO::FETCH_ASSOC))
		{
			$contenu .=  '<tr>';
				foreach ($commande as $indice => $information)
				{
					$contenu .=  '<td>' . $information . '</td>';
				}
				$contenu .=  '<td><a href="?action=supprimer_commande&id_commande=' . $commande['id_commande'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette commande?\'));"> <i class="glyphicon glyphicon-trash"></i> </a></td>';
			   $contenu .=  '</tr>';
		}
$contenu .=  '</table>';


//---------------------- Affichage -------------------//
require_once("../inc/haut.inc.php");
echo $contenu;
require_once("../inc/bas.inc.php");
