<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Sql_Codigo = mysqli_query($db,"SELECT A.AF_NUEVO_CODIGO
FROM Contabilidad.ACTIVO_FIJO AS A
WHERE A.AF_CODIGO = '".$_POST["CodigoActivo"]."'");

$Fila = mysqli_fetch_array($Sql_Codigo);

echo $Fila["AF_NUEVO_CODIGO"];


?>