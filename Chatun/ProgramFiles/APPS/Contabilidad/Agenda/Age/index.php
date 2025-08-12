<!DOCTYPE html>
<html>
<head>
<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$SqlEventos   = ("SELECT * FROM Agenda.EVENTO WHERE E_ANFITRION = $id_user");
  $Resultado = mysqli_query($db, $SqlEventos);

  $SqlEventosIn   = ("SELECT EVENTO.* FROM Agenda.EVENTO, Agenda.PARTICIPANTES WHERE EVENTO.E_CODIGO= PARTICIPANTES.E_CODIGO
  AND PARTICIPANTES.E_USUARIO = $id_user");
  $ResultadoIn = mysqli_query($db, $SqlEventosIn);

?>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Portal Institucional Chatún</title>
	<link rel="stylesheet" type="text/css" href="css/fullcalendar.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/home.css">

  <!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../../libs/TableFilter/filtergrid.css">
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
  <script>
    function AgregarLinea()
		{
			$("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
		}
		function EliminarLinea(x)
		{
			var parent = $(x).parents().get(1);
                $(parent).remove();
                CalcularTotal();
		}

    function BuscarParticipante(x)
        {

				//Obtenemos el value del input
		        var service = x.value;
		        var dataString = 'service='+service;
		        var Indice = $(x).closest('tr').index();
		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscarParticipante.php",
		            data: dataString,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function(data) {
		            	if(data == 0)
		            	{
		            		alertify.error('No se encontró ningún registro');
		            		$('#suggestions').html('');
		            	}
		            	else
		            	{
		            		$('#ModalSugerencias').modal('show');
			                //Escribimos las sugerencias que nos manda la consulta
			                $('#suggestions').fadeIn(1000).html(data);
			                //Al hacer click en algua de las sugerencias
			                $('.suggest-element').click(function(){
			                    x.value = $(this).attr('id')+"/"+$(this).attr('data');
			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#suggestions').fadeOut(500);
			                    $('#ModalSugerencias').modal('hide');

			                });
			            }
		            }
		        });
			}

    </script>
</head>
<body>
<?php include("../../../../MenuTop.php"); ?>


 <div id="base">

<div class="container">
  <div class="row">
    <div class="col msjs">
      <?php
        include('msjs.php');
      ?>
    </div>
  </div>

 

<div class="col-lg-12">
      <h1 class="text-center"><strong>AGENDA</strong><br></h1>
      <br>
      </div>
      <div class="col-lg-12">
                  
        <div class="card">
          <div class="card-head style-primary">
          </div>
          <div class="card-body">
          <div id='calendar'></div>
            
        </div>
      </div>
      
    <!-- END CONTENT -->

     


<?php  
  include('modalUpdateEvento.php');
  include('modalNuevoEvento.php');
?>

 <!-- Modal Detalle Pasivo Contingente -->
 <div id="ModalSugerencias"  role="dialog" class="modal">
            <div class="modal-dialog" role="document">
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



  

<script src ="js/jquery-3.0.0.min.js"> </script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/moment.min.js"></script>	
<script type="text/javascript" src="js/fullcalendar.min.js"></script>
<script src='locales/es.js'></script>

<script type="text/javascript">
$(document).ready(function() {
  $("#calendar").fullCalendar({
    header: {
      left: "prev,next today",
      center: "title",
      right: "month,agendaWeek,agendaDay"
    },

    locale: 'es',

    defaultView: "month",
    navLinks: true, 
    editable: true,
    eventLimit: true, 
    selectable: true,
    selectHelper: false,
    initialView: 'dayGridMonth',

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
          _id: '<?php echo $dataEvento['E_CODIGO']; ?>',
          title: '<?php echo $dataEvento['E_TITULO']; ?>',
          start: '<?php echo $dataEvento['E_FECHA']; ?>T<?php echo $dataEvento['E_HORA_INICIO']; ?>',
          end:   '<?php echo $dataEvento['E_FECHA']; ?>T<?php echo $dataEvento['E_HORA_FIN']; ?>',
          backgroundColor: '<?php echo $dataEvento['E_COLOR']; ?>',
          borderColor:'<?php echo $dataEvento['E_COLOR']; ?>',
          },

	
	<?php } 
	
	while($dataEventoIn = mysqli_fetch_array($ResultadoIn)){ ?>
    {
          _id: '<?php echo $dataEventoIn['E_CODIGO']; ?>',
          title: '<?php echo $dataEventoIn['E_TITULO']; ?>',
          start: '<?php echo $dataEventoIn['E_FECHA']; ?>T<?php echo $dataEventoIn['E_HORA_INICIO']; ?>',
          end:   '<?php echo $dataEventoIn['E_FECHA']; ?>T<?php echo $dataEventoIn['E_HORA_FIN']; ?>',
          backgroundColor: '<?php echo $dataEventoIn['E_COLOR']; ?>',
          borderColor:'<?php echo $dataEventoIn['E_COLOR']; ?>',
          },
	<?php } ?>
  ],

//Eliminar Evento
eventRender: function(event, element) {
    element
      .find(".fc-content")

    
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


</body>
</html>
