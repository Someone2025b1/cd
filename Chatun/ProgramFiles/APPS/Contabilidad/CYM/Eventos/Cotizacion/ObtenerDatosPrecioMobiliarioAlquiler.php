<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Codigo = $_POST[Codigo];

$QueryPrecio = mysqli_query($db, "SELECT A.MA_PRECIO_UNITARIO
							FROM Bodega.MOBILIARIO_ALQUILER AS A
							WHERE A.MA_CODIGO = '".$Codigo."'");

$FilaPrecio = mysqli_fetch_array($QueryPrecio);

echo $FilaPrecio[MA_PRECIO_UNITARIO];
?>