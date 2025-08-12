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
	
	<script>
	function DesplegarResolucion(x)
	{
		if(x.value == '2')
		{
			$('#FacturaAprobada').show();
			$('#FacturaRechazada').hide();
			$('#Comprobante').attr("required", "required");
			$('#MotivoRechazo').attr("required");
		}
		else
		{
			$('#FacturaAprobada').hide();
			$('#FacturaRechazada').show();
			$('#Comprobante').attr("required");
			$('#MotivoRechazo').attr("required", "required");
		}
	}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<div class="col-lg-12">
					<br>
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Contabilizar Anticipo</strong></h4>
						</div>
						<div class="card-body">
						<?php

							$CodigoTransaccion = $_POST["CodigoTransaccion"];
							$Estado = $_POST["Estado"];
							$Periodo      = $_POST["Periodo"];

							$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE PC_CODIGO = ".$Periodo;
										$resultCorrelativo = mysqli_query($db,$queryCorrelativo);
										while($rowCor = mysqli_fetch_array($resultCorrelativo))
										{	
											if($rowCor["CORRELATIVO"] == 0)
											{
												$Correlativo = 1;
											}
											else
											{
												$Correlativo = $rowCor["CORRELATIVO"] + 1;
											}
										}

							


							if($Estado == 2)
							{
								$Comprobante = $_POST["Comprobante"];
								$sql = mysqli_query($db,"UPDATE Contabilidad.TRANSACCION SET TRANSACCION.E_CODIGO = 2, TRANSACCION.TRA_NO_HOJA = '".$Comprobante."', TRANSACCION.TRA_CORRELATIVO = ".$Correlativo.", TRANSACCION.PC_CODIGO = ".$Periodo.", TRANSACCION.TRA_CONTABILIZO = ".$id_user." WHERE TRANSACCION.TRA_CODIGO = '".$CodigoTransaccion."'");
							}
							else
							{
								$MotivoRechazo = $_POST["MotivoRechazo"];
								$sql = mysqli_query($db,"UPDATE Contabilidad.TRANSACCION SET TRANSACCION.E_CODIGO = 3, TRANSACCION.TRA_MOTIVO_RECHAZO = '".$MotivoRechazo."' WHERE TRANSACCION.TRA_CODIGO = '".$CodigoTransaccion."'");
							}

							if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
							{
								echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo operar el anticipo.</h2>
										<h4 class="text-light">Código de transacción: '.$CodigoTransaccion.'</h4>
									</div>';
								echo mysql_error($sql);
								$Centinela = false;
								
							}
							else
							{
								echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El anticipo se operó correctamente.</h2>
								<div class="row">
									<div class="col-lg-6 text-right"><a href="OAImp.php?Codigo='.$CodigoTransaccion.'" target="_blank"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print"></span> Imprimir</a></div>
									<div class="col-lg-6 text-left"><a href="OA.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
								</div>';
							}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END CONTENT -->

	
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
