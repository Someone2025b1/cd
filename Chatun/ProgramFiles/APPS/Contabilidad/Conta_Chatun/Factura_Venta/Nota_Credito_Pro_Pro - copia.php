<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/httpful.phar");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$FechaHoraHoy = date('Y-m-d', strtotime('now')).'T'.date('H:i:s', strtotime('now'));
$CodigoEstablecimiento = 1;
$CorreoEmisor = 'info@parquechatun.com';
$NITEmisor = '92066097';
$NombreComercial = 'PARQUE CHATUN';
$NombreEmisor = 'ASOCIACIÓN PARA EL CRECIMIENTO EDUCATIVO REG. COOPERATIVO Y APOYO TURÍSTICO DE ESQUIPULAS';
$DireccionEmisor = 'KILOMETRO 226.5 CARRETERA DE ASFALTADA HACIA FRONTERA DE HONDURAS';
$CodigoPostalEmisor = '20007';
$MunicipioEmisor = 'Esquiuplas';
$DepartamentoEmisor = 'Chiquimula';
$PaisEmisor = 'GT';
$CorreoReceptor = 'kelly.intecap@gmail.com';

$CodigoPostalReceptor = '01001';
$MunicipioReceptor = 'GUATEMALA';
$DepartamentoReceptor = 'GUATEMALA';
$PaisReceptor = 'GT';
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

								



								$FechaDocumento       = $_POST['FechaDocumento'];
								$NIT                  = $_POST['NIT'];
								$Nombre               = $_POST['Nombre'];
								$ImporteBruto         = $_POST['ImporteBruto'];
								$Impuesto             = $_POST['Impuesto'];
								$TotalTransaccion     = $_POST['TotalTransaccion'];
								$CodigoFactura        = $_POST['CodigoFactura'];
								$Observaciones        = $_POST['Observaciones'];
								$Tabla                = $_POST['Tabla'];
								$Direccion 			  = $_POST['Direccion'];
								$FechaCertificacion   = $_POST['FechaCertificacion'];
								$NumeroAutorizacion   = $_POST['NumeroAutorizacion'];

								
								$CodigoCuenta         = $_POST['CodigoCuenta'];
								$Nombrecuenta         = $_POST['Nombrecuenta'];
								$Cargo                = $_POST['Cargo'];
								$Abono                = $_POST['Abono'];
								$ContadorContabilidad = count($CodigoCuenta);
								
								$CodigoProducto       = $_POST['CodigoProducto'];
								$NombreProducto       = $_POST['NombreProducto'];
								$Cantidad             = $_POST['Cantidad'];
								$PrecioUnitario       = $_POST['PrecioUnitario'];
								$MontoBruto           = $_POST['MontoBruto'];
								$IVA                  = $_POST['IVA'];
								$Descuento            = $_POST['Descuento'];
								$Total                = $_POST['Total'];
								$ContadorProducto     = count($_POST['CodigoProducto']);

								$xml = '
	                              <dte:GTDocumento xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:dte="http://www.sat.gob.gt/dte/fel/0.2.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="0.1" xsi:schemaLocation="http://www.sat.gob.gt/dte/fel/0.2.0">
	                                <dte:SAT ClaseDocumento="dte">
	                                  <dte:DTE ID="DatosCertificados">
	                                    <dte:DatosEmision ID="DatosEmision">
	                                      <dte:DatosGenerales CodigoMoneda="GTQ" FechaHoraEmision="'.$FechaHoraHoy.'" NumeroAcceso="100000000" Tipo="NCRE"></dte:DatosGenerales>
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
	                                      <dte:Items>';

								$ContadorLinea = 1;

								for ($i=0; $i < $ContadorProducto; $i++) 
								{ 

									$MontoImpuesto = ($Total[$i] * .12) / 1.12;
                                    $MontoGravable = $Total[$i] - $MontoImpuesto;
                                    $TotalSubtotal = $MontoGravable + $MontoImpuesto;

                                    $xml .= 
                                      '<dte:Item BienOServicio="B" NumeroLinea="'.$ContadorLinea.'">
                                        <dte:Cantidad>'.$Cantidad[$i].'</dte:Cantidad>
                                        <dte:UnidadMedida>UND</dte:UnidadMedida>
                                        <dte:Descripcion>'.$NombreProducto[$i].'</dte:Descripcion>
                                        <dte:PrecioUnitario>'.$PrecioUnitario[$i].'</dte:PrecioUnitario>
                                        <dte:Precio>'.$Total[$i].'</dte:Precio>
                                        <dte:Descuento>0.00</dte:Descuento>
                                        <dte:Impuestos>
                                          <dte:Impuesto>
                                            <dte:NombreCorto>IVA</dte:NombreCorto>
                                            <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
                                            <dte:MontoGravable>'.number_format($MontoGravable, 2, '.', '').'</dte:MontoGravable>
                                            <dte:MontoImpuesto>'.number_format($MontoImpuesto, 2, '.', '').'</dte:MontoImpuesto>
                                          </dte:Impuesto>
                                        </dte:Impuestos>
                                        <dte:Total>'.number_format($TotalSubtotal, 2, '.', '').'</dte:Total>
                                      </dte:Item>';
                                      $ContadorLinea++;
                                      $TotalMontoImpuesto = $TotalMontoImpuesto + number_format($MontoImpuesto, 2, '.', '');
                                      $GranTotal = $GranTotal + $Total[$i];

								}

								$xml .=
	                                      '</dte:Items>
	                                      <dte:Totales>
	                                        <dte:TotalImpuestos>
	                                          <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 2, '.', '').'"></dte:TotalImpuesto>
	                                        </dte:TotalImpuestos>
	                                        <dte:GranTotal>'.$GranTotal.'</dte:GranTotal>
	                                      </dte:Totales>
	                                      <dte:Complementos>
	                                        <dte:Complemento IDComplemento="Notas" NombreComplemento="Notas" URIComplemento="http://www.sat.gob.gt/fel/notas.xsd">
	                                          <cno:ReferenciasNota xmlns:cno="http://www.sat.gob.gt/face2/ComplementoReferenciaNota/0.1.0" FechaEmisionDocumentoOrigen="'.$FechaCertificacion.'" MotivoAjuste="Anulacion de factura" NumeroAutorizacionDocumentoOrigen="'.$NumeroAutorizacion.'" Version="0.0"></cno:ReferenciasNota>
	                                        </dte:Complemento>
	                                      </dte:Complementos>
	                                    </dte:DatosEmision>
	                                  </dte:DTE>
	                                </dte:SAT>
	                              </dte:GTDocumento>';


								

							$url_servicio_firma = "https://signer-emisores.feel.com.gt/sign_solicitud_firmas/firma_xml";
                                      
                              $encoded_xml =  base64_encode($xml);

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

                              if ($response->code == 200)
                              {
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

                                  	$SerieNotaCredito = $responseCerti->body->serie;
                                    $AutorizacionNotaCredito = $responseCerti->body->uuid;
                                    $NumeroNotaCredito = $responseCerti->body->numero;
                                    $FechaCertificacion = $responseCerti->body->fecha;


									   $Mes = date('m', strtotime('now'));
									   $Anho = date('Y', strtotime('now'));

									   $QuerySaberPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = ".$Mes." AND PC_ANHO = ".$Anho;
										$ResultSaberPeriodo = mysqli_query($db, $QuerySaberPeriodo);
										while($FilaSaberPeriodo = mysqli_fetch_array($ResultSaberPeriodo))
										{
											$Periodo = $FilaSaberPeriodo["PC_CODIGO"];
										}

										$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE MONTH( TRA_FECHA_TRANS ) = ".$Mes." AND YEAR( TRA_FECHA_TRANS ) = ".$Anho." AND PC_CODIGO = ".$Periodo;
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

										$Uid = uniqid('tra_');

										if($Tabla == 'FACTURA')
										{
											$Bodega = 1;
										}
										elseif($Tabla == 'FACTURA_KS')
										{
											$Bodega = 1;
										}
										elseif($Tabla == 'FACTURA_KS_2')
										{
											$Bodega = 1;
										}
										elseif($Tabla == 'FACTURA_SV')
										{
											$Bodega = 2;
										}
										elseif($Tabla == 'FACTURA_HS')
										{
											$Bodega = 3;
										}
										elseif($Tabla == 'FACTURA_TQ')
										{
											$Bodega = 5;
										}
										elseif($Tabla == 'FACTURA_EV')
										{
											$Bodega = 1;
										}

										if(isset($_POST["RebajaInventario"]))
										{
											$SqlBodega = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION(TRA_CODIGO, TRA_FECHA_TRANS, B_CODIGO, E_CODIGO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, TT_CODIGO, TRA_OBSERVACIONES, F_CODIGO)VALUES('".$Uid."', CURRENT_DATE(), ".$Bodega.", 1, CURRENT_DATE, CURRENT_TIME(), ".$id_user.", 12, 'Nota de Crédito por anulación de factura', '".$CodigoFactura."')");

											$SqlBodegaDetalle = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_CARGO_PRODUCTO)
																			SELECT '".$Uid."', '".$Uid."', A.P_CODIGO, A.TRAD_ABONO_PRODUCTO
																			FROM Bodega.TRANSACCION_DETALLE AS A
																			WHERE A.TRA_CODIGO = '".$CodigoFactura."'");
										}
										

									   $SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_TOTAL, TRA_CORRELATIVO, PC_CODIGO, TRA_DTE, TRA_CAE, TRA_FACTURA_NOTA_CREDITO, TRA_TABLA_FACTURA_NOTA_CREDITO)
											 VALUES('".$Uid."', CURRENT_DATE(), '".$Observaciones."',  CURRENT_DATE(), CURRENT_TIME(), ".$id_user .", 2, 17, ".$TotalTransaccion.", ".$Correlativo.", ".$Periodo.", '".$AutorizacionNotaCredito."', '".$SerieNotaCredito."-".$NumeroNotaCredito."', '".$CodigoFactura."', '".$Tabla."')") or die(mysqli_error());

									   for ($i=0; $i <$ContadorContabilidad ; $i++) 
									   { 
									   		$UidD      = uniqid("FD_");
									   		$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '".$CodigoCuenta[$i]."', ".$Cargo[$i].", ".$Abono[$i].")");
									   }

									   ?>
									   	<div class="row text-center">
											<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
												<h2 class="text-light">La Nota de Crédito se ingresó con Éxito.</h2>
												<div class="row">
													<div class="col-lg-6 text-center"><a href="Nota_Credito.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
											</div>
										</div>
									   <?php

									}else{
									   ?>
	                                      <ul>
	                                        <?php foreach ($responseCerti->body->descripcion_errores as $errores) { ?>
	                                            <li><?php echo $errores->mensaje_error ?></li>
	                                       <?php } ?>
	                                      </ul>
	                                    <?php		
									}
							       
								} else{ 
								  ?>
                                  <div class="alert alert-danger">
                                    <strong>Hubo un error con el proceso de firmar el documeto electrónico</strong>
                                  </div>
                                <?php
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
