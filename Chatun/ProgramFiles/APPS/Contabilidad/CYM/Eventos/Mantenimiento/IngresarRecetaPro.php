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
				<h1 class="text-center"><strong>Mantenimiento de Productos</strong><br></h1>
				<br>
				<form class="form" method="POST" role="form">
					<?php
 
						$Nombre = $_POST["Nombre"];
						$StockMinimo = 1;
						$UnidadMedida = 6;
						$PrecioVenta = $_POST["PrecioVenta"];
						$CodBarra = "";
						$Estado = $_POST["Estado"];
						$CantidadBolas = 0;
						$CodR         =uniqid('rep_');
						$CodRD         =uniqid('repd_');						
						$LlevaInventario = 0;
						$Souvenirs = 0;
						$Terrazas = 0;
						$Helados = 0;
						$Cafe = 0;								
						$Juegos = 0;
						$Taquilla = 0;
						$Tilapia = 0;
						$Mirador = 0;
						$Evento = 1;
						$Servicio = 1;
						$Cantidad  = $_POST["Cantidad"];
						$Producto  = $_POST["ProductoNombre"];
						$Costo    = $_POST["Costo"];
						$SubTotal  = $_POST["SubTotal"];
						$Total  = $_POST["TotalFacturaFinal"];
						$ProductoNombre = $_POST["ProductoNombre"];
						$Tipo 			= $_POST["Tipo"];
						$Contador2  = count($_POST["ProductoNombre"]);
				
					 
					 
						$sql = mysqli_query($db, "INSERT INTO Productos.RECETA (R_CODIGO, R_NOMBRE, R_PRECIO, R_TERRAZAS, R_MIRADOR, R_CAFE, R_EVENTO, R_GUARNICION, R_CANTIDAD_BOLAS, R_SERVICIO)
											VALUES ('".$CodR."', '".$Nombre."', '".$Total."','".$Terrazas."', '".$Mirador."', '".$Cafe."', '".$Evento."', '".$Guarnicion."', '".$CantidadBolas."', 1)");
						
						$sql = mysqli_query($db, "INSERT INTO Productos.PRODUCTO (P_NOMBRE, P_STOCK_MINIMO, UM_CODIGO, P_PRECIO_COMPRA_PONDERADO, P_PRECIO_VENTA, P_CODIGO_BARRAS, P_ESTADO, P_SOUVENIRS, P_TERRAZAS, P_HELADOS, P_CAFE, P_JUEGOS, P_TAQUILLA, P_TILAPIA, P_LLEVA_EXISTENCIA, R_CODIGO, P_BOLA)
											VALUES ('".$Nombre."', '".$StockMinimo."', '".$UnidadMedida."', 0.00,  '".$PrecioVenta."', '".$CodBarra."', '".$Estado."', '".$Souvenirs."', '".$Terrazas."', '".$Helados."', '".$Cafe."', '".$Juegos."', '".$Taquilla."', '".$Tilapia."', '".$LlevaInventario."', '".$CodR."','".$CantidadBolas."')");
						
						if(!$sql)
						{
							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo ingresar el producto.</h2>
								</div>';
							echo mysqli_error($sq, $sql);
							
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
															VALUES('".$CodR."', '".$CodRD."', '".$j."', '".$Prod."', '".$Can."', '".$Pre."', '".$Sub."')");
									}

							echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El producto se ingresó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="IngresarReceta.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
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
