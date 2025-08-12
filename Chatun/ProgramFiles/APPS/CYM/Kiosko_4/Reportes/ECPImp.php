<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));
$CostoTotalSuma = 0;

$FechaIni = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];
$Bodega   = $_POST["Bodega"];

$NuevaFecha = $FechaIni;
$NombreBodega = saber_nombre_bodega($Bodega);

$MesAnterior = date('m', strtotime($FechaIni)) - 1;
$Anho = date('Y', strtotime($FechaIni));

function _data_last_month_day($Mes, $Anho) { 
      $month = $Mes;
      $year = $Anho;
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
 
      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  };
 
  /** Actual month first day **/
  function _data_first_month_day($Mes, $Anho) {
      $month = $Mes;
      $year = $Anho;
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }

$PrimerDiaMesAnterior = _data_first_month_day($MesAnterior, $Anho);
$PrimerDiaMesAnteriorF = date('Y-m-d', strtotime($PrimerDiaMesAnterior));


$UltimoDiaMesAnterior = _data_last_month_day($MesAnterior, $Anho);
$UltimoDiaMesAnteriorF = date('Y-m-d', strtotime($UltimoDiaMesAnterior));

$FechaFinal = date('Y-m-d', strtotime($FechaIni."-1 day"));

$TotalActivo = 0;
$TotalPasivo = 0;


$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Existencia de Productos - ".$NombreBodega,16,array('justification'=>'center'));
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
$ResultCuentas = mysqli_query($db,$QueryCuentas);
while($row = mysqli_fetch_array($ResultCuentas))
{
    $NuevaFecha = $FechaIni;
    $ExistenciaMost = 0;
    $Producto = $row["P_CODIGO"];
    $ProductoNombre = $row["P_NOMBRE"];
    $UnidadMedida = $row["UM_NOMBRE"];

    $query = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO` ) AS `CARGOS`, SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_PRODUCTO` ) AS `ABONOS`
    FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
    WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
    AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
    AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
    AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
    $rest = mysqli_query($db,$query);
    while($fila = mysqli_fetch_array($rest))
    {

        $Existencia = (($fila["CARGOS"] - $fila["ABONOS"]));
        $ExistenciaMost = number_format($Existencia, 2, '.', ',');
        

        $Query = "SELECT SUM(TRANSACCION_DETALLE.TRAD_SUBTOTAL) AS TOTAL, SUM(TRANSACCION_DETALLE.TRAD_CARGO_PRODUCTO) AS ENTRADAS 
        FROM Bodega.TRANSACCION, Bodega.TRANSACCION_DETALLE
        WHERE TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
        AND (TRANSACCION.TT_CODIGO = 1 OR TRANSACCION.TT_CODIGO = 7)
        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2016/01/01' AND '".$FechaFin."'
        AND TRANSACCION.E_CODIGO = 1
        AND TRANSACCION.B_CODIGO = 4
        AND TRANSACCION_DETALLE.P_CODIGO = ".$Producto."
        ORDER BY TRANSACCION.TRA_FECHA_TRANS, TRANSACCION.TT_CODIGO, TRANSACCION.TRA_HORA";

        $Result = mysqli_query($db,$Query);
        while($row = mysqli_fetch_array($Result))
        {

            $CostoUnitarioExistencia = $row["TOTAL"] / $row["ENTRADAS"];

        }

        $CostoUnitario = $CostoTotal / $Entradas;
        $CostoUnitarioMostrar = number_format($CostoUnitarioExistencia, 4, '.', ',');

        $CostoTotal2 = $Existencia * $CostoUnitarioExistencia;
        $CostoTotalMostrar = number_format($CostoTotal2, 4, '.', ',');

        $CostoTotalSuma = $CostoTotalSuma + $CostoTotal2;

        if($Existencia != 0)
        {
            $Data[] = array('col1'=>$Producto, 'col2'=>$ProductoNombre, 'col3'=>$UnidadMedida, 'col4'=>$ExistenciaMost, 'col5'=>$CostoUnitarioMostrar, 'col6'=>$CostoTotalMostrar);
        }
        
    }

    
}

$Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'<b>TOTAL</b>', 'col6'=>number_format($CostoTotalSuma, 4, '.', ','));


$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>