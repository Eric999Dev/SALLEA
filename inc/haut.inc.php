<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

	<title>SALLEA</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo RACINE_SITE . 'inc/css/bootstrap.min.css';  ?>" rel="stylesheet">

    <!-- Custom CSS -->
	<link href="<?php echo RACINE_SITE . 'inc/css/shop-homepage.css';  ?>" rel="stylesheet">

	<link href="<?php echo RACINE_SITE . 'inc/css/jquery.range.css';  ?>" rel="stylesheet">




	<!-- AJOUTER LE LIEN CSS SUIVANT POUR LE DETAIL PRODUIT-->
    <link href="<?php echo RACINE_SITE . 'inc/css/portfolio-item.css';  ?>" rel="stylesheet">

    <link href="<?php echo RACINE_SITE . 'inc/css/fontawesome-stars.css';  ?>" rel="stylesheet">

    <!--etoiles-->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">



	<!-- jQuery -->
	<script src="<?php echo RACINE_SITE . 'inc/js/jquery.js'; ?>"></script>

	<!-- jQuery datepicker-->
	<script src="<?php echo RACINE_SITE .  'inc/js/datepicker-fr.js' ;?>"></script>

	<!-- jQuery Range-->
	<script src="<?php echo RACINE_SITE . 'inc/js/jquery.range.js'; ?>"></script>

    <!-- Bootstrap Core JavaScript -->
	<script src="<?php echo RACINE_SITE . 'inc/js/bootstrap.min.js'; ?>"></script>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

			<!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">

				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- La marque -->
				<a class="navbar-brand" href="<?php echo RACINE_SITE . 'index.php'; ?>">SALLEA</a>

		   </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
<!-- le menu de navigation -->
<?php
echo '<li><a href="'. RACINE_SITE .'index.php">Boutique</a></li>';
echo '<li><a href="'. RACINE_SITE .'contact.php">Contact</a></li>';
echo '<li><a href="'. RACINE_SITE .'qui-sommes-nous.php">Qui-Sommes nous</a></li>';

if (userConnect()) {
	// si membre connecté on affiche les liens 'profil' et 'se déconnecter' :
	echo '<li><a href="'. RACINE_SITE .'profil.php"><span class="glyphicon glyphicon-user" width="10" height="10"></span> Mon profil</a></li>';
	echo '<li><a href="'. RACINE_SITE .'connexion.php?action=deconnexion">Se déconnecter</a></li>';
} else {
	// membre non connecté : on affiche les liens 'inscription' et 'connexion' :

	echo '<li><a href="'. RACINE_SITE .'inscription.php">Inscription</a></li>';
	echo '<li><a href="'. RACINE_SITE .'connexion.php">Connexion</a></li>';

}


if (userConnectAdmin()) {
	// Pour l'admin, on ajoute les liens de back-office :
echo '<li>';
 echo '<div class="dropdown">';
 echo '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Administration <span class="caret"></span>';
 echo '</button>';
    echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';
        echo '<li><a href="'. RACINE_SITE .'admin/gestion_salles.php">Gestion salles</a></li>';

        echo '<li><a href="'. RACINE_SITE .'admin/gestion_commandes.php">Gestion commandes</a></li>';

        echo '<li><a href="'. RACINE_SITE .'admin/gestion_membres.php">Gestion membres</a></li>';

        echo '<li><a href="'. RACINE_SITE .'admin/gestion_produits.php">Gestion produits</a></li>';

        echo '<li><a href="'. RACINE_SITE .'admin/gestion_avis.php">Gestion avis</a></li>';

        echo '<li><a href="'. RACINE_SITE .'admin/statistiques.php">Statistiques</a></li>';
  echo '</ul>';
echo '</div>';
echo '</li>';

}
?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div> <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container" style="min-height: 80vh;">
