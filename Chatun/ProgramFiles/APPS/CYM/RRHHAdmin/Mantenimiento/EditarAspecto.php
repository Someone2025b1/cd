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
		function ObtenerDepartamentosLaborales(Valor)
	{
		$.ajax({
			url: 'BuscarDepartamentosLaborales.php',
			type: 'POST',
			data: 'id='+Valor,
			success: function(opciones)
			{
				$('#Puesto').html(opciones);
			},
			error: function(opciones)
			{
				alert('Error'+opciones);
			}
		})
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
				<h1 class="text-center"><strong>Mantenimiento de Aspectos a Evaluar</strong><br></h1>
				<br>

				<?php
										$Codigo = $_GET["Codigo"];

									$Consulta = "SELECT ASPECTOS_EVALUAR.* FROM RRHH.ASPECTOS_EVALUAR WHERE ASPECTOS_EVALUAR.ARE_CODIGO = $Codigo 
                                    ORDER BY ASPECTOS_EVALUAR.ARE_CODIGO";
									$Resultado = mysqli_query($db, $Consulta);
									while($row = mysqli_fetch_array($Resultado))
									{
										$CodigoAs = $row["ARE_CODIGO"];
										$Nombre = $row["ARE_NOMBRE"];
										$Area = $row["AR_CODIGO"];
										$AreaT = $row["A_CODIGO"];
										$Puesto = $row["P_CODIGO"];
										
									}

									$sqlRet = mysqli_query($db,"SELECT A.P_NOMBRE, A.A_CODIGO 
												FROM RRHH.PUESTO AS A     
												WHERE A.P_CODIGO = ".$Puesto); 
												$rowret=mysqli_fetch_array($sqlRet);

												$NombrePuesto=$rowret["P_NOMBRE"];
												$CodigoArea=$rowret["A_CODIGO"];

									$sqlRet = mysqli_query($db,"SELECT A.A_NOMBRE 
									FROM RRHH.AREAS AS A     
									WHERE A.A_CODIGO = ".$CodigoArea); 
									$rowret=mysqli_fetch_array($sqlRet);

									$NombreArea=$rowret["A_NOMBRE"];
								?>

				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Datos del Nuevo Aspecto</strong></h4>
						</div>
						<div class="col-lg-8">
										<div class="form-group floating-label">
                                        <label for="Codigo">Codigo del Aspecto</label>
											<input class="form-control" type="text" name="Codigo" id="Codigo" value="<?php echo $Codigo ?>"  readonly/>
											
										</div>
										</div>
						<div class="card-body">
							<div class="col-lg-12">
								
								<div class="card card-underline">
								
									<div class="card-head">
										<ul class="nav nav-tabs pull-right" data-toggle="tabs">
											<?php
											if($Area==8){

											
											?>
											<li class="active"><a href="#second2">Por Área</a></li>
											<?php
											}elseif($Area==9){

											
												?>
												<li class="active"><a href="#three">Por Puesto</a></li>
												<?php
												}else{

												
												?>
												<li class="active"><a href="#first2">General</a></li>
												<?php
												
													
												}
												?>
											
											
										</ul>
										<header>Tipo de Aspecto</header>
									</div>
									<div class="card-body tab-content">
									<?php
											if($Area==8){

											?>

											<!--Segunda Opción -->
										<div class="tab-pane active" id="second2">
											<form action="EditarAspectoPro.php" method="POST" role="form" class="form">
												<div class="row">
                                               
                                                <div class="col-lg-12">
												<input class="form-control" type="hidden" name="Tipo" id="Tipo" value="Area"  readonly/>
												<input class="form-control" type="hidden" name="Codigo" id="Codigo" value="<?php echo $Codigo ?>"  readonly/>
                                                    <div class="col-lg-8">
                                                    <div class="form-group">
													<label for="Aspecto">Nombre del Aspecto</label>
														<textarea class="form-control" name="Aspecto" id="Aspecto" rows="2" cols="40" required><?php echo $Nombre; ?></textarea>
														</div>
                                                </div>
                                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <select name="Area" id="Area" onchange="ObtenerDepartamentosLaborales(this.value)" class="form-control" >
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            <?php
                                            $Selected="";
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                            $query = "SELECT * FROM RRHH.AREAS ORDER BY A_NOMBRE";
                                            $result = mysqli_query($db, $query);
                                            while($row = mysqli_fetch_array($result))
                                            {
                                                if($AreaT==$row["A_CODIGO"]){
                                                    $selected="selected";
                                                }else
                                                {$selected="";
                                                }
                                                echo '<option value="'.$row["A_CODIGO"].'" '.$selected.'>'.$row["A_NOMBRE"].'</option>';
                                            }

                                            

                                            ?>
                                        </select>
                                        <label for="Area">Área de Trabajo</label>
                                    </div>
                                </div>
                                                
                                                </div>	
												</div>
												<div class="col-lg-12" align="center">
													<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
												</div>
											</form>
										</div>
                                        <!--Fin -->
											<?php
											}elseif($Area==9){

												?>
												<!--Tercera Opción -->
										<div class="tab-pane active" id="three">
											<form action="EditarAspectoPro.php" method="POST" role="form" class="form">
												<div class="row">
												<div class="col-lg-12">
												<input class="form-control" type="hidden" name="Tipo" id="Tipo" value="Puesto"  readonly/>
												<input class="form-control" type="hidden" name="Codigo" id="Codigo" value="<?php echo $Codigo ?>"  readonly/>
												
												<div class="col-lg-12">
														<div class="form-group">
														<label for="Aspecto">Nombre del Aspecto</label>
														<textarea class="form-control" name="Aspecto" id="Aspecto" rows="2" cols="40" required><?php echo $Nombre; ?></textarea>
														</div>
													</div>
												
												</div>
													<div class="col-lg-6">
										<div class="form-group">
											<select name="AreaP" id="AreaP" onchange="ObtenerDepartamentosLaborales(this.value)" class="form-control" >
											<option  selected disabled><?php echo $NombreArea; ?></option>
												<?php
                                                $Selected="";
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM RRHH.AREAS ORDER BY A_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
        
													echo '<option value="'.$row["A_CODIGO"].'">'.$row["A_NOMBRE"].'</option>';
												}

												?>
											</select>
											<label for="AreaP">Área de Trabajo</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<select name="Puesto" id="Puesto" class="form-control" onchange="ObtenerJefe(this.value)">
												<<option value="<?php echo $Puesto; ?>"  selected><?php echo $NombrePuesto; ?></option>
											</select>
											<label for="Puesto">Puesto Laboral</label>
										</div>
									</div>
														
												</div>
												<div class="col-lg-12" align="center">
													<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
												</div>
											</form>
										</div>
                                        <!--Fin -->
												<?php
												}else{

												
												?>
												<!--Primera Opción -->
										<div class="tab-pane active" id="first2">
											<form action="EditarAspectoPro.php" method="POST" role="form" class="form" >

												<div class="row">
													<div class="col-lg-12">
												<input class="form-control" type="hidden" name="Tipo" id="Tipo" value="General"  readonly/>
												<input class="form-control" type="hidden" name="Codigo" id="Codigo" value="<?php echo $Codigo ?>"  readonly/>
													
                                                        <div class="col-lg-9">
														<div class="form-group">
														<label for="Aspecto">Nombre del Aspecto</label>
														<textarea class="form-control" name="Aspecto" id="Aspecto" rows="2" cols="40" required><?php echo $Nombre; ?></textarea>
														</div>
													</div>
                                                    <div class="col-lg-3">
										<div class="form-group">
											<select name="AreaGen" id="AreaGen" onchange="ObtenerDepartamentosLaborales(this.value)" class="form-control" >
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                $Selected="";
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM RRHH.AREA_EVALUAR WHERE (AR_CODIGO <> 8 OR AR_CODIGO <> 9) ORDER BY AR_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													if($Area==$row["AR_CODIGO"]){
														$selected="selected";
													}else
													{$selected="";
													}
													echo '<option value="'.$row["AR_CODIGO"].'" '.$selected.'>'.$row["AR_NOMBRE"].'</option>';
												}


												?>
											</select>
											<label for="AreaGen">Área de Evaluación General</label>
										</div>
									</div>
													
													</div>	
												</div>
												<div class="col-lg-12" align="center">
													<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
												</div>
											</form>
										</div>
                                        <!--Fin -->
												<?php
												
													
												}
												?>
                                        
                                        
                                        
									</div>
								</div><!--end .card -->
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
