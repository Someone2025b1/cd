<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$estados = [
    "Pedido recibido",
    "Cotizando",
    "Pendiente de Confirmar Cotización",
    "Cotización Confirmada",
    "Confirmación de Director Ejecutivo ",
	"Pedido",
	"Recibido",
	"Pendiente de Factura",
	"Pendiente de Pagar",
	"Pagado"
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
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

	<style>
      
        #estado-envio-container {
            width: 100%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: white;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .timeline {
            display: flex;
            justify-content: space-between;

            list-style: none;
            padding: 10px;
            width: 100%;
        }

		.timeline:before {
    top: none;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 0px;
    background-color: #0c0c0c;
    opacity: 0.15;
    left: 0;
    margin-left: -2px;
}
        .step {
            position: relative;
            margin: 5px 0;
            padding: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }
        .circle {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block;
            background: <?php echo $is_cancelled ? 'red' : '#ccc'; ?>;
        }
        .completed .circle {
            background: green;
        }
        .cancelled .circle {
            background: red;
        }
        .line {
            position: absolute;
     
            left: 0;
            width: 100%;
            height: 5px;
            background: <?php echo $is_cancelled ? 'red' : '#ccc'; ?>;
            z-index: -1;
        }
    </style>

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
	function EditarDocumento(x)
    	{
    		var ModalAbierto=x.value;
    		$('#ModalCambiar-'+x).modal('show');

    	}

		function VerDocumento(x)
    	{
    		var ModalAbierto=x.value;
    		$('#ModalVer-'+x).modal('show');

    	}


		function GuardarEditado(x)
		{
			var formulario = document.getElementById("FormularioDocumento-"+x);
			formulario.submit();
			return true;
		}
	</script>

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

		function actualizarSeleccion(checkbox) {
			let codigo = checkbox.getAttribute("data-codigo");
			let seleccionada = checkbox.checked ? 1 : 0;

			let formData = new FormData();
			formData.append("codigo", codigo);
			formData.append("seleccionada", seleccionada);

			fetch("actualizar.php", {
				method: "POST",
				body: formData
			})
			.then(response => response.text())
			.then(data => {
				console.log(data); // Verifica la respuesta del servidor
			})
			.catch(error => console.error("Error:", error));
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
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Mis Requisiciones</strong></h4>
						</div>
						<div class="card-body">
							<div class="col-lg-12">
								<?php
									if($_POST["TipoBusqueda"] == 1)
									{
										$Query = "SELECT REQUISICION.*
													FROM CompraVenta.REQUISICION
													WHERE REQUISICION.R_FECHA BETWEEN '".$_POST["FechaIni"]."' AND '".$_POST["FechaFin"]."' 
													AND REQUISICION.U_CODIGO = ".$id_user."
													ORDER BY REQUISICION.R_CODIGO";
									}
									else
									{
										$Query = "SELECT REQUISICION.*, AREA_GASTO.AG_NOMBRE, REQUISICION_ESTADO.RE_NOMBRE 
													FROM Contabilidad.REQUISICION, Contabilidad.AREA_GASTO, Contabilidad.REQUISICION_ESTADO
													WHERE REQUISICION.AG_CODIGO = AREA_GASTO.AG_CODIGO
													AND REQUISICION.RE_CODIGO = REQUISICION_ESTADO.RE_CODIGO
													AND REQUISICION.R_NUMERO = ".$_POST["Requisicion"]." 
													AND REQUISICION.R_COLABORADOR = ".$id_user."
													ORDER BY REQUISICION.R_NUMERO";
									}

									$Result = mysqli_query($db, $Query);
									$Numero1 = mysqli_num_rows($Result);

									if($Numero1 > 0)
									{
										?>
										<table class="table table-hover table-condensed">
											<thead>
												<tr>
													<th><h6><strong>#</strong></h6></th>
													<th><h6><strong>Fecha</strong></h6></th>
													<th><h6><strong>Cant</strong></h6></th>
													<th><h6><strong>Producto/Servicio</strong></h6></th>
													<th><h6><strong>Cotizaciones</strong></h6></th>
													<th><h6><strong>Observaciones</strong></h6></th>
													<th><h6><strong>Estado</strong></h6></th>
												</tr>
											</thead>
											<tbody>
										<?php
										while($Fila = mysqli_fetch_array($Result))
										{
											$Numero=$Fila["R_CODIGO"];
											$FechaRequisicion = $Fila["R_FECHA"];
											$HoraPidio = $Fila["R_HORA"];
											$Solicito = $Fila["U_CODIGO"];
											

											$QueryUsu = "SELECT cif FROM info_colaboradores.datos_laborales WHERE estado = 1 AND cif = $Solicito ORDER BY cif";
											$ResultUsu = mysqli_query($db, $QueryUsu);
											while($rowUsu = mysqli_fetch_array($ResultUsu))
											{
												
												$NombreSolito = saber_nombre_colaborador($rowUsu["cif"]);
											}
											
											$Observaciones = $Fila["R_OBSERVACIONES"];
											$Estado = $Fila["R_ESTADO"];
																				?>
											<div class="row">
									
                                           
                                            <?php 
											$i=1;
											$QueryDetalle = "SELECT * FROM CompraVenta.REQUISICION_DETALLE WHERE R_CODIGO = '".$Numero."'";
											$ResultDetalle = mysqli_query($db, $QueryDetalle);
                                            
                                            	
                                            	while($row = mysqli_fetch_array($ResultDetalle))
                                            	{
													$Clasificacion = $row["RD_CLASIFICACION"];
													$RDCodigo = $row["RD_CODIGO"];
													$Estado = $row["RD_ESTADO"];

													if($Estado == 1)
													{
														$Text = "Pedido recibido";
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
														$Text = "Confirmación de Director Ejecutivo ";
													}elseif($Estado == 6)
													{
														$Text = "Pedido";
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

													
													if($Clasificacion==1){
														
														$CantCo=0;
													}elseif($Clasificacion==2){
														
														$CantCo=1;
													}elseif($Clasificacion==3){
														
														$CantCo=2;
													}elseif($Clasificacion==4){
														
														$CantCo=3;
													}elseif($Clasificacion==5){
														
														$CantCo=0;
													}elseif($Clasificacion==6){
														
														$CantCo=0;
													}

													$Cantidad = number_format( $row['RD_CANTIDAD'], 0, '.', ',');
													
                                            		?>
													
													<tr>
													<td><h6><?php echo $row['R_CODIGO'] ?></td>
													<td><h6><?php echo  date('d-m-Y', strtotime($row['RD_FECHA_NECESIDAD'])) ?></h6></td>
													<td align="center"><h6><?php echo $Cantidad ?></h6></td>
		                                                <td><h6> <?php echo $row['RD_PRODUCTO'] ?> </h6></td>
														<td align="center"><?php echo $CantCo ?></td>
														<td><?php echo $row['RD_OBSERVACION'] ?></td>
														<td style="font-size: 24px"><button type="button" class="btn"  value="<?php echo $RDCodigo; ?>" onclick="EditarDocumento(this.value)">
															<span class="fa fa-eye"></span>
														</button>
														</td>
		                                            </tr>


													

													<!-- Modal Editar -->
													<div id="ModalCambiar-<?php echo $RDCodigo; ?>"class="modal fade" role="dialog" style="width: 100%">
																		
																		<div class="modal-dialog" style="width: 90%">
																		
																		<div class="card">
																		<div class="card-body">
																			
																		<input type="hidden" name="CodigoRe" id="CodigoRe" value="<?php echo $Numero ?>">
																		<input type="hidden" name="CodigoReDetalle" id="CodigoReDetalle" value="<?php echo $RDCodigo ?>">
																		<input type="hidden" name="RDEstado" id="RDEstado" value="<?php echo $Estado ?>">
																		<input type="hidden" name="ClasificiacionRD" id="ClasificiacionRD" value="<?php echo $Clasificacion ?>">
																			<!-- Modal content-->
																			<div class="modal-content">
																			<div class="card-head style-primary">
																							<h2 class="text-center"> Datos Del Producto </h2>
																						</div>

																						<div class="card-body">
								<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-1">
										<div class="form-group">
										<label for="NombreEstado">No. Requisición</label>
											<input class="form-control" type="text" name="NombreEstado" id="NombreEstado" required value="<?php echo $Numero; ?>" readonly/>
											
										</div>
									</div>	
								
									<div class="col-lg-2">

										<div class="form-group">
										<label for="NombreEstado">Estado</label>
											<input class="form-control" type="text" name="NombreEstado" id="NombreEstado" value="<?php echo $Text; ?>" required readonly />
											
										</div>
									</div>	
								
									<div class="col-lg-1">
										<div class="form-group">
										<label for="FechaRequisicion">Fecha de Requisicón</label>
											<input class="form-control" type="date" name="FechaRequisicion" id="FechaRequisicion" value="<?php echo date('Y-m-d', strtotime($FechaRequisicion)); ?>" readonly required/>
											
										</div>
									</div>	
									<div class="col-lg-1">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Hora que se Pidio</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $HoraPidio ?>" readonly/>
											
										</div>
										</div>
									<div class="col-lg-2">
										<div class="form-group">
										<label for="FechaRequisicion">Fecha de Necesidad</label>
											<input class="form-control" type="date" name="FechaRequisicion" id="FechaRequisicion" value="<?php echo date('Y-m-d', strtotime($row['RD_FECHA_NECESIDAD'])); ?>" readonly required/>
											
										</div>
												</div>
									
										<div class="col-lg-5">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Solicitó</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $NombreSolito ?>" readonly/>
											
										</div>
										</div>

										<div class="col-lg-1">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Cantidad</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $Cantidad ?>" readonly/>
											
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Producto/Servicio</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $row['RD_PRODUCTO'] ?>" readonly/>
											
										</div>
										</div>
										<div class="col-lg-7">
                                        <label for="Descripcion">Descripción</label>
										<textarea class="form-control" name="Nombre" id="Nombre" rows="2" cols="40" disabled="disabled"><?php echo $row['RD_OBSERVACION']?></textarea>
											
											</div>
									</div>	
								</div>
<div id="estado-envio-container">
<h4 style="text-align: center;">Seguimiento de Envío</h4>
   

	<ul class="timeline">
            <?php 

			// Estado actual (cámbialo dinámicamente según la lógica de tu aplicación)
		$estado_actual = $Text; // Cambia esto según el estado actual
		$estado_cancelado = "Cancelado";
		$is_cancelled = ($estado_actual == $estado_cancelado);
		
		if ($is_cancelled) {
			$estados[] = $estado_cancelado;
		}
		foreach ($estados as $estado): ?>
                <li class="step <?php echo $is_cancelled ? 'cancelled' : (($estado == $estado_actual || array_search($estado, $estados) < array_search($estado_actual, $estados)) ? 'completed' : ''); ?>">
                    <div class="circle"></div>
                    <span><?php echo $estado; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
	</div>

	
																				<div class="modal-body">
																				<form class="form" id="FormularioDocumento-<?php echo $RDCodigo; ?>" action="RRConsComPro.php" method="POST" enctype="multipart/form-data">
																				
																					<div id="suggestions" class="text-center"></div>
																					<input type="hidden" name="CodigoRe" id="CodigoRe" value="<?php echo $Numero ?>">
																					<input type="hidden" name="CodigoReDetalle" id="CodigoReDetalle" value="<?php echo $RDCodigo ?>">
																					<input type="hidden" name="RDEstado" id="RDEstado" value="<?php echo $Estado ?>">
																					<input type="hidden" name="valori" id="valori" value="<?php echo $i ?>">
																					
																					
																								<div class="col-lg-8">
																								</div>
																								<?php 


																		if($Clasificacion==0){
																			?>
																			<div class="col-lg-4">
																			</div>
																			<div class="col-lg-4">
																		<label for="Clasificacion-<?php echo $RDCodigo; ?>">¿Cuantas Cotizaciones Tendra?</label>
																		<h6><select name="Clasificacion-<?php echo $RDCodigo; ?>" id="Clasificacion-<?php echo $RDCodigo; ?>" class="form-control" style="width: 150px" required>
																		<option value="" disabled selected>Seleccione una opción</option>
																		<option value="1">0</option>
																		<option value="2">1</option>
																		<option value="3">2</option>
																		<option value="4">3</option>
																		</select>
																		
																		</h6>
																			</div>

																			<?php
																		}
																		if($Estado==2){
																		if($Clasificacion==2){
																		?>
																		
																		<div class="col-lg-12">
																		
																		<div class="col-lg-3">
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

																		
																		<div class="col-lg-2">
																		<label for="MontoCoti1<?php echo $i ?>">Monto de la Cotización</label>
																		<h6><input align="right" type="text" step="any" class="form-control" name="MontoCoti1<?php echo $i ?>" id="MontoCoti1<?php echo $i ?>" style="width: 100px"  min="0" ></h6>
																						</div>
																						<div class="col-lg-7">
																		</div>
																		</div>
																						<?php 
																							}
																					
																		elseif($Clasificacion==3){
																		?>
																		<div class="col-lg-12">
																		
																		<div class="col-lg-3">
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

																		
																		<div class="col-lg-2">

																		<label for="MontoCoti1<?php echo $i ?>">Monto de la Cotización</label>
																		<h6><input align="right" type="text" step="any" class="form-control" name="MontoCoti1<?php echo $i ?>" id="MontoCoti1<?php echo $i ?>" style="width: 100px"  min="0" ></h6>
																						</div>
																						
																		
																		<div class="col-lg-7">
																		</div>
																		</div>
																		


																						<div class="col-lg-12">

																						<div class="col-lg-3">
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
																					<div class="col-lg-2">

																					<label for="MontoCoti2<?php echo $i ?>">Monto de la Cotización</label>
																					<h6><input align="right" type="text" step="any" class="form-control" name="MontoCoti2<?php echo $i ?>" id="MontoCoti2<?php echo $i ?>" style="width: 100px"  min="0" ></h6>
																						</div>
																						<div class="col-lg-7">
																		</div>

																		</div>
																						<?php 
																							}
																					
																		elseif($Clasificacion==4){
																		?>
																		<div class="col-lg-12">
																		
																		<div class="col-lg-3">
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

																																				
																		<div class="col-lg-2">

																		<label for="MontoCoti1<?php echo $i ?>">Monto de la Cotización</label>
																		<h6><input align="right" type="text" step="any" class="form-control" name="MontoCoti1<?php echo $i ?>" id="MontoCoti1<?php echo $i ?>" style="width: 100px"  min="0" ></h6>
																		</div>
																		<div class="col-lg-7">
																		</div>
																		</div>

																		<div class="col-lg-12">

																						<div class="col-lg-3">

																						
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
																						<div class="col-lg-2">

																						<label for="MontoCoti2<?php echo $i ?>">Monto de la Cotización</label>
																						<h6><input align="right" type="text" step="any" class="form-control" name="MontoCoti2<?php echo $i ?>" id="MontoCoti2<?php echo $i ?>" style="width: 100px"  min="0" ></h6>
																								</div>

																						<div class="col-lg-7">
																							</div>

																							</div>

																							<div class="col-lg-12">

																							<div class="col-lg-3">
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
																									<div class="col-lg-2">

																						<label for="MontoCoti3<?php echo $i ?>">Monto de la Cotización</label>
																						<h6><input align="right" type="text" step="any" class="form-control" name="MontoCoti3<?php echo $i ?>" id="MontoCoti3<?php echo $i ?>" style="width: 100px"  min="0" ></h6>
																						</div>
																						<div class="col-lg-7">
																		</div>

																		</div>

																		

																						<?php 
																						
																							}
																						}
																						if($Estado>2){

																							?>
																							
																							<div class="col-lg-12">
																						<div class="col-lg-1">
																						<h6>Codigo de Cotización</h6>
																						</div>
																						<div class="col-lg-4">
																						<h6>Monto</h6>
																						</div>
																						<div class="col-lg-1">
																						<div class="checkbox checkbox-styled">
																						<label>
																								
																							</label>
																							</div>
																						</div>
																						<div class="col-lg-1">
																						</div>
																						</div>
																						<?php

																							$QueryDetalleCotizacion = "SELECT * FROM CompraVenta.COTIZACION WHERE RD_CODIGO = '$RDCodigo'";
																							$ResultDetalleCotizacion = mysqli_query($db, $QueryDetalleCotizacion);
																							
																								
																								while($rowCot = mysqli_fetch_array($ResultDetalleCotizacion))
																								{

																									$CodigoDoc = $rowCot["C_CODIGO"];
																									$NombreDoc = $rowCot["C_NOMBRE"];
																									$Extencion = $rowCot["C_EXTENCION"];
																									
																														?>
																						<div class="row">								
																						<div class="col-lg-12">
																						<div class="col-lg-1">
																						<h6><input type="text" class="form-control" name="CodigoDoc" id="CodigoDoc"  style="width: 400px" min="0" value="<?php echo $CodigoDoc ?>" disabled="disabled"></h6>
																						</div>
																						<div class="col-lg-4">
																						<h6> <input type="text" class="form-control" name="NombreDoc" id="NombreDoc" readonly disabled="disabled" style="width: 400px" value="<?php echo $NombreDoc ?>"></h6>
																						</div>
																						<div class="col-lg-1">
																						<div class="checkbox checkbox-styled">
																						<label>
																								<input type="checkbox" name="Seleccionar-<?php echo $CodigoDoc; ?>" id="Seleccionar-<?php echo $CodigoDoc; ?>" data-codigo="<?php echo $CodigoDoc; ?>" onchange="actualizarSeleccion(this)" <?php if($id_user==$Solicito){}else{echo 'disabled="true"';} ?>>
																								<span>Seleccionar</span>
																							</label>
																							</div>
																						</div>
																						<div class="col-lg-1">
																						<button type="button" class="btn btn-info"  value="<?php echo $CodigoDoc; ?>" onclick="VerDocumento(this.value)">
																							<span class="fa fa-eye"></span>
																						</button> 
																						</div>
																						</div>
																						<br>
																						
																						</div>
																						
																						
																						
																			                                                
						                                                
																						<!-- Modal VER Cotización-->
																	 <!-- Modal Detalle Pasivo Contingente -->
																	 <div id="ModalVer-<?php echo $CodigoDoc; ?>" class="modal fade" role="dialog" style="width: 100%">
																		
																		<div class="modal-dialog" style="width: 80%">
																		
																		<div class="card">
																		<div class="card-body">
																			
																		<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
																			<!-- Modal content-->
																			<div class="modal-content">
																			<div class="card-head style-primary">
																							<h2 class="text-center"> <?php echo $NombreDoc; ?> </h2>
																						</div>
																				<div class="modal-body">
																				<form class="form" id="FormularioVer" action="GuardarDocumento.php" method="POST" enctype="multipart/form-data">
																					<div id="suggestions" class="text-center"></div>
																					
																					<embed 	src="<?php echo $NombreDoc; ?>" style="width:100%; height:500px;" frameborder="0" >	

																				</form>

																						<div class="modal-footer">
																					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
																				</div>
																				</div>
																			</div>
																			</div>
																		</div>
																		
																	</div>
																	</div>
												<!-- /Modal Detalle Pasivo Contingente -->
						                                          						  						

																														

																	
																							<?php 	

																						}
																						
																					}
																						?>
																						
																				</form>

																						<div>
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
                                      
								</div>
											


											<?php
										}
										?>	
											</tbody>
										</table>
										<?php
									}
									else
									{
										?>
										
										<div class="alert alert-danger text-center" role="alert">
											<strong>No se encontró ninguna requisición con los parámetros establecidos</strong>
										</div>
										<div class="row text-center">
											<a href="MRC.php">
												<button type="button" class="btn btn-primary btn-md">
											    	<span class="glyphicon glyphicon-chevron-left"></span> Regresar
												</button>
											</a>
										</div>

										<?php
									}
								?>
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
	</body>
	</html>
