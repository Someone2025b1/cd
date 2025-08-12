<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$User = $_SESSION["login"];

$Factura = $_GET["Codigo"];

$sql = "SELECT * FROM Bodega.FACTURA_PIZZA AS A LEFT JOIN Bodega.RESOLUCION AS B ON A.RES_NUMERO = B.RES_NUMERO WHERE A.F_CODIGO = '".$Factura."'";
$result = mysqli_query($db,$sql);
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
    $DTE = $row["F_DTE"];
    $CAE = $row["F_CAE"];
}


$sqlCliente = "SELECT * FROM Bodega.CLIENTE WHERE CLI_NIT = '".$NIT."'";
$resultCliente = mysqli_query($db,$sqlCliente);
while($rowC = mysqli_fetch_array($resultCliente))
{
    $Nombre  = $rowC["CLI_NOMBRE"];
    $Direccion  = utf8_decode($rowC["CLI_DIRECCION"]);
}

$TablaProducto = <<<EOD
<table cellspacing="4" cellpadding="1" border="0">
    <tr>
    <td align="left">CA</td>
    <td align="left">PROD</td>
    </tr>
EOD;

$sqlD = "SELECT FACTURA_PIZZA_DETALLE.*, PRODUCTO.P_NOMBRE 
                FROM Bodega.FACTURA_PIZZA_DETALLE, Productos.PRODUCTO 
                WHERE FACTURA_PIZZA_DETALLE.RS_CODIGO = PRODUCTO.P_CODIGO
                AND FACTURA_PIZZA_DETALLE.F_CODIGO = '".$Factura."'";
$resultD = mysqli_query($db,$sqlD);
while($rowD = mysqli_fetch_array($resultD))
{
    $Cantidad  = number_format($rowD["FD_CANTIDAD"], 0, '.', ',');
    $NombreProd  = $rowD["P_NOMBRE"];
    $PrecioUnitario  = number_format($rowD["FD_PRECIO_UNITARIO"], 2, '.', ',');
    $Descuento  = number_format($rowD["FD_DESCUENTO"], 2, '.', ',');
    $Descuento1  += $rowD["FD_DESCUENTO"];
    $Subtotal  = number_format($rowD["FD_SUBTOTAL"], 2, '.', ',');
    $TablaProducto .= <<<EOD
    <tr>
    <td align="left" style="font-size: 30px; width: 30%;">$Cantidad</td>
    <td align="left" style="font-size: 30px; width: 70%;">$NombreProd</td>
    </tr>
EOD;
}



$SQLRes =  "SELECT * FROM Bodega.RESOLUCION WHERE RES_NUMERO = '".$ResolucionNumero."'";
$ResultRes = mysqli_query($db,$SQLRes);
while($FilaRes = mysqli_fetch_array($ResultRes))
{
    $DelResolucion = $FilaRes["RES_DEL"];
    $AlResolucion = $FilaRes["RES_AL"];
    $FechaResolucion = $FilaRes["RES_FECHA_RESOLUCION"];
}

$TotalFactura = number_format($TotalFactura, 2, '.', ',');


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
$pdf->SetMargins(5,0,10, true);
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$pdf->writeHTML($Transac,0,0,0,0,'J'); 

$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 55);
$tbl1 = "ORDEN #".$NumeroOrden;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);

$tbl1 = "------------------------------------------";
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