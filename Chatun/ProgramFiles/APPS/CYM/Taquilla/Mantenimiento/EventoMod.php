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

	<?php
	$tipodereevento = $_GET["TipoEvento"];
	if($tipodereevento==1){
		$Query = mysqli_query($db, "SELECT * FROM Taquilla.ASOCIADOS_FORMACION AS A WHERE A.AF_ID = ".$_GET["Codigo"]);

		$Fila = mysqli_fetch_array($Query);

		$Nombre         = $Fila["NOMBRE_EVENTO"];
		$DuenoEvento = $Fila["IE_DUENO_EVENTO"];
		$CantidadPersonas         = $Fila["AF_PARTICIPANTES"];
		$Empresa   = $Fila["IE_NOMBRE_EMPRESA"];
		$IdEvento  = $Fila["E_ID"];
		$ClasificacionEvento = $Fila["CE_ID"];
		$AreaUtilizarID = $Fila["AU_ID"];
		$TelEmpresa = $Fila["IE_TEL_EMPRESA"];
		$FechaEvento = $Fila["AF_FECHA"];
	}

	if($tipodereevento==2){
		$Query = mysqli_query($db, "SELECT * FROM Taquilla.INGRESO_EVENTO AS A WHERE A.IE_ID = ".$_GET["Codigo"]);

		$Fila = mysqli_fetch_array($Query);

		$Nombre         = $Fila["NOMBRE_EVENTO"];
		$DuenoEvento = $Fila["IE_DUENO_EVENTO"];
		$CantidadPersonas         = $Fila["IE_CANTIDAD_PERSONAS"];
		$Empresa   = $Fila["IE_NOMBRE_EMPRESA"];
		$IdEvento  = $Fila["E_ID"];
		$ClasificacionEvento = $Fila["CE_ID"];
		$AreaUtilizarID = $Fila["AU_ID"];
		$TelEmpresa = $Fila["IE_TEL_EMPRESA"];
		$FechaEvento = $Fila["IE_FECHA_EVENTO"];
	}

	?>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Eventos</strong><br></h1>
				<br>
				<form class="form" action="EventoModPro.php" method="POST" role="form">
					<input type="hidden" name="Codigo" value="<?php echo $_GET["Codigo"] ?>">
					<input type="hidden" name="TipoEvento" value="<?php echo $_GET["TipoEvento"] ?>">
					
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Evento</strong></h4>
							</div>
							<div class="card-body">
							<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $Nombre ?>" required/>
											<label for="Nombre" style="color: green; font-weight:bold">Nombre</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="DuenoEvento" id="DuenoEvento" value="<?php echo $DuenoEvento ?>" required/>
											<label for="DuenoEvento" style="color: green; font-weight:bold">Dueño Evento</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="CantidadPersonas" id="CantidadPersonas" value="<?php echo $CantidadPersonas ?>" required/>
											<label for="CantidadPersonas" style="color: green; font-weight:bold">Cantidad de Personas</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="NombreEmpresa" id="NombreEmpresa" value="<?php echo $Empresa ?>" required/>
											<label for="NombreEmpresa" style="color: green; font-weight:bold">Nombre Empresa</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
									<div class="input-group-content">
											<input type="date" class="form-control" name="FechaEvento" value="<?php echo $FechaEvento ?>">
											<label style="color: green; font-weight:bold">Fecha Evento</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="TelEmpresa" id="TelEmpresa" value="<?php echo $TelEmpresa ?>" required/>
											<label for="TelEmpresa" style="color: green; font-weight:bold">Tel. Empresa</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<label for="Evento" style="color: green; font-weight:bold">Evento</label>
										<select name="EventoID" id="EventoID" class="form-control">
												<?php 
												$ListEvento = mysqli_query($db, "SELECT a.E_DESCRIPCION, a.E_ID FROM Taquilla.EVENTO a WHERE a.E_DESCRIPCION <> ''");
												while ($RowEvento = mysqli_fetch_array($ListEvento)) 
												{
												?>
												<option <?php if ( $RowEvento["E_ID"]== $IdEvento){?>selected= "selected"<?php } ?> value="<?php echo $RowEvento["E_ID"] ?>"><?php echo $RowEvento["E_DESCRIPCION"] ?></option>
												<?php 
												}
												?> 
											</select>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<label for="ClasificadorID" style="color: green; font-weight:bold">Clasificación de Evento</label>
										<select name="ClasificadorID" id="ClasificadorID" class="form-control">
												<?php 
												$ListEvento = mysqli_query($db, "SELECT a.CE_DESCRIPCION, a.CE_ID FROM Taquilla.CLASIFICADOR_EVENTO a");
												while ($RowEvento = mysqli_fetch_array($ListEvento)) 
												{
												?>
												<option <?php if ( $RowEvento["CE_ID"]== $ClasificacionEvento){?>selected= "selected"<?php } ?> value="<?php echo $RowEvento["CE_ID"] ?>"><?php echo $RowEvento["CE_DESCRIPCION"] ?></option>
												<?php 
												}
												?> 
											</select>
									</div>
							</div>
							<div class="row">
									<div class="col-lg-3">
										<label for="AreaUtilizarID" style="color: green; font-weight:bold">Área a Utilizar</label>
										<select name="AreaUtilizarID" id="AreaUtilizarID" class="form-control">
												<?php 
												$ListEvento = mysqli_query($db, "SELECT a.AU_DESCRIPCION, a.AU_ID FROM Taquilla.AREA_UTILIZAR a");
												while ($RowEvento = mysqli_fetch_array($ListEvento)) 
												{
												?>
												<option <?php if ( $RowEvento["AU_ID"]== $AreaUtilizarID){?>selected= "selected"<?php } ?> value="<?php echo $RowEvento["AU_ID"] ?>"><?php echo $RowEvento["AU_DESCRIPCION"] ?></option>
												<?php 
												}
												?> 
											</select>
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
