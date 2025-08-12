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

	<script language=javascript type=text/javascript>
		$(document).on("keypress", 'form', function (e) {
		    var code = e.keyCode || e.which;
		    if (code == 13) {
		        e.preventDefault();
		        return false;
		    }
		});
	</script>
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="THRePro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Asignar un Talonario de Ticket a Hotel</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select name="HotelV" id="HotelV" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Taquilla.HOTEL WHERE H_ESTADO = 1 ORDER BY H_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													echo '<option value="'.$row["H_CODIGO"].'">'.$row["H_NOMBRE"].'</option>';
												}

												?>
											</select>
											<label for="HotelV">Hotel Actual</label>
										</div>
										<div class="form-group">
											<select name="Hotel" id="Hotel" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Taquilla.HOTEL WHERE H_ESTADO = 1 ORDER BY H_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													echo '<option value="'.$row["H_CODIGO"].'">'.$row["H_NOMBRE"].'</option>';
												}

												?>
											</select>
											<label for="Hotel">Nuevo Hotel</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-2">
										<div class="form-group">
											<input type="number" name="Del" id="Del" class="form-control" required="required">
											<label for="Del">Del</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-2">
										<div class="form-group">
											<input type="number" name="Al" id="Al" class="form-control" required="required">
											<label for="Al">Al</label>
										</div>
									</div>
								</div>
                                <div class="row">
									<div class="col-lg-2">
										<div class="form-group">
											<input type="text" name="Razon" id="Razon" class="form-control" required="required">
											<label for="Razon">Razón de la Reasignación</label>
										</div>
									</div>
								</div>
								<!-- <div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<select name="TipoTalonario" class="form-control" required="required">
												<option value="" selected disabled>Seleccione una opción</option>
												<option value="1">Tickets para Niño Menor a 5 Años</option>
												<option value="2">Tickets para Niño</option>
												<option value="3">Tickets para Adulto</option>
											</select>
											<label for="TipoTalonario">Tipo de Talonario</label>
										</div>
									</div>
								</div> -->
								<div class="row text-center">
									<button type="submit" class="btn btn-primary btn-lg">Enviar</button>
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
	</html>
