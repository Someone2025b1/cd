<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
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
		alert('llega');
		var CancelacionVar = $('#Cancelacion').val();
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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php
	$Numero = $_GET["Numero"];

	$Query = "SELECT REQUISICION.*, REQUISICION_ESTADO.* 
				FROM Contabilidad.REQUISICION, Contabilidad.REQUISICION_ESTADO 
				WHERE REQUISICION.RE_CODIGO = REQUISICION_ESTADO.RE_CODIGO
				AND REQUISICION.R_NUMERO = ".$Numero;
	$Result = mysqli_query($db, $Query);
	while($Fila = mysqli_fetch_array($Result))
	{
		$FechaRequisicion = $Fila["R_FECHA"];
		$FechaNecesidad = $Fila["R_FECHA_NECESIDAD"];
		$ColaboradorSolicita = $Fila["R_COLABORADOR"];
		$AreaGasto = $Fila["AG_CODIGO"];
		$Observaciones = $Fila["R_OBSERVACIONES"];
		$Estado = $Fila["RE_CODIGO"];

		if($Estado == 1)
		{
			$Text = "";
		}
		else
		{
			$Text = "readonly";
		}
		$Codigo = $Fila["R_CODIGO"];
		$NombreEstado = $Fila["RE_NOMBRE"];
		$CodigoEstado = $Fila["RE_CODIGO"];
		$MotivoCancelacion = $Fila["R_MOTIVO_CANCELACION"];
	}
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<?php
				if($Estado == 1)
				{
					echo '<form class="form" action="RCMod.php" method="POST" role="form">';
				}
				else
				{
					echo '<form class="form" role="form">';
				}
				?>
				
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
											<input class="form-control" type="text" name="NombreEstado" id="NombreEstado" required value="<?php echo $_GET["Numero"]; ?>"/>
											<label for="NombreEstado">No. Requisición</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="NombreEstado" id="NombreEstado" value="<?php echo $NombreEstado; ?>" required <?php echo $Text; ?>/>
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
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaNecesidad" id="FechaNecesidad" value="<?php echo date('Y-m-d', strtotime($FechaNecesidad)); ?>" required <?php echo $Text; ?>/>
											<label for="FechaNecesidad">Fecha de Necesidad</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<select class="form-control selectpicker" data-live-search="true" required id="ColaboradorSolicita" name="ColaboradorSolicita" <?php echo $Text; ?>>
												<?php
													$Query = "SELECT cif FROM info_colaboradores.datos_laborales WHERE estado = 1 AND cif <> 12947 ORDER BY cif";
													$Result = mysqli_query($db, $Query);
													while($row = mysqli_fetch_array($Result))
													{
														if($row["cif"] == $ColaboradorSolicita)
														{
															$Texto = 'selected';
														}
														else
														{
															$Texto = '';
														}
														$Nombre = saber_nombre_colaborador($row["cif"]);
														echo '<option data-tokens="'.$Nombre.'" value="'.$row["cif"].'" '.$Texto.'>'.$Nombre.'</option>';
													}
												?>
											</select>
											<label for="ColaboradorSolicita">Colaborador que solicita</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<select class="form-control" required id="AreaGasto" name="AreaGasto" <?php echo $Text; ?>>
												<?php
													$Query1 = "SELECT * FROM Contabilidad.AREA_GASTO ORDER BY AG_NOMBRE";
													$Result1 = mysqli_query($db, $Query1);
													while($row1 = mysqli_fetch_array($Result1))
													{
														if($row1["AG_CODIGO"] == $AreaGasto)
														{
															$Texto = 'selected';
														}
														else
														{
															$Texto = '';
														}	
														echo '<option data-tokens="'.$row1["AG_NOMBRE"].'" value="'.$row1["AG_CODIGO"].'" '.$Texto.'>'.$row1["AG_NOMBRE"].'</option>';
													}
												?>
											</select>
											<label for="AreaGasto">Área de Gasto</label>
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
								if($CodigoEstado == 4)
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
								if($CodigoEstado == 3)
								{
									$QueryFacturaCompra = "SELECT REQUISICION.R_FACTURA_COMPRA, REQUISICION.R_PROVEEDOR, PROVEEDOR.P_NOMBRE 
															FROM Contabilidad.REQUISICION, Contabilidad.PROVEEDOR
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
                                                <td><strong>Sugerencia</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fila-base">
                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="Cantidad[]" id="Cantidad[]" style="width: 100px" value="0.00" min="0" ></h6></td>
                                                <td><input align="right" type="text" class="form-control" name="Descripcion[]" id="Descripcion[]" ></td>
                                                <td><input align="right" type="text" class="form-control" name="Sugerencia[]" id="Sugerencia[]" ></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php 
                                            if($Estado == 1)
                                            {
                                            	$QueryDetalle = "SELECT * FROM Contabilidad.REQUISICION_DETALLE WHERE R_CODIGO = '".$Codigo."'";
                                            	$ResultDetalle = mysqli_query($db, $QueryDetalle);
                                            	while($row = mysqli_fetch_array($ResultDetalle))
                                            	{
                                            		?>
													
													<tr>
		                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="Cantidad[]" id="Cantidad[]" style="width: 100px" value="<?php echo $row['RD_CANTIDAD'] ?>" min="0"></h6></td>
		                                                <td><input align="right" type="text" class="form-control" name="Descripcion[]" id="Descripcion[]" value="<?php echo $row['RD_DESCRIPCION'] ?>"></td>
		                                                <td><input align="right" type="text" class="form-control" name="Sugerencia[]" id="Sugerencia[]" value="<?php echo $row['RD_SUGERENCIA'] ?>"></td>
		                                                <td class="eliminar">
		                                                    <button type="button" class="btn btn-danger btn-xs">
		                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
		                                                    </button>
		                                                </td>
		                                            </tr>

                                            		<?php
                                            	}
                                            }
                                            else
                                            {
                                            	$QueryDetalle = "SELECT * FROM Contabilidad.REQUISICION_DETALLE WHERE R_CODIGO = '".$Codigo."'";
                                            	$ResultDetalle = mysqli_query($db, $QueryDetalle);
                                            	while($row = mysqli_fetch_array($ResultDetalle))
                                            	{
                                            		?>
													
													<tr>
		                                                <td><h6><input align="right" type="number" step="any" class="form-control" name="Cantidad[]" id="Cantidad[]" style="width: 100px" value="<?php echo $row['RD_CANTIDAD'] ?>" min="0" readonly></h6></td>
		                                                <td><input align="right" type="text" class="form-control" name="Descripcion[]" id="Descripcion[]" value="<?php echo $row['RD_DESCRIPCION'] ?>" readonly></td>
		                                                <td><input align="right" type="text" class="form-control" name="Sugerencia[]" id="Sugerencia[]" value="<?php echo $row['RD_SUGERENCIA'] ?>" readonly></td>
		                                            </tr>

                                            		<?php
                                            	}
                                            }

                                            ?>
                                            
                                        </tbody>
                                    </table>
                                    <?php 
                                    if($Estado == 1)
                                    {
                                    	?>
                                    		<div class="col-lg-12" align="left">
		                                        <button type="button" class="btn btn-success btn-xs" id="agregar">
		                                            <span class="glyphicon glyphicon-plus"></span> Agregar
		                                        </button>
		                                    </div>

                                    	<?php
                                    }

                                    ?>
								</div>
							</div>
						</div>
					</div>
					<?php

					if($Estado == 1)
					{
						?>
						<div class="col-lg-6" align="center">
							<button type="button" class="btn ink-reaction btn-raised btn-danger" id="btnCancelar" onclick="CancelarRequisicion()">Cancelar Requisición</button>
						</div>
						<div class="col-lg-6" align="center">
							<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Actualizar</button>
						</div>

						<?php
					}
					?>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
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
                    				<input class="form-control" maxlength="255" type="text" name="Cancelacion" id="Cancelacion" />
                    				<label for="Cancelacion">¿Por qué desea cancelar la requisición?</label>
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
								<button type="button" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" onclick="CancelarRequisicion()">Cancelar Requisición</button>
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
