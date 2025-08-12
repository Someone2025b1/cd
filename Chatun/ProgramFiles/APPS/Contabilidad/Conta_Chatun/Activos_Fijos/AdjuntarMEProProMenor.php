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
	function Redireccionar()
	{
		var Codigo = $('#CodigoTrans').val();
		window.location.replace('AdjuntarMEProMenor.php?CodigoPoliza='+Codigo);
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
						<?php

						$CodigoActivo     = $_POST["CodigoActivo"];
						$NombreActivo     = $_POST["NombreActivo"];
						$CIFResponsable   = $_POST["CIFResponsable"];
						$Area             = $_POST["Area"];
						$TipoActivo       = $_POST["TipoActivo"];
						$Descripcion      = $_POST["Descripcion"];
						$ValorActivo      = $_POST["ValorActivo"];
						$CodigoTrans      = $_POST["CodigoTrans"];
						$SaldoPoliza      = $_POST["SaldoPoliza"];
						$FechaAdquisicion = $_POST["FechaAdquisicion"];

						if(isset($_POST["Deducible"]))
								{
									$Deducible = 1;
								}
								else
								{
									$Deducible = 0;
								}

						echo '<input type="hidden" id="CodigoTrans" value="'.$CodigoTrans.'" />';

						$query = mysqli_query($db,"INSERT INTO Contabilidad.ACTIVO_FIJO_MENOR(AF_CODIGO, AF_NOMBRE, AF_RESPONSABLE, AF_AREA, AF_OBSERVACIONES, AF_VALOR, AF_TRANSACCION, TA_CODIGO, AF_ESTADO, AF_VALOR_ACTUAL, AF_FECHA_ADQUISICION, AF_DEDUCIBLE)
												VALUES ('".$CodigoActivo."', '".$NombreActivo."', ".$CIFResponsable.", ".$Area.", '".$Descripcion."', ".$ValorActivo.", '".$CodigoTrans."', ".$TipoActivo.", 1, ".$ValorActivo.", '".$FechaAdquisicion."', '".$Deducible."')");

						$SaldoActual = $SaldoPoliza - $ValorActivo;
						$SaldoActual2 = 0;

						if($query)
						{
							$Consulta = mysqli_query($db,"UPDATE Contabilidad.TRANSACCION SET TRA_MENOR_REGISTRADO = 1 WHERE TRA_CODIGO = '".$CodigoTrans."';");
							if($Consulta)
							{
								?>
									<script>
									Redireccionar();
									</script>
								<?php
							}
							else
							{
								echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
								<h2 class="text-light">Lo sentimos, no se pudo el activo fijo.</h2>
								<h4 class="text-light">Código de transacción: '.$CodigoActivo.'. Actualizando saldo</h4>
								</div>';
								echo mysqli_error($query);
								$Centinela = false;
								
							}
							
													
						}
						else
						{
							echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
							<h2 class="text-light">Lo sentimos, no se pudo el activo fijo.</h2>
							<h4 class="text-light">Código de transacción: '.$CodigoActivo.'</h4>
							</div>';
							echo mysqli_error($query);
							$Centinela = false;
								
						}

						?>
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
