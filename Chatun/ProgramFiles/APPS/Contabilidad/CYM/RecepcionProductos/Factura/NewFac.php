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

	<style>
	.fila-base{
            display: none;
        }
    </style>
	<script language=javascript type=text/javascript>
		function stopRKey(evt) {
		var evt = (evt) ? evt : ((event) ? event : null);
		var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
		if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
		}
		document.onkeypress = stopRKey; 
	</script>
    <script>
    	$(function(){ 
             // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar1").on('click', function(){
                $("#tabla1 tbody tr:eq(0)").clone().removeClass('fila-base1').appendTo("#tabla1 tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar1",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
                CalcularTotal();
            });

            $("#agregar2").on('click', function(){
                $("#tabla2 tbody tr:eq(0)").clone().removeClass('fila-base2').appendTo("#tabla2 tbody");
            });
 
        });

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

	function SelProveedor(x)
		{
			window.open('SelProveedor.php','popup','width=750, height=700');
			document.getElementById("Pedido").focus();
		}
		function ComprobarTipo(x)
		{
			if(x.value == 'C')
			{
				$('#DivCombustibles').show();
				$('#DivProductosServicios').hide();
				$('#Combustible').attr("required", "required");
				$('#DestinoCombustibles').attr("required", "required");
				$('#CantidadGalones').attr("required", "required");
				$('#PrecioGalones').attr("required", "required");
				$('#TotalCombustible').attr("required", "required");
			}
			else
			{
				$('#DivCombustibles').hide();
				$('#Combustible').attr("required");
				$('#DestinoCombustibles').attr("required");
				$('#CantidadGalones').attr("required");
				$('#PrecioGalones').attr("required");
				$('#TotalCombustible').attr("required");
				$('#DivProductosServicios').show();
			}
		}
        
		function Calcular()
		{
			var TotalCargos = 0;
			var TotalAbonos = 0;
			var Contador = document.getElementsByName('Cargos[]');
			var Cargos = document.getElementsByName('Cargos[]');
			var Abonos = document.getElementsByName('Abonos[]');
            var TotalIng = document.getElementsByName('BoldTotal');
            var TotalFac = document.getElementsByName('TotalFactura');

			for(i=0; i<Contador.length; i++)
			{
				TotalCargos = parseFloat(TotalCargos) + parseFloat(Cargos[i].value);
				TotalAbonos = parseFloat(TotalAbonos) + parseFloat(Abonos[i].value);
			}
			
			$('#TotalCargos').val(TotalCargos.toFixed(2));
			$('#TotalAbonos').val(TotalAbonos.toFixed(2));
			if(TotalCargos.toFixed(2) == TotalAbonos.toFixed(2))
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-danger');
				$('#ResultadoPartida').addClass('alert alert-callout alert-success');
				$('#NombreResultado').html('Partida Completa');
				
			}
			else
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-success');
				$('#ResultadoPartida').addClass('alert alert-callout alert-danger');
				$('#NombreResultado').html('Factura Incompleta');
				$('#btnGuardar').prop("disabled", true);
			}
		}
		function LlenarPartida(x)
		{
			var Cargos  = document.getElementsByName('Cargos[]');
			var Abonos  = document.getElementsByName('Abonos[]');

			var Impuesto = $('#Impuesto').val();

			if(Impuesto == 0.05)
			{
				var Carg = Cargos[2];

				Cargos[2].value = 0.00;
				Cargos[1].value = x.value;
				Abonos[3].value = x.value;
				var parent = $(Carg).parents().get(2);
				$(parent).remove();
			}
			else
			{
				TotalImpuesto = (parseFloat(x.value)/1.12) * parseFloat(Impuesto);
				TotalDeposito = parseFloat(x.value) - parseFloat(TotalImpuesto);

				TotalImpuesto = TotalImpuesto.toFixed(2);
				TotalDeposito = TotalDeposito.toFixed(2);

				Cargos[2].value = TotalImpuesto;
				Cargos[1].value = TotalDeposito;
				Abonos[3].value = x.value;
			}	
			
			Calcular();
		}

	</script>
<script>
    //Esto es del producto
    function BuscarProducto(x)
        {

				//Obtenemos el value del input
		        var Precio = document.getElementsByName('Precio[]');
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
			                    Precio[Indice].value = $(this).attr('dataPrecio');
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
			var Precio   = document.getElementsByName('Precio[]');
			var Cantidad = document.getElementsByName('Cantidad[]');
			var SubTotal = document.getElementsByName('SubTotal[]');
            var TotalFac1 = document.getElementById('TotalFactura').value;
            var TotalFac = parseFloat(TotalFac1);
			var Total = 0;
			var SubTotalCalculado = 0;
			for(i = 1; i < Precio.length; i++)
			{
				PrecioCalculado = parseFloat(SubTotal[i].value) / parseFloat(Cantidad[i].value);
				Precio[i].value = PrecioCalculado.toFixed(2);
				Total = Total + parseFloat(SubTotal[i].value);
			}
			$('#BoldTotal').val(Total.toFixed(2));

            if( Total.toFixed(2) == TotalFac.toFixed(2))
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-danger');
				$('#ResultadoPartida').addClass('alert alert-callout alert-success');
                $('#NombreResultado').html('Factura y Poliza Completa');
				$('#btnGuardar').prop("disabled", false);
			}
			else
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-success');
				$('#ResultadoPartida').addClass('alert alert-callout alert-danger');
                $('#NombreResultado').html('Factura Incompleta');
				$('#btnGuardar').prop("disabled", true);
			}
			
		}

		function EnviarForm()
	{
		var Formulario = $('#FormularioEnviar');
		$(Formulario).attr('action', 'NewFacPro.php');
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
				<form class="form" method="POST" role="form" id="FormularioEnviar">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales de Factura de Compra</strong></h4>
							</div>
                        
							<div class="card-body">
								<div class="row">
									<div class="col-lg-6">
											<div class="form-group">
												<input class="form-control" type="text" name="Nombre" id="Nombre" placeholder="Click para seleccionar un proveedor" readonly onclick="SelProveedor(this)" required/>
												<label for="Nombre">Proveedor</label>
												<input class="form-control" type="hidden" name="Impuesto" id="Impuesto"  required/>
											</div>
									</div>
									<div class="col-lg-4">
											<div class="form-group">
												<input class="form-control" type="text" name="CodigoProveedor" id="CodigoProveedor" readonly onclick="SelProveedor(this)" required/>
												<label for="CodigoProveedor">Cuenta Contable</label>
											</div>
									</div>
								</div>
								<input class="form-control" type="hidden" name="RegimenC" id="RegimenC" readonly />
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="NIT" id="NIT" readonly required/>
											<label for="NIT">NIT</label>
										</div>
                                        <div class="col-lg-8">
										<div class="form-group">
											<input class="form-control" type="text" name="Pedido" id="Pedido" required/>
											<label for="Pedido">No. de Pedido</label>
										</div>
									</div>
									</div>
									<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="CajaChica" id="CajaChica">
												<span>Con Caja Chica</span>
											</label>
										</div>
									</div> 
									<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="FacturaEspecial" id="FacturaEspecial">
												<span>Factura Especial</span>
											</label>
										</div>
									</div> 
								</div>
								<div class="row">
									<div class="col-lg-2">
										<div class="form-group">
											<input class="form-control" type="text" name="SerieFactura" id="SerieFactura" required/>
											<label for="SerieFactura">No. de Serie</label>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="Factura" id="Factura" required/>
											<label for="Factura">No. de Factura</label>
										</div>
									</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d') ?>" required/>
											<label for="Fecha">Fecha Factura</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Descripcion" id="Descripcion" required></textarea>
											<label for="Descripcion">Descripción</label>
										</div>
									</div>
								</div>
								<div class="row"><br></div>
								<div id="DivProductosServicios">
									<div class="row">
										<div class="col-lg-3 col-lg-9">
											<div class="form-group floating-label">
												<input class="form-control" type="number" step="any" name="TotalFactura" id="TotalFactura" min="0" onChange="LlenarPartida(this)"/>
												<label for="TotalFactura">Total de Factura</label>
											</div>
										</div>
									</div>
								</div>
                                </div>
                            </div>
                        </div>
                    
                                <div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Ingreso de Productos</strong></h4>
							</div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fila-base">
                                                <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onChange="CalcularTotal()" style="width: 100px" min="0" required></h6></td>
                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onchange="BuscarProducto(this)" required></h6></td>
                                                <td><h6><input type="number" class="form-control" name="Precio[]" id="Precio[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly required></h6></td>
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
                                                <td><h6><input type="number" class="form-control" name="Precio[]" id="Precio[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly required></h6></td>
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
                                <div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Poliza Automatica</strong></h4>
							</div>
        
                            <div class="card-body">
                               
								<div class="col-lg-12">
									<table class="table table-hover table-condensed" name="tabla3" id="tabla3">
                                        <thead>
                                            <tr>
                                                <td><strong>Cuenta</strong></td>
                                                <td><strong>Cargos</strong></td>
                                                <td><strong>Abonos</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fila-base">
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="1.01.06.012/Inventario Bodega Puntos de Venta." readonly required/></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0" readonly required/></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0" readonly required/></h6></td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="1.01.05.001/IVA Crédito Fiscal" readonly required/></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0" readonly required/></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0" readonly required/></h6></td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" readonly required/></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0" readonly required/></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0" readonly required/></h6></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                        	<tr>
                                        		<td class="text-right">Total</td>
                                                <td><h6><input type="number" step="any" class="form-control" name="TotalCargos" id="TotalCargos"  readonly style="width: 100px" value="0.00"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="TotalAbonos" id="TotalAbonos" readonly style="width: 100px" value="0.00"  ></h6></td>
                                                <td><div style="height: 45px" id="ResultadoPartida" role="alert"><strong id="NombreResultado"></strong></div></td>
                                        	</tr>
                                        </tfoot>
                                    </table>
								</div>	
								<br>
								<div id="DivProduccionTilapia" style="display: none;">
						
					</div>
						<br>
						<div class="col-lg-12" align="center">
						<button type="submit" onclick="EnviarForm()" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" disabled>Guardar</button>
							</div>
							
					<br>
					<br>
					</form>								
				</div>
			</div>
		</div>
					   
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

	</body>
	</html>
