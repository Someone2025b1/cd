<?php
include("../../../../../Script/funciones.php");
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
	<style>
	.fila-base{
            display: none;
        }
    </style>
	
		
<script>
	 
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

		//Esto es del producto
		function BuscarProducto(x)
        {

				//Obtenemos el value del input
		        var Costo = document.getElementsByName('Costo[]');
		        var Cantidad = document.getElementsByName('Cantidad[]'); 
			    var Tipo = document.getElementsByName('Tipo[]'); 
		        var service = x.value;
		        var dataString = 'service='+service;
		        var Indice = $(x).closest('tr').index();
		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscarProducto.php",
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
			                    x.value = $(this).attr('id')+"/"+$(this).attr('data');
			                    Costo[Indice].value = $(this).attr('dataCosto');
			                    Tipo[Indice].value = $(this).attr('dataTipo');
								if (Tipo[Indice].value==3) 
								{
									Cantidad[Indice].value = $(this).attr('dataCant');
								}
			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#suggestions').fadeOut(500);
			                    $('#ModalSugerencias').modal('hide');
			                    CalcularTotal();
			                });
			            }
		            }
		        });
			}

           
			function CalcularTotal()
		{
			var Costo   = document.getElementsByName('Costo[]');
			var Cantidad = document.getElementsByName('Cantidad[]');
			var SubTotal = document.getElementsByName('SubTotal[]');
			var Total = 0;
			var SubTotalCalculado = 0;
			for(i = 1; i < Costo.length; i++)
			{
				SubTotalCalculado = parseFloat(Cantidad[i].value) * parseFloat(Costo[i].value);
				SubTotal[i].value = SubTotalCalculado.toFixed(2);
				Total = Total + SubTotalCalculado;
			}
			$('#BoldTotal').val(Total.toFixed(2));

		}

		function AgregarLinea()
		{
			$("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
		}
		function EliminarLinea(x)
		{
			var parent = $(x).parents().get(1);
                $(parent).remove();
                CalcularTotal();
		}

		function EnviarForm()
	{
		

		var Formulario = $('#FormularioEnviar');
		$(Formulario).attr('action', 'IngresarRecetaPro.php');
		$(Formulario).submit();
		
		

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
				<h1 class="text-center"><strong>Mantenimiento de Inventario de Recetas</strong><br></h1>
				<br>
				<form class="form" method="POST" role="form" id="FormularioEnviar">
				<button type="submit" disabled class="none" aria-hidden="true"></button>
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales de la Receta</strong></h4>
							</div>
							<?php
			if (saber_puesto($id_user)==15 | saber_puesto($id_user)==31){
				?>
					
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
                                        <label for="PrecioVenta">Precio de venta</label>
											<input class="form-control" type="number"  name="PrecioVenta" id="PrecioVenta" required/>
											
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
							</div>
							<div class="row">
							<div class="col-lg-4 col-lg-8">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Guarnicion" id="Guarnicion">
												<span>Es Guarnición</span>
											</label>
										</div>
									</div>
									</div>

								<div class="row">
								<div class="col-lg-4 col-lg-8">
								<div class="checkbox checkbox-styled">
									<label>
										<input type="checkbox" name="EligeSabor" id="EligeSabor" onchange="ElegirSabor(this)">
										<span>¿El cliente puede eligir el sabor del helado?</span>
									</label>
								</div>
								</div>
								<div class="row" id="DivElegirSabor" style="display: none;">
									<div class="col-lg-2 col-lg-8">
										<div class="form-group">
											<input type="number" class="form-control" step="any" name="CantidadBolas" id="CantidadBolas" min="1">
											<label for="CantidadBolas">Cantidad Bolas</label>
										</div>
									</div>
								</div>
								</div>
								
							
                            <div class="card-head style-primary">
								<h4 class="text-center"> Donde se Vendera </h4>
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
												<input type="checkbox" name="Mirador" id="Mirador">
												<span>Restaurante el Mirador</span>
											</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Eventos" id="Eventos">
												<span>Eventos</span>
											</label>
										</div>
									</div>
						</div>

						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Detalle de Receta</strong></h4>
							</div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Producto</th>
                                                <th>Costo</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fila-base">
                                                <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onChange="CalcularTotal()" style="width: 100px" min="0" required></h6></td>
                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onchange="BuscarProducto(this)" required></h6></td>
                                                <td><h6><input type="number" class="form-control" name="Costo[]" id="Costo[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly required></h6></td>
                                                <td><h6><input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]" onChange="CalcularTotal()" style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" required></h6></td>
                                                <td><h6><input type="hidden" class="form-control" name="Tipo[]" id="Tipo[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onChange="CalcularTotal()" style="width: 100px" min="0" required></h6></td>
                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onchange="BuscarProducto(this)" required></h6></td>
                                                <td><h6><input type="number" class="form-control" name="Costo[]" id="Costo[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly required></h6></td>
                                                <td><h6><input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]" onChange="CalcularTotal()" style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" required></h6></td>
                                                <td><h6><input type="hidden" class="form-control" name="Tipo[]" id="Tipo[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr style="display: none">
                                                <td></td>
                                                <td></td>
                                                <td style="text-align: right; vertical-align: text-top; font-size: 18px"><b>Descuento Q.</b></td>
                                                <td style="text-align: left; vertical-align: text-top; font-size: 18px"><input class="form-control" type="text" id="BoldDescuento" name="TotalFacturaConDescuento" value="0.00" readonly></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align: right; vertical-align: text-top; font-size: 20px"><b>Total Q.</b></td>
                                                <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="BoldTotal" name="TotalFacturaFinal" value="0.00" readonly></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-md" id="agregar" onclick="AgregarLinea()">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div>
                                </div>
                                </div>
                                </div>
					</div>
					<div class="col-lg-12" align="center">
					<button type="submit" onclick="EnviarForm()" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Guardar</button>
						</div>
					<br>
					<br>
					<?php
					}else{
						echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, Usuario no esta 
									Autorizado.</h2>
								</div>';

						

					}
					?>
					</div>
				</form>
			</div>
		</div>
	
		<!-- END CONTENT -->

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
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	<!-- BEGIN JAVASCRIPT -->
	<script src="../../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
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
