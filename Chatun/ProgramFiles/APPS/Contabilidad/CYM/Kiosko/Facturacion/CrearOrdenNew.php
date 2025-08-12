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
														<input type="text" class="form-control" name="NITFactura" id="NITFactura" <?php if($Fila_TipoOrden["M_NIT_FACTURA"] != ''){echo 'value="'.$Fila_TipoOrden["M_NIT_FACTURA"].'"';}else{echo 'value="CF"';} ?> data-mesa="<?php echo $_GET["Mesa"] ?>" onchange="ActualizarNIT(this.value)">
													</div>
												</div>
												<div class="col-lg-12">
													<div class="col-lg-10">	
														<label for="Nombre">Nombre</label>
														<input type="text" class="form-control" name="Nombre" id="Nombre" <?php if($Fila_TipoOrden["M_NOMBRE_FACTURA"] != ''){echo 'value="'.$Fila_TipoOrden["M_NOMBRE_FACTURA"].'"';}else{echo 'value="Consumidor Final"';} ?> data-mesa="<?php echo $_GET["Mesa"] ?>" onchange="ActualizarNombre()" readonly>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="col-lg-10">	
														<label for="Direccion">Dirección</label>
														<input type="text" class="form-control" name="Direccion" id="Direccion" <?php if($Fila_TipoOrden["M_DIRECCION_FACTURA"] != ''){echo 'value="'.$Fila_TipoOrden["M_DIRECCION_FACTURA"].'"';}else{echo 'value="Ciudad"';} ?> data-mesa="<?php echo $_GET["Mesa"] ?>" onchange="ActualizarDireccion(this)" readonly>
													</div>
												</div>
											</div>
											<div class="row">
												<br>
											</div>
											<div class="row">
												<div id="Resultados">
												<table class="table" name="tabla" id="tabla">
																
																<tbody>
																<tr>
																		<th style="text-align: center;">Buscar Producto</th>
																	
																		<td><h6><input type="text" class="form-control" name="ProductoNombre" id="ProductoNombre" style="width: 750px;
																		padding: 5px;
																		outline: none;
																		border: 3px solid #0d5906;
																		font-weight: 200;
																		border-radius: 10px;
																		text-align: center; border-color: green;" onchange="BuscarProducto(this)"></h6></td> 
						                                            </tr>
																</tbody>
															</table>
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
		<div class="modal fade" tabindex="-1" role="dialog" id="ModalFacturas" >
		  <div class="modal-dialog modal-xs" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Credenciales de inicio de sesión</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<input type="hidden" id="Codigo" name="Codigo">
		      	<div class="row">
			      	 <div class="form-group">
			          <div class="col-xs-6">
			            <input required="" class="form-control" type="text" required="" placeholder="Usuario" name="usernameV" id="usernameV">
			          </div>
				      </div> 
				</div>
				<div class="row">
			        <div class="form-group ">
			          <div class="col-xs-6">
			            <input required="" class="form-control" type="password" required="" placeholder="Contraseña" id="passwordV" name="passwordV" required>
			          </div>
			        </div> 
		      	</div> 
		      </div> 
		      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
			        <button type="button" class="btn btn-primary" onclick="ValidarCredenciales()">Validar</button>
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
		<script src="../../../../../libs/alertify/js/alertify.js"></script>
		<!-- END JAVASCRIPT -->
		

		<script>
			function ObtenerDatosMenu()
			{
				
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
						url: 'ObtenerDatosOrdenNew.php',
						type: 'post',
						data: 'Mesa='+Mesa,
						success: function (data) {
							$('#ResultadosOrden').html(data);
						}
					});
			}
			function EliminarElemento(x, Impreso)
			{
				var Codigo = $(x).attr('data-codigo');
				if (Impreso==1) 
				{ 
				$.ajax({
						url: 'EliminarElemento.php',
						type: 'post',
						data: 'Codigo='+Codigo,
						success: function (data) {
							ObtenerDatosOrden();
						}
					});
				}
				else
				{
					$("#Codigo").val(Codigo);
					$("#ModalFacturas").modal("show"); 
				}
			}

			function ValidarCredenciales()
		{
			var Codigo = $("#Codigo").val();
			var Usuario = $("#usernameV").val();
			var Password = $("#passwordV").val();
			$.ajax({
				url: 'ComprobarUsuario.php',
				type: 'POST',
				dataType: 'html',
				data: {Usuario:Usuario, Password:Password},
				success:function(data)
				{
					if (data==3) 
					{
						alertify.error("No tiene permisos...");
					}
					else if (data==2) 
					{
						alertify.error("Usuario o contraseña incorrecta..");
					}
					else 
					{ 
						$.ajax({
						url: 'EliminarElemento.php',
						type: 'post',
						data: 'Codigo='+Codigo,
						success: function (data) {
							$("#ModalFacturas").modal("hide"); 
							ObtenerDatosOrden();
						}
						});					
					}
				}
			}) 
			
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
			function BuscarProducto(x)
        {

				//Obtenemos el value del input
		        var Precio = document.getElementsByName('Precio[]');
		        var Cantidad = document.getElementsByName('Cantidad[]'); 
		        var service = x.value;
				var j = '';
				
		        var dataString = 'service='+service;
		        var Indice = $(x).closest('tr').index();
		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscarProductoNew.php",
		            data: dataString,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function(data) {
		            	if(data == 0)
		            	{
		            		alertify.error('No se encontró ningún registro');
		            		$('#suggestions').html('');
		            	}
		            	else
		            	{
		            		$('#ModalSugerencias').modal('show');
			                //Escribimos las sugerencias que nos manda la consulta
			                $('#suggestions').fadeIn(1000).html(data);
			                //Al hacer click en algua de las sugerencias
			                $('.suggest-element').click(function(){
								document.getElementById('ProductoNombre').focus();
			                    x.value ="";
			                   

			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#suggestions').fadeOut(500);
			                    $('#ModalSugerencias').modal('hide');

								if($(this).attr('dataSabor') > 0)
			                    {
			                    	Sabores = $(this).attr('dataSabor');
			                    	ModalElegirSabores(Sabores);
			                    }
								
			                 

							
			                });
			            }
		            }
		        });
			}

			function AddLine()
		{
			$("#TablaSabores tr:eq(0)").clone().removeClass('fila-base1').appendTo("#TablaSabores");
		}

			function ModalElegirSabores(x)
		{
			$('#ModalSugerencias').modal('hide');
			$('#ModalSabores').modal('show');

			AddLine();

			$.ajax({
		            type: "POST",
		            url: "AgregarSaboresNew.php",
		            data: "Cantidad="+x,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function(data) {
		            	$('#SelectsSabores').html(data);
		            }
		        });

			
		}
		function AgregarSabores(x)
		{
    		var Mesa = $('#Mesa').val();

			if( $('#FormularioSabores')[0].checkValidity() )
			{
				var SaborHelado = document.getElementsByName('SaborHelado[]');
				var Contador = SaborHelado.length;



				for(i = 0; i< Contador; i++)
				{
					var Fila = SaborHelado[i];

					var AtributoFila = $(Fila).attr("data");
					var AtributoCodigo = $(Fila).val();
					

					$.ajax({
			            type: "POST",
			            url: "InsertarSabores.php",
			            data: "Codigo="+AtributoCodigo+"&Mesa="+Mesa,
			            beforeSend: function()
			            {
			            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
			            },
			            error: function(data) {
			            	alert('Algo Salió Mal!!!!');
			            }
			        });
				}
				$('#ModalSabores').modal('hide');
			}
			else
			{
				$('#FormularioSabores').find(':submit').click();
			}
		}
		</script>
		<!-- Modal Detalle Pasivo Contingente -->
<div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Resultados de su búsqueda</h2>
                    </div>
                    <div class="modal-body">
                    	<div id="suggestions" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

		 <!-- Modal Detalle Pasivo Contingente -->
		 <div id="ModalSabores" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <h2 class="modal-title">Elegir sabor de las bolas de helado</h2>
                    </div>
                    <div class="modal-body">
                    	<form class="form" role="form" id="FormularioSabores">
						<input type="hidden" name="MesaSabor" id="CodigoEmpleado" value="<?php echo $_GET["Mesa"] ?>">
	                    	<div id="SelectsSabores">

	                    	</div>
	                    	<button type="submit" id="BtnEvniarSabor" style="display: none"></button>
	                    </form>
                    </div>
                    <div class="modal-footer">
                    	<button type="button" class="btn btn-primary" onclick="AgregarSabores()">
                    	<span class="glyphicon glyphicon-check"></span> Agregar
                    	</button>
                    	
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

	</body>
	</html>
