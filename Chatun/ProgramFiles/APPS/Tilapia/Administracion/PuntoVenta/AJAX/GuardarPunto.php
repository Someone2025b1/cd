<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Nombre = $_POST['Nombre']; 
$SQL_INSERT = mysqli_query($db, "INSERT INTO Bodega.PUNTOS_VENTA (Descripcion, Estado, Colaborador, Fecha) 
VALUES ('$Nombre', 1, '$id_user', CURRENT_TIME)");

if($SQL_INSERT){

	echo '1';
}else {

	echo '2';
}

?>	