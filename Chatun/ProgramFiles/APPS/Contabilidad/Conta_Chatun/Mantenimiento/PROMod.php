<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
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
	<!-- END STYLESHEETS -->

</head>

<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<?php
		$Codigo = $_GET["Codigo"];

		$Consulta = "SELECT * FROM Contabilidad.PROVEEDOR WHERE P_CODIGO = '" . $Codigo . "'";
		$Resultado = mysqli_query($db, $Consulta);
		while ($fila = mysqli_fetch_array($Resultado)) {
			$Nombre         = $fila["P_NOMBRE"];
			$NIT            = $fila["P_NIT"];
			$DPI            = $fila["P_DPI"];
			$Direccion      = $fila["P_DIRECCION"];
			$Telefono1      = $fila["P_TELEFONO"];
			$Telefono2      = $fila["P_TELEFONO1"];
			$Email          = $fila["P_EMAIL"];
			$Regimen        = $fila["REG_CODIGO"];
			$CuentaBancaria = $fila["P_CODIGO_CUENTA"];
			$NombreCuenta   = $fila["P_NOMBRE_CUENTA"];
			$Banco          = $fila["B_CODIGO"];
			$TipoFactura    = $fila["TF_CODIGO"];
			$DiasCredito    = $fila["P_DIAS_CREDITO"];
			$TipoProveedor    = $fila["TipoProveedor"];
		}

		?>

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Consulta de Proveedor</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Proveedores</strong></h4>
						</div>
						<div class="card-body">
							<form class="form" action="PROModPro.php" method="POST">
								<div class="row">
									<div class="col-lg-12" align="right">
										<span class="input-group-btn">
											<button class="btn btn-success" type="button" onclick="AbrirProveedores()">Consultar Proveedores</button>
										</span>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Codigo" id="Codigo" value="<?php echo $Codigo; ?>" required readonly />
											<label for="Codigo">Código Contable</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $Nombre; ?>" required />
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3 col-lg-9">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="NIT" id="NIT" value="<?php echo $NIT; ?>" required />
											<label for="NIT"># de NIT</label>
										</div>
									</div>
									<div class="col-lg-3 col-lg-9">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="DPI" id="DPI" value="<?php echo $DPI; ?>" required />
											<label for="DPI"># de DPI</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Direccion" id="Direccion" required><?php echo $Direccion; ?></textarea>
											<label for="Direccion">Dirección</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="Telefono1" id="Telefono1" value="<?php echo $Telefono1; ?>" min="8" required />
											<label for="Telefono1">Número de Teléfono Principal</label>
										</div>
									</div>
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="Telefono2" id="Telefono2" value="<?php echo $Telefono2; ?>" min="8" />
											<label for="Telefono2">Número de Teléfono Secundario</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="email" name="Email" id="Email" value="<?php echo $Email; ?>" />
											<label for="Email">Correo Electrónico</label>
										</div>
									</div>
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="DiasCredito" id="DiasCredito" value="<?php echo $DiasCredito; ?>" />
											<label for="DiasCredito">Días de Crédito</label>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="CuentaBancaria" id="CuentaBancaria" value="<?php echo $CuentaBancaria; ?>" required />
											<label for="CuentaBancaria">No. Cuenta Bancaria</label>
										</div>
									</div>
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="NombreCuentaBancaria" id="NombreCuentaBancaria" value="<?php echo $NombreCuenta; ?>" required />
											<label for="NombreCuentaBancaria">Nombre de Cuenta Bancaria</label>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Banco" id="Banco" class="form-control" required>
												<?php
												//Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Contabilidad.BANCO ORDER BY B_NOMBRE";
												$result = mysqli_query($db, $query);
												while ($row = mysqli_fetch_array($result)) {
													if ($row["B_CODIGO"] == $Banco) {
														$Selected = 'selected';
													} else {
														$Selected = '';
													}
													echo '<option value="' . $row["B_CODIGO"] . '" ' . $Selected . '>' . $row["B_NOMBRE"] . '</option>';
												}

												?>
											</select>
											<label for="Banco">Banco</label>
										</div>
									</div>
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="TipoFactura" id="TipoFactura" class="form-control" required>
												<?php
												//Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Contabilidad.TIPO_FACTURA ORDER BY TF_NOMBRE";
												$result = mysqli_query($db, $query);
												while ($row = mysqli_fetch_array($result)) {
													if ($row["TF_CODIGO"] == $TipoFactura) {
														$Selected = 'selected';
													} else {
														$Selected = '';
													}
													echo '<option value="' . $row["TF_CODIGO"] . '" ' . $Selected . '>' . $row["TF_NOMBRE"] . '</option>';
												}

												?>
											</select>
											<label for="TipoFactura">Tipo Factura</label>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Regimen" id="Regimen" class="form-control" required>
												<?php
												//Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Contabilidad.REGIMEN ORDER BY REG_NOMBRE";
												$result = mysqli_query($db, $query);
												while ($row = mysqli_fetch_array($result)) {
													if ($row["REG_CODIGO"] == $Regimen) {
														$Selected = 'selected';
													} else {
														$Selected = '';
													}
													echo '<option value="' . $row["REG_CODIGO"] . '" ' . $Selected . '>' . $row["REG_NOMBRE"] . '</option>';
												}

												?>
											</select>
											<label for="Regimen">Tipo de Régimen</label>
										</div>
									</div>
									<?php
									// --- Consulta del proveedor (ejemplo) ---
									$Codigo = $_GET['Codigo'] ?? '';
									$TipoProveedor = null;

									if ($Codigo !== '') {
										$Consulta = "SELECT * FROM Contabilidad.PROVEEDOR WHERE P_CODIGO = '" . mysqli_real_escape_string($db, $Codigo) . "'";
										$Resultado = mysqli_query($db, $Consulta);
										if ($Resultado && mysqli_num_rows($Resultado) > 0) {
											$fila = mysqli_fetch_assoc($Resultado);
											// Asegúrate de leer la columna correcta: en tu tabla se llama P_TIPO
											$TipoProveedor = isset($fila['P_TIPO']) ? (int)$fila['P_TIPO'] : null;
										}
									}
									// ahora $TipoProveedor contiene 1, 2 o null
									?>
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="TipoProveedor" id="TipoProveedor" class="form-control" required>
												<!-- Si estás en modo edición, no conviene dejar el placeholder seleccionado -->
												<option value="" disabled <?php echo ($TipoProveedor === null ? 'selected' : ''); ?>>Seleccione una opción</option>

												<option value="1" <?php echo ($TipoProveedor === 1 ? 'selected' : ''); ?>>Proveedor Local</option>
												<option value="2" <?php echo ($TipoProveedor === 2 ? 'selected' : ''); ?>>Proveedor del Exterior</option>
											</select>
											<label for="TipoProveedor">Tipo de Proveedor <?php echo "" . $TipoProveedor ?></label>
										</div>
									</div>
								</div>
								<div class="col-lg-12" align="center">
									<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
									<a href="PRO.php"><button type="button" class="btn ink-reaction btn-raised btn-warning">Cancelar</button></a>
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
		<!-- END JAVASCRIPT -->

</body>

</html>