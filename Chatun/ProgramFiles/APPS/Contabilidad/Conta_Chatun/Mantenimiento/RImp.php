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

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Reimpresión de Partidas</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Partida</strong></h4>
						</div>
						<div class="card-body">
							<div class="col-lg-12">
								<div class="card card-underline">
									<div class="card-head">
										<ul class="nav nav-tabs pull-right" data-toggle="tabs">
											<li class="active"><a href="#first2">Por Fecha</a></li>
											<li><a href="#second2">Por Número</a></li>
											<li><a href="#second3">Por Correlativo</a></li>
										</ul>
										<header>Búsqueda de Partida</header>
									</div>
									<div class="card-body tab-content">
										<div class="tab-pane active" id="first2">
											<form action="RImpPro.php" method="POST" role="form" class="form" >
												<div class="row">
													<div class="col-lg-3">
														<div class="form-group">
															<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" required/>
															<label for="Fecha">Fecha</label>
														</div>
													</div>	
												</div>
												<div class="col-lg-12" align="center">
													<button type="submit" class="btn ink-reaction btn-raised btn-primary">Consultar</button>
												</div>
											</form>
										</div>
										<div class="tab-pane" id="second2">
											<form action="ImpPartida.php" method="POST" role="form" class="form" target="_blnk">
												<div class="row">
													<div class="col-lg-3">
														<div class="form-group">
															<input class="form-control" type="text" name="Partida" id="Partida" value="<?php echo date('Y-m-d'); ?>" required/>
															<label for="Partida">No. Partida</label>
														</div>
													</div>	
												</div>
												<div class="col-lg-12" align="center">
													<button type="submit" class="btn ink-reaction btn-raised btn-primary">Consultar</button>
												</div>
											</form>
										</div>
										<div class="tab-pane" id="second3">
											<form action="ImpPartidaHoja.php" method="POST" role="form" class="form" target="_blnk">
												<div class="row">
													<div class="col-lg-3">
														<div class="form-group">
															<input class="form-control" type="text" name="Partida" id="Partida" value="<?php echo date('Y-m-d'); ?>" required/>
															<label for="Partida">No. Hoja</label>
														</div>
													</div>	
												</div>
												<div class="col-lg-12" align="center">
													<button type="submit" class="btn ink-reaction btn-raised btn-primary">Consultar</button>
												</div>
											</form>
										</div>
									</div>
								</div><!--end .card -->
							</div>
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
