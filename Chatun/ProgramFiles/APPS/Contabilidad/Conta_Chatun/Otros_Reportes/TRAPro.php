<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$NombreUsuario = saber_nombre_colaborador($id_user);
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
	function DesplegarResolucion(x)
	{
		if(x.value == '2')
		{
			$('#FacturaRechazada').hide();
			$('#FacturaAprobada').show();
			$('#MotivoRechazo').attr("required");
			$('#Comprobante').attr("required", "required");
		}
		else
		{
			$('#FacturaRechazada').show();
			$('#FacturaAprobada').hide();
			$('#Comprobante').attr("required");
			$('#MotivoRechazo').attr("required", "required");
		}
	}
	</script>
	<script>
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
		            url: "buscarCuenta.php",
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
		            }
		        });
		}
		function ActualizarPartida()
		{
			document.FormularioPartida.submit();
		}
		function OperarFactura()
		{
			document.FormOperar.submit();
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

			if(TotalCargos == TotalAbonos)
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-danger');
				$('#ResultadoPartida').addClass('alert alert-callout alert-success');
				$('#NombreResultado').html('Partida Completa');
			}
			else
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-success');
				$('#ResultadoPartida').addClass('alert alert-callout alert-danger');
				$('#NombreResultado').html('Partida Incompleta');
			}
		}
	</script>
	<style>
	.fila-base{
            display: none;
        }
    </style>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php
	$TotalCargos = 0;
	$TotalAbonos = 0;

	$query = "SELECT TRANSACCION.*, AREA_GASTO.AG_NOMBRE
			FROM  Contabilidad.TRANSACCION, Contabilidad.AREA_GASTO
			WHERE TRANSACCION.TRA_AREA_GASTO = AREA_GASTO.AG_CODIGO
			AND TRA_CODIGO = '".$_GET["Codigo"]."'";
	$result = mysqli_query($db, $query);
	while($row = mysqli_fetch_array($result))
	{	
		$Fecha         = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
		$Concepto      = $row["TRA_CONCEPTO"];
		$AutorizaGasto = $row["TRA_AUTORIZA_GASTO"];
		$Solicitante   = $row["TRA_SOLICITA_GASTO"];
		$AreaGasto     = $row["TRA_AREA_GASTO"];
		$Monto         = $row["TRA_TOTAL"];
		$Correlativo   = $row["TRA_CORRELATIVO"];
		$MotivoRechazo 		=$row["TRA_MOTIVO_RECHAZO"];
		if($Visto == 0)
		{
			$QueryActualizar = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_VISTO = 1 WHERE TRA_CODIGO = '".$_GET["Codigo"]."'");

		}
		$NombreUsuario = saber_nombre_colaborador($Solicitante);
	}									
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos del Anticipo</strong></h4>
							</div>
							<div class="card-body">
							<form class="form" role="form" name="FormularioPartida" method="POST" action="ActualizarPartida.php">
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $MotivoRechazo; ?>" readonly/>
											<label for="Nombre">Motivo Rechazo</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="CIFSolicitante" id="CIFSolicitante" value="<?php echo $Solicitante; ?>" readonly required/>
											<label for="CIFSolicitante">CIF del Solicitante</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="NombreSolicitante" id="NombreSolicitante" value="<?php echo $NombreUsuario; ?>" readonly required/>
											<label for="NombreSolicitante">Nombre Solicitante</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Correlativo" id="Correlativo" value="<?php echo $Correlativo; ?>" readonly required/>
											<label for="Correlativo">No. de Anticipo</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group">
											<select name="AutorizaGasto" id="AutorizaGasto" class="form-control" readonly required>
												<option value="4500">Julio César Salguero Ramos</option>
											</select>
											<label for="AutorizaGasto">Autoriza Gasto</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group">
										<select name="AreaGasto" id="AreaGasto" class="form-control" readonly required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Contabilidad.AREA_GASTO ORDER BY AG_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													if($row["AG_CODIGO"] == $AreaGasto)
													{
														$Selected = 'selected';
													}
													else
													{
														$Selected = '';
													}
													echo '<option value="'.$row["AG_CODIGO"].'" '.$Selected.'>'.$row["AG_NOMBRE"].'</option>';
												}

												?>
											</select>
											<label for="AreaGasto">Área del Gasto</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Descripcion" id="Descripcion" readonly required><?php echo $Concepto; ?></textarea>
											<label for="Descripcion">Descripción del Anticipo</label>
										</div>
									</div>
								</div>
								<div id="DivProductosServicios">
									<div class="row">
										<div class="col-lg-3 col-lg-9">
											<div class="form-group floating-label">
												<input class="form-control" type="number" step="any" name="TotalAnticipo" id="TotalAnticipo" min="0" readonly value="<?php echo $Monto; ?>"/>
												<label for="TotalAnticipo">Monto Solicitado</label>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
	                                        <thead>
	                                            <tr>
	                                                <td><strong>Cuenta</strong></td>
	                                                <td><strong>Cargos</strong></td>
	                                                <td><strong>Abonos</strong></td>
	                                                <td><strong>Razón</strong></td>
	                                            </tr>
	                                        </thead>
	                                        <tbody>
	                                            <tr class="fila-base">
	                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)"></h6></td>
	                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0"></h6></td>
	                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0"></h6></td>
	                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
	                                                <td class="eliminar">
	                                                    <button type="button" class="btn btn-danger btn-xs">
	                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
	                                                    </button>
	                                                </td>
	                                            </tr>
	                                            <?php
		                                        	$query = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE 
		                                        				FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA
		                                        				WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
		                                        				AND TRANSACCION_DETALLE.TRA_CODIGO = '".$_GET["Codigo"]."'";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														echo '<tr>';
														echo '<td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)" value="'.$row["N_CODIGO"].'/'.$row["N_NOMBRE"].'" readonly></h6></td>';
		                                                echo '<td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" min="0" value="'.$row["TRAD_CARGO_CONTA"].'" readonly></h6></td>';
		                                                echo '<td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px"  min="0" value="'.$row["TRAD_ABONO_CONTA"].'" readonly></h6></td>';
		                                                echo '<td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]" value="'.$row["TRAD_RAZON"].'" readonly></h6></td>';
		                                                echo '</tr>';
														$TotalCargos = $TotalCargos + $row["TRAD_CARGO_CONTA"];
														$TotalAbonos = $TotalAbonos + $row["TRAD_ABONO_CONTA"];
													}
		                                        ?>
	                                        </tbody>
	                                        <tfoot>
	                                        	<tr>
	                                        		<td class="text-right">Total</td>
	                                                <td><h6><input type="text" step="any" class="form-control" name="TotalCargos" id="TotalCargos"  readonly style="width: 100px" value="<?php echo number_format($TotalCargos, 2, '.', ','); ?>"></h6></td>
	                                                <td><h6><input type="text" step="any" class="form-control" name="TotalAbonos" id="TotalAbonos" readonly style="width: 100px" value="<?php echo number_format($TotalAbonos, 2, '.', ','); ?>"  ></h6></td>
	                                                <td><div style="height: 45px" id="ResultadoPartida" role="alert"><strong id="NombreResultado"></strong></div></td>
	                                        	</tr>
	                                        </tfoot>
	                                    </table>
								</div>		
								<input class="form-control" type="hidden" name="CodigoTransaccion" id="CodigoTransaccion" value="<?php echo $_GET["Codigo"] ?>"/>
							</form>							
							</div>
						</div>
					</div>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
