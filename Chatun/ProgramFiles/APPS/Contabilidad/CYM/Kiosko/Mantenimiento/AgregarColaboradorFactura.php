<?php
	include("../../../../../Script/conex.php");
	$Colaborador = $_POST["Colaborador"];
	
	$Sql = mysqli_query($db, "INSERT INTO Bodega.COLABORADOR_FACTURA(CF_CIF)VALUES(".$Colaborador.")")or die(mysqli_error());

	if($Sql)
	{
		echo 1;
	}
	else
	{
		echo 2;
	}
?>