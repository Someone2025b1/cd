<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];

$i = 1;

$GLOBALS["FechaI"] = $_POST["FechaInicio"];
$GLOBALS["FechaF"] = $_POST["FechaFin"];

$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));


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
        $this->Cell(0,0,"Asociación para el Crecimiento Educativo Reg.",0,1,'C');
$this->Cell(0,0,"Cooperativo y Apoyo Turístico de Esquipulas",0,1,'C');
$this->Cell(0,0,"-ACERCATE-",0,1,'C');
        $this->SetFont('helvetica', '', 15);
        $this->Cell(0,0,"Facturas Emitidas Kiosko Restaurante 2",0,1,'C');
        $this->SetFont('helvetica', '', 12);
        $this->Cell(0,0,"Del ".date('d-m-Y', strtotime($GLOBALS["FechaI"]))." Al ".date('d-m-Y', strtotime($GLOBALS["FechaF"])) ,0,1,'C');
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("L","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,45,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(0,0, "Generó: $Usuario",0,1,'R');
$pdf->Cell(0,0, "$FechaHora",0,1,'R');
$pdf->SetFont('Helvetica', '', 8);





$SQLResolucion = "SELECT *
FROM Bodega.RESOLUCION AS A
WHERE A.RES_TIPO = 'KR2'
AND A.RES_ESTADO = 1";
$ResultResolucion = mysqli_query($db, $SQLResolucion);
while($FilaResolucion = mysqli_fetch_array($ResultResolucion))
{



$Resolucion = $FilaResolucion["RES_NUMERO"];

$DetalleResolucion = "SELECT * FROM Bodega.RESOLUCION WHERE RES_NUMERO = '".$Resolucion."'";
$ResultDetalle = mysqli_query($db, $DetalleResolucion);
while($FilaDetalle = mysqli_fetch_array($ResultDetalle))
{
    $DelAl = "DEL ".$FilaDetalle["RES_DEL"]." AL ".$FilaDetalle["RES_AL"];
    $FechaResolucion = date('d-m-Y', strtotime($FilaDetalle["RES_FECHA_RESOLUCION"]));
}

    $tbl1 = <<<EOD
    <tr>
    <td colspan="6" align="center" style="background-color: #C9C9C9">RESOLUCION $Resolucion CON FECHA $FechaResolucion, $DelAl</td>
    </tr>
EOD;

$tbl1 .= <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td style="background-color: #C9C9C9"><b>No.</b></td>
    <td style="background-color: #C9C9C9"><b>Número Factura</b></td>
    <td style="background-color: #C9C9C9"><b>Fecha</b></td>
    <td style="background-color: #C9C9C9"><b>Monto</b></td>
    <td style="background-color: #C9C9C9"><b>Estado</b></td>
    </tr>
EOD;

$Consulta1 = "SELECT * FROM Bodega.FACTURA_KS_2 WHERE F_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."' AND RES_NUMERO = '".$Resolucion."' ORDER BY F_FECHA_TRANS, F_SERIE, F_NUMERO";
$Resultado1 = mysqli_query($db, $Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
$Contador = $i;
$Serie = $row1["F_SERIE"];
$Numero = $row1["F_DTE"];
$Fecha = date('d-m-Y', strtotime($row1["F_FECHA_TRANS"]));
$Monto = 'Q. '.number_format($row1["F_TOTAL"], 2, '.', ',');
$SumaTotalTotal = $SumaTotalTotal + $row1["F_TOTAL"];
if($row1["F_ESTADO"] == 1)
{
    $Estado = 'EMITIDO';
}
elseif($row1["F_ESTADO"] == 2)
{
    $Estado = 'ANULADO';
}

$tbl1 .= <<<EOD
    <tr>
    <td>$Contador</td>
    <td>$Numero</td>
    <td>$Fecha</td>
    <td>$Monto</td>
    <td>$Estado</td>
    </tr>
EOD;
$i++;
}
}

$SumaTotalTotal = 'Q. '.number_format($SumaTotalTotal, 2, '.', ',');
$tbl1 .= <<<EOD
    <tr>
    <td></td>
    <td></td>
    <td>TOTAL</td>
    <td>$SumaTotalTotal</td>
    <td></td>
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