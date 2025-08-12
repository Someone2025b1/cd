<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/httpful.phar");
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
	<script>
		function Imprimir()
		{
			var Cod = document.getElementById('CodigoFactura').value;

			newwindow=window.open('FactImp.php?Codigo='+Cod,'name','toolbar=1,scrollbars=1,location=1,statusbar=0,menubar=1,resizable=1,width=800,height=600');
			if (window.focus) {newwindow.focus()} return false;
		}

		function Reimprimir()
	    { 
	  	 $('#submit').prop('disabled', true);
	  	 location.reload();
		}

	</script>


</head>
<body class="menubar-hoverable header-fixed menubar-pin " >

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
		<?php
			$TotalTaquillaSinIVA = 0;

			$UI        = uniqid("tra_");
			$UID       = uniqid("trad_");
			$Uid       = uniqid("F_");
			$UidD      = uniqid("FD_");
			$CCod      = uniqid("CC_");
			$Centinela = true;
			$Contador  = count($_POST["Cantidad"]);
			$TotalDescuentoFactura = 0;
			date_default_timezone_set('America/Guatemala');
			$FechaHoraHoy = date('Y-m-d', strtotime('now')).'T'.date('H:i:s', strtotime('now'));
			$CodigoEstablecimiento = $_POST["Establecimiento"];
			$CorreoEmisor = 'info@parquechatun.com';
			$NITEmisor = '92066097';
			$NombreComercial = 'PARQUE CHATUN';
			$NombreEmisor = 'ASOCIACIÓN PARA EL CRECIMIENTO EDUCATIVO REG. COOPERATIVO Y APOYO TURÍSTICO DE ESQUIPULAS';
			$DireccionEmisor = 'KILOMETRO 226.5 CARRETERA DE ASFALTADA HACIA FRONTERA DE HONDURAS';
			$CodigoPostalEmisor = '20007';
			$MunicipioEmisor = 'Esquiuplas';
			$DepartamentoEmisor = 'Chiquimula';
			$PaisEmisor = 'GT';
			$CorreoReceptor = 'facturacionchatun@gmail.com';

			$TipoPago                 = $_POST["TipoPago"];
			$Fecha                    = $_POST["Fecha"];
			$ClienteRegistrado        = $_POST["ClienteRegistrado"];			
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
			$Descuento      = $_POST["Descuento"];
			$TipoProducto   = $_POST["TipoProducto"];
			$ProductoNombre = $_POST["ProductoNombre"]; 

			//Si el número de NIT NO esta registrado
			//Se crea un nuevo cliente con los datos ingresados anteriormente
			$NIT       = $_POST["NIT"];
			$Nombre    = strtoupper($_POST["Nombre"]);
			$Direccion = strtoupper($_POST["Direccion"]);

			$sql = mysqli_query($db, "INSERT INTO Bodega.CLIENTE (CLI_NIT, CLI_NOMBRE, CLI_DIRECCION) VALUES ('".$NIT."', '".$Nombre."', '".$Direccion."')ON DUPLICATE KEY UPDATE CLI_NOMBRE = '".$Nombre."', CLI_DIRECCION = '".$Direccion."'");

			if(!$sql)
			{
				echo 'ERROR EN INGRESO DE CLIENTE';
				
			}

			$CodigoPostalReceptor = '01001';
			$MunicipioReceptor = 'GUATEMALA';
			$DepartamentoReceptor = 'GUATEMALA';
			$PaisReceptor = 'GT';

			$XMLEnviar = '
			<dte:GTDocumento xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:dte="http://www.sat.gob.gt/dte/fel/0.2.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="0.1" xsi:schemaLocation="http://www.sat.gob.gt/dte/fel/0.2.0"> 
			  <dte:SAT ClaseDocumento="dte">
			    <dte:DTE ID="DatosCertificados">
			      <dte:DatosEmision ID="DatosEmision">
			        <dte:DatosGenerales CodigoMoneda="GTQ" FechaHoraEmision="'.$FechaHoraHoy.'" NumeroAcceso="100000000" Tipo="FACT"></dte:DatosGenerales>
			        <dte:Emisor AfiliacionIVA="GEN" CodigoEstablecimiento="'.$CodigoEstablecimiento.'" CorreoEmisor="'.$CorreoEmisor.'" NITEmisor="'.$NITEmisor.'" NombreComercial="'.$NombreComercial.'" NombreEmisor="'.$NombreEmisor.'">
			          <dte:DireccionEmisor>
			            <dte:Direccion>'.$DireccionEmisor.'</dte:Direccion>
			            <dte:CodigoPostal>'.$CodigoPostalEmisor.'</dte:CodigoPostal>
			            <dte:Municipio>'.$MunicipioEmisor.'</dte:Municipio>
			            <dte:Departamento>'.$DepartamentoEmisor.'</dte:Departamento>
			            <dte:Pais>'.$PaisEmisor.'</dte:Pais>
			          </dte:DireccionEmisor>
			        </dte:Emisor>
			        <dte:Receptor CorreoReceptor="'.$CorreoReceptor.'" IDReceptor="'.$NIT.'" NombreReceptor="'.$Nombre.'">
			          <dte:DireccionReceptor>
			            <dte:Direccion>'.$Direccion.'</dte:Direccion>
			            <dte:CodigoPostal>'.$CodigoPostalReceptor.'</dte:CodigoPostal>
			            <dte:Municipio>'.$MunicipioReceptor.'</dte:Municipio>
			            <dte:Departamento>'.$DepartamentoReceptor.'</dte:Departamento>
			            <dte:Pais>'.$PaisReceptor.'</dte:Pais>
			          </dte:DireccionReceptor>
			        </dte:Receptor>
			        <dte:Frases>
			          <dte:Frase CodigoEscenario="1" TipoFrase="1"></dte:Frase>
			        </dte:Frases>
			        <dte:Items>';

			$QueryDatosNIT = mysqli_query($db, "SELECT *
											FROM Bodega.CLIENTE AS A
											WHERE A.CLI_NIT = '".$NIT."'");
			$FilaDatosNIT = mysqli_fetch_array($QueryDatosNIT);

			$NombreCliente = $FilaDatosNIT['CLI_NOMBRE'];
			$DireccionCliente = $FilaDatosNIT['CLI_DIRECCION'];


			//Si el tipo de pago fue en EFECTIVO
			if($TipoPago == 1)
			{
				$Moneda = $_POST["MonedaPagoInput"];

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ (F_CODIGO, F_SERIE, F_TIPO, CLI_NIT, F_TOTAL, F_FECHA_TRANS, F_HORA, F_USUARIO, F_MONEDA, F_EFECTIVO, F_CAMBIO, F_OBSERVACIONES, RES_NUMERO)
												VALUES ('".$Uid."', '".$SerieAutorizada."', 1, '".$NIT."', ".$TotalFacturaFinal.", CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user.", ".$Moneda.", ".$Efectivo.", ".$Cambio.", '".$Observaciones."', '".$NumeroResolucion."')") or die('Encabezado Factura 1'.mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Taquilla No.1 Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 11, 1, '".$Uid."')") or die('Encabezado Bodega 1 '.mysqli_error());

				/****************************************************************************************
				*****************************************************************************************
				*									PARTIDA CONTABLE 								    *
				*****************************************************************************************
				****************************************************************************************/

				$Mes = date('m', strtotime('now'));
				$Anho = date('Y', strtotime('now'));

				$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
				$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

				$TotalFacturaCorroborar = $IVADebito + $VentaSinIVA;

				if($TotalFacturaCorroborar != $TotalFacturaFinal)
				{
					if($TotalFacturaCorroborar > $TotalFacturaFinal)
					{
						$Diferencia = $TotalFacturaCorroborar - $TotalFacturaFinal;
					}
					elseif($TotalFacturaCorroborar < $TotalFacturaFinal)
					{
						$Diferencia = $TotalFacturaFinal - $TotalFacturaCorroborar;
					}

					$IVADebito = $IVADebito + $Diferencia;
				}
				

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
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Taquilla No.1 Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 9, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die('Encabezado Conta 1'.mysqli_error());
				if ($CodigoEstablecimiento==1) {
				 
				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.01.004', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");
				}
				else
				{
					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
													VALUES('".$Uid."', '".$UidD."', '1.01.01.004', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

						$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
													VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");

						$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
													VALUES('".$Uid."', '".$UidD."', '4.01.07.001', 0.00, ".number_format($VentaSinIVA, 4, ".", "").")");
				}
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
						$Des = $Descuento[$i];
						$Tip = $TipoProducto[$i];
						$ProN = $ProductoNombre[$i];
						$UnidVn = $_POST["UnidadesVendidas"][$i];
						$Estanque = $_POST["Estanque"][$i];

						if ($Can>0) {
							 
						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_UNIDADES, FD_ESTANQUE)
											VALUES('".$Uid."', '".$UidD."', '".$Can."', '".$Pro."', '".$Pre."', '".$Sub."', '".$UnidVn."', '".$Estanque."')") or die('Error Factura TQ Detalle '.mysqli_error());
						}

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
								$PrecioProductoNeto = round($PrecioProductoNeto, 5);
							}						

							if ($CodigoEstablecimiento==1) {
								 
							$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '4.01.03.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
							}

							$IVAProducto = (($Sub / 1.12) * 0.12);
							$SubNeto = $Sub - $IVAProducto;

							if($i != 0)
							{
								$MontoImpuesto = ($Sub * .12) / 1.12;
						    	$MontoGravable = $Sub - $MontoImpuesto;
						    	$Total = $MontoGravable + $MontoImpuesto;

								$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;				
							}
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 5);

							if($Pro == 657)
							{
								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$Pro.", ".$Can.")") or die(mysqli_error());

								$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");

								$IVAProducto = (($Sub / 1.12) * 0.12);
								$SubNeto = $Sub - $IVAProducto;

								if($i != 0)
								{
									$MontoImpuesto = ($Sub * .12) / 1.12;
						    		$MontoGravable = $Sub - $MontoImpuesto;
						    		$Total = $MontoGravable + $MontoImpuesto;

									$XMLEnviar .= '
							          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
							            <dte:Cantidad>'.$Can.'</dte:Cantidad>
							            <dte:UnidadMedida>UND</dte:UnidadMedida>
							            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
							            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
							            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
							            <dte:Descuento>'.$Des.'</dte:Descuento>
							            <dte:Impuestos>
							              <dte:Impuesto>
							                <dte:NombreCorto>IVA</dte:NombreCorto>
							                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
							                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
							                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
							              </dte:Impuesto>
							            </dte:Impuestos>
							            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
							           </dte:Item>';

									$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
									$GranTotal = $GranTotal + $Sub;				
								}
							}
							else
							{

								if($Pro == 2629)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								#Nuevos
								elseif($Pro == 2628)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2627)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.012', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2626)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.013', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2625)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.014', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2624)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.015', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2623)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.016', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}


								#Fin
								elseif($Pro == 821)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 822)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2557)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.004', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 823)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 859)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 860)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 863)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.009', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 858)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 857)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.004', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 856)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 864)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 865)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 861)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 862)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 876)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 877)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 878)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 879)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 880)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 881)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 883)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 884)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 886)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 887)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 893)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 905)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1149)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1148)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1384)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.010', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1358)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.013', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1359)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.012', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
							}

							$IVAProducto = (($Sub / 1.12) * 0.12);
							$SubNeto = $Sub - $IVAProducto;

							if($i != 0)
							{
								$MontoImpuesto = ($Sub * .12) / 1.12;
						    	$MontoGravable = $Sub - $MontoImpuesto;
						    	$Total = $MontoGravable + $MontoImpuesto;

								$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;				
							}
						}
					}

					$XMLEnviar .= '
					        </dte:Items>
					        <dte:Totales>
					          <dte:TotalImpuestos>
					            <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 4, ".", "").'"></dte:TotalImpuesto>
					          </dte:TotalImpuestos>
					          <dte:GranTotal>'.number_format($GranTotal, 2, ".", "").'</dte:GranTotal>
					        </dte:Totales>
					      </dte:DatosEmision>
					    </dte:DTE>
					  </dte:SAT>
					</dte:GTDocumento>';
				}

				//------------------------- CABECERA DEL DTE  -----------------------
  
				$url_servicio_firma = "https://signer-emisores.feel.com.gt/sign_solicitud_firmas/firma_xml";
        
				$encoded_xml =  base64_encode($XMLEnviar);

				$contenido_xml = array(
						'llave' => 'ca7d21d86285fb239d5cf10bd5d303fe',
					    'archivo' => $encoded_xml,
					    'codigo' => "n/a",
					    'alias' => 'ASOCRE',
					    'es_anulacion' => 'N'
					);             

				$json_body = json_encode( $contenido_xml );

				$response = \Httpful\Request::post($url_servicio_firma)             
				    ->sendsJson()                               
				    ->body($json_body)            
				    ->send();

				if($response->body->resultado == 1)
				{
					$NuevoXMLFirmado = $response->body->archivo;

					$contenido_xml_certi = array(
					    'nit_emisor' => "",
					    'correo_copia' => '',
					    'xml_dte' => $NuevoXMLFirmado
					);

					$json_body_certi = json_encode( $contenido_xml_certi );

					$uri = "https://certificador.feel.com.gt/fel/certificacion/v2/dte/";
						$responseCerti = \Httpful\Request::post($uri)
						->sendsJson()                               
						->body($json_body_certi)
						->addHeaders(array(
								  'usuario' => 'ASOCRE',             
							  	   'llave' => '6423B3029AEAE099309BF1930C6EB09D'           
							))            
						->send();  
						
						
					if($responseCerti->body->cantidad_errores == 0)
					{
						//Condicion si viene de No Asociados
						if(isset($_POST["Cantidadingreso"])){
						//obtener variables de NO Asociado para Guardar
						$NombreNoAsociado = $_POST["NombreNoAsociado"];
						$depto =  $_POST["depto"];
						$municipio= $_POST["municipio"];		
						$SelectVisitaEsquipulas = $_POST["SelectVisitaEsquipulas"];
						$EnteradoNoAsociado = $_POST["EnteradoNoAsociado"];
						$EdadNoAsociado = $_POST["EdadNoAsociado"];
						if($EdadNoAsociado == "")
							{
								$EdadNoAsociado = 0;
							}
						$SelectAsisteconNoAsociado = $_POST["SelectAsisteconNoAsociado"];
						$FrecuenciaVisitaNoAsociado = $_POST["FrecuenciaVisitaNoAsociado"];
						$CorreoNoAsociado = $_POST["CorreoNoAsociado"];
						$SelectConociaParque = $_POST["SelectConociaParque"];
						$BuscaNoAsociado = $_POST["BuscaNoAsociado"];
						$Cantidadingreso = $_POST['Cantidadingreso'];
						$NumeroTelefonoNoAsociado = $_POST['NumeroTelefonoNoAsociado']; 

						$GuardarNoAsociado = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_NO_ASOCIADO VALUES (NULL, '$NombreNoAsociado', 73, $depto, $municipio, $SelectVisitaEsquipulas, $EnteradoNoAsociado, $EdadNoAsociado, $SelectAsisteconNoAsociado, $FrecuenciaVisitaNoAsociado, '$CorreoNoAsociado', '$NumeroTelefonoNoAsociado', $SelectConociaParque, $BuscaNoAsociado, $id_user, CURDATE(), $Cantidadingreso[1], $Cantidadingreso[2], $Cantidadingreso[3], $Cantidadingreso[0]) ") or die("Error en guardar No Asociado".mysqli_error());
						}
							//Termina de guardar no Asociado


							$TotaldeBoletos = $TotalFacturaFinal/50;
$TotalFacturaFinal=number_format($TotalFacturaFinal, 2, ".", "");

		$Generar = "SELECT * FROM Bodega.BOLETO_GENERAR";
		$resultg = mysqli_query($db, $Generar);
		while($roweg = mysqli_fetch_array($resultg))
		{
			$Generar=$roweg["Generar"];

				}


				if($Generar==1){

				
					for($i=1; $i<=$TotaldeBoletos; $i++)
				{
					$querykardex = mysqli_query($db, "INSERT INTO Bodega.BOLETOS (B_PUNTO, B_FACTURA)
						VALUES('TAQUILLA #1', '".$Uid."')");

				}
			}
						?>
					   	<script>
					   		jQuery(document).ready(function($) {
					   			Imprimir();
					   		}); 
						</script>
					   <?php 
						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
							<h2 class="text-light">La factura se ingresó correctamente.</h2>
							<div class="row">
								<a href="VtaNew.php">
									<button type="button" class="btn btn-success btn-lg">
										<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
									</button>
								</a>
							</div>';

			           echo "NÚMERO DE AUTORIZACIÓN:   "."<b>".$responseCerti->body->uuid."</b>"."</p>";
			           echo "SERIE:   "."<b>".$responseCerti->body->serie."</b>"."</p>";
					   echo "NÚMERO DE FACTURA"."<b>".$responseCerti->body->numero."</b>"."</p>";	

					   
					   $QueryUpdateFactura = mysqli_query($db, "UPDATE Bodega.FACTURA_TQ SET F_SERIE = '".$responseCerti->body->serie."', F_CAE = '".$responseCerti->body->numero."', F_DTE = '".$responseCerti->body->uuid."', F_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionBodega = mysqli_query($db, "UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Vta. Taquilla No.1 Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionContabilidad = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Vta. Taquilla No.1 Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."', TRA_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE TRA_CODIGO = '".$Uid."'");
					}
					else
					{
						$QueryBitacora = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA 
						SELECT FACTURA_TQ.F_CODIGO, '5', FACTURA_TQ.F_ORDEN, FACTURA_TQ.F_SERIE, FACTURA_TQ.F_NUMERO, FACTURA_TQ.F_TIPO, FACTURA_TQ.CLI_NIT, FACTURA_TQ.D_CODIGO, FACTURA_TQ.F_CON_DESCUENTO, FACTURA_TQ.F_TOTAL, FACTURA_TQ.F_EFECTIVO, FACTURA_TQ.F_CAMBIO, FACTURA_TQ.F_FECHA_TRANS, FACTURA_TQ.F_HORA, FACTURA_TQ.F_USUARIO, FACTURA_TQ.F_MONEDA, FACTURA_TQ.F_ESTADO, FACTURA_TQ.F_RAZON_ANULACION, FACTURA_TQ.F_NOMBRE_CREDITO, FACTURA_TQ.F_NO_BOLETA, FACTURA_TQ.F_OBSERVACIONES, FACTURA_TQ.F_NO_AUTORIZACION, FACTURA_TQ.RES_NUMERO, FACTURA_TQ.F_CUENTA_BANCARIA, FACTURA_TQ.F_REALIZADA, FACTURA_TQ.F_CAE, FACTURA_TQ.F_DTE, FACTURA_TQ.F_FECHA_CERTIFICACION, FACTURA_TQ.F_TIPO_TARJETA FROM Bodega.FACTURA_TQ 
						WHERE  FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryBitacora1 = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA_DETALLE
							SELECT F_CODIGO, FD_CODIGO, FD_CORRELATIVO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_DESCUENTO, RS_CODIGO FROM Bodega.FACTURA_TQ_DETALLE
							WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());
					 		
							$QueryUnoRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ 
																WHERE FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryDosRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ_DETALLE
																WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryTresRestaurante = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
																FROM Bodega.TRANSACCION 
																INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
																WHERE TRANSACCION.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCuatroRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
																	WHERE TRANSACCION.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCincoRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
																	WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());
						echo ' <div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR! <i class="fa fa-caution text-danger"></i></span></h1>
							<h2 class="text-light">La factura tuvo un error.</h2>
							<div class="row">
								 <div style="margin:3em;">
									<button id="submit" onclick="Reimprimir()" type="button" class="btn btn-primary btn-lg">Re Imprimir</button> 
								</div>
							</div> ';
				      	echo '<br><ul>';

				      	foreach ($responseCerti->body->descripcion_errores as $errores) 
				      	{
					        echo '<li>'.$errores->mensaje_error.'</li>';
				      	}
				      
				      	echo '<br></ul>';
					}
				}
				else
				{
					$QueryBitacora = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA 
						SELECT FACTURA_TQ.F_CODIGO, '5', FACTURA_TQ.F_ORDEN, FACTURA_TQ.F_SERIE, FACTURA_TQ.F_NUMERO, FACTURA_TQ.F_TIPO, FACTURA_TQ.CLI_NIT, FACTURA_TQ.D_CODIGO, FACTURA_TQ.F_CON_DESCUENTO, FACTURA_TQ.F_TOTAL, FACTURA_TQ.F_EFECTIVO, FACTURA_TQ.F_CAMBIO, FACTURA_TQ.F_FECHA_TRANS, FACTURA_TQ.F_HORA, FACTURA_TQ.F_USUARIO, FACTURA_TQ.F_MONEDA, FACTURA_TQ.F_ESTADO, FACTURA_TQ.F_RAZON_ANULACION, FACTURA_TQ.F_NOMBRE_CREDITO, FACTURA_TQ.F_NO_BOLETA, FACTURA_TQ.F_OBSERVACIONES, FACTURA_TQ.F_NO_AUTORIZACION, FACTURA_TQ.RES_NUMERO, FACTURA_TQ.F_CUENTA_BANCARIA, FACTURA_TQ.F_REALIZADA, FACTURA_TQ.F_CAE, FACTURA_TQ.F_DTE, FACTURA_TQ.F_FECHA_CERTIFICACION, FACTURA_TQ.F_TIPO_TARJETA FROM Bodega.FACTURA_TQ 
						WHERE  FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryBitacora1 = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA_DETALLE
							SELECT F_CODIGO, FD_CODIGO, FD_CORRELATIVO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_DESCUENTO, RS_CODIGO FROM Bodega.FACTURA_TQ_DETALLE
							WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());
					 		
							$QueryUnoRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ 
																WHERE FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryDosRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ_DETALLE
																WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryTresRestaurante = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
																FROM Bodega.TRANSACCION 
																INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
																WHERE TRANSACCION.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCuatroRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
																	WHERE TRANSACCION.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCincoRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
																	WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());
						echo ' <div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR! <i class="fa fa-caution text-danger"></i></span></h1>
							<h2 class="text-light">La factura tuvo un error.</h2>
							<div class="row">
								 <div style="margin:3em;">
									<button id="submit" onclick="Reimprimir()" type="button" class="btn btn-primary btn-lg">Re Imprimir</button> 
								</div>
							</div> ';
				      	echo '<br><ul>';
				}
			}
			elseif($TipoPago == 2)
			{
				$NumeroAutorizacionTXT = $_POST["NumeroAutorizacionTXT"];
				$TipoTarjeta = $_POST["TipoTarjeta"];
				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ (F_CODIGO, F_SERIE, F_TIPO, CLI_NIT, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_OBSERVACIONES, F_NO_AUTORIZACION, RES_NUMERO, F_TIPO_TARJETA)
												VALUES ('".$Uid."', '".$SerieAutorizada."', 2, '".$NIT."', ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.", '".$Observaciones."', '".$NumeroAutorizacionTXT."', '".$NumeroResolucion."', '".$TipoTarjeta."')") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Taquilla No.1 Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 11, 1, '".$Uid."')") or die(mysqli_error());

				/****************************************************************************************
				*****************************************************************************************
				*									PARTIDA CONTABLE 								    *
				*****************************************************************************************
				****************************************************************************************/

				$Mes = date('m', strtotime('now'));
				$Anho = date('Y', strtotime('now'));

				$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
				$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

				$TotalFacturaCorroborar = $IVADebito + $VentaSinIVA;

				if($TotalFacturaCorroborar != $TotalFacturaFinal)
				{
					if($TotalFacturaCorroborar > $TotalFacturaFinal)
					{
						$Diferencia = $TotalFacturaCorroborar - $TotalFacturaFinal;
					}
					elseif($TotalFacturaCorroborar < $TotalFacturaFinal)
					{
						$Diferencia = $TotalFacturaFinal - $TotalFacturaCorroborar;
					}

					$IVADebito = $IVADebito + $Diferencia;
				}
				

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
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Taquilla No.1 Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 9, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());
				if ($CodigoEstablecimiento==1) {
				 

				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.010', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");
				}
				else
				{
					if ($TipoTarjeta==1) 
					{
						$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.010', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)"); 
					}
					elseif ($TipoTarjeta==2) 
					{
						$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.010', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)"); 
					} 

					$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");

					$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.07.001', 0.00, ".number_format($VentaSinIVA, 4, ".", "").")");
				}
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
						$Des = $Descuento[$i];
						$Tip = $TipoProducto[$i];
						$ProN = $ProductoNombre[$i];
						$UnidVn = $_POST["UnidadesVendidas"][$i];
						$Estanque = $_POST["Estanque"][$i];

						if ($Can>0) {
							 
						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_UNIDADES, FD_ESTANQUE)
											VALUES('".$Uid."', '".$UidD."', '".$Can."', '".$Pro."', '".$Pre."', '".$Sub."', '".$UnidVn."', '".$Estanque."')") or die('Error Factura TQ Detalle '.mysqli_error());
						}

						if($Tip == 2)
						{
							$ConsultaProdReceta = "SELECT * FROM Bodega.RECETA_SUBRECETA_DETALLE WHERE RS_CODIGO = '".$Pro."'";
							$ResultProdReceta = mysqli_query($db, $ConsultaProdReceta) or die(mysqli_error());
							while($fila = mysqli_fetch_array($ResultProdReceta))
							{
								$TotalDescargo = $fila["RSD_CANTIDAD"] * $Can;
								$ProductoCodigo      = $fila["P_CODIGO"];

								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$ProductoCodigo.", ".number_format($TotalDescargo, 2, ".", "").")") or die(mysqli_error());

								$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
								$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
								$PrecioProductoNeto = round($PrecioProductoNeto, 5);
							}						

							if ($CodigoEstablecimiento==1) {
								 
							$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '4.01.03.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
							}

							$IVAProducto = (($Sub / 1.12) * 0.12);
							$SubNeto = $Sub - $IVAProducto;

							if($i != 0)
							{
								$MontoImpuesto = ($Sub * .12) / 1.12;
						    	$MontoGravable = $Sub - $MontoImpuesto;
						    	$Total = $MontoGravable + $MontoImpuesto;

								$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;						
							}
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 5);

							if($Pro == 657)
							{
								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$Pro.", ".$Can.")") or die(mysqli_error());

								$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								$IVAProducto = (($Sub / 1.12) * 0.12);
								$SubNeto = $Sub - $IVAProducto;

								if($i != 0)
								{
									$MontoImpuesto = ($Sub * .12) / 1.12;
							    	$MontoGravable = $Sub - $MontoImpuesto;
							    	$Total = $MontoGravable + $MontoImpuesto;

									$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;						
								}
							}
							else
							{

								if($Pro == 821)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2629)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								#Nuevos
								elseif($Pro == 2628)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2627)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.012', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2626)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.013', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2625)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.014', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2624)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.015', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2623)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.016', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}


								#Fin
								elseif($Pro == 822)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 823)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2557)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.004', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 859)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 860)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 863)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.009', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 858)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 857)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.004', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 856)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 864)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 865)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 861)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 862)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 876)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 877)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 878)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 879)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 880)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 881)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 883)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 884)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 886)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 887)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 893)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 905)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1149)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1148)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1384)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.010', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1358)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.013', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								$IVAProducto = (($Sub / 1.12) * 0.12);
								$SubNeto = $Sub - $IVAProducto;

								if($i != 0)
								{
									$MontoImpuesto = ($Sub * .12) / 1.12;
							    	$MontoGravable = $Sub - $MontoImpuesto;
							    	$Total = $MontoGravable + $MontoImpuesto;

									$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;						
								}
							}
						}
					}

					$XMLEnviar .= '
					        </dte:Items>
					        <dte:Totales>
					          <dte:TotalImpuestos>
					            <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 4, ".", "").'"></dte:TotalImpuesto>
					          </dte:TotalImpuestos>
					          <dte:GranTotal>'.number_format($GranTotal, 2, ".", "").'</dte:GranTotal>
					        </dte:Totales>
					      </dte:DatosEmision>
					    </dte:DTE>
					  </dte:SAT>
					</dte:GTDocumento>';
				}

				//------------------------- CABECERA DEL DTE  -----------------------


				$url_servicio_firma = "https://signer-emisores.feel.com.gt/sign_solicitud_firmas/firma_xml";
        
				$encoded_xml =  base64_encode($XMLEnviar);

				$contenido_xml = array(
						'llave' => 'ca7d21d86285fb239d5cf10bd5d303fe',
					    'archivo' => $encoded_xml,
					    'codigo' => "n/a",
					    'alias' => 'ASOCRE',
					    'es_anulacion' => 'N'
					);             

				$json_body = json_encode( $contenido_xml );

				$response = \Httpful\Request::post($url_servicio_firma)             
				    ->sendsJson()                               
				    ->body($json_body)            
				    ->send();

				if($response->body->resultado == 1)
				{
					$NuevoXMLFirmado = $response->body->archivo;

					$contenido_xml_certi = array(
					    'nit_emisor' => "",
					    'correo_copia' => '',
					    'xml_dte' => $NuevoXMLFirmado
					);

					$json_body_certi = json_encode( $contenido_xml_certi );

					$uri = "https://certificador.feel.com.gt/fel/certificacion/v2/dte/";
						$responseCerti = \Httpful\Request::post($uri)
						->sendsJson()                               
						->body($json_body_certi)
						->addHeaders(array(
								  'usuario' => 'ASOCRE',             
							  	   'llave' => '6423B3029AEAE099309BF1930C6EB09D'           
							))            
						->send();   

					if($responseCerti->body->cantidad_errores == 0)
					{
						//Condicion si viene de No Asociados
						if(isset($_POST["Cantidadingreso"])){
							//obtener variables de NO Asociado para Guardar
							$NombreNoAsociado = $_POST["NombreNoAsociado"];
							$depto =  $_POST["depto"];
							$municipio= $_POST["municipio"];		
							$SelectVisitaEsquipulas = $_POST["SelectVisitaEsquipulas"];
							$EnteradoNoAsociado = $_POST["EnteradoNoAsociado"];
							$EdadNoAsociado = $_POST["EdadNoAsociado"];
							if($EdadNoAsociado == "")
								{
									$EdadNoAsociado = 0;
								}
							$SelectAsisteconNoAsociado = $_POST["SelectAsisteconNoAsociado"];
							$FrecuenciaVisitaNoAsociado = $_POST["FrecuenciaVisitaNoAsociado"];
							$CorreoNoAsociado = $_POST["CorreoNoAsociado"];
							$SelectConociaParque = $_POST["SelectConociaParque"];
							$BuscaNoAsociado = $_POST["BuscaNoAsociado"];
							$Cantidadingreso = $_POST['Cantidadingreso'];
							$NumeroTelefonoNoAsociado = $_POST['NumeroTelefonoNoAsociado']; 
	
							$GuardarNoAsociado = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_NO_ASOCIADO VALUES (NULL, '$NombreNoAsociado', 73, $depto, $municipio, $SelectVisitaEsquipulas, $EnteradoNoAsociado, $EdadNoAsociado, $SelectAsisteconNoAsociado, $FrecuenciaVisitaNoAsociado, '$CorreoNoAsociado', '$NumeroTelefonoNoAsociado', $SelectConociaParque, $BuscaNoAsociado, $id_user, CURDATE(), $Cantidadingreso[1], $Cantidadingreso[2], $Cantidadingreso[3], $Cantidadingreso[0]) ") or die("Error en guardar No Asociado".mysqli_error());
							}
								//Termina de guardar no Asociado

								$TotaldeBoletos = $TotalFacturaFinal/50;
$TotalFacturaFinal=number_format($TotalFacturaFinal, 2, ".", "");

		$Generar = "SELECT * FROM Bodega.BOLETO_GENERAR";
		$resultg = mysqli_query($db, $Generar);
		while($roweg = mysqli_fetch_array($resultg))
		{
			$Generar=$roweg["Generar"];

				}


				if($Generar==1){

				
					for($i=1; $i<=$TotaldeBoletos; $i++)
				{
					$querykardex = mysqli_query($db, "INSERT INTO Bodega.BOLETOS (B_PUNTO, B_FACTURA)
						VALUES('TAQUILLA #1', '".$Uid."')");

				}
			}
						?>
					   	<script>
					   		jQuery(document).ready(function($) {
					   			Imprimir();
					   		}); 
						</script>
					   <?php 
						?>
					   	<script>
					   		jQuery(document).ready(function($) {
					   			Imprimir();
					   		}); 
						</script>
					   <?php 
						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
							<h2 class="text-light">La factura se ingresó correctamente.</h2>
							<div class="row">
								<a href="VtaNew.php">
									<button type="button" class="btn btn-success btn-lg">
										<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
									</button>
								</a>
							</div>';

			           echo "NÚMERO DE AUTORIZACIÓN:   "."<b>".$responseCerti->body->uuid."</b>"."</p>";
			           echo "SERIE:   "."<b>".$responseCerti->body->serie."</b>"."</p>";
					   echo "NÚMERO DE FACTURA"."<b>".$responseCerti->body->numero."</b>"."</p>";	

					   
					   $QueryUpdateFactura = mysqli_query($db, "UPDATE Bodega.FACTURA_TQ SET F_SERIE = '".$responseCerti->body->serie."', F_CAE = '".$responseCerti->body->numero."', F_DTE = '".$responseCerti->body->uuid."', F_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionBodega = mysqli_query($db, "UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Vta. Taquilla No.1 Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionContabilidad = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Vta. Taquilla No.1 Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."', TRA_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE TRA_CODIGO = '".$Uid."'");
					}
					else
					{
						$QueryBitacora = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA 
						SELECT FACTURA_TQ.F_CODIGO, '5', FACTURA_TQ.F_ORDEN, FACTURA_TQ.F_SERIE, FACTURA_TQ.F_NUMERO, FACTURA_TQ.F_TIPO, FACTURA_TQ.CLI_NIT, FACTURA_TQ.D_CODIGO, FACTURA_TQ.F_CON_DESCUENTO, FACTURA_TQ.F_TOTAL, FACTURA_TQ.F_EFECTIVO, FACTURA_TQ.F_CAMBIO, FACTURA_TQ.F_FECHA_TRANS, FACTURA_TQ.F_HORA, FACTURA_TQ.F_USUARIO, FACTURA_TQ.F_MONEDA, FACTURA_TQ.F_ESTADO, FACTURA_TQ.F_RAZON_ANULACION, FACTURA_TQ.F_NOMBRE_CREDITO, FACTURA_TQ.F_NO_BOLETA, FACTURA_TQ.F_OBSERVACIONES, FACTURA_TQ.F_NO_AUTORIZACION, FACTURA_TQ.RES_NUMERO, FACTURA_TQ.F_CUENTA_BANCARIA, FACTURA_TQ.F_REALIZADA, FACTURA_TQ.F_CAE, FACTURA_TQ.F_DTE, FACTURA_TQ.F_FECHA_CERTIFICACION, FACTURA_TQ.F_TIPO_TARJETA FROM Bodega.FACTURA_TQ 
						WHERE  FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryBitacora1 = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA_DETALLE
							SELECT F_CODIGO, FD_CODIGO, FD_CORRELATIVO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_DESCUENTO, RS_CODIGO FROM Bodega.FACTURA_TQ_DETALLE
							WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());
					 		
							$QueryUnoRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ 
																WHERE FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryDosRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ_DETALLE
																WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryTresRestaurante = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
																FROM Bodega.TRANSACCION 
																INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
																WHERE TRANSACCION.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCuatroRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
																	WHERE TRANSACCION.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCincoRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
																	WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());
						echo ' <div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR! <i class="fa fa-caution text-danger"></i></span></h1>
							<h2 class="text-light">La factura tuvo un error.</h2>
							<div class="row">
								 <div style="margin:3em;">
									<button id="submit" onclick="Reimprimir()" type="button" class="btn btn-primary btn-lg">Re Imprimir</button> 
								</div>
							</div> ';
				      	echo '<br><ul>';

				      	foreach ($responseCerti->body->descripcion_errores as $errores) 
				      	{
					        echo '<li>'.$errores->mensaje_error.'</li>';
				      	}
				      
				      	echo '<br></ul>';
					}
				}
				else
				{
					$QueryBitacora = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA 
						SELECT FACTURA_TQ.F_CODIGO, '5', FACTURA_TQ.F_ORDEN, FACTURA_TQ.F_SERIE, FACTURA_TQ.F_NUMERO, FACTURA_TQ.F_TIPO, FACTURA_TQ.CLI_NIT, FACTURA_TQ.D_CODIGO, FACTURA_TQ.F_CON_DESCUENTO, FACTURA_TQ.F_TOTAL, FACTURA_TQ.F_EFECTIVO, FACTURA_TQ.F_CAMBIO, FACTURA_TQ.F_FECHA_TRANS, FACTURA_TQ.F_HORA, FACTURA_TQ.F_USUARIO, FACTURA_TQ.F_MONEDA, FACTURA_TQ.F_ESTADO, FACTURA_TQ.F_RAZON_ANULACION, FACTURA_TQ.F_NOMBRE_CREDITO, FACTURA_TQ.F_NO_BOLETA, FACTURA_TQ.F_OBSERVACIONES, FACTURA_TQ.F_NO_AUTORIZACION, FACTURA_TQ.RES_NUMERO, FACTURA_TQ.F_CUENTA_BANCARIA, FACTURA_TQ.F_REALIZADA, FACTURA_TQ.F_CAE, FACTURA_TQ.F_DTE, FACTURA_TQ.F_FECHA_CERTIFICACION, FACTURA_TQ.F_TIPO_TARJETA FROM Bodega.FACTURA_TQ 
						WHERE  FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryBitacora1 = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA_DETALLE
							SELECT F_CODIGO, FD_CODIGO, FD_CORRELATIVO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_DESCUENTO, RS_CODIGO FROM Bodega.FACTURA_TQ_DETALLE
							WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());
					 		
							$QueryUnoRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ 
																WHERE FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryDosRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ_DETALLE
																WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryTresRestaurante = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
																FROM Bodega.TRANSACCION 
																INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
																WHERE TRANSACCION.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCuatroRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
																	WHERE TRANSACCION.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCincoRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
																	WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());
						echo ' <div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR! <i class="fa fa-caution text-danger"></i></span></h1>
							<h2 class="text-light">La factura tuvo un error.</h2>
							<div class="row">
								 <div style="margin:3em;">
									<button id="submit" onclick="Reimprimir()" type="button" class="btn btn-primary btn-lg">Re Imprimir</button> 
								</div>
							</div> ';
				      	echo '<br><ul>';
				}
			}
			elseif($TipoPago == 3)
			{
				$NombreCredito = $_POST["NombreCreditoTXT"];

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ (F_CODIGO, F_SERIE, F_TIPO, CLI_NIT, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_NOMBRE_CREDITO, F_OBSERVACIONES, RES_NUMERO)
												VALUES ('".$Uid."', '".$SerieAutorizada."', 3, '".$NIT."', ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.",  '".$NombreCredito."', '".$Observaciones."', '".$NumeroResolucion."')") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Taquilla No.1 Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 11, 1, '".$Uid."')") or die(mysqli_error());

				/****************************************************************************************
				*****************************************************************************************
				*									PARTIDA CONTABLE 								    *
				*****************************************************************************************
				****************************************************************************************/

				$Mes = date('m', strtotime('now'));
				$Anho = date('Y', strtotime('now'));

				$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
				$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

				$TotalFacturaCorroborar = $IVADebito + $VentaSinIVA;

				if($TotalFacturaCorroborar != $TotalFacturaFinal)
				{
					if($TotalFacturaCorroborar > $TotalFacturaFinal)
					{
						$Diferencia = $TotalFacturaCorroborar - $TotalFacturaFinal;
					}
					elseif($TotalFacturaCorroborar < $TotalFacturaFinal)
					{
						$Diferencia = $TotalFacturaFinal - $TotalFacturaCorroborar;
					}

					$IVADebito = $IVADebito + $Diferencia;
				}
				

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
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Taquilla No.1 Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 9, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());

				if ($CodigoEstablecimiento==1) {
				 
				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.01.004', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");
				}
				else
				{
					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.01.004', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

					$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");

					$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.07.001', 0.00, ".number_format($VentaSinIVA, 4, ".", "").")");
				}

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
						$Des = $Descuento[$i];
						$Tip = $TipoProducto[$i];
						$ProN = $ProductoNombre[$i];
						$UnidVn = $_POST["UnidadesVendidas"][$i];
						$Estanque = $_POST["Estanque"][$i];

						if ($Can>0) {
							 
						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_UNIDADES, FD_ESTANQUE)
											VALUES('".$Uid."', '".$UidD."', '".$Can."', '".$Pro."', '".$Pre."', '".$Sub."', '".$UnidVn."', '".$Estanque."')") or die('Error Factura TQ Detalle '.mysqli_error());
						}

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
								$PrecioProductoNeto = round($PrecioProductoNeto, 5);
							}						

							if ($CodigoEstablecimiento==1) {
								 
							$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '4.01.03.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
							}

							$IVAProducto = (($Sub / 1.12) * 0.12);
							$SubNeto = $Sub - $IVAProducto;

							if($i != 0)
							{
								$MontoImpuesto = ($Sub * .12) / 1.12;
						    	$MontoGravable = $Sub - $MontoImpuesto;
						    	$Total = $MontoGravable + $MontoImpuesto;

								$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;						
							}
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 5);

							if($Pro == 657)
							{
								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$Pro.", ".$Can.")") or die(mysqli_error());

								$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");

								$IVAProducto = (($Sub / 1.12) * 0.12);
								$SubNeto = $Sub - $IVAProducto;

								if($i != 0)
								{
									$MontoImpuesto = ($Sub * .12) / 1.12;
							    	$MontoGravable = $Sub - $MontoImpuesto;
							    	$Total = $MontoGravable + $MontoImpuesto;

									$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;						
								}
							}
							else
							{

								if($Pro == 821)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2629)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								#Nuevos
								elseif($Pro == 2628)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2627)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.012', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2626)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.013', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2625)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.014', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2624)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.015', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2623)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.016', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}


								#Fin
								elseif($Pro == 822)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 823)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2557)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.004', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 859)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 860)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 863)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.009', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 858)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 857)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.004', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 856)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 864)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 865)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 861)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 862)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 876)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 877)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 878)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 879)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 880)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 881)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 883)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 884)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 886)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 887)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 893)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 905)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1149)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1148)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1384)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.010', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1358)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.013', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}

								$IVAProducto = (($Sub / 1.12) * 0.12);
								$SubNeto = $Sub - $IVAProducto;

								if($i != 0)
								{
									$MontoImpuesto = ($Sub * .12) / 1.12;
							    	$MontoGravable = $Sub - $MontoImpuesto;
							    	$Total = $MontoGravable + $MontoImpuesto;

									$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;						
								}
							}
						}
					}

					$XMLEnviar .= '
					        </dte:Items>
					        <dte:Totales>
					          <dte:TotalImpuestos>
					            <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 4, ".", "").'"></dte:TotalImpuesto>
					          </dte:TotalImpuestos>
					          <dte:GranTotal>'.number_format($GranTotal, 2, ".", "").'</dte:GranTotal>
					        </dte:Totales>
					      </dte:DatosEmision>
					    </dte:DTE>
					  </dte:SAT>
					</dte:GTDocumento>';
				}

				//------------------------- CABECERA DEL DTE  -----------------------


				$url_servicio_firma = "https://signer-emisores.feel.com.gt/sign_solicitud_firmas/firma_xml";
        
				$encoded_xml =  base64_encode($XMLEnviar);

				$contenido_xml = array(
						'llave' => 'ca7d21d86285fb239d5cf10bd5d303fe',
					    'archivo' => $encoded_xml,
					    'codigo' => "n/a",
					    'alias' => 'ASOCRE',
					    'es_anulacion' => 'N'
					);             

				$json_body = json_encode( $contenido_xml );

				$response = \Httpful\Request::post($url_servicio_firma)             
				    ->sendsJson()                               
				    ->body($json_body)            
				    ->send();

				if($response->body->resultado == 1)
				{
					$NuevoXMLFirmado = $response->body->archivo;

					$contenido_xml_certi = array(
					    'nit_emisor' => "",
					    'correo_copia' => '',
					    'xml_dte' => $NuevoXMLFirmado
					);

					$json_body_certi = json_encode( $contenido_xml_certi );

					$uri = "https://certificador.feel.com.gt/fel/certificacion/v2/dte/";
						$responseCerti = \Httpful\Request::post($uri)
						->sendsJson()                               
						->body($json_body_certi)
						->addHeaders(array(
								  'usuario' => 'ASOCRE',             
							  	   'llave' => '6423B3029AEAE099309BF1930C6EB09D'           
							))            
						->send();   

					if($responseCerti->body->cantidad_errores == 0)
					{
						//Condicion si viene de No Asociados
						if(isset($_POST["Cantidadingreso"])){
							//obtener variables de NO Asociado para Guardar
							$NombreNoAsociado = $_POST["NombreNoAsociado"];
							$depto =  $_POST["depto"];
							$municipio= $_POST["municipio"];		
							$SelectVisitaEsquipulas = $_POST["SelectVisitaEsquipulas"];
							$EnteradoNoAsociado = $_POST["EnteradoNoAsociado"];
							$EdadNoAsociado = $_POST["EdadNoAsociado"];
							if($EdadNoAsociado == "")
								{
									$EdadNoAsociado = 0;
								}
							$SelectAsisteconNoAsociado = $_POST["SelectAsisteconNoAsociado"];
							$FrecuenciaVisitaNoAsociado = $_POST["FrecuenciaVisitaNoAsociado"];
							$CorreoNoAsociado = $_POST["CorreoNoAsociado"];
							$SelectConociaParque = $_POST["SelectConociaParque"];
							$BuscaNoAsociado = $_POST["BuscaNoAsociado"];
							$Cantidadingreso = $_POST['Cantidadingreso'];
							$NumeroTelefonoNoAsociado = $_POST['NumeroTelefonoNoAsociado']; 
	
							$GuardarNoAsociado = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_NO_ASOCIADO VALUES (NULL, '$NombreNoAsociado', 73, $depto, $municipio, $SelectVisitaEsquipulas, $EnteradoNoAsociado, $EdadNoAsociado, $SelectAsisteconNoAsociado, $FrecuenciaVisitaNoAsociado, '$CorreoNoAsociado', '$NumeroTelefonoNoAsociado', $SelectConociaParque, $BuscaNoAsociado, $id_user, CURDATE(), $Cantidadingreso[1], $Cantidadingreso[2], $Cantidadingreso[3], $Cantidadingreso[0]) ") or die("Error en guardar No Asociado".mysqli_error());
							}
								//Termina de guardar no Asociado

								$TotaldeBoletos = $TotalFacturaFinal/50;
$TotalFacturaFinal=number_format($TotalFacturaFinal, 2, ".", "");

		$Generar = "SELECT * FROM Bodega.BOLETO_GENERAR";
		$resultg = mysqli_query($db, $Generar);
		while($roweg = mysqli_fetch_array($resultg))
		{
			$Generar=$roweg["Generar"];

				}


				if($Generar==1){

				
					for($i=1; $i<=$TotaldeBoletos; $i++)
				{
					$querykardex = mysqli_query($db, "INSERT INTO Bodega.BOLETOS (B_PUNTO, B_FACTURA)
						VALUES('TAQUILLA #1', '".$Uid."')");

				}
			}
						?>
					   	<script>
					   		jQuery(document).ready(function($) {
					   			Imprimir();
					   		}); 
						</script>
					   <?php 
						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
							<h2 class="text-light">La factura se ingresó correctamente.</h2>
							<div class="row">
								<a href="VtaNew.php">
									<button type="button" class="btn btn-success btn-lg">
										<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
									</button>
								</a>
							</div>';

			           echo "NÚMERO DE AUTORIZACIÓN:   "."<b>".$responseCerti->body->uuid."</b>"."</p>";
			           echo "SERIE:   "."<b>".$responseCerti->body->serie."</b>"."</p>";
					   echo "NÚMERO DE FACTURA"."<b>".$responseCerti->body->numero."</b>"."</p>";	

					   
					   $QueryUpdateFactura = mysqli_query($db, "UPDATE Bodega.FACTURA_TQ SET F_SERIE = '".$responseCerti->body->serie."', F_CAE = '".$responseCerti->body->numero."', F_DTE = '".$responseCerti->body->uuid."', F_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionBodega = mysqli_query($db, "UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Vta. Taquilla No.1 Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionContabilidad = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Vta. Taquilla No.1 Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."', TRA_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE TRA_CODIGO = '".$Uid."'");
					
					   ##### CUENTAS POR COBRAR
					   $sqlCredito = mysqli_query($db, "INSERT INTO Contabilidad.CUENTAS_POR_COBRAR (CC_CODIGO, F_CODIGO, CC_ESTADO, CC_NIT, CC_REALIZO, CC_TOTAL, CC_PUNTO, CC_ABONO)
					   VALUES ('".$CCod."', '".$Uid."', 1, $NIT,  '".$id_user."', '".$TotalFacturaFinal."', 'TAQUILLA', 0.00)");
					
					
					}
					else
					{
						$QueryBitacora = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA 
						SELECT FACTURA_TQ.F_CODIGO, '5', FACTURA_TQ.F_ORDEN, FACTURA_TQ.F_SERIE, FACTURA_TQ.F_NUMERO, FACTURA_TQ.F_TIPO, FACTURA_TQ.CLI_NIT, FACTURA_TQ.D_CODIGO, FACTURA_TQ.F_CON_DESCUENTO, FACTURA_TQ.F_TOTAL, FACTURA_TQ.F_EFECTIVO, FACTURA_TQ.F_CAMBIO, FACTURA_TQ.F_FECHA_TRANS, FACTURA_TQ.F_HORA, FACTURA_TQ.F_USUARIO, FACTURA_TQ.F_MONEDA, FACTURA_TQ.F_ESTADO, FACTURA_TQ.F_RAZON_ANULACION, FACTURA_TQ.F_NOMBRE_CREDITO, FACTURA_TQ.F_NO_BOLETA, FACTURA_TQ.F_OBSERVACIONES, FACTURA_TQ.F_NO_AUTORIZACION, FACTURA_TQ.RES_NUMERO, FACTURA_TQ.F_CUENTA_BANCARIA, FACTURA_TQ.F_REALIZADA, FACTURA_TQ.F_CAE, FACTURA_TQ.F_DTE, FACTURA_TQ.F_FECHA_CERTIFICACION, FACTURA_TQ.F_TIPO_TARJETA FROM Bodega.FACTURA_TQ 
						WHERE  FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryBitacora1 = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA_DETALLE
							SELECT F_CODIGO, FD_CODIGO, FD_CORRELATIVO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_DESCUENTO, RS_CODIGO FROM Bodega.FACTURA_TQ_DETALLE
							WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());
					 		
							$QueryUnoRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ 
																WHERE FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryDosRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ_DETALLE
																WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryTresRestaurante = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
																FROM Bodega.TRANSACCION 
																INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
																WHERE TRANSACCION.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCuatroRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
																	WHERE TRANSACCION.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCincoRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
																	WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());
						echo ' <div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR! <i class="fa fa-caution text-danger"></i></span></h1>
							<h2 class="text-light">La factura tuvo un error.</h2>
							<div class="row">
								 <div style="margin:3em;">
									<button id="submit" onclick="Reimprimir()" type="button" class="btn btn-primary btn-lg">Re Imprimir</button> 
								</div>
							</div> ';
				      	echo '<br><ul>';

				      	foreach ($responseCerti->body->descripcion_errores as $errores) 
				      	{
					        echo '<li>'.$errores->mensaje_error.'</li>';
				      	}
				      
				      	echo '<br></ul>';
					}
				}
				else
				{
					$QueryBitacora = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA 
						SELECT FACTURA_TQ.F_CODIGO, '5', FACTURA_TQ.F_ORDEN, FACTURA_TQ.F_SERIE, FACTURA_TQ.F_NUMERO, FACTURA_TQ.F_TIPO, FACTURA_TQ.CLI_NIT, FACTURA_TQ.D_CODIGO, FACTURA_TQ.F_CON_DESCUENTO, FACTURA_TQ.F_TOTAL, FACTURA_TQ.F_EFECTIVO, FACTURA_TQ.F_CAMBIO, FACTURA_TQ.F_FECHA_TRANS, FACTURA_TQ.F_HORA, FACTURA_TQ.F_USUARIO, FACTURA_TQ.F_MONEDA, FACTURA_TQ.F_ESTADO, FACTURA_TQ.F_RAZON_ANULACION, FACTURA_TQ.F_NOMBRE_CREDITO, FACTURA_TQ.F_NO_BOLETA, FACTURA_TQ.F_OBSERVACIONES, FACTURA_TQ.F_NO_AUTORIZACION, FACTURA_TQ.RES_NUMERO, FACTURA_TQ.F_CUENTA_BANCARIA, FACTURA_TQ.F_REALIZADA, FACTURA_TQ.F_CAE, FACTURA_TQ.F_DTE, FACTURA_TQ.F_FECHA_CERTIFICACION, FACTURA_TQ.F_TIPO_TARJETA FROM Bodega.FACTURA_TQ 
						WHERE  FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryBitacora1 = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA_DETALLE
							SELECT F_CODIGO, FD_CODIGO, FD_CORRELATIVO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_DESCUENTO, RS_CODIGO FROM Bodega.FACTURA_TQ_DETALLE
							WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());
					 		
							$QueryUnoRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ 
																WHERE FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryDosRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ_DETALLE
																WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryTresRestaurante = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
																FROM Bodega.TRANSACCION 
																INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
																WHERE TRANSACCION.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCuatroRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
																	WHERE TRANSACCION.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCincoRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
																	WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());
						echo ' <div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR! <i class="fa fa-caution text-danger"></i></span></h1>
							<h2 class="text-light">La factura tuvo un error.</h2>
							<div class="row">
								 <div style="margin:3em;">
									<button id="submit" onclick="Reimprimir()" type="button" class="btn btn-primary btn-lg">Re Imprimir</button> 
								</div>
							</div> ';
				      	echo '<br><ul>';
				}
			}
			elseif($TipoPago == 4)
			{
				$NumeroBoleta = $_POST["NumeroBoleta"];
				$CuentaBancaria = $_POST["CuentaBancaria"];

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ (F_CODIGO, F_SERIE, F_TIPO, CLI_NIT, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_NO_BOLETA, F_OBSERVACIONES, RES_NUMERO, F_CUENTA_BANCARIA)
												VALUES ('".$Uid."', '".$SerieAutorizada."', 4, '".$NIT."', ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.",  '".$NumeroBoleta."', '".$Observaciones."', '".$NumeroResolucion."', '".$CuentaBancaria."')") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Taquilla No.1 Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 11, 1, '".$Uid."')") or die(mysqli_error());

				/****************************************************************************************
				*****************************************************************************************
				*									PARTIDA CONTABLE 								    *
				*****************************************************************************************
				****************************************************************************************/

				$Mes = date('m', strtotime('now'));
				$Anho = date('Y', strtotime('now'));

				$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
				$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

				$TotalFacturaCorroborar = $IVADebito + $VentaSinIVA;

				if($TotalFacturaCorroborar != $TotalFacturaFinal)
				{
					if($TotalFacturaCorroborar > $TotalFacturaFinal)
					{
						$Diferencia = $TotalFacturaCorroborar - $TotalFacturaFinal;
					}
					elseif($TotalFacturaCorroborar < $TotalFacturaFinal)
					{
						$Diferencia = $TotalFacturaFinal - $TotalFacturaCorroborar;
					}

					$IVADebito = $IVADebito + $Diferencia;
				}				

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
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Taquilla No.1 Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 9, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());

				if ($CodigoEstablecimiento==1) {
					 
				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '".$CuentaBancaria."', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");
				}
				else
				{
					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '".$CuentaBancaria."', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

					$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");

					$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.07.001', 0.00, ".number_format($VentaSinIVA, 4, ".", "").")");
				}

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
						$Des = $Descuento[$i];
						$Tip = $TipoProducto[$i];
						$ProN = $ProductoNombre[$i];
						$UnidVn = $_POST["UnidadesVendidas"][$i];
						$Estanque = $_POST["Estanque"][$i];

						if ($Can>0) {
							 
						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_TQ_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_UNIDADES, FD_ESTANQUE)
											VALUES('".$Uid."', '".$UidD."', '".$Can."', '".$Pro."', '".$Pre."', '".$Sub."', '".$UnidVn."', '".$Estanque."')") or die('Error Factura TQ Detalle '.mysqli_error());
						}

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
								$PrecioProductoNeto = round($PrecioProductoNeto, 5);
							}						

							if ($CodigoEstablecimiento==1) {
								 
							$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '4.01.03.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
						}
							$IVAProducto = (($Sub / 1.12) * 0.12);
							$SubNeto = $Sub - $IVAProducto;

							if($i != 0)
							{
								$MontoImpuesto = ($Sub * .12) / 1.12;
						    	$MontoGravable = $Sub - $MontoImpuesto;
						    	$Total = $MontoGravable + $MontoImpuesto;

								$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;						
							}
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 5);

							if($Pro == 657)
							{
								$queryAbonoProd = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_ABONO_PRODUCTO)
													  			VALUES('".$UID."', '".$UI."', ".$Pro.", ".$Can.")") or die(mysqli_error());

								$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");

								$IVAProducto = (($Sub / 1.12) * 0.12);
								$SubNeto = $Sub - $IVAProducto;

								if($i != 0)
								{
									$MontoImpuesto = ($Sub * .12) / 1.12;
							    	$MontoGravable = $Sub - $MontoImpuesto;
							    	$Total = $MontoGravable + $MontoImpuesto;

									$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;						
								}
							}
							else
							{

								if($Pro == 821)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2629)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								#Nuevos
								elseif($Pro == 2628)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2627)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.012', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2626)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.013', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2625)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.014', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2624)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.015', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2623)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.016', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}


								#Fin
								elseif($Pro == 822)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 2557)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.004', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 823)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.001.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 859)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 860)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 863)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.009', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 858)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 857)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.004', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 856)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 864)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 865)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 861)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 862)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.008', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 876)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 877)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 878)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 879)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.003', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 880)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.006', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 881)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 883)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 884)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 886)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.02.002', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 887)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.06.007', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 893)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 905)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.005', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1149)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1148)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.05.001', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1384)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.010', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								}
								elseif($Pro == 1358)
								{
									$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.01.013', 0.00, ".number_format($PrecioProductoNeto, 4, ".", "").")");
								} 

								$IVAProducto = (($Sub / 1.12) * 0.12);
								$SubNeto = $Sub - $IVAProducto;

								if($i != 0)
								{
									$MontoImpuesto = ($Sub * .12) / 1.12;
							    	$MontoGravable = $Sub - $MontoImpuesto;
							    	$Total = $MontoGravable + $MontoImpuesto;
						    	
									$XMLEnviar .= '
						          <dte:Item BienOServicio="B" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$Can.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProN.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 4, ".", "").'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProducto;
								$GranTotal = $GranTotal + $Sub;						
								}
							}
						}
					}

					$XMLEnviar .= '
					        </dte:Items>
					        <dte:Totales>
					          <dte:TotalImpuestos>
					            <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 4, ".", "").'"></dte:TotalImpuesto>
					          </dte:TotalImpuestos>
					          <dte:GranTotal>'.number_format($GranTotal, 2, ".", "").'</dte:GranTotal>
					        </dte:Totales>
					      </dte:DatosEmision>
					    </dte:DTE>
					  </dte:SAT>
					</dte:GTDocumento>';
				}

				//------------------------- CABECERA DEL DTE  -----------------------


				$url_servicio_firma = "https://signer-emisores.feel.com.gt/sign_solicitud_firmas/firma_xml";
        
				$encoded_xml =  base64_encode($XMLEnviar);

				$contenido_xml = array(
						'llave' => 'ca7d21d86285fb239d5cf10bd5d303fe',
					    'archivo' => $encoded_xml,
					    'codigo' => "n/a",
					    'alias' => 'ASOCRE',
					    'es_anulacion' => 'N'
					);             

				$json_body = json_encode( $contenido_xml );

				$response = \Httpful\Request::post($url_servicio_firma)             
				    ->sendsJson()                               
				    ->body($json_body)            
				    ->send();

				if($response->body->resultado == 1)
				{
					$NuevoXMLFirmado = $response->body->archivo;

					$contenido_xml_certi = array(
					    'nit_emisor' => "",
					    'correo_copia' => '',
					    'xml_dte' => $NuevoXMLFirmado
					);

					$json_body_certi = json_encode( $contenido_xml_certi );

					$uri = "https://certificador.feel.com.gt/fel/certificacion/v2/dte/";
						$responseCerti = \Httpful\Request::post($uri)
						->sendsJson()                               
						->body($json_body_certi)
						->addHeaders(array(
								  'usuario' => 'ASOCRE',             
							  	   'llave' => '6423B3029AEAE099309BF1930C6EB09D'           
							))            
						->send();   

					if($responseCerti->body->cantidad_errores == 0)
					{
						//Condicion si viene de No Asociados
						if(isset($_POST["Cantidadingreso"])){
							//obtener variables de NO Asociado para Guardar
							$NombreNoAsociado = $_POST["NombreNoAsociado"];
							$depto =  $_POST["depto"];
							$municipio= $_POST["municipio"];		
							$SelectVisitaEsquipulas = $_POST["SelectVisitaEsquipulas"];
							$EnteradoNoAsociado = $_POST["EnteradoNoAsociado"];
							$EdadNoAsociado = $_POST["EdadNoAsociado"];
							if($EdadNoAsociado == "")
								{
									$EdadNoAsociado = 0;
								}
							$SelectAsisteconNoAsociado = $_POST["SelectAsisteconNoAsociado"];
							$FrecuenciaVisitaNoAsociado = $_POST["FrecuenciaVisitaNoAsociado"];
							$CorreoNoAsociado = $_POST["CorreoNoAsociado"];
							$SelectConociaParque = $_POST["SelectConociaParque"];
							$BuscaNoAsociado = $_POST["BuscaNoAsociado"];
							$Cantidadingreso = $_POST['Cantidadingreso'];
							$NumeroTelefonoNoAsociado = $_POST['NumeroTelefonoNoAsociado']; 
	
							$GuardarNoAsociado = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_NO_ASOCIADO VALUES (NULL, '$NombreNoAsociado', 73, $depto, $municipio, $SelectVisitaEsquipulas, $EnteradoNoAsociado, $EdadNoAsociado, $SelectAsisteconNoAsociado, $FrecuenciaVisitaNoAsociado, '$CorreoNoAsociado', '$NumeroTelefonoNoAsociado', $SelectConociaParque, $BuscaNoAsociado, $id_user, CURDATE(), $Cantidadingreso[1], $Cantidadingreso[2], $Cantidadingreso[3], $Cantidadingreso[0]) ") or die("Error en guardar No Asociado".mysqli_error());
							}
								//Termina de guardar no Asociado

								$TotaldeBoletos = $TotalFacturaFinal/50;
$TotalFacturaFinal=number_format($TotalFacturaFinal, 2, ".", "");

		$Generar = "SELECT * FROM Bodega.BOLETO_GENERAR";
		$resultg = mysqli_query($db, $Generar);
		while($roweg = mysqli_fetch_array($resultg))
		{
			$Generar=$roweg["Generar"];

				}


				if($Generar==1){

				
					for($i=1; $i<=$TotaldeBoletos; $i++)
				{
					$querykardex = mysqli_query($db, "INSERT INTO Bodega.BOLETOS (B_PUNTO, B_FACTURA)
						VALUES('TAQUILLA #1', '".$Uid."')");

				}
			}
						?>
					   	<script>
					   		jQuery(document).ready(function($) {
					   			Imprimir();
					   		}); 
						</script>
					   <?php 
						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
							<h2 class="text-light">La factura se ingresó correctamente.</h2>
							<div class="row">
								<a href="VtaNew.php">
									<button type="button" class="btn btn-success btn-lg">
										<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
									</button>
								</a>
							</div>';

			           echo "NÚMERO DE AUTORIZACIÓN:   "."<b>".$responseCerti->body->uuid."</b>"."</p>";
			           echo "SERIE:   "."<b>".$responseCerti->body->serie."</b>"."</p>";
					   echo "NÚMERO DE FACTURA"."<b>".$responseCerti->body->numero."</b>"."</p>";	

					   
					   $QueryUpdateFactura = mysqli_query($db, "UPDATE Bodega.FACTURA_TQ SET F_SERIE = '".$responseCerti->body->serie."', F_CAE = '".$responseCerti->body->numero."', F_DTE = '".$responseCerti->body->uuid."', F_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionBodega = mysqli_query($db, "UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Vta. Taquilla No.1 Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionContabilidad = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Vta. Taquilla No.1 Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."', TRA_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE TRA_CODIGO = '".$Uid."'");
					}
					else
					{
						$QueryBitacora = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA 
						SELECT FACTURA_TQ.F_CODIGO, '5', FACTURA_TQ.F_ORDEN, FACTURA_TQ.F_SERIE, FACTURA_TQ.F_NUMERO, FACTURA_TQ.F_TIPO, FACTURA_TQ.CLI_NIT, FACTURA_TQ.D_CODIGO, FACTURA_TQ.F_CON_DESCUENTO, FACTURA_TQ.F_TOTAL, FACTURA_TQ.F_EFECTIVO, FACTURA_TQ.F_CAMBIO, FACTURA_TQ.F_FECHA_TRANS, FACTURA_TQ.F_HORA, FACTURA_TQ.F_USUARIO, FACTURA_TQ.F_MONEDA, FACTURA_TQ.F_ESTADO, FACTURA_TQ.F_RAZON_ANULACION, FACTURA_TQ.F_NOMBRE_CREDITO, FACTURA_TQ.F_NO_BOLETA, FACTURA_TQ.F_OBSERVACIONES, FACTURA_TQ.F_NO_AUTORIZACION, FACTURA_TQ.RES_NUMERO, FACTURA_TQ.F_CUENTA_BANCARIA, FACTURA_TQ.F_REALIZADA, FACTURA_TQ.F_CAE, FACTURA_TQ.F_DTE, FACTURA_TQ.F_FECHA_CERTIFICACION, FACTURA_TQ.F_TIPO_TARJETA FROM Bodega.FACTURA_TQ 
						WHERE  FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryBitacora1 = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA_DETALLE
							SELECT F_CODIGO, FD_CODIGO, FD_CORRELATIVO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_DESCUENTO, RS_CODIGO FROM Bodega.FACTURA_TQ_DETALLE
							WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());
					 		
							$QueryUnoRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ 
																WHERE FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryDosRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ_DETALLE
																WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryTresRestaurante = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
																FROM Bodega.TRANSACCION 
																INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
																WHERE TRANSACCION.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCuatroRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
																	WHERE TRANSACCION.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCincoRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
																	WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());
						echo ' <div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR! <i class="fa fa-caution text-danger"></i></span></h1>
							<h2 class="text-light">La factura tuvo un error.</h2>
							<div class="row">
								 <div style="margin:3em;">
									<button id="submit" onclick="Reimprimir()" type="button" class="btn btn-primary btn-lg">Re Imprimir</button> 
								</div>
							</div> ';
				      	echo '<br><ul>';

				      	foreach ($responseCerti->body->descripcion_errores as $errores) 
				      	{
					        echo '<li>'.$errores->mensaje_error.'</li>';
				      	}
				      
				      	echo '<br></ul>';
					}
				}
				else
				{
					$QueryBitacora = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA 
						SELECT FACTURA_TQ.F_CODIGO, '5', FACTURA_TQ.F_ORDEN, FACTURA_TQ.F_SERIE, FACTURA_TQ.F_NUMERO, FACTURA_TQ.F_TIPO, FACTURA_TQ.CLI_NIT, FACTURA_TQ.D_CODIGO, FACTURA_TQ.F_CON_DESCUENTO, FACTURA_TQ.F_TOTAL, FACTURA_TQ.F_EFECTIVO, FACTURA_TQ.F_CAMBIO, FACTURA_TQ.F_FECHA_TRANS, FACTURA_TQ.F_HORA, FACTURA_TQ.F_USUARIO, FACTURA_TQ.F_MONEDA, FACTURA_TQ.F_ESTADO, FACTURA_TQ.F_RAZON_ANULACION, FACTURA_TQ.F_NOMBRE_CREDITO, FACTURA_TQ.F_NO_BOLETA, FACTURA_TQ.F_OBSERVACIONES, FACTURA_TQ.F_NO_AUTORIZACION, FACTURA_TQ.RES_NUMERO, FACTURA_TQ.F_CUENTA_BANCARIA, FACTURA_TQ.F_REALIZADA, FACTURA_TQ.F_CAE, FACTURA_TQ.F_DTE, FACTURA_TQ.F_FECHA_CERTIFICACION, FACTURA_TQ.F_TIPO_TARJETA FROM Bodega.FACTURA_TQ 
						WHERE  FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryBitacora1 = mysqli_query($db, "INSERT INTO Bitacoras.FACTURA_DETALLE
							SELECT F_CODIGO, FD_CODIGO, FD_CORRELATIVO, FD_CANTIDAD, P_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL, FD_DESCUENTO, RS_CODIGO FROM Bodega.FACTURA_TQ_DETALLE
							WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());
					 		
							$QueryUnoRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ 
																WHERE FACTURA_TQ.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryDosRestaurante = mysqli_query($db, "DELETE 
																FROM Bodega.FACTURA_TQ_DETALLE
																WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryTresRestaurante = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
																FROM Bodega.TRANSACCION 
																INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
																WHERE TRANSACCION.F_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCuatroRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
																	WHERE TRANSACCION.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());

							$QueryCincoRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
																	WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$Uid."'")or die(mysqli_error());
						echo ' <div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR! <i class="fa fa-caution text-danger"></i></span></h1>
							<h2 class="text-light">La factura tuvo un error.</h2>
							<div class="row">
								 <div style="margin:3em;">
									<button id="submit" onclick="Reimprimir()" type="button" class="btn btn-primary btn-lg">Re Imprimir</button> 
								</div>
							</div> ';
				      	echo '<br><ul>';
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
	 
</body>
</html>
