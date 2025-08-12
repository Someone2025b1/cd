<?php
include("../../../../../Script/conex.php");

	$consulta = "SELECT * FROM Bodega.PRODUCTO WHERE  CP_CODIGO = 'JG' ORDER BY P_NOMBRE";
    $result = mysqli_query($db, $consulta);
	while($row = mysqli_fetch_array($result))
	{
		?>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-center">
						<a style="text-decoration: none; cursor: pointer" onclick="AgregarProducto(this)" dataProducto="<?php echo $row["P_CODIGO"]; ?>" dataNombre="<?php echo $row["P_NOMBRE"]; ?>" dataPrecio="<?php echo $row["P_PRECIO"]; ?>"><div><?php echo $row["P_NOMBRE"] ?></div></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
?>
