<?php
	include("../../../../../Script/conex.php");
	$Codigo = $_POST["Codigo"];

	$Sql = mysqli_query($db, "DELETE FROM Bodega.MESA_ORDEN WHERE MO_CODIGO = '".$Codigo."'");
?>