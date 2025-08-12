<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$sql = mysqli_query($db, "SELECT A.id_aplicacion, B.nombre, B.icono, B.link FROM info_base.define_aplicaciones_departamentos AS A LEFT JOIN info_bbdd.aplicaciones AS B ON A.id_aplicacion = B.id_aplicacion WHERE A.id_departamento = $id_depto AND B.estado = 1") or die (mysqli_error());
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
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="content-fluid text-right">
				<br>
				<button type="button" class="btn ink-reaction btn-primary">
					<i class="fa fa-chevron-left"> <a href="principal.php">Regresar</a></i>
				</button>
				<br>
				<br>
			</div>
			
			<div class="col-lg-12">
				<h2 class="text-center">Crear un nuevo colaborador</h2>
				<hr>
				<?php

					$CIF = $_POST["CIF"];
					$PrimerNombre = $_POST["PrimerNombre"];

					if(isset($_POST["SegundoNombre"]))
					{
						$SegundoNombre = $_POST["SegundoNombre"];	
					}
					else
					{
						$SegundoNombre = '';	
					}

					if(isset($_POST["TercerNombre"]))
					{
						$TercerNombre = $_POST["TercerNombre"];
					}
					else
					{
						$TercerNombre = '';	
					}					
					
					$PrimerApellido = $_POST["PrimerApellido"];

					if(isset($_POST["SegundoApellido"]))
					{
						$SegundoApellido = $_POST["SegundoApellido"];
					}
					else
					{
						$SegundoApellido = '';	
					}

					if(isset($_POST["ApellidoCasada"]))
					{
						$ApellidoCasada = $_POST["ApellidoCasada"];
					}
					else
					{
						$ApellidoCasada = '';	
					}

					if(isset($_POST["Sexo"]))
					{
						$Sexo = $_POST["Sexo"];
					}
					else
					{
						$Sexo = 'M';	
					}			
					
					
					$Nacionalidad = $_POST["Nacionalidad"];
					

					if($Nacionalidad != 73)
					{
						$Pasaporte = $_POST["Pasaporte"];
					}
					else
					{
						$DPI = $_POST["DPI"];
					}

					if(isset($_POST["EstadoCivil"]))
					{
						$EstadoCivil = $_POST["EstadoCivil"];
					}
					else
					{
						$EstadoCivil = 'M';	
					}
					
					if(isset($_POST["NIT"]))
					{
						$NIT = $_POST["NIT"];
					}
					else
					{
						$NIT = '';	
					}
					

					if(isset($_POST["FechaNacimiento"]))
					{
						$FechaNacimiento = $_POST["FechaNacimiento"];
					}
					else
					{
						$FechaNacimiento = '1990-01-01';	
					}

					if(isset($_POST["Direccion"]))
					{
						$Direccion = $_POST["Direccion"];
					}
					else
					{
						$Direccion = 'Esquipulas';	
					}
					
					if(isset($_POST["DepartamentoResidencia"]))
					{
						$DepartamentoResidencia = $_POST["DepartamentoResidencia"];
					}
					else
					{
						$DepartamentoResidencia = '';	
					}

					if(isset($_POST["MunicipioResidencia"]))
					{
						$MunicipioResidencia = $_POST["MunicipioResidencia"];
					}
					else
					{
						$MunicipioResidencia = '';	
					}

					if(isset($_POST["Celular"]))
					{
						$Celular = $_POST["Celular"];
					}
					else
					{
						$Celular = '';	
					}

					if(isset($_POST["Telefono"]))
					{
						$Telefono = $_POST["Telefono"];
					}
					else
					{
						$Telefono = '';	
					}
					
					if(isset($_POST["EmailInstitucional"]))
					{
						$EmailInstitucional = $_POST["EmailInstitucional"];
					}
					else
					{
						$EmailInstitucional = 'info@parquechatun.com';	
					}
					
					if(isset($_POST["EmailPersonal"]))
					{
						$EmailPersonal = $_POST["EmailPersonal"];
					}
					else
					{
						$EmailPersonal = '';	
					}					
					
					if(isset($_POST["Profesion"]))
					{
						$Profesion = $_POST["Profesion"];
					}
					else
					{
						$Profesion = '';	
					}

					if(isset($_POST["Observaciones"]))
					{
						$Observaciones = $_POST["Observaciones"];
					}
					else
					{
						$Observaciones = '';	
					}
					
					if(isset($_POST["DepartamentoLaboral"]))
					{
						$DepartamentoLaboral = $_POST["DepartamentoLaboral"];
					}
					else
					{
						$DepartamentoLaboral = '';	
					}
					
					if(isset($_POST["Puesto"]))
					{
						$Puesto = $_POST["Puesto"];
					}
					else
					{
						$Puesto = '';	
					}
					
					if(isset($_POST["FechaIngreso"]))
					{
						$FechaIngreso = $_POST["FechaIngreso"];
					}
					else
					{
						$FechaIngreso = '2016-03-01';	
					}
					
					

					$Usuario = $_POST["Usuario"];

					if(isset($_POST["ClasificacionUsuario"]))
					{
						$ClasificacionUsuario = $_POST["ClasificacionUsuario"];
					}
					else
					{
						$ClasificacionUsuario = '1';	
					}


					$public = '9eb883a8eef41445b21f9d0f14702050e12fe4eb27d165cde8864076b7bd021a';

					$NombreCompleto = $PrimerNombre." ".$SegundoNombre." ".$TercerNombre." ".$PrimerApellido." ".$SegundoApellido." ".$ApellidoCasada;

					$NombreCompleto = trim($NombreCompleto);
					
		

					$sql = mysqli_query($db, "INSERT INTO info_colaboradores.datos_generales (cif, sexo, estado_civil, nit, nacionalidad, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, dpi, fecha_nacimiento, direccion, departamento_direccion, municipio_direccion, celular, email_institucional, observacion, profesion)
								VALUES ('".$CIF."', '".$Sexo."', '".$EstadoCivil."', '".$NIT."', '".$Nacionalidad."', '".$PrimerNombre."', '".$SegundoNombre."', '".$PrimerApellido."', '".$SegundoApellido."', '".$DPI."', '".$FechaNacimiento."', '".$Direccion."', '".$DepartamentoResidencia."', '".$MunicipioResidencia."', '".$Celular."', '".$EmailInstitucional."', '".$Observaciones."', '".$Profesion."')")or die('Error 1:'.mysqli_query($db, $sql));
									
					if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
					{
						echo 'Error1: '.mysqli_error($sql);
						
					}
					else
					{
						$sql1 = mysqli_query($db, "INSERT INTO info_colaboradores.datos_laborales (cif, agencia, gerencia, departamento, puesto, fecha_ingreso, tipo_jerarquia, estado, tipo_colaborador)
								VALUES ('".$CIF."', 0, 5, '".$DepartamentoLaboral."', '".$Puesto."', '".$FechaIngreso."', 0, 1, '".$ClasificacionUsuario."')")or die('Error 2:'.mysqli_query($db, $sql1));

						if(!$sql1) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
						{
							echo 'Error2: '.mysqli_error($sql1);
							
						}
						else
						{
							$sql2 = mysqli_query($db, "INSERT INTO info_bbdd.usuarios (id_user, nombre, login, password)
								VALUES (".$CIF.", '".$NombreCompleto."', '".$Usuario."', '".$public."')")or die('Error 3'.mysqli_query($db, $sql2));

							if(!$sql2) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
							{
								echo 'Error3: '.mysqli_error($sql2);
								
							}
							else
							{
								echo '<div class="alert alert-success">El nuevo colaborador fue creado con éxito</div>';
							}
						}

					}	
				

				?>
			</div>			
		</div>
		<!-- END CONTENT -->
		
		<?php include("MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	<!-- BEGIN JAVASCRIPT -->
	<script src="../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../js/core/source/App.js"></script>
	<script src="../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../js/core/source/AppCard.js"></script>
	<script src="../../../js/core/source/AppForm.js"></script>
	<script src="../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../js/core/source/AppVendor.js"></script>
	<script src="../../../js/core/demo/Demo.js"></script>
	<script src="../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<!-- END JAVASCRIPT -->

	</body>
	</html>
