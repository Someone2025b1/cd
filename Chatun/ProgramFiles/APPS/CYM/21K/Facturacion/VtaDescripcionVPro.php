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
	
	<script>
		function Imprimir()
		{
			var Cod = document.getElementById('CodigoFactura').value;

			window.open('FactImpNew.php?Codigo='+Cod, '_blank');
			
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

			$UI        = uniqid("tra_");
			$UID       = uniqid("trad_");
			$KCod=uniqid('KR_');
			$Uid       = uniqid("F_");
			$UidD      = uniqid("FD_");
			$CCod      = uniqid("CC_");
			$Centinela = true;
			$Contador  = count($_POST["Cantidad"]);
			$ContadorD  = count($_POST["CantidadDes"]);
			$TotalDescuentoFactura = 0;

			$FechaHoraHoy = date('Y-m-d', strtotime('now')).'T'.date('H:i:s', strtotime('now'));
			$CodigoEstablecimiento = 3;
			$CorreoEmisor = 'info@parquechatun.com';
			$NITEmisor = '92066097';
			$NombreComercial = '21K ESQUIPULAS';
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
			$TotalFacturaFinal        = $_POST["TotalDescripcion"];
			$TipoMoneda               = $_POST["MonedaPagoInput"];
			$Observaciones 			  = $_POST["Direccion"];
			$EventoPertenece          = $_POST["EventoPertenece"];
			$TipoFactura          = $_POST["TipoFactura"];

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
			$PuntoDeVenta = $_POST["PuntoDeVenta"];

			$CantidadDes       = $_POST["CantidadDes"];
			$DescripcionFac       = $_POST["DescripcionFac"];
			$PrecioDes         = $_POST["PrecioDes"];
			$SubTotalDes       = $_POST["SubtotalDescr"];

			$NIT       = $_POST["NIT"];
			$DPI       = $_POST["DPI"];
			$Pasaporte       = $_POST["Pasaporte"];
			$TipoDoc       = $_POST["TipoDoc"];

			$Nombre    = strtoupper($_POST["Nombre"]);
			$Direccion = strtoupper($_POST["Direccion"]);

			

			$CodigoPostalReceptor = '01001';
			$MunicipioReceptor = 'GUATEMALA';
			$DepartamentoReceptor = 'GUATEMALA';
			$PaisReceptor = 'GT';
if($TipoDoc=="N"){
	
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

}elseif($TipoDoc=="D"){

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
			        <dte:Receptor CorreoReceptor="'.$CorreoReceptor.'" IDReceptor="'.$DPI.'" NombreReceptor="'.$Nombre.'" TipoEspecial="CUI">
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

					$NIT=$DPI;


}elseif($TipoDoc=="P"){

	$CodigoPostalReceptor = '01001';
			$MunicipioReceptor = 'EL SALVADOR';
			$DepartamentoReceptor = 'EL SALVADOR';
			$PaisReceptor = 'SV';

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
			        <dte:Receptor CorreoReceptor="'.$CorreoReceptor.'" IDReceptor="'.$Pasaporte.'" NombreReceptor="'.$Nombre.'" TipoEspecial="EXT">
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

					$NIT=$Pasaporte;

}
			//Si el número de NIT NO esta registrado
			//Se crea un nuevo cliente con los datos ingresados anteriormente
			$sql = mysqli_query($db, "INSERT INTO Bodega.CLIENTE (CLI_NIT, CLI_NOMBRE, CLI_DIRECCION) VALUES ('".$NIT."', '".$Nombre."', '".$Direccion."')ON DUPLICATE KEY UPDATE CLI_NOMBRE = '".$Nombre."', CLI_DIRECCION = '".$Direccion."'");

			if(!$sql)
			{
				echo 'ERROR EN INGRESO DE CLIENTE';
				
			}
			
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

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_EV (F_CODIGO, F_SERIE, F_TIPO, CLI_NIT, F_TOTAL, F_FECHA_TRANS, F_HORA, F_USUARIO, F_MONEDA, F_EFECTIVO, F_CAMBIO, F_OBSERVACIONES, RES_NUMERO, F_DESCRIPCIONES)
												VALUES ('".$Uid."', '".$SerieAutorizada."', 1, '".$NIT."', ".$TotalFacturaFinal.", CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user.", ".$Moneda.", ".$Efectivo.", ".$Cambio.", '".$Observaciones."', '".$NumeroResolucion."', 1)") or die('Encabezado Factura 1'.mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Eventos Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 15, 1, '".$Uid."')") or die('Encabezado Bodega 1 '.mysqli_error());

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
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Eventos Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 32, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die('Encabezado Conta 1'.mysqli_error());

				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.01.006', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");
																								
				$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
				VALUES('".$Uid."', '".$UidD."', '4.01.03.002', 0.00, ".number_format($VentaSinIVA, 4, ".", "").")");
				


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
						$Des = $Descuento[$i];
						$Tip = $TipoProducto[$i];
						$ProN = $ProductoNombre[$i];

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_EV_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
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
								$PrecioProductoNeto = round($PrecioProductoNeto, 5);
							}						

							
							
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 5);

							$ConsultaNomenclatura = mysqli_query($db, "SELECT N_CODIGO
																	FROM Bodega.PRODUCTO AS A
																	WHERE A.P_CODIGO = ".$Pro);
							$FilaNomenclatura = mysqli_fetch_array($ConsultaNomenclatura);
							
							
						
						}
					}


					for($i=1; $i<$ContadorD; $i++)
					{
						$CanD = $CantidadDes[$i];
						$ProD = $DescripcionFac[$i];
						$PreD = $PrecioDes[$i];
						$SubD = $SubTotalDes[$i];
						

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_EV_DESCRIPCION (F_CODIGO, FD_CODIGO, FD_CANTIDAD, FD_DESCRIPCION, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', '".$CanD."', '".$ProD."', '".$PreD."', '".$SubD."')") or die('Error Factura TQ Detalle '.mysqli_error());

						
						
							$TotalIVAProductoD = ((($PreD * $CanD) * 0.12) / 1.12);
							$PrecioProductoNetoD = ($PreD * $CanD) - $TotalIVAProductoD;
							$PrecioProductoNetoD = round($PrecioProductoNetoD, 5);

							$IVAProductoD = (($SubD / 1.12) * 0.12);
							$SubNetoD = $SubD - $IVAProductoD;

						
								$MontoImpuestoD = ($SubD * .12) / 1.12;
						    	$MontoGravableD = $SubD - $MontoImpuestoD;
						    	$TotalD = $MontoGravableD + $MontoImpuestoD;

								$XMLEnviar .= '
						          <dte:Item BienOServicio="S" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$CanD.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProD.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($PreD, 3, '.', '').'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($SubD, 3, '.', '').'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravableD, 3, '.', '').'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuestoD, 3, '.', '').'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($TotalD, 2, '.', '').'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProductoD;
								$GranTotal = $GranTotal + $TotalD;					
							
						
					}


					$XMLEnviar .= '
						        </dte:Items>
						        <dte:Totales>
						          <dte:TotalImpuestos>
						            <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 3, '.', '').'"></dte:TotalImpuesto>
						          </dte:TotalImpuestos>
						          <dte:GranTotal>'.number_format($GranTotal, 3, '.', '').'</dte:GranTotal>
						        </dte:Totales>
						      </dte:DatosEmision>
						    </dte:DTE>
						  </dte:SAT>
						</dte:GTDocumento>';
				}

				//------------------------- CABECERA DEL DTE  -----------------------

				echo $XMLEnviar;
				
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

						## Kardex
					$SerieAutorizada             = $_POST["SerieAutorizada"];
					$FacturaNumero            = $_POST["FacturaNumero"];
					for($i=1; $i<$Contador; $i++)
				{
					$ProN = $ProductoNombre[$i]; 
					$PuntoV=$PuntoDeVenta[$i-1];
					$Can = $Cantidad[$i];
					$Pro = $Producto[$i];
					$Pre = $Precio[$i];
					$Sub = ($Pre*$Can); 
					$Des = $Descuento[$i];  
					$SubFac = ($Pre*$Can) - $Des;
					$Tip = $Tipo[$i];
					$ProductoXplotado = explode("/", $Pro);

					$Prod = $ProductoXplotado[0];

					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$Prod;
					$result = mysqli_query($db, $queryp);
					while($rowe = mysqli_fetch_array($result))
					{
						if($rowe["P_LLEVA_EXISTENCIA"]==1){

						
							if($PuntoV==1){

						$existenciaAn=$rowe["P_EXISTENCIA_TERRAZAS"];
						$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

						$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;

						$nuevaexistencia = $rowe["P_EXISTENCIA_TERRAZAS"] - $Can;

					

					$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
					P_EXISTENCIA_TERRAZAS = '".$nuevaexistencia."',
					P_EXISTENCIA_GENERAL = '".$cantidadgen."'
					WHERE P_CODIGO = ".$Prod);
							}elseif($PuntoV==2){

								$existenciaAn=$rowe["P_EXISTENCIA_SOUVENIRS"];
								$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];
		
								$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;
		
								$nuevaexistencia = $rowe["P_EXISTENCIA_SOUVENIRS"] - $Can;
		
							
		
							$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
							P_EXISTENCIA_SOUVENIRS = '".$nuevaexistencia."',
							P_EXISTENCIA_GENERAL = '".$cantidadgen."'
							WHERE P_CODIGO = ".$Prod);
									}elseif($PuntoV==3){

										$existenciaAn=$rowe["P_EXISTENCIA_HELADOS"];
										$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];
				
										$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;
				
										$nuevaexistencia = $rowe["P_EXISTENCIA_HELADOS"] - $Can;
				
									
				
									$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
									P_EXISTENCIA_HELADOS = '".$nuevaexistencia."',
									P_EXISTENCIA_GENERAL = '".$cantidadgen."'
									WHERE P_CODIGO = ".$Prod);
											}
											elseif($PuntoV==4){

												$existenciaAn=$rowe["P_EXISTENCIA_CAFE"];
												$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];
						
												$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;
						
												$nuevaexistencia = $rowe["P_EXISTENCIA_CAFE"] - $Can;
						
											
						
											$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
											P_EXISTENCIA_CAFE = '".$nuevaexistencia."',
											P_EXISTENCIA_GENERAL = '".$cantidadgen."'
											WHERE P_CODIGO = ".$Prod);
													}

					}else{
						#PARA REGISTRAR  TODOS LOS INGREDIENTES
						if($rowe["R_CODIGO"]!=NULL){
							$CodReceta=$rowe["R_CODIGO"];

							$queryr = "SELECT * FROM Productos.RECETA_DETALLE WHERE R_CODIGO ='$CodReceta'";
							$resultr = mysqli_query($db, $queryr);
							while($rower = mysqli_fetch_array($resultr))
							{
								$ProdR=$rower["P_CODIGO"];
								$CanR=$rower["RD_CANTIDAD"] * $Can;
								$querypR = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdR;
								$resultR = mysqli_query($db, $querypR);
								while($roweR = mysqli_fetch_array($resultR))
								{
									if($PuntoV==1){

									$existenciaAnR=$roweR["P_EXISTENCIA_TERRAZAS"];
									$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

									$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

									$nuevaexistenciaR = $roweR["P_EXISTENCIA_TERRAZAS"] - $CanR;

								

								$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
								P_EXISTENCIA_TERRAZAS = '".$nuevaexistenciaR."',
								P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
								WHERE P_CODIGO = ".$ProdR);

							}elseif($PuntoV==3){

								$existenciaAnR=$roweR["P_EXISTENCIA_HELADOS"];
								$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

								$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

								$nuevaexistenciaR = $roweR["P_EXISTENCIA_HELADOS"] - $CanR;

							

							$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
							P_EXISTENCIA_HELADOS = '".$nuevaexistenciaR."',
							P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
							WHERE P_CODIGO = ".$ProdR);

						}elseif($PuntoV==4){

							$existenciaAnR=$roweR["P_EXISTENCIA_CAFE"];
							$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

							$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

							$nuevaexistenciaR = $roweR["P_EXISTENCIA_CAFE"] - $CanR;

						

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_CAFE = '".$nuevaexistenciaR."',
						P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
						WHERE P_CODIGO = ".$ProdR);

					}
								}

								$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
								VALUES('".$KCod."', '".$Uid."', '".$ProdR."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Venta de Producto Segun Factura de Eventos Serie Número "."$SerieAutorizada"."  "."$FacturaNumero"."', '".$existenciaGAnR."', '".$cantidadgenR."', '".$PuntoV."', '".$existenciaAnR."', '".$nuevaexistenciaR."')");

								
							}

							$existenciaAn=1;
							$existenciaGAn=1;

							$cantidadgen = 1;

							$nuevaexistencia = 1;

						}else{
							$existenciaAn=0;
							$existenciaGAn=0;

							$cantidadgen = 0;

							$nuevaexistencia = 0;

						}
						
					}



					$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
					VALUES('".$KCod."', '".$Uid."', '".$Prod."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Venta de Producto Segun Factura de Eventos Serie Número "."$SerieAutorizada"."  "."$FacturaNumero"."', '".$existenciaGAn."', '".$cantidadgen."', '".$PuntoV."', '".$existenciaAn."', '".$nuevaexistencia."')");

					}
				}
							#PARA SACAR LAS BOLAS DE HELADO
							$QuerySelSabores = "SELECT * FROM Bodega.TEMPORAL_SABORES WHERE TS_CODIGO_USUARIO=".$id_user;
							$ResultSelSabores = mysqli_query($db, $QuerySelSabores);
							$RegistrosSelSabores = mysqli_num_rows($ResultSelSabores);
							if($RegistrosSelSabores > 0)
							{
								while($FilaSelSabores = mysqli_fetch_array($ResultSelSabores))
								{
									$CodProdSabor = $FilaSelSabores["TS_CODIGO_PRODUCTO"];
									$CanR=3;

									$querypR = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$CodProdSabor;
								$resultR = mysqli_query($db, $querypR);
								while($roweR = mysqli_fetch_array($resultR))
								{


									$existenciaAnR=$roweR["P_EXISTENCIA_HELADOS"];
									$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

									$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

									$nuevaexistenciaR = $roweR["P_EXISTENCIA_HELADOS"] - $CanR;

								

								$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
								P_EXISTENCIA_HELADOS = '".$nuevaexistenciaR."',
								P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
								WHERE P_CODIGO = ".$CodProdSabor);

									
								}

								$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
								VALUES('".$KCod."', '".$Uid."', '".$CodProdSabor."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Venta de Producto Segun Factura de Eventos Serie Número "."$SerieAutorizada"."  "."$FacturaNumero"."', '".$existenciaGAnR."', '".$cantidadgenR."', 3, '".$existenciaAnR."', '".$nuevaexistenciaR."')");

									
								}

								
							}

######################## FIN KARDEX ####################

$QueryEvento= mysqli_query($db, "UPDATE Eventos.EVENTO SET
								F_CODIGO = '".$Uid."'
								WHERE EV_CODIGO = '$EventoPertenece'");

						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
							<h2 class="text-light">La factura se ingresó correctamente.</h2>
							<div class="row">
								<a href="VtaDescripcion.php">
									<button type="button" class="btn btn-success btn-lg">
										<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
									</button>
								</a>
							</div>';

			           echo "NÚMERO DE AUTORIZACIÓN:   "."<b>".$responseCerti->body->uuid."</b>"."</p>";
			           echo "SERIE:   "."<b>".$responseCerti->body->serie."</b>"."</p>";
					   echo "NÚMERO DE FACTURA"."<b>".$responseCerti->body->numero."</b>"."</p>";	

					   
					   $QueryUpdateFactura = mysqli_query($db, "UPDATE Bodega.FACTURA_EV SET F_SERIE = '".$responseCerti->body->serie."', F_CAE = '".$responseCerti->body->numero."', F_DTE = '".$responseCerti->body->uuid."', F_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionBodega = mysqli_query($db, "UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Vta. Eventos Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionContabilidad = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Vta. Eventos Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."', TRA_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE TRA_CODIGO = '".$Uid."'");
					}
					else
					{
				      	echo '<br><ul>';

				      	foreach ($responseCerti->body->descripcion_errores as $errores) 
				      	{
					        echo '<li>'.$errores->mensaje_error.'</li>';
				      	}
				      
				      	echo '<br></ul>';
					}
				}
			}
			elseif($TipoPago == 2)
			{
				$NumeroAutorizacionTXT = $_POST["NumeroAutorizacionTXT"];

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_EV (F_CODIGO, F_SERIE, F_TIPO, CLI_NIT, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_OBSERVACIONES, F_NO_AUTORIZACION, RES_NUMERO, F_DESCRIPCIONES)
												VALUES ('".$Uid."', '".$SerieAutorizada."', 2, '".$NIT."', ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.", '".$Observaciones."', '".$NumeroAutorizacionTXT."', '".$NumeroResolucion."', 1)") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Eventos Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 15, 1, '".$Uid."')") or die(mysqli_error());

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
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Eventos Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 32, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());

				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.010', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");		
												
				$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.03.002', 0.00, ".number_format($VentaSinIVA, 4, ".", "").")");
												


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

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_EV_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
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
													  			VALUES('".$UID."', '".$UI."', ".$ProductoCodigo.", ".number_format($TotalDescargo, 2, ".", "").")") or die(mysqli_error());

								$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
								$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
								$PrecioProductoNeto = round($PrecioProductoNeto, 5);
							}						

							
							$IVAProducto = (($Sub / 1.12) * 0.12);
							$SubNeto = $Sub - $IVAProducto;

						
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 5);

							
							$ConsultaNomenclatura = mysqli_query($db, "SELECT N_CODIGO
																	FROM Bodega.PRODUCTO AS A
																	WHERE A.P_CODIGO = ".$Pro);
							$FilaNomenclatura = mysqli_fetch_array($ConsultaNomenclatura);
							
							
							$IVAProducto = (($Sub / 1.12) * 0.12);
							$SubNeto = $Sub - $IVAProducto;

						}

					}

					
					for($i=1; $i<$ContadorD; $i++)
					{
						$CanD = $CantidadDes[$i];
						$ProD = $DescripcionFac[$i];
						$PreD = $PrecioDes[$i];
						$SubD = $SubTotalDes[$i];
						

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_EV_DESCRIPCION (F_CODIGO, FD_CODIGO, FD_CANTIDAD, FD_DESCRIPCION, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', '".$CanD."', '".$ProD."', '".$PreD."', '".$SubD."')") or die('Error Factura TQ Detalle '.mysqli_error());

						
						
							$TotalIVAProductoD = ((($PreD * $CanD) * 0.12) / 1.12);
							$PrecioProductoNetoD = ($PreD * $CanD) - $TotalIVAProductoD;
							$PrecioProductoNetoD = round($PrecioProductoNetoD, 5);

							$IVAProductoD = (($SubD / 1.12) * 0.12);
							$SubNetoD = $SubD - $IVAProductoD;

						
								$MontoImpuestoD = ($SubD * .12) / 1.12;
						    	$MontoGravableD = $SubD - $MontoImpuestoD;
						    	$TotalD = $MontoGravableD + $MontoImpuestoD;

								$XMLEnviar .= '
						          <dte:Item BienOServicio="S" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$CanD.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProD.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($PreD, 3, '.', '').'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($SubD, 3, '.', '').'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravableD, 3, '.', '').'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuestoD, 3, '.', '').'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($TotalD, 2, '.', '').'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProductoD;
								$GranTotal = $GranTotal + $TotalD;					
							
						
					}

					$XMLEnviar .= '
						        </dte:Items>
						        <dte:Totales>
						          <dte:TotalImpuestos>
						            <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 3, '.', '').'"></dte:TotalImpuesto>
						          </dte:TotalImpuestos>
						          <dte:GranTotal>'.number_format($GranTotal, 3, '.', '').'</dte:GranTotal>
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
						## Kardex
					$SerieAutorizada             = $_POST["SerieAutorizada"];
					$FacturaNumero            = $_POST["FacturaNumero"];
					for($i=1; $i<$Contador; $i++)
				{
					$ProN = $ProductoNombre[$i]; 
					$PuntoV=$PuntoDeVenta[$i-1];
					$Can = $Cantidad[$i];
					$Pro = $Producto[$i];
					$Pre = $Precio[$i];
					$Sub = ($Pre*$Can); 
					$Des = $Descuento[$i];  
					$SubFac = ($Pre*$Can) - $Des;
					$Tip = $Tipo[$i];
					$ProductoXplotado = explode("/", $Pro);

					$Prod = $ProductoXplotado[0];

					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$Prod;
					$result = mysqli_query($db, $queryp);
					while($rowe = mysqli_fetch_array($result))
					{
						if($rowe["P_LLEVA_EXISTENCIA"]==1){

						
							if($PuntoV==1){

						$existenciaAn=$rowe["P_EXISTENCIA_TERRAZAS"];
						$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

						$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;

						$nuevaexistencia = $rowe["P_EXISTENCIA_TERRAZAS"] - $Can;

					

					$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
					P_EXISTENCIA_TERRAZAS = '".$nuevaexistencia."',
					P_EXISTENCIA_GENERAL = '".$cantidadgen."'
					WHERE P_CODIGO = ".$Prod);
							}elseif($PuntoV==2){

								$existenciaAn=$rowe["P_EXISTENCIA_SOUVENIRS"];
								$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];
		
								$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;
		
								$nuevaexistencia = $rowe["P_EXISTENCIA_SOUVENIRS"] - $Can;
		
							
		
							$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
							P_EXISTENCIA_SOUVENIRS = '".$nuevaexistencia."',
							P_EXISTENCIA_GENERAL = '".$cantidadgen."'
							WHERE P_CODIGO = ".$Prod);
									}elseif($PuntoV==3){

										$existenciaAn=$rowe["P_EXISTENCIA_HELADOS"];
										$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];
				
										$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;
				
										$nuevaexistencia = $rowe["P_EXISTENCIA_HELADOS"] - $Can;
				
									
				
									$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
									P_EXISTENCIA_HELADOS = '".$nuevaexistencia."',
									P_EXISTENCIA_GENERAL = '".$cantidadgen."'
									WHERE P_CODIGO = ".$Prod);
											}
											elseif($PuntoV==4){

												$existenciaAn=$rowe["P_EXISTENCIA_CAFE"];
												$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];
						
												$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;
						
												$nuevaexistencia = $rowe["P_EXISTENCIA_CAFE"] - $Can;
						
											
						
											$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
											P_EXISTENCIA_CAFE = '".$nuevaexistencia."',
											P_EXISTENCIA_GENERAL = '".$cantidadgen."'
											WHERE P_CODIGO = ".$Prod);
													}

					}else{
						#PARA REGISTRAR  TODOS LOS INGREDIENTES
						if($rowe["R_CODIGO"]!=NULL){
							$CodReceta=$rowe["R_CODIGO"];

							$queryr = "SELECT * FROM Productos.RECETA_DETALLE WHERE R_CODIGO ='$CodReceta'";
							$resultr = mysqli_query($db, $queryr);
							while($rower = mysqli_fetch_array($resultr))
							{
								$ProdR=$rower["P_CODIGO"];
								$CanR=$rower["RD_CANTIDAD"] * $Can;
								$querypR = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdR;
								$resultR = mysqli_query($db, $querypR);
								while($roweR = mysqli_fetch_array($resultR))
								{
									if($PuntoV==1){

									$existenciaAnR=$roweR["P_EXISTENCIA_TERRAZAS"];
									$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

									$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

									$nuevaexistenciaR = $roweR["P_EXISTENCIA_TERRAZAS"] - $CanR;

								

								$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
								P_EXISTENCIA_TERRAZAS = '".$nuevaexistenciaR."',
								P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
								WHERE P_CODIGO = ".$ProdR);

							}elseif($PuntoV==3){

								$existenciaAnR=$roweR["P_EXISTENCIA_HELADOS"];
								$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

								$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

								$nuevaexistenciaR = $roweR["P_EXISTENCIA_HELADOS"] - $CanR;

							

							$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
							P_EXISTENCIA_HELADOS = '".$nuevaexistenciaR."',
							P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
							WHERE P_CODIGO = ".$ProdR);

						}elseif($PuntoV==4){

							$existenciaAnR=$roweR["P_EXISTENCIA_CAFE"];
							$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

							$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

							$nuevaexistenciaR = $roweR["P_EXISTENCIA_CAFE"] - $CanR;

						

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_CAFE = '".$nuevaexistenciaR."',
						P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
						WHERE P_CODIGO = ".$ProdR);

					}
								}

								$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
								VALUES('".$KCod."', '".$Uid."', '".$ProdR."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Venta de Producto Segun Factura de Eventos Serie Número "."$SerieAutorizada"."  "."$FacturaNumero"."', '".$existenciaGAnR."', '".$cantidadgenR."', '".$PuntoV."', '".$existenciaAnR."', '".$nuevaexistenciaR."')");

								
							}

							$existenciaAn=1;
							$existenciaGAn=1;

							$cantidadgen = 1;

							$nuevaexistencia = 1;

						}else{
							$existenciaAn=0;
							$existenciaGAn=0;

							$cantidadgen = 0;

							$nuevaexistencia = 0;

						}
						
					}



					$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
					VALUES('".$KCod."', '".$Uid."', '".$Prod."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Venta de Producto Segun Factura de Eventos Serie Número "."$SerieAutorizada"."  "."$FacturaNumero"."', '".$existenciaGAn."', '".$cantidadgen."', '".$PuntoV."', '".$existenciaAn."', '".$nuevaexistencia."')");

					}
				}
							#PARA SACAR LAS BOLAS DE HELADO
							$QuerySelSabores = "SELECT * FROM Bodega.TEMPORAL_SABORES WHERE TS_CODIGO_USUARIO=".$id_user;
							$ResultSelSabores = mysqli_query($db, $QuerySelSabores);
							$RegistrosSelSabores = mysqli_num_rows($ResultSelSabores);
							if($RegistrosSelSabores > 0)
							{
								while($FilaSelSabores = mysqli_fetch_array($ResultSelSabores))
								{
									$CodProdSabor = $FilaSelSabores["TS_CODIGO_PRODUCTO"];
									$CanR=3;

									$querypR = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$CodProdSabor;
								$resultR = mysqli_query($db, $querypR);
								while($roweR = mysqli_fetch_array($resultR))
								{


									$existenciaAnR=$roweR["P_EXISTENCIA_HELADOS"];
									$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

									$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

									$nuevaexistenciaR = $roweR["P_EXISTENCIA_HELADOS"] - $CanR;

								

								$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
								P_EXISTENCIA_HELADOS = '".$nuevaexistenciaR."',
								P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
								WHERE P_CODIGO = ".$CodProdSabor);

									
								}

								$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
								VALUES('".$KCod."', '".$Uid."', '".$CodProdSabor."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Venta de Producto Segun Factura de Eventos Serie Número "."$SerieAutorizada"."  "."$FacturaNumero"."', '".$existenciaGAnR."', '".$cantidadgenR."', 3, '".$existenciaAnR."', '".$nuevaexistenciaR."')");

									
								}

								
							}

######################## FIN KARDEX ####################

$QueryEvento= mysqli_query($db, "UPDATE Eventos.EVENTO SET
								F_CODIGO = '".$Uid."'
								WHERE EV_CODIGO = '$EventoPertenece'");

						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
							<h2 class="text-light">La factura se ingresó correctamente.</h2>
							<div class="row">
								<a href="VtaDescripcion.php">
									<button type="button" class="btn btn-success btn-lg">
										<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
									</button>
								</a>
							</div>';

			           echo "NÚMERO DE AUTORIZACIÓN:   "."<b>".$responseCerti->body->uuid."</b>"."</p>";
			           echo "SERIE:   "."<b>".$responseCerti->body->serie."</b>"."</p>";
					   echo "NÚMERO DE FACTURA"."<b>".$responseCerti->body->numero."</b>"."</p>";	

					   
					   $QueryUpdateFactura = mysqli_query($db, "UPDATE Bodega.FACTURA_EV SET F_SERIE = '".$responseCerti->body->serie."', F_CAE = '".$responseCerti->body->numero."', F_DTE = '".$responseCerti->body->uuid."', F_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionBodega = mysqli_query($db, "UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Vta. Eventos Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionContabilidad = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Vta. Eventos Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."', TRA_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE TRA_CODIGO = '".$Uid."'");
					}
					else
					{
				      	echo '<br><ul>';

				      	foreach ($responseCerti->body->descripcion_errores as $errores) 
				      	{
					        echo '<li>'.$errores->mensaje_error.'</li>';
				      	}
				      
				      	echo '<br></ul>';
					}
				}
			}
			elseif($TipoPago == 3)
			{
				$NombreCredito = $_POST["NombreCreditoTXT"];

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_21K (F_CODIGO, F_SERIE, F_TIPO, CLI_NIT, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_NOMBRE_CREDITO, F_OBSERVACIONES, RES_NUMERO, F_DESCRIPCIONES)
												VALUES ('".$Uid."', '".$SerieAutorizada."', 3, '".$NIT."', ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.",  '".$NombreCredito."', '".$Observaciones."', '".$NumeroResolucion."', 1)") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Factura 21K Según ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 15, 1, '".$Uid."')") or die(mysqli_error());

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
										 VALUES('".$Uid."', CURRENT_DATE(), 'Factura 21K Según ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 32, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());

				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.014', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");
																								
				$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '".$TipoFactura."', 0.00, ".number_format($VentaSinIVA, 4, ".", "").")");
				


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
					

					for($i=1; $i<$ContadorD; $i++)
					{
						$CanD = $CantidadDes[$i];
						$ProD = $DescripcionFac[$i];
						$PreD = $PrecioDes[$i];
						$SubD = $SubTotalDes[$i];
						

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_21K_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, FD_DESCRIPCION, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', '".$CanD."', '".$ProD."', '".$PreD."', '".$SubD."')") or die('Error Factura TQ Detalle '.mysqli_error());

						
						
							$TotalIVAProductoD = ((($PreD * $CanD) * 0.12) / 1.12);
							$PrecioProductoNetoD = ($PreD * $CanD) - $TotalIVAProductoD;
							$PrecioProductoNetoD = round($PrecioProductoNetoD, 5);

							$IVAProductoD = (($SubD / 1.12) * 0.12);
							$SubNetoD = $SubD - $IVAProductoD;

						
								$MontoImpuestoD = ($SubD * .12) / 1.12;
						    	$MontoGravableD = $SubD - $MontoImpuestoD;
						    	$TotalD = $MontoGravableD + $MontoImpuestoD;

								$XMLEnviar .= '
						          <dte:Item BienOServicio="S" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$CanD.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProD.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($PreD, 3, '.', '').'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($SubD, 3, '.', '').'</dte:Precio>
						            <dte:Descuento>0.00</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravableD, 3, '.', '').'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuestoD, 3, '.', '').'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($TotalD, 2, '.', '').'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProductoD;
								$GranTotal = $GranTotal + $TotalD;					
							
						
					}

					$XMLEnviar .= '
						        </dte:Items>
						        <dte:Totales>
						          <dte:TotalImpuestos>
						            <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 3, '.', '').'"></dte:TotalImpuesto>
						          </dte:TotalImpuestos>
						          <dte:GranTotal>'.number_format($GranTotal, 3, '.', '').'</dte:GranTotal>
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
						

						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
							<h2 class="text-light">La factura se ingresó correctamente.</h2>
							<div class="row">
								<a href="VtaDescripcion.php">
									<button type="button" class="btn btn-success btn-lg">
										<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
									</button>
								</a>
							</div>';

			           echo "NÚMERO DE AUTORIZACIÓN:   "."<b>".$responseCerti->body->uuid."</b>"."</p>";
			           echo "SERIE:   "."<b>".$responseCerti->body->serie."</b>"."</p>";
					   echo "NÚMERO DE FACTURA"."<b>".$responseCerti->body->numero."</b>"."</p>";	

					   
					   $QueryUpdateFactura = mysqli_query($db, "UPDATE Bodega.FACTURA_21K SET F_SERIE = '".$responseCerti->body->serie."', F_CAE = '".$responseCerti->body->numero."', F_DTE = '".$responseCerti->body->uuid."', F_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionBodega = mysqli_query($db, "UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Factura 21K Según ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionContabilidad = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Factura 21K Según  ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."', TRA_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE TRA_CODIGO = '".$Uid."'");
						
					   ##### CUENTAS POR COBRAR
					  # $sqlCredito = mysqli_query($db, "INSERT INTO Contabilidad.CUENTAS_POR_COBRAR (CC_CODIGO, F_CODIGO, CC_ESTADO, CC_NIT, CC_REALIZO, CC_TOTAL, CC_PUNTO, CC_ABONO)
					  # VALUES ('".$CCod."', '".$Uid."', 1, '".$NIT."',  '".$id_user."', '".$TotalFacturaFinal."', 'EVENTOS', 0.00)");
					
					}
					else
					{
				      	echo '<br><ul>';

				      	foreach ($responseCerti->body->descripcion_errores as $errores) 
				      	{
					        echo '<li>'.$errores->mensaje_error.'</li>';
				      	}
				      
				      	echo '<br></ul>';
					}
				}
			}
			elseif($TipoPago == 4)
			{
				$NumeroBoleta = $_POST["NumeroBoleta"];
				$CuentaBancaria = $_POST["CuentaBancaria"];

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_21K (F_CODIGO, F_SERIE, F_TIPO, CLI_NIT, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_NO_BOLETA, F_OBSERVACIONES, RES_NUMERO, F_CUENTA_BANCARIA, F_DESCRIPCIONES)
												VALUES ('".$Uid."', '".$SerieAutorizada."', 4, '".$NIT."', ".$TotalFacturaFinal.", 0.00, 0.00, CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.",  '".$NumeroBoleta."', '".$Observaciones."', '".$NumeroResolucion."', '".$CuentaBancaria."', 1)") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Factura 21K Según ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 15, 1, '".$Uid."')") or die(mysqli_error());

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
										 VALUES('".$Uid."', CURRENT_DATE(), 'Factura 21K Según ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 32, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());

				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '".$CuentaBancaria."', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");
																								
				$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '".$TipoFactura."', 0.00, ".number_format($VentaSinIVA, 4, ".", "").")");
				


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
					
					for($i=1; $i<$ContadorD; $i++)
					{
						$CanD = $CantidadDes[$i];
						$ProD = $DescripcionFac[$i];
						$PreD = $PrecioDes[$i];
						$SubD = $SubTotalDes[$i];
						

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_21K_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, FD_DESCRIPCION, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', '".$CanD."', '".$ProD."', '".$PreD."', '".$SubD."')") or die('Error Factura TQ Detalle '.mysqli_error());

						
							
						
							$TotalIVAProductoD = ((($PreD * $CanD) * 0.12) / 1.12);
							$PrecioProductoNetoD = ($PreD * $CanD) - $TotalIVAProductoD;
							$PrecioProductoNetoD = round($PrecioProductoNetoD, 5);

							$IVAProductoD = (($SubD / 1.12) * 0.12);
							$SubNetoD = $SubD - $IVAProductoD;

						
								$MontoImpuestoD = ($SubD * .12) / 1.12;
						    	$MontoGravableD = $SubD - $MontoImpuestoD;
						    	$TotalD = $MontoGravableD + $MontoImpuestoD;

								$XMLEnviar .= '
						          <dte:Item BienOServicio="S" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$CanD.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProD.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($PreD, 3, '.', '').'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($SubD, 3, '.', '').'</dte:Precio>
						            <dte:Descuento>0.00</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravableD, 3, '.', '').'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuestoD, 3, '.', '').'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($TotalD, 2, '.', '').'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProductoD;
								$GranTotal = $GranTotal + $TotalD;					
							
						
					}

					$XMLEnviar .= '
						        </dte:Items>
						        <dte:Totales>
						          <dte:TotalImpuestos>
						            <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 3, '.', '').'"></dte:TotalImpuesto>
						          </dte:TotalImpuestos>
						          <dte:GranTotal>'.number_format($GranTotal, 3, '.', '').'</dte:GranTotal>
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
						
						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
							<h2 class="text-light">La factura se ingresó correctamente.</h2>
							<div class="row">
								<a href="VtaDescripcion.php">
									<button type="button" class="btn btn-success btn-lg">
										<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
									</button>
								</a>
							</div>';

			           echo "NÚMERO DE AUTORIZACIÓN:   "."<b>".$responseCerti->body->uuid."</b>"."</p>";
			           echo "SERIE:   "."<b>".$responseCerti->body->serie."</b>"."</p>";
					   echo "NÚMERO DE FACTURA"."<b>".$responseCerti->body->numero."</b>"."</p>";	

					   
					   $QueryUpdateFactura = mysqli_query($db, "UPDATE Bodega.FACTURA_21K SET F_SERIE = '".$responseCerti->body->serie."', F_CAE = '".$responseCerti->body->numero."', F_DTE = '".$responseCerti->body->uuid."', F_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionBodega = mysqli_query($db, "UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Factura 21K Según ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionContabilidad = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Factura 21K Según ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."', TRA_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE TRA_CODIGO = '".$Uid."'");
					}
					else
					{
				      	echo '<br><ul>';

				      	foreach ($responseCerti->body->descripcion_errores as $errores) 
				      	{
					        echo '<li>'.$errores->mensaje_error.'</li>';
				      	}
				      
				      	echo '<br></ul>';
					}
				}
			}

			elseif($TipoPago == 5){
				###VARIABLES PAGO MIXTO
				$MontoEfectivoCon = $_POST["MontoME"];
				$MontoTarjeta = $_POST["MontoMT"];
				$AutorizacionM = $_POST["AutorizacionM"];
				$MontoBanco = $_POST["MontoMB"];
				$NumeroBoletaM = $_POST["NumeroBoletaM"];
				$CuentaBancariaM = $_POST["CuentaBancariaM"];
				$CodigoA = $_POST["CodigoA"];
				$NombreA = $_POST["NombreA"];
				$MontoMA = $_POST["MontoMA"];
				$CambioM = $_POST["CambioM"];
				$ContadorANTICIPO  = count($_POST["MontoMA"]);
				$MontoAnticipo = 0;

				$MontoEfectivo=$MontoEfectivoCon-$CambioM;

				#DETERMINAR TOTAL PAGO MIXTO Y ACTUALIZAR ESTADO DE LOS ANTICIPOS
				for($i=0; $i<$ContadorANTICIPO; $i++)
					{
						$CodA = $CodigoA[$i];
						$MonA = $MontoMA[$i];
						
						$MontoAnticipo+=$MonA;
					}


				###REGISTRO DEL ENCABEZADO
				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_EV (F_CODIGO, F_SERIE, F_TIPO, CLI_NIT, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_NO_BOLETA, F_OBSERVACIONES, RES_NUMERO, F_CUENTA_BANCARIA, F_NO_AUTORIZACION, F_EFECTIVO_M, F_TARJETA_M, F_BANCO_M, F_ANTICIPO_M, F_DESCRIPCIONES)
												VALUES ('".$Uid."', '".$SerieAutorizada."', 5, '".$NIT."', ".$TotalFacturaFinal.", 0.00, ".$CambioM.", CURRENT_DATE(), CURRENT_TIMESTAMP(),  ".$id_user.",  '".$NumeroBoletaM."', '".$Observaciones."', '".$NumeroResolucion."', '".$CuentaBancariaM."', '".$AutorizacionM."', ".$MontoEfectivo.", ".$MontoTarjeta.", ".$MontoBanco.", ".$MontoAnticipo.", 1)") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', CURRENT_DATE(), 'Vta. Eventos Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 15, 1, '".$Uid."')") or die(mysqli_error());

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
										 VALUES('".$Uid."', CURRENT_DATE(), 'Vta. Eventos Según Fact. ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 32, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());

				if($MontoBanco>0){

					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '".$CuentaBancariaM."', ".number_format($MontoBanco, 2, ".", "").", 0.00)");
				}
				if($MontoAnticipo>0){

					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.02.001', ".number_format($MontoAnticipo, 2, ".", "").", 0.00)");
				}
				if($MontoEfectivo>0){

					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.01.006', ".number_format($MontoEfectivo, 2, ".", "").", 0.00)");
				}
				if($MontoTarjeta>0){

					$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.010', ".number_format($MontoTarjeta, 2, ".", "").", 0.00)");
				}

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");
												
				$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.03.002', 0.00, ".number_format($VentaSinIVA, 4, ".", "").")");
												


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

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_EV_DETALLE (F_CODIGO, FD_CODIGO, FD_CANTIDAD, RS_CODIGO, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
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
								$PrecioProductoNeto = round($PrecioProductoNeto, 5);
							}						

							

							$IVAProducto = (($Sub / 1.12) * 0.12);
							$SubNeto = $Sub - $IVAProducto;

							
						}
						else
						{
							$TotalIVAProducto = ((($Pre * $Can) * 0.12) / 1.12);
							$PrecioProductoNeto = ($Pre * $Can) - $TotalIVAProducto;
							$PrecioProductoNeto = round($PrecioProductoNeto, 5);

							
							$ConsultaNomenclatura = mysqli_query($db, "SELECT N_CODIGO
																	FROM Bodega.PRODUCTO AS A
																	WHERE A.P_CODIGO = ".$Pro);
							$FilaNomenclatura = mysqli_fetch_array($ConsultaNomenclatura);
							
							
							$IVAProducto = (($Sub / 1.12) * 0.12);
							$SubNeto = $Sub - $IVAProducto;

							
						}
					}

					for($i=1; $i<$ContadorD; $i++)
					{
						$CanD = $CantidadDes[$i];
						$ProD = $DescripcionFac[$i];
						$PreD = $PrecioDes[$i];
						$SubD = $SubTotalDes[$i];
						

						$query = mysqli_query($db, "INSERT INTO Bodega.FACTURA_EV_DESCRIPCION (F_CODIGO, FD_CODIGO, FD_CANTIDAD, FD_DESCRIPCION, FD_PRECIO_UNITARIO, FD_SUBTOTAL)
											VALUES('".$Uid."', '".$UidD."', '".$CanD."', '".$ProD."', '".$PreD."', '".$SubD."')") or die('Error Factura TQ Detalle '.mysqli_error());

						
						
							$TotalIVAProductoD = ((($PreD * $CanD) * 0.12) / 1.12);
							$PrecioProductoNetoD = ($PreD * $CanD) - $TotalIVAProductoD;
							$PrecioProductoNetoD = round($PrecioProductoNetoD, 5);

							$IVAProductoD = (($SubD / 1.12) * 0.12);
							$SubNetoD = $SubD - $IVAProductoD;

						
								$MontoImpuestoD = ($SubD * .12) / 1.12;
						    	$MontoGravableD = $SubD - $MontoImpuestoD;
						    	$TotalD = $MontoGravableD + $MontoImpuestoD;

								$XMLEnviar .= '
						          <dte:Item BienOServicio="S" NumeroLinea="'.$i.'">
						            <dte:Cantidad>'.$CanD.'</dte:Cantidad>
						            <dte:UnidadMedida>UND</dte:UnidadMedida>
						            <dte:Descripcion>'.$ProD.'</dte:Descripcion>
						            <dte:PrecioUnitario>'.number_format($PreD, 3, '.', '').'</dte:PrecioUnitario>
						            <dte:Precio>'.number_format($SubD, 3, '.', '').'</dte:Precio>
						            <dte:Descuento>'.$Des.'</dte:Descuento>
						            <dte:Impuestos>
						              <dte:Impuesto>
						                <dte:NombreCorto>IVA</dte:NombreCorto>
						                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
						                <dte:MontoGravable>'.number_format($MontoGravableD, 3, '.', '').'</dte:MontoGravable>
						                <dte:MontoImpuesto>'.number_format($MontoImpuestoD, 3, '.', '').'</dte:MontoImpuesto>
						              </dte:Impuesto>
						            </dte:Impuestos>
						            <dte:Total>'.number_format($TotalD, 2, '.', '').'</dte:Total>
						           </dte:Item>';

								$TotalMontoImpuesto = $TotalMontoImpuesto + $IVAProductoD;
								$GranTotal = $GranTotal + $TotalD;					
							
						
					}

					$XMLEnviar .= '
						        </dte:Items>
						        <dte:Totales>
						          <dte:TotalImpuestos>
						            <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 3, '.', '').'"></dte:TotalImpuesto>
						          </dte:TotalImpuestos>
						          <dte:GranTotal>'.number_format($GranTotal, 3, '.', '').'</dte:GranTotal>
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
						## Kardex
					$SerieAutorizada             = $_POST["SerieAutorizada"];
					$FacturaNumero            = $_POST["FacturaNumero"];
					for($i=1; $i<$Contador; $i++)
				{
					$ProN = $ProductoNombre[$i]; 
					$PuntoV=$PuntoDeVenta[$i-1];
					$Can = $Cantidad[$i];
					$Pro = $Producto[$i];
					$Pre = $Precio[$i];
					$Sub = ($Pre*$Can); 
					$Des = $Descuento[$i];  
					$SubFac = ($Pre*$Can) - $Des;
					$Tip = $Tipo[$i];
					$ProductoXplotado = explode("/", $Pro);

					$Prod = $ProductoXplotado[0];

					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$Prod;
					$result = mysqli_query($db, $queryp);
					while($rowe = mysqli_fetch_array($result))
					{
						if($rowe["P_LLEVA_EXISTENCIA"]==1){

						
							if($PuntoV==1){

						$existenciaAn=$rowe["P_EXISTENCIA_TERRAZAS"];
						$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

						$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;

						$nuevaexistencia = $rowe["P_EXISTENCIA_TERRAZAS"] - $Can;

					

					$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
					P_EXISTENCIA_TERRAZAS = '".$nuevaexistencia."',
					P_EXISTENCIA_GENERAL = '".$cantidadgen."'
					WHERE P_CODIGO = ".$Prod);
							}elseif($PuntoV==2){

								$existenciaAn=$rowe["P_EXISTENCIA_SOUVENIRS"];
								$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];
		
								$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;
		
								$nuevaexistencia = $rowe["P_EXISTENCIA_SOUVENIRS"] - $Can;
		
							
		
							$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
							P_EXISTENCIA_SOUVENIRS = '".$nuevaexistencia."',
							P_EXISTENCIA_GENERAL = '".$cantidadgen."'
							WHERE P_CODIGO = ".$Prod);
									}elseif($PuntoV==3){

										$existenciaAn=$rowe["P_EXISTENCIA_HELADOS"];
										$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];
				
										$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;
				
										$nuevaexistencia = $rowe["P_EXISTENCIA_HELADOS"] - $Can;
				
									
				
									$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
									P_EXISTENCIA_HELADOS = '".$nuevaexistencia."',
									P_EXISTENCIA_GENERAL = '".$cantidadgen."'
									WHERE P_CODIGO = ".$Prod);
											}
											elseif($PuntoV==4){

												$existenciaAn=$rowe["P_EXISTENCIA_CAFE"];
												$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];
						
												$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;
						
												$nuevaexistencia = $rowe["P_EXISTENCIA_CAFE"] - $Can;
						
											
						
											$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
											P_EXISTENCIA_CAFE = '".$nuevaexistencia."',
											P_EXISTENCIA_GENERAL = '".$cantidadgen."'
											WHERE P_CODIGO = ".$Prod);
													}

					}else{
						#PARA REGISTRAR  TODOS LOS INGREDIENTES
						if($rowe["R_CODIGO"]!=NULL){
							$CodReceta=$rowe["R_CODIGO"];

							$queryr = "SELECT * FROM Productos.RECETA_DETALLE WHERE R_CODIGO ='$CodReceta'";
							$resultr = mysqli_query($db, $queryr);
							while($rower = mysqli_fetch_array($resultr))
							{
								$ProdR=$rower["P_CODIGO"];
								$CanR=$rower["RD_CANTIDAD"] * $Can;
								$querypR = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdR;
								$resultR = mysqli_query($db, $querypR);
								while($roweR = mysqli_fetch_array($resultR))
								{
									if($PuntoV==1){

									$existenciaAnR=$roweR["P_EXISTENCIA_TERRAZAS"];
									$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

									$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

									$nuevaexistenciaR = $roweR["P_EXISTENCIA_TERRAZAS"] - $CanR;

								

								$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
								P_EXISTENCIA_TERRAZAS = '".$nuevaexistenciaR."',
								P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
								WHERE P_CODIGO = ".$ProdR);

							}elseif($PuntoV==3){

								$existenciaAnR=$roweR["P_EXISTENCIA_HELADOS"];
								$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

								$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

								$nuevaexistenciaR = $roweR["P_EXISTENCIA_HELADOS"] - $CanR;

							

							$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
							P_EXISTENCIA_HELADOS = '".$nuevaexistenciaR."',
							P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
							WHERE P_CODIGO = ".$ProdR);

						}elseif($PuntoV==4){

							$existenciaAnR=$roweR["P_EXISTENCIA_CAFE"];
							$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

							$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

							$nuevaexistenciaR = $roweR["P_EXISTENCIA_CAFE"] - $CanR;

						

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_CAFE = '".$nuevaexistenciaR."',
						P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
						WHERE P_CODIGO = ".$ProdR);

					}
								}

								$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
								VALUES('".$KCod."', '".$Uid."', '".$ProdR."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Venta de Producto Segun Factura de Eventos Serie Número "."$SerieAutorizada"."  "."$FacturaNumero"."', '".$existenciaGAnR."', '".$cantidadgenR."', '".$PuntoV."', '".$existenciaAnR."', '".$nuevaexistenciaR."')");

								
							}

							$existenciaAn=1;
							$existenciaGAn=1;

							$cantidadgen = 1;

							$nuevaexistencia = 1;

						}else{
							$existenciaAn=0;
							$existenciaGAn=0;

							$cantidadgen = 0;

							$nuevaexistencia = 0;

						}
						
					}



					$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
					VALUES('".$KCod."', '".$Uid."', '".$Prod."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Venta de Producto Segun Factura de Eventos Serie Número "."$SerieAutorizada"."  "."$FacturaNumero"."', '".$existenciaGAn."', '".$cantidadgen."', '".$PuntoV."', '".$existenciaAn."', '".$nuevaexistencia."')");

					}
				}
							#PARA SACAR LAS BOLAS DE HELADO
							$QuerySelSabores = "SELECT * FROM Bodega.TEMPORAL_SABORES WHERE TS_CODIGO_USUARIO=".$id_user;
							$ResultSelSabores = mysqli_query($db, $QuerySelSabores);
							$RegistrosSelSabores = mysqli_num_rows($ResultSelSabores);
							if($RegistrosSelSabores > 0)
							{
								while($FilaSelSabores = mysqli_fetch_array($ResultSelSabores))
								{
									$CodProdSabor = $FilaSelSabores["TS_CODIGO_PRODUCTO"];
									$CanR=3;

									$querypR = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$CodProdSabor;
								$resultR = mysqli_query($db, $querypR);
								while($roweR = mysqli_fetch_array($resultR))
								{


									$existenciaAnR=$roweR["P_EXISTENCIA_HELADOS"];
									$existenciaGAnR=$roweR["P_EXISTENCIA_GENERAL"];

									$cantidadgenR = $roweR["P_EXISTENCIA_GENERAL"] - $CanR;

									$nuevaexistenciaR = $roweR["P_EXISTENCIA_HELADOS"] - $CanR;

								

								$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
								P_EXISTENCIA_HELADOS = '".$nuevaexistenciaR."',
								P_EXISTENCIA_GENERAL = '".$cantidadgenR."'
								WHERE P_CODIGO = ".$CodProdSabor);

									
								}

								$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
								VALUES('".$KCod."', '".$Uid."', '".$CodProdSabor."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Venta de Producto Segun Factura de Eventos Serie Número "."$SerieAutorizada"."  "."$FacturaNumero"."', '".$existenciaGAnR."', '".$cantidadgenR."', 3, '".$existenciaAnR."', '".$nuevaexistenciaR."')");

									
								}

								
							}

######################## FIN KARDEX ####################

$QueryEvento= mysqli_query($db, "UPDATE Eventos.EVENTO SET
								F_CODIGO = '".$Uid."'
								WHERE EV_CODIGO = '$EventoPertenece'");


						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
							<h2 class="text-light">La factura se ingresó correctamente.</h2>
							<div class="row">
								<a href="VtaDescripcion.php">
									<button type="button" class="btn btn-success btn-lg">
										<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
									</button>
								</a>
							</div>';

			           echo "NÚMERO DE AUTORIZACIÓN:   "."<b>".$responseCerti->body->uuid."</b>"."</p>";
			           echo "SERIE:   "."<b>".$responseCerti->body->serie."</b>"."</p>";
					   echo "NÚMERO DE FACTURA"."<b>".$responseCerti->body->numero."</b>"."</p>";	

					   
					   $QueryUpdateFactura = mysqli_query($db, "UPDATE Bodega.FACTURA_EV SET F_SERIE = '".$responseCerti->body->serie."', F_CAE = '".$responseCerti->body->numero."', F_DTE = '".$responseCerti->body->uuid."', F_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionBodega = mysqli_query($db, "UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Vta. Eventos Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."' WHERE F_CODIGO = '".$Uid."'");

					   $QueryUpdateTransaccionContabilidad = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Vta. Eventos Según Fact. ".$responseCerti->body->serie.' - '.$responseCerti->body->numero.' - '.$responseCerti->body->uuid."', TRA_FECHA_CERTIFICACION = '".$responseCerti->body->fecha."' WHERE TRA_CODIGO = '".$Uid."'");
						

					   #ACTUALIZAR ESTADO DE LOS ANTICIPOS
						for($i=0; $i<$ContadorANTICIPO; $i++)
						{
							$CodA = $CodigoA[$i];
							$MonA = $MontoMA[$i];
							
							$QueryUpdateFactura = mysqli_query($db, "UPDATE Contabilidad.ANTICIPO_EVENTOS SET AE_ESTADO = 1, F_CODIGO = '".$Uid."', AE_FECHA_USO = CURRENT_DATE() WHERE AE_CODIGO = '".$CodA."'");

							
						}
					}
					else
					{
				      	echo '<br><ul>';

				      	foreach ($responseCerti->body->descripcion_errores as $errores) 
				      	{
					        echo '<li>'.$errores->mensaje_error.'</li>';
				      	}
				      
				      	echo '<br></ul>';
					}
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
