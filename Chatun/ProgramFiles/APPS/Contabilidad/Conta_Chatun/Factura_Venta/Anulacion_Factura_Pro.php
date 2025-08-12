<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


//Para restringir
session_start(); // Siempre iniciar la sesión

// Definimos qué área tiene permiso para ver esta página
$areaPermitida = '55';

// Verificamos si el usuario ha iniciado sesión
if (!isset($_SESSION['id_departamento'])) {
    echo "Debe iniciar sesión primero.";
    exit(); // detenemos la ejecución
}

// Verificamos si el usuario pertenece al área permitida
if ($_SESSION['id_departamento'] !== $areaPermitida) {
    echo "No tiene permisos para ver esta página.";
    exit(); // detenemos la ejecución
}

//Fin Restrincción
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

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Crear Nota de Crédito</strong></h4>
							</div>
							<div class="card-body">
							<?php
								if($_GET['Tabla']=='DETALLE_FACTURA_ADMINISTRATIVA')
								{
									$QueryDatosFactura = mysqli_query($db, "SELECT c.CLI_DIRECCION, b.DFA_NIT, b.TRA_CODIGO, a.TRA_TOTAL, a.TRA_FECHA_CERTIFICACION,  c.CLI_NOMBRE, a.TRA_DTE
									FROM Contabilidad.TRANSACCION a 
									INNER JOIN Contabilidad.DETALLE_FACTURA_ADMINISTRATIVA b ON a.TRA_CODIGO = b.TRA_CODIGO
									INNER JOIN Bodega.CLIENTE c ON c.CLI_NIT = b.DFA_NIT
									WHERE a.TT_CODIGO = 25 AND a.TRA_CODIGO = '".$_GET['Codigo']."' GROUP BY b.TRA_CODIGO");
									$FilaDatosFactura = mysqli_fetch_array($QueryDatosFactura);
									$ImporteBruto = ($FilaDatosFactura['TRA_TOTAL']) - (($FilaDatosFactura['TRA_TOTAL'] * 0.12) / 1.12);
									$Impuesto = ($FilaDatosFactura['TRA_TOTAL'] * 0.12) / 1.12; 
									$FechaCertificacion = $FilaDatosFactura["TRA_FECHA_CERTIFICACION"]; 
									$FechaCertiExplode = explode("T", $FechaCertificacion); 
									$FechaDepuradaCertificacion = $FechaCertiExplode[0]; 
									$NumeroAutorizacion = $FilaDatosFactura["TRA_DTE"];
									$Nit = $FilaDatosFactura['DFA_NIT'];
									$Nombre = $FilaDatosFactura['CLI_NOMBRE'];
									$Total = $FilaDatosFactura['TRA_TOTAL']; 
									$Codigo  = $FilaDatosFactura['TRA_CODIGO'];
									$Direccion1 = $FilaDatosFactura['CLI_DIRECCION'];
								}
								elseif($_GET['Tabla']=='DETALLE_FACTURA_ESPECIAL')
								{
									$QueryDatosFactura = mysqli_query($db, "SELECT  b.DFE_NIT, b.TRA_CODIGO, a.TRA_TOTAL, c.P_NOMBRE, c.P_DIRECCION, a.TRA_FECHA_CERTIFICACION, a.TRA_DTE
									FROM Contabilidad.TRANSACCION a 
									INNER JOIN Contabilidad.DETALLE_FACTURA_ESPECIAL b ON a.TRA_CODIGO = b.TRA_CODIGO
									INNER JOIN Contabilidad.PROVEEDOR c ON c.P_DPI = b.DFE_NIT
									WHERE a.TT_CODIGO = 19 AND a.TRA_CODIGO = '".$_GET['Codigo']."' GROUP BY b.TRA_CODIGO");
									$FilaDatosFactura = mysqli_fetch_array($QueryDatosFactura);
									$ImporteBruto = ($FilaDatosFactura['TRA_TOTAL']) - (($FilaDatosFactura['TRA_TOTAL'] * 0.12) / 1.12);
									$Impuesto = ($FilaDatosFactura['TRA_TOTAL'] * 0.12) / 1.12; 
									$FechaCertificacion = $FilaDatosFactura["TRA_FECHA_CERTIFICACION"]; 
									$FechaCertiExplode = explode("T", $FechaCertificacion); 
									$FechaDepuradaCertificacion = $FechaCertiExplode[0]; 
									$NumeroAutorizacion = $FilaDatosFactura["TRA_DTE"];
									$Nit = $FilaDatosFactura['DFE_NIT'];
									$Nombre = $FilaDatosFactura['P_NOMBRE'];
									$Total = $FilaDatosFactura['TRA_TOTAL']; 
									$Codigo  = $FilaDatosFactura['TRA_CODIGO'];
									$Direccion1 = $FilaDatosFactura['P_DIRECCION'];
								}else
								{
									$QueryDatosFactura = mysqli_query($db, "SELECT * 
									FROM Bodega.".$_GET['Tabla']." AS A
									INNER JOIN Bodega.CLIENTE AS B ON A.CLI_NIT = B.CLI_NIT
									WHERE A.F_CODIGO = '".$_GET['Codigo']."'");
									$FilaDatosFactura = mysqli_fetch_array($QueryDatosFactura);
									$ImporteBruto = ($FilaDatosFactura['F_TOTAL']) - (($FilaDatosFactura['F_TOTAL'] * 0.12) / 1.12);
									$Impuesto = ($FilaDatosFactura['F_TOTAL'] * 0.12) / 1.12; 
									$FechaCertificacion = $FilaDatosFactura["F_FECHA_CERTIFICACION"]; 
									$FechaCertiExplode = explode("T", $FechaCertificacion); 
									$FechaDepuradaCertificacion = $FechaCertiExplode[0]; 
									$NumeroAutorizacion = $FilaDatosFactura["F_DTE"];
									$Nit = $FilaDatosFactura['CLI_NIT'];
									$Nombre = $FilaDatosFactura['CLI_NOMBRE'];
									$Total = $FilaDatosFactura['F_TOTAL'];
									$Codigo  = $FilaDatosFactura['F_CODIGO'];
									$Direccion1 = $FilaDatosFactura['CLI_DIRECCION'];

								} 
									
									?>
									<form action="Anulacion_Factura_Pro_Pro.php" method="POST">
										<input type="hidden" name="Tabla" id="Tabla" value="<?php echo $_GET['Tabla'] ?>">
										<div class="row">
											<div class="col-lg-3">
												<label for="FechaDocumento">Fecha Documento</label>
												<input type="date" name="FechaDocumento" id="FechaDocumento" class="form-control" required value="<?php echo date('Y-m-d') ?>">
											</div>
											<div class="col-lg-3">
												<label for="FechaCertificacion">Fecha Certificacion</label>
												<input type="text" name="FechaCertificacion" id="FechaCertificacion" class="form-control" required value="<?php echo date('Y-m-d', strtotime($FechaDepuradaCertificacion)) ?>" readonly>
												<input type="hidden" name="FechaCertificacionCompleta" id="FechaCertificacionCompleta" class="form-control" required value="<?php echo $FechaCertificacion ?>" readonly>
											</div>
											<div class="col-lg-6">
												<label for="NumeroAutorizacion">Autorizacion</label>
												<input type="text" name="NumeroAutorizacion" id="NumeroAutorizacion" class="form-control" required value="<?php echo $NumeroAutorizacion ?>" readonly>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3">
												<label for="NIT">NIT</label>
												<input type="text" name="NIT" id="NIT" class="form-control" required value="<?php echo $Nit; ?>" readonly>
											</div>
											<div class="col-lg-6">
												<label for="Nombre">Nombre</label>
												<input type="text" name="Nombre" id="Nombre" class="form-control" required value="<?php echo $Nombre; ?>" readonly>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<label for="Direccion">Dirección</label>
												<input type="text" name="Direccion" id="Direccion" class="form-control" required value="<?php echo $Direccion1 ?>" readonly>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3">
												<label for="ImporteBruto">Importe Bruto</label>
												<input type="number" name="ImporteBruto" id="ImporteBruto" class="form-control" required value="<?php echo number_format($ImporteBruto, 2, ".", "") ?>" readonly>
											</div>
											<div class="col-lg-3">
												<label for="Impuesto">Impuesto</label>
												<input type="number" name="Impuesto" id="Impuesto" class="form-control" required value="<?php echo number_format($Impuesto, 2, ".", "") ?>" readonly>
											</div>
											<div class="col-lg-3">
												<label for="TotalTransaccion">Total</label>
												<input type="number" name="TotalTransaccion" id="TotalTransaccion" class="form-control" required value="<?php echo number_format($Total, 2, ".", "") ?>" readonly>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3">
												<label for="CodigoFactura">Código Factura</label>
												<input type="text" name="CodigoFactura" id="CodigoFactura" class="form-control" required readonly value="<?php echo $Codigo ?>">
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<label for="Observaciones">Observaciones</label>
												<input type="text" name="Observaciones" id="Observaciones" class="form-control" required >
											</div>
										</div>
										<div class="row">
											<br>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="checkbox checkbox-styled">
													<label>
														<input type="checkbox" name="RebajaInventario" id="RebajaInventario" class="form-control" checked>
														<span>Rebaja Inventario?</span>
													</label>
												</div>
											</div>
										</div>
										<div class="row">
											<br>
											<br>
										</div>
										<div class="row">
											<caption class="text-center"><h3>Partida Contable</h3></caption>
											<table class="table table-hover table-condensed">
												<thead>
													<tr>
														<th>CODIGO</th>
														<th>CUENTA</th>
														<th>CARGO</th>
														<th>ABONO</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$QueryCuentaContable = mysqli_query($db, "SELECT B.*, C.*
																					FROM Contabilidad.TRANSACCION AS A
																					INNER JOIN Contabilidad.TRANSACCION_DETALLE AS B ON A.TRA_CODIGO = B.TRA_CODIGO
																					INNER JOIN Contabilidad.NOMENCLATURA AS C ON B.N_CODIGO = C.N_CODIGO
																					WHERE A.TRA_CODIGO = '".$_GET["Codigo"]."'");
														while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
														{
															?>
																<tr>
																	<td><input type="text" class="form-control" name="CodigoCuenta[]" id="CodigoCuenta[]" required readonly value="<?php echo $FilaCuentaContable[N_CODIGO] ?>"></td>
																	<td><input type="text" class="form-control" name="Nombrecuenta[]" id="Nombrecuenta[]" required readonly value="<?php echo $FilaCuentaContable[N_NOMBRE] ?>"></td>
																	<td><input type="text" class="form-control" name="Cargo[]" id="Cargo[]" required readonly value="<?php echo $FilaCuentaContable[TRAD_ABONO_CONTA] ?>"></td>
																	<td><input type="text" class="form-control" name="Abono[]" id="Abono[]" required readonly value="<?php echo $FilaCuentaContable[TRAD_CARGO_CONTA] ?>"></td>
																</tr>
															<?php
														}
													?>
												</tbody>
											</table>
										</div>
										<div class="row">
											<br>
											<br>
										</div>
										<div class="row">
											<caption class="text-center"><h3>Movimiento Producto</h3></caption>
											<table class="table table-hover table-condensed">
												<thead>
													<tr>
														<th>CODIGO</th>
														<th>PRODUCTO</th>
														<th>CANTIDAD</th>
														<th>PRECIO UNITARIO</th>
														<th>MONTO BRUTO</th>
														<th>IVA</th>
														<th>DESCUENTO</th>
														<th>IMPORTE NETO</th>
													</tr>
												</thead>
												<tbody>
													<?php
					if($_GET['Tabla'] == 'FACTURA_HS')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_HS_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");
						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_NOMBRE] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");
						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																	FROM Bodega.RECETA_SUBRECETA AS A
																	WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
							$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA_2')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_2_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");
						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.P_NOMBRE
																	FROM Productos.PRODUCTO AS A
																	WHERE A.P_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
							$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[P_NOMBRE] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA_PIZZA')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_PIZZA_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");
						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.P_NOMBRE
																	FROM Productos.PRODUCTO AS A
																	WHERE A.P_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
							$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[P_NOMBRE] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA_RS')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_RS_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");
						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																	FROM Bodega.RECETA_SUBRECETA AS A
																	WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
							$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA_JG')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_JG_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");
						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																	FROM Bodega.PRODUCTO AS A
																	WHERE A.P_CODIGO = '".$FilaCuentaContable[P_CODIGO]."'");
							$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[P_NOMBRE] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA_21K')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_21K_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");
						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							

							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCRIPCION] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA_SV')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_SV_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");

						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							$QuerySaberNombreProducto = mysqli_query($db, "SELECT A.P_NOMBRE
															FROM Productos.PRODUCTO AS A
															WHERE A.P_CODIGO = '".$FilaCuentaContable[P_CODIGO]."'");
							$FilaNombreProducto = mysqli_fetch_array($QuerySaberNombreProducto);

							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[P_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreProducto[P_NOMBRE] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA_SV_2')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_SV_2_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");

						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							$QuerySaberNombreProducto = mysqli_query($db, "SELECT A.P_NOMBRE
															FROM Productos.PRODUCTO AS A
															WHERE A.P_CODIGO = '".$FilaCuentaContable[P_CODIGO]."'");
							$FilaNombreProducto = mysqli_fetch_array($QuerySaberNombreProducto);

							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[P_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreProducto[P_NOMBRE] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA_KS')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_KS_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");
						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																	FROM Bodega.RECETA_SUBRECETA AS A
																	WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
							$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA_KS_2')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_KS_2_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");
						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																	FROM Bodega.RECETA_SUBRECETA AS A
																	WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
							$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

							?>
								<tr>
									<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
									<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
									<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
									<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
									<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
									<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
									<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
								</tr>
							<?php
						}
					}
					elseif($_GET['Tabla'] == 'FACTURA_TQ')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_TQ_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");

						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							if($FilaCuentaContable[RS_CODIGO] != '')
							{
								$QuerySaberNombreProducto = mysqli_query($db, "SELECT A.P_NOMBRE
																FROM Bodega.PRODUCTO AS A
																WHERE A.P_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");

								$RegistrosNombreProducto = mysqli_num_rows($QuerySaberNombreProducto);

								if($RegistrosNombreProducto > 0)
								{
									$FilaNombreProducto = mysqli_fetch_array($QuerySaberNombreProducto);

									?>
										<tr>
											<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
											<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreProducto[P_NOMBRE] ?>"></td>
											<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
											<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
											<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
										</tr>
									<?php
								}
								else
								{

									$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																			FROM Bodega.RECETA_SUBRECETA AS A
																			WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
									$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

									if($FilaCuentaContable[RS_CODIGO] != '')
									{
										?>
											<tr>
												<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
																					<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
																					<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
																					<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
																					<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
																				</tr>
																			<?php
																		}
																	}
																}
															}
														}
					elseif($_GET['Tabla'] == 'FACTURA_TQ_2')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_TQ_2_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");

						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							if($FilaCuentaContable[RS_CODIGO] != '')
							{
								$QuerySaberNombreProducto = mysqli_query($db, "SELECT A.P_NOMBRE
																FROM Bodega.PRODUCTO AS A
																WHERE A.P_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");

								$RegistrosNombreProducto = mysqli_num_rows($QuerySaberNombreProducto);

								if($RegistrosNombreProducto > 0)
								{
									$FilaNombreProducto = mysqli_fetch_array($QuerySaberNombreProducto);

									?>
										<tr>
											<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
											<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreProducto[P_NOMBRE] ?>"></td>
											<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
											<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
											<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
										</tr>
									<?php
								}
								else
								{

									$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																			FROM Bodega.RECETA_SUBRECETA AS A
																			WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
									$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

									if($FilaCuentaContable[RS_CODIGO] != '')
									{
										?>
											<tr>
												<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
																					<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
																					<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
																					<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
																					<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
																				</tr>
																			<?php
																		}
																	}
																}
															}
														}
					elseif($_GET['Tabla'] == 'FACTURA_TQ_3')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_TQ_3_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");

						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							if($FilaCuentaContable[RS_CODIGO] != '')
							{
								$QuerySaberNombreProducto = mysqli_query($db, "SELECT A.P_NOMBRE
																FROM Bodega.PRODUCTO AS A
																WHERE A.P_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");

								$RegistrosNombreProducto = mysqli_num_rows($QuerySaberNombreProducto);

								if($RegistrosNombreProducto > 0)
								{
									$FilaNombreProducto = mysqli_fetch_array($QuerySaberNombreProducto);

									?>
										<tr>
											<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
											<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreProducto[P_NOMBRE] ?>"></td>
											<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
											<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
											<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
										</tr>
									<?php
								}
								else
								{

									$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																			FROM Bodega.RECETA_SUBRECETA AS A
																			WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
									$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

									if($FilaCuentaContable[RS_CODIGO] != '')
									{
										?>
											<tr>
												<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
																					<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
																					<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
																					<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
																					<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
																				</tr>
																			<?php
																		}
																	}
																}
															}
														}
					elseif($_GET['Tabla'] == 'FACTURA_TQ_4')
					{
						$QueryCuentaContable = mysqli_query($db, "SELECT *
														FROM Bodega.FACTURA_TQ_4_DETALLE AS A
														WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");

						while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
						{
							if($FilaCuentaContable[RS_CODIGO] != '')
							{
								$QuerySaberNombreProducto = mysqli_query($db, "SELECT A.P_NOMBRE
																FROM Bodega.PRODUCTO AS A
																WHERE A.P_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");

								$RegistrosNombreProducto = mysqli_num_rows($QuerySaberNombreProducto);

								if($RegistrosNombreProducto > 0)
								{
									$FilaNombreProducto = mysqli_fetch_array($QuerySaberNombreProducto);

									?>
										<tr>
											<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
											<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreProducto[P_NOMBRE] ?>"></td>
											<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
											<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
											<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
											<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
										</tr>
									<?php
								}
								else
								{

									$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																			FROM Bodega.RECETA_SUBRECETA AS A
																			WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
									$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

									if($FilaCuentaContable[RS_CODIGO] != '')
									{
										?>
											<tr>
												<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
																					<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
																					<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
																					<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
																					<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
																				</tr>
																			<?php
																		}
																	}
																}
															}
														}
														elseif($_GET['Tabla'] == 'FACTURA_EV')
														{
															$QueryCuentaContable = mysqli_query($db, "SELECT *
																							FROM Bodega.FACTURA_EV_DETALLE AS A
																							WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");

															while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
															{
																if($FilaCuentaContable[RS_CODIGO] != '')
																{
																	$QuerySaberNombreProducto = mysqli_query($db, "SELECT A.P_NOMBRE
																									FROM Bodega.PRODUCTO AS A
																									WHERE A.P_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");

																	$RegistrosNombreProducto = mysqli_num_rows($QuerySaberNombreProducto);

																	if($RegistrosNombreProducto > 0)
																	{
																		$FilaNombreProducto = mysqli_fetch_array($QuerySaberNombreProducto);

																		?>
																			<tr>
																				<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
																				<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreProducto[P_NOMBRE] ?>"></td>
																				<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
																				<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
																				<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																				<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																				<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
																				<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
																			</tr>
																		<?php
																	}
																	else
																	{

																		$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																												FROM Bodega.RECETA_SUBRECETA AS A
																												WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
																		$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

																		if($FilaCuentaContable[RS_CODIGO] != '')
																		{
																			?>
																				<tr>
																					<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
																					<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
																					<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
																					<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
																					<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
																				</tr>
																			<?php
																		}
																	}
																}
															}
														}
														elseif($_GET['Tabla'] == 'FACTURA_HC')
														{
															$QueryCuentaContable = mysqli_query($db, "SELECT *
																							FROM Bodega.FACTURA_HC_DETALLE AS A
																							WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");

															while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
															{
																		if($FilaCuentaContable[RS_CODIGO] != '')
																		{
																			?>
																				<tr>
																					<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
																					<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_NOMBRE] ?>"></td>
																					<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
																					<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
																					<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo number_format($FilaCuentaContable[FD_DESCUENTO], 2, ".", "") ?>"></td>
																					<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
																				</tr>
																			<?php
																}
															}
														}
														elseif($_GET['Tabla'] == 'FACTURA_KS_3')
														{
															$QueryCuentaContable = mysqli_query($db, "SELECT *
																							FROM Bodega.FACTURA_KS_3_DETALLE AS A
																							WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");

															while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
															{
																$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																										FROM Bodega.RECETA_SUBRECETA AS A
																										WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
																$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

																?>
																	<tr>
																		<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
																		<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
																		<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
																		<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
																		<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																		<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																		<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
																		<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
																	</tr>
																<?php
																		 
															}
														}
														elseif($_GET['Tabla'] == 'FACTURA_KS_4')
														{
															$QueryCuentaContable = mysqli_query($db, "SELECT *
																							FROM Bodega.FACTURA_KS_4_DETALLE AS A
																							WHERE A.F_CODIGO = '".$_GET["Codigo"]."'");

															while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
															{
																$QuerySaberNombreReceta = mysqli_query($db, "SELECT A.RS_NOMBRE
																										FROM Bodega.RECETA_SUBRECETA AS A
																										WHERE A.RS_CODIGO = '".$FilaCuentaContable[RS_CODIGO]."'");
																$FilaNombreReceta = mysqli_fetch_array($QuerySaberNombreReceta);

																?>
																	<tr>
																		<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[RS_CODIGO] ?>"></td>
																		<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaNombreReceta[RS_NOMBRE] ?>"></td>
																		<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[FD_CANTIDAD] ?>"></td>
																		<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[FD_PRECIO_UNITARIO] ?>"></td>
																		<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[FD_PRECIO_UNITARIO] -(($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																		<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[FD_PRECIO_UNITARIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																		<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="<?php echo $FilaCuentaContable[FD_DESCUENTO] ?>"></td>
																		<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[FD_SUBTOTAL] ?>"></td>
																	</tr>
																<?php
																		 
															}
														}
														elseif($_GET['Tabla'] == 'DETALLE_FACTURA_ADMINISTRATIVA')
														{
															$QueryCuentaContable = mysqli_query($db, "SELECT a.DFA_CODIGO, a.DFA_CANTIDAD, a.DFA_DESCRIPCION, a.DFA_PRECIO, a.DFA_SUBTOTAL FROM Contabilidad.DETALLE_FACTURA_ADMINISTRATIVA a WHERE a.TRA_CODIGO = '".$_GET["Codigo"]."'");

															while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
															{
																 
																?>
																	<tr>
																		<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[DFA_CODIGO] ?>"></td>
																		<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaCuentaContable[DFA_DESCRIPCION] ?>"></td>
																		<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[DFA_CANTIDAD] ?>"></td>
																		<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[DFA_PRECIO] ?>"></td>
																		<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[DFA_PRECIO] -(($FilaCuentaContable[DFA_PRECIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																		<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[DFA_PRECIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																		<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="0"></td>
																		<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[DFA_SUBTOTAL] ?>"></td>
																	</tr>
																<?php
																		 
															}
														}
														elseif($_GET['Tabla'] == 'DETALLE_FACTURA_ESPECIAL')
														{
															$QueryCuentaContable = mysqli_query($db, "SELECT a.DFE_CODIGO, a.DFE_CANTIDAD, a.DFE_DESCRIPCION, a.DFE_PRECIO, a.DFE_SUBTOTAL FROM Contabilidad.DETALLE_FACTURA_ESPECIAL a WHERE a.TRA_CODIGO = '".$_GET["Codigo"]."'");

															while($FilaCuentaContable = mysqli_fetch_array($QueryCuentaContable))
															{
																 
																?>
																	<tr>
																		<td><input type="text" class="form-control" name="CodigoProducto[]" id="CodigoProducto[]" required readonly value="<?php echo $FilaCuentaContable[DFE_CODIGO] ?>"></td>
																		<td><input type="text" class="form-control" name="NombreProducto[]" id="NombreProducto[]" required readonly value="<?php echo $FilaCuentaContable[DFE_DESCRIPCION] ?>"></td>
																		<td><input type="text" class="form-control" name="Cantidad[]" id="Cantidad[]" required readonly value="<?php echo $FilaCuentaContable[DFE_CANTIDAD] ?>"></td>
																		<td><input type="text" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" required readonly value="<?php echo $FilaCuentaContable[DFE_PRECIO] ?>"></td>
																		<td><input type="text" class="form-control" name="MontoBruto[]" id="MontoBruto[]" required readonly value="<?php echo number_format(($FilaCuentaContable[DFE_PRECIO] -(($FilaCuentaContable[DFE_PRECIO] * 0.12) / 1.12)), 2, ".", "") ?>"></td>
																		<td><input type="text" class="form-control" name="IVA[]" id="IVA[]" required readonly value="<?php echo number_format((($FilaCuentaContable[DFE_PRECIO] * 0.12) / 1.12), 2, ".", "") ?>"></td>
																		<td><input type="text" class="form-control" name="Descuento[]" id="Descuento[]" required readonly value="0"></td>
																		<td><input type="text" class="form-control" name="Total[]" id="Total[]" required readonly value="<?php echo $FilaCuentaContable[DFE_SUBTOTAL] ?>"></td>
																	</tr>
																<?php
																		 
															}
														}
													?>
												</tbody>
											</table>
										</div>
										<div class="row text-center">
											<button type="submit" class="btn btn-success">Guardar</button>
										</div>
									</form>	

							</div>
						</div>
					</div>
			</div>
		</div>
		<!-- END CONTENT -->

	
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
