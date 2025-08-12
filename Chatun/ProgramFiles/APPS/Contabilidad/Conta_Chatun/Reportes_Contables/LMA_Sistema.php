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
								<h4 class="text-center"><strong>Libro Mayor Agrupado</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<div class="col-lg-3"></div>
									<div class="col-lg-6">
										<div class="form-group">
											<div class="input-daterange input-group" id="demo-date-range">
												<div class="input-group-content">
													<input type="date" class="form-control" name="FechaInicio" value="<?php echo date('Y-m-d') ?>">
													<label>Rango de Fechas</label>
												</div>
												<span class="input-group-addon">al</span>
												<div class="input-group-content">
													<input type="date" class="form-control" name="FechaFin" value="<?php echo date('Y-m-d') ?>">
													<div class="form-control-line"></div>
												</div>
											</div>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="col-lg-12" align="center">
									<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Consultar</button>
								</div>
								<?php
									if(isset($_POST["FechaInicio"]) && isset($_POST["FechaFin"]))
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
																	$FechaIni = $_POST["FechaInicio"];
																	$FechaFin = $_POST["FechaFin"];
																	$FechaFinal = date("Y-m-d", strtotime("$FechaIni -1  days"));

																	

																	$Consulta1 = "SELECT `TRANSACCION_DETALLE`.`N_CODIGO` , `NOMENCLATURA`.`N_NOMBRE`
																	FROM `Contabilidad`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE` , `Contabilidad`.`NOMENCLATURA` AS `NOMENCLATURA` , `Contabilidad`.`TRANSACCION` AS `TRANSACCION`
																	WHERE `TRANSACCION_DETALLE`.`N_CODIGO` = `NOMENCLATURA`.`N_CODIGO`
																	AND `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO`
																	AND `TRANSACCION`.`TRA_FECHA_TRANS`
																	BETWEEN '".$FechaIni."'
																	AND '".$FechaFin."'
																	AND TRANSACCION.E_CODIGO = 2
																	GROUP BY `TRANSACCION_DETALLE`.`N_CODIGO`
																	ORDER BY `TRANSACCION_DETALLE`.`N_CODIGO` ASC , `TRANSACCION`.`TRA_CORRELATIVO` ASC ";
																	$Resultado1 = mysqli_query($db, $Consulta1);
																	while($row1 = mysqli_fetch_array($Resultado1))
																	{
																		$TotalCargos = 0;
																	    $TotalAbonos = 0;
																	    $Saldo = 0;

																		$CodigoContable = $row1["N_CODIGO"];
    																	$Nombrecontable = $row1["N_NOMBRE"];

    																	?>
																			<tr>
																				<td colspan="4" style="background-color: #C9C9C9" align="center"><b><?php echo $CodigoContable.' - '.$Nombrecontable ?></b></td>
																			</tr>
																			<tr>
																				<td align="left" style="background-color: #C9C9C9"><b>Descripción</b></td>
																			    <td align="left" style="background-color: #C9C9C9"><b>Cargos</b></td>
																			    <td align="right" style="background-color: #C9C9C9"><b>Abonos</b></td>
																			    <td align="right" style="background-color: #C9C9C9"><b>Saldo</b></td>
																			</tr>
    																	<?php

    																	$sql2 = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_CONTA` ) AS `SUMA_CARGOS` , SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_CONTA` ) AS `SUMA_ABONOS` , `NOMENCLATURA`.`N_TIPO`
																	        FROM `Contabilidad`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE` , `Contabilidad`.`TRANSACCION` AS `TRANSACCION` , `Contabilidad`.`NOMENCLATURA` AS `NOMENCLATURA`
																	        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO`
																	        AND `TRANSACCION_DETALLE`.`N_CODIGO` = `NOMENCLATURA`.`N_CODIGO`
																	        AND `TRANSACCION`.`TRA_FECHA_TRANS`
																	        BETWEEN '2015-01-01'
																	        AND '".$FechaFinal."'
																	        AND `TRANSACCION_DETALLE`.`N_CODIGO` = '".$CodigoContable."'
																	        AND TRANSACCION.E_CODIGO = 2";    


																	    $result2 = mysqli_query($db, $sql2);
																	    if($fila = mysqli_fetch_array($result2))
																	    {
																	    	$Cargos = $fila["SUMA_CARGOS"];
																	        $Abonos = $fila["SUMA_ABONOS"];
																	        $Cargo = number_format($fila["SUMA_CARGOS"], 2, '.', ',');
																	        $Abono = number_format($fila["SUMA_ABONOS"], 2, '.', ',');
																	        $Saldo = $Saldo + ($Cargos - $Abonos);
																	        $SaldoArreglado = number_format($Saldo, 2, '.', ',');
																	       
																	        $TotalCargos = $TotalCargos + $fila["SUMA_CARGOS"];
																	        $TotalAbonos = $TotalAbonos + $fila["SUMA_ABONOS"];
																	        ?>
																				<tr>
																					<td align="left">Saldos Anteriores</td>
																				    <td align="left"><?php echo number_format($Cargos, 2) ?></td>
																				    <td align="right"><?php echo number_format($Abonos, 2) ?></td>
																				    <td align="right"><?php echo number_format($Saldo, 2) ?></td>
																				</tr>
																	        <?php
																	    }

																	    $sql2 = "SELECT `TRANSACCION`.`TRA_FECHA_TRANS`, SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_CONTA` ) AS `SUMA_CARGOS` , SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_CONTA` ) AS `SUMA_ABONOS` , `NOMENCLATURA`.`N_TIPO`
																	        FROM `Contabilidad`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE` , `Contabilidad`.`TRANSACCION` AS `TRANSACCION` , `Contabilidad`.`NOMENCLATURA` AS `NOMENCLATURA`
																	        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO`
																	        AND `TRANSACCION_DETALLE`.`N_CODIGO` = `NOMENCLATURA`.`N_CODIGO`
																	        AND `TRANSACCION`.`TRA_FECHA_TRANS`
																	        BETWEEN '".$FechaIni."'
																	        AND '".$FechaFin."'
																	        AND `TRANSACCION_DETALLE`.`N_CODIGO` = '".$CodigoContable."'
																	        AND TRANSACCION.E_CODIGO = 2
																	        GROUP BY `TRANSACCION`.`TRA_FECHA_TRANS`";    


																	    $result2 = mysqli_query($db, $sql2);
																	    while($fila = mysqli_fetch_array($result2))
																	    {
																	    	$Cargos = $fila["SUMA_CARGOS"];
																	        $Abonos = $fila["SUMA_ABONOS"];
																	        $Cargo = number_format($fila["SUMA_CARGOS"], 2, '.', ',');
																	        $Abono = number_format($fila["SUMA_ABONOS"], 2, '.', ',');
																	        $Saldo = $Saldo + ($Cargos - $Abonos);
																	        $SaldoArreglado = number_format($Saldo, 2, '.', ',');
																	       
																	        $TotalCargos = $TotalCargos + $fila["SUMA_CARGOS"];
																	        $TotalAbonos = $TotalAbonos + $fila["SUMA_ABONOS"];

																	        ?>
																				<tr>
																					<td align="left"><?php echo 'Movimientos del '.date('d-m-Y', strtotime($fila["TRA_FECHA_TRANS"])) ?></td>
																				    <td align="left"><?php echo number_format($Cargos, 2) ?></td>
																				    <td align="right"><?php echo number_format($Abonos, 2) ?></td>
																				    <td align="right"><?php echo number_format($Saldo, 2) ?></td>
																				</tr>
																	        <?php
																	    }

																	    ?>
																				<tr>
																				    <td align="right"><b></b></td>
																					<td align="left"><b><?php echo 'SUMAS' ?></b></td>
																				    <td align="right"><b><?php echo number_format($TotalCargos, 2) ?></b></td>
																				    <td align="right"><b><?php echo number_format($TotalAbonos, 2) ?></b></td>
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
	</body>
	</html>
