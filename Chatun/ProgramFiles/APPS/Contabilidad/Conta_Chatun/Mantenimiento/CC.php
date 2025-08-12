<?php
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
	

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Modificar un Cierre de Caja</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Cierres</strong></h4>
						</div>
						<div class="card-body">
							<form class="form" action="CCMod.php" method="POST" role="form">
								<div class="row">
									<div class="col-lg-2 floating-label">
										<div class="form-group">
										<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" required/>
											<label for="Fecha">Fecha de Cierre</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4 floating-label">
										<div class="form-group">
											<select name="PuntoVenta" id="PuntoVenta" required class="form-control">
												<option value="" disabled selected>Seleccione una Opción</option>
												<option value="1">Las Terrazas</option>
												<option value="20">Las Terrazas #2</option>
												<option value="2">Souvenirs</option>
												<option value="22">Pizzería</option>
												<option value="3">Helados</option>
												<option value="4">Café Los Abuelos</option>
												<option value="6">Kiosko Azados</option>
												<option value="5">Taquilla</option>
												<option value="7">Mirador</option>
												<option value="8">Eventos</option> 
												<option value="9">Tilapia</option>
												<option value="11">Kiosko Oasis</option>
												<option value="10">Juegos</option>
												<option value="17">Souvenirs #2</option>
												<option value="15">Taquilla #2</option>
												<option value="16">Taquilla #3</option>
												<option value="19">Taquilla #4</option>
												<option value="18">Kiosko Pasillo</option>

											</select>
											<label for="PuntoVenta">Punto de Venta</label>
										</div>
									</div>
								</div> 
								<div class="col-lg-12" align="center">
									<button type="submit" class="btn ink-reaction btn-raised btn-primary">Consultar</button>
								</div>
							</form>
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
