<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$estados = [
    "Pedido recibido",
    "Procesando",
    "Enviado",
    "En tránsito",
    "Entregado"
];
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
	<script src="../../../../../js/libs/bootstrap-select/bootstrap-select.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../js/libs/bootstrap-select/bootstrap-select.min.css"/>	
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
	function CancelarRequisicion()
	{
		$('#ModalSugerencias').modal('show');
	}
	function CancelacionFun()
	{
		//alert('llega');
		var CancelacionVar = $('#Cancelacion1').val();
		var CodigoRequisicion = $('#CodigoRequisicion').val();
		//Le pasamos el valor del input al ajax
		
		$.ajax({
			type: "POST",
			url: "CancelacionRequisicion.php",
			data:"Motivo="+CancelacionVar+"&Codigo="+CodigoRequisicion,

			success: function(data) {
				alertify.error('La requisición fue cancelada con éxito');
				$('#ModalSugerencias').modal('hide');
				$('#btnCancelar').prop('disabled', 'true');

			},
			error: function(data)
			{
				alertify.error('No se pudo cancelar la requisición');
			}
		});
	}
	</script>

<script>
        $(document).ready(function () {
            $("#Clasificacion").change(function () {
                let valor = parseInt($(this).val());
                let docContainer = $("#documentos-container");
                docContainer.empty();
                
                if (valor === 2) {
                    docContainer.append('<input type="file" name="documento1" class="form-control" />');
                } else if (valor === 3) {
                    docContainer.append('<input type="file" name="documento1" class="form-control" />');
                    docContainer.append('<input type="file" name="documento2" class="form-control" />');
                } else if (valor === 4) {
                    docContainer.append('<input type="file" name="documento1" class="form-control" />');
                    docContainer.append('<input type="file" name="documento2" class="form-control" />');
                    docContainer.append('<input type="file" name="documento3" class="form-control" />');
                }
            });
        });
    </script>

<script>
	function EditarDocumento(x)
    	{
    		var ModalAbierto=x.value;
    		$('#ModalCambiar-'+x).modal('show');

    	}


		function GuardarEditado(x)
		{
			var formulario = document.getElementById("FormularioDocumento-"+x);
			formulario.submit();
			return true;
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php
	$Numero = $_GET["Numero"];

	$Query = "SELECT REQUISICION.*, REQUISICION_DETALLE.* 
				FROM CompraVenta.REQUISICION, CompraVenta.REQUISICION_DETALLE 
				WHERE REQUISICION.R_CODIGO = REQUISICION_DETALLE.R_CODIGO
				AND REQUISICION.R_CODIGO = ".$Numero;
	$Result = mysqli_query($db, $Query);
	while($Fila = mysqli_fetch_array($Result))
	{
		$FechaRequisicion = $Fila["R_FECHA"];
		$FechaNecesidad = $Fila["R_FECHA_NECESIDAD"];
		$ColaboradorSolicita = $Fila["R_COLABORADOR"];
		
		$Observaciones = $Fila["R_OBSERVACIONES"];
		$Estado = $Fila["R_ESTADO"];

		if($Estado == 1)
		{
			$Text = "Solicitado";
		}
		elseif($Estado == 2)
		{
			$Text = "Cotizando";
		}elseif($Estado == 3)
		{
			$Text = "Pendiente de Confirmar Cotización";
		}elseif($Estado == 4)
		{
			$Text = "Cotización Confirmada";
		}elseif($Estado == 5)
		{
			$Text = "Pendiente Confirmación Director Ejecutivo";
		}elseif($Estado == 6)
		{
			$Text = "Peido";
		}elseif($Estado == 7)
		{
			$Text = "Recibido";
		}elseif($Estado == 8)
		{
			$Text = "Pendiente de Factura";
		}elseif($Estado == 9)
		{
			$Text = "Pendiente de Pagar";
		}elseif($Estado == 10)
		{
			$Text = "Pagado";
		}elseif($Estado == 11)
		{
			$Text = "Cancelado";
		}
		$Codigo = $Fila["R_CODIGO"];
		$Solicito = $Fila["U_CODIGO"];
		$CodigoEstado = $Fila["R_ESTADO"];
		$MotivoCancelacion = $Fila["R_MOTIVO_CANCELACION"];
	}
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form action="RRConsComPro.php" id="FormularioEnviar" method="POST" class="form" enctype="multipart/form-data">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Consulta Requisición de Compra</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="NombreEstado" id="NombreEstado" required value="<?php echo $_GET["Numero"]; ?>" readonly/>
											<label for="NombreEstado">No. Requisición</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="NombreEstado" id="NombreEstado" value="<?php echo $Text; ?>" required readonly />
											<label for="NombreEstado">Estado de la Requisición</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="hidden" name="Numero" id="Numero" value="<?php echo $Numero; ?>" >
											<input class="form-control" type="hidden" name="CodigoRequisicion" id="CodigoRequisicion" value="<?php echo $Codigo; ?>" >
											<input class="form-control" type="date" name="FechaRequisicion" id="FechaRequisicion" value="<?php echo date('Y-m-d', strtotime($FechaRequisicion)); ?>" readonly required/>
											<label for="FechaRequisicion">Fecha de Requisicón</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											
												<?php
													$Query = "SELECT cif FROM info_colaboradores.datos_laborales WHERE estado = 1 AND cif = $Solicito ORDER BY cif";
													$Result = mysqli_query($db, $Query);
													while($row = mysqli_fetch_array($Result))
													{
														if($row["cif"] == $Solicito)
														{
															$Texto = 'selected';
														}
														else
														{
															$Texto = '';
														}
														$Nombre = saber_nombre_colaborador($row["cif"]);
													}
												?>

												<input class="form-control" type="text" name="Solicito" id="Solicito" required value="<?php echo $Nombre; ?>" readonly/>
										
											<label for="ColaboradorSolicita">Colaborador que solicita</label>
										</div>
									</div>	
								</div>
								
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="text" name="Concepto" id="Concepto" value="<?php echo $Observaciones; ?>" required <?php echo $Text; ?>/>
											<label for="Concepto">Observaciones</label>
										</div>
									</div>	
								</div>
								<?php
								if($CodigoEstado == 11)
								{
									?>
									<div class="row">
										<div class="col-lg-10">
											<div class="form-group">
												<input class="form-control" maxlength="255" type="text" name="MotivoCancelacion" id="MotivoCancelacion" value="<?php echo $MotivoCancelacion; ?>" required/>
												<label for="MotivoCancelacion">Motivo de Cancelación</label>
											</div>
										</div>	
									</div>
										
									<?php
								}
								if($CodigoEstado == 9 | $CodigoEstado == 10)
								{
									$QueryFacturaCompra = "SELECT REQUISICION.*, REQUISICION.R_PROVEEDOR, PROVEEDOR.P_NOMBRE 
															FROM CompraVenta.REQUISICION, CompraVenta.REQUISICION_DETALLE 
															WHERE REQUISICION.R_PROVEEDOR = PROVEEDOR.P_CODIGO
															AND REQUISICION.R_NUMERO = ".$_GET["Numero"];
									$ResultFacturaCompra = mysqli_query($db, $QueryFacturaCompra);
									$FilaFacturaCompra = mysqli_fetch_array($ResultFacturaCompra);

									if($FilaFacturaCompra["R_FACTURA_COMPRA"] != '')
									{
										?>
										<div class="row">
											<div class="col-lg-8">
												<div class="form-group">
													<input class="form-control" maxlength="255" type="text" name="MotivoCancelacion" id="MotivoCancelacion" value="<?php echo $FilaFacturaCompra['R_FACTURA_COMPRA'].' de '.$FilaFacturaCompra["P_NOMBRE"]; ?>" required/>
													<label for="MotivoCancelacion">Factura de Compra</label>
												</div>
											</div>	
										</div>
										<?php
									}
								}
								?>
								<div class="row">
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <td><strong>Cantidad</strong></td>
                                                <td><strong>Descripción</strong></td>
                                                <td><strong>Clasificación</strong></td>
                                                <td><strong>Observaciones</strong></td>
                                                <td><strong>Cambiar Estado</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                            <?php 
											$i=1;
											$QueryDetalle = "SELECT * FROM CompraVenta.REQUISICION_DETALLE WHERE R_CODIGO = '".$Numero."'";
											$ResultDetalle = mysqli_query($db, $QueryDetalle);
                                            
                                            	
                                            	while($row = mysqli_fetch_array($ResultDetalle))
                                            	{
													$Clasificacion = $row["RD_CLASIFICACION"];
													$RDCodigo = $row["RD_CODIGO"];
													
                                            		?>
													
													<tr>
		                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="Cantidad[]" id="Cantidad[]" style="width: 100px" value="<?php echo $row['RD_CANTIDAD'] ?>" min="0"></h6></td>
		                                                <td><input align="right" type="text" class="form-control" name="Descripcion[]" id="Descripcion[]" value="<?php echo $row['RD_PRODUCTO'] ?>" readonly ></td>
														<td><h6><select name="Clasificacion" id="Clasificacion[]" class="form-control" style="width: 150px" required>
																		<option value="1" <?php if($Clasificacion==1){echo "selected"; }?>>0.1 - 1,000.00</option>
																		<option value="2" <?php if($Clasificacion==2){echo "selected"; }?>>1,001.00 - 5,000.00</option>
																		<option value="3" <?php if($Clasificacion==3){echo "selected"; }?>>5,001 - 10,000</option>
																		<option value="4" <?php if($Clasificacion==4){echo "selected"; }?>>10,001 - ∞</option>
																		<option value="5" <?php if($Clasificacion==5){echo "selected"; }?>>Proveedores Recurrentes</option>
																		<option value="6" <?php if($Clasificacion==6){echo "selected"; }?>>Compra de Emergencia (ya resuelto)</option>
																		</select>
																		<div id="documentos-container">
	
																		</div>
																		</h6></td>
																	<td style="font-size: 24px"><button type="button" class="btn btn-warning"  value="<?php echo $RDCodigo; ?>" onclick="EditarDocumento(this.value)">
																		<span class="fa fa-pencil"></span>
																	</button>
																	</td>
		                                            </tr>


													

													<!-- Modal Editar -->
													<div id="ModalCambiar-<?php echo $RDCodigo; ?>" class="modal fade" role="dialog">
																		
																		<div class="modal-dialog">
																		
																		<div class="card">
																		<div class="card-body">
																			
																		<input type="hidden" name="CodigoRe" id="CodigoRe" value="<?php echo $Numero ?>">
																			<!-- Modal content-->
																			<div class="modal-content">
																			<div class="card-head style-primary">
																							<h2 class="text-center"> Datos Laborales </h2>
																						</div>
																				<div class="modal-body">
																				<form class="form" id="FormularioDocumento-<?php echo $RDCodigo; ?>" action="RRConsComPro.php" method="POST" enctype="multipart/form-data">
																					<div id="suggestions" class="text-center"></div>
																					<input type="hidden" name="CodigoRe" id="CodigoRe" value="<?php echo $Numero ?>">
																					<div class="col-lg-8">
																									<div class="form-group floating-label">
																									<label for="TipoDocumento">Tipo de Documento</label>
																									<input class="form-control" type="text" name="TipoDocumento" id="TipoDocumento" value="<?php echo $NombreDoc ?>" readonly>
																									</div>
																								</div>
																								<div class="col-lg-8">
																								</div>
																								<?php 
																		if($Clasificacion==2){
																		?>
																		<div >
																							<input type="file" name="documento1<?php echo $i ?>" id="documento1<?php echo $i ?>">
																							
																							<label for="documento" 
																							style="background: #1F5F74;
																									color: white;
																									padding: 6px 20px;
																									cursor: pointer;
																									margin: 5 5;
																									text-align: center;
																									border-radius: 3px;">Cotización #1</label>
																						</div>
																						<?php 
																							}
																					
																		elseif($Clasificacion==3){
																		?>
																		<div >
																							<input type="file" name="documento1<?php echo $i ?>" id="documento1<?php echo $i ?>">
																							
																							<label for="documento" 
																							style="background: #1F5F74;
																									color: white;
																									padding: 6px 20px;
																									cursor: pointer;
																									margin: 5 5;
																									text-align: center;
																									border-radius: 3px;">Cotización #1</label>
																						</div>

																						<div >
																							<input type="file" name="documento2<?php echo $i ?>" id="documento2<?php echo $i ?>">
																							
																							<label for="documento" 
																							style="background: #1F5F74;
																									color: white;
																									padding: 6px 20px;
																									cursor: pointer;
																									margin: 5 5;
																									text-align: center;
																									border-radius: 3px;">Cotización #2</label>
																						</div>
																						<?php 
																							}
																					
																		elseif($Clasificacion==4){
																		?>
																		<div >
																							<input type="file" name="documento1<?php echo $i ?>" id="documento1<?php echo $i ?>">
																							
																							<label for="documento" 
																							style="background: #1F5F74;
																									color: white;
																									padding: 6px 20px;
																									cursor: pointer;
																									margin: 5 5;
																									text-align: center;
																									border-radius: 3px;">Cotización #1</label>
																						</div>

																						<div >
																							<input type="file" name="documento2<?php echo $i ?>" id="documento2<?php echo $i ?>">
																							
																							<label for="documento" 
																							style="background: #1F5F74;
																									color: white;
																									padding: 6px 20px;
																									cursor: pointer;
																									margin: 5 5;
																									text-align: center;
																									border-radius: 3px;">Cotización #2</label>
																						</div>

																						<div >
																							<input type="file" name="documento3<?php echo $i ?>" id="documento3<?php echo $i ?>">
																							
																							<label for="documento" 
																							style="background: #1F5F74;
																									color: white;
																									padding: 6px 20px;
																									cursor: pointer;
																									margin: 5 5;
																									text-align: center;
																									border-radius: 3px;">Cotización #3</label>
																						</div>
																						<?php 
																						
																							}
																						?>
																				</form>

																						<div class="modal-footer">
																					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
																					<button type="button" class="btn btn-success" value="<?php echo $RDCodigo; ?>" onclick="GuardarEditado(this.value)">Guardar</button>
																				</div>
																				</div>
																			</div>
																			</div>
																		</div>
																		
																	</div>

																	</div>
																	<!-- /Modal Detalle Pasivo Contingente -->
																			
																	
                                            		<?php
													$i++;

													
                                            	}
                                            
                                            

                                            ?>
                                            
                                        </tbody>
                                    </table>
                                  
								</div><!-- AQUIIIIIII -->
																			
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
		|
		<?php include("../MenuUsers.html"); ?>

		<!-- Modal Detalle Pasivo Contingente -->
		<form class="form" role="form">
        <div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Cancelación de Requisición</h2>
                    </div>
                    <div class="modal-body">
                    	<div class="row">
                    		<div class="col-lg-10">
                    			<div class="form-group">
                    				<input class="form-control" maxlength="255" type="text" name="Cancelacion1" id="Cancelacion1" />
                    				<label for="Cancelacion1">¿Por qué desea cancelar la requisición?</label>
                    			</div>
                    		</div>	
                    	</div>
                    </div>
                    <div class="modal-footer">
                    	<div class="row">
                    		<div class="col-lg-6" align="center">
								<button type="button" class="btn ink-reaction btn-raised btn-danger" data-dismiss="modal" id="btnGuardar">Cerrar</button>
							</div>
							<div class="col-lg-6" align="center">
								<button type="button" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" onclick="CancelacionFun()">Cancelar Requisición</button>
							</div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <!-- /Modal Detalle Pasivo Contingente -->

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
