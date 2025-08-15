<?php
// ListaCuentasPorPagar_InsertKardex.php
// Opción B: recorrer en PHP e insertar en
// Contabilidad.CUENTAS_POR_PAGAR_KARDEX y Contabilidad.CUENTAS_POR_PAGAR
// ---------------------------------------------------------------

ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");    // Debe proveer $db (mysqli)
include("../../../../../Script/funciones.php");

// Parámetros (POST o GET)
$FechaIni = $_POST['FechaInicio'] ?? $_GET['FechaInicio'] ?? date('Y-m-01');
$FechaFin = $_POST['FechaFin']  ?? $_GET['FechaFin']  ?? date('Y-m-d');

// Normalizar fechas
$FechaIni = date('Y-m-d', strtotime($FechaIni));
$FechaFin = date('Y-m-d', strtotime($FechaFin));

// Opciones de comportamiento
$purge_existing_kardex = true; // si true borra kardex previos del proveedor en el rango antes de insertar
$insert_summary = true;        // si true inserta la fila resumen en CUENTAS_POR_PAGAR
$creator_user = $_SESSION['iduser'] ?? 'system';

// Reporte final
$report = [
    'providers_processed' => 0,
    'kardex_rows_inserted' => 0,
    'summaries_inserted' => 0,
    'errors' => []
];
// seleccionar la base de datos explícitamente para evitar "No database selected"
$dbName = 'Contabilidad';
if (!mysqli_select_db($db, $dbName)) {
    die("Error seleccionando la base de datos '$dbName': " . mysqli_error($db));
}
// ----------------- 1) Crear tabla temporal tx_filtered -----------------
$createTmp = "
CREATE TEMPORARY TABLE IF NOT EXISTS tx_filtered (
  TRA_CODIGO VARCHAR(100) NOT NULL PRIMARY KEY,
  TRA_FECHA_TRANS DATE NOT NULL,
  TRA_HORA TIME NULL
) ENGINE=InnoDB;
";
if (!mysqli_query($db, $createTmp)) {
    die("Error creando tabla temporal tx_filtered: " . mysqli_error($db));
}
// Vaciar por si existiera (misma sesión)
mysqli_query($db, "TRUNCATE TABLE tx_filtered");

// Poblar tx_filtered: transacciones válidas hasta FechaFin
$insertTmp = "
INSERT IGNORE INTO tx_filtered (TRA_CODIGO, TRA_FECHA_TRANS, TRA_HORA)
SELECT TRA_CODIGO, TRA_FECHA_TRANS, TRA_HORA
FROM Contabilidad.TRANSACCION
WHERE E_CODIGO = 2
  AND TRA_ESTADO = 1
  AND TRA_FECHA_TRANS <= ?
";
$stmt = mysqli_prepare($db, $insertTmp);
if (!$stmt) { die("Error preparando insert tmp: " . mysqli_error($db)); }
mysqli_stmt_bind_param($stmt, 's', $FechaFin);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// ----------------- 2) Obtener proveedores con deuda calculada > 0 -----------------
$providersSql = "
SELECT td.N_CODIGO AS codigo, td.TRAD_RAZON AS nombre,
       SUM(td.TRAD_CARGO_CONTA) AS sum_cargos,
       SUM(td.TRAD_ABONO_CONTA) AS sum_abonos
FROM Contabilidad.TRANSACCION_DETALLE td
JOIN tx_filtered tx ON td.TRA_CODIGO = tx.TRA_CODIGO
GROUP BY td.N_CODIGO, td.TRAD_RAZON
HAVING (
    CASE WHEN LEFT(td.N_CODIGO,1) = '1'
      THEN (SUM(td.TRAD_CARGO_CONTA) - SUM(td.TRAD_ABONO_CONTA))
      ELSE (SUM(td.TRAD_ABONO_CONTA) - SUM(td.TRAD_CARGO_CONTA))
    END
) > 0
ORDER BY td.N_CODIGO
";
$resProv = mysqli_query($db, $providersSql);
if ($resProv === false) {
    die("Error obteniendo proveedores: " . mysqli_error($db));
}
$providers = mysqli_fetch_all($resProv, MYSQLI_ASSOC);

// ----------------- 3) Preparar statements de inserción -----------------
// Prepared statement para insertar en KARDEX
$insKardexSql = "
INSERT INTO Contabilidad.CUENTAS_POR_PAGAR_KARDEX
  (KP_FECHA, KP_CONCEPTO, KP_MONTO, N_CODIGO, TRA_CODIGO, KP_SALDO_A, KP_SALDO_N, KP_TIPO, KP_ESTADO_T, KP_SERIE, KP_FACTURA)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
";
$insKardexStmt = mysqli_prepare($db, $insKardexSql);
if (!$insKardexStmt) {
    die("Error preparando insert kardex: " . mysqli_error($db));
}

// Prepared statement para insertar resumen en CUENTAS_POR_PAGAR
$insResumenSql = "
INSERT INTO Contabilidad.CUENTAS_POR_PAGAR
  (CP_CODIGO, TRA_CODIGO, CP_ESTADO, CP_FECHA_PAGO, N_CODIGO, CP_REALIZO, CP_TOTAL, CP_ABONO, CP_FECHA_ABONO, P_TIPO)
VALUES (?, NULL, 1, NULL, ?, ?, ?, ?, NULL, ?)
";
$insResumenStmt = mysqli_prepare($db, $insResumenSql);
if (!$insResumenStmt) {
    die("Error preparando insert resumen: " . mysqli_error($db));
}

// ----------------- 4) Procesar cada proveedor -----------------
foreach ($providers as $prov) {
    $codigoProv = $prov['codigo'];
    $nombreProv = $prov['nombre'];

    // comenzar transacción por proveedor
    mysqli_begin_transaction($db);

    try {
        // -- opcional: borrar kardex existentes del proveedor en el rango (para evitar duplicados)
        if ($purge_existing_kardex) {
            $delK = "DELETE FROM Contabilidad.CUENTAS_POR_PAGAR_KARDEX WHERE N_CODIGO = ? AND KP_FECHA BETWEEN ? AND ?";
            $dstmt = mysqli_prepare($db, $delK);
            if ($dstmt) {
                mysqli_stmt_bind_param($dstmt, 'sss', $codigoProv, $FechaIni, $FechaFin);
                mysqli_stmt_execute($dstmt);
                mysqli_stmt_close($dstmt);
            } else {
                // no fatal, solo reporte
                $report['errors'][] = "No se pudo preparar DELETE kardex para $codigoProv: " . mysqli_error($db);
            }
        }

        // -- calcular saldo anterior (movimientos < FechaIni) aplicando tu regla
        $prevSql = "
        SELECT IFNULL(SUM(TRAD_CARGO_CONTA),0) AS pc, IFNULL(SUM(TRAD_ABONO_CONTA),0) AS pa
        FROM Contabilidad.TRANSACCION_DETALLE td
        JOIN Contabilidad.TRANSACCION t ON td.TRA_CODIGO = t.TRA_CODIGO
        WHERE td.N_CODIGO = ? AND t.TRA_FECHA_TRANS < ? AND t.E_CODIGO = 2 AND t.TRA_ESTADO = 1
        ";
        $pst = mysqli_prepare($db, $prevSql);
        if (!$pst) throw new Exception("Error preparando prevSql: " . mysqli_error($db));
        mysqli_stmt_bind_param($pst, 'ss', $codigoProv, $FechaIni);
        mysqli_stmt_execute($pst);
        mysqli_stmt_bind_result($pst, $prevCargos, $prevAbonos);
        mysqli_stmt_fetch($pst);
        mysqli_stmt_close($pst);
        $prevCargos = (float)$prevCargos;
        $prevAbonos = (float)$prevAbonos;
        if (isset($codigoProv[0]) && $codigoProv[0] == '1') {
            $saldo = $prevCargos - $prevAbonos;
        } else {
            $saldo = $prevAbonos - $prevCargos;
        }

        // -- obtener movimientos del periodo ordenados
        $movSql = "
        SELECT td.TRAD_CARGO_CONTA AS CARGOS, td.TRAD_ABONO_CONTA AS ABONOS,
               t.TT_CODIGO, t.TRA_FECHA_TRANS, t.TRA_CONCEPTO, t.TRA_SERIE, t.TRA_FACTURA,
               td.TRAD_CORRELATIVO, td.TRA_CODIGO
        FROM Contabilidad.TRANSACCION_DETALLE td
        JOIN tx_filtered tx ON td.TRA_CODIGO = tx.TRA_CODIGO
        JOIN Contabilidad.TRANSACCION t ON t.TRA_CODIGO = td.TRA_CODIGO
        WHERE td.N_CODIGO = ?
          AND tx.TRA_FECHA_TRANS BETWEEN ? AND ?
        ORDER BY tx.TRA_FECHA_TRANS, t.TRA_HORA, td.TRAD_CORRELATIVO
        ";
        $mst = mysqli_prepare($db, $movSql);
        if (!$mst) throw new Exception("Error preparando movSql: " . mysqli_error($db));
        mysqli_stmt_bind_param($mst, 'sss', $codigoProv, $FechaIni, $FechaFin);
        mysqli_stmt_execute($mst);

        // Obtener resultados del statement (compatibilidad)
        if (function_exists('mysqli_stmt_get_result')) {
            $resMov = mysqli_stmt_get_result($mst);
        } else {
            // fallback no-soportado: fetch bind (poco frecuente en setups modernos)
            $resMov = null;
        }

        // recorrer movimientos e insertar en KARDEX
        $kardexInserted = 0;
        if ($resMov) {
            while ($row = mysqli_fetch_assoc($resMov)) {
                $cargos = (float)$row['CARGOS'];
                $abonos = (float)$row['ABONOS'];

                // aplicar regla de signo por código
                if (isset($codigoProv[0]) && $codigoProv[0] == '1') {
                    $monto = $cargos - $abonos;
                } else {
                    $monto = $abonos - $cargos;
                }

                $saldoAnterior = $saldo;
                $saldoNuevo = $saldoAnterior + $monto;

                // bind e insert kardex
                $kp_fecha = $row['TRA_FECHA_TRANS'];
                $kp_concepto = $row['TRA_CONCEPTO'];
                $kp_monto = $monto;
                $kp_ncodigo = $codigoProv;
                $kp_tracod = $row['TRA_CODIGO'];
                $kp_saldo_a = $saldoAnterior;
                $kp_saldo_n = $saldoNuevo;
                $kp_tipo = $row['TT_CODIGO'] ?? null;
                $kp_estado_t = 1;
                $kp_serie = $row['TRA_SERIE'] ?? null;
                $kp_factura = $row['TRA_FACTURA'] ?? null;

                // types: s s d s s d d s i s s -> 'ssdssddisss'
                mysqli_stmt_bind_param($insKardexStmt, 'ssdssddisss',
                    $kp_fecha, $kp_concepto, $kp_monto,
                    $kp_ncodigo, $kp_tracod, $kp_saldo_a,
                    $kp_saldo_n, $kp_tipo, $kp_estado_t,
                    $kp_serie, $kp_factura
                );
                $ok = mysqli_stmt_execute($insKardexStmt);
                if (!$ok) {
                    throw new Exception("Error insertando kardex (prov $codigoProv): " . mysqli_error($db));
                }
                $kardexInserted++;
                $report['kardex_rows_inserted']++;

                // actualizar saldo acumulado
                $saldo = $saldoNuevo;
            }
        }
        mysqli_stmt_close($mst);

        // -- insertar resumen en CUENTAS_POR_PAGAR (si está activado)
        if ($insert_summary) {
            $periodSql = "
            SELECT IFNULL(SUM(td.TRAD_CARGO_CONTA),0) AS pc, IFNULL(SUM(td.TRAD_ABONO_CONTA),0) AS pa
            FROM Contabilidad.TRANSACCION_DETALLE td
            JOIN tx_filtered tx ON td.TRA_CODIGO = tx.TRA_CODIGO
            WHERE td.N_CODIGO = ? AND tx.TRA_FECHA_TRANS BETWEEN ? AND ?
            ";
            $pst2 = mysqli_prepare($db, $periodSql);
            if (!$pst2) throw new Exception("Error preparando periodSql: " . mysqli_error($db));
            mysqli_stmt_bind_param($pst2, 'sss', $codigoProv, $FechaIni, $FechaFin);
            mysqli_stmt_execute($pst2);
            mysqli_stmt_bind_result($pst2, $periodCargos, $periodAbonos);
            mysqli_stmt_fetch($pst2);
            mysqli_stmt_close($pst2);
            $periodCargos = (float)$periodCargos;
            $periodAbonos = (float)$periodAbonos;

            // calcular deuda actual según tu regla
            if (isset($codigoProv[0]) && $codigoProv[0] == '1') {
                $deudaActual = ($prevCargos + $periodCargos) - ($prevAbonos + $periodAbonos);
            } else {
                $deudaActual = ($prevAbonos + $periodAbonos) - ($prevCargos + $periodCargos);
            }

            // solo insertar resumen si deudaActual > 0
            if ($deudaActual > 0.0001) {
                $cp_codigo = uniqid('CP_'); // puedes cambiar por UUID si prefieres
                $cp_ncodigo = $codigoProv;
                $cp_total = $periodCargos; // aquí guardamos totales del periodo; ajusta si quieres otra cosa
                $cp_abono = $periodAbonos;
                $p_tipo = 'GENERADO';
                $cp_realizo = $creator_user;

                // Bind types: s s s d d s => 'sssdds'
                mysqli_stmt_bind_param($insResumenStmt, 'sssdds',
                    $cp_codigo, $cp_ncodigo, $cp_realizo, $cp_total, $cp_abono, $p_tipo
                );
                $okRes = mysqli_stmt_execute($insResumenStmt);
                if (!$okRes) {
                    throw new Exception("Error insertando resumen para $codigoProv: " . mysqli_error($db));
                } else {
                    $report['summaries_inserted']++;
                }
            }
        } // end insert_summary

        // commit proveedor
        mysqli_commit($db);
        $report['providers_processed']++;
    } catch (Exception $ex) {
        // rollback proveedor
        mysqli_rollback($db);
        $report['errors'][] = $ex->getMessage();
    }
} // end foreach providers

// cerrar statements
mysqli_stmt_close($insKardexStmt);
mysqli_stmt_close($insResumenStmt);

// ----------------- 5) Salida HTML resumida -----------------
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Proceso terminado - Insert Cuentas por Pagar</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css">
</head>
<body class="container" style="padding:20px">
  <h3>Proceso de importación a KARDEX y CUENTAS_POR_PAGAR finalizado</h3>
  <ul>
    <li>Proveedores procesados: <?php echo htmlspecialchars($report['providers_processed']); ?></li>
    <li>Filas KARDEX insertadas: <?php echo htmlspecialchars($report['kardex_rows_inserted']); ?></li>
    <li>Resúmenes insertados: <?php echo htmlspecialchars($report['summaries_inserted']); ?></li>
  </ul>

  <?php if (!empty($report['errors'])): ?>
    <div class="alert alert-danger">
      <strong>Errores:</strong>
      <ul>
        <?php foreach ($report['errors'] as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?>
      </ul>
    </div>
  <?php else: ?>
    <div class="alert alert-success">Sin errores reportados.</div>
  <?php endif; ?>

  <p><a class="btn btn-primary" href="ListaCuentasPorPagar.php">Volver al Listado</a></p>
</body>
</html>
