<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Usuar = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$User = $_SESSION["login"];

$Retiro = $_GET["Codigo"];

$sql = "SELECT * FROM Bodega.RETIRO_DINERO AS A  WHERE A.RD_CODIGO = '".$Retiro."'";
$result = mysqli_query($db,$sql);
while($row = mysqli_fetch_array($result))
{
    $Fecha  = $row["RD_FECHA"];
    $Usuario  = $row["RD_USUARIO"];
    $Punto    = $row["RD_PUNTO"];
    $Monto    = $row["RD_MONTO"];
    
}

$sqlCaj = mysqli_query($db,"SELECT A.nombre 
FROM info_bbdd.usuarios AS A     
WHERE A.id_user = ".$Usuar); 
$rowcaj=mysqli_fetch_array($sqlCaj);

$NombreCaj=$rowcaj["nombre"];

$sqlRet = mysqli_query($db,"SELECT A.nombre 
FROM info_bbdd.usuarios AS A     
WHERE A.id_user = ".$Usuario); 
$rowret=mysqli_fetch_array($sqlRet);

$NombreRet=$rowret["nombre"];




//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {

}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","pt", array(600, 3000), 'UTF-8', FALSE);
// Add a page
$pdf->AddPage();
$pdf->SetMargins(-5,0,-10, true);
$pdf->SetFont('helvetica', '', 35);

$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 25);
$tbl1 = "CONSTANCIA";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', 'B', 35);
$tbl1 = "RETIRO DE EFECTIVO";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "CODIGO: ".$Retiro;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 50);
$tbl1 = "MONTO: Q.".$Monto;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "PUNTO DE VENTA: ".$Punto;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "$FechaHora";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "ENTREGA: ".$NombreCaj;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "RETIRA: ".$NombreRet;
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$pdf->AddPage();
$pdf->SetMargins(-5,0,-10, true);
$pdf->SetFont('helvetica', '', 35);

$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$pdf->SetFont('helvetica', '', 25);
$tbl1 = "CONSTANCIA";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', 'B', 35);
$tbl1 = "RETIRO DE EFECTIVO";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "CODIGO: ".$Retiro;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 50);
$tbl1 = "MONTO: Q.".$Monto;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "PUNTO DE VENTA: ".$Punto;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "$FechaHora";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "ENTREGA: ".$NombreCaj;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "RETIRA: ".$NombreRet;
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();

?>