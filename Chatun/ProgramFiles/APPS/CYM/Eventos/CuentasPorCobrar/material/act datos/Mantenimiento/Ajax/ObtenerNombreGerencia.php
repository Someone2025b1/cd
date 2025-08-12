<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$CodigoDepartamento = $_POST["CodigoDepartamento"];


$Sql_Datos_Menu = mysqli_query($db, $portal_coosajo_db, "SELECT B.gerencia
FROM info_base.departamentos AS A
INNER JOIN info_base.gerencias AS B ON A.id_gerencia = B.id_gerencia
WHERE A.id_depto = ".$CodigoDepartamento);
$Fila_Datos_Menu = mysqli_fetch_array($Sql_Datos_Menu);

echo $Fila_Datos_Menu["gerencia"];

?>