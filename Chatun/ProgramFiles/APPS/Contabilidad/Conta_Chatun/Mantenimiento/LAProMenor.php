<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
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
	
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
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

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Lista de Activos Fijos</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Activos Fijos</strong></h4>
						</div>
						<div class="card-body">
							<?php 
								$Codigo = $_GET["Codigo"];

								$Query = "SELECT * FROM Contabilidad.ACTIVO_FIJO_MENOR WHERE AF_CODIGO = '".$Codigo."'";
								$Result = mysqli_query($db, $Query);
								$Fila = mysqli_fetch_array(($Result));
								
								$Codigo            = $Fila["AF_CODIGO"];
								$NombreActivo      = $Fila["AF_NOMBRE"];
								$CIFResponsable    = $Fila["AF_RESPONSABLE"];
								$AreaGasto 		   = $Fila["AF_AREA"];
								$NombreResponsable = saber_nombre_colaborador($Fila["AF_RESPONSABLE"]);
								$TipoActivo        = $Fila["TA_CODIGO"];
								$Observaciones     = $Fila["AF_OBSERVACIONES"];
								$ValorActivo       = number_format($Fila["AF_VALOR"], 2);
							?>
							<form class="form" action="LAProProMenor.php" method="POST" role="form">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="CodigoActivo" id="CodigoActivo" value="<?php echo $Codigo ?>" required readonly />
											<label for="CodigoActivo">Código del Activo</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<input class="form-control" type="text" name="NombreActivo" id="NombreActivo" value="<?php echo $NombreActivo ?>" required />
											<label for="NombreActivo">Nombre del Activo</label>
										</div>
									</div>	
								</div>
								<div class="row">
										<div class="col-lg-3">
										<div class="form-group ">
											<input class="form-control" type="text" name="CIFResponsable" id="CIFResponsable" value="<?php echo $CIFResponsable ?>" readonly onclick="SelColaborador()" required/>
											<label for="CIFResponsable">CIF del Responsable</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group ">
											<input class="form-control" type="text" name="NombreResponsable" id="NombreResponsable" value="<?php echo $NombreResponsable ?>" readonly onclick="SelColaborador()"/>
											<label for="NombreResponsable">Nombre Responsable</label>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<button class="btn btn-success btn-sm" type="button" onclick="SelColaborador()">Seleccionar Solicitante</button>
										</div>
									</div>
								</div>
								<div class="row col-lg-4">
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group">
												<select name="Area" id="Area" class="form-control" required>
														<option value="" disabled selected>Seleccione una opción</option>
														<?php
			                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
														$query = "SELECT * FROM Contabilidad.AREA_GASTO ORDER BY AG_NOMBRE";
														$result = mysqli_query($db, $query);
														while($row = mysqli_fetch_array($result))
														{
															if($row["AG_CODIGO"] == $AreaGasto)
															{
																$Texto = 'selected';
															}
															else
															{
																$Texto = '';
															}
															echo '<option value="'.$row["AG_CODIGO"].'" '.$Texto.'>'.$row["AG_NOMBRE"].'</option>';
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
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                    	if($row["TA_CODIGO"] == $TipoActivo)
                                                    	{
                                                    		$Texto = 'selected';
                                                    	}
                                                    	else
                                                    	{
                                                    		$Texto = '';
                                                    	}
                                                    	echo '<option value="'.$row["TA_CODIGO"].'" '.$Texto.'>'.$row["TA_NOMBRE"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="TipoActivo">Tipo del Activo</label>
										</div>
									</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" type="text" name="Descripcion" id="Descripcion" value="<?php echo $Observaciones ?>"/>
											<label for="Descripcion">Observaciones</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" min="0" step="any" name="ValorActivo" id="ValorActivo" required readonly value="<?php echo $ValorActivo ?>"/>
											<label for="ValorActivo">Valor del Activo</label>
										</div>
									</div>	
								</div>
								<div class="col-lg-12 text-center">
									<button type="submit" class="btn btn-primary btn-lg">
									<span class="glyphicon glyphicon-check"></span> Actualizar
									</button>
								</div>
							</form>
						</div>							
			        </div>
			    </div>
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
