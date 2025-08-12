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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Nomenclatura</strong><br></h1>
				<br>
				<form class="form" action="NOMENModPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Editar Cuenta Contable</strong></h4>
							</div>
							<div class="card-body">
								<?php 
								$Codigo = $_GET["Codigo"];
								$Consulta = "SELECT * FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO = '".$Codigo."'";
								$Resultado = mysqli_query($db, $Consulta);
								while($row = mysqli_fetch_array($Resultado))
								{
									$Nombre = $row["N_NOMBRE"];
									$Tipo = $row["N_TIPO"];
								}
								?>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
										<input class="form-control" type="text" name="CodigoCuenta" id="CodigoCuenta" value="<?php echo $Codigo; ?>" required readonly/>
											<label for="CodigoCuenta">Código de la Cuenta</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $Nombre; ?>"  required/>
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Tipo" id="Tipo" class="form-control" required>
												<option <?php if($Tipo == 'GM'){echo 'selected';} ?> value="GM">Grupo Matriz</option>
												<option <?php if($Tipo == 'G'){echo 'selected';} ?> value="G">Grupo</option>
												<option <?php if($Tipo == 'S'){echo 'selected';} ?> value="S">Subgrupo</option>
												<option <?php if($Tipo == 'D'){echo 'selected';} ?> value="D">Debe</option>
												<option <?php if($Tipo == 'H'){echo 'selected';} ?>value="H">Haber</option>
											</select>
											<label for="Tipo">Tipo</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
						<a href="NOMEN.php"><button type="button" class="btn ink-reaction btn-raised btn-warning">Cancelar</button></a>
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
