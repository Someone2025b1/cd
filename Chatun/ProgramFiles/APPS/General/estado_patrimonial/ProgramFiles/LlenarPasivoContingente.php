<?php
include("../../../../../Script/conex.php");

$Institucion = $_POST["Institucion"];
$Nombre = $_POST["Nombre"];
$Monto = $_POST["Monto"];
$Vencimiento = $_POST["Vencimiento"];
$UsuarioID = $_POST["UsuarioID"];



$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.detalle_pasivo_contingente (colaborador, fiador_de, institucion, monto, vencimiento) 
VALUES (".$UsuarioID.", '".$Nombre."', '".$Institucion."', '".$Monto."', '".$Vencimiento."')");

if(!$sql)
{
	echo 'ERROR';
}

?>