<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$ahora = time();
$unDiaEnSegundos = 24 * 60 * 60;
$manana = $ahora - $unDiaEnSegundos - $unDiaEnSegundos;
$FechaHoy = date("Y-m-d", $manana);

$SqlEventos   = ("SELECT * FROM Eventos.EVENTO WHERE EV_CANCELADO = 0");
  $Resultado = mysqli_query($db, $SqlEventos);

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
		
      title: '<?php echo $dataEvento['EV_LUGAR']; ?>',
	  info: 'ghdfghdfghfgd',
      start: '<?php echo $dataEvento['EV_FECHA_EV']; ?>T<?php echo $dataEvento['EV_HORA_INI']; ?>',
      emd: '<?php echo $dataEvento['EV_FECHA_EV']; ?>T<?php echo $dataEvento['EV_HORA_FIN']; ?>',
	  <?php if($dataEvento['F_CODIGO']==NULL & $dataEvento['EV_FECHA_EV']<$FechaHoy & $dataEvento['EV_INFORMATIVO']==0){ ?>
	  backgroundColor: 'red',
      borderColor: 'red',
	  <?php }else{

		?>
		backgroundColor: 'green',
		borderColor: 'green',
		<?php

	  }?>
	  url: 'https://portal.parquechatun.com.gt/ProgramFiles/APPS/CYM/Eventos/ListaEventos/VerEvento.php?Codigo=<?php echo $dataEvento['EV_CODIGO']; ?>'	  

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


	  

    </script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php");


	
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Consulta de Eventos</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						</div>
						<div class="card-body">
						<div id='calendar'></div>
							
					</div>
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
