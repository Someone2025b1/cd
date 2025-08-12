<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$Colaborador = $_POST["Colaborador"];


$Sql_Nombre_Puesto = mysqli_query($db, $portal_coosajo_db, "SELECT A.nombre_puesto
FROM info_colaboradores.vista_colaboradores_idt AS A
WHERE A.cif = ".$Colaborador);
$Fila_Nombre_Puesto = mysqli_fetch_array($Sql_Nombre_Puesto);

echo $Fila_Nombre_Puesto["nombre_puesto"];

?>