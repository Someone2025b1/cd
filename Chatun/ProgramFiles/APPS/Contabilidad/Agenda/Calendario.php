<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Mi Calendario:: Ing. Urian Viera</title>
	<link rel="stylesheet" type="text/css" href="css/fullcalendar.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/home.css">
</head>
<body>

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
<div class="mt-5"></div>

<div class="container">
  <div class="row">
    <div class="col msjs">
      <?php
        include('msjs.php');
      ?>
    </div>
  </div>

<div class="row">
  <div class="col-md-12 mb-3">
  <h3 class="text-center" id="title">AGENDA</h3>
  </div>
</div>
</div>



<div id="calendar"></div>


<?php  
  include('modalNuevoEvento.php');
  include('modalUpdateEvento.php');
?>





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

<script src='locales/es.js'></script>

<script type="text/javascript">
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

    locale: 'es',

    defaultView: "month",
    navLinks: true, 
    editable: true,
    eventLimit: true, 
    selectable: true,
    selectHelper: false,

//Nuevo Evento
  select: function(start, end){
      $("#exampleModal").modal();
      $("input[name=fecha_inicio]").val(start.format('DD-MM-YYYY'));
       
      var valorFechaFin = end.format("DD-MM-YYYY");
      var F_final = moment(valorFechaFin, "DD-MM-YYYY").subtract(1, 'days').format('DD-MM-YYYY'); //Le resto 1 dia
      $('input[name=fecha_fin').val(F_final);  

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


//Eliminar Evento
eventRender: function(event, element) {
    element
      .find(".fc-content")
      .prepend("<span id='btnCerrar'; class='closeon material-icons'>&#xe5cd;</span>");
    
    //Eliminar evento
    element.find(".closeon").on("click", function() {

  var pregunta = confirm("Deseas Borrar este Evento?");   
  if (pregunta) {

    $("#calendar").fullCalendar("removeEvents", event._id);

     $.ajax({
            type: "POST",
            url: 'deleteEvento.php',
            data: {id:event._id},
            success: function(datos)
            {
              $(".alert-danger").show();

              setTimeout(function () {
                $(".alert-danger").slideUp(500);
              }, 3000); 

            }
        });
      }
    });
  },


//Moviendo Evento Drag - Drop
eventDrop: function (event, delta) {
  var idEvento = event._id;
  var start = (event.start.format('DD-MM-YYYY'));
  var end = (event.end.format("DD-MM-YYYY"));

    $.ajax({
        url: 'drag_drop_evento.php',
        data: 'start=' + start + '&end=' + end + '&idEvento=' + idEvento,
        type: "POST",
        success: function (response) {
         // $("#respuesta").html(response);
        }
    });
},

//Modificar Evento del Calendario 
eventClick:function(event){
    var idEvento = event._id;
    $('input[name=idEvento').val(idEvento);
    $('input[name=evento').val(event.title);
    $('input[name=fecha_inicio').val(event.start.format('DD-MM-YYYY'));
    $('input[name=fecha_fin').val(event.end.format("DD-MM-YYYY"));

    $("#modalUpdateEvento").modal();
  },


  });


//Oculta mensajes de Notificacion
  setTimeout(function () {
    $(".alert").slideUp(300);
  }, 3000); 


});

</script>


<!--------- WEB DEVELOPER ------>
<!--------- URIAN VIERA   ----------->
<!--------- PORTAFOLIO:  https://blogangular-c7858.web.app  -------->

</body>
</html>