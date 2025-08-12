<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$User = $_SESSION["login"];

$Factura = $_GET["Codigo"];

$sql = "SELECT A.TRA_TOTAL, A.TRA_ISR, A.TRA_IVA, A.TRA_FACTURA, A.TRA_SERIE, A.TRA_DTE, A.TRA_CAE, A.TRA_FECHA_TRANS, A.TRA_HORA, A.TRA_FECHA_CERTIFICACION FROM Contabilidad.TRANSACCION A
WHERE A.TRA_CODIGO = '$Factura'";
$result = mysqli_query($db, $sql);
while($row = mysqli_fetch_array($result))
{
    $Serie  = $row["TRA_SERIE"];
    $Numero  = $row["TRA_FACTURA"];  
    $FechaCert = cambio_fecha($row["TRA_FECHA_CERTIFICACION"]);
    $Fecha = cambio_fecha($row["TRA_FECHA_TRANS"])." ".$row["TRA_HORA"];
    $DTE = $row["TRA_DTE"];
    $CAE = $row["TRA_CAE"];
    $ISR = number_format($row["TRA_ISR"],2);
    $IVA = number_format($row["TRA_IVA"],2);
    $Total = number_format($row["TRA_TOTAL"],2);
}

$SqlNit = "SELECT DFA_NIT FROM Contabilidad.DETALLE_FACTURA_ADMINISTRATIVA  
WHERE TRA_CODIGO = '$Factura'";
$ResulNit = mysqli_fetch_array(mysqli_query($db, $SqlNit));
$sqlCliente = "SELECT * FROM Bodega.CLIENTE WHERE CLI_NIT = '".$ResulNit["DFA_NIT"]."'";
$resultCliente = mysqli_query($db, $sqlCliente);
while($rowC = mysqli_fetch_array($resultCliente))
{
    $Nombre  = $rowC["CLI_NOMBRE"];
    $Direccion  = utf8_decode($rowC["CLI_DIRECCION"]);
}
$NitRec = $ResulNit["DFA_NIT"];

$tbl2 .= <<<EOD
<table cellspacing="0" cellpadding="1" border="0">   
          <tr>  
            <td style="width:150px"><img src="logo.png"  width="90" height="50"></td>
            <td style="width:250px" align="center"><h3>Factura</h3></td> 
          </tr>     
</table> 
EOD;

$TablaEncabezado = <<<EOD
<table cellspacing="2" cellpadding="1" border="0">
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;">ASOCIACIÓN PARA EL CRECIMIENTO EDUCATIVO REG. COOPERATIVO Y APOYO</td>
    <td align="left" style="font-size: 8px; width: 200px;"> </td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;">TURÍSTICO DE ESQUIPULAS</td>
    <td align="left" style="font-size: 8px; width: 200px;">NÚMERO DE AUTORIZACIÓN </td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;">Nit Emisor: 92066097</td>
    <td align="left" style="font-size: 8px; width: 200px;">$DTE </td> 
    </tr>
     <tr>
    <td align="left" style="font-size: 9px; width: 400px;">PARQUE CHATUN</td>
    <td align="left" style="font-size: 8px; width: 200px;">Serie: $Serie Número de DTE: $Numero </td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;">KILOMETRO 226.5 CARRETERA DE ASFALTADA HACIA FRONTERA DE HONDURAS</td>
    <td align="left" style="font-size: 8px; width: 200px;">Número de Acceso:</td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;"> </td>
    <td align="left" style="font-size: 7.5px; width: 200px;">Fecha y hora de emisión: $Fecha</td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;">NIT Receptor: $NitRec</td>
    <td align="left" style="font-size: 7.5px; width: 200px;">Fecha y hora de certificación: $FechaCert</td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;">Nombre Receptor: $Nombre</td>
    <td align="left" style="font-size: 8px; width: 200px;">Moneda: GTQ</td> 
    </tr>
EOD;

 
$TablaProducto = <<<EOD
<table border="1">
    <tr style="background-color:#E1E4E1">
        <td align="left" style="font-size: 8px; width: 50px;"><b>#No.</b></td>
        <td align="left" style="font-size: 8px; width: 50px;"><b>B/S</b></td>
        <td align="left" style="font-size: 8px; width: 70px;"><b>Cantidad</b></td> 
        <td align="left" style="font-size: 8px; width: 80px;"><b>Descripción</b></td>
        <td align="left" style="font-size: 8px; width: 70px;"><b>P. Unitario con IVA Q</b></td>
        <td align="left" style="font-size: 8px; width: 70px;"><b>Descuento (Q)</b></td>
        <td align="left" style="font-size: 8px; width: 70px;"><b>Total (Q)</b></td> 
        <td align="left" style="font-size: 8px; width: 70px;"><b>Impuestos</b></td> 
    </tr>
EOD;

$sqlD = "SELECT DFA_CANTIDAD, DFA_DESCRIPCION, DFA_PRECIO, DFA_SUBTOTAL, DFA_TIPO FROM Contabilidad.DETALLE_FACTURA_ADMINISTRATIVA 
WHERE TRA_CODIGO = '$Factura'";
$resultD = mysqli_query($db, $sqlD);
$Cont = 1;
while($rowD = mysqli_fetch_array($resultD))
{

    $Cantidad  = number_format($rowD["DFA_CANTIDAD"], 0, '.', ',');
    $NombreProd  = $rowD["DFA_DESCRIPCION"];
    $PrecioUnitario  = number_format($rowD["DFA_PRECIO"], 2, '.', ','); 
    $Subtotal  = number_format($rowD["DFA_SUBTOTAL"], 2, '.', ',');
    $Iva = number_format(($rowD["DFA_SUBTOTAL"]/1.12)*0.12,2);
    $Tipo = $rowD["DFA_TIPO"];
    if ($Tipo=='B') {
       $TipoD = "Bien";
    }
    else
    {
        $TipoD = "Servicio";
    }
    
    $TablaProducto .= <<<EOD
    <tr>
    <td align="left" style="font-size: 8px; width: 50px;">$Cont </td> 
    <td align="left" style="font-size: 8px; width: 50px;">$TipoD </td> 
    <td align="left" style="font-size: 8px; width: 70px;">$Cantidad</td>
    <td align="left" style="font-size: 8px; width: 80px;">$NombreProd</td>
    <td align="left" style="font-size: 8px; width: 70px;">Q.$PrecioUnitario</td> 
    <td align="left" style="font-size: 8px; width: 70px;">Q.0.00 </td>
    <td align="left" style="font-size: 8px; width: 70px;">Q.$Subtotal</td>
    <td align="left" style="font-size: 8px; width: 70px;">IVA: $Iva</td>
    </tr>
EOD;
    $TotalT += $rowD["DFA_SUBTOTAL"];
    $TotalI += ($rowD["DFA_SUBTOTAL"]/1.12)*0.12;
    $Cont++;
}
 
$TotalT = number_format($TotalT, 2, '.', ',');
$TotalI = number_format($TotalI, 2, '.', ',');

$TablaProducto .= <<<EOD
    <tr>
        <td align="left" style="font-size: 8px; width: 50px;"> </td>
        <td align="left" style="font-size: 8px; width: 50px;"> </td>
        <td align="left" style="font-size: 8px; width: 70px;"> </td>
        <td align="left" style="font-size: 8px; width: 80px;"><b>Totales</b></td>
        <td align="righ" style="font-size: 8px width: 70px;"> </td>
        <td align="righ" style="font-size: 8px width: 70px;"> </td>
        <td align="left" style="font-size: 8px width: 70px; ">Q. $TotalT</td>
        <td align="left" style="font-size: 8px width: 70px; ">Q. $TotalI</td>
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
$pdf = new MYPDF("P","mm","letter", TRUE, 'UTF-8', FALSE);
// Add a page
$pdf->AddPage();
$pdf->SetMargins(10,0,10, true);
$pdf->SetFont('helvetica', '', 14);
$pdf->writeHTML($tbl2,1,0,0,0,'C');
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($TablaEncabezado,0,0,0,0,'J'); 
$tbl1 = "___________________________________________________________________________________________________ <br>";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$pdf->writeHTML($TablaProducto,0,0,0,0,'J'); 
$pdf->writeHTML($TablaComplemento,0,0,0,0,'J'); 
$pdf->SetFont('helvetica', '', 10);
$tbl1 = " <br> <br>***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$tbl1 = "Datos del Certificador";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$tbl1 = "INFILE, S.A. NIT: 12521337";
$pdf->writeHTML($tbl1,1,0,0,0,'L');  
$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'L'); 
// force print dialog
$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();

?>