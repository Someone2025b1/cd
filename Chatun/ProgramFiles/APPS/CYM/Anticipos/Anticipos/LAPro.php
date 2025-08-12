<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
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
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.default.css"/>
	<!-- END STYLESHEETS -->
	
	<script>
	function AgregarDocumento()
	{
		$('#ModalSugerencias').modal('show');
	}
	function Eliminar(x)
	{
		alertify.confirm("¿Está seguro que desea eliminar este recibo/factura?", function (e) {
		    if (e) {
		        window.location = 'Eliminar.php?Codigo='+x.value;
		    } else {
		        
		    }
		});
	}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php
	$TotalCargos = 0;
	$TotalAbonos = 0;
	$TotalFacturasRecibos = 0;

	$query = "SELECT TRANSACCION.*, AREA_GASTO.AG_NOMBRE
			FROM  Contabilidad.TRANSACCION, Contabilidad.AREA_GASTO
			WHERE TRANSACCION.TRA_AREA_GASTO = AREA_GASTO.AG_CODIGO
			AND TRA_CODIGO = '".$_GET["Codigo"]."'";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{	
		$Fecha         = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
		$Concepto      = $row["TRA_CONCEPTO"];
		$AutorizaGasto = $row["TRA_AUTORIZA_GASTO"];
		$Solicitante   = $row["TRA_SOLICITA_GASTO"];
		$AreaGasto     = $row["TRA_AREA_GASTO"];
		$Monto         = $row["TRA_TOTAL"];
		$Saldo         = $row["TRA_SALDO"];
		$Correlativo   = $row["TRA_CORRELATIVO"];
		$NombreUsuario = saber_nombre_colaborador($Solicitante);
	}									
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="IngresoPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Anticipos Abiertos</strong></h4>
							</div>
							<div class="card-body">
								<form class="form">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="CIFSolicitante" id="CIFSolicitante" value="<?php echo $Solicitante; ?>" readonly required/>
											<label for="CIFSolicitante">CIF del Solicitante</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="NombreSolicitante" id="NombreSolicitante" value="<?php echo $NombreUsuario; ?>" readonly required/>
											<label for="NombreSolicitante">Nombre Solicitante</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Correlativo" id="Correlativo" value="<?php echo $Correlativo; ?>" readonly required/>
											<label for="Correlativo">No. de Anticipo</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group">
											<select name="AutorizaGasto" id="AutorizaGasto" class="form-control" readonly required>
												<option value="4500">Julio César Salguero Ramos</option>
											</select>
											<label for="AutorizaGasto">Autoriza Gasto</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group">
										<select name="AreaGasto" id="AreaGasto" class="form-control" readonly required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT AG_CODIGO, AG_NOMBRE FROM Contabilidad.AREA_GASTO ORDER BY AG_NOMBRE";
												$result = mysqli_query($db,$query);
												while($row = mysqli_fetch_array($result))
												{
													if($row["AG_CODIGO"] == $AreaGasto)
													{
														$Selected = 'selected';
													}
													else
													{
														$Selected = '';
													}
													echo '<option value="'.$row["AG_CODIGO"].'" '.$Selected.'>'.$row["AG_NOMBRE"].'</option>';
												}

												?>
											</select>
											<label for="AreaGasto">Área del Gasto</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Descripcion" id="Descripcion" readonly required><?php echo $Concepto; ?></textarea>
											<label for="Descripcion">Descripción del Anticipo</label>
										</div>
									</div>
								</div>
								<div id="DivProductosServicios">
									<div class="row">
										<div class="col-lg-3 col-lg-9">
											<div class="form-group floating-label">
												<input class="form-control" type="number" step="any" name="TotalAnticipo" id="TotalAnticipo" min="0" readonly value="<?php echo $Monto; ?>"/>
												<label for="TotalAnticipo">Monto Solicitado</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3 col-lg-9">
											<div class="form-group floating-label">
												<input class="form-control" type="number" step="any" name="SaldoPendiente" id="SaldoPendiente" min="0" readonly value="<?php echo $Saldo; ?>"/>
												<label for="SaldoPendiente">Saldo Pendiente</label>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <td><strong>Cuenta</strong></td>
                                                <td><strong>Nombre</strong></td>
                                                <td><strong>Cargos</strong></td>
                                                <td><strong>Abonos</strong></td>
                                                <td><strong>Razón</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php
                                        	$query = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE 
                                        	FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA
                                        	WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
                                        	AND TRANSACCION_DETALLE.TRA_CODIGO = '".$_GET["Codigo"]."'";
                                        	$result = mysqli_query($db,$query);
                                        	while($row = mysqli_fetch_array($result))
                                        	{
                                        		echo '<tr>';
                                        		echo '<td>'.$row["N_CODIGO"].'</td>';
                                        		echo '<td>'.$row["N_NOMBRE"].'</td>';
                                        		echo '<td>'.$row["TRAD_CARGO_CONTA"].'</td>';
                                        		echo '<td>'.$row["TRAD_ABONO_CONTA"].'</td>';
                                        		echo '<td>'.$row["TRAD_RAZON"].'</td>';
                                        		echo '</tr>';
                                        		$TotalCargos = $TotalCargos + $row["TRAD_CARGO_CONTA"];
                                        		$TotalAbonos = $TotalAbonos + $row["TRAD_ABONO_CONTA"];
                                        	}
                                        	?>
                                        </tbody>
                                        <tfoot>
	                                        	<tr>
	                                        		<td></td>
	                                        		<td class="text-right"><b>Total</b></td>
	                                                <td align="left"><b><?php echo number_format($TotalCargos, 2, '.', ','); ?></b></td>
	                                                <td align="left"><b><?php echo number_format($TotalAbonos, 2, '.', ','); ?></b></td>
	                                                <td></td>
	                                        	</tr>
	                                        </tfoot>
                                    </table>
								</div>		
							</form>
							</div>
						</div>
						<?php
						if($Monto == $Saldo)
						{
							?>
							<div class="card">
								<div class="card-head style-primary">
									<h4 class="text-center"><strong>Facturas/Recibos</strong></h4>
								</div>
								<div class="card-body">
									<div class="alert alert-callout alert-success" role="alert">
										El anticipo no posee ninguna Factura/Recibo adjunto.
									</div>
									<div class="col-lg-12 text-center">
										<a href="Ingreso.php?IDAnticipo=<?php echo $_GET["Codigo"] ?>&Saldo=<?php echo $Saldo;  ?>"><button type="button" class="btn btn-warning">
											<span class="glyphicon glyphicon-check"></span> Agregar
										</button></a>
									</div>
								</div>
							</div>

							<?php
						}
						elseif($Saldo > 0 && $Saldo <$Monto)
						{
							?>
							<div class="card">
								<div class="card-head style-primary">
									<h4 class="text-center"><strong>Facturas/Recibos</strong></h4>
								</div>
								<div class="card-body">
								<table class="table table-hover table-condensed">
									<thead>
										<th>
											<h5><strong>Fecha</strong></h5>
										</th>
										<th>
											<h5><strong>Tipo</strong></h5>
										</th>
										<th>
											<h5><strong>Descripción</strong></h5>
										</th>
										<th>
											<h5><strong>Monto</strong></h5>
										</th>
									</thead>
									<tbody>
									<?php
										$query = "SELECT * FROM Contabilidad.TRANSACCION WHERE TRA_ANTICIPO = '".$_GET["Codigo"]."'";
										$result = mysqli_query($db,$query);
										while($row = mysqli_fetch_array($result))
										{	
											$Fecha         = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
											if($row["TRA_TIPO_DOCUMENTO"] == 'F')
											{
												$Tipo = 'Factura';
											}
											else
											{
												$Tipo = 'Recibo';
											}
											echo '<tr>';
											echo '<td><h5>'.$Fecha.'</h5></td>';
											echo '<td><h5>'.$Tipo.'</h5></td>';
											echo '<td><h5>'.$row["TRA_CONCEPTO"].'</h5></td>';
											echo '<td><h5>'.$row["TRA_TOTAL"].'</h5></td>';
											echo '<td><h5><a href="Consultar.php?ID='.$row["TRA_CODIGO"].'"<button type="button" class="btn btn-warning btn-xs">
													    <span class="glyphicon glyphicon-search"></span> Consultar
													  </button></a></h5></td>';
													  echo '<td><h5><button type="button" class="btn btn-danger btn-xs" onClick="Eliminar(this)" value="'.$row["TRA_CODIGO"].'">
													    <span class="glyphicon glyphicon-remove-circle"></span> Eliminar
													  </button></h5></td>';
											echo '</tr>';
											$TotalFacturasRecibos = $TotalFacturasRecibos + $row["TRA_TOTAL"];
										}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td></td>
											<td></td>
											<td align="left"><b>Total</b></td>
											<td align="left"><b><?php echo number_format($TotalFacturasRecibos, 2, '.', ','); ?></b></td>
										</tr>
									</tfoot>
								</table>
								<div class="col-lg-12 text-center">
								<a href="Ingreso.php?IDAnticipo=<?php echo $_GET["Codigo"] ?>&Saldo=<?php echo $Saldo;  ?>"><button type="button" class="btn btn-warning">
										<span class="glyphicon glyphicon-check"></span> Agregar
									</button></a>
								</div>
							</div>
						</div>
							<?php
						}
						elseif($Saldo == 0)
						{
							?>
							<div class="card">
								<div class="card-head style-primary">
									<h4 class="text-center"><strong>Facturas/Recibos</strong></h4>
								</div>
								<div class="card-body">
									<div class="alert alert-callout alert-success text-center" role="alert">
										El anticipo ya fue cancelado en su totalidad.
									</div>
									<table class="table table-hover table-condensed">
									<thead>
										<th>
											<h5><strong>Fecha</strong></h5>
										</th>
										<th>
											<h5><strong>Tipo</strong></h5>
										</th>
										<th>
											<h5><strong>Descripción</strong></h5>
										</th>
										<th>
											<h5><strong>Monto</strong></h5>
										</th>
									</thead>
									<tbody>
									<?php
										$query = "SELECT * FROM Contabilidad.TRANSACCION WHERE TRA_ANTICIPO = '".$_GET["Codigo"]."'";
										$result = mysqli_query($db,$query);
										while($row = mysqli_fetch_array($result))
										{	
											$Fecha         = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
											if($row["TRA_TIPO_DOCUMENTO"] == 'F')
											{
												$Tipo = 'Factura';
											}
											else
											{
												$Tipo = 'Recibo';
											}
											echo '<tr>';
											echo '<td><h5>'.$Fecha.'</h5></td>';
											echo '<td><h5>'.$Tipo.'</h5></td>';
											echo '<td><h5>'.$row["TRA_CONCEPTO"].'</h5></td>';
											echo '<td><h5>'.$row["TRA_TOTAL"].'</h5></td>';
											echo '<td><h5><a href="Consultar.php?ID='.$row["TRA_CODIGO"].'"><button type="button" class="btn btn-warning btn-xs">
													    <span class="glyphicon glyphicon-search"></span> Consultar
													  </button></a></h5></td>';
													  echo '<td><h5><button type="button" class="btn btn-danger btn-xs" value="'.$row["TRA_CODIGO"].'" onClick="Eliminar(this)">
													    <span class="glyphicon glyphicon-remove-circle"></span> Eliminar
													  </button></h5></td>';
											echo '</tr>';
											$TotalFacturasRecibos = $TotalFacturasRecibos + $row["TRA_TOTAL"];
										}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td></td>
											<td></td>
											<td align="left"><b>Total</b></td>
											<td align="left"><b><?php echo number_format($TotalFacturasRecibos, 2, '.', ','); ?></b></td>
										</tr>
									</tfoot>
								</table>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->

		<!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Agregar Recibo/Factura</h2>
                    </div>
                    <div class="modal-body">
                    	<form class="form" id="FormAgregar" method="POST" action="AgregarDocumento.php">
                    		
                    	</form>
                    </div>
                    <div class="modal-footer">
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				        <button type="button" class="btn btn-success" onClick="Adjuntar">Agregar</button>
				    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
