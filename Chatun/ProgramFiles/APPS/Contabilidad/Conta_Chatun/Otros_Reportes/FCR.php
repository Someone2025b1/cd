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


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="FRImp.php" method="POST" role="form" target="_blank">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Facturas de Compra Rechazadas</strong></h4>
							</div>
							<div class="card-body">
								<?php
	                                
									$query = "SELECT A.*, B.P_NOMBRE, B.P_CODIGO FROM Contabilidad.TRANSACCION AS A, Contabilidad.PROVEEDOR AS B 
												WHERE A.P_CODIGO = B.P_CODIGO 
												AND (A.TT_CODIGO = 2 OR A.TT_CODIGO = 13)
												AND A.E_CODIGO = 3";
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
													<th class="text-center"><strong><h6>Fecha</h6></strong></th>
													<th class="text-center"><strong><h6>Serie</h6></strong></th>
													<th class="text-center"><strong><h6>Factura</h6></strong></th>
													<th class="text-center"><strong><h6>Código Proveedor</h6></strong></th>
													<th class="text-center"><strong><h6>Nombre</h6></strong></th>
													<th class="text-center"><strong><h6>Rechazada por</h6></strong></th>
													<th class="text-center"><strong><h6>Total</h6></strong></th>
												</tr>
											</thead>
											<tbody>
										<?php
										while($row = mysqli_fetch_array($result))
										{
											$Codigo = $row["TRA_CODIGO"];
											echo '<tr>';
												echo '<td>'.$i.'</td>';
												echo '<td>'.date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"])).'</td>';
												echo '<td>'.$row["TRA_SERIE"].'</td>';
												echo '<td>'.$row["TRA_FACTURA"].'</td>';
												echo '<td>'.$row["P_CODIGO"].'</td>';
												echo '<td>'.$row["P_NOMBRE"].'</td>';
												echo '<td>'.$row["TRA_MOTIVO_RECHAZO"].'</td>';
												echo '<td>'.number_format($row["TRA_TOTAL"], 2, '.', ',').'</td>';
												echo '<td><a href="OFacturaPro.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-warning btn-xs">
															<span class="glyphicon glyphicon-search"></span> Consultar
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
