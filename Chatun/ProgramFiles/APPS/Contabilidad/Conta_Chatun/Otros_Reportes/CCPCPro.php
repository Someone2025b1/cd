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
				$Fecha = $_POST["FechaInicio"];
				$queryTasaCambioLempira = "SELECT TC_TASA FROM Contabilidad.TASA_CAMBIO WHERE TC_CODIGO = 1";
				$resultTasaCambioLempira = mysqli_query($db, $queryTasaCambioLempira);
				while($FilaTCL = mysqli_fetch_array($resultTasaCambioLempira))
				{
					$TasaCambioLempira = $FilaTCL["TC_TASA"];
				}

				$queryTasaCambioDolar = "SELECT TC_TASA FROM Contabilidad.TASA_CAMBIO WHERE TC_CODIGO = 2";
				$resultTasaCambioDolar = mysqli_query($db, $queryTasaCambioDolar);
				while($FilaTCL = mysqli_fetch_array($resultTasaCambioDolar))
				{
					$TasaCambioDolar = $FilaTCL["TC_TASA"];
				}

				 
				$QueryMinMaxFacturas = "SELECT MAX(F_NUMERO) AS MAXIMO, MIN(F_NUMERO) AS MINIMO, F_SERIE FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."'";
				$ResultMinMaxFacturas = mysqli_query($db, $QueryMinMaxFacturas);
				while($FilaMinMaxFacturas = mysqli_fetch_array($ResultMinMaxFacturas))
				{
					$DelFactura = $FilaMinMaxFacturas["MINIMO"];
					$AlFactura = $FilaMinMaxFacturas["MAXIMO"];
					$SerieFactura = $FilaMinMaxFacturas["F_SERIE"];
				}

				$Query = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."'";
				$Result = mysqli_query($db, $Query);
				while($row = mysqli_fetch_array($Result))
				{
					$FacturasEmitidas = $row["FACTURAS_EMITIDAS"];
				}

				$Query1 = "SELECT COUNT(F_CODIGO) AS FACTURAS_ANULADAS FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."' AND F_ESTADO = 2";
				$Result1 = mysqli_query($db, $Query1);
				while($row1 = mysqli_fetch_array($Result1))
				{
					$FacturasAnuladas = $row1["FACTURAS_ANULADAS"];
				}


				$Query3 = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITO FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."' AND F_TIPO = 2 AND F_ESTADO = 1";
				$Result3 = mysqli_query($db, $Query3);
				while($row3 = mysqli_fetch_array($Result3))
				{
					$TotalTarjetaCredito = $row3["TOTAL_CREDITO"];
				}

				$Query4 = "SELECT SUM(F_TOTAL) AS TOTAL_DOLARES FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."' AND F_TIPO = 1 AND F_MONEDA = 2 AND F_ESTADO = 1";
				$Result4 = mysqli_query($db, $Query4);
				while($row4 = mysqli_fetch_array($Result4))
				{
					$TotalDolares = $row4["TOTAL_DOLARES"];
				}

				$TotalDolaresQuetzalisados = $TCD * $TasaCambioDolar;

				$Query4 = "SELECT SUM(F_TOTAL) AS TOTAL_LEMPIRAS FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."' AND F_TIPO = 1 AND F_MONEDA = 3 AND F_ESTADO = 1";
				$Result4 = mysqli_query($db, $Query4);
				while($row4 = mysqli_fetch_array($Result4))
				{
					$TotalLempiras = $row4["TOTAL_LEMPIRAS"];
				}

				$TotalLempirasQuetzalisados = $TCL * $TasaCambioLempira;

				$Query5 = "SELECT SUM(F_TOTAL) AS TOTAL_DEPOSITOS FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."' AND F_TIPO = 4 AND F_ESTADO = 1";
				$Result5 = mysqli_query($db, $Query5);
				while($row5 = mysqli_fetch_array($Result5))
				{
					$TotalDeposito = $row5["TOTAL_DEPOSITOS"];
				}	

				$Query6 = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITOS FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."' AND F_TIPO = 3 AND F_ESTADO = 1";
				$Result6 = mysqli_query($db, $Query6);
				while($row6 = mysqli_fetch_array($Result6))
				{
					$TotalCreditos = $row6["TOTAL_CREDITOS"];
				}		

				$Query7 = "SELECT SUM(F_TOTAL) AS TOTAL_EFECTIVO FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."' AND F_MONEDA = 1 AND F_ESTADO = 1";
				$Result7 = mysqli_query($db, $Query7);
				while($row = mysqli_fetch_array($Result7))
				{
					$TotalEfectivo = $row["TOTAL_EFECTIVO"];
				}	
 
				$Query9 = "SELECT SUM(F_CAMBIO) AS TOTAL_CAMBIO_LEMPIRA FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."' AND F_MONEDA = 3 AND F_ESTADO = 1";
				$Result9 = mysqli_query($db, $Query9);
				while($row = mysqli_fetch_array($Result9))
				{
					$CambioLempiras = $row["TOTAL_CAMBIO_LEMPIRA"];
				}

				$Query10 = "SELECT SUM(F_CAMBIO) AS TOTAL_CAMBIO_DOLARES FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."' AND F_MONEDA = 2 AND F_ESTADO = 1";
				$Result10 = mysqli_query($db, $Query10);
				while($row = mysqli_fetch_array($Result10))
				{
					$CambioDolares = $row["TOTAL_CAMBIO_DOLARES"];
				}

				$Query11 = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_PS WHERE F_ESTADO = 1 AND F_FECHA_TRANS = '".$Fecha."'";
				$Result11 = mysqli_query($db, $Query11);
				while($row = mysqli_fetch_array($Result11))
				{
					$TotalFacturado = $row["TOTAL_FACTURADO"];
				}

				$QueryNotaEfectivo = mysqli_query($db, "SELECT A.TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_TIPO = 1");
				$RegistrosNotaEfectivo = mysqli_num_rows($QueryNotaEfectivo);

				if($RegistrosNotaEfectivo > 1)
				{
					$QueryNotaEfectivo = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_TIPO = 1");
				}

				$FilaNotaEfectivo = mysqli_fetch_array($QueryNotaEfectivo);

				$QueryNotaCredito = mysqli_query($db, "SELECT A.TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_TIPO = 2");
				$RegistrosNotaCredito = mysqli_num_rows($QueryNotaCredito);

				if($RegistrosNotaCredito > 1)
				{
					$QueryNotaCredito = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_TIPO = 2");
				}

				$FilaNotaCredito = mysqli_fetch_array($QueryNotaCredito);

				$QueryNotaTarjetaCredito = mysqli_query($db, "SELECT A.TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_TIPO = 3");
				$RegistrosTarjetaCredito = mysqli_num_rows($QueryNotaTarjetaCredito);

				if($RegistrosTarjetaCredito > 1)
				{
					$QueryNotaTarjetaCredito = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL)
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_TIPO = 3");
				}

				$FilaNotaTarjetaCredito = mysqli_fetch_array($QueryNotaTarjetaCredito);

				$QueryNotaDepositos = mysqli_query($db, "SELECT A.TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_TIPO = 4");
				$RegistrosNotaDepositos = mysqli_num_rows($QueryNotaDepositos);

				if($RegistrosNotaDepositos > 1)
				{
					$QueryNotaDepositos = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_TIPO = 4");
				}


				$FilaNotaDepositos = mysqli_fetch_array($QueryNotaDepositos);

				$QueryNotaDolares = mysqli_query($db, "SELECT A.TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_MONEDA = 2");
				$RegistrosNotaDolares = mysqli_num_rows($QueryNotaDolares);

				if($RegistrosNotaDolares > 1)
				{
					$QueryNotaDolares = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_MONEDA = 2");
				}


				$FilaNotaDolares = mysqli_fetch_array($QueryNotaDolares);

				$QueryNotaLempiras = mysqli_query($db, "SELECT A.TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_MONEDA = 3");
				$RegistrosNotaLempiras = mysqli_num_rows($QueryNotaLempiras);

				if($RegistrosNotaDolares > 1)
				{
					$QueryNotaLempiras = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
													FROM Contabilidad.TRANSACCION AS A
													INNER JOIN Bodega.FACTURA_PS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
													WHERE A.TT_CODIGO = 23
													AND A.TRA_FECHA_TRANS = '".$Fecha."'
													AND B.F_MONEDA = 3");
				}


				$FilaNotaLempiras = mysqli_fetch_array($QueryNotaLempiras);

				$TotalNotasEmitidas = $RegistrosNotaEfectivo + $RegistrosNotaCredito + $RegistrosTarjetaCredito + $RegistrosNotaDepositos + $RegistrosNotaDolares + $RegistrosNotaLempiras;

				 

				$TotalEfectivo = $TotalEfectivo - $CambioLempiras - $CambioDolares;
				$TCQ = $TotalEfectivo;
				$Total = ($TCQ + $TotalTarjetaCredito + $TotalDolaresQuetzalisados + $TotalLempirasQuetzalisados + $TotalDeposito + $TotalCreditos - ($FilaNotaEfectivo[TRA_TOTAL] + $FilaNotaCredito[TRA_TOTAL] + $FilaNotaTarjetaCredito[TRA_TOTAL] + $FilaNotaDepositos[TRA_TOTAL] + $FilaNotaDolares[TRA_TOTAL] + $FilaNotaLempiras[TRA_TOTAL]));

				$FaltSob = ($TCQ + $TotalCreditos + $TotalTarjetaCredito + $TotalDolaresQuetzalisados + $TotalLempirasQuetzalisados + $TotalDeposito) - ($TotalFacturado - ($FilaNotaEfectivo[TRA_TOTAL] + $FilaNotaCredito[TRA_TOTAL] + $FilaNotaTarjetaCredito[TRA_TOTAL] + $FilaNotaDepositos[TRA_TOTAL] + $FilaNotaDolares[TRA_TOTAL] + $FilaNotaLempiras[TRA_TOTAL]));

				$QueryDocumentosEmitidos = mysqli_query($db, "SELECT F_CODIGO FROM Bodega.FACTURA_PS WHERE F_FECHA_TRANS = '".$Fecha."'");
				$TotalDocumentosEmitidos = mysqli_num_rows($QueryDocumentosEmitidos);

				$QueryFacturas = mysqli_query($db, "SELECT MIN(A.F_DTE) AS MINIMO, MAX(A.F_DTE) AS MAXIMO
												FROM Bodega.FACTURA_PS AS A
												WHERE A.F_FECHA_TRANS = '".$Fecha."'");
				$FilaFactura = mysqli_fetch_array($QueryFacturas);

				$FacturaMinima = $FilaFactura["MINIMO"];
				$FacturaMaxima = $FilaFactura["MAXIMO"];
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
															<input type="number" class="form-control" name="FacturasAnuladas" value="<?php echo $TotalNotasEmitidas ?>" readonly>
															<label>Notas Crédito Emitidas</label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-10">
												<div class="form-group">
													<div class="input-daterange input-group" id="demo-date-range">
														<div class="input-group-content">
															<input type="text" class="form-control" style="width: 700px" name="FacturasAnuladas" value="<?php echo 'De la '.$FacturaMinima.' a la '.$FacturaMaxima ?>" readonly>
															<label>Facturas</label>
														</div>
													</div>
												</div>
											</div>	
										</div>
										<div class="row">
											<div class="col-lg-12">
												<table class="table table-hover table-condensed">
													<tbody>
														<tr>
															<td colspan="3" align="right">Datos Preliminares</td>
															<td align="right">Nota Crédito</td>
															<td align="right">Total</td>
														</tr>
														<tr>
															<td><h5><b>Efectivo</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TCQ, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($FilaNotaEfectivo[TRA_TOTAL], 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TCQ - $FilaNotaEfectivo[TRA_TOTAL], 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Crédito</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalCreditos, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($FilaNotaCredito[TRA_TOTAL], 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalCreditos - $FilaNotaCredito[TRA_TOTAL], 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Tarjeta Crédito</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalTarjetaCredito, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($FilaNotaTarjetaCredito[TRA_TOTAL], 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalTarjetaCredito - $FilaNotaTarjetaCredito[TRA_TOTAL], 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Dólar</b></h5></td>
															<td align="right"><h5><?php echo '$. '.number_format($TCD, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalDolaresQuetzalisados, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($FilaNotaDolares[TRA_TOTAL], 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalDolaresQuetzalisados - $FilaNotaDolares[TRA_TOTAL], 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Lempira</b></h5></td>
															<td align="right"><h5><?php echo 'L. '.number_format($TCL, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalLempirasQuetzalisados, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($FilaNotaLempiras[TRA_TOTAL], 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalLempirasQuetzalisados - $FilaNotaLempiras[TRA_TOTAL], 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Depósitos</b></h5></td>
															<td colspan="2" align="right"><h5><?php echo 'Q. '.number_format($TotalDeposito, 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($FilaNotaDepositos[TRA_TOTAL], 2, '.', ','); ?></h5></td>
															<td align="right"><h5><?php echo 'Q. '.number_format($TotalDeposito - $FilaNotaDepositos[TRA_TOTAL], 2, '.', ','); ?></h5></td>
														</tr>
														<tr>
															<td align="center"><h2><b>Total Ingresos</b></h2></td>
															<td colspan="4" align="right"><h2><?php echo 'Q. '.number_format($Total, 2, '.', ','); ?></h2></td>
														</tr>
														<tr>
															<td align="center"><h4><b>Total Facturado</b></h4></td>
															<td colspan="4" align="right"><h4><?php echo 'Q. '.number_format($TotalFacturado, 2, '.', ','); ?></h4></td>
														</tr>
														<tr>
															<td align="center"><h4><b>Total Notas de Crédito</b></h4></td>
															<td colspan="4" align="right"><h4><?php echo 'Q. '.number_format($FilaNotaEfectivo[TRA_TOTAL] + $FilaNotaCredito[TRA_TOTAL] + $FilaNotaTarjetaCredito[TRA_TOTAL] + $FilaNotaDepositos[TRA_TOTAL] + $FilaNotaDolares[TRA_TOTAL] + $FilaNotaLempiras[TRA_TOTAL], 2, '.', ','); ?></h4></td>
														</tr>
														<tr>
															<td align="center"><h2><b>Total Documentos Emitidos</b></h2></td>
															<td colspan="4" align="right"><h2><?php echo number_format($TotalFacturado - ($FilaNotaEfectivo[TRA_TOTAL] + $FilaNotaCredito[TRA_TOTAL] + $FilaNotaTarjetaCredito[TRA_TOTAL] + $FilaNotaDepositos[TRA_TOTAL] + $FilaNotaDolares[TRA_TOTAL] + $FilaNotaLempiras[TRA_TOTAL]), 2) ?></h2></td>
														</tr>
														<tr>
															<td><h5><b>Faltante</b></h5></td>
															<td colspan="4" align="right"><h5><?php if($FaltSob < 0){echo 'Q. '.number_format($FaltSob, 2, '.', ',');}elseif($FaltSob == 0){echo 'Q. '.number_format(0, 2, '.', ',');}else{echo 'Q. '.number_format(0, 2, '.', ',');} ?></h5></td>
														</tr>
														<tr>
															<td><h5><b>Sobrante</b></h5></td>
															<td colspan="4" align="right"><h5><?php if($FaltSob > 0){echo 'Q. '.number_format($FaltSob, 2, '.', ',');}elseif($FaltSob == 0){echo 'Q. '.number_format(0, 2, '.', ',');}else{echo 'Q. '.number_format(0, 2, '.', ',');} ?></h5></td>
														</tr>
													</tbody>
												</table>
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
												</tr>
											</thead>
											<tbody>
												<?php
													$SqlFacturas = "SELECT FACTURA_PS.* 
																	FROM Bodega.FACTURA_PS
																	WHERE FACTURA_PS.F_FECHA_TRANS = '".$_POST["FechaInicio"]."' 
																	ORDER BY FACTURA_PS.F_SERIE, FACTURA_PS.F_NUMERO";
													$ResultFacturas = mysqli_query($db, $SqlFacturas);
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
															echo '<td>'.$FilasFacturas["F_DTE"].'</td>';
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

			<input type="hidden" name="TipoCorte" id="TipoCorte" value="Tilapia">

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

			<input type="hidden" name="NotaCreditoEfectivo" id="NotaCreditoEfectivo" value="<?php echo $FilaNotaEfectivo[TRA_TOTAL] ?>">
			<input type="hidden" name="TotalEfectivo" id="TotalEfectivo" value="<?php echo $TCQ - $FilaNotaEfectivo[TRA_TOTAL] ?>">

			<input type="hidden" name="NotaCreditoCredito" id="NotaCreditoCredito" value="<?php echo $FilaNotaCredito[TRA_TOTAL] ?>">
			<input type="hidden" name="TotalCredito" id="TotalCredito" value="<?php echo $TotalCreditos - $FilaNotaCredito[TRA_TOTAL] ?>">

			<input type="hidden" name="NotaCreditoTarjeta" id="NotaCreditoTarjeta" value="<?php echo $FilaNotaTarjetaCredito[TRA_TOTAL] ?>">
			<input type="hidden" name="TotalTarjeta" id="TotalTarjeta" value="<?php echo $TotalTarjetaCredito - $FilaNotaTarjetaCredito[TRA_TOTAL] ?>">

			<input type="hidden" name="NotaCreditoDolar" id="NotaCreditoDolar" value="<?php echo $FilaNotaDolares[TRA_TOTAL] ?>">
			<input type="hidden" name="TotalDolar" id="TotalDolar" value="<?php echo $TotalDolaresQuetzalisados - $FilaNotaDolares[TRA_TOTAL] ?>">

			<input type="hidden" name="NotaCreditoLempiar" id="NotaCreditoLempiar" value="<?php echo $FilaNotaLempiras[TRA_TOTAL] ?>">
			<input type="hidden" name="TotalLempira" id="TotalLempira" value="<?php echo $TotalLempirasQuetzalisados - $FilaNotaLempiras[TRA_TOTAL] ?>">

			<input type="hidden" name="NotaCreditoDeposito" id="NotaCreditoDeposito" value="<?php echo $FilaNotaDepositos[TRA_TOTAL] ?>">
			<input type="hidden" name="TotalDeposito" id="TotalDeposito" value="<?php echo $TotalDeposito - $FilaNotaDepositos[TRA_TOTAL] ?>">

			<input type="hidden" name="TotalNotasEmitidas" id="TotalNotasEmitidas" value="<?php echo $TotalNotasEmitidas ?>">
			<input type="hidden" name="TotlaFacturasEmitidas" id="TotlaFacturasEmitidas" value="<?php echo 'De la '.$FacturaMinima.' a la '.$FacturaMaxima ?>">
		</form>
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
