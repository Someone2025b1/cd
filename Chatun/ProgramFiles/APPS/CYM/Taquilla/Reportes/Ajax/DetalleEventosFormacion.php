<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
error_reporting(0);
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$mesObtenido = $_POST['mes'];
$mes = date("m",strtotime($mesObtenido));
$year = date("Y",strtotime($mesObtenido));
$fechaInicial = $_POST["fechaInicial"];
$fechaFinal = $_POST["fechaFinal"];
$dia = $_POST["dia"];
$anio = $_POST["anio"];
if ($fechaInicial != "" and $fechaFinal!="") 
{
 $texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
  $filtroNoA = "DATE(A.IE_FECHA_EVENTO) BETWEEN '$fechaInicial' AND '$fechaFinal'";
 $filtroRefer = "DATE(A.AF_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'";
}
elseif($dia!="")
{
 $texto = "Del día ".cambio_fecha($dia);
 $filtroNoA = "DATE(A.IE_FECHA_EVENTO) = '$dia'";
 $filtroRefer = "DATE(A.AF_FECHA) = '$dia'";
}
elseif($anio!="")
{
 $texto = "Del año ".$anio;
 $filtroNoA = "YEAR(DATE(A.IE_FECHA_EVENTO))= '$anio'";
 $filtroRefer = "YEAR(DATE(A.AF_FECHA))= '$anio'";
}
elseif($mesObtenido!="")
{
 $texto = "Del mes ".$mes." y año ".$year;
 $filtroNoA = "MONTH(DATE(A.IE_FECHA_EVENTO))= '$mes' and YEAR(DATE(A.IE_FECHA_EVENTO))= '$year'";
 $filtroRefer = "MONTH(DATE(A.AF_FECHA))= '$mes'and YEAR(DATE(A.AF_FECHA))= '$year'";
}

$selectDetalle = mysqli_query($db, "SELECT A.E_ID, A.AU_ID, A.NOMBRE_EVENTO, A.IE_DUENO_EVENTO, A.IE_CANTIDAD_PERSONAS, C.CE_DESCRIPCION, A.IE_NOMBRE_EMPRESA,
A.IE_TEL_EMPRESA, A.IE_MUNICIPIO, A.IE_DEPTO, A.IE_PAIS, A.IE_FECHA_EVENTO, 'EVENTO'
FROM Taquilla.INGRESO_EVENTO A  
INNER JOIN Taquilla.CLASIFICADOR_EVENTO C ON C.CE_ID = A.CE_ID 
WHERE $filtroNoA
UNION ALL 
SELECT  A.E_ID, A.AU_ID, A.NOMBRE_EVENTO, A.IE_DUENO_EVENTO, A.AF_PARTICIPANTES, C.CE_DESCRIPCION, A.IE_NOMBRE_EMPRESA,
A.IE_TEL_EMPRESA, A.AF_MUNICIPIO, A.AF_DEPTO, A.AF_PAIS, A.AF_FECHA, P.PA_DESCRIPCION
FROM Taquilla.ASOCIADOS_FORMACION A 
INNER JOIN Taquilla.PROGRAMAS_ACTIVOS P ON P.PA_ID = A.PA_ID 
INNER JOIN Taquilla.CLASIFICADOR_EVENTO C ON C.CE_ID = A.CE_ID
WHERE $filtroRefer");
?>

<!DOCTYPE html>
<html lang="en">
<title>Listado Eventos y Formación 
<?php echo $texto ?></title>
<head> 
	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
</head>
	<center>
		<h4>Listado Referencias
		<?php echo $texto ?></h4>
	</center>
	<div style="overflow-x:auto;">
		<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblEventos" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 
			    <thead>
		      <tr>
		      	<th>#</th>
		      	<th>Evento</th>
		        <th>Nombre Evento</th>
		        <th>Dueño Evento </th> 
		        <th>Cantidad Personas</th>
		        <th>Área Utilizar</th>
		        <th>Clasificador</th> 
		        <th>Nombre Empresa</th> 
		        <th>Tel Empresa</th>
		        <th>Procedencia</th>
		        <th>Programa</th>
		        <th>Fecha Evento</th>
		      </tr>
		    </thead>
		    <tbody>
		    <?php
		    $Contador = 1;
		   
		    while($TicketHotelResult = mysqli_fetch_array($selectDetalle))
		    	{
	    		if($TicketHotelResult['IE_PAIS'] == 73)
	    		{
	    			$SaberDepartamento = saber_departamento($TicketHotelResult['IE_DEPTO']);
	    			$tmp_sql = mysqli_fetch_row(mysqli_query($db, "SELECT nombre_municipio FROM info_base.municipios_guatemala WHERE id_departamento = $TicketHotelResult[IE_DEPTO] AND id_municipio = $TicketHotelResult[IE_MUNICIPIO] "));
	    			$SaberMunicipio = $tmp_sql[0];
	    			$Procedencia = $SaberMunicipio.", ".$SaberDepartamento.", Guatemala";

	    		}
	    		else
	    		{
	    			 $QueryP = "SELECT *FROM info_base.lista_paises_mundo a WHERE a.id = $TicketHotelResult[IE_PAIS]";
                    $ResultP = mysqli_fetch_array(mysqli_query($db, $QueryP));
	    			
	    			$Procedencia = $ResultP["pais"];
	    		} 	
	    		
	    		$AreaUtilizar = mysqli_fetch_array(mysqli_query($db, "SELECT a.AU_DESCRIPCION FROM Taquilla.AREA_UTILIZAR a WHERE a.AU_ID = $TicketHotelResult[AU_ID] "));
	    		$Evento = mysqli_fetch_array(mysqli_query($db, "SELECT a.E_DESCRIPCION FROM Taquilla.EVENTO a WHERE a.E_ID = $TicketHotelResult[E_ID] "));
	    		   
		      ?>
		      <tr>
		      	<td><?php echo $Contador?></td>
		      	<td><?php echo $Evento['E_DESCRIPCION'] ?></td>
		    	<td><?php echo $TicketHotelResult['NOMBRE_EVENTO'] ?></td> 
		    	<td><?php echo $TicketHotelResult['IE_DUENO_EVENTO']?></td>
		    	<td><?php echo $TicketHotelResult['IE_CANTIDAD_PERSONAS'] ?></td> 
		      	<td><?php echo $AreaUtilizar['AU_DESCRIPCION'] ?></td>
		    	<td><?php echo $TicketHotelResult['CE_DESCRIPCION'] ?></td> 
		    	<td><?php echo $TicketHotelResult['IE_NOMBRE_EMPRESA'] ?></td> 
		    	<td><?php echo $TicketHotelResult['IE_TEL_EMPRESA'] ?></td> 
		    	<td><?php echo $Procedencia?></td>
		    	<td><?php echo $TicketHotelResult['EVENTO'] ?></td> 
		    	<td><?php echo $TicketHotelResult['IE_FECHA_EVENTO']?></td> 
	    	   </tr>
	    	<?php  
	    	$Contador++;
	    		}
	    	?>
		    </tbody>
		  </table>
		</div>
	</div>		    		
 