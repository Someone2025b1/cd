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
                Calcular();
            });
        });
	function BuscarProducto(x){
		        //Obtenemos el value del input
		        var service = x.value;
		        var dataString = 'service='+service;
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
		function Calcular()
		{
			var TotalFactura   = $('#TotalFactura').val();
			var SumaTotal      = 0;
			var Subtotal       = 0;
			var Contador       = document.getElementsByName('Cantidad[]');
			var Cantidad       = document.getElementsByName('Cantidad[]');
			var PrecioUnitario = document.getElementsByName('PrecioUnitario[]');
			var Total          = document.getElementsByName('Total[]');

			for(i=0; i<Contador.length; i++)
			{
				Subtotal = parseFloat(Total[i].value) / parseFloat(Cantidad[i].value);
				PrecioUnitario[i].value = Subtotal.toFixed(4);
				SumaTotal = SumaTotal + parseFloat(Total[i].value);
			}
			
			$('#TotalIngreso').val(SumaTotal.toFixed(2));

			if(TotalFactura == SumaTotal.toFixed(2))
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-danger');
				$('#ResultadoPartida').addClass('alert alert-callout alert-success');
				$('#NombreResultado').html('Sumas Iguales');
				$('#btnGuardar').prop("disabled", false);
				$('#agregar').prop("disabled", true);
			}
			else
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-success');
				$('#ResultadoPartida').addClass('alert alert-callout alert-danger');
				$('#NombreResultado').html('Sumas Diferentes');
				$('#btnGuardar').prop("disabled", true);
				$('#agregar').prop("disabled", false);
			}
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php

	$query = "SELECT MAX(TRA_NUMERO) AS CORRELATIVO FROM Bodega.TRANSACCION
				WHERE TT_CODIGO = 1";
	$result = mysqli_query($db, $query);
	while($row = mysqli_fetch_array($result))
	{	
		if($row["CORRELATIVO"] == 0)
		{
			$Correlativo = 1;
		}
		else
		{
			$Correlativo = $row["CORRELATIVO"] + 1;
		}

		$Codigo    = $_GET["Codigo"];
		$Factura   = $_GET["Factura"];
		$Proveedor = $_GET["Proveedor"];
		$Total     = $_GET["Total"];
	}
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="IngresoPro.php" method="POST" role="form">
				<input class="form-control" type="hidden" name="Codigo" id="Codigo" value="<?php echo $Codigo; ?>" readonly required/>
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Ingreso de Producto a Bodega</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group" >
											<input class="form-control" type="text" name="CodigoIngreso" id="CodigoIngreso" value="<?php echo $Correlativo; ?>" required readonly/>
											<label for="CodigoIngreso">No. de Ingreso</label>
										</div>
									</div>
								</div>	
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<input class="form-control" type="text" name="Proveedor" id="Proveedor" value="<?php echo $Proveedor; ?>" readonly required/>
											<label for="Proveedor">Proveedor</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3" >
										<div class="form-group">
											<input class="form-control" type="text" name="Factura" id="Factura" value="<?php echo $Factura; ?>" readonly required/>
											<label for="Factura">No. de Factura</label>
											<span id="SpanCIF"></span>
										</div>
									</div>
									<div class="col-lg-2" >
										<div class="form-group">
											<input class="form-control" type="text" name="Total" id="Total" value="<?php echo number_format($Total, 2, '.', ','); ?>" readonly required/>
											<input class="form-control" type="hidden" name="TotalFactura" id="TotalFactura" value="<?php echo  number_format($Total, 2, '.', ''); ?>" readonly required/>
											<label for="Total">Total de Factura</label>
											<span id="SpanCIF"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" readonly required/>
											<label for="Fecha">Fecha de Ingreso de Producto</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<select name="Bodega" id="Bodega" class="form-control" required>
												<option value="4">Bodega Central</option>
											</select>
											<label for="Bodega">Bodega</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="text" name="Concepto" id="Concepto"/>
											<label for="Concepto">Observaciones</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <td><strong>Cantidad</strong></td>
                                                <td><strong>Producto</strong></td>
                                                <td><strong>Precio Unitario</strong></td>
                                                <td><strong>Subtotal</strong></td>
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
												$query = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE 
															FROM Bodega.PRODUCTO, Bodega.UNIDAD_MEDIDA
															WHERE PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
															 ORDER BY P_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													if($row["CP_CODIGO"] == 'TR')
													{
														$BodegaNombre = 'Terrazas';
													}
													elseif($row["CP_CODIGO"] == 'SV')
													{
														$BodegaNombre = 'Souvenirs';
													}
													elseif($row["CP_CODIGO"] == 'HS')
													{
														$BodegaNombre = 'Helados Sarita';
													}
													elseif($row["CP_CODIGO"] == 'TQ')
													{
														$BodegaNombre = 'Taquilla';
													}
													elseif($row["CP_CODIGO"] == 'MT')
													{
														$BodegaNombre = 'Mantenimiento';
													}
													elseif($row["CP_CODIGO"] == 'PU')
													{
														$BodegaNombre = 'Papelería y Útiles';
													}

													echo '<option value="'.$row["P_CODIGO"].'">'.$row["P_NOMBRE"].' ('.$row["UM_NOMBRE"].') - '.$BodegaNombre.'</option>';
												}

												?>
											</select>
										</div></h6></td>
                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" style="width: 100px" value="0.00"  min="0" readonly></h6></td>
                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="Total[]" id="Total[]" style="width: 100px" value="0.00"  min="0" onChange="Calcular()"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="Cantidad[]" id="Cantidad[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0" required></h6></td>
                                                <td><h6><div class="form-group">
											<select name="Producto[]" id="Producto[]" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE 
															FROM Bodega.PRODUCTO, Bodega.UNIDAD_MEDIDA
															WHERE PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
															 ORDER BY P_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													if($row["CP_CODIGO"] == 'TR')
													{
														$BodegaNombre = 'Terrazas';
													}
													elseif($row["CP_CODIGO"] == 'SV')
													{
														$BodegaNombre = 'Souvenirs';
													}
													elseif($row["CP_CODIGO"] == 'HS')
													{
														$BodegaNombre = 'Helados Sarita';
													}
													elseif($row["CP_CODIGO"] == 'TQ')
													{
														$BodegaNombre = 'Taquilla';
													}
													elseif($row["CP_CODIGO"] == 'MT')
													{
														$BodegaNombre = 'Mantenimiento';
													}
													elseif($row["CP_CODIGO"] == 'PU')
													{
														$BodegaNombre = 'Papelería y Útiles';
													}
													
													echo '<option value="'.$row["P_CODIGO"].'">'.$row["P_NOMBRE"].' ('.$row["UM_NOMBRE"].') - '.$BodegaNombre.'</option>';
												}

												?>
											</select>
										</div></h6></td>
                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="PrecioUnitario[]" id="PrecioUnitario[]" style="width: 100px" value="0.00"  min="0" required readonly></h6></td>
                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="Total[]" id="Total[]" style="width: 100px" value="0.00"  min="0" required onChange="Calcular()"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                        	<tr>
                                        		<td></td>
                                        		<td></td>
                                                <td class="text-right">Total</td>
                                                <td><h6><input type="text" class="form-control" name="TotalIngreso" id="TotalIngreso" readonly style="width: 100px" value="0.00"  ></h6></td>
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
		
		<?php include("../MenuUsers.html"); ?>

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

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
