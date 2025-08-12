<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$GLOBALS['Codigo'] = $_GET["Codigo"];
$TotalCargos = 0;
$TotalAbonos = 0;


$Consulta = "SELECT * FROM Bodega.COTIZACION WHERE C_CODIGO = '".$_GET["Codigo"]."'";
$Resultado = mysqli_query($db, $Consulta);
$row = mysqli_fetch_array($Resultado);

$MontoReserva =$row["C_RESERVA_MONTO"];
$RecibiDe     =$row["CE_NOMBRE"];


//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {

        $this->SetFont('helvetica', 'B', 20);

    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,30,15);
// Add a page
$pdf->AddPage();
$pdf->Cell(0,0, "".$RecibiDe,0,1,'L');
$pdf->Cell(0,0, "Q. ".number_format($MontoReserva, 2),0,1,'L');
$pdf->Cell(0,0, "Reserva de Evento en Chatun",0,1,'L');

ob_clean();
$pdf->Output();
ob_flush();
?>