<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$i = 1;

$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));


//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = '../../../../../img/logo.png';
        $this->Image($image_file, 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0,0,"Asociación para el Crecimiento Educativo Reg.",0,1,'C');
$this->Cell(0,0,"Cooperativo y Apoyo Turístico de Esquipulas",0,1,'C');
$this->Cell(0,0,"-ACERCATE-",0,1,'C');
        $this->SetFont('helvetica', '', 15);
        $this->Cell(0,0,"Reporte de Resoluciones",0,1,'C');
        $this->SetFont('helvetica', '', 12);
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("L","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,45,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(0,0, "Generó: $Usuario",0,1,'R');
$pdf->Cell(0,0, "$FechaHora",0,1,'R');
$pdf->SetFont('Helvetica', '', 8);

$tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td style="background-color: #C9C9C9"><b>Resolucion</b></td>
    <td style="background-color: #C9C9C9"><b>Fecha Autorizacion</b></td>
    <td style="background-color: #C9C9C9"><b>Serie</b></td>
    <td style="background-color: #C9C9C9"><b>Del</b></td>
    <td style="background-color: #C9C9C9"><b>Al</b></td>
    <td style="background-color: #C9C9C9"><b>Fecha Ingreso</b></td>
    <td style="background-color: #C9C9C9"><b>Tipo Documento</b></td>
    <td style="background-color: #C9C9C9"><b>Fecha Vencimiento</b></td>
    <td style="background-color: #C9C9C9"><b>Estado</b></td>
    </tr>
EOD;


$Consulta = "SELECT * FROM Bodega.RESOLUCION ORDER BY RES_NUMERO";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
    if($row["RES_ESTADO"] == 0)
                                        {
                                            $Estado = 'Inactivo (Por Usar)';
                                        }
                                        elseif($row["RES_ESTADO"] == 1)
                                        {
                                            $Estado = 'Activo';
                                        }
                                        else
                                        {
                                            $Estado = 'Inactivo (Completo)';
                                        }
                                        $Codigo = $row["RES_NUMERO"];

$FechaAutorizacion = date('d-m-Y', strtotime($row["RES_FECHA_RESOLUCION"]));
$Serie = $row["RES_SERIE"];
$Del = $row["RES_DEL"];
$Al = $row["RES_AL"];
$FechaIngreso = date('d-m-Y', strtotime($row["RES_FECHA_INGRESO"]));
$TipoDocumento = $row["RES_TIPO_DOCUMENTO"];
$FechaVencimiento = date('d-m-Y', strtotime($row["RES_FECHA_VENCIMIENTO"]));


                                        $tbl1 .= <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td>$Codigo</td>
    <td>$FechaAutorizacion</td>
    <td>$Serie</td>
    <td>$Del</td>
    <td>$Al</td>
    <td>$FechaIngreso</td>
    <td>$TipoDocumento</td>
    <td>$FechaVencimiento</td>
    <td>$Estado</td>
    </tr>
EOD;


}

$tbl1 .= <<<EOD
</table>
EOD;
$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
ob_clean();
$pdf->Output();
ob_flush();
?>