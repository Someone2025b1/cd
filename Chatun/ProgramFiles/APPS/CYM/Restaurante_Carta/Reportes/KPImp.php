<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];

$TotalGeneralCargos = 0;
$TotalGeneralAbonos = 0;

$Cargos = 0;
$SaldoTotal = 0;
$i        = 1;


$GLOBALS["FechaI"] = $_POST["FechaInicio"];
$GLOBALS["FechaF"] = $_POST["FechaFin"];
$Bodega = $_POST["Bodega"];
$Producto = $_POST["Producto"];

$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));


$TotalCargos = 0;
$TotalAbonos = 0;

$tbl1 = <<<EOD
<table border="0">
    <tr>
    <td align="center" style="background-color: #C9C9C9; width: 50"><b>No.</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Fecha</b></td>
    <td align="center" style="background-color: #C9C9C9; width: 150"><b>Tipo</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Producto</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Ingresos</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Egresos</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Saldo</b></td>
    </tr>
EOD;

$Consulta = "SELECT TRANSACCION.*, TRANSACCION_DETALLE.*, TIPO_TRANSACCION.TT_NOMBRE, PRODUCTO.P_NOMBRE 
            FROM Bodega.TRANSACCION, Bodega.TRANSACCION_DETALLE, Bodega.TIPO_TRANSACCION, Bodega.PRODUCTO
            WHERE TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO
            AND TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO
            AND TRANSACCION_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
            AND (TRANSACCION.TT_CODIGO = 1 OR TRANSACCION.TT_CODIGO = 2 OR TRANSACCION.TT_CODIGO = 5 OR TRANSACCION.TT_CODIGO = 6 OR TRANSACCION.TT_CODIGO = 7 OR TRANSACCION.TT_CODIGO = 9)
            AND TRANSACCION.B_CODIGO = ".$Bodega."
            AND TRANSACCION_DETALLE.P_CODIGO = ".$Producto."
            AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$_POST["FechaInicio"]."' AND '".$_POST["FechaFin"]."'
            ORDER BY TRANSACCION.TRA_FECHA_TRANS, TRANSACCION.TRA_HORA";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
    $Fecha = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
    $Tipo     = $row["TT_NOMBRE"];
    $Producto     = $row["P_NOMBRE"];
    $Ingresos = $row["TRAD_CARGO_PRODUCTO"];
    $Egresos  = $row["TRAD_ABONO_PRODUCTO"];
    $Saldo    = $Ingresos - $Egresos;
    $SaldoTotal = $SaldoTotal + $Saldo;
        $tbl1 .= <<<EOD
    <tr>
    <td align="left" style="width: 50">$i</td>
    <td align="left">$Fecha</td>
    <td align="left" style="width: 150">$Tipo</td>
    <td align="left">$Producto</td>
    <td align="right">$Ingresos</td>
    <td align="right">$Egresos</td>
    <td align="right">$SaldoTotal</td>
    </tr>
EOD;
    $i++;
}

$tbl1 .= <<<EOD
</table>
EOD;

//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = '../../../../../img/logo.png';
        $this->Image($image_file, 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 15);
        // Title
        $this->Cell(0,0,"Asociación para el Crecimiento Educativo Reg.",0,1,'C');
$this->Cell(0,0,"Cooperativo y Apoyo Turístico de Esquipulas",0,1,'C');
$this->Cell(0,0,"-ACERCATE-",0,1,'C');
        $this->SetFont('helvetica', '', 15);
        $this->Cell(0,0,"Kardex de Producto",0,1,'C');
        $this->SetFont('helvetica', '', 12);
        $this->Cell(0,0,"Del ".$GLOBALS["FechaI"]." Al ".$GLOBALS["FechaF"] ,0,1,'C');
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("L","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,40,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(0,0, "Generó: $Usuario",0,1,'R');
$pdf->Cell(0,0, "$FechaHora",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', '', 8);
$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
ob_clean();
$pdf->Output();
ob_flush();
?>