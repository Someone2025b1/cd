<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");


    $codigo = intval($_POST["codigo"]);
    $seleccionada = intval($_POST["seleccionada"]);
    $PorQue = mysqli_real_escape_string($db, $_POST["PorQue"]);

    $query = "UPDATE CompraVenta.COTIZACION SET C_SELECCIONADA = $seleccionada, C_PORQUE = '$PorQue' WHERE C_CODIGO = $codigo";
    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo "Actualización exitosa";
        echo $codigo;
    } else {
        echo "Error al actualizar: " . mysqli_error($db);
    }

?>
