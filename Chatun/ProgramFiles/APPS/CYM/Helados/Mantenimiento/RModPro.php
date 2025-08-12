<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
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
				<?php
				
					$UI           = $_POST["CodigoRecetaSubreceta"];
					$UID          = uniqid('rd_');
					$Contador     = count($_POST["Producto"]);
					$Centinela    = true;

					$Cantidad       = $_POST["Cantidad"];
					$Producto       = $_POST["Producto"];

					$Nombre = $_POST["Nombre"];
						$StockMinimo = 1;
						$UnidadMedida = 6;
						$PrecioVenta = $_POST["PrecioVenta"];
						$CodBarra = "";
						$Estado = $_POST["Estado"];
						$CantidadBolas = $_POST["CantidadBolas"];
						$CantidadFruta = $_POST["CantidadFruta"];
						$CodR         =uniqid('rep_');
						$CodRD         =uniqid('repd_');

						
						
						if(isset($_POST["Terrazas"]))
								{
									$Terrazas = 1;
								}
								else
								{
									$Terrazas = 0;
								}

						if(isset($_POST["Helados"]))
								{
									$Helados = 1;
								}
								else
								{
									$Helados = 0;
								}

						if(isset($_POST["Cafe"]))
								{
									$Cafe = 1;
								}
								else
								{
									$Cafe = 0;
								}

						
								if(isset($_POST["Mirador"]))
								{
									$Mirador = 1;
								}
								else
								{
									$Mirador = 0;
								}

								if(isset($_POST["Guarnicion"]))
								{
									$Guarnicion = 1;
								}
								else
								{
									$Guarnicion = 0;
								}

								if(isset($_POST["Eventos"]))
								{
									$Eventos = 1;
								}
								else
								{
									$Eventos = 0;
								}

								if(isset($_POST["Yogurt"]))
								{
									$Yogurt = 1;
								}
								else
								{
									$Yogurt = 0;
								}



								$Cantidad  = $_POST["Cantidad"];
								$Producto  = $_POST["ProductoNombre"];
								$Costo    = $_POST["Costo"];
								$SubTotal  = $_POST["SubTotal"];
								$Total  = $_POST["TotalFacturaFinal"];
								$ProductoNombre = $_POST["ProductoNombre"];
								$Tipo 			= $_POST["Tipo"];
								$Contador2  = count($_POST["ProductoNombre"]);
								$CodigoReceta=$_POST["CodigoRecetaSubreceta"];


					
						

						$sql = mysqli_query($db, "UPDATE Productos.RECETA SET R_NOMBRE = '".$Nombre."', R_PRECIO = '".$Total."', R_CANTIDAD_BOLAS = '".$CantidadBolas."', R_TERRAZAS = '".$Terrazas."', R_MIRADOR = '".$Mirador."', R_CAFE = '".$Cafe."', R_EVENTO = '".$Eventos."', R_GUARNICION = '".$Guarnicion."' WHERE R_CODIGO = '".$CodigoReceta."'");

						$sqlp = mysqli_query($db, "UPDATE Productos.PRODUCTO SET P_NOMBRE = '".$Nombre."', P_PRECIO_VENTA = ".$PrecioVenta.", P_BOLA = ".$CantidadBolas.", P_FRUTA = ".$CantidadFruta.", P_YOGURT = ".$Yogurt.",  P_ESTADO = ".$Estado.", P_TERRAZAS = ".$Terrazas.", P_HELADOS = ".$Helados.", P_CAFE = ".$Cafe." WHERE R_CODIGO = '".$CodigoReceta."'");

									
					if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
					{

						echo '<div class="alert alert-danger text-center" align="center"><strong>Error: </strong>No se pudo completar la transacción principal. <a href="R.php">Click Aquí</a> para regresar</div>';
						echo mysqli_error($sql8);
						
					}
					else
					{
						$sql1 = mysqli_query($db, "DELETE FROM Productos.RECETA_DETALLE WHERE R_CODIGO = '".$CodigoReceta."'");
						if(!$sql1)
						{
							echo '<div class="alert alert-danger text-center" align="center"><strong>Error: </strong>No se pudo completar detalle la transacción. <a href="R.php">Click Aquí</a> para regresar</div>';
							echo mysqli_error($sql8);
							
						}
						else
						{

							for($j=1; $j<$Contador2; $j++)
									{
										$ProN = $ProductoNombre[$j]; 
										$Can = $Cantidad[$j];
										$Pro = $Producto[$j];
										$Pre = $Costo[$j];
										$Sub = $SubTotal[$j];
										$Tip = $Tipo[$j];
										$costototaling =0;
										$costonu=0;
										$ProductoXplotado = explode("/", $Pro);

										$Prod = $ProductoXplotado[0];

										

										$queryd = mysqli_query($db, "INSERT INTO Productos.RECETA_DETALLE (R_CODIGO, RD_CODIGO, RD_CORRELATIVO, P_CODIGO, RD_CANTIDAD, RD_COSTO, RD_SUBTOTAL)
															VALUES('".$CodigoReceta."', '".$CodRD."', '".$j."', '".$Prod."', '".$Can."', '".$Pre."', '".$Sub."')");
									}
								if(!$queryd)
								{
									echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo modificar la receta/subreceta.</h2>
									<h4 class="text-light">Código de transacción: '.$UID.'</h4>
									</div>';
									echo mysqli_error($query);
									$Centinela = false;
									
								}
							}
						}

						if($Centinela == true)
						{

							echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">La Receta/Subreceta se mpdificó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="R.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
							</div>';
						}
					
				
				
				?>
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
