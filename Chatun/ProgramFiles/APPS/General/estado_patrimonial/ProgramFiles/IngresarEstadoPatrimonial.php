<?php
include("../../../../../Script/conex.php");

$Caja                       = $_POST['Caja'];
$DepositosCoosajo           = $_POST['DepositosCoosajo'];
$DepositosBancos            = $_POST['DepositosBancos'];
$FondoRetiro                = $_POST['FondoRetiro'];
$CuentasPorCobrar           = $_POST['CuentasPorCobrar'];
$SubtotalActivoCirculante   = $_POST['SubtotalActivoCirculante'];

$TerrenosConstrucciones     = $_POST['TerrenosConstrucciones'];
$Vehiculos                  = $_POST['Vehiculos'];
$InversionesValoresAcciones = $_POST['InversionesValoresAcciones'];
$MobiliarioEquipo           = $_POST['MobiliarioEquipo'];
$InversionesGanado          = $_POST['InversionesGanado'];
$OtrosActivos               = $_POST['OtrosActivos'];
$SubtotalActivoFijo         = $_POST['SubtotalActivoFijo'];

$ObligacionesCortoPlazoC    = $_POST['ObligacionesCortoPlazoC'];
$ObligacionesCortoPlazoB    = $_POST['ObligacionesCortoPlazoB'];
$TarjetasCredito            = $_POST['TarjetasCredito'];
$AnticipoSueldo             = $_POST['AnticipoSueldo'];
$OtrosPrestamos             = $_POST['OtrosPrestamos'];
$CuentasDocumentosPorPagar  = $_POST['CuentasDocumentosPorPagar'];
$Proveedores                = $_POST['Proveedores'];
$OtrosPasivoCirculante      = $_POST['OtrosPasivoCirculante'];
$SubtotalPasivoCirculante   = $_POST['SubtotalPasivoCirculante'];

$ObligacionesLargoPlazoC    = $_POST['ObligacionesLargoPlazoC'];
$ObligacionesLargoPlazoB    = $_POST['ObligacionesLargoPlazoB'];
$OtrasDeudasPasivoFijo      = $_POST['OtrasDeudasPasivoFijo'];
$SubtotalPasivoFijo         = $_POST['SubtotalPasivoFijo'];

$TotalActivo                = $_POST['TotalActivo'];
$TotalPasivo                = $_POST['TotalPasivo'];
$TotalPatrimonio            = $_POST['TotalPatrimonio'];
$TotalPasivoPatrimonio      = $_POST['TotalPasivoPatrimonio'];

$Usuario                    = $_POST['Usuario'];

$Hoy = date('Y-m-d', strtotime('now'));

$Consulta = "SELECT COUNT(id) AS TOTAL FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE id = ".$Usuario." AND fecha = '".$Hoy."'";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
   $Registro = $row["TOTAL"];                   
}


if($Registro == 0)
{
	$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.estado_patrimonial_detalle (id, fecha, caja, depositos_coosajo, depositos_bancos, fondo_retiro, cuentas_cobrar, subtotal_activocirculante, terrenos, vehiculos, mobiliario, inversiones_ganado, inversiones_valores, otros_activos, subtotal_activofijo, total_activo, prestamos_coosajo_menor, prestamos_bancos_menor, anticipo_sueldo, otros_prestamos, tarjetas_credito, cuentas_por_pagar, proveedores, otros_pasivocirculante, subtotal_pasivocirculante, prestamos_coosajo_mayores, prestamos_bancos_mayores, otras_deudas, subtotal_pasivofijo, total_pasivo, patrimonio, total_pasivo_patrimonio, fecha_actualizacion, hora_actualizacion)
						VALUES (".$Usuario.", '".$Hoy."', ".$Caja.", ".$DepositosCoosajo.", ".$DepositosBancos.", ".$FondoRetiro.", ".$CuentasPorCobrar.", ".$SubtotalActivoCirculante.", ".$TerrenosConstrucciones.", ".$Vehiculos.", ".$MobiliarioEquipo.", ".$InversionesGanado.", ".$InversionesValoresAcciones.", ".$OtrosActivos.", ".$SubtotalActivoFijo.", ".$TotalActivo.", ".$ObligacionesCortoPlazoC.", ".$ObligacionesCortoPlazoB.", ".$AnticipoSueldo.", ".$OtrosPrestamos.", ".$TarjetasCredito.", ".$CuentasDocumentosPorPagar.", ".$Proveedores.", ".$OtrosPasivoCirculante.", ".$SubtotalPasivoCirculante.", ".$ObligacionesLargoPlazoC.", ".$ObligacionesLargoPlazoB.", ".$OtrasDeudasPasivoFijo.", ".$SubtotalPasivoFijo.", ".$TotalPasivo.", ".$TotalPatrimonio.", ".$TotalPasivoPatrimonio.", CURRENT_DATE(), CURRENT_TIMESTAMP())");

	if(!$sql)
	{
		echo mysqli_error($sql);
	}
}
elseif($Registro > 0)
{
	$sql = mysqli_query($db, "UPDATE Estado_Patrimonial.estado_patrimonial_detalle
						SET caja = ".$Caja.", depositos_coosajo = ".$DepositosCoosajo.", depositos_bancos = ".$DepositosBancos.", fondo_retiro = ".$FondoRetiro.", cuentas_cobrar = ".$CuentasPorCobrar.", subtotal_activocirculante = ".$SubtotalActivoCirculante.", terrenos = ".$TerrenosConstrucciones.", vehiculos = ".$Vehiculos.", mobiliario = ".$MobiliarioEquipo.", inversiones_ganado = ".$InversionesGanado.", inversiones_valores = ".$InversionesValoresAcciones.", otros_activos = ".$OtrosActivos.", subtotal_activofijo = ".$SubtotalActivoFijo.", total_activo = ".$TotalActivo.", prestamos_coosajo_menor = ".$ObligacionesCortoPlazoC.", prestamos_bancos_menor = ".$ObligacionesCortoPlazoB.", anticipo_sueldo = ".$AnticipoSueldo.", otros_prestamos = ".$OtrosPrestamos.", tarjetas_credito = ".$TarjetasCredito.", cuentas_por_pagar = ".$CuentasDocumentosPorPagar.", proveedores = ".$Proveedores.", otros_pasivocirculante = ".$OtrosPasivoCirculante.", subtotal_pasivocirculante = ".$SubtotalPasivoCirculante.", prestamos_coosajo_mayores = ".$ObligacionesLargoPlazoC.", prestamos_bancos_mayores = ".$ObligacionesLargoPlazoB.", otras_deudas = ".$OtrasDeudasPasivoFijo.", subtotal_pasivofijo = ".$SubtotalPasivoFijo.", total_pasivo = ".$TotalPasivo.", patrimonio = ".$TotalPatrimonio.", total_pasivo_patrimonio = ".$TotalPasivoPatrimonio.", fecha_actualizacion = CURRENT_DATE(), hora_actualizacion = CURRENT_TIMESTAMP()
						WHERE id= ".$Usuario." AND fecha = '".$Hoy."' ");

	if(!$sql)
	{
		echo mysqli_error($sql);
	}
}


?>