<?php
include ("../../../Script/conex.php");
$cif = $_GET["cif"];
$agencia = $_GET["agencia"];
$sql = "INSERT INTO ".$base_general.".cajeros_generales VALUES ('$agencia', '$cif') ON DUPLICATE KEY UPDATE id_user='$cif'";
mysqli_queryquery ($sql);
header('Location: ver_cajeros_generales.php')
?>