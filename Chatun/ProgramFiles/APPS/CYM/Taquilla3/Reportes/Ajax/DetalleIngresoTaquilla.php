<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$mesObtenido = $_POST['mes'];
$mes = date("m",strtotime($mesObtenido));
$year = date("Y",strtotime($mesObtenido));

//LIMPIAMOS
$Tickets = mysqli_query($db, "DELETE FROM Taquilla.DET_INGRESO");
//INSERTAMOS EN LA TABLA TEMPORAL
//HOTELES
$selectHotel = mysqli_query($db, "SELECT DATE(A.IH_FECHA) AS FECHA, SUM(A.IH_ADULTOS) AS ADULTOS, SUM(A.IH_NINOS) AS MENORES, SUM(A.IH_MENORES_5) AS MENORES5 FROM Taquilla.INGRESO_HOTEL A 
WHERE MONTH(A.IH_FECHA) = $mes AND YEAR(A.IH_FECHA) =  $year
GROUP BY DAY(DATE(A.IH_FECHA))");

while($rowHotel = mysqli_fetch_array($selectHotel))
{
	$Tickets = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, IH_ADULTOS, IH_NINOS, IH_MENORES_5, COLABORADOR)
		values ('$rowHotel[FECHA]', $rowHotel[ADULTOS], $rowHotel[MENORES], $rowHotel[MENORES5], $id_user)");
}

//ASOCIADOS ADULTOS
$Ticketsa = mysqli_query($db, "DELETE FROM Taquilla.TEMPORAL_ASOCIADO");
$selectAsociados = mysqli_query($db, "SELECT  A.IA_FECHA_INGRESO as FECHA, A.IAT_CIF_ASOCIADO, B.ciffecnacimie
FROM Taquilla.INGRESO_ASOCIADO AS A 
INNER JOIN bankworks.cif_generales B ON A.IAT_CIF_ASOCIADO = B.cifcodcliente
WHERE MONTH(DATE(A.IA_FECHA_INGRESO)) = $mes AND YEAR(DATE(A.IA_FECHA_INGRESO)) =  $year 
GROUP BY DAY(A.IA_FECHA_INGRESO), A.IAT_CIF_ASOCIADO
");
$mayor =0;
$menor= 0;
$menor5=0;
while($rowTarAdultos = mysqli_fetch_array($selectAsociados))
{
	$edad = $rowTarAdultos['ciffecnacimie'];

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
	$fechaAsoc = $rowTarAdultos["FECHA"];
	$tarjIns = mysqli_query($db, "INSERT INTO Taquilla.TEMPORAL_ASOCIADO (MAYOR, MENOR, MENOR5, FECHA)
		values ($mayor, $menor, $menor5, '$fechaAsoc')");
}

$queryAdultos = mysqli_query($db, "SELECT SUM(A.MAYOR) AS MAYOR, SUM(A.MENOR) AS MENOR, SUM(A.MENOR5) AS MENOR5, A.FECHA FROM Taquilla.TEMPORAL_ASOCIADO A
WHERE MONTH(A.FECHA) = $mes AND YEAR(A.FECHA) =  $year 
GROUP BY DAY(A.FECHA)");

while($rowAdultosIngreso = mysqli_fetch_array($queryAdultos))
{ 
 
$tarjAd = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET IA_ADULTO = $rowAdultosIngreso[MAYOR], IA_MENOR = $rowAdultosIngreso[MENOR], IA_MENOR5 = $rowAdultosIngreso[MENOR5] WHERE DIT_FECHA = '$rowAdultosIngreso[FECHA]'"); 

}

$selectTarAdulInsert = mysqli_query($db, "SELECT SUM(A.MAYOR) AS MAYOR, SUM(A.MENOR) AS MENOR, SUM(A.MENOR5) AS MENOR5, A.FECHA FROM Taquilla.TEMPORAL_ASOCIADO A
WHERE MONTH(A.FECHA) = $mes AND YEAR(A.FECHA) =  $year AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO B WHERE B.DIT_FECHA = A.FECHA)
GROUP BY DAY(A.FECHA)
");

while($rowTarAdultosInsert = mysqli_fetch_array($selectTarAdulInsert))
{ 

$tarjIns = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, IA_ADULTO, IA_MENOR, IA_MENOR5, COLABORADOR)
		values ('$rowTarAdultosInsert[FECHA]', $rowTarAdultosInsert[MAYOR], $rowTarAdultosInsert[MENOR], $rowTarAdultosInsert[MENOR5], $id_user)");
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
		$tarjIns = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, IA_ACOMPANANTE, COLABORADOR)
		values ('$rowAcom[FECHA]', $rowAcom[total], $id_user)");
}
/*
//ASOCIADOS ACOMPAÑANTES MENORES
$selectAsociadosAcomM = mysqli_query($db, "SELECT COUNT(A.IAT_CIF_ASOCIADO) as total, A.IA_FECHA_INGRESO as FECHA
FROM Taquilla.INGRESO_ACOMPANIANTE AS A 
WHERE MONTH(A.IA_FECHA_INGRESO) = $mes AND YEAR(A.IA_FECHA_INGRESO) =  $year AND A.IAT_EDAD <=18
GROUP BY DAY(A.IA_FECHA_INGRESO)");

while($rowTarAdultosAcomM = mysqli_fetch_array($selectAsociadosAcomM))
{
		$tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET IA_MENOR = $rowTarAdultosAcomM[total] WHERE DIT_FECHA = '$rowTarAdultosAcomM[FECHA]'");
}

$selectTarAcompInsertM = mysqli_query($db, "SELECT COUNT(A.IAT_CIF_ASOCIADO) as total, A.IA_FECHA_INGRESO as FECHA
FROM Taquilla.INGRESO_ACOMPANIANTE AS A 
WHERE MONTH(A.IA_FECHA_INGRESO) = $mes AND YEAR(A.IA_FECHA_INGRESO) =  $year AND A.IAT_EDAD <=18 AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO B WHERE B.DIT_FECHA = DATE(A.IA_FECHA_INGRESO))
GROUP BY DAY(A.IA_FECHA_INGRESO)
");
while($rowAcomM = mysqli_fetch_array($selectTarAcompInsertM))
{
		$tarjIns = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, IA_MENOR)
		values ('$rowAcomM[FECHA]', $rowAcomM[total])");
}
*/
//tarjetas insert
$selectTarj = mysqli_query($db, "SELECT DATE(A.ITF_FECHA) AS FECHA, SUM(A.ITF_ADULTOS) AS ADULTOS, SUM(A.ITF_NINOS) AS NINOS, SUM(A.ITF_MENORES_5) AS MENORES5
FROM Taquilla.INGRESO_TARJETAS_FAMILIARES A 
WHERE MONTH(DATE(A.ITF_FECHA)) = $mes AND YEAR(DATE(A.ITF_FECHA)) =  $year
GROUP BY DAY(DATE(A.ITF_FECHA))
");

while($rowTarj = mysqli_fetch_array($selectTarj))
{
		$tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET ITF_TITULAR = 1, ITF_ADULTOS = $rowTarj[ADULTOS], ITF_NINOS = $rowTarj[NINOS], ITF_MENORES_5 = $rowTarj[MENORES5] WHERE DIT_FECHA = '$rowTarj[FECHA]'");
}

$selectTarjIn = mysqli_query($db, "SELECT DATE(A.ITF_FECHA) AS FECHA, SUM(A.ITF_ADULTOS) AS ADULTOS, SUM(A.ITF_NINOS) AS NINOS, SUM(A.ITF_MENORES_5) AS MENORES5
FROM Taquilla.INGRESO_TARJETAS_FAMILIARES A 
WHERE MONTH(DATE(A.ITF_FECHA)) = $mes AND YEAR(DATE(A.ITF_FECHA)) =  $year AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO B WHERE B.DIT_FECHA = DATE(A.ITF_FECHA))
GROUP BY DAY(DATE(A.ITF_FECHA))
");
while($rowTarjIns = mysqli_fetch_array($selectTarjIn))
{
		$tarjIns = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, ITF_TITULAR, ITF_ADULTOS, ITF_NINOS, ITF_MENORES_5, COLABORADOR)
		values ('$rowTarjIns[FECHA]', 1, $rowTarjIns[ADULTOS], $rowTarjIns[NINOS], $rowTarjIns[MENORES5]), $id_user");
}

//MENORES 5 AÑOS INSERT 

$selectUpdMenor = mysqli_query($db, "SELECT SUM(a.INA_NINIO_MENOR_5) AS TOTAL, a.INA_FECHA_INGRESO FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE MONTH(a.INA_FECHA_INGRESO) = $mes AND YEAR(a.INA_FECHA_INGRESO) =  $year AND a.INA_NINIO_MENOR_5>0 
GROUP BY DAY(a.INA_FECHA_INGRESO) ");
while($rowTarjMenor = mysqli_fetch_array($selectUpdMenor))
{
		$tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET MENORES_5 = $rowTarjMenor[TOTAL]  WHERE DIT_FECHA = '$rowTarjMenor[INA_FECHA_INGRESO]'");
}

$selectMenor = mysqli_query($db, "SELECT SUM(a.INA_NINIO_MENOR_5) AS TOTAL, a.INA_FECHA_INGRESO FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE MONTH(a.INA_FECHA_INGRESO) = $mes AND YEAR(a.INA_FECHA_INGRESO) =  $year AND a.INA_NINIO_MENOR_5>0 AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO B WHERE B.DIT_FECHA = a.INA_FECHA_INGRESO )
GROUP BY DAY(a.INA_FECHA_INGRESO) ");
while($rowMenores = mysqli_fetch_array($selectMenor))
{
		$tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, MENORES_5, COLABORADOR)
		values ('$rowMenores[INA_FECHA_INGRESO]', $rowMenores[TOTAL], $id_user)");
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
		$tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, INA_ADULTO, COLABORADOR)
		values ('$rowMenores[INA_FECHA_INGRESO]', $rowMenores[SUMA], $id_user)");
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
		$tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, INA_NINO, COLABORADOR)
		values ('$rowMenores[INA_FECHA_INGRESO]', $rowMenores[SUMA], $id_user)");
}

//EJERCICIOS

$selectEjercicios = mysqli_query($db, "SELECT DATE(a.AF_FECHA) as FECHA, SUM(a.AF_PARTICIPANTES) AS TOTAL FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.PROGRAMAS_ACTIVOS b ON a.PA_ID = b.PA_ID
WHERE MONTH(DATE(a.AF_FECHA))=$mes AND YEAR(DATE(a.AF_FECHA))= $year AND a.PA_ID IN (6,8)
GROUP BY DAY(DATE(a.AF_FECHA))");
while($rowTarjEjercicios = mysqli_fetch_array($selectEjercicios))
{
		$tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET EJERCICIOS = $rowTarjEjercicios[TOTAL]  WHERE DIT_FECHA = '$rowTarjEjercicios[FECHA]'");
}

$selectEjerInsert = mysqli_query($db, "SELECT DATE(a.AF_FECHA) as FECHA, SUM(a.AF_PARTICIPANTES) AS TOTAL FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.PROGRAMAS_ACTIVOS b ON a.PA_ID = b.PA_ID
WHERE MONTH(DATE(a.AF_FECHA)) = $mes AND  YEAR(DATE(a.AF_FECHA)) =  $year AND a.PA_ID IN (6,8) AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO C WHERE C.DIT_FECHA = DATE(a.AF_FECHA))
GROUP BY DAY(DATE(a.AF_FECHA)) ");
while($rowEjerciciosInsert = mysqli_fetch_array($selectEjerInsert))
{
		$tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, EJERCICIOS, COLABORADOR)
		values ('$rowEjerciciosInsert[FECHA]', $rowEjerciciosInsert[TOTAL], $id_user)");
}

//FORMACION

$selectFormacion = mysqli_query($db, "SELECT DATE(a.AF_FECHA) AS FECHA, SUM(a.AF_PARTICIPANTES) AS TOTAL FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.CLASIFICADOR_EVENTO c ON c.CE_ID = a.CE_ID
WHERE MONTH(DATE(a.AF_FECHA)) = $mes AND  YEAR(DATE(a.AF_FECHA)) =  $year AND a.CE_ID = 1
GROUP BY DAY(DATE(a.AF_FECHA))");
while($rowTarjForm = mysqli_fetch_array($selectFormacion))
{
		$tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET FORMACION = $rowTarjForm[TOTAL]  WHERE DIT_FECHA = '$rowTarjForm[FECHA]'");
}

$selectFormInsert = mysqli_query($db, "SELECT DATE(a.AF_FECHA) AS FECHA, SUM(a.AF_PARTICIPANTES) AS TOTAL FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.CLASIFICADOR_EVENTO c ON c.CE_ID = a.CE_ID
WHERE MONTH(DATE(a.AF_FECHA)) = $mes AND  YEAR(DATE(a.AF_FECHA)) =  $year AND a.CE_ID = 1 AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO C WHERE C.DIT_FECHA = DATE(a.AF_FECHA))
GROUP BY DAY(DATE(a.AF_FECHA)) ");
while($rowFormInsert = mysqli_fetch_array($selectFormInsert))
{
		$tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, EJERCICIOS, COLABORADOR)
		values ('$rowFormInsert[FECHA]', $rowFormInsert[TOTAL], $id_user)");
}

//EVENTOS INSERT

$selectEventos = mysqli_query($db, "SELECT DATE(a.IE_FECHA_EVENTO) as FECHA, SUM(a.IE_CANTIDAD_PERSONAS) AS TOTAL FROM Taquilla.INGRESO_EVENTO a
WHERE MONTH(DATE(a.IE_FECHA_EVENTO)) = $mes AND YEAR(DATE(a.IE_FECHA_EVENTO)) =  $year
GROUP BY DAY(DATE(a.IE_FECHA_EVENTO)) ");
while($rowTarEvento = mysqli_fetch_array($selectEventos))
{
		$tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET EVENTOS = $rowTarEvento[TOTAL]  WHERE DIT_FECHA = '$rowTarEvento[FECHA]'");
}

$selectEvenInsert = mysqli_query($db, "SELECT DATE(a.IE_FECHA_EVENTO) as FECHA, SUM(a.IE_CANTIDAD_PERSONAS) AS TOTAL FROM Taquilla.INGRESO_EVENTO a
WHERE MONTH(DATE(a.IE_FECHA_EVENTO)) = $mes AND YEAR(DATE(a.IE_FECHA_EVENTO)) =  $year AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO C WHERE C.DIT_FECHA = DATE(a.IE_FECHA_EVENTO))
GROUP BY DAY(DATE(a.IE_FECHA_EVENTO)) ");
while($rowEventoInsert = mysqli_fetch_array($selectEvenInsert))
{
		$tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, EVENTOS, COLABORADOR)
		values ('$rowEventoInsert[FECHA]', $rowEventoInsert[TOTAL], $id_user)");
}

//CORTESIAS INSERT

$selectCortesia = mysqli_query($db, "SELECT DATE(a.IC_FECHA) AS FECHA, SUM(a.IC_CANTIDAD_PERSONAS) AS TOTAL FROM Taquilla.INGRESO_CORTESIA a
WHERE MONTH(DATE(a.IC_FECHA))=$mes AND YEAR(DATE(a.IC_FECHA))= $year
GROUP BY DAY(DATE(a.IC_FECHA))");
while($rowTarCortesia = mysqli_fetch_array($selectCortesia))
{
		$tarj = mysqli_query($db, "UPDATE Taquilla.DET_INGRESO SET CORTESIAS = $rowTarCortesia[TOTAL]  WHERE DIT_FECHA = '$rowTarCortesia[FECHA]'");
}

$selectCortesiaInsert = mysqli_query($db, "SELECT DATE(a.IC_FECHA) AS FECHA, SUM(a.IC_CANTIDAD_PERSONAS) AS TOTAL FROM Taquilla.INGRESO_CORTESIA a
WHERE MONTH(DATE(a.IC_FECHA))=$mes AND YEAR(DATE(a.IC_FECHA))= $year
AND NOT EXISTS (SELECT *FROM Taquilla.DET_INGRESO C WHERE C.DIT_FECHA = DATE(a.IC_FECHA))
GROUP BY DAY(DATE(a.IC_FECHA)) ");
while($rowCortesiaInsert = mysqli_fetch_array($selectCortesiaInsert))
{
		$tarjMenores = mysqli_query($db, "INSERT INTO Taquilla.DET_INGRESO (DIT_FECHA, CORTESIAS, COLABORADOR)
		values ('$rowCortesiaInsert[FECHA]', $rowCortesiaInsert[TOTAL], $id_user)");
}

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
	<header align="center">
		<h3>Ingresos Taquilla del Mes <?php echo $mes?> y año <?php echo $year ?></h3>
	</header>
	<?php 
	 $Tickets = mysqli_query($db, "SELECT * FROM Taquilla.DET_INGRESO WHERE COLABORADOR = $id_user ORDER BY DIT_FECHA ASC");
	if(mysqli_num_rows($Tickets) >= 1)
		{
	 ?>
	<div align="left">
		<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
	</div>
<br>
	<div align="left">
		<a type="button" href="Ajax/DetIngresosPDF.php?mes=<?php echo $mesObtenido?>" target="_blank" class="btn ink-reaction btn-raised btn-primary" >Exportar PDF</a>
	</div>
	
	<?php 
		}
	 ?>
	<br>
	<div style="overflow-x:auto;">
		<table class="table table-hover" id="TblTicketsHotel">
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
		        <th>Adulto No Asociado</th>					     
		        <th>No Asociado Niño</th>
		        <th>Hotel Adulto</th>
		        <th>Hotel Niño</th>
		        <th>Tarjeta Familiar</th>
		        <th>Acompañante Tarjeta Familiar</th>
		        <th>Total no Asociados</th>
		        <th>Niños menores de 5 años</th> 
		        <th>Eventos</th>
		        <th>Cortesías</th>
				<th>Total Ingresos Varios</th>
		        <th>Total Día</th> 
		        <th>Total Mes</th>
		      </tr>
		    </thead>
		    <tbody>
		    <?php
		    $Contador = 1;
		   
		    while($TicketHotelResult = mysqli_fetch_array($Tickets))
		    	{ 
		    		$totalNoAsociados = $TicketHotelResult["INA_NINO"]+$TicketHotelResult["INA_ADULTO"]+$TicketHotelResult["IH_ADULTOS"]+$TicketHotelResult["IH_NINOS"]+$TicketHotelResult["ITF_TITULAR"]+$TicketHotelResult["ITF_ADULTOS"]+$TicketHotelResult["ITF_NINOS"];
		    		$menores5 = $TicketHotelResult["IH_MENORES_5"]+$TicketHotelResult["ITF_MENORES_5"]+$TicketHotelResult["MENORES_5"]+$TicketHotelResult["IA_MENOR5"];
		    		$totalAsociados = $TicketHotelResult["IA_ADULTO"]+$TicketHotelResult["IA_ACOMPANANTE"]+$TicketHotelResult["IA_MENOR"]+$TicketHotelResult["EJERCICIOS"]+ $TicketHotelResult["FORMACION"];
		    		$totalIngresosV = $menores5+$TicketHotelResult["EVENTOS"]+$TicketHotelResult["CORTESIAS"];
		    		$totalDia = $totalNoAsociados+ $totalAsociados+ $menores5+ $TicketHotelResult["EVENTOS"]+ $TicketHotelResult["CORTESIAS"]; 
		    		
		      ?>
		      <tr>
		    	<td><?php echo conocerDiaSemanaFecha($TicketHotelResult["DIT_FECHA"]) ?></td>
		    	<td><?php echo cambio_fecha($TicketHotelResult["DIT_FECHA"])?></td>
		    	<td><?php echo $TicketHotelResult["IA_ADULTO"]?></td>
		    	<td><?php echo $TicketHotelResult["IA_ACOMPANANTE"] ?></td>
		    	<td><?php echo $TicketHotelResult["IA_MENOR"] ?></td>
		    	<td><?php echo $TicketHotelResult["EJERCICIOS"]?></td>
		    	<td><?php echo $TicketHotelResult["FORMACION"]?></td>
		    	<td><?php echo $totalAsociados ?></td>
		    	<td><?php echo $TicketHotelResult["INA_ADULTO"]?></td>
		    	<td><?php echo $TicketHotelResult["INA_NINO"]?></td> 
		    	<td><?php echo $TicketHotelResult["IH_ADULTOS"]?></td>
		    	<td><?php echo $TicketHotelResult["IH_NINOS"]?></td>
		    	<td><?php echo $TicketHotelResult["ITF_TITULAR"]?></td>
		    	<td><?php echo $TicketHotelResult["ITF_ADULTOS"]+$TicketHotelResult["ITF_NINOS"]?></td>
		    	<td><?php echo $totalNoAsociados?></td>
		    	<td><?php echo $menores5?></td> 
		    	<td><?php echo $TicketHotelResult["EVENTOS"]?></td>
		    	<td><?php echo $TicketHotelResult["CORTESIAS"]?></td> 
		    	<td><?php echo $totalIngresosV?></td>
		    	<td><?php echo $totalDia?></td> 	    	 
	    	   </tr>
	    	<?php  
	    	$Contador++;
	    	$adultoAsociado += $TicketHotelResult["IA_ADULTO"];
	    	$acompaAsociado += $TicketHotelResult["IA_ACOMPANANTE"];
	    	$menorAsociado += $TicketHotelResult["IA_MENOR"];
	    	$finalAsociado += $totalAsociados;
	    	$adultoNoAsociado += $TicketHotelResult["INA_ADULTO"];
	    	$ninoNoAsociado += $TicketHotelResult["INA_NINO"];
	    	$adultoHotel += $TicketHotelResult["IH_ADULTOS"];
	    	$ninoHotel += $TicketHotelResult["IH_NINOS"];
			$titularTarjeta +=	$TicketHotelResult["ITF_TITULAR"];
			$acompaTarjeta += $TicketHotelResult["ITF_ADULTOS"]+$TicketHotelResult["ITF_NINOS"];
			$finalNoAsocaido += $totalNoAsociados;
			$totalMenores += $menores5;
			$totalEjercicios += $TicketHotelResult["EJERCICIOS"];
			$totalFormacion += $TicketHotelResult["FORMACION"];
			$totalEventos += $TicketHotelResult["EVENTOS"];
			$totalCortesia += $TicketHotelResult["CORTESIAS"];
			$totalVarios += $totalIngresosV;
			$finalDia += $totalDia;

	    		} 	    	?>
	    	<tr>
	    		<td></td>
	    		<td>Total</td>
	    		<td class="text-center"><?php echo $adultoAsociado ?></td>
	    		<td class="text-center"><?php echo $acompaAsociado ?></td>
	    		<td class="text-center"><?php echo $menorAsociado ?></td>
	    		<td class="text-center"><?php echo $totalEjercicios ?></td>
	    		<td class="text-center"><?php echo $totalFormacion ?></td>
	    		<td class="text-center"><?php echo $finalAsociado ?></td>
	    		<td class="text-center"><?php echo $adultoNoAsociado ?></td>
	    		<td class="text-center"><?php echo $ninoNoAsociado ?></td>
	    		<td class="text-center"><?php echo $adultoHotel ?></td>
	    		<td class="text-center"><?php echo $ninoHotel ?></td>
	    		<td class="text-center"><?php echo $titularTarjeta ?></td>
	    		<td class="text-center"><?php echo $acompaTarjeta ?></td>
	    		<td class="text-center"><?php echo $finalNoAsocaido ?></td>
	    		<td class="text-center"><?php echo $totalMenores ?></td> 
	    		<td class="text-center"><?php echo $totalEventos ?></td>
	    		<td class="text-center"><?php echo $totalCortesia ?></td>
	    		<td class="text-center"><?php echo $totalVarios ?> </td> 
	    		<td class="text-center"><?php echo $finalDia ?></td>
	    	</tr>
		    </tbody>
		  </table>
	</div>		    		

<script>
var Contador = "<?php echo $Contador ?>";
  var tbl_filtrado =  { 
	mark_active_columns: true,
    highlight_keywords: true,
	filters_row_index: 1,
	paging: true,             //paginar 3 filas por pagina
    rows_counter: true,      //mostrar cantidad de filas
    rows_counter_text: "Registros: ", 
	page_text: "Página:",
    of_text: "de",
	btn_reset: true, 
    loader: true, 
    loader_html: "<img src='../../../../../img/Preloader.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
	display_all_text: "-Todos-",
	results_per_page: ["# Filas por Página...",[10,25,50,100, Contador]],  
	btn_reset: true,
	col_0: "select",
	col_5: "select",
	col_6: "select",
  };
  var tf = setFilterGrid('TblTicketsHotel', tbl_filtrado);//fin opciones para tabla de productos

  $('#BtnExportarTicketHotel').click(function(event) {
			$('#TblTicketsHotel').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click
</script>
</html>
