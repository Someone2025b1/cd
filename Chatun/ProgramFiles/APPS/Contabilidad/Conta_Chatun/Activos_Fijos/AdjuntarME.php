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
	function SelColaborador(x)
		{
			window.open('SelColaborador.php','popup','width=750, height=700');
			document.getElementById("AutorizaGasto").focus();
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php

	$query = "SELECT TRA_TOTAL, TRA_SALDO FROM Contabilidad.TRANSACCION WHERE TRA_CODIGO = '".$_GET["CodigoPoliza"]."'";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{	
		$Total = $row["TRA_TOTAL"];
		$Saldo = $row["TRA_SALDO"];
	}
	?>


	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="IngresoPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Adjuntar Mobiliario Equipo a Póliza</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<?php
	                                
									$query = "SELECT * FROM Contabilidad.TRANSACCION WHERE TT_CODIGO = 13 AND TRA_SALDO > 0 AND E_CODIGO = 2";
									$result = mysqli_query($db,$query);
									$NumeroResultados = mysqli_num_rows($result);
									if($NumeroResultados > 0)
									{
										$i = 1;
										?>
										<table class="table">
											<thead>
												<tr>
													<th class="text-center"><strong><h6>No. Póliza</h6></strong></th>
													<th class="text-center"><strong><h6>Transaccion</h6></strong></th>
													<th class="text-center"><strong><h6>Fecha</h6></strong></th>
													<th class="text-center"><strong><h6>Concepto</h6></strong></th>
													<th class="text-center"><strong><h6>Total</h6></strong></th>
													<th class="text-center"><strong><h6>Saldo</h6></strong></th>
												</tr>
											</thead>
											<tbody>
										<?php
										while($row = mysqli_fetch_array($result))
										{
											$Codigo = $row["TRA_CODIGO"];

											$QueryTotal = mysqli_query($db,"SELECT SUM(TRAD_CARGO_CONTA) AS SUMA_TOTAL
																		FROM Contabilidad.TRANSACCION_DETALLE 
																		WHERE ((TRANSACCION_DETALLE.N_CODIGO BETWEEN '1.02.01.001' AND '1.02.01.010') OR (N_CODIGO = '1.03.01.001'))
																		AND TRANSACCION_DETALLE.TRA_CODIGO = '".$Codigo."'");
											$FilaTotal = mysqli_fetch_array($QueryTotal);
											$Total = $FilaTotal["SUMA_TOTAL"];


											$QueryMobiliarioAdjunto = mysqli_query($db,"SELECT SUM(ACTIVO_FIJO.AF_VALOR) AS TOTAL_ACTIVO
														FROM Contabilidad.ACTIVO_FIJO
														WHERE ACTIVO_FIJO.AF_ESTADO = 1
														AND AF_TRANSACCION = '".$Codigo."'");
											$FilaTotalMobiliario = mysqli_fetch_array($QueryMobiliarioAdjunto);
											$TotalSaldo = $FilaTotalMobiliario["TOTAL_ACTIVO"];

											$SaldoTotal = $Total - $TotalSaldo;
											$SaldoActual2=0;

											if($SaldoTotal != 0 && $SaldoTotal > 0.05)
											{
												echo '<tr>';
													echo '<td>'.$row["TRA_CORRELATIVO"].'</td>';
													echo '<td>'.$Codigo.'</td>';
													echo '<td>'.date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"])).'</td>';
													echo '<td>'.$row["TRA_CONCEPTO"].'</td>';
													echo '<td>'.number_format($Total, 2, '.', ',').'</td>';
													echo '<td>'.number_format($SaldoTotal, 2, '.', ',').'</td>';
													echo '<td><a href="AdjuntarMEPro.php?CodigoPoliza='.$Codigo.'"><button type="button" class="btn btn-warning btn-xs">
																<span class="glyphicon glyphicon-plus"></span> Adjuntar
															</button></a></td>';
												echo '</tr>';
												$i++;

												
											}
										}
										?>
											</tbody>
										</table>
										<?php
									}
									else
									{
										?>
											<div class="alert alert-callout alert-success" role="alert">
												Actualmente <strong>no hay</strong> pólizas pendientes por operar.
											</div>
										<?php
									}

									?>
								</div>
							</div>
							
						</div>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Adjuntar Activos Menores</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<?php
	                                
									$query = "SELECT B.TRAD_CARGO_CONTA AS SUMA_TOTAL, A.* 
									FROM Contabilidad.TRANSACCION AS A, Contabilidad.TRANSACCION_DETALLE AS B
									WHERE A.TRA_CODIGO = B.TRA_CODIGO 
									AND (A.TT_CODIGO = 2 OR  A.TT_CODIGO = 13)
									AND A.TRA_MENOR_REGISTRADO = 0 
									AND A.E_CODIGO = 2
									AND ((B.N_CODIGO = '7.02.06.004') OR (B.N_CODIGO = '7.08.06.004')OR (B.N_CODIGO = '6.02.06.004')
									OR (B.N_CODIGO = '6.03.06.005') OR (B.N_CODIGO = '6.04.06.005') OR (B.N_CODIGO = '6.05.06.004')
									OR (B.N_CODIGO = '6.06.06.004') OR (B.N_CODIGO = '6.07.06.004') OR (B.N_CODIGO = '6.08.06.004'))";
									$result = mysqli_query($db,$query);
									$NumeroResultados = mysqli_num_rows($result);
									if($NumeroResultados > 0)
									{
										$i = 1;
										?>
										<table class="table">
											<thead>
												<tr>
													<th class="text-center"><strong><h6>No. Póliza</h6></strong></th>
													<th class="text-center"><strong><h6>Transaccion</h6></strong></th>
													<th class="text-center"><strong><h6>Fecha</h6></strong></th>
													<th class="text-center"><strong><h6>Concepto</h6></strong></th>
													<th class="text-center"><strong><h6>Total</h6></strong></th>
													<th class="text-center"><strong><h6>Saldo</h6></strong></th>
												</tr>
											</thead>
											<tbody>
										<?php
										while($row = mysqli_fetch_array($result))
										{
											$Codigo = $row["TRA_CODIGO"];

											$Total = $row["SUMA_TOTAL"];


											$QueryMobiliarioAdjunto = mysqli_query($db,"SELECT SUM(ACTIVO_FIJO.AF_VALOR) AS TOTAL_ACTIVO
														FROM Contabilidad.ACTIVO_FIJO
														WHERE ACTIVO_FIJO.AF_ESTADO = 1
														AND AF_TRANSACCION = '".$Codigo."'");
											$FilaTotalMobiliario = mysqli_fetch_array($QueryMobiliarioAdjunto);
											$TotalSaldo = $FilaTotalMobiliario["TOTAL_ACTIVO"];

											$SaldoTotal = $Total - $TotalSaldo;

											if($SaldoTotal != 0 && $SaldoTotal > 0.05)
											{
												echo '<tr>';
													echo '<td>'.$row["TRA_CORRELATIVO"].'</td>';
													echo '<td>'.$Codigo.'</td>';
													echo '<td>'.date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"])).'</td>';
													echo '<td>'.$row["TRA_CONCEPTO"].'</td>';
													echo '<td>'.number_format($Total, 2, '.', ',').'</td>';
													echo '<td>'.number_format($SaldoTotal, 2, '.', ',').'</td>';
													echo '<td><a href="AdjuntarMEProMenor.php?CodigoPoliza='.$Codigo.'"><button type="button" class="btn btn-warning btn-xs">
																<span class="glyphicon glyphicon-plus"></span> Adjuntar
															</button></a></td>';
												echo '</tr>';
												$i++;
											}
											
										}
										?>
											</tbody>
										</table>
										<?php
									}
									else
									{
										?>
											<div class="alert alert-callout alert-success" role="alert">
												Actualmente <strong>no hay</strong> pólizas pendientes por operar.
											</div>
										<?php
									}

									?>
								</div>
							</div>
							
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>


	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
