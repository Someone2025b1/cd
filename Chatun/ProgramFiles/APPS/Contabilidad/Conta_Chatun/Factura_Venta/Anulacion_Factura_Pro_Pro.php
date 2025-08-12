<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/httpful.phar");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


//Para restringir
session_start(); // Siempre iniciar la sesión

// Definimos qué área tiene permiso para ver esta página
$areaPermitida = '55';

// Verificamos si el usuario ha iniciado sesión
if (!isset($_SESSION['id_departamento'])) {
    echo "Debe iniciar sesión primero.";
    exit(); // detenemos la ejecución
}

// Verificamos si el usuario pertenece al área permitida
if ($_SESSION['id_departamento'] !== $areaPermitida) {
    echo "No tiene permisos para ver esta página.";
    exit(); // detenemos la ejecución
}

//Fin Restrincción



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

								$KCod=uniqid('KR_');



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
								$FechaCertificacionCompleta = $_POST['FechaCertificacionCompleta'];

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
											$Punto = "Terrazas";
										}
										if($Tabla == 'FACTURA_2')
										{
											$Bodega = 1;
											$Punto = "Terrazas #2";
										}
										elseif($Tabla == 'FACTURA_KS')
										{
											$Bodega = 4;
										}
										elseif($Tabla == 'FACTURA_KS_2')
										{
											$Bodega = 1;
											$Punto = "Kiosco Azados";
										}
										elseif($Tabla == 'FACTURA_RS')
										{
											$Bodega = 1;
											$Punto = "Restaurante Mirador";
										}
										elseif($Tabla == 'FACTURA_KS_3')
										{
											$Bodega = 1;
											$Punto = "Kiosco Oasis";
										}
										elseif($Tabla == 'FACTURA_SV')
										{
											$Bodega = 2;
										}
										elseif($Tabla == 'FACTURA_SV_2')
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
										elseif($Tabla == 'FACTURA_TQ_2')
										{
											$Bodega = 5;
										}
										elseif($Tabla == 'FACTURA_TQ_3')
										{
											$Bodega = 5;
										}
										elseif($Tabla == 'FACTURA_TQ_4')
										{
											$Bodega = 5;
										}
										elseif($Tabla == 'FACTURA_EV')
										{
											$Bodega = 0.1;
										}
										elseif($Tabla == 'FACTURA_KS_4')
										{
											$Bodega = 0.2;
										}
										elseif($Tabla == 'FACTURA_HC')
										{
											$Bodega = 3;
										}
										elseif($Tabla == 'FACTURA_PIZZA')
										{
											$Bodega = 8;
										}

										if(isset($_POST["RebajaInventario"]))
										{
											$SqlBodega = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION(TRA_CODIGO, TRA_FECHA_TRANS, B_CODIGO, E_CODIGO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, TT_CODIGO, TRA_OBSERVACIONES, F_CODIGO)VALUES('".$Uid."', CURRENT_DATE(), ".$Bodega.", 1, CURRENT_DATE, CURRENT_TIME(), ".$id_user.", 12, 'Nota de Crédito por anulación de factura', '".$CodigoFactura."')");

											$SqlBodegaDetalle = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_CARGO_PRODUCTO)
																			SELECT '".$Uid."', '".$Uid."', A.P_CODIGO, A.TRAD_ABONO_PRODUCTO
																			FROM Bodega.TRANSACCION_DETALLE AS A
																			WHERE A.TRA_CODIGO = '".$CodigoFactura."'");
										}
										

									   $SqlContable = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION_DETALLE SET TRAD_CARGO_CONTA = 0, TRAD_ABONO_CONTA = 0 WHERE TRA_CODIGO = '".$CodigoFactura."'") or die(mysqli_error());

									    $SqlContable = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_ESTADO = 2 WHERE TRA_CODIGO = '".$CodigoFactura."'") or die(mysqli_error());


									   $SqlContable = mysqli_query($db, "UPDATE Bodega.$Tabla SET F_ESTADO = 2 WHERE F_CODIGO = '".$CodigoFactura."'") or die(mysqli_error());

####################################################################
####################################################################
######### REGISTRO DE KARDEX Y ACTUALIZACION DE EXISTENCIA #########
####################################################################
####################################################################
$Cantidad  = $_POST["Cantidad"];
$Producto  = $_POST["CodigoProducto"];
$ProductoNombre = $_POST["ProductoNombre"];
$Contador2  = count($_POST["CodigoProducto"]);


/*for($j=0; $j<$Contador2; $j++)
{
	$ProN = $ProductoNombre[$j]; 
	$Can = $Cantidad[$j];
	$Pro = $Producto[$j];
	$Pre = $Precio[$j];
	$costototaling =0;
	$costonu=0;

	$Prod = $Pro;


	$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$Prod;
				$result = mysqli_query($db, $queryp);
				while($rowe = mysqli_fetch_array($result))
				{
					if($rowe["P_LLEVA_EXISTENCIA"]==1){
					$existenciaAn=$rowe["P_EXISTENCIA_SOUVENIRS"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					if($Bodega==2){

						$nuevaexistencia = $rowe["P_EXISTENCIA_SOUVENIRS"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_SOUVENIRS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$Prod);
						}

					}else{
						$existenciaAn=0;
						$existenciaGAn=0;

						$cantidadgen = 0;

						$nuevaexistencia = 0;
					}

				$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
				VALUES('".$KCod."', '".$Uid."', '".$Prod."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Devolucion de Producto Segun Factura Anulada de Souvenir ".$NumeroAutorizacion."', '".$existenciaGAn."', '".$cantidadgen."', 2, '".$existenciaAn."', '".$nuevaexistencia."')");


				
		}
}*/
if($Bodega==1){

	$queryK = "SELECT * FROM Productos.KARDEX WHERE K_PUNTO_VENTA= 1 AND TRA_CODIGO ='$CodigoFactura'";
				$resultk = mysqli_query($db, $queryK);
				while($rowek = mysqli_fetch_array($resultk))
				{
					$ProdK=$rowek["P_CODIGO"];

					$Can=$rowek["K_EXISTENCIA_ANTERIOR_PUNTO"]-$rowek["K_EXISTENCIA_ACTUAL_PUNTO"];


					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdK;
				$result = mysqli_query($db, $queryp);
				while($rowe = mysqli_fetch_array($result))
				{
					if($rowe["P_LLEVA_EXISTENCIA"]==1){

					$existenciaAn=$rowe["P_EXISTENCIA_TERRAZAS"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_TERRAZAS"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_TERRAZAS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);
						

					}else{
						$existenciaAn=$Can;
						$existenciaGAn=$Can;

						$cantidadgen = $Can;

						$nuevaexistencia = $Can;
					}

				$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
				VALUES('".$KCod."', '".$Uid."', '".$ProdK."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Devolucion de Producto Segun Factura Anulada de ".$Punto." ".$NumeroAutorizacion." ".$CodigoFactura."', '".$existenciaGAn."', '".$cantidadgen."', 1, '".$existenciaAn."', '".$nuevaexistencia."')");


				
		}
					
				}

}
if($Bodega==2){

	$queryK = "SELECT * FROM Productos.KARDEX WHERE K_PUNTO_VENTA= 2 AND TRA_CODIGO ='$CodigoFactura'";
				$resultk = mysqli_query($db, $queryK);
				while($rowek = mysqli_fetch_array($resultk))
				{
					$ProdK=$rowek["P_CODIGO"];

					$Can=$rowek["K_EXISTENCIA_ANTERIOR_PUNTO"]-$rowek["K_EXISTENCIA_ACTUAL_PUNTO"];


					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdK;
				$result = mysqli_query($db, $queryp);
				while($rowe = mysqli_fetch_array($result))
				{
					if($rowe["P_LLEVA_EXISTENCIA"]==1){

					$existenciaAn=$rowe["P_EXISTENCIA_SOUVENIRS"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_SOUVENIRS"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_SOUVENIRS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);
						

					}else{
						$existenciaAn=$Can;
						$existenciaGAn=$Can;

						$cantidadgen = $Can;

						$nuevaexistencia = $Can;
					}

				$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
				VALUES('".$KCod."', '".$Uid."', '".$ProdK."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Devolucion de Producto Segun Factura Anulada de Souvenirs ".$NumeroAutorizacion." ".$CodigoFactura."', '".$existenciaGAn."', '".$cantidadgen."', 1, '".$existenciaAn."', '".$nuevaexistencia."')");


				
		}
					
				}

}
if($Bodega==3){

	$queryK = "SELECT * FROM Productos.KARDEX WHERE K_PUNTO_VENTA= 3 AND TRA_CODIGO ='$CodigoFactura'";
				$resultk = mysqli_query($db, $queryK);
				while($rowek = mysqli_fetch_array($resultk))
				{
					$ProdK=$rowek["P_CODIGO"];

					$Can=$rowek["K_EXISTENCIA_ANTERIOR_PUNTO"]-$rowek["K_EXISTENCIA_ACTUAL_PUNTO"];


					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdK;
				$result = mysqli_query($db, $queryp);
				while($rowe = mysqli_fetch_array($result))
				{
					if($rowe["P_LLEVA_EXISTENCIA"]==1){

					$existenciaAn=$rowe["P_EXISTENCIA_HELADOS"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_HELADOS"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_HELADOS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);
						

					}else{
						$existenciaAn=0;
						$existenciaGAn=0;

						$cantidadgen = 0;

						$nuevaexistencia = 0;
					}

				$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
				VALUES('".$KCod."', '".$Uid."', '".$ProdK."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Devolucion de Producto Segun Factura Anulada de Helados ".$NumeroAutorizacion." ".$CodigoFactura."', '".$existenciaGAn."', '".$cantidadgen."', 3, '".$existenciaAn."', '".$nuevaexistencia."')");


				
		}
					
				}

}

if($Bodega==4){

	$queryK = "SELECT * FROM Productos.KARDEX WHERE K_PUNTO_VENTA= 4 AND TRA_CODIGO ='$CodigoFactura'";
				$resultk = mysqli_query($db, $queryK);
				while($rowek = mysqli_fetch_array($resultk))
				{
					$ProdK=$rowek["P_CODIGO"];

					$Can=$rowek["K_EXISTENCIA_ANTERIOR_PUNTO"]-$rowek["K_EXISTENCIA_ACTUAL_PUNTO"];


					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdK;
				$result = mysqli_query($db, $queryp);
				while($rowe = mysqli_fetch_array($result))
				{
					if($rowe["P_LLEVA_EXISTENCIA"]==1){

					$existenciaAn=$rowe["P_EXISTENCIA_CAFE"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_CAFE"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_CAFE = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);
						

					}else{
						$existenciaAn=0;
						$existenciaGAn=0;

						$cantidadgen = 0;

						$nuevaexistencia = 0;
					}

				$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
				VALUES('".$KCod."', '".$Uid."', '".$ProdK."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Devolucion de Producto Segun Factura Anulada de Cafe Los Abuelos ".$NumeroAutorizacion." ".$CodigoFactura."', '".$existenciaGAn."', '".$cantidadgen."', 4, '".$existenciaAn."', '".$nuevaexistencia."')");


				
		}
					
				}

}

if($Bodega==8){

	$queryK = "SELECT * FROM Productos.KARDEX WHERE K_PUNTO_VENTA= 8 AND TRA_CODIGO ='$CodigoFactura'";
				$resultk = mysqli_query($db, $queryK);
				while($rowek = mysqli_fetch_array($resultk))
				{
					$ProdK=$rowek["P_CODIGO"];

					$Can=$rowek["K_EXISTENCIA_ANTERIOR_PUNTO"]-$rowek["K_EXISTENCIA_ACTUAL_PUNTO"];


					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdK;
				$result = mysqli_query($db, $queryp);
				while($rowe = mysqli_fetch_array($result))
				{
					if($rowe["P_LLEVA_EXISTENCIA"]==1){

					$existenciaAn=$rowe["P_EXISTENCIA_PIZZERIA"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_PIZZERIA"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_PIZZERIA = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);
						

					}else{
						$existenciaAn=$Can;
						$existenciaGAn=$Can;

						$cantidadgen = $Can;

						$nuevaexistencia = $Can;
					}

				$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
				VALUES('".$KCod."', '".$Uid."', '".$ProdK."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Devolucion de Producto Segun Factura Anulada de Pizzería ".$NumeroAutorizacion." ".$CodigoFactura."', '".$existenciaGAn."', '".$cantidadgen."', 1, '".$existenciaAn."', '".$nuevaexistencia."')");


				
		}
					
				}

}
if($Bodega==0.1){

	$queryK = "SELECT * FROM Productos.KARDEX WHERE TRA_CODIGO ='$CodigoFactura'";
				$resultk = mysqli_query($db, $queryK);
				while($rowek = mysqli_fetch_array($resultk))
				{
					$ProdK=$rowek["P_CODIGO"];
					$PuntoVenta=$rowek["K_PUNTO_VENTA"];

					$Can=$rowek["K_EXISTENCIA_ANTERIOR_PUNTO"]-$rowek["K_EXISTENCIA_ACTUAL_PUNTO"];


					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdK;
				$result = mysqli_query($db, $queryp);
				while($rowe = mysqli_fetch_array($result))
				{
					if($rowe["P_LLEVA_EXISTENCIA"]==1){

						if($PuntoVenta==1){

							$existenciaAn=$rowe["P_EXISTENCIA_TERRAZAS"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_TERRAZAS"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_TERRAZAS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);

						}elseif($PuntoVenta==2){

							$existenciaAn=$rowe["P_EXISTENCIA_SOUVENIRS"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_SOUVENIRS"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_SOUVENIRS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);

						}elseif($PuntoVenta==3){

							$existenciaAn=$rowe["P_EXISTENCIA_HELADOS"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_HELADOS"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_HELADOS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);

						}elseif($PuntoVenta==4){

							$existenciaAn=$rowe["P_EXISTENCIA_CAFE"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_CAFE"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_CAFE = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);

						}
					
						

					}else{
						$existenciaAn=0;
						$existenciaGAn=0;

						$cantidadgen = 0;

						$nuevaexistencia = 0;
					}

				$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
				VALUES('".$KCod."', '".$Uid."', '".$ProdK."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Devolucion de Producto Segun Factura Anulada de Eventos ".$NumeroAutorizacion." ".$CodigoFactura."', '".$existenciaGAn."', '".$cantidadgen."',  '".$PuntoVenta."', '".$existenciaAn."', '".$nuevaexistencia."')");


				
		}
					
				}

}

if($Bodega==0.2){

	$queryK = "SELECT * FROM Productos.KARDEX WHERE TRA_CODIGO ='$CodigoFactura'";
				$resultk = mysqli_query($db, $queryK);
				while($rowek = mysqli_fetch_array($resultk))
				{
					$ProdK=$rowek["P_CODIGO"];
					$PuntoVenta=$rowek["K_PUNTO_VENTA"];

					$Can=$rowek["K_EXISTENCIA_ANTERIOR_PUNTO"]-$rowek["K_EXISTENCIA_ACTUAL_PUNTO"];


					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdK;
				$result = mysqli_query($db, $queryp);
				while($rowe = mysqli_fetch_array($result))
				{
					if($rowe["P_LLEVA_EXISTENCIA"]==1){

						if($PuntoVenta==1){

							$existenciaAn=$rowe["P_EXISTENCIA_TERRAZAS"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_TERRAZAS"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_TERRAZAS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);

						}elseif($PuntoVenta==2){

							$existenciaAn=$rowe["P_EXISTENCIA_SOUVENIRS"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_SOUVENIRS"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_SOUVENIRS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);

						}elseif($PuntoVenta==3){

							$existenciaAn=$rowe["P_EXISTENCIA_HELADOS"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_HELADOS"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_HELADOS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);

						}elseif($PuntoVenta==4){

							$existenciaAn=$rowe["P_EXISTENCIA_CAFE"];
					$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

					$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;

					

						$nuevaexistencia = $rowe["P_EXISTENCIA_CAFE"] + $Can;

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_CAFE = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$ProdK);

						}
					
						

					}else{
						$existenciaAn=0;
						$existenciaGAn=0;

						$cantidadgen = 0;

						$nuevaexistencia = 0;
					}

				$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
				VALUES('".$KCod."', '".$Uid."', '".$ProdK."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Devolucion de Producto Segun Factura Anulada de Kiosco Pasillo ".$NumeroAutorizacion." ".$CodigoFactura."', '".$existenciaGAn."', '".$cantidadgen."',  '".$PuntoVenta."', '".$existenciaAn."', '".$nuevaexistencia."')");


				
		}
					
				}

}
######### FINALIZA KARDEX ###############


#############POR SI ES CREDITO#######################

$QueryCuentaPorCobrara = mysqli_query($db, "UPDATE Contabilidad.CUENTAS_POR_COBRAR SET
						CC_ESTADO = 3,
						CC_FECHA_PAGO = CURRENT_DATE()
						WHERE F_CODIGO = '$CodigoFactura'");







#############FINAL DE CREDITO #############################



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
