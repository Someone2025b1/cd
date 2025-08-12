<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Codigo = $_POST[Codigo];

$Query = mysqli_query($db, "DELETE FROM Bodega.FOTOGRAFIA_TIPO_MONTAJE WHERE FTM_CODIGO = ".$Codigo);

if($Query)
{
	echo 1;
}
else
{
	echo 0;
}

?>
