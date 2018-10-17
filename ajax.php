<?php require_once('inc/init.inc.php');

  if(empty($_GET)){
    $donnees = executeRequete("SELECT DISTINCT * FROM salle, produit WHERE salle.id_salle = produit.id_salle");
  }
  else{
    $donnees = executeRequete("SELECT DISTINCT * FROM salle, produit WHERE
      salle.id_salle = produit.id_salle AND
      salle.categorie = :categorie AND
      salle.capacite >= :capacite AND
      salle.ville = :ville AND
      produit.prix <= :prix AND
      produit.date_arrivee >= :date_arrivee AND
      produit.date_depart > :date_depart
      ",array(
        ':categorie' => $_GET['categorie'],
        ':capacite' => $_GET['capacite'],
        ':ville' => $_GET['ville'],
        ':prix' => $_GET['prix'],
        ':date_arrivee' => $_GET['date_arrivee'],
        ':date_depart' => $_GET['date_depart']
      ));
  }

  $contenu_gauche .= 'Il y a ' . $donnees->rowCount() . ' résultats';

  while ($produit = $donnees->fetch(PDO::FETCH_ASSOC)) {
  //	 debug($produit);
  	$contenu_droite .= '<div class="col-sm-4">';
  		$contenu_droite .= '<div class="thumbnail">';
  			// image cliquable :
  			$contenu_droite .= '<a href="fiche_produit.php?id_produit='. $produit['id_produit'] .'"><img src="'. $produit['photo'] .'" width="60" height="60"></a>';

  			// les infos du produit :
  			$contenu_droite .= '<div class="caption">';
  				$contenu_droite .= '<h4 class="pull-right">'. $produit['prix'] .' €</h4>';
  				$contenu_droite .= '<h4>'. $produit['titre'] .'</h4>';
  				$contenu_droite .= '<h4>'. $produit['ville'] .'</h4>';
  				$contenu_droite .= '<p>'. $produit['description'] .'</p>';
  				$contenu_droite .= '<p>'. $produit['date_arrivee'] .' au '. $produit['date_depart'] .'</p>';
  			$contenu_droite .= '</div>';  // .caption
  		$contenu_droite .= '</div>'; // .thumbnail
  	$contenu_droite .= '</div>';  // .col-sm-4
  }

  echo $contenu_droite;



?>
