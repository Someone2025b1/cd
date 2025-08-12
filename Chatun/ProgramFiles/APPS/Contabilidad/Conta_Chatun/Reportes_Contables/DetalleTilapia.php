<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$FechaIni = $_POST["FechaInicio"]; 
$FechaFin = $_POST["FechaFin"]; 
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
	<script src="../../../../../libs/bootstrap-table/js/bootstrap-table.min.js"></script>
	<script src="../../../../../libs/bootstrap-table/1.11.1/extensions/export/bootstrap-table-export.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/tableExport.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/es6-promise/es6-promise.auto.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/jsPDF/jspdf.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/pdfmake/pdfmake.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/bootstrap-table/css/bootstrap-table.min.css">
	<link type="text/css" rel="stylesheet" href="../../../../../libs/bootstrap-table/1.11.1/extensions/filter-control/bootstrap-table-filter-control.css">
	<!-- END STYLESHEETS -->


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php 

		include("../../../../MenuTop.php") ;




	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container-fluid">
				<form class="form" role="form" id="FRMReporte" action="#" method="GET">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Libro Ventas</strong></h4>
							</div>
							<div class="card-body">
								<table class="table table-hover table-condensed" id="table"
                                   data-toggle="table"
                                   data-toolbar="#toolbar"
                                   data-toggle-pagination="true"
                                   data-show-export="true"
                                   data-icons-prefix="fa"
                                   data-icons="icons"
                                   data-pagination="false"
                                   data-sortable="true"
                                   data-search="true"
                                   data-filter-control="true">
									<thead>
										<tr>
											<th data-sortable="true" data-field="FECHA" data-filter-control="input"><h6><strong>FECHA</strong></h6></th>
											<th data-sortable="true" data-field="CLIENTE" data-filter-control="input"><h6><strong>LIBRAS</strong></h6></th>
											<th data-sortable="true" data-field="NIT" data-filter-control="input"><h6><strong>UNIDADES</strong></h6></th>
											<th data-sortable="true" data-field="DOCUMENTO" data-filter-control="input"><h6><strong>TOTAL</strong></h6></th> 
										</tr>
									</thead>
									<tbody>
										<?php
											$QueryDetalle = mysqli_query($db, "SELECT F_FECHA_TRANS, SUM(SALDO) AS SALDO, SUM(Unidades) AS Unidades, SUM(Libras) AS Libras FROM (SELECT F_FECHA_TRANS, 
											(SELECT sum(b.FD_UNIDADES) AS Unidades FROM  Bodega.FACTURA_PS_DETALLE b where a.F_CODIGO = b.F_CODIGO) AS Unidades, (SELECT sum(b.FD_CANTIDAD) AS Libras FROM  Bodega.FACTURA_PS_DETALLE b where a.F_CODIGO = b.F_CODIGO) AS Libras,
											(SELECT a.F_TOTAL  AS SALDO
											FROM Contabilidad.TRANSACCION AS C
											WHERE C.TRA_FECHA_TRANS = a.F_FECHA_TRANS
											AND C.E_CODIGO = 2 
											AND C.TRA_CODIGO = a.F_CODIGO
											AND (C.TRA_CONCEPTO <> 'FACTURA ANULADA' AND C.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND C.TRA_ESTADO = 1) AS SALDO 								
											FROM Bodega.FACTURA_PS a
											INNER JOIN Contabilidad.TRANSACCION t ON a.F_CODIGO = t.TRA_CODIGO 
											WHERE a.F_FECHA_TRANS BETWEEN '$FechaIni' AND '$FechaFin' AND t.TRA_ESTADO = 1
											GROUP BY a.F_FECHA_TRANS, a.F_CODIGO
											UNION ALL
											SELECT a.F_FECHA_TRANS, (SELECT sum(b.FD_UNIDADES) AS Unidades FROM  Bodega.FACTURA_TQ_DETALLE b where a.F_CODIGO = b.F_CODIGO) AS Unidades, (SELECT sum(b.FD_CANTIDAD) AS Libras FROM  Bodega.FACTURA_TQ_DETALLE b where a.F_CODIGO = b.F_CODIGO) AS Libras,
											(SELECT SUM(a.F_TOTAL) AS SALDO
											FROM Contabilidad.TRANSACCION AS C
											WHERE C.TRA_FECHA_TRANS = a.F_FECHA_TRANS
											AND C.E_CODIGO = 2 
											AND C.TRA_CODIGO = a.F_CODIGO
											AND (C.TRA_CONCEPTO <> 'FACTURA ANULADA' AND C.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND C.TRA_ESTADO = 1) AS SALDO 								
											FROM Bodega.FACTURA_TQ a
											INNER JOIN Bodega.FACTURA_TQ_DETALLE b ON a.F_CODIGO = b.F_CODIGO 
											INNER JOIN Contabilidad.TRANSACCION t ON a.F_CODIGO = t.TRA_CODIGO 
											WHERE a.F_FECHA_TRANS BETWEEN '$FechaIni' AND '$FechaFin' AND t.TRA_ESTADO = 1 AND b.FD_UNIDADES > 0
											GROUP BY a.F_FECHA_TRANS, a.F_CODIGO
											)dum
											GROUP BY  F_FECHA_TRANS 
											ORDER BY F_FECHA_TRANS 
											 ");
											while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
											{
												$Fecha = date('d-m-Y', strtotime($FilaDetalle["F_FECHA_TRANS"]));
											    
											    ?>
													<tr>
													    <td align="center"><?php echo $Fecha ?></td> 
													    <td align="center"><?php echo $FilaDetalle["Libras"] ?></td> 
													    <td align="center"><?php echo $FilaDetalle["Unidades"]?></td>
													    <td align="center"><?php echo $FilaDetalle["SALDO"] ?></td> 
													   </tr>
											    <?php
											    $SumaLib += $FilaDetalle["Libras"];
											    $SumaCant += $FilaDetalle["Unidades"];
											    $SumaFac += $FilaDetalle["SALDO"];

											}
 
										?>
									</tbody>
									<tfoot>
										<tr>
										    <td align="left"></td>
										    <td align="left"><b><?php echo number_format($SumaLib,2) ?></b></td>
										    <td align="left"><b><?php echo number_format($SumaCant,2) ?></b></td> 
										    <td align="left"><b><?php echo number_format($SumaFac,2) ?></b></td> 
										    </tr>
									</tfoot>

								</table>
							</div>
						</div>
					</div>
				</form>
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

	<script>
		function TipoReporte(x)
		{
			if(x == 1)
			{
				$("#FRMReporte").attr('action', 'LVImp.php');
				$("#FRMReporte").attr('target', '_blank');
			}
			else
			{
				$("#FRMReporte").attr('action', 'LVSistemaImp.php');
				$("#FRMReporte").attr('target', '_self');
			}
		}
	</script>
	<!-- END BASE -->
	</body>
	</html>
