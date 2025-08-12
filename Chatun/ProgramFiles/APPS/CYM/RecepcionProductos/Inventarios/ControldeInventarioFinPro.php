<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
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
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
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

    <script language=javascript type=text/javascript>
		function stopRKey(evt) {
		var evt = (evt) ? evt : ((event) ? event : null);
		var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
		if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
		}
		document.onkeypress = stopRKey; 
	</script>

	<script>
		
		function AgregarLinea()
		{
			$("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
		}
		function EliminarLinea(x)
		{
			var parent = $(x).parents().get(1);
                $(parent).remove();
                CalcularTotal();
		}
		
		function BuscarProducto(x)
        {

				//Obtenemos el value del input
		        var Cantidad = document.getElementsByName('Cantidad[]'); 
		        var service = x.value;
				var llevad ="";
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
			                    x.value = $(this).attr('id')+"/"+$(this).attr('data');

								
			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#suggestions').fadeOut(500);
			                    $('#ModalSugerencias').modal('hide');
			                    CalcularTotal();

								if(Cantidad[Indice].value>0){

									CalcularTotal();
									}
			                });
			            }
		            }
		        });
			}
		
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php");
    
    $CodigoInventario=$_GET["Codigo"];


    $query = "SELECT * FROM Productos.CONTROL_INVENTARIO
	WHERE  CI_CODIGO = '$CodigoInventario'";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{	

		$Punto       =  $row["PV_CODIGO"];
		$FechaInicio = $row["CI_FECHA_INICIO"];
		$HoraInicio        = $row["CI_HORA_INICIO"];


	}
    
    
    ?>

	
	

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
				<section>
					<div class="section-header">
						<ol class="breadcrumb">
							<li class="active"></li>
						</ol>
					</div>
					<div class="section-body contain-lg">
						<!-- BEGIN VALIDATION FORM WIZARD -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
                                <div class="card-head style-primary">
                                    <h4 class="text-center"><strong>Control de Inventario</strong></h4>
                                    </div>
									<div class="card-body ">
										<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
											<form class="form form-validation" role="form" novalidate="novalidate" action="ControldeInventarioFinProPro.php?Codigo=<?php echo $CodigoInventario ?>" method="POST" role="form" id="FormularioPrincipal" >

											<div class="row">
											<input class="form-control" min="0" type="hidden" name="Codigo"  id="Codigo" value="<?php echo $CodigoInventario; ?>" required/>
									<div class="col-lg-6 col-lg-6">
										<div class="form-group">
											<select name="Bodega" id="Bodega" class="form-control" required>
												<?php
                                                $Selected="";
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM CompraVenta.PUNTO_VENTA WHERE PV_CODIGO=$Punto ORDER BY PV_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
                                                    
													echo '<option value="'.$row["PV_CODIGO"].'">'.$row["PV_NOMBRE"].'</option>';
												}

												?>
											</select>
											<label for="Bodega">Punto de Venta</label>
										</div>
									</div>
                            </div>
														<div class="row">
															<table class="table" name="tabla" id="tabla">
																<thead>
																	<tr>
																		<th>Producto</th>
																		<th>Cantidad Contada</th>
																		<th>Cantidad Consignación</th>
																	</tr>
																</thead>
																<tbody>
																	
                                                                <?php
                                                                $query = "SELECT A.*, B.P_NOMBRE
                                                                FROM Productos.CONTROL_INVENTARIO_DETALLE AS A,
                                                                Productos.PRODUCTO AS B
                                                                WHERE A.P_CODIGO=B.P_CODIGO
                                                                AND A.CI_CODIGO = '$CodigoInventario'";
                                                                $result = mysqli_query($db,$query);
                                                                while($row = mysqli_fetch_array($result))
                                                                {	
                                                                    ?>
						                                            <tr>
						                                               
						                                                <td><h6><input type="hidden" class="form-control" name="Producto[]" id="Producto[]"></h6>
						                                                	<h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 800px" value="<?php echo $row["P_CODIGO"].'/'.$row["P_NOMBRE"]; ?>" readonly></h6></td>
                                                                            <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onChange="CalcularTotal()" style="width: 100px" min="0"></h6></td>
                                                                            <td><h6><input type="number" class="form-control" name="Consignacion[]" id="Consignacion[]" onChange="CalcularTotal()" style="width: 100px" min="0"></h6></td>
																			<td class="eliminar">
						                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
						                                                        <span class="glyphicon glyphicon-trash"></span>
						                                                    </button>
						                                                </td>
						                                            </tr>

                                                                    <?php
                                                                }
                                                                ?>
																</tbody>
																
															</table>
															
														</div>

													
													
												</div><!--end .tab-content -->

                                                <div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
					</div>
												
											</form>
										</div><!--end #rootwizard -->
									</div><!--end .card-body -->
								</div><!--end .card -->
							</div><!--end .col -->
						</div><!--end .row -->

					</div><!--end .section-body -->
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>


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
	<script src="../../../../../js/core/demo/DemoFormWizard.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/additional-methods.min.js"></script>
	<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>

	<script src="../../../../../libs/alertify/js/alertify.js"></script>

	<!-- END JAVASCRIPT -->

	

	<!-- Modal Detalle Pasivo Contingente -->
	<div id="ModalResultados" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 80%">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" id="Resultados">
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning btn-md" onclick="RegresarAPrincipal()">
					<span class="glyphicon glyphicon-arrow-left" ></span> Principal
					</button>
					<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign" ></span> Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Detalle Pasivo Contingente -->

	
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
	
	
</body>
</html>
