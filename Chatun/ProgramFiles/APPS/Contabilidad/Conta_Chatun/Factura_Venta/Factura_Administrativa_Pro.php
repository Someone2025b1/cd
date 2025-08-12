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
					<br>
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Ingreso de Factura Administrativa</strong></h4>
						</div>
						<div class="card-body">
							<?php
							date_default_timezone_set('America/Guatemala');
			
								$FechaFactura    = $_POST['Fecha'];
								$FechaHoraHoy = $FechaFactura.'T'.date('H:i:s', strtotime('now'));
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
								$Email      = $_POST["Email"]; 
								if ($Email!="") {
									$EmailE = $Email;
								}
								else
								{
									$EmailE = "facturacionchatun@gmail.com";
								}
								$CorreoReceptor =  $EmailE;

								$CodigoPostalReceptor = '01001';
								$MunicipioReceptor = 'GUATEMALA';
								$DepartamentoReceptor = 'GUATEMALA';
								$PaisReceptor = 'GT';
 
								$Periodo         = $_POST['Periodo'];
								$Comprobante     = $_POST['Comprobante'];
								$Concepto        = $_POST['Concepto'];
								$NombreCompleto  = $_POST['Nombre'];
								$CantidadFactura = $_POST['CantidadFactura'];
								$TipoCalculo     = $_POST['TipoCalculo'];
								$TotalFactura    = $_POST['TotalFE'];
								$Base            = $_POST['Base'];
								 
								$NIT             = $_POST['NIT'];
								$DPI             = $_POST['DPI'];
								$Domicilio       = 'Ciudad';
								$Descripcion     = $_POST['Descripcion'];
								$CodigoProveedor = $_POST['CodigoProveedor'];

  
								$Cuenta       = $_POST["Cuenta"];
								$Cargos       = $_POST["Cargos"];
								$Abonos       = $_POST["Abonos"];
								$Razon        = $_POST["Razon"];

								$TipoProducto     = $_POST["TipoProducto"];
								$CantidadFE       = $_POST["CantidadFE"];
								$DescripcionFE    = $_POST["DescripcionFE"];
								$PrecioUnitarioFE = $_POST["PrecioUnitarioFE"];
								$SubTotalFE       = $_POST["SubTotalFE"];
								$ContadorFE		  = count($CantidadFE);

								$UI             = uniqid('tra_');
								$UID            = uniqid('trad_');
								$Contador       = count($_POST["Cuenta"]);
								$Centinela      = true;

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
								        <dte:Receptor CorreoReceptor="'.$CorreoReceptor.'" IDReceptor="'.$NIT.'" NombreReceptor="'.$NombreCompleto.'">
								          <dte:DireccionReceptor>
								            <dte:Direccion>'.$Domicilio.'</dte:Direccion>
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

								for($i=1; $i<$ContadorFE; $i++)
                    			{
									if($i != 0)
									{	
										$Tip = $TipoProducto[$i-1];
										$Can = $CantidadFE[$i];
										$Des = $DescripcionFE[$i];
										$Pre = $PrecioUnitarioFE[$i];
										$Sub = $SubTotalFE[$i];
										$UIDFE = uniqid('DFE_');

										$IVAProducto = (($Sub / 1.12) * 0.12);
										$SubNeto = $Sub - $IVAProducto;

										$query = mysqli_query($db, "INSERT INTO Contabilidad.DETALLE_FACTURA_ADMINISTRATIVA (DFA_CODIGO, TRA_CODIGO, DFA_CANTIDAD, DFA_DESCRIPCION, DFA_PRECIO, DFA_SUBTOTAL, DFA_TIPO, DFA_NIT)
															VALUES('".$UIDFE."', '".$UI."', ".$Can.", '".$Des."', ".$Pre.", ".$Sub.", '".$Tip."', '".$NIT."')");


										$MontoImpuesto = ($Sub * .12) / 1.12;
								    	$MontoGravable = $Sub - $MontoImpuesto;
								    	$Total = $MontoGravable + $MontoImpuesto;

										$XMLEnviar .= '
								          <dte:Item BienOServicio="'.$Tip.'" NumeroLinea="'.$i.'">
								            <dte:Cantidad>'.$Can.'</dte:Cantidad>
								            <dte:UnidadMedida>UND</dte:UnidadMedida>
								            <dte:Descripcion>'.$Des.'</dte:Descripcion>
								            <dte:PrecioUnitario>'.number_format($Pre, 2, ".", "").'</dte:PrecioUnitario>
								            <dte:Precio>'.number_format($Sub, 2, ".", "").'</dte:Precio>
								            <dte:Descuento>0.00</dte:Descuento>
								            <dte:Impuestos>
								              <dte:Impuesto>
								                <dte:NombreCorto>IVA</dte:NombreCorto>
								                <dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>
								                <dte:MontoGravable>'.number_format($MontoGravable, 2, ".", "").'</dte:MontoGravable>
								                <dte:MontoImpuesto>'.number_format($MontoImpuesto, 2, ".", "").'</dte:MontoImpuesto>
								              </dte:Impuesto>
								            </dte:Impuestos>
								            <dte:Total>'.number_format($Total, 2, ".", "").'</dte:Total>
								           </dte:Item>';

										$TotalMontoImpuesto = $TotalMontoImpuesto + number_format($IVAProducto, 2, ".", "");
										$GranTotal = $GranTotal + $Sub;	

										if(!$query)
										{
											echo '<div class="col-lg-12 text-center">
													<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
													<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de venta.</h2>
													<h4 class="text-light">Código de transacción: '.$UIDFE.'</h4>
												</div>';
											echo mysqli_error($query);
											$Centinela = false;
											
										}
									}	
								}

								$XMLEnviar .= '
								        </dte:Items>
									        <dte:Totales>
									          <dte:TotalImpuestos>
									            <dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 2, ".", "").'"></dte:TotalImpuesto>
									          </dte:TotalImpuestos>
									          <dte:GranTotal>'.$GranTotal.'</dte:GranTotal>
									        </dte:Totales> 
									      </dte:DatosEmision>
									    </dte:DTE>
									  </dte:SAT>
									</dte:GTDocumento>';
 
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
										$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE PC_CODIGO = ".$Periodo;
										$resultCorrelativo = mysqli_query($db, $queryCorrelativo);
										while($rowCor = mysqli_fetch_array($resultCorrelativo))
										{	
											if($rowCor["CORRELATIVO"] == 0)
											{
												$Correlativo = 1;
											}
											else
											{
												$Correlativo = $rowCor["CORRELATIVO"] + 1;
											}
										}

										$sql = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_SERIE, TRA_FACTURA, TRA_CONCEPTO, TRA_TOTAL, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_CORRELATIVO, TRA_SALDO, TRA_TIPO_FACTURA_VENTA, PC_CODIGO, TRA_DTE, TRA_CAE, TRA_FECHA_CERTIFICACION, TRA_CONTABILIZO)
														VALUES('".$UI."', '".$FechaFactura."', '".$responseCerti->body->serie."', '".$responseCerti->body->numero."', '".$Descripcion."', ".$TotalFactura.", CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$id_user."', 2, 25, ".$Correlativo.", ".$TotalFactura.", 'FACA', ".$Periodo.", '".$responseCerti->body->uuid."', '".$responseCerti->body->numero."', '".$responseCerti->body->fecha."', $id_user)");

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

										if($Centinela == true)
										{
											echo '<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
												<h2 class="text-light">La factura administrativa se ingresó correctamente.</h2><br>
												<a target="_blank" href="../Mantenimiento/ImpPartida2.php?Codigo='.$UI.'"><button type="button" class="btn btn-sm btn-warning">
												    	<span class="glyphicon glyphicon-print"></span> Imprimir Poliza
													</button></a>
											    <a target="_blank" href="FactImpAd.php?Codigo='.$UI.'"><button type="button" class="btn btn-sm btn-success">
												    	<span class="glyphicon glyphicon-print"></span> Imprimir Factura
													</button></a>
												<a href="Factura_Administrativa.php"><button type="button" class="btn btn-sm btn-danger">
											    	<span class="glyphicon glyphicon-print"></span> Regresar
												</button></a>
												';
										}	

										
							           //echo "NUMERO DE DTE:   "."<b>".$response->body->numeroDte."</b>"."</p>";
									   //echo "CAE:   "."<b>".$response->body->cae."</b>"."</p>";	
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

		<!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Resultados de su búsqueda</h2>
                    </div>
                    <div class="modal-body">
                    	<div id="suggestions" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
