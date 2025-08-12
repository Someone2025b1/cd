<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$ID = $_POST["Codigo"];
$Asociado = $_POST["Asociado"];

$querytemporal = mysqli_query($db, "DELETE FROM Taquilla.INGRESO_ACOMPANIANTE_TEMPORAL WHERE IAT_CODIGO = ".$ID." AND IAT_CIF_COLABORADOR = ".$id_user)or die(mysqli_error($querytemporal));

$querytemporalmenor = mysqli_query($db, "DELETE FROM Taquilla.INGRESO_ACOMPANIANTE_MENORES_TEMPORAL WHERE USUARIO = ".$id_user);


?>
