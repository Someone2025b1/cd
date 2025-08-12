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
    $(function() {
	    $('#FormAEnviar').submit( function() {
	        if($('#InventarioSel').is(':checked'))
	        {
	        	var Cuenta = document.getElementsByName('Cuenta[]');
	        	var Centinela = false;

	        	for(i=1; i<Cuenta.length; i++)
				{
					NombreCuenta = Cuenta[i].value;

					Txt = NombreCuenta.split('/');

					CodCuenta = Txt[0].split('.');

					Completo = CodCuenta[0]+'.'+CodCuenta[1]+'.'+CodCuenta[2];

					if(Completo == '1.01.06')
					{
						Centinela = true;
						
						
					}
				}

				if(Centinela == true)
					{
						return true;
					}
					else
					{
						alertify.error('Usted marcó la opción de -A Inventario Bodega-, pero no ingresó ninguna cuenta contable de Inventario.');
						return false;
					}
	        }
	        else
	        {
	        	var Cuenta = document.getElementsByName('Cuenta[]');

	        	for(i=1; i<Cuenta.length; i++)
				{
					NombreCuenta = Cuenta[i].value;

					Txt = NombreCuenta.split('/');

					CodCuenta = Txt[0].split('.');

					Completo = CodCuenta[0]+'.'+CodCuenta[1]+'.'+CodCuenta[2];

					if(Completo == '1.01.06')
					{
						Centinela = true;
						
						
					}
				}
				if(Centinela == true)
				{
					if($('#InventarioSel').is(':checked'))
					{
						return true;
					}
					else
					{
						alertify.error('Usted ingresó ninguna cuenta contable de Inventario pero no está marcada la opción de -A Inventario Bodega-.');
						return false;
					}
				}
	        }

	    });
	});

	$(function() {
	    $('#FormAEnviar').submit( function() {
	        if($('#MobiliarioEquipo').is(':checked'))
	        {
	        	var Cuenta = document.getElementsByName('Cuenta[]');
	        	var Centinela = false;

	        	for(i=1; i<Cuenta.length; i++)
				{
					NombreCuenta = Cuenta[i].value;

					Txt = NombreCuenta.split('/');
					
					if(Txt[0] == '1.02.01.004' || Txt[0] == '1.02.01.006' || Txt[0] == '1.02.01.010' || Txt[0] == '1.02.01.008' || Txt[0] == '1.03.01.001')
					{
						Centinela = true;
						
					}
				}

				if(Centinela == true)
					{
						return true;
					}
					else
					{
						alertify.error('Usted marcó la opción de -A Activo Fijo-, pero no ingresó ninguna cuenta contable de Activos Fijos.');
						return false;
					}
	        }
	        else
	        {
	        	return true;
	        }

	    });
	});

	//Función para agregar o eliminar filas en la tabla de construcciones
        $(function(){
        
            // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar").on('click', function(){
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
                Calcular();
            });
        });
        function BuscarCuenta(x){
		        //Obtenemos el value del input
		        var service = x.value;
		        var dataString = 'service='+service;
		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscarCuenta.php",
		            data: dataString,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function(data) {
		            	if(data == '')
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
				                //Hacemos desaparecer el resto de sugerencias
				                $('#suggestions').fadeOut(500);
				                $('#ModalSugerencias').modal('hide');
				            });	
			            }
		            }
		        });
		}
	function SelProveedor(x)
		{
			window.open('SelProveedor.php','popup','width=750, height=700');
			document.getElementById("SerieFactura").focus();
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
		function TotalCombus()
		{
			var Total = parseFloat($('#CantidadGalones').val() * $('#PrecioGalones').val());
			$('#TotalCombustible').val(Total.toFixed(2));


			var Cargos  = document.getElementsByName('Cargos[]');
			var Abonos  = document.getElementsByName('Abonos[]');

			var Impuesto = $('#Impuesto').val();
			
			
			TotalDeposito = parseFloat(Total) / 1.12;
			TotalImpuesto = parseFloat(Total) - parseFloat(TotalDeposito);

			Cargos[2].value = TotalImpuesto.toFixed(2);
			Cargos[1].value = TotalDeposito.toFixed(2);
			Abonos[3].value = Total;
			
			Calcular();
		}
		function Calcular()
		{
			var TotalCargos = 0;
			var TotalAbonos = 0;
			var Contador = document.getElementsByName('Cargos[]');
			var Cargos = document.getElementsByName('Cargos[]');
			var Abonos = document.getElementsByName('Abonos[]');

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
				$('#btnGuardar').prop("disabled", false);
			}
			else
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-success');
				$('#ResultadoPartida').addClass('alert alert-callout alert-danger');
				$('#NombreResultado').html('Partida Incompleta');
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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="IngresoPro.php" method="POST" role="form" id="FormAEnviar">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Ingreso de Factura de Compra</strong></h4>
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
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="NIT" id="NIT" readonly required/>
											<label for="NIT">NIT</label>
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
									<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Inventario" id="InventarioSel">
												<span>A Inventario Bodega</span>
											</label>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MobiliarioEquipo" id="MobiliarioEquipo">
												<span>A Activo Fijo</span>
											</label>
										</div>
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
								<div class="col-lg-12">
									<h5>Tipo</h5>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="B" name="TipoCompra" onChange="ComprobarTipo(this)" required>
										<span>Bienes</span>
									</label>
									<label class="radio-inline radio-styled">
										<input type="radio" value="C" name="TipoCompra" onChange="ComprobarTipo(this)" required>
										<span>Combustible</span>
									</label>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="I" name="TipoCompra" onChange="ComprobarTipo(this)" required>
										<span>Importación</span>
									</label>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="S" name="TipoCompra" onChange="ComprobarTipo(this)" required>
										<span>Servicios</span>
									</label>
								</div>
								<div id="DivCombustibles" style="display: none">
									<div class="row">
										<div class="col-lg-6 col-lg-6">
											<div class="form-group">
												<select name="Combustible" id="Combustible" class="form-control" onchange="ComprobarCombustible(this.value)">
													<option value="" disabled selected>Seleccione una opción</option>
													<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
	                                                    $query = "SELECT * FROM Contabilidad.COMBUSTIBLE ORDER BY COM_NOMBRE";
	                                                    $result = mysqli_query($db, $query);
	                                                    while($row = mysqli_fetch_array($result))
	                                                    {
	                                                        echo '<option value="'.$row["COM_CODIGO"].'">'.$row["COM_NOMBRE"].'</option>';
	                                                    }

	                                                ?>
												</select>
												<label for="Combustible">Tipo de Combustible</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-lg-6">
											<div class="form-group">
												<input class="form-control" type="text" name="DestinoCombustibles" id="DestinoCombustibles" maxlength="255" />
												<label for="DestinoCombustibles">Destino</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3 col-lg-9">
											<div class="form-group floating-label">
												<input class="form-control" type="number" step="any" name="CantidadGalones" id="CantidadGalones" onChange="TotalCombus()" min="0"/>
												<label for="CantidadGalones">Cantidad de Galones</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3 col-lg-9">
											<div class="form-group floating-label">
												<input class="form-control" type="number" step="any" name="PrecioGalones" id="PrecioGalones" onChange="TotalCombus()" min="0"/>
												<label for="PrecioGalones">Precio por Galon</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3 col-lg-9">
											<div class="form-group">
												<input class="form-control" type="number" step="any" name="TotalCombustible" id="TotalCombustible" readonly />
												<label for="TotalCombustible">Total</label>
											</div>
										</div>
									</div>
								</div>
								<div class="row"><br></div>
								<div id="DivProductosServicios" style="display: none">
									<div class="row">
										<div class="col-lg-3 col-lg-9">
											<div class="form-group floating-label">
												<input class="form-control" type="number" step="any" name="TotalFactura" id="TotalFactura" min="0" onChange="LlenarPartida(this)"/>
												<label for="TotalFactura">Total de Factura</label>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <td><strong>Cuenta</strong></td>
                                                <td><strong>Cargos</strong></td>
                                                <td><strong>Abonos</strong></td>
                                                <td><strong>Razón</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fila-base">
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0"></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)" value="1.01.02.001/Parque Chatún, S.A."></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0"></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)" value="1.01.05.001/IVA Crédito Fiscal"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0"></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0"></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
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
						<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" disabled>Guardar</button>
					</div>
					<br>
					<br>
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

	</body>
	</html>
