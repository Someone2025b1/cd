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
                                    <a class="btn-minimize text-success" onclick="AgregarSubMenu()"><i class="mdi mdi-plus"></i></a>
                                </div>
                                <h2 class="text-center">Administración SubMenu</h2>
                            </div>
                            <div class="card-body collapse show">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                            $Sql_Elementos_SubMenu = mysqli_query($db, $portal_coosajo_db, "SELECT A.*, B.MA_NOMBRE
                                                                                                        FROM portal_coosajo_db.SUBMENU_APLICATIVO AS A
                                                                                                        INNER JOIN portal_coosajo_db.MENU_APLICATIVO AS B ON A.MA_CODIGO = B.MA_CODIGO
                                                                                                        WHERE B.A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'");
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
                                                                <th data-sortable="true" data-field="MENU" data-filter-control="select"><h6><strong>MENU</strong></h6></th>
                                                                <th data-sortable="true" data-field="NOMBRE" data-filter-control="input"><h6><strong>NOMBRE</strong></h6></th>
                                                                <th data-sortable="true" data-field="PATH" data-filter-control="input"><h6><strong>PATH</strong></h6></th>
                                                                <th data-sortable="true" data-field="ORDEN" data-filter-control="input"><h6><strong>ORDEN</strong></h6></th>
                                                                <th data-sortable="false" data-field="ESTADO"><h6><strong>ESTADO</strong></h6></th>
                                                                <th data-sortable="false" data-field="ACC"><h6><strong></strong></h6></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            while($Fila_Elementos_SubMenu = mysqli_fetch_array($Sql_Elementos_SubMenu))
                                                            {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $Fila_Elementos_SubMenu["MA_NOMBRE"] ?></h6></td>
                                                                        <td><?php echo $Fila_Elementos_SubMenu["SMA_NOMBRE"] ?></td>
                                                                        <td><?php echo $Fila_Elementos_SubMenu["SMA_PATH"] ?></td>
                                                                        <td><?php echo $Fila_Elementos_SubMenu["SMA_ORDEN"] ?></td>
                                                                        <td>
                                                                            <div class="switch">
                                                                                <label><input value="<?php echo $Fila_Elementos_SubMenu['SMA_CODIGO'] ?>" onchange="ActivarInactivar(this)" type="checkbox" <?php if($Fila_Elementos_SubMenu["SMA_ESTADO"] == 1){echo 'checked';} ?>><span class="lever"></span></label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" data-toggle="tooltip" data-original-title="Editar" data-codigo="<?php echo $Fila_Elementos_SubMenu['SMA_CODIGO'] ?>" data-referencia-aplicativo="<?php echo $Referencia_Aplicacion_Menu ?>" onclick="Editar(this)"> <i class="fa fa-edit text-warning"></i> </a>
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

    <div class="modal fade in" id="ModalEditarSubMenu">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Editar SubMenu</h4>
                </div>
                <div class="modal-body">
                    <div id="DivResultadoSubMenu"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="GuardarEdicionMenu()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="ModalAgregarSubMenu">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Agregar SubMenu</h4>
                </div>
                <div class="modal-body">
                    <form class="form form-material" id="FRMAgregarSubMenu">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label for="Menu">Menu</label>
                                <select class="form-control" name="Menu" id="Menu" required>
                                    <option value="" disabled selected>SELECCIONE UN MENU</option>
                                    <?php
                                        $Sql_Menu_Agregar = mysqli_query($db, $portal_coosajo_db, "SELECT A.MA_CODIGO, A.MA_NOMBRE
                                                                                                    FROM portal_coosajo_db.MENU_APLICATIVO AS A
                                                                                                    WHERE A.A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'");
                                        while($Fila_Menu_Agregar = mysqli_fetch_array($Sql_Menu_Agregar))
                                        {
                                            ?>
                                                <option value="<?php echo $Fila_Menu_Agregar["MA_CODIGO"] ?>"><?php echo $Fila_Menu_Agregar["MA_NOMBRE"] ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" class="form-control" name="Nombre" id="Nombre" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 form-group">
                                <label for="Path">Path</label>
                                <input type="text" class="form-control" name="Path" id="Path" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 form-group">
                                <label for="Orden">Orden</label>
                                <input type="number" class="form-control" name="Orden" id="Orden" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="GuardarSubMenu()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
        include($_SERVER["DOCUMENT_ROOT"].'/includes/Scripts.php');
    ?>
    <script>
        function ActivarInactivar(x)
        {
            if($(x).is(':checked'))
            {
                $.ajax({
                    url: 'Ajax/ActivarInactivarSubMenu.php',
                    type: 'post',
                    data: 'SubMenu='+x.value+'&Tipo=1',
                    success: function (data) {
                        if(data != 1)
                        {
                            $.toast({
                                text: "No se pudo activar/inactivar el elemento del menú seleccionado. Comuníquese con IDT", // Text that is to be shown in the toast
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
                    url: 'Ajax/ActivarInactivarSubMenu.php',
                    type: 'post',
                    data: 'SubMenu='+x.value+'&Tipo=2',
                    success: function (data) {
                        if(data != 1)
                        {
                            $.toast({
                                text: "No se pudo activar/inactivar el elemento del menú seleccionado. Comuníquese con IDT", // Text that is to be shown in the toast
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
        function AgregarSubMenu()
        {
            $('#ModalAgregarSubMenu').modal('show');
        }
        function GuardarSubMenu()
        {
            if($('#FRMAgregarSubMenu')[0].checkValidity())
            {
                var FRMSerializado = $('#FRMAgregarSubMenu').serialize();

                $.ajax({
                        url: 'Ajax/GuardarSubMenu.php',
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
            var CodigoSubMenu = $(x).attr('data-codigo');
            var ReferenciaAplicacion = $(x).attr('data-referencia-aplicativo');

            $.ajax({
                    url: 'Ajax/ObtenerDatosSubMenu.php',
                    type: 'post',
                    data: 'CodigoSubMenu='+CodigoSubMenu+'&ReferenciaAplicacion='+ReferenciaAplicacion,
                    success: function (data) {
                        $('#DivResultadoSubMenu').html(data);
                        $('#ModalEditarSubMenu').modal('show');
                    }
                });
        }
        function GuardarEdicionMenu()
        {
            if($('#FRMEditarSubMenu')[0].checkValidity())
            {
                var FRMSerializado = $('#FRMEditarSubMenu').serialize();

                $.ajax({
                        url: 'Ajax/GuardarEdicionSubMenu.php',
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
</body>

</html>
