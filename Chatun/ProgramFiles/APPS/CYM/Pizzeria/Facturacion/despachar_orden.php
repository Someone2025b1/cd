<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

if (isset($_POST['codigo'])) {
    $codigo = mysqli_real_escape_string($db, $_POST['codigo']);
    $query = "UPDATE Bodega.FACTURA_PIZZA SET F_DESPACHADA = 1 WHERE F_CODIGO = '$codigo'";
    if (mysqli_query($db, $query)) {
        echo "OK";
    } else {
        echo "Error al actualizar: " . mysqli_error($db);
    }
}