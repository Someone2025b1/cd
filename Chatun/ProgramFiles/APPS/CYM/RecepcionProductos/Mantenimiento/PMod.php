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

	<script type="text/javascript">
	function CodigoBarrasFun()
	{
		var Seleccionado = $("input[name='CodigoBarras']:checked").val();

		if(Seleccionado == 1)
		{
			$('#EscanearCodigoBarrasDIV').show();
			$('#CodigoBarrasNuevoDIV').hide();
			$('#Codigo').focus();
		}
		else
		{
			$('#EscanearCodigoBarrasDIV').hide();
			$('#CodigoBarrasNuevoDIV').show();

			var Codigo = $('#CodigoNuevo').val();
			$("#bcTarget1").barcode(Codigo, "code128",{barWidth:2, barHeight:120, renderer:"canvas"});
		}
	}
	function GenerarCodigoActual()
	{
		var Codigo = $('#CodigoBarrasActual').val();
			$("#bcTarget2").barcode(Codigo, "code128",{barWidth:2, barHeight:120, output:"canvas"});
	}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin " onload="GenerarCodigoActual()">

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
								$Consulta = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO = '".$Codigo."'";
								$Resultado = mysqli_query($db, $Consulta);
								while($row = mysqli_fetch_array($Resultado))
								{
									$Nombre = $row["P_NOMBRE"];
									$Stock  = $row["P_STOCK_MINIMO"];
									$Categoria = $row["CP_CODIGO"];
									$Precio = $row["P_PRECIO_VENTA"];
									$Compra = $row["P_PRECIO_COMPRA_PONDERADO"];
									$CodigoBarras = $row["P_CODIGO_BARRAS"];
									$UnidadMedida = $row["UM_CODIGO"];
									$estado= $row["P_ESTADO"];
									$llevaIn = $row["P_LLEVA_EXISTENCIA"];
									$Souvenirs = $row["P_SOUVENIRS"];
									$Terrazas = $row["P_TERRAZAS"];
									$Helados = $row["P_HELADOS"];
									$Cafe = $row["P_CAFE"];
									$Juegos = $row["P_JUEGOS"];
									$Taquilla = $row["P_TAQUILLA"];
									$Tilapia = $row["P_TILAPIA"];
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
								
						
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Nombre">Nombre</label>
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $Nombre; ?>"required/>
											
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="StockMinimo">Stock Mínimo</label>
											<input class="form-control" type="number" min="1" name="StockMinimo" id="StockMinimo" value="<?php echo $Stock; ?>" required/>
											
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
                                                    while($rowm = mysqli_fetch_array($result))
                                                    {
														if($rowm["UM_CODIGO"] == $UnidadMedida)
                                                    	{
                                                    		$Selected = 'selected';
                                                    	}
                                                    	else
                                                    	{
                                                    		$Selected = '';
                                                    	}
                                                        echo '<option value="'.$rowm["UM_CODIGO"].'" '.$Selected.'>'.$rowm["UM_NOMBRE"].'</option>';
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
                                        <label for="PrecioCompra">Precio de Compra Ponderado</label>
											<input class="form-control" step="any" type="number"  name="PrecioCompra" id="PrecioCompra" value="<?php echo $Compra; ?>" required/>
											
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="PrecioVenta">Precio de venta</label>
											<input class="form-control" type="number"  name="PrecioVenta" step="any" id="PrecioVenta" value="<?php echo $Precio; ?>" required/>
											
										</div>
									</div>
								</div>   
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="CodBarra">Código de barras</label>
											<input class="form-control" type="text"  name="CodBarra" id="CodBarra" value="<?php echo $CodigoBarras; ?>">
											
										</div>
									</div>
								</div>
                                <div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Estado" id="Estado" class="form-control" required>
												<option value="1"<?php if($estado==1){ echo 'selected'; } ?>>ACTIVO</option>
                                                <option value="0" <?php if($estado==0){ echo 'selected'; } ?>>INACTIVO</option>
											</select>
											<label for="Estado">Estado de Producto</label>
										</div>
									</div>
                                    <div class="col-lg-4">
                                        <br>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="LlevaInventario" id="LlevaInventario" <?php if($llevaIn==1){ echo 'checked';  } ?>>
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
												<input type="checkbox" name="Souvenirs" id="Souvenirs" <?php if($Souvenirs==1){ echo 'checked';  } ?>>
												<span>Souvenirs</span>
											</label>
										</div>
									</div> 
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Terrazas" id="Terrazas" <?php if($Terrazas==1){ echo 'checked';  } ?>>
												<span>Terrazas</span>
											</label>
										</div>
									</div>
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Helados" id="Helados" <?php if($Helados==1){ echo 'checked';  } ?>>
												<span>Helados</span>
											</label>
										</div>
									</div>
                                    
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Cafe" id="Cafe" <?php if($Cafe==1){ echo 'checked';  } ?>>
												<span>Cafe Los Abuelos</span>
											</label>
										</div>
									</div> 
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Juegos" id="Juegos" <?php if($Juegos==1){ echo 'checked';  } ?>>
												<span>Juegos</span>
											</label>
										</div>
									</div>
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Taquilla" id="Taquilla" <?php if($Taquilla==1){ echo 'checked';  } ?>>
												<span>Taquilla</span>
											</label>
										</div>
									</div>
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Tilapia" id="Tilapia" <?php if($Tilapia==1){ echo 'checked';  } ?>>
												<span>Tilapia</span>
											</label>
										</div>
									</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
						<a href="P.php"><button type="button" class="btn ink-reaction btn-raised btn-warning">Cancelar</button></a>
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
	<script src="../../../../../libs/barcode/jquery-barcode.js"></script>
	<!-- END JAVASCRIPT -->

	</body>
	</html>
