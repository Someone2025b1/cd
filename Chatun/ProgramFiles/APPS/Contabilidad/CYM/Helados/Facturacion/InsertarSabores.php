<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");


	$Codigo = $_POST["Codigo"];
	$Fila = $_POST["Fila"];
	$id_user = $_SESSION["iduser"];



	$Query = mysqli_query($db, "INSERT INTO Bodega.TEMPORAL_SABORES (TS_FILA, TS_CODIGO_PRODUCTO, TS_CODIGO_USUARIO) 
							VALUES ($Fila, $Codigo, $id_user)");

?>