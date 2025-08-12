<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
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
											<select name="Periodo" id="Periodo" class="form-control" required>
												<option value="" selected>SELECCIONE UNA OPCION</option>
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
								<div class="col-lg-12" align="center">
									<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Consultar</button>
								</div>
								<?php
									if(isset($_POST["Periodo"]))
									{
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
																	$Consulta = "SELECT DISTINCT (TRA_FECHA_TRANS)
																	FROM Contabilidad.TRANSACCION
																	WHERE E_CODIGO =2
																	AND PC_CODIGO = ".$_POST["Periodo"]."
																	ORDER BY TRA_FECHA_TRANS";
																	$Resultado = mysqli_query($db, $Consulta);
																	while($row = mysqli_fetch_array($Resultado))
																	{
																		$FechaFormato = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
  																		$FechaSinFormato = $row["TRA_FECHA_TRANS"];
  																		?>
																		<tr>
																			<td colspan="4"><b>Partidas del día <?php echo $FechaFormato ?></b></td>
																		</tr>
  																		<?php
  																		$QueryTipoTransaccion = mysqli_query($db, "SELECT DISTINCT(TT_CODIGO)
																		                                        FROM Contabilidad.TRANSACCION
																		                                        WHERE E_CODIGO =2
																		                                        AND PC_CODIGO = ".$_POST["Periodo"]."
																		                                        AND TRA_FECHA_TRANS = '".$FechaSinFormato."'
																		                                        ORDER BY TT_CODIGO");
																		while($fila = mysqli_fetch_array($QueryTipoTransaccion))
																		{
																			$SumaCargos = 0;
																		    $SumaAbonos = 0; 
																		    $TipoTransaccion = $fila["TT_CODIGO"];
																		    $NombreTransaccion = saber_nombre_transaccion_contabilidad($TipoTransaccion);
																		    $txt = "#".$FacturaContador." ".$NombreTransaccion." ".date('d-m-Y', strtotime($FechaSinFormato));
																		    ?>
																				<tr>
																					<td colspan="4"><b><?php echo $txt ?></b></td>
																				</tr>
																				<tr>
																					<td align="left" style="background-color: #C9C9C9"><b>Cuenta</b></td>
																				    <td align="left" style="background-color: #C9C9C9"><b>Descripción</b></td>
																				    <td align="right" style="background-color: #C9C9C9"><b>Debe</b></td>
																				    <td align="right" style="background-color: #C9C9C9"><b>Haber</b></td>
																				</tr>
																		    <?php
																		    $QueryPartida = mysqli_query($db, "SELECT SUM( A.TRAD_CARGO_CONTA ) AS CARGOS, SUM( A.TRAD_ABONO_CONTA ) AS ABONOS, A.N_CODIGO AS CODIGO_NOMENCLATURA, C.N_NOMBRE
																		                                  FROM Contabilidad.TRANSACCION_DETALLE AS A
																		                                  INNER JOIN Contabilidad.TRANSACCION AS B ON A.TRA_CODIGO = B.TRA_CODIGO
																		                                  INNER JOIN Contabilidad.NOMENCLATURA AS C ON A.N_CODIGO = C.N_CODIGO
																		                                  WHERE B.E_CODIGO =2
																		                                  AND B.PC_CODIGO = ".$_POST["Periodo"]."
																		                                  AND B.TRA_FECHA_TRANS = '".$FechaSinFormato."'
																		                                  AND B.TT_CODIGO = ".$TipoTransaccion."
																		                                  GROUP BY A.N_CODIGO");
																		    while($FilaP = mysqli_fetch_array($QueryPartida))
																		    {
																		    	$Codigo = $FilaP["CODIGO_NOMENCLATURA"];
																			    $Nombre = $FilaP["N_NOMBRE"];
																			    $Cargos = $FilaP["CARGOS"];
																			    $Abonos = $FilaP["ABONOS"];
																			    $SumaCargos += $Cargos;
																			    $SumaAbonos += $Abonos; 

																			    $CargosFormato = number_format($Cargos, 2);
																			    $AbonosFormato = number_format($Abonos, 2);

																			    ?>
																					<tr>
																				    	<td align="left" style="background-color: #C9C9C9"><?php echo $Codigo ?></td>
																				    	<td align="left" style="background-color: #C9C9C9"><?php echo $Nombre ?></td>
																				    	<td align="right" style="background-color: #C9C9C9"><?php echo $CargosFormato ?></td>
																				    	<td align="right" style="background-color: #C9C9C9"><?php echo $AbonosFormato ?></td>
																				    </tr>
																			    <?php
																		    }

																		    $SumaCargosFormato = number_format($SumaCargos, 2);
    																		$SumaAbonosFormato = number_format($SumaAbonos, 2);

																		    ?>
																				<tr>
																				    <td align="left" style="background-color: #C9C9C9"></td>
																				    <td align="left" style="background-color: #C9C9C9"><b>TOTALES</b></td>
																				    <td align="right" style="background-color: #C9C9C9"><b><?php echo $SumaCargosFormato ?></b></td>
																				    <td align="right" style="background-color: #C9C9C9"><b><?php echo $SumaAbonosFormato ?></b></td>
																			    </tr>
																			    <tr>
																			    	<td colspan="4"><hr></td>
																			    </tr>
																		    <?php

																		    $SumaTotalCargos += $SumaCargos;
																			$SumaTotalAbonos += $SumaAbonos;
																		}
																	}

																	$SumaTotalCargosFormato = number_format($SumaTotalCargos, 2);
																	$TotalGeneralAbonosFormato = number_format($SumaTotalAbonos, 2);

																	
																?>
															</tbody>
															<tfoot>
																<tr>
																	<td colspan="4" align="center"><b>Total de Cargos:  <?php echo $SumaTotalCargosFormato ?></b></td>
																</tr>
																<tr>
																	<td colspan="4" align="center"><b>Total de Abonos:  <?php echo $TotalGeneralAbonosFormato ?></b></td>
																</tr>
															</tfoot>
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
	</body>
	</html>
