<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$CodigoPerfil = $_POST["CodigoPerfil"];


$Sql_Datos_Perfil = mysqli_query($db, $portal_coosajo_db, "SELECT * FROM portal_coosajo_db.PRIVILEGIO_APLICATIVO AS A WHERE A.PA_CODIGO = ".$CodigoPerfil);
$Fila_Datos_Perfil = mysqli_fetch_array($Sql_Datos_Perfil);

?>

<form class="form form-material" id="FRMEditarMenu">
    <input type="hidden" name="CodigoPerfilEditar" id="CodigoPerfilEditar" value="<?php echo $CodigoPerfil ?>">
    <div class="row">
        <div class="col-lg-6 form-group">
            <label for="NombreEditar">Nombre</label>
            <input type="text" class="form-control" name="NombreEditar" id="NombreEditar" value="<?php echo $Fila_Datos_Perfil["PA_NOMBRE"] ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 form-group">
            <label for="DescripcionEditar">Descripción</label>
            <input type="text" class="form-control" name="DescripcionEditar" id="DescripcionEditar" value="<?php echo $Fila_Datos_Perfil["PA_DESCRIPCION"] ?>" required>
        </div>
    </div>
</form>