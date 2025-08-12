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
								<th><h5><strong>FECHA EVENTO</strong></h5></th>
								<th><h5><strong>HORA</strong></h5></th>
								<th><h5><strong>CLIENTE</strong></h5></th>
								<th><h5><strong>CUI</strong></h5></th>
								<th><h5><strong>NIT</strong></h5></th>
								<th><h5><strong>ESTADO</strong></h5></th>
								<th><h5><strong>MODIFICAR</strong></h5></th>
								<th><h5><strong>RESERVAR</strong></h5></th>
								<th><h5><strong>IMPRIMIR</strong></h5></th>
								<th><h5><strong>FACTURAR</strong></h5></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$Contador = 1;
								$Query = mysqli_query($db, "SELECT A.C_CODIGO, A.C_FECHA_EVENTO, A.C_HORA_INICIO_EVENTO, A.C_HORA_FIN_EVENTO, A.CE_NOMBRE, A.CE_CUI, A.CE_NIT, B.ECE_NOMBRE, A.C_ESTADO
														FROM Bodega.COTIZACION AS A
														INNER JOIN Bodega.ESTADO_COTIZACION_EVENTO AS B ON A.C_ESTADO = B.ECE_CODIGO
														WHERE A.C_USUARIO_INGRESO = ".$id_user."
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
											<td><a href="Consulta_Cotizacion.php?Codigo=<?php echo $Fila[C_CODIGO] ?>"><button type="button" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-search"></span></button></a></td>
											<?php
												if($Fila[C_ESTADO] == 1)
												{
													?>
														<td><button type="button" class="btn btn-sm btn-warning" value="<?php echo $Fila[C_CODIGO] ?>" onclick="Reservar(this)"><span class="fa fa-circle-o"></span></button></td>
													<?php
												}
												elseif($Fila[C_ESTADO] == 4)
												{
													?>
														<td><a href="ReciboCaja.php?Codigo=<?php echo $Fila[C_CODIGO] ?>" target="_blank"><button type="button" class="btn btn-sm btn-warning" value="<?php echo $Fila[C_CODIGO] ?>"><span class="fa fa-circle-o"></span></button></a></td>
													<?php
												}
												else
												{
													?>
														<td><button disabled type="button" class="btn btn-sm btn-warning"><span class="fa fa-circle-o"></span></button></td>
													<?php
												}
											?>
											<td><button type="button" class="btn btn-sm btn-warning" value="<?php echo $Fila[C_CODIGO] ?>" onclick="ImprimirCotizacion(this.value)"><span class="glyphicon glyphicon-print"></span></button></td>
											<td><a href="Vta.php?Codigo=<?php echo $Fila[C_CODIGO] ?>"><button type="button" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-check"></span></button></a></td>
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

		<div class="modal fade" id="ModalReserva">
			<div class="modal-dialog" style="width: 60%">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title text-center"><strong>RESERVAR</strong></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<input type="hidden" id="CodigoCotizacion" name="CodigoCotizacion">
							<div class="col-lg-12">
								<div class="col-lg-4">
									<label for="Monto">Monto</label>
									<input type="number" class="form-control" step="any" name="Monto" id="Monto">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-primary" onclick="GuardarReserva()">Guardar</button>
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
			function Reservar(x)
			{
				$('#ModalReserva').modal('show');
				$('#CodigoCotizacion').val(x.value);
			}
			function GuardarReserva()
			{
				if($('#Monto').val() == '')
				{
					alertify.error('Antes de continuar, favor llene el campo de Monto');
				}
				else
				{
					$.ajax({
							url: 'GuardarReserva.php',
							type: 'post',
							data: 'Codigo='+$('#CodigoCotizacion').val()+'&MontoReserva='+$('#Monto').val(),
							success: function (data) {
								if(data == 1)
								{
									window.open('ReciboCajaReserva.php?Codigo'+$('#CodigoCotizacion').val(),'_blank');
									window.location.reload();
								}
								else
								{
									alertify.error('No se pudo realizar la reserva');
								}
							}
						});
				}
			}
			function ImprimirCotizacion(x)
			{
				alertify.confirm("¿Desea enviar la cotización al cliente por correo electrónico?", function (e) {
				    if (e) {
				        var win = window.open('Cotizacion_Imp.php?Codigo='+x+'&Envio=1', '_blank');
  						win.focus();
				    } else {
				        var win = window.open('Cotizacion_Imp.php?Codigo='+x+'&Envio=0', '_blank');
  						win.focus();
				    }
				});
			}
		</script>

	</body>
	</html>
