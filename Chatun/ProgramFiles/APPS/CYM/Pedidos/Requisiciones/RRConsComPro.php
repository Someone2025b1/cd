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

	<script>
		function EnviarFormulario()
		{
			var formulario = document.getElementById("FormularioEnviar");
			formulario.submit();
			return true;
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php");

	$Numero   = $_POST["CodigoRe"]; #Codigo de la Requisicion
	$CodigoDetalle   = $_POST["CodigoReDetalle"]; #Codigo del detalle
	$Estado   = $_POST["RDEstado"]; #Estado
	$Valori   = $_POST["valori"]; #Estado
	

	?>
	

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form id="FormularioEnviar" action="RCConsCom.php?Numero=<?php echo $Numero ?>" method="POST">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Requisición</strong></h4>
							</div>
							<div class="card-body">
							<input type="hidden" name="CodigoRe" id="CodigoRe" value="<?php echo $Numero ?>">
							<input type="hidden" name="CodigoReDetalle" id="CodigoReDetalle" value="<?php echo $CodigoDetalle ?>">
							<input type="hidden" name="RDEstado" id="RDEstado" value="<?php echo $Estado ?>">
							
								<?php
								
							
								
								

								$i=$Valori;

											$QueryDetalle = "SELECT * FROM CompraVenta.REQUISICION_DETALLE WHERE RD_CODIGO = '$CodigoDetalle'";
											$ResultDetalle = mysqli_query($db, $QueryDetalle);
                                            
                                            	
                                            	while($row = mysqli_fetch_array($ResultDetalle))
                                            	{
													$Clasificacion = $row["RD_CLASIFICACION"];
													$RDCodigo      = $row["RD_CODIGO"];
													$Estado      = $row["RD_ESTADO"];
													$llevaCoti=0;


									if($Estado==2){	
														
									if($Clasificacion==2 | $Clasificacion==3 | $Clasificacion==4){

										$llevaCoti=1;
									
									if ($_FILES["documento1".$i]["error"] === 0) {

										$permitidos = array("application/pdf");
										$limite_kb = 1024; //1 MB
									
										if (in_array($_FILES["documento1".$i]["type"], $permitidos) && $_FILES["documento1".$i]["size"] <= $limite_kb * 1024) {
									
											$ruta = 'Cotizaciones/';
											$archivoNombre = $_FILES["documento1".$i]["name"];
											$trozos = explode(".", $archivoNombre); 
			                                $extension = end($trozos);
											$archivo = $ruta ."Cotizacion1-".$Numero."-".$i."-".$RDCodigo.".". $extension;
									
											if (!file_exists($ruta)) {
												mkdir($ruta, 0777, true);
											}
									
											
									
												$resultado = move_uploaded_file($_FILES["documento1".$i]["tmp_name"], $archivo);
									
												if ($resultado) {
													echo "Archivo Guardado";
												} else {
													echo "Error al guardar archivo";
												}
											
										} else {
											echo "Archivo no permitido o excede el tamaño";
										}

										$MontoCotizacion   = $_POST["MontoCoti1".$i]; #Clasificiacion

										$QueryColaborador = mysqli_query($db, "INSERT INTO CompraVenta.COTIZACION(R_CODIGO, RD_CODIGO, C_EXTENCION, C_NOMBRE, C_MONTO)
										VALUES('".$Numero."', '".$RDCodigo."', '".$extension."', '".$archivo."', '".$MontoCotizacion."')");
									}


									if ($_FILES["documento2".$i]["error"] === 0) {

										$permitidos = array("application/pdf");
										$limite_kb = 1024; //1 MB
									
										if (in_array($_FILES["documento2".$i]["type"], $permitidos) && $_FILES["documento2".$i]["size"] <= $limite_kb * 1024) {
									
											$ruta = 'Cotizaciones/';
											$archivoNombre = $_FILES["documento2".$i]["name"];
											$trozos = explode(".", $archivoNombre); 
			                                $extension = end($trozos);
											$archivo = $ruta ."Cotizacion2-".$Numero."-".$i."-".$RDCodigo.".". $extension;
									
											if (!file_exists($ruta)) {
												mkdir($ruta, 0777, true);
											}
									
											
									
												$resultado = move_uploaded_file($_FILES["documento2".$i]["tmp_name"], $archivo);
									
												if ($resultado) {
													echo "Archivo Guardado";
												} else {
													echo "Error al guardar archivo";
												}
											
										} else {
											echo "Archivo no permitido o excede el tamaño";
										}

										$MontoCotizacion   = $_POST["MontoCoti2".$i]; #Clasificiacion

										$QueryColaborador = mysqli_query($db, "INSERT INTO CompraVenta.COTIZACION(R_CODIGO, RD_CODIGO, C_EXTENCION, C_NOMBRE, C_MONTO)
										VALUES('".$Numero."', '".$RDCodigo."', '".$extension."', '".$archivo."', '".$MontoCotizacion."')");
									}

									if ($_FILES["documento3".$i]["error"] === 0) {

										$permitidos = array("application/pdf");
										$limite_kb = 1024; //1 MB
									
										if (in_array($_FILES["documento3".$i]["type"], $permitidos) && $_FILES["documento3".$i]["size"] <= $limite_kb * 1024) {
									
											$ruta = 'Cotizaciones/';
											$archivoNombre = $_FILES["documento3".$i]["name"];
											$trozos = explode(".", $archivoNombre); 
			                                $extension = end($trozos);
											$archivo = $ruta ."Cotizacion3-".$Numero."-".$i."-".$RDCodigo.".". $extension;
									
											if (!file_exists($ruta)) {
												mkdir($ruta, 0777, true);
											}
									
											
									
												$resultado = move_uploaded_file($_FILES["documento3".$i]["tmp_name"], $archivo);
									
												if ($resultado) {
													echo "Archivo Guardado";
												} else {
													echo "Error al guardar archivo";
												}
											
										} else {
											echo "Archivo no permitido o excede el tamaño";
										}

										$MontoCotizacion   = $_POST["MontoCoti3".$i]; #Clasificiacion

										$QueryColaborador = mysqli_query($db, "INSERT INTO CompraVenta.COTIZACION(R_CODIGO, RD_CODIGO, C_EXTENCION, C_NOMBRE, C_MONTO)
										VALUES('".$Numero."', '".$RDCodigo."', '".$extension."', '".$archivo."' , '".$MontoCotizacion."')");
									}
								}
							}
									
									


									if($Estado==1){

										$ClasificacionNueva   = $_POST["Clasificacion-".$CodigoDetalle]; #Clasificiacion
										$EstadoNuevo=2;
										$Descripcion="Se Empezo a Cotizar/Pedir";

										if($Clasificacion==0){

										$Query = mysqli_query($db, "UPDATE CompraVenta.REQUISICION_DETALLE SET
												RD_CLASIFICACION = '".$ClasificacionNueva."'
												WHERE RD_CODIGO= '$CodigoDetalle'");
										}
									}
									
									elseif($Estado==2){
	
										if($llevaCoti==0){
										$EstadoNuevo=6;
										$Descripcion="Se realizo el Pedido con el Proveedor";
										}else{
										$EstadoNuevo=3;
										$Descripcion="Cotizaciones enviadas pendiente de su confirmación";

										

										}
									}elseif($Estado==3){
										$EstadoNuevo=5;
										$Descripcion="Cotización ya fue Confirmada";
										

										
									}elseif($Estado==5){
										$EstadoNuevo=6;
										$Descripcion="Se realizo el Pedido con el Proveedor";


									}elseif($Estado==6){
										
										$Comentario   = $_POST["ObservacionR-".$CodigoDetalle]; #Comentario de Recibido

										
											if(isset($_POST["Factura-".$CodigoDetalle])) #Lleva Factura o No
											{
												$Factura = 1;
											}else
											{
												$Factura = 0;
											}

											if($Factura==1){
												$EstadoNuevo=9;
												$Descripcion="El Ususario Recibio el Producto/Servicio ya Facturado";
											}else{
												$EstadoNuevo=8;
												$Descripcion="El Ususario Recibio el Producto/Servicio Factura Pendiente";
											}
										
											$Query = mysqli_query($db, "UPDATE CompraVenta.REQUISICION_DETALLE SET
												RD_COMENTARIO = '".$Comentario."'
												WHERE RD_CODIGO= '$CodigoDetalle'");
										
									}elseif($Estado==8){
										$EstadoNuevo=9;
										$Descripcion="Se recibio la Factura";


									}elseif($Estado==9){
										$EstadoNuevo=10;
										$Descripcion="El Producto ya fue pagado";

									}
	
						
	
									$Query = mysqli_query($db, "UPDATE CompraVenta.REQUISICION_DETALLE SET
												RD_ESTADO = '".$EstadoNuevo."'
												WHERE RD_CODIGO= '$CodigoDetalle'");
	
	
	
									$QueryDetalle = mysqli_query($db, "INSERT INTO CompraVenta.SEGUIMIENTO_REQUICISION(R_CODIGO, RD_CODIGO, RD_ESTADO, SR_DESCRIPCIÓN, SR_FECHA, SR_HORA, U_CODIGO)
									VALUES('".$Numero."', '".$RDCodigo."', '".$EstadoNuevo."', '".$Descripcion."', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$id_user."')");
						
								
						

									
							}
								
								?>
							
							<?php
							if($Query){
							?>
											
											<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
									<h2 class="text-light">La requisición se Actualizo correctamente.</h2>
									<div class="row">
									</div>

											<?php
							}
											?>
									
									

							</div>
							
					</div>
					<br>
					<br>
				</form>

				
			</div>
		</div>
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
	</body>
	</html>
