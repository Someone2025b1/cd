<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../Script/funciones.php");


$TotalGeneralCargos = 0;
$TotalGeneralAbonos = 0;

$GLOBALS["Mes"] = $_POST["Mes"];
$GLOBALS["Anho"] = $_POST["anho"];

$Mes = $_POST["Mes"];
$Anho = $_POST["anho"];

//$GLOBALS["NombreMes"] = saber_mes($_POST["Mes"]);

$NumeroDias = cal_days_in_month(CAL_GREGORIAN, $Mes, $Anho);


$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));

$Fecha         = 0;
$Cliente       = 0;
$NIT           = 0;
$Documento     = 0;
$Serie         = 0;
$Del           = 0;
$Al            = 0;
$Bienes        = 0;
$Servicios     = 0;
$Exportaciones = 0;
$IVA           = 0;
$Impuestos     = 0;
$Exento        = 0;
$Total         = 0;

$BienesMostrar        = 0;
$ServiciosMostrar     = 0;
$ExportacionesMostrar = 0;
$IVAMostrar           = 0;
$ImpuestosMostrar     = 0;
$ExentoMostrar        = 0;
$TotalMostrar         = 0;


$TotalSumaServicios = 0;
$TotalSumaIVA = 0;
$TotalSumaTotal = 0;





$TotalCargos = 0;
$TotalAbonos = 0;

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
    <td align="center" style="background-color: #C9C9C9"><b>Cliente</b></td>
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

for($i=1; $i <= $NumeroDias; $i++)
{
    $NuevaFecha = $Anho."-".$Mes."-".$i;
    $NuevaFecha = date('Y-m-d', strtotime($NuevaFecha));

    $Consulta = "SELECT *
            FROM Contabilidad.TRANSACCION
            WHERE (TT_CODIGO = 3 OR TT_CODIGO = 4 OR TT_CODIGO = 5 OR TT_CODIGO = 6 OR TT_CODIGO = 7 OR TT_CODIGO = 8 OR TT_CODIGO = 9 OR TT_CODIGO = 15)
            AND E_CODIGO = 2
            AND TRA_FECHA_TRANS = '".$NuevaFecha."'
            GROUP BY TT_CODIGO";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
    if($row["TT_CODIGO"] == 3)
    {
    $Fecha         = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
    $Cliente       = 'Clientes Varios';
    $NIT           = 'CF';
    $Documento     = 'Fac';
    $ConsultaSerieA = "SELECT 'A' AS TRA_SERIE, MIN(TRA_FACTURA) AS TRA_FACTURA, MAX(TRA_FACTURA_AL) AS TRA_FACTURA_AL
            FROM Contabilidad.TRANSACCION
            WHERE (TT_CODIGO = 3)
            AND E_CODIGO = 2
            AND TRA_SERIE = 'A'
            AND TRA_FECHA_TRANS = '".$NuevaFecha."'";
    $ResultSerieA = mysqli_query($db, $ConsultaSerieA);
    $FilaSerieA = mysqli_fetch_array($ResultSerieA);

    $TotalSerieA = "SELECT SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS TRA_TOTAL
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.01.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS = '".$NuevaFecha."'
                    AND TRANSACCION.E_CODIGO = 2
                    AND TRANSACCION.TRA_SERIE = 'A'
                    AND TRANSACCION.TT_CODIGO = 3";
    $ResultTotalSerieA = mysqli_query($db, $TotalSerieA);
    $RegistrosA = mysqli_num_rows($ResultTotalSerieA);
    $FilaTotalSerieA = mysqli_fetch_array($ResultTotalSerieA);

    if($FilaSerieA[TRA_FACTURA] != '' && $FilaSerieA[TRA_FACTURA_AL] != '')
    {

    $Serie         = $FilaSerieA["TRA_SERIE"];
    $Del           = $FilaSerieA["TRA_FACTURA"];
    $Al            = $FilaSerieA["TRA_FACTURA_AL"];
    if($row["TC_CODIGO"] == 'B')
    {
        $Total         = $FilaTotalSerieA["TRA_TOTAL"];
        $Bienes        = $Total;
        $Servicios     = 0;
        $Exportaciones = 0;
        $IVA           = $Total*0.12;
        $Total         = $Bienes+$IVA;
    }
    elseif($row["TC_CODIGO"] == 'S')
    {
        $Total         = $FilaTotalSerieA["TRA_TOTAL"];
        $Bienes        = 0;
        $Servicios     = $Total;
        $Exportaciones = 0;
        $IVA           = $Total*0.12;
        $Total         = $Servicios+$IVA;
    }
    if($row["TC_CODIGO"] == 'E')
    {
        $Total         = $FilaTotalSerieA["TRA_TOTAL"];
        $Bienes        = 0;
        $Servicios     = 0;
        $Exportaciones = $Total;
        $IVA           = $Total*0.12;
        $Total         = $Exportaciones+$IVA;
    }

    
    $Impuestos     = 0;
    $Exento        = 0;
    $BienesMostrar        = number_format($Bienes, 2, '.', ',');
    $ServiciosMostrar     = number_format($Servicios, 2, '.', ',');
    $ExportacionesMostrar = number_format($Exportaciones, 2, '.', ',');
    $IVAMostrar           = number_format($IVA, 2, '.', ',');
    $ImpuestosMostrar     = number_format($Impuestos, 2, '.', ',');
    $ExentoMostrar        = number_format($Exento, 2, '.', ',');
    $TotalMostrar         = number_format($Total, 2, '.', ',');

    $tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td>
    <td align="center">$Serie</td>
    <td align="center">$Del</td>
    <td align="center">$Al</td>
    <td align="right">$BienesMostrar</td>
    <td align="right">$ServiciosMostrar</td>
    <td align="right">$ExportacionesMostrar</td>
    <td align="right">$IVAMostrar</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalMostrar</td>
    </tr>
EOD;

    $TotalSumaServicios = $TotalSumaServicios + $Servicios;
    $TotalSumaIVA = $TotalSumaIVA + $IVA;
    $TotalSumaTotal = $TotalSumaTotal + $Total;

}

    $ConsultaSerieBU = "SELECT 'BU' AS TRA_SERIE, MIN(TRA_FACTURA) AS TRA_FACTURA, MAX(TRA_FACTURA_AL) AS TRA_FACTURA_AL
            FROM Contabilidad.TRANSACCION
            WHERE (TT_CODIGO = 3)
            AND E_CODIGO = 2
            AND TRA_SERIE = 'BU'
            AND TRA_FECHA_TRANS = '".$NuevaFecha."'";
    $ResultSerieBU = mysqli_query($db, $ConsultaSerieBU);
    $RegistrosBU = mysqli_num_rows($ResultSerieBU);

    $FilaSerieBU = mysqli_fetch_array($ResultSerieBU);
    if($FilaSerieBU[TRA_FACTURA] != '' && $FilaSerieBU[TRA_FACTURA_AL] != '')
    {

    $TotalSerieBU = "SELECT SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS TRA_TOTAL
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.01.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS = '".$NuevaFecha."'
                    AND TRANSACCION.E_CODIGO = 2
                    AND TRANSACCION.TRA_SERIE = 'BU'
                    AND TRANSACCION.TT_CODIGO = 3";
    $ResultTotalSerieBU = mysqli_query($db, $TotalSerieBU);
    $FilaTotalSerieBU = mysqli_fetch_array($ResultTotalSerieBU);

    $Serie         = $FilaSerieBU["TRA_SERIE"];
    $Del           = $FilaSerieBU["TRA_FACTURA"];
    $Al            = $FilaSerieBU["TRA_FACTURA_AL"];
    if($row["TC_CODIGO"] == 'B')
    {
        $Total         = $FilaTotalSerieBU["TRA_TOTAL"];
        $Bienes        = $Total;
        $Servicios     = 0;
        $Exportaciones = 0;
        $IVA           = $Total*0.12;
        $Total         = $Bienes+$IVA;
    }
    elseif($row["TC_CODIGO"] == 'S')
    {
        $Total         = $FilaTotalSerieBU["TRA_TOTAL"];
        $Bienes        = 0;
        $Servicios     = $Total;
        $Exportaciones = 0;
        $IVA           = $Total*0.12;
        $Total         = $Servicios+$IVA;
    }
    if($row["TC_CODIGO"] == 'E')
    {
        $Total         = $FilaTotalSerieBU["TRA_TOTAL"];
        $Bienes        = 0;
        $Servicios     = 0;
        $Exportaciones = $Total;
        $IVA           = $Total*0.12;
        $Total         = $Exportaciones+$IVA;
    }

    
    $Impuestos     = 0;
    $Exento        = 0;
    $BienesMostrar        = number_format($Bienes, 2, '.', ',');
    $ServiciosMostrar     = number_format($Servicios, 2, '.', ',');
    $ExportacionesMostrar = number_format($Exportaciones, 2, '.', ',');
    $IVAMostrar           = number_format($IVA, 2, '.', ',');
    $ImpuestosMostrar     = number_format($Impuestos, 2, '.', ',');
    $ExentoMostrar        = number_format($Exento, 2, '.', ',');
    $TotalMostrar         = number_format($Total, 2, '.', ',');

    $tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td>
    <td align="center">$Serie</td>
    <td align="center">$Del</td>
    <td align="center">$Al</td>
    <td align="right">$BienesMostrar</td>
    <td align="right">$ServiciosMostrar</td>
    <td align="right">$ExportacionesMostrar</td>
    <td align="right">$IVAMostrar</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalMostrar</td>
    </tr>
EOD;

    $TotalSumaServicios = $TotalSumaServicios + $Servicios;
    $TotalSumaIVA = $TotalSumaIVA + $IVA;
    $TotalSumaTotal = $TotalSumaTotal + $Total;
    }

    }
    if($row["TT_CODIGO"] == 4)
    {
    $Fecha         = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
    $Cliente       = 'Clientes Varios';
    $NIT           = 'CF';
    $Documento     = 'Fac';

    $ConsultaSerieB = "SELECT 'B' AS TRA_SERIE, MIN(TRA_FACTURA) AS TRA_FACTURA, MAX(TRA_FACTURA_AL) AS TRA_FACTURA_AL
            FROM Contabilidad.TRANSACCION
            WHERE (TT_CODIGO = 4)
            AND E_CODIGO = 2
            AND TRA_SERIE = 'B'
            AND TRA_FECHA_TRANS = '".$NuevaFecha."'";
    $ResultSerieB = mysqli_query($db, $ConsultaSerieB);
    $FilaSerieB = mysqli_fetch_array($ResultSerieB);

    $Serie         = $FilaSerieB["TRA_SERIE"];
    $Del           = $FilaSerieB["TRA_FACTURA"];
    $Al            = $FilaSerieB["TRA_FACTURA_AL"];

    $TotalSerieB = "SELECT SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS TRA_TOTAL
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.01.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS = '".$NuevaFecha."'
                    AND TRANSACCION.E_CODIGO = 2
                    AND TRANSACCION.TRA_SERIE = 'B'
                    AND TRANSACCION.TT_CODIGO = 4";
    $ResultTotalSerieB = mysqli_query($db, $TotalSerieB);
    $FilaTotalSerieB = mysqli_fetch_array($ResultTotalSerieB);

    if($row["TC_CODIGO"] == 'B')
    {
        $Total         = $FilaTotalSerieB["TRA_TOTAL"];
        $Bienes        = $Total;
        $Servicios     = 0;
        $Exportaciones = 0;
        $IVA           = $Total*0.12;
        $Total         = $Bienes+$IVA;
    }
    elseif($row["TC_CODIGO"] == 'S')
    {
        $Total         = $FilaTotalSerieB["TRA_TOTAL"];
        $Bienes        = 0;
        $Servicios     = $Total;
        $Exportaciones = 0;
        $IVA           = $Total*0.12;
        $Total         = $Servicios+$IVA;
    }
    if($row["TC_CODIGO"] == 'E')
    {
        $Total         = $FilaTotalSerieB["TRA_TOTAL"];
        $Bienes        = 0;
        $Servicios     = 0;
        $Exportaciones = $Total;
        $IVA           = $Total*0.12;
        $Total         = $Exportaciones+$IVA;
    }

    $TotalVentas = $TotalVentas + $Servicios;
    
    $Impuestos     = 0;
    $Exento        = 0;
    $BienesMostrar        = number_format($Bienes, 2, '.', ',');
    $ServiciosMostrar     = number_format($Servicios, 2, '.', ',');
    $ExportacionesMostrar = number_format($Exportaciones, 2, '.', ',');
    $IVAMostrar           = number_format($IVA, 2, '.', ',');
    $ImpuestosMostrar     = number_format($Impuestos, 2, '.', ',');
    $ExentoMostrar        = number_format($Exento, 2, '.', ',');
    $TotalMostrar         = number_format($Total, 2, '.', ',');

    $tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td>
    <td align="center">$Serie</td>
    <td align="center">$Del</td>
    <td align="center">$Al</td>
    <td align="right">$BienesMostrar</td>
    <td align="right">$ServiciosMostrar</td>
    <td align="right">$ExportacionesMostrar</td>
    <td align="right">$IVAMostrar</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalMostrar</td>
    </tr>
EOD;

    $TotalSumaServicios = $TotalSumaServicios + $Servicios;
    $TotalSumaIVA = $TotalSumaIVA + $IVA;
    $TotalSumaTotal = $TotalSumaTotal + $Total;

    }
    if($row["TT_CODIGO"] == 5)
    {
    $Fecha         = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
    $Cliente       = 'Clientes Varios';
    $NIT           = 'CF';
    $Documento     = 'Fac';

    $ConsultaSerieB = "SELECT 'C' AS TRA_SERIE, MIN(TRA_FACTURA) AS TRA_FACTURA, MAX(TRA_FACTURA_AL) AS TRA_FACTURA_AL
            FROM Contabilidad.TRANSACCION
            WHERE (TT_CODIGO = 5)
            AND E_CODIGO = 2
            AND TRA_SERIE = 'C'
            AND TRA_FECHA_TRANS = '".$NuevaFecha."'";
    $ResultSerieB = mysqli_query($db, $ConsultaSerieB);
    $FilaSerieB = mysqli_fetch_array($ResultSerieB);

    $Serie         = $FilaSerieB["TRA_SERIE"];
    $Del           = $FilaSerieB["TRA_FACTURA"];
    $Al            = $FilaSerieB["TRA_FACTURA_AL"];

    $TotalSerieC = "SELECT SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS TRA_TOTAL
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.01.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS = '".$NuevaFecha."'
                    AND TRANSACCION.E_CODIGO = 2
                    AND TRANSACCION.TRA_SERIE = 'C'
                    AND TRANSACCION.TT_CODIGO = 5";
    $ResultTotalSerieC = mysqli_query($db, $TotalSerieC);
    $FilaTotalSerieC = mysqli_fetch_array($ResultTotalSerieC);

    if($row["TC_CODIGO"] == 'B')
    {
        $Total         = $FilaTotalSerieC["TRA_TOTAL"];
        $Bienes        = $Total;
        $Servicios     = 0;
        $Exportaciones = 0;
        $IVA           = $Total*0.12;
        $Total         = $Bienes+$IVA;
    }
    elseif($row["TC_CODIGO"] == 'S')
    {
        $Total         = $FilaTotalSerieC["TRA_TOTAL"];
        $Bienes        = 0;
        $Servicios     = $Total;
        $Exportaciones = 0;
        $IVA           = $Total*0.12;
        $Total         = $Servicios+$IVA;
    }
    if($row["TC_CODIGO"] == 'E')
    {
        $Total         = $FilaTotalSerieC["TRA_TOTAL"];
        $Bienes        = 0;
        $Servicios     = 0;
        $Exportaciones = $Total;
        $IVA           = $Total*0.12;
        $Total         = $Exportaciones+$IVA;
    }

    $TotalVentas = $TotalVentas + $Servicios;
    
    $Impuestos     = 0;
    $Exento        = 0;
    $BienesMostrar        = number_format($Bienes, 2, '.', ',');
    $ServiciosMostrar     = number_format($Servicios, 2, '.', ',');
    $ExportacionesMostrar = number_format($Exportaciones, 2, '.', ',');
    $IVAMostrar           = number_format($IVA, 2, '.', ',');
    $ImpuestosMostrar     = number_format($Impuestos, 2, '.', ',');
    $ExentoMostrar        = number_format($Exento, 2, '.', ',');
    $TotalMostrar         = number_format($Total, 2, '.', ',');

    $tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td>
    <td align="center">$Serie</td>
    <td align="center">$Del</td>
    <td align="center">$Al</td>
    <td align="right">$BienesMostrar</td>
    <td align="right">$ServiciosMostrar</td>
    <td align="right">$ExportacionesMostrar</td>
    <td align="right">$IVAMostrar</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalMostrar</td>
    </tr>
EOD;
    
    $TotalSumaServicios = $TotalSumaServicios + $Servicios;
    $TotalSumaIVA = $TotalSumaIVA + $IVA;
    $TotalSumaTotal = $TotalSumaTotal + $Total;

    }
    elseif($row["TT_CODIGO"] == 7)
    {
        $ConsultaMaxMin = "SELECT MIN( F_NUMERO ) AS MINIMO, MAX( F_NUMERO ) AS MAXIMO, SUM( F_TOTAL ) AS TOTAL, F_SERIE 
FROM Bodega.FACTURA
WHERE F_FECHA_TRANS =  '".$NuevaFecha."'";
        $QueryConsultaMaxMin = mysqli_query($db, $ConsultaMaxMin);
        $FilaMaxMin = mysqli_fetch_array($QueryConsultaMaxMin);

        $Fecha         = date('d-m-Y', strtotime($NuevaFecha));
        $Cliente       = 'Clientes Varios';
        $NIT           = 'CF';
        $Documento     = 'Fac';
        $Serie         = $row["TRA_SERIE"];
        $Del           = $FilaMaxMin["MINIMO"];
        $Al            = $FilaMaxMin["MAXIMO"];
        $Total         = $FilaMaxMin["TOTAL"];
        $Bienes        = 0;
        $Servicios     = $Total / 1.12;
        $Exportaciones = 0;
        $IVA           = $Servicios*0.12;
        $Total         = $Servicios+$IVA;
        $Impuestos     = 0;
    $Exento        = 0;
    $BienesMostrar        = number_format($Bienes, 2, '.', ',');
    $ServiciosMostrar     = number_format($Servicios, 2, '.', ',');
    $ExportacionesMostrar = number_format($Exportaciones, 2, '.', ',');
    $IVAMostrar           = number_format($IVA, 2, '.', ',');
    $ImpuestosMostrar     = number_format($Impuestos, 2, '.', ',');
    $ExentoMostrar        = number_format($Exento, 2, '.', ',');
    $TotalMostrar         = number_format($Total, 2, '.', ',');

    $TotalVentas = $TotalVentas + $Servicios;

        $tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td>
    <td align="center">$Serie</td>
    <td align="center">$Del</td>
    <td align="center">$Al</td>
    <td align="right">$BienesMostrar</td>
    <td align="right">$ServiciosMostrar</td>
    <td align="right">$ExportacionesMostrar</td>
    <td align="right">$IVAMostrar</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalMostrar</td>
    </tr>
EOD;

    $TotalSumaServicios = $TotalSumaServicios + $Servicios;
    $TotalSumaIVA = $TotalSumaIVA + $IVA;
    $TotalSumaTotal = $TotalSumaTotal + $Total;

    }
    elseif($row["TT_CODIGO"] == 8)
    {
        $ConsultaMaxMin = "SELECT MIN( F_NUMERO ) AS MINIMO, MAX( F_NUMERO ) AS MAXIMO, SUM( F_TOTAL ) AS TOTAL, F_SERIE 
FROM Bodega.FACTURA_SV
WHERE F_FECHA_TRANS =  '".$NuevaFecha."'";
        $QueryConsultaMaxMin = mysqli_query($db, $ConsultaMaxMin);
        $FilaMaxMin = mysqli_fetch_array($QueryConsultaMaxMin);

        $Fecha         = date('d-m-Y', strtotime($NuevaFecha));
        $Cliente       = 'Clientes Varios';
        $NIT           = 'CF';
        $Documento     = 'Fac';
        $Serie         = $row["TRA_SERIE"];
        $Del           = $FilaMaxMin["MINIMO"];
        $Al            = $FilaMaxMin["MAXIMO"];
        $Total         = $FilaMaxMin["TOTAL"];
        $Bienes        = 0;
        $Servicios     = $Total / 1.12;
        $Exportaciones = 0;
        $IVA           = $Servicios*0.12;
        $Total         = $Servicios+$IVA;
        $Impuestos     = 0;
    $Exento        = 0;
    $BienesMostrar        = number_format($Bienes, 2, '.', ',');
    $ServiciosMostrar     = number_format($Servicios, 2, '.', ',');
    $ExportacionesMostrar = number_format($Exportaciones, 2, '.', ',');
    $IVAMostrar           = number_format($IVA, 2, '.', ',');
    $ImpuestosMostrar     = number_format($Impuestos, 2, '.', ',');
    $ExentoMostrar        = number_format($Exento, 2, '.', ',');
    $TotalMostrar         = number_format($Total, 2, '.', ',');

    $TotalVentas = $TotalVentas + $Servicios;

        $tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td>
    <td align="center">$Serie</td>
    <td align="center">$Del</td>
    <td align="center">$Al</td>
    <td align="right">$BienesMostrar</td>
    <td align="right">$ServiciosMostrar</td>
    <td align="right">$ExportacionesMostrar</td>
    <td align="right">$IVAMostrar</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalMostrar</td>
    </tr>
EOD;

    $TotalSumaServicios = $TotalSumaServicios + $Servicios;
    $TotalSumaIVA = $TotalSumaIVA + $IVA;
    $TotalSumaTotal = $TotalSumaTotal + $Total;

    }
    elseif($row["TT_CODIGO"] == 9)
    {
        $ConsultaMaxMin = "SELECT MIN( F_NUMERO ) AS MINIMO, MAX( F_NUMERO ) AS MAXIMO, SUM( F_TOTAL ) AS TOTAL, F_SERIE 
FROM Bodega.FACTURA_TQ
WHERE F_FECHA_TRANS =  '".$NuevaFecha."'";
        $QueryConsultaMaxMin = mysqli_query($db, $ConsultaMaxMin);
        $FilaMaxMin = mysqli_fetch_array($QueryConsultaMaxMin);

        $Fecha         = date('d-m-Y', strtotime($NuevaFecha));
        $Cliente       = 'Clientes Varios';
        $NIT           = 'CF';
        $Documento     = 'Fac';
        $Serie         = $row["TRA_SERIE"];
        $Del           = $FilaMaxMin["MINIMO"];
        $Al            = $FilaMaxMin["MAXIMO"];
        $Total         = $FilaMaxMin["TOTAL"];
        $Bienes        = 0;
        $Servicios     = $Total / 1.12;
        $Exportaciones = 0;
        $IVA           = $Servicios*0.12;
        $Total         = $Servicios+$IVA;
        $Impuestos     = 0;
    $Exento        = 0;
    $BienesMostrar        = number_format($Bienes, 2, '.', ',');
    $ServiciosMostrar     = number_format($Servicios, 2, '.', ',');
    $ExportacionesMostrar = number_format($Exportaciones, 2, '.', ',');
    $IVAMostrar           = number_format($IVA, 2, '.', ',');
    $ImpuestosMostrar     = number_format($Impuestos, 2, '.', ',');
    $ExentoMostrar        = number_format($Exento, 2, '.', ',');
    $TotalMostrar         = number_format($Total, 2, '.', ',');

    $TotalVentas = $TotalVentas + $Servicios;

        $tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td>
    <td align="center">$Serie</td>
    <td align="center">$Del</td>
    <td align="center">$Al</td>
    <td align="right">$BienesMostrar</td>
    <td align="right">$ServiciosMostrar</td>
    <td align="right">$ExportacionesMostrar</td>
    <td align="right">$IVAMostrar</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalMostrar</td>
    </tr>
EOD;

    $TotalSumaServicios = $TotalSumaServicios + $Servicios;
    $TotalSumaIVA = $TotalSumaIVA + $IVA;
    $TotalSumaTotal = $TotalSumaTotal + $Total;

    }
    elseif($row["TT_CODIGO"] == 6)
    {
        $ConsultaMaxMin = "SELECT MIN( F_NUMERO ) AS MINIMO, MAX( F_NUMERO ) AS MAXIMO, SUM( F_TOTAL ) AS TOTAL, F_SERIE 
FROM Bodega.FACTURA_HS
WHERE F_FECHA_TRANS =  '".$NuevaFecha."'";
        $QueryConsultaMaxMin = mysqli_query($db, $ConsultaMaxMin);
        $FilaMaxMin = mysqli_fetch_array($QueryConsultaMaxMin);

        $Fecha         = date('d-m-Y', strtotime($NuevaFecha));
        $Cliente       = 'Clientes Varios';
        $NIT           = 'CF';
        $Documento     = 'Fac';
        $Serie         = $row["TRA_SERIE"];
        $Del           = $FilaMaxMin["MINIMO"];
        $Al            = $FilaMaxMin["MAXIMO"];
        $Total         = $FilaMaxMin["TOTAL"];
        $Bienes        = 0;
        $Servicios     = $Total / 1.12;
        $Exportaciones = 0;
        $IVA           = $Servicios*0.12;
        $Total         = $Servicios+$IVA;
        $Impuestos     = 0;
    $Exento        = 0;
    $BienesMostrar        = number_format($Bienes, 2, '.', ',');
    $ServiciosMostrar     = number_format($Servicios, 2, '.', ',');
    $ExportacionesMostrar = number_format($Exportaciones, 2, '.', ',');
    $IVAMostrar           = number_format($IVA, 2, '.', ',');
    $ImpuestosMostrar     = number_format($Impuestos, 2, '.', ',');
    $ExentoMostrar        = number_format($Exento, 2, '.', ',');
    $TotalMostrar         = number_format($Total, 2, '.', ',');

    $TotalVentas = $TotalVentas + $Servicios;

        $tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td>
    <td align="center">$Serie</td>
    <td align="center">$Del</td>
    <td align="center">$Al</td>
    <td align="right">$BienesMostrar</td>
    <td align="right">$ServiciosMostrar</td>
    <td align="right">$ExportacionesMostrar</td>
    <td align="right">$IVAMostrar</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalMostrar</td>
    </tr>
EOD;

    $TotalSumaServicios = $TotalSumaServicios + $Servicios;
    $TotalSumaIVA = $TotalSumaIVA + $IVA;
    $TotalSumaTotal = $TotalSumaTotal + $Total;

    }
    elseif($row["TT_CODIGO"] == 15)
    {
        $ConsultaMaxMin = "SELECT MIN( F_NUMERO ) AS MINIMO, MAX( F_NUMERO ) AS MAXIMO, SUM( F_TOTAL ) AS TOTAL, F_SERIE 
FROM Bodega.FACTURA_KS
WHERE F_FECHA_TRANS =  '".$NuevaFecha."'";
        $QueryConsultaMaxMin = mysqli_query($db, $ConsultaMaxMin);
        $FilaMaxMin = mysqli_fetch_array($QueryConsultaMaxMin);

        $Fecha         = date('d-m-Y', strtotime($NuevaFecha));
        $Cliente       = 'Clientes Varios';
        $NIT           = 'CF';
        $Documento     = 'Fac';
        $Serie         = $row["TRA_SERIE"];
        $Del           = $FilaMaxMin["MINIMO"];
        $Al            = $FilaMaxMin["MAXIMO"];
        $Total         = $FilaMaxMin["TOTAL"];
        $Bienes        = 0;
        $Servicios     = $Total / 1.12;
        $Exportaciones = 0;
        $IVA           = $Servicios*0.12;
        $Total         = $Servicios+$IVA;
        $Impuestos     = 0;
    $Exento        = 0;
    $BienesMostrar        = number_format($Bienes, 2, '.', ',');
    $ServiciosMostrar     = number_format($Servicios, 2, '.', ',');
    $ExportacionesMostrar = number_format($Exportaciones, 2, '.', ',');
    $IVAMostrar           = number_format($IVA, 2, '.', ',');
    $ImpuestosMostrar     = number_format($Impuestos, 2, '.', ',');
    $ExentoMostrar        = number_format($Exento, 2, '.', ',');
    $TotalMostrar         = number_format($Total, 2, '.', ',');

    $TotalVentas = $TotalVentas + $Servicios;

        $tbl1 .= <<<EOD
    <tr>
    <td align="center">$Fecha</td>
    <td align="center">$Cliente</td>
    <td align="center">$NIT</td>
    <td align="center">$Documento</td>
    <td align="center">$Serie</td>
    <td align="center">$Del</td>
    <td align="center">$Al</td>
    <td align="right">$BienesMostrar</td>
    <td align="right">$ServiciosMostrar</td>
    <td align="right">$ExportacionesMostrar</td>
    <td align="right">$IVAMostrar</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalMostrar</td>
    </tr>
EOD;

    $TotalSumaServicios = $TotalSumaServicios + $Servicios;
    $TotalSumaIVA = $TotalSumaIVA + $IVA;
    $TotalSumaTotal = $TotalSumaTotal + $Total;

    }
    

}
}

$TotalSumaServiciosFormato = number_format($TotalSumaServicios, 2, '.', ',');
$TotalSumaIVAFormato = number_format($TotalSumaIVA, 2, '.', ',');
$TotalSumaTotalFormato = number_format($TotalSumaTotal, 2, '.', ',');

$tbl1 .= <<<EOD
    <tr>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center">TOTALES</td>
    <td align="right">0.00</td>
    <td align="right">$TotalSumaServiciosFormato</td>
    <td align="right">0.00</td>
    <td align="right">$TotalSumaIVAFormato</td>
    <td align="right">0.00</td>
    <td align="right">0.00</td>
    <td align="right">$TotalSumaTotalFormato</td>
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