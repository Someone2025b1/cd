<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$QueryPorcentaje = mysqli_query($db, "SELECT PC_PORCENTAJE FROM Bodega.PORCENTAJE_COMISION WHERE PC_CODIGO = 1");
$FilaPorcentaje = mysqli_fetch_array($QueryPorcentaje);

$Porcentaje = $FilaPorcentaje["PC_PORCENTAJE"];

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

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Comisión Venta</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Porcentaje de Comisión de Venta</strong></h4>
						</div>
						<div class="card-body">
							<div class="col-lg-12">
								<div class="col-lg-3">
									<label for="PorcentajeComision">Porcentaje Comisión</label>
									<input type="number" step="any" class="form-control" name="PorcentajeComision" id="PorcentajeComision" required value="<?php echo $Porcentaje ?>">
								</div>
							</div>
							<div class="col-lg-12 text-center">
								<button type="button" class="btn btn-primary" onclick="ActualizarPorcentaje()">Guardar</button>
							</div>
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

		<script>
			function ActualizarPorcentaje()
			{
				var Porcentaje = $('#PorcentajeComision').val();

				if(Porcentaje == '')
				{
					alert('El porcentaje no debe estar vacío');
				}
				else
				{
					$.ajax({
							url: 'ActualizarPorcentaje.php',
							type: 'post',
							data: 'Porcentaje='+Porcentaje,
							success: function (data) {
								if(data == 1)
								{
									window.location.reload();
								}
								else
								{
									alertify.error('No se puede actualizar el porcentaje');
								}
							}
						});
				}
			}
		</script>

	</body>
	</html>
