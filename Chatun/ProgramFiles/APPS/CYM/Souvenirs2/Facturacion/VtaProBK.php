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

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<!-- END STYLESHEETS -->

	<script>
		function Imprimir()
		{
			var Cod = document.getElementById('CodigoFactura').value;

			window.open('FactImp.php?Codigo='+Cod, '_blank');
			
		}

	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin " onload="Imprimir()">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
		<?php
			$UI        = uniqid("tra_");
			$UID       = uniqid("trad_");
			$Uid       = uniqid("F_");
			$UidD      = uniqid("FD_");
			$Centinela = true;
			$Contador  = count($_POST["ProductoNombre"]);

			$TipoPago                 = $_POST["TipoPago"];
			$FacturaSerie             = $_POST["FacturaSerie"];
			$FacturaNumero            = $_POST["FacturaNumero"];
			$Fecha                    = $_POST["Fecha"];
			$NumeroOrden              = $_POST["NumeroOrden"];
			$ClienteRegistrado        = $_POST["ClienteRegistrado"];			
			$DescuentoCodigo          = $_POST["DescuentoCodigo"];
			$TotalFacturaConDescuento = $_POST["TotalFacturaConDescuento"];
			$TotalFacturaFinal        = $_POST["TotalFacturaFinal"];
			$TipoMoneda               = $_POST["MonedaPagoInput"];
			$Observaciones 			  = $_POST["Direccion"];
			$NumeroResolucion 	      = $_POST["NumeroResolucion"];

			if($TipoPago == 1)
			{
				if($TipoMoneda == 1)
				{
					$Efectivo = $_POST["TotalEfectivo"];
					$Cambio   = $_POST["Cambio"];
				}
				elseif($TipoMoneda == 2)
				{
					$Efectivo = $_POST["TotalEfectivoDolares"];
					$Cambio   = $_POST["CambioDolaresQuetzalizados"];
				}
				elseif($TipoMoneda == 3)
				{
					$Efectivo = $_POST["TotalEfectivoLempira"];
					$Cambio   = $_POST["CambioLempirasQuetzalizados"];
				}
			}

			echo '<input type="hidden" id="CodigoFactura" value="'.$Uid.'" />';

			$Cantidad = $_POST["Cantidad"];
			$Producto = $_POST["ProductoNombre"];
			$Precio   = $_POST["Precio"];
			$SubTotal = $_POST["SubTotal"];

			//Si el número de NIT NO esta registrado
			//Se crea un nuevo cliente con los datos ingresados anteriormente
			if($ClienteRegistrado == 2)
			{
				$NIT       = $_POST["NIT"];
				$Nombre    = strtoupper($_POST["Nombre"]);
				$Direccion = strtoupper($_POST["Direccion"]);

				$sql = mysqli_query($db, "INSERT INTO Bodega.CLIENTE (CLI_NIT, CLI_NOMBRE, CLI_DIRECCION) VALUES ('".$NIT."', '".$Nombre."', '".$Direccion."')") or die(mysqli_error());

				if(!$sql)
				{
					echo 'ERROR EN INGRESO DE CLIENTE';
					
				}
			}
			//Si el Número de NIT ya está registrado
			//Solo toma el número de NIT para almacenarlo
			else
			{
				$NIT       = $_POST["NIT"];
			}


			//Si el tipo de pago fue en EFECTIVO
			if($TipoPago == 1)
			{
				$Moneda = $_POST["MonedaPagoInput"];
				
				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_SV_2 (F_CODIGO, F_ORDEN, F_SERIE, F_NUMERO, F_TIPO, CLI_NIT, D_CODIGO, F_CON_DESCUENTO, F_TOTAL, F_FECHA_TRANS, F_HORA, F_USUARIO, F_MONEDA, F_EFECTIVO, F_CAMBIO, F_OBSERVACIONES, RES_NUMERO)
												VALUES ('".$Uid."', ".$NumeroOrden.", '".$FacturaSerie."', ".$FacturaNumero.", 1, '".$NIT."', ".$DescuentoCodigo.", ".$TotalFacturaConDescuento.", ".$TotalFacturaFinal.",  CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.", ".$Moneda.", ".$Efectivo.", ".$Cambio.", '".$Observaciones."', '".$NumeroResolucion."')") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Souvenirs Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 10, 2, '".$Uid."')");

				if(!$QueryEncabezado)
				{
					echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
							<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
							<h4 class="text-light">Código de transacción: '.$UID.'</h4>
						</div>';
					echo mysqli_error($query);
					$Centinela = false;
					
				}
				else
				{
					for($i=1; $i<$Contador; $i++)
					{
						$Can = $Cantidad[$i];
						$Pro = $Producto[$i];
						$Pre = $Precio[$i];
						$Sub = $SubTotal[$i];

						$ProductoXplotado = explode("/", $Pro);

						$Prod = $ProductoXplotado[0];

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_SV_2_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', ".$Can.", ".$Prod.", ".$Pre.", ".$Sub.")");

						

						if($Prod != 350 && $Prod != 320 && $Prod != 310 && $Prod != 351 && $Prod != 352 && $Prod != 307 && $Prod != 311 && $Prod != 312 && $Prod != 308 && $Prod != 309 && $Prod != 318)					
						{
							$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
											  			VALUES('".$UID."', '".$UI."', ".$Prod.", ".$Can.")");
						}

						
					}

					/****************************************************************************************
					*****************************************************************************************
					*									PARTIDA CONTABLE 								    *
					*****************************************************************************************
					****************************************************************************************/

					$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
					$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

					$Mes = date('m', strtotime('now'));
					$Anho = date('Y', strtotime('now'));

					$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE MONTH( TRA_FECHA_TRANS ) = ".$Mes." AND YEAR( TRA_FECHA_TRANS ) = ".$Anho;
					$resultCorrelativo = mysqli_query($db, $queryCorrelativo);
					while($rowC = mysqli_fetch_array($resultCorrelativo))
					{	
						if($rowC["CORRELATIVO"] == 0)
						{
							$Correlativo = 1;
						}
						else
						{
							$Correlativo = $rowC["CORRELATIVO"] + 1;
						}
					}

					$QuerySaberPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = ".$Mes." AND PC_ANHO = ".$Anho;
					$ResultSaberPeriodo = mysqli_query($db, $QuerySaberPeriodo);
					while($FilaSaberPeriodo = mysqli_fetch_array($ResultSaberPeriodo))
					{
						$Periodo = $FilaSaberPeriodo["PC_CODIGO"];
					}

					$SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SERIE, TRA_FACTURA, TRA_TOTAL, RES_NUMERO, TRA_CORRELATIVO, PC_CODIGO)
											 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Restaurant Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 8, '".$FacturaSerie."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());


					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.01.001', ".$TotalFacturaFinal.", 0.00)");

					$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".$IVADebito.")");

					$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.001', 0.00, ".$VentaSinIVA.")");
				}

				if($Centinela == true)
				{
					echo '<div class="col-lg-12 text-center">
					<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
					<h2 class="text-light">La factura se ingresó correctamente.</h2>
					<div class="row">
						<a href="Vta.php">
							<button type="button" class="btn btn-success btn-lg">
								<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
							</button>
						</a>
					</div>';
				}
			}
			elseif($TipoPago == 2)
			{
				$NumeroAutorizacionTXT = $_POST["NumeroAutorizacionTXT"];
				
				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_SV_2 (F_CODIGO, F_ORDEN, F_SERIE, F_NUMERO, F_TIPO, CLI_NIT, D_CODIGO, F_CON_DESCUENTO, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_OBSERVACIONES, F_NO_AUTORIZACION, RES_NUMERO)
												VALUES ('".$Uid."', ".$NumeroOrden.", '".$FacturaSerie."', ".$FacturaNumero.", 2, '".$NIT."', ".$DescuentoCodigo.", ".$TotalFacturaConDescuento.", ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.", '".$Observaciones."', '".$NumeroAutorizacionTXT."', '".$NumeroResolucion."')");

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Souvenirs Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 10, 2, '".$Uid."')");

				if(!$QueryEncabezado)
				{
					echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
							<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
							<h4 class="text-light">Código de transacción: '.$UID.'</h4>
						</div>';
					echo mysqli_error($query);
					$Centinela = false;
					
				}
				else
				{
					for($i=1; $i<$Contador; $i++)
					{
						$Can = $Cantidad[$i];
						$Pro = $Producto[$i];
						$Pre = $Precio[$i];
						$Sub = $SubTotal[$i];

						$ProductoXplotado = explode("/", $Pro);

						$Prod = $ProductoXplotado[0];

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_SV_2_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', ".$Can.", ".$Prod.", ".$Pre.", ".$Sub.")");

					
						if($Prod != 350 && $Prod != 320 && $Prod != 310 && $Prod != 351 && $Prod != 352 && $Prod != 307 && $Prod != 311 && $Prod != 312 && $Prod != 308 && $Prod != 309 && $Prod != 318)					
						{
							$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
											  			VALUES('".$UID."', '".$UI."', ".$Prod.", ".$Can.")");
						}						
					}

					/****************************************************************************************
					*****************************************************************************************
					*									PARTIDA CONTABLE 								    *
					*****************************************************************************************
					****************************************************************************************/

					$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
					$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

					$Mes = date('m', strtotime('now'));
					$Anho = date('Y', strtotime('now'));

					$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE MONTH( TRA_FECHA_TRANS ) = ".$Mes." AND YEAR( TRA_FECHA_TRANS ) = ".$Anho;
					$resultCorrelativo = mysqli_query($db, $queryCorrelativo);
					while($rowC = mysqli_fetch_array($resultCorrelativo))
					{	
						if($rowC["CORRELATIVO"] == 0)
						{
							$Correlativo = 1;
						}
						else
						{
							$Correlativo = $rowC["CORRELATIVO"] + 1;
						}
					}

					$QuerySaberPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = ".$Mes." AND PC_ANHO = ".$Anho;
					$ResultSaberPeriodo = mysqli_query($db, $QuerySaberPeriodo);
					while($FilaSaberPeriodo = mysqli_fetch_array($ResultSaberPeriodo))
					{
						$Periodo = $FilaSaberPeriodo["PC_CODIGO"];
					}

					$SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SERIE, TRA_FACTURA, TRA_TOTAL, RES_NUMERO, TRA_CORRELATIVO, PC_CODIGO)
											 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Restaurant Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 8, '".$FacturaSerie."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());


					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.006', ".$TotalFacturaFinal.", 0.00)");

					$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".$IVADebito.")");

					$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.001', 0.00, ".$VentaSinIVA.")");
				}

				if($Centinela == true)
				{
					echo '<div class="col-lg-12 text-center">
					<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
					<h2 class="text-light">La factura se ingresó correctamente.</h2>
					<div class="row">
						<a href="Vta.php">
							<button type="button" class="btn btn-success btn-lg">
								<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
							</button>
						</a>
					</div>';
				}
			}
			elseif($TipoPago == 3)
			{
				$NombreCredito = $_POST["NombreCreditoTXT"];

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_SV_2 (F_CODIGO, F_ORDEN, F_SERIE, F_NUMERO, F_TIPO, CLI_NIT, D_CODIGO, F_CON_DESCUENTO, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_NOMBRE_CREDITO, F_OBSERVACIONES, RES_NUMERO)
												VALUES ('".$Uid."', ".$NumeroOrden.", '".$FacturaSerie."', ".$FacturaNumero.", 3, '".$NIT."', ".$DescuentoCodigo.", ".$TotalFacturaConDescuento.", ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.",  '".$NombreCredito."', '".$Observaciones."', '".$NumeroResolucion."')") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Souvenirs Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 10, 2, '".$Uid."')");

				if(!$QueryEncabezado)
				{
					echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
							<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
							<h4 class="text-light">Código de transacción: '.$UID.'</h4>
						</div>';
					echo mysqli_error($query);
					$Centinela = false;
					
				}
				else
				{
					for($i=1; $i<$Contador; $i++)
					{
						$Can = $Cantidad[$i];
						$Pro = $Producto[$i];
						$Pre = $Precio[$i];
						$Sub = $SubTotal[$i];

						$ProductoXplotado = explode("/", $Pro);

						$Prod = $ProductoXplotado[0];

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_SV_2_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', ".$Can.", ".$Prod.", ".$Pre.", ".$Sub.")");

					
						if($Prod != 350 && $Prod != 320 && $Prod != 310 && $Prod != 351 && $Prod != 352 && $Prod != 307 && $Prod != 311 && $Prod != 312 && $Prod != 308 && $Prod != 309 && $Prod != 318)					
						{
							$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
											  			VALUES('".$UID."', '".$UI."', ".$Prod.", ".$Can.")");
						}
						
					}

					/****************************************************************************************
					*****************************************************************************************
					*									PARTIDA CONTABLE 								    *
					*****************************************************************************************
					****************************************************************************************/

					$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
					$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

					$Mes = date('m', strtotime('now'));
					$Anho = date('Y', strtotime('now'));

					$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE MONTH( TRA_FECHA_TRANS ) = ".$Mes." AND YEAR( TRA_FECHA_TRANS ) = ".$Anho;
					$resultCorrelativo = mysqli_query($db, $queryCorrelativo);
					while($rowC = mysqli_fetch_array($resultCorrelativo))
					{	
						if($rowC["CORRELATIVO"] == 0)
						{
							$Correlativo = 1;
						}
						else
						{
							$Correlativo = $rowC["CORRELATIVO"] + 1;
						}
					}

					$QuerySaberPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = ".$Mes." AND PC_ANHO = ".$Anho;
					$ResultSaberPeriodo = mysqli_query($db, $QuerySaberPeriodo);
					while($FilaSaberPeriodo = mysqli_fetch_array($ResultSaberPeriodo))
					{
						$Periodo = $FilaSaberPeriodo["PC_CODIGO"];
					}

					$SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SERIE, TRA_FACTURA, TRA_TOTAL, RES_NUMERO, TRA_CORRELATIVO, PC_CODIGO)
											 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Restaurant Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 8, '".$FacturaSerie."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());


					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.002', ".$TotalFacturaFinal.", 0.00)");

					$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".$IVADebito.")");

					$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.001', 0.00, ".$VentaSinIVA.")");
				}

				if($Centinela == true)
				{
					echo '<div class="col-lg-12 text-center">
					<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
					<h2 class="text-light">La factura se ingresó correctamente.</h2>
					<div class="row">
						<a href="Vta.php">
							<button type="button" class="btn btn-success btn-lg">
								<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
							</button>
						</a>
					</div>';
				}
			}
			elseif($TipoPago == 4)
			{
				$NumeroBoleta = $_POST["NumeroBoleta"];
				$CuentaBancaria = $_POST["CuentaBancaria"];
				
				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_SV_2 (F_CODIGO, F_ORDEN, F_SERIE, F_NUMERO, F_TIPO, CLI_NIT, D_CODIGO, F_CON_DESCUENTO, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_NO_BOLETA, F_OBSERVACIONES, RES_NUMERO, F_CUENTA_BANCARIA)
												VALUES ('".$Uid."', ".$NumeroOrden.", '".$FacturaSerie."', ".$FacturaNumero.", 4, '".$NIT."', ".$DescuentoCodigo.", ".$TotalFacturaConDescuento.", ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.",  '".$NumeroBoleta."', '".$Observaciones."', '".$NumeroResolucion."', '".$CuentaBancaria."')") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Souvenirs Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 10, 2, '".$Uid."')");

				if(!$QueryEncabezado)
				{
					echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
							<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
							<h4 class="text-light">Código de transacción: '.$UID.'</h4>
						</div>';
					echo mysqli_error($query);
					$Centinela = false;
					
				}
				else
				{
					for($i=1; $i<$Contador; $i++)
					{
						$Can = $Cantidad[$i];
						$Pro = $Producto[$i];
						$Pre = $Precio[$i];
						$Sub = $SubTotal[$i];

						$ProductoXplotado = explode("/", $Pro);

						$Prod = $ProductoXplotado[0];

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_SV_2_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', ".$Can.", ".$Prod.", ".$Pre.", ".$Sub.")");

					
						if($Prod != 350 && $Prod != 320 && $Prod != 310 && $Prod != 351 && $Prod != 352 && $Prod != 307 && $Prod != 311 && $Prod != 312 && $Prod != 308 && $Prod != 309 && $Prod != 318)					
						{
							$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
											  			VALUES('".$UID."', '".$UI."', ".$Prod.", ".$Can.")");
						}
						
					}

					/****************************************************************************************
					*****************************************************************************************
					*									PARTIDA CONTABLE 								    *
					*****************************************************************************************
					****************************************************************************************/

					$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
					$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

					$Mes = date('m', strtotime('now'));
					$Anho = date('Y', strtotime('now'));

					$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE MONTH( TRA_FECHA_TRANS ) = ".$Mes." AND YEAR( TRA_FECHA_TRANS ) = ".$Anho;
					$resultCorrelativo = mysqli_query($db, $queryCorrelativo);
					while($rowC = mysqli_fetch_array($resultCorrelativo))
					{	
						if($rowC["CORRELATIVO"] == 0)
						{
							$Correlativo = 1;
						}
						else
						{
							$Correlativo = $rowC["CORRELATIVO"] + 1;
						}
					}

					$QuerySaberPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = ".$Mes." AND PC_ANHO = ".$Anho;
					$ResultSaberPeriodo = mysqli_query($db, $QuerySaberPeriodo);
					while($FilaSaberPeriodo = mysqli_fetch_array($ResultSaberPeriodo))
					{
						$Periodo = $FilaSaberPeriodo["PC_CODIGO"];
					}

					$SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SERIE, TRA_FACTURA, TRA_TOTAL, RES_NUMERO, TRA_CORRELATIVO, PC_CODIGO)
											 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Restaurant Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 8, '".$FacturaSerie."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());


					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '".$CuentaBancaria."', ".$TotalFacturaFinal.", 0.00)");

					$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".$IVADebito.")");

					$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.001', 0.00, ".$VentaSinIVA.")");
				}

				if($Centinela == true)
				{
					echo '<div class="col-lg-12 text-center">
					<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
					<h2 class="text-light">La factura se ingresó correctamente.</h2>
					<div class="row">
						<a href="Vta.php">
							<button type="button" class="btn btn-success btn-lg">
								<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
							</button>
						</a>
					</div>';
				}
			}


		?>
		</div><!--end #content-->
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>


	</div><!--end #base-->
	<!-- END BASE -->

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
	<script src="../../../../../js/core/demo/DemoFormWizard.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/additional-methods.min.js"></script>
	<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>
	<!-- END JAVASCRIPT -->

</body>
</html>
