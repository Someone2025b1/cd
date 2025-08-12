<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

set_time_limit(300);

ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$Periodo = $_POST["Periodo"];
$FechaInicio = $_POST["FechaInicio"];
$Corrr = $_POST["Correlativo"];

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


$NombreMes = nombre_mes($Mes);


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

$UltimoDiaMes = _data_last_month_day($Mes, $Anho);
$UltimoDiaMesF = date('d-m-Y', strtotime($UltimoDiaMes));

$TotalCargos = 0;
$TotalAbonos = 0;

$Corr = $Corrr+0;

//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

    global $Corr;

      // get the current page break margin
      $bMargin = $this->getBreakMargin();
      // get current auto-page-break mode
      $auto_page_break = $this->AutoPageBreak;
      // disable auto-page-break
      $this->SetAutoPageBreak(false, 0);
      // set bacground image
      $this->Image('LibroDiario.jpg', 0, 0, 216, 350, '', '', '', false, 300, '', false, false, 0);
      // restore auto-page-break status
      $this->SetAutoPageBreak($auto_page_break, $bMargin);
      // set the starting point for the page content
      $this->setPageMark();
  
      //$this->Image('LibroDiario.jpg',0,0,500,600);
      //$this->SetFont('Helvetica','B',10);
      //$this->SetFont('Helvetica', '', 8);
      //$this->Image('tabla.png',180,4,25);
      //$this->Cell(10,5, "",0,1,'R');
      //$this->Cell(185,0,'FOLIO NO.',0,0,'R');
      $this->SetTextColor(255,0,0);
      $this->SetFont('Helvetica', '', 16);
      $this->Cell(10,5, "",0,1,'R');
      $this->SetFont('Helvetica', '', 20);
      $this->Cell(10,5, "",0,1,'R');
      $this->SetFont('Helvetica', '', 18);
      $this->Cell(165,0, "$Corr",0,1,'R');
      //$this->SetTextColor(0,0,0);
      //$this->SetFont('Helvetica','B',12);
      //$this->Cell(0,0,'LIBRO DIARIO',0,0,'C');
      
      //$this->SetFont('Helvetica', '', 8);
      //$this->Cell(10,5, "",0,1,'R');

      //$this->SetFont('Helvetica','B',12);
      //$this->Cell(0,0,'ACERCATE',0,0,'C');

      //$this->SetFont('Helvetica', '', 8);
      //$this->Cell(150,5, "",0,1,'R');

     // $this->SetFont('Helvetica','B',8);
      //$this->Cell(0,0,'Asociación Para el Crecimiento Educativo Reg. Cooperativo y Apoyo Turistico de Esquipulas -ACERCATE-',0,0,'C');

      //$this->SetFont('Helvetica', '', 8);
      //$this->Cell(150,2, "",0,1,'R');

      //$this->SetFont('Helvetica','B',8);
      //$this->Cell(0,0,'NIT:9206609-7',0,0,'C');
        
      $Corr=$Corr+1;
      
    }
     // Page footer
     public function Footer() {
        // Position at 15 mm from bottom
        //$this->SetY(-10);
        // Set font

        //$this->SetFont('Helvetica','B',8);
        //$this->Cell(0,0,'Kilometro 226.5 carretera asfaltada hacía Frontera de Honduras Parque Chatun, Esquipulas, Chiquimula.',0,0,'C');
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","legal", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,43,10);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 14);
$pdf->Cell(150,5, "",0,1,'R');
$pdf->SetFont('Helvetica', '',14);
$pdf->Cell(0,0, "Mes de ".$NombreMes,0,1,'C');
$pdf->Cell(0,0, "Cifras Expresadas en Quetzales",0,1,'C');
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Cell(150,4, "",0,1,'R');
$pdf->SetFont('Helvetica', '', 8);

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

  $pdf->SetFont('Helvetica', 'B', 9);
  $txt = "Partidas del día $FechaFormato";
  $pdf->writeHTML($txt,true,0,0,0,'C');   

  $QueryTipoTransaccion = mysqli_query($db, "SELECT DISTINCT(TT_CODIGO)
                                        FROM Contabilidad.TRANSACCION
                                        WHERE E_CODIGO =2
                                        AND PC_CODIGO = ".$Periodo."
                                        AND TRA_FECHA_TRANS = '".$FechaSinFormato."'
                                        ORDER BY TT_CODIGO");
  while($fila = mysqli_fetch_array($QueryTipoTransaccion))
  {
    unset($tbl1);

    $tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td align="left" style="background-color: #C9C9C9"><b>Cuenta</b></td>
    <td align="left" style="background-color: #C9C9C9"><b>Descripción</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Debe</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Haber</b></td>
    </tr>
EOD;


    $SumaCargos = 0;
    $SumaAbonos = 0; 
    $TipoTransaccion = $fila["TT_CODIGO"];
    $NombreTransaccion = saber_nombre_transaccion_contabilidad($TipoTransaccion);
     $pdf->SetFont('Helvetica', '', 8);
    $txt = "#".$FacturaContador." ".$NombreTransaccion." ".date('d-m-Y', strtotime($FechaSinFormato));
    $pdf->writeHTML($txt,true,0,0,0,'L');  

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

      $CargosFormato = number_format($Cargos, 2);
      $AbonosFormato = number_format($Abonos, 2);

      $tbl1 .= <<<EOD
    <tr>
    <td align="left" style="background-color: #C9C9C9">$Codigo</td>
    <td align="left" style="background-color: #C9C9C9">$Nombre</td>
    <td align="right" style="background-color: #C9C9C9">$CargosFormato</td>
    <td align="right" style="background-color: #C9C9C9">$AbonosFormato</td>
    </tr>
EOD;
    }

    $SumaCargosFormato = number_format($SumaCargos, 2);
    $SumaAbonosFormato = number_format($SumaAbonos, 2);

    $tbl1 .= <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td align="left" style="background-color: #C9C9C9"></td>
    <td align="left" style="background-color: #C9C9C9"><b>TOTALES</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>$SumaCargosFormato</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>$SumaAbonosFormato</b></td>
    </tr>
EOD;

    $FacturaContador++;

    $SumaTotalCargos += $SumaCargos;
    $SumaTotalAbonos += $SumaAbonos;

    $tbl1 .= <<<EOD
<tr>
<td align="left" colspan="4">___________________________________________________________________________________________</td>
</tr>
EOD;
$pdf->writeHTML($tbl1,0,0,0,1,'J'); 
  }

}

$SumaTotalCargosFormato = number_format($SumaTotalCargos, 2);
$TotalGeneralAbonosFormato = number_format($SumaTotalAbonos, 2);

$txt = "<b>Total de Cargos:  $SumaTotalCargosFormato</b>";
$pdf->writeHTML($txt,true,0,0,1,'C'); 
$txt = "<b>Total de Abonos:  $TotalGeneralAbonosFormato</b>";
$pdf->writeHTML($txt,true,0,0,1,'C'); 
ob_clean();
$pdf->Output();
ob_flush();
?>