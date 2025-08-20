<?php
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");

// 1. --- CONFIGURACIÓN INICIAL ---
if (isset($db) && $db instanceof mysqli) {
    mysqli_set_charset($db, 'utf8mb4');
}
$Username = isset($_SESSION["iduser"]) ? $_SESSION["iduser"] : 'desconocido';
$FechaHoy = date('d-m-Y H:i:s');

// 2. --- OBTENCIÓN DE PARÁMETROS ---
$Nombre = '';
if (!empty($_GET['CodigoCuenta'])) $Nombre = trim($_GET['CodigoCuenta']);
elseif (!empty($_POST['CodigoCuenta'])) $Nombre = trim($_POST['CodigoCuenta']);
elseif (!empty($_GET['Codigo'])) $Nombre = trim($_GET['Codigo']);

$Codigo = !empty($_GET['NombreCuenta']) ? trim($_GET['NombreCuenta']) : $Nombre;

$defaultStart = date('Y-m-01', strtotime('-3 months'));
$defaultEnd = date('Y-m-d');
$FechaIni = !empty($_GET['FechaInicio']) ? date('Y-m-d', strtotime($_GET['FechaInicio'])) : $defaultStart;
$FechaFin = !empty($_GET['FechaFin']) ? date('Y-m-d', strtotime($_GET['FechaFin'])) : $defaultEnd;

// 3. --- LÓGICA DE CÁLCULO DE ESTADO DE CUENTA ---
$Data = array();
$SaldoFinal = 0.0;
$proveedorInfo = null; // Variable para guardar la info del proveedor

if (empty($Nombre)) {
    $error_msg = 'No se especificó el código de cuenta. Pasa el parámetro en la URL como ?CodigoCuenta=TU_CODIGO';
} else {
    // PASO A: CALCULAR EL SALDO INICIAL (SALDOS ANTERIORES)
    $fecha_corte_anterior = date('Y-m-d', strtotime($FechaIni . " -1 day"));
    $sql_anterior = "SELECT SUM(td.TRAD_CARGO_CONTA) AS CARGOS, SUM(td.TRAD_ABONO_CONTA) AS ABONOS
                     FROM Contabilidad.TRANSACCION_DETALLE td
                     JOIN Contabilidad.TRANSACCION t ON td.TRA_CODIGO = t.TRA_CODIGO
                     WHERE t.TRA_FECHA_TRANS <= ? AND td.N_CODIGO = ? AND t.E_CODIGO = 2 AND t.TRA_ESTADO = 1";

    if ($stmt_anterior = mysqli_prepare($db, $sql_anterior)) {
        mysqli_stmt_bind_param($stmt_anterior, 'ss', $fecha_corte_anterior, $Nombre);
        mysqli_stmt_execute($stmt_anterior);
        $res_anterior = mysqli_stmt_get_result($stmt_anterior);
        $fila_anterior = mysqli_fetch_assoc($res_anterior);

        $cargos_anteriores = floatval($fila_anterior['CARGOS'] ?? 0);
        $abonos_anteriores = floatval($fila_anterior['ABONOS'] ?? 0);

        if (isset($Nombre[0]) && $Nombre[0] === '1') {
            $SaldoFinal = $cargos_anteriores - $abonos_anteriores;
        } else {
            $SaldoFinal = $abonos_anteriores - $cargos_anteriores;
        }

        $Data[] = array(
            'col1' => '-----',
            'colFactura' => '-----',
            'col2' => '-----',
            'col3' => 'Saldos Anteriores al ' . date('d-m-Y', strtotime($FechaIni)),
            'col4' => number_format($cargos_anteriores, 2, '.', ','),
            'col5' => number_format($abonos_anteriores, 2, '.', ','),
            'col6' => number_format($SaldoFinal, 2, '.', ','),
            'is_saldo_anterior' => true
        );
        mysqli_free_result($res_anterior);
        mysqli_stmt_close($stmt_anterior);
    } else {
        $error_msg = 'Error al preparar la consulta de saldos anteriores.';
    }

    // PASO B: OBTENER Y PROCESAR MOVIMIENTOS DEL RANGO
    if (empty($error_msg)) {
        $sql_movimientos = "SELECT td.TRAD_CARGO_CONTA AS CARGOS, td.TRAD_ABONO_CONTA AS ABONOS, tt.TT_NOMBRE, t.TRA_FECHA_TRANS, t.TRA_CONCEPTO, t.TRA_SERIE, t.TRA_FACTURA, t.TRA_CODIGO as transaction_id
                            FROM Contabilidad.TRANSACCION_DETALLE td
                            JOIN Contabilidad.TRANSACCION t ON td.TRA_CODIGO = t.TRA_CODIGO
                            LEFT JOIN Contabilidad.TIPO_TRANSACCION tt ON t.TT_CODIGO = tt.TT_CODIGO
                            WHERE (t.TRA_FECHA_TRANS BETWEEN ? AND ?) AND td.N_CODIGO = ? AND t.E_CODIGO = 2 AND t.TRA_ESTADO = 1
                            ORDER BY t.TRA_FECHA_TRANS, t.TRA_HORA";

        if ($stmt_movimientos = mysqli_prepare($db, $sql_movimientos)) {
            mysqli_stmt_bind_param($stmt_movimientos, 'sss', $FechaIni, $FechaFin, $Nombre);
            mysqli_stmt_execute($stmt_movimientos);
            $res_movimientos = mysqli_stmt_get_result($stmt_movimientos);

            while ($fila = mysqli_fetch_assoc($res_movimientos)) {
                $cargos = floatval($fila['CARGOS']);
                $abonos = floatval($fila['ABONOS']);

                if (isset($Nombre[0]) && $Nombre[0] === '1') {
                    $saldo_movimiento = $cargos - $abonos;
                } else {
                    $saldo_movimiento = $abonos - $cargos;
                }
                $SaldoFinal += $saldo_movimiento;

                $Data[] = array(
                    'col1' => date('d-m-Y', strtotime($fila['TRA_FECHA_TRANS'])),
                    'colFactura' => trim($fila['TRA_SERIE'] . '-' . $fila['TRA_FACTURA']),
                    'col2' => ($fila['TT_NOMBRE'] ?? ''),
                    'col3' => ($fila['TRA_CONCEPTO'] ?? ''),
                    'col4' => number_format($cargos, 2, '.', ','),
                    'col5' => number_format($abonos, 2, '.', ','),
                    'col6' => number_format($SaldoFinal, 2, '.', ','),
                    'transaction_id' => $fila['transaction_id']
                );
            }
            mysqli_free_result($res_movimientos);
            mysqli_stmt_close($stmt_movimientos);
        } else {
            $error_msg = 'Error al preparar la consulta de movimientos.';
        }
    }
}

$totalAPagar = $SaldoFinal;

// --- LÓGICA PARA OBTENER INFO DEL PROVEEDOR SI TIENE DEUDA ---
if (substr($Nombre, 0, 1) === '2' && $totalAPagar > 0) {
    $sql_proveedor = "SELECT P_CODIGO, P_NOMBRE, P_DIAS_CREDITO FROM Contabilidad.PROVEEDOR WHERE P_CODIGO = ? LIMIT 1";
    if ($stmt_prov = mysqli_prepare($db, $sql_proveedor)) {
        mysqli_stmt_bind_param($stmt_prov, 's', $Nombre);
        mysqli_stmt_execute($stmt_prov);
        $res_prov = mysqli_stmt_get_result($stmt_prov);
        if ($fila_prov = mysqli_fetch_assoc($res_prov)) {
            $proveedorInfo = [
                'codigo' => $fila_prov['P_CODIGO'],
                'nombre' => $fila_prov['P_NOMBRE'],
                'dias_credito' => (int)$fila_prov['P_DIAS_CREDITO']
            ];

            // Consulta para obtener la fecha de la deuda más antigua
            $sql_fecha_deuda = "SELECT t.TRA_FECHA_TRANS 
                                FROM Contabilidad.TRANSACCION t
                                JOIN Contabilidad.TRANSACCION_DETALLE td ON t.TRA_CODIGO = td.TRA_CODIGO
                                WHERE td.N_CODIGO = ? AND td.TRAD_ABONO_CONTA > 0 AND t.E_CODIGO = 2 AND t.TRA_ESTADO = 1
                                ORDER BY t.TRA_FECHA_TRANS DESC
                                LIMIT 1";
            if ($stmt_fecha = mysqli_prepare($db, $sql_fecha_deuda)) {
                mysqli_stmt_bind_param($stmt_fecha, 's', $Nombre);
                mysqli_stmt_execute($stmt_fecha);
                $res_fecha = mysqli_stmt_get_result($stmt_fecha);
                $fecha_mas_antigua = null;
                if ($factura = mysqli_fetch_assoc($res_fecha)) {
                    $fecha_mas_antigua = $factura['TRA_FECHA_TRANS'];
                }

                if ($fecha_mas_antigua) {
                    $proveedorInfo['fecha_limite_pago'] = date('d-m-Y', strtotime($fecha_mas_antigua . ' + ' . $proveedorInfo['dias_credito'] . ' days'));
                } else {
                    $proveedorInfo['fecha_limite_pago'] = 'N/A';
                }
                mysqli_stmt_close($stmt_fecha);
            }
        }
        mysqli_stmt_close($stmt_prov);
    }
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estado de Cuenta - <?php echo htmlspecialchars($Codigo, ENT_QUOTES, 'UTF-8'); ?></title>
    <!-- STYLESHEETS ORIGINALES -->
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
    <link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
    <!-- DataTables CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <!-- ESTILOS CSS ORIGINALES PARA CENTRADO Y APARIENCIA -->
    <style>
        #main-wrapper {
            padding-top: 70px;
        }

        .container.centered-card-container {
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            float: none;
        }

        .btn-date-range {
            background: linear-gradient(90deg, #00c6ff, #33b749);
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(51, 183, 73, 0.12);
            display: inline-flex;
            gap: 8px;
            align-items: center;
            cursor: pointer;
        }

        .btn-date-range i {
            font-size: 16px;
        }

        .modal .modal-dialog {
            max-width: 420px;
        }

        .small-muted {
            color: #6c757d;
            font-size: .9rem;
        }

        .saldo-final-display {
            font-size: 1.25rem;
            font-weight: bold;
            color: #007bff;
            background-color: #e9f5ff;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
        }

        .proveedor-info-box {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-left: 5px solid #5bc0de;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .proveedor-info-box h4 {
            margin-top: 0;
            color: #31708f;
        }

        @media (max-width: 768px) {

            .card-header .d-flex,
            .mb-3.d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .card-header .text-end {
                text-align: left !important;
                margin-top: 10px;
            }

            .mb-3.d-flex {
                gap: 10px;
            }

            .saldo-final-display {
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>

<body class="menubar-hoverable header-fixed menubar-pin">
    <?php include("../../../../MenuTop.php") ?>
    <div id="main-wrapper">
        <div class="container my-4 centered-card-container">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h2 class="text-center">Asociación para el Crecimiento Educativo Reg. - ACERCATE</h2>
                            <div class="text-center">Cooperativo y Apoyo Turístico de Esquipulas</div>
                        </div>
                        <div class="text-center mt-2 mt-md-0">
                            <div class="small-muted ">Usuario: <?php echo htmlspecialchars($Username, ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="small-muted">Generado: <?php echo htmlspecialchars($FechaHoy, ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h5>
                            <?php
                            $cuentas_banco = ['1.01.02.001', '1.01.02.002', '1.01.02.003', '1.01.02.004', '1.01.02.005', '1.01.02.006', '1.01.02.007', '1.01.02.008'];
                            if (in_array($Nombre, $cuentas_banco)) {
                                echo 'Libro de Banco | ' . htmlspecialchars($Codigo, ENT_QUOTES, 'UTF-8');
                            } else {
                                echo 'Estado de Cuenta - ' . htmlspecialchars($Codigo, ENT_QUOTES, 'UTF-8');
                            }
                            ?>
                        </h5>
                        <div class="small-muted">Del <?php echo date('d-m-Y', strtotime($FechaIni)); ?> al <?php echo date('d-m-Y', strtotime($FechaFin)); ?></div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($error_msg)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error_msg, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>
                    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex gap-2 flex-wrap" id="table-buttons">
                            <!-- Los botones de DataTables se insertarán aquí -->
                        </div>
                        <div class="d-flex align-items-center gap-3 flex-wrap mt-2 mt-md-0">
                            <span class="saldo-final-display">Saldo Final: Q <?php echo number_format($totalAPagar, 2, '.', ','); ?></span>
                            <button class="btn-date-range" type="button" data-toggle="modal" data-target="#dateRangeModal">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <span id="btnDateLabel">Cambiar Rango</span>
                            </button>
                        </div>
                    </div>

                    <!-- SECCIÓN ESPECIAL PARA PROVEEDORES (SIMPLIFICADA) -->
                    <?php if ($proveedorInfo): ?>
                        <div class="proveedor-info-box">
                            <h4>Resumen de Cuenta por Pagar</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Proveedor:</strong> <?php echo htmlspecialchars($proveedorInfo['nombre']); ?></p>
                                    <p><strong>Código:</strong> <?php echo htmlspecialchars($proveedorInfo['codigo']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Fecha Límite de Pago (próxima):</strong> <span class="text-danger" style="font-weight: bold;"><?php echo htmlspecialchars($proveedorInfo['fecha_limite_pago']); ?></span></p>
                                    <p><strong>Total a Pagar:</strong> <span style="font-weight: bold; font-size: 1.1em;">Q <?php echo number_format(abs($totalAPagar), 2); ?></span></p>
                                    <!-- Formulario oculto que enviará los datos por POST -->
                                    <form action="realizarpago_proveedor.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="proveedor" value="<?php echo htmlspecialchars($proveedorInfo['codigo']); ?>">
                                        <input type="hidden" name="NombreCuenta" value="<?php echo htmlspecialchars($proveedorInfo['nombre']); ?>">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-money"></i> Realizar Pago
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- FIN DE SECCIÓN ESPECIAL -->

                    <div class="table-responsive">
                        <table id="estadoTable" class="table table-striped table-bordered" style="width:100%;">
                            <caption>Historial de transacciones</caption>
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Factura</th>
                                    <th>Tipo</th>
                                    <th>Concepto</th>
                                    <th class="text-end">Cargos</th>
                                    <th class="text-end">Abonos</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($Data as $r): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($r['col1'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($r['colFactura'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($r['col2'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($r['col3'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-end"><?php echo htmlspecialchars($r['col4'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-end"><?php echo htmlspecialchars($r['col5'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-end"><?php echo htmlspecialchars($r['col6'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php include("../MenuUsers.html"); ?>
    </div>
    <!-- Modal para Rango de Fechas -->
    <div class="modal fade" id="dateRangeModal" tabindex="-1" role="dialog" aria-labelledby="dateRangeModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="dateRangeModalLabel">Seleccionar Rango de Fechas</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Fecha de Inicio</label>
                            <input type="text" class="form-control datepicker" name="FechaInicio" value="<?php echo htmlspecialchars($FechaIni); ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Fecha de Fin</label>
                            <input type="text" class="form-control datepicker" name="FechaFin" value="<?php echo htmlspecialchars($FechaFin); ?>" autocomplete="off">
                        </div>
                        <input type="hidden" name="CodigoCuenta" value="<?php echo htmlspecialchars($Nombre, ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="NombreCuenta" value="<?php echo htmlspecialchars($Codigo, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aplicar Filtro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  <!-- SCRIPTS -->
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
    <!-- DataTables y Botones -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#estadoTable').DataTable({
                paging: false,
                searching: true,
                info: false,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: 'Copiar',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        filename: 'estado_cuenta',
                        className: 'btn btn-sm btn-outline-success'
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        filename: 'estado_cuenta',
                        className: 'btn btn-sm btn-outline-success'
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        className: 'btn btn-sm btn-outline-primary'
                    }
                ],
                order: [],
                language: {
                    search: "Buscar en transacciones:",
                    zeroRecords: "No se encontraron registros",
                    emptyTable: "No hay datos disponibles"
                }
            });

            table.buttons().container().appendTo('#table-buttons');

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                language: 'es'
            });

            function updateButtonLabel() {
                var f1 = <?php echo json_encode($FechaIni); ?>;
                var f2 = <?php echo json_encode($FechaFin); ?>;
                if (f1 && f2) {
                    var d1 = f1.split('-');
                    var d2 = f2.split('-');
                    if (d1.length === 3 && d2.length === 3) {
                        $('#btnDateLabel').text(d1[2] + '-' + d1[1] + '-' + d1[0] + ' al ' + d2[2] + '-' + d2[1] + '-' + d2[0]);
                    }
                } else {
                    $('#btnDateLabel').text('Cambiar Rango');
                }
            }
            updateButtonLabel();
        });
    </script>
</body>

</html>