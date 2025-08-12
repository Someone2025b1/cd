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
	<!-- END STYLESHEETS -->

	<style type="text/css">
        .fila-base{
            display: none;
        }
    	.suggest-element{
    		margin-left:5px;
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
				<form class="form" id="">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Ingreso de Asociados</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<div class="col-lg-3"></div>
									<div class="col-lg-6">
										<div class="form-group">
											<select name="SelectMes" class="form-control" id="SelectMes" required>
												<option value="x" selected>Seleccione una opción</option>
												<option value="1">Enero</option>
												<option value="2">Febrero</option>
												<option value="3">Marzo</option>
												<option value="4">Abril</option>
												<option value="5">Mayo</option>
												<option value="6">Junio</option>
												<option value="7">Julio</option>
												<option value="8">Agosto</option>
												<option value="9">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
											<label for="Mes">Mes</label>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
										
										<div class="row">
											<div class="col-lg-5"></div>
											<div class="col-lg-2">
											  <label for="Anho">Año</label>								
											  <input type="number" name="anio" id="anio" class="form-control" value="" required="required" pattern="\d{4}" maxlength="4">
											</div>
										</div><br>
									
								<div class="col-lg-12" align="center">
									<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnConsultar">Consultar</button><br>
							<img src="../../../../../img/Preloader.gif" width="64" height="64" style="display: none" id="GifCargando">									
								</div>
							</div>
						</div>
					</div>
					<br>
					<br>
				</form>
			</div>

<div class="container" id="ReporteGenerado" style="display: none;">
  <div class="panel-group" id="accordion">
    <div class="panel panel-primary">
      <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
        <h3 class="panel-title" align="center">
          Ingreso Diario
        </h3>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">
			<div id="AjaxReporteDia"></div>
        </div>
      </div>
    </div>
    <div class="panel panel-primary">
      <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
        <h4 class="panel-title" align="center">
          Ingreso Asociado
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
			<div id="AjaxConsultaReporte">
			</div>
        </div>
      </div>
    </div>
    <div class="panel panel-primary">
      <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
        <h4 class="panel-title" align="center">
          Ingreso No Asociado
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
        	<div id="AjaxNoAsociado"></div>
        </div>
      </div>
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
		$('#SelectMes').change(function(event) {
			$('#anio').focus();
		});

		$('#BtnConsultar').click(function(event) {
			var SelectMes = $('#SelectMes').val();
			var anio = $('#anio').val();
			if(SelectMes == "x")
			{
				alertify.error('Es necesario elegir un mes');
				$('#SelectMes').focus();
				return false;
			}
			if(anio == "")
			{
				alertify.error('Es necesario un año');
				$('#anio').focus();
				return false;
			}
			else
			{
				ReporteAsociado(SelectMes, anio);
				ReporteNoAsociado(SelectMes, anio);//llamo la funcion de no asociado
				ReporteDiario(SelectMes, anio);
				$('#ReporteGenerado').show('fast');
			}//fin else
		});//fin click btn 

function ReporteAsociado(SelectMes, anio)
{
	$.ajax({
		url: 'ConsultarReporte.php',
		type: 'POST',
		data: {SelectMes: SelectMes, anio: anio},
		 beforeSend:function(data)
		 {
		 	$('#GifCargando').show();
			 },
		success: function(data)
		{
			if(data)//si devuelve data
			{
			  $('#GifCargando').hide();
			 
			  $('#AjaxConsultaReporte').html(data);							
			}//fin if data
		}//fin funcion success
	})//fin funcion ajax
}//fin funcion reporte asociado

function ReporteNoAsociado(SelectMes, anio){
	$.ajax({
		url: 'NoAsociados.php',
		type: 'POST',
		data: {SelectMes: SelectMes, anio: anio},
		success: function(data)
		{
			$('#AjaxNoAsociado').html(data);
		}
	})	
}//finfuncion reporte no asociado

function ReporteDiario(SelectMes, anio)
{
	$.ajax({
		url: 'IngresoDia.php',
		type: 'POST',
		data: {SelectMes: SelectMes, anio: anio},
		success: function(data)
		{
			$('#AjaxReporteDia').html(data);
		}
	})//fin ajax
}//fin funcion reporte diario

	</script>
	</body>
	</html>
