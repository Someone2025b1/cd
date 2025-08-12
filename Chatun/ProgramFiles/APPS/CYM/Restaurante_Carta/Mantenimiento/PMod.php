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
				<h1 class="text-center"><strong>Edición de Productos</strong><br></h1>
				<br>
				<form class="form" action="PModPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Editar Producto</strong></h4>
							</div>
							<div class="card-body">
								<?php 
								$Codigo = $_GET["Codigo"];
								$Consulta = "SELECT * FROM Bodega.PRODUCTO WHERE P_CODIGO = '".$Codigo."'";
								$Resultado = mysqli_query($db, $Consulta);
								while($row = mysqli_fetch_array($Resultado))
								{
									$Nombre = $row["P_NOMBRE"];
									$Stock  = $row["P_STOCK_MINIMO"];
									$Categoria = $row["CP_CODIGO"];
								}
								?>
								<div class="row">
									<div class="col-lg-1">
										<div class="form-group floating-label" id="DIVCIF">
										<input class="form-control" type="text" name="CodigoProducto" id="CodigoProducto" value="<?php echo $Codigo; ?>" required readonly/>
											<label for="CodigoProducto">Código</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $Nombre; ?>"  required/>
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
											<input class="form-control" type="number" step="any" name="Stock" id="Stock" value="<?php echo $Stock; ?>"  required/>
											<label for="Stock">Stock Mínimo</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Categoria" id="Categoria" class="form-control" required>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT * FROM Bodega.CATEGORIA_PRODUCTO ORDER BY CP_NOMBRE";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                    	if($row["CP_CODIGO"] == $Categoria)
                                                    	{
                                                    		$Selected = 'selected';
                                                    	}
                                                    	else
                                                    	{
                                                    		$Selected = '';
                                                    	}
                                                        echo '<option value="'.$row["CP_CODIGO"].'" '.$Selected.'>'.$row["CP_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="Categoria">Categoría de Producto</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
						<a href="CP.php"><button type="button" class="btn ink-reaction btn-raised btn-warning">Cancelar</button></a>
					</div>
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
