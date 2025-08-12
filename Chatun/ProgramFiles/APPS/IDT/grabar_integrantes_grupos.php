<?php
include ("../../../Script/conex.php");
$idgrupo = $_GET["idgrupo"];
$cif = $_GET["cif"];
$tipo = $_GET["tipo"];

switch ($tipo) {
	case 1:	mysqli_query($db, "INSERT INTO ".$base_general.".define_integrantes_grupos VALUES ('$idgrupo', '$cif')") or die ('Ya existe este usuario dentro del grupo especificado....  &nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:history.back()">REGRESAR</a>');
			$sql = mysqli_query($db, "SELECT * FROM ".$base_general.".define_aplicaciones_grupos WHERE id_grupo = $idgrupo");
			$hay_datos = mysqli_querynum_rows($sql);
			if ($hay_datos != 0) {
				while ($si_datos = mysqli_fetch_row($sql)) {
					mysqli_queryquery ("INSERT INTO ".$base_bbdd.".define_permisos VALUES (NULL, $idgrupo, $cif, $si_datos[1], $si_datos[2]) ON DUPLICATE KEY UPDATE id_nivel = $si_datos[2]") or die (mysqli_error());
				}
			}			
			break;
	case 2:	mysqli_query($db, "DELETE FROM ".$base_general.".define_integrantes_grupos WHERE id_grupo = $idgrupo AND id_user = $cif") or die (mysqli_error());
			mysqli_query($db, "DELETE FROM ".$base_bbdd.".define_permisos WHERE id_user = $cif AND id_grupo = $idgrupo") or die (mysqli_error()); 
			break;
}

header('Location: ver_integrantes_grupos.php?centinela=0&idgrupo='.$idgrupo)
?>