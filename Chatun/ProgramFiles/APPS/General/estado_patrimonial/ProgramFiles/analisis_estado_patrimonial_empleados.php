<?php
header('Content-Type:text/html;charset=utf-8');
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>PORTAL COOSAJO, R.L. - Estado Patrimonial</title>

    <!-- CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/mint-admin.css" rel="stylesheet" />
    <link href="css/alertify.core.css" rel="stylesheet" />
    <link href="css/alertify.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../../../../../Script/TableFilter/filtergrid.css">
    <!-- <link rel="stylesheet" href="css/datepicker.css"> -->

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/alertify.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script type="text/javascript" src="../../../../../Script/TableFilter/tablefilter_all_min.js"></script>
    <script type="text/javascript" src="../../../../../Script/jquery.table2excel.js"></script>

    <!-- Mint Admin Scripts - Include with every page -->
    <script src="js/mint-admin.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8899-1">
    <script>
        function CalcularFechaInicio()
        {
            var FechaFin = $('#FechaFinal').val();
            var Xplot = FechaFin.split("-");
            var NuevoAnho = parseFloat(Xplot[0]) -1;
            var NuevaFecha = NuevoAnho+"-"+Xplot[1]+"-"+Xplot[2];
            $('#FechaInicio').val(NuevaFecha);
        }
        function CargarElementos()
        {

            $('#tbl_resultados > tbody').empty();
            var FechaInicio = $('#FechaInicio').val();
            var FechaFinal = $('#FechaFinal').val();

            $('#FIA').val(FechaInicio);
            $('#FFA').val(FechaFinal);

            $.ajax({
                url: 'LlenarTablaAnalisisEP.php',
                type: 'post',
                data: 'FechaInicio='+FechaInicio+'&FechaFinal='+FechaFinal,
                beforeSend: function()
                {
                    $('#ModalLOAD').modal("show");
                    $('#suggestions').html('<img src="../Imagenes/screens-preloader.gif" />');
                    $('#ModalLOAD').modal("hide");
                },
                success: function(output)
                {
                    $('#Resultados').html(output);
                    var tbl_filtrado =  { 
                        mark_active_columns: true,
                        highlight_keywords: true,
                        filters_row_index:1,
                    paging: true,             //paginar 3 filas por pagina
                    rows_counter: true,      //mostrar cantidad de filas
                    rows_counter_text: "Registros: ", 
                    page_text: "Página:",
                    of_text: "de",
                    btn_reset: true, 
                    loader: true, 
                    loader_html: "<img src='../../../../../Script/TableFilter/img_loading.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
                    display_all_text: "-Todos-",
                    results_per_page: ["# Filas por Página...",[10,25,50,100]],  
                    btn_reset: true,
                    col_2: "select",
                    col_3: "disabled",
                    col_4: "disabled",
                    col_5: "disabled",
                    col_6: "disabled",
                    col_7: "disabled",
                    col_8: "disabled",
                    col_9: "disabled",
                    col_10: "disabled",
                    col_11: "disabled",
                    col_12: "disabled"
                };

                var tf = setFilterGrid('tbl_resultados', tbl_filtrado);

                $("#DIVImprimir").show();
                },
                error: function()
                {
                    alertify.error('Algo salió mal');
                }
            });
        }
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover(); 
        });
    </script>

</head>

<body style="background-color: #FFFFFF" onload="CalcularFechaInicio()">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title" align="center">
				<h3><strong>Estado Patrimonial de Empleados</strong></h3>
			</div>
		</div>
		<div class="panel-body">
            <div class="container-fluid" align="center"><h4><strong>Análisis de Estados Patrimoniales de Empleados de Coosajo R.L.</strong></h4></div>
            <div><br></div>
            <div class="container-fluid" align="center">
                <form class="form-horizontal">
                    <label for="FechaInicio" class="col-lg-3 label-control text-right">Fecha Inicio</label>
                    <div class="col-lg-3" align="left">
                        <input type="date" class="form-control" size="9" name="FechaInicio" id="FechaInicio" value="<?php echo date('Y-m-d'); ?>" required/>
                    </div>
                    <label for="FechaFinal" class="col-lg-3 label-control text-right">Fecha Final</label>
                    <div class="col-lg-3" align="left">
                        <input type="date" class="form-control" size="9" name="FechaFinal" id="FechaFinal" value="<?php echo date('Y-m-d'); ?>" required/>
                    </div>
                </form>
                <br>
                <div class="container-fluid">
                    <button type="button" class="btn btn-primary btn-md" onclick="CargarElementos()">
                        <span class="glyphicon glyphicon-export"></span> Cargar Datos
                    </button>
                </div>
            </div>
            <div class="row">
                <br>
                <div class="conteiner-fluid text-center">
                    <h4><b>Nomenclatura</b></h4><span class="help-block"><a title="Nomenclatura" data-toggle="popover" data-trigger="hover" data-content="N/A FI: Fecha Ingreso del colaborador, menor a fecha inicial de análisis. N/A EP<1: El colaborador cuenta sólo con un registro de sus estados patrimoniales en la fecha del análisis."><i class="fa fa-question-circle fa-fw fa-2x"></i></a></span>
                </div>
            </div>
            <div class="container-fluid">
                <table class="table table-condensed table2excel" data-tableName="Tabla Analisis" id="tbl_resultados" cellpadding="0">
                    <thead>
                        <tr>
                            <th colspan="4" class="text-right">
                                <h6><strong>Activos</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Pasivos</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Patrimonio</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Activos</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Pasivos</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Patrimonio</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Incre/Decre</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Factor Riesgo</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Riesgo</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Factor Riesgo</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Total</strong></h6>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>CIF</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Nombre</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Puesto</strong></h6>
                            </th>
                            <th>
                                <h6><strong>A</strong></h6>
                            </th>
                            <th>
                                <h6><strong>A</strong></h6>
                            </th>
                            <th>
                                <h6><strong>A</strong></h6>
                            </th>
                            <th>
                                <h6><strong>B</strong></h6>
                            </th>
                            <th>
                                <h6><strong>B</strong></h6>
                            </th>
                            <th>
                                <h6><strong>B</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Patrimonio</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Patrimonio</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Crecimiento Activos</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Crecimiento Activos</strong></h6>
                            </th>
                            <th>
                                <h6><strong>Riesgo</strong></h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="Resultados">
                        
                    </tbody>
                </table>
            </div>
            <div class="container-fluid" align="center" id="DIVImprimir" style="display: none">
                <button type="button" class="btn btn-default btn-md">
                <span class="glyphicon glyphicon-print"></span> <a href="reporte_empleados_analisis-PDF.php" target="_blank" style="font-color: #FFFFFF">Imprimir Alertas Generadas</a>
                </button>
                <button type="button" class="btn btn-default btn-md" onclick="ExportarTabla()">
                <span class="glyphicon glyphicon-download-alt"></span> Exportar Tabla
                </button>
                <button type="button" class="btn btn-default btn-md" onclick="GenerarConstancias()">
                <span class="glyphicon glyphicon-inbox"></span> Generar Constancias
                </button>
                
            </div>
        </div>
    </div>
    <div id="ModalLOAD" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="suggestions" align="center"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="ModalGenerarConstancias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Generar Constancias</h2>
                    </div>
                    <div class="modal-body">
                       <div class="container">
                       <form method="POST" action="GenerarConstancias.php" target="_blank">
                           <div class="form-group">
                                <label for="FechaAnalisis">Fecha de Análisis</label>
                               <input class="form-control" type="date" name="FechaAnalisis" value="<?php echo date('Y-m-d', strtotime('now')); ?>">
                               <input class="form-control" type="hidden" name="FIA" id="FIA">
                               <input class="form-control" type="hidden" name="FFA" id="FFA">
                           </div>
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-md">Generar
                        </button>
                    </div>
                       </form>
                </div>
            </div>
        </div>

    <script>
            function ExportarTabla(){
                $(".table2excel").table2excel({
                    exclude: ".noExl",
                    name: "Tabla de Analisis",
                    filename: "Analisis_Tabla"
                });
            }
            function GenerarConstancias()
            {
                $('#FIA').val($('#FechaInicio').val());
                $('#FFA').val($('#FechaFinal').val());
                $('#ModalGenerarConstancias').modal('show');
            }
        </script>
</body>

</html>
