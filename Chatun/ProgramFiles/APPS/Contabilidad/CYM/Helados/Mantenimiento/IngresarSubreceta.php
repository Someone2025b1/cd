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

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->
	<style>
	.fila-base{
            display: none;
        }
    </style>
	
		
<script>
	 
	function ElegirSabor(x)
        {
        	if(x.checked)
        	{
        		$('#DivElegirSabor').show();
        	}
        	else
        	{
        		$('#DivElegirSabor').hide();
        	}
        }

		//Esto es del producto
		function BuscarProducto(x)
        {

				//Obtenemos el value del input
		        
		        
		        var service = x.value;
		        var dataString = 'service='+service;
		        var Indice = $(x).closest('tr').index();
		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscarProducto.php",
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
			                   
			                });
			            }
		            }
		        });
			}

           

		function AgregarLinea()
		{
			$("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
		}
		function EliminarLinea(x)
		{
			var parent = $(x).parents().get(1);
                $(parent).remove();
		}

		function EnviarForm()
	{
		

		var Formulario = $('#FormularioEnviar');
		$(Formulario).attr('action', 'IngresarSubrecetaPro.php');
		$(Formulario).submit();
		
		

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
				<h1 class="text-center"><strong>Agregar Producción de Subreceta</strong><br></h1>
				<br>
				<form class="form" method="POST" role="form" id="FormularioEnviar">
				<button type="submit" disabled class="none" aria-hidden="true"></button>
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Materia prima Usada</strong></h4>
							</div>
							<div class="card-body">


							<div class="row">
                                    <table class="table" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Producto</th>
												<th> </th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fila-base">
                                                <td><h6><input type="number" class="form-control" name="CantidadM[]" id="CantidadM[]" style="width: 100px" min="0" required></h6></td>
                                                <td><h6><input type="text" class="form-control" name="ProductoNombreM[]" id="ProductoNombreM[]" style="width: 800px" onchange="BuscarProducto(this)" required></h6></td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="number" class="form-control" name="CantidadM[]" id="CantidaMd[]" style="width: 100px" min="0" required></h6></td>
                                                <td><h6><input type="text" class="form-control" name="ProductoNombreM[]" id="ProductoNombreM[]" style="width: 600px" onchange="BuscarProducto(this)" required></h6></td>
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
							

						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Producto Producido</strong></h4>
							</div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table" name="tabla2" id="tabla2">
                                        <thead>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Producto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr>
                                                <td><h6><input type="number" class="form-control" name="CantidadP" id="CantidadP" style="width: 100px" min="0" required></h6></td>
                                                <td><h6><input type="text" class="form-control" name="ProductoNombreP" id="ProductoNombreP" style="width: 500px" onchange="BuscarProducto(this)" required></h6></td>
                                                
                                            </tr>
                                        </tbody>
									</table>
                                       
                                          
                                            
                                    </div>
                                </div>
                                </div>
								<div class="col-lg-12" align="center">
					<button type="submit" onclick="EnviarForm()" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Guardar</button>
						</div>
                                </div>
					</div>
					
					<br>
					<br>
					</div>
				</form>
			</div>
		</div>
	
		<!-- END CONTENT -->

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
	<script src="../../../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
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
