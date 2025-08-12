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
					if($_POST["PoseeCodigo"] == 0)
					{
						$CodigoNuevo  = $_POST["CodigoBarras"];
						
						if($CodigoNuevo == 1)
						{
							$CodigoBarrasNuevo = $_POST["Codigo"];
						}
						else
						{
							$CodigoBarrasNuevo = $_POST["CodigoNuevo"];
						}


						$sql = mysqli_query($db, "UPDATE Bodega.PRODUCTO SET P_NOMBRE = '".$_POST["Nombre"]."', P_STOCK_MINIMO = ".$_POST["Stock"].", CP_CODIGO = '".$_POST["Categoria"]."', P_PRECIO = ".$_POST["Precio"].", P_CODIGO_BARRAS = '".$CodigoBarrasNuevo."', P_ESTADO = '".$_POST["Estado"]."'   WHERE P_CODIGO = '".$_POST["CodigoProducto"]."'");
										
						if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
						{

							echo '<div class="alert alert-danger text-center" align="center"><strong>Error: </strong>No se pudo completar la transacción. <a href="P.php">Click Aquí</a> para regresar</div>';
							echo mysqli_error($sql);
							
						}
						else
						{
							echo '<div class="alert alert-success text-center" align="center"><strong>Bien! </strong>El registro se modificó con éxito. <a href="P.php">Click Aquí</a> para regresar</div>';
						}
					}
					else
					{
						

						$sql = mysqli_query($db, "UPDATE Bodega.PRODUCTO SET P_NOMBRE = '".$_POST["Nombre"]."', P_STOCK_MINIMO = ".$_POST["Stock"].", CP_CODIGO = '".$_POST["Categoria"]."', P_PRECIO = ".$_POST["Precio"].", P_ESTADO = '".$_POST["Estado"]."'   WHERE P_CODIGO = '".$_POST["CodigoProducto"]."'");
										
						if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
						{

							echo '<div class="alert alert-danger text-center" align="center"><strong>Error: </strong>No se pudo completar la transacción. <a href="P.php">Click Aquí</a> para regresar</div>';
							echo mysqli_error($sql);
							
						}
						else
						{
							echo '<div class="alert alert-success text-center" align="center"><strong>Bien! </strong>El registro se modificó con éxito. <a href="P.php">Click Aquí</a> para regresar</div>';
							echo '<div class="col-lg-12 text-center"><a href="P.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>';
						}
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
