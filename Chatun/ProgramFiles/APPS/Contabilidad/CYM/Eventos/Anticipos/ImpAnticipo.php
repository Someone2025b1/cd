<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Usuar = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$User = $_SESSION["login"];

$Codigo = $_GET["Codigo"];

$sql = "SELECT * FROM Contabilidad.ANTICIPO_EVENTOS AS A  WHERE A.AE_CODIGO = '".$Codigo."'";
$result = mysqli_query($db,$sql);
while($row = mysqli_fetch_array($result))
{
    $Nit  = $row["CLI_NIT"];
    $Nombre  = $row["RD_USUARIO"];
    $Monto    = $row["AE_MONTO"];
    $Fecha    = date($row["AE_FECHA"]);
    $FechaEv  = date($row["AE_FECHA_EVENTO"]);
    $Usuario  = $row["AE_USER"];
    $TipoPago  = $row["AE_TIPOPAGO"];
    $Observaciones  = $row["AE_OBSERVACIONES"];
    $Boleta  = $row["AE_BOLETA"];
    
}

$sqlCliente = "SELECT * FROM Bodega.CLIENTE WHERE CLI_NIT = '".$Nit."'";
$resultCliente = mysqli_query($db, $sqlCliente);
while($rowC = mysqli_fetch_array($resultCliente))
{
    $Nombre  = utf8_decode($rowC["CLI_NOMBRE"]);
    $Direccion  = utf8_decode($rowC["CLI_DIRECCION"]);
}



$sqlRet = mysqli_query($db,"SELECT A.nombre 
FROM info_bbdd.usuarios AS A     
WHERE A.id_user = ".$Usuario); 
$rowret=mysqli_fetch_array($sqlRet);

$NombreRet=$rowret["nombre"];


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
    $Icono  = $_SERVER['DOCUMENT_ROOT']."/img/logoev.png"; 


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

$Transac .= <<<EOD
            <table border="0">  
                
                <tr style="font-size: 34px">
                    <td colspan="8" align="center"><img src="$Icono" width="250" ></td>
                </tr>   
            </table>
            EOD; 
$pdf->writeHTML($Transac,0,0,0,0,'J'); 

$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 25);
$tbl1 = "Parque Chatun";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', 'B', 35);
$tbl1 = "RECIBO DE CAJA";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "Número: ".$Codigo;
$pdf->writeHTML($tbl1,6,6,6,6,'R');
$tbl1 = "N.I.T.:     $Nit";
$pdf->writeHTML($tbl1,1,0,0,6,'L');
$tbl1 = "NOMBRE:     $Nombre";
$pdf->writeHTML($tbl1,1,0,0,6,'L');
$tbl1 = "DIRECCION:   $Direccion";
$pdf->writeHTML($tbl1,1,0,0,6,'L');
$tbl1 = "FECHA: $Fecha";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->writeHTML($TablaProducto,0,0,0,0,'J'); 
$tbl1 = "TIPO PAGO:   $Pago";
$pdf->writeHTML($tbl1,1,0,0,0,'J');
$pdf->SetFont('helvetica', '', 40);
$tbl1 = "MONTO: Q.".$Monto;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "Concepto: ".$Observaciones;
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$tbl1 = "FECHA EVENTO: $FechaEv";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');


$pdf->AddPage();
$pdf->SetMargins(5,0,10, true);
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$pdf->writeHTML($Transac,0,0,0,0,'J'); 

$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 25);
$tbl1 = "Parque Chatun";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', 'B', 35);
$tbl1 = "RECIBO DE CAJA";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "Número: ".$Codigo;
$pdf->writeHTML($tbl1,6,6,6,6,'R');
$tbl1 = "N.I.T.:     $Nit";
$pdf->writeHTML($tbl1,1,0,0,6,'L');
$tbl1 = "NOMBRE:     $Nombre";
$pdf->writeHTML($tbl1,1,0,0,6,'L');
$tbl1 = "DIRECCION:   $Direccion";
$pdf->writeHTML($tbl1,1,0,0,6,'L');
$tbl1 = "FECHA: $Fecha";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->writeHTML($TablaProducto,0,0,0,0,'J'); 
$tbl1 = "TIPO PAGO:   $Pago";
$pdf->writeHTML($tbl1,1,0,0,0,'J');
$pdf->SetFont('helvetica', '', 40);
$tbl1 = "MONTO: Q.".$Monto;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "Concepto: ".$Observaciones;
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$tbl1 = "FECHA EVENTO: $FechaEv";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();

?>