<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
include("../../../../Script/funciones.php");
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
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

	<script>
	function EnviarForm()
	{
		var Opcion = $('#TipoCierre').val();
		var Formulario = $('#FormularioEnviar');
		$(Formulario).attr('action', 'SolicitudBBDD.php');
		$(Formulario).submit();
		

	}
	</script>



</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" method="POST" role="form" id="FormularioEnviar" action="SolicitudBBDD.php">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Agregar Solicitud Departamento de Desarrollo</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<div class="col-lg-6">
										<div class="form-group">
											<div width="100%" class="form-group">
											<select  align="center" class="form-control" name="Aplicacion" id="Aplicacion">
												<option value="" disabled selected>Seleccione Aplicativo</option>
												<option>Contabilidad Chatún</option>
												<option>Las Terrazas</option>
												<option>Souvenirs</option>
												<option>Bodega</option>
												<option>Helados</option>
												<option>Finanzas</option>
												<option>Café Los Abuelos</option>
												<option>Requerimiento Eventos</option>
												<option>Taquilla</option>
												<option>Bodega Mantenimiento, Papeleria y Utiles</option>
												<option>Eventos</option>
												<option>Restaurante El Mirador</option>
												<option>Hoteles</option>
												<option>Juegos</option>
												<option>Tilapia</option>
												<option>Colaboradores</option>
												<option>Pisicultura</option>
												<option>Análisis de Costos</option>
												<option>Nueva Aplicación</option>
											</select>
											
											</div>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="row text-center">
									<div class="col-lg-6">
										<div class="form-group">
										<p>Descripción: </p>
										<textarea name="Descripcion" id="Descripcion"rows="10" cols="70" placeholder="Escribe aquí la descripción de tu solicitud:"></textarea>
										
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="col-lg-12" align="center">
									<button type="button" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" onclick="EnviarForm()">Enviar</button>
								</div>
							</div>
						</div>
					</div>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("MenuUsers.html"); ?>

		

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>

	<script>
    var btn = document.querySelector('#btnGuardar');
    var btnlbl = btn.textContent;

    btn.addEventListener('click', function(e) {
    e.preventDefault();
    
    // deshabilita el botón y previene un doble clic
    this.disabled = true;
    this.textContent = 'Espere unos segundos...';
    
    // simula el proceso y reactiva el clic despues de 3 segundos
    setTimeout(function(){ btn.disabled=false; btn.textContent = btnlbl; }, 2000);
    });
</script>
