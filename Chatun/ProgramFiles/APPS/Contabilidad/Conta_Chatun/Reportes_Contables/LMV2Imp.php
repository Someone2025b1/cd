<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];

$TotalGeneralCargos = 0;
$TotalGeneralAbonos = 0;
$SaldoArrelagdo = 0;
$TotalCargosArreglado = 0;
$TotalAbonosArreglado = 0;

$GLOBALS["FechaI"] = $_POST["FechaInicio"];
$GLOBALS["FechaF"] = $_POST["FechaFin"];
$FechaFinal = date("Y-m-d", strtotime("$FechaIni -1  days"));

$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));


$TotalCargos = 0;
$TotalAbonos = 0;


$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode(""),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode(""),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode(""),22,array('justification'=>'center'));
$pdf->ezText("",16,array('justification'=>'center'));
$pdf->ezText("Del ".date('d-m-Y', strtotime($FechaIni))." Al ".date('d-m-Y', strtotime($FechaFin)),14,array('justification'=>'center'));
$pdf->ezText("Cifras Expresadas en Quetzales",14,array('justification'=>'center'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>utf8_decode('Fecha'), 'col2'=>utf8_decode('Partida'), 'col3'=>utf8_decode('Observaciones'), 'col4'=>utf8_decode('Cargos'), 'col5'=>utf8_decode('Abonos'), 'col6'=>utf8_decode('Saldo'));
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5), 'cols'=>array(
 'col2'=>array('justification'=>'right'), 'col3'=>array('justification'=>'right'), 'col4'=>array('justification'=>'right')));
/*FIN OPCIONES*/

$Consulta1 = "SELECT `TRANSACCION_DETALLE`.`N_CODIGO` , `NOMENCLATURA`.`N_NOMBRE`
FROM `Contabilidad`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE` , `Contabilidad`.`NOMENCLATURA` AS `NOMENCLATURA` , `Contabilidad`.`TRANSACCION` AS `TRANSACCION`
WHERE `TRANSACCION_DETALLE`.`N_CODIGO` = `NOMENCLATURA`.`N_CODIGO`
AND `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO`
AND `TRANSACCION`.`TRA_FECHA_TRANS`
BETWEEN '".$FechaIni."'
AND '".$FechaFin."'
AND TRANSACCION.E_CODIGO = 2
GROUP BY `TRANSACCION_DETALLE`.`N_CODIGO`
ORDER BY `TRANSACCION_DETALLE`.`N_CODIGO` ASC , `TRANSACCION`.`TRA_CORRELATIVO` ASC ";
$Resultado1 = mysqli_query($db, $Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
    unset($Data);

    $TotalCargos = 0;
    $TotalAbonos = 0;
    $Saldo = 0;
    $SaldoArrelagdo = 0;

    $CodigoContable = $row1["N_CODIGO"];
    $Nombrecontable = utf8_decode($row1["N_NOMBRE"]);

    $pdf->ezText($CodigoContable." - ".$Nombrecontable,12,array('justification'=>'left'));

    $pdf->ezText('',14,array('justification'=>'left'));

    $sql2 = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_CONTA` ) AS `SUMA_CARGOS` , SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_CONTA` ) AS `SUMA_ABONOS` , `NOMENCLATURA`.`N_TIPO`
        FROM `Contabilidad`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE` , `Contabilidad`.`TRANSACCION` AS `TRANSACCION` , `Contabilidad`.`NOMENCLATURA` AS `NOMENCLATURA`
        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO`
        AND `TRANSACCION_DETALLE`.`N_CODIGO` = `NOMENCLATURA`.`N_CODIGO`
        AND `TRANSACCION`.`TRA_FECHA_TRANS`
        BETWEEN '2015-01-01'
        AND '".$FechaFinal."'
        AND `TRANSACCION_DETALLE`.`N_CODIGO` = '".$CodigoContable."'
        AND TRANSACCION.E_CODIGO = 2";    

    $result2 = mysqli_query($db, $sql2);
    if($fila = mysqli_fetch_array($result2))
    {
        $Cargos = $fila["SUMA_CARGOS"];
        $Abonos = $fila["SUMA_ABONOS"];
        $Cargo = number_format($fila["SUMA_CARGOS"], 2, '.', ',');
        $Abono = number_format($fila["SUMA_ABONOS"], 2, '.', ',');
        $Saldo = $Saldo + ($Cargos - $Abonos);
        $SaldoArreglado = number_format($Saldo, 2, '.', ',');


        $Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'Saldos Anteriores', 'col4'=>$Cargo, 'col5'=>$Abono, 'col6'=>$SaldoArreglado);

        $TotalCargos = $TotalCargos + $fila["SUMA_CARGOS"];
        $TotalAbonos = $TotalAbonos + $fila["SUMA_ABONOS"];

    }

    $sql1 = "SELECT `TRANSACCION`.`TRA_FECHA_TRANS` , `TRANSACCION_DETALLE`.`N_CODIGO` , `TRANSACCION`.`TRA_CORRELATIVO` , `NOMENCLATURA`.`N_NOMBRE` , `TRANSACCION`.`TRA_CONCEPTO` , `TRANSACCION_DETALLE`.`TRAD_CARGO_CONTA` , `TRANSACCION_DETALLE`.`TRAD_ABONO_CONTA`
            FROM `Contabilidad`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE` , `Contabilidad`.`NOMENCLATURA` AS `NOMENCLATURA` , `Contabilidad`.`TRANSACCION` AS `TRANSACCION`
            WHERE `TRANSACCION_DETALLE`.`N_CODIGO` = `NOMENCLATURA`.`N_CODIGO`
            AND `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO`
            AND `TRANSACCION`.`TRA_FECHA_TRANS`
            BETWEEN '".$FechaIni."'
            AND '".$FechaFin."'
            AND `TRANSACCION_DETALLE`.`N_CODIGO` = '".$CodigoContable."'
            AND TRANSACCION.E_CODIGO = 2
            ORDER BY `TRANSACCION`.`TRA_CORRELATIVO` ASC ";   

    $result1    = mysqli_query($db, $sql1);

    while($row1 = mysqli_fetch_assoc($result1))
    {
        $Fecha = date('d-m-Y', strtotime($row1["TRA_FECHA_TRANS"]));
        $Partida = $row1["TRA_CORRELATIVO"];
        $Observaciones = $row1["TRA_CONCEPTO"];
        $Cargos = $row1["TRAD_CARGO_CONTA"];
        $Abonos = $row1["TRAD_ABONO_CONTA"];
        $Cargo = number_format($row1["TRAD_CARGO_CONTA"], 2, '.', ',');
        $Abono = number_format($row1["TRAD_ABONO_CONTA"], 2, '.', ',');
        $Saldo = $Saldo + ($Cargos - $Abonos);
        $SaldoArrelagdo = number_format($Saldo, 2, '.', ',');

        $Data[] = array('col1'=>$Fecha, 'col2'=>$Partida, 'col3'=>utf8_decode($Observaciones), 'col4'=>$Cargo, 'col5'=>$Abono, 'col6'=>$SaldoArrelagdo);

        $TotalCargos = $TotalCargos + $row1["TRAD_CARGO_CONTA"];
        $TotalAbonos = $TotalAbonos + $row1["TRAD_ABONO_CONTA"];
        $TotalCargosArreglado = number_format($TotalCargos, 2, '.', ',');
        $TotalAbonosArreglado = number_format($TotalAbonos, 2, '.', ',');
    }

    $Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'Totales', 'col4'=>$TotalCargosArreglado, 'col5'=>$TotalAbonosArreglado, 'col6'=>'');

    $pdf->ezTable($Data, $Titulo,'', $Opciones);
    $pdf->ezText('',14,array('justification'=>'left'));
}

ob_clean();
$pdf->ezStream();
?>