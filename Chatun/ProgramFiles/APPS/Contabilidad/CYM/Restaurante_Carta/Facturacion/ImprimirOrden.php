<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$User = $_SESSION["login"];

$Factura = $_GET["Codigo"];

$sql = "SELECT * FROM Bodega.FACTURA_RS AS A LEFT JOIN Bodega.RESOLUCION AS B ON A.RES_NUMERO = B.RES_NUMERO WHERE A.F_CODIGO = '".$Factura."'";
$result = mysqli_query($db, $sql);
while($row = mysqli_fetch_array($result))
{
    $Serie  = $row["F_SERIE"];
    $Numero  = $row["F_NUMERO"];
    $NIT    = $row["CLI_NIT"];
    $TipoPago    = $row["F_TIPO"];
    if($TipoPago == 1)
    {
        $Pago = 'EFECTIVO';
    }
    elseif($TipoPago == 2)
    {
        $Pago = 'TARJETA CREDITO';
    }
    elseif($TipoPago == 3)
    {
        $Pago = 'CREDITO';
    }
    elseif($TipoPago == 4)
    {
        $Pago = 'DEPOSITO';
    }
    $TotalFactura  = $row["F_TOTAL"];
    $PagoEfectivo = number_format($row["F_EFECTIVO"], 2, '.', ',');
    $Cambio = number_format($row["F_CAMBIO"], 2, '.', ',');
    $NumeroOrden = $row["F_ORDEN"];
    $ResolucionNumero = $row["RES_NUMERO"];
    $Descuento = $row["F_CON_DESCUENTO"];
    $DTE = $row["F_DTE"];
    $CAE = $row["F_CAE"];
}


$sqlCliente = "SELECT * FROM Bodega.CLIENTE WHERE CLI_NIT = '".$NIT."'";
$resultCliente = mysqli_query($db, $sqlCliente);
while($rowC = mysqli_fetch_array($resultCliente))
{
    $Nombre  = utf8_decode($rowC["CLI_NOMBRE"]);
    $Direccion  = utf8_decode($rowC["CLI_DIRECCION"]);
}

$TablaProducto = <<<EOD
<table cellspacing="2" cellpadding="1" border="0">
EOD;

$sqlD = "SELECT A.MO_CANTIDAD, C.RS_NOMBRE
FROM Bodega.MESA_ORDEN AS A
INNER JOIN Bodega.MESA AS B ON A.M_CODIGO = B.M_CODIGO
INNER JOIN Bodega.RECETA_SUBRECETA AS C ON A.RS_CODIGO = C.RS_CODIGO
WHERE B.M_CODIGO = '".$_GET["Mesa"]."'";
$resultD = mysqli_query($db, $sqlD);
while($rowD = mysqli_fetch_array($resultD))
{
    $Cantidad  = number_format($rowD["MO_CANTIDAD"], 0, '.', ',');
    $NombreProd  = $rowD["RS_NOMBRE"];
    $TablaProducto .= <<<EOD
    <tr>
    <td align="left" style="font-size: 30px; width: 50px;">$Cantidad</td>
    <td align="left" style="font-size: 30px; width: 500px">$NombreProd</td>
    </tr>
EOD;
}

$TablaProducto .= <<<EOD
</table>
EOD;

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
$tbl1 = "MESA NÚMERO:   <b>".$_GET["Mesa"]."</b>";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->writeHTML($TablaProducto,0,0,0,0,'J'); 
// force print dialog
$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();

?>