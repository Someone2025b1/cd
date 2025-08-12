<?php
include ("../../../Script/conex.php");

	$consulta = "SELECT cif FROM info_colaboradores.datos_generales WHERE cif = ".$_POST["id"];
    $result = mysqli_query($db, $consulta);
	$numero = mysqli_num_rows($result); // obtenemos el número de filas

    echo $numero;
?>
