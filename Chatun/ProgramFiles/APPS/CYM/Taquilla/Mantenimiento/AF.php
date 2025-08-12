<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
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
	
    <script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

	<script>
		function EnviarFormulario()
		{
			var Pass = $('#Password').val();
			var UserID = $('#UserID').val();
			$.ajax({
				url: 'ComprobarContra.php',
				type: 'POST',
				data: 'id='+Pass+'&user='+UserID,
				success: function(opciones)
				{
					if(opciones == 1)
					{
						$('#FormularioEnviar').submit();
					}
					else
					{
						var Pass = $('#PassDescuento').val('');
						alertify.error('La contraseña es incorrecta');
					}
					
				},
				error: function(opciones)
				{
					alert('Error'+opciones);
				}
			})
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php"); ?>

	<!-- BEGIN BASE-->
	<div id="base">
		<input type="text" id="UserID" value="<?php echo $id_user;?>" />
		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Anulación de Factura</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Búsqueda de Factura</strong></h4>
						</div>
						<div class="card-body">
							<form class="form" action="#" method="POST" role="form" id="FormularioEnviar">
								<div class="row">
									<div class="form-group floating-label col-lg-2">
										<input class="form-control" type="text" name="Serie" id="Serie" value="<?php if(isset($_POST["Serie"])){ echo $_POST["Serie"];} ?>" required/>
										<label for="Serie">Serie</label>
									</div>
									<div class="form-group floating-label col-lg-2">
										<input class="form-control" type="number" name="Numero" id="Numero" value="<?php if(isset($_POST["Numero"])){ echo $_POST["Numero"];} ?>" required/>
										<label for="Numero">Número</label>
									</div>
								</div>
								<div class="row">
									<div class="form-group floating-label col-lg-2">
										<input class="form-control" type="password" name="Password" id="Password" required/>
										<label for="Password">Contraseña</label>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-lg-12 text-center">
										<button type="button" class="btn btn-success" onclick="EnviarFormulario()">
											<span class="glyphicon glyphicon-ok"></span> Buscar
										</button>
									</div>
								</div>
							</form>
							<form class="form" action="AFPro.php" method="POST" role="form" >
								<div class="container">
									<br>
									<br>
								</div>
								<div class="row">
									<?php
										if(isset($_POST["Serie"]) && isset($_POST["Numero"]))
										{
											$Query = "SELECT FACTURA_TQ.*, CLIENTE.* 
														FROM Bodega.FACTURA_TQ, Bodega.CLIENTE 
														WHERE FACTURA_TQ.CLI_NIT = CLIENTE.CLI_NIT
														AND FACTURA_TQ.F_SERIE = '".trim($_POST["Serie"])."' AND FACTURA_TQ.F_NUMERO = ".$_POST["Numero"];
											$Result = mysqli_query($db, $Query);
											$Registros = mysqli_num_rows($Result);

											if($Registros > 0)
											{
												while($Fila = mysqli_fetch_array($Result))
												{
													$NIT          = $Fila["CLI_NIT"];
													$Nombre       = $Fila["CLI_NOMBRE"];
													$Direccion    = $Fila["CLI_DIRECCION"];
													$Fecha        = $Fila["F_FECHA_TRANS"];
													$Hora         = $Fila["F_HORA"];
													$TotalFactura = $Fila["F_TOTAL"];
													$Moneda       = $Fila["F_MONEDA"];
													$Elaboro      = $Fila["F_USUARIO"];
													$Orden        = $Fila["F_ORDEN"];
													$CodigoTrans  = $Fila["F_CODIGO"];

													if($Moneda == 1)
													{
														$Moneda = 'Quetzales';
													}
													elseif($Moneda == 2)
													{
														$Moneda = 'Dólares';
													}
													else
													{
														$Moneda = 'Lempiras';
													}
												}
												?>
												
												<div class="container">
													<div class="form-group floating-label col-lg-2">
														<input class="form-control" type="text" name="Serie" id="Serie" value="<?php if(isset($_POST["Serie"])){ echo strtoupper($_POST["Serie"]);} ?>" readonly required/>
														<label for="Serie">Serie</label>
													</div>
													<div class="form-group floating-label col-lg-2">
														<input class="form-control" type="number" name="Numero" id="Numero" value="<?php if(isset($_POST["Numero"])){ echo strtoupper($_POST["Numero"]);} ?>" readonly required/>
														<label for="Numero">Número</label>
													</div>
												</div>
												<div class="container">
													<div class="form-group floating-label col-lg-2">
														<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $Fecha; ?>" readonly required/>
														<label for="Fecha">Fecha de Factura</label>
													</div>
													<div class="form-group floating-label col-lg-2">
														<input class="form-control" type="text" name="Hora" id="Hora" value="<?php echo $Hora; ?>" readonly required/>
														<label for="Hora">Hora de Factura</label>
													</div>
													<div class="form-group floating-label col-lg-5">
														<input class="form-control" type="text" name="Elaboro" id="Elaboro" value="<?php echo saber_nombre_colaborador($Elaboro); ?>" readonly required/>
														<label for="Elaboro">Elaboró Factura</label>
													</div>
												</div>
												<div class="container">
													<div class="form-group floating-label col-lg-2">
														<input class="form-control" type="text" name="NIT" id="NIT" value="<?php echo $NIT; ?>" readonly required/>
														<label for="NIT">NIT</label>
													</div>
													<div class="form-group floating-label col-lg-5">
														<input class="form-control" type="text" name="Numero" id="Numero" value="<?php echo $Nombre; ?>" readonly  required/>
														<label for="Numero">Nombre</label>
													</div>
												</div>
												<div class="container">
													<div class="form-group floating-label col-lg-8">
														<input class="form-control" type="text" name="Direccion" id="Direccion" value="<?php echo $Direccion; ?>" readonly required/>
														<label for="Direccion">Dirección</label>
													</div>
												</div>
												<div class="container">
													<div class="form-group floating-label col-lg-2">
														<input class="form-control" type="number" step="any" name="TotalFactura" id="TotalFactura" value="<?php echo $TotalFactura; ?>" readonly required/>
														<label for="TotalFactura">Total de Factura</label>
													</div>
													<div class="form-group floating-label col-lg-2">
														<input class="form-control" type="number" step="any" name="Orden" id="Orden" value="<?php echo $Orden; ?>" readonly required/>
														<label for="Orden">Número Orden</label>
													</div>
												</div>
												<div class="container">
													<div class="form-group floating-label col-lg-2">
														<input class="form-control" type="text" step="any" name="Moneda" id="Moneda" value="<?php echo $Moneda; ?>" readonly  required/>
														<label for="Moneda">Moneda</label>
													</div>
												</div>
												<div class="container">
													<div class="form-group floating-label col-lg-8">
														<input class="form-control" type="hidden" name="Codigo" id="Codigo" value="<?php echo $CodigoTrans; ?>" required/>
														<input class="form-control" type="text" name="Razon" id="Razon" required/>
														<label for="Razon">Razón de Anulación</label>
													</div>
												</div>
												<div class="row">
													<div class="form-group col-lg-12 text-center">
														<button type="submit" class="btn btn-success">
															<span class="glyphicon glyphicon-remove"></span> Anular
														</button>
													</div>
												</div>

												<?php
											}
											else
											{
												?>
												<div class="alert alert-callout alert-success" role="alert">
													La Factura <?php echo strtoupper($_POST["Serie"]).'-'.$_POST["Numero"]; ?>, no está ingresada.
												</div>
												<?php
											}
										}
									?>
								</div>
							</form>
						</div>
					</div>
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
		<script src="../../../../../libs/alertify/js/alertify.js"></script>
		<!-- END JAVASCRIPT -->

	</body>
	</html>
