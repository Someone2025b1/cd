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
				<h1 class="text-center"><strong>Mantenimiento de Inventario de Productos</strong><br></h1>
				<br>
				<form class="form" action="IngresarProductoPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Producto</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Nombre">Nombre</label>
											<input class="form-control" type="text" name="Nombre" id="Nombre" required/>
											
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="StockMinimo">Stock Mínimo</label>
											<input class="form-control" type="number" min="1" name="StockMinimo" id="StockMinimo" required/>
											
										</div>
									</div>
								</div>  
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="UnidadMedida" id="UnidadMedida" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT * FROM Bodega.UNIDAD_MEDIDA ORDER BY UM_NOMBRE";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["UM_CODIGO"].'">'.$row["UM_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="UnidadMedida">Unidad de Medida</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="PrecioVenta">Precio de venta</label>
											<input class="form-control" type="number" min="0" step="0.5" name="PrecioVenta" id="PrecioVenta" required/>
											
										</div>
										<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="Costo">Precio Costo</label>
											<input class="form-control" type="number" min="0" step="any" name="Costo" id="Costo" required/>
											
										</div>
									</div>
								</div>   
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="CodBarra">Código de barras</label>
											<input class="form-control" type="text"  name="CodBarra" id="CodBarra">
											
										</div>
									</div>
								</div>
                                <div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Estado" id="Estado" class="form-control" required>
												<option value="1">ACTIVO</option>
                                                <option value="0">INACTIVO</option>
											</select>
											<label for="Estado">Estado de Producto</label>
										</div>
									</div>
                                    <div class="col-lg-4">
                                        <br>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="LlevaInventario" id="LlevaInventario">
												<span>Lleva Inventario</span>
											</label>
										</div>
									</div>
							</div>
                            <div class="card-head style-primary">
								<h4 class="text-center"> Donde se Vendera </h4>
                            </div>
                            <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Souvenirs" id="Souvenirs">
												<span>Souvenirs</span>
											</label>
										</div>
									</div> 
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Terrazas" id="Terrazas">
												<span>Terrazas</span>
											</label>
										</div>
									</div>
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Helados" id="Helados">
												<span>Helados</span>
											</label>
										</div>
									</div>
                                    
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Cafe" id="Cafe">
												<span>Cafe Los Abuelos</span>
											</label>
										</div>
									</div> 
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Juegos" id="Juegos">
												<span>Juegos</span>
											</label>
										</div>
									</div>
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Taquilla" id="Taquilla">
												<span>Taquilla</span>
											</label>
										</div>
									</div>
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Tilapia" id="Tilapia">
												<span>Tilapia</span>
											</label>
										</div>
									</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
					</div>
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
