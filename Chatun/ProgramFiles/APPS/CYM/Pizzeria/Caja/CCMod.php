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
	function EditHead()
	{ 
		 $("#SerieFactura").attr("readonly", false);
		 $("#Factura").attr("readonly", false); 
		 $("#Fecha").attr("readonly", false);
		 $("#Descripcion").attr("readonly", false); 
					
	}

	function CalcularTotalQ()
	{
		var B200 = $('#BQ200').val();
		var B100 = $('#BQ100').val();
		var B50  = $('#BQ50').val();
		var B20  = $('#BQ20').val();
		var B10  = $('#BQ10').val();
		var B5   = $('#BQ5').val();
		var B1   = $('#BQ1').val();
		var M1   = $('#MQ1').val();
		var M50  = $('#MQ50').val();
		var M25  = $('#MQ25').val();
		var M10  = $('#MQ10').val();
		var M5   = $('#MQ5').val();

		var CantidadEntera = parseFloat(B200 * 200) + parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5) + parseFloat(B1 * 1);
		var CantidadMoneda = parseFloat(M1 * 1) + parseFloat(M50 * 0.50) + parseFloat(M25 * 0.25) + parseFloat(M10 * 0.10) + parseFloat(M5 * 0.05);

		var Total = CantidadEntera + CantidadMoneda;
		Total = Total.toFixed(2);

		$('#TCQ').val(Total);
	}
	function CalcularTotalD()
	{
		var B100 = $('#BD100').val();
		var B50  = $('#BD50').val();
		var B20  = $('#BD20').val();
		var B10  = $('#BD10').val();
		var B5   = $('#BD5').val();
		var B1   = $('#BD1').val();

		var CantidadEntera = parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5) + parseFloat(B1 * 1);
		
		var Total = CantidadEntera;
		Total = Total.toFixed(2);

		$('#TCD').val(Total);
	}
	function CalcularTotalL()
	{
		var B500 = $('#BL500').val();
		var B100 = $('#BL100').val();
		var B50  = $('#BL50').val();
		var B20  = $('#BL20').val();
		var B10  = $('#BL10').val();
		var B5   = $('#BL5').val();
		
		var CantidadEntera = parseFloat(B500 * 500) + parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5);
		
		var Total = CantidadEntera;
		Total = Total.toFixed(2);

		$('#TCL').val(Total);
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
				<h1 class="text-center"><strong>Contabilizar Cierre</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Cierre</strong></h4>
						</div>
						<div class="card-body">
							<?php

								$Query = "SELECT * FROM Bodega.APERTURA_CIERRE_CAJA WHERE ACC_TIPO = 22 AND ACC_FECHA = CURDATE() AND ACC_ESTADO = 2";
								$Result = mysqli_query($db, $Query);
								$Registros = mysqli_num_rows($Result);
								$Fila = mysqli_fetch_array($Result);

								$CodigoCierre = $Fila["ACC_CODIGO"];
								
								if($Registros > 0)
								{	
									$QueryDetalle = "SELECT * FROM Bodega.CIERRE_DETALLE WHERE ACC_CODIGO = '".$CodigoCierre."'";
									$ResultDetalle = mysqli_query($db, $QueryDetalle);
									$FilaDetalle = mysqli_fetch_array($ResultDetalle);

									$BilletesQ200   = $FilaDetalle["CD_Q_200"];
									$BilletesQ100   = $FilaDetalle["CD_Q_100"];
									$BilletesQ50    = $FilaDetalle["CD_Q_50"];
									$BilletesQ20    = $FilaDetalle["CD_Q_20"];
									$BilletesQ10    = $FilaDetalle["CD_Q_10"];
									$BilletesQ5     = $FilaDetalle["CD_Q_5"];
									$BilletesQ1     = $FilaDetalle["CD_Q_1"];
									$BilletesM1     = $FilaDetalle["CD_M_1"];
									$BilletesM50    = $FilaDetalle["CD_M_50"];
									$BilletesM25    = $FilaDetalle["CD_M_25"];
									$BilletesM10    = $FilaDetalle["CD_M_10"];
									$BilletesM_5    = $FilaDetalle["CD_M_5"];
									$BilletesQTotal = $FilaDetalle["CD_TOTAL_Q"];
									
									$BilletesD100   = $FilaDetalle["CD_D_100"];
									$BilletesD50    = $FilaDetalle["CD_D_50"];
									$BilletesD20    = $FilaDetalle["CD_D_20"];
									$BilletesD10    = $FilaDetalle["CD_D_10"];
									$BilletesD5     = $FilaDetalle["CD_D_5"];
									$BilletesD1     = $FilaDetalle["CD_D_1"];
									$BilletesDTotal = $FilaDetalle["CD_TOTAL_D"];

									$BilletesL500 = $FilaDetalle["CD_L_500"];
									$BilletesL100 = $FilaDetalle["CD_L_100"];
									$BilletesL50 = $FilaDetalle["CD_L_50"];
									$BilletesL20 = $FilaDetalle["CD_L_20"];
									$BilletesL10 = $FilaDetalle["CD_L_10"];
									$BilletesL5 = $FilaDetalle["CD_L_5"];
									$BilletesLTotal = $FilaDetalle["CD_TOTAL_L"];


									?>
									<form class="form" role="form" method="POST" action="CCModPro.php">
										<div class="row">
											<div class="col-lg-2">
												<div class="form-group floating-label">
													<input class="form-control" type="hidden" name="CodigoCierre" id="CodigoCierre" value="<?php echo $CodigoCierre ?>" required readonly/>
													<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" required readonly/>
													<label for="Fecha">Fecha Cierre</label>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group floating-label">
													<input class="form-control" type="text" name="NombrePuntoVenta" id="NombrePuntoVenta" value="Restaurante Terrazas" required readonly/>
													<label for="NombrePuntoVenta">Punto de Venta</label>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													 <button type="button" class="btn waves-effect waves-light btn-success">Editar</button>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													   <button type="button" class="btn ink-reaction btn-raised btn-warning" id="btnGuardarPartida" data-toggle="modal" data-target="#ModalFacturas">Validar</button> 
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="card tabs-left style-default-light">
													<ul class="card-head nav nav-tabs" data-toggle="tabs">
														<li class="active"><a href="#first5">Quetzales</a></li>
														<li class=""><a href="#second5">Dólares</a></li>
														<li><a href="#third5">Lempiras</a></li>
													</ul>
													<div class="card-body tab-content style-default-bright">
														<div class="tab-pane active" id="first5">
															<h3 class="text-light"><strong>Cuadre de Efectivo (Q)</strong></h3>
													<div class="row">
														<div class="col-xs-6"> 									
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesQ200 ?>" disabled/>
																	<label for="BQ200">Billetes de Q. 200</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"  value="<?php echo $BilletesQ100 ?>" disabled/>
																	<label for="BQ100">Billetes de Q. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"    value="<?php echo $BilletesQ50 ?>" disabled/>
																	<label for="BQ50">Billetes de Q. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   min="0"  value="<?php echo $BilletesQ20 ?>" disabled/>
																	<label for="BQ20">Billetes de Q. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesQ10 ?>" disabled/>
																	<label for="BQ10">Billetes de Q. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"    value="<?php echo $BilletesQ5 ?>" disabled/>
																	<label for="BQ5">Billetes de Q. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesQ1 ?>" disabled/>
																	<label for="BQ1">Billetes de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesM1 ?>" disabled/>
																	<label for="MQ1">Monedas de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"  value="<?php echo $BilletesM50 ?>" disabled/>
																	<label for="MQ50">Monedas de C. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesM25 ?>" disabled/>
																	<label for="MQ25">Monedas de C. 25</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"   value="<?php echo $BilletesM10 ?>" disabled/>
																	<label for="MQ10">Monedas de C. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number"  value="<?php echo $BilletesM_5 ?>" disabled/>
																	<label for="MQ5">Monedas de C. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-6">
																	<input class="form-control" type="number" step="any" name="TCQ" id="TCQ" min="0"  value="<?php echo $BilletesQTotal ?>" disabled/>
																	<label for="TCQ">Total de Cuadre en Quetzales</label>
																</div>
															</div>
															</div>
															<div class="col-xs-6">
																	<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ200" id="BQ200" min="0" required value="<?php echo $BilletesQ200 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="BQ200">Billetes de Q. 200</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ100" id="BQ100" min="0" required value="<?php echo $BilletesQ100 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="BQ100">Billetes de Q. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ50" id="BQ50" min="0" required value="<?php echo $BilletesQ50 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="BQ50">Billetes de Q. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ20" id="BQ20" min="0" required value="<?php echo $BilletesQ20 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="BQ20">Billetes de Q. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ10" id="BQ10" min="0" required value="<?php echo $BilletesQ10 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="BQ10">Billetes de Q. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ5" id="BQ5" min="0" required value="<?php echo $BilletesQ5 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="BQ5">Billetes de Q. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BQ1" id="BQ1" min="0" required value="<?php echo $BilletesQ1 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="BQ1">Billetes de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ1" id="MQ1" min="0" required value="<?php echo $BilletesM1 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="MQ1">Monedas de Q. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ50" id="MQ50" min="0" required value="<?php echo $BilletesM50 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="MQ50">Monedas de C. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ25" id="MQ25" min="0" required value="<?php echo $BilletesM25 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="MQ25">Monedas de C. 25</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ10" id="MQ10" min="0" required value="<?php echo $BilletesM10 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="MQ10">Monedas de C. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="MQ5" id="MQ5" min="0" required value="<?php echo $BilletesM_5 ?>" onchange="CalcularTotalQ();EditHead()"/>
																	<label for="MQ5">Monedas de C. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-6">
																	<input class="form-control" type="number" step="any" name="TCQ" id="TCQ" min="0" required value="<?php echo $BilletesQTotal ?>" readonly/>
																	<label for="TCQ">Total de Cuadre en Quetzales</label>
																</div>
															</div>
															</div>
														</div>
													</div>
														<div class="tab-pane" id="second5">
															<h3 class="text-light"><strong>Cuadre de Efectivo ($)</strong></h3>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD100" id="BD100" min="0" required value="<?php echo $BilletesD100 ?>" onchange="CalcularTotalD()"/>
																	<label for="BD100">Billetes de $. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD50" id="BD50" min="0" required value="<?php echo $BilletesD50 ?>" onchange="CalcularTotalD()"/>
																	<label for="BD50">Billetes de $. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD20" id="BD20" min="0" required value="<?php echo $BilletesD20 ?>" onchange="CalcularTotalD()"/>
																	<label for="BD20">Billetes de $. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD10" id="BD10" min="0" required value="<?php echo $BilletesD10 ?>" onchange="CalcularTotalD()"/>
																	<label for="BD10">Billetes de $. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD5" id="BD5" min="0" required value="<?php echo $BilletesD5 ?>" onchange="CalcularTotalD()"/>
																	<label for="BD5">Billetes de $. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BD1" id="BD1" min="0" required value="<?php echo $BilletesD1 ?>" onchange="CalcularTotalD()"/>
																	<label for="BD1">Billetes de $. 1</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="TCD" id="TCD" min="0" required value="<?php echo $BilletesDTotal ?>" readonly />
																	<label for="TCD">Total de Cuadre en Dólares</label>
																</div>
															</div>
														</div>
														<div class="tab-pane" id="third5">
															<h3 class="text-light"><strong>Cuadre de Efectivo (L)</strong></h3>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL500" id="BL500" min="0" required value="<?php echo $BilletesL500 ?>" onchange="CalcularTotalL()"/>
																	<label for="BL500">Billetes de L. 500</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL100" id="BL100" min="0" required value="<?php echo $BilletesL100 ?>" onchange="CalcularTotalL()"/>
																	<label for="BL100">Billetes de L. 100</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL50" id="BL50" min="0" required value="<?php echo $BilletesL50 ?>" onchange="CalcularTotalL()"/>
																	<label for="BL50">Billetes de L. 50</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL20" id="BL20" min="0" required value="<?php echo $BilletesL20 ?>" onchange="CalcularTotalL()"/>
																	<label for="BL20">Billetes de L. 20</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL10" id="BL10" min="0" required value="<?php echo $BilletesL10 ?>" onchange="CalcularTotalL()"/>
																	<label for="BL10">Billetes de L. 10</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-3">
																	<input class="form-control" type="number" name="BL5" id="BL5" min="0" required value="<?php echo $BilletesL5 ?>" onchange="CalcularTotalL()"/>
																	<label for="BL5">Billetes de L. 5</label>
																</div>
															</div>
															<div class="row">
																<div class="form-group floating-label col-lg-6">
																	<input class="form-control" type="number" name="TCL" id="TCL" min="0" required value="<?php echo $BilletesLTotal ?>" readonly />
																	<label for="TCL">Total de Cuadre en Lempiras</label>
																</div>
															</div>
														</div>
													</div><!--end .card-body -->
												</div><!--end .card -->
											</div>
										</div>
										<div class="row">
											<div class="row text-center">
												<button type="submit" class="btn btn-success">
												<span class="glyphicon glyphicon-ok"></span> Actualizar Cierre
												</button>
											</div>
										</div>
									</form>
									<?php
								}
								else
								{
									?>	
	
									<div class="alert alert-danger text-center" role="alert">
										<strong>No se encontró ningun registro con los criterios de búsquda</strong>
									</div>
									<div class="col-lg-12 text-center">
										<a href="CC.php"><button type="button" class="btn btn-primary">Regresar</button></a>
									</div>

									<?php
								}

							?>
						</div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
 
<div class="modal fade" tabindex="-1" role="dialog" id="ModalFacturas" >
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Credenciales de inicio de sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
	      	 <div class="form-group">
	          <div class="col-xs-6">
	            <input required="" class="form-control" type="text" required="" placeholder="Usuario" name="username" id="username">
	          </div>
		      </div> 
		</div>
		<div class="row">
	        <div class="form-group ">
	          <div class="col-xs-6">
	            <input required="" class="form-control" type="password" required="" placeholder="Contraseña" id="password" name="password" required>
	          </div>
	        </div> 
      	</div> 
      </div> 
      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary" onclick="ValidarCredenciales()">Validar</button>
      </div>
    </div>
  </div>
</div>
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
	<script>
		function ValidarCredenciales()
		{
			var Codigo = $("#CodigoCierre").val();
			var Usuario = $("#username").val();
			var Password = $("#password").val();
			$.ajax({
				url: 'Ajax/ComprobarUsuario.php',
				type: 'POST',
				dataType: 'html',
				data: {Usuario:Usuario, Password:Password},
				success:function(data)
				{
					if (data==3) 
					{
						alertify.error("No tiene permisos...");
					}
					else if (data==2) 
					{
						alertify.error("Usuario o contraseña incorrecta..");
					}
					else 
						
					{
						var User = data;
						$.ajax({
							url: 'Ajax/GuardarValidacion.php',
							type: 'POST',
							dataType: 'html',
							data: {User:User, Codigo:Codigo},
							success:function(data)
							{
								if (data==1) 
								{
									location.reload();
								}
								else
								{
									alertify.error("Error en la verificación.")
								}
							} 
						}) 						
					}
				}
			}) 
			
		}
	</script>
	</body> 
	</html>
