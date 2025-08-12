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

	<script type="text/javascript">
$(document).ready(function() {
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
});
</script>
	
	<script>
		function Enviar()
		{
			// confirm dialog
			alertify.confirm("¿Estás seguro que deseas modificar esta partida?", function (e) {
			    if (e) {
			        $('#Formulario').submit();
			    }
			});
		}
		//Función para agregar o eliminar filas en la tabla de construcciones
        $(function(){
        
            // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar").on('click', function(){
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
                Calcular();
            });
        });
        function BuscarCuenta(x){
		        //Obtenemos el value del input
		        var service = x.value;
		        var dataString = 'service='+service;
		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscarCuentaMod.php",
		            data: dataString,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function(data) {
		            	
		            	if(data == '')
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
		            },
		            error: function(data) {
		            	alert(data);
		            }

		        });
		}
		function Calcular()
		{
			var TotalCargos = 0;
			var TotalAbonos = 0;
			var Contador = document.getElementsByName('Cargos[]');
			var Cargos = document.getElementsByName('Cargos[]');
			var Abonos = document.getElementsByName('Abonos[]');

			for(i=0; i<Contador.length; i++)
			{
				TotalCargos = parseFloat(TotalCargos) + parseFloat(Cargos[i].value);
				TotalAbonos = parseFloat(TotalAbonos) + parseFloat(Abonos[i].value);
			}
			
			$('#TotalCargos').val(TotalCargos.toFixed(2));
			$('#TotalAbonos').val(TotalAbonos.toFixed(2));

			if(TotalCargos.toFixed(2) == TotalAbonos.toFixed(2))
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-danger');
				$('#ResultadoPartida').addClass('alert alert-callout alert-success');
				$('#NombreResultado').html('Partida Completa');
				$('#btnGuardar').prop("disabled", false);
			}
			else
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-success');
				$('#ResultadoPartida').addClass('alert alert-callout alert-danger');
				$('#NombreResultado').html('Partida Incompleta');
				$('#btnGuardar').prop("disabled", true);
			}
		}
		function SelColaborador(x)
		{
			window.open('SelColaborador.php','popup','width=750, height=700');
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>


	<?php
	$Consulta = "SELECT * FROM Contabilidad.TRANSACCION WHERE TRA_CODIGO = '".$_GET["Codigo"]."'";
		$Resultado = mysqli_query($db, $Consulta);
		while($row = mysqli_fetch_array($Resultado))
		{
		    $GLOBALS['Comprobante'] = $row["TRA_COMPROBANTE"];
		    $Fecha                  = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
		    $Hora                   = $row["TRA_HORA"];
		    $Concepto               = $row["TRA_CONCEPTO"];
		    $FechaHoy               = date('d-m-Y', strtotime($row["TRA_FECHA_HOY"]));
		    $Usuario                = $row["TRA_USUARIO"];
		    $Serie                  =$row["TRA_SERIE"];
		    $Factura                =$row["TRA_FACTURA"];
		    $TipoCompra             =$row["TC_CODIGO"];
		    $Combustible            = $row["COM_CODIGO"];
		    $DestinoCombustible     =$row["TRA_DESTINO_COM"];
		    $CantidadGalones        =$row["TRA_CANT_GALONES"];
		    $PrecioGalones          =$row["TRA_PRECIO_GALONES"];
		    $TotalFactura           =$row["TRA_TOTAL"];
		    $FormaPago              =$row["FP_CODIGO"];
		    $Usuario                =$row["TRA_USUARIO"];
		    $NoPoliza               =$row["TRA_CORRELATIVO"];
		    $Contabilizo            =$row["TRA_CONTABILIZO"];
		    $NoHoja					=$row["TRA_NO_HOJA"];
		    $FechaFact   			=$row["TRA_FECHA_TRANS"];
		    $Periodo 				=$row["PC_CODIGO"];

		}

	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="ModificacionPro.php" method="POST" role="form" id="Formulario">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Consulta/Modificación de Póliza</strong></h4>
							</div>
							<div class="card-body">
							<?php
								$Centinela    = true;
								$Comprobante = $_POST["Comprobante"];
								$Fecha = $_POST["Fecha"];
								$Concepto = $_POST["Concepto"];
								$CodigoPoliza = $_POST["Codigo"];

								$UI           = $CodigoPoliza;
								$UID          = uniqid('trad_');
								$Contador     = count($_POST["Cuenta"]);

								$Cuenta       = $_POST["Cuenta"];
								$Cargos       = $_POST["Cargos"];
								$Abonos       = $_POST["Abonos"];
								$Razon        = $_POST["Razon"];

								$Query = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_FECHA_TRANS = '".$Fecha."', TRA_CONCEPTO = '".$Concepto."' WHERE TRA_CODIGO = '".$CodigoPoliza."'") or die (mysqli_error()); 

								if(!$Query)
								{
									echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo modificar la póliza.</h2>
									<h4 class="text-light">Código de transacción: '.$CodigoPoliza.' encabezado</h4>
									</div>';
									echo mysqli_error($query);
									$Centinela = false;
									
								}
								else
								{


									$queryLog = mysqli_query($db, "INSERT INTO Contabilidad.HISTORIAL_MODIFICACION (FechaInsert, TRA_CODIGO, Colaborador)
											VALUES(CURRENT_TIMESTAMP,  '".$UI."', $id_user)") or die(mysqli_error());
									$IdHistorial = mysqli_insert_id($db);

									$QueryDetalleHistorial = mysqli_query($db, "INSERT INTO Contabilidad.HISTORIAL_TRANSACCION_DETALLE 
SELECT A.TRA_CODIGO, A.TRAD_CODIGO, A.TRAD_CORRELATIVO, A.N_CODIGO, A.TRAD_CARGO_CONTA, A.TRAD_ABONO_CONTA, A.TRAD_RAZON, ".$IdHistorial."  FROM Contabilidad.TRANSACCION_DETALLE A WHERE A.TRA_CODIGO = '".$CodigoPoliza."'") or die(mysqli_error());

									$QueryDetalle = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE WHERE TRA_CODIGO = '".$CodigoPoliza."'") or die(mysqli_error());



									for($i=1; $i<$Contador; $i++)
									{
										$Cue = $Cuenta[$i];
										$Car = $Cargos[$i];
										$Abo = $Abonos[$i];
										$Raz = $Razon[$i];

										$Xplotado = explode("/", $Cue);
										$NCue = $Xplotado[0];

										$query = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA, TRAD_RAZON)
											VALUES('".$UID."', '".$UI."', '".$NCue."', ".$Car.", ".$Abo.", '".$Raz."')") or die(mysqli_error());

										if(!$query)
										{
											echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo modificar la póliza.</h2>
											<h4 class="text-light">Código de transacción: '.$UID.' Detalle</h4>
											</div>';
											echo mysqli_error($query);
											$Centinela = false;
											
										}	
									}
								}

								if($Centinela == true)
								{
									echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
									<h2 class="text-light">La factura de compra se ingresó correctamente.</h2>
									<div class="row">
										<div class="col-lg-6 text-right"><a href="ImpPartidaNew.php?Codigo='.$UI.'" target="_blank"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print"></span> Imprimir</a></div>
										<div class="col-lg-6 text-left"><a href="Ingreso.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
									</div>';
								}

							?>
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
