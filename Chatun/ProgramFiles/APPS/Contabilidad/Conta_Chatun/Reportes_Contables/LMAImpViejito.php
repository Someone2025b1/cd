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
$Corrr = $_POST["Correlativo"];


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
//$pdf->ezImage("LibroMayor.jpg", 0,80, 'none', 'left');
//$pdf->ezText("\n\n\n", 3);
//$pdf->ezSetCmMargins(2,2,2,2);
$pdf->ezText(utf8_decode(""),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode(""),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode(""),22,array('justification'=>'center'));
$pdf->ezText("",16,array('justification'=>'center'));
$pdf->ezText("Del ".date('d-m-Y', strtotime($FechaIni))." Al ".date('d-m-Y', strtotime($FechaFin)),14,array('justification'=>'center'));
$pdf->ezText("Cifras Expresadas en Quetzales",14,array('justification'=>'center'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>utf8_decode('Descripción'), 'col2'=>'Cargos', 'col3'=>'Abonos', 'col4'=>'Saldo');
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
AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1
GROUP BY `TRANSACCION_DETALLE`.`N_CODIGO`
ORDER BY `TRANSACCION_DETALLE`.`N_CODIGO` ASC , `TRANSACCION`.`TRA_CORRELATIVO` ASC ";
$Resultado1 = mysqli_query($db, $Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
    $pdf->ezText("",14,array('justification'=>'center'));
    $pdf->ezText("",14,array('justification'=>'center'));
    unset($Data);
    $TotalCargos = 0;
    $TotalAbonos = 0;
    $Saldo = 0;


    $CodigoContable = $row1["N_CODIGO"];
    $Nombrecontable = utf8_decode($row1["N_NOMBRE"]);
    $pdf->ezText("$CodigoContable - $Nombrecontable",14,array('justification'=>'center'));
    $pdf->ezText("",14,array('justification'=>'center'));

    $sql2 = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_CONTA` ) AS `SUMA_CARGOS` , SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_CONTA` ) AS `SUMA_ABONOS` , `NOMENCLATURA`.`N_TIPO`
        FROM `Contabilidad`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE` , `Contabilidad`.`TRANSACCION` AS `TRANSACCION` , `Contabilidad`.`NOMENCLATURA` AS `NOMENCLATURA`
        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO`
        AND `TRANSACCION_DETALLE`.`N_CODIGO` = `NOMENCLATURA`.`N_CODIGO`
        AND `TRANSACCION`.`TRA_FECHA_TRANS`
        BETWEEN '2015-01-01'
        AND '".$FechaFinal."' AND TRANSACCION.TRA_ESTADO = 1
        AND `TRANSACCION_DETALLE`.`N_CODIGO` = '".$CodigoContable."'
        AND TRANSACCION.E_CODIGO = 2";    


    $result2 = mysqli_query($db, $sql2);
    if($fila = mysqli_fetch_array($result2))
    { 
        if($CodigoContable=="1.01.01.001" && ($fila["TRA_FECHA_TRANS"]>="2021-08-29"))
        {
        	$RestarS = 125;
        }
        else
        {
        	$RestarS = 0;	
        }

        if($CodigoContable=="1.01.01.001" && $fila["TRA_FECHA_TRANS"]=="2021-08-29")
        {
        	$RestarSo = 125; 
        }
        else
        {
        	$RestarSo = 0; 	
        }
        $Cargos = $fila["SUMA_CARGOS"];
        $Abonos = $fila["SUMA_ABONOS"];
        $Cargo = number_format($fila["SUMA_CARGOS"], 2, '.', ',');
        $Abono = number_format($fila["SUMA_ABONOS"], 2, '.', ',');
        $Saldo = $Saldo + ($Cargos - $Abonos);
        $SaldoArreglado = number_format($Saldo, 2, '.', ',');
       
        $TotalCargos = $TotalCargos + $fila["SUMA_CARGOS"];
        $TotalAbonos = $TotalAbonos + $fila["SUMA_ABONOS"];

        $Data[] = array('col1'=>'Saldos Anteriores', 'col2'=>number_format($Cargos, 2), 'col3'=>number_format($Abonos, 2), 'col4'=>number_format($Saldo, 2));
    }

    $sql2 = "SELECT `TRANSACCION`.`TRA_FECHA_TRANS`, SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_CONTA` ) AS `SUMA_CARGOS` , SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_CONTA` ) AS `SUMA_ABONOS` , `NOMENCLATURA`.`N_TIPO`
        FROM `Contabilidad`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE` , `Contabilidad`.`TRANSACCION` AS `TRANSACCION` , `Contabilidad`.`NOMENCLATURA` AS `NOMENCLATURA`
        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO`
        AND `TRANSACCION_DETALLE`.`N_CODIGO` = `NOMENCLATURA`.`N_CODIGO`
        AND `TRANSACCION`.`TRA_FECHA_TRANS`
        BETWEEN '".$FechaIni."'
        AND '".$FechaFin."'
        AND `TRANSACCION_DETALLE`.`N_CODIGO` = '".$CodigoContable."'
        AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1
        GROUP BY `TRANSACCION`.`TRA_FECHA_TRANS`";    


    $result2 = mysqli_query($db, $sql2);
    while($fila = mysqli_fetch_array($result2))
    {
        $Cargos = $fila["SUMA_CARGOS"];
        $Abonos = $fila["SUMA_ABONOS"];
        $Cargo = number_format($fila["SUMA_CARGOS"], 2, '.', ',');
        $Abono = number_format($fila["SUMA_ABONOS"], 2, '.', ',');
        $Saldo = $Saldo + ($Cargos - $Abonos);
        $SaldoArreglado = number_format($Saldo, 2, '.', ',');
       
        $TotalCargos = $TotalCargos + $fila["SUMA_CARGOS"];
        $TotalAbonos = $TotalAbonos + $fila["SUMA_ABONOS"];
        if($CodigoContable=="1.01.01.004" && ($fila["TRA_FECHA_TRANS"]>="2021-03-27"))
        {
        	$RestarT = 254;
        }
        else
        {
        	$RestarT = 0;	
        }

        if($CodigoContable=="1.01.01.004" && $fila["TRA_FECHA_TRANS"]=="2021-03-27")
        {
        	$Restar = 254; 
        }
        else
        {
        	$Restar = 0; 	
        }

        if($CodigoContable=="1.01.01.001" && ($fila["TRA_FECHA_TRANS"]>="2021-08-29"))
        {
        	$RestarS = 125;
        }
        else
        {
        	$RestarS = 0;	
        }

        if($CodigoContable=="1.01.01.001" && $fila["TRA_FECHA_TRANS"]=="2021-08-29")
        {
        	$RestarSo = 125; 
        }
        else
        {
        	$RestarSo = 0; 	
        }
        
        $Data[] = array('col1'=>'Movimientos del '.date('d-m-Y', strtotime($fila["TRA_FECHA_TRANS"])), 'col2'=>number_format($Cargos-$Restar-$RestarSo, 2), 'col3'=>number_format($Abonos, 2), 'col4'=>number_format($Saldo, 2));
    }

    $Data[] = array('col1'=>'SUMAS', 'col2'=>number_format($TotalCargos, 2), 'col3'=>number_format($TotalAbonos, 2), 'col4'=>"");

    $pdf->ezTable($Data, $Titulo,'', $Opciones);
}

ob_clean();
$pdf->ezStream();
?>