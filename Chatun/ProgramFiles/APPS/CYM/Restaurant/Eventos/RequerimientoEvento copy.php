	<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");


$cont = 0;
$fecha_inicio = $_POST["FechaInicio"];
$fecha_fin = $_POST["FechaFin"];
$contatemp = 0;

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

	<style type="text/css">
        .fila-base{
            display: none;
        }
		</style>

	<script>
		function AgregarRequerimiento(x)
    	{
    		var ModalAbierto=x.value;
    		$('#ModalRequerimiento-'+x).modal('show');

    	}

		function AgregarLinea()
		{
			$("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
		}

		function EliminarLinea(x)
		{
			var Indice = $(x).closest('tr').index();
			var parent = $(x).parents().get(1);
                $(parent).remove();
                CalcularTotal();
            DelSabor(Indice);
		}
	
		function SolicitarRequerimiento()
    	{
			var Producto = document.getElementsByName('Producto-'+ModalAbierto+'[]');
		    var Cantidad = document.getElementsByName('Cantidad-'+ModalAbierto+'[]'); 
		    var FechaEsperada = $('#FechaEsperada-'+ModalAbierto).val(); 
		    var FechaLimite = $('#FechaLimite-'+ModalAbierto).val(); 
			var CodigoDelTiempo = $('#CodigoDelTiempo-'+ModalAbierto).val(); 
			var CodigoEv = $('#CodigoEv-'+ModalAbierto).val();
    		for(i=1; i<Cantidad.length; i++)
			{
    		$.ajax({
    				url: 'AgregarRequerimiento.php',
    				type: 'post',
    				data: 'Producto='+Producto[i].value+'&Cantidad='+Cantidad[i].value+'&FechaLimite='+FechaLimite+'&FechaEsperada='+FechaEsperada+'&CodigoDelTiempo='+CodigoDelTiempo+'&CodigoEv='+CodigoEv,
    				success: function (data) {
    					if(data == 1)
    					{
    						$('#FormularioRequerimientoProductos-'+ModalAbierto)[0].reset();
							$('#ModalRequerimiento-'+ModalAbierto).modal('hide');
    						alertify.success('Requerimiento Ingresado');
    						
    					}
    					else
    					{
    						alert(data);
    					}
    				}
    			});
			}
    	}

		function BuscarProducto(x)
        {
				//Obtenemos el value del input
		        var Producto = document.getElementsByName('Producto[]');
		        var service = x.value;
		        var dataString = 'service='+service;
		        var Indice = $(x).closest('tr').index();
		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscarProductoNew.php",
		            data: dataString,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function(data) {
		            	if(data == 0)
		            	{
		            		alertify.error('No se encontró ningún registro');
		            		$('#suggestions').html('');
		            	}
		            	else
		            	{
		            		$('#ModalSugerencias').modal('show');
			                //Escribimos las sugerencias que nos manda la consulta
			                $('#suggestions').fadeIn(1000).html(data);
			                //Al hacer click en algua de las sugerencias
			                $('.suggest-element').click(function(){
			                    x.value = $(this).attr('data');
			                    Producto[Indice].value = $(this).attr('id');
			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#suggestions').fadeOut(500);
			                    $('#ModalSugerencias').modal('hide');
			                    
			                    
			                });
			            }
		            }
		        });
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
										<div class="col-lg-6">
											<button class="btn btn-success"  value="<?php echo $CONT."-".$TipoD; ?>" onclick="AgregarRequerimiento(this.value)"> Agregar Requerimineto de Productos <span class="fa fa-shopping-cart" aria-hidden="true"></span></button>
										</div>
										
									</div>
							</div>
											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoD" id="AdultoD" <?php if($AdultoD==1){ echo 'checked';  } ?> onchange="AdultoDes(this)" disabled="disabled">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTOD" <?php if($AdultoD==0){ echo 'style="display: none;"';  }?>>
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoD">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoD" id="CantidadAdultoD" value="<?php echo $CantidadAdultoD?>" readonly />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuAdultoD">Menu Adulto</label>
											<input class="form-control" type="text" name="MenuAdultoD" id="MenuAdultoD" value="<?php echo $MenuAdultoD?>" readonly/>
											
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoD" id="NinoD" <?php if($NinoD==1){ echo 'checked';  } ?> onchange="NinoDes(this)" disabled="disabled">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINOD" <?php if($NinoD==0){ echo 'style="display: none;"';  }?>>
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoD">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoD" id="CantidadNinoD" value="<?php echo $CantidadNinoD?>" readonly/>
											</div>
											<div class="col-lg-4">
                                        <label for="MenuNinoD">Menu Niño</label>
											<input class="form-control" type="text" name="MenuNinoD" id="MenuNinoD" value="<?php echo $MenuNinoD?>" readonly/>
											
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraD">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraD" id="HoraD" value="<?php echo $HoraD?>" readonly/>
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnD">Servir En:</label>
										<select name="ServirEnD" id="ServirEnD" class="form-control" disabled="disabled">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable" <?php if($ServirEnD=="Biodegradable"){echo "selected";}?>>Biodegradable</option>
                                                <option value="Cristaleria" <?php if($ServirEnD=="Cristaleria"){echo "selected";}?>>Cristaleria</option>
                                                <option value="Melamina" <?php if($ServirEnD=="Melamina"){echo "selected";}?>>Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloD">Estilo</label>
											<input class="form-control" type="text" name="EstiloD" id="EstiloD" value="<?php echo $EstiloD?>" readonly/>
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesD">Adicionales</label>
											<input class="form-control" type="text" name="AdicionalesD" id="AdicionalesD" value="<?php echo $AdicionalesD?>" readonly/>
											
											</div>
								
									</div>
											</div>
										</div>
									</div>
								
							</div><!--end .panel -->

							<!-- 
		************************************************************************
		************************************************************************
						MODAL PARA Requeriminetos de Producto
		************************************************************************
		************************************************************************
		-->
		<div class="modal fade" id="ModalRequerimiento-<?php echo $CONT."-".$TipoD; ?>" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" style="width: 50%">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title text-center"><b>Requeriminetos de Producto</b></h3>
					</div>
					<div class="modal-body">
						<form class="form" id="FormularioRequerimientoProductos">
							<div class="row">
							<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Fecha">Fecha Esperada</label>
											<input class="form-control" type="date" name="FechaEsperada" id="FechaEsperada" required/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Fecha">Fecha Limite</label>
											<input class="form-control" type="date" name="FechaLimite" id="FechaLimite" required/>
										</div>
									</div>
									<input type="hidden" name="CodigoDelTiempo" id="CodigoDelTiempo">
									<input type="hidden" name="CodigoEv" id="CodigoEv" value="<?php echo $CodigoEvento ?>">


							<div class="col-lg-6">
															<table class="table" name="tabla" id="tabla">
																<thead>
																	<tr>
																		<th>Cantidad</th>
																		<th>Producto</th>
																		<th>Nombre</th>
																	</tr>
																</thead>
																<tbody>
																	<tr class="fila-base">
																	<td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]"  style="width: 100px" min="0"></h6></td>
																	<td><h6> <input type="number" class="form-control" name="Producto[]" id="Producto[]" readonly disabled="disabled"></h6></td> 
																	<td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onchange="BuscarProducto(this)"></h6></td>
						                                                <td class="eliminar">
						                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
						                                                        <span class="glyphicon glyphicon-trash"></span>
						                                                    </button>
						                                                </td>
						                                            </tr>
																	<?php
																	$sql = "SELECT A.*, B.P_NOMBRE
																	FROM Eventos.EV_PRODUCTOS_AYB AS A, Productos.PRODUCTO AS B
																	WHERE A.P_CODIGO = B.P_CODIGO 
																	AND A.EV_CODIGO_REQUERIMIENTO = '$CodigoDelTiempos'";
																	$result = mysqli_query($db, $sql);
																	while($row = mysqli_fetch_array($result))
																	{
																		$Cantidad1 = $row["EV_CANTIDAD"];
																		$Producto1 = $row["P_CODIGO"];
																		$NombreP   = $row["P_NOMBRE"];
																		
																		?>
																		<tr>
																	<td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]"  style="width: 100px" min="0"></h6></td>
																	<td><h6> <input type="number" class="form-control" name="Producto[]" id="Producto[]" readonly disabled="disabled"></h6></td> 		                                                
						                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onchange="BuscarProducto(this)" ></h6></td>
						                                                <td class="eliminar">
						                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
						                                                        <span class="glyphicon glyphicon-trash"></span>
						                                                    </button>
						                                                </td>
						                                            </tr>
						                                            		  <?php
																	}
																	?>												
																	<tr>
																	<td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]"  style="width: 100px" min="0"></h6></td>
																	<td><h6> <input type="number" class="form-control" name="Producto[]" id="Producto[]" readonly disabled="disabled"></h6></td> 		                                                
						                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onchange="BuscarProducto(this)"></h6></td>
						                                                <td class="eliminar">
						                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
						                                                        <span class="glyphicon glyphicon-trash"></span>
						                                                    </button>
						                                                </td>
						                                            </tr>
																</tbody>
																</table>
															<div class="col-lg-12" align="left">
						                                        <button type="button" class="btn btn-success btn-md" id="agregar" onclick="AgregarLinea()">
						                                            <span class="glyphicon glyphicon-plus"></span> Agregar
						                                        </button>
						                                    </div>
														</div>
								
							</div>
						</form>
	</div>
	<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-success" onclick="SolicitarRequerimiento()">Agregar</button>
					</div>
	</div>
	
	</div>
	
	</div>
			<!-- END CONTENT -->
												<?php 
												$CONT2+=1;	
												$Color2+=1;
												}
											?> 
											<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObservacionesAyB">Observaciones AyB</label>
											<input class="form-control" type="text" name="ObservacionesAyB" id="ObservacionesAyB" value="<?php echo $ObservacionesAyB?>" readonly/>
										</div>
									</div>
									</div>
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
                        }
                            ?>
					</div>
				</div>
			</div>
            </div>
				</div>
			</div>

			

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
