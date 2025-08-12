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

								$Consulta = "SELECT * FROM Bodega.APERTURA_CIERRE_CAJA WHERE ACC_FECHA = CURRENT_DATE() AND ACC_ESTADO = 1 AND ACC_TIPO = 8";
								$ResultConsulta = mysqli_query($db, $Consulta) or die(mysqli_error());
								$Registros = mysqli_num_rows($ResultConsulta);


								if($Registros == 0)
								{	

									$Query = "SELECT ACC_FECHA FROM Bodega.APERTURA_CIERRE_CAJA WHERE ACC_ESTADO = 1 AND ACC_FECHA < CURRENT_DATE() AND ACC_TIPO = 8";
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
													<input class="form-control" type="number" step="any" name="MontoInicial" id="MontoInicial" value="0" required />
													<label for="MontoInicial">Monto de Apertura</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="card tabs-left style-default-light">
													<ul class="card-head nav nav-tabs" data-toggle="tabs">
														<li class="active"><a href="#first5">Quetzales</a></li> 
													</ul>
													<div class="card-body tab-content style-default-bright">
														<div class="tab-pane active" id="first5">
															<h3 class="text-light"><strong>Cuadre de Efectivo (Q)</strong></h3>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ200" id="BQ200" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="BQ200">Billetes de Q. 200</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ100" id="BQ100" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="BQ100">Billetes de Q. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ50" id="BQ50" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="BQ50">Billetes de Q. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ20" id="BQ20" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="BQ20">Billetes de Q. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ10" id="BQ10" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="BQ10">Billetes de Q. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ5" id="BQ5" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="BQ5">Billetes de Q. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ1" id="BQ1" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="BQ1">Billetes de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ1" id="MQ1" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="MQ1">Monedas de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ50" id="MQ50" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="MQ50">Monedas de C. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ25" id="MQ25" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="MQ25">Monedas de C. 25</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ10" id="MQ10" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="MQ10">Monedas de C. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ5" id="MQ5" value="0" min="0" required onchange="CalcularTotalQ()"/>
																	<label for="MQ5">Monedas de C. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" step="any" name="TCQ" id="TCQ" value="0" min="0" required readonly/>
																	<label for="TCQ">Total de Cuadre en Quetzales</label>
																</div>
															</div>
														</div> 
													</div>
												</div>
										</div>
										<div class="row">
											<br>
										</div>
										<div class="row">
											<div class="row text-center">
												<button   type="submit" class="btn btn-success" id="btnSubmit">
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
	<script>
		function CalcularTotalQ()
			{
				var B200 = $('#BQ200').val();
				var B100 = $('#BQ100').val();
				var B50  = $('#BQ50').val();
				var B20  = $('#BQ20').val();
				var B10  = $('#BQ10').val();
				var B5   = $('#BQ5').val();
				var B1   = $('#BQ1').val();
				var M1   = $('#MQ1').val();
				var M50  = $('#MQ50').val();
				var M25  = $('#MQ25').val();
				var M10  = $('#MQ10').val();
				var M5   = $('#MQ5').val();

				var CantidadEntera = parseFloat(B200 * 200) + parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5) + parseFloat(B1 * 1);
				var CantidadMoneda = parseFloat(M1 * 1) + parseFloat(M50 * 0.50) + parseFloat(M25 * 0.25) + parseFloat(M10 * 0.10) + parseFloat(M5 * 0.05);

				var Total = CantidadEntera + CantidadMoneda;
				Total = Total.toFixed(2);

				$('#TCQ').val(Total);
				var TotalApertura = $("#MontoInicial").val(); 
				 
			}
	</script>
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
