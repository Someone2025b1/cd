<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$User = $_SESSION["login"];

$Factura = $_GET["Codigo"];

$sql = "SELECT * FROM Bodega.FACTURA_HS AS A LEFT JOIN Bodega.RESOLUCION AS B ON A.RES_NUMERO = B.RES_NUMERO WHERE A.F_CODIGO = '".$Factura."'";
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
    <tr>
    <td align="left">CA</td>
    <td align="left">PROD</td>
    <td align="right">P/U</td>
    <td align="right">DESC</td>
    <td align="right">TOTAL</td>
    </tr>
EOD;

$sqlD = "SELECT FACTURA_HS_DETALLE.*, FACTURA_HS_DETALLE.RS_NOMBRE AS RS_NOMBRE
                FROM Bodega.FACTURA_HS_DETALLE, Productos.PRODUCTO 
                WHERE FACTURA_HS_DETALLE.RS_CODIGO = PRODUCTO.P_CODIGO
                AND FACTURA_HS_DETALLE.F_CODIGO = '".$Factura."'";
$resultD = mysqli_query($db, $sqlD);
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
$SQLRes =  "SELECT * FROM Bodega.RESOLUCION WHERE RES_NUMERO = '".$ResolucionNumero."'";
$ResultRes = mysqli_query($db, $SQLRes);
while($FilaRes = mysqli_fetch_array($ResultRes))
{
    $DelResolucion = $FilaRes["RES_DEL"];
    $AlResolucion = $FilaRes["RES_AL"];
    $FechaResolucion = $FilaRes["RES_FECHA_INGRESO"];
}

$TotalFactura = number_format($TotalFactura, 2, '.', ',');

$TablaProducto .= <<<EOD
    <tr>
    <td align="left"></td>
    <td align="right" colspan="2" style="font-size: 30px ">TOTAL Q.</td>
    <td align="right" style="font-size: 30px ">$TotalFactura</td>
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
$pdf->SetFont('helvetica', '', 55);
$tbl1 = "ORDEN #".$NumeroOrden;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "$FechaHora";
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
    $tbl1 = "";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $tbl1 = "";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $tbl1 = "";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $tbl1 = "(f)___________________________";
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

// $pdf->AddPage();
// $pdf->SetMargins(1,0,10, true);
// $pdf->SetFont('Helvetica', '', 30);  
// $pdf->Cell(0,0, "",0,1,'R'); 
// $TotalMascarilla = $TotalFactura / 50;
// $Mascarilla = round($TotalMascarilla, 0, PHP_ROUND_HALF_EVEN);
// if ($Mascarilla>0) {
//    $Texto = "¡Gracias por tu compra! Te ganas: ".$Mascarilla." mascarilla.";
// } 
// else
// {
//     $Texto = "¡¡GRACIAS POR CUMPLIR LOS PROTOCOLOS DE BIOSEGURIDAD!! <br>
//     Al reunir Q 50.00 en todos tus consumos puedes adquirir una mascarilla GRATIS. <br> Tu consumo: ".$TotalFactura;
// }
//   $pdf->SetFont('helvetica', '', 80); 
//    $TransacDet .= <<<EOD
// <table border="0">   
//     <tr style="font-size: 20px">
//         <td align="left"><b>PS:</b> Helados </td> 
//     </tr>  
//     <tr style="font-size: 20px">
//         <td align="left">$FechaHora </td> 
//     </tr>    
//     <tr style="font-size: 30px"> <br>
//         <td colspan="8" align="center">$Texto </td>
//     </tr>   
//     <tr style="font-size: 20px"> 
//         <td colspan="8" align="center"><img src="2833278.png" width="300" height="250"> <br>
//         Recuerda que debes dar like a la página de Facebook de Parque Chatun.<br>
//         ¡Canjea en servicio al cliente!</td>
//     </tr>  
// </table>
// EOD; 
// $pdf->writeHTML($TransacDet,0,0,0,0,'J'); 

# PARA TIKETS

$Logo  = "../../Logo20.png"; 


$Boletos = "SELECT BOLETOS.*
        FROM Bodega.BOLETOS
        WHERE BOLETOS.B_FACTURA = '".$Factura."'";
$Boletos1 = mysqli_query($db, $Boletos);

while($ResBol = mysqli_fetch_array($Boletos1))
{
    $Numero=$ResBol["B_NUMERO"];
    $Punto=$ResBol["B_PUNTO"];

    $Transac1= <<<EOD
    <table border="0">     
        <tr style="font-size: 34px">
            <td colspan="8" align="center"><img src="$Logo" width="165" height="150"></td>
        </tr>   
    </table>
    EOD; 

$pdf->AddPage();
$pdf->SetMargins(5,0,10, true);
$pdf->SetFont('helvetica', '', 15);
$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetMargins(5,0,10, true);
$pdf->SetFont('helvetica', '', 15);
$pdf->writeHTML($Transac1,0,0,0,0,'J'); 

$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 55);
$tbl1 = "RIFA";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 75);
$tbl1 = "Cupón #".$Numero;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "P.V. ".$Punto;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);



$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

}


$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();

?>