<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");
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
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Lista de Activos Fijos</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Activos Fijos</strong></h4>
						</div>
						<div class="card-body">
							<table class="table table-hover table-condensed" id="tbl_resultados">
								<thead>
									<tr>
										<th>
											<strong><h6>Código</h6></strong>
										</th>
										<th>
											<strong><h6>Nombre</h6></strong>
										</th>
										<th>
											<strong><h6>Responsable</h6></strong>
										</th>
										<th>
											<strong><h6>Tipo</h6></strong>
										</th>
										<th>
											<strong><h6>Área</h6></strong>
										</th>
										<th>
											<strong><h6>Observaciones</h6></strong>
										</th>
										<th>
											<strong><h6>Valor</h6></strong>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$query = "SELECT A.*, B.AG_NOMBRE, C.TA_NOMBRE
											FROM Contabilidad.ACTIVO_FIJO AS A
											INNER JOIN Contabilidad.AREA_GASTO AS B ON A.AF_AREA = B.AG_CODIGO
											INNER JOIN Contabilidad.TIPO_ACTIVO AS C ON A.TA_CODIGO = C.TA_CODIGO
											WHERE A.AF_ESTADO = 1";
									$result = mysqli_query($db,$query);
									while($row = mysqli_fetch_array($result))
									{
										$NombreResponsable = saber_nombre_colaborador($row["AF_RESPONSABLE"]);
										?>
										<tr>
											<td><h6><?php echo $row["AF_CODIGO"]; ?></h6></td>
											<td><h6><?php echo $row["AF_NOMBRE"]; ?></h6></td>
											<td><h6><?php echo $NombreResponsable; ?></h6></td>
											<td><h6><?php echo $row["TA_NOMBRE"]; ?></h6></td>
											<td><h6><?php echo $row["AG_NOMBRE"]; ?></h6></td>
											<td><h6><?php echo $row["AF_OBSERVACIONES"]; ?></h6></td>
											<td><h6><?php echo number_format($row["AF_VALOR"], 2, '.', ',') ?></h6></td>
											<td>
												<h6><a href="DarBajaPro.php?CodigoActivo=<?php echo $row["AF_CODIGO"] ?>&CodigoTrans=<?php $_GET["CodigoPoliza"]; ?>"><button type="button" class="btn btn-danger btn-xs">
												<span class="glyphicon glyphicon-arrow-down"></span> Baja
												</button></a></h6>
											</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
			        </div>
			    </div>
			</div>
		</div>
		<!-- END CONTENT -->

		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

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
	<!-- END JAVASCRIPT -->

</body>
</html>
