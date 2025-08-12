<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


$QueryPuesto = "SELECT * FROM info_colaboradores.datos_laborales WHERE cif = ".$id_user;
$ResultPuesto = mysqli_query($db, $QueryPuesto);
		while($Filapu = mysqli_fetch_array($ResultPuesto))
		{
			$ID_PUESTO = $Filapu["puesto"];
	}
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
	<script type="text/javascript">
$(document).ready(function() {
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
});
</script>
	<script>
	 //Función para agregar o eliminar filas en la tabla de construcciones
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

			if(TotalCargos.toFixed(2) == TotalAbonos.toFixed(2))
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-danger');
				$('#ResultadoPartida').addClass('alert alert-callout alert-success');
				$('#NombreResultado').html('Partida Completa');
				$('#btnGuardar').prop("disabled", false);
			}
			else
			{
				$('#ResultadoPartida').removeClass('alert alert-callout alert-success');
				$('#ResultadoPartida').addClass('alert alert-callout alert-danger');
				$('#NombreResultado').html('Partida Incompleta');
				$('#btnGuardar').prop("disabled", true);
			}
			$('#btnGuardar').prop("disabled", false);
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


		</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php");
	
	if($ID_PUESTO == 4 || $id_user==53711){

	

	$ano=date("Y");
	$anocierre=$ano-1;
	$FechaInicio=$anocierre.'/01/01';
	$FechaFinal=$anocierre.'/12/31';
	$FechaFinalim = date($FechaFinal);
	$mes=date("m");
	$mesre=$mes-1;
	$TraCod           = uniqid('tra_');
	$TradCod          = uniqid('trad_');
											?>




	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="IngresoCierreProPolizaFinal.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Ingreso de Póliza</strong></h4>
							</div>
							<input class="form-control" type="hidden" name="CodigoTransaccionP" id="CodigoTransaccionP" value="<?php echo $TraCod; ?>" required/>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="text" name="Comprobante" id="Comprobante"  required/>
											<label for="Comprobante">No. de Comprobante</label>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $FechaFinalim; ?>" required/>
											<label for="Fecha">Fecha</label>
										</div>
									</div>	
								</div>
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
									<div class="col-lg-10">
										<div class="form-group">
											<input class="form-control" maxlength="255" type="text" name="Concepto" id="Concepto" required/>
											<label for="Concepto">Concepto</label>
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
												<tr
                                            <?php
											
                                            $Nomenclatura="";
                                            $CargosIngresoTotalAcumulado=0;
                                            $AbonosIngresoTotalAcumulado=0;

                                            $IngresoTotalAcumulado = mysqli_query($db,"SELECT TRANSACCION_DETALLE.TRAD_CARGO_CONTA, TRANSACCION_DETALLE.TRAD_ABONO_CONTA, TRANSACCION_DETALLE.N_CODIGO
                                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFinal."'
												AND TRANSACCION.TRA_CONCEPTO <> 'FACTURA ANULADA' 
												AND TRANSACCION.TRA_CONCEPTO <> 'PÓLIZA ANULADA'
                                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1 ORDER BY N_CODIGO");

                                                while ($ResultIngresoTotalAcumulado = mysqli_fetch_array($IngresoTotalAcumulado)) {
                                                    $partida=$ResultIngresoTotalAcumulado["N_CODIGO"];
                                                    
                                                    if($partida == $Nomenclatura){
                                                        
                                                        $CargosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_CARGO_CONTA"];
                                                        $AbonosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_ABONO_CONTA"];
                                                    }else{
                                                        if($Nomenclatura==""){
                                                           
                                                            $Nomenclatura = $ResultIngresoTotalAcumulado["N_CODIGO"];
                                                            $CargosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_CARGO_CONTA"];
                                                            $AbonosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_ABONO_CONTA"];
                                                        }else{

															$totalabonos=$AbonosIngresoTotalAcumulado-$CargosIngresoTotalAcumulado;
                                                            $query_services = mysqli_query($db, "SELECT N_CODIGO, N_NOMBRE, N_TIPO FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO = '".$Nomenclatura."'");
                                                                while ($row_services = mysqli_fetch_array($query_services)) {
                                                                    $Nome= $row_services['N_CODIGO']."/".$row_services['N_NOMBRE'];
                                                                    $Nome2= $row_services['N_CODIGO'];
                                                                }
                                                            ?>
                                                            <tr>
                                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="<?php echo $Nome; ?>"></h6></td>
                                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="<?php echo $totalabonos; ?>" min="0"></h6></td>
                                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0"></h6></td>
                                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                                                </tr>
                                                            <?php

														$sqlDetalle = mysqli_query($db, "INSERT INTO Bitacoras.POLIZA_CIERRE_DETALLE (TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA)
														VALUES('$TraCod', '$TradCod', '$Nome2', '$totalabonos', 0.00)");

                                                            $Nomenclatura = $ResultIngresoTotalAcumulado["N_CODIGO"];
                                                            $CargosIngresoTotalAcumulado=0;
                                                            $AbonosIngresoTotalAcumulado=0;
                                                            $CargosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_CARGO_CONTA"];
                                                            $AbonosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_ABONO_CONTA"];
                                                        }
                                                    }

                                                
                                                }
												$totalabonos=$AbonosIngresoTotalAcumulado-$CargosIngresoTotalAcumulado;
												$query_services = mysqli_query($db, "SELECT N_CODIGO, N_NOMBRE, N_TIPO FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO = '".$Nomenclatura."'");
                                                                while ($row_services = mysqli_fetch_array($query_services)) {
                                                                    $Nome= $row_services['N_CODIGO']."/".$row_services['N_NOMBRE'];
																	$Nome2= $row_services['N_CODIGO'];
                                                                }
                                                            ?>
                                                            <tr>
                                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="<?php echo $Nome; ?>"></h6></td>
                                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="<?php echo $totalabonos; ?>" min="0"></h6></td>
                                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00"  min="0"></h6></td>
                                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                                                </tr>
                                               

																<?php
																$sqlDetalle = mysqli_query($db, "INSERT INTO Bitacoras.POLIZA_CIERRE_DETALLE (TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA)
																VALUES('$TraCod', '$TradCod', '$Nome2', '$totalabonos', 0.00)");

											#Abonos
                                            $FechaFinal=$FechaFinal;
                                            $Nomenclatura="";
                                            $CargosIngresoTotalAcumulado=0;
                                            $AbonosIngresoTotalAcumulado=0;

                                            $IngresoTotalAcumulado = mysqli_query($db,"SELECT TRANSACCION_DETALLE.TRAD_CARGO_CONTA, TRANSACCION_DETALLE.TRAD_ABONO_CONTA, TRANSACCION_DETALLE.N_CODIGO
                                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '8.99.99.999'
                                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFinal."'
												AND TRANSACCION.TRA_CONCEPTO <> 'FACTURA ANULADA' 
												AND TRANSACCION.TRA_CONCEPTO <> 'PÓLIZA ANULADA'
                                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1 ORDER BY N_CODIGO");

                                                while ($ResultIngresoTotalAcumulado = mysqli_fetch_array($IngresoTotalAcumulado)) {
                                                    $partida=$ResultIngresoTotalAcumulado["N_CODIGO"];
                                                    
                                                    if($partida == $Nomenclatura){
                                                        
                                                        $CargosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_CARGO_CONTA"];
                                                        $AbonosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_ABONO_CONTA"];
                                                    }else{
                                                        if($Nomenclatura==""){
                                                           
                                                            $Nomenclatura = $ResultIngresoTotalAcumulado["N_CODIGO"];
                                                            $CargosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_CARGO_CONTA"];
                                                            $AbonosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_ABONO_CONTA"];
                                                        }else{

															

															$totalcargos=$CargosIngresoTotalAcumulado-$AbonosIngresoTotalAcumulado;
															if ($totalcargos>0){
                                                            $query_services = mysqli_query($db, "SELECT N_CODIGO, N_NOMBRE, N_TIPO FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO = '".$Nomenclatura."'");
                                                                while ($row_services = mysqli_fetch_array($query_services)) {
                                                                    $Nome= $row_services['N_CODIGO']."/".$row_services['N_NOMBRE'];
																	$Nome2= $row_services['N_CODIGO'];
                                                                }
                                                            ?>
                                                            <tr>
                                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="<?php echo $Nome; ?>"></h6></td>
                                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0"></h6></td>
                                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="<?php echo $totalcargos; ?>"  min="0"></h6></td>
                                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                                                </tr>
                                                            <?php
															}
																$sqlDetalle = mysqli_query($db, "INSERT INTO Bitacoras.POLIZA_CIERRE_DETALLE (TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA)
															VALUES('$TraCod', '$TradCod', '$Nome2', 0.00, '$totalcargos')");


                                                            $Nomenclatura = $ResultIngresoTotalAcumulado["N_CODIGO"];
                                                            $CargosIngresoTotalAcumulado=0;
                                                            $AbonosIngresoTotalAcumulado=0;
                                                            $CargosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_CARGO_CONTA"];
                                                            $AbonosIngresoTotalAcumulado += $ResultIngresoTotalAcumulado["TRAD_ABONO_CONTA"];
                                                        }
                                                    }

                                                
                                                }
												$totalcargos=$CargosIngresoTotalAcumulado-$AbonosIngresoTotalAcumulado;
												$query_services = mysqli_query($db, "SELECT N_CODIGO, N_NOMBRE, N_TIPO FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO = '".$Nomenclatura."'");
                                                                while ($row_services = mysqli_fetch_array($query_services)) {
                                                                    $Nome= $row_services['N_CODIGO']."/".$row_services['N_NOMBRE'];
																	$Nome2= $row_services['N_CODIGO'];
                                                                }
                                                            ?>
                                                            <tr>
                                                                <td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="<?php echo $Nome; ?>"></h6></td>
                                                                <td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0"></h6></td>
                                                                <td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="<?php echo $totalcargos; ?>"  min="0"></h6></td>
                                                                <td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
                                                                </tr>
										

																<?php

													$sqlDetalle = mysqli_query($db, "INSERT INTO Bitacoras.POLIZA_CIERRE_DETALLE (TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA)
													VALUES('$TraCod', '$TradCod', '$Nome2', 0.00, '$totalcargos')");

													#Utilidades
													$FechaFinal=$FechaFinal;
													/*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
														$IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
														FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
														WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
														AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
														AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFinal."'
														AND TRANSACCION.E_CODIGO = 2";
													$ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
													$FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
													$CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
													$AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
													$TotalIngresosAcumulado      = $AbonosIngresoTotalAcumulado - $CargosIngresoTotalAcumulado;
													$TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
													/*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

													/*QUERY PARA SABER LOS COSTOS TOTALES ACUMULADOS*/
													$CostoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
														FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
														WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
														AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.00.00.000' AND '5.99.99.999'
														AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFinal."'
														AND TRANSACCION.E_CODIGO = 2";
													$ResultCostoTotalAcumulado = mysqli_query($db, $CostoTotalAcumulado);
													$FilaCostoTotalAcumulado   = mysqli_fetch_array($ResultCostoTotalAcumulado);
													$CargosCostoTotalAcumulado = $FilaCostoTotalAcumulado["CARGOS"];
													$AbonosCostoTotalAcumulado = $FilaCostoTotalAcumulado["ABONOS"];
													$TotalCostoTotalAcumulado      = $CargosCostoTotalAcumulado - $AbonosCostoTotalAcumulado;
													$TotalCostoTotalAcumuladoM     = number_format($TotalCostoTotalAcumulado, 2, '.', ',');
													/*FIN QUERY PARA SABER LOS COSTOS TOTALES ACUMULADOS*/

													/*QUERY PARA SABER LOS GASTOS TOTALES ACUMULADOS*/
													$GastoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
														FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
														WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
														AND ((TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND  '5.02.99.999')
														OR (TRANSACCION_DETALLE.N_CODIGO BETWEEN '6.00.00.000' AND  '9.99.99.999'))
														AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFinal."'
														AND TRANSACCION.E_CODIGO = 2";
													$ResultGastoTotalAcumulado = mysqli_query($db, $GastoTotalAcumulado);
													$FilaGastoTotalAcumulado   = mysqli_fetch_array($ResultGastoTotalAcumulado);
													$CargosGastoTotalAcumulado = $FilaGastoTotalAcumulado["CARGOS"];
													$AbonosGastoTotalAcumulado = $FilaGastoTotalAcumulado["ABONOS"];
													$TotalGastoTotalAcumulado      = $CargosGastoTotalAcumulado - $AbonosGastoTotalAcumulado;
													$TotalGastoTotalAcumuladoM     = number_format($TotalGastoTotalAcumulado, 2, '.', ',');
													/*FIN QUERY PARA SABER LOS GASTOS TOTALES ACUMULADOS*/

													$TotalUtilidadNeta = $TotalIngresosAcumulado - ($TotalCostoTotalAcumulado + $TotalGastoTotalAcumulado);
													$TotalUtilidadNetaM = number_format($TotalUtilidadNeta, 2, '.', ',');
													
													$TotalUtilidadNetaM = $TotalUtilidadNetaM;
													
														
													$query_services = mysqli_query($db, "SELECT N_CODIGO, N_NOMBRE, N_TIPO FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO = '3.02.01.001'");
														while ($row_services = mysqli_fetch_array($query_services)) {
															$Nome= $row_services['N_CODIGO']."/".$row_services['N_NOMBRE'];
															$Nome2= $row_services['N_CODIGO'];
														}

														$sqlDetalle = mysqli_query($db, "INSERT INTO Bitacoras.POLIZA_CIERRE_DETALLE (TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA)
															VALUES('$TraCod', '$TradCod', '$Nome2', 0.00, '$TotalUtilidadNeta')");
													?>
													<tr>
														<td><h6><input type="text" class="form-control" name="Cuenta[]" id="Cuenta[]" style="width: 500px" value="<?php echo $Nome; ?>"></h6></td>
														<td><h6><input type="number" step="any" class="form-control" name="Cargos[]" id="Cargos[]"  onChange="Calcular()" style="width: 100px" value="0.00" min="0"></h6></td>
														<td><h6><input type="number" step="any" class="form-control" name="Abonos[]" id="Abonos[]" onChange="Calcular()" style="width: 100px" value="<?php echo $TotalUtilidadNeta; ?>"  min="0"></h6></td>
														<td><h6><input type="text" class="form-control" name="Razon[]" id="Razon[]"></h6></td>
														</tr>
                                        </tbody>
                                        <tfoot>
                                        	<tr>
                                        		<td class="text-right">Total</td>
                                                <td><h6><input type="number" step="any" class="form-control" name="TotalCargos" id="TotalCargos"  readonly style="width: 100px" value="0.00"></h6></td>
                                                <td><h6><input type="number" step="any" class="form-control" name="TotalAbonos" id="TotalAbonos" readonly style="width: 100px" value="0.00"  ></h6></td>
                                                <td><div style="height: 45px" id="ResultadoPartida" role="alert"><strong id="NombreResultado"></strong></div></td>
                                        	</tr>
                                        </tfoot>
                                    </table>
									<?php

										$sqlDetalle = mysqli_query($db, "INSERT INTO Bitacoras.POLIZA_CIERRE (TRA_CODIGO, TRA_FECHA, TRA_TOTAL)
										VALUES('$TraCod', CURRENT_DATE(), 0.00)");

									?>
                                    <input class="form-control" type="hidden" name="Tipo" id="Tipo" value="NE" required/>
                                    
                                    <div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-xs" id="agregar">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" onclick="return IngresarPolizaSi()" disabled>Guardar</button>
					</div>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php
		}else{
			echo '<div class="col-lg-12 text-center">
				<br><br><br><br><br>
					<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
					<h2 class="text-light">Lo sentimos, usted no tiene los permisos necesarios para acceder a esta función.</h2>
					<h1 class="text-light">SOLO PERSONAL AUTORIZADO DEL AREA FINACIERA.'.$ID_PUESTO.'</h1>
				</div>';

				echo 'Puesto '.$ID_PUESTO;
		}  
		include("../MenuUsers.html"); ?>

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
