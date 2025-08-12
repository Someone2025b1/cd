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
	
	<script>
	function ComprobarNumero(x)
	{

		$.ajax({
			url: 'BuscarResolucion.php',
			type: 'POST',
			data: 'id='+x,
			success: function(opciones)
			{
				if(parseFloat(opciones) > 0)
				{
					$('#DIVCIF').removeClass('has-success has-error has-feedback');
					$('#SpanCIF').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

					$('#DIVCIF').addClass('has-error has-feedback');
					$('#SpanCIF').addClass('glyphicon glyphicon-remove form-control-feedback');
					$('#EMCIF').html('El Número de Resolución ya está registrado');
					$('#BtnEnviar').prop("disabled", true);
				}
				else
				{	$('#DIVCIF').removeClass('has-success has-error has-feedback');
					$('#SpanCIF').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

					$('#DIVCIF').addClass('has-success has-feedback');
					$('#SpanCIF').addClass('glyphicon glyphicon-ok form-control-feedback');
					$('#EMCIF').html('');
					$('#BtnEnviar').prop("disabled", false);
				}
			},
			error: function(opciones)
			{
				alert('Error'+opciones);
			}
		})
	}
	function ComprobarSerie(x)
	{
		$('#Serie').val(x.toUpperCase());
		$.ajax({
			url: 'BuscarSerie.php',
			type: 'POST',
			data: 'id='+x,
			success: function(opciones)
			{
				if(opciones == 0)
				{
					$('#RangoInicial').val(1);
				}
				else
				{
					$('#RangoInicial').val(opciones);
				}
			},
			error: function(opciones)
			{
				alert('Error'+opciones);
			}
		})
	}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Resoluciones</strong><br></h1>
				<br>
				<form class="form" action="ResAddPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales de la Resolución</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
											<input class="form-control" type="text" name="NumeroResolucion" id="NumeroResolucion" onchange="ComprobarNumero(this.value)" required/>
											<label for="NumeroResolucion">Número de Resolución</label>
											<span id="SpanCIF"></span>
										</div>
										<em id="EMCIF"></em>
									</div>
									<div class="col-lg-8" id="DIVResultado"></div>
								</div>
								<div class="row">
									<div class="col-lg-2">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaResolucion" id="FechaResolucion" required/>
											<label for="FechaResolucion">Fecha de Resolución</label>
										</div>
									</div>
								</div> 
								<div class="row" >
									<div class="col-lg-2">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Serie" id="Serie" onchange="ComprobarSerie(this.value)" required/>
											<label for="Serie"># de Serie</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-2">
										<div class="form-group">
											<input class="form-control" type="number" name="RangoInicial" id="RangoInicial" min="0" required readonly />
											<label for="RangoInicial">Rando Inicial (Del)</label>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="RangoFinal" id="RangoFinal" min="0" required/>
											<label for="RangoFinal">Rango Final (Al)</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaVencimientoResolucion" id="FechaVencimientoResolucion" required/>
											<label for="FechaVencimientoResolucion">Fecha de Vencimiento de Resolución</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="TipoDocumento" id="TipoDocumento" required/>
											<label for="TipoDocumento">Tipo de Documento</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select class="form-control" name="Tipo" required>
												<option value="" selected disable>Seleccione una opción</option>
												<option value="HS">Helados</option>
												<option value="KR">Kiosko Restaurante</option>
												<option value="KR2">Kiosko Restaurante 2</option>
												<option value="TR">Restaurante</option>
												<option value="SV">Souvenirs</option>
												<option value="TQ">Taquilla</option>
												<option value="EV">Eventos</option>
											</select>
										</div>
										<label for="Tipo">De</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="BtnEnviar">Guardar</button>
					</div>
					<br>
					<br>
				</form>
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

	</body>
	</html>
