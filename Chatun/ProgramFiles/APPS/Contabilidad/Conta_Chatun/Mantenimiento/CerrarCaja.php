<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");

$Codigo = $_POST[Codigo];

$Query = mysqli_query($db, "UPDATE Bodega.APERTURA_CIERRE_CAJA SET ACC_ESTADO = 2 WHERE ACC_CODIGO = '".$Codigo."'");

if($Query)
{
	echo 1;
}
else
{
	echo 0;
}

?>