<?php
set_time_limit(1200);

ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");

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
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,45,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', '',16);
$pdf->Cell(0,0, "Del ".$PrimerDiaMesF." Al ".$UltimoDiaMesF,0,1,'C');
$pdf->Cell(0,0, "Cifras Expresadas en Quetzales",0,1,'C');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', '', 10);

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
$Concepto = $row1["TRA_CONCEPTO"]; 
$Transaccion = $row1["TT_NOMBRE"];
$Fecha = date('d-m-Y', strtotime($row1["TRA_FECHA_TRANS"])); 

$txt = "<b># $NoPartida  $Transaccion del $Fecha</b>";
$pdf->writeHTML($txt,true,0,0,0,'L'); 
$txt = "$Concepto";
$pdf->writeHTML($txt,true,0,0,0,'L'); 
$tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td align="left" style="background-color: #C9C9C9"><b>Código</b></td>
    <td align="left" style="background-color: #C9C9C9"><b>Cuenta</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Debe</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Haber</b></td>
    </tr>
EOD;

$Consulta = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA 
WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
AND TRA_CODIGO = '".$Codigo."'";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{

$Codigo = $row["N_CODIGO"];
$Nombre = $row["N_NOMBRE"];
$Cargos = $row["TRAD_CARGO_CONTA"];
$Abonos = $row["TRAD_ABONO_CONTA"];
$tbl1 .= <<<EOD
<tr>
<td align="left">$Codigo</td>
<td align="left">$Nombre</td>
<td align="right">$Cargos</td>
<td align="right">$Abonos</td>
</tr>
EOD;
$TotalCargos = $TotalCargos + $Cargos;
$TotalAbonos = $TotalAbonos + $Abonos;
}
$TotalGeneralCargos = $TotalGeneralCargos + $TotalCargos;
$TotalGeneralAbonos = $TotalGeneralAbonos + $TotalAbonos;

$TotalCargos = number_format($TotalCargos, 2, '.', ',');
$TotalAbonos = number_format($TotalAbonos, 2, '.', ',');
$tbl1 .= <<<EOD
<tr>
<td align="left"></td>
<td align="left"><b>Sumas Iguales</b></td>
<td align="right"><b>$TotalCargos</b></td>
<td align="right"><b>$TotalAbonos</b></td>
</tr>
EOD;
$tbl1 .= <<<EOD
<tr>
<td align="left" colspan="4">______________________________________________________________________________________________</td>
</tr>
EOD;
$pdf->writeHTML($tbl1,0,0,0,0,'J'); 

}
$TotalGeneralCargos = number_format($TotalGeneralCargos, 2, '.', ',');
$TotalGeneralAbonos = number_format($TotalGeneralAbonos, 2, '.', ',');

$txt = "<b>Total de Cargos:  $TotalGeneralCargos</b>";
$pdf->writeHTML($txt,true,0,0,0,'C'); 
$txt = "<b>Total de Abonos:  $TotalGeneralAbonos</b>";
$pdf->writeHTML($txt,true,0,0,0,'C'); 
ob_clean();
$pdf->Output();
ob_flush();
?>