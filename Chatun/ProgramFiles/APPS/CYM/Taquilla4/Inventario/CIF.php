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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="IFPro.php" method="POST" role="form" target="_blank">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Conteo de Inventario Físico</strong></h4>
							</div>
							<div class="card-body">
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

										//QUERY PARA TRAER TODO EL MOVIMIENTO DE LAS CUENTAS EN EL RANGO DE FECHAS SELECCIONADO
										$QueryCuentas = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE 
										                FROM Bodega.PRODUCTO, Bodega.UNIDAD_MEDIDA 
										                WHERE PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
										                AND PRODUCTO.P_CODIGO_SUBRECETA = '0'
										                AND PRODUCTO.CP_CODIGO = 'HS'
										                GROUP BY PRODUCTO.P_NOMBRE ORDER BY PRODUCTO.P_NOMBRE";
										$ResultCuentas = mysqli_query($db, $QueryCuentas);
										while($row = mysqli_fetch_array($ResultCuentas))
										{
										    $ExistenciaMost = 0;
										    $Producto = $row["P_CODIGO"];
										    $ProductoNombre = $row["P_NOMBRE"];
										    $UnidadMedida = $row["UM_NOMBRE"];

										    $query = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO` ) AS `CARGOS`, SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_PRODUCTO` ) AS `ABONOS`
										    FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
										    WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
										    AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
										    AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
										    AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '".$FechaInicio."' AND '".$FechaFin."'";
										    $rest = mysqli_query($db, $query);
										    while($fila = mysqli_fetch_array($rest))
										    {
										        $Existencia = $fila["CARGOS"] - $fila["ABONOS"];
										        
										        ?>
													<tr>
														<td><?php echo $Producto; ?></td>
														<td><?php echo $ProductoNombre." - ".$UnidadMedida; ?></td>
														<td>
															<div class="col-lg-10">
																<div class="form-group">
																	<input class="form-control" min="0" type="number" name="Fisico[]"  id="Fisico[]" value="0.00" required/>
																</div>
															</div>
														</td>
													</tr>
			
										        <?php										        
										    }

										    
										}	
										?>
									</tbody>
								</table>
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
