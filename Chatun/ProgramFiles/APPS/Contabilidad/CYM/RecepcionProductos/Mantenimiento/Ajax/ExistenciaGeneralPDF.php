<?php
include("../../../../../../Script/funciones.php");
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../../libs/ezpdf/class.ezpdf.php");


$TablaProducto = <<<EOD
    <table cellspacing="0.5" cellpadding="0.5" border="0.5">
    <tr style="border: 2px;">
    <td align="center" style="font-size: 10px; width: 5%;"><strong>Cod. </strong></td>
    <td align="center" style="font-size: 10px; width: 15%;"><strong>Nombre </strong></td>
    <td align="center" style="font-size: 10px; width: 10%;"><strong>Promedio Ponderado </strong></td>
    <td align="center" style="font-size: 10px; width: 10%;"><strong>Precio Venta </strong></td>
    <td align="center" style="font-size: 10px; width: 10%;"><strong>Existencia Bodega </strong></td>
    <td align="center" style="font-size: 10px; width: 10%;"><strong>Existencia Terrazas </strong></td>
    <td align="center" style="font-size: 10px; width: 10%;"><strong>Existencia Souvenir </strong></td>
    <td align="center" style="font-size: 10px; width: 10%;"><strong>Existencia Cafe Los Abuelos </strong></td>
    <td align="center" style="font-size: 10px; width: 10%;"><strong>Existencia Helados </strong></td>
    <td align="center" style="font-size: 10px; width: 10%;"><strong>Existencia General </strong></td>
    </tr>
EOD;
$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_LLEVA_EXISTENCIA=1 ORDER BY PRODUCTO.P_NOMBRE");
while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $Cod = $row1["P_CODIGO"];
            $Nombre=$row1["P_NOMBRE"];
            $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
            $Venta=$row1["P_PRECIO_VENTA"];
            $Bodega=$row1["P_EXISTENCIA_BODEGA"];
            $Terrazas=$row1["P_EXISTENCIA_TERRAZAS"];
            $Souvenir=$row1["P_EXISTENCIA_SOUVENIRS"];
            $Cafe=$row1["P_EXISTENCIA_CAFE"];
            $Helados=$row1["P_EXISTENCIA_HELADOS"];
            $General=$row1["P_EXISTENCIA_GENERAL"];

    

    
            $TablaProducto .= <<<EOD
            <tr style="border: 2px;">
                <td align="left" style="font-size: 8px; width: 5%;"> $Cod </td>
                <td align="left" style="font-size: 8px; width: 15%;">  $Nombre </td>
                <td align="left" style="font-size: 8px; width: 10%;">  $Ponderado </td> 
                <td align="left" style="font-size: 8px; width: 10%;"> $Venta </td>
                <td align="left" style="font-size: 8px; width: 10%;">  $Bodega </td>
                <td align="left" style="font-size: 8px; width: 10%;">  $Terrazas </td>
                <td align="left" style="font-size: 8px; width: 10%;"> $Souvenir </td>
                <td align="left" style="font-size: 8px; width: 10%;">  $Cafe </td>
                <td align="left" style="font-size: 8px; width: 10%;">  $Helados </td>
                <td align="left" style="font-size: 8px; width: 10%;"> $General </td>
            </tr>
            EOD;

    
}
$TablaProducto .= <<<EOD
</table>
EOD;
//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Legal", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(10,10,10);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(0,0, "Existencias Generales",0,1,'C');
$pdf->SetFont('Helvetica', '', 5);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->writeHTML($TablaProducto, true, false, true, false, '');
// force print dialog
$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();
?>					
	