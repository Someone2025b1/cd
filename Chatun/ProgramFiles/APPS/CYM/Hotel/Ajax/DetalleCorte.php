 <?php  
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
$IdCorte = $_POST["IdCorte"];
$Contador = 1;
	?>
<table class="table table-hover" id="TblTicketsHotel">
<thead> 
  <tr> 
    <th class="text-center">Fecha</th>
    <th class="text-center">No. Factura</th> 
    <th>NOMBRE</th>
    <th>DEL</th>
    <th>AL</th>
    <th>Total Vales</th>
    <th>TICKET ADULTO</th>
    <th>TOTAL Q.</th>
	<th>TICKET ADULTO MAYOR</th>
    <th>TOTAL Q.</th>
    <th>TICKET NIÑO</th>
    <th>TOTAL Q.</th>
    <th>Monto</th> 
  </tr>
</thead>
<tbody>
 <?php 
$Detalle = mysqli_query($db,  "SELECT c.CH_Factura, a.DC_Id, b.H_NOMBRE, a.DC_Del, a.DC_Al, a.DC_Total, a.DC_Adultos, a.DC_TotalAdulto, a.DC_AdultosM, a.DC_TotalAdultoM, a.DC_Ninos,
a.DC_TotalNino, a.DC_TotalMonto 
FROM Taquilla.DETALLE_FAC_HOTEL a
INNER JOIN Taquilla.FAC_HOTEL c ON c.CH_Id = a.CH_Id 
INNER JOIN Taquilla.HOTEL b ON b.H_CODIGO = a.H_CODIGO
WHERE a.DC_Estado = 1 ORDER BY a.DC_Id ASC");
 while ($Row = mysqli_fetch_array($Detalle)) 
 {
 ?>
 <tr>
	<td><?php echo $fechaHoy?></td> 
	<td><?php echo $Row["CH_Factura"] ?></td>
	<td align="center"><?php echo $Row['H_NOMBRE']?></td>
	<td align="center"><?php echo $Row['DC_Del']?></td>
	<td align="center"><?php echo $Row['DC_Al']?></td>
	<td align="center"><?php echo $Row['DC_Total']?></td>  	
	<td align="center"><?php echo $Row['DC_Adultos']?></td>  
	<td align="center">Q. <?php echo $Row['DC_TotalAdulto']?></td>  
	<td align="center"><?php echo $Row['DC_AdultosM']?></td>  
	<td align="center">Q. <?php echo $Row['DC_TotalAdultoM']?></td> 
	<td align="center"><?php echo $Row['DC_Ninos']?></td>     	
	<td align="center">Q. <?php echo $Row['DC_TotalNino']?></td>  
	<td align="center"><?php echo $Row['DC_TotalMonto']?></td> 
   </tr>
 <?php 
 $totalVales += $Row['DC_Total'];
 $Adulto += $Row['DC_Adultos'];
 $AdultoM += $Row['DC_AdultosM'];
 $totalAdulto += $Row['DC_TotalAdulto'];
 $totalAdultoM += $Row['DC_TotalAdultoM'];
 $Nino += $Row['DC_Ninos'];
 $totalNino += $Row['DC_TotalNino']; 
 $totalHotel += $Row['DC_TotalMonto'];
 }
 ?>
  
	<td>Total</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td> 
	<td class="text-center"><?php echo $totalVales ?> </td> 
	<td class="text-center"><?php echo $Adulto ?> </td>
	<td class="text-center">Q. <?php echo $totalAdulto ?> </td> 
	<td class="text-center"><?php echo $AdultoM ?> </td>
	<td class="text-center">Q. <?php echo $totalAdultoM ?> </td>	
	<td class="text-center"><?php echo $Nino ?> </td> 	
	<td class="text-center">Q. <?php echo $totalNino ?> </td> 
	<td class="text-center">Q. <?php echo number_format($totalHotel,2) ?></td>
</tr>
</tbody>
</table>
<input type="hidden" name="TotalCorte" id="TotalCorte" value="<?php echo $totalHotel?>">
<script type="text/javascript">
	function eliminar(Id)
	{
		$.ajax({
			url: 'Ajax/EliminarDetalle.php',
			type: 'POST',
			dataType: 'html',
			data: {Id: Id},
			success:function(data)
			{
				if (data==1) 
				{
					 Tabla();
				}
				else
				{
					alertify.error("Error");
				}
			}
		})  
		 
	}
</script>