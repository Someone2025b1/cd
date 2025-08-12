<?php
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));
$CostoTotalSuma = 0;

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];
$Bodega   = $_POST["Bodega"];

$NuevaFecha = $FechaIni;

$FechaFinal = date('Y-m-d', strtotime($FechaIni."-1 day"));

$TotalActivo = 0;
$TotalPasivo = 0;


$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Movimiento de Bodega",16,array('justification'=>'center'));
$pdf->ezText("Del ".date('d-m-Y', strtotime($FechaIni))." Al ".date('d-m-Y', strtotime($FechaFin)),14,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>'No.', 'col2'=>'Fecha', 'col3'=>'Tipo', 'col4'=>'Producto', 'col5'=>'Ingresos', 'col6'=>'Egresos');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/

$Consulta = "SELECT TRANSACCION.TRA_FECHA_TRANS, TRANSACCION_DETALLE.TRAD_CARGO_PRODUCTO, TRANSACCION_DETALLE.TRAD_ABONO_PRODUCTO, TIPO_TRANSACCION.TT_NOMBRE, PRODUCTO.P_NOMBRE 
            FROM Bodega.TRANSACCION, Bodega.TRANSACCION_DETALLE, Bodega.TIPO_TRANSACCION, Bodega.PRODUCTO
            WHERE TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO
            AND TRANSACCION.TT_CODIGO = TIPO_TRANSACCION.TT_CODIGO
            AND TRANSACCION_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
            AND (TRANSACCION.TT_CODIGO = 1 OR TRANSACCION.TT_CODIGO = 2 OR TRANSACCION.TT_CODIGO = 5 OR TRANSACCION.TT_CODIGO = 6 OR TRANSACCION.TT_CODIGO = 7 OR TRANSACCION.TT_CODIGO = 9)
            AND TRANSACCION.B_CODIGO = ".$Bodega."
            AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$_POST["FechaInicio"]."' AND '".$_POST["FechaFin"]."'
            ORDER BY TRANSACCION.TRA_FECHA_TRANS, TRANSACCION.TRA_HORA";
$Resultado = mysqli_query($db,$Consulta);
while($row = mysqli_fetch_array($Resultado))
{
    $Fecha = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
    $Tipo     = $row["TT_NOMBRE"];
    $Producto     = $row["P_NOMBRE"];
    $Ingresos = $row["TRAD_CARGO_PRODUCTO"];
    $Egresos  = $row["TRAD_ABONO_PRODUCTO"];
    $Saldo    = $Ingresos - $Egresos;
    $SaldoTotal = $SaldoTotal + $Saldo;

    $Data[] = array('col1'=>$i, 'col2'=>$Fecha, 'col3'=>$Tipo, 'col4'=>$Producto, 'col5'=>$Ingresos, 'col6'=>$Egresos);

    $i++;
}





$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>