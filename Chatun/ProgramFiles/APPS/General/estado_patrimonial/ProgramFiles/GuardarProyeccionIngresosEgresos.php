<?php
include("../../../../../Script/conex.php");

$SueldosSalarios       = $_POST['SueldosSalarios'];
$GastosPersonales      = $_POST['GastosPersonales'];
$Bonificaciones        = $_POST['Bonificaciones'];
$GastosFamiliares      = $_POST['GastosFamiliares'];
$AlquileresRentas      = $_POST['AlquileresRentas'];
$DescuentosSalariales  = $_POST['DescuentosSalariales'];
$JubilacionesPensiones = $_POST['JubilacionesPensiones'];
$AmortizacionCreditos  = $_POST['AmortizacionCreditos'];
$BonoAguinaldo         = $_POST['BonoAguinaldo'];
$PagoTarjetaCredito    = $_POST['PagoTarjetaCredito'];
$OtrosIngresos         = $_POST['OtrosIngresos'];
$OtrosEgresos          = $_POST['OtrosEgresos'];
$TotalIngresosP        = $_POST['TotalIngresosP'];
$TotalEgresosP         = $_POST['TotalEgresosP'];

$Usuario               = $_POST['Usuario'];

$Hoy = date('Y-m-d', strtotime('now'));

$Consulta = "SELECT COUNT(colaborador) AS TOTAL FROM Estado_Patrimonial.proyeccion_ingresos_egresos_detalle WHERE colaborador = ".$Usuario." AND fecha = '".$Hoy."'";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
   $Registro = $row["TOTAL"];                   
}

if($Registro == 0)
{
	$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.proyeccion_ingresos_egresos_detalle (fecha, colaborador, sueldos_salarios, bonificaciones, alquileres_rentas, jubilaciones_pensiones, bono14_aguinaldo, otros_ingresos, total_ingresos, gastos_personales, gastos_familiares, descuentos_salariales, amortizacion_creditos, pago_tarjetas_credito, otros_egresos, total_egresos, fecha_modificacion, hora_modificacion)
						VALUES ('".$Hoy."', ".$Usuario.", ".$SueldosSalarios.", ".$Bonificaciones.", ".$AlquileresRentas.", ".$JubilacionesPensiones.", ".$BonoAguinaldo.", ".$OtrosIngresos.", ".$TotalIngresosP.", ".$GastosPersonales.", ".$GastosFamiliares.", ".$DescuentosSalariales.", ".$AmortizacionCreditos.", ".$PagoTarjetaCredito.", ".$OtrosEgresos.", ".$TotalEgresosP.", CURRENT_DATE(), CURRENT_TIMESTAMP())");

	if(!$sql)
	{
		echo mysqli_error($sql);
	}
}
elseif($Registro > 0)
{
	$sql = mysqli_query($db, "UPDATE Estado_Patrimonial.proyeccion_ingresos_egresos_detalle
						SET sueldos_salarios = ".$SueldosSalarios.", bonificaciones = ".$Bonificaciones.", alquileres_rentas = ".$AlquileresRentas.", jubilaciones_pensiones = ".$JubilacionesPensiones.", bono14_aguinaldo = ".$BonoAguinaldo.", otros_ingresos = ".$OtrosIngresos.", total_ingresos = ".$TotalIngresosP.", gastos_personales = ".$GastosPersonales.", gastos_familiares = ".$GastosFamiliares.", descuentos_salariales = ".$DescuentosSalariales.", amortizacion_creditos = ".$AmortizacionCreditos.", pago_tarjetas_credito = ".$PagoTarjetaCredito.", otros_egresos = ".$OtrosEgresos.", total_egresos = ".$TotalEgresosP.", fecha_modificacion  = CURRENT_DATE(), hora_modificacion = CURRENT_TIMESTAMP()
						WHERE colaborador= ".$Usuario." AND fecha = '".$Hoy."'");

	if(!$sql)
	{
		echo mysqli_error($sql);
	}
}


?>