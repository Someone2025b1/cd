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
    <th class="text-center">Eliminar</th>
  </tr>
</thead>
<tbody>
 <?php 
$Detalle = mysqli_query($db,  "SELECT a.DC_Id, b.H_NOMBRE, a.DC_Del, a.DC_Al, a.DC_Total, a.DC_Adultos, a.DC_TotalAdulto, a.DC_Ninos,
a.DC_TotalNino, a.DC_TotalMonto, a.DC_AdultosM, a.DC_TotalAdultoM 
FROM Taquilla.DETALLE_FAC_HOTEL a 
INNER JOIN Taquilla.HOTEL b ON b.H_CODIGO = a.H_CODIGO
WHERE a.CH_Id = $IdCorte AND a.DC_Estado = 1 ORDER BY a.DC_Id ASC");
 while ($Row = mysqli_fetch_array($Detalle)) 
 {
 ?>
 <tr>
	<td><?php echo $fechaHoy?></td>  
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
	<td align="center"><button type="button" class="btn ink-reaction btn-raised btn-danger"  onclick="eliminar('<?php echo $Row[DC_Id] ?>')">X</button></td>   
   </tr>
 <?php 
 $totalVales += $Row['DC_Total'];
 $Adulto += $Row['DC_Adultos'];
 $totalAdulto += $Row['DC_TotalAdulto'];
 $Nino += $Row['DC_Ninos'];
 $totalNino += $Row['DC_TotalNino']; 
 $totalHotel += $Row['DC_TotalMonto'];
 }
 ?>
  <tr>
	<td><?php echo $fechaHoy?></td>  
	<td align="center"><button type="button" class="btn ink-reaction btn-raised btn-primary"  onclick="verHoteles()">Hotel</button></td>
	<td align="center"><?php echo $TicketHotelResult['NINOS']?></td>
	<td align="center"><?php echo $total?></td>   	 
   </tr>
<tfoot>
	<tr style="display: none">
        <td></td>
        <td></td>
        <td style="text-align: right; vertical-align: text-top; font-size: 18px"><b>Descuento Q.</b></td>
        <td style="text-align: left; vertical-align: text-top; font-size: 18px"><input class="form-control" type="text" id="BoldDescuento" name="TotalFacturaConDescuento" value="0.00" readonly></td>
        <td></td>
    </tr>
	<tr>
        <td></td>
        <td></td>
		<td></td>
		<td></td> 
		<td class="text-center"><?php echo $totalVales ?> </td> 
		<td class="text-center"><?php echo $Adulto ?> </td>
		<td class="text-center"><?php echo $totalAdulto ?> </td> 	
		<td class="text-center"><?php echo $Nino ?> </td> 	
		<td class="text-center"><?php echo $totalNino ?> </td>
        <td style="text-align: right; vertical-align: text-top; font-size: 20px"><b>Total Q.</b></td>
        <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="BoldTotal" name="TotalFacturaFinal" value="<?php echo $totalHotel ?>" readonly></td>
        <td></td>
    </tr>
</tfoot>  
</tbody>
</table>
<input type="hidden" name="TotalCorte" id="TotalCorte" value="<?php echo $totalHotel?>">
<script type="text/javascript">
	function eliminar(Id)
	{
		$.ajax({
			url: '../Ajax/EliminarDetalle.php',
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