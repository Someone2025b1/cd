<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$GLOBALS["TipoCorte"] = $_POST["TipoCorte"];

$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$Tipo = $_POST["Tipo"];
$FechaImp              = date('d-m-Y', strtotime($_POST["FechaImp"]));
$FacturasEmitidasCorte = $_POST["FacturasEmitidasCorte"];
$FacturasAnul          = $_POST["FacturasAnul"];
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
$FaltanteSobrante      = number_format($_POST["FaltanteSobrante"], 2, '.', ',');

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

$TotalNotasCredito = number_format($_POST["NotaCreditoEfectivo"] + $_POST["NotaCreditoCredito"] + $_POST["NotaCreditoTarjeta"] + $_POST["NotaCreditoDolar"] + $_POST["NotaCreditoLempiar"]  + $_POST["NotaCreditoDeposito"], 2);

$TotalNotasDebito = number_format(0, 2);

if($_POST["FaltanteSobrante"] > 0)
{
    $Texto = 'Sobrante';
}
elseif($_POST["FaltanteSobrante"] < 0)
{
    $Texto = 'Faltante';
}
else
{
    $Texto = 'Sin Diferencia';
}

$AnuladasFac = number_format($FacturasAnul,2);

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

$TotalCredito = number_format($_POST["CreditoCorte"],2);

$credit=$_POST["TCCorte"] + $_POST["TotalAnticipoTar"];

$TotalTarjetaCredito = number_format($credit, 2);

$TotalDepositos = number_format(($_POST["DepositosCorte"]+$_POST["TotalAnticipoDep"]), 2);

$TotalDatosPreliminares = number_format(($_POST["EfectivoCorte"]+ $_POST["TotalAnticipoMF"] + $_POST["TotalChequeCC"] + $_POST["TotalExpIvaCC"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"]) + $_POST["CreditoCorte"] + $_POST["TCCorte"] + $_POST["DepositosCorte"] + $_POST["TotalAnticipoDep"] + $_POST["TotalAnticipoTar"], 2);

$TotalIngresos = number_format($_POST["EfectivoCorte"]+ $_POST["TotalAnticipoMF"] + $_POST["TotalChequeCC"] + $_POST["TotalExpIvaCC"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"] + $_POST["CreditoCorte"] + $_POST["TCCorte"] + $_POST["DepositosCorte"] + $_POST["TotalAnticipoDep"] + $_POST["TotalAnticipoTar"], 2);

$TotalNotasEmitidasTotal = number_format(($_POST["NotaCreditoEfectivo"] + $_POST["NotaCreditoCredito"] + $_POST["NotaCreditoTarjeta"] + $_POST["NotaCreditoDolar"] + $_POST["NotaCreditoLempiar"]  + $_POST["NotaCreditoDeposito"]) - $TotalNotasDebito, 2);


$FaltanteSobranteTotal = (($_POST["EfectivoCorte"]+ $_POST["TotalAnticipoMF"] + $_POST["TotalChequeCC"] + $_POST["TotalExpIvaCC"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"]) + ($_POST["CreditoCorte"] - $_POST["NotaCreditoCredito"] + $_POST["NotaDebitoCredito"]) + ($_POST["TCCorte"] - $_POST["NotaCreditoTarjeta"] + $_POST["NotaDebitoTarjeta"]) + ($_POST["DepositosCorte"] - $_POST["NotaCreditoDeposito"] + $_POST["NotaDebitoDeposito"] + $_POST["TotalAnticipoDep"] + $_POST["TotalAnticipoTar"]))  - ($_POST["FacturadoCorte"]) ;

$EfectivoQuetzalizado = number_format($_POST["EfectivoCorte"] + $_POST["Dolares1Corte"] + $_POST["Lempiras1Corte"], 2);

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

$FaltanteSobranteTotal = number_format($FaltanteSobranteTotal,2);
$Query1 = mysqli_fetch_array(mysqli_query($db, "SELECT a.Usuario 
FROM Bodega.CUADRE_CAJA a WHERE DATE(a.Fecha) = '".$_POST['FechaImp']."' and a.Tipo = $Tipo")); 
$RowCont1 = mysqli_fetch_array(mysqli_query($db, "SELECT a.nombre FROM info_bbdd.usuarios a WHERE a.id_user = $Query1[Usuario]"));
$UsuarioNombre1 = $RowCont1["nombre"];

$Contabilidad = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(a.ACC_USUARIO_CONTABILIZA) as Cont FROM Bodega.CIERRE_DETALLE a 
INNER JOIN Bodega.APERTURA_CIERRE_CAJA b ON a.ACC_CODIGO = b.ACC_CODIGO
WHERE  b.ACC_FECHA = '".$_POST['FechaImp']."' and b.ACC_TIPO = $Tipo
 "));
$RowCont = mysqli_fetch_array(mysqli_query($db, "SELECT a.nombre FROM info_bbdd.usuarios a WHERE a.id_user = $Contabilidad[Cont]"));
$Contabiliza = $RowCont["nombre"];
//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = '../../../../../img/logo.png';
        $this->Image($image_file, 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 30);
        // Title
        $this->Cell(0,0,"CONTROL DE INGRESOS",0,1,'C');
        $this->Cell(0,0, $GLOBALS["TipoCorte"] ,0,1,'C');
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,45,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(0,0, "Generó: $Usuario",0,1,'R');
$pdf->Cell(0,0, "$FechaHora",0,1,'R');
$pdf->SetFont('Helvetica', '', 20);
$pdf->Cell(0,0, "",0,1,'R');
$pdf->SetFont('Helvetica', '', 10);

$RecibosdeCaja=$_POST["AnticiposEmitidos"];
$TotalAnticipoMF=number_format($_POST["TotalAnticipoMF"],2) ;
$TotalChequeCC=number_format($_POST["TotalChequeCC"],2) ;
$TotalExpIvaCC=number_format($_POST["TotalExpIvaCC"],2) ;


if($GLOBALS["TipoCorte"]=="Eventos"){
    $tblAnt = <<<EOD
    <tr>
        <td colspan="8"><b>Recibos de Caja Emitidos:</b> $RecibosdeCaja</td>
    </tr>

EOD;

}else{
    $tblAnt ="";

}

if($GLOBALS["TipoCorte"]=="Eventos"){
    $tblAnt1 = <<<EOD
    <tr style="font-size: 8px">
        <td>Pago Con Anticipo</td>
        <td align="right">$TotalAnticipoMF</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$TotalAnticipoMF</td>
        <td align="right"> </td>
        <td align="right"> </td>
        <td align="right">$TotalAnticipoMF</td>
    </tr>
    <tr style="font-size: 8px">
        <td>Pago Con Cheque</td>
        <td align="right">$TotalChequeCC</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$TotalChequeCC</td>
        <td align="right"> </td>
        <td align="right"> </td>
        <td align="right">$TotalChequeCC</td>
    </tr>
    <tr style="font-size: 8px">
        <td>Retención/Exepción de IVA</td>
        <td align="right">$TotalExpIvaCC</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$TotalExpIvaCC</td>
        <td align="right"> </td>
        <td align="right"> </td>
        <td align="right">$TotalExpIvaCC</td>
    </tr>

EOD;

}else{
    $tblAnt1 ="";

}

$tbl1 .= <<<EOD
<table border="1">
    <tr>
        <td colspan="8"><b>Fecha:</b> $FechaImp</td>
    </tr>
    <tr>
        <td colspan="8"><b>Facturas Emitidas:</b> $FacturasEmitidasCorte</td>
    </tr>
    $tblAnt
    <tr>
        <td colspan="8"><b>Notas de Crédito Emitidas: </b> $TotalNotasEmitidas</td>
    </tr>
    <tr>
        <td colspan="8"><b>Notas de Débito Emitidas: </b> $TotalNotasDebitoEmitidas</td>
    </tr>
    <tr>
        <td colspan="8"><b>Facturas Anuladas: </b> $AnuladasFac</td>
    </tr>
    <tr>
        <td colspan="8"><b>Tipo de Cambio - Lempira: </b> $TipoCambioLempira</td>
    </tr>
    <tr>
        <td colspan="8"><b>Tipo de Cambio - Dólar: </b> $TipoCambioDolar</td>
    </tr>
    <tr style="font-size: 8px">
        <td colspan="4"></td>
        <td align="center"><b>Datos Preliminares</b></td>
        <td align="center" rowspan="2" valign="middle"><b>Notas de Crédito</b></td>
        <td align="center" rowspan="2" valign="middle"><b>Notas De Débito</b></td>
        <td align="center" rowspan="2" valign="middle"><b>TOTAL</b></td>
    </tr>
    <tr style="font-size: 8px">
        <td></td>
        <td align="center"><b>Quetzal</b></td>
        <td align="center"><b>Dólar</b></td>
        <td align="center"><b>Lempira</b></td>
        <td align="center"><b>Tot. Quetzalizado</b></td>
    </tr>
    <tr style="font-size: 8px">
        <td rowspan="2">Efectivo</td>
        <td rowspan="2" align="right">$EfectivoCorte</td>
        <td align="right">$DolaresCorte</td>
        <td align="right">$LempirasCorte</td>
        <td align="right" rowspan="2" >$EfectivoQuetzalizado</td>
        <td align="right" rowspan="2" > </td>
        <td align="right" rowspan="2" > </td>
        <td align="right" rowspan="2" >$EfectivoQuetzalizado</td>
    </tr>
    <tr style="font-size: 8px">
        <td align="right">$Dolares1Corte</td>
        <td align="right">$Lempiras1Corte</td>
    </tr>
    <tr style="font-size: 8px">
        <td>Crédito</td>
        <td align="right">$CreditoCorte</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$CreditoCorte</td>
        <td align="right"> </td>
        <td align="right"> </td>
        <td align="right">$TotalCredito</td>
    </tr>
    <tr style="font-size: 8px">
        <td>Tarjeta de Crédito</td>
        <td align="right">$TCCorte</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$TCCorte</td>
        <td align="right"> </td>
        <td align="right"> </td>
        <td align="right">$TotalTarjetaCredito</td>
    </tr>
    <tr style="font-size: 8px">
        <td>Depósitos</td>
        <td align="right">$DepositosCorte</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$DepositosCorte</td>
        <td align="right"> </td>
        <td align="right"> </td>
        <td align="right">$TotalDepositos</td>
    </tr>
    $tblAnt1
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>TOTAL DATOS PRELIMINARES</b></td>
        <td align="right">$TotalDatosPreliminares</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>TOTAL NOTAS</b></td>
        <td align="right"></td>
        <td align="right">$TotalNotasCredito</td>
        <td align="right">$TotalNotasDebito</td>
        <td align="right"></td>
    </tr>
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>TOTAL INGRESOS</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$TotalIngresos</td>
    </tr>
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>TOTAL FACTURADO</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$FacturadoCorte</td>
    </tr>
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>TOTAL ANULADO</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$AnuladasFac</td>
    </tr> 
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>$Titulo</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$FaltanteSobranteTotal</td>
    </tr>
EOD;
if($TotalNotasEmitidas>0)
{  
$NC = "SELECT *
FROM Contabilidad.TRANSACCION AS A
INNER JOIN Bodega.FACTURA_KS AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
WHERE A.TT_CODIGO = 17
AND A.TRA_FECHA_TRANS =  '".$_POST['FechaImp']."'
 ";
$Result = mysqli_query($db, $NC);
while($row1 = mysqli_fetch_array($Result))
{ 
   $Nota = $row1["TRA_DTE"];
   $Fac = $row1["F_CAE"];
   $FechaFac = cambio_fecha($row1["F_FECHA_TRANS"]);
} 

$tbl1 .= <<<EOD
    <tr style="font-size: 8px">
        <td colspan="16">*Nota de crédito $Nota aplicada a la factura número $Fac, fecha $FechaFac <br></td>
    </tr>
EOD;
}
$tbl1 .= <<<EOD
</table>
EOD;


$pdf->writeHTML($tbl1,0,0,0,0,'J'); 


$pdf->SetFont('Helvetica', '', 40);
$pdf->Cell(0,0, "",0,1,'R');

$pdf->SetFont('Helvetica', '', 10);

$tbl1 = <<<EOD
<table border="0">
   <tr>
    <td align="center">______________________________</td>
    <td align="center">______________________________</td>
    </tr>
    <tr>
    <td align="center">$UsuarioNombre1</td>
    <td align="center">$Contabiliza</td>
    </tr>
    <tr>
    <td align="center">Entrega</td>
    <td align="center">Recibe</td>
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