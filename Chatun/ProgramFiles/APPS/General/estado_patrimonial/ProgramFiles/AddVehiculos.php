<?php
include("../../../../../Script/conex.php");

$Marca = $_POST['Marca'];
$Modelo = $_POST['Modelo'];
$Color = $_POST['Color'];
$ValorMercadoVehiculo = $_POST['ValorMercadoVehiculo'];
$UsuarioID = $_POST['UsuarioID'];

$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.vehiculos_detalle (marca, modelo, color, valor_vehiculo, colaborador, fecha)
					VALUES ('".$Marca."', '".$Modelo."', '".$Color."', ".$ValorMercadoVehiculo.", ".$UsuarioID.", CURRENT_DATE())");
?>