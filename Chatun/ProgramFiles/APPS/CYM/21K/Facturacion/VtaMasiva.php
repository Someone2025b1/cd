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

        
				$Facturas = "SELECT * FROM Bodega.21K_INSCRIPCIONES WHERE FACTURADO = 0 LIMIT 500";
				$Facturas2 = mysqli_query($db, $Facturas) or die(mysqli_error());
				while($FacturasRes = mysqli_fetch_array($Facturas2))
				{
					$CorrelativoFac = $FacturasRes["CORRELATIVO"];
					$Nom=$FacturasRes["NOMBRE"];
					$Tipo=$FacturasRes["TIPO"];
					$NIT =$FacturasRes["NIT"];
					$GranTotal=0;
					$TotalMontoImpuesto=0;
				

                
			$TotalTaquillaSinIVA = 0;
            $Cantidad = 1;

			$UI        = uniqid("tra_");
			$UID       = uniqid("trad_");
			$Uid       = uniqid("F_");
			$UidD      = uniqid("FD_");
			$CCod      = uniqid("CC_");
			$Centinela = true;
			$Contador  = 1;
			$ContadorD  = 1;
			$TotalDescuentoFactura = 0;

			$FechaHoraHoy = date('2024-11-30', strtotime('now')).'T'.date('H:i:s', strtotime('now'));
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

			$TipoPago                 = 3;
			$Fecha                    = $_POST["Fecha"];
			$ClienteRegistrado        = $_POST["ClienteRegistrado"];			
			
			$TipoMoneda               = $_POST["MonedaPagoInput"];
			$Observaciones 			  = "Ciudad";
			$TipoFactura          = $_POST["TipoFactura"];
			$Des=$FacturasRes["DESCRIPCION"];

			

			if($Des=="21K"){

				$PrecioDes         = 175;
			$SubTotalDes       = 175;
			$TotalFacturaConDescuento = 175;
			$TotalFacturaFinal        = 175;
			$DescripcionFac       = "Inscripción 21K 2024";
			}else{

			$PrecioDes         = 150;
			$SubTotalDes       = 150;
			$TotalFacturaConDescuento = 150;
			$TotalFacturaFinal        = 150;
			$DescripcionFac       = "Inscripción 10K 2024";


			}
			
				
			echo '<input type="hidden" id="CodigoFactura" value="'.$Uid.'" />';

			
			$PuntoDeVenta ="21K";

			if($Tipo=="DPI"){

				$TipoDoc       = "D";

			}else{

				$TipoDoc       = "N";
				$NIT = "CF";
			}
			
			

			$Nombre    = strtoupper($Nom);
			$Direccion = strtoupper($Observaciones);

			

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
			        <dte:Receptor CorreoReceptor="'.$CorreoReceptor.'" IDReceptor="'.$NIT.'" NombreReceptor="'.$Nombre.'" TipoEspecial="CUI">
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


			if($TipoPago == 3)
			{
				$NombreCredito = "21K";

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Bodega.FACTURA_21K (F_CODIGO, F_SERIE, F_TIPO, CLI_NIT, F_TOTAL, F_EFECTIVO, F_CAMBIO, F_FECHA_TRANS, F_HORA, F_USUARIO, F_NOMBRE_CREDITO, F_OBSERVACIONES, RES_NUMERO, F_DESCRIPCIONES)
												VALUES ('".$Uid."', '".$SerieAutorizada."', 3, '".$NIT."', ".$TotalFacturaFinal.", 0.00, 0.00, '2024-11-30', CURRENT_TIMESTAMP(),  ".$id_user.",  '".$NombreCredito."', '".$Observaciones."', '".$NumeroResolucion."', 1)") or die(mysqli_error());

				$sqlAbono = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, B_CODIGO, F_CODIGO)
											 VALUES('".$UI."', '2024-11-30', 'Factura 21K Según ".$SerieAutorizada." ".$FacturaNumero."',  '2024-11-30', CURRENT_TIMESTAMP(), ".$id_user .", 1, 15, 1, '".$Uid."')") or die(mysqli_error());

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
										 VALUES('".$Uid."', '2024-11-30', 'Factura 21K Según ".$SerieAutorizada." ".$FacturaNumero."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 32, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());

				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.014', ".number_format($TotalFacturaFinal, 2, ".", "").", 0.00)");

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '2.01.04.001', 0.00, ".number_format($IVADebito, 4, ".", "").")");
																								
				$SqlContableD2 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '4.01.08.001', 0.00, ".number_format($VentaSinIVA, 4, ".", "").")");
				


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
					

					
						$CanD = 1;
						$ProD = $DescripcionFac;
						$PreD = $PrecioDes;
						$SubD = $SubTotalDes;
						

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
						          <dte:Item BienOServicio="S" NumeroLinea="1">
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
						
					$QueryPU = mysqli_query($db, "UPDATE Bodega.21K_INSCRIPCIONES SET
					FACTURADO = 1
					WHERE CORRELATIVO = ".$CorrelativoFac);
						

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
