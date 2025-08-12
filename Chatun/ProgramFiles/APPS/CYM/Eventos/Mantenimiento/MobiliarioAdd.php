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
				<h1 class="text-center"><strong>Mantenimiento de Mobiliario</strong><br></h1>
				<br>
				<form class="form" action="MobiliarioAddPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Mobiliario</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Nombre" id="Nombre" required/>
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<label for="CategoriaMobiliario">Categoría Mobiliario</label>
										<select class="form-control" name="CategoriaMobiliario" id="CategoriaMobiliario" required>
											<option value="" disabled selected>SELECCIONE UNA OPCION</option>
											<?php
												$QueryTM = mysqli_query($db, "SELECT * FROM Bodega.CATEGORIA_MOBILIARIO WHERE CM_ESTADO = 1 ORDER BY CM_NOMBRE");
												while($FilaTM = mysqli_fetch_array($QueryTM))
												{
													?>
														<option value="<?php echo $FilaTM[CM_CODIGO] ?>"><?php echo $FilaTM[CM_NOMBRE] ?></option>
													<?php
												}
											?>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<label for="TipoMobiliario">Tipo Mobiliario</label>
										<select class="form-control" name="TipoMobiliario" id="TipoMobiliario" required>
											<option value="" disabled selected>SELECCIONE UNA OPCION</option>
											<?php
												$QueryTM = mysqli_query($db, "SELECT * FROM Bodega.TIPO_MOBILIARIO WHERE TM_ESTADO = 1 ORDER BY TM_NOMBRE");
												while($FilaTM = mysqli_fetch_array($QueryTM))
												{
													?>
														<option value="<?php echo $FilaTM[TM_CODIGO] ?>"><?php echo $FilaTM[TM_NOMBRE] ?></option>
													<?php
												}
											?>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="number" step="any" name="Disponibilidad" id="Disponibilidad" required/>
											<label for="Disponibilidad">Disponibilidad Total</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="number" step="any" name="PrecioUnitario" id="PrecioUnitario" required/>
											<label for="PrecioUnitario">Precio Unitario</label>
										</div>
									</div>
								</div> 
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
					</div>
					<br>
					<br>
				</form>
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
