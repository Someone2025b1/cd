<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<!-- END META -->
	
    <script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php"); ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Anulación de Factura</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Anulación de Factura</strong></h4>
						</div>
						<div class="card-body">
							<?php

								$Centinela = true;

								$sql = mysqli_query($db, "UPDATE Bodega.FACTURA_RS SET F_ESTADO = 2, F_RAZON_ANULACION = '".$_POST["Razon"]."', F_TOTAL = 0.00 WHERE F_CODIGO = '".$_POST["Codigo"]."'") or die(mysqli_error());
								if(!$sql)
								{
									$Centinela = false;
									
								}

								$sqlDetalle = mysqli_query($db, "DELETE FROM Bodega.FACTURA_RS_DETALLE WHERE F_CODIGO = '".$_POST["Codigo"]."'") or die(mysqli_error());
								if(!$sqlDetalle)
								{
									$Centinela = false;
									
								}

								$Query = "SELECT TRA_CODIGO FROM Bodega.TRANSACCION WHERE F_CODIGO = '".$_POST["Codigo"]."'";
								$Result = mysqli_query($db, $Query);
								while($Fila = mysqli_fetch_array($Result))
								{
									$CodigoFacutra = $Fila["TRA_CODIGO"];
								}

								$QueryDetalle = mysqli_query($db, "DELETE FROM Bodega.TRANSACCION_DETALLE WHERE TRA_CODIGO = '".$CodigoFacutra."'");




								$Consulta = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'FACTURA ANULADA' WHERE TRA_CODIGO = '".$_POST["Codigo"]."'") or die(mysqli_error());
								if(!$Consulta)
								{
									$Centinela = false;
									
								}

								$ConsultaDetalle = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE WHERE TRA_CODIGO = '".$_POST["Codigo"]."'") or die(mysqli_error());
								if(!$ConsultaDetalle)
								{
									$Centinela = false;
									
								}

								if($Centinela == true)
								{
									echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
									<h2 class="text-light">La factura se anuló correctamente.</h2>
									<div class="row">
									</div>';
								}
							?>
						</div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->

			<?php include("../MenuUsers.html"); ?>

		</div><!--end #base-->
		<!-- END BASE -->

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
		<!-- END JAVASCRIPT -->

	</body>
	</html>
