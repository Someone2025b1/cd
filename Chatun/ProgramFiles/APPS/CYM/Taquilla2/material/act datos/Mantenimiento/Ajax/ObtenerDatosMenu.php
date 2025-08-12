<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$CodigoMenu = $_POST["CodigoMenu"];


$Sql_Datos_Menu = mysqli_query($db, $portal_coosajo_db, "SELECT A.*, C.gerencia FROM portal_coosajo_db.MENU_APLICATIVO AS A INNER JOIN info_base.departamentos AS B ON A.MA_DEPARTAMENTO = B.id_depto INNER JOIN info_base.gerencias AS C ON B.id_gerencia = C.id_gerencia WHERE A.MA_CODIGO = ".$CodigoMenu);
$Fila_Datos_Menu = mysqli_fetch_array($Sql_Datos_Menu);

?>

<form class="form form-material" id="FRMEditarMenu">
    <input type="hidden" name="AplicativoMenuEditar" id="AplicativoMenuEditar" value="<?php echo $Referencia_Aplicacion_Menu ?>">
    <input type="hidden" name="CodigoMenuEditar" id="CodigoMenuEditar" value="<?php echo $CodigoMenu ?>">
    <div class="row">
        <div class="col-lg-10 form-group">
            <label for="NombreEditar">Nombre</label>
            <input type="text" class="form-control" name="NombreEditar" id="NombreEditar" value="<?php echo $Fila_Datos_Menu["MA_NOMBRE"] ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 form-group">
            <label for="IconoEditar">Icono</label>
            <input type="text" class="form-control" name="IconoEditar" id="IconoEditar" value="<?php echo $Fila_Datos_Menu["MA_ICONO_MENU"] ?>" required>
        </div>
        <div class="col-lg-4 form-group">
            <label for="OrdenEditar">Orden</label>
            <input type="number" class="form-control" name="OrdenEditar" id="OrdenEditar" value="<?php echo $Fila_Datos_Menu["MA_ORDEN_MENU"] ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 form-group">
            <label for="DepartamentoEditar">Departamento</label>
            <select class="form-control" name="DepartamentoEditar" id="DepartamentoEditar" onchange="ObtenerNombreGerenciaEditar(this.value)" required>
                <?php
                    $Sql_Departamento_Menu = mysqli_query($db, $portal_coosajo_db, "SELECT A.id_depto, A.nombre_depto
                                                                                FROM info_base.departamentos AS A
                                                                                ORDER BY A.nombre_depto");
                    while($Fila_Departamento_Menu = mysqli_fetch_array($Sql_Departamento_Menu))
                    {
                    	if($Fila_Datos_Menu["MA_DEPARTAMENTO"] == $Fila_Departamento_Menu["id_depto"])
                    	{
                    		$TextoDepartamento = 'selected';
                    	}
                    	else
                    	{
                    		$TextoDepartamento = '';
                    	}
                        ?>
                            <option value="<?php echo $Fila_Departamento_Menu["id_depto"] ?>" <?php echo $TextoDepartamento ?>><?php echo $Fila_Departamento_Menu["nombre_depto"] ?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 form-group">
            <label for="GerenciaEditar">Gerencia</label>
            <input type="text" class="form-control" name="GerenciaEditar" id="GerenciaEditar" value="<?php echo $Fila_Datos_Menu["gerencia"] ?>" required readonly>
        </div>
    </div>
</form>