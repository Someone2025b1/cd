<?php
include("../../../../../Script/conex.php");

	$consulta = "SELECT pass_descuentos FROM info_bbdd.usuarios WHERE id_user = '".$_POST["user"]."'";
    $result = mysqli_query($db, $consulta);
	while($fila = mysqli_fetch_array($result))
	{
		$Pass = $fila["pass_descuentos"];
	}

	if($Pass == $_POST["id"] AND $_POST["id"]!="")
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>
