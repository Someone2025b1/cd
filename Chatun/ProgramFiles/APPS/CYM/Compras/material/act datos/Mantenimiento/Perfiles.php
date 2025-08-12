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
                                    <a class="btn-minimize text-success" onclick="AgregarPerfil()"><i class="mdi mdi-plus"></i></a>
                                </div>
                                <h2 class="text-center">Administración Perfiles</h2>
                            </div>
                            <div class="card-body collapse show">
                                <div class="row">
                                    <div class="col-md-12">
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
                                                    <th data-sortable="true" data-field="DESCRIPCION" data-filter-control="input"><h6><strong>DESCRIPCIÓN</strong></h6></th>
                                                    <th data-sortable="false" data-field="ESTADO"><h6><strong>ESTADO</strong></h6></th>
                                                    <th data-sortable="false" data-field="ACC"><h6><strong></strong></h6></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $Sql_Privilegio = mysqli_query($db, $portal_coosajo_db, "SELECT *
                                                                                                            FROM portal_coosajo_db.PRIVILEGIO_APLICATIVO AS A
                                                                                                            WHERE A.A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'");
                                                while($Fila_Privilegio = mysqli_fetch_array($Sql_Privilegio))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $Fila_Privilegio["PA_NOMBRE"] ?></h6></td>
                                                            <td><?php echo $Fila_Privilegio["PA_DESCRIPCION"] ?></td>
                                                            <td>
                                                                <div class="switch">
                                                                    <label><input value="<?php echo $Fila_Privilegio['PA_CODIGO'] ?>" onchange="ActivarInactivar(this)" type="checkbox" <?php if($Fila_Privilegio["PA_ESTADO"] == 1){echo 'checked';} ?>><span class="lever"></span></label>
                                                                </div>
                                                            </td>
                                                            <td style="font-size: 25px">
                                                                <a href="#" data-toggle="tooltip" data-original-title="Editar" data-codigo="<?php echo $Fila_Privilegio['PA_CODIGO'] ?>" onclick="Editar(this)"> <i class="fa fa-edit text-warning"></i> </a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="ModalEditarPerfil">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Editar Menu</h4>
                </div>
                <div class="modal-body">
                    <div id="DivResultadoMenu"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="GuardarEdicionPerfil()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="ModalAgregarPerfil">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Agregar Menu</h4>
                </div>
                <div class="modal-body">
                    <form class="form form-material" id="FRMAgregarPerfil">
                        <input type="hidden" name="AplicativoPerfil" id="AplicativoPerfil" value="<?php echo $Referencia_Aplicacion_Menu ?>">
                        <div class="row">
                            <div class="col-lg-4 form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" class="form-control" name="Nombre" id="Nombre" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label for="Descripcion">Descripción</label>
                                <input type="text" class="form-control" name="Descripcion" id="Descripcion" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="GuardarPerfil()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
        include($_SERVER["DOCUMENT_ROOT"].'/includes/Scripts.php');
    ?>

</body>

<script>
    function AgregarPerfil()
        {
            $('#ModalAgregarPerfil').modal('show');
        }
    function GuardarPerfil()
        {
            if($('#FRMAgregarPerfil')[0].checkValidity())
            {
                var FRMSerializado = $('#FRMAgregarPerfil').serialize();

                $.ajax({
                        url: 'Ajax/GuardarPerfil.php',
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
                                    text: "No se pudo guardar el menú, comuníquese con IDT", // Text that is to be shown in the toast
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
        function Editar(x)
        {
            var CodigoPerfil = $(x).attr('data-codigo');

            $.ajax({
                    url: 'Ajax/ObtenerDatosPerfil.php',
                    type: 'post',
                    data: 'CodigoPerfil='+CodigoPerfil,
                    success: function (data) {
                        $('#DivResultadoMenu').html(data);
                        $('#ModalEditarPerfil').modal('show');
                    }
                });
        }
        function ActivarInactivar(x)
        {
            if($(x).is(':checked'))
            {
                $.ajax({
                    url: 'Ajax/ActivarInactivarPerfil.php',
                    type: 'post',
                    data: 'Perfil='+x.value+'&Tipo=1',
                    success: function (data) {
                        if(data != 1)
                        {
                            $.toast({
                                text: "No se pudo activar/inactivar el elemento del Perfil seleccionado. Comuníquese con IDT", // Text that is to be shown in the toast
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
                $.ajax({
                    url: 'Ajax/ActivarInactivarPerfil.php',
                    type: 'post',
                    data: 'Perfil='+x.value+'&Tipo=2',
                    success: function (data) {
                        if(data != 1)
                        {
                            $.toast({
                                text: "No se pudo activar/inactivar el elemento del Perfil seleccionado. Comuníquese con IDT", // Text that is to be shown in the toast
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
        }
        function GuardarEdicionPerfil()
        {
            if($('#FRMEditarMenu')[0].checkValidity())
            {
                var FRMSerializado = $('#FRMEditarMenu').serialize();

                $.ajax({
                        url: 'Ajax/GuardarEdicionPerfil.php',
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
                                    text: "No se puedo guardar la información, comuníquese con IDT", // Text that is to be shown in the toast
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
</script>

</html>
