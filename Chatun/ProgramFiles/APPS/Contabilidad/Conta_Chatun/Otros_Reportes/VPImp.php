<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../Script/funciones.php");

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];

$i = 1;

$GLOBALS["FechaI"] = $_POST["FechaInicio"];
$GLOBALS["FechaF"] = $_POST["FechaFin"];

$GLOBALS["NombreReceta"] = utf8_encode(saber_nombre_receta($_POST[Producto]).' - '.saber_nombre_bodega($_POST[Bodega]));

$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));

if($_POST["Bodega"] == 7)
{
    $Tabla = "FACTURA_RS";
    $Tabla1 = "FACTURA_RS_DETALLE";
}
else
{
    $Tabla = "FACTURA";
    $Tabla1 = "FACTURA_DETALLE";
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
        $this->SetFont('helvetica', 'B', 15);
        // Title
        $this->Cell(0,0,"Asociación para el Crecimiento Educativo Reg.",0,1,'C');
        $this->Cell(0,0,"Cooperativo y Apoyo Turístico de Esquipulas",0,1,'C');
        $this->Cell(0,0,"-ACERCATE-",0,1,'C');
        $this->SetFont('helvetica', '', 15);
        $this->Cell(0,0,"Ventas por Producto",0,1,'C');
        $this->Cell(0,0,$GLOBALS["NombreReceta"],0,1,'C');
        $this->SetFont('helvetica', '', 12);
        $this->Cell(0,0,"Del ".date('d-m-Y', strtotime($GLOBALS["FechaI"]))." Al ".date('d-m-Y', strtotime($GLOBALS["FechaF"])) ,0,1,'C');
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,50,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(0,0, "Generó: $Usuario",0,1,'R');
$pdf->Cell(0,0, "$FechaHora",0,1,'R');
$pdf->SetFont('Helvetica', '', 8);






$tbl1 .= <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td style="background-color: #C9C9C9"><b>No.</b></td>
    <td style="background-color: #C9C9C9"><b>Fecha</b></td>
    <td style="background-color: #C9C9C9"><b>Producto</b></td>
    <td style="background-color: #C9C9C9"><b>Cantidad</b></td>
    <td style="background-color: #C9C9C9"><b>Precio Unitario</b></td>
    <td style="background-color: #C9C9C9"><b>Total</b></td>
    </tr>
EOD;

$Consulta1 = "SELECT B.F_FECHA_TRANS, A.RS_CODIGO, C.RS_NOMBRE, A.FD_CANTIDAD, A.FD_PRECIO_UNITARIO, A.FD_SUBTOTAL
FROM Bodega.$Tabla1 AS A
INNER JOIN Bodega.$Tabla AS B ON A.F_CODIGO = B.F_CODIGO
INNER JOIN Bodega.RECETA_SUBRECETA AS C ON A.RS_CODIGO = C.RS_CODIGO
WHERE B.F_FECHA_TRANS BETWEEN '".$_POST["FechaInicio"]."' AND '".$_POST["FechaFin"]."'
AND A.RS_CODIGO = '".$_POST[Producto]."'";
$Resultado1 = mysqli_query($db, $Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
$Contador = $i;
$Fecha = date('d-m-Y', strtotime($row1[F_FECHA_TRANS]));
$Producto = $row1["RS_NOMBRE"];
$Cantidas = $row1["FD_CANTIDAD"];
$PrecioUnitario = 'Q. '.number_format($row1["FD_PRECIO_UNITARIO"], 2, '.', ',');
$Subtotal = 'Q. '.number_format($row1["FD_SUBTOTAL"], 2, '.', ',');
$SumaTotalTotal = $SumaTotalTotal + $row1["FD_SUBTOTAL"];
$SumaCantidadTotal = $SumaCantidadTotal + $row1["FD_CANTIDAD"];

$tbl1 .= <<<EOD
    <tr>
    <td>$Contador</td>
    <td>$Fecha</td>
    <td>$Producto</td>
    <td>$Cantidas</td>
    <td>$PrecioUnitario</td>
    <td>$Subtotal</td>
    </tr>
EOD;
$i++;
}

$SumaTotalTotal = 'Q. '.number_format($SumaTotalTotal, 2, '.', ',');
$SumaCantidadTotal = number_format($SumaCantidadTotal, 2, '.', ',');
$tbl1 .= <<<EOD
    <tr>
    <td></td>
    <td></td>
    <td>TOTAL</td>
    <td>$SumaCantidadTotal</td>
    <td></td>
    <td>$SumaTotalTotal</td>
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