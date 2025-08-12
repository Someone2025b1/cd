<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Id = $_POST["Id"];
$Estado = $_POST["Estado"];
$CIF = $_POST["CIF"];
if ($Estado==1) {
	 $Contador = mysqli_num_rows(mysqli_query($db, "SELECT*
	FROM info_bbdd.aplicaciones_agg a
	WHERE EXISTS (SELECT *FROM info_bbdd.permisos_app b where b.id_aplicacion = a.id_aplicacion and b.id_aplicacion = $Id AND b.id_user = $CIF )"));
	 if ($Contador>0) 
	 {
	 	$Upd = mysqli_query($db, "UPDATE info_bbdd.permisos_app SET estado = 1 where id_aplicacion = $Id and id_user = $CIF"); 
	 }
	 else
	 {
	 	$Upd = mysqli_query($db, "INSERT INTO info_bbdd.permisos_app (id_user, id_aplicacion, estado) VALUES ($CIF, $Id, 1)");
	 }
}
else
{
	$Upd = mysqli_query($db, "UPDATE info_bbdd.permisos_app SET estado = 2 where id_aplicacion = $Id and id_user = $CIF");
}

if ($Upd) {
	echo "1";
}
?>
 
