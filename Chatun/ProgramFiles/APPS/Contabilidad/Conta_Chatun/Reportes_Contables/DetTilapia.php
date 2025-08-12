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
											<th data-sortable="true" data-field="TIPO" data-filter-control="input"><h6><strong>TIPO</strong></h6></th> 
											<th data-sortable="true" data-field="CLIENTE" data-filter-control="input"><h6><strong>LIBRAS</strong></h6></th>
											<th data-sortable="true" data-field="NIT" data-filter-control="input"><h6><strong>UNIDADES</strong></h6></th>
											<th data-sortable="true" data-field="DOCUMENTO" data-filter-control="input"><h6><strong>TOTAL</strong></h6></th>
											<th data-sortable="true" data-field="LUGAR" data-filter-control="input"><h6><strong>LUGAR VENTA</strong></h6></th>
											<th data-sortable="true" data-field="ESTANQUE1" data-filter-control="input"><h6><strong>ESTANQUE</strong></h6></th>
											 
										</tr>
									</thead>
									<tbody>
										<?php
										$fechatemp = $FechaIni;
										$prod="";
										$libprod=0;
										$cantprod=0;
										$totalfacpro=0;
										$libprodps=0;
										$cantprodps=0;
										$totalfacprops=0;
										$libprodtq=0;
										$cantprodtq=0;
										$totalfacprotq=0;

										$QueryProd = mysqli_query($db,"SELECT A.P_CODIGO, A.P_NOMBRE
										FROM Bodega.PRODUCTO AS A
										WHERE TP_ID =3
										");

										while($FilaProd = mysqli_fetch_array($QueryProd))
										{
											$libprod=0;
											$cantprod=0;
											$totalfacpro=0;
											$fechatemp = $FechaIni;
											
											
											$QueryDetalle = mysqli_query($db,"SELECT A.F_FECHA_TRANS, B.FD_CANTIDAD, B.FD_UNIDADES, B.FD_SUBTOTAL, B.FD_ESTANQUE, C.P_NOMBRE, C.P_CODIGO
											FROM Bodega.FACTURA_PS AS A 
											JOIN Bodega.FACTURA_PS_DETALLE AS B ON A.F_CODIGO = B.F_CODIGO 
											JOIN Bodega.PRODUCTO AS C ON B.RS_CODIGO = C.P_CODIGO
											JOIN Contabilidad.TRANSACCION AS D ON  D.TRA_CODIGO = A.F_CODIGO 
											AND D.TRA_CONCEPTO <> 'FACTURA ANULADA' 
											AND D.TRA_CONCEPTO <> 'PÓLIZA ANULADA'
											AND D.TRA_ESTADO = 1
											WHERE A.F_FECHA_TRANS BETWEEN '$FechaIni' AND '$FechaFin' AND D.TRA_ESTADO = 1
											ORDER BY A.F_FECHA_TRANS ASC
											");

											while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
											{
												
												
												
												if($FilaDetalle["P_CODIGO"]== $FilaProd["P_CODIGO"]){
													

													if($fechatemp==$FilaDetalle["F_FECHA_TRANS"]){

														$libprod += $FilaDetalle["FD_CANTIDAD"];
														$cantprod += $FilaDetalle["FD_UNIDADES"];
														$totalfacpro += $FilaDetalle["FD_SUBTOTAL"];
														
																
														
													
														$SumaLib += $FilaDetalle["FD_CANTIDAD"];
														$SumaCant += $FilaDetalle["FD_UNIDADES"];
														$SumaFac += $FilaDetalle["FD_SUBTOTAL"];

														$estanque=$FilaDetalle["FD_ESTANQUE"];



													}elseif($totalfacpro!=0.0){
														
														
														$Fecha = date('d-m-Y', strtotime($fechatemp));
														?>
													
														<tr>
															<td align="center"><?php echo $Fecha ?></td> 
															<td align="center"><?php echo $FilaDetalle["P_NOMBRE"] ?></td>
															<td align="center"><?php echo  number_format($libprod,2)?></td> 
															<td align="center"><?php echo number_format($cantprod,2) ?></td>
															<td align="center"><?php echo number_format($totalfacpro,2) ?></td>
															<td align="center">Tilapia</td> 
															<td align="center"><?php echo $estanque ?></td>
														</tr>
													

														<?php
														$SumaLib += $FilaDetalle["FD_CANTIDAD"];
														$SumaCant += $FilaDetalle["FD_UNIDADES"];
														$SumaFac += $FilaDetalle["FD_SUBTOTAL"];

														$libprod=0;
														$cantprod=0;
														$totalfacpro=0;

														$fechatemp=$FilaDetalle["F_FECHA_TRANS"];
														$estanque=$FilaDetalle["FD_ESTANQUE"];
														
														
														$libprod+=$FilaDetalle["FD_CANTIDAD"];
														$cantprod+=$FilaDetalle["FD_UNIDADES"];
														$totalfacpro+=$FilaDetalle["FD_SUBTOTAL"];

													}else{
														$fechatemp=$FilaDetalle["F_FECHA_TRANS"];
														$estanque=$FilaDetalle["FD_ESTANQUE"];
														
														
														$libprod+=$FilaDetalle["FD_CANTIDAD"];
														$cantprod+=$FilaDetalle["FD_UNIDADES"];
														$totalfacpro+=$FilaDetalle["FD_SUBTOTAL"];

														$SumaLib += $FilaDetalle["FD_CANTIDAD"];
														$SumaCant += $FilaDetalle["FD_UNIDADES"];
														$SumaFac += $FilaDetalle["FD_SUBTOTAL"];
													}
													
												
													
												
												}
													$prod=$FilaProd["P_NOMBRE"];

													$libprodps=$SumaLib;
													$cantprodps=$SumaCant;
													$totalfacprops=$SumaFac;

													
													


											}
										
											$Fecha = date('d-m-Y', strtotime($fechatemp));
										
											if($totalfacpro!=0.0){
 
										?>
													<tr>
													    <td align="center"><?php echo $Fecha ?></td> 
													    <td align="center"><?php echo $prod ?></td>
														<td align="center"><?php echo  number_format($libprod,2)?></td> 
													    <td align="center"><?php echo number_format($cantprod,2) ?></td>
													    <td align="center"><?php echo number_format($totalfacpro,2) ?></td> 
														<td align="center">Tilapia</td> 
														<td align="center"><?php echo $estanque ?></td>
													</tr>
													<?php
											
										}
									}

										?>
										
										<?php
										#aqui empieza el wile de la taquilla
										$QueryProd = mysqli_query($db,"SELECT A.P_CODIGO, A.P_NOMBRE
										FROM Bodega.PRODUCTO AS A
										WHERE TP_ID =3
										");

										while($FilaProd = mysqli_fetch_array($QueryProd))
										{
											$libprod=0;
											$cantprod=0;
											$totalfacpro=0;
											$fechatemp = $FechaIni;
											
											
											$QueryDetalle = mysqli_query($db,"SELECT A.F_FECHA_TRANS, B.FD_CANTIDAD, B.FD_UNIDADES, B.FD_ESTANQUE, B.FD_SUBTOTAL, C.P_NOMBRE, C.P_CODIGO
											FROM Bodega.FACTURA_TQ AS A 
											JOIN Bodega.FACTURA_TQ_DETALLE AS B ON A.F_CODIGO = B.F_CODIGO 
											JOIN Bodega.PRODUCTO AS C ON B.RS_CODIGO = C.P_CODIGO
											JOIN Contabilidad.TRANSACCION AS D ON  D.TRA_CODIGO = A.F_CODIGO 
											AND D.TRA_CONCEPTO <> 'FACTURA ANULADA' 
											AND D.TRA_CONCEPTO <> 'PÓLIZA ANULADA'
											AND D.TRA_ESTADO = 1
											WHERE A.F_FECHA_TRANS BETWEEN '$FechaIni' AND '$FechaFin' AND D.TRA_ESTADO = 1 AND B.FD_UNIDADES > 0
											ORDER BY A.F_FECHA_TRANS ASC");

											while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
											{
												
												
												
												if($FilaDetalle["P_CODIGO"]== $FilaProd["P_CODIGO"]){
													

													if($fechatemp==$FilaDetalle["F_FECHA_TRANS"]){

														$libprod += $FilaDetalle["FD_CANTIDAD"];
														$cantprod += $FilaDetalle["FD_UNIDADES"];
														$totalfacpro += $FilaDetalle["FD_SUBTOTAL"];
														
																
														
													
														$SumaLib += $FilaDetalle["FD_CANTIDAD"];
														$SumaCant += $FilaDetalle["FD_UNIDADES"];
														$SumaFac += $FilaDetalle["FD_SUBTOTAL"];

														$estanque=$FilaDetalle["FD_ESTANQUE"];



													}elseif($totalfacpro!=0.0){
														
														
														$Fecha = date('d-m-Y', strtotime($fechatemp));
														?>
													
														<tr>
															<td align="center"><?php echo $Fecha ?></td> 
															<td align="center"><?php echo $FilaDetalle["P_NOMBRE"] ?></td>
															<td align="center"><?php echo  number_format($libprod,2)?></td> 
															<td align="center"><?php echo number_format($cantprod,2) ?></td>
															<td align="center"><?php echo number_format($totalfacpro,2) ?></td>
															<td align="center">Taquilla</td> 
															<td align="center"><?php echo $estanque ?></td>
														</tr>
													

														<?php
														$SumaLib += $FilaDetalle["FD_CANTIDAD"];
														$SumaCant += $FilaDetalle["FD_UNIDADES"];
														$SumaFac += $FilaDetalle["FD_SUBTOTAL"];

														$libprod=0;
														$cantprod=0;
														$totalfacpro=0;

														$fechatemp=$FilaDetalle["F_FECHA_TRANS"];
														$estanque=$FilaDetalle["FD_ESTANQUE"];
														
														
														$libprod+=$FilaDetalle["FD_CANTIDAD"];
														$cantprod+=$FilaDetalle["FD_UNIDADES"];
														$totalfacpro+=$FilaDetalle["FD_SUBTOTAL"];

													}else{
														$fechatemp=$FilaDetalle["F_FECHA_TRANS"];
														$estanque=$FilaDetalle["FD_ESTANQUE"];
														
														
														$libprod+=$FilaDetalle["FD_CANTIDAD"];
														$cantprod+=$FilaDetalle["FD_UNIDADES"];
														$totalfacpro+=$FilaDetalle["FD_SUBTOTAL"];

														$SumaLib += $FilaDetalle["FD_CANTIDAD"];
														$SumaCant += $FilaDetalle["FD_UNIDADES"];
														$SumaFac += $FilaDetalle["FD_SUBTOTAL"];
													}
													
												
													
												
												}
												$prod=$FilaProd["P_NOMBRE"];
													
												$libprodtq = abs($libprodps-$SumaLib);
												$cantprodtq = abs($cantprodps-$SumaCant);
												$totalfacprotq = abs($totalfacprops-$SumaFac);

													
													


											}

											$Fecha = date('d-m-Y', strtotime($fechatemp));

											if($totalfacpro!=0.0){

											?>
													<tr>
														<td align="center"><?php echo $Fecha ?></td> 
														<td align="center"><?php echo $prod ?></td>
														<td align="center"><?php echo  number_format($libprod,2)?></td> 
														<td align="center"><?php echo number_format($cantprod,2) ?></td>
														<td align="center"><?php echo number_format($totalfacpro,2) ?></td> 
														<td align="center">Taquilla</td> 
														<td align="center"><?php echo $estanque ?></td>
													</tr>
													<?php

											}
											}
									?>
									
									</tbody>

									<tfoot>
									<tr>
													    
														<td align="center" colspan="6" ><h1 align="center"> <?php echo  "TOTALES"?> </h1></td> 
													     
													</tr>
									<tr>
										    <td align="left"></td>
											<td align="left">Tilapia</td>
										    <td align="left"><b><?php echo number_format($libprodps,2) ?></b></td>
										    <td align="left"><b><?php echo number_format($cantprodps,2) ?></b></td> 
										    <td align="left"><b><?php echo number_format($totalfacprops,2) ?></b></td> 
										    </tr>

											<tr>
										    <td align="left"></td>
											<td align="left">Taquilla</td>
										    <td align="left"><b><?php echo number_format($libprodtq,2) ?></b></td>
										    <td align="left"><b><?php echo number_format($cantprodtq,2) ?></b></td> 
										    <td align="left"><b><?php echo number_format($totalfacprotq,2) ?></b></td> 
										    </tr>
									
										<tr>
										    <td align="left"></td>
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

