<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$Departamento = $_GET["id_depto"];
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
		<link type="text/css" rel="stylesheet" href="../../../css/theme-4/bootstrap.css" />
		<link type="text/css" rel="stylesheet" href="../../../css/theme-4/materialadmin.css" />
		<link type="text/css" rel="stylesheet" href="../../../css/theme-4/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="../../../css/theme-4/material-design-iconic-font.min.css" />
		<!-- END STYLESHEETS -->
	</head>
	<body class="menubar-hoverable header-fixed menubar-pin ">

		<?php include("../../MenuTop.php") ?>

		<!-- BEGIN BASE-->
		<div id="base">
			<!-- BEGIN CONTENT-->
			<div id="content" style="margin-left: -125px">
				<div class="content-fluid text-right">
				<br>
				<button type="button" class="btn ink-reaction btn-primary">
					<i class="fa fa-chevron-left"> <a href="../../index.php">Regresar</a></i>
				</button>
				<br>
				<br>
			</div>
				<table class="table table-responsive" align="center" >
					<?php
						$sql = mysqli_query($db, "SELECT A.nombre, A.icono, A.LINK, B.id_departamento FROM info_bbdd.aplicaciones AS A, info_base.define_aplicaciones_departamentos AS B WHERE A.id_aplicacion = B.id_aplicacion AND B.id_departamento = ".$_GET["id_depto"]." ORDER BY A.nombre");
						$i = 0;

						while ($permisos = mysqli_fetch_row($sql)) 
						{
							$link = $permisos[2];
							$i++;

							if ($i == 1) 
							{
								echo '<tr>';
							}
							if ($i <= 5) 
							{
								echo '<td align="center" ><a href="'.$link.'"><img width="128" height="128" class="img-rounded" src="../../APPS/IDT/Imagenes/Aplicaciones/'.$permisos[1].'"><br><h4>'.$permisos[0].'</h4></a></td>';
							}
							if ($i == 5) 
							{
								echo '</tr>';
								echo '<tr>';
								echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
								echo '</tr>';
								$i = 0;	
							}
						}
					?>
				</table>
			</div><!--end #content-->
			<!-- END CONTENT -->

		</div><!--end #base-->
		<!-- END BASE -->

		<!-- BEGIN JAVASCRIPT -->
		<script src="../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../../../js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../../js/libs/spin.js/spin.min.js"></script>
		<script src="../../../js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
		<script src="../../../js/core/source/App.js"></script>
		<script src="../../../js/core/source/AppNavigation.js"></script>
		<script src="../../../js/core/source/AppOffcanvas.js"></script>
		<script src="../../../js/core/source/AppCard.js"></script>
		<script src="../../../js/core/source/AppForm.js"></script>
		<script src="../../../js/core/source/AppNavSearch.js"></script>
		<script src="../../../js/core/source/AppVendor.js"></script>
		<script src="../../../js/core/demo/Demo.js"></script>
		<!-- END JAVASCRIPT -->

	</body>
</html>
