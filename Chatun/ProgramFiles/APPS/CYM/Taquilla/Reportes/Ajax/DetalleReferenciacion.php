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
$dia = $_POST["dia"];
$anio = $_POST["anio"];
if ($fechaInicial != "" and $fechaFinal!="") 
{
 $texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
  $filtroNoA = "DATE(A.IA_FECHA_INGRESO) BETWEEN '$fechaInicial' AND '$fechaFinal'";
 $filtroRefer = "DATE(a.IR_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'";
}
elseif($dia!="")
{
 $texto = "Del día ".cambio_fecha($dia);
 $filtroNoA = "DATE(A.IA_FECHA_INGRESO) = '$dia'";
 $filtroRefer = "DATE(a.IR_FECHA) = '$dia'";
}
elseif($anio!="")
{
 $texto = "Del año ".$anio;
 $filtroNoA = "YEAR(DATE(A.IA_FECHA_INGRESO))= '$anio'";
 $filtroRefer = "YEAR(DATE(A.IR_FECHA))= '$anio'";
}
elseif($mesObtenido!="")
{
 $texto = "Del mes ".$mes." y año ".$year;
 $filtroNoA = "MONTH(DATE(A.IA_FECHA_INGRESO))= '$mes' and YEAR(DATE(A.IA_FECHA_INGRESO))= '$year'";
 $filtroRefer = "MONTH(DATE(a.IR_FECHA))= '$mes'and YEAR(DATE(a.IR_FECHA))= '$year'";
}


$selectDetalle = mysqli_query($db, "SELECT A.IAT_NOMBRE, A.IAT_SELECT_MUNICIPIO, A.IAT_SELECT_DEPARTAMENTO, A.IAT_SELECT_PAIS, A.IAT_EDAD, A.IAT_TELEFONO, A.IAT_CORREO as Descripcion, A.IA_FECHA_INGRESO FROM Taquilla.INGRESO_ACOMPANIANTE A 
WHERE $filtroNoA and A.IAT_SELECT_MUNICIPIO > 0
UNION ALL
SELECT a.IR_NOMBRE_COMPLETO, a.IR_MUNICIPIO, a.IR_DEPARTAMENTO, a.IR_PAIS, a.IR_EDAD, a.IR_TELEFONO, b.TR_DESCRIPCION as Descripcion, DATE(a.IR_FECHA) FROM Taquilla.INGRESO_REFERENCIACION a 
INNER JOIN Taquilla.TIPO_REFERENCIA b ON a.TR_ID = b.TR_ID
WHERE $filtroRefer and a.IR_MUNICIPIO > 0");
?>

<!DOCTYPE html>
<html lang="en">
<title>Listado Referencias 
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
		<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 
			    <thead>
		      <tr>
		      	<th>#</th>
		        <th>Nombre</th>
		        <th>Dirección</th> 
		        <th>Edad</th>
		        <th>Teléfono</th> 
		        <th>Tipo referencia</th> 
		        <th>Fecha Ingreso</th>
		      </tr>
		    </thead>
		    <tbody>
		    <?php
		    $Contador = 1;
		   
		    while($TicketHotelResult = mysqli_fetch_array($selectDetalle))
		    	{
		    	if($TicketHotelResult['IAT_SELECT_PAIS'] == 79)
	    		{
	    			$SaberDepartamento = saber_departamento_honduras($TicketHotelResult[IAT_SELECT_PAIS]);
	    			$SaberMunicipio = "";
	    		}
	    		if($TicketHotelResult['IAT_SELECT_PAIS'] == 73)
	    		{
	    			$SaberDepartamento = saber_departamento($TicketHotelResult['IAT_SELECT_DEPARTAMENTO']);
	    			$tmp_sql = mysqli_fetch_array(mysqli_query($db, "SELECT nombre_municipio FROM info_base.municipios_guatemala WHERE id_departamento = $TicketHotelResult[IAT_SELECT_DEPARTAMENTO] AND id = $TicketHotelResult[IAT_SELECT_MUNICIPIO] "));
	    			$SaberMunicipio = $tmp_sql['nombre_municipio'];

	    		}
	    		if($TicketHotelResult['IAT_SELECT_PAIS'] == 54)
	    		{
	    			$SaberDepartamento = saber_departamento_salvador($TicketHotelResult[IAT_SELECT_PAIS]);
	    			$SaberMunicipio = "";
	    		} 	
	    		
	    		   
		      ?>
		      <tr>
		      	<td><?php echo $Contador?></td>
		    	<td><?php echo $TicketHotelResult[IAT_NOMBRE] ?></td>
		    	<td><?php echo $SaberMunicipio.", ".$SaberDepartamento?></td>
		    	<td><?php echo $TicketHotelResult[IAT_EDAD]?></td>
		    	<td><?php echo $TicketHotelResult[IAT_TELEFONO] ?></td>
		    	<td><?php echo $TicketHotelResult[Descripcion] ?></td> 
		    	<td><?php echo cambio_fecha($TicketHotelResult[IA_FECHA_INGRESO])?></td> 
	    	   </tr>
	    	<?php  
	    	$Contador++;
	    		}
	    	?>
		    </tbody>
		  </table>
		</div>
	</div>		    		


<script>
	$('#TblTicketsHotel').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
    });
	 $('#BtnExportarTicketHotel').click(function(event) {
			$('#TblTicketsHotel').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click

	 
</script>