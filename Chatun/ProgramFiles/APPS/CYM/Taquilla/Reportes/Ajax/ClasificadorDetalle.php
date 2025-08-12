<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$mesObtenido = $_POST['mes'];
$mes = date("m",strtotime($mesObtenido));
$year = date("Y",strtotime($mesObtenido));
$fechaInicial = $_POST["fechaInicial"];
$fechaFinal = $_POST["fechaFinal"];
$selectClasificador = $_POST["selectClasificador"];
$dia = $_POST["dia"];
$anio = $_POST["anio"];
if ($fechaInicial != "" and $fechaFinal!="") 
{
 $texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
  $filtroNoA = "DATE(a.AF_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'"; 
}
elseif($dia!="")
{
 $texto = "Del día ".cambio_fecha($dia);
 $filtroNoA = "DATE(a.AF_FECHA) = '$dia'"; 
}
elseif($anio!="")
{
 $texto = "Del año ".$anio;
 $filtroNoA = "YEAR(DATE(a.AF_FECHA))= '$anio'"; 
}
elseif($mesObtenido!="")
{
 $texto = "Del mes ".$mes."	y año ".$year;
 $filtroNoA = "MONTH(DATE(a.AF_FECHA))= '$mes' and YEAR(DATE(a.AF_FECHA))= '$year'"; 
}
if ($selectClasificador=="x")
{
 $filtroClasificador= " ";
}
else
{
 $filtroClasificador = "a.CE_ID = $selectClasificador AND";
}

$selectDetalle = mysqli_query($db, "SELECT SUM(a.AF_PARTICIPANTES) AS SUMA, b.PA_DESCRIPCION, COUNT(a.AF_ID) AS CONTADOR FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.PROGRAMAS_ACTIVOS b ON a.PA_ID = b.PA_ID
WHERE $filtroClasificador $filtroNoA 
GROUP BY a.PA_ID");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<title>CONTEO DE EVENTOS 
<?php echo $texto ?></title>
</head>
			<center>
				<h4>CONTEO DE EVENTOS 
				<?php echo $texto ?></h4>
			</center>
	<br>
	<div style="overflow-x:auto;">
		<table class="table table-hover" id="TblDet">
		    <thead>
		      <tr>
		      	<th align="center">TIPO DE EVENTO</th>
		        <th align="center">ASISTENTES</th>
		        <th align="center">CANTIDAD DE EVENTOS</th>  
		      </tr>
		    </thead>
		    <tbody>
		    <?php
		    $Contador = 1;
		   
		    while($TicketHotelResult = mysqli_fetch_array($selectDetalle))
		    	{   
		    		$totalSuma+= $TicketHotelResult['SUMA'];
		    		$totalCont+= $TicketHotelResult['CONTADOR'];
		      ?>
		      <tr> 
		    	<td><?php echo $TicketHotelResult['PA_DESCRIPCION'] ?></td>
		    	<td class="text-center"><?php echo $TicketHotelResult['SUMA']?></td>
		    	<td class="text-center"><?php echo $TicketHotelResult['CONTADOR']?></td> 
	    	   </tr>
	    	<?php  
	    	$Contador++;
	    		}
	    	?>
	    	<tr bgcolor="#74DF00">
	    		<td>Total</td>
	    		<td class="text-center"><?php echo $totalSuma ?></td>
	    		<td class="text-center"><?php echo $totalCont ?></td>
	    	</tr>
		    </tbody>
		  </table>
	</div>		    		
 