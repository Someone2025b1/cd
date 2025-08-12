<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Porcentaje = $_POST[Porcentaje];

$Query = mysqli_query($db, "UPDATE Bodega.PORCENTAJE_COMISION SET PC_PORCENTAJE = ".$Porcentaje." WHERE PC_CODIGO = 1");

if($Query)
{
	echo 1;
}
else
{
	echo 0;
}

?>