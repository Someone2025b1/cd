<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$id_user = $_SESSION["iduser"];

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
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<link rel="stylesheet" type="text/css" href="../../../../../libs/alertify/css/alertify.core.css">
	<link rel="stylesheet" type="text/css" href="../../../../../libs/alertify/css/alertify.bootstrap.css">
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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="card">
				<div class="card-body">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th><h5><strong>#</strong></h5></th>
								<th><h5><strong>FECHA DEGUSTACION</strong></h5></th>
								<th><h5><strong>HORA</strong></h5></th>
								<th><h5><strong>CLIENTE</strong></h5></th>
								<th><h5><strong>CUI</strong></h5></th>
								<th><h5><strong>NIT</strong></h5></th>
								<th><h5><strong>DIAS RESTANTES</strong></h5></th>
								<th><h5><strong>CONSULTA</strong></h5></th>
								<th><h5><strong>REALIZADA</strong></h5></th>
								<th><h5><strong>RECHAZAR</strong></h5></th>
								<th><h5><strong>ENVIAR RECORDATORIO</strong></h5></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$Contador = 1;
								$Query = mysqli_query($db, "SELECT *, DATEDIFF(D_FECHA, CURRENT_DATE()) AS DIFERENCIA_DIAS
														FROM Bodega.DEGUSTACION AS A
														WHERE A.D_COLABORADOR = ".$id_user."
														AND A.D_ESTADO = 1
														ORDER BY DIFERENCIA_DIAS ASC, A.D_FECHA_INGRESO DESC, A.D_FECHA_INGRESO DESC");
								while($Fila = mysqli_fetch_array($Query))
								{
									if($Fila[DIFERENCIA_DIAS] <= 1)
									{
										$Color = 'class="danger"';
									}
									elseif($Fila[DIFERENCIA_DIAS] > 1 && $Fila[DIFERENCIA_DIAS] <= 4)
									{
										$Color = 'class="warning"';
									}
									else
									{
										$Color = 'class="success"';
									}
									?>
										<tr <?php echo $Color ?>>
											<td><h6><?php echo $Contador ?></h6></td>
											<td><h6><?php echo date('d-m-Y', strtotime($Fila[D_FECHA])) ?></h6></td>
											<td><h6><?php echo $Fila[D_HORA] ?></h6></td>
											<td><h6><?php echo $Fila[D_NOMBRE] ?></h6></td>
											<td><h6><?php echo $Fila[D_CUI] ?></h6></td>
											<td><h6><?php echo $Fila[D_NIT] ?></h6></td>
											<td><h6><?php echo $Fila[DIFERENCIA_DIAS] ?></h6></td>
											<td><a href="Consulta_Degustacion.php?Codigo=<?php echo $Fila[D_CODIGO] ?>"><button type="button" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-search"></span></button></a></td>
											<td><button type="button" class="btn btn-sm btn-warning" onclick="MarcarRealizada(this.value)" value="<?php echo $Fila[D_REFERENCIA] ?>"><span class="glyphicon glyphicon-check"></span></button></td>
											<td><button type="button" class="btn btn-sm btn-warning" onclick="MarcarRechazada(this.value)" value="<?php echo $Fila[D_REFERENCIA] ?>"><span class="glyphicon glyphicon-remove"></span></button></td>
											<td><button type="button" class="btn btn-sm btn-warning" onclick="EnviarRecordatorio(this.value)" value="<?php echo $Fila[D_REFERENCIA] ?>"><span class="glyphicon glyphicon-bell"></span></button></td>
										</tr>
									<?php
									$Contador++;
								}
							?>
						</tbody>
					</table>
					<?php

					?>			
				</div>
			</div>
			<!-- END CONTENT -->

			<?php include("../MenuUsers.html"); ?>

		</div><!--end #base-->
		<!-- END BASE -->

		<div class="modal fade" id="ModalAceptada">
			<div class="modal-dialog" style="width: 80%">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title text-center"><strong>REALIZAR DEGUSTACION</strong></h4>
					</div>
					<div class="modal-body">
						<form id="FRMMarcar">
							<div class="row">
								<input type="hidden" id="CodigoDegustacion" name="CodigoDegustacion">
								<input type="hidden" id="CodigoCotizacion" name="CodigoCotizacion">
								<div class="col-lg-12">
									<div class="col-lg-12">
										<label for="Observaciones">Observaciones</label>
										<input type="text" class="form-control" step="any" name="Observaciones" id="Observaciones" required>
									</div>
								</div>
							</div>
							<div class="row">
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th><h5><strong>#</strong></h5></th>
											<th><h5><strong>FECHA EVENTO</strong></h5></th>
											<th><h5><strong>HORA</strong></h5></th>
											<th><h5><strong>CLIENTE</strong></h5></th>
											<th><h5><strong>CUI</strong></h5></th>
											<th><h5><strong>NIT</strong></h5></th>
											<th><h5><strong>ESTADO</strong></h5></th>
											<th><h5><strong>SELECCIONAR</strong></h5></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$Contador = 1;
											$Query = mysqli_query($db, "SELECT A.C_CODIGO, A.C_FECHA_EVENTO, A.C_HORA_INICIO_EVENTO, A.C_HORA_FIN_EVENTO, A.CE_NOMBRE, A.CE_CUI, A.CE_NIT, B.ECE_NOMBRE, A.C_ESTADO
																	FROM Bodega.COTIZACION AS A
																	INNER JOIN Bodega.ESTADO_COTIZACION_EVENTO AS B ON A.C_ESTADO = B.ECE_CODIGO
																	WHERE A.D_CODIGO = ''
																	ORDER BY A.C_FECHA_INGRESO DESC, A.C_HORA_INGRESO DESC");
											while($Fila = mysqli_fetch_array($Query))
											{
												?>
													<tr>
														<td><h6><?php echo $Contador ?></h6></td>
														<td><h6><?php echo date('d-m-Y', strtotime($Fila[C_FECHA_EVENTO])) ?></h6></td>
														<td><h6><?php echo 'Desde las '.$Fila[C_HORA_INICIO_EVENTO].' hasta las '.$Fila[C_HORA_FIN_EVENTO] ?></h6></td>
														<td><h6><?php echo $Fila[CE_NOMBRE] ?></h6></td>
														<td><h6><?php echo $Fila[CE_CUI] ?></h6></td>
														<td><h6><?php echo $Fila[CE_NIT] ?></h6></td>
														<td><h6><?php echo $Fila[ECE_NOMBRE] ?></h6></td>
														<td><button value="<?php echo $Fila[C_CODIGO] ?>" type="button" class="btn btn-primary" onclick="Seleccionar(this.value)"><span class="glyphicon glyphicon-check"></span></button></td>
													</tr>
												<?php
												$Contador++;
											}
										?>
									</tbody>
								</table>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>


		<div class="modal fade" id="ModalPreloader" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" style="width: 60%">
				<div class="modal-content">
					<div class="modal-body">
						<div class="row text-center">
							<img src="../../../../../img/LoaderNew.gif" alt="">
						</div>												
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
		<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.js"></script>
		<script src="../../../../../js/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<script src="../../../../../js/libs/carousel/dist/carousel.js"></script>
		<script src="../../../../../js/libs/carousel/src/lib/bane/bane.js"></script>
		<script src="../../../../../libs/alertify/js/alertify.js"></script>
		<!-- END JAVASCRIPT -->

		<script>
			function MarcarRealizada(x)
			{

				$('#CodigoDegustacion').val(x);

				$('#ModalAceptada').modal('show');
			}
			function Guardar()
			{
				if($('#CodigoCotizacion').val() == '' && $('#CodigoDegustacion').val() == '')
				{
					alertify.error('Antes de continuar, debe llenar los campos obligatorios');
				}
				else
				{
					$.ajax({
	        			url: 'MarcarRealizada.php',
	        			type: 'post',
	        			data: 'CodigoDegustacion='+$('#CodigoDegustacion').val()+'&CodigoCotizacion='+$('#CodigoCotizacion').val()+'&Descripcion='+Observaciones,
	        			success: function (data) {
	        				if(data == 1)
	        				{
	        					window.location.reload();
	        				}
	        				else
	        				{
	        					alertify.error('No se puedo marcar como realizada la degustación');
	        				}
	        			}
	        		});
	        	}
			}
			function MarcarRechazada(x)
			{
				alertify.prompt("¿Está seguro que desea marcar como rechazada la degustación? Si confirma, por favor de una descripción.", function (e, str) {
				    // str is the input text
				    if (e) {
				        if(str == "")
				        {
				        	alertify.error('La descripción no puede ir vacío');
				        }
				        else
				        {
				        	$.ajax({
			        			url: 'MarcarRechazada.php',
			        			type: 'post',
			        			data: 'Codigo='+x+'&Descripcion='+str,
			        			success: function (data) {
			        				if(data == 1)
			        				{
			        					window.location.reload();
			        				}
			        				else
			        				{
			        					alertify.error('No se puedo marcar como realizada la degustación');
			        				}
			        			}
			        		});
				        }
				    }
				}, "");
			}
			function EnviarRecordatorio(x)
			{
				alertify.confirm("¿Está seguro que desea enviarle un recordatorio a la persona seleccionada?", function (e) {
				    if (e) {
				    	$.ajax({
				    			url: 'EnviarRecordatorio.php',
				    			type: 'post',
				    			data: 'Codigo='+x,
				    			beforeSend: function (data){
				    				$('#ModalPreloader').modal('show');
				    			},
				    			success: function (data) {
				    				if(data == 1)
				    				{
				    					$('#ModalPreloader').modal('hide');
				    					alertify.success('Recordatorio Enviado');
				    				}
				    				else
				    				{
				    					$('#ModalPreloader').modal('hide');
				    					alertify.error('No se pudo enviar el correo, por favor inténtelo mas tarde');
				    				}
				    			}
				    		});
				    }
				});
			}
			function Seleccionar(x)
			{
				$('#CodigoCotizacion').val(x);
				Guardar();
			}
		</script>

	</body>
	</html>
