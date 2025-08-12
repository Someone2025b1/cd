<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Sql_CrearMesa = mysqli_query($db, "INSERT INTO Bodega.MESA(M_CODIGO)VALUES(NULL)")or die(mysqli_error());

if($Sql_CrearMesa)
{
	echo 1;
}
else
{
	echo 2;
}
?>
