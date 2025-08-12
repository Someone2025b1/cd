<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../Script/funciones.php");


$TotalGeneralCargos = 0;
$TotalGeneralAbonos = 0;

$GLOBALS["Mes"] = $_GET["Mes"];
$GLOBALS["Anho"] = $_GET["anho"];

$MesC = $_GET["Mes"];
$Anho = $_GET["anho"];
$Lista = mysqli_fetch_array(mysqli_query($db, "SELECT mes FROM info_base.lista_meses where id = $MesC"));
$FechaT = $Lista["mes"].", ".$Anho;
//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("L","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,0,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', '', 7);

$tbl1 = <<<EOD
<h2 align="center">$FechaT</h2>
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
    <td align="center" style="background-color: #C9C9C9"><b>Fecha</b></td>
    <td align="center" style="background-color: #C9C9C9" width="10%"><b>Cliente</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>NIT</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Documento</b></td> 
    <td align="right" style="background-color: #C9C9C9"><b>Bienes</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Servicios</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Exportaciones</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>IVA</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Impuestos</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Exento</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Total</b></td>
    </tr>
EOD;

$QueryDetalle = mysqli_query($db, "SELECT F_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'FAC' AS TIPO, SUM(BIENES) AS BIENES, SUM(SERVICIOS) AS SERVICIOS, SUM(NETO) AS NETO, SUM(SALDO) AS SALDO FROM (SELECT a.F_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'FAC' AS TIPO, 
                                            (SELECT SUM(a.F_TOTAL)/1.12 AS BIENES
                                            FROM Contabilidad.TRANSACCION AS B
                                            WHERE B.TRA_FECHA_TRANS = a.F_FECHA_TRANS
                                            AND B.E_CODIGO = 2
                                            AND B.TRA_CODIGO = a.F_CODIGO  AND (B.TRA_CONCEPTO <> 'FACTURA ANULADA' AND B.TRA_CONCEPTO <> 'PÓLIZA ANULADA' AND B.TRA_ESTADO = 1)) AS BIENES,
                                            0 AS SERVICIOS, 
                                            (SUM(a.F_TOTAL) - ROUND(((SUM(a.F_TOTAL) / 1.12) * .12), 2)) AS NETO,
                                            (SELECT SUM(a.F_TOTAL) AS SALDO
                                            FROM Contabilidad.TRANSACCION AS C
                                            WHERE C.TRA_FECHA_TRANS = a.F_FECHA_TRANS
                                            AND C.E_CODIGO = 2 
                                            AND C.TRA_CODIGO = a.F_CODIGO
                                            AND (C.TRA_CONCEPTO <> 'FACTURA ANULADA' AND C.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND C.TRA_ESTADO = 1) AS SALDO                                     
                                            FROM Bodega.FACTURA_21K a
                                            INNER JOIN Contabilidad.TRANSACCION t ON a.F_CODIGO = t.TRA_CODIGO 
                                            WHERE MONTH(a.F_FECHA_TRANS) = $MesC AND YEAR(a.F_FECHA_TRANS) = $Anho AND t.TRA_ESTADO = 1
                                            GROUP BY a.F_FECHA_TRANS 
                                            UNION ALL
                                            SELECT a.F_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'FAC' AS TIPO, 
                                            (SELECT SUM(a.F_TOTAL)/1.12 AS BIENES
                                            FROM Contabilidad.TRANSACCION AS B
                                            WHERE B.TRA_FECHA_TRANS = a.F_FECHA_TRANS
                                            AND B.E_CODIGO = 2
                                            AND B.TRA_CODIGO = a.F_CODIGO  AND (B.TRA_CONCEPTO <> 'FACTURA ANULADA' AND B.TRA_CONCEPTO <> 'PÓLIZA ANULADA' AND B.TRA_ESTADO = 1)) AS BIENES,
                                            0 AS SERVICIOS, 
                                            (SUM(a.F_TOTAL) - ROUND(((SUM(a.F_TOTAL) / 1.12) * .12), 2)) AS NETO,
                                            (SELECT SUM(a.F_TOTAL) AS SALDO
                                            FROM Contabilidad.TRANSACCION AS C
                                            WHERE C.TRA_FECHA_TRANS = a.F_FECHA_TRANS
                                            AND C.E_CODIGO = 2 
                                            AND C.TRA_CODIGO = a.F_CODIGO
                                            AND (C.TRA_CONCEPTO <> 'FACTURA ANULADA' AND C.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND C.TRA_ESTADO = 1) AS SALDO                                     
                                            FROM Bodega.FACTURA_TQ a
                                            INNER JOIN Bodega.FACTURA_TQ_DETALLE b ON a.F_CODIGO = b.F_CODIGO 
                                            INNER JOIN Contabilidad.TRANSACCION t ON a.F_CODIGO = t.TRA_CODIGO 
                                            WHERE MONTH(a.F_FECHA_TRANS) = $MesC AND YEAR(a.F_FECHA_TRANS) = $Anho AND t.TRA_ESTADO = 1 AND b.FD_UNIDADES > 0
                                            GROUP BY a.F_FECHA_TRANS
                                            )dum
                                            GROUP BY  F_FECHA_TRANS
                                            ORDER BY F_FECHA_TRANS ");
while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
{

    $Fecha = date('d-m-Y', strtotime($FilaDetalle["F_FECHA_TRANS"]));
    $Cliente = $FilaDetalle['CLIENTE'];
    $NIT = $FilaDetalle['NIT'];
    $Documento = $FilaDetalle['TIPO'];
    $Serie = $FilaDetalle['TRA_SERIE'];
    $Del = $FilaDetalle['MINIMO'];
    
    $Bienes = number_format($FilaDetalle["BIENES"],2);
    $Servicios = number_format($FilaDetalle["SERVICIOS"],2);

    $ExportacionesMostrar = number_format(0, 2);

    $Iva = ($FilaDetalle['SALDO']/1.12)*0.12;
    $Total = $FilaDetalle['SALDO'];

    $IVAMostrar = number_format(($FilaDetalle['SALDO']/1.12)*0.12, 2);
    $TotalMostrar = number_format($FilaDetalle['SALDO'], 2);
    $Cliente = $FilaDetalle['CLIENTE'];

    $BienesTotal += $FilaDetalle["BIENES"];
    $ServiciosTotal += $FilaDetalle["SERVICIOS"];
    $IvaTotal = $IvaTotal + $Iva;
    $TotalLibro += $Total;


$tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td> 
    <td align="right">$Servicios</td>
    <td align="right">$Bienes</td>
    <td align="right">$ExportacionesMostrar</td>
    <td align="right">$IVAMostrar</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalMostrar</td>
    </tr>
EOD;

}


$BienesMostrarTotal = number_format($BienesTotal, 2);
$ServiciosMostrarTotal = number_format($ServiciosTotal, 2);
$ExportacionesMostrar = number_format(0, 2);
$IVAMostrarTotal = number_format($IvaTotal, 2);
$TotalMostrarLibro = number_format($TotalLibro, 2);
$TotalLibroM = number_format(($BienesTotal+$ServiciosTotal),2);

 
$BienesD = number_format($BienesTotal*0.12, 2);
$ServiciosD = number_format($ServiciosTotal*0.12, 2);
$ExpoD = $ExportacionesMostrar*0.12;
$IvaD = number_format($IvaTotal*0.12, 2);
$TotalLibroD = number_format((($BienesTotal*0.12)+($ServiciosTotal*0.12)), 2);

$SumaBienes = number_format($BienesTotal + ($BienesTotal*0.12),2);
$SumaServicios = number_format($ServiciosTotal + ($ServiciosTotal*0.12),2);
$SumaIva = number_format($IvaTotal + ($IvaTotal*0.12),2);
$I = $IvaTotal;
$SumaTotal = number_format(($BienesTotal + ($BienesTotal*0.12)+($ServiciosTotal + ($ServiciosTotal*0.12))),2);

$TotalDoc = mysqli_fetch_array(mysqli_query($db, "SELECT sum(Contador) AS CONTADOR
FROM(SELECT COUNT(*) AS Contador, F_FECHA_TRANS
FROM Bodega.FACTURA_21K B
WHERE MONTH(B.F_FECHA_TRANS) = $MesC AND YEAR(B.F_FECHA_TRANS) = $Anho
UNION ALL 
SELECT COUNT(*) AS Contador, F_FECHA_TRANS
FROM Bodega.FACTURA_TQ a
INNER JOIN Bodega.FACTURA_TQ_DETALLE b ON a.F_CODIGO = b.F_CODIGO                                       
WHERE MONTH(a.F_FECHA_TRANS) = $MesC AND YEAR(a.F_FECHA_TRANS) = $Anho  AND b.FD_UNIDADES > 0
) dum
 
 "));
$Docs = number_format($TotalDoc["CONTADOR"]);
$tbl1 .= <<<EOD
    <tr>
    <td align="center"></td>  
    <td align="center"></td> 
    <td align="center"></td>
    <td align="center"></td>
    <td align="right"><b>$ServiciosMostrarTotal</b></td>
    <td align="right"><b>$BienesMostrarTotal</b></td>
    <td align="right"><b>$ExportacionesMostrar</b></td>
    <td align="right"><b>$IVAMostrarTotal</b></td> 
    <td align="right"><b>0.00</b></td>
    <td align="right"><b>0.00</b></td>
    <td align="right"><b>$TotalMostrarLibro</b></td> 
    </tr>
EOD;


$tbl1 .= <<<EOD
</table>
EOD;
$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
$pdf->ln(10);
$tbl2 = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
  <tr>
      <td width="50%"> </td>
      <td width="87%">  
        <table cellspacing="0" cellpadding="1" border="1">
            <thead>
                <tr>
                     <td align="center" style="background-color: #C9C9C9" width="60%"><b>Resumen de $Docs documentos</b></td>
                </tr>
                <tr>
                    <td align="center" style="background-color: #C9C9C9" width="10%"><b>Descripción</b></td>
                    <td align="center" style="background-color: #C9C9C9" width="10%"><b>Bienes</b></td>
                    <td align="center" style="background-color: #C9C9C9" width="10%"><b>Servicios</b></td>
                    <td align="center" style="background-color: #C9C9C9" width="10%"><b>Exportaciones</b></td>  
                    <td align="center" style="background-color: #C9C9C9" width="10%"><b>Exento</b></td>
                    <td align="center" style="background-color: #C9C9C9" width="10%"><b>Total</b></td> 
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="left" width="10%">Sub-total</td>
                    <td align="right" width="10%">Q. $ServiciosMostrarTotal</td>
                    <td align="right" width="10%">Q. $BienesMostrarTotal</td>
                    <td align="right" width="10%">Q. 0.00</td> 
                    <td align="right" width="10%">Q. 0.00</td>
                    <td align="right" width="10%">Q. $TotalLibroM</td> 
                </tr>
                <tr>
                    <td align="left" width="10%">Débito-fiscal</td>
                    <td align="right" width="10%">Q. $ServiciosD</td>
                    <td align="right" width="10%">Q. $BienesD</td>
                    <td align="right" width="10%">Q. 0.00</td> 
                    <td align="right" width="10%">Q. 0.00</td>
                    <td align="right" width="10%">Q. $TotalLibroD</td> 
                </tr>
                <tr>
                    <td align="left" width="10%"><b>Gran Total</b></td>
                    <td align="right" width="10%">Q. $SumaServicios</td>
                    <td align="right" width="10%">Q. $SumaBienes</td>
                    <td align="right" width="10%">Q. 0.00</td> 
                    <td align="right" width="10%">Q. 0.00</td>
                    <td align="right" width="10%">Q. $SumaTotal</td> 
                </tr>
            </tbody>
EOD;

$tbl2 .= <<<EOD
</table>
</td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl2,0,0,0,0,'J'); 

ob_clean();
$pdf->Output();
ob_flush();
?>