<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Sql_Codigo = mysqli_query($db,"UPDATE Contabilidad.ACTIVO_FIJO SET AF_NUEVO_CODIGO = '".$_POST["CodigoNuevoActivo"]."' WHERE AF_CODIGO = '".$_POST["CodigoActivo"]."'")or die(mysqli_error());

if($Sql_Codigo)
{
	echo 1;
}
else
{
	echo 0;
}



?>