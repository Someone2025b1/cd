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

	<?php
		$sql = "SELECT * FROM Contabilidad.TASA_CAMBIO WHERE TC_CODIGO = 1";
		$result = mysqli_query($db, $sql);
		while($fila = mysqli_fetch_array($result))
		{
			$TasaCambioLempira = $fila["TC_TASA"];
		}

		$sql1 = "SELECT * FROM Contabilidad.TASA_CAMBIO WHERE TC_CODIGO = 2";
		$result1 = mysqli_query($db, $sql1);
		while($fila1 = mysqli_fetch_array($result1))
		{
			$TasaCambioDolar = $fila1["TC_TASA"];
		}
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Tasa de Cambio</strong></h4>
						</div>
						<div class="card-body">
							<form class="form" action="TCPro.php" method="POST" role="form">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
											<input class="form-control" type="text" name="TasaCambioLempira" id="TasaCambioLempira" value="<?php echo $TasaCambioLempira ?>" required/>
											<label for="TasaCambioLempira">Tasa de Cambio Lempira</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
											<input class="form-control" type="text" name="TasaCambioDolar" id="TasaCambioDolar" value="<?php echo $TasaCambioDolar ?>" required/>
											<label for="TasaCambioDolar">Tasa de Cambio Dólar</label>
										</div>
									</div>
								</div>
								<div class="row text-center">
									<button type="submit" class="btn ink-reaction btn-raised btn-primary">Actualizar</button>
								</div>
							</form>
						</div>
					</div>
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
