<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
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
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
			<div class="container">
				<form class="form" action="AperturaPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Apertura de Caja</strong></h4>
							</div>
							<div class="card-body">
								<?php

								$Consulta = "SELECT * FROM Bodega.APERTURA_CIERRE_CAJA WHERE ACC_FECHA = CURRENT_DATE() AND ACC_ESTADO = 1 AND ACC_TIPO = 5";
								$ResultConsulta = mysqli_query($db, $Consulta) or die(mysqli_error());
								$Registros = mysqli_num_rows($ResultConsulta);


								if($Registros == 0)
								{	

									$Query = "SELECT ACC_FECHA FROM Bodega.APERTURA_CIERRE_CAJA WHERE ACC_ESTADO = 1 AND ACC_FECHA < CURRENT_DATE() AND ACC_TIPO = 5";
									$ResultQuery = mysqli_query($db, $Query);
									$RegistrosQuery = mysqli_num_rows($ResultQuery);

									if($RegistrosQuery == 0)
									{
										?>
										<div class="row">
											<div class="col-lg-2">
												<div class="form-group floating-label">
													<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" required readonly/>
													<label for="Fecha">Fecha Apertura</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-2">
												<div class="form-group floating-label">
													<input class="form-control" type="number" step="any" name="MontoInicial" id="MontoInicial" value="1000" required />
													<label for="MontoInicial">Monto de Apertura</label>
												</div>
											</div>
										</div>
										<div class="row">
											<br>
										</div>
										<div class="row">
											<div class="row text-center">
												<button type="submit" class="btn btn-success">
												<span class="glyphicon glyphicon-ok"></span>  Aperturar
												</button>
											</div>
										</div>
										<?php
									}
									else
									{
										?>
											<div class="alert alert-callout alert-success" role="alert">
												Tiene pendiente crear el cierre de caja de al menos un día.
											</div>
										<?php
									}
								}
								elseif($Registros > 0)
								{
									?>
									<div class="alert alert-callout alert-success" role="alert">
									Debe cerrar operaciones del día de hoy.
									</div>
									<?php
								}

								?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div><!--end #content-->
		<!-- END CONTENT -->
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>


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
	<script src="../../../../../js/core/demo/DemoFormWizard.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/additional-methods.min.js"></script>
	<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>
	<script src="../../../../../libs/alertify/js/alertify.js"></script>

	<!-- END JAVASCRIPT -->
</body>
</html>
