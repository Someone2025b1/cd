<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Codigo = $_POST[Codigo];
$Descripcion = $_POST[Descripcion];

$QueryPrecio = mysqli_query($db, "UPDATE Bodega.DEGUSTACION SET D_ESTADO = 3, D_DESCRIPCION = '".$Descripcion."' WHERE D_REFERENCIA = '".$Codigo."'");

if($QueryPrecio)
{
	echo 1;
}
else
{
	echo 0;
}

?>