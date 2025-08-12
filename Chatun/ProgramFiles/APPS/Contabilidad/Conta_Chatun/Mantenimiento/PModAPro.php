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
				<h1 class="text-center"><strong>Modificación de Partidas</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Partidas contablizadas del día <?php echo date('d-m-Y', strtotime($_POST["Fecha"])); ?></strong></h4>
						</div>
						<div class="card-body">
							<table class="table table-hover table-condensed">
								<thead>
									<tr>
										<th><strong>Tipo</strong></th>
										<th><strong>Concepto</strong></th>
										<th><strong>Total</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php

									$Query = "SELECT TRANSACCION.TRA_CODIGO, TRANSACCION.TRA_CONCEPTO, TRANSACCION.TRA_TOTAL, TIPO_TRANSACCION.TT_NOMBRE
									 FROM Contabilidad.TRANSACCION, Contabilidad.TIPO_TRANSACCION 
									 WHERE TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO 
									 AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1
									 AND TRANSACCION.TRA_FECHA_TRANS = '".$_POST["Fecha"]."'
									 AND (TRANSACCION.TT_CODIGO = 28 OR TRANSACCION.TT_CODIGO = 6 OR TRANSACCION.TT_CODIGO = 7 OR TRANSACCION.TT_CODIGO = 8 OR TRANSACCION.TT_CODIGO = 15 OR TRANSACCION.TT_CODIGO = 9 OR TRANSACCION.TT_CODIGO = 20 OR TRANSACCION.TT_CODIGO = 21 OR TRANSACCION.TT_CODIGO = 17 OR TRANSACCION.TT_CODIGO = 18 OR TRANSACCION.TT_CODIGO = 23) order by TRANSACCION.TT_CODIGO asc";
									 $Result = mysqli_query($db, $Query);
									 while($row = mysqli_fetch_array($Result))
									 {
									 	?>
										
											<tr>
												<td><?php echo $row["TT_NOMBRE"]; ?></td>
												<td><?php echo $row["TRA_CONCEPTO"]; ?></td>
												<td><?php echo 'Q. '.number_format($row["TRA_TOTAL"], 2, '.', ','); ?></td>
												<td><a href="PModAProPro.php?Codigo=<?php echo $row['TRA_CODIGO']; ?>"><button type="button" class="btn btn-sm btn-warning">
												    	<span class="glyphicon glyphicon-pencil"></span> Modificar
													</button></a>
												</td>
											</tr>

									 	<?php
									 }
									?>
								</tbody>
							</table>
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
