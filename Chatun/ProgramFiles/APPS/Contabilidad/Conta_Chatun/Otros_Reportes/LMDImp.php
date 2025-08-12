<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$FechaIni = $_POST["FechaInicio"];
$CodigoCuenta = $_POST["CodigoCuenta"];

$FechaFin = $_POST["FechaFin"];

$TotalGeneralCargos = 0;
$TotalGeneralAbonos = 0;
$SaldoArrelagdo = 0;
$TotalCargosArreglado = 0;
$TotalAbonosArreglado = 0;

$GLOBALS["FechaI"] = $_POST["FechaInicio"];
$GLOBALS["FechaF"] = $_POST["FechaFin"];
$FechaFinal = date("Y-m-d", strtotime("$FechaIni -1  days"));

$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));


$TotalCargos = 0;
$TotalAbonos = 0;

//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,45,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', '',16);
$pdf->Cell(0,0, "Del ".date('d-m-Y', strtotime($GLOBALS["FechaI"]))." Al ".date('d-m-Y', strtotime($GLOBALS["FechaF"])),0,1,'C');
$pdf->Cell(0,0, "Cifras Expresadas en Quetzales",0,1,'C');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', '', 10);


$Consulta1 = "SELECT TRANSACCION_DETALLE.N_CODIGO , NOMENCLATURA.N_NOMBRE
FROM Contabilidad.TRANSACCION_DETALLE AS TRANSACCION_DETALLE , Contabilidad.NOMENCLATURA AS NOMENCLATURA , Contabilidad.TRANSACCION AS TRANSACCION
WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
AND TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
AND TRANSACCION.TRA_FECHA_TRANS
BETWEEN '".$FechaIni."'
AND '".$FechaFin."'
AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoCuenta."'
AND TRANSACCION.E_CODIGO = 2
GROUP BY TRANSACCION_DETALLE.N_CODIGO
ORDER BY TRANSACCION_DETALLE.N_CODIGO ASC , TRANSACCION.TRA_CORRELATIVO ASC ";
$Resultado1 = mysqli_query($db, $Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
    $TotalCargos = 0;
    $TotalAbonos = 0;
    $Saldo = 0;
    $SaldoArrelagdo = 0;
    $tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td align="center" style="background-color: #C9C9C9; width: 75px"><b>Fecha</b></td>
    <td align="center" style="background-color: #C9C9C9; width: 40px"><b>Partida</b></td>
    <td align="center" style="background-color: #C9C9C9; width: 100px"><b>Observaciones</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Cargos</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Abonos</b></td>
    <td align="right" style="background-color: #C9C9C9"><b>Saldo</b></td>
    </tr>
EOD;

    $pdf->SetFont('Helvetica', 'B', 12);
    $CodigoContable = $row1["N_CODIGO"];
    $Nombrecontable = $row1["N_NOMBRE"];
    $pdf->Cell(0,0,"$CodigoContable - $Nombrecontable",0,1,'L');
    $pdf->Cell(0,0,"",0,1,'C');

    $sql2 = "SELECT SUM( TRANSACCION_DETALLE.TRAD_CARGO_CONTA ) AS SUMA_CARGOS , SUM( TRANSACCION_DETALLE.TRAD_ABONO_CONTA ) AS SUMA_ABONOS , NOMENCLATURA.N_TIPO
        FROM Contabilidad.TRANSACCION_DETALLE AS TRANSACCION_DETALLE , Contabilidad.TRANSACCION AS TRANSACCION , Contabilidad.NOMENCLATURA AS NOMENCLATURA
        WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
        AND TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
        AND TRANSACCION.TRA_FECHA_TRANS
        BETWEEN '2015-01-01'
        AND '".$FechaFinal."'
        AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoContable."'
        AND TRANSACCION.E_CODIGO = 2";    

        $pdf->SetFont('Helvetica', '', 8);

    $result2 = mysqli_query($db, $sql2);
    if($fila = mysqli_fetch_array($result2))
    {
        $Cargos = $fila["SUMA_CARGOS"];
        $Abonos = $fila["SUMA_ABONOS"];
        $Cargo = number_format($fila["SUMA_CARGOS"], 2, '.', ',');
        $Abono = number_format($fila["SUMA_ABONOS"], 2, '.', ',');
        $Saldo = $Saldo + ($Cargos - $Abonos);
        $SaldoArreglado = number_format($Saldo, 2, '.', ',');
        $tbl1 .= <<<EOD
    <tr>
    <td align="left" style="width: 75px"><b></b></td>
    <td align="left" style="width: 40px"><b></b></td>
    <td align="left" style="width: 100px">Saldos Anteriores</td>
    <td align="right">$Cargo</td>
    <td align="right">$Abono</td>
    <td align="right">$SaldoArrelagdo</td>
    </tr>
EOD;
        $TotalCargos = $TotalCargos + $fila["SUMA_CARGOS"];
        $TotalAbonos = $TotalAbonos + $fila["SUMA_ABONOS"];
    }

$sql1 = "SELECT TRANSACCION.TRA_FECHA_TRANS , TRANSACCION_DETALLE.N_CODIGO , TRANSACCION.TRA_CORRELATIVO , NOMENCLATURA.N_NOMBRE , TRANSACCION.TRA_CONCEPTO , TRANSACCION_DETALLE.TRAD_CARGO_CONTA , TRANSACCION_DETALLE.TRAD_ABONO_CONTA
            FROM Contabilidad.TRANSACCION_DETALLE AS TRANSACCION_DETALLE , Contabilidad.NOMENCLATURA AS NOMENCLATURA , Contabilidad.TRANSACCION AS TRANSACCION
            WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO
            AND TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
            AND TRANSACCION.TRA_FECHA_TRANS
            BETWEEN '".$FechaIni."'
            AND '".$FechaFin."'
            AND TRANSACCION_DETALLE.N_CODIGO = '".$CodigoContable."'
            AND TRANSACCION.E_CODIGO = 2
            ORDER BY TRANSACCION.TRA_CORRELATIVO ASC ";   

    $result1    = mysqli_query($db, $sql1);

    while($row1 = mysqli_fetch_array($result1))
    {
        $Fecha = date('d-m-Y', strtotime($row1["TRAD_CARGO_CONTA"]));
        $Partida = $row1["TRA_CORRELATIVO"];
        $Observaciones = $row1["TRA_CONCEPTO"];
        $Cargos = $row1["TRAD_CARGO_CONTA"];
        $Abonos = $row1["TRAD_ABONO_CONTA"];
        $Cargo = number_format($row1["TRAD_CARGO_CONTA"], 2, '.', ',');
        $Abono = number_format($row1["TRAD_ABONO_CONTA"], 2, '.', ',');
        $Saldo = $Saldo + ($Cargos - $Abonos);
        $SaldoArrelagdo = number_format($Saldo, 2, '.', ',');
        $tbl1 .= <<<EOD
    <tr>
    <td align="left" style="width: 75px">$Fecha</td>
    <td align="left" style="width: 40px">$Partida</td>
    <td align="left" style="width: 100px">$Observaciones</td>
    <td align="right">$Cargo</td>
    <td align="right">$Abono</td>
    <td align="right">$SaldoArrelagdo</td>
    </tr>
EOD;
        $TotalCargos = $TotalCargos + $row1["TRAD_CARGO_CONTA"];
        $TotalAbonos = $TotalAbonos + $row1["TRAD_ABONO_CONTA"];
        $TotalCargosArreglado = number_format($TotalCargos, 2, '.', ',');
        $TotalAbonosArreglado = number_format($TotalAbonos, 2, '.', ',');
    }

$tbl1 .= <<<EOD
    <tr>
    <td align="left" style="width: 75px"></td>
    <td align="left" style="width: 40px"></td>
    <td align="left" style="width: 100px"><b>Totales</b></td>
    <td align="right"><b>$TotalCargosArreglado</b></td>
    <td align="right"><b>$TotalAbonosArreglado</b></td>
    <td align="right"></td>
    </tr>
EOD;

$tbl1 .= <<<EOD
</table>
EOD;

$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
$pdf->Cell(0,0,"",0,1,'C');
$pdf->Cell(0,0,"",0,1,'C');
$pdf->Cell(0,0,"",0,1,'C');
}
ob_clean();
$pdf->Output();
ob_flush();
?>