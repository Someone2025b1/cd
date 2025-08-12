<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Orden = $_POST['Orden'];


$Query = mysqli_query($db,"UPDATE Bodega.FACTURA SET F_REALIZADA = 1 WHERE F_CODIGO = '".$Orden."'");


$Query2 = mysqli_query($db,"UPDATE Bodega.FACTURA_2 SET F_REALIZADA = 1 WHERE F_CODIGO = '".$Orden."'");

?>