<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
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
		function EnviarFormulario()
		{
			var formulario = document.getElementById("FormularioEnviar");
			formulario.submit();
			return true;
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
				<form id="FormularioEnviar" action="EditarColaborador.php" method="POST">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Nuevo Cokaborador</strong></h4>
							</div>
							<div class="card-body">
								<?php
								$CodigoColaborador   = $_POST["CodigoColaborador"];
								$Nombres       = $_POST["Nombres"];
								$Apellidos = $_POST["Apellidos"];
								$DPI        = $_POST["DPI"];
								$TipoSangre        = $_POST["TipoSangre"];
								
								$EstadoCivil        = $_POST["EstadoCivil"];
								$FechaNacimiento        = $_POST["FechaNacimiento"];
								$Celular        = $_POST["Celular"];
								$FechaInicio        = $_POST["FechaInicio"];
								$Direccion        = $_POST["Direccion"];
								$IGSS        = $_POST["IGSS"];
								$NIT        = $_POST["NIT"];
								$Casa        = $_POST["Casa"];
								$Area        = $_POST["Area"];
								$Puesto        = $_POST["Puesto"];
								$TipoEmpleado        = $_POST["TipoEmpleado"];
								$Jefe        = $_POST["Jefe"];
								$Extendido        = $_POST["Extendido"];
								$Nacido        = $_POST["Nacido"];
								$Base        = $_POST["Base"];
								$BonoLey        = $_POST["BonoLey"];
								$Bono        = $_POST["Bono"];

								if(isset($_POST["Vehiculo"]))
								{
									$Vehiculo = 1;
								}
								else
								{
									$Vehiculo = 0;
								}

								if(isset($_POST["Automovil"]))
								{
									$Automovil = 1;
								}
								else
								{
									$Automovil = 0;
								}

								if(isset($_POST["Motocicleta"]))
								{
									$Motocicleta = 1;
								}
								else
								{
									$Motocicleta = 0;
								}

								$ObservacionesGen        = $_POST["ObservacionesGen"];

									
									if ($_FILES["archivo"]["error"] === 0) {

										$permitidos = array("image/png", "image/jpg", "image/jpeg", "application/pdf");
										$limite_kb = 1024; //1 MB
									
										if (in_array($_FILES["archivo"]["type"], $permitidos) && $_FILES["archivo"]["size"] <= $limite_kb * 1024) {
									
											$ruta = 'files/'.$CodigoColaborador."/";
											$archivoNombre = $_FILES["archivo"]["name"];
											$trozos = explode(".", $archivoNombre); 
			                                $extension = end($trozos);
											$archivo = $ruta ."Foto-".$CodigoColaborador.".". $extension;
									
											if (!file_exists($ruta)) {
												mkdir($ruta, 0777, true);
											}
									
											
									
												$resultado = move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo);
									
												if ($resultado) {
													echo "Archivo Guardado";
												} else {
													echo "Error al guardar archivo";
												}
											
										} else {
											echo "Archivo no permitido o excede el tamaño";
										}
									}

									$QueryColaborador = mysqli_query($db, "INSERT INTO RRHH.COLABORADOR(C_CODIGO, C_NOMBRES, C_APELLIDOS, C_DPI, EC_CODIGO,
									C_FECHA_NACIMIENTO, C_FECHA_INICIO, C_CELULAR, C_DIRECCION, C_NO_IGSS, C_NIT, C_VEHICULO, C_AUTOMOVIL, C_MOTOCICLETA, C_CASA, C_EXTENCION_FOTO, C_OBSERVACIONES,
									C_TIPO_SANGRE, P_CODIGO, A_CODIGO, C_ACTIVO, C_TIPO_EMPLEADO, C_JEFE, C_EXTENDIDO, C_NACIDO, C_BASE, C_BONOFICACION, C_BONO)
										VALUES('".$CodigoColaborador."', '".$Nombres."', '".$Apellidos."', '".$DPI."', '".$EstadoCivil."', '".$FechaNacimiento."', '".$FechaInicio."',
										'".$Celular."', '".$Direccion."', '".$IGSS."', '".$NIT."', ".$Vehiculo.", ".$Automovil.", ".$Motocicleta.", '".$Casa."', '".$extension."', '".$ObservacionesGen."',
										'".$TipoSangre."', ".$Puesto.", ".$Area.", 1, '".$TipoEmpleado."', '".$Jefe."', '".$Extendido."', '".$Nacido."', '".$Base."', '".$Bono."', '".$BonoLey."')");
								?>

							<input class="form-control" type="hide" name="CodigoColaborador" id="CodigoColaborador" value="<?php echo $CodigoColaborador; ?>"/>

							</div>
						</div>
					</div>
					<br>
					<br>
				</form>

				<script>
					<?php
					if($QueryColaborador){
					?>
									EnviarFormulario();
									<?php
					}
									?>
								</script>

			</div>
		</div>
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
	</body>
	</html>
