<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
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
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../MenuTop.php") ?>

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
						$StockMinimo = $_POST["StockMinimo"];
						$UnidadMedida = $_POST["UnidadMedida"];
						$PrecioVenta = $_POST["PrecioVenta"];
						$CodBarra = $_POST["CodBarra"];
						$Estado = $_POST["Estado"];
						$Costo = $_POST["Costo"];

						if(isset($_POST["LlevaInventario"]))
								{
									$LlevaInventario = 1;
								}
								else
								{
									$LlevaInventario = 0;
								}

						if(isset($_POST["Souvenirs"]))
								{
									$Souvenirs = 1;
								}
								else
								{
									$Souvenirs = 0;
								}

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

						if(isset($_POST["Juegos"]))
								{
									$Juegos = 1;
								}
								else
								{
									$Juegos = 0;
								}
					 
						if(isset($_POST["Taquilla"]))
								{
									$Taquilla = 1;
								}
								else
								{
									$Taquilla = 0;
								}

						if(isset($_POST["Tilapia"]))
								{
									$Tilapia = 1;
								}
								else
								{
									$Tilapia = 0;
								}
					 
						$sql = mysqli_query($db, "INSERT INTO Productos.PRODUCTO (P_NOMBRE, P_STOCK_MINIMO, UM_CODIGO, P_PRECIO_COMPRA_PONDERADO, P_PRECIO_VENTA, P_CODIGO_BARRAS, P_ESTADO, P_SOUVENIRS, P_TERRAZAS, P_HELADOS, P_CAFE, P_JUEGOS, P_TAQUILLA, P_TILAPIA, P_LLEVA_EXISTENCIA)
											VALUES ('".$Nombre."', '".$StockMinimo."', '".$UnidadMedida."', '".$Costo."',  '".$PrecioVenta."', '".$CodBarra."', '".$Estado."', '".$Souvenirs."', '".$Terrazas."', '".$Helados."', '".$Cafe."', '".$Juegos."', '".$Taquilla."', '".$Tilapia."', '".$LlevaInventario."')");
						
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
							echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El producto se ingresó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="IngresarProducto.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
							</div>';
						}
					?>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	<!-- BEGIN JAVASCRIPT -->
	<script src="../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../../js/core/source/App.js"></script>
	<script src="../../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../../js/core/source/AppCard.js"></script>
	<script src="../../../../js/core/source/AppForm.js"></script>
	<script src="../../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../../js/core/source/AppVendor.js"></script>
	<script src="../../../../js/core/demo/Demo.js"></script>
	<script src="../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<!-- END JAVASCRIPT -->

	</body>
	</html>
