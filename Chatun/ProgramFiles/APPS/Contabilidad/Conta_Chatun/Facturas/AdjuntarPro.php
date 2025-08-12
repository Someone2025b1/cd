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
	<script src="../../../../../js/libs/dropzone/dropzone.min.js"></script>

	
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/dropzone/dropzone-theme.css" />
	<!-- END STYLESHEETS -->


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="AdjuntarProPro.php" method="POST" role="form" enctype="multipart/form-data">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Adjuntar Documento de Pago a Factura de Compra</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<?php
									$TotalCargos = 0;
									$TotalAbonos = 0;

									$query = "SELECT A.*, B.* FROM Contabilidad.TRANSACCION AS A, Contabilidad.PROVEEDOR AS B 
												WHERE A.P_CODIGO = B.P_CODIGO 
												AND A.TRA_CODIGO = '".$_GET["Codigo"]."'";
									$result = mysqli_query($db, $query);
									while($row = mysqli_fetch_array($result))
									{	
										$FechaBien          = $row["TRA_FECHA_TRANS"];
										$Fecha              = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
										$Hora               = $row["TRA_HORA"];
										$Concepto           = $row["TRA_CONCEPTO"];
										$FechaHoy           = date('d-m-Y', strtotime($row["TRA_FECHA_HOY"]));
										$Usuario            = $row["TRA_USUARIO"];
										$Nit                =$row["P_NIT"];
										$ProveedorCodigo    =$row["P_CODIGO"];
										$ProveedorNombre    =$row["P_NOMBRE"];
										$Serie              =$row["TRA_SERIE"];
										$Factura            =$row["TRA_FACTURA"];
										$TipoCompra         =$row["TC_CODIGO"];
										$Combustible        = $row["COM_CODIGO"];
										$DestinoCombustible =$row["TRA_DESTINO_COM"];
										$CantidadGalones    =$row["TRA_CANT_GALONES"];
										$PrecioGalones      =$row["TRA_PRECIO_GALONES"];
										$TotalFactura       =$row["TRA_TOTAL"];
										$FormaPago          =$row["FP_CODIGO"];
										$Usuario            =$row["TRA_USUARIO"];
										$Comprobante        =$row["TRA_COMPROBANTE"];
										$Monto				=number_format($row["TRA_TOTAL"], 2, '.', ',');
									}									
								?>

								<form class="form" role="form">
									<div class="row">
										<div class="col-lg-6">
												<div class="form-group">
													<input class="form-control" type="hidden" name="CodigoTransaccion" id="CodigoTransaccion" value="<?php echo $_GET["Codigo"]; ?>" readonly/>
													<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $ProveedorNombre; ?>" readonly/>
													<label for="Nombre">Proveedor</label>
												</div>
										</div>
										<div class="col-lg-4">
												<div class="form-group">
													<input class="form-control" type="text" name="CodigoProveedor" id="CodigoProveedor" value="<?php echo $ProveedorCodigo; ?>" readonly/>
													<label for="CodigoProveedor">Cuenta Contable</label>
												</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" name="NIT" id="NIT" value="<?php echo $Nit; ?>" readonly/>
												<label for="NIT">NIT</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-2">
											<div class="form-group">
												<input class="form-control" type="text" name="SerieFactura" id="SerieFactura" value="<?php echo $Serie; ?>" readonly/>
												<label for="SerieFactura">No. de Serie</label>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" name="Factura" id="Factura" value="<?php echo $Factura; ?>" readonly/>
												<label for="Factura">No. de Factura</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $FechaBien; ?>" readonly/>
												<label for="Fecha">Fecha Factura</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-lg-6">
											<div class="form-group floating-label">
												<textarea class="form-control" name="Descripcion" id="Descripcion" readonly><?php echo $Concepto; ?></textarea>
												<label for="Descripcion">Descripción</label>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<h5>Tipo</h5>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="B" name="TipoCompra" <?php if($TipoCompra == 'B'){echo 'checked';} ?> disabled>
											<span>Bienes</span>
										</label>
										<label class="radio-inline radio-styled">
											<input type="radio" value="C" name="TipoCompra" <?php if($TipoCompra == 'C'){echo 'checked';} ?> disabled>
											<span>Combustible</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="I" name="TipoCompra" <?php if($TipoCompra == 'I'){echo 'checked';} ?> disabled>
											<span>Importación</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="S" name="TipoCompra" <?php if($TipoCompra == 'S'){echo 'checked';} ?> disabled>
											<span>Servicios</span>
										</label>
									</div>
									<div class="row">
										<br>
										<br>
										<br>
										<br>
									</div>
									<div class="row">
										<div class="col-lg-6 col-lg-6">
											<div class="form-group">
												<input type="file" class="form-control" name="Documento[]" id="Documento" />
												<label for="Descripcion">Adjuntar Dcoumento de Pago</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<button type="submit" class="btn btn-primary">Adjuntar</button>
										</div>
									</div>
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
