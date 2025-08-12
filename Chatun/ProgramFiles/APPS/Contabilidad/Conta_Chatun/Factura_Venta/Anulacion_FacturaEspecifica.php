<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/httpful.phar");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$FechaHoraHoy = date('Y-m-d', strtotime('now')).'T'.date('H:i:s', strtotime('now'));

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



								$NIT                  = $_POST["NIT"];
								$Observaciones        = $_POST["Observaciones"];
								$NumeroAutorizacion   = $_POST["NumeroAutorizacion"];

								
								$FechaCertificacionCompleta = $_POST["FechaCertificacionCompleta"];

								$xml = '
	                              <dte:GTAnulacionDocumento xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:dte="http://www.sat.gob.gt/dte/fel/0.1.0" xmlns:n1="http://www.altova.com/samplexml/other-namespace" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="0.1">
									<dte:SAT>
										<dte:AnulacionDTE ID="DatosCertificados">
										<dte:DatosGenerales FechaEmisionDocumentoAnular="'.$FechaCertificacionCompleta.'" FechaHoraAnulacion="'.$FechaHoraHoy.'" ID="DatosAnulacion" IDReceptor="'.$NIT.'" MotivoAnulacion="'.$Observaciones.'" NITEmisor="92066097" NumeroDocumentoAAnular="'.$NumeroAutorizacion.'"></dte:DatosGenerales>
										</dte:AnulacionDTE>
									</dte:SAT>
								</dte:GTAnulacionDocumento>';

								

							$url_servicio_firma = "https://signer-emisores.feel.com.gt/sign_solicitud_firmas/firma_xml";
                                      
                              $encoded_xml =  base64_encode($xml);

                              $contenido_xml = array(
                                'llave' => 'ca7d21d86285fb239d5cf10bd5d303fe',
                                  'archivo' => $encoded_xml,
                                  'codigo' => "n/a",
                                  'alias' => 'ASOCRE',
                                  'es_anulacion' => 'S'
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

                                  $uri = "https://certificador.feel.com.gt/fel/anulacion/v2/dte";
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


									   ?>
									   	<div class="row text-center">
											<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
												<h2 class="text-light">La anulación se ingresó con Éxito.</h2>
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
							       
								}else{
									?>
	
									<h2 class="text-light">No Se anulo</h2>
									<?php
								}
	
								
							}else{
								?>

								<h2 class="text-light">NO se encontro.</h2>
								<?php
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
