<?php
require_once('../inc/init.inc.php');
$top5salles='';
$top5comm='';
$top5mbr='';
$top5prix='';
//-----------TRAITEMENT---------------

//1- On vérifie que le membre est admin :
    if(!userConnectAdmin()) {
        header('location:../connexion.php');
        exit();
    }



    if(isset($_GET['action']) && $_GET['action'] == "show"){

        $resultat = executeRequete("SELECT *, ROUND(AVG(note),2) AS note_moyenne FROM avis LEFT JOIN salle ON avis.id_salle = salle.id_salle GROUP BY avis.id_salle ORDER BY note_moyenne DESC LIMIT 0,5");

        $top5salles.='<br> <p class="text-primary">Les salles les mieux notées sont : </p><br>';
        $top5salles.='<ol>';

        while ($stat = $resultat->fetch(PDO::FETCH_ASSOC)){

            $top5salles.= '<li class="text-info"> La salle '.$stat['titre'].' ~ ID : '.$stat['id_salle'].'<br>Note : '.$stat['note_moyenne'].' étoile(s).</li>';

        }
     $top5salles.='</ol>';

    }

    if(isset($_GET['action']) && $_GET['action'] == "show1"){

        $resultat = executeRequete("SELECT s.titre,s.id_salle, COUNT(s.id_salle) AS nb_cmd_par_salle FROM commande c, produit p, salle s WHERE c.id_produit = p.id_produit AND p.id_salle = s.id_salle GROUP BY s.id_salle ORDER BY nb_cmd_par_salle DESC LIMIT 0,5");

        $top5comm.='<br> <p class="text-primary">Les salles les plus commandées sont : </p><br>';
        $top5comm.='<ol>';

        while ($stat = $resultat->fetch(PDO::FETCH_ASSOC)){

            $top5comm.= '<li class="text-info">'.$stat['titre'].' ~ ID : '.$stat['nb_cmd_par_salle'].'</li>';

        }
     $top5comm.='</ol>';

    }

    if(isset($_GET['action']) && $_GET['action'] == "show2"){

        $resultat = executeRequete("SELECT m.prenom, m.nom, m.pseudo, COUNT(c.id_membre) AS nb_cmd_par_membre FROM commande c, membre m WHERE c.id_membre = m.id_membre GROUP BY c.id_membre ORDER BY nb_cmd_par_membre DESC LIMIT 0,5");

        $top5mbr.='<br><p class="text-primary"> Les membres achetant le plus (en quantité) sont : </p><br>';
        $top5mbr.='<ol>';

        while ($stat = $resultat->fetch(PDO::FETCH_ASSOC)){

            $top5mbr.= '<li class="text-info">'.$stat['nom'].' '.$stat['prenom'].'</li>';

        }
     $top5mbr.='</ol>';

    }
    if(isset($_GET['action']) && $_GET['action'] == "show3"){

        $resultat = executeRequete("SELECT m.prenom, m.nom, m.pseudo, SUM(p.prix) AS valeur_de_cde_par_membre FROM commande c, membre m, produit p WHERE c.id_membre = m.id_membre AND c.id_produit = p.id_produit GROUP BY c.id_membre ORDER BY valeur_de_cde_par_membre DESC LIMIT 0,5");

        $top5prix.='<br> <p class="text-primary">Les membres qui achètent le plus cher sont : </p><br>';
        $top5prix.='<ol>';

        while ($stat = $resultat->fetch(PDO::FETCH_ASSOC)){

            $top5prix.= '<li class="text-info">'.$stat['nom'].' '.$stat['prenom'].'</li>';

        }
     $top5prix.='</ol>';

    }



//---------------------- AFFICHAGE -----------------
require_once('../inc/haut.inc.php')
?>

<br><br>
<div class="row">
<h3 class="text-center text-primary" id="modifPr">Statistiques</h3><br>
<div class="col-sm-5">
<a href="?action=show" class="btn btn-info" role="button">Top 5 des salles les mieux notées</a>
<br>
<div><?php echo $top5salles ; ?></div>
<br><br>

<a href="?action=show1" class="btn btn-info" role="button">Top 5 des salles les plus commandées</a>
<br>
<div><?php echo $top5comm ; ?></div>
<br><br>

<a href="?action=show2" class="btn btn-info" role="button">Top 5 des membres qui achètent le plus (en quantité)</a>
<br>
<div><?php echo $top5mbr ; ?></div>
<br><br>

<a href="?action=show3" class="btn btn-info" role="button">Top 5 des membres qui achètent le plus cher</a>
<br>
<div><?php echo $top5prix ; ?></div>
</div>
</div>



<?php
require_once('../inc/bas.inc.php');

?>
