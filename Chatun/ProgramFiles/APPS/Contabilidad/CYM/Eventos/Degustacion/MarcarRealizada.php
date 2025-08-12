<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$CodigoDegustacion = $_POST[CodigoDegustacion];
$Descripcion = $_POST[Descripcion];
$CodigoCotizacion = $_POST[CodigoCotizacion];

$QueryPrecio = mysqli_query($db, "UPDATE Bodega.DEGUSTACION SET D_ESTADO = 2, D_DESCRIPCION = '".$Descripcion."' WHERE D_REFERENCIA = '".$Codigo."'");

if($QueryPrecio)
{
	$QueryCotizacion = mysqli_query($db, "UPDATE Bodega.COTIZACION SET D_CODIGO = '".$CodigoDegustacion."' WHERE C_CODIGO = ".$CodigoCotizacion);

	if($QueryCotizacion)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
else
{
	echo 0;
}

?>