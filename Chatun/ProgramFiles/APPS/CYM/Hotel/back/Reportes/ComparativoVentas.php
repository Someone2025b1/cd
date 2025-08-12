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
	<title>Portal Institucional Chatún</title>

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
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>
	
	<!-- END JAVASCRIPT -->
	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<!-- Resources -->
<script src="graficas/core.js"></script>
<script src="graficas/charts.js"></script>
<script src="graficas/animated.js"></script>
	<!-- END STYLESHEETS -->

	<style type="text/css">
        .fila-base{
            display: none;
        }
    	.suggest-element{
    		
    		margin-top:5px;
    		width:350px;
    		cursor:pointer;
    	}
    	#suggestions {
    		width:auto;
    		height:auto;
    		overflow: auto;
    	}
    </style>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<br>
				<div class="card">
					<div class="card-head style-primary">
							<h3 class="text-center"><strong>Comparativo Ventas</strong></h3>
						</div>
						<div class="card-body">
							<div class="row text-center"> 
								<div class="col-lg-3">
									<div class="form-group">
										<label for="NombreHotel"><h3>Filtro</h3></label>
										<select name="SelectHotel" class="form-control" id="SelectHotel" required onChange="optionSelect(this.value)">
										 <option disabled="" selected>Seleccione una opción</option> 		
										 <option value="1">Día</option>
										 <option value="2">Mes</option>
										 <option value="3">Año</option>
										 <option value="4">Rango</option> 
										</select>
									</div>
								</div>	
								<div class="col-lg-3">
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
								<div class="col-lg-3">
									<div id="divDia2" style="display: none;">
										<label for="dia2"><h3>Día 2</h3></label>
										<input type="date" id="dia2" name="dia2" class="form-control" />
									</div>
									<div id="divMes2" style="display: none;">
										<label for="mes2"><h3>Mes 2</h3></label>
										<input type="month" id="mes2" name="mes2" class="form-control" />
									</div>
									<div id="divAnio2" style="display: none;">
										<label for="anio2"><h3>Año 2</h3></label>
										<input type="number" id="anio2" name="anio2" class="form-control" />
									</div>
									<div id="divRango2" style="display: none;">
										<label for="fechaInicial"><h3>Fecha Inicial 2</h3></label>
										<input type="date" id="fechaInicial2" name="fechaInicial2" class="form-control" />
										<label for="fechaFinal"><h3>Fecha Final 2</h3></label>
										<input type="date" id="fechaFinal2" name="fechaFinal2" class="form-control" />
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
					<div id="AjaxDetalleTicket"></div>							
				</div>
			</div>
		</div>
	
 

		</div><!-- END CONTENT -->
		
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>
	</div><!--end #base-->
	<!-- END BASE -->
	<script>
		function verDetalle()
		{
			var mes = $("#mes").val();
			var dia = $("#dia").val();
			var anio = $("#anio").val(); 
			var fechaInicial = $("#fechaInicial").val();
			var fechaFinal = $("#fechaFinal").val();
			var mes2 = $("#mes2").val();
			var dia2 = $("#dia2").val();
			var anio2 = $("#anio2").val(); 
			var fechaInicial2 = $("#fechaInicial2").val();
			var fechaFinal2 = $("#fechaFinal2").val();
			
			 	 $.ajax({
				url: 'Ajax/GrupComparativoVentas.php',
				type: 'POST',
				data: {mes:mes, dia: dia, anio: anio, fechaFinal:fechaFinal, fechaInicial:fechaInicial, mes2:mes2, dia2: dia2, anio2: anio2, fechaFinal2:fechaFinal2, fechaInicial2:fechaInicial2, },
				beforeSend: function()
				{
					$('#GifCargando').show();
				},
				success: function(data)
				{
					if(data)
					{
						$('#GifCargando').hide();
						$('#ReporteGenerado').show('fast');
						$('#AjaxDetalleTicket').html(data);
						var mes = $("#mes").val("");
						var dia = $("#dia").val("");
						var anio = $("#anio").val(""); 
						var fechaInicial = $("#fechaInicial").val("");
						var fechaFinal = $("#fechaFinal").val("");
						var mes2 = $("#mes2").val("");
						var dia2 = $("#dia2").val("");
						var anio2 = $("#anio2").val(""); 
						var fechaInicial2 = $("#fechaInicial2").val("");
						var fechaFinal2 = $("#fechaFinal2").val("");
					}
				}
				})
		}

	function optionSelect(x)
	{ 
		if (x==1) 
		{
			$("#divDia").show();
			$("#divMes").hide();
			$("#divAnio").hide(); 
			$("#divRango").hide(); 
			$("#divDia2").show();
			$("#divMes2").hide();
			$("#divAnio2").hide();
			$("#divRango2").hide(); 
		}
		else if(x==2)
		{
			$("#divDia").hide();
			$("#divMes").show();
			$("#divAnio").hide(); 
			$("#divRango").hide();
			$("#divDia2").hide();
			$("#divMes2").show();
			$("#divAnio2").hide(); 
			$("#divRango2").hide();
		}
		else if(x==3)
		{
			$("#divDia").hide();
			$("#divMes").hide();
			$("#divAnio").show();
			$("#divRango").hide();
			$("#divDia2").hide();
			$("#divMes2").hide();
			$("#divAnio2").show();
			$("#divRango2").hide(); 
		} 
		else if(x==4)
		{
			$("#divDia").hide();
			$("#divMes").hide();
			$("#divAnio").hide();
			$("#divRango").show();
			$("#divDia2").hide();
			$("#divMes2").hide();
			$("#divAnio2").hide();
			$("#divRango2").show(); 
		} 
		$("#divBoton").show();
	}
	</script>

	</body>
	</html>
