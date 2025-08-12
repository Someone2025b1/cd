<?php
include("../../../../../Script/conex.php");

	$consulta = "SELECT P_NIT FROM Contabilidad.PROVEEDOR WHERE P_NIT = '".$_POST["NIT"]."'";
    $result = mysqli_query($db, $consulta);
	$numero = mysqli_num_rows($result); // obtenemos el número de filas
	
	echo $numero;
    
?>
