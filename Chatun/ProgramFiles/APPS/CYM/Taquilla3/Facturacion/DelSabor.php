<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

	$Fila = $_POST["Fila"];


	$Query = mysqli_query($db, "DELETE FROM Bodega.TEMPORAL_SABORES WHERE TS_FILA = $Fila");

?>