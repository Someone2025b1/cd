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
	function AbrirProveedores()
		{
			window.open('Proveedores.php','popup','width=750, height=700');
		}
		function VerificarProveedor(x)
		{
			$.ajax({
				type: "POST",
				url: "ComprobarNIT.php",
				data: 'NIT='+x,
				beforeSend: function()
				{
					$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
				},
				success: function(data) 
				{
					if(data != 0)
					{
						alertify.error('El NIT ya se encuentra registrado en la base de datos de proveedores');
						$('#btnEnviar').attr("disabled", true);
					}
					else
					{
						$('#btnEnviar').attr("disabled", false);
					}
				},
				error: function(data) 
				{
					alert('Error algo salió mal');
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
				<h1 class="text-center"><strong>Mantenimiento de Proveedores</strong><br></h1>
				<br>
				<form class="form" action="PROAddPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Proveedor</strong></h4>
							</div>
							<div class="card-body">
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
											<input class="form-control" type="text" name="Nombre" id="Nombre" required/>
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div> 
								<div class="row" >
									<div class="col-lg-3 col-lg-9">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="NIT" id="NIT" onchange="VerificarProveedor(this.value)" required/>
											<label for="NIT"># de NIT</label>
										</div>
									</div>
									<div class="col-lg-3 col-lg-9">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="DPI" id="DPI" required/>
											<label for="DPI"># de DPI</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Direccion" id="Direccion" required></textarea>
											<label for="Direccion">Dirección</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="Telefono1" id="Telefono1" min="8" required/>
											<label for="Telefono1">Número de Teléfono Principal</label>
										</div>
									</div>
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="number" name="Telefono2" id="Telefono2" min="8"/>
											<label for="Telefono2">Número de Teléfono Secundario</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="email" name="Email" id="Email" />
											<label for="Email">Correo Electrónico</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="CuentaBancaria" id="CuentaBancaria"/>
											<label for="CuentaBancaria">No. Cuenta Bancaria</label>
										</div>
									</div>
								</div>
								<div class="row" >
									<div class="col-lg-4 col-lg-8">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="NombreCuentaBancaria" id="NombreCuentaBancaria"/>
											<label for="NombreCuentaBancaria">Nombre de Cuenta Bancaria</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Banco" id="Banco" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT * FROM Contabilidad.BANCO ORDER BY B_NOMBRE";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["B_CODIGO"].'">'.$row["B_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="Banco">Banco</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Regimen" id="Regimen" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT * FROM Contabilidad.REGIMEN ORDER BY REG_NOMBRE";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["REG_CODIGO"].'">'.$row["REG_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="Regimen">Tipo de Régimen</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="TipoFactura" id="TipoFactura" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT * FROM Contabilidad.TIPO_FACTURA ORDER BY TF_NOMBRE";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["TF_CODIGO"].'">'.$row["TF_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="TipoFactura">Tipo de Factura que Maneja</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="TipoProveedor" id="TipoProveedor" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="1">Proveedor Local</option>
												<option value="2">Proveedor del Exterior</option>
											</select>
											<label for="TipoProveedor">Tipo de Proveedor</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnEnviar" disabled>Guardar</button>
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
	<script src="../../../../../libs/alertify/js/alertify.js"></script>
	<!-- END JAVASCRIPT -->

	</body>
	</html>
