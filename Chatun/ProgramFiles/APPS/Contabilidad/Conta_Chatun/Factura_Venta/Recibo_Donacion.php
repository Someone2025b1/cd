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
	<script>
	//Función para agregar o eliminar filas en la tabla de construcciones
        $(function(){
        
            // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar").on('click', function(){
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
            });

            $("#agregarP").on('click', function(){
                $("#tablaP tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tablaP tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });
        });
		function Calcular()
		{
			var TotalGeneral = 0;
			var Contador = document.getElementsByName('Cantidad[]');
			var Cantidad = document.getElementsByName('Cantidad[]');
			var PrecioUnitario = document.getElementsByName('PrecioUnitario[]');
			var Total = document.getElementsByName('Total[]');

			for(i=1; i<Contador.length; i++)
			{
				Total[i].value = parseFloat(Cantidad[i].value) * parseFloat(PrecioUnitario[i].value);

				TotalGeneral = parseFloat(TotalGeneral) + parseFloat(Total[i].value);
			}
			
			$('#GranTotal').val(TotalGeneral.toFixed(2));
		}
		function ComprobarNIT(x)
		{
			$.ajax({
				url: '../../../CYM/Eventos/Facturacion/BuscarNIT.php',
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
		function CalcularP()
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

			if(TotalCargos == TotalAbonos)
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
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="Recibo_Donacion_Pro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Ingreso de Recibo de Donación</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select name="Periodo" id="Periodo" class="form-control" required>
												<?php
													$QueryPeriodo = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE EPC_CODIGO = 1";
													$ResultPeriodo = mysqli_query($db, $QueryPeriodo);
													while($FilaP = mysqli_fetch_array($ResultPeriodo))
													{
														echo '<option value="'.$FilaP["PC_CODIGO"].'">'.$FilaP["PC_MES"]."-".$FilaP["PC_ANHO"].'</option>';
												}
												?>
											</select>
											<label for="Periodo">Periodo</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d') ?>" required/>
											<label for="Fecha">Fecha Recibo</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group" id="DIVCIF">
											<input class="form-control" type="text" name="NIT" id="NIT" onchange="ComprobarNIT(this.value)" value="CF" autofocus required/>
											<label for="NIT">Número de NIT</label>
										</div>
									</div>
									<div class="col-lg-9">
										<div class="form-group" id="DIVCIF">
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="Consumidor Final" onkeyup="ComprobarAcentos(this)" required readonly />
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Direccion" id="Direccion" required></textarea>
											<label for="Direccion">Dirección</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
											<input type="text" class="form-control" name="Departamento" id="Departamento" required>
											<label for="Departamento">Departamento</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group floating-label">
											<input type="text" class="form-control" name="Municipio" id="Municipio" required>
											<label for="Municipio">Municipio</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input type="text" class="form-control" name="CodigoPostal" id="CodigoPostal" required>
											<label for="CodigoPostal">Código Postal</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Descripcion" id="Descripcion" required></textarea>
											<label for="Descripcion">Descripción Recibo de Donación</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-center">
										<br>
										<br>
										<h3>Datos Recibo de Donación</h3>
									</div>
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                            	<td><strong>Tipo</strong></td>
                                                <td><strong>Cantidad</strong></td>
                                                <td><strong>Descripción</strong></td>
                                                <td><strong>Precio Unitario</strong></td>
                                                <td><strong>Total</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fila-base">
                                            	<td>
                                            		<select class="form-control" name="Tipo[]" id="Tipo[]">
                                            			<option value="B">Bien</option>
                                            			<option value="S">Servicio</option>
                                            		</select>
                                            	</td>
                                                <td><h6><input type="number" style="width: 100px" step="any" class="form-control" name="Cantidad[]" id="Cantidad[]" onchange="Calcular()"></h6></td>
                                                <td><h6><input type="text" style="width: 500px" class="form-control" name="Descripcion[]" id="Descripcion[]"></h6></td>
                                                <td><h6><input type="number" style="width: 100px" step="any" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" onchange="Calcular()"></h6></td>
                                                <td><h6><input type="number" style="width: 100px" step="any" class="form-control" name="Total[]" id="Total[]" readonly></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                            		<select class="form-control" name="Tipo[]" id="Tipo[]">
                                            			<option value="B">Bien</option>
                                            			<option value="S">Servicio</option>
                                            		</select>
                                            	</td>
                                                <td><h6><input type="number" style="width: 100px" step="any" class="form-control" name="Cantidad[]" onchange="Calcular()" id="Cantidad[]"></h6></td>
                                                <td><h6><input type="text" style="width: 500px" class="form-control" name="Descripcion[]" id="Descripcion[]"></h6></td>
                                                <td><h6><input type="number" style="width: 100px" step="any" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" onchange="Calcular()"></h6></td>
                                                <td><h6><input type="number" style="width: 100px" step="any" class="form-control" name="Total[]" id="Total[]" readonly></h6></td>
                                                <td class="eliminar"></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                        	<tr>
                                        		<td class="text-right" colspan="4">Total</td>
                                                <td><h6><input type="number" step="any" class="form-control" name="GranTotal" id="GranTotal"  readonly style="width: 100px" value="0.00"></h6></td>
                                        	</tr>
                                        </tfoot>
                                    </table>
                                    <div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-xs" id="agregar">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div>
								</div>									
								<div class="row">
									<div class="col-lg-12 text-center">
										<br>
										<br>
										<h3>Datos Partida</h3>
									</div>
									<table class="table table-hover table-condensed" name="tabla" id="tablaP">
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
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="CalcularP()" style="width: 100px" value="0.00" min="0"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="CalcularP()" style="width: 100px" value="0.00"  min="0"></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)" value=""></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="CalcularP()" style="width: 100px" value="0.00" min="0" ></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="CalcularP()" style="width: 100px" value="0.00"  min="0" ></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
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
                                        <button type="button" class="btn btn-success btn-xs" id="agregarP">
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
