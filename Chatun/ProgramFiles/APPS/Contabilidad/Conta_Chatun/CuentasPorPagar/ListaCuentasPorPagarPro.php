<?php
// error_reporting(error_reporting() & ~E_NOTICE);
// 	$db = mysqli_connect("10.60.58.214", "root","chatun2021");
// 	if (!$db) {
//   	echo "Error con la base de datos, favor de comunicarse al departamento de IDT para verificar...";
//  	 exit;
// 	}
// 	$db1 = mysqli_connect("10.60.58.214", "root","chatun2021");
// //defino tipo de caracteres a manejar.
// 	mysqli_set_charset($db, 'utf8');
// //defino variables globales de las tablas
// 	$base_asociados = 'info_asociados';
// 	$base_general = 'info_base';
// 	$base_bbdd = 'info_bbdd';
	// $base_colaboradores = 'info_colaboradores';
?>

<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$Usuar = $_SESSION["iduser"];
// 1801788
// $Usuar==53711 | $Usuar==22045 | $Usuar==435849
if($Usuar==1801788){
	$Filtro="";
}else{
	$Filtro="AND CC_REALIZO ="."$Usuar";
}
// --- Parámetros de filtro y paginación (leer GET) ---
$FechaIni = $_GET['FechaInicio'] ?? '2016-01-01';
$FechaFin = $_GET['FechaFin'] ?? date('Y-m-d');
$page     = max(1, (int)($_GET['page'] ?? 1));
$perPage  = max(10, (int)($_GET['perPage'] ?? 25)); // por defecto 25
$offset   = ($page - 1) * $perPage;

// Normalizar fechas a YYYY-MM-DD (básico)
$FechaIni = date('Y-m-d', strtotime($FechaIni));
$FechaFin = date('Y-m-d', strtotime($FechaFin));

// Opcional: filtrar por proveedor (N_CODIGO)
$filtroProveedor = isset($_GET['proveedor']) && $_GET['proveedor'] !== '' ? $_GET['proveedor'] : null;

// --- Consulta principal (agregada por proveedor) ---
// Nota: LEFT JOIN PROVEEDORES p para traer nombre y dias_credito si existe esa tabla.
// Ajusta p.nombre / p.dias_credito si en tu BD los campos se llaman distinto.
$baseWhere = "T.E_CODIGO = 2 AND T.TRA_ESTADO = 1";

$params = [':fi' => $FechaIni, ':ff' => $FechaFin];

$filtroProveedorSql = '';
if ($filtroProveedor !== null) {
    $filtroProveedorSql = " AND TD.N_CODIGO = :prov ";
    $params[':prov'] = $filtroProveedor;
}

// Subconsulta agrupada
$groupSql = "
    SELECT
      TD.N_CODIGO AS codigo,
      COALESCE(p.nombre, TD.TRAD_RAZON) AS nombre,
      COALESCE(p.dias_credito, 0) AS dias_credito,
      MAX(T.TRA_FECHA_TRANS) AS last_date,
      SUM(CASE WHEN T.TRA_FECHA_TRANS BETWEEN :fi AND :ff THEN TD.TRAD_CARGO_CONTA ELSE 0 END) AS period_cargos,
      SUM(CASE WHEN T.TRA_FECHA_TRANS BETWEEN :fi AND :ff THEN TD.TRAD_ABONO_CONTA ELSE 0 END) AS period_abonos,
      SUM(CASE WHEN T.TRA_FECHA_TRANS < :fi THEN TD.TRAD_CARGO_CONTA ELSE 0 END) AS prev_cargos,
      SUM(CASE WHEN T.TRA_FECHA_TRANS < :fi THEN TD.TRAD_ABONO_CONTA ELSE 0 END) AS prev_abonos,
      SUM(TD.TRAD_CARGO_CONTA) - SUM(TD.TRAD_ABONO_CONTA) AS total_deuda,
      COUNT(DISTINCT CASE WHEN T.TRA_FECHA_TRANS BETWEEN :fi AND :ff THEN T.TRA_CODIGO ELSE NULL END) AS num_facturas
    FROM TRANSACCION_DETALLE TD
    JOIN TRANSACCION T ON TD.TRA_CODIGO = T.TRA_CODIGO
    LEFT JOIN PROVEEDORES p ON p.N_CODIGO = TD.N_CODIGO
    WHERE {$baseWhere}
    {$filtroProveedorSql}
    GROUP BY TD.N_CODIGO, COALESCE(p.nombre, TD.TRAD_RAZON), COALESCE(p.dias_credito, 0)
    HAVING total_deuda <> 0
    ORDER BY total_deuda DESC
";

// --- Obtener total de filas (para paginación) ---
$countSql = "SELECT COUNT(*) AS cnt FROM ( $groupSql ) AS tcount";
$stmtCount = $pdo->prepare($countSql);
$stmtCount->execute($params);
$totalRows = (int)$stmtCount->fetchColumn();
$totalPages = (int)ceil($totalRows / $perPage);

// --- Traer datos paginados ---
$paginatedSql = $groupSql . " LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($paginatedSql);

// bind dinámico params
foreach ($params as $k => $v) {
    $stmt->bindValue($k, $v);
}
$stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();
$res = $stmt->fetchAll();

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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

<div class="container" style="margin-top:20px">
  <h3 class="text-center">Lista de Cuentas por Pagar (Estilo Estado de Cuenta)</h3>
  <p class="text-muted">Período: <?php echo htmlspecialchars(date('d-m-Y', strtotime($FechaIni))).' al '.htmlspecialchars(date('d-m-Y', strtotime($FechaFin))); ?></p>

  <div class="panel panel-default">
    <div class="panel-body table-responsive">
      <?php if (!$res) { ?>
        <div class="alert alert-danger">Error en consulta: <?php echo htmlspecialchars(mysqli_error($db)); ?></div>
      <?php } else { ?>
      <table class="table table-hover table-condensed" id="tbl_proveedores">
        <thead>
          <tr>
            <th>No.</th>
            <th>Fecha (Últ. emisión)</th>
            <th>Código Proveedor</th>
            <th>Nombre Proveedor</th>
            <th>Vencimiento (Fecha emisión + días crédito)</th>
            <th>Cargos (período)</th>
            <th>Abonos (período)</th>
            <th>Saldo Anterior (C-A)</th>
            <th>Deuda Actual</th>
            <th>Facturas Pend.</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($res)) {
            $last_date = $row['last_date'] ? date('d-m-Y', strtotime($row['last_date'])) : '---';
            $dias_credito = isset($row['dias_credito']) ? (int)$row['dias_credito'] : 0;
            $vencimiento = ($row['last_date']) ? date('d-m-Y', strtotime($row['last_date'] . " +{$dias_credito} days")) : '---';

            $period_cargos = number_format((float)$row['period_cargos'],2);
            $period_abonos = number_format((float)$row['period_abonos'],2);
            $prev_cargos = (float)$row['prev_cargos'];
            $prev_abonos = (float)$row['prev_abonos'];
            $saldo_anterior = number_format($prev_cargos - $prev_abonos,2); // igual que ECImp: cargos - abonos para cuenta tipo activo
            $total_deuda = number_format((float)$row['total_deuda'],2);
            $num_fact = (int)$row['num_facturas'];

            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$last_date.'</td>';
            echo '<td>'.htmlspecialchars($row['codigo']).'</td>';
            echo '<td>'.htmlspecialchars($row['nombre']).'</td>';
            echo '<td>'.$vencimiento.'</td>';
            echo '<td class="text-right">Q. '.$period_cargos.'</td>';
            echo '<td class="text-right">Q. '.$period_abonos.'</td>';
            echo '<td class="text-right">Q. '.$saldo_anterior.'</td>';
            echo '<td class="text-right">Q. '.$total_deuda.'</td>';
            echo '<td class="text-center">'.$num_fact.'</td>';
            echo '<td>';
            echo '<a class="btn btn-xs btn-info" href="DetalleProveedor.php?codigo='.urlencode($row['codigo']).'">Detalles</a> ';
            echo '<a class="btn btn-xs btn-primary" href="PagarProveedor.php?codigo='.urlencode($row['codigo']).'">Pagar</a>';
            echo '</td>';
            echo '</tr>';

            $i++;
        }
        ?>
        </tbody>
      </table>
      <?php
 if ($totalRows > 0) { ?>
<nav aria-label="Page navigation">
  <ul class="pagination">
    <?php
    $qsBase = "FechaInicio=" . urlencode($qFechaIni) . "&FechaFin=" . urlencode($qFechaFin) . "&perPage=".(int)$perPage;
    $prev = max(1, $page-1);
    $next = min($totalPages, $page+1);
    ?>
    <li class="<?php echo ($page==1)?'disabled':'';?>"><a href="?<?php echo $qsBase; ?>&page=1" aria-label="Primera"><span>&laquo;</span></a></li>
    <li class="<?php echo ($page==1)?'disabled':'';?>"><a href="?<?php echo $qsBase; ?>&page=<?php echo $prev; ?>" aria-label="Anterior"><span>&lsaquo;</span></a></li>

    <?php
    $start = max(1, $page-3);
    $end = min($totalPages, $page+3);
    for ($p = $start; $p <= $end; $p++) {
        echo '<li'.(($p==$page)?' class="active"':'').'><a href="?'.$qsBase.'&page='.$p.'">'.$p.'</a></li>';
    }
    ?>

    <li class="<?php echo ($page==$totalPages)?'disabled':'';?>"><a href="?<?php echo $qsBase; ?>&page=<?php echo $next; ?>" aria-label="Siguiente"><span>&rsaquo;</span></a></li>
    <li class="<?php echo ($page==$totalPages)?'disabled':'';?>"><a href="?<?php echo $qsBase; ?>&page=<?php echo $totalPages; ?>" aria-label="Última"><span>&raquo;</span></a></li>
  </ul>
</nav>
<?php } ?>
<?php } ?>
    </div>
  </div>
</div>
	<?php include("../MenuUsers.html"); ?>

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