<?php 
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));

$Codigo = $_POST["NombreCuenta"];
$Nombre = "1.01.03.003";

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];
$Producto = $_POST["Producto"];


$FechaFinal = date('Y-m-d', strtotime($FechaIni."-1 day"));

$TotalActivo = 0;
$TotalPasivo = 0;


$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
if($Nombre == '1.01.02.001' || $Nombre == '1.01.02.002' || $Nombre == '1.01.02.003' || $Nombre == '1.01.02.004' || $Nombre == '1.01.02.007' || $Nombre == '1.01.02.008' || $Nombre == '1.01.02.005' || $Nombre == '1.01.02.006')
{
    $pdf->ezText("Libro de Banco | $Codigo",16,array('justification'=>'center'));
    $pdf->ezText("$Nombre",16,array('justification'=>'center'));
}
else
{
    $pdf->ezText("Estado de Cuenta - ".$Nombre." - ".$Codigo,16,array('justification'=>'center'));

}
$pdf->ezText("Del ".date('d-m-Y', strtotime($FechaIni))." Al ".date('d-m-Y', strtotime($FechaFin)),14,array('justification'=>'center'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>'Fecha', 'colFactura'=>'Factura', 'colNombre'=>' Nombre Cliente', 'col2'=>'Tipo', 'col3'=>'Concepto', 'col4'=>'Cargos', 'col5'=>'Abonos', 'col6'=>'Total');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>8, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/


$QueryAnterior = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                AND TRANSACCION.TRA_FECHA_TRANS
                BETWEEN  '2016/01/01'
                AND  '".$FechaFinal."'
                AND TRANSACCION_DETALLE.N_CODIGO =  '".$Nombre."'
                AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1";
$ResultAnterior = mysqli_query($db, $QueryAnterior);
while($FilaAnterior = mysqli_fetch_array($ResultAnterior))
{
    if($Nombre[0] == 1)
    {
        $Saldo = $FilaAnterior["CARGOS"] - $FilaAnterior["ABONOS"];    
    }
    else
    {
        $Saldo = $FilaAnterior["ABONOS"] - $FilaAnterior["CARGOS"];
    }
    

    $SaldoFinal = $SaldoFinal + $Saldo;

    $Data[] = array('col1'=>'-----', 'colFactura'=>'-----', 'colNombre'=>'------', 'col2'=>'-----', 'col3'=>'Saldos Anteriores', 'col4'=>number_format($FilaAnterior["CARGOS"], 2, '.', ','), 'col5'=>number_format($FilaAnterior["ABONOS"], 2, '.', ','), 'col6'=>number_format($SaldoFinal, 2, '.', ','));
}

$QueryAnterior = "SELECT TRANSACCION_DETALLE.TRAD_CARGO_CONTA AS CARGOS, TRANSACCION_DETALLE.TRAD_ABONO_CONTA AS ABONOS, TIPO_TRANSACCION.TT_NOMBRE, TRANSACCION.TRA_FECHA_TRANS, TRANSACCION.TRA_CONCEPTO, TRANSACCION.TRA_SERIE, TRANSACCION.TRA_FACTURA,
                    CLIENTE.CLI_NOMBRE AS CLIENTE, TRANSACCION.TRA_FECHA_TRANS AS fech, TRANSACCION.TRA_HORA AS hora
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TIPO_TRANSACCION, Contabilidad.TRANSACCION,
                    Bodega.FACTURA, Bodega.CLIENTE
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO
                    AND TRANSACCION.TRA_CODIGO = FACTURA.F_CODIGO
                    AND FACTURA.CLI_NIT = CLIENTE.CLI_NIT
                    AND (TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."')
                    AND TRANSACCION_DETALLE.N_CODIGO = '".$Nombre."'
                    AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1
                    
					UNION ALL
                    
                    SELECT TRANSACCION_DETALLE.TRAD_CARGO_CONTA AS CARGOS, TRANSACCION_DETALLE.TRAD_ABONO_CONTA AS ABONOS, TIPO_TRANSACCION.TT_NOMBRE, TRANSACCION.TRA_FECHA_TRANS, TRANSACCION.TRA_CONCEPTO, TRANSACCION.TRA_SERIE, TRANSACCION.TRA_FACTURA,
                    CLIENTE.CLI_NOMBRE AS CLIENTE, TRANSACCION.TRA_FECHA_TRANS AS fech, TRANSACCION.TRA_HORA AS hora
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TIPO_TRANSACCION, Contabilidad.TRANSACCION,
                    Bodega.FACTURA_EV, Bodega.CLIENTE
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO
                    AND TRANSACCION.TRA_CODIGO = FACTURA_EV.F_CODIGO
                    AND FACTURA_EV.CLI_NIT = CLIENTE.CLI_NIT
                    AND (TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."')
                    AND TRANSACCION_DETALLE.N_CODIGO = '".$Nombre."'
                    AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1

                    UNION ALL
                    
                    SELECT TRANSACCION_DETALLE.TRAD_CARGO_CONTA AS CARGOS, TRANSACCION_DETALLE.TRAD_ABONO_CONTA AS ABONOS, TIPO_TRANSACCION.TT_NOMBRE, TRANSACCION.TRA_FECHA_TRANS, TRANSACCION.TRA_CONCEPTO, TRANSACCION.TRA_SERIE, TRANSACCION.TRA_FACTURA,
                    CLIENTE.CLI_NOMBRE AS CLIENTE, TRANSACCION.TRA_FECHA_TRANS AS fech, TRANSACCION.TRA_HORA AS hora
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TIPO_TRANSACCION, Contabilidad.TRANSACCION,
                    Bodega.FACTURA_HC, Bodega.CLIENTE
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO
                    AND TRANSACCION.TRA_CODIGO = FACTURA_HC.F_CODIGO
                    AND FACTURA_HC.CLI_NIT = CLIENTE.CLI_NIT
                    AND (TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."')
                    AND TRANSACCION_DETALLE.N_CODIGO = '".$Nombre."'
                    AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1
                   
                    UNION ALL

                    SELECT TRANSACCION_DETALLE.TRAD_CARGO_CONTA AS CARGOS, TRANSACCION_DETALLE.TRAD_ABONO_CONTA AS ABONOS, TIPO_TRANSACCION.TT_NOMBRE, TRANSACCION.TRA_FECHA_TRANS, TRANSACCION.TRA_CONCEPTO, TRANSACCION.TRA_SERIE, TRANSACCION.TRA_FACTURA,
                    '--' AS CLIENTE, TRANSACCION.TRA_FECHA_TRANS AS fech, TRANSACCION.TRA_HORA AS hora
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TIPO_TRANSACCION, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO
                    AND (TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaIni."' AND '".$FechaFin."')
                    AND TRANSACCION_DETALLE.N_CODIGO = '".$Nombre."'
                    AND TRANSACCION.TRA_CODIGO LIKE '%tra_%'
                    AND TRANSACCION.E_CODIGO = 2 AND TRANSACCION.TRA_ESTADO = 1

                    ORDER BY fech, hora";
$ResultAnterior = mysqli_query($db, $QueryAnterior);
while($FilaAnterior = mysqli_fetch_array($ResultAnterior))
{
    if($Nombre[0] == 1)
    {
        $Saldo = $FilaAnterior["CARGOS"] - $FilaAnterior["ABONOS"];    
    }
    else
    {
        $Saldo = $FilaAnterior["ABONOS"] - $FilaAnterior["CARGOS"];
    }
    $Cliente = $FilaAnterior["CLIENTE"];
    $SaldoFinal = $SaldoFinal + $Saldo;

    $Data[] = array('col1'=>date('d-m-Y', strtotime($FilaAnterior["TRA_FECHA_TRANS"])), 'colFactura'=>$FilaAnterior["TRA_SERIE"].'-'.$FilaAnterior["TRA_FACTURA"], 'colNombre'=>$Cliente, 'col2'=>utf8_decode($FilaAnterior["TT_NOMBRE"]), 'col3'=>utf8_decode($FilaAnterior["TRA_CONCEPTO"]), 'col4'=>number_format($FilaAnterior["CARGOS"], 2, '.', ','), 'col5'=>number_format($FilaAnterior["ABONOS"], 2, '.', ','), 'col6'=>number_format($SaldoFinal, 2, '.', ','));
}





$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>