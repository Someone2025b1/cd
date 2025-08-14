<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Portal Institucional Chatún</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Mantengo tus hojas originales para no romper nada -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>

	<!-- Fontawesome CDN (para iconos) -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

	<!-- OVERRIDES ESPECÍFICOS: aplican por encima de materialadmin -->
	<style>
		:root{
      --verde-principal: #8BC34A;   /* color que mencionaste */
      --fondo: #f3f4f6;
      --card-radius: 12px;
      --card-shadow: 0 6px 20px rgba(20,20,30,0.06);
    }

    body {
      background: var(--fondo);
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color: #333;
      
    }

    

    /* Card principal */
    .card-form {
      border-radius: var(--card-radius);
      box-shadow: var(--card-shadow);
      overflow: hidden;
	  max-width: 100%;
    }
    .card-head {
      background: var(--verde-principal);
      color: #fff;
      padding: 16px 22px;
    }
    .card-head h4 { margin:0; font-weight:700; font-size:1.05rem; letter-spacing:0.2px; }

    .card-body {
      padding: 24px;
      background: #fff;
    }

    /* Inputs */
    .form-control {
      border-radius: 8px;
      height: calc(2.6rem + 2px);
      box-shadow: none;
      border: 1px solid #e6e6e6;
	  max-width: 100%;
    }
    .form-label{
      font-weight:600;
      font-size:0.9rem;
    }
    textarea.form-control { min-height:72px; padding-top:10px; }

    /* Botones */
    .btn-consultar {
      background: var(--verde-principal);
      color: #fff;
      border: none;
      padding: 8px 14px;
      border-radius: 8px;
    }
    .btn-guardar {
      background: #0d6efd; /* Bootstrap primary */
      color: #fff;
      border-radius: 8px;
      padding: 10px 28px;
      font-weight:600;
    }

    /* Footer / espacio */
    .form-footer { padding: 20px; text-align:center; background:transparent; }

    /* Limitar el ancho máximo y centrar la tarjeta en pantallas grandes */
@media (min-width: 1400px) {
  .container {
    max-width: 1200px; /* límite para que no se estire demasiado */
  }
}
/* Mejorar tamaño de fuente y espaciados en pantallas grandes */
@media (min-width: 992px) {
  .card-head h4 {
    font-size: 1.25rem;
  }
  .form-label {
    font-size: 1rem;
  }
}
	</style>

	<script>
	function AbrirProveedores() {
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
				<!-- Usamos clase page-title para controlar tamaño sin romper otras reglas -->
				<h1 class="page-title">Mantenimiento de Proveedores</h1>

				<form class="form" action="PROAddPro2.php" method="POST" role="form">
					<div class="row">
						<div class="col-12 col-lg-10 col-xl-8">
							<!-- Aplicamos custom-card sobre la card existente -->
							<div class="card card-form mb-4">
								<div class="card-head">
           							 <h4 class="text-center">Datos Generales del Proveedor</h4>
         						</div>
								<div class="card-body">
									<!-- botón consultar alineado a la derecha -->
									
									<div class="d-flex justify-content-end mb-3">
              <button class="btn-consultar" onclick="AbrirProveedores()">
				<i class="fa-solid fa-magnifying-glass"></i> Consultar Proveedores</button>
            </div>
									<!-- FORM FIELDS (manteniendo exactamente los name/id para no romper la lógica) -->
									<div class="row g-3">
										<div class="col-12 col-md-6">
											<label class="form-label" for="Nombre">Nombre</label>
											<input class="form-control" type="text" name="Nombre" id="Nombre" required/>
										</div>

										<div class="col-12 col-md-3">
											<label class="form-label" for="NIT"># de NIT</label>
											<input class="form-control" type="text" name="NIT" id="NIT" onchange="VerificarProveedor(this.value)" required/>
										</div>

										<div class="col-12 col-md-3">
											<label class="form-label" for="DPI"># de DPI</label>
											<input class="form-control" type="text" name="DPI" id="DPI" required/>
										</div>

										<div class="col-12">
											<label class="form-label" for="Direccion">Dirección</label>
											<textarea class="form-control" name="Direccion" id="Direccion" required></textarea>
										</div>

										<div class="col-12 col-md-4">
											<label class="form-label" for="Telefono1">Número de Teléfono Principal</label>
											<input class="form-control" type="number" name="Telefono1" id="Telefono1" min="8" required/>
										</div>

										<div class="col-12 col-md-4">
											<label class="form-label" for="Telefono2">Número de Teléfono Secundario</label>
											<input class="form-control" type="number" name="Telefono2" id="Telefono2" min="8"/>
										</div>

										<div class="col-12 col-md-4">
											<label class="form-label" for="Email">Correo Electrónico</label>
											<input class="form-control" type="email" name="Email" id="Email" />
										</div>

										<div class="col-12 col-md-4">
											<label class="form-label" for="DiasCredito">Días de Crédito</label>
											<input class="form-control" type="number" name="DiasCredito" id="DiasCredito" value="<?php echo $DiasCredito; ?>" />
										</div>

										<div class="col-12 col-md-4">
											<label class="form-label" for="CuentaBancaria">No. Cuenta Bancaria</label>
											<input class="form-control" type="text" name="CuentaBancaria" id="CuentaBancaria"/>
										</div>

										<div class="col-12 col-md-4">
											<label class="form-label" for="NombreCuentaBancaria">Nombre de Cuenta Bancaria</label>
											<input class="form-control" type="text" name="NombreCuentaBancaria" id="NombreCuentaBancaria"/>
										</div>

										<div class="col-12 col-md-3">
											<label class="form-label" for="Banco">Banco</label>
											<select name="Banco" id="Banco" class="form-control select">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
													$query = "SELECT * FROM Contabilidad.BANCO ORDER BY B_NOMBRE";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														echo '<option value="'.$row["B_CODIGO"].'">'.$row["B_NOMBRE"].'</option>';
													}
												?>
											</select>
										</div>

										<div class="col-12 col-md-3">
											<label class="form-label" for="Regimen">Tipo de Régimen</label>
											<select name="Regimen" id="Regimen" class="form-control select" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
													$query = "SELECT * FROM Contabilidad.REGIMEN ORDER BY REG_NOMBRE";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														echo '<option value="'.$row["REG_CODIGO"].'">'.$row["REG_NOMBRE"].'</option>';
													}
												?>
											</select>
										</div>

										<div class="col-12 col-md-3">
											<label class="form-label" for="TipoFactura">Tipo de Factura que Maneja</label>
											<select name="TipoFactura" id="TipoFactura" class="form-control select" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
													$query = "SELECT * FROM Contabilidad.TIPO_FACTURA ORDER BY TF_NOMBRE";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														echo '<option value="'.$row["TF_CODIGO"].'">'.$row["TF_NOMBRE"].'</option>';
													}
												?>
											</select>
										</div>

										<div class="col-12 col-md-3">
											<label class="form-label" for="TipoProveedor">Tipo de Proveedor</label>
											<select name="TipoProveedor" id="TipoProveedor" class="form-control select" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="1">Proveedor Local</option>
												<option value="2">Proveedor del Exterior</option>
											</select>
										</div>

									</div> <!-- /.row g-3 -->

									<!-- action buttons -->
									<div class="form-footer mt-4 d-flex justify-content-center gap-3">
										<button type="submit" class="btn-guardar" id="btnEnviar" disabled>
											<i class="fa fa-floppy-o me-2" aria-hidden="true"></i> Guardar
										</button>
										<button type="reset" class="btn btn-outline-secondary">Limpiar</button>
									</div>

								</div> <!-- /.card-body -->
							</div> <!-- /.card custom-card -->
						</div> <!-- /.col -->
					</div> <!-- /.row -->
				</form>

			</div> <!-- /.container -->
		</div> <!-- /#content -->

		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->

	<!-- SCRIPTS ORIGINALES -->
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

</body>
</html>
