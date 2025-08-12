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
                                    <a class="btn-minimize text-success" onclick="AgregarMenu()"><i class="mdi mdi-plus"></i></a>
                                </div>
                                <h2 class="text-center">Administración Menú</h2>
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
                                                    <th data-sortable="true" data-field="NOMBRE" data-filter-control="input"><h6><strong>NOMBRE</strong></h6></th>
                                                    <th data-sortable="true" data-field="ICONO" data-filter-control="input"><h6><strong>ICONO</strong></h6></th>
                                                    <th data-sortable="true" data-field="GERENCIA" data-filter-control="select"><h6><strong>GERENCIA</strong></h6></th>
                                                    <th data-sortable="true" data-field="DEPARTAMENTO" data-filter-control="select"><h6><strong>DEPARTAMENTO</strong></h6></th>
                                                    <th data-sortable="true" data-field="ORDEN" data-filter-control="select"><h6><strong>ORDEN</strong></h6></th>
                                                    <th data-sortable="false" data-field="ESTADO"><h6><strong>ESTADO</strong></h6></th>
                                                    <th data-sortable="false" data-field="ACC"><h6><strong></strong></h6></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $Sql_Elementos_Menu = mysqli_query($db, $portal_coosajo_db, "SELECT A.*, C.gerencia
                                                                                                        FROM portal_coosajo_db.MENU_APLICATIVO AS A 
                                                                                                        LEFT JOIN info_base.departamentos AS B ON A.MA_DEPARTAMENTO = B.id_depto
                                                                                                        LEFT JOIN info_base.gerencias AS C ON B.id_gerencia = C.id_gerencia
                                                                                                        WHERE A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'");
                                                while($Fila_Elementos_Menu = mysqli_fetch_array($Sql_Elementos_Menu))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $Fila_Elementos_Menu["MA_NOMBRE"] ?></h6></td>
                                                            <td style="font-size: 25px"><i class="<?php echo $Fila_Elementos_Menu["MA_ICONO_MENU"] ?>"></i></td>
                                                            <td><?php echo utf8_encode($Fila_Elementos_Menu["gerencia"]) ?></td>
                                                            <td><?php echo utf8_encode(saber_nombre_departamento_coosajo($Fila_Elementos_Menu["MA_DEPARTAMENTO"])) ?></td>
                                                            <td><?php echo $Fila_Elementos_Menu["MA_ORDEN_MENU"] ?></td>
                                                            <td>
                                                                <div class="switch">
                                                                    <label><input value="<?php echo $Fila_Elementos_Menu['MA_CODIGO'] ?>" onchange="ActivarInactivar(this)" type="checkbox" <?php if($Fila_Elementos_Menu["MA_ESTADO"] == 1){echo 'checked';} ?>><span class="lever"></span></label>
                                                                </div>
                                                            </td>
                                                            <td style="font-size: 25px">
                                                                <a href="#" data-toggle="tooltip" data-original-title="Editar" data-codigo="<?php echo $Fila_Elementos_Menu['MA_CODIGO'] ?>" onclick="Editar(this)"> <i class="fa fa-edit text-warning"></i> </a>
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

    <div class="modal fade in" id="ModalEditarMenu">
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
                    <button type="button" class="btn btn-primary" onclick="GuardarEdicionMenu()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="ModalAgregarMenu">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Agregar Menu</h4>
                </div>
                <div class="modal-body">
                    <form class="form form-material" id="FRMAgregarMenu">
                        <input type="hidden" name="AplicativoMenu" id="AplicativoMenu" value="<?php echo $Referencia_Aplicacion_Menu ?>">
                        <div class="row">
                            <div class="col-lg-10 form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" class="form-control" name="Nombre" id="Nombre" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label for="Icono">Icono</label>
                                <input type="text" class="form-control" name="Icono" id="Icono" required>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label for="Orden">Orden</label>
                                <input type="number" class="form-control" name="Orden" id="Orden" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label for="Departamento">Departamento</label>
                                <select class="form-control" name="Departamento" id="Departamento" onchange="ObtenerNombreGerencia(this.value)" required>
                                    <option value="" disabled selected>SELECCIONE UN DEPARTAMENTO</option>
                                    <?php
                                        $Sql_Departamento_Menu = mysqli_query($db, $portal_coosajo_db, "SELECT A.id_depto, A.nombre_depto
                                                                                                    FROM info_base.departamentos AS A
                                                                                                    ORDER BY A.nombre_depto");
                                        while($Fila_Departamento_Menu = mysqli_fetch_array($Sql_Departamento_Menu))
                                        {
                                            ?>
                                                <option value="<?php echo $Fila_Departamento_Menu["id_depto"] ?>"><?php echo $Fila_Departamento_Menu["nombre_depto"] ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label for="Gerencia">Gerencia</label>
                                <input type="text" class="form-control" name="Gerencia" id="Gerencia" required readonly>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="GuardarMenu()">Guardar</button>
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
                    url: 'Ajax/ActivarInactivarMenu.php',
                    type: 'post',
                    data: 'Menu='+x.value+'&Tipo=1',
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
                    url: 'Ajax/ActivarInactivarMenu.php',
                    type: 'post',
                    data: 'Menu='+x.value+'&Tipo=2',
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
        function AgregarMenu()
        {
            $('#ModalAgregarMenu').modal('show');
        }
        function GuardarMenu()
        {
            if($('#FRMAgregarMenu')[0].checkValidity())
            {
                var FRMSerializado = $('#FRMAgregarMenu').serialize();

                $.ajax({
                        url: 'Ajax/GuardarMenu.php',
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
            var CodigoMenu = $(x).attr('data-codigo');

            $.ajax({
                    url: 'Ajax/ObtenerDatosMenu.php',
                    type: 'post',
                    data: 'CodigoMenu='+CodigoMenu,
                    success: function (data) {
                        $('#DivResultadoMenu').html(data);
                        $('#ModalEditarMenu').modal('show');
                    }
                });
        }
        function ObtenerNombreGerencia(x)
        {
            $.ajax({
                    url: 'Ajax/ObtenerNombreGerencia.php',
                    type: 'post',
                    data: 'CodigoDepartamento='+x,
                    success: function (data) {
                        $('#Gerencia').val(data);
                    }
                });
        }
        function ObtenerNombreGerenciaEditar(x)
        {
            $.ajax({
                    url: 'Ajax/ObtenerNombreGerencia.php',
                    type: 'post',
                    data: 'CodigoDepartamento='+x,
                    success: function (data) {
                        $('#GerenciaEditar').val(data);
                    }
                });
        }
        function GuardarEdicionMenu()
        {
            if($('#FRMEditarMenu')[0].checkValidity())
            {
                var FRMSerializado = $('#FRMEditarMenu').serialize();

                $.ajax({
                        url: 'Ajax/GuardarEdicionMenu.php',
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
