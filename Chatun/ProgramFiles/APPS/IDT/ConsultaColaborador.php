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
	<link type="text/css" rel="stylesheet" href="../../../css/jquery-ui.css" />
	<link type="text/css" rel="stylesheet" href="../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->
	
	<script type="text/javascript">
		function ComprobarCIF(x)
		{
			if(isNaN(x))
			{
				$.ajax({
					type: "POST",
					url: "BuscarNombre.php",
					data: 'service='+x,
					beforeSend: function()
					{
						$('#EMCIF').html('<img width="48px" height="48px" src="../../../img/loader.gif" />');
					},
					success: function(data) {
						if(data == '')
						{
							$('#DIVCIF').removeClass('has-success has-error has-feedback');
							$('#SpanCIF').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

							$('#DIVCIF').addClass('has-error has-feedback');
							$('#SpanCIF').addClass('glyphicon glyphicon-remove form-control-feedback');
							$('#EMCIF').html('El Número de CIF o el Nombre no está registrado');
						}
						else
						{
							$('#DIVCIF').removeClass('has-success has-error has-feedback');
							$('#SpanCIF').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

							$('#DIVCIF').addClass('has-success has-feedback');
							$('#SpanCIF').addClass('glyphicon glyphicon-ok form-control-feedback');
							$('#EMCIF').html('');
			                //Escribimos las sugerencias que nos manda la consulta
			                $('#EMCIF').fadeIn(1000).html(data);
			                //Al hacer click en algua de las sugerencias
			                $('.suggest-element').click(function(){
			                	$('#CIF').val($(this).attr('data'));
			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#EMCIF').fadeOut(1000);
			                });
			            }
			        }
			    });
			}
			else
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

							$('#DIVCIF').addClass('has-success has-feedback');
							$('#SpanCIF').addClass('glyphicon glyphicon-ok form-control-feedback');
							$('#EMCIF').html('');
						}
						else
						{	
							$('#DIVCIF').removeClass('has-success has-error has-feedback');
							$('#SpanCIF').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

							$('#DIVCIF').addClass('has-error has-feedback');
							$('#SpanCIF').addClass('glyphicon glyphicon-remove form-control-feedback');
							$('#EMCIF').html('El Número de CIF o el Nombre no está registrado');
						}
					},
					error: function(opciones)
					{
						alert('Error'+opciones);
					}
				})
			}
		}
		function ReiniciarPass()
		{
			var CIF = $('#CIF').val();
			alert(CIF);
			alertify.confirm("¿Está seguro que desa reiniciar la contraseña del colaborador? <br><br>Si Presiona OK, la contraseña será -public- (sin guiones) y cuando el colaborador inicie sesión por primera vez tendrá que cambiarla forzosamente.",
				function(){
					$.ajax({
						url: 'ReiniciarPass.php',
						type: 'POST',
						data: 'id='+CIF,
						success: function(opciones)
						{
							alertify.success('La contraseña del colaborador se reinició');
						},
						error: function(opciones)
						{
							alertify.error(opciones);
						}
					})
				},
				function(){
				});
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
	function AgregarAplicativo(Estado, Id, CIF)
	{
		$.ajax({
			url: 'Ajax/ModificarAplicativo.php',
			type: 'POST',
			dataType: 'html',
			data: {Estado: Estado, Id: Id, CIF: CIF},
			success:function(data)
			{
				if (data==1) 
				{
				 ListadoAplicacion(CIF);
				}
			}			
		});		
	}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../MenuTop.php"); 

	if(isset($_POST["CIFViene"]))
	{
		$CIFViene = $_POST["CIFViene"];

	}
	else
	{
		$CIFViene = '';
	}
	?>

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
				<div class="card">
					<div class="card-head style-primary">
						<h4 class="text-center"><strong>Búsqueda de Colaborador</strong></h4>
					</div>
					<div class="card-body">
						<form class="form" action="#" method="POST" role="form">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group floating-label" id="DIVCIF">
										<input class="form-control" type="text" name="CIFViene" id="CIF" min="0" onchange="ComprobarCIF(this.value)" value="<?php echo $CIFViene ?>" required/>
										<label for="CIF">Búsqueda por Nombre o por CIF</label>
										<span id="SpanCIF"></span>
									</div>
									<div id="EMCIF"></div>
								</div>
								<div class="col-lg-8" id="DIVResultado"></div>
							</div>
							<br>
							<div class="col-lg-12" align="left">
								<button type="submit" class="btn ink-reaction btn-raised btn-primary">Buscar</button>
							</div>
						</form>
					</div>
				</div>
				<?php

				if(isset($_POST["CIFViene"]))
				{
					$consulta = "SELECT * FROM info_colaboradores.datos_generales WHERE cif = ".$_POST["CIFViene"];
					$result = mysqli_query($db, $consulta);
					while($fila = mysqli_fetch_array($result))
					{
						$CIF                    = $fila["cif"];
						$Sexo                   = $fila["sexo"];
						$EstadoCivil            = $fila["estado_civil"];
						$NIT                    = $fila["nit"];
						$Nacionalidad           = $fila["nacionalidad"];
						$PrimerNombre           = $fila["primer_nombre"];
						$SegundoNombre          = $fila["segundo_nombre"];
						$TercerNombre           = $fila["tercer_nombre"];
						$PrimerApellido         = $fila["primer_apellido"];
						$SegundoApellido        = $fila["segundo_apellido"];
						$ApellidoCasada         = $fila["apellido_casada"];
						$DPI                    = $fila["dpi"];
						$Pasaporte              = $fila["pasaporte"];
						$FechaNacimiento        = $fila["fecha_nacimiento"];
						$Direccion              = $fila["direccion"];
						$DepartamentoResidencia = $fila["departamento_direccion"];
						$MunicipioResidencia    = $fila["municipio_direccion"];
						$Telefono               = $fila["telefono"];
						$Celular                = $fila["celular"];
						$EmailPersonal          = $fila["email_personal"];
						$EmailInstitucional     = $fila["email_institucional"];
						$Observaciones          = $fila["observacion"];
						$Profesion              = $fila["profesion"];
					}

					$consulta1 = "SELECT * FROM info_colaboradores.datos_laborales WHERE cif = ".$_POST["CIFViene"];
					$result1 = mysqli_query($db, $consulta1);
					while($fila1 = mysqli_fetch_array($result1))
					{
						$Agencia             = $fila1["agencia"];
						$Gerencia            = $fila1["gerencia"];
						$DepartamentoLaboral = $fila1["departamento"];
						$Puesto              = $fila1["puesto"];
						$FechaIngreso        = $fila1["fecha_ingreso"];
						$TipoJerarquia       = $fila1["tipo_jerarquia"];
						$EstadoLaboral       = $fila1["estado"];
						$Clasificacionusuario= $fila1["tipo_colaborador"];
					}

					$consulta2 = "SELECT * FROM info_bbdd.usuarios WHERE id_user = ".$_POST["CIFViene"];
					$result2 = mysqli_query($db, $consulta2);
					while($fila2 = mysqli_fetch_array($result2))
					{
						$NombreCompleto = $fila2["nombre"];
						$Username       = $fila2["login"];
					}

					?>
					<form class="form" action="ActualizarColaborador.php" method="POST" role="form">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-head style-primary">
									<h4 class="text-center"><strong>Datos Generales del Colaborador</strong></h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-lg-4">
											<div class="form-group floating-label" id="DIVCIF">
												<input class="form-control" type="number" name="CIF" id="CIF" min="0" value="<?php echo $CIF;?>" required readonly/>
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
												<input class="form-control" type="text" name="PrimerNombre" id="PrimerNombre" value="<?php echo $PrimerNombre;?>" required/>
												<label for="PrimerNombre">Primer Nombre</label>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group floating-label">
												<input class="form-control" type="text" name="SegundoNombre" id="SegundoNombre" value="<?php echo $SegundoNombre;?>" >
												<label for="SegundoNombre">Segundo Nombre</label>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group floating-label">
												<input class="form-control" type="text" name="TercerNombre" id="TercerNombre" value="<?php echo $TercerNombre;?>"/>
												<label for="TercerNombre">Tercer Nombre</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
											<div class="form-group floating-label">
												<input class="form-control" type="text" name="PrimerApellido" id="PrimerApellido" value="<?php echo $PrimerApellido;?>" required/>
												<label for="PrimerApellido">Primer Apellido</label>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group floating-label">
												<input class="form-control" type="text" name="SegundoApellido" id="SegundoApellido" value="<?php echo $SegundoApellido;?>" />
												<label for="SegundoApellido">Segundo Apellido</label>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group floating-label">
												<input class="form-control" type="text" name="ApellidoCasada" id="ApellidoCasada" value="<?php echo $ApellidoCasada;?>"/>
												<label for="ApellidoCasada">Apellido de Casada</label>
											</div>
										</div>
									</div>
									<div>
										<h5>Género</h5>	
										<?php
										if($Sexo == 'M')
										{
											?>
											<label class="radio-inline radio-styled">
												<input type="radio" value="M" name="Sexo" checked="checked" required>
												<span>Masculino</span>
											</label>
											<label class="radio-inline radio-styled" >
												<input type="radio" value="F" name="Sexo" required>
												<span>Femenino</span>
											</label>
											<?php
										}
										else
										{
											?>
											<label class="radio-inline radio-styled">
												<input type="radio" value="M" name="Sexo" required>
												<span>Masculino</span>
											</label>
											<label class="radio-inline radio-styled" >
												<input type="radio" value="F" name="Sexo" checked="checked" required>
												<span>Femenino</span>
											</label>
											<?php
										}	
										?>
									</div>
									<br>
									<div class="row">
										<div class="col-lg-4 col-lg-8">
											<div class="form-group">
												<select name="Nacionalidad" id="Nacionalidad" class="form-control" required onchange="VerificarNacionalidad(this.value)">
													<option value="" disabled selected>Seleccione una opción</option>
													<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
													$query = "SELECT * FROM  info_base.lista_nacionalidades ORDER BY nacionalidad";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														if($row["id"] == $Nacionalidad)
														{
															$Seleccionado = 'Selected';
														}
														else
														{
															$Seleccionado = '';
														}
														echo '<option value="'.$row["id"].'" '.$Seleccionado.'>'.$row["nacionalidad"].'</option>';
													}

													?>
												</select>
												<label for="Nacionalidad">Nacionalidad</label>
											</div>
										</div>
									</div>
									<?php
									if($Nacionalidad == 35)
									{
										?>
										<div class="row" id="DIVDPI" >
											<div class="col-lg-4 col-lg-8">
												<div class="form-group floating-label">
													<input class="form-control" type="number" name="DPI" id="DPI" min="0" value="<?php echo $DPI;?>"/>
													<label for="DPI">DPI</label>
												</div>
											</div>
										</div>

										<?php
									}
									else
									{
										?>
										<div class="row" id="DIVPasaporte" >
											<div class="col-lg-4 col-lg-8">
												<div class="form-group floating-label">
													<input class="form-control" type="number" name="Pasaporte" id="Pasaporte" min="0" value="<?php echo $Pasaporte;?>"/>
													<label for="Pasaporte"># de Pasaporte</label>
												</div>
											</div>
										</div>

										<?php
									}
									?>
									
									<div>
										<h5>Estado Civil</h5>
										<label class="radio-inline radio-styled">
											<input type="radio" value="C" <?php if($EstadoCivil == 'C'){echo 'checked="checked"';} ?> name="EstadoCivil">
											<span>Casado(a)</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="S" <?php if($EstadoCivil == 'S'){echo 'checked="checked"';} ?> name="EstadoCivil">
											<span>Soltero(a)</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="U" <?php if($EstadoCivil == 'U'){echo 'checked="checked"';} ?> name="EstadoCivil">
											<span>Union Libre</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="D" <?php if($EstadoCivil == 'D'){echo 'checked="checked"';} ?> name="EstadoCivil">
											<span>Divorciado(a)</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="V" <?php if($EstadoCivil == 'V'){echo 'checked="checked"';} ?> name="EstadoCivil">
											<span>Viudo(a)</span>
										</label>
									</div>
									<div class="row" >
										<div class="col-lg-4 col-lg-8">
											<div class="form-group floating-label">
												<input class="form-control" type="text" name="NIT" id="NIT" value="<?php echo $NIT;?>"/>
												<label for="NIT"># de NIT</label>
											</div>
										</div>
									</div>
									<div class="row" >
										<div class="col-lg-4 col-lg-8">
											<div class="form-group">
												<input class="form-control" type="date" name="FechaNacimiento" id="FechaNacimiento" value="<?php echo $FechaNacimiento;?>" required/>
												<label for="FechaNacimiento">Fecha de Nacimiento</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-lg-6">
											<div class="form-group floating-label">
												<textarea class="form-control" name="Direccion" id="Direccion"required><?php echo $Direccion;?></textarea>
												<label for="Direccion">Dirección</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4 col-lg-8">
											<div class="form-group">
												<select name="DepartamentoResidencia" id="DepartamentoResidencia" class="form-control"  required onchange="MostrarMunicipios(this.value)">
													<option value="" disabled selected>Seleccione una opción</option>
													<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
													$query = "SELECT id_departamento, nombre_departamento FROM  info_base.departamentos_guatemala ORDER BY nombre_departamento";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														if($row["id_departamento"] == $DepartamentoResidencia)
														{
															$Seleccionado = 'Selected';
														}
														else
														{
															$Seleccionado = '';
														}
														echo '<option value="'.$row["id_departamento"].'" '.$Seleccionado.'>'.$row["nombre_departamento"].'</option>';
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
												<select name="MunicipioResidencia" id="MunicipioResidencia" class="form-control" id="MunicipioResidencia" required>	
												<?php
													$query = "SELECT id_municipio, nombre_municipio FROM  info_base.municipios_guatemala WHERE id_departamento = ".$DepartamentoResidencia." ORDER BY nombre_municipio";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														if($row["id_municipio"] == $MunicipioResidencia)
														{
															$Seleccionado = 'Selected';
														}
														else
														{
															$Seleccionado = '';
														}
														echo '<option value="'.$row["id_municipio"].'" '.$Seleccionado.'>'.$row["nombre_municipio"].'</option>';
													}
												?>
												</select>
												<label for="MunicipioResidencia">Municipio de Residencia</label>
											</div>
										</div>
									</div>
									<div class="row" >
										<div class="col-lg-4 col-lg-8">
											<div class="form-group floating-label">
												<input class="form-control" type="number" name="Celular" id="Celular" min="0" value="<?php echo $Celular;?>" required/>
												<label for="Celular">Número de Celular</label>
											</div>
										</div>
										<div class="col-lg-4 col-lg-8">
											<div class="form-group floating-label">
												<input class="form-control" type="number" name="Telefono" id="Telefono" value="<?php echo $Telefono;?>" min="0"/>
												<label for="Telefono">Número de Teléfono</label>
											</div>
										</div>
									</div>
									<div class="row" >
										<div class="col-lg-4 col-lg-8">
											<div class="form-group floating-label">
												<input class="form-control" type="email" name="EmailInstitucional" id="EmailInstitucional" value="<?php echo $EmailInstitucional;?>" >
												<label for="EmailInstitucional">Correo Electrónico Institucional</label>
											</div>
										</div>
										<div class="col-lg-4 col-lg-8">
											<div class="form-group floating-label">
												<input class="form-control" type="email" name="EmailPersonal" id="EmailPersonal" value="<?php echo $EmailPersonal;?>" />
												<label for="EmailPersonal">Correo Electrónico Personal</label>
											</div>
										</div>
									</div>
									<div class="row" >
										<div class="col-lg-4 col-lg-8">
											<div class="form-group floating-label">
												<input class="form-control" type="text" name="Profesion" id="Profesion" value="<?php echo $Profesion;?>" >
												<label for="Profesion">Profesión</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-lg-6">
											<div class="form-group floating-label">
												<textarea class="form-control" name="Observaciones" id="Observaciones"><?php echo $Observaciones;?></textarea>
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
												<select name="DepartamentoLaboral" id="DepartamentoLaboral" class="form-control" required>
													<option value="" disabled selected>Seleccione una opción</option>
													<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
													$query = "SELECT id_depto, nombre_depto FROM info_base.departamentos ORDER BY nombre_depto";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														if($row["id_depto"] == $DepartamentoLaboral)
														{
															$Seleccionado = 'Selected';
														}
														else
														{
															$Seleccionado = '';
														}
														echo '<option value="'.$row["id_depto"].'" '.$Seleccionado.'>'.$row["nombre_depto"].'</option>';
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
												<select name="Puesto" id="Puesto" class="form-control" required>
													<option value="" disabled selected>Seleccione una opción</option>
													<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
													$query = "SELECT id_puesto, nombre_puesto FROM info_base.define_puestos ORDER BY nombre_puesto";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														if($row["id_puesto"] == $Puesto)
														{
															$Seleccionado = 'Selected';
														}
														else
														{
															$Seleccionado = '';
														}
														echo '<option value="'.$row["id_puesto"].'" '.$Seleccionado.'>'.$row["nombre_puesto"].'</option>';
													}

													?>
												</select>
												<label for="Puesto">Puesto Laboral</label>
											</div>
										</div>
									</div>
									<div class="row" >
										<div class="col-lg-4 col-lg-8">
											<div class="form-group">
												<input class="form-control" type="date" name="FechaIngreso" id="FechaIngreso" value="<?php echo $FechaIngreso;?>" required/>
												<label for="FechaIngreso">Fecha de Ingreso a la Institución</label>
											</div>
										</div>
									</div>
									<div>
										<h5>Estado Laboral</h5>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="1" <?php if($EstadoLaboral == 1){echo 'checked="checked"';} ?> name="EstadoLaboral">
											<span>Activo(a)</span>
										</label>
										<label class="radio-inline radio-styled">
											<input type="radio" value="0" <?php if($EstadoLaboral == 0 || $EstadoLaboral == 5){echo 'checked="checked"';} ?> name="EstadoLaboral">
											<span>Inactivo(a)</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="2" <?php if($EstadoLaboral == 2){echo 'checked="checked"';} ?> name="EstadoLaboral">
											<span>Suspendido(a)</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="3" <?php if($EstadoLaboral == 3){echo 'checked="checked"';} ?> name="EstadoLaboral">
											<span>Vacaciones</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="4" <?php if($EstadoLaboral == 4){echo 'checked="checked"';} ?> name="EstadoLaboral">
											<span>Permiso</span>
										</label>
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
														<input type="text" class="form-control" id="Usuario" name="Usuario" value="<?php echo $Username;?>" readonly>
														<label for="Usuario">Usuario</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-lg-6">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-content">
														<button type="button" class="btn btn-block ink-reaction btn-danger" onClick="ReiniciarPass()">Reiniciar Contraseña</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4 col-lg-8">
											<div class="form-group">
												<select name="ClasificacionUsuario" id="ClasificacionUsuario" class="form-control" onchange="ObtenerDepartamentosLaborales(this.value)">
													<option value="1" <?php if($Clasificacionusuario == 1){echo "selected";} ?>>Colaborador</option>
													<option value="2" <?php if($Clasificacionusuario == 2){echo "selected";} ?>>Usuario Portal</option>
												</select>
												<label for="ClasificacionUsuario">Tipo de Usuario</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="card">
								<div class="card-head style-primary">
									<h4 class="text-center"><strong>Permisos Portal</strong></h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div id="ListadoApp"></div>
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
					<?php
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
	<script src="../../../js/libs/jquery-ui/jquery-ui.min.js"></script>
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
	<script src="../../../libs/alertify/js/alertify.js"></script>
	<!-- END JAVASCRIPT -->

</body>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		var CIF = $("#CIF").val();
		ListadoAplicacion(CIF);
	});

	function ListadoAplicacion(CIF)
	{
		$.ajax({
			url: 'Ajax/AsignarAplicativos.php',
			type: 'POST',
			dataType: 'html',
			data: {CIF: CIF},
			success:function(data)
			{
				$("#ListadoApp").html(data);
			}
		})  
	}
</script>
</html>
