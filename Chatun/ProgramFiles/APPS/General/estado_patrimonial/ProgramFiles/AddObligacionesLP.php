<?php
include("../../../../../Script/conex.php");

$EntidadFinanciera = $_POST['EntidadFinanciera'];
$Acreedor = $_POST['Acreedor'];
$Garantia = $_POST['Garantia'];
$Vencimiento = $_POST['Vencimiento'];
$MontoOriginal = $_POST['MontoOriginal'];
$SaldoActual = $_POST['SaldoActual'];
$Frecuencia = $_POST['Frecuencia'];
$MontoCortoPlazo = $_POST['MontoCortoPlazo'];
$UsuarioID = $_POST['UsuarioID'];

$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.obligacioneslp_detalle (entidad_financiera, acreedor, garantia, vencimiento, monto_original, saldo_actual, frecuencia, monto_amortizacion, colaborador, fecha)
					VALUES ('".$EntidadFinanciera."', '".$Acreedor."', '".$Garantia."', '".$Vencimiento."', ".$MontoOriginal.", ".$SaldoActual.", '".$Frecuencia."', ".$MontoCortoPlazo.", ".$UsuarioID.", CURRENT_DATE())");?>