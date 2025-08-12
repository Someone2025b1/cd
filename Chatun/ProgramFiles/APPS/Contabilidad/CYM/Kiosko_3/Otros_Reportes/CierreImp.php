<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$GLOBALS["TipoCorte"] = $_POST["TipoCorte"];

$Usuario = $_SESSION["iduser"];
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
$FaltanteSobrante = number_format($_POST["FaltanteSobrante"], 2, '.', ',');

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


$tbl1 .= <<<EOD
<table border="0">
    <tr>
    <td><b>Fecha:</b> $FechaImp</td>
    <td><b>Facturas Emitidas:</b> $FacturasEmitidasCorte</td>
    <td><b>Facturas Anuladas:</b> $FacturasAnuladasCorte</td>
    <td><b>Facturas:</b> Serie $SerieFacturaCorte de la $DelFacturaCorte a la $AlFacturaCorte</td>
    </tr>
    <tr>
    <td colspan="2" align="left"><b>Efectivo</b></td>
    <td colspan="2" align="right">Q. $EfectivoCorte</td>
    </tr>
    <tr>
    <td colspan="2" align="left"><b>Crédito</b></td>
    <td colspan="2" align="right">Q. $CreditoCorte</td>
    </tr>
    <tr>
    <td colspan="2" align="left"><b>Tarjeta Crédito</b></td>
    <td colspan="2" align="right">Q. $TCCorte</td>
    </tr>
    <tr>
    <td colspan="2" align="left"><b>Dólar</b></td>
    <td align="left">$. $DolaresCorte</td>
    <td align="right">Q. $Dolares1Corte</td>
    </tr>
    <tr>
    <td colspan="2" align="left"><b>Lempira</b></td>
    <td align="left">L. $LempirasCorte</td>
    <td align="right">Q. $Lempiras1Corte</td>
    </tr>
    <tr>
    <td colspan="2" align="left"><b>Depósitos</b></td>
    <td colspan="2" align="right">Q. $DepositosCorte</td>
    </tr>
    <tr>
    <td colspan="2" align="right" style="font-size: 12px"><b>Total Ingresos</b></td>
    <td colspan="2" align="right" style="font-size: 12px">Q. $IngresosCorte</td>
    </tr>
    <tr>
    <td colspan="2" align="right" style="font-size: 12px"><b>Total Facturado</b></td>
    <td colspan="2" align="right" style="font-size: 12px">Q. $FacturadoCorte</td>
    </tr>
    <tr>
    <td colspan="2" align="right" style="font-size: 12px"><b>$Texto</b></td>
    <td colspan="2" align="right" style="font-size: 12px">Q. $FaltanteSobrante</td>
    </tr>
EOD;

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