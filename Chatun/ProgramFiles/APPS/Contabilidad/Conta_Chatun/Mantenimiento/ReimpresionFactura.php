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


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>
	<?php include("../MenuUsers.html"); ?>
	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Búsqueda de Factura Electrónica</strong></h4>
							</div>
							<div class="card-body">
								<form action="#" method="GET">
									<div class="row"> 
										<div class="col-lg-offset-2 col-lg-4">
											<div class="form-group">
												<label for="Fecha">Fecha</label>
												<input type="date" id="Fecha" name="Fecha" class="form-control" value="<?php echo date('Y-m-d') ?>">
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="PuntoVenta">Punto Venta</label>
												<select class="form-control" name="PuntoVenta" id="PuntoVenta" required>
													<option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
													<option value="RS">RESTAURANTE</option>
													<option value="EV">EVENTOS</option>
													<option value="HS">HELADOS</option>
													<option value="KS">KIOSKO</option>
													<option value="KS2">KIOSKO 2</option>
													<option value="SV">SOUVENIRS</option>
													<option value="TQ">TAQUILLA</option>
													<option value="MR">MIRADOR</option>
													<option value="HC">HOTELES</option> 
													<option value="KO">KIOSKO OASIS</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row"> 
										<div class="col-lg-offset-2 col-lg-4">
											<div class="form-group">
												<label for="Nit">Nit</label>
												<input type="text" id="Nit" name="Nit" class="form-control">
											</div>
										</div>
									</div>
									<div class="row"> 
										<div class="col-lg-offset-2 col-lg-4">
											<div class="form-group">
												<label for="Monto">Monto</label>
												<input type="text" id="Monto" name="Monto" class="form-control">
											</div>
										</div>
									</div>
									<div class="col-lg-12 text-center">
										<button type="submit" class="btn btn-success">Consultar</button>
									</div>
								</form>
								<div class="row">
									<br>
									<br>
								</div>
								<div class="row">
									<?php
										if(isset($_GET['Fecha']))
										{
											if($_GET['PuntoVenta'] == 'RS')
											{
												$Tabla = "FACTURA";
												$Imprimir = "../../../CYM/Restaurant/Facturacion/FactImp.php";
											}
											elseif($_GET['PuntoVenta'] == 'EV')
											{
												$Tabla = "FACTURA_EV";
												$Imprimir = "../../../CYM/Eventos/Facturacion/FactImp.php";
											}
											elseif($_GET['PuntoVenta'] == 'HS')
											{
												$Tabla = "FACTURA_HS";
												$Imprimir = "../../../CYM/Helados/Facturacion/FactImp.php";
											}
											elseif($_GET['PuntoVenta'] == 'KS')
											{
												$Tabla = "FACTURA_KS";
												$Imprimir = "../../../CYM/Kiosko/Facturacion/FactImp.php";
											}
											elseif($_GET['PuntoVenta'] == 'KS2')
											{
												$Tabla = "FACTURA_KS_2";
												$Imprimir = "../../../CYM/Kiosko_2/Facturacion/FactImp.php";
											}
											elseif($_GET['PuntoVenta'] == 'SV')
											{
												$Tabla = "FACTURA_SV";
												$Imprimir = "../../../CYM/Souvenirs/Facturacion/FactImp.php";
											}
											elseif($_GET['PuntoVenta'] == 'TQ')
											{
												$Tabla = "FACTURA_TQ";
												$Imprimir = "../../../CYM/Taquilla/Facturacion/FactImp.php";
											}
											elseif($_GET['PuntoVenta'] == 'MR')
											{
												$Tabla = "FACTURA_RS";
												$Imprimir = "../../../CYM/Restaurante_Carta/Facturacion/FactImp.php";
											}
											elseif($_GET['PuntoVenta'] == 'HC')
											{
												$Tabla = "FACTURA_HC";
												$Imprimir = "../../../CYM/Hoteles/Facturacion/FactImp.php";
											}
											elseif($_GET['PuntoVenta'] == 'KO')
											{
												$Tabla = "FACTURA_KS_3";
												$Imprimir = "../../../CYM/Kiosko_3/Facturacion/FactImp.php";
											}

											$Nit = $_GET["Nit"];
											$Monto = $_GET["Monto"];
											if ($Nit!="") {
												$FiltroNit = "AND A.CLI_NIT = '$Nit'";
											}
											else
											{
												$FiltroNit = "";	
											}

											if ($Monto!="") {
												$FiltroMonto = "AND A.F_TOTAL = '$Monto'";
											}
											else
											{
												$FiltroMonto = "";	
											}
											$Query = mysqli_query($db, "SELECT * 
																	FROM Bodega.$Tabla AS A
																	INNER JOIN Bodega.CLIENTE AS B ON A.CLI_NIT = B.CLI_NIT
																	WHERE A.F_FECHA_TRANS = '".$_GET['Fecha']."' $FiltroNit $FiltroMonto
																	AND A.F_CAE <> ''
																	AND A.F_CODIGO NOT IN (SELECT DISTINCT(T.TRA_FACTURA_NOTA_CREDITO)
																							FROM Contabilidad.TRANSACCION AS T 
																							WHERE T.TRA_FACTURA_NOTA_CREDITO <> ''
																							AND T.TT_CODIGO = 17)");
											echo "SELECT * 
											FROM Bodega.$Tabla AS A
											INNER JOIN Bodega.CLIENTE AS B ON A.CLI_NIT = B.CLI_NIT
											WHERE A.F_FECHA_TRANS = '".$_GET['Fecha']."' $FiltroNit $FiltroMonto
											AND A.F_CAE <> ''
											AND A.F_CODIGO NOT IN (SELECT DISTINCT(T.TRA_FACTURA_NOTA_CREDITO)
																	FROM Contabilidad.TRANSACCION AS T 
																	WHERE T.TRA_FACTURA_NOTA_CREDITO <> ''
																	AND T.TT_CODIGO = 17)";

											?>
												<table class="table table-hover table-condensed">
													<thead>
														<tr>
															<th>DTE</th>
															<th>NIT</th>
															<th>CLIENTE</th>
															<th>HORA</th>
															<th>TOTAL FACTURA</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
													<?php
														while($Fila = mysqli_fetch_array($Query))
														{
															?>
																<tr>
																	<td><?php echo $Fila['F_DTE'] ?></td>
																	<td><?php echo $Fila['CLI_NIT'] ?></td>
																	<td><?php echo $Fila['CLI_NOMBRE'] ?></td>	 		
																	<td><?php echo $Fila['F_HORA'] ?></td>
																	<td><?php echo number_format($Fila['F_TOTAL'], 2) ?></td>
																	<td><a href="<?php echo $Imprimir?>?Codigo=<?php echo $Fila['F_CODIGO'] ?>" target="_blank"><button type="button" class="btn btn-warning"><span class="fa fa-print"></span></button></a></td>
																</tr>
															<?php
														}
													?>
													</tbody>
												</table>
											<?php
										}
									?>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<!-- END CONTENT -->
 
	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
