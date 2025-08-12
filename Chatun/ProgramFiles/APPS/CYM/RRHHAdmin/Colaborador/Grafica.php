<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- END META -->
	<!-- BEGIN JAVASCRIPT -->
	<script src="../../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../../../js/core/source/App.js"></script>
	<script src="../../../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../../../js/core/source/AppCard.js"></script>
	<script src="../../../../../js/core/source/AppForm.js"></script>
	<script src="../../../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../../../js/core/source/AppVendor.js"></script>
	<script src="../../../../../js/core/demo/Demo.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../../libs/alertify/js/alertify.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importar chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>



  <script src="RGraph/libraries/RGraph.common.core.js" ></script>
    <script src="RGraph/libraries/RGraph.common.tooltips.js" ></script>
    <script src="RGraph/libraries/RGraph.common.dynamic.js" ></script>
    <script src="RGraph/libraries/RGraph.pie.js" ></script>>
<script src="RGraph/libraries/RGraph.radar.js"></script>
</head>

<body>
<?php
// Valores con PHP. Estos podrían venir de una base de datos o de cualquier lugar del servidor
$etiquetas = ["RENDIMINETO", "RESPONSABLIDAD", "IDENTIFICACION CON LA INSTITUCIÓN", "MADUREZ", "RELACIONES INTERPERSONALES",
"DESARROLLO PERSONAL", "PRESENTACIÓN PERSONAL"];
$datosVentas = [16, 20, 12, 16, 16, 8, 12];
$datosVentas2 = [10, 15, 9, 8, 7, 4, 6];
?>
    <!-- BEGIN BASE-->
	<div id="base">

<!-- BEGIN CONTENT-->
<div id="content">
	<div class="container">
		<h1 class="text-center"><strong>EVALUACIÓN DESEMPEÑO</strong><br></h1>
		<br>
		<form action="AgregarColaboradorPro.php" method="POST" class="form" enctype="multipart/form-data">
			<div class="col-lg-12">
				<div class="card">
				<div class="card-body">
    <canvas id="grafica"></canvas>
	<div>
    
    <script type="text/javascript">
        // Obtener una referencia al elemento canvas del DOM
        const $grafica = document.querySelector("#grafica");
        // Pasaamos las etiquetas desde PHP
        const etiquetas = <?php echo json_encode($etiquetas) ?>;
        // Podemos tener varios conjuntos de datos. Comencemos con uno
        const datosVentas2020 = {
            label: "Esperado",
            // Pasar los datos igualmente desde PHP
            data: <?php echo json_encode($datosVentas) ?>,
            backgroundColor: 'rgba(5, 175, 18, 0.2)', // Color de fondo
            borderColor: 'rgba(5, 175, 18, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
        }
		const datosVentas2021 = {
            label: "Colaborador",
            // Pasar los datos igualmente desde PHP
            data: <?php echo json_encode($datosVentas2) ?>,
            backgroundColor: 'rgba(255, 0, 15, 0.2)', // Color de fondo
            borderColor: 'rgba(255, 0, 15, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
        };
        new Chart($grafica, {
            type: 'line', // Tipo de gráfica
            data: {
                labels: etiquetas,
                datasets: [
                    datosVentas2020, datosVentas2021,
                    // Aquí más datos...
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                },
            }
        });
    </script>

	</div>
				</div>
				</div>
			</div>
		</form>
	</div>
</div>
	</div>
	
</body>

</html>