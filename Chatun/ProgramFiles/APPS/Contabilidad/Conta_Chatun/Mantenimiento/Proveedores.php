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

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->
</head>
<body>


	<div class="col-lg-12">
		<h2 class="text-center"><strong>Seleccione un Proveedor</strong></h2>
		<br>
		<div class="text-right">
			<button type="button" class="btn btn-danger btn-sm" onclick="window.close()">
				<span class="glyphicon glyphicon-remove"></span> Cerrar
			</button>
    	</div>
		<table class="table table-hover table-condensed">
			<thead>
				<tr>
					<th><h6><strong>Cta. Contable</strong></h6></th>
					<th><h6><strong>Nombre</strong></h6></th>
					<th><h6><strong>NIT</strong></h6></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i = 1;
					$Consulta = "SELECT * FROM Contabilidad.PROVEEDOR ORDER BY P_CODIGO";
					$Resultado = mysqli_query($db, $Consulta);
					while($row = mysqli_fetch_array($Resultado))
					{
						echo '<tr>';
							echo '<td><h6>'.$row["P_CODIGO"].'</h6></td>';
							echo '<td><h6>'.$row["P_NOMBRE"].'</h6></td>';
							echo '<td><h6>'.$row["P_NIT"].'</h6></td>';
						echo '</tr>';
						$i++;
					}
				?>
			</tbody>
		</table>
	</div>


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
