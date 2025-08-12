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
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="CLPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Contabilizar Liquidación</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<?php
	                                
									$query = "SELECT TRANSACCION.*
											  FROM  Contabilidad.TRANSACCION
											  WHERE  ((TT_CODIGO = 12 AND TRA_TIPO_DOCUMENTO = 'R') OR (TT_CODIGO = 2 AND TRA_TIPO_DOCUMENTO = 'F'))
											  AND E_CODIGO = 1
											  ORDER BY TRA_FECHA_TRANS, TRA_CORRELATIVO";
									$result = mysqli_query($db,$query);
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
													<th class="text-center"><strong><h6>Tipo Documento</h6></strong></th>
													<th class="text-center"><strong><h6>Descripción</h6></strong></th>
													<th class="text-center"><strong><h6>Anticipo</h6></strong></th>
													<th class="text-center"><strong><h6>Total</h6></strong></th>
												</tr>
											</thead>
											<tbody>
										<?php
										while($row = mysqli_fetch_array($result))
										{
											if($row["TRA_TIPO_DOCUMENTO"] == 'F')
											{
												$Documento = 'Factura';
											}
											else
											{
												$Documento = 'Recibo';
											}
											$Codigo = $row["TRA_CODIGO"];
											echo '<tr>';
												echo '<td>'.$i.'</td>';
												echo '<td style="width:150px">'.date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"])).'</td>';
												echo '<td>'.$Documento.'</td>';
												echo '<td>'.$row["TRA_CONCEPTO"].'</td>';
												echo '<td>'.$row["TRA_CORRELATIVO"].'</td>';
												echo '<td>'.number_format($row["TRA_TOTAL"], 2, '.', ',').'</td>';
												echo '<td><a href="CLPro.php?Codigo='.$Codigo.'&Tipo='.$row["TRA_TIPO_DOCUMENTO"].'"><button type="button" class="btn btn-warning btn-xs">
															<span class="glyphicon glyphicon-pencil"></span> Operar
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
												Actualmente <strong>no hay</strong> solicitudes pendientes por contabilizar.
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
