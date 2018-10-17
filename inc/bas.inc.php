 </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-4">
                    <p><a href="../cgv.php">Conditions générales de ventes</a></p>
                </div>

                <div class="col-lg-4">
                    <p>Copyright &copy; SALLEA - 2018</p>
                </div>

                <div class="col-lg-4">
                    <p><a href="../mentions.php">Mentions légales</a></p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

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
<script src="inc/js/datepicker-fr.js"></script>
<script>

		$(function(){
			$("#date_arrivee").datepicker({
				dateFormat: "dd-mm-yy",
				minDate:1
			});
			// quand on change de date, on l'affiche dans un alert :
			$("#date_arrivee").change(function(){
				var dateA = $("#date_arrivee").val();

			});

			$("#date_depart").datepicker({
				dateFormat: "dd-mm-yy",
				minDate:1
			});
			// quand on change de date, on l'affiche dans un alert :
			$("#date_depart").change(function(){
				var dateD = $("#date_depart").val();

			});


		});

$(function(){

// Script Range

    $('.range').jRange({
        from: 0,
        to: 100,
        step: 1,
        scale: [0,25,50,75,100],
        format: '%s',
        width: 250,
        showLabels: true,
        isRange : true
    });

});
</script>

</body>

</html>
