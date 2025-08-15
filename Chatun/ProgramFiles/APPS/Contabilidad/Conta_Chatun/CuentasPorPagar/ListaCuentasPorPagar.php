<?php
// ListaCuentasPorPagar.php
// Versión SIN crear tablas (NO CREATE TEMPORARY TABLE)
// Lista todos los proveedores con deuda, paginada y con TableFilterJS

ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");    // debe proveer $db (mysqli)
include("../../../../../Script/funciones.php");

// Seleccionar la base de datos explícitamente en caso de "No database selected"
$dbName = 'Contabilidad';
if (!mysqli_select_db($db, $dbName)) {
    die("Error seleccionando la base de datos '$dbName': " . mysqli_error($db));
}

// Parámetros (GET o POST)
$FechaIni = $_REQUEST['FechaInicio'] ?? date('Y-m-01');
$FechaFin = $_REQUEST['FechaFin']  ?? date('Y-m-d');
$page     = max(1, (int)($_REQUEST['page'] ?? 1));
$perPage  = max(10, (int)($_REQUEST['perPage'] ?? 50));
$offset   = ($page - 1) * $perPage;

// Normalizar fechas a YYYY-MM-DD
$FechaIni = date('Y-m-d', strtotime($FechaIni));
$FechaFin = date('Y-m-d', strtotime($FechaFin));

// -----------------------------------------
// 1) Contar total de proveedores con deuda
// (no temp table, join directo TRANSACCION_DETALLE -> TRANSACCION)
// -----------------------------------------
$countSql = "
SELECT COUNT(*) AS cnt FROM (
  SELECT td.N_CODIGO
  FROM Contabilidad.TRANSACCION_DETALLE td
  JOIN Contabilidad.TRANSACCION t ON td.TRA_CODIGO = t.TRA_CODIGO
  WHERE t.E_CODIGO = 2
    AND t.TRA_ESTADO = 1
  GROUP BY td.N_CODIGO
  HAVING (SUM(td.TRAD_CARGO_CONTA) - SUM(td.TRAD_ABONO_CONTA)) <> 0
) AS tcount
";
$resCount = mysqli_query($db, $countSql);
if ($resCount === false) {
    $totalRows = 0;
} else {
    $totalRows = (int) mysqli_fetch_assoc($resCount)['cnt'];
}
$totalPages = max(1, (int)ceil($totalRows / $perPage));

// -----------------------------------------
// 2) Consulta principal (agregada y paginada)
// -----------------------------------------
$mainSql = "
SELECT
  td.N_CODIGO AS codigo,
  td.TRAD_RAZON AS nombre,
  MAX(t.TRA_FECHA_TRANS) AS last_date,
  SUM(CASE WHEN t.TRA_FECHA_TRANS BETWEEN ? AND ? THEN td.TRAD_CARGO_CONTA ELSE 0 END) AS period_cargos,
  SUM(CASE WHEN t.TRA_FECHA_TRANS BETWEEN ? AND ? THEN td.TRAD_ABONO_CONTA ELSE 0 END) AS period_abonos,
  SUM(CASE WHEN t.TRA_FECHA_TRANS < ? THEN td.TRAD_CARGO_CONTA ELSE 0 END) AS prev_cargos,
  SUM(CASE WHEN t.TRA_FECHA_TRANS < ? THEN td.TRAD_ABONO_CONTA ELSE 0 END) AS prev_abonos,
  SUM(td.TRAD_CARGO_CONTA) - SUM(td.TRAD_ABONO_CONTA) AS total_deuda,
  COUNT(DISTINCT CASE WHEN t.TRA_FECHA_TRANS BETWEEN ? AND ? THEN t.TRA_CODIGO ELSE NULL END) AS num_facturas
FROM Contabilidad.TRANSACCION_DETALLE td
JOIN Contabilidad.TRANSACCION t ON td.TRA_CODIGO = t.TRA_CODIGO
WHERE t.E_CODIGO = 2
  AND t.TRA_ESTADO = 1
GROUP BY td.N_CODIGO, td.TRAD_RAZON
HAVING total_deuda <> 0
ORDER BY total_deuda DESC
LIMIT ? OFFSET ?
";

$stmt = mysqli_prepare($db, $mainSql);
if (!$stmt) {
    die("Error preparando consulta principal: " . mysqli_error($db));
}

// Bind parameters:
// fi,ff,fi,ff,prevCut,prevCut,fi,ff, limit, offset
$fi = $FechaIni;
$ff = $FechaFin;
$prevCut = $FechaIni;
mysqli_stmt_bind_param($stmt, 'ssssssssii',
    $fi, $ff,   // period cargos
    $fi, $ff,   // period abonos
    $prevCut, $prevCut, // prev cutoff
    $fi, $ff,   // num_facturas count
    $perPage, $offset
);
mysqli_stmt_execute($stmt);

// Obtener resultados (compatibilidad)
$rows = [];
if (function_exists('mysqli_stmt_get_result')) {
    $res = mysqli_stmt_get_result($stmt);
    if ($res) $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    // Fallback a bind_result + fetch
    mysqli_stmt_bind_result(
        $stmt,
        $codigo, $nombre, $last_date,
        $period_cargos, $period_abonos,
        $prev_cargos, $prev_abonos,
        $total_deuda, $num_facturas
    );
    while (mysqli_stmt_fetch($stmt)) {
        $rows[] = [
            'codigo' => $codigo,
            'nombre' => $nombre,
            'last_date' => $last_date,
            'period_cargos' => $period_cargos,
            'period_abonos' => $period_abonos,
            'prev_cargos' => $prev_cargos,
            'prev_abonos' => $prev_abonos,
            'total_deuda' => $total_deuda,
            'num_facturas' => $num_facturas
        ];
    }
}
mysqli_stmt_close($stmt);

// -----------------------------------------
// 3) Render HTML + TableFilterJS
// -----------------------------------------
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de Cuentas por Pagar - Todos (Sin crear tablas)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- TableFilter script -->
  <script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

  <!-- STYLES -->
  <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
  <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
  <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
  <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
  <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
  <link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
  <style>
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .table-condensed td, .table-condensed th { padding: .35rem; }
  </style>
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">
<?php include("../../../../MenuTop.php"); ?>

<div class="container" style="margin-top:20px">
  <h3 class="text-center">Lista de Cuentas por Pagar (Todos los Proveedores)</h3>
  <p class="text-muted text-center">
    Período: <?php echo htmlspecialchars(date('d-m-Y', strtotime($FechaIni))) . ' al ' . htmlspecialchars(date('d-m-Y', strtotime($FechaFin))); ?>
    &nbsp; | &nbsp; Registros: <?php echo number_format($totalRows); ?>
  </p>

  <div class="panel panel-default">
    <div class="panel-body table-responsive">
      <table class="table table-hover table-condensed" id="tbl_resultados">
        <thead>
          <tr>
            <th>No.</th>
            <th>Proveedor (Código)</th>
            <th>Nombre</th>
            <th>Últ. emisión</th>
            <th class="text-right">Cargos (período)</th>
            <th class="text-right">Abonos (período)</th>
            <th class="text-right">Saldo Anterior</th>
            <th class="text-right">Deuda Actual</th>
            <th class="text-center">Facturas</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if (empty($rows)) {
            echo '<tr><td colspan="10" class="text-center">No se encontraron proveedores con deuda en el periodo.</td></tr>';
        } else {
            $i = $offset + 1;
            foreach ($rows as $r) {
                $prev_cargos = (float)($r['prev_cargos'] ?? 0);
                $prev_abonos = (float)($r['prev_abonos'] ?? 0);
                $saldo_anterior_val = (isset($r['codigo'][0]) && $r['codigo'][0] == '1')
                    ? ($prev_cargos - $prev_abonos)
                    : ($prev_abonos - $prev_cargos);

                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . htmlspecialchars($r['codigo']) . '</td>';
                echo '<td>' . htmlspecialchars($r['nombre']) . '</td>';
                echo '<td>' . ($r['last_date'] ? htmlspecialchars(date('d-m-Y', strtotime($r['last_date']))) : '---') . '</td>';
                echo '<td class="text-right">Q. ' . number_format((float)$r['period_cargos'], 2) . '</td>';
                echo '<td class="text-right">Q. ' . number_format((float)$r['period_abonos'], 2) . '</td>';
                echo '<td class="text-right">Q. ' . number_format($saldo_anterior_val, 2) . '</td>';
                echo '<td class="text-right">Q. ' . number_format((float)$r['total_deuda'], 2) . '</td>';
                echo '<td class="text-center">' . (int)$r['num_facturas'] . '</td>';
                echo '<td>';
                echo '<a class="btn btn-xs btn-info" href="DetalleProveedor.php?codigo=' . urlencode($r['codigo']) . '">Detalles</a> ';
                echo '<a class="btn btn-xs btn-primary" href="PagarProveedor.php?codigo=' . urlencode($r['codigo']) . '">Pagar</a>';
                echo '</td>';
                echo '</tr>';
                $i++;
            }
        }
        ?>
        </tbody>
      </table>

      <!-- Paginación -->
      <?php if ($totalRows > 0) { ?>
<nav aria-label="Page navigation">
  <ul class="pagination">
    <?php
    $qsBase = "FechaInicio=" . urlencode($FechaIni) . "&FechaFin=" . urlencode($FechaFin) . "&perPage=" . (int)$perPage;
    $prev = max(1, $page - 1);
    $next = min($totalPages, $page + 1);
    ?>
    <li class="<?php echo ($page == 1) ? 'disabled' : ''; ?>"><a href="?<?php echo $qsBase; ?>&page=1" aria-label="Primera"><span>&laquo;</span></a></li>
    <li class="<?php echo ($page == 1) ? 'disabled' : ''; ?>"><a href="?<?php echo $qsBase; ?>&page=<?php echo $prev; ?>" aria-label="Anterior"><span>&lsaquo;</span></a></li>

    <?php
    $start = max(1, $page - 3);
    $end = min($totalPages, $page + 3);
    for ($p = $start; $p <= $end; $p++) {
        echo '<li' . (($p == $page) ? ' class="active"' : '') . '><a href="?' . $qsBase . '&page=' . $p . '">' . $p . '</a></li>';
    }
    ?>

    <li class="<?php echo ($page == $totalPages) ? 'disabled' : ''; ?>"><a href="?<?php echo $qsBase; ?>&page=<?php echo $next; ?>" aria-label="Siguiente"><span>&rsaquo;</span></a></li>
    <li class="<?php echo ($page == $totalPages) ? 'disabled' : ''; ?>"><a href="?<?php echo $qsBase; ?>&page=<?php echo $totalPages; ?>" aria-label="Última"><span>&raquo;</span></a></li>
  </ul>
</nav>
<?php } ?>

    </div>
  </div>
</div>

<?php include("../MenuUsers.html"); ?>

<!-- CORE SCRIPTS -->
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

<!-- Inicializar TableFilter con tu configuración -->
<script>
window.addEventListener('load', function(){
  try {
    var tbl_filtrado =  { 
        mark_active_columns: true,
        highlight_keywords: true,
        filters_row_index:1,
        paging: true,
        paging_length: 15,  
        rows_counter: true,
        rows_counter_text: "Registros: ", 
        page_text: "Página:",
        of_text: "de",
        btn_reset: true, 
        loader: true, 
        loader_html: "<img src='../../../../../libs/TableFilter/img_loading.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
        display_all_text: "-Todos-",
        results_per_page: ["# Filas por Página...",[10,20,50,100]],  
        btn_reset: true,
        col_2: "disable",
        col_3: "disable",
        alternate_rows: true,
        col_4: 'number',
        col_5: 'number',
        col_6: 'number',
        col_7: 'number'
    };

    if (typeof setFilterGrid === 'function') {
      setFilterGrid('tbl_resultados', tbl_filtrado);
    } else if (typeof TableFilter !== 'undefined') {
      var TFconfig = Object.assign({}, tbl_filtrado);
      TFconfig.base_path = TFconfig.base_path || '../../../../../libs/TableFilter/';
      var tf = new TableFilter('tbl_resultados', TFconfig);
      tf.init();
    } else {
      console.warn('TableFilter no disponible en este entorno.');
    }
  } catch(e) {
    console.warn('TableFilter no inicializado:', e);
  }
});
</script>

</body>
</html>
