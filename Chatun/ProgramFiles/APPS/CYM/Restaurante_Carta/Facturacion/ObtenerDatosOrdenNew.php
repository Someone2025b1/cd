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
		<?php

			if($Numero > 0)
			{
				?>
					<thead>
						<td colspan="4" align="center"><button type="button" class="btn btn-primary" onclick="window.location.reload()"><span class="glyphicon glyphicon-refresh"></span></button></td>
					</thead>
				<?php
			}
		?>
		<tbody>
	<?php

	$consulta = "SELECT A.*, B.P_NOMBRE, B.P_PRECIO_VENTA
				FROM Bodega.MESA_ORDEN AS A
				INNER JOIN Productos.PRODUCTO AS B ON A.RS_CODIGO = B.P_CODIGO
				WHERE A.M_CODIGO = ".$Mesa."
				AND A.MO_ESTADO = 1
				ORDER BY B.P_NOMBRE";
    $result = mysqli_query($db, $consulta);
	while($row = mysqli_fetch_array($result))
	{
		?>
		<tr>
			<td style="width: 20%"><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" value="<?php echo $row["MO_CANTIDAD"] ?>" data-codigo="<?php echo $row["MO_CODIGO"] ?>" onchange="CambiarTotal(this)"></td>
			<td><b><?php echo $row["P_NOMBRE"] ?></b></td>
			<td class="text-right" style="font-size: 12px" style="width: 30%"><?php echo 'Q '.number_format($row["P_PRECIO_VENTA"] * $row["MO_CANTIDAD"], 2) ?></td>
			<?php
				if($Numero > 0)
				{
					?>
						<td><a class="btn btn-flat ink-reaction text-danger" data-codigo="<?php echo $row["MO_CODIGO"] ?>" onclick="EliminarElemento(this)">
							<i class="fa fa-remove"></i>
						</a></td>
					<?php
				}
			?>
		</tr>
		<?php
		$Total = $Total + ($row["P_PRECIO_VENTA"] * $row["MO_CANTIDAD"]);
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
			<?php

				if($Numero > 0)
				{
					?>
						<tr>
							<td class="text-center"><a href="ImprimirOrdenNew.php?Mesa=<?php echo $Mesa ?>" target="_blank"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-print"></span></button></a></td>
							<td colspan="2" class="text-center"><a href="VtaNew.php?Mesa=<?php echo $Mesa ?>"><button type="button" class="btn btn-primary"><span class="md md-receipt"></span></button></a></td>
							<td class="text-center"><button type="button" class="btn btn-danger" value="<?php echo $Mesa ?>" onclick="DescartarOrden(this.value)"><span class="glyphicon glyphicon-remove-circle"></span></button></td>
						</tr>
					<?php
				}
			?>
		</tfoot>
	</table>