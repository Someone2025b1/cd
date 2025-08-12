<?php
include("../../../../../Script/conex.php");

$EntidadFinanciera = $_POST["EntidadFinanciera"];
$Acreedor          = $_POST["Acreedor"];
$Garantia          = $_POST["Garantia"];
$Vencimiento       = $_POST["Vencimiento"];
$MontoOriginal     = $_POST["MontoOriginal"];
$SaldoActual       = $_POST["SaldoActual"];
$Frecuencia        = $_POST["Frecuencia"];
$MontoCortoPlazo   = $_POST["MontoCortoPlazo"];
$ID                = $_POST["ID"];


$sql = mysqli_query($db, "UPDATE Estado_Patrimonial.obligacioneslp_detalle SET entidad_financiera = '".$EntidadFinanciera."', acreedor = '".$Acreedor."', garantia = '".$Garantia."', vencimiento = '".$Vencimiento."', monto_original = ".$MontoOriginal.", saldo_actual = ".$SaldoActual.", frecuencia = '".$Frecuencia."', monto_amortizacion = ".$MontoCortoPlazo.", fecha = CURRENT_DATE WHERE id = ".$_POST["ID"]."") or die (mysqli_error());


if(!$sql)
{
	echo mysqli_error();
}
else
{
	header('Location: estado_patrimonial.php');
}

?>