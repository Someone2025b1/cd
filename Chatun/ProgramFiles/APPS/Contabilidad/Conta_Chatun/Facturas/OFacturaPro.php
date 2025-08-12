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
	
	<script>
	$(function(){
        
            // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar").on('click', function(){
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
                Calcular();
            });
        });
	function DesplegarResolucion(x)
	{
		if(x.value == '2')
		{
			$('#FacturaAprobada').show();
			$('#FacturaRechazada').hide();
			$('#Comprobante').attr("required", "required");
			$('#MotivoRechazo').attr("required");

			Comprobante();
		}
		else
		{
			$('#FacturaAprobada').hide();
			$('#FacturaRechazada').show();
			$('#Comprobante').attr("required");
			$('#MotivoRechazo').attr("required", "required");
		}
	}

		function Calcular()
		{
			var TotalCargos = 0;
			var TotalAbonos = 0;
			var Contador = document.getElementsByName('Cargos[]');
			var Cargos = document.getElementsByName('Cargos[]');
			var Abonos = document.getElementsByName('Abonos[]');

			for(i=0; i<Contador.length; i++)
			{
				TotalCargos = parseFloat(TotalCargos) + parseFloat(Cargos[i].value);
				TotalAbonos = parseFloat(TotalAbonos) + parseFloat(Abonos[i].value);
			}
			
			$('#TotalCargos').val(TotalCargos.toFixed(2));
			$('#TotalAbonos').val(TotalAbonos.toFixed(2));

			if(TotalCargos == TotalAbonos)
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-danger');
				$('#ResultadoPartida').addClass('alert alert-callout alert-success');
				$('#NombreResultado').html('Partida Completa');
			}
			else
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-success');
				$('#ResultadoPartida').addClass('alert alert-callout alert-danger');
				$('#NombreResultado').html('Partida Incompleta');
			}
		}
	</script>
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
			            }
		            }
		        });
		}
		function ActualizarPartida()
		{
			document.FormularioPartida.submit();
		}
		function OperarFactura()
		{
			
			var mesperiodo1 = Periodo;
			var mesperiodo2= new Date(mesperiodo1);
			var mesperiodo3 = mesperiodo2.getMonth();

			var mesfecha1 = document.getElementById('Fecha').value;
			var mesfecha2 = new Date(mesfecha1);
			var mesfecha3 = mesfecha2.getMonth();

			var mesfecha = mesfecha3+1;
			var mesperiodo = mesperiodo3+1;


			if(mesfecha!=mesperiodo){
			var respuesta = confirm("La Fecha no coincide con el Periodo Contable, ¿Quieres continuar con el ingreso de la Poliza?");

			if (respuesta== true){

				
				
				document.FormOperar.submit();
				return true;

				}else{
					
					return false;
				}
			}else{

				document.FormOperar.submit();

			}

		}

		function EditHead()
		{ 
			 $("#SerieFactura").attr("readonly", false);
			 $("#Factura").attr("readonly", false); 
			 $("#Fecha").attr("readonly", false);
			 $("#Descripcion").attr("readonly", false); 
			 $("#Establecimiento").attr("readonly", false); 
						
		}
	</script>
	<script>
	function SaberMesPeriodo(x){

		var service = $(x).val();
		var dataString = 'service='+service;
			
			//Le pasamos el valor del input al ajax
			$.ajax({
				type: "POST",
				url: "VerFechaConPeriodo.php",
				data: dataString,
				beforeSend: function()
				{
					$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
				},
				success: function(data) {  
							Periodo = data; 
						}
			});

			}
		

	</script>
	
<script>
	function IngresarPolizaSi(){

		var mesperiodo1 = Periodo;
		var mesperiodo2= new Date(mesperiodo1);
		var mesperiodo3 = mesperiodo2.getMonth();
		
		var mesfecha1 = document.getElementById('Fecha').value;
		var mesfecha2 = new Date(mesfecha1);
		var mesfecha3 = mesfecha2.getMonth();

		var mesfecha = mesfecha3+1;
		var mesperiodo = mesperiodo3+1;

		
		if(mesfecha!=mesperiodo){
		var respuesta = confirm("La Fecha no coincide con el Periodo Contable, ¿Quieres continuar con el ingreso de la Poliza?");

		if (respuesta== true){

			return true;

			}else{
				
				return false;
			}
		}
	}

	function Comprobante(){

var fecha = document.getElementById('Fecha').value;
var Comprobante = document.getElementById('Comprobante').value;

$.ajax({
		url: 'ObtenerNoHojaSin.php',
		type: 'POST',
		data: {fecha:fecha},
		success: function(data)
		{
			if(data)
			{
				$('#Comprobante').val(data);
			}
		}
		})
	


}
		</script>
		
	<style>
	.fila-base{
            display: none;
        }

		
    </style>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" role="form" name="FormularioPartida" method="POST" action="ActualizarPartida.php">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Operar Factura</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
								<?php
									$TotalCargos = 0;
									$TotalAbonos = 0;

									$query = "SELECT A.*, B.* FROM Contabilidad.TRANSACCION AS A, Contabilidad.PROVEEDOR AS B 
												WHERE A.P_CODIGO = B.P_CODIGO 
												AND A.TRA_CODIGO = '".$_GET["Codigo"]."'";
									$result = mysqli_query($db, $query);
									while($row = mysqli_fetch_array($result))
									{	
										$FechaBien          = $row["TRA_FECHA_TRANS"];
										$Fecha              = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
										$Hora               = $row["TRA_HORA"];
										$Concepto           = $row["TRA_CONCEPTO"];
										$FechaHoy           = date('d-m-Y', strtotime($row["TRA_FECHA_HOY"]));
										$Usuario            = $row["TRA_USUARIO"];
										$Nit                =$row["P_NIT"];
										$ProveedorCodigo    =$row["P_CODIGO"];
										$ProveedorNombre    =$row["P_NOMBRE"];
										$Serie              =$row["TRA_SERIE"];
										$Factura            =$row["TRA_FACTURA"];
										$TipoCompra         =$row["TC_CODIGO"];
										$Combustible        = $row["COM_CODIGO"];
										$DestinoCombustible =$row["TRA_DESTINO_COM"];
										$CantidadGalones    =$row["TRA_CANT_GALONES"];
										$PrecioGalones      =$row["TRA_PRECIO_GALONES"];
										$TotalFactura       =$row["TRA_TOTAL"];
										$FormaPago          =$row["FP_CODIGO"];
										$Usuario            =$row["TRA_USUARIO"];
										$Comprobante        =$row["TRA_COMPROBANTE"];
										$Establecimiento    =$row["TRA_ESTABLECIMIENTO"];
										
									}		
									if ($Establecimiento==1) 
									{
										$SelectEst1 = "selected";	
										$SelectEst2 = " ";		
										$SelectEst3 = " ";		
									}
									elseif ($Establecimiento==3) 
									{
										$SelectEst3 = "selected";	
										$SelectEst2 = " ";	
										$SelectEst1 = " ";	

									}	
									else
									{
										$SelectEst2 = "selected";	
										$SelectEst1 = " ";
										$SelectEst3 = " ";		
									}								
								?>

								<form class="form" role="form">
									<div class="row">
										<div class="col-lg-6">
												<div class="form-group">
													<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $ProveedorNombre; ?>" readonly/>
													<label for="Nombre">Proveedor</label>
												</div>
										</div>
										<div class="col-lg-4">
												<div class="form-group">
													<input class="form-control" type="text" name="CodigoProveedor" id="CodigoProveedor" value="<?php echo $ProveedorCodigo; ?>" readonly/>
													<label for="CodigoProveedor">Cuenta Contable</label>
												</div>
										</div>
										<div class="col-lg-2">
												<button onclick="EditHead()" type="button" class="btn btn-warning btn-xs" >
	                                            <span class="glyphicon glyphico$Fechan-edit"></span> Editar
	                                       		</button>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" name="NIT" id="NIT" value="<?php echo $Nit; ?>" readonly/>
												<label for="NIT">NIT</label>
											</div>
										</div>
										<div class="col-lg-3">
										<div class="form-group"> 
											<label for="Establecimiento">Establecimiento</label>
											<select class="form-control"  name="Establecimiento" id="Establecimiento" required readonly>
												<option selected disabled >Seleccione</option>
												<option <?php echo $SelectEst1 ?> value="1">ACERCATE I</option>
												<option <?php echo $SelectEst2 ?> value="2">ACERCATE II</option>
												<option <?php echo $SelectEst3 ?> value="3">21K</option>
											</select>
										</div>
									</div>
									</div>
									<div class="row">
										<div class="col-lg-2">
											<div class="form-group">
												<input class="form-control" type="text" name="SerieFactura" id="SerieFactura" value="<?php echo $Serie; ?>" readonly/>
												<label for="SerieFactura">No. de Serie</label>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" name="Factura" id="Factura" value="<?php echo $Factura; ?>" readonly/>
												<label for="Factura">No. de Factura</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $FechaBien; ?>" readonly/>
												<label for="Fecha">Fecha Factura</label>
											</div>
										</div>
									</div>
									<script>					
									Comprobante();	
										</script>
									<div class="row">
										<div class="col-lg-6 col-lg-6">
											<div class="form-group floating-label">
												<textarea class="form-control" name="Descripcion" id="Descripcion" readonly><?php echo $Concepto; ?></textarea>
												<label for="Descripcion">Descripción</label>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<h5>Tipo</h5>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="B" name="TipoCompra" <?php if($TipoCompra == 'B'){echo 'checked';} ?> disabled>
											<span>Bienes</span>
										</label>
										<label class="radio-inline radio-styled">
											<input type="radio" value="C" name="TipoCompra" <?php if($TipoCompra == 'C'){echo 'checked';} ?> disabled>
											<span>Combustible</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="I" name="TipoCompra" <?php if($TipoCompra == 'I'){echo 'checked';} ?> disabled>
											<span>Importación</span>
										</label>
										<label class="radio-inline radio-styled" >
											<input type="radio" value="S" name="TipoCompra" <?php if($TipoCompra == 'S'){echo 'checked';} ?> disabled>
											<span>Servicios</span>
										</label>
									</div>
									<div id="DivCombustibles" <?php if($TipoCompra == 'C'){echo 'style="display: block"';}else{echo 'style="display: none"';} ?> >
										<div class="row">
											<div class="col-lg-6 col-lg-6">
												<div class="form-group">
													<select name="Combustible" id="Combustible" class="form-control" disabled>
														<?php
		                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
		                                                    $query = "SELECT * FROM Contabilidad.COMBUSTIBLE ORDER BY COM_NOMBRE";
		                                                    $result = mysqli_query($db, $query);
		                                                    while($row = mysqli_fetch_array($result))
		                                                    {
		                                                    	if($row["COM_CODIGO"] == $Combustible)
		                                                    	{
		                                                    		$Selected = 'selected';
		                                                    	}
		                                                    	else
		                                                    	{
		                                                    		$Selected = '';
		                                                    	}
		                                                        echo '<option value="'.$row["COM_CODIGO"].'" '.$Selected.'>'.$row["COM_NOMBRE"].'</option>';
		                                                    }

		                                                ?>
													</select>
													<label for="Combustible">Tipo de Combustible</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6 col-lg-6">
												<div class="form-group">
													<input class="form-control" type="text" name="DestinoCombustibles" id="DestinoCombustibles" value="<?php echo $DestinoCombustible; ?>" readonly/>
													<label for="DestinoCombustibles">Destino</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3 col-lg-9">
												<div class="form-group floating-label">
													<input class="form-control" type="number" name="CantidadGalones" id="CantidadGalones" value="<?php echo $CantidadGalones; ?>" readonly/>
													<label for="CantidadGalones">Cantidad de Galones</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3 col-lg-9">
												<div class="form-group floating-label">
													<input class="form-control" type="number" name="PrecioGalones" id="PrecioGalones" value="<?php echo $PrecioGalones; ?>" readonly/>
													<label for="PrecioGalones">Precio por Galon</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3 col-lg-9">
												<div class="form-group">
													<input class="form-control" type="number" name="TotalCombustible" id="TotalCombustible" value="<?php echo $TotalFactura; ?>" readonly />
													<label for="TotalCombustible">Total</label>
												</div>
											</div>
										</div>
									</div>
									<div class="row"><br></div>
									<div id="DivProductosServicios" <?php if($TipoCompra == 'B'){echo 'style="display: block"';}else{echo 'style="display: none"';} ?>>
										<div class="row">
											<div class="col-lg-3 col-lg-9">
												<div class="form-group floating-label">
													<input class="form-control" type="number" name="TotalFactura" id="TotalFactura" value="<?php echo $TotalFactura; ?>" readonly/>
													<label for="TotalFactura">Total de Factura</label>
												</div>
											</div>
										</div>
									</div>
									</div>
									<div class="row">
										<table class="table table-hover table-condensed" name="tabla" id="tabla">
	                                        <thead>
	                                            <tr>
	                                                <td><strong>Cuenta</strong></td>
	                                                <td><strong>Cargos</strong></td>
	                                                <td><strong>Abonos</strong></td>
	                                                <td><strong>Razón</strong></td>
	                                            </tr>
	                                        </thead>
	                                        <tbody>
	                                            <tr class="fila-base">
	                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)"></h6></td>
	                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0"></h6></td>
	                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0"></h6></td>
	                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
	                                                <td class="eliminar">
	                                                    <button type="button" class="btn btn-danger btn-xs">
	                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
	                                                    </button>
	                                                </td>
	                                            </tr>
	                                            <?php
		                                        	$query = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE 
		                                        				FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA
		                                        				WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
		                                        				AND TRANSACCION_DETALLE.TRA_CODIGO = '".$_GET["Codigo"]."'";
													$result = mysqli_query($db, $query);
													while($row = mysqli_fetch_array($result))
													{
														echo '<tr>';
														echo '<td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)" value="'.$row["N_CODIGO"].'/'.$row["N_NOMBRE"].'"></h6></td>';
		                                                echo '<td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" min="0" value="'.number_format($row["TRAD_CARGO_CONTA"], 2, ".", "").'"></h6></td>';
		                                                echo '<td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px"  min="0" value="'.number_format($row["TRAD_ABONO_CONTA"], 2, ".", "").'"></h6></td>';
		                                                echo '<td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]" value="'.$row["TRAD_RAZON"].'"></h6></td>';
		                                                echo '<td class="eliminar">
		                                                    <button type="button" class="btn btn-danger btn-xs">
		                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
		                                                    </button>
		                                                </td>';
		                                                echo '</tr>';
														$TotalCargos = $TotalCargos + $row["TRAD_CARGO_CONTA"];
														$TotalAbonos = $TotalAbonos + $row["TRAD_ABONO_CONTA"];
													}
		                                        ?>
	                                        </tbody>
	                                        <tfoot>
	                                        	<tr>
	                                        		<td class="text-right">Total</td>
	                                                <td><h6><input type="text" step="any" class="form-control" name="TotalCargos" id="TotalCargos"  readonly style="width: 100px" value="<?php echo number_format($TotalCargos, 2, '.', ','); ?>"></h6></td>
	                                                <td><h6><input type="text" step="any" class="form-control" name="TotalAbonos" id="TotalAbonos" readonly style="width: 100px" value="<?php echo number_format($TotalAbonos, 2, '.', ','); ?>"  ></h6></td>
	                                                <td><div style="height: 45px" id="ResultadoPartida" role="alert"><strong id="NombreResultado"></strong></div></td>
	                                        	</tr>
	                                        </tfoot>
	                                    </table>
	                                    <div class="col-lg-12" align="left">
	                                        <button type="button" class="btn btn-success btn-xs" id="agregar">
	                                            <span class="glyphicon glyphicon-plus"></span> Agregar
	                                        </button>
	                                    </div>
										<input class="form-control" type="hidden" name="CodigoTransaccion" id="CodigoTransaccion" value="<?php echo $_GET["Codigo"] ?>"/>
										<div class="col-lg-12" align="center">
											<button type="button" class="btn ink-reaction btn-raised btn-primary" id="btnGuardarPartida" onclick="ActualizarPartida()">Actualizar Partida</button>
										</div>
									</div>									
								</div>
								</form>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Resolución</strong></h4>
							</div>
							<form class="form" role="form" action="OFacturaProPro.php" method="POST" name="FormOperar">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12" align="center">
										<label class="radio-inline radio-styled" >
											<input type="radio" value="2" name="Estado" id="Estado" onchange="DesplegarResolucion(this)" required>
											<span>Aprobada</span>
										</label>
										<label class="radio-inline radio-styled">
											<input type="radio" value="3" name="Estado" id="Estado" onchange="DesplegarResolucion(this)" required>
											<span>Rechazada</span>
										</label>
									</div>
									<div id="FacturaAprobada" style="display: none">
										<div class="row">
											<div class="col-lg-3 col-lg-9">
												<div class="form-group floating-label">
												<label for="Comprobante">No. Comprobante</label>
													<input class="form-control" type="text" name="Comprobante" id="Comprobante" />
													
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group">
													<select name="Periodo" id="Periodo" class="form-control" onchange="SaberMesPeriodo(this)" required>
														<option value="" selected>SELECCIONE UNA OPCION</option>
														option
														<?php
															$QueryPeriodo = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE EPC_CODIGO = 1";
															$ResultPeriodo = mysqli_query($db, $QueryPeriodo);
															while($FilaP = mysqli_fetch_array($ResultPeriodo))
															{
																echo '<option value="'.$FilaP["PC_CODIGO"].'">'.$FilaP["PC_MES"]."-".$FilaP["PC_ANHO"].'</option>';
														}
														?>
													</select>
													<label for="Periodo">Periodo</label>
												</div>
											</div>	
									</div>
									</div>
									<div id="FacturaRechazada" style="display: none">
										<div class="col-lg-10 col-lg-">
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
									<button type="button" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" onclick="OperarFactura()">Guardar</button>
								</div>
							</div>
							</form>
						</div>
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
