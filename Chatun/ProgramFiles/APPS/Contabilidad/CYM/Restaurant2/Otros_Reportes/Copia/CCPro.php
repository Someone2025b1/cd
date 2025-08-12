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

	<script>
		function ImprimirCorte()
		{
			document.FormCorte.submit();
		}
	</script>


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<?php
				$Tipo = $_POST["TipoCierre"];

				$queryTasaCambioLempira = "SELECT TC_TASA FROM Contabilidad.TASA_CAMBIO WHERE TC_CODIGO = 1";
				$resultTasaCambioLempira = mysqli_query($db,$queryTasaCambioLempira);
				while($FilaTCL = mysqli_fetch_array($resultTasaCambioLempira))
				{
					$TasaCambioLempira = $FilaTCL["TC_TASA"];
				}

				$queryTasaCambioDolar = "SELECT TC_TASA FROM Contabilidad.TASA_CAMBIO WHERE TC_CODIGO = 2";
				$resultTasaCambioDolar = mysqli_query($db,$queryTasaCambioDolar);
				while($FilaTCL = mysqli_fetch_array($resultTasaCambioDolar))
				{
					$TasaCambioDolar = $FilaTCL["TC_TASA"];
				}

				$sql = "SELECT APERTURA_CIERRE_CAJA.*, CIERRE_DETALLE.* 
						FROM Bodega.APERTURA_CIERRE_CAJA, Bodega.CIERRE_DETALLE
						WHERE APERTURA_CIERRE_CAJA.ACC_CODIGO = CIERRE_DETALLE.ACC_CODIGO
						AND APERTURA_CIERRE_CAJA.ACC_FECHA = '".$_POST["FechaInicio"]."'
						AND APERTURA_CIERRE_CAJA.ACC_TIPO = 1
						AND APERTURA_CIERRE_CAJA.ACC_ESTADO = 2";
				$result = mysqli_query($db,$sql);
				while($fila = mysqli_fetch_array($result))
				{
					$Fecha        = $fila["ACC_FECHA"];
					$SaldoInicial = $fila["ACC_SALDO_INICIAL"];
					$Cierre       = $fila["ACC_CORRELATIVO"];
					
					$BQ200        = $fila["CD_Q_200"];
					$BQ100        = $fila["CD_Q_100"];
					$BQ50         = $fila["CD_Q_50"];
					$BQ20         = $fila["CD_Q_20"];
					$BQ10         = $fila["CD_Q_10"];
					$BQ5          = $fila["CD_Q_5"];
					$BQ1          = $fila["CD_Q_1"];
					$MQ1          = $fila["CD_M_1"];
					$MQ50         = $fila["CD_M_50"];
					$MQ25         = $fila["CD_M_25"];
					$MQ10         = $fila["CD_M_10"];
					$MQ5          = $fila["CD_M_5"];
					$TCQ          = $fila["CD_TOTAL_Q"];
					
					$BD100        = $fila["CD_D_100"];
					$BD50         = $fila["CD_D_50"];
					$BD20         = $fila["CD_D_20"];
					$BD10         = $fila["CD_D_10"];
					$BD5          = $fila["CD_D_5"];
					$BD1          = $fila["CD_D_1"];
					$TCD          = $fila["CD_TOTAL_D"];
					
					$BL500        = $fila["CD_L_500"];
					$BL100        = $fila["CD_L_100"];
					$BL50         = $fila["CD_L_50"];
					$BL20         = $fila["CD_L_20"];
					$BL10         = $fila["CD_L_10"];
					$BL5          = $fila["CD_L_5"];
					$TCL          = $fila["CD_TOTAL_L"];

					$Faltante     = $fila["CD_TOTAL_FALTANTE"];
					$Sobrante     = $fila["CD_TOTAL_SOBRANTE"];

				}

				$QueryMinMaxFacturas = "SELECT MAX(F_NUMERO) AS MAXIMO, MIN(F_NUMERO) AS MINIMO, F_SERIE FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."'";
				$ResultMinMaxFacturas = mysqli_query($db,$QueryMinMaxFacturas);
				while($FilaMinMaxFacturas = mysqli_fetch_array($ResultMinMaxFacturas))
				{
					$DelFactura = $FilaMinMaxFacturas["MINIMO"];
					$AlFactura = $FilaMinMaxFacturas["MAXIMO"];
					$SerieFactura = $FilaMinMaxFacturas["F_SERIE"];
				}

				$Query = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."'";
				$Result = mysqli_query($db,$Query);
				while($row = mysqli_fetch_array($Result))
				{
					$FacturasEmitidas = $row["FACTURAS_EMITIDAS"];
				}

				$Query1 = "SELECT COUNT(F_CODIGO) AS FACTURAS_ANULADAS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_ESTADO = 2";
				$Result1 = mysqli_query($db,$Query1);
				while($row1 = mysqli_fetch_array($Result1))
				{
					$FacturasAnuladas = $row1["FACTURAS_ANULADAS"];
				}


				$Query3 = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITO FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_TIPO = 2";
				$Result3 = mysqli_query($db,$Query3);
				while($row3 = mysqli_fetch_array($Result3))
				{
					$TotalTarjetaCredito = $row3["TOTAL_CREDITO"];
				}

				$Query4 = "SELECT SUM(F_TOTAL) AS TOTAL_DOLARES FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_TIPO = 1 AND F_MONEDA = 2";
				$Result4 = mysqli_query($db,$Query4);
				while($row4 = mysqli_fetch_array($Result4))
				{
					$TotalDolares = $row4["TOTAL_DOLARES"];
				}

				$TotalDolaresQuetzalisados = $TCD * $TasaCambioDolar;

				$Query4 = "SELECT SUM(F_TOTAL) AS TOTAL_LEMPIRAS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_TIPO = 1 AND F_MONEDA = 3";
				$Result4 = mysqli_query($db,$Query4);
				while($row4 = mysqli_fetch_array($Result4))
				{
					$TotalLempiras = $row4["TOTAL_LEMPIRAS"];
				}

				$TotalLempirasQuetzalisados = $TCL * $TasaCambioLempira;

				$Query5 = "SELECT SUM(F_TOTAL) AS TOTAL_DEPOSITOS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_TIPO = 4";
				$Result5 = mysqli_query($db,$Query5);
				while($row5 = mysqli_fetch_array($Result5))
				{
					$TotalDeposito = $row5["TOTAL_DEPOSITOS"];
				}	

				$Query6 = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITOS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_TIPO = 3";
				$Result6 = mysqli_query($db,$Query6);
				while($row6 = mysqli_fetch_array($Result6))
				{
					$TotalCreditos = $row6["TOTAL_CREDITOS"];
				}		

				$Query7 = "SELECT SUM(F_TOTAL) AS TOTAL_EFECTIVO FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_MONEDA = 1";
				$Result7 = mysqli_query($db,$Query7);
				while($row = mysqli_fetch_array($Result7))
				{
					$TotalEfectivo = $row["TOTAL_EFECTIVO"];
				}	

				$Query8 = "SELECT ACC_SALDO_INICIAL AS TOTAL_APERTURA FROM Bodega.APERTURA_CIERRE_CAJA WHERE ACC_FECHA = '".$Fecha."' AND ACC_TIPO = 1";
				$Result8 = mysqli_query($db,$Query8);
				while($row = mysqli_fetch_array($Result8))
				{
					$Apertura = $row["TOTAL_APERTURA"];
				}

				$Query9 = "SELECT SUM(F_CAMBIO) AS TOTAL_CAMBIO_LEMPIRA FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_MONEDA = 3";
				$Result9 = mysqli_query($db,$Query9);
				while($row = mysqli_fetch_array($Result9))
				{
					$CambioLempiras = $row["TOTAL_CAMBIO_LEMPIRA"];
				}

				$Query10 = "SELECT SUM(F_CAMBIO) AS TOTAL_CAMBIO_DOLARES FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_MONEDA = 2";
				$Result10 = mysqli_query($db,$Query10);
				while($row = mysqli_fetch_array($Result10))
				{
					$CambioDolares = $row["TOTAL_CAMBIO_DOLARES"];
				}

				$Query11 = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."'";
				$Result11 = mysqli_query($db,$Query11);
				while($row = mysqli_fetch_array($Result11))
				{
					$TotalFacturado = $row["TOTAL_FACTURADO"];
				}

				$TCQ = $TCQ - $Apertura;


				$TotalEfectivo = $TotalEfectivo - $CambioLempiras - $CambioDolares;

				$Total = ($TCQ + $TotalTarjetaCredito + $TotalDolaresQuetzalisados + $TotalLempirasQuetzalisados + $TotalDeposito + $TotalCreditos);

				$FaltSob = $Total - $TotalFacturado;
			?>
			<div class="container">
				<form class="form" action="CCPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="panel-group" id="accordion6">
							<div class="card panel">
								<div class="card-head style-info collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-1" aria-expanded="false">
									<header>Cuadre Caja</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-1" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-daterange input-group" id="demo-date-range">
														<div class="input-group-content">
															<input type="date" class="form-control" name="FechaInicio" value="<?php echo $Fecha ?>" readonly>
															<label>Fecha del Corte</label>
														</div>
													</div>
												</div>
											</div>	
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-daterange input-group" id="demo-date-range">
														<div class="input-group-content">
															<input type="number" class="form-control" name="FacturasEmitidas" value="<?php echo $FacturasEmitidas ?>" readonly>
															<label>Facturas Emitidas</label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-daterange input-group" id="demo-date-range">
														<div class="input-group-content">
															<input type="number" class="form-control" name="FacturasAnuladas" value="<?php echo $FacturasAnuladas ?>" readonly>
															<label>Facturas Anuladas</label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-5">
												<div class="form-group">
													<div class="input-daterange input-group" id="demo-date-range">
														<div class="input-group-content">
															<input type="text" class="form-control" name="FacturasAnuladas" value="<?php echo 'Serie '.$SerieFactura.' de la '.$DelFactura.' a la '.$AlFactura; ?>" readonly>
															<label>Facturas</label>
														</div>
													</div>
												</div>
											</div>			
											<div class="col-lg-12">
												<table class="table table-hover table-condensed">
													<tbody>
														<tr>
															<td><h5><b>Efectivo</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TCQ, 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Crédito</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalCreditos, 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Tarjeta Crédito</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalTarjetaCredito, 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Dólar</b></h5></td>
															<td align="right"><h5><?php echo '$. '.number_format($TCD, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalDolaresQuetzalisados, 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Lempira</b></h5></td>
															<td align="right"><h5><?php echo 'L. '.number_format($TCL, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalLempirasQuetzalisados, 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Depósitos</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalDeposito, 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td align="center"><h2><b>Total Ingresos</b></h2></td>
															<td colspan="2" align="right"><h2><?php echo 'Q. '.number_format($Total, 2, '.', ','); ?></h2></td>
														</tr>
														<tr>
															<td align="center"><h2><b>Total Facturado</b></h2></td>
															<td colspan="2" align="right"><h2><?php echo 'Q. '.number_format($TotalFacturado, 2, '.', ','); ?></h2></td>
														</tr>
														<tr>
															<td><h5><b>Faltante</b></h5></td>
															<td colspan="2" align="right"><h5><?php if($FaltSob < 0){echo 'Q. '.number_format($FaltSob, 2, '.', ',');}elseif($FaltSob == 0){echo 'Q. '.number_format(0, 2, '.', ',');}else{echo 'Q. '.number_format(0, 2, '.', ',');} ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Sobrante</b></h5></td>
															<td colspan="2" align="right"><h5><?php if($FaltSob > 0){echo 'Q. '.number_format($FaltSob, 2, '.', ',');}elseif($FaltSob == 0){echo 'Q. '.number_format(0, 2, '.', ',');}else{echo 'Q. '.number_format(0, 2, '.', ',');} ?></h5></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div><!--end .panel -->
							<div class="card panel">
								<div class="card-head style-warning collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-2" aria-expanded="false">
									<header>Detalle de Cuadre Caja</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-2" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">
											<div class="col-lg-12">
												<div class="card tabs-left style-default-light">
													<ul class="card-head nav nav-tabs" data-toggle="tabs">
														<li class="active"><a href="#first5">Quetzales</a></li>
														<li class=""><a href="#second5">Dólares</a></li>
														<li><a href="#third5">Lempiras</a></li>
													</ul>
													<div class="card-body tab-content style-default-bright">
														<div class="tab-pane active" id="first5">
															<h3 class="text-light"><strong>Cuadre de Efectivo (Q)</strong></h3>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ200" id="BQ200" value="<?php echo $BQ200 ?>" min="0" required readonly/>
																	<label for="BQ200">Billetes de Q. 200</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ100" id="BQ100" value="<?php echo $BQ100 ?>" min="0" required readonly/>
																	<label for="BQ100">Billetes de Q. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ50" id="BQ50" value="<?php echo $BQ50 ?>" min="0" required readonly/>
																	<label for="BQ50">Billetes de Q. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ20" id="BQ20" value="<?php echo $BQ20 ?>" min="0" required readonly/>
																	<label for="BQ20">Billetes de Q. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ10" id="BQ10" value="<?php echo $BQ10 ?>" min="0" required readonly/>
																	<label for="BQ10">Billetes de Q. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ5" id="BQ5" value="<?php echo $BQ5 ?>" min="0" required readonly/>
																	<label for="BQ5">Billetes de Q. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ1" id="BQ1" value="<?php echo $BQ1 ?>" min="0" required readonly/>
																	<label for="BQ1">Billetes de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ1" id="MQ1" value="<?php echo $MQ1 ?>" min="0" required readonly/>
																	<label for="MQ1">Monedas de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ50" id="MQ50" value="<?php echo $MQ50 ?>" min="0" required readonly/>
																	<label for="MQ50">Monedas de C. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ25" id="MQ25" value="<?php echo $MQ25 ?>" min="0" required readonly/>
																	<label for="MQ25">Monedas de C. 25</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ10" id="MQ10" value="<?php echo $MQ10 ?>" min="0" required readonly/>
																	<label for="MQ10">Monedas de C. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ5" id="MQ5" value="<?php echo $MQ5 ?>" min="0" required readonly/>
																	<label for="MQ5">Monedas de C. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" step="any" name="Apertura" id="Apertura" value="<?php echo $Apertura ?>" min="0" required readonly/>
																	<label for="Apertura">(-)Apertura</label>
																</div>
															</div>											
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="text" step="any" name="TCQ" id="TCQ" value="<?php echo $TCQ ?>" min="0" required readonly/>
																	<label for="TCQ">Total de Cuadre en Quetzales</label>
																</div>
															</div>
														</div>
														<div class="tab-pane" id="second5">
															<h3 class="text-light"><strong>Cuadre de Efectivo ($)</strong></h3>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD100" id="BD100" value="<?php echo $BD100 ?>" min="0" required readonly/>
																	<label for="BD100">Billetes de $. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD50" id="BD50" value="<?php echo $BD50 ?>" min="0" required readonly/>
																	<label for="BD50">Billetes de $. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD20" id="BD20" value="<?php echo $BD20 ?>" min="0" required readonly/>
																	<label for="BD20">Billetes de $. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD10" id="BD10" value="<?php echo $BD10 ?>" min="0" required readonly/>
																	<label for="BD10">Billetes de $. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD5" id="BD5" value="<?php echo $BD5 ?>" min="0" required readonly/>
																	<label for="BD5">Billetes de $. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD1" id="BD1" value="<?php echo $BD1 ?>" min="0" required readonly/>
																	<label for="BD1">Billetes de $. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="TCD" id="TCD" value="<?php echo $TCD ?>" min="0" required readonly />
																	<label for="TCD">Total de Cuadre en Dólares</label>
																</div>
															</div>
														</div>
														<div class="tab-pane" id="third5">
															<h3 class="text-light"><strong>Cuadre de Efectivo (L)</strong></h3>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL500" id="BL500" value="<?php echo $BL500 ?>" min="0" readonly />
																	<label for="BL500">Billetes de L. 500</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL100" id="BL100" value="<?php echo $BL100 ?>" min="0" readonly />
																	<label for="BL100">Billetes de L. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL50" id="BL50" value="<?php echo $BL50 ?>" min="0" readonly />
																	<label for="BL50">Billetes de L. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL20" id="BL20" value="<?php echo $BL20 ?>" min="0" readonly />
																	<label for="BL20">Billetes de L. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL10" id="BL10" value="<?php echo $BL10 ?>" min="0" readonly />
																	<label for="BL10">Billetes de L. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL5" id="BL5" value="<?php echo $BL5 ?>" min="0" readonly />
																	<label for="BL5">Billetes de L. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="TCL" id="TCL" value="<?php echo $TCL ?>" min="0" required readonly />
																	<label for="TCL">Total de Cuadre en Lempiras</label>
																</div>
															</div>
														</div>
													</div><!--end .card-body -->
												</div><!--end .card -->
											</div>
										</div>
									</div>
								</div>
							</div><!--end .panel -->
							<div class="card panel">
								<div class="card-head style-accent collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-3" aria-expanded="false">
									<header>Detalle de Facturas</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-3" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<table class="table" id="tbl_resultados">
											<thead>
												<tr>
													<th>Serie</th>
													<th>Factura</th>
													<th>NIT</th>
													<th>Neto</th>
													<th>IVA</th>
													<th>Total</th>
													<th>Tipo</th>
													<th>Moneda</th>
													<th>Descuento</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$SqlFacturas = "SELECT FACTURA.* FROM Bodega.FACTURA
																	WHERE FACTURA.F_FECHA_TRANS = '".$_POST["FechaInicio"]."' 
																	ORDER BY FACTURA.F_SERIE, FACTURA.F_NUMERO";
													$ResultFacturas = mysqli_query($db,$SqlFacturas);
													while($FilasFacturas = mysqli_fetch_array($ResultFacturas))
													{
														if($FilasFacturas["F_TIPO"] == 1)
														{
															$Tipo = 'Efectivo';
														}
														elseif($FilasFacturas["F_TIPO"] == 2)
														{
															$Tipo = 'Tarjeta Crédito';
														}
														elseif($FilasFacturas["F_TIPO"] == 3)
														{
															$Tipo = 'Crédito';
														}
														elseif($FilasFacturas["F_TIPO"] == 4)
														{
															$Tipo = 'Depósito';
														}

														if($FilasFacturas["F_TIPO"] == 1)
														{
															if($FilasFacturas["F_MONEDA"] == 1)
															{
																$Moneda = 'Quetzal';
															}
															elseif($FilasFacturas["F_MONEDA"] == 2)
															{
																$Moneda = 'Dólar';
															}
															elseif($FilasFacturas["F_MONEDA"] == 3)
															{
																$Moneda = 'Lempira';
															}
														}
														elseif($FilasFacturas["F_TIPO"] == 4)
														{
															$Moneda = 'Quetzal';
														}
														else
														{
															$Moneda = '---';
														}

														
														$IVA = ($FilasFacturas["F_TOTAL"] * 0.12) / 1.12;
														$Neto = $FilasFacturas["F_TOTAL"] - $IVA;

														echo '<tr>';
															echo '<td>'.$FilasFacturas["F_SERIE"].'</td>';
															echo '<td>'.$FilasFacturas["F_NUMERO"].'</td>';
															echo '<td>'.$FilasFacturas["CLI_NIT"].'</td>';
															echo '<td>'.number_format($Neto, 2, '.', ',').'</td>';
															echo '<td>'.number_format($IVA, 2, '.', ',').'</td>';
															echo '<td>'.number_format($FilasFacturas["F_TOTAL"], 2, '.', ',').'</td>';
															if($FilasFacturas["F_ESTADO"] == 2)
															{	
																echo '<td>ANULADA</td>';
																echo '<td>ANULADA</td>';
															}
															elseif($FilasFacturas["F_ESTADO"] == 1)
															{
																echo '<td>'.$Tipo.'</td>';
																echo '<td>'.$Moneda.'</td>';
															}
															echo '<td>'.number_format($FilasFacturas["F_CON_DESCUENTO"], 2, '.', ',').'</td>';
														echo '</tr>';
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div><!--end .panel -->
							<div class="card panel">
								<div class="card-head style-success collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-4" aria-expanded="false">
									<header>Formato de Impresión</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-4" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="col-lg-12 text-center">
												<button class="btn btn-lg btn-primary" type="button" onclick="ImprimirCorte()">Imprimir</button>
											</div>
									</div>
								</div>
							</div><!--end .panel -->
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->

		<form method="POST" target="_blank" action="CierreImp.php" name="FormCorte">

			<input type="hidden" name="TipoCorte" id="TipoCorte" value="Restaurante Terrazas">

			<input type="hidden" name="FechaImp" id="FechaImp" value="<?php echo $Fecha ?>">
			<input type="hidden" name="FacturasEmitidasCorte" id="FacturasEmitidasCorte" value="<?php echo $FacturasEmitidas ?>">
			<input type="hidden" name="FacturasAnuladasCorte" id="FacturasAnuladasCorte" value="<?php $FacturasAnuladas ?>">
			<input type="hidden" name="SerieFacturaCorte" id="SerieFacturaCorte" value="<?php echo $SerieFactura; ?>">
			<input type="hidden" name="DelFacturaCorte" id="DelFacturaCorte" value="<?php echo $DelFactura ?>">
			<input type="hidden" name="AlFacturaCorte" id="AlFacturaCorte" value="<?php echo $AlFactura ?>">

			<input type="hidden" name="EfectivoCorte" id="EfectivoCorte" value="<?php echo $TCQ ?>">
			<input type="hidden" name="CreditoCorte" id="CreditoCorte" value="<?php echo $TotalCreditos ?>">
			<input type="hidden" name="TCCorte" id="TCCorte" value="<?php echo $TotalTarjetaCredito ?>">
			<input type="hidden" name="DolaresCorte" id="DolaresCorte" value="<?php echo $TCD ?>">
			<input type="hidden" name="Dolares1Corte" id="Dolares1Corte" value="<?php echo $TotalDolaresQuetzalisados ?>">
			<input type="hidden" name="LempirasCorte" id="LempirasCorte" value="<?php echo $TCL ?>">
			<input type="hidden" name="Lempiras1Corte" id="Lempiras1Corte" value="<?php echo $TotalLempirasQuetzalisados ?>">
			<input type="hidden" name="DepositosCorte" id="DepositosCorte" value="<?php echo $TotalDeposito ?>">
			<input type="hidden" name="IngresosCorte" id="IngresosCorte" value="<?php echo $Total ?>">
			<input type="hidden" name="FacturadoCorte" id="FacturadoCorte" value="<?php echo $TotalFacturado ?>">
			<input type="hidden" name="FaltanteSobrante" id="FaltanteSobrante" value="<?php echo $FaltSob ?>">


		</form>
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
