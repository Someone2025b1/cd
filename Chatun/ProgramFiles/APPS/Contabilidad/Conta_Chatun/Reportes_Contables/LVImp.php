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

$Mes = $_GET["Mes"];
$Anho = $_GET["anho"];

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
$pdf->SetMargins(15,20,15);
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
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td align="center" style="background-color: #C9C9C9"><b>Fecha</b></td>
    <td align="center" style="background-color: #C9C9C9" width="10%"><b>Cliente</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>NIT</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Documento</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Serie</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Del</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Al</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Bienes</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Servicios</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Exportaciones</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>IVA</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Impuestos</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Exento</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Total</b></td>
    </tr>
EOD;

$QueryDetalle = mysqli_query($db, "SELECT A.TRA_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'FAC' AS TIPO, A.TRA_SERIE, 
                            (SELECT MIN(B.TRA_FACTURA) AS MINIMO
                            FROM Contabilidad.TRANSACCION AS B
                            WHERE (B.TT_CODIGO = A.TT_CODIGO)
                            AND B.TRA_FECHA_TRANS = A.TRA_FECHA_TRANS
                            AND B.E_CODIGO = 2
                            AND B.TRA_SERIE = A.TRA_SERIE) AS MINIMO, 
                            (SELECT MAX(C.TRA_FACTURA) MAXIMO
                            FROM Contabilidad.TRANSACCION AS C
                            WHERE (C.TT_CODIGO = A.TT_CODIGO)
                            AND C.TRA_FECHA_TRANS = A.TRA_FECHA_TRANS
                            AND C.E_CODIGO = 2
                            AND C.TRA_SERIE = A.TRA_SERIE) AS MAXIMO, 
                            (SELECT MAX(C.TRA_FACTURA_AL) MAXIMO
                            FROM Contabilidad.TRANSACCION AS C
                            WHERE (C.TT_CODIGO = A.TT_CODIGO)
                            AND C.TRA_FECHA_TRANS = A.TRA_FECHA_TRANS
                            AND C.E_CODIGO = 2
                            AND C.TRA_SERIE = A.TRA_SERIE) AS MAXIMO_2, 
                            ROUND(((SUM(A.TRA_TOTAL) / 1.12) * .12), 2) AS IVA,
                            (SUM(A.TRA_TOTAL) - ROUND(((SUM(A.TRA_TOTAL) / 1.12) * .12), 2)) AS NETO,
                            SUM(A.TRA_TOTAL) AS SALDO
                            FROM Contabilidad.TRANSACCION AS A
                             WHERE (TT_CODIGO = 3 OR TT_CODIGO = 4 OR TT_CODIGO = 5 OR TT_CODIGO = 6 OR TT_CODIGO = 7 OR TT_CODIGO = 8 OR TT_CODIGO = 9 OR TT_CODIGO = 15 OR TT_CODIGO = 22)
                            AND MONTH(A.TRA_FECHA_TRANS) = ".$Mes."
                            AND YEAR(A.TRA_FECHA_TRANS) = ".$Anho."
                            AND A.E_CODIGO = 2
                            AND (A.TRA_CONCEPTO <> 'FACTURA ANULADA' AND A.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND A.TRA_ESTADO = 1
                            GROUP BY A.TRA_FECHA_TRANS, A.TRA_SERIE
                            ORDER BY A.TRA_FECHA_TRANS ASC, A.TRA_SERIE ASC");
while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
{

    $Fecha = date('d-m-Y', strtotime($FilaDetalle["TRA_FECHA_TRANS"]));
    $Cliente = $FilaDetalle[CLIENTE];
    $NIT = $FilaDetalle[NIT];
    $Documento = $FilaDetalle[TIPO];
    $Serie = $FilaDetalle[TRA_SERIE];
    $Del = $FilaDetalle[MINIMO];
    if($FilaDetalle[MAXIMO_2] == '')
    {
        $Al = $FilaDetalle[MAXIMO];
    }
    else
    {
        $Al = $FilaDetalle[MAXIMO_2];
    }

    if($Del == '' && $Al == '')
    {
        $Del = ObtenerMinimosMaximosSerie('Del', $Serie, $FilaDetalle["TRA_FECHA_TRANS"]);
        $Al = ObtenerMinimosMaximosSerie('Al', $Serie, $FilaDetalle["TRA_FECHA_TRANS"]);
    }

    if($FilaDetalle[TRA_SERIE] == 'D' || $FilaDetalle[TRA_SERIE] == 'E' || $FilaDetalle[TRA_SERIE] == 'F' || $FilaDetalle[TRA_SERIE] == 'I' || $FilaDetalle[TRA_SERIE] == 'L')
    {
        $Bienes = $FilaDetalle[NETO];
        $Servicios = 0;

        $BienesMostrar = number_format($FilaDetalle[NETO], 2);
        $ServiciosMostrar = number_format(0, 2);
    }
    else
    {
        $Bienes = 0;
        $Servicios = $FilaDetalle[NETO];

        $BienesMostrar = number_format(0, 2);
        $ServiciosMostrar = number_format($FilaDetalle[NETO], 2);
    }

    $ExportacionesMostrar = number_format(0, 2);

    $Iva = $FilaDetalle[IVA];
    $Total = $FilaDetalle[SALDO];

    $IVAMostrar = number_format($FilaDetalle[IVA], 2);
    $TotalMostrar = number_format($FilaDetalle[SALDO], 2);
    $Cliente = $FilaDetalle[CLIENTE];

    $BienesTotal = $BienesTotal + $Bienes;
    $ServiciosTotal = $ServiciosTotal + $Servicios;
    $IvaTotal = $IvaTotal + $Iva;
    $TotalTotal = $TotalTotal + $Total;


$tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td>
    <td align="center">$Serie</td>
    <td align="center" style="font-size: 6px">$Del</td>
    <td align="center" style="font-size: 6px">$Al</td>
    <td align="right">$BienesMostrar</td>
    <td align="right">$ServiciosMostrar</td>
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
$TotalMostrarTotal = number_format($TotalTotal, 2);

$tbl1 .= <<<EOD
    <tr>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="right"><b>$BienesMostrarTotal</b></td>
    <td align="right"><b>$ServiciosMostrarTotal</b></td>
    <td align="right"><b>$ExportacionesMostrar</b></td>
    <td align="right"><b>$IVAMostrarTotal</b></td>
    <td align="right"><b>0.00</b></td>
    <td align="right"><b>0.00</b></td>
    <td align="right"><b>$TotalMostrarTotal</b></td>
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