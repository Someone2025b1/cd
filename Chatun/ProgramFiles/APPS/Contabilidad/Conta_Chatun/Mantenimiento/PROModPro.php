<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
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
	
    <script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

	<?php
		$Codigo               = $_POST["Codigo"];
		$Nombre               = $_POST["Nombre"];
		$NIT                  = $_POST["NIT"];
		$DPI                  = $_POST["DPI"];
		$Direccion            = $_POST["Direccion"];
		$Telefono1            = $_POST["Telefono1"];
		$Telefono2            = $_POST["Telefono2"];
		$Email                = $_POST["Email"];
		$Regimen              = $_POST["Regimen"];
		$TipoProveedor        = $_POST["TipoProveedor"];
		$CuentaBancaria       = $_POST["CuentaBancaria"];
		$NombreCuentaBancaria = $_POST["NombreCuentaBancaria"];
		$Banco                = $_POST["Banco"];
		$TipoFactura          = $_POST["TipoFactura"];
		$DiasCredito          = $_POST["DiasCredito"];

	?>

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Edición de Proveedor</strong><br></h1>
				<br>
				<?php
					$sql = mysqli_query($db, "UPDATE Contabilidad.PROVEEDOR SET P_NOMBRE = '".$Nombre."', P_DIRECCION = '".$Direccion."', P_TELEFONO = '".$Telefono1."', P_TELEFONO1 = '".$Telefono2."', P_EMAIL = '".$Email."', REG_CODIGO = '".$Regimen."', P_NIT = '".$NIT."', P_DPI = '".$DPI."', P_CODIGO_CUENTA = '".$CuentaBancaria."', P_NOMBRE_CUENTA = '".$NombreCuentaBancaria."', B_CODIGO = '".$Banco."', TF_CODIGO = '".$TipoFactura."', P_DIAS_CREDITO = ".$DiasCredito.", P_TIPO = ".$TipoProveedor." WHERE P_CODIGO = '".$Codigo."'");
									
					if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
					{

						echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
								<h2 class="text-light">Lo sentimos, no se pudo ingresar el proveedor.</h2>
								<h4 class="text-light">Código de transacción: '.$Codigo.'</h4>
								</div>';
						echo mysqli_error($sql);
						
					}
					else
					{
						$sql1 = mysqli_query($db, "UPDATE Contabilidad.NOMENCLATURA SET N_NOMBRE = '".$Nombre."' WHERE N_CODIGO = '".$Codigo."'");

						if(!$sql1) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
						{

							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo ingresar el proveedor.</h2>
									<h4 class="text-light">Código de transacción: '.$Codigo.'</h4>
									</div>';
							echo mysqli_error($sql1);
							
						}
						else
						{
							echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El proveedor se modificó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="PRO.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
								</div>';
						}						
					}
				?>
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
