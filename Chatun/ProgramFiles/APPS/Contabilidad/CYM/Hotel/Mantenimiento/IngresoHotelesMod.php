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
	
		$Query = mysqli_query($db, "SELECT * FROM Taquilla.INGRESO_HOTEL AS A WHERE A.IH_ID = ".$_GET["Codigo"]);

		$Fila = mysqli_fetch_array($Query);

		$Vale         = $Fila["IH_VALE"];
		$Adulto = $Fila["IH_ADULTOS"];
		$Nino   = $Fila["IH_NINOS"];
		$menores   = $Fila["IH_MENORES_5"];
		$IdHotel  = $Fila["H_CODIGO"];
		$AdultoM = $Fila["IH_ADULTO_MAYOR"];
		$PrecioAd = $Fila["IH_PRECIO_ADULTO"];
		$PrecioNi = $Fila["IH_PRECIO_NINO"];
		$PrecioAdM = $Fila["IH_PRECIO_ADULTO_MAYOR"];
		$Col = $Fila["IH_COLABORADOR"];
		$FechaEvento = $Fila["IH_FECHA"];
	

		$sqlRet = mysqli_query($db,"SELECT A.nombre 
		FROM info_bbdd.usuarios AS A     
		WHERE A.id_user = ".$Col); 
		$rowret=mysqli_fetch_array($sqlRet);

		$NombreGenero=$rowret["nombre"];

	?>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Ingreso Hoteles</strong><br></h1>
				<br>
				<form class="form" action="IngresoHotelesModPro.php" method="POST" role="form">
					<input type="hidden" name="Codigo" value="<?php echo $_GET["Codigo"] ?>">
					
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Vale</strong></h4>
							</div>
							<div class="card-body">
							<div class="row">
									<div class="col-lg-3">
										<label for="Evento" style="color: green; font-weight:bold">Hotel</label>
										<select name="Hotel" id="Hotel" class="form-control">
												<?php 
												$ListEvento = mysqli_query($db, "SELECT a.H_NOMBRE, a.H_CODIGO FROM Taquilla.HOTEL a WHERE a.H_NOMBRE <> ''");
												while ($RowEvento = mysqli_fetch_array($ListEvento)) 
												{
												?>
												<option <?php if ( $RowEvento["H_CODIGO"]== $IdHotel){?>selected= "selected"<?php } ?> value="<?php echo $RowEvento["H_CODIGO"] ?>"><?php echo $RowEvento["H_NOMBRE"] ?></option>
												<?php 
												}
												?> 
											</select>
									</div>
								</div>
							<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Vale" id="Vale" value="<?php echo $Vale ?>" required readonly/>
											<label for="Vale" style="color: green; font-weight:bold">Vale</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Ingreso" id="Ingreso" value="<?php echo $NombreGenero ?>" required readonly/>
											<label for="DuenoEvento" style="color: green; font-weight:bold">Ingreso</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="CantidadAdultos" id="CantidadAdultos" value="<?php echo $Adulto ?>" required/>
											<label for="CantidadAdultos" style="color: green; font-weight:bold">Cantidad de Adultos</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="CantidadNino" id="CantidadNino" value="<?php echo $Nino ?>" required/>
											<label for="CantidadNino" style="color: green; font-weight:bold">Cantidad de Niños</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="CantidadAdultosM" id="CantidadAdultosM" value="<?php echo $AdultoM ?>" required/>
											<label for="CantidadAdultosM" style="color: green; font-weight:bold">Cantidad de Adultos Mayores</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="CantidadNinoMenor" id="CantidadNinoMenor" value="<?php echo $menores ?>" required/>
											<label for="CantidadNinoMenor" style="color: green; font-weight:bold">Cantidad de Niños Menores a 5 Años</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="PreciodAdultos" id="PreciodAdultos" value="<?php echo $PrecioAd ?>" required/>
											<label for="PreciodAdultos" style="color: green; font-weight:bold">Precio de Adultos</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="PrecioNino" id="PrecioNino" value="<?php echo $PrecioNi ?>" required/>
											<label for="PrecioNino" style="color: green; font-weight:bold">Precio de Niños</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="PreciodAdultosM" id="PreciodAdultosM" value="<?php echo $PrecioAdM ?>" required/>
											<label for="PreciodAdultosM" style="color: green; font-weight:bold">Precio de Adultos Mayores</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
									<div class="input-group-content">
									<label style="color: green; font-weight:bold">Fecha Ingreso</label>
											<input type="date" class="form-control" name="FechaIngreso" value="<?php echo $FechaEvento ?>">
											
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
