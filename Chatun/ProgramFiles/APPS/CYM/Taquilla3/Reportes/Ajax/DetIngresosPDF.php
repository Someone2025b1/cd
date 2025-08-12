<?php
ob_start();
session_start(); 
require("../../../../../../Script/tcpdf/tcpdf.php"); 
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");  
include("../../../../../../Script/funciones.php");  
$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));
$mesObtenido = $_GET['mes'];
$mes = date("m",strtotime($mesObtenido));
$year = date("Y",strtotime($mesObtenido));
$saberMes = fecha_con_mes($mesObtenido);
/*
//LIMPIAMOS
$Tickets = mysqli_query($db, "TRUNCATE TABLE Taquilla.DET_INGRESO");
//INSERTAMOS EN LA TABLA TEMPORAL
//HOTELES
$selectHotel = mysqli_query($db, "SELECT DATE(A.IH_FECHA) AS FECHA, A.IH_ADULTOS AS ADULTOS, A.IH_NINOS AS MENORES, A.IH_MENORES_5 AS MENORES5 FROM Taquilla.INGRESO_HOTEL A 
WHERE MONTH(A.IH_FECHA) = $mes AND YEAR(A.IH_FECHA) =  $year
GROUP BY DAY(DATE(A.IH_FECHA))");

while($rowHotel = mysqli_fetch_array($selectHotel))
{
  $Tickets = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, IH_ADULTOS, IH_NINOS, IH_MENORES_5)
    values ('$rowHotel[FECHA]', $rowHotel[ADULTOS], $rowHotel[MENORES], $rowHotel[MENORES5])");
}

//ASOCIADOS ADULTOS

//ASOCIADOS ADULTOS
$Ticketsa = mysqli_query($db, "TRUNCATE TABLE Taquilla.TEMPORAL_ASOCIADO");
$selectAsociados = mysqli_query($db, "SELECT  A.IA_FECHA_INGRESO as FECHA, A.IAT_CIF_ASOCIADO
FROM Taquilla.INGRESO_ASOCIADO AS A 
WHERE MONTH(DATE(A.IA_FECHA_INGRESO)) = $mes AND YEAR(DATE(A.IA_FECHA_INGRESO)) =  $year 
GROUP BY DAY(A.IA_FECHA_INGRESO), A.IAT_CIF_ASOCIADO
");
$mayor =0;
$menor= 0;
$menor5=0;
while($rowTarAdultos = mysqli_fetch_array($selectAsociados))
{
    $edad = Saber_Edad_Asociado($rowTarAdultos[IAT_CIF_ASOCIADO]);

    if ($edad>18) {
        $mayor = 1;
        $menor = 0;
        $menor5 = 0;
    }
    elseif($edad > 4 && $edad <= 18)
    {
        $menor = 1;
        $mayor = 0;
        $menor5 = 0;
    }
    else
    {
        $menor = 0;
        $mayor = 0;
        $menor5 = 1;
    }
    $fechaAsoc = $rowTarAdultos[FECHA];
    $tarjIns = mysqli_query($db, "INSERT INTO Taquilla.TEMPORAL_ASOCIADO (MAYOR, MENOR, FECHA)
        values ($mayor, $menor, '$fechaAsoc')");
}

$queryAdultos = mysqli_query($db, "SELECT SUM(A.MAYOR) AS MAYOR, SUM(A.MENOR) AS MENOR, A.FECHA FROM Taquilla.TEMPORAL_ASOCIADO A
WHERE MONTH(A.FECHA) = $mes AND YEAR(A.FECHA) =  $year 
GROUP BY DAY(A.FECHA)");

while($rowAdultosIngreso = mysqli_fetch_array($queryAdultos))
{ 
 
$tarjAd = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET IA_ADULTO = $rowAdultosIngreso[MAYOR], IA_MENOR = $rowAdultosIngreso[MENOR] WHERE DIT_FECHA = '$rowAdultosIngreso[FECHA]'"); 

}

$selectTarAdulInsert = mysqli_query($db, "SELECT SUM(A.MAYOR) AS MAYOR, SUM(A.MENOR) AS MENOR, A.FECHA FROM Taquilla.TEMPORAL_ASOCIADO A
WHERE MONTH(A.FECHA) = $mes AND YEAR(A.FECHA) =  $year AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO B WHERE B.DIT_FECHA = A.FECHA)
GROUP BY DAY(A.FECHA)
");

while($rowTarAdultosInsert = mysqli_fetch_array($selectTarAdulInsert))
{ 

$tarjIns = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, IA_ADULTO, IA_MENOR)
        values ('$rowTarAdultosInsert[FECHA]', $rowTarAdultosInsert[MAYOR], $rowTarAdultosInsert[MENOR])");
}

//ASOCIADOS ACOMPAÑANTES
$selectAsociadosAcom = mysqli_query($db, "SELECT COUNT(A.IAT_CODIGO) as total, A.IA_FECHA_INGRESO as FECHA
FROM Taquilla.INGRESO_ACOMPANIANTE AS A 
WHERE MONTH(A.IA_FECHA_INGRESO) = $mes AND YEAR(A.IA_FECHA_INGRESO) =  $year 
GROUP BY DAY(A.IA_FECHA_INGRESO)");

while($rowTarAdultosAcom = mysqli_fetch_array($selectAsociadosAcom))
{
        $tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET IA_ACOMPANANTE = $rowTarAdultosAcom[total] WHERE DIT_FECHA = '$rowTarAdultosAcom[FECHA]'");
}

$selectTarAcompInsert = mysqli_query($db, "SELECT COUNT(A.IAT_CODIGO) as total, A.IA_FECHA_INGRESO as FECHA
FROM Taquilla.INGRESO_ACOMPANIANTE AS A 
WHERE MONTH(A.IA_FECHA_INGRESO) = $mes AND YEAR(A.IA_FECHA_INGRESO) =  $year AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO B WHERE B.DIT_FECHA = DATE(A.IA_FECHA_INGRESO))
GROUP BY DAY(A.IA_FECHA_INGRESO)
");
while($rowAcom = mysqli_fetch_array($selectTarAcompInsert))
{
        $tarjIns = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, IA_ACOMPANANTE)
        values ('$rowAcom[FECHA]', $rowAcom[total])");
}

//tarjetas insert
$selectTarj = mysqli_query($db, "SELECT DATE(A.ITF_FECHA) AS FECHA, A.ITF_ADULTOS AS ADULTOS, A.ITF_NINOS AS NINOS, A.ITF_MENORES_5 AS MENORES5
FROM Taquilla.INGRESO_TARJETAS_FAMILIARES A 
WHERE MONTH(DATE(A.ITF_FECHA)) = $mes AND YEAR(DATE(A.ITF_FECHA)) =  $year
GROUP BY DAY(DATE(A.ITF_FECHA))
");

while($rowTarj = mysqli_fetch_array($selectTarj))
{
    $tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET ITF_TITULAR = 1, ITF_ADULTOS = $rowTarj[ADULTOS], ITF_NINOS = $rowTarj[NINOS], ITF_MENORES_5 = $rowTarj[MENORES5] WHERE DIT_FECHA = '$rowTarj[FECHA]'");
}

$selectTarjIn = mysqli_query($db, "SELECT DATE(A.ITF_FECHA) AS FECHA, A.ITF_ADULTOS AS ADULTOS, A.ITF_NINOS AS NINOS, A.ITF_MENORES_5 AS MENORES5
FROM Taquilla.INGRESO_TARJETAS_FAMILIARES A 
WHERE MONTH(DATE(A.ITF_FECHA)) = $mes AND YEAR(DATE(A.ITF_FECHA)) =  $year AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO B WHERE B.DIT_FECHA = DATE(A.ITF_FECHA))
GROUP BY DAY(DATE(A.ITF_FECHA))
");
while($rowTarjIns = mysqli_fetch_array($selectTarjIn))
{
    $tarjIns = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, ITF_TITULAR, ITF_ADULTOS, ITF_NINOS, ITF_MENORES_5)
    values ('$rowTarjIns[FECHA]', 1, $rowTarjIns[ADULTOS], $rowTarjIns[NINOS], $rowTarjIns[MENORES5])");
}

//MENORES 5 AÑOS INSERT 

$selectUpdMenor = mysqli_query($db, "SELECT a.INA_NINIO_MENOR_5, a.INA_FECHA_INGRESO FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE MONTH(a.INA_FECHA_INGRESO) = $mes AND YEAR(a.INA_FECHA_INGRESO) =  $year AND a.INA_NINIO_MENOR_5>0 
GROUP BY DAY(a.INA_FECHA_INGRESO) ");
while($rowTarjMenor = mysqli_fetch_array($selectUpdMenor))
{
    $tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET MENORES_5 = $rowTarjMenor[INA_NINIO_MENOR_5]  WHERE DIT_FECHA = '$rowTarjMenor[INA_FECHA_INGRESO]'");
}

$selectMenor = mysqli_query($db, "SELECT a.INA_NINIO_MENOR_5, a.INA_FECHA_INGRESO FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE MONTH(a.INA_FECHA_INGRESO) = $mes AND YEAR(a.INA_FECHA_INGRESO) =  $year AND a.INA_NINIO_MENOR_5>0 AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO B WHERE B.DIT_FECHA = a.INA_FECHA_INGRESO )
GROUP BY DAY(a.INA_FECHA_INGRESO) ");
while($rowMenores = mysqli_fetch_array($selectMenor))
{
    $tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, MENORES_5)
    values ('$rowMenores[INA_FECHA_INGRESO]', $rowMenores[INA_NINIO_MENOR_5])");
}

//ADULTOS NO ASOCIADOS INSERT 

$selectUpdAdulto = mysqli_query($db, "SELECT SUM(a.INA_ADULTO) AS SUMA, a.INA_FECHA_INGRESO FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE MONTH(a.INA_FECHA_INGRESO) = $mes AND YEAR(a.INA_FECHA_INGRESO) =  $year AND a.INA_ADULTO>0 
GROUP BY DAY(a.INA_FECHA_INGRESO) ");
while($rowTarjAdulto = mysqli_fetch_array($selectUpdAdulto))
{
    $tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET INA_ADULTO = $rowTarjAdulto[SUMA]  WHERE DIT_FECHA = '$rowTarjAdulto[INA_FECHA_INGRESO]'");
}

$selectAdulto = mysqli_query($db, "SELECT SUM(a.INA_ADULTO) AS SUMA, a.INA_FECHA_INGRESO FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE MONTH(a.INA_FECHA_INGRESO) = $mes AND YEAR(a.INA_FECHA_INGRESO) =  $year  AND a.INA_ADULTO>0 AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO B WHERE B.DIT_FECHA = a.INA_FECHA_INGRESO )
GROUP BY DAY(a.INA_FECHA_INGRESO) ");
while($rowMenores = mysqli_fetch_array($selectAdulto))
{
    $tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, INA_ADULTO)
    values ('$rowMenores[INA_FECHA_INGRESO]', $rowMenores[SUMA])");
}

//NIÑOS NO ASOCIADOS INSERT 

$selectUpdAdulto = mysqli_query($db, "SELECT SUM(a.INA_NINIO) AS SUMA, a.INA_FECHA_INGRESO FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE MONTH(a.INA_FECHA_INGRESO) = $mes AND YEAR(a.INA_FECHA_INGRESO) =  $year  AND a.INA_NINIO>0
GROUP BY DAY(a.INA_FECHA_INGRESO) ");
while($rowTarjAdulto = mysqli_fetch_array($selectUpdAdulto))
{
    $tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET INA_NINO = $rowTarjAdulto[SUMA]  WHERE DIT_FECHA = '$rowTarjAdulto[INA_FECHA_INGRESO]'");
}

$selectAdulto = mysqli_query($db, "SELECT SUM(a.INA_NINIO) AS SUMA, a.INA_FECHA_INGRESO FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE MONTH(a.INA_FECHA_INGRESO) = $mes AND YEAR(a.INA_FECHA_INGRESO) =  $year AND a.INA_NINIO>0 AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO B WHERE B.DIT_FECHA = a.INA_FECHA_INGRESO )
GROUP BY DAY(a.INA_FECHA_INGRESO) ");
while($rowMenores = mysqli_fetch_array($selectAdulto))
{
    $tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, INA_NINO)
    values ('$rowMenores[INA_FECHA_INGRESO]', $rowMenores[SUMA])");
}

//EJERCICIOS

$selectEjercicios = mysqli_query($db, "SELECT DATE(a.AF_FECHA) as FECHA, a.AF_PARTICIPANTES FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.PROGRAMAS_ACTIVOS b ON a.PA_ID = b.PA_ID
WHERE MONTH(DATE(a.AF_FECHA))=$mes AND YEAR(DATE(a.AF_FECHA))= $year AND a.PA_ID IN (6,8)
GROUP BY DAY(DATE(a.AF_FECHA))");
while($rowTarjEjercicios = mysqli_fetch_array($selectEjercicios))
{
    $tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET EJERCICIOS = $rowTarjEjercicios[AF_PARTICIPANTES]  WHERE DIT_FECHA = '$rowTarjEjercicios[FECHA]'");
}

$selectEjerInsert = mysqli_query($db, "SELECT DATE(a.AF_FECHA) as FECHA, a.AF_PARTICIPANTES FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.PROGRAMAS_ACTIVOS b ON a.PA_ID = b.PA_ID
WHERE MONTH(DATE(a.AF_FECHA)) = $mes AND  YEAR(DATE(a.AF_FECHA)) =  $year AND a.PA_ID IN (6,8) AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO C WHERE C.DIT_FECHA = DATE(a.AF_FECHA))
GROUP BY DAY(DATE(a.AF_FECHA)) ");
while($rowEjerciciosInsert = mysqli_fetch_array($selectEjerInsert))
{
    $tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, EJERCICIOS)
    values ('$rowEjerciciosInsert[FECHA]', $rowEjerciciosInsert[AF_PARTICIPANTES])");
}

//FORMACION

$selectFormacion = mysqli_query($db, "SELECT DATE(a.AF_FECHA) AS FECHA, a.AF_PARTICIPANTES FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.CLASIFICADOR_EVENTO c ON c.CE_ID = a.CE_ID
WHERE MONTH(DATE(a.AF_FECHA)) = $mes AND  YEAR(DATE(a.AF_FECHA)) =  $year AND a.CE_ID = 1
GROUP BY DAY(DATE(a.AF_FECHA))");
while($rowTarjForm = mysqli_fetch_array($selectFormacion))
{
    $tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET FORMACION = $rowTarjForm[AF_PARTICIPANTES]  WHERE DIT_FECHA = '$rowTarjForm[FECHA]'");
}

$selectFormInsert = mysqli_query($db, "SELECT DATE(a.AF_FECHA) AS FECHA, a.AF_PARTICIPANTES FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.CLASIFICADOR_EVENTO c ON c.CE_ID = a.CE_ID
WHERE MONTH(DATE(a.AF_FECHA)) = $mes AND  YEAR(DATE(a.AF_FECHA)) =  $year AND a.CE_ID = 1 AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO C WHERE C.DIT_FECHA = DATE(a.AF_FECHA))
GROUP BY DAY(DATE(a.AF_FECHA)) ");
while($rowFormInsert = mysqli_fetch_array($selectFormInsert))
{
    $tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, EJERCICIOS)
    values ('$rowFormInsert[FECHA]', $rowFormInsert[AF_PARTICIPANTES])");
}

//EVENTOS INSERT

$selectEventos = mysqli_query($db, "SELECT DATE(a.IE_FECHA_EVENTO) as FECHA, a.IE_CANTIDAD_PERSONAS FROM Taquilla.INGRESO_EVENTO a
WHERE MONTH(DATE(a.IE_FECHA_EVENTO)) = $mes AND YEAR(DATE(a.IE_FECHA_EVENTO)) =  $year
GROUP BY DAY(DATE(a.IE_FECHA_EVENTO)) ");
while($rowTarEvento = mysqli_fetch_array($selectEventos))
{
    $tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET EVENTOS = $rowTarEvento[IE_CANTIDAD_PERSONAS]  WHERE DIT_FECHA = '$rowTarEvento[FECHA]'");
}

$selectEvenInsert = mysqli_query($db, "SELECT DATE(a.IE_FECHA_EVENTO) as FECHA, a.IE_CANTIDAD_PERSONAS FROM Taquilla.INGRESO_EVENTO a
WHERE MONTH(DATE(a.IE_FECHA_EVENTO)) = $mes AND YEAR(DATE(a.IE_FECHA_EVENTO)) =  $year AND a.CE_ID = 1 AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO C WHERE C.DIT_FECHA = DATE(a.IE_FECHA_EVENTO))
GROUP BY DAY(DATE(a.IE_FECHA_EVENTO)) ");
while($rowEventoInsert = mysqli_fetch_array($selectEvenInsert))
{
    $tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, EVENTOS)
    values ('$rowEventoInsert[FECHA]', $rowEventoInsert[IE_CANTIDAD_PERSONAS])");
}

//CORTESIAS INSERT

$selectCortesia = mysqli_query($db, "SELECT DATE(a.IC_FECHA) AS FECHA, a.IC_CANTIDAD_PERSONAS FROM Taquilla.INGRESO_CORTESIA a
WHERE MONTH(DATE(a.IC_FECHA))=$mes AND YEAR(DATE(a.IC_FECHA))= $year
GROUP BY DAY(DATE(a.IC_FECHA))");
while($rowTarCortesia = mysqli_fetch_array($selectCortesia))
{
    $tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET CORTESIAS = $rowTarCortesia[IC_CANTIDAD_PERSONAS]  WHERE DIT_FECHA = '$rowTarCortesia[FECHA]'");
}

$selectCortesiaInsert = mysqli_query($db, "SELECT DATE(a.IC_FECHA) AS FECHA, a.IC_CANTIDAD_PERSONAS FROM Taquilla.INGRESO_CORTESIA a
WHERE MONTH(DATE(a.IC_FECHA))=$mes AND YEAR(DATE(a.IC_FECHA))= $year
AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO C WHERE C.DIT_FECHA = DATE(a.IC_FECHA))
GROUP BY DAY(DATE(a.IC_FECHA)) ");
while($rowCortesiaInsert = mysqli_fetch_array($selectCortesiaInsert))
{
    $tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, CORTESIAS)
    values ('$rowCortesiaInsert[FECHA]', $rowCortesiaInsert[IC_CANTIDAD_PERSONAS])");
}
*/

$Tickets = mysqli_query($db, "SELECT * FROM Taquilla.DET_INGRESO WHERE COLABORADOR = $Username ORDER BY DIT_FECHA ASC");

$Tickets2 = mysqli_query($db, "SELECT * FROM Taquilla.DET_INGRESO WHERE COLABORADOR = $Username ORDER BY DIT_FECHA ASC");

$Tickets3 = mysqli_query($db, "SELECT * FROM Taquilla.DET_INGRESO WHERE COLABORADOR = $Username ORDER BY DIT_FECHA ASC");

GLOBAL $fecha;
$fecha = date("d-m-Y");
GLOBAL $correlativo;
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo 
    }

    public function Footer() {
    }
}


$Contador = count($StringExplotado);

$StringExplotado = explode(" ", $EspecificarIngreso);

$NuevoStringIngreso = '';

for($x = 1; $x < $Contador; $x++)
{
    if(5 % $x == 0)
    {
        $NuevoStringIngreso = $NuevoStringIngreso."\n";
    }
    else
    {
        $NuevoStringIngreso = $StringExplotado[$x].' '.$NuevoStringIngreso;
    }
}

$pdf = new MYPDF("P","mm","letter", TRUE, 'UTF-8', FALSE);

$pdf->AddPage();
$pdf->setPageOrientation('L');
$pdf->SetLineWidth(.3); 
$pdf->SetDrawColor(0, 0, 0); 
$pdf->SetFont('helvetica',10);
$pdf->SetFillColor(255,255,255);   
$tbl1 .= <<<EOD
<table cellspacing="0" cellpadding="1" border="0">   
          <tr> 
          <td style="width:750px" align="center">INGRESOS AL PARQUE CHATÚN: $saberMes </td>
          </tr>
            </table> 
EOD;
$pdf->writeHTML($tbl1, true, false, false, false, '');  
 $pdf->SetFont('helvetica',12);
$tbl .= <<<EOD
 <table cellspacing="0" cellpadding="1" border="1"> 
             <thead>
              <tr>
            <th>Día</th>
            <th>Fecha</th>
            <th>Titular Tarjeta</th>
            <th>Acompañante Tarjeta</th>
            <th>Niño Tarjeta</th>
            <th>Ejercicios</th>
            <th>Formación</th>
            <th>Total</th>
            </tr>
             </thead> 
             <tbody>
EOD;
        $Contador = 1;
        while($TicketHotelResult = mysqli_fetch_array($Tickets))
          { 
            $totalNoAsociados = $TicketHotelResult[INA_NINO]+$TicketHotelResult[INA_ADULTO]+$TicketHotelResult[IH_ADULTOS]+$TicketHotelResult[IH_NINOS]+$TicketHotelResult[ITF_TITULAR]+$TicketHotelResult[ITF_ADULTOS]+$TicketHotelResult[ITF_NINOS];
            $menores5 = $TicketHotelResult[IH_MENORES_5]+$TicketHotelResult[ITF_MENORES_5]+$TicketHotelResult[MENORES_5];
            $totalAsociados = $TicketHotelResult[IA_ADULTO]+$TicketHotelResult[IA_ACOMPANANTE]+$TicketHotelResult[IA_MENOR]+$TicketHotelResult[EJERCICIOS]+ $TicketHotelResult[FORMACION];
            $totalDia = $totalAsociados; 
            $diaSemana= conocerDiaSemanaFecha($TicketHotelResult[DIT_FECHA]);
            $cambioFecha = cambio_fecha($TicketHotelResult[DIT_FECHA]);
$tbl .= <<<EOD
              <tr>
              <td>$diaSemana</td>
              <td>$cambioFecha</td>
              <td>$TicketHotelResult[IA_ADULTO]</td>
              <td>$TicketHotelResult[IA_ACOMPANANTE]</td>
              <td>$TicketHotelResult[IA_MENOR]</td>
              <td>$TicketHotelResult[EJERCICIOS]</td>
              <td>$TicketHotelResult[FORMACION]</td>
              <td>$totalAsociados</td>
              </tr>       
EOD;
 $Contador++;
        $adultoAsociado += $TicketHotelResult[IA_ADULTO];
        $acompaAsociado += $TicketHotelResult[IA_ACOMPANANTE];
        $menorAsociado += $TicketHotelResult[IA_MENOR];
        $totalEjercicios += $TicketHotelResult[EJERCICIOS];
        $totalFormacion += $TicketHotelResult[FORMACION]; 
        $finalAsociado += $totalAsociados; 
       }
 $tbl .= <<<EOD
                <tr>  
                <td>  </td>
                <td> Total</td>  
                <td class="text-center">$adultoAsociado</td>
                <td class="text-center">$acompaAsociado</td>
                <td class="text-center">$menorAsociado</td>
                <td class="text-center">$totalEjercicios</td>
                <td class="text-center">$totalFormacion</td>
                <td class="text-center">$finalAsociado</td> 
                </tr>
                </tbody>
   </table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->Ln(10);


//otra pagina

$pdf->AddPage();
$pdf->setPageOrientation('L');
$pdf->SetLineWidth(.3); 
$pdf->SetDrawColor(0, 0, 0); 
$pdf->SetFont('helvetica',10);
$pdf->SetFillColor(255,255,255);  
$tbl2 .= <<<EOD
 <table cellspacing="0" cellpadding="1" border="1"> 
             <thead> 
             <tr>
                <th>Día</th>
                <th>Fecha</th>
                <th>Adulto No Asociado</th>              
                <th>No Asociado Niño</th>
                <th>Hotel Adulto</th>
                <th>Hotel Niño</th>
                <th>Tarjeta Familiar</th>
                <th>Acompañante Tarjeta Familiar</th>
                <th>Total no Asociados</th>
              </tr>
             </thead> 
             <tbody>
EOD;
        $Contador = 1;
        while($TicketHotelResult2 = mysqli_fetch_array($Tickets2))
          { 
            $totalNoAsociados = $TicketHotelResult2[INA_NINO]+$TicketHotelResult2[INA_ADULTO]+$TicketHotelResult2[IH_ADULTOS]+$TicketHotelResult2[IH_NINOS]+$TicketHotelResult2[ITF_TITULAR]+$TicketHotelResult2[ITF_ADULTOS]+$TicketHotelResult2[ITF_NINOS];
            $menores5 = $TicketHotelResult2[IH_MENORES_5]+$TicketHotelResult2[ITF_MENORES_5]+$TicketHotelResult2[MENORES_5];
            $totalAsociados = $TicketHotelResult2[IA_ADULTO]+$TicketHotelResult2[IA_ACOMPANANTE]+$TicketHotelResult2[IA_MENOR]+$TicketHotelResult2[EJERCICIOS]+ $TicketHotelResult2[FORMACION];
            $totalDia = $totalNoAsociados; 
            $diaSemana= conocerDiaSemanaFecha($TicketHotelResult2[DIT_FECHA]);
            $cambioFecha = cambio_fecha($TicketHotelResult2[DIT_FECHA]);
            $acompanantes=$TicketHotelResult2[ITF_ADULTOS]+$TicketHotelResult2[ITF_NINOS];
$tbl2 .= <<<EOD
              <tr>
              <td>$diaSemana</td>
              <td>$cambioFecha</td>
              <td>$TicketHotelResult2[INA_ADULTO]</td>
              <td>$TicketHotelResult2[INA_NINO]</td>
              <td>$TicketHotelResult2[IH_ADULTOS]</td>
              <td>$TicketHotelResult2[IH_NINOS]</td>
              <td>$TicketHotelResult2[ITF_TITULAR]</td>
              <td>$acompanantes</td>
              <td>$totalNoAsociados</td>
              </tr>       
EOD;
 $Contador++;
 $adultoAsociado += $TicketHotelResult2[IA_ADULTO];
        $adultoNoAsociado += $TicketHotelResult2[INA_ADULTO];
        $ninoNoAsociado += $TicketHotelResult2[INA_NINO];
        $adultoHotel += $TicketHotelResult2[IH_ADULTOS];
        $ninoHotel += $TicketHotelResult2[IH_NINOS];
      $titularTarjeta +=  $TicketHotelResult2[ITF_TITULAR];
      $acompaTarjeta += $TicketHotelResult2[ITF_ADULTOS]+$TicketHotelResult2[ITF_NINOS];
      $finalNoAsocaido1 += $totalNoAsociados;
       }
 $tbl2 .= <<<EOD
                <tr>  
                <td>  </td>
                <td> Total</td>  
                <td class="text-center">$adultoNoAsociado</td>
                <td class="text-center">$ninoNoAsociado</td>
                <td class="text-center">$adultoHotel</td>
                <td class="text-center">$ninoHotel</td>
                <td class="text-center">$titularTarjeta</td>
                <td class="text-center">$acompaTarjeta</td>
                <td class="text-center">$finalNoAsocaido1</td>
                </tr>
                </tbody>
   </table>
EOD;
$pdf->writeHTML($tbl2, true, false, false, false, '');
//ultima pagina

$pdf->AddPage();
$pdf->setPageOrientation('L');
$pdf->SetLineWidth(.3); 
$pdf->SetDrawColor(0, 0, 0); 
$pdf->SetFont('helvetica',10);
$pdf->SetFillColor(255,255,255);  
$tbl3 .= <<<EOD
 <table cellspacing="0" cellpadding="1" border="1"> 
             <thead> 
             <tr>
                <th>Día</th>
                <th>Fecha</th>
                <th>Niños menores de 5 años</th> 
                <th>Eventos</th>
                <th>Cortesías</th>                
                <th>Total Varios</th>
                <th>Total Día</th> 
              </tr>
             </thead> 
             <tbody>
EOD;
        $Contador = 1;
        while($TicketHotelResult3 = mysqli_fetch_array($Tickets3))
          { 
            $totalNoAsociados = $TicketHotelResult3[INA_NINO]+$TicketHotelResult3[INA_ADULTO]+$TicketHotelResult3[IH_ADULTOS]+$TicketHotelResult3[IH_NINOS]+$TicketHotelResult3[ITF_TITULAR]+$TicketHotelResult3[ITF_ADULTOS]+$TicketHotelResult3[ITF_NINOS];
            $menores5 = $TicketHotelResult3[IH_MENORES_5]+$TicketHotelResult3[ITF_MENORES_5]+$TicketHotelResult3[MENORES_5]+$TicketHotelResult3[IA_MENOR5];
		    $totalAsociados = $TicketHotelResult3[IA_ADULTO]+$TicketHotelResult3[IA_ACOMPANANTE]+$TicketHotelResult3[IA_MENOR]+$TicketHotelResult3[EJERCICIOS]+ $TicketHotelResult3[FORMACION];
            $totalDia =  $menores5+$TicketHotelResult3[EVENTOS]+$TicketHotelResult3[CORTESIAS]; 
            $diaSemana= conocerDiaSemanaFecha($TicketHotelResult3[DIT_FECHA]);
            $cambioFecha = cambio_fecha($TicketHotelResult3[DIT_FECHA]);
            $totalIngresosV = $menores5+$TicketHotelResult3[EVENTOS]+$TicketHotelResult3[CORTESIAS];
		    $acompanantes=$TicketHotelResult3[ITF_ADULTOS]+$TicketHotelResult3[ITF_NINOS];
$tbl3 .= <<<EOD
              <tr>
                <td>$diaSemana</td>
                <td>$cambioFecha</td>
                <td>$menores5</td>
                <td>$TicketHotelResult3[EVENTOS]</td>
                <td>$TicketHotelResult3[CORTESIAS]</td>                
                <td>$totalIngresosV</td>
                <td>$totalDia</td> 
              </tr>       
EOD;
 $Contador++;
 $adultoAsociado += $TicketHotelResult3[IA_ADULTO];
        $acompaAsociado += $TicketHotelResult3[IA_ACOMPANANTE];
        $menorAsociado += $TicketHotelResult3[IA_MENOR];
         $adultoNoAsociado += $TicketHotelResult3[INA_ADULTO];
        $ninoNoAsociado += $TicketHotelResult3[INA_NINO];
        $adultoHotel += $TicketHotelResult3[IH_ADULTOS];
        $ninoHotel += $TicketHotelResult3[IH_NINOS];
      $titularTarjeta +=  $TicketHotelResult3[ITF_TITULAR];
      $acompaTarjeta += $TicketHotelResult3[ITF_ADULTOS]+$TicketHotelResult3[ITF_NINOS];
      $finalNoAsocaido += $totalNoAsociados;
      $totalMenores += $menores5;
      $totalEjercicios += $TicketHotelResult3[EJERCICIOS];
      $totalFormacion += $TicketHotelResult3[FORMACION];
      $totalEventos += $TicketHotelResult3[EVENTOS];
      $totalCortesia += $TicketHotelResult3[CORTESIAS];
      $finalDia += $totalDia;  
      $totalVarios += $totalIngresosV;
			 
}
$totalMes = $finalDia+ $finalNoAsocaido1 +$finalAsociado;
$tbl3 .= <<<EOD
                <tr>  
                <td>  </td>
                <td> Total</td>
                <td class="text-center">$totalMenores</td> 
                <td class="text-center">$totalEventos</td>
                <td class="text-center">$totalCortesia</td>
                <td class="text-center">$totalVarios</td>          
                <td class="text-center">$finalDia</td>          
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>TOTAL MES:</td>
                  <td class="text-center">$totalMes</td>
                </tr>
                </tbody>
   </table>
EOD;
$pdf->writeHTML($tbl3, true, false, false, false, '');

 
ob_clean();
$pdf->Output();
$pdf->ezStream(); 
?>

 