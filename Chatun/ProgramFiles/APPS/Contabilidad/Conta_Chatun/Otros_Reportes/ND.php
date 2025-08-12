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


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">				
				<div class="col-lg-12">
					<br>
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Notas de Débito Emitidas</strong></h4>
						</div>
						<div class="card-body">
							<form class="form" action="#" method="GET" role="form">
								<div class="row text-center">
									<div class="col-lg-3"></div>
									<div class="col-lg-6">
										<div class="form-group">
											<div class="input-daterange input-group" id="demo-date-range">
												<div class="input-group-content">
													<input type="date" class="form-control" name="FechaInicio" value="<?php echo date('Y-m-d') ?>">
													<label>Rango de Fechas</label>
												</div>
												<span class="input-group-addon">al</span>
												<div class="input-group-content">
													<input type="date" class="form-control" name="FechaFin" value="<?php echo date('Y-m-d') ?>">
													<div class="form-control-line"></div>
												</div>
											</div>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="col-lg-12" align="center">
									<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Consultar</button>
								</div>
							</form>
							<div class="row">
								<br>
								<br>
							</div>
							<?php
								if(isset($_GET["FechaInicio"]))
								{
									?>
										<div class="row">
											<div class="col-lg-12">
												<table class="table table-hover table-condensed">
													<thead>
														<tr>
															<th><h5><b>FECHA</b></h5></th>
															<th><h5><b>DTE</b></h5></th>
															<th><h5><b>AREA</b></h5></th>
															<th><h5><b>NETO</b></h5></th>
															<th><h5><b>IVA</b></h5></th>
															<th><h5><b>TOTAL</b></h5></th>
														</tr>
													</thead>
													<tbody>
													<?php
														$Query = mysqli_query($db, "SELECT *, ROUND((A.TRA_TOTAL / 1.12) * 0.12, 2) AS IVA, A.TRA_TOTAL - ((A.TRA_TOTAL / 1.12) * 0.12) AS NETO
																				FROM Contabilidad.TRANSACCION AS A
																				WHERE A.TT_CODIGO = 18
																				AND A.TRA_FECHA_TRANS BETWEEN '".$_GET[FechaInicio]."' AND '".$_GET[FechaFin]."'");
														while($Fila = mysqli_fetch_array($Query))
														{
															?>
																<tr>
																	<td><h6><?php echo date('d-m-Y', strtotime($Fila[TRA_FECHA_TRANS])) ?></h6></td>
																	<td><h6><?php echo $Fila[TRA_DTE] ?></h6></td>
																	<td><h6><?php echo $Fila[TRA_TABLA_FACTURA_NOTA_CREDITO] ?></h6></td>
																	<td><h6><?php echo number_format($Fila[NETO], 2) ?></h6></td>
																	<td><h6><?php echo number_format($Fila[IVA], 2) ?></h6></td>
																	<td><h6><?php echo number_format($Fila[TRA_TOTAL], 2) ?></h6></td>
																</tr>
															<?php
														}
													?>
													</tbody>
												</table>
											</div>
										</div>
									<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

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
