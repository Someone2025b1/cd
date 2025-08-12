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
		$Codigo = $_GET["Codigo"];
		$Consulta = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE PC_CODIGO = '".$Codigo."'";
		$Resultado = mysqli_query($db, $Consulta);
		while($row = mysqli_fetch_array($Resultado))
		{
			$Mes = $row["PC_MES"];
			$Anho = $row["PC_ANHO"];
			$Estado = $row["EPC_CODIGO"];
		}
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Períodos Contables</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<form action="PCModPro.php" method="POST">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Consulta de Periodos Contables</strong></h4>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-lg-2">
									<div class="form-group floating-label">
									<input class="form-control" type="number" min="1" max="12" name="Mes" id="Mes" value="<?php echo $Mes; ?>" readonly required/>
										<label for="Mes">Mes</label>
									</div>
								</div>
							</div> 
							<div class="row">
								<div class="col-lg-2">
									<div class="form-group floating-label">
									<input class="form-control" type="number" min="2016" name="Anho" id="Anho" value="<?php echo $Anho; ?>" readonly required/>
										<label for="Anho">Año</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-2">
									<div class="form-group floating-label">
										<select name="Estado" id="Estado" class="form-control">
											<option value="1" <?php if($Estado == 1){echo 'selected';} ?>>Activo</option>
											<option value="2" <?php if($Estado == 2){echo 'selected';} ?>>Cerrado</option>
										</select>
										<label for="Estado">Estado</label>
									</div>
								</div>
							</div>
							<div class="col-lg-12" align="center">
								<input class="form-control" type="hidden" name="Codigo" id="Codigo" value="<?php echo $Codigo; ?>" readonly required/>
								<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
							</div>
						</div>
					</div>
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
