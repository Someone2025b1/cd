<?php
include("../../../../../Script/conex.php");

	$consulta = "SELECT * FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO = '".$_POST["id"]."'";
    $result = mysqli_query($db, $consulta);
	$numero = mysqli_num_rows($result); // obtenemos el número de filas

		echo $numero;
    
?>
