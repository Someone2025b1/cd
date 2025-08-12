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
	<script src="../../../../../js/libs/bootstrap-select/bootstrap-select.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../js/libs/bootstrap-select/bootstrap-select.min.css"/>
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
			<div class="container">
				<h1 class="text-center"><strong>Ingreso de Juegos</strong><br></h1>
				<br>
				<form class="form" action="PAddPro.php" method="POST" role="form" enctype="multipart/form-data">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Juego</strong></h4>
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
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="number" step="any" name="Precio" id="Precio" required/>
											<label for="Precio">Precio</label>
										</div>
									</div>
								</div>  
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="number" step="any" name="PrecioEspecial" id="PrecioEspecial" required/>
											<label for="Precio">Precio Especial</label>
										</div>
									</div>
								</div>  
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<label for="Precio">Icono</label>
											<input class="form-control" type="file" name="Icono[]" id="Icono" required/> 
										</div>
									</div>
								</div>  
								<div class="row">
									<div class="col-lg-4 col-lg-8"> 
											<label for="Nomenclatura">Nomenclatura</label>
											<select name="Nomenclatura" id="Nomenclatura" class="form-control selectpicker" required data-live-search="true" required>
												<option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
												<?php
                                                    $query = "SELECT *
													FROM Contabilidad.NOMENCLATURA AS A
													WHERE A.N_CODIGO BETWEEN '4.01.06.001' AND '4.01.06.016'";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["N_CODIGO"].'">'.$row["N_CODIGO"].' - '.$row["N_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>  
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
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	<!-- BEGIN JAVASCRIPT -->
 
	<!-- END JAVASCRIPT -->

	</body>
	</html>
