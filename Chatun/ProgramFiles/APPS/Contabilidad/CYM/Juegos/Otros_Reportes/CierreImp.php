<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../Script/funciones.php");

$GLOBALS["TipoCorte"] = $_POST["TipoCorte"];

$Usuario =  $_SESSION["iduser"];
$CodigoApertura = $_POST["CodigoApertura"];
$UsuarioNombre = saber_nombre_asociado_orden($Usuario);
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));

$FechaImp              = date('d-m-Y', strtotime($_POST["FechaImp"]));
$FacturasEmitidasCorte = $_POST["FacturasEmitidasCorte"];
$FacturasAnuladasCorte = $_POST["FacturasAnuladasCorte"];
$SerieFacturaCorte     = $_POST["SerieFacturaCorte"];
$DelFacturaCorte       = $_POST["DelFacturaCorte"];
$AlFacturaCorte        = $_POST["AlFacturaCorte"];
$EfectivoCorte         = number_format($_POST["EfectivoCorte"], 2, '.', ',');
$CreditoCorte          = number_format($_POST["CreditoCorte"], 2, '.', ',');
$TCCorte               = number_format($_POST["TCCorte"], 2, '.', ',');
$DolaresCorte          = number_format($_POST["DolaresCorte"], 2, '.', ',');
$Dolares1Corte         = number_format($_POST["Dolares1Corte"], 2, '.', ',');
$LempirasCorte         = number_format($_POST["LempirasCorte"], 2, '.', ',');
$Lempiras1Corte        = number_format($_POST["Lempiras1Corte"], 2, '.', ',');
$DepositosCorte        = number_format($_POST["DepositosCorte"], 2, '.', ',');
$IngresosCorte         = number_format($_POST["IngresosCorte"], 2, '.', ',');
$FacturadoCorte        = number_format($_POST["FacturadoCorte"], 2, '.', ',');
$Falta                 = number_format($_POST["Falta"], 2, '.', ',');
$Sobra                 = number_format($_POST["Sobra"], 2, '.', ',');

$NotaCreditoEfectivo   = number_format($_POST["NotaCreditoEfectivo"], 2, '.', ',');
$TotalEfectivo         = number_format($_POST["TotalEfectivo"], 2, '.', ',');
$NotaCreditoCredito    = number_format($_POST["NotaCreditoCredito"], 2, '.', ',');
$TotalCredito          = number_format($_POST["TotalCredito"], 2, '.', ',');
$NotaCreditoTarjeta    = number_format($_POST["NotaCreditoTarjeta"], 2, '.', ',');
$TotalTarjeta          = number_format($_POST["TotalTarjeta"], 2, '.', ',');
$NotaCreditoDolar      = number_format($_POST["NotaCreditoDolar"], 2, '.', ',');
$TotalDolar            = number_format($_POST["TotalDolar"], 2, '.', ',');
$NotaCreditoLempiar    = number_format($_POST["NotaCreditoLempiar"], 2, '.', ',');
$TotalLempira          = number_format($_POST["TotalLempira"], 2, '.', ',');
$NotaCreditoDeposito   = number_format($_POST["NotaCreditoDeposito"], 2, '.', ',');
$TotalDeposito         = number_format($_POST["TotalDeposito"], 2, '.', ',');
$TotalNotasEmitidas    = $_POST["TotalNotasEmitidas"];
$TotlaFacturasEmitidas = $_POST["TotlaFacturasEmitidas"];
$UsuarioContabiliza = $_POST["UsuarioContabiliza"];
$TotalNotasCredito = number_format($_POST["NotaCreditoEfectivo"] + $_POST["NotaCreditoCredito"] + $_POST["NotaCreditoTarjeta"] + $_POST["NotaCreditoDolar"] + $_POST["NotaCreditoLempiar"]  + $_POST["NotaCreditoDeposito"], 2);

$TotalNotasDebito = number_format(0, 2);

if($_POST["Sobra"] > 0)
{
    $Texto = 'Sobrante';
}
elseif($_POST["Falta"] < 0)
{
    $Texto = 'Faltante';
}
else
{
    $Texto = 'Sin Diferencia';
}



$QueryTasaCambioLempira = mysqli_query($db, "SELECT *
FROM Contabilidad.TASA_CAMBIO AS A
WHERE A.TC_MONEDA = 1");
$FilaTasaCambioLempira = mysqli_fetch_array($QueryTasaCambioLempira);

$QueryTasaCambioDolar = mysqli_query($db, "SELECT *
FROM Contabilidad.TASA_CAMBIO AS A
WHERE A.TC_MONEDA = 2");
$FilaTasaCambioDolar = mysqli_fetch_array($QueryTasaCambioDolar);

$TipoCambioLempira = number_format($FilaTasaCambioLempira["TC_TASA"], 2);
$TipoCambioDolar = number_format($FilaTasaCambioDolar["TC_TASA"], 2);

$TotalEfectivoQuetzalizado = number_format($_POST["TotalEfectivo"] + $_POST["TotalDolar"] + $_POST["TotalLempira"], 2);

$TotalEfectivoTotal = number_format(($_POST["TotalEfectivo"] + $_POST["TotalDolar"] + $_POST["TotalLempira"]) - $_POST["NotaCreditoEfectivo"] + $_POST["NotaDebitoEfectivo"], 2);

$TotalCredito = number_format($_POST["CreditoCorte"] - $_POST["NotaCreditoCredito"] + $_POST["NotaDebitoCredito"] ,2);

$TotalTarjetaCredito = number_format($_POST["TCCorte"] - $_POST["NotaCreditoTarjeta"] + $_POST["NotaDebitoTarjeta"], 2);

$TotalDepositos = number_format($_POST["DepositosCorte"] - $_POST["NotaCreditoDeposito"] + $_POST["NotaDebitoDeposito"], 2);

$TotalDatosPreliminares = number_format(($_POST["EfectivoCorte"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"]) + $_POST["CreditoCorte"] + $_POST["TCCorte"] + $_POST["DepositosCorte"], 2);
$TotalDatosPreliminares1 =($_POST["EfectivoCorte"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"]) + $_POST["CreditoCorte"] + $_POST["TCCorte"] + $_POST["DepositosCorte"];
 
$TotalIngresos = number_format(($_POST["EfectivoCorte"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"]) + ($_POST["CreditoCorte"] - $_POST["NotaCreditoCredito"] + $_POST["NotaDebitoCredito"]) + ($_POST["TCCorte"] - $_POST["NotaCreditoTarjeta"] + $_POST["NotaDebitoTarjeta"]) + ($_POST["DepositosCorte"] - $_POST["NotaCreditoDeposito"] + $_POST["NotaDebitoDeposito"]), 2);
$TotalIngresosT = ($_POST["EfectivoCorte"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"]) + ($_POST["CreditoCorte"] - $_POST["NotaCreditoCredito"] + $_POST["NotaDebitoCredito"]) + ($_POST["TCCorte"] - $_POST["NotaCreditoTarjeta"] + $_POST["NotaDebitoTarjeta"]) + ($_POST["DepositosCorte"] - $_POST["NotaCreditoDeposito"] + $_POST["NotaDebitoDeposito"]);

$TotalNotasEmitidasTotal = number_format(($_POST["NotaCreditoEfectivo"] + $_POST["NotaCreditoCredito"] + $_POST["NotaCreditoTarjeta"] + $_POST["NotaCreditoDolar"] + $_POST["NotaCreditoLempiar"]  + $_POST["NotaCreditoDeposito"]) - $TotalNotasDebito, 2);
$TotalNotasEmitidasTotalT = ($_POST["NotaCreditoEfectivo"] + $_POST["NotaCreditoCredito"] + $_POST["NotaCreditoTarjeta"] + $_POST["NotaCreditoDolar"] + $_POST["NotaCreditoLempiar"]  + $_POST["NotaCreditoDeposito"]) - $TotalNotasDebito;

$FaltanteSobranteTotal = (($_POST["EfectivoCorte"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"]) + ($_POST["CreditoCorte"] - $_POST["NotaCreditoCredito"] + $_POST["NotaDebitoCredito"]) + ($_POST["TCCorte"] - $_POST["NotaCreditoTarjeta"] + $_POST["NotaDebitoTarjeta"]) + ($_POST["DepositosCorte"] - $_POST["NotaCreditoDeposito"] + $_POST["NotaDebitoDeposito"])) - ($_POST["FacturadoCorte"] - (($_POST["NotaCreditoEfectivo"] + $_POST["NotaCreditoCredito"] + $_POST["NotaCreditoTarjeta"] + $_POST["NotaCreditoDolar"] + $_POST["NotaCreditoLempiar"]  + $_POST["NotaCreditoDeposito"]) - $TotalNotasDebito)) ;

$EfectivoQuetzalizado = number_format($_POST["EfectivoCorte"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"], 2);

$EfectivoQuetzalizadoT = $_POST["EfectivoCorte"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"];

if($FaltanteSobranteTotal > 0)
{
    $Titulo = 'SOBRANTE DE CAJA';
}
elseif($FaltanteSobranteTotal < 0)
{
    $Titulo = 'FALTANTE DE CAJA';
}
else
{
    $Titulo = '';
}

if ($_POST["FaltanteSobrante"]>0) 
{
   $Falta = 0;
   $Sobra = $_POST["FaltanteSobrante"];
}
else
{
    $Falta = $_POST["FaltanteSobrante"];
   $Sobra = 0;
}

$Insert = mysqli_query($db, "INSERT INTO Bodega.CUADRE_CAJA (Usuario, Fecha, Hora, EfectivoQ, EfectivoD, EfectivoL, EfectivoNota, EfectivoDeb, EfectivoTotal, Credito, CreditoNota, CreditoDeb, CreditoTotal, Tarjeta, TarjetaNota, TarjetaDebito, TarjetaTotal, Deposito, DepositoNota, DepositoDeb, DepositoTotal, TotalDatos, TotalNotas, TotalNotasC, TotalIngresos, TotalFacturado, TotalNotasEmitidas, Sobrante, Faltante) 
    VALUES ('$Usuario', CURRENT_TIME, CURRENT_TIMESTAMP, '".$_POST["EfectivoCorte"]."', '".$_POST["DolaresCorte"]."', '".$_POST["LempirasCorte"]."', '".$_POST["NotaCreditoEfectivo"]."', '".$_POST["NotaDebitoEfectivo"]."', '".$EfectivoQuetzalizadoT."', '".$_POST["CreditoCorte"]."', '".$_POST["NotaCreditoCredito"]."', '".$_POST["NotaDebitoCredito"]."', '".$_POST["TotalCredito"]."', '".$TCCorte."', '".$_POST["NotaCreditoTarjeta"]."', '".$_POST["NotaDebitoTarjeta"]."', '".$_POST["TotalTarjetaCredito"]."', '".$_POST["DepositosCorte"]."', '".$_POST["NotaDebitoDeposito"]."', '".$_POST["NotaCreditoDeposito"]."', '".$_POST["TotalDepositos"]."', '".$TotalDatosPreliminares1."', '".$_POST["TotalNotasDebito"]."', '".$_POST["TotalNotasCredito"]."',  '".$TotalIngresosT."', '".$_POST["FacturadoCorte"]."', '".$TotalNotasEmitidasTotalT."', '$Sobra', '$Falta')");
//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = '../../../../../img/logo.png';
        $this->Image($image_file, 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0,0,"CONTROL DE INGRESOS CIERRE PARCIAL",0,1,'C');
        $this->Cell(0,0, "CAJA HELADOS" ,0,1,'C');
    }
}
//***********************************************************
//***********************************************************
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","pt", array(750, 3000), 'UTF-8', FALSE);
// Add a page
$pdf->AddPage();
$pdf->SetMargins(5,0,10, true);
$pdf->SetFont('Helvetica', '', 20);
$pdf->Cell(0,0, "Generó: $Usuario",0,1,'R');
$pdf->Cell(0,0, "$FechaHora",0,1,'R');
$pdf->SetFont('Helvetica', '', 20);
$pdf->Cell(0,0, "",0,1,'R');
$pdf->SetFont('Helvetica', '', 10);


$tbl1 .= <<<EOD
<table border="0">
    <tr style="font-size: 28px">
        <td colspan="8" ><b>Fecha:</b> $FechaImp</td>
    </tr>
    <tr style="font-size: 28px">
        <td colspan="8" ><b>Facturas Emitidas:</b> $FacturasEmitidasCorte</td>
    </tr> 
    <tr style="font-size: 28px">
        <td colspan="8" ><b>Tipo de Cambio - Lempira: </b> $TipoCambioLempira</td>
    </tr>
    <tr style="font-size: 28px">
        <td colspan="8" ><b>Tipo de Cambio - Dólar: </b> $TipoCambioDolar</td>
    </tr>
    <tr style="font-size: 20px">
        <td colspan="4"></td>
        <td align="center"><b> </b></td> 
        <td align="center" rowspan="2" valign="middle"><b>TOTAL</b></td>
    </tr>
    <tr style="font-size: 20px">
        <td></td>
        <td align="center"><b>Q</b></td>
        <td align="center"><b>$</b></td>
        <td align="center"><b>L</b></td>
        <td align="center"><b>Tot. Q</b></td>
    </tr>
    <tr style="font-size: 20px">
        <td rowspan="2">Efectivo</td>
        <td rowspan="2" align="center">$EfectivoCorte</td>
        <td align="center">$DolaresCorte</td>
        <td align="center">$LempirasCorte</td>
        <td align="center" rowspan="2" >$EfectivoQuetzalizado</td> 
        <td align="center" rowspan="2" >$EfectivoQuetzalizado</td>
    </tr>
    <tr style="font-size: 20px">
        <td align="center">$Dolares1Corte</td>
        <td align="center">$Lempiras1Corte</td>
    </tr>
    <tr style="font-size: 20px">
        <td>Crédito</td>
        <td align="center">$CreditoCorte</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">$CreditoCorte</td> 
        <td align="center">$TotalCredito</td>
    </tr>
    <tr style="font-size: 20px">
        <td>Tarjeta de Crédito</td>
        <td align="center">$TCCorte</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">$TCCorte</td> 
        <td align="center">$TotalTarjetaCredito</td>
    </tr>
    <tr style="font-size: 20px">
        <td>Depósitos</td>
        <td align="center">$DepositosCorte</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">$DepositosCorte</td> 
        <td align="center">$TotalDepositos</td>
    </tr>
    <tr style="font-size: 20px">
        <td colspan="4" align="left"><b>TOTAL DATOS PRELIMINARES</b></td>
        <td align="center">$TotalDatosPreliminares</td>
        <td align="center"></td> 
    </tr> 
    <tr style="font-size: 20px">
        <td colspan="4" align="left"><b>TOTAL INGRESOS</b></td>
        <td align="center"></td> 
        <td align="center">$TotalIngresos</td>
    </tr>
    <tr style="font-size: 20px">
        <td colspan="4" align="left"><b>TOTAL FACTURADO</b></td>
        <td align="center"></td> 
        <td align="center">$FacturadoCorte</td>
    </tr>
   
EOD;
if($_POST["FaltanteSobrante"]>0)
{ 
    $Falta =number_format($_POST["FaltanteSobrante"],2);
    $UpdSob = mysqli_query($db, "UPDATE Bodega.CIERRE_DETALLE SET CD_TOTAL_SOBRANTE = '".$_POST["FaltanteSobrante"]."' WHERE CD_USUARIO = $Usuario AND ACC_CODIGO = '$CodigoApertura'");
$tbl1 .= <<<EOD
    <tr style="font-size: 20px">
        <td colspan="4" align="left"><b>SOBRANTE DE CAJA</b></td>
        <td align="center"></td> 
        <td align="center">$Falta</td>
    </tr>
EOD;
}

if($_POST["FaltanteSobrante"]<0)
{   
     $Sobra = number_format($_POST["FaltanteSobrante"],2);
     $UpdSob = mysqli_query($db, "UPDATE Bodega.CIERRE_DETALLE SET CD_TOTAL_FALTANTE = '".$_POST["FaltanteSobrante"]."'  WHERE CD_USUARIO = $Usuario AND ACC_CODIGO = '$CodigoApertura'"); 
$tbl1 .= <<<EOD
    <tr style="font-size: 20px">
        <td colspan="4" align="left"><b>FALTANTE DE CAJA</b></td>
        <td align="center"></td> 
        <td align="center">$Sobra</td>
    </tr>
EOD;
}
$tbl1 .= <<<EOD
</table>
EOD;


$pdf->writeHTML($tbl1,0,0,0,0,'J'); 


$pdf->SetFont('Helvetica', '', 40);
$pdf->Cell(0,0, "",0,1,'R');

$pdf->SetFont('Helvetica', '', 20);

$tbl1 = <<<EOD
<table border="0">
    <tr>
    <td align="center">_______________________________________________________</td> 
    </tr>
    <tr>
    <td align="center">$UsuarioNombre</td> 
    </tr>
    <tr>
    <td align="center">Entrega</td> 
    </tr>
EOD;

$tbl1 .= <<<EOD
</table>
EOD;

$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
ob_clean();
$pdf->Output();
ob_flush();
?>