<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");
 
$Codig = $_GET["Codigo"];
$FechaHoy = date("Y-m-d");
$Usuario = $_SESSION["iduser"];
 
$EntregaCol = saber_nombre_colaborador($Usuario);
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$TotalNotasDebito = number_format(0, 2);
$queryTasaCambioLempira = "SELECT TC_TASA FROM Contabilidad.TASA_CAMBIO WHERE TC_CODIGO = 1";
                $resultTasaCambioLempira = mysqli_query($db, $queryTasaCambioLempira);
                while($FilaTCL = mysqli_fetch_array($resultTasaCambioLempira))
                {
                    $TasaCambioLempira = $FilaTCL["TC_TASA"];
                }

                $queryTasaCambioDolar = "SELECT TC_TASA FROM Contabilidad.TASA_CAMBIO WHERE TC_CODIGO = 2";
                $resultTasaCambioDolar = mysqli_query($db, $queryTasaCambioDolar);
                while($FilaTCL = mysqli_fetch_array($resultTasaCambioDolar))
                {
                    $TasaCambioDolar = $FilaTCL["TC_TASA"];
                }

                $sql = "SELECT APERTURA_CIERRE_CAJA.*, CIERRE_DETALLE.* 
                        FROM Bodega.APERTURA_CIERRE_CAJA, Bodega.CIERRE_DETALLE
                        WHERE APERTURA_CIERRE_CAJA.ACC_CODIGO = CIERRE_DETALLE.ACC_CODIGO
                        AND APERTURA_CIERRE_CAJA.ACC_FECHA = '".$FechaHoy."'
                        AND APERTURA_CIERRE_CAJA.ACC_TIPO = 22 and CIERRE_DETALLE.CD_USUARIO = $Usuario
                        ";
                $result = mysqli_query($db, $sql);
                while($fila = mysqli_fetch_array($result))
                {
                    $Fecha        = $fila["ACC_FECHA"];
                    $SaldoInicial = $fila["ACC_SALDO_INICIAL"];
                    $Cierre       = $fila["ACC_CORRELATIVO"];
                    
                    $BQ200        = $fila["CD_Q_200"];
                    $BQ100        = $fila["CD_Q_100"];
                    $BQ50         = $fila["CD_Q_50"];
                    $BQ20         = $fila["CD_Q_20"];
                    $BQ10         = $fila["CD_Q_10"];
                    $BQ5          = $fila["CD_Q_5"];
                    $BQ1          = $fila["CD_Q_1"];
                    $MQ1          = $fila["CD_M_1"];
                    $MQ50         = $fila["CD_M_50"];
                    $MQ25         = $fila["CD_M_25"];
                    $MQ10         = $fila["CD_M_10"];
                    $MQ5          = $fila["CD_M_5"];
                    $TCQ          = $fila["CD_TOTAL_Q"];
                    
                    $BD100        = $fila["CD_D_100"];
                    $BD50         = $fila["CD_D_50"];
                    $BD20         = $fila["CD_D_20"];
                    $BD10         = $fila["CD_D_10"];
                    $BD5          = $fila["CD_D_5"];
                    $BD1          = $fila["CD_D_1"];
                    $TCD          = $fila["CD_TOTAL_D"];
                    
                    $BL500        = $fila["CD_L_500"];
                    $BL100        = $fila["CD_L_100"];
                    $BL50         = $fila["CD_L_50"];
                    $BL20         = $fila["CD_L_20"];
                    $BL10         = $fila["CD_L_10"];
                    $BL5          = $fila["CD_L_5"];
                    $TCL          = $fila["CD_TOTAL_L"];

                    $Faltante     = $fila["CD_TOTAL_FALTANTE"];
                    $Sobrante     = $fila["CD_TOTAL_SOBRANTE"];

                }

                $QueryMinMaxFacturas = "SELECT MAX(F_NUMERO) AS MAXIMO, MIN(F_NUMERO) AS MINIMO, F_SERIE FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."'";
                $ResultMinMaxFacturas = mysqli_query($db, $QueryMinMaxFacturas);
                while($FilaMinMaxFacturas = mysqli_fetch_array($ResultMinMaxFacturas))
                {
                    $DelFactura = $FilaMinMaxFacturas["MINIMO"];
                    $AlFactura = $FilaMinMaxFacturas["MAXIMO"];
                    $SerieFactura = $FilaMinMaxFacturas["F_SERIE"];
                }

                $Query = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_USUARIO = $Usuario";
                $Result = mysqli_query($db, $Query);
                while($row = mysqli_fetch_array($Result))
                {
                    $FacturasEmitidas = $row["FACTURAS_EMITIDAS"];
                }

                $Query1 = "SELECT COUNT(F_CODIGO) AS FACTURAS_ANULADAS FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_ESTADO = 2 AND F_USUARIO = $Usuario";
                $Result1 = mysqli_query($db, $Query1);
                while($row1 = mysqli_fetch_array($Result1))
                {
                    $FacturasAnuladas = $row1["FACTURAS_ANULADAS"];
                }


                $Query3 = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITO FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_TIPO = 2 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result3 = mysqli_query($db, $Query3);
                while($row3 = mysqli_fetch_array($Result3))
                {
                    $TotalTarjetaCredito = $row3["TOTAL_CREDITO"];
                }

                $Query4 = "SELECT SUM(F_TOTAL) AS TOTAL_DOLARES FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_TIPO = 1 AND F_MONEDA = 2 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result4 = mysqli_query($db, $Query4);
                while($row4 = mysqli_fetch_array($Result4))
                {
                    $TotalDolares = $row4["TOTAL_DOLARES"];
                }

                $TotalDolaresQuetzalisados = $TCD * $TasaCambioDolar;

                $Query4 = "SELECT SUM(F_TOTAL) AS TOTAL_LEMPIRAS FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_TIPO = 1 AND F_MONEDA = 3 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result4 = mysqli_query($db, $Query4);
                while($row4 = mysqli_fetch_array($Result4))
                {
                    $TotalLempiras = $row4["TOTAL_LEMPIRAS"];
                }

                $TotalLempirasQuetzalisados = $TCL * $TasaCambioLempira;

                $Query5 = "SELECT SUM(F_TOTAL) AS TOTAL_DEPOSITOS FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_TIPO = 4 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result5 = mysqli_query($db, $Query5);
                while($row5 = mysqli_fetch_array($Result5))
                {
                    $TotalDeposito = $row5["TOTAL_DEPOSITOS"];
                }   

                $Query6 = "SELECT SUM(F_TOTAL) AS TOTAL_CREDITOS FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_TIPO = 3 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result6 = mysqli_query($db, $Query6);
                while($row6 = mysqli_fetch_array($Result6))
                {
                    $TotalCreditos = $row6["TOTAL_CREDITOS"];
                }       

                $Query7 = "SELECT SUM(F_TOTAL) AS TOTAL_EFECTIVO FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_MONEDA = 1 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result7 = mysqli_query($db, $Query7);
                while($row = mysqli_fetch_array($Result7))
                {
                    $TotalEfectivo = $row["TOTAL_EFECTIVO"];
                }   
 
                $Query9 = "SELECT SUM(F_CAMBIO) AS TOTAL_CAMBIO_LEMPIRA FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_MONEDA = 3 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result9 = mysqli_query($db, $Query9);
                while($row = mysqli_fetch_array($Result9))
                {
                    $CambioLempiras = $row["TOTAL_CAMBIO_LEMPIRA"];
                }

                $Query10 = "SELECT SUM(F_CAMBIO) AS TOTAL_CAMBIO_DOLARES FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."' AND F_MONEDA = 2 AND F_ESTADO = 1 AND F_USUARIO = $Usuario";
                $Result10 = mysqli_query($db, $Query10);
                while($row = mysqli_fetch_array($Result10))
                {
                    $CambioDolares = $row["TOTAL_CAMBIO_DOLARES"];
                }
 
                $Query11 = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_PIZZA WHERE F_ESTADO = 1 AND F_USUARIO = $Usuario AND F_FECHA_TRANS = '".$FechaHoy."'";
                $Result11 = mysqli_query($db, $Query11);
                while($row = mysqli_fetch_array($Result11))
                {
                    $TotalFacturado = $row["TOTAL_FACTURADO"];
                }

                $QueryNotaEfectivo = mysqli_query($db, "SELECT A.TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 1");
                $RegistrosNotaEfectivo = mysqli_num_rows($QueryNotaEfectivo);

                if($RegistrosNotaEfectivo > 1)
                {
                    $QueryNotaEfectivo = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 1");
                }

                $FilaNotaEfectivo = mysqli_fetch_array($QueryNotaEfectivo);

                $QueryNotaCredito = mysqli_query($db, "SELECT A.TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 2");
                $RegistrosNotaCredito = mysqli_num_rows($QueryNotaCredito);

                if($RegistrosNotaCredito > 1)
                {
                    $QueryNotaCredito = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 2");
                }

                $FilaNotaCredito = mysqli_fetch_array($QueryNotaCredito);

                $QueryNotaTarjetaCredito = mysqli_query($db, "SELECT A.TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 3");
                $RegistrosTarjetaCredito = mysqli_num_rows($QueryNotaTarjetaCredito);

                if($RegistrosTarjetaCredito > 1)
                {
                    $QueryNotaTarjetaCredito = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL)
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 3");
                }

                $FilaNotaTarjetaCredito = mysqli_fetch_array($QueryNotaTarjetaCredito);

                $QueryNotaDepositos = mysqli_query($db, "SELECT A.TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 4");
                $RegistrosNotaDepositos = mysqli_num_rows($QueryNotaDepositos);

                if($RegistrosNotaDepositos > 1)
                {
                    $QueryNotaDepositos = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_TIPO = 4");
                }


                $FilaNotaDepositos = mysqli_fetch_array($QueryNotaDepositos);

                $QueryNotaDolares = mysqli_query($db, "SELECT A.TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_MONEDA = 2");
                $RegistrosNotaDolares = mysqli_num_rows($QueryNotaDolares);

                if($RegistrosNotaDolares > 1)
                {
                    $QueryNotaDolares = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_MONEDA = 2");
                }


                $FilaNotaDolares = mysqli_fetch_array($QueryNotaDolares);

                $QueryNotaLempiras = mysqli_query($db, "SELECT A.TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_MONEDA = 3");
                $RegistrosNotaLempiras = mysqli_num_rows($QueryNotaLempiras);

                if($RegistrosNotaDolares > 1)
                {
                    $QueryNotaLempiras = mysqli_query($db, "SELECT SUM(A.TRA_TOTAL) AS TRA_TOTAL
                                                    FROM Contabilidad.TRANSACCION AS A
                                                    INNER JOIN Bodega.FACTURA_PIZZA AS B ON A.TRA_FACTURA_NOTA_CREDITO = B.F_CODIGO
                                                    WHERE A.TT_CODIGO = 17 AND B.F_CODIGO = $Usuario
                                                    AND A.TRA_FECHA_TRANS = '".$FechaHoy."'
                                                    AND B.F_MONEDA = 3");
                }


                $FilaNotaLempiras = mysqli_fetch_array($QueryNotaLempiras);

                $TotalNotasEmitidas = $RegistrosNotaEfectivo + $RegistrosNotaCredito + $RegistrosTarjetaCredito + $RegistrosNotaDepositos + $RegistrosNotaDolares + $RegistrosNotaLempiras;

             

                $TotalEfectivo = $TotalEfectivo - $CambioLempiras - $CambioDolares;

                $Total = ($TCQ + $TotalTarjetaCredito + $TotalDolaresQuetzalisados + $TotalLempirasQuetzalisados + $TotalDeposito + $TotalCreditos - ($FilaNotaEfectivo[TRA_TOTAL] + $FilaNotaCredito[TRA_TOTAL] + $FilaNotaTarjetaCredito[TRA_TOTAL] + $FilaNotaDepositos[TRA_TOTAL] + $FilaNotaDolares[TRA_TOTAL] + $FilaNotaLempiras[TRA_TOTAL]));

                $FaltSob = ($TCQ + $TotalCreditos + $TotalTarjetaCredito + $TotalDolaresQuetzalisados + $TotalLempirasQuetzalisados + $TotalDeposito) - ($TotalFacturado - ($FilaNotaEfectivo[TRA_TOTAL] + $FilaNotaCredito[TRA_TOTAL] + $FilaNotaTarjetaCredito[TRA_TOTAL] + $FilaNotaDepositos[TRA_TOTAL] + $FilaNotaDolares[TRA_TOTAL] + $FilaNotaLempiras[TRA_TOTAL]));

                $QueryDocumentosEmitidos = mysqli_query($db, "SELECT F_CODIGO FROM Bodega.FACTURA_PIZZA WHERE F_FECHA_TRANS = '".$FechaHoy."'");
                $TotalDocumentosEmitidos = mysqli_num_rows($QueryDocumentosEmitidos);

                $QueryFacturas = mysqli_query($db, "SELECT MIN(A.F_DTE) AS MINIMO, MAX(A.F_DTE) AS MAXIMO
                                                FROM Bodega.FACTURA_PIZZA AS A
                                                WHERE A.F_FECHA_TRANS = '".$FechaHoy."'");
                $FilaFactura = mysqli_fetch_array($QueryFacturas);

                $EfectivoQuetzalizado = number_format($TCQ + $TotalDolaresQuetzalisados + $TotalLempirasQuetzalisados, 2);
                $TotalDatosPreliminares = number_format(($TCQ + $TotalDolaresQuetzalisados + $TotalLempirasQuetzalisados) + $TotalCreditos + $TotalTarjetaCredito + $TotalDeposito, 2);
                $TotalDepositos = number_format($TotalDeposito - $FilaNotaDepositos[TRA_TOTAL] + $_POST["NotaDebitoDeposito"], 2);
                $TotalIngresos = number_format(($TCQ + $TotalDolaresQuetzalisados + $TotalLempirasQuetzalisados) + ($TotalCreditos - $FilaNotaCredito[TRA_TOTAL]) + ($TotalTarjetaCredito - $FilaNotaTarjetaCredito[TRA_TOTAL]) + ($TotalDeposito - $FilaNotaDepositos[TRA_TOTAL]), 2);
                $TotalNotasEmitidasTotal = number_format(($FilaNotaEfectivo[TRA_TOTAL] + $FilaNotaCredito[TRA_TOTAL] + $FilaNotaTarjetaCredito[TRA_TOTAL] + $FilaNotaDolares[TRA_TOTAL] + $FilaNotaLempiras[TRA_TOTAL]  + $FilaNotaDepositos[TRA_TOTAL]) - $TotalNotasDebito, 2);
                $FacturaMinima = $FilaFactura["MINIMO"];
                $FacturaMaxima = $FilaFactura["MAXIMO"];

$FaltanteSobranteTotal = (($TCQ + $TotalDolaresQuetzalisados + $TotalLempirasQuetzalisados) + ($TotalCreditos - $FilaNotaCredito[TRA_TOTAL]) + ($TotalTarjetaCredito - $FilaNotaTarjetaCredito[TRA_TOTAL]) + ($TotalDeposito - $FilaNotaDepositos[TRA_TOTAL])) - ($TotalFacturado - (($FilaNotaEfectivo[TRA_TOTAL] + $FilaNotaCredito[TRA_TOTAL] + $FilaNotaTarjetaCredito[TRA_TOTAL] + $FilaNotaDolares[TRA_TOTAL]  + $FilaNotaLempiras[TRA_TOTAL]  + $FilaNotaDepositos[TRA_TOTAL]) - $TotalNotasDebito)) ;
 
if($FaltanteSobranteTotal > 0)
{
    $Titulo = 'SOBRANTE DE CAJA';
    $UpdSob = mysqli_query($db, "UPDATE Bodega.CIERRE_DETALLE SET CD_TOTAL_SOBRANTE = $FaltanteSobranteTotal WHERE CD_USUARIO = $Usuario AND ACC_CODIGO = '$Codig'");
}
elseif($FaltanteSobranteTotal < 0)
{
    $Titulo = 'FALTANTE DE CAJA';
    $UpdSob = mysqli_query($db, "UPDATE Bodega.CIERRE_DETALLE SET CD_TOTAL_FALTANTE = ($FaltanteSobranteTotal*-1)  WHERE CD_USUARIO = $Usuario AND ACC_CODIGO = '$Codig'");
}
else
{
    $Titulo = '';
}

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
        $this->Cell(0,0,"CONTROL DE INGRESOS CIERRE PARCIAL",0,1,'C');
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
        <td colspan="8"><b>Fecha:</b> $FechaHora</td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="8"><b>Facturas Emitidas:</b> $FacturasEmitidas</td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="8"><b>NC: </b> $TotalNotasEmitidas</td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="8"><b>ND: </b> 0</td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="4"></td>
        <td align="center"><b> </b></td>
        <td align="center" rowspan="2" valign="middle"><b>Notas de Crédito</b></td>
        <td align="center" rowspan="2" valign="middle"><b>Notas De Débito</b></td>
        <td align="center" rowspan="2" valign="middle"><b>TOTAL</b></td>
    </tr>
    <tr style="font-size: 18px">
        <td></td>
        <td align="center"><b>Q</b></td>
        <td align="center"><b>$</b></td>
        <td align="center"><b>L</b></td>
        <td align="center"><b>Tot. Q</b></td>
    </tr>
    <tr style="font-size: 18px">
        <td rowspan="2">Efectivo</td>
        <td rowspan="2" align="right">$TCQ</td>
        <td align="right">$TCD</td>
        <td align="right">$TCL</td>
        <td align="right" rowspan="2" >$EfectivoQuetzalizado</td>
        <td align="right" rowspan="2" >$FilaNotaEfectivo[TRA_TOTAL]</td>
        <td align="right" rowspan="2" >$NotaDebitoEfectivo</td>
        <td align="right" rowspan="2" >$EfectivoQuetzalizado</td>
    </tr>
    <tr style="font-size: 18px">
        <td align="right">$Dolares1Corte</td>
        <td align="right">$Lempiras1Corte</td>
    </tr>
    <tr style="font-size: 18px">
        <td>Crédito</td>
        <td align="right">$TotalCreditos</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$TotalCreditos</td>
        <td align="right">$FilaNotaCredito[TRA_TOTAL]</td>
        <td align="right">$NotaDebitoCredito</td>
        <td align="right">$TotalCr</td>
    </tr>
    <tr style="font-size: 18px">
        <td>Tarjeta de Crédito</td>
        <td align="right">$TotalTarjetaCredito</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$TotalTarjetaCredito</td>
        <td align="right">$FilaNotaTarjetaCredito[TRA_TOTAL]</td>
        <td align="right">$NotaDebitoTarjeta</td>
        <td align="right">$TotalTar</td>
    </tr>
    <tr style="font-size: 18px">
        <td>Depósitos</td>
        <td align="right">$TotalDeposito</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="right">$TotalDeposito</td>
        <td align="right">$FilaNotaDepositos[TRA_TOTAL]</td>
        <td align="right">$NotaDebitoDeposito</td>
        <td align="right">$TotalDepositos</td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="4"><b>TOTAL DATOS PRELIMINARES</b></td>
        <td align="right">$TotalDatosPreliminares</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="4"><b>TOTAL NOTAS</b></td>
        <td align="right"></td>
        <td align="right">$TotalNotasCredito</td>
        <td align="right">$TotalNotasDebito</td>
        <td align="right"></td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="4"><b>TOTAL INGRESOS</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$TotalIngresos</td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="4"><b>TOTAL FACTURADO</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$TotalFacturado</td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="4"><b>NOTAS EMITIDAS</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$TotalNotasEmitidasTotal</td>
    </tr>
    <tr style="font-size: 18px">
        <td colspan="4"><b>$Titulo</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">$FaltanteSobranteTotal</td>
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