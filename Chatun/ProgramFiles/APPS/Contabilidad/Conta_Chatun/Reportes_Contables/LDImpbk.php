<?php
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

function _data_last_month_day($Mes, $Anho) { 
      $month = $Mes;
      $year = $Anho;
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
 
      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  };
 
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

$Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));

$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText("", 90);
$pdf->ezText("Del ".$PrimerDiaMesF." Al ".$UltimoDiaMesF,16,array('justification'=>'center'));
$pdf->ezText("Cifras Expresadas en Quetzales",16,array('justification'=>'center'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>'<b>Codigo</b>', 'col2'=>'<b>Cuenta</b>', 'col3'=>'<b>Debe</b>', 'col4'=>'<b>Haber</b>');
/*FIN TITULOS*/


$Consulta1 = "SELECT TRANSACCION.*, TIPO_TRANSACCION.TT_NOMBRE FROM Contabilidad.TRANSACCION, Contabilidad.TIPO_TRANSACCION
            WHERE TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO 
            AND E_CODIGO = 2 
            AND PC_CODIGO = ".$Periodo."
            ORDER BY TRA_CORRELATIVO, TRA_FECHA_TRANS, TRA_HORA";
$Resultado1 = mysqli_query($db, $Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
  $TotalCargos = 0;
  $TotalAbonos = 0;
  $Codigo = $row1["TRA_CODIGO"];
  $NoPartida = $row1["TRA_CORRELATIVO"]; 
  $Concepto = utf8_decode($row1["TRA_CONCEPTO"]); 
  $Transaccion = utf8_decode($row1["TT_NOMBRE"]);

  $pdf->ezText("<b># $NoPartida  $Transaccion del $Fecha</b>",10,array('justification'=>'left'));
  $pdf->ezText("$Concepto",10,array('justification'=>'left'));

  $Consulta = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA 
  WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
  AND TRA_CODIGO = '".$Codigo."'";
  $Resultado = mysqli_query($db, $Consulta);
  while($row = mysqli_fetch_array($Resultado))
  {

    $Codigo = $row["N_CODIGO"];
    $Nombre = utf8_encode($row["N_NOMBRE"]);
    $Cargos = $row["TRAD_CARGO_CONTA"];
    $Abonos = $row["TRAD_ABONO_CONTA"];
    
    $Data[] = array('col1'=>$Codigo, 'col2'=>$Nombre, 'col3'=>$Cargos, 'col4'=>$Abonos);


    $TotalCargos = $TotalCargos + $Cargos;
    $TotalAbonos = $TotalAbonos + $Abonos;
  }

  $TotalGeneralCargos = $TotalGeneralCargos + $TotalCargos;
  $TotalGeneralAbonos = $TotalGeneralAbonos + $TotalAbonos;

  $TotalCargos = number_format($TotalCargos, 2, '.', ',');
  $TotalAbonos = number_format($TotalAbonos, 2, '.', ',');


  $Data[] = array('col1'=>'', 'col2'=>'Sumas Iguales', 'col3'=>$TotalCargos, 'col4'=>$TotalAbonos);

  $pdf->ezTable($Data);

  $pdf->ezText("<b>_________________________________________________________________________________________________<b>",10,array('justification'=>'center'));

  unset($Data);

}
$TotalGeneralCargos = number_format($TotalGeneralCargos, 2, '.', ',');
$TotalGeneralAbonos = number_format($TotalGeneralAbonos, 2, '.', ',');



ob_clean();
$pdf->ezStream();
?>

