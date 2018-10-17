<?php

require_once("inc/init.inc.php");

//------------------ AFFICHAGE -----------------------


require_once("inc/haut.inc.php");

?>


          <div class="col-lg-12">
      <div class="row" style="width:900px height=350px">
        <?php echo $contenu_droite; ?>

<div id="carousel" class="carousel slide" data-ride="carousel">
    <!-- Menu -->
    <ol class="carousel-indicators">
        <li data-target="#carousel" data-slide-to="0" class="active"></li>
        <li data-target="#carousel" data-slide-to="1"></li>
        <li data-target="#carousel" data-slide-to="2"></li>
    </ol>

    <!-- Items -->
    <div class="carousel-inner">

        <div class="item active">
            <img src="img/paris.jpg" alt="Slide 1" class="img-responsive" width="100%" />
        </div>
        <div class="item">
            <img src="img/lyon.jpg" alt="Slide 2" class="img-responsive" width="100%" />
        </div>
        <div class="item">
            <img src="img/marseille.jpg" alt="Slide 3"class="img-responsive" width="100%" />
        </div>
    </div>
    <a href="#carousel" class="left carousel-control" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a href="#carousel" class="right carousel-control" data-slide="next">
     <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
 </div>
</div>

                	<h1>Qui sommes-nous</h1>

					<p> <strong> Sallea </strong>est une société proposant la location de salles de réunion,bureau et formation à ses clients.</p>

					Adresse : 300 Boulevard de Vaugirard, 75015 Paris, France

					<p>Mission : La société est spécialisée dans la location de salle pour l’organisation de réunions par les entreprises ou les particuliers.</p>

					<p>Périmètre géographique de l’activité : La société dispose de salles de <strong>réunions,bureaux et formations à Paris, Lyon et Marseille.</strong></p>

					<p>Objectifs : L'enjeu est d’attribuer plusieurs périodes de location sur chacune des salles, ce qui nous donnera plusieurs produits.</p>

        </div>
        <br>

    <div class="row">

      <div class="col-md-12">

              <div class="col-md-4">

                <img src="img/form6.jpg" class="img-responsive img-thumbnail" width="100%" />
                <h6><em>Salle de Fromation</em></h6>
              </div>

              <div class="col-md-4">

                <img src="img/reu5.jpg"  class="img-responsive img-thumbnail" width="100%" />
                <h6><em>Salle de Reunion</em></h6>
              </div>

              <div class="col-md-4">

                <img src="img/bur1.jpg"  class="img-responsive img-thumbnail" width="100%" />
                <h6><em>Bureau</em></h6>
              </div>
      </div>

      </div>
      <!-- /.row -->


<?php

require_once('inc/bas.inc.php');
