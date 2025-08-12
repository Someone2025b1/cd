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
// Iniciar transacción para asegurar la integridad de los datos
mysqli_begin_transaction($db);
 
try {
    // Datos Generales del Pago
    $codigoProveedor = $_POST['CodigoProveedor'];
    $nombreProveedor = $_POST['Nombre'];
    $tipoPago = $_POST['TipoPago'];
    $totalPagado = (float)$_POST['TotalFacturaFinal'];
    $observaciones = mysqli_real_escape_string($db, $_POST['Observaciones']);
    $noDocumento = mysqli_real_escape_string($db, $_POST['NoDocumento']);
    $cuentaBancaria = $_POST['CuentaBancaria'];
 
    // Datos de las facturas a las que se abona
    $codigosFac = $_POST['CodigoFac'];
    $abonosFac = $_POST['AbonoFac'];
 
    $descripcionPartida = "Pago a proveedor " . $nombreProveedor . ". " . $observaciones;
    
    // 1. Crear el encabezado de la transacción de EGRESO
    $uid = uniqid("tra_");
    $mesActual = date('m');
    $anhoActual = date('Y');
 
    // Lógica para obtener el período y correlativo
    $queryPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = $mesActual AND PC_ANHO = $anhoActual";
    $resPeriodo = mysqli_query($db, $queryPeriodo);
    $filaPeriodo = mysqli_fetch_assoc($resPeriodo);
    $periodo = $filaPeriodo['PC_CODIGO'];
 
    $queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE PC_CODIGO = $periodo";
    $resCorrelativo = mysqli_query($db, $queryCorrelativo);
    $filaCorrelativo = mysqli_fetch_assoc($resCorrelativo);
    $correlativo = ($filaCorrelativo['CORRELATIVO'] ?? 0) + 1;
 
    // Insertar Transacción (El Egreso)
    $sqlTransaccion = "INSERT INTO Contabilidad.TRANSACCION
        (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_TOTAL, PC_CODIGO, TRA_CORRELATIVO)
        VALUES ('$uid', CURRENT_DATE(), '$descripcionPartida', CURRENT_DATE(), CURRENT_TIME(), $id_user, 2, 5, $totalPagado, $periodo, $correlativo)"; // TT_CODIGO=5 (Egreso)
    
    if (!mysqli_query($db, $sqlTransaccion)) {
        throw new Exception("Error al crear encabezado de transacción: " . mysqli_error($db));
    }
 
    // 2. Crear el detalle de la transacción (Partida Contable)
    $proveedorInfo = mysqli_fetch_assoc(mysqli_query($db, "SELECT P_CODIGO_CUENTA FROM Contabilidad.PROVEEDOR WHERE P_CODIGO = '$codigoProveedor'"));
    $cuentaProveedores = $proveedorInfo['P_CODIGO_CUENTA']; // Cuenta contable del proveedor
    
    $sqlDetalleDebe = "INSERT INTO Contabilidad.TRANSACCION_DETALLE (TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA)
                       VALUES ('$uid', uniqid('trad_'), '$cuentaProveedores', $totalPagado, 0.00)";
    if (!mysqli_query($db, $sqlDetalleDebe)) {
        throw new Exception("Error al crear detalle (DEBE): " . mysqli_error($db));
    }
 
    $cuentaOrigen = ($tipoPago == 1) ? '1.01.01.001' : $cuentaBancaria; // Caja o Banco
    $sqlDetalleHaber = "INSERT INTO Contabilidad.TRANSACCION_DETALLE (TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA)
                        VALUES ('$uid', uniqid('trad_'), '$cuentaOrigen', 0.00, $totalPagado)";
    if (!mysqli_query($db, $sqlDetalleHaber)) {
        throw new Exception("Error al crear detalle (HABER): " . mysqli_error($db));
    }
 
    // 3. Actualizar las Cuentas por Pagar y el Kardex
    for ($i = 0; $i < count($codigosFac); $i++) {
        $abono = (float)$abonosFac[$i];
        if ($abono > 0) {
            $codigoFac = $codigosFac[$i];
 
            // Obtener datos actuales de la cuenta por pagar
            $sqlCP = "SELECT (CP_TOTAL - CP_ABONO) as Saldo, P_TIPO FROM Contabilidad.CUENTAS_POR_PAGAR WHERE CP_CODIGO = '$codigoFac'";
            $resCP = mysqli_query($db, $sqlCP);
            $filaCP = mysqli_fetch_assoc($resCP);
            $saldoAnterior = (float)$filaCP['Saldo'];
            $tipoTransaccion = $filaCP['P_TIPO'];
            $saldoNuevo = $saldoAnterior - $abono;
            $estadoFinal = ($saldoNuevo <= 0.01) ? 2 : 1; // 2=Pagada, 1=Pendiente
 
            // Actualizar CUENTAS_POR_PAGAR
            $sqlUpdCP = "UPDATE Contabilidad.CUENTAS_POR_PAGAR
                         SET CP_ABONO = CP_ABONO + $abono, CP_ESTADO = $estadoFinal, CP_FECHA_ABONO = CURRENT_DATE()
                         WHERE CP_CODIGO = '$codigoFac'";
            if (!mysqli_query($db, $sqlUpdCP)) {
                throw new Exception("Error al actualizar cuenta por pagar: " . mysqli_error($db));
            }
 
            // Preparar valores para el KARDEX
            $kp_efectivo = ($tipoPago == 1) ? $abono : 0.00;
            $kp_cheque = ($tipoPago == 2) ? $abono : 0.00;
            $kp_banco = ($tipoPago == 4) ? $abono : 0.00;
            $kp_tarjeta = ($tipoPago == 5) ? $abono : 0.00;
            $kp_no_cheque = ($tipoPago == 2) ? $noDocumento : '';
            $kp_boleta = ($tipoPago == 4) ? $noDocumento : '';
            $kp_autorizacion = ($tipoPago == 5) ? $noDocumento : '';
            $kp_banco_n = ($tipoPago == 4) ? $cuentaBancaria : ''; // Asumiendo que N_NOMBRE es el nombre del banco
 
            // Insertar en KARDEX
            $sqlKardex = "INSERT INTO Contabilidad.CUENTAS_POR_PAGAR_KARDEX
                (CP_CODIGO, T_CODIGO, KP_CONCEPTO, KP_MONTO, KP_SALDO_A, KP_SALDO_N, KP_FECHA, KP_ESTADO, KP_TIPO_PAGO,
                 KP_EFECTIVO, KP_BANCO, KP_BOLETA, KP_BANCO_N, KP_TARJETA, KP_AUTORIZACION, KP_CHEQUE, KP_NO_CHEQUE,
                 KCP_USER, KP_TIPO)
                VALUES ('$codigoFac', '$uid', '$descripcionPartida', $abono, $saldoAnterior, $saldoNuevo, CURRENT_DATE(), $estadoFinal, $tipoPago,
                 $kp_efectivo, $kp_banco, '$kp_boleta', '$kp_banco_n', $kp_tarjeta, '$kp_autorizacion', $kp_cheque, '$kp_no_cheque',
                 $id_user, '$tipoTransaccion')";
            if (!mysqli_query($db, $sqlKardex)) {
                throw new Exception("Error al insertar en kardex: " . mysqli_error($db));
            }
        }
    }
 
    // Si todo salió bien, confirmar la transacción
    mysqli_commit($db);
    $exito = true;
 
} catch (Exception $e) {
    // Si algo falló, revertir todo
    mysqli_rollback($db);
    $exito = false;
    $mensajeError = $e->getMessage();
}
 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Resultado del Pago</title>
    <!-- Tus CSS y JS -->
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">
    <?php include("../../../../MenuTop.php") ?>
    <div id="base">
        <div id="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center" style="padding-top: 50px;">
                        <?php if ($exito): ?>
                            <h1><span class="text-xxxl text-light">¡Éxito! <i class="fa fa-check-circle text-success"></i></span></h1>
                            <h2 class="text-light">El pago se ha registrado correctamente.</h2>
                            <br>
                            <a href="ListaCuentasPorPagar.php" class="btn btn-primary btn-lg">Volver a Cuentas por Pagar</a>
                        <?php else: ?>
                            <h1><span class="text-xxxl text-light">Error <i class="fa fa-times-circle text-danger"></i></span></h1>
                            <h2 class="text-light">No se pudo registrar el pago.</h2>
                            <p class="text-danger" style="font-size: 1.1em;"><?php echo $mensajeError; ?></p>
                            <br>
                            <a href="javascript:history.back()" class="btn btn-warning btn-lg">Intentar de Nuevo</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include("../MenuUsers2.html"); ?>
    </div>
</body>
</html>