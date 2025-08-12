<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$QueryDatos = mysqli_query($db, "SELECT * FROM Bodega.DEGUSTACION WHERE D_CODIGO = ".$_GET[Codigo]);
$FilaDatos = mysqli_fetch_array($QueryDatos);

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
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<link rel="stylesheet" type="text/css" href="../../../../../libs/alertify/css/alertify.core.css">
	<link rel="stylesheet" type="text/css" href="../../../../../libs/alertify/css/alertify.bootstrap.css">
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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="card">
				<div class="card-body">
					<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
						<form action="Consulta_Degustacion_Pro.php" method="POST" class="form floating-label form-validation" role="form" novalidate="novalidate" id="FRMEnviar">
							<input type="hidden" name="RanchoSeleccionado" id="RanchoSeleccionado" value="<?php echo $FilaDatos[C_RANCHO] ?>">
							<input type="hidden" name="Codigo" id="Codigo" value="<?php echo $FilaDatos[D_REFERENCIA] ?>">
							<div class="form-wizard-nav">
								<div class="progress" style="width: 100%;"><div class="progress-bar progress-bar-primary" style="width: 0%;"></div></div>
								<ul class="nav nav-justified nav-pills">
									<li class="active"><a href="#step1" data-toggle="tab"><span class="step">1</span> <span class="title">FECHA</span></a></li>
									<li><a href="#step2" data-toggle="tab"><span class="step">2</span> <span class="title">CLIENTE</span></a></li>
									<li><a href="#step3" data-toggle="tab"><span class="step">3</span> <span class="title">COMIDA/BEBIDA</span></a></li>
									<li><a href="#step4" data-toggle="tab"><span class="step">4</span> <span class="title">ACTUALIZAR</span></a></li>
								</ul>
							</div><!--end .form-wizard-nav -->
							<div class="tab-content clearfix">
								<div class="tab-pane active" id="step1">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-4 text-right">
												<span class="text-xxxxl text-light"><i class="fa fa-calendar text-primary"></i></span>
											</div>	
											<div class="col-lg-6">
												<div class="col-lg-12">
													<div class="col-lg-6">
														<div class="form-group floating-label">
															<label>Fecha</label>
															<input type="date" class="form-control" name="Fecha" id="Fecha" value="<?php echo $FilaDatos[D_FECHA] ?>" required>
														</div>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="col-lg-4">
														<div class="form-group  floating-label">
															<label>Hora Inicio</label>
															<input type="time" class="form-control" name="HoraInicio" id="HoraInicio" value="<?php echo $FilaDatos[D_HORA] ?>" required>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div><!--end #step1 -->
								<div class="tab-pane" id="step2">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<input type="hidden" name="CodigoCliente" id="CodigoCliente" value="<?php echo $FilaDatos[CE_CODIGO] ?>" >
										<div class="col-lg-2 text-right">
											<span class="text-xxxxl text-light"><i class="fa fa-user text-primary"></i></span>
										</div>	
										<div class="col-lg-10">
											<div class="col-lg-12">
												<div class="col-lg-4">
													<div class="form-group floating-label">
														<label>CUI</label>
														<input type="text" class="form-control" name="CUI" id="CUI" value="<?php echo $FilaDatos[D_CUI] ?>" required onchange="ObtenerDatosCUI(this.value)">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group floating-label">
														<label>NIT</label>
														<input type="text" class="form-control" name="NIT" id="NIT" value="<?php echo $FilaDatos[D_NIT] ?>" required onchange="ObtenerDatosNIT(this.value)">
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="col-lg-6">
													<div class="form-group  floating-label">
														<label>Nombre</label>
														<input type="text" class="form-control" name="Nombre" id="Nombre" value="<?php echo $FilaDatos[D_NOMBRE] ?>" required>
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="col-lg-12">
													<div class="form-group  floating-label">
														<label>Dirección</label>
														<input type="text" class="form-control" name="Direccion" id="Direccion" value="<?php echo $FilaDatos[D_DIRECCION] ?>" required>
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="col-lg-3">
													<div class="form-group  floating-label">
														<label>Celular</label>
														<input type="number" class="form-control" name="Celular" id="Celular" value="<?php echo $FilaDatos[D_CELULAR] ?>" required>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group  floating-label">
														<label>Teléfono</label>
														<input type="number" class="form-control" name="Telefono" value="<?php echo $FilaDatos[D_TELEFONO] ?>" id="Telefono">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group  floating-label">
														<label>Email</label>
														<input type="email" class="form-control" name="Email" value="<?php echo $FilaDatos[D_EMAIL] ?>" id="Email">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div><!--end #step2 -->
								<div class="tab-pane" id="step3">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-1 text-right">
											<span class="text-xxxxl text-light"><i class="fa fa-cutlery text-primary"></i></span>
										</div>	
										<div class="col-lg-11">
											<div class="col-lg-12">
												<table class="table table-hover table-condensed" id="tabla">
													<caption class="text-center"><h3><strong>PLATILLOS - GUARNICIONES - BEBIDAS</strong></h3></caption>
													<thead>
														<tr>
															<th><h5>NOMBRE</h5></th>
															<th style="display: none"><h5>PRECIO</h5></th>
															<th><h5>CANTIDAD</h5></th>
															<th style="display: none"><h5>DESCUENTO</h5></th>
															<th style="display: none"><h5>SUBTOTAL</h5></th>
														</tr>
													</thead>
													<tbody>
														<tr class="fila-base">
															<td>
																<select class="form-control" name="Receta[]" id="Receta[]" onchange="ObtenerDatos(this)">
																	<option value="" disabled selected>Seleccione un Platillo</option>
																	<?php
																		$QueryPlatillo = mysqli_query($db, "SELECT A.RS_CODIGO, A.RS_NOMBRE
																										FROM Bodega.RECETA_SUBRECETA AS A
																										WHERE A.RS_MODULO = 'EV'
																										AND A.RS_TIPO = 1
																										AND A.RS_MOSTRAR_MENU = 1");
																		while($FilaPlatillo = mysqli_fetch_array($QueryPlatillo))
																		{
																			?>
																				<option value="<?php echo $FilaPlatillo[RS_CODIGO] ?>"><?php echo $FilaPlatillo[RS_NOMBRE] ?></option>
																			<?php
																		}
																	?>
																</select>
															</td>
															<td style="display: none">
																<input type="number" class="form-control" name="Precio[]" id="Precio[]" readonly>
															</td>
															<td>
																<input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onchange="Calcular()">
															</td>
															<td style="display: none">
																<input type="number" class="form-control" name="Descuento[]" id="Descuento[]" onchange="Calcular()">
															</td>
															<td style="display: none">
																<input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]" readonly>
															</td>
															<td class="eliminar">
																<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
															</td>
														</tr>
														<?php  
															$QueryPlatilloGuardados = mysqli_query($db, "SELECT *
																									FROM Bodega.PLATILLO_DEGUSTACION AS A
																									WHERE A.D_REFERENCIA = '".$FilaDatos[D_REFERENCIA]."'");
															while($FilaPlatilloGuardados = mysqli_fetch_array($QueryPlatilloGuardados))
															{
																?>
																	<tr>
																		<td>
																			<select class="form-control" name="Receta[]" id="Receta[]" onchange="ObtenerDatos(this)">
																				<?php
																					$QueryPlatillo = mysqli_query($db, "SELECT A.RS_CODIGO, A.RS_NOMBRE
																													FROM Bodega.RECETA_SUBRECETA AS A
																													WHERE A.RS_MODULO = 'EV'
																													AND A.RS_TIPO = 1
																													AND A.RS_MOSTRAR_MENU = 1");
																					while($FilaPlatillo = mysqli_fetch_array($QueryPlatillo))
																					{
																						if($FilaPlatilloGuardados[RS_CODIGO] == $FilaPlatillo[RS_CODIGO])
																						{
																							$Texto = 'selected';
																						}
																						else
																						{
																							$Texto = '';
																						}

																						?>
																							<option value="<?php echo $FilaPlatillo[RS_CODIGO] ?>" <?php echo $Texto ?>><?php echo $FilaPlatillo[RS_NOMBRE] ?></option>
																						<?php
																					}
																				?>
																			</select>
																		</td>
																		<td style="display: none">
																			<input type="number" class="form-control" name="Precio[]" id="Precio[]" value="<?php echo $FilaPlatilloGuardados[PE_PRECIO] ?>" readonly>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" value="<?php echo $FilaPlatilloGuardados[PD_CANTIDAD] ?>" onchange="Calcular()">
																		</td>
																		<td style="display: none">
																			<input type="number" class="form-control" name="Descuento[]" id="Descuento[]" value="<?php echo $FilaPlatilloGuardados[PE_DESCUENTO] ?>" onchange="Calcular()">
																		</td>
																		<td style="display: none">
																			<input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]" value="<?php echo $FilaPlatilloGuardados[PE_SUBTOTAL] ?>" readonly>
																		</td>
																		<td class="eliminar">
																			<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
																		</td>
																	</tr>
																<?php
															}
														?>
													</tbody>
												</table>
												<div class="col-lg-12 text-right">
													<button type="button" class="btn btn-success" id="agregar"><span class="glyphicon glyphicon-plus"></span></button>
												</div>
											</div>
										</div>
									</div>
								</div><!--end #step4 -->
								<div class="tab-pane" id="step4">
									<div class="card-body style-default-bright">
										<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<div class="form-group">
											<label class="col-sm-3 control-label">Enviar Email a Cliente?</label>
											<div class="col-sm-9">
												<div class="radio radio-styled">
													<label>
														<input type="radio" name="EnvioEmail" value="1" checked="">
														<span>Si</span>
													</label>
												</div>
												<div class="radio radio-styled">
													<label>
														<input type="radio" name="EnvioEmail" value="2">
														<span>No</span>
													</label>
												</div>
											</div><!--end .col -->
										</div>
									</div>
									<div class="col-lg-12 text-center">
										<button type="button" class="btn ink-reaction btn-raised btn-lg btn-primary" onclick="Confirmacion()">ACTUALIZAR</button>
									</div>
								</div><!--end #step4 -->
							</div><!--end .tab-content -->
						</form>
					</div>				
				</div>
			</div>
			<!-- END CONTENT -->

			<?php include("../MenuUsers.html"); ?>

		</div><!--end #base-->
		<!-- END BASE -->

		<div class="modal fade" id="ModalGaleria">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="row" id="Resultados"></div>
					</div>
				</div>
			</div>
		</div>



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
		<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.js"></script>
		<script src="../../../../../js/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<script src="../../../../../js/libs/carousel/dist/carousel.js"></script>
		<script src="../../../../../js/libs/carousel/src/lib/bane/bane.js"></script>
		<script src="../../../../../libs/alertify/js/alertify.js"></script>
		<!-- END JAVASCRIPT -->

		<script>
			function GaleriaRancho(x)
			{
				$.ajax({
						url: 'ObtenerFotografias.php',
						type: 'post',
						data: 'Codigo='+$(x).attr('data-codigo'),
						success: function (data) {
							$('#Resultados').html(data);
							$('#myCarousel').carousel();
							$('#ModalGaleria').modal('show');
						}
					});
			}
			function ObtenerDatos(x)
			{
				var Indice = $(x).closest('tr').index();
				var Precio = document.getElementsByName('Precio[]');

				$.ajax({
						url: 'ObtenerDatosPrecio.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							Precio[Indice].value = data;
							Calcular();
						}
					});
				
			}
			function ObtenerDatosMobiliario(x)
			{
				var Indice = $(x).closest('tr').index();
				var PrecioMobiliario = document.getElementsByName('PrecioMobiliario[]');

				$.ajax({
						url: 'ObtenerDatosPrecioMobiliario.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							PrecioMobiliario[Indice].value = data;
							CalcularMobiliario();
						}
					});
				
			}
			function ObtenerDatosMobiliarioAlquiler(x)
			{
				var Indice = $(x).closest('tr').index();
				var PrecioMobiliario = document.getElementsByName('PrecioMobiliarioAlquiler[]');

				$.ajax({
						url: 'ObtenerDatosPrecioMobiliarioAlquiler.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							PrecioMobiliario[Indice].value = data;
							CalcularMobiliarioAlquiler();
						}
					});
				
			}
			function ObtenerDatosServicios(x)
			{
				var Indice = $(x).closest('tr').index();
				var PrecioServicio = document.getElementsByName('PrecioServicio[]');

				$.ajax({
						url: 'ObtenerDatosServicio.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							PrecioServicio[Indice].value = data;
							CalcularServicios();
						}
					});
				
			}
			function CalcularMobiliario()
			{
				var Precio   = document.getElementsByName('PrecioMobiliario[]');
				var Cantidad = document.getElementsByName('CantidadMobiliario[]');
				var Descuento = document.getElementsByName('DescuentoMobiliario[]');
				var SubTotal = document.getElementsByName('SubTotalMobiliario[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value)) - parseFloat(Descuento[i].value);

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function CalcularServicios()
			{
				var Precio   = document.getElementsByName('PrecioServicio[]');
				var Cantidad = document.getElementsByName('CantidadServicios[]');
				var Descuento = document.getElementsByName('DescuentoServicios[]');
				var SubTotal = document.getElementsByName('SubTotalServicios[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value)) - parseFloat(Descuento[i].value);

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function CalcularMobiliarioAlquiler()
			{
				var Precio   = document.getElementsByName('PrecioMobiliarioAlquiler[]');
				var Cantidad = document.getElementsByName('CantidadMobiliarioAlquiler[]');
				var Descuento = document.getElementsByName('DescuentoMobiliarioAlquiler[]');
				var SubTotal = document.getElementsByName('SubTotalMobiliarioAlquiler[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value)) - parseFloat(Descuento[i].value);

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function Calcular()
			{
				var Precio   = document.getElementsByName('Precio[]');
				var Cantidad = document.getElementsByName('Cantidad[]');
				var Descuento = document.getElementsByName('Descuento[]');
				var SubTotal = document.getElementsByName('SubTotal[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value) - parseFloat(Descuento[i].value));

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function ObtenerDatosCUI(x)
			{
				$.ajax({
						url: 'ObtenerDatosCUI.php',
						type: 'post',
						data: 'Codigo='+x,
						success: function (response) {
							if(response != 0)
							{
								var json = $.parseJSON(response);
								$(json).each(function(i,val){
								    $.each(val,function(k,v){
									        if(k == 'nit')    
									        {
									        	$('#NIT').val(v);
									        }

									        if(k == 'nombre')    
									        {
									        	$('#Nombre').val(v);
									        	$('#ParrafoNombre').html(v);
									        }

									        if(k == 'direccion')    
									        {
									        	$('#Direccion').val(v);
									        	$('#ParrafoDireccion').html(v);
									        }

									        if(k == 'celular')    
									        {
									        	$('#Celular').val(v);
									        }

									        if(k == 'telefono')    
									        {
									        	$('#Telefono').val(v);
									        }

									        if(k == 'email')    
									        {
									        	$('#Email').val(v);
									        }

									        if(k == 'codigo')    
									        {
									        	$('#CodigoCliente').val(v);
									        }
									});
								});
							}
						}
					});
			}
			function ObtenerDatosNIT(x)
			{
				$.ajax({
						url: 'ObtenerDatosNIT.php',
						type: 'post',
						data: 'Codigo='+x,
						success: function (response) {
							if(response != 0)
							{
								var json = $.parseJSON(response);
								$(json).each(function(i,val){
								    $.each(val,function(k,v){
									        if(k == 'cui')    
									        {
									        	$('#CUI').val(v);
									        }

									        if(k == 'nombre')    
									        {
									        	$('#Nombre').val(v);
									        	$('#ParrafoNombre').html(v);
									        }

									        if(k == 'direccion')    
									        {
									        	$('#Direccion').val(v);
									        	$('#ParrafoDireccion').html(v);
									        }

									        if(k == 'celular')    
									        {
									        	$('#Celular').val(v);
									        }

									        if(k == 'telefono')    
									        {
									        	$('#Telefono').val(v);
									        }

									        if(k == 'email')    
									        {
									        	$('#Email').val(v);
									        }

									        if(k == 'codigo')    
									        {
									        	$('#CodigoCliente').val(v);
									        }
									});
								});
							}
						}
					});
			}
			function Confirmacion()
			{
				alertify.confirm("¿Está seguro que desea guardar con los datos seleccionados?", function (e) {
				    if (e) {
				        $('#FRMEnviar').submit();
				    }
				});
			}
		</script>

		<script>
	$(function(){
        
        // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
        $("#agregar").on('click', function(){
            $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
        });

        $("#agregarMobiliario").on('click', function(){
            $("#tablaMobiliario tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tablaMobiliario tbody");
        });

        $("#agregarMobiliarioAlquiler").on('click', function(){
            $("#tablaMobiliarioAlquiler tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tablaMobiliarioAlquiler tbody");
        });

        $("#agregarServicios").on('click', function(){
            $("#tablaServicios tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tablaServicios tbody");
        });

        // Evento que selecciona la fila y la elimina
        $(document).on("click",".eliminar",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            Calcular();
        });

        $(document).on("click",".eliminarMobiliario",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            CalcularMobiliario();
        });

        $(document).on("click",".eliminarMobiliarioAlquiler",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            CalcularMobiliarioAlquiler();
        });

        $(document).on("click",".eliminarServicios",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            CalcularServicios();
        });
    });
	</script>

	</body>
	</html>
