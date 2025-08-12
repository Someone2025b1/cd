<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Fecha = $_POST['Fecha']; 
$SQL_INSERT = mysqli_query($db, "UPDATE Bodega.CONTROL_PISICULTURA SET Estado = 4 WHERE Fecha = '$Fecha' AND Estado = 3");

if($SQL_INSERT){

	echo '1';
}else {

	echo '2';
}

?>	