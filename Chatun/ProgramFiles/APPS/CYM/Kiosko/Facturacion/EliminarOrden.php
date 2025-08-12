<?php
include("../../../../../Script/conex.php");

	$Mesa = $_POST["Mesa"];

	$query = mysqli_query($db, "DELETE FROM Bodega.MESA_ORDEN_CA WHERE M_CODIGO = ".$Mesa);
	
	$Query2 = mysqli_query($db, "UPDATE Bodega.MESA_CA SET ME_CODIGO = 1, M_CIF_ATIENDE = NULL, M_TIPO_ORDEN = NULL, M_NOMBRE_FACTURA = NULL, M_NIT_FACTURA = NULL, M_DIRECCION_FACTURA = NULL WHERE M_CODIGO = ".$Mesa);

	if($query && $Query2)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>
