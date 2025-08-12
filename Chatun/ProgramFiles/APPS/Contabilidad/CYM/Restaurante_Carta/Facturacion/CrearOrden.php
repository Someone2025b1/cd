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
	
    <script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

</head>
<body onload="ObtenerDatosOrden()">

	<?php 

	include("../../../../MenuTop.php");

	$Sql_TipoOrden = mysqli_query($db, "SELECT * FROM Bodega.MESA WHERE M_CODIGO = ".$_GET["Mesa"]);
	$Fila_TipoOrden = mysqli_fetch_array($Sql_TipoOrden);

	?>

	<!-- BEGIN BASE-->
	<div id="base">
		<input type="hidden" id="Mesa" value="<?php echo $_GET["Mesa"] ?>">
		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container-fluid">
				<div class="col-lg-12">
							<div class="row">
								<br>
							</div>
							<div class="row">
								<div class="col-lg-12 text-right">
									<a href="Orden.php"><button type="button" class="btn btn-warning"><span class="md md-keyboard-arrow-left"></span> Regresar</button></a>
								</div>
							</div>
							<div class="row">
								<br>
							</div>
							<div class="row">
								<div class="col-lg-8 col-md-6">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col-lg-12 text-center">
													<h4><b>Opciones de Orden</b></h4>
												</div>
												<div class="col-lg-12">
													<div class="col-sm-12">
														<div class="radio radio-styled">
															<label>
																<input type="radio" name="TipoOrden" value="1" <?php if($Fila_TipoOrden["M_TIPO_ORDEN"] == 1){echo 'checked';}elseif($Fila_TipoOrden["M_TIPO_ORDEN"] == ''){echo 'checked';} ?>>
																<span>Para comer aquí</span>
															</label>
														</div>
														<div class="radio radio-styled">
															<label>
																<input type="radio" name="TipoOrden" value="2" <?php if($Fila_TipoOrden["M_TIPO_ORDEN"] == 2){echo 'checked';} ?>>
																<span>Para llevar</span>
															</label>
														</div>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="col-lg-3">	
														<label for="NITFactura">NIT</label>
														<input type="text" class="form-control" name="NITFactura" id="NITFactura" <?php if($Fila_TipoOrden["M_NIT_FACTURA"] != ''){echo 'value="'.$Fila_TipoOrden[M_NIT_FACTURA].'"';}else{echo 'value="CF"';} ?> data-mesa="<?php echo $_GET["Mesa"] ?>" onchange="ActualizarNIT(this.value)">
													</div>
												</div>
												<div class="col-lg-12">
													<div class="col-lg-10">	
														<label for="Nombre">Nombre</label>
														<input type="text" class="form-control" name="Nombre" id="Nombre" <?php if($Fila_TipoOrden["M_NOMBRE_FACTURA"] != ''){echo 'value="'.$Fila_TipoOrden[M_NOMBRE_FACTURA].'"';}else{echo 'value="Consumidor Final"';} ?> data-mesa="<?php echo $_GET["Mesa"] ?>" onchange="ActualizarNombre()" readonly>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="col-lg-10">	
														<label for="Direccion">Dirección</label>
														<input type="text" class="form-control" name="Direccion" id="Direccion" <?php if($Fila_TipoOrden["M_DIRECCION_FACTURA"] != ''){echo 'value="'.$Fila_TipoOrden[M_DIRECCION_FACTURA].'"';}else{echo 'value="Ciudad"';} ?> data-mesa="<?php echo $_GET["Mesa"] ?>" onchange="ActualizarDireccion(this)" readonly>
													</div>
												</div>
											</div>
											<div class="row">
												<br>
											</div>
											<div class="row">
												<div id="Resultados">
												<?php

													//Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
													$query = "SELECT CATEGORIA_MENU.CM_NOMBRE, CATEGORIA_MENU.CM_CODIGO 
																FROM Bodega.CATEGORIA_MENU, Bodega.RECETA_SUBRECETA
																WHERE CATEGORIA_MENU.CM_CODIGO = RECETA_SUBRECETA.CM_CODIGO
																AND RECETA_SUBRECETA.RS_TIPO = 1
																AND RECETA_SUBRECETA.RS_BODEGA = 'TR'
																GROUP BY RECETA_SUBRECETA.CM_CODIGO";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														?>
															<div class="col-lg-3 col-md-6">
											                    <div class="panel panel-primary">
											                        <div class="panel-heading">
											                            <div class="row">
											                                <div class="col-xs-12 text-center">
											                                    <a onClick="AbrirModalResultados(<?php echo $row["CM_CODIGO"]; ?>)" style="text-decoration: none; cursor: pointer"><div><?php echo $row["CM_NOMBRE"] ?></div></a>
											                                </div>
											                            </div>
											                        </div>
											                    </div>
											                </div>
														<?php
													}

												?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-6">
									<div class="card">
										<div class="card-head text-center"><h3><b>Orden Actual</b></h3></div>	
										<div class="card-body">
											<div class="row">
												<div class="col-lg-12" id="ResultadosOrden"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
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
		<script src="../../../../../libs/alertify/js/alertify.js"></script>
		<!-- END JAVASCRIPT -->
		

		<script>
			function ObtenerDatosMenu()
			{
				$.ajax({
						url: 'ObtenerDatosMenu.php',
						type: 'post',
						success: function (data) {
							$('#Resultados').html(data);
						}
					});
			}
			function AbrirModalResultados(x)
			{

				$.ajax({
					url: 'ObtenerProductosOrden.php',
					type: 'POST',
					data: 'id='+x,
					success: function(opciones)
					{
						$('#Resultados').html(opciones)
					},
					error: function(opciones)
					{
						alert('Error'+opciones);
					}
				});
			}
			function AgregarProducto(x)
			{
				var Producto  = $(x).attr('dataProducto');
				var Mesa      = $('#Mesa').val();
				var TipoOrden = $('input:radio[name=TipoOrden]:checked').val();

				$.ajax({
					url: 'ElementoOrden.php',
					type: 'post',
					data: 'Producto='+Producto+'&Mesa='+Mesa+'&TipoOrden='+TipoOrden,
					success: function (data) {
						if(data == 1)
						{
							ObtenerDatosMenu();
							ActualizarNIT();
							ActualizarNombre();
							ActualizarDireccion();
							ObtenerDatosOrden();
						}
					}
				});
			}
			function ObtenerDatosOrden()
			{
				var Mesa = $('#Mesa').val();

				$.ajax({
						url: 'ObtenerDatosOrden.php',
						type: 'post',
						data: 'Mesa='+Mesa,
						success: function (data) {
							$('#ResultadosOrden').html(data);
						}
					});
			}
			function EliminarElemento(x)
			{
				var Codigo = $(x).attr('data-codigo');

				$.ajax({
						url: 'EliminarElemento.php',
						type: 'post',
						data: 'Codigo='+Codigo,
						success: function (data) {
							ObtenerDatosOrden();
						}
					});
			}
			function CambiarTotal(x)
			{
				var Valor = x.value;
				var Codigo = $(x).attr('data-codigo');

				if(parseFloat(Valor) <= 0)
				{
					$(x).val(1);

					$.ajax({
						url: 'CambiarValor.php',
						type: 'post',
						data: 'Valor='+Valor+'&Codigo='+Codigo,
						success: function (data) {
							ObtenerDatosOrden();
						}
					});
				}
				else
				{
					$.ajax({
						url: 'CambiarValor.php',
						type: 'post',
						data: 'Valor='+Valor+'&Codigo='+Codigo,
						success: function (data) {
							ObtenerDatosOrden();
						}
					});
				}
			}
			function DescartarOrden(x)
			{
				alertify.confirm("¿Está seguro que desea descartar la orden?", function (e) {
				    if (e) {
				        $.ajax({
				        		url: 'EliminarOrden.php',
				        		type: 'post',
				        		data: 'Mesa='+x,
				        		success: function (data) {
				        			if(data == 1)
				        			{
				        				window.location.href="Orden.php";
				        			}
				        			else
				        			{
				        				alertify.error('Hubo un error al tratar de eliminar la orden.');
				        			}
				        		}
				        	});
				    }
				});
			}
			function ActualizarNIT(x)
			{
				$.ajax({
					url: 'BuscarNIT.php',
					type: 'POST',
					data: 'id='+x,
					success: function(opciones)
					{
						var Datos = JSON.parse(opciones);

						if(parseFloat(opciones) != 0)
						{
							$('#Nombre').val(Datos['Nombre']);
							$('#Direccion').val(Datos['Direccion']);

							$('#DIVCIF').removeClass('has-success has-error has-feedback');
							$('#SpanNIT').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

							$('#DIVCIF').addClass('has-success has-feedback');
							$('#SpanNIT').addClass('glyphicon glyphicon-ok form-control-feedback');
							$('#EMNIT').html('');

							$('#ClienteRegistrado').val(1);
							
						}
						else if(parseFloat(opciones) == 0)
						{	
							$('#DIVCIF').removeClass('has-success has-error has-feedback');
							$('#SpanNIT').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

							$('#DIVCIF').addClass('has-error has-feedback');
							$('#SpanNIT').addClass('glyphicon glyphicon-remove form-control-feedback');
							$('#EMNIT').html('El Número de NIT no está registrado');	
							$('#ClienteRegistrado').val(2);					
						}
					},
					error: function(opciones)
					{
						alert('Error'+opciones);
					}
				})
			}
			function ActualizarNombre(x)
			{
				var Mesa = $(x).attr('data-mesa');
				var x = $('#Nombre').val();

				$.ajax({
						url: 'ActualizarNombre.php',
						type: 'post',
						data: 'Nombre='+x+'&Mesa='+Mesa,
						success: function (data) {
							if(data != "")
							{
								alertify.error('Hubo un problema al actualizar el Nombre');
							}
						}
					});
			}
			function ActualizarDireccion()
			{
				var Mesa = $(x).attr('data-mesa');
				var x = $('#Direccion').val();

				$.ajax({
						url: 'ActualizarDireccion.php',
						type: 'post',
						data: 'Direccion='+x+'&Mesa='+Mesa,
						success: function (data) {
							if(data != "")
							{
								alertify.error('Hubo un problema al actualizar la Direccion');
							}
						}
					});
			}
		</script>
	</body>
	</html>
