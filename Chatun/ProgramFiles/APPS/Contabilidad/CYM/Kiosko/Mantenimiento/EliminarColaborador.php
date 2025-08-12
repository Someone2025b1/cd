<?php
	include("../../../../../Script/conex.php");
	$CIF = $_POST["CIF"];

	$Sql = mysqli_query($db, "DELETE FROM Bodega.COLABORADOR_FACTURA WHERE CF_CIF = ".$CIF)or die(mysqli_error());

	if($Sql)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>