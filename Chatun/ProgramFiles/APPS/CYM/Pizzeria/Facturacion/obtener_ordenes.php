<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$QueryOrdenes = mysqli_query($db, "SELECT F_CODIGO, F_ORDEN FROM Bodega.FACTURA_PIZZA 
    WHERE F_REALIZADA = 1 AND F_FECHA_TRANS = CURRENT_DATE() AND F_DESPACHADA = 0
    ORDER BY F_ORDEN ASC");

$ordenes = array();
while ($row = mysqli_fetch_assoc($QueryOrdenes)) {
    $ordenes[] = array(
        'codigo' => $row['F_CODIGO'],
        'orden' => $row['F_ORDEN']
    );
}

echo json_encode($ordenes);