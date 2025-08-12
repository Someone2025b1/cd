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

</head>
<body class="menubar-hoverable header-fixed menubar-pin">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="#" method="GET" role="form" >
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Ingreso Diario</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<div class="col-lg-3"></div>
									<div class="col-lg-6">
										<div class="form-group">
											<div class="input-daterange input-group" id="demo-date-range">
												<div class="input-group-content">
													<input type="date" class="form-control" name="FechaInicio" value="<?php echo date('Y-m-d') ?>">
													<label>Rango de Fechas</label>
												</div>
												<span class="input-group-addon">al</span>
												<div class="input-group-content">
													<input type="date" class="form-control" name="FechaFin" value="<?php echo date('Y-m-d') ?>">
													<div class="form-control-line"></div>
												</div>
											</div>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="col-lg-12" align="center">
									<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Consultar</button>
								</div>
								<?php
									if(isset($_GET["FechaInicio"]) && isset($_GET["FechaFin"]))
									{
										?>
											<div class="row">
												<br>
												<br>
												<br>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<?php
														$Query = mysqli_query($db, "SELECT *
																				FROM Taquilla.INGRESO_ASOCIADO AS A
																				WHERE A.IA_FECHA_INGRESO BETWEEN '2017-08-01' AND '2017-08-03'
																				ORDER BY A.IA_FECHA_INGRESO, A.IA_HORA_INGRESO");
														$Registros = mysqli_num_rows($Query);

														if($Registros > 0)
														{
															?>
																<table class="table table-hover table-condensed">
																	<thead>
																		<tr>
																			<th><h5><strong>#</strong></h5></th>
																			<th><h5><strong>CIF</strong></h5></th>
																			<th><h5><strong>NOMBRE</strong></h5></th>
																			<th><h5><strong>FECHA/HORA</strong></h5></th>
																			<th><h5><strong>ACOMPAÑANTES</strong></h5></th>
																			<th><h5><strong>REGISTRÓ</strong></h5></th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			$Contador = 1;
																			while($Fila = mysqli_fetch_array($Query))
																			{
																				$QueryAcompanantes = mysqli_query($db, "SELECT *
																													FROM Taquilla.INGRESO_ACOMPANIANTE AS A
																													WHERE A.IA_REFERENCIA = '".$Fila[IA_REFERENCIA]."'");
																				$RegistroAcompanantes = mysqli_num_rows($QueryAcompanantes);
																				?>
																					<tr>
																						<td><h6><?php echo $Contador ?></h6></td>
																						<td><h6><?php echo $Fila["IAT_CIF_ASOCIADO"] ?></h6></td>
																						<td><h6><?php echo saber_nombre_asociado_orden($Fila["IAT_CIF_ASOCIADO"]) ?></h6></td>
																						<td><h6><?php echo date('d-m-Y', strtotime($Fila["IA_FECHA_INGRESO"])).' '.$Fila["IA_HORA_INGRESO"] ?></h6></td>
																						<?php
																							if($RegistroAcompanantes > 0)
																							{
																								?>
																									<td><h6><button type="button" class="btn btn-warning" onclick="VerAcompanantes(this.value)" value="<?php echo $Fila[IA_REFERENCIA] ?>"><span class="glyphicon glyphicon-search"></span></button></h6></td>
																								<?php
																							}
																							else
																							{
																								?>
																									<td><h6>N/A</h6></td>
																								<?php
																							}
																						?>
																						<td><h6><?php echo saber_nombre_asociado_orden($Fila["IAT_CIF_COLABORADOR"]) ?></h6></td>
																					</tr>
																				<?php
																				$Contador++;
																			}
																		?>
																	</tbody>
																</table>
															<?php
														}
														else
														{
															?>
																<div class="row text-center">
																	<div class="alert alert-warning">
																		<strong>No existen registros para las fechas ingresadas</strong>
																	</div>
																</div>
															<?php
														}
													?>
												</div>
											</div>
										<?php
									}
								?>
							</div>
						</div>
					</div>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->

		<div class="modal fade" id="ModalAcompanantes">
			<div class="modal-dialog" style="width: 80%">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title text-center"><strong>Detalle de Acompañantes</strong></h4>
					</div>
					<div class="modal-body">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th><h5><strong>NOMBRE</strong></h5></th>
									<th><h5><strong>EDAD</strong></h5></th>
									<th><h5><strong>EMAIL</strong></h5></th>
								</tr>
							</thead>
							<tbody id="Resultado">
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		
		<?php include("../MenuUsers.html"); ?>

		<script>
			function VerAcompanantes(x)
			{
				$.ajax({
						url: 'VerAcompanantes.php',
						type: 'post',
						data: 'Referencia='+x,
						success: function (data) {
							$('#Resultado').html(data);
							$('#ModalAcompanantes').modal('show');
						}
					});
			}
		</script>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
