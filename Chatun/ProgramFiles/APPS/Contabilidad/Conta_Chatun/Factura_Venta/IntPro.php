<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
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

	<script>
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
			                x.blur();
		            	}
		            }
		        });
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
				<form class="form" action="IntPro.php" method="POST" role="form" target="_blank">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Integración Funcionarios/Empleados</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<table class="table table-hover table-condensed">
										<thead>
											<tr>
												<th>
													<h5><strong>CIF</strong></h5>
												</th>
												<th>
													<h5><strong>Colaborador</strong></h5>
												</th>
												<th class="text-center">
													<h5><strong>Cargos</strong></h5>
												</th>
												<th class="text-center">
													<h5><strong>Abonos</strong></h5>
												</th>
												<th class="text-center">
													<h5><strong>Saldo</strong></h5>
												</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$Total = 0;
										$FechaIni = $_POST["FechaInicio"];
										$FechaFin = $_POST["FechaFin"];
											$query = "SELECT SUM(TRA_TOTAL) AS TOTAL_ANTICIPOS, TRA_CIF_COLABORADOR 
														FROM Contabilidad.TRANSACCION
														WHERE TT_CODIGO BETWEEN 3 AND 9
														AND TRA_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."'
														AND E_CODIGO = 2
														AND TRA_TIPO_FACTURA_VENTA = 'FE'
														GROUP BY TRA_CIF_COLABORADOR";
											$result = mysqli_query($db, $query);
											while($row = mysqli_fetch_array($result))
											{	
												$Total = 0;
												$SolicitaCIF    = $row["TRA_CIF_COLABORADOR"];
												$Solicitante    = saber_nombre_colaborador($row["TRA_CIF_COLABORADOR"]);
												$TotalAnticipos = $row["TOTAL_ANTICIPOS"];

												$query1 = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
															FROM Contabilidad.TRANSACCION, Contabilidad.TRANSACCION_DETALLE
															WHERE TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO
															AND TRANSACCION_DETALLE.N_CODIGO = '1.01.04.006'
															AND TRANSACCION.TRA_TIPO_FACTURA_VENTA = 'FE'
															AND TRANSACCION.TRA_CIF_COLABORADOR = ".$SolicitaCIF."
															AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."'
															ORDER BY TRANSACCION.TRA_FECHA_TRANS ";
												$result1 = mysqli_query($db, $query1);
												while($row1 = mysqli_fetch_array($result1))
												{
													$Cargos = $row1["CARGOS"];
													$Abonos = $row1["ABONOS"];
												}

												$SaldoTotal = $Cargos - $Abonos;

												echo '<tr>';
													echo '<td>'.$SolicitaCIF.'</td>';
													echo '<td>'.$Solicitante.'</td>';
													echo '<td class="text-center">'.number_format($Cargos, 2, '.', ',').'</td>';
													echo '<td class="text-center">'.number_format($Abonos, 2, '.', ',').'</td>';
													echo '<td class="text-center">'.number_format($SaldoTotal, 2, '.', ',').'</td>';
													echo '<td><a target="_blank" href="IntProImp.php?Solicitante='.$SolicitaCIF.'&FechaInicio='.$FechaIni.'&FechaFin='.$FechaFin.'"><button type="button" class="btn btn-warning btn-xs">
															    <span class="glyphicon glyphicon-list"></span> Detalle
															  </button></a></td>';
												echo '</tr>';
											}
										?>
										</tbody>
									</table>
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
