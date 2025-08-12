<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
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
	<!-- END META -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->
	<style>

		.background {
		  
		  height: 100%;
		  width: 100%;
		}
	</style>

</head>
<body onload="setInterval('ObtenerOrdenes()', 5000);">

	<!-- BEGIN BASE-->
	<div style="height: 100%;">

		<!-- BEGIN CONTENT-->
		<div class="background background-filter">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
	 
<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">

			<div class="card">
				<div class="card-body no-padding">
					<div class="margin-bottom-xxl">
						<h1 class="text-dark text-ultra-bold text-xxl text-light text-center no-margin">¡ORDENES LISTAS!</h1>
					</div>
					<ul class="list ui-sortable">
				
					<?php
					$Contador = 1;
					$QueryOrdenes = mysqli_query($db,"SELECT A.F_CODIGO, A.F_ORDEN, A.F_OBSERVACIONES
													FROM Bodega.FACTURA AS A 
													WHERE A.F_DESPACHADA <> 1
													AND A.F_REALIZADA = 1 AND A.F_FECHA_TRANS = CURRENT_DATE()
													ORDER BY A.F_ORDEN ASC");
					while($FilaOrdenes = mysqli_fetch_array($QueryOrdenes))
					{
						?>
							<li class="tile ui-sortable-handle text-center">
								<strong> <h3 class="text-warning text-xxxxl"><span class="text-warning fa fa-check"></span> ORDEN #<?php echo $FilaOrdenes["F_ORDEN"] ?></h3></strong>
							</li>
						<?php
					}
					$QueryOrdenes = mysqli_query($db,"SELECT A.F_CODIGO, A.F_ORDEN, A.F_OBSERVACIONES
													FROM Bodega.FACTURA_2 AS A 
													WHERE A.F_DESPACHADA <> 1
													AND A.F_REALIZADA = 1 AND A.F_FECHA_TRANS = CURRENT_DATE()
													ORDER BY A.F_ORDEN ASC");
					while($FilaOrdenes = mysqli_fetch_array($QueryOrdenes))
					{
						?>
							<li class="tile ui-sortable-handle text-center">
								<strong> <h3 class="text-warning text-xxxxl"><span class="text-warning fa fa-check"></span> ORDEN Caja No.2 #<?php echo $FilaOrdenes["F_ORDEN"] ?></h3></strong>
							</li>
						<?php
					}
					?>
					</ul>
				</div>
			</div>
		</div>
</div>
			</div>
			<div class="col-lg-3"></div>
		</div>
		<!-- END CONTENT -->
	

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
		function ObtenerOrdenes()
		{
			location.reload();
		}
		function Realizar(x)
		{
			$.ajax({
					url: 'RealizarOrden_Listas.php',
					type: 'post',
					data: 'Orden='+x,
					success: function (data) {
						ObtenerOrdenes();
					}
				});
		}
	</script>

	</body>
	</html>
