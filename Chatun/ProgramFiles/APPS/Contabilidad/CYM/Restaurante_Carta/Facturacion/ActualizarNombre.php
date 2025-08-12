<?php
	include("../../../../../Script/conex.php");
	include("../../../../../Script/seguridad.php");
	$Mesa = $_POST["Mesa"];
	$Nombre = $_POST["Nombre"];

	$Query = mysqli_query($db, "UPDATE Bodega.MESA SET M_NOMBRE_FACTURA = '".$Nombre."' WHERE M_CODIGO = ".$Mesa);

	?>