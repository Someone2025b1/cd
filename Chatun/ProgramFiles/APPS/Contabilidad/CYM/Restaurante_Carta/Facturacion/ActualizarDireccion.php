<?php
	include("../../../../../Script/conex.php");
	include("../../../../../Script/seguridad.php");
	$Mesa = $_POST["Mesa"];
	$Direccion = $_POST["Direccion"];

	$Query = mysqli_query($db, "UPDATE Bodega.MESA SET M_DIRECCION_FACTURA = '".$Direccion."' WHERE M_CODIGO = ".$Mesa);

	?>