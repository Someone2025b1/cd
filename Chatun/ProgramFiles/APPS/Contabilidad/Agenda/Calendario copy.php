<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


  $SqlEventos   = ("SELECT * FROM Agenda.EVENTO WHERE E_ANFITRION = $id_user");
  $Resultado = mysqli_query($db, $SqlEventos);

  $SqlEventosIn   = ("SELECT EVENTO.* FROM Agenda.EVENTO, Agenda.PARTICIPANTES WHERE EVENTO.E_CODIGO= PARTICIPANTES.E_CODIGO
  AND PARTICIPANTES.E_USUARIO = $id_user");
  $ResultadoIn = mysqli_query($db, $SqlEventosIn);

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

	<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
		  locale:"es",
		  headerToolbar:{
			left:'prev,next today',
			center:'title',
			right:'dayGridMonth,timeGridWeek,timeGridDay'

		  },  

		
 
		 
		
 

  events: [
	<?php while($dataEvento = mysqli_fetch_array($Resultado)){ ?>
    {
		
      title: '<?php echo $dataEvento['E_TITULO']; ?>',
	  info: 'ghdfghdfghfgd',
      start: '<?php echo $dataEvento['E_FECHA']; ?>T<?php echo $dataEvento['E_HORA_INICIO']; ?>',
      emd: '<?php echo $dataEvento['E_FECHA']; ?>T<?php echo $dataEvento['E_HORA_FIN']; ?>',
	  backgroundColor: 'green',
      borderColor: 'green',
	  url: 'https://portal.parquechatun.com.gt/ProgramFiles/APPS/CYM/Eventos/VerEventos/VerEvento.php?Codigo=<?php echo $dataEvento['EV_CODIGO']; ?>'	  

    },

	
	<?php } 
	
	while($dataEventoIn = mysqli_fetch_array($ResultadoIn)){ ?>
    {
		
      title: '<?php echo $dataEventoIn['E_TITULO']; ?>',
	  info: 'ghdfghdfghfgd',
      start: '<?php echo $dataEventoIn['E_FECHA']; ?>T<?php echo $dataEventoIn['E_HORA_INICIO']; ?>',
      emd: '<?php echo $dataEventoIn['E_FECHA']; ?>T<?php echo $dataEventoIn['E_HORA_FIN']; ?>',
	  backgroundColor: 'blue',
      borderColor: 'blue',
	 	  

    },
	<?php } ?>
  ],

  

  eventClick: function(info) {
    info.jsEvent.preventDefault(); // don't let the browser navigate

    if (info.event.url) {
      window.open(info.event.url);
    }
  }

  
          
        })
		
        calendar.render()
      })


	  function AgregarEvento()
    	{
    		$('#ModalEvento').modal('show');

    	}

		function GuardarEvento()
		{
			var formulario = document.getElementById("FormularioEvento");
			formulario.submit();
			return true;
		}


    </script>

</head>
<body >

	<?php include("../../../MenuTop.php");


	
	?>

	<!-- BEGIN BASE-->
	<div id="base">

	<div class="col-lg-12">
				<h1 class="text-center"><strong>AGENDA</strong><br></h1>
				<br>
				</div>
				<div class="col-lg-12">
				<div class="col-lg-1">
						<button class="btn btn-success" type="button" onclick="AgregarEvento()"> Agregar <span class="fa fa-plus-square" aria-hidden="true"></span></button>
					</div>
					
					<div class="col-lg-11">
										
					<div class="card">
						<div class="card-head style-primary">
						</div>
						<div class="card-body">
						<div id='calendar'></div>
							
					</div>
				</div>
				
			<!-- END CONTENT -->


			<div id="ModalEvento" class="modal fade" role="dialog">
	
            <div class="modal-dialog">
			
			<div class="card">
			<div class="card-body">
				
			<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
                <!-- Modal content-->
                <div class="modal-content">
				<div class="card-head style-primary">
								<h2 class="text-center"> Datos Laborales </h2>
                            </div>
                    <div class="modal-body">
					<form class="form" id="FormularioEvento" action="GuardarEvento.php" method="POST" enctype="multipart/form-data">
                    	<div id="suggestions" class="text-center"></div>
						<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
						<div class="col-lg-8">
										<div class="form-group floating-label">
                                        <label for="TipoDocumento">Tipo de Documento</label>
										<select name="TipoDocumento" id="TipoDocumento" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="DPI">DPI</option>
                                                <option value="Ornato">Boleto de Ornato</option>
                                                <option value="SolicitudEmpleo">Solicitud de Empleo</option>
											</select>
										</div>
									</div>
									<div class="col-lg-8">
									</div>
						<div >
								<input type="file" name="documento" id="documento" >
								
								<label for="documento" 
								style="background: #1F5F74;
										color: white;
										padding: 6px 20px;
										cursor: pointer;
										margin: 5 5;
										text-align: center;
										border-radius: 3px;">Seleccionar Documneto</label>
							</div>
					</form>

							<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-success" onclick="GuardarDocumento()">Guardar</button>
					</div>
                    </div>
                </div>
                </div>
            </div>
			</form>
	</div>
	
        </div>

		

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
