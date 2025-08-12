<?php
include("../../../../../Script/conex.php");

$Cargos   = $_POST['Cargos'];
$Abonos   = $_POST['Abonos'];
$Cuenta   = $_POST['Cuenta'];
$Razon    = $_POST['Razon'];
$Trans    = $_POST['CodigoTransaccion'];
$Contador = count($Cargos);
$UID      = uniqid('trad_');
$SerieFactura = $_POST["SerieFactura"];
$Factura = $_POST["Factura"];
$Fecha = $_POST["Fecha"];
$Descripcion = $_POST["Descripcion"];
$Establecimiento = $_POST["Establecimiento"];
$Act = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRA_FECHA_TRANS = '$Fecha', TRA_CONCEPTO = '$Descripcion', 
TRA_SERIE = '$SerieFactura', TRA_FACTURA = '$Factura', TRA_ESTABLECIMIENTO = '$Establecimiento' WHERE TRA_CODIGO = '$Trans' ");
$SQLDelete = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE WHERE TRA_CODIGO = '".$Trans."'");

for($i=1; $i<$Contador; $i++)
{
	$Cue = $Cuenta[$i];
	$Car = $Cargos[$i];
	$Abo = $Abonos[$i];
	$Raz = $Razon[$i];

	$Xplotado = explode("/", $Cue);
	$NCue = $Xplotado[0];

	$query = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA, TRAD_RAZON)
		VALUES('".$UID."', '".$Trans."', '".$NCue."', ".$Car.", ".$Abo.", '".$Raz."')");
}

header('Location: OFacturaPro.php?Codigo='.$Trans);

?>