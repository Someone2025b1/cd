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

	<style>
	.fila-base{
            display: none;
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
    	$(function(){ 
             // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar1").on('click', function(){
                $("#tabla1 tbody tr:eq(0)").clone().removeClass('fila-base1').appendTo("#tabla1 tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar1",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
                CalcularTotal();
            });

            $("#agregar2").on('click', function(){
                $("#tabla2 tbody tr:eq(0)").clone().removeClass('fila-base2').appendTo("#tabla2 tbody");
            });
 
        });

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


	</script>
<script>
    //Esto es del producto
    function BuscarProducto(x)
        {

				//Obtenemos el value del input
		        var Precio = document.getElementsByName('Precio[]');
		        var Cantidad = document.getElementsByName('Cantidad[]'); 
			    var Tipo = document.getElementsByName('Tipo[]'); 
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
			                    CalcularTotal();
			                });
			            }
		            }
		        });
			}

           
        function CalcularTotal()
		{
			var Cantidad = document.getElementsByName('Cantidad[]');
			var Total = 0;
			var cantn = Cantidad.length;
			for(i = 1; i < Cantidad.length; i++)
			{
				Total = Total + parseFloat(Cantidad[i].value);
			}

			$('#BoldTotal').val(Total.toFixed(2));

		}

		function EnviarForm()
	{
		var Formulario = $('#FormularioEnviar');
		$(Formulario).attr('action', 'FinalizarReconteo.php');
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
				<form class="form" method="POST" role="form" id="FormularioEnviar">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Recepción de Envio</strong></h4>
							</div>
                            <div class="card-body">
                                <div class="row">
							<div class="row">
                                <div>
									<div class="col-lg-12">
										<div class="form-group">
											<?php 
                                                $CodigoEnv=$_GET["Codigo"];

                                                //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                $Consulta = "SELECT A.*
												FROM Productos.EX_PUNTOS_PEQUENOS_DET AS A
												WHERE A.EPDD_PUNTO = 'Kiosco Azados' 
												AND A.EPDD_ESTADO=2
												AND A.EPPD_CODIGO='$CodigoEnv'
												GROUP BY A.EPPD_CODIGO
												ORDER BY A.EPPD_FECHA";
												$Resultado = mysqli_query($db, $Consulta);
												while($row = mysqli_fetch_array($Resultado))
												{
																
													$Envia = "Terrazas";
												
                                                    ?>
                                                    <div class="row">
                                                    <div class="col-lg-12">
                                                    <div class="col-lg-3">
                                                            <div class="form-group">
                                                            <input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $row["EPPD_FECHA"]; ?>"  readonly/>
                                                                <label for="Nombre">Fecha Solicitud</label>
                                                            </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                            <div class="form-group">
                                                            <input class="form-control" type="text" name="Pedido" id="Pedido" value="<?php echo $row["EPPD_CODIGO"]; ?>"  readonly/>
                                                                <label for="Nombre">Reconteo</label>
                                                            </div>
                                                    </div>
                                                    
                                                    
                                                </div>
                                                    </div>
                                                   
                                                <input class="form-control" type="hidden" name="Codigo" id="Codigo" readonly value="<?php echo $CodigoEnv; ?>" />
                                                    <?php
                                                    
                                                }

												?>
										</div>
									</div>
                            </div>
                            </div>
                                </div>

                                </div>
								
                                </div>
                            
                            
                    
                                <div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Productos a Recontar</strong></h4>
							</div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                               
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Consignación</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php
											$query = "SELECT A.*, B.P_NOMBRE
											FROM Productos.EX_PUNTOS_PEQUENOS_DET AS A,
											Productos.PRODUCTO AS B
											WHERE A.P_CODIGO=B.P_CODIGO
											AND A.EPDD_ESTADO = 2
											AND A.EPPD_CODIGO='$CodigoEnv'";
											$result = mysqli_query($db,$query);
											while($row = mysqli_fetch_array($result))
											{	
												?>
												<tr>
												   
													<td><h6><input type="hidden" class="form-control" name="Producto[]" id="Producto[]"></h6>
														<h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 700px" value="<?php echo $row["P_CODIGO"].'/'.$row["P_NOMBRE"]; ?>" readonly></h6></td>
														<td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onChange="CalcularTotal()" style="width: 100px" min="0"></h6></td>
														<td><h6><input type="number" class="form-control" name="Consignacion[]" id="Consignacion[]" onChange="CalcularTotal()" style="width: 100px" min="0"></h6></td>
														
												</tr>

												<?php
											}
											?>
                                        </tbody>
                                       
                                    </table>
                                    
                                </div>
                                </div>
                                </div>
						<br>
						<div class="col-lg-12" align="center">
						<button type="submit" onclick="EnviarForm()" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar">Enviar</button>
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

	</body>
	</html>
