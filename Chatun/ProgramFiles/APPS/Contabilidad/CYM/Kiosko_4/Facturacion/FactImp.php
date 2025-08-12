<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$User = $_SESSION["login"];

$Factura = $_GET["Codigo"];

$sql = "SELECT * FROM Bodega.FACTURA_KS_4 AS A LEFT JOIN Bodega.RESOLUCION AS B ON A.RES_NUMERO = B.RES_NUMERO WHERE A.F_CODIGO = '".$Factura."'";
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
    $Descuento = $row["F_CON_DESCUENTO"];
    $DTE = $row["F_DTE"];
    $CAE = $row["F_CAE"];
}


$sqlCliente = "SELECT * FROM Bodega.CLIENTE WHERE CLI_NIT = '".$NIT."'";
$resultCliente = mysqli_query($db,$sqlCliente);
while($rowC = mysqli_fetch_array($resultCliente))
{
    $Nombre  = utf8_decode($rowC["CLI_NOMBRE"]);
    $Direccion  = utf8_decode($rowC["CLI_DIRECCION"]);
}

$TablaProducto = <<<EOD
<table cellspacing="2" cellpadding="1" border="0">
    <tr>
    <td align="left">CA</td>
    <td align="left">PROD</td>
    <td align="right">P/U</td>
    <td align="right">DESC</td>
    <td align="right">TOTAL</td>
    </tr>
EOD;

$sqlD = "SELECT FACTURA_KS_4_DETALLE.*, RECETA_SUBRECETA.RS_NOMBRE 
FROM Bodega.FACTURA_KS_4_DETALLE, Bodega.RECETA_SUBRECETA 
WHERE FACTURA_KS_4_DETALLE.RS_CODIGO = RECETA_SUBRECETA.RS_CODIGO
AND FACTURA_KS_4_DETALLE.F_CODIGO = '$Factura'
UNION ALL 
SELECT FACTURA_KS_4_DETALLE.*, PRODUCTO.P_NOMBRE 
FROM Bodega.FACTURA_KS_4_DETALLE, Bodega.PRODUCTO 
WHERE FACTURA_KS_4_DETALLE.RS_CODIGO = PRODUCTO.P_CODIGO
AND FACTURA_KS_4_DETALLE.F_CODIGO = '$Factura'";
$resultD = mysqli_query($db,$sqlD);
while($rowD = mysqli_fetch_array($resultD))
{
    $Cantidad  = number_format($rowD["FD_CANTIDAD"], 0, '.', ',');
    $NombreProd  = $rowD["RS_NOMBRE"];
    $PrecioUnitario  = number_format($rowD["FD_PRECIO_UNITARIO"], 2, '.', ',');
    $Descuento  = number_format($rowD["FD_DESCUENTO"], 2, '.', ',');
    $Subtotal  = number_format($rowD["FD_SUBTOTAL"], 2, '.', ',');
    $Descuento1  += $rowD["FD_DESCUENTO"];
    $TablaProducto .= <<<EOD
    <tr>
    <td align="left" style="font-size: 30px; width: 50px;">$Cantidad</td>
    <td align="left" style="font-size: 30px; width: 230px;">$NombreProd</td>
    <td align="right" style="font-size: 30px; width: 100px;">$PrecioUnitario</td>
    <td align="right" style="font-size: 30px; width: 100px;">$Descuento</td>
    <td align="right" style="font-size: 30px; width: 120px;">$Subtotal</td>
    </tr>
EOD;
}

if($Descuento != 0)
{
    $DescuentoFormato = number_format($Descuento1, 2, '.', ',');
    $TablaProducto .= <<<EOD
    <tr>
    <td align="left" style="font-size: 35px; width: 80px;"></td>
    <td align="left" style="font-size: 35px; width: 270px;">SUBTOTAL</td>
    <td align="right" style="font-size: 35px; width: 120px;">Q.</td>
    <td align="right" style="font-size: 35px; width: 120px;">$DescuentoFormato</td>
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
    <tr>
    <td align="left"></td>
    <td align="right" colspan="2" style="font-size: 35px ">TOTAL Q.</td>
    <td align="right" style="font-size: 35px ">$TotalFactura</td>
    </tr>
EOD;
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
$tbl1 = "ASOCIACIÓN PARA EL CRECIMIENTO EDUCATIVO";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "REG. COOPERATIVO Y APOYO TURÍSTICO DE ESQUIPULAS";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "-ACERCATE-";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "KILOMETRO 226.5 CARRETERA DE ASFALTADA HACIA";
$pdf->writeHTML($tbl1,1,0,0,0,'C'); 
$tbl1 = "FRONTERA DE HONDURAS";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "PARQUE CHATUN";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "ESQUIPULAS, CHIQUIMULA";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "N.I.T. 9206609-7";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 25);
$tbl1 = "DOCUMENTO TRIBUTARIO ELECTRONICO";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', 'B', 35);
$tbl1 = "FACTURA";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "SERIE: ".$Serie;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "NUMERO: ".$CAE;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "AUTORIZACIÓN: ";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = $DTE;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "$FechaHora";
$pdf->writeHTML($tbl1,1,0,0,0,'R');
$tbl1 = "$User";
$pdf->writeHTML($tbl1,1,0,0,0,'R');
$tbl1 = "Computadora No. 1";
$pdf->writeHTML($tbl1,1,0,0,0,'R');
$tbl1 = "Transacción $Factura";
$pdf->writeHTML($tbl1,1,0,0,0,'R');
$tbl1 = "N.I.T.:     $NIT";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$tbl1 = "NOMBRE:     $Nombre";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$tbl1 = "DIRECCION:   $Direccion";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->writeHTML($TablaProducto,0,0,0,0,'J'); 
$tbl1 = "TIPO PAGO:   $Pago";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
if($rowD["FD_SUBTOTAL"] == 1)
    {
        $tbl1 = "PAGO Q.:         ".$PagoEfectivo;
        $pdf->writeHTML($tbl1,1,0,0,0,'L');
    }
    elseif($rowD["FD_SUBTOTAL"] == 2)
    {
        $tbl1 = "PAGO $.:         ".$PagoEfectivo;
        $pdf->writeHTML($tbl1,1,0,0,0,'L');
    }
    elseif($rowD["FD_SUBTOTAL"] == 3)
    {
        $tbl1 = "PAGO $.:         ".$PagoEfectivo;
        $pdf->writeHTML($tbl1,1,0,0,0,'L');
    }
$tbl1 = "CAMBIO Q.:      $Cambio";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
if($TipoPago == 3)
{
    $tbl1 = "(f)___________________________________________";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $tbl1 = "Firma de Aceptación de Crédito";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
}
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "CERTIFICADOR: INFILE, S.A.";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "NIT CERTIFICADOR: 12521337";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "SUJETO A PAGOS TRIMESTRALES";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "ESPERAMOS QUE VUELVA PRONTO";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "GRACIAS POR PREFERIRNOS";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
// force print dialog
$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();

?>