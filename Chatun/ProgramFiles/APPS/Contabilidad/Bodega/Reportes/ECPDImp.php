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

$FechaFinal = date('Y-m-d', strtotime($FechaIni."-1 day"));

$TotalActivo = 0;
$TotalPasivo = 0;


$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Existencia de Productos por Clasificación"),16,array('justification'=>'center'));
$pdf->ezText("Del ".date('d-m-Y', strtotime($FechaIni))." Al ".date('d-m-Y', strtotime($FechaFin)),14,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
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
    $ProductoNombre = utf8_decode($row["P_NOMBRE"]);
    $UnidadMedida = $row["UM_NOMBRE"];

    if($row["CP_CODIGO"] == 'TR')
    {
        $query = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO` ) AS `CARGOS`, SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_PRODUCTO` ) AS `ABONOS`
        FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
        AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
        AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
        AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
        $rest = mysqli_query($db, $query);
        while($fila = mysqli_fetch_array($rest))
        {
            $Existencia = $fila["CARGOS"] - $fila["ABONOS"];
            $ExistenciaMost = number_format($Existencia, 4, '.', ',');
            
            $QueryCosto = "SELECT SUM(`TRANSACCION_DETALLE`.`TRAD_SUBTOTAL`) AS COSTO_TOTAL, SUM(`TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO`) AS TOTAL_ENTRADAS
                FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
                WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
                AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
                AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
                AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '2016/01/01' AND '".$FechaFin."'";
            $ResCosto = mysqli_query($db, $QueryCosto);
            while($filacosto = mysqli_fetch_array($ResCosto))
            {
                $CostoTotal = $filacosto["COSTO_TOTAL"];
                $Entradas = $filacosto["TOTAL_ENTRADAS"];
            }

            $CostoUnitario = $CostoTotal / $Entradas;
            $CostoUnitarioMostrar = number_format($CostoUnitario, 4, '.', ',');

            $CostoTotal2 = $Existencia * $CostoUnitario;
            $CostoTotalMostrar = number_format($CostoTotal2, 4, '.', ',');

           

            if($Existencia != 0)
            {
                $CostoTotalSumaTR = $CostoTotalSumaTR + $CostoTotal2;
                $DataTR[] = array('col1'=>$Producto, 'col2'=>$ProductoNombre, 'col3'=>$UnidadMedida, 'col4'=>$ExistenciaMost, 'col5'=>$CostoUnitarioMostrar, 'col6'=>$CostoTotalMostrar);
            }
            
        }   
    }
    elseif($row["CP_CODIGO"] == 'SV')
    {
        $query = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO` ) AS `CARGOS`, SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_PRODUCTO` ) AS `ABONOS`
        FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
        AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
        AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
        AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
        $rest = mysqli_query($db, $query);
        while($fila = mysqli_fetch_array($rest))
        {
            $Existencia = $fila["CARGOS"] - $fila["ABONOS"];
            $ExistenciaMost = number_format($Existencia, 4, '.', ',');
            
            $QueryCosto = "SELECT SUM(`TRANSACCION_DETALLE`.`TRAD_SUBTOTAL`) AS COSTO_TOTAL, SUM(`TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO`) AS TOTAL_ENTRADAS
                FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
                WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
                AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
                AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
                AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '2016/01/01' AND '".$FechaFin."'";
            $ResCosto = mysqli_query($db, $QueryCosto);
            while($filacosto = mysqli_fetch_array($ResCosto))
            {
                $CostoTotal = $filacosto["COSTO_TOTAL"];
                $Entradas = $filacosto["TOTAL_ENTRADAS"];
            }

            $CostoUnitario = $CostoTotal / $Entradas;
            $CostoUnitarioMostrar = number_format($CostoUnitario, 4, '.', ',');

            $CostoTotal2 = $Existencia * $CostoUnitario;
            $CostoTotalMostrar = number_format($CostoTotal2, 4, '.', ',');

           

            if($Existencia != 0)
            {
                $CostoTotalSumaSV = $CostoTotalSumaSV + $CostoTotal2;
                $DataSV[] = array('col1'=>$Producto, 'col2'=>$ProductoNombre, 'col3'=>$UnidadMedida, 'col4'=>$ExistenciaMost, 'col5'=>$CostoUnitarioMostrar, 'col6'=>$CostoTotalMostrar);
            }
            
        }   
    }
    if($row["CP_CODIGO"] == 'HS')
    {
        $query = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO` ) AS `CARGOS`, SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_PRODUCTO` ) AS `ABONOS`
        FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
        AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
        AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
        AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
        $rest = mysqli_query($db, $query);
        while($fila = mysqli_fetch_array($rest))
        {
            $Existencia = $fila["CARGOS"] - $fila["ABONOS"];
            $ExistenciaMost = number_format($Existencia, 4, '.', ',');
            
            $QueryCosto = "SELECT SUM(`TRANSACCION_DETALLE`.`TRAD_SUBTOTAL`) AS COSTO_TOTAL, SUM(`TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO`) AS TOTAL_ENTRADAS
                FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
                WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
                AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
                AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
                AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '2016/01/01' AND '".$FechaFin."'";
            $ResCosto = mysqli_query($db, $QueryCosto);
            while($filacosto = mysqli_fetch_array($ResCosto))
            {
                $CostoTotal = $filacosto["COSTO_TOTAL"];
                $Entradas = $filacosto["TOTAL_ENTRADAS"];
            }

            $CostoUnitario = $CostoTotal / $Entradas;
            $CostoUnitarioMostrar = number_format($CostoUnitario, 4, '.', ',');

            $CostoTotal2 = $Existencia * $CostoUnitario;
            $CostoTotalMostrar = number_format($CostoTotal2, 4, '.', ',');

           
            if($Existencia != 0)
            {
                $CostoTotalSumaHS = $CostoTotalSumaHS + $CostoTotal2;
                $DataHS[] = array('col1'=>$Producto, 'col2'=>$ProductoNombre, 'col3'=>$UnidadMedida, 'col4'=>$ExistenciaMost, 'col5'=>$CostoUnitarioMostrar, 'col6'=>$CostoTotalMostrar);
            }
            
        }   
    }

    
}

$DataTR[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'<b>TOTAL</b>', 'col6'=>number_format($CostoTotalSumaTR, 4, '.', ','));
$DataSV[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'<b>TOTAL</b>', 'col6'=>number_format($CostoTotalSumaSV, 4, '.', ','));
$DataHS[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'<b>TOTAL</b>', 'col6'=>number_format($CostoTotalSumaHS, 4, '.', ','));

$pdf->ezText(utf8_decode("Bodega Central - Terrazas"),16,array('justification'=>'center'));
$pdf->ezText("", 10);
$pdf->ezTable($DataTR, $Titulo,'', $Opciones);
$pdf->ezText("", 30);
#$pdf->ezText(utf8_decode("Bodega Central - Souvenirs"),16,array('justification'=>'center'));
#$pdf->ezText("", 10);
#$pdf->ezTable($DataSV, $Titulo,'', $Opciones);
#$pdf->ezText("", 30);
$pdf->ezText(utf8_decode("Bodega Central - Helados Sarita"),16,array('justification'=>'center'));
$pdf->ezText("", 10);
$pdf->ezTable($DataHS, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>