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
                                <h2 class="text-center">Administración Accesos a Perfiles Aplicativo - <?php echo $_GET["Nombre"] ?></h2>
                            </div>
                            <div class="card-body collapse show">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">                                        
                                            <?php
                                                $Sql_Menu_Aplicativo_Creado = mysqli_query($db, $portal_coosajo_db, "SELECT *
                                                                                                                FROM portal_coosajo_db.MENU_APLICATIVO AS A
                                                                                                                WHERE A.A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'
                                                                                                                AND A.MA_ESTADO = 1");
                                                while($Fila_Menu_Aplicativo_Creado = mysqli_fetch_array($Sql_Menu_Aplicativo_Creado))
                                                {
                                                    ?>
                                                        <li class="list-group-item active"><?php echo $Fila_Menu_Aplicativo_Creado["MA_NOMBRE"] ?></li>
                                                    <?php
                                                    $Sql_SubMenu_Aplicativo_Creado = mysqli_query($db, $portal_coosajo_db, "SELECT *
                                                                                                                        FROM portal_coosajo_db.SUBMENU_APLICATIVO AS A
                                                                                                                        WHERE A.MA_CODIGO = ".$Fila_Menu_Aplicativo_Creado['MA_CODIGO']."
                                                                                                                        AND A.SMA_ESTADO = 1");
                                                    while($Fila_SubMenu_Aplicativo_Creado = mysqli_fetch_array($Sql_SubMenu_Aplicativo_Creado))
                                                    {
                                                        $Sql_Permiso_Privilegio_Existe = mysqli_query($db, $portal_coosajo_db, "SELECT *
                                                                                                                            FROM portal_coosajo_db.PERMISO_PRIVILEGIO AS A
                                                                                                                            WHERE A.PA_CODIGO = ".$_GET["Codigo"]."
                                                                                                                            AND A.SM_CODIGO = ".$Fila_SubMenu_Aplicativo_Creado["SMA_CODIGO"]);
                                                        $Registros_Permiso_Privilegio_Existe = mysqli_num_rows($Sql_Permiso_Privilegio_Existe);

                                                        
                                                        ?>
                                                            <li class="list-group-item">
                                                                <div class="switch">
                                                                    <label><input data-perfil="<?php echo $_GET["Codigo"] ?>" value="<?php echo $Fila_SubMenu_Aplicativo_Creado['SMA_CODIGO'] ?>" onchange="ActivarInactivar(this)" type="checkbox" <?php if($Registros_Permiso_Privilegio_Existe > 0){echo 'checked';} ?>><span class="lever"></span><?php echo $Fila_SubMenu_Aplicativo_Creado['SMA_NOMBRE'] ?></label>
                                                                </div>
                                                            </li>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </ul>
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
        function ActivarInactivar(x)
        {
            var CodigoPerfil = $(x).attr('data-perfil');

            if($(x).is(':checked'))
            {
                $.ajax({
                    url: 'Ajax/ActivarInactivarPermisoPerfil.php',
                    type: 'post',
                    data: 'Acceso='+x.value+'&CodigoPerfil='+CodigoPerfil+'&Tipo=1',
                    success: function (data) {
                        if(data != 1)
                        {
                            $.toast({
                                text: "No se pudo activar/inactivar el elemento del Acceso seleccionado. Comuníquese con IDT", // Text that is to be shown in the toast
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
                    url: 'Ajax/ActivarInactivarPermisoPerfil.php',
                    type: 'post',
                    data: 'Acceso='+x.value+'&CodigoPerfil='+CodigoPerfil+'&Tipo=2',
                    success: function (data) {
                        if(data != 1)
                        {
                            $.toast({
                                text: "No se pudo activar/inactivar el elemento del Acceso seleccionado. Comuníquese con IDT", // Text that is to be shown in the toast
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
    </script>
</body>

</html>
