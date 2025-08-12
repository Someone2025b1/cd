<?php
include("../../../../../Script/conex.php");

	if ($_POST["id"]==1) 
	{  
		$consulta = "SELECT * FROM Bodega.PRODUCTO WHERE CP_CODIGO = 'JG'";
	    $result = mysqli_query($db, $consulta);
		while($row = mysqli_fetch_array($result))
		{
			?>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12 text-center">
							<a style="text-decoration: none; cursor: pointer" onclick="AgregarProducto(this)" dataProducto="<?php echo $row["P_CODIGO"]; ?>" dataNombre="<?php echo $row["P_NOMBRE"]; ?>" dataPrecio="<?php echo $row["P_PRECIO"]; ?>" dataTipo="1"><div><?php echo $row["P_NOMBRE"] ?></div></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
	elseif ($_POST["id"]==2) 
	{  
		$consulta = "SELECT C_Nombre, C_Precio, C_Id FROM Bodega.COMBO WHERE C_Estado = 1 ";
	    $result = mysqli_query($db, $consulta);
		while($row = mysqli_fetch_array($result))
		{
			?>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12 text-center">
							<a style="text-decoration: none; cursor: pointer" onclick="AgregarProducto(this)" dataProducto="<?php echo $row["C_Id"]; ?>" dataNombre="<?php echo $row["C_Nombre"]; ?>" dataPrecio="<?php echo $row["C_Precio"]; ?>" dataTipo="2"><div><?php echo $row["C_Nombre"] ?></div></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
	elseif ($_POST["id"]==3) 
	{  
		$consulta = "SELECT  a.Precio, a.Cantidad, b.P_NOMBRE, a.IdEscala FROM Bodega.ESCALA_PRODUCTO a
		INNER JOIN Bodega.PRODUCTO  b ON a.P_CODIGO = b.P_CODIGO
		WHERE Estado = 1";
	    $result = mysqli_query($db, $consulta);
		while($row = mysqli_fetch_array($result))
		{
			?>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12 text-center">
							<a style="text-decoration: none; cursor: pointer" onclick="AgregarProducto(this)" dataProducto="<?php echo $row["IdEscala"]; ?>" dataNombre="<?php echo $row["P_NOMBRE"]; ?>" dataPrecio="<?php echo $row["Precio"]; ?>" dataCant="<?php echo $row["Cantidad"]; ?>" dataTipo="3"><div><?php echo $row["Cantidad"]." * ".$row["Precio"]." ".$row["P_NOMBRE"] ?></div></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
?>
