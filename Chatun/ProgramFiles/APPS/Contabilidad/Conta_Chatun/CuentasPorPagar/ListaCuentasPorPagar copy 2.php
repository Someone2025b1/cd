<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Portal Institucional Chatún</title>

    <!-- META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- STYLESHEETS -->
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
    <link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">

    <!-- Layout fixes + responsive tweaks -->
    <style>
        :root {
            --menubar-default-width: 260px;
        }

        header,
        .header,
        .topbar,
        #header,
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1060;
            width: 100%;
        }

        #menubar {
            position: fixed;
            left: 0;
            bottom: 0;
            z-index: 1050;
            overflow-y: auto;
        }

        #main-wrapper {
            transition: margin-left .18s ease, padding-top .18s ease;
        }

        .search-row {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .titulo-pagina {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(90deg, #33b749ff, #00c6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 25px 0;
            text-transform: uppercase;
        }

        /* Estilos para la nueva tabla */
        .table-container {
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table>thead>tr>th {
            font-weight: 600;
            color: #337ab7;
        }

        .table>tbody>tr.proveedor-row {
            cursor: pointer;
        }
            
        .table>tbody>tr.proveedor-row:hover {
            background-color: #f5f5f5;
        }

        .collapse-details {
            background-color: #f9f9f9;
            border-left: 4px solid #337ab7;
            padding: 15px;
        }
        
        .collapse-details .detail-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .badge-active {
            background-color: #28a745;
        }

        /* Paginación */
        .pagination-wrap {
            margin-top: 18px;
            margin-bottom: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pagination-wrap .page-btn {
            border: 1px solid #ddd;
            background: #fff;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            min-width: 36px;
            text-align: center;
        }

        .pagination-wrap .page-btn.active {
            background: #337ab7;
            color: #fff;
            border-color: #2e6da4;
        }

        .pagination-wrap .page-btn.disabled {
            opacity: .5;
            pointer-events: none;
        }

        .page-size-select {
            margin-left: 12px;
        }

        .filter-controls {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-left: 12px;
        }

        @media (max-width: 991px) {
            #menubar {
                left: -100%;
            }

            #main-wrapper {
                margin-left: 0 !important;
                padding-top: 60px;
            }

            .pagination-wrap {
                padding: 0 12px;
            }
        }
    </style>
</head>

<body class="menubar-hoverable header-fixed menubar-pin">

    <section id="wrapper" class="login-register login-sidebar">

        <?php include("../../../../MenuTop.php") ?>

        <div id="main-wrapper">
            <div class="container-fluid">
                <div class="row search-row">
                    <div class="col-xs-12 text-right">
                        <h1 class="titulo-pagina text-center">
                            <i class="fa fa-building" aria-hidden="true"></i>
                            <strong>Listado de Proveedores para Cuentas Por Pagar</strong>
                        </h1>
                        <input type="text" class="form-control" id="search" style="width:240px;display:inline-block;" placeholder="Buscar un proveedor..">
                        <span class="filter-controls" title="Mostrar sólo proveedores con movimientos en los últimos 12 meses">
                            <input type="checkbox" id="filterActive" style="vertical-align:middle;" />
                            <label for="filterActive" style="margin:0; font-size:13px; vertical-align:middle;">Mostrar sólo activos (último año)</label>
                        </span>
                        <select id="pageSize" class="form-control page-size-select" style="width:110px;display:inline-block;">
                            <option value="10">10 / pág</option>
                            <option value="15" selected>15 / pág</option>
                            <option value="25">25 / pág</option>
                            <option value="50">50 / pág</option>
                        </select>
                    </div>
                </div>

                <!-- Nueva Tabla con Collapse -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre del Proveedor</th>
                                            <th>Codigo del Proveedor</th>
                                            <th>Ultima Factura</th>
                                            <th>Fehcha de Factura</th>
                                            <th>Ultima fecha de pago</th>
                                            <th>Monto</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Ver Detalles</th>
                                        </tr>
                                    </thead>
                                    <tbody id="mytable">
                                        <?php
                                        // La lógica PHP y la consulta a la base de datos no se modifican
                                        $sql = "
                                            SELECT P.P_CODIGO, P.P_NOMBRE,
                                                   CASE WHEN activos.P_CODIGO IS NOT NULL THEN 1 ELSE 0 END AS activo_reciente
                                            FROM Contabilidad.PROVEEDOR P
                                            LEFT JOIN (
                                                SELECT DISTINCT TD.N_CODIGO AS P_CODIGO
                                                FROM Contabilidad.TRANSACCION_DETALLE TD
                                                JOIN Contabilidad.TRANSACCION T ON TD.TRA_CODIGO = T.TRA_CODIGO
                                                WHERE T.TRA_FECHA_TRANS BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()
                                                  AND T.E_CODIGO = 2 AND T.TRA_ESTADO = 1
                                            ) activos ON P.P_CODIGO = activos.P_CODIGO
                                            ORDER BY activo_reciente DESC, P.P_NOMBRE;
                                        ";
                                        $Sql_Aplicativos = mysqli_query($db, $sql);
                                        if (!$Sql_Aplicativos) {
                                            $Sql_Aplicativos = mysqli_query($db, "SELECT P_CODIGO, P_NOMBRE FROM Contabilidad.PROVEEDOR");
                                        }
                                        
                                        $contador = 0;
                                        while ($Fila_Aplicativos = mysqli_fetch_array($Sql_Aplicativos)) {
                                            $contador++;
                                            $Link  = "ListaCuentasPorPagarPro.php?CodigoCuenta=" . $Fila_Aplicativos['P_CODIGO'] . "&NombreCuenta=" . urlencode($Fila_Aplicativos['P_NOMBRE']);
                                            $activo = isset($Fila_Aplicativos['activo_reciente']) ? intval($Fila_Aplicativos['activo_reciente']) : 0;
                                            $clase_activo = $activo ? 'activo-reciente' : '';
                                            $collapseId = "collapse_" . $contador;
                                        ?>
                                            <!-- Fila principal que activa el collapse -->
                                            <tr class="proveedor-row <?php echo $clase_activo ?>" data-toggle="collapse" data-target="#<?php echo $collapseId ?>" aria-expanded="false" aria-controls="<?php echo $collapseId ?>">
                                                <td><?php echo htmlspecialchars($Fila_Aplicativos['P_NOMBRE']); ?></td>
                                                <td><?php echo htmlspecialchars($Fila_Aplicativos['P_CODIGO']); ?></td>
                                                <td><?php echo htmlspecialchars($Fila_Aplicativos['P_CODIGO']); ?></td>
                                                <td><?php echo htmlspecialchars($Fila_Aplicativos['P_CODIGO']); ?></td>
                                                <td><?php echo htmlspecialchars($Fila_Aplicativos['P_CODIGO']); ?></td>
                                                <td><?php echo htmlspecialchars($Fila_Aplicativos['P_CODIGO']); ?></td>
                                                <td class="text-center">
                                                    <?php if ($activo): ?>
                                                        <span class="badge badge-active">Activo</span>
                                                    <?php else: ?>
                                                        <span class="badge">Inactivo</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><i class="fa fa-chevron-down"></i></td>
                                            </tr>
                                            <!-- Fila oculta con los detalles (collapse) -->
                                            <tr>
                                                <td colspan="3" style="padding: 0 !important;">
                                                    <div class="collapse collapse-details" id="<?php echo $collapseId ?>">
                                                        <div class="detail-content">
                                                            <div>
                                                                <strong>Código de Proveedor:</strong> <?php echo $Fila_Aplicativos['P_CODIGO']; ?><br>
                                                                <?php if ($activo): ?>
                                                                    <small style="color:#28a745;">Este proveedor ha tenido movimientos en el último año.</small>
                                                                <?php endif; ?>
                                                            </div>
                                                            <a href="<?php echo $Link ?>" class="btn btn-primary">
                                                                <i class="fa fa-eye"></i> Ver Cuentas por Pagar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Controles de paginación -->
                <div class="row">
                    <div class="col-xs-12">
                        <div id="paginationControls" class="pagination-wrap"></div>
                    </div>
                </div>

            </div>

            <?php include("../MenuUsers.html"); ?>
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

        <!-- JS para ajustar layout dinámicamente y búsqueda + paginación -->
        <script>
            (function() {
                // --- layout helpers (sin cambios) ---
                var main = document.getElementById('main-wrapper');
                var menubar = document.getElementById('menubar');
                var header = document.querySelector('header, .header, #header, .topbar');

                function computeAndApply() {
                    try {
                        var menubar = document.getElementById('menubar');
                        var main = document.getElementById('main-wrapper');
                        var header = document.querySelector('header, .header, #header, .topbar, .navbar');
                        var headerHeight = header ? (header.getBoundingClientRect().height || 0) : 0;
                        var menubarWidth = 0;
                        if (document.body.classList.contains('menubar-pin') && menubar) {
                            menubarWidth = menubar.getBoundingClientRect().width || 0;
                            if (!menubarWidth) {
                                var fallback = getComputedStyle(document.documentElement).getPropertyValue('--menubar-default-width');
                                menubarWidth = parseInt(fallback) || 260;
                            }
                        }
                        if (menubar) {
                            menubar.style.position = 'fixed';
                            menubar.style.top = headerHeight + 'px';
                            menubar.style.height = (window.innerHeight - headerHeight) + 'px';
                            menubar.style.overflowY = 'auto';
                            menubar.style.zIndex = 1050;
                        }
                        if (main) {
                            if (window.innerWidth > 991) {
                                main.style.marginLeft = menubarWidth + 'px';
                            } else {
                                main.style.marginLeft = '0px';
                            }
                            main.style.paddingTop = headerHeight + 'px';
                        }
                    } catch (e) {
                        console.error('computeAndApply error', e);
                    }
                }
                window.addEventListener('load', computeAndApply);
                window.addEventListener('resize', computeAndApply);
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(m) {
                        if (m.type === 'attributes' && m.attributeName === 'class') {
                            computeAndApply();
                        }
                    });
                });
                observer.observe(document.body, {
                    attributes: true
                });
                if (menubar) {
                    try {
                        var ro = new ResizeObserver(function() {
                            computeAndApply();
                        });
                        ro.observe(menubar);
                    } catch (err) {}
                }

                // --- Paginación y búsqueda para la TABLA ---
                var $rows = null; // Todas las filas .proveedor-row
                var currentPage = 1;
                var pageSize = parseInt($('#pageSize').val()) || 15;

                function collectRows() {
                    $rows = $("#mytable .proveedor-row");
                }

                function getFilteredIndices(filterText) {
                    var indices = [];
                    filterText = (filterText || "").toLowerCase();
                    var activeOnly = $('#filterActive').is(':checked');

                    $rows.each(function(i) {
                        var $row = $(this);
                        var text = $row.text().toLowerCase();

                        if (activeOnly && !$row.hasClass('activo-reciente')) {
                            return; // continue
                        }

                        if (!filterText || text.indexOf(filterText) > -1) {
                            indices.push(i);
                        }
                    });
                    return indices;
                }

                function renderPage(page) {
                    var filter = $('#search').val().toLowerCase();
                    var indices = getFilteredIndices(filter);
                    var total = indices.length;
                    var totalPages = Math.max(1, Math.ceil(total / pageSize));

                    if (page < 1) page = 1;
                    if (page > totalPages) page = totalPages;
                    currentPage = page;

                    // Ocultar todas las filas (tanto la principal como la de detalles)
                    $('#mytable tr').hide();

                    var start = (currentPage - 1) * pageSize;
                    var end = start + pageSize;
                    for (var pos = start; pos < end && pos < total; pos++) {
                        var idx = indices[pos];
                        var $mainRow = $rows.eq(idx);
                        var $detailRow = $mainRow.next('tr'); // La fila de detalles es la siguiente
                        
                        $mainRow.show();
                        $detailRow.show(); // Mostramos la fila de detalles para que el collapse funcione
                    }

                    renderPaginationControls(totalPages, currentPage);
                }

                function renderPaginationControls(totalPages, activePage) {
                    var $p = $('#paginationControls');
                    $p.empty();

                    function btn(label, page, cls) {
                        var $b = $('<div class="page-btn"></div>').text(label).data('page', page);
                        if (cls) $b.addClass(cls);
                        return $b;
                    }

                    var $prev = btn('«', activePage - 1);
                    if (activePage === 1) $prev.addClass('disabled');
                    $p.append($prev);

                    var maxButtons = 7;
                    var half = Math.floor(maxButtons / 2);
                    var start = Math.max(1, activePage - half);
                    var end = Math.min(totalPages, start + maxButtons - 1);
                    if (end - start < maxButtons - 1) {
                        start = Math.max(1, end - maxButtons + 1);
                    }

                    if (start > 1) {
                        $p.append(btn(1, 1));
                        if (start > 2) $p.append($('<div class="page-btn disabled">...</div>'));
                    }

                    for (var i = start; i <= end; i++) {
                        var cls = (i === activePage) ? 'active' : '';
                        $p.append(btn(i, i, cls));
                    }

                    if (end < totalPages) {
                        if (end < totalPages - 1) $p.append($('<div class="page-btn disabled">...</div>'));
                        $p.append(btn(totalPages, totalPages));
                    }

                    var $next = btn('»', activePage + 1);
                    if (activePage === totalPages) $next.addClass('disabled');
                    $p.append($next);

                    $p.off('click').on('click', '.page-btn', function() {
                        var $this = $(this);
                        if ($this.hasClass('disabled') || $this.hasClass('active')) return;
                        var toPage = $this.data('page');
                        if (typeof toPage === 'number') {
                            renderPage(toPage);
                            $('html, body').animate({
                                scrollTop: $('#mytable').offset().top - 80
                            }, 200);
                        }
                    });
                }

                $(document).ready(function() {
                    collectRows();
                    renderPage(1);

                    $('#search').on('input', function() {
                        currentPage = 1;
                        renderPage(1);
                    });

                    $('#filterActive').on('change', function() {
                        currentPage = 1;
                        renderPage(1);
                    });

                    $('#pageSize').on('change', function() {
                        pageSize = parseInt($(this).val()) || 15;
                        currentPage = 1;
                        renderPage(1);
                    });

                    // Icono de flecha en collapse
                    $('#mytable').on('show.bs.collapse', '.collapse', function () {
                        $(this).closest('tr').prev('tr.proveedor-row').find('.fa').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                    }).on('hide.bs.collapse', '.collapse', function () {
                        $(this).closest('tr').prev('tr.proveedor-row').find('.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                    });

                    computeAndApply();
                });

            })();
        </script>
    </section>
</body>

</html>