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
$DetalleCorte = mysqli_query($db, "SELECT a.CH_NoEfectivo, a.CH_Efectivo, a.CH_ObservacionesEfectivo, a.CH_NoCheque,
a.CH_Cheque, a.CH_ObservacionesCheque, a.CH_NoDeposito, a.CH_Deposito, a.CH_ObservacionesDeposito,
a.CH_NoTarjeta, a.CH_Tarjeta, a.CH_ObservacionesTarjeta, a.CH_Total, a.CH_FacturaDel,
a.CH_FacturaAl, a.CH_TotalFac  FROM Taquilla.CORTE_HOTEL a WHERE a.CH_Id = $IdCorte");
$Det = mysqli_fetch_array($DetalleCorte);
$Colaborador = saber_nombre_asociado_orden($Username);
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
 $TotalCobrar = mysqli_fetch_array(mysqli_query($db, "SELECT a.H_CODIGO, b.H_NOMBRE, SUM(a.IH_ADULTOS) AS ADULTOS, SUM(a.IH_NINOS) AS NINOS 
          FROM Taquilla.INGRESO_HOTEL a
          INNER JOIN Taquilla.HOTEL b ON a.H_CODIGO = b.H_CODIGO
          WHERE a.IH_VALE > 0 AND NOT EXISTS (SELECT *FROM Taquilla.DETALLE_VALE_FACTURA c 
          where a.IH_VALE = c.DVF_Vale AND a.H_CODIGO = c.DVF_Hotel)
            "));
$PrecioAdulto = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 1"));
$PrecioNino = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 2"));
            $totalEntrada =   number_format(($TotalCobrar[ADULTOS]*$PrecioAdulto["Precio"])+($TotalCobrar[NINOS]*$PrecioNino["Precio"]),2);
$Tickets = mysqli_query($db, "SELECT a.H_CODIGO, b.H_NOMBRE, SUM(a.IH_ADULTOS) AS ADULTOS, SUM(a.IH_NINOS) AS NINOS 
                      FROM Taquilla.INGRESO_HOTEL a
                      INNER JOIN Taquilla.HOTEL b ON a.H_CODIGO = b.H_CODIGO
                      WHERE a.IH_VALE > 0 AND NOT EXISTS (SELECT *FROM Taquilla.DETALLE_VALE_FACTURA c 
                      where a.IH_VALE = c.DVF_Vale AND a.H_CODIGO = c.DVF_Hotel)
                      GROUP BY a.H_CODIGO
                      ");
 while ($Row = mysqli_fetch_array($Tickets)) 
 {
  $total =   number_format(($Row["ADULTOS"]*$PrecioAdulto["Precio"])+($Row["NINOS"]*$PrecioNino["Precio"]),2);
$tbl .= <<<EOD
 <tr>
  <td width="100px">$Contador</td>
  <td width="100px">$Row[H_NOMBRE]</td>
  <td width="100px" align="center">$Row[ADULTOS] </td>
  <td width="100px" align="center">$Row[NINOS]</td>
  <td width="100px" align="center">Q. $total</td>      
 </tr>
EOD;
$Contador++; 
$totalAdultos += $Row[ADULTOS];
$totalNinos += $Row[NINOS];
$totalHotel += $total;
 }
 $totalHotel = number_format($totalHotel,2);
 $totalAdulto = number_format($totalAdulto,2);
 $totalNino = number_format($totalNino,2);
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
              <td width="68px" align="center">$TotalCobrar[ADULTOS]</td>
              <td width="68px" align="center">$TotalCobrar[NINOS]</td>
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
 