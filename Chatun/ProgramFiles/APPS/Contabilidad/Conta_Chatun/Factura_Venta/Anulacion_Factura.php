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
								<h4 class="text-center"><strong>Búsqueda de Factura Electrónica</strong></h4>
							</div>
							<div class="card-body">
								<form action="#" method="GET">
									<div class="col-lg-offset-4 col-lg-4">
										<div class="form-group">
											<label for="Fecha">Fecha</label>
											<input type="date" id="Fecha" name="Fecha" class="form-control" value="<?php echo date('Y-m-d') ?>">
										</div>
									</div>
									<div class="col-lg-offset-4 col-lg-4">
										<div class="form-group">
											<label for="PuntoVenta">Punto Venta</label>
											<select class="form-control" name="PuntoVenta" id="PuntoVenta" required>
												<option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
												<option value="RS">LAS TERRAZAS</option>
												<option value="RS2">LAS TERRAZAS #2</option>
												<option value="PIZZA">PIZZERÍA</option>
												<option value="EV">EVENTOS</option>
												<option value="HS">HELADOS</option>
												<option value="KS">CAFÉ LOS ABUELOS</option>
												<option value="KS2">KIOSKO AZADOS</option>
												<option value="SV">SOUVENIRS</option>
												<option value="TQ">TAQUILLA</option>
												<option value="MR">MIRADOR</option>
												<option value="HC">HOTELES</option>
												<option value="PS">PISICULTURA</option> 
												<option value="KO">KIOSKO OASIS</option>
												<option value="JG">JUEGOS</option> 
												<option value="AD">ADMINISTRATIVA</option>
												<option value="FE">ESPECIAL</option>
												<option value="TQ2">TAQUILLA #2</option>
												<option value="TQ3">TAQUILLA #3</option>
												<option value="TQ4">TAQUILLA #4</option>
												<option value="SV2">SOUVENIRS #2</option>
												<option value="KO4">KIOSKO PASILLO</option>
												<option value="21K">21K</option>
											</select>
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
										    if($_GET['PuntoVenta'] == 'AD')
											{
												$Tabla = "DETALLE_FACTURA_ADMINISTRATIVA";
												$Query = mysqli_query($db, "SELECT b.DFA_NIT, b.TRA_CODIGO, a.TRA_TOTAL,  c.CLI_NOMBRE, a.TRA_DTE
												FROM Contabilidad.TRANSACCION a 
												INNER JOIN Contabilidad.DETALLE_FACTURA_ADMINISTRATIVA b ON a.TRA_CODIGO = b.TRA_CODIGO
												INNER JOIN Bodega.CLIENTE c ON c.CLI_NIT = b.DFA_NIT
												WHERE a.TT_CODIGO = 25 AND a.TRA_FECHA_TRANS = '".$_GET['Fecha']."' GROUP BY b.TRA_CODIGO");  
											}
											elseif($_GET['PuntoVenta'] == 'FE')
											{
												$Tabla = "DETALLE_FACTURA_ESPECIAL";
												$Query = mysqli_query($db, "SELECT b.DFE_NIT, b.TRA_CODIGO, a.TRA_TOTAL, a.TRA_DTE
												FROM Contabilidad.TRANSACCION a 
												INNER JOIN Contabilidad.DETALLE_FACTURA_ESPECIAL b ON a.TRA_CODIGO = b.TRA_CODIGO
												WHERE a.TT_CODIGO = 19 AND a.TRA_FECHA_TRANS = '".$_GET['Fecha']."' GROUP BY b.TRA_CODIGO");  
											}else
											{
												if($_GET['PuntoVenta'] == 'RS')
											{
												$Tabla = "FACTURA";
												$DirImprimir = "../../../CYM/Restaurant/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'RS2')
											{
												$Tabla = "FACTURA_2";
												$DirImprimir = "../../../CYM/Restaurant2/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'EV')
											{
												$Tabla = "FACTURA_EV";
												$DirImprimir = "../../../CYM/Eventos/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'HS')
											{
												$Tabla = "FACTURA_HS";
												$DirImprimir = "../../../CYM/Helados/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'KS')
											{
												$Tabla = "FACTURA_KS";
												$DirImprimir = "../../../CYM/Kiosko/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'KS2')
											{
												$Tabla = "FACTURA_KS_2";
												$DirImprimir = "../../../CYM/Kiosko_2/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'SV')
											{
												$Tabla = "FACTURA_SV";
												$DirImprimir = "../../../CYM/Souvenirs/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'TQ')
											{
												$Tabla = "FACTURA_TQ";
												$DirImprimir = "../../../CYM/Taquilla/Facturacion/FactImp.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'MR')
											{
												$Tabla = "FACTURA_RS";
												$DirImprimir = "../../../CYM/Restaurante_Carta/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'HC')
											{
												$Tabla = "FACTURA_HC";
												$DirImprimir = "../../../CYM/Hoteles/Facturacion/FactImp.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'PS')
											{
												$Tabla = "FACTURA_PS";
												$DirImprimir = "../../../CYM/Tilapia/Facturacion/FactImp.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'KO')
											{
												$Tabla = "FACTURA_KS_3";
												$DirImprimir = "../../../CYM/Kiosko_3/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'JG')
											{
												$Tabla = "FACTURA_JG";
												$DirImprimir = "../../../CYM/Juegos/Facturacion/FactImp.php?Codigo=";
											} 
											elseif($_GET['PuntoVenta'] == 'TQ2')
											{
												$Tabla = "FACTURA_TQ_2";
												$DirImprimir = "../../../CYM/Taquilla2/Facturacion/FactImp.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'TQ3')
											{
												$Tabla = "FACTURA_TQ_3";
												$DirImprimir = "../../../CYM/Taquilla3/Facturacion/FactImp.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'TQ4')
											{
												$Tabla = "FACTURA_TQ_4";
												$DirImprimir = "../../../CYM/Taquilla4/Facturacion/FactImp.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'SV2')
											{
												$Tabla = "FACTURA_SV_2";
												$DirImprimir = "../../../CYM/Souvenirs2/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'KO4')
											{
												$Tabla = "FACTURA_KS_4";
												$DirImprimir = "../../../CYM/Kiosko_4/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == '21K')
											{
												$Tabla = "FACTURA_21K";
												$DirImprimir = "../../../CYM/21K/Facturacion/FactImpNew.php?Codigo=";
											}
											elseif($_GET['PuntoVenta'] == 'PIZZA')
											{
												$Tabla = "FACTURA_PIZZA";
												$DirImprimir = "../../../CYM/Pizzeria/Facturacion/FactImpNew.php?Codigo=";
											}

												$Query = mysqli_query($db, "SELECT * 
																	FROM Bodega.$Tabla AS A
																	INNER JOIN Bodega.CLIENTE AS B ON A.CLI_NIT = B.CLI_NIT
																	WHERE A.F_FECHA_TRANS = '".$_GET['Fecha']."' 
																	AND A.F_CAE <> ''
																	AND A.F_CODIGO NOT IN (SELECT DISTINCT(T.TRA_FACTURA_NOTA_CREDITO)
																							FROM Contabilidad.TRANSACCION AS T 
																							WHERE T.TRA_FACTURA_NOTA_CREDITO <> ''
																							AND T.TT_CODIGO = 17)");
											}
											

											?>
												<table class="table table-hover table-condensed">
													<thead>
														<tr>
															<th>DTE</th>
															<th>HORA</th>
															<th>NIT</th>
															<th>CLIENTE</th>
															<th>TOTAL</th>
															<th>ANULAR</th>
															<th>IMPRIMIR</th>
														</tr>
													</thead>
													<tbody>
													<?php
														while($Fila = mysqli_fetch_array($Query))
														{
															if($Tabla == "DETALLE_FACTURA_ADMINISTRATIVA")
															{
																$Dte = $Fila['TRA_DTE'];
																$Hora = $Fila['TRA_HORA'];
																$Nombre = $Fila['CLI_NOMBRE'];
																$Nit = $Fila['DFA_NIT'];
																$Total = $Fila['TRA_TOTAL'];
																$Codigo = $Fila['TRA_CODIGO'];
															}
															elseif($Tabla == "DETALLE_FACTURA_ESPECIAL")
															{
																$Dte = $Fila['TRA_DTE'];
																$Hora = $Fila['TRA_HORA'];
																$Nombre = $Fila['CLI_NOMBRE'];
																$Nit = $Fila['DFE_NIT'];
																$Total = $Fila['TRA_TOTAL'];
																$Codigo = $Fila['TRA_CODIGO'];
															}else
															{
																$Dte = $Fila['F_DTE'];
																$Hora = $Fila['F_HORA'];
																$Nombre = $Fila['CLI_NOMBRE'];
																$Nit = $Fila['CLI_NIT'];
																$Total = $Fila['F_TOTAL'];
																$Codigo = $Fila['F_CODIGO'];
															} 
															?>
																<tr>
																	<td><?php echo $Dte ?></td>
																	<td><?php echo $Hora ?></td>
																	<td><?php echo $Nit ?></td>
																	<td><?php echo $Nombre ?></td>
																	<td><?php echo number_format($Total, 2) ?></td>
																	<td><a href="Anulacion_Factura_Pro.php?Tabla=<?php echo $Tabla ?>&Codigo=<?php echo $Codigo ?>"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span></button></a></td>
																	<td>
																	<a href="<?php echo $DirImprimir.$Codigo ?>" Target="_blank"><button type="button" class="btn btn-info">
																					<span class="glyphicon glyphicon-print"></span> 
																				</button></a>
																	</td>
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

	
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
