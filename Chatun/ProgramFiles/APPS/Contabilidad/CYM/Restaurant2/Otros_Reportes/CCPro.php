<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Conteo = mysqli_num_rows(mysqli_query($db, "SELECT *FROM Bodega.CIERRE_DETALLE a 
INNER JOIN Bodega.APERTURA_CIERRE_CAJA b ON a.ACC_CODIGO = b.ACC_CODIGO
WHERE b.ACC_FECHA = '".$_POST["FechaInicio"]."' AND b.ACC_TIPO = 20"));

$Conteo1 = mysqli_num_rows(mysqli_query($db, "SELECT *FROM Bodega.CUADRE_CAJA a WHERE a.Fecha = '".$_POST["FechaInicio"]."'"));

date_default_timezone_set('America/Guatemala');    

$DateAndTime = date('G', time());  
 
if ($Conteo==1 && $DateAndTime<15) 
{
	$FiltroUser = "AND F_USUARIO = $id_user";
	$filtroOtro = "and CD_USUARIO = $id_user";
}
elseif ($Conteo==1 && $DateAndTime>15) 
{
	$FiltroUser = "";
	$filtroOtro = "";
}
elseif ($Conteo==2 && $DateAndTime>15) 
{
	$FiltroUser = "AND F_USUARIO = $id_user";
	$filtroOtro = "and CD_USUARIO = $id_user";
}

$FiltroUser = "";
	$filtroOtro = "";


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
						AND APERTURA_CIERRE_CAJA.ACC_TIPO = 20  $filtroOtro";
				$result = mysqli_query($db,$sql);
				while($fila = mysqli_fetch_array($result))
				{
					$Fecha        = $fila["ACC_FECHA"];
					$SaldoInicial = $fila["ACC_SALDO_INICIAL"];
					$Cierre       = $fila["ACC_CORRELATIVO"];
					$Codigo       = $fila["ACC_CODIGO"];
					$BilletesQ200   = $fila["CD_Q_200"];
					$BilletesQ100   = $fila["CD_Q_100"];
					$BilletesQ50    = $fila["CD_Q_50"];
					$BilletesQ20    = $fila["CD_Q_20"];
					$BilletesQ10    = $fila["CD_Q_10"];
					$BilletesQ5     = $fila["CD_Q_5"];
					$BilletesQ1     = $fila["CD_Q_1"];
					$BilletesM1     = $fila["CD_M_1"];
					$BilletesM50    = $fila["CD_M_50"];
					$BilletesM25    = $fila["CD_M_25"];
					$BilletesM10    = $fila["CD_M_10"];
					$BilletesM_5    = $fila["CD_M_5"];
					$TCQ = $fila["CD_TOTAL_Q"];
					
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

				 

				$Query = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser";
				$Result = mysqli_query($db,$Query);
				while($row = mysqli_fetch_array($Result))
				{
					$FacturasEmitidas = $row["FACTURAS_EMITIDAS"];
				}

				$Query1 = "SELECT COUNT(F_CODIGO) AS FACTURAS_ANULADAS FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser AND F_ESTADO = 2";
				$Result1 = mysqli_query($db,$Query1);
				while($row1 = mysqli_fetch_array($Result1))
				{
					$FacturasAnuladas = $row1["FACTURAS_ANULADAS"];
				}


				$Query3 = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITO FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser AND F_TIPO = 2";
				$Result3 = mysqli_query($db,$Query3);
				while($row3 = mysqli_fetch_array($Result3))
				{
					$TotalTarjetaCredito = $row3["TOTAL_CREDITO"];
				}

				$Query4 = "SELECT SUM(F_TOTAL) AS TOTAL_DOLARES FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser AND F_TIPO = 1 AND F_MONEDA = 2";
				$Result4 = mysqli_query($db,$Query4);
				while($row4 = mysqli_fetch_array($Result4))
				{
					$TotalDolares = $row4["TOTAL_DOLARES"];
				}

				$TotalDolaresQuetzalisados = $TCD * $TasaCambioDolar;

				$Query4 = "SELECT SUM(F_TOTAL) AS TOTAL_LEMPIRAS FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser AND F_TIPO = 1 AND F_MONEDA = 3";
				$Result4 = mysqli_query($db,$Query4);
				while($row4 = mysqli_fetch_array($Result4))
				{
					$TotalLempiras = $row4["TOTAL_LEMPIRAS"];
				}

				$TotalLempirasQuetzalisados = $TCL * $TasaCambioLempira;

				$Query5 = "SELECT SUM(F_TOTAL) AS TOTAL_DEPOSITOS FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser AND F_TIPO = 4";
				$Result5 = mysqli_query($db,$Query5);
				while($row5 = mysqli_fetch_array($Result5))
				{
					$TotalDeposito = $row5["TOTAL_DEPOSITOS"];
				}	

				$Query6 = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITOS FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser AND F_TIPO = 3";
				$Result6 = mysqli_query($db,$Query6);
				while($row6 = mysqli_fetch_array($Result6))
				{
					$TotalCreditos = $row6["TOTAL_CREDITOS"];
				}		

				$Query7 = "SELECT SUM(F_TOTAL) AS TOTAL_EFECTIVO FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser AND F_MONEDA = 1";
				$Result7 = mysqli_query($db,$Query7);
				while($row = mysqli_fetch_array($Result7))
				{
					$TotalEfectivo = $row["TOTAL_EFECTIVO"];
				}	

				$Query8 = "SELECT ACC_SALDO_INICIAL AS TOTAL_APERTURA FROM Bodega.APERTURA_CIERRE_CAJA WHERE ACC_FECHA = '".$Fecha."' AND ACC_TIPO = 20";
				$Result8 = mysqli_query($db,$Query8);
				while($row = mysqli_fetch_array($Result8))
				{
					$Apertura = $row["TOTAL_APERTURA"];
				}

				$Query9 = "SELECT SUM(F_CAMBIO) AS TOTAL_CAMBIO_LEMPIRA FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser AND F_MONEDA = 3";
				$Result9 = mysqli_query($db,$Query9);
				while($row = mysqli_fetch_array($Result9))
				{
					$CambioLempiras = $row["TOTAL_CAMBIO_LEMPIRA"];
				}

				$Query10 = "SELECT SUM(F_CAMBIO) AS TOTAL_CAMBIO_DOLARES FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser AND F_MONEDA = 2";
				$Result10 = mysqli_query($db,$Query10);
				while($row = mysqli_fetch_array($Result10))
				{
					$CambioDolares = $row["TOTAL_CAMBIO_DOLARES"];
				}

				$Query11 = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '".$Fecha."' $FiltroUser";
				$Result11 = mysqli_query($db,$Query11);
				while($row = mysqli_fetch_array($Result11))
				{
					$TotalFacturado = $row["TOTAL_FACTURADO"];
				}

				$TCQ = $TCQ - $Apertura;


				$TotalEfectivo = $TotalEfectivo - $CambioLempiras - $CambioDolares;

				$Total = ($TCQ + $TotalTarjetaCredito + $TotalDolaresQuetzalisados + $TotalLempirasQuetzalisados + $TotalDeposito + $TotalCreditos);

				$FaltSob = $Total - $TotalFacturado;

				$Conteo = mysqli_fetch_array(mysqli_query($db, "SELECT a.ACC_USUARIO_CONTABILIZA FROM Bodega.CIERRE_DETALLE a WHERE a.CD_USUARIO = $id_user AND a.ACC_CODIGO = '$Codigo'")); 
				if ($Conteo["ACC_USUARIO_CONTABILIZA"]>0) 
				{
					$Texto = "disabled";
				}
				else
				{
					$Texto = "";
				}
			?>
			<div class="container"> 
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
															<label>Fecha del Corte</label><input type="date" class="form-control" name="FechaInicio" value="<?php echo $Fecha ?>" readonly>
															
														</div>
													</div>
												</div>
											</div>	
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-daterange input-group" id="demo-date-range">
														<div class="input-group-content">
															<label>Facturas Emitidas</label><input type="number" class="form-control" name="FacturasEmitidas" value="<?php echo $FacturasEmitidas ?>" readonly>
															
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-daterange input-group" id="demo-date-range">
														<div class="input-group-content">
															<label>Facturas Anuladas</label><input type="number" class="form-control" name="FacturasAnuladas" value="<?php echo $FacturasAnuladas ?>" readonly>
															
														</div>
													</div>
												</div>
											</div> 			
											<div class="col-lg-12">
											<?php  

											$Cont = mysqli_query($db, "SELECT * FROM Bodega.APERTURA_CIERRE_CAJA a WHERE a.ACC_TIENE_PARCIAL = 1 AND a.ACC_FECHA = '".$_POST["FechaInicio"]."'
											AND a.ACC_TIPO = 20");


											if ($Cont AND $TCQ) 
											{ 
											$Consulta = "SELECT APERTURA_CIERRE_CAJA.*, 
											SUM(CIERRE_DETALLE_PARCIAL.CD_Q_200) AS  CD_Q_200, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_100) AS  CD_Q_100, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_50) AS  CD_Q_50, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_20) AS  CD_Q_20, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_10) AS  CD_Q_10, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_5) AS  CD_Q_5, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_1) AS  CD_Q_1, SUM(CIERRE_DETALLE_PARCIAL.CD_M_1) AS  CD_M_1, SUM(CIERRE_DETALLE_PARCIAL.CD_M_50) AS  CD_M_50, SUM(CIERRE_DETALLE_PARCIAL.CD_M_25) AS  CD_M_25, SUM(CIERRE_DETALLE_PARCIAL.CD_M_10) AS  CD_M_10,  SUM(CIERRE_DETALLE_PARCIAL.CD_M_5) AS  CD_M_5, SUM(CIERRE_DETALLE_PARCIAL.CD_TOTAL_Q) AS  CD_TOTAL_Q, SUM(CIERRE_DETALLE_PARCIAL.CD_D_100) AS  CD_D_100, SUM(CIERRE_DETALLE_PARCIAL.CD_D_50) AS  CD_D_50,  SUM(CIERRE_DETALLE_PARCIAL.CD_D_20) AS  CD_D_20, SUM(CIERRE_DETALLE_PARCIAL.CD_D_10) AS  CD_D_10,  SUM(CIERRE_DETALLE_PARCIAL.CD_D_5) AS  CD_D_5, SUM(CIERRE_DETALLE_PARCIAL.CD_D_1) AS  CD_D_1, SUM(CIERRE_DETALLE_PARCIAL.CD_TOTAL_D) AS  CD_TOTAL_D, SUM(CIERRE_DETALLE_PARCIAL.CD_L_500) AS  CD_L_500,  SUM(CIERRE_DETALLE_PARCIAL.CD_L_100) AS  CD_L_100, SUM(CIERRE_DETALLE_PARCIAL.CD_L_50) AS  CD_L_50, SUM(CIERRE_DETALLE_PARCIAL.CD_L_20) AS  CD_L_20, SUM(CIERRE_DETALLE_PARCIAL.CD_L_10) AS  CD_L_10, SUM(CIERRE_DETALLE_PARCIAL.CD_L_5) AS  CD_L_5, SUM(CIERRE_DETALLE_PARCIAL.CD_TOTAL_L) AS  CD_TOTAL_L,  SUM(CIERRE_DETALLE_PARCIAL.CD_TOTAL_FALTANTE) AS  CD_TOTAL_FALTANTE, SUM(CIERRE_DETALLE_PARCIAL.CD_TOTAL_SOBRANTE) AS  CD_TOTAL_SOBRANTE, 
											CIERRE_DETALLE_PARCIAL.ACCP_HORA
											FROM Bodega.APERTURA_CIERRE_CAJA, Bodega.CIERRE_DETALLE_PARCIAL
											WHERE APERTURA_CIERRE_CAJA.ACC_CODIGO = CIERRE_DETALLE_PARCIAL.ACC_CODIGO
											AND APERTURA_CIERRE_CAJA.ACC_FECHA = '".$_POST["FechaInicio"]."'
											AND APERTURA_CIERRE_CAJA.ACC_TIPO = 20
											GROUP BY CIERRE_DETALLE_PARCIAL.ACC_CODIGO";
											$Resultado = mysqli_query($db, $Consulta);
											while($row = mysqli_fetch_array($Resultado))
											{

											$TCQ2+=$row["CD_TOTAL_Q"];
											$TCD2+=$row["CD_TOTAL_D"];
											$TCL2+=$row["CD_TOTAL_L"];
											}

											$TotalDolaresQuetzalisados2 = $TCD2 * $TasaCambioDolar;
											$TotalLempirasQuetzalisados2 = $TCL2 * $TasaCambioLempira;

											$TotalDolaresQuetzalisados3 = $TotalDolaresQuetzalisados - $TotalDolaresQuetzalisados2;
											$TotalLempirasQuetzalisados3 = $TotalLempirasQuetzalisados - $TotalLempirasQuetzalisados2;
											$TCQ3=$TCQ-$TCQ2;



											}
											?> 	
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
														<tr>
															<td align="center" colspan="4"><h2><b>MONTOS A RETIRAR</b></h2></td>
															
														</tr>
														<tr>
															<td><h5><b>QUETZALES</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TCQ3, 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>DOLARES</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalDolaresQuetzalisados3, 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>LEMPIRAS</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalLempirasQuetzalisados3, 2, '.', ','); ?></h5></td>
														</tr> 
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div><!--end .panel -->

							
							<!--Cuadre Parcial -->
							<?php

							$Consulta = "SELECT APERTURA_CIERRE_CAJA.*, 
							SUM(CIERRE_DETALLE_PARCIAL.CD_Q_200) AS  CD_Q_200, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_100) AS  CD_Q_100, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_50) AS  CD_Q_50, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_20) AS  CD_Q_20, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_10) AS  CD_Q_10, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_5) AS  CD_Q_5, SUM(CIERRE_DETALLE_PARCIAL.CD_Q_1) AS  CD_Q_1, SUM(CIERRE_DETALLE_PARCIAL.CD_M_1) AS  CD_M_1, SUM(CIERRE_DETALLE_PARCIAL.CD_M_50) AS  CD_M_50, SUM(CIERRE_DETALLE_PARCIAL.CD_M_25) AS  CD_M_25, SUM(CIERRE_DETALLE_PARCIAL.CD_M_10) AS  CD_M_10,  SUM(CIERRE_DETALLE_PARCIAL.CD_M_5) AS  CD_M_5, SUM(CIERRE_DETALLE_PARCIAL.CD_TOTAL_Q) AS  CD_TOTAL_Q, SUM(CIERRE_DETALLE_PARCIAL.CD_D_100) AS  CD_D_100, SUM(CIERRE_DETALLE_PARCIAL.CD_D_50) AS  CD_D_50,  SUM(CIERRE_DETALLE_PARCIAL.CD_D_20) AS  CD_D_20, SUM(CIERRE_DETALLE_PARCIAL.CD_D_10) AS  CD_D_10,  SUM(CIERRE_DETALLE_PARCIAL.CD_D_5) AS  CD_D_5, SUM(CIERRE_DETALLE_PARCIAL.CD_D_1) AS  CD_D_1, SUM(CIERRE_DETALLE_PARCIAL.CD_TOTAL_D) AS  CD_TOTAL_D, SUM(CIERRE_DETALLE_PARCIAL.CD_L_500) AS  CD_L_500,  SUM(CIERRE_DETALLE_PARCIAL.CD_L_100) AS  CD_L_100, SUM(CIERRE_DETALLE_PARCIAL.CD_L_50) AS  CD_L_50, SUM(CIERRE_DETALLE_PARCIAL.CD_L_20) AS  CD_L_20, SUM(CIERRE_DETALLE_PARCIAL.CD_L_10) AS  CD_L_10, SUM(CIERRE_DETALLE_PARCIAL.CD_L_5) AS  CD_L_5, SUM(CIERRE_DETALLE_PARCIAL.CD_TOTAL_L) AS  CD_TOTAL_L,  SUM(CIERRE_DETALLE_PARCIAL.CD_TOTAL_FALTANTE) AS  CD_TOTAL_FALTANTE, SUM(CIERRE_DETALLE_PARCIAL.CD_TOTAL_SOBRANTE) AS  CD_TOTAL_SOBRANTE, 
							CIERRE_DETALLE_PARCIAL.ACCP_HORA
								 FROM Bodega.APERTURA_CIERRE_CAJA, Bodega.CIERRE_DETALLE_PARCIAL
								WHERE APERTURA_CIERRE_CAJA.ACC_CODIGO = CIERRE_DETALLE_PARCIAL.ACC_CODIGO
								AND APERTURA_CIERRE_CAJA.ACC_FECHA = '".$_POST["FechaInicio"]."'
								AND APERTURA_CIERRE_CAJA.ACC_TIPO = 20
								GROUP BY CIERRE_DETALLE_PARCIAL.ACC_CODIGO";
							$Resultado = mysqli_query($db, $Consulta);
							while($row = mysqli_fetch_array($Resultado))
							{
								$TotalParcial+=$row["ACCP_TOTAL"];
								$TCQ1+=$row["CD_TOTAL_Q"];
								$TCD1+=$row["CD_TOTAL_D"];
								$TCL1+=$row["CD_TOTAL_L"];
								$HoraParcial=$row["ACCP_HORA"];
								$Fecha1=$row["ACC_FECHA"];
							}

							$Query6P = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITOS FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '$Fecha1' AND F_HORA <='$HoraParcial' AND F_TIPO = 3";
							$Result6P = mysqli_query($db,$Query6P);
							while($row6P = mysqli_fetch_array($Result6P))
							{
								$TotalCreditos1 = $row6P["TOTAL_CREDITOS"];
							}

							$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '$Fecha1' AND F_HORA <='$HoraParcial'";
							$Result11p = mysqli_query($db,$Query11p);
							while($rowp = mysqli_fetch_array($Result11p))
							{
								$TotalFacturado1 = $rowp["TOTAL_FACTURADO"];
							}

							$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '$Fecha1' AND F_HORA <='$HoraParcial'";
							$Resultp = mysqli_query($db,$Queryp);
							while($rowp = mysqli_fetch_array($Resultp))
							{
								$FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
							}

							$Query3p = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITO FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '$Fecha1' AND F_HORA <='$HoraParcial' AND F_TIPO = 2";
							$Result3p = mysqli_query($db,$Query3p);
							while($row3p = mysqli_fetch_array($Result3p))
							{
								$TotalTarjetaCredito1 = $row3p["TOTAL_CREDITO"];
							}

							$Query5P = "SELECT SUM(F_TOTAL) AS TOTAL_DEPOSITOS1 FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS = '$Fecha1' AND F_HORA <='$HoraParcial' AND F_TIPO = 4";
							$Result5P = mysqli_query($db,$Query5P);
							while($row5P = mysqli_fetch_array($Result5P))
							{
								$TotalDeposito1 = $row5P["TOTAL_DEPOSITOS1"];
							}
							

							$TotalDolaresQuetzalisados1 = $TCD1 * $TasaCambioDolar;
							$TotalLempirasQuetzalisados1 = $TCL1 * $TasaCambioLempira;
							$Total1 = ($TCQ1 + $TotalTarjetaCredito1 + $TotalDolaresQuetzalisados1 + $TotalLempirasQuetzalisados1 + $TotalDeposito1 + $TotalCreditos1);

							$FaltSob1 = $Total1 - $TotalFacturado1;

							?>
							<div class="card panel">
								<div class="card-head style-secondary collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-5" aria-expanded="false">
									<header>Cuadre Caja Parcial</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-5" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-daterange input-group" id="demo-date-range">
														<div class="input-group-content">
														<label>Fecha del Corte</label>
															<input type="date" class="form-control" name="FechaInicio" value="<?php echo $Fecha1 ?>" readonly>
															
														</div>
													</div>
												</div>
											</div>	
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-daterange input-group" id="demo-date-range">
														<div class="input-group-content">
														<label>Facturas Emitidas</label>
															<input type="number" class="form-control" name="FacturasEmitidas" value="<?php echo $FacturasEmitidas1 ?>" readonly>
															
														</div>
													</div>
												</div>
											</div>
												 		
											<div class="col-lg-12">
												<table class="table table-hover table-condensed">
													<tbody>
														
														<tr>
															<td><h5><b>Efectivo</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TCQ1, 2, '.', ','); ?></h5></td> 
														
														</tr>
														<tr>
															<td><h5><b>Crédito</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalCreditos1, 2, '.', ','); ?></h5></td> 
															
														</tr>
														<tr>
															<td><h5><b>Tarjeta Crédito</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalTarjetaCredito1, 2, '.', ','); ?></h5></td> 
															
														</tr>
														<tr>
															<td><h5><b>Dólar</b></h5></td>
															<td align="right"><h5><?php echo '$. '.number_format($TCD1, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalDolaresQuetzalisados1, 2, '.', ','); ?></h5></td> 
														
														</tr>
														<tr>
															<td><h5><b>Lempira</b></h5></td>
															<td align="right"><h5><?php echo 'L. '.number_format($TCL1, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalLempirasQuetzalisados1, 2, '.', ','); ?></h5></td> 
															
														</tr>
														<tr>
															<td><h5><b>Depósitos</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalDeposito1, 2, '.', ','); ?></h5></td> 
															
														</tr>
														<tr>
															<td align="center"><h2><b>Total Ingresos</b></h2></td>
															<td colspan="4" align="right"><h2><?php echo 'Q. '.number_format($Total1, 2, '.', ','); ?></h2></td>
														</tr>
														<tr>
															<td align="center"><h4><b>Total Facturado</b></h4></td>
															<td colspan="4" align="right"><h4><?php echo 'Q. '.number_format($TotalFacturado1, 2, '.', ','); ?></h4></td>
														</tr>
														
														
														<tr>
															<td><h5><b>Faltante</b></h5></td>
															<td colspan="4" align="right"><h5><?php if($FaltSob1 < 0){echo 'Q. '.number_format($FaltSob1, 2, '.', ',');}elseif($FaltSob1 == 0){echo 'Q. '.number_format(0, 2, '.', ',');}else{echo 'Q. '.number_format(0, 2, '.', ',');} ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Sobrante</b></h5></td>
															<td colspan="4" align="right"><h5><?php if($FaltSob1 > 0){echo 'Q. '.number_format($FaltSob1, 2, '.', ',');}elseif($FaltSob1 == 0){echo 'Q. '.number_format(0, 2, '.', ',');}else{echo 'Q. '.number_format(0, 2, '.', ',');} ?></h5></td>
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
														<form id="FormData" role="form" class="form">
														<input type="hidden" value="<?php echo $Codigo?>" id="CodigoCierre" name="CodigoCierre">
														<input type="hidden" id="UsuarioContabiliza" name="UsuarioContabiliza">
														<div class="row">
														<div class="col-xs-6"> 									
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesQ200 ?>" disabled/>
																	<label for="BQ200">Billetes de Q. 200</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"  value="<?php echo $BilletesQ100 ?>" disabled/>
																	<label for="BQ100">Billetes de Q. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"    value="<?php echo $BilletesQ50 ?>" disabled/>
																	<label for="BQ50">Billetes de Q. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   min="0"  value="<?php echo $BilletesQ20 ?>" disabled/>
																	<label for="BQ20">Billetes de Q. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesQ10 ?>" disabled/>
																	<label for="BQ10">Billetes de Q. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"    value="<?php echo $BilletesQ5 ?>" disabled/>
																	<label for="BQ5">Billetes de Q. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesQ1 ?>" disabled/>
																	<label for="BQ1">Billetes de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesM1 ?>" disabled/>
																	<label for="MQ1">Monedas de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"  value="<?php echo $BilletesM50 ?>" disabled/>
																	<label for="MQ50">Monedas de C. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesM25 ?>" disabled/>
																	<label for="MQ25">Monedas de C. 25</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesM10 ?>" disabled/>
																	<label for="MQ10">Monedas de C. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"  value="<?php echo $BilletesM_5 ?>" disabled/>
																	<label for="MQ5">Monedas de C. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-6">
																	<input class="form-control" type="number" step="any"  value="<?php echo $TCQ ?>" disabled/>
																	<label for="TCQ">Total de Cuadre en Quetzales</label>
																</div>
															</div>
															</div>
															<div class="col-xs-6">
																	<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ200" id="BQ200" min="0" required value="<?php echo $BilletesQ200 ?>" onchange="CalcularTotalQ()"/>
																	<label for="BQ200">Billetes de Q. 200</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ100" id="BQ100" min="0" required value="<?php echo $BilletesQ100 ?>" onchange="CalcularTotalQ()"/>
																	<label for="BQ100">Billetes de Q. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ50" id="BQ50" min="0" required value="<?php echo $BilletesQ50 ?>" onchange="CalcularTotalQ()"/>
																	<label for="BQ50">Billetes de Q. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ20" id="BQ20" min="0" required value="<?php echo $BilletesQ20 ?>" onchange="CalcularTotalQ()"/>
																	<label for="BQ20">Billetes de Q. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ10" id="BQ10" min="0" required value="<?php echo $BilletesQ10 ?>" onchange="CalcularTotalQ()"/>
																	<label for="BQ10">Billetes de Q. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ5" id="BQ5" min="0" required value="<?php echo $BilletesQ5 ?>" onchange="CalcularTotalQ()"/>
																	<label for="BQ5">Billetes de Q. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ1" id="BQ1" min="0" required value="<?php echo $BilletesQ1 ?>" onchange="CalcularTotalQ()"/>
																	<label for="BQ1">Billetes de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ1" id="MQ1" min="0" required value="<?php echo $BilletesM1 ?>" onchange="CalcularTotalQ()"/>
																	<label for="MQ1">Monedas de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ50" id="MQ50" min="0" required value="<?php echo $BilletesM50 ?>" onchange="CalcularTotalQ()"/>
																	<label for="MQ50">Monedas de C. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ25" id="MQ25" min="0" required value="<?php echo $BilletesM25 ?>" onchange="CalcularTotalQ()"/>
																	<label for="MQ25">Monedas de C. 25</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ10" id="MQ10" min="0" required value="<?php echo $BilletesM10 ?>" onchange="CalcularTotalQ()"/>
																	<label for="MQ10">Monedas de C. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ5" id="MQ5" min="0" required value="<?php echo $BilletesM_5 ?>" onchange="CalcularTotalQ()"/>
																	<label for="MQ5">Monedas de C. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-6">
																	<input class="form-control" type="number" step="any" name="TCQ" id="TCQ" min="0" required value="<?php echo $TCQ ?>" readonly/>
																	<label for="TCQ">Total de Cuadre en Quetzales</label>
																</div>
															</div>
															</div>
														</div>
													</div>
														<div class="tab-pane" id="second5">
															<h3 class="text-light"><strong>Cuadre de Efectivo ($)</strong></h3>
														<div class="row">
														<div class="col-xs-6"> 		
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"  value="<?php echo $BD100 ?>" min="0" required readonly/>
																	<label for="BD100">Billetes de $. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"  value="<?php echo $BD50 ?>" min="0" required readonly/>
																	<label for="BD50">Billetes de $. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" value="<?php echo $BD20 ?>" min="0" required readonly/>
																	<label for="BD20">Billetes de $. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" value="<?php echo $BD10 ?>" min="0" required readonly/>
																	<label for="BD10">Billetes de $. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" value="<?php echo $BD5 ?>" min="0" required readonly/>
																	<label for="BD5">Billetes de $. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"  value="<?php echo $BD1 ?>" min="0" required readonly/>
																	<label for="BD1">Billetes de $. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-6">
																	<input class="form-control" type="number" value="<?php echo $TCD ?>" min="0" required readonly />
																	<label for="TCD">Total de Cuadre en Dólares</label>
																</div>
															</div>
														</div> 
														<div class="col-xs-6"> 		
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control"   onchange="CalcularTotalD()" type="number" name="BD100" id="BD100" value="<?php echo $BD100 ?>" min="0" required />
																	<label for="BD100">Billetes de $. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control"   onchange="CalcularTotalD()" type="number" name="BD50" id="BD50" value="<?php echo $BD50 ?>" min="0" required />
																	<label for="BD50">Billetes de $. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control"   onchange="CalcularTotalD()" type="number" name="BD20" id="BD20" value="<?php echo $BD20 ?>" min="0" required />
																	<label for="BD20">Billetes de $. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control"   onchange="CalcularTotalD()" type="number" name="BD10" id="BD10" value="<?php echo $BD10 ?>" min="0" required />
																	<label for="BD10">Billetes de $. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control"   onchange="CalcularTotalD()" type="number" name="BD5" id="BD5" value="<?php echo $BD5 ?>" min="0" required />
																	<label for="BD5">Billetes de $. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control"   onchange="CalcularTotalD()" type="number" name="BD1" id="BD1" value="<?php echo $BD1 ?>" min="0" required />
																	<label for="BD1">Billetes de $. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-6">
																	<input class="form-control" type="number" name="TCD" id="TCD" value="<?php echo $TCD ?>" min="0" required  readonly/>
																	<label for="TCD">Total de Cuadre en Dólares</label>
																</div>
															</div>
														</div>		
														</div>
														</div>
														<div class="tab-pane" id="third5">
															<h3 class="text-light"><strong>Cuadre de Efectivo (L)</strong></h3>
															<div class="row">
															<div class="col-xs-6"> 		
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" value="<?php echo $BL500 ?>" min="0" readonly />
																	<label for="BL500">Billetes de L. 500</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" value="<?php echo $BL100 ?>" min="0" readonly />
																	<label for="BL100">Billetes de L. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" value="<?php echo $BL50 ?>" min="0" readonly />
																	<label for="BL50">Billetes de L. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" value="<?php echo $BL20 ?>" min="0" readonly />
																	<label for="BL20">Billetes de L. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" value="<?php echo $BL10 ?>" min="0" readonly />
																	<label for="BL10">Billetes de L. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" value="<?php echo $BL5 ?>" min="0" readonly />
																	<label for="BL5">Billetes de L. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" value="<?php echo $TCL ?>" min="0" required readonly />
																	<label for="TCL">Total de Cuadre en Lempiras</label>
																</div>
															</div> 								
															</div>
															<div class="col-xs-6">
																<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" onchange="CalcularTotalL()"  type="number" name="BL500" id="BL500" value="<?php echo $BL500 ?>" min="0"  />
																	<label for="BL500">Billetes de L. 500</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" onchange="CalcularTotalL()"  type="number" name="BL100" id="BL100" value="<?php echo $BL100 ?>" min="0"  />
																	<label for="BL100">Billetes de L. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" onchange="CalcularTotalL()"  type="number" name="BL50" id="BL50" value="<?php echo $BL50 ?>" min="0"  />
																	<label for="BL50">Billetes de L. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" onchange="CalcularTotalL()"  type="number" name="BL20" id="BL20" value="<?php echo $BL20 ?>" min="0"  />
																	<label for="BL20">Billetes de L. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" onchange="CalcularTotalL()"  type="number" name="BL10" id="BL10" value="<?php echo $BL10 ?>" min="0"  />
																	<label for="BL10">Billetes de L. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" onchange="CalcularTotalL()"  type="number" name="BL5" id="BL5" value="<?php echo $BL5 ?>" min="0"  />
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
															</div>
														</div>
														<div class="row">
														<div class="col-lg-10" align="center">
															<div class="form-group">
																 <button <?php echo $Texto ?> data-toggle="modal" data-target="#ModalFacturas2" type="button" class="btn waves-effect waves-light btn-success">Editar</button>
															</div>
														</div> 
														</form>
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
													$SqlFacturas = "SELECT FACTURA_2.* FROM Bodega.FACTURA_2
																	WHERE FACTURA_2.F_FECHA_TRANS = '".$_POST["FechaInicio"]."' $FiltroUser
																	ORDER BY FACTURA_2.F_SERIE, FACTURA_2.F_NUMERO";
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
									<header>Validación</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-4" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="col-lg-12" align="center">
											<h3>NOTA:</h3><h3 class="text-center text-danger">Eliminar facturas sin CAE antes de validar!</h3>
											<div class="form-group">
												   <button <?php echo $Texto ?> type="button" class="btn ink-reaction btn-raised btn-warning" id="btnGuardarPartida" data-toggle="modal" data-target="#ModalFacturas">Validar</button> 
											</div>
										</div> 
									</div>
								</div> 
							</div><!--end .panel -->
						</div>
					</div> 
			</div>
		</div>
		<!-- END CONTENT -->

		<form method="POST" target="_blank" action="CierreImp.php" name="FormCorte">
			<input type="hidden" value="<?php echo $Codigo?>" id="CodigoApertura" name="CodigoApertura">
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

<div class="modal fade" tabindex="-1" role="dialog" id="ModalFacturas2" >
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Credenciales de inicio de sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
	      	 <div class="form-group">
	          <div class="col-xs-6">
	            <input required="" class="form-control" type="text" required="" placeholder="Usuario" name="username" id="username">
	          </div>
		      </div> 
		</div>
		<div class="row">
	        <div class="form-group ">
	          <div class="col-xs-6">
	            <input required="" class="form-control" type="password" required="" placeholder="Contraseña" id="password" name="password" required>
	          </div>
	        </div> 
      	</div> 
      </div> 
      <div id="mensaje" style="display: none" align="center">
      		<h3>Cargando...</h3>
      		<img src="loading.gif" alt="" width="300" height="100">      	
      </div>
      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary" onclick="EditarCuadre()">Validar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="ModalFacturas" >
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Credenciales de inicio de sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
	      	 <div class="form-group">
	          <div class="col-xs-6">
	            <input required="" class="form-control" type="text" required="" placeholder="Usuario" name="usernameV" id="usernameV">
	          </div>
		      </div> 
		</div>
		<div class="row">
	        <div class="form-group ">
	          <div class="col-xs-6">
	            <input required="" class="form-control" type="password" required="" placeholder="Contraseña" id="passwordV" name="passwordV" required>
	          </div>
	        </div> 
      	</div> 
      </div> 
      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary" onclick="ValidarCredenciales()">Validar</button>
      </div>
    </div>
  </div>
</div>
<script>
	function CalcularTotalQ()
	{
		var B200 = $('#BQ200').val();
		var B100 = $('#BQ100').val();
		var B50  = $('#BQ50').val();
		var B20  = $('#BQ20').val();
		var B10  = $('#BQ10').val();
		var B5   = $('#BQ5').val();
		var B1   = $('#BQ1').val();
		var M1   = $('#MQ1').val();
		var M50  = $('#MQ50').val();
		var M25  = $('#MQ25').val();
		var M10  = $('#MQ10').val();
		var M5   = $('#MQ5').val();

		var CantidadEntera = parseFloat(B200 * 200) + parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5) + parseFloat(B1 * 1);
		var CantidadMoneda = parseFloat(M1 * 1) + parseFloat(M50 * 0.50) + parseFloat(M25 * 0.25) + parseFloat(M10 * 0.10) + parseFloat(M5 * 0.05);

		var Total = CantidadEntera + CantidadMoneda;
		Total = Total.toFixed(2);

		$('#TCQ').val(Total);
	}
	function CalcularTotalD()
	{
		var B100 = $('#BD100').val();
		var B50  = $('#BD50').val();
		var B20  = $('#BD20').val();
		var B10  = $('#BD10').val();
		var B5   = $('#BD5').val();
		var B1   = $('#BD1').val();

		var CantidadEntera = parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5) + parseFloat(B1 * 1);
		
		var Total = CantidadEntera;
		Total = Total.toFixed(2);

		$('#TCD').val(Total);
	}
	function CalcularTotalL()
	{
		var B500 = $('#BL500').val();
		var B100 = $('#BL100').val();
		var B50  = $('#BL50').val();
		var B20  = $('#BL20').val();
		var B10  = $('#BL10').val();
		var B5   = $('#BL5').val();
		
		var CantidadEntera = parseFloat(B500 * 500) + parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5);
		
		var Total = CantidadEntera;
		Total = Total.toFixed(2);

		$('#TCL').val(Total);
	} 

		function EditarCuadre()
		{
			var Usuario = $("#username").val();
			var Password = $("#password").val();
			$.ajax({
				url: 'Ajax/ComprobarUsuario.php',
				type: 'POST',
				dataType: 'html',
				data: {Usuario:Usuario, Password:Password},
				success:function(data)
				{
					if (data==3) 
					{
						alertify.error("No tiene permisos...");
					}
					else if (data==2) 
					{
						alertify.error("Usuario o contraseña incorrecta..");
					}
					else 
					{  
					$("#UsuarioContabiliza").val(data);
					var Form = $("#FormData").serialize();
					$.ajax({
						url: 'CCModPro.php',
						type: 'POST',
						dataType: 'html',
						data: Form,
						beforeSend: function() {
					        // setting a timeout
					       $("#mensaje").show();
					    },
						success:function(data)
						{
							if(data==1)
							{
								location.reload();
								
							}
							else
							{
								alertify.error("Ha ocurrido un error.");
							}
						}
					})
				} 
			}
		})
	}

		function ValidarCredenciales()
		{
			var Codigo = $("#CodigoCierre").val();
			var Usuario = $("#usernameV").val();
			var Password = $("#passwordV").val();
			$.ajax({
				url: 'Ajax/ComprobarUsuario.php',
				type: 'POST',
				dataType: 'html',
				data: {Usuario:Usuario, Password:Password},
				success:function(data)
				{
					if (data==3) 
					{
						alertify.error("No tiene permisos...");
					}
					else if (data==2) 
					{
						alertify.error("Usuario o contraseña incorrecta..");
					}
					else 
					{
						var User = data;
						$.ajax({
							url: 'Ajax/GuardarValidacion.php',
							type: 'POST',
							dataType: 'html',
							data: {User:User, Codigo:Codigo},
							success:function(data)
							{
								if (data==1) 
								{
									ImprimirCorte();
									$("#ModalFacturas").modal("hide");
									location.reload();
								}
								else
								{
									alertify.error("Error en la verificación.")
								}
							} 
						}) 						
					}
				}
			}) 
			
		}
	</script>
	</body>
	</html>
