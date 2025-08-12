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

	<script language=javascript type=text/javascript>
		$(document).on("keypress", 'form', function (e) {
		    var code = e.keyCode || e.which;
		    if (code == 13) {
		        e.preventDefault();
		        return false;
		    }
		});
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php"); ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="IFProPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Conteo de Inventario Físico</strong></h4>
							</div>
							<div class="card-body">
								<?php

									$UIA = uniqid('ABT_');
									$UIAD = uniqid('ABTD_');

									$UIC = uniqid('ABT_');
									$UICD = uniqid('ABTD_');

									$Codigo = $_POST["Codigo"];
									$CodigoUnicoNotaAbono = uniqid('tra_');
									$CodigoUnicoNotaAbonoDetalle = uniqid('trad_');

									$CodigoUnicoNotaCargo = uniqid('tra_');
									$CodigoUnicoNotaCargoDetalle = uniqid('trad_');


									$CodigoTransaccion = $_POST["CodigoTransaccion"];
									$CodigoProducto    = $_POST["CodigoProducto"];
									$Existencia        = $_POST["Existencia"];
									$Fisico            = $_POST["Fisico"];
									$Diferencia        = $_POST["Diferencia"];
									$Costo        	   = $_POST["Costo"];
									
									
									$BodegaAjuste      = $_POST["BodegaAjuste"];
									$FechaAjuste       = $_POST["FechaAjuste"];
									$FechaFinalAjuste  = $_POST["FechaFinalAjuste"];

									$Contador = count($CodigoProducto);
									$BodegaCod = $_POST["BodegaCod"];
									$FechaCod = $_POST["FechaCod"];



									//TIPO 1 = NOTA DE ABONO
									$SqlCargo = mysqli_query($db, "INSERT INTO Bodega.AJUSTE_BODEGA_TEMPORAL (ABT_CODIGO, CIF_CODIGO, ABT_TIPO, ABT_USUARIO, ABT_FECHA, ABT_HORA, ABT_ESTADO)
															VALUES ('".$UIA."', '".$CodigoTransaccion."', 1, ".$id_user.", CURRENT_DATE(), CURRENT_TIME(), 0)") or die('Cod 1'.mysqli_error($sql));

									//TIPO 2 = NOTA DE CARGO
									$SqlAbono = mysqli_query($db, "INSERT INTO Bodega.AJUSTE_BODEGA_TEMPORAL (ABT_CODIGO, CIF_CODIGO, ABT_TIPO, ABT_USUARIO, ABT_FECHA, ABT_HORA, ABT_ESTADO)
															VALUES ('".$UIC."', '".$CodigoTransaccion."', 2, ".$id_user.", CURRENT_DATE(), CURRENT_TIME(), 0)") or die('Cod 2'.mysqli_error($sql));


									$QueryEncabezado = "SELECT * FROM Bodega.CONTEO_INVENTARIO_FISICO WHERE CIF_CODIGO = '".$Codigo."'";
									$ResultEncabezado = mysqli_query($db, $QueryEncabezado);
									$FilaEncabezado = mysqli_fetch_array($ResultEncabezado);

									$FechaConteo   = $FilaEncabezado["CIF_FECHA"];
									$Periodo       = $FilaEncabezado["PC_CODIGO"];
									$Observaciones = $FilaEncabezado["CIF_OBSERVACIONES"];
									$Codigo        = $FilaEncabezado["CIF_CODIGO"];
									$FechaInicio   = $FilaEncabezado["CIF_FECHA_INICIO"];
									$FechaFin      = $FilaEncabezado["CIF_FECHA_FIN"];
									$Bodega        = $FilaEncabezado["B_CODIGO"];


									$QueryCuentas = "SELECT CONTEO_INVENTARIO_FISICO_DETALLE.*, UNIDAD_MEDIDA.UM_NOMBRE, PRODUCTO.P_NOMBRE 
														FROM Bodega.CONTEO_INVENTARIO_FISICO_DETALLE, Bodega.PRODUCTO, Bodega.UNIDAD_MEDIDA
														WHERE CONTEO_INVENTARIO_FISICO_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
														AND PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
														AND CONTEO_INVENTARIO_FISICO_DETALLE.CIF_CODIGO = '".$Codigo."'";
										$ResultCuentas = mysqli_query($db, $QueryCuentas);
										while($row = mysqli_fetch_array($ResultCuentas))
										{
											$ExistenciaMost = 0;
											$Producto       = $row["P_CODIGO"];
											$ProductoNombre = $row["P_NOMBRE"];
											$UnidadMedida   = $row["UM_NOMBRE"];
											$Cantidad       = $row["CIFD_CANTIDAD_FISICO"];

											
													$QueryInventario = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_PRODUCTO) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_PRODUCTO) AS ABONOS
									      								FROM Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION
									      								WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
									                                    AND TRANSACCION.B_CODIGO = ".$Bodega." 
									                                    AND TRANSACCION_DETALLE.P_CODIGO = ".$Producto."
									                                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'";
									                $ResultInventario = mysqli_query($db, $QueryInventario);
									                $Row = mysqli_fetch_array($ResultInventario);

									                $Existencia = $Row["CARGOS"] - $Row["ABONOS"];

									                if ($Existencia!="") 
									                {
									                	$Existencia = $Existencia;
									                }
									                else
									                {
									                	$Existencia = 0;
									                }

									                $Diferencia = $Cantidad - $Existencia;
													 
									                $QueryCosto = "SELECT SUM(`TRANSACCION_DETALLE`.`TRAD_SUBTOTAL`) AS COSTO_TOTAL, SUM(`TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO`) AS TOTAL_ENTRADAS
													                FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
													                WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
													                AND `TRANSACCION`.`B_CODIGO` = 4
													                AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
													                AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '2016/01/01' AND '".$FechaFin."'";
							            $ResCosto = mysqli_query($db, $QueryCosto);
							            while($filacosto = mysqli_fetch_array($ResCosto))
							            {
							                $CostoTotal = $filacosto["COSTO_TOTAL"];
							                $Entradas = $filacosto["TOTAL_ENTRADAS"];
							            }

							            if($Entradas != 0)
							            {
							            	$CostoUnitario = $CostoTotal / $Entradas;	
							            }
							            else
							            {
							            	$CostoUnitario = 0;
							            }


										 if($Diferencia < 0)
										{
											$SqlAbonoDetalle = mysqli_query($db, "INSERT INTO Bodega.AJUSTE_BODEGA_TEMPORAL_DETALLE (ABTD_CODIGO, ABT_CODIGO, P_CODIGO, ABTD_AJUSTE)
												VALUES ('".$UIAD."', '".$UIA."', ".$Producto.", ".$Diferencia.")") or die('Cod 3'.mysqli_error($sql));
										}
										elseif($Diferencia > 0)
										{
											$SqlCargoDetalle = mysqli_query($db, "INSERT INTO Bodega.AJUSTE_BODEGA_TEMPORAL_DETALLE (ABTD_CODIGO, ABT_CODIGO, P_CODIGO, ABTD_AJUSTE, ABTD_COSTO)
												VALUES ('".$UICD."', '".$UIC."', ".$Producto.", ".$Diferencia.", ".$CostoUnitario.")") or die('Cod 4'.mysqli_error($sql));
										} 

								}        
 
 

									/******************************************************************/
									/***********************  NOTA DE ABONO  **************************/
									/******************************************************************/

									$QueryAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, TRA_AJUSTE_CUADRADORA)
																VALUES('".$CodigoUnicoNotaAbono."', '".$FechaCod."', 'Ajuste Automático',  CURRENT_DATE(), CURRENT_TIME(), 31121, 1, 6, '".$BodegaCod."', 1)") or die('Cod 5'.mysqli_error($sql));

									$QueryAjustesAbono = "SELECT AJUSTE_BODEGA_TEMPORAL_DETALLE.* 
														FROM Bodega.AJUSTE_BODEGA_TEMPORAL_DETALLE, Bodega.AJUSTE_BODEGA_TEMPORAL
														WHERE AJUSTE_BODEGA_TEMPORAL_DETALLE.ABT_CODIGO = AJUSTE_BODEGA_TEMPORAL.ABT_CODIGO
														AND AJUSTE_BODEGA_TEMPORAL.CIF_CODIGO = '".$CodigoTransaccion."'
														AND AJUSTE_BODEGA_TEMPORAL.ABT_TIPO = 1";
									$RestulAjustesAbono = mysqli_query($db, $QueryAjustesAbono) or die('Cod 6'.mysqli_error($sql));
									while($RowAbono = mysqli_fetch_array($RestulAjustesAbono))
									{
										$Prod = $RowAbono["P_CODIGO"];
										$Cant = ($RowAbono["ABTD_AJUSTE"]) * (-1);
										$InsertAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
											VALUES('".$CodigoUnicoNotaAbonoDetalle."', '".$CodigoUnicoNotaAbono."', ".$Prod.", ".$Cant.")") or die('Cod 7'.mysqli_error($sql));
									}


									/******************************************************************/
									/***********************  NOTA DE CARGO  **************************/
									/******************************************************************/

									$QueryCargo = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, TRA_AJUSTE_CUADRADORA)
																VALUES('".$CodigoUnicoNotaCargo."', '".$FechaCod."', 'Ajuste Automático',  CURRENT_DATE(), CURRENT_TIME(), 31121, 1, 7, '".$BodegaCod."', 1)") or die('Cod 8'.mysqli_error($sql));

									$QueryAjustesCargo = "SELECT AJUSTE_BODEGA_TEMPORAL_DETALLE.* 
														FROM Bodega.AJUSTE_BODEGA_TEMPORAL_DETALLE, Bodega.AJUSTE_BODEGA_TEMPORAL
														WHERE AJUSTE_BODEGA_TEMPORAL_DETALLE.ABT_CODIGO = AJUSTE_BODEGA_TEMPORAL.ABT_CODIGO
														AND AJUSTE_BODEGA_TEMPORAL.CIF_CODIGO = '".$CodigoTransaccion."'
														AND AJUSTE_BODEGA_TEMPORAL.ABT_TIPO = 2";
									$RestulAjustesCargo = mysqli_query($db, $QueryAjustesCargo) or die('Cod 9'.mysqli_error($sql));
									while($RowCargo = mysqli_fetch_array($RestulAjustesCargo))
									{
										$Prod = $RowCargo["P_CODIGO"];
										$Cant = $RowCargo["ABTD_AJUSTE"];
										$Cost = $RowCargo["ABTD_COSTO"];

										$SubTot = $Cant * $Cost;


										$InsertAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_CARGO_PRODUCTO, TRAD_PRECIO_UNITARIO, TRAD_SUBTOTAL)
											VALUES('".$CodigoUnicoNotaCargoDetalle."', '".$CodigoUnicoNotaCargo."', ".$Prod.", ".$Cant.", ".$Cost.", ".$SubTot.")") or die('Cod 10'.mysqli_error($sql));
									}

									$sqlupdate = mysqli_query($db, "UPDATE Bodega.CONTEO_INVENTARIO_FISICO SET CIF_ESTADO = 1 WHERE CIF_CODIGO = '".$CodigoTransaccion."'") or die('Cod 11'.mysqli_error($sql));


									echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
									<h2 class="text-light">Los ajustes realizaron correctamente.</h2>';
								?>
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
