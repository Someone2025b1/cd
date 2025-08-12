<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$MesC = $_GET["Mes"];
$anho = $_GET["anho"];
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
											<th data-sortable="true" data-field="CLIENTE" data-filter-control="input"><h6><strong>CLIENTE</strong></h6></th>
											<th data-sortable="true" data-field="NIT" data-filter-control="input"><h6><strong>NIT</strong></h6></th>
											<th data-sortable="true" data-field="DOCUMENTO" data-filter-control="input"><h6><strong>DOCUMENTO</strong></h6></th>	
											<th data-sortable="true" data-field="CANT FACTURAS" data-filter-control="input"><h6><strong>CANT FACTURAS</strong></h6></th>				
											<th data-sortable="true" data-field="BIENES" data-filter-control="input"><h6><strong>BIENES</strong></h6></th>
											<th data-sortable="true" data-field="SERVICIOS" data-filter-control="input"><h6><strong>SERVICIOS</strong></h6></th>
											<th data-sortable="true" data-field="EXPORTACIONES" data-filter-control="input"><h6><strong>EXPORTACIONES</strong></h6></th>
											<th data-sortable="true" data-field="IVA" data-filter-control="input"><h6><strong>IVA</strong></h6></th>
											<th data-sortable="true" data-field="IMPUESTOS" data-filter-control="input"><h6><strong>IMPUESTOS</strong></h6></th>
											<th data-sortable="true" data-field="EXENTO" data-filter-control="input"><h6><strong>EXENTO</strong></h6></th>
											<th data-sortable="true" data-field="TOTAL" data-filter-control="input"><h6><strong>TOTAL</strong></h6></th> 
										</tr>
									</thead>
									<tbody>
										<?php
											$QueryDetalle = mysqli_query($db, "
											SELECT *FROM (SELECT A.TRA_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'FAC' AS TIPO,
											(SELECT SUM(B.TRA_TOTAL)/1.12 AS BIENES
											FROM Contabilidad.TRANSACCION AS B
											WHERE B.TRA_FECHA_TRANS = A.TRA_FECHA_TRANS
											AND B.E_CODIGO = 2
											AND B.TT_CODIGO IN (7,15,8,6,20, 24, 28,21)  AND (B.TRA_CONCEPTO <> 'FACTURA ANULADA' AND B.TRA_CONCEPTO <> 'PÓLIZA ANULADA' AND B.TRA_ESTADO = 1)) AS BIENES,
											(SELECT SUM(C.TRA_TOTAL)/1.12 AS SERVICIOS
											FROM Contabilidad.TRANSACCION AS C
											WHERE C.TRA_FECHA_TRANS = A.TRA_FECHA_TRANS
											AND C.E_CODIGO = 2 
											AND C.TT_CODIGO IN (3,4,5,9,22, 25, 26) AND NOT EXISTS (SELECT *FROM Bodega.FACTURA_TQ t INNER JOIN Bodega.FACTURA_TQ_DETALLE q ON t.F_CODIGO = q.F_CODIGO WHERE t.F_CODIGO = C.TRA_CODIGO AND q.FD_UNIDADES > 0) AND (C.TRA_CONCEPTO <> 'FACTURA ANULADA' AND C.TRA_CONCEPTO <> 'PÓLIZA ANULADA' AND C.TRA_ESTADO = 1)) AS SERVICIOS, 
											(SUM(A.TRA_TOTAL) - ROUND(((SUM(A.TRA_TOTAL) / 1.12) * .12), 2)) AS NETO,
											(SELECT SUM(C.TRA_TOTAL) AS SALDO
											FROM Contabilidad.TRANSACCION AS C
											WHERE C.TRA_FECHA_TRANS = A.TRA_FECHA_TRANS
											AND C.E_CODIGO = 2 
											AND C.TT_CODIGO IN (3,4,5,9,21,22,7,15,8,6,20, 24, 25, 26, 28) 
											AND (C.TRA_CONCEPTO <> 'FACTURA ANULADA' AND NOT EXISTS (SELECT *FROM Bodega.FACTURA_TQ t INNER JOIN Bodega.FACTURA_TQ_DETALLE q ON t.F_CODIGO = q.F_CODIGO WHERE t.F_CODIGO = C.TRA_CODIGO AND q.FD_UNIDADES > 0) AND C.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND C.TRA_ESTADO = 1) AS SALDO
											FROM Contabilidad.TRANSACCION AS A
											WHERE A.TT_CODIGO IN (3,4,5,6,7,8,9,15,20,21,22, 26, 28) AND NOT EXISTS (SELECT *FROM Bodega.FACTURA_TQ t INNER JOIN Bodega.FACTURA_TQ_DETALLE q ON t.F_CODIGO = q.F_CODIGO WHERE t.F_CODIGO = A.TRA_CODIGO AND q.FD_UNIDADES > 0)
											AND MONTH(A.TRA_FECHA_TRANS) = $MesC
											AND YEAR(A.TRA_FECHA_TRANS) = $anho
											AND A.E_CODIGO = 2
											AND (A.TRA_CONCEPTO <> 'FACTURA ANULADA' AND A.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND A.TRA_ESTADO = 1
											GROUP BY A.TRA_FECHA_TRANS
											UNION ALL
											SELECT A.TRA_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'NC' AS TIPO,
											0 AS BIENES,
											(SELECT (SUM(C.TRA_TOTAL)*-1)/1.12 AS SERVICIOS
											FROM Contabilidad.TRANSACCION AS C
											WHERE C.TRA_FECHA_TRANS = A.TRA_FECHA_TRANS
											AND C.E_CODIGO = 2 AND C.TT_CODIGO IN (17) AND (C.TRA_CONCEPTO <> 'FACTURA ANULADA' AND C.TRA_CONCEPTO <> 'PÓLIZA ANULADA' AND C.TRA_ESTADO = 1)) AS SERVICIOS,  (SUM(A.TRA_TOTAL)*-1 - ROUND(((SUM(A.TRA_TOTAL) / 1.12) * .12), 2)) AS NETO,
											SUM(A.TRA_TOTAL)*-1 AS SALDO
											FROM Contabilidad.TRANSACCION AS A
											WHERE A.TT_CODIGO IN (17)
											AND MONTH(A.TRA_FECHA_TRANS) = $MesC
											AND YEAR(A.TRA_FECHA_TRANS) = $anho
											AND A.E_CODIGO = 2
											AND (A.TRA_CONCEPTO <> 'FACTURA ANULADA' AND A.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND A.TRA_ESTADO = 1
											GROUP BY A.TRA_FECHA_TRANS
											UNION ALL
											 SELECT A.TRA_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'ND' AS TIPO,
											0 AS BIENES,
											(SELECT SUM(C.TRA_TOTAL)/1.12 AS SERVICIOS
											FROM Contabilidad.TRANSACCION AS C
											WHERE C.TRA_FECHA_TRANS = A.TRA_FECHA_TRANS
											AND C.E_CODIGO = 2 AND C.TT_CODIGO IN (18) AND (C.TRA_CONCEPTO <> 'FACTURA ANULADA' AND C.TRA_CONCEPTO <> 'PÓLIZA ANULADA' AND C.TRA_ESTADO = 1)) AS SERVICIOS,
											 (SUM(A.TRA_TOTAL) - ROUND(((SUM(A.TRA_TOTAL) / 1.12) * .12)*-1, 2)) AS NETO,
											SUM(A.TRA_TOTAL) AS SALDO
											FROM Contabilidad.TRANSACCION AS A
											WHERE A.TT_CODIGO IN (18)
											AND MONTH(A.TRA_FECHA_TRANS) = $MesC
											AND YEAR(A.TRA_FECHA_TRANS) = $anho
											AND A.E_CODIGO = 2
											AND (A.TRA_CONCEPTO <> 'FACTURA ANULADA' AND A.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND A.TRA_ESTADO = 1
											GROUP BY A.TRA_FECHA_TRANS
											)dum
											ORDER BY TRA_FECHA_TRANS 
 ");
											while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
											{
												$Fecha = date('d-m-Y', strtotime($FilaDetalle["TRA_FECHA_TRANS"]));
											    $Cliente = $FilaDetalle['CLIENTE'];
											    $NIT = $FilaDetalle['NIT'];
											    $Documento = $FilaDetalle['TIPO'];
											  

											  
											    // if($FilaDetalle['TRA_SERIE'] == 'D' || $FilaDetalle['TRA_SERIE'] == 'E' || $FilaDetalle['TRA_SERIE'] == 'F' || $FilaDetalle['TRA_SERIE'] == 'I' || $FilaDetalle['TRA_SERIE'] == 'L')
											    // {
											    //     $Bienes = $FilaDetalle['NETO'];
											    //     $Servicios = 0;

											    //     $BienesMostrar = number_format($FilaDetalle['NETO'], 2);
											    //     $ServiciosMostrar = number_format(0, 2);
											    // }
											    // else
											    // {
											    //     $Bienes = 0;
											    //     $Servicios = $FilaDetalle['NETO'];

											    //     $BienesMostrar = number_format(0, 2);
											    //     $ServiciosMostrar = number_format($FilaDetalle['NETO'], 2);
											    // }

											    $Bienes = $FilaDetalle['BIENES'];
											    $Servicios = $FilaDetalle['SERVICIOS'];

											    $ExportacionesMostrar = number_format(0, 2);

											    $Iva = ($FilaDetalle['SALDO']/1.12)*0.12;
											    $Total = $FilaDetalle['SALDO'];

											    $IVAMostrar = number_format(($FilaDetalle['SALDO']/1.12)*0.12, 2);
											    $TotalMostrar = number_format($FilaDetalle['SALDO'], 2);
											    $Cliente = $FilaDetalle['CLIENTE'];

											    $BienesTotal = $BienesTotal + $Bienes;
											    $ServiciosTotal = $ServiciosTotal + $Servicios;
											    $IvaTotal = $IvaTotal + $Iva;
											    $TotalTotal = $TotalTotal + $Total;

											    ?>
													<tr>
													    <td align="center"><?php echo $Fecha ?></td>
													    <td align="center"><?php echo $Cliente ?></td>
													    <td align="center"><?php echo $NIT ?></td>
													    <td align="center"><?php echo $Documento ?></td> 
													    <td align="left">
													    	<?php
													    	if ($Documento== 'FAC') 
													    	{
													    	 	$Cant = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(*) AS Contador
																	FROM Contabilidad.TRANSACCION AS B
																	WHERE B.TRA_FECHA_TRANS = '$FilaDetalle[TRA_FECHA_TRANS]'
																	AND B.E_CODIGO = 2 AND B.TT_CODIGO IN (3,4,5,9,21,22,7,15,8,6,20, 24, 26, 25, 28) AND NOT EXISTS (SELECT *FROM Bodega.FACTURA_TQ t INNER JOIN Bodega.FACTURA_TQ_DETALLE q ON t.F_CODIGO = q.F_CODIGO WHERE t.F_CODIGO = B.TRA_CODIGO AND q.FD_UNIDADES > 0)"));
													    	} 
													    	else if ($Documento== 'NC')
													    	{
													    		$Cant = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(*) AS Contador
																	FROM Contabilidad.TRANSACCION AS B
																	WHERE B.TRA_FECHA_TRANS = '$FilaDetalle[TRA_FECHA_TRANS]'
																	AND B.E_CODIGO = 2 AND B.TT_CODIGO IN (17)  "));
													    	}
													    	else if ($Documento== 'ND')
													    	{
													    		$Cant = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(*) AS Contador
																	FROM Contabilidad.TRANSACCION AS B
																	WHERE B.TRA_FECHA_TRANS = '$FilaDetalle[TRA_FECHA_TRANS]'
																	AND B.E_CODIGO = 2 AND B.TT_CODIGO IN (18) AND (B.TRA_CONCEPTO <> 'FACTURA ANULADA' AND B.TRA_CONCEPTO <> 'PÓLIZA ANULADA' AND B.TRA_ESTADO = 1)"));
													    	}
													    	echo $Cant["Contador"] ?>
													    		
													    	</td>
													    <td align="right"><?php echo number_format($Bienes,2) ?></td>
													    <td align="right"><?php echo number_format($Servicios,2) ?></td>
													    <td align="right"><?php echo $ExportacionesMostrar ?></td>
													    <td align="right"><?php echo $IVAMostrar ?></td>
													    <td align="right">0.00</td>
													    <td align="right">0.00</td>
													    <td align="right"><?php echo $TotalMostrar ?></td> 
													   </tr>
											    <?php
											    $SumaFac += $Cant["Contador"];

											}

											$BienesMostrarTotal = number_format($BienesTotal, 2);
											$ServiciosMostrarTotal = number_format($ServiciosTotal, 2);
											$ExportacionesMostrar = number_format(0, 2);
											$IVAMostrarTotal = number_format($IvaTotal, 2);
											$TotalMostrarTotal = number_format($TotalTotal, 2);

										?>
									</tbody>
									<tfoot>
										<tr>
										    <td align="center"></td>
										    <td align="center"></td>
										    <td align="center"></td>
										    <td align="center"></td> 
										    <td align="left"><b><?php echo number_format($SumaFac) ?></b></td>
										    <td align="center"><b><?php echo $BienesMostrarTotal ?></b></td>
										    <td align="center"><b><?php echo $ServiciosMostrarTotal ?></b></td>
										    <td align="center"><b><?php echo $ExportacionesMostrar ?></b></td>
										    <td align="center"><b><?php echo $IVAMostrarTotal ?></b></td>
										    <td align="right"><b>0.00</b></td>
										    <td align="right"><b>0.00</b></td>
										    <td align="right"><b><?php echo $TotalMostrarTotal ?></b></td> 
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
