<?php
ob_start();
session_start();
include("conex_pdf.php"); 
require("tcpdf/tcpdf.php"); 
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php"); 
include("../../../../Script/funciones.php");  

$Username = $_SESSION["iduser"];
$fechaHoy = date('d-m-Y');
$mesObtenido = $_GET['mes'];
$fechaInicial = $_GET["fechaInicial"];
$fechaFinal = $_GET["fechaFinal"]; 
$IdCorte = $_GET["Id"];
$DetalleCorte = mysqli_query($db, "SELECT a.CH_RecibeCorte, a.CH_NoEfectivo, a.CH_Efectivo, a.CH_ObservacionesEfectivo, a.CH_NoCheque,
a.CH_Cheque, a.CH_ObservacionesCheque, a.CH_NoDeposito, a.CH_Deposito, a.CH_ObservacionesDeposito,
a.CH_NoTarjeta, a.CH_Tarjeta, a.CH_ObservacionesTarjeta, a.CH_Total, a.CH_FacturaDel,
a.CH_FacturaAl, a.CH_TotalFac  FROM Taquilla.CORTE_HOTEL a WHERE a.CH_Id = $IdCorte");
$Det = mysqli_fetch_array($DetalleCorte);
$Colaborador = saber_nombre_asociado_orden($Username);
$Recibe = saber_nombre_asociado_orden($Det["CH_RecibeCorte"]);
GLOBAL $fecha;
$fecha = date("d-m-Y");
GLOBAL $correlativo;
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo 
    }

    public function Footer() {
    }
}


$Contador = count($StringExplotado);

$StringExplotado = explode(" ", $EspecificarIngreso);

$NuevoStringIngreso = '';

for($x = 1; $x < $Contador; $x++)
{
    if(5 % $x == 0)
    {
        $NuevoStringIngreso = $NuevoStringIngreso."\n";
    }
    else
    {
        $NuevoStringIngreso = $StringExplotado[$x].' '.$NuevoStringIngreso;
    }
}

$pdf = new MYPDF("L","mm","letter", TRUE, 'UTF-8', FALSE);

$pdf->AddPage();
$pdf->SetLineWidth(.3); 
$pdf->SetDrawColor(0, 0, 0); 
$pdf->SetFont('helvetica',10);
$pdf->SetFillColor(255,255,255);   
$tbl2 .= <<<EOD
<table cellspacing="0" cellpadding="1" border="0">   
          <tr>  
            <td style="width:150px"> </td>
            <td style="width:80px" align="left">Fecha:</td>
            <td style="width:80px" align="left">$fechaHoy</td>
          </tr>
          <tr>
          <td style="width:150px"><img src="logo.png"  width="150" height="100"></td>
          <td style="width:80px" align="left"><br><br>Facturas<br>Del<br>$Det[CH_FacturaDel] </td>
          <td style="width:80px" align="left"><br><br>Serie A<br>Al<br>$Det[CH_FacturaAl] </td>
          <td style="width:80px" align="left"><br><br><br>Total<br>$Det[CH_TotalFac] </td>
          </tr>
</table> 
EOD;
$pdf->writeHTML($tbl2, true, false, false, false, '');  
 $pdf->SetFont('helvetica',12);
$tbl .= <<<EOD
 
<table border="1">
<thead> 
  <tr  > 
    <th width="730px" align="center">DETALLE DEL CORTE</th> 
  </tr>
  <tr style="background-color:#98FF98"> 
    <th width="380px" align="center">DETALLE DE CORTE VALES</th>
    <th width="350px" align="center">DETALLE CORTE TICKETS</th> 
  </tr>
  <tr> 
    <th width="80px" class="text-center">Fecha</th>
    <th width="50px" class="text-center">No. Factura</th> 
    <th width="100px">NOMBRE</th>
    <th width="50px">DEL</th>
    <th width="50px">AL</th>
    <th width="50px">Total Vales</th>
    <th width="70px">TICKET ADULTO</th>
    <th width="70px">TOTAL Q.</th>
    <th width="70px">TICKET NIÑO</th>
    <th width="70px">TOTAL Q.</th>
    <th width="70px">Monto</th>
  </tr>
</thead>
<tbody> 
EOD;
$Detalle = mysqli_query($db, "SELECT b.H_NOMBRE, a.DC_Del, a.DC_Al, a.DC_Total, a.DC_Adultos, a.DC_TotalAdulto, a.DC_Ninos, a.DC_Factura,
a.DC_TotalNino, a.DC_TotalMonto 
FROM Taquilla.DETALLE_CORTE a 
INNER JOIN Taquilla.HOTEL b ON b.H_CODIGO = a.H_CODIGO
WHERE a.CH_Id = $IdCorte AND a.DC_Estado = 1 ORDER BY a.DC_Id ASC");
 while ($Row = mysqli_fetch_array($Detalle)) 
 {
$tbl .= <<<EOD
 <tr>
  <td width="80px">$fechaHoy</td> 
  <td width="50px">$Row[DC_Factura] </td>
  <td width="100px" align="center">$Row[H_NOMBRE] </td>
  <td width="50px" align="center">$Row[DC_Del]</td>
  <td width="50px" align="center">$Row[DC_Al]</td>
  <td width="50px" align="center">$Row[DC_Total]</td>   
  <td width="70px" align="center">$Row[DC_Adultos]</td>  
  <td width="70px" align="center">$Row[DC_TotalAdulto]</td>  
  <td width="70px" align="center">$Row[DC_Ninos]</td>       
  <td width="70px" align="center">$Row[DC_TotalNino]</td>  
  <td width="70px" align="center">$Row[DC_TotalMonto]</td>   
   </tr>
EOD;
 $totalVales += $Row['DC_Total'];
 $Adulto += $Row['DC_Adultos'];
 $totalAdulto += $Row['DC_TotalAdulto'];
 $Nino += $Row['DC_Ninos'];
 $totalNino += $Row['DC_TotalNino']; 
 $totalHotel += $Row['DC_TotalMonto'];
 }
 $totalHotel = number_format($totalHotel,2);
 $totalAdulto = number_format($totalAdulto,2);
 $totalNino = number_format($totalNino,2);
 $tbl .= <<<EOD
<tr>
  <td width="80px">Total</td>
  <td width="50px"></td>
  <td width="100px"></td>
  <td width="50px"></td>
  <td width="50px"></td> 
  <td width="50px" align="center">$totalVales  </td> 
  <td width="70px" align="center">$Adulto  </td>
  <td width="70px" align="center">Q. $totalAdulto  </td>  
  <td width="70px" align="center">$Nino  </td>   
  <td width="70px" align="center">Q. $totalNino  </td> 
  <td width="70px" align="center">Q. $totalHotel </td>
</tr>
</tbody>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->Ln(10);
$tbl1 .= <<<EOD
<table border="1">
<thead> 
  <tr> 
    <th width="100px">Forma de Pago</th>
    <th width="50px">No.</th>
    <th width="100px">Cantidad</th>
    <th width="100px">Observaciones</th> 
  </tr>
</thead>
<tbody> 
EOD;
$DetalleCorte2 = mysqli_query($db, "SELECT a.CH_NoEfectivo, a.CH_Efectivo, a.CH_ObservacionesEfectivo, a.CH_NoCheque,
a.CH_Cheque, a.CH_ObservacionesCheque, a.CH_NoDeposito, a.CH_Deposito, a.CH_ObservacionesDeposito,
a.CH_NoTarjeta, a.CH_Tarjeta, a.CH_ObservacionesTarjeta, a.CH_Total, a.CH_FacturaDel,
a.CH_FacturaAl, a.CH_TotalFac  FROM Taquilla.CORTE_HOTEL a WHERE a.CH_Id = $IdCorte");
$RowDet = mysqli_fetch_array($DetalleCorte2);
$tbl1 .= <<<EOD
 <tr>
    <td width="100px">EFECTIVO</td>
    <td width="50px">$RowDet[CH_NoEfectivo]</td>
    <td width="100px">Q. $RowDet[CH_Efectivo]</td>
    <td width="100px">$RowDet[CH_ObservacionesEfectivo]</td>
 </tr>
  <tr>
    <td width="100px">CHEQUE</td>
    <td width="50px">$RowDet[CH_NoCheque]</td>
    <td width="100px">Q. $RowDet[CH_Cheque]</td>
    <td width="100px">$RowDet[CH_ObservacionesCheque]</td>
 </tr>
  <tr>
    <td width="100px">DEPOSITO</td>
    <td width="50px">$RowDet[CH_NoDeposito]</td>
    <td width="100px">Q. $RowDet[CH_Deposito]</td>
    <td width="100px">$RowDet[CH_ObservacionesDeposito]</td>
 </tr>
  <tr>
    <td width="100px">TARJETAS</td>
    <td width="50px">$RowDet[CH_NoTarjeta]</td>
    <td width="100px">Q. $RowDet[CH_Tarjeta]</td>
    <td width="100px">$RowDet[CH_ObservacionesTarjeta]</td>
 </tr>
  <tr>
    <td width="150px"><b>TOTAL DEL DÍA</b></td> 
    <td width="100px">Q. $RowDet[CH_Total]</td>
    <td width="100px"> </td>
 </tr> 
</tbody>
</table>
EOD;
$pdf->writeHTML($tbl1, true, false, false, false, '');
$pdf->Ln(10);
$tbl3 .= <<<EOD
<table cellspacing="0" cellpadding="1" border="0">   
          <tr>  
            <td style="width:350px" align="center">__________________________________</td> 
            <td style="width:350px" align="center">__________________________________ </td> 
          </tr>
          <tr>  
            <td style="width:350px" align="center">Entregado por</td> 
            <td style="width:350px" align="center">Recibido por </td> 
          </tr>
          <tr>  
            <td style="width:350px" align="center">$Colaborador</td> 
            <td style="width:350px" align="center">$Recibe</td> 
          </tr>
           
</table> 
EOD;
$pdf->writeHTML($tbl3, true, false, false, false, '');  

$pdf->Ln(10);
ob_clean();
$pdf->Output();
$pdf->ezStream(); 
?>
 