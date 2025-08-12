<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
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
			<table align="center" class="table" id="Menu">
				<?php
				$i=1;
				while ($grupos = mysqli_fetch_row($sql)) {
					$link = $grupos[3];
					$i++;
					if ($i == 1) {
						echo '<tr>';
					}
					if ($i <= 5) {
						echo '<td><a href="'.$link.'"><img src="Imagenes/Aplicaciones/'.$grupos[2].'" width="128" height="128" border="0"></br>'.strtoupper($grupos[1]).'</a></td>';
					}
					if ($i == 5) {
						echo '</tr>';
						echo '<tr>';
						echo '</tr>';
						$i = 0;	
					}
				}
				?>
				<tr align="center">
					<td>
						<a href="definir_gerencias.php?centinela=0">
							<img src="Imagenes/Gerencias.png" alt="Definir Gerencias..." width="128" height="128" border="0">
							<br>DEFINIR GERENCIAS
						</a>
					</td>
					<td>
						<a href="definir_departamentos.php?centinela=0">
							<img src="Imagenes/Departamentos.png" alt="Departamentos..." width="128" height="128" border="0">
							<br>DEFINIR DEPARTAMENTOS
						</a>
					</td>
					<td>
						<a href="definir_aplicaciones.php?centinela=0">
							<img src="Imagenes/New Database.png" width="128" height="128" border="0">
							<br>DEFINIR APLICACIONES
						</a>
					</td>
					<td>
						<a href="ver_departamentos_app.php?centinela=0">
							<img src="Imagenes/BBDD.png" alt="Definir Bases de Datos" width="115" height="128" border="0">
							<br>PROGRAMAS POR DEPARTAMENTOS
						</a>
					</td>
				</tr>
				<tr align="center">
					<td>
						<a href="ver_grupos.php?centinela=0">
							<img src="Imagenes/grupos_especiales.png" alt="Cajero General" width="128" height="128" border="0">
							<br>DEFINIR GRUPOS ESPECIALES DE TRABAJO
						</a>
					</td>
					<td>
						<a href="ver_aplicaciones_predeterminados.php?centinela=0">
							<img src="Imagenes/database.png" alt="Cajero General" width="128" height="127" border="0">
							<br>DEFINIR PROGRAMAS PREDETERMINADOS
						</a>
					</td>
					<td>
						<a href="acceso_departamentos.php?centinela=0">
							<img src="Imagenes/Permisos.png" alt="Permisos" width="128" height="128" border="0">
							<br>PERMISOS DEL PORTAL
						</a>
					</td>
					<td>
						<a href="ConsultaColaborador.php">
							<img src="Imagenes/user-id.png" alt="Permisos" width="128" height="128" border="0">
							<br>MANTENIMIENTO DE COLABORADORES
						</a>
					</td>
				</tr>
				<tr align="center">
					<td>
						<a href="Admin_Menu/index.php">
							<img src="Imagenes/Menu.png" alt="Menu" width="128" height="128" border="0">
							<br>ADMIN. MENU APLICACIONES
						</a>
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
			</table>
		</div>
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
