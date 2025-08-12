<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Codigo = $_POST[Codigo];

$QueryPrecio = mysqli_query($db, "SELECT A.SE_PRECIO_UNITARIO
							FROM Bodega.SERVICIO_EVENTO AS A
							WHERE A.SE_CODIGO = '".$Codigo."'");

$FilaPrecio = mysqli_fetch_array($QueryPrecio);

echo $FilaPrecio[SE_PRECIO_UNITARIO];
?>