<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
include("../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$MesC = $_GET["Mes"];
$Anho = $_GET["anho"];
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
	<script src="../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../libs/alertify/js/alertify.js"></script>
	<script src="../../../../libs/bootstrap-table/js/bootstrap-table.min.js"></script>
	<script src="../../../../libs/bootstrap-table/1.11.1/extensions/export/bootstrap-table-export.js"></script>
	<script src="../../../../libs/tableExport.jquery.plugin-master/tableExport.min.js"></script>
	<script src="../../../../libs/tableExport.jquery.plugin-master/libs/es6-promise/es6-promise.auto.min.js"></script>
	<script src="../../../../libs/tableExport.jquery.plugin-master/libs/jsPDF/jspdf.min.js"></script>
	<script src="../../../../libs/tableExport.jquery.plugin-master/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
	<script src="../../../../libs/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script>
	<script src="../../../../libs/tableExport.jquery.plugin-master/libs/pdfmake/pdfmake.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../libs/bootstrap-table/css/bootstrap-table.min.css">
	<link type="text/css" rel="stylesheet" href="../../../../libs/bootstrap-table/1.11.1/extensions/filter-control/bootstrap-table-filter-control.css">
	<!-- END STYLESHEETS -->


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php 

		include("../../../../MenuTop.php") ;



$QueryDetalle = mysqli_query($db, "SELECT b.TRA_CODIGO, b.TRAD_CODIGO, b.N_CODIGO   
FROM Contabilidad.TRANSACCION a
INNER JOIN Contabilidad.TRANSACCION_DETALLE  b ON b.TRA_CODIGO = a.TRA_CODIGO
WHERE a.TRA_FECHA_HOY = '2022-04-13' AND a.TT_CODIGO =  21 
AND b.TRAD_ABONO_CONTA > 0 AND b.N_CODIGO = '1.01.01.006' 
 
 ");
$Con = 1;
											while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
											{  

												$QueryDetalle1 = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION_DETALLE SET N_CODIGO = '4.01.05.001' where TRAD_CODIGO = '$FilaDetalle[TRAD_CODIGO]' AND TRAD_ABONO_CONTA > 0 AND N_CODIGO = '1.01.01.006'");
												echo $Con++;
}
											    ?> 
	<!-- END BASE -->
	</body>
	</html>
