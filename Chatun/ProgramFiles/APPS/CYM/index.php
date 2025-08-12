<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
include("../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
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
		<link type="text/css" rel="stylesheet" href="../../../css/theme-4/bootstrap.css" />
		<link type="text/css" rel="stylesheet" href="../../../css/theme-4/materialadmin.css" />
		<link type="text/css" rel="stylesheet" href="../../../css/theme-4/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="../../../css/theme-4/material-design-iconic-font.min.css" />
		<!-- END STYLESHEETS -->
		<script>
			function Redireccionar()
			{
				var PuestoLaboral = $('#PuestoLaboral').val();

				//Cajero Restaurante
				if(PuestoLaboral == 17)
				{
					window.location.href = "MenuCajeroRestaurante.php";
				}
				else if(PuestoLaboral == 15)
				{
					window.location.href = "MenuCoordinadorAlimentos.php";
				}
				else if(PuestoLaboral == 18)
				{
					window.location.href = "MenuCajeroMultiservicios.php";
				}
				else if(PuestoLaboral == 19)
				{
					window.location.href = "MenuCajeroHelados.php";
				}
				else
				{
					window.location.href = "MenuAdmin.php?id_depto=56";
				}
			}
		</script>
	</head>
	<body class="menubar-hoverable header-fixed menubar-pin " onload="Redireccionar()">

		<?php include("../../MenuTop.php") ?>

		<!-- BEGIN BASE-->
		<div id="base">
			<!-- BEGIN CONTENT-->
			<div id="content" style="margin-left: -125px">
				<div class="content-fluid text-right">
				<br>
				<button type="button" class="btn ink-reaction btn-primary">
					<i class="fa fa-chevron-left"> <a href="../../index.php">Regresar</a></i>
				</button>
				<br>
				<br>
			</div>
				<input type="hidden" id="PuestoLaboral" value="<?php echo saber_puesto($id_user); ?>" />
			</div><!--end #content-->
			<!-- END CONTENT -->

		</div><!--end #base-->
		<!-- END BASE -->

		<!-- BEGIN JAVASCRIPT -->
		<script src="../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../../../js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../../js/libs/spin.js/spin.min.js"></script>
		<script src="../../../js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
		<script src="../../../js/core/source/App.js"></script>
		<script src="../../../js/core/source/AppNavigation.js"></script>
		<script src="../../../js/core/source/AppOffcanvas.js"></script>
		<script src="../../../js/core/source/AppCard.js"></script>
		<script src="../../../js/core/source/AppForm.js"></script>
		<script src="../../../js/core/source/AppNavSearch.js"></script>
		<script src="../../../js/core/source/AppVendor.js"></script>
		<script src="../../../js/core/demo/Demo.js"></script>
		<!-- END JAVASCRIPT -->

	</body>
</html>
