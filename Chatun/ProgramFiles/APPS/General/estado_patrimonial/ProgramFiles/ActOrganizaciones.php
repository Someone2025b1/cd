<?php
include("../../../../../Script/conex.php");

$Usuario = $_POST['Usuario'];

$resultado = mysqli_query($db, "SELECT * FROM Estado_Patrimonial.detalle_organizaciones_civiles WHERE colaborador = ".$Usuario);
$numero_filas = mysqli_num_rows($resultado);

echo $numero_filas;
?>