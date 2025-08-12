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
				<form class="form" action="IngresoPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Facturas Pendientes de Operar</strong></h4>
							</div>
							<div class="card-body">
								<?php

									$query = "SELECT TRANSACCION.*, PROVEEDOR.P_NOMBRE, TRANSACCION_DETALLE.TRAD_CARGO_CONTA FROM 
												Contabilidad.TRANSACCION, Contabilidad.PROVEEDOR, Contabilidad.TRANSACCION_DETALLE
												WHERE TRANSACCION.P_CODIGO = PROVEEDOR.P_CODIGO
												AND TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO
												AND TRANSACCION.TRA_A_INVENTARIO = 1 
												AND TRANSACCION.E_CODIGO = 2
												AND TRANSACCION.TRA_ESTADO_INVENTARIO = 1
												AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '1.01.06.001' AND '1.01.06.999'
												AND (PROVEEDOR.P_CODIGO <> '2.01.01.001.719' AND PROVEEDOR.P_CODIGO <> '2.01.01.001.653' AND PROVEEDOR.P_CODIGO <> '2.01.01.001.720') ORDER BY TRANSACCION.TRA_FECHA_TRANS DESC";
									$result = mysqli_query($db, $query);
									$Registros = mysqli_num_rows($result);

									if($Registros > 0)
									{
										?>
										<table class="table table-hover table-condensed">
											<thead>
												<tr>
													<th><h6><strong>Fecha</strong></h6></th>
													<th><h6><strong>Factura</strong></h6></th>
													<th><h6><strong>Proveedor</strong></h6></th>
													<th><h6><strong>Total</strong></h6></th>
												</tr>
											</thead>	
											<tbody>

											<?php
											while($row = mysqli_fetch_array($result))
											{	
												$Codigo = $row["TRA_CODIGO"];
												echo '<tr>';
													echo '<td><h6>'.date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"])).'</h6></td>';
													echo '<td><h6>'.$row["TRA_SERIE"].'-'.$row["TRA_FACTURA"].'</h6></td>';
													echo '<td><h6>'.$row["P_NOMBRE"].'</h6></td>';
													echo '<td><h6>'.number_format($row["TRAD_CARGO_CONTA"], 2, '.', ',').'</h6></td>';
													echo '<td><a href="Ingreso.php?Codigo='.$Codigo.'&Factura='.$row["TRA_SERIE"].'-'.$row["TRA_FACTURA"].'&Proveedor='.$row["P_NOMBRE"].'&Total='.$row["TRAD_CARGO_CONTA"].'"><button type="button" class="btn btn-warning btn-xs">
															<span class="glyphicon glyphicon-pencil"></span> Operar
														</button></a></td>';
												echo '</tr>';
											}
											?>
											</tbody>
										</table>
										<?php
									}
									else
									{
										?>
											<div class="alert alert-callout alert-success" role="alert">
												Actualmente <strong>no hay</strong> facturas pendientes por operar.
											</div>
										<?php
									}
								?>
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
	</body>
	</html>
