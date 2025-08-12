<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
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
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.css">
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.default.css">
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">

				<header>
					<h3>Búqueda de Asociado</h3>		
				</header>

				<div class="row">	

						<div class="col-lg-4 col-md-6">	
							
								<div class="form-group">									 
									<label for="buscador">Búsqueda</label>
									<input type="text" class="form-control" id="buscador" />
									<div align="center" id="div_cargando" style="display: none">
										<img src="../Taquilla/IMG/Cargando.gif" alt="" width="75px">
									</div>
								</div>

									<div id="ajax_sugerencias" style="display:none">
										
									</div>

							<form id="frm_ingreso_asociado">

								<div class="form-group">									 
									<label for="cif_asociado">
										CIF
									</label>
									<input type="number" min="0" step="any" class="form-control" id="cif_asociado" readonly="" name="cif_asociado" />
								</div>

								<div class="form-group">									 
									<label for="nombre_asociado">
										Nombre Asociado
									</label>
									<input type="text" class="form-control" id="nombre_asociado" readonly="" name="nombre_asociado" />
								</div>

								<div class="form-group">									 
									<label for="nit_asociado">
										NIT Asociado
									</label>
									<input type="text" class="form-control" id="nit_asociado" readonly="" name="nit_asociado"/>
								</div>

								<div class="form-group">									 
									<label for="dpi_asociado">
										DPI
									</label>
									<input type="text" class="form-control" id="dpi_asociado" readonly="" name="dpi_asociado" />
								</div>

								<div class="form-group">									 
									<label for="puntos_disponibles">
										Puntos Disponibles:
									</label>
									<span class="label label-success">1</span>
								</div>
							</form>

						</div>
							<!-- fin col-lg-4" -->

						<div class="col-lg-5" style="display:none" id="div_detalle_entrada">

							<div class="form-group">									 
								<h3>Acompañantes</h3>
							</div>

								<div class="form-group">									 
									 <div class="col-xs-2">
									  <label for="ex1">Niños</label>
									  <input class="form-control" id="input_ninio" type="number" step="any" min="0">
									</div>
									 <div class="col-xs-2">
									  <label for="ex1">Adultos</label>
									  <input class="form-control" id="input_adulto" type="number" step="any" min="0">
									</div>
								</div>

						</div> <!-- cin col-lg-5 -->


						<button type="button" class="btn btn-success" id="btn_ingresar_asociado">Ingresar...</button>
				</div>				

			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->


	<!-- BEGIN JAVASCRIPT -->
	<script src="../../../../js/libs/jquery/jquery-2.0.0.min.js"></script>
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
	<script src="../../../../libs/alertify/js/alertify.min.js"></script>
	<!-- END JAVASCRIPT -->

	<script>
	$(document).ready(function()
	 {
		$('#buscador').focus(); //focus al iniciar documento
	
	});

	$('#buscador').keydown(function(e) {
		 if (e.keyCode == 9)
		  {
		  var buscador = $('#buscador').val();
		  if(buscador == 0){
		  	alertify.error('Es necesario un parámetro de búsqueda');
		  	$('#buscador').focus();
		  	$('#frm_ingreso_asociado')[0].reset();
		  	return false;
		  }
		  $.ajax({
		  	url: 'BusquedaAsociado.php',
		  	type: 'POST',
		  	dataType: 'json',
		  	data: {buscador: buscador},
		  	beforeSend: function() {
			   $('#div_cargando').show();
			  },
		  	success: function(data){
		  		if(!data){
		  			alertify.error('No existe información...');
		  			$('#div_cargando').hide('fast');
		  			$('#frm_ingreso_asociado')[0].reset();
		  			$('#div_detalle_entrada').show('fast');
		  		}else{
					JSON.stringify(data);
					$('#cif_asociado').val(data.cif_asociado);
					$('#nombre_asociado').val(data.nombre_asociado);
					$('#nit_asociado').val(data.nit_asociado);
					$('#dpi_asociado').val(data.dpi_asociado);
					$('#div_cargando').hide('fast');
					$('#div_detalle_entrada').show('fast');
					$('#input_ninio').focus();
		  		}
		  		if(data == 1){
		  			buscar_nombre();
		  		}
		  	}//fin funcion success
		  })//fin ajax
    	}//fin else e.keycode
	});	

	function buscar_nombre(){
		var buscador = $('#buscador').val();
		$.ajax({
			url: 'BusquedaAsociado.php',
			type: 'POST',
			data: {buscador: buscador},
			success: function(data){
				$('#ajax_sugerencias').show();
				alert(data);
				$('#ajax_sugerencias').html(data);
			}
		})//fin $.ajax
	}//fin funcion buscar_nombre

	$('#btn_ingresar_asociado').click(function(event) {
		var form = $('#frm_ingreso_asociado').serialize();
		$.ajax({
			url: 'IngresoAsociado.php',
			type: 'POST',
			data: form,
		})
	});
	</script>

	</body>
	</html>
