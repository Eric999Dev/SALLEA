<?php
require_once('inc/init.inc.php');
$suggestion = '';
$btncommande='';
$avis='';
if (isset($_GET['id_produit'])) {

$resultat = executeRequete("SELECT p.id_produit, s.photo ,s.adresse, s.titre, s.categorie, s.cp, s.ville, s.capacite,p.etat, p.prix, s.description, s.id_salle,p.date_arrivee,p.date_depart, ROUND(AVG(a.note),1)AS note
                           FROM produit p
                           JOIN salle s ON s.id_salle=p.id_salle
                           LEFT JOIN avis a ON s.id_salle=a.id_salle
                           WHERE p.etat = 'libre' AND p.id_produit=:id_produit", array(':id_produit'=> $_GET['id_produit']));

if ($resultat->rowCount() == 0){
    header('location:index.php');
    exit();
}

$produit= $resultat->fetch(PDO::FETCH_ASSOC);
extract($produit);
if ($etat =='libre' && userConnect()){ // affichage ou non btn si libre ou reservé
        $btncommande.='<form class="text-right" method="post" action="">
        <input type="hidden" name="id_produit" value="'. $_GET['id_produit'] .'">
        <input type="submit" value="Réserver" name="reserver" class="btn btn-info">
        </form>';
        $avis .= '<a href="avis.php?id_salle='. $produit['id_salle'] .'"><button class="btn btn-info" type="button"><i class="icon icon-check icon-lg"></i> Déposer un commentaire & une note</button></a>';
} else {
    $btncommande.='<div class="text-right" ><a class="btn btn-primary" href="connexion.php" role="button">Connectez-vous</a></div>';
    $avis.='<a class="btn btn-primary" href="connexion.php" role="button">Connectez-vous</a>';

}



    if(isset($_POST['reserver'])){

       executeRequete("INSERT INTO commande (id_commande,id_membre, id_produit, date_enregistrement)
                                    VALUES (NULL, :id_membre, :id_produit, NOW())",
                                    array (
                                        ':id_membre'    => $_SESSION['membre']['id_membre'],
                                        ':id_produit'   => $id_produit));
       executeRequete("UPDATE produit SET etat = :etat WHERE id_produit = :id_produit", array(
        ':etat' => 'reservation',
        ':id_produit' => $_POST['id_produit']
    ));

$btncommande.='<div class="bg-success text-center">Votre commande a été prise en compte, nous vous en remercions.<br> Vous retrouverez cette commande sur votre profil.</div>';
    }

 } // fin if isset

 $requete = executeRequete("SELECT DISTINCT id_produit,titre,photo FROM salle, produit WHERE categorie = :categorie AND id_produit <> :id_produit AND salle.id_salle = produit.id_salle AND produit.etat = 'libre' ORDER BY RAND() LIMIT 4", array( ':categorie' => $produit['categorie'], ':id_produit' => $_GET['id_produit']));

 $suggestion .= '<div class="row">';
while ($produit_associes = $requete->fetch(PDO::FETCH_ASSOC)) {


	$suggestion .= '<div class="col-sm-3">';
		$suggestion .= '<a href="fiche_produit.php?id_produit='. $produit_associes['id_produit'] .'">
							<img src="'. $produit_associes['photo'] .'" class="img-thumbnail">
						</a>';
		$suggestion .= '<h6>'. $produit_associes['titre'] .'</h6>';
    $suggestion .= '</div>';


}
$suggestion .= '</div>';


//---------------------- AFFICHAGE -----------------
require_once('inc/haut.inc.php');

echo $contenu_droite;
echo $btncommande;
?>

   <div class="row ">
       <div class="col-sm-6">
            <h3><?php echo $titre ?> </h3>
            <p><?php echo $note?></p>
        </div>
    </div>
<div class="row">
    <div class="col-sm-8">
        <img class="card-img-top img-responsive" src="<?php echo $photo ?>">
    </div>
    <div class="col-sm-4">
        <p><strong>Description : </strong></p>
        <p><?php echo $description ?></p>
        <p><strong>Localisation : </strong></p>
        <iframe class="border border-primary embed-responsive-item" src="https://www.google.com/maps/embed/v1/place?key= AIzaSyDAMN8GzF4qd27_kym1YkoVl9rv7x5ApuE&q=<?= $adresse; ?>+<?= $ville; ?>" allowfullscreen width="400" height="350"></iframe>
    </div>
</div>

<div class="row ">

       <div class="col-sm-6">
            <br>
            <p><strong>Informations complémentaires : </strong></p>
       </div>
</div>
<div class="row ">
    <div class="col-sm-4">
        <p class="text-muted"><span class="glyphicon glyphicon-calendar" width="10" height="10"></span> <?php echo $date_arrivee?> </small></p>
        <p class="text-muted"><span class="glyphicon glyphicon-calendar" width="10" height="10"></span> <?php echo $date_depart?> </small></p>
    </div>
    <div class="col-sm-4">
        <p><span class="glyphicon glyphicon-user" width="10" height="10"></span> Capacité : <?php echo $capacite?></p>
        <p><span class="glyphicon glyphicon-list" width="10" height="10"></span> Catégorie : <?php echo $categorie?></p>
    </div>
    <div class="col-sm-4">
        <p><span class="glyphicon glyphicon-map-marker" width="10" height="10"></span> Adresse : <?php echo $adresse . ' - ' .$cp. ' - ' .$ville?></p>
        <h5><i class="glyphicon glyphicon-eur"></i> Tarif : <?php echo $prix?> €</h5>
    </div>
</div>


<div class="row">
		<div class="col-lg-6">
			<h5><em>Autres produits de même catégorie<em></h5>
		</div>
</div>
		<?= $suggestion; ?>


       <br><br>
            <?php

       echo $avis;

            ?>

<?php
require_once('inc/bas.inc.php');
