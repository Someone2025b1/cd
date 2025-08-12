<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
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
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->
	
	<script type="text/javascript">
	function VerificarNacionalidad(x)
	{
		if(x == 35)
		{
			$("#DIVDPI").show();
			$("#DIVPasaporte").hide();
		}
		else
		{
			$("#DIVDPI").hide();
			$("#DIVPasaporte").show();
		}
	}
	function MostrarMunicipios(Valor)
	{
		$.ajax({
			url: 'BuscarMunicipios.php',
			type: 'POST',
			data: 'id='+Valor,
			success: function(opciones)
			{
				$('#MunicipioResidencia').html(opciones)
			},
			error: function(opciones)
			{
				alert('Error'+opciones);
			}
		})
	}
	function ObtenerDepartamentosLaborales(Valor)
	{
		$.ajax({
			url: 'BuscarDepartamentosLaborales.php',
			type: 'POST',
			data: 'id='+Valor,
			success: function(opciones)
			{
				$('#Puesto').html(opciones)
			},
			error: function(opciones)
			{
				alert('Error'+opciones);
			}
		})
	}
	function CrearUsername()
	{
		var PrimerNombre          = $('#PrimerNombre').val();
		var SegundoNombre         = $('#SegundoNombre').val();
		var PrimerApellido        = $('#PrimerApellido').val();
		var DepartamentoLaboral   = $('#DepartamentoLaboral option:selected').text();
		var DepartamentoIniciales = '';
		var Cadena                = 'pc';

		var Explotado = DepartamentoLaboral.split(" ");

		for(i=0; i<Explotado.length; i++)
		{
			DepartamentoIniciales = DepartamentoIniciales+Explotado[i][0];
		}

		DepartamentoIniciales = DepartamentoIniciales.toLowerCase();

		Primer = PrimerNombre[0].toLowerCase();
		Segundo = SegundoNombre[0].toLowerCase();
		Apellido = PrimerApellido[0].toLowerCase();

		$('#Usuario').val(Cadena+DepartamentoIniciales+Primer+Segundo+Apellido);
	}
	function ComprobarCIF(x)
	{

		$.ajax({
			url: 'BuscarCIF.php',
			type: 'POST',
			data: 'id='+x,
			success: function(opciones)
			{
				if(parseFloat(opciones) > 0)
				{
					$('#DIVCIF').removeClass('has-success has-error has-feedback');
					$('#SpanCIF').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

					$('#DIVCIF').addClass('has-error has-feedback');
					$('#SpanCIF').addClass('glyphicon glyphicon-remove form-control-feedback');
					$('#EMCIF').html('El Número de CIF ya está registrado');
				}
				else
				{	$('#DIVCIF').removeClass('has-success has-error has-feedback');
					$('#SpanCIF').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

					$('#DIVCIF').addClass('has-success has-feedback');
					$('#SpanCIF').addClass('glyphicon glyphicon-ok form-control-feedback');
					$('#EMCIF').html('');
				}
			},
			error: function(opciones)
			{
				alert('Error'+opciones);
			}
		})
	}
	</script>

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
				<form class="form" action="AddColaboradorPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Colaborador</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
											<input class="form-control" type="number" name="CIF" id="CIF" min="0" onchange="ComprobarCIF(this.value)" required/>
											<label for="CIF">CIF</label>
											<span id="SpanCIF"></span>
										</div>
										<em id="EMCIF"></em>
									</div>
									<div class="col-lg-8" id="DIVResultado"></div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="PrimerNombre" id="PrimerNombre" required/>
											<label for="PrimerNombre">Primer Nombre</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="SegundoNombre" id="SegundoNombre"/>
											<label for="SegundoNombre">Segundo Nombre</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="TercerNombre" id="TercerNombre"/>
											<label for="TercerNombre">Tercer Nombre</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="PrimerApellido" id="PrimerApellido" required/>
											<label for="PrimerApellido">Primer Apellido</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="SegundoApellido" id="SegundoApellido"/>
											<label for="SegundoApellido">Segundo Apellido</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="ApellidoCasada" id="ApellidoCasada"/>
											<label for="ApellidoCasada">Apellido de Casada</label>
										</div>
									</div>
								</div>
								<div>
									<h5>Género</h5>	
									<label class="radio-inline radio-styled">
										<input type="radio" value="M" name="Sexo">
										<span>Masculino</span>
									</label>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="F" name="Sexo">
										<span>Femenino</span>
									</label>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Nacionalidad" id="Nacionalidad" class="form-control" onchange="VerificarNacionalidad(this.value)">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT * FROM  info_base.lista_nacionalidades ORDER BY nacionalidad";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["id"].'">'.$row["nacionalidad"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="Nacionalidad">Nacionalidad</label>
										</div>
									</div>
								</div>
								<div class="row" id="DIVDPI" style="display: none">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="DPI" id="DPI" min="0" />
											<label for="DPI">DPI</label>
										</div>
									</div>
								</div>
								<div class="row" id="DIVPasaporte" style="display: none">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="Pasaporte" id="Pasaporte" min="0" />
											<label for="Pasaporte"># de Pasaporte</label>
										</div>
									</div>
								</div>
								<div>
									<h5>Estado Civil</h5>
									<label class="radio-inline radio-styled">
										<input type="radio" value="C" name="EstadoCivil">
										<span>Casado(a)</span>
									</label>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="S" name="EstadoCivil">
										<span>Soltero(a)</span>
									</label>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="U" name="EstadoCivil">
										<span>Union Libre</span>
									</label>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="D" name="EstadoCivil">
										<span>Divorciado(a)</span>
									</label>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="V" name="EstadoCivil">
										<span>Viudo(a)</span>
									</label>
								</div>
								<div class="row" >
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="NIT" id="NIT" />
											<label for="NIT"># de NIT</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaNacimiento" id="FechaNacimiento"/>
											<label for="FechaNacimiento">Fecha de Nacimiento</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Direccion" id="Direccion"></textarea>
											<label for="Direccion">Dirección</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="DepartamentoResidencia" id="DepartamentoResidencia" class="form-control" onchange="MostrarMunicipios(this.value)">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT id_departamento, nombre_departamento FROM  info_base.departamentos_guatemala ORDER BY nombre_departamento";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["id_departamento"].'">'.$row["nombre_departamento"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="DepartamentoResidencia">Departamento de Residencia</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="MunicipioResidencia" id="MunicipioResidencia" class="form-control" id="MunicipioResidencia">												
											</select>
											<label for="MunicipioResidencia">Municipio de Residencia</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="Celular" id="Celular" min="0"/>
											<label for="Celular">Número de Celular</label>
										</div>
									</div>
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="Telefono" id="Telefono"/>
											<label for="Telefono">Número de Teléfono</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="email" name="EmailInstitucional" id="EmailInstitucional"/>
											<label for="EmailInstitucional">Correo Electrónico Institucional</label>
										</div>
									</div>
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="email" name="EmailPersonal" id="EmailPersonal" min="0"/>
											<label for="EmailPersonal">Correo Electrónico Personal</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Profesion" id="Profesion"/>
											<label for="Profesion">Profesión</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Observaciones" id="Observaciones"></textarea>
											<label for="Observaciones">Observaciones</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Laborales</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="DepartamentoLaboral" id="DepartamentoLaboral" class="form-control" onchange="ObtenerDepartamentosLaborales(this.value)">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT id_depto, nombre_depto FROM info_base.departamentos WHERE id_gerencia = 5 ORDER BY nombre_depto";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["id_depto"].'">'.$row["nombre_depto"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="DepartamentoLaboral">Departamento Laboral</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Puesto" id="Puesto" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
											</select>
											<label for="Puesto">Puesto Laboral</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaIngreso" id="FechaIngreso"/>
											<label for="FechaIngreso">Fecha de Ingreso a la Institución</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos de Ingreso al Portal (Usuario)</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-content">
													<input type="text" class="form-control" id="Usuario" name="Usuario" readonly>
													<label for="Usuario">Usuario</label>
												</div>
												<div class="input-group-btn">
													<button type="button" class="btn btn-default" onclick="CrearUsername()">Generar Usuario</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<em class="text-caption">La contraseña, para entrar al portal, por default es "public" (sin comillas), al primer intento de login forzosamente tendrá que cambiarla.</em>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="ClasificacionUsuario" id="ClasificacionUsuario" class="form-control" onchange="ObtenerDepartamentosLaborales(this.value)">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="1">Colaborador</option>
												<option value="2">Usuario Portal</option>
											</select>
											<label for="ClasificacionUsuario">Tipo de Usuario</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
					</div>
					<br>
					<br>
				</form>
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
