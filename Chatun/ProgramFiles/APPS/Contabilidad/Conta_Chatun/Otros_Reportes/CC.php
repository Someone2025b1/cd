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
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

	<script>
	function EnviarForm()
	{
		var Opcion = $('#TipoCierre').val();
		var Formulario = $('#FormularioEnviar');
		if(Opcion == 1)
		{
			$(Formulario).attr('action', 'CCPro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 2)
		{
			$(Formulario).attr('action', 'CCSPro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 3)
		{
			$(Formulario).attr('action', 'CCHPro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 4)
		{
			$(Formulario).attr('action', 'CCKPro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 5)
		{
			$(Formulario).attr('action', 'CCTPro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 6)
		{
			$(Formulario).attr('action', 'CCT2Pro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 7)
		{
			$(Formulario).attr('action', 'CC2Pro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 8)
		{
			$(Formulario).attr('action', 'CCEPro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 9)
		{
			$(Formulario).attr('action', 'CCHCPro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 10)
		{
			$(Formulario).attr('action', 'CCPesPro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 11)
		{
			$(Formulario).attr('action', 'CCKO.php');
			$(Formulario).submit();
		}
		else if(Opcion == 12)
		{
			$(Formulario).attr('action', 'JG.php');
			$(Formulario).submit();
		}
		else if(Opcion == 13)
		{
			$(Formulario).attr('action', 'CCTPro2.php');
			$(Formulario).submit();
		}
		else if(Opcion == 14)
		{
			$(Formulario).attr('action', 'CCTPro3.php');
			$(Formulario).submit();
		}
		else if(Opcion == 15)
		{
			$(Formulario).attr('action', 'CCSPro2.php');
			$(Formulario).submit();
		}
		else if(Opcion == 16)
		{
			$(Formulario).attr('action', 'CCKO4.php');
			$(Formulario).submit();
		}
		else if(Opcion == 17)
		{
			$(Formulario).attr('action', 'CCTPro4.php');
			$(Formulario).submit();
		}

		else if(Opcion == 18)
		{
			$(Formulario).attr('action', 'CCPro2.php');
			$(Formulario).submit();
		}
		else if(Opcion == 19)
		{
			$(Formulario).attr('action', 'CC21KPro.php');
			$(Formulario).submit();
		}
		else if(Opcion == 20)
		{
			$(Formulario).attr('action', 'CCPizzeriaPro.php');
			$(Formulario).submit();
		}
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
				<form class="form" method="POST" role="form" id="FormularioEnviar">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Corte de Caja</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<div class="col-lg-6">
										<div class="form-group">
											<div class="input-daterange input-group" id="demo-date-range">
												<div class="input-group-content">
													<input type="date" class="form-control" name="FechaInicio" value="<?php echo date('Y-m-d') ?>">
													<label>Fecha del Corte</label>
												</div>
											</div>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="row text-center">
									<div class="col-lg-6">
										<div class="form-group">
											<select class="form-control" name="TipoCierre" id="TipoCierre">
												<option value="" disabled selected>Seleccione una Opción</option>
												<option value="3">Helados</option>
												<option value="4">Café los Abuelos</option>
												<option value="6">Kiosko</option>
												<option value="5">Taquilla</option>
												<option value="1">Las Terrazas</option>
												<option value="18">Las Terrazas #2</option>
												<option value="2">Souvenirs</option>
												<option value="20">Pizzería</option>
												<option value="7">Mirador</option>
												<option value="8">Eventos</option>
												<option value="9">Hoteles</option> 
												<option value="10">Tilapia</option> 
												<option value="11">Kiosko Oasis</option>
												<option value="12">Juegos</option>
												<option value="13">Taquilla #2</option>
												<option value="14">Taquilla #3</option>
												<option value="17">Taquilla #4</option>
												<option value="15">Souvenirs #2</option>
												<option value="16">Kiosko Pasillo</option>
												<option value="19">21K</option>
											</select>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="col-lg-12" align="center">
									<button type="button" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" onclick="EnviarForm()">Consultar</button>
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
		
		<?php include("../MenuUsers.html"); ?>

		<!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Resultados de su búsqueda</h2>
                    </div>
                    <div class="modal-body">
                    	<div id="suggestions" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
