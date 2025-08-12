<?php
include("../../../../../Script/conex.php");

	$consulta = "SELECT * FROM Bodega.RECETA_SUBRECETA WHERE CM_CODIGO = '".$_POST["id"]."'";
    $result = mysqli_query($db, $consulta);
	while($row = mysqli_fetch_array($result))
	{
		?>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-center text-xl">
						<a style="text-decoration: none; cursor: pointer" onclick="AgregarProducto(this)" dataProducto="<?php echo $row["RS_CODIGO"]; ?>" dataNombre="<?php echo $row["RS_NOMBRE"]; ?>" dataPrecio="<?php echo $row["RS_PRECIO"]; ?>"><div><?php echo $row["RS_NOMBRE"] ?></div></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
?>
