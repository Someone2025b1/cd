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

	<?php include("../../../../MenuTop.php");



	$Query = "SELECT CONTEO_INVENTARIO_FISICO.*, BODEGA.B_NOMBRE, PERIODO_CONTABLE.* 
	FROM Bodega.CONTEO_INVENTARIO_FISICO, Bodega.BODEGA, Contabilidad.PERIODO_CONTABLE 
	WHERE CONTEO_INVENTARIO_FISICO.B_CODIGO = BODEGA.B_CODIGO 
	AND CONTEO_INVENTARIO_FISICO.PC_CODIGO = PERIODO_CONTABLE.PC_CODIGO
	AND CIF_ESTADO = 0";
	$Result = mysqli_query($db, $Query);
	$Registros = mysqli_num_rows($Result);
	?>


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
								<h4 class="text-center"><strong>Conteo Inventario Físico Pendientes de Operar</strong></h4>
							</div>
							<div class="card-body">
								<?php
								if($Registros > 0)
								{

									?>
										<table class="table table-hover table-condensed">
											<thead>
												<tr>
													<th><h4><strong>#</strong></h4></th>
													<th><h4><strong>Fecha Conteo</strong></h4></th>
													<th><h4><strong>Bodega</strong></h4></th>
													<th><h4><strong>Periodo</strong></h4></th>
												</tr>
											</thead>
											<tbody>
											<?php
												$i = 1;
												
												while($Fila = mysqli_fetch_array($Result))
												{
													$Codigo = $Fila["CIF_CODIGO"];
													$Bodega = $Fila["B_CODIGO"];  
													$FechaConteo = $Fila["CIF_FECHA"];
													?>
													<tr>
														<td><?php echo $i; ?></td>		
														<td><?php echo date('d-m-Y', strtotime($Fila["CIF_FECHA"])); ?></td>		
														<td><?php echo $Fila["B_NOMBRE"]; ?></td>		
														<td><?php echo $Fila["PC_MES"].'-'.$Fila["PC_ANHO"]; ?></td>		
														<td><a href="IFPro.php?Codigo=<?php echo $Codigo; ?>&Bodega=<?php echo $Bodega?>&Fecha=<?php echo $FechaConteo ?>">
																<button type="button" class="btn btn-success btn-xs">
														    		<span class="glyphicon glyphicon-check"></span> Operar
																</button>
															</a>
														</td>		
													</tr>
													<?php
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
											Actualmente <strong>no hay</strong> conteos físicos de inventario pendientes de revisión.
										</div>
									<?php
								}
								?>
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
