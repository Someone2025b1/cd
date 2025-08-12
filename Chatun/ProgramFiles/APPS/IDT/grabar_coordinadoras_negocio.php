<?php
include ("../../../Script/conex.php");
$cif = $_GET["cif"];
$agencia = $_GET["agencia"];
$sql = "INSERT INTO ".$base_general.".coordinadores_negocios VALUES ('$agencia', '$cif') ON DUPLICATE KEY UPDATE id_user='$cif'";
mysqli_queryquery ($sql);
header('Location: ver_coordinadoras_negocio.php')
?>