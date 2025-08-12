<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$id_user = $_SESSION["iduser"];

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
	
    <script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<link rel="stylesheet" type="text/css" href="../../../../../libs/alertify/css/alertify.core.css">
	<link rel="stylesheet" type="text/css" href="../../../../../libs/alertify/css/alertify.bootstrap.css">

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="card">
				<div class="card-body">
					<?php
						$CodigoUnico                    = uniqid();
						$Fecha                          = $_POST[Fecha];
						$HoraInicio                     = $_POST[HoraInicio];
						$HoraFin                        = $_POST[HoraFin];
						$TipoEvento                     = $_POST[TipoEvento];
						
						$CUI                            = $_POST[CUI];
						$NIT                            = $_POST[NIT];
						$Nombre                         = $_POST[Nombre];
						$Direccion                      = $_POST[Direccion];
						$Celular                        = $_POST[Celular];
						$Telefono                       = $_POST[Telefono];
						$Email                          = $_POST[Email];
						$CodigoCliente                  = $_POST[CodigoCliente];
						
						$Adultos                        = $_POST[Adultos];
						$Ninos                          = $_POST[Ninos];
						
						$RanchoSeleccionado             = $_POST[RanchoSeleccionado];
						$MontajeSeleccionado            = $_POST[MontajeSeleccionado];
						
						$Receta                         = $_POST[Receta];
						$Precio                         = $_POST[Precio];
						$Cantidad                       = $_POST[Cantidad];
						$SubTotal                       = $_POST[SubTotal];
						$Descuento                      = $_POST[Descuento];
						$Contador                       = count($Receta);
						
						$MobiliarioCristaleria          = $_POST[MobiliarioCristaleria];
						$PrecioMobiliarioCristaleria    = $_POST[PrecioMobiliarioCristaleria];
						$CantidadMobiliarioCristaleria  = $_POST[CantidadMobiliarioCristaleria];
						$DescuentoMobiliarioCristaleria = $_POST[DescuentoMobiliarioCristaleria];
						$SubTotalMobiliarioCristaleria  = $_POST[SubTotalMobiliarioCristaleria];
						$ContadorMobiliarioCristaleria  = count($MobiliarioCristaleria);
						
						$MobiliarioManteleria           = $_POST[MobiliarioManteleria];
						$PrecioMobiliarioManteleria     = $_POST[PrecioMobiliarioManteleria];
						$CantidadMobiliarioManteleria   = $_POST[CantidadMobiliarioManteleria];
						$DescuentoMobiliarioManteleria  = $_POST[DescuentoMobiliarioManteleria];
						$SubTotalMobiliarioManteleria   = $_POST[SubTotalMobiliarioManteleria];
						$ContadorMobiliarioManteleria   = count($MobiliarioManteleria);
						
						$MobiliarioMobiliario           = $_POST[MobiliarioMobiliario];
						$PrecioMobiliarioMobiliario     = $_POST[PrecioMobiliarioMobiliario];
						$CantidadMobiliarioMobiliario   = $_POST[CantidadMobiliarioMobiliario];
						$DescuentoMobiliarioMobiliario  = $_POST[DescuentoMobiliarioMobiliario];
						$SubTotalMobiliarioMobiliario   = $_POST[SubTotalMobiliarioMobiliario];
						$ContadorMobiliarioMobiliario   = count($MobiliarioMobiliario);
						
						$MobiliarioEquipo               = $_POST[MobiliarioEquipo];
						$PrecioMobiliarioEquipo         = $_POST[PrecioMobiliarioEquipo];
						$CantidadMobiliarioEquipo       = $_POST[CantidadMobiliarioEquipo];
						$DescuentoMobiliarioEquipo      = $_POST[DescuentoMobiliarioEquipo];
						$SubTotalMobiliarioEquipo       = $_POST[SubTotalMobiliarioEquipo];
						$ContadorMobiliarioEquipo       = count($MobiliarioEquipo);
						
						$MobiliarioAlquiler             = $_POST[MobiliarioAlquiler];
						$PrecioMobiliarioAlquiler       = $_POST[PrecioMobiliarioAlquiler];
						$CantidadMobiliarioAlquiler     = $_POST[CantidadMobiliarioAlquiler];
						$DescuentoMobiliarioAlquiler    = $_POST[DescuentoMobiliarioAlquiler];
						$SubTotalMobiliarioAlquiler     = $_POST[SubTotalMobiliarioAlquiler];
						$ContadorMobiliarioAlquiler     = count($MobiliarioAlquiler);
						
						$Servicios                      = $_POST[Servicios];
						$PrecioServicio                 = $_POST[PrecioServicio];
						$CantidadServicios              = $_POST[CantidadServicios];
						$DescuentoServicios             = $_POST[DescuentoServicios];
						$SubTotalServicios              = $_POST[SubTotalServicios];
						$ContadorServicios              = count($Servicios);
						
						$EnvioEmail                     = $_POST[EnvioEmail];

						if($_POST[CodigoCliente] != '')
						{
							$QueryExisteCliente = mysqli_query($db, "SELECT CE_CODIGO FROM Bodega.CLIENTE_EVENTO WHERE CE_CODIGO = ".$CodigoCliente)or die('Error 1'.mysqli_error());
							$RegistroExisteCliente = mysqli_num_rows($QueryExisteCliente);

							if($RegistroExisteCliente > 0)
							{
								$QueryUpdateCliente = mysqli_query($db, "UPDATE Bodega.CLIENTE_EVENTO SET CE_NOMBRE = '".$Nombre."',
																									CE_DIRECCION = '".$Direccion."',
																									CE_CELULAR = ".$Celular.",
																									CE_TELEFONO = ".$Telefono.",
																									CE_EMAIL = '".$Email."'
																									WHERE CE_CODIGO = ".$CodigoCliente)or die('Error 2'.mysqli_error());
							}
						}
						else
						{
							$QueryInsertCliente = mysqli_query($db, "INSERT INTO Bodega.CLIENTE_EVENTO(CE_CUI, CE_NIT, CE_NOMBRE, CE_DIRECCION, CE_CELULAR, CE_TELEFONO, CE_EMAIL)VALUES('".$CUI."', '".$NIT."', '".$Nombre."', '".$Direccion."', ".$Celular.", ".$Telefono.", '".$Email."')")or die('Error 3'.mysqli_error());

							$IDCliente = mysqli_insert_id();

							$CodigoCliente = $IDCliente;
						}

						$Query = mysqli_query($db, "INSERT INTO Bodega.COTIZACION(C_REFERENCIA, C_FECHA_EVENTO, C_HORA_INICIO_EVENTO, C_HORA_FIN_EVENTO, TE_CODIGO, CE_CODIGO, CE_CUI, CE_NIT, CE_NOMBRE, CE_DIRECCION, CE_CELULAR, CE_TELEFONO, CE_EMAIL, C_INVITADOS_ADULTOS, C_INVITADOS_NINOS, C_RANCHO, C_FECHA_INGRESO, C_HORA_INGRESO, C_ESTADO, C_USUARIO_INGRESO, C_TIPO_MONTAJE)VALUES('".$CodigoUnico."', '".$Fecha."', '".$HoraInicio."', '".$HoraFin."', ".$TipoEvento.", ".$CodigoCliente.", '".$CUI."', '".$NIT."', '".$Nombre."', '".$Direccion."', ".$Celular.", ".$Telefono.", '".$Email."', ".$Adultos.", ".$Ninos.", ".$RanchoSeleccionado.", CURRENT_DATE(), CURRENT_TIME(), 1, ".$id_user.", ".$MontajeSeleccionado.")")or die('Error 4'.mysqli_error());

						$UltimoID = mysqli_insert_id();

						for ($i=1; $i <= $Contador ; $i++)
						{
							$CodigoPlatillo = uniqid();

							if($Receta[$i-1] != '' && $Precio[$i] != '' && $Cantidad[$i] != '' && $SubTotal[$i] != '' && $Descuento[$i] != '')
							{

								$QueryPlatillo = mysqli_query($db, "INSERT INTO Bodega.PLATILLO_EVENTO(PE_CODIGO, C_REFERENCIA, RS_CODIGO, PE_PRECIO, PE_CANTIDAD, PE_SUBTOTAL, PE_DESCUENTO)VALUES('".$CodigoPlatillo."', '".$CodigoUnico."', '".$Receta[$i-1]."', ".$Precio[$i].", ".$Cantidad[$i].", ".$SubTotal[$i].", ".$Descuento[$i].")")or die('Error 5'.mysqli_error());
							}
						}

						for ($i=1; $i <= $ContadorMobiliarioManteleria ; $i++)
						{
							$CodigoMobiliario = uniqid();

							if($MobiliarioManteleria[$i-1] != '' && $PrecioMobiliarioManteleria[$i] != '' && $CantidadMobiliarioManteleria[$i] != '' && $SubTotalMobiliarioManteleria[$i] != '' && $DescuentoMobiliarioManteleria[$i] != '')
							{
								$QueryMobiliarioManteleria = mysqli_query($db, "INSERT INTO Bodega.MOBILIARIO_EVENTO(ME_CODIGO, C_REFERENCIA, M_CODIGO, M_PRECIO, M_CANTIDAD, M_SUBTOTAL, M_DESCUENTO)VALUES('".$CodigoMobiliario."', '".$CodigoUnico."', ".$MobiliarioManteleria[$i-1].", ".$PrecioMobiliarioManteleria[$i].", ".$CantidadMobiliarioManteleria[$i].", ".$SubTotalMobiliarioManteleria[$i].", ".$DescuentoMobiliarioManteleria[$i].")")or die('Error 6'.mysqli_error());
							}
						}

						for ($i=1; $i <= $ContadorMobiliarioCristaleria ; $i++)
						{
							$CodigoMobiliario = uniqid();

							if($MobiliarioCristaleria[$i-1] != '' && $PrecioMobiliarioCristaleria[$i] != '' && $CantidadMobiliarioCristaleria[$i] != '' && $SubTotalMobiliarioCristaleria[$i] != '' && $DescuentoMobiliarioCristaleria[$i] != '')
							{
								$QueryMobiliarioCristaleria = mysqli_query($db, "INSERT INTO Bodega.MOBILIARIO_EVENTO(ME_CODIGO, C_REFERENCIA, M_CODIGO, M_PRECIO, M_CANTIDAD, M_SUBTOTAL, M_DESCUENTO)VALUES('".$CodigoMobiliario."', '".$CodigoUnico."', ".$MobiliarioCristaleria[$i-1].", ".$PrecioMobiliarioCristaleria[$i].", ".$CantidadMobiliarioCristaleria[$i].", ".$SubTotalMobiliarioCristaleria[$i].", ".$DescuentoMobiliarioCristaleria[$i].")")or die('Error 6'.mysqli_error());
							}
						}

						for ($i=1; $i <= $ContadorMobiliarioMobiliario ; $i++)
						{
							$CodigoMobiliario = uniqid();

							if($MobiliarioMobiliario[$i-1] != '' && $PrecioMobiliarioMobiliario[$i] != '' && $CantidadMobiliarioMobiliario[$i] != '' && $SubTotalMobiliarioMobiliario[$i] != '' && $DescuentoMobiliarioMobiliario[$i] != '')
							{
								$QueryMobiliarioMobiliario = mysqli_query($db, "INSERT INTO Bodega.MOBILIARIO_EVENTO(ME_CODIGO, C_REFERENCIA, M_CODIGO, M_PRECIO, M_CANTIDAD, M_SUBTOTAL, M_DESCUENTO)VALUES('".$CodigoMobiliario."', '".$CodigoUnico."', ".$MobiliarioMobiliario[$i-1].", ".$PrecioMobiliarioMobiliario[$i].", ".$CantidadMobiliarioMobiliario[$i].", ".$SubTotalMobiliarioMobiliario[$i].", ".$DescuentoMobiliarioMobiliario[$i].")")or die('Error 6'.mysqli_error());
							}
						}

						for ($i=1; $i <= $ContadorMobiliarioEquipo ; $i++)
						{
							$CodigoMobiliario = uniqid();

							if($MobiliarioEquipo[$i-1] != '' && $PrecioMobiliarioEquipo[$i] != '' && $CantidadMobiliarioEquipo[$i] != '' && $SubTotalMobiliarioEquipo[$i] != '' && $DescuentoMobiliarioEquipo[$i] != '')
							{
								$QueryMobiliarioEquipo = mysqli_query($db, "INSERT INTO Bodega.MOBILIARIO_EVENTO(ME_CODIGO, C_REFERENCIA, M_CODIGO, M_PRECIO, M_CANTIDAD, M_SUBTOTAL, M_DESCUENTO)VALUES('".$CodigoMobiliario."', '".$CodigoUnico."', ".$MobiliarioEquipo[$i-1].", ".$PrecioMobiliarioEquipo[$i].", ".$CantidadMobiliarioEquipo[$i].", ".$SubTotalMobiliarioEquipo[$i].", ".$DescuentoMobiliarioEquipo[$i].")")or die('Error 6'.mysqli_error());
							}
						}

						for ($i=1; $i <= $ContadorMobiliarioAlquiler ; $i++)
						{
							$CodigoMobiliarioAlquiler = uniqid();

							if($MobiliarioAlquiler[$i-1] != '' && $PrecioMobiliarioAlquiler[$i] != '' && $CantidadMobiliarioAlquiler[$i] != '' && $SubTotalMobiliarioAlquiler[$i] != '' && $DescuentoMobiliarioAlquiler[$i] != '')
							{
								$QueryMobiliarioAlquiler = mysqli_query($db, "INSERT INTO Bodega.MOBILIARIO_EVENTO_ALQUILER(MEA_CODIGO, C_REFERENCIA, MA_CODIGO, MEA_PRECIO, MEA_CANTIDAD, MEA_SUBTOTAL, MEA_DESCUENTO)VALUES('".$CodigoMobiliarioAlquiler."', '".$CodigoUnico."', ".$MobiliarioAlquiler[$i-1].", ".$PrecioMobiliarioAlquiler[$i].", ".$CantidadMobiliarioAlquiler[$i].", ".$SubTotalMobiliarioAlquiler[$i].", ".$DescuentoMobiliarioAlquiler[$i].")")or die('Error 7'.mysqli_error());
							}
						}

						for ($i=1; $i <= $ContadorServicios ; $i++)
						{
							$CodigoServicios = uniqid();

							if($Servicios[$i-1] != '' && $PrecioServicio[$i] != '' && $CantidadServicios[$i] != '' && $SubTotalServicios[$i] != '' && $DescuentoServicios[$i] != '')
							{
								$QueryServicios = mysqli_query($db, "INSERT INTO Bodega.SERVICIO_EVENTO_CONTRATADO(SEC_CODIGO, C_REFERENCIA, SE_CODIGO, SEC_PRECIO, SEC_CANTIDAD, SEC_SUBTOTAL, SEC_DESCUENTO)VALUES('".$CodigoServicios."', '".$CodigoUnico."', ".$Servicios[$i-1].", ".$PrecioServicio[$i].", ".$CantidadServicios[$i].", ".$SubTotalServicios[$i].", ".$DescuentoServicios[$i].")")or die('Error 8'.mysqli_error());
							}
						}

						if($EnvioEmail == 1)
						{
							?>
								<script>
									ImprimirCotizacionEnvio();
								</script>
							<?php
						}

					?>
					<div class="col-lg-12 text-center">
						<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
						<h2 class="text-light">La cotización se ingresó correctamente.</h2>
						<div class="col-lg-12 text-center">
							<?php
								if($EnvioEmail == 1)
								{
									?>
										<a target="_blank" href="Cotizacion_Imp.php?Codigo=<?php echo $UltimoID ?>&Envio=1"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Imprimir</button></a>
									<?php
								}
								else
								{
									?>
										<a target="_blank" href="Cotizacion_Imp.php?Codigo=<?php echo $UltimoID ?>&Envio=0"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Imprimir</button></a>
									<?php	
								}
							?>
						</div>
					</div>
			</div>
			<!-- END CONTENT -->

			<?php include("../MenuUsers.html"); ?>

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
		<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
		<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.js"></script>
		<script src="../../../../../js/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<script src="../../../../../js/libs/carousel/dist/carousel.js"></script>
		<script src="../../../../../js/libs/carousel/src/lib/bane/bane.js"></script>
		<script src="../../../../../libs/alertify/js/alertify.js"></script>
		<!-- END JAVASCRIPT -->

		

	</body>
	</html>
