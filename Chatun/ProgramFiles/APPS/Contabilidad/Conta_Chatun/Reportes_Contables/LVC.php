<?php
ob_start();
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


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php 

	include("../../../../MenuTop.php");
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="#" method="GET" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Libro Ventas</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<div class="col-lg-3"></div>
									<div class="col-lg-6">
										<div class="form-group">
											<select name="Mes" class="form-control" required>
												<option value="" disabled selected>Seleccione un Mes</option>
												<option value="1">Enero</option>
												<option value="2">Febrero</option>
												<option value="3">Marzo</option>
												<option value="4">Abril</option>
												<option value="5">Mayo</option>
												<option value="6">Junio</option>
												<option value="7">Julio</option>
												<option value="8">Agosto</option>
												<option value="9">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="row text-center">
									<div class="col-lg-5"></div>
									<div class="col-lg-2">
										<div class="form-group">
											<input class="form-control" name="anho" id="anho" type="number" min="2016" max="2050" value="<?php echo date('Y', strtotime('now')); ?>" required>
											<label for="anho">Año</label>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="row text-center">
									<div class="col-lg-4"></div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="TipoEstablecimiento">Establecimiento</label>
											<select class="form-control" name="TipoEstablecimiento" id="TipoEstablecimiento" >
												<option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
												<option value="1">ACERCATE I</option>
												<option value="2">ACERCATE II</option>
												<option value="3">21K</option>
											</select>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="row text-center">
									<div class="col-lg-4"></div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="TipoReporte">Tipo Reporte</label>
											<select class="form-control" name="TipoReporte" id="TipoReporte" >
												<option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
												<option value="1">PDF</option>
												<option value="2">Sistema</option>
											</select>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="col-lg-12" align="center">
									<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Consultar</button>
								</div>
							</div>
						</div>
					</div>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); 

		if(isset($_GET["Mes"]))
		{
			if($_GET["TipoReporte"] == 1 && $_GET["TipoEstablecimiento"] == 1)
			{
				header('Location: LVImpC.php?Mes='.$_GET["Mes"].'&anho='.$_GET["anho"]);
			}
			elseif($_GET["TipoReporte"] == 2 && $_GET["TipoEstablecimiento"] == 1)
			{
				header('Location: LVSistemaImpC.php?Mes='.$_GET["Mes"].'&anho='.$_GET["anho"]);
			}
			if($_GET["TipoReporte"] == 1 && $_GET["TipoEstablecimiento"] == 2)
			{
				header('Location: LVImpC2.php?Mes='.$_GET["Mes"].'&anho='.$_GET["anho"]);
			}
			elseif($_GET["TipoReporte"] == 2 && $_GET["TipoEstablecimiento"] == 2)
			{
				header('Location: LVSistemaImpC2.php?Mes='.$_GET["Mes"].'&anho='.$_GET["anho"]);
			}
			if($_GET["TipoReporte"] == 1 && $_GET["TipoEstablecimiento"] == 3)
			{
				header('Location: LVImpC3.php?Mes='.$_GET["Mes"].'&anho='.$_GET["anho"]);
			}
			elseif($_GET["TipoReporte"] == 2 && $_GET["TipoEstablecimiento"] == 3)
			{
				header('Location: LVSistemaImpC3.php?Mes='.$_GET["Mes"].'&anho='.$_GET["anho"]);
			}
		}
		?>

		<!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Resultados de su búsqueda</h2>
                    </div>
                    <div class="modal-body">
                    	<div id="suggestions" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
<?php
	ob_flush();
?>