<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
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
	
    <script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Administración Taquilla</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Programas Activos</strong></h4>
						</div>
						<div class="card-body"> 
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="nombrePrograma">Nombre del programa</label>
										<input class="form-control" type="text"  name="nombrePrograma" id="nombrePrograma" placeholder="Ej. NOMBRE" required />
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
									<button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="guardarPrograma()">GUARDAR</button>
									</div>
								</div>
							</div>
							<div class="row" id="divListadoProgramas"></div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->
			<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Áreas Utilizadas</strong></h4>
						</div>
						<div class="card-body"> 
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="nombreArea">Descripción</label>
										<input class="form-control" type="text"  name="nombreArea" id="nombreArea" placeholder="Ej. NOMBRE" required />
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
									<button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="guardarArea()">GUARDAR</button>
									</div>
								</div>
							</div>
							<div class="row" id="divListadoArea"></div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->
			<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Clasificador de Eventos</strong></h4>
						</div>
						<div class="card-body"> 
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="nombreClasificador">Descripción</label>
										<input class="form-control" type="text"  name="nombreClasificador" id="nombreClasificador" placeholder="Ej. NOMBRE" required />
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
									<button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="guardarClasificador()">GUARDAR</button>
									</div>
								</div>
							</div>
							<div class="row" id="divListadoClasificador"></div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->
			<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Eventos</strong></h4>
						</div>
						<div class="card-body"> 
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="eventos">Descripción</label>
										<input class="form-control" type="text"  name="eventos" id="eventos" placeholder="Ej. NOMBRE" required />
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
									<button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="guardarEventos()">GUARDAR</button>
									</div>
								</div>
							</div>
							<div class="row" id="divListadoEventos"></div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->
			<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Eventos Cortesía</strong></h4>
						</div>
						<div class="card-body"> 
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="eventoCortesia">Descripción</label>
										<input class="form-control" type="text"  name="eventoCortesia" id="eventoCortesia" placeholder="Ej. NOMBRE" required />
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
									<button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="guardarEventosCortesia()">GUARDAR</button>
									</div>
								</div>
							</div>
							<div class="row" id="divListadoEventosCortesia"></div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->
			<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Tipos de Referencia</strong></h4>
						</div>
						<div class="card-body"> 
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="referenciaTipo">Descripción</label>
										<input class="form-control" type="text"  name="referenciaTipo" id="referenciaTipo" placeholder="Ej. NOMBRE" required />
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
									<button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="guardarTipoReferencia()">GUARDAR</button>
									</div>
								</div>
							</div>
							<div class="row" id="divListadoReferencia"></div>
					</div>
				</div>
			</div>
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
		<script>
			$(document).ready(function() {
				verListadoPrograma();
				verListadoClasificador();
				verListadoEventosCortesia();
				verListadoEventos();
				verListadoReferencia();
				verListadoAreas();
			});
			function verListadoReferencia(){
				$.ajax({
            	url: 'Ajax/ListadoReferencia.php',
            	type: 'POST',
            	data: {},
					success: function(data)
					{
					  $("#divListadoReferencia").html(data);
					}
				})
			}
			function verListadoPrograma(){
				$.ajax({
            	url: 'Ajax/ListadoProgramas.php',
            	type: 'POST',
            	data: {},
					success: function(data)
					{
					  $("#divListadoProgramas").html(data);
					}
				})
			}
			function verListadoEventosCortesia(){
				$.ajax({
            	url: 'Ajax/ListadoEventosCortesia.php',
            	type: 'POST',
            	data: {},
					success: function(data)
					{
					  $("#divListadoEventosCortesia").html(data);
					}
				})
			}

			function verListadoEventos(){
				$.ajax({
            	url: 'Ajax/ListadoEventos.php',
            	type: 'POST',
            	data: {},
					success: function(data)
					{
					  $("#divListadoEventos").html(data);
					}
				})
			}

			function verListadoClasificador(){
				$.ajax({
            	url: 'Ajax/ListadoClasificador.php',
            	type: 'POST',
            	data: {},
					success: function(data)
					{
					  $("#divListadoClasificador").html(data);
					}
				})
			}

			function verListadoAreas(){
				$.ajax({
            	url: 'Ajax/ListadoAreas.php',
            	type: 'POST',
            	data: {},
					success: function(data)
					{
					  $("#divListadoArea").html(data);
					}
				})
			}

			function guardarTipoReferencia(){
				var referenciaTipo = $("#referenciaTipo").val();
				var tipo=5;
				$.ajax({
            	url: 'Ajax/GuardarAdmTaquilla.php',
            	type: 'POST',
            	data: {referenciaTipo: referenciaTipo, tipo:tipo},
					success: function(data)
					{
					  if (data==1) 
					  {
					  	verListadoReferencia();
					  	alertify.success("Se ha almacenado correctamente!");
					  	$("#referenciaTipo").val("");
					  }				
					}
				})
			}

			function guardarEventos(){
				var eventos = $("#eventos").val();
				var tipo=4;
				$.ajax({
            	url: 'Ajax/GuardarAdmTaquilla.php',
            	type: 'POST',
            	data: {eventos: eventos, tipo:tipo},
					success: function(data)
					{
					  if (data==1) 
					  {
					  	verListadoEventos();
					  	alertify.success("Se ha almacenado correctamente!");
					  	$("#eventos").val("");
					  }				
					}
				})
			}

			function guardarPrograma(){
				var nombrePrograma = $("#nombrePrograma").val();
				var tipo=1;
				$.ajax({
            	url: 'Ajax/GuardarAdmTaquilla.php',
            	type: 'POST',
            	data: {nombrePrograma: nombrePrograma, tipo:tipo},
					success: function(data)
					{
					  if (data==1) 
					  {
					  	verListadoPrograma();
					  	alertify.success("Se ha almacenado correctamente!");
					  	$("#nombrePrograma").val("");
					  }				
					}
				})
			}

			function guardarClasificador(){
				var nombreClasificador = $("#nombreClasificador").val();
				var tipo = 2;
				$.ajax({
            	url: 'Ajax/GuardarAdmTaquilla.php',
            	type: 'POST',
            	data: {nombreClasificador: nombreClasificador, tipo:tipo},
					success: function(data)
					{
					  if (data==1) 
					  {
					  	verListadoClasificador();
					  	alertify.success("Se ha almacenado correctamente!");
					  	$("#nombreClasificador").val("");
					  }				
					}
				})
			}

			function guardarArea(){
				var nombreArea = $("#nombreArea").val();
				var tipo = 6;
				$.ajax({
            	url: 'Ajax/GuardarAdmTaquilla.php',
            	type: 'POST',
            	data: {nombreArea: nombreArea, tipo:tipo},
					success: function(data)
					{
					  if (data==1) 
					  {
					  	verListadoAreas();
					  	alertify.success("Se ha almacenado correctamente!");
					  	$("#nombreArea").val("");
					  }				
					}
				})
			}

			function guardarEventosCortesia(){
				var eventoCortesia = $("#eventoCortesia").val();
				var tipo = 3;
				$.ajax({
            	url: 'Ajax/GuardarAdmTaquilla.php',
            	type: 'POST',
            	data: {eventoCortesia: eventoCortesia, tipo:tipo},
					success: function(data)
					{
					  if (data==1) 
					  {
					  	verListadoEventosCortesia();
					  	alertify.success("Se ha almacenado correctamente!");
					  	$("#eventoCortesia").val("");
					  }				
					}
				})
			}
		</script>
	</body>
	</html>
