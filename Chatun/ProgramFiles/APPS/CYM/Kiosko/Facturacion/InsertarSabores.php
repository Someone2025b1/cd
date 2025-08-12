<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");


	$Codigo = $_POST["Codigo"];
	$Mesa = $_POST["Mesa"];
	$id_user = $_SESSION["iduser"];



	$Query = mysqli_query($db, "INSERT INTO Bodega.MESA_BOLAS (MO_CODIGO, M_CODIGO, MO_CANTIDAD, P_CODIGO, MO_ESTADO) 
							VALUES ($Mesa, $Mesa, 1, $Codigo, 1)");

?>