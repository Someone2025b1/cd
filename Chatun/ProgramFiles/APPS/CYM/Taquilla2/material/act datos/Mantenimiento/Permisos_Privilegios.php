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
                                <h2 class="text-center">Asignación de Perfiles de Aplicativo a Usuarios</h2>
                            </div>
                            <div class="card-body collapse show">
                                <form id="FRMAsignarPerfil">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="Colaborador">Colaborador</label>
                                            <select class="form-control selectpicker" data-live-search="true" id="Colaborador" name="Colaborador" onchange="ObtenerPerfilColabroador(this.value)">
                                                <option value="" disabled selected>SELECCIONE UN COLABORADOR</option>
                                                <?php
                                                    $Sql_Colaborador = mysqli_query($db, $portal_coosajo_db, "SELECT A.cif, A.Nombres_Completos
                                                                                                        FROM info_colaboradores.vista_colaboradores_idt AS A
                                                                                                        WHERE A.estado = 'Activo'
                                                                                                        AND A.cif NOT IN (SELECT PAC.PAC_COLABORADOR
                                                                                                                        FROM portal_coosajo_db.PRIVILEGIO_APLICATIVO_COLABORADOR AS PAC
                                                                                                                        INNER JOIN portal_coosajo_db.PRIVILEGIO_APLICATIVO AS PA ON PAC.PA_CODIGO = PA.PA_CODIGO
                                                                                                                        WHERE PA.A_REFERENCIA = '".$Referencia_Aplicacion_Menu."')
                                                                                                        ORDER BY A.Nombres_Completos");
                                                    while($Fila_Desarrollador = mysqli_fetch_array($Sql_Colaborador))
                                                    {
                                                        ?>
                                                            <option value="<?php echo $Fila_Desarrollador['cif'] ?>"><?php echo $Fila_Desarrollador['Nombres_Completos'] ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="PerfilActual">PerfilActual</label>
                                            <input type="text" class="form-control" name="PerfilActual" id="PerfilActual" value="Seleccione un Colaborador" required readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="NuevoPerfil">Nuevo Perfil</label>
                                            <select class="form-control selectpicker" data-live-search="true" id="NuevoPerfil" name="NuevoPerfil" required>
                                                <option value="" disabled selected>SELECCIONE UN PERFIL</option>
                                                <?php
                                                    $Sql_Perfil_Asignacion = mysqli_query($db, $portal_coosajo_db, "SELECT *
                                                                                                            FROM portal_coosajo_db.PRIVILEGIO_APLICATIVO AS A
                                                                                                            WHERE A.PA_ESTADO = 1
                                                                                                            AND A.A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'");
                                                    while($Fila_Perfil_Asignacion = mysqli_fetch_array($Sql_Perfil_Asignacion))
                                                    {
                                                        ?>
                                                            <option value="<?php echo $Fila_Perfil_Asignacion['PA_CODIGO'] ?>"><?php echo $Fila_Perfil_Asignacion['PA_NOMBRE'] ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <button onclick="AgregarPerfilColaborador()" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Asignar Perfil</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-lg-12">
                                    <br>
                                    <br>
                                    <div class="card">
                                        <div class="card-header">
                                            Perfiles de Aplicativo Asignados a Colaboradores
                                            <div class="card-actions">
                                                <a class="" data-action="collapse"><i class="ti-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body collapse">
                                            <?php
                                                $Sql_Perfiles_Asignados = mysqli_query($db, $portal_coosajo_db, "SELECT A.*, B.PA_NOMBRE
                                                                                                            FROM portal_coosajo_db.PRIVILEGIO_APLICATIVO_COLABORADOR AS A
                                                                                                            INNER JOIN portal_coosajo_db.PRIVILEGIO_APLICATIVO AS B ON A.PA_CODIGO = B.PA_CODIGO
                                                                                                            WHERE B.A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'");
                                                $Registros_Perfiles_Asignados = mysqli_num_rows($Sql_Perfiles_Asignados);

                                                if($Registros_Perfiles_Asignados > 0)
                                                {
                                                    ?>
                                                        <table class="table table-hover table-condensed"
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
                                                                    <th data-sortable="true" data-field="CIF" data-filter-control="input">CIF</th>
                                                                    <th data-sortable="true" data-field="NOMBRE" data-filter-control="input">NOMBRE</th>
                                                                    <th data-sortable="true" data-field="PERFILASIGNADO" data-filter-control="select">PERFIL ASIGNADO</th>
                                                                    <th data-sortable="false" data-field="ACC"><h6><strong></strong></h6></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                                while($Fila_Perfiles_Asignados = mysqli_fetch_array($Sql_Perfiles_Asignados))
                                                                {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $Fila_Perfiles_Asignados["PAC_COLABORADOR"] ?></td>
                                                                            <td><?php echo saber_nombre_asociado_orden($Fila_Perfiles_Asignados["PAC_COLABORADOR"]) ?></td>
                                                                            <td><?php echo $Fila_Perfiles_Asignados["PA_NOMBRE"] ?></td>
                                                                            <td>
                                                                                <div class="switch">
                                                                                    <label><input value="<?php echo $Fila_Perfiles_Asignados['PAC_CODIGO'] ?>" onchange="ActivarInactivar(this)" type="checkbox" <?php if($Fila_Perfiles_Asignados["PAC_ESTADO"] == 1){echo 'checked';} ?>><span class="lever"></span></label>
                                                                                </div>
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
                                                            <h3 class="text-info"><i class="fa fa-exclamation-circle"></i> Información</h3> 
                                                            No existen perfiles de aplicativo asignados a un colaborador.
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
    </div>
    <?php
        include($_SERVER["DOCUMENT_ROOT"].'/includes/Scripts.php');
    ?>
    <script>
        function ObtenerPerfilColabroador(x)
        {
            $.ajax({
                    url: 'Ajax/ObtenerPerfilColabroador.php',
                    type: 'post',
                    data: 'Colaborador='+x,
                    success: function (data) {
                        $('#PerfilActual').val(data);
                    }
                });
        }
        function AgregarPerfilColaborador()
        {
            if($('#FRMAsignarPerfil')[0].checkValidity())
            {
                var FRMSerializado = $('#FRMAsignarPerfil').serialize();

                $.ajax({
                        url: 'Ajax/GuardarPerfilColaboradorAplicativo.php',
                        type: 'post',
                        data: FRMSerializado,
                        success: function (data) {
                            if(data == 1)
                            {
                                window.location.reload();
                            }
                            else
                            {
                                $.toast({
                                    text: "Hubo un error al tratar de agregar el perfil al colaborador", // Text that is to be shown in the toast
                                    heading: 'Información', // Optional heading to be shown on the toast
                                    icon: 'error', // Type of toast icon
                                    showHideTransition: 'fade', // fade, slide or plain
                                    allowToastClose: false, // Boolean value true or false
                                    hideAfter: 5000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                    stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                                    position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                                    textAlign: 'left',  // Text alignment i.e. left, right or center
                                    loader: true,  // Whether to show loader or not. True by default
                                    loaderBg: '#9EC600',  // Background color of the toast loader
                                });
                            }
                        }
                    });
            }
            else
            {
                $.toast({
                    text: "Antes de continuar, llene todos los campos", // Text that is to be shown in the toast
                    heading: 'Información', // Optional heading to be shown on the toast
                    icon: 'error', // Type of toast icon
                    showHideTransition: 'fade', // fade, slide or plain
                    allowToastClose: false, // Boolean value true or false
                    hideAfter: 5000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                    stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                    position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                    textAlign: 'left',  // Text alignment i.e. left, right or center
                    loader: true,  // Whether to show loader or not. True by default
                    loaderBg: '#9EC600',  // Background color of the toast loader
                });
            }
        }
        function ActivarInactivar(x)
        {
            if($(x).is(':checked'))
            {
                $.ajax({
                    url: 'Ajax/ActivarInactivarPerfilAsignado.php',
                    type: 'post',
                    data: 'Perfil='+x.value+'&Tipo=1',
                    success: function (data) {
                        if(data == 1)
                        {
                            window.location.reload();
                        }
                    }
                });
            }
            else
            {
                $.ajax({
                    url: 'Ajax/ActivarInactivarPerfilAsignado.php',
                    type: 'post',
                    data: 'Perfil='+x.value+'&Tipo=2',
                    success: function (data) {
                        if(data == 1)
                        {
                            window.location.reload();
                        }
                    }
                });
            }
        }
    </script>
</body>

</html>
