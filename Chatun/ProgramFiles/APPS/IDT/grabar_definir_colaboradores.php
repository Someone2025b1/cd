<?php
include ("../../../Script/conex.php");
$tipo_definir = $_GET["tipo"];
$id_definir = $_GET["id"];
$cif = $_GET["cif"];
switch ($tipo_definir) {
	case 1:	mysqli_query($db, "INSERT INTO ".$base_general.".define_gerentes VALUES ('$id_definir', '$cif') ON DUPLICATE KEY UPDATE id_user='$cif'") or die (mysqli_error());
			break;
	case 2:	mysqli_query($db, "INSERT INTO ".$base_general.".define_jefe_departamento VALUES ('$id_definir', '$cif') ON DUPLICATE KEY UPDATE id_user='$cif'") or die (mysqli_error());
			break;
	case 3:	mysqli_query($db, "INSERT INTO ".$base_general.".define_jefe_agencia VALUES ('$id_definir', '$cif') ON DUPLICATE KEY UPDATE id_user='$cif'") or die (mysqli_error());
			break;
	case 4:	mysqli_query($db, "INSERT INTO ".$base_general.".define_cajeros_generales VALUES ('$id_definir', '$cif') ON DUPLICATE KEY UPDATE id_user='$cif'") or die (mysqli_error());
			break;
	case 5:	mysqli_query($db, "INSERT INTO ".$base_general.".define_coordinadores_negocios VALUES ('$id_definir', '$cif') ON DUPLICATE KEY UPDATE id_user='$cif'") or die (mysqli_error());
			break;
}

header('Location: ver_asignaciones.php?centinela=0&tipo='.$tipo_definir)
?>