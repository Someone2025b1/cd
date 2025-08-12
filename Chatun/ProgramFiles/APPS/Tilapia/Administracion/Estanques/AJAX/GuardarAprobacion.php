<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Id = $_POST["Id"];
$Observaciones = $_POST["Observaciones"];

$SQL_INSERT = mysqli_query($db, "UPDATE Bodega.COMPRA_ALEVINES SET Estado = 2, Observaciones = '$Observaciones' where TRA_CODIGO = '$Id'");


if($SQL_INSERT){
	
	echo '1';
}else {

	echo '2';
}

?>	