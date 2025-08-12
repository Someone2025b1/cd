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
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
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

	<script>
        function BuscarCuenta(x){
		        //Obtenemos el value del input
		        var service = x.value;
		        var dataString = 'service='+service;
		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscarCuenta.php",
		            data: dataString,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function(data) {
		            	if(data == '')
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
			                });
			                x.blur();
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
				<form class="form" action="KPImp.php" method="POST" role="form" target="_blank">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Alerta de Mínimos de Producto - Bodega Central</strong></h4>
							</div>
							<div class="card-body">
								<ul class="list divider-full-bleed">
								<?php
									$QueryProductos = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE FROM Bodega.PRODUCTO, Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION, Bodega.UNIDAD_MEDIDA
														WHERE TRANSACCION_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
														AND TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
														AND PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
														AND TRANSACCION.B_CODIGO = 1
														GROUP BY TRANSACCION_DETALLE.P_CODIGO
														ORDER BY PRODUCTO.P_NOMBRE";
									$ResultProductos = mysqli_query($db,$QueryProductos);
									while($FilaProductos = mysqli_fetch_array($ResultProductos))
									{
										$CodigoProducto = $FilaProductos["P_CODIGO"];
										$ProductoNombre = $FilaProductos["P_NOMBRE"];
										$Minimo			= $FilaProductos["P_STOCK_MINIMO"];
										$UnidadMedida   = $FilaProductos["UM_NOMBRE"];

										$QueryStock = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_PRODUCTO) AS ENTRADAS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_PRODUCTO) AS SALIDAS
														FROM Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION
														WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
														AND TRANSACCION_DETALLE.P_CODIGO = ".$CodigoProducto."
														AND TRANSACCION.B_CODIGO = 1";

										$ResultStock = mysqli_query($db,$QueryStock);
										while($FilaStock = mysqli_fetch_array($ResultStock))
										{
											$Cargos = $FilaStock["ENTRADAS"];
											$Abonos = $FilaStock["SALIDAS"];

											$Stock = $Cargos - $Abonos;

											if($Stock < $Minimo)
											{
												?>
													<li class="tile">
														<a class="tile-content ink-reaction">
															<div class="tile-icon">
																<i class="fa fa-warning text-danger"></i>
															</div>
															<div class="tile-text">
																<?php echo '<b>Stock Mínimo de '.$ProductoNombre.'</b>, <em>existe '.$Stock.' '.$UnidadMedida.'. El mínimo requerido es de '.$Minimo.' </em>'; ?>
															</div>
														</a>
													</li>
												<?php
											}
										}

									}
								?>
								</ul>
							</div>
						</div>
					</div>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

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

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
