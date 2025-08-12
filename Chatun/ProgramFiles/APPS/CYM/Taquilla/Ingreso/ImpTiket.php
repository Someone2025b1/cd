<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Usuar = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$User = $_SESSION["login"];

$Cantidad = $_GET["Cantidad"];

    $Icono  = $_SERVER['DOCUMENT_ROOT']."/img/logoev.png"; 


//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {

}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","pt", array(600, 3000), 'UTF-8', FALSE);
// Add a page
$pdf->AddPage();
$pdf->SetMargins(5,0,10, true);
$pdf->SetFont('helvetica', '', 35);

$Transac .= <<<EOD
            <table border="0">  
                
                <tr style="font-size: 34px">
                    <td colspan="8" align="center"><img src="$Icono" width="250" ></td>
                </tr>   
            </table>
            EOD; 
$pdf->writeHTML($Transac,0,0,0,0,'J'); 

$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 25);
$tbl1 = "Parque Chatun";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', 'B', 35);
$tbl1 = "TIKET DE INGRESO";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', 'B', 35);
$tbl1 = "Cantidad:";
$pdf->writeHTML($tbl1,6,6,6,6,'C');
$pdf->SetFont('helvetica', 'B', 80);
$tbl1 = $Cantidad;
$pdf->writeHTML($tbl1,6,6,6,6,'C');
$tbl1 = "TAQUILLA: #1";
$pdf->SetFont('helvetica', 'B', 35);
$pdf->writeHTML($tbl1,1,0,0,6,'C');
$tbl1 = "FECHA: $FechaHora";
$pdf->writeHTML($tbl1,1,0,0,0,'C');


$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');



$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();

?>