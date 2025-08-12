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
				<h1 class="text-center"><strong>Mantenimiento de Productos</strong><br></h1>
				<br>
				<form class="form" method="POST" role="form">
					<?php
 
						$Nombre = $_POST["Nombre"];
						$DPI = $_POST["DPI"];
						$CalidadActua = $_POST["CalidadActua"];
						$FechaNacimiento = $_POST["FechaNacimiento"];
						$Cel = $_POST["Cel"];
						$Cel2 = $_POST["Cel2"];
						$Correo = $_POST["Correo"];
						$Direccion = $_POST["Direccion"];
						$DepartamentoResidencia = $_POST["DepartamentoResidencia"];
						$MunicipioResidencia = $_POST["MunicipioResidencia"];
						$Razon = $_POST["Razon"];
						$Actividad = $_POST["Actividad"];
						$NombreCo = $_POST["NombreCo"];
						$NIT = $_POST["NIT"];
						$TelEmpresa = $_POST["TelEmpresa"];
						$Comprador = $_POST["Comprador"];
						$CelComprador = $_POST["CelComprador"];
						$Paga = $_POST["Paga"];
						$CelPaga = $_POST["CelPaga"];
						$Monto = $_POST["Monto"];
						$DiasCredito = $_POST["DiasCredito"];
						$FechaRTU = $_POST["FechaRTU"];
						$Estado = $_POST["Estado"];

						if(isset($_POST["SolicitudCredito"]))
								{
									$SolicitudCredito = 1;
								}
								else
								{
									$SolicitudCredito = 0;
								}

						if(isset($_POST["FotocopiaDPI"]))
								{
									$FotocopiaDPI = 1;
								}
								else
								{
									$FotocopiaDPI = 0;
								}

						if(isset($_POST["RepLegal"]))
								{
									$RepLegal = 1;
								}
								else
								{
									$RepLegal = 0;
								}

						if(isset($_POST["Patente"]))
								{
									$Patente = 1;
								}
								else
								{
									$Patente = 0;
								}

						if(isset($_POST["RTU"]))
								{
									$RTU = 1;
								}
								else
								{
									$RTU = 0;
								}

						if(isset($_POST["ReciboLuz"]))
								{
									$ReciboLuz = 1;
								}
								else
								{
									$ReciboLuz = 0;
								}
					 
					 
                                $sql = mysqli_query($db, "UPDATE Contabilidad.CLIENTE_CREDITO SET CLIC_NOMBRE_COMPLETO='".$Nombre."', CLIC_CALIDAD_ACTUA='".$CalidadActua."',
                                CLIC_DPI = '".$DPI."', CLIC_FECHA_NACIMIENTO = '".$FechaNacimiento."', CLIC_TELFONO_EMPRESA ='".$TelEmpresa."', CLIC_CEL = '".$Cel."',
                                CLIC_CEL2 = '".$Cel2."', CLIC_EMAIL = '".$Correo."', CLIC_DIRECCION = '".$Direccion."', CLIC_MUCIPIO = '".$MunicipioResidencia."',
                                CLIC_DEPARTAMAENTO = '".$DepartamentoResidencia."', CLIC_RAZON_SOCIAL = '".$Razon."', CLIC_NOMBRE_COMERCIAL = '".$NombreCo."', CLIC_ACTIVIDAD_COMERCIAL = '".$Actividad."',
                                CLIC_NOMBRE_COMPRA = '".$Comprador."', CLIC_CEL_COMPRA = '".$CelComprador."', CLIC_NOMBRE_COBRO= '".$Paga."', CLIC_CEL_COBRO = '".$CelPaga."', CLIC_MONTO_CREDITO ='".$Monto."',
                                CLIC_DIAS = '".$DiasCredito."', CLIC_SOLICITUD = '".$SolicitudCredito."', CLIC_FDPI = '".$FotocopiaDPI."', CLIC_REP_LEGAL = '".$RepLegal."', CLIC_PATENTE_COMERCIO = '".$Patente."',
                                CLIC_RTU = '".$RTU."', CLIC_RTU_FECHA = '".$FechaRTU."', CLIC_RECIBO_LUZ = '".$ReciboLuz."', CLIC_ESTADO = '".$Estado."' WHERE CLIC_NIT = '".$NIT."'");
											
						
						if(!$sql)
						{
							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo ingresar el Cliente.</h2>
								</div>';
							echo mysqli_error($sq, $sql);
							
						}
						else
						{
							echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El Cliente se ingresó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="EditarCliente.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
							</div>';
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
