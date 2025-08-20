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

        .app-card {
            padding: 8px;
        }

        .app-card .card {
            min-height: 180px;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            /* necesario para badge */
            overflow: visible;
        }

        .app-card .card .card-body {
            position: relative;
            padding: 1rem;
        }

        .btn-circle {
            border-radius: 50%;
            padding: 6px 8px;
        }

        /* Badge para proveedores activos */
        .badge-active {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #28a745;
            color: white;
            font-weight: 700;
            padding: 4px 7px;
            border-radius: 12px;
            font-size: 13px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
            line-height: 1;
        }

        /* Estilo para proveedores activos en el último año */
        .activo-reciente .card {
            border: 2px solid #28a745;
            background-color: #e9f7ef;
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

        /* checkbox + label inline */
        .filter-controls {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-left: 12px;
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
                        <!-- filtro para mostrar solo activos -->
                        <span class="filter-controls" title="Mostrar sólo proveedores con movimientos en los últimos 12 meses">
                            <input type="checkbox" id="filterActive" style="vertical-align:middle;" />
                            <label for="filterActive" style="margin:0; font-size:13px; vertical-align:middle;">Mostrar sólo activos (último año)</label>
                        </span>
                        <!-- tamaño de página -->
                        <select id="pageSize" class="form-control page-size-select" style="width:110px;display:inline-block;">
                            <option value="6">6 / pág</option>
                            <option value="9">9 / pág</option>
                            <option value="12" selected>12 / pág</option>
                            <option value="20">20 / pág</option>
                        </select>
                    </div>
                </div>

                <!-- Grid responsivo de apps -->
                <div class="row" id="mytable">
                    <?php
                    // Consulta mejorada: prioriza proveedores con actividad en el último año
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
                        // Si la consulta falla, intentamos con la consulta simple original como fallback
                        $Sql_Aplicativos = mysqli_query($db, "SELECT P_CODIGO, P_NOMBRE FROM Contabilidad.PROVEEDOR");
                    }
                    while ($Fila_Aplicativos = mysqli_fetch_array($Sql_Aplicativos)) {
                        $Icono = "../../../../APPS/IDT/Imagenes/Aplicaciones/rrhh2.png";
                        $Link  = "ListaCuentasPorPagarPro.php?CodigoCuenta=" . $Fila_Aplicativos['P_CODIGO'] . "&NombreCuenta=" . urlencode($Fila_Aplicativos['P_NOMBRE']);
                        // Determinar clase si existe campo activo_reciente (fallback 0 si no existe)
                        $activo = isset($Fila_Aplicativos['activo_reciente']) ? intval($Fila_Aplicativos['activo_reciente']) : 0;
                        $clase = $activo ? 'activo-reciente' : '';
                    ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 app-card <?php echo $clase ?>">
                            <a href="<?php echo $Link ?>">
                                <div class="card h-100">
                                    <?php if ($activo): ?>
                                        <div class="badge-active" aria-hidden="true">★ Activo</div>
                                    <?php endif; ?>
                                    <div class="text-center p-3">
                                        <img src="<?php echo $Icono ?>" height="80" width="80" alt="icono" loading="lazy">
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="font-normal">
                                            <?php echo $Fila_Aplicativos['P_NOMBRE'] ?>
                                            <?php if ($activo): ?>
                                                <br><small style="color:#28a745;">(Activo último año)</small>
                                            <?php endif; ?>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
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
                // --- layout helpers (no tocamos la lógica) ---
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
                    } catch (err) {
                        // ResizeObserver puede no estar en navegadores muy viejos
                    }
                }

                // --- paginación en cliente (ligera) ---
                var $cards = null; // todos los .app-card
                var currentPage = 1;
                var pageSize = parseInt($('#pageSize').val()) || 12;

                function collectCards() {
                    // reconstruye la lista de tarjetas actuales (DOM)
                    $cards = $(".app-card");
                }

                function getFilteredIndices(filterText) {
                    // Devuelve array de índices de elementos que coinciden con el filtro
                    var indices = [];
                    filterText = (filterText || "").toLowerCase();
                    var activeOnly = $('#filterActive').is(':checked');

                    $cards.each(function(i) {
                        var $card = $(this);
                        var text = $card.text().toLowerCase();

                        // si está activado el filtro "solo activos" y la tarjeta no tiene la clase, skip
                        if (activeOnly && !$card.hasClass('activo-reciente')) {
                            return; // continue
                        }

                        if (!filterText || text.indexOf(filterText) > -1) {
                            indices.push(i);
                        }
                    });
                    return indices;
                }

                function renderPage(page) {
                    // muestra sólo la página solicitada
                    var filter = $('#search').val().toLowerCase();
                    var indices = getFilteredIndices(filter);
                    var total = indices.length;
                    var totalPages = Math.max(1, Math.ceil(total / pageSize));

                    // normalizar página
                    if (page < 1) page = 1;
                    if (page > totalPages) page = totalPages;
                    currentPage = page;

                    // ocultar todo y luego mostrar sólo los índices que tocan
                    $cards.hide();

                    var start = (currentPage - 1) * pageSize;
                    var end = start + pageSize;
                    for (var pos = start; pos < end && pos < total; pos++) {
                        var idx = indices[pos];
                        $cards.eq(idx).show();
                    }

                    renderPaginationControls(totalPages, currentPage);
                }

                function renderPaginationControls(totalPages, activePage) {
                    var $p = $('#paginationControls');
                    $p.empty();

                    // helper para crear botón
                    function btn(label, page, cls) {
                        var $b = $('<div class="page-btn"></div>').text(label).data('page', page);
                        if (cls) $b.addClass(cls);
                        return $b;
                    }

                    // Prev
                    var $prev = btn('«', activePage - 1);
                    if (activePage === 1) $prev.addClass('disabled');
                    $p.append($prev);

                    // lógica para mostrar hasta N botones y usar "..." cuando hay muchas páginas
                    var maxButtons = 7; // ajustar si quieres más
                    var half = Math.floor(maxButtons / 2);
                    var start = Math.max(1, activePage - half);
                    var end = Math.min(totalPages, start + maxButtons - 1);
                    if (end - start < maxButtons - 1) {
                        start = Math.max(1, end - maxButtons + 1);
                    }

                    // si hay un inicio mayor a 1, ponemos 1 y "..."
                    if (start > 1) {
                        $p.append(btn(1, 1));
                        if (start > 2) $p.append($('<div class="page-btn disabled">...</div>'));
                    }

                    for (var i = start; i <= end; i++) {
                        var cls = (i === activePage) ? 'active' : '';
                        $p.append(btn(i, i, cls));
                    }

                    // si hay resto, ponemos "..." y última
                    if (end < totalPages) {
                        if (end < totalPages - 1) $p.append($('<div class="page-btn disabled">...</div>'));
                        $p.append(btn(totalPages, totalPages));
                    }

                    // Next
                    var $next = btn('»', activePage + 1);
                    if (activePage === totalPages) $next.addClass('disabled');
                    $p.append($next);

                    // Evento click (delegación)
                    $p.off('click').on('click', '.page-btn', function() {
                        var $this = $(this);
                        if ($this.hasClass('disabled') || $this.hasClass('active')) return;
                        var toPage = $this.data('page');
                        if (typeof toPage === 'number') {
                            renderPage(toPage);
                            // scroll suave al grid (para UX)
                            $('html, body').animate({
                                scrollTop: $('#mytable').offset().top - 80
                            }, 200);
                        }
                    });
                }

                // --- eventos de búsqueda y cambio tamaño página ---
                $(document).ready(function() {
                    collectCards();
                    // Render inicial
                    renderPage(1);

                    // búsqueda: siempre vuelve a la página 1
                    $('#search').on('input', function() {
                        currentPage = 1;
                        renderPage(1);
                    });

                    // filtro "solo activos"
                    $('#filterActive').on('change', function() {
                        currentPage = 1;
                        renderPage(1);
                    });

                    // cambio tamaño de página
                    $('#pageSize').on('change', function() {
                        pageSize = parseInt($(this).val()) || 12;
                        currentPage = 1;
                        renderPage(1);
                    });

                    // Si el DOM cambia (p. ej. se recargan tarjetas), reconstruimos
                    var container = document.getElementById('mytable');
                    if (container) {
                        var mo = new MutationObserver(function() {
                            collectCards();
                            renderPage(1);
                        });
                        mo.observe(container, {
                            childList: true,
                            subtree: false
                        });
                    }

                    // primer ajuste layout
                    computeAndApply();
                });

            })();
        </script>
    </section>
</body>

</html>