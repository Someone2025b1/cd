<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$mesObtenido = $_POST['mes'];
$fechaInicial = $_POST["fechaInicial"];
$fechaFinal = $_POST["fechaFinal"]; 
$dia = $_POST["dia"];
$anio = $_POST["anio"];
if ($fechaInicial != "" and $fechaFinal!="") 
{
 $texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
 $filtroAsociados = "DATE(A.IA_FECHA_INGRESO) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroNoA = "DATE(a.INA_FECHA_INGRESO) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroProgramas = "DATE(a.AF_FECHA) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroEvento = "DATE(a.IE_FECHA_EVENTO) BETWEEN '$fechaInicial' AND '$fechaFinal'";
 $filtroCortesia = "DATE(a.IC_FECHA) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroHotel = "DATE(A.IH_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'";
 $filtroTar = "DATE(A.ITF_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'";
 $filtroRefer = "DATE(A.AF_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'";
}
elseif($dia!="")
{
 $texto = "Del día ".cambio_fecha($dia);
 $filtroAsociados = "DATE(A.IA_FECHA_INGRESO) = '$dia'";
 $filtroNoA = "DATE(a.INA_FECHA_INGRESO) = '$dia'";
 $filtroProgramas = "DATE(a.AF_FECHA) = '$dia'";
 $filtroEvento = "DATE(a.IE_FECHA_EVENTO) = '$dia'";
 $filtroCortesia = "DATE(a.IC_FECHA) = '$dia'";
 $filtroHotel = "DATE(A.IH_FECHA) = '$dia'";
 $filtroTar = "DATE(A.ITF_FECHA) = '$dia'";
 $filtroRefer = "DATE(A.AF_FECHA) = '$dia'";
}
elseif($anio!="")
{
 $texto = "Del año ".$anio;
 $filtroAsociados = "YEAR(DATE(A.IA_FECHA_INGRESO)) = '$anio'";
 $filtroNoA = "YEAR(DATE(a.INA_FECHA_INGRESO)) = '$anio'";
 $filtroProgramas = "YEAR(DATE(a.AF_FECHA)) = '$anio'";
 $filtroEvento = "YEAR(DATE(a.IE_FECHA_EVENTO)) = '$anio'";
 $filtroCortesia = "YEAR(DATE(a.IC_FECHA)) = '$anio'";
 $filtroHotel = "YEAR(DATE(A.IH_FECHA))= '$anio'";
 $filtroTar = "YEAR(DATE(A.ITF_FECHA))= '$anio'";
 $filtroRefer = "YEAR(DATE(A.AF_FECHA))= '$anio'";
}
//ASOCIADOS
$selectAsociados = mysqli_query($db, "SELECT A.IAT_CIF_ASOCIADO
FROM Taquilla.INGRESO_ASOCIADO AS A 
WHERE $filtroAsociados
GROUP BY A.IA_FECHA_INGRESO, A.IAT_CIF_ASOCIADO
");
$mayor =0;
$menor= 0;
$menor5=0;
while($rowTarAdultos = mysqli_fetch_array($selectAsociados))
{
	$edad = Saber_Edad_Asociado($rowTarAdultos['IAT_CIF_ASOCIADO']);

	if ($edad>18) {
		$mayor ++; 
	}
	elseif($edad > 4 && $edad <= 18)
	{
		$menor++; 
	}
	else
    { 
		$menor5++;
    } 
}
 


$asociadosAcomp = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(IAT_NOMBRE) as total 
FROM Taquilla.INGRESO_ACOMPANIANTE AS A
WHERE $filtroAsociados  
 "));

 
//no asociados
$noAsociadosAdulto = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_ADULTO) AS SUMA FROM Taquilla.INGRESO_NO_ASOCIADO a
WHERE $filtroNoA AND a.INA_ADULTO>0  
 "));

$noAsociadosAdultoM = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_ADULTO_MAYOR) AS SUMA FROM Taquilla.INGRESO_NO_ASOCIADO a
WHERE $filtroNoA AND a.INA_ADULTO_MAYOR>0  
 "));

$noAsociadosNino = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_NINIO) AS SUMA FROM Taquilla.INGRESO_NO_ASOCIADO a
WHERE $filtroNoA AND a.INA_NINIO>0  
 "));

//HOTELES
$selectHotel = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(A.IH_ADULTOS) AS ADULTOS, SUM(A.IH_NINOS) AS MENORES, SUM(A.IH_MENORES_5) AS MENORES5 FROM Taquilla.INGRESO_HOTEL A 
WHERE $filtroHotel
"));


 //tarjetas insert
$selectTarj = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(A.ITF_ADULTOS) AS ADULTOS, SUM(A.ITF_NINOS) AS NINOS, SUM(A.ITF_MENORES_5) AS MENORES5
FROM Taquilla.INGRESO_TARJETAS_FAMILIARES A 
WHERE $filtroTar
"));

$ContarTar = mysqli_fetch_array(mysqli_query($db, "SELECT count(*) as Cont
FROM Taquilla.INGRESO_TARJETAS_FAMILIARES A 
WHERE $filtroTar
"));
 
//MENORES 5 AÑOS INSERT 

$selectUpdMenor = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_NINIO_MENOR_5) AS MENORES5 FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE $filtroNoA AND a.INA_NINIO_MENOR_5>0  "));

  
//EJERCICIOS

$selectEjercicios = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.AF_PARTICIPANTES) AS SUMA FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.PROGRAMAS_ACTIVOS b ON a.PA_ID = b.PA_ID
WHERE $filtroProgramas AND a.PA_ID IN (6,8)"));
  
//FORMACION

$selectFormacion = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.AF_PARTICIPANTES) AS SUMA FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.CLASIFICADOR_EVENTO c ON c.CE_ID = a.CE_ID
WHERE $filtroProgramas #AND a.CE_ID = 1 SE comento para que todos los asociados salgan donde pertenecen
 ")); 
//EVENTOS INSERT
 
$selectEventos1 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.IE_CANTIDAD_PERSONAS)  AS SUMA
FROM Taquilla.INGRESO_EVENTO a  
INNER JOIN Taquilla.CLASIFICADOR_EVENTO C ON C.CE_ID = a.CE_ID 
WHERE $filtroEvento"));
 
#$selectEventos2 = mysqli_fetch_array(mysqli_query($db,"SELECT  SUM(A.AF_PARTICIPANTES) AS SUMA
#FROM Taquilla.ASOCIADOS_FORMACION A 
#INNER JOIN Taquilla.PROGRAMAS_ACTIVOS P ON P.PA_ID = A.PA_ID 
#INNER JOIN Taquilla.CLASIFICADOR_EVENTO C ON C.CE_ID = A.CE_ID 
#WHERE $filtroRefer AND A.CE_ID NOT IN (1)"));
$SumaEventos = $selectEventos1["SUMA"];#+$selectEventos2["SUMA"]; se comento para que no sume de mas

 
//CORTESIAS INSERT

$selectCortesia = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.IC_CANTIDAD_PERSONAS) AS SUMA FROM Taquilla.INGRESO_CORTESIA a
WHERE $filtroCortesia"));
 
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
 
	<div align="left">
		<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
	</div> <br>
	<div align="left">
		<a type="button" href="Ajax/DetReferenciacion.php?mesObtenido=<?php echo $mesObtenido?>&fechaInicial=<?php echo $fechaInicial?>&fechaFinal=<?php echo $fechaFinal?>&dia=<?php echo $dia?>&anio=<?php echo $anio?>" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar PDF</a>
	</div> 
	<br>
	<div style="overflow-x:auto;">
		<table class="table table-hover" id="TblTicketsHotel">
		    <thead>
		      <tr>
		      	<td class="text-center"><h1>INGRESO ASOCIADOS <?php echo $texto ?></h1></td>
		      </tr>
		    </thead>
		    <tbody> 
		      <tr>
		    	<td>TITULAR TARJETA MI COOPE</td>
		    	<td><?php echo $mayor ?></td>
		   	  </tr>
		   	  <tr>
		    	<td>ACOMPAÑANTES TARJETA MI COOPE</td>
		    	<td><?php echo $asociadosAcomp["total"] ?></td>
		   	  </tr>
		   	  <tr>
		    	<td>NIÑOS TARJETA MI COOPE</td>
		    	<td><?php echo $menor ?></td>
		   	  </tr>
		   	   <tr>
		    	<td>EJERCICIOS</td>
		    	<td><?php echo $selectEjercicios["SUMA"] ?></td>
		   	  </tr>
		   	  <tr>
		    	<td>FORMACION</td>
		    	<td><?php echo $selectFormacion["SUMA"] ?></td>
		   	  </tr>
		   	  <tr>
		   	  <tr bgcolor="#ddd">
		    	<td>TOTAL ASOCIADOS</td>
		    	<td><?php $totalAsociado = $mayor+$asociadosAcomp["total"]+$menor+$selectEjercicios["SUMA"]+$selectFormacion["SUMA"];
		    	echo $totalAsociado?></td>
		   	  </tr>
		   	  <tr>
		    	<td>ADULTO NO ASOCIADO</td>
		    	<td><?php echo $noAsociadosAdulto["SUMA"] ?></td>
		   	  </tr>
				 <tr>
		    	<td>ADULTO MAYOR NO ASOCIADO</td>
		    	<td><?php echo $noAsociadosAdultoM["SUMA"] ?></td>
		   	  </tr>
		   	  <tr>
		    	<td>NIÑO NO ASOCIADO</td>
		    	<td><?php echo $noAsociadosNino["SUMA"] ?></td>
		   	  </tr>
		   	  <tr>
		    	<td>HOTEL ADULTO</td>
		    	<td><?php echo $selectHotel["ADULTOS"] ?></td>
		   	  </tr>
		   	  <tr>
		    	<td>HOTEL NIÑOS</td>
		    	<td><?php echo $selectHotel["MENORES"] ?></td>
		   	  </tr>
		   	  <tr>
		    	<td>TARJETAS FAMILIARES</td>
		    	<td><?php echo $ContarTar["Cont"] ?></td>
		   	  </tr>
		   	  <tr>
		    	<td>ACOMPAÑANTES TARJETAS FAMILIARES</td>
		    	<td><?php echo $selectTarj["NINOS"]+$selectTarj["ADULTOS"] ?></td>
		   	  </tr>
		   	  <tr bgcolor="#ddd">
		    	<td>TOTAL NO ASOCIADOS</td>
		    	<td><?php
		    		$totalNoAsociado = $noAsociadosAdulto["SUMA"]+$noAsociadosAdultoM["SUMA"]+$noAsociadosNino["SUMA"]+$selectHotel["ADULTOS"]+$selectHotel["MENORES"]+$selectTarj["ADULTOS"]+$selectTarj["NINOS"];
					echo $totalNoAsociado ?></td>
		   	  </tr>
		   	  <tr>
		    	<td>NIÑOS MENORES 5 AÑOS</td>
		    	<td><?php echo $selectTarj["MENORES5"]+$selectHotel["MENORES5"]+$selectUpdMenor["MENORES5"]+$menor5 ?></td>
		   	  </tr> 
		    	<td>EVENTOS</td>
		    	<td><?php echo $SumaEventos ?></td>
		   	  </tr>
		   	  <tr>
		    	<td>CORTESÍAS</td>
		    	<td><?php echo $selectCortesia["SUMA"] ?></td>
		   	  </tr>
		   	  <tr bgcolor="#ddd">
		    	<td>TOTAL INGRESOS VARIOS</td>
		    	<td><?php
		    		$totalIV = $selectTarj["MENORES5"]+$selectHotel["MENORES5"]+$selectUpdMenor["MENORES5"]+$SumaEventos+$selectCortesia["SUMA"]+$menor5;
					echo $totalIV ?></td>
		   	  </tr>
		   	  <tr bgcolor="#62CE46">
		    	<td>TOTAL</td>
		    	<td><?php
		    		$totalM = $totalNoAsociado+$totalIV+$totalAsociado;
					echo $totalM ?></td>
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
