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
 
$sql = "SELECT A.TRA_CONCEPTO, A.TRA_TABLA_FACTURA_NOTA_CREDITO, A.TRA_FACTURA_NOTA_CREDITO, A.TRA_SERIE, A.TRA_DTE, A.TRA_CAE, A.TRA_FECHA_TRANS, A.TRA_HORA, A.TRA_CODIGO, A.TRA_FECHA_CERTIFICACION FROM Contabilidad.TRANSACCION A
WHERE A.TRA_CODIGO = '$Factura'";
$result = mysqli_query($db, $sql);
while($row = mysqli_fetch_array($result))
{
    $Serie  = $row["TRA_SERIE"];
    $Numero  = $row["F_NUMERO"];  
    $Fecha = cambio_fecha($row["TRA_FECHA_TRANS"]);
    $DTE = $row["TRA_DTE"];
    $CAE = $row["TRA_CAE"];
    $Hora = $row["TRA_HORA"];
    $Certi = $row["TRA_FECHA_CERTIFICACION"];
    $Tabla = $row["TRA_TABLA_FACTURA_NOTA_CREDITO"];
    $FacNota = $row["TRA_FACTURA_NOTA_CREDITO"];
    $Motivo = $row["TRA_CONCEPTO"]; 
}

$sql1 = "SELECT  A.CLI_NIT, A.F_SERIE, A.F_DTE, A.F_CAE, A.F_FECHA_TRANS FROM Bodega.$Tabla A
WHERE A.F_CODIGO = '$FacNota'";
$result1 = mysqli_query($db, $sql1);
while($row1 = mysqli_fetch_array($result1))
{
    $SerieN  = $row1["F_SERIE"];
    $NumeroN  = $row1["F_CAE"];  
    $FechaN = cambio_fecha($row1["F_FECHA_TRANS"]);
    $DTEN = $row1["F_DTE"];
    $CAEN = $row1["F_CAE"]; 
    $NitRec = $row1["CLI_NIT"]; 
}

if ($NitRec=='CF') {
    $NombreNit = "Consumidor Final";
}
else
{
    $QueryClie = mysqli_fetch_array(mysqli_query($db, "SELECT a.CLI_NOMBRE FROM Bodega.CLIENTE a WHERE a.CLI_NIT = $NitRec"));
    $NombreNit = $QueryClie["CLI_NOMBRE"];
}

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
    <td align="left" style="font-size: 8px; width: 200px;"> </td> 
    </tr>
     <tr>
    <td align="left" style="font-size: 9px; width: 400px;">PARQUE CHATUN</td>
    <td align="left" style="font-size: 8px; width: 200px;">Serie: $CAE Número de DTE: $DTE</td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;">KILOMETRO 226.5 CARRETERA DE ASFALTADA HACIA FRONTERA DE HONDURAS</td>
    <td align="left" style="font-size: 8px; width: 200px;">Número de Acceso:</td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;"> </td>
    <td align="left" style="font-size: 8px; width: 200px;">Fecha y hora de emisión: $Fecha $Hora</td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;">NIT Receptor $NitRec</td>
    <td align="left" style="font-size: 8px; width: 200px;">Fecha y hora de certificación: $Certi</td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 400px;">Nombre Recepto: $NombreNit</td>
    <td align="left" style="font-size: 8px; width: 200px;">Moneda: GTQ</td> 
    </tr>
EOD;



$sqlCliente = "SELECT * FROM Bodega.CLIENTE WHERE CLI_NIT = '".$NIT."'";
$resultCliente = mysqli_query($db, $sqlCliente);
while($rowC = mysqli_fetch_array($resultCliente))
{
    $Nombre  = utf8_decode($rowC["CLI_NOMBRE"]);
    $Direccion  = utf8_decode($rowC["CLI_DIRECCION"]);
}

$TablaProducto = <<<EOD
<table border="1">
    <tr style="background-color:#E1E4E1">
        <td align="left" style="font-size: 8px; width: 50px;"><b>#No.</b></td>
        <td align="left" style="font-size: 8px; width: 50px;"><b>B/S</b></td>
        <td align="left" style="font-size: 8px; width: 70px;"><b>Cantidad</b></td> 
        <td align="left" style="font-size: 8px; width: 100px;"><b>Descripción</b></td>
        <td align="left" style="font-size: 8px; width: 70px;"><b>P. Unitario con IVA Q</b></td> 
        <td align="left" style="font-size: 8px; width: 70px;"><b>Total (Q)</b></td> 
        <td align="left" style="font-size: 8px; width: 70px;"><b>Impuestos</b></td> 
    </tr>
EOD;

$sqlD = "SELECT A.DNC_CANTIDAD, A.DNC_DESCRIPCION, A.DNC_PRECIO, A.DNC_SUBTOTAL FROM Contabilidad.DETALLE_NOTA_CREDITO A WHERE A.TRA_CODIGO = '$Factura'";
$resultD = mysqli_query($db, $sqlD);
$Cont = 1;
while($rowD = mysqli_fetch_array($resultD))
{

    $Cantidad  = number_format($rowD["DNC_CANTIDAD"], 0, '.', ',');
    $NombreProd  = $rowD["DNC_DESCRIPCION"];
    $PrecioUnitario  = number_format($rowD["DNC_PRECIO"], 2, '.', ','); 
    $Subtotal  = number_format($rowD["DNC_SUBTOTAL"], 2, '.', ',');
    $Iva = number_format(($rowD["DNC_SUBTOTAL"]/1.12)*0.12,2);
    $TablaProducto .= <<<EOD
    <tr>
    <td align="left" style="font-size: 8px; width: 50px;">$Cont</td> 
    <td align="left" style="font-size: 8px; width: 50px;">Bien</td> 
    <td align="left" style="font-size: 8px; width: 70px;">$Cantidad</td>
    <td align="left" style="font-size: 8px; width: 100px;">$NombreProd</td>
    <td align="left" style="font-size: 8px; width: 70px;">Q.$PrecioUnitario</td> 
    <td align="left" style="font-size: 8px; width: 70px;">Q.$Subtotal</td>
    <td align="left" style="font-size: 8px; width: 70px;">IVA: $Iva</td>
    </tr>
EOD;
$Cont++;
$TotalFactura += $rowD["DNC_SUBTOTAL"];
$TotalIVA += ($rowD["DNC_SUBTOTAL"]/1.12)*0.12;
}
 
$TotalFactura = number_format($TotalFactura, 2, '.', ',');
$TotalIVA = number_format($TotalIVA, 2, '.', ',');

$TablaProducto .= <<<EOD
    <tr>
        <td align="left" style="font-size: 8px; width: 50px;"> </td>
        <td align="left" style="font-size: 8px; width: 50px;"> </td>
        <td align="left" style="font-size: 8px; width: 70px;"> </td>
        <td align="left" style="font-size: 8px; width: 100px;"><b>Totales</b></td>
        <td align="righ" style="font-size: 8px width: 70px;"> </td>
        <td align="left" style="font-size: 8px width: 70px;">Q. $TotalFactura </td>
        <td align="left" style="font-size: 8px width: 70px; ">Q. $TotalIVA</td> 
    </tr>
EOD;
$TablaProducto .= <<<EOD
</table>
EOD;
 
$TablaComplemento = <<<EOD
<table cellspacing="2" cellpadding="1" border="1">
    <tr>
    <td align="left" style="font-size: 9px; width: 200px;">REFERENCIA DE NOTAS DE DÉBITO Y CRÉDITO</td>
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 100px;">Régimen:</td>
    <td align="left" style="font-size: 8px; width: 100px;">Régimen actual (FEL)</td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 8px; width: 100px;">Número de autorización:</td> 
    <td align="left" style="font-size: 8px; width: 100px;">$DTEN</td> 
    </tr>
    <tr>
    <td align="left" style="font-size: 9px; width: 100px;">Serie:</td>
    <td align="left" style="font-size: 8px; width: 100px;">$SerieN</td> 
    </tr>
     <tr>
    <td align="left" style="font-size: 9px; width: 100px;">Número:</td>
    <td align="left" style="font-size: 8px; width: 100px;">$CAEN</td> 
    </tr> 
    <tr>
    <td align="left" style="font-size: 9px; width: 100px;">Fecha de emisión:</td>
    <td align="left" style="font-size: 8px; width: 100px;">$FechaN</td> 
    </tr> 
    <tr>
    <td align="left" style="font-size: 9px; width: 100px;">Motivo del ajuste:</td>
    <td align="left" style="font-size: 8px; width: 100px;">$Motivo</td> 
    </tr> 
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
$tbl1 = "Nota de Crédito";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($TablaEncabezado,0,0,0,0,'J'); 
$tbl1 = "___________________________________________________________________________________________________ <br>";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$pdf->writeHTML($TablaProducto,0,0,0,0,'J');
$tbl1 = " <br> <br> ";
$pdf->writeHTML($tbl1,1,0,0,0,'L'); 
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