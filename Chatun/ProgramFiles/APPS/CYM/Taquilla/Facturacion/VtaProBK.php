<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
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
			$TotalTaquillaSinIVA = 0;


			$ConsultaSerie = "SELECT RES_SERIE, RES_NUMERO FROM Bodega.RESOLUCION WHERE RES_ESTADO = 1 AND RES_TIPO = 'TQ'";
			$ResultSerie = mysqli_query($db, $ConsultaSerie) or die(mysqli_error());
			while($fila = mysqli_fetch_array($ResultSerie))
			{
				$FacturaSerie = $fila["RES_SERIE"];
				$NumeroResolucion = $fila["RES_NUMERO"];
			}

			$ConsultaNumeroFactura = "SELECT F_NUMERO FROM Bodega.FACTURA_TQ WHERE F_SERIE = '".$FacturaSerie."' ORDER BY F_NUMERO DESC LIMIT 1";
			$ResultNumeroFactura = mysqli_query($db, $ConsultaNumeroFactura) or die(mysqli_error());
			$RegistrosNumeroFactura = mysqli_num_rows($ResultNumeroFactura);
			if($RegistrosNumeroFactura == 0)
			{
				$ConsultaNumeroFacturaInicial = "SELECT RES_DEL FROM Bodega.RESOLUCION WHERE RES_ESTADO = 1 AND RES_TIPO = 'TQ'";
				$ResultNumeroFacturaInicial = mysqli_query($db, $ConsultaNumeroFacturaInicial) or die(mysqli_error());
				while($filaFacturaInicial = mysqli_fetch_array($ResultNumeroFacturaInicial))
				{
					$FacturaNumero = $filaFacturaInicial["RES_DEL"];
				}
			}
			else
			{
				while($filaFactura = mysqli_fetch_array($ResultNumeroFactura))
				{
					$FacturaNumero = $filaFactura["F_NUMERO"] + 1;
				}
			}


			$UI        = uniqid("tra_");
			$UID       = uniqid("trad_");
			$Uid       = uniqid("F_");
			$UidD      = uniqid("FD_");
			$Centinela = true;
			$Contador  = count($_POST["Cantidad"]);

			$TipoPago                 = $_POST["TipoPago"];
			$Fecha                    = $_POST["Fecha"];
			$ClienteRegistrado        = $_POST["ClienteRegistrado"];			
			$DescuentoCodigo          = $_POST["DescuentoCodigo"];
			$TotalFacturaConDescuento = $_POST["TotalFacturaConDescuento"];
			$TotalFacturaFinal        = $_POST["TotalFacturaFinal"];
			$TipoMoneda               = $_POST["MonedaPagoInput"];
			$Observaciones 			  = $_POST["Direccion"];

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

			$Cantidad       = $_POST["Cantidad"];
			$Producto       = $_POST["Producto"];
			$Precio         = $_POST["Precio"];
			$SubTotal       = $_POST["SubTotal"];
			$ProductoNombre = $_POST["ProductoNombre"];
			$TipoProducto = $_POST["TipoProducto"];

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

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ (F_CODIGO, F_SERIE, F_NUMERO, F_TIPO, CLI_NIT, D_CODIGO, F_CON_DESCUENTO, F_TOTAL, F_FECHA_TRANS, F_HORA, F_USUARIO, F_MONEDA, F_EFECTIVO, F_CAMBIO, F_OBSERVACIONES, RES_NUMERO)
												VALUES ('".$Uid."', '".$FacturaSerie."', ".$FacturaNumero.", 1, '".$NIT."', ".$DescuentoCodigo.", ".$TotalFacturaConDescuento.", ".$TotalFacturaFinal.", CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user.", ".$Moneda.", ".$Efectivo.", ".$Cambio.", '".$Observaciones."', '".$NumeroResolucion."')") or die('Encabezado Factura 1'.mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Taquilla Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 11, 1, '".$Uid."')") or die('Encabezado Bodega 1 '.mysqli_error());

				/****************************************************************************************
				*****************************************************************************************
				*									PARTIDA CONTABLE 								    *
				*****************************************************************************************
				****************************************************************************************/

				$Mes = date('m', strtotime('now'));
				$Anho = date('Y', strtotime('now'));

				$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
				$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

				

				$QuerySaberPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = ".$Mes." AND PC_ANHO = ".$Anho;
				$ResultSaberPeriodo = mysqli_query($db, $QuerySaberPeriodo) or die(mysqli_error());
				while($FilaSaberPeriodo = mysqli_fetch_array($ResultSaberPeriodo))
				{
					$Periodo = $FilaSaberPeriodo["PC_CODIGO"];
				}

				$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE MONTH( TRA_FECHA_TRANS ) = ".$Mes." AND YEAR( TRA_FECHA_TRANS ) = ".$Anho." AND PC_CODIGO = ".$Periodo;
				$resultCorrelativo = mysqli_query($db, $queryCorrelativo) or die(mysqli_error());
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

				$SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SERIE, TRA_FACTURA, TRA_TOTAL, RES_NUMERO, TRA_CORRELATIVO, PC_CODIGO)
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Taquilla Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 9, '".$FacturaSerie."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die('Encabezado Conta 1'.mysqli_error());

				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.01.004', ".$TotalFacturaFinal.", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".$IVADebito.")");

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
					for($i=0; $i<$Contador; $i++)
					{
						$Can = $Cantidad[$i];
						$Pro = $Producto[$i];
						$Pre = $Precio[$i];
						$Sub = $SubTotal[$i];
						$Tip = $TipoProducto[$i];

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', '".$Can."', '".$Pro."', '".$Pre."', '".$Sub."')") or die('Error Factura TQ Detalle '.mysqli_error());

						if($Tip == 2)
						{
							$ConsultaProdReceta = "SELECT * FROM Bodega.RECETA_SUBRECETA_DETALLE WHERE RS_CODIGO = '".$Pro."'";
							$ResultProdReceta = mysqli_query($db, $ConsultaProdReceta) or die(mysqli_error());
							while($fila = mysqli_fetch_array($ResultProdReceta))
							{
								$TotalDescargo = $fila["RSD_CANTIDAD"] * $Can;
								$ProductoCodigo      = $fila["P_CODIGO"];

								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$ProductoCodigo.", ".$TotalDescargo.")") or die(mysqli_error());

								$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
								$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
								$PrecioProductoNeto = round($PrecioProductoNeto, 2);
							}						

							$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '4.01.03.006', 0.00, ".$PrecioProductoNeto.")");
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 2);

							if($Pro == 657)
							{
								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$Pro.", ".$Can.")") or die(mysqli_error());

								$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.003', 0.00, ".$PrecioProductoNeto.")");
							}
							else
							{

								if($Pro == 821)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 822)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 823)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 859)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.006', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 860)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 863)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.009', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 858)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.005', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 857)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.004', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 856)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 864)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 865)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 861)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 862)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 876)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 877)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 878)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 879)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 880)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.006', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 881)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 883)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 884)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 886)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 887)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 893)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 905)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".$PrecioProductoNeto.")");
								}
							}
						}
					}
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

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ (F_CODIGO, F_SERIE, F_NUMERO, F_TIPO, CLI_NIT, D_CODIGO, F_CON_DESCUENTO, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_OBSERVACIONES, F_NO_AUTORIZACION, RES_NUMERO)
												VALUES ('".$Uid."', '".$FacturaSerie."', ".$FacturaNumero.", 2, '".$NIT."', ".$DescuentoCodigo.", ".$TotalFacturaConDescuento.", ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.", '".$Observaciones."', '".$NumeroAutorizacionTXT."', '".$NumeroResolucion."')") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Taquilla Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 11, 1, '".$Uid."')") or die(mysqli_error());

				/****************************************************************************************
				*****************************************************************************************
				*									PARTIDA CONTABLE 								    *
				*****************************************************************************************
				****************************************************************************************/

				$Mes = date('m', strtotime('now'));
				$Anho = date('Y', strtotime('now'));

				$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
				$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

				

				$QuerySaberPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = ".$Mes." AND PC_ANHO = ".$Anho;
				$ResultSaberPeriodo = mysqli_query($db, $QuerySaberPeriodo) or die(mysqli_error());
				while($FilaSaberPeriodo = mysqli_fetch_array($ResultSaberPeriodo))
				{
					$Periodo = $FilaSaberPeriodo["PC_CODIGO"];
				}

				$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE MONTH( TRA_FECHA_TRANS ) = ".$Mes." AND YEAR( TRA_FECHA_TRANS ) = ".$Anho." AND PC_CODIGO = ".$Periodo;
				$resultCorrelativo = mysqli_query($db, $queryCorrelativo) or die(mysqli_error());
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

				$SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SERIE, TRA_FACTURA, TRA_TOTAL, RES_NUMERO, TRA_CORRELATIVO, PC_CODIGO)
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Taquilla Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 9, '".$FacturaSerie."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());

				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.006', ".$TotalFacturaFinal.", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".$IVADebito.")");

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
					for($i=0; $i<$Contador; $i++)
					{
						$Can = $Cantidad[$i];
						$Pro = $Producto[$i];
						$Pre = $Precio[$i];
						$Sub = $SubTotal[$i];
						$Tip = $TipoProducto[$i];

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', '".$Can."', '".$Pro."', '".$Pre."', '".$Sub."')") or die('Error Factura TQ Detalle '.mysqli_error());

						if($Tip == 2)
						{
							$ConsultaProdReceta = "SELECT * FROM Bodega.RECETA_SUBRECETA_DETALLE WHERE RS_CODIGO = '".$Pro."'";
							$ResultProdReceta = mysqli_query($db, $ConsultaProdReceta) or die(mysqli_error());
							while($fila = mysqli_fetch_array($ResultProdReceta))
							{
								$TotalDescargo = $fila["RSD_CANTIDAD"] * $Can;
								$ProductoCodigo      = $fila["P_CODIGO"];

								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$ProductoCodigo.", ".$TotalDescargo.")") or die(mysqli_error());

								$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
								$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
								$PrecioProductoNeto = round($PrecioProductoNeto, 2);
							}						

							$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '4.01.03.006', 0.00, ".$PrecioProductoNeto.")");
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 2);

							if($Pro == 657)
							{
								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$Pro.", ".$Can.")") or die(mysqli_error());

								$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.003', 0.00, ".$PrecioProductoNeto.")");
							}
							else
							{

								if($Pro == 821)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 822)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 823)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 859)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.006', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 860)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 863)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.009', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 858)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.005', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 857)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.004', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 856)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 864)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 865)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 861)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 862)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 876)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 877)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 878)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 879)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 880)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.006', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 881)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 883)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 884)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 886)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 887)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 893)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 905)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".$PrecioProductoNeto.")");
								}
							}
						}
					}
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

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ (F_CODIGO, F_SERIE, F_NUMERO, F_TIPO, CLI_NIT, D_CODIGO, F_CON_DESCUENTO, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_NOMBRE_CREDITO, F_OBSERVACIONES, RES_NUMERO)
												VALUES ('".$Uid."', '".$FacturaSerie."', ".$FacturaNumero.", 3, '".$NIT."', ".$DescuentoCodigo.", ".$TotalFacturaConDescuento.", ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.",  '".$NombreCredito."', '".$Observaciones."', '".$NumeroResolucion."')") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Taquilla Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 11, 1, '".$Uid."')") or die(mysqli_error());

				/****************************************************************************************
				*****************************************************************************************
				*									PARTIDA CONTABLE 								    *
				*****************************************************************************************
				****************************************************************************************/

				$Mes = date('m', strtotime('now'));
				$Anho = date('Y', strtotime('now'));

				$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
				$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

				

				$QuerySaberPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = ".$Mes." AND PC_ANHO = ".$Anho;
				$ResultSaberPeriodo = mysqli_query($db, $QuerySaberPeriodo) or die(mysqli_error());
				while($FilaSaberPeriodo = mysqli_fetch_array($ResultSaberPeriodo))
				{
					$Periodo = $FilaSaberPeriodo["PC_CODIGO"];
				}

				$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE MONTH( TRA_FECHA_TRANS ) = ".$Mes." AND YEAR( TRA_FECHA_TRANS ) = ".$Anho." AND PC_CODIGO = ".$Periodo;
				$resultCorrelativo = mysqli_query($db, $queryCorrelativo) or die(mysqli_error());
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

				$SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SERIE, TRA_FACTURA, TRA_TOTAL, RES_NUMERO, TRA_CORRELATIVO, PC_CODIGO)
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Taquilla Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 9, '".$FacturaSerie."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());

				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.01.004', ".$TotalFacturaFinal.", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".$IVADebito.")");

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
					for($i=0; $i<$Contador; $i++)
					{
						$Can = $Cantidad[$i];
						$Pro = $Producto[$i];
						$Pre = $Precio[$i];
						$Sub = $SubTotal[$i];
						$Tip = $TipoProducto[$i];

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', '".$Can."', '".$Pro."', '".$Pre."', '".$Sub."')") or die('Error Factura TQ Detalle '.mysqli_error());

						if($Tip == 2)
						{
							$ConsultaProdReceta = "SELECT * FROM Bodega.RECETA_SUBRECETA_DETALLE WHERE RS_CODIGO = '".$Pro."'";
							$ResultProdReceta = mysqli_query($db, $ConsultaProdReceta) or die(mysqli_error());
							while($fila = mysqli_fetch_array($ResultProdReceta))
							{
								$TotalDescargo = $fila["RSD_CANTIDAD"] * $Can;
								$ProductoCodigo      = $fila["P_CODIGO"];

								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$ProductoCodigo.", ".$TotalDescargo.")") or die(mysqli_error());

								$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
								$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
								$PrecioProductoNeto = round($PrecioProductoNeto, 2);
							}						

							$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '4.01.03.006', 0.00, ".$PrecioProductoNeto.")");
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 2);

							if($Pro == 657)
							{
								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$Pro.", ".$Can.")") or die(mysqli_error());

								$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.003', 0.00, ".$PrecioProductoNeto.")");
							}
							else
							{

								if($Pro == 821)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 822)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 823)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 859)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.006', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 860)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 863)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.009', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 858)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.005', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 857)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.004', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 856)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 864)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 865)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 861)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 862)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 876)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 877)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 878)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 879)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 880)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.006', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 881)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 883)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 884)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 886)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 887)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 893)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 905)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".$PrecioProductoNeto.")");
								}
							}
						}
					}
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

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ (F_CODIGO, F_SERIE, F_NUMERO, F_TIPO, CLI_NIT, D_CODIGO, F_CON_DESCUENTO, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_NO_BOLETA, F_OBSERVACIONES, RES_NUMERO, F_CUENTA_BANCARIA)
												VALUES ('".$Uid."', '".$FacturaSerie."', ".$FacturaNumero.", 4, '".$NIT."', ".$DescuentoCodigo.", ".$TotalFacturaConDescuento.", ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.",  '".$NumeroBoleta."', '".$Observaciones."', '".$NumeroResolucion."', '".$CuentaBancaria."')") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Taquilla Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 11, 1, '".$Uid."')") or die(mysqli_error());

				/****************************************************************************************
				*****************************************************************************************
				*									PARTIDA CONTABLE 								    *
				*****************************************************************************************
				****************************************************************************************/

				$Mes = date('m', strtotime('now'));
				$Anho = date('Y', strtotime('now'));

				$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
				$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

				

				$QuerySaberPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = ".$Mes." AND PC_ANHO = ".$Anho;
				$ResultSaberPeriodo = mysqli_query($db, $QuerySaberPeriodo) or die(mysqli_error());
				while($FilaSaberPeriodo = mysqli_fetch_array($ResultSaberPeriodo))
				{
					$Periodo = $FilaSaberPeriodo["PC_CODIGO"];
				}

				$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE MONTH( TRA_FECHA_TRANS ) = ".$Mes." AND YEAR( TRA_FECHA_TRANS ) = ".$Anho." AND PC_CODIGO = ".$Periodo;
				$resultCorrelativo = mysqli_query($db, $queryCorrelativo) or die(mysqli_error());
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

				$SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SERIE, TRA_FACTURA, TRA_TOTAL, RES_NUMERO, TRA_CORRELATIVO, PC_CODIGO)
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Taquilla Según Fact. ".$FacturaSerie." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 9, '".$FacturaSerie."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());

				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.01.004', ".$TotalFacturaFinal.", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".$IVADebito.")");

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
					for($i=0; $i<$Contador; $i++)
					{
						$Can = $Cantidad[$i];
						$Pro = $Producto[$i];
						$Pre = $Precio[$i];
						$Sub = $SubTotal[$i];
						$Tip = $TipoProducto[$i];

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', '".$Can."', '".$Pro."', '".$Pre."', '".$Sub."')") or die('Error Factura TQ Detalle '.mysqli_error());

						if($Tip == 2)
						{
							$ConsultaProdReceta = "SELECT * FROM Bodega.RECETA_SUBRECETA_DETALLE WHERE RS_CODIGO = '".$Pro."'";
							$ResultProdReceta = mysqli_query($db, $ConsultaProdReceta) or die(mysqli_error());
							while($fila = mysqli_fetch_array($ResultProdReceta))
							{
								$TotalDescargo = $fila["RSD_CANTIDAD"] * $Can;
								$ProductoCodigo      = $fila["P_CODIGO"];

								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$ProductoCodigo.", ".$TotalDescargo.")") or die(mysqli_error());

								$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
								$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
								$PrecioProductoNeto = round($PrecioProductoNeto, 2);
							}						

							$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '4.01.03.006', 0.00, ".$PrecioProductoNeto.")");
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 2);

							if($Pro == 657)
							{
								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$Pro.", ".$Can.")") or die(mysqli_error());

								$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.003', 0.00, ".$PrecioProductoNeto.")");
							}
							else
							{

								if($Pro == 821)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 822)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 823)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 859)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.006', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 860)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 863)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.009', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 858)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.005', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 857)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.004', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 856)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 864)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 865)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 861)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 862)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 876)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 877)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 878)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 879)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.003', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 880)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.006', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 881)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 883)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 884)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 886)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 887)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 893)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".$PrecioProductoNeto.")");
								}
								elseif($Pro == 905)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".$PrecioProductoNeto.")");
								}
							}
						}
					}
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
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>


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
