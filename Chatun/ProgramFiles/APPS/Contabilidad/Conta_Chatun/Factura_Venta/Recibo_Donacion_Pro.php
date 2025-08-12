<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
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
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Ingreso de Recibo de Donación</strong></h4>
						</div>
						<div class="card-body">
							<?php

								$FechaHoraHoy = date('Y-m-d', strtotime($_POST["Fecha"])).'T'.date('H:i:s', strtotime('now'));
								$CodigoEstablecimiento = 1;
								$CorreoEmisor = 'info@parquechatun.com';
								$NITEmisor = '9300000176K';
								$NombreComercial = 'PARQUE CHATUN';
								$NombreEmisor = 'ASOCIACIÓN PARA EL CRECIMIENTO EDUCATIVO REG. COOPERATIVO Y APOYO TURÍSTICO DE ESQUIPULAS';
								$DireccionEmisor = 'KILOMETRO 226.5 CARRETERA DE ASFALTADA HACIA FRONTERA DE HONDURAS';
								$CodigoPostalEmisor = '20007';
								$MunicipioEmisor = 'Esquiuplas';
								$DepartamentoEmisor = 'Chiquimula';
								$PaisEmisor = 'GT';
								$CorreoReceptor = 'kelly.intecap@gmail.com';
								$CodigoPostalReceptor = $_POST["CodigoPostal"];
								$MunicipioReceptor = $_POST["Municipio"];
								$DepartamentoReceptor = $_POST["Departamento"];
								$DireccionReceptor = $_POST["Direccion"];
								$PaisReceptor = 'GT';
								$Nombre = $_POST["Nombre"];
								$NIT = $_POST["NIT"];


								$Cantidad     = $_POST["Cantidad"];
								$Descripcion       = $_POST["Descripcion"];
								$PrecioUnitario   = $_POST["PrecioUnitario"];
								$Total           = $_POST["Total"];
								$Tipo        = $_POST["Tipo"];
								$ContadorRecibo = count($_POST["Tipo"]);



								$UI             = uniqid('tra_');
								$UID            = uniqid('trad_');
								$Contador       = count($_POST["Cuenta"]);
								$Centinela      = true;
									
								$Fecha          = $_POST["Fecha"];
								$Comprobante    = $_POST["Comprobante"];
								$SerieFactura   = $_POST["SerieFactura"];
								$FacturaDel     = $_POST["FacturaDel"];
								$FacturaAl      = $_POST["FacturaAl"];
								$TipoCompra     = $_POST["TipoCompra"];
								$Descripcion       = $_POST["Descripcion"];
								$TotalFactura   = $_POST["TotalFactura"];
								$Periodo        = $_POST["Periodo"];

								$query = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE PC_CODIGO = ".$Periodo;
								$result = mysqli_query($db, $query);
								while($row = mysqli_fetch_array($result))
								{	
									if($row["CORRELATIVO"] == 0)
									{
										$Correlativo = 1;
									}
									else
									{
										$Correlativo = $row["CORRELATIVO"] + 1;
									}
								}

								$XMLEnviar = '
								<dte:GTDocumento xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:dte="http://www.sat.gob.gt/dte/fel/0.2.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="0.1" xsi:schemaLocation="http://www.sat.gob.gt/dte/fel/0.1.0">
								  <dte:SAT ClaseDocumento="dte">
								    <dte:DTE ID="DatosCertificados">
								      <dte:DatosEmision ID="DatosEmision">
								        <dte:DatosGenerales CodigoMoneda="GTQ" FechaHoraEmision="'.$FechaHoraHoy.'" Tipo="RDON" TipoPersoneria="2"></dte:DatosGenerales>
								        <dte:Emisor AfiliacionIVA="GEN" CodigoEstablecimiento="'.$CodigoEstablecimiento.'" NITEmisor="'.$NITEmisor.'" NombreComercial="'.$NombreComercial.'" NombreEmisor="'.$NombreEmisor.'">
								          <dte:DireccionEmisor>
								            <dte:Direccion>'.$DireccionEmisor.'</dte:Direccion>
								            <dte:CodigoPostal>'.$CodigoPostalEmisor.'</dte:CodigoPostal>
								            <dte:Municipio>'.$MunicipioEmisor.'</dte:Municipio>
								            <dte:Departamento>'.$DepartamentoEmisor.'</dte:Departamento>
								            <dte:Pais>'.$PaisEmisor.'</dte:Pais>
								          </dte:DireccionEmisor>
								        </dte:Emisor>
								        <dte:Receptor IDReceptor="'.$NIT.'" NombreReceptor="'.$Nombre.'">
								          <dte:DireccionReceptor>
								            <dte:Direccion>'.$DireccionReceptor.'</dte:Direccion>
								            <dte:CodigoPostal>'.$CodigoPostalReceptor.'</dte:CodigoPostal>
								            <dte:Municipio>'.$MunicipioReceptor.'</dte:Municipio>
								            <dte:Departamento>'.$DepartamentoReceptor.'</dte:Departamento>
								            <dte:Pais>'.$PaisReceptor.'</dte:Pais>
								          </dte:DireccionReceptor>
								        </dte:Receptor>
											<dte:Frases><dte:Frase CodigoEscenario="4" TipoFrase="4"></dte:Frase></dte:Frases>
											<dte:Items>';



								for($i=1; $i<$ContadorRecibo; $i++)
                        		{
									$XMLEnviar .= '       
												<dte:Item BienOServicio="'.$Tipo[$i].'" NumeroLinea="'.$i.'">
								            		<dte:Cantidad>'.$Cantidad[$i].'</dte:Cantidad>
													<dte:UnidadMedida>UND</dte:UnidadMedida>
								            		<dte:Descripcion>'.$Descripcion[$i].'</dte:Descripcion>
								            		<dte:PrecioUnitario>'.$PrecioUnitario[$i].'</dte:PrecioUnitario>
								            		<dte:Precio>'.$Total[$i].'</dte:Precio>
													<dte:Descuento>0</dte:Descuento>
								            		<dte:Total>'.$Total[$i].'</dte:Total>
								          		</dte:Item>
											';
								}

								$XMLEnviar .= '
											</dte:Items>        
											<dte:Totales>
												<dte:GranTotal>'.$_POST["GranTotal"].'</dte:GranTotal>
								        	</dte:Totales>
								       </dte:DatosEmision>
								      </dte:DTE>
								   </dte:SAT>
								</dte:GTDocumento>';

								$url_servicio_firma = "https://signer-emisores.feel.com.gt/sign_solicitud_firmas/firma_xml";
        
								$encoded_xml =  base64_encode($XMLEnviar);

								$contenido_xml = array(
									'llave' => '80c18e117f60a144f7edfb4da42e3930',
								    'archivo' => $encoded_xml,
								    'codigo' => "n/a",
								    'alias' => 'ASOCRE_DEMO',
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
									   'usuario' => 'ASOCRE_DEMO',             
								  	   'llave' => '8C62764BB8379ECDE61895E8B5E5CD81'           
										))            
									->send();  

									if($responseCerti->body->cantidad_errores == 0)
									{
										$sql = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_TOTAL, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_CORRELATIVO, TRA_CIF_COLABORADOR, TRA_SALDO, PC_CODIGO)
														VALUES('".$UI."', '".$Fecha."', '".$Concepto."', ".$_POST["GranTotal"].", CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$UserID ."', 2, ".$TipoTransaccion.", ".$Correlativo.", ".$id_user.", ".$_POST["GranTotal"].", ".$Periodo.")");

										for($i=1; $i<$Contador; $i++)
		                    			{
											$Cue = $Cuenta[$i];
											$Car = $Cargos[$i];
											$Abo = $Abonos[$i];
											$Raz = $Razon[$i];

											$Xplotado = explode("/", $Cue);
											$NCue = $Xplotado[0];

											$query = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA, TRAD_RAZON)
																VALUES('".$UID."', '".$UI."', '".$NCue."', ".$Car.", ".$Abo.", '".$Raz."')");

											if(!$query)
											{
												echo '<div class="col-lg-12 text-center">
														<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
														<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de venta.</h2>
														<h4 class="text-light">Código de transacción: '.$UID.'</h4>
													</div>';
												echo mysqli_error($query);
												$Centinela = false;
												
											}	
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
							?>
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
