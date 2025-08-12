<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$TablaProducto = <<<EOD
    <table cellspacing="0.5" cellpadding="0.5" border="0.5">
    <tr style="border: 2px;">
    <td align="center" style="font-size: 14px; width: 20%;">No Orden</td>
    <td align="center" style="font-size: 14px; width: 40%;">Fecha</td>
    <td align="center" style="font-size: 14px; width: 40%;">RESTAURANTE</td>
    </tr>
EOD;
$cont = 0;
$QueryOrdenes = mysqli_query($db,"SELECT A.F_CODIGO, A.F_ORDEN, A.F_OBSERVACIONES, A.F_FECHA_TRANS, C.B_NOMBRE, C.B_CODIGO
                                FROM Bodega.FACTURA AS A JOIN Bodega.TRANSACCION AS B ON A.F_CODIGO = B.F_CODIGO JOIN Bodega.BODEGA AS C ON B.B_CODIGO = C.B_CODIGO
                                WHERE A.F_REALIZADA = 1 
                                ORDER BY A.F_FECHA_TRANS ASC");
while($FilaOrdenes = mysqli_fetch_array($QueryOrdenes))
{
    $fecha_inicio = date("2022-10-20");
    $fecha_fin = date("2022-10-20");
    $restaura = 1;
    

        if (($FilaOrdenes["F_FECHA_TRANS"] <= $fecha_inicio) and ($FilaOrdenes["F_FECHA_TRANS"] >= $fecha_fin) and ($FilaOrdenes["B_CODIGO"] == $restaura)){

            $NoOrden = $FilaOrdenes["F_ORDEN"];
            $FechaOrden = $FilaOrdenes["F_FECHA_TRANS"];
            $res = $FilaOrdenes["B_NOMBRE"];
    
            $TablaProducto .= <<<EOD
            <tr style="border: 2px;">
                <td align="left" style="font-size: 12px; width: 20%;"><strong> #  $NoOrden </strong></td>
                <td align="left" style="font-size: 12px; width: 40%;"><strong>  $FechaOrden </strong></td>
                <td align="left" style="font-size: 12px; width: 40%;"><strong>  $res </strong></td> 
            </tr>
            EOD;
            $cont= $cont+1;

    }
}
$TablaProducto .= <<<EOD
<tr>
    <td align="right"  style="font-size: 14px width: 30%;">TOTAL OORDENES</td>
    <td align="right" colspan="2"style="font-size: 14px width: 70%;">$cont</td>
</tr>
</table>
EOD;
//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Legal", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,15,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 30);
$pdf->Cell(0,0, "Reportes de Ordenes",0,1,'C');
$pdf->SetFont('Helvetica', 'B', 30);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->writeHTML($TablaProducto,0,0,0,0,'J'); 
// force print dialog
$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();
?>					
	