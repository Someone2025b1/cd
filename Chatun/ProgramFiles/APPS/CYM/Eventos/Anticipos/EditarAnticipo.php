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

        $Codigo = $_GET["Codigo"];


        $Consulta = "SELECT * FROM Contabilidad.ANTICIPO_EVENTOS WHERE AE_ESTADO=0 AND AE_CODIGO = '$Codigo' ORDER BY AE_CODIGO";
                $Resultado = mysqli_query($db, $Consulta);
                while($row = mysqli_fetch_array($Resultado))
                {
                    $Nombre=$row["AE_NOMBRE_CLIENTE"];
                    $Fecha=$row["AE_FECHA_EVENTO"];
                    $Monto=$row["AE_MONTO"];
                    $CodigoUser=$row["AE_USER"];
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
				<h1 class="text-center"><strong>Mantenimiento de Ingreso Hoteles</strong><br></h1>
				<br>
				<form class="form" action="EditarAnticipoPro.php" method="POST" role="form">
					<input type="hidden" name="Codigo" value="<?php echo $_GET["Codigo"] ?>">
					
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Anticipo</strong></h4>
							</div>
							<div class="card-body">
                            <div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Vale" id="Vale" value="<?php echo $Codigo ?>" required readonly/>
											<label for="Vale" style="color: green; font-weight:bold">Codigo</label>
										</div>
									</div>
								</div>
                                <div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Vale" id="Vale" value="<?php echo $Nombre ?>" required readonly/>
											<label for="Vale" style="color: green; font-weight:bold">Nombre del Anticipo</label>
										</div>
									</div>
								</div>
                                <div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="date" name="Vale" id="Vale" value="<?php echo $Fecha ?>" required readonly/>
											<label for="Vale" style="color: green; font-weight:bold">Fecha del evento</label>
										</div>
									</div>
								</div>
                            <div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Vale" id="Vale" value="<?php echo $Monto ?>" required readonly/>
											<label for="Vale" style="color: green; font-weight:bold">Monto</label>
										</div>
									</div>
								</div>
							<div class="row">
									<div class="col-lg-3">
										<label for="Vendedor" style="color: green; font-weight:bold">Vendedora</label>
										<select name="Vendedor" id="Vendedor" class="form-control">
												
								        <option <?php if ( $CodigoUser== 31827){?>selected= "selected"<?php } ?> value="31827">ROSMERI PACHECO</option>
								        <option <?php if ( $CodigoUser== 116558){?>selected= "selected"<?php } ?> value="116558">CELESTE CASTILLO</option>
								        <option <?php if ( $CodigoUser== 1292232){?>selected= "selected"<?php } ?> value="1292232">MARIANELY DUBOM</option>
												
												?> 
											</select>
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
