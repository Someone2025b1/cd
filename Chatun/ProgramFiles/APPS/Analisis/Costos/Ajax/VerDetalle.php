 <?php  
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
$Anio = $_POST["Anio"];
$Contador = count($Anio);
$Producto = $_POST["Producto"];
$ContadorP = count($Producto);
$ContadorP1 = count($Producto);
?>

	<table class="table table-hover">
		<thead>
			<tr>
				<th>Productos</th>
				 <?php 		
				 for ($i=0; $i < $Contador; $i++) 
				 { 
				 	?>
				 	 <th class="text-center"> 
				 	 	<?php echo $Anio[$i]; ?>
				 	 </th>
				 <?php } ?>
			</tr>
		</thead>
	<tbody>	
		
		<?php 
		for ($i=0; $i < $ContadorP; $i++) {  
			$Prod = mysqli_query($db, "SELECT P_CODIGO, P_NOMBRE FROM Bodega.PRODUCTO a where P_CODIGO = $Producto[$i]");
			while ($Row = mysqli_fetch_array($Prod)) 
			{
				$Nombre = $Row["P_NOMBRE"];
				?>
				<tr>
				 <td><h4><?php echo $Nombre; ?></h4></td>
				 <?php 		
				 for ($j=0; $j < $Contador; $j++) 
				 { 
				 	$Precio = mysqli_fetch_array(mysqli_query($db, "SELECT AVG(a.TRAD_PRECIO_UNITARIO) AS Precio  FROM Bodega.TRANSACCION_DETALLE a 
					INNER JOIN Bodega.PRODUCTO b ON a.P_CODIGO = b.P_CODIGO
					INNER JOIN Bodega.TRANSACCION c ON a.TRA_CODIGO = c.TRA_CODIGO
					WHERE YEAR(c.TRA_FECHA_TRANS) = $Anio[$j] AND a.TRAD_PRECIO_UNITARIO > 0
					AND b.P_CODIGO = $Producto[$i]")); 
				 	?>
				 	 <td class="text-center"> 
				 	 	<?php echo number_format($Precio["Precio"],2); ?>
				 	 </td>
				 <?php   
				 } 
				 ?> 
				</tr>
				<?php  
	} 
		} 
		?> 	 
	</tbody>
	<tfoot> 
		<tr>
			<td>Total</td>
		<?php  
	for ($k=0; $k < $Contador; $k++) 
		 {	 
		      
		 		$Sum = 0;
		 	 
		 	for ($i=0; $i < $ContadorP1; $i++) 
		 	{    
		 		$PrecioF = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.TRAD_PRECIO_UNITARIO) AS Precio  FROM Bodega.TRANSACCION_DETALLE a 
				INNER JOIN Bodega.PRODUCTO b ON a.P_CODIGO = b.P_CODIGO
				INNER JOIN Bodega.TRANSACCION c ON a.TRA_CODIGO = c.TRA_CODIGO
				WHERE YEAR(c.TRA_FECHA_TRANS) = $Anio[$k] AND a.TRAD_PRECIO_UNITARIO > 0
				AND b.P_CODIGO = $Producto[$i]")); 
				$PrecioC = mysqli_num_rows(mysqli_query($db, "SELECT *FROM Bodega.TRANSACCION_DETALLE a 
				INNER JOIN Bodega.PRODUCTO b ON a.P_CODIGO = b.P_CODIGO
				INNER JOIN Bodega.TRANSACCION c ON a.TRA_CODIGO = c.TRA_CODIGO
				WHERE YEAR(c.TRA_FECHA_TRANS) = $Anio[$k] AND a.TRAD_PRECIO_UNITARIO > 0
				AND b.P_CODIGO = $Producto[$i]")); 
				$Prom = $PrecioF["Precio"] / $PrecioC;
				$Sum += $Prom;
			}	 
			?>
			<td class="text-center"> 
	 	 	<b><?php echo number_format($Sum,2); ?></b>
	 	 	</td>
	 	 	<?php 
	   }
	?> 	 
 
		</tr>
	</tfoot>
</table>					

 