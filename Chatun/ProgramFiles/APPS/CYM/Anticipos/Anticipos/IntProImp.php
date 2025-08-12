<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$TotalAperturas = 0;
$TotalCancelaciones = 0;
$Saldo = 0;
$Solicitante = $_GET["Solicitante"];
$FechaIni = $_GET["FechaInicio"];
$FechaFin = $_GET["FechaFin"];
$Usuario = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s');


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
        $this->Cell(0,0,"                    Integración de Anticipos   ",0,1,'C');
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,10,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(0,0, "Generó: $Usuario",0,1,'R');
$pdf->Cell(0,0, "$FechaHoy",0,1,'R');
$pdf->SetFont('Helvetica', '', 8);


$tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
    <td align="center" style="background-color: #C9C9C9"><b>Fecha</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Comprobante</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>No. Anticipo</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Concepto</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Aperturas</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Cancelaciones</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Saldo</b></td>
    </tr>
EOD;
$Consulta = "SELECT TRA_TOTAL AS TOTAL_ANTICIPOS, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_CORRELATIVO, TRA_NO_HOJA , TRA_CODIGO
FROM Contabilidad.TRANSACCION
WHERE TT_CODIGO = 10
AND E_CODIGO = 2
AND TRA_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."'
AND TRA_SOLICITA_GASTO = ".$Solicitante."
ORDER BY TRA_FECHA_TRANS";
$Resultado = mysqli_query($db,$Consulta);
while($row = mysqli_fetch_array($Resultado))
{
$Fecha       = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
$Comprobante = $row["TRA_NO_HOJA"];
$Anticipo    = $row["TRA_CORRELATIVO"];
$Descripcion = utf8_encode($row["TRA_CONCEPTO"]);
$Apertura    = number_format($row["TOTAL_ANTICIPOS"], 2, '.', ',');
$Cancelacion = number_format(0.00, 2, '.', ',');
$Codigo      = $row["TRA_CODIGO"];
$TotalAperturas = $TotalAperturas + $row["TOTAL_ANTICIPOS"];
$Saldo = $Saldo + $row["TOTAL_ANTICIPOS"];
$tbl1 .= <<<EOD
<tr>
<td align="center"><b>$Fecha</b></td>
<td align="center"><b>$Comprobante</b></td>
<td align="center"><b>$Anticipo</b></td>
<td align="center"><b>$Descripcion</b></td>
<td align="center"><b>$Apertura</b></td>
<td align="center"><b>$Cancelacion</b></td>
<td align="center"><b>$Saldo</b></td>
</tr>
EOD;
$Consulta1 = "SELECT TRA_TOTAL AS TOTAL_ANTICIPOS, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_CORRELATIVO, TRA_NO_HOJA 
FROM Contabilidad.TRANSACCION
WHERE TRA_ANTICIPO = '".$Codigo."'
ORDER BY TRA_FECHA_TRANS";
$Resultado1 = mysqli_query($db,$Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
    $Fecha       = date('d-m-Y', strtotime($row1["TRA_FECHA_TRANS"]));
$Comprobante = $row1["TRA_NO_HOJA"];
$Anticipo    = $row1["TRA_CORRELATIVO"];
$Descripcion = utf8_encode($row1["TRA_CONCEPTO"]);
$Cancelacion    = number_format($row1["TOTAL_ANTICIPOS"], 2, '.', ',');
$Apertura = number_format(0.00, 2, '.', ',');
$Saldo = $Saldo - $row["TOTAL_ANTICIPOS"];
$tbl1 .= <<<EOD
<tr>
<td align="center">$Fecha</td>
<td align="center">$Comprobante</td>
<td align="center">$Anticipo</td>
<td align="center">$Descripcion</td>
<td align="center">$Apertura</td>
<td align="center">$Cancelacion</td>
<td align="center"><b>$Saldo</b></td>
</tr>
EOD;
$TotalCancelaciones = $TotalCancelaciones + $row1["TOTAL_ANTICIPOS"];
}
}

$TotalCancelaciones = number_format($TotalCancelaciones, 2, '.', ',');
$TotalAperturas =number_format($TotalAperturas, 2, '.', ',');

$tbl1 .= <<<EOD
<tr>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"><b>Total</b></td>
<td align="center"><b>$TotalAperturas</b></td>
<td align="center"><b>$TotalCancelaciones</b></td>
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