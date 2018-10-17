<?php require_once('init.inc.php');


// Requête concernant les produit à afficher :

//  debug('CUIcUI');
$categorie = true; // pour que la requête SQL fonctionne par défaut en sélectionnant tous les produits.
$ville = true;
$capacite = true;
$prix = true;
$date_a = true;
$date_d = true;

if(!empty($_POST)) {
  if(isset($_POST['categorie'])) {
    $categorie = "categorie IN ('" . implode("','", $_POST['categorie']) . "')";
    //debug($categorie);
  }
  if(isset($_POST['ville'])) {
    $ville = "ville IN('" . implode("','", $_POST['ville']) . "')";
    //debug($ville);
  }
  if(isset($_POST['capacite'])) {
    $capacite = $_POST['capacite'];
  }
  if(isset($_POST['prix'])) {
    $prix = $_POST['prix'];
  }

  if(isset($_POST['date_arrivee'])) {
    if(!empty($_POST['date_arrivee'])) {
      $date_a = DateTime::createFromFormat('d-m-Y', $_POST['date_arrivee'])->format('Y-m-d H:i:s');
    } else {
      $date_a = date("Y-m-d H:i:s");
    }
  }
  if(isset($_POST['date_depart'])) {
    if(!empty($_POST['date_depart'])) {
      $date_d = DateTime::createFromFormat('d-m-Y', $_POST['date_depart'])->format('Y-m-d H:i:s');
    } else {
      $date_d = '3000-31-12 19:00:00';
    }
  }
} // fin du if(!empty($_POST))


    $donnees = executeRequete("SELECT * FROM salle, produit
      WHERE salle.id_salle = produit.id_salle
      AND $categorie
      AND salle.capacite <= :capacite
      AND $ville
      AND produit.prix <= :prix
      AND produit.date_arrivee >= :date_arrivee
      AND produit.date_depart <= :date_depart
      AND produit.etat = 'libre'
      GROUP BY produit.id_produit
      ",
      array(
        ':capacite' => $capacite,
        ':prix' => $prix,
        ':date_arrivee' => $date_a,
        ':date_depart' => $date_d
      ));


// Affichage des produits :
  $contenu_droite .= '<div class="col-md-12">Il y a ' . $donnees->rowCount() . ' résultats</div>';
  while ($produit = $donnees->fetch(PDO::FETCH_ASSOC)) {

//debug($produit);
    // Réduction de caractère pour la description :
    $description = substr($produit['description'],0,35);

    // Changement du format de la date :
    $date_a = new DateTime($produit['date_arrivee']);
    $date_d = new DateTime($produit['date_depart']);
    $date_a = $date_a->format('d-m-Y');
    $date_d = $date_d->format('d-m-Y');


  	$contenu_droite .= '<div class="col-md-4" style="height: 430px;">';
  		$contenu_droite .= '<div class="thumbnail">';
  			// image cliquable :
  			$contenu_droite .= '<a href="fiche_produit.php?id_produit='. $produit['id_produit'] .'"><img src="'. $produit['photo'] .'" width="60" height="60"></a>';

  			// les infos du produit :
  			$contenu_droite .= '<div class="caption" style="height: 200px;">';
  				$contenu_droite .= '<h4 class="pull-right">'. $produit['prix'] .' €</h4>';
  				$contenu_droite .= '<h4>'. $produit['titre'] .'</h4>';
  				$contenu_droite .= '<h4>'. $produit['ville'] .'</h4>';
  				$contenu_droite .= '<p>'. $description .'...</p>';
  				$contenu_droite .= '<p><span class="glyphicon glyphicon-calendar" width="10" height="10"></span> '. $date_a .' au '. $date_d .'</p>';
          $contenu_droite .= '<a href="fiche_produit.php?id_produit='. $produit['id_produit'] .'" class="pull-right"><i class="glyphicon glyphicon-search"></i></a>';
  			$contenu_droite .= '</div>';  // .caption
  		$contenu_droite .= '</div>'; // .thumbnail
  	$contenu_droite .= '</div>';  // .col-md-4

  }



  echo $contenu_droite;



?>
