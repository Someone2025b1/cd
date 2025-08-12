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
				<h1 class="text-center"><strong>Edición de Productos</strong><br></h1>
				<br>
				<?php
					$Codigo=$_POST["CodigoProducto"];
					$Nombre = $_POST["Nombre"];
					$StockMinimo = $_POST["StockMinimo"];
					$UnidadMedida = $_POST["UnidadMedida"];
					$PrecioVenta = $_POST["PrecioVenta"];
					$PrecioCompra = $_POST["PrecioCompra"];
					$CodBarra = $_POST["CodBarra"];
					$Estado = $_POST["Estado"];

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


						$sql = mysqli_query($db, "UPDATE Productos.PRODUCTO SET P_NOMBRE = '".$Nombre."', P_STOCK_MINIMO = ".$StockMinimo.", UM_CODIGO = '".$UnidadMedida."', P_PRECIO_COMPRA_PONDERADO = ".$PrecioCompra.", P_PRECIO_VENTA = ".$PrecioVenta.", P_CODIGO_BARRAS = '".$CodBarra."', P_ESTADO = '".$Estado."', P_SOUVENIRS = '".$Souvenirs."', P_TERRAZAS = '".$Terrazas."', P_HELADOS = '".$Helados."', P_CAFE = '".$Cafe."', P_JUEGOS = '".$Juegos."', P_TAQUILLA = '".$Taquilla."', P_TILAPIA = '".$Tilapia."', P_LLEVA_EXISTENCIA = '".$LlevaInventario."'  WHERE P_CODIGO = '".$Codigo."'");
										
						if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
						{

							echo '<div class="alert alert-danger text-center" align="center"><strong>Error: </strong>No se pudo completar la transacción. <a href="P.php">Click Aquí</a> para regresar</div>';
							echo mysqli_error($sq, $sql);
							
						}
						else
						{
							echo '<div class="alert alert-success text-center" align="center"><strong>Bien! </strong>El registro se modificó con éxito. <a href="P.php">Click Aquí</a> para regresar</div>';
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
