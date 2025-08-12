<!-- BEGIN META -->
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<!-- END META -->
<?php
ob_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));

$FechaInicio = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];

$FechaFinal = date('Y-m-d', strtotime($FechaInicio."-1 day"));

$TotalActivo = 0;
$TotalPasivo = 0;


if ($FechaInicio >= '2021-07-01' || $FechaFin <= '2021-08-31') 
{
   $Alter = 0.005;
}
else
{
    $Alter = 0;
}

$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Balance de Saldos",16,array('justification'=>'center'));
$pdf->ezText("Del ".date('d-m-Y', strtotime($FechaInicio))." Al ".date('d-m-Y', strtotime($FechaFin)),14,array('justification'=>'center'));
$pdf->ezText("Expresado en Quetzales",14,array('justification'=>'center'));
$pdf->ezText( $Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);

$NomTitulo = mysqli_query($db, "SELECT * FROM Finanzas.TITULO ");
while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $CodTit = $row1["T_CODIGO"];

            $Data[] = array('col1'=>'');
            $Data[] = array('col1'=>($row1["T_NOMBRE"]),6);

/*TITULOS*/
    $Titulo = array('col1'=>'Cuenta', 'col2'=>'Nombre', 'col3'=>'Saldo Inicial', 'col4'=>'Cargos', 'col5'=>'Abonos', 'col6'=>'Total Mes', 'col7'=>'Saldo Final');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/



//QUERY PARA TRAER TAS LAS CUENTAS QUE SE HAN UTILIZADO EN LA CONTA
$QueryTodasCuentas = "SELECT TRANSACCION_DETALLE.N_CODIGO, NOMENCLATURA.N_NOMBRE
FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION, Finanzas.NOMENCLATURA
WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
AND TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
AND TRANSACCION.E_CODIGO =2 and TRANSACCION.TRA_ESTADO = 1
AND NOMENCLATURA.T_CODIGO= '".$CodTit."'
GROUP BY TRANSACCION_DETALLE.N_CODIGO
ORDER BY TRANSACCION_DETALLE.N_CODIGO";
$ResultTodasCuentas = mysqli_query($db, $QueryTodasCuentas);
while($FTC = mysqli_fetch_array($ResultTodasCuentas))
{
    
    $CODCuenta = $FTC["N_CODIGO"];
    $NOMCuenta = $FTC["N_NOMBRE"];

    //QUERY PARA TRAER TODO EL MOVIMIENTO DE LAS CUENTAS EN EL RANGO DE FECHAS SELECCIONADO
    $QueryCuentas = "SELECT TRANSACCION_DETALLE.N_CODIGO, SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS, NOMENCLATURA.N_NOMBRE
    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION, Finanzas.NOMENCLATURA
    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
    AND TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
    AND NOMENCLATURA.T_CODIGO='".$CodTit."'
    AND TRANSACCION.TRA_FECHA_TRANS
    BETWEEN  '".$FechaInicio."'
    AND  '".$FechaFin."'
    AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1
    AND TRANSACCION_DETALLE.N_CODIGO = '".$CODCuenta."'";
    $ResultCuentas = mysqli_query($db, $QueryCuentas);
    while($row = mysqli_fetch_array($ResultCuentas))
    {
        $TotalAcumulado = 0;
        $Cargos = 0;
        $Abonos = 0;
        $SaldoFinal = 0;

        $Cuenta = $CODCuenta;
        $CuentaExplotada = explode(".", $Cuenta);
        $Segmento = $CuentaExplotada[0];

        $NombreCuenta = utf8_decode($NOMCuenta);

        $Cargos = $row["CARGOS"];
        $Abonos = $row["ABONOS"];
        $diferencia= $Cargos-$Abonos;


        $CargosMostrar = number_format($Cargos, 3, ".", "");
        $AbonosMostrar = number_format($Abonos, 3, ".", "");
        $DiferenciaMostrar = number_format($diferencia, 3, ".", "");


            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 3, ".", "");

            //QUERY PARA TRAER EL MOVIEMIENTO DE LAS CUENTAS ACUMULADO
            $QueryCuentasAcumulado = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                        AND TRANSACCION.TRA_FECHA_TRANS
                                        BETWEEN  '2015/01/01'
                                        AND  '".$FechaFinal."'
                                        AND TRANSACCION_DETALLE.N_CODIGO = '".$Cuenta."'
                                        AND TRANSACCION.E_CODIGO = 2 and TRANSACCION.TRA_ESTADO = 1";
            $ResultCuentasAcumulado = mysqli_query($db, $QueryCuentasAcumulado);
            while($row1 = mysqli_fetch_array($ResultCuentasAcumulado))
            {
                $CargosAcumulados = $row1["CARGOS"];
                $AbonosAcumulados = $row1["ABONOS"];
                $TotalAcumulado = $CargosAcumulados - $AbonosAcumulados;
                $TotalAcumuladoMostrar = number_format($TotalAcumulado, 3, ".", "");
            }

            $SaldoFinal = $TotalAcumulado + $Total;
            $SaldoFinalMostrar = number_format($SaldoFinal, 3, ".", "");

            $SumaCargos = $SumaCargos + $Cargos;
            $SumaAbonos = $SumaAbonos + $Abonos;
            $SumaSaldoInicial = $SumaSaldoInicial + $TotalAcumulado;
            $SumaSaldoFinal = $SumaSaldoFinal + $SaldoFinal;

            $Data[] = array('col1'=>$Cuenta, 'col2'=>$NombreCuenta, 'col3'=>$TotalAcumuladoMostrar, 'col4'=>$CargosMostrar, 'col5'=>$AbonosMostrar, 'col6'=>$DiferenciaMostrar, 'col7'=>$SaldoFinalMostrar);
    }
}
$TotalesSalAnte+=$SumaSaldoInicial+$Alter;
$TotalesSalActu+=$SumaSaldoFinal+$Alter;
$TotalesSumaCargos+=$SumaCargos;
$TotalesSumaAbonos+=$SumaAbonos;
$diferenciaCargosAbonos = $SumaCargos-$SumaAbonos;
$TotalesDiferencia += $diferenciaCargosAbonos;

$Data[] = array('col3'=>number_format($SumaSaldoInicial+$Alter, 3, ".", ""), 'col4'=>number_format($SumaCargos, 3, ".", ""), 'col5'=>number_format($SumaAbonos, 3, ".", ""), 'col6'=>number_format($diferenciaCargosAbonos, 3, ".", ""), 'col7'=>number_format($SumaSaldoFinal+$Alter, 3, ".", ""), 'col1'=>'', 'col2'=>'TOTALES');

$SumaSaldoInicial=0;
$SumaSaldoFinal=0;
$diferenciaCargosAbonos=0;
$SumaAbonos=0;
$SumaCargos=0;

        }
$Data[]= array('col3'=>number_format($TotalesSalAnte, 3, ".", ""), 'col4'=>number_format($TotalesSumaCargos, 3, ".", ""), 'col5'=>number_format($TotalesSumaAbonos, 3, ".", ""), 'col6'=>number_format($TotalesDiferencia, 3, ".", ""), 'col7'=>number_format($TotalesSalActu, 3, ".", ""), 'col1'=>'', 'col2'=>'TOTALES FINALES');
$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>