<?php
include("../../../../../Script/conex.php");

$Tipo = $_POST["Tipo"];
$Nombre = $_POST["Nombre"];
$Cargo = $_POST["Cargo"];
$Fecha = $_POST["Fecha"];
$UsuarioID = $_POST["UsuarioID"];



$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.detalle_organizaciones_civiles (colaborador, tipo_organizacion, nombre_organizacion, fecha_ingreso, cargo) 
VALUES (".$UsuarioID.", '".$Tipo."', '".$Nombre."', '".$Fecha."', '".$Cargo."')");

if(!$sql)
{
	echo 'ERROR';
}

?>