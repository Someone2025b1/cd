<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$QueryDatos = mysqli_query($db, "SELECT * FROM Bodega.COTIZACION WHERE C_CODIGO = ".$_GET[Codigo]);
$FilaDatos = mysqli_fetch_array($QueryDatos);

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
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<link rel="stylesheet" type="text/css" href="../../../../../libs/alertify/css/alertify.core.css">
	<link rel="stylesheet" type="text/css" href="../../../../../libs/alertify/css/alertify.bootstrap.css">
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

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="card">
				<div class="card-body">
					<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
						<form action="Consulta_Cotizacion_Pro.php" method="POST" class="form floating-label form-validation" role="form" novalidate="novalidate" id="FRMEnviar">

							<input type="hidden" name="RanchoSeleccionado" id="RanchoSeleccionado" value="<?php echo $FilaDatos[C_RANCHO] ?>">
							<input type="hidden" name="MontajeSeleccionado" id="MontajeSeleccionado" value="<?php echo $FilaDatos[C_TIPO_MONTAJE] ?>">
							<input type="hidden" name="Codigo" id="Codigo" value="<?php echo $FilaDatos[C_REFERENCIA] ?>">
							<input type="hidden" name="CodigoCoti" id="CodigoCoti" value="<?php echo $FilaDatos[C_CODIGO] ?>">
							<div class="form-wizard-nav">
								<div class="progress" style="width: 100%;"><div class="progress-bar progress-bar-primary" style="width: 0%;"></div></div>
								<ul class="nav nav-justified nav-pills">
									<li class="active"><a href="#step1" data-toggle="tab"><span class="step">1</span> <span class="title">FECHA</span></a></li>
									<li><a href="#step2" data-toggle="tab"><span class="step">2</span> <span class="title">CLIENTE</span></a></li>
									<li><a href="#step3" data-toggle="tab"><span class="step">3</span> <span class="title">INVITADOS</span></a></li>
									<li><a href="#step4" data-toggle="tab"><span class="step">4</span> <span class="title">RANCHO</span></a></li>
									<li><a href="#step5" data-toggle="tab"><span class="step">5</span> <span class="title">TIPO MONTAJE</span></a></li>
									<li><a href="#step6" data-toggle="tab"><span class="step">6</span> <span class="title">COMIDA/BEBIDA</span></a></li>
									<li><a href="#step7" data-toggle="tab"><span class="step">7</span> <span class="title">MOBILIARIO/MONTAJE</span></a></li>
									<li><a href="#step8" data-toggle="tab"><span class="step">8</span> <span class="title">MOB. ALQUILER</span></a></li>
									<li><a href="#step9" data-toggle="tab"><span class="step">9</span> <span class="title">SERVICIOS</span></a></li>
									<li><a href="#step10" data-toggle="tab"><span class="step">10</span> <span class="title">ACTUALIZAR</span></a></li>
								</ul>
							</div><!--end .form-wizard-nav -->
							<div class="tab-content clearfix">
								<div class="tab-pane active" id="step1">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-4 text-right">
												<span class="text-xxxxl text-light"><i class="fa fa-calendar text-primary"></i></span>
											</div>	
											<div class="col-lg-6">
												<div class="col-lg-12">
													<div class="col-lg-6">
														<div class="form-group floating-label">
															<label>Fecha</label>
															<input type="date" class="form-control" name="Fecha" id="Fecha" value="<?php echo $FilaDatos[C_FECHA_EVENTO] ?>" required>
														</div>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="col-lg-4">
														<div class="form-group  floating-label">
															<label>Hora Inicio</label>
															<input type="time" class="form-control" name="HoraInicio" id="HoraInicio" value="<?php echo $FilaDatos[C_HORA_INICIO_EVENTO] ?>" required>
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group  floating-label">
															<label>Hora Fin</label>
															<input type="time" class="form-control" name="HoraFin" id="HoraFin" value="<?php echo $FilaDatos[C_HORA_FIN_EVENTO] ?>" required>
														</div>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="col-lg-6">
														<div class="form-group ">
															<label>Tipo de Evento</label>
															<select class="form-control" name="TipoEvento" id="TipoEvento">
																<?php
																	$QueryTipoEvento = mysqli_query($db, "SELECT *
																							FROM Bodega.TIPO_EVENTO AS A
																							WHERE A.TE_ESTADO = 1");
																	while($FilaTipoEvento = mysqli_fetch_array($QueryTipoEvento))
																	{
																		if($FilaDatos[TE_CODIGO] == $FilaTipoEvento[TE_CODIGO])
																		{
																			$Texto = 'selected';
																		}
																		else
																		{
																			$Texto = '';
																		}
																		?>
																			<option value="<?php echo $FilaTipoEvento[TE_CODIGO] ?>" <?php echo $Texto ?>><?php echo $FilaTipoEvento[TE_NOMBRE] ?></option>
																		<?php
																	}
																?>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div><!--end #step1 -->
								<div class="tab-pane" id="step2">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<input type="hidden" name="CodigoCliente" id="CodigoCliente" value="<?php echo $FilaDatos[CE_CODIGO] ?>" >
										<div class="col-lg-2 text-right">
											<span class="text-xxxxl text-light"><i class="fa fa-user text-primary"></i></span>
										</div>	
										<div class="col-lg-10">
											<div class="col-lg-12">
												<div class="col-lg-4">
													<div class="form-group floating-label">
														<label>CUI</label>
														<input type="text" class="form-control" name="CUI" id="CUI" value="<?php echo $FilaDatos[CE_CUI] ?>" required onchange="ObtenerDatosCUI(this.value)">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group floating-label">
														<label>NIT</label>
														<input type="text" class="form-control" name="NIT" id="NIT" value="<?php echo $FilaDatos[CE_NIT] ?>" required onchange="ObtenerDatosNIT(this.value)">
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="col-lg-6">
													<div class="form-group  floating-label">
														<label>Nombre</label>
														<input type="text" class="form-control" name="Nombre" id="Nombre" value="<?php echo $FilaDatos[CE_NOMBRE] ?>" required>
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="col-lg-12">
													<div class="form-group  floating-label">
														<label>Dirección</label>
														<input type="text" class="form-control" name="Direccion" id="Direccion" value="<?php echo $FilaDatos[CE_DIRECCION] ?>" required>
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="col-lg-3">
													<div class="form-group  floating-label">
														<label>Celular</label>
														<input type="number" class="form-control" name="Celular" id="Celular" value="<?php echo $FilaDatos[CE_CELULAR] ?>" required>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group  floating-label">
														<label>Teléfono</label>
														<input type="number" class="form-control" name="Telefono" value="<?php echo $FilaDatos[CE_TELEFONO] ?>" id="Telefono">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group  floating-label">
														<label>Email</label>
														<input type="email" class="form-control" name="Email" value="<?php echo $FilaDatos[CE_EMAIL] ?>" id="Email">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div><!--end #step2 -->
								<div class="tab-pane" id="step3">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-4 text-right">
											<span class="text-xxxxl text-light"><i class="fa fa-users text-primary"></i></span>
										</div>	
										<div class="col-lg-8">
											<div class="col-lg-12">
												<div class="col-lg-2">
													<div class="form-group floating-label">
														<label>Adultos</label>
														<input type="number" class="form-control" name="Adultos" id="Adultos" value="<?php echo $FilaDatos[C_INVITADOS_ADULTOS] ?>" required>
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="col-lg-2">
													<div class="form-group  floating-label">
														<label>Niños</label>
														<input type="number" class="form-control" name="Ninos" id="Ninos" value="<?php echo $FilaDatos[C_INVITADOS_NINOS] ?>" required>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div><!--end #step3 -->
								<div class="tab-pane" id="step4">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<div class="row">
											<br>
											<br>
										</div>
										<div class="col-lg-12 text-center">
											<div id="TituloNombreRancho"></div>
										</div>
										<div class="row">
											<br>
											<br>
										</div>
										<?php
											$QueryRanchos = mysqli_query($db, "SELECT *, (SELECT B.FR_RUTA FROM Bodega.FOTOGRAFIA_RANCHO AS B WHERE B.R_REFERENCIA = A.R_REFERENCIA LIMIT 1) AS FOTOGRAFIA
																		FROM Bodega.RANCHO AS A
																		WHERE A.R_ESTADO = 1");
											while($FilaRanchos = mysqli_fetch_array($QueryRanchos))
											{
												?>
													<div class="text-center">
				                                      <div class="col-sm-3">
				                                        <div class="thumbnail">
				                                          <a style="cursor: pointer;" onclick="GaleriaRancho(this)" data-codigo="<?php echo $FilaRanchos[R_CODIGO] ?>"><img style="width: 259px; height: 194px" src="<?php echo '../Mantenimiento/'.$FilaRanchos[FOTOGRAFIA] ?>" alt="..."></a>
				                                          <div class="caption">
				                                            <h3><b><?php echo $FilaRanchos[R_NOMBRE]; ?></b></h3>
				                                            <p><button data-nombre-rancho="<?php echo $FilaRanchos[R_NOMBRE] ?>" onclick="SeleccionarRancho(this)" value="<?php echo $FilaRanchos[R_CODIGO] ?>" type="button" class="btn btn-lg ink-reaction btn-floating-action btn-primary"><i class="fa fa-check"></i></button></p>
				                                          </div>
				                                        </div>
				                                      </div>
				                                    </div>
												<?php
											}
										?>
									</div>
								</div><!--end #step4 -->
								<div class="tab-pane" id="step5">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<div class="row">
											<br>
											<br>
										</div>
										<div class="col-lg-12 text-center">
											<div id="TituloNombreMontaje"></div>
										</div>
										<div class="row">
											<br>
											<br>
										</div>
										<?php
											$QueryRanchos = mysqli_query($db, "SELECT *, (SELECT B.FTM_RUTA FROM Bodega.FOTOGRAFIA_TIPO_MONTAJE AS B WHERE A.TM_REFERENCIA = B.TM_REFERENCIA LIMIT 1) AS FOTOGRAFIA
																			FROM Bodega.TIPO_MONTAJE AS A
																			WHERE A.TM_ESTADO = 1");
											while($FilaRanchos = mysqli_fetch_array($QueryRanchos))
											{
												?>
													<div class="text-center">
				                                      <div class="col-sm-3">
				                                        <div class="thumbnail">
				                                          <a style="cursor: pointer;" onclick="GaleriaRancho(this)" data-codigo="<?php echo $FilaRanchos[TM_CODIGO] ?>"><img style="width: 259px; height: 194px" src="<?php echo '../Mantenimiento/'.$FilaRanchos[FOTOGRAFIA] ?>" alt="..."></a>
				                                          <div class="caption">
				                                            <h3><b><?php echo $FilaRanchos[TM_NOMBRE]; ?></b></h3>
				                                            <p><button data-nombre-montaje="<?php echo $FilaRanchos[TM_NOMBRE] ?>" onclick="SeleccionarTipoMontaje(this)"  value="<?php echo $FilaRanchos[TM_CODIGO] ?>" type="button" class="btn btn-lg ink-reaction btn-floating-action btn-primary"><i class="fa fa-check"></i></button></p>
				                                          </div>
				                                        </div>
				                                      </div>
				                                    </div>
												<?php
											}
										?>
									</div>
								</div><!--end #step4 -->
								<div class="tab-pane" id="step6">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-1 text-right">
											<span class="text-xxxxl text-light"><i class="fa fa-cutlery text-primary"></i></span>
										</div>	
										<div class="col-lg-11">
											<div class="col-lg-12">
												<table class="table table-hover table-condensed" id="tabla">
													<caption class="text-center"><h3><strong>PLATILLOS - GUARNICIONES - BEBIDAS</strong></h3></caption>
													<thead>
														<tr>
															<th><h5>NOMBRE</h5></th>
															<th><h5>PRECIO</h5></th>
															<th><h5>CANTIDAD</h5></th>
															<th><h5>DESCUENTO</h5></th>
															<th><h5>SUBTOTAL</h5></th>
														</tr>
													</thead>
													<tbody>
														<tr class="fila-base">
															<td>
																<select class="form-control" name="Receta[]" id="Receta[]" onchange="ObtenerDatos(this)">
																	<option value="" disabled selected>Seleccione un Platillo</option>
																	<?php
																		$QueryPlatillo = mysqli_query($db, "SELECT A.RS_CODIGO, A.RS_NOMBRE
																										FROM Bodega.RECETA_SUBRECETA AS A
																										WHERE A.RS_MODULO = 'EV'
																										AND A.RS_TIPO = 1
																										AND A.RS_MOSTRAR_MENU = 1");
																		while($FilaPlatillo = mysqli_fetch_array($QueryPlatillo))
																		{
																			?>
																				<option value="<?php echo $FilaPlatillo[RS_CODIGO] ?>"><?php echo $FilaPlatillo[RS_NOMBRE] ?></option>
																			<?php
																		}
																	?>
																</select>
															</td>
															<td>
																<input type="number" class="form-control" name="Precio[]" id="Precio[]" readonly>
															</td>
															<td>
																<input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onchange="Calcular()">
															</td>
															<td>
																<input type="number" class="form-control" name="Descuento[]" id="Descuento[]" onchange="Calcular()">
															</td>
															<td>
																<input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]" readonly>
															</td>
															<td class="eliminar">
																<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
															</td>
														</tr>
														<?php  
															$QueryPlatilloGuardados = mysqli_query($db, "SELECT *
																									FROM Bodega.PLATILLO_EVENTO AS A
																									WHERE A.C_REFERENCIA = '".$FilaDatos[C_REFERENCIA]."'");
															while($FilaPlatilloGuardados = mysqli_fetch_array($QueryPlatilloGuardados))
															{
																?>
																	<tr>
																		<td>
																			<select class="form-control" name="Receta[]" id="Receta[]" onchange="ObtenerDatos(this)">
																				<?php
																					$QueryPlatillo = mysqli_query($db, "SELECT A.RS_CODIGO, A.RS_NOMBRE
																													FROM Bodega.RECETA_SUBRECETA AS A
																													WHERE A.RS_MODULO = 'EV'
																													AND A.RS_TIPO = 1
																													AND A.RS_MOSTRAR_MENU = 1");
																					while($FilaPlatillo = mysqli_fetch_array($QueryPlatillo))
																					{
																						if($FilaPlatilloGuardados[RS_CODIGO] == $FilaPlatillo[RS_CODIGO])
																						{
																							$Texto = 'selected';
																						}
																						else
																						{
																							$Texto = '';
																						}

																						?>
																							<option value="<?php echo $FilaPlatillo[RS_CODIGO] ?>" <?php echo $Texto ?>><?php echo $FilaPlatillo[RS_NOMBRE] ?></option>
																						<?php
																					}
																				?>
																			</select>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="Precio[]" id="Precio[]" value="<?php echo $FilaPlatilloGuardados[PE_PRECIO] ?>" readonly>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" value="<?php echo $FilaPlatilloGuardados[PE_CANTIDAD] ?>" onchange="Calcular()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="Descuento[]" id="Descuento[]" value="<?php echo $FilaPlatilloGuardados[PE_DESCUENTO] ?>" onchange="Calcular()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]" value="<?php echo $FilaPlatilloGuardados[PE_SUBTOTAL] ?>" readonly>
																		</td>
																		<td class="eliminar">
																			<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
																		</td>
																	</tr>
																<?php
															}
														?>
													</tbody>
												</table>
												<div class="col-lg-12 text-right">
													<button type="button" class="btn btn-success" id="agregar"><span class="glyphicon glyphicon-plus"></span></button>
												</div>
											</div>
										</div>
									</div>
								</div><!--end #step4 -->
								<div class="tab-pane" id="step7">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-1 text-right">
											<span class="text-xxxxl text-light"><i class="fa fa-archive text-primary"></i></span>
										</div>	
										<div class="col-lg-11">
											<div class="col-lg-12">
												<table class="table table-hover table-condensed" id="tablaMobiliarioCristaleria">
													<caption class="text-center"><h3><strong>MOBILIARIO - CRISTALERÍA</strong></h3></caption>
													<thead>
														<tr>
															<th><h5>NOMBRE</h5></th>
															<th><h5>PRECIO</h5></th>
															<th><h5>CANTIDAD</h5></th>
															<th><h5>DESCUENTO</h5></th>
															<th><h5>SUBTOTAL</h5></th>
														</tr>
													</thead>
													<tbody>
														<tr class="fila-base">
															<td>
																<select class="form-control" name="MobiliarioCristaleria[]" id="MobiliarioCristaleria[]" onchange="ObtenerDatosMobiliarioCristaleria(this)">
																	<option value="" disabled selected>Seleccione una opción</option>
																	<?php
																		$QueryMobiliario = mysqli_query($db, "SELECT A.M_CODIGO, A.M_NOMBRE, B.TM_NOMBRE
																										FROM Bodega.MOBILIARIO AS A
																										INNER JOIN Bodega.TIPO_MOBILIARIO AS B ON A.TM_CODIGO = B.TM_CODIGO
																										INNER JOIN Bodega.CATEGORIA_MOBILIARIO AS C ON A.CM_CODIGO = C.CM_CODIGO
																										WHERE A.M_ESTADO = 1
																										AND C.CM_CODIGO = 1
																										ORDER BY M_NOMBRE");
																		while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																		{
																			?>
																				<option value="<?php echo $FilaMobiliario[M_CODIGO] ?>"><?php echo $FilaMobiliario[M_NOMBRE] ?></option>
																			<?php
																		}
																	?>
																</select>
															</td>
															<td>
																<input type="number" class="form-control" name="PrecioMobiliarioCristaleria[]" id="PrecioMobiliarioCristaleria[]" readonly>
															</td>
															<td>
																<input type="number" class="form-control" name="CantidadMobiliarioCristaleria[]" id="CantidadMobiliarioCristaleria[]" onchange="CalcularMobiliarioCristaleria()">
															</td>
															<td>
																<input type="number" class="form-control" name="DescuentoMobiliarioCristaleria[]" id="DescuentoMobiliarioCristaleria[]" onchange="CalcularMobiliarioCristaleria()">
															</td>
															<td>
																<input type="number" class="form-control" name="SubTotalMobiliarioCristaleria[]" id="SubTotalMobiliarioCristaleria[]" readonly>
															</td>
															<td class="eliminarMobiliarioCristaleria">
																<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
															</td>
														</tr>
														<?php
															$QueryMobiliarioGuardado = mysqli_query($db, "SELECT A.*
																									FROM Bodega.MOBILIARIO_EVENTO AS A
																									INNER JOIN Bodega.MOBILIARIO AS B ON A.M_CODIGO = B.M_CODIGO
																									WHERE A.C_REFERENCIA = '".$FilaDatos[C_REFERENCIA]."'
																									AND B.CM_CODIGO = 1");
															while($FilaMobiliarioGuardado = mysqli_fetch_array($QueryMobiliarioGuardado))
															{
																?>
																	<tr>
																		<td>
																			<select class="form-control" name="MobiliarioCristaleria[]" id="MobiliarioCristaleria[]" onchange="ObtenerDatosMobiliarioCristaleria(this)">
																				<?php
																					$QueryMobiliario = mysqli_query($db, "SELECT A.M_CODIGO, A.M_NOMBRE, B.TM_NOMBRE
																													FROM Bodega.MOBILIARIO AS A
																													INNER JOIN Bodega.TIPO_MOBILIARIO AS B ON A.TM_CODIGO = B.TM_CODIGO
																													WHERE A.M_ESTADO = 1");
																					while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																					{
																						if($FilaMobiliarioGuardado[M_CODIGO] == $FilaMobiliario[M_CODIGO])
																						{
																							$Texto = 'selected';
																						}
																						else
																						{
																							$Texto = '';
																						}
																						?>
																							<option value="<?php echo $FilaMobiliario[M_CODIGO] ?>" <?php echo $Texto ?>><?php echo $FilaMobiliario[M_NOMBRE].' '.$FilaMobiliario[TM_NOMBRE] ?></option>
																						<?php
																					}
																				?>
																			</select>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="PrecioMobiliarioCristaleria[]" value="<?php echo $FilaMobiliarioGuardado[M_PRECIO] ?>" id="PrecioMobiliarioCristaleria[]" readonly>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="CantidadMobiliarioCristaleria[]" value="<?php echo $FilaMobiliarioGuardado[M_CANTIDAD] ?>" id="CantidadMobiliarioCristaleria[]" onchange="CalcularMobiliarioCristaleria()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="DescuentoMobiliarioCristaleria[]" value="<?php echo $FilaMobiliarioGuardado[M_DESCUENTO] ?>" id="DescuentoMobiliarioCristaleria[]" onchange="CalcularMobiliarioCristaleria()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="SubTotalMobiliarioCristaleria[]" value="<?php echo $FilaMobiliarioGuardado[M_SUBTOTAL] ?>" id="SubTotalMobiliarioCristaleria[]" readonly>
																		</td>
																		<td class="eliminarMobiliario">
																			<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
																		</td>
																	</tr>
																<?php
															}
														?>
													</tbody>
												</table>
												<div class="col-lg-12 text-right">
													<button type="button" class="btn btn-success" id="agregarMobiliarioCristaleria"><span class="glyphicon glyphicon-plus"></span></button>
												</div>
											</div>
											<div class="col-lg-12">
												<table class="table table-hover table-condensed" id="tablaMobiliarioManteleria">
													<caption class="text-center"><h3><strong>MOBILIARIO - MANTELERIA</strong></h3></caption>
													<thead>
														<tr>
															<th><h5>NOMBRE</h5></th>
															<th><h5>PRECIO</h5></th>
															<th><h5>CANTIDAD</h5></th>
															<th><h5>DESCUENTO</h5></th>
															<th><h5>SUBTOTAL</h5></th>
														</tr>
													</thead>
													<tbody>
														<tr class="fila-base">
															<td>
																<select class="form-control" name="MobiliarioManteleria[]" id="MobiliarioManteleria[]" onchange="ObtenerDatosMobiliarioManteleria(this)">
																	<option value="" disabled selected>Seleccione una opción</option>
																	<?php
																		$QueryMobiliario = mysqli_query($db, "SELECT A.M_CODIGO, A.M_NOMBRE, B.TM_NOMBRE
																										FROM Bodega.MOBILIARIO AS A
																										INNER JOIN Bodega.TIPO_MOBILIARIO AS B ON A.TM_CODIGO = B.TM_CODIGO
																										INNER JOIN Bodega.CATEGORIA_MOBILIARIO AS C ON A.CM_CODIGO = C.CM_CODIGO
																										WHERE A.M_ESTADO = 1
																										AND C.CM_CODIGO = 2
																										ORDER BY M_NOMBRE");
																		while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																		{
																			?>
																				<option value="<?php echo $FilaMobiliario[M_CODIGO] ?>"><?php echo $FilaMobiliario[M_NOMBRE] ?></option>
																			<?php
																		}
																	?>
																</select>
															</td>
															<td>
																<input type="number" class="form-control" name="PrecioMobiliarioManteleria[]" id="PrecioMobiliarioManteleria[]" readonly>
															</td>
															<td>
																<input type="number" class="form-control" name="CantidadMobiliarioManteleria[]" id="CantidadMobiliarioManteleria[]" onchange="CalcularMobiliarioManteleria()">
															</td>
															<td>
																<input type="number" class="form-control" name="DescuentoMobiliarioManteleria[]" id="DescuentoMobiliarioManteleria[]" onchange="CalcularMobiliarioManteleria()">
															</td>
															<td>
																<input type="number" class="form-control" name="SubTotalMobiliarioManteleria[]" id="SubTotalMobiliarioManteleria[]" readonly>
															</td>
															<td class="eliminarMobiliarioManteleria">
																<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
															</td>
														</tr>
														<?php
															$QueryMobiliarioGuardado = mysqli_query($db, "SELECT A.*
																									FROM Bodega.MOBILIARIO_EVENTO AS A
																									INNER JOIN Bodega.MOBILIARIO AS B ON A.M_CODIGO = B.M_CODIGO
																									WHERE A.C_REFERENCIA = '".$FilaDatos[C_REFERENCIA]."'
																									AND B.CM_CODIGO = 2");
															while($FilaMobiliarioGuardado = mysqli_fetch_array($QueryMobiliarioGuardado))
															{
																?>
																	<tr>
																		<td>
																			<select class="form-control" name="MobiliarioManteleria[]" id="MobiliarioManteleria[]" onchange="ObtenerDatosMobiliarioManteleria(this)">
																				<?php
																					$QueryMobiliario = mysqli_query($db, "SELECT A.M_CODIGO, A.M_NOMBRE, B.TM_NOMBRE
																													FROM Bodega.MOBILIARIO AS A
																													INNER JOIN Bodega.TIPO_MOBILIARIO AS B ON A.TM_CODIGO = B.TM_CODIGO
																													WHERE A.M_ESTADO = 1");
																					while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																					{
																						if($FilaMobiliarioGuardado[M_CODIGO] == $FilaMobiliario[M_CODIGO])
																						{
																							$Texto = 'selected';
																						}
																						else
																						{
																							$Texto = '';
																						}
																						?>
																							<option value="<?php echo $FilaMobiliario[M_CODIGO] ?>" <?php echo $Texto ?>><?php echo $FilaMobiliario[M_NOMBRE].' '.$FilaMobiliario[TM_NOMBRE] ?></option>
																						<?php
																					}
																				?>
																			</select>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="PrecioMobiliarioManteleria[]" value="<?php echo $FilaMobiliarioGuardado[M_PRECIO] ?>" id="PrecioMobiliarioManteleria[]" readonly>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="CantidadMobiliarioManteleria[]" value="<?php echo $FilaMobiliarioGuardado[M_CANTIDAD] ?>" id="CantidadMobiliarioManteleria[]" onchange="CalcularMobiliarioCristaleria()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="DescuentoMobiliarioManteleria[]" value="<?php echo $FilaMobiliarioGuardado[M_DESCUENTO] ?>" id="DescuentoMobiliarioManteleria[]" onchange="CalcularMobiliarioCristaleria()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="SubTotalMobiliarioManteleria[]" value="<?php echo $FilaMobiliarioGuardado[M_SUBTOTAL] ?>" id="SubTotalMobiliarioManteleria[]" readonly>
																		</td>
																		<td class="eliminarMobiliarioManteleria">
																			<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
																		</td>
																	</tr>
																<?php
															}
														?>
													</tbody>
												</table>
												<div class="col-lg-12 text-right">
													<button type="button" class="btn btn-success" id="agregarMobiliarioManteleria"><span class="glyphicon glyphicon-plus"></span></button>
												</div>
											</div>
											<div class="col-lg-12">
												<table class="table table-hover table-condensed" id="tablaMobiliarioMobiliario">
													<caption class="text-center"><h3><strong>MOBILIARIO</strong></h3></caption>
													<thead>
														<tr>
															<th><h5>NOMBRE</h5></th>
															<th><h5>PRECIO</h5></th>
															<th><h5>CANTIDAD</h5></th>
															<th><h5>DESCUENTO</h5></th>
															<th><h5>SUBTOTAL</h5></th>
														</tr>
													</thead>
													<tbody>
														<tr class="fila-base">
															<td>
																<select class="form-control" name="MobiliarioMobiliario[]" id="MobiliarioMobiliario[]" onchange="ObtenerDatosMobiliarioMobiliario(this)">
																	<option value="" disabled selected>Seleccione una opción</option>
																	<?php
																		$QueryMobiliario = mysqli_query($db, "SELECT A.M_CODIGO, A.M_NOMBRE, B.TM_NOMBRE
																										FROM Bodega.MOBILIARIO AS A
																										INNER JOIN Bodega.TIPO_MOBILIARIO AS B ON A.TM_CODIGO = B.TM_CODIGO
																										INNER JOIN Bodega.CATEGORIA_MOBILIARIO AS C ON A.CM_CODIGO = C.CM_CODIGO
																										WHERE A.M_ESTADO = 1
																										AND C.CM_CODIGO = 3
																										ORDER BY M_NOMBRE");
																		while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																		{
																			?>
																				<option value="<?php echo $FilaMobiliario[M_CODIGO] ?>"><?php echo $FilaMobiliario[M_NOMBRE].' '.$FilaMobiliario[TM_NOMBRE] ?></option>
																			<?php
																		}
																	?>
																</select>
															</td>
															<td>
																<input type="number" class="form-control" name="PrecioMobiliarioMobiliario[]" id="PrecioMobiliarioMobiliario[]" readonly>
															</td>
															<td>
																<input type="number" class="form-control" name="CantidadMobiliarioMobiliario[]" id="CantidadMobiliarioMobiliario[]" onchange="CalcularMobiliarioMobiliario()">
															</td>
															<td>
																<input type="number" class="form-control" name="DescuentoMobiliarioMobiliario[]" id="DescuentoMobiliarioMobiliario[]" onchange="CalcularMobiliarioMobiliario()">
															</td>
															<td>
																<input type="number" class="form-control" name="SubTotalMobiliarioMobiliario[]" id="SubTotalMobiliarioMobiliario[]" readonly>
															</td>
															<td class="eliminarMobiliarioMobiliario">
																<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
															</td>
														</tr>
														<?php
															$QueryMobiliarioGuardado = mysqli_query($db, "SELECT A.*
																									FROM Bodega.MOBILIARIO_EVENTO AS A
																									INNER JOIN Bodega.MOBILIARIO AS B ON A.M_CODIGO = B.M_CODIGO
																									WHERE A.C_REFERENCIA = '".$FilaDatos[C_REFERENCIA]."'
																									AND B.CM_CODIGO = 3");
															while($FilaMobiliarioGuardado = mysqli_fetch_array($QueryMobiliarioGuardado))
															{
																?>
																	<tr>
																		<td>
																			<select class="form-control" name="MobiliarioMobiliario[]" id="MobiliarioMobiliario[]" onchange="ObtenerDatosMobiliarioMobiliario(this)">
																				<?php
																					$QueryMobiliario = mysqli_query($db, "SELECT A.M_CODIGO, A.M_NOMBRE, B.TM_NOMBRE
																													FROM Bodega.MOBILIARIO AS A
																													INNER JOIN Bodega.TIPO_MOBILIARIO AS B ON A.TM_CODIGO = B.TM_CODIGO
																													WHERE A.M_ESTADO = 1");
																					while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																					{
																						if($FilaMobiliarioGuardado[M_CODIGO] == $FilaMobiliario[M_CODIGO])
																						{
																							$Texto = 'selected';
																						}
																						else
																						{
																							$Texto = '';
																						}
																						?>
																							<option value="<?php echo $FilaMobiliario[M_CODIGO] ?>" <?php echo $Texto ?>><?php echo $FilaMobiliario[M_NOMBRE].' '.$FilaMobiliario[TM_NOMBRE] ?></option>
																						<?php
																					}
																				?>
																			</select>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="PrecioMobiliarioMobiliario[]" value="<?php echo $FilaMobiliarioGuardado[M_PRECIO] ?>" id="PrecioMobiliarioMobiliario[]" readonly>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="CantidadMobiliarioMobiliario[]" value="<?php echo $FilaMobiliarioGuardado[M_CANTIDAD] ?>" id="CantidadMobiliarioMobiliario[]" onchange="CalcularMobiliarioMobiliario()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="DescuentoMobiliarioMobiliario[]" value="<?php echo $FilaMobiliarioGuardado[M_DESCUENTO] ?>" id="DescuentoMobiliarioMobiliario[]" onchange="CalcularMobiliarioMobiliario()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="SubTotalMobiliarioMobiliario[]" value="<?php echo $FilaMobiliarioGuardado[M_SUBTOTAL] ?>" id="SubTotalMobiliarioMobiliario[]" readonly>
																		</td>
																		<td class="eliminarMobiliarioMobiliario">
																			<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
																		</td>
																	</tr>
																<?php
															}
														?>
													</tbody>
												</table>
												<div class="col-lg-12 text-right">
													<button type="button" class="btn btn-success" id="agregarMobiliarioMobiliario"><span class="glyphicon glyphicon-plus"></span></button>
												</div>
											</div>
											<div class="col-lg-12">
												<table class="table table-hover table-condensed" id="tablaMobiliarioEquipo">
													<caption class="text-center"><h3><strong>MOBILIARIO - EQUIPO</strong></h3></caption>
													<thead>
														<tr>
															<th><h5>NOMBRE</h5></th>
															<th><h5>PRECIO</h5></th>
															<th><h5>CANTIDAD</h5></th>
															<th><h5>DESCUENTO</h5></th>
															<th><h5>SUBTOTAL</h5></th>
														</tr>
													</thead>
													<tbody>
														<tr class="fila-base">
															<td>
																<select class="form-control" name="MobiliarioEquipo[]" id="MobiliarioEquipo[]" onchange="ObtenerDatosMobiliarioEquipo(this)">
																	<option value="" disabled selected>Seleccione una opción</option>
																	<?php
																		$QueryMobiliario = mysqli_query($db, "SELECT A.M_CODIGO, A.M_NOMBRE, B.TM_NOMBRE
																										FROM Bodega.MOBILIARIO AS A
																										INNER JOIN Bodega.TIPO_MOBILIARIO AS B ON A.TM_CODIGO = B.TM_CODIGO
																										INNER JOIN Bodega.CATEGORIA_MOBILIARIO AS C ON A.CM_CODIGO = C.CM_CODIGO
																										WHERE A.M_ESTADO = 1
																										AND C.CM_CODIGO = 4
																										ORDER BY M_NOMBRE");
																		while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																		{
																			?>
																				<option value="<?php echo $FilaMobiliario[M_CODIGO] ?>"><?php echo $FilaMobiliario[M_NOMBRE] ?></option>
																			<?php
																		}
																	?>
																</select>
															</td>
															<td>
																<input type="number" class="form-control" name="PrecioMobiliarioEquipo[]" id="PrecioMobiliarioEquipo[]" readonly>
															</td>
															<td>
																<input type="number" class="form-control" name="CantidadMobiliarioEquipo[]" id="CantidadMobiliarioEquipo[]" onchange="CalcularMobiliarioEquipo()">
															</td>
															<td>
																<input type="number" class="form-control" name="DescuentoMobiliarioEquipo[]" id="DescuentoMobiliarioEquipo[]" onchange="CalcularMobiliarioEquipo()">
															</td>
															<td>
																<input type="number" class="form-control" name="SubTotalMobiliarioEquipo[]" id="SubTotalMobiliarioEquipo[]" readonly>
															</td>
															<td class="eliminarMobiliarioMobiliario">
																<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
															</td>
														</tr>
														<?php
															$QueryMobiliarioGuardado = mysqli_query($db, "SELECT A.*
																									FROM Bodega.MOBILIARIO_EVENTO AS A
																									INNER JOIN Bodega.MOBILIARIO AS B ON A.M_CODIGO = B.M_CODIGO
																									WHERE A.C_REFERENCIA = '".$FilaDatos[C_REFERENCIA]."'
																									AND B.CM_CODIGO = 4");
															while($FilaMobiliarioGuardado = mysqli_fetch_array($QueryMobiliarioGuardado))
															{
																?>
																	<tr>
																		<td>
																			<select class="form-control" name="MobiliarioEquipo[]" id="MobiliarioEquipo[]" onchange="ObtenerDatosMobiliarioEquipo(this)">
																				<?php
																					$QueryMobiliario = mysqli_query($db, "SELECT A.M_CODIGO, A.M_NOMBRE, B.TM_NOMBRE
																													FROM Bodega.MOBILIARIO AS A
																													INNER JOIN Bodega.TIPO_MOBILIARIO AS B ON A.TM_CODIGO = B.TM_CODIGO
																													WHERE A.M_ESTADO = 1");
																					while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																					{
																						if($FilaMobiliarioGuardado[M_CODIGO] == $FilaMobiliario[M_CODIGO])
																						{
																							$Texto = 'selected';
																						}
																						else
																						{
																							$Texto = '';
																						}
																						?>
																							<option value="<?php echo $FilaMobiliario[M_CODIGO] ?>" <?php echo $Texto ?>><?php echo $FilaMobiliario[M_NOMBRE].' '.$FilaMobiliario[TM_NOMBRE] ?></option>
																						<?php
																					}
																				?>
																			</select>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="PrecioMobiliarioEquipo[]" value="<?php echo $FilaMobiliarioGuardado[M_PRECIO] ?>" id="PrecioMobiliarioEquipo[]" readonly>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="CantidadMobiliarioEquipo[]" value="<?php echo $FilaMobiliarioGuardado[M_CANTIDAD] ?>" id="CantidadMobiliarioEquipo[]" onchange="CalcularMobiliarioMobiliario()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="DescuentoMobiliarioEquipo[]" value="<?php echo $FilaMobiliarioGuardado[M_DESCUENTO] ?>" id="DescuentoMobiliarioEquipo[]" onchange="CalcularMobiliarioMobiliario()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="SubTotalMobiliarioEquipo[]" value="<?php echo $FilaMobiliarioGuardado[M_SUBTOTAL] ?>" id="SubTotalMobiliarioEquipo[]" readonly>
																		</td>
																		<td class="eliminarMobiliarioMobiliario">
																			<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
																		</td>
																	</tr>
																<?php
															}
														?>
													</tbody>
												</table>
												<div class="col-lg-12 text-right">
													<button type="button" class="btn btn-success" id="agregarMobiliarioEquipo"><span class="glyphicon glyphicon-plus"></span></button>
												</div>
											</div>
										</div>
									</div>
								</div><!--end #step4 -->
								<div class="tab-pane" id="step8">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-1 text-right">
											<span class="text-xxxxl text-light"><i class="fa fa-archive text-primary"></i></span>
										</div>	
										<div class="col-lg-11">
											<div class="col-lg-12">
												<table class="table table-hover table-condensed" id="tablaMobiliarioAlquiler">
													<caption class="text-center"><h3><strong>MOBILIARIO ALQUILER</strong></h3></caption>
													<thead>
														<tr>
															<th><h5>NOMBRE</h5></th>
															<th><h5>PRECIO</h5></th>
															<th><h5>CANTIDAD</h5></th>
															<th><h5>DESCUENTO</h5></th>
															<th><h5>SUBTOTAL</h5></th>
														</tr>
													</thead>
													<tbody>
														<tr class="fila-base">
															<td>
																<select class="form-control" name="MobiliarioAlquiler[]" id="MobiliarioAlquiler[]" onchange="ObtenerDatosMobiliarioAlquiler(this)">
																	<option value="" disabled selected>Seleccione una opción</option>
																	<?php
																		$QueryMobiliario = mysqli_query($db, "SELECT C.MA_CODIGO, C.MA_NOMBRE, E.TM_NOMBRE
																										FROM Bodega.MOBILIARIO_ALQUILER AS C
																										INNER JOIN Bodega.TIPO_MOBILIARIO AS E ON C.TM_CODIGO = E.TM_CODIGO
																										WHERE C.MA_ESTADO = 1");
																		while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																		{
																			?>
																				<option value="<?php echo $FilaMobiliario[MA_CODIGO] ?>"><?php echo $FilaMobiliario[MA_NOMBRE].' '.$FilaMobiliario[TM_NOMBRE] ?></option>
																			<?php
																		}
																	?>
																</select>
															</td>
															<td>
																<input type="number" class="form-control" name="PrecioMobiliarioAlquiler[]" id="PrecioMobiliarioAlquiler[]" readonly>
															</td>
															<td>
																<input type="number" class="form-control" name="CantidadMobiliarioAlquiler[]" id="CantidadMobiliarioAlquiler[]" onchange="CalcularMobiliarioAlquiler()">
															</td>
															<td>
																<input type="number" class="form-control" name="DescuentoMobiliarioAlquiler[]" id="DescuentoMobiliarioAlquiler[]" onchange="CalcularMobiliarioAlquiler()">
															</td>
															<td>
																<input type="number" class="form-control" name="SubTotalMobiliarioAlquiler[]" id="SubTotalMobiliarioAlquiler[]" readonly>
															</td>
															<td class="eliminarMobiliarioAlquiler">
																<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
															</td>
														</tr>
														<?php
															$QueryMobiliarioAlquiler = mysqli_query($db, "SELECT *
																									FROM Bodega.MOBILIARIO_EVENTO_ALQUILER AS A
																									WHERE A.C_REFERENCIA = '".$FilaDatos[C_REFERENCIA]."'");
															while($FilaMobiliarioAlquilerGuardado = mysqli_fetch_array($QueryMobiliarioAlquiler))
															{
																?>
																	<tr>
																		<td>
																			<select class="form-control" name="MobiliarioAlquiler[]" id="MobiliarioAlquiler[]" onchange="ObtenerDatosMobiliario(this)">
																				<?php
																					$QueryMobiliario = mysqli_query($db, "SELECT A.MA_CODIGO, A.MA_NOMBRE, B.TM_NOMBRE
																													FROM Bodega.MOBILIARIO_ALQUILER AS A
																													INNER JOIN Bodega.TIPO_MOBILIARIO AS B ON A.TM_CODIGO = B.TM_CODIGO
																													WHERE A.MA_ESTADO = 1");
																					while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																					{
																						if($FilaMobiliarioAlquilerGuardado[MEA_CODIGO] == $FilaMobiliario[MA_CODIGO])
																						{
																							$Texto = 'selected';
																						}
																						else
																						{
																							$Texto = '';
																						}
																						?>
																							<option value="<?php echo $FilaMobiliario[MA_CODIGO] ?>" <?php echo $Texto ?>><?php echo $FilaMobiliario[MA_NOMBRE].' '.$FilaMobiliario[TM_NOMBRE] ?></option>
																						<?php
																					}
																				?>
																			</select>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="PrecioMobiliarioAlquiler[]" value="<?php echo $FilaMobiliarioAlquilerGuardado[MEA_PRECIO] ?>" id="PrecioMobiliarioAlquiler[]" readonly>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="CantidadMobiliarioAlquiler[]" value="<?php echo $FilaMobiliarioAlquilerGuardado[MEA_CANTIDAD] ?>" id="CantidadMobiliarioAlquiler[]" onchange="CalcularMobiliarioAlquiler()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="DescuentoMobiliarioAlquiler[]" value="<?php echo $FilaMobiliarioAlquilerGuardado[MEA_DESCUENTO] ?>" id="DescuentoMobiliarioAlquiler[]" onchange="CalcularMobiliarioAlquiler()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="SubTotalMobiliarioAlquiler[]" value="<?php echo $FilaMobiliarioAlquilerGuardado[MEA_SUBTOTAL] ?>" id="SubTotalMobiliarioAlquiler[]" readonly>
																		</td>
																		<td class="eliminarMobiliarioAlquiler">
																			<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
																		</td>
																	</tr>
																<?php
															}
														?>
													</tbody>
												</table>
												<div class="col-lg-12 text-right">
													<button type="button" class="btn btn-success" id="agregarMobiliarioAlquiler"><span class="glyphicon glyphicon-plus"></span></button>
												</div>
											</div>
										</div>
									</div>
								</div><!--end #step4 -->
								<div class="tab-pane" id="step9">
									<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-1 text-right">
											<span class="text-xxxxl text-light"><i class="fa fa-archive text-primary"></i></span>
										</div>	
										<div class="col-lg-11">
											<div class="col-lg-12 text-center">
												<table class="table table-hover table-condensed" id="tablaServicios">
													<caption class="text-center"><h3><strong>SERVICIOS</strong></h3></caption>
													<thead>
														<tr>
															<th><h5>NOMBRE</h5></th>
															<th><h5>PRECIO</h5></th>
															<th><h5>CANTIDAD</h5></th>
															<th><h5>DESCUENTO</h5></th>
															<th><h5>SUBTOTAL</h5></th>
														</tr>
													</thead>
													<tbody>
														<tr class="fila-base">
															<td>
																<select class="form-control" name="Servicios[]" id="Servicios[]" onchange="ObtenerDatosServicios(this)">
																	<option value="" disabled selected>Seleccione una opción</option>
																	<?php
																		$QueryMobiliario = mysqli_query($db, "SELECT A.SE_CODIGO, A.SE_NOMBRE
																										FROM Bodega.SERVICIO_EVENTO AS A
																										WHERE A.SE_ESTADO = 1");
																		while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																		{
																			?>
																				<option value="<?php echo $FilaMobiliario[SE_CODIGO] ?>"><?php echo $FilaMobiliario[SE_NOMBRE] ?></option>
																			<?php
																		}
																	?>
																</select>
															</td>
															<td>
																<input type="number" class="form-control" name="PrecioServicio[]" id="PrecioServicio[]" readonly>
															</td>
															<td>
																<input type="number" class="form-control" name="CantidadServicios[]" id="CantidadServicios[]" onchange="CalcularServicios()">
															</td>
															<td>
																<input type="number" class="form-control" name="DescuentoServicios[]" id="DescuentoServicios[]" onchange="CalcularServicios()">
															</td>
															<td>
																<input type="number" class="form-control" name="SubTotalServicios[]" id="SubTotalServicios[]" readonly>
															</td>
															<td class="eliminarMobiliarioAlquiler">
																<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
															</td>
														</tr>
														<?php
															$QueryServicios = mysqli_query($db, "SELECT *
																									FROM Bodega.SERVICIO_EVENTO_CONTRATADO AS A
																									WHERE A.C_REFERENCIA = '".$FilaDatos[C_REFERENCIA]."'");
															while($FilaServicios = mysqli_fetch_array($QueryServicios))
															{
																?>
																	<tr>
																		<td>
																			<select class="form-control" name="Servicios[]" id="Servicios[]" onchange="ObtenerDatosMobiliario(this)">
																				<?php
																					$QueryMobiliario = mysqli_query($db, "SELECT A.SE_CODIGO, A.SE_NOMBRE
																										FROM Bodega.SERVICIO_EVENTO AS A
																										WHERE A.SE_ESTADO = 1");
																					while($FilaMobiliario = mysqli_fetch_array($QueryMobiliario))
																					{
																						if($FilaServicios[SE_CODIGO] == $FilaMobiliario[SE_CODIGO])
																						{
																							$Texto = 'selected';
																						}
																						else
																						{
																							$Texto = '';
																						}
																						?>
																							<option value="<?php echo $FilaMobiliario[SE_CODIGO] ?>" <?php echo $Texto ?>><?php echo $FilaMobiliario[SE_NOMBRE] ?></option>
																						<?php
																					}
																				?>
																			</select>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="PrecioServicio[]" value="<?php echo $FilaServicios[SEC_PRECIO] ?>" id="PrecioServicio[]" readonly>
																		</td>
																		<td>
																			<input type="number" class="form-control" name="CantidadServicios[]" value="<?php echo $FilaServicios[SEC_CANTIDAD] ?>" id="CantidadServicios[]" onchange="CalcularServicios()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="DescuentoServicios[]" value="<?php echo $FilaServicios[SEC_DESCUENTO] ?>" id="DescuentoServicios[]" onchange="CalcularServicios()">
																		</td>
																		<td>
																			<input type="number" class="form-control" name="SubTotalServicios[]" value="<?php echo $FilaServicios[SEC_SUBTOTAL] ?>" id="SubTotalServicios[]" readonly>
																		</td>
																		<td class="eliminarMobiliarioAlquiler">
																			<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
																		</td>
																	</tr>
																<?php
															}
														?>
													</tbody>
												</table>
												<div class="col-lg-12 text-right">
													<button type="button" class="btn btn-success" id="agregarServicios"><span class="glyphicon glyphicon-plus"></span></button>
												</div>
											</div>
										</div>
									</div>
								</div><!--end #step4 -->
								<div class="tab-pane" id="step10">
									<div class="card-body style-default-bright">
										<div class="row">
										<br>
										<br>
									</div>
									<div class="col-lg-12">
										<div class="form-group">
											<label class="col-sm-3 control-label">Enviar Email a Cliente?</label>
											<div class="col-sm-9">
												<div class="radio radio-styled">
													<label>
														<input type="radio" name="EnvioEmail" value="1" checked="">
														<span>Si</span>
													</label>
												</div>
												<div class="radio radio-styled">
													<label>
														<input type="radio" name="EnvioEmail" value="2">
														<span>No</span>
													</label>
												</div>
											</div><!--end .col -->
										</div>
									</div>
									<div class="col-lg-12 text-center">
										<button type="button" class="btn ink-reaction btn-raised btn-lg btn-primary" onclick="Confirmacion()">ACTUALIZAR</button>
									</div>
								</div><!--end #step4 -->
							</div><!--end .tab-content -->
						</form>
					</div>				
				</div>
			</div>
			<!-- END CONTENT -->

			<?php include("../MenuUsers.html"); ?>

		</div><!--end #base-->
		<!-- END BASE -->

		<div class="modal fade" id="ModalGaleria">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="row" id="Resultados"></div>
					</div>
				</div>
			</div>
		</div>



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
		<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.js"></script>
		<script src="../../../../../js/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<script src="../../../../../js/libs/carousel/dist/carousel.js"></script>
		<script src="../../../../../js/libs/carousel/src/lib/bane/bane.js"></script>
		<script src="../../../../../libs/alertify/js/alertify.js"></script>
		<!-- END JAVASCRIPT -->

		<script>
			function GaleriaRancho(x)
			{
				$.ajax({
						url: 'ObtenerFotografias.php',
						type: 'post',
						data: 'Codigo='+$(x).attr('data-codigo'),
						success: function (data) {
							$('#Resultados').html(data);
							$('#myCarousel').carousel();
							$('#ModalGaleria').modal('show');
						}
					});
			}
			function ObtenerDatos(x)
			{
				var Indice = $(x).closest('tr').index();
				var Precio = document.getElementsByName('Precio[]');

				$.ajax({
						url: 'ObtenerDatosPrecio.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							Precio[Indice].value = data;
							Calcular();
						}
					});
				
			}
			function ObtenerDatosMobiliarioCristaleria(x)
			{
				var Indice = $(x).closest('tr').index();
				var PrecioMobiliario = document.getElementsByName('PrecioMobiliarioCristaleria[]');

				$.ajax({
						url: 'ObtenerDatosPrecioMobiliario.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							PrecioMobiliario[Indice].value = data;
							CalcularMobiliario();
						}
					});
				
			}
			function ObtenerDatosMobiliarioManteleria(x)
			{
				var Indice = $(x).closest('tr').index();
				var PrecioMobiliario = document.getElementsByName('PrecioMobiliarioManteleria[]');

				$.ajax({
						url: 'ObtenerDatosPrecioMobiliario.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							PrecioMobiliario[Indice].value = data;
							CalcularMobiliario();
						}
					});
				
			}
			function ObtenerDatosMobiliarioMobiliario(x)
			{
				var Indice = $(x).closest('tr').index();
				var PrecioMobiliario = document.getElementsByName('PrecioMobiliarioMobiliario[]');

				$.ajax({
						url: 'ObtenerDatosPrecioMobiliario.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							PrecioMobiliario[Indice].value = data;
							CalcularMobiliario();
						}
					});
				
			}
			function ObtenerDatosMobiliarioEquipo(x)
			{
				var Indice = $(x).closest('tr').index();
				var PrecioMobiliario = document.getElementsByName('PrecioMobiliarioEquipo[]');

				$.ajax({
						url: 'ObtenerDatosPrecioMobiliario.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							PrecioMobiliario[Indice].value = data;
							CalcularMobiliario();
						}
					});
				
			}
			function ObtenerDatosMobiliarioAlquiler(x)
			{
				var Indice = $(x).closest('tr').index();
				var PrecioMobiliario = document.getElementsByName('PrecioMobiliarioAlquiler[]');

				$.ajax({
						url: 'ObtenerDatosPrecioMobiliarioAlquiler.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							PrecioMobiliario[Indice].value = data;
							CalcularMobiliarioAlquiler();
						}
					});
				
			}
			function ObtenerDatosServicios(x)
			{
				var Indice = $(x).closest('tr').index();
				var PrecioServicio = document.getElementsByName('PrecioServicio[]');

				$.ajax({
						url: 'ObtenerDatosServicio.php',
						type: 'post',
						data: 'Codigo='+x.value,
						success: function (data) {
							PrecioServicio[Indice].value = data;
							CalcularServicios();
						}
					});
				
			}
			function CalcularMobiliarioCristaleria()
			{
				var Precio   = document.getElementsByName('PrecioMobiliarioCristaleria[]');
				var Cantidad = document.getElementsByName('CantidadMobiliarioCristaleria[]');
				var Descuento = document.getElementsByName('DescuentoMobiliarioCristaleria[]');
				var SubTotal = document.getElementsByName('SubTotalMobiliarioCristaleria[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value)) - parseFloat(Descuento[i].value);

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function CalcularMobiliarioManteleria()
			{
				var Precio   = document.getElementsByName('PrecioMobiliarioManteleria[]');
				var Cantidad = document.getElementsByName('CantidadMobiliarioManteleria[]');
				var Descuento = document.getElementsByName('DescuentoMobiliarioManteleria[]');
				var SubTotal = document.getElementsByName('SubTotalMobiliarioManteleria[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value)) - parseFloat(Descuento[i].value);

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function CalcularMobiliarioMobiliario()
			{
				var Precio   = document.getElementsByName('PrecioMobiliarioMobiliario[]');
				var Cantidad = document.getElementsByName('CantidadMobiliarioMobiliario[]');
				var Descuento = document.getElementsByName('DescuentoMobiliarioMobiliario[]');
				var SubTotal = document.getElementsByName('SubTotalMobiliarioMobiliario[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value)) - parseFloat(Descuento[i].value);

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function CalcularMobiliarioEquipo()
			{
				var Precio   = document.getElementsByName('PrecioMobiliarioEquipo[]');
				var Cantidad = document.getElementsByName('CantidadMobiliarioEquipo[]');
				var Descuento = document.getElementsByName('DescuentoMobiliarioEquipo[]');
				var SubTotal = document.getElementsByName('SubTotalMobiliarioEquipo[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value)) - parseFloat(Descuento[i].value);

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function CalcularServicios()
			{
				var Precio   = document.getElementsByName('PrecioServicio[]');
				var Cantidad = document.getElementsByName('CantidadServicios[]');
				var Descuento = document.getElementsByName('DescuentoServicios[]');
				var SubTotal = document.getElementsByName('SubTotalServicios[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value)) - parseFloat(Descuento[i].value);

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function CalcularMobiliarioAlquiler()
			{
				var Precio   = document.getElementsByName('PrecioMobiliarioAlquiler[]');
				var Cantidad = document.getElementsByName('CantidadMobiliarioAlquiler[]');
				var Descuento = document.getElementsByName('DescuentoMobiliarioAlquiler[]');
				var SubTotal = document.getElementsByName('SubTotalMobiliarioAlquiler[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value)) - parseFloat(Descuento[i].value);

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function Calcular()
			{
				var Precio   = document.getElementsByName('Precio[]');
				var Cantidad = document.getElementsByName('Cantidad[]');
				var Descuento = document.getElementsByName('Descuento[]');
				var SubTotal = document.getElementsByName('SubTotal[]');

				var Total = 0;

				for (var i = 1; i <= Precio.length; i++) 
				{
					if(Precio[i].value == '')
					{
						Precio[i].value = 0;
					}

					if(Cantidad[i].value == '')
					{
						Cantidad[i].value = 0;
					}

					if(Descuento[i].value == '')
					{
						Descuento[i].value = 0;
					}

					Total = (parseFloat(Precio[i].value) * parseFloat(Cantidad[i].value) - parseFloat(Descuento[i].value));

					SubTotal[i].value = parseFloat(Total);
				}
			}
			function ObtenerDatosCUI(x)
			{
				$.ajax({
						url: 'ObtenerDatosCUI.php',
						type: 'post',
						data: 'Codigo='+x,
						success: function (response) {
							if(response != 0)
							{
								var json = $.parseJSON(response);
								$(json).each(function(i,val){
								    $.each(val,function(k,v){
									        if(k == 'nit')    
									        {
									        	$('#NIT').val(v);
									        }

									        if(k == 'nombre')    
									        {
									        	$('#Nombre').val(v);
									        	$('#ParrafoNombre').html(v);
									        }

									        if(k == 'direccion')    
									        {
									        	$('#Direccion').val(v);
									        	$('#ParrafoDireccion').html(v);
									        }

									        if(k == 'celular')    
									        {
									        	$('#Celular').val(v);
									        }

									        if(k == 'telefono')    
									        {
									        	$('#Telefono').val(v);
									        }

									        if(k == 'email')    
									        {
									        	$('#Email').val(v);
									        }

									        if(k == 'codigo')    
									        {
									        	$('#CodigoCliente').val(v);
									        }
									});
								});
							}
						}
					});
			}
			function ObtenerDatosNIT(x)
			{
				$.ajax({
						url: 'ObtenerDatosNIT.php',
						type: 'post',
						data: 'Codigo='+x,
						success: function (response) {
							if(response != 0)
							{
								var json = $.parseJSON(response);
								$(json).each(function(i,val){
								    $.each(val,function(k,v){
									        if(k == 'cui')    
									        {
									        	$('#CUI').val(v);
									        }

									        if(k == 'nombre')    
									        {
									        	$('#Nombre').val(v);
									        	$('#ParrafoNombre').html(v);
									        }

									        if(k == 'direccion')    
									        {
									        	$('#Direccion').val(v);
									        	$('#ParrafoDireccion').html(v);
									        }

									        if(k == 'celular')    
									        {
									        	$('#Celular').val(v);
									        }

									        if(k == 'telefono')    
									        {
									        	$('#Telefono').val(v);
									        }

									        if(k == 'email')    
									        {
									        	$('#Email').val(v);
									        }

									        if(k == 'codigo')    
									        {
									        	$('#CodigoCliente').val(v);
									        }
									});
								});
							}
						}
					});
			}
			function Confirmacion()
			{
				alertify.confirm("¿Está seguro que desea guardar con los datos seleccionados?", function (e) {
				    if (e) {
				        $('#FRMEnviar').submit();
				    }
				});
			}
			function SeleccionarRancho(x)
			{
				var NombreRancho = $(x).attr('data-nombre-rancho');
				$('#RanchoSeleccionado').val(x.value);

				$('#TituloNombreRancho').html("<h3>Rancho Seleccionado: <strong>"+NombreRancho+"</strong></h3>");

			}
			function SeleccionarTipoMontaje(x)
			{
				var NombreMontaje = $(x).attr('data-nombre-montaje');
				$('#MontajeSeleccionado').val(x.value);

				$('#TituloNombreMontaje').html("<h3>Montaje Seleccionado: <strong>"+NombreMontaje+"</strong></h3>");

			}
		</script>

		<script>
	$(function(){
        
        // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
        $("#agregar").on('click', function(){
            $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
        });

        $("#agregarMobiliarioCristaleria").on('click', function(){
            $("#tablaMobiliarioCristaleria tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tablaMobiliarioCristaleria tbody");
        });
        $("#agregarMobiliarioManteleria").on('click', function(){
            $("#tablaMobiliarioManteleria tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tablaMobiliarioManteleria tbody");
        });
        $("#agregarMobiliarioMobiliario").on('click', function(){
            $("#tablaMobiliarioMobiliario tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tablaMobiliarioMobiliario tbody");
        });
        $("#agregarMobiliarioEquipo").on('click', function(){
            $("#tablaMobiliarioEquipo tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tablaMobiliarioEquipo tbody");
        });

        $("#agregarMobiliarioAlquiler").on('click', function(){
            $("#tablaMobiliarioAlquiler tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tablaMobiliarioAlquiler tbody");
        });

        $("#agregarServicios").on('click', function(){
            $("#tablaServicios tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tablaServicios tbody");
        });

        // Evento que selecciona la fila y la elimina
        $(document).on("click",".eliminar",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            Calcular();
        });

        $(document).on("click",".eliminarMobiliarioCristaleria",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            CalcularMobiliarioCristaleria();
        });
        $(document).on("click",".eliminarMobiliarioManteleria",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            CalcularMobiliarioManteleria();
        });
        $(document).on("click",".eliminarMobiliarioMobiliario",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            CalcularMobiliarioMobiliario();
        });
        $(document).on("click",".eliminarMobiliarioEquipo",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            CalcularMobiliarioEquipo();
        });

        $(document).on("click",".eliminarMobiliarioAlquiler",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            CalcularMobiliarioAlquiler();
        });

        $(document).on("click",".eliminarServicios",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
            CalcularServicios();
        });
    });
	</script>

	</body>
	</html>
