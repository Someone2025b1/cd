<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Periodo = $_POST["Periodo"];
$FechaInicio = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];

$TotalGeneralCargos = 0;
$TotalGeneralAbonos = 0;

$GLOBALS["FechaI"] = $_POST["FechaInicio"];
$GLOBALS["FechaF"] = $_POST["FechaFin"];

$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));

$QueryPeriodo = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE EPC_CODIGO = 1 AND PC_CODIGO = ".$Periodo;
$ResultPeriodo = mysqli_query($db, $QueryPeriodo);
while($FilaP = mysqli_fetch_array($ResultPeriodo))
{
    $Mes = $FilaP["PC_MES"];
    $Anho = $FilaP["PC_ANHO"];
}

 /** Actual month first day **/
  function _data_first_month_day($Mes, $Anho) {
      $month = $Mes;
      $year = $Anho;
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }

$PrimerDiaMes = _data_first_month_day($Mes, $Anho);
$PrimerDiaMesF = date('d-m-Y', strtotime($PrimerDiaMes));

$UltimoDiaMes = _data_first_month_day($Mes, $Anho);
$UltimoDiaMesF = date('d-m-Y', strtotime($UltimoDiaMes));

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
    $Titulo = array('col1'=>utf8_decode('Código'), 'col2'=>utf8_decode('Cuenta'), 'col3'=>utf8_decode('Debe'), 'col4'=>utf8_decode('Haber'));
/*FIN TITULOS*/
 
/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5), 'cols'=>array(
 'col2'=>array('justification'=>'right'), 'col3'=>array('justification'=>'right'), 'col4'=>array('justification'=>'right')));
/*FIN OPCIONES*/


$Consulta1 = "SELECT TRANSACCION.*, TIPO_TRANSACCION.TT_NOMBRE FROM Contabilidad.TRANSACCION, Contabilidad.TIPO_TRANSACCION
            WHERE TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO 
            AND E_CODIGO = 2 AND TRA_ESTADO = 1
            AND PC_CODIGO = 63
            ORDER BY TRA_CORRELATIVO, TRA_FECHA_TRANS, TRA_HORA ";
$Resultado1 = mysqli_query($db, $Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
    $TotalCargos = 0;
    $TotalAbonos = 0;
    $Codigo = $row1["TRA_CODIGO"];
    $NoPartida = $row1["TRA_CORRELATIVO"]; 
    $Concepto = utf8_decode($row1["TRA_CONCEPTO"]); 
    $Transaccion = $row1["TT_NOMBRE"];
    $Fecha = date('d-m-Y', strtotime($row1["TRA_FECHA_TRANS"])); 
    $pdf->ezText('<b># '.$NoPartida.' '.$Transaccion.' del '.$Fecha.'</b>',12,array('justification'=>'left'));
    $pdf->ezText($Concepto,12,array('justification'=>'left'));

    $Consulta = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA 
    WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
    AND TRA_CODIGO = '".$Codigo."'";
    $Resultado = mysqli_query($db, $Consulta);
    while($row = mysqli_fetch_array($Resultado))
    {
    $Codigo = $row["N_CODIGO"];
    $Nombre = utf8_decode($row["N_NOMBRE"]);
    $Cargos = $row["TRAD_CARGO_CONTA"];
    $Abonos2 = $row["TRAD_ABONO_CONTA"];
    $Data[] = array('col1'=>$Codigo, 'col2'=>$Nombre, 'col3'=>$Cargos, 'col4'=>$Abonos2); 
    $pdf->ezText('',14,array('justification'=>'left'));
    $TotalCargos = $TotalCargos + $Cargos;
    $TotalAbonos = $TotalAbonos + $Abonos2;
    }
    $TotalGeneralCargos = $TotalGeneralCargos + $TotalCargos;
    $TotalGeneralAbonos = $TotalGeneralAbonos + $TotalAbonos;
    $TotalCargos = number_format($TotalCargos, 2, '.', ',');
    $TotalAbonos = number_format($TotalAbonos, 2, '.', ',');
    $Data[] = array('col1'=>'', 'col2'=>'Sumas Iguales', 'col3'=>$TotalCargos, 'col4'=>$TotalAbonos);
    $pdf->ezTable($Data, $Titulo,'', $Opciones);
}

ob_clean();
$pdf->ezStream();
?>