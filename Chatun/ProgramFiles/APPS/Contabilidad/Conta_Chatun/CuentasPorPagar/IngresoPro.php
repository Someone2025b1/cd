<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$UserID = $_SESSION["iduser"];
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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Ingreso de Póliza</strong></h4>
							</div>
							<div class="card-body">
							<?php
								// --- INICIO DEL PROCESO DE GUARDADO ---

$UI           = uniqid('tra_');
$UID          = uniqid('trad_');
$Contador     = count($_POST["Cuenta"]);
$Centinela    = true;

$Comprobante = $_POST["Comprobante"];
$Fecha        = $_POST["Fecha"];
$Concepto     = $_POST["Concepto"];
$Periodo      = $_POST["Periodo"];
$TotalPoliza  = 0;
$Tipo         = $_POST["Tipo"];

if($Tipo      == 'FE') {
    $CIFSolicitante = $_POST["CIFSolicitante"];
}

$Cuenta       = $_POST["Cuenta"];
$Cargos       = $_POST["Cargos"];
$Abonos       = $_POST["Abonos"];
$Razon        = $_POST["Razon"];

for($i=1; $i<$Contador; $i++) {
    $TotalPoliza = $TotalPoliza + ($Cargos[$i] ?? 0);
}

// --- INSERCIÓN EN TRANSACCION (Lógica original) ---
if($Tipo == 'NE') {
    // ... (tu lógica para obtener el correlativo se mantiene) ...
    $sql = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_CORRELATIVO, TRA_TOTAL, TRA_TIPO_FACTURA_VENTA, TRA_NO_HOJA, PC_CODIGO, TRA_CONTABILIZO)
                        VALUES('".$UI."', '".$Fecha."', '".$Concepto."', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$UserID ."', 2, 1, '".$Correlativo."', ".$TotalPoliza.", 'NE', '".$Comprobante."', ".$Periodo.", '".$UserID ."')");
} else {
    // ... (tu lógica para obtener el correlativo se mantiene) ...
    $sql = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_CORRELATIVO, TRA_TOTAL, TRA_CIF_COLABORADOR, TRA_TIPO_FACTURA_VENTA, TRA_NO_HOJA, PC_CODIGO, TRA_CONTABILIZO)
                        VALUES('".$UI."', '".$Fecha."', '".$Concepto."', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$UserID ."', 2, 1, '".$Correlativo."', ".$TotalPoliza.", ".$CIFSolicitante.", 'FE', '".$Comprobante."', ".$Periodo.", '".$UserID ."')");
}

if(!$sql) {
    // ... (tu manejo de errores se mantiene) ...
    $Centinela = false;
} else {
    for($i=1; $i<$Contador; $i++) {
        $Cue = $Cuenta[$i];
        $Car = $Cargos[$i];
        $Abo = $Abonos[$i];
        $Raz = $Razon[$i];

        $Xplotado = explode("/", $Cue);
        $NCue = trim($Xplotado[0]);

        $query = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA, TRAD_RAZON)
                    VALUES('".$UID."', '".$UI."', '".$NCue."', ".$Car.", ".$Abo.", '".$Raz."')");

        if(!$query) {
            // ... (tu manejo de errores se mantiene) ...
            $Centinela = false;
            break; // Salir del bucle si hay un error
        }

        // --- INICIO DE LA LÓGICA MEJORADA PARA CUENTAS POR PAGAR ---


    // VERIFICAR SI ES UNA NUEVA DEUDA (ABONO A PROVEEDOR)
    if (substr($NCue, 0, 8) === '2.01.01.' && $Abo > 0) {
        $cp_codigo = uniqid('cp_'); // Generar un ID único para la cuenta por pagar
        
        // Insertar en la tabla maestra de Cuentas por Pagar
        $sql_cpp = "INSERT INTO Contabilidad.CUENTAS_POR_PAGAR 
                        (CP_CODIGO, TRA_CODIGO, CP_ESTADO, N_CODIGO, CP_REALIZO, CP_TOTAL, P_TIPO) 
                    VALUES 
                        (?, ?, 1, ?, ?, ?, 'EXTERNO')";
        
        if ($stmt_cpp = mysqli_prepare($db, $sql_cpp)) {
            mysqli_stmt_bind_param($stmt_cpp, 'sssis', $cp_codigo, $UI, $NCue, $UserID, $Abo);
            mysqli_stmt_execute($stmt_cpp);
            mysqli_stmt_close($stmt_cpp);
        }
    }

    // VERIFICAR SI ES UN PAGO A UNA DEUDA (CARGO A PROVEEDOR)
    if (substr($NCue, 0, 8) === '2.01.01.' && $Car > 0) {
        // 1. Buscar la cuenta por pagar más antigua y abierta para este proveedor
        $sql_buscar_cpp = "SELECT CP_CODIGO, CP_TOTAL, CP_ABONO FROM Contabilidad.CUENTAS_POR_PAGAR 
                           WHERE N_CODIGO = ? AND CP_ESTADO = 1 ORDER BY TRA_CODIGO ASC LIMIT 1";
        
        if ($stmt_buscar = mysqli_prepare($db, $sql_buscar_cpp)) {
            mysqli_stmt_bind_param($stmt_buscar, 's', $NCue);
            mysqli_stmt_execute($stmt_buscar);
            $res_cpp = mysqli_stmt_get_result($stmt_buscar);
            
            if ($fila_cpp = mysqli_fetch_assoc($res_cpp)) {
                $cp_codigo_existente = $fila_cpp['CP_CODIGO'];
                $saldo_anterior = $fila_cpp['CP_TOTAL'] - $fila_cpp['CP_ABONO'];
                $nuevo_abono_total = $fila_cpp['CP_ABONO'] + $Car;
                $saldo_nuevo = $saldo_anterior - $Car;
                $estado_nuevo = ($nuevo_abono_total >= $fila_cpp['CP_TOTAL']) ? 2 : 1; // 2 = Pagado

                // 2. Actualizar la tabla maestra
                $sql_update_cpp = "UPDATE Contabilidad.CUENTAS_POR_PAGAR 
                                   SET CP_ABONO = ?, CP_FECHA_ABONO = CURDATE(), CP_ESTADO = ? 
                                   WHERE CP_CODIGO = ?";
                if ($stmt_update = mysqli_prepare($db, $sql_update_cpp)) {
                    mysqli_stmt_bind_param($stmt_update, 'dis', $nuevo_abono_total, $estado_nuevo, $cp_codigo_existente);
                    mysqli_stmt_execute($stmt_update);
                    mysqli_stmt_close($stmt_update);
                }

                // 3. Insertar el detalle en el Kardex
                $t_codigo_kardex = uniqid('kpx_');
                $sql_kardex = "INSERT INTO Contabilidad.CUENTAS_POR_PAGAR_KARDEX 
                                    (CP_CODIGO, T_CODIGO, KP_CONCEPTO, KP_MONTO, KP_SALDO_A, KP_SALDO_N, KP_FECHA, KCP_USER, KP_TIPO) 
                               VALUES 
                                    (?, ?, ?, ?, ?, ?, CURDATE(), ?, 'EXTERNO')";
                if ($stmt_kardex = mysqli_prepare($db, $sql_kardex)) {
                    mysqli_stmt_bind_param($stmt_kardex, 'sssdddi', $cp_codigo_existente, $t_codigo_kardex, $Concepto, $Car, $saldo_anterior, $saldo_nuevo, $UserID);
                    mysqli_stmt_execute($stmt_kardex);
                    mysqli_stmt_close($stmt_kardex);
                }
            }
            mysqli_stmt_close($stmt_buscar);
        }
    }
    // --- FIN DE LA NUEVA LÓGICA ---
					   // VERIFICAR SI ES UNA NUEVA DEUDA (ABONO A PROVEEDOR)
        if (substr($NCue, 0, 8) === '2.01.01.' && $Abo > 0) {
            $cp_codigo = uniqid('cpp_');
            
            // Obtener datos adicionales del proveedor y la transacción
            $dias_credito = 0;
            $numero_factura = '';
            
            $sql_info = "SELECT prov.P_DIAS_CREDITO, trans.TRA_SERIE, trans.TRA_FACTURA 
                         FROM Contabilidad.PROVEEDOR prov
                         JOIN Contabilidad.TRANSACCION trans ON trans.TRA_CODIGO = ?
                         WHERE prov.P_CODIGO_CUENTA = ? LIMIT 1";
            
            if ($stmt_info = mysqli_prepare($db, $sql_info)) {
                mysqli_stmt_bind_param($stmt_info, 'ss', $UI, $NCue);
                mysqli_stmt_execute($stmt_info);
                $res_info = mysqli_stmt_get_result($stmt_info);
                if ($fila_info = mysqli_fetch_assoc($res_info)) {
                    $dias_credito = (int)$fila_info['P_DIAS_CREDITO'];
                    $numero_factura = trim($fila_info['TRA_SERIE'] . '-' . $fila_info['TRA_FACTURA']);
                }
                mysqli_stmt_close($stmt_info);
            }
            
            // Calcular la fecha de vencimiento
            $fecha_vencimiento = date('Y-m-d', strtotime($Fecha . ' + ' . $dias_credito . ' days'));

            // Insertar en la tabla maestra de Cuentas por Pagar con los nuevos campos
            $sql_cpp = "INSERT INTO Contabilidad.CUENTAS_POR_PAGAR 
                            (CP_CODIGO, TRA_CODIGO, CP_ESTADO, N_CODIGO, CP_REALIZO, CP_TOTAL, P_TIPO, CP_FECHA_VENCIMIENTO, CP_NUMERO_FACTURA) 
                        VALUES 
                            (?, ?, 1, ?, ?, ?, 'EXTERNO', ?, ?)";
            
            if ($stmt_cpp = mysqli_prepare($db, $sql_cpp)) {
                mysqli_stmt_bind_param($stmt_cpp, 'sssisds', $cp_codigo, $UI, $NCue, $UserID, $Abo, $fecha_vencimiento, $numero_factura);
                mysqli_stmt_execute($stmt_cpp);
                mysqli_stmt_close($stmt_cpp);
            }
        }

        // VERIFICAR SI ES UN PAGO A UNA DEUDA (CARGO A PROVEEDOR)
        if (substr($NCue, 0, 8) === '2.01.01.' && $Car > 0) {
            // La lógica para manejar los pagos se mantiene igual que en la respuesta anterior
            $sql_buscar_cpp = "SELECT CP_CODIGO, CP_TOTAL, CP_ABONO FROM Contabilidad.CUENTAS_POR_PAGAR 
                               WHERE N_CODIGO = ? AND CP_ESTADO = 1 ORDER BY CP_FECHA_VENCIMIENTO ASC LIMIT 1";
            
            if ($stmt_buscar = mysqli_prepare($db, $sql_buscar_cpp)) {
                mysqli_stmt_bind_param($stmt_buscar, 's', $NCue);
                mysqli_stmt_execute($stmt_buscar);
                $res_cpp = mysqli_stmt_get_result($stmt_buscar);
                
                if ($fila_cpp = mysqli_fetch_assoc($res_cpp)) {
                    $cp_codigo_existente = $fila_cpp['CP_CODIGO'];
                    $saldo_anterior = $fila_cpp['CP_TOTAL'] - $fila_cpp['CP_ABONO'];
                    $nuevo_abono_total = $fila_cpp['CP_ABONO'] + $Car;
                    $saldo_nuevo = $saldo_anterior - $Car;
                    $estado_nuevo = ($nuevo_abono_total >= $fila_cpp['CP_TOTAL']) ? 2 : 1;

                    $sql_update_cpp = "UPDATE Contabilidad.CUENTAS_POR_PAGAR 
                                       SET CP_ABONO = ?, CP_FECHA_ABONO = CURDATE(), CP_ESTADO = ? 
                                       WHERE CP_CODIGO = ?";
                    if ($stmt_update = mysqli_prepare($db, $sql_update_cpp)) {
                        mysqli_stmt_bind_param($stmt_update, 'dis', $nuevo_abono_total, $estado_nuevo, $cp_codigo_existente);
                        mysqli_stmt_execute($stmt_update);
                        mysqli_stmt_close($stmt_update);
                    }

                    $t_codigo_kardex = uniqid('kpx_');
                    $sql_kardex = "INSERT INTO Contabilidad.CUENTAS_POR_PAGAR_KARDEX 
                                        (CP_CODIGO, T_CODIGO, KP_CONCEPTO, KP_MONTO, KP_SALDO_A, KP_SALDO_N, KP_FECHA, KCP_USER, KP_TIPO) 
                                   VALUES (?, ?, ?, ?, ?, ?, CURDATE(), ?, 'EXTERNO')";
                    if ($stmt_kardex = mysqli_prepare($db, $sql_kardex)) {
                        mysqli_stmt_bind_param($stmt_kardex, 'sssdddi', $cp_codigo_existente, $t_codigo_kardex, $Concepto, $Car, $saldo_anterior, $saldo_nuevo, $UserID);
                        mysqli_stmt_execute($stmt_kardex);
                        mysqli_stmt_close($stmt_kardex);
                    }
                }
                mysqli_stmt_close($stmt_buscar);
            }
        }
        // --- FIN DE LA NUEVA LÓGICA ---
    }		

									if($Centinela == true)
									{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">La póliza se ingresó correctamente.</h2>
											<div class="row">
												<div class="col-lg-6 text-right"><a href="IngresoImpNew.php?Codigo='.$UI.'" target="_blank"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print"></span> Imprimir</a></div>
												<div class="col-lg-6 text-left"><a href="Ingreso.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
										</div>';
									}						
								}

							?>
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
