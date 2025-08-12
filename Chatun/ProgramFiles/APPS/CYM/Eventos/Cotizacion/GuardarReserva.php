<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Monto  = $_POST[MontoReserva];
$Codigo = $_POST[Codigo];

$Query = mysqli_query($db, "UPDATE Bodega.COTIZACION SET C_RESERVA_MONTO = ".$Monto.", C_ESTADO = 4 WHERE C_CODIGO = ".$Codigo);

if($Query)
{
	echo 1;
}
else
{
	echo 0;
}

?>