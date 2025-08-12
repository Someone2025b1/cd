<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
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

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->
	<style>

		.background {
		  
		  height: 100%;
		  width: 100%;
		}

		.progress {
    background-color: #e9ecef;
    border-radius: 5px;
    overflow: hidden;
}
.progress-bar {
    height: 100%;
    background-color: #28a745;
    transition: width 0.5s ease;
}
	</style>

	

</head>
<body onload="setInterval('ObtenerOrdenes()', 5000);">

	<!-- BEGIN BASE-->
	<div style="height: 100%;">

		<!-- BEGIN CONTENT-->
		<div class="background background-filter">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
	 
<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">

			<div class="card">
				<div class="card-body no-padding">
					<div class="margin-bottom-xxl">
						<h1 class="text-dark text-ultra-bold text-xxl text-light text-center no-margin">¡ORDENES LISTAS!</h1>
					</div>
					<ul class="list ui-sortable" id="ordenes-lista"></ul>

				</div>
			</div>
		</div>
</div>
			</div>
			<div class="col-lg-3"></div>
		</div>
		<!-- END CONTENT -->
	

	</div><!--end #base-->
	<!-- END BASE -->

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

	<script>
    let ordenesMostradas = {};

function ObtenerOrdenes() {
    $.ajax({
        url: 'obtener_ordenes.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(item) {
                const codigo = item.codigo;
                const numeroOrden = item.orden;

                if (!ordenesMostradas[codigo]) {
                    // Crear elemento de lista
                    const li = document.createElement("li");
                    li.className = "tile ui-sortable-handle text-center orden-" + codigo;

                    // Crear contenido con barra de progreso
                    li.innerHTML = `
                        <strong>
                            <h3 class="text-warning text-xxxxl">
                                <span class="text-warning fa fa-check"></span> ORDEN #${numeroOrden}
                            </h3>
                        </strong>
                        <div class="progress" style="height: 10px; margin: 10px 20px;">
                            <div id="barra-${codigo}" class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                                role="progressbar" style="width: 0%; transition: width 1s;"></div>
                        </div>
                    `;

                    document.getElementById("ordenes-lista").appendChild(li);
                    ordenesMostradas[codigo] = true;

                    // Iniciar barra de progreso
                    let progreso = 0;
                    const barra = document.getElementById("barra-" + codigo);
                    const intervalo = setInterval(() => {
                        progreso += 1;
                        barra.style.width = progreso + "%";

                        if (progreso >= 100) {
                            clearInterval(intervalo);
                            // Despachar orden
                            $.ajax({
                                url: 'despachar_orden.php',
                                type: 'POST',
                                data: { codigo:codigo },
                                success: function () {
                                    li.remove();
                                    delete ordenesMostradas[codigo];
                                }
                            });
                        }
                    }, 900); // 600 ms * 100 = 60 segundos
                }
            });
        }
    });
}

window.onload = function () {
    ObtenerOrdenes();
    setInterval(ObtenerOrdenes, 5000);
};
</script>




	</body>
	</html>
