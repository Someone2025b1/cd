<?php
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];
$Producto = $_POST["Producto"];
$Bodega = $_POST["Bodega"];

$NuevaFecha = $FechaIni;

$FechaFinal = date('Y-m-d', strtotime($FechaIni."-1 day"));

$TotalActivo = 0;
$TotalPasivo = 0;


$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Detalle de Existencia de Producto - ".saber_nombre_producto($Producto),16,array('justification'=>'center'));
$pdf->ezText("Del ".date('d-m-Y', strtotime($FechaIni))." Al ".date('d-m-Y', strtotime($FechaFin)),14,array('justification'=>'center'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>'Fecha', 'col2'=>'Entradas', 'col3'=>'Precio Entr.', 'col4'=>'Total Entr.', 'col5'=>'Salidas', 'col6'=>'Precio Sal.', 'col7'=>'Total Sal.', 'col8'=>'Existencia', 'col9'=>'Precio', 'col10'=>'Total');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>8, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/


//QUERY PARA TRAER TODO EL MOVIMIENTO DE LAS CUENTAS EN EL RANGO DE FECHAS SELECCIONADO

while($NuevaFecha <= $FechaFin)
{

    $Query = "SELECT * FROM Bodega.TRANSACCION
                WHERE (TT_CODIGO = 1 OR TT_CODIGO = 7 OR TT_CODIGO = 6 OR TT_CODIGO = 2)
                AND TRA_FECHA_TRANS = '".$NuevaFecha."'
                AND E_CODIGO = 1
                AND B_CODIGO = ".$Bodega."
                ORDER BY TRA_FECHA_TRANS, TT_CODIGO, TRA_HORA";

    $Result = mysqli_query($db, $Query);
    while($row = mysqli_fetch_array($Result))
    {
        $CodigoTransacion = $row["TRA_CODIGO"];

        if($row["TT_CODIGO"] == 1 OR $row["TT_CODIGO"] == 7)
        {
            $QueryDetalle = "SELECT * FROM Bodega.TRANSACCION_DETALLE
                            WHERE TRA_CODIGO = '".$CodigoTransacion."'
                            AND P_CODIGO = ".$Producto;
            $ResultDetalle = mysqli_query($db, $QueryDetalle);
            while($Fila = mysqli_fetch_array($ResultDetalle))
            {

                $UnidadesEntrada = $Fila["TRAD_CARGO_PRODUCTO"];
                $PrecioEntrada   = $Fila["TRAD_PRECIO_UNITARIO"];
                $TotalEntrada    = $UnidadesEntrada * $PrecioEntrada;

                $ExistenciaTotal = ($CostoTotalExistencia + $TotalEntrada);

                $SumaTotalEntrada = $SumaTotalEntrada + $UnidadesEntrada;

                $SumaCostoTotal = $SumaCostoTotal + $TotalEntrada;

                $CostoUnitarioExistencia = $ExistenciaTotal / $SumaTotalEntrada;

                $CostoTotalExistencia = $SumaTotalEntrada * $CostoUnitarioExistencia;

                $Data[] = array('col1'=>date('d-m-Y', strtotime($NuevaFecha)), 'col2'=>number_format($UnidadesEntrada, 2, '.', ','), 'col3'=>number_format($PrecioEntrada, 4, '.', ','), 'col4'=>number_format($TotalEntrada, 2, '.', ','), 'col5'=>'', 'col6'=>'', 'col7'=>'', 'col8'=>number_format($SumaTotalEntrada, 2, '.', ','), 'col9'=>number_format($CostoUnitarioExistencia, 4, '.', ','), 'col10'=>number_format($ExistenciaTotal, 2, '.', ','));

            }            
        }
        else
        {
            $QueryDetalle = "SELECT * FROM Bodega.TRANSACCION_DETALLE
                            WHERE TRA_CODIGO = '".$CodigoTransacion."'
                            AND P_CODIGO = ".$Producto;
            $ResultDetalle = mysqli_query($db, $QueryDetalle);
            while($Fila = mysqli_fetch_array($ResultDetalle))
            {

                $UnidadesSalida = $Fila["TRAD_ABONO_PRODUCTO"];
                $PrecioSalida   = $CostoUnitarioExistencia;
                $TotalSalida    = $UnidadesSalida * $PrecioSalida;

                $SumaTotalEntrada = $SumaTotalEntrada - $UnidadesSalida;
                $CostoUnitarioExistencia = $CostoUnitarioExistencia;
                $CostoTotalExistencia = $SumaTotalEntrada * $CostoUnitarioExistencia;

                $Data[] = array('col1'=>date('d-m-Y', strtotime($NuevaFecha)), 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>number_format($UnidadesSalida, 2, '.', ','), 'col6'=>number_format($PrecioSalida, 2, '.', ','), 'col7'=>number_format($TotalSalida, 2, '.', ','), 'col8'=>number_format($SumaTotalEntrada, 2, '.', ','), 'col9'=>number_format($CostoUnitarioExistencia, 4, '.', ','), 'col10'=>number_format($CostoTotalExistencia, 2, '.', ','));

            }  
        }
    }

    

   $NuevaFecha = date('Y-m-d', strtotime("$NuevaFecha + 1 day"));
}



$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>