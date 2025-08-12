    <?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$GLOBALS["TipoCorte"] = $_POST["TipoCorte"];

$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$FilaNotasC = number_format($_POST["FilaNotasC"],2);
$TotalNotasEmitidas = $_POST["TotalNotasEmitidas"];
$FechaImp              = date('d-m-Y', strtotime($_POST["FechaImp"]));
$Fecha = $_POST["FechaImp"];
$Tipo = $_POST["Tipo"];
$QueryTasaCambioLempira = mysqli_query($db, "SELECT *
FROM Contabilidad.TASA_CAMBIO AS A
WHERE A.TC_MONEDA = 1");
$FilaTasaCambioLempira = mysqli_fetch_array($QueryTasaCambioLempira);

$QueryTasaCambioDolar = mysqli_query($db, "SELECT *
FROM Contabilidad.TASA_CAMBIO AS A
WHERE A.TC_MONEDA = 2");
$FilaTasaCambioDolar = mysqli_fetch_array($QueryTasaCambioDolar);

$TipoCambioLempira = number_format($FilaTasaCambioLempira["TC_TASA"], 2);
$TipoCambioDolar = number_format($FilaTasaCambioDolar["TC_TASA"], 2);

$Query = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."'";
                $Result = mysqli_query($db, $Query);
while($row = mysqli_fetch_array($Result))
{
    $FacturasEmitidasCorte = $row["FACTURAS_EMITIDAS"];
}

$QueryA = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_ESTADO = 2";
                $Result = mysqli_query($db, $QueryA);
while($rowA = mysqli_fetch_array($Result))
{
    $FacturasAnuladas = $rowA["FACTURAS_EMITIDAS"];
}

$Query1 = mysqli_fetch_array(mysqli_query($db, "SELECT a.Usuario, a.EfectivoQ, a.EfectivoD, a.EfectivoL, a.EfectivoNota, a.EfectivoDeb, a.EfectivoTotal, a.Credito, a.CreditoNota, a.CreditoDeb, a.CreditoTotal, a.Tarjeta, a.TarjetaNota, a.TarjetaDebito, a.TarjetaTotal, a.Deposito, a.DepositoNota, a.DepositoDeb, a.DepositoTotal, a.TotalDatos, a.TotalNotas, a.TotalNotasC, a.TotalIngresos, a.TotalFacturado, a.Sobrante, a.Faltante, a.TotalNotasEmitidas
FROM Bodega.CUADRE_CAJA a WHERE DATE(a.Fecha) = '$Fecha' and a.Tipo = $Tipo ORDER BY a.Hora ASC LIMIT 1"));
$EfectivoCorte = $Query1["EfectivoQ"];
$DolaresCorte = $Query1["EfectivoD"];
$LempirasCorte = $Query1["EfectivoL"];
$EfectivoQuetzalizado = $Query1["EfectivoTotal"];
$NotaCreditoEfectivo = $Query1["EfectivoNota"];
$NotaDebitoEfectivo = $Query1["EfectivoDeb"]; 
$CreditoCorte = $Query1["Credito"]; 
$NotaCreditoCredito = $Query1["CreditoNota"];
$NotaDebitoCredito = $Query1["CreditoDeb"];
$TotalCredito = $Query1["CreditoTotal"];
$TCCorte = $Query1["Tarjeta"]; 
$NotaCreditoTarjeta = $Query1["TarjetaNota"];
$NotaDebitoTarjeta = $Query1["TarjetaDebito"];
$TotalTarjetaCredito = $Query1["TarjetaTotal"];
$DepositosCorte = $Query1["Deposito"]; 
$NotaCreditoDeposito = $Query1["DepositoNota"];
$NotaDebitoDeposito = $Query1["DepositoDeb"];
$TotalDepositos = $Query1["DepositoTotal"];
$TotalDatosPreliminares = $Query1["TotalDatos"];
$TotalNotasCredito = $Query1["TotalNotasC"];
$TotalNotasDebito = $Query1["TotalNotas"];
$TotalIngresos = $Query1["TotalIngresos"];
$FacturadoCorte = $Query1["TotalFacturado"];
$User1 = $Query1["Usuario"];
$UsuarioNombre1 = saber_nombre_asociado_orden($Query1["Usuario"]);
$Query2 = mysqli_fetch_array(mysqli_query($db, "SELECT a.Contabiliza, a.Usuario, a.EfectivoQ, a.EfectivoD, a.EfectivoL, a.EfectivoNota, a.EfectivoDeb, a.EfectivoTotal, a.Credito, a.CreditoNota, a.CreditoDeb, a.CreditoTotal, a.Tarjeta, a.TarjetaNota, a.TarjetaDebito, a.TarjetaTotal, a.Deposito, a.DepositoNota, a.DepositoDeb, a.DepositoTotal, a.TotalDatos, a.TotalNotas, a.TotalNotasC, a.TotalIngresos, a.TotalFacturado, a.Sobrante, a.Faltante, a.TotalNotasEmitidas
FROM Bodega.CUADRE_CAJA a WHERE DATE(a.Fecha) = '$Fecha'  and a.Tipo = $Tipo ORDER BY a.Hora DESC LIMIT 1"));
$EfectivoCorte1 = $Query2["EfectivoQ"];
$DolaresCorte1 = $Query2["EfectivoD"];
$LempirasCorte1 = $Query2["EfectivoL"];
$EfectivoQuetzalizado1 = $Query2["EfectivoTotal"];
$NotaCreditoEfectivo1 = $Query2["EfectivoNota"];
$NotaDebitoEfectivo1 = $Query2["EfectivoDeb"]; 
$CreditoCorte1 = $Query2["Credito"]; 
$NotaCreditoCredito1 = $Query2["CreditoNota"];
$NotaDebitoCredito1 = $Query2["CreditoDeb"];
$TotalCredito1 = $Query2["CreditoTotal"];
$TCCorte1 = $Query2["Tarjeta"]; 
$NotaCreditoTarjeta1 = $Query2["TarjetaNota"];
$NotaDebitoTarjeta1 = $Query2["TarjetaDebito"];
$TotalTarjetaCredito1 = $Query2["TarjetaTotal"];
$DepositosCorte1 = $Query2["Deposito"]; 
$NotaCreditoDeposito1 = $Query2["DepositoNota"];
$NotaDebitoDeposito1 = $Query2["DepositoDeb"];
$TotalDepositos1 = $Query2["DepositoTotal"];
$TotalDatosPreliminares1 = $Query2["TotalDatos"];
$TotalNotasCredito1 = $Query2["TotalNotasC"];
$TotalNotasDebito1 = $Query2["TotalNotas"];
$TotalIngresos1 = $Query2["TotalIngresos"];
$FacturadoCorte1 = $Query2["TotalFacturado"];
$User2 = $Query2["Usuario"];
$UsuarioNombre2 = saber_nombre_asociado_orden($Query2["Usuario"]);
 
$TotalIngresosTotal = number_format($TotalIngresos + $TotalIngresos1,2);
$FacturadoCorteTotal = number_format($FacturadoCorte + $FacturadoCorte1,2); 
$Contabilidad = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(a.ACC_USUARIO_CONTABILIZA) as Cont FROM Bodega.CIERRE_DETALLE a 
INNER JOIN Bodega.APERTURA_CIERRE_CAJA b ON a.ACC_CODIGO = b.ACC_CODIGO
WHERE  b.ACC_FECHA = '$Fecha'
 "));
$Contabiliza = saber_nombre_asociado_orden($Contabilidad["Cont"]);
 

$Anulado1 = "SELECT SUM(F_TOTAL) AS FACTURAS_Anuladas FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_USUARIO = $Query1[Usuario] AND F_ESTADO = 2";
                $Result = mysqli_query($db, $Anulado1);
while($row1 = mysqli_fetch_array($Result))
{
    $FacturasAnuladas1 = $row1["FACTURAS_EMITIDAS"];
}

$FacA1 = number_format($FacturasAnuladas1,2);

$Anulado2 = "SELECT SUM(F_TOTAL) AS FACTURAS_Anuladas FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$Fecha."' AND F_USUARIO = $Query2[Usuario] AND F_ESTADO = 2";
                $Result = mysqli_query($db, $Anulado2);
while($row2 = mysqli_fetch_array($Result))
{
    $FacturasAnuladas2 = $row2["FACTURAS_EMITIDAS"];
}

$FacA2 = number_format($FacturasAnuladas2,2);

$FacturadoAnuladaTotal = number_format($FacturasAnuladas1 + $FacturasAnuladas2,2);
$EfectivoQuetzalizadoTot =  number_format($EfectivoQuetzalizado1 + $EfectivoQuetzalizado,2);
$CredTot =  number_format($CreditoCorte1 + $CreditoCorte,2);
$TarTot =  number_format($TCCorte1 + $TCCorte,2);
$DepTot =  number_format($DepositosCorte1 + $DepositosCorte,2);
//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = '../../../../../img/logo.png';
        $this->Image($image_file, 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 30);
        // Title
        $this->Cell(0,0,"CONTROL DE INGRESOS",0,1,'C');
        $this->Cell(0,0, $GLOBALS["TipoCorte"] ,0,1,'C');
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,45,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(0,0, "Generó: $Usuario",0,1,'R');
$pdf->Cell(0,0, "$FechaHora",0,1,'R');
$pdf->SetFont('Helvetica', '', 20);
$pdf->Cell(0,0, "",0,1,'R');
$pdf->SetFont('Helvetica', '', 10);


$tbl1 .= <<<EOD
<table border="1">
    <tr>
        <td colspan="8"><b>Fecha:</b> $FechaImp</td>
    </tr>
    <tr>
        <td colspan="8"><b>Facturas Emitidas:</b> $FacturasEmitidasCorte</td>
    </tr>
    <tr>
        <td colspan="8"><b>Facturas Anuladas:</b> $FacturasAnuladas</td>
    </tr>
    <tr>
        <td colspan="8"><b>Notas de Crédito Emitidas: </b> $TotalNotasEmitidas</td>
    </tr>
    <tr>
        <td colspan="8"><b>Notas de Débito Emitidas: </b> 0</td>
    </tr> 
    <tr>
        <td colspan="8"><b> Tipo de Cambio - Lempira: </b> $TipoCambioLempira</td>
    </tr>
    <tr>
        <td colspan="8"><b>Tipo de Cambio - Dólar: </b> $TipoCambioDolar</td>
    </tr> 
    <tr style="font-size: 8px">
        <td  width="40px"></td>
        <td width="169px" align="center"><b>Usuario $User1</b></td>
        <td width="169px" align="center"><b>Usuario $User2</b></td> 
        <td width="49px" align="center" rowspan="2" valign="middle"><b>Notas de Crédito</b></td>
        <td width="49px" align="center" rowspan="2" valign="middle"><b>Notas De Débito</b></td>
        <td width="50px" align="center" rowspan="2" valign="middle"><b>TOTAL</b></td>
    </tr>
    <tr style="font-size: 8px">
        <td width="40px"></td>
        <td width="40px" align="center"><b>Q</b></td>
        <td width="40px" align="center"><b>D</b></td>
        <td width="40px" align="center"><b>L</b></td>
        <td width="49px" align="center"><b>Tot. Q</b></td>
        <td width="40px" align="center"><b>Q</b></td>
        <td width="40px" align="center"><b>D</b></td>
        <td width="40px" align="center"><b>L</b></td>
        <td width="49px" align="center"><b>Tot. Q</b></td>
    </tr>
    <tr style="font-size: 8px">
        <td width="40px" rowspan="2">Efectivo</td>
        <td width="40px" rowspan="2" align="right">$EfectivoCorte</td>
        <td width="40px" align="right">$DolaresCorte</td>
        <td width="40px" align="right">$LempirasCorte</td> 
        <td width="49px" align="right" rowspan="2" >$EfectivoQuetzalizado</td> 
        <td width="40px" align="right" rowspan="2" >$EfectivoCorte1</td>
        <td width="40px" align="right" >$DolaresCorte1</td>
        <td width="40px" align="right" >$LempirasCorte1</td>
        <td width="49px" align="right" rowspan="2" >$EfectivoQuetzalizado1</td> 
        <td width="49px" rowspan="2" align="right"></td>
        <td width="50px" rowspan="2" align="right"></td>
        <td width="50px" rowspan="2" align="right">$EfectivoQuetzalizadoTot</td>
    </tr>
    <tr style="font-size: 8px">
        <td width="40px" align="right">$Dolares1Corte</td>
        <td width="40px" align="right">$Lempiras1Corte</td>
        <td width="40px" align="right">$Dolares1Corte</td>
        <td width="40px" align="right">$Lempiras1Corte</td>
    </tr>
    <tr style="font-size: 8px">
        <td width="40px">Crédito</td>
        <td width="40px" align="right">$CreditoCorte</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$CreditoCorte</td>
        <td width="40px" align="right">$CreditoCorte1</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$CreditoCorte1</td>
        <td align="right"> </td>
        <td align="right"> </td>
        <td align="right">$CredTot</td> 
    </tr>
    <tr style="font-size: 8px">
        <td width="40px">Tarjeta C</td>
        <td align="right">$TCCorte</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$TCCorte</td>
        <td align="right">$TCCorte1</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$TCCorte1</td>
        <td align="right"> </td>
        <td align="right"> </td>
        <td align="right">$TarTot</td> 
    </tr>
    <tr style="font-size: 8px">
        <td width="40px">Depósitos</td>
        <td align="right">$DepositosCorte</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$DepositosCorte</td>
        <td align="right">$DepositosCorte1</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$DepositosCorte1</td> 
        <td align="right"> </td>
        <td align="right"> </td>
        <td align="right">$DepTot</td> 
    </tr>
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>TOTAL DATOS PRELIMINARES</b></td>
        <td align="right">$TotalDatosPreliminares</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$TotalDatosPreliminares1</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr> 
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>TOTAL EFECTIVO</b></td>
        <td align="right">$TotalIngresos</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$TotalIngresos1</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$TotalIngresosTotal</td>
    </tr>
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>TOTAL FACTURADO</b></td>
        <td align="right">$FacturadoCorte</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$FacturadoCorte1</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$FacturadoCorteTotal</td> 
    </tr>
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>TOTAL NOTAS</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$FilaNotasC</td>
        <td align="right">$TotalNotasDebito</td>
        <td align="right"></td> 
    </tr>
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>TOTAL ANULADO</b></td>
        <td align="right">$FacA1</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$FacA2</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$FacturadoAnuladaTotal</td> 
    </tr>
  
EOD;
if($Query1["Sobrante"]>0 || $Query2["Sobrante"]>0)
{ 
    $Sobra1 = $Query1["Sobrante"];
    $Sobra2 = $Query2["Sobrante"];
    $SobraTotal =  $Sobra1+  $Sobra2;
    
$tbl1 .= <<<EOD
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>SOBRANTE DE CAJA</b></td>
        <td align="right">$Sobra1</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$Sobra2</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$SobraTotal</td>
    </tr>
EOD;
}
if($Query1["Faltante"]<0 || $Query2["Faltante"]<0)
{ 
    $Faltante1 = $Query1["Faltante"];
    $Faltante2 = $Query2["Faltante"];
    $FaltanteTotal =  $Faltante1+  $Faltante2;
    
$tbl1 .= <<<EOD
    <tr style="font-size: 8px">
        <td colspan="4" align="center"><b>FALTANTE DE CAJA</b></td>
        <td align="right">$Faltante1</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$Faltante2</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$FaltanteTotal</td>
    </tr>
EOD;
}

if($TotalNotasEmitidas>0)
{  
$NC = "SELECT A.TRA_DTE,  A.TRA_FACTURA_NOTA_CREDITO, B.F_CAE, B.F_FECHA_TRANS
FROM Contabilidad.TRANSACCION AS A
INNER JOIN Bodega.FACTURA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
WHERE A.TT_CODIGO = 17
AND A.TRA_FECHA_TRANS = '$Fecha'";
$Result = mysqli_query($db, $NC);
while($row1 = mysqli_fetch_array($Result))
{ 
   $Nota = $row1["TRA_DTE"];
   $Fac = $row1["F_CAE"];
   $FechaFac = cambio_fecha($row1["F_FECHA_TRANS"]);
} 

$tbl1 .= <<<EOD
    <tr style="font-size: 8px">
        <td colspan="16">*Nota de crédito $Nota aplicada a la factura número $Fac, fecha $FechaFac <br></td>
    </tr>
EOD;
}
$tbl1 .= <<<EOD
</table>
EOD;


$pdf->writeHTML($tbl1,0,0,0,0,'J'); 


$pdf->SetFont('Helvetica', '', 40);
$pdf->Cell(0,0, "",0,1,'R');

$pdf->SetFont('Helvetica', '', 10);

$tbl1 = <<<EOD
<table border="0">
    <tr>
    <td align="center">______________________________</td>
    <td align="center">______________________________</td>
    </tr>
    <tr>
    <td align="center">$UsuarioNombre1</td>
    <td align="center">$UsuarioNombre2</td>
    </tr>
    <tr>
    <td align="center">Entrega</td>
    <td align="center">Entrega</td>
    </tr>
    
    <tr>
    <td align="center"> </td>
    </tr>
  
    <tr>
    <td align="center"> </td>
    </tr>
    <tr>
    <td align="center">______________________________</td> 
    </tr>
    <tr>
    <td align="center">$Contabiliza</td> 
    </tr>
    <tr>
    <td align="center">Recibe</td> 
    </tr>
EOD;

$tbl1 .= <<<EOD
</table>
EOD;

$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
ob_clean();
$pdf->Output();
ob_flush();
?>