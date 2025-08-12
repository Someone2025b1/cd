<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Codigo = $_POST[Codigo];

$QueryPrecio = mysqli_query($db, "SELECT A.M_PRECIO_UNITARIO
							FROM Bodega.MOBILIARIO AS A
							WHERE A.M_CODIGO = '".$Codigo."'");

$FilaPrecio = mysqli_fetch_array($QueryPrecio);

echo $FilaPrecio[M_PRECIO_UNITARIO];
?>