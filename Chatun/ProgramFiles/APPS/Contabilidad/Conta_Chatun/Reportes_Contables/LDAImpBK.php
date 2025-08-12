<?php
ob_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");


$Periodo = $_POST["Periodo"];
$FechaInicio = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];

$TotalGeneralCargos = 0;
$TotalGeneralAbonos = 0;

$FacturaContador = 1;

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


$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText("Del ".$PrimerDiaMesF." Al ".$UltimoDiaMesF,14,array('justification'=>'center'));
$pdf->ezText("Expresado en Quetzales",14,array('justification'=>'center'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>'Cuenta', 'col2'=>'Nombre', 'col3'=>'Cargos', 'col4'=>'Abonos');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'showLines'=>1, 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/

$Consulta = "SELECT DISTINCT (TRA_FECHA_TRANS)
FROM Contabilidad.TRANSACCION
WHERE E_CODIGO =2
AND PC_CODIGO = ".$Periodo."
ORDER BY TRA_FECHA_TRANS";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
  $FechaFormato = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
  $FechaSinFormato = $row["TRA_FECHA_TRANS"];
  $pdf->ezText(utf8_decode("Partidas del día ").$FechaFormato,13,array('justification'=>'center'));
  $pdf->ezText("",14,array('justification'=>'center'));
  $pdf->ezText("",14,array('justification'=>'center'));
  

  $QueryTipoTransaccion = mysqli_query($db, "SELECT DISTINCT(TT_CODIGO)
                                        FROM Contabilidad.TRANSACCION
                                        WHERE E_CODIGO =2
                                        AND PC_CODIGO = ".$Periodo."
                                        AND TRA_FECHA_TRANS = '".$FechaSinFormato."'
                                        ORDER BY TT_CODIGO");
  while($fila = mysqli_fetch_array($QueryTipoTransaccion))
  {
    unset($Data);
    $SumaCargos = 0;
  $SumaAbonos = 0; 
    $TipoTransaccion = $fila["TT_CODIGO"];
    $NombreTransaccion = saber_nombre_transaccion_contabilidad($TipoTransaccion);
    $pdf->ezText(utf8_decode("#".$FacturaContador." ".$NombreTransaccion." ".date('d-m-Y', strtotime($FechaSinFormato))),12,array('justification'=>'left'));
    $pdf->ezText("",8,array('justification'=>'center'));
    $QueryPartida = mysqli_query($db, "SELECT SUM( A.TRAD_CARGO_CONTA ) AS CARGOS, SUM( A.TRAD_ABONO_CONTA ) AS ABONOS, A.N_CODIGO AS CODIGO_NOMENCLATURA, C.N_NOMBRE
                                  FROM Contabilidad.TRANSACCION_DETALLE AS A
                                  INNER JOIN Contabilidad.TRANSACCION AS B ON A.TRA_CODIGO = B.TRA_CODIGO
                                  INNER JOIN Contabilidad.NOMENCLATURA AS C ON A.N_CODIGO = C.N_CODIGO
                                  WHERE B.E_CODIGO =2
                                  AND B.PC_CODIGO = ".$Periodo."
                                  AND B.TRA_FECHA_TRANS = '".$FechaSinFormato."'
                                  AND B.TT_CODIGO = ".$TipoTransaccion."
                                  GROUP BY A.N_CODIGO");
    while($FilaP = mysqli_fetch_array($QueryPartida))
    {
      $Codigo = $FilaP["CODIGO_NOMENCLATURA"];
      $Nombre = $FilaP["N_NOMBRE"];
      $Cargos = $FilaP["CARGOS"];
      $Abonos = $FilaP["ABONOS"];
      $SumaCargos += $Cargos;
      $SumaAbonos += $Abonos; 

      $Data[] = array('col1'=>$Codigo, 'col2'=>utf8_decode($Nombre), 'col3'=>number_format($Cargos, 2), 'col4'=>number_format($Abonos, 2));
    }

    $SumaTotalCargos += $SumaCargos;
     $SumaTotalAbonos += $SumaAbonos;
    $Data[] = array('col1'=>'', 'col2'=>utf8_decode('TOTALES'), 'col3'=>number_format($SumaCargos, 2), 'col4'=>number_format($SumaAbonos, 2));
    $pdf->ezTable($Data, $Titulo,'', $Opciones);
    $pdf->ezText("",19,array('justification'=>'center'));

    $FacturaContador++;
  }
}
$pdf->ezText("",19,array('justification'=>'center'));
$pdf->ezText("",19,array('justification'=>'center'));
$pdf->ezText("TOTAL CARGOS: ".number_format($SumaTotalCargos, 2),19,array('justification'=>'center'));
$pdf->ezText("TOTAL ABONOS: ".number_format($SumaTotalAbonos, 2),19,array('justification'=>'center'));

ob_clean();
$pdf->ezStream();
?>