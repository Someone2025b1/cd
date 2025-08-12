<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$Debe         = 0;
$Haber        = 0;
$Saldo        = 0;
$DebeMostrar  = 0;
$HaberMostrar = 0;
$SaldoMostrar = 0;
$SaldoTotal = 0;
$Solicitante = $_GET["Solicitante"];
$FechaIni = $_GET["FechaInicio"];
$FechaFin = $_GET["FechaFin"];
$Usuario = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s');
$GLOBALS["Nombre"] = saber_nombre_colaborador($Solicitante);
$GLOBALS["CIF"] = $Solicitante;

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
        $this->Cell(0,0,"                    Integración de Funcionarios/Empleados   ",0,1,'C');
        $this->Cell(0,0,"                    ".$GLOBALS["CIF"]." - ".$GLOBALS["Nombre"]."   ",0,1,'C');
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("L","mm","Letter", TRUE, 'UTF-8', FALSE);
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
    <td align="center" style="background-color: #C9C9C9; width: 75px"><b>Fecha</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Comprobante</b></td>
    <td align="center" style="background-color: #C9C9C9; width: 300px"><b>Concepto</b></td>
    <td align="right" style="background-color: #C9C9C9; width: 75px"><b>Debe</b></td>
    <td align="right" style="background-color: #C9C9C9; width: 75px"><b>Haber</b></td>
    <td align="right" style="background-color: #C9C9C9; width: 75px"><b>Saldo</b></td>
    </tr>
EOD;
$Consulta = "SELECT TRANSACCION.*, TRANSACCION_DETALLE.TRAD_CARGO_CONTA, TRANSACCION_DETALLE.TRAD_ABONO_CONTA
FROM Contabilidad.TRANSACCION, Contabilidad.TRANSACCION_DETALLE
WHERE TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO
AND TRANSACCION_DETALLE.N_CODIGO = '1.01.04.006'
AND TRANSACCION.TRA_TIPO_FACTURA_VENTA = 'FE'
AND TRANSACCION.TRA_CIF_COLABORADOR = ".$Solicitante."
AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."'
ORDER BY TRANSACCION.TRA_FECHA_TRANS";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
    $Fecha = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
    $Comprobante = $row["TRA_NO_HOJA"];
    $Concepto = $row["TRA_CONCEPTO"];
    $Debe = $row["TRAD_CARGO_CONTA"];
    $Haber = $row["TRAD_ABONO_CONTA"];
    $Saldo = $Debe - $Haber;
    $SaldoTotal = $SaldoTotal +($Saldo);

    $DebeMostrar  = number_format($Debe, 2, '.', ',');
    $HaberMostrar = number_format($Haber, 2, '.', ',');
    $SaldoMostrar = number_format($SaldoTotal, 2, '.', ',');

    $tbl1 .= <<<EOD
    <tr>
    <td align="center" style="width: 75px">$Fecha</td>
    <td align="center">$Comprobante</td>
    <td align="left" style="width: 300px">$Concepto</td>
    <td align="right" style="width: 75px">$DebeMostrar</td>
    <td align="right" style="width: 75px">$HaberMostrar</td>
    <td align="right" style="width: 75px">$SaldoMostrar</td>
    </tr>
EOD;
}


$tbl1 .= <<<EOD
</table>
EOD;
$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
ob_clean();
$pdf->Output();
ob_flush();
?>