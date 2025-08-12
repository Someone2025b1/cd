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

	<?php include("../../../../MenuTop.php"); 

	$Bodega = $_POST["Bodega"];
	$Periodo = $_POST["Periodo"];


	$QueryEncabezado = "SELECT * FROM Bodega.CONTEO_INVENTARIO_FISICO WHERE B_CODIGO = ".$Bodega." AND CIF_ESTADO = 0 AND PC_CODIGO = ".$Periodo;
	$ResultEncabezado = mysqli_query($db, $QueryEncabezado);
	$FilaEncabezado = mysqli_fetch_array($ResultEncabezado);

	$FechaConteo = $FilaEncabezado["CIF_FECHA"];
	$Periodo = $FilaEncabezado["PC_CODIGO"];
	$FechaConteo = $FilaEncabezado["CIF_FECHA"];
	$Observaciones = $FilaEncabezado["CIF_OBSERVACIONES"];
	$Codigo = $FilaEncabezado["CIF_CODIGO"];
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="IFProPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Conteo de Inventario Físico</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="hidden" name="CodigoTransaccion" id="CodigoTransaccion" value="<?php echo $Codigo; ?>" required readonly/>
											<input class="form-control" type="date" name="FechaConteo" id="FechaConteo" value="<?php echo date('Y-m-d', strtotime($FechaConteo)); ?>" required readonly/>
											<label for="FechaConteo">Fecha de Conteo</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select name="Periodo" id="Periodo" class="form-control" required readonly>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE EPC_CODIGO <> 0";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													if($row["PC_CODIGO"] == $Periodo)
													{
														$Texto = 'selected';
													}
													else
													{
														$Texto = '';
													}
													echo '<option value="'.$row["PC_CODIGO"].'" $Texto>'.$row["PC_MES"].'-'.$row["PC_ANHO"].'</option>';
												}

												?>
											</select>
											<label for="Periodo">Periodo Contable</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<input class="form-control" type="text" name="Observaciones" id="Observaciones" value="<?php echo $Observaciones; ?>" required readonly/>
											<label for="Observaciones">Observaciones</label>
										</div>
									</div>	
								</div>
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th><h4><strong>#</strong></h4></th>
											<th><h4><strong>Código</strong></h4></th>
											<th><h4><strong>Producto</strong></h4></th>
											<th><h4><strong>Cantidad</strong></h4></th>
										</tr>
									</thead>
									<tbody>
										<?php

										$FechaInicio = $_POST["FechaInicio"];
										$FechaFin    = $_POST["FechaFin"];
										$Bodega      = $_POST["Bodega"];
										$i 		     = 1;

										//QUERY PARA TRAER TODO EL MOVIMIENTO DE LAS CUENTAS EN EL RANGO DE FECHAS SELECCIONADO
										$QueryCuentas = "SELECT CONTEO_INVENTARIO_FISICO_DETALLE.*, UNIDAD_MEDIDA.UM_NOMBRE, PRODUCTO.P_NOMBRE 
														FROM Bodega.CONTEO_INVENTARIO_FISICO_DETALLE, Bodega.PRODUCTO, Bodega.UNIDAD_MEDIDA
														WHERE CONTEO_INVENTARIO_FISICO_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
														AND PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
														AND CONTEO_INVENTARIO_FISICO_DETALLE.CIF_CODIGO = '".$Codigo."'";
										$ResultCuentas = mysqli_query($db, $QueryCuentas);
										while($row = mysqli_fetch_array($ResultCuentas))
										{
											$ExistenciaMost = 0;
											$Producto = $row["P_CODIGO"];
											$ProductoNombre = $row["P_NOMBRE"];
											$UnidadMedida = $row["UM_NOMBRE"];
											$Cantidad = $row["CIFD_CANTIDAD_FISICO"];

											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $Producto; ?></td>
												<td><?php echo $ProductoNombre." - ".$UnidadMedida; ?></td>
												<td>
													<div class="col-lg-10">
														<div class="form-group">
															<input class="form-control" min="0" type="hidden" name="Codigo[]"  id="Codigo[]" value="<?php echo $Producto; ?>" required/>
															<input class="form-control" min="0" type="number" name="Fisico[]"  id="Fisico[]" value="<?php echo $Cantidad; ?>" required/>
														</div>
													</div>
												</td>
											</tr>

											<?php	
											$i++;
										}	
										?>
									</tbody>
								</table>
								<div class="row">
									<br>
									<br>
								</div>
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
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
