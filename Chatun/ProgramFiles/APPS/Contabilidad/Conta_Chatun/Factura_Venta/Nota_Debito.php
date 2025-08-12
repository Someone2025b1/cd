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
								<h4 class="text-center"><strong>Búsqueda de Factura Electrónica</strong></h4>
							</div>
							<div class="card-body">
								<form action="#" method="GET">
									<div class="col-lg-offset-4 col-lg-4">
										<div class="form-group">
											<label for="Fecha">Fecha</label>
											<input type="date" id="Fecha" name="Fecha" class="form-control" value="<?php echo date('Y-m-d') ?>">
										</div>
									</div>
									<div class="col-lg-12 text-center">
										<button type="submit" class="btn btn-success">Consultar</button>
									</div>
								</form>
								<div class="row">
									<br>
									<br>
								</div>
								<div class="row">
									<?php
										if(isset($_GET[Fecha]))
										{
											$Query = mysqli_query($db, "SELECT * FROM Contabilidad.TRANSACCION AS A WHERE A.TRA_FECHA_TRANS = '".$_GET['Fecha']."' AND TT_CODIGO = 17 AND A.TRA_CODIGO NOT IN (SELECT ND.TRA_FACTURA_NOTA_CREDITO_AFECTADA
																			FROM Contabilidad.TRANSACCION AS ND
																			WHERE ND.TT_CODIGO = 18)");
											?>
												<table class="table table-hover table-condensed">
													<thead>
														<tr>
															<th>CONCEPTO</th>
															<th>DTE NOTA CRÉDITO</th>
															<th>CAE NOTA CRÉDITO</th>
															<th>TOTAL</th>
															<th>REALIZAR</th>
														</tr>
													</thead>
													<tbody>
													<?php
														while($Fila = mysqli_fetch_array($Query))
														{
															?>
																<tr>
																	<td><?php echo $Fila[TRA_CONCEPTO] ?></td>
																	<td><?php echo $Fila[TRA_DTE] ?></td>
																	<td><?php echo $Fila[TRA_CAE] ?></td>
																	<td><?php echo number_format($Fila[TRA_TOTAL], 2) ?></td>
																	<td><a href="Nota_Debito_Pro.php?&Codigo=<?php echo $Fila[TRA_CODIGO] ?>&Factura=<?php echo $Fila[TRA_FACTURA_NOTA_CREDITO] ?>&Tabla=<?php echo $Fila[TRA_TABLA_FACTURA_NOTA_CREDITO] ?>"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span></button></a></td>
																</tr>
															<?php
														}
													?>
													</tbody>
												</table>
											<?php
										}
									?>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<!-- END CONTENT -->

	
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
