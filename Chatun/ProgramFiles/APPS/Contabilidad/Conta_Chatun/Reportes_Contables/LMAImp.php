<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Username = $_SESSION["iduser"];

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];
$Corr = $_POST["Correlativo"];


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

$Anho = date('Y');
$FechaInicioConsulta=$Anho."-01-01";


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
      $this->Image('LibroMayor.jpg', 0, 0, 216, 350, '', '', '', false, 300, '', false, false, 0);
      // restore auto-page-break status
      $this->SetAutoPageBreak($auto_page_break, $bMargin);
      // set the starting point for the page content
      $this->setPageMark();
  
 
      $this->SetTextColor(255,0,0);
      $this->SetFont('Helvetica', '', 16);
      $this->Cell(10,5, "",0,1,'R');
      $this->SetFont('Helvetica', '', 20);
      $this->Cell(10,5, "",0,1,'R');
      $this->SetFont('Helvetica', '', 18);
      $this->Cell(165,0, "$Corr",0,1,'R');
   
        
      $Corr=$Corr+1;
      
    }
   
}


$pdf = new MYPDF("P","mm","legal", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,43,10);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 14);
$pdf->Cell(150,5, "",0,1,'R');
$pdf->SetFont('Helvetica', '',14);
$pdf->Cell(0,0, "Del ".$FechaIni." Al ".$FechaFin,0,1,'C');
$pdf->Cell(0,0, "Cifras Expresadas en Quetzales",0,1,'C');
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Cell(150,4, "",0,1,'R');
$pdf->SetFont('Helvetica', '', 8);


/*TITULOS*/
    
/*FIN TITULOS*/

/*OPCIONES*/
   // $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5), 'cols'=>array(
 //'col2'=>array('justification'=>'right'), 'col3'=>array('justification'=>'right'), 'col4'=>array('justification'=>'right')));
/*FIN OPCIONES*/


$Consulta1 = "SELECT `TRANSACCION_DETALLE`.`N_CODIGO` , `NOMENCLATURA`.`N_NOMBRE`
FROM `Contabilidad`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE` , `Contabilidad`.`NOMENCLATURA` AS `NOMENCLATURA` , `Contabilidad`.`TRANSACCION` AS `TRANSACCION`
WHERE `TRANSACCION_DETALLE`.`N_CODIGO` = `NOMENCLATURA`.`N_CODIGO`
AND `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO`
AND `TRANSACCION`.`TRA_FECHA_TRANS`
BETWEEN '2015-01-01'
AND '".$FechaFin."'
AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1
GROUP BY `TRANSACCION_DETALLE`.`N_CODIGO`
ORDER BY `TRANSACCION_DETALLE`.`N_CODIGO` ASC , `TRANSACCION`.`TRA_CORRELATIVO` ASC ";
$Resultado1 = mysqli_query($db, $Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
    //$pdf->ezText("",14,array('justification'=>'center'));
    //$pdf->ezText("",14,array('justification'=>'center'));
   // unset($Data);
    unset($tbl1);

    $tbl1 = <<<EOD
            <table border="0.5"  style= "border: black 1px solid;">
                <tr>
                <td align="left" style="background-color: #C4C7C3"; ><b>Descripción</b></td>
                <td align="left" style="background-color: #C4C7C3"; ><b>Cargos</b></td>
                <td align="right" style="background-color: #C4C7C3"; ><b>Abonos</b></td>
                <td align="right" style="background-color: #C4C7C3"; ><b>Saldo</b></td>
                </tr>
            EOD;

    $TotalCargos = 0;
    $TotalAbonos = 0;
    $Saldo = 0;


    $CodigoContable = $row1["N_CODIGO"];
    $Nombrecontable = $row1["N_NOMBRE"];
    $pdf->SetFont('Helvetica', '',14);
    $pdf->Cell(0,0, "".$CodigoContable." - ".$Nombrecontable,0,1,'C');
    $pdf->Cell(150,4, "",0,1,'R');



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

        $Saldoformato=number_format($Saldo, 2, '.', ',');
        $Cargosformato=number_format($Cargos, 2, '.', ',');
        $Abonosformato=number_format($Abonos, 2, '.', ',');

        $tbl1 .= <<<EOD
                <tr>
                <td align="left">Saldos Anteriores</td>
                <td align="right">$Cargosformato</td>
                <td align="right">$Abonosformato</td>
                <td align="right">$Saldoformato</td>
                </tr>
            EOD;

        //$Data[] = array('col1'=>'Saldos Anteriores', 'col2'=>number_format($Cargos, 2), 'col3'=>number_format($Abonos, 2), 'col4'=>number_format($Saldo, 2));
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

        $FechaTra=($fila["TRA_FECHA_TRANS"]);
        $restaCa=number_format($Cargos-$Restar-$RestarSo, 2);
        $Cargosformato=number_format($Cargos, 2, '.', ',');
        $Abonosformato=number_format($Abonos, 2, '.', ',');
        $Saldoformato=number_format($Saldo, 2, '.', ',');

        
        $tbl1 .= <<<EOD
                <tr>
                <td align="left" >$FechaTra</td>
                <td align="right" >$restaCa</td>
                <td align="right" >$Abonosformato</td>
                <td align="right" >$Saldoformato</td>
                </tr>
            EOD;
        
        //$Data[] = array('col1'=>'Movimientos del '.date('d-m-Y', strtotime($fila["TRA_FECHA_TRANS"])), 'col2'=>number_format($Cargos-$Restar-$RestarSo, 2), 'col3'=>number_format($Abonos, 2), 'col4'=>number_format($Saldo, 2));
    }

    $tbl1 .= <<<EOD
            <tr>
            <td align="lefth">SUMAS</td>
            <td align="right">$TotalCargos</td>
            <td align="right">$TotalAbonos</td>
            <td align="center"> </td>
            </tr>
            </table>
            <br>
            <br>
        EOD;

    //$Data[] = array('col1'=>'SUMAS', 'col2'=>number_format($TotalCargos, 2), 'col3'=>number_format($TotalAbonos, 2), 'col4'=>"");

    //$pdf->ezTable($Data, $Titulo,'', $Opciones);
$pdf->SetFont('Helvetica', '', 8);
$pdf->writeHTML($tbl1,0,0,0,1,'J'); 
}

ob_clean();
$pdf->Output();
ob_flush();
//ob_clean();
//$pdf->ezStream();
?>