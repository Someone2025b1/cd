<?php
error_reporting(error_reporting() & ~E_NOTICE);
	$db = mysqli_connect("10.60.58.214", "root","chatun2021");
	if (!$db) {
  	echo "Error con la base de datos, favor de comunicarse al departamento de IDT para verificar...";
 	 exit;
	}
	$db1 = mysqli_connect("10.60.58.214", "root","chatun2021");
//defino tipo de caracteres a manejar.
	mysqli_set_charset($db, 'utf8');
//defino variables globales de las tablas
	$base_asociados = 'info_asociados';
	$base_general = 'info_base';
	$base_bbdd = 'info_bbdd';
	$base_colaboradores = 'info_colaboradores';
?>

<?php
include("../../../../../Script/seguridad.php");
// include("../../../../../Script/conex.php");

include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
 // 1801788
// $Usuar==53711 | $Usuar==22045 | $Usuar==435849
if($Usuar==1801788){
	$Filtro="";
}else{
	$Filtro="AND CC_REALIZO ="."$Usuar";
}
$codigoProveedor = $_GET["codigo"];
 
// Obtener datos del proveedor usando P_CODIGO
$sqlProveedor = "SELECT P_NOMBRE, P_DIRECCION, P_NIT FROM Contabilidad.PROVEEDOR WHERE P_CODIGO = '$codigoProveedor'";
$resProveedor = mysqli_query($db, $sqlProveedor);
$filaProveedor = mysqli_fetch_assoc($resProveedor);
$nombreProveedor = $filaProveedor['P_NOMBRE'];
$direccionProveedor = $filaProveedor['P_DIRECCION'];
$nitProveedor = $filaProveedor['P_NIT'];
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
<script>
        function calcularTotalPago() {
            let abonos = document.getElementsByName('AbonoFac[]');
            let saldos = document.getElementsByName('SaldoFac[]');
            let restas = document.getElementsByName('RestaFac[]');
            let total = 0;
 
            for (let i = 0; i < abonos.length; i++) {
                let saldo = parseFloat(saldos[i].value);
                let abono = parseFloat(abonos[i].value);
 
                if (isNaN(abono) || abono < 0) {
                    abonos[i].value = "0.00";
                    abono = 0;
                }
 
                if (abono > saldo) {
                    alertify.error('El abono no puede ser mayor que el saldo pendiente.');
                    abonos[i].value = saldo.toFixed(2);
                    abono = saldo;
                }
                
                let resta = saldo - abono;
                restas[i].value = resta.toFixed(2);
                
                total += abono;
            }
            document.getElementById('BoldTotal').value = total.toFixed(2);
            document.getElementById('TotalPago').value = total.toFixed(2);
        }
 
        function validarFormulario() {
            let totalPagar = parseFloat(document.getElementById('BoldTotal').value);
            if (totalPagar <= 0) {
                alertify.alert('El monto total a pagar debe ser mayor a cero.');
                return;
            }
            if (document.getElementById('TipoPago').value === '') {
                alertify.alert('Debe seleccionar una forma de pago.');
                return;
            }
            document.getElementById('FormularioPago').submit();
        }
        function TipoPago(x)
		{
			if(x == 1)
			{
				$('#TipoPago').val(1);
				
				$('#FormaPagoTCredito').hide();
				$('#SeleccionarMoneda').show();
				$('#FormaPagoCredito').hide();
				$('#FormaPagoDeposito').hide();
				$('#NombreCredito').hide();
				$('#NumeroAutorizacion').hide();
				$('#FormaPagoMixto').hide();
			}
			else if(x == 2)
			{
				$('#TipoPago').val(2);
				$('#SeleccionarMoneda').hide();
				$('#FormaPagoEfectivo').hide();
				$('#FormaPagoTCredito').show();
				$('#FormaPagoCredito').hide();
				$('#FormaPagoDeposito').hide();
				$('#NombreCredito').hide();
				$('#FormaPagoMixto').hide();
				$('#FormaPagoEfectivoQuetzales').hide();
				$('#FormaPagoEfectivoDolar').hide();
				$('#FormaPagoEfectivoLempiras').hide();
				$('#NumeroAutorizacion').show();
			}
			else if(x == 3)
			{
				$('#TipoPago').val(3);
				$('#SeleccionarMoneda').hide();
				$('#FormaPagoEfectivo').hide();
				$('#FormaPagoTCredito').hide();
				$('#FormaPagoCredito').show();
				$('#FormaPagoDeposito').hide();
				$('#FormaPagoMixto').hide();
				$('#NombreCredito').show();
				$('#FormaPagoEfectivoQuetzales').hide();
				$('#FormaPagoEfectivoDolar').hide();
				$('#FormaPagoEfectivoLempiras').hide();
				$('#NumeroAutorizacion').hide();
			}
			else if(x == 4)
			{
				$('#TipoPago').val(4);
				$('#SeleccionarMoneda').hide();
				$('#FormaPagoEfectivo').hide();
				$('#FormaPagoTCredito').hide();
				$('#FormaPagoCredito').hide();
				$('#FormaPagoDeposito').show();
				$('#FormaPagoMixto').hide();
				$('#NombreCredito').hide();
				$('#FormaPagoEfectivoQuetzales').hide();
				$('#FormaPagoEfectivoDolar').hide();
				$('#FormaPagoEfectivoLempiras').hide();
				$('#NumeroAutorizacion').hide();
			}
			else if(x == 5)
			{
				$('#TipoPago').val(5);
				$('#SeleccionarMoneda').hide();
				$('#FormaPagoEfectivo').hide();
				$('#FormaPagoTCredito').hide();
				$('#FormaPagoCredito').hide();
				$('#FormaPagoDeposito').hide();
				$('#FormaPagoMixto').show();
				$('#NombreCredito').hide();
				$('#FormaPagoEfectivoQuetzales').hide();
				$('#FormaPagoEfectivoDolar').hide();
				$('#FormaPagoEfectivoLempiras').hide();
				$('#NumeroAutorizacion').hide();
			}
		}
    </script>
    </head>
<body class="menubar-hoverable header-fixed menubar-pin" onload="calcularTotalPago()">
 
    <?php include("../../../../MenuTop.php") ?>
 
    <div id="base">
        <div id="content">
            <section>
                <div class="section-body contain-lg">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-head style-primary">
                                    <header>Registrar Pago a Proveedor</header>
                                </div>
                                <div class="card-body">
                                    <form class="form" action="ProcesarPagoProveedor.php" method="POST" id="FormularioPago">
                                        <input type="hidden" name="CodigoProveedor" value="<?php echo $codigoProveedor; ?>">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="NIT" name="NIT" value="<?php echo $nitProveedor; ?>" readonly>
                                                    <label for="NIT">NIT Proveedor</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?php echo $nombreProveedor; ?>" readonly>
                                                    <label for="Nombre">Nombre</label>
                                                </div>
                                            </div>
                                        </div>
 
                                        <div class="row">
                                            <table class="table table-striped" id="tablaFacturas">
                                                <thead>
                                                    <tr>
                                                        <th>Factura Proveedor</th>
                                                        <th>Concepto / Origen</th>
                                                        <th>Monto Total</th>
                                                        <th>Saldo Pendiente</th>
                                                        <th style="width: 15%;">Abono</th>
                                                        <th>Nuevo Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $consultaFacturas = "SELECT CP.CP_CODIGO, T.TRA_CODIGO, T.TRA_FACTURA, T.TRA_CONCEPTO, CP.CP_TOTAL, (CP.CP_TOTAL - CP.CP_ABONO) AS SaldoPendiente
                                                                     FROM Contabilidad.CUENTAS_POR_PAGAR AS CP
                                                                     JOIN Contabilidad.TRANSACCION AS T ON CP.TRA_CODIGO = T.TRA_CODIGO
                                                                     WHERE CP.N_CODIGO = '$codigoProveedor' AND CP.CP_ESTADO = 1 AND (CP.CP_TOTAL - CP.CP_ABONO) > 0";
                                                $resFacturas = mysqli_query($db, $consultaFacturas);
                                                while($fila = mysqli_fetch_assoc($resFacturas)) {
                                                    $saldo = $fila['SaldoPendiente'];
                                                ?>
                                                    <tr>
                                                        <input type="hidden" name="CodigoFac[]" value="<?php echo $fila['CP_CODIGO']; ?>">
                                                        <td><input type="text" class="form-control" name="NumeroFactura[]" value="<?php echo $fila['TRA_FACTURA']; ?>" readonly></td>
                                                        <td><input type="text" class="form-control" name="ConceptoFac[]" value="<?php echo $fila['TRA_CONCEPTO']; ?>" readonly></td>
                                                        <td><input type="number" class="form-control" name="MontoFac[]" value="<?php echo $fila['CP_TOTAL']; ?>" readonly style="text-align: right;"></td>
                                                        <td><input type="number" class="form-control" name="SaldoFac[]" value="<?php echo $saldo; ?>" readonly style="text-align: right;"></td>
                                                        <td><input type="number" class="form-control" name="AbonoFac[]" value="0.00" onchange="calcularTotalPago()" onkeyup="calcularTotalPago()" min="0" step="any" style="text-align: right; background-color: #d1f8ff;"></td>
                                                        <td><input type="number" class="form-control" name="RestaFac[]" value="<?php echo $saldo; ?>" readonly style="text-align: right;"></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" style="text-align: right; font-size: 1.2em;"><b>Total a Pagar Q.</b></td>
                                                        <td><input class="form-control" type="text" id="BoldTotal" name="TotalFacturaFinal" value="0.00" readonly style="font-size: 1.2em; font-weight: bold; text-align: right;"></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
 
                                        <hr>
                                        <h4>Detalle del Pago</h4>
                                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <select id="TipoPago" name="TipoPago" class="form-control">
                                                        <option value="" selected disabled>&nbsp;</option>
                                                        <option value="1">Efectivo</option>
                                                        <option value="2">Cheque</option>
                                                        <option value="4">Transferencia / Depósito</option>
                                                        <option value="5">Tarjeta</option>
                                                    </select>
                                                    <label for="TipoPago">Forma de Pago</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="TotalPago" name="TotalPago" readonly>
                                                    <label for="TotalPago">Monto del Pago</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="NoDocumento" name="NoDocumento">
                                                    <label for="NoDocumento">No. Cheque / Boleta / Autorización</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <select id="CuentaBancaria" name="CuentaBancaria" class="form-control">
                                                        <option value="">&nbsp;</option>
                                                        <?php
                                                        $QueryCB = "SELECT N_CODIGO, N_NOMBRE FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO LIKE '1.01.02.001' AND '1.01.02.999' ORDER BY N_NOMBRE";
                                                        $ResultCB = mysqli_query($db, $QueryCB);
                                                        while($FilaCB = mysqli_fetch_array($ResultCB)) {
                                                            echo '<option value="'.$FilaCB["N_CODIGO"].'">'.$FilaCB["N_NOMBRE"].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="CuentaBancaria">Cuenta de Origen (De dónde sale el dinero)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <textarea name="Observaciones" id="Observaciones" class="form-control" rows="2"></textarea>
                                                    <label for="Observaciones">Observaciones / Concepto del pago</label>
                                                </div>
                                            </div>
                                        </div>
 
                                        <div class="card-actionbar-row">
                                            <button type="button" class="btn btn-success btn-lg ink-reaction" onclick="validarFormulario()">
                                                <i class="fa fa-save"></i> Registrar Pago
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include("../MenuUsers2.html") ?>
    </div>
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
