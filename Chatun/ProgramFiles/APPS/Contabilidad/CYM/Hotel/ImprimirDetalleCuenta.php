<?php
ob_start();
session_start();
include("../../../../libs/tcpdf/tcpdf.php");
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php"); 
include("../../../../Script/funciones.php");  

$Username = $_SESSION["iduser"];
$fechaHoy = date('d-m-Y'); 
$Colaborador = saber_nombre_asociado_orden($Username);
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
            <td style="width:150px"><img src="logo.png"  width="150" height="100"></td>
            <td style="width:100px" align="left"><h2>Fecha:</h2></td>
            <td style="width:100px" align="left"><h2>$fechaHoy</h2></td>
          </tr>
</table> 
EOD;
$pdf->writeHTML($tbl2, true, false, false, false, '');  
 $pdf->SetFont('helvetica',12);
$tbl .= <<<EOD
<table border="0">
<tr>
   <td width="500px">
<table border="1">
<thead>  
  <tr>  
    <th width="500px" align="center">DETALLE DE CUENTAS POR COBRAR</th> 
  </tr>
  <tr> 
    <th  width="100px">No.</th>
    <th  width="100px">HOTELES SOCIOS VENDEDORES</th>
    <th  width="100px" align="center">ADULTO</th>
    <th  width="100px" align="center">NIÑO</th>
    <th  width="100px" align="center">CUENTA POR COBRAR Q.<br> TOTAL</th>  
  </tr>
</thead>
<tbody> 
EOD;
$Contador = 1;
 $TotalCobrar = mysqli_fetch_array(mysqli_query($db, "SELECT a.H_CODIGO, b.H_NOMBRE, SUM(a.IH_ADULTOS) AS ADULTOS, SUM(a.IH_NINOS) AS NINOS, SUM(a.IH_TOTAL_ADULTO) AS TotalAdulto, SUM(a.IH_TOTAL_NINO) AS TotalNino
          FROM Taquilla.INGRESO_HOTEL a
          INNER JOIN Taquilla.HOTEL b ON a.H_CODIGO = b.H_CODIGO
          WHERE a.IH_VALE > 0 AND NOT EXISTS (SELECT *FROM Taquilla.DETALLE_VALE_FACTURA c 
          where a.IH_VALE = c.DVF_Vale AND a.H_CODIGO = c.DVF_Hotel)
            ", $db));
 
$totalEntrada =   number_format($TotalCobrar["TotalNino"]+$TotalCobrar["TotalAdulto"],2);
$Tickets = mysqli_query($db, "SELECT a.H_CODIGO, b.H_NOMBRE, SUM(a.IH_ADULTOS) AS ADULTOS, SUM(a.IH_NINOS) AS NINOS, SUM(a.IH_TOTAL_ADULTO) AS TotalAdulto, SUM(a.IH_TOTAL_NINO) AS TotalNino
                      FROM Taquilla.INGRESO_HOTEL a
                      INNER JOIN Taquilla.HOTEL b ON a.H_CODIGO = b.H_CODIGO
                      WHERE a.IH_VALE > 0 AND NOT EXISTS (SELECT *FROM Taquilla.DETALLE_VALE_FACTURA c 
                      where a.IH_VALE = c.DVF_Vale AND a.H_CODIGO = c.DVF_Hotel)
                      GROUP BY a.H_CODIGO
                      ", $db);
 while ($Row = mysqli_fetch_array($Tickets)) 
 {
  $total =   number_format($Row["TotalNino"]+$Row["TotalAdulto"],2);
  $Nombre = $Row['H_NOMBRE'];
  $Ad = $Row['ADULTOS'];
  $Nino = $Row['NINOS'];
$tbl .= <<<EOD
 <tr>
  <td width="100px">$Contador</td>
  <td width="100px">$Nombre</td>
  <td width="100px" align="center">$Ad</td>
  <td width="100px" align="center">$Nino</td>
  <td width="100px" align="center">Q. $total</td>      
 </tr>
EOD;
$Contador++; 
$totalAdultos += $Row['ADULTOS'];
$totalNinos += $Row['NINOS'];
$totalHotel += $total;
 }
 $totalHotel = number_format($totalHotel,2);
 $totalAdulto = number_format($totalAdulto,2);
 $totalNino = number_format($totalNino,2);
 $TotalCobrarA = $TotalCobrar['ADULTOS'];
 $TotalCobrarN = $TotalCobrar['NINOS'];
 $tbl .= <<<EOD
<tr>
  <td>Total</td>
  <td></td>
  <td align="center">$totalAdultos </td> 
  <td align="center">$totalNinos </td> 
  <td align="center">Q.$totalHotel</td>
</tr>
</tbody>
</table>
</td> 
   <td width="205px">
    <table border="1">  
           <thead>
           <tr>
             <td style="width:205px" align="center">RESUMEN VENTAS POR COBRAR</td> 
          </tr>
          <tr>
             <td style="width:205px" align="center">Fecha: $fechaHoy</td> 
          </tr>
          <tr> 
              <th width="68px" align="center">ADULTO</th>
              <th width="68px" align="center">NIÑO</th>
              <th width="68px" align="center">TOTAL</th>
            </tr>
          </thead>
          <tbody> 
            <tr>
              <td width="68px" align="center">$TotalCobrarA</td>
              <td width="68px" align="center">$TotalCobrarN</td>
              <td width="68px" align="center">Q. $totalEntrada</td>
            </tr>
          </tbody>
  </table>  
   </td>
</tr> 
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
 
ob_clean();
$pdf->Output();
$pdf->ezStream(); 
?>
 