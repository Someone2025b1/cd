<?php
include("../../../../../Script/conex.php");

	if($_POST["id"]==999)
	{
		$consulta = "SELECT * FROM Bodega.RECETA_SUBRECETA 
WHERE RS_BODEGA = 'HS' AND RS_TIPO = 1 ORDER BY RS_NOMBRE";
		$result = mysqli_query($db,$consulta);
	}
	else
	{
		$consulta = "SELECT * FROM Bodega.RECETA_SUBRECETA WHERE CM_CODIGO = '".$_POST["id"]."'";
    	$result = mysqli_query($db,$consulta);
	}
	while($row = mysqli_fetch_array($result))
	{
		if($_POST["id"]==999)
		{
			$Id = $row["RS_CODIGO"];
			$Name = $row["RS_NOMBRE"];
			$Precio = $row["RS_PRECIO"];
			$TipoProd = 2;
		}
		else
		{
			$Id = $row["RS_CODIGO"];
			$Name = $row["RS_NOMBRE"];
			$Precio = $row["RS_PRECIO"];
			$TipoProd = 1;
		}

		?>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-center">
						<a style="text-decoration: none; cursor: pointer" onclick="AgregarProducto(this)" dataProducto="<?php echo $Id; ?>" dataNombre="<?php echo $Name; ?>" dataTipo ="<?php echo $TipoProd; ?>"  dataPrecio="<?php echo $Precio; ?>"><div><?php echo $Name ?></div></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
?>
