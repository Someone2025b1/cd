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
								<h4 class="text-center"><strong>Integración Anticipos</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<table class="table table-hover table-condensed">
										<thead>
											<tr>
												<th>
													<h5><strong>Área</strong></h5>
												</th>
												<th>
													<h5><strong>CIF</strong></h5>
												</th>
												<th>
													<h5><strong>Colaborador</strong></h5>
												</th>
												<th>
													<h5><strong>Integración</strong></h5>
												</th>
												<th>
													<h5><strong>Saldo</strong></h5>
												</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$Total = 0;
										$FechaIni = $_POST["FechaInicio"];
										$FechaFin = $_POST["FechaFin"];
											$query = "SELECT SUM(TRA_TOTAL) AS TOTAL_ANTICIPOS, TRA_SOLICITA_GASTO 
														FROM Contabilidad.TRANSACCION
														WHERE TT_CODIGO = 10
														AND TRA_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."'
														AND E_CODIGO = 2
														GROUP BY TRA_SOLICITA_GASTO";
											$result = mysqli_query($db,$query);
											while($row = mysqli_fetch_array($result))
											{	
												$Total = 0;
												$SolicitaCIF    = $row["TRA_SOLICITA_GASTO"];
												$Solicitante    = saber_nombre_colaborador($row["TRA_SOLICITA_GASTO"]);
												$AreaSolicitante = saber_departamento_coosajo($row["TRA_SOLICITA_GASTO"]);
												$TotalAnticipos = $row["TOTAL_ANTICIPOS"];

												$query1 = "SELECT TRA_CODIGO 
														FROM Contabilidad.TRANSACCION
														WHERE TRA_SOLICITA_GASTO = ".$SolicitaCIF;
												$result1 = mysqli_query($db,$query1);
												while($row1 = mysqli_fetch_array($result1))
												{
													$Codigo = $row1["TRA_CODIGO"];

													$query2 = "SELECT TRA_TOTAL 
															FROM Contabilidad.TRANSACCION
															WHERE TRA_ANTICIPO = '".$Codigo."'";
													$result2 = mysqli_query($db,$query2);
													while($row2 = mysqli_fetch_array($result2))
													{
														$Total = $Total + $row2["TRA_TOTAL"];
														
													}

												}

												$SaldoTotal = $TotalAnticipos - $Total;

												echo '<tr>';
													echo '<td>'.$AreaSolicitante.'</td>';
													echo '<td>'.$SolicitaCIF.'</td>';
													echo '<td>'.$Solicitante.'</td>';
													echo '<td>'.number_format($TotalAnticipos, 2, '.', ',').'</td>';
													echo '<td>'.number_format($SaldoTotal, 2, '.', ',').'</td>';
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
