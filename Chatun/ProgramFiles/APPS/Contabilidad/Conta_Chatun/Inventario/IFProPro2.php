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


									//TIPO 1 = NOTA DE ABONO
									$SqlCargo = mysqli_query($db, "INSERT INTO Bodega.AJUSTE_BODEGA_TEMPORAL (ABT_CODIGO, CIF_CODIGO, ABT_TIPO, ABT_USUARIO, ABT_FECHA, ABT_HORA, ABT_ESTADO)
															VALUES ('".$UIA."', '".$CodigoTransaccion."', 1, ".$id_user.", CURRENT_DATE(), CURRENT_TIME(), 0)") or die('Cod 1'.mysqli_error());

									//TIPO 2 = NOTA DE CARGO
									$SqlAbono = mysqli_query($db, "INSERT INTO Bodega.AJUSTE_BODEGA_TEMPORAL (ABT_CODIGO, CIF_CODIGO, ABT_TIPO, ABT_USUARIO, ABT_FECHA, ABT_HORA, ABT_ESTADO)
															VALUES ('".$UIC."', '".$CodigoTransaccion."', 2, ".$id_user.", CURRENT_DATE(), CURRENT_TIME(), 0)") or die('Cod 2'.mysqli_error());

									for($i=0; $i<$Contador; $i++)
									{
										if($Diferencia[$i] < 0)
										{
											$SqlAbonoDetalle = mysqli_query($db, "INSERT INTO Bodega.AJUSTE_BODEGA_TEMPORAL_DETALLE (ABTD_CODIGO, ABT_CODIGO, P_CODIGO, ABTD_AJUSTE)
												VALUES ('".$UIAD."', '".$UIA."', ".$CodigoProducto[$i].", ".$Diferencia[$i].")") or die('Cod 3'.mysqli_error());
										}
										elseif($Diferencia[$i] > 0)
										{
											$SqlCargoDetalle = mysqli_query($db, "INSERT INTO Bodega.AJUSTE_BODEGA_TEMPORAL_DETALLE (ABTD_CODIGO, ABT_CODIGO, P_CODIGO, ABTD_AJUSTE, ABTD_COSTO)
												VALUES ('".$UICD."', '".$UIC."', ".$CodigoProducto[$i].", ".$Diferencia[$i].", ".$Costo[$i].")") or die('Cod 4'.mysqli_error());
										}
									}


									/******************************************************************/
									/***********************  NOTA DE ABONO  **************************/
									/******************************************************************/

									$QueryAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, TRA_AJUSTE_CUADRADORA)
																VALUES('".$CodigoUnicoNotaAbono."', '2021-05-31', 'Ajuste Automático',  CURRENT_DATE(), CURRENT_TIME(), 31121, 1, 6, 2, 1)") or die('Cod 5'.mysqli_error());

									$QueryAjustesAbono = "SELECT AJUSTE_BODEGA_TEMPORAL_DETALLE.* 
														FROM Bodega.AJUSTE_BODEGA_TEMPORAL_DETALLE, Bodega.AJUSTE_BODEGA_TEMPORAL
														WHERE AJUSTE_BODEGA_TEMPORAL_DETALLE.ABT_CODIGO = AJUSTE_BODEGA_TEMPORAL.ABT_CODIGO
														AND AJUSTE_BODEGA_TEMPORAL.CIF_CODIGO = '".$CodigoTransaccion."'
														AND AJUSTE_BODEGA_TEMPORAL.ABT_TIPO = 1";
									$RestulAjustesAbono = mysqli_query($db, $QueryAjustesAbono) or die('Cod 6'.mysqli_error());
									while($RowAbono = mysqli_fetch_array($RestulAjustesAbono))
									{
										$Prod = $RowAbono["P_CODIGO"];
										$Cant = ($RowAbono["ABTD_AJUSTE"]) * (-1);
										$InsertAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
											VALUES('".$CodigoUnicoNotaAbonoDetalle."', '".$CodigoUnicoNotaAbono."', ".$Prod.", ".$Cant.")") or die('Cod 7'.mysqli_error());
									}


									/******************************************************************/
									/***********************  NOTA DE CARGO  **************************/
									/******************************************************************/

									$QueryCargo = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, TRA_AJUSTE_CUADRADORA)
																VALUES('".$CodigoUnicoNotaCargo."', '2021-05-31', 'Ajuste Automático',  CURRENT_DATE(), CURRENT_TIME(), 31121, 1, 7, 2, 1)") or die('Cod 8'.mysqli_error());

									$QueryAjustesCargo = "SELECT AJUSTE_BODEGA_TEMPORAL_DETALLE.* 
														FROM Bodega.AJUSTE_BODEGA_TEMPORAL_DETALLE, Bodega.AJUSTE_BODEGA_TEMPORAL
														WHERE AJUSTE_BODEGA_TEMPORAL_DETALLE.ABT_CODIGO = AJUSTE_BODEGA_TEMPORAL.ABT_CODIGO
														AND AJUSTE_BODEGA_TEMPORAL.CIF_CODIGO = '".$CodigoTransaccion."'
														AND AJUSTE_BODEGA_TEMPORAL.ABT_TIPO = 2";
									$RestulAjustesCargo = mysqli_query($db, $QueryAjustesCargo) or die('Cod 9'.mysqli_error());
									while($RowCargo = mysqli_fetch_array($RestulAjustesCargo))
									{
										$Prod = $RowCargo["P_CODIGO"];
										$Cant = $RowCargo["ABTD_AJUSTE"];
										$Cost = $RowCargo["ABTD_COSTO"];

										$SubTot = $Cant * $Cost;


										$InsertAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_CARGO_PRODUCTO, TRAD_PRECIO_UNITARIO, TRAD_SUBTOTAL)
											VALUES('".$CodigoUnicoNotaCargoDetalle."', '".$CodigoUnicoNotaCargo."', ".$Prod.", ".$Cant.", ".$Cost.", ".$SubTot.")") or die('Cod 10'.mysqli_error());
									}

									$sqlupdate = mysqli_query($db, "UPDATE Bodega.CONTEO_INVENTARIO_FISICO SET CIF_ESTADO = 1 WHERE CIF_CODIGO = '".$CodigoTransaccion."'") or die('Cod 11'.mysqli_error());


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
