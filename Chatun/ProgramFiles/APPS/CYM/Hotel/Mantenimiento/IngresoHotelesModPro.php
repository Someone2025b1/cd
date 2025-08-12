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
				<h1 class="text-center"><strong>Mantenimiento de Ingreso Hoteles</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Datos Generales del Evento</strong></h4>
						</div>
						<div class="card-body">
							<div class="row">
								<?php

									$Hotel              = $_POST["Hotel"];
									$CantidadAdulto    = $_POST["CantidadAdultos"];
									$CantidadAdultoM             = $_POST["CantidadAdultosM"];
									$CantidaMenores            = $_POST["CantidadNinoMenor"];
									$CantidadNino            = $_POST["CantidadNino"];
									$PrecioAdulto = $_POST["PreciodAdultos"];
									$PrecioAdultoM      = $_POST["PreciodAdultosM"];
									$PrecioNino          = $_POST["PrecioNino"];
									$FechaIngreso         = $_POST["FechaIngreso"];
									$Codigo              = $_POST["Codigo"];

									$TotalAdulto = $CantidadAdulto * $PrecioAdulto;
									$TotalNino = $CantidadNino * $PrecioNino;
									$TotalAdultoM = $CantidadAdultoM * $PrecioAdultoM;
									$TotalTotal = $TotalAdulto + $TotalNino + $TotalAdultoM;

									if ($id_user==10345 | $id_user==53711){

										

										$Query = mysqli_query($db, "UPDATE Taquilla.INGRESO_HOTEL SET
										H_CODIGO = '".$Hotel."',
										IH_ADULTOS = '".$CantidadAdulto."',
										IH_NINOS = '".$CantidadNino."',
										IH_MENORES_5 ='".$CantidaMenores."',
										IH_ADULTO_MAYOR ='".$CantidadAdultoM."',
										IH_PRECIO_ADULTO ='".$PrecioAdulto."',
										IH_PRECIO_NINO ='".$PrecioNino."',
										IH_PRECIO_ADULTO_MAYOR ='".$PrecioAdultoM."',
										IH_TOTAL_ADULTO ='".$TotalAdulto."',
										IH_TOTAL_NINO ='".$TotalNino."',
										IH_TOTAL_ADULTO_MAYOR ='".$TotalAdultoM."',
										IH_TOTAL ='".$TotalTotal."',
										IH_FECHA ='".$FechaIngreso."' 
										WHERE IH_ID = ".$Codigo);

										if($Query)
										{
											echo '<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
												<h2 class="text-light">El Ingreso a Hoteles se Modifico correctamente.</h2>
												<div class="row">
													<div class="col-lg-12 text-center"><a href="IngresoHotelesListaFecha.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
											</div>';
										}
										else
										{
											echo '<div class="col-lg-12 text-center">
													<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
													<h2 class="text-light">Lo sentimos, no se pudo ingresar La Actualuización del Ingreso Hoteles.</h2>
												</div>';
												
											}
										

										
								}else{
									echo '<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
												<h2 class="text-light">Lo sentimos, no se pudo Actualizar el Evento devido a que su Usuario no esta 
												Autorizado.</h2>
											</div>';

									

								}
								?>
							</div> 
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

	</body>
	</html>
