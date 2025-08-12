<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$FechaIni = $_POST["FechaInicio"]; 
$FechaFin = $_POST["FechaFin"]; 
$tipodereporte = $_POST["TipoReporte"];
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
								<?php
								#RESUMIDO
								if ($tipodereporte == 2){
									?>
									
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
											<th data-sortable="true" data-field="NUM" data-filter-control="input"><h6><strong>NUM.</strong></h6></th>
											<th data-sortable="true" data-field="FECHA" data-filter-control="input"><h6><strong>FECHA</strong></h6></th>
											<th data-sortable="true" data-field="SERIE" data-filter-control="input"><h6 align="center"><strong>SERIE</strong></h6></th>
											<th data-sortable="true" data-field="NUMERO" data-filter-control="input"><h6 align="center"><strong>NUMERO</strong></h6></th>
											<th data-sortable="true" data-field="INFORMACION" data-filter-control="input"><h6><strong>INFORMACIÓN</strong></h6></th>
											<th data-sortable="true" data-field="TOTAL" data-filter-control="input"><h6><strong>TOTAL SIN DESCUENTO</strong></h6></th>
											<th data-sortable="true" data-field="DESCUENTO" data-filter-control="input"><h6><strong>DESCUENTO</strong></h6></th> 
											<th data-sortable="true" data-field="TOTALFINAL" data-filter-control="input"><h6><strong>TOTAL FINAL</strong></h6></th> 
										</tr>
									</thead>
									<tbody>
										<?php
											$cont=0;
											$descuentototal=0;
										
											$QueryDescuentos = mysqli_query($db,"SELECT A.F_FECHA_TRANS, A.F_SERIE, A.F_CAE, A.CLI_NIT, A.F_CON_DESCUENTO, A.F_TOTAL, B.CLI_NOMBRE, C.F_CODIGO,
											C.FD_PRECIO_UNITARIO, C.FD_DESCUENTO, C.FD_CANTIDAD, C.FD_SUBTOTAL
											FROM Bodega.FACTURA AS A 
											JOIN Bodega.CLIENTE AS B ON  B.CLI_NIT = A.CLI_NIT
											JOIN Bodega.FACTURA_DETALLE AS C ON  C.F_CODIGO = A.F_CODIGO
											JOIN Contabilidad.TRANSACCION AS D ON  D.TRA_CODIGO = A.F_CODIGO 
											AND D.TRA_CONCEPTO <> 'FACTURA ANULADA' 
											AND D.TRA_CONCEPTO <> 'PÓLIZA ANULADA'
											AND D.TRA_ESTADO = 1
											WHERE A.F_FECHA_TRANS BETWEEN '$FechaIni' AND '$FechaFin' AND D.TRA_ESTADO = 1 AND C.FD_DESCUENTO <> 0
											ORDER BY A.F_FECHA_TRANS ASC");

											while($FilaDetalle = mysqli_fetch_array($QueryDescuentos))
											{
												$Fecha = date('d-m-Y', strtotime($FilaDetalle["F_FECHA_TRANS"]));
												$TotalSin = $FilaDetalle["F_CON_DESCUENTO"] + $FilaDetalle["F_TOTAL"];
												$Info =$FilaDetalle["CLI_NIT"]. ", ".$FilaDetalle['CLI_NOMBRE'];
												$CodigoF = $FilaDetalle["F_CODIGO"];
												

												
												if($codf != $FilaDetalle["F_CODIGO"]){
													$cont+=1;

													$QueryDetalleDescuentos = mysqli_query($db,"SELECT H.F_CODIGO, H.FD_PRECIO_UNITARIO,
													H.FD_DESCUENTO, H.FD_CANTIDAD, H.FD_SUBTOTAL
													FROM Bodega.FACTURA_DETALLE AS H
													WHERE H.F_CODIGO = '$CodigoF'
													ORDER BY H.F_CODIGO ASC");
													
													while($FilaDetalledes = mysqli_fetch_array($QueryDetalleDescuentos))
													{
														
													$preciocon = $FilaDetalledes["FD_SUBTOTAL"] / $FilaDetalledes["FD_CANTIDAD"];
													$subtotalsin = $FilaDetalledes["FD_DESCUENTO"] + $FilaDetalledes["FD_SUBTOTAL"];
													$descuentototal += $FilaDetalledes["FD_DESCUENTO"];
															
													#totales por cada venta
													$totalconpv += $FilaDetalledes["FD_SUBTOTAL"];
													$totalsinpv += $subtotalsin;

													
													}
												#Totales generales
												$SumTotalSin += $totalsinpv;
												$SumaTotalCon += $totalconpv;

												$encabezado=0;

												
												$descuento = $totalsinpv - $totalconpv;
												
												?>
												<tr>
													<td align="center"><?php echo $cont ?></td>	
													<td align="center"><?php echo $Fecha ?></td>
													<td align="center"><b><?php echo $FilaDetalle["F_SERIE"] ?></b></td>
													<td align="center"><b><?php echo $FilaDetalle["F_CAE"] ?></b></td> 
													<td align="center"><?php echo $Info ?></td> 
													<td align="center"><b><?php echo $totalsinpv ?></b></td>
													<td align="center"><b><?php echo $descuento ?></b></td>
													<td align="center"><b><?php echo $totalconpv ?></b></td> 
													</tr>
												<?php
												$totalsinpv=0;
												$totalconpv=0;
												
												#GARANTIZA QUE SE TOME EN CUENTA SOLO UNA VEZ LA VENTA
												$codf=$FilaDetalle["F_CODIGO"];
												

											}

											}
											$Fechai = date('d-m-Y', strtotime($FechaIni));
										$Fechaf = date('d-m-Y', strtotime($FechaFin));
										?>
									</tbody>
									<tfoot>
									<tr>
										    <td align="center" colspan="8"><h6  align="center" style="font-weight: bold; color: blck; font-size: 20px;">TOTALES FINALES, DESCUENTOS DEL <?php echo $Fechai ?> AL <?php echo $Fechaf ?></h6></td>
			
										    </tr>

											<tr>
										    <td align="center" colspan="2"><b>TOTAL VENTAS SIN DESCUENTO</b></td>
											<td align="center" colspan="3"><b>TOTAL VENTAS CON DESCUENTO</b></td>
										    <td align="center" colspan="3"><b>TOTAL DESCUENTO REALIZADO EN LAS VENTAS</b></td> 
										    </tr>

										<tr>
										    <td align="center" colspan="2"><b><?php echo number_format($SumTotalSin,2) ?></b></td>
										    <td align="center" colspan="3"><b><?php echo number_format($SumaTotalCon,2) ?></b></td> 
										    <td align="center" colspan="3"><b><?php echo number_format($descuentototal,2) ?></b></td> 
										    </tr>
									</tfoot>

								</table>
								<?php
										}
										#
										#
										#
										#
										#
										#
										##

										#DETALLADO
										#
										#
										#
										#
										#
										#
										#
										$codf="";
										$encabezado=0;
										$totalsinpv=0;
										$totalconpv=0;
										$descuentototal=0;
										$cont=0;
										
										if ($tipodereporte == 1){
											?>
											
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
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th> 
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													
												</tr>
												<tr>
												<th data-sortable="true" data-field="NUM" data-filter-control="input"><h6 align="center"><strong>No.</strong></h6></th>
													<th data-sortable="true" data-field="FECHA" data-filter-control="input"><h6 align="center"><strong>FECHA</strong></h6></th>
													<th data-sortable="true" data-field="SERIE" data-filter-control="input"><h6 align="center"><strong>SERIE</strong></h6></th>
													<th data-sortable="true" data-field="NUMERO" data-filter-control="input"><h6 align="center"><strong>NUMERO</strong></h6></th>
													<th data-sortable="true" data-field="INFORMACION" data-filter-control="input"><h6 align="center"><strong>INFORMACIÓN</strong></h6></th>
													<th data-sortable="true" data-field="DETALLE" data-filter-control="input" colspan="6"><h6 align="center" ><strong>DETALLE</strong></h6></th> 
												</tr>
											</thead>
											<tbody>
												<?php
											$QueryDescuentos = mysqli_query($db,"SELECT A.F_FECHA_TRANS, A.F_SERIE, A.F_CAE, A.CLI_NIT, A.F_CON_DESCUENTO, A.F_TOTAL, B.CLI_NOMBRE, C.F_CODIGO,
											C.FD_PRECIO_UNITARIO, C.FD_DESCUENTO, C.FD_CANTIDAD, C.FD_SUBTOTAL
											FROM Bodega.FACTURA AS A 
											JOIN Bodega.CLIENTE AS B ON  B.CLI_NIT = A.CLI_NIT
											JOIN Bodega.FACTURA_DETALLE AS C ON  C.F_CODIGO = A.F_CODIGO
											JOIN Contabilidad.TRANSACCION AS D ON  D.TRA_CODIGO = A.F_CODIGO 
											AND D.TRA_CONCEPTO <> 'FACTURA ANULADA' 
											AND D.TRA_CONCEPTO <> 'PÓLIZA ANULADA'
											AND D.TRA_ESTADO = 1
											WHERE A.F_FECHA_TRANS BETWEEN '$FechaIni' AND '$FechaFin' AND D.TRA_ESTADO = 1 AND C.FD_DESCUENTO <> 0
											ORDER BY A.F_FECHA_TRANS ASC");

											while($FilaDetalle = mysqli_fetch_array($QueryDescuentos))
											{
												$Fecha = date('d-m-Y', strtotime($FilaDetalle["F_FECHA_TRANS"]));
												$TotalSin = $FilaDetalle["F_CON_DESCUENTO"] + $FilaDetalle["F_TOTAL"];
												$Info =$FilaDetalle["CLI_NIT"]. ", ".$FilaDetalle['CLI_NOMBRE'];
												$CodigoF = $FilaDetalle["F_CODIGO"];
												

												
												if($codf != $FilaDetalle["F_CODIGO"]){
													$cont+=1;

													$QueryDetalleDescuentos = mysqli_query($db,"SELECT H.F_CODIGO, H.FD_PRECIO_UNITARIO,
													H.FD_DESCUENTO, H.FD_CANTIDAD, H.FD_SUBTOTAL, I.P_NOMBRE
													FROM Bodega.FACTURA_DETALLE AS H
													JOIN Productos.PRODUCTO AS I ON H.RS_CODIGO = I.P_CODIGO 
													WHERE H.F_CODIGO = '$CodigoF'
													ORDER BY H.F_CODIGO ASC");
													
													while($FilaDetalledes = mysqli_fetch_array($QueryDetalleDescuentos))
													{
														if($encabezado==0){
															?>

															<tr>
																<td align="center"><b><?php echo $cont ?></b></td>
																<td align="center"><b><?php echo $Fecha ?></b></td>
																<td align="center"><b><?php echo $FilaDetalle["F_SERIE"] ?></b></td>
																<td align="center"><b><?php echo $FilaDetalle["F_CAE"] ?></b></td> 
																<td align="center"><b><?php echo $Info ?></b></td>
																<td align="center"><b>PRODUCTO </b></td> 
																<td align="center"><b>CANTIDAD</b></td>
																<td align="center"><b>PRECIO SIN DESCUENTO</b></td> 
																<td align="center"><b>PRECIO CON DESCUENTO</b></td>
																<td align="center"><b>SUBTOTAL SIN DESCUENTO</b></td>
																<td align="center"><b>SUBTOTAL CON DESCUENTO</b></td> 
																</tr>

															<?php
															$encabezado=1;
															}
															
																
																
															$preciocon = $FilaDetalledes["FD_SUBTOTAL"] / $FilaDetalledes["FD_CANTIDAD"];
															$subtotalsin = $FilaDetalledes["FD_DESCUENTO"] + $FilaDetalledes["FD_SUBTOTAL"];
															?>
															<tr>
																<td align="center"></td> 
																<td align="center"></td> 
																<td align="center"></td>
																<td align="center"></td>
																<td align="center"></td>
																<td align="center"><?php echo $FilaDetalledes["P_NOMBRE"] ?></td>
																<td align="center"><?php echo $FilaDetalledes["FD_CANTIDAD"] ?></td>
																<td align="center">Q.<?php echo $FilaDetalledes["FD_PRECIO_UNITARIO"] ?></td> 
																<td align="center">Q.<?php echo $preciocon ?></td>
																<td align="center">Q.<?php echo $subtotalsin ?></td>
																<td align="center">Q.<?php echo $FilaDetalledes["FD_SUBTOTAL"] ?></td> 
																</tr>

															
 
											    <?php
												#totales por cada venta
												$totalconpv += $FilaDetalledes["FD_SUBTOTAL"];
												$totalsinpv += $subtotalsin;

												if($FilaDetalledes["FD_DESCUENTO"]!= 0){
													$descuentototal += $FilaDetalledes["FD_DESCUENTO"];
												}

												}
												#Totales generales
												$SumTotalSin += $totalsinpv;
											    $SumaTotalCon += $totalconpv;

												#GARANTIZA QUE SE TOME EN CUENTA SOLO UNA VEZ LA VENTA
												$encabezado=0;

												

												?>
												<tr>
													<td align="right" colspan="9"><b><h6  align="right" style="color: red; font-size: 16px;">Totales</h6></b></td> 
													<td align="center"><b><h6  align="center" style="color: red; font-size: 16px;"><?php echo $totalsinpv ?></h6></b></td>
													<td align="center"><b><h6  align="center" style="color: red; font-size: 16px;"><?php echo $totalconpv ?></h6></b></td> 
													</tr>
												<?php
												$totalsinpv=0;
												$totalconpv=0;

												$codf=$FilaDetalle["F_CODIGO"];

											}

											}
											$Fechai = date('d-m-Y', strtotime($FechaIni));
										$Fechaf = date('d-m-Y', strtotime($FechaFin));
										?>
									</tbody>
									<tfoot>
									<tr>
										    <td align="center" colspan="11"><h6  align="center" style="font-weight: bold; color: blck; font-size: 20px;">TOTALES FINALES, DESCUENTOS DEL <?php echo $Fechai ?> AL <?php echo $Fechaf ?></h6></td>
			
										    </tr>

											<tr>
										    <td align="center" colspan="3"><b>TOTAL VENTAS SIN DESCUENTO</b></td>
											<td align="center" colspan="4"><b>TOTAL VENTAS CON DESCUENTO</b></td>
										    <td align="center" colspan="4"><b>TOTAL DESCUENTO REALIZADO EN LAS VENTAS</b></td> 
										    </tr>

										<tr>
										    <td align="center" colspan="3"><b><?php echo number_format($SumTotalSin,2) ?></b></td>
										    <td align="center" colspan="4"><b><?php echo number_format($SumaTotalCon,2) ?></b></td> 
										    <td align="center" colspan="4"><b><?php echo number_format($descuentototal,2) ?></b></td> 
										    </tr>
									</tfoot>

								</table>
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