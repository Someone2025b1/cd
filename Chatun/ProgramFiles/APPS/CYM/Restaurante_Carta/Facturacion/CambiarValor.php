<?php
	include("../../../../../Script/conex.php");
	$Valor = $_POST["Valor"];
	$Codigo = $_POST["Codigo"];

	if($Valor <= 0)
	{
		$Valor = 1;
	}

	$Sql = mysqli_query($db, "UPDATE Bodega.MESA_ORDEN SET MO_CANTIDAD = ".$Valor." WHERE MO_CODIGO = '".$Codigo."'");
?>