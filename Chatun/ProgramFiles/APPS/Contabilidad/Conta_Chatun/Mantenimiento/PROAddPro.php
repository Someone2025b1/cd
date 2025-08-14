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
				<h1 class="text-center"><strong>Mantenimiento de Proveedores</strong><br></h1>
				<br>
				<?php
					// --- Recoger POST de forma segura, evitando warnings si no vienen
					$Nombre               = isset($_POST["Nombre"]) ? $_POST["Nombre"] : '';
					$NIT                  = isset($_POST["NIT"]) ? $_POST["NIT"] : '';
					$DPI                  = isset($_POST["DPI"]) ? $_POST["DPI"] : '';
					$Direccion            = isset($_POST["Direccion"]) ? $_POST["Direccion"] : '';
					$Telefono1            = isset($_POST["Telefono1"]) ? $_POST["Telefono1"] : '';
					$Telefono2            = isset($_POST["Telefono2"]) ? $_POST["Telefono2"] : '';
					$Email                = isset($_POST["Email"]) ? $_POST["Email"] : '';
					$Regimen              = isset($_POST["Regimen"]) ? $_POST["Regimen"] : '';
					$TipoProveedor        = isset($_POST["TipoProveedor"]) ? $_POST["TipoProveedor"] : '';
					$CuentaBancaria       = isset($_POST["CuentaBancaria"]) ? $_POST["CuentaBancaria"] : '';
					$NombreCuentaBancaria = isset($_POST["NombreCuentaBancaria"]) ? $_POST["NombreCuentaBancaria"] : '';
					$Banco                = isset($_POST["Banco"]) ? $_POST["Banco"] : '';
					$TipoFactura          = isset($_POST["TipoFactura"]) ? $_POST["TipoFactura"] : '';
					$DiasCredito          = isset($_POST["DiasCredito"]) ? $_POST["DiasCredito"] : '';

					// Helper: escapar string y preparar ints/NULL
					function qstr($db, $val) {
						return "'" . mysqli_real_escape_string($db, $val) . "'";
					}
					function qint_or_null($val) {
						// si viene vacío o no es numérico -> NULL
						if ($val === '' || $val === null) return 'NULL';
						// permitir números en formato string
						if (is_numeric($val)) return intval($val);
						return 'NULL';
					}

					// Generación de CodigoNuevo (mantengo tu lógica)
					if($TipoProveedor == 1)
					{
						$query = "SELECT MAX(CONVERT(SUBSTRING_INDEX(A.P_CODIGO, '.', -1), UNSIGNED INTEGER)) AS CODIGO_NUEVO
									FROM Contabilidad.PROVEEDOR AS A";
						$result = mysqli_query($db, $query);
						$CodigoNuevo = null;
						while($row = mysqli_fetch_array($result))
						{
							$CodigoNuevo =  $row["CODIGO_NUEVO"];
						}

						if($CodigoNuevo == '2.01.01.001')
						{
							$CodigoNuevo = $CodigoNuevo.'.001';
						}
						else
						{
							$CorrelativoActual = $CodigoNuevo;
							$CorrelativoActual = $CorrelativoActual + 1;
							if($CorrelativoActual < 10)
							{
								$CorrelativoNuevo = '00'.$CorrelativoActual;
							}
							elseif(($CorrelativoActual > 9) && ($CorrelativoActual < 100))
							{
								$CorrelativoNuevo = '0'.$CorrelativoActual;
							}
							elseif($CorrelativoActual > 99)
							{
								$CorrelativoNuevo = $CorrelativoActual;
							}

							$CodigoNuevo = '2.01.01.001.'.$CorrelativoNuevo;							
						}

						// PREPARAR valores para query: escapamos strings y tratamos ints/NULL
						$CodigoNuevo_q = qstr($db, $CodigoNuevo);
						$Direccion_q = qstr($db, $Direccion);
						$Email_q = qstr($db, $Email);
						$NIT_q = qstr($db, $NIT);
						$DPI_q = qstr($db, $DPI);
						$Nombre_q = qstr($db, $Nombre);
						// P_TELEFONO y P_TELEFONO1 en tu captura son VARCHAR, tratamos como string o NULL
						$Telefono1_q = ($Telefono1 !== '' && $Telefono1 !== null) ? qstr($db, $Telefono1) : 'NULL';
						$Telefono2_q = ($Telefono2 !== '' && $Telefono2 !== null) ? qstr($db, $Telefono2) : 'NULL';
						$Regimen_q = qint_or_null($Regimen);
						$CuentaBancaria_q = ($CuentaBancaria !== '' && $CuentaBancaria !== null) ? qstr($db, $CuentaBancaria) : 'NULL';
						$NombreCuentaBancaria_q = ($NombreCuentaBancaria !== '' && $NombreCuentaBancaria !== null) ? qstr($db, $NombreCuentaBancaria) : 'NULL';
						$DiasCredito_q = qint_or_null($DiasCredito);
						$Banco_q = qint_or_null($Banco);
						$TipoFactura_q = ($TipoFactura !== '' && $TipoFactura !== null) ? qstr($db, $TipoFactura) : 'NULL';
						$TipoProveedor_q = qint_or_null($TipoProveedor);

						$insert_query = "INSERT INTO Contabilidad.PROVEEDOR
							(P_CODIGO, P_DIRECCION, P_EMAIL, P_NIT, P_DPI, P_NOMBRE, P_TELEFONO, P_TELEFONO1, REG_CODIGO, P_CODIGO_CUENTA, P_NOMBRE_CUENTA, P_DIAS_CREDITO, B_CODIGO, TF_CODIGO, P_TIPO)
							VALUES ($CodigoNuevo_q, $Direccion_q, $Email_q, $NIT_q, $DPI_q, $Nombre_q, $Telefono1_q, $Telefono2_q, $Regimen_q, $CuentaBancaria_q, $NombreCuentaBancaria_q, $DiasCredito_q, $Banco_q, $TipoFactura_q, $TipoProveedor_q)";

						$sql = mysqli_query($db, $insert_query);

						if(!$sql)
						{
							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo ingresar el proveedor.</h2>
									<h4 class="text-light">Código de transacción: '.$CodigoNuevo.'</h4>
								</div>';
							// Mostrar error real y la query para depuración
							echo 'Error MySQL: ' . mysqli_error($db);
							echo '<pre>'.$insert_query.'</pre>';
							exit;
						}
						else
						{
							$sql1_query = "INSERT INTO Contabilidad.NOMENCLATURA (N_CODIGO, N_NOMBRE, N_TIPO)
												VALUES (".qstr($db,$CodigoNuevo).", ".qstr($db,$Nombre).", '')";
							$sql1 = mysqli_query($db, $sql1_query);

							if(!$sql1)
							{
								echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo ingresar el proveedor.</h2>
										<h4 class="text-light">Código de transacción: '.$CodigoNuevo.'</h4>
									</div>';
								echo 'Error MySQL: ' . mysqli_error($db);
								echo '<pre>'.$sql1_query.'</pre>';
								exit;
							}
							else
							{
								echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El proveedor se ingresó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="PRO.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
								</div>';
							}
						}
					}
					else
					{
						// Rama para proveedor exterior (mantengo tu lógica)
						$query = "SELECT MAX(N_CODIGO) AS CODIGO_NUEVO FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO BETWEEN '2.01.01.002' AND '2.01.01.002.9999'";
						$result = mysqli_query($db, $query);
						$CodigoNuevo = null;
						while($row = mysqli_fetch_array($result))
						{
							$CodigoNuevo =  $row["CODIGO_NUEVO"];
						}

						if($CodigoNuevo == '2.01.01.002')
						{
							$CodigoNuevo = $CodigoNuevo.'.001';
						}
						else
						{
							$Xplotado = explode(".", $CodigoNuevo);
							$CorrelativoActual = isset($Xplotado[4]) ? intval($Xplotado[4]) : 0;
							$CorrelativoActual = $CorrelativoActual + 2;
							if($CorrelativoActual < 10)
							{
								$CorrelativoNuevo = '00'.$CorrelativoActual;
							}
							elseif(($CorrelativoActual > 9) && ($CorrelativoActual < 100))
							{
								$CorrelativoNuevo = '0'.$CorrelativoActual;
							}
							elseif($CorrelativoActual > 99)
							{
								$CorrelativoNuevo = $CorrelativoActual;
							}

							$CodigoNuevo = $Xplotado[0].'.'.$Xplotado[1].'.'.$Xplotado[2].'.'.$Xplotado[3].'.'.$CorrelativoNuevo;							
						}

						// Preparamos variables igual que en la otra rama
						$CodigoNuevo_q = qstr($db, $CodigoNuevo);
						$Direccion_q = qstr($db, $Direccion);
						$Email_q = qstr($db, $Email);
						$NIT_q = qstr($db, $NIT);
						$DPI_q = qstr($db, $DPI);
						$Nombre_q = qstr($db, $Nombre);
						$Telefono1_q = ($Telefono1 !== '' && $Telefono1 !== null) ? qstr($db, $Telefono1) : 'NULL';
						$Telefono2_q = ($Telefono2 !== '' && $Telefono2 !== null) ? qstr($db, $Telefono2) : 'NULL';
						$Regimen_q = qint_or_null($Regimen);
						$CuentaBancaria_q = ($CuentaBancaria !== '' && $CuentaBancaria !== null) ? qstr($db, $CuentaBancaria) : 'NULL';
						$NombreCuentaBancaria_q = ($NombreCuentaBancaria !== '' && $NombreCuentaBancaria !== null) ? qstr($db, $NombreCuentaBancaria) : 'NULL';
						$DiasCredito_q = qint_or_null($DiasCredito);
						$Banco_q = qint_or_null($Banco);
						$TipoFactura_q = ($TipoFactura !== '' && $TipoFactura !== null) ? qstr($db, $TipoFactura) : 'NULL';
						$TipoProveedor_q = qint_or_null($TipoProveedor);

						$insert_query = "INSERT INTO Contabilidad.PROVEEDOR
							(P_CODIGO, P_DIRECCION, P_EMAIL, P_NIT, P_DPI, P_NOMBRE, P_TELEFONO, P_TELEFONO1, REG_CODIGO, P_CODIGO_CUENTA, P_NOMBRE_CUENTA, P_DIAS_CREDITO, B_CODIGO, TF_CODIGO, P_TIPO)
							VALUES ($CodigoNuevo_q, $Direccion_q, $Email_q, $NIT_q, $DPI_q, $Nombre_q, $Telefono1_q, $Telefono2_q, $Regimen_q, $CuentaBancaria_q, $NombreCuentaBancaria_q, $DiasCredito_q, $Banco_q, $TipoFactura_q, $TipoProveedor_q)";

						$sql = mysqli_query($db, $insert_query);

						if(!$sql)
						{
							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo ingresar el proveedor.</h2>
									<h4 class="text-light">Código de transacción: '.$CodigoNuevo.'</h4>
								</div>';
							echo 'Error MySQL: ' . mysqli_error($db);
							echo '<pre>'.$insert_query.'</pre>';
							exit;
						}
						else
						{
							$sql1_query = "INSERT INTO Contabilidad.NOMENCLATURA (N_CODIGO, N_NOMBRE, N_TIPO)
												VALUES (".qstr($db,$CodigoNuevo).", ".qstr($db,$Nombre).", '')";
							$sql1 = mysqli_query($db, $sql1_query);

							if(!$sql1)
							{
								echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo ingresar el proveedor.</h2>
										<h4 class="text-light">Código de transacción: '.$CodigoNuevo.'</h4>
									</div>';
								echo 'Error MySQL: ' . mysqli_error($db);
								echo '<pre>'.$sql1_query.'</pre>';
								exit;
							}
							else
							{
								echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El proveedor se ingresó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="PRO.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
								</div>';
							}
						}
					}
				?>
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
