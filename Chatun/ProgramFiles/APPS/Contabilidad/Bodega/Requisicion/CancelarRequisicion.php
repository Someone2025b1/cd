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
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.default.css"/>
	<!-- END STYLESHEETS -->

	<style type="text/css">
        .fila-base{
            display: none;
        }
    	.suggest-element{
    		margin-left:5px;
    		margin-top:5px;
    		width:350px;
    		cursor:pointer;
    	}
    	#suggestions {
    		width:auto;
    		height:auto;
    		overflow: auto;
    	}
    </style>

	

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php
		$query = "SELECT REQUISICION.*, BODEGA.B_NOMBRE
		FROM Bodega.REQUISICION, Bodega.BODEGA
		WHERE REQUISICION.B_CODIGO = BODEGA.B_CODIGO
		AND REQUISICION.R_CODIGO = '".$_GET["Codigo"]."' ";
		$result = mysqli_query($db, $query);
		while($row = mysqli_fetch_array($result))
		{
			$FechaRequisicion = $row["R_FECHA"];
			$FechaNecesidad   = $row["R_FECHA_NECESIDAD"];
			$Bodega           = $row["B_NOMBRE"];
			$Observaciones    = $row["R_OBSERVACIONES"];
			$Genero           = $row["R_USUARIO"];
			$BodegaCodigo     = $row["B_CODIGO"];
		}
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="CancelarRequisicionPro.php" method="POST" role="form">
				<input class="form-control" type="hidden" name="Codigo" id="Codigo" value="<?php echo $_GET["Codigo"]; ?>" readonly required/>
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Requisición de Producto</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="hidden" name="CodigoRequisicion" value="<?php echo $_GET['Codigo']; ?>"  id="CodigoRequisicion" readonly/>
											<input class="form-control" maxlength="255" type="text" name="Genero" value="<?php echo saber_nombre_colaborador($Genero); ?>"  id="Genero" readonly/>
											<label for="Genero">Generó Solicitud</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaRequisicion" id="FechaRequisicion" value="<?php echo $FechaRequisicion; ?>" readonly required/>
											<label for="FechaRequisicion">Fecha de Requisicón</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaNecesidad" id="FechaNecesidad" value="<?php echo $FechaNecesidad; ?>" required readonly/>
											<label for="FechaNecesidad">Fecha de Necesidad</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="BodegaNombre" id="BodegaNombre" value="<?php echo $Bodega; ?>" required readonly/>
											<input class="form-control" type="hidden" name="BodegaRecibe" id="BodegaRecibe" value="<?php echo $BodegaCodigo; ?>" required readonly/>
											<label for="BodegaNombre">Bodega Destino</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="text" name="Concepto" value="<?php echo $Observaciones; ?>"  id="Concepto" readonly/>
											<label for="Concepto">Observaciones</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <td><strong>Cantidad Solicitada</strong></td>
                                                <td><strong>Producto</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<tr class="fila-base">
                                                <td></td>
                                                <td><h6><div class="form-group">
											<select name="Producto[]" id="Producto[]" class="form-control" onchange="SaberStock(this)">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Bodega.PRODUCTO ORDER BY P_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													echo '<option value="'.$row["P_CODIGO"].'">'.$row["P_NOMBRE"].'</option>';
												}

												?>
											</select>
										</div></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                            	$i = 1;
                                            	$query = "SELECT REQUISICION_DETALLE.*, PRODUCTO.P_NOMBRE
												FROM Bodega.REQUISICION_DETALLE, Bodega.PRODUCTO
												WHERE REQUISICION_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
												AND REQUISICION_DETALLE.R_CODIGO = '".$_GET["Codigo"]."' ";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													$Producto = $row["P_CODIGO"];
													$Consulta = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_PRODUCTO) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_PRODUCTO) AS ABONOS
      								FROM Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION
      								WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                                      AND TRANSACCION.B_CODIGO = 4 
                                                      AND TRANSACCION_DETALLE.P_CODIGO = ".$Producto;
													$Resultados = mysqli_query($db, $Consulta);
													while($row1 = mysqli_fetch_array($Resultados))
													{
														$Stock = $row1["CARGOS"] - $row1["ABONOS"];

													}
													$ProductoCodigo = $row["P_CODIGO"];
													echo '<tr>';
														echo '<td>'.number_format($row["RD_CANTIDAD"], 2, '.', ',').'</td>';
														echo '<td>'.$row["P_NOMBRE"].'</td>';
														echo '<input class="form-control" style="width: 150px" type="hidden"  name="Producto[]" value="'.$Producto.'" required readonly/>';
													echo '</tr>';
													$i++;
												}

                                            ?>
                                        </tbody>
                                    </table>
								</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="text" name="MotivoCancelacion" id="MotivoCancelacion" required/>
											<label for="MotivoCancelacion">¿Porqué desea cancelar la requisición?</label>
										</div>
									</div>	
								</div>
							</div>
						</div>
						<div class="col-lg-12" align="center">
							<button type="submit" class="btn ink-reaction btn-raised btn-danger" id="btnGuardar">Cancelar Requisición</button>
						</div>
						<br>
						
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

		<!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Resultados de su búsqueda</h2>
                    </div>
                    <div class="modal-body">
                    	<div id="suggestions" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
