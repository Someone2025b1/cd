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
	<!-- END STYLESHEETS -->

	<script type="text/javascript">
	function CodigoBarrasFun()
	{
		var Seleccionado = $("input[name='CodigoBarras']:checked").val();

		if(Seleccionado == 1)
		{
			$('#EscanearCodigoBarrasDIV').show();
			$('#CodigoBarrasNuevoDIV').hide();
			$('#Codigo').focus();
		}
		else
		{
			$('#EscanearCodigoBarrasDIV').hide();
			$('#CodigoBarrasNuevoDIV').show();

			var Codigo = $('#CodigoNuevo').val();
			$("#bcTarget1").barcode(Codigo, "code128",{barWidth:2, barHeight:120, renderer:"canvas"});
		}
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
				<h1 class="text-center"><strong>Mantenimiento de Productos</strong><br></h1>
				<br>
				<form class="form" action="PAddPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Producto</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Nombre" id="Nombre" required/>
											<label for="Nombre">Nombre</label>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-1">
										<div class="form-group floating-label" id="DIVCIF">
											<input class="form-control" type="number" min="1" name="StockMinimo" id="StockMinimo" required/>
											<label for="StockMinimo">Mínimo</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Categoria" id="Categoria" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="EVE">Eventos</option>
											</select>
											<label for="Categoria">Categoría</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="UnidadMedida" id="UnidadMedida" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT * FROM Bodega.UNIDAD_MEDIDA ORDER BY UM_NOMBRE";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["UM_CODIGO"].'">'.$row["UM_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="UnidadMedida">Unidad de Medida</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="number" step="any" name="Precio" id="Precio" required/>
											<label for="Precio">Precio</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="Nomenclatura" id="Nomenclatura" class="form-control" required>
												<option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
												<?php
                                                    $query = "SELECT *
																FROM Contabilidad.NOMENCLATURA AS A
																WHERE A.N_TIPO <> 'GM'
																AND A.N_TIPO <> 'G'
																AND A.N_TIPO <> 'S'";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["N_CODIGO"].'">'.$row["N_CODIGO"].' - '.$row["N_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="Nomenclatura">Nomenclatura</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="col-sm-3 control-label">Código de Barras</label>
											<div class="col-sm-9">
												<div class="radio radio-styled">
													<label>
														<input type="radio" name="CodigoBarras" value="1" onChange="CodigoBarrasFun()">
														<span>Posee Código de Barras</span>
													</label>
												</div>
												<div class="radio radio-styled">
													<label>
														<input type="radio" name="CodigoBarras" value="2" onChange="CodigoBarrasFun()">
														<span>Crear un Código de Barras</span>
													</label>
												</div>
											</div><!--end .col -->
										</div>
									</div>
								</div>
								<div class="row" id="EscanearCodigoBarrasDIV" style="display: none">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Codigo" id="Codigo" onkeyup='$("#bcTarget").barcode(this.value, "code128",{barWidth:2, barHeight:120, renderer:"canvas"});' />
											<label for="Codigo">Escanear el Codigo</label>
										</div>
										<div id="bcTarget"></div>   
									</div>
								</div>
								<div class="row" id="CodigoBarrasNuevoDIV" style="display: none">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="CodigoNuevo" id="CodigoNuevo" value="<?php echo uniqid(); ?>" readonly />
											<label for="CodigoNuevo">Código Nuevo</label>
										</div>
										<div id="bcTarget1"></div>   
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
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
	<script src="../../../../../libs/barcode/jquery-barcode.js"></script>
	<!-- END JAVASCRIPT -->

	</body>
	</html>
