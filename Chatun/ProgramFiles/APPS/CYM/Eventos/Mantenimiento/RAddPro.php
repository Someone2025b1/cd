<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
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
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Recetas/Subrecetas</strong><br></h1>
				<br>
				<form class="form" action="CTAAddPro.php" method="POST" role="form">
					<?php
						$UI           = uniqid('r_');
						$UID          = uniqid('rd_');
						$Contador     = count($_POST["Producto"]);
						$Centinela    = true;

						$Nombre        = $_POST["Nombre"];
						$Categoria     = $_POST["Categoria"];
						$TipoReceta    = $_POST["TipoReceta"];
						$Precio        = $_POST["Precio"];
						$CategoriaMenuEventos = $_POST["CategoriaMenuEventos"];

						$Cantidad       = $_POST["Cantidad"];
						$Producto       = $_POST["Producto"];


						//Si es una Receta	
						if($TipoReceta == 1)
						{
							$sql = mysqli_query($db, "INSERT INTO Bodega.RECETA_SUBRECETA (RS_CODIGO, RS_NOMBRE, CM_CODIGO, RS_TIPO, RS_PRECIO, RS_BODEGA, RS_MODULO, CME_CODIGO)
												VALUES ('".$UI."', '".$Nombre."', 9, ".$TipoReceta.", ".$Precio.", 'EV', 'EV', ".$CategoriaMenuEventos.")");

								if ($_FILES['Fotografia']['size'] != '0') 
								{
									$tamano = $_FILES['Fotografia']['size']/1024;
									$archivo_subir = $_FILES['Fotografia']['name'];	
									$archivoBase = basename( $_FILES['Fotografia']['name']); 
									$trozos = explode(".", $archivoBase); 
			                        $extension = end($trozos);
									$uploaddir = "Images/";
									$base_archivo = uniqid().$extension;
									
									$path = $uploaddir.$base_archivo;
									$nuevo_nombre_archivo = $base_archivo;
									$nombre = addslashes($nombre);
								    if(copy($_FILES['Fotografia']['tmp_name'], $path)){
										mysqli_query ("UPDATE Bodega.RECETA_SUBRECETA SET RS_RUTA_FOTOGRAFIA = '".$path."' WHERE RS_CODIGO = '".$UI."'") or die (mysqli_error());
							        	$txt = "ARCHIVO SUBIDO CON ï¿½XITO.";
									} else {
										$txt = "ERROR AL SUBIR ARCHIVO, FAVOR DE VERIFICAR Y VOLVER A INTENTAR";
									}
								} else {
									$txt = "El archivo tiene 0Kb de tamaï¿½o, por lo que es un archivo erroneo, vuelva a seleccionar un archivo correcto.";	
								}

						
							if(!$sql)
							{
								echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo ingresar la receta/subreceta.</h2>
									</div>';
								echo mysqli_error($sql);
								
							}
							else
							{
								for($i=0; $i<$Contador; $i++)
								{
									$Can = $Cantidad[$i+1];
									$Pro = $Producto[$i];

									$query = mysqli_query($db, "INSERT INTO Bodega.RECETA_SUBRECETA_DETALLE (RSD_CODIGO, RS_CODIGO, RSD_CANTIDAD, P_CODIGO)
										VALUES('".$UID."', '".$UI."', ".$Can.", ".$Pro.")");

									if(!$query)
									{
										echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo ingresar la receta/subreceta.</h2>
										<h4 class="text-light">Código de transacción: '.$UID.'</h4>
									</div>';
									echo mysqli_error($query);
									$Centinela = false;
									
									}
								}
							}
						}
						//Si es una SubReceta
						else
						{

							$StockMinimo  = $_POST["StockMinimo"];
							$UnidadMedida = $_POST["UnidadMedida"];

							//Query para ingreso de la subreceta
							$sql = mysqli_query($db, "INSERT INTO Bodega.RECETA_SUBRECETA (RS_CODIGO, RS_NOMBRE, CM_CODIGO, RS_TIPO, RS_BODEGA, RS_MODULO)
												VALUES ('".$UI."', '".$Nombre."', ".$Categoria.", ".$TipoReceta.", 'EV', 'EV' )");

								if ($_FILES['Fotografia']['size'] != '0') 
								{
									$tamano = $_FILES['Fotografia']['size']/1024;
									$archivo_subir = $_FILES['Fotografia']['name'];	
									$archivoBase = basename( $_FILES['Fotografia']['name']); 
									$trozos = explode(".", $archivoBase); 
			                        $extension = end($trozos);
									$uploaddir = "Images/";
									$base_archivo = uniqid().$extension;
									
									$path = $uploaddir.$base_archivo;
									$nuevo_nombre_archivo = $base_archivo;
									$nombre = addslashes($nombre);
								    if(copy($_FILES['Fotografia']['tmp_name'], $path)){
										mysqli_query ("UPDATE Bodega.RECETA_SUBRECETA SET RS_RUTA_FOTOGRAFIA = '".$path."' WHERE RS_CODIGO = '".$UI."'") or die (mysqli_error());
							        	$txt = "ARCHIVO SUBIDO CON ï¿½XITO.";
									} else {
										$txt = "ERROR AL SUBIR ARCHIVO, FAVOR DE VERIFICAR Y VOLVER A INTENTAR";
									}
								} else {
									$txt = "El archivo tiene 0Kb de tamaï¿½o, por lo que es un archivo erroneo, vuelva a seleccionar un archivo correcto.";	
								}

						
							if(!$sql)
							{
								echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo ingresar la receta/subreceta.</h2>
									</div>';
								echo mysqli_error($sql);
								
							}
							else
							{
								for($i=0; $i<$Contador; $i++)
								{
									$Can = $Cantidad[$i+1];
									$Pro = $Producto[$i];

									$query = mysqli_query($db, "INSERT INTO Bodega.RECETA_SUBRECETA_DETALLE (RSD_CODIGO, RS_CODIGO, RSD_CANTIDAD, P_CODIGO)
										VALUES('".$UID."', '".$UI."', ".$Can.", ".$Pro.")");

									if(!$query)
									{
										echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo ingresar el producto a bodega.</h2>
										<h4 class="text-light">Código de transacción: '.$UID.'</h4>
									</div>';
									echo mysqli_error($query);
									$Centinela = false;
									
									}
								}
							}	


							//Query para ingreso de Prudcto
							$sql = mysqli_query($db, "INSERT INTO Bodega.PRODUCTO (P_NOMBRE, P_STOCK_MINIMO, CP_CODIGO, UM_CODIGO, P_CODIGO_SUBRECETA)
											VALUES ('".$Nombre."', ".$StockMinimo.", 'EV', ".$UnidadMedida.", '".$UI."')");
						}
						

						if($Centinela == true)
						{

							echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">La Receta/Subreceta se ingresó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="R.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
							</div>';
						}
					?>
					<br>
					<br>
				</form>
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
	<!-- END JAVASCRIPT -->

	</body>
	</html>
