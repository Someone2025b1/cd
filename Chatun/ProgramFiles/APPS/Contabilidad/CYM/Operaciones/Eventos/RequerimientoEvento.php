<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");


$cont = 0;
$fecha_inicio = $_POST["FechaInicio"];
$fecha_fin = $_POST["FechaFin"];
$contatemp = 0;
$fechaActual = strtotime(date("d-m-Y"));

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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

   

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Lista y Detalle Requerimientos de Eventos Proximos</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
                    <div class="container"> 
					<div class="col-lg-12">
						<div class="panel-group" id="accordion6">
                        <?php
                        $Colores = ["info", "success", "danger", "warning", "primary"];
                        $Color=0;
                        $CONT=1;
						$Consulta = "SELECT B.*, A.EV_ENCARGADO, A.EV_FECHA_EV, A.EV_DUENO, A.EV_LUGAR, A.EV_CEL,
						A.EV_HORA_INI, A.EV_HORA_FIN, A.EV_CANTIDAD_PERSONAS, A.EV_OBSERVACIONES, EV_NOMBRE,
						EV_FECHA_CRE, EV_FECHAMOD, EV_HORAINGRESO, EV_HORAMOD
						FROM Eventos.EVENTO AS A, Eventos.EV_REQUERIMIENTOS_OPERACONES AS B
						WHERE (A.EV_FECHA_EV >= NOW() OR A.EV_FECHA_EV >= date_add(NOW(), INTERVAL -2 DAY)) 
						AND A.EV_CODIGO = B.EV_CODIGO AND A.EV_CANCELADO = 0
						ORDER BY A.EV_FECHA_EV";
						$Resultado = mysqli_query($db, $Consulta);
						while($row = mysqli_fetch_array($Resultado))
						{

                            $CodigoProduccion = $row["EV_CODIGO"];
							$FechaCreo=$row["EV_FECHA_CRE"];
							$FechaMod=$row["EV_FECHAMOD"];
							$HoraCreo=$row["EV_HORAINGRESO"];
							$HoraMod=$row["EV_HORAMOD"];
							$Dueno=$row["EV_DUENO"];
							$Cel=$row["EV_CEL"];
							$Encargado=$row["EV_ENCARGADO"];
							$FechaEvento=$row["EV_FECHA_EV"];
							$FechaEvento1=strtotime(date($row["EV_FECHA_EV"]));
							$HoraIni=$row["EV_HORA_INI"];
							$HoraFin=$row["EV_HORA_FIN"];
							$Lugar=$row["EV_LUGAR"];
							$CantidadPersona=$row["EV_CANTIDAD_PERSONAS"];
							$ObservacionesGen=$row["EV_OBSERVACIONES"];
							$NombreEvento = $row["EV_NOMBRE"];

							if($FechaEvento1 == $fechaActual){
								$Color="success";
							}
							
							if($fechaActual > $FechaEvento1){
								$Color="danger";
							}

							if($fechaActual < $FechaEvento1){
								$Color="info";
							}


                            $Usuario = $row["EV_ENCARGADO"];

										$sqlRet = mysqli_query($db,"SELECT A.nombre 
										FROM info_bbdd.usuarios AS A     
										WHERE A.id_user = ".$Usuario); 
										$rowret=mysqli_fetch_array($sqlRet);

										$Encargado=$rowret["nombre"];

                        
										$sqlre = "SELECT A.*
										FROM Eventos.EV_REQUERIMIENTOS_OPERACONES AS A
										WHERE A.EVRO_TIPO_MONTAJE <> '' AND A.EV_CODIGO = '$CodigoProduccion'";
										$resultre = mysqli_query($db, $sqlre);
										while($rowre = mysqli_fetch_array($resultre))
										{
											$Tiene = "SI";
											
										}

						if($Tiene == "SI"){
                      
                        ?>
                    <div class="card panel">
								<div class="card-head style-<?php echo $Color; ?> ollapsed" data-toggle="collapse" data-parent="#accordion6 " data-target="#accordion6-<?php echo $CONT; ?>" aria-expanded="false">
									<header>Fecha: <?php echo $row["EV_FECHA_EV"]." | Lugar: ".$row["EV_LUGAR"]." | Encargado: ".$Encargado; ?></header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-<?php echo $CONT; ?>" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">
										<div class="card-body">
                            <div class="card-head style-primary">
								<h4 class="text-center"> Datos Generales del Evento </h4>
                            </div>
							<div class="row">
									<div class="col-lg-12">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Codigo del Evento</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $CodigoProduccion ?>" readonly/>
											
										</div>
										</div>
										<div class="col-lg-2">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Fecha Creo</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $FechaCreo ?>" readonly/>
											
										</div>
										</div>
										<div class="col-lg-2">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Hora Creo</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $HoraCreo ?>" readonly/>
											
										</div>
										</div>
										<div class="col-lg-2">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Fecha Modificado</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $FechaMod ?>" readonly/>
											
										</div>
										</div>
										<div class="col-lg-2">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Hora Modificado</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $HoraMod ?>" readonly/>
											
										</div>
										</div>
									</div>
							</div>
							<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="NombreDueno">Nombre del Dueño del Evento</label>
											<input class="form-control" type="text" name="NombreDueno" id="NombreDueno" value="<?php echo $Dueno ?>" required readonly/>
											
										</div>
									</div>

									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="NombreEvento">Nombre del Evento</label>
											<input class="form-control" type="text" name="NombreEvento" id="NombreEvento" value="<?php echo $NombreEvento ?>" required/>
											
										</div>
									</div>

									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Celular">Número de Celular</label>
											<input class="form-control" type="text" name="Celular" id="Celular" value="<?php echo $Cel ?>" required readonly/>
											
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Fecha">Fecha del Evento</label>
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $FechaEvento ?>" required readonly/>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraIni">Hora de Inicio</label>
											<input class="form-control" type="time" name="HoraIni" id="HoraIni" value="<?php echo $HoraIni ?>" required readonly/>
											
										</div>
									</div>
                                    <div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraFin">Hora de Fiunalización</label>
											<input class="form-control" type="time" name="HoraFin" id="HoraFin" value="<?php echo $HoraFin ?>" required readonly/>
											
										</div>
									</div>
								</div>
								
								
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Personas">Cantidad de Personas</label>
											<input class="form-control" type="num" name="Personas" id="Personas" value="<?php echo $CantidadPersona ?>" required readonly/>
										</div>
									</div>
								
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Lugar">Lugar</label>
										<select name="Lugar" id="Lugar" class="form-control" onchange="Otro(this.value)" readonly>
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Rancho Raices" <?php if($Lugar=="Rancho Raices"){echo "selected"; $Otro=0;}?>>Rancho Raices</option>
                                                <option value="Rancho Jardín" <?php if($Lugar=="Rancho Jardín"){echo "selected"; $Otro=0;}?>>Rancho Jardín</option>
                                                <option value="Rancho Terrazas" <?php if($Lugar=="Rancho Terrazas"){echo "selected"; $Otro=0;}?>>Rancho Terrazas</option>
                                                <option value="Rancho Chatun" <?php if($Lugar=="Rancho Chatun"){echo "selected"; $Otro=0;}?>>Rancho Chatun</option>
                                                <option value="Área de Teatro" <?php if($Lugar=="Área de Teatro"){echo "selected"; $Otro=0;}?>>Área de Teatro</option>
                                                <option value="Aula Inovarte" <?php if($Lugar=="Aula Inovarte"){echo "selected"; $Otro=0;}?>>Aula Inovarte</option>
                                                <option value="1" <?php if($Otro==1){echo "selected";}?>>Otro</option>
											</select>
										</div>
									</div>
                                    <div class="col-lg-3">
                                    <div class="form-group floating-label" id="DIVOTRO" <?php if($Otro==0){ echo 'style="display: none;"';  }?> readonly>
                                        <label for="Paga">Otro</label>
											<input class="form-control" type="text" name="OtroLugar" id="OtroLugar" value="<?php if($Otro==1){ echo $Lugar;}?>" readonly/>
											
										</div>
                                    </div>
								</div>
                                <div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObservacionesGen">Observaciones Generales</label>
											<input class="form-control" type="text" name="ObservacionesGen" id="ObservacionesGen" value="<?php echo $ObservacionesGen ?>" required readonly/>
											
										</div>
									</div>
									</div>
								</div>		
											<div class="col-lg-12">
											<?php 	
														
											?> 	
												<table class="table table-hover table-condensed">
													<tbody>
                                                    <tr>
															<td><h1><b>Requerimiento</b></h5></td>
															<td><h1><b>Lleva</b></h5></td>
														</tr>
                                                        <?php
                                                   

                                                      ?>
													  <tr>
													     <td><h2><b></b>Tipo Montage</h5></td>
													     <td><h2><b><?php echo $row["EVRO_TIPO_MONTAJE"] ?></b></h5></td>
												  	  </tr>

														<tr>
															<td><h2><b></b>Pizarra</h5></td>
															<td><h2><b><?php if($row["EVRO_PIZARRA"]==1){ echo '<span class="fa fa-check-circle text-success"></span>';}else{echo '<span class="fa fa-times-circle text-danger"></span>'; } ?></b></h5></td>
														</tr>
														
														<tr>
															<td><h2><b></b>Pantalla</h5></td>
															<td><h2><b><?php if($row["EVRO_PANTALLA"]==1){ echo '<span class="fa fa-check-circle text-success"></span>';}else{echo '<span class="fa fa-times-circle text-danger"></span>'; } ?></b></h5></td>
														</tr>
														<tr>
															<td><h2><b></b>Mesa Sonido</h5></td>
															<td><h2><b><?php if($row["EVRO_MESA_SONIDO"]==1){ echo '<span class="fa fa-check-circle text-success"></span>';}else{echo '<span class="fa fa-times-circle text-danger"></span>'; } ?></b></h5></td>
														</tr>
														<tr>
															<td><h2><b></b>Manteleria Completa</h5></td>
															<td><h2><b><?php if($row["EVRO_MANTELERIA_COMPLETA"]==1){ echo '<span class="fa fa-check-circle text-success"></span>';}else{echo '<span class="fa fa-times-circle text-danger"></span>'; } ?></b></h5></td>
														</tr>
														<tr>
															<td><h2><b></b>Tarima</h5></td>
															<td><h2><b><?php if($row["EVRO_TARIMA"]==1){ echo '<span class="fa fa-check-circle text-success"></span>';}else{echo '<span class="fa fa-times-circle text-danger"></span>'; } ?></b></h5></td>
														</tr>
														<tr>
															<td><h2><b></b>Mesa Proyector</h5></td>
															<td><h2><b><?php if($row["EVRO_MESAPRYECTOR"]==1){ echo '<span class="fa fa-check-circle text-success"></span>';}else{echo '<span class="fa fa-times-circle text-danger"></span>'; } ?></b></h5></td>
														</tr>
														<tr>
															<td><h2><b></b>Mesa AyB</h5></td>
															<td><h2><b><?php if($row["EVRO_MESAAYB"]==1){ echo '<span class="fa fa-check-circle text-success"></span>';}else{echo '<span class="fa fa-times-circle text-danger"></span>'; } ?></b></h5></td>
														</tr>
														<tr>
															<td><h2><b></b>Sobre Mantel</h5></td>
															<td><h2><b><?php if($row["EVRO_SOBREMANTEL"]==1){ ?>
															<h5>Color: <?php echo $row["EVRO_COLOR_SOBREMANTEL"] ?></h5>
															<?php }else{echo '<span class="fa fa-times-circle text-danger"></span>'; } ?></b></h5></td>
															
														</tr>
														<tr>
															<td><h2><b></b>Mesas Extra</h5></td>
															<td style="width: 300px"><h2><b><?php if($row["EVRO_CANTIDAD_EXTRA"]>0){ ?>
															<h5><b> Cantidad: </b> <?php echo $row["EVRO_CANTIDAD_EXTRA"] ?> <b> Para: </b> <?php echo $row["EVRO_MESA_PARA"] ?></h5>
															<?php }else{echo '<span class="fa fa-times-circle text-danger"></span>'; } ?></b></h5></td>
														</tr>
														<tr>
															<td colspan="2"><h2><b>Descripción Sillas y Mesas:</b> <?php echo $row["EVRO_SILLA"]; ?></h5></td>
														</tr>
														<tr>
															<td colspan="2"><h2><b>Observaciones: </b><?php echo $row["EVRO_OBSERVACIONES"]; ?></h5></td>
														</tr>
														

                                                        
														 
													</tbody>
												</table>

											</div>
										</div>
									</div>
								</div>
							</div><!--end .panel -->

                            <?php

                             $NombreProducto="NO INGRESARON PRODUCCION";
                            $CONT=$CONT+1;

                            if($Color==4){
                                $Color=0;
                            }else{
                                $Color++;
                            }
							$Tiene="NO";
						}
                        }
                            ?>
					</div>
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
