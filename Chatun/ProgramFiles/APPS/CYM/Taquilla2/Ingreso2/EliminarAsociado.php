<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$ID = $_POST["ID"];

$QueryCIFAsociado = mysqli_query($db, "SELECT IAT_CIF_ASOCIADO FROM Taquilla.INGRESO_ASOCIADO_TEMPORAL WHERE IAT_CODIGO = ".$ID);
$FilaCIFAsociado = mysqli_fetch_array($QueryCIFAsociado);
$CIFAsociado = $FilaCIFAsociado["IAT_CIF_ASOCIADO"];

$query = mysqli_query($db, "DELETE FROM Taquilla.INGRESO_ASOCIADO_TEMPORAL WHERE IAT_CODIGO = ".$ID) or die("error".mysqli_error());

$querytemporal = mysqli_query($db, "DELETE FROM Taquilla.INGRESO_ACOMPANIANTE_TEMPORAL WHERE IAT_CIF_ASOCIADO = ".$CIFAsociado." AND IAT_CIF_COLABORADOR = ".$id_user);


?>
