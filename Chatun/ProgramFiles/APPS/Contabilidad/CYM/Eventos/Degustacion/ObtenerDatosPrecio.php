<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Codigo = $_POST[Codigo];

$QueryPrecio = mysqli_query($db, "SELECT A.RS_PRECIO
							FROM Bodega.RECETA_SUBRECETA AS A
							WHERE A.RS_CODIGO = '".$Codigo."'");

$FilaPrecio = mysqli_fetch_array($QueryPrecio);

echo $FilaPrecio[RS_PRECIO];
?>