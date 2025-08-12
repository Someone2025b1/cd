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
	<script src="../../../../../js/libs/tableexport/jquery.base64.js"></script>
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>
	<script src="../../../../../js/libs/tableexport/tableExport.js"></script>
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
				<h1 class="text-center"><strong>FACTURAS CAE</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Facturas</strong></h4>
						</div>
						<div class="card-body">
							<div class="col-lg-12">
								<?php
									$Query = mysqli_query($db, "SELECT A.F_FECHA_TRANS AS FECHA, A.F_HORA AS HORA, 'RESTAURANTE' AS AREA, A.F_TOTAL AS TOTAL
															FROM Bodega.FACTURA AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION 
															SELECT A.F_FECHA_TRANS AS FECHA, A.F_HORA AS HORA, 'LAS TERRAZAS #2' AS AREA, A.F_TOTAL AS TOTAL
															FROM Bodega.FACTURA_2 AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION 
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'HELADOS', A.F_TOTAL
															FROM Bodega.FACTURA_HS AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'CAFE LOS ABUELOS', A.F_TOTAL
															FROM Bodega.FACTURA_KS AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'PIZZERÍA', A.F_TOTAL
															FROM Bodega.FACTURA_PIZZA AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'KIOSKO', A.F_TOTAL
															FROM Bodega.FACTURA_KS_2 AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'KIOSKO OASIS', A.F_TOTAL
															FROM Bodega.FACTURA_KS_3 AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'KIOSKO PASILLO', A.F_TOTAL
															FROM Bodega.FACTURA_KS_4 AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'JUEGOS', A.F_TOTAL
															FROM Bodega.FACTURA_JG AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'SOUVENIRS', A.F_TOTAL
															FROM Bodega.FACTURA_SV AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'SOUVENIRS #2', A.F_TOTAL
															FROM Bodega.FACTURA_SV_2 AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'TAQUILLA', A.F_TOTAL
															FROM Bodega.FACTURA_TQ AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'TAQUILLA #2', A.F_TOTAL
															FROM Bodega.FACTURA_TQ_2 AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'TAQUILLA #3', A.F_TOTAL
															FROM Bodega.FACTURA_TQ_3 AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'TAQUILLA #4', A.F_TOTAL
															FROM Bodega.FACTURA_TQ_4 AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'RESTAURANTE MIRADOR', A.F_TOTAL
															FROM Bodega.FACTURA_RS AS A
															WHERE A.F_FECHA_TRANS > '2018-10-11'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'EVENTOS', A.F_TOTAL
															FROM Bodega.FACTURA_EV AS A
															WHERE A.F_FECHA_TRANS > '2021-05-01'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'HOTEL', A.F_TOTAL
															FROM Bodega.FACTURA_HC AS A
															WHERE A.F_FECHA_TRANS > '2021-05-01'
															AND (A.F_CAE = '' or A.F_CAE is null)
															UNION
															SELECT A.F_FECHA_TRANS, A.F_HORA, 'TILAPIA', A.F_TOTAL
															FROM Bodega.FACTURA_PS AS A
															WHERE A.F_FECHA_TRANS > '2021-05-01'
															AND (A.F_CAE = '' or A.F_CAE is null)");


								?>
								<table class="table table-hover table-condensed" id="TblTicketsHotel">
									<thead>
										<tr>
											<th><h6>#</h6></th>
											<th><h6>FECHA</h6></th>
											<th><h6>HORA</h6></th>
											<th><h6>ÁREA</h6></th>
											<th class="text-right"><h6>MONTO</h6></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$Contador = 1;
											while($Fila = mysqli_fetch_array($Query))
											{
												?>
													<tr>
														<td><h6><?php echo $Contador ?></h6></td>
														<td><h6><?php echo date('d-m-Y', strtotime($Fila["FECHA"])) ?></h6></td>
														<td><h6><?php echo $Fila["HORA"] ?></h6></td>
														<td><h6><?php echo $Fila["AREA"] ?></h6></td>
														<td class="text-right"><h6><?php echo number_format($Fila["TOTAL"], 2) ?></h6></td>
													</tr>
												<?php
												$Contador++;
												$TotalFacturas = $TotalFacturas + $Fila["TOTAL"];
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="4" class="text-right"><h6><b>TOTAL</b></h6></th>
											<th class="text-right"><h6><b><?php echo number_format($TotalFacturas, 2) ?></b></h6></th>
										</tr>
									</tfoot>
								</table>
								<div class="col-lg-12">
									<br>
									<br>
								</div>
								<div class="col-lg-12 text-center">
									<button type="button" class="btn btn-danger" onclick="EliminarFacturas()">Eliminar</button>
								</div>
								<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
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
		<script src="../../../../../libs/alertify/js/alertify.js"></script>
		<script src="../../../../../js/libs/tableexport/jquery.base64.js"></script>
		<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>
		<script src="../../../../../js/libs/tableexport/tableExport.js"></script>
	<!-- END JAVASCRIPT -->
		<!-- END JAVASCRIPT -->

		<div class="modal fade" id="ModalPreloader" style="width: 80%" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 text-center">
								<img src="../../../../../img/Preloader.gif" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
			function EliminarFacturas()
			{
				$.ajax({
						url: 'EliminarFacturasSinCAE.php',
						type: 'post',
						beforeSend: function()
						{
							$('#ModalPreloader').modal('show');
						},
						success: function (data) {
							if(data == '')
							{
								$('#ModalPreloader').modal('hide');
								window.location.reload();
							}
							else
							{
								$('#ModalPreloader').modal('hide');
								alertify.error('No se pudo eliminar las facturas sin CAE');
							}
						}
					});
			}
		
		 $('#BtnExportarTicketHotel').click(function(event) {
			$('#TblTicketsHotel').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click

	 
	</script>

	</body>
	</html>
