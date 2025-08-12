<?php
include("../Script/seguridad.php");
include("../Script/conex.php");
include("../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$base_general = 'info_base';
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
		<link type="text/css" rel="stylesheet" href="../css/theme-4/bootstrap.css" />
		<link type="text/css" rel="stylesheet" href="../css/theme-4/materialadmin.css" />
		<link type="text/css" rel="stylesheet" href="../css/theme-4/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="../css/theme-4/material-design-iconic-font.min.css" />
		<!-- END STYLESHEETS -->
	</head>
	<body class="menubar-hoverable header-fixed menubar-pin ">

		<?php include("MenuTop.php") ?>

		<!-- BEGIN BASE-->
		<div id="base">

			<!-- BEGIN CONTENT-->
			<div id="content" style="margin-left: -125px">
				<table class="table table-responsive" align="center" >
					<?php
						$sql = mysqli_query($db, "SELECT A.id_departamento, B.nombre_depto, B.link_pagina, B.link_imagen FROM ".$base_general.".define_integrantes_departamentos AS A LEFT JOIN ".$base_general.".departamentos AS B ON A.id_departamento = B.id_depto WHERE A.id_user = '$id_user' ORDER BY B.nombre_depto ASC");
						$i = 0;

						while ($permisos = mysqli_fetch_row($sql)) 
						{
							$link = "APPS/".$permisos[2]."?id_depto=".$permisos[0];
							$i++;

							if ($i == 1) 
							{
								echo '<tr>';
							}
							if ($i <= 5) 
							{
								echo '<td align="center" ><a href="'.$link.'"><img width="128" height="128" class="img-rounded" src="APPS/IDT/Imagenes/Departamentos/'.$permisos[3].'"><br><h4>'.$permisos[1].'</h4></a></td>';
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
				<table class="table table-responsive" align="center" >
					<?php
						$sqlpredeterminados = mysqli_query($db, "SELECT a.* FROM info_bbdd.aplicaciones AS a INNER JOIN info_base.define_aplicaciones_predeterminados as b ON a.id_aplicacion = b.id_aplicacion WHERE a.estado = 1 ORDER BY a.nombre");
						$i = 0;

						while ($rowapp = mysqli_fetch_array($sqlpredeterminados)) 
						{
							$link = "APPS/General/".$rowapp['link'];
							$i++;

							if ($i == 1) 
							{
								echo '<tr>';
							}
							if ($i <= 5) 
							{
								echo '<td align="center" ><a href="'.$link.'"><img width="128" height="128" class="img-rounded" src="APPS/IDT/Imagenes/Aplicaciones/'.$rowapp['icono'].'"><br><h4>'.$rowapp['nombre'].'</h4></a></td>';
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
				<table class="table table-responsive" align="center" >
					<?php
						$sqlpredeterminados = mysqli_query($db, "SELECT A.* 
															FROM info_base.define_grupos AS A
															INNER JOIN info_base.define_integrantes_grupos AS B
															ON A.id_grupo = B.id_grupo
															WHERE B.id_user = '$id_user'");
						$i = 0;

						while ($rowapp = mysqli_fetch_array($sqlpredeterminados)) 
						{
							$Grupo = $rowapp["id_grupo"];
							$link = "Grupos_Especiales.php?Grupo=".$Grupo;
							$i++;

							if ($i == 1) 
							{
								echo '<tr>';
							}
							if ($i <= 5) 
							{
								echo '<td align="center" ><a href="'.$link.'"><img width="128" height="128" class="img-rounded" src="APPS/IDT/Imagenes/Grupos/'.$rowapp['icono'].'"><br><h4>'.$rowapp['nombre_grupo'].'</h4></a></td>';
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
		<script src="../js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../js/libs/spin.js/spin.min.js"></script>
		<script src="../js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
		<script src="../js/core/source/App.js"></script>
		<script src="../js/core/source/AppNavigation.js"></script>
		<script src="../js/core/source/AppOffcanvas.js"></script>
		<script src="../js/core/source/AppCard.js"></script>
		<script src="../js/core/source/AppForm.js"></script>
		<script src="../js/core/source/AppNavSearch.js"></script>
		<script src="../js/core/source/AppVendor.js"></script>
		<script src="../js/core/demo/Demo.js"></script>
		<!-- END JAVASCRIPT -->

	</body>
</html>
