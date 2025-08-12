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
				if($_POST["TipoReceta"] == 1)
				{
					$UI           = $_POST["CodigoRecetaSubreceta"];
					$UID          = uniqid('rd_');
					$Contador     = count($_POST["Producto"]);
					$Centinela    = true;

					$Cantidad       = $_POST["Cantidad"];
					$Producto       = $_POST["Producto"];

					$sql = mysqli_query($db, "UPDATE Bodega.RECETA_SUBRECETA SET RS_NOMBRE = '".$_POST["Nombre"]."', CM_CODIGO = ".$_POST["Categoria"].", RS_PRECIO = ".$_POST["Precio"]." WHERE RS_CODIGO = '".$_POST["CodigoRecetaSubreceta"]."'");
									
					if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
					{

						echo '<div class="alert alert-danger text-center" align="center"><strong>Error: </strong>No se pudo completar la transacción. <a href="R.php">Click Aquí</a> para regresar</div>';
						echo mysqli_error($sql);
						
					}
					else
					{
						$sql1 = mysqli_query($db, "DELETE FROM Bodega.RECETA_SUBRECETA_DETALLE WHERE RS_CODIGO = '".$_POST["CodigoRecetaSubreceta"]."'");
						if(!$sql1)
						{
							echo '<div class="alert alert-danger text-center" align="center"><strong>Error: </strong>No se pudo completar la transacción. <a href="R.php">Click Aquí</a> para regresar</div>';
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
					}
				}
				elseif($_POST["TipoReceta"] == 2)
				{
					$UI           = $_POST["CodigoRecetaSubreceta"];
					$UID          = uniqid('rd_');
					$Contador     = count($_POST["Producto"]);
					$Centinela    = true;

					$Cantidad       = $_POST["Cantidad"];
					$Producto       = $_POST["Producto"];

					$sql = mysqli_query($db, "UPDATE Bodega.RECETA_SUBRECETA SET RS_NOMBRE = '".$_POST["Nombre"]."', CM_CODIGO = ".$_POST["Categoria"]." WHERE RS_CODIGO = '".$_POST["CodigoRecetaSubreceta"]."'");

					$sqlProducto = mysqli_query($db, "UPDATE Bodega.PRODUCTO SET P_NOMBRE = '".$_POST["Nombre"]."', P_STOCK_MINIMO = ".$_POST["StockMinimo"].", UM_CODIGO = '".$_POST["UnidadMedida"]."'  WHERE P_CODIGO_SUBRECETA = '".$_POST["CodigoRecetaSubreceta"]."'");				

					if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
					{

						echo '<div class="alert alert-danger text-center" align="center"><strong>Error: </strong>No se pudo completar la transacción. <a href="R.php">Click Aquí</a> para regresar</div>';
						echo mysqli_error($sql);
						
					}
					else
					{
						$sql1 = mysqli_query($db, "DELETE FROM Bodega.RECETA_SUBRECETA_DETALLE WHERE RS_CODIGO = '".$_POST["CodigoRecetaSubreceta"]."'");
						if(!$sql1)
						{
							echo '<div class="alert alert-danger text-center" align="center"><strong>Error: </strong>No se pudo completar la transacción. <a href="R.php">Click Aquí</a> para regresar</div>';
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
