<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$CodigoSubMenu = $_POST["CodigoSubMenu"];
$ReferenciaAplicacion = $_POST["ReferenciaAplicacion"];


$Sql_Datos_SubMenu = mysqli_query($db, $portal_coosajo_db, "SELECT * FROM portal_coosajo_db.SUBMENU_APLICATIVO WHERE SMA_CODIGO = ".$CodigoSubMenu);
$Fila_Datos_SubMenu = mysqli_fetch_array($Sql_Datos_SubMenu);

?>

<form class="form form-material" id="FRMEditarSubMenu">
    <input type="hidden" name="CodigoSubMenuEditar" id="CodigoSubMenuEditar" value="<?php echo $CodigoSubMenu ?>">
    <div class="row">
        <div class="col-lg-12 form-group">
            <label for="MenuEditar">Menu</label>
            <select class="form-control" name="MenuEditar" id="MenuEditar" required>
                <?php
                    $Sql_Menu_Agregar = mysqli_query($db, $portal_coosajo_db, "SELECT A.MA_CODIGO, A.MA_NOMBRE
                                                                                FROM portal_coosajo_db.MENU_APLICATIVO AS A
                                                                                WHERE A.A_REFERENCIA = '".$ReferenciaAplicacion."'");
                    while($Fila_Menu_Agregar = mysqli_fetch_array($Sql_Menu_Agregar))
                    {
                        if($Fila_Menu_Agregar["MA_CODIGO"] == $Fila_Datos_SubMenu["MA_CODIGO"])
                        {
                            $TextoMenuAplicativo = 'selected';
                        }
                        else
                        {
                            $TextoMenuAplicativo = '';
                        }
                        ?>
                            <option value="<?php echo $Fila_Menu_Agregar["MA_CODIGO"] ?>" <?php echo $TextoMenuAplicativo ?>><?php echo $Fila_Menu_Agregar["MA_NOMBRE"] ?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 form-group">
            <label for="NombreEditar">Nombre</label>
            <input type="text" class="form-control" name="NombreEditar" id="NombreEditar" value="<?php echo $Fila_Datos_SubMenu["SMA_NOMBRE"] ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 form-group">
            <label for="PathEditar">Path</label>
            <input type="text" class="form-control" name="PathEditar" id="PathEditar" value="<?php echo $Fila_Datos_SubMenu["SMA_PATH"] ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 form-group">
            <label for="OrdenEditar">Orden</label>
            <input type="number" class="form-control" name="OrdenEditar" id="OrdenEditar" value="<?php echo $Fila_Datos_SubMenu["SMA_ORDEN"] ?>" required>
        </div>
    </div>
</form>