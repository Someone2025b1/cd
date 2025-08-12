<?php
include("../../../../../Script/conex.php");

$Acreedor      = $_POST["Acreedor"];
$Vencimiento   = $_POST["Vencimiento"];
$MontoOriginal = $_POST["MontoOriginal"];
$SaldoActual   = $_POST["SaldoActual"];
$ID            = $_POST["ID"];


$sql = mysqli_query($db, "UPDATE Estado_Patrimonial.tarjetas_credito_detalle SET acreedor = '".$Acreedor."', vencimiento = '".$Vencimiento."', monto_original = ".$MontoOriginal.", saldo_actual = ".$SaldoActual.", fecha = CURRENT_DATE WHERE id = '".$_POST["ID"]."'");


if(!$sql)
{
	echo mysqli_error();
}
else
{
	header('Location: estado_patrimonial.php');
}

?>