<?php
	include("../../../../../Script/conex.php");
	include("../../../../../Script/seguridad.php");
	$Mesa = $_POST["Mesa"];
	$Total = 0;

	$Query = mysqli_query($db, "SELECT * FROM Bodega.COLABORADOR_FACTURA WHERE CF_CIF = ".$_SESSION["iduser"]);
	$Numero = mysqli_num_rows($Query);

	?>
	<input type="hidden" id="NumeroColaboradorFactura" value="<?php echo $Numero ?>">
	<table class="table"> 
		<thead>
			<td colspan="4" align="center"><button type="button" class="btn btn-primary" onclick="window.location.reload()"><span class="glyphicon glyphicon-refresh"></span></button></td>
		</thead>  
		<tbody>
	<?php

	$consulta = "SELECT A.*, B.RS_NOMBRE, C.CM_NOMBRE, B.RS_PRECIO, A.MO_IMPRESO
				FROM Bodega.MESA_ORDEN_CA AS A
				INNER JOIN Bodega.RECETA_SUBRECETA AS B ON A.RS_CODIGO = B.RS_CODIGO
				INNER JOIN Bodega.CATEGORIA_MENU AS C ON B.CM_CODIGO = C.CM_CODIGO
				WHERE A.M_CODIGO = ".$Mesa."
				AND A.MO_ESTADO = 1
				ORDER BY C.CM_NOMBRE";
    $result = mysqli_query($db, $consulta);
	while($row = mysqli_fetch_array($result))
	{
		$Impreso = $row["MO_IMPRESO"];
		?>
		<tr>
			<td style="width: 20%"><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" value="<?php echo $row["MO_CANTIDAD"] ?>" data-codigo="<?php echo $row["MO_CODIGO"] ?>" onchange="CambiarTotal(this)"></td>
			<td><b><?php echo $row["RS_NOMBRE"] ?></b><small>(<?php echo $row["CM_NOMBRE"] ?></small>)</td>
			<td class="text-right" style="font-size: 12px" style="width: 30%"><?php echo 'Q '.number_format($row["RS_PRECIO"] * $row["MO_CANTIDAD"], 2) ?></td>
						<td><a class="btn btn-flat ink-reaction text-danger" data-codigo="<?php echo $row["MO_CODIGO"] ?>" onclick="EliminarElemento(this, '<?php echo $Impreso ?>')">
							<i class="fa fa-remove"></i>
						</a></td> 
		</tr>
		<?php
		$Total = $Total + ($row["RS_PRECIO"] * $row["MO_CANTIDAD"]);
	}
?>
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td class="text-right"><b>TOTAL</b></td>
				<td class="text-right" style="font-size: 12px" style="width: 30%">Q. <?php echo number_format($Total, 2); ?></td>
				<td></td>
			</tr> 
			<tr>
				<td class="text-center"><a href="ImprimirOrden.php?Mesa=<?php echo $Mesa ?>" target="_blank"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-print"></span></button></a></td>
				<td colspan="2" class="text-center"><a href="Vta.php?Mesa=<?php echo $Mesa ?>"><button type="button" class="btn btn-primary"><span class="md md-receipt"></span></button></a></td>
				<td class="text-center"><button type="button" class="btn btn-danger" value="<?php echo $Mesa ?>" onclick="DescartarOrden(this.value)"><span class="glyphicon glyphicon-remove-circle"></span></button></td>
			</tr> 
		</tfoot>
	</table>