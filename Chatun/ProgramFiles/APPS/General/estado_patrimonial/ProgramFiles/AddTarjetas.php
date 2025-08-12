<?php
include("../../../../../Script/conex.php");

$AcreedorTarjetas = $_POST['AcreedorTarjetas'];
$VencimientoTarjetas = $_POST['VencimientoTarjetas'];
$MontoOriginalTarjetas = $_POST['MontoOriginalTarjetas'];
$SaldoActualTarjetas = $_POST['SaldoActualTarjetas'];
$UsuarioID = $_POST['UsuarioID'];

$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.tarjetas_credito_detalle (acreedor, vencimiento, monto_original, saldo_actual, colaborador, fecha)
					VALUES ('".$AcreedorTarjetas."', '".$VencimientoTarjetas."', ".$MontoOriginalTarjetas.", ".$SaldoActualTarjetas.", ".$UsuarioID.", CURRENT_DATE())");
?>