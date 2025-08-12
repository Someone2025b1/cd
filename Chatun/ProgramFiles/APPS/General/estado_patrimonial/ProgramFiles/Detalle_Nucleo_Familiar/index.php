<?php
header('Content-Type:text/html;charset=utf-8');
session_start();
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/funciones.php");
include("../../../../../../Script/conex.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>PORTAL COOSAJO, R.L. - DETALLE DE NUCLEO FAMILIAR</title>

    <!-- CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet" />
    <link href="../css/font-awesome.min.css" rel="stylesheet" />
    <link href="../css/mint-admin.css" rel="stylesheet" />
    <link href="../css/alertify.core.css" rel="stylesheet" />
    <link href="../css/alertify.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="../js/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../../../../../../Script/TableFilter/filtergrid.css">
    <!-- <link rel="stylesheet" href="../css/datepicker.css"> -->

    <!-- Core Scripts - Include with every page -->
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/alertify.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script type="text/javascript" src="../../../../../../Script/TableFilter/tablefilter_all_min.js"></script>
    <script type="text/javascript" src="../../../../../../Script/jquery.table2excel.js"></script>

    <!-- Mint Admin Scripts - Include with every page -->
    <script src="../js/mint-admin.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8899-1">
</head>

<body style="background-color: #FFFFFF">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title" align="center">
				<h3><strong>Detalle de Núcleo Familiar</strong></h3>
			</div>
		</div>
		<div class="panel-body">
            <table class="table table-hover table-condensed" id="tbl_resultados">
                <thead>
                    <tr>
                        <th><h6><strong>CIF Colaborador</strong></h6></th>
                        <th><h6><strong>Nombre Colaborador</strong></h6></th>
                        <th><h6><strong>CIF Pariente</strong></h6></th>
                        <th><h6><strong>Nombre Pariente</strong></h6></th>
                        <th><h6><strong>Parentesco</strong></h6></th>
                        <th><h6><strong>Grado de Consanguinidad</strong></h6></th>
                        <th><h6><strong>Depende de Usted</strong></h6></th>
                        <th><h6><strong>Vive con Usted</strong></h6></th>
                        <th><h6><strong>Fecha Nacimiento (Hijo)</strong></h6></th>
                        <th><h6><strong>Dirección (Hijo)</strong></h6></th>
                        <th><h6><strong>Ocupación</strong></h6></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $Consulta = "SELECT * FROM coosajo_base_patrimonio.detalle_parentescos  ORDER BY colaborador";
                        $Resultado = mysqli_query($db, $Consulta);
                        while($row = mysqli_fetch_array($Resultado))
                        {
                            if($row["dependiente"] == '2' || $row["dependiente"] == 'No')
                            {
                                $Dependiente = 'No';
                            }
                            else
                            {
                                $Dependiente = 'Si';
                            }

                            if($row["vive"] == '')
                            {
                                $Vive = 'No';
                            }
                            else
                            {
                                $Vive = 'Si';
                            }

                            if($row["fecha_nacimiento_hijo"] = '0000-00-00')
                            {
                                $FechaNacimiento = '----------';
                            }
                            else
                            {
                                $FechaNacimiento = date('d-m-Y', strtotime($row["fecha_nacimiento_hijo"]));
                            }

                            if($row["tipo_persona"] == 1)
                            {
                               $NombreParentesco = saber_nombre_asociado($row["cif"]);
                            }
                            else
                            {
                                $NombreParentesco = $row["nombre_no_asociado"];
                            }

                            echo '<tr>';
                                echo '<td><h6>'.$row["colaborador"].'</h6</td>';
                                echo '<td><h6>'.saber_nombre_asociado($row["colaborador"]).'</h6</td>';
                                echo '<td><h6>'.$row["cif"].'</h6</td>';
                                echo '<td><h6>'.$NombreParentesco.'</h6</td>';
                                echo '<td><h6>'.$row["parentesco"].'</h6</td>';
                                echo '<td><h6>'.$row["grado_consaguinidad"].'</h6</td>';
                                echo '<td><h6>'.$Dependiente.'</h6</td>';
                                echo '<td><h6>'.$Vive.'</h6</td>';
                                echo '<td><h6>'.$FechaNacimiento.'</h6</td>';
                                echo '<td><h6>'.$row["direccion_hijo"].'</h6</td>';
                                echo '<td><h6>'.$row["ocupacion"].'</h6</td>';
                            echo '</tr>';                    
                        }
                    ?>
                </tbody>
            </table>
            <script>
                var tbl_filtrado =  { 
                        mark_active_columns: true,
                        highlight_keywords: true,
                        filters_row_index:1,
                    paging: true,             //paginar 3 filas por pagina
                    paging_length: 20,  
                    rows_counter: true,      //mostrar cantidad de filas
                    rows_counter_text: "Registros: ", 
                    page_text: "Página:",
                    of_text: "de",
                    btn_reset: true, 
                    loader: true, 
                    loader_html: "<img src='../../../../../../Script/TableFilter/img_loading.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
                    display_all_text: "-Todos-",
                    results_per_page: ["# Filas por Página...",[10,20,50,100]],  
                    btn_reset: true,
                    col_4: "select",
                    col_5: "select",
                    col_6: "select",
                    col_7: "select",
                    col_8: "disabled",
                    col_9: "disabled",
                    col_10: "disabled"
                };

                var tf = setFilterGrid('tbl_resultados', tbl_filtrado);
            </script>
        </div>
    </div>
</body>

</html>
