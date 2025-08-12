<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Tipo = $_POST['Tipo'];  
$SQL_INSERT = mysqli_query($db, "INSERT INTO Pisicultura.Producto_Pisicultura (Descripcion, Tipo, Fecha, Usuario) 
VALUES ('$Tipo',  '3', CURRENT_TIME, '$id_user')");

if($SQL_INSERT){

	echo '1';
}else {

	echo '2';
}

?>	