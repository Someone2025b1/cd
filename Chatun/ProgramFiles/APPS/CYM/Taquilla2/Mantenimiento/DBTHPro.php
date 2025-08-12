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
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="DBTHProPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Dar de Baja un Talonario</strong></h4>
							</div>
							<div class="card-body">
							<?php 
								$Query = mysqli_query($db, "SELECT A.*, B.H_NOMBRE
													FROM Taquilla.ASIGNACION_TALONARIO_TICKET AS A 
													INNER JOIN Taquilla.HOTEL AS B
													ON A.H_CODIGO = B.H_CODIGO
													WHERE A.H_CODIGO = '".$_GET[Codigo]."'");
								$Fila = mysqli_fetch_array($Query);

								$Hotel = $Fila["H_NOMBRE"];
								$Del = $Fila["ATT_DEL"];
								$Al = $Fila["ATT_AL"];
								$TipoTalonario = $Fila["ATT_TIPO_TALONARIO"];
								$Codigo = $_GET["Codigo"];							
							?>

							<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<input type="text" name="Hotel" id="Hotel" class="form-control" required="required" value="<?php echo $Hotel ?>" readonly>
											<input type="hidden" name="Codigo" id="Codigo" class="form-control" required="required" value="<?php echo $Codigo ?>" readonly>
											<label for="Hotel">Hotel</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group"> 
											<input onclick="validar()" type="checkbox" name="TipoBaja" id="TipoBaja" class="form-control">
											<label for="Hotel">Vale en Específico</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-2">
										<div class="form-group">
											<select id="talonario" name="talonario" class="form-control" onchange="verVales(this.value)">
												<option selected="" disabled="">Seleccione</option>
												<?php 
												$QuerySelect = mysqli_query($db, "SELECT a.ATT_CODIGO, a.ATT_DEL, a.ATT_AL FROM Taquilla.ASIGNACION_TALONARIO_TICKET a
												WHERE a.H_CODIGO = $_GET[Codigo] and ATT_ESTADO = 0");
												while ($Row = mysqli_fetch_array($QuerySelect)) 
												{
												?>
												<option value="<?php echo $Row[ATT_CODIGO] ?>"><?php echo $Row["ATT_DEL"]."-".$Row["ATT_AL"]?></option>
												<?php 
												}
												?>
											</select>
											<label for="Del">Talonario</label>
										</div>
									</div>
								</div> 
								<div id="Detalle" style="display: none">
								<div id="divVale"></div>
								</div>
								<!-- <div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<select name="TipoTalonario" class="form-control" required="required" readonly>
												<option value="" selected disabled>Seleccione una opción</option>
												<option <?php if($TipoTalonario == 1){echo 'selected'; } ?> value="1">Tickets para Niño Menor a 5 Años</option>
												<option <?php if($TipoTalonario == 2){echo 'selected'; } ?> value="2">Tickets para Niño</option>
												<option <?php if($TipoTalonario == 3){echo 'selected'; } ?> value="3">Tickets para Adulto</option>
											</select>
											<label for="TipoTalonario">Tipo de Talonario</label>
										</div>
									</div>
								</div> -->
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<input type="text" name="Razon" id="Razon" class="form-control" required="required">
											<label for="Razon">¿Por que va a Anular el talonario?</label>
										</div>
									</div>
								</div>
								<div class="row text-center">
									<button type="submit" class="btn btn-primary">Guardar</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../../Hotel/MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	<script>

		function validar()
		{
			var TipoBaja = $("#TipoBaja").prop( "checked");
			if (TipoBaja==true) 
			{ 
				$("#Detalle").show();
			}
			else
			{
				$("#Detalle").hide();
			}
		}

		 

		 function verVales(Id)
    { 
        $.ajax({
            url: 'Ajax/SaberVales.php',
            type: 'POST',
            dataType: 'html',
            data: {Id:Id},
            success: function(data)
            { 
                $("#divVale").html(data);
            }
        })
                
    }
	</script>
	</html>

