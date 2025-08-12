<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$FechaInicio = $_POST["fechaInicial"];
$FechaFin = $_POST["fechaFinal"]; 
$TipoDatos = $_POST["TipoDatos"]; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">

	<style type="text/css">
        .well{
        	 background: rgb(134, 192, 72);
        }

        table th {
	  color: #fff;
	  background-color: #f00;
	}
    </style>

</head>

<?php
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

?>
<div align="left">
		<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
	</div> <br>
	<br>
	<div style="overflow-x:auto;">
		<table class="table table-hover" id="TblTicketsHotel">
		    <thead>
        
		    </thead>
		    <tbody> 
            <tr>
            <td align="center" colspan="6" ><b>REPORTE FINANCIERO</b></td>
          </tr>
        <tr>
            <td><b>Partida</b></td>
            <td><b>Tipo</b></td>
            <td><b>Saldo Inicial</b></td>
            <td><b>Cargos</b></td>
            <td><b>Abonos</b></td>
            <td><b>Total Mes</b></td>
            <td><b>Saldo Final</b></td>
          </tr>
<?php
 if ($TipoDatos=="TODO"){
$NomTitulo = mysqli_query($db, "SELECT * FROM Finanzas.TITULO ");
while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $CodTit = $row1["T_CODIGO"];
            $NombreTit=$row1["T_NOMBRE"];
            $TipoTit=$row1["T_TIPO"];


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

        $CargosMostrar = number_format($Cargos, 3, ".", "");
        $AbonosMostrar = number_format($Abonos, 3, ".", "");

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

           
    }
}
$TotalesSalAnte += $SumaSaldoInicial+$Alter;
$TotalesSalActu += $SumaSaldoFinal+$Alter;
$TotalesSumaCargos += $SumaCargos;
$TotalesSumaAbonos += $SumaAbonos;
$diferenciaCargosAbonos = $SumaCargos-$SumaAbonos;
$TotalesDiferencia += $diferenciaCargosAbonos;

?>
<tr>
		    	<td><?php echo $NombreTit ?></td>
		    	<td><?php echo $TipoTit ?></td>
		    	<td><?php echo number_format($SumaSaldoInicial+$Alter, 3, ".", "") ?></td>
		    	<td><?php echo number_format($SumaCargos, 3, ".", "") ?></td>
		    	<td><?php echo number_format($SumaAbonos, 3, ".", "") ?></td>
		    	<td><?php echo number_format($diferenciaCargosAbonos, 3, ".", "") ?></td>
		    	<td><?php echo number_format($SumaSaldoFinal+$Alter, 3, ".", "") ?></td>
		   	  </tr>
<?php

$SumaSaldoInicial=0;
$SumaSaldoFinal=0;
$diferenciaCargosAbonos=0;
$SumaAbonos=0;
$SumaCargos=0;
        }

    }else{

        $NomTitulo = mysqli_query($db, "SELECT * FROM Finanzas.TITULO 
                                                 WHERE T_TIPO = '$TipoDatos'");
while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $CodTit = $row1["T_CODIGO"];
            $NombreTit=$row1["T_NOMBRE"];
            $TipoTit=$row1["T_TIPO"];


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

        $CargosMostrar = number_format($Cargos, 3, ".", "");
        $AbonosMostrar = number_format($Abonos, 3, ".", "");

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

           
    }
}
$TotalesSalAnte += $SumaSaldoInicial+$Alter;
$TotalesSalActu += $SumaSaldoFinal+$Alter;
$TotalesSumaCargos += $SumaCargos;
$TotalesSumaAbonos += $SumaAbonos;
$diferenciaCargosAbonos = $SumaCargos-$SumaAbonos;
$TotalesDiferencia += $diferenciaCargosAbonos;

?>
<tr>
		    	<td><?php echo $NombreTit ?></td>
		    	<td><?php echo $TipoTit ?></td>
		    	<td><?php echo number_format($SumaSaldoInicial+$Alter, 3, ".", "") ?></td>
		    	<td><?php echo number_format($SumaCargos, 3, ".", "") ?></td>
		    	<td><?php echo number_format($SumaAbonos, 3, ".", "") ?></td>
		    	<td><?php echo number_format($diferenciaCargosAbonos, 3, ".", "") ?></td>
		    	<td><?php echo number_format($SumaSaldoFinal+$Alter, 3, ".", "") ?></td>
		   	  </tr>
<?php

$SumaSaldoInicial=0;
$SumaSaldoFinal=0;
$diferenciaCargosAbonos=0;
$SumaAbonos=0;
$SumaCargos=0;
        }

    }

?>

		    
        
        <tr>
		    	<td colspan="2"><b>Totales</b></td>
		    	<td><b><?php echo number_format($TotalesSalAnte, 3, ".", "") ?></b></td>
		    	<td><b><?php echo number_format($TotalesSumaCargos, 3, ".", "") ?></b></td>
		    	<td><b><?php echo number_format($TotalesSumaAbonos, 3, ".", "") ?></b></td>
		    	<td><b><?php echo number_format($TotalesDiferencia, 3, ".", "") ?></b></td>
		    	<td><b><?php echo number_format($TotalesSalActu, 3, ".", "") ?></b></td>
						</tr>
         </tbody>
		  </table>
	</div>

	<script>
		 $('#BtnExportarTicketHotel').click(function(event) {
			$('#TblTicketsHotel').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click

	 
	</script>		    		
</html>
