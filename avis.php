<?php
require_once('inc/init.inc.php');

//-----------TRAITEMENT---------------

//1- On vérifie que le membre est admin :
    if(!userConnect()) {
        header('location:connexion.php');
        exit();
    }

    $contenu='';
    $depotAvis='';
   // 4- Traitement du formulaire : enregistrement du produit
   if (isset($_GET['id_salle'])) {

  	// **************ici il faudrait mettre tous les controles sur le formulaire qu'on ne fait pas ... (cf fichier inscription)

    $resultat = executeRequete("SELECT * FROM avis");


   $avis= $resultat->fetch(PDO::FETCH_ASSOC);


       //Enregistrement des produits en BDD :

       if($_POST){
	   executeRequete("INSERT INTO avis(id_membre,id_salle, commentaire, note, date_enregistrement) VALUES(:id_membre,:id_salle, :commentaire, :note, NOW())",
	  array(

           ':id_membre'         => $_SESSION['membre']['id_membre'],
		   ':id_salle'          => $_GET['id_salle'],
		   ':commentaire'       => $_POST['commentaire'],
           ':note'         	    => $_POST['vote']
		    ));


               $depotAvis .='<div class="bg-success text-center">Votre avis a été pris en compte, nous vous en remercions.</div>';

            }
        }
//debug($_POST);
//---------------------- AFFICHAGE -----------------
require_once('inc/haut.inc.php');
echo $contenu_droite;
echo $depotAvis;

?>
<br><br>
<h3 class="text-center bg-info"  id="modifM">Déposer un avis</h3>
<div class="row">
    <div class= "col align-self-start text-info">
	    <form method="post" action="" enctype="multipart/form-data">

		<input type="hidden" id="id_avis" name="id_avis" value="<?php echo $membre_actuel['id_membre'] ?? 0; ?>">
		<!-- champ caché pour ne pas pouvoir le modifier. Il est utile pour connaitre l'id du produit que l'on est en train de modifier -->

		<label for="pseudo">Pseudo</label><br>
		<input class="form-control" type="text" id="pseudo" name="pseudo" value="<?php echo $_SESSION['membre']['pseudo'] ?? ''; ?>" disabled ><br><br>


        <label for="note">Clickez sur l'étoile de votre choix pour valider votre vote :</label><br>
        <div class="col align-self-center">
        <select id="etoile" name="vote">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br><br>


	<div class= "col align-self-end text-info">
        <label for="commentaire">Commentaire</label><br>
		<textarea class="form-control" id="commentaire" name="commentaire" rows="12" cols="25" style="resize: none;"></textarea><br>


	</div>
    </div>
    <div class= "row">
		<input type="submit" value="valider" class="btn btn-info center-block">
        </div>
        </div>
    </form>
    </div>

	<?php


require_once('inc/bas.inc.php');

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
