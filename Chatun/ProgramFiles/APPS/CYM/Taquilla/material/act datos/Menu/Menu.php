<?php
$Referencia_Aplicacion_Menu = "5c4901e953d43";
$Path_Aplicativo = "/App/253_ActualizacionDatos/";
?>
<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <?php
                   //SELECT PARA EL MENU DEL PORTAL
                    $Sql_Menu = mysqli_query($db, $portal_coosajo_db, "SELECT DISTINCT(B.MA_CODIGO), E.MA_NOMBRE, E.MA_ICONO_MENU, E.MA_ORDEN_MENU
                                                                FROM portal_coosajo_db.PERMISO_PRIVILEGIO AS A
                                                                INNER JOIN portal_coosajo_db.SUBMENU_APLICATIVO AS B ON A.SM_CODIGO = B.SMA_CODIGO
                                                                INNER JOIN portal_coosajo_db.PRIVILEGIO_APLICATIVO AS C ON A.PA_CODIGO = C.PA_CODIGO
                                                                INNER JOIN portal_coosajo_db.PRIVILEGIO_APLICATIVO_COLABORADOR AS D ON C.PA_CODIGO = D.PA_CODIGO
                                                                INNER JOIN portal_coosajo_db.MENU_APLICATIVO AS E ON B.MA_CODIGO = E.MA_CODIGO
                                                                WHERE C.A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'
                                                                AND D.PAC_COLABORADOR = ".$_SESSION['CIF']."
                                                                AND E.MA_ESTADO = 1");
                    while($Fila_Menu = mysqli_fetch_array($Sql_Menu))
                    {
                        ?>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="<?php echo $Fila_Menu["MA_ICONO_MENU"] ?>"></i><span class="hide-menu"><?php echo $Fila_Menu["MA_NOMBRE"] ?> </span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <?php
                                        $Sql_SubMenu = mysqli_query($db, $portal_coosajo_db, "SELECT A.*, B.*
                                                                                        FROM portal_coosajo_db.PERMISO_PRIVILEGIO AS A
                                                                                        INNER JOIN portal_coosajo_db.SUBMENU_APLICATIVO AS B ON A.SM_CODIGO = B.SMA_CODIGO
                                                                                        INNER JOIN portal_coosajo_db.PRIVILEGIO_APLICATIVO AS C ON A.PA_CODIGO = C.PA_CODIGO
                                                                                        INNER JOIN portal_coosajo_db.PRIVILEGIO_APLICATIVO_COLABORADOR AS D ON C.PA_CODIGO = D.PA_CODIGO
                                                                                        INNER JOIN portal_coosajo_db.MENU_APLICATIVO AS E ON B.MA_CODIGO = E.MA_CODIGO
                                                                                        WHERE C.A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'
                                                                                        AND D.PAC_COLABORADOR = ".$_SESSION['CIF']."
                                                                                        AND E.MA_ESTADO = 1
                                                                                        AND E.MA_CODIGO = ".$Fila_Menu['MA_CODIGO']."
                                                                                        AND B.SMA_ESTADO = 1
                                                                                        ORDER BY B.SMA_ORDEN ASC");
                                        while($Fila_SubMenu = mysqli_fetch_array($Sql_SubMenu))
                                        {
                                            ?>
                                                <li><a href="<?php echo $Path_Aplicativo.''.$Fila_SubMenu['SMA_PATH'] ?>"><?php echo $Fila_SubMenu['SMA_NOMBRE'] ?></a></li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                        <?php
                    }
                ?>
            </ul>
        </nav>
    </div>
</aside>
