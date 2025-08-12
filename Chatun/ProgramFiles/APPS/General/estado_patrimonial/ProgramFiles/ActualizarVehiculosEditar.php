<?php
include("../../../../../Script/conex.php");

$Marca = $_POST["Marca"];
$Modelo = $_POST["Modelo"];
$Color        = $_POST["Color"];
$ValorMercado        = $_POST["ValorMercado"];
$ID           = $_POST["ID"];


$sql = mysqli_query($db, "UPDATE Estado_Patrimonial.vehiculos_detalle SET marca = '".$Marca."', modelo = '".$Modelo."', color = '".$Color."', valor_vehiculo = ".$ValorMercado.", fecha = CURRENT_DATE WHERE id = '".$_POST["ID"]."'");


if(!$sql)
{
	echo mysqli_error();
}
else
{
	header('Location: estado_patrimonial.php');
}

?>