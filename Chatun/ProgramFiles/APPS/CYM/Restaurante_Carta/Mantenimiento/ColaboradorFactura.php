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
				<h1 class="text-center"><strong>Administración de Colaboradores con Permiso de Facturación</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<form id="FMRAgregar">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="Colaborador">Colaborador</label>
											<select class="form-control" name="Colaborador" id="Colaborador" required>
												<option value="" disabled selected>SELECCIONE UN COLABORADOR</option>
												<?php
													$Sql = mysqli_query($db, "SELECT A.cif, CONCAT(A.primer_nombre, ' ', A.segundo_nombre, ' ', A.primer_apellido, ' ', A.segundo_apellido) AS NOMBRE FROM info_colaboradores.Vista_Colaboradores_Nueva AS A ORDER BY NOMBRE");
													while($Fila = mysqli_fetch_array($Sql))
													{
														?>
															<option value="<?php echo $Fila["cif"] ?>"><?php echo $Fila["NOMBRE"] ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-center">
										<button type="button" class="btn btn-primary" onclick="Guardar()">Guardar</button>
									</div>
								</div>
								<div class="row">
									<br>
									<br>
									<br>
								</div>
								<div class="row">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>COLABORADOR</th>
												<th>ELIMINAR</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$SqlDatos = mysqli_query($db, "SELECT * FROM Bodega.COLABORADOR_FACTURA");
												while($FilaDatos = mysqli_fetch_array($SqlDatos))
												{
													?>
														<tr>
															<td><?php echo saber_nombre_colaborador($FilaDatos["CF_CIF"]) ?></td>
															<td><button type="button" class="btn btn-danger" value="<?php echo $FilaDatos[CF_CIF] ?>" onclick="EliminarColaborador(this.value)"><span class="glyphicon glyphicon-remove"></span></button></td>
														</tr>
													<?php
												}
											?>
										</tbody>
									</table>
								</div>
							</form>
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
		<script src="../../../../../libs/alertify/js/alertify.js"></script>
		<!-- END JAVASCRIPT -->

		<script>
			function Guardar()
			{
				if($('#FMRAgregar')[0].checkValidity())
				{
					$.ajax({
							url: 'AgregarColaboradorFactura.php',
							type: 'post',
							data: $('#FMRAgregar').serialize(),
							success: function (data) {
								if(data == 1)
								{
									window.location.reload();
								}
								else
								{
									alertify.error('No se pudo agregar el colaborador');
								}
							}
						});
				}
			}
			function EliminarColaborador(x)
			{
				$.ajax({
						url: 'EliminarColaborador.php',
						type: 'post',
						data: 'CIF='+x,
						success: function (data) {
							if(data == 1)
							{
								window.location.reload();
							}
							else
							{
								alertify.error('Hubo un error');
							}
						}
					});
			}
		</script>

	</body>
	</html>
