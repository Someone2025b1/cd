<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
include("../../../../Script/conex_a_coosajo.php");
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
					<h3>Ingreso No Asociado</h3>		
				</header>

				<div class="row">	

						<div class="col-lg-5">	
							
						  <form id="frm_ingreso_no_asociado">

							<div class="form-group">									 
									<label for="nombre_no_asociado">
										Nombres
									</label>
									<input type="text" class="form-control" id="nombre_no_asociado" />
							</div>
							
							<div class="form-group">									 
									<label for="lugar_origen">
										Lugar de Origen
									</label>
									<?php 
										$departamentos = mysql_query("select * from info_base.departamentos_guatemala", $dbc);
									?>
									<select name="select_lugar_origen" id="select_lugar_origen" class="form-control">
										<option value="<?php ?>">SELECCIONE UNA OPCIÓN</option>
									<?php 
											while($departamentos_result = mysql_fetch_array($departamentos))
											{
									?>
										<option value="<?php echo $departamentos_result['id_departamento']?>"><?php echo utf8_encode($departamentos_result['nombre_departamento'])?></option>
									<?php 
											}
									?>
									</select>
							</div>

							<div class="form-group">									 
									<label for="">
										Visitas al Parque
									</label>
									<div class="input-group">
									    <input type="number" step="any" min="0" class="form-control" placeholder="Veces" id="numero_visitas"/>
									    <span class="input-group-addon">-</span>
									    <select value="" class="form-control" id="select_frecuencia_ingreso">
									    	<option value="0">SELECCIONE UNA OPCIÓN</option>
									    	<option value="1">Diaria</option>
									    	<option value="2">Semanal</option>
									    	<option value="3">Mensual</option>
									    	<option value="4">Anual</option>
									    </select>
									</div>
							</div>

							<div class="form-group">									 
									<label for="lugar_origen">
										Medio de información
									</label>

									<select name="select_medio_informacion" id="select_medio_informacion" class="form-control">
										<option value="0">SELECCIONE UNA OPCIÓN</option>
										<option value=""></option>
									</select>							
							</div>

							<div class="form-group">									 
									<label for="">
										Correo electrónico
									</label>								
								    <input type="email" class="form-control" placeholder="Email" id="correo_electronico"/>						
							</div>

							<div class="form-group">									 
									<label for="">
										Teléfono(s)
									</label>								
								    <div class="input-group">
									    <input type="number" step="any" min="0" class="form-control" placeholder="Principal" id="numero_telefono_p"/>
									    <span class="input-group-addon">-</span>
									    <input type="number" step="any" min="0" class="form-control" placeholder="Secundario" id="numero_telefono_s"/>
									</div>
							</div>

							<div class="form-group">									 
									<label for="">
										Qué busca en un centro de atracción turístico
									</label>								
								    <textarea class="form-control" rows="3" id="atraccion_turistica"></textarea>
							</div>

							</form>

						</div> <!-- fin col-lg-4 col-md-6 -->

						<div class="col-lg-5">
							
							<div align="center" class="form-group">
								<button type="button" class="btn ink-reaction btn-primary" id="btn_agregar_servicio">
									<i class="fa fa-plus-circle" aria-hidden="true"> <a href="#">Agregar Servicios</a></i>
								</button>
							</div>

							<div class="form-group" id="div_tipo_servicio">									 
									<label for="">
										Tipo de Servicio
									</label>								
								    <select name="select_tipo_servicio" id="select_tipo_servicio" class="form-control">
								    	<option value="0">SELECCIONE UNA OPCIÓN</option>
								    	<?php 
								   	  $servicios = mysql_query("SELECT * FROM Taquilla.TIPO_SERVICIO TS_NOMBRE_SERVICIO order by TS_NOMBRE_SERVICIO asc", $db);
								    	  while($servicios_result = mysql_fetch_array($servicios)){
								    	?>
								    	<option value="<?php echo $servicios_result['TS_ID_SERVICIO']?>"><?php echo $servicios_result['TS_NOMBRE_SERVICIO']?></option>
								    	<?php 
								    		}
								    	?>
								    </select>
							</div>

						</div>
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


<div class="modal fade" id="modal_servicios">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Agregar Servicios</h4>
			</div>
			<div class="modal-body">
				<div id="ajax_modal_servicio"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary">Guardar</button>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#nombre_no_asociado').focus();
});

$('#nombre_no_asociado').blur(function(event) {
	var nombre_no_asociado = $("#nombre_no_asociado").val().length;
	if(nombre_no_asociado < 1)
	 {
		//alertify.error('Es necesario un nombre');
		//$('#btn_agregar_servicio').hide();
		//$('#div_tipo_servicio').hide();
		//$('#nombre_no_asociado').focus();
	 }//fin if
	   else
	    {
		// $('#btn_agregar_servicio').show();
		}//fin else
});

	$('#select_lugar_origen').change(function(event) { //realiza focus en numero de visitas frecuencias
		$('#numero_visitas').focus();
	});

	$('#btn_agregar_servicio').click(function(event) { //muestra el tipo de servicio a elegir
		$('#div_tipo_servicio').show('fast');
	});

	$('#select_tipo_servicio').change(function(event) {
		var tipo_servicio = $('#select_tipo_servicio').val();
		$('#modal_servicios').modal({backdrop: 'static', keyboard: false})  //desactivo que no puedan clickar afuera
		
		$.ajax({
			url: 'ModalServicios.php',
			type: 'POST',
			data: {tipo_servicio: tipo_servicio},
			success: function(ajax_modal_servicio){
				$('#ajax_modal_servicio').html(ajax_modal_servicio);
			}
		})

	});
</script>

	</body>
	</html>
