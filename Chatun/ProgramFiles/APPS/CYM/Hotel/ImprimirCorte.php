<?php
ob_start();
session_start();
include("../../../../Script/conex.php");
include("../../../../libs/tcpdf/tcpdf.php");
include("../../../../Script/funciones.php");  

$Username = $_SESSION["iduser"];
$fechaHoy = date('d-m-Y'); 
$IdCorte = $_GET["Id"]; 
$DetalleCorte = mysqli_query($db, "SELECT DATE(a.CH_Fecha) AS Fecha, a.CH_RecibeCorte, a.CH_NoEfectivo, a.CH_Efectivo, a.CH_ObservacionesEfectivo, a.CH_NoCheque,
a.CH_Cheque, a.CH_ObservacionesCheque, a.CH_NoDeposito, a.CH_Deposito, a.CH_ObservacionesDeposito,
a.CH_NoTarjeta, a.CH_Tarjeta, a.CH_ObservacionesTarjeta, a.CH_Total, a.CH_FacturaDel,
a.CH_FacturaAl, a.CH_TotalFac  FROM Taquilla.CORTE_HOTEL a WHERE a.CH_Id = $IdCorte");
$Det = mysqli_fetch_array($DetalleCorte);
$fechaCorte = cambio_fecha($Det["Fecha"]);
$Colaborador = mysqli_fetch_array(mysqli_query($db, "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido FROM info_colaboradores.Vista_Colaboradores_Nueva
a WHERE a.cif = $Username"));
$Colaborador = $Colaborador["primer_nombre"]." ".$Colaborador["segundo_nombre"]." ".$Colaborador["primer_apellido"]." ".$Colaborador["segundo_apellido"];
$Recibe = mysqli_fetch_array(mysqli_query($db, "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido FROM info_colaboradores.Vista_Colaboradores_Nueva
a WHERE a.cif = $Det[CH_RecibeCorte]"));
$Recibe = $Recibe["primer_nombre"]." ".$Recibe["segundo_nombre"]." ".$Recibe["primer_apellido"]." ".$Recibe["segundo_apellido"];
GLOBAL $fecha;
$fecha = date("d-m-Y");
GLOBAL $correlativo;
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
    }
}

 

//***********************************************************
//***********************************************************
$pdf = new MYPDF("L","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,45,15);
// Add a page
$pdf->AddPage();   
$tbl2 .= <<<EOD
<table cellspacing="0" cellpadding="1" border="0">   
          <tr>  
            <td style="width:150px"><img src="logo.png"  width="150" height="80"></td>
            <td style="width:80px" align="left"><h1>Fecha:</h1></td>
            <td style="width:200px" align="left"><h1>$fechaCorte</h1></td>
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
    <th width="50px">TICKET ADULTO</th>
    <th width="50px">TOTAL Q.</th>
    <th width="50px">TICKET ADULTO MAYOR</th>
    <th width="50px">TOTAL Q.</th>
    <th width="50px">TICKET NIÑO</th>
    <th width="50px">TOTAL Q.</th>
    <th width="50px">Monto</th>
  </tr>
</thead>
<tbody> 
EOD;
$Detalle = mysqli_query($db, "SELECT b.H_NOMBRE, a.DC_Del, a.DC_Al, a.DC_Total, a.DC_Adultos, a.DC_TotalAdulto, a.DC_Ninos, a.DC_Factura,
a.DC_TotalNino, a.DC_TotalMonto, a.DC_AdultosM, a.DC_TotalAdultoM
FROM Taquilla.DETALLE_CORTE a 
INNER JOIN Taquilla.HOTEL b ON b.H_CODIGO = a.H_CODIGO
WHERE a.CH_Id = $IdCorte AND a.DC_Estado = 1 ORDER BY a.DC_Id ASC");
 while ($Row = mysqli_fetch_array($Detalle)) 
 {
$tbl .= <<<EOD
 <tr>
  <td width="80px">$fechaCorte</td> 
  <td width="50px">$Row[DC_Factura] </td>
  <td width="100px" align="center">$Row[H_NOMBRE] </td>
  <td width="50px" align="center">$Row[DC_Del]</td>
  <td width="50px" align="center">$Row[DC_Al]</td>
  <td width="50px" align="center">$Row[DC_Total]</td>   
  <td width="50px" align="center">$Row[DC_Adultos]</td>  
  <td width="50px" align="center">$Row[DC_TotalAdulto]</td> 
  <td width="50px" align="center">$Row[DC_AdultosM]</td>  
  <td width="50px" align="center">$Row[DC_TotalAdultoM]</td>  
  <td width="50px" align="center">$Row[DC_Ninos]</td>       
  <td width="50px" align="center">$Row[DC_TotalNino]</td>  
  <td width="50px" align="center">$Row[DC_TotalMonto]</td>   
   </tr>
EOD;
 $totalVales += $Row['DC_Total'];
 $Adulto += $Row['DC_Adultos'];
 $totalAdulto += $Row['DC_TotalAdulto'];
 $AdultoM += $Row['DC_AdultosM'];
 $totalAdultoM += $Row['DC_TotalAdultoM'];
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
  <td width="50px" align="center">$Adulto  </td>
  <td width="50px" align="center">Q. $totalAdulto  </td>  
  <td width="50px" align="center">$AdultoM  </td>
  <td width="50px" align="center">Q. $totalAdultoM  </td>
  <td width="50px" align="center">$Nino  </td>   
  <td width="50px" align="center">Q. $totalNino  </td> 
  <td width="50px" align="center">Q. $totalHotel </td>
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
 
?>
 