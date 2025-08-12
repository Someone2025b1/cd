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
	<!-- END STYLESHEETS -->
	
	<script>
	function ValidarResolucion(x)
	{
		var Tipo = $('#Tipo').val();
		//Validar si hay Activo algúna resolución
		if(x.value == 1)
		{
			$.ajax({
				type: "POST",
				url: "VerificarResolucionActiva.php",
				data: 'Tipo='+Tipo,
				beforeSend: function()
				{
					$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
				},
				success: function(data) {
					
				},
				error: function(){
					alert('Error');
				}
			});
		}
		else if(x.value == 2)
		{
			
		}
	}
	</script>
	
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

	<?php
		$Codigo = $_GET["Codigo"];

		$Consulta = "SELECT * FROM Bodega.RESOLUCION WHERE RES_NUMERO = '".$Codigo."'";
		$Resultado = mysqli_query($db, $Consulta);
		while($fila = mysqli_fetch_array($Resultado))
		{
			$FechaResolucion            = $fila["RES_FECHA_RESOLUCION"];
			$Serie                      = $fila["RES_SERIE"];
			$Del                        = $fila["RES_DEL"];
			$Al                         = $fila["RES_AL"];
			$FechaVencimientoResolucion = $fila["RES_FECHA_VENCIMIENTO"];
			$Estado                     = $fila["RES_ESTADO"];
			$Tipo                       = $fila["RES_TIPO"];
			$FechaIngreso               = $fila["RES_FECHA_INGRESO"];
			$TipoDocumento              = $fila["RES_TIPO_DOCUMENTO"];
		}


		//ALERTA PARA CONSUMO DE MAS DEL 75% DE FACTURAS DE UNA RESOLUCION
		$Consulta1 = "SELECT RES_SERIE, RES_AL FROM Bodega.RESOLUCION WHERE RES_ESTADO = 1 AND RES_TIPO = '".$Tipo."'";
		$Resultado1 = mysqli_query($db, $Consulta1);
		while($Fila1 = mysqli_fetch_array($Resultado1))
		{
			$Serie = $Fila1["RES_SERIE"];
			$Final = $Fila1["RES_AL"];

			$SubConsulta1 = "SELECT MAX(F_NUMERO) AS TOTAL FROM Bodega.FACTURA WHERE F_SERIE = '".$Serie."' ";
			$SubResultado1 = mysqli_query($db, $SubConsulta1);
			while($SubFila1 = mysqli_fetch_array($SubResultado1))
			{
				$TotalFacturas = $SubFila1["TOTAL"];

				$TotalConsumo = (100 * $TotalFacturas) / $Final;
			}
		}

	?>

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Resoluciones</strong><br></h1>
				<br>
				<form class="form" action="ResModPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales de la Resolución</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
											<input class="form-control" type="text" name="NumeroResolucion" id="NumeroResolucion" value="<?php echo $Codigo; ?>" readonly  required/>
											<label for="NumeroResolucion">Número de Resolución</label>
										</div>
									</div>
									<div class="col-lg-8" id="DIVResultado"></div>
								</div>
								<div class="row">
									<div class="col-lg-2">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaResolucion" id="FechaResolucion" value="<?php echo $FechaResolucion; ?>" readonly required/>
											<label for="FechaResolucion">Fecha de Resolución</label>
										</div>
									</div>
								</div> 
								<div class="row" >
									<div class="col-lg-2">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Serie" id="Serie" value="<?php echo $Serie; ?>" readonly required/>
											<label for="Serie"># de Serie</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-2">
										<div class="form-group">
											<input class="form-control" type="number" name="RangoInicial" id="RangoInicial" min="0" value="<?php echo $Del; ?>" readonly required />
											<label for="RangoInicial">Rando Inicial (Del)</label>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="RangoFinal" id="RangoFinal" min="0" value="<?php echo $Al; ?>" readonly required/>
											<label for="RangoFinal">Rango Final (Al)</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaVencimientoResolucion" id="FechaVencimientoResolucion" value="<?php echo $FechaVencimientoResolucion; ?>" readonly required/>
											<label for="FechaVencimientoResolucion">Fecha de Vencimiento de Resolución</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="TipoDocumento" id="TipoDocumento" value="<?php echo $TipoDocumento; ?>" readonly required/>
											<label for="TipoDocumento">Tipo de Documento</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select class="form-control" name="Tipo" id="Tipo" required readonly>
												<?php
												if($Tipo == 'TR')
												{
													echo '<option value="TR">Restaurante</option>';
												}
												elseif($Tipo == 'SV')
												{
													echo '<option value="SV">Souvenirs</option>';
												}
												elseif($Tipo == 'KR')
												{
													echo '<option value="KR">Kiosko</option>';
												}
												elseif($Tipo == 'TQ')
												{
													echo '<option value="TQ">Taquilla</option>';
												}
												elseif($Tipo == 'EV')
												{
													echo '<option value="EV">Eventos</option>';
												}
												?>
											</select>
											<label for="Tipo">De</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select class="form-control" name="Estado" required onchange="ValidarResolucion(this)">
												<option value="0" disabled <?php if($Estado == 0){echo 'selected';}?>>Inactivo (Por Usar)</option>
												<option value="1" <?php if($Estado == 1){echo 'selected';}?>>Activo</option>
												<option value="2" <?php if($Estado == 2){echo 'selected';}?>>Inactivo (Completo)</option>
											</select>
										</div>
										<em id="EMCIF" class="text-danger"><?php if($TotalConsumo >= 75){echo 'ALERTA: La resolución actualmente tiene consumido el '.number_format($TotalConsumo, 2, '.', ',').'% de su totalidad';} ?></em>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="BtnEnviar">Guardar</button>
					</div>
					<br>
					<br>
				</form>
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
