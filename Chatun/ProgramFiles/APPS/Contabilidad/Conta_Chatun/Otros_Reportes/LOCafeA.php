<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");



$cont = 0;
$fecha_inicio = $_POST["FechaInicio"];
$fecha_fin = $_POST["FechaFin"];
$contatemp = 0;
$fechatemp = $fecha_inicio;
$tipodereporte = $_POST["TipoReporte"];

if ($tipodereporte == 1){
    $TablaProducto = <<<EOD
        <table  border="0.1">
        <tr style="border: 1px;">
        <td align="center" style="font-size: 14px; width: 35%;">NO. ORDEN</td>
        <td align="center" style="font-size: 14px; width: 35%;">HORA</td>
        <td align="center" style="font-size: 14px; width: 30%;">MONTO</td>
        </tr>
    EOD;

    $QueryOrdenes = mysqli_query($db,"SELECT A.F_CODIGO, A.F_ORDEN, A.F_FECHA_TRANS, A.F_HORA, A.F_TOTAL
                                    FROM Bodega.FACTURA_KS AS A 
                                    WHERE A.F_ESTADO = 1 
                                    ORDER BY A.F_FECHA_TRANS ASC");
    while($FilaOrdenes = mysqli_fetch_array($QueryOrdenes))
    {
            if (($FilaOrdenes["F_FECHA_TRANS"] >= $fecha_inicio) and ($FilaOrdenes["F_FECHA_TRANS"] <= $fecha_fin)){

                $NoOrden = $FilaOrdenes["F_ORDEN"];
                $FechaOrden = $FilaOrdenes["F_FECHA_TRANS"];
                $HoraOrden = $FilaOrdenes["F_HORA"];
                $MontoOrden = $FilaOrdenes["F_TOTAL"];
                $horasin = new DateTime($HoraOrden);
                $hora = $horasin->format('g:i a');
                

                if($fechatemp==$FechaOrden){
                    $contorden = $contorden +1;
                    $TablaProducto .= <<<EOD
                    <tr style="border: 2px;">
                        <td align="left"  style="font-size: 12px; font-weight: normal; width: 35%;"> #  $contorden </td>
                        <td type="time" align="left" style="font-size: 12px; font-weight: normal; width: 35%;"> $hora</td>
                        <td type="time" align="left" style="font-size: 12px; font-weight: normal; width: 30%;">  Q. $MontoOrden</td>
                    </tr>
                    EOD;
                    $cont= $cont+1;
                    $contatemp = $contatemp+1;
                }else{
                    $fechaconmes=fecha_con_mes($fechatemp);
                    $TablaProducto .= <<<EOD
                    <tr style="border: 2px;">
                        <td align="center" colspan="2" style="font-size: 14px; width: 100%; color: #090a09; margin: 20px" ><strong> $fechaconmes  <u style="color: black;"> $contatemp </u> Ordenes En Total </strong></td>
                    </tr>
                    EOD;
                    $fechatemp = $FechaOrden;
                    $contatemp = 0;
                    $contorden = $contatemp +1;
                    $TablaProducto .= <<<EOD
                    <tr style="border: 2px;">
                        <td align="left"  style="font-size: 12px; font-weight: normal; width: 35%;"> #  $contorden </td>
                        <td type="time" align="left" style="font-size: 12px; font-weight: normal; width: 35%;"> $hora</td>
                        <td type="time" align="left" style="font-size: 12px; font-weight: normal; width: 30%;">  Q. $MontoOrden</td>
                    </tr>
                    EOD;
                    $cont= $cont+1;
                    $contatemp = $contatemp+1;
                    
                }

        }
    }
    $fechaconmes=fecha_con_mes($fechatemp);
    $TablaProducto .= <<<EOD
                <tr style="border: 2px;">
                    <td align="center" colspan="2" style="font-size: 14px; width: 100%; color: #090a09;"><strong>  $fechaconmes <u style="color: black;"> $contatemp </u> Ordenes En Total</strong></td>
                </tr>
                EOD;
}
if ($tipodereporte == 2){
    $TablaProducto = <<<EOD
        <table  border="0.1">
        <tr style="border: 1px;">
        <td align="center" style="font-size: 14px; width: 50%;">FECHA</td>
        <td align="center" style="font-size: 14px; width: 50%;">ORDENES POR DÍA</td>
        </tr>
    EOD;
    $QueryOrdenes = mysqli_query($db,"SELECT A.F_CODIGO, A.F_ORDEN, A.F_FECHA_TRANS, A.F_HORA
                                    FROM Bodega.FACTURA_KS AS A 
                                    WHERE A.F_ESTADO = 1 
                                    ORDER BY A.F_FECHA_TRANS ASC");
    while($FilaOrdenes = mysqli_fetch_array($QueryOrdenes))
    {
        
        

            if (($FilaOrdenes["F_FECHA_TRANS"] >= $fecha_inicio) and ($FilaOrdenes["F_FECHA_TRANS"] <= $fecha_fin)){

                $NoOrden = $FilaOrdenes["F_ORDEN"];
                $FechaOrden = $FilaOrdenes["F_FECHA_TRANS"];
                $HoraOrden = $FilaOrdenes["F_HORA"];
                
                if($fechatemp==$FechaOrden){

                    $cont= $cont+1;
                    $contatemp = $contatemp+1;
                }else{
                    
                    $fechaconmes=fecha_con_mes($fechatemp);
                    $TablaProducto .= <<<EOD
                    <tr style="border: 2px;">
                        <td align="left" style="font-size: 14px; font-weight: normal; width: 50%;"> $fechaconmes</td>
                        <td align="center" style="font-size: 14px; font-weight: normal; width: 50%;"> $contatemp</td>
                    </tr>
                    EOD;
                    
                    $contatemp = 0;
                    $cont= $cont+1;
                    $contatemp = $contatemp+1;
                    $fechatemp = $FechaOrden;
                }

        }
    }
    $fechaconmes=fecha_con_mes($fechatemp);
    $TablaProducto .= <<<EOD
                <tr style="border: 2px;">
                    <td align="left" style="font-size: 14px; font-weight: normal; width: 50%;"> $fechaconmes</td>
                    <td align="center" style="font-size: 14px; font-weight: normal; width: 50%;">  $contatemp </td>
                </tr>
                EOD;
}



$TablaProducto .= <<<EOD
<tr>
    <td align="right"   style="font-size: 16px width: 30%;">TOTAL OORDENES</td>
    <td align="right" style="font-size: 16px width: 70%;">$cont</td>
</tr>
</table>
EOD;

$fechaconmesinicio=fecha_con_mes($fecha_inicio);
$fechaconmesfin=fecha_con_mes($fecha_fin);
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
$pdf->SetFont('Helvetica', 'B', 18);
$pdf->Cell(0,0, "REPORTE DE ORDENES",0,1,'C');
if($fecha_inicio==$fecha_fin){
    $pdf->SetFont('Helvetica', 'B', 18);
    $pdf->Cell(0,0, "Del Día $fechaconmesinicio",0,1,'C');
}else{
    $pdf->SetFont('Helvetica', 'B', 18);
    $pdf->Cell(0,0, "Del $fechaconmesinicio al $fechaconmesfin",0,1,'C');
}
$pdf->SetFont('Helvetica', 'B', 14);
$pdf->Cell(0,0, "Restaurante El Mirador",0,1,'C');
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
				