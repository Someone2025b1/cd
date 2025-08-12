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
						$CONT3=7;
						$Consulta = "SELECT A.*
						FROM Eventos.EVENTO AS A
						WHERE (A.EV_FECHA_EV >= NOW() OR A.EV_FECHA_EV >= date_add(NOW(), INTERVAL -2 DAY)) 
						ORDER BY A.EV_FECHA_EV";
						$Resultado = mysqli_query($db, $Consulta);
						while($row = mysqli_fetch_array($Resultado))
						{

                            $CodigoEvento = $row["EV_CODIGO"];

                            $Usuario = $row["EV_ENCARGADO"];

										$sqlRet = mysqli_query($db,"SELECT A.nombre 
										FROM info_bbdd.usuarios AS A     
										WHERE A.id_user = ".$Usuario); 
										$rowret=mysqli_fetch_array($sqlRet);

										$Encargado=$rowret["nombre"];

                        
										$sqlre = "SELECT A.*
										FROM Eventos.EV_PRODUCTOS_AYB AS A
										WHERE A.EV_CODIGO = '$CodigoEvento'";
										$resultre = mysqli_query($db, $sqlre);
										while($rowre = mysqli_fetch_array($resultre))
										{
											$Tiene = "SI";
											
										}

					  if($Tiene == "SI"){
                        ?>
						
                    <div class="card panel">
								<div class="card-head style-<?php echo $Colores[$Color]; ?> collapsed" data-toggle="collapse" data-parent="#accordion6 " data-target="#accordion6-<?php echo $CONT; ?>" aria-expanded="false">
									<header>Fecha: <?php echo $row["EV_FECHA_EV"]." | Lugar: ".$row["EV_LUGAR"]." | Encargado: ".$Encargado; ?></header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-<?php echo $CONT; ?>" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">		
											<div class="col-lg-12">
											<?php 	
											$CONT2=1;	
											$Color2=0;
											$Colores2 = ["background:#E3C1F3; color: #000000; font-weight: bold;",
											"background:#D08FF0; color: #000000; font-weight: bold;",
											"background:#C772F2; color: #000000; font-weight: bold;",
											"background:#BD51F3; color: #000000; font-weight: bold;",
											"background:#AD20F4; color: #000000; font-weight: bold;"];
												$ConsultaDes = "SELECT A.*
												FROM Eventos.EV_REQUERIMIENTOS_AYB AS A
												WHERE A.EV_CODIGO = '$CodigoEvento'
												ORDER BY A.EV_CODIGO";
												$ResultadoDes = mysqli_query($db, $ConsultaDes);
												while($rowDes = mysqli_fetch_array($ResultadoDes))
												{	
													$CodigoDes=$rowDes["EV_CODIGO_REQUERIMIENTO"];
													$TipoD=$rowDes["EVRA_TIPO"];
													$AdultoD=$rowDes["EVRA_ADULTO"];
													$MenuAdultoD=$rowDes["EVRA_MENU_ADULTO"];
													$CantidadAdultoD=$rowDes["EVRA_CANTIDAD_ADULTO"];
													$NinoD=$rowDes["EVRA_NINO"];
													$CantidadNinoD=$rowDes["EVRA_CANTIDAD_NINO"];
													$MenuNinoD=$rowDes["EVRA_MENU_NINO"];
													$HoraD=$rowDes["EVRA_HORA"];
													$ServirEnD=$rowDes["EVRA_SERVIREN"];
													$EstiloD=$rowDes["EVRA_ESTILO"];
													$AdicionalesD=$rowDes["EVRA_ADICIONALES"];
													$ObservacionesAyB=$rowDes["EVRA_OBSERVACIONES"];

													$sqlre = "SELECT A.*
										FROM Eventos.EV_PRODUCTOS_AYB AS A
										WHERE A.EV_CODIGO_REQUERIMIENTO = '$CodigoDes'";
										$resultre = mysqli_query($db, $sqlre);
										while($rowre = mysqli_fetch_array($resultre))
										{
											$TieneT = "SI";
											
										}
										if($TieneT == "SI"){
														
											?> 	
												<div class="card panel"  id="DIVDESAYUNO" >
								<div class="card-head style-success  collapsed" data-toggle="collapse" style="<?php echo $Colores2[$Color2]; ?>;" data-parent="#accordion<?php echo $CONT3; ?>" data-target="#accordion<?php echo $CONT3; ?>-<?php echo $CONT2; ?>" aria-expanded="false">
									<header><?php echo $rowDes["EVRA_TIPO"]; ?></header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion<?php echo $CONT3; ?>-<?php echo $CONT2; ?>" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">		
											<div class="col-lg-12">
											<div class="col-lg-12">
											<div class="row">
									<div class="col-lg-12">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="CodigoDes">Codigo del Tiempo de Comida</label>
											<input class="form-control" type="text" name="CodigoDes" id="CodigoDes" value="<?php echo $CodigoDes ?>" readonly/>
										</div>

										</div>
										
									</div>

									<?php
																	
										$sqlre = "SELECT A.*
										FROM Eventos.EV_PRODUCTOS_AYB AS A
										WHERE A.EV_CODIGO_REQUERIMIENTO = '$CodigoDes'";
										$resultre = mysqli_query($db, $sqlre);
										while($rowre = mysqli_fetch_array($resultre))
										{
											$Esperada = $rowre["EV_FECHA_ESPERADA"];
											$Limite = $rowre["EV_FECHA_LIMITE"];
											$FechaSolicito = $rowre["EV_FECHA_SOLICITO"];
											$HoraSoli= $rowre["EV_HORA_PEDIDO"];
										}
											?>
											<div class="col-lg-3">
											<div class="form-group floating-label">
                                        <label for="Fecha">Fecha Esperada</label>
											<input class="form-control" type="date" name="FechaEsperada" id="FechaEsperada" value="<?php echo $Esperada ?>" required disabled="disabled"/>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Fecha">Fecha Limite</label>
											<input class="form-control" type="date" name="FechaLimite" id="FechaLimite" value="<?php echo $Limite ?>" required disabled="disabled"/>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Fecha">Fecha Solicito</label>
											<input class="form-control" type="date" name="FechaLimite" id="FechaLimite" value="<?php echo $FechaSolicito ?>" required disabled="disabled"/>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Fecha">Hora</label>
											<input class="form-control" type="Time" name="FechaLimite" id="FechaLimite" value="<?php echo $HoraSoli ?>" required disabled="disabled"/>
										</div>
									</div>
							</div>
		
										<table class="table" name="tabla-<?php echo $CONT."-".$TipoD; ?>" id="tabla-<?php echo $CONT."-".$TipoD; ?>" >
																<thead>
																	<tr>
																		<th>Cantidad</th>
																		<th>Cod.</th>
																		<th>Nombre</th>
																		<th>Existencia Actual</th>
																		<th>Observaciones</th>
																	</tr>
																</thead>
																<tbody>
																<?php
																	
																	$sqlreq = "SELECT A.*, B.P_NOMBRE, B.P_EXISTENCIA_BODEGA
																	FROM Eventos.EV_PRODUCTOS_AYB AS A, Productos.PRODUCTO AS B
																	WHERE A.P_CODIGO = B.P_CODIGO 
																	AND A.EV_CODIGO_REQUERIMIENTO = '$CodigoDes'";
																	$resultreq = mysqli_query($db, $sqlreq);
																	while($rowreq = mysqli_fetch_array($resultreq))
																	{
																		$Cantidad1 = $rowreq["EV_CANTIDAD"];
																		$Producto1 = $rowreq["P_CODIGO"];
																		$NombreP   = $rowreq["P_NOMBRE"];
																		$ObservacionP   = $rowreq["EV_OBSERVACIONES_P"];
																		$ExistenciaP = $rowreq["P_EXISTENCIA_BODEGA"];
																		
																		
																		?>
																		<tr>
																	<td><h6><input type="number" class="form-control" name="Cantidad" id="Cantidad"  style="width: 100px" min="0" value="<?php echo $Cantidad1 ?>" disabled="disabled"></h6></td>
																	<td><h6> <input type="number" class="form-control" name="Producto" id="Producto" readonly disabled="disabled" style="width: 100px" value="<?php echo $Producto1 ?>"></h6></td> 		                                                
						                                                <td><h6><input type="text" class="form-control" name="ProductoNombre" id="ProductoNombre" style="width: 300px" value="<?php echo $NombreP ?>" disabled="disabled"></h6></td>
						                                                <td><h6><input type="text" class="form-control" name="ExistenciaP" id="ExistenciaP" style="width: 100px; <?php if($Cantidad1>$ExistenciaP){echo 'color: red;';} ?>" value="<?php echo number_format($ExistenciaP, 2, ".", "")?>" disabled="disabled"></h6></td>
						                                                <td><h6><textarea class="form-control" name="Observaciones" id="Observacionesn" rows="1" cols="40" disabled="disabled"><?php echo $ObservacionP?></textarea></h6></td>
						                                            </tr>
																	  <?php
																	}
																	
																	?>		
																		</tbody>
																</table>
						                                    
										
								
									</div>
											</div>
										</div>
									</div>
									</div>
								
							</div><!--end .panel -->

							
												<?php 
												$CONT2+=1;	
												$Color2+=1;
												$TieneT="NO";
																}
																
												}
											?> 
											
											</div>
										</div>
									</div>
								</div>
							</div><!--end .panel -->

                            <?php

                             $NombreProducto="NO INGRESARON PRODUCCION";
                            $CONT=$CONT+1;
							$CONT3+=1;	

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
