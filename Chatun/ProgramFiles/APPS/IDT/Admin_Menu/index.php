<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$sql = mysqli_query($db, "SELECT A.id_aplicacion, B.nombre, B.icono, B.link FROM info_base.define_aplicaciones_departamentos AS A LEFT JOIN info_bbdd.aplicaciones AS B ON A.id_aplicacion = B.id_aplicacion WHERE A.id_departamento = $id_depto AND B.estado = 1") or die (mysqli_error());
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
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<!-- END STYLESHEETS -->
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content" style="margin-left: -125px">
			
		</div>
			<div class="list-results">
			<!-- END CONTENT -->
				<?php
					$Query = mysqli_query($db, "SELECT A.id_aplicacion, A.icono, A.nombre
										FROM info_bbdd.aplicaciones AS A");
					while($Fila = mysqli_fetch_array($Query))
					{
						?>
							<a style="cursor: pointer;" href="Administracion.php?Codigo=<?php echo $Fila[id_aplicacion] ?>">
								<div class="col-lg-3">
									<div class="col-xs-12 col-lg-6 hbox-xs">
										<div class="hbox-column width-2">
											<img class="img-circle img-responsive pull-left" src="<?php echo '../Imagenes/Aplicaciones/'.$Fila[icono] ?>" alt="">
										</div><!--end .hbox-column -->
										<div class="hbox-column v-top">
											<div class="clearfix">
												<div class="col-lg-12 margin-bottom-lg">
													<a class="text-lg text-sm"><?php echo $Fila[nombre] ?></a>
												</div>
											</div>
										</div><!--end .hbox-column -->
									</div>
								</div>
							</a>
						<?php
					}
				?>
			</div>
		</div><!--end #base-->
		<!-- END BASE -->

		<!-- BEGIN JAVASCRIPT -->
		<script src="../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../../../../js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../../../js/libs/spin.js/spin.min.js"></script>
		<script src="../../../../js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
		<script src="../../../../js/core/source/App.js"></script>
		<script src="../../../../js/core/source/AppNavigation.js"></script>
		<script src="../../../../js/core/source/AppOffcanvas.js"></script>
		<script src="../../../../js/core/source/AppCard.js"></script>
		<script src="../../../../js/core/source/AppForm.js"></script>
		<script src="../../../../js/core/source/AppNavSearch.js"></script>
		<script src="../../../../js/core/source/AppVendor.js"></script>
		<script src="../../../../js/core/demo/Demo.js"></script>
		<!-- END JAVASCRIPT -->

	</body>
	</html>
