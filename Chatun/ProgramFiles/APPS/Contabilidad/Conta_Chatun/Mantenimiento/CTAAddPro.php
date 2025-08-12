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
				<h1 class="text-center"><strong>Mantenimiento de Cuentas Bancarias</strong><br></h1>
				<br>
				<form class="form" action="CTAAddPro.php" method="POST" role="form">
					<?php

						$Nombre       = $_POST["Nombre"];
						$CodigoCuenta = $_POST["CodigoCuenta"];
						$Banco        = $_POST["Banco"];

						$query = "SELECT MAX(N_CODIGO) AS CODIGO_NUEVO FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO BETWEEN '1.01.02.000' AND '1.01.02.999'";
						$result = mysqli_query($db, $query);
						while($row = mysqli_fetch_array($result))
						{
							$CodigoNuevo =  $row["CODIGO_NUEVO"];
						}

						if($CodigoNuevo == '1.01.02.000')
						{
							$CodigoExplotado = explode(".", $CodigoNuevo);
							$CodigoNuevo = $CodigoExplotado[0].'.'.$CodigoExplotado[1].'.'.$CodigoExplotado[2].'.001';
						}
						else
						{
							$Xplotado = explode(".", $CodigoNuevo);
							$CorrelativoActual = $Xplotado[3];
							$CorrelativoActual = $CorrelativoActual + 1;
							if($CorrelativoActual < 10)
							{
								$CorrelativoNuevo = '00'.$CorrelativoActual;
							}
							elseif(($CorrelativoActual > 9) && ($CorrelativoActual < 100))
							{
								$CorrelativoNuevo = '0'.$CorrelativoActual;
							}
							elseif($CorrelativoActual > 99)
							{
								$CorrelativoNuevo = $CorrelativoActual;
							}

							$CodigoNuevo = $Xplotado[0].'.'.$Xplotado[1].'.'.$Xplotado[2].'.'.$CorrelativoNuevo;							
						}

						$sql = mysqli_query($db, "INSERT INTO Contabilidad.CUENTA (CTA_CODIGO, CTA_NUMERO, CTA_NOMBRE, B_CODIGO)
											VALUES ('".$CodigoNuevo."', '".$CodigoCuenta."', '".$Nombre."', ".$Banco.")");
						
						if(!$sql)
						{
							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo ingresar la cuenta bancaria.</h2>
									<h4 class="text-light">Código de transacción: '.$CodigoNuevo.'</h4>
								</div>';
							echo mysqli_error($sql);
				
						}
						else
						{
							$sql1 = mysqli_query($db, "INSERT INTO Contabilidad.NOMENCLATURA (N_CODIGO, N_NOMBRE, N_TIPO)
												VALUES ('".$CodigoNuevo."', '".$Nombre."', '')");

							if(!$sql1)
							{
								echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo ingresar la cuenta bancaria.</h2>
										<h4 class="text-light">Código de transacción: '.$CodigoNuevo.'</h4>
									</div>';
								echo mysqli_error($sql1);
					
							}
							else
							{
								echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El proveedor se ingresó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="CTA.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
								</div>';
							}
						}
					?>
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
