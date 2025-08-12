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
	//Función para agregar o eliminar filas en la tabla de construcciones
        $(function(){
        
            // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar").on('click', function(){
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
            });

            $("#agregarFE").on('click', function(){
                $("#tableFE tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tableFE tbody");
            });

            $(document).on("click",".eliminarFE",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });
        });
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
			                    RevisarCuentas();
			                });
		            	}
		            }
		        });
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
		function LlenarPartida(x)
		{
			var Cargos  = document.getElementsByName('Cargos[]');
			var Abonos  = document.getElementsByName('Abonos[]');

			var Impuesto = 0.12;
			
			TotalImpuesto = (parseFloat(x.value)/parseFloat(1.12)) * parseFloat(Impuesto);
			TotalDeposito = (parseFloat(x.value)/parseFloat(1.12));
			TotalImpuesto = TotalImpuesto.toFixed(2);
			Abonos[2].value = TotalImpuesto;
			Cargos[1].value = x.value;
			TotalDeposito = TotalDeposito.toFixed(2);
			Abonos[3].value = TotalDeposito;
			
			Calcular();
		}
		function RevisarCuentas()
		{
			var i=0;
			var Centinela = false;
			var Contador = document.getElementsByName('Cargos[]');
			var Cuenta = document.getElementsByName('Cuenta[]');

			for(i=0; i<Contador.length; i++)
			{
				if(Cuenta[i].value == '1.01.04.006/Funcionarios y Empleados')
				{
					$('#DIVFuncionariosEmpleados').show();
					$('#Tipo').val('FE');
					$('#CIFSolicitante').attr("required", "required");
					$('#NombreSolicitante').attr("required", "required");
					
				}
				else
				{
					$('#DIVFuncionariosEmpleados').hide();
					$('#Tipo').val('NE');
					$('#CIFSolicitante').attr("required");
					$('#NombreSolicitante').attr("required");
				}
			}
		}
		function SelColaborador(x)
		{
			window.open('SelColaborador.php','popup','width=750, height=700');
			document.getElementById("AutorizaGasto").focus();
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

	
	function Comprovante(){

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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="Factura_Especial_Pro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Ingreso de Factura Especial</strong></h4>
							</div>
							<?php
								$QueryFacturaEspecial = mysqli_query($db, "SELECT *
																		FROM Bodega.RESOLUCION AS A
																		WHERE A.RES_TIPO = 'FEE'
																		AND A.RES_ESTADO = 1");
								$FilaFacturaEspecial = mysqli_fetch_array($QueryFacturaEspecial);

								$Serie = $FilaFacturaEspecial["RES_SERIE"];
							?>
							<div class="card-body">
								
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group  floating-label">
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d') ?>" required onChange="Comprovante()"/>
											<label for="Fecha">Fecha Factura</label>
										</div>
									</div>
								</div>
								<script>					
									Comprovante();	
										</script>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<select name="Periodo" id="Periodo" class="form-control" onchange="SaberMesPeriodo(this)" required>
												<option value="" disabled selected>Seleccione</option>
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
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
										<label for="Comprobante">Comprobante</label>
											<input class="form-control" type="text" name="Comprobante" id="Comprobante" required/>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group  floating-label">
											<input class="form-control" type="number" step="any" name="CantidadFactura" id="CantidadFactura" onchange="CalcularTotal()" required/>
											<label for="CantidadFactura">Quiero que</label>
										</div>
									</div>
									<script>					
									Comprovante();	
										</script>
									<div class="col-lg-9">
										<div class="radio radio-styled">
											<label>
												<input type="radio" name="TipoCalculo" value="1" onclick="CalcularTotal(this)">
												<span>La cantidad a entregar</span>
											</label>
										</div>
										<div class="radio radio-styled">
											<label>
												<input type="radio" name="TipoCalculo" value="2" onclick="CalcularTotal(this)">
												<span>El total de la factura</span>
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="number" step="any" name="TotalFactura" id="TotalFactura" required readonly value="0.00">
											<label for="TotalFactura">Total Factura</label>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="number" step="any" name="Base" id="Base" required readonly value="0.00">
											<label for="Base">Base</label>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="number" step="any" name="ISR" id="ISR" required readonly value="0.00">
											<label for="ISR">ISR</label>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="number" step="any" name="IVA" id="IVA" required readonly value="0.00">
											<label for="IVA">IVA</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
											<div class="form-group">
												<input class="form-control" type="text" name="Nombre" id="Nombre" placeholder="Click para seleccionar un proveedor" readonly onclick="SelProveedor(this)" required/>
												<label for="Nombre">Proveedor</label>
											</div>
									</div>
									<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" name="CodigoProveedor" id="CodigoProveedor" readonly onclick="SelProveedor(this)" required/>
												<label for="CodigoProveedor">Cuenta Contable</label>
											</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="NIT" id="NIT" readonly required/>
											<label for="NIT">NIT</label>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="DPI" id="DPI" readonly required/>
											<label for="DPI">DPI</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<input class="form-control" type="text" name="Domicilio" id="Domicilio" required/>
											<label for="Domicilio">Domicilio</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Descripcion" id="Descripcion" required></textarea>
											<label for="Descripcion">Descripción</label>
										</div>
									</div>
								</div>	<br>	
								<div class="col-lg-12">
									<h5>Tipo</h5>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="B" name="TipoCompra" required>
										<span>Bienes</span>
									</label>
									<label class="radio-inline radio-styled">
										<input type="radio" value="C" name="TipoCompra" required>
										<span>Combustible</span>
									</label>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="I" name="TipoCompra" required>
										<span>Importación</span>
									</label>
									<label class="radio-inline radio-styled" >
										<input type="radio" value="S" name="TipoCompra" required>
										<span>Servicios</span>
									</label>
								</div><br>
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
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0" ></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0" ></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)" value="1.01.05.001/IVA Crédito Fiscal"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0" ></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0" ></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)" value="2.01.04.006/IVA Retención facturas especiales"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0" ></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0" ></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)" value="2.01.04.007/ISR Retención facturas especiales"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0" ></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0" ></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                            </tr>
                                            <tr>
                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0" ></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0" ></h6></td>
                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                        	<tr>
                                        		<td class="text-right">Total</td>
                                                <td><h6><input type="number" step="any" class="form-control" name="TotalAbonos" id="TotalAbonos" readonly style="width: 100px" value="0.00"  ></h6></td>
                                        	</tr>
                                        </tfoot>
                                    </table>
                                    <div class="col-lg-12" align="left">
                                    <input class="form-control" type="hidden" name="Tipo" id="Tipo" value="NE" required/>
                                        <button type="button" class="btn btn-success btn-xs" id="agregar">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div>
								</div>	
								<div class="row">
									<table class="table table-hover table-condensed" name="tableFE" id="tableFE">
										<caption class="text-center"></caption>
                                        <thead>
                                            <tr>
                                            	<td><strong>Tipo</strong></td>
                                                <td><strong>Cantidad</strong></td>
                                                <td><strong>Descripcion</strong></td>
                                                <td><strong>Precio</strong></td>
                                                <td><strong>Subtotal</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fila-base">
                                            	<td>
                                            		<select name="TipoProducto[]" id="TipoProducto[]" class="form-control">
														<option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
														<option value="S">Servicio</option>
														<option value="B">Bien</option>
													</select>
                                            	</td>
                                                <td><h6><input type="number" step="any" class="form-control" name="CantidadFE[]" id="CantidadFE[]" onchange="CalcularTotalFE()" style="width: 100px" value="0"></h6></td>
                                                <td><h6><input type="text" step="any" class="form-control" name="DescripcionFE[]" id="DescripcionFE[]"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="PrecioUnitarioFE[]" id="PrecioUnitarioFE[]" onchange="CalcularTotalFE()" style="width: 200px" value="0"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="SubTotalFE[]" id="SubTotalFE[]" value="0"></h6></td>
                                                <td class="eliminarFE">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td>
                                            		<select name="TipoProducto[]" id="TipoProducto[]" class="form-control">
														<option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
														<option value="S">Servicio</option>
														<option value="B">Bien</option>
													</select>
                                            	</td>
                                                <td><h6><input type="number" step="any" class="form-control" name="CantidadFE[]" id="CantidadFE[]" onchange="CalcularTotalFE()" style="width: 100px"></h6></td>
                                                <td><h6><input type="text" step="any" class="form-control" name="DescripcionFE[]" id="DescripcionFE[]"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="PrecioUnitarioFE[]" id="PrecioUnitarioFE[]" onchange="CalcularTotalFE()" style="width: 200px"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="SubTotalFE[]" id="SubTotalFE[]"></h6></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                        	<tr>
                                        		<td colspan="3" class="text-right">Total</td>
                                                <td><h6><input type="number" step="any" class="form-control" name="TotalFE" id="TotalFE"  readonly style="width: 100px" value="0.00"></h6></td>
                                        	</tr>
                                        </tfoot>
                                    </table>
                                    <div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-xs" id="agregarFE">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div>
								</div>							
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary" onclick="return IngresarPolizaSi()" id="btnGuardar">Guardar</button>
					</div>
					<br>
					<br>
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

	<script>
		function CalcularTotal()
		{
			if($('#CantidadFactura').val() == '')
			{
				alertify.error('Antes de continuar debe llenar el campo de "Quiero que"');
			}
			else
			{
				if($('input[name=TipoCalculo]:checked').val() == 1)
				{
					var TotalFactura = parseFloat($('#CantidadFactura').val()) * parseFloat(1.17895);
					var TotalBase    = parseFloat(TotalFactura) / 1.12;
					var TotalISR	 = parseFloat(TotalBase) * parseFloat(0.05);
					var TotalIVA     = parseFloat(TotalBase) * parseFloat(0.12);
					
					$('#TotalFactura').val(TotalFactura.toFixed(2));
					$('#Base').val(TotalBase.toFixed(2));
					$('#ISR').val(TotalISR.toFixed(2));
					$('#IVA').val(TotalIVA.toFixed(2));

					var Cargos = document.getElementsByName('Cargos[]');
					var Abonos = document.getElementsByName('Abonos[]');

					Cargos[1].value = TotalBase.toFixed(2);
					Cargos[2].value = TotalIVA.toFixed(2);
					Abonos[3].value = TotalIVA.toFixed(2);
					Abonos[4].value = TotalISR.toFixed(2);
					Abonos[5].value = $('#CantidadFactura').val();
					Calcular();
				}
				else if($('input[name=TipoCalculo]:checked').val() == 2)
				{
					var TotalBase    = parseFloat($('#CantidadFactura').val()) / 1.12;
					var TotalISR	 = parseFloat(TotalBase) * parseFloat(0.05);
					var TotalIVA     = parseFloat(TotalBase) * parseFloat(0.12);

					$('#TotalFactura').val($('#CantidadFactura').val());
					$('#Base').val(TotalBase.toFixed(2));
					$('#ISR').val(TotalISR.toFixed(2));
					$('#IVA').val(TotalIVA.toFixed(2));

					var Cargos = document.getElementsByName('Cargos[]');
					var Abonos = document.getElementsByName('Abonos[]');

					var AbonoProveedor = parseFloat($('#TotalFactura').val()) - parseFloat(TotalIVA) - parseFloat(TotalISR);

					Cargos[1].value = TotalBase.toFixed(2);
					Cargos[2].value = TotalIVA.toFixed(2);
					Abonos[3].value = TotalIVA.toFixed(2);
					Abonos[4].value = TotalISR.toFixed(2);
					Abonos[5].value = AbonoProveedor.toFixed(2);
					Calcular();
				}
				else
				{
					$('#TotalFactura').val(0.00);
					$('#Base').val(0.00);
					$('#ISR').val(0.00);
					$('#IVA').val(0.00);

					var Cargos = document.getElementsByName('Cargos[]');
					var Abonos = document.getElementsByName('Abonos[]');

					Cargos[1].value = 0;
					Cargos[2].value = 0;
					Abonos[3].value = 0;
					Abonos[4].value = 0;
					Abonos[5].value = 0;
					Calcular();
				}
			}
		}
		function SelProveedor(x)
		{
			window.open('SelProveedor.php','popup','width=750, height=700');
			document.getElementById("Domicilio").focus();
		}
		function CalcularTotalFE()
		{
			var CantidadFE       = document.getElementsByName('CantidadFE[]');
			var PrecioUnitarioFE = document.getElementsByName('PrecioUnitarioFE[]');
			var SubTotalFE       = document.getElementsByName('SubTotalFE[]');
			var TotalSuma        = 0;
			var SumaSubtotal     = 0;

			for(var i=0; i<CantidadFE.length; i++)
			{
				SumaSubtotal = parseFloat(CantidadFE[i].value) * parseFloat(PrecioUnitarioFE[i].value);	

				SubTotalFE[i].value = SumaSubtotal;

				TotalSuma = parseFloat(TotalSuma) + parseFloat(SumaSubtotal);
			}

			$('#TotalFE').val(TotalSuma);
		}
	</script>

	</body>
	</html>
