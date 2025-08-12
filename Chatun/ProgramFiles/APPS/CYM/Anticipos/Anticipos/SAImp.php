<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$TotalAperturas = 0;
$TotalCancelaciones = 0;
$Saldo = 0;
$Codigo = $_GET["Codigo"];
$Usuario = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s');

$sql = "SELECT * FROM Contabilidad.TRANSACCION WHERE TRA_CODIGO = '".$Codigo."'";
$result = mysqli_query($db,$sql);
while($row = mysqli_fetch_array($result))
{
    $Fecha = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]))." ".$row["TRA_HORA"];
    $Concepto = $row["TRA_CONCEPTO"];
    $TotalAnticipo = number_format($row["TRA_TOTAL"], 2, '.', ',');
    $Solicitante = $row["TRA_SOLICITA_GASTO"];
    $NoAnticipo = $row["TRA_NO_ANTICIPO"];
    $NombreSolicitante = saber_nombre_colaborador($Solicitante);
}


//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->setPrintHeader(false);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(0,0,"Asociación para el Crecimiento Educativo Reg.",0,1,'C');
$pdf->Cell(0,0,"Cooperativo y Apoyo Turístico de Esquipulas",0,1,'C');
$pdf->SetFont('Helvetica', 'B', 20);
$pdf->Cell(0,0,"-ACERCATE-",0,1,'C');
$pdf->writeHTML($txt,1,0,0,0,'C'); 
$pdf->SetFont('Helvetica', '', 10);
$txt = "<br><br>";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "Anticipo No. $NoAnticipo";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "<b>Para: </b>Departamento de Contabilidad";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "<b>Asunto: </b>Anticipo para gastos";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "<b>Responsable: </b>$NombreSolicitante";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "<b>Monto Solicitado: </b>Q. $TotalAnticipo";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "<b>Fecha: </b> $Fecha";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "<br><br>";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "__________________________________________________________________________________________________";
$pdf->Image('../../../../../img/logo.png',120,50,40,0,'PNG');
$pdf->writeHTML($txt,1,0,0,0,'C'); 
$txt = "<br><br>";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "Por este medio solicito la cantidad de :Q. $TotalAnticipo, para:";
$pdf->writeHTML($txt,1,0,0,0,'J');
$txt = "<br>";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "$Concepto";
$pdf->writeHTML($txt,1,0,0,0,'J');
$txt = "<br><br><br>";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "Por este medio, me comoprometo a cancelar el presente anticipo dentro de los diez días hábiles que establece El Reglamento de Compras -ACERCATE- en el artículo 16 numeral 3. En caso de inclumplimiento presentaré a Gerencia las justificaciones.";
$pdf->writeHTML($txt,1,0,0,0,'J');
$txt = "<br><br><br><br><br><br>";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "_____________________________________";
$pdf->writeHTML($txt,1,0,0,0,'C');
$txt = "$NombreSolicitante";
$pdf->writeHTML($txt,1,0,0,0,'C');
$txt = "Colaborador";
$pdf->writeHTML($txt,1,0,0,0,'C');
$txt = "<br><br><br>";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "_____________________________________";
$pdf->writeHTML($txt,1,0,0,0,'C');
$txt = "Autorizado por Gerencia General";
$pdf->writeHTML($txt,1,0,0,0,'C');
$txt = "<br><br><br>";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "_____________________________________";
$pdf->writeHTML($txt,1,0,0,0,'J');
$txt = "Quien recibe en Contabilidad";
$pdf->writeHTML($txt,1,0,0,0,'J');
$txt = "<br><br><br>";
$pdf->writeHTML($txt,1,0,0,0,'J'); 
$txt = "_______/_______/______________________";
$pdf->writeHTML($txt,1,0,0,0,'J');
$txt = "Entrega/Liquidación";
$pdf->writeHTML($txt,1,0,0,0,'J');
ob_clean();
$pdf->Output();
ob_flush();
?>