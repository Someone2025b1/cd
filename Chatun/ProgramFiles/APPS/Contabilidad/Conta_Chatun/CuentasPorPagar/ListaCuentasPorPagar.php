<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
?>

<!DOCTYPE html>
<html lang="en">

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
            /* Si tu menubar tiene otro ancho, ajusta aquí */
            --menubar-default-width: 260px;
        }

        /* Asegura que el header esté siempre por encima */
        header,
        .header,
        .topbar,
        #header,
        .navbar {
            position: fixed;
            /* si ya lo es, no lo rompe */
            top: 0;
            left: 0;
            right: 0;
            z-index: 1060;
            /* > menubar */
        }

        /* Menubar: estilos base (se ajusta por JS) */
        #menubar {
            position: fixed;
            left: 0;
            bottom: 0;
            z-index: 1050;
            overflow-y: auto;
        }

        /* main-wrapper será empujado por JS (padding-top y margin-left) */
        #main-wrapper {
            transition: margin-left .18s ease, padding-top .18s ease;
        }


        /* Espaciado del buscador en móviles */
        .search-row {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* Ajustes esteticos y responsive cards */
        .app-card {
            padding: 8px;
        }

        .app-card .card {
            min-height: 180px;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .app-card .card .card-body {
            position: relative;
            padding: 1rem;
        }

        .btn-circle {
            border-radius: 50%;
            padding: 6px 8px;
        }

        /* responsive: en pantallas pequeñas el menubar offcanvas del tema debería venir por encima.
   si tu tema ya lo maneja, esto no interfiere. */
        @media (max-width: 991px) {
            #menubar {
                left: -100%;
            }

            /* offcanvas; el JS/resto del tema controla esto */
            #main-wrapper {
                margin-left: 0 !important;
                padding-top: 60px;
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
                        <input type="text" class="form-control" id="search" style="width:240px;display:inline-block;" placeholder="Buscar un aplicativo..">
                    </div>
                </div>

                <!-- Grid responsivo de apps -->
                <div class="row" id="mytable">
                    <?php
                    $Sql_Aplicativos = mysqli_query($db, "SELECT a.nombre, a.icono, a.link, a.id_aplicacion FROM info_bbdd.aplicaciones_agg a 
                    INNER JOIN info_bbdd.permisos_app b ON b.id_aplicacion = a.id_aplicacion 
                    WHERE b.id_user = $id_user AND b.estado = 1");
                    while ($Fila_Aplicativos = mysqli_fetch_array($Sql_Aplicativos)) {
                        $Icono = "../../../../APPS/IDT/Imagenes/Aplicaciones/" . $Fila_Aplicativos['icono'];
                        $Link  = "../../../../APPS/" . $Fila_Aplicativos['link'];
                    ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 app-card">
                            <a href="<?php echo $Link ?>">
                                <div class="card h-100">
                                    <div class="text-center p-3">
                                        <img src="<?php echo $Icono ?>" height="80" width="80" alt="icono">
                                    </div>
                                    <div class="card-body text-center">
                                        <button type="button"
                                            class="btn-sm btn <?php echo isset($ClaseFavorito) ? $ClaseFavorito : '' ?> btn-circle pull-right"
                                            onclick="MarcarFavorito(this)"
                                            value="<?php echo htmlspecialchars($Fila_Aplicativos['nombre'], ENT_QUOTES) ?>">
                                            <i class="fa fa-star"></i>
                                        </button>
                                        <h4 class="font-normal"><?php echo $Fila_Aplicativos['nombre'] ?></h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
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

        <!-- JS para ajustar layout dinámicamente y búsqueda -->
        <script>
            (function() {
                var main = document.getElementById('main-wrapper');
                var menubar = document.getElementById('menubar');
                // Intentamos detectar el header/top bar (varias opciones por si cambia el markup)
                var header = document.querySelector('header, .header, #header, .topbar');

                function computeAndApply() {
                    try {
                        // Detectamos elementos
                        var menubar = document.getElementById('menubar');
                        var main = document.getElementById('main-wrapper');
                        var header = document.querySelector('header, .header, #header, .topbar, .navbar'); // varias opciones

                        // Alto del header (fallback 0)
                        var headerHeight = header ? (header.getBoundingClientRect().height || 0) : 0;

                        // Ancho del menubar (solo si está "pinned")
                        var menubarWidth = 0;
                        if (document.body.classList.contains('menubar-pin') && menubar) {
                            menubarWidth = menubar.getBoundingClientRect().width || 0;
                            if (!menubarWidth) {
                                var fallback = getComputedStyle(document.documentElement).getPropertyValue('--menubar-default-width');
                                menubarWidth = parseInt(fallback) || 260;
                            }
                        }

                        // Aplicamos estilos:
                        if (menubar) {
                            // hacemos fijo el menubar y lo empujamos hacia abajo según headerHeight
                            menubar.style.position = 'fixed';
                            menubar.style.top = headerHeight + 'px';
                            // que ocupe el alto restante sin pasar por debajo del footer (si lo hay)
                            menubar.style.height = (window.innerHeight - headerHeight) + 'px';
                            menubar.style.overflowY = 'auto';
                            // z-index menor que header (para que header esté por encima)
                            menubar.style.zIndex = 1050;
                        }

                        if (main) {
                            // En pantallas grandes dejamos margen-left para que el contenido no quede bajo el menubar
                            if (window.innerWidth > 991) {
                                main.style.marginLeft = menubarWidth + 'px';
                            } else {
                                main.style.marginLeft = '0px';
                            }
                            // padding-top para que el contenido no quede bajo el header
                            main.style.paddingTop = headerHeight + 'px';
                        }
                    } catch (e) {
                        console.error('computeAndApply error', e);
                    }
                }


                // Ejecutar al cargar y al redimensionar
                window.addEventListener('load', computeAndApply);
                window.addEventListener('resize', computeAndApply);

                // Observamos cambios en atributos del body (por ejemplo, classes que cambien menubar-pin)
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

                // Si el menubar cambia tamaño dinámicamente, ajustamos (ej: colapsa/expande)
                if (menubar) {
                    var ro = new ResizeObserver(function() {
                        computeAndApply();
                    });
                    ro.observe(menubar);
                }

                // Búsqueda de aplicaciones (filtra los bloques .app-card)
                $(document).ready(function() {
                    $("#search").on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $(".app-card").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                        });
                    });

                    // Hacemos un primer ajuste en caso de que todo ya exista
                    computeAndApply();
                });
            })();
        </script>
    </section>
</body>

</html>