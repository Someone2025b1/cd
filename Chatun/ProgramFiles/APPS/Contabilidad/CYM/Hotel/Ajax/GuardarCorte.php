<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
$IdCorte        = $_POST["IdCorte"]; 
$NoEfectivo = $_POST["NoEfectivo"];
$CantEfectivo = $_POST["CantEfectivo"];
$ObsEfectivo = $_POST["ObsEfectivo"];
$NoCheque = $_POST["NoCheque"];
$CantCheque = $_POST["CantCheque"];
$ObsCheque = $_POST["ObsCheque"];
$NoDeposito = $_POST["NoDeposito"];
$CantDeposito = $_POST["CantDeposito"];
$ObsDeposito = $_POST["ObsDeposito"];
$NoTarjetas = $_POST["NoTarjetas"];
$CantTarjetas = $_POST["CantTarjetas"];
$ObsTarjetas   = $_POST["ObsTarjetas"];
$TotalDia = $_POST["TotalDia"];
$DelFac = $_POST["DelFac"];
$AlFac = $_POST["AlFac"];
$TotalFac = $_POST["TotalFac"];
$Recibido = $_POST["Recibido"];
$Insert = mysqli_query($db,  "UPDATE Taquilla.CORTE_HOTEL SET CH_NoEfectivo = '$NoEfectivo', CH_Efectivo = $CantEfectivo, CH_ObservacionesEfectivo = '$ObsEfectivo', CH_NoCheque = '$NoCheque', CH_Cheque = $CantCheque, CH_ObservacionesCheque = '$ObsCheque', CH_NoDeposito = '$NoDeposito', CH_Deposito = $CantDeposito, CH_ObservacionesDeposito = '$ObsDeposito', CH_NoTarjeta = '$NoTarjetas', CH_Tarjeta = $CantTarjetas, CH_ObservacionesTarjeta = '$ObsTarjetas', CH_Total = $TotalDia, CH_RecibeCorte = $Recibido, CH_Estado = 2  WHERE CH_Id = $IdCorte");
if($Insert) 
{
	 
$Detalle1 = mysqli_query($db,  "SELECT c.CH_Factura, a.DC_Id, a.H_CODIGO, a.DC_Del, a.DC_Al, a.DC_Total, a.DC_Adultos, a.DC_TotalAdulto, a.DC_Ninos,
a.DC_TotalNino, a.DC_AdultosM, a.DC_TotalAdultoM, a.DC_TotalMonto 
FROM Taquilla.DETALLE_FAC_HOTEL a
INNER JOIN Taquilla.FAC_HOTEL c ON c.CH_Id = a.CH_Id  
WHERE a.DC_Estado = 1 ORDER BY a.DC_Id ASC");
 while ($Row = mysqli_fetch_array($Detalle1)) 
 {
	$Detalle = mysqli_query($db,  "INSERT INTO Taquilla.DETALLE_CORTE (CH_Id, H_CODIGO, DC_Factura, DC_Del, DC_Al, DC_Total, DC_Adultos,
	DC_TotalAdulto, DC_AdultosM, DC_TotalAdultoM, DC_Ninos, DC_TotalNino, DC_TotalMonto, DC_Estado)
	VALUES ($IdCorte, '$Row[H_CODIGO]', '$Row[CH_Factura]', '$Row[DC_Del]', '$Row[DC_Al]', '$Row[DC_Total]', '$Row[DC_Adultos]', '$Row[DC_TotalAdulto]', '$Row[DC_AdultosM]', '$Row[DC_TotalAdultoM]', '$Row[DC_Ninos]', '$Row[DC_TotalNino]', '$Row[DC_TotalMonto]', 1)");
 }
 $Upd = mysqli_query($db,  "UPDATE Taquilla.DETALLE_FAC_HOTEL SET DC_Estado = 2 WHERE DC_Estado = 1");

}

if ($Insert) {
    echo "1";
}

?>
