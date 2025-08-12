<?php
set_time_limit(300);
ob_start();
session_start();
setlocale(LC_ALL,"es_ES");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));

$FechaIni = $_GET["FechaInicio"];
$FechaFin = $_GET["FechaFin"];

$TotalAcompanantesTotal = 0;


$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Ingreso Diario",16,array('justification'=>'center'));
$pdf->ezText("Del ".date('d-m-Y', strtotime($FechaIni))." Al ".date('d-m-Y', strtotime($FechaFin)),14,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);
$pdf->ezText("INGRESO DE ASOCIADOS",16,array('justification'=>'center'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>utf8_decode('#'), 'col2'=>utf8_decode('CIF'), 'col3'=>utf8_decode('NOMBRE'), 'col4'=>utf8_decode('FECHA INGRESO'), 'col5'=>utf8_decode('HORA INGRESO'), 'col6'=>utf8_decode('ACOMPAÑANTES'));
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/

$Contador = 1;

//QUERY PARA TRAER TODO EL MOVIMIENTO DE LAS CUENTAS EN EL RANGO DE FECHAS SELECCIONADO
$QueryAsociados = "SELECT A.IAT_CIF_ASOCIADO, A.IA_FECHA_INGRESO, A.IA_HORA_INGRESO, A.IA_REFERENCIA
                    FROM Taquilla.INGRESO_ASOCIADO AS A
                    WHERE A.IA_FECHA_INGRESO BETWEEN '".$FechaIni."' AND '".$FechaFin."'
                    GROUP BY A.IAT_CIF_ASOCIADO
                    ORDER BY A.IA_FECHA_INGRESO ASC, A.IA_HORA_INGRESO ASC";
$ResultAsociados = mysqli_query($db, $QueryAsociados);
while($row = mysqli_fetch_array($ResultAsociados))
{
    $ReferenciaAsociado = $row["IA_REFERENCIA"];
    $CIFAasociado = $row["IAT_CIF_ASOCIADO"];

    $QueryAcompanates = mysqli_query($db, "SELECT COUNT(A.IAT_CODIGO) AS TOTAL_ACOMPANANTES
                                        FROM Taquilla.INGRESO_ACOMPANIANTE AS A
                                        INNER JOIN Taquilla.INGRESO_ASOCIADO AS B ON A.IA_REFERENCIA = B.IA_REFERENCIA
                                        WHERE B.IAT_CIF_ASOCIADO =  '".$CIFAasociado."'
                                        AND B.IA_FECHA_INGRESO BETWEEN '".$FechaIni."' AND '".$FechaFin."'");
    $fila = mysqli_fetch_array($QueryAcompanates);
    $TotalAcompanantes = $fila["TOTAL_ACOMPANANTES"];

    $Data[] = array('col1'=>$Contador, 'col2'=>$row["IAT_CIF_ASOCIADO"], 'col3'=>saber_nombre_asociado_orden($row["IAT_CIF_ASOCIADO"]), 'col4'=>date('d-m-Y', strtotime($row["IA_FECHA_INGRESO"])), 'col5'=>$row["IA_HORA_INGRESO"], 'col6'=>$TotalAcompanantes);    
    $TotalAcompanantesTotal += $TotalAcompanantes;
    $Contador++;
}

$Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'<b>TOTAL</b>', 'col6'=>$TotalAcompanantesTotal);

$pdf->ezTable($Data, $Titulo,'', $Opciones);


unset($Data);
unset($Titulo);

$Titulo = array('col1'=>utf8_decode('FECHA'), 'col2'=>utf8_decode('ADULTOS'), 'col3'=>utf8_decode('NIÑOS'), 'col4'=>utf8_decode('NIÑOS MENORES A 5 AÑOS'), 'col5'=>utf8_decode('TOTAL INGRESO DEL DIA'));

$pdf->ezText("", 12);
$pdf->ezText("RESUMEN ASOCIADOS",12,array('justification'=>'center'));
$pdf->ezText("", 14);

$QueryFechaAsociado = mysqli_query($db, "SELECT A.IA_FECHA_INGRESO
                                    FROM Taquilla.INGRESO_ASOCIADO AS A
                                    WHERE A.IA_FECHA_INGRESO BETWEEN '".$FechaIni."' AND '".$FechaFin."'
                                    GROUP BY A.IA_FECHA_INGRESO
                                    ORDER BY A.IA_FECHA_INGRESO ASC");
while($FilaFechaAsociado = mysqli_fetch_array($QueryFechaAsociado))
{
    $IngresoMenor4 = 0;
    $IngresoNinio = 0;
    $IngresoAdulto = 0;

    $FechaAsociado = $FilaFechaAsociado["IA_FECHA_INGRESO"];

    $QueryResumenAsociado = mysqli_query($db, "SELECT A.IAT_CIF_ASOCIADO
                                        FROM Taquilla.INGRESO_ASOCIADO AS A
                                        WHERE A.IA_FECHA_INGRESO = '".$FechaAsociado."'
                                        GROUP BY A.IAT_CIF_ASOCIADO");
    while($FilaResumenAsociado = mysqli_fetch_array($QueryResumenAsociado))
    {
        $CIFAsociado = $FilaResumenAsociado["IAT_CIF_ASOCIADO"];
        $EdadAsociado = Saber_Edad_Asociado($CIFAsociado);

        if($EdadAsociado <= 4)
        {
            $IngresoMenor4++; 
        }
        elseif($EdadAsociado > 4 && $EdadAsociado <= 18)
        {
            $IngresoNinio++;
        }
        else
        {
            $IngresoAdulto++;
        }
    }

    $TotalIngresoAsociadosDia = $IngresoAdulto + $IngresoNinio + $IngresoMenor4;

    $TotalAdultosAsociado += $IngresoAdulto;
    $TotalNinioAsociado += $IngresoNinio;
    $IngresoMenor4Asociado += $IngresoMenor4;

    $Data[] = array('col1'=>date('d-m-Y', strtotime($FechaAsociado)), 'col2'=>$IngresoAdulto, 'col3'=>$IngresoNinio, 'col4'=>$IngresoMenor4, 'col5'=>$TotalIngresoAsociadosDia);
}

$TotalIngresoAsociados = $TotalAdultosAsociado + $TotalNinioAsociado + $IngresoMenor4Asociado;

$Data[] = array('col1'=>'TOTAL', 'col2'=>$TotalAdultosAsociado, 'col3'=>$TotalNinioAsociado, 'col4'=>$IngresoMenor4Asociado, 'col5'=>$TotalIngresoAsociados);

$pdf->ezTable($Data, $Titulo,'', $Opciones);

unset($Data);
unset($Titulo);


$pdf->ezText("", 30);
$pdf->ezText("INGRESO DE NO ASOCIADOS",16,array('justification'=>'center'));
$pdf->ezText("", 14);


$Titulo = array('col1'=>utf8_decode('FECHA'), 'col2'=>utf8_decode('ADULTOS'), 'col3'=>utf8_decode('NIÑOS'), 'col4'=>utf8_decode('NIÑOS MENORES A 5 AÑOS'), 'col5'=>utf8_decode('TOTAL INGRESO DEL DIA'));


$QueryNoAsociados = mysqli_query($db, "SELECT A.INA_FECHA_INGRESO, SUM(A.INA_ADULTO) AS ADULTOS, SUM(A.INA_NINIO) AS NINIO, SUM(A.INA_NINIO_MENOR_5) AS NINIO_MENOR_5
                                FROM Taquilla.INGRESO_NO_ASOCIADO AS A
                                WHERE A.INA_FECHA_INGRESO BETWEEN '".$FechaIni."' AND '".$FechaFin."'
                                GROUP BY A.INA_FECHA_INGRESO
                                ORDER BY A.INA_FECHA_INGRESO ASC");
while($FilaNA = mysqli_fetch_array($QueryNoAsociados)) 
{
    $TotalIngresoNoAsociadosDia = 0;
    $TotalAdultos += $FilaNA["ADULTOS"];
    $TotalNinio += $FilaNA["NINIO"];
    $TotalNinioMenor5 += $FilaNA["NINIO_MENOR_5"];

    $TotalIngresoNoAsociadosDia = $FilaNA["ADULTOS"] + $FilaNA["NINIO"] + $FilaNA["NINIO_MENOR_5"];

    $Data[] = array('col1'=>date('d-m-Y', strtotime($FilaNA["INA_FECHA_INGRESO"])), 'col2'=>$FilaNA["ADULTOS"], 'col3'=>$FilaNA["NINIO"], 'col4'=>$FilaNA["NINIO_MENOR_5"], 'col5'=>$TotalIngresoNoAsociadosDia);
}

$TotalIngresoNoAsociados = $TotalAdultos + $TotalNinio + $TotalNinioMenor5;

$Data[] = array('col1'=>'TOTAL', 'col2'=>$TotalAdultos, 'col3'=>$TotalNinio, 'col4'=>$TotalNinioMenor5, 'col5'=>$TotalIngresoNoAsociados);

$pdf->ezTable($Data, $Titulo,'', $Opciones);



unset($Data);
unset($Titulo);


$pdf->ezText("", 30);
$pdf->ezText("CONSOLIDADO ASOCIADOS - NO ASOCIADOS",16,array('justification'=>'center'));
$pdf->ezText("", 14);

$TotalIngresoAdultos = 0;
$TotalIngresoNinio = 0;
$TotalIngresoMenor4 = 0;

$Titulo = array('col1'=>utf8_decode('FECHA'), 'col2'=>utf8_decode('ADULTOS'), 'col3'=>utf8_decode('NIÑOS'), 'col4'=>utf8_decode('NIÑOS MENORES A 5 AÑOS'), 'col5'=>utf8_decode('TOTAL INGRESO DEL DIA'));

$QueryFechaAsociado = mysqli_query($db, "SELECT A.IA_FECHA_INGRESO
                                    FROM Taquilla.INGRESO_ASOCIADO AS A
                                    WHERE A.IA_FECHA_INGRESO BETWEEN '".$FechaIni."' AND '".$FechaFin."'
                                    GROUP BY A.IA_FECHA_INGRESO
                                    ORDER BY A.IA_FECHA_INGRESO ASC");
while($FilaFechaAsociado = mysqli_fetch_array($QueryFechaAsociado))
{
    $IngresoMenor4 = 0;
    $IngresoNinio = 0;
    $IngresoAdulto = 0;
    $TotalAdultos = 0;
    $TotalNinio = 0;
    $TotalNinioMenor5 = 0;
    $TotalIngresoAsociadosDia = 0;

    $FechaAsociado = $FilaFechaAsociado["IA_FECHA_INGRESO"];

    $QueryResumenAsociado = mysqli_query($db, "SELECT A.IAT_CIF_ASOCIADO
                                        FROM Taquilla.INGRESO_ASOCIADO AS A
                                        WHERE A.IA_FECHA_INGRESO = '".$FechaAsociado."'
                                        GROUP BY A.IAT_CIF_ASOCIADO");
    while($FilaResumenAsociado = mysqli_fetch_array($QueryResumenAsociado))
    {
        $CIFAsociado = $FilaResumenAsociado["IAT_CIF_ASOCIADO"];
        $EdadAsociado = Saber_Edad_Asociado($CIFAsociado);

        if($EdadAsociado <= 4)
        {
            $IngresoMenor4++; 
        }
        elseif($EdadAsociado > 4 && $EdadAsociado <= 18)
        {
            $IngresoNinio++;
        }
        else
        {
            $IngresoAdulto++;
        }
    }

    $QueryNoAsociados = mysqli_query($db, "SELECT SUM(A.INA_ADULTO) AS ADULTOS, SUM(A.INA_NINIO) AS NINIO, SUM(A.INA_NINIO_MENOR_5) AS NINIO_MENOR_5
                                FROM Taquilla.INGRESO_NO_ASOCIADO AS A
                                WHERE A.INA_FECHA_INGRESO = '".$FechaAsociado."'");
    while($FilaNA = mysqli_fetch_array($QueryNoAsociados)) 
    {
        $TotalIngresoNoAsociadosDia = 0;
        $TotalAdultos += $FilaNA["ADULTOS"];
        $TotalNinio += $FilaNA["NINIO"];
        $TotalNinioMenor5 += $FilaNA["NINIO_MENOR_5"];

        $TotalIngresoNoAsociadosDia = $FilaNA["ADULTOS"] + $FilaNA["NINIO"] + $FilaNA["NINIO_MENOR_5"];
    }

    $TotalIngresoAsociadosDia = ($IngresoAdulto +  $TotalAdultos) + ($IngresoNinio + $TotalNinio ) + ($IngresoMenor4 + $TotalNinioMenor5);

    $TotalIngresoAdultos += $IngresoAdulto +  $TotalAdultos;
    $TotalIngresoNinio += $IngresoNinio + $TotalNinio;
    $TotalIngresoMenor4 += $IngresoMenor4 + $TotalNinioMenor5;

    $Data[] = array('col1'=>date('d-m-Y', strtotime($FechaAsociado)), 'col2'=>$IngresoAdulto+$TotalAdultos, 'col3'=>$IngresoNinio+$TotalNinio, 'col4'=>$IngresoMenor4+$TotalNinioMenor5, 'col5'=>$TotalIngresoAsociadosDia);
}

$TotalIngresoAsociados = $TotalIngresoAdultos + $TotalIngresoNinio + $TotalIngresoMenor4;

$Data[] = array('col1'=>'TOTAL', 'col2'=>$TotalIngresoAdultos, 'col3'=>$TotalIngresoNinio, 'col4'=>$TotalIngresoMenor4, 'col5'=>$TotalIngresoAsociados);

$pdf->ezTable($Data, $Titulo,'', $Opciones);

unset($Data);
unset($Titulo);


$pdf->ezText("", 30);

$pdf->ezText("RELACION PORCENTAJE - CANTIDAD",16,array('justification'=>'center'));
$pdf->ezText("", 14);

$Titulo = array('col1'=>utf8_decode(''), 'col2'=>utf8_decode('CANTIDAD'), 'col3'=>utf8_decode('PORCENTAJE'));
$PorcentajeEntradaAsociados = (100* ($IngresoAdulto+$IngresoNinio+$IngresoMenor4)) / ($TotalIngresoAsociados + $TotalAcompanantesTotal);
$PorcentajeEntradaNoAsociados = (100*($TotalAdultos+$TotalNinio+$TotalNinioMenor5)) / ($TotalIngresoAsociados + $TotalAcompanantesTotal);
$PorcentajeEntradaAcompanantes = (100*($TotalAcompanantesTotal)) / ($TotalIngresoAsociados + $TotalAcompanantesTotal);

$Data[] = array('col1'=>'INGRESO ASOCIADOS', 'col2'=>$IngresoAdulto+$IngresoNinio+$IngresoMenor4, 'col3'=>number_format($PorcentajeEntradaAsociados, 2).'%');
$Data[] = array('col1'=>'INGRESO NO ASOCIADOS', 'col2'=>$TotalAdultos+$TotalNinio+$TotalNinioMenor5, 'col3'=>number_format($PorcentajeEntradaNoAsociados, 2).'%');
$Data[] = array('col1'=>utf8_decode('INGRESO ACOMPAÑANTES'), 'col2'=>$TotalAcompanantesTotal, 'col3'=>number_format($PorcentajeEntradaAcompanantes, 2).'%');
$Data[] = array('col1'=>'INGRESO TOTAL', 'col2'=>$TotalIngresoAsociados+$TotalAcompanantesTotal, 'col3'=>'100%');

$pdf->ezTable($Data, $Titulo,'', $Opciones);

ob_clean();
$pdf->ezStream();
?>