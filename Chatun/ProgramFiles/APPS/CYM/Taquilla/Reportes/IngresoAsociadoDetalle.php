<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
	<script src="../../../../../js/libs/tableexport/tableExport.js"></script>
	<!-- <script src="../../../../../js/libs/tableexport/base64.min.js"></script> -->
	<script src="../../../../../js/libs/tableexport/jquery.base64.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
<script src="../material/material-pro/assets/plugins/jquery/jquery.min.js"></script>
     <script src="../material/material-pro/assets/plugins/datatables/jquery.dataTables.min.js"></script>
 
     <script src="../material/material-pro/assets/plugins/moment/moment.js"></script>
    <script src="../material/material-pro/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="../material/material-pro/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!-- Color Picker Plugin JavaScript -->
         <!-- Bootstrap Core CSS -->
    <link href="../material/material-pro/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="../material/material-pro/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="../material/material-pro/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="../material/material-pro/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="../material/material-pro/assets/plugins/css-chart/css-chart.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="../material/material-pro/assets/plugins/c3-master/c3.min.css" rel="stylesheet">
    <!-- Vector CSS -->
    <link href="../material/material-pro/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="../material/material-pro/material/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../material/material-pro/material/css/colors/blue.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" href="../Script/alertify_bueno/alertify.core.css">
    <link rel="stylesheet" href="../Script/alertify_bueno/alertify.default.css"> 
    <script src="datatables/jquery-3.5.1.js"></script>
    <script src="datatables/jquery.dataTables.min.js"></script>
    <script src="datatables/dataTables.buttons.min.js"></script> 
    <script src="datatables/jszip.min.js"></script>
    <script src="datatables/buttons.html5.min.js"></script>
    <script src="datatables/pdf.js"></script>
    <script src="datatables/vfs_fonts.js"></script>  

	<!-- END STYLESHEETS -->

	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

<!-- BEGIN CONTENT-->
<div id="content">
<div class="container">
<form class="form" action="#"  role="form" >
<div class="col-lg-12">
<br>
<div class="card">
<div class="card-head style-primary">
<h4 class="text-center"><strong>Ingreso Asociados</strong></h4>
</div>
<div class="card-body">
<div class="row text-center"> 
	<div class="col-lg-4"> 
			<label for="SelectHotel"><h3>Filtro</h3></label>
			<select name="SelectHotel" class="form-control" id="SelectHotel" required onChange="optionSelect(this.value)">
			 <option disabled="" selected>Seleccione una opción</option> 		
			 <option value="1">Día</option>
			 <option value="2">Mes</option>
			 <option value="3">Año</option>
			 <option value="4">Rango</option> 
			</select>
	</div>	
	<div class="col-lg-6">
		<div id="divDia" style="display: none;">
			<label for="dia"><h3>Día</h3></label>
			<input type="date" id="dia" name="dia" class="form-control" />
		</div>
		<div id="divMes" style="display: none;">
			<label for="mes"><h3>Mes</h3></label>
			<input type="month" id="mes" name="mes" class="form-control" />
		</div>
		<div id="divAnio" style="display: none;">
			<label for="anio"><h3>Año</h3></label>
			<input type="number" id="anio" name="anio" class="form-control" />
		</div>
		<div id="divRango" style="display: none;">
			<label for="fechaInicial"><h3>Fecha Inicial</h3></label>
			<input type="date" id="fechaInicial" name="fechaInicial" class="form-control" />
			<label for="fechaFinal"><h3>Fecha Final</h3></label>
			<input type="date" id="fechaFinal" name="fechaFinal" class="form-control" />
		</div>
	</div>
	<div class="col-lg-2" id="divBoton" style="display: none;"><br><br>
		<button type="button" class="btn btn-info btn-circle"><i class="fa fa-check" onclick="verDetalle()"></i>
    </button>
	</div>
</div>
<div align="center">
						<img src="../../../../../img/Preloader.gif" width="64" height="64" id="GifCargando" style="display: none">		
					</div>
<div id="detalle"></div>
</form>
			 
		
		<?php include("../MenuUsers.html"); ?>

		<script>
			function verDetalle()
			{
				var mes = $("#mes").val();
				var anio = $("#anio").val();
				var fechaInicial = $("#fechaInicial").val();
				var fechaFinal = $("#fechaFinal").val();
				var dia = $("#dia").val();
				$.ajax({
						url: 'Ajax/AsociadosDetalle.php',
						type: 'post',
						data: {mes: mes, anio: anio, fechaInicial: fechaInicial, fechaFinal: fechaFinal, dia: dia},
						beforeSend: function()
						{
							$('#GifCargando').show();
						},
						success: function (data) { 
							$('#GifCargando').hide();
							$('#detalle').html(data); 
							$('#TblTicketsHotel1').DataTable( {
							    dom: 'Bfrtip',
							    buttons: [
							        'copy', 'excel', 'pdf'
							    ]
							} );
							var mes = $("#mes").val("");
							var anio = $("#anio").val("");
							var fechaInicial = $("#fechaInicial").val("");
							var fechaFinal = $("#fechaFinal").val("");
							var dia = $("#dia").val("");
						}
					});
			}
		</script>

	</div><!--end #base-->
	<!-- END BASE -->
	<script>
		function optionSelect(x)
	{ 
		if (x==1) 
		{
			$("#divDia").show();
			$("#divMes").hide();
			$("#divAnio").hide();
			$("#divRango").hide();
		}
		else if(x==2)
		{
			$("#divDia").hide();
			$("#divMes").show();
			$("#divAnio").hide();
			$("#divRango").hide();
		}
		else if(x==3)
		{
			$("#divDia").hide();
			$("#divMes").hide();
			$("#divAnio").show();
			$("#divRango").hide();
		}
		else if(x==4)
		{
			$("#divDia").hide();
			$("#divMes").hide();
			$("#divAnio").hide();
			$("#divRango").show();
		}
		$("#divBoton").show();
	}
	</script>
	</body>
	</html>
