<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Codigo = $_GET["Codigo"];

$Consulta = "SELECT * FROM Bodega.RECETA_SUBRECETA WHERE RS_CODIGO = '".$Codigo."'";
	$Resultado = mysqli_query($db, $db, $db, $Consulta) or die (mysqli_error());
	while($row = mysqli_fetch_array($Resultado))
	{
		$Nombre    = $row["RS_NOMBRE"];
		$Categoria = $row["CM_CODIGO"];
		$Tipo      = $row["RS_TIPO"];
		$Precio    = $row["RS_PRECIO"];
		$ElegirSabor = $row["RS_ELEGIR_SABOR"];
		$CantidadBolas = $row["RS_CANTIDAD_BOLAS"];

		if($Tipo == 2)
		{
			$Consulta1 = "SELECT * FROM Bodega.PRODUCTO WHERE P_CODIGO_SUBRECETA = '".$Codigo."'";
			$Resultado1 = mysqli_query($db, $db, $db, $Consulta1) or die (mysqli_error());
			while($row1 = mysqli_fetch_array($Resultado1))
			{
				$Stock = $row1["P_STOCK_MINIMO"];
				$ProductoCodigo = $row1["CP_CODIGO"];
				$UnidadMedida = $row1["UM_CODIGO"];
			}
		}
	}
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
	<script src="../../../../../libs/alertify/js/alertify.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

	<style type="text/css">
        .fila-base{
            display: none;
        }
    	.suggest-element{
    		margin-left:5px;
    		margin-top:5px;
    		width:350px;
    		cursor:pointer;
    	}
    	#suggestions {
    		width:auto;
    		height:auto;
    		overflow: auto;
    	}
    </style>

	<script>
		$(function(){
        
            // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar").on('click', function(){
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });
        });
        function ElegirSabor(x)
        {
        	if(x.checked)
        	{
        		$('#DivElegirSabor').show();
        	}
        	else
        	{
        		$('#DivElegirSabor').hide();
        	}
        }
	</script>

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
				<form class="form" action="RModPro.php" method="POST" role="form">
					<input type="hidden" name="CodigoRecetaSubreceta" value="<?php echo $_GET["Codigo"] ?>">
					<?php 

					if($Tipo == 1)
					{

					?>
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales de la Receta/Subreceta</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $Nombre ?>" required/>
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="TipoReceta" id="TipoReceta" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="1" selected>Receta</option>
											</select>
											<label for="TipoReceta">Tipo</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-2 col-lg-8">
										<div class="form-group">
											<input type="number" class="form-control" step="any" name="Precio" id="Precio" value="<?php echo $Precio ?>" min="0" required>
											<label for="Precio">Precio</label>
										</div>
									</div>
								</div>
								<div class="checkbox checkbox-styled">
									<label>
										<input type="checkbox" name="EligeSabor" id="EligeSabor" onchange="ElegirSabor(this)" <?php if($ElegirSabor == 1){echo 'checked';} ?>>
										<span>¿El cliente puede eligir el sabor del helado?</span>
									</label>
								</div>
								<div class="row" id="DivElegirSabor" <?php if($ElegirSabor == 1){echo 'style="display: block;"';}else{echo 'style="display: none;"';} ?> >
									<div class="col-lg-2 col-lg-8">
										<div class="form-group">
											<input type="number" class="form-control" step="any" name="CantidadBolas" id="CantidadBolas" min="1" value="<?php echo $CantidadBolas ?>" required>
											<label for="CantidadBolas">Cantidad Bolas</label>
										</div>
									</div>
								</div>
								<?php
								}
								else
								{
									?>
									<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales de la Receta/Subreceta</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $Nombre ?>" required/>
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Categoria" id="Categoria" class="form-control" required>
												<option value="" disabled>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT * FROM Bodega.CATEGORIA_MENU ORDER BY CM_NOMBRE";
                                                    $result = mysqli_query($db, $db, $db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                    	if($Categoria == $row["CM_CODIGO"])
                                                    	{
                                                    		$Selected = 'selected';
                                                    	}
                                                    	else
                                                    	{
                                                    		$Selected = '';
                                                    	}
                                                        echo '<option value="'.$row["CM_CODIGO"].'" '.$Selected.'>'.$row["CM_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="Categoria">Categoría</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="TipoReceta" id="TipoReceta" class="form-control" required>
												<option value="" disabled>Seleccione una opción</option>
												<option value="2">Subreceta</option>
											</select>
											<label for="TipoReceta" selected>Tipo</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-2 col-lg-8">
										<div class="form-group">
											<input type="number" class="form-control" step="any" name="Precio" id="Precio" value="<?php echo $Precio ?>" min="0" required>
											<label for="Precio">Precio</label>
										</div>
									</div>
								</div>

								<div class="row" id="DIVProducto">
									<div class="row">
										<div class="col-lg-1">
											<div class="form-group floating-label" id="DIVCIF">
												<input class="form-control" type="number" min="1" name="StockMinimo" id="StockMinimo" value="<?php echo $Stock ?>" required/>
												<label for="StockMinimo">Mínimo</label>
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
	                                                    $result = mysqli_query($db, $db, $db, $query);
	                                                    while($row = mysqli_fetch_array($result))
	                                                    {
	                                                    	if($UnidadMedida == $row["UM_CODIGO"])
                                                    	{
                                                    		$Selected = 'selected';
                                                    	}
                                                    	else
                                                    	{
                                                    		$Selected = '';
                                                    	}
	                                                        echo '<option value="'.$row["UM_CODIGO"].'" '.$Selected.'>'.$row["UM_NOMBRE"].'</option>';
	                                                    }

	                                                ?>
												</select>
												<label for="UnidadMedida">Unidad de Medida</label>
											</div>
										</div>
									</div>
								</div>
								
								<?php
								}
								?>
								<div class="row">
									<table class="table table-hover table-condensed" id="tabla">
										<thead>
											<tr>
												<th>
													<h6><b>Cantidad</b></h6>
												</th>
												<th>
													<h6><b>Producto</b></h6>
												</th>
											</tr>
										</thead>
										<tbody>
											<tr class="fila-base">
                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="Cantidad[]" id="Cantidad[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0" ></h6></td>
                                                <td><h6><div class="form-group">
											<select name="Producto[]" id="Producto[]" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE FROM Bodega.PRODUCTO, Bodega.UNIDAD_MEDIDA WHERE PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO AND CP_CODIGO = 'HS' ORDER BY P_NOMBRE";
												$result = mysqli_query($db, $db, $db, $query);
												while($row = mysqli_fetch_array($result))
												{
													echo '<option value="'.$row["P_CODIGO"].'">'.$row["P_NOMBRE"].' ('.$row["UM_NOMBRE"].')'.'</option>';
												}

												?>
											</select>
										</div></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
											<?php
												$Consulta2 = "SELECT RECETA_SUBRECETA_DETALLE.*, PRODUCTO.P_NOMBRE, UNIDAD_MEDIDA.UM_NOMBRE 
																FROM Bodega.RECETA_SUBRECETA_DETALLE, Bodega.PRODUCTO, Bodega.UNIDAD_MEDIDA 
																WHERE RECETA_SUBRECETA_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO 
																AND PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
																AND RS_CODIGO = '".$Codigo."'";
												$Resultado2 = mysqli_query($db, $db, $db, $Consulta2) or die (mysqli_error());
												while($row2 = mysqli_fetch_array($Resultado2))
												{
													?>
														<tr>
			                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="Cantidad[]" id="Cantidad[]" value="<?php echo $row2["RSD_CANTIDAD"] ?>" style="width: 100px" value="0.00" min="0" ></h6></td>
			                                                <td><input type="hidden" name="Producto[]" id="Producto[]" value="<?php echo $row2["P_CODIGO"] ?>" class="form-control">
			                                                	<input type="text" name="ProductoNombre[]" id="ProductoNombre[]" value="<?php echo $row2["P_NOMBRE"].' ('.$row2["UM_NOMBRE"].')'; ?>" class="form-control"></td>
			                                                <td class="eliminar">
			                                                    <button type="button" class="btn btn-danger btn-xs">
			                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
			                                                    </button>
			                                                </td>
			                                            </tr>
													<?php
												}
											?>
										</tbody>
									</table>
									<div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-xs" id="agregar">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div>
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
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
