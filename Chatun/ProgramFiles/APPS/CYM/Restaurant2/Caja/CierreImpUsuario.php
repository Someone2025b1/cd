<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");
 
 
$FechaHoy = $_GET["FechaInicio"];
$FechaDet = cambio_fecha($_GET["FechaInicio"]);
$Usuario = $_GET["Usuario"];
 
$EntregaCol = saber_nombre_colaborador($Usuario);
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
 

                $Query = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_USUARIO = $Usuario";
                $Result = mysqli_query($db, $Query);
                while($row = mysqli_fetch_array($Result))
                {
                    $FacturasEmitidas = $row["FACTURAS_EMITIDAS"];
                }

                $Query1 = "SELECT COUNT(F_CODIGO) AS FACTURAS_ANULADAS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_ESTADO = 2 AND F_USUARIO = $Usuario";
                $Result1 = mysqli_query($db, $Query1);
                while($row1 = mysqli_fetch_array($Result1))
                {
                    $FacturasAnuladas = $row1["FACTURAS_ANULADAS"];
                }


                $Query3 = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITO FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_TIPO = 2 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result3 = mysqli_query($db, $Query3);
                while($row3 = mysqli_fetch_array($Result3))
                {
                    $TotalTarjetaCredito = $row3["TOTAL_CREDITO"];
                }

                $Query4 = "SELECT SUM(F_TOTAL) AS TOTAL_DOLARES FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_TIPO = 1 AND F_MONEDA = 2 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result4 = mysqli_query($db, $Query4);
                while($row4 = mysqli_fetch_array($Result4))
                {
                    $TotalDolares = $row4["TOTAL_DOLARES"];
                }

                $TotalDolaresQuetzalisados = $TCD * $TasaCambioDolar;

                $Query4 = "SELECT SUM(F_TOTAL) AS TOTAL_LEMPIRAS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_TIPO = 1 AND F_MONEDA = 3 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result4 = mysqli_query($db, $Query4);
                while($row4 = mysqli_fetch_array($Result4))
                {
                    $TotalLempiras = $row4["TOTAL_LEMPIRAS"];
                }

                $TotalLempirasQuetzalisados = $TCL * $TasaCambioLempira;

                $Query5 = "SELECT SUM(F_TOTAL) AS TOTAL_DEPOSITOS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_TIPO = 4 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result5 = mysqli_query($db, $Query5);
                while($row5 = mysqli_fetch_array($Result5))
                {
                    $TotalDeposito = $row5["TOTAL_DEPOSITOS"];
                }   

                $Query6 = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITOS FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_TIPO = 3 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result6 = mysqli_query($db, $Query6);
                while($row6 = mysqli_fetch_array($Result6))
                {
                    $TotalCreditos = $row6["TOTAL_CREDITOS"];
                }       

                $Query7 = "SELECT SUM(F_TOTAL) AS TOTAL_EFECTIVO FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_MONEDA = 1 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result7 = mysqli_query($db, $Query7);
                while($row = mysqli_fetch_array($Result7))
                {
                    $TotalEfectivo = $row["TOTAL_EFECTIVO"];
                }   
 
                $Query9 = "SELECT SUM(F_CAMBIO) AS TOTAL_CAMBIO_LEMPIRA FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_MONEDA = 3 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result9 = mysqli_query($db, $Query9);
                while($row = mysqli_fetch_array($Result9))
                {
                    $CambioLempiras = $row["TOTAL_CAMBIO_LEMPIRA"];
                }

                $Query10 = "SELECT SUM(F_CAMBIO) AS TOTAL_CAMBIO_DOLARES FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_MONEDA = 2 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result10 = mysqli_query($db, $Query10);
                while($row = mysqli_fetch_array($Result10))
                {
                    $CambioDolares = $row["TOTAL_CAMBIO_DOLARES"];
                }
 
                $Query11 = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA WHERE F_ESTADO = 1 AND F_USUARIO = $Usuario AND F_FECHA_TRANS = '".$FechaHoy."'";
                $Result11 = mysqli_query($db, $Query11);
                while($row = mysqli_fetch_array($Result11))
                {
                    $TotalFacturado = $row["TOTAL_FACTURADO"];
                }

                $QueryNotaEfectivo = mysqli_query($db, "SELECT A.TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 1");
                $RegistrosNotaEfectivo = mysqli_num_rows($QueryNotaEfectivo);

                if($RegistrosNotaEfectivo > 1)
                {
                    $QueryNotaEfectivo = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 1");
                }

                $FilaNotaEfectivo = mysqli_fetch_array($QueryNotaEfectivo);

                $QueryNotaCredito = mysqli_query($db, "SELECT A.TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 2");
                $RegistrosNotaCredito = mysqli_num_rows($QueryNotaCredito);

                if($RegistrosNotaCredito > 1)
                {
                    $QueryNotaCredito = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 2");
                }

                $FilaNotaCredito = mysqli_fetch_array($QueryNotaCredito);

                $QueryNotaTarjetaCredito = mysqli_query($db, "SELECT A.TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 3");
                $RegistrosTarjetaCredito = mysqli_num_rows($QueryNotaTarjetaCredito);

                if($RegistrosTarjetaCredito > 1)
                {
                    $QueryNotaTarjetaCredito = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL)
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 3");
                }

                $FilaNotaTarjetaCredito = mysqli_fetch_array($QueryNotaTarjetaCredito);

              
              
         

                $TotalNotasEmitidas = $RegistrosNotaEfectivo + $RegistrosNotaCredito + $RegistrosTarjetaCredito + $RegistrosNotaDepositos + $RegistrosNotaDolares + $RegistrosNotaLempiras;

             

                $QueryDocumentosEmitidos = mysqli_query($db, "SELECT F_CODIGO FROM Bodega.FACTURA WHERE F_FECHA_TRANS = '".$FechaHoy."'");
                $TotalDocumentosEmitidos = mysqli_num_rows($QueryDocumentosEmitidos);

                $QueryFacturas = mysqli_query($db, "SELECT MIN(A.F_DTE) AS MINIMO, MAX(A.F_DTE) AS MAXIMO
                                                FROM Bodega.FACTURA AS A
                                                WHERE A.F_FECHA_TRANS = '".$FechaHoy."'");
                $FilaFactura = mysqli_fetch_array($QueryFacturas);

               $TotalDatosPreliminares = number_format($TotalCreditos + $TotalTarjetaCredito + $TotalDeposito, 2);
                $TotalDepositos = number_format($TotalDeposito - $FilaNotaDepositos[TRA_TOTAL] + $_POST["NotaDebitoDeposito"], 2);
                    
$TotalCr = $TotalCreditos - $FilaNotaCredito['TRA_TOTAL'];
$TotalTar = $TotalTarjetaCredito - $FilaNotaTarjetaCredito['TRA_TOTAL'];
//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = '../../../../../img/logo.png';
        $this->Image($image_file, 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0,0,"DOCUMENTOS EMITIDOS POR USUARIO",0,1,'C');
        $this->Cell(0,0, "CAJA TERRAZAS" ,0,1,'C');
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","pt", array(600, 3000), 'UTF-8', FALSE);
$pdf->SetMargins(15,58,15);
// Add a page
$pdf->AddPage(); 

$tbl1 .= <<<EOD
<table  >
    <tr style="font-size: 18px">
        <td colspan="8"><b>Fecha:</b> $FechaDet</td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="8"><b>Facturas Emitidas:</b> $FacturasEmitidas</td>
    </tr> 
    <tr style="font-size: 18px">
        <td colspan="8"><b>Facturas Anuladas:</b> $FacturasAnuladas</td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="8"></td> 
        <td align="center" rowspan="6" valign="middle"><b>TOTAL</b></td>
    </tr> 
    <tr style="font-size: 18px">
        <td  colspan="4">Crédito</td>
        <td align="right">$TotalCreditos</td>   
    </tr>
    <tr style="font-size: 18px">
        <td colspan="4">Tarjeta de Crédito</td>
        <td align="right">$TotalTarjetaCredito</td> 
    </tr>
    <tr style="font-size: 18px">
        <td colspan="4">Depósitos</td>
        <td align="right">$TotalDeposito</td>  
    </tr>
    <tr style="font-size: 18px">
        <td colspan="4"><b>TOTAL DATOS PRELIMINARES</b></td>
        <td align="right">$TotalDatosPreliminares</td> 
    </tr>  
    <tr style="font-size: 18px">
        <td colspan="4"> </td>
        
    </tr> 
    <tr style="font-size: 18px">
        <td colspan="4"><b>TOTAL FACTURADO</b></td> 
        <td align="right">$TotalFacturado</td>
    </tr>  
EOD;

$tbl1 .= <<<EOD
</table>
EOD;


$pdf->writeHTML($tbl1,0,0,0,0,'J'); 


$pdf->SetFont('Helvetica', '', 40);
$pdf->Cell(0,0, "",0,1,'R');

$pdf->SetFont('Helvetica', '', 14);

$tbl1 = <<<EOD
<table border="0">
    <tr>
    <td align="center">______________________________</td> 
    </tr>
    <tr>
    <td align="center">$EntregaCol</td>  
    </tr>
      <tr>
    <td align="center">Entrega</td>  
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