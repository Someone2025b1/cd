<?php
include("../../../../../Script/conex.php");

	$consulta = "SELECT RES_NUMERO FROM Bodega.RESOLUCION WHERE RES_NUMERO = '".$_POST["id"]."'";
    $result = mysqli_query($db, $consulta);
	$numero = mysqli_num_rows($result); // obtenemos el número de filas

    echo $numero;
?>
