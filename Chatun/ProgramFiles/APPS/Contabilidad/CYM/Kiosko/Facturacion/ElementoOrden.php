<?php
include("../../../../../Script/conex.php");
include("../../../../../Script/seguridad.php");

	$Producto = $_POST["Producto"];
	$Mesa = $_POST["Mesa"];
	$TipoOrden = $_POST["TipoOrden"];

	$Upd_Mesa = mysqli_query($db, "UPDATE Bodega.MESA_CA SET M_CIF_ATIENDE = ".$_SESSION["iduser"].", ME_CODIGO = 2, M_TIPO_ORDEN = ".$TipoOrden." WHERE M_CODIGO = ".$Mesa);

	$Orden = mysqli_query($db, "INSERT INTO Bodega.MESA_ORDEN_CA(MO_CODIGO, M_CODIGO, RS_CODIGO)VALUES('".uniqid()."', ".$Mesa.", '".$Producto."')")or die(mysqli_error());

	if($Orden)
	{
		echo 1;
	}
	else
	{
		echo 2;
	}
?>