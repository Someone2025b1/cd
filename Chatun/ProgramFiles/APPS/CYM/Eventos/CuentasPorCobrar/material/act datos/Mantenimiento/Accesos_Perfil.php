<!DOCTYPE html>
<html lang="en">

<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");
    include($_SERVER["DOCUMENT_ROOT"]."/includes/Header.php");
?>

<body class="fix-header card-no-border">
    
    <div id="main-wrapper">
        <?php
            include($_SERVER["DOCUMENT_ROOT"].'/includes/Head.php');
include($_SERVER["DOCUMENT_ROOT"]."/App/253_ActualizacionDatos/Menu/Menu.php");
        ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-actions">
                                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                                </div>
                                <h2 class="text-center">Administración Accesos a Perfiles Aplicativo</h2>
                            </div>
                            <div class="card-body collapse show">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                            $Sql_Elementos_SubMenu = mysqli_query($db, $portal_coosajo_db, "SELECT *
                                                                                                        FROM portal_coosajo_db.PRIVILEGIO_APLICATIVO AS A
                                                                                                        WHERE A.PA_ESTADO = 1
                                                                                                        AND A.A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'");
                                            $Registros_Elementos_SubMenu = mysqli_num_rows($Sql_Elementos_SubMenu);

                                            if($Registros_Elementos_SubMenu > 0)
                                            {
                                                ?>
                                                    <table id="TableMenu" class="table table-hover table-condensed"
                                                            data-toggle="table"
                                                            data-toolbar="#toolbar"
                                                            data-show-export="false"
                                                            data-icons-prefix="fa"
                                                            data-icons="icons"
                                                            data-pagination="true"
                                                            data-sortable="true"
                                                            data-search="true"
                                                            data-filter-control="true">
                                                        <thead>
                                                            <tr>
                                                                <th data-sortable="true" data-field="PERFIL" data-filter-control="input"><h6><strong>PERFIL</strong></h6></th>
                                                                <th data-sortable="false" data-field="ACC"><h6><strong></strong></h6></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            while($Fila_Elementos_SubMenu = mysqli_fetch_array($Sql_Elementos_SubMenu))
                                                            {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $Fila_Elementos_SubMenu["PA_NOMBRE"].' - '.$Fila_Elementos_SubMenu["PA_DESCRIPCION"] ?></h6></td>
                                                                        <td>
                                                                            <a href="Accesos_Perfil_Detalle.php?Codigo=<?php echo $Fila_Elementos_SubMenu["PA_CODIGO"] ?>&Nombre=<?php echo $Fila_Elementos_SubMenu["PA_NOMBRE"] ?>" data-toggle="tooltip" data-original-title="Detalle"> <i class="fa fa-search text-primary"></i> </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                    <div class="alert alert-info">
                                                        <h3 class="text-info"><i class="fa fa-exclamation-circle"></i> Información</h3>No se encontró ningún registro.
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        include($_SERVER["DOCUMENT_ROOT"].'/includes/Scripts.php');
    ?>
</body>

</html>
