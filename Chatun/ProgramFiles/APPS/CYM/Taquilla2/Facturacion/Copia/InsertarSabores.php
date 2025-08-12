<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");


	$Codigo = $_POST["Codigo"];
	$Fila = $_POST["Fila"];


	$Query = mysqli_query($db, "INSERT INTO Bodega.TEMPORAL_SABORES (TS_FILA, TS_CODIGO_PRODUCTO) 
							VALUES ($Fila, $Codigo)");

?>