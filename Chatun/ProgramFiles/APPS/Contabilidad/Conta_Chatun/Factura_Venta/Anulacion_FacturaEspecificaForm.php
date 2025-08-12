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


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<?php
			if (saber_puesto($id_user)==4 | saber_puesto($id_user)==31){
				?>
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Anular Factura Especifica</strong></h4>
							</div>
							<div class="card-body">
							<?php
								
									
									?>
									<form action="Anulacion_FacturaEspecifica.php" method="POST">
										<div class="row">
											<div class="col-lg-6">
												<label for="FechaCertificacionCompleta">Fecha Certificacion</label>
												<input type="text" name="FechaCertificacionCompleta" id="FechaCertificacionCompleta" class="form-control" placeholder="Fecha Completa incluida la Hora, sin espacios como en la factura" required>
											</div>
										</div>
										<div class="row">
										<div class="col-lg-6">
												<label for="NumeroAutorizacion">Autorizacion</label>
												<input type="text" name="NumeroAutorizacion" id="NumeroAutorizacion" class="form-control" placeholder="Sin Espacios" required >
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3">
												<label for="NIT">NIT Receptor</label>
												<input type="text" name="NIT" id="NIT" class="form-control" required>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<label for="Observaciones">Observaciones</label>
												<input type="text" name="Observaciones" id="Observaciones" class="form-control" required >
											</div>
										</div>
										<div class="row text-center">
											<button type="submit" class="btn btn-success">Guardar</button>
										</div>
									</form>	

							</div>
						</div>
						
					</div>
					<?php
					}else{
						echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo Actualizar el Evento devido a que su Usuario no esta 
									Autorizado.</h2>
								</div>';

						

					}
					?>
<?php include("../MenuUsers.html"); ?>
			</div>
		</div>
		<!-- END CONTENT -->

	
		
		
	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
