<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$IdCombo = $_POST["IdCombo"];
?>
<table class="table table-hover table-condensed" id="tbl_resultados">
	<thead>
		<th><strong>No.</strong></th>
		<th><strong>Juego</strong></th> 
		<th><strong>Precio</strong></th>
		<th><strong>Precio Real</strong></th>
		<th><strong>Precio %</strong></th>
		<th><strong>Precio Combo</strong></th>
		<th><strong>Descuento</strong></th>
		<th><strong>Eliminar</strong></th>
	</thead>
	<tbody>
	<?php
		$Detalle = "SELECT a.P_NOMBRE, a.P_CODIGO, a.P_PRECIO FROM Bodega.PRODUCTO a 
			INNER JOIN Bodega.COMBO_DETALLE b ON b.P_CODIGO = a.P_CODIGO
			WHERE a.CP_CODIGO = 'JG'  AND b.Combo_Id = '$IdCombo' ORDER BY a.P_NOMBRE"	;
		$Resultado = mysqli_query($db, $Detalle);
		$Cont = 1;
		while($row = mysqli_fetch_array($Resultado))
		{
			$Codigo = $row["P_CODIGO"];
			?>
			<tr>
			    	<td><?php echo $Cont?></td>               
			    	<td><input class="form-control" type="text" value="<?php echo $row["P_NOMBRE"]?>"/></td> 
			    	<td><input class="form-control" type="number" step="any" name="Precio[]" id="Precio[]" readonly /></td>
			    	<td><input class="form-control" type="text" step="any" name="PrecioReal[]" id="PrecioReal[]" value="<?php echo $row["P_PRECIO"]?>"/></td>
			    	<td><input class="form-control" type="text" step="any" name="Porcentaje[]" id="Porcentaje[]"/></td>
			    	<td><input class="form-control" type="text" value="<?php echo $row["P_NOMBRE"]?>"/></td>
			    	<td><input class="form-control" type="text" value="<?php echo $row["P_NOMBRE"]?>"/></td>
			    	<td><button type="button" class="btn btn-danger btn-xs">
							 <span class="glyphicon glyphicon-close">X</span>  
						</button>
				    </td>
			    </tr>
			    <?php 
			$Cont++;
		}
	?>									
	</tbody>
</table>
 <script type="text/javascript">
 	function Calcular()
		{

			var PrecioReal   = document.getElementsByName('PrecioReal[]'); 
			alert(PrecioReal);
			var Porcentaje   = document.getElementsByName('Porcentaje[]'); 
			var PrecioTotal  = document.getElementsByName('PrecioTotal'); 
			for(i = 1; i < PrecioReal.length; i++)
			{
				Porcent = parseFloat(PrecioReal[i].value) / parseFloat(PrecioTotal);
				Porcentaje[i].value = Porcent.toFixed(2); 
			}  
		}
 </script>