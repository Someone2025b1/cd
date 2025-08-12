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
	

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Cierre de Cajas</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Cierres</strong></h4>
						</div>
						<div class="card-body">
							<form class="form" action="#" method="POST" role="form">
								<div class="row">
									<div class="col-lg-2 floating-label">
										<div class="form-group">
										<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" required/>
											<label for="Fecha">Fecha de Cierre</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-3">
										<label for="Tipo">De</label>
										<div class="form-group">
											<select class="form-control" name="Tipo" required>
												<option value="" selected disable>Seleccione una opción</option>
												<option value="HS">Helados</option>
												<option value="KR">Kiosko Restaurante</option>
												<option value="KR2">Kiosko Restaurante 2</option>
												<option value="TR">Restaurante</option>
												<option value="SV">Souvenirs</option>
												<option value="TQ">Taquilla</option>
												<option value="EV">Eventos</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-lg-12" align="center">
									<button type="submit" class="btn ink-reaction btn-raised btn-primary">Consultar</button>
								</div>
							</form>
							<div class="row">
								<br>
								<br>
								<br>
							</div>
							<?php
								if(isset($_POST[Fecha]))
								{
									if($_POST[Tipo] == 'HS')
									{
										$Tabla = "FACTURA_HS";
									}
									elseif($_POST[Tipo] == 'KR')
									{
										$Tabla = "FACTURA_KS";
									}
									elseif($_POST[Tipo] == 'KR2')
									{
										$Tabla = "FACTURA_KS_2";
									}
									elseif($_POST[Tipo] == 'TR')
									{
										$Tabla = "FACTURA";
									}
									elseif($_POST[Tipo] == 'SV')
									{
										$Tabla = "FACTURA_SV";
									}
									elseif($_POST[Tipo] == 'TQ')
									{
										$Tabla = "FACTURA_TQ";
									}
									elseif($_POST[Tipo] == 'EV')
									{
										$Tabla = "FACTURA_EV";
									}
									$Query = mysqli_query($db, "SELECT MIN(A.F_NUMERO) AS MINIMO, MAX(A.F_NUMERO) AS MAXIMO
															FROM Bodega.$Tabla AS A
															WHERE A.F_FECHA_TRANS = '".$_POST[Fecha]."'");

									$Fila = mysqli_fetch_array($Query);


									?>
										<h3 class="text-center"><strong>Se ha factura del <?php echo number_format($Fila[MINIMO]).' al '.number_format($Fila[MAXIMO]) ?></strong></h3>
										<h4 class="text-center">Un total de <?php echo number_format($Fila[MAXIMO] - $Fila[MINIMO]) ?> facturas realizadas</h4>
										<div class="row">
											<br>
											<br>
											<br>
										</div>
										<form action="ImprimirFacturas.php" role="form" class="form" target="_blank">
											<input type="hidden" name="Tabla" value="<?php echo $Tabla ?>">
											<input type="hidden" name="PV" value="<?php echo $_POST[Tipo] ?>">
											<div class="row">
												<div class="col-lg-offset-5 col-lg-7">
													<div class="col-lg-2 floating-label">
														<div class="form-group">
														<input class="form-control" type="number" name="Del" id="Del" value="<?php echo $Fila[MINIMO] ?>" min="<?php echo $Fila[MINIMO] ?>" required/>
															<label for="Del">Del</label>
														</div>
													</div>
													<div class="col-lg-2 floating-label">
														<div class="form-group">
														<input class="form-control" type="number" name="Al" id="Al" value="<?php echo $Fila[MAXIMO] ?>" max="<?php echo $Fila[MAXIMO] ?>" required/>
															<label for="Al">Al</label>
														</div>
													</div>
													<div class="col-lg-2">
														<button type="submit" class="btn btn-lg btn-success"><span class="glyphicon glyphicon-print"></span></button>
													</div>
												</div>
											</div>
										</form>
									<?php
								}
							?>
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
