<?php
ob_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));

$FechaInicio = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];
$FechaFinal = date('Y-m-d', strtotime($FechaInicio) - '1 day');
$Total = 100;
$TotalM = number_format($Total, 2, '.', ',');

$TipoReporte = $_POST["TipoReporte"];

$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode(""),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode(""),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode(""),22,array('justification'=>'center'));
$pdf->ezText("",16,array('justification'=>'center'));
$pdf->ezText("Estado de Resultados General",14,array('justification'=>'center'));
$pdf->ezText("del ".date('d-m-Y', strtotime($FechaInicio))." al ".date('d-m-Y', strtotime($FechaFin)),14,array('justification'=>'center'));
$pdf->ezText("Cifras Expresadas en Quetzales",14,array('justification'=>'center'));
$pdf->ezText("", 14);

/*TITULOS PARA TABLA DE RESUMEN*/
    $TituloResumen = array('col1'=>'Resumen', 'col2'=>'Acumulado', 'col3'=>'Mes', 'col4'=>'%', 'col5'=>'Total', 'col6'=>'%');
/*FIN TITULOS PARA TABLA DE RESUMEN*/

/*OPCIONES PARA TABLA DE RESUMEN*/
    $OpcionesResumen = array('fontSize'=>8, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES PARA TABLA DE RESUMEN*/

/*TITULOS PARA TABLA DE DETALLE*/
    $TituloDetalle = array('col1'=>'Detalle', 'col2'=>'Acumulado', 'col3'=>'Mes', 'col4'=>'%', 'col5'=>'Total', 'col6'=>'%');
/*FIN TITULOS PARA TABLA DE DETALLE*/

/*OPCIONES PARA TABLA DE DETALLE*/
    $OpcionesDetalle = array('fontSize'=>8, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES PARA TABLA DE DETALLE*/

/*************************************************
**************************************************
                    INGRESOS
**************************************************
*************************************************/
if(isset($_POST["Cierre"]))
    {
        $Cierre = 29;
    }
    else
    {
        $Cierre = 0;
    }


/*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
    
    if($Cierre == 0)
    {
        $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
    }
    else
    {
        $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                    AND TRANSACCION.TT_CODIGO <> 29";
    }
    $ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
    $FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
    $CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
    $AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
    $TotalIngresosAcumulado      = $AbonosIngresoTotalAcumulado - $CargosIngresoTotalAcumulado;
    $TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
/*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

/*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
    if($Cierre == 0)
    {
        $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
    }
    else
    {
        $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                    AND TRANSACCION.TT_CODIGO <> 29";
    }
    $ResultIngresoTotalMes = mysqli_query($db, $IngresoTotalMes);
    $FilaIngresoTotalMes   = mysqli_fetch_array($ResultIngresoTotalMes);
    $CargosIngresoTotalMes = $FilaIngresoTotalMes["CARGOS"];
    $AbonosIngresoTotalMes = $FilaIngresoTotalMes["ABONOS"];
    $TotalIngresosMes      = $AbonosIngresoTotalMes - $CargosIngresoTotalMes;
    $CienPorCiento         = $TotalIngresosMes;
    $TotalIngresosMesM     = number_format($TotalIngresosMes, 2, '.', ',');
/*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

/*SUMA DE TOTAL RESUMEN*/
    $SumaTotalResumen = $TotalIngresosAcumulado + $TotalIngresosMes;
    $SumaTotalResumenM     = number_format($SumaTotalResumen, 2, '.', ',');
/*FIN SUMA DE TOTAL RESUMEN*/


/*************************************************
**************************************************
                    COSTOS
**************************************************
*************************************************/


/*QUERY PARA SABER LOS COSTOS TOTALES ACUMULADOS*/
    if($Cierre == 0)
    {
        $CostoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.00.00.000' AND '5.99.99.999'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                        AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
    }
    else
    {
        $CostoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.00.00.000' AND '5.99.99.999'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                        AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION.TT_CODIGO <> 29";
    }
    $ResultCostoTotalAcumulado = mysqli_query($db, $CostoTotalAcumulado);
    $FilaCostoTotalAcumulado   = mysqli_fetch_array($ResultCostoTotalAcumulado);
    $CargosCostoTotalAcumulado = $FilaCostoTotalAcumulado["CARGOS"];
    $AbonosCostoTotalAcumulado = $FilaCostoTotalAcumulado["ABONOS"];
    $TotalCostoTotalAcumulado      = $CargosCostoTotalAcumulado - $AbonosCostoTotalAcumulado;
    $TotalCostoTotalAcumuladoM     = number_format($TotalCostoTotalAcumulado, 2, '.', ',');
/*FIN QUERY PARA SABER LOS COSTOS TOTALES ACUMULADOS*/

/*QUERY PARA SABER LOS INGRESOS TOTALES DEL MES*/
    if($Cierre == 0)
    {
        $CostoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.00.00.000' AND '5.99.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
    }
    else
    {
        $CostoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.00.00.000' AND '5.99.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                    AND TRANSACCION.TT_CODIGO <> 29";
    }
    $ResultCostoTotalMes = mysqli_query($db, $CostoTotalMes);
    $FilaCostoTotalMes   = mysqli_fetch_array($ResultCostoTotalMes);
    $CargosCostoTotalMes = $FilaCostoTotalMes["CARGOS"];
    $AbonosCostoTotalMes = $FilaCostoTotalMes["ABONOS"];
    $TotalCostoTotalMes      = $CargosCostoTotalMes - $AbonosCostoTotalMes;
    $TotalCostoTotalMesM     = number_format($TotalCostoTotalMes, 2, '.', ',');
/*FIN QUERY PARA SABER LOS INGRESOS TOTALES DEL MES*/

/*CALCULO DE PORCENTAJE DE COSTOS*/
    $PorcentajeCostoAcumulado = ($Total * $TotalCostoTotalMes) / $TotalIngresosMes;
    $PorcentajeCostoAcumuladoM = number_format($PorcentajeCostoAcumulado, 2, '.', ',');
/*CALCULO DE PORCENTAJE DE COSTOS*/

/*SUMA TOTAL DE COSTOS*/
    $TotalCostosSuma = $TotalCostoTotalAcumulado + $TotalCostoTotalMes;
    $TotalCostosSumaM = number_format($TotalCostosSuma, 2, '.', ',');
/*FIN SUMA TOTAL DE COSTOS*/

/*CALCULO DE PORCENTAJE DE TOTAL DE COSTOS*/
    $PorcentajeCostosTotal = ($Total * $TotalCostosSuma) / $SumaTotalResumen; 
    $PorcentajeCostosTotalM = number_format($PorcentajeCostosTotal, 2, '.', ',');
/*FIN CALCULO DE PORCENTAJE DE TOTAL DE COSTOS*/

/*************************************************
**************************************************
                UTILIDAD BRUTA
**************************************************
*************************************************/

/*RESTA DE UTILIDAD BRUTA DE ACUMULADO*/
    $TotalUtilidadBrutaAcumulado = $TotalIngresosAcumulado - $TotalCostoTotalAcumulado;
    $TotalUtilidadBrutaAcumuladoM = number_format($TotalUtilidadBrutaAcumulado, 2, '.', ',');
/*FIN RESTA DE UTILIDAD BRUTA DE ACUMULADO*/

/*RESTA DE UTILIDAD BRUTA DE MES*/
    $TotalUtilidadBrutaMes = $TotalIngresosMes - $TotalCostoTotalMes;
    $TotalUtilidadBrutaMesM = number_format($TotalUtilidadBrutaMes, 2, '.', ',');
/*FIN RESTA DE UTILIDAD BRUTA DE MES*/

/*RESTA DE UTILIDAD BRUTA DE MES*/
    $TotalUtilidadBrutaPorcentaje = $Total - $PorcentajeCostoAcumulado;
    $TotalUtilidadBrutaPorcentajeM = number_format($TotalUtilidadBrutaPorcentaje, 2, '.', ',');
/*FIN RESTA DE UTILIDAD BRUTA DE MES*/

/*RESTA DE UTILIDAD BRUTA DE MES*/
    $TotalUtilidadBrutaTotal = $SumaTotalResumen - $TotalCostosSuma;
    $TotalUtilidadBrutaTotalM = number_format($TotalUtilidadBrutaTotal, 2, '.', ',');
/*FIN RESTA DE UTILIDAD BRUTA DE MES*/

/*RESTA DE UTILIDAD BRUTA DE MES*/
    $TotalUtilidadBrutaTotalPorcentaje = $Total - $PorcentajeCostosTotal;
    $TotalUtilidadBrutaTotalPorcentajeM = number_format($TotalUtilidadBrutaTotalPorcentaje, 2, '.', ',');
/*FIN RESTA DE UTILIDAD BRUTA DE MES*/

/*************************************************
**************************************************
                    GASTOS
**************************************************
*************************************************/

/*QUERY PARA SABER LOS GASTOS TOTALES ACUMULADOS*/
    if($Cierre == 0)
    {
        $GastoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND ((TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND  '5.02.99.999')
                    OR (TRANSACCION_DETALLE.N_CODIGO BETWEEN '6.00.00.000' AND  '9.99.99.999'))
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
    }
    else
    {
        $GastoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND ((TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND  '5.02.99.999')
                    OR (TRANSACCION_DETALLE.N_CODIGO BETWEEN '6.00.00.000' AND  '9.99.99.999'))
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                    AND TRANSACCION.TT_CODIGO <> 29";
    }
    $ResultGastoTotalAcumulado = mysqli_query($db, $GastoTotalAcumulado);
    $FilaGastoTotalAcumulado   = mysqli_fetch_array($ResultGastoTotalAcumulado);
    $CargosGastoTotalAcumulado = $FilaGastoTotalAcumulado["CARGOS"];
    $AbonosGastoTotalAcumulado = $FilaGastoTotalAcumulado["ABONOS"];
    $TotalGastoTotalAcumulado      = $CargosGastoTotalAcumulado - $AbonosGastoTotalAcumulado;
    $TotalGastoTotalAcumuladoM     = number_format($TotalGastoTotalAcumulado, 2, '.', ',');
/*FIN QUERY PARA SABER LOS GASTOS TOTALES ACUMULADOS*/

/*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
    if($Cierre == 0)
    {
        $GastoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND ((TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND  '5.02.99.999')
                    OR (TRANSACCION_DETALLE.N_CODIGO BETWEEN '6.00.00.000' AND  '9.99.99.999'))
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
    }
    else
    {
        $GastoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                    AND ((TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND  '5.02.99.999')
                    OR (TRANSACCION_DETALLE.N_CODIGO BETWEEN '6.00.00.000' AND  '9.99.99.999'))
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                    AND TRANSACCION.TT_CODIGO <> 29";
    }
    $ResultGastoTotalMes = mysqli_query($db, $GastoTotalMes);
    $FilaGastoTotalMes   = mysqli_fetch_array($ResultGastoTotalMes);
    $CargosGastoTotalMes = $FilaGastoTotalMes["CARGOS"];
    $AbonosGastoTotalMes = $FilaGastoTotalMes["ABONOS"];
    $TotalGastoTotalMes      = $CargosGastoTotalMes - $AbonosGastoTotalMes;
    $TotalGastoTotalMesM     = number_format($TotalGastoTotalMes, 2, '.', ',');
/*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

/*PORCENTAJE DE GASTO*/
    $PorcentajeGasto = ($Total * $TotalGastoTotalMes) / $TotalIngresosMes;
    $PorcentajeGastoM = number_format($PorcentajeGasto, 2, '.', ',');
/*FIN PORCENTAJE DE GASTO*/

/*PORCENTAJE DE GASTO*/
    $SumaTotalGasto = $TotalGastoTotalAcumulado + $TotalGastoTotalMes;
    $SumaTotalGastoM = number_format($SumaTotalGasto, 2, '.', ',');
/*FIN PORCENTAJE DE GASTO*/

/*PORCENTAJE TOTAL DE GASTO*/
    $PorcentajeTotalGasto = ($Total * $SumaTotalGasto) / $SumaTotalResumen;
    $PorcentajeTotalGastoM = number_format($PorcentajeTotalGasto, 2, '.', ',');
/*FIN PORCENTAJE TOTAL DE GASTO*/

/*************************************************
**************************************************
                UTILIDAD NETA
**************************************************
*************************************************/
/*TOTAL ACUMULADO UTILIDAD NETA*/
    $TotalAcumuladoUtilidadNeta = ($TotalUtilidadBrutaAcumulado - $TotalGastoTotalAcumulado);
    $TotalAcumuladoUtilidadNetaM = number_format($TotalAcumuladoUtilidadNeta, 2, '.', ',');
/*FIN TOTAL ACUMULADO UTILIDAD NETA*/

/*TOTAL MES UTILIDAD NETA*/
    $TotalMesUtilidadNeta = ($TotalUtilidadBrutaMes - $TotalGastoTotalMes);
    $TotalMesUtilidadNetaM = number_format($TotalMesUtilidadNeta, 2, '.', ',');
/*FIN TOTAL MES UTILIDAD NETA*/

/*TOTAL PORCENTAJE UTILIDAD NETA*/
    $TotalPorcentajeUtilidadNeta = ($TotalUtilidadBrutaPorcentaje - $PorcentajeGasto);
    $TotalPorcentajeUtilidadNetaM = number_format($TotalPorcentajeUtilidadNeta, 2, '.', ',');
/*FIN TOTAL PORCENTAJE UTILIDAD NETA*/

/*TOTAL TOTAL UTILIDAD NETA*/
    $TotalTotalUtilidadNeta = ($TotalUtilidadBrutaTotal - $SumaTotalGasto);
    if($FechaFin == "2022-12-31"){

        $TotalTotalUtilidadNeta-=0.01;
    }
    $TotalTotalUtilidadNetaM = number_format($TotalTotalUtilidadNeta, 2, '.', ',');
/*FIN TOTAL TOTAL UTILIDAD NETA*/

/*TOTAL TOTAL UTILIDAD NETA*/
    $TotalTotalPorcentajeUtilidadNeta = ($TotalUtilidadBrutaTotalPorcentaje - $PorcentajeTotalGasto);
    $TotalTotalPorcentajeUtilidadNetaM = number_format($TotalTotalPorcentajeUtilidadNeta, 2, '.', ',');
/*FIN TOTAL TOTAL UTILIDAD NETA*/

//Línea en tabla de Ingresos
$DataResumen[] = array('col1'=>'Ventas', 'col2'=>$TotalIngresosAcumuladoM, 'col3'=>$TotalIngresosMesM, 'col4'=>$TotalM, 'col5'=>$SumaTotalResumenM, 'col6'=>$TotalM);
//Línea en tabla de Costos
$DataResumen[] = array('col1'=>'(-)Costos de Ventas', 'col2'=>$TotalCostoTotalAcumuladoM, 'col3'=>$TotalCostoTotalMesM, 'col4'=>$PorcentajeCostoAcumuladoM, 'col5'=>$TotalCostosSumaM, 'col6'=>$PorcentajeCostosTotalM);
//Línea en tabla de Utilidad Bruta
$DataResumen[] = array('col1'=>'UTILIDAD BRUTA', 'col2'=>$TotalUtilidadBrutaAcumuladoM, 'col3'=>$TotalUtilidadBrutaMesM, 'col4'=>$TotalUtilidadBrutaPorcentajeM, 'col5'=>$TotalUtilidadBrutaTotalM, 'col6'=>$TotalUtilidadBrutaTotalPorcentajeM);
//Línea en tabla de Gastos
$DataResumen[] = array('col1'=>'(-)Gastos', 'col2'=>$TotalGastoTotalAcumuladoM, 'col3'=>$TotalGastoTotalMesM, 'col4'=>$PorcentajeGastoM, 'col5'=>$SumaTotalGastoM, 'col6'=>$PorcentajeTotalGastoM);
//Línea en tabla de Utilidad Neta
$DataResumen[] = array('col1'=>'UTILIDAD NETA', 'col2'=>$TotalAcumuladoUtilidadNetaM, 'col3'=>$TotalMesUtilidadNetaM, 'col4'=>$TotalPorcentajeUtilidadNetaM, 'col5'=>$TotalTotalUtilidadNetaM, 'col6'=>$TotalTotalPorcentajeUtilidadNetaM);


/*************************************************
**************************************************
                DETALLE DE INGRESOS
**************************************************
*************************************************/

//QUERY PARA TRAER TODAS LAS CUENTAS DE INGRESOS
$QueryDetalleIngresos = "SELECT * FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO BETWEEN  '4.00.00.000' AND  '4.99.99.999' ";
$ResultDetalleIngresos = mysqli_query($db, $QueryDetalleIngresos);
while($FilaDetalleIngresos = mysqli_fetch_array($ResultDetalleIngresos))
{
    if($TipoReporte == 1)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS INGRESOS
            **************************************************
            *************************************************/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
                $CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
                $AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
                $TotalIngresosAcumulado      = $AbonosIngresoTotalAcumulado - $CargosIngresoTotalAcumulado;
                $TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes   = mysqli_fetch_array($ResultIngresoTotalMes);
                $CargosIngresoTotalMes = $FilaIngresoTotalMes["CARGOS"];
                $AbonosIngresoTotalMes = $FilaIngresoTotalMes["ABONOS"];
                $TotalIngresosMes      = $AbonosIngresoTotalMes - $CargosIngresoTotalMes;
                $CienPorCientoMes      = $TotalIngresosMes;
                $TotalIngresosMesM     = number_format($TotalIngresosMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen = $TotalIngresosAcumulado + $TotalIngresosMes;
                $CienPorCientoTotal = $SumaTotalResumen;
                $SumaTotalResumenM     = number_format($SumaTotalResumen, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/
            
            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumen != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumuladoM, 'col3'=>$TotalIngresosMesM, 'col4'=>$TotalM, 'col5'=>$SumaTotalResumenM, 'col6'=>$TotalM);
            }

        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $AbonosIngresoCuentaGrupo - $CargosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $AbonosIngresoCuentaGrupoMes - $CargosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO SUBGRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'S')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].".".$CodigoExplotado[2].'.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $AbonosIngresoCuentaGrupo - $CargosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $AbonosIngresoCuentaGrupoMes - $CargosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {

                $DataDetalle[] = array('col1'=>"    --".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO CUENTA
        else
        {
            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $AbonosIngresoCuentaGrupo - $CargosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $AbonosIngresoCuentaGrupoMes - $CargosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"       ---".$CodigoCuenta.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }

        }
    }
    elseif($TipoReporte == 2)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS INGRESOS
            **************************************************
            *************************************************/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
                $CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
                $AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
                $TotalIngresosAcumulado      = $AbonosIngresoTotalAcumulado - $CargosIngresoTotalAcumulado;
                $TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes   = mysqli_fetch_array($ResultIngresoTotalMes);
                $CargosIngresoTotalMes = $FilaIngresoTotalMes["CARGOS"];
                $AbonosIngresoTotalMes = $FilaIngresoTotalMes["ABONOS"];
                $TotalIngresosMes      = $AbonosIngresoTotalMes - $CargosIngresoTotalMes;
                $CienPorCientoMes      = $TotalIngresosMes;
                $TotalIngresosMesM     = number_format($TotalIngresosMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen = $TotalIngresosAcumulado + $TotalIngresosMes;
                $CienPorCientoTotal = $SumaTotalResumen;
                $SumaTotalResumenM     = number_format($SumaTotalResumen, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/
            
            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumen != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumuladoM, 'col3'=>$TotalIngresosMesM, 'col4'=>$TotalM, 'col5'=>$SumaTotalResumenM, 'col6'=>$TotalM);
            }

        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $AbonosIngresoCuentaGrupo - $CargosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $AbonosIngresoCuentaGrupoMes - $CargosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO SUBGRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'S')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].".".$CodigoExplotado[2].'.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $AbonosIngresoCuentaGrupo - $CargosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $AbonosIngresoCuentaGrupoMes - $CargosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {

                $DataDetalle[] = array('col1'=>"    --".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
    }
    elseif($TipoReporte == 3)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS INGRESOS
            **************************************************
            *************************************************/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
                $CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
                $AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
                $TotalIngresosAcumulado      = $AbonosIngresoTotalAcumulado - $CargosIngresoTotalAcumulado;
                $TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes   = mysqli_fetch_array($ResultIngresoTotalMes);
                $CargosIngresoTotalMes = $FilaIngresoTotalMes["CARGOS"];
                $AbonosIngresoTotalMes = $FilaIngresoTotalMes["ABONOS"];
                $TotalIngresosMes      = $AbonosIngresoTotalMes - $CargosIngresoTotalMes;
                $CienPorCientoMes      = $TotalIngresosMes;
                $TotalIngresosMesM     = number_format($TotalIngresosMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen = $TotalIngresosAcumulado + $TotalIngresosMes;
                $CienPorCientoTotal = $SumaTotalResumen;
                $SumaTotalResumenM     = number_format($SumaTotalResumen, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/
            
            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumen != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumuladoM, 'col3'=>$TotalIngresosMesM, 'col4'=>$TotalM, 'col5'=>$SumaTotalResumenM, 'col6'=>$TotalM);
            }

        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $AbonosIngresoCuentaGrupo - $CargosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $AbonosIngresoCuentaGrupoMes - $CargosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
    }
}

/*************************************************
**************************************************
                DETALLE DE COSTOS
**************************************************
*************************************************/

//QUERY PARA TRAER TODAS LAS CUENTAS DE INGRESOS
$QueryDetalleIngresos = "SELECT * FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO BETWEEN  '5.03.00.000' AND  '5.03.99.999' ";
$ResultDetalleIngresos = mysqli_query($db, $QueryDetalleIngresos);
while($FilaDetalleIngresos = mysqli_fetch_array($ResultDetalleIngresos))
{
    if($TipoReporte == 1)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS COSTOS
            **************************************************
            *************************************************/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                    AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
                $CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
                $AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
                $TotalIngresosAcumulado      = $CargosIngresoTotalAcumulado - $AbonosIngresoTotalAcumulado;
                $TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes   = mysqli_fetch_array($ResultIngresoTotalMes);
                $CargosIngresoTotalMes = $FilaIngresoTotalMes["CARGOS"];
                $AbonosIngresoTotalMes = $FilaIngresoTotalMes["ABONOS"];
                $TotalIngresosMes      = $CargosIngresoTotalMes - $AbonosIngresoTotalMes;
                $TotalIngresosMesM     = number_format($TotalIngresosMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen = $TotalIngresosAcumulado + $TotalIngresosMes;
                $SumaTotalResumenM     = number_format($SumaTotalResumen, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumen != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumuladoM, 'col3'=>$TotalIngresosMesM, 'col4'=>$TotalM, 'col5'=>$SumaTotalResumenM, 'col6'=>$TotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {     
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO SUBGRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'S')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].".".$CodigoExplotado[2].'.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {         
                $DataDetalle[] = array('col1'=>"    --".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO CUENTA
        else
        {
            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"       ---".$CodigoCuenta.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }

        }
    }
    elseif($TipoReporte == 2)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS COSTOS
            **************************************************
            *************************************************/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
                $CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
                $AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
                $TotalIngresosAcumulado      = $CargosIngresoTotalAcumulado - $AbonosIngresoTotalAcumulado;
                $TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                   $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29"; 
                }
                $ResultIngresoTotalMes = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes   = mysqli_fetch_array($ResultIngresoTotalMes);
                $CargosIngresoTotalMes = $FilaIngresoTotalMes["CARGOS"];
                $AbonosIngresoTotalMes = $FilaIngresoTotalMes["ABONOS"];
                $TotalIngresosMes      = $CargosIngresoTotalMes - $AbonosIngresoTotalMes;
                $TotalIngresosMesM     = number_format($TotalIngresosMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen = $TotalIngresosAcumulado + $TotalIngresosMes;
                $SumaTotalResumenM     = number_format($SumaTotalResumen, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumen != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumuladoM, 'col3'=>$TotalIngresosMesM, 'col4'=>$TotalM, 'col5'=>$SumaTotalResumenM, 'col6'=>$TotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {     
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO SUBGRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'S')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].".".$CodigoExplotado[2].'.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {         
                $DataDetalle[] = array('col1'=>"    --".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
    }
    elseif($TipoReporte == 3)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS COSTOS
            **************************************************
            *************************************************/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
                $CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
                $AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
                $TotalIngresosAcumulado      = $CargosIngresoTotalAcumulado - $AbonosIngresoTotalAcumulado;
                $TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.03.00.000' AND '5.03.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes   = mysqli_fetch_array($ResultIngresoTotalMes);
                $CargosIngresoTotalMes = $FilaIngresoTotalMes["CARGOS"];
                $AbonosIngresoTotalMes = $FilaIngresoTotalMes["ABONOS"];
                $TotalIngresosMes      = $CargosIngresoTotalMes - $AbonosIngresoTotalMes;
                $TotalIngresosMesM     = number_format($TotalIngresosMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen = $TotalIngresosAcumulado + $TotalIngresosMes;
                $SumaTotalResumenM     = number_format($SumaTotalResumen, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumen != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumuladoM, 'col3'=>$TotalIngresosMesM, 'col4'=>$TotalM, 'col5'=>$SumaTotalResumenM, 'col6'=>$TotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {     
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
    }
}

/*************************************************
**************************************************
                DETALLE DE GASTOS 1
**************************************************
*************************************************/

//QUERY PARA TRAER TODAS LAS CUENTAS DE INGRESOS
$QueryDetalleIngresos = "SELECT * FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO BETWEEN  '5.02.00.000' AND  '5.02.99.999' ";
$ResultDetalleIngresos = mysqli_query($db, $QueryDetalleIngresos);
while($FilaDetalleIngresos = mysqli_fetch_array($ResultDetalleIngresos))
{
    if($TipoReporte == 1)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS COSTOS
            **************************************************
            *************************************************/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
                $CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
                $AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
                $TotalIngresosAcumulado      = $CargosIngresoTotalAcumulado - $AbonosIngresoTotalAcumulado;
                $TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes1 = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes1   = mysqli_fetch_array($ResultIngresoTotalMes1);
                $CargosIngresoTotalMes = $FilaIngresoTotalMes1["CARGOS"];
                $AbonosIngresoTotalMes = $FilaIngresoTotalMes1["ABONOS"];
                $TotalIngresosMes      = $CargosIngresoTotalMes - $AbonosIngresoTotalMes;
                $TotalIngresosMesM     = number_format($TotalIngresosMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen = $TotalIngresosAcumulado + $TotalIngresosMes;
                $SumaTotalResumenM     = number_format($SumaTotalResumen, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumen != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumuladoM, 'col3'=>$TotalIngresosMesM, 'col4'=>$TotalM, 'col5'=>$SumaTotalResumenM, 'col6'=>$TotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO SUBGRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'S')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].".".$CodigoExplotado[2].'.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"    --".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO CUENTA
        else
        {
            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"       ---".$CodigoCuenta.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }

        }
    }
    elseif($TipoReporte == 2)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS COSTOS
            **************************************************
            *************************************************/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
                $CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
                $AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
                $TotalIngresosAcumulado      = $CargosIngresoTotalAcumulado - $AbonosIngresoTotalAcumulado;
                $TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes1 = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes1   = mysqli_fetch_array($ResultIngresoTotalMes1);
                $CargosIngresoTotalMes = $FilaIngresoTotalMes1["CARGOS"];
                $AbonosIngresoTotalMes = $FilaIngresoTotalMes1["ABONOS"];
                $TotalIngresosMes      = $CargosIngresoTotalMes - $AbonosIngresoTotalMes;
                $TotalIngresosMesM     = number_format($TotalIngresosMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen = $TotalIngresosAcumulado + $TotalIngresosMes;
                $SumaTotalResumenM     = number_format($SumaTotalResumen, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumen != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumuladoM, 'col3'=>$TotalIngresosMesM, 'col4'=>$TotalM, 'col5'=>$SumaTotalResumenM, 'col6'=>$TotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO SUBGRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'S')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].".".$CodigoExplotado[2].'.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"    --".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
    }
    elseif($TipoReporte == 3)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS COSTOS
            **************************************************
            *************************************************/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
                $CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
                $AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
                $TotalIngresosAcumulado      = $CargosIngresoTotalAcumulado - $AbonosIngresoTotalAcumulado;
                $TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND '5.02.99.999'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes1 = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes1   = mysqli_fetch_array($ResultIngresoTotalMes1);
                $CargosIngresoTotalMes = $FilaIngresoTotalMes1["CARGOS"];
                $AbonosIngresoTotalMes = $FilaIngresoTotalMes1["ABONOS"];
                $TotalIngresosMes      = $CargosIngresoTotalMes - $AbonosIngresoTotalMes;
                $TotalIngresosMesM     = number_format($TotalIngresosMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen = $TotalIngresosAcumulado + $TotalIngresosMes;
                $SumaTotalResumenM     = number_format($SumaTotalResumen, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumen != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumuladoM, 'col3'=>$TotalIngresosMesM, 'col4'=>$TotalM, 'col5'=>$SumaTotalResumenM, 'col6'=>$TotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
    }
}

/*************************************************
**************************************************
                DETALLE DE GASTOS 2
**************************************************
*************************************************/

//QUERY PARA TRAER TODAS LAS CUENTAS DE INGRESOS
$QueryDetalleIngresos = "SELECT * FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO BETWEEN  '6.00.00.000' AND  '9.99.99.999' ";
$ResultDetalleIngresos = mysqli_query($db, $QueryDetalleIngresos);
while($FilaDetalleIngresos = mysqli_fetch_array($ResultDetalleIngresos))
{
    if($TipoReporte == 1)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS COSTOS
            **************************************************
            *************************************************/
            $CodigoExp = explode(".", $CodigoCuenta);
            $CuentaFin = $CodigoExp[0].".99.99.999";
            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoTotalAcumulado1 = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado1   = mysqli_fetch_array($ResultIngresoTotalAcumulado1);
                $CargosIngresoTotalAcumulado1 = $FilaIngresoTotalAcumulado1["CARGOS"];
                $AbonosIngresoTotalAcumulado1 = $FilaIngresoTotalAcumulado1["ABONOS"];
                $TotalIngresosAcumulado1      = $CargosIngresoTotalAcumulado1 - $AbonosIngresoTotalAcumulado1;
                $TotalIngresosAcumulado1M     = number_format($TotalIngresosAcumulado1, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes   = mysqli_fetch_array($ResultIngresoTotalMes);
                $CargosIngresoTotalMes1 = $FilaIngresoTotalMes["CARGOS"];
                $AbonosIngresoTotalMes1 = $FilaIngresoTotalMes["ABONOS"];
                $TotalIngresosMes1      = $CargosIngresoTotalMes1 - $AbonosIngresoTotalMes1;
                $TotalIngresosMesM1     = number_format($TotalIngresosMes1, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen1 = $TotalIngresosAcumulado1 + $TotalIngresosMes1;
                $SumaTotalResumenM1     = number_format($SumaTotalResumen1, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/

            /*CALCULO PARA EL PORCENTAJE DEL MES*/
                $GastosPorcentaje = (100 * $TotalIngresosMes1) / $TotalIngresosMes;
                $GastosPorcentajeM     = number_format($GastosPorcentaje, 2, '.', ',');
            /*FIN CALCULO PARA EL PORCENTAJE DEL MES*/


             /*CALCULO PARA EL PORCENTAJE DEL MES TOTAL*/
                $GastosPorcentaje1 = (100 * $TotalIngresosMes1) / $SumaTotalResumen;
                $GastosPorcentaje1M     = number_format($GastosPorcentaje1, 2, '.', ',');
            /*FIN CALCULO PARA EL PORCENTAJE DEL MES TOTAL*/

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumenM1 != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumulado1M, 'col3'=>$TotalIngresosMesM1, 'col4'=>$GastosPorcentajeM, 'col5'=>$SumaTotalResumenM1, 'col6'=>$GastosPorcentaje1M);
            }
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO SUBGRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'S')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].".".$CodigoExplotado[2].'.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"    --".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO CUENTA
        else
        {
            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 


            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"       ---".$CodigoCuenta.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }

        }
    }
    elseif($TipoReporte == 2)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS COSTOS
            **************************************************
            *************************************************/
            $CodigoExp = explode(".", $CodigoCuenta);
            $CuentaFin = $CodigoExp[0].".99.99.999";
            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalAcumulado1 = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado1   = mysqli_fetch_array($ResultIngresoTotalAcumulado1);
                $CargosIngresoTotalAcumulado1 = $FilaIngresoTotalAcumulado1["CARGOS"];
                $AbonosIngresoTotalAcumulado1 = $FilaIngresoTotalAcumulado1["ABONOS"];
                $TotalIngresosAcumulado1      = $CargosIngresoTotalAcumulado1 - $AbonosIngresoTotalAcumulado1;
                $TotalIngresosAcumulado1M     = number_format($TotalIngresosAcumulado1, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes   = mysqli_fetch_array($ResultIngresoTotalMes);
                $CargosIngresoTotalMes1 = $FilaIngresoTotalMes["CARGOS"];
                $AbonosIngresoTotalMes1 = $FilaIngresoTotalMes["ABONOS"];
                $TotalIngresosMes1      = $CargosIngresoTotalMes1 - $AbonosIngresoTotalMes1;
                $TotalIngresosMesM1     = number_format($TotalIngresosMes1, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen1 = $TotalIngresosAcumulado1 + $TotalIngresosMes1;
                $SumaTotalResumenM1     = number_format($SumaTotalResumen1, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/

            /*CALCULO PARA EL PORCENTAJE DEL MES*/
                $GastosPorcentaje = (100 * $TotalIngresosMes1) / $TotalIngresosMes;
                $GastosPorcentajeM     = number_format($GastosPorcentaje, 2, '.', ',');
            /*FIN CALCULO PARA EL PORCENTAJE DEL MES*/


             /*CALCULO PARA EL PORCENTAJE DEL MES TOTAL*/
                $GastosPorcentaje1 = (100 * $TotalIngresosMes1) / $SumaTotalResumen;
                $GastosPorcentaje1M     = number_format($GastosPorcentaje1, 2, '.', ',');
            /*FIN CALCULO PARA EL PORCENTAJE DEL MES TOTAL*/

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumenM1 != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumulado1M, 'col3'=>$TotalIngresosMesM1, 'col4'=>$GastosPorcentajeM, 'col5'=>$SumaTotalResumenM1, 'col6'=>$GastosPorcentaje1M);
            }
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
        //SI LA CUENTA ES DE TIPO SUBGRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'S')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].".".$CodigoExplotado[2].'.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"    --".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
    }
    elseif($TipoReporte == 3)
    {
        $NombreCuenta = $FilaDetalleIngresos["N_NOMBRE"];
        $CodigoCuenta = $FilaDetalleIngresos["N_CODIGO"];
        //SI LA CUENTA ES DE TIPO GRUPO MATRIZ
        if($FilaDetalleIngresos["N_TIPO"] == 'GM')
        {
            /*************************************************
            **************************************************
                        SABER TOTAL DE LOS COSTOS
            **************************************************
            *************************************************/
            $CodigoExp = explode(".", $CodigoCuenta);
            $CuentaFin = $CodigoExp[0].".99.99.999";
            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalAcumulado1 = mysqli_query($db, $IngresoTotalAcumulado);
                $FilaIngresoTotalAcumulado1   = mysqli_fetch_array($ResultIngresoTotalAcumulado1);
                $CargosIngresoTotalAcumulado1 = $FilaIngresoTotalAcumulado1["CARGOS"];
                $AbonosIngresoTotalAcumulado1 = $FilaIngresoTotalAcumulado1["ABONOS"];
                $TotalIngresosAcumulado1      = $CargosIngresoTotalAcumulado1 - $AbonosIngresoTotalAcumulado1;
                $TotalIngresosAcumulado1M     = number_format($TotalIngresosAcumulado1, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
                if($Cierre == 0)
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoTotalMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$CodigoCuenta."' AND  '".$CuentaFin."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoTotalMes = mysqli_query($db, $IngresoTotalMes);
                $FilaIngresoTotalMes   = mysqli_fetch_array($ResultIngresoTotalMes);
                $CargosIngresoTotalMes1 = $FilaIngresoTotalMes["CARGOS"];
                $AbonosIngresoTotalMes1 = $FilaIngresoTotalMes["ABONOS"];
                $TotalIngresosMes1      = $CargosIngresoTotalMes1 - $AbonosIngresoTotalMes1;
                $TotalIngresosMesM1     = number_format($TotalIngresosMes1, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

            /*SUMA DE TOTAL RESUMEN*/
                $SumaTotalResumen1 = $TotalIngresosAcumulado1 + $TotalIngresosMes1;
                $SumaTotalResumenM1     = number_format($SumaTotalResumen1, 2, '.', ',');
            /*FIN SUMA DE TOTAL RESUMEN*/

            /*CALCULO PARA EL PORCENTAJE DEL MES*/
                $GastosPorcentaje = (100 * $TotalIngresosMes1) / $TotalIngresosMes;
                $GastosPorcentajeM     = number_format($GastosPorcentaje, 2, '.', ',');
            /*FIN CALCULO PARA EL PORCENTAJE DEL MES*/


             /*CALCULO PARA EL PORCENTAJE DEL MES TOTAL*/
                $GastosPorcentaje1 = (100 * $TotalIngresosMes1) / $SumaTotalResumen;
                $GastosPorcentaje1M     = number_format($GastosPorcentaje1, 2, '.', ',');
            /*FIN CALCULO PARA EL PORCENTAJE DEL MES TOTAL*/

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($SumaTotalResumenM1 != 0)
            {
                //Línea en tabla de Ingresos
                $DataDetalle[] = array('col1'=>$FilaDetalleIngresos["N_CODIGO"].' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresosAcumulado1M, 'col3'=>$TotalIngresosMesM1, 'col4'=>$GastosPorcentajeM, 'col5'=>$SumaTotalResumenM1, 'col6'=>$GastosPorcentaje1M);
            }
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($FilaDetalleIngresos["N_TIPO"] == 'G')
        {
            //OBTENER CODIGO DE LA CUENTA DE GRUPO
            $Codigo = $FilaDetalleIngresos["N_CODIGO"];
            //CODIGO SEPARADO POR PUNTOS
            $CodigoExplotado = explode(".", $Codigo);
            //CODIGO FINAL
            $CodigoFinal = $CodigoExplotado[0].".".$CodigoExplotado[1].'.99.999';

            /*QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupo = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFinal."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";   
                }
                $ResultIngresoCuentaGrupo = mysqli_query($db, $IngresoCuentaGrupo);
                $FilaIngresoCuentaGrupo   = mysqli_fetch_array($ResultIngresoCuentaGrupo);
                $CargosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["CARGOS"];
                $AbonosIngresoCuentaGrupo = $FilaIngresoCuentaGrupo["ABONOS"];
                $TotalIngresoCuentaGrupo      = $CargosIngresoCuentaGrupo - $AbonosIngresoCuentaGrupo;
                $TotalIngresoCuentaGrupoM     = number_format($TotalIngresoCuentaGrupo, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS ACUMULADOS DE LA CUENTA GRUPO*/

            /*QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/
                if($Cierre == 0)
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
                }
                else
                {
                    $IngresoCuentaGrupoMes = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                                FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '".$Codigo."' AND '".$CodigoFinal."'
                                AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '".$FechaInicio."' AND '".$FechaFin."'
                                AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
                                AND TRANSACCION.TT_CODIGO <> 29";
                }
                $ResultIngresoCuentaGrupoMes = mysqli_query($db, $IngresoCuentaGrupoMes);
                $FilaIngresoCuentaGrupoMes   = mysqli_fetch_array($ResultIngresoCuentaGrupoMes);
                $CargosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["CARGOS"];
                $AbonosIngresoCuentaGrupoMes = $FilaIngresoCuentaGrupoMes["ABONOS"];
                $TotalIngresoCuentaGrupoMes      = $CargosIngresoCuentaGrupoMes - $AbonosIngresoCuentaGrupoMes;
                $TotalIngresoCuentaGrupoMesM     = number_format($TotalIngresoCuentaGrupoMes, 2, '.', ',');
            /*FIN QUERY PARA SABER LOS INGRESOS DEL MES DE LA CUENTA GRUPO*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoAcumulado = ($Total * $TotalIngresoCuentaGrupoMes) / $CienPorCientoMes;
                $PorcentajeCuentaGrupoAcumuladoM = number_format($PorcentajeCuentaGrupoAcumulado, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/  

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $TotalSumaTotal = $TotalIngresoCuentaGrupo + $TotalIngresoCuentaGrupoMes;
                $TotalSumaTotalM = number_format($TotalSumaTotal, 2, '.', ',');
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/

            /*CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/
                $PorcentajeCuentaGrupoTotal = ($Total * $TotalSumaTotal) / $CienPorCientoTotal;
                $PorcentajeCuentaGrupoTotalM = number_format($PorcentajeCuentaGrupoTotal, 2, '.', ','); 
            /*FIN CALCULO PARA SABER EL PORCENTAJE DE LA CUENTA*/ 

            //SI EXISTEN VALORES EN EL MES Y EL TOTAL QUE AGREGE LA LÍNEA A LA TABLA
            if($TotalSumaTotal != 0)
            {
                $DataDetalle[] = array('col1'=>"  -".$Codigo.' '.utf8_decode($NombreCuenta), 'col2'=>$TotalIngresoCuentaGrupoM, 'col3'=>$TotalIngresoCuentaGrupoMesM, 'col4'=>$PorcentajeCuentaGrupoAcumuladoM, 'col5'=>$TotalSumaTotalM, 'col6'=>$PorcentajeCuentaGrupoTotalM);
            }
        }
    }
}



$pdf->ezTable($DataResumen, $TituloResumen,'', $OpcionesResumen);
$pdf->ezText("", 14);
$pdf->ezTable($DataDetalle, $TituloDetalle,'', $OpcionesDetalle);
ob_clean();
$pdf->ezStream();
?>