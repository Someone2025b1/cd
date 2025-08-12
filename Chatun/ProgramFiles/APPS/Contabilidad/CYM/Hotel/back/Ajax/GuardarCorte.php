<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/conex_a_coosajo.php");
include("../../../../../Script/conex_sql_server.php");
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
$Insert = mysqli_query($db, "UPDATE Taquilla.CORTE_HOTEL SET CH_NoEfectivo = '$NoEfectivo', CH_Efectivo = $CantEfectivo, CH_ObservacionesEfectivo = '$ObsEfectivo', CH_NoCheque = '$NoCheque', CH_Cheque = $CantCheque, CH_ObservacionesCheque = '$ObsCheque', CH_NoDeposito = '$NoDeposito', CH_Deposito = $CantDeposito, CH_ObservacionesDeposito = '$ObsDeposito', CH_NoTarjeta = '$NoTarjetas', CH_Tarjeta = $CantTarjetas, CH_ObservacionesTarjeta = '$ObsTarjetas', CH_Total = $TotalDia, CH_RecibeCorte = $Recibido, CH_Estado = 2  WHERE CH_Id = $IdCorte");
$Detalle = mysqli_query($db, "SELECT A.DC_Id FROM Taquilla.DETALLE_CORTE A WHERE A.CH_Id = $IdCorte");

while ($Row = mysqli_fetch_array($Detalle)) {
	 
$Insert2 = mysqli_query($db, "UPDATE Taquilla.DETALLE_VALE_FACTURA SET DVF_Estado = 2 WHERE DC_Id = $Row[DC_Id]");
 }
if ($Insert) {
    echo "1";
}

?>
