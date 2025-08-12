<?php
include("../../../../../Script/funciones.php");
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
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.default.css"/>
	<!-- END STYLESHEETS -->
	<script>
	function CambiarEstado(x)
	{
		if(x.value == 'AT')
		{
			var Requisicion = $('#CodigoRequisicion').val();
			alertify.confirm("¿Está seguro que desea marcar como ATENDIDA la requisición?", function (e) {
				if (e) {
					$.ajax({
		            type: "POST",
		            url: "AtenderRequisicion.php",
		            data: 'idRequisicion='+Requisicion,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function() {
		            	alertify.success('La requisición se marco como ATENDIDA');
		            	setTimeout(function(){
		            		window.location.replace('Solicitud.php');
		            	}, 3000);
		            }
		        });
				} else {
					
				}
			});
		}
		else if(x.value == 'CA')
		{
			var Requisicion = $('#CodigoRequisicion').val();
			alertify.confirm("¿Está seguro que desea marcar como ATENDIDA la requisición?", function (e) {
				if (e) {
					$.ajax({
		            type: "POST",
		            url: "CancelarRequisicion.php",
		            data: 'idRequisicion='+Requisicion,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function() {
		            	alertify.success('La requisición se marco como CANCELADA');
		            	setTimeout(function(){
		            		window.location.replace('Solicitud.php');
		            	}, 3000);
		            }
		        });
				} else {
					
				}
			});
		}
	}
	</script>
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php
		$query = "SELECT REQUISICION.*, BODEGA.B_NOMBRE
		FROM Bodega.REQUISICION, Bodega.BODEGA
		WHERE REQUISICION.B_CODIGO = BODEGA.B_CODIGO
		AND REQUISICION.R_CODIGO = '".$_GET["Codigo"]."' ";
		$result = mysqli_query($db, $query);
		while($row = mysqli_fetch_array($result))
		{
			$FechaRequisicion = $row["R_FECHA"];
			$FechaNecesidad   = $row["R_FECHA_NECESIDAD"];
			$Bodega           = $row["B_NOMBRE"];
			$Observaciones    = $row["R_OBSERVACIONES"];
			$Genero           = $row["R_USUARIO"];
		}
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="RCPro.php" method="POST" role="form">
				<input class="form-control" type="hidden" name="Codigo" id="Codigo" value="<?php echo $Codigo; ?>" readonly required/>
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Requisición de Compra</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="hidden" name="CodigoRequisicion" value="<?php echo $_GET['Codigo']; ?>"  id="CodigoRequisicion" readonly/>
											<input class="form-control" maxlength="255" type="text" name="Genero" value="<?php echo saber_nombre_colaborador($Genero); ?>"  id="Genero" readonly/>
											<label for="Genero">Generó Solicitud</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaRequisicion" id="FechaRequisicion" value="<?php echo $FechaRequisicion; ?>" readonly required/>
											<label for="FechaRequisicion">Fecha de Requisicón</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaNecesidad" id="FechaNecesidad" value="<?php echo $FechaNecesidad; ?>" required readonly/>
											<label for="FechaNecesidad">Fecha de Necesidad</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="Bodega" id="Bodega" value="<?php echo $Bodega; ?>" required readonly/>
											<label for="Bodega">Bodega Destino</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="text" name="Concepto" value="<?php echo $Observaciones; ?>"  id="Concepto" readonly/>
											<label for="Concepto">Observaciones</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <td><strong>Cantidad</strong></td>
                                                <td><strong>Producto</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            	$query = "SELECT REQUISICION_DETALLE.*, PRODUCTO.P_NOMBRE
												FROM Bodega.REQUISICION_DETALLE, Bodega.PRODUCTO
												WHERE REQUISICION_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
												AND REQUISICION_DETALLE.R_CODIGO = '".$_GET["Codigo"]."' ";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													echo '<tr>';
														echo '<td>'.number_format($row["RD_CANTIDAD"], 2, '.', ',').'</td>';
														echo '<td>'.$row["P_NOMBRE"].'</td>';
													echo '</tr>';
												}

                                            ?>
                                        </tbody>
                                    </table>
								</div>
							</div>
						</div>
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Estado de la Requisición</strong></h4>
							</div>
							<div class="card-body">
								<div class="container text-center">
									<div class="col-lg-12">
										<label class="radio-inline radio-styled" >
											<input type="radio" value="AB" name="EstadoRequisición" onChange="CambiarEstado(this)" required checked>
											<span>Abierta</span>
										</label>
										<label class="radio-inline radio-styled">
											<input type="radio" value="AT" name="EstadoRequisición" onChange="CambiarEstado(this)" required>
											<span>Atendida</span>
										</label>
										<label class="radio-inline radio-styled">
											<input type="radio" value="CA" name="EstadoRequisición" onChange="CambiarEstado(this)" required>
											<span>Cancelar</span>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
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
