<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");


    if (isset($_POST['codigo']) && isset($_POST['cantidad'])) {
    $codigo = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];
    $codigoIn = $_POST['codigoIn'];


    $querypr = "SELECT * FROM Productos.INVENTARIO_RECONTEO_DETALLE WHERE IR_CODIGO = '$codigoIn' AND P_CODIGO = $codigo";
        $resultpr = mysqli_query($db, $querypr);
        while($rowpr = mysqli_fetch_array($resultpr))
        {

            $existenciasou=$rowpr["ID_CANTIDAD_SISTEMA"];

            $diferencia=$cantidad-$existenciasou;
        }
        

    $query = "UPDATE Productos.INVENTARIO_RECONTEO_DETALLE SET
    ID_CANTIDAD_CONTADA = $cantidad,
    ID_CANTIDAD_SISTEMA = '".$existenciasou."',
    ID_DIFERENCIA = '".$diferencia."' WHERE IR_CODIGO = '$codigoIn' AND P_CODIGO = $codigo";

    if (mysqli_query($db, $query)) {
        echo "Actualizado correctamente";
    } else {
        echo "Error al actualizar";
    }
} else {
    echo "Datos incompletos";
}

?>
