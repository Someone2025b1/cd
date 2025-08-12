<?php
include("../../../../../Script/funciones.php");
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
	

	<script>
	function SelColaborador(x)
		{
			window.open('SelColaborador.php','popup','width=750, height=700');
			document.getElementById("AutorizaGasto").focus();
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php

	$query = "SELECT TRA_TOTAL, TRA_SALDO FROM Contabilidad.TRANSACCION WHERE TRA_CODIGO = '".$_GET["CodigoPoliza"]."'";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{	
		$Total = $row["TRA_TOTAL"];
		$Saldo = $row["TRA_SALDO"];
	}
	?>


	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="AdjuntarMEProPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Adjuntar Mobiliario Equipo a Póliza</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="TotalPoliza" id="TotalPoliza" value="<?php echo $Total ?>" required readonly/>
											<label for="TotalPoliza">Total de Póliza</label>
										</div>
									</div>	
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="SaldoPoliza" id="SaldoPoliza" value="<?php echo $Saldo ?>" required readonly/>
											<label for="SaldoPoliza">Saldo de Póliza</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="CodigoActivo" id="CodigoActivo" required />
											<label for="CodigoActivo">Código del Activo</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="NombreActivo" id="NombreActivo" required />
											<label for="NombreActivo">Nombre del Activo</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaAdquisicion" id="FechaAdquisicion" required />
											<label for="FechaAdquisicion">Fecha de Adquisición</label>
										</div>
									</div>	
								</div>
								<div class="row">
										<div class="col-lg-3">
										<div class="form-group ">
											<input class="form-control" type="text" name="CIFResponsable" id="CIFResponsable" readonly onclick="SelColaborador()" required/>
											<label for="CIFResponsable">CIF del Responsable</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group ">
											<input class="form-control" type="text" name="NombreResponsable" id="NombreResponsable" readonly onclick="SelColaborador()"/>
											<label for="NombreResponsable">Nombre Responsable</label>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<button class="btn btn-success btn-sm" onclick="SelColaborador()">Seleccionar Solicitante</button>
										</div>
									</div>
								</div>
								<div class="row col-lg-4 ">
										<div class="row">
											<div class="col-lg-6 col-lg-6">
												<div class="form-group">
												<select name="Area" id="Area" class="form-control" required>
														<option value="" disabled selected>Seleccione una opción</option>
														<?php
			                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
														$query = "SELECT * FROM Contabilidad.AREA_GASTO ORDER BY AG_NOMBRE";
														$result = mysqli_query($db,$query);
														while($row = mysqli_fetch_array($result))
														{
															echo '<option value="'.$row["AG_CODIGO"].'">'.$row["AG_NOMBRE"].'</option>';
														}

														?>
													</select>
													<label for="Area">Área del Gasto</label>
												</div>
											</div>
										</div>
									</div>
									<div class="row col-lg-4 ">
										<div class="form-group">
											<select name="TipoActivo" id="TipoActivo" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT * FROM Contabilidad.TIPO_ACTIVO ORDER BY TA_NOMBRE";
                                                    $result = mysqli_query($db,$query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["TA_CODIGO"].'">'.$row["TA_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="TipoActivo">Tipo del Activo</label>
										</div>
									</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" type="text" name="Descripcion" id="Descripcion"/>
											<label for="Descripcion">Observaciones</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="number" min="0" step="any" name="ValorActivo" id="ValorActivo" required/>
											<label for="ValorActivo">Valor del Activo</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Deducible" id="Deducible">
												<span>Es Deducible</span>
											</label>
										</div>
									</div>	
								</div>
							</div>
						</div>
							<div class="container text-center">
								<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Guardar</button>
							</div>
							<br>
							<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Mobiliario Equipo</strong></h4>
							</div>
							<div class="card-body">
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th>
												<strong><h6>Código</h6></strong>
											</th>
											<th>
												<strong><h6>Nombre</h6></strong>
											</th>
											<th>
												<strong><h6>Responsable</h6></strong>
											</th>
											<th>
												<strong><h6>Tipo</h6></strong>
											</th>
											<th>
												<strong><h6>Área</h6></strong>
											</th>
											<th>
												<strong><h6>Observaciones</h6></strong>
											</th>
											<th>
												<strong><h6>Valor</h6></strong>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$query = "SELECT ACTIVO_FIJO.*, AREA_GASTO.AG_NOMBRE, TIPO_ACTIVO.TA_NOMBRE
														FROM Contabilidad.ACTIVO_FIJO, Contabilidad.AREA_GASTO, Contabilidad.TIPO_ACTIVO 
														WHERE ACTIVO_FIJO.AF_AREA = AREA_GASTO.AG_CODIGO
														AND ACTIVO_FIJO.TA_CODIGO = TIPO_ACTIVO.TA_CODIGO
														AND ACTIVO_FIJO.AF_ESTADO = 1
														AND AF_TRANSACCION = '".$_GET["CodigoPoliza"]."'";
											$result = mysqli_query($db,$query);
											while($row = mysqli_fetch_array($result))
											{
												$NombreResponsable = saber_nombre_colaborador($row["AF_RESPONSABLE"]);
												?>
													<tr>
														<td><h6><?php echo $row["AF_CODIGO"]; ?></h6></td>
														<td><h6><?php echo $row["AF_NOMBRE"]; ?></h6></td>
														<td><h6><?php echo $NombreResponsable; ?></h6></td>
														<td><h6><?php echo $row["TA_NOMBRE"]; ?></h6></td>
														<td><h6><?php echo $row["AG_NOMBRE"]; ?></h6></td>
														<td><h6><?php echo $row["AF_OBSERVACIONES"]; ?></h6></td>
														<td><h6><?php echo number_format($row["AF_VALOR"], 2, '.', ',') ?></h6></td>
														<td>
															<h6><a href="EliminarActivo.php?CodigoActivo=<?php echo $row["AF_CODIGO"] ?>&Valor=<?php echo $row["AF_VALOR"] ?>&Saldo=<?php echo $Saldo ?>&Transaccion=<?php echo $_GET["CodigoPoliza"] ?>"><button type="button" class="btn btn-danger btn-xs">
															<span class="glyphicon glyphicon-remove"></span> Eliminar
															 </button></a></h6>
														</td>
													</tr>
												<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					<input id="CodigoTrans" name="CodigoTrans" type="hidden" value="<?php echo $_GET["CodigoPoliza"] ?>"></input>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>


	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
