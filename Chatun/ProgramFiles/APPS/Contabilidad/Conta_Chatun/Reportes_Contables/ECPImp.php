<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];
$CostoTotalTotal = 0;

$FechaFinal = date('Y-m-d', strtotime($FechaIni."-1 day"));

$TotalActivo = 0;
$TotalPasivo = 0;


$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode(""),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode(""),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode(""),22,array('justification'=>'center'));
$pdf->ezText("",16,array('justification'=>'center'));
$pdf->ezText("Existencia de Producto al ".date('d-m-Y', strtotime($FechaFin)),14,array('justification'=>'center'));
$pdf->ezText("Cifras Expresadas en Quetzales",14,array('justification'=>'center'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>utf8_decode('Código'), 'col2'=>'Nombre', 'col3'=>'Unidad de Medida', 'col4'=>'Cantidad', 'col5'=>'Costo Unitario', 'col6'=>'Costo Total');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/


//QUERY PARA TRAER TODO EL MOVIMIENTO DE LAS CUENTAS EN EL RANGO DE FECHAS SELECCIONADO
$QueryCuentas = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE 
                FROM Bodega.PRODUCTO, Bodega.UNIDAD_MEDIDA 
                WHERE PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
                GROUP BY PRODUCTO.P_NOMBRE ORDER BY PRODUCTO.P_NOMBRE";
$ResultCuentas = mysqli_query($db, $QueryCuentas);
while($row = mysqli_fetch_array($ResultCuentas))
{
    $ExistenciaMost = 0;
    $Producto = $row["P_CODIGO"];
    $ProductoNombre = $row["P_NOMBRE"];
    $UnidadMedida = $row["UM_NOMBRE"];

    $query = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO` ) AS `CARGOS`, SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_PRODUCTO` ) AS `ABONOS`
    FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
    WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
    AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
    AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '".$FechaIni."' AND '".$FechaFin."'
    AND TRANSACCION.E_CODIGO = 1";
    $rest = mysqli_query($db, $query);
    while($fila = mysqli_fetch_array($rest))
    {
        $Existencia = $fila["CARGOS"] - $fila["ABONOS"];
        $ExistenciaMost = number_format($Existencia, 2, '.', ',');
        
        $QueryCosto = "SELECT SUM(`TRANSACCION_DETALLE`.`TRAD_SUBTOTAL`) AS COSTO_TOTAL, SUM(`TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO`) AS TOTAL_ENTRADAS
            FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
            WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
            AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
            AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '2016/01/01' AND '".$FechaFin."'
            AND TRANSACCION.E_CODIGO = 1";
        $ResCosto = mysqli_query($db, $QueryCosto);
        while($filacosto = mysqli_fetch_array($ResCosto))
        {
            $CostoTotal = $filacosto["COSTO_TOTAL"];
            $Entradas = $filacosto["TOTAL_ENTRADAS"];
        }

        $CostoUnitario = $CostoTotal / $Entradas;
        $CostoUnitarioMostrar = number_format($CostoUnitario, 2, '.', ',');

        $CostoTotal2 = $Existencia * $CostoUnitario;
        $CostoTotalMostrar = number_format($CostoTotal2, 2, '.', ',');

        $CostoTotalTotal = $CostoTotalTotal + $CostoTotal2;

        if($Existencia != 0)
        {
            $Data[] = array('col1'=>$Producto, 'col2'=>$ProductoNombre, 'col3'=>$UnidadMedida, 'col4'=>$ExistenciaMost, 'col5'=>$CostoUnitarioMostrar, 'col6'=>$CostoTotalMostrar);
        }
        
    }

    
}

$CostoTotalTotal = number_format($CostoTotalTotal, 2, '.', ',');

$Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'TOTAL', 'col6'=>$CostoTotalTotal);



$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>