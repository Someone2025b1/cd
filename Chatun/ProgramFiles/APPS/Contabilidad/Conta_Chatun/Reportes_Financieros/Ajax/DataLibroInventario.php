<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$FechaInicio = $_POST["fechaInicial"];
$FechaFin = $_POST["fechaFinal"]; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">

	

</head>

<?php


$TotalActivo = 0;
$TotalPasivo = 0;




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
            <td><b>Cuenta</b></td>
            <td><b>Nombre</b></td>
            <td><b>Total</b></td>
            <td><b>Debe</b></td>
            <td><b>Haber</b></td>
            <td><b>Saldo</b></td>
            <td><b>Auxiliar</b></td>
          </tr>
<?php

/*************************************************
**************************************************
   QUERY PARA LLAMAR TODAS LAS CUENTAS DE ACTIVO
**************************************************
*************************************************/
$QueryCuentas = "SELECT * FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO BETWEEN '1.00.00.000' AND '1.99.99.999' ORDER BY N_CODIGO";
$ResultCuentas = mysqli_query($db, $QueryCuentas);
while($Row = mysqli_fetch_array($ResultCuentas))
{
    $Cuenta = $Row["N_CODIGO"];
    $NombreCuenta = utf8_decode($Row["N_NOMBRE"]);

      //SI LA CUENTA ES DE TIPO GRUPO MADRE
        if($Row["N_TIPO"] == 'GM')
        {
            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '1.00.00.000' AND '1.99.99.999'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["CARGOS"];
                $Abonos = $row["ABONOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');
            ?>
            <tr>
		    	<td><b><?php echo $Cuenta; ?></b></td>
		    	<td><b><?php echo $NombreCuenta ?></b></td>
		    	<td><b><?php echo $TotalMostrar ?></b></td>
		    	<td><b></b></td>
		    	<td><b></b></td>
		    	<td><b></b></td>
						</tr>
            <?php
            
            
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($Row["N_TIPO"] == 'G')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0].".".$CuentaExplotado[1]."99.999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["CARGOS"];
                $Abonos = $row["ABONOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            if($Total != 0)
            {
                ?>
                <tr>
                    <td><b><?php echo $Cuenta; ?></b></td>
                    <td><b><?php echo '   '.$NombreCuenta ?></b></td>
                    <td><b><?php echo $TotalMostrar ?></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                            </tr>
                <?php
                
                
            }        
        }
        //SI LA CUENTA ES DE TIPO SUBGRUPO 
        elseif($Row["N_TIPO"] == 'S')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0].".".$CuentaExplotado[1].".".$CuentaExplotado[2].".999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["CARGOS"];
                $Abonos = $row["ABONOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            if($Total != 0)
            {
                ?>
                <tr>
                    <td><b><?php echo $Cuenta; ?></b></td>
                    <td><b><?php echo '        '.$NombreCuenta ?></b></td>
                    <td><b><?php echo $TotalMostrar ?></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                            </tr>
                <?php
                
                
            }  
        }
        //SI LA CUENTA ES DE TIPO SUBCUENTA
        elseif($Row["N_TIPO"] == 'SC')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0].".".$CuentaExplotado[1].".".$CuentaExplotado[2].".".$CuentaExplotado[3].".999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["CARGOS"];
                $Abonos = $row["ABONOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            if($Total != 0)
            {
                ?>
                <tr>
                    <td><b><?php echo $Cuenta; ?></b></td>
                    <td><b><?php echo '             '.$NombreCuenta ?></b></td>
                    <td><b><?php echo $TotalMostrar ?></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                            </tr>
                <?php

                

            }
            
        }
        //SI LA CUENTA ES CUENTA NORMAL
        else
        {
            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO = '".$Cuenta."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["CARGOS"];
                $Abonos = $row["ABONOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            if($Total != 0)
            {
                ?>
                <tr>
                    <td><b><?php echo $Cuenta; ?></b></td>
                    <td><b><?php echo '             '.$NombreCuenta ?></b></td>
                    <td><b></b></td>
                    <td><b><?php echo $TotalMostrar ?></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                            </tr>
                <?php


                
                
            }


            
            $TotalActivo = $TotalActivo + $Total;

            
        }
    }

/*************************************************
**************************************************
   QUERY PARA LLAMAR TODAS LAS CUENTAS DE PASIVO
**************************************************
*************************************************/
$QueryCuentas = "SELECT * FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO BETWEEN '2.00.00.000' AND '3.99.99.999' ORDER BY N_CODIGO";
$ResultCuentas = mysqli_query($db, $QueryCuentas);
while($Row = mysqli_fetch_array($ResultCuentas))
{
    $Cuenta = $Row["N_CODIGO"];
    $NombreCuenta = utf8_decode($Row["N_NOMBRE"]);


        //SI LA CUENTA ES DE TIPO GRUPO MADRE
        if($Row["N_TIPO"] == 'GM')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0]."99.99.999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["ABONOS"];
                $Abonos = $row["CARGOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');


            if($Total != 0)
            {
                ?>
                <tr>
                    <td><b><?php echo $Cuenta; ?></b></td>
                    <td><b><?php echo '             '.$NombreCuenta ?></b></td>
                    <td><b><?php echo $TotalMostrar ?></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                            </tr>
                <?php
                
            }  
        }
        //SI LA CUENTA ES DE TIPO GRUPO
        elseif($Row["N_TIPO"] == 'G')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0].".".$CuentaExplotado[1]."99.999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["ABONOS"];
                $Abonos = $row["CARGOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            if($Total != 0)
            {
                ?>
                <tr>
                    <td><b><?php echo $Cuenta; ?></b></td>
                    <td><b><?php echo '             '.$NombreCuenta ?></b></td>
                    <td><b><?php echo $TotalMostrar ?></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                            </tr>
                <?php
                
            }        
        }
        //SI LA CUENTA ES DE TIPO SUBGRUPO 
        elseif($Row["N_TIPO"] == 'S')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0].".".$CuentaExplotado[1].".".$CuentaExplotado[2].".999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["ABONOS"];
                $Abonos = $row["CARGOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            if($Total != 0)
            {
                ?>
                <tr>
                    <td><b><?php echo $Cuenta; ?></b></td>
                    <td><b><?php echo '        '.$NombreCuenta ?></b></td>
                    <td><b><?php echo $TotalMostrar ?></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                            </tr>
                <?php
               
            }  
        }
        //SI LA CUENTA ES DE TIPO SUBCUENTA
        elseif($Row["N_TIPO"] == 'SC')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0].".".$CuentaExplotado[1].".".$CuentaExplotado[2].".".$CuentaExplotado[3].".999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["ABONOS"];
                $Abonos = $row["CARGOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            if($Total != 0)
            {
                ?>
                <tr>
                    <td><b><?php echo $Cuenta; ?></b></td>
                    <td><b><?php echo '        '.$NombreCuenta ?></b></td>
                    <td><b><?php echo $TotalMostrar ?></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                            </tr>
                <?php
                
            }
        }
        //SI LA CUENTA ES CUENTA NORMAL
        else
        {
            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO = '".$Cuenta."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["ABONOS"];
                $Abonos = $row["CARGOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            if($Total != 0)
            {
                ?>
                <tr>
                    <td><b><?php echo $Cuenta; ?></b></td>
                    <td><b><?php echo '        '.$NombreCuenta ?></b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    <td><b><?php echo $TotalMostrar ?></b></td>
                    <td><b></b></td>
                            </tr>
                <?php
               
            }
            $TotalPasivo = $TotalPasivo + $Total;
        }
       
}
/*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
$IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
AND TRANSACCION.E_CODIGO = 2";
$ResultIngresoTotalAcumulado = mysqli_query($db, $IngresoTotalAcumulado);
$FilaIngresoTotalAcumulado   = mysqli_fetch_array($ResultIngresoTotalAcumulado);
$CargosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["CARGOS"];
$AbonosIngresoTotalAcumulado = $FilaIngresoTotalAcumulado["ABONOS"];
$TotalIngresosAcumulado      = $AbonosIngresoTotalAcumulado - $CargosIngresoTotalAcumulado;
$TotalIngresosAcumuladoM     = number_format($TotalIngresosAcumulado, 2, '.', ',');
/*FIN QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/

/*QUERY PARA SABER LOS COSTOS TOTALES ACUMULADOS*/
$CostoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.00.00.000' AND '5.99.99.999'
AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
AND TRANSACCION.E_CODIGO = 2";
$ResultCostoTotalAcumulado = mysqli_query($db, $CostoTotalAcumulado);
$FilaCostoTotalAcumulado   = mysqli_fetch_array($ResultCostoTotalAcumulado);
$CargosCostoTotalAcumulado = $FilaCostoTotalAcumulado["CARGOS"];
$AbonosCostoTotalAcumulado = $FilaCostoTotalAcumulado["ABONOS"];
$TotalCostoTotalAcumulado      = $CargosCostoTotalAcumulado - $AbonosCostoTotalAcumulado;
$TotalCostoTotalAcumuladoM     = number_format($TotalCostoTotalAcumulado, 2, '.', ',');
/*FIN QUERY PARA SABER LOS COSTOS TOTALES ACUMULADOS*/

/*QUERY PARA SABER LOS GASTOS TOTALES ACUMULADOS*/
$GastoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
AND ((TRANSACCION_DETALLE.N_CODIGO BETWEEN '5.02.00.000' AND  '5.02.99.999')
OR (TRANSACCION_DETALLE.N_CODIGO BETWEEN '6.00.00.000' AND  '9.99.99.999'))
AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$FechaFin."'
AND TRANSACCION.E_CODIGO = 2";
$ResultGastoTotalAcumulado = mysqli_query($db, $GastoTotalAcumulado);
$FilaGastoTotalAcumulado   = mysqli_fetch_array($ResultGastoTotalAcumulado);
$CargosGastoTotalAcumulado = $FilaGastoTotalAcumulado["CARGOS"];
$AbonosGastoTotalAcumulado = $FilaGastoTotalAcumulado["ABONOS"];
$TotalGastoTotalAcumulado      = $CargosGastoTotalAcumulado - $AbonosGastoTotalAcumulado;
$TotalGastoTotalAcumuladoM     = number_format($TotalGastoTotalAcumulado, 2, '.', ',');
/*FIN QUERY PARA SABER LOS GASTOS TOTALES ACUMULADOS*/

$TotalUtilidadNeta = $TotalIngresosAcumulado - ($TotalCostoTotalAcumulado + $TotalGastoTotalAcumulado);
$TotalUtilidadNetaM = number_format($TotalUtilidadNeta, 2, '.', ',');

$TotalUtilidadNetaM = $TotalUtilidadNetaM;

?>
<tr>
    <td><b>3.02.01.001</b></td>
    <td><b>Resultado del Ejercicio</b></td>
    <td><b></b></td>
    <td><b></b></td>
    <td><b><?php echo $TotalUtilidadNetaM ?></b></td>
    <td><b></b></td>
            </tr>
<?php


?>
 
        <tr>
		    	<td><b>Totales</b></td>
		    	<td><b><?php echo number_format($TotalActivo, 3, ".", "") ?></b></td>
		    	<td><b><?php echo number_format($TotalPasivo, 3, ".", "") ?></b></td>
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
