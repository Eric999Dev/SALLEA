<?php
require_once("../inc/init.inc.php");

// 1- Vérification si Admin :
if(!userConnect())
{
	header("location:../connexion.php");
	exit();
}

// Suppression d'avis :

if(isset($_GET['action']) && $_GET['action'] == "supprimer_avis" && isset($_GET['id_avis']))
{

		executeRequete("DELETE FROM avis WHERE id_avis=:id_avis", array(':id_avis' => $_GET['id_avis']));

		$contenu .= '<div class="bg-danger"> L\'avis a été supprimé ! </div>';
	}



// Affichage du tableau :
$resultat = executeRequete("SELECT a.id_avis, m.id_membre, s.id_salle, a.commentaire,a.note,a.date_enregistrement
                            FROM avis a, membre m, salle s
                            WHERE a.id_membre = m.id_membre AND a.id_salle = s.id_salle
                            "); // On obtient un objet PDOStatement

$contenu .= '<h3> Avis </h3>';
$contenu .= 'Nombre d\'avis enregistrés : ' . $resultat->rowcount();


$contenu .=  '<table class="col-md-12 table-bordered table-striped table-condensed ">';
$contenu .=  '<tr>';
        // Afficahge des entêtes :
        for($i = 0; $i < $resultat->columnCount(); $i++)
        {
            $champs = $resultat->getColumnMeta($i); // Retourne les métadonnées pour une colonne dans le jeu de résultats $champs sous forme de tableau
          $contenu .= '<th>' . $champs['name'] . '</th>';
        }

   if(userConnectAdmin()){

       $contenu .=  '<th> Supprimer </th>';
                         }
    $contenu .=  '</tr>';

        // Affichage des lignes :

    while($avis = $resultat->fetch(PDO::FETCH_ASSOC))
    {
        $contenu .= '<tr>';
            foreach ($avis as $indice => $information)
            {

							if($indice == 'note'){

								$contenu .= '<td id="etoile">' .$information.'</td>';

							}else{
                 $contenu .=  '<td>' . $information . '</td>';
							 }
            }

           if(userConnectAdmin()){

               $contenu .=  '<td><a href="?action=supprimer_avis&id_avis=' . $avis['id_avis'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cet avis?\'));"> <i class="glyphicon glyphicon-trash"></i> </a></td>';
           }
        $contenu .=  '</tr>';
    }
$contenu .=  '</table>';




//---------------------- Affichage -------------------//

require_once("../inc/haut.inc.php");
echo $contenu;

require_once("../inc/bas.inc.php");
?>

<!--etoiles-->
<script src="<?php echo RACINE_SITE . 'inc/js/jquery.barrating.min.js';?>"></script>
<script type="text/javascript">
   $(function() {
      $('#etoile').barrating({
        theme: 'fontawesome-stars'
      });
   });

</script>
