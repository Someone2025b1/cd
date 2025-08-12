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

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="#" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Libro Diario</strong></h4>
							</div>
							<div class="card-body">
							<div class="row text-center">
									<div class="col-lg-3"></div>
									<div class="col-lg-6">
										<div class="form-group">
											<select name="Tipo" id="Tipo" class="form-control" onchange="TipoBusqueda(this.value)">
												<option selected>Seleccione</option>
												<option value="1">Periodo</option>
												<option value="2">Fechas</option>
											</select>
											<label for="Tipo">Tipo Búsqueda</label>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="row text-center" id="DivPeriodo" style="display: none;">
									<div class="col-lg-3"></div>
									<div class="col-lg-6">
										<div class="form-group">
											<select name="Periodo" id="Periodo" class="form-control">
												<option value="x" selected>SELECCIONE UNA OPCION</option>
												option
												<?php
													$QueryPeriodo = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE EPC_CODIGO = 1";
													$ResultPeriodo = mysqli_query($db, $QueryPeriodo);
													while($FilaP = mysqli_fetch_array($ResultPeriodo))
													{
														echo '<option value="'.$FilaP["PC_CODIGO"].'">'.$FilaP["PC_MES"]."-".$FilaP["PC_ANHO"].'</option>';
												}
												?>
											</select>
											<label for="Periodo">Periodo</label>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="row text-center" id="DivFecha" style="display: none;"> 
									<div class="col-lg-3"></div>
									<div class="col-lg-3">
										<label for="">Fecha Inicial</label>
										<input type="date" class="form-control" id="FechaInicial" name="FechaInicial">
									</div> 
									<div class="col-lg-3">
										<label for="">Fecha Final</label>
										<input type="date" class="form-control" id="FechaFinal" name="FechaFinal">
									</div> 
								</div>
								<br>
								<div class="col-lg-12" align="center">
									<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Consultar</button>
								</div>
								<br>
								<?php
									if($_POST["Periodo"]!="x" || (isset($_POST["FechaInicial"])) )
									{
										if($_POST["Periodo"]!="x")
										{
											$Filtro = "AND PC_CODIGO = ".$_POST['Periodo']."";
										}
										else
										{
											$Filtro = "AND TRA_FECHA_TRANS BETWEEN '$_POST[FechaInicial]' AND '$_POST[FechaFinal]'";
										}
										?>
											<div class="row">
												<br>
												<br>
												<br>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<div class="table-responsive">
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
																	<th data-sortable="true" data-field="CUENTA" data-filter-control="input"><h6><strong></strong></h6></th>
																	<th data-sortable="true" data-field="NOMBRE" data-filter-control="input"><h6><strong></strong></h6></th>
																	<th data-sortable="true" data-field="DEBE" data-filter-control="input"><h6><strong></strong></h6></th>
																	<th data-sortable="true" data-field="HABER" data-filter-control="input"><h6><strong></strong></h6></th>
																</tr>
															</thead>
															<tbody>
																<?php
																	$Consulta1 = "SELECT TRANSACCION.*, TIPO_TRANSACCION.TT_NOMBRE FROM Contabilidad.TRANSACCION, Contabilidad.TIPO_TRANSACCION
																		            WHERE TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO 
																		            AND E_CODIGO = 2 AND TRA_ESTADO = 1	
																		            $Filtro
																		            ORDER BY TRA_CORRELATIVO, TRA_FECHA_TRANS, TRA_HORA";
																					 
																		$Resultado1 = mysqli_query($db, $Consulta1);
																		while($row1 = mysqli_fetch_array($Resultado1))
																		{
																			$TotalCargos = 0;
																							$TotalAbonos = 0;
																			$Codigo = $row1["TRA_CODIGO"];
																			$NoPartida = $row1["TRA_CORRELATIVO"]; 
																			$Concepto = $row1["TRA_CONCEPTO"]; 
																			$Transaccion = $row1["TT_NOMBRE"];
																			$Fecha = date('d-m-Y', strtotime($row1["TRA_FECHA_TRANS"])); 
																			?>
																				<tr>
																					<td colspan="4"><b># <?php echo $NoPartida.'   '.$Transaccion.' del '.$Fecha ?></b></td>
																				</tr>
																				<tr>
																					<td colspan="4"><b><?php echo $Concepto ?></b></td>
																				</tr>
																				<tr>	
																					<td><b>CUENTA</b></td>
																					<td><b>NOMBRE</b></td>
																					<td><b>DEBE</b></td>
																					<td><b>HABER</b></td>
																				</tr>
																					<?php
																						$Consulta = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA 
																						WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
																						AND TRA_CODIGO = '".$Codigo."'";
																						$Resultado = mysqli_query($db, $Consulta);
																						while($row = mysqli_fetch_array($Resultado))
																						{
																							$Codigo = $row["N_CODIGO"];
																							$Nombre = $row["N_NOMBRE"];
																							$Cargos = $row["TRAD_CARGO_CONTA"];
																							$Abonos = $row["TRAD_ABONO_CONTA"];
																							?>
																								<tr>
																									<td align="left"><?php echo $Codigo ?></td>
																									<td align="left"><?php echo $Nombre ?></td>
																									<td align="right"><?php echo number_format($Cargos, 2) ?></td>
																									<td align="right"><?php echo number_format($Abonos, 2) ?></td>
																								</tr>
																							<?php
																							$TotalCargos = $TotalCargos + $Cargos;
																							$TotalAbonos = $TotalAbonos + $Abonos;
																						}

																						$TotalGeneralCargos = $TotalGeneralCargos + $TotalCargos;
																						$TotalGeneralAbonos = $TotalGeneralAbonos + $TotalAbonos;
																					?>
																				<tr>
																					<td align="left"></td>
																					<td align="left"><b>Sumas Iguales</b></td>
																					<td align="right"><b><?php  echo number_format($TotalCargos, 2) ?></b></td>
																					<td align="right"><b><?php  echo number_format($TotalAbonos, 2) ?></b></td>
																				</tr>
																			<?php
																		}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										<?php
									}
								?>
							</div>
						</div>
					</div>
					<br>
					<br>
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
	<!-- END BASE -->
	<script>
		function TipoBusqueda(Valor)
		{
			if(Valor==1)
			{
				$("#DivPeriodo").show();
				$("#DivFecha").hide();
			}
			else
			{
				$("#DivPeriodo").hide();
				$("#DivFecha").show();
			}
		}
	</script>
	</body>
	</html>
