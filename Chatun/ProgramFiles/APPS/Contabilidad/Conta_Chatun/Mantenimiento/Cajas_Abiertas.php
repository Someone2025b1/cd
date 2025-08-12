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

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->
	

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Cerrar una Caja sin Cierre</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Cierres</strong></h4>
						</div>
						<div class="card-body">
							<?php
								$Query = mysqli_query($db, "SELECT A.ACC_FECHA, B.B_NOMBRE, A.ACC_SALDO_INICIAL, A.ACC_HORA_APERTURA, A.ACC_USUARIO_APERTURA, A.ACC_CODIGO
														FROM Bodega.APERTURA_CIERRE_CAJA AS A
														LEFT JOIN Bodega.BODEGA AS B ON A.ACC_TIPO = B.B_CODIGO
														WHERE A.ACC_ESTADO = 1
														AND A.ACC_FECHA < CURRENT_DATE()");
								$Query1 = mysqli_query($db, "SELECT A.ACC_FECHA, B.B_NOMBRE, A.ACC_SALDO_INICIAL, A.ACC_HORA_APERTURA, A.ACC_USUARIO_APERTURA, A.ACC_CODIGO
														FROM Bodega.APERTURA_CIERRE_CAJA AS A
														LEFT JOIN Bodega.BODEGA AS B ON A.ACC_TIPO = B.B_CODIGO
														WHERE A.ACC_ESTADO = 1
														AND A.ACC_FECHA < CURRENT_DATE()");
								$Registros = mysqli_num_rows($Query1);

								if($Registros > 0)
								{
									?>
										<table class="table table-hover table-condensed">
											<thead>
												<tr>
													<th><h5><strong>FECHA</strong></h5></th>
													<th><h5><strong>PUNTO VENTA</strong></h5></th>
													<th><h5><strong>SALDO INICIAL</strong></h5></th>
													<th><h5><strong>HORA APERTURA</strong></h5></th>
													<th><h5><strong>USUARIO APERTURÓ</strong></h5></th>
												</tr>
											</thead>
											<tbody>
											<?php
												while($Fila = mysqli_fetch_array($Query))
												{
													?>
														<tr>
															<td><h6><?php echo date('d-m-Y', strtotime($Fila['ACC_FECHA'])) ?></h6></td>
															<td><h6><?php echo $Fila['B_NOMBRE'] ?></h6></td>
															<td><h6><?php echo number_format($Fila['ACC_SALDO_INICIAL'], 2) ?></h6></td>
															<td><h6><?php echo $Fila['ACC_HORA_APERTURA'] ?></h6></td>
															<td><h6><?php echo utf8_encode(saber_nombre_asociado_orden($Fila['ACC_USUARIO_APERTURA'])) ?></h6></td>
															<td><button value="<?php echo $Fila[ACC_CODIGO] ?>" onclick="CerrarCaja(this.value)" type="button" class="btn btn-warning"> Cerrar </button></td>
														</tr>
													<?php
												}
											?>
											</tbody>
										</table>
									<?php
								}
								else
								{
									?>
										<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light"><i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">No existen cajas abiertas</h2>
										</div>
									<?php
								}
							?>
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

	<script>
		function CerrarCaja(x)
		{
			$.ajax({
				url: 'CerrarCaja.php',
				type: 'post',
				data: 'Codigo='+x,
				success: function (data) {
					if(data == 1)
					{
						window.location.reload();
					}
					else
					{
						alertify.error('No se pudo cerrar la caja');
					}
				}
			});
		}
	</script>

	</body>
	</html>
