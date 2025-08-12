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


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="IngresoPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Solicitudes Pendientes de Compra</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<?php
	                                
									$query = "SELECT REQUISICION.*, BODEGA.B_NOMBRE
												FROM Bodega.REQUISICION, Bodega.BODEGA
												WHERE REQUISICION.B_CODIGO = BODEGA.B_CODIGO
												AND RT_CODIGO = 1
												AND R_ESTADO = 1";
									$result = mysqli_query($db, $query);
									$NumeroResultados = mysqli_num_rows($result);
									if($NumeroResultados > 0)
									{
										$i = 1;
										?>
										<table class="table">
											<thead>
												<tr>
													<th class="text-center"><strong><h6>No.</h6></strong></th>
													<th class="text-center"><strong><h6>Fecha Solicitud</h6></strong></th>
													<th class="text-center"><strong><h6>Solicitó</h6></strong></th>
													<th class="text-center"><strong><h6>Fecha de Necesidad</h6></strong></th>
													<th class="text-center"><strong><h6>Bodega</h6></strong></th>
													<th class="text-center"><strong><h6>Observaciones</h6></strong></th>
												</tr>
											</thead>
											<tbody>
										<?php
										while($row = mysqli_fetch_array($result))
										{
											$Codigo = $row["R_CODIGO"];
											echo '<tr>';
												echo '<td>'.$i.'</td>';
												echo '<td>'.date('d-m-Y', strtotime($row["R_FECHA"])).'</td>';
												echo '<td>'.saber_nombre_colaborador($row["R_USUARIO"]).'</td>';
												echo '<td>'.date('d-m-Y', strtotime($row["R_FECHA_NECESIDAD"])).'</td>';
												echo '<td>'.$row["B_NOMBRE"].'</td>';
												echo '<td>'.$row["R_OBSERVACIONES"].'</td>';
												echo '<td><a href="SolicitudDetalle.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-warning btn-xs">
															<span class="glyphicon glyphicon-search"></span> Detalle
														</button></a></td>';
											echo '</tr>';
											$i++;
										}
										?>
											</tbody>
										</table>
										<?php
									}
									else
									{
										?>
											<div class="alert alert-callout alert-success" role="alert">
												Actualmente <strong>no hay</strong> facturas pendientes por operar.
											</div>
										<?php
									}

									?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->

	
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
