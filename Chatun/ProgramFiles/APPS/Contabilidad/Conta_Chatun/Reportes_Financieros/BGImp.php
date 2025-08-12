<?php
ob_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));

$Fecha = $_POST["Fecha"];
$TipoReporte = $_POST["TipoReporte"];

$TotalActivo = 0;
$TotalPasivo = 0;


$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode(""),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode(""),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode(""),22,array('justification'=>'center'));
$pdf->ezText("",16,array('justification'=>'center'));
$pdf->ezText("Balance General",16,array('justification'=>'center'));
$pdf->ezText("Al ".date('d-m-Y', strtotime($Fecha)),14,array('justification'=>'center'));
$pdf->ezText("Cifras Expresadas en Quetzales",14,array('justification'=>'center'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>'Cuenta', 'col2'=>'Nombre', 'col3'=>'Total', 'col4'=>'Debe', 'col5'=>'Haber');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/


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

    if($TipoReporte == 1)
    {
        //SI LA CUENTA ES DE TIPO GRUPO MADRE
        if($Row["N_TIPO"] == 'GM')
        {
            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '1.00.00.000' AND '1.99.99.999'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["CARGOS"];
                $Abonos = $row["ABONOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            $Data[] = array('col1'=>$Cuenta, 'col2'=>$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'   '.$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'        '.$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'             '.$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
            }
        }
        //SI LA CUENTA ES CUENTA NORMAL
        else
        {
            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO = '".$Cuenta."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'             '.$NombreCuenta, 'col3'=>'', 'col4'=>$TotalMostrar, 'col5'=>'');
            }
            $TotalActivo = $TotalActivo + $Total;
        }
    }
    elseif($TipoReporte == 2)
    {
        //SI LA CUENTA ES DE TIPO GRUPO MADRE
        if($Row["N_TIPO"] == 'GM')
        {
            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '1.00.00.000' AND '1.99.99.999'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["CARGOS"];
                $Abonos = $row["ABONOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            $Data[] = array('col1'=>$Cuenta, 'col2'=>$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'   '.$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'        '.$NombreCuenta, 'col3'=>'', 'col4'=>$TotalMostrar, 'col5'=>'');
                $TotalActivo = $TotalActivo + $Total;
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'             '.$NombreCuenta, 'col3'=>'', 'col4'=>$TotalMostrar, 'col5'=>'');
            }
        }
    }
    elseif($TipoReporte == 3)
    {
        //SI LA CUENTA ES DE TIPO GRUPO MADRE
        if($Row["N_TIPO"] == 'GM')
        {
            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '1.00.00.000' AND '1.99.99.999'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["CARGOS"];
                $Abonos = $row["ABONOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            $Data[] = array('col1'=>$Cuenta, 'col2'=>$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'   '.$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'        '.$NombreCuenta, 'col3'=>'', 'col4'=>$TotalMostrar, 'col5'=>'');
                $TotalActivo = $TotalActivo + $Total;
            }  
        }
    }
    elseif($TipoReporte == 4)
    {
        //SI LA CUENTA ES DE TIPO GRUPO MADRE
        if($Row["N_TIPO"] == 'GM')
        {
            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '1.00.00.000' AND '1.99.99.999'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
                        AND TRANSACCION.E_CODIGO = 2";
            $Result = mysqli_query($db, $Query);
            while($row = mysqli_fetch_array($Result))
            {
                $Cargos = $row["CARGOS"];
                $Abonos = $row["ABONOS"];
            }

            $Total = $Cargos - $Abonos;
            $TotalMostrar = number_format($Total, 2, '.', ',');

            $Data[] = array('col1'=>$Cuenta, 'col2'=>$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'   '.$NombreCuenta, 'col3'=>'', 'col4'=>$TotalMostrar, 'col5'=>'');
                $TotalActivo = $TotalActivo + $Total;
            }        
        }
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

    if($TipoReporte == 1)
    {
        //SI LA CUENTA ES DE TIPO GRUPO MADRE
        if($Row["N_TIPO"] == 'GM')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0]."99.99.999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'   '.$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'        '.$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'             '.$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
            }
        }
        //SI LA CUENTA ES CUENTA NORMAL
        else
        {
            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO = '".$Cuenta."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'             '.$NombreCuenta, 'col3'=>'', 'col4'=>'', 'col5'=>$TotalMostrar);
            }
            $TotalPasivo = $TotalPasivo + $Total;
        }
    }
    elseif($TipoReporte == 2)
    {
        //SI LA CUENTA ES DE TIPO GRUPO MADRE
        if($Row["N_TIPO"] == 'GM')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0]."99.99.999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'   '.$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'        '.$NombreCuenta, 'col3'=>'', 'col4'=>'', 'col5'=>$TotalMostrar);
            }  
            $TotalPasivo = $TotalPasivo + $Total;
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'             '.$NombreCuenta, 'col3'=>'', 'col4'=>'', 'col5'=>$TotalMostrar);
            }
        }
    }
    elseif($TipoReporte == 3)
    {
        //SI LA CUENTA ES DE TIPO GRUPO MADRE
        if($Row["N_TIPO"] == 'GM')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0]."99.99.999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'   '.$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'        '.$NombreCuenta, 'col3'=>'', 'col4'=>'', 'col5'=>$TotalMostrar);
                $TotalPasivo = $TotalPasivo + $Total;
            }  
        }
    }
    elseif($TipoReporte == 4)
    {
        //SI LA CUENTA ES DE TIPO GRUPO MADRE
        if($Row["N_TIPO"] == 'GM')
        {
            $CuentaExplotado = explode('.', $Cuenta);
            $CuentaFin = $CuentaExplotado[0]."99.99.999";

            $Query = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS CARGOS, SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS ABONOS
                        FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                        AND TRANSACCION_DETALLE.N_CODIGO BETWEEN  '".$Cuenta."' AND '".$CuentaFin."'
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>$NombreCuenta, 'col3'=>$TotalMostrar, 'col4'=>'', 'col5'=>'');
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
                        AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                $Data[] = array('col1'=>$Cuenta, 'col2'=>'   '.$NombreCuenta, 'col3'=>'', 'col4'=>'', 'col5'=>$TotalMostrar);
                $TotalPasivo = $TotalPasivo + $Total;
            }        
        }
    }
    
}

/*QUERY PARA SABER LOS INGRESOS TOTALES ACUMULADOS*/
    $IngresoTotalAcumulado = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_CONTA) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_CONTA) AS ABONOS
                    FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.TRANSACCION
                    WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO AND TRANSACCION.TRA_ESTADO = 1
                    AND TRANSACCION_DETALLE.N_CODIGO BETWEEN '4.00.00.000' AND '4.99.99.999'
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
                    AND TRANSACCION.TRA_FECHA_TRANS BETWEEN '2015/01/01' AND '".$Fecha."'
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
if($Fecha == "2021-12-31" | $Fecha == "2022-12-31")
{
    $TotalUtilidadNetaM = "0.00";
}
else 
{
    $TotalUtilidadNetaM = $TotalUtilidadNetaM;
}





 
$Data[] = array('col1'=>'3.02.01.001', 'col2'=>'Resultado del Ejercicio', 'col3'=>'', 'col4'=>'', 'col5'=>$TotalUtilidadNetaM);

$TotalPasivo = $TotalPasivo + $TotalUtilidadNeta;


if($Fecha >= "2022-12-31")
{
    #$TotalActivo += 0.02;
    $TotalPasivo -= 0.02;
}
if($Fecha >= "2023-12-31")
{
    $TotalActivo += 0.02;
    $TotalPasivo += 0.06;
}
if($Fecha >= "2024-03-01")
{
    $TotalActivo -= 0.02;
    
}
if($Fecha >= "2024-10-01")
{
    $TotalActivo += 0.01;
    
}

$TotalActivo = number_format($TotalActivo, 2, '.', ',');
$TotalPasivo = number_format($TotalPasivo, 2, '.', ',');

$Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'TOTALES', 'col4'=>$TotalActivo, 'col5'=>$TotalPasivo);
$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>