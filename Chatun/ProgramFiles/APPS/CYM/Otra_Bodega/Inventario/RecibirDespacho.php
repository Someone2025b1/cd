<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Puesto = saber_puesto($id_user);
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
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.default.css"/>
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

	<script type="text/javascript">
	$(function(){
        
            // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar").on('click', function(){
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });
        });
	function VerificarStock()
	{
		var Contador         = document.getElementsByName('Stock[]');
		var CantidadDespacho = document.getElementsByName('CantidadDespacho[]');
		var Stock            = document.getElementsByName('Stock[]');

		for(i=0; i<Contador.length; i++)
		{
			if(parseFloat(Stock[i].value) < parseFloat(CantidadDespacho[i].value))
			{
				alertify.error('Stock menor a cantidad de despacho');
				CantidadDespacho[i].value = 0.00;
			}
		}
	}
	function SaberStock(x)
	{
		var BodegaEnvia = $('#BodegaEnvia').val();
		if(BodegaEnvia == null)
		{
			alertify.error('Debe seleccionar la bodega que envía el producto antes de continuar');
		}
		else
		{

			var ValorSelect = x.value;
			var Indice = $(x).closest('tr').index();
			var Stock       = document.getElementsByName('Stock[]');
			$.ajax({
				type: "POST",
				url: "ObtenerStock.php",
				data: 'IDProducto='+ValorSelect+'&Bodega='+BodegaEnvia,
				beforeSend: function()
				{
					$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
				},
				success: function(data) {
					Stock[Indice].value = parseFloat(data);
				}
			});
		}

	}
	function DesplegarResolucion(x)
	{
		if(x.value == '2')
		{
			$('#FacturaAprobada').show();
			$('#FacturaRechazada').hide();
			$('#MotivoRechazo').attr("required");
		}
		else
		{
			$('#FacturaAprobada').hide();
			$('#FacturaRechazada').show();
			$('#MotivoRechazo').attr("required", "required");
		}
	}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php
		$query = "SELECT *
					FROM Bodega.TRANSACCION 
					WHERE TRA_CODIGO = '".$_GET["Codigo"]."' ";
		$result = mysqli_query($db, $query);
		while($row = mysqli_fetch_array($result))
		{
			$FechaTraslado	 = $row["TRA_FECHA_TRANS"];
			$Bodega           = $row["B_NOMBRE"];
			$Observaciones    = $row["TRA_OBSERVACIONES"];
			$Genero           = $row["TRA_USUARIO"];
			$BodegaCodigoEnvia     = $row["B_CODIGO"];
			$BodegaCodigoRecibe     = $row["B_CODIGO_DESTINO_RECIBE"];
		}
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
			<form class="form" role="form" action="RecibirDespachoPro.php" method="POST">
				<input class="form-control" type="hidden" name="Codigo" id="Codigo" value="<?php echo $_GET["Codigo"]; ?>" readonly required/>
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Requisición de Producto</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="hidden" name="CodigoRequisicion" value="<?php echo $_GET['Codigo']; ?>"  id="CodigoRequisicion" readonly/>
											<input class="form-control" maxlength="255" type="text" name="Genero" value="<?php echo saber_nombre_colaborador($Genero); ?>"  id="Genero" readonly/>
											<label for="Genero">Generó Solicitud</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaTraslado	" id="FechaTraslado	" value="<?php echo $FechaTraslado	; ?>" readonly required/>
											<label for="FechaTraslado	">Fecha de Requisicón</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="BodegaNombreEnvia" id="BodegaNombreEnvia" value="<?php echo saber_nombre_bodega($BodegaCodigoEnvia); ?>" required readonly/>
											<input class="form-control" type="hidden" name="BodegaEnvia" id="BodegaEnvia" value="<?php echo $BodegaCodigoEnvia; ?>" required readonly/>
											<label for="BodegaEnvia">Bodega Envía</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="BodegaNombre" id="BodegaNombre" value="<?php echo saber_nombre_bodega($BodegaCodigoRecibe); ?>" required readonly/>
											<input class="form-control" type="hidden" name="BodegaRecibe" id="BodegaRecibe" value="<?php echo $BodegaCodigoRecibe; ?>" required readonly/>
											<label for="BodegaNombre">Bodega Destino</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="text" name="ConceptoTraslado" value="<?php echo $Observaciones; ?>"  id="ConceptoTraslado" readonly/>
											<label for="ConceptoTraslado">Observaciones de Traslado</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="text" name="Concepto"   id="Concepto" required/>
											<label for="Concepto">Observaciones de Recepción</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <td><strong>Producto</strong></td>
                                                <td><strong>Cantidad Enviado</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            	$i = 1;
                                            	$query = "SELECT TRANSACCION_DETALLE.*, PRODUCTO.P_NOMBRE
												FROM Bodega.TRANSACCION_DETALLE, Bodega.PRODUCTO
												WHERE TRANSACCION_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
												AND TRANSACCION_DETALLE.TRA_CODIGO = '".$_GET["Codigo"]."' ";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													$ProductoCodigo = $row["P_CODIGO"];
													$Cantidad = $row["TRAD_ABONO_PRODUCTO"];
													echo '<tr>';
														echo '<td>'.$row["P_NOMBRE"].'</td>';
														echo '<input class="form-control" style="width: 150px" type="hidden"  name="Producto[]" value="'.$ProductoCodigo.'" required readonly/>';
														echo '<td><input class="form-control" style="width: 150px; text-align: right" type="number" step="any" name="CantidadDespacho[]" id="CantidadDespacho[]" value="'.$Cantidad.'"  required readonly/></td>';
													echo '</tr>';
													$i++;
												}

                                            ?>
                                        </tbody>
                                    </table>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Resolución</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12" align="center">
										<label class="radio-inline radio-styled" >
											<input type="radio" value="2" name="Estado" id="Estado" onchange="DesplegarResolucion(this)" required>
											<span>Recibí Conforme</span>
										</label>
										<label class="radio-inline radio-styled">
											<input type="radio" value="3" name="Estado" id="Estado" onchange="DesplegarResolucion(this)" required>
											<span>Rechazar Traslado</span>
										</label>
									</div>
									<div id="FacturaRechazada" style="display: none">
										<div class="col-lg-12 col-lg-">
											<div class="form-group floating-label">
												<input class="form-control" type="text" name="MotivoRechazo" id="MotivoRechazo" />
												<label for="MotivoRechazo">Motivo</label>
											</div>
										</div>
									</div>
								</div>
								<br>
								<br>
								<div class="col-lg-12" align="center">
									<input class="form-control" type="hidden" name="CodigoTransaccion" id="CodigoTransaccion" value="<?php echo $_GET["Codigo"] ?>"/>
									<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" >Guardar</button>
								</div>
							</div>
						</div>
						<br>
						
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php 
		if($Puesto != 4)
		{
			include("../MenuUsers.html");
		}
		else
		{
			include("../MenuAdmin.html");
		}  
		?>

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
