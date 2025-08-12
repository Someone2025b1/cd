<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
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
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

	<style type="text/css">
        .fila-base{
            display: none;
        }
        .fila-base1{
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

    <script language=javascript type=text/javascript>
		function stopRKey(evt) {
		var evt = (evt) ? evt : ((event) ? event : null);
		var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
		if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
		}
		document.onkeypress = stopRKey; 
	</script>

	<script> 
		 function AbrirModalPrincipal(x)
		{
			$('#ModalPrincipal').modal('show');
			var Indice = $(x).closest('tr').index();
			$('#ROWControl').val(Indice);
			$(x).blur();
		}

		function BuscarProducto(x)
        {

				//Obtenemos el value del input
		        var Precio = document.getElementsByName('PrecioReal[]');
		        var Producto = document.getElementsByName('Producto[]'); 
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
			                    x.value = $(this).attr('data');
			                    Precio[Indice].value = $(this).attr('dataPrecio');
			                    Producto[Indice].value = $(this).attr('id'); 
			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#suggestions').fadeOut(500);
			                    $('#ModalSugerencias').modal('hide');
			                    CalcularTotal(); 
			                });
			            }
		            }
		        });
			}
		 
		 
		function AgregarLinea()
		{
			$("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
		}
		function AddLine()
		{
			$("#TablaSabores tr:eq(0)").clone().removeClass('fila-base1').appendTo("#TablaSabores");
		}
		function EliminarLinea(x)
		{
			var Indice = $(x).closest('tr').index();
			var parent = $(x).parents().get(1);
                $(parent).remove();
                Calcular();
            DelSabor(Indice);
		}
		 
		 
	 
		function AbrirModalResultados(x)
		{
			$('#ModalPrincipal').modal('hide');

			$.ajax({
				url: 'ObtenerProductos.php',
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
			$('#ModalResultados').modal('show');
		}
		function AgregarProducto(x)
		{	
			var ProductoNombre = document.getElementsByName('ProductoNombre[]');
			var Producto = document.getElementsByName('Producto[]');
			var Precio = document.getElementsByName('PrecioReal[]');
			var Indice = $('#ROWControl').val();
			Producto[Indice].value = $(x).attr('dataProducto');
			ProductoNombre[Indice].value = $(x).attr('dataNombre');
			Precio[Indice].value = $(x).attr('dataPrecio');
			$('#ModalPrincipal').modal('hide');
			Calcular();
		}
		 
		function Calcular()
		{
			var Validar = $('#Validar').prop('checked');
            if(Validar == true){
                CalcularTotalPor();
            }else{
                 CalcularTotal();
            }
		}

		function CalcularTotal()
		{
			var PrecioReal =  document.getElementsByName('PrecioReal[]');
			var Porcentaje =  document.getElementsByName('Porcentaje[]');
			var PrecioCombo = document.getElementsByName('PrecioCombo[]');
			var Descuento =   document.getElementsByName('Descuento[]'); 
			var PrecioTotal = $('#PrecioTotal').val(); 
			var TotalT = 0;
			var Total = 0;
			var TotalP = 0;
			var TotalD = 0;
			var Porcen = 0;
			var Valor = 0;
			var Desc = 0;
			for(i = 1; i < PrecioReal.length; i++)
			{  
				TotalT = TotalT + parseFloat(PrecioReal[i].value);
			}  
			$('#BoldTotalT').val(TotalT.toFixed(2));
			var Tot = $('#BoldTotalT').val();
			for(i = 1; i < PrecioReal.length; i++)
			{   
				Porcen = (parseFloat(PrecioReal[i].value)/parseFloat(Tot))*100; 
				Porcentaje[i].value = Porcen.toFixed(2);
				Valor = (parseFloat(PrecioReal[i].value)/parseFloat(Tot))*parseFloat(PrecioTotal);
				PrecioCombo[i].value = Valor.toFixed(2);
				Desc = parseFloat(PrecioReal[i].value)-parseFloat(PrecioCombo[i].value); 
				Descuento[i].value = Desc.toFixed(2);
				Total = Total + Porcen;
				TotalP = TotalP + Valor;
				TotalD = TotalD + Desc; 
			}  
			
			$('#BoldTotal').val(Total.toFixed(2));
			$('#BoldTotalP').val(TotalP.toFixed(2));
			$('#BoldTotalD').val(TotalD.toFixed(2));
		}

		function CalcularTotalPor()
		{
			var PrecioReal =  document.getElementsByName('PrecioReal[]');
			var Porcentaje =  document.getElementsByName('Porcentaje[]');
			var PrecioCombo = document.getElementsByName('PrecioCombo[]');
			var Descuento =   document.getElementsByName('Descuento[]'); 
			var PrecioTotal = $('#PrecioTotal').val(); 
			var TotalT = 0;
			var Total = 0;
			var TotalP = 0;
			var TotalD = 0;
			var Porcen = 0;
			var Valor = 0;
			var Desc = 0;
			for(i = 1; i < PrecioReal.length; i++)
			{  
				TotalT = TotalT + parseFloat(PrecioReal[i].value);
			}  
			$('#BoldTotalT').val(TotalT.toFixed(2));
			var Tot = $('#BoldTotalT').val();
			var Diferencia = parseFloat(Tot) - parseFloat(PrecioTotal);
			for(i = 1; i < PrecioReal.length; i++)
			{   
				Desc = parseFloat(Porcentaje[i].value/100)*parseFloat(Diferencia);
				Descuento[i].value = Desc.toFixed(2);
				Valor = parseFloat(PrecioReal[i].value)-parseFloat(Descuento[i].value);
				PrecioCombo[i].value = Valor.toFixed(2);
				Total = Total + parseFloat(Porcentaje[i].value);
				TotalP = TotalP + Valor;
				TotalD = TotalD + Desc; 
			}  
			
			$('#BoldTotal').val(Total.toFixed(2));
			$('#BoldTotalP').val(TotalP.toFixed(2));
			$('#BoldTotalD').val(TotalD.toFixed(2));

			if (parseFloat($('#BoldTotal').val())==100) 
			{  
		         $("#enviar"). attr("disabled", false);
			}
			else
			{ 
				 $("#enviar"). attr("disabled", true);
			} 
		}  
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?> 
	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
				<section>
					<div class="section-header">
						<ol class="breadcrumb">
							<li class="active"></li>
						</ol>
					</div>
					<div class="section-body contain-lg">
						<!-- BEGIN VALIDATION FORM WIZARD -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body ">
										<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
											<form class="form form-validation" role="form" novalidate="novalidate" action="ComboAddPro.php" method="POST" role="form" id="FormularioPrincipal"> 
												<div class="tab-content clearfix">
													<div class="tab-pane active" id="step1">
														<div class="row">
															<div class="col-lg-3">
																<div class="form-group">
																	<input class="form-control" type="text" name="Nombre" id="Nombre"  autofocus required/>
																	<label for="Nombre">Nombre</label> 
																</div> 
															</div>
															<div class="col-lg-3">
																<div class="form-group">
																	<input class="form-control" type="number" step="any" name="PrecioTotal" id="PrecioTotal" onchange="Calcular()"  required/>
																	<label for="PrecioTotal">Precio Total</label>
																</div>
															</div>
															<div class="col-lg-3">
																 	<label for="Validar">Cálculo Porcentaje
																 		<input class="form-control" type="checkbox" step="any" name="Validar" id="Validar"   required/>
																 	</label> 
															</div>
														</div>  
														<br><br>  
														<div class="row">
															<table class="table" name="tabla" id="tabla">
																<thead>
																	<tr>
																		<th>Juego</th> 
																		<th>Precio Producto</th>
																		<th>%</th>
																		<th>Precio Combo</th>
																		<th>Descuento</th>
																	</tr>
																</thead>
																<tbody>
																	<tr class="fila-base">
																		<td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onclick="AbrirModalPrincipal(this)"></h6></td>
																		 <input type="hidden" class="form-control" name="Producto[]" id="Producto[]"> 
						                                                <td><h6><input readonly type="number" class="form-control" name="PrecioReal[]" id="PrecioReal[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="Porcentaje[]" id="Porcentaje[]"   style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" onchange="Calcular()"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="PrecioCombo[]" id="PrecioCombo[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="Descuento[]" id="Descuento[]" onChange="CalcularTotal()" style="width: 100px" min="0"></h6></td>
						                                                <td class="eliminar">
						                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
						                                                        <span class="glyphicon glyphicon-trash"></span>
						                                                    </button>
						                                                </td>
						                                            </tr>
						                                            <tr>
						                                            	<td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onclick="AbrirModalPrincipal(this)"></h6></td>
						                                            	 <input type="hidden" class="form-control" name="Producto[]" id="Producto[]"> 
						                                                <td><h6><input type="number" class="form-control" name="PrecioReal[]" id="PrecioReal[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="Porcentaje[]" id="Porcentaje[]"   style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" onchange="Calcular()"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="PrecioCombo[]" id="PrecioCombo[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="Descuento[]" id="Descuento[]" onChange="CalcularTotal()" style="width: 100px" min="0"></h6></td>
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
						                                                <td>Total</td>
						                                                <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="BoldTotalT" name="BoldTotalT" value="0.00" readonly></td> 
						                                                <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="BoldTotal" name="BoldTotal" value="0.00" readonly></td>
						                                                <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="BoldTotalP" name="BoldTotalP" value="0.00" readonly></td> 
						                                                <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="BoldTotalD" name="BoldTotalD" value="0.00" readonly></td>
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
														<input type="hidden" id="ROWControl" />
													</div> 
													<br><br>
													<div class="col-lg-12" align="center">
				                                        <button type="submit" class="btn btn-success btn-md" id="enviar" >
				                                         GUARDAR
				                                        </button>
				                                    </div>
											</form>
										</div><!--end #rootwizard -->
									</div><!--end .card-body -->
								</div><!--end .card -->
							</div><!--end .col -->
						</div><!--end .row -->

					</div><!--end .section-body -->
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>


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
	<script src="../../../../../js/core/demo/DemoFormWizard.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/additional-methods.min.js"></script>
	<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>

	<script src="../../../../../libs/alertify/js/alertify.js"></script>

	<!-- END JAVASCRIPT -->

 <div id="ModalPrincipal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 80%">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
					<?php

						
						$consulta = "SELECT * FROM Bodega.PRODUCTO WHERE  CP_CODIGO = 'JG' ORDER BY P_NOMBRE";
					    $result = mysqli_query($db, $consulta);
						while($row = mysqli_fetch_array($result))
						{
							?>
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-12 text-center">
											<a style="text-decoration: none; cursor: pointer" onclick="AgregarProducto(this)" dataProducto="<?php echo $row["P_CODIGO"]; ?>" dataNombre="<?php echo $row["P_NOMBRE"]; ?>" dataPrecio="<?php echo $row["P_PRECIO"]; ?>"><div><?php echo $row["P_NOMBRE"] ?></div></a>
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
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign" ></span> Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Detalle Pasivo Contingente -->
	<div id="ModalResultados" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 80%">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" id="Resultados">
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning btn-md" onclick="RegresarAPrincipal()">
					<span class="glyphicon glyphicon-arrow-left" ></span> Principal
					</button>
					<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign" ></span> Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Detalle Pasivo Contingente -->

	<!-- Modal Detalle Pasivo Contingente -->
	<div id="ModalDescuentos" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 50%">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
					<?php

						//Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
					$query = "SELECT * FROM Bodega.DESCUENTO WHERE D_TIPO = 1 ORDER BY D_NOMBRE";
					$result = mysqli_query($db, $query);
					while($row = mysqli_fetch_array($result))
					{
						?>
						<div class="col-lg-3 col-md-6">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-12 text-center">
											<a style="text-decoration: none; cursor: pointer" dataNombre="<?php echo $row["D_NOMBRE"] ?>" dataDescuento="<?php echo $row["D_PORCENTAJE"] ?>" dataCodigoDesc="<?php echo $row["D_CODIGO"] ?>" onClick="AgregarDescuentoData(this)"><div><?php echo $row["D_NOMBRE"] ?></div></a>
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
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">
						<span class="glyphicon glyphicon-remove-sign" ></span> Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Detalle Pasivo Contingente -->

	 
	<!-- /Modal Detalle Pasivo Contingente -->

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
	
</body>
</html>
