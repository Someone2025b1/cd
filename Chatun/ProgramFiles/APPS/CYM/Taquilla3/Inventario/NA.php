<?php
include("../../../../../Script/funciones.php");
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
		var ValorSelect = x.value;
		var Indice = $(x).closest('tr').index();
		var Stock       = document.getElementsByName('Stock[]');
		$.ajax({
			type: "POST",
			url: "ObtenerStock.php",
			data: 'IDProducto='+ValorSelect,
			beforeSend: function()
			{
				$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
			},
			success: function(data) {
				Stock[Indice].value = parseFloat(data);
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
				<form class="form" action="NAPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Nota de Abono</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="FechaSalida" id="FechaSalida" value="<?php echo date('Y-m-d'); ?>" required/>
											<label for="FechaSalida">Fecha de Salida Producto</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select name="Bodega" id="Bodega" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Bodega.BODEGA WHERE B_CODIGO = 5 ORDER BY B_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													echo '<option value="'.$row["B_CODIGO"].'">'.$row["B_NOMBRE"].'</option>';
												}

												?>
											</select>
											<label for="Bodega">Bodega</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="text" name="Concepto"  id="Concepto" />
											<label for="Concepto">Observaciones</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <td><strong>Producto</strong></td>
                                                <td><strong>Stock</strong></td>
                                                <td><strong>Cantidad Despacho</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<tr class="fila-base">
                                                <td><h6><div class="form-group">
											<select name="Producto[]" id="Producto[]" class="form-control" onchange="SaberStock(this)">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Bodega.PRODUCTO WHERE CP_CODIGO = 'TQ' ORDER BY P_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													echo '<option value="'.$row["P_CODIGO"].'">'.$row["P_NOMBRE"].'</option>';
												}

												?>
											</select>
										</div></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Stock[]" id="Stock[]" value="0.00"  min="0" readonly></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="CantidadSalida[]" id="CantidadSalida[]" onChange="VerificarStock()" value="0.00" min="0"></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h6><div class="form-group">
											<select name="Producto[]" id="Producto[]" class="form-control" onchange="SaberStock(this)">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM Bodega.PRODUCTO WHERE CP_CODIGO = 'TQ' ORDER BY P_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													echo '<option value="'.$row["P_CODIGO"].'">'.$row["P_NOMBRE"].'</option>';
												}

												?>
											</select>
										</div></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Stock[]" id="Stock[]" value="0.00"  min="0" readonly></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="CantidadSalida[]" id="CantidadSalida[]" onChange="VerificarStock()" value="0.00" min="0"></h6></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-xs" id="agregar">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div>
								</div>
							</div>
						</div>
						<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Guardar</button>
					</div>
						<br>
						
					</div>
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
