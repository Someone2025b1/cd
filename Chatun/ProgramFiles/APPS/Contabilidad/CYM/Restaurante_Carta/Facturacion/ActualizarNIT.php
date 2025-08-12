<?php
	include("../../../../../Script/conex.php");
	include("../../../../../Script/seguridad.php");
	$Mesa = $_POST["Mesa"];
	$NIT = $_POST["NIT"];

	$Query = mysqli_query($db, "UPDATE Bodega.MESA SET M_NIT_FACTURA = '".$NIT."' WHERE M_CODIGO = ".$Mesa);

	?>