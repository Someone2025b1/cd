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

	<script language=javascript type=text/javascript>
		$(document).on("keypress", 'form', function (e) {
		    var code = e.keyCode || e.which;
		    if (code == 13) {
		        e.preventDefault();
		        return false;
		    }
		});
	</script>
	<script>
		function ObtenerMunicipio(x)
		{
			var Departamento = x;

			$.ajax({
				url: 'ObtenerMunicipios.php',
				type: 'post',
				data: 'Departamento='+Departamento,
				success: function (data) {
					$('#Municipio').html(data);
				}
			});
			
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

	<?php 
	$Query = mysqli_query($db, "SELECT * FROM Taquilla.HOTEL WHERE H_CODIGO = ".$_GET["Codigo"]);
	$fila = mysqli_fetch_array($Query);

	$Nombre = $fila["H_NOMBRE"];
	$Direccion = $fila["H_DIRECCION"];
	$Departamento = $fila["H_DEPARTAMENTO"];
	$Municipio = $fila["H_MUNICIPIO"];
	$TelefonoPrincipal = $fila["H_TELEFONO"];
	$TelefonoSecundario = $fila["H_TELEFONO_1"];
	$Email = $fila["H_EMAIL"];
	$Publicidad = $fila["H_PUBLICIDAD"];
	$DireFac = $fila["H_DIRECCION_FAC"];
	$Contacto = $fila["H_CONTACTO"];
	$NombreFac = $fila["H_NOMBRE_FAC"];
	$NitFac = $fila["H_NIT_FAC"]; 
	?>

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="HModPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Modificar un Hotel</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<input type="text" name="Nombre" id="Nombre" class="form-control" value="<?php echo $Nombre ?>" required="required">
											<input type="hidden" name="Codigo" id="Codigo" class="form-control" value="<?php echo $_GET["Codigo"] ?>" required="required">
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<input type="text" name="Direccion" id="Direccion" class="form-control" value="<?php echo $Direccion ?>" required="required">
											<label for="Direccion">Dirección</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select name="Departamento" id="Departamento" class="form-control" required onchange="ObtenerMunicipio(this.value)">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM info_base.departamentos_guatemala ORDER BY nombre_departamento";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													if($Departamento == $row["id_departamento"])
													{
														$Texto = 'selected';
													}
													else
													{
														$Texto = '';
													}
													echo '<option value="'.$row["id_departamento"].'" '.$Texto.'>'.$row["nombre_departamento"].'</option>';
												}

												?>
											</select>
											<label for="Departamento">Departamento</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select name="Municipio" id="Municipio" class="form-control" value="<?php echo $Nombre ?>" required>
											<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM info_base.municipios_guatemala WHERE id_departamento = $Departamento ORDER BY nombre_municipio";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													if($Municipio == $row["id"])
													{
														$Texto = 'selected';
													}
													else
													{
														$Texto = '';
													}
													echo '<option value="'.$row["id"].'" '.$Texto.'>'.$row["nombre_municipio"].'</option>';
												}

												?>
											</select>
											<label for="Municipio">Municipio</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input type="number" name="TelefonoPrincipal" id="TelefonoPrincipal" class="form-control" value="<?php echo $TelefonoPrincipal ?>" required="required">
											<label for="TelefonoPrincipal">Teléfono Principal</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input type="number" name="TelefonoSecundario" id="TelefonoSecundario" class="form-control" value="<?php echo $TelefonoSecundario ?>" >
											<label for="TelefonoSecundario">Teléfono Secundario</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<input type="email" name="Email" id="Email" class="form-control" value="<?php echo $Email ?>" >
											<label for="Email">Email</label>
										</div>
									</div>
								</div>
									<div class="row">
									<div class="col-lg-8">
										<div class="form-group">
											<textarea class="form-control" id="Publicidad" name="Publicidad" placeholder="Describa la publicidad..."><?php echo $Publicidad ?></textarea>
											<label for="Publicidad">Tipo de Publicidad Instalada</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<input type="text" name="Contacto" id="Contacto" class="form-control" value="<?php echo $Contacto ?>">
											<label for="Contacto">Nombre del Contacto</label>
										</div>
									</div>
								</div>
								<h3 class="text-center">DATOS DE FACTURACIÓN</h3>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<input type="text" name="NombreFacturacion" id="NombreFacturacion" class="form-control" value="<?php echo $NombreFac ?>">
											<label for="NombreFacturacion">Nombre</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<input type="text" name="NitFacturacion" id="NitFacturacion" class="form-control" value="<?php echo $NitFac ?>">
											<label for="NitFacturacion">Nit</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<input type="text" name="DireccionFacturacion" id="DireccionFacturacion" class="form-control" value="<?php echo $DireFac ?>">
											<label for="DireccionFacturacion">Dirección</label>
										</div>
									</div>
								</div>
								<div class="row text-center">
									<button type="submit" class="btn btn-primary btn-lg">Enviar</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../../Hotel/MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
